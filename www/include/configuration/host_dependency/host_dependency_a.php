<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/?>
<form action="" method="post">
<table cellpadding="0" cellspacing="3" width="350" align='center'>
	<tr>
		<td valign="top" style="white-space: nowrap;" width="50%"><? echo $lang['h']; ?><font color='red'>*</font></td>
		<td class="text10b" valign="top">
			<select name="hd[host_host_id]">
				<?
				foreach ($hosts as $host)	{
					if ($host->get_register())
						echo "<option value='".$host->get_id()."'>".$host->get_name()."</option>";
					unset($host);
				}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td valign="top" style="white-space: nowrap;"><? echo $lang['h']; ?> dependent<font color='red'>*</font></td>
		<td class="text10b" valign="top">
			<select name="hd[host_host_id2]">
				<?
				foreach ($hosts as $host)	{
					if ($host->get_register())
						echo "<option value='".$host->get_id()."'>".$host->get_name()."</option>";
					unset($host);
				}
				?>
			</select>
		</td>
	</tr>
	<? if (!strcmp ($oreon->user->get_version(), 1)) { ?>
	<tr>
		<td valign="top" style="white-space: nowrap;">Notification failure criteria<font color='red'>*</font></td>
		<td class="text10b" valign="top" style="white-space: nowrap;">
			<input ONMOUSEOVER="montre_legende('Ok/UP', '');" ONMOUSEOUT="cache_legende();" name="hd[hd_notification_failure_criteria_o]" type="checkbox" value="o" id="hd_notification_failure_criteria_o"> o -
			<input ONMOUSEOVER="montre_legende('Down', '');" ONMOUSEOUT="cache_legende();" name="hd[hd_notification_failure_criteria_d]" type="checkbox" value="d" id="hd_notification_failure_criteria_d"> d -
			<input ONMOUSEOVER="montre_legende('Unreachable', '');" ONMOUSEOUT="cache_legende();" name="hd[hd_notification_failure_criteria_u]" type="checkbox" value="u" id="hd_notification_failure_criteria_u"> u -
			<input ONMOUSEOVER="montre_legende('None', '');" ONMOUSEOUT="cache_legende();" name="hd[hd_notification_failure_criteria_n]" type="checkbox" value="n" onClick="enabledOptionsCheck(hd_notification_failure_criteria_o);enabledOptionsCheck(hd_notification_failure_criteria_d);enabledOptionsCheck(hd_notification_failure_criteria_u);"> n
		</td>
	</tr>
	<? } ?>
	<? if (!strcmp ($oreon->user->get_version(), 2)) { ?>
	<tr>
		<td valign="top" style="white-space: nowrap;">Inherits parent</td>
		<td class="text10b" valign="top" style="white-space: nowrap;">
			<input name="hd[hd_inherits_parent]" type="radio" value="1"> Yes -
			<input name="hd[hd_inherits_parent]" type="radio" value="0"> No -
			<input name="hd[hd_inherits_parent]" type="radio" value="2" checked> Nothing
		</td>
	</tr>
	<tr>
		<td valign="top" style="white-space: nowrap;">Execution failure criteria</td>
		<td class="text10b" valign="top" style="white-space: nowrap;">
			<input ONMOUSEOVER="montre_legende('Ok/UP', '');" ONMOUSEOUT="cache_legende();" name="hd[hd_execution_failure_criteria_o]" type="checkbox" value="o" id="hd_execution_failure_criteria_o"> o -
			<input ONMOUSEOVER="montre_legende('Down', '');" ONMOUSEOUT="cache_legende();" name="hd[hd_execution_failure_criteria_d]" type="checkbox" value="d" id="hd_execution_failure_criteria_d"> d -
			<input ONMOUSEOVER="montre_legende('Unreachable', '');" ONMOUSEOUT="cache_legende();" name="hd[hd_execution_failure_criteria_u]" type="checkbox" value="u" id="hd_execution_failure_criteria_u"> u -
			<input ONMOUSEOVER="montre_legende('None', '');" ONMOUSEOUT="cache_legende();" name="hd[hd_execution_failure_criteria_n]" type="checkbox" value="n" onClick="enabledOptionsCheck(hd_execution_failure_criteria_o);enabledOptionsCheck(hd_execution_failure_criteria_d);enabledOptionsCheck(hd_execution_failure_criteria_u);"> n
		</td>
	</tr>
	<tr>
		<td valign="top" style="white-space: nowrap;">Notification failure criteria</td>
		<td class="text10b" valign="top" style="white-space: nowrap;">
			<input ONMOUSEOVER="montre_legende('Ok/UP', '');" ONMOUSEOUT="cache_legende();" name="hd[hd_notification_failure_criteria_o]" type="checkbox" value="o" id="hd_notification_failure_criteria_o"> o -
			<input ONMOUSEOVER="montre_legende('Down', '');" ONMOUSEOUT="cache_legende();" name="hd[hd_notification_failure_criteria_d]" type="checkbox" value="d" id="hd_notification_failure_criteria_d"> d -
			<input ONMOUSEOVER="montre_legende('Unreachable', '');" ONMOUSEOUT="cache_legende();" name="hd[hd_notification_failure_criteria_u]" type="checkbox" value="u" id="hd_notification_failure_criteria_u"> u -
			<input ONMOUSEOVER="montre_legende('None', '');" ONMOUSEOUT="cache_legende();" name="hd[hd_notification_failure_criteria_n]" type="checkbox" value="n" onClick="enabledOptionsCheck(hd_notification_failure_criteria_o);enabledOptionsCheck(hd_notification_failure_criteria_d);enabledOptionsCheck(hd_notification_failure_criteria_u);"> n
		</td>
	</tr>
	<? } ?>
	<tr>
		<td align="left">
			<? echo $lang['required']; ?>&nbsp;&nbsp;
		</td>
		<td align="center">
			<input type="submit" name="AddHD" value="<? echo $lang['save']; ?>">
		</td>
	</tr>
</table>
</form>