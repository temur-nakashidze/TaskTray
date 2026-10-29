@aware(['darkIcon' => 'ps:moon', 'lightIcon' => 'ps:sun-dim', 'systemIcon' => 'computer-desktop', 'iconVariant' => 'fill'])
<x-ui.dropdown>
    <x-slot:button class="cursor-pointer hover:opacity-80 transition " role="button" aria-haspopup="true"
        aria-expanded="false" aria-controls="theme-menu">
        <x-ui.icon :name="$darkIcon" :variant="$iconVariant" size="lg" class="dark:hidden inline-flex fill-neutral-400" />
        <x-ui.icon :name="$lightIcon" :variant="$iconVariant" size="lg" class="hidden dark:inline-flex fill-neutral-400" />
    </x-slot:button>

    <x-slot:menu>
        <x-ui.dropdown.item :icon="$lightIcon" :iconVariant="$iconVariant" x-on:click="$theme.setLight();close()"
            x-bind:class="{ 'dark:bg-white/5 bg-black/5': $theme.isLight }">
            light
        </x-ui.dropdown.item>

        <x-ui.dropdown.item :icon="$darkIcon" :iconVariant="$iconVariant" x-on:click="$theme.setDark();close()"
            x-bind:class="{ 'dark:bg-white/5 bg-theme/5': $theme.isDark }">
            dark
        </x-ui.dropdown.item>

        <x-ui.dropdown.item :icon="$systemIcon" :iconVariant="$iconVariant" x-on:click="$theme.setSystem();close()"
            x-bind:class="{ 'dark:bg-white/5 bg-black/5': $theme.isSystem }">
            system
        </x-ui.dropdown.item>
    </x-slot:menu>
</x-ui.dropdown>
