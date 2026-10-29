<x-layouts::app.index :title="$title ?? null">
    <x-ui.layout.sidebar-main>
        <x-slot:sidebar>
            <livewire:workyard.sidebar-navlist />
        </x-slot:sidebar>
        {{ $slot }}
    </x-ui.layout.sidebar-main>
</x-layouts::app.index>
