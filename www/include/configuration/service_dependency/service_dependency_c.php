<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/?>
<form action="" method="post">
<table border="0" cellpadding="3" cellspacing="3">
	<tr>
		<td valign="top" nowrap><? echo $lang['h']; ?><font color='red'>*</font></td>
		<td class="text10b" valign="top">
			<input type='hidden' name='sd[host_host_id]' value='<? echo $sds[$sd_id]->get_host(); ?>'>
			<? echo $hosts[$sds[$sd_id]->get_host()]->get_name(); ?>
		</td>
	</tr>
	<tr>
		<td valign="top" nowrap><? echo $lang['s']; ?><font color='red'>*</font></td>
		<td class="text10b" valign="top">
			<input type='hidden' name='sd[service_service_id]' value='<? echo $sds[$sd_id]->get_service(); ?>'>
			<? echo $services[$sds[$sd_id]->get_service()]->get_description(); ?>
		</td>
	</tr>
	<tr>
		<td valign="top" nowrap><? echo $lang['h']; ?> dependent<font color='red'>*</font></td>
		<td class="text10b" valign="top">
			<input type='hidden' name='sd[host_host_id2]' value='<? echo $sds[$sd_id]->get_host_dependent(); ?>'>
			<? echo $hosts[$sds[$sd_id]->get_host_dependent()]->get_name(); ?>
		</td>
	</tr>
	<tr>
		<td valign="top" nowrap><? echo $lang['s']; ?> dependent<font color='red'>*</font></td>
		<td class="text10b" valign="top">
			<input type='hidden' name='sd[service_service_id2]' value='<? echo $sds[$sd_id]->get_service_dependent(); ?>'>
			<? echo $services[$sds[$sd_id]->get_service_dependent()]->get_description(); ?>
		</td>
	</tr>
	<? if (!strcmp ($oreon->user->get_version(), 2)) { ?>
	<tr>
		<td valign="top" nowrap>Inherits parent</td>
		<td class="text10b" valign="top" nowrap>
			<input name="sd[sd_inherits_parent]" type="radio" value="1" <? if ($sds[$sd_id]->get_inherits_parent() == 1) echo "Checked"; ?>> Yes -
			<input name="sd[sd_inherits_parent]" type="radio" value="0" <? if ($sds[$sd_id]->get_inherits_parent() == 0) echo "Checked"; ?>> No -
			<input name="sd[sd_inherits_parent]" type="radio" value="2" <? if ($sds[$sd_id]->get_inherits_parent() == 2) echo "Checked"; ?>> Nothing
		</td>
	</tr>
	<? } ?>
	<tr>
		<td valign="top" nowrap>Execution failure criteria</td>
		<?
		$option_efc = array();
		if ($sds[$sd_id]->get_execution_failure_criteria())	{
			$tab = split(",", stripslashes($sds[$sd_id]->get_execution_failure_criteria()));
			for ($i = 0; $i != 5; $i++)	{
				if (isset($tab[$i]))
					$option_efc[$tab[$i]] = $tab[$i];
			}
		}
		?>
		<td class="text10b" valign="top" nowrap>
			<input ONMOUSEOVER="montre_legende('OK', '');" ONMOUSEOUT="cache_legende();" name="sd[sd_execution_failure_criteria_o]" type="checkbox" value="o" <? if (isset($option_efc["o"]) && strcmp($option_efc["o"], "")) print "Checked"; if (isset($option_efc["n"]) && strcmp($option_efc["n"], "")) print " disabled";?> id="sd_execution_failure_criteria_o"> o -
			<input ONMOUSEOVER="montre_legende('Warning', '');" ONMOUSEOUT="cache_legende();" name="sd[sd_execution_failure_criteria_w]" type="checkbox" value="w" <? if (isset($option_efc["w"]) && strcmp($option_efc["w"], "")) print "Checked"; if (isset($option_efc["n"]) && strcmp($option_efc["n"], "")) print " disabled";?> id="sd_execution_failure_criteria_w"> w -
			<input ONMOUSEOVER="montre_legende('Unknown', '');" ONMOUSEOUT="cache_legende();" name="sd[sd_execution_failure_criteria_u]" type="checkbox" value="u" <? if (isset($option_efc["u"]) && strcmp($option_efc["u"], "")) print "Checked"; if (isset($option_efc["n"]) && strcmp($option_efc["n"], "")) print " disabled";?> id="sd_execution_failure_criteria_u"> u -
			<input ONMOUSEOVER="montre_legende('Critical', '');" ONMOUSEOUT="cache_legende();" name="sd[sd_execution_failure_criteria_c]" type="checkbox" value="c" <? if (isset($option_efc["c"]) && strcmp($option_efc["c"], "")) print "Checked"; if (isset($option_efc["n"]) && strcmp($option_efc["n"], "")) print " disabled";?> id="sd_execution_failure_criteria_c"> c -
			<input ONMOUSEOVER="montre_legende('None', '');" ONMOUSEOUT="cache_legende();" name="sd[sd_execution_failure_criteria_n]" type="checkbox" value="n" <? if (isset($option_efc["n"]) && strcmp($option_efc["n"], "")) print "Checked";?> onClick="enabledOptionsCheck(sd_execution_failure_criteria_o);enabledOptionsCheck(sd_execution_failure_criteria_w);enabledOptionsCheck(sd_execution_failure_criteria_u);enabledOptionsCheck(sd_execution_failure_criteria_c);"> n
		</td>
	</tr>
	<tr>
		<td valign="top" nowrap>Notification failure criteria</td>
		<?
		$option_nfc = array();
		if ($sds[$sd_id]->get_notification_failure_criteria())	{
			$tab = split(",", stripslashes($sds[$sd_id]->get_notification_failure_criteria()));
			for ($i = 0; $i != 5; $i++)	{
				if (isset($tab[$i]))
					$option_nfc[$tab[$i]] = $tab[$i];
			}
		}
		?>
		<td class="text10b" valign="top" nowrap>
			<input ONMOUSEOVER="montre_legende('OK', '');" ONMOUSEOUT="cache_legende();" name="sd[sd_notification_failure_criteria_o]" type="checkbox" value="o" <? if (isset($option_nfc["o"]) && strcmp($option_nfc["o"], "")) print "Checked";if (isset($option_nfc["n"]) && strcmp($option_nfc["n"], "")) print " disabled";?> id="sd_notification_failure_criteria_o"> o -
			<input ONMOUSEOVER="montre_legende('Warning', '');" ONMOUSEOUT="cache_legende();" name="sd[sd_notification_failure_criteria_w]" type="checkbox" value="w" <? if (isset($option_nfc["w"]) && strcmp($option_nfc["w"], "")) print "Checked";if (isset($option_nfc["n"]) && strcmp($option_nfc["n"], "")) print " disabled";?> id="sd_notification_failure_criteria_w"> w -
			<input ONMOUSEOVER="montre_legende('Unknown', '');" ONMOUSEOUT="cache_legende();" name="sd[sd_notification_failure_criteria_u]" type="checkbox" value="u" <? if (isset($option_nfc["u"]) && strcmp($option_nfc["u"], "")) print "Checked";if (isset($option_nfc["n"]) && strcmp($option_nfc["n"], "")) print " disabled";?> id="sd_notification_failure_criteria_u"> u -
			<input ONMOUSEOVER="montre_legende('Critical', '');" ONMOUSEOUT="cache_legende();" name="sd[sd_notification_failure_criteria_c]" type="checkbox" value="c" <? if (isset($option_nfc["c"]) && strcmp($option_nfc["c"], "")) print "Checked";if (isset($option_nfc["n"]) && strcmp($option_nfc["n"], "")) print " disabled";?> id="sd_notification_failure_criteria_c"> c -
			<input ONMOUSEOVER="montre_legende('None', '');" ONMOUSEOUT="cache_legende();" name="sd[sd_notification_failure_criteria_n]" type="checkbox" value="n" <? if (isset($option_nfc["n"]) && strcmp($option_nfc["n"], "")) print "Checked";?> onClick="enabledOptionsCheck(sd_notification_failure_criteria_o);enabledOptionsCheck(sd_notification_failure_criteria_w); enabledOptionsCheck(sd_notification_failure_criteria_u); enabledOptionsCheck(sd_notification_failure_criteria_c);"> n
		</td>
	</tr>
	<tr>
		<td align="left">
			<? echo $lang['required']; ?>&nbsp;&nbsp;
		</td>
		<td align="center">
			<input type="hidden" name="sd[sd_id]" value="<? echo $sd_id ?>">
			<input type="submit" name="ChangeSD" value="<? echo $lang['save']; ?>">
		</td>
	</tr>
</table>
</form>