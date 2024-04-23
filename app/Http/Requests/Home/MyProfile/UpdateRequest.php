<?php

namespace App\Http\Requests\Home\MyProfile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateRequest extends FormRequest
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
            "last_name" => ["required", "max:200"],
            "profile_path" => ["nullable", "image", "mimes:png,jpg,jpeg", "max:1024"],
            "mobile" => ["nullable", "regex:/^09\d{9}$/", "unique:users,mobile," . Auth::user()->id],
            "city" => ["required", "exists:cities,slug"],
            "gender" => ["required", "in:male,female,none"],
        ];
    }

    public function attributes()
    {
        return [
            "profile_path" => "پروفایل",
            "city" => "شهر",
            "gender" => "جنسیت",
        ];
    }
}
