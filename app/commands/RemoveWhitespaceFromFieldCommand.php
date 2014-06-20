<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use SS\Database\Database;

class RemoveWhitespaceFromFieldCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'ss:remove-whitespace';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Remove whitespace from a field in a table';

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
        $table = $this->argument('table');
        $field = $this->argument('field');

		(new Database)->remove_whitespace_from_field($table, $field);
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
            array('table', InputArgument::REQUIRED, 'Table name'),
			array('field', InputArgument::REQUIRED, 'Field name'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
