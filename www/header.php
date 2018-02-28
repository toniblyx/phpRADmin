<?
/*
phpRADmin is developped under GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt or read LICENSE file.

Developed by : Toni de la Fuente (blyx) from Madrid and Alfacar (Granada), Spain  
For information : toni@blyx.com http://blyx.com

We are using Oreon for base code: http://www.oreon-project.org
We are using Dialup Admin for user management 
and many more things: http://www.freeradius.org
We are using PHPKI for Certificates management: http://phpki.sourceforge.org/ 

Thanks very much!!
*/
// Bench
	function microtime_float() 	{
	   list($usec, $sec) = explode(" ", microtime());
	   return ((float)$usec + (float)$sec);
	}

	$time_start = microtime_float();

	// Load configuration File
	include_once ("phpradmin.conf.php");
	include_once ("$classdir/Session.class.php");
	include_once ("$classdir/Oreon.class.php");

	Session::start();

	if (isset($_POST["export_sub_list"])) {
		$mime_type = 'text/x-text';
		if (!strcmp($_GET['p'], "2"))
			$mime_type .= 'image/jpeg';
		$filename = "phpradmin.sql";
		// Send headers
		header('Content-Type: '.$mime_type);
		// IE need specific headers
		if (stristr($_SERVER['HTTP_USER_AGENT'], "MSIE")) {
			header("Content-Disposition: inline; filename=\"".$filename."\"");
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');
		} else {
			header('Content-Disposition: attachment; filename="'.$filename.'"');
			header('Expires: 0');
			header('Pragma: no-cache');
		}
		if (isset($_POST["s"]) && ($_POST["s"] == 1 || $_POST["s"] == 2 || $_POST["s"] == 4))	{
			include("./include/options/extract_sub.php");exit();}
	}
	else {
		if (!isset($_SESSION["oreon"]))
			header("Location: index.php");
		//alias
		$oreon = & $_SESSION["oreon"];
		if (isset($oreon->optGen)){
			$expire = $oreon->optGen->get_session_expire();
		} else
			$expire = 0;
		
		$oreon->clean_session($expire);
 		if ($oreon->check_if_session_ok())
			$oreon->update_current_session(session_id(), $p, $o);
		else	{
			header("Location: index.php");
			exit();
		}
		// Load traduction in the selected language.
		include_once ("./lang/" . $oreon->user->get_lang() . ".php");
		print "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>";

	include_once("themes/basic/basic_header.php");

	if (isset($p) && $p == 310)
		print "<SCRIPT language='javascript' src='./include/javascript/datepicker.js'></SCRIPT>";
?>
<SCRIPT language='javascript' src='./include/javascript/functions.js'></SCRIPT>
<?
if (isset($oreon->commands) && ($p == 102 || $p == 123 || $p == 104 || $p == 125 || $p == 124))	{
	include_once("./include/javascript/TabOfServHost.php");
}
	// Reload  administration page
	if (!strcmp($p, "303") || !strcmp($p, "1")){
		if (!isset($oreon->optGen))
			$oreon->loadoptgen();
		print "<SCRIPT LANGUAGE='JavaScript'> setTimeout(\"javascript:history.go(0)\",".$oreon->optGen->get_refresh()."000)</SCRIPT>";
	}
?>
</head>
<body leftmargin="0" rightmargin="0" topmargin="0">
<?
	include("./include/javascript/infobulle.php");
?>
	<SCRIPT language="JavaScript">InitBulle("#000000","#CFCFCF","#000000",1);
	// InitBulle(couleur de texte, couleur de fond, couleur de contour taille contour)
	</SCRIPT>
<?
	if (isset($p) && $p == 124 && isset($_GET["o"]) && !strcmp($_GET["o"], "d"))
		include("./include/javascript/loading.html");
	include_once("themes/basic/basic_top_menu.php");
?>
<table align="center" width="100%" border="0" style="margin-bottom: 1px;padding-right: 0px;">
<? } ?>