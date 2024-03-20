@props(['width' => '7xl'])

@php
$Width = 'max-w-7xl';
if ( $width == '7xl' ) $Width = 'max-w-7xl';
if ( $width == '6xl' ) $Width = 'max-w-6xl';
if ( $width == '5xl' ) $Width = 'max-w-5xl';
if ( $width == 'full' ) $Width = 'w-full';
@endphp

<div>
    <div {{ $attributes->merge(['class' => 'py-12']) }}>
        <div class="{{ $Width }} mx-auto sm:px-6 lg:px-8 lg:flex items-start justify-between gap-6">

            @isset($left)
            <div wire:ignore {{ $left->attributes->merge(['class' => 'shrink lg:w-[280px] space-y-4 lg:sticky lg:top-5']) }}>
                {{ $left }}
            </div>
            @endisset

            <div {{ $slot->attributes->merge(['class' => 'grow mt-6 lg:mt-0']) }}>
                {{ $slot }}
            </div>

            @isset($right)
            <div wire:ignore {{ $right->attributes->merge(['class' => 'shrink lg:w-[280px] space-y-4 lg:sticky lg:top-5']) }}>
                {{ $right }}
            </div>
            @endisset

        </div>
    </div>
</div>
