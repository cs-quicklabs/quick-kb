<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreWorkspaceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authorization will be handled by middleware
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    // public function messages(): array
    // {
    //     return [
    //         'title.required' => 'The workspace title is required.',
    //         'title.max' => 'The workspace title cannot exceed 255 characters.',
    //         'title.unique' => 'This workspace title already exists.',
    //         'description.required' => 'The workspace description is required.',
    //         'description.max' => 'The workspace description cannot exceed 1000 characters.',
    //     ];
    // }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    // public function attributes(): array
    // {
    //     return [
    //         'title' => 'workspace title',
    //         'description' => 'workspace description',
    //     ];
    // }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422)
        );
    }
} 