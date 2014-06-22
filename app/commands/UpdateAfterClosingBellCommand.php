<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class UpdateAfterClosingBellCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'ss:closing-bell-update';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = "Update the data after closing bell (called by a cron)";

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
        // store the new stock data
        $data['feedback'] = $this->call('ss:store-stock-data');

        $this->notify_admin($data, 'Stock data update status report');

        // update the streaks using the new data
        $data['feedback'] = $this->call('ss:update-streaks');

        $this->notify_admin($data, 'Streak update status report');
	}

    protected function notify_admin(array $data, $subject)
    {
        Mail::send('emails.cron.basic', $data, function($message)
        {
            $message->to(Config::get('app.owner_email'))->subject($subject);
        });
    }

}
