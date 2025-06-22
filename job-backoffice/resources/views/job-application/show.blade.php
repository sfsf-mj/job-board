<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $jobApplication->user->name }} | Applied to {{ $jobApplication->jobVacancy->title }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">

        <!-- Back button -->
        <div class="mb-6">
            <a href="{{ route('job-application.index') }}"
                class="bg-gray-200 text-gray-800 hover:bg-gray-300 px-4 py-2 rounded-md"> ← Back
            </a>
        </div>

        <div class="w-full mx-auto p-6 bg-white rounded-lg shadow">

            <!-- Job Application Details -->
            <div>
                <h3 class="text-lg font-bold">Application Details</h3>
                <p><strong>Applicant:</strong> {{ $jobApplication->user->name }}</p>
                <p><strong>Job Title:</strong> {{ $jobApplication->jobVacancy->title }}</p>
                <p><strong>Company:</strong> {{ $jobApplication->jobVacancy->company->name }}</p>
                <p><strong>Status:</strong> <x-job-application-status application="{{ $jobApplication->status }}" /> </p>
                <p><strong>Resume:</strong> <a class="text-blue-500 hover:text-blue-700 underline"
                        href="{{ $jobApplication->resume->file_Uri }}" targer="_blank">{{ $jobApplication->resume->file_Uri }}</a></p>
            </div>

            <!-- Edit and Archive Buttons -->
            <div class="flex justify-end space-x-4 mb-6">
                <a href="{{ route('job-application.edit', $jobApplication->id) }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Edit</a>
                <form action=" {{ route('job-application.destroy', $jobApplication->id) }}" method="POST"
                    class="inline-block confirm-dialog-form" data-confirm-message="Are you sure do you want to archive?">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">Archive</button>
                </form>
            </div>

            <!-- Tabs Navigation -->
            <div class=" mb-6">
                <ul class="flex space-x-4">
                    <li>
                        <a href="{{ route('job-application.show', [$jobApplication->id, 'tab' => 'resume']) }}"
                            class="px-4 py-2 text-gray-800 font-semibold {{ request('tab') == 'resume' || request('tab') == null ? 'border-b-2 border-blue-500' : '' }}">Resume</a>
                    </li>
                    <li>
                        <a href="{{ route('job-application.show', [$jobApplication->id, 'tab' => 'AIfeedback']) }}"
                            class="px-4 py-2 text-gray-800 font-semibold {{ request('tab') == 'AIfeedback' ? 'border-b-2 border-blue-500' : '' }}">AI Feedback</a>
                    </li>
                </ul>
            </div>

            <!-- Tab Content -->
            <div>

                <!-- Resume Tab -->
                <div id="jobs" class="{{ request('tab') == 'resume' || request('tab') == '' ? 'block' : 'hidden' }}">
                    <table class="min-w-full bg-gray-50 rounded-lg shadow">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 text-left bg-gray-100 rounded-tl-lg">Summary</th>
                                <th class="py-2 px-4 text-left bg-gray-100 rounded-tr-lg">Skills</th>
                                <th class="py-2 px-4 text-left bg-gray-100 rounded-tr-lg">Experience</th>
                                <th class="py-2 px-4 text-left bg-gray-100 rounded-tr-lg">Education</th>
                            </tr>
                        </thead>
                        <tbody>
                            <td class="py-2 px-4">{{ $jobApplication->resume->summary }}</td>
                            <td class="py-2 px-4">{{ $jobApplication->resume->skills }}</td>
                            <td class="py-2 px-4">{{ $jobApplication->resume->experience }}</td>
                            <td class="py-2 px-4">{{ $jobApplication->resume->education }}</td>
                        </tbody>
                    </table>
                </div>

                <!-- Applications Tab -->
                <div id="applications" class="{{ request('tab') == 'AIfeedback' ? 'block' : 'hidden' }}">
                    <table class="min-w-full bg-gray-50 rounded-lg shadow">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 text-left bg-gray-100 rounded-tl-lg">AI Score</th>
                                <th class="py-2 px-4 text-left bg-gray-100 rounded-tr-lg">Feedback</th>
                            </tr>
                        </thead>
                        <tbody>
                            <td class="py-2 px-4">{{ $jobApplication->aiGeneratedScore }}</td>
                            <td class="py-2 px-4">{{ $jobApplication->aiGeneratedFeedback }}</td>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>