<?php

namespace App\Http\Controllers;

use App\Repositories\ModuleRepository;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    protected $moduleRepository;

    public function __construct(ModuleRepository $moduleRepository)
    {
        $this->moduleRepository = $moduleRepository;
    }

    public function modules(Request $request, $workspace_slug)
    {
        $params = $request->all();  
        $modulesData = $this->moduleRepository->getModules($params, $workspace_slug);

        return view('modules.modules', [
            'modules' => $modulesData['modules'],
            'workspace' => $modulesData['workspace'],
            'moduleCount' => $modulesData['moduleCount']
        ]);
    }
} 