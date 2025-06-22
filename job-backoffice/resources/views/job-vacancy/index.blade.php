<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Job Vacancies') }}
            {{ request()->has('archived') && request()->input('archived') == 'true' ? '(Archived)' : '' }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">

        <div class="flex justify-end space-x-4 mb-4">

            @if(request()->has('archived') && request()->input('archived') == 'true')
                <!-- Active Job Vacancy Button -->
                <a href="{{ route('job-vacancy.index') }}"
                    class="bg-gray-900 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Active
                </a>
            @else
                <!-- Archived Job Vacancy Button -->
                <a href="{{ route('job-vacancy.index', ['archived' => 'true']) }}"
                    class="bg-gray-900 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Archived
                </a>
            @endif

            <!-- Create Job Vacancy Button -->
            <a href="{{ route('job-vacancy.create') }}"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Add Job Vacancy
            </a>
        </div>

        <!-- Job Vacancy Table -->
        <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow mt-4 bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Title</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Location</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Salary</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Type</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Required Skills</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">View Count</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Company</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Job Category</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($jobVacancies as $jobVacancy)
                    <tr class="border-b hover:bg-blue-50">
                        <td class="px-6 py-4 text-gray-800">
                            @if (request()->has('archived') && request()->input('archived') == 'true')
                                {{ $jobVacancy->title }}
                            @else
                                <a href="{{ route('job-vacancy.show', $jobVacancy->id) }}"
                                    class="text-blue-500 hover:text-blue-700 underline">
                                    {{ $jobVacancy->title }}
                                </a>

                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-800">{{ $jobVacancy->location }}</td>
                        <td class="px-6 py-4 text-gray-800"> ${{ number_format($jobVacancy->salary, 2) }}</td>
                        <td class="px-6 py-4 text-gray-800">{{ $jobVacancy->type }}</td>
                        <td class="px-6 py-4 text-gray-800">{{ $jobVacancy->required_skills }}</td>
                        <td class="px-6 py-4 text-gray-800">{{ $jobVacancy->view_count }}</td>
                        <td class="px-6 py-4 text-gray-800">{{ $jobVacancy->company->name }}</td>
                        <td class="px-6 py-4 text-gray-800">{{ $jobVacancy->jobCategory->name }}</td>
                        <td>
                            <div class="flex space-x-4">
                                @if(request()->has('archived') && request()->input('archived') == 'true')
                                    <!-- Restore Button -->
                                    <form action="{{ route('job-vacancy.restore', $jobVacancy->id) }}" method="POST"
                                        class="confirm-dialog-form inline"
                                        data-confirm-message="Are you sure do you want to restore?">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-green-500 hover:text-green-700">🔄 Restore</button>
                                    </form>
                                @else
                                    <!-- Edit Button -->
                                    <a href="{{ route('job-vacancy.edit', ['job_vacancy' => $jobVacancy->id, 'redirectToList' => 'true']) }}"
                                        class="text-blue-500 hover:text-blue-700">✍️ Edit</a>

                                    <!-- Delete Button -->
                                    <form action="{{ route('job-vacancy.destroy', $jobVacancy->id) }}" method="POST"
                                        class="confirm-dialog-form inline"
                                        data-confirm-message="Are you sure do you want to archive?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700">🗃️ Archive</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="px-6 py-4 text-gray-800">No jobVacancies found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $jobVacancies->links() }}
        </div>

    </div>

</x-app-layout>