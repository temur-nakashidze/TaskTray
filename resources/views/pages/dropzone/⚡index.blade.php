<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.workyard')] class extends Component {
    public string $title = 'Dropzone';
    public string $icon = 'ps:upload';
    public string $color = 'neutral';
    public string $parent = 'ps:upload';
    public ?string $button = null;
    public bool $editable = true;
};
?>
<div>



    <div class="p-(--padding-box-lg) space-y-(--gap-layout)">

        <div class="grid grid-cols-5 gap-(--gap-layout)">
            <div size="lg" class="col-span-3">
                <x-shelf.tray header="Drop Zone">
                    <x-task :meta="false" />
                    <x-task :meta="false" note="ndjksajdnakjdnkajsn" />
                    <x-task :meta="false" note="dasdasd  fdsf sdfs dfs df" />
                    <x-task :meta="false" :tags="['tag1', 'tag2']" />
                    <x-task :meta="false" />
                    <x-task :meta="false" :tags="['tag3', 'tag4']" note="dh kajd kjashd  dkjahs" />
                    <x-task :meta="false" />
                </x-shelf.tray>
            </div>
            <div class="col-span-2">
                <div class="flex items-center justify-between">
                    <x-ui.heading size="2xl">
                        Projects
                    </x-ui.heading>
                    <x-ui.button variant="outline" iconAfter="ps:plus" icon="ps:books" label="Add Project"
                        x-on:click="shelfFormOpen = true" />
                </div>

                <x-ui.empty class="border border-(--color-line-subtle)">
                    <x-ui.empty.media>
                        <x-ui.icon name="user" class="size-10" />
                    </x-ui.empty.media>
                    <x-ui.empty.contents>
                        <x-ui.heading>No Projects</x-ui.heading>
                        <x-ui.text variant="muted">
                            No projects yet. Add a new project to get started.
                        </x-ui.text>
                        <x-ui.button variant="primary" label="create new project" iconAfter="ps:plus" />
                    </x-ui.empty.contents>
                </x-ui.empty>

            </div>
        </div>

    </div>


</div>
