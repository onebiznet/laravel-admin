<?php 

namespace OneBiznet\Admin\View\Navigation;

use Closure;

class NavigationItem
{
    protected ?string $group = null;

    protected ?Closure $isActiveWhen = null;

    protected ?string $icon = null;

    protected ?string $label = null;

    protected ?string $badge = null;

    protected ?string $badgeColor = null;

    protected ?int $sort = null;

    final public function __construct(?string $label = null)
    {
        if (filled($label)) {
            $this->label($label);
        }
    }

    public static function make(?string $label = null): static
    {
        return app(get_called_class(), ['label' => $label]);
    }

    public function badge(?string $badge, ?string $color = null): static
    {
        $this->badge = $badge;
        $this->badgeColor = $color;

        return $this;
    }

    public function group(?string $group): static
    {
        $this->group = $group;

        return $this;
    }

    public function icon(string $icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    public function isActiveWhen(Closure $callback): static
    {
        $this->isActiveWhen = $callback;

        return $this;
    }

    public function label(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function sort(?int $sort): static
    {
        $this->sort = $sort;

        return $this;
    }

    public function getBadge(): ?string
    {
        return $this->badge;
    }

    public function getBadgeColor(): ?string
    {
        return $this->badgeColor;
    }

    public function getGroup(): ?string
    {
        return $this->group;
    }

    public function getIcon(): ? string
    {
        return $this->icon;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function getSort(): int
    {
        return $this->sort ?? -1;
    }

    public function isActive(): bool
    {
        $callback = $this->isActiveWhen;

        if ($callback === null) {
            return false;
        }

        return app()->call($callback);
    }
}