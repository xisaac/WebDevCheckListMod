<!DOCTYPE html>
<html>
	<head>
		<title>Web Developer Checklist</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" media="all" href="content/edit.css" />
		<script src="Scripts/editscript.js"></script>		
		<?php include('scripts/xmlwriter.php'); ?>
		
		<!-- Javascript function, which parses javascript variables to xmlwriter.php -->
		<SCRIPT language="javascript">
		function javaFunction(category, rule, linkText, linkUrls){	
			// the url which you have to reload is this page, but you add an action to the GET- or POST-variable
			var url="<?php echo $_SERVER['PHP_SELF'];?>?action=phpFunction&category="+category+"&rule="
			+rule+"&linkText="+linkText+'&linkUrls='+linkUrls;		
			// Opens the url in the same window
			window.open(url, "_self");
		}
		</SCRIPT>  
	</head>
	
	<body>		
	
	    <header itemscope itemtype="http://schema.org/WebApplication">
			<h1 itemprop="name">Web Developer Checklist</h1>
		</header>
		<?php include('snippets/menubar.php'); ?>
		<div id="main">
		
			<table id="pagelayout">
				<tr>
					<!-- Contains controls for selecting / editing categories -->
					<td>
						<h2>Step 1 - </h2> <h3>Select category.</h3>
						<form>								
							<input type="radio" id="CatTextRadBtn" name="categoryDropDown" onclick="selectNewCategory()">
								<b>Add a new category name:</b> <input type="text" id="categoryNameTxt"><br/>
							<input type="radio" id="catListRadBtn" name="categoryDropDown" onclick="updateCategory()">
								<b>Use Existing Category: &nbsp &nbsp &nbsp </b>
							<select id="categories" onchange='updateRule();'>
								<option>Choose a category</option>
							</select>
						</form>
					</td>
					<td>
						<!-- Contains controls for selecting / editing rules -->
						<h2>Step 2 - </h2> <h3>Select rule.</h3>
						<form id="ruleForm">								
							<span>
								<input type="radio" name="ruleDropDown" onclick="selectNewrule()" id="newRuleRadBtn">
								<b>Create a new rule:</b> <input type="text" id="ruleNameTxt" ><br/>
								<input type="radio" name="ruleDropDown" onclick="updateRule()" id="editRuleRadBtn">
								<b>Use Existing Rule: </b>
								<select id="rules" onchange='updateLinks();' >
									<option>Choose a category</option>
								</select>
							</span>
						</form>
					</td>
					<td>
						<!-- Contains controls for selecting / editing links -->
						<h2>Step 3 - </h2> <h3>Select links.</h3>
						<button type="button" onclick="addLinkSpace()">Add New Link</button>
						<button type="button" id="commitbtn" onclick="commitValidation()">Commit Changes</button>
						<form  id="linkForm">
						<!--
							<b>Link Text:</b> <input class="urlTextTxt" type="text"><br/>
							<b>Link URL:</b> <input class="urlTxt" type="text">
						-->
							<div id="linkFormEdit">
							</div>							
						</form>
					</td>
				<tr>
				<tr>
					<td id="message" colspan="3">
						
					</td>
				</tr>
			</table>
		</div>
		<script src="Scripts/editscript.js"></script>
	</body>
</html>