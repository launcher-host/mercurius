<?php

use Illuminate\Database\Migrations\Migration;

class AddMercuriusUserFields extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->string('avatar')->nullable()->after('email');
            $table->boolean('is_online')->default(true);
            $table->boolean('be_notified')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        if (Schema::hasColumn('users', 'avatar')) {
            Schema::table('users', function ($table) {
                $table->dropColumn('avatar');
            });
        }

        Schema::table('users', function ($table) {
            $table->dropColumn('is_online');
            $table->dropColumn('be_notified');
        });
    }
}
