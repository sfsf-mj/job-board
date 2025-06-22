<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobVacancyCreateRequest extends FormRequest
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
            "title"=> "bail|required|string|max:255",
            "description"=> "bail|required|string|max:255",
            "location"=> "bail|required|string|max:255",
            "salary"=> "bail|required|numeric",
            "type"=> "bail|required|string|max:255",
            "required_skills"=> "bail|required|string|max:255",
            "company_id"=> "bail|required|string|max:255|exists:companies,id",
            "job_category_id"=> "bail|required|max:255|exists:job_categories,id",
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The title field is required.',
            'description.required' => 'The description field is required.',
            'location.required' => 'The location field is required.',
            'salary.required' => 'The salary field is required.',
            'type.required' => 'The type field is required.',
            'required_skills.required' => 'The required_skills field is required.',
            'company_id.required'=> 'Company is required.',
            'company_id.exists'=> 'Company does not exist.',
            'job_category_id.required'=> 'Job Category is required.',
            'job_category_id.exists'=> 'Job Category does not exist.',
        ];
    }
}
