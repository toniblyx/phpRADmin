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
		<td valign="top"><? echo $lang['h']; ?><font color='red'>*</font></td>
		<td class="text10b" valign="top">
			<input type='hidden' name='se[host_host_id]' value='<? echo $ses[$se_id]->get_host(); ?>'>
			<? echo $hosts[$ses[$se_id]->get_host()]->get_name(); ?>
		</td>
	</tr>
	<tr>
		<td valign="top"><? echo $lang['s']; ?><font color='red'>*</font></td>
		<td class="text10b" valign="top">
			<input type='hidden' name='se[service_service_id]' value='<? echo $ses[$se_id]->get_service(); ?>'>
			<? echo $services[$ses[$se_id]->get_service()]->get_description();	?>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<div align="center" class="text10b">
				Contact Group <font color='red'>*</font>
			</div>
			<table border="0" align="center">
				<tr>
					<td align="left" style="padding: 3px;">
						<select name="selectContactGroupBase" size="8" multiple>
						<?
							if (isset($contactGroups))
								foreach ($contactGroups as $contactGroup)	{
									if (!array_key_exists($contactGroup->get_id(), $ses[$se_id]->contactGroups))
										echo "<option value='".$contactGroup->get_id()."'>".$contactGroup->get_name()."</option>";
									unset($contactGroup);
								}
						?>
						</select>
					</td>
					<td style="padding-left: 5px; padding-right: 5px;" valign="middle" align="center">
						<input type="button" name="add" value="<? echo $lang['add']; ?>" onClick="Moove(this.form.selectContactGroupBase,this.form.selectContactGroup)"><br><br><br>
						<input type="button" name="remove" value="<? echo $lang['delete']; ?>" onClick="Moove(this.form.selectContactGroup,this.form.selectContactGroupBase)">
					</td>
					<td>
						<select id="selectContactGroup" name="selectContactGroup[]" size="8" multiple>
							<?
								foreach ($ses[$se_id]->contactGroups as $existing_contactGroup)	{
									echo "<option value='".$existing_contactGroup->get_id()."'>".$existing_contactGroup->get_name()."</option>";
									unset($existing_contactGroup);
								}
							?>
						</select>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td valign="top" nowrap>First notification<font color='red'>*</font></td>
		<td class="text10b" valign="top"><input size="5" type="text" name="se[se_first_notification]" value="<? echo $ses[$se_id]->get_first_notification(); ?>"></td>
	</tr>
	<tr>
		<td valign="top" nowrap>Last notification<font color='red'>*</font></td>
		<td class="text10b" valign="top"><input size="5" type="text" name="se[se_last_notification]" value="<? echo preg_replace("/(99999)/", "0", $ses[$se_id]->get_last_notification()); ?>"></td>
	</tr>
	<tr>
		<td valign="top" nowrap>Notification interval<font color='red'>*</font></td>
		<td class="text10b" valign="top"><input size="5" type="text" name="se[se_notification_interval]" value="<? echo preg_replace("/(99999)/", "0", $ses[$se_id]->get_notification_interval()); ?>"> <? echo " * ".$oreon->Nagioscfg->get_interval_length()." ".$lang["time_sec"]; ?></td>
	</tr>
	<? if (!strcmp ($oreon->user->get_version(), 2)) { ?>
	<tr>
		<td class="text10">escalation_period</td>
		<td align="left" style="padding: 3px;">
			<select name="se[timeperiod_tp_id]">
				<option value=""></option>
			<?
				if (isset($timeperiods))
					foreach ($timeperiods as $timeperiod)	{
						echo "<option value='".$timeperiod->get_id()."'";
						if ($timeperiod->get_id() == $ses[$se_id]->get_escalation_period())
							echo " selected";
						echo ">".$timeperiod->get_name()."</option>";
						unset($timeperiod);
					}
			?>
			</select>
		</td>
	</tr>
	<tr>
		<td class="text10">escalation_options</td>
		<td align="left" style="padding: 3px;" nowrap>
		<?
		$option_esc = array();
		if ($ses[$se_id]->get_escalation_options())	{
			$tab = split(",", stripslashes($ses[$se_id]->get_escalation_options()));
			for ($i = 0; $i != 4; $i++)	{
				if (isset($tab[$i]))
					$option_esc[$tab[$i]] = $tab[$i];
			}
		}
		?>
			<input ONMOUSEOVER="montre_legende('Warning', '');" ONMOUSEOUT="cache_legende();" name="se[se_escalation_options_w]" type="checkbox" value="w" <? if (isset($option_esc["w"]) && strcmp($option_esc["w"], "")) print "Checked";?>> w -
			<input ONMOUSEOVER="montre_legende('Unknown', '');" ONMOUSEOUT="cache_legende();" name="se[se_escalation_options_u]" type="checkbox" value="u" <? if (isset($option_esc["u"]) && strcmp($option_esc["u"], "")) print "Checked";?>> u -
			<input ONMOUSEOVER="montre_legende('Critical', '');" ONMOUSEOUT="cache_legende();" name="se[se_escalation_options_c]" type="checkbox" value="c" <? if (isset($option_esc["c"]) && strcmp($option_esc["c"], "")) print "Checked";?>> c -
			<input ONMOUSEOVER="montre_legende('OK/Recovery', '');" ONMOUSEOUT="cache_legende();" name="se[se_escalation_options_r]" type="checkbox" value="r" <? if (isset($option_esc["r"]) && strcmp($option_esc["r"], "")) print "Checked";?>> r
		</td>
	</tr>
	<? } ?>
	<tr>
		<td align="left">
			<? echo $lang['required']; ?>&nbsp;&nbsp;
		</td>
		<td align="center">
			<input type="hidden" name="se[se_id]" value="<? echo $se_id ?>">
			<input type="submit" name="ChangeSE" value="<? echo $lang['save']; ?>" onClick="selectAll(this.form.selectContactGroup);">
		</td>
	</tr>
</table>
</form>