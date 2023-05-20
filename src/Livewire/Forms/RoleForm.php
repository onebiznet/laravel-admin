<?php 

namespace OneBiznet\Admin\Livewire\Forms;

use OneBiznet\Admin\Livewire\Form;
use OneBiznet\Admin\View\Form\TextInput;

class RoleForm extends Form
{
    protected function schema() 
    {
        return [
            TextInput::make('name')
                ->rules('required|string|unique:roles,name,'.$this->model->getKey()),
            TextInput::make('guard_name')
                ->rules('nullable|string|max:255'),
        ];
    }
}