<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white dark:text-gray-200 leading-tight">
            {{ $jobVacancy->title }} - Apply
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="bg-black shadow-lg rounded-lg p-6 max-w-7xl max-auto">
            <a href="{{ route('job-vacancies.show', $jobVacancy->id) }}"
                class="text-blue-400 hover:underline mb-6 inline-block">
                Back to job details
            </a>

            <div class="border-b border-white/10 pb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-white">{{ $jobVacancy->title }}</h1>
                        <p class="text-md text-gray-400">{{ $jobVacancy->company->name }}</p>
                        <div class="flex items-center gap-2">
                            <p class="text-sm text-gray-400">{{ $jobVacancy->location }}</p>
                            <p class="text-sm text-gray-400">.</p>
                            <p class="text-sm text-gray-400">{{ '$' . number_format(num: $jobVacancy->salary) }}</p>
                            <p class="text-sm bg-indigo-500 text-white p-1 rounded-lg">{{ $jobVacancy->type }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('job-vacancies.apply', $jobVacancy->id) }}" class="space-y-4') }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <!-- This used to check if the user is already appled this job -->
                <input type="hidden" name="job_vacancy_id" value="{{ $jobVacancy->id }}">

                @if($errors->any())
                    <div class="alert alert-danger bg-red-900/15  border-red-500 border-l-4 p-4 mb-4">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li class="text-red-400">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Choose Existing Resume -->
                <div>
                    <h3 class="text-xl font-semibold text-white mb-4">Choose Your Resume</h3>
                    <div class="mb-6 space-y-4">
                        <x-input-label for="resume" value="Select from your existing resumes" />
                        <div class="space-y-4">

                            @php
                                $resume_error = $errors->first('resume_option') ? 'border-red-500' : 'border-gray-600';
                            @endphp

                            @forelse ($resumes as $resume)
                                <div class="flex items-center gap-2">
                                    <input type="radio" name="resume_option" id="{{ $resume->id }}"
                                        value="{{ $resume->id }}" />
                                    <div class="border-2 {{ $resume_error }} rounded-lg p-4 w-full">
                                        <label for="{{ $resume->id }}" class="text-white cursor-pointer">
                                            {{ $resume->file_name }}
                                            <span class="text-gray-400 text-sm">(Uploaded at:
                                                {{ $resume->created_at->format('d/m/Y') }})</span>
                                        </label>
                                    </div>

                                </div>
                            @empty
                                <span class="text-gray-400">No resumes found.</span>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Upload New Resume -->
                <div x-data="{ fileName: '', hasError: {{ $errors->has('resume_file') ? 'true' : 'false' }} }"
                    class="space-y-4">

                    <x-input-label for="new_resume" value="Or upload a new resume:" />

                    <div class="flex items-center">
                        <div class="flex items-center gap-2 w-full">

                            <input x-ref="newResumeRadio" type="radio" name="resume_option" id="new_resume"
                                value="new_resume" />

                            <label for="new_resume_file" class="block text-white cursor-pointer w-full">
                                <div class="border-2 border-dashed border-gray-600 rounded-lg p-4 hover:border-blue-500 transition"
                                    :class="{'border-blue-500': fileName, ' border-red-500': hasError }">
                                    <input
                                        @change="fileName = $event.target.files[0].name; $refs.newResumeRadio.checked = true"
                                        type="file" name="resume_file" id="new_resume_file" class="hidden"
                                        accept=".pdf" />
                                    <div class="text-center">
                                        <template x-if="!fileName">
                                            <p class="text-gray-400">Click to upload PDF (Max 5MB)</p>
                                        </template>
                                        <template x-if="fileName">
                                            <div>
                                                <p x-text="fileName" class="mt-2 text-blue-400"></p>
                                                <p class="text-gray-400 text-sm mt-3">Click to change file</p>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-4 ">
                    <x-primary-button class="mt-6 w-full">Submit Application</x-primary-button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>