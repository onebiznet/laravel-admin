<?php 

namespace OneBiznet\Admin\Providers;

use Closure;
use Illuminate\Contracts\Support\Arrayable;
use OneBiznet\Admin\Models\Media;
use OneBiznet\Admin\View\Navigation\NavigationBuilder;
use OneBiznet\Admin\View\Navigation\NavigationGroup;
use OneBiznet\Admin\View\Navigation\NavigationLink;

class AdminPanel 
{
    protected ?Closure $navigationBuilder =  null;

    public function navigation(Closure $builder): void
    {
        $this->navigationBuilder = $builder;
    }

    public function navigationItems(): array | Arrayable
    {
        if ($this->navigationBuilder === null) {
            $this->navigation(function (NavigationBuilder $builder): NavigationBuilder {
                return $builder->items([
                    NavigationLink::make('Dashboard')
                        ->icon('fas fa-home')
                        ->url(route('admin.home'))
                        ->isActiveWhen(fn () => request()->routeIs('admin.home')),
                    NavigationLink::make('Settings')
                        ->icon('fa-cog')
                        ->url('/'),
                    NavigationGroup::make('Users')
                        ->icon('fas fa-user')
                        ->items([
                            NavigationLink::make('All Users')
                                ->icon('fas fa-users')
                                ->url(route('admin.users.index'))
                                ->isActiveWhen(function () {
                                    return request()->routeIs('admin.users.index');
                                })
                        ])
                ]);
            });
        }

        $builder = app()->call($this->navigationBuilder);

        return $builder->getNavigation();
    }

    public function media()
    {
        return Media::query();
    }

    public function logoUrl()
    {
        return asset('vendor/admin/img/AdminLTELogo.png');
    }
}