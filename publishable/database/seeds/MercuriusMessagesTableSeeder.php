<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MercuriusMessagesTableSeeder extends Seeder
{
    /**
     * Dummy conversation string.
     *
     * @var array
     */
    private $dummyConversation = [
        'Hello!',
        'Hi there!',
        'How are you? :)',
        'Great TY! enjoying the paradise. What about you?',
        'Paradise ?!? plz send me your GPS coords',
        'Sure! on the way!',
    ];

    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('mercurius_messages')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $ian = $this->getUser('ian@launcher.host');
        $noa = $this->getUser('noa@launcher.host');
        $lua = $this->getUser('lua@launcher.host');

        $this->createConversation($lua, $ian);
        $this->createConversation($ian, $noa);
        $this->createConversation($lua, $noa);

        $this->createDummyUsersConversations($ian, $noa, $lua);
    }

    /**
     * Creates a conversation for 2 users.
     *
     * @param int $user_a
     * @param int $user_b
     */
    private function createConversation($user_a, $user_b)
    {
        // Place a message dated 1 year ago
        $_dt = Carbon::now()->subYear()->subDays(10)->subHours(7);
        $this->addMessage('Hello 1 Year ago 01!', $user_a, $user_b, $_dt);
        $this->addMessage('Hello 1 Year ago 02!', $user_a, $user_b, $_dt->addHours(7));

        // Place messages dated some months ago
        // Add plenty of messages to test scroll w/ lazy load
        $_dt->addMonth(5);
        for ($i = 1; $i < 60; $i++) {
            $_msg = 'Hello 6M ago, testing message number '.$i;
            $this->addMessage($_msg, $user_a, $user_b, $_dt->addHours(5));
        }

        $i = 0;
        $_dt = Carbon::now()->subDays(rand(4, 10));
        foreach ($this->dummyConversation as $msg) {
            $_sender = ($i % 2 ? $user_a : $user_b);
            $_receiver = ($i % 2 ? $user_b : $user_a);

            $this->addMessage($msg, $_sender, $_receiver, $_dt->addHours(7));
            $i++;
        }
    }

    /**
     * Create conversations for dummy users.
     *
     * This is useful for testing the scroll behaviour at the conversations list
     * and the display of dates.
     *
     * @return void
     */
    private function createDummyUsersConversations(...$demoUsers)
    {
        // We have seeded 3 demo users previously, we will use this users to
        // create the dummy messages.
        //
        $dummyUsers = config('mercurius.models.user')::where(
                        'id', '>', end($demoUsers)
                    )->get();

        $_dt = Carbon::now()->subDays(3);
        foreach ($dummyUsers as $user) {
            $_dt->subDays(42);
            $this->createDummyConversations($_dt, $user, $demoUsers);
        }
    }

    /**
     * Create dummy conversations with demo users.
     *
     * @return void
     */
    private function createDummyConversations($dt, $dummyUser, $demoUsers)
    {
        foreach ($demoUsers as $demoUser) {
            $_msg = 'Hello from '.$dummyUser->name;
            $this->addMessage($_msg, $dummyUser->id, $demoUser, $dt);
        }
    }

    /**
     * Add message.
     *
     * @return array
     */
    private function addMessage($message, $sender_id, $receiver_id, $datetime)
    {
        DB::table('mercurius_messages')->insert([
            'message'     => $message,
            'sender_id'   => $sender_id,
            'receiver_id' => $receiver_id,
            'created_at'  => $datetime->format('Y-m-d H:i:s'),
            'updated_at'  => $datetime->format('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Retrieves a User.
     *
     * @param string $email
     */
    private function getUser($email)
    {
        return config('mercurius.models.user')::where(
                'email', $email
            )->first()->id;
    }
}
