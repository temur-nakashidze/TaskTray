@props(['dark' => null])
@php
    $locale = ['en' => 'ENG', 'ka' => 'GEO', 'ru' => 'RUS'];
@endphp
<x-ui.dropdown position="bottom-end" portal>
    <x-slot:button>
        <x-ui.button label="{{ $locale[app()->getLocale()] }}" variant="soft" iconAfter="ps:caret-down"
            iconSize="xs"></x-ui.button>
    </x-slot:button>
    <x-slot:menu>
        <x-ui.dropdown.item href="{{ route('language.set', 'ru') }}">RUS</x-ui.dropdown.item>
        <x-ui.dropdown.item href="{{ route('language.set', 'en') }}">ENG</x-ui.dropdown.item>
        <x-ui.dropdown.item href="{{ route('language.set', 'ka') }}">GEO</x-ui.dropdown.item>
    </x-slot:menu>
</x-ui.dropdown>
