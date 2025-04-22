<?php

namespace App\Repositories;

use App\Models\Workspace;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Module;
use App\Models\Article;


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
                'status' => config('constants.WORKSPACE_ACTIVE_STATUS'), // Active by default
                'created_by' => Auth::id()
            ];

            // Create the workspace
            $workspace = Workspace::create($storeData);

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }


    /**
     * Retrieve all active workspaces.
     * 
     * @param array $params
     * @return array
     */
    public function getAllWorkspaces($params)
    {
        $workspaces = Workspace::where('status', config('constants.WORKSPACE_ACTIVE_STATUS'))
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

    /**
     * Update an existing workspace.
     *
     * @param array $data The update data to be saved.
     * @param int $workspace_id The ID of the workspace to be updated.
     * @return boolean True if the update was successful, false if not.
     * @throws \Exception If the update fails.
     */
    public function updateWorkspace(array $data, $workspace_id)
    {
        DB::beginTransaction();
        try {
            if(isset($data['title'])){
                $data['slug'] = Str::slug($data['title']).'-'.uniqid();
            }
            $data['updated_by'] = Auth::id();
            $workspace = Workspace::find($workspace_id);
            $workspace->update($data);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack(); 
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Update the status of an existing workspace.
     *
     * @param array $data The array containing the status value to be updated.
     * @param int $workspace_id The ID of the workspace to be updated.
     * @return boolean True if the update was successful, false if not.
     * @throws \Exception If the update fails.
     */
    public function updateWorkspaceStatus(array $data, $workspace_id)
    {
        DB::beginTransaction();
        try {
            $workspace = Workspace::find($workspace_id);
            $workspace->status = $data['status'];
            $workspace->updated_by = Auth::id();
            $workspace->save();

            if($workspace){
                $workspace->modules()->update([
                    'status' => $data['status'],
                    'updated_by' => Auth::user()->id,
                    'updated_at' => now()
                ]);

                $workspace->modules->each(function($module) use ($data) {
                    $module->articles()->update([
                        'status' => $data['status'],
                        'updated_by' => Auth::user()->id,
                        'updated_at' => now()
                    ]);
                });

            }
            DB::commit();
            return $workspace;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }   
    } 
    
    /**
     * Update the order of workspaces.
     *
     * @param array $data The array containing workspace order information with 'orders' as a key.
     * @return boolean True if the update was successful, false if not.
     * @throws \Exception If the update fails.
     */
    public function updateWorkspaceOrder(array $data)
    {
        DB::beginTransaction();
        try {
            foreach ($data['orders'] as $order) {
                $workspace = Workspace::find($order['id']);  
                $workspace->order = $order['order'] + 1;
                $workspace->updated_by = Auth::id();
                $workspace->save();
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {   
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }


    /**
     * Retrieve all archived workspaces for adminland with optional search filter.
     *
     * @param array $params The array containing search parameters.
     * @return array The list of archived workspaces with their details.
     */
    public function getAdminlandArchivedWorkspaces($params)
    {  
        $search = $params['search']??"";
        $workspaces = Workspace::with('updatedBy')
            ->where('status', config('constants.WORKSPACE_ARCHIVED_STATUS'))
            ->where(function ($query) use($search) {
                $query->where('title', 'LIKE', '%'.$search.'%')
                    ->orWhere('description', 'LIKE', '%'.$search.'%');
            })
            ->orderBy('updated_at', 'desc')
            ->get()
            ->map(function($workspace) {
                return [
                    'id' => $workspace->id,
                    'title' => $workspace->title,
                    'slug' => $workspace->slug,
                    'updated_by' => $workspace->updatedBy->name,
                    'updated_at' => Carbon::parse($workspace->updated_at)->format('F d, Y')
                ];
            });

        return $workspaces;
    }


    /**
     * Searches for content in the workspaces and modules.
     * 
     * @param array $params The array containing search parameters.
     * @return array The list of search results.
     */
    public function searchContent($params) {
        $searchResults = [];
        $search = $params['search'] ?? '';
        switch ($params['type']) {
            case 'workspaces':
                $searchResults = Workspace::searchWorkspaces($search)->pluck('formatted_data');
                break;
            case 'modules':
                $searchResults = Module::searchModules($search)->pluck('formatted_data');
                break;
            case 'articles':
                $searchResults = Article::searchArticles($search)->pluck('formatted_data');
                break;
        }
        
        return $searchResults;
        
    }



    /**
     * Deletes a workspace and all its associated modules and articles.
     *
     * @param int $workspaceId The ID of the workspace to be deleted.
     * @return boolean True if the delete was successful, false if not.
     * @throws \Exception If the delete fails.
     */
    public function deleteWorkspace($workspaceId)
    {
        try {
            $workspace = Workspace::findOrFail($workspaceId);

            DB::beginTransaction();

            Article::whereHas('module', function($query) use ($workspaceId) {
                $query->where('workspace_id', $workspaceId);
            })->delete();
            
            Module::where('workspace_id', $workspaceId)->delete();
            
            $workspace->delete();
            
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }


    /**
     * Retrieves an archived workspace.
     *
     * @param string $workspaceSlug The slug of the workspace to be retrieved.
     * @return \App\Models\Workspace The archived workspace.
     */
    public function getArchivedWorkspace($workspaceSlug)
    {   
        $workspace = Workspace::with('modules', 'updatedBy')
                        ->where('status', config('constants.WORKSPACE_ARCHIVED_STATUS'))
                        ->where('slug', $workspaceSlug)
                        ->first();
        if(!empty($workspace)){
            $workspace->archived_at = Carbon::parse($workspace->updated_at)->format('F d, Y');
        }
        
        return $workspace;
    }
} 