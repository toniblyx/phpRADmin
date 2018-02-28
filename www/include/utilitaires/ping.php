<?
/*
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)
For information : toni@blyx.com
*/
	// Load configuration File
	include_once ("../../oreon.conf.php");
	include_once ("../../$classdir/Session.class.php");
	
	Session::start();
	
	if (!isset($_SESSION["oreon"])) {print '<center><font color="red"><b>Sorry , acces forbidden.</b></font></center>'; exit();};
?>
<html>
<head><title>PING</title></head>
<body>
<font style="font-family: verdan, arial, helvetica;">
	<?
	if (isset($_GET["ip"]) && strcmp($_GET["ip"], "")){
		$ip_after = preg_split ("/[;\<\>|]{1}/", $_GET["ip"]);
		$stdout = shell_exec("/bin/ping " . $ip_after[0] . " -c 4");
		$tab = preg_split ("/[\n]+/", $stdout);
		foreach ($tab as $str){
			$str = str_replace(" ", "&nbsp;", $str);
			$str = str_replace("	", "&nbsp;&nbsp;&nbsp;&nbsp;", $str);
			print "<nobr>" . $str . "</nobr><br>";
		}	
	
	} ?>
</font>
</body>
</html>