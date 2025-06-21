<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Job Category') }}
            {{ request()->has('archived') && request()->input('archived') == 'true' ? '(Archived)' : '' }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">

        <div class="flex justify-end space-x-4 mb-4">

            @if(request()->has('archived') && request()->input('archived') == 'true')
                <!-- Active Job Category Button -->
                <a href="{{ route('job-category.index') }}"
                    class="bg-gray-900 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Active
                </a>
            @else
                <!-- Archived Job Category Button -->
                <a href="{{ route('job-category.index', ['archived' => 'true']) }}"
                    class="bg-gray-900 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Archived
                </a>
            @endif

            <!-- Create Job Category Button -->
            <a href="{{ route('job-category.create') }}"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Add Job Category
            </a>
        </div>

        <!-- Job Category Table -->
        <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow mt-4 bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Category Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr class="border-b hover:bg-blue-50">
                        <td class="px-6 py-4 text-gray-800">{{ $category->name }}</td>
                        <td>
                            <div class="flex space-x-4">
                                @if(request()->has('archived') && request()->input('archived') == 'true')
                                    <!-- Restore Button -->
                                    <form action="{{ route('job-category.restore', $category->id) }}" method="POST"
                                        class="confirm-dialog-form inline"
                                        data-confirm-message="Are you sure do you want to restore?">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-green-500 hover:text-green-700">🔄 Restore</button>
                                    </form>
                                @else
                                    <!-- Edit Button -->
                                    <a href="{{ route('job-category.edit', $category->id) }}"
                                        class="text-blue-500 hover:text-blue-700">✍️ Edit</a>

                                    <!-- Delete Button -->
                                    <form action="{{ route('job-category.destroy', $category->id) }}" method="POST"
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
                        <td colspan="2" class="px-6 py-4 text-gray-800">No job categories found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $categories->links() }}
        </div>

    </div>

</x-app-layout>