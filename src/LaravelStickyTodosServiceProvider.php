<?php

namespace AhmetBarut\LaravelStickyTodos;

use AhmetBarut\LaravelStickyTodos\Middleware\InjectStickyTodo;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class LaravelStickyTodosServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/sticky-todos.php', 'sticky-todos');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (!Schema::hasTable('todo_sticky_notes')) {
            return;
        }
        if (config('sticky-todos.enabled') === false) {
            return;
        }

        $this->app[Kernel::class]->appendMiddlewareToGroup('web', InjectStickyTodo::class);

        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'sticky-todos-views');

        $this->publishes([
            __DIR__ . '/../config/sticky-todos.php' => config_path('sticky-todos.php'),
        ], 'sticky-todos-config');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/sticky-todos'),
        ], 'sticky-todos-views');

        $this->publishes([
            __DIR__ . '/../public' => public_path('vendor/sticky-todos'),
        ], 'sticky-todos-public');
    }
}
