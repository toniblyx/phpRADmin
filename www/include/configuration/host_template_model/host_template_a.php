<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/?>
<form name="AddHostForm" action="" method="post" enctype="multipart/form-data">
<table cellpadding="0" cellspacing="3" width="350" align='center'>
	<tr>
		<td width="50%">Name :<font color="red">*</font></td>
		<td class="text10b"><input type="text" name="htm[host_name]" value=""></td>
	</tr>
	<tr>
		<td>Alias :</td>
		<td class="text10b"><input type="text" name="htm[host_alias]" value=""></td>
	</tr>
	<tr>
		<td>Address :</td>
		<td class="text10b"><input type="text" name="htm[host_address]" value=""></td>
	</tr>
	<tr>
		<td class="text10b" colspan="2" align="center">
			<div align="center" class="text10b">
				Parents
			</div>
			<table border="0">
				<tr>
					<td align="left" style="padding: 3px;">
						<select name="selectHostParentBase" size="8" multiple>
						<?
						if (isset($hosts))
							foreach ($hosts as $host)	{
								if (!strcmp($host->get_register(), "1"))
									echo "<option value='".$host->get_id()."'>".$host->get_name()."</option>";
								unset($host);
							}
						?>
						</select>
					</td>
					<td style="padding-left: 5px; padding-right: 5px;" valign="middle" align="center">
						<input type="button" name="add" value="<? echo $lang['add']; ?>" onClick="Moove(this.form.selectHostParentBase,this.form.selectHostParent)"><br><br><br>
						<input type="button" name="remove" value="<? echo $lang['delete']; ?>" onClick="Moove(this.form.selectHostParent,this.form.selectHostParentBase)">
					</td>
					<td>
						<select id="selectHostParent" name="selectHostParent[]" size="8" multiple></select>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class="text10b" colspan="2" align="center">
			<div align="center" class="text10b">
				Host Groups
			</div>
			<table border="0">
				<tr>
					<td align="left" style="padding: 3px;">
						<select name="selectHostGroupBase" size="8" multiple>
						<?
							if (isset($hostGroups))
								foreach ($hostGroups as $hostGroup)	{
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
						<select id="selectHostGroup" name="selectHostGroup[]" size="8" multiple></select>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>Check_command :</td>
		<td class="text10b">
		<select name="htm[command_command_id]">
		<option value=''></option>
		<?
			if (isset($commands))
				foreach ($commands as $cmd)	{
					if (!strstr($cmd->get_name(), "check_graph") && !strcmp($cmd->get_type(), "2"))
						echo "<option value='".$cmd->get_id()."'>".$cmd->get_name()."</option>";
					unset($cmd);
				}
		?>
		</select>
		</td>
	</tr>
	<tr>
		<td>Max_check_attempts :</td>
		<td class="text10b"><input size="5" type="text" name="htm[host_max_check_attempts]" value=""></td>
	</tr>
	<? if (!strcmp("1", $oreon->user->get_version()))	{	?>
	<tr>
		<td>Checks_enabled :</td>
		<td class="text10b">
		<input name="htm[host_check_enabled]" type="radio" value="1"> Yes -
		<input name="htm[host_check_enabled]" type="radio" value="3"> No -
		<input name="htm[host_check_enabled]" type="radio" value="2" Checked> Nothing
		</td>
	</tr>
	<? } if (!strcmp("2", $oreon->user->get_version())) { ?>
	<tr>
		<td>Check_interval :</td>
		<td class="text10b"><input size="5" type="text" name="htm[host_check_interval]" value=""> <? echo " * ".$oreon->Nagioscfg->get_interval_length()." ".$lang["time_sec"]; ?></td>
	</tr>
	<tr>
		<td>Active_checks_enabled :</td>
		<td class="text10b">
		<input name="htm[host_active_checks_enabled]" type="radio" value="1"> Yes -
		<input name="htm[host_active_checks_enabled]" type="radio" value="3"> No -
		<input name="htm[host_active_checks_enabled]" type="radio" value="2" Checked> Nothing
		</td>
	</tr>
	<tr>
		<td>Passive_checks_enabled :</td>
		<td class="text10b">
		<input name="htm[host_passive_checks_enabled]" type="radio" value="1"> Yes -
		<input name="htm[host_passive_checks_enabled]" type="radio" value="3"> No -
		<input name="htm[host_passive_checks_enabled]" type="radio" value="2" Checked> Nothing
		</td>
	</tr>
	<tr>
		<td>Check_period :</td>
		<td class="text10b">
		<select name="htm[timeperiod_tp_id]">
		<?
			if (isset($timePeriods))
				foreach ($timePeriods as $tp)	{
					echo "<option value='".$tp->get_id()."'>".$tp->get_name()."</option>";
					unset($tp);
				}
		?>
		</select>
		</td>
	</tr>
	<tr>
		<td>Obsess_over_host :</td>
		<td class="text10b">
		<input name="htm[host_obsess_over_host]" type="radio" value="1"> Yes -
		<input name="htm[host_obsess_over_host]" type="radio" value="3"> No -
		<input name="htm[host_obsess_over_host]" type="radio" value="2" Checked> Nothing
		</td>
	</tr>
	<tr>
		<td>Check_freshness :</td>
		<td class="text10b">
		<input name="htm[host_check_freshness]" type="radio" value="1"> Yes -
		<input name="htm[host_check_freshness]" type="radio" value="3"> No -
		<input name="htm[host_check_freshness]" type="radio" value="2" Checked> Nothing
		</td>
	</tr>
	<tr>
		<td>Freshness_threshold :</td>
		<td class="text10b">
			<input size="5" type="text" id="templateFreshnessThreshold" name="htm[host_freshness_threshold]" value=""> <? echo $lang["time_sec"]; ?>
			&nbsp;&nbsp;<input type="checkbox" name="ftNothingBox" OnClick="enabledTemplateFieldSelect(this.form.templateFreshnessThreshold);">
			<? echo $value_flag[2]; ?>
		</td>
	</tr>
	<?	}	?>
	<tr>
		<td>Event_handler_enabled :</td>
		<td class="text10b">
		<input name="htm[host_event_handler_enabled]" type="radio" value="1"> Yes -
		<input name="htm[host_event_handler_enabled]" type="radio" value="3"> No -
		<input name="htm[host_event_handler_enabled]" type="radio" value="2" Checked> Nothing
		</td>
	</tr>
	<tr>
		<td>Event_handler :</td>
		<td class="text10b">
		<select name="htm[command_command_id2]" id="templateEventHandler">
		<option></option>
		<?
			if (isset($commands))
				foreach ($commands as $cmd)	{
					if (!strstr($cmd->get_name(), "check_graph") && $cmd->get_type() == 2)
						echo "<option value='".$cmd->get_id()."'>".$cmd->get_name()."</option>";
					unset($cmd);
				}
		?>
		</select>
		</td>
	</tr>
	<tr>
		<td>Low_flap_threshold :</td>
		<td class="text10b">
			<input size="5" type="text" id="templateLowFlapThreshold" name="htm[host_low_flap_threshold]" value=""> %
			&nbsp;&nbsp;<input type="checkbox" name="lftNothingBox" OnClick="enabledTemplateFieldSelect(this.form.templateLowFlapThreshold);">
			<? echo $value_flag[2]; ?>
		</td>
	</tr>
	<tr>
		<td>High_flap_threshold :</td>
		<td class="text10b">
			<input size="5" type="text" id="templateHighFlapThreshold" name="htm[host_high_flap_threshold]" value=""> %
			&nbsp;&nbsp;<input type="checkbox" name="hftNothingBox" OnClick="enabledTemplateFieldSelect(this.form.templateHighFlapThreshold);">
			<? echo $value_flag[2]; ?>
		</td>
	</tr>
	<tr>
		<td>Flap_detection_enabled :</td>
		<td class="text10b">
		<input name="htm[host_flap_detection_enabled]" type="radio" value="1"> Yes -
		<input name="htm[host_flap_detection_enabled]" type="radio" value="3"> No -
		<input name="htm[host_flap_detection_enabled]" type="radio" value="2" Checked> Nothing
		</td>
	</tr>
	<tr>
		<td>Process_perf_data :</td>
		<td class="text10b">
		<input name="htm[host_process_perf_data]" type="radio" value="1"> Yes -
		<input name="htm[host_process_perf_data]" type="radio" value="3"> No -
		<input name="htm[host_process_perf_data]" type="radio" value="2" Checked> Nothing
		</td>
	</tr>
	<tr>
		<td>Retain_status_information :</td>
		<td class="text10b">
		<input name="htm[host_retain_status_information]" type="radio" value="1"> Yes -
		<input name="htm[host_retain_status_information]" type="radio" value="3"> No -
		<input name="htm[host_retain_status_information]" type="radio" value="2" Checked> Nothing
		</td>
	</tr>
	<tr>
		<td style="white-space: nowrap;">Retain_nonstatus_information :</td>
		<td style="white-space: nowrap;" class="text10b">
		<input name="htm[host_retain_nonstatus_information]" type="radio" value="1"> Yes -
		<input name="htm[host_retain_nonstatus_information]" type="radio" value="3"> No -
		<input name="htm[host_retain_nonstatus_information]" type="radio" value="2" Checked> Nothing
		</td>
	</tr>
	<?	if (!strcmp("2", $oreon->user->get_version()))	{	?>
	<tr>
		<td class="text10b" colspan="2" align="center">
			<div align="center" class="text10b">
				Contact Groups
			</div>
			<table border="0">
				<tr>
					<td align="left" style="padding: 3px;">
						<select name="selectContactGroupBase" size="8" multiple>
						<?
							if (isset($contactGroups))
								foreach ($contactGroups as $contactGroup)	{
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
						</select>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<?	}	?>
	<tr>
		<td>Notification_interval :</td>
		<td class="text10b"><input size="5" type="text" name="htm[host_notification_interval]" value=""> <? echo " * ".$oreon->Nagioscfg->get_interval_length()." ".$lang["time_sec"]; ?></td>
	</tr>
	<tr>
		<td>Notification_period :</td>
		<td class="text10b">
		<select name="htm[timeperiod_tp_id2]">
		<?
			if (isset($timePeriods))
				foreach ($timePeriods as $tp)	{
					echo "<option value='".$tp->get_id()."'>".$tp->get_name()."</option>";
					unset($tp);
				}
		?>
		</select>
		</td>
	</tr>
	<tr>
		<td>Notification_options :</td>
		<td class="text10b">
		<input ONMOUSEOVER="montre_legende('Down', '');" ONMOUSEOUT="cache_legende();"  name="htm[host_notification_options_d]" type="checkbox" value="d"> d -
		<input ONMOUSEOVER="montre_legende('Up', '');" ONMOUSEOUT="cache_legende();"  name="htm[host_notification_options_u]" type="checkbox" value="u"> u -
		<input ONMOUSEOVER="montre_legende('Recovery', '');" ONMOUSEOUT="cache_legende();"  name="htm[host_notification_options_r]" type="checkbox" value="r"> r
		</td>
	</tr>
	<tr>
		<td>Notifications_enabled :</td>
		<td class="text10b">
		<input name="htm[host_notifications_enabled]" type="radio" value="1"> Yes -
		<input name="htm[host_notifications_enabled]" type="radio" value="3"> No -
		<input name="htm[host_notifications_enabled]" type="radio" value="2" Checked> Nothing
		</td>
	</tr>
	<tr>
		<td>Stalking_options :</td>
		<td class="text10b">
		<input ONMOUSEOVER="montre_legende('Ok/UP', '');" ONMOUSEOUT="cache_legende();"  name="htm[host_stalking_options_o]" type="checkbox" value="o"> o -
		<input ONMOUSEOVER="montre_legende('Down', '');" ONMOUSEOUT="cache_legende();"  name="htm[host_stalking_options_d]" type="checkbox" value="d"> d -
		<input ONMOUSEOVER="montre_legende('Unreachable', '');" ONMOUSEOUT="cache_legende();"  name="htm[htost_stalking_options_u]" type="checkbox" value="u"> u
		</td>
	</tr>
	<tr>
		<td valign="top">Comment :</td>
		<td class="text10b">
			<textarea name="htm[host_comment]" cols="25" rows="4"></textarea>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center">
			<input type="submit" name="AddHTM" value="<? echo $lang['save']; ?>" onClick="selectAll(this.form.selectHostParent); selectAll(this.form.selectHostGroup); selectAll(this.form.selectContactGroup)">
		</td>
	</tr>
</table>
</form>