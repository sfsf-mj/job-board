<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="bg-black shadow-lg rounded-lg p-6 max-w-7xl max-auto">
            <h3 class="text-2xl text-white font-bold mb-6">
                {{ __('Welcome back,') }}
                <span class="text-blue-500">{{ Auth::user()->name }}</span>
            </h3>

            <!-- Search & Filters -->
            <div class="flex items-center flex-col gap-5 sm:flex-row sm:justify-between">
                <!-- Search Bar -->
                <form action="{{ route('dashboard') }}" method="get" class="flex items-center justify-center sm:w-1/4">
                    @if (request('filter'))
                        <input type="hidden" name="filter" value="{{ request('filter') }}">
                    @endif

                    <input type="text" value="{{ request('search') }}"
                        class="w-full p-2 rounded-l-lg bg-gray-800 text-white" placeholder="Search for a job"
                        name="search">
                    <button type="submit"
                        class="bg-indigo-500 text-white p-2 rounded-r-lg border border-indigo-500">Search</button>

                    @if (request('search'))
                        <a href="{{ route('dashboard', ['filter' => request('filter')]) }}"
                        class="bg-transparent text-indigo-400 border border-indigo-400 px-2 py-1 text-sm rounded-lg sm:text-lg ml-2">Clear</a>
                    @endif
                </form>

                <!-- Filters -->
                <div class="flex space-x-2">
                    <a href="{{ route('dashboard', ['filter' => 'FullTime', 'search' => request('search')]) }}"
                        class="bg-indigo-500 text-white p-2 text-sm rounded-lg sm:text-lg">Full-Time</a>
                    <a href="{{ route('dashboard', ['filter' => 'Remote', 'search' => request('search')]) }}"
                        class="bg-indigo-500 text-white p-2 text-sm rounded-lg sm:text-lg">Remote</a>
                    <a href="{{ route('dashboard', ['filter' => 'Hybrid', 'search' => request('search')]) }}"
                        class="bg-indigo-500 text-white p-2 text-sm rounded-lg sm:text-lg">Hybrid</a>
                    <a href="{{ route('dashboard', ['filter' => 'Contract', 'search' => request('search')]) }}"
                        class="bg-indigo-500 text-white p-2 text-sm rounded-lg sm:text-lg">Contract</a>

                    @if (request('filter'))
                        <a href="{{ route('dashboard', ['search' => request('search')]) }}"
                            class="bg-transparent text-indigo-400 border border-indigo-400 p-2 text-sm rounded-lg sm:text-lg">Clear</a>
                    @endif
                </div>

            </div>

            <!-- Job List -->
            <div class="space-y-4 mt-6">
                @forelse ($jobVacancies as $jobVacancy)
                    <!-- Job Item -->
                    <div class="border-b border-white/30 pb-4 flex justify-between items-center">
                        <div>
                            <a href="{{ route('job-vacancies.show', $jobVacancy->id) }}" 
                            class="text-lg font-semibold text-blue-400 hover:underline">{{ $jobVacancy->title }}</a>
                            <p class="text-sm text-white">{{ $jobVacancy->company->name }} | {{ $jobVacancy->location }}</p>
                            <p class="text-sm text-white">{{ '$' . number_format($jobVacancy->salary) }}/Year</p>
                            <p class="text-sm text-gray-500 pr-20">{{ $jobVacancy->description }}</p>
                        </div>
                        <span class=" bg-blue-500 text-white p-2 rounded-lg">{{ $jobVacancy->type }}</span>
                    </div>
                @empty
                    <p class="text-white w-full text-center border-b border-white/50 p-5">No job vacancies found.</p>
                @endforelse

                <div class="mt-10">
                    {{ $jobVacancies->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>