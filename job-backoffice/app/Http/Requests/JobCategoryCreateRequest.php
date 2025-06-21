<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobCategoryCreateRequest extends FormRequest
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
            "name"=> "bail|required|string|max:255|unique:job_categories,name",
        ];
    }

    public function messages(): array
    {
        return [
            "name.required" => "The category name is required.",
            "name.string" => "The category name must be a string.",
            "name.max" => "The category name must not be greater than 255 characters.",
            "name.unique" => "The category name has already been taken.",
        ];
    }
}
