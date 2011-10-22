<?php
/*  File: rss_item.php
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

class RSSItem {
	// instance variables
	private $title;
	private $description;
	private $link;
	private $pubdate;
	private $guid;

	// setters
	function setTitle($title) {
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

	private function writeTitle(&$body) {
		if(isset($this->title)) {
			$body .= "\t<title>";
			$body .= htmlentities($this->title);
			$body .= "</title>\n";
		}
	}

	private function writeDescription(&$body) {
		if(isset($this->description)) {
			$body .= "\t<description>";
			$body .= htmlentities($this->description);
			$body .= "</description>\n";
		}
	}

	private function writeLink(&$body) {
		if(isset($this->link)) {
			$body .= "\t<link>";
			$body .= htmlentities($this->link);
			$body .= "</link>\n";
		}
	}

	private function writePubDate(&$body) {
		if(isset($this->pubdate)) {
			$body .= "\t<pubDate>";
			$body .= htmlentities($this->pubdate);
			$body .= "</pubDate>\n";
		}
	}

	private function writeGUID(&$body) {
		$body .= "\t<guid>";
		$body .= $this->getGUID();
		$body .= "</guid>\n";
	}

	public function export() {
		$body = "";
		$this->writeHeader($body);
		$this->writeTitle($body);
		$this->writeDescription($body);
		$this->writeLink($body);
		$this->writePubDate($body);
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
