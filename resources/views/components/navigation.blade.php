<li class="{{ $attributes->class('nav-item')->get('class') }}">
    <a href="{{ $url ?? '#' }}" class="nav-link {{ $active ? 'active' : '' }}">
        @if ($icon)
            <i class="nav-icon {{ $icon }}"></i>
        @endif
        <p>{{ $label }}
            @if (!empty($items))
                <i class="fas fa-angle-left right"></i>
            @endif
        </p>
    </a>

    @if (!empty($items))
        <ul class="nav nav-treeview">
            @foreach ($items as $sub_item)
                {{ $sub_item }}
            @endforeach
        </ul>
    @endif
</li>
