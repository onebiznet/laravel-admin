<div class="form-group row">
    <label for="{{ $attributes->get('id') }}" class="col-sm-3">{{ $label ?? '' }}</label>
    <div class="col-sm-9">
        <div x-data="{
            content: @if ($attributes->whereStartsWith('wire:model')->first()) @entangle($attributes->wire('model')->value()) @else
        $attribute->get('value') @endif
        }" x-init="() => {
            const editor = tinymce.init({
                branding: false,
                target: $refs.editor,
                external_plugins: {
                    pluginId: '{{ function_exists('global_asset') ? global_asset('vendor/admin/js/tinymce-plugins.js') : asset('vendor/admin/js/tinymce-plugins.js')}}'
                },
                plugins: [
                    'advlist',
                    'autolink',
                    'lists',
                    'link',
                    'image',
                    'media',
                    'table',
                    'gallery'
                ],
                toolbar: 'blocks bold italic backcolor | ' +
                    'alignleft aligncenter alignright alignjustify | ' +
                    'bullist numlist outdent indent | ' +
                    'gallery',
                setup: function(editor) {
                    editor.on('change', function() {
                        content = editor.getContent();
                    });
                }
            });
        }" wire:ignore>
            <textarea x-ref="editor" x-text="content"></textarea>
        </div>
    </div>
</div>
