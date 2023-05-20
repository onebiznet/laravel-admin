<?php

namespace OneBiznet\Admin\Livewire\Forms;

use App\Models\User;
use OneBiznet\Admin\Livewire\Form;
use OneBiznet\Admin\View\Form\Panel;
use OneBiznet\Admin\View\Form\Radio;
use OneBiznet\Admin\View\Form\TabPage;
use OneBiznet\Admin\View\Form\Tabs;
use OneBiznet\Admin\View\Form\TelInput;
use OneBiznet\Admin\View\Form\TextInput;

class UserForm extends Form
{
    protected function schema()
    {
        return [
            Tabs::make('tab-1')
                ->tabPages([
                    TabPage::make('page-1')
                        ->addComponents([
                            TextInput::make('name')
                                ->rules('required'),
                            Panel::make()
                                ->collapseIf(fn ($model) => empty($model->name))
                                ->addComponents([
                                    TextInput::make('username')
                                        ->rules('required'),
                                ]),
                        ]),
                    TabPage::make('page-2')
                        ->addComponents([
                            TextInput::make('email')
                                ->rules('nullable|email'),
                            TelInput::make('phone')
                                ->rules('required'),
                        ]),
                ])
        ];
    }

    public function save()
    {
        $this->validate();

        $this->model->save();
    }
}
