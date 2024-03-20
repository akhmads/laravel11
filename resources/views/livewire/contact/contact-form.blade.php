<?php

use Livewire\Volt\Component;
use Livewire\Attributes\On;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Subdistrict;

new class extends Component {

    public $set_id;
    public $name;
    public $address;
    public $email;
    public $phone;
    public $mobile;
    public $status;

    public function mount(Request $request)
    {
        $contact = Contact::Find($request->id);
        $this->set_id = $contact->id ?? '';
        $this->name = $contact->name ?? '';
        $this->address = $contact->address ?? '';
        $this->email = $contact->email ?? '';
        $this->phone = $contact->phone ?? '';
        $this->mobile = $contact->mobile ?? '';
        $this->status = $contact->status ?? '';
    }

    public function store()
    {
        if(empty($this->set_id))
        {
            $valid = $this->validate([
                'name' => 'required',
                'address' => '',
                'email' => '',
                'phone' => '',
                'mobile' => '',
                'status' => 'required',
            ]);

            $contact = Contact::create($valid);
            session()->flash('success', __('Contact has been saved'));
            $this->redirectRoute('master.contact.form', $contact->id);
        }
        else
        {
            $valid = $this->validate([
                'name' => 'required',
                'address' => '',
                'email' => '',
                'phone' => '',
                'mobile' => '',
                'status' => 'required',
            ]);

            $contact = Contact::find($this->set_id);
            $contact->update($valid);
            session()->flash('success', __('Contact has been saved'));
        }
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Contacts') }}
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
                        <x-hyco.label for="address" :value="__('Address')" class="mb-1" />
                        <x-hyco.textarea id="address" wire:model="address" class="w-full"></x-hyco.textarea>
                        <x-hyco.input-error class="mt-2" for="address" />
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <x-hyco.label for="email" :value="__('Email')" class="mb-1" />
                        <x-hyco.input id="email" wire:model="email" class="w-full" autofocus />
                        <x-hyco.input-error class="mt-2" for="email" />
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <x-hyco.label for="phone" :value="__('Phone')" class="mb-1" />
                        <x-hyco.input id="phone" wire:model="phone" class="w-full" autofocus />
                        <x-hyco.input-error class="mt-2" for="phone" />
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <x-hyco.label for="mobile" :value="__('Mobile')" class="mb-1" />
                        <x-hyco.input id="mobile" wire:model="mobile" class="w-full" autofocus />
                        <x-hyco.input-error class="mt-2" for="mobile" />
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <x-hyco.label :value="__('Status')" class="mb-1" />
                        <x-hyco.select wire:model="status" :options="['active'=>'active','inactive'=>'inactive']" class="w-full"></x-hyco.select>
                        <x-hyco.input-error class="mt-2" for="status" />
                    </div>

                </x-slot>

                <x-slot name="footer" class="justify-center">
                    <x-hyco.link href="{{ route('master.contact') }}" wire:navigate icon="x-mark" class="bg-yellow-500 hover:bg-yellow-400">Back</x-hyco.link>
                    <x-hyco.button wire:loading.attr="disabled" icon="check">Save</x-hyco.button>
                </x-slot>
            </x-hyco.section>

        </div>
    </div>
</div>
