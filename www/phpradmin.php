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
include ("./include/session/multiuser_mode.php");
	//xdebug_start_trace(); 
	if (isset($_GET["p"]))
		$p = $_GET["p"];
	else if (isset($_POST["p"]))
		$p = $_POST["p"];
	else 
		$p = 1;
		
	if (isset($_GET["o"]))
		$o = $_GET["o"];
	else if (isset($_POST["o"]))
		$o = $_POST["o"];
	else 
		$o = 0;

	// header
	include ("./header.php");
	
	// Menu
	include ("themes/basic/basic_menu.php");


	if (!isset($oreon->user))
		include ("./index.php");
	// Load Object
	
	if (!isset($oreon->Nagioscfg))
		$oreon->loadNagioscfg();
	if (!isset($oreon->Resourcecfg))
		$oreon->loadResourcecfg();
	if (!isset($oreon->htms))
		$oreon->loadHostTemplateModel();
	if (!isset($oreon->stms))
		$oreon->loadServiceTemplateModel();
	if (!isset($oreon->optGen))
		$oreon->loadoptgen();
	if (!isset($oreon->users))
		$oreon->loadUsers();	
	unset($oreon->user_online);
	
	/* check if object must be reload when interface is using in multiuser mode */
	check_reload_data($oreon);	
		
	if ($p >= 300 && $p <= 399){
		if (isset($Logs))
			unset($Logs);
		if ($p == 303 || $p == 306 || $p == 314 || $p == 315 || $p == 317)  
			$Logs = new Logs($oreon);
	}

	// permisions
	function check_law($page, $status, $version = -1)      {
		if (($page >= 101 && $page <= 126) && ($status == 2 || $status == 3))
			return true;
		else if (($page >= 301 && $page <= 319) && ($status == 1 || $status == 2 || $status == 3))
			return true;
		else if ($page == 212)
			return true;
		else if (($page >= 201 && $page <= 216) && ($status == 3))
			return true;
		else if (($page >= 203 && $page <= 212) && ($status == 2))
			return true;
		else if (($page >= 501 && $page <= 512) && ($status == 1 || $status == 2 || $status == 3))
			return true;
		else
			return false;
	}

	if (! isset($oreon->redirectTo))
		$oreon->loadRedirectTo();
	if ($p != 1)
		print "<td width='85%' valign='top' style='border: 1px solid #E9E5E5;padding-top:5px;padding-left:5px;'>";
	else
		print "<td width='100%' colspan='2' valign='top' style='border: 1px solid #E9E5E5;padding-top:5px;padding-left:5px;padding-right:5px;padding-bottom:5px;'>";
	if (isset($oreon->redirectTo[$p]) && file_exists($oreon->redirectTo[$p]->get_pages()) && $oreon->redirectTo[$p]->right <= $oreon->user->status)
		include($oreon->redirectTo[$p]->get_pages());
	else
		include("./alt_error.php");
	print "</td>";
	include ("./footer.php");
?>