@props(['url','active'])

@php
$classes = ($active ?? false)
            ? 'px-4 py-[5px] inline-flex items-center text-sm font-medium leading-5 text-gray-900 bg-gray-100 rounded transition duration-150 ease-in-out'
            : 'px-4 py-[5px] inline-flex items-center text-sm font-medium leading-5 text-gray-400 hover:text-gray-800 rounded transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot ?? '' }}
</a>
