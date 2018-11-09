<?php

use Illuminate\Database\Migrations\Migration;

class AddSlugMercuriusUserTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (!Schema::hasColumn('users', 'slug')) {
            Schema::table('users', function ($table) {
                $table->string('slug')->nullable()->after('email');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('users', function ($table) {
            $table->dropColumn('slug');
        });
    }
}
