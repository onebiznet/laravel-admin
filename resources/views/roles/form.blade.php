<x-admin-layout>
    <x-slot name="title">{{ $role->exists ? 'Edit Role' : 'New Role' }}</x-slot>

    <livewire:role-form :model="$role" />
</x-admin-layout>