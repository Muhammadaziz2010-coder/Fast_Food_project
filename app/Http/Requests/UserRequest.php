<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = $this->route('user');

        return match ($this->route()?->getName()) {
            'users.store' => [
                'name' => ['required', 'string', 'max:150'],
                'username' => ['required', 'string', 'min:4', 'max:32', 'unique:users'],
                'password' => ['required', 'string', 'min:4', 'max:16'],
                'roles' => ['required', 'array', 'min:1'],
                'roles.*' => ['exists:roles,id']
            ],
            'users.update' => [
                'name' => ['required', 'string', 'max:150'],
                'username' => ['required', 'string', 'min:4', 'max:32', 'unique:users,username,' . $user->id],
                'password' => ['sometimes', 'string', 'min:4', 'max:16'],
                'roles' => ['required', 'array', 'min:1'],
                'roles.*' => ['exists:roles,id']
            ],
            default => []
        };
    }

    /**
     * Get the validation error messages that apply to the request.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Name is required.',
            'name.string' => 'Name must be a string.',
            'name.max' => 'Name may not be greater than :max characters.',

            'username.required' => 'Username is required.',
            'username.string' => 'Username must be a string.',
            'username.min' => 'Username must be at least :min characters.',
            'username.max' => 'Username may not be greater than :max characters.',
            'username.unique' => 'This username is already taken.',

            'password.required' => 'Password is required.',
            'password.string' => 'Password must be a string.',
            'password.min' => 'Password must be at least :min characters.',
            'password.max' => 'Password may not be greater than :max characters.',

            'roles.required' => 'Roles are required.',
        ];
    }
}
