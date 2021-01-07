<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalPriceToDvitems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dvitems', function (Blueprint $table) {
            $table->string('new_tonase')->nullable();
            $table->string('old_tonase')->nullable();
            $table->string('price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dvitems', function (Blueprint $table) {
            $table->dropColumn('new_tonase');
            $table->dropColumn('old_tonase');
            $table->dropColumn('price');
        });
    }
}
