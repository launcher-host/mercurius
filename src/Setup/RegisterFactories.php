<?php

namespace Launcher\Mercurius\Setup;

use Illuminate\Database\Eloquent\Factory as EloquentFactory;

trait RegisterFactories
{
    /**
     * Register factories.
     *
     * @param  string  $path
     * @return void
     */
    protected function registerEloquentFactoriesFrom($path)
    {
        $this->app->make(EloquentFactory::class)->load($path);
    }
}
