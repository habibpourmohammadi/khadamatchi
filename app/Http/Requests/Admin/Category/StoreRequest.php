<?php

namespace App\Http\Requests\Admin\Category;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            "name" => ["required", "unique:categories,name", "max:255"],
            "description" => ["required"],
            "image_path" => ["nullable", "image", "mimes:png,jpg,jpeg", "max:1024"],
        ];
    }

    public function attributes()
    {
        return [
            "name" => "نام دسته بندی",
            "description" => "توضیحات دسته بندی",
            "image_path" => "عکس دسته بندی",
        ];
    }
}
