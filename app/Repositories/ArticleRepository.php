<?php

namespace App\Repositories;

use App\Models\Workspace;
use App\Models\Module;
use App\Models\Article;
class ArticleRepository
{
    public function getAllArticles($workspace_slug, $module_slug)
    {
        $workspace = Workspace::with(['modules' => function($query) use ($module_slug) {
                $query->where('slug', $module_slug);
            }])->where('slug', $workspace_slug)->first();
        

        $module = $workspace->modules->first();
        
        return [
            'workspace' => $workspace,
            'module' => $module
        ];
        
    }

    
    public function createArticle($data, $workspace_slug, $module_slug)
    {
        return true;
    }

} 