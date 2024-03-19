<?php

use Livewire\Volt\Component;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

new class extends Component {

    public $set_id;
    public $name;
    public $email;
    public $password;

    public function mount(Request $request)
    {
        $user = User::member()->where('id', $request->id)->first();
        $this->set_id = $user->id ?? '';
        $this->name = $user->name ?? '';
        $this->email = $user->email ?? '';
    }

    public function store()
    {
        if(empty($this->set_id))
        {
            $valid = $this->validate([
                'name' => 'required',
                'email' => ['required', 'email', 'max:200', Rule::unique('users')],
                'password' => ['required','string','min:8'],
            ]);

            $valid['password'] = Hash::make($this->password);
            $valid['role'] = 'member';
            $User = User::create($valid);
            session()->flash('success', __('User has been saved'));
            $this->redirectRoute('user.member.form', $User->id);
        }
        else
        {
            $valid = $this->validate([
                'name' => 'required',
                'email' => ['required', 'email', 'max:200', Rule::unique('users')->ignore($this->set_id)],
                'password' => ['nullable','string','min:8'],
            ]);

            if ( empty($this->password) ) {
                unset($valid['password']);
            } else {
                $valid['password'] = Hash::make($this->password);
            }

            User::member()->where('id', $this->set_id)->update($valid);
            session()->flash('success', __('User has been saved'));
        }
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User / Member') }}
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
                        <x-hyco.label for="name" :value="__('Full Name')" class="mb-1" />
                        <x-hyco.input id="name" wire:model="name" class="w-full" autofocus />
                        <x-hyco.input-error class="mt-2" for="name" />
                    </div>

                    <div class="col-span-6 sm:col-span-6">
                        <x-hyco.label for="email" :value="__('Email')" class="mb-1" />
                        <x-hyco.input id="email" wire:model="email" class="w-full" />
                        <x-hyco.input-error class="mt-2" for="email" />
                    </div>

                    <div class="col-span-6 sm:col-span-6">
                        <x-hyco.label for="password" :value="__('Password')" class="mb-1" />
                        <x-hyco.input type="password" id="password" wire:model="password" class="w-full" />
                        <x-hyco.input-error class="mt-2" for="password" />
                    </div>

                </x-slot>

                <x-slot name="footer" class="justify-center">
                    <x-hyco.link href="{{ route('user.member') }}" wire:navigate icon="x-mark" class="bg-yellow-500 hover:bg-yellow-400">Back</x-hyco.link>
                    <x-hyco.button wire:loading.attr="disabled" icon="check">Save</x-hyco.button>
                </x-slot>
            </x-hyco.section>

        </div>
    </div>
</div>
