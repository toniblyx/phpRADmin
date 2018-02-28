/** 
Oreon is developped with Apache Licence 2.0 :
http://www.apache.org/licenses/LICENSE-2.0.txt
Developped by : Julien Mathis - Romain Le Merlus

The Software is provided to you AS IS and WITH ALL FAULTS.
OREON makes no representation and gives no warranty whatsoever,
whether express or implied, and without limitation, with regard to the quality,
safety, contents, performance, merchantability, non-infringement or suitability for
any particular or intended purpose of the Software found on the OREON web site.
In no event will OREON be liable for any direct, indirect, punitive, special,
incidental or consequential damages however they may arise and even if OREON has
been previously advised of the possibility of such damages.

For information : contact@oreon.org
*/
// JavaScript Document

// Traffic Map
if (!document.all) {document.captureEvents(Event.MouseMove);} 
    document.onclick = position; 
function position(evenement) 
{  
  element = document.all?event.srcElement:evenement.target; 
  if (element.name!="trafficMap") return;
  document.trafficMapEvent.x.value = document.all?event.x:evenement.layerX; 
  document.trafficMapEvent.y.value = document.all?event.y:evenement.layerY; 
}

// Moove or remoove elements in SelectArea (ContactGroups, HostGroups...)
function Moove(l1,l2) {
	var tab = Array();
	var cpt = 0;
	if (l1.options.selectedIndex >= 0) {
		for (var i = 0; i < l1.length; i++)	{
			if (l1.options[i].selected)	{
				o = new Option(l1.options[i].text,l1.options[i].value);
				l2.options[l2.options.length] = o;
				tab[cpt] = i;
				cpt++;
			}
		}
	}
	
	var ordre = 1;
	var n=tab.length;
	var continuer=true;
	var i=0;
	var iter=0;
	for (i=0;i<n;i++) {
		tab[i]=ordre*tab[i];
	}
	while (continuer) {
		iter++;
		continuer=false;
		for (i=0;i<n-1;i++) {
			if (Math.min(tab[i],tab[i+1])!=tab[i+1]) {
				var temp=tab[i];
				tab[i]=tab[i+1];
				tab[i+1]=temp;  
				continuer=true;
			}
		}
	}
	for (i=0;i<n;i++) {
		tab[i]=ordre*tab[i];
	}
	if (l1.options.selectedIndex >= 0) {
		for (cpt = 0; cpt < tab.length; cpt++)	{
			l1.options[tab[cpt]] = null;
		}
	}
}

// Select all index in SelectArea
function selectAll (selectform) {
	for (i = 0; i < selectform.options.length; i++)
		selectform.options[i].selected = true;
}

// Enable/disable field for template. Put the old value when disable.
function enabledTemplateField (obj, strTemplate, strObj)	{
	obj.disabled = !(obj.disabled);
	var z = (obj.disabled) ? 'disabled' : 'false';
	if (obj.disabled)
		obj.value = strTemplate;
	else if (strObj != '')
		obj.value = strObj;
}

// Enable/disable field for template. Put the old value when disable.
function enabledTemplateFieldSelect (obj)	{
	obj.disabled = !(obj.disabled);
	var z = (obj.disabled) ? 'disabled' : 'false';
}

// Enable/disable field for template. Put the old value when disable.
function enabledTemplateFieldTarea (obj)	{
	obj.disabled = !(obj.disabled);
	var z = (obj.disabled) ? 'disabled' : 'false';
}


// Enable/disable field radio button for template. Put the old value when disable.
function enabledTemplateFieldRadio (obj, strTemplate, strObj)	{
	for (var i=0; i<obj.length;i++) {
		obj[i].disabled = !(obj[i].disabled);
	}
	for (var i=0; i<obj.length;i++) {
		var z = (obj[i].disabled) ? 'disabled' : 'false';
	}
	for (var i=0; i<obj.length;i++) {
		if (obj[i].disabled)	{
			if (obj[i].value == strTemplate)
				obj[i].checked = true;
		} else if (strObj != '')
			if (obj[i].value == strObj)
					obj[i].checked = true;
	}
}

