<?php

namespace OneBiznet\Admin\View\DataTable\Columns;

use Illuminate\Database\Eloquent\Model;
use OneBiznet\Admin\View\DataTable\Traits\ButtonColumnConfiguration;
use OneBiznet\Admin\View\DataTable\Traits\ButtonColumnHelpers;
use Rappasoft\LaravelLivewireTables\Exceptions\DataTableConfigurationException;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

class ButtonColumn extends LinkColumn
{
    use ButtonColumnHelpers,
        ButtonColumnConfiguration;

    protected string $view = 'admin::data-table.columns.button';
    protected string $color = 'primary';
    protected string $icon = '';

    protected $titleCallback;
    protected $actionCallback;
    protected $attributesCallback;

    public function __construct(string $title, string $from = null)
    {
        parent::__construct($title, $from);

        $this->label(fn () => null);
    }

    public function getContents(Model $row)
    {
        $title = $this->getIcon() . ($this->hasTitleCallback() ? app()->call($this->getTitleCallback(), ['row' => $row]) : '');

        if (!$this->hasLocationCallback()) {
            if ($this->hasActionCallback()) {
                $location = '#';
                $action = app()->call($this->getActionCallback(), ['row' => $row]);
            } else {
                throw new DataTableConfigurationException('You must specify a action or link location callback for an button column.');
            }
        } else {
            $location = app()->call($this->getLocationCallback(), ['row' => $row]);
            $action = null;
        }

        $attributes = $this->hasAttributesCallback() ? app()->call($this->getAttributesCallback(), ['row' => $row]) : [];

        $attributes = array_merge($attributes, ['class' => 'btn btn-sm btn-' . $this->color . ' ' . ($attributes['class'] ?? '')]);

        return view($this->getView())
            ->withColumn($this)
            ->withTitle($title)
            ->withPath($location)
            ->withAction($action)
            ->withAttributes($attributes);
    }
}
