<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorkspaceRequest;
use App\Repositories\WorkspaceRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateWorkspaceRequest;
use App\Http\Controllers\BaseController;


class WorkspaceController extends BaseController
{
    protected $workspaceRepository;

    public function __construct(WorkspaceRepository $workspaceRepository)
    {
        $this->workspaceRepository = $workspaceRepository;
    }

    
    /**
     * Create a new workspace.
     *
     * @param StoreWorkspaceRequest $request The request object containing validated data for the new workspace.
     * @return JsonResponse The JSON response indicating success or failure of workspace creation.
     */
    public function createWorkspace(StoreWorkspaceRequest $request): JsonResponse
    {
        try {
            $workspace = $this->workspaceRepository->createWorkspace($request->validated());

            return $this->sendSuccessResponse($workspace, config('response_messages.workspace_created'), config('statuscodes.OK'));

        } catch (\Exception $e) {

            return $this->sendErrorResponse($e->getMessage(), config('response_messages.failed_to_create_workspace'), config('statuscodes.BAD_REQUEST')
            );
        }
    }

    /**
     * Return a view with a list of all workspaces.
     *
     * @param Request $request The request object containing input data.
     * @return \Illuminate\Http\Response The view containing the list of workspaces.
     */
    public function workspaces(Request $request)
    {
        $workspaces = $this->workspaceRepository->getAllWorkspaces($request->all());
        
        return view('workspaces.workspaces', compact('workspaces'));
    }

    /**
     * Update an existing workspace.
     *
     * @param UpdateWorkspaceRequest $request The request object containing validated data for updating the workspace.
     * @param int $workspace_id The ID of the workspace to be updated.
     * @return JsonResponse The JSON response indicating success or failure of the workspace update.
     */
    public function updateWorkspace(UpdateWorkspaceRequest $request, $workspace_id)
    {
        try {
            $workspace = $this->workspaceRepository->updateWorkspace($request->all(), $workspace_id);

            return $this->sendSuccessResponse( [], config('response_messages.workspace_updated'), config('statuscodes.OK'));
        } catch (\Exception $e) {

            return $this->sendErrorResponse($e->getMessage(), config('response_messages.failed_to_update_workspace'), config('statuscodes.BAD_REQUEST'));
        }
    }

    /**
     * Update the status of an existing workspace.
     *
     * @param Request $request The request object containing the status data.
     * @param int $workspace_id The ID of the workspace to be updated.
     * @return JsonResponse The JSON response indicating success or failure of the workspace status update.
     */
    public function updateWorkspaceStatus(Request $request, $workspace_id)
    {
        try {
            $workspace = $this->workspaceRepository->updateWorkspaceStatus($request->all(), $workspace_id);

            return $this->sendSuccessResponse($workspace, config('response_messages.workspace_status_updated'), config('statuscodes.OK'));
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), config('response_messages.failed_to_update_workspace_status'), config('statuscodes.BAD_REQUEST'));
        }
    }

    /**
     * Update the order of existing workspaces.
     *
     * @param Request $request The request object containing the order data.
     * @return JsonResponse The JSON response indicating success or failure of the workspace order update.
     */
    public function updateWorkspaceOrder(Request $request)
    {
        try {
            $this->workspaceRepository->updateWorkspaceOrder($request->all());

            return $this->sendSuccessResponse([], config('response_messages.workspace_order_updated'), config('statuscodes.OK'));

        } catch (\Exception $e) {
            
            return $this->sendErrorResponse($e->getMessage(), config('response_messages.failed_to_update_workspace_order'), config('statuscodes.BAD_REQUEST'));
        }
    }


    /**
     * Return a view with a list of all archived workspaces for adminland.
     *
     * @param Request $request The request object containing input data.
     * @return \Illuminate\Http\Response The view containing the list of archived workspaces.
     */
    public function archivedWorkspaces(Request $request)
    {
        $workspaces = $this->workspaceRepository->getAdminlandArchivedWorkspaces($request->all());

        return view('adminland.archivedworkspace', compact('workspaces'));
    }



    /**
     * Searches for content in the workspaces and modules.
     *
     * @param Request $request The request object containing search parameters.
     * @return JsonResponse The JSON response indicating success or failure of the search.
     */
    public function searchContent(Request $request) {

        try {
            $searchResults = $this->workspaceRepository->searchContent($request->all());

            return $this->sendSuccessResponse($searchResults, config('response_messages.search_results_retrieved'), config('statuscodes.OK'));
        } catch (\Exception $e) {
            
            return $this->sendErrorResponse($e->getMessage(), config('response_messages.failed_to_search_content'), config('statuscodes.BAD_REQUEST'));
        }
    }


    /**
     * Delete a workspace by its ID.
     *
     * @param int $workspaceId The ID of the workspace to be deleted.
     * @return \Illuminate\Http\JsonResponse The JSON response indicating success or failure of the delete operation.
     */
    public function deleteWorkspace($workspaceId)
    {
        try {
            // Call the repository method to delete the workspace
            $this->workspaceRepository->deleteWorkspace($workspaceId);

            return $this->sendSuccessResponse([], config('response_messages.workspace_deleted'), config('statuscodes.OK'));
        } catch (\Exception $e) {

            return $this->sendErrorResponse($e->getMessage(), config('response_messages.failed_to_delete_workspace'), config('statuscodes.BAD_REQUEST'));
        }
    }


    /**
     * Returns a view with a specific archived workspace.
     *
     * @param string $workspaceSlug The slug of the workspace to be displayed.
     * @return \Illuminate\Http\Response The view containing the archived workspace.
     */
    public function getArchivedWorkspace($workspaceSlug)
    {
        $workspace = $this->workspaceRepository->getArchivedWorkspace($workspaceSlug);
        if(!empty($workspace)){
            return view('workspaces.archivedworkspace', compact('workspace'));
        } else {
            return redirect()->route('adminland.archivedworkspaces')->with('error', config('response_messages.workspace_not_found'));
        }
        
    }
    
}
