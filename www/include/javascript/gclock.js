/*  GClock : a versatile and easy to use time display module

    Developed by Hans B PUFAL  : mailto:hans.pufal@gmail.com
    Copyright (c) 2006 Hans B PUFAL
    Released under the GPL open source licence. You are hereby given the right
    to make use of this code subject to the provisions and conditions detailed 
    in the GLPL licence. For any other use, please contact the author.
    
    Full package available at http://www.pufal.net/GClock                    */
/*
if (typeof getElementsByClass == 'undefined')
  function getElementsByClass (node, search, tag) {
    var classElements = new Array();
    var els = node.getElementsByTagName(tag || '*');
    var pattern = new RegExp("(^|\\s)"+search+"(\\s|$)", 'i');
    for (i = 0, j = 0; i < els.length; i++) {
      if (pattern.test(els[i].className))
        classElements[j++] = els[i];
    }
    return classElements;
  }
*/

if (typeof getElementsWithAttribute == 'undefined') 
  function getElementsWithAttribute (
    ele, att, val) {
    var
      e,
      a,
      ne = [];

    for (var i = (ele || document).childNodes.length; i--;) {
      if ((e = ele.childNodes[i]).getAttribute && ((a = e.getAttribute (att)) || (e.hasAttribute ? e.hasAttribute (att) : (typeof a == 'string'))) && 
      ((typeof val == 'undefined') || ((a || '').indexOf (val) >= 0))) {
        ne.push (e);
      }
      
      if (e.childNodes && e.childNodes.length)
        ne = ne.concat (getElementsWithAttribute (e, att, val));
    }

    return ne;
  }


if (!String.parseAttributes) 
  String.prototype.parseAttributes = function () {
    var 
      av,
      a = {},
      attrib = this.split (/\s*;\s*/);
      
    for (var i = attrib.length; i--;)
      if (attrib[i]) {
        av = attrib[i].match (/^([a-z0-9-_]+)(:\s*(.*)\s*)?$/i);
        if (av && av[3] && av[3].match (/^\d+$/)) av[3] = parseInt (av[3], 10);
        av && av.length && (a[av[1].toLowerCase()] = ((!av[3] || (av[3] == '')) ? true : av[3]));
      }
    return a;
  }


if (typeof loadFile == 'undefined')   
  function loadFile (fnames, module) {
    (typeof fnames == 'string') && (fnames = fnames.split(/\s*,\s*/));
    if (fnames.length == 0)
      return;

    if (module) {
      var m = document.getElementsByTagName ('SCRIPT');
      for (var i = m.length; i--;) 
        if (m[i].src && (m[i].src.indexOf (module) !== -1)) {
          module = m[i].src.slice (0, - module.length);
          break;
        }
      module = module.replace('http://', '');
      module = module.slice (module.indexOf ('/'));
    } else
      module = '';
    
    for (var i = fnames.length; i--;) {
      var 
        fileref,
        file = fnames[i];
        
      if (file.toLowerCase ().slice(-3) == '.js') {
        fileref = document.createElement('script')
        fileref.setAttribute ("type", "text/javascript");
        fileref.setAttribute ("src", module + file);
      }
      
      else if (file.toLowerCase ().slice(-4) == ".css") {
        fileref=document.createElement ("link")
        fileref.setAttribute ("rel", "stylesheet");
        fileref.setAttribute ("type", "text/css");
        fileref.setAttribute ("href", module + file);
      }
      else
        continue;

      document.getElementsByTagName ("head").item (0).appendChild (fileref);
    }
  }


