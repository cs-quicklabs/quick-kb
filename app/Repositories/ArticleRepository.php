<?php

namespace App\Repositories;

use App\Models\Workspace;
use App\Models\Module;
use App\Models\Article;
use App\Models\ArticleRating;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;



class ArticleRepository
{
    /**
     * Retrieve all articles for the given workspace and module.
     * 
     * @param string $workspace_slug The slug of the workspace containing the module and articles.
     * @param string $module_slug The slug of the module containing the articles.
     * @return array The array containing the workspace, module, and articles.
     */
    public function getAllArticles($workspace_slug, $module_slug)
    {
        
        $workspace = Workspace::whereHas('modules', function($q) use ($module_slug) {
                    $q->where('slug', $module_slug)
                        ->where('status', 1);
                })
                ->with(
                [
                    'modules' => function($query) use ($module_slug) {
                        $query->where('slug', $module_slug);
                    },
                    'modules.articles' => function($query) {
                        if(!Auth::check()){
                            $query = $query->where('status', 1);
                        }
                        $query->where('status' , '!=' , 0)->orderBy('order', 'asc');
                    }
                ])
                ->where('slug', $workspace_slug)
                ->where('status', 1);
        
        
                
        $workspace = $workspace->first();
        
        if(!$workspace) {
            return false;
        }
        $module = $workspace->modules->first();
        $articles = $module->articles->map(function($article) {
                return [
                    'id' => $article->id,
                    'title' => $article->title,
                    'slug' => $article->slug,
                    //'content' => $article->content,
                    'content' => getCleanContent($article->content),
                    'status' => $article->status,
                    'created_at' => $article->created_at,
                    'updated_at' => $article->updated_at
                ];
            })
            ->toArray();
        
        return [
            'workspace' => $workspace,
            'module' => $module,
            'articles' => $articles
        ];
        
    }

    
    /**
     * Get the workspace and module for which an article is being added.
     *
     * @param array $data The article data containing 'title', 'content', and 'module_id'
     * @param string $workspace_slug The slug of the workspace containing the module
     * @param string $module_slug The slug of the module containing the article
     * @return \App\Models\Module The module for which an article is being added, or false if not found
     */
    public function addArticle($data, $workspace_slug, $module_slug)
    {
        $module = Module::with('workspace')
                ->where('slug', $module_slug)
                ->whereHas('workspace', function($q) use ($workspace_slug){
                    $q->where('slug', $workspace_slug);
                })->first();
        

        if(!$module) {
            return false;
        }   
        return $module;
    }


