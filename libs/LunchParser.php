<?php

class LunchParser
{
	
	private $lunchTitle;
	
	private $lunchMenu;
	
	protected function parse($feed){}
	
	protected function registerResult($title, $menu)
	{
		$this->lunchTitle = $title;
		$this->lunchMenu = $menu;
	}
	
	public function getHTMLMenu($feed)
	{
		$menu = $this->getParsedMenu($feed);
		return "        <div class='restaurant'><h2>{$menu['title']}</h2>" . 
			   "<div>{$menu['menu']}</div></div>";
	}
	
	public function getParsedMenu($feed)
	{
		$this->resetMenu();
		$this->parse($feed);
		$return = array(
			'title' => $this->lunchTitle,
			'menu' => $this->lunchMenu
		);
		return $return;
	}
	
	public function resetMenu()
	{
		$this->lunchMenu = NULL;
		$this->lunchTitle = NULL;
	}
	
}