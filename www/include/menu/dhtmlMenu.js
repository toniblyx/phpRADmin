// <![CDATA[
/*****************************************************************
Simple standard supporting foldoutmenu script  
copyright 2002 Thomas Brattli - www.dhtmlcentral.com 

Will only work in ie5+ and Mozilla/NS6+

NOTES: 
Styling up LI and UL tags is NOT the easiest thing to do.
The browsers tend to treat it different

Styles availble:

a.myMenu[level] (ie: a.myMenu0)
a.myMenu[level]:hover (and visited and active)
ul.myMenu[level]
li.myMenu[level]  

Make those styles in a stylesheet to style up the elements.
Because the elements do not have any class or style in the
beginning the style should not mess up anything in strange 
browsers like NS4. 
*****************************************************************/
function loopElements(el,level){
	for(var i=0;i<el.childNodes.length;i++){
		//We only want LI nodes:
		if(el.childNodes[i] && el.childNodes[i]["tagName"] && el.childNodes[i].tagName.toLowerCase() == "li"){
			//Ok we have the LI node - let's give it a className
			el.childNodes[i].className = "myMenu"+level
			//Let's look for the A and if it has child elements (another UL tag)
			childs = el.childNodes[i].childNodes
			for(var j=0;j<childs.length;j++){
				temp = childs[j]
				if(temp && temp["tagName"]){
					if(temp.tagName.toLowerCase() == "a"){
						//We found the A tag - let's style it
						temp.className = "myMenu"+level
						//Onclick event
						temp.onclick = showHide;
						//var to hold the a tag
						el.childNodes[i].a = temp
					}else if(temp.tagName.toLowerCase() == "ul"){
						if(el.childNodes[i].a){ //Add arrow
							span = document.createElement("span")
							span.style.fontFamily="webdings"
							el.childNodes[i].a.insertBefore(span,el.childNodes[i].a.childNodes[0])
						}
						//Set class and hide the UL
						temp.style.display='none'
						temp.className= "myMenu"+level
						//Recursive - calling it self to go all the way through the three.
						loopElements(temp,level +1) 
					}
				}
			}	
		}
	}
}
function showHide(){
	//Bluring the tag so we don't get the "selected square"
	this.blur()
	//We have a A tag - need to go to the LI tag to check for UL tags:
	el = this.parentNode
	//Loop for UL tags:
	for(var i=0;i<el.childNodes.length;i++){
		temp = el.childNodes[i]
		if(temp && temp["tagName"] && temp.tagName.toLowerCase() == "ul"){
			//Check status:
			if(temp.style.display=="none"){
				temp.style.display = ""
				//Change the arrow:
				if(this.childNodes[0] && this.childNodes[0]["tagName"] && this.childNodes[0].tagName.toLowerCase()=="span"){
					this.childNodes[0].replaceChild(document.createTextNode("6"),this.childNodes[0].childNodes[0])
				}				
			}else{
				temp.style.display = "none"
				//Change the arrow:
				if(this.childNodes[0] && this.childNodes[0]["tagName"] && this.childNodes[0].tagName.toLowerCase()=="span"){
					this.childNodes[0].replaceChild(document.createTextNode("4"),this.childNodes[0].childNodes[0])
				}			
			}
		}
	}
	//Returning true if there's a link there. Else returns false so it doesn't go to "#"
	if(this.href!="#"){
		return true
	}else return false
}


function setClasses(menu){
	var menu = document.getElementById(menu)
	if(!menu.childNodes) return //Opera supports getElementById - but not childNodes
	menu.className="myMenu"+0
	//hide the menu before styling it:
	loopElements(menu,0)
	
}
//Browsercheck --
if(document.getElementById && document.createElement) setClasses("myMenu")
// ]]>