<x-admin-layout>
    <x-slot name="title">{{ $title ?? '' }}</x-slot>

    <div class="card card-body">
        <livewire:data-table :model="$model">
    </div>
</x-admin-layout>