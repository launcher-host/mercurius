<?php

namespace Launcher\Mercurius\Tests;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User;
use Launcher\Mercurius\Models\Message;
use Illuminate\Support\Facades\Artisan;
use Launcher\Mercurius\MercuriusServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
	use HandlesExceptions;

	protected $migrate = false;

	public function setUp()
	{
        Carbon::setTestNow(Carbon::parse('2099-01-01 00:00:00'));

		parent::setUp();

		if ($this->migrate) {
			$this->migrate();
		}

		$this->withFactories(__DIR__.'/Factories');

        $this->disableExceptionHandling();
	}

	protected function getPackageProviders($app)
	{
	    return [
	    	MercuriusServiceProvider::class,
	    ];
	}

    protected function userFactory()
    {
    	return factory(User::class);
    }

    protected function messageFactory()
    {
    	return factory(Message::class);
    }

    protected function migrate()
    {
    	$this->loadLaravelMigrations();

		Artisan::call('vendor:publish', [
            '--tag' => 'mercurius-migrations',
        ]);

        Carbon::setTestNow();

		$this->artisan('migrate');
    }
}
