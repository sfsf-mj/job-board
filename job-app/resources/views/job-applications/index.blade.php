<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="bg-black shadow-lg rounded-lg p-6 max-w-7xl max-auto space-y-4">
            @forelse($jobApplications as $jobApplication)
                <div class="bg-gray-800 p-4 rounded-lg">
                    <h3 class="text-white text-lg font-bold">{{ $jobApplication->jobVacancy->title }}</h3>
                    <p class="text-sm">{{ $jobApplication->jobVacancy->company->name }}</p>
                    <p class="text-xs">{{ $jobApplication->jobVacancy->location }}</p>

                    <div class="flex items-center justify-between">
                        <p class="text-sm">{{ $jobApplication->created_at->format('d M Y') }}</p>
                        <p class="px-3 py-1 bg-blue-600 text-white rounded-md">{{ $jobApplication->jobVacancy->type }}</p>
                    </div>

                    <div class="flex items-center gap-2">
                        <span>Applied With: {{ $jobApplication->resume->file_name }}</span>
                        <a href="{{ public_path('resumes') . '/' . $jobApplication->resume->file_name }}"
                            target="_blank" class="text-indigo-500 hover:text-indigo-600 underline">View Resume</a>
                    </div>

                    <div class="flex flex-start flex-col gap-2 mt-4">
                        <div class="flex items-center gap-2">
                            @php
                                $status = $jobApplication->status;
                                $statusColor = match($status){
                                    'pending' => 'bg-yellow-500',
                                    'accepted' => 'bg-green-500',
                                    'rejected' => 'bg-red-500',
                                };
                            @endphp
                            <p class="text-sm {{ $statusColor }} text-white font-bold bg-gray-800  p-2 rounded-md w-fit">Status: {{ $jobApplication->status }}</p>
                            <p class="text-sm bg-indigo-600 text-white p-2 rounded-md w-fit">Score:
                                {{ $jobApplication->aiGeneratedScore }}
                            </p>
                        </div>
                        <div class="">
                            <p class="text-md font-bold">AI Feedback:</p>
                            {{ $jobApplication->aiGeneratedFeedback }}
                        </div>
                    </div>
                </div>
            @empty
                    <div class="bg-gray-800 p-4 rounded-lg">
                        <p class="text-gray-400">No job applications found.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $jobApplications->links() }}
            </div>
        </div>
</x-app-layout>