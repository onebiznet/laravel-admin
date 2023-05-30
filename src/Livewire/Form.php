<?php

namespace OneBiznet\Admin\Livewire;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Arr;
use Illuminate\View\ComponentSlot;
use Livewire\Component;
use OneBiznet\Admin\Models\Media;
use OneBiznet\Admin\View\Form\Container;
use OneBiznet\Admin\View\Form\Field;
use OneBiznet\Admin\View\Form\MediaField;
use OneBiznet\Admin\View\Form\TextInput;
use OneBiznet\Admin\View\Traits\HasComponents;

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
            $rules = array_merge($rules, $field->getRules());
        }

        return $rules;
    }

    public function getSlot()
    {
        return '';
    }

    public function save()
    {
        $this->validate($this->getRules());

        $this->model->save();

        foreach ($this->relationships as $relation => $values) {
            $relationship = $this->model->{$relation}();
            $relatedModel = $relationship->getRelated();
            if ($relatedModel instanceof Media) {
                $mediaArray = Arr::flatten($values, 1);
                $pivotArray = collect($mediaArray)->mapWithKeys(function ($media, $index) {
                    return [$media['id'] => [
                        'order' => $index,
                    ]];
                });
                $this->model->{$relation}()->sync($pivotArray);
            } else {
                $values = Arr::flatten($values);
                switch (get_class($relationship)) {
                    case BelongsToMany::class:
                    case MorphToMany::class:
                        $this->model->{$relation}()->sync($values);
                        break;

                    case HasMany::class:
                        $this->model->{$relation}()->saveMany($relatedModel::find($values));
                }
            }
        }

        toastr()->success('Data saved successfully.', 'Saved');
    }

    public function render()
    {
        return view('admin::livewire.form', ['components' => $this->form_components, 'slot' => $this->getSlot()])
            ->layout('admin-layout');
    }
}
