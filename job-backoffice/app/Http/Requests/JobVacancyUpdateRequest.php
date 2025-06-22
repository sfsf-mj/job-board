<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobVacancyUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            "title"=> "bail|required|string|max:255",
            "description"=> "bail|required|string|max:255",
            "location"=> "bail|required|string|max:255",
            "salary"=> "bail|required|string|max:255",
            "type"=> "bail|required|string|max:255",
            "required_skills"=> "bail|required|string|max:255",
            "company_id"=> "bail|required|max:255",
            "job_category_id"=> "bail|required|max:255",
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
            'company_id.required' => 'The company_id field is required.',
            'job_category_id.required' => 'The job_category_id field is required.',
        ];
    }
}