// Enable/disable field check button for template. Put the old value when disable.
function enabledTemplateFieldCheck (obj, strTemplate, strObj)	{
	for (var i=0; i<obj.length;i++) {
		obj[i].disabled = !(obj[i].disabled);
	}
	for (var i=0; i<obj.length;i++) {
		var z = (obj[i].disabled) ? 'disabled' : 'false';
		obj[i].checked = false;
	}
	tabTemplate = strTemplate.split(',');
	tabObj = strObj.split(',');
	if (obj[0].disabled)	{
		for (var i=0; i<tabTemplate.length;i++) {
			for (var k=0; k<obj.length; k++)	{
				if (obj[k].value == tabTemplate[i])
					obj[k].checked = true;
			}
		}
	}
	else if (strObj != '')	{
		for (var i=0; i<tabObj.length;i++) {
			for (var k=0; k<obj.length; k++)	{
				if (obj[k].value == tabObj[i])
					obj[k].checked = true;
			}
		}
	}
}

// Enable/disable field check button for template. Put the old value when disable.
function enabledOptionsCheck(obj)	{
	
		obj.disabled = !(obj.disabled);
}

//Check/Uncheck list of checkbox
function multipleCheck(obj, value)	{
	if (obj.length == null)	{
		obj.checked = value;
		return;
	}
	for (var i=0; i<obj.length;i++) {
		obj[i].checked = value; 
	}
}

// hidde <div>


function Get_Cookie(name) {
  var start = document.cookie.indexOf(name + '=');
  var len = start + name.length + 1;
  if ((!start) && (name != document.cookie.substring(0,name.length)))
    return null;
  if (start == -1)
    return null;
  var end = document.cookie.indexOf(';',len);
  if (end == -1) 
  	end = document.cookie.length;
  return unescape(document.cookie.substring(len,end));
}

function Set_Cookie( name, value, expires, path, domain, secure ) 
{
	// set time, it's in milliseconds
	var today = new Date();
	today.setTime( today.getTime() );

	/*
	if the expires variable is set, make the correct 
	expires time, the current script below will set 
	it for x number of days, to make it for hours, 
	delete * 24, for minutes, delete * 60 * 24
	*/
	if ( expires ){
		expires = expires * 1000 * 60 * 60 * 24;
	}
	var expires_date = new Date( today.getTime() + (expires) );

	document.cookie = name + "=" +escape( value ) +
	( ( expires ) ? ";expires=" + expires_date.toGMTString() : "" ) + 
	( ( path ) ? ";path=" + path : "" ) + 
	( ( domain ) ? ";domain=" + domain : "" ) +
	( ( secure ) ? ";secure" : "" );
}

function Delete_Cookie(name,path,domain) {
  if (Get_Cookie(name))
    document.cookie =
      name + '=' +
      ( (path) ? ';path=' + path : '') +
      ( (domain) ? ';domain=' + domain : '') +
      ';expires=Thu, 01-Jan-1970 00:00:01 GMT';
}



function hideobject(id, cookie, handle, src){

	if(this.document.getElementById( id).style.display=='none'){
		this.document.getElementById( id).style.display='inline';

		Set_Cookie(cookie,'true',30,'/','','');
		var show = Get_Cookie(cookie);
		document[handle].src = src;		
	}else{
		this.document.getElementById(  id).style.display='none';

		Set_Cookie(cookie,'false',30,'/','','');
		var show = Get_Cookie(cookie);
		document[handle].src = src;	

	}
}

function showSubMenu(id, handle){
	if(this.document.getElementById( id).style.display=='none'){
		tbButtonMouseOver(handle, 119,'',10);
	}
}

// 


