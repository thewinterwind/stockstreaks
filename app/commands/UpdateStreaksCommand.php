<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class UpdateStreaksCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'ss:update-streaks';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Update the stock streaks';

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
        $force = $this->argument('force');

		(new \SS\Stock\Stock)->store_streaks($force);
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
