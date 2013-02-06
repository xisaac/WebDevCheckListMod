<!DOCTYPE html>
<html>
	<head>
		<?php header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0'); ?>
		<title>Web Developer Checklist</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" media="all" href="content/edit.css" />
		<script src="Scripts/editscript.js"></script>		
		<?php include('scripts/xmlwriter.php'); ?>
		
		<!-- Javascript function, which parses javascript variables to xmlwriter.php -->
		<SCRIPT language="javascript">
		function javaFunction(category, rule, linkText, linkUrls, actionType){	
			// the url which you have to reload is this page, but you add an action to the GET- or POST-variable
			var url="<?php echo $_SERVER['PHP_SELF'];?>?action=phpFunction&category="+category+"&rule="
			+rule+"&linkText="+linkText+'&linkUrls='+linkUrls+'&actionType='+actionType;		
			// Opens the url in the same window
			window.open(url, "_self");
		}
		</SCRIPT>  
		<?php include('scripts/sort.php'); ?>
	</head>
	
	<body>
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
							</select><br/>
							<button type="button" onclick="removeCategory()" id="deleteCategory">Delete Selected Category</button>
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
								</select><br/> 
								<button type="button" onclick="removeRule()" id="deleteRule">Delete Selected Rule</button>
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
	<HEAD>
		<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
		<META HTTP-EQUIV="Expires" CONTENT="-1">
	</HEAD>
</html>