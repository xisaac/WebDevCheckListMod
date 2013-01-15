//Reads from an external document
function loadXMLDoc(dname)
{
if (window.XMLHttpRequest)
  {
  xhttp=new XMLHttpRequest();
  }
else
  {
  xhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xhttp.open("GET",dname,false);
xhttp.send("");
return xhttp.responseXML;
}

/*
Creates the HTML page, using the 'loadXMLDoc(dname)' method to load the xml and xslt file.
This code is executed using the "body" tag's "onload" method.
*/

function displayResult()
{
xml=loadXMLDoc("App_Data/items.xml");
xsl=loadXMLDoc("Scripts/items.xsl");
// code for IE
if (window.ActiveXObject)
  {
  ex=xml.transformNode(xsl);
  document.getElementById("main").innerHTML=ex;
  }
// code for Mozilla, Firefox, Opera, etc.
else if (document.implementation && document.implementation.createDocument)
  {
  xsltProcessor=new XSLTProcessor();
  xsltProcessor.importStylesheet(xsl);
  resultDocument = xsltProcessor.transformToFragment(xml,document);
  document.getElementById("main").appendChild(resultDocument);
  }
  handleChange(this);
}
/*
Attached to the rule-checkboxes' "onchange" property within the XSLT file.
Updates the progress bar with the percentage completion.
*/
function handleChange(cb) {
	var checkProgress = document.getElementById("checkProgress");
	var totalCount = document.getElementsByClassName("listCheck");
	var percentage = 0, count = 0;				
	for (var i=0; i<totalCount.length; i++) {
		if (totalCount[i].type === "checkbox" && totalCount[i].checked === true) {
			count++;
		}
	}
	percentage = (count/totalCount.length) * 100;
	display(percentage + "%");
	checkProgress.value = percentage;
}
function display(msg) {
  document.getElementById("PercentageValue").innerHTML = msg;
  document.getElementById("fallback").innerHTML = msg;
}

// Clears all the checkboxes and resets the progress bar
function clearAll() {
	var boxes = document.getElementsByClassName("listCheck");
	for (var i = 0; i < boxes.length; i++) {
		boxes[i].checked = false;
	}
	handleChange(this);
}

//Displays the links within the rule when it's information icon is clicked
function openDetails(e){
	var details = document.getElementsByTagName('em');
	
	if (!e) e = window.event;
	var detail = (e.target || e.srcElement);                
	var ul = (detail.nextElementSibling || detail.nextSibling);

	if (ul.style.maxHeight !== '100px')
		ul.style.maxHeight = '100px';
	else
		ul.style.maxHeight = '0';

	for (var i = 0; i < details.length; i++) {
		if (details[i] !== detail) {
			var d = (details[i].nextElementSibling || details[i].nextSibling);
			d.style.maxHeight = "0";
		}
	}
}