var gclock = {
  display : null,
  ticker : null,
  
  init : function () {
    if (typeof getElementsWithAttribute == 'function') {
      var ele = getElementsWithAttribute (document, 'Gclock');

      for (var i = ele.length; i--;) {
        var 
          clk = ele[i];
          a = (clk.getAttribute ('Gclock') || '').parseAttributes ();

        if (a.style) {
          var
            html = '';

          !a.format && (a.format = '%H~%i');  
          for (var j = 0 ; j < a.format.length; j++)	 
            html += "<span class='"+ a.style +" D"+j+"'></span>"
          clk.innerHTML = html;
          loadFile (a.style + '.css', 'gclock.js');
        }
      }

      ele.length && gclock.tick ();
    }
    
    if (window.removeEventListener) {
      window.removeEventListener('load', gclock.init, false);
    } else if (window.detachEvent) {
      window.detachEvent('onload', gclock.init);
    } else alert ('cannot remove onLoad');

  },


  tick : function () {
    var
      alarm,
      options,
      fdisp,
      tDate = new Date(),
      h = tDate.getHours (),
      m = tDate.getMinutes (),
      s = tDate.getSeconds (),
      zh, zm,
      bdisp = ('S'+h).slice (-2) + ((1 & s) ? 'S' : 'C') + ('0'+m).slice (-2),
      clocks = getElementsWithAttribute (document, 'Gclock');

    if (clocks.length == 0) {
      gclock.ticker && clearInterval (gclock.ticker);
      gclock.ticker = null;
      return;
    }

    !gclock.ticker && (gclock.ticker = setInterval (gclock.tick, 500));
    
    if (bdisp == gclock.display)
      return;
    
    for (var c = clocks.length; c--;) {
      options = (clocks[c].getAttribute ('Gclock') || '').parseAttributes ();
      !options.format && (options.format = "%G~%i");

      if (zh = (options.gmt || options.utc))
        zh = ((zh === true) ? 0 : parseInt(zh, 10)) + tDate.getUTCHours(), zm = tDate.getUTCMinutes();
      else
        zh = h, zm = m;
      
      var zh = zh + parseInt (options.tzone || '0', 10);
      while (zh > 23) zh -= 24;
      while (zh < 0) zh += 24; 
      
      fdisp = options.format;
	    fdisp = fdisp.replace ('%a', (zh < 12) ? 'am' : 'pm');
	    fdisp = fdisp.replace ('%A', (zh < 12) ? 'AM' : 'PM');
	    fdisp = fdisp.replace ('%g', (' ' + ((zh > 12) ? (zh % 12) : zh)).slice (-2));
	    fdisp = fdisp.replace ('%G', (' '+zh).slice (-2));
	    fdisp = fdisp.replace ('%h', ('0'+((zh>12)?zh-12:zh)).slice (-2));
	    fdisp = fdisp.replace ('%H', ('0'+zh).slice (-2));
	    fdisp = fdisp.replace ('%i', ('0'+zm).slice (-2));
	    fdisp = fdisp.replace ('%s', ('0'+s).slice (-2));
	      
      if (options.style) {
        var chN;
        for (var i = 0; i < fdisp.length; i++) {
   	      chN = (' ' == (chN = fdisp.charAt(i))) ? 'S' : ((':' == chN) ? 'C' : (('~' == chN) ? ((1 & s) ? 'N' : 'C') : chN));
	        var digits = getElementsByClass (clocks[c], 'D'+i);
	        digits.length && (digits[0].className = options.style + ' D' + i + ' ' + options.style + chN);
	      }
	    }
      else if (clocks[c].innerHTML != fdisp)
        clocks[c].innerHTML = fdisp.replace (/~/g, ((1 & s) ? ' ' : ':'));
		  
      if (((s % 10) == 0) && options.alarm && (alarm = options.alarm.match (/^(\d\d?):(\d\d?)(:\d0)?\s+(.*)$/)) &&
          alarm.length && (alarm[1] == h) && (alarm[2] == m) && 
          (((typeof alarm[3] == 'undefined') ? '00' : alarm[3]).slice(-2) == s)) {
          try  { eval (alarm[4]);} 
	          catch (e) { alert (alarm[4]); }
	      }
    }
      
    gclock.display = bdisp;
  }
}


if (typeof modules == 'undefined') {
  if (gclock && gclock.init) {
    if (window.addEventListener)
      window.addEventListener ('load', gclock.init, false);
    else if (window.attachEvent)
      window.attachEvent ("onload", gclock.init);
  }
}
else
  (modules ['gclock'] = gclock.init) ();
