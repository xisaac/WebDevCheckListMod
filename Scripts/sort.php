<?php
	/*
		Uses the sort.xsl file as a template for re-arranging the data in the items.xml file. 
		The data in the XML file is then used to construct the home page.
	*/
	// Load the XML and XSLT source					
	$xml = new DOMDocument;
	$xml->load('App_Data/items.xml');					
	$xsl = new DOMDocument;
	$xsl->load('Scripts/sort.xsl');
	// Configure and run transformer
	$proc = new XSLTProcessor;
	$proc->importStyleSheet($xsl);								
	$newObject = $proc->transformToXML($xml);
	//Write new XML to file
	$file = 'App_Data/items.xml';
	if(is_file($file) && is_readable($file)){
		$open = fopen($file, 'w') or die ("File cannot be opened.");
		fwrite($open, $newObject);
		fclose($open); 
	}					
?>