<?php

namespace App\Repositories;

use App\Models\Workspace;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Module;

class WorkspaceRepository
{
    /**
     * Create a new workspace
     *
     * @param array $data
     * @return Workspace
     * @throws \Exception
     */
    public function createWorkspace(array $data)
    {
        DB::beginTransaction();
        try {
            // Get the maximum order value
            $maxOrder = Workspace::where('created_by', Auth::id())->max('order') ?? 0;
            $storeData = [
                'title' => $data['title'],
                'description' => $data['description'],
                'slug' => Str::slug($data['title']).'-'.uniqid(),
                'order' => $maxOrder + 1,
                'status' => 1, // Active by default
                'created_by' => Auth::id()
            ];

            // Create the workspace
            $workspace = Workspace::create($storeData);

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Failed to create workspace: ' . $e->getMessage());
        }
    }


    public function getAllWorkspaces($params)
    {
        
        $search = $params['search'] ?? '';
        $workspaces = Workspace::where('status', 1)
                ->where(function($query) use ($search) {
                    $query->where('title', 'like', '%'.$search.'%')
                          ->orWhere('description', 'like', '%'.$search.'%');
                })
                ->orderBy('order', 'asc')
                ->get()
                ->map(function($workspace) {
                    return [
                        'id' => $workspace->id,
                        'title' => $workspace->title,
                        'slug' => $workspace->slug,
                        'description' => $workspace->description,
                        'shortTitle' => getShortTitle($workspace->title, 150, '...'),
                        'created_at' => $workspace->created_at,
                        'updated_at' => $workspace->updated_at
                    ];
                })->toArray();

        $workspaceCount = count($workspaces);
        return [
            'workspaces' => $workspaces,
            'workspaceCount' => $workspaceCount
        ];
    }

    public function updateWorkspace(array $data, $workspace_id)
    {
        DB::beginTransaction();
        try {
            if(isset($data['title'])){
                $data['slug'] = Str::slug($data['title']).'-'.uniqid();
            }
            $workspace = Workspace::find($workspace_id);
            $workspace->update($data);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack(); 
            dd($e->getMessage());
            throw new \Exception('Failed to update workspace: ' . $e->getMessage());
        }
    }

    public function updateWorkspaceStatus(array $data, $workspace_id)
    {
        DB::beginTransaction();
        try {
            $workspace = Workspace::find($workspace_id);
            $workspace->status = $data['status'];
            $workspace->updated_by = Auth::id();
            $workspace->save();

            if($workspace){
                $workspace->modules()->update(['status' => $data['status']]);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Failed to update workspace status: ' . $e->getMessage());
        }   
    } 
    
    public function updateWorkspaceOrder(array $data)
    {
        DB::beginTransaction();
        try {
            foreach ($data['orders'] as $order) {
                $workspace = Workspace::find($order['id']);  
                $workspace->order = $order['order'] + 1;
                $workspace->save();
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {   
            DB::rollBack();
            throw new \Exception('Failed to update workspace positions: ' . $e->getMessage());
        }
    }


    public function getArchivedWorkspaces()
    {
        $workspaces = Workspace::with('updatedBy')
            ->where('status', 0)
            ->get()
            ->map(function($workspace) {
                return [
                    'id' => $workspace->id,
                    'title' => $workspace->title,
                    'updated_by' => $workspace->updatedBy->name,
                    'updated_at' => Carbon::parse($workspace->updated_at)->format('F d, Y')
                ];
            });

        return $workspaces;
    }


    public function searchContent($params) {
        $searchResults = [];
        $search = $params['search'] ?? '';

        if($params['type'] === 'workspaces'){
            $searchResults = Workspace::search($search)
                ->query(function ($query) {
                    $query->where('status', 1)
                        ->orderBy('order', 'asc');
                })
                ->get()
                ->map(function($list) {
                    return [
                        'id' => $list->id,
                        'title' => $list->title,
                        'slug' => $list->slug,
                        'description' => $list->description,
                        'shortTitle' => getShortTitle($list->title, 50, '...'),
                        'link' => route('modules.modules', [$list->slug])
                    ];
                })
                ->values();
        }

        if($params['type'] === 'modules'){
            $searchResults = Module::search($search)
            ->query(function ($query) {
                $query->where('status', 1)
                    ->orderBy('order', 'asc');
            })
            ->get()
            ->map(function($list) {
                return [
                    'id' => $list->id,
                    'title' => $list->title,
                    'slug' => $list->slug,
                    'description' => $list->description,
                    'shortTitle' => getShortTitle($list->title, 50, '...'),
                    'link' => route('articles.articles', [$list->workspace->slug??Null, $list->slug])
                ];
            })
            ->values();
        }
        return $searchResults;
        
    }
} 