<?php

use Illuminate\Database\Seeder;

class MercuriusDatabaseSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            MercuriusUsersTableSeeder::class,
            MercuriusMessagesTableSeeder::class,
        ]);
    }
}
