<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeHaveHistoryToHistoryUpdatedOnStocksTable extends Migration {

	/**
	 * Store when the history was last updated instead of a simple boolean
	 */
	public function up()
	{
		Schema::table('stocks', function(Blueprint $table)
		{
            $table->dropColumn('have_history');
			$table->date('history_updated')->after('market_cap');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down()
	{
		Schema::table('stocks', function(Blueprint $table)
		{
			$table->dropColumn('history_updated');
            $table->tinyInteger('have_history')->default(0)->after('market_cap');
		});
	}

}
