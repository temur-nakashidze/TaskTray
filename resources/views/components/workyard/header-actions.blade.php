 <div x-data="{ editing: false }"
     class="sticky w-full z-50 bg-(--color-neutral-50)/30 dark:bg-(--color-neutral-850)/30 backdrop-blur top-0 shrink-0 border-b border-(--color-line-subtle) py-(--padding-box-sm) px-(--padding-box-lg) min-h-[65px] group"
     style="view-transition-name: layout-header;" data-slot="header">
     <div class="flex items-center gap-(--gap-micro)">
         @if ($isWorkbench)
             <x-ui.badge size="lg" icon="wrench-screwdriver" variant="outline" class="mr-3">
                 Workbench
             </x-ui.badge>
         @endif
         @if ($icon)
             <x-ui.icon name="{{ $icon }}" variant="duotone" class="size-9 {{ $color }}" />
         @endif

         <div class="relative">
             <x-ui.heading x-show="!editing" x-transition size="2xl"
                 class="{{ $color }}! capitalize text-nowrap" weight="semibold">
                 {{ $title }}
             </x-ui.heading>
             @if ($editable)
                 <div x-show="editing" x-cloak x-transition
                     class="absolute left-0 top-1/2 -translate-y-1/2 flex items-center gap-(--gap-micro)  pt-1">
                     <x-ui.input class="w-44!" placeholder="Project name" value="{{ $title }}" />
                     <x-ui.button variant="ghost" icon="ps:check" x-on:click="editing = false" />
                 </div>
             @endif
         </div>
         @if ($editable)
             <x-ui.button x-show="!editing" x-transition variant="ghost" icon="ps:pencil-simple"
                 x-on:click="editing = true" class="opacity-0 group-hover:opacity-100 transition-opacity" />
         @endif
         <x-ui.spacer />
         @if ($button)
             <x-ui.button label="{{ $button }}" variant="soft" color="primary" icon="{{ $buttonIcon }}"
                 iconVariant="duotone" />
         @endif
     </div>

 </div>
