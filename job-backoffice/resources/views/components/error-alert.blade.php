{{--

    This component is used to display error messages in a consistent format.
    It checks if there are any errors and displays them in a styled alert box.

    To usage it, simply include the component in your Blade view like this:
    <x-error-alert />

--}}

@if ($errors->any())
    <div class="mt-4 mb-8">
        <div class="bg-red-50 border-l-4 border-red-400 p-4">
            <h3 class="text-sm/6 font-medium text-red-800">Whoops! Something went wrong.</h3>
            <ul class="mt-2 text-sm/6 text-red-700 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
