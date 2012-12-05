<?php


class Neklid extends LunchParser implements IParser
{

	public function parse($feed) {
		$data2 = file_get_html($feed["url"]);
		$menu = "";
		foreach($data2->find("table") as $e) {
			$menu .= "<table>" . $e->innertext . "</table>";
		}
		$title = $feed["title"];
		$data2->clear();
		$this->registerResult($title, $menu);
	}
}
