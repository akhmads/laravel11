<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Rule;
use Akhmads\Hyco\Traits\Toast;
use App\Models\Example;

new class extends Component {
    use Toast;

    #[Rule('required')]
    public ?string $name;

    #[Rule('nullable|email|unique:example')]
    public ?string $email;

    #[Rule('nullable')]
    public ?string $date;

    #[Rule('nullable')]
    public ?string $address;

    #[Rule('nullable')]
    public ?string $price;

    #[Rule('nullable')]
    public string $user_id;

    public function with(): array
    {
        return [];
    }

    public function store()
    {
        $data = $this->validate();

        Example::create($data);

        $this->success('/play', 'Example has been created');
    }
} ?>
<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Example') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <x-hc-input label="Name" wire:model="name" />
                    <x-hc-input label="Email" wire:model="email" type="email" />
                    <x-hc-input label="Date" wire:model="date" type="date" />
                    <x-hc-textarea label="Address" wire:model="address" />
                    <x-hc-input label="Price" wire:model="price" />
                    <x-hc-select label="User" wire:model="user_id" :options="\App\Models\User::get()->pluck('name','id')" />

                    <div class="pt-5">
                        <x-hc-button type="button" wire:click="store" icon="o-check" spinner="store">Save</x-hc-button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
