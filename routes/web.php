<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\WorkspaceController;


Route::get('/', [AuthController::class, 'checkInitialRedirect']);

Route::middleware([RedirectIfAuthenticated::class])->group(function () {
    Route::get('/signup', [AuthController::class, 'signup']);
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
Route::get('/modules', function () {
    return view('modules.modules');
})->name('modules.modules');

// Protected routes
Route::middleware([Authenticate::class])->group(function () {
    Route::prefix('adminland')->group(function () {
        Route::get('/change-password', function () {
            return view('adminland.changepassword');
        })->name('adminland.changepassword');

        Route::post('/update-password', [AuthController::class, 'updatePassword'])->name('adminland.updatepassword');

        Route::get('/workspaces', function () {
            return view('adminland.archivedworkspace');
        })->name('adminland.workspaces');

        Route::get('/modules', function () {
            return view('adminland.archivedmodule');
        })->name('adminland.modules');

        Route::get('/articles', function () {
            return view('adminland.archivedarticle');
        })->name('adminland.articles');

        Route::get('/settings', [SettingController::class, 'settings'])->name('adminland.settings');

        Route::POST('/accountsettings', [SettingController::class, 'updateAccountSettings']); 
    });

    Route::post('/workspaces', [WorkspaceController::class, 'createWorkspace'])->name('workspaces.createWorkspace');
    Route::post('/workspaces/update/{workspace_id}', [WorkspaceController::class, 'updateWorkspace'])->name('workspaces.updateWorkspace');
    Route::post('/workspaces/update-status/{workspace_id}', [WorkspaceController::class, 'updateWorkspaceStatus'])->name('workspaces.updateWorkspaceStatus');
    Route::post('/workspaces/update-positions', [WorkspaceController::class, 'updateWorkspacePositions'])->name('workspaces.updateWorkspacePositions');
});

