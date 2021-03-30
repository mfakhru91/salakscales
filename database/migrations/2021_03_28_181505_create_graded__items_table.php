<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradedItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('graded__items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('buyer_Id')->nullable();
            $table->foreignId('note_id')->nullable();
            $table->date('date_time');
            $table->string('new_tonase')->nullable();
            $table->string('old_tonase')->nullable();
            $table->string('price')->nullable();
            $table->string('income')->nullable();
            $table->string('status')->default('0');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('buyer_Id')->references('id')->on('buyers')->onDelete('cascade');
            $table->foreign('note_id')->references('id')->on('notes')->onDelete('cascade');
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
        Schema::dropIfExists('graded__items');
    }
}
