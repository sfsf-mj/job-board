<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white dark:text-gray-200 leading-tight">
            {{ $jobVacancy->title }} - Job Details
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="bg-black shadow-lg rounded-lg p-6 max-w-7xl max-auto">
            <a href="{{ route(name: 'dashboard') }}"
                class="text-blue-400 border-2 border-blue-400 px-2 py-1 rounded-lg hover:bg-blue-400/30 mb-6 inline-block">
                Back
            </a>

            <div class="border-b border-white/10 pb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-white">{{ $jobVacancy->title }}</h1>
                        <p class="text-md text-gray-400">{{ $jobVacancy->company->name }}</p>
                        <div class="flex items-center gap-2">
                            <p class="text-sm text-gray-400">{{ $jobVacancy->location }}</p>
                            <p class="text-lg text-gray-400">•</p>
                            <p class="text-sm text-gray-400">{{ '$' . number_format(num: $jobVacancy->salary) }}</p>
                            <p class="text-lg text-gray-400">•</p>
                            <p class="text-sm text-indigo-500 font-bold p-1 rounded-lg">{{ $jobVacancy->type }}</p>
                        </div>
                        @if ($checkApply)
                            <p class="flex items-center justify-end text-lg font-semibold text-yellow-400 mt-4">
                                You have already applied for this job</p>
                        @endif
                    </div>
                    <div>
                        @if (!$checkApply)
                            <a href="{{ route(name: 'job-vacancies.apply', parameters: $jobVacancy->id) }}"
                                class="justify-center bg-gradient-to-r from-indigo-500 to-rose-500 text-white py-2 px-4 rounded-lg transition hover:from-indigo-600 hover:to-rose-600">
                                Apply Now</a>
                        @endif
                    </div>
                </div>

            </div>

            <div class="grid grid-cols-3 gap-4 mt-6">
                <div class="col-span-2">
                    <h2 class="text-lg font-bold text-white mb-2">Job Description</h2>
                    <p class="text-gray-400">{{ $jobVacancy->description }}</p>
                </div>

                <div class="col-span-1">
                    <h2 class="text-lg font-bold text-white mb-2">Job Overview</h2>
                    <div class="bg-gray-900 rounded-lg p-6 space-y-4">
                        <div>
                            <p class=" text-gray-400">Published At</p>
                            <p class="text-white">{{ $jobVacancy->created_at->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class=" text-gray-400">Company</p>
                            <p class="text-white">{{ $jobVacancy->company->name }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400">Location</p>
                            <p class="text-white">{{ $jobVacancy->location }}</p>
                        </div>
                        <div>
                            <p class=" text-gray-400">Salary</p>
                            <p class="text-white">{{ '$' . number_format(num: $jobVacancy->salary) }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400">Type</p>
                            <p class="text-white">{{ $jobVacancy->type }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400">Category</p>
                            <p class="text-white">{{ $jobVacancy->jobCategory->name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>