<?php 
	if (isset($_GET[action])){
		// Retrieve the GET parameters and executes the function
		$funcName	= $_GET[action];
		$category	= $_GET[category];
		$rule	    = $_GET[rule];
		$linkText	= $_GET[linkText];
		$linkUrls = $_GET[linkUrls];
		$funcName($category,$rule,$linkText,$linkUrls); 
	} else if (isset($_POST[action])){
		// Retrieve the POST parameters and executes the function
		$funcName	= $_POST[action];
		$category	    = $_POST[category];
		$rule = $_POST[rule];
		$linkText	= $_POST[linkText];
		$linkUrls   = $_POST[linkUrls];
		$funcName($category,$rule,$linkText,$linkUrls); 	  
	}
	 
	function phpFunction($category,$rule,$v1,$v2)
	{
		$file = "write.xml";
		$fp = fopen($file, "rb") or die("cannot open file");
		$str = fread($fp, filesize($file));
		
		// initialize variables in method call.
		$linkText = explode(",", $v1);
		$linkUrls = explode(",", $v2);	
		$linkSize = sizeof($linkText);
		
		// Access XML elements.
		$doc = new DOMDocument();
		$doc->formatOutput = true;
		$doc->preserveWhiteSpace = false;
		$doc->loadXML($str) or die("Error");
		$root   = $doc->documentElement;
		$ori    = $root->childNodes->item(0);
		$updated = false;
		
		//Edit existing data
		$cats = $doc -> getElementsByTagName( "category" );
		$rules = $doc -> getElementsByTagName( "rule" );
		foreach( $cats as $cat )
		{
			$doc->appendChild( $root );
			$catName = $cat->getAttribute('name');
			if($catName == "$category")
			{ //Add new links to an existing rule.
				foreach($rules as $ruleItem)
				{
					$ruleName = $ruleItem->getAttribute('name');
					if($ruleName == "$rule")
					{
						echo "Rule name $rule was found\n";
						$updated = true;
						while( $ruleItem->firstChild ){	$ruleItem->removeChild($ruleItem->firstChild);  }
						
						for($i = 0; $i < $linkSize; $i++)
						{
							if (($linkText[$i] != "") && ($linkUrls[$i] != ""))
							{
								$linkElement = $doc->createElement( "link", "$linkText[$i]" );
								$linkElement->setAttribute("url","$linkUrls[$i]");
								$ruleItem->appendChild($linkElement);
							}							
						}
						$cat->appendChild($ruleItem);
						$root->appendChild($cat);
						break 2;
					}					
				}
				//Activated when the selected category is already in the xml, but the rule is a new rule.
				//Add a new rule to an existing category, even if the rule has no links.
				if($updated == false)
				{
					echo "$rule not found\n";
					$updated = true;
					
					$ruleItem = $doc->createElement( "rule" );
					$ruleItem->setAttribute("name","$rule");		
					
					for($i = 0; $i < $linkSize; $i++)
					{
						if (($linkText[$i] != "") && ($linkUrls[$i] != ""))
						{
							$linkElement = $doc->createElement( "link", "$linkText[$i]" );
							$linkElement->setAttribute("url","$linkUrls[$i]");
							$ruleItem->appendChild($linkElement);
						}							
					}
					$cat->appendChild($ruleItem);
					$root->appendChild($cat);
					echo 'Rule "$rule" has been updated\n';
					break;
				}				
			}
		}
		
		if ($updated == false)
		{
			//Add new category to XML.
			$doc->appendChild( $root );
			$catElement = $doc->createElement( "category" );
			$catElement->setAttribute("name","$category");
			$ruleElement = $doc->createElement( "rule" );
			$ruleElement->setAttribute("name","$rule");		

			for($i = 0; $i < $linkSize; $i++)
			{
				if (($linkText[$i] != "") && ($linkUrls[$i] != ""))
				{
					$linkElement = $doc->createElement( "link", "$linkText[$i]" );
					$linkElement->setAttribute("url","$linkUrls[$i]");
					$ruleElement->appendChild($linkElement);
				}
			}
			$catElement->appendChild($ruleElement);
			$root->insertBefore($catElement,$ori);		
		}
		$doc->save("write.xml"); // save the xml to file.
	}	
  ?>