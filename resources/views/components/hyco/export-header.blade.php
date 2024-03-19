@props(['title'])

<div class="flex items-center justify-start gap-2 ">
    <h2 class="min-w-[160px] font-semibold text-xl text-gray-800 leading-tight">
        {{ __($title) }}
    </h2>
    <div class="flex items-end gap-6 text-sm">
        <x-hyco.export-header-menu :href="route('export.export')" :active="request()->routeIs('export.export')">Manifest</x-hyco.export-header-menu>
        <x-hyco.export-header-menu :href="route('export.carton')" :active="request()->routeIs('export.carton')">Carton</x-hyco.export-header-menu>
        <x-hyco.export-header-menu :href="route('export.inbound')" :active="request()->routeIs('export.inbound')">Inbound</x-hyco.export-header-menu>
        <x-hyco.export-header-menu :href="route('export.outbound')" :active="request()->routeIs('export.outbound')">Outbound</x-hyco.export-header-menu>
    </div>
</div>
