<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorkspaceRequest;
use App\Repositories\WorkspaceRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateWorkspaceRequest;


class WorkspaceController extends Controller
{
    protected $workspaceRepository;

    public function __construct(WorkspaceRepository $workspaceRepository)
    {
        $this->workspaceRepository = $workspaceRepository;
    }

    /**
     * Store a newly created workspace in storage.
     */
    public function createWorkspace(StoreWorkspaceRequest $request): JsonResponse
    {
        try {
            $workspace = $this->workspaceRepository->createWorkspace($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Workspace created successfully',
                'data' => $workspace
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create workspace',
                'errors' => ['general' => [$e->getMessage()]]
            ], 500);
        }
    }

    public function workspaces(Request $request)
    {
        $workspaces = $this->workspaceRepository->getAllWorkspaces($request->all());
        
        return view('workspaces.workspaces', compact('workspaces'));
    }

    public function updateWorkspace(UpdateWorkspaceRequest $request, $workspace_id)
    {
        try {
            $workspace = $this->workspaceRepository->updateWorkspace($request->all(), $workspace_id);

            return response()->json([
                'success' => true,
                'message' => 'Workspace updated successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update workspace',
                'errors' => ['general' => [$e->getMessage()]]
            ], 500);
        }
    }

    public function updateWorkspaceStatus(Request $request, $workspace_id)
    {
        try {
            $workspace = $this->workspaceRepository->updateWorkspaceStatus($request->all(), $workspace_id);

            return response()->json([
                'success' => true,
                'message' => 'Workspace status updated successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update workspace status',
                'errors' => ['general' => [$e->getMessage()]]
            ], 500);
        }
    }

    public function updateWorkspaceOrder(Request $request)
    {
        try {
            $this->workspaceRepository->updateWorkspaceOrder($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Workspace positions updated successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update workspace positions',
                'errors' => ['general' => [$e->getMessage()]]
            ], 500);    
        }
    }


    public function archivedWorkspaces()
    {
        $workspaces = $this->workspaceRepository->getArchivedWorkspaces();

        return view('adminland.archivedworkspace', compact('workspaces'));
    }



    public function searchContent(Request $request) {

        try {
            $searchResults = $this->workspaceRepository->searchContent($request->all());

            return response()->json([
                'success' => true,
                'data' => $searchResults
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to search content.',
                'errors' => ['general' => [$e->getMessage()]]
            ], 500);    
        }
    }
}
