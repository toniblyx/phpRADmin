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

if (!isset($oreon))
	exit();

function return_dongle_type($page)
{
	if ($page == 1)
		return 1; // home
	else if ($page >= 1000 && $page <= 1999)
		return 2; // users
	else if ($page >= 2000 && $page <= 2999)
		return 3; // clients
	else if ($page >= 3000 && $page <= 3999)
		return 4; // reporting	
	else if ($page >= 4000 && $page <= 4999)
		return 5; // options
	else if ($page >= 5000 && $page <= 5999)
		return 6; // billing
	else 
		return 0;	
		
}

$type = return_dongle_type($_GET['p']);

?>
<style type="text/css">
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
.Estilo15 {color: #D5AD28}
.Estilo16 {color: #F0A650}
</style>

<table width="100%" height="55" border="0" align="center" cellpadding="0" cellspacing="0" background="">
<tr>
	<td height="50" colspan="2">
		<div style="padding-left: 50px;">
		  <p><a href="phpradmin.php?p=1"><img src="img/logo-name.jpg" border="0"></a><br />
          </p>
	    </div>
	</td>
</tr>
</table>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td width='672'>
		<table border="0" cellpadding="0" cellspacing="0" class="txtlist">
			<tr width='672'>
				<td width="25" height="20" background="img/menu_top/fond_haut.gif" class="listprofil">
					<div style="padding:3px 6px">&nbsp;</div>				</td>
				<td width="1" bgcolor="#CCCCCC"></td>
				<td width="1"></td>
				<td width="105" height="20" background="img/menu_top/fond_haut.gif" 
				class="listprofil<? if ($type == 1) print "highlight"; ?>" onmouseout="this.className='listprofil<? if ($type == 1) print "highlight"; ?>'"
				onmouseover="this.className='listresult<? if ($type == 1) print "highlight"; ?>ON'" 
				onclick="document.location.href='phpradmin.php?p=1'">
					<img src="img/menu_top/coin_haut.gif" align="left" hspace="0">
					<div style="padding:3px 6px">&nbsp;<img src="img/sm_home.gif" width="15" height="13" align="absmiddle" /> <? echo $lang['m_home']; ?></div>				</td>
				<td width="1" bgcolor="#CCCCCC"></td>
				<td width="1"></td>
				<td width="105" height="20" background="img/menu_top/fond_haut.gif" 
				<? if ($oreon->user->get_status() != 1) {?>
				class="listprofil<? if ($type == 2) print "highlight"; ?>" onmouseout="this.className='listprofil<? if ($type == 2) print "highlight"; ?>'" 
				onmouseover="this.className='listresult<? if ($type == 2) print "highlight"; ?>ON'" 
				onclick="document.location.href='phpradmin.php?p=1001'"
				<? } else {?>class="listprofillocked" <?}?>>
					<img src="img/menu_top/coin_haut.gif" align="left" hspace="0">
					<div style="padding:3px 6px">&nbsp;<img src="img/sm_users.gif" width="14" height="14" align="absmiddle" /> <? echo $lang['m_users']; ?></div>				</td>
				<td width="1" bgcolor="#CCCCCC"></td>
				<td width="1"></td>
				<td width="106" height="20" background="img/menu_top/fond_haut.gif" 
				class="listprofil<? if ($type == 3) print "highlight"; ?>" onmouseout="this.className='listprofil<? if ($type == 3) print "highlight"; ?>'" 
				onmouseover="this.className='listresult<? if ($type == 3) print "highlight"; ?>ON'"
				onclick="document.location.href='phpradmin.php?p=2001'">
					<img src="img/menu_top/coin_haut.gif" align="left" hspace="0">
					<div style="padding:3px 6px">&nbsp;<img src="img/iconHost.gif" width="14" height="14" align="absmiddle" /> <? echo $lang['m_clients_devices']; ?></div></td>
				<td width="1" bgcolor="#CCCCCC"></td>
				<td width="1"></td>
				<td width="106" height="20" background="img/menu_top/fond_haut.gif"
				class="listprofil<? if ($type == 4) print "highlight"; ?>" onmouseout="this.className='listprofil<? if ($type == 4) print "highlight"; ?>'" 
				onmouseover="this.className='listresult<? if ($type == 4) print "highlight"; ?>ON'"
				onclick="document.location.href='phpradmin.php?p=3001'">
					<img src="img/menu_top/coin_haut.gif" align="left" hspace="0">
					<div style="padding:3px 6px">&nbsp;<img src="img/sm_report.gif" width="14" height="14" align="absmiddle" /> <? echo $lang['m_bbreport']; ?></div>				</td>
				<td width="1" bgcolor="#CCCCCC"></td>
				<td width="1"></td>
				<td width="106" height="20" background="img/menu_top/fond_haut.gif"
				class="listprofil<? if ($type == 5) print "highlight"; ?>" onmouseout="this.className='listprofil<? if ($type == 5) print "highlight"; ?>'" 
				onmouseover="this.className='listresult<? if ($type == 5) print "highlight"; ?>ON'"
				onclick="document.location.href='phpradmin.php?p=4001'">
					<img src="img/menu_top/coin_haut.gif" align="left" hspace="0">
					<div style="padding:3px 6px">&nbsp;<img src="img/iconService.gif" width="14" height="14" align="absmiddle" /> <? echo $lang['m_options']; ?></div>				</td>
				<td width="1" bgcolor="#CCCCCC"></td>
				<td width="1"></td>
				<td width="106" height="20" background="img/menu_top/fond_haut.gif"
				class="listprofil<? if ($type == 6) print "highlight"; ?>" onmouseout="this.className='listprofil<? if ($type == 6) print "highlight"; ?>'" 
				onmouseover="this.className='listresult<? if ($type == 6) print "highlight"; ?>ON'"
				onclick="document.location.href='phpradmin.php?p=5000'">
					<img src="img/menu_top/coin_haut.gif" align="left" hspace="0">
					<div style="padding:3px 6px">&nbsp;<img src="img/sm_billing.gif" width="14" height="14" align="absmiddle" /> <? echo $lang['m_billing']; ?></div>				</td>
				<td width="1" bgcolor="#CCCCCC"></td>				
			</tr>
		</table>
	</td>
	<td style='wight-space:nowrap;text-align:right;'>
		<table border="0" cellpadding="0" cellspacing="0" class="txtlistright" align='right' width='100%'>
			<tr>
				<td width="1"></td>
				<td width="1" bgcolor="#CCCCCC"></td>
				<td height="20" background="img/menu_top/fond_haut.gif" class="listprofilright" onmouseout="this.className='listprofilright'" 
				onmouseover="this.className='listprofilright'" onclick="document.location.href='phpradmin.php?p=1'">
					<div style="padding:3px 6px;text-align:right;white-space:nowrap;">
						<a href="phpradmin.php?p=212" class="toplink"><? print $oreon->user->get_firstname()." ".$oreon->user->get_lastname()." (".$oreon->user->get_alias().")"; ?></a>
						&nbsp;-&nbsp;<font class="toplink"><? print date($lang['header_format']); ?></font>
						&nbsp;-&nbsp;<a href="index.php?disconnect=1" style="padding-right:20px" class="toplink"><? echo $lang['m_logout']; ?></a>
					</div>
				</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td height="1" colspan="2"><img src="img/blank.gif" width="1" height="1" hspace="0"></td>
</tr>
<tr>
	<td height="1" colspan="2" bgcolor="#CCCCCC"><img src="img/blank.gif" width="1" height="1" hspace="0"></td>
</tr>
<tr>
	<td height="4" colspan="2"></td>
</tr>
</table>