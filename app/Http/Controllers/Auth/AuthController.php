<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignupRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function signup()
    {   
        return view('firstrun.signup');
    }

    public function login()
    {
        return view('firstrun.login');
    }

    public function authenticate(LoginRequest $request)
    {

        if ($this->userRepository->authenticate($request->all())) {
            return redirect()->intended('/workspaces');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function recoveryCode($userId)
    {   
        $user = $this->userRepository->findByEncryptedId($userId);
        return view('firstrun.recoverycode', ['recoveryCode' => $user->recovery_code ?? null]);
    }

    public function forgotPassword()
    {
        return view('firstrun.forgotpassword');
    }

    public function register(SignupRequest $request)
    {
        $encryptedId = $this->userRepository->register($request->all());
        
        return redirect()->route('recovery.code', ['userId' => $encryptedId]);
    }

    public function logout()
    {
        $this->userRepository->logout();
        return redirect()->route('login');
    }

    public function validateRecoveryCode(Request $request)
    {
        $encryptedId = $this->userRepository->validateRecoveryCode($request->all());

        if ($encryptedId) {
            return redirect()->route('reset-password', ['userId' => $encryptedId]);
        }

        return redirect()->route('forgot-password')->withErrors([
            'recovery_code' => 'The provided recovery code is incorrect.',
        ]);
    }

    public function showResetPasswordForm($userId)
    {
        if (!$this->userRepository->validateEncryptedUserId($userId)) {
            return redirect()->route('forgot-password')->withErrors([
                'user_id' => 'The provided user ID is invalid.',
            ]);
        }

        return view('firstrun.resetpassword', ['userId' => $userId]);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {

        if ($this->userRepository->resetPassword($request->all())) {
            return redirect()->route('login')->with('status', 'Password has been reset successfully.');
        }

        return back()->withErrors([
            'password' => 'Failed to reset the password. Please try again.',
        ]);
    }

    public function updatePassword(ChangePasswordRequest $request)
    {

        if ($this->userRepository->updatePassword($request->all())) {
            return redirect()->route('adminland.changepassword')->with('status', 'Password has been changed successfully.');
        }

        return back()->withErrors([
            'old_password_or_recovery_code' => 'The provided old password or recovery code is incorrect.',
        ]);
    }

    public function checkInitialRedirect()
    {
        $userCount = $this->userRepository->count();
        
        if ($userCount > 0) {
            return redirect('/workspaces');
        }
        return redirect('/signup');
    }


}