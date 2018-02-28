<script language="Javascript">

var IB=new Object;
var posX=0;posY=0;
var xOffset=0;yOffset=10;
function montre_legende(texte, texte2) {
  contenu="<TABLE border=0 cellspacing=0 cellpadding="+IB.NbPixel+"><TR bgcolor='"+IB.ColContour+"'><TD><TABLE border=0 cellpadding=2 cellspacing=0 bgcolor='"+IB.ColFond+"'><TR><TD align='left' style='font-weight: bold;'><FONT size='-1' face='arial' color='"+IB.ColTexte+"'>"+texte2+"</FONT></TD></TR><TR><TD><FONT size='-1' face='arial' color='"+IB.ColTexte+"'>"+texte+"</FONT></TD></TR></TABLE></TD></TR></TABLE>&nbsp;";
  var finalPosX=posX-xOffset;
  if (finalPosX<0) finalPosX=0;
  if (document.layers) {
    document.layers["bulle"].document.write(contenu);
    document.layers["bulle"].document.close();
    document.layers["bulle"].top=posY+yOffset;
    document.layers["bulle"].left=finalPosX;
    document.layers["bulle"].visibility="show";}
  if (document.all) {
    //var f=window.event;
    //doc=document.body.scrollTop;
    bulle.innerHTML=contenu;
    document.all["bulle"].style.top=posY+yOffset;
    document.all["bulle"].style.left=finalPosX;//f.x-xOffset;
    document.all["bulle"].style.visibility="visible";
  }
  //modif CL 09/2001 - NS6 : celui-ci ne supporte plus document.layers mais document.getElementById
  else if (document.getElementById) {
    document.getElementById("bulle").innerHTML=contenu;
    document.getElementById("bulle").style.top=posY+yOffset;
    document.getElementById("bulle").style.left=finalPosX;
    document.getElementById("bulle").style.visibility="visible";
  }
}
function getMousePos(e) {
  if (document.all) {
  posX=event.x+document.body.scrollLeft; //modifs CL 09/2001 - IE : regrouper l'évènement
  posY=event.y+document.body.scrollTop;
  }
  else {
  posX=e.pageX; //modifs CL 09/2001 - NS6 : celui-ci ne supporte pas e.x et e.y
  posY=e.pageY; 
  }
}
function cache_legende() {
	if (document.layers) {document.layers["bulle"].visibility="hide";}
	if (document.all) {document.all["bulle"].style.visibility="hidden";}
	else if (document.getElementById){document.getElementById("bulle").style.visibility="hidden";}
}

function InitBulle(ColTexte,ColFond,ColContour,NbPixel) {
	IB.ColTexte=ColTexte;IB.ColFond=ColFond;IB.ColContour=ColContour;IB.NbPixel=NbPixel;
	if (document.layers) {
		window.captureEvents(Event.MOUSEMOVE);window.onMouseMove=getMousePos;
		document.write("<LAYER name='bulle' top=0 left=0 visibility='hide'></LAYER>");
	}
	if (document.all) {
		document.write("<DIV id='bulle' style='position:absolute;top:0;left:0;visibility:hidden'></DIV>");
		document.onmousemove=getMousePos;
	}
	//modif CL 09/2001 - NS6 : celui-ci ne supporte plus document.layers mais document.getElementById
	else if (document.getElementById) {
	        document.onmousemove=getMousePos;
	        document.write("<DIV id='bulle' style='position:absolute;top:0;left:0;visibility:hidden'></DIV>");
	}

}

</script>