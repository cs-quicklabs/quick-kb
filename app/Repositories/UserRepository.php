<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\KnowledgeBase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Theme;

class UserRepository
{
    
    /**
     * Registers a new user and creates an associated knowledge base.
     *
     * @param array $data User data including 'knowledge_base', 'password', and other attributes.
     * @return string Encrypted ID of the newly created user.
     * @throws \Exception If the registration process fails.
     */

    public function register(array $data)
    {
        DB::beginTransaction();
        try {
            $knowledge_base = $data['knowledge_base'];
            unset($data['knowledge_base']);
            $data['recovery_code'] = Str::uuid()->toString();
            $data['password'] = Hash::make($data['password']);
            $data['is_confirmed'] = 1;
            
            $user = User::create($data);
            
            $knowledgeBase = KnowledgeBase::create([
                'knowledge_base_name' => $knowledge_base,
                'user_id' => $user->id,
            ]);

            $themeData = getDefaultThemeValues(); //Getting default theme values from helper function.

            Theme::create([
                'knowledge_base_id' => $knowledgeBase->id,
                'name' => 'default',
                'theme_type' => 'default',
                'theme' => $themeData
            ]);
            
            $encryptedId = encrypt($user->id);
            DB::commit();
            
            return $encryptedId;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Retrieves a user by the encrypted ID.
     *
     * @param string $encryptedUserId Encrypted ID of the user to retrieve.
     * @return User|null The user instance if found, otherwise null.
     */
    public function findByEncryptedId($encryptedUserId)
    {

        $decryptedId = decrypt($encryptedUserId);
        return User::find($decryptedId);
    }

    /**
     * Attempt to log in with the given credentials.
     *
     * @param array $credentials The credentials to use for the login attempt.
     * @return bool True if the login attempt is successful, otherwise false.
     */
    public function login(array $credentials)
    {
        return Auth::attempt($credentials);
    }

    /**
     * Attempts to authenticate the user with the given credentials.
     *
     * @param array $params The credentials to use for the login attempt.
     * @return bool True if the login attempt is successful, otherwise false.
     */
    public function authenticate($params)
    {
        $credentials = [
            'email' => $params['email'],
            'password' => $params['password']
        ];

        if ($this->login($credentials)) {
            session()->regenerate();
            return true;
        }

        return false;
    }

    /**
     * Log out the current user and invalidate their session.
     *
     * This will remove the session data from the storage and
     * regenerate the session token.
     */
    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
    }

    /**
     * Validates the recovery code provided in the parameters.
     *
     * This function checks if the given recovery code exists in the database
     * and returns the encrypted user ID if found.
     *
     * @param array $params An associative array containing the 'recovery_code'.
     * @return string|null The encrypted user ID if the recovery code is valid, otherwise null.
     */

    public function validateRecoveryCode(array $params)
    {
        $recoveryCode = $params['recovery_code'];
        $user = User::where('recovery_code', $recoveryCode)->first();

        if ($user) {
            return encrypt($user->id);
        }

        return null;
    }

    /**
     * Validates the encrypted user ID.
     *
     * This function attempts to decrypt the encrypted user ID and checks
     * whether a user with the corresponding ID exists in the database.
     *
     * @param string $encryptedId The encrypted user ID to validate.
     * @return bool True if the user ID is valid and the user exists, otherwise false.
     */

    public function validateEncryptedUserId(string $encryptedId)
    {
        try {
            $userId = decrypt($encryptedId);
            return User::find($userId) !== null;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Resets the password for a user with the given ID and new password.
     *
     * This function takes an associative array containing the 'user_id' and 'password'
     * to reset the password. The 'user_id' is expected to be an encrypted user ID
     * using the app's encryption key. The password is expected to be a raw string.
     *
     * @param array $params An associative array containing the 'user_id' and 'password'.
     * @return bool True if the password was successfully reset, otherwise false.
     */
    public function resetPassword(array $params)
    {
        $userId = decrypt($params['user_id']);
        $password = $params['password'];
        $user = User::find($userId);

        if ($user) {
            $user->password = Hash::make($password);
            return $user->save();
        }

        return false;
    }

    /**
     * Updates the password for the currently authenticated user.
     *
     * @param array $params An associative array containing the 'old_password_or_recovery_code' and 'new_password'.
     * @return bool True if the password was successfully updated, otherwise false.
     */
    public function updatePassword(array $params)
    {
        $oldPasswordOrRecoveryCode = $params['old_password_or_recovery_code'];
        $newPassword = $params['new_password'];
        $user = Auth::user();
    
        if (Hash::check($oldPasswordOrRecoveryCode, $user->password) || $user->recovery_code === $oldPasswordOrRecoveryCode) {
            $user->password = Hash::make($newPassword);
            return User::where('id', $user->id)->update(['password' => $user->password]);
        }
    
        return false;
    }

    /**
     * Counts the total number of users in the database.
     *
     * This function uses the User model to retrieve the count of
     * all user records present in the database.
     *
     * @return int The total number of users.
     */

    public function count(): int
    {
        $userCount = User::count();
        return $userCount;
    }

    
}