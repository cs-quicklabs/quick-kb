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
        $credentials = $request->only('email', 'password');

        if ($this->userRepository->authenticate($credentials)) {
            return redirect()->intended('/workspaces');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function recoveryCode($userId)
    {   
        $decryptedId = decrypt($userId);
        $user = $this->userRepository->findById($decryptedId);
        return view('firstrun.recoverycode', ['recoveryCode' => $user->recovery_code ?? null]);
    }

    public function forgotPassword()
    {
        return view('firstrun.forgotpassword');
    }

    public function register(SignupRequest $request)
    {
        $user = $this->userRepository->register($request->all());
        $encryptedId = encrypt($user->id);

        return redirect()->route('recovery.code', ['userId' => $encryptedId]);
    }

    public function logout()
    {
        $this->userRepository->logout();
        return redirect()->route('login');
    }

    public function validateRecoveryCode(Request $request)
    {
        $recoveryCode = $request->input('recovery_code');
        $encryptedId = $this->userRepository->validateRecoveryCode($recoveryCode);

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
        $userId = decrypt($request->input('user_id'));
        $password = $request->input('password');

        if ($this->userRepository->resetPassword($userId, $password)) {
            return redirect()->route('login')->with('status', 'Password has been reset successfully.');
        }

        return back()->withErrors([
            'password' => 'Failed to reset the password. Please try again.',
        ]);
    }

    public function updatePassword(ChangePasswordRequest $request)
    {
        $oldPasswordOrRecoveryCode = $request->input('old_password_or_recovery_code');
        $newPassword = $request->input('new_password');

        if ($this->userRepository->updatePassword($oldPasswordOrRecoveryCode, $newPassword)) {
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