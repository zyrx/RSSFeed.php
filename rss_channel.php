<?php
/*  File: rss_channel.php
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
include_once("rss_item.php");

class RSSChannel {
	private $items = array();
	private $categories = array();
	private $generator = "RSSFeed.php";
	private $title;
	private $description;
	private $link;
	private $language;
	private $lastbuilddate;
	private $pubdate;
	private $ttl;
	private $copyright;
	private $image;

	// setters
	public function addItem($item) {
		if($item instanceof RSSItem) {
			array_push($this->items, $item);
		}
	}

	public function addCategory($cat) {
		array_push($this->categories, (string)$cat);
	}
	
	public function setTitle($title) {
		$this->title = (string)$title;
	}

	public function setDescription($description) {
		$this->description = (string)$description;
	}

	public function setLink($link) {
		$this->link = (string)$link;
	}

	public function setLanguage($lang) {
		$this->language = (string)$lang;
	}

	public function setLastBuildDate($date) {
		if(is_integer($date)) {
			$this->lastbuilddate = date("r", $date);
		} else {
			$this->lastbuilddate = (string)$date;
		}
	}

	public function setPubDate($date) {
		if(is_integer($date)) {
			$this->pubdate = date("r", $date);
		} else {
			$this->pubdate = (string)$date;
		}
	}

	public function setTTL($ttl) {
		$this->ttl = (integer)$ttl;
	}

	public function setCopyright($copyright) {
		$this->copyright = (string)$copyright;
	}

	public function setImage($image) {
		$this->image = (string)$image;
	}

	// writer functions
	private function writeHeader(&$body) {
		$body .= "<channel>\n";
	}

	private function writeFooter(&$body) {
		$body .= "</channel>\n";
	}

	private function writeAttribute(&$body, $attr, $val) {
		if(isset($val)) {
			$body .= "\t<$attr>";
			$body .= htmlentities($val);
			$body .= "</$attr>\n";
		}
	}

	// helper functions
	private function getLastBuildDate() {
		if(isset($this->lstbuilddate)) {
			return $this->lastbuilddate;
		} else {
			return date("r", time());
		}
	}

	// public API
	public function export() {
		$body = "";
		$this->writeHeader($body);
		$this->writeAttribute($body, "title", $this->title);
		$this->writeAttribute($body, "description", $this->description);
		$this->writeAttribute($body, "link", $this->link);
		$this->writeAttribute($body, "generator", $this->generator);
		foreach($this->categories as $cat) {
			$this->writeAttribute($body, "category", $cat);
		}
		$this->writeAttribute($body, "language", $this->language);
		$this->writeAttribute($body, "lastBuildDate", $this->getLastBuildDate());
		$this->writeAttribute($body, "pubDate", $this->pubdate);
		$this->writeAttribute($body, "ttl", $this->ttl);
		$this->writeAttribute($body, "copyright", $this->copyright);
		$this->writeAttribute($body, "image", $this->image);
		foreach($this->items as $item) {
			$body .= "\t";
			$body .= rtrim(str_replace("\n", "\n\t", $item->export()), "\t");
		}
		$this->writeFooter($body);
		return $body;
	}

	public function __toString() {
		return $this->export();
	}
}
