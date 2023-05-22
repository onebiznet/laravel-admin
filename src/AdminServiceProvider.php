<?php

namespace OneBiznet\Admin;

use App\Models\User;
use Butschster\Head\Facades\PackageManager;
use Butschster\Head\Packages\Package;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Http\Request;
use OneBiznet\Admin\Providers\RouteServiceProvider;
use OneBiznet\Admin\View\Layout\AdminLayout;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use Laravel\Fortify\Fortify;
use Livewire\Livewire;
use OneBiznet\Admin\Facades\Admin;
use OneBiznet\Admin\Providers\AdminPanel;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class, true);

        $this->mergeConfigFrom(__DIR__ . '/../config/admin.php', 'admin');

        $this->app->afterResolving(BladeCompiler::class, function () {
            Blade::component('admin-layout', AdminLayout::class);

            Blade::componentNamespace('\\OneBiznet\\Admin\View\\Components', 'admin');
        });

        $this->app->singleton('admin-panel', function () {
            return new AdminPanel();
        });

        AliasLoader::getInstance()->alias('Admin', Admin::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'admin');

        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'admin');

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');        

        $this->registerMetaTags();

        $this->registerLivewireComponents();

        $this->publishes([
            __DIR__ . '/../resources/css' => public_path('vendor/admin/css'),
            __DIR__ . '/../resources/js' => public_path('vendor/admin/js'),
            __DIR__ . '/../resources/img' => public_path('vendor/admin/img'),
        ], 'admin-assets');

        Fortify::viewPrefix('admin::auth.');

        Fortify::authenticateUsing(function (Request $request) {
            if ($user = User::where('email', $request->username)
                ->orWhere('username', $request->username)
                ->orWhere('phone', ltrim($request->username, '0'))
                ->first()
            ) {

                if (Hash::check($request->password, $user->password)) {
                    return $user;
                }
            }
        });
    }

    private function registerMetaTags()
    {
        PackageManager::create('jquery', function (Package $package) {
            $package->addScript(
                'jquery.js',
                'https://code.jquery.com/jquery-3.6.4.min.js',
                ['integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8="', 'crossorigin="anonymous"'],
                'head'
            );
        });

        PackageManager::create('bootstrap-4', function (Package $package) {
            $package->addScript(
                'bootstrap-bundle.js',
                'https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js',
                ['integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"', 'crossorigin="anonymous"'],
            )->requires('jquery');

            // $package->addScript(
            //     'bootstrap-bundle.js',
            //     'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js',
            //     ['integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"', 'crossorigin="anonymous'],
            // )->addStyle(
            //     'bootstrap.css',
            //     'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css"',
            //     ['integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ"', 'crossorigin="anonymous']
            // )->requires('jquery');
        });

        PackageManager::create('adminlte', function (Package $package) {
            $package->addStyle(
                'adminlte.css',
                'https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css',
            )->addScript(
                'adminlte.js',
                'https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js',
            )->requires('bootstrap-4', 'fontawesome', 'flag-icons');
        });

        PackageManager::create('intl-tel-input', function (Package $package) {
            $package->addStyle(
                'intl-tel-input.css',
                'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.1.5/css/intlTelInput.css'
            )->addScript(
                'intl-tel-input.js',
                'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.1.5/js/intlTelInput.min.js'
            );
        });

        PackageManager::create('alpinejs', function (Package $package) {
            $package->addScript(
                'alpine.js',
                'https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js',
                ['defer'],
            );
        });

        PackageManager::create('flag-icons', function (Package $package) {
            $package->addStyle(
                'flag-icons.css',
                'https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css'
            );
        });

        PackageManager::create('fontawesome', function (Package $package) {
            $package->addStyle(
                'fontawesome.css',
                'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css'
            );
        });

        PackageManager::create('tom-select', function (Package $package) {
            $package->addStyle(
                'tom-select.css',
                'https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.min.css',
            )->addScript(
                'tom-select.js',
                'https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js',
            );
        });

        PackageManager::create('tom-select-bootstrap', function (Package $package) {
            $package->addStyle(
                'tom-select-bootstrap.css',
                'https://cdnjs.cloudflare.com/ajax/libs/tom-select/2.2.2/css/tom-select.bootstrap4.min.css'
            )->addScript(
                'tom-select.js',
                'https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js',
            );
        });

        PackageManager::create('iconpicker', function (Package $package) {
            $package->addStyle(
                'iconpicker.css',
                'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-iconpicker/1.10.0/css/bootstrap-iconpicker.min.css',
            )->addScript(
                'iconpicker.js',
                'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-iconpicker/1.10.0/js/bootstrap-iconpicker.bundle.min.js',
            )->requires(
                'bootstrap-4', 'fontawesome'
            );
        });

        PackageManager::create('tinymce', function (Package $package) {
            $package->addScript(
                'tinymce.js',
                'https://cdn.tiny.cloud/1/kfsgnh30zk1ds8gzx7acydwfuy5sjob8sr1uru36cniceypi/tinymce/6/tinymce.min.js',
                ['referrerpolicy="origin"'],
                'head',
            );
        });

        PackageManager::create('filepond', function (Package $package) {
            $package->requires(
                'filepond-file-validate-type',
                'filepond-file-validate-size',
                'filepond-image-preview',
                'filepond-file-poster',
                'filepond-image-crop',
            );
            
            $package->addStyle(
                'filepond.css',
                'https://unpkg.com/filepond@^4/dist/filepond.css',
            )->addScript(
                'filepond.js',
                'https://unpkg.com/filepond@^4/dist/filepond.js'
            );
        });

        PackageManager::create('filepond-file-validate-type', function (Package $package) {
            $package->addScript(
                'filepond-file-validate-type.js',
                'https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js'
            );
        });

        PackageManager::create('filepond-file-validate-size', function (Package $package) {
            $package->addScript(
                'filepond-file-validate-size.js',
                'https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js'
            );
        });

        PackageManager::create('filepond-image-preview', function (Package $package) {
            $package->addStyle(
                'filepond-image-preview.css',
                'https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css',
            )->addScript(
                'filepond-image-preview.js',
                'https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js'
            );
        });

        PackageManager::create('filepond-file-poster', function (Package $package) {
            $package->addStyle(
                'filepond-file-poster.css',
                'https://unpkg.com/filepond-plugin-file-poster/dist/filepond-plugin-file-poster.css',
            )->addScript(
                'filepond-file-poster.js',
                'https://unpkg.com/filepond-plugin-file-poster/dist/filepond-plugin-file-poster.js'
            );
        });

        PackageManager::create('filepond-image-crop', function (Package $package) {
            $package->addScript(
                'filepond-image-crop.js',
                'https://unpkg.com/filepond-plugin-image-crop/dist/filepond-plugin-image-crop.js',
            );
        });

        PackageManager::create('draganddrop', function (Package $package) {
            $package->addStyle(
                'draganddrop.css',
                asset('vendor/admin/css/draganddrop.css'),
            )->addScript(
                'draganddrop.js',
                asset('vendor/admin/js/draganddrop.js')
            );
        });

        PackageManager::create('flatpickr', function (Package $package) {
            $package->addStyle(
                'flatpickr.css',
                'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css'
            )->addScript(
                'flatpickr.js',
                'https://cdn.jsdelivr.net/npm/flatpickr'
            );
        });


    }

    private function registerLivewireComponents()
    {
        Livewire::component('data-table', \OneBiznet\Admin\Livewire\DataTables\DataTable::class);
        Livewire::component('user-table', \OneBiznet\Admin\Livewire\DataTables\UserDataTable::class);
        Livewire::component('role-table', \OneBiznet\Admin\Livewire\DataTables\RoleDataTable::class);
        Livewire::component('permission-table', \OneBiznet\Admin\Livewire\DataTables\PermissionDataTable::class);

        Livewire::component('form', \OneBiznet\Admin\Livewire\Form::class);
        Livewire::component('user-form', \OneBiznet\Admin\Livewire\Forms\UserForm::class);
        Livewire::component('role-form', \OneBiznet\Admin\Livewire\Forms\RoleForm::class);
        Livewire::component('permission-form', \OneBiznet\Admin\Livewire\Forms\PermissionForm::class);

        Livewire::component('gallery', \OneBiznet\Admin\Livewire\Gallery::class);
    }
}
