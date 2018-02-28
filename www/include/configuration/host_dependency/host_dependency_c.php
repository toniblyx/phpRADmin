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
		<td valign="top" style="white-space: nowrap;" width="50%">Host :<font color='red'>*</font></td>
		<td class="text10b" valign="top" style="white-space: nowrap;">
			<input type='hidden' name='hd[host_host_id]' value='<? echo $hds[$hd_id]->get_host(); ?>'>
			<? echo $hosts[$hds[$hd_id]->get_host()]->get_name(); ?>
		</td>
	</tr>
	<tr>
		<td valign="top" style="white-space: nowrap;">Host dependent :<font color='red'>*</font></td>
		<td class="text10b" valign="top" style="white-space: nowrap;">
			<input type='hidden' name='hd[host_host_id2]' value='<? echo $hds[$hd_id]->get_host_dependent(); ?>'>
			<? echo $hosts[$hds[$hd_id]->get_host_dependent()]->get_name(); ?>
		</td>
	</tr>
	<? if (!strcmp ($oreon->user->get_version(), 1)) { ?>
	<tr>
		<td valign="top" style="white-space: nowrap;">Notification failure criteria<font color='red'>*</font></td>
		<?
		$option_nfc = array();
		if ($hds[$hd_id]->get_notification_failure_criteria())	{
			$tab = split(",", $hds[$hd_id]->get_notification_failure_criteria());
			for ($i = 0; $i != 4; $i++)	{
				if (isset($tab[$i]))
					$option_nfc[$tab[$i]] = $tab[$i];
			}
		}
		?>
		<td class="text10b" valign="top" style="white-space: nowrap;">
			<input ONMOUSEOVER="montre_legende('Ok/UP', '');" ONMOUSEOUT="cache_legende();"  name="hd[hd_notification_failure_criteria_o]" type="checkbox" value="o" <? if (isset($option_nfc["o"]) && strcmp($option_nfc["o"], "")) print "Checked"; if (isset($option_nfc["n"]) && strcmp($option_nfc["n"], "")) print "disabled";?> id="hd_notification_failure_criteria_o"> o -
			<input ONMOUSEOVER="montre_legende('Down', '');" ONMOUSEOUT="cache_legende();" name="hd[hd_notification_failure_criteria_d]" type="checkbox" value="d" <? if (isset($option_nfc["d"]) && strcmp($option_nfc["d"], "")) print "Checked"; if (isset($option_nfc["n"]) && strcmp($option_nfc["n"], "")) print "disabled";?> id="hd_notification_failure_criteria_d"> d -
			<input ONMOUSEOVER="montre_legende('Unreachable', '');" ONMOUSEOUT="cache_legende();" name="hd[hd_notification_failure_criteria_u]" type="checkbox" value="u" <? if (isset($option_nfc["u"]) && strcmp($option_nfc["u"], "")) print "Checked"; if (isset($option_nfc["n"]) && strcmp($option_nfc["n"], "")) print "disabled";?> id="hd_notification_failure_criteria_u"> u -
			<input ONMOUSEOVER="montre_legende('None', '');" ONMOUSEOUT="cache_legende();" name="hd[hd_notification_failure_criteria_n]" type="checkbox" value="n" <? if (isset($option_nfc["n"]) && strcmp($option_nfc["n"], "")) print "Checked";?> onClick="enabledOptionsCheck(hd_notification_failure_criteria_o);enabledOptionsCheck(hd_notification_failure_criteria_d);enabledOptionsCheck(hd_notification_failure_criteria_u);"> n
		</td>
	</tr>
	<? } ?>
	<? if (!strcmp ($oreon->user->get_version(), 2)) { ?>
	<tr>
		<td valign="top" style="white-space: nowrap;">Inherits parent</td>
		<td class="text10b" valign="top" style="white-space: nowrap;">
			<input name="hd[hd_inherits_parent]" type="radio" value="1" <? if ($hds[$hd_id]->get_inherits_parent() == 1) echo "Checked"; ?>> Yes -
			<input name="hd[hd_inherits_parent]" type="radio" value="0" <? if ($hds[$hd_id]->get_inherits_parent() == 0) echo "Checked"; ?>> No -
			<input name="hd[hd_inherits_parent]" type="radio" value="2" <? if ($hds[$hd_id]->get_inherits_parent() == 2) echo "Checked"; ?>> Nothing
		</td>
	</tr>
	<tr>
		<td valign="top" style="white-space: nowrap;">Execution failure criteria</td>
		<?
		$option_efc = array();
		if ($hds[$hd_id]->get_execution_failure_criteria())	{
			$tab = split(",", $hds[$hd_id]->get_execution_failure_criteria());
			for ($i = 0; $i != 4; $i++)	{
				if (isset($tab[$i]))
					$option_efc[$tab[$i]] = $tab[$i];
			}
		}
		?>
		<td class="text10b" valign="top" style="white-space: nowrap;">
			<input ONMOUSEOVER="montre_legende('Ok/UP', '');" ONMOUSEOUT="cache_legende();" name="hd[hd_execution_failure_criteria_o]" type="checkbox" value="o" <? if (isset($option_efc["o"]) && strcmp($option_efc["o"], "")) print "Checked";if (isset($option_efc["n"]) && strcmp($option_efc["n"], "")) print " disabled";?> id="hd_execution_failure_criteria_o"> o -
			<input ONMOUSEOVER="montre_legende('Down', '');" ONMOUSEOUT="cache_legende();" name="hd[hd_execution_failure_criteria_d]" type="checkbox" value="d" <? if (isset($option_efc["d"]) && strcmp($option_efc["d"], "")) print "Checked";if (isset($option_efc["n"]) && strcmp($option_efc["n"], "")) print " disabled";?> id="hd_execution_failure_criteria_d"> d -
			<input ONMOUSEOVER="montre_legende('Unreachable', '');" ONMOUSEOUT="cache_legende();" name="hd[hd_execution_failure_criteria_u]" type="checkbox" value="u" <? if (isset($option_efc["u"]) && strcmp($option_efc["u"], "")) print "Checked";if (isset($option_efc["n"]) && strcmp($option_efc["n"], "")) print " disabled";?> id="hd_execution_failure_criteria_u"> u -
			<input ONMOUSEOVER="montre_legende('None', '');" ONMOUSEOUT="cache_legende();" name="hd[hd_execution_failure_criteria_n]" type="checkbox" value="n" <? if (isset($option_efc["n"]) && strcmp($option_efc["n"], "")) print "Checked";?> onClick=";enabledOptionsCheck(hd_execution_failure_criteria_d);enabledOptionsCheck(hd_execution_failure_criteria_o);enabledOptionsCheck(hd_execution_failure_criteria_u);"> n
		</td>
	</tr>
	<tr>
		<td valign="top" style="white-space: nowrap;">Notification failure criteria</td>
		<?
		$option_nfc = array();
		if ($hds[$hd_id]->get_notification_failure_criteria())	{
			$tab = split(",", $hds[$hd_id]->get_notification_failure_criteria());
			for ($i = 0; $i != 4; $i++)	{
				if (isset($tab[$i]))
					$option_nfc[$tab[$i]] = $tab[$i];
			}
		}
		?>
		<td class="text10b" valign="top" style="white-space: nowrap;">
			<input ONMOUSEOVER="montre_legende('Ok/UP', '');" ONMOUSEOUT="cache_legende();" name="hd[hd_notification_failure_criteria_o]" type="checkbox" value="o" <? if (isset($option_nfc["o"]) && strcmp($option_nfc["o"], "")) print "Checked";if (isset($option_nfc["n"]) && strcmp($option_nfc["n"], "")) print " disabled"; ?> id="hd_notification_failure_criteria_o"> o -
			<input ONMOUSEOVER="montre_legende('Down', '');" ONMOUSEOUT="cache_legende();" name="hd[hd_notification_failure_criteria_d]" type="checkbox" value="d" <? if (isset($option_nfc["d"]) && strcmp($option_nfc["d"], "")) print "Checked";if (isset($option_nfc["n"]) && strcmp($option_nfc["n"], "")) print " disabled";?> id="hd_notification_failure_criteria_d"> d -
			<input ONMOUSEOVER="montre_legende('Unreachable', '');" ONMOUSEOUT="cache_legende();" name="hd[hd_notification_failure_criteria_u]" type="checkbox" value="u" <? if (isset($option_nfc["u"]) && strcmp($option_nfc["u"], "")) print "Checked";if (isset($option_nfc["n"]) && strcmp($option_nfc["n"], "")) print " disabled";?> id="hd_notification_failure_criteria_u"> u -
			<input ONMOUSEOVER="montre_legende('None', '');" ONMOUSEOUT="cache_legende();" name="hd[hd_notification_failure_criteria_n]" type="checkbox" value="n" <? if (isset($option_nfc["n"]) && strcmp($option_nfc["n"], "")) print "Checked";?> onClick="enabledOptionsCheck(hd_notification_failure_criteria_o);enabledOptionsCheck(hd_notification_failure_criteria_d);enabledOptionsCheck(hd_notification_failure_criteria_u);"> n
		</td>
	</tr>
	<? } ?>
	<tr>
		<td align="left">
			<? echo $lang['required']; ?>&nbsp;&nbsp;
		</td>
		<td align="center">
			<input type="hidden" name="hd[hd_id]" value="<? echo $hd_id ?>">
			<input type="submit" name="ChangeHD" value="<? echo $lang['save']; ?>">
		</td>
	</tr>
</table>
</form>