@props([
    'shrinkable' => false,
    'togglable' => false,
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
                        this.isTablet = window.matchMedia('(min-width: 768px) and (max-width: 1023px)')
                            .matches;

                        if (!this.isMobile) this.mobileOpen = false;
                        if (this.isTablet) this.collapsed = true;
                    };

                    window.addEventListener('resize', update);
                },
            });
        });
    </script>
@endonce


{{-- SIDEBAR ROOT --}}
<div x-data x-init="$store.sidebar.init()" data-slot="dashboard-sidebar"
    :data-sidebar-collapsed="$store.sidebar?.collapsed ? true : null" class="shrink-0"
    style="width: var(--sidebar-initial-width, 20rem); transition: width 300ms ease-in-out;"
    :style="`width: ${$store.sidebar?.isMobile ? '0px' : ($store.sidebar?.collapsed ? '4rem' : '20rem')}; transition: width 300ms ease-in-out;`">
    <div style="position: fixed; top: 0; left: 0; height: 100dvh; width: var(--sidebar-initial-width, 20rem); transition: width 300ms ease-in-out;"
        :style="`position: fixed; top: 0; left: 0; height: 100dvh; width: ${$store.sidebar?.isMobile ? '0px' : ($store.sidebar?.collapsed ? '4rem' : '20rem')}; transition: width 300ms ease-in-out;`">
        {{-- MOBILE BACKDROP --}}
        <div x-show="$store.sidebar?.mobileOpen" x-transition.opacity @click="$store.sidebar.closeMobile()"
            class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm" style="display:none;"></div>


        {{-- PANEL --}}
        <div {{ $attributes->class(['flex flex-col overflow-hidden']) }} data-slot="dashboard-sidebar-panel"
            :style="$store.sidebar ? (
                $store.sidebar.isMobile ?
                `
                                                                                    position: fixed;
                                                                                    top: 0;
                                                                                    left: 0;
                                                                                    z-index: 9999;
                                                                                    width: 20rem;
                                                                                    height: 100dvh;
                                                                                    transform: translateX(${
                                                                                        $store.sidebar.mobileOpen ? '0' : 'calc(-100% - 1rem)'
                                                                                    });
                                                                                    transition: transform 300ms ease-in-out;
                                                                                ` :
                `
                                                                                    width: 100%;
                                                                                    height: 100%;
                                                                                `
            ) : ''">

            {{-- BODY --}}
            <div class="flex-1 min-h-0 overflow-y-auto p-(--padding-box-sm)" data-slot="dashboard-sidebar-body">

                {{-- CONTENT --}}
                <div class="flex-1">
                    @if ($togglable)
                        <div class="flex items-center justify-between mb-2">
                            <x-ui.button variant="ghost" color="surface" x-data @click="$store.sidebar.toggle()"
                                data-slot="dashboard-sidebar-toggle" squared>
                                <div x-data>
                                    <template x-if="!$store.sidebar.collapsed">
                                        <x-ui.icon name="ps:sidebar-simple" />
                                    </template>

                                    <template x-if="$store.sidebar.collapsed">
                                        <x-ui.icon name="ps:sidebar" />
                                    </template>
                                </div>
                            </x-ui.button>
                        </div>
                    @endif

                    {{ $slot }}
                </div>

            </div>

            {{-- FOOTER --}}
            @if (isset($footer))
                <div class="shrink-0 p-(--padding-box-sm)" data-slot="dashboard-sidebar-footer">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>
</div>
