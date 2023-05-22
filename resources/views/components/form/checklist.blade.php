<div class="form-group row">
    <label for="{{ $attributes->get('id') }}" class="col-sm-3">{{ $label ?? '' }}</label>
    <div class="col-sm-9">
        <div class="row">
            @foreach ($options as $value => $option)
                <div class="col-6 col-sm-4 col-md-3">
                    <div class="custom-control custom-{{ $type ?? 'checkbox' }}">
                        <input type="checkbox" id="{{ $attributes->get('id') }}-{{ $value }}"
                            {{ $attributes->merge(['class' => 'custom-control-input custom-control-input-' . ($color ?? 'primary')])->except('id') }}
                            value="{{ $value }}" />
                        <label for="{{ $attributes->get('id') }}-{{ $value }}"
                            class="custom-control-label form-check-label">
                            {{ $option }}
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
