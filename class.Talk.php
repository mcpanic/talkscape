<?php

include_once "utils.php";

class Talk{
	public $id;
	public $slug;
	public $title;
	public $date;
	public $video_link;
	public $video_local_link;
	public $slides_link;
	public $length;
	public $abstract;
	public $speaker;
	public $affiliation;
	public $event;

	function __construct(){
		//$this->id = $id;

	}

	function getHTML(){
		$html = "";
		//$formatted_date = time2str($this->date);
		$date = strtotime($this->date);
		$date = date("Y-m-d", $date);
		$html = "<h4>$this->speaker <small>$this->affiliation</small></h4>"
			. "<h5>$date <small>at $this->event</small></h5>";

		if (isset($this->slides_link))
			$html .= "<div><a class='btn' href='/talkscape/$this->slides_link' target='_blank'><i class='icon-download'></i> Slides</a></div>";

		$html .= "<div>$this->abstract</div>";
		return $html;
	}
}
?>