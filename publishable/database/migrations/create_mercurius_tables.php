<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMercuriusTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tables = config('mercurius.table_names');

        Schema::create($tables['conversations'], function (Blueprint $table) {
            $table->increments('id');
            $table->text('slug')->index();
            $table->text('name')->nullable();
            $table->timestamps();
        });

        // Schema::create($tables['conversation_user'], function (Blueprint $table) {
        //     $table->integer('conversation_id')->unsigned();
        //     $table->integer('user_id')->unsigned();
        //     $table->timestamps();

        //     $table->foreign('conversation_id')
        //         ->references('id')
        //         ->on($tables['conversations'])
        //         ->onUpdate('cascade')
        //         ->onDelete('cascade');

        //     $table->foreign('user_id')
        //         ->references('id')
        //         ->on($tables['users'])
        //         ->onUpdate('cascade')
        //         ->onDelete('cascade');

        //     $table->primary(['conversation_id', 'user_id']);
        // });

        Schema::create($tables['messages'], function (Blueprint $table) {
            $table->increments('id');
            $table->text('message');
            $table->integer('conversation_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('sender_id')->unsigned();
            $table->timestamp('seen_at')->nullable();
            $table->timestamps();

            $table->foreign('conversation_id')
                ->references('id')
                ->on($tables['conversations'])
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on($tables['users'])
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('sender_id')
                ->references('id')
                ->on($tables['users'])
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tables = config('mercurius.table_names');

        Schema::dropIfExists($tables['messages']);
        Schema::dropIfExists($tables['conversations']);
        // Schema::dropIfExists($tables['conversation_user']);
    }
}
