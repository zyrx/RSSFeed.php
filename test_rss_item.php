<?php
include("rss_item.php");

$item = new RSSItem;
$item->setTitle("hello");
$item->setDescription("fun");
$item->setLink("http://google.com");
echo $item;
?>
