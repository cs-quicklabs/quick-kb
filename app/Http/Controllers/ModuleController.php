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
            return $this->sendSuccessResponse($module, config('response_messages.module_created'), config('statuscodes.success')); 

        } catch (\Exception $e) {
            return $this->sendErrorResponse(
                $e->getMessage(), 
                config('response_messages.failed_to_create_module'), 
                config('statuscodes.internal_server_error')
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

            return $this->sendSuccessResponse($module, config('response_messages.module_updated'), config('statuscodes.success'));

        } catch (\Exception $e) {
            return $this->sendErrorResponse(
                $e->getMessage(), 
                config('response_messages.failed_to_update_module'), 
                config('statuscodes.internal_server_error')
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

            return $this->sendSuccessResponse([], config('response_messages.module_order_updated'), config('statuscodes.success'));
        } catch (\Exception $e) {

            return $this->sendErrorResponse(
                $e->getMessage(), 
                config('response_messages.failed_to_update_module_order'), 
                config('statuscodes.internal_server_error')
            );
        }
    }
} 
