<?php

namespace App\Repositories;

use App\Models\Module;
use App\Models\Workspace;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Article;

class ModuleRepository
{
    /**
     * Retrieve all modules for the given workspace, with optional search filter.
     *
     * @param array $params
     * @param string $workspace_slug
     * @return array
     */
    public function getModules($params, $workspace_slug)
    {
        $search = $params['search'] ?? '';

        $workspace = Workspace::with(['updatedBy' => function ($q) {
                    $q->select('id', 'name');
                }])
                ->where('slug', $workspace_slug)
                ->first();

        if(!$workspace) {
            return false;
        }
        
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
        try {
            $workspace = Workspace::where('id', $params['workspace_id'])->first();
            if(!$workspace) {
                throw new \Exception(config('response_messages.workspace_not_found'));
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

            return true;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Update a module
     *
     * @param array $params The module data to update
     * @param int $module_id The ID of the module to update
     * @return \App\Models\Module The updated module
     * @throws \Exception
     */
    public function updateModule($params, $module_id)
    {
        try {
            $module = Module::find($module_id);
            if(!$module) {
                throw new \Exception(config('response_messages.module_not_found'));
            }

            $params['updated_by'] = Auth::id();
            $module->update($params);

            return $module;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }  
    
    /**
     * Update the order of the modules.
     *
     * @param array $params The array of module orders, each item containing 'id' and 'order' keys
     * @return boolean True if the update was successful, false if not
     * @throws \Exception If the update fails
     */
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
            throw new \Exception($e->getMessage());
        }
    }


    /**
     * Get the archived modules for the given workspace
     *
     * @param string $workspace_slug The slug of the workspace
     * @return array The array of archived modules
     */
    public function getAdminlandArchivedModules($params)
    {  
        $search = $params['search']??"";
        $modules = Module::with('workspace', 'updatedBy')
            ->where('status', 0)
            ->where(function ($query) use($search) {
                $query->where('title', 'LIKE', '%'.$search.'%')
                    ->orWhere('description', 'LIKE', '%'.$search.'%');
            })
            ->get()
            ->map(function($module) {
                return [
                    'id' => $module->id,
                    'title' => $module->title,
                    'slug' => $module->slug,
                    'workspace_id' => $module->workspace_id,
                    'workspace_slug' => $module->workspace->slug??"",
                    'updated_by' => $module->updatedBy->name,
                    'updated_at' => Carbon::parse($module->updated_at)->format('F d, Y')
                ];
            });
        
        return $modules;
    }



    public function updateModuleStatus(array $data, $module_id)
    {
        DB::beginTransaction();
        try {
            $module = Module::find($module_id);
            $module->status = $data['status'];
            $module->updated_by = Auth::id();
            $module->save();

            if($module){
                $module->articles()->update(['status' => $data['status']]);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }   
    } 


    /**
     * Delete a module and its associated articles.
     *
     * @param int $moduleId The ID of the module to delete
     * @return bool True if the deletion was successful
     * @throws \Exception If the module cannot be deleted
     */
    public function deleteModule($moduleId)
    {
        try {
            $module = Module::findOrFail($moduleId);

            DB::beginTransaction();

            Article::where('module_id', $moduleId)->delete();
            
            $module->delete();
            
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }


    /**
     * Retrieve an archived module by its workspace slug and module slug.
     *
     * @param string $workspaceSlug The slug of the workspace to which the module belongs.
     * @param string $moduleSlug The slug of the module to retrieve.
     * @return \App\Models\Module|null The archived module if found, otherwise null.
     */
    public function getArchivedModule($workspaceSlug, $moduleSlug)
    {   
        $module = Module::with('workspace:id,title,slug','articles:id,slug,module_id','updatedBy:id,name')
                        ->whereHas('workspace', function ($q) use ($workspaceSlug) {
                            $q->where('slug', $workspaceSlug);
                        })
                        ->where('status', 0)
                        ->where('slug', $moduleSlug)
                        ->first();
        
        return $module;
    }
} 
