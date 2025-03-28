<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateAccountSettingsRequest;
use App\Repositories\SettingRepository;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
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
} 