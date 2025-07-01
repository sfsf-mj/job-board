<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ApplyJobRequest extends FormRequest
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
        $userId = auth()->guard()->user()->id;
        $jobVacancyId = $this->route('id');

        return [
            "resume_option"=> "bail|required|string",
            "resume_file" => "bail|required_if:resume_option,new_resume|file|mimes:pdf|max:5120",
            'job_vacancy_id' => [
                'required', // تأكد من أن job_vacancy_id موجود
                Rule::unique('job_applications')->where(function ($query) use ($userId, $jobVacancyId) {
                    return $query->where('user_id', $userId)
                                 ->where('job_vacancy_id', $jobVacancyId);
                })
            ],
        ];
    }

    public function messages(): array
    {
        return [
            "resume_file.required" => "A resume file is required.",
            "resume_file.file" => "The resume file must be a file.",
            "resume_file.mimes" => "The resume file must be a PDF.",
            "resume_file.max" => "The resume file must not exceed 5MB.",
            "resume_option.required"=> "The resume is required.",
            "job_vacancy_id.unique"=> "You have already applied for this job.",
        ];
    }
}
