<div class="form-group row" wire:ignore>
    <label for="{{ $attributes->get('id') }}" class="col-sm-3">{{ $label ?? '' }}</label>
    <div class="col-sm-9">
        <div class="w-100" x-data="{
            create: {{ $attributes->get('data-create') ?? 'false' }},
            data: @if ($attributes->whereStartsWith('wire:model')->first()) @entangle($attributes->wire('model')->value()) 
                @else 
                    {{ json_encode($attributes->get('value')) }} @endif
        }" x-init="() => {
            new TomSelect($refs.select, {
                items: data,
                create: create ? function(input) {
                    text = input.replace('@', '');
                    return { value: text, text: text };
                } : false,
                createFilter: create ? function(input) {
                    return input.startsWith('@');
                } : null,
                persist: false,
                placeholder: '{{ $attributes->get('placeholder') ?? $attributes->get('data-placeholder') }}',
                maxItems: {{ $attributes->has('multiple') ? 'null' : 1 }},
                onChange: function(value) {
                    data = value;
                },
            });
        }" x-cloak>

            <select x-ref="select" {{ $attributes->whereDoesntStartWith(['wire', 'value']) }}>
                {{ $slot }}
            </select>
        </div>
        @error($attributes->get('name'))
            <input type="hidden" class="is-invalid">
            <span class="invalid-feedback error">{{ $message }}</span>
        @enderror

    </div>
</div>
