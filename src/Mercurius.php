<?php

namespace Launcher\Mercurius;

use Launcher\Mercurius\Setup\ProvidesScriptVariables;

class Mercurius
{
    use ProvidesScriptVariables;

    /**
     * The Mercurius version.
     */
    public static $version = '1.0.0-alpha';

    /**
     * The models used with Mercurius.
     */
    protected $models = [
        'user',
        'message',
    ];

    /**
     * Creates a new instance.
     */
    public function __construct()
    {
        foreach ($this->models as $model) {
            $this->models[$model] = config('mercurius.models.'.$model);
        }
    }

    /**
     * Get model instance by name.
     *
     * @param  string $name
     * @return Illuminate\Database\Eloquent\Model
     */
    public function model(string $name)
    {
        $class = strtolower($name);
        if (!in_array($class, $this->models)) {
            throw new \Exception("[{$class}] class not found.");
        }

        return app($this->models[$class]);
    }

    /**
     * Get the user model instance.
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function user()
    {
        return app($this->models['user']);
    }
}
