<?php namespace App\Services;

use App\Channel;
use App\Post;

class Crawler {

    private $feed;

    private $channel;

    public function __construct($channel) {
        date_default_timezone_set('America/Los_Angeles');
        $simplepie = \App::make('Feeds');
        if ($channel instanceof Channel) {
            $this->channel = $channel;
            $this->feed = $simplepie->make($this->channel->_id);
        } else {
            $this->feed = $simplepie->make($channel);
            $this->createChannel($channel);
        }
    }

    public function getChannel() {
        return $this->channel;
    }

    protected function createChannel($id) {
        $this->channel = new Channel();
        $this->channel->title = $this->feed->get_title();
        $this->channel->link = $this->feed->get_permalink();
        $this->channel->description = $this->feed->get_description();
        $this->channel->_id = $id;
        ;
        $this->channel->last_date_collected = NULL;
        $this->channel->save();
    }

    protected function create_post_doc($item, $channelId) {
        //TODO: Add type and metadata to the document
        $doc = array("channel" => $channelId,
            "title" => $item->get_title(),
            "publish_date" => $item->get_local_date(),
            "body" => $item->get_description(),
            "permalink" => $item->get_permalink());
        return $doc;
    }

    protected function insert_first_time($channelid) {
        $elems_to_insert = array();
        foreach ($this->feed->get_items() as $item)
            $elems_to_insert[] = $this->create_post_doc($item, $channelid);
        return $elems_to_insert;
    }

    protected function insert($channelid, $channelLastDate) {
        /*
          To avoid opening more than one connection with the database,
          I check if I have inserted the post by the date or by the permalink.
          I check by the permalink only if the post don't have a pubdate field on the rss file.
         */

        $channelDate = strtotime($channelLastDate);
        $elems_to_insert = array();
        foreach ($this->feed->get_items() as $item) {
            // I check if I added this post before by the date or by the permalink, in case there is no date.
            if ($item->get_local_date() != NULL) {
                $itemDate = strtotime($item->get_local_date());
                if ($itemDate > $channelDate)
                    $elems_to_insert[] = $this->create_post_doc($item, $channelid);
                else
                    break;
            }
            else {
                $docQuery = array('permalink' => $item->get_permalink());
                if (Post::raw()->findOne($docQuery) == NULL)
                    $elems_to_insert[] = $this->create_post_doc($item, $channelid);
                else
                    break;
            }
        }
        return $elems_to_insert;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function updateItems() {
        /* Using https://github.com/willvincent/feeds */

        $elems_to_insert = array();

        // If there is no post of this channel on the database, I add everything on it.
        if (!$this->channel->last_date_collected) {
            $elems_to_insert = $this->insert_first_time($this->channel->_id);
        } else {
            $last_date_collected = date('Y-m-d H:i:s', $this->channel->last_date_collected->sec);
            $elems_to_insert = $this->insert($this->channel->_id, $last_date_collected);
        }

        if (count($elems_to_insert) > 0) {
            Post::raw()->batchInsert($elems_to_insert);

            $this->channel->last_date_collected = new \MongoDate(strtotime(date("Y-m-d H:i:s")));
            $this->channel->save();
        }
    }

}

?>
