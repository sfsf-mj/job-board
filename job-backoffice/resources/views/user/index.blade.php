<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">

        <div class="flex justify-between space-x-4 mb-4">

            <form method="GET" action="{{ route('user.index') }}" x-data="{ search: '{{ request('search') }}' }"
                class="flex justify-start space-x-4">

                <input type="text" name="search" class="rounded" x-model="search"
                    @input.debounce.500ms="window.location.href = '{{ route('user.index') }}' + '?search=' + encodeURIComponent(search)"
                    placeholder="Search...">
            </form>


            @if(request()->has('archived') && request()->input('archived') == 'true')
                <!-- Active User Button -->
                <a href="{{ route('user.index') }}"
                    class="bg-gray-900 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Active
                </a>
            @else
                <!-- Archived User Button -->
                <a href="{{ route('user.index', ['archived' => 'true']) }}"
                    class="bg-gray-900 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Archived
                </a>
            @endif
        </div>

        <!-- User Table -->
        <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow mt-4 bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">ِName</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Email</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Role</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr class="border-b hover:bg-blue-50">
                        <td class="px-6 py-4 text-gray-800">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-gray-800">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-gray-800">{{ $user->role }}</td>
                        <td>
                            <div class="flex space-x-4">
                                @if(request()->has('archived') && request()->input('archived') == 'true')
                                    <!-- Restore Button -->
                                    <form action="{{ route('user.restore', $user->id) }}" method="POST"
                                        class="confirm-dialog-form inline"
                                        data-confirm-message="Are you sure do you want to restore?">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-green-500 hover:text-green-700">🔄 Restore</button>
                                    </form>
                                @else
                                    @if($user->role != 'admin')
                                        <!-- Edit Button -->
                                        <a href="{{ route('user.edit', ['user' => $user->id, 'redirectToList' => 'true']) }}"
                                            class="text-blue-500 hover:text-blue-700">✍️ Edit</a>

                                        <!-- Delete Button -->
                                        <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                            class="confirm-dialog-form inline"
                                            data-confirm-message="Are you sure do you want to archive?">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700">🗃️ Archive</button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-gray-800 text-center">No Users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $users->links() }}
        </div>

    </div>

</x-app-layout>