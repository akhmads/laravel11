@props(['width' => '7xl'])

@php
$Width = 'max-w-7xl';
if ( $width == '7xl' ) $Width = 'max-w-7xl';
if ( $width == 'full' ) $Width = 'w-full';
@endphp

<div>
    <div {{ $attributes->merge(['class' => 'py-12']) }}>
        <div class="{{ $Width }} mx-auto sm:px-6 lg:px-8">
            {{ $slot }}
        </div>
    </div>
</div>
