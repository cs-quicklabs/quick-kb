<?php

namespace App\Repositories;

use App\Models\Module;
use App\Models\Workspace;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ModuleRepository
{
    public function getModules($params, $workspace_slug)
    {
        $search = $params['search'] ?? '';

        $workspace = Workspace::with(['updatedBy' => function ($q) {
                    $q->select('id', 'name');
                }])
                ->where('slug', $workspace_slug)
                ->first();

        if(!empty($workspace)){
            $workspace->shortTitle = getShortTitle($workspace->title, 20, '...');
        }
        
        $modules = Module::where('modules.status', 1)
                ->where('modules.workspace_id', $workspace->id??0)
                ->where(function($query) use ($search) {
                    $query->where('modules.title', 'like', '%'.$search.'%')
                          ->orWhere('modules.description', 'like', '%'.$search.'%');
                })
                ->orderBy('modules.order', 'asc')
                ->get()
                ->map(function($module) {
                    return [
                        'id' => $module->id,
                        'title' => $module->title,
                        'slug' => $module->slug,
                        'description' => $module->description,
                        'shortTitle' => getShortTitle($module->title, 150, '...'),
                        'created_at' => $module->created_at,
                        'updated_at' => $module->updated_at
                    ];
                })->toArray();
        

        $moduleCount = count($modules);
        return [
            'modules' => $modules,
            'moduleCount' => $moduleCount,
            'workspace' => $workspace
        ];
    }

    /**
     * Create a new module
     *
     * @param array $params The module data
     * @return \App\Models\Module The created module
     */
    public function createModule($params)
    {
        DB::beginTransaction();
        try {
            $workspace = Workspace::where('id', $params['workspace_id'])->first();
            if(!$workspace) {
                throw new \Exception('Workspace not found');
            }
            // Get the maximum order value
            $maxOrder = Module::where('workspace_id', $workspace->id)->max('order') ?? 0;
            $storeData = [
                'title' => $params['title'],
                'description' => $params['description'],
                'slug' => Str::slug($params['title']).'-'.uniqid(),
                'order' => $maxOrder + 1,
                'status' => 1, // Active by default
                'workspace_id' => $params['workspace_id'],
                'created_by' => Auth::id()
            ];

            // Create the module
            $module = Module::create($storeData);

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Failed to create module: ' . $e->getMessage());
        }
    }

    public function updateModule($params, $module_id)
    {
        DB::beginTransaction();
        try {
            $module = Module::find($module_id);
            if(!$module) {
                throw new \Exception('Module not found');
            }

            $params['updated_by'] = Auth::id();
            $module->update($params);

            DB::commit();
            return $module;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Failed to update module: ' . $e->getMessage());
        }
    }  
    
    public function updateModuleOrder($params)
    {
        DB::beginTransaction();
        try {
            foreach ($params['orders'] as $order) {
                $module = Module::find($order['id']);
                $module->order = $order['order'] + 1;
                $module->save();
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Failed to update module order: ' . $e->getMessage());
        }
    }

} 