    /**
     * Store a new article.
     *
     * @param array $data The article data containing 'title', 'content', and 'module_id'
     * @return bool True if the article was successfully stored, otherwise false
     * @throws \Exception If the article cannot be stored
     */
    public function storeArticle($data)
    {
        try {
            $module = Module::where('id', $data['module_id'])->first();
            if(!$module) {
                return false;
            } 

            //Fetch images and replace them with urls...
            $data['content'] = $this->fetchImages($data['content']);

            // Get the maximum order value
            $maxOrder = Article::where('created_by', Auth::id())->max('order') ?? 0;
            $articleData = [
                'title' => $data['title'],
                'content' => $data['content'],
                'module_id' => $data['module_id'],
                'created_by' => Auth::user()->id,
                'slug' => Str::slug($data['title']).'-'.uniqid(),
                'order' => $maxOrder + 1,
                'status' =>  $data['status']??1,// Active by default
            ];
            $article = Article::create($articleData);
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }



    /**
     * Update the status of an article.
     *
     * @param array $data The article status data containing 'status'
     * @param int $article_id The ID of the article to be updated
     * @return bool True if the article status was successfully updated, otherwise false
     * @throws \Exception If the article status cannot be updated
     */
    public function updateArticleStatus(array $data, $article_id)
    {
        try {
            $article = Article::with('module', 'module.workspace')->where('id', $article_id)->first();
            
            if(!$article) {
                throw new \Exception(config('response_messages.article_not_found'));
            }
            
            if($data['status'] == 1) {
                if($article->module->workspace->status == 0 || $article->module->status == 0) {
                    throw new \Exception(config('response_messages.restore_module_first'));
                }
            }

            $article->status = $data['status'];
            $article->updated_by = Auth::id();
            $article->save();

            return $article;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }   
    } 



    /**
     * Update the order of the articles.
     *
     * @param array $data The array of article orders, each item containing 'id' and 'order' keys
     * @return boolean True if the update was successful, false if not
     * @throws \Exception If the update fails
     */
    public function updateArticleOrder(array $data)
    {
        DB::beginTransaction();
        try {
            foreach ($data['orders'] as $order) {
                $article = Article::find($order['id']);  
                $article->order = $order['order'] + 1;
                $article->save();
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {   
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }



    /**
     * Get the article by its workspace slug, module slug, and article slug.
     * 
     * @param string $workspace_slug The slug of the workspace containing the module
     * @param string $module_slug The slug of the module containing the article
     * @param string $article_slug The slug of the article to be retrieved
     * @return \App\Models\Article|false The article if found, otherwise false
     */
    public function articleDetails($workspace_slug, $module_slug, $article_slug)
    {
        $article = Article::with('module', 'module.workspace','createdBy')
                ->whereHas('module', function($q) use ($module_slug) {
                    $q->where('slug', $module_slug);
                })
                ->whereHas('module.workspace', function($q) use ($workspace_slug) {
                    $q->where('slug', $workspace_slug);
                })
                ->where('slug', $article_slug)
                ->first();
        
        if(!$article) {
            return false;
        }

        
        return $article;
    }


/**
 * Update an existing article.
 *
 * @param array $data The article data containing 'title', 'content', and 'status'.
 * @param int $article_id The ID of the article to be updated.
 * @return bool True if the article was successfully updated, otherwise an exception is thrown.
 * @throws \Exception If the article cannot be updated.
 */

    public function updateArticle($data, $article_id)
    {
        try {

            //Fetch images and replace them with urls...
            $data['content'] = $this->fetchImages($data['content']);

            $article = Article::find($article_id);
            $article->title = $data['title'];
            $article->content = $data['content'];
            $article->status = $data['status'];
            $article->updated_by = Auth::id();
            $article->save();
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }



    /**
     * Retrieve all archived articles, with optional search filter.
     * 
     * @param array $params The array containing search parameters.
     * @return array The list of archived articles with their details.
     */
    public function getAdminlandArchivedArticles($params)
    {
        $search = $params['search']??"";
        $articles = Article::with('updatedBy', 'module', 'module.workspace')
            ->where('status', 0)
            ->where(function ($query) use($search) {
                $query->where('title', 'LIKE', '%'.$search.'%')
                    ->orWhere('content', 'LIKE', '%'.$search.'%');
            })
            ->get()
            ->map(function($article) {
                return [
                    'id' => $article->id,
                    'title' => $article->title,
                    'slug' => $article->slug,
                    'module_slug' => $article->module->slug,
                    'workspace_slug' => $article->module->workspace->slug,
                    'updated_by' => $article->updatedBy->name,
                    'updated_at' => Carbon::parse($article->updated_at)->format('F d, Y')
                ];
            });
        //dd($articles);
        return $articles;
    }


    /**
     * Delete an article.
     *
     * @param int $articleId The ID of the article to be deleted
     * @return boolean True if the deletion was successful, false if not
     * @throws \Exception If the article cannot be deleted
     */
    public function deleteArticle($articleId)
    {
        try {
            $delete = Article::where('id', $articleId)->delete();
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }


    /**
     * Retrieves an archived article.
     *
     * @param string $workspaceSlug The slug of the workspace containing the module and article.
     * @param string $moduleSlug The slug of the module containing the article.
     * @param string $articleSlug The slug of the article to be retrieved.
     * @return \App\Models\Article|false The archived article if found, otherwise false.
     */
    public function getArchivedArticle($workspaceSlug, $moduleSlug, $articleSlug)
    {
        $article = Article::with('module', 'module.workspace', 'createdBy')
            ->whereHas('module', function($q) use ($moduleSlug) {
                $q->where('slug', $moduleSlug);
            })
            ->whereHas('module.workspace', function($q) use ($workspaceSlug) {
                $q->where('slug', $workspaceSlug);
            })
            ->where('slug', $articleSlug)
            ->where('status', 0) //For archived articles
            ->first();
        
        if(!$article) {
            return false;
        }
        return $article;
    }
    

    /**
     * Replace base64 encoded images with actual URLs in the given content.
     *
     * @param string $content The content that may contain base64 encoded images.
     * @return string The content with base64 images replaced with actual URLs.
     */
    public function fetchImages($content){
        preg_match_all('/<img[^>]+src="data:image\/[^"]+"/', $content, $matches);
            
        $imageUrls = [];
        if (!empty($matches[0])) {
            foreach ($matches[0] as $imgTag) {
                if (preg_match('/src="([^"]+)"/', $imgTag, $srcMatch)) {
                    $base64String = $srcMatch[1];

                    // Decode base64 and save as a file
                    if (preg_match('/^data:image\/(\w+);base64,/', $base64String, $extMatch)) {
                        $extension = $extMatch[1]; // jpg, png, etc.
                        $base64Data = substr($base64String, strpos($base64String, ',') + 1);
                        $decodedData = base64_decode($base64Data);

                        // Generate filename and save it
                        $filename = 'uploads/' . Str::random(10) . '.' . $extension;
                        Storage::disk('public')->put($filename, $decodedData);

                        // Replace base64 with image URL
                        $imageUrls[$base64String] = asset('storage/' . $filename);
                    }
                }
            }
        }

        // Replace base64 images with actual paths in content
        foreach ($imageUrls as $base64 => $url) {
            $content = str_replace($base64, $url, $content);
        }

        return $content;
    }


    /**
     * Save an article rating (like).
     *
     * @param array $params The associative array containing article_id and rating.
     * @return bool True if the rating was successfully saved, otherwise false.
     */
    public function articleLike($params){
        try{
            ArticleRating::create([
                'article_id' => $params['article_id'],
                'rating' => $params['rating']
            ]);

            $article = Article::find($params['article_id']);
        return $article;
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
} 