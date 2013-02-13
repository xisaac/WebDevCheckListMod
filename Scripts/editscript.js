var xml=loadXMLDoc("App_Data/items.xml");

var catNameText = document.getElementById('categoryNameTxt');
var cat = document.getElementById('categories');
var newCatRad = document.getElementById('CatTextRadBtn');

var deleteCat = document.getElementById('deleteCategory');
var deleteRule = document.getElementById('deleteRule');

var ruleListRadBtn = document.getElementById('editRuleRadBtn');
var rule = document.getElementById('rules');
var ruleTextValue = document.getElementById('ruleNameTxt');
var ruleTextRadBtn = document.getElementById('newRuleRadBtn');

var linkform = document.getElementById('linkFormEdit');
var changeCatCheck = document.getElementById('changeCatName');
var categoryEditTxt = document.getElementById('categoryEditTxt');
var changeRuleCheck = document.getElementById('changeRuleName');
var ruleEditTxt = document.getElementById('ruleEditTxt');

// determines how to load the XML file based on browser version.
function loadXMLDoc(dname){
	if (window.XMLHttpRequest){	xhttp=new XMLHttpRequest();	} // code for IE7+, Firefox, Chrome, Opera, Safari
	else{ xhttp=new ActiveXObject("Microsoft.XMLHTTP"); } // code for IE6, IE5
	xhttp.open("GET",dname,false);
	xhttp.send("");
	return xhttp.responseXML;
}

function pageStart(){
	newCatRad.checked=true;
	selectNewCategory();
}
// Retrieves categories from xml, empties the categories drop
// down and update it with the retrieved categories. 
function updateCategory(){
	show('catDiv');
	var categoryName=xml.getElementsByTagName("category");
	cat.disabled=false;
	catNameText.disabled=true;
	
	changeCatCheck.disabled=false;
	categoryEditTxt.disabled=false;
	
	while ( cat.firstChild ) cat.removeChild( cat.firstChild );	
	for(i=0;i<categoryName.length;i++) {
		var newOption = document.createElement('option');
		newOption.innerHTML = categoryName[i].getAttribute('name');
		cat.appendChild(newOption);
	}
	deleteCat.disabled=false;
	ruleListRadBtn.checked=true;	
	updateRule();	
}

// Retrieves rules from xml, within the selected category
// updates the rules drop down and update it with the retrieved rules. 
function updateRule(){
	show('ruleDiv');
	var ruleName=xml.getElementsByTagName("rule");
	var selectedCat = cat.options[cat.selectedIndex].text;
	rule.disabled=false;
	ruleTextValue.disabled=true;	
	
	changeRuleCheck.disabled=false;
	ruleEditTxt.disabled=false;	
	
	while ( rule.firstChild ) rule.removeChild( rule.firstChild );	
	var j=0;
	for(i=0;i<ruleName.length;i++) {
		if(ruleName[i].parentNode.getAttribute('name') == selectedCat) {
			var newOption = document.createElement('option');
			newOption.innerHTML = ruleName[i].getAttribute('name');
			rule.appendChild(newOption);
			j++;
		}
	}
	if ((j < 1)){
		if((newCatRad.checked == true) && (catNameText.value == "")){
			var newOption = document.createElement('option');
			newOption.innerHTML = 'No category selected';
			rule.appendChild(newOption);
			rule.setAttribute("style","background-color: #E24343;");
		}					
	} else {
		deleteRule.disabled=false;
		rule.setAttribute("style","background-color: none;");
		updateLinks();
	}
}

//Hides html element with the ID passed as a parameter.
//for the category and rule editing elements.
function hide(id){
	if (document.getElementById){
		obj = document.getElementById(id); 
		if (obj.style.display == ""){ obj.style.display = "none"; }
	}
}

//Shows html element with the ID passed as a parameter.
//for the category and rule editing elements.
function show(id){
	if (document.getElementById){
		obj = document.getElementById(id); 
		if (obj.style.display == "none"){ obj.style.display = ""; }
	}
}

// Retrieves links from xml, within the selected rule
// and creates new elements to display the links. 
function updateLinks(){
	var linkName=xml.getElementsByTagName("link");
	var selectedRule = rule.options[rule.selectedIndex].text;	
	while(linkform.firstChild) {	linkform.removeChild(linkform.firstChild);	}
	
	for(i=0;i<linkName.length;i++) {
		if(linkName[i].parentNode.getAttribute('name') == selectedRule) {
			var newOption = document.createElement('div');
			newOption.innerHTML = '<button id="btnDispose" class="btn btn-danger" type="button" onclick="unlistLink(this)">' +
					'<i class="icon-trash icon-white"></i></button><br/>'+
					'Link Text: <input class="search-query urlTextTxt" type="text" value="'+ linkName[i].firstChild.nodeValue +'"><br/>' +
					'Link URL: <input class="search-query urlTxt" type="text" value="'+ linkName[i].getAttribute('url') +'"><br>';
			linkform.appendChild(newOption);
		}
	}
}

