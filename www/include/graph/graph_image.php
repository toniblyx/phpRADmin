<?
/**
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Julien Mathis - Mathieu Mettre - Romain Le Merlus - Christophe Coraboeuf

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

	// include class
	include_once ("../../oreon.conf.php");
	include_once ("../../$classdir/Session.class.php");
	include_once ("../../$classdir/Oreon.class.php");


	Session::start();

	$oreon = & $_SESSION["oreon"];

	//if (!isset($oreon))
	//	exit();

function escape_command($command) {
	return ereg_replace("(\\\$|`)", "", $command);
}

function escape_colon($command) {
	return ereg_replace(":", "\:", $command);
}

function rrdtool_execute($command_line, $oreon) {

	$command_line = str_replace(";", "", $command_line);
	$command_line = $oreon->optGen->get_rrd_pwd() . " " . $command_line .  " 2>&1";
	$command_line = escape_command("$command_line") ;
	//print $command_line;
	$fp = popen($command_line  , 'r');
	if (isset($fp) && $fp ) {
		$str ='';
		while (!feof ($fp)) {
	  		$buffer = fgets($fp, 4096);
	 		$str = $str . $buffer ;
		}

		// If not a picture...
		if (  (!strstr(substr($str,0,10), 'PNG')) && (!strstr(substr($str,0,10), 'GIF')) ) {
			// We generate own picture with message error
			$fontwidth = ImageFontWidth(2);
		    $fontheight = ImageFontHeight(2);
		    $maxcharsperline = floor(600 / $fontwidth);
		    if ( $maxcharsperline > strlen($str) ) {
		    	$width = floor( strlen($str) * $fontwidth);
		    } else {
		    	$width = 600;
		    }

		    $str = wordwrap($str , $maxcharsperline, "\n", 1);

		    $lines = explode("\n", $str);
		  	$height =  ($fontheight + 5 )* (count($lines)-1);
		    $img_handle = ImageCreate ($width,$height);

			$back_color = ImageColorAllocate ($img_handle, 0, 0, 0);
			$txt_color = ImageColorAllocate ($img_handle, 255, 0, 0);
			imagecolortransparent($img_handle,$back_color);

		   	while (list($numl, $line) = each($lines)) {
		       ImageString($img_handle, 2, 0, $y + 5, $line , $txt_color);
		       $y += $fontheight;
		     }
			ImagePng ($img_handle);
		} else {
			return $str;
		}
	}
}

function rrdtool_function_graph($oreon) {
	// Load traduction in the selected language.
	include_once ("../../lang/" . $oreon->user->get_lang() . ".php");

	$time = $_GET['time'];
	$time2 = $_GET['time2'];
	$verticallabel = html_entity_decode(urldecode($_GET['verticallabel']));
	if (!isset($_GET['timename']))
		$timename = "";
	else
		$timename = html_entity_decode(urldecode($_GET['timename'])) . " -" ;
	$namerrd = $_GET['namerrd'];
	$imgformat = $_GET['imgformat'];
	$width = $_GET['width'];
	$height = $_GET['height'];
	$ColGrilFond = $_GET['ColGrilFond'];
	$ColFond = $_GET['ColFond'];
	$ColPolice = $_GET['ColPolice'];
	$ColGrGril = $_GET['ColGrGril'];
	$ColPtGril = $_GET['ColPtGril'];
	$ColContCub = $_GET['ColContCub'];
	$ColArrow = $_GET['ColArrow'];
	$ColImHau = $_GET['ColImHau'];
	$ColImBa = $_GET['ColImBa'];
	$path = $_GET['path'];
	$ds1name = escape_colon(html_entity_decode(urldecode($_GET['ds1name'])));
	$dsname[2] = escape_colon(html_entity_decode(urldecode($_GET['ds2name'])));
	$ColDs1 = $_GET['ColDs1'];
	$ColDs[2] = $_GET['ColDs2'];
	$dsname[3] = escape_colon(html_entity_decode(urldecode($_GET['ds3name'])));
	$dsname[4] = escape_colon(html_entity_decode(urldecode($_GET['ds4name'])));
	$ColDs[3] = $_GET['ColDs3'];
	$ColDs[4] = $_GET['ColDs4'];
	$flamming = $_GET['flamming'];
	$lowerlimit = $_GET['lowerlimit'];
	$areads1 = $_GET['areads1'];
	$ticknessds1 = $_GET['ticknessds1'];
	$gprintlastds1 = $_GET['gprintlastds1'];
	$gprintminds1 = $_GET['gprintminds1'];
	$gprintaverageds1 = $_GET['gprintaverageds1'];
	$gprintmaxds1 = $_GET['gprintmaxds1'];
	$areads[2] = $_GET['areads2'];
	$ticknessds[2] = $_GET['ticknessds2'];
	$gprintlastds[2] = $_GET['gprintlastds2'];
	$gprintminds[2] = $_GET['gprintminds2'];
	$gprintaverageds[2] = $_GET['gprintaverageds2'];
	$gprintmaxds[2] = $_GET['gprintmaxds2'];
	$areads[3] = $_GET['areads3'];
	$ticknessds[3] = $_GET['ticknessds3'];
	$gprintlastds[3] = $_GET['gprintlastds3'];
	$gprintminds[3] = $_GET['gprintminds3'];
	$gprintaverageds[3] = $_GET['gprintaverageds3'];
	$gprintmaxds[3] = $_GET['gprintmaxds3'];
	$areads[4] = $_GET['areads4'];
	$ticknessds[4] = $_GET['ticknessds4'];
	$gprintlastds[4] = $_GET['gprintlastds4'];
	$gprintminds[4] = $_GET['gprintminds4'];
	$gprintaverageds[4] = $_GET['gprintaverageds4'];
	$gprintmaxds[4] = $_GET['gprintmaxds4'];
	$dsflg = $_GET['dsflg'];
	$name = html_entity_decode(urldecode($_GET['name']));

	// GRAPH MAIN
	$graph_opts = "graph - ";
	$graph_opts .= "--interlaced ";
	$graph_opts .= "--start=$time ";
	if (strcmp($time2, 0)) {
		$graph_opts .= "--end=$time2 ";
	}
	$graph_opts .= "--vertical-label=\"$verticallabel\" ";
	$graph_opts .= "--title=\"$timename $name\" ";
	$graph_opts .= "--imgformat=$imgformat ";
	$graph_opts .= "--alt-autoscale-max ";
	$graph_opts .= "--lower-limit=$lowerlimit ";
	//$graph_opts .= "--interlace  ";
	$graph_opts .= "--width=$width ";
	$graph_opts .= "--height=$height ";
	$graph_opts .= "--color CANVAS#$ColGrilFond ";
	$graph_opts .= "--color BACK#$ColFond ";
	$graph_opts .= "--color FONT#$ColPolice ";
	$graph_opts .= "--color MGRID#$ColGrGril ";
	$graph_opts .= "--color GRID#$ColPtGril ";
	$graph_opts .= "--color FRAME#$ColContCub ";
	$graph_opts .= "--color ARROW#$ColArrow ";
	$graph_opts .= "--color SHADEA#$ColImHau ";
	$graph_opts .= "--color SHADEB#$ColImBa ";

	// GRAPH DATA SOURCE A / Ds1
	$graph_opts .= "DEF:a=$path$namerrd:a:AVERAGE  ";
	$graph_opts .= "DEF:m=$path$namerrd:a:MAX  ";
	// GRAPH DATA SOURCE A / Ds1 OPTIONS

/*	for ($pct = 0; $pct <= 104; $pct += 4) {
		$graph_opts .= "CDEF:max".$pct."pct=m,$pct,*,100,/ ";
		$graph_opts .= "CDEF:val$pct=max".$pct."pct,a,GT,0,max".$pct."pct,IF ";
	}
	if (!strcmp($flamming, "yes")) {	// FLAMMING

		for ($pct = 100; $pct > 0; $pct -= 4) {
			$tmp = sprintf("%02x%02x", 0xff * (100 - $pct) / 100, 0x5f * (100 - $pct) / 100);
			if ($pct != 0)
				$graph_opts .= "AREA:val$pct#ff$tmp ";
			else{
				if ($pct == 100){
					$graph_opts .= "AREA:a#ff$tmp:$ds1name ";
					$graph_opts .= "AREA:val$pct#ff$tmp ";
				}
				else
					$graph_opts .= "AREA:val$pct#ff$tmp ";
			}
		}
	}*/
	/*
	for ($pct = 4; $pct <= 100; $pct += 4) {
		$graph_opts .= "CDEF:max".$pct."pct=m,$pct,*,100,/ ";
		$graph_opts .= "CDEF:val$pct=max".$pct."pct,a,GT,0,max4pct,IF ";
	}
//	$graph_opts .= "AREA:a#ff0000:$ds1name ";
	if (!strcmp($flamming, "yes")) {	// FLAMMING
		$tmp = "";
		for ($pct = 4; $pct <= 100; $pct += 4) {
			$tmp = sprintf("%02x%02x", 0xff * (100 - $pct) / 100, 0x5f * (100 - $pct) / 100);
			if ($pct == 4)
				$graph_opts .= "AREA:val$pct#ff$tmp ";
			else
				$graph_opts .= "STACK:val$pct#ff$tmp ";
		}
	}
	*/
	/* RRDTOOL 1.2 Incompatibilities
	   ------------------------------
			* Colons in COMMENT arguments to rrdtool graph must be escaped with a backslash
	*/
	if (!strcmp($oreon->optGen->get_rrdtool_version(), '1.2')) {
	    $rrd_time =  escape_colon(date($lang["date_time_format_g_comment"], time() + $time)) ;
	    $rrd_time2 = escape_colon(date($lang["date_time_format_g_comment"], time() + $time2)) ;
	} else {
	    $rrd_time =  date($lang["date_time_format_g_comment"], time() + $time) ;
	    $rrd_time2 = date($lang["date_time_format_g_comment"], time() + $time2) ;
	}
	$graph_opts .= "COMMENT:\" ". $lang["g_from"] . $rrd_time . $lang["g_to"] . $rrd_time2 . "\\c\" ";
	if (!strcmp($flamming, "no")) {
		if (!strcmp ($areads1, "yes")) {
			$graph_opts .= "AREA:a#$ColDs1:\"$ds1name\" ";
		} else {
			if (!strcmp ($ticknessds1, "1"))
				$graph_opts .= "LINE1:a#$ColDs1:\"$ds1name\" ";
			if (!strcmp ($ticknessds1, "2"))
				$graph_opts .= "LINE2:a#$ColDs1:\"$ds1name\" ";
			if (!strcmp ($ticknessds1, "3"))
				$graph_opts .= "LINE3:a#$ColDs1:\"$ds1name\" ";
		}
	}
	$graph_opts .= "CDEF:flaming1=a,40,*,100,/ ";
	$graph_opts .= "CDEF:flaming2=a,5,*,100,/ ";
	if (!strcmp($flamming, "yes")) {
		$graph_opts .= "AREA:flaming1#ffff5f:\"$ds1name\" ";
		$graph_opts .= "STACK:flaming2#fffc51 ";
		$graph_opts .= "STACK:flaming2#fffc51 ";
		$graph_opts .= "STACK:flaming2#fff046 ";
		$graph_opts .= "STACK:flaming2#ffe95f ";
		$graph_opts .= "STACK:flaming2#ffd237 ";
		$graph_opts .= "STACK:flaming2#ffc832 ";
		$graph_opts .= "STACK:flaming2#ffbe2d ";
		$graph_opts .= "STACK:flaming2#ffaa23 ";
		$graph_opts .= "STACK:flaming2#ff9619 ";
		$graph_opts .= "STACK:flaming2#ff841e ";
		$graph_opts .= "STACK:flaming2#ff841e ";
		$graph_opts .= "STACK:flaming2#ff6600 ";
	}
	// VALUES
	if (!strcmp ($gprintlastds1, "yes")){
		$graph_opts .= "GPRINT:a:LAST:\"".escape_colon($lang["g_current"])."%8.2lf%s"; // "GPRINT:a:LAST:\"Last calc %lf%s\\l\" "
		if ((!strcmp ($gprintminds1, "yes") || !strcmp ($gprintaverageds1, "yes") || !strcmp ($gprintmaxds1, "yes"))
			|| ($dsflg == 1  && !strcmp ($gprintmaxds1, "yes") && !strcmp ($gprintaverageds1, "yes") && !strcmp ($gprintminds1, "yes")))
			$graph_opts .= "\" ";
		else
			$graph_opts .= "\\l\" ";
	}
	if (!strcmp ($gprintminds1, "yes")){
		$graph_opts .= "GPRINT:a:MIN:\"Min\:%8.2lf%s";
		if ((!strcmp ($gprintaverageds1, "yes") || !strcmp ($gprintmaxds1, "yes")) || ($dsflg == 1 && !strcmp($gprintmaxds1, "yes") && !strcmp($gprintaverageds1, "yes")))
			$graph_opts .= "\" ";
		else
			$graph_opts .= "\\l\" ";
	}
	if (!strcmp ($gprintaverageds1, "yes"))	{
		$graph_opts .= "GPRINT:a:AVERAGE:\"". escape_colon($lang["g_average"]) ."%8.2lf%s";
		if (!strcmp ($gprintmaxds1, "yes") || ($dsflg == 1 && !strcmp ($gprintmaxds1, "yes")))
			$graph_opts .= "\" ";
		else
			$graph_opts .= "\\l\" ";
	}
	if (!strcmp ($gprintmaxds1, "yes"))
		$graph_opts .= "GPRINT:a:MAX:\"Max\:%8.2lf%s\\l\" ";

	// GRAPH DATA SOURCE B / Ds2

	$tab = array("z", "a", "b", "c", "d");
	for ($i = 2 ; $i <= 4 && $i <= $dsflg ; $i++)
	{
		if ($dsflg >= $i) {
			$graph_opts .= " DEF:$tab[$i]=$path$namerrd:$tab[$i]:AVERAGE ";
			// GRAPH DATA SOURCE B / Ds2 OPTIONS
			if (!strcmp ($areads[$i], "yes")) {
				$graph_opts .= "AREA:$tab[$i]#$ColDs[$i]:\"$dsname[$i]\" ";
			} else {
				if (!strcmp ($ticknessds[$i], "1"))
					$graph_opts .= "LINE1:$tab[$i]#$ColDs[$i]:\"$dsname[$i]\" ";
				if (!strcmp ($ticknessds[$i], "2"))
					$graph_opts .= "LINE2:$tab[$i]#$ColDs[$i]:\"$dsname[$i]\" ";
				if (!strcmp ($ticknessds[$i], "3"))
					$graph_opts .= "LINE3:$tab[$i]#$ColDs[$i]:\"$dsname[$i]\" ";
			}

			if (!strcmp ($gprintlastds[$i], "yes")){
				$graph_opts .= "GPRINT:$tab[$i]:LAST:\"".escape_colon($lang["g_current"])."%8.2lf%s";
				if ((!strcmp ($gprintminds[$i], "yes") || !strcmp ($gprintaverageds[$i], "yes") || !strcmp ($gprintmaxds[$i], "yes"))
					|| ($dsflg >= $i && !strcmp ($gprintmaxds[$i], "yes") && !strcmp ($gprintaverageds[$i], "yes") && !strcmp ($gprintminds[$i], "yes")))
					$graph_opts .= "\" ";
				else
					$graph_opts .= "\\l\"";
			}
			if (!strcmp ($gprintminds[$i], "yes")){
				$graph_opts .= "GPRINT:$tab[$i]:MIN:\"Min\:%8.2lf%s";
				if ((!strcmp ($gprintaverageds[$i], "yes") || !strcmp ($gprintmaxds[$i], "yes")) || ($dsflg >= $i && !strcmp($gprintmaxds[$i], "yes") && !strcmp($gprintaverageds[$i], "yes")))
					$graph_opts .= "\" ";
				else
					$graph_opts .= "\\l\"";
			}
			if (!strcmp ($gprintaverageds[$i], "yes")){
				$graph_opts .= "GPRINT:$tab[$i]:AVERAGE:\"". escape_colon($lang["g_average"]) ."%8.2lf%s";
				if (!strcmp ($gprintmaxds[$i], "yes") || ($dsflg >= $i && !strcmp ($gprintmaxds[$i], "yes")))
					$graph_opts .= "\" ";
				else
					$graph_opts .= "\\l\"";
			}
			if (!strcmp ($gprintmaxds[$i], "yes"))
				$graph_opts .= "GPRINT:$tab[$i]:MAX:\"Max\:%8.2lf%s\\l\" ";
		}
	}
	//print $graph_opts;
	return rrdtool_execute("$graph_opts", $oreon);
}

print rrdtool_function_graph($oreon);
?>
