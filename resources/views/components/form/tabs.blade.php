<ul class="nav nav-tabs" role="tablist">
    @foreach ($tab_pages as $page)
        <li class="nav-item">
            <a href="#{{ $page->getId() }}" class="nav-link @if ($page->getActive()) active @endif" id="{{ $page->getId() }}-tab" data-toggle="pill" role="tab" aria-controls="{{ $attributes->get('id') }}" aria-selected="{{ $page->getActive() ? 'true' : 'false' }}" wire:ignore.self>{{ $page->getLabel() ?? $page->getName() ?? $page->getId() }}</a>
        </li>
    @endforeach
</ul>
<div class="card card-{{ $color ?: 'primary' }} card-outline card-outline-tabs">
    <div class="card-header p-0 border-bottom-0">
    </div>
    <div class="card-body">
        <div {{ $attributes->class('tab-content') }} id="{{ $attributes->get('id') }}-tabContent">
            @foreach ($tab_pages as $page)
                {!! $page->render()->with($page->getData()) !!}
            @endforeach
        </div>
    </div>
</div>