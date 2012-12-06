<?php

header("content-type: text/html; charset=utf-8");

include 'config.php';
include 'simple_html_dom.php';

define("APPDIR", __DIR__ . DIRECTORY_SEPARATOR);

?><!DOCTYPE HTML>
<html>
    <head>
        <title>FeedingTime</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<script type="text/javascript">var _gaq = _gaq || [];_gaq.push(['_setAccount', 'UA-247686-10']);_gaq.push(['_trackPageview']);(function() {var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);})();</script>
    </head>
    <body>
<?php

include 'cached.php';

if ($cache && isset($lastcached) && $lastcached > (time() - 3600)) {
	$content = $cachedContent;
	echo "<p id='meta'>cached @ " . date("r", $lastcached) . "</p>";
} else {
	
	$parser = new Parser();
	$content = "";
	$i = 0;

	foreach($feeds as $feed) {
		$content .= $parser->getHTMLMenu($feed['type'], $feed);
		$i++;
	}

	$content .= "<style>body{width:" . ((420*$i)+20) . "px;}</style>";

	$cachedContent = $content;
	$lastcached = time();
	if (!is_file("cached.php")) {
		touch("cached.php");
		chmod("cached.php", 0777);
	}
	$file = fopen("cached.php", "w");
	fwrite($file, "<?" . "php\n\n\$lastcached = $lastcached;\n\n\$cachedContent = <<<BLAHBLAH\n " . $cachedContent . "\nBLAHBLAH;\n");
	fclose($file);
	
	echo "<p id='meta'>cached now</p>";
	
}

echo $content;

?></body>
</html>