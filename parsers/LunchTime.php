<?php


class LunchTime extends LunchParser implements IParser
{
	
	public function parse($feed) {
		$xmlPlain = file_get_contents($feed["url"]);
		$data = simplexml_load_string($xmlPlain);
		$item = $data->item;
		$title = $feed["title"];
		$menu = $item->description;
		$this->registerResult($title, $menu);
	}
}


