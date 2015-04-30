<?php namespace App\Services;

class Channel {

    /**
     * Under development. Now it just look for an channel at the database. Later, 
     * it'll register a channel if it doesn't exists. Maybe return this Channel 
     * Service object would be a good idea.
     * @param string $id
     * @return App\Channel
     */
    public static function lookup($id) {
        $channel = \App\Channel::find($id);
        if ($channel)
            return $channel;
        $crawler = new Crawler($id);
        $crawler->updateItems();
        return $crawler->getChannel();
    }

}
