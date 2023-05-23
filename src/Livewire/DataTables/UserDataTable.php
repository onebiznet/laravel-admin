<?php

namespace OneBiznet\Admin\Livewire\DataTables;

use App\Models\User;
use OneBiznet\Admin\Livewire\DataTable;
use OneBiznet\Admin\View\DataTable\Columns\ButtonColumn;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;

class UserDataTable extends DataTable
{
    protected $model = User::class;

    public function columns(): array
    {
        return [
            Column::make('Name'),
            Column::make('Username'),
            Column::make('Email Address', 'email'),
            Column::make('Phone Number', 'phone'),
            Column::make('Roles')
                ->label(fn ($row) => implode(', ', $row->roles ? $row->roles->pluck('name')->all() : [])),
            ButtonGroupColumn::make('Actions')
                ->attributes(fn () => ['class' => 'btn-group'])
                ->buttons([
                    ButtonColumn::make('Edit')
                        ->icon('fas fa-pencil')
                        ->color('primary')
                        ->location(fn ($row) => route('admin.users.edit', ['row' => $row])),
                    ButtonColumn::make('Delete')
                        ->icon('fas fa-trash')
                        ->color('danger')
                        ->action(fn ($row) => 'delete(' . $row->{$this->primaryKey} . ')'),
                ])
        ];
    }
}
