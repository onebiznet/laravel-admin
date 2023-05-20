<?php

namespace OneBiznet\Admin\View\Form;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use OneBiznet\Admin\View\Form\Traits\HasColor;

class Tabs extends Container
{
    use HasColor;

    protected string $view = 'admin::components.form.tabs';

    public function __construct(?string $name = null)
    {
        $this->name = $name;
    }
    
    public function tabPages(array | Arrayable $tabPages)
    {
        $this->addComponents((array) $tabPages);

        $active = false;
        foreach ($tabPages as $page) {
            $active = $page->getActive() ? true : $active;
        }

        if (!$active && count($tabPages)) {
            $tabPages[0]->active();
        }

        return $this;
    }

    public function getTabPages(): array
    {
        return collect($this->components)->filter(fn ($component) => $component instanceof TabPage)->all();
    }

    public function getComponents(): array
    {
        return $this->getTabPages();
    }
}
