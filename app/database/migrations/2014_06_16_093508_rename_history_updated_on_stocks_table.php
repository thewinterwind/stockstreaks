<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameHistoryUpdatedOnStocksTable extends Migration {

	/**
	 * Rename the column to better reflect whats actually happening
	 */
	public function up()
	{
        Schema::table('stocks', function(Blueprint $table)
        {
            $table->renameColumn('history_updated', 'history_downloaded');
        });
	}

	/**
	 * Reverse the migrations.
	 */
	public function down()
	{
		Schema::table('stocks', function(Blueprint $table)
        {
            $table->renameColumn('history_downloaded', 'history_updated');
        });
	}

}
