<?php

include_once('simplepie/autoloader.php');
include_once('simplepie/idn/idna_convert.class.php');

// Create a new instance of the SimplePie object
$feed = new SimplePie();
$conn = new MongoClient();

$feed->set_feed_url('');
$feed->set_item_class();
$feed->init();
$feed->handle_content_type();

foreach($feed->get_items() as $item)
{
    
}

?>
