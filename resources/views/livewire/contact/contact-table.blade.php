<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Models\Contact;

new class extends Component {
    use WithPagination;

    public $perPage = 10;
    public $sortColumn = "name";
    public $sortDir = "asc";
    public $sortLink = [];
    public $searchKeyword = '';
    public $confirmDeletion = false;
    public $set_id;

    public function with(): array
    {
        $contact = Contact::orderby($this->sortColumn,$this->sortDir)
            ->select('contact.*')
            ->where(function($query){
                $query->whereLike('contact.name', $this->searchKeyword);
            });

        return [ 'contacts' => $contact->paginate($this->perPage) ];
    }

    public function mount()
    {
        $this->sortLink[$this->sortColumn] = $this->sortDir;
    }

    public function updated()
    {
        $this->resetPage();
    }

    public function sortOrder($columnName)
    {
        $this->sortColumn = $columnName;
        $this->sortDir = ($this->sortDir == 'asc') ? 'desc' : 'asc';
        $this->sortLink = [];
        $this->sortLink[$columnName] = $this->sortDir;
    }

    public function delete($id)
    {
        $this->confirmDeletion = true;
        $this->set_id = $id;
    }

    public function destroy()
    {
        Contact::destroy($this->set_id);
        $this->confirmDeletion = false;
        session()->flash('success', __('Contact has been deleted'));
        return redirect()->route('master.contact');
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Master / Contact') }}
        </h2>
    </x-slot>

    <x-hyco.flash-alert />
    <div wire:loading class="fixed top-0">
        <x-hyco.loading />
    </div>

    <x-master-section>

        <x-hyco.table>
            <x-slot name="headingLeft">
                <x-hyco.table-perpage wire:model.live="perPage" :data="[10,25,50,100]" :value="$perPage" :span="1" />
                <x-hyco.table-search wire:model.live.debounce.300ms="searchKeyword" :span="4" />
            </x-slot>

            <x-slot name="headingRight">
                <x-hyco.link wire:navigate href="{{ route('master.contact.form',0) }}" icon="plus" class="scale-90">
                    Create
                </x-hyco.link>
            </x-slot>

            <x-slot name="header">
                <tr>
                    <x-hyco.table-th name="contact.name" label="Name" :sort="$sortLink" wire:click="sortOrder('contact.name')" class="cursor-pointer"></x-hyco.table-th>
                    <x-hyco.table-th name="contact.email" label="Email" :sort="$sortLink" wire:click="sortOrder('contact.email')" class="cursor-pointer"></x-hyco.table-th>
                    <x-hyco.table-th name="contact.phone" label="Phone" :sort="$sortLink" wire:click="sortOrder('contact.phone')" class="cursor-pointer"></x-hyco.table-th>
                    <x-hyco.table-th name="contact.mobile" label="Mobile" :sort="$sortLink" wire:click="sortOrder('contact.mobile')" class="cursor-pointer"></x-hyco.table-th>
                    <x-hyco.table-th name="contact.status" label="Status" :sort="$sortLink" wire:click="sortOrder('contact.status')" class="cursor-pointer w-[120px]"></x-hyco.table-th>
                    <th class="px-4 py-2 text-left w-[150px]">
                        Action
                    </th>
                </tr>
            </x-slot>

            @forelse ($contacts as $contact)
            <x-hyco.table-tr>
                <td class="px-4 py-3 text-gray-600">
                    {{ $contact->name }}
                </td>
                <td class="px-4 py-3 text-gray-600">
                    {{ $contact->email }}
                </td>
                <td class="px-4 py-3 text-gray-600">
                    {{ $contact->phone }}
                </td>
                <td class="px-4 py-3 text-gray-600">
                    {{ $contact->mobile }}
                </td>
                <td class="px-4 py-3 text-gray-600">
                    <x-hyco.table-active :status="$contact->status"></x-hyco.table-active>
                </td>
                {{-- <td class="px-4 py-3 text-gray-600">
                    {{ ($contact->updated_at)->format('d/m/Y, H:i') }}
                </td> --}}
                <td class="h-px w-px whitespace-nowrap px-4 py-3">
                    <a href="{{ route('master.contact.form',$contact->id) }}" wire:navigate class="text-xs text-white bg-blue-600 px-3 py-1 rounded-lg">Edit</a>
                    <a href="javascript:void(0)" wire:click="delete({{ $contact->id }})" class="text-xs bg-red-600 text-white px-3 py-1 rounded-lg">Del</a>
                </td>
            </x-hyco.table-tr>
            @empty
            <tr>
                <td colspan="100" class="text-center py-10">No data</td>
            </tr>
            @endforelse

            <x-slot name="footer">
                {{ $contacts->links() }}
            </x-slot>
        </x-hyco.table>

    </x-master-section>

    <x-hyco.confirmation-modal wire:model.live="confirmDeletion">
        <x-slot name="title">
            {{ __('Delete Contact') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to delete this contact?') }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmDeletion')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ml-3" wire:click="destroy" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-danger-button>
        </x-slot>
    </x-hyco.confirmation-modal>
</div>
