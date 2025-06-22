<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Applicant Status') }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md">
            <!-- Requist error messages -->
            <x-error-alert />

            <!-- Create form -->
            <form action="{{ route('job-application.update', ['job_application' => $jobApplication->id, 'redirectToList' => request('redirectToList')]) }}" class="w-full max-w-lg') }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Job Application Details -->
                <div class="mb-4 p-6 bg-gray-50 border border-gray-100 rounded-lg shadow-sm">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Company Details</h3>

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Applicant Name</label>
                        <p class="text-gray-400 block w-full rounded-md shadow-sm">{{ $jobApplication->user->name }}</p>
                    </div>

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Job Title</label>
                        <p class="text-gray-400 block w-full rounded-md shadow-sm">{{ $jobApplication->jobVacancy->title }}</p>
                    </div>

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Company</label>
                        <p class="text-gray-400 block w-full rounded-md shadow-sm">{{ $jobApplication->jobVacancy->company->name }}</p>
                    </div>

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">AI Generated Score</label>
                        <p class="text-gray-400 block w-full rounded-md shadow-sm">{{ $jobApplication->aiGeneratedScore }}</p>
                    </div>

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">AI Generated Feedback</label>
                        <p class="text-gray-400 block w-full rounded-md shadow-sm">{{ $jobApplication->aiGeneratedFeedback }}</p>
                    </div>

                    <!-- 'pending', 'accepted', 'rejected' -->
                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" id="status"
                            class="{{ $errors->has('status') ? 'border-red-500' : 'border-gray-300' }} mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Select Status</option>
                            <option value="pending" {{ old('status', $jobApplication->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="accepted" {{ old('status', $jobApplication->status) == 'accepted' ? 'selected' : '' }}>Accepted</option>
                            <option value="rejected" {{ old('status', $jobApplication->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Action buttons -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('job-application.index') }}"
                        class="px-4 py-2 rounded-md text-gray-500 hover:text-gray-700">
                        Cancel
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus: outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>