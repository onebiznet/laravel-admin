<div class="modal fade @if ($show) show @endif" id="gallery-modal" tabindex="-1" role="dialog"
    aria-labelledby="{{ __('Gallery') }}" aria-hidden="true"
    @if ($show) style="display: block;" @endif>
    @once
        <style>
            .filter-item input:checked+.img-thumbnail {
                border: 4px solid var(--primary);
            }

            .modal-full {
                margin: 0px;
                min-width: 100% !important;
                height: 100% !important;
            }

            .modal-full .modal-content {
                border: 0px;
                border-radius: 0px;
                height: 100%;
            }
        </style>
        <script>
            const getGalleryImage = function(model, multiple = null) {
                Livewire.emitTo('gallery', 'openGallery', model, multiple);
            }
        </script>
    @endonce
    <div class="modal-dialog modal-full" role="document" x-data="{
        selected: @entangle('selected'),
        multiple: @entangle('multiple'),
    }">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">Gallery</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('Close') }}" wire:click.prevent="$toggle('show')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body overflow-auto full-body">
                <ul class="nav nav-tabs border-0" id="gallery-modal-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="gallery-tab-pill" data-toggle="pill" href="#gallery-tab-content"
                            role="tab" aria-controls="gallery-tab" aria-selected="true"
                            wire:ignore.self>{{ __('Gallery') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="upload-tab-pill" data-toggle="pill" href="#upload-tab-content"
                            role="tab" aria-controls="upload-tab" aria-selected="false"
                            wire:ignore.self>{{ __('Upload') }}</a>
                    </li>
                </ul>
                <div class="card rounded-0">
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="gallery-tab-content" role="tabpanel"
                                aria-labelledby="gallery-tab-pill" wire:ignore.self>
                                <div class="filter-container p-0 row">
                                    <div class="col-sm-6 col-md-4 col-lg-3">
                                        @if ($media = Admin::media()->find(is_array($selected) ? end($selected) : $selected))
                                            <div class="row d-flex justify-content-center">
                                                {{ $media->img()->attributes(['class' => 'border', 'style' => 'max-height: 200px; max-width: 100%;']) }}
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-6 col-form-label">{{ __('File') }}</label>
                                                <div class="col-6">
                                                    <input type="text" class="form-control"
                                                        value="{{ $media->getFullUrl() }}" />
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-sm-6 col-md-8 col-lg-9">
                                        <div class="row">
                                            @foreach ($gallery as $media)
                                                <label class="filter-item col-6 col-sm-6 col-md-4 col-lg-3 col-xl-2">
                                                    <div class="position-relative overflow-hidden"
                                                        style="padding-bottom: 100%">
                                                        <div class="d-flex position-absolute w-100 h-100">
                                                            <input
                                                                @if ($multiple) type="checkbox" @else type="radio" @endif
                                                                id="gallery_item_{{ $media->id }}"
                                                                class="invisible position-absolute"
                                                                value="{{ $media->id }}" wire:model="selected" />

                                                            <img src="{{ $media->getFullUrl() }}"
                                                                class="img-thumbnail w-100 rounded-0 p-0"
                                                                alt="{{ $media->caption }}"
                                                                style="object-fit: cover; object-position: center;" />
                                                        </div>
                                                    </div>
                                                </label>
                                            @endforeach
                                        </div>
                                        <div x-data="{
                                            init() {
                                                let observer = new IntersectionObserver((entries) => {
                                                    entries.forEach(entry => {
                                                        if (entry.isIntersecting) {
                                                            @this.loadMore();
                                                        }
                                                    })
                                                }, {
                                                    root: null
                                                });
                                                observer.POLL_INTERVAL = 100
                                                observer.observe(this.$el);
                                                @this.loadMore();
                                            }
                                        }">
                                            @if ($hasMorePages)
                                                <button type="button" wire:loading.remove wire:click.prevent="loadMore"
                                                    class="uk-button uk-button-default uk-button-large uk-width-1-1"
                                                    style="border-top-left-radius: 0; border-top-right-radius: 0;">
                                                    <span class="uk-margin-small-right"
                                                        uk-icon="icon: plus; ratio: .75;"></span><span>Load
                                                        more</span>
                                                </button>

                                                <div uk-spinner wire:loading></div>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="upload-tab-content" role="tabpanel"
                                aria-labelledby="upload-tab-pill" wire:ignore.self>
                                {{-- <x-livewire.image-upload wire:model="uploads" /> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <div class="custom-control custom-switch">
                    @if ($multiple !== null)
                        <input type="checkbox" class="custom-control-input" id="is_multiple" x-model="multiple" />
                        <label class="custom-control-label form-check-label"
                            for="is_multiple">{{ __('Select multiple') }}</label>
                    @endif
                </div>
                <button type="button" class="btn btn-primary" wire:click.prevent="dispatch"
                    @if (!$selected || empty($selected)) disabled @endif>{{ __('Select') }}</button>
            </div>
        </div>
    </div>
</div>
