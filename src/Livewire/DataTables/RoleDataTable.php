<?php

namespace OneBiznet\Admin\Livewire\DataTables;

use OneBiznet\Admin\Livewire\DataTable;
use OneBiznet\Admin\View\DataTable\Columns\ButtonColumn;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;

class RoleDataTable extends DataTable
{
    protected $model = \Spatie\Permission\Models\Role::class;

    public function columns() : array
    {
        return [
            Column::make('Id')
                ->hideIf(true),
            Column::make('Name'),
            Column::make('Guard Name'),
            ButtonGroupColumn::make('Actions')
                ->buttons([
                    ButtonColumn::make('Edit')
                        ->icon('fas fa-pencil')
                        ->location(fn ($row) => route('admin.roles.edit', ['row' => $row]))
                        ->color('primary'),
                    ButtonColumn::make('Delete')
                        ->icon('fas fa-trash')
                        ->color('danger')
                        ->action(fn ($row) => 'delete(' . $row->{$this->primaryKey} . ')'),
                ])
        ];
    }
}
