<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/?>
<form name="ChangeServiceTemplateModel" method="post">
<table border="0" cellpadding="3" cellspacing="3">
	<tr>
		<td>Description :</td>
		<td class="text10b"><input type="text" name="stm[service_description]" value="<? echo $services[$stm_id]->get_description(); ?>" maxlength="63"></td>
	</tr>
	<tr>
		<td>Is Volatile :</td>
		<td class="text10b">
		<input name="stm[service_is_volatile]" type="radio" value="1" <? if ($services[$stm_id]->get_is_volatile() == 1) echo "Checked"; ?>> Yes -
		<input name="stm[service_is_volatile]" type="radio" value="3" <? if ($services[$stm_id]->get_is_volatile() == 3) echo "Checked"; ?> > No -
		<input name="stm[service_is_volatile]" type="radio" value="2" <? if ($services[$stm_id]->get_is_volatile() == 2) echo "Checked"; ?> > Nothing
		</td>
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
									if (!array_key_exists($serviceGroup->get_id(), $services[$stm_id]->serviceGroups))
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
						<select id="selectSG" name="selectSG[]" size="8" multiple>
						<?
						if (isset($services[$stm_id]->serviceGroups))
							foreach ($services[$stm_id]->serviceGroups as $existing_sg)	{
								echo "<option value='".$existing_sg->get_id()."'>".$existing_sg->get_name()."</option>";
								unset($existing_sg);
							}
						?>
						</select>

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
					if ($cmd->get_id() == $services[$stm_id]->get_check_command())
						echo "<option value='" . $cmd->get_id() . "' selected>" . $cmd->get_name() . "</option>";
					else if (!strcmp($cmd->get_type(), "2"))
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
			<input type="text" name="stm[command_command_id_arg]" value="<? echo str_replace("\"","&#34;",$services[$stm_id]->get_check_command_arg()); ?>">
			<img src="./img/info.gif" ONMOUSEOVER="var sel = document.forms['ChangeServiceTemplateModel'].elements['templateCheckCommand'].options[document.forms['ChangeServiceTemplateModel'].elements['templateCheckCommand'].options.selectedIndex].value; command = commands_arg(sel); montre_legende(command[1], command[0]);" ONMOUSEOUT="cache_legende();">
		</td>
	</tr>
	<tr>
		<td>Max_check_attempts :</td>
		<td class="text10b"><input size="5" type="text" name="stm[service_max_check_attempts]" value="<? echo $services[$stm_id]->get_max_check_attempts(); ?>"></td>
	</tr>
	<tr>
		<td>Normal_check_interval :</td>
		<td class="text10b"><input size="5" type="text" name="stm[service_normal_check_interval]" value="<? echo $services[$stm_id]->get_normal_check_interval(); ?>"> <? echo " * ".$oreon->Nagioscfg->get_interval_length()." ".$lang["time_sec"]; ?></td>
	</tr>
	<tr>
		<td>Retry_check_interval :</td>
		<td class="text10b"><input size="5" type="text" name="stm[service_retry_check_interval]" value="<? echo $services[$stm_id]->get_retry_check_interval(); ?>"> <? echo " * ".$oreon->Nagioscfg->get_interval_length()." ".$lang["time_sec"]; ?></td>
	</tr>
	<tr>
		<td>Active_checks_enabled :</td>
		<td class="text10b">
		<input name="stm[service_active_checks_enabled]" type="radio" value="1" <? if ($services[$stm_id]->get_active_checks_enabled() == 1) echo "Checked"; ?>> Yes -
		<input name="stm[service_active_checks_enabled]" type="radio" value="3" <? if ($services[$stm_id]->get_active_checks_enabled() == 3) echo "Checked"; ?> > No -
		<input name="stm[service_active_checks_enabled]" type="radio" value="2" <? if ($services[$stm_id]->get_active_checks_enabled() == 2) echo "Checked"; ?> > Nothing
		</td>
	</tr>
	<tr>
		<td>Passive_checks_enabled :</td>
		<td class="text10b">
		<input name="stm[service_passive_checks_enabled]" type="radio" value="1" <? if ($services[$stm_id]->get_passive_checks_enabled() == 1) echo "Checked"; ?>> Yes -
		<input name="stm[service_passive_checks_enabled]" type="radio" value="3" <? if ($services[$stm_id]->get_passive_checks_enabled() == 3) echo "Checked"; ?> > No -
		<input name="stm[service_passive_checks_enabled]" type="radio" value="2" <? if ($services[$stm_id]->get_passive_checks_enabled() == 2) echo "Checked"; ?> > Nothing
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
					if ($tp->get_id() == $services[$stm_id]->get_check_period())
						echo "<option value='" . $tp->get_id() . "' selected>" . $tp->get_name() . "</option>";
					else
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
		<input name="stm[service_parallelize_check]" type="radio" value="1" <? if ($services[$stm_id]->get_parallelize_check() == 1) echo "Checked"; ?>> Yes -
		<input name="stm[service_parallelize_check]" type="radio" value="3" <? if ($services[$stm_id]->get_parallelize_check() == 3) echo "Checked"; ?> > No -
		<input name="stm[service_parallelize_check]" type="radio" value="2" <? if ($services[$stm_id]->get_parallelize_check() == 2) echo "Checked"; ?> > Nothing
		</td>
	</tr>
	<tr>
		<td>Obsess_over_service :</td>
		<td class="text10b">
		<input name="stm[service_obsess_over_service]" type="radio" value="1" <? if ($services[$stm_id]->get_obsess_over_service() == 1) echo "Checked"; ?>> Yes -
		<input name="stm[service_obsess_over_service]" type="radio" value="3" <? if ($services[$stm_id]->get_obsess_over_service() == 3) echo "Checked"; ?> > No -
		<input name="stm[service_obsess_over_service]" type="radio" value="2" <? if ($services[$stm_id]->get_obsess_over_service() == 2) echo "Checked"; ?> > Nothing
		</td>
	</tr>
	<tr>
		<td>Check_freshness :</td>
		<td class="text10b">
		<input name="stm[service_check_freshness]" type="radio" value="1" <? if ($services[$stm_id]->get_check_freshness() == 1) echo "Checked"; ?>> Yes -
		<input name="stm[service_check_freshness]" type="radio" value="3"<? if ($services[$stm_id]->get_check_freshness() == 3) echo "Checked"; ?> > No -
		<input name="stm[service_check_freshness]" type="radio" value="2"<? if ($services[$stm_id]->get_check_freshness() == 2) echo "Checked"; ?> > Nothing
		</td>
	</tr>
	<tr>
		<td>Freshness_threshold :</td>
		<td class="text10b">
			<input size="5" type="text" id="templateFreshnessThreshold" name="stm[service_freshness_threshold]" value="
			<?
				if ($services[$stm_id]->get_freshness_threshold())
					echo preg_replace("/(99999)/", "0", $services[$stm_id]->get_freshness_threshold());
			?>" <? if (!$services[$stm_id]->get_freshness_threshold()) echo "disabled"; ?>> %
			&nbsp;&nbsp;<input type="checkbox" name="ftNothingBox" <? if (!$services[$stm_id]->get_freshness_threshold()) echo "checked"; ?>  OnClick="enabledTemplateFieldSelect(this.form.templateFreshnessThreshold);">
			<? echo $value_flag[2]; ?>
		</td>
	</tr>
	<tr>
		<td>Event_handler :</td>
		<td class="text10b">
		<select name="stm[command_command_id2]" id="templateEventHandler">
			<option></option>
		<?
			if (isset($commands))
				foreach ($commands as $cmd)	{
					if (!strstr($cmd->get_name(), "check_graph") && $cmd->get_id() == $services[$stm_id]->get_event_handler())
						echo "<option value='" . $cmd->get_id() . "' selected>" . $cmd->get_name() . "</option>";
					else if (!strstr($cmd->get_name(), "check_graph") && !strcmp($cmd->get_type(), "2"))
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
			<input type="text" name="stm[command_command_id2_arg]" value="<? echo str_replace("\"","&#34;",$services[$stm_id]->get_event_handler_arg()); ?>">
			<img src="./img/info.gif" ONMOUSEOVER="var sel = document.forms['ChangeServiceTemplateModel'].elements['templateEventHandler'].options[document.forms['ChangeServiceTemplateModel'].elements['templateEventHandler'].options.selectedIndex].value; command = commands_arg(sel); montre_legende(command[1], command[0]);" ONMOUSEOUT="cache_legende();">
		</td>
	</tr>
	<tr>
		<td>Event_handler enabled :</td>
		<td class="text10b">
		<input name="stm[service_event_handler_enabled]" type="radio" value="1" <? if ($services[$stm_id]->get_event_handler_enabled() == 1) echo "Checked"; ?>> Yes -
		<input name="stm[service_event_handler_enabled]" type="radio" value="3" <? if ($services[$stm_id]->get_event_handler_enabled() == 3) echo "Checked"; ?> > No -
		<input name="stm[service_event_handler_enabled]" type="radio" value="2" <? if ($services[$stm_id]->get_event_handler_enabled() == 2) echo "Checked"; ?> > Nothing
		</td>
	</tr>
	<tr>
		<td>Low_flap_threshold :</td>
		<td class="text10b">
			<input size="5" type="text" id="templateLowFlapThreshold" name="stm[service_low_flap_threshold]" value="
			<?
				if ($services[$stm_id]->get_low_flap_threshold())
					echo preg_replace("/(99999)/", "0", $services[$stm_id]->get_low_flap_threshold());
			?>" <? if (!$services[$stm_id]->get_low_flap_threshold()) echo "disabled"; ?>> %
			&nbsp;&nbsp;<input type="checkbox" name="lftNothingBox" <? if (!$services[$stm_id]->get_low_flap_threshold()) echo "checked"; ?>  OnClick="enabledTemplateFieldSelect(this.form.templateLowFlapThreshold);">
			<? echo $value_flag[2]; ?>
		</td>
	</tr>
	<tr>
		<td>High_flap_threshold :</td>
		<td class="text10b">
			<input size="5" type="text" id="templateHighFlapThreshold" name="stm[service_high_flap_threshold]" value="
			<?
				if ($services[$stm_id]->get_high_flap_threshold())
					echo preg_replace("/(99999)/", "0", $services[$stm_id]->get_high_flap_threshold());
			?>" <? if (!$services[$stm_id]->get_high_flap_threshold()) echo "disabled"; ?>> %
			&nbsp;&nbsp;<input type="checkbox" name="hftNothingBox" <? if (!$services[$stm_id]->get_high_flap_threshold()) echo "checked"; ?>  OnClick="enabledTemplateFieldSelect(this.form.templateHighFlapThreshold);">
			<? echo $value_flag[2]; ?>
		</td>
	</tr>
	<tr>
		<td>Flap_detection_enabled :</td>
		<td class="text10b">
		<input name="stm[service_flap_detection_enabled]" type="radio" value="1" <? if ($services[$stm_id]->get_flap_detection_enabled() == 1) echo "Checked"; ?>> Yes -
		<input name="stm[service_flap_detection_enabled]" type="radio" value="3" <? if ($services[$stm_id]->get_flap_detection_enabled() == 3) echo "Checked"; ?> > No -
		<input name="stm[service_flap_detection_enabled]" type="radio" value="2" <? if ($services[$stm_id]->get_flap_detection_enabled() == 2) echo "Checked"; ?> > Nothing
		</td>
	</tr>
	<tr>
		<td>Process_perf_data :</td>
		<td class="text10b">
		<input name="stm[service_process_perf_data]" type="radio" value="1" <? if ($services[$stm_id]->get_process_perf_data() == 1) echo "Checked"; ?>> Yes -
		<input name="stm[service_process_perf_data]" type="radio" value="3" <? if ($services[$stm_id]->get_process_perf_data() == 3) echo "Checked"; ?> > No -
		<input name="stm[service_process_perf_data]" type="radio" value="2" <? if ($services[$stm_id]->get_process_perf_data() == 2) echo "Checked"; ?> > Nothing
		</td>
	</tr>
	<tr>
		<td>Retain_status_information :</td>
		<td class="text10b">
		<input name="stm[service_retain_status_information]" type="radio" value="1" <? if ($services[$stm_id]->get_retain_status_information() == 1) echo "Checked"; ?>> Yes -
		<input name="stm[service_retain_status_information]" type="radio" value="3" <? if ($services[$stm_id]->get_retain_status_information() == 3) echo "Checked"; ?> > No -
		<input name="stm[service_retain_status_information]" type="radio" value="2" <? if ($services[$stm_id]->get_retain_status_information() == 2) echo "Checked"; ?> > Nothing </td>
	</tr>
	<tr>
		<td style="white-space: nowrap;">Retain_nonstatus_information :</td>
		<td class="text10b" style="white-space: nowrap;">
		<input name="stm[service_retain_nonstatus_information]" type="radio" value="1" <? if ($services[$stm_id]->get_retain_nonstatus_information() == 1) echo "Checked"; ?>> Yes -
		<input name="stm[service_retain_nonstatus_information]" type="radio" value="3" <? if ($services[$stm_id]->get_retain_nonstatus_information() == 3) echo "Checked"; ?> > No -
		<input name="stm[service_retain_nonstatus_information]" type="radio" value="2" <? if ($services[$stm_id]->get_retain_nonstatus_information() == 2) echo "Checked"; ?> > Nothing </td>
	</tr>
	<tr>
		<td>Notification_interval :</td>
		<td class="text10b">
			<input size="5" type="text" name="stm[service_notification_interval]" value="<? echo preg_replace("/(99999)/", "0", $services[$stm_id]->get_notification_interval()); ?>"> <? echo " * ".$oreon->Nagioscfg->get_interval_length()." ".$lang["time_sec"]; ?>
		</td>
	</tr>
	<tr>
		<td>Notification_period :</td>
		<td class="text10b">
		<select name="stm[timeperiod_tp_id2]">
			<option></option>
		<?
			if (isset($timePeriods))
				foreach ($timePeriods as $tp)	{
					if ($tp->get_id() == $services[$stm_id]->get_notification_period())
						echo "<option value='" . $tp->get_id() . "' selected>" . $tp->get_name() . "</option>";
					else
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
		<?
			if ($services[$stm_id]->get_notification_options()){
				$option_not = array();
				$tab = split(",", $services[$stm_id]->get_notification_options());
				for ($i = 0; $i != 4; $i++)
					if (isset($tab[$i]))
						$option_not[$tab[$i]] = $tab[$i];
			}											?>
		<input ONMOUSEOVER="montre_legende('Warning', '');" ONMOUSEOUT="cache_legende();"  name="stm[service_notification_options_w]" type="checkbox" value="w" <? if (isset($option_not["w"]) && strcmp($option_not["w"], "")) print "Checked";?>> w -
		<input ONMOUSEOVER="montre_legende('Unknown', '');" ONMOUSEOUT="cache_legende();"  name="stm[service_notification_options_u]" type="checkbox" value="u" <? if (isset($option_not["u"]) && strcmp($option_not["u"], "")) print "Checked";?>> u -
		<input ONMOUSEOVER="montre_legende('Critical', '');" ONMOUSEOUT="cache_legende();"  name="stm[service_notification_options_c]" type="checkbox" value="c" <? if (isset($option_not["c"]) && strcmp($option_not["c"], "")) print "Checked";?>> c
		<input ONMOUSEOVER="montre_legende('Recovery', '');" ONMOUSEOUT="cache_legende();"  name="stm[service_notification_options_r]" type="checkbox" value="r" <? if (isset($option_not["r"]) && strcmp($option_not["r"], "")) print "Checked";?>> r
	</tr>
	<tr>
		<td>Notification_enabled :</td>
		<td class="text10b">
		<input name="stm[service_notification_enabled]" type="radio" value="1" <? if ($services[$stm_id]->get_notification_enabled() == 1) echo "Checked"; ?>> Yes -
		<input name="stm[service_notification_enabled]" type="radio" value="3" <? if ($services[$stm_id]->get_notification_enabled() == 3) echo "Checked"; ?> > No -
		<input name="stm[service_notification_enabled]" type="radio" value="2" <? if ($services[$stm_id]->get_notification_enabled() == 2) echo "Checked"; ?> > Nothing </td>
	</tr>
	<tr>
		<td colspan="2">
			<div class="text10b" align="center">
				Contact Groups
			</div>
			<table border="0" align="center">
				<tr>
					<td align="left" style="padding: 3px;">
						<select name="selectCGBase" size="8" multiple>
						<?
							if (isset($contactGroups))	{
								foreach ($contactGroups as $contactGroup)	{
									if (!array_key_exists($contactGroup->get_id(), $services[$stm_id]->contactGroups))
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
						<select id="selectCG" name="selectCG[]" size="8" multiple>
						<?
						if (isset($services[$stm_id]->contactGroups))
							foreach ($services[$stm_id]->contactGroups as $existing_cg)	{
								echo "<option value='".$existing_cg->get_id()."'>".$existing_cg->get_name()."</option>";
								unset($existing_cg);
							}
						?>
						</select>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>Stalking_options :</td>
		<td class="text10b">
		<?
			$option_sta = array();
			if ($services[$stm_id]->get_stalking_options()){
				$tab = split(",", $services[$stm_id]->get_stalking_options());
				for ($i = 0; $i != 4; $i++){
					if (isset($tab[$i]))
						$option_sta[$tab[$i]] = $tab[$i];
				}
			}
		?>
		<input ONMOUSEOVER="montre_legende('Ok', '');" ONMOUSEOUT="cache_legende();"  name="stm[service_stalking_options_o]" type="checkbox" value="o" <? if (isset($option_sta["o"]) && strcmp($option_sta["o"], "")) print "Checked";?>> o -
		<input ONMOUSEOVER="montre_legende('Warning', '');" ONMOUSEOUT="cache_legende();"  name="stm[service_stalking_options_w]" type="checkbox" value="w" <? if (isset($option_sta["w"]) && strcmp($option_sta["w"], "")) print "Checked";?>> w -
		<input ONMOUSEOVER="montre_legende('Unknown', '');" ONMOUSEOUT="cache_legende();"  name="stm[service_stalking_options_u]" type="checkbox" value="u" <? if (isset($option_sta["u"]) && strcmp($option_sta["u"], "")) print "Checked";?>> u
		<input ONMOUSEOVER="montre_legende('Critical', '');" ONMOUSEOUT="cache_legende();"  name="stm[service_stalking_options_c]" type="checkbox" value="c" <? if (isset($option_sta["c"]) && strcmp($option_sta["c"], "")) print "Checked";?>> c
		</td>
	</tr>
	<tr>
		<td valign="top">Comment :</td>
		<td class="text10b">
			<textarea name="stm[service_comment]" cols="25" rows="4"><? echo preg_replace("/(#BLANK#)/", "", $services[$stm_id]->get_comment()); ?></textarea>
		</td>
	</tr>
	<tr>
		<td align="left">
			<? echo $lang['required']; ?>&nbsp;&nbsp;
		</td>
		<td align="center">
			<input type="hidden" name="stm[stm_id]" value="<? echo $stm_id ?>">
			<input type="submit" name="ChangeSTM" value="<? echo $lang['save']; ?>" onClick="selectAll(this.form.selectCG); selectAll(this.form.selectSG);">
		</td>
	</tr>
</table>
</form>