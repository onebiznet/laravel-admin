<?php 

namespace OneBiznet\Admin\View;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;
use Illuminate\View\ComponentAttributeBag;
use OneBiznet\Admin\Livewire\Form;
use OneBiznet\Admin\View\Form\Container;
use OneBzinet\Admin\View\Traits\Authorizable;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

abstract class Component 
{
    //use Authorizable;
    
    protected string $view;

    protected ?string $id = null;

    protected ?string $name = null;

    protected Component | Form | null $parent = null;

    protected ComponentAttributeBag $attributes;

    protected static array $propertyCache = [];

    protected static array $methodCache = [];

    public static function make(?string $name = null)
    {
        $instance = new static($name);
        $instance = $instance->id($name);

        return $instance;
    }

    protected function shouldIgnore($name)
    {
        return str_starts_with($name, '__') ||
            in_array($name, $this->ignoredMethods());
    }

    protected function ignoredMethods()
    {
        return [
            '__construct',
            'getData',
            'getView',
            'getParent',
            'render',
        ];
    }

    protected function extractPublicProperties()
    {
        $class = get_class($this);

        $this->attributes = $this->attributes ?: new ComponentAttributeBag();

        if (!isset(static::$propertyCache[$class])) {
            $reflection = new ReflectionClass($this);

            static::$propertyCache[$class] = collect($reflection->getProperties(ReflectionProperty::IS_PUBLIC))
                ->reject(function (ReflectionProperty $property) {
                    return $property->isStatic();
                })
                ->map(function (ReflectionProperty $property) {
                    return $property->getName();
                })->all();
        }

        $values = [];

        foreach (static::$propertyCache[$class] as $property) {
            $values[$property] = $this->{$property};
        }

        return $values;
    }

    protected function extractGetterMethods()
    {
        $class = get_class($this);

        if (!isset(static::$methodCache[$class])) {
            $reflection = new ReflectionClass($this);

            static::$methodCache[$class] = collect($reflection->getMethods(ReflectionMethod::IS_PUBLIC))
                ->reject(function (ReflectionMethod $method) {
                    return strpos($method->getName(), 'get') === false || $this->shouldIgnore($method->getName());
                })
                ->mapWithKeys(function (ReflectionMethod $method) {
                    return [(string) Str::of($method->getName())->after('get')->kebab()->replace('-', '_') => $method->getName()];
                });
        }

        $values = [];

        foreach (static::$methodCache[$class] as $key => $method) {
            $values[$key] = $this->{$method}();
        }

        return $values;
    }

    protected function newAttributeBag(array $attributes = [])
    {
        return new ComponentAttributeBag($attributes);
    }

    public function id($id): self
    {
        $this->id = $id;

        return $this;
    }

    public function name(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function parent(Component | Form $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    public function hasForm(): bool
    {
        if ($this->parent instanceof Form) {
            return true;
        } elseif ($this->parent instanceof Container) {
            return $this->parent->hasForm();
        }

        return false;
    }

    public function getId(): ?string
    {
        return $this->id ?? $this->name;
    }

    public function getName(): ?string
    {
        return $this->name ?? $this->id;
    }

    public function getParent(): Component | Form | null
    {
        return $this->parent;
    }

    public function getForm(): ?Form
    {
        if ($this->parent instanceof Form) {
            return $this->parent;
        }

        if ($this->parent instanceof Component) {
            return $this->parent->getForm();
        }

        return null;
    }

    public function getAttributes()
    {
        $attributes = $this->attributes ?? $this->newAttributeBag([
            'id' => $this->getId(),
            'name' => $this->getName(),
        ]);

        return $attributes;
    }

    public function getSlot() { return ''; }

    public function getData(): array
    {
        $this->attributes = $this->getAttributes();

        return array_merge($this->extractPublicProperties(), $this->extractGetterMethods());
    }

    public function getView(): string
    {
        return $this->view ?? 'admin::components.form.' . Str::snake(last(explode('\\', static::class)));
    }

    public function render()
    {
        return View::first([$this->getView(), 'admin::components.form.component'])->with($this->getData());
    }
}