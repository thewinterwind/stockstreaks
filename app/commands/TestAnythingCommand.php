<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class TestAnythingCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'test';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Test anything';

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
        $symbol = $this->argument('symbol');
        $streak = (int) str_replace('n', '-', $this->argument('streak'));

        // $result = (new \SS\Stock\Stock)->calculateMovePercentage('ZX', -4);
		$result = (new \SS\Stock\Stock)->calculateMovePercentage($symbol, $streak);

        dd($result);
	}

    protected function getArguments()
    {
        return array(
            array('symbol', InputArgument::OPTIONAL, 'Symbol name'),
            array('streak', InputArgument::OPTIONAL, 'Streak amount'),
        );
    }

}
