<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use App\Channel;

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
    
    protected function create_post_doc($item, $channelId)
    {
        //TODO: Add type and metadata to the document
        $doc = array("channel"       => $channelId,
                     "publish_date"  => $item->get_local_date(),
                     "body"          => $item->get_description(),
                     "permalink"     =>  $item->get_permalink());
        return $doc;
    }
    
    protected function insert_first_time($feed, $channelid)
    {
        $elems_to_insert = array();
        foreach($feed->get_items() as $item)
        {
            $elems_to_insert[] = $this->create_post_doc($item, $channelid);
        }
        return $elems_to_insert;
    }
    
    protected function insert($feed, $channelid, $channelLastDate)
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
                if($item->get_local_date() > $channelLastDate)
                    $elems_to_insert[] = $this->create_post_doc($item, $channelid);
                else break;
            }
            else
            {
                $docQuery = array('permalink' => $item->get_permalink());
                if(\DB::getCollection("posts_collection")->findOne($docQuery) == NULL)
                    $elems_to_insert[] = $this->create_post_doc($item, $channelid);
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
         
        $cursor = Channel::all();
        $elems_to_insert = array();
        
        // Foreach channel present at mongodb
        foreach($cursor as $channel)
        {
            $sp = \App::make('Feeds');
            $feed = $sp->make($channel->_id); // The _id is the link of the feedi
            
            $last_date_collected = date('Y-m-d H:i:s', $channel->last_date_collected->sec);
            echo $last_date_collected;
            // If there is no post of this channel on the database, I add everything on it.
            if(\DB::getCollection("posts_collection")->count(array("channel" => $channel->_id) == 0))
                $elems_to_insert = $this->insert_first_time($feed, $channel->_id);
            else
                $elems_to_insert = $this->insert($feed, $channel->_id, $last_date_collected);
            
            if(count($elems_to_insert) > 0)
            {
                \DB::getCollection("posts_collection")->batchInsert($elems_to_insert);
                
                echo "ADDED\n";
                $changedChannel = Channel::find($channel->_id);
                $changedChannel->last_date_collected = new \MongoDate(strtotime(date("Y-m-d H:i:s")));
                $changedChannel->save();
            }
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
