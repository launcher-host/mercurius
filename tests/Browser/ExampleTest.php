<?php

namespace Launcher\Mercurius\Tests\Browser;

use Launcher\Mercurius\Tests\DuskTestCase;

class ExampleTest extends DuskTestCase
{
	protected $migrate = true;

    public function test_browsing_frontpage()
    {
        $user = $this->userFactory()->create();

        /*
        $this->browse(function ($browser) use ($user) {
            $response = $browser->loginAs($user)
                ->visit(route('mercurius.home'));
            sleep(10);
        });
        */
    }
}