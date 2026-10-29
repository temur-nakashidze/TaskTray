<div class="flex items-center gap-2">
    <!-- Dropdown 1: Base Theme -->
    <div x-data="{
        open: false,
        currentTheme: document.documentElement.getAttribute('data-theme') || 'braunish',
        setTheme(theme) {
            this.currentTheme = theme;
            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem('app-theme', theme);
            this.open = false;
        }
    }" class="relative inline-block text-left">

        <x-ui.dropdown position="bottom-end" portal>
            <x-slot:button>
                <x-ui.button variant="soft" iconAfter="ps:caret-down" iconSize="xs" icon="ps:circle" iconVariant="fill"
                    iconColor="text-red-300">
                    Primary</x-ui.button>
            </x-slot:button>
            <x-slot:menu>
                <x-ui.dropdown.item @click="document.documentElement.setAttribute('data-theme', 'dim-grey')">
                    Dim Gray
                </x-ui.dropdown.item>
                <x-ui.dropdown.item @click="document.documentElement.setAttribute('data-theme', 'dusty-grape')">
                    Dusty Grape
                </x-ui.dropdown.item>
            </x-slot:menu>
        </x-ui.dropdown>
    </div>

    <!-- Dropdown 2: Accent Color -->
    <div x-data="{
        open: false,
        currentAccent: document.documentElement.getAttribute('data-accent') || 'natur',
        setAccent(accent) {
            this.currentAccent = accent;
            document.documentElement.setAttribute('data-accent', accent);
            localStorage.setItem('app-accent', accent);
            this.open = false;
        }
    }" class="relative inline-block text-left">
        {{-- Accent Color Switcher --}}
        <x-ui.dropdown position="bottom-end" portal>
            <x-slot:button>
                <x-ui.button variant="soft" iconAfter="ps:caret-down" iconSize="xs" icon="ps:circle" iconVariant="fill"
                    iconColor="text-red-300">
                    Accent</x-ui.button>
            </x-slot:button>
            <x-slot:menu>
                <x-ui.dropdown.item @click="document.documentElement.setAttribute('data-accent', 'natur')">
                    Natur
                </x-ui.dropdown.item>
                <x-ui.dropdown.item @click="document.documentElement.setAttribute('data-accent', 'mauve')">
                    Mauve
                </x-ui.dropdown.item>
            </x-slot:menu>
        </x-ui.dropdown>
    </div>
</div>
