<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/?>
<form name="ChangeHostForm" action="" method="post" enctype="multipart/form-data">
<table cellpadding="0" cellspacing="3" width="350" align='center'>
	<tr>
		<td width="50%">Name :<font color="red">*</font></td>
		<td class="text10b"><input type="text" name="htm[host_name]" value="<? echo $hosts[$htm_id]->get_name(); ?>"></td>
	</tr>
	<tr>
		<td>Alias :</td>
		<td class="text10b"><input type="text" name="htm[host_alias]" value="<? echo $hosts[$htm_id]->get_alias(); ?>"></td>
	</tr>
	<tr>
		<td>Address :</td>
		<td class="text10b"><input type="text" name="htm[host_address]" value="<? echo $hosts[$htm_id]->get_address(); ?>"></td>
	</tr>
	<tr>
		<td colspan="2" align="center">
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
								if ($host->get_register())
									if (!array_key_exists($host->get_id(), $hosts[$htm_id]->parents))
										echo "<option value='".$host->get_id()."'>".$host->get_name()."</option>";
								unset($host);
							}
						?>
						</select>
					</td>
					<td style="padding-left: 5px; padding-right: 5px;" valign="middle" align="center">
						<input type="button" name="add" value="<? echo $lang['add']; ?>" onClick="Moove(this.form.selectHostParentBase,this.form.selectHostParent);"><br><br><br>
						<input type="button" name="remove" value="<? echo $lang['delete']; ?>" onClick="Moove(this.form.selectHostParent,this.form.selectHostParentBase);">
					</td>
					<td>
						<select id="selectHostParent" name="selectHostParent[]" size="8" multiple>
						<?
						foreach ($hosts[$htm_id]->parents as $existing_hosts)	{
							echo "<option value='".$existing_hosts->get_id()."'>".$existing_hosts->get_name()."</option>";
							unset($existing_hosts);
						}
						?>
						</select>
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
								if (!array_key_exists($hostGroup->get_id(), $hosts[$htm_id]->hostGroups))
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
						<?	foreach ($hosts[$htm_id]->hostGroups as $existing_host)	{
								echo "<option value='".$existing_host->get_id()."'>".$existing_host->get_name()."</option>";
								unset($existing_host);
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
			<select name="htm[command_command_id]">
			<?
			echo "<option value=''></option>";
			foreach ($commands as $cmd)	{
				if (!strstr($cmd->get_name(), "check_graph") && !strcmp($cmd->get_type(), "2"))	{
					echo "<option value='".$cmd->get_id()."'";
					if ($cmd->get_id() == $hosts[$htm_id]->get_check_command())
						echo " selected";
					echo ">".$cmd->get_name()."</option>";
				}
				unset($cmd);
			}
			?>
			</select>
		</td>
	</tr>
	<tr>
		<td>Max_check_attempts :</td>
		<td class="text10b"><input size="5" type="text" name="htm[host_max_check_attempts]" value="<? echo $hosts[$htm_id]->get_max_check_attempts(); ?>"></td>
	</tr>
	<?	if (!strcmp("1", $oreon->user->get_version()))	{	?>
	<tr>
		<td>Checks_enabled :</td>
		<td class="text10b">
		<input name="htm[host_check_enabled]" type="radio" value="1" <? if ($hosts[$htm_id]->get_checks_enabled() == 1) echo "Checked"; ?>> Yes -
		<input name="htm[host_check_enabled]" type="radio" value="3" <? if ($hosts[$htm_id]->get_checks_enabled() == 3) echo "Checked"; ?> > No -
		<input name="htm[host_check_enabled]" type="radio" value="2" <? if ($hosts[$htm_id]->get_checks_enabled() == 2) echo "Checked"; ?> > Nothing
		</td>
	</tr>
	<? }	if (!strcmp("2", $oreon->user->get_version()))	{	?>
	<tr>
		<td>Check_interval :</td>
		<td class="text10b"><input size="5" type="text" name="htm[host_check_interval]" value="<? echo preg_replace("/(99999)/", "0", $hosts[$htm_id]->get_check_interval()); ?>"> <? echo " * ".$oreon->Nagioscfg->get_interval_length()." ".$lang["time_sec"]; ?></td>
	</tr>
	<tr>
		<td>Active_checks_enabled :</td>
		<td class="text10b">
		<input name="htm[host_active_checks_enabled]" type="radio" value="1" <? if ($hosts[$htm_id]->get_active_checks_enabled() == 1) echo "Checked"; ?>> Yes -
		<input name="htm[host_active_checks_enabled]" type="radio" value="3" <? if ($hosts[$htm_id]->get_active_checks_enabled() == 3) echo "Checked"; ?>> No -
		<input name="htm[host_active_checks_enabled]" type="radio" value="2" <? if ($hosts[$htm_id]->get_active_checks_enabled() == 2) echo "Checked"; ?> > Nothing
		</td>
	</tr>
	<tr>
		<td>Passive_checks_enabled :</td>
		<td class="text10b">
		<input name="htm[host_passive_checks_enabled]" type="radio" value="1" <? if ($hosts[$htm_id]->get_passive_checks_enabled() == 1) echo "Checked"; ?>> Yes -
		<input name="htm[host_passive_checks_enabled]" type="radio" value="3" <? if ($hosts[$htm_id]->get_passive_checks_enabled() == 3) echo "Checked"; ?> > No -
		<input name="htm[host_passive_checks_enabled]" type="radio" value="2" <? if ($hosts[$htm_id]->get_passive_checks_enabled() == 2) echo "Checked"; ?> > Nothing
		</td>
	</tr>
	<tr>
		<td>Check_period :</td>
		<td class="text10b">
		<select name="htm[timeperiod_tp_id]">
		<?
			if (isset($timePeriods))
				foreach ($timePeriods as $tp)	{
					echo "<option value='". $tp->get_id()."'";
					if ($tp->get_id() == $hosts[$htm_id]->get_check_period())
						echo " selected";
					echo ">".$tp->get_name()."</option>";
					unset($tp);
				}
		?>
		</select>
		</td>
	</tr>
	<tr>
		<td>Obsess_over_host :</td>
		<td class="text10b">
		<input name="htm[host_obsess_over_host]" type="radio" value="1" <? if ($hosts[$htm_id]->get_obsess_over_host() == 1) echo "Checked"; ?>> Yes -
		<input name="htm[host_obsess_over_host]" type="radio" value="3" <? if ($hosts[$htm_id]->get_obsess_over_host() == 3) echo "Checked"; ?> > No -
		<input name="htm[host_obsess_over_host]" type="radio" value="2" <? if ($hosts[$htm_id]->get_obsess_over_host() == 2) echo "Checked"; ?> > Nothing
		</td>
	</tr>
	<tr>
		<td>Check_freshness :</td>
		<td class="text10b">
		<input name="htm[host_check_freshness]" type="radio" value="1" <? if ($hosts[$htm_id]->get_check_freshness() == 1) echo "Checked"; ?>> Yes -
		<input name="htm[host_check_freshness]" type="radio" value="3" <? if ($hosts[$htm_id]->get_check_freshness() == 3) echo "Checked"; ?> > No -
		<input name="htm[host_check_freshness]" type="radio" value="2" <? if ($hosts[$htm_id]->get_check_freshness() == 2) echo "Checked"; ?> > Nothing
		</td>
	</tr>
	<tr>
		<td>Freshness_threshold :</td>
		<td class="text10b">
			<input size="5" type="text" id="templateFreshnessThreshold" name="htm[host_freshness_threshold]" value="
			<?
				if ($hosts[$htm_id]->get_freshness_threshold())
					echo preg_replace("/(99999)/", "0", $hosts[$htm_id]->get_freshness_threshold());
			?>" <? if (!$hosts[$htm_id]->get_freshness_threshold()) echo "disabled"; ?>> <? echo $lang["time_sec"]; ?>
			&nbsp;&nbsp;<input type="checkbox" name="ftNothingBox" <? if (!$hosts[$htm_id]->get_freshness_threshold()) echo "checked"; ?>  OnClick="enabledTemplateFieldSelect(this.form.templateFreshnessThreshold);">
		</td>
	</tr>
	<?	}	?>
	<tr>
		<td>Event_handler_enabled :</td>
		<td class="text10b">
		<input name="htm[host_event_handler_enabled]" type="radio" value="1" <? if ($hosts[$htm_id]->get_event_handler_enabled() == 1) echo "Checked"; ?>> Yes -
		<input name="htm[host_event_handler_enabled]" type="radio" value="3" <? if ($hosts[$htm_id]->get_event_handler_enabled() == 3) echo "Checked"; ?> > No -
		<input name="htm[host_event_handler_enabled]" type="radio" value="2" <? if ($hosts[$htm_id]->get_event_handler_enabled() == 2) echo "Checked"; ?> > Nothing
		</td>
	</tr>
	<tr>
		<td>Event_handler :</td>
		<td class="text10b">
			<select name="htm[command_command_id2]" id="templateEventHandler">
			 <?
				echo "<option value=''></option>";
				if (isset($commands))
				foreach ($commands as $cmd)	{
					if (!strstr($cmd->get_name(), "check_graph") && $cmd->get_type() == 2)	{
						echo "<option value='".$cmd->get_id()."'";
						if ($cmd->get_id() == $hosts[$htm_id]->get_event_handler())
							echo " selected";
						echo ">".$cmd->get_name()."</option>";
					}
					unset($cmd);
				}
			?>
			</select>
		</td>
	</tr>
	<tr>
		<td>Low_flap_threshold :</td>
		<td class="text10b">
			<input size="5" type="text" id="templateLowFlapThreshold" name="htm[host_low_flap_threshold]" value="
			<?
				if ($hosts[$htm_id]->get_low_flap_threshold())
					echo preg_replace("/(99999)/", "0", $hosts[$htm_id]->get_low_flap_threshold());
			?>" <? if (!$hosts[$htm_id]->get_low_flap_threshold()) echo "disabled"; ?>> %
			&nbsp;&nbsp;<input type="checkbox" name="lftNothingBox" <? if (!$hosts[$htm_id]->get_low_flap_threshold()) echo "checked"; ?>  OnClick="enabledTemplateFieldSelect(this.form.templateLowFlapThreshold);">
			<? echo $value_flag[2]; ?>
		</td>
	</tr>
	<tr>
		<td>High_flap_threshold :</td>
		<td class="text10b">
			<input size="5" type="text" id="templateHighFlapThreshold" name="htm[host_high_flap_threshold]" value="
			<?
				if ($hosts[$htm_id]->get_high_flap_threshold())
					echo preg_replace("/(99999)/", "0", $hosts[$htm_id]->get_high_flap_threshold());
			?>" <? if (!$hosts[$htm_id]->get_high_flap_threshold()) echo "disabled"; ?>> %
			&nbsp;&nbsp;<input type="checkbox" name="hftNothingBox" <? if (!$hosts[$htm_id]->get_high_flap_threshold()) echo "checked"; ?>  OnClick="enabledTemplateFieldSelect(this.form.templateHighFlapThreshold);">
			<? echo $value_flag[2]; ?>
		</td>
	</tr>
	<tr>
		<td>Flap_detection_enabled :</td>
		<td class="text10b">
		<input name="htm[host_flap_detection_enabled]" type="radio" value="1" <? if ($hosts[$htm_id]->get_flap_detection_enabled() == 1) echo "Checked"; ?>> Yes -
		<input name="htm[host_flap_detection_enabled]" type="radio" value="3" <? if ($hosts[$htm_id]->get_flap_detection_enabled() == 3) echo "Checked"; ?> > No -
		<input name="htm[host_flap_detection_enabled]" type="radio" value="2" <? if ($hosts[$htm_id]->get_flap_detection_enabled()== 2) echo "Checked"; ?> > Nothing
		</td>
	</tr>
	<tr>
		<td>Process_perf_data :</td>
		<td class="text10b">
		<input name="htm[host_process_perf_data]" type="radio" value="1" <? if ($hosts[$htm_id]->get_process_perf_data() == 1) echo "Checked"; ?>> Yes -
		<input name="htm[host_process_perf_data]" type="radio" value="3" <? if ($hosts[$htm_id]->get_process_perf_data() == 3) echo "Checked"; ?> > No -
		<input name="htm[host_process_perf_data]" type="radio" value="2" <? if ($hosts[$htm_id]->get_process_perf_data() == 2) echo "Checked"; ?> > Nothing
		</td>
	</tr>
	<tr>
		<td>Retain_status_information :</td>
		<td class="text10b">
		<input name="htm[host_retain_status_information]" type="radio" value="1" <? if ($hosts[$htm_id]->get_retain_status_information() == 1) echo "Checked"; ?>> Yes -
		<input name="htm[host_retain_status_information]" type="radio" value="3" <? if ($hosts[$htm_id]->get_retain_status_information() == 3) echo "Checked"; ?> > No -
		<input name="htm[host_retain_status_information]" type="radio" value="2" <? if ($hosts[$htm_id]->get_retain_status_information() == 2) echo "Checked"; ?> > Nothing
		</td>
	</tr>
	<tr>
		<td style="white-space: nowrap;">Retain_nonstatus_information :</td>
		<td  style="white-space: nowrap;" class="text10b">
		<input name="htm[host_retain_nonstatus_information]" type="radio" value="1" <? if ($hosts[$htm_id]->get_retain_nonstatus_information() == 1) echo "Checked"; ?>> Yes -
		<input name="htm[host_retain_nonstatus_information]" type="radio" value="3" <? if ($hosts[$htm_id]->get_retain_nonstatus_information() == 3) echo "Checked"; ?> > No -
		<input name="htm[host_retain_nonstatus_information]" type="radio" value="2" <? if ($hosts[$htm_id]->get_retain_nonstatus_information() == 2) echo "Checked"; ?> > Nothing
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
									if (!array_key_exists($contactGroup->get_id(), $hosts[$htm_id]->contactgroups))
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
						<?	foreach ($hosts[$htm_id]->contactgroups as $existing_cg)	{
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
	<?	}	?>
	<tr>
		<td>Notification_interval :</td>
		<td class="text10b"><input size="5" type="text" name="htm[host_notification_interval]" value="<? echo preg_replace("/(99999)/", "0", $hosts[$htm_id]->get_notification_interval()); ?>"> <? echo " * ".$oreon->Nagioscfg->get_interval_length()." ".$lang["time_sec"]; ?></td>
	</tr>
	<tr>
		<td>Notification_period :</td>
		<td class="text10b" nowrap>
			<select name="htm[timeperiod_tp_id2]">
			<?
				if (isset($timePeriods))
					foreach ($timePeriods as $tp)	{
						echo "<option value='". $tp->get_id()."'";
						if ($tp->get_id() == $hosts[$htm_id]->get_notification_period())
							echo " selected";
						echo ">".$tp->get_name()."</option>";
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
		if ($hosts[$htm_id]->get_notification_options()){
			$option_not = array();
			$tab = split(",", $hosts[$htm_id]->get_notification_options());
			for ($i = 0; $i != 3; $i++){
				if (isset($tab[$i]))
					$option_not[$tab[$i]] = $tab[$i];
			}
		}
		?>
		<input ONMOUSEOVER="montre_legende('Down', '');" ONMOUSEOUT="cache_legende();"  name="htm[host_notification_options_d]" type="checkbox" value="d" <? if (isset($option_not["d"])) print "Checked";?>> d -
		<input ONMOUSEOVER="montre_legende('Up', '');" ONMOUSEOUT="cache_legende();"  name="htm[host_notification_options_u]" type="checkbox" value="u" <? if (isset($option_not["u"])) print "Checked";?>> u -
		<input ONMOUSEOVER="montre_legende('Recovery', '');" ONMOUSEOUT="cache_legende();"  name="htm[host_notification_options_r]" type="checkbox" value="r" <? if (isset($option_not["r"])) print "Checked";?>> r
		</td>
	</tr>
	<tr>
		<td>Notifications_enabled :</td>
		<td class="text10b">
		<input name="htm[host_notifications_enabled]" type="radio" value="1" <? if ($hosts[$htm_id]->get_notifications_enabled() == 1) echo "Checked"; ?>> Yes -
		<input name="htm[host_notifications_enabled]" type="radio" value="3" <? if ($hosts[$htm_id]->get_notifications_enabled() == 3) echo "Checked"; ?> > No -
		<input name="htm[host_notifications_enabled]" type="radio" value="2" <? if ($hosts[$htm_id]->get_notifications_enabled() == 2) echo "Checked"; ?> > Nothing
		</td>
	</tr>
	<tr>
		<td>Stalking_options :</td>
		<td class="text10b">
		<?
		if ($hosts[$htm_id]->get_stalking_options()){
			$option_sta = array();
			$tab = split(",", $hosts[$htm_id]->get_stalking_options());
			for ($i = 0; $i != 3; $i++){
				if (isset($tab[$i]))
					$option_sta[$tab[$i]] = $tab[$i];
			}
		}
		?>
		<input ONMOUSEOVER="montre_legende('Ok/Up', '');" ONMOUSEOUT="cache_legende();"  name="htm[host_stalking_options_o]" type="checkbox" value="o" <? if (isset($option_sta["o"])) print "Checked";?>> o -
		<input ONMOUSEOVER="montre_legende('Down', '');" ONMOUSEOUT="cache_legende();"  name="htm[host_stalking_options_d]" type="checkbox" value="d" <? if (isset($option_sta["d"])) print "Checked";?>> d -
		<input ONMOUSEOVER="montre_legende('Unreachable', '');" ONMOUSEOUT="cache_legende();"  name="htm[host_stalking_options_u]" type="checkbox" value="u" <? if (isset($option_sta["u"])) print "Checked";?>> u
		</td>
	</tr>
	<tr>
		<td valign="top">Comment :</td>
		<td class="text10b">
			<textarea name="htm[host_comment]" cols="25" rows="4"><? echo preg_replace("/(#BLANK#)/", "", $hosts[$htm_id]->get_comment()); ?></textarea>
		</td>
	</tr>
	<tr>
		<td align="center" colspan="2">
			<input type="hidden" name="htm[htm_id]" value="<? echo $htm_id ?>">
			<input type="submit" name="ChangeHTM" value="<? echo $lang['save']; ?>" onClick="selectAll(this.form.selectHostParent); selectAll(this.form.selectHostGroup); selectAll(this.form.selectContactGroup);">
		</td>
	</tr>
</table>
</form>