<?php


class JinaKrajina extends LunchParser implements IParser
{

  public function parse($feed) {
    $data = file_get_html($feed["url"]);
    $menu = "";
    foreach($data->find("#lunchMenu") as $e) {
      $menu = $e->innertext;
    }
    $title = $feed["title"];
    $data->clear();
    $this->registerResult($title, $menu);
  }
}

