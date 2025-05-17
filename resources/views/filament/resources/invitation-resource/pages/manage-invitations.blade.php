<x-filament-panels::page>
    {{-- This will render the default ListRecords content (tabs, table, etc.) --}}
    {{ $this->table }}

    {{-- Include your Livewire modal component here so it's on the page --}}
    @livewire('send-invitation-form')
</x-filament-panels::page>
