<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipToJournalLedgers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('journal_ledgers', function (Blueprint $table) {
            $table->foreignId('dvitem_id')->nullable();
            $table->foreignId('item_id')->nullable();
            $table->foreignId('bookkeeping_journals_id')->nullable();
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
            $table->foreign('dvitem_id')->references('id')->on('dvitems')->onDelete('cascade');
            $table->foreign('bookkeeping_journals_id')->references('id')->on('bookkeeping_journals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('journal_ledgers', function (Blueprint $table) {
            $table->dropForeign('item_id');
            $table->dropForeign('dvitem_id');
            $table->dropForeign('bookkeeping_journals_id');
        });
    }
}
