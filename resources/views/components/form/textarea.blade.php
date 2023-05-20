<div class="form-group row">
    <label for="{{ $attributes->get('id') }}" class="col-sm-3">{{ $label ?? '' }}</label>
    <div class="col-sm-9">
        <textarea
            {{ $attributes->except('value')->class(['form-control', 'is-invalid' => $errors->has($attributes->get('name'))]) }}>
            @isset($slot)
                {{ $slot }}
            @else
                {{ $attributes->get('value') }}
            @endisset
        </textarea>
    </div>
</div>
