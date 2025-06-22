@props(['application'])

@php
    $color = match($application) {
        'pending' => 'text-yellow-500',
        'accepted' => 'text-green-500',
        'rejected' => 'text-red-500',
        default => 'text-gray-500',
    };
@endphp

<span class="font-bold {{ $color }}">
    {{ $application }}
</span>
