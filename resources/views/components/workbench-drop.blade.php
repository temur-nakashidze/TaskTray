@props(['workbench'])

{{--
    Wrap any button/card to make it a Workbench drop target.
    The host Livewire component must use WithWorkbenchPulling.
    On drop the dragged card is put back where it was: the real task never leaves its tray,
    only a WorkbenchTask representation is created.
--}}
<div {{ $attributes->class('relative') }}>
    {{ $slot }}

    @if ($workbench)
        <div x-sort="$wire.pullToWorkbench($item, 'workbench:{{ $workbench }}')" x-sort:group="tasks"
            x-sort:config="{ onAdd: (e) => e.from.insertBefore(e.item, e.from.children[e.oldIndex] || null) }"
            class="absolute inset-0 z-10 pointer-events-none in-[.sorting]:pointer-events-auto"></div>
    @endif
</div>
