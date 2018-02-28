<?
/*
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)
For information : toni@blyx.com
*/
	if (!isset($oreon))
		exit(); ?>

<table border='0' cellpadding="0" cellspacing="0">
	<tr>
		<td>
			<table cellspacing="0" cellpadding="0"  class="txtlist" width='160'>
				<tr>
				    <td class="tabTableTitle"><? echo $lang['mon_up']; ?></td>
				    <td class="tabTableTitle"><? echo $lang['mon_down']; ?></td>
				    <td class="tabTableTitle"><? echo $lang['mon_unreachable']; ?></td>
				</tr>
				<tr>
					<td class="tabTableWC"<? if ($Logs->host["UP"] != 0) print  " bgcolor='#".$oreon->optGen->get_color_up()."'"; ?>><? print $Logs->host["UP"]; ?></td>
					<td class="tabTableWC"<? if ($Logs->host["DOWN"] != 0) print  " bgcolor='#".$oreon->optGen->get_color_down()."'"; ?>><? print $Logs->host["DOWN"]; ?></td>
					<td class="tabTableWC"<? if ($Logs->host["UNREACHABLE"] != 0 || $Logs->host["UNKNOWN"] != 0 || $Logs->host["PENDING"] != 0) print  " bgcolor='#".$oreon->optGen->get_color_unreachable()."'"; ?>><? print $Logs->host["UNREACHABLE"] + $Logs->host["PENDING"] + $Logs->host["UNKNOWN"] ; ?></td>
				</tr>
				<tr>
					<td height="1" bgcolor="#CCCCCC" colspan="3"></td>
				</tr>
			</table>
		</td>
		<td style="padding-left: 30px;"></td>
		<td>
			<table cellspacing="0" cellpadding="0"  class="txtlist" width='300'>
				<tr>
				    <td class="tabTableTitle"><? echo $lang['mon_ok']; ?></td>
				    <td class="tabTableTitle"><? echo $lang['mon_critical']; ?></td>
				    <td class="tabTableTitle"><? echo $lang['mon_warning']; ?></td>
					<td class="tabTableTitle"><? echo $lang['mon_pending']; ?></td>
				    <td class="tabTableTitle"><? echo $lang['mon_unknown']; ?></td>
				</tr>
				<tr>
					<td class="tabTableWC"<? if ($Logs->sv["OK"] != 0) print  " bgcolor='#".$oreon->optGen->get_color_ok()."'"; ?>><? print $Logs->sv["OK"]; ?></td>
					<td class="tabTableWC"<? if ($Logs->sv["CRITICAL"] != 0) print  " bgcolor='#".$oreon->optGen->get_color_critical()."'"; ?>><? print $Logs->sv["CRITICAL"]; ?></td>
					<td class="tabTableWC"<? if ($Logs->sv["WARNING"] != 0) print  " bgcolor='#".$oreon->optGen->get_color_warning()."'"; ?>><? print $Logs->sv["WARNING"]; ?></td>
					<td class="tabTableWC"<? if ($Logs->sv["PENDING"] != 0) print  " bgcolor='#".$oreon->optGen->get_color_pending()."'"; ?>><? print $Logs->sv["PENDING"]; ?></td>
					<td class="tabTableWC"<? if ($Logs->sv["UNKNOWN"] != 0) print  " bgcolor='#".$oreon->optGen->get_color_unknown()."'"; ?>><? print $Logs->sv["UNKNOWN"]; ?></td>
				</tr>
				<tr>
					<td height="1" bgcolor="#CCCCCC" colspan="5"></td>
				</tr>
			</table>
		</td>
	</tr>
</table>