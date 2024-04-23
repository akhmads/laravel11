<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Session;
use App\Models\Example;

new class extends Component {
    use WithPagination;

    public $perPage = 8;
    public $sort = ['created_at' => 'desc'];

    #[Session(key: 'searchUser')]
    public $search = '';

    public function with(): array
    {
        $example = Example::tableOrder($this->sort);
        $example->withAggregate('user','name');
        $example->tableLike('name', $this->search);
        return [ 'examples' => $example->paginate($this->perPage) ];
    }

    public function updated()
    {
        $this->resetPage();
    }

    public function sortOrder($column)
    {
        $key = array_key_first($this->sort);
        $this->sort = [ $column => $this->sort[$key] == 'asc' ? 'desc' : 'asc' ];
    }

    public function destroy(Example $example)
    {
        $example->delete();
        $this->success('/play', 'Example has been deleted.');
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

            <x-hc-table>
                <x-slot:right>
                    <x-hc-link href="{{ url('/play/create') }}" wire:navigate icon="o-plus">Create</x-hc-link>
                </x-slot:right>
                <x-slot:header>
                    <tr>
                        <x-hc-th name="name" :sort="$sort" />
                        <x-hc-th name="email" :sort="$sort" />
                        <x-hc-th name="user_name" :sort="$sort" />
                        <x-hc-th name="created_at" :sort="$sort" class="w-[200px]" />
                        <th class="w-[100px]">#</th>
                    </tr>
                </x-slot:header>

                @forelse ($examples as $example)
                <x-hc-tr>
                    <td class="px-4 py-3 text-gray-600">{{ $example->name }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $example->email }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $example->user_name ?? '' }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ ($example->created_at ?? '')->format('d-m-Y, H:i') }}</td>
                    <td class="px-4 py-1">
                        <div class="flex items-center gap-2">
                            <a href="{{ url("/play/$example->id/edit") }}" wire:navigate class="text-xs text-indigo-600 bg-indigo-100 hover:bg-indigo-400 hover:text-white px-3 py-1 rounded delay-50 duration-300 ease-in-out">Edit</a>
                            <a href="javascript:void(0)" wire:click="destroy({{ $example->id }})" class="text-xs text-red-600 bg-red-100 hover:bg-red-400 hover:text-white px-3 py-1 rounded delay-50 duration-300 ease-in-out">Del</a>
                        </div>
                    </td>
                </x-hc-tr>
                @empty
                <tr>
                    <td colspan="100" class="text-center py-10">No data.</td>
                </tr>
                @endforelse

            </x-hc-table>

        </div>
    </div>
</div>
