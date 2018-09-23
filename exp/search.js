var TRange=null;

findString = function (str) {
	if (parseInt(navigator.appVersion)<4) return;
	var strFound;
	var win = document.getElementById('reading').contentWindow;
	
	if (window.find) {

	  // CODE FOR BROWSERS THAT SUPPORT window.find

	  strFound=win.find(str);
	  if (!strFound) {
	    strFound=win.find(str,0,1);
	    while (win.find(str,0,1)) continue;
	  }
	}
	else if (navigator.appName.indexOf("Microsoft")!=-1) {
		// EXPLORER-SPECIFIC CODE
	    if (TRange!=null) {
	        TRange.collapse(false);
		    strFound=TRange.findText(str);
	        if (strFound) TRange.select();
	    }
	    if (TRange==null || strFound==0) {
			TRange=win.document.body.createTextRange();
			strFound=TRange.findText(str);
			if (strFound) TRange.select();
		}
	}
	else if (navigator.appName=="Opera") {
	    //alert ("Opera browsers not supported, sorry...")
		return;
	}
	if (!strFound) {
		//alert ("String '"+str+"' not found!");
	}
	return;
};