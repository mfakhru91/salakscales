<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddResponsiblePersonToBookkeepingJournals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookkeeping_journals', function (Blueprint $table) {
            $table->string('responsible_person');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookkeeping_journals', function (Blueprint $table) {
            $table->dropColumn('responsible_person');
        });
    }
}
