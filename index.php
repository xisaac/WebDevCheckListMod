<!DOCTYPE html>
<html lang="en-us">
	<head>
		<?php header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0'); //prevent page caching. ?>
		<meta charset="utf-8" />		
		<link rel="stylesheet" type="text/css" media="all" href="content/site.css" />
		<link rel="stylesheet" type="text/css" media="all" href="content/normalize.css" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />		
		<script src="Scripts/modernizr-2.6.2.js"></script>
		<script src="Scripts/script.js"></script>
		<script src="scripts/script.min.js" async="async"></script>		
		<?php include('scripts/sort.php'); ?>
	</head>
	
	<body onload="displayResult()">		
		<?php include('snippets/menubar.php'); ?>
		
		<div id="main">
			
		</div>
		
		<footer>
			<p id="PercentageValue"></p>			
			<a href="#" id="clearall" onclick="clearAll()" >Clear all</a>
			<progress id="checkProgress" value="0" max="100" >
				<span id="fallback"></span>
			</progress>
		</footer>
		
		<script>
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-37479788-1']);
			_gaq.push(['_trackPageview']);

			(function () {
				var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();
		</script>

	</body>
	<HEAD>
	<!-- Help prevent caching -->
		<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
		<META HTTP-EQUIV="Expires" CONTENT="-1">
	</HEAD>
</html>