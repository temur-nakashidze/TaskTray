@props([
    'position' => 'bottom-center',
    'offset' => 3,
    'onHover' => false,
])

<div x-data="{
    popoverOpen: false,
    toggle() {
        this.popoverOpen = !this.popoverOpen;
    },
    show() {
        this.popoverOpen = true;
    },
    hide() {
        this.popoverOpen = false;
    }
}" x-on:click.away="hide()" x-on:keydown.escape.stop="hide()" @contextmenu.stop
    class="inline-flex relative [--popup-round:var(--radius-box)] [--popup-padding:--spacing(1)]">
    {{ $slot }}
</div>
