@props([
    'color',
])

<x-button
    class="text-white bg-{{ $color }}-700 active:bg-{{ $color }}-800 hover:bg_{{ $color }}-800" {{ $attributes }}>
    {{ $slot }}
</x-button>


