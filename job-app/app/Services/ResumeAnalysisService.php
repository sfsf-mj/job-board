<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Spatie\PdfToText\Pdf;

class ResumeAnalysisService
{
    // public function extractResumeInformation(string $fileUrl)
    // {
    //     try {
    //         // Extract raw text from the resume pdf file (read pdf file, and get the text)
    //         $rawText = $this->extractTextFromPdf($fileUrl);

    //         Log::debug('Successfully extracted text from pdf file' . strlen($rawText) . ' characters');

    //         // Use OpenAI API to organize the text into a structured format
    //         $response = OpenAI::chat()->create([
    //             'model' => 'gpt-40-mini',
    //             'messages' => [
    //                 [
    //                     'role' => 'system',
    //                     'content' => "You are a percise resume parser. Extract information exactly as it appears in the resume without adding any interpretation or additional information. The output should be in JSON format."
    //                 ],
    //                 [
    //                     "role" => "user",
    //                     "content" => "Parse the following resume content and extract the information as a JSON Object with the exact keys: 'summary', 'skills', 'experience', 'education'. The resume content is: {$rawText}. Return an empty string for key that if not found."
    //                 ]
    //             ],
    //             "response_format" => [
    //                 "type" => "json_object"
    //             ],
    //             "temperature" => 0.1 // Sets the randomness of the AI response to 0, making it deterministic and focused on the most likely completion
    //         ]);

    //         // Output: summary, skills, experience, education -> JSON
    //         $result = $response->choices[0]->message->content;

    //         Log::debug('OpenAI response: ' . $result);

    //         $parsedResult = json_decode($result, true);

    //         if (json_last_error() !== JSON_ERROR_NONE) {
    //             Log::error("Failed to parse OpenAI response: " . json_last_error_msg());
    //             throw new \Exception('Failed to parse OpenAI response');
    //         }

    //         // Validate the parsed result
    //         $requiredKeys = ['summary', 'skills', 'experience', 'education'];
    //         $missingKeys = array_diff(array: $requiredKeys, arrays: array_keys(array: $parsedResult));
    //         if (count(value: $missingKeys) > 0) {
    //             Log::error(message: 'Missing required keys: ' . implode(separator: ', ', array: $missingKeys));
    //             throw new \Exception(message: 'Missing required keys in the parsed result');
    //         }

    //         // Return the JSON object
    //         return [
    //             'summary' => $parsedResult['summary'] ?? '',
    //             'skills' => $parsedResult['skills'] ?? '',
    //             'experience' => $parsedResult['experience'] ?? '',
    //             'education' => $parsedResult['education'] ?? ''
    //         ];
    //     } catch (\Exception $e) {
    //         Log::error(message: 'Failed to extract resume information: ' . $e->getMessage());

    //         return [
    //             'summary' => '',
    //             'skills' => '',
    //             'experience' => '',
    //             'education' => ''
    //         ];
    //     }
    // }


    public function extractResumeInformation_test(string $fileUrl)
    {
        $rawText = $this->extractTextFromPdf($fileUrl);

        return [
            'summary' => 'test mode',
            'skills' => 'test mode',
            'experience' => 'test mode',
            'education' => 'test mode'
        ];
    }

    //     public function analyzeResume($jobVacancy, $resumeData)
//     {
//         try {
//             $jobDetails = json_encode([
//                 'job_title' => $jobVacancy->title,
//                 'job_description' => $jobVacancy->description,
//                 'job_location' => $jobVacancy->location,
//                 'job_type' => $jobVacancy->type,
//                 'job_salary' => $jobVacancy->salary,
//             ]);

    //             $resumeDetails = json_encode($resumeData);

    //             $response = OpenAI::chat()->create([
//                 'model' => 'gpt-40',
//                 'messages' => [
//                     [
//                         'role' => 'system',
//                         'content'
//                         => "You are an expert HR professional and job recruiter. You are given a job vacancy and a resume.
// Your task is to analyze the resume and determine if the candidate is a good fit for the job.
// The output should be in JSON format.
// Provide a score from 0 to 100 for the candidate's suitability for the job, and a detailed feedback.
// Response should only be Json that has the following keys: 'aiGeneratedScore', 'aiGeneratedFeedback'.
// Aigenerate feedback should be detailed and specific to the job and the candidate's resume."
//                     ],
//                     [
//                         'role' => 'user',
//                         'content' => "Please evalute this job application. Job Details: {$jobDetails}. Resume Details: {$resumeDetails}"
//                     ]
//                 ],
//                 'response_format' => [
//                     'type' => 'json_object'
//                 ],
//                 'temperature' => 0.1
//             ]);

    //             $result = $response->choices[0]->message->content;

    //             Log::debug('OpenAI evaluationresponse: ' . $result);

    //             $parsedResult = json_decode(json: $result, associative: true);

    //             if (json_last_error() !== JSON_ERROR_NONE) {
//                 Log::error('Failed to parse OpenAI response: ' . json_last_error_msg());
//                 throw new \Exception('Failed to parse OpenAI response');
//             }

    //             if (!isset($parsedResult['aiGeneratedScore']) || !isset($parsedResult['aiGeneratedFeedback'])) {
//                 Log::error('Missing required keys in the parsed result');
//                 throw new \Exception('Missing required keys in the parsed result');
//             }

    //             return $parsedResult;

    //         } catch (\Exception $e) {
//             Log::error(message: 'Error analyzing resume: ' . $e->getMessage());
//             return [
//                 'aiGeneratedScore' => 0,
//                 'aiGeneratedFeedback' => 'An error occurred while analyzing the resume. Please try again later.'
//             ];
//         }
//     }


    public function analyzeResume_test($jobVacancy, $resumeData)
    {
        return [
            'aiGeneratedScore' => 100,
            'aiGeneratedFeedback' => 'test mode'
        ];
    }

    private function extractTextFromPdf(string $fileUrl): string
    {
        /*
            Will use the following code when using external storage
        */
        // $tempFile = tempnam(sys_get_temp_dir(), 'pdf');
        // $filePath = parse_url($fileUrl, PHP_URL_PATH);
        // if(!$filePath) {
        //     throw new \Exception('Invalid file URL: ' . $filePath);
        // }

        $fileName = basename($fileUrl);

        $storagePath = public_path('resumes/' . $fileName);
        if (!file_exists($storagePath)) {
            throw new \Exception('File not found: ' . $storagePath);
        }

        /*
            Will use the following code when using external storage
        */
        // $pdfContent = file_get_contents($storagePath);
        // if ($pdfContent === false) {
        //     throw new \Exception(message: 'Failed to read local file: ' . $storagePath);
        // }
        // file_put_contents($tempFile, $pdfContent);

        // Check if pdf-to-text library is installed
        // Extract text from the pdf file
        try {
            $text = Pdf::getText($storagePath);
            return $text;
        } catch (\Spatie\PdfToText\Exceptions\PdfNotFound $e) {
            throw new \Exception('PDF to text conversion tool (pdftotext) is not installed or not found in system PATH. Error: ' . $e->getMessage());
        } catch (\Exception $e) {
            throw new \Exception('Failed to extract text from PDF: ' . $e->getMessage());
        }
    }

}