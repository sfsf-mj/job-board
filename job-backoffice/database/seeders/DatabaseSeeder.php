<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\JobApplication;
use App\Models\JobCategory;
use App\Models\JobVacancy;
use App\Models\Resume;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // seed the user admin
        User::firstOrCreate(
            [
                'email' => 'admin@admin.com',
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // seed data to test with
        $jobData = json_decode(file_get_contents(database_path('data/job_data.json')), true);
        $jobApplicationsData = json_decode(file_get_contents(database_path('data/job_applications.json')), true);

        // Create job categories
        foreach ($jobData['job_categories'] as $category) {
            JobCategory::firstOrCreate([
                'name' => $category,
            ]);
        }

        // create companies
        foreach ($jobData['companies'] as $company) {
            $email = fake()->unique()->safeEmail();

            // creatw a company owner before creating the company
            $companyOwner = User::firstOrCreate(
                [
                    'email' => $email,
                ],
                [
                    'name' => fake()->name(),
                    'email' => $email,
                    'password' => Hash::make('12345678'),
                    'role' => 'company-owner',
                    'email_verified_at' => now(),
                ]
            );

            // create the company
            Company::firstOrCreate(
                [
                    'name' => $company['name'],
                ],
                [
                    'name' => $company['name'],
                    'address' => $company['address'],
                    'industry' => $company['industry'],
                    'website' => $company['website'],
                    'owner_id' => $companyOwner->id,
                ]
            );
        }

        // create job vacancies
        foreach ($jobData['job_vacancies'] as $job) {
            // get the company
            $company = Company::where('name', $job['company'])->firstOrFail();

            //get job category
            $jobCategory = JobCategory::where('name', $job['category'])->firstOrFail();

            // create the job vacancy
            JobVacancy::firstOrCreate([
                'title' => $job['title'],
                'company_id' => $company->id,
            ], [
                'title' => $job['title'],
                'description' => $job['description'],
                'location' => $job['location'],
                'salary' => $job['salary'],
                'type' => 'FullTime',
                'required_skills' => 'test',
                'view_count' => 0,
                'company_id' => $company->id,
                'job_category_id' => $jobCategory->id,
            ]);
        }

        // create job applications
        foreach ($jobApplicationsData['jobApplications'] as $application) {
            // get random job vacancy
            $jobVacancy = JobVacancy::inRandomOrder()->firstOrFail();

            // create a job seeker user
            $email = fake()->unique()->safeEmail();
            $user = User::firstOrCreate(
                [
                    'email' => $email,
                ],
                [
                    'name' => fake()->name(),
                    'email' => $email,
                    'password' => Hash::make('12345678'),
                    'role' => 'job-seeker',
                    'email_verified_at' => now(),
                ]
            );

            // create a resume for job seeker
            $resume = Resume::firstOrCreate(
                [
                    'user_id' => $user->id,
                ],
                [
                    'file_name' => $application['resume']['filename'],
                    'file_Uri' => $application['resume']['fileUri'],
                    'summary' => $application['resume']['summary'],
                    'contact_details' => $application['resume']['contactDetails'],
                    'education' => $application['resume']['education'],
                    'experience' => $application['resume']['experience'],
                    'skills' => $application['resume']['skills'],
                    'user_id' => $user->id,
                ]
            );

            //create the job application
            JobApplication::firstOrCreate([
                'job_vacancy_id' => $jobVacancy->id,
                'user_id' => $user->id,
            ], [
                'status' => $application['status'],
                'aiGeneratedScore' => $application['aiGeneratedScore'],
                'aiGeneratedFeedback' => $application['aiGeneratedFeedback'],
                'job_vacancy_id' => $jobVacancy->id,
                'user_id' => $user->id,
                'resume_id' => $resume->id,
            ]);
        }
    }
}
