<div id="{{ $attributes->get('id') }}" {{ $attributes->class(['tab-pane fade', 'show active' => $active]) }} role="tabpanel" aria-labelledby="{{ $attributes->get('id') }}-tab" wire:ignore.self>
    {{ $slot }}
    {{-- @foreach ($components as $component) 
        {!! $component->render()->with($component->getData()) !!}
    @endforeach --}}
</div>