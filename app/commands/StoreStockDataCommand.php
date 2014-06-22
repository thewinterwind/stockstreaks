<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use SS\Stock\Stock;

class StoreStockDataCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'ss:store-stock-data';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Store the daily stock information';

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
        $stockRepo = new Stock;
        $stocks = $stockRepo->getValidStocks();

        foreach ($stocks as $stock)
        {
            $stockRepo->storeStockData($stock->symbol);
        }
	}

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('force', InputArgument::OPTIONAL, 'Whether or not to force an update'),
        );
    }

}
