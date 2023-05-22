<x-admin-layout>
    <x-slot name="title">
        Permissions <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary ml-2">Create New</a>
    </x-slot>

    <livewire:permission-table />
</x-admin-layout>