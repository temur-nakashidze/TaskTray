@aware([
    'collapsable' => true,
    'variant' => 'default',
    'label' => null,
    'icon' => null,
])

<div class="flex justify-between items-center" data-slot="sidebar-navlist-group-header">
    <div @class([
        'flex items-center',
        '[:not(:has([data-collapsed]_&))_&]:pl-3' => $icon,
    ])>
        @if ($icon)
            <x-ui.icon :name="$icon" class="size-5" />
        @endif

        <h4 class="font-normal pl-3 py-1 font-mono text-sm text-theme-400 dark:text-theme-500">{{ $label }}</h4>
    </div>

    @if ($collapsable)
        <button x-on:click="expand()" class="p-2 rounded-box cursor-pointer hover:dark:bg-white/5 hover:bg-neutral-900/5"
            type="button">
            <x-ui.icon x-show="!expanded" style="display:none;" name="chevron-down" class="size-4" />
            <x-ui.icon x-show="expanded" name="chevron-up" style="display:none;" class="size-4" />
        </button>
    @endif
</div>

<div @if ($collapsable) x-show="expanded"
     x-collapse @endif
    class="flex flex-col gap-y-1 ml-2 rtl:mr-2" data-slot="sidebar-navlist-group-items">
    {{ $slot }}
</div>
