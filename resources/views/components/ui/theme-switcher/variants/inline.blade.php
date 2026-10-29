@aware(['darkIcon' => 'ps:moon', 'lightIcon' => 'ps:sun', 'iconVariant' => 'duotone'])

<div class="flex items-center transition-all duration-200  overflow-hidden">
    <x-ui.button :icon="$lightIcon" iconVariant="{{ $iconVariant }}" variant="ghost"
                 class="hover:opacity-80  transition"
                 x-show="$theme.isResolvedToLight" x-on:click="$theme.toggle()" style="display: none;"
                 iconVariant="regular"
                 role="button" aria-pressed="true" x-bind:aria-pressed="$theme.isResolvedToLight"
                 aria-label="Activate light theme"/>
    <x-ui.button :icon="$darkIcon" iconVariant="{{ $iconVariant }}" variant="gost" class="hover:opacity-80 transition"
                 x-show="$theme.isResolvedToDark" x-on:click="$theme.toggle()" style="display: none;"
                 iconVariant="regular"
                 role="button" aria-pressed="true" x-bind:aria-pressed="$theme.isResolvedToDark"
                 aria-label="Activate dark theme"/>
</div>
