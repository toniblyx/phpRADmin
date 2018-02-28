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
if ($p >= 1000 && $p <= 1999) { // Users menu	?>
<tr>
	<td valign="top" align="left" width="100%" colspan="2">
		<table border='0' width='' align="left" cellpadding="0" cellspacing="0">
			<tr>
				<? if ($oreon->user->get_status() != 1) { ?>
				<td valign="top" width="8%">
				<div style="display: yes;" id="leftCol1">
				<table cellspacing="0" cellpadding="0" border="0" width="160" class="txtlist">
					<tr>
						<td width="100%" height="1" class="tabTable"><img src="img/blank.gif" width="1" height="1" alt=""></td>
					</tr>
					<tr>
					    <td class="tabTableTitle" onmouseout="this.className='tabTableTitle'"
									onmouseover="this.className='tabTableTitleON'"><? echo $lang['da_users']; ?>
						</td>
					</tr>
					<tr>
					    <td class="tabTable" onclick="document.location.href='phpradmin.php?p=1001'" onmouseout="this.className='tabTable'"
									onmouseover="this.className='tabTableON'"><a href='phpradmin.php?p=1001' class='txtlistleft'><? echo $lang['da_adduser']; ?></a>
						</td>
					</tr>
					<tr>
					    <td class="tabTable" onclick="document.location.href='phpradmin.php?p=1002'" onmouseout="this.className='tabTable'"
									onmouseover="this.className='tabTableON'"><a href='phpradmin.php?p=1002' class='txtlistleft'><? echo $lang['da_findedit']; ?></a>
						</td>
					</tr>
					<tr>
					    <td class="tabTable" onclick="document.location.href='phpradmin.php?p=1003'" onmouseout="this.className='tabTable'"
									onmouseover="this.className='tabTableON'"><a href='phpradmin.php?p=1003' class='txtlistleft'><? echo $lang['da_failedlogins']; ?></a>
						</td>
					</tr>
					<tr>
					    <td class="tabTable" onclick="document.location.href='phpradmin.php?p=1004'" onmouseout="this.className='tabTable'"
									onmouseover="this.className='tabTableON'"><a href='phpradmin.php?p=1004' class='txtlistleft'><? echo $lang['da_badusers']; ?></a>
						</td>
					</tr>				
					<TR>
						<td height="1" bgcolor="#CCCCCC"></td>
					</TR>
					<tr>
						<td width="100%" height="5"><img src="img/blank.gif" width="1" height="1" alt=""></td>
					</tr>
					<tr>
					    <td class="tabTableTitle" onmouseout="this.className='tabTableTitle'"
									onmouseover="this.className='tabTableTitleON'"><? echo $lang['da_groups']; ?>
						</td>
					</tr>
					<tr>
					    <td class="tabTable" onclick="document.location.href='phpradmin.php?p=1101'" onmouseout="this.className='tabTable'"
									onmouseover="this.className='tabTableON'"><div><a href='phpradmin.php?p=1101' class='txtlistleft'><? echo $lang['da_addgroup']; ?></a></div>
						</td>
					</tr>
					<tr>
					    <td class="tabTable" onclick="document.location.href='phpradmin.php?p=1102'" onmouseout="this.className='tabTable'"
									onmouseover="this.className='tabTableON'"><a href='phpradmin.php?p=1102' class='txtlistleft'><? echo $lang['da_editgroup']; ?></a>
						</td>
					</tr>
					<TR>
						<td height="1" bgcolor="#CCCCCC"></td>
					</TR>
					<tr>
						<td width="100%" height="5"><img src="img/blank.gif" width="1" height="1" alt=""></td>
					</tr>
					<tr>
					    <td class="tabTableTitle" onmouseout="this.className='tabTableTitle'"
									onmouseover="this.className='tabTableTitleON'"><? echo $lang['pra_certs']; ?>
						</td>
					</tr>
					<tr>
					    <td class="tabTable" onclick="document.location.href='phpradmin.php?p=1006'" onmouseout="this.className='tabTable'"
									onmouseover="this.className='tabTableON'"><div><a href='phpradmin.php?p=1006' class='txtlistleft'>Request a New Certificate</a></div>
						</td>
					</tr>
					<tr>
					    <td class="tabTable" onclick="document.location.href='phpradmin.php?p=1007'" onmouseout="this.className='tabTable'"
									onmouseover="this.className='tabTableON'"><a href='phpradmin.php?p=1007' class='txtlistleft'>Manage Certificates</a>
						</td>
					</tr>
					<tr>
					    <td class="tabTable" onclick="document.location.href='phpradmin.php?p=1008'" onmouseout="this.className='tabTable'"
									onmouseover="this.className='tabTableON'"><a href='phpradmin.php?p=1008' class='txtlistleft'>Update the Certificate Revocation List</a>
						</td>
					</tr>
					<tr>
					    <td class="tabTable" onclick="document.location.href='phpradmin.php?p=1009'" onmouseout="this.className='tabTable'"
									onmouseover="this.className='tabTableON'"><a href='phpradmin.php?p=1009' class='txtlistleft'>Download the CA Root Certificate</a>
						</td>
					</tr>
					<tr>
					    <td class="tabTable" onclick="document.location.href='phpradmin.php?p=1012'" onmouseout="this.className='tabTable'"
									onmouseover="this.className='tabTableON'"><a href='phpradmin.php?p=1012' class='txtlistleft'>Show the CA Root Certificate</a>
						</td>
					</tr>
					<tr>
					    <td class="tabTable" onclick="document.location.href='phpradmin.php?p=1010'" onmouseout="this.className='tabTable'"
									onmouseover="this.className='tabTableON'"><a href='phpradmin.php?p=1010' class='txtlistleft'>Download the Certificate Revocation List</a>
						</td>
					</tr>
					<tr>
					    <td class="tabTable" onclick="document.location.href='phpradmin.php?p=1013'" onmouseout="this.className='tabTable'"
									onmouseover="this.className='tabTableON'"><a href='phpradmin.php?p=1013' class='txtlistleft'>Show the Certificate Revocation List</a>
						</td>
					</tr>
					<tr>
					    <td class="tabTable" onclick="document.location.href='phpradmin.php?p=1011'" onmouseout="this.className='tabTable'"
									onmouseover="this.className='tabTableON'"><a href='phpradmin.php?p=1011' class='txtlistleft'>Help about Certificates</a>
						</td>
					</tr>					
					<TR>
						<td height="1" bgcolor="#CCCCCC"></td>
					</TR>
				</table>	
				</div>
				</td>
				<? } ?>
<? } else if ($p >= 2000 && $p <= 2999){ // Clients menu	?>
<tr>
	<td valign="top" align="left" width="100%" colspan="2">
		<table border='0' width='' align="left" cellpadding="0" cellspacing="0">
			<tr>
				<? if ($oreon->user->get_status() != 1) { ?>
				<td valign="top" width="8%">
				<div style="display: yes;" id="leftCol3">
				<table cellspacing="0" cellpadding="0" border="0" width="160" class="txtlist">
					<tr>
						<td width="100%" height="1" class="tabTable"><img src="img/blank.gif" width="1" height="1" alt=""></td>
					</tr>
					<tr>
					    <td class="tabTableTitle" onmouseout="this.className='tabTableTitle'" 
									onmouseover="this.className='tabTableTitleON'">Clients
						</td>
					</tr>	
					<tr>
					    <td class="tabTable" onclick="document.location.href='phpradmin.php?p=2001'" onmouseout="this.className='tabTable'" 
									onmouseover="this.className='tabTableON'"><a href='phpradmin.php?p=2001' class='txtlistleft'>Manage</a>
						</td>
					</tr>
					<tr>
					    <td class="tabTable" onclick="document.location.href='phpradmin.php?p=4008'" onmouseout="this.className='tabTable'" 
									onmouseover="this.className='tabTableON'"><a href='phpradmin.php?p=4008' class='txtlistleft'>Apply</a>
						</td>
					</tr>
					<TR>
						<td height="1" bgcolor="#CCCCCC"></td>
					</TR>
					<tr>
						<td width="100%" height="5"><img src="img/blank.gif" width="1" height="1" alt=""></td>
					</tr>
					</table>
					</div>
				</td>
				<? } ?>
<? } else if ($p >= 3000 && $p <= 3999)	{ // Reporting Menu ?>
<tr>
	<td valign="top" align="left" width="100%" colspan="2">
		<table border='0' width='' align="left" cellpadding="0" cellspacing="0">
			<tr>
				<? if ($oreon->user->get_status() != 1) { ?>
				<td valign="top" width="8%">
				<div style="display: yes;" id="leftCol5">
				<table cellspacing="0" cellpadding="0" border="0" width="160" class="txtlist">
					<tr>
						<td width="100%" height="1" class="tabTable"><img src="img/blank.gif" width="1" height="1" alt=""></td>
					</tr>
					<tr>
					    <td class="tabTableTitle" onmouseout="this.className='tabTableTitle'" 
									onmouseover="this.className='tabTableTitleON'"><? echo $lang["bbreporting"]; ?>
						</td>
					</tr>
					<tr>
					    <td class="tabTable" onclick="document.location.href='phpradmin.php?p=3001'" onmouseout="this.className='tabTable'"
									onmouseover="this.className='tabTableON'"><a href='phpradmin.php?p=3001' class='txtlistleft'>Online users</a>
						</td>
					</tr>
					<tr>
					    <td class="tabTable" onclick="document.location.href='phpradmin.php?p=3002'" onmouseout="this.className='tabTable'" 
									onmouseover="this.className='tabTableON'"><a href='phpradmin.php?p=3002' class='txtlistleft'>Accounting</a>
						</td>
					</tr>
					<tr>
					    <td class="tabTable" onclick="document.location.href='phpradmin.php?p=3003'" onmouseout="this.className='tabTable'" 
									onmouseover="this.className='tabTableON'"><a href='phpradmin.php?p=3003' class='txtlistleft'>Global Stats</a>
						</td>
					</tr>
					<tr>
					    <td class="tabTable" onclick="document.location.href='phpradmin.php?p=3004'" onmouseout="this.className='tabTable'" 
									onmouseover="this.className='tabTableON'"><a href='phpradmin.php?p=3004' class='txtlistleft'>User Stats</a>
						</td>
					</tr>
					<TR>
						<td height="1" bgcolor="#CCCCCC"></td>
					</TR>
				</table>
				<br>
				<table cellspacing="0" cellpadding="0" border="0" width="160" class="txtlist">
					<tr>
						<td width="100%" height="1" class="tabTable"><img src="img/blank.gif" width="1" height="1" alt=""></td>
					</tr>
					<tr>
					    <td class="tabTableTitle" onmouseout="this.className='tabTableTitle'" 
									onmouseover="this.className='tabTableTitleON'">Graphs
						</td>
					</tr>
					<tr>
					    <td class="tabTable" onclick="document.location.href='phpradmin.php?p=3100'" onmouseout="this.className='tabTable'" 
									onmouseover="this.className='tabTableON'"><a href='phpradmin.php?p=3100' class='txtlistleft'>User graphs</a>
						</td>
					</tr>
					<tr>
					    <td class="tabTable" onclick="document.location.href='phpradmin.php?p=3101'" onmouseout="this.className='tabTable'" 
									onmouseover="this.className='tabTableON'"><a href='phpradmin.php?p=3101' class='txtlistleft'>Client graphs</a>
						</td>
					</tr>
					<tr>
					    <td class="tabTable" onclick="document.location.href='phpradmin.php?p=3102'" onmouseout="this.className='tabTable'" 
									onmouseover="this.className='tabTableON'"><a href='phpradmin.php?p=3102' class='txtlistleft'>DB graphs</a>
						</td>
					</tr>
					<TR>
						<td height="1" bgcolor="#CCCCCC"></td>
					</TR>
				</table>
				<br>
				<table cellspacing="0" cellpadding="0" border="0" width="160" class="txtlist">
					<tr>
						<td width="100%" height="1" class="tabTable"><img src="img/blank.gif" width="1" height="1" alt=""></td>
					</tr>
					<tr>
					    <td class="tabTableTitle" onmouseout="this.className='tabTableTitle'" 
									onmouseover="this.className='tabTableTitleON'">Logs
						</td>
					</tr>
					<tr>
					    <td class="tabTable" onclick="document.location.href='phpradmin.php?p=3200'" onmouseout="this.className='tabTable'" 
									onmouseover="this.className='tabTableON'"><a href='phpradmin.php?p=3200' class='txtlistleft'>RADIUS logs</a>
						</td>
					</tr>
					<tr>
					    <td class="tabTable" onclick="document.location.href='phpradmin.php?p=3201'" onmouseout="this.className='tabTable'" 
									onmouseover="this.className='tabTableON'"><a href='phpradmin.php?p=3201' class='txtlistleft'>System logs</a>
						</td>
					</tr>
					<TR>
						<td height="1" bgcolor="#CCCCCC"></td>
					</TR>
				</table>
				</div>
				</td>
				<? } ?>
<? }	else if ($p >= 4000 && $p <= 4999)	{ // Options menu	?>
<tr>
	<td valign="top" align="left" width="100%" colspan="2">
		<table border='0' width='' align="left" cellpadding="0" cellspacing="0">
			<tr>
				<? if ($oreon->user->get_status() != 1) { ?>
				<td valign="top" width="8%">
				<div style="display: yes;" id="leftCol2">
				<table cellspacing="0" cellpadding="0" border="0" width="160" class="txtlist">
					<tr>
						<td width="100%" height="1" class="tabTable"><img src="img/blank.gif" width="1" height="1" alt=""></td>
					</tr>
					<tr>
					    <td class="tabTableTitle" onmouseout="this.className='tabTableTitle'" 
									onmouseover="this.className='tabTableTitleON'"><? echo $lang['m_configuration']; ?>
						</td>
					</tr>
					<tr>
					    <td class="tabTable" onclick="document.location.href='phpradmin.php?p=4001'" onmouseout="this.className='tabTable'" 
									onmouseover="this.className='tabTableON'"><a href='phpradmin.php?p=4001' class='txtlistleft'><? echo $lang['m_general']; ?></a>
						</td>
					</tr>
					<tr>
					    <td class="tabTable" onclick="document.location.href='phpradmin.php?p=4002'" onmouseout="this.className='tabTable'" 
									onmouseover="this.className='tabTableON'"><a href='phpradmin.php?p=4002' class='txtlistleft'><? echo $lang['m_lang']; ?></a>
						</td>
					</tr>
					<tr>
					    <td class="tabTable" onclick="document.location.href='phpradmin.php?p=4004'" onmouseout="this.className='tabTable'" 
									onmouseover="this.className='tabTableON'"><a href='phpradmin.php?p=4004' class='txtlistleft'><? echo "Radius Server"; ?></a>
						</td>
					</tr>
					<tr>
					    <td class="tabTable" onclick="document.location.href='phpradmin.php?p=4004'" onmouseout="this.className='tabTable'" 
									onmouseover="this.className='tabTableON'">&nbsp;&nbsp;&nbsp;&nbsp;<img src="img/picto2.gif">&nbsp;<a href='phpradmin.php?p=4004' class='txtlistleft'>Edit files</a>
						</td>
					</tr>
					<tr>
					    <td class="tabTable" onclick="document.location.href='phpradmin.php?p=4005'" onmouseout="this.className='tabTable'" 
									onmouseover="this.className='tabTableON'"><a href='phpradmin.php?p=4005' class='txtlistleft'>Dialup
					        Admin </a>
						</td>
					</tr>
					<tr>
					    <td class="tabTable" onclick="document.location.href='phpradmin.php?p=4006'" onmouseout="this.className='tabTable'" 
									onmouseover="this.className='tabTableON'">&nbsp;&nbsp;&nbsp;&nbsp;<img src="img/picto2.gif">&nbsp;<a href='phpradmin.php?p=4006' class='txtlistleft'>Edit files</a>
						</td>
					</tr>
					<tr>
					    <td class="tabTable" onclick="document.location.href='phpradmin.php?p=4007'" onmouseout="this.className='tabTable'" 
									onmouseover="this.className='tabTableON'"><a href='phpradmin.php?p=4007' class='txtlistleft'>Dictionary</a>
						</td>
					</tr>
					<tr>
					    <td class="tabTable" onclick="document.location.href='phpradmin.php?p=4008'" onmouseout="this.className='tabTable'" 
									onmouseover="this.className='tabTableON'"><a href='phpradmin.php?p=4008' class='txtlistleft'><strong>Apply -&gt; Lock/Unlock</strong></a>
						</td>
					</tr>
					<TR>
						<td height="1" bgcolor="#CCCCCC"></td>
					</TR>
					<tr>
						<td width="100%" height="5"><img src="img/blank.gif" width="1" height="1" alt=""></td>
					</tr>
					<tr>
					    <td class="tabTableTitle" onmouseout="this.className='tabTableTitle'"
									onmouseover="this.className='tabTableTitleON'"><? echo $lang['m_application_users']; ?></a>
						</td>
					</tr>
					<tr>
					    <td class="tabTable" onclick="document.location.href='phpradmin.php?p=4100'" onmouseout="this.className='tabTable'" 
									onmouseover="this.className='tabTableON'"><a href='phpradmin.php?p=4100' class='txtlistleft'><? echo $lang['m_is_connected']; ?></a>
						</td>
					</tr>
					<tr>
					    <td class="tabTable" onclick="document.location.href='phpradmin.php?p=4101'" onmouseout="this.className='tabTable'" 
									onmouseover="this.className='tabTableON'"><a href='phpradmin.php?p=4101' class='txtlistleft'><? echo $lang['m_profile']; ?></a>
						</td>
					</tr>
					<tr>
					    <td class="tabTable" onclick="document.location.href='phpradmin.php?p=4102'" onmouseout="this.className='tabTable'" 
									onmouseover="this.className='tabTableON'"><a href='phpradmin.php?p=4102' class='txtlistleft'><? echo $lang['m_users_profile']; ?></a>
						</td>
					</tr>
					<tr>
					    <td class="tabTable" onclick="document.location.href='phpradmin.php?p=4102&o=a'" onmouseout="this.className='tabTable'" 
									onmouseover="this.className='tabTableON'">&nbsp;&nbsp;&nbsp;&nbsp;<img src="img/picto2.gif">&nbsp;<a href='phpradmin.php?p=4102&o=a' class='txtlistleft'><? echo $lang['add']; ?></a>
						</td>
					</tr>
					<TR>
						<td height="1" bgcolor="#CCCCCC"></td>
					</TR>
					<tr>
						<td width="100%" height="5"><img src="img/blank.gif" width="1" height="1" alt=""></td>
					</tr>
					<tr>
					    <td class="tabTableTitle" onmouseout="this.className='tabTableTitle'"
									onmouseover="this.className='tabTableTitleON'"><? echo $lang['m_tools']; ?></a>
						</td>
					</tr>
					<tr>
					    <td class="tabTable" onclick="document.location.href='phpradmin.php?p=4200'" onmouseout="this.className='tabTable'" 
									onmouseover="this.className='tabTableON'"><a href='phpradmin.php?p=4200' class='txtlistleft'><? echo $lang['m_histo']; ?></a>
						</td>
					</tr>
					<tr>
					    <td class="tabTable" onclick="document.location.href='phpradmin.php?p=4201'" onmouseout="this.className='tabTable'" 
									onmouseover="this.className='tabTableON'"><a href='phpradmin.php?p=4201' class='txtlistleft'><? echo $lang['m_backup_db']; ?></a>
						</td>
					</tr>
					<tr>
					    <td class="tabTable" onclick="document.location.href='phpradmin.php?p=4202'" onmouseout="this.className='tabTable'" 
									onmouseover="this.className='tabTableON'"><a href='phpradmin.php?p=4202' class='txtlistleft'><? echo $lang['m_server_status']; ?></a>
						</td>
					</tr>
					<tr>
					    <td class="tabTable" onclick="document.location.href='phpradmin.php?p=4203'" onmouseout="this.className='tabTable'" 
									onmouseover="this.className='tabTableON'"><a href='phpradmin.php?p=4203' class='txtlistleft'><? echo $lang['m_updates']; ?></a>
						</td>
					</tr>
					<tr>
					    <td class="tabTable" onclick="document.location.href='phpradmin.php?p=4204'" onmouseout="this.className='tabTable'" 
									onmouseover="this.className='tabTableON'"><a href='phpradmin.php?p=4204' class='txtlistleft'><? echo $lang['m_about']; ?></a>
						</td>
					</tr>
					<TR>
						<td height="1" bgcolor="#CCCCCC"></td>
					</TR>
					<tr>
						<td width="100%" height="5"><img src="img/blank.gif" width="1" height="1" alt=""></td>
					</tr>
				</table>
				</div>
				</td>
				<? } ?>
<? } else if ($p >= 5000 && $p <= 5999){ // Billing menu	?>
<tr>
	<td valign="top" align="left" width="100%" colspan="2">
		<table border='0' width='' align="left" cellpadding="0" cellspacing="0">
			<tr>
				<? if ($oreon->user->get_status() != 1) { ?>
				<td valign="top" width="8%">
				<div style="display: yes;" id="leftCol3">
				<table cellspacing="0" cellpadding="0" border="0" width="160" class="txtlist">
					<tr>
						<td width="100%" height="1" class="tabTable"><img src="img/blank.gif" width="1" height="1" alt=""></td>
					</tr>
					<tr>
					    <td class="tabTableTitle" onmouseout="this.className='tabTableTitle'" 
									onmouseover="this.className='tabTableTitleON'">Billing
						</td>
					</tr>	
					<tr>
					    <td class="tabTable" onclick="document.location.href='phpradmin.php?p=5000'" onmouseout="this.className='tabTable'" 
									onmouseover="this.className='tabTableON'"><a href='phpradmin.php?p=5000' class='txtlistleft'>General</a>
						</td>
					</tr>
					<TR>
						<td height="1" bgcolor="#CCCCCC"></td>
					</TR>
					<tr>
						<td width="100%" height="5"><img src="img/blank.gif" width="1" height="1" alt=""></td>
					</tr>
				</table>
				</div>
				</td>
				<? } ?>	
<? } else {	?><tr>
	<td valign="top" width="100%" colspan="2" align="center">
		<table border='0'>
			<tr>
<? } ?>