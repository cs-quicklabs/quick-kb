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

    public function workspaces()
    {
        $workspaces = $this->workspaceRepository->getAllWorkspaces();
        
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
}
