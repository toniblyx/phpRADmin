<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/?>
<td align="left" style="padding-left: 20px;" valign="top">
	<?
	if (isset($_POST["stm_id"]) && strcmp($_POST["stm_id"], NULL))
		$stm_id = $_POST["stm_id"];
	else
		unset ($_POST["stm_id"]);
	if (isset($_POST["sv"]))
		$sv = $_POST["sv"]; ?>
	<form action="" method="post" name="AddServiceForm">
		<input name="o" type="hidden" value="asf">
		<input name="id" type="hidden" value="<? print $_GET['id']; ?>">
	<table border="0" cellpadding="0" cellspacing="0" align="center">
		<tr>
			<td class="tabTableTitle"><? echo $lang['add']. " ".$lang['s']; ?></td>
		</tr>
		<tr>
			<td class="tabTableForTab">
				<table border="0" cellpadding="3" cellspacing="0" align="center">
				<tr>
					<td style="padding-top:10px;padding-bottom:10px;" class="text11b" colspan="2">
						Informations : port = <? print $_GET["port"]; ?>; service type = <? print $oreon->AutoDetect[$_GET["id"]]->name_list[$_GET["ids"]]; ?><br>
					</td>							
				</tr>
				<tr>
					<td>HostGroup name :<font color='red'>*</font></td>
					<td class="text10b">
					<select name="sv[hostgroup_id]" id="hostGroupDis" onChange="if (!this.form['hostGroupDis'].options[this.form['hostGroupDis'].selectedIndex].value)	this.form['hostDis'].disabled = false; else this.form['hostDis'].disabled = true;">
						<option></option>
					<?
						foreach ($hostGroups as $hostGroup)	{
							echo "<option value='" . $hostGroup->get_id() . "'";
							if (isset($_POST["sv"]) && isset($sv["hostgroup_id"]) && $sv["hostgroup_id"]== $hostGroup->get_id())
								echo " selected";
							echo ">" . $hostGroup->get_name() . "</option>";
							unset($hostGroup);
						}
					?>
					</select>
					</td>
				</tr>
				<tr>
					<td>Host name :<font color='red'>*</font></td>
					<td class="text10b">
					<select name="sv[host_host_id]" id="hostDis" onChange="if (!this.form['hostDis'].options[this.form['hostDis'].selectedIndex].value)	this.form['hostGroupDis'].disabled = false; else 	this.form['hostGroupDis'].disabled = true;">
						<option></option>
					<?
						foreach ($hosts as $host)	{
							if ($host->get_register())	{	
								echo "<option value='" . $host->get_id() . "'";
								if (isset($_POST["sv"]) && isset($sv["host_host_id"]) && $sv["host_host_id"] == $host->get_id())
									echo " selected";
								echo ">" . $host->get_name() . "</option>";
							}
							unset($host);
						}
					?>
					</select>
					</td>
				</tr>
				<? if (isset($stms) && count($stms)) { ?>
				<tr>
					<td class="text10b" style="white-space: nowrap;"><? echo $lang['stm_use']; ?> :</td>
					<td>
						<select name="stm_id" onChange="this.form.submit();">
							<option value=""></option>
							<?
							if (isset($stms))
								foreach ($stms as $stm)	{
									echo "<option value='" .$stm->get_id(). "'";
									if (isset($_POST["stm_id"]) && ($stm_id == $stm->get_id()))
										echo " selected";
									echo ">" .$services[$stm->get_id()]->get_description(). "</option>";
									unset($stm);
								}
							?>
						</select>
					</td>
				</tr>
				<? } ?>
				<tr>
					<td>Description :<font color='red'>*</font></td>
					<td class="text10b">
						<?
						$desc = NULL;
						if (isset($_POST["stm_id"]))	{
							if ($services[$stm_id]->get_description());
								$desc = $services[$stm_id]->get_description();
						} else
							$desc = $oreon->AutoDetect[$_GET["id"]]->name_list[$_GET["ids"]];
						?>
						<input type="text" name="sv[service_description]" value="<? echo str_replace("STemplate_", "", $desc); ?>" maxlength="63" size="25">
					</td>
				</tr>
				<tr>
					<td>Is Volatile :</td>
					<td class="text10b">
					<?
					$iv = NULL;
					if (isset($_POST["stm_id"]))
						if ($services[$stm_id]->get_is_volatile())
							$iv = $services[$stm_id]->get_is_volatile();
					if ($iv)	{ ?>
						<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateIsVolatile, '<? echo $iv; ?>', '');">
					<? } ?>
					<input name="sv[service_is_volatile]" type="radio" id="templateIsVolatile" value="1" <? if (isset($_POST["stm_id"])) if ($iv == 1) echo "checked"; ?> <? if ($iv) echo "disabled";?>> Yes - 
					<input name="sv[service_is_volatile]" type="radio" id="templateIsVolatile" value="3" <? if (isset($_POST["stm_id"])) if ($iv == 3) echo "checked"; ?> <? if ($iv) echo "disabled";?>> No - 
					<input name="sv[service_is_volatile]" type="radio" id="templateIsVolatile" value="2" <? if (isset($_POST["stm_id"])) { if ($iv == 2) echo "checked";} else echo "checked";?> <? if ($iv) echo "disabled";?>> Nothing
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<div align="center" class="text10b">
							Service Groups
							<?
							$sgs = NULL;
							if (isset($_POST["stm_id"]))
								if (isset($services[$stm_id]->serviceGroups))
									$sgs = & $services[$stm_id]->serviceGroups;
							if (count($sgs))	{ ?>
								<input type="checkbox" onClick="enabledTemplateFieldSelect(this.form.templateSGBase);enabledTemplateFieldSelect(this.form.selectSG);">
							<? } ?>
						</div>
						<table border="0" align="center">
							<tr>
								<td align="left" style="padding: 3px;">
									<select name="selectSGBase" id="templateSGBase" size="8" <? if (count($sgs)) echo "disabled";?> multiple>
									<?
										if (isset($serviceGroups))
											foreach ($serviceGroups as $serviceGroup)	{
												if (isset($_POST["stm_id"]))	{
													if (!array_key_exists($serviceGroup->get_id(), $services[$stm_id]->serviceGroups))
														echo "<option value='".$serviceGroup->get_id()."'>".$serviceGroup->get_name()."</option>";
												}
												else
													echo "<option value='".$serviceGroup->get_id()."'>".$serviceGroup->get_name()."</option>";
												unset($serviceGroup);
											}
									?>
									</select>
								</td>
								<td style="padding-left: 5px; padding-right: 5px;" valign="middle" align="center">
									<input type="button" name="add" value="<? echo $lang['add']; ?>" onClick="Moove(this.form.selectSGBase,this.form.selectSG);"><br><br><br>
									<input type="button" name="remove" value="<? echo $lang['delete']; ?>" onClick="Moove(this.form.selectSG,this.form.selectSGBase);">
								</td>
								<td>
									<select id="selectSG" name="selectSG[]" size="8" <? if (count($sgs)) echo "disabled";?> multiple>
									<?
										if (isset($_POST["stm_id"]))
											if (isset($services[$stm_id]->serviceGroups))	
												foreach ($services[$stm_id]->serviceGroups as $existing_serviceGroup)	{
													echo "<option value='".$existing_serviceGroup->get_id()."'>".$existing_serviceGroup->get_name()."</option>";
													unset($existing_serviceGroup);
												}
									?>
									</select>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>Check_command :<font color='red'>*</font></td>
					<td class="text10b" style="white-space: nowrap;">
					<?
					$cc = NULL;
					if (isset($_POST["stm_id"]))
						$cc = $services[$stm_id]->get_check_command();
					if ($cc)	{ ?>
						<input type="checkbox" name="templateCheckCommandBox" onClick="enabledTemplateField(this.form.templateCheckCommand, <? echo $cc; ?>, '');">
					<? } ?>
					<select name="sv[command_command_id]" id="templateCheckCommand" <? if ($cc) echo "disabled"; ?>>
					<?
						if (isset($commands))
							foreach ($commands as $cmd)	{
								if (!strcmp($cmd->get_type(), "2"))	{
									echo "<option value='" . $cmd->get_id() . "'";
									if ($cmd->get_id() == $cc)
										echo " selected";
									echo ">" . $cmd->get_name() . "</option>";
								}
								unset($cmd);
							}
					?>
					</select>
					</td>
				</tr>
				<tr>
					<td>Check_command_arguments :</td>
					<td class="text10b" style="white-space: nowrap;">
						<?
						$cca = NULL;
						if (isset($_POST["stm_id"]))
							$cca = $services[$stm_id]->get_check_command_arg();
						if ($cca)	{ ?>
							<input type="checkbox" name="templateCheckCommandArgumentsBox" onClick="enabledTemplateField(this.form.templateCheckCommandArguments, '<? echo addslashes($cca); ?>', '');">
						<? } ?>
						<input type="text" name="sv[command_command_id_arg]" id="templateCheckCommandArguments" value="<? echo $cca; ?>" <? if ($cca) echo "disabled";?>>
						<img src="./img/info.gif" ONMOUSEOVER="var sel = document.forms['AddServiceForm'].elements['templateCheckCommand'].options[document.forms['AddServiceForm'].elements['templateCheckCommand'].options.selectedIndex].value; command = commands_arg(sel); montre_legende(command[1], command[0]);" ONMOUSEOUT="cache_legende();">
					</td>
				</tr>
				<tr>
					<td>Max_check_attempts :<font color='red'>*</font></td>
					<td class="text10b">
						<?
						$mca = NULL;
						if (isset($_POST["stm_id"]))
							$mca = $services[$stm_id]->get_max_check_attempts();
						if ($mca)	{ ?>
							<input type="checkbox" onClick="enabledTemplateField(this.form.templateMaxCheckAttempts, <? echo $mca; ?>, '');">
						<? } ?>
						<input size="5" type="text" name="sv[service_max_check_attempts]" id="templateMaxCheckAttempts" value="<? echo $mca; ?>" <? if ($mca) echo "disabled";?>>
					</td>
				</tr>
				<tr>
					<td>Normal_check_interval :<font color='red'>*</font></td>
					<td class="text10b">
						<?
						$nci = NULL;
						if (isset($_POST["stm_id"]))
							$nci = $services[$stm_id]->get_normal_check_interval();
						if ($nci)	{ ?>
							<input type="checkbox" onClick="enabledTemplateField(this.form.templateNormalCheckInterval, <? echo $nci; ?>, '');">
						<? } ?>
						<input size="5" type="text" name="sv[service_normal_check_interval]" id="templateNormalCheckInterval" value="<? echo $nci; ?>" <? if ($nci) echo "disabled";?>>							
						* <? echo $oreon->Nagioscfg->interval_length . " " .$lang["time_sec"]; ?>
					</td>
				</tr>
				<tr>
					<td>Retry_check_interval :<font color='red'>*</font></td>
					<td class="text10b">
						<?
						$rci = NULL;
						if (isset($_POST["stm_id"]))
							$rci = $services[$stm_id]->get_retry_check_interval();
						if ($rci)	{ ?>
							<input type="checkbox" onClick="enabledTemplateField(this.form.templateRetryCheckInterval, <? echo $rci; ?>, '');">
						<? } ?>
						<input size="5" type="text" name="sv[service_retry_check_interval]" id="templateRetryCheckInterval" value="<? echo $rci; ?>" <? if ($rci) echo "disabled";?>>
						* <? echo $oreon->Nagioscfg->interval_length . " " .$lang["time_sec"]; ?>
					</td>
				</tr>
				<tr>
					<td>Active_checks_enabled :</td>
					<td class="text10b">
					<?
					$ace = NULL;
					if (isset($_POST["stm_id"]))
						$ace = $services[$stm_id]->get_active_checks_enabled();
					if ($ace)	{ ?>
						<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateActiveChecksEnabled, '<?  echo $ace; ?>', '');">
					<? } ?>
					<input name="sv[service_active_checks_enabled]" type="radio" id="templateActiveChecksEnabled" value="1" <? if (isset($_POST["stm_id"])) if ($ace == 1) echo "checked"; ?> <? if ($ace) echo "disabled"; ?>> Yes - 
					<input name="sv[service_active_checks_enabled]" type="radio" id="templateActiveChecksEnabled" value="3" <? if (isset($_POST["stm_id"])) if ($ace == 3) echo "checked"; ?> <? if ($ace) echo "disabled"; ?>> No - 
					<input name="sv[service_active_checks_enabled]" type="radio" id="templateActiveChecksEnabled" value="2" <? if (isset($_POST["stm_id"])) { if ($ace == 2) echo "checked";} else echo "checked"; ?> <? if ($ace) echo "disabled"; ?>> Nothing 
					</td>
				</tr>
				<tr>
					<td>Passive_checks_enabled :</td>
					<td class="text10b">
					<?
					$pce = NULL;
					if (isset($_POST["stm_id"]))
						$pce = $services[$stm_id]->get_passive_checks_enabled();
					if ($pce)	{ ?>
						<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templatePassiveChecksEnabled, '<? echo $pce; ?>', '');">
					<? } ?>
					<input name="sv[service_passive_checks_enabled]" type="radio" id="templatePassiveChecksEnabled" value="1" <? if (isset($_POST["stm_id"])) if ($pce == 1) echo "checked"; ?> <? if ($pce) echo "disabled";?>> Yes - 
					<input name="sv[service_passive_checks_enabled]" type="radio" id="templatePassiveChecksEnabled" value="3" <? if (isset($_POST["stm_id"])) if ($pce == 3) echo "checked"; ?> <? if ($pce) echo "disabled";?>> No - 
					<input name="sv[service_passive_checks_enabled]" type="radio" id="templatePassiveChecksEnabled" value="2" <? if (isset($_POST["stm_id"])) { if ($pce == 2) echo "checked";} else echo "checked"; ?> <? if ($pce) echo "disabled";?>> Nothing 
					</td>
				</tr>
				<tr>
					<td>Check_period :<font color='red'>*</font></td>
					<td class="text10b">
					<?
					$cp = NULL;
					if (isset($_POST["stm_id"]))
						$cp = $services[$stm_id]->get_check_period();
					if ($cp)	{ ?>
						<input type="checkbox" onClick="enabledTemplateField(this.form.templateCheckPeriod, <? echo $cp; ?>, '');">
					<? } ?>
					<select name="sv[timeperiod_tp_id]" id="templateCheckPeriod" <? if ($cp) echo "disabled";?>>
						<option></option>
					<?
						if (isset($timePeriods))
							foreach ($timePeriods as $tp)	{
								echo "<option value='" . $tp->get_id() . "'";
								if ($tp->get_id() == $cp)
									echo " selected";
								echo ">" . $tp->get_name() . "</option>";
								unset($tp);
							}
					?>
					</select>
					</td>
				</tr>
				<tr>
					<td>Parallelize_check :</td>
					<td class="text10b">
					<?
					$pc = NULL;
					if (isset($_POST["stm_id"]))
						$pc = $services[$stm_id]->get_parallelize_check();
					if ($pc)	{ ?>
						<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateServiceParallelizeCheck, '<? echo $pc; ?>', '');">
					<? } ?>
					<input name="sv[service_parallelize_check]" type="radio" id="templateServiceParallelizeCheck" value="1" <? if (isset($_POST["stm_id"])) if ($pc == 1) echo "checked"; ?> <? if ($pc) echo "disabled";?>> Yes - 
					<input name="sv[service_parallelize_check]" type="radio" id="templateServiceParallelizeCheck" value="3" <? if (isset($_POST["stm_id"])) if ($pc == 3) echo "checked"; ?> <? if ($pc) echo "disabled";?>> No - 
					<input name="sv[service_parallelize_check]" type="radio" id="templateServiceParallelizeCheck" value="2" <? if (isset($_POST["stm_id"])) { if ($pc == 2) echo "checked";} else echo "checked"; ?> <? if ($pc) echo "disabled";?>> Nothing 
					</td>
				</tr>
				<tr>
					<td>Obsess_over_service :</td>
					<td class="text10b">
					<?
					$oos = NULL;
					if (isset($_POST["stm_id"]))
						$oos = $services[$stm_id]->get_obsess_over_service();
					if ($oos)	{ ?>
						<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateObsessOverService, '<? echo $oos; ?>', '');">
					<? } ?>
					<input name="sv[service_obsess_over_service]" type="radio" id="templateObsessOverService" value="1" <? if (isset($_POST["stm_id"])) if ($oos == 1) echo "checked"; ?> <? if ($oos) echo "disabled";?>> Yes - 
					<input name="sv[service_obsess_over_service]" type="radio" id="templateObsessOverService" value="3" <? if (isset($_POST["stm_id"])) if ($oos == 3) echo "checked"; ?> <? if ($oos) echo "disabled";?>> No - 
					<input name="sv[service_obsess_over_service]" type="radio" id="templateObsessOverService" value="2" <? if (isset($_POST["stm_id"])) { if ($oos == 2) echo "checked";} else echo "checked"; ?> <? if ($oos) echo "disabled";?>> Nothing 
					</td>
				</tr>
				<tr>
					<td>Check_freshness :</td>
					<td class="text10b">
					<?
					$cf = NULL;
					if (isset($_POST["stm_id"]))
						$cf = $services[$stm_id]->get_check_freshness();
					if ($cf)	{ ?>
						<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateCheckFreshness, '<? echo $cf; ?>', '');">
					<? } ?>
					<input name="sv[service_check_freshness]" type="radio" id="templateCheckFreshness" value="1" <? if (isset($_POST["stm_id"])) if ($cf == 1) echo "checked"; ?> <? if ($cf) echo "disabled";?>> Yes - 
					<input name="sv[service_check_freshness]" type="radio" id="templateCheckFreshness" value="3" <? if (isset($_POST["stm_id"])) if ($cf == 3) echo "checked"; ?> <? if ($cf) echo "disabled";?>> No - 
					<input name="sv[service_check_freshness]" type="radio" id="templateCheckFreshness" value="2" <? if (isset($_POST["stm_id"])) { if ($cf == 2) echo "checked";} else echo "checked"; ?> <? if ($cf) echo "disabled";?>> Nothing 
					</td>
				</tr>
				<tr>
					<td>Freshness_threshold :</td>
					<td class="text10b">	
					<?
					$ft = NULL;
					if (isset($_POST["stm_id"]))
						$ft = $services[$stm_id]->get_freshness_threshold();
					if ($ft)	{ ?>
						<input type="checkbox" onClick="enabledTemplateFieldSelect(this.form.ftNothingBox); enabledTemplateField(this.form.templateFreshnessThreshold, <? echo preg_replace("/(99999)/", "0", $ft) ?>, '');">
					<? } ?>
						<input size="5" type="text" name="sv[service_freshness_threshold]" id="templateFreshnessThreshold" value="<? echo preg_replace("/(99999)/", "0", $ft) ?>"<? if ($ft) echo "disabled";?>>
						<? echo $lang["time_sec"]; ?>
						&nbsp;&nbsp;<input type="checkbox" name="ftNothingBox" value="" OnClick="enabledTemplateFieldSelect(this.form.templateFreshnessThreshold);" <? if ($ft) echo "disabled"; ?>>Nothing
					</td>
				</tr>
				<tr>
					<td>Event_handler :</td>
					<td class="text10b">	
					<?
					$eh = NULL;
					if (isset($_POST["stm_id"]))
						$eh = $services[$stm_id]->get_event_handler();
					if ($eh)	{ ?>
						<input type="checkbox" onClick="enabledTemplateField(this.form.templateEventHandler, <? echo $eh; ?>, '');">
					<? } ?>
					<select name="sv[command_command_id2]" id="templateEventHandler" <? if ($eh) echo "disabled";?>>
					<?
						echo "<option value=''></option>";
						if (isset($commands))
							foreach ($commands as $cmd)	{
								if (!strstr($cmd->get_name(), "check_graph") && $cmd->get_type() == 2)	{
									echo "<option value='" . $cmd->get_id() . "'";
									if ($cmd->get_id() == $eh)
										echo " selected";
									echo ">" . $cmd->get_name() . "</option>";
								}
								unset($cmd);
							}
					?>
					</select>
					</td>
				</tr>
				<tr>
					<td>Event_handler_arguments :</td>
					<td class="text10b">
						<?
						$eha = NULL;
						if (isset($_POST["stm_id"]))
							$eha = $services[$stm_id]->get_event_handler_arg();
						if ($eha)	{ ?>
							<input type="checkbox" name="templateEventHandlerArgumentsBox" onClick="enabledTemplateField(this.form.templateEventHandlerArguments, '<? echo addslashes($eha) ?>', '');">
						<? } ?>
						<input type="text" name="sv[command_command_id2_arg]" id="templateEventHandlerArguments" value="<? echo $eha ?>" <? if ($eha) echo "disabled";?>>
						<img src="./img/info.gif" ONMOUSEOVER="var sel = document.forms['AddServiceForm'].elements['templateEventHandler'].options[document.forms['AddServiceForm'].elements['templateEventHandler'].options.selectedIndex].value; command = commands_arg(sel); montre_legende(command[1], command[0]);" ONMOUSEOUT="cache_legende();">
					</td>
				</tr>
				<tr>
					<td>Event_handler enabled :</td>
					<td class="text10b">
					<?
					$ehe = NULL;
					if (isset($_POST["stm_id"]))
						$ehe = $services[$stm_id]->get_event_handler_enabled();
					if ($ehe)	{ ?>
						<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateEventHandlerEnabled, '<? echo $ehe; ?>', '');">
					<? } ?>
					<input name="sv[service_event_handler_enabled]" type="radio" id="templateEventHandlerEnabled" value="1" <? if (isset($_POST["stm_id"])) if ($ehe == 1) echo "checked"; ?> <? if ($ehe) echo "disabled";?>> Yes - 
					<input name="sv[service_event_handler_enabled]" type="radio" id="templateEventHandlerEnabled" value="3" <? if (isset($_POST["stm_id"])) if ($ehe == 3) echo "checked"; ?> <? if ($ehe) echo "disabled";?>> No - 
					<input name="sv[service_event_handler_enabled]" type="radio" id="templateEventHandlerEnabled" value="2" <? if (isset($_POST["stm_id"])) { if ($ehe == 2) echo "checked";} else echo "checked"; ?> <? if ($ehe) echo "disabled";?>> Nothing
					</td>
				</tr>
				<tr>
					<td>Low_flap_threshold :</td>
					<td class="text10b">	
						<?
						$lft = NULL;
						if (isset($_POST["stm_id"]))
							$lft = $services[$stm_id]->get_low_flap_threshold();
						if ($lft)	{ ?>
							<input type="checkbox" onClick="enabledTemplateFieldSelect(this.form.lftNothingBox); enabledTemplateField(this.form.templateLowFlapThreshold, <? echo preg_replace("/(99999)/", "0", $lft); ?>, '');">
						<? } ?>
						<input size="5" type="text" name="sv[service_low_flap_threshold]" id="templateLowFlapThreshold" value="<? echo preg_replace("/(99999)/", "0", $lft); ?>" <? if ($lft) echo "disabled";?>>
						%
						&nbsp;&nbsp;<input type="checkbox" name="lftNothingBox" value="" OnClick="enabledTemplateFieldSelect(this.form.templateLowFlapThreshold);" <? if ($lft) echo "disabled"; ?>>Nothing
					</td>
				</tr>
				<tr>
					<td>High_flap_threshold :</td>
					<td class="text10b">	
						<?
						$hft = NULL;
						if (isset($_POST["stm_id"]))
							$hft = $services[$stm_id]->get_high_flap_threshold();
						if ($hft)	{ ?>
							<input type="checkbox" onClick="enabledTemplateFieldSelect(this.form.hftNothingBox); enabledTemplateField(this.form.templateHighFlapThreshold, <? echo preg_replace("/(99999)/", "0", $hft); ?>, '');">
						<? } ?>
						<input size="5" type="text" name="sv[service_high_flap_threshold]" id="templateHighFlapThreshold" value="<? echo preg_replace("/(99999)/", "0", $hft); ?>" <? if ($hft) echo "disabled";?>>
						%
						&nbsp;&nbsp;<input type="checkbox" name="hftNothingBox" value="" OnClick="enabledTemplateFieldSelect(this.form.templateHighFlapThreshold);" <? if ($hft) echo "disabled"; ?>>Nothing
					</td>
				</tr>
				<tr>
					<td>Flap_detection_enabled :</td>
					<td class="text10b">
					<?
					$fde = NULL;
					if (isset($_POST["stm_id"]))
						$fde = $services[$stm_id]->get_flap_detection_enabled();
					if ($fde)	{ ?>
						<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateFlapDetectionEnabled, '<? echo $fde ?>', '');">
					<? } ?>
					<input name="sv[service_flap_detection_enabled]" type="radio" id="templateFlapDetectionEnabled" value="1" <? if (isset($_POST["stm_id"])) if ($fde == 1) echo "checked"; ?> <? if ($fde) echo "disabled";?>> Yes - 
					<input name="sv[service_flap_detection_enabled]" type="radio" id="templateFlapDetectionEnabled" value="3" <? if (isset($_POST["stm_id"])) if ($fde == 3) echo "checked"; ?> <? if ($fde) echo "disabled";?>> No - 
					<input name="sv[service_flap_detection_enabled]" type="radio" id="templateFlapDetectionEnabled" value="2" <? if (isset($_POST["stm_id"])) { if ($fde == 2) echo "checked";} else echo "checked"; ?> <? if ($fde) echo "disabled";?>> Nothing 
					</td>
				</tr>
				<tr>
					<td>Process_perf_data :</td>
					<td class="text10b">
					<?
					$ppd = NULL;
					if (isset($_POST["stm_id"]))
						$ppd = $services[$stm_id]->get_process_perf_data();
					if ($ppd)	{ ?>
						<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateProcessPerfData, '<? echo $ppd; ?>', '');">
					<? } ?>
					<input name="sv[service_process_perf_data]" type="radio" id="templateProcessPerfData" value="1" <? if (isset($_POST["stm_id"])) if ($ppd == 1) echo "checked"; ?> <? if ($ppd) echo "disabled";?>> Yes - 
					<input name="sv[service_process_perf_data]" type="radio" id="templateProcessPerfData" value="3" <? if (isset($_POST["stm_id"])) if ($ppd == 3) echo "checked"; ?> <? if ($ppd) echo "disabled";?>> No - 
					<input name="sv[service_process_perf_data]" type="radio" id="templateProcessPerfData" value="2" <? if (isset($_POST["stm_id"])) { if ($ppd == 2) echo "checked";} else echo "checked"; ?> <? if ($ppd) echo "disabled";?>> Nothing 
					</td>
				</tr>
				<tr>
					<td>Retain_status_information :</td>
					<td class="text10b">
					<?
					$rsi = NULL;
					if (isset($_POST["stm_id"]))
						$rsi = $services[$stm_id]->get_retain_status_information();
					if ($rsi)	{ ?>
						<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateRetainStatusInformation, '<? echo $rsi; ?>', '');">
					<? } ?>
					<input name="sv[service_retain_status_information]" type="radio" id="templateRetainStatusInformation" value="1" <? if (isset($_POST["stm_id"])) if ($rsi == 1) echo "checked"; ?> <? if ($rsi) echo "disabled";?>> Yes - 
					<input name="sv[service_retain_status_information]" type="radio" id="templateRetainStatusInformation" value="3" <? if (isset($_POST["stm_id"])) if ($rsi == 3) echo "checked"; ?> <? if ($rsi) echo "disabled";?>> No - 
					<input name="sv[service_retain_status_information]" type="radio" id="templateRetainStatusInformation" value="2" <? if (isset($_POST["stm_id"])) { if ($rsi == 2) echo "checked";} else echo "checked"; ?> <? if ($rsi) echo "disabled";?>> Nothing 
					</td>
				</tr>
				<tr>
					<td style="white-space: nowrap;">Retain_nonstatus_information :</td>
					<td class="text10b" style="white-space: nowrap;">
					<?
					$rni = NULL;
					if (isset($_POST["stm_id"]))
						$rni = $services[$stm_id]->get_retain_nonstatus_information();
					if ($rni)	{ ?>
						<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateRetainNonstatusInformation, '<? echo $rni; ?>', '');">
					<? } ?>
					<input name="sv[service_retain_nonstatus_information]" type="radio" id="templateRetainNonstatusInformation" value="1" <? if (isset($_POST["stm_id"])) if ($rni == 1) echo "checked"; ?> <? if ($rni) echo "disabled";?>> Yes - 
					<input name="sv[service_retain_nonstatus_information]" type="radio" id="templateRetainNonstatusInformation" value="3" <? if (isset($_POST["stm_id"])) if ($rni == 3) echo "checked"; ?> <? if ($rni) echo "disabled";?>> No - 
					<input name="sv[service_retain_nonstatus_information]" type="radio" id="templateRetainNonstatusInformation" value="2" <? if (isset($_POST["stm_id"])) { if ($rni == 2) echo "checked";} else echo "checked";?> <? if ($rni) echo "disabled";?>> Nothing 
					</td>
				</tr>
				<tr>
					<td>Notification_interval :<font color='red'>*</font></td>
					<td class="text10b">	
						<?
						$nt = NULL;
						if (isset($_POST["stm_id"]))
							$nt = $services[$stm_id]->get_notification_interval();
						if ($nt)	{ ?>
							<input type="checkbox" onClick="enabledTemplateField(this.form.templateNotificationInterval, <? echo preg_replace("/(99999)/", "0", $nt); ?>, '');">
						<? } ?>
						<input size="5" type="text" name="sv[service_notification_interval]" id="templateNotificationInterval" value="<? echo preg_replace("/(99999)/", "0", $nt); ?>" <? if ($nt) echo "disabled";?>>
						&nbsp;* <? echo $oreon->Nagioscfg->get_interval_length() . " " .$lang["time_sec"]; ?>
					</td>
				</tr>
				<tr>
					<td>Notification_period :<font color='red'>*</font></td>
					<td class="text10b">	
					<?
					$np = NULL;
					if (isset($_POST["stm_id"]))
						$np = $services[$stm_id]->get_notification_period();
					if ($np)	{ ?>
						<input type="checkbox" onClick="enabledTemplateField(this.form.templateNotificationPeriod, <? echo $np; ?>, '');">
					<? } ?>
					<select name="sv[timeperiod_tp_id2]" id="templateNotificationPeriod" <? if ($np) echo "disabled";?>>
						<option></option>
					<?
						if (isset($timePeriods))
							foreach ($timePeriods as $tp)	{
								echo "<option value='" . $tp->get_id() . "'";
								if ($tp->get_id() == $np)
									echo " selected";
								echo ">" . $tp->get_name() . "</option>";
								unset($tp);
							}
					?>
					</select>
					</td>
				</tr>
				<tr>
					<td>Notification_options :<font color='red'>*</font></td>
					<td class="text10b">
					<?
					$nos = NULL;
					if (isset($_POST["stm_id"]))
						$nos = $services[$stm_id]->get_notification_options();
					if (isset($_POST["stm_id"]) && $services[$stm_id]->get_notification_options())	{
						$option_not = array();
						$tab = split(",", $services[$stm_id]->get_notification_options());
						for ($i = 0; $i != 4; $i++)	{
							if (isset($tab[$i]))
								$option_not[$tab[$i]] = $tab[$i];
						}
					}
					if ($nos)	{ ?>
						<input type="checkbox" onClick="enabledTemplateFieldCheck(this.form.templateNotificationOptions, '<? echo $nos; ?>', '');">
					<? } ?>											
					<input name="sv[service_notification_options_w]" type="checkbox" id="templateNotificationOptions" value="w" <? if (isset($option_not["w"]) && strcmp($option_not["w"], "")) print "Checked";?> <? if ($nos) echo "disabled";?>> w -
					<input name="sv[service_notification_options_u]" type="checkbox" id="templateNotificationOptions" value="u" <? if (isset($option_not["u"]) && strcmp($option_not["u"], "")) print "Checked";?> <? if ($nos) echo "disabled";?>> u -
					<input name="sv[service_notification_options_c]" type="checkbox" id="templateNotificationOptions" value="c" <? if (isset($option_not["c"]) && strcmp($option_not["c"], "")) print "Checked";?> <? if ($nos) echo "disabled";?>> c
					<input name="sv[service_notification_options_r]" type="checkbox" id="templateNotificationOptions" value="r" <? if (isset($option_not["r"]) && strcmp($option_not["r"], "")) print "Checked";?> <? if ($nos) echo "disabled";?>> r
				</tr>
				<tr>
					<td>Notification_enabled :</td>
					<td class="text10b">
					<?
					$ne = NULL;
					if (isset($_POST["stm_id"]))
						$ne = $services[$stm_id]->get_notification_enabled();
					if ($ne)	{ ?>
						<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateNotificationEnabled, '<? echo $ne; ?>', '');">
					<? } ?>
					<input name="sv[service_notification_enabled]" type="radio" id="templateNotificationEnabled" value="1" <? if (isset($_POST["stm_id"])) if ($ne == 1) echo "checked"; ?> <? if ($ne) echo "disabled";?>> Yes - 
					<input name="sv[service_notification_enabled]" type="radio" id="templateNotificationEnabled" value="3" <? if (isset($_POST["stm_id"])) if ($ne == 3) echo "checked"; ?> <? if ($ne) echo "disabled";?>> No - 
					<input name="sv[service_notification_enabled]" type="radio" id="templateNotificationEnabled" value="2" <? if (isset($_POST["stm_id"])) { if ($ne == 2) echo "checked";} else echo "checked"; ?> <? if ($ne) echo "disabled";?>> Nothing 
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<div align="center" class="text10b">
							Contact Groups<font color='red'>*</font>
							<?
							$cgs = NULL;
							if (isset($_POST["stm_id"]))
								if (isset($services[$stm_id]->contactGroups))
									$cgs = & $services[$stm_id]->contactGroups;
							if (count($cgs))	{ ?>
								<input type="checkbox" name="templateContactGroupsBox" onClick="enabledTemplateFieldSelect(this.form.templateCGBase);enabledTemplateFieldSelect(this.form.selectCG);">
							<? } ?>
						</div>
						<table border="0" align="center">
							<tr>
								<td align="left" style="padding: 3px;">
									<select name="selectCGBase" id="templateCGBase" size="8" <? if (count($cgs)) echo "disabled";?> multiple>
									<?
										if (isset($contactGroups))
											foreach ($contactGroups as $contactGroup)	{
												if (isset($_POST["stm_id"]))	{
													if (!array_key_exists($contactGroup->get_id(), $services[$stm_id]->contactGroups))
														echo "<option value='".$contactGroup->get_id()."'>".$contactGroup->get_name()."</option>";
												 }
												 else
													echo "<option value='".$contactGroup->get_id()."'>".$contactGroup->get_name()."</option>";
												unset($contactGroup);
											}
									?>
									</select>
								</td>
								<td style="padding-left: 5px; padding-right: 5px;" valign="middle" align="center">
									<input type="button" name="add" value="<? echo $lang['add']; ?>" onClick="Moove(this.form.selectCGBase,this.form.selectCG);"><br><br><br>
									<input type="button" name="remove" value="<? echo $lang['delete']; ?>" onClick="Moove(this.form.selectCG,this.form.selectCGBase);">
								</td>
								<td>
									<select id="selectCG" name="selectCG[]" size="8" multiple <? if (count($cgs)) echo "disabled";?>>
										<?
										if (isset($_POST["stm_id"]))
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
					$sos = NULL;
					if (isset($_POST["stm_id"]))
						$sos = $services[$stm_id]->get_stalking_options();
					if (isset($_POST["stm_id"]) && $services[$stm_id]->get_stalking_options())	{
						$option_sta = array();
						$tab = split(",", $services[$stm_id]->get_stalking_options());
						for ($i = 0; $i != 4; $i++)	{
							if (isset($tab[$i]))
								$option_sta[$tab[$i]] = $tab[$i];
						}
					}
					if ($sos)	{ ?>
						<input type="checkbox" onClick="enabledTemplateFieldCheck(this.form.templateStalkingOptions, '<? echo $sos; ?>', '');">
					<? } ?>
					<input name="sv[service_stalking_options_o]" type="checkbox" id="templateStalkingOptions" value="o" <? if (isset($option_sta["o"]) && strcmp($option_sta["o"], "")) print "Checked";?> <? if ($sos) echo "disabled";?>> o -
					<input name="sv[service_stalking_options_w]" type="checkbox" id="templateStalkingOptions" value="w" <? if (isset($option_sta["w"]) && strcmp($option_sta["w"], "")) print "Checked";?> <? if ($sos) echo "disabled";?>> w -
					<input name="sv[service_stalking_options_u]" type="checkbox" id="templateStalkingOptions" value="u" <? if (isset($option_sta["u"]) && strcmp($option_sta["u"], "")) print "Checked";?> <? if ($sos) echo "disabled";?>> u
					<input name="sv[service_stalking_options_c]" type="checkbox" id="templateStalkingOptions" value="c" <? if (isset($option_sta["c"]) && strcmp($option_sta["c"], "")) print "Checked";?> <? if ($sos) echo "disabled";?>> c
					</td>
				</tr>
				<tr>
					<td valign="top">Activate :</td>
					<td class="text10b">
						<input type="checkbox" name="sv[service_activate]" checked>
					</td>
				</tr>
				<tr>
					<td valign="top">Comment :</td>
					<td class="text10b">	
						<?
						$ct = NULL;
						if (isset($_POST["stm_id"]))
							$ct = $services[$stm_id]->get_comment();
						if ($ct)	{ ?>
							<input type="checkbox" name="templateCommentBox" onClick="enabledTemplateFieldTarea(this.form.templateComment);">
						<? } ?>
						<textarea name="sv[service_comment]" cols="25" rows="4" id="templateComment" <? if ($ct) echo "disabled";?>><? echo $ct; ?></textarea>
					</td>
				</tr>
				<tr>
					<td align="center" colspan="2">
						<input type="submit" name="AddService" value="<? echo $lang['save']; ?>" onClick="selectAll(this.form.selectCG); selectAll(this.form.selectSG);">
					</td>
				</tr>
				</table>
			</td>
		</tr>
	</table>
	</form>
</td>