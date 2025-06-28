<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Job Application') }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">

        <div class="flex justify-between space-x-4 mb-4">

            <form method="GET" action="{{ route('job-application.index') }}"
                x-data="{ search: '{{ request('search') }}' }" class="flex justify-start space-x-4">

                <input type="text" name="search" class="rounded" x-model="search"
                    @input.debounce.500ms="window.location.href = '{{ route('job-application.index') }}' + '?search=' + encodeURIComponent(search)"
                    placeholder="Search...">
            </form>


            @if(request()->has('archived') && request()->input('archived') == 'true')
                <!-- Active Job Application Button -->
                <a href="{{ route('job-application.index') }}"
                    class="bg-gray-900 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Active
                </a>
            @else
                <!-- Archived Job Application Button -->
                <a href="{{ route('job-application.index', ['archived' => 'true']) }}"
                    class="bg-gray-900 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Archived
                </a>
            @endif
        </div>

        <!-- Job Application Table -->
        <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow mt-4 bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">ِApplicant Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Job Title</th>
                    @if (auth()->guard()->user()->role == "admin")
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Company</th>
                    @endif
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($jobApplications as $application)
                    <tr class="border-b hover:bg-blue-50">
                        <td class="px-6 py-4 text-gray-800">
                            @if (request()->has('archived') && request()->input('archived') == 'true')
                                {{ $application->user->name }}
                            @else
                                <a href="{{ route('job-application.show', $application->id) }}"
                                    class="text-blue-500 hover:text-blue-700 underline">
                                    {{ $application->user->name }}
                                </a>

                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-800">{{ $application->jobVacancy?->title ?? 'N/A' }}</td>

                        @if (auth()->guard()->user()->role == "admin")
                            <td class="px-6 py-4 text-gray-800">{{ $application->jobVacancy?->company->name ?? 'N/A' }}</td>
                        @endif
                        
                        <td class="px-6 py-4 text-gray-800"><x-job-application-status
                                application="{{ $application->status }}" /></td>
                        <td>
                            <div class="flex space-x-4">
                                @if(request()->has('archived') && request()->input('archived') == 'true')
                                    <!-- Restore Button -->
                                    <form action="{{ route('job-application.restore', $application->id) }}" method="POST"
                                        class="confirm-dialog-form inline"
                                        data-confirm-message="Are you sure do you want to restore?">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-green-500 hover:text-green-700">🔄 Restore</button>
                                    </form>
                                @else
                                    <!-- Edit Button -->
                                    <a href="{{ route('job-application.edit', ['job_application' => $application->id, 'redirectToList' => 'true']) }}"
                                        class="text-blue-500 hover:text-blue-700">✍️ Edit</a>

                                    <!-- Delete Button -->
                                    <form action="{{ route('job-application.destroy', $application->id) }}" method="POST"
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
                        <td colspan="5" class="px-6 py-4 text-gray-800 text-center">No job applications found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $jobApplications->links() }}
        </div>

    </div>

</x-app-layout>