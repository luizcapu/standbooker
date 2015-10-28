function nl2br (str, is_xhtml) {
    // Converts newlines to HTML line breaks  
    // 
    // version: 1006.1915
    // discuss at: http://phpjs.org/functions/nl2br    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Philip Peterson
    // +   improved by: Onno Marsman
    // +   improved by: Atli ��r
    // +   bugfixed by: Onno Marsman    // +      input by: Brett Zamir (http://brett-zamir.me)
    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Brett Zamir (http://brett-zamir.me)
    // +   improved by: Maximusya
    // *     example 1: nl2br('Kevin\nvan\nZonneveld');    // *     returns 1: 'Kevin\nvan\nZonneveld'
    // *     example 2: nl2br("\nOne\nTwo\n\nThree\n", false);
    // *     returns 2: '<br>\nOne<br>\nTwo<br>\n<br>\nThree<br>\n'
    // *     example 3: nl2br("\nOne\nTwo\n\nThree\n", true);
    // *     returns 3: '\nOne\nTwo\n\nThree\n'    
	var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '' : '<br>';
 
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
}

function runIeFix(){
	if ($.browser.msie) {
			// solucao para o buttonset do JQueryUI
			// funcionar no IE
		
			browserVersion = parseInt($.browser.version.substr(0, 1));
			
			if (browserVersion < 9){

				$("label").click(function() {

					var elID   = $(this).attr('for');
					var elType = $("#"+elID).attr('type');
					var elChecked = $("#"+elID).attr('checked');

					if (elType == "radio")		
						$("#"+elID).attr('checked', 'true');

					if (elType == "checkbox"){

						if (elChecked)
							$("#"+elID).attr('checked', '');
						else
							$("#"+elID).attr('checked', 'true');
					}		
						
					
				});

				// marca/desmarca buttonset a partir do clique
				// no radio original
				$("input[type='radio']").click(function() {

					var elID = $(this).attr('id');
					var elChecked = $(this).attr('checked');

					if (elChecked)
						$("label[for='"+elID+"']").addClass('ui-state-active');
					else
						$("label[for='"+elID+"']").removeClass('ui-state-active');
					
				});
			
			}
			
		}
}	

function modalConfirm(mensagem, titulo, captionOK, captionCancel){
	var elMsg;	
	
	$("#msgContainer").remove();
	
	elMsg = "<div id='msgContainer' name='msgContainer' style='width:200px; height:100px; background-color:#fff; display:none;' title='"+titulo+"'>";
	elMsg =	elMsg + mensagem;
	elMsg =	elMsg + "</div>";

	$('body').append(elMsg);
	
	return $("#msgContainer").dialog({
		resizable: false,
		height:140,
		modal: true,
		buttons: {
			captionOK: function() {
				$(this).dialog('close');
				return true;
			},
			captionCancel: function() {
				$(this).dialog('close');
				return false;
			}
		}
	});
}

function loadXMLString(txt) {
	try // Internet Explorer
	{
		xmlDoc = new ActiveXObject("Microsoft.XMLDOM");
		xmlDoc.async = "false";
		xmlDoc.loadXML(txt);
		return (xmlDoc);
	} catch (e) {
		try // Firefox, Mozilla, Opera, etc.
		{
			parser = new DOMParser();
			xmlDoc = parser.parseFromString(txt, "text/xml");
			return (xmlDoc);
		} catch (e) {
			//alert(e.message)
		}
	}
	return (null);
}

function loadLocations(selCountry, selLocation, idDefault) {
	
	$.ajax( {
		type :"POST",
		url :"../util/loadLocations.php",
		data :"countryId=" + selCountry.value,
		beforeSend : function() {
			selLocation.options.length = "";
			selLocation.disabled = true;
			var y = document.createElement('option');
			y.value = "";
			y.text = "Loading locations...";
			try {
				selLocation.add(y, null); // standards compliant
			} catch (ex) {
				selLocation.add(y); // IE only
			}
		},
		success : function(txt) {
			xmlDoc = loadXMLString(txt);
			selLocation.options.length = "";
			var y = document.createElement('option');
			y.value = "";
			y.text = "Select a location...";
			try {
				selLocation.add(y, null); // standards compliant
			} catch (ex) {
				selLocation.add(y); // IE only
			}
	
			var x = xmlDoc.getElementsByTagName("item");
		
			for (i = 0; i < x.length; i++) {
				value = x[i].getElementsByTagName("id")[0];
				text = x[i].getElementsByTagName("label")[0];
		
				var y = document.createElement('option');
				y.value = value.childNodes[0].nodeValue;
				y.text = text.childNodes[0].nodeValue;
				
				if (idDefault == y.value) y.selected = true;
					
				try {
					selLocation.add(y, null); // standards compliant
				} catch (ex) {
					selLocation.add(y); // IE only
				}
			}
			selLocation.disabled = false;
		},
		error : function(txt) {
			//window.alert("erro");
		}
	});
}


function cryptPHP(aValue){
	$.ajax( {
		async:false,
		type :"POST",
		url :"../util/cryptString.php",
		data :"aValue=" + aValue,
		beforeSend : function() {
		},
		success : function(txt) {
			return txt;
		},
		error : function(txt) {
			return "";
		}
	});	
}

function submitAjax(form) {
	form.ajaxSubmit();
} 

function submitAjaxReload(form) {
	form.ajaxSubmit({
		success: function() { 
			window.location.reload();
		}
	});
} 

function submitAjaxReloadConfirm(form, msg) {
	if (confirm(msg)){
		form.ajaxSubmit({
			success: function() { 
				window.location.reload();
			}
		});
	}
}