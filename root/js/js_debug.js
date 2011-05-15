/*
* By Peter Todorov - Sourced from http://www.sitepoint.com/article/layers-content-javascript
*/

function WriteLayer(ID,parentID,sText)
{
	if (document.layers)
	{
		var oLayer;
		if(parentID)
			oLayer = eval('document.' + parentID + '.document.' + ID + '.document');
   		else
   			oLayer = document.layers[ID].document;
		
   		oLayer.open();
		oLayer.write(sText);
		oLayer.close();
	}
	else if (parseInt(navigator.appVersion)>=5&&navigator.appName=="Netscape")
		document.getElementById(ID).innerHTML = sText;
	else if (document.all)
		document.all[ID].innerHTML = sText
}