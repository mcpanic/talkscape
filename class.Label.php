<?php

include_once "utils.php";
include_once "vendor/smartypants.php";
include_once "vendor/markdown.php";

class Label{
	public $id;
	public $talk_id;
	public $title;
	public $level;
	public $start_at;
	public $duration;
	public $detail;

	function __construct($id){
		//$this->id = $id;

	}

	function getURL(){
		return "";
	}

	function getHTML(){
		$html = "";
		$html .= "<li data-id='$this->id' data-start_at='$this->start_at'>"
				. "<i class='icon-chevron-down open-detail'></i>" 
				. "<a href='#'>"
				. "<span class='label'>" . getTimeDisplay($this->start_at) . "</span>"
				. $this->title
				. "</a><div class='detail'>"
				. SmartyPants(Markdown($this->detail))
				. "</div></li>";
		return $html;
	}

	function getAdminHTML(){
		$html = "";
		$html .= "<li data-id='$this->id' data-start_at='$this->start_at'>"
				. "<i class='icon-chevron-down open-detail'></i>" 
				. "<a href='#'>"
				. "<span class='label'>" . getTimeDisplay($this->start_at) . "</span>"
				. "<span class='title'>$this->title</span>"
				. "</a>"
				. "<span class='update-link'><a href='#'>edit</a></span>"
				. "<span class='delete-link'><a href='#'>delete</a></span>"
				. "<div class='detail'>" . SmartyPants(Markdown($this->detail)) . "</div></li>";
		return $html;		
	}
}
?>