<div class="form-group row">
    <label for="{{ $attributes->get('id') }}" class="col-sm-3">{{ $label ?? '' }}</label>
    <div class="col-sm-9">
        <div class="custom-control custom-{{ $type ?? 'checkbox' }}">
            <input type="checkbox"
                {{ $attributes->merge(['class' => 'custom-control-input custom-control-input-' . ($color ?? 'primary')]) }} />
            <label for="{{ $attributes->get('id') }}" class="custom-control-label form-check-label">
                {{ $caption ?? ($slot ?? $attributes->get('label')) }}
            </label>
        </div>
    </div>
</div>
