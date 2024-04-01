<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\SalesInvoice;

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
        $salesInvoice = SalesInvoice::orderby($this->sortColumn,$this->sortDir)
            ->where(function($query){
                $query->whereLike('name', $this->searchKeyword);
            });

        return [ 'items' => $item->paginate($this->perPage) ];
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
        SalesInvoice::destroy($this->set_id);
        $this->confirmDeletion = false;
        session()->flash('success', __('Item has been deleted'));
        return redirect()->route('master.item');
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

    <x-section>

        <x-hyco.table>
            <x-slot name="headingLeft">
                <x-hyco.table-perpage wire:model.live="perPage" :data="[10,25,50,100]" :value="$perPage" :span="1" />
                <x-hyco.table-search wire:model.live.debounce.300ms="searchKeyword" :span="4" />
            </x-slot>

            <x-slot name="headingRight">
                <x-hyco.link wire:navigate href="{{ route('master.item.form',0) }}" icon="plus" class="scale-90">
                    Create
                </x-hyco.link>
            </x-slot>

            <x-slot name="header">
                <tr>
                    <x-hyco.table-th name="name" label="Name" :sort="$sortLink" wire:click="sortOrder('name')" class="cursor-pointer"></x-hyco.table-th>
                    <x-hyco.table-th name="status" label="Status" :sort="$sortLink" wire:click="sortOrder('status')" class="cursor-pointer w-[120px]"></x-hyco.table-th>
                    <th class="px-4 py-2 text-left w-[150px]">
                        Action
                    </th>
                </tr>
            </x-slot>

            @forelse ($items as $item)
            <x-hyco.table-tr>
                <td class="px-4 py-3 text-gray-600">
                    {{ $item->name }}
                </td>
                <td class="px-4 py-3 text-gray-600">
                    <x-hyco.table-active :status="$item->status"></x-hyco.table-active>
                </td>
                <td class="h-px w-px whitespace-nowrap px-4 py-3">
                    <a href="{{ route('master.item.form',$item->id) }}" wire:navigate class="text-xs text-white bg-blue-600 px-3 py-1 rounded-lg">Edit</a>
                    <a href="javascript:void(0)" wire:click="delete({{ $item->id }})" class="text-xs bg-red-600 text-white px-3 py-1 rounded-lg">Del</a>
                </td>
            </x-hyco.table-tr>
            @empty
            <tr>
                <td colspan="100" class="text-center py-10">No data</td>
            </tr>
            @endforelse

            <x-slot name="footer">
                {{ $items->links() }}
            </x-slot>
        </x-hyco.table>

    </x-section>

    <x-hyco.confirmation-modal wire:model.live="confirmDeletion">
        <x-slot name="title">
            {{ __('Delete Item') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to delete this item?') }}
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
