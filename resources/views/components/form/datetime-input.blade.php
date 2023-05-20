<div class="form-group row" wire:ignore>
    <label for="{{ $attributes->get('id') }}" class="col-sm-3">{{ $label ?? '' }}</label>
    <div class="col-sm-9">
        <div class="input-group" x-data="{
            date: @entangle($attributes->wire('model')->value())
        }" x-init="() => {
            flatpickr($refs.flatpickr, {
                wrap: true,
                dateFormat: 'd-m-Y G:i K',
                allowInput: true,
                defaultHour: 0,
                enableTime: true,
                onChange: (selectedDates, dateStr, instance) => {
                    date = dateStr;
                },
            });
        }" x-ref="flatpickr">
            <input type="text" {{ $attributes->merge(['class' => 'form-control']) }} data-input>
            <div class="input-group-append" data-toggle>
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
            </div>
        </div>

        @error($attributes->get('name'))
            <input type="hidden" class="is-invalid"><span class="error invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
</div>
