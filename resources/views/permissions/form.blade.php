<x-admin-layout>
    <x-slot name="title">{{ $permission->exists ? 'Edit Permission' : 'New Permission' }}</x-slot>

    <livewire:permission-form :model="$permission" />
</x-admin-layout>