<?php

use Livewire\Volt\Component;

new class extends Component {

    public $count = 0;

    public function increment()
    {
        $this->count++;
    }

    public function decrement()
    {
        $this->count--;
    }

}; ?>

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Counter') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 text-center">

                    <h1 class="text-xl mb-4">{{ $count }}</h1>
                    <x-primary-button wire:click="decrement">-</x-primary-button>
                    <x-primary-button wire:click="increment">+</x-primary-button>

                </div>
            </div>
        </div>
    </div>
</div>
