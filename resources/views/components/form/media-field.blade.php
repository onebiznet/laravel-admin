<div class="form-group row" x-data="{
    value: {{ json_encode($attributes->get('value')) }},
    multiple: {{ $attributes->has('multiple') ? 'true' : 'false' }},
    images: @if ($attributes->whereStartsWith('wire:model')->first()) @entangle($attributes->wire('model')->value()) 
    @else
        {{ json_encode(Admin::media()->find($attributes->get('value', []))->all()) }} @endif,
}" x-init="() => {
    const createPreview = function(images) {
        $($refs.sortable).children('li').remove();
        value = [];
        images.forEach(function(image, index) {
            value.push(image.id);
            var itemTemplate = $('#item-template').html();
            $(itemTemplate)
                .data('index', index)
                .attr('id', image.id)
                .appendTo($refs.sortable)
                .find('img')
                .attr('src', image.original_url);
        });
    };

    createPreview(images);

    $($refs.sortable).on('click', '.gallery-item .delete-item', function(e) {
        e.preventDefault();
        var index = $(this).closest('li').data('index');
        images.splice(index, 1);
    });

    $($refs.sortable).sortable({
        container: 'ul',
        node: 'li.gallery-item',
        scroll: true,
        handle: 'img',
        autocreate: false,
        update: function(e) {
            images = this.sortable('serialize').map(sorted => {
                return JSON.parse(JSON.stringify(images.find(({ id }) => id == parseInt(sorted.id))));
            });
        }
    });

    $watch('images', images => {
        createPreview(images)
    });

    window.addEventListener('{{ $attributes->wire('model')->value() }}', function(e) {
        var new_items = Array.isArray(e.detail.items) ? e.detail.items : [e.detail.items];
        new_items = new_items.filter(item => {
            found = images.find(image => image.id == item.id);
            return !found;
        });
        images = JSON.parse(JSON.stringify(images.concat(new_items)));
    });


}" wire:ignore>
    <label class="col-sm-3" for="{{ $attributes->get('id') }}">{{ $label ?? '' }}</label>
    @once
        <style>
            .gallery-item .hover {
                right: 0px;
                top: 0px;
                display: none;
            }

            .gallery-item:hover .hover {
                display: block;
            }
        </style>
    @endonce
    <div class="col-sm-9">
        <script type="text/html" id="item-template">
            <li class="col-6 col-sm-4 col-md-3 mb-3 gallery-item">
                <div class="position-relative overflow-hidden" style="padding-bottom: 100%;">
                    <div class="d-flex position-absolute m-100 h-100">
                        <img class="img-thumbnail w-100" style="object-fit: contain; background: #444;" src=""/>
                    </div>
                    <div class="position-absolute hover">
                        <a href="#" class="btn btn-sm delete-item text-danger">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </div>
            </li>
        </script>
        <ul class="row row-eq-height list-unstyled m-0" id="{{ $attributes->get('id') }}" x-ref="sortable">
        </ul>

        <div class="col-6 col-sm-4 col-md-3 mb-3" x-show.important="images.length == 0 || multiple" id="add_media"
        x-on:click="getGalleryImage('{{ $attributes->wire('model')->value() }}' )">
            <div class="position-relative overflow-hidden" style="padding-bottom: 100%">
                <div class="d-flex border position-absolute w-100 h-100 justify-content-center align-items-center">
                    @if ($attributes->has('placeholder'))
                        <img class="w-100 position-absolute" src="{{ $attributes->get('placeholder') }}" style="opacity: 0.8;"/>
                    @endif 
                    <i class="fas fa-plus"></i>
                </div>
            </div>
        </div>

        <input type="hidden" name="{{ $attributes->get('name') }}" x-model="value"
            class="@error($attributes->get('name')) is-invalid @enderror">
        @error($attributes->get('name'))
            <span class="error invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
</div>
