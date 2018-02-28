<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/?>
<form name="AddServiceTemplateModel" action="" method="post">
<table border="0" cellpadding="3" cellspacing="3">
	<tr>
		<td>Description :</td>
		<td class="text10b"><input type="text" name="stm[service_description]" value="" maxlength="63"></td>
	</tr>
	<tr>
		<td>Is Volatile :</td>
		<td class="text10b">
		<input name="stm[service_is_volatile]" type="radio" value="1"> Yes -
		<input name="stm[service_is_volatile]" type="radio" value="3"> No -
		<input name="stm[service_is_volatile]" type="radio" value="2" checked> Nothing</td>
	</tr>
	<tr>
		<td colspan="2">
			<div class="text10b" align="center">
				Service Groups
			</div>
			<table border="0" align="center">
				<tr>
					<td align="left" style="padding: 3px;">
						<select name="selectSGBase" size="8" multiple>
						<?
							if (isset($serviceGroups))	{
								foreach ($serviceGroups as $serviceGroup)	{
									if (!array_key_exists($serviceGroup->get_id(), $services[$sv]->serviceGroups))
										echo "<option value='".$serviceGroup->get_id()."'>".$serviceGroup->get_name()."</option>";
									unset($serviceGroup);
								}
							}
						?>
						</select>
					</td>
					<td style="padding-left: 5px; padding-right: 5px;" valign="middle" align="center">
						<input type="button" name="add" value="<? echo $lang['add']; ?>" onClick="Moove(this.form.selectSGBase,this.form.selectSG);"><br><br><br>
						<input type="button" name="remove" value="<? echo $lang['delete']; ?>" onClick="Moove(this.form.selectSG,this.form.selectSGBase);">
					</td>
					<td>
						<select id="selectSG" name="selectSG[]" size="8" multiple></select>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>Check_command :</td>
		<td class="text10b">
		<select name="stm[command_command_id]" id="templateCheckCommand">
		<option></option>
		<?
			if (isset($commands))
				foreach ($commands as $cmd)	{
					if (!strcmp($cmd->get_type(), "2"))
						echo "<option value='" . $cmd->get_id() . "'>" . $cmd->get_name() . "</option>";
					unset($cmd);
				}
		?>
		</select>
		</td>
	</tr>
	<tr>
		<td>Check_command_arguments :</td>
		<td class="text10b">
			<input type="text" name="stm[command_command_id_arg]" value="">
			<img src="./img/info.gif" ONMOUSEOVER="var sel = document.forms['AddServiceTemplateModel'].elements['templateCheckCommand'].options[document.forms['AddServiceTemplateModel'].elements['templateCheckCommand'].options.selectedIndex].value; command = commands_arg(sel); montre_legende(command[1], command[0]);" ONMOUSEOUT="cache_legende();">
		</td>
	</tr>
	<tr>
		<td>Max_check_attempts :</td>
		<td class="text10b"><input size="5" type="text" name="stm[service_max_check_attempts]" value=""></td>
	</tr>
	<tr>
		<td>Normal_check_interval :</td>
		<td class="text10b"><input size="5" type="text" name="stm[service_normal_check_interval]" value=""> <? echo " * ".$oreon->Nagioscfg->get_interval_length()." ".$lang["time_sec"]; ?></td>
	</tr>
	<tr>
		<td>Retry_check_interval :</td>
		<td class="text10b"><input size="5" type="text" name="stm[service_retry_check_interval]" value=""> <? echo " * ".$oreon->Nagioscfg->get_interval_length()." ".$lang["time_sec"]; ?></td>
	</tr>
	<tr>
		<td>Active_checks_enabled :</td>
		<td class="text10b">
		<input name="stm[service_active_checks_enabled]" type="radio" value="1"> Yes -
		<input name="stm[service_active_checks_enabled]" type="radio" value="3"> No -
		<input name="stm[service_active_checks_enabled]" type="radio" value="2" checked> Nothing
		</td>
	</tr>
	<tr>
		<td>Passive_checks_enabled :</td>
		<td class="text10b">
		<input name="stm[service_passive_checks_enabled]" type="radio" value="1"> Yes -
		<input name="stm[service_passive_checks_enabled]" type="radio" value="3"> No -
		<input name="stm[service_passive_checks_enabled]" type="radio" value="2" checked> Nothing
		</td>
	</tr>
	<tr>
		<td>Check_period :</td>
		<td class="text10b">
		<select name="stm[timeperiod_tp_id]">
			<option></option>
		<?
			if (isset($timePeriods))
				foreach ($timePeriods as $tp)	{
					echo "<option value='" . $tp->get_id() . "'>" . $tp->get_name() . "</option>";
					unset($tp);
				}
		?>
		</select>
		</td>
	</tr>
	<tr>
		<td>Parallelize_check :</td>
		<td class="text10b">
		<input name="stm[service_parallelize_check]" type="radio" value="1"> Yes -
		<input name="stm[service_parallelize_check]" type="radio" value="3"> No -
		<input name="stm[service_parallelize_check]" type="radio" value="2" checked> Nothing
		</td>
	</tr>
	<tr>
		<td>Obsess_over_service :</td>
		<td class="text10b">
		<input name="stm[service_obsess_over_service]" type="radio" value="1"> Yes -
		<input name="stm[service_obsess_over_service]" type="radio" value="3"> No -
		<input name="stm[service_obsess_over_service]" type="radio" value="2" checked> Nothing
		</td>
	</tr>
	<tr>
		<td>Check_freshness :</td>
		<td class="text10b">
		<input name="stm[service_check_freshness]" type="radio" value="1"> Yes -
		<input name="stm[service_check_freshness]" type="radio" value="3"> No -
		<input name="stm[service_check_freshness]" type="radio" value="2" checked> Nothing
		</td>
	</tr>
	<tr>
		<td>Freshness_threshold :</td>
		<td class="text10b">
			<input size="5" type="text" id="templateFreshnessThreshold" name="stm[service_freshness_threshold]" value=""> <? echo $lang["time_sec"]; ?>
			&nbsp;&nbsp;<input type="checkbox" name="ftNothingBox" OnClick="enabledTemplateFieldSelect(this.form.templateFreshnessThreshold);">
			<? echo $value_flag[2]; ?>
		</td>
	</tr>
	<tr>
		<td>Event_handler :</td>
		<td class="text10b">
		<select name="stm[command_command_id2]" id="templateEventHandler">
		<?
			echo "<option value=''></option>";
			if (isset($commands))
				foreach ($commands as $cmd)	{
					if (!strstr($cmd->get_name(), "check_graph") && $cmd->get_type() == 2)
						echo "<option value='" . $cmd->get_id() . "'>" . $cmd->get_name() . "</option>";
					unset($cmd);
				}
		?>
		</select>
		</td>
	</tr>
	<tr>
		<td>Event_handler_arguments :</td>
		<td class="text10b">
			<input type="text" name="stm[command_command_id2_arg]" value="">
			<img src="./img/info.gif" ONMOUSEOVER="var sel = document.forms['AddServiceTemplateModel'].elements['templateEventHandler'].options[document.forms['AddServiceTemplateModel'].elements['templateEventHandler'].options.selectedIndex].value; command = commands_arg(sel); montre_legende(command[1], command[0]);" ONMOUSEOUT="cache_legende();">
		</td>
	</tr>
	<tr>
		<td>Event_handler enabled :</td>
		<td class="text10b">
		<input name="stm[service_event_handler_enabled]" type="radio" value="1"> Yes -
		<input name="stm[service_event_handler_enabled]" type="radio" value="3"> No -
		<input name="stm[service_event_handler_enabled]" type="radio" value="2" checked> Nothing
		</td>
	</tr>
	<tr>
		<td>Low_flap_threshold :</td>
		<td class="text10b">
			<input size="5" type="text" id="templateLowFlapThreshold" name="stm[service_low_flap_threshold]" value=""> %
			&nbsp;&nbsp;<input type="checkbox" name="lftNothingBox" OnClick="enabledTemplateFieldSelect(this.form.templateLowFlapThreshold);">
			<? echo $value_flag[2]; ?>
		</td>
	</tr>
	<tr>
		<td>High_flap_threshold :</td>
		<td class="text10b">
			<input size="5" type="text" id="templateHighFlapThreshold" name="stm[service_high_flap_threshold]" value=""> %
			&nbsp;&nbsp;<input type="checkbox" name="hftNothingBox" OnClick="enabledTemplateFieldSelect(this.form.templateHighFlapThreshold);">
			<? echo $value_flag[2]; ?>
		</td>
	</tr>
	<tr>
		<td>Flap_detection_enabled :</td>
		<td class="text10b">
		<input name="stm[service_flap_detection_enabled]" type="radio" value="1"> Yes -
		<input name="stm[service_flap_detection_enabled]" type="radio" value="3"> No -
		<input name="stm[service_flap_detection_enabled]" type="radio" value="2" checked> Nothnig
		</td>
	</tr>
	<tr>
		<td>Process_perf_data :</td>
		<td class="text10b">
		<input name="stm[service_process_perf_data]" type="radio" value="1"> Yes -
		<input name="stm[service_process_perf_data]" type="radio" value="3"> No -
		<input name="stm[service_process_perf_data]" type="radio" value="2" checked> Nothing
		</td>
	</tr>
	<tr>
		<td>Retain_status_information :</td>
		<td class="text10b">
		<input name="stm[service_retain_status_information]" type="radio" value="1"> Yes -
		<input name="stm[service_retain_status_information]" type="radio" value="3"> No -
		<input name="stm[service_retain_status_information]" type="radio" value="2" checked> Nothing
		</td>
	</tr>
	<tr>
		<td style="white-space: nowrap;">Retain_nonstatus_information :</td>
		<td class="text10b" style="white-space: nowrap;">
		<input name="stm[service_retain_nonstatus_information]" type="radio" value="1"> Yes -
		<input name="stm[service_retain_nonstatus_information]" type="radio" value="3"> No -
		<input name="stm[service_retain_nonstatus_information]" type="radio" value="2" checked> Nothing
		</td>
	</tr>
	<tr>
		<td>Notification_interval :</td>
		<td class="text10b"><input size="5" type="text" name="stm[service_notification_interval]" value=""> <? echo " * ".$oreon->Nagioscfg->get_interval_length()." ".$lang["time_sec"]; ?></td>
	</tr>
	<tr>
		<td>Notification_period :</td>
		<td class="text10b">
		<select name="stm[timeperiod_tp_id2]">
			<option></option>
		<?	if (isset($timePeriods))
				foreach ($timePeriods as $tp)	{
					echo "<option value='" . $tp->get_id() . "'>" . $tp->get_name() . "</option>";
					unset($tp);
				}
		?>
		</select>
		</td>
	</tr>
	<tr>
		<td>Notification_options :</td>
		<td class="text10b">
		<input ONMOUSEOVER="montre_legende('Warning', '');" ONMOUSEOUT="cache_legende();"  name="stm[service_notification_options_w]" type="checkbox" value="w"> w -
		<input ONMOUSEOVER="montre_legende('Unknown', '');" ONMOUSEOUT="cache_legende();"  name="stm[service_notification_options_u]" type="checkbox" value="u"> u -
		<input ONMOUSEOVER="montre_legende('Critical', '');" ONMOUSEOUT="cache_legende();"  name="stm[service_notification_options_c]" type="checkbox" value="c"> c
		<input ONMOUSEOVER="montre_legende('Recovery', '');" ONMOUSEOUT="cache_legende();"  name="stm[service_notification_options_r]" type="checkbox" value="r"> r
	</tr>
	<tr>
		<td>Notification_enabled :</td>
		<td class="text10b">
		<input name="stm[service_notification_enabled]" type="radio" value="1"> Yes -
		<input name="stm[service_notification_enabled]" type="radio" value="3"> No -
		<input name="stm[service_notification_enabled]" type="radio" value="2" checked> Nothing
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<div align="center" class="text10b">
				Contact Groups
			</div>
			<table border="0" align="center">
				<tr>
					<td align="left" style="padding: 3px;">
						<select name="selectCGBase" size="8" multiple>
						<?
							if (isset($contactGroups))	{
								foreach ($contactGroups as $contactGroup)	{
									if (!array_key_exists($contactGroup->get_id(), $services[$sv]->contactGroups))
										echo "<option value='".$contactGroup->get_id()."'>".$contactGroup->get_name()."</option>";
									unset($contactGroup);
								}
							}
						?>
						</select>
					</td>
					<td style="padding-left: 5px; padding-right: 5px;" valign="middle" align="center">
						<input type="button" name="add" value="<? echo $lang['add']; ?>" onClick="Moove(this.form.selectCGBase,this.form.selectCG);"><br><br><br>
						<input type="button" name="remove" value="<? echo $lang['delete']; ?>" onClick="Moove(this.form.selectCG,this.form.selectCGBase);">
					</td>
					<td>
						<select id="selectCG" name="selectCG[]" size="8" multiple></select>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>Stalking_options :</td>
		<td class="text10b">
		<input ONMOUSEOVER="montre_legende('Ok', '');" ONMOUSEOUT="cache_legende();"  name="stm[service_stalking_options_o]" type="checkbox" value="o"> o -
		<input ONMOUSEOVER="montre_legende('Warning', '');" ONMOUSEOUT="cache_legende();"  name="stm[service_stalking_options_w]" type="checkbox" value="w"> w -
		<input ONMOUSEOVER="montre_legende('Unknown', '');" ONMOUSEOUT="cache_legende();"  name="stm[service_stalking_options_u]" type="checkbox" value="u"> u
		<input ONMOUSEOVER="montre_legende('Critical', '');" ONMOUSEOUT="cache_legende();"  name="stm[service_stalking_options_c]" type="checkbox" value="c"> c
		</td>
	</tr>
	<tr>
		<td valign="top">Comment :</td>
		<td class="text10b">
			<textarea name="stm[service_comment]" cols="25" rows="4"></textarea>
		</td>
	</tr>
	<tr>
		<td align="left">
			<? echo $lang['required']; ?>&nbsp;&nbsp;
		</td>
		<td align="center">
			<input type="submit" name="AddSTM" value="<? echo $lang['save']; ?>" onClick="selectAll(this.form.selectCG); selectAll(this.form.selectSG);">
		</td>
	</tr>
	</table>
</form>