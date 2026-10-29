@props([
    'footer' => null,
])

@once
    <script>
        document.addEventListener('alpine:init', () => {
            if (window.__sidebarStoreInit) return;
            window.__sidebarStoreInit = true;

            const isMobile = window.matchMedia('(max-width: 767px)').matches;
            const isTablet = window.matchMedia('(min-width: 768px) and (max-width: 1023px)').matches;
            const savedCollapsed = localStorage.getItem('sidebar-collapsed') === 'true';

            Alpine.store('sidebar', {
                collapsed: isMobile ? false : (isTablet ? true : savedCollapsed),
                mobileOpen: false,
                isMobile,
                isTablet,
                _initialized: false,

                toggle() {
                    this.collapsed = !this.collapsed;
                    localStorage.setItem('sidebar-collapsed', this.collapsed);
                    document.documentElement.toggleAttribute('data-sidebar-collapsed', this.collapsed);
                },

                toggleMobile() {
                    this.mobileOpen = !this.mobileOpen;
                },

                closeMobile() {
                    this.mobileOpen = false;
                },

                init() {
                    if (this._initialized) return;
                    this._initialized = true;

                    const update = () => {
                        this.isMobile = window.matchMedia('(max-width: 767px)').matches;
                        this.isTablet = window.matchMedia('(min-width: 768px) and (max-width: 1023px)').matches;

                        if (!this.isMobile) this.mobileOpen = false;
                        if (this.isTablet) {
                            this.collapsed = true;
                            document.documentElement.setAttribute('data-sidebar-collapsed', '');
                        }
                    };

                    window.addEventListener('resize', update);
                },
            });
        });
    </script>
@endonce


{{-- SIDEBAR ROOT --}}
<div
        x-data
        x-init="$store.sidebar.init()"
        data-slot="sidebar"
        class="flex-shrink-0"
        style="width: var(--sidebar-initial-width, 18rem); transition: width 300ms ease-in-out;"
        :style="`width: ${$store.sidebar?.isMobile ? '0px' : ($store.sidebar?.collapsed ? '4.55rem' : '18rem')}; transition: width 300ms ease-in-out;`"
>

    {{-- MOBILE BACKDROP --}}
    <div
            x-show="$store.sidebar?.mobileOpen"
            x-transition.opacity
            @click="$store.sidebar.closeMobile()"
            class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm"
            style="display:none;"
    ></div>


    {{-- PANEL --}}
    <div
            {{ $attributes->class(['flex flex-col overflow-hidden']) }}
            data-slot="sidebar-panel"
            style="position: sticky; top: var(--header-height, 90px); height: calc(100dvh - var(--header-height, 90px)); width: 100%;"
            :style="$store.sidebar?.isMobile ? `
        position: fixed;
        top: 0.5rem;
        left: 0;
        z-index: 9999;
        width: 18rem;
        height: calc(100dvh - 1rem);
        transform: translateX(${$store.sidebar.mobileOpen ? '0' : 'calc(-100% - 0.5rem)'});
        transition: transform 300ms ease-in-out;
    ` : ''"
    >

        {{-- BODY --}}
        <div
                x-data="{
        isTop: true,
        isBottom: true,
        hasOverflow: false,
        update() {
            const { scrollTop, scrollHeight, clientHeight } = $el;
            this.isTop = scrollTop <= 0;
            this.isBottom = (scrollTop + clientHeight) >= (scrollHeight - 1);
            this.hasOverflow = scrollHeight > clientHeight;
        }
    }"
                x-init="update(); $nextTick(() => update())"
                @scroll.passive="update()"
                @resize.window.debounce="update()"
                class="flex-1 min-h-0 overflow-y-auto flex flex-col p-4"
                data-slot="sidebar-body"
        >
            {{-- CONTENT --}}
            <div class="flex-1">
                {{ $toggler ?? '' }}
                {{ $slot }}
            </div>

            {{-- FOOTER --}}
            @if ($footer)
                <div class="sticky bottom-0 pt-4 z-10">
                    <div
                            x-show="hasOverflow && !isBottom"
                            style="display:none"
                            class="absolute inset-0 -z-10 bg-gradient-to-t from-neutral-50 via-neutral-50 dark:from-neutral-800 dark:via-neutral-800 to-transparent"
                    ></div>
                    <div class="relative">
                        {{ $footer }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>