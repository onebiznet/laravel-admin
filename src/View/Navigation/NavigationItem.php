<?php 

namespace OneBiznet\Admin\View\Navigation;

use Closure;
use Illuminate\Contracts\Support\Htmlable;
use OneBiznet\Admin\View\Component;
use OneBiznet\Admin\View\Traits\HasLabel;

class NavigationItem extends Component implements Htmlable
{
    use HasLabel;

    protected string $view = 'admin::components.navigation';

    protected ?string $group = null;

    protected ?Closure $isActiveWhen = null;

    protected ?string $icon = null;

    protected ?string $badge = null;

    protected ?string $badgeColor = null;

    protected ?int $sort = null;

    public function __construct(?string $name = null)
    {        
        if (filled($name)) {
            $this->label($name);
            $this->name($name);
        }
    }

    public static function make(?string $name = null): static
    {
        return new static ($name);
        //return app(get_called_class(), ['label' => $label]);
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

    public function getActive(): bool 
    {
        return $this->isActive();
    }

    public function toHtml()
    {
        return $this->render();
    }
}