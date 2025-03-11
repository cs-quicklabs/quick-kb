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

    /**
     * Display the signup view for creating a new account.
     *
     * @return \Illuminate\View\View
     */

    public function signup()
    {   
        return view('firstrun.signup');
    }

    /**
     * Display the login view for user authentication.
     *
     * @return \Illuminate\View\View
     */

    public function login()
    {
        return view('firstrun.login');
    }

    
    /**
     * Handles user authentication.
     *
     * @param LoginRequest $request The request object containing validated user credentials.
     * @return \Illuminate\Http\RedirectResponse The redirect response after user authentication.
     */
    public function authenticate(LoginRequest $request)
    {

        if ($this->userRepository->authenticate($request->all())) {
            return redirect()->intended('/workspaces')->with('success', config('response_messages.
            user_logged_in'));
        }

        return back()->withErrors([
            'email' => config('response_messages.credentials_not_matched'),
        ]);
    }


    /**
     * Display the recovery code for a user given the encrypted ID.
     * 
     * @param string $userId The encrypted ID of the user.
     * @return \Illuminate\View\View The view containing the recovery code.
     */
    public function recoveryCode($userId)
    {   
        $user = $this->userRepository->findByEncryptedId($userId);
        return view('firstrun.recoverycode', ['recoveryCode' => $user->recovery_code ?? null]);
    }


    /**
     * Display the forgot password view.
     *
     * @return \Illuminate\View\View The view for password recovery.
     */

    public function forgotPassword()
    {
        return view('firstrun.forgotpassword');
    }


    /**
     * Registers a new user using the provided request data.
     * 
     * @param SignupRequest $request The request object containing validated user data.
     * @return \Illuminate\Http\RedirectResponse The redirect response containing the encrypted ID of the newly registered user.
     */
    public function register(SignupRequest $request)
    {
        $encryptedId = $this->userRepository->register($request->all());
        
        return redirect()->route('recovery.code', ['userId' => $encryptedId]);
    }

    
    /**
     * Log out the current user and invalidate their session.
     * 
     * @return \Illuminate\Http\RedirectResponse The redirect response to the login page.
     */
    public function logout()
    {
        $this->userRepository->logout();
        return redirect()->route('login');
    }

    /**
     * Validates a recovery code for a user and redirects to the reset password page.
     *
     * @param \Illuminate\Http\Request $request The request object containing the recovery code.
     * @return \Illuminate\Http\RedirectResponse The redirect response either to the reset password page
     * or the forgot password page with an error message if the code is invalid.
     */
    public function validateRecoveryCode(Request $request)
    {
        $encryptedId = $this->userRepository->validateRecoveryCode($request->all());

        if ($encryptedId) {
            return redirect()->route('reset-password', ['userId' => $encryptedId]);
        }

        return redirect()->route('forgot-password')->withErrors([
            'recovery_code' => config('response_messages.invalid_recovery_code'),
        ]);
    }

    
    /**
     * Display the reset password view for a user given the encrypted ID.
     * 
     * @param string $userId The encrypted ID of the user to reset the password for.
     * @return \Illuminate\View\View The view for resetting the password or the redirect response
     * to the forgot password page if the ID is invalid.
     */
    public function showResetPasswordForm($userId)
    {
        if (!$this->userRepository->validateEncryptedUserId($userId)) {
            return redirect()->route('forgot-password')->with('error', config('response_messages.invalid_user_id'));
        }

        return view('firstrun.resetpassword', ['userId' => $userId]);
    }

    /**
     * Resets the password for a user using the provided request data.
     * 
     * @param ResetPasswordRequest $request The request object containing the new password.
     * @return \Illuminate\Http\RedirectResponse The redirect response to the login page with a success message.
     */
    public function resetPassword(ResetPasswordRequest $request)
    {

        if ($this->userRepository->resetPassword($request->all())) {
            return redirect()->route('login')->with('success', config('response_messages.password_reset_successfully'));
        }

        return back()->withErrors([
            'password' => config('response_messages.password_reset_failed'),
        ]);
    }

    
    /**
     * Updates the password for the currently authenticated user.
     *
     * @param ChangePasswordRequest $request The request object containing the old password or recovery code and the new password.
     * @return \Illuminate\Http\RedirectResponse The redirect response to the change password page with a success message if the password is updated,
     * or with an error message if the old password or recovery code is incorrect.
     */

    public function updatePassword(ChangePasswordRequest $request)
    {

        if ($this->userRepository->updatePassword($request->all())) {
            return redirect()->route('adminland.changepassword')->with('success', config('response_messages.password_reset_successfully'));
        }

        return redirect()->route('adminland.changepassword')->with('error', config('response_messages.old_password_or_recovery_code_incorrect'));
    }

    /**
     * Checks if there are any users in the database and redirects accordingly.
     * If there are any users, redirects to the workspaces page, otherwise redirects to the signup page.
     * 
     * @return \Illuminate\Http\RedirectResponse The redirect response.
     */
    public function checkInitialRedirect()
    {
        $userCount = $this->userRepository->count();
        
        if ($userCount > 0) {
            return redirect('/workspaces');
        }
        return redirect('/signup');
    }


}