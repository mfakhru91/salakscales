<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationGradingToGradedItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('graded__items', function (Blueprint $table) {
            $table->foreignId('grading_id')->nullable();
            $table->foreign('grading_id')->references('id')->on('gradings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('graded__items', function (Blueprint $table) {
            $table->dropForeign('grading_id');
        });
    }
}
