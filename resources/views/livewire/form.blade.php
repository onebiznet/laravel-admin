<form wire:submit.prevent="save">
    <div class="card">
        <div class="card-body">
            @foreach ($components as $component)
                {!! $component->render() !!}
            @endforeach
            
            {{ $slot }}
        </div>

        <div class="fixed-bottom form-actions px-4 py-2 border-top d-flex justify-content-end" style="background: #fafafa">
            <div class="btn-group">
                @foreach ($this->actions() as $action => $label)
                    @if ($loop->first)
                        <button class="btn btn-danger" type="submit">{{ $label }}</button>
                        @if ($loop->remaining)
                            <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu">
                        @endif
                    @else
                        <button type="button" class="dropdown-item" wire:click.prevent="{{ $action }}">{{ $label }}</button>
                    @endif

                    @if ($loop->last && $loop->count > 1)
            </div>
            @endif
            @endforeach
        </div>
    </div>
    </div>
</form>
