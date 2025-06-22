<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $jobVacancy->title }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">

        <!-- Back button -->
        <div class="mb-6">
            <a href="{{ route('job-vacancy.index') }}"
                class="bg-gray-200 text-gray-800 hover:bg-gray-300 px-4 py-2 rounded-md"> ← Back
            </a>
        </div>

        <div class="w-full mx-auto p-6 bg-white rounded-lg shadow">

            <!-- Company Details -->
            <div>
                <h3 class="text-lg font-bold">Job Vacancy Information</h3>
                <p><strong>Titel</strong>: {{ $jobVacancy->title }}</p>
                <p><strong>Type</strong>: {{ $jobVacancy->type }}</p>
                <p><strong>Views</strong>: {{ $jobVacancy->view_count }}</p>
                <p><strong>Salary</strong>: ${{ number_format($jobVacancy->salary, 2) }}</p>
                <p><strong>Location</strong>: {{ $jobVacancy->location }}</p>
                <p><strong>Company</strong>: {{ $jobVacancy->company->name }}</p>
                <p><strong>Job Category</strong>: {{ $jobVacancy->jobCategory->name }}</p>
                <p><strong>Required Skills</strong>: {{ $jobVacancy->required_skills }}</p>
                <p><strong>Description</strong>: {{ $jobVacancy->description }}</p>
            </div>

            <!-- Edit and Archive Buttons -->
            <div class="flex justify-end space-x-4 mb-6">
                <a href="{{ route('job-vacancy.edit', $jobVacancy->id) }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Edit</a>
                <form action=" {{ route('job-vacancy.destroy', $jobVacancy->id) }}" method="POST"
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
                        <a href="{{ route('job-vacancy.show', [$jobVacancy->id, 'tab' => 'applications']) }}"
                            class="px-4 py-2 text-gray-800 font-semibold {{ request('tab') == 'applications' || request('tab') == null ? 'border-b-2 border-blue-500' : '' }}">Applications</a>
                    </li>
                </ul>
            </div>

            <!-- Tab Content -->
            <div>

                <!-- Applications Tab -->
                <div id="applications" class="{{ request('tab') == 'applications' || request('tab') == null ? 'block' : 'hidden' }}">
                    <table class="min-w-full bg-gray-50 rounded-lg shadow">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 text-left bg-gray-100 rounded-tl-lg">Applicant Name</th>
                                <th class="py-2 px-4 text-left bg-gray-100 rounded-tr-lg">Job Title</th>
                                <th class="py-2 px-4 text-left bg-gray-100 rounded-tr-lg">Status</th>
                                <th class="py-2 px-4 text-left bg-gray-100 rounded-tr-lg">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jobVacancy->JobApplications as $application)
                                <tr>
                                    <td class="py-2 px-4">{{ $application->user->name }}</td>
                                    <td class="py-2 px-4">{{ $application->jobVacancy->title }}</td>
                                    <td class="py-2 px-4">{{ $application->status }}</td>
                                    <td class="py-2 px-4">
                                        <a href="{{ route('job-application.show', $application->id) }}"
                                            class="text-blue-500 hover:text-blue-700 underline">View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-2 px-4 text-gray-800">No applications found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>