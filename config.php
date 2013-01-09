<?php

/**
 * Feeds config
 */

/**
 * Turn ON/OFF caching
 * @var bool
 */
$cache = TRUE;

/**
 * Feeds to be parsed
 * @var array
 */
$feeds = array(
	array(
		"type" => "lunchtime",
		"title" => "U Palečka",
		"url" => "http://www.lunchtime.cz/rss/?id=4971&type=restaurant"
	),
	array(
		"type" => "lunchtime",
		"title" => "Obyčejný svět",
		"url" => "http://www.lunchtime.cz/rss/?id=1444&type=restaurant"
	),
	array(
		"type" => "kofein",
		"title" => "Kofein",
		"url" => "http://www.ikofein.cz/poledne.php"
	),
	array(
		"type" => "neklid",
		"title" => "Neklid",
		"url" => "http://www.neklid.com/generovane_html/dennimenutisk.html"
	),
	array(
		"type" => "lunchtime",
		"title" => "HamTam",
		"url" => "http://www.lunchtime.cz/rss/?id=3594&type=restaurant"
	)
);


function __autoload($class) {
	$file = APPDIR . 'libs/' . $class . '.php';
	if (is_file($file)) {
		include $file;
	}
}

