<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/$str = "";
	
	function return_color($i, $status){
		if (!strcmp($status, "CRITICAL") || !strcmp($status, "DOWN"))
			return "#FFBBBB";
		if ($i % 2 == 1)
			return  "#E9E9E9";
		else
			return "#E0E0E0";
	}
	
	function return_color_status($status){
		global  $oreon;
		if (!strcmp($status, "CRITICAL") || !strcmp($status, "DOWN"))
			return $oreon->optGen->get_color_critical();
		else if (!strcmp($status, "OK") || !strcmp($status, "UP"))
			return $oreon->optGen->get_color_ok();
		else if (!strcmp($status, "WARNING"))
			return $oreon->optGen->get_color_warning();
		else if (!strcmp($status, "PENDING"))
			return $oreon->optGen->get_color_pending();
		else
			return $oreon->optGen->get_color_unknown();
	}
	// init value for each included file
	$i = 0;
	$old = "";

	if ((isset($_GET["o"]) && !strcmp($_GET['o'], "h")))
		include("./include/status/host.php");
	else if ((isset($_GET["o"]) && !strcmp($_GET['o'], "hp")))
		include("./include/status/host_probleme.php");
	else if (!isset($_GET["o"]) || (isset($_GET["o"]) && !strcmp($_GET['o'], "s") || !strcmp($_GET['o'], "")))
		include("./include/status/service.php");
	else if (!strcmp($_GET['o'], "sp"))
		include("./include/status/service_probleme.php");
	else if (isset($_GET["o"]) && !strcmp($_GET['o'], "sc"))
		include("./include/status/service_sc.php");
	else if (isset($_GET["o"]) && !strcmp($_GET['o'], "hg"))
		include("./include/status/hostgroup.php");
	else if (isset($_GET["o"]) && !strcmp($_GET['o'], "proc"))
		include("./include/status/proc_info.php");
	else if (isset($_GET["o"]) && !strcmp($_GET['o'], "sg"))
		include("./include/status/status_gird.php");
	else if (isset($_GET["o"]) && !strcmp($_GET['o'], "sm"))
		include("./include/status/status_summary.php");
	else if (isset($_GET["o"]) && !strcmp($_GET['o'], "sgr"))
		include("./include/status/status_servicegroup.php");
?>