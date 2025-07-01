<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplyJobRequest;
use App\Models\JobApplication;
use App\Models\JobVacancy;
use App\Models\Resume;
use App\Services\ResumeAnalysisService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JobVacancyController extends Controller
{
    protected $resumeAnalysisService;

    public function __construct(ResumeAnalysisService $resumeAnalysisService)
    {
        $this->resumeAnalysisService = $resumeAnalysisService;
    }
    public function show(string $id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);

        $userId = auth()->guard()->user()->id;
        $jobVacancyId = $id;

        $checkApply = JobApplication::where('user_id', $userId)
            ->where('job_vacancy_id', $jobVacancyId)
            ->exists();

        return view("job-vacancies.show", compact("jobVacancy", "checkApply"));
    }

    public function apply(string $id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        $resumes = auth()->guard()->user()->resumes;
        return view("job-vacancies.apply", compact("jobVacancy", "resumes"));
    }

    public function processApplication(ApplyJobRequest $request, string $id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        $resumeId = null;
        $extractedInfo = null;

        if ($request->input('resume_option') == 'new_resume') {
            $file = $request->file('resume_file');
            $extension = $file->getClientOriginalExtension();
            $originalFileName = $file->getClientOriginalName();
            $newFileName = "resume_" . time() . '.' . $extension;
            $file->move(public_path('resumes'), $newFileName);
            $path = 'resumes/' . $newFileName;

            // Extract resume info
            $extractedInfo = $this->resumeAnalysisService->extractResumeInformation_test($path);

            $resume = Resume::create([
                'file_name' => $originalFileName,
                'file_Uri' => $path,
                'contact_details' => json_encode([
                    'name' => auth()->guard()->user()->name,
                    'email' => auth()->guard()->user()->email,
                ]),
                'summary' => $extractedInfo['summary'],
                'education' => $extractedInfo['education'],
                'experience' => $extractedInfo['experience'],
                'skills' => $extractedInfo['skills'],
                'user_id' => auth()->guard()->user()->id,
            ]);

            $resumeId = $resume->id;

        } else {
            $resumeId = $request->input('resume_option');
            $resume = Resume::findOrFail($resumeId);

            $extractedInfo = [
                'summary' => $resume->summary,
                'education' => $resume->education,
                'experience' => $resume->experience,
                'skills' => $resume->skills,
            ];
        }

        // Evaluate job application
        $evaluation = $this->resumeAnalysisService->analyzeResume_test($jobVacancy, $extractedInfo);

        JobApplication::create([
            'status' => 'pending',
            'aiGeneratedScore' => $evaluation['aiGeneratedScore'],
            'aiGeneratedFeedback' => $evaluation['aiGeneratedFeedback'],
            'job_vacancy_id' => $id,
            'user_id' => auth()->guard()->user()->id,
            'resume_id' => $resumeId,
        ]);

        return redirect()->route("job-applications.index")->with('notification', [
            'title' => 'Success!',
            'type' => 'success',
            'message' => 'Your application has been applied successfully.',
        ]);
    }
}
