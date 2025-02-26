<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\KnowledgeBase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
class UserRepository
{
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
            
            KnowledgeBase::create([
                'knowledge_base_name' => $knowledge_base,
                'user_id' => $user->id,
            ]);
            
            DB::commit();
            $encryptedId = encrypt($user->id);
            return $encryptedId;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to register user: ' . $e->getMessage());
            throw new \Exception('Failed to register user: ' . $e->getMessage());
        }
    }

    public function findByEncryptedId($encryptedUserId)
    {

        $decryptedId = decrypt($encryptedUserId);
        return User::find($decryptedId);
    }

    public function login(array $credentials)
    {
        return Auth::attempt($credentials);
    }

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

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
    }

    public function validateRecoveryCode(array $params)
    {
        $recoveryCode = $params['recovery_code'];
        $user = User::where('recovery_code', $recoveryCode)->first();

        if ($user) {
            return encrypt($user->id);
        }

        return null;
    }

    public function validateEncryptedUserId(string $encryptedId)
    {
        try {
            $userId = decrypt($encryptedId);
            return User::find($userId) !== null;
        } catch (\Exception $e) {
            return false;
        }
    }

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

    public function count(): int
    {
        $userCount = User::count();
        return $userCount;
    }
}