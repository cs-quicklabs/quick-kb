<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateAccountSettingsRequest;
use App\Repositories\SettingRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
class SettingController extends Controller
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
            return redirect()->back()->with('success', config('response_messages.settings_updated'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', config('response_messages.failed_to_update_settings'))->withInput();
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