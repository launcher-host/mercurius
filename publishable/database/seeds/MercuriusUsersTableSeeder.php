<?php

use Illuminate\Database\Seeder;

class MercuriusUsersTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        // Seed Mercurius Demo Users
        //
        $this->createUser('Ian Fox', 'ian@launcher.host', 'avatar_ian.png');
        $this->createUser('Noa Robison', 'noa@launcher.host', 'avatar_noa.png');
        $this->createUser('Lua Adison', 'lua@launcher.host', 'avatar_lua.png');

        // Seed random users
        factory(config('mercurius.models.user'), 20)->create();
    }

    /**
     * Insert single User.
     *
     * @param string $name
     * @param string $email
     */
    private function createUser($name, $email, $avatar)
    {
        $uf = config('mercurius.user_field_names');

        factory(config('mercurius.models.user'))->make([
            'email'       => $email,
            $uf['name']   => $name,
            $uf['avatar'] => 'vendor/mercurius/img/avatar/'.$avatar,
            'password'    => bcrypt('password'),
        ]);
    }
}
