<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Company') }}
            {{ request()->has('archived') && request()->input('archived') == 'true' ? '(Archived)' : '' }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">

        <div class="flex justify-end space-x-4 mb-4">

            @if(request()->has('archived') && request()->input('archived') == 'true')
                <!-- Active company Button -->
                <a href="{{ route('company.index') }}"
                    class="bg-gray-900 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Active
                </a>
            @else
                <!-- Archived company Button -->
                <a href="{{ route('company.index', ['archived' => 'true']) }}"
                    class="bg-gray-900 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Archived
                </a>
            @endif

            <!-- Create company Button -->
            <a href="{{ route('company.create') }}"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Add company
            </a>
        </div>

        <!-- company Table -->
        <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow mt-4 bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Address</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Industry</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Owner</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($companies as $company)
                    <tr class="border-b hover:bg-blue-50">
                        <td class="px-6 py-4 text-gray-800">
                            @if (request()->has('archived') && request()->input('archived') == 'true')
                                {{ $company->name }}
                            @else
                                <a href="{{ route('company.show', $company->id) }}"
                                    class="text-blue-500 hover:text-blue-700 underline">
                                    {{ $company->name }}
                                </a>

                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-800">{{ $company->address }}</td>
                        <td class="px-6 py-4 text-gray-800">{{ $company->industry }}</td>
                        <td class="px-6 py-4 text-gray-800">{{ $company->owner->name }}</td>
                        <td>
                            <div class="flex space-x-4">
                                @if(request()->has('archived') && request()->input('archived') == 'true')
                                    <!-- Restore Button -->
                                    <form action="{{ route('company.restore', $company->id) }}" method="POST"
                                        class="confirm-dialog-form inline"
                                        data-confirm-message="Are you sure do you want to restore?">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-green-500 hover:text-green-700">🔄 Restore</button>
                                    </form>
                                @else
                                    <!-- Edit Button -->
                                    <a href="{{ route('company.edit', ['company' => $company->id, 'redirectToList' => 'true']) }}"
                                        class="text-blue-500 hover:text-blue-700">✍️ Edit</a>

                                    <!-- Delete Button -->
                                    <form action="{{ route('company.destroy', $company->id) }}" method="POST"
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
                        <td colspan="2" class="px-6 py-4 text-gray-800">No Companies found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $companies->links() }}
        </div>

    </div>

</x-app-layout>