<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyUpdateRequest extends FormRequest
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
            "name"=> "bail|required|string|max:255|unique:companies,name,".$this->route('company'),
            "address"=> "bail|required|string|max:255",
            "industry"=> "bail|required|string|max:255",
            "website"=> "bail|nullable|url|string|max:255",

            "owner_name"=> "bail|required|string|max:255",
            "owner_password"=> "bail|nullable|string|min:8",
        ];
    }

    public function messages(): array
    {
        return [
            "name.required" => "Name is required.",
            "name.string" => "Name must be a string.",
            "name.max" => "Name must not exceed 255 characters.",
            "name.unique" => "Name already exists.",
            "address.required" => "Address is required.",
            "address.string" => "Address must be a string.",
            "address.max" => "Address must not exceed 255 characters.",
            "industry.required" => "Industry is required.",
            "industry.string" => "Industry must be a string.",
            "industry.max" => "Industry must not exceed 255 characters.",
            "website.required" => "Website is required.",
            "website.string" => "Website must be a string.",
            "website.max" => "Website must not exceed 255 characters.",
            "website.url"=> "The website must be a valid URL.",

            "owner_name.required" => "Owner name is required.",
            "owner_name.string" => "Owner name must be a string.",
            "owner_name.max" => "Owner name must not exceed 255 characters.",
            "owner_password.min"=> "Password must be at least 8 characters.",
        ];
    }
}
