<?php

namespace App\Http\Requests\Permissions;

use Illuminate\Foundation\Http\FormRequest;

class CreatePermissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'unique:permissions,name|required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'The permission name has already been taken.',
            'name.required' => 'The permission name is required.',
            'name.string' => 'The permission name must be a string.',
            'name.max' => 'The permission name must not be greater than 255 characters.',
        ];
    }
}
