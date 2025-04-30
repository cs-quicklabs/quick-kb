<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateAccountSettingsRequest;
use App\Repositories\SettingRepository;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Requests\ImportDatabaseRequest;
class SettingController extends BaseController
{
    protected $settingRepository;

    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    /**
     * Handle the incoming request for updating account settings.
     *
     * @param  \App\Http\Requests\UpdateAccountSettingsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function updateAccountSettings(UpdateAccountSettingsRequest $request)
    {
        try {
            $this->settingRepository->updateAccountSettings($request->validated(), Auth::id());
            return $this->sendSuccessResponse( [], config('response_messages.account_settings_updated'), config('statuscodes.OK'));
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), config('response_messages.account_settings_not_updated'), config('statuscodes.BAD_REQUEST'));
        }
    }

    /**
     * Get the user settings.
     *
     * @return \Illuminate\Http\Response
     */
    public function settings()
    {
        $userSettings = $this->settingRepository->settings();
        return view('adminland.accountsettings', compact('userSettings'));
    }


    /**
     * Display the manage database view page.
     *
     * @return \Illuminate\View\View
     */
    public function manageDatabase()
    {
        return view('adminland.managedatabase');
    }


    /**
     * Export the database.
     *
     * @return \Illuminate\Http\Response
     */
    public function exportDatabase()
    {
        try {
            $database = $this->settingRepository->exportDatabase();
            return $this->sendSuccessResponse( $database, config('response_messages.database_exported'), config('statuscodes.OK'));
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), config('response_messages.failed_to_export_database'), config('statuscodes.BAD_REQUEST'));
        }
    }


    /**
     * Import the database.
     *
     * @param  \App\Http\Requests\ImportDatabaseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function importDatabase(ImportDatabaseRequest $request)  {
        try {
            $this->settingRepository->importDatabase($request->all());
            return $this->sendSuccessResponse( [], config('response_messages.database_imported'), config('statuscodes.OK'));
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), config('response_messages.failed_to_import_database'), config('statuscodes.BAD_REQUEST'));        
        }
    }


    /**
     * Save the article footer text.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveArticleFooter(Request $request) {
        try {
            $this->settingRepository->saveArticleFooter($request->all());
            return $this->sendSuccessResponse( [], config('response_messages.article_footer_saved'), config('statuscodes.OK'));
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), config('response_messages.failed_to_save_article_footer'), config('statuscodes.BAD_REQUEST'));   
        }
    }
} 