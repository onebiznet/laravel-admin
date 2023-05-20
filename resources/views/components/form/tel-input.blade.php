<div class="form-group row">
    @once
        <style>
            .iti {
                width: 100%
            }
        </style>
    @endonce
    <label for="{{ $attributes->get('id') }}" class="col-sm-3">{{ $label ?? '' }}</label>
    <div class="col-sm-9">
        <div wire:ignore x-data="{ phoneNumber: @if ($attributes->whereStartsWith('wire:model')->first()) @entangle($attributes->wire('model')->value()) @else '{{ $attributes->get('value') }}' @endif }" x-init="window.addEventListener('load', () => {
            if (window.iti_inputs === undefined) window.iti_inputs = {};
        
            var iti = window.intlTelInput($refs.input, {
                initialCountry: '{{ $attributes->get('countryCode') ?: 'MM' }}',
                preferredCountries: ['MM'],
                hiddenInput: 'phone_number',
                separateDialCode: true,
                nationalMode: false,
                autoPlaceholder: 'aggressive',
                formatOnDisplay: false,
                utilsScript: 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.min.js',
            });
        
            $refs.input.addEventListener('change', (event) => {
                if (iti.isValidNumber()) {
                    $refs.input.classList.remove('uk-form-danger');
                } else {
                    $refs.input.classList.add('uk-form-danger');
                }
            });
        
            window.iti_inputs[$refs.input.name] = iti;
        });">
            <input type="tel" x-ref="input" {{ $attributes->merge(['class' => 'form-control']) }}>
        </div>

        @error($attributes->get('name'))
            <input type="hidden" class="is-invalid"><span class="error invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
</div>
