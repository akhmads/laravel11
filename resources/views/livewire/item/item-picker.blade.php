<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Modelable;
use Illuminate\Support\Facades\DB;
use App\Models\Item;

new class extends Component {

    #[Modelable]
    public $value;
    public $label;
    public $searchKeyword;
    public $disabled = false;

    public function with(): array
    {
        $item = Item::orderby('item.name','asc')
            ->where(function($query){
                $query->whereLike('item.name', $this->searchKeyword);
            });

        return [ 'items' => $item->limit(10)->get() ];
    }

    public function mount($value = '', $label = '', $disabled = false)
    {
        if( !empty($value) ){
            $item = Item::where('id',$value)->get()->first();
        }else{
            $item = Item::where('id',$this->value)->get()->first();
        }
        $this->value = $item->id ?? '';

        if ( ! empty($item->name) ) {
            $this->label = $item->name;
        } else {
            $this->label = $label;
        }
        $this->disabled = $disabled;
    }

    public function pick($id,$label)
    {
        $this->value = $id;
        $this->label = $label;
        $this->dispatch('item-picked', id: $id, label: $label);
    }
}; ?>

<div>
    <div x-data="{ open: false }" @keyup.enter="open =! open" @close-item-picker="open=false" class="relative">
        <span class="select-none absolute inset-y-0 right-0 flex items-center cursor-pointer pr-3">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
            </svg>
        </span>
        <div x-on:click="open =! open" tabindex="0" class="w-full bg-white select-none px-3 pr-8 py-2 text-base truncate cursor-pointer border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 focus:outline-indigo-500 rounded-md shadow-sm">
            {{ empty($label) ? '' : $label }}
        </div>

        <div x-cloak x-show="open" x-trap="open" @click.outside="open = false" class="absolute top-[calc(100%+5px)] left-0 z-50 w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-lg">
            <input wire:model.live.debounce.500ms="searchKeyword" wire:loading.class="bg-sky-50" tabindex="0" type="text" autofocus placeholder="Search" class="w-full border border-gray-300 focus:border-indigo-400 focus:outline-none py-2 px-2 mb-2 rounded-md shadow-sm">
            <div class="max-h-[200px] overflow-y-auto">
                @forelse ( $items as $item )
                <div wire:key="item-picker-{{ $item->id }}" wire:click="pick('{{ $item->id }}','{{ $item->name }}');$dispatch('close-item-picker');" class="p-1 cursor-pointer hover:bg-blue-50" tabindex="0">
                    {{ $item->name }}
                </div>
                @empty
                <div class="p-1">No data found.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
