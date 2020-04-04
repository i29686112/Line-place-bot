<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Conversations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('conversations', function (Blueprint $table) {
            $table->id()->autoIncrement();

            $table->integer('step')->default(0);

            $table->string('type');
            $table->text('note')->comment('In JSON format.');
            $table->string('user_id',100);
            $table->enum('status',['open','closed'])->default('open');
            $table->timestamps();
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
        Schema::dropIfExists('conversations');

    }
}
