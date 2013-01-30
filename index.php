<!DOCTYPE html>
<html lang="en-us">
	<head>
		<title>Web Developer Checklist</title>
		<meta charset="utf-8" />
		<meta name="keywords" content="checklist, best practices, web development, performance, usability, mobile, website" />
		<meta name="description" content="The ultimate checklist for all serious web developers building modern websites" />
		<meta name="author" content="Sayed Hashimi @sayedihashimi, Mads Kristensen @mkristensen" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes" />
		
		<link rel="stylesheet" type="text/css" media="all" href="content/site.css" />
		<link rel="stylesheet" type="text/css" media="all" href="content/normalize.css" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
		
		<script src="Scripts/modernizr-2.6.2.js"></script>
		<script src="Scripts/script.js"></script>
		<script src="scripts/script.min.js" async="async"></script>
	</head>
	
	<body onload="displayResult()">	
	    <header itemscope itemtype="http://schema.org/WebApplication">
			<h1 itemprop="name">Web Developer Checklist</h1>
		</header>
		<aside><a href="https://github.com/ligershark/webdevchecklist.com"><span class="ghFork"></span></a></aside>
		
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
</html>