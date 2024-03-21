<?php

use Livewire\Volt\Component;
use Livewire\Attributes\On;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Subdistrict;

new class extends Component {

    public $set_id;
    public $name;
    public $status;

    public function mount(Request $request)
    {
        $item = Item::Find($request->id);
        $this->set_id = $item->id ?? '';
        $this->name = $item->name ?? '';
        $this->status = $item->status ?? '';
    }

    public function store()
    {
        if(empty($this->set_id))
        {
            $valid = $this->validate([
                'name' => 'required',
                'status' => 'required',
            ]);

            $item = Item::create($valid);
            session()->flash('success', __('Item has been saved'));
            $this->redirectRoute('master.item.form', $item->id);
        }
        else
        {
            $valid = $this->validate([
                'name' => 'required',
                'status' => 'required',
            ]);

            $item = Item::find($this->set_id);
            $item->update($valid);
            session()->flash('success', __('Item has been saved'));
        }
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Items') }}
        </h2>
    </x-slot>

    <x-hyco.flash-alert />
    <div wire:loading class="fixed top-0">
        <x-hyco.loading />
    </div>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            <x-hyco.section submit="store">
                <x-slot name="body">

                    <div class="col-span-6 sm:col-span-6">
                        <x-hyco.label for="name" :value="__('Name')" class="mb-1" />
                        <x-hyco.input id="name" wire:model="name" class="w-full" autofocus />
                        <x-hyco.input-error class="mt-2" for="name" />
                    </div>

                    <div class="col-span-6 sm:col-span-6">
                        <x-hyco.label :value="__('Status')" class="mb-1" />
                        <x-hyco.select wire:model="status" :options="['active'=>'active','inactive'=>'inactive']" class="w-full"></x-hyco.select>
                        <x-hyco.input-error class="mt-2" for="status" />
                    </div>

                </x-slot>

                <x-slot name="footer" class="justify-center">
                    <x-hyco.link href="{{ route('master.item') }}" wire:navigate icon="x-mark" class="bg-yellow-500 hover:bg-yellow-400">Back</x-hyco.link>
                    <x-hyco.button wire:loading.attr="disabled" icon="check">Save</x-hyco.button>
                </x-slot>
            </x-hyco.section>

        </div>
    </div>
</div>
