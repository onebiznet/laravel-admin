<?php

namespace OneBiznet\Admin\Livewire;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Arr;
use Livewire\Component;
use OneBiznet\Admin\Models\Media;
use OneBiznet\Admin\View\Form\Container;
use OneBiznet\Admin\View\Form\Field;
use OneBiznet\Admin\View\Form\MediaField;
use OneBiznet\Admin\View\Form\TextInput;
use OneBiznet\Admin\View\Form\Traits\HasComponents;

class Form extends Component
{
    use HasComponents;

    public $model;

    protected array $cachedComponents = [];

    public $relationships = [];

    public $rules = [
        'model.*' => '',
        'relationships.*' => '',
    ];

    public function mount(
        $model
    ) {
        $this->model = $model;

        $this->addComponents($this->schema());

        foreach ($this->getFields($this->form_components) as $field) {
            if (method_exists($field, 'hasRelation') && $field->hasRelation()) {
                $relation = $field->getRelation();
                $name = last(explode('.', $field->getName()));
                $relationship = $this->model->{$relation}();
                $this->relationships[$relation] = $this->relationships[$relation] ?? [];
                $this->relationships[$relation][$name] =
                    $field instanceof MediaField
                    ? $this->model->{$relation}->all()
                    : $this->model->{$relation}->pluck($relationship->getRelatedKeyName());
            }

            $this->rules[$field->getName()] = $field->getRules();
        }
    }

    public function actions()
    {
        return [
            'submit' => 'Save',
        ];
    }

    protected function schema()
    {
        $components = [];
        foreach ($this->model->getAttributes() as $key => $value) {
            $components[] = TextInput::make($key);
        }
        return $components;
    }

    public function getFormComponentsProperty()
    {
        if (empty($this->cachedComponents)) {
            $this->cachedComponents = collect($this->schema())->each(function ($component) {
                $component->parent($this);
            })->all();
        }

        return $this->cachedComponents;
    }

    public function getFields(array | Arrayable $components): array
    {
        $fields = [];
        foreach ($components as $component) {
            if ($component instanceof Field) {
                $fields[] = $component;
            } elseif ($component instanceof Container) {
                $fields = array_merge($fields, $this->getFields($component->getComponents()));
            }
        }

        return $fields;
    }

    public function getRules()
    {
        $rules = [];
        foreach ($this->getFields($this->form_components) as $field) {
            $rules[$field->getName()] = $field->getRules();
        }
        
        return $rules;
    }

    public function save()
    {
        $this->validate($this->getRules());

        $this->model->save();

        foreach ($this->relationships as $relation => $values) {
            $relationship = $this->model->{$relation}();
            if ($relationship->getRelated() instanceof Media) {
                $mediaArray = Arr::flatten($values, 1);
                $pivotArray = collect($mediaArray)->mapWithKeys(function ($media, $index) {
                    return [$media['id'] => [
                        'order' => $index,
                    ]];
                });
                $this->model->{$relation}()->sync($pivotArray);
            } else {
                $values = Arr::flatten($values);
                if (get_class($relationship) == BelongsToMany::class) {
                    $this->model->{$relation}()->sync($values);
                }
            }
        }

        toastr()->success('Data saved successfully.', 'Saved');        
    }

    public function render()
    {
        return view('admin::livewire.form', ['components' => $this->form_components]);
    }
}
