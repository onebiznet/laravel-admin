<?php

namespace OneBiznet\Admin\Livewire;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use PHPUnit\Runner\ClassDoesNotExistException;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;

class DataTable extends DataTableComponent
{
    protected $primaryKey = null;

    protected $hidden = [];

    public function mount(
        string $model = '',
        string $primaryKey = null,
        array $hidden = [],
    ) {
        if (class_exists($model)) {
            $this->model = $model;
        }

        $this->primaryKey = $primaryKey ?? $this->modelInstance->getKeyName();
        $this->hidden = array_merge($hidden ?: [], $this->modelInstance->getHidden());

        $this->theme = 'bootstrap-4';
    }

    public function getModelInstanceProperty() : Model
    {
        return $this->model::firstOrNew();
    }

    public function getTableColumnsProperty()
    {
        return collect($this->modelInstance->getAttributes())->keys();
    }

    public function bulkActions(): array
    {
        return [
            'export' => 'Export',
            'delete' => 'Delete',
        ];
    }

    public function configure(): void
    {
        $this->setPrimaryKey($this->primaryKey ?? 'id')
            ->setAdditionalSelects([
                $this->modelInstance->getTable() . '.' . $this->primaryKey . ' as ' . $this->primaryKey
                ])
            ->setComponentWrapperAttributes([
                'class' => 'card card-body',
            ]);
    }

    public function columns(): array
    {
        $casts = $this->modelInstance->getCasts();

        $columns = $this->tableColumns->reject(function ($col_name) {
            return in_array($col_name, $this->hidden);
        })->map(function ($col_name) use ($casts) {
            $cast = $casts[$col_name] ?? null;

            $column = Column::make(Str::title(str_replace('_', ' ', $col_name)), $col_name);
            switch ($cast) {
                case 'array':
                    $column = Column::make(Str::title(str_replace('_', ' ', $col_name)), $col_name)
                        ->format(
                            fn ($value, $row, Column $column) => implode(', ', $value)
                        );
                    break;

                case 'boolean':
                    $column = BooleanColumn::make(Str::title(str_replace('_', ' ', $col_name)), $col_name);
                    break;

                default:
                    $column = Column::make(Str::title(str_replace('_', ' ', $col_name)), $col_name);
            }

            return $column;
        })->all();

        return $columns;
    }
}
