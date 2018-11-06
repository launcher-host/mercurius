<?php

namespace Launcher\Mercurius\Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User;
use Launcher\Mercurius\Tests\TestCase;

class ConversationTest extends TestCase
{
	protected $migrate = true;

    public function test_getting_conversations()
    {
    	$user = $this->userFactory()->create();

    	$messageA = $this->messageFactory()->create([
    		'sender_id' => $user->id,
    	]);

    	$messageB = $this->messageFactory()->create([
    		'receiver_id' => $user->id,
    	]);

    	$users = User::all();

    	$response = $this->actingAs($user)
    		->get('/conversations')
    		->assertOk()
    		->assertJson([
    			[
    				'id' => '2',
    				'user' => $users->find(2)->name,
    				'avatar' => $users->find(2)->avatar,
    				'is_online' => '1',
    				'sender' => '1',
    				'message' => $messageA->message,
    				'seen_at' => Carbon::now()->toDateTimeString(),
    				'created_at' => Carbon::now()->toDateTimeString(),
    			],
    			[
    				'id' => '3',
    				'user' => $users->find(3)->name,
    				'avatar' => $users->find(2)->avatar,
    				'is_online' => '1',
    				'sender' => '3',
    				'message' => $messageB->message,
    				'seen_at' => Carbon::now()->toDateTimeString(),
    				'created_at' => Carbon::now()->toDateTimeString(),
    			]
    		]);
    }

    public function test_getting_recipients() {}
    public function test_getting_converstion_with_given_user() {}
    public function test_deleting_conversation() {}
}
