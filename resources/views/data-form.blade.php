<x-admin-layout>
    <x-slot name="title">{{ $title ?? '' }}</x-slot>

    <livewire:form :model="$model" />
</x-admin-layout>