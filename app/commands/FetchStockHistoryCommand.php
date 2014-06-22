<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class FetchStockHistoryCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'ss:fetch-stock-history';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = "Download and write the stock's trading history";

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		(new \SS\Stock\Stock)->fetchStockHistory();
	}


}
