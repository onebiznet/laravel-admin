<?php

namespace OneBiznet\Admin\Providers;

use Closure;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\Route;
use OneBiznet\Admin\Models\Media;
use OneBiznet\Admin\View\Navigation\NavigationBuilder;
use OneBiznet\Admin\View\Navigation\NavigationGroup;
use OneBiznet\Admin\View\Navigation\NavigationLink;

class AdminPanel
{
    protected ?Closure $navigationBuilder =  null;

    protected $navigation;

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
                        ->route('admin.home')
                        ->sort(0),
                    NavigationLink::make('Settings')
                        ->icon('fas fa-cog')
                        ->sort(10)
                        ->url('/'),
                    NavigationGroup::make('Users')
                        ->icon('fas fa-user')
                        ->sort(3)
                        ->items([
                            NavigationLink::make('All Users')
                                ->icon('fas fa-users')
                                ->route('admin.users.index'),
                            NavigationLink::make('Create User')
                                ->icon('fas fa-user-plus')
                                ->route('admin.users.create'),
                            NavigationLink::make('Roles')
                                ->icon('fas fa-user-tag')
                                ->url(route('admin.roles.index'))
                                ->isActiveWhen(fn () => Route::is('admin.roles.*')),
                            NavigationLink::make('Permissions')
                                ->icon('fas fa-user-check')
                                ->url(route('admin.permissions.index'))
                                ->isActiveWhen(fn () => Route::is('admin.permissions.*')),
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
        return function_exists('global_asset')
            ? global_asset('vendor/admin/img/AdminLTELogo.png')
            : asset('vendor/admin/img/AdminLTELogo.png');
    }
}
