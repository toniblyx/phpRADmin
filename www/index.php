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
	if (!file_exists("./phpradmin.conf.php")) 
		header("Location: ./install/setup.php");
	else {
		include_once ("./phpradmin.conf.php");
	include_once ("$classdir/Session.class.php");
	include_once ("$classdir/OreonDatabase.class.php");
	include_once ("$classdir/User.class.php");
	include_once ("$classdir/Oreon.class.php");

	// detect installation dir
	$file_install_acces = 0;
	if (file_exists("./install/setup.php")){
		$error_msg = "Installation Directory '". getcwd() ."/install/' is accessible. Delete this directory to prevent security problem. Please change directory permissions for'". getcwd(). "' with chmod 755 '". getcwd(). "' ";
		$file_install_acces = 1;
	}
	Session::start();
	if (isset($_GET["disconnect"])) {
		$oreon = & $_SESSION["oreon"];
		Session::stop();
		Session::start();
	}

	if (isset($_SESSION["oreon"])) {	// already connected
		include("./lang/en.php");
			$msg_error = $lang['already_logged'];
	}
	else {
		if (isset($_POST["submit"])) {
			$oreon_db = new OreonDatabase($conf_pra["host"], $conf_pra["user"], $conf_pra["password"], $conf_pra["db"]);
			if (($user_id = $oreon_db->checkUser(addslashes($_POST["useralias"]), $_POST["password"]))) {
				$user = new User($oreon_db->getUser($user_id));
				$_SESSION["oreon"] = new oreon($user, $oreon_db);
				system("echo \"[" . time() . "] LOGIN from ". $_SERVER["REMOTE_ADDR"] . ";;" . addslashes($_POST["useralias"]) . "\" >> ./include/log/" . date("Ymd") . ".txt");
				$_SESSION["oreon"]->add_new_session(session_id(), $_SESSION["oreon"]->user->get_id());
				header("Location: ./phpradmin.php?p=1");
			}
			else
				system("echo \"[" . time() . "] Err LOGIN from ". $_SERVER["REMOTE_ADDR"] . ";;" . addslashes($_POST["useralias"]) . "\" >> ./include/log/" . date("Ymd") . ".txt");

		}
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>phpRADmin - FreeRADIUS web management</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="themes/basic/basic_style.css" rel="stylesheet" type="text/css">
<link rel="shortcut icon" href="img/favicon.ico">
<script src='include/javascript/gclock.js'></script>
<style type="text/css">
.Estilo1 {color: #D5AE26}
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: none;
}
a:active {
	text-decoration: none;
}
.Estilo3 {font-size: 40%}

#getfirefox {
	top: 30px; 
	position: absolute; 
	right: 30px;
	width: 142px;
	height: 50px;
}

#getfirefox a {
	background: url('img/getfirefox.png') no-repeat 0 0;
	width: 142px;
	height: 50px;
	display: block;
}

#getfirefox a:hover {
	background-position: -142px;
}
input {
	border: 1px solid #cccccc;
	background-color: #ffffff;
	color: #787878;
	font-size: 8pt;
}
body{
	font-family: Verdana, Lucida, sans-serif;
	background-color: #ffffff;
	font-size: 8pt;
	line-height: 1.7;
	color: #787878;
	margin: 0;
	padding: 0;
}
.be {	font-weight:bold;
	font-size: 12pt;
	color: #565656;
}
</style>
</head>
<body OnLoad="document.login.useralias.focus();">
<div class="text20b" align="center" style="padding-top: 30px; padding-bottom: 40px;">
<!--	phpRADmin -->
</div>
<table align="center" border="0" class="color2">
	<tr>
		<td width="585" height="282" align="center" valign="middle"><p>
		  <img src="img/logo-name.jpg"><br>
		  Version <? include ("include/version/version.php"); ?>
		  </p>
<form action="./index.php" method="post" name="login">
		<?
			if ($file_install_acces)
				print "<center><span class='msg'>$error_msg</span></center>";
		?>
 	    <table width="161" height="126" border="0" cellpadding="0" cellspacing="2">
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td width="59" align="right"><span class="text10b">User: </span></td>
            <td align="right"><input name=useralias style="WIDTH: 96px" maxlength="32"></td>
          </tr>
          <tr>
            <td align="right"><span class="text10b">Password: </span></td>
            <td align="right"><input name=password type=password style="WIDTH: 96px" maxlength="32"></td>
          </tr>
          <tr align="right">
            <td colspan="2"><input class=textnormal type=submit value=Login name=submit></td>
          </tr>
        </table>
 	      </form>
		  <p>		      
		    <?
		if (isset($msg_error))
			echo "<div style='padding-top: 10px;' class='text12bc'>$msg_error</div>";
		else if (isset($_POST["submit"]))
			echo "<div style='padding-top: 10px;' class='text12bc'>Invalid User or Password</div>";
	}
	?>  
          </p>
	  </td>
	</tr>
</table>
<div id="getfirefox">
	<a href="http://getfirefox.com/" target="_blank" title="Get Firefox - web browsing reloaded."></a>
</div>
</body>
</html>
