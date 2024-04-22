<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
        return [
            "first_name" => ["required", "max:200"],
            "last_name" => ["required", "max:150"],
            "mobile" => ["nullable", "regex:/^09\d{9}$/", "unique:users,mobile"],
            "email" => ["required", "email", "unique:users,email"],
            "password" => ["required"],
            "city" => ["required", "exists:cities,slug"]
        ];
    }
}
