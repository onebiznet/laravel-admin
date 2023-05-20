<div class="form-group row">
    <label for="{{ $attributes->get('id') }}" class="col-sm-3">{{ $label ?? '' }}</label>
    <div class="col-sm-9">
        <input {{ $attributes->class(['form-control', 'is-invalid' => $errors->has($attributes->get('name'))]) }} />
        @error($attributes->get('name'))
            <span class="invalid-feedback error">{{ $message }}</span>
        @enderror
    </div>
</div>
