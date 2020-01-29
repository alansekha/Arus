<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserCounters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        schema::create('user_counters', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->ondelete('cascade')
                ->onChange('cascade');
            $table->bigInteger('counter_id')->unsigned();
            $table->foreign('counter_id')
                ->references('id')->on('counters')
                ->onDelete('cascade')
                ->onChange('cascade');
            $table->bigInteger('queue_number');
            $table->enum('is_processed', ['process', 'waiting', 'finished']);
            $table->date('date');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
