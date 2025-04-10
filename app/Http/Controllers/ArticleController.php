<?php

namespace App\Http\Controllers;

use App\Repositories\ArticleRepository;
use Illuminate\Http\Request;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Http\Controllers\BaseController;


class ArticleController extends BaseController
{
    protected $articleRepository;


    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $workspace_slug
     * @param  string  $module_slug
     * @return \Illuminate\Http\Response
     */
    public function articles(Request $request, $workspace_slug, $module_slug)
    {
        $articlesData = $this->articleRepository->getAllArticles($workspace_slug, $module_slug);
        
        if(!$articlesData) {
            return redirect()->route('workspaces.workspaces')->with('error', config('response_messages.workspace_not_found'));
        } else {
            extract($articlesData);
            return view('articles.articles', compact('workspace', 'module', 'articles'));
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $workspace_slug
     * @param  string  $module_slug
     * @return \Illuminate\Http\Response
     */
    public function addArticle(Request $request, $workspace_slug, $module_slug)
    {
        $module = $this->articleRepository->addArticle($request->all(), $workspace_slug, $module_slug);

        if(!$module) {
            return redirect()->route('workspaces.workspaces')->with('error', config('response_messages.module_not_found'));
        }
        return view('articles.addarticle', compact('module'));
    }


    
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreArticleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function storeArticle(StoreArticleRequest $request)
    {
        try {
            $article = $this->articleRepository->storeArticle($request->all());
            if($article){
                return $this->sendSuccessResponse($article, config('response_messages.article_created'), config('statuscodes.OK'));
            } else {
                return $this->sendErrorResponse([], config('response_messages.module_not_found'), config('statuscodes.BAD_REQUEST'));
            }
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), config('response_messages.failed_to_create_article'), config('statuscodes.BAD_REQUEST'));
        }
    }


    /**
     * Update the status of an article.
     *
     * @param \Illuminate\Http\Request $request The request object containing the status data.
     * @param int $workspace_id The ID of the workspace containing the article.
     * @return \Illuminate\Http\JsonResponse The JSON response indicating success or failure of the article status update.
     */
    public function updateArticleStatus(Request $request, $article_id)
    {
        try {
            $workspace = $this->articleRepository->updateArticleStatus($request->all(), $article_id);

            return $this->sendSuccessResponse($workspace, config('response_messages.article_status_updated'), config('statuscodes.OK'));
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), config('response_messages.failed_to_update_article_status'), config('statuscodes.BAD_REQUEST'));
        }
    }



    /**
     * Update the order of the articles.
     *
     * @param \Illuminate\Http\Request $request The request object containing the order data.
     * @return \Illuminate\Http\JsonResponse The JSON response indicating success or failure of the article order update.
     */

    public function updateArticleOrder(Request $request)
    {
        try {
            $this->articleRepository->updateArticleOrder($request->all());

            return $this->sendSuccessResponse([], config('response_messages.article_order_updated'), config('statuscodes.OK'));

        } catch (\Exception $e) {
            
            return $this->sendErrorResponse($e->getMessage(), config('response_messages.failed_to_update_article_order'), config('statuscodes.BAD_REQUEST'));
        }
    }


    /**
     * Get the article by its workspace slug, module slug, and article slug.
     *
     * @param \Illuminate\Http\Request $request The request object containing input data.
     * @param string $workspace_slug The slug of the workspace containing the module and article.
     * @param string $module_slug The slug of the module containing the article.
     * @param string $article_slug The slug of the article to be retrieved.
     * @return \Illuminate\Http\Response The view containing the article details, or redirect to the previous page with an error message if the article is not found.
     */
    public function articleDetails(Request $request, $workspace_slug, $module_slug, $article_slug)
    {
        $articleData = $this->articleRepository->articleDetails($workspace_slug, $module_slug, $article_slug);
        
        if(!$articleData) {
            return redirect()->back()->with('error', config('response_messages.article_not_found'));
        } else {
            return view('articles.articledetails', compact('articleData'));
        }
    }


    /**
     * Update an existing article.
     *
     * @param \App\Http\Requests\UpdateArticleRequest $request The request object containing validated data for updating the article.
     * @param int $article_id The ID of the article to be updated.
     * @return \Illuminate\Http\JsonResponse The JSON response indicating success or failure of the article update.
     */
    public function updateArticle(UpdateArticleRequest $request, $article_id){
        try {
            $article = $this->articleRepository->updateArticle($request->all(), $article_id);

            return $this->sendSuccessResponse($article, config('response_messages.article_updated'), config('statuscodes.OK'));
        } catch (\Exception $e) {

            return $this->sendErrorResponse(
                $e->getMessage(), 
                config('response_messages.failed_to_update_article'), 
                config('statuscodes.BAD_REQUEST')
            );
        }
    }


    /**
     * Returns a view with a list of all archived articles for adminland.
     * 
     * @param Request $request The request object containing input data.
     * @return \Illuminate\Http\Response The view containing the list of archived articles.
     */
    public function archivedArticles(Request $request)
    {
        $articles = $this->articleRepository->getAdminlandArchivedArticles($request->all());
        
        return view('adminland.archivedarticle', compact('articles'));
    }


    /**
     * Delete an article by its ID.
     *
     * @param int $articleId The ID of the article to be deleted.
     * @return \Illuminate\Http\JsonResponse The JSON response indicating success or failure of the delete operation.
     */
    public function deleteArticle($articleId)
    {
        try {
            $this->articleRepository->deleteArticle($articleId);

            return $this->sendSuccessResponse([], config('response_messages.article_deleted'), config('statuscodes.OK'));
        } catch (\Exception $e) {

            return $this->sendErrorResponse($e->getMessage(), config('response_messages.failed_to_delete_article'), config('statuscodes.BAD_REQUEST'));
        }
    }



    /**
     * Retrieve a specific archived article by workspace, module, and article slugs.
     *
     * @param string $workspaceSlug The slug of the workspace.
     * @param string $moduleSlug The slug of the module.
     * @param string $articleSlug The slug of the article.
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse The view containing the archived article or a redirect response if not found.
     */
    public function getArchivedArticle($workspaceSlug, $moduleSlug, $articleSlug)
    {
        $articleData = $this->articleRepository->getArchivedArticle($workspaceSlug, $moduleSlug, $articleSlug);
        
        if(!empty($articleData)){
            return view('articles.archivedarticle', compact('articleData'));
        } else {
            return redirect()->route('adminland.archivedarticles')->with('error', config('response_messages.article_not_found'));
        }
        
    }


    /**
     * Handle the request to like an article.
     *
     * @param \Illuminate\Http\Request $request The request object containing the article ID and rating data.
     * @return \Illuminate\Http\JsonResponse The JSON response indicating success or failure of the like operation.
     */
    public function articleLike(Request $request)
    {
        try {
            $article = $this->articleRepository->articleLike($request->all());

            return $this->sendSuccessResponse($article, config('response_messages.article_liked'), config('statuscodes.OK'));
        } catch (\Exception $e) {

            return $this->sendErrorResponse($e->getMessage(), config('response_messages.failed_to_like_article'), config('statuscodes.BAD_REQUEST'));
        }

    }
} 