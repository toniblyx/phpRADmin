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
		<td class="text10b" style="white-space: nowrap;" width="50%">Host<font color='red'>*</font></td>
		<td style="padding: 3px;">
		<select name="he[host_host_id]">
		<?
			if (isset($hosts))	{
				foreach ($hosts as $host)
					if ($host->get_register())	{
						echo "<option value='".$host->get_id()."'";
						if ($host->get_id() == $hes[$he_id]->get_host())
							echo " selected";
						echo ">".$host->get_name()."</option>";
					unset($host);
				}
			}
		?>
		</select>
		</td>
	</tr>
	<tr>
		<td class="text10b" style="white-space: nowrap;">first_notification<font color='red'>*</font></td>
		<td class="text10b"><input size="5" type="text" name="he[he_first_notification]" value="<? echo $hes[$he_id]->get_first_notification(); ?>"></td>
	</tr>
	<tr>
		<td class="text10b" style="white-space: nowrap;">last_notification<font color='red'>*</font></td>
		<td class="text10b"><input size="5" type="text" name="he[he_last_notification]" value="<? echo preg_replace("/(99999)/", "0", $hes[$he_id]->get_last_notification()); ?>"></td>
	</tr>
	<tr>
		<td class="text10b" style="white-space: nowrap;">notification_interval<font color='red'>*</font></td>
		<td class="text10b" style="white-space: nowrap;"><input size="5" type="text" name="he[he_notification_interval]" value="<? echo preg_replace("/(99999)/", "0", $hes[$he_id]->get_notification_interval()); ?>"> <? echo " * ".$oreon->Nagioscfg->get_interval_length()." ".$lang["time_sec"]; ?></td>
	</tr>
	<tr>
		<td colspan="2">
			<table border="0" align="center">
				<tr>
					<td colspan="3" align="center" class="text10b" style="padding:20px; white-space: nowrap;">
						Contact Group<font color='red'>*</font>
					</td>
				</tr>
				<tr>
					<td align="left" style="padding: 3px;">
						<select name="selectContactGroupBase" size="8" multiple>
						<?
							if (isset($contactGroups))
								foreach ($contactGroups as $contactGroup)	{
									if (!array_key_exists($contactGroup->get_id(), $hes[$he_id]->contactGroups))
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
								foreach ($hes[$he_id]->contactGroups as $existing_contactGroup)	{
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
	<? if (!strcmp ($oreon->user->get_version(), 2)) { ?>
	<tr>
		<td colspan="2">
			<table border="0" align="center">
				<tr>
					<td colspan="3" align="center" class="text10b" style="padding=20px; white-space: nowrap;">
						Host Group
					</td>
				</tr>
				<tr>
					<td align="left" style="padding: 3px;">
						<select name="selectHostGroupBase" size="8" multiple>
						<?
							if (isset($hostGroups))
								foreach ($hostGroups as $hostGroup)	{
									if (!array_key_exists($hostGroup->get_id(), $hes[$he_id]->hostGroups))
										echo "<option value='".$hostGroup->get_id()."'>".$hostGroup->get_name()."</option>";
									unset($hostGroup);
								}
						?>
						</select>
					</td>
					<td style="padding-left: 5px; padding-right: 5px;" valign="middle" align="center">
						<input type="button" name="add" value="<? echo $lang['add']; ?>" onClick="Moove(this.form.selectHostGroupBase,this.form.selectHostGroup)"><br><br><br>
						<input type="button" name="remove" value="<? echo $lang['delete']; ?>" onClick="Moove(this.form.selectHostGroup,this.form.selectHostGroupBase)">
					</td>
					<td>
						<select id="selectHostGroup" name="selectHostGroup[]" size="8" multiple>
						<?
							foreach ($hes[$he_id]->hostGroups as $existing_hostGroup)	{
								echo "<option value='".$existing_hostGroup->get_id()."'>".$existing_hostGroup->get_name()."</option>";
								unset($existing_hostGroup);
							}
						?>
						</select>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<? } if (!strcmp ($oreon->user->get_version(), 2)) { ?>
	<tr>
		<td class="text10b" style="white-space: nowrap;">escalation_period</td>
		<td align="left" style="padding: 3px;">
			<select name="he[timeperiod_tp_id]">
				<option value=""></option>
			<?
				if (isset($timeperiods))
					foreach ($timeperiods as $timeperiod)	{
						echo "<option value='".$timeperiod->get_id()."'";
						if ($timeperiod->get_id() == $hes[$he_id]->get_escalation_period())
							echo " selected";
						echo ">".$timeperiod->get_name()."</option>";
						unset($timeperiod);
					}
			?>
			</select>
		</td>
	</tr>
	<tr>
		<td class="text10b" style="white-space: nowrap;">escalation_options</td>
		<td align="left" style="padding: 3px; white-space: nowrap;">
			<?
			$option_esc = array();
			if ($hes[$he_id]->get_escalation_options())	{
				$tab = split(",", stripslashes($hes[$he_id]->get_escalation_options()));
				for ($i = 0; $i != 3; $i++){
					if (isset($tab[$i]))
						$option_esc[$tab[$i]] = $tab[$i];
				}
			}
			?>
			<input ONMOUSEOVER="montre_legende('Down', '');" ONMOUSEOUT="cache_legende();" name="he[he_escalation_options_d]" type="checkbox" value="d" <? if (isset($option_esc["d"]) && strcmp($option_esc["d"], "")) print "Checked";?>> d -
			<input ONMOUSEOVER="montre_legende('Unreachable', '');" ONMOUSEOUT="cache_legende();" name="he[he_escalation_options_u]" type="checkbox" value="u" <? if (isset($option_esc["u"]) && strcmp($option_esc["u"], "")) print "Checked";?>> u -
			<input ONMOUSEOVER="montre_legende('UP/Recovery', '');" ONMOUSEOUT="cache_legende();" name="he[he_escalation_options_r]" type="checkbox" value="r" <? if (isset($option_esc["r"]) && strcmp($option_esc["r"], "")) print "Checked";?>> r
		</td>
	</tr>
	<? } ?>
	<tr>
		<td align="left">
			<? echo $lang['required']; ?>&nbsp;&nbsp;
		</td>
		<td align="center">
			<input type="hidden" name="he[he_id]" value="<? echo $he_id; ?>">
			<input type="submit" name="ChangeHE" value="<? echo $lang['save']; ?>" onClick="selectAll(this.form.selectContactGroup); selectAll(this.form.selectHostGroup)">
		</td>
	</tr>
</table>
</form>