<?php

use Illuminate\Database\Migrations\Migration;

class AddMercuriusUserFields extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        $fields = config('mercurius.user_field_names');

        Schema::table('users', function ($table) {
            $table->string($fields['avatar'])->nullable()->after('email');
            $table->string($fields['slug'])->nullable();
            $table->boolean($fields['is_online'])->default(true);
            $table->boolean($fields['be_notified'])->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        $fields = config('mercurius.user_field_names');

        Schema::table('users', function ($table) {
            $table->dropColumn($fields['avatar']);
            $table->dropColumn($fields['slug']);
            $table->dropColumn($fields['is_online']);
            $table->dropColumn($fields['be_notified']);
        });
    }
}
