<?php

namespace Launcher\Mercurius\Tests\Feature;

use Launcher\Mercurius\Tests\TestCase;

class ProfileTest extends TestCase
{
	protected $migrate = true;

    public function test_refreshing_profile()
    {
    	$user = $this->userFactory()->create();

    	$response = $this->actingAs($user)
    		->get('/profile/refresh')
    		->assertOk()
    		->assertJson(array_except($user->toArray(), [
    			'email', 'password', 'remember_token', 'updated_at', 'created_at'
    		]));
    }

    public function test_getting_notifications() {}
    public function test_updating_profile() {}
}
