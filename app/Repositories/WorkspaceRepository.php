<?php

namespace App\Repositories;

use App\Models\Workspace;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Helpers\StringHelper;
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
                ->where('title', 'like', '%'.$search.'%')
                ->orWhere('description', 'like', '%'.$search.'%')
                ->orderBy('order', 'asc')
                ->get()
                ->map(function($workspace) {
                    return [
                        'id' => $workspace->id,
                        'title' => $workspace->title,
                        'slug' => $workspace->slug,
                        'description' => $workspace->description,
                        'shortTitle' => StringHelper::getShortTitle($workspace->title, 150, '...'),
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
            throw new \Exception('Failed to update workspace: ' . $e->getMessage());
        }
    }

    public function updateWorkspaceStatus(array $data, $workspace_id)
    {
        DB::beginTransaction();
        try {
            $workspace = Workspace::find($workspace_id);
            $workspace->status = $data['status'];
            $workspace->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Failed to update workspace status: ' . $e->getMessage());
        }   
    } 
    
    public function updateWorkspacePositions(array $data)
    {
        DB::beginTransaction();
        try {
            foreach ($data['positions'] as $position) {
                $workspace = Workspace::find($position['id']);  
                $workspace->order = $position['order'] + 1;
                $workspace->save();
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {   
            DB::rollBack();
            throw new \Exception('Failed to update workspace positions: ' . $e->getMessage());
        }
    }
} 