<?php

namespace OneBiznet\Admin\Livewire\Forms;

use OneBiznet\Admin\Livewire\Form;
use OneBiznet\Admin\View\Form\TelInput;
use OneBiznet\Admin\View\Form\TextInput;
use OneBiznet\Admin\View\Form\TomSelect;

class UserForm extends Form
{
    protected function schema()
    {
        return [
            TextInput::make('name')
                ->rules('required|string|max:255'),
            TextInput::make('username')
                ->rules('required|string|max:50|unique:users,username,' . $this->model->id),
            TextInput::make('email')
                ->rules('nullable|email'),
            TelInput::make('phone')
                ->rules('required'),
            TomSelect::make('roles')
                ->multiple()
                ->relationship('roles.name'),
        ];
    }
}
