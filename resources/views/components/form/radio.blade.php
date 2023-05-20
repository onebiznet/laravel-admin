<div class="form-group row">
    <label for="{{ $attributes->get('id') }}" class="col-sm-3">{{ $label ?? '' }}</label>
    <div class="col-sm-9">
        @foreach ($options as $value => $option)
            <div class="custom-control custom-{{ $type ?? 'radio' }}">
                <input type="radio" id="{{ $attributes->get('id') }}-{{ $value }}"
                    {{ $attributes->merge(['class' => 'custom-control-input custom-control-input-' . ($color ?? 'primary')])->except('id') }}
                    value="{{ $value }}" />
                <label for="{{ $attributes->get('id') }}-{{ $value }}"
                    class="custom-control-label form-check-label">
                    {{ $option }}
                </label>
            </div>
        @endforeach
    </div>
</div>
