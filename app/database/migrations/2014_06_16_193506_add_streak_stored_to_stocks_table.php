<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStreakStoredToStocksTable extends Migration {

	/**
	 * The date the streak was stored on
	 */
	public function up()
	{
		Schema::table('stocks', function(Blueprint $table)
		{
			$table->date('streak_stored')->after('streak');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down()
	{
		Schema::table('stocks', function(Blueprint $table)
		{
			$table->dropColumn('streak_stored');
		});
	}

}
