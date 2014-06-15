<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSummariesTable extends Migration {

	/**
	 * Run the migrations.
	 */
	public function up()
	{
		Schema::create('summaries', function($table)
        {
            $table->increments('id');
            $table->string('date', 10);
            $table->string('symbol', 20);
            $table->double('open', 10, 2);
            $table->double('high', 10, 2);
            $table->double('low', 10, 2);
            $table->double('close', 10, 2);
            $table->double('adjusted_close', 10, 2);
            $table->bigInteger('volume');
            $table->timestamp('updated_at');
        });
	}

	/**
	 * Reverse the migrations.
	 */
	public function down()
	{
		Schema::drop('summaries');
	}

}
