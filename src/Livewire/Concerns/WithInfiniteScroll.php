<?php 

namespace OneBiznet\Admin\Livewire\Concerns;

trait WithInfiniteScroll
{
    public $hasMorePages;
    public $nextCursor;

    public abstract function loadMore();
}