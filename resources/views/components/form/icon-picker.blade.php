<div class="form-group row">
    <label for="{{ $attributes->get('id') }}" class="col-sm-3">{{ $label ?? '' }}</label>
    <div class="col-sm-9">
        <div class="btn-group" x-data="{
            icon: @if ($attributes->whereStartsWith('wire:model')->first()) @entangle($attributes->wire('model')->value()) @else '{{ $attributes->get('value') }}' @endif
        }" x-init="$($refs.iconpicker).iconpicker({
            icon: icon,
            iconset: 'fontawesome6',
            arrowClass: 'btn-default',
        });
        $($refs.iconpicker).on('change', function(e) {
            icon = e.icon;
        });" wire:ignore>
            <button x-ref="iconpicker" {{ $attributes->merge(['class' => 'btn btn-default']) }}></button>
            <button type="button" class="btn btn-default" x-on:click="$($refs.iconpicker).iconpicker('setIcon', '')"
                x-show="(icon != 'empty')"><span class="mr-2" x-text="icon"></span><i
                    class="far fa-times-circle text-danger"></i></button>
        </div>
        @error($attributes->get('name'))
            <input type="hidden" class="is-invalid" />
            <span class="error invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
</div>
