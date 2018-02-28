<?
/*
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)
For information : toni@blyx.com
*/


	include_once ("../../oreon.conf.php");
	include_once ("../../class/Session.class.php");
	include_once ("../../class/Oreon.class.php");
	include_once ("../../include/jpgraph/jpgraph_pie.php");
	include_once ("../../include/jpgraph/jpgraph_pie3d.php");
	Session::start();
	$oreon = & $_SESSION["oreon"];

	if (!isset($oreon))
		exit();

	$hosts = & $oreon->hosts;
	$services = & $oreon->services;
	// Launch log analyse
	$Logs = new Logs($oreon);
?>
<html>
<head>
<title> Oreon - <? echo $lang["live_report"]; ?></title>
<link href="styles.css" rel="stylesheet" type="text/css">
</head>
<body bottommargin="0" leftmargin="0" topmargin="10" rightmargin="0" bgcolor="#FFFFFF">

</body>
</html>

