<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStreakToStocksTable extends Migration {

	/**
	 * Run the migrations.
	 */
	public function up()
	{
		Schema::table('stocks', function(Blueprint $table)
		{
			$table->integer('streak')->default(0)->after('exchange');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down()
	{
		Schema::table('stocks', function(Blueprint $table)
		{
			$table->dropColumn('streak');
		});
	}

}
