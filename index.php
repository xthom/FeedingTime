<?php

include 'simple_html_dom.php';
header("content-type: text/html; charset=utf-8");

?><!DOCTYPE HTML>
<html>
    <head>
        <title>FeedingTime</title>
        <style>
			body {
				font-family: sans-serif;
				padding: 0;
				margin: 0;
			}
			.restaurant {
				width: 400px;
				font-size: 13px !important;
				float: left;
				border: 1px solid #456;
				margin: 10px;
				border-radius: 5px;
				box-shadow: 2px 2px 2px #ccc;
			}
			.restaurant h2 {
				margin: 0;
				padding: 10px 20px;
				background: #456;
				color: #fff;
			}
			#meta {
				position: absolute;
				right: 0;
				bottom: 0;
				padding: 3px 5px;
				font-size: 10px;
				color: #444;
				background: #ddd;
			}
        </style>
		<script type="text/javascript">var _gaq = _gaq || [];_gaq.push(['_setAccount', 'UA-247686-10']);_gaq.push(['_trackPageview']);(function() {var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);})();</script>
    </head>
    <body>
<?php

include 'cached.php';

if (isset($lastcached) && $lastcached > (time() - 3600)) {
	
	$content = $cachedContent;

	echo "<p id='meta'>cached @ " . date("r", $lastcached) . "</p>";
	
}
else {
	
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
		)
	);

	$content = "";
	$i = 0;

	foreach($feeds as $feed) {

		if ($feed["type"] == "lunchtime") {
			$xmlPlain = file_get_contents($feed["url"]);
			$data = simplexml_load_string($xmlPlain);
			$item = $data->item;
			$title = $feed["title"];
			$menu = $item->description;
		}
		elseif ($feed["type"] == "kofein") {
			$data = file_get_html($feed["url"]);
			$menu = "";
			foreach($data->find(".mn-posts") as $e) {
				$menu = $e->innertext;
			}
			$title = $feed["title"];
			$data->clear();
		}
		elseif ($feed["type"] == "neklid") {

			$data2 = file_get_html($feed["url"]);
			$menu = "";
			foreach($data2->find("table") as $e) {
				$menu .= "<table>" . $e->innertext . "</table>";
			}
			$title = $feed["title"];
			$data2->clear();
		}
		
		$i++;

		$content .= "        <div class='restaurant'><h2>$title</h2><div>$menu</div></div>";
	}

	$content .= "<style>body{width:" . ((420*$i)+20) . "px;}</style>";

	$cachedContent = $content;
	$lastcached = time();
	$file = fopen("cached.php", "w");
	fwrite($file, "<?" . "php\n\n\$lastcached = $lastcached;\n\n\$cachedContent = <<<BLAHBLAH\n " . $cachedContent . "\nBLAHBLAH;\n");
	fclose($file);
	
	echo "<p id='meta'>cached now</p>";
	
}
echo $content;

?></body>
</html>