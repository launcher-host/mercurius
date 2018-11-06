<?php

namespace Launcher\Mercurius;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Launcher\Mercurius\Commands\InstallCommand;
use Launcher\Mercurius\Setup\MigrationsHandler;

class MercuriusServiceProvider extends ServiceProvider
{
    use EventMap;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../publishable/views', 'mercurius');
        $this->loadTranslationsFrom(__DIR__.'/../publishable/lang', 'mercurius');
        $this->registerEvents();

        require __DIR__.'/../routes/channels.php';
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerPublishable();
        $this->mergeConfigFrom(__DIR__.'/../publishable/config/mercurius.php', 'mercurius');

        $this->loadHelpers();

        if ($this->app->runningInConsole()) {
            $this->registerConsoleCommands();
        }

        $this->app->singleton('mercurius', function () {
            return new Mercurius();
        });
    }

    /**
     * Register publishable files.
     *
     * @return void
     */
    protected function registerPublishable()
    {
        $_path = __DIR__.'/../publishable/';

        $publishable = [
            'mercurius-config' => ["{$_path}config/mercurius.php" => config_path('mercurius.php')],
            'mercurius-public' => ["{$_path}public" => public_path('vendor/mercurius')],
            'mercurius-sass'   => [__DIR__.'/../resources/sass/' => resource_path('sass/vendor/mercurius')],
            'mercurius-js'     => [__DIR__.'/../resources/js/' => resource_path('js/vendor/mercurius')],
            'mercurius-seeds'  => ["{$_path}database/seeds/" => database_path('seeds')],
            'mercurius-lang'   => ["{$_path}lang/" => resource_path('lang')],
            'mercurius-views'  => ["{$_path}views/" => resource_path('views/vendor/mercurius')],
        ];

        foreach ($publishable as $group => $paths) {
            $this->publishes($paths, $group);
        }

        $this->registerPublishableMigrations();
    }

    /**
     * Register publishable migration files.
     */
    private function registerPublishableMigrations()
    {
        $_migrations = [
            'add_mercurius_user_fields',
            'create_mercurius_messages_table',
            'add_slug_mercurius_user_table',
        ];

        $_publishable = (new MigrationsHandler())->processMigrations($_migrations);

        if ($_publishable && count($_publishable) > 0) {
            $this->publishes($_publishable, 'mercurius-migrations');
        }
    }

    /**
     * Register the commands accessible from the Console.
     */
    private function registerConsoleCommands()
    {
        $this->commands(InstallCommand::class);
    }

    /**
     * Load helpers.
     */
    protected function loadHelpers()
    {
        foreach (glob(__DIR__.'/Helpers/*.php') as $filename) {
            require_once $filename;
        }
    }

    /**
     * Register job events.
     *
     * @return void
     */
    protected function registerEvents()
    {
        $events = $this->app->make(Dispatcher::class);

        foreach ($this->events as $event => $listeners) {
            foreach ($listeners as $listener) {
                $events->listen($event, $listener);
            }
        }
    }
}
