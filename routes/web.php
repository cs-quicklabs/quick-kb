<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\CheckUserExists;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\WorkspaceController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ArticleController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

Route::get('/', [AuthController::class, 'checkInitialRedirect']);

Route::middleware([RedirectIfAuthenticated::class])->group(function () {
    Route::middleware([CheckUserExists::class])->group(function () {
        Route::get('/signup', [AuthController::class, 'signup']);
    });
    Route::get('/login', [AuthController::class, 'login'])->name('login');
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'authenticate']);
Route::get('/recovery-code/{userId}', [AuthController::class, 'recoveryCode'])->name('recovery.code');
Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
Route::get('/reset-password/{userId}', [AuthController::class, 'showResetPasswordForm'])->name('reset-password');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// New route for validating recovery code
Route::post('/validate-recovery-code', [AuthController::class, 'validateRecoveryCode'])->name('validate.recovery.code');

Route::get('/workspaces', [WorkspaceController::class, 'workspaces'])->name('workspaces.workspaces');
Route::get('/modules/{workspace_slug}', [ModuleController::class, 'modules'])->name('modules.modules');

Route::get('/articles/{workspace_slug}/{module_slug}', [ArticleController::class, 'articles'])->name('articles.articles');
Route::get('/articles/{workspace_slug}/{module_slug}/add', [ArticleController::class, 'addArticle'])->name('articles.addArticle')->middleware(Authenticate::class);
Route::get('/articles/{workspace_slug}/{module_slug}/{article_slug}', [ArticleController::class, 'articleDetails'])->name('articles.articleDetails');
Route::post('search-content', [WorkspaceController::class, 'searchContent'])->name('search.content');

// Protected routes
Route::middleware([Authenticate::class])->group(function () {
    Route::prefix('adminland')->group(function () {
        Route::get('/change-password', function () {
            return view('adminland.changepassword');
        })->name('adminland.changepassword');

        Route::post('/update-password', [AuthController::class, 'updatePassword'])->name('adminland.updatepassword');

        Route::get('/archived/workspaces', [WorkspaceController::class, 'archivedWorkspaces'])->name('adminland.archivedworkspaces');

        Route::delete('/delete/workspace/{workspace_id}', [WorkspaceController::class, 'deleteWorkspace'])->name('adminland.deleteWorkSpace');

        Route::get('/archived/modules', [ModuleController::class, 'archivedModules'])->name('adminland.archivedmodules');
        Route::delete('/delete/module/{module_id}', [ModuleController::class, 'deleteModule'])->name('adminland.deleteModule');

        Route::get('/archived/articles', [ArticleController::class, 'archivedArticles'])->name('adminland.archivedarticles');
        Route::delete('/delete/article/{article_id}', [ArticleController::class, 'deleteArticle'])->name('adminland.deleteArticle');


        Route::get('/settings', [SettingController::class, 'settings'])->name('adminland.settings');

        Route::POST('/accountsettings', [SettingController::class, 'updateAccountSettings'])->name('adminland.updateAccountSettings'); 
    });

    Route::post('/workspaces', [WorkspaceController::class, 'createWorkspace'])->name('workspaces.createWorkspace');
    Route::post('/workspaces/update/{workspace_id}', [WorkspaceController::class, 'updateWorkspace'])->name('workspaces.updateWorkspace');
    Route::post('/workspaces/update-status/{workspace_id}', [WorkspaceController::class, 'updateWorkspaceStatus'])->name('workspaces.updateWorkspaceStatus');
    Route::post('/workspaces/update-order', [WorkspaceController::class, 'updateWorkspaceOrder'])->name('workspaces.updateWorkspaceOrder');
    Route::get('/workspaces/archived/{workspace_slug}', [WorkspaceController::class, 'getArchivedWorkspace'])->name('workspaces.getArchivedWorkspace');

    Route::post('/modules', [ModuleController::class, 'createModule'])->name('modules.createModule');
    Route::post('/modules/update/{module_id}', [ModuleController::class, 'updateModule'])->name('modules.update');
    Route::post('/modules/update-status/{module_id}', [ModuleController::class, 'updateModuleStatus'])->name('modules.updateModuleStatus');
    Route::post('/modules/update-order', [ModuleController::class, 'updateModuleOrder'])->name('modules.updateModuleOrder');
    Route::get('/modules/archived/{workspace_slug}/{module_slug}', [ModuleController::class, 'getArchivedModule'])->name('modules.getArchivedModule');

    
    Route::post('/articles/store', [ArticleController::class, 'storeArticle'])->name('articles.store');
    Route::post('/articles/update-status/{article_id}', [ArticleController::class, 'updateArticleStatus'])->name('articles.updateArticleStatus');
    Route::post('/articles/update-order', [ArticleController::class, 'updateArticleOrder'])->name('articles.updateArticleOrder');
    Route::post('/articles/update/{article_id}', [ArticleController::class, 'updateArticle'])->name('articles.update');
    Route::get('/articles/archived/{workspace_slug}/{module_slug}/{article_slug}', [ArticleController::class, 'getArchivedArticle'])->name('articles.getArchivedArticle');

});


