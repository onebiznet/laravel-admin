<a href="{{ $path }}" {!! count($attributes) ? $column->arrayToAttributes($attributes) : '' !!} @if ($action) wire:click.prevent="{{ $action }}" @endif>{!! $title !!}</a>