<x-admin-layout>
    <x-slot name="title">
        Roles <a href="{{ route('admin.roles.create') }}" class="btn btn-primary ml-2">Create New</a>
    </x-slot>

    <livewire:role-table />
</x-admin-layout>