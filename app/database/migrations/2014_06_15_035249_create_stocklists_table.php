<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStocklistsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('stocklists', function($table)
        {
            $table->increments('id');
            $table->string('symbol', 20);
            $table->string('name');
            $table->string('exchange');
            $table->string('ipo_year');
            $table->string('sector');
            $table->string('industry');
            $table->string('last_sale');
            $table->string('market_cap');
            $table->string('summary_link');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('stocklists');
	}

}
