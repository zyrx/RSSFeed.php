<?php
include("rss_channel.php");
$item = new RSSItem;
$item->setTitle("fun");
$item->setLink("http://google.com/");
$item->setDescription("fun stuff.");

$chan = new RSSChannel;
$chan->setTitle("channel");
$chan->setLink("http://yahoo.com/");
$chan->setDescription("fun channel");
$chan->setCopyright("(c) Nobody, 1999");
$chan->addItem($item);

echo $chan;
?>
