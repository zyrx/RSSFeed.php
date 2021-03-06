<?php
/*  File: rss_item.php
 *  
 *  Copyright (C) 2011, Patrick M. Elsen
 *
 *  This file is part of RSSFeed.php (http://github.com/xfbs/RSSFeed.php)
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

class RSSItem {
	// instance variables
	private $categories = array();
	private $title;
	private $description;
	private $link;
	private $pubdate;
	private $guid;
	private $author;
	private $comments;
	private $enclosure;

	// setters
	public function addCategory($cat) {
		array_push($this->categories, (string)$cat);
	}

	public function setAuthor($author) {
		$this->author = (string)$author;
	}

	public function setComments($comments) {
		$this->comments = (string)$comments;
	}

	public function setEnclosure($enclosure) {
		$this->enclosure = (string)$enclosure;
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

	public function setPubDate($date) {
		if(is_integer($date)) {
			// convert integer (assumed to be unix timestamp) to RFC2822 formatted date
			$this->pubdate = date("r", $date);
		} else {
			$this->pubdate = (string)$date;
		}
	}

	public function setGUID($guid) {
		$this->guid = (string)$guid;
	}

	// private helpers
	private function getGUID() {
		if($this->guid != NULL) {
			return $this->guid;
		} else {
			return md5($this->title . $this->description . $this->link);
		}
	}

	// write functions
	private function writeHeader(&$body) {
		$body .= "<item>\n";
	}

	private function writeFooter(&$body) {
		$body .= "</item>\n";
	}

	private function writeGUID(&$body) {
		$body .= "\t<guid>";
		$body .= $this->getGUID();
		$body .= "</guid>\n";
	}

	private function writeAttribute(&$body, $attr, $val) {
		if(isset($val)) {
			$body .= "\t<$attr>";
			$body .= htmlentities($val);
			$body .= "</$attr>\n";
		}
	}

	public function export() {
		$body = "";
		$this->writeHeader($body);
		$this->writeAttribute($body, "title", $this->title);
		$this->writeAttribute($body, "description", $this->description);
		$this->writeAttribute($body, "link", $this->link);
		$this->writeAttribute($body, "pubDate", $this->pubdate);
		$this->writeAttribute($body, "author", $this->author);
		$this->writeAttribute($body, "comments", $this->comments);
		$this->writeAttribute($body, "enclosure", $this->enclosure);
		foreach($this->categories as $category) {
			$this->writeAttribute($body, "category", $category);
		}
		$this->writeGUID($body);
		$this->writeFooter($body);
		return $body;
	}

	// syntactic sugar
	public function __toString() {
		return $this->export();
	}
}
?>
