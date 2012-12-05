<?php

class Parser
{
	
	private $parsers = array();
	
	public function __construct()
	{
		$this->createParsers();
	}
	
	public function getParsedMenu($parser, $url)
	{
		if (isset($this->parsers[$parser])) {
			return $this->parsers[$parser]->getParsedMenu($url);
		}
		return NULL;
	}
	
	public function getHTMLMenu($parser, $url)
	{
		if (isset($this->parsers[$parser])) {
			return $this->parsers[$parser]->getHTMLMenu($url);
		}
		return NULL;
	}
	
	private function createParsers()
	{
		$dir = APPDIR . 'parsers/';
		$folder = dir($dir);
		while($file = $folder->read()) {
			if (preg_match('~^(.+)\.php$~i', $file, $match)) {
				if (isset($match[1]) && !isset($this->parsers[$match[1]])) {
					require $dir . $file;
					$className = $match[1];
					$this->parsers[strtolower($className)] = new $className();
				}
			}
		}

	}
	
	
	
}