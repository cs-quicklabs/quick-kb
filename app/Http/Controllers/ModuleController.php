<?php

namespace App\Http\Controllers;

use App\Repositories\ModuleRepository;
use Illuminate\Http\Request;    
use App\Http\Requests\CreateModuleRequest;
use Illuminate\Http\JsonResponse;

class ModuleController extends Controller
{
    protected $moduleRepository;

    public function __construct(ModuleRepository $moduleRepository)
    {
        $this->moduleRepository = $moduleRepository;
    }

    public function modules(Request $request, $workspace_slug)
    {
        $modulesData = $this->moduleRepository->getModules($request->all(), $workspace_slug);
        
        return view('modules.modules', [
            'modules' => $modulesData['modules'],
            'workspace' => $modulesData['workspace'],
            'moduleCount' => $modulesData['moduleCount']
        ]);
    }


    public function createModule(CreateModuleRequest $request)
    {
        try {
            
            $module = $this->moduleRepository->createModule($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Module created successfully',
                'data' => $module
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create module',
                'errors' => ['general' => [$e->getMessage()]]
            ], 500);
        }
    }

    public function updateModule(Request $request, $module_id)
    {
        try {
            $module = $this->moduleRepository->updateModule($request->all(), $module_id);

            return response()->json([
                'success' => true,
                'message' => 'Module updated successfully',
                'data' => $module
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update module',
                'errors' => ['general' => [$e->getMessage()]]
            ], 500);
        }
    }

    public function updateModuleOrder(Request $request)
    {
        try {
            $this->moduleRepository->updateModuleOrder($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Module order updated successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update module order',
                'errors' => ['general' => [$e->getMessage()]]
            ], 500);
        }
    }
} 
