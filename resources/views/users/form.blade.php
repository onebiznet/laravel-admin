<x-admin-layout>
    <x-slot name="title">{{ $user->exists ? $user->name : 'New User' }}</x-slot>

    <livewire:user-form :model="$user" />
</x-admin-layout>