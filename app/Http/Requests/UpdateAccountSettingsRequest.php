<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAccountSettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Since we'll handle authorization through middleware
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'knowledge_base_name' => ['required', 'string', 'max:255'],
            'theme_color' => ['required', 'string', 'in:red,blue,green,yellow,teal,orange'], // adjust colors as needed
            'theme_spacing' => ['required', 'string', 'in:default,compact'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'knowledge_base_name.required' => 'The knowledge base name is required.',
            'knowledge_base_name.max' => 'The knowledge base name cannot exceed 255 characters.',
            'theme_color.required' => 'Please select a theme color.',
            'theme_color.in' => 'The selected theme color is invalid.',
            'theme_spacing.required' => 'Please select a theme spacing.',
            'theme_spacing.in' => 'The selected theme spacing is invalid.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'knowledge_base_name' => 'knowledge base name',
            'theme_color' => 'theme color',
            'theme_spacing' => 'theme spacing',
        ];
    }
} 