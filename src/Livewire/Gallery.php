<?php 

namespace OneBiznet\Admin\Livewire;

use Butschster\Head\Facades\Meta;
use Illuminate\Pagination\Cursor;
use Livewire\Component;
use OneBiznet\Admin\Livewire\Concerns\WithInfiniteScroll;
use OneBiznet\Admin\Models\Media;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;

class Gallery extends Component
{
    use WithInfiniteScroll;

    public $gallery;

    public ?bool $multiple = false;

    public $selected = null;

    public array $dispatches = [];

    public bool $show = false;

    public function mount(bool $multiple = false)
    {
        Meta::includePackages('alpinejs');

        $this->gallery = new MediaCollection();

        $this->multiple = $multiple;

        $this->selected = $this->multiple ? [] : null;

        $this->loadMore();
    }

    public $listeners = ['openGallery'];

    public function openGallery($params, $multiple = null)
    {
        $this->show = true;
        $this->multiple = $multiple;
        $this->dispatches[] = $params;
    }    

    public function updatedMultiple($multiple) 
    {
        if ($multiple) {
            $this->selected = $this->selected ? [$this->selected] : [];
        } else {
            $this->selected = empty($this->selected) ? null : last($this->selected);
        }
    }

    public function getQuery() 
    {
        return Media::whereRaw('1=1');
    }

    public function loadMore()
    {
        if ($this->hasMorePages !== null && !$this->hasMorePages) {
            return ;
        }

        $query = $this->getQuery();

        $media = $query->latest()->cursorPaginate(24, ['*'], 'cursor', Cursor::fromEncoded($this->nextCursor));

        $this->gallery->push(...$media->items());

        $this->hasMorePages = $media->hasMorePages();
        if ($this->hasMorePages === true) {
            $this->nextCursor = $media->nextCursor()->encode();
        }
    }

    public function dispatch()
    {
        foreach($this->dispatches as $dispatch) {
            $this->dispatchBrowserEvent($dispatch, ['items' => Media::find($this->multiple ? $this->selected : [$this->selected])->all()]);
        }

        $this->selected = $this->multiple ? [] : null;
        $this->dispatches = [];
        $this->show = false;
    }

    public function render()
    {
        return view('admin::livewire.gallery');
    }
}