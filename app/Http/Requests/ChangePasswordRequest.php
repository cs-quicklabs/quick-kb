<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'old_password_or_recovery_code' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ];
    }
}