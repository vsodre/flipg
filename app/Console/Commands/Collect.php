<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use App\Channel;
use App\Services\Crawler;

class Collect extends Command
{    
	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'collect';
    
	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'This command update all the posts of all the channels';
    
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
        /* Using https://github.com/willvincent/feeds */
        
        $cursor = Channel::all();
        
        // Foreach channel present at mongodb
        foreach($cursor as $channel)
        {
            $crawler = new Crawler($channel);
            $crawler->updateItems();
        }
	}

	/*
	 * Get the console command arguments.
	 * 
     * NULL if it's the cronjob calling the crawler
     * The _id of the channel if it's the channel service calling
     * 
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			['example', InputArgument::REQUIRED, 'An example argument.'],
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
			['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
		];
	}

}
