<?php
/*  File: rss_feed.php
 *  
 *  Copyright (C) 2011, Patrick M. Elsen
 *
 *  This file is part of CMatrixCrypt (http://github.com/xfbs/CMatrixCrypt)
 *  Author: Patrick M. Elsen <pelsen.vn (a) gmail.com>
 *
 *  All rights reserved.
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License along
 *  with this program; if not, write to the Free Software Foundation, Inc.,
 *  51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 */

// defines the RSSItem class
include_once("rss_channel.php");

class RSSFeed {
	private $version = "2.0";
	private $channels = array();

	public function addChannel($chan) {
		if($chan instanceof RSSChannel) {
			array_push($this->channels, $chan);
		}
	}

	public function writeXMLHeader(&$body) {
		$body .= "<?xml version=\"1.0\"?>\n";
	}

	public function writeRSSHeader(&$body) {
		$body .= "<rss version=\"$this->version\">\n";
	}

	public function writeRSSFooter(&$body) {
		$body .= "</rss>\n";
	}

	public function export() {
		$body = "";
		$this->writeXMLHeader($body);
		$this->writeRSSHeader($body);
		foreach($this->channels as $channel) {
			$body .= "\t";
			$body .= rtrim(str_replace("\n", "\n\t", $channel->export()), "\t");
		}
		$this->writeRSSFooter($body);
		return $body;
	}

	public function __toString() {
		return $this->export();
	}
}
