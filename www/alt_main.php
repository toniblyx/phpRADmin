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
*/	if (!isset($oreon))
		exit();

	function return_color_health($h)	{
		if ($h < 25)
			return "#F5574C";
		else if (($h >= 25) && ($h < 50))
			return "#F5C425";
		else if (($h >= 50) && ($h <= 75))
			return "#FABF37";
		else if ($h > 75)
			return "#3BF541";
	}
	$Logs = new Logs($oreon); ?>
	<table border=0 width="100%" class="tabTableTitleHome">
		<tr>
			<td style="text-align:left;font-family:Arial, Helvetica, Sans-Serif;font-size:13px;padding-left:20px;font-weight: bold;"><? echo $lang['status']; ?></td>
		</tr>
	</table>
	<table border=0 width="100%" class="tabTableHome" style="padding-top:8px;">
		<tr>
		  <td width="100%" align="center" colspan="2">
			<table border=0 cellpadding="0" cellspacing="0" align="center">
						<td class="text10b" align="center" style="white-space: nowrap; padding-right: 3px;">
						<? $radius_status = shell_exec ($oreon->optGen->get_startup_script() ." status");
						print "<font color='green'>" . $radius_status . "</font>"; ?>
						</td>
			</table>
			<br />
			<table border=0 cellpadding="0" cellspacing="0" align="center">
						<td class="text10b" align="center" style="white-space: nowrap; padding-right: 3px;"><? echo $lang['pra_users_status_now']; ?>:</td>
			</table>
			<table border=0 width="100%" cellpadding="0" cellspacing="0" align="center">
					<tr>
						<td width="150" class="text10b" align="center" style="white-space: nowrap; padding-right: 3px;">
						<p align="center"><a href="phpradmin.php?p=3001"><img src="graphuserspie.php" border="0"></a></p>
						</td>
					</tr>
			</table>
			<center>
			<table border=0 cellpadding="0" cellspacing="0" align="center">
						<td class="text10b" align="center" style="white-space: nowrap; padding-right: 3px;"><br /><? echo $lang['pra_user_connections']; ?>:</td>
			</table>
			<table border=0 width="100%" cellpadding="0" cellspacing="0" align="center">
					<tr>
						<td width="150" class="text10b" align="center" style="white-space: nowrap; padding-right: 3px;">
						<p align="center"><a href="phpradmin.php?p=3100"><img src="rrd/users_hour.png" border="0"/></a></p>
						</td>
					</tr>
			</table>
			<table border=0 cellpadding="0" cellspacing="0" align="center">
						<td class="text10b" align="center" style="white-space: nowrap; padding-right: 3px;"><br /><? echo $lang['pra_client_connections']; ?>:</td>
			</table>
			<table border=0 width="100%" cellpadding="0" cellspacing="0" align="center">
					<tr>
						<td width="150" class="text10b" align="center" style="white-space: nowrap; padding-right: 3px;">
						<p align="center"><a href="phpradmin.php?p=3101"><img src="rrd/clients_hour.png" border="0"/></a></p>
						</td>
					</tr>
			</table>
			<table border=0 cellpadding="0" cellspacing="0" align="center">
						<td class="text10b" align="center" style="white-space: nowrap; padding-right: 3px;"><br /><? echo $lang['pra_db_status']; ?>:</td>
			</table>
			<table border=0 width="100%" cellpadding="0" cellspacing="0" align="center">
					<tr>
						<td width="150" class="text10b" align="center" style="white-space: nowrap; padding-right: 3px;">
					    <p align="center"><a href="phpradmin.php?p=3102"><img src="rrd/db_traffic_hour.png" border="0"/></a></p>
						</td>
					</tr>
			</table>
		  </td>
		</tr>
		<tr>
			<td width="100%" align="center" colspan="2">
			<div style="width:720px;">
			  <p><a href="phpradmin.php?p=1"><img src="img/reload.gif" alt="Reload Page" border="0" longdesc="Reload Page" /><br><? echo $lang['pra_auto_reload']; ?></a></p>
			  </div>
			</td>
		</tr> 
	</table>
	