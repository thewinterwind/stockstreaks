<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSummaryUpdatedToStocksTable extends Migration {

	/**
	 * This column indicates when the stock's history (past trades) was last updated 
	 */
	public function up()
	{
		Schema::table('stocks', function(Blueprint $table)
		{
			$table->date('summary_updated')->after('updated_at');
		});
	}

	/**
	 * Reverse the migration.
	 */
	public function down()
	{
		Schema::table('stocks', function(Blueprint $table)
		{
			$table->dropColumn('summary_updated');
		});
	}

}
