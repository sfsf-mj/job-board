<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Job Vacancy') }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md">
            <!-- Requist error messages -->
            <x-error-alert />

            <!-- Create form {{ route('job-vacancy.store') }} -->
            <form action="{{ route('job-vacancy.update', ['job_vacancy' => $jobVacancy->id, 'redirectToList' => request('redirectToList')]) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Job Vacancy Details -->
                <div class="mb-4 p-6 bg-gray-50 border border-gray-100 rounded-lg shadow-sm">
                    <h3 class="text-lg font-bold text-gray-800">Job Vacancy Details</h3>
                    <p class="text-sm mb-4 text-gray-600">Enter the Job Vacancy Details.</p>

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $jobVacancy->title) }}"
                            class="{{ $errors->has('title') ? 'border-red-500' : 'border-gray-300' }} mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('title')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                        <input type="text" name="location" id="location" value="{{ old('location', $jobVacancy->location) }}"
                            class="{{ $errors->has('location') ? 'border-red-500' : 'border-gray-300' }} mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('location')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="salary" class="block text-sm font-medium text-gray-700">Salary</label>
                        <input type="number" name="salary" id="salary" value="{{ old('salary', $jobVacancy->salary) }}"
                            class="{{ $errors->has('salary') ? 'border-red-500' : 'border-gray-300' }} mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('salary')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                        <!-- 'FullTime', 'Contract', 'Remote', 'Hybrid' -->
                        <select name="type" id="type"
                            class="{{ $errors->has('type') ? 'border-red-500' : 'border-gray-300' }} mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Select a type</option>
                            <option value="FullTime" {{ old('type', $jobVacancy->type) == 'FullTime' ? 'selected' : '' }}>Full Time</option>
                            <option value="Contract" {{ old('type', $jobVacancy->type) == 'Contract' ? 'selected' : '' }}>Contract</option>
                            <option value="Remote" {{ old('type', $jobVacancy->type) == 'Remote' ? 'selected' : '' }}>Remote</option>
                            <option value="Hybrid" {{ old('type', $jobVacancy->type) == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                        </select>
                        @error('type')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- If the login user has Admin role -->
                    @if(Auth::user()->role == 'admin')
                        <div class="mb-4">
                            <label for="company_id" class="block text-sm font-medium text-gray-700">Company</label>
                            <select name="company_id" id="company_id"
                                class="{{ $errors->has('company_id') ? 'border-red-500' : 'border-gray-300' }} mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Select a company</option>
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}" {{ old('company_id', $jobVacancy->company_id) == $company->id ? 'selected' : '' }}>
                                        {{ $company->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('company_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message ?? 'Company ID error' }}</p>
                            @enderror
                        </div>
                    @else
                        <input type="hidden" name="company_id" value="{{ Auth::user()->company->id ?? '' }}">
                    @endif

                    <div class="mb-4">
                        <label for="job_category_id" class="block text-sm font-medium text-gray-700">Job Category</label>
                        <select name="job_category_id" id="job_category_id"
                            class="{{ $errors->has('job_category_id') ? 'border-red-500' : 'border-gray-300' }} mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Select a job category</option>
                            @foreach ($jobCategories as $jobCategory)
                                <option value="{{ $jobCategory->id }}"
                                    {{ old('job_category_id', $jobVacancy->job_category_id) == $jobCategory->id ? 'selected' : '' }}>
                                    {{ $jobCategory->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('job_category_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="description" rows="4"
                            class="{{ $errors->has('description') ? 'border-red-500' : 'border-gray-300' }} mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            {{ old('description', $jobVacancy->description) }}
                        </textarea>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="required_skills" class="block text-sm font-medium text-gray-700">Required Skills</label>
                        <textarea name="required_skills" id="required_skills" rows="4"
                            class="{{ $errors->has('required_skills') ? 'border-red-500' : 'border-gray-300' }} mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            {{ old('required_skills', $jobVacancy->required_skills) }}
                        </textarea>
                        @error('required_skills')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Action buttons -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('job-vacancy.index') }}"
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