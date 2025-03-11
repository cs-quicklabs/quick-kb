<?php

namespace App\Http\Controllers;

use App\Repositories\ArticleRepository;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    protected $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function articles(Request $request, $workspace_slug, $module_slug)
    {
        $articlesData = $this->articleRepository->getAllArticles($workspace_slug, $module_slug);
        
        return view('articles.articles', [
            'workspace' => $articlesData['workspace'],
            'module' => $articlesData['module']
        ]);
    }

    public function createArticle(Request $request, $workspace_slug, $module_slug)
    {
        $searchResults = $this->articleRepository->createArticle($request->all(), $workspace_slug, $module_slug);

        return view('articles.addarticle');
    }
} 