// disables the categories drop-down list and romves its values with 'Choose a category'
function selectNewCategory(){
	catNameText.disabled=false;
	cat.disabled=true;
	deleteCat.disabled=true;
	while ( cat.firstChild ) cat.removeChild( cat.firstChild );
	
	var newOption = document.createElement('option');
	newOption.innerHTML = 'Choose a category';
	cat.appendChild(newOption);	
	changeCatCheck.disabled=true;
	changeCatCheck.checked=false;
	categoryEditTxt.disabled=true;
	categoryEditTxt.value = "";
	hide('catDiv');
	selectNewrule();
}

// selects the new rule radio button, enables the new rule text field
// and removes all the displayed links, if there are any.
function selectNewrule(){
	ruleTextValue.disabled=false;
	ruleTextRadBtn.checked=true;
	rule.disabled=true;
	deleteRule.disabled=true;
	
	changeRuleCheck.checked=false;
	changeRuleCheck.disabled=true;
	ruleEditTxt.disabled=true;
	ruleEditTxt.value = "";
	hide('ruleDiv');
	
	while(linkform.firstChild) {	linkform.removeChild(linkform.firstChild);	}
}

//Adds an empty link space to allow the user to enter new links.
function addLinkSpace(){
	var newLink = document.createElement('div');
	newLink.innerHTML = '<button id="btnDispose" class="btn btn-danger" type="button" onclick="unlistLink(this)">' +
					'<i class="icon-trash icon-white"></i></button><br/>' +
					'Link Text: <input class="search-query urlTextTxt" type="text"><br/>' +
					'Link URL: <input class="search-query urlTxt" type="text"><br>';
	linkform.appendChild(newLink);
}

// Allows the user to delete added link spaces.
function unlistLink(n){	n.parentNode.parentNode.removeChild(n.parentNode);	}

// Commit changes to XML file after updating validations.
function commitValidation(){
	var message = document.getElementById('message');	
	var catList = document.getElementById('catListRadBtn');
	var linkText = document.getElementsByClassName('urlTextTxt');
	var linkUrl = document.getElementsByClassName('urlTxt');
		
	var messageValue = "";
	var messageContainer = document.createElement('div');
	
	var catValue, ruleValue, catEdit, ruleEdit;
	var catOk = true;
	var ruleOk = true;
	var validationReady = false;
	
	while ( message.firstChild ) message.removeChild( message.firstChild );
	
	// Validates the category and holds its value if it passes validation
	if (catList.checked == false){
		if ((newCatRad.checked==true) && (catNameText.value == "")){
			catOk = false;
			messageValue += "&nbsp * Empty Category name field not allowed. Type or select a category name. <br />";
		} else if(newCatRad.checked==false){
			catOk = false;
			messageValue += "&nbsp * A category is required to proceed. Type or select a category name. <br />";
		}
		catValue = catNameText.value;
	} else {
		catValue = cat.options[cat.selectedIndex].text;
	}
	
	// Validates the rule and holds its value if it passes validation
	if (ruleTextRadBtn.checked == true){
		if(ruleTextValue.value == ""){
			ruleOk = false;
			messageValue += "&nbsp * A rule is required to proceed. Type a rule name. <br />";
		}
		ruleValue = ruleTextValue.value;
	} else if ((ruleListRadBtn.checked == true) && (newCatRad.checked == true)){
		ruleOk = false;
		messageValue += "&nbsp * Existing rule(s) are unavailable for new Categories. Type a rule name. <br />";
	}else if ((ruleListRadBtn.checked == true) && (catList.checked == true)){
		ruleValue = rule.options[rule.selectedIndex].text;
	}
	
	// Validates the links and if it passes validation, all appropriate values are written to XML.
	var linkTextArr = [];
	var	linkUrlArr = [];
	for (var i = 0; i < linkText.length; i++){
		linkTextArr[i] = linkText[i].value;
		linkUrlArr[i] = linkUrl[i].value;
	}
	
	if((catOk == true) && (ruleOk == true)) { validationReady = true;}
	if (messageValue != ""){
		messageContainer.innerHTML = '<div class="alert alert-error">' +
								'<strong>Error!</strong><br/>' + messageValue + '</div>';
		message.appendChild(messageContainer);	
	}
	
	//Commits changes if all necessary validations have been passed
	var action = 'Commit';
	if ( validationReady == true ) {
		if((changeCatCheck.checked == true) && (categoryEditTxt.value != "")){	catEdit = categoryEditTxt.value; } 
		if((changeRuleCheck.checked == true) && (ruleEditTxt.value != "")){	ruleEdit = ruleEditTxt.value; } 
		javaFunction(catValue, ruleValue, linkTextArr, linkUrlArr, catEdit, ruleEdit, action);
	}	
}

//passes variables to php function for deleting categories.
function removeCategory(){
	var action = "removeCat";
	var ruleValue, linkTextArr, linkUrlArr, catNew, ruleNew;
	var selectedCat = cat.options[cat.selectedIndex].text;
	javaFunction(selectedCat, ruleValue, linkTextArr, linkUrlArr, catNew, ruleNew, action);
}

//passes variables to php function for deleting rules.
function removeRule(){
	var action = "removeRule";
	var linkTextArr, linkUrlArr, catNew, ruleNew;
	var catValue = cat.options[cat.selectedIndex].text;
	var selectedRule = rule.options[rule.selectedIndex].text;
	javaFunction(catValue, selectedRule, linkTextArr, linkUrlArr, catNew, ruleNew, action);
}