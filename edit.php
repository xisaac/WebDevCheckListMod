<!DOCTYPE html>
<html>
	<head>
		<?php header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0'); ?>
		<title>Web Developer Checklist</title>
		<meta charset="utf-8" />
		<?php include('scripts/xmlwriter.php');?>
		<?php include('scripts/sort.php'); ?>
		
		<link rel="stylesheet" type="text/css" media="all" href="content/edit.css" />				
		<script src="Scripts/editscript.js"></script>
		<script src="Scripts/jquery.min.js"></script>
		<script src="twitter-bootstrap-v2/docs/assets/js/bootstrap-alert.js"></script> 		
		<SCRIPT language="javascript">
		<!-- Pass javascript variables to PHP script -->
		function javaFunction(category, rule, linkText, linkUrls, catEdit, ruleEdit, actionType){
			// the url which you have to reload is this page, but you add an action to the GET- or POST-variable
			var url="<?php echo $_SERVER['PHP_SELF'];?>?action=phpFunction&category="+category+"&rule="
			+rule+"&linkText="+linkText+'&linkUrls='+linkUrls+'&catEdit='+catEdit+'&ruleEdit='+ruleEdit+'&actionType='+actionType;
			// Opens the url in the same window
			window.open(url, "_self");
		}
		</SCRIPT>		
	</head>
	
	<body onload="pageStart()">
		<?php include('snippets/menubar.php'); ?>
		<div id="main">
			<a href="#myModal" class="btn btn-primary" id="helpbtn" data-toggle="modal">Help</a>
			<div id="message">
				<!-- Displays the success message when it is available -->
				<script type="text/JavaScript">
					var newMessage = '<?php echo $successMessage; ?>'
					if (newMessage == ""){
						document.write("<br/>");
					}else{
						document.write(newMessage);
					}
				</script>
			</div>
			
			<table id="pagelayout">
				<tr>
					<!-- Contains controls for selecting / editing categories -->
					<td>
						<h2>Step 1 - </h2> <h3>Select category.</h3>
						<form class="well span6" >								
							<input type="radio" id="CatTextRadBtn" name="categoryDropDown" onclick="selectNewCategory()">
								<label class="customlabel" for="CatTextRadBtn">
									Create new category:<input class="search-query" type="text" id="categoryNameTxt" placeholder="Type Category Name Here.....">
								</label><br/><br/>
								
							<input type="radio" id="catListRadBtn" name="categoryDropDown" onclick="updateCategory()">
							<label class="customlabel" for="catListRadBtn">
								Use Existing Category:						
							</label>
							<select id="categories" onchange='updateRule();'>
								<option>Choose a category</option>
							</select><br/>
							
							<div style="display: none;" id="catDiv">
							<input type="checkbox" id="changeCatName" />
							<label class="customlabel" for="changeCatName">Change Category name to: </label>
							<input type="text" id="categoryEditTxt"><br/>
							</div>
							
							<button class="btn btn-danger" type="button" onclick="removeCategory()" id="deleteCategory">
								Delete Selected Category
							</button>
						</form>
					</td>
					
					<td>
						<!-- Contains controls for selecting / editing rules -->
						<h2>Step 2 - </h2> <h3>Select rule.</h3>
						<form class="well span6" id="ruleForm">
							<span>
								<input type="radio" name="ruleDropDown" onclick="selectNewrule()" id="newRuleRadBtn">
								<label class="customlabel" for="newRuleRadBtn">
									Create new rule: <input type="text" class="search-query" id="ruleNameTxt" placeholder="Type Rule Name Here.....">
								</label><br/><br/>
								<input type="radio" name="ruleDropDown" onclick="updateRule()" id="editRuleRadBtn">
								<label class="customlabel" for="editRuleRadBtn">Use Existing Rule: </label>
								<select id="rules" onchange='updateLinks();' >
									<option>Choose a category</option>
								</select><br/>
								
								<div style="display: none;" id="ruleDiv">
									<input type="checkbox" id="changeRuleName" />
									<label class="customlabel" for="changeRuleName">Change Rule name to: </label>
									<input type="text" id="ruleEditTxt"><br/>
								</div>
							
								<button class="btn btn-danger" type="button" onclick="removeRule()" id="deleteRule">Delete Selected Rule</button>
							</span>
						</form>
					</td>
					
					<td>
						<!-- Contains controls for selecting / editing links -->
						<h2>Step 3 - </h2> <h3>Select links.</h3>
						<button class="btn btn-primary" type="button" onclick="addLinkSpace()">Add New Link</button>
						<button class="btn btn-primary" type="button" id="commitbtn" onclick="commitValidation()">Commit Changes</button><br/><br/>
						<form  class="well" id="linkForm">
							<div id="linkFormEdit">
							</div>
						</form>
					</td>
				</tr>
			</table>
		</div>
		
		<!-- Modal Controls for displaying help information -->		
		<div class="modal hide" id="myModal" aria-hidden="true">
			<div class="modal-header" id="modehead">
				<h3>HELP</h3>
			</div>
			<div class="modal-body" id="modebody">
				<p>
					<h5><u>Adding a category</u></h5>
					The new category radio button needs to be selected in-order to type in the name of a new category to be created.
					Doing this will disable the Existing category selector. New categories must have one rule added to them but, the 
					added rules do not necessary need to have links attached to them. Selecting the existing category radio button 
					updates the dropdown box with a list of all existing categories. This will automatically disable the new category 
					option and any changes made to it will be ignored when changes are committed.
				</p>
				<p>
					<h5><u>Adding a rule</u></h5>
					The rule options are very similar to the category options. New rules can also be added to existing category but 
					existing rules cannot be added to new categories. Selecting an existing category populates the existing rule drop-down 
					box with all the rules within the selected category.
				</p>
				<p>
					<h5><u>Adding a link</u></h5>
					If an existing rule that has links is selected, its links will be displayed in the step 3 section of the page. Clicking 
					the add link button adds an empty link section where the text and URL for a new link can be entered. Links can be added 
					to existing or new rules.
				</p>
				<p>
					<h5><u>Commiting changes</u></h5>
					Clicking the "Commit Changes" button in the top right area of the Step 3 section will commit all the changes to the data store.
					Certain validations prevent changes from being commited e.g. adding a category without rules. Any links without a text and url 
					value will not be added during a commit and will be discarded.
				</p>
				<p>
					<h5><u>Editing Data</u></h5>
					Clicking the existing category or rule button, opens an extension just below the selection drop down box. If the new change name 
					checkbox is checked and the corresponding textbox has a value, the rule or category name is replaced with the new value when the 
					commit changes button is clicked. Link values can be changed directly from the list of links and the data is saved when changes 
					are committed.
				</p>
				<p>
					<h5><u>Deleting Data</u></h5>
					The delete button in the category section only works when an existing category is selected. Clicking the button deletes the currently 
					selected category, all rules within it and their links. The delete button in the rules section functions in the same way by deleting 
					the selected rule and its links but not the selected category or any of its other appended data. Links can be deleted by clicking the 
					red button with the trash can icon within each link section. Deleted links are not finalised until the commit button has been clicked.
				</p>
				<p>
					<h5><u>Error Messages</u></h5>
					Error messages are displayed directly under the "Help" button in red text.
				</p>
			</div>
			<div class="model-footer" id="modefoot">
				<br/>
				<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
			</div>
		</div>
		<!-- Modal Controls End -->
		
		<script src="Scripts/editscript.js"></script>		
	</body>
	<HEAD>
		<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
		<META HTTP-EQUIV="Expires" CONTENT="-1">
	</HEAD>
</html>