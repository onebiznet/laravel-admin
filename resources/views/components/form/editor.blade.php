<div class="form-group row">
    <label for="{{ $attributes->get('id') }}" class="col-sm-3">{{ $label ?? '' }}</label>
    <div class="col-sm-9">
        <div x-data="{
            content: @if ($attributes->whereStartsWith('wire:model')->first()) @entangle($attributes->wire('model')->value()) @else
        $attribute->get('value') @endif
        }" x-init="() => {
            const editor = tinymce.init({
                target: $refs.editor,
                branding: false
            });
        }" wire:ignore>
            <textarea x-ref="editor" x-text="content"></textarea>
        </div>
    </div>
</div>
