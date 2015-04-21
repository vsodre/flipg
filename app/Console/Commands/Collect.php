<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

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
        date_default_timezone_set('America/Los_Angeles');
	}
    
    protected function create_post_doc($item, $channel)
    {
        //TODO: Add type and metadata to the document
        $doc = array("channel"       => $channel,
                     "publish_date"  => $item->get_local_date(),
                     "body"          => $item->get_description(),
                     "permalink"     =>  $item->get_permalink());
        return $doc;
    }
    
    protected function insert_first_time($feed, $channel)
    {
        $elems_to_insert = array();
        foreach($feed->get_items() as $item)
        {
            echo $item->get_title();
            $elems_to_insert[] = $this->create_post_doc($item, $channel["_id"]);
        }
        return $elems_to_insert;
    }
    
    protected function insert($feed, $channel)
    {
        /*
            To avoid opening more than one connection with the database,
            I check if I have inserted the post by the date or by the permalink.
            I check by the permalink only if the post don't have a pubdate field on the rss file.
        */
        
        $elems_to_insert = array();
        foreach($feed->get_items() as $item)
        {
            if($item->get_local_date() != NULL)
            {
                if($item->get_local_date() > $channel["last_date_collected"])
                    $elems_to_insert[] = $this->create_post_doc($item, $channel["_id"]);
                else break;
            }
            else
            {
                $docQuery = array('permalink' => $item->get_permalink());
                if(\DB::getCollection("posts")->findOne($docQuery) == NULL)
                    $elems_to_insert[] = $this->create_post_doc($item, $channel["_id"]);
                else break;
            }
        }
        return $elems_to_insert;
    }

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
        /* Using https://github.com/willvincent/feeds */
        
        $cursor = \DB::getCollection("channel")->find();
        $elems_to_insert = array();
        
        // Foreach channel present at mongodb
        foreach($cursor as $channel)
        {
            $sp = \App::make('Feeds');
            $feed = $sp->make($channel["_id"]); // The _id is the link of the feedi
            
            // If there is no post of this channel on the database, I add everything on it.
            if(\DB::getCollection("posts")->count(array("channel" => $channel["_id"])) == 0)
                $elems_to_insert = $this->insert_first_time($feed, $channel);
            else
                $elems_to_insert = $this->insert($feed, $channel);
            
            if(count($elems_to_insert) > 0)
                \DB::getCollection("posts")->batchInsert($elems_to_insert);
        }
	}

	/**
	 * Get the console command arguments.
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