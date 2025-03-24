<?php

namespace App\Http\Controllers;

use App\Repositories\ModuleRepository;
use Illuminate\Http\Request;    
use App\Http\Requests\CreateModuleRequest;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\BaseController;

class ModuleController extends BaseController
{
    protected $moduleRepository;

    public function __construct(ModuleRepository $moduleRepository)
    {
        $this->moduleRepository = $moduleRepository;
    }

    /**
     * Shows the modules in a workspace
     *
     * @param Request $request
     * @param string $workspace_slug
     * @return \Illuminate\Http\Response
     */
    public function modules(Request $request, $workspace_slug)
    {
        $modulesData = $this->moduleRepository->getModules($request->all(), $workspace_slug);
        if($modulesData){
            return view('modules.modules', [
                'modules' => $modulesData['modules'],
                'workspace' => $modulesData['workspace'],
                'moduleCount' => $modulesData['moduleCount']
            ]);
        } else {
            return redirect()->route('workspaces.workspaces')->with('error', config('response_messages.workspace_not_found'));
        }
        
    }


    /**
     * Create a new module.
     *
     * @param CreateModuleRequest $request The request object containing module data.
     * @return \Illuminate\Http\JsonResponse The JSON response indicating success or failure of module creation.
     */

    public function createModule(CreateModuleRequest $request)
    {
        try {
            
            $module = $this->moduleRepository->createModule($request->all());
            return $this->sendSuccessResponse($module, config('response_messages.module_created'), config('statuscodes.OK')); 

        } catch (\Exception $e) {
            return $this->sendErrorResponse(
                $e->getMessage(), 
                config('response_messages.failed_to_create_module'), 
                config('statuscodes.BAD_REQUEST')
            );
        }
    }

    /**
     * Update a module.
     *
     * @param \Illuminate\Http\Request $request The request object containing module data.
     * @param int $module_id The ID of the module to update.
     * @return \Illuminate\Http\JsonResponse The JSON response indicating success or failure of module update.
     */
    public function updateModule(Request $request, $module_id)
    {
        try {
            $module = $this->moduleRepository->updateModule($request->all(), $module_id);

            return $this->sendSuccessResponse($module, config('response_messages.module_updated'), config('statuscodes.OK'));

        } catch (\Exception $e) {
            return $this->sendErrorResponse(
                $e->getMessage(), 
                config('response_messages.failed_to_update_module'), 
                config('statuscodes.BAD_REQUEST')
            );
        }
    }

    /**
     * Update the order of the modules.
     *
     * @param \Illuminate\Http\Request $request The request object containing the order data.
     * @return \Illuminate\Http\JsonResponse The JSON response indicating success or failure of module order update.
     */
    public function updateModuleOrder(Request $request)
    {
        try {
            $this->moduleRepository->updateModuleOrder($request->all());

            return $this->sendSuccessResponse([], config('response_messages.module_order_updated'), config('statuscodes.OK'));
        } catch (\Exception $e) {

            return $this->sendErrorResponse(
                $e->getMessage(), 
                config('response_messages.failed_to_update_module_order'), 
                config('statuscodes.BAD_REQUEST')
            );
        }
    }


    /**
     * Get the archived modules.
     *
     * @return \Illuminate\Http\Response The JSON response containing the archived modules.
     */
    public function archivedModules(Request $request)
    {
        $modules = $this->moduleRepository->getAdminlandArchivedModules($request->all());
        return view('adminland.archivedmodule', compact('modules'));
    }



    /**
     * Update the status of a module.
     *
     * @param \Illuminate\Http\Request $request The request object containing the status data.
     * @param int $module_id The ID of the module to update.
     * @return \Illuminate\Http\JsonResponse The JSON response indicating success or failure of the module status update.
     */
    public function updateModuleStatus(Request $request, $module_id)
    {
        try {
            $module = $this->moduleRepository->updateModuleStatus($request->all(), $module_id);

            return $this->sendSuccessResponse($module, config('response_messages.module_status_updated'), config('statuscodes.OK'));
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), config('response_messages.failed_to_update_module_status'), config('statuscodes.BAD_REQUEST'));
        }
    }



    /**
     * Delete a module by its ID.
     *
     * @param int $moduleId The ID of the module to be deleted.
     * @return \Illuminate\Http\JsonResponse The JSON response indicating success or failure of the delete operation.
     */
    public function deleteModule($moduleId)
    {
        try {
            // Call the repository method to delete the moduleId
            $this->moduleRepository->deleteModule($moduleId);

            return $this->sendSuccessResponse([], config('response_messages.module_deleted'), config('statuscodes.OK'));
        } catch (\Exception $e) {

            return $this->sendErrorResponse($e->getMessage(), config('response_messages.failed_to_delete_module'), config('statuscodes.BAD_REQUEST'));
        }
    }


    /**
     * Retrieve a specific archived module by workspace and module slugs.
     *
     * @param string $workspaceSlug The slug of the workspace.
     * @param string $moduleSlug The slug of the module.
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse The view containing the module or a redirect response if not found.
     */
    public function getArchivedModule($workspaceSlug, $moduleSlug)
    {
        $module = $this->moduleRepository->getArchivedModule($workspaceSlug, $moduleSlug);
        
        if(!empty($module)){
            return view('modules.archivedmodule', compact('module'));
        } else {
            return redirect()->route('adminland.archivedmodules')->with('error', config('response_messages.module_not_found'));
        }
        
    }

} 
