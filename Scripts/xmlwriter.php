	<?php 	
	error_reporting(0);  // Turn off all error reporting
	
	if (isset($_GET[action])){
		// Retrieve the GET parameters and executes the function
		$funcName	= $_GET[action];
		$category	= $_GET[category];
		$rule	    = $_GET[rule];
		$linkText	= $_GET[linkText];
		$linkUrls   = $_GET[linkUrls];
		$catEdit    = $_GET[catEdit];
		$ruleEdit   = $_GET[ruleEdit];
		$actionType = $_GET[actionType];
		$funcName($category,$rule,$linkText,$linkUrls, $catEdit, $ruleEdit, $actionType); 
	} else if (isset($_POST[action])){
		// Retrieve the POST parameters and executes the function
		$funcName	= $_POST[action];
		$category	= $_POST[category];
		$rule       = $_POST[rule];
		$linkText	= $_POST[linkText];
		$linkUrls   = $_POST[linkUrls];
		$catEdit    = $_POST[catEdit];
		$ruleEdit   = $_POST[ruleEdit];
		$actionType = $_POST[actionType];
		$funcName($category,$rule,$linkText,$linkUrls, $catEdit, $ruleEdit, $actionType); 	  
	}
	
	$successMessage;
	
	function phpFunction($category,$rule,$v1,$v2, $catEdit, $ruleEdit, $actionType)
	{
		$file = "App_Data/items.xml";
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
		global $successMessage;
		
		$cats = $doc -> getElementsByTagName( "category" );
		$rules = $doc -> getElementsByTagName( "rule" );
		
		// Delete category and all it's children
		if("$actionType" == 'removeCat'){
			foreach( $cats as $cat )
			{
				$catName = $cat->getAttribute('name');
				if($catName == "$category"){ $cat->parentNode->removeChild($cat); }
			}
		}
		
		// Delete selected rule and all it's children
		if("$actionType" == 'removeRule'){			
			foreach( $cats as $cat )
			{				
				$catName = $cat->getAttribute('name');
				if($catName == "$category"){
					foreach($rules as $ruleItem){
					$ruleName = $ruleItem->getAttribute('name');
					
						if($ruleName == "$rule"){
							$ruleItem -> parentNode -> removeChild($ruleItem);
							if($cat->firstChild == false){
								$cat -> parentNode -> removeChild($cat);
							}							
						}
					}						
				
				}
			}
		}
		
		if("$actionType" == 'Commit'){
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
							if ($ruleEdit != "undefined"){ $ruleItem->setAttribute("name",ucfirst($ruleEdit)); }
							if ($catEdit != "undefined"){ $cat->setAttribute("name",ucfirst($catEdit)); }
							$cat->appendChild($ruleItem);
							$root->appendChild($cat);
							break 2;
						}					
					}
					//Activated when the selected category is already in the xml, but the rule is a new rule.
					//Add a new rule to an existing category, even if the rule has no links.
					if($updated == false)
					{									
						$ruleItem = $doc->createElement( "rule" );
						$ruleItem->setAttribute("name",ucfirst($rule));		
						
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
						$updated = true;
						break;
					}				
				}
			}
			
			if ($updated == false)
			{
				//Add new category to XML.
				$doc->appendChild( $root );
				$catElement = $doc->createElement( "category" );
				$catElement->setAttribute("name",ucfirst($category));
				$ruleElement = $doc->createElement( "rule" );
				$ruleElement->setAttribute("name",ucfirst($rule));		

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
		}
		$doc->save("App_Data/items.xml"); // save the xml to file.
		$successMessage = '<div class="alert alert-success"> <a class="close" data-dismiss="alert">×</a>'.
							'<strong>Success! - </strong> Checklist updated.</div>';
	}
	
?>