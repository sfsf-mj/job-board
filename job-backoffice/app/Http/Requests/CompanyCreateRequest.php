<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyCreateRequest extends FormRequest
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
            "name"=> "bail|required|string|max:255|unique:companies,name",
            "address"=> "bail|required|string|max:255",
            "industry"=> "bail|required|string|max:255",
            "website"=> "bail|nullable|string|url|max:255",
            
            // owner details
            "owner_name"=> "bail|required|string|max:255",
            "owner_email"=> "bail|required|string|email|max:255|unique:users,email",
            "owner_password"=> "bail|required|string|min:8",
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
            "website.string" => "Website must be a string.",
            "website.url"=> "The website must be a valid URL.",
            "website.max" => "Website must not exceed 255 characters.",
            
            "owner_password.confirmed"=> "Password confirmation does not match.",
            "owner_password.min"=> "Password must be at least 8 characters.",
        ];
    }
}
