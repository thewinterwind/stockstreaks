<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHaveHistoryToStocksTable extends Migration {

	/**
	 * This field indicates whether we've retrieved the CSV for the stock's trading history
	 */
	public function up()
	{
		Schema::table('stocks', function(Blueprint $table)
		{
			$table->tinyInteger('have_history')->default(0)->after('market_cap');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down()
	{
		Schema::table('stocks', function(Blueprint $table)
		{
			$table->dropColumn('have_history');
		});
	}

}
