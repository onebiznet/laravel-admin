<div class="form-group row" wire:ignore>
    <label for="{{ $attributes->get('id') }}" class="col-sm-3">{{ $label ?? '' }}</label>
    <div class="col-sm-9">
        <div class="w-100" x-data="{
            data: @if ($attributes->whereStartsWith('wire:model')->first()) @entangle($attributes->wire('model')->value()) @else '{{ $attributes->get('value') }}' @endif
        }" x-init="() => {
            new TomSelect($refs.input, {
                items: data,
                create: {{ $attributes->get('data-create') ?? 'true' }},
                onChange: function(value) {
                    data = value;
                },
            });
        }" x-cloak>
            <input x-ref="input" {{ $attributes->merge(['class' => 'form-control']) }}>
        </div>
        @error($attributes->get('name'))
            <input type="hidden" class="is-invalid">
            <span class="invalid-feedback error">{{ $message }}</span>
        @enderror
    </div>
</div>
