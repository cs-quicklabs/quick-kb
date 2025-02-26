<?php

namespace App\Repositories;

use App\Models\Module;
use App\Helpers\StringHelper;
use App\Models\Workspace;
class ModuleRepository
{
    public function getModules($params, $workspace_slug)
    {
        $search = $params['search'] ?? '';

        $workspace = Workspace::where('slug', $workspace_slug)->first();

        $modules = Module::where('modules.status', 1)
                ->where('modules.workspace_id', $workspace->id??0)
                ->where('modules.title', 'like', '%'.$search.'%')
                ->orWhere('modules.description', 'like', '%'.$search.'%')
                ->orderBy('modules.order', 'asc')
                ->get()
                ->map(function($module) {
                    return [
                        'id' => $module->id,
                        'title' => $module->title,
                        'slug' => $module->slug,
                        'description' => $module->description,
                        'shortTitle' => StringHelper::getShortTitle($module->title, 150, '...'),
                        'created_at' => $module->created_at,
                        'updated_at' => $module->updated_at
                    ];
                })->toArray();

        $moduleCount = count($modules);
        return [
            'modules' => $modules,
            'moduleCount' => $moduleCount,
            'workspace' => $workspace
        ];
    }
} 