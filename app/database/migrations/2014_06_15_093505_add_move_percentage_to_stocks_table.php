<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMovePercentageToStocksTable extends Migration {

	/**
	 * Run the migrations.
	 */
	public function up()
	{
		Schema::table('stocks', function(Blueprint $table)
		{
			$table->double('move_percentage', 12, 1)->default(0.0)->after('streak');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down()
	{
		Schema::table('stocks', function(Blueprint $table)
		{
			$table->dropColumn('move_percentage');
		});
	}

}
