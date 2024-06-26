<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;
use Illuminate\Support\Carbon;
use Akhmads\Hyco\Traits\Toast;
use App\Models\Item;

new class extends Component {
    use Toast;

    #[Rule('required')]
    public string $name = 'John Doe';

    #[Rule('required')]
    public string $user_id = '1';

    public function with(): array
    {
        return [];
    }

    public function store()
    {
        $data = $this->validate();

        $this->success('/play', 'Saved');
    }
} ?>
<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Playground') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <x-hc-input label="Name" wire:model="name" />
                    <x-hc-select label="User" wire:model="user_id" :options="\App\Models\User::get()->pluck('name','id')" />

                    <div class="pt-5">
                        <x-hc-button type="button" wire:click="store" icon="o-check" spinner="store">Save</x-hc-button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
