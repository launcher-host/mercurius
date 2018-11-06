<?php

namespace Launcher\Mercurius\Tests\Feature;

use Launcher\Mercurius\Tests\TestCase;

class ConversationTest extends TestCase
{
	protected $migrate = true;

    public function test_getting_conversations()
    {
    	$user = $this->userFactory()->create();

    	$conversation = $this->conversationFactory()->create();

    	$response = $this->actingAs($user)
    		->get('/conversations')
    		->assertOk();

    	dd($response->original);
    }

    public function test_getting_recipients() {}
    public function test_getting_converstion_with_given_user() {}
    public function test_deleting_conversation() {}
}
