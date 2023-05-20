@php
    $sub_items = method_exists($item, 'getItems') ? $item->getItems() : null;
    $url = method_exists($item, 'getUrl') ? $item->getUrl() : '#';
@endphp
<li class="nav-item @if (!empty($sub_items) && !$item->isCollapsed()) menu-open @endif">
    @if ($label = $item->getLabel()) 
        <a href="{{ $url }}" class="nav-link @if ($item->isActive()) active @endif">
            @if ($icon = $item->getIcon())
                <i class="nav-icon {{ $icon }}"></i>
                <p>{{ $item->getLabel() }} 
                    @if(!empty($sub_items))
                        <i class="fas fa-angle-left right"></i>
                    @endif
                </p>
            @endif
        </a>
    @endif
    @if(!empty($sub_items)) 
        <ul class="nav nav-treeview">
            @foreach ($sub_items as $sub_item)
                <x-admin::navigation :item="$sub_item" />
            @endforeach
        </ul>
    @endif
</li>