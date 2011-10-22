<?php

include("rss_feed.php");

$video1 = new RSSItem;
$video1->setTitle("lustiges video");
$video1->setDescription("sdgfghj");
$video1->setLink("http://youtube.com/");

$video2 = new RSSItem;
$video2->setTitle("adfs");
$video2->setDescription("asdadsada");
$video2->setLink("http://google.com/");
$video2->setAuthor("Patrick");
$video2->setEnclosure("http://youtube.com");
$video2->addCategory("Furry art");

$channel = new RSSChannel;
$channel->setTitle("Videos");
$channel->setDescription("lustige videos");
$channel->setLink("http://lw-server.com/");
$channel->setCopyright("(c) 2011");
$channel->addCategory("Fun stuff");

$channel->addItem($video1);
$channel->addItem($video2);

$feed = new RSSFeed;
$feed->addChannel($channel);
echo $feed;
?>
