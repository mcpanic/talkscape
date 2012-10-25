<?php
include_once "utils.php";

class Highlight{
	public $id;
	public $talk_id;
	public $title;
	public $start_at;
	public $thumbnail_link;
	public $owner;

	function __construct($id){
		//$this->id = $id;
	}

	function getURL(){
		return "";
	}

	function getHTML(){
		$html = "";
		$html .= "<li data-id='$this->id' data-start_at='$this->start_at'>"
				. "<a href='#'>"
				. "<span class='overlay-play'></span>"
				. "<span class='label'>" . getTimeDisplay($this->start_at) . "</span> <small>by $this->owner</small>"
				. "<span class='thumb'><img src='$this->thumbnail_link' class='img-rounded'></span>"
				. "<span class='info'>$this->title</span>"
				. "</a></li>";
		return $html;
	}

	function getAdminHTML(){
		$html = "";
		/*
		$html .= "<li data-id='$this->id' data-start_at='$this->start_at'>"
				. "<i class='icon-chevron-down open-detail'></i>" 
				. "<a href='#'>"
				. "<span class='label'>" . getTimeDisplay($this->start_at) . "</span>"
				. "<span class='title'>$this->title</span>"
				. "</a>"
				. "<span class='update-link'><a href='#'>edit</a></span>"
				. "<span class='delete-link'><a href='#'>delete</a></span>"
				. "<div class='detail'>" . SmartyPants(Markdown($this->detail)) . "</div></li>";
		*/
		return $html;		
	}
}
                        
?>