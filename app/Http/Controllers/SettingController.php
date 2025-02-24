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

    public function updateAccountSettings(UpdateAccountSettingsRequest $request)
    {
        try {
            $this->settingRepository->updateAccountSettings($request->validated(), Auth::id());
            return redirect()->back()->with('success', 'Settings updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function settings()
    {
        $accountSettings = $this->settingRepository->getThemeData();
        return view('adminland.accountsettings', compact('accountSettings'));
    }
} 