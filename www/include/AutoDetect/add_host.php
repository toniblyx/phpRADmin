<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/?>
<td align="left" style="padding-left: 10px;" valign="top">
	<table border="0" bordercolor="#213B82" cellpadding="0" cellspacing="0">		
		<tr>
			<td class="tabTableTitle">
			<? echo $lang['add']. " ".$lang['h']; ?>
			</td>							
		</tr>
		<tr>
			<td class="tabTableForTab">
			<?								
			if (isset($_POST["htm_id"]) && strcmp($_POST["htm_id"], NULL))
				$htm_id = $_POST["htm_id"];
			else
				unset ($_POST["htm_id"]);
			if (isset($_POST["h"]))
				$h = $_POST["h"];
			?>
			<form action="" method="post" name="AddHostForm">
				<input name="o" type="hidden" value="ahf">
				<input name="id" type="hidden" value="<? print $_GET['id']; ?>">	
				<table border="0" cellpadding="3" cellspacing="3">
					<? if (isset($htms) && count($htms)) { ?>
					<tr>
						<td class="text10b" style="white-space: nowrap;"><? echo $lang['htm_use']; ?> :</td>
						<td>
							<select name="htm_id" onChange="this.form.submit();">
								<option value=""></option>
								<?
								if (isset($htms))
									foreach ($htms as $htm)	{
										echo "<option value='" .$htm->get_id(). "'";
										if (isset($_POST["htm_id"]) && ($htm_id == $htm->get_id()))
											echo " selected";
										echo ">" .$hosts[$htm->get_id()]->get_name(). "</option>";
										unset($htm);
									}
								?>
							</select>
						</td>
					</tr>
					<? } ?>
					<tr>
						<td>Name :<font color="red">*</font></td>
						<td class="text10b">
							<?
							$name = NULL;
							if (isset($_POST["htm_id"]) && $hosts[$htm_id]->get_name())
								$name = $hosts[$htm_id]->get_name();
							else
								$name = $oreon->AutoDetect[$_GET["id"]]->get_dns();
							?>
							<input type="text" name="host[host_name]" value="<? echo str_replace("HTemplate_", "", $name); ?>">
						</td>
					</tr>
					<tr>
						<td>Alias :<font color="red">*</font></td>
						<td class="text10b">
							<?
							$alias = NULL;
							if (isset($_POST["htm_id"]) && $hosts[$htm_id]->get_alias())
								$alias = $hosts[$htm_id]->get_alias();
							else
								$alias2 = $oreon->AutoDetect[$_GET["id"]]->get_dns();
							if ($alias)	{ ?>
								<input type="checkbox" onClick="enabledTemplateField(this.form.templateAlias, '<? echo $alias; ?>', '');">
							<? } ?>
							<input type="text" name="host[host_alias]" id="templateAlias" value="<? if ($alias){echo $alias;}else{echo $alias2;} ?>" <? if ($alias) echo "disabled";?>>
						</td>
					</tr>
					<tr>
						<td>Address (ip, dns) :<font color="red">*</font></td>
						<td class="text10b">
							<?
							$address = NULL;
							if (isset($_POST["htm_id"]) && $hosts[$htm_id]->get_address())
								$address = $hosts[$htm_id]->get_address();
							else
								$address2 = $oreon->AutoDetect[$_GET["id"]]->get_ip();
							if ($address)	{ ?>
								<input type="checkbox" onClick="enabledTemplateField(this.form.templateAddress, '<? echo $address; ?>', '');">
							<? } ?>
							<input type="text" name="host[host_address]" id="templateAddress" value="<? if ($address){ echo $address; }else{ echo $address2;} ?>" <? if ($address) echo "disabled";?>>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<div align="center" class="text10b">
								Parents
								<?
								$parents = NULL;
								if (isset($_POST["htm_id"]))
									$parents = & $hosts[$htm_id]->parents;
								if (count($parents))	{ ?>
									<input type="checkbox" onClick="enabledTemplateFieldSelect(this.form.templateHostParentBase);enabledTemplateFieldSelect(this.form.selectHostParent);">
								<? } ?>
							</div>
							<table border="0" align="center">
								<tr>
									<td align="left" style="padding: 3px;">
										<select name="selectHostParentBase" id="templateHostParentBase" size="8" <? if (count($parents)) echo "disabled";?> multiple>
										<?
											if (isset($hosts))
												foreach ($hosts as $host)		{	
													if ($host->get_register())	{
														if (isset($_POST["htm_id"]))	{
															if (!array_key_exists($host->get_id(), $hosts[$htm_id]->parents))
																echo "<option value='".$host->get_id()."'>".$host->get_name()."</option>";
														}
														else
															echo "<option value='".$host->get_id()."'>".$host->get_name()."</option>";
													}
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
										<select id="selectHostParent" name="selectHostParent[]" size="8" <? if (count($parents)) echo "disabled";?> multiple>
										<?
											if (isset($_POST["htm_id"]))	
												foreach ($hosts[$htm_id]->parents as $existing_parent)	{
													echo "<option value='".$existing_parent->get_id()."'>".$existing_parent->get_name()."</option>";
													unset($existing_parent);
												}
										?>
										</select>
									</td>
								</tr>
							</table>
						</td>
					</tr>								
					<tr>
						<td colspan="2">
							<div align="center" class="text10b">
								Host Groups
								<?
								$hgs = NULL;
								if (isset($_POST["htm_id"]))
									$hgs = & $hosts[$htm_id]->hostGroups;
								if (count($hgs))	{ ?>
									<input type="checkbox" onClick="enabledTemplateFieldSelect(this.form.templateHostGroupBase);enabledTemplateFieldSelect(this.form.selectHostGroup);">
								<? } ?>
							</div>
							<table border="0" align="center">
								<tr>
									<td align="left" style="padding: 3px;">
										<select name="selectHostGroupBase" id="templateHostGroupBase" size="8" <? if (count($hgs)) echo "disabled";?> multiple>
										<?
											if (isset($hostGroups))
												foreach ($hostGroups as $hostGroup)	{
													if (isset($_POST["htm_id"]))	{
														if (!array_key_exists($hostGroup->get_id(), $hosts[$htm_id]->hostGroups))
															echo "<option value='".$hostGroup->get_id()."'>".$hostGroup->get_name()."</option>";
													}
													else
														echo "<option value='".$hostGroup->get_id()."'>".$hostGroup->get_name()."</option>";
													unset($hostGroup);
												}
										?>
										</select>
									</td>
									<td style="padding-left: 5px; padding-right: 5px;" valign="middle" align="center">
										<input type="button" name="add" value="<? echo $lang['add']; ?>" onClick="Moove(this.form.selectHostGroupBase,this.form.selectHostGroup);"><br><br><br>
										<input type="button" name="remove" value="<? echo $lang['delete']; ?>" onClick="Moove(this.form.selectHostGroup,this.form.selectHostGroupBase);">
									</td>
									<td>
										<select id="selectHostGroup" name="selectHostGroup[]" size="8" <? if (count($hgs)) echo "disabled";?> multiple>
										<?
											if (isset($_POST["htm_id"]))	
												foreach ($hosts[$htm_id]->hostGroups as $existing_hg)	{
													echo "<option value='".$existing_hg->get_id()."'>".$existing_hg->get_name()."</option>";
													unset($existing_hg);
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
						<td class="text10b" style="white-space: nowrap;">
						<?
						$cc = NULL;
						if (isset($_POST["htm_id"]))
							$cc = $hosts[$htm_id]->get_check_command();
						if ($cc)	{ ?>
							<input type="checkbox" onClick="enabledTemplateField(this.form.templateCheckCommand, <? echo $cc; ?>, '');">
						<? } ?>
						<select name="host[command_command_id]" id="templateCheckCommand" <? if ($cc) echo "disabled"; ?>>
						<?
							echo "<option></option>";
							if (isset($commands))
								foreach ($commands as $cmd)	{
									if (!strstr($cmd->get_name(), "check_graph") && !strcmp($cmd->get_type(), "2"))	{
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
						<td>Max_check_attempts :<font color="red">*</font></td>
						<td class="text10b">
							<?
							$mca = NULL;
							if (isset($_POST["htm_id"]))
								$mca = $hosts[$htm_id]->get_max_check_attempts();
							if ($mca)	{ ?>
								<input type="checkbox" onClick="enabledTemplateField(this.form.templateMaxCheckAttempts, <? echo $mca; ?>, '');">
							<? } ?>
							<input size="5"  type="text" name="host[host_max_check_attempts]" id="templateMaxCheckAttempts" value="<? echo $mca; ?>" <? if ($mca) echo "disabled";?>>
						</td>
					</tr>
					<? if (!strcmp("1", $oreon->user->get_version()))	{	?>
					<tr>
						<td>Checks_enabled :</td>
						<td class="text10b">
						<?
						$ce = NULL;
						if (isset($_POST["htm_id"]))
							$ce = $hosts[$htm_id]->get_checks_enabled();
						if ($ce)	{ ?>
							<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateChecksEnabled, '<?  echo $ce; ?>', '');">
						<? } ?>
						<input name="host[host_check_enabled]" type="radio" value="1" id="templateChecksEnabled" <? if (isset($_POST["htm_id"])) if ($ce == 1) echo "checked"; ?> <? if ($ce) echo "disabled"; ?>> Yes - 
						<input name="host[host_check_enabled]" type="radio" value="3" id="templateChecksEnabled" <? if (isset($_POST["htm_id"])) if ($ce == 3) echo "checked"; ?> <? if ($ce) echo "disabled"; ?>> No - 
						<input name="host[host_check_enabled]" type="radio" value="2" id="templateChecksEnabled" <? if (isset($_POST["htm_id"])) { if ($ce == 2) echo "checked";} else echo "checked"; ?> <? if ($ce) echo "disabled"; ?>> Nothing 
						</td>	
					</tr>
					<? } if (!strcmp("2", $oreon->user->get_version()))	{	?>
					<tr>
						<td>Check_interval :</td>
						<td class="text10b">
						<?
							$ci = NULL;
							if (isset($_POST["htm_id"]))
								$ci = $hosts[$htm_id]->get_check_interval();
							if ($ci)	{ ?>
								<input type="checkbox" onClick="enabledTemplateField(this.form.templateCheckInterval, <? echo preg_replace("/(99999)/", "0", $ci); ?>, '');">
							<? } ?>
							<input size="5"  type="text" name="host[host_check_interval]" id="templateCheckInterval" value="<? echo preg_replace("/(99999)/", "0", $ci); ?>" <? if ($ci) echo "disabled";?>>
							<? echo $lang["time_min"]; ?>
						</td>
					</tr>
					<tr>
						<td>Active_checks_enabled :</td>
						<td class="text10b">
						<?
						$ace = NULL;
						if (isset($_POST["htm_id"]))
							$ace = $hosts[$htm_id]->get_active_checks_enabled();
						if ($ace)	{ ?>
							<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateActiveChecksEnabled, '<?  echo $ace; ?>', '');">
						<? } ?>
						<input name="host[host_active_checks_enabled]" type="radio" value="1" id="templateActiveChecksEnabled" <? if (isset($_POST["htm_id"])) if ($ace == 1) echo "checked"; ?> <? if ($ace) echo "disabled"; ?>> Yes - 
						<input name="host[host_active_checks_enabled]" type="radio" value="3" id="templateActiveChecksEnabled" <? if (isset($_POST["htm_id"])) if ($ace == 3) echo "checked"; ?> <? if ($ace) echo "disabled"; ?>> No - 
						<input name="host[host_active_checks_enabled]" type="radio" value="2" id="templateActiveChecksEnabled" <? if (isset($_POST["htm_id"])) { if ($ace == 2) echo "checked";} else echo "checked"; ?> <? if ($ace) echo "disabled"; ?>> Nothing 
						</td>	
					</tr>
					<tr>
						<td>Passive_checks_enabled :</td>
						<td class="text10b">
						<?
						$pce = NULL;
						if (isset($_POST["htm_id"]))
							$pce = $hosts[$htm_id]->get_passive_checks_enabled();
						if ($pce)	{ ?>
							<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templatePassiveChecksEnabled, '<? echo $pce; ?>', '');">
						<? } ?>
						<input name="host[host_passive_checks_enabled]" type="radio" id="templatePassiveChecksEnabled" value="1" <? if (isset($_POST["htm_id"])) if ($pce == 1) echo "checked"; ?> <? if ($pce) echo "disabled";?>> Yes - 
						<input name="host[host_passive_checks_enabled]" type="radio" id="templatePassiveChecksEnabled" value="3" <? if (isset($_POST["htm_id"])) if ($pce == 3) echo "checked"; ?> <? if ($pce) echo "disabled";?>> No - 
						<input name="host[host_passive_checks_enabled]" type="radio" id="templatePassiveChecksEnabled" value="2" <? if (isset($_POST["htm_id"])) { if ($pce == 2) echo "checked";} else echo "checked"; ?> <? if ($pce) echo "disabled";?>> Nothing 
						</td>
					</tr>
					<tr>
						<td>Check_period :<font color="red">*</font></td>
						<td class="text10b">
						<?
						$cp = NULL;
						if (isset($_POST["htm_id"]))
							$cp = $hosts[$htm_id]->get_check_period();
						if ($cp)	{ ?>
							<input type="checkbox" onClick="enabledTemplateField(this.form.templateCheckPeriod, <? echo $cp; ?>, '');">
						<? } ?>
						<select name="host[timeperiod_tp_id]" id="templateCheckPeriod" <? if ($cp) echo "disabled"; ?>>
						<?
							if (isset($timePeriods))
								foreach ($timePeriods as $tp)	{	
									echo "<option value='".$tp->get_id()."'";
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
						<td>Obsess_over_host :</td>
						<td class="text10b">
						<?
						$ooh = NULL;
						if (isset($_POST["htm_id"]))
							$ooh = $hosts[$htm_id]->get_obsess_over_host();
						if ($ooh)	{ ?>
							<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateObsessOverHost, '<? echo $ooh; ?>', '');">
						<? } ?>
						<input name="host[host_obsess_over_host]" type="radio" value="1" id="templateObsessOverHost" <? if (isset($_POST["htm_id"])) if ($ooh == 1) echo "checked"; ?> <? if ($ooh) echo "disabled";?>> Yes - 
						<input name="host[host_obsess_over_host]" type="radio" value="3" id="templateObsessOverHost" <? if (isset($_POST["htm_id"])) if ($ooh == 3) echo "checked"; ?> <? if ($ooh) echo "disabled";?>> No - 
						<input name="host[host_obsess_over_host]" type="radio" value="2" id="templateObsessOverHost" <? if (isset($_POST["htm_id"])) { if ($ooh == 2) echo "checked";} else echo "checked"; ?> <? if ($ooh) echo "disabled";?>> Nothing 
						</td>
					</tr>
					<tr>
						<td>Check_freshness :</td>
						<td class="text10b">
						<?
						$cf = NULL;
						if (isset($_POST["htm_id"]))
							$cf = $hosts[$htm_id]->get_check_freshness();
						if ($cf)	{ ?>
							<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateCheckFreshness, '<? echo $cf; ?>', '');">
						<? } ?>
						<input name="host[host_check_freshness]" type="radio" value="1" id="templateCheckFreshness" <? if (isset($_POST["htm_id"])) if ($cf == 1) echo "checked"; ?> <? if ($cf) echo "disabled";?>> Yes - 
						<input name="host[host_check_freshness]" type="radio" value="3" id="templateCheckFreshness" <? if (isset($_POST["htm_id"])) if ($cf == 3) echo "checked"; ?> <? if ($cf) echo "disabled";?>> No - 
						<input name="host[host_check_freshness]" type="radio" value="2" id="templateCheckFreshness" <? if (isset($_POST["htm_id"])) { if ($ooh == 2) echo "checked";} else echo "checked"; ?> <? if ($cf) echo "disabled";?>> Nothing 
						</td>
					</tr>
					<tr>
						<td>Freshness_threshold :</td>
						<td class="text10b">	
							<?
							$ft = NULL;
							if (isset($_POST["htm_id"]))
								$ft = $hosts[$htm_id]->get_freshness_threshold();
							if ($ft)	{ ?>
								<input type="checkbox" OnClick="enabledTemplateFieldSelect(this.form.ftNothingBox);enabledTemplateField(this.form.templateFreshnessThreshold, <? echo preg_replace("/(99999)/", "0", $ft); ?>, '');">
							<? } ?>
							<input size="5"  type="text" id="templateFreshnessThreshold" name="host[host_freshness_threshold]" value="<? echo preg_replace("/(99999)/", "0", $ft) ?>" <? if ($ft) echo "disabled";?>>
							<? echo $lang["time_sec"]; ?>
							&nbsp;&nbsp;<input type="checkbox" name="ftNothingBox" value="" OnClick="enabledTemplateFieldSelect(this.form.templateFreshnessThreshold);" <? if ($ft) echo "disabled"; ?>>Nothing
						</td>
					</tr>
					<?	}	?>
					<tr>
						<td>Event_handler_enabled :</td>
						<td class="text10b">
						<?
						$ehe = NULL;
						if (isset($_POST["htm_id"]))
							$ehe = $hosts[$htm_id]->get_event_handler_enabled();
						if ($ehe)	{ ?>
							<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateEventHandlerEnabled, '<? echo $ehe; ?>', '');">
						<? } ?>
						<input name="host[host_event_handler_enabled]" type="radio" id="templateEventHandlerEnabled" value="1" <? if (isset($_POST["htm_id"])) if ($ehe == 1) echo "checked"; ?> <? if ($ehe) echo "disabled";?>> Yes - 
						<input name="host[host_event_handler_enabled]" type="radio" id="templateEventHandlerEnabled" value="3" <? if (isset($_POST["htm_id"])) if ($ehe == 3) echo "checked"; ?> <? if ($ehe) echo "disabled";?>> No - 
						<input name="host[host_event_handler_enabled]" type="radio" id="templateEventHandlerEnabled" value="2" <? if (isset($_POST["htm_id"])) { if ($ehe == 2) echo "checked";} else echo "checked"; ?> <? if ($ehe) echo "disabled";?>> Nothing 
						</td>
					</tr>
					<tr>
						<td>Event_handler :</td>
						<td class="text10b">	
						<?
						$eh = NULL;
						if (isset($_POST["htm_id"]))
							$eh = $hosts[$htm_id]->get_event_handler();
						if ($eh)	{ ?>
							<input type="checkbox" onClick="enabledTemplateField(this.form.templateEventHandler, <? echo $eh; ?>, '');">
						<? } ?>
						<select name="host[command_command_id2]" id="templateEventHandler" <? if ($eh) echo "disabled"; ?>>
						<?
							echo "<option></option>";
							if (isset($commands))
								foreach ($commands as $cmd)	{
									if (!strstr($cmd->get_name(), "check_graph") && !strcmp($cmd->get_type(), "2"))	{
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
						<td>Low_flap_threshold :</td>
						<td class="text10b">	
							<?
							$lft = NULL;
							if (isset($_POST["htm_id"]))
								$lft = $hosts[$htm_id]->get_low_flap_threshold();
							if ($lft)	{ ?>
								<input type="checkbox" OnClick="enabledTemplateFieldSelect(this.form.lftNothingBox); enabledTemplateField(this.form.templateLowFlapThreshold, <? echo preg_replace("/(99999)/", "0", $lft); ?>, '');">
							<? } ?>
							<input size="5"  type="text" id="templateLowFlapThreshold" name="host[host_low_flap_threshold]" value="<? echo preg_replace("/(99999)/", "0", $lft); ?>" <? if ($lft) echo "disabled"; ?>>
							%
							&nbsp;&nbsp;<input type="checkbox" name="lftNothingBox" value="" OnClick="enabledTemplateFieldSelect(this.form.templateLowFlapThreshold);" <? if ($lft) echo "disabled"; ?>>Nothing
						</td>
					</tr>
					<tr>
						<td>High_flap_threshold :</td>
						<td class="text10b">	
							<?
							$hft = NULL;
							if (isset($_POST["htm_id"]))
								$hft = $hosts[$htm_id]->get_high_flap_threshold();
							if ($hft)	{ ?>
								<input type="checkbox" OnClick="enabledTemplateFieldSelect(this.form.hftNothingBox); enabledTemplateField(this.form.templateHighFlapThreshold, <? echo preg_replace("/(99999)/", "0", $hft); ?>, '');">
							<? } ?>
							<input size="5"  type="text" id="templateHighFlapThreshold" name="host[host_high_flap_threshold]" value="<? echo preg_replace("/(99999)/", "0", $hft); ?>" <? if ($hft) echo "disabled"; ?>>
							%
							&nbsp;&nbsp;<input type="checkbox" name="hftNothingBox" value="" OnClick="enabledTemplateFieldSelect(this.form.templateHighFlapThreshold);" <? if ($hft) echo "disabled"; ?>>Nothing
						</td>
					</tr>
					<tr>
						<td>Flap_detection_enabled :</td>
						<td class="text10b">
						<?
						$fde = NULL;
						if (isset($_POST["htm_id"]))
							$fde = $hosts[$htm_id]->get_flap_detection_enabled();
						if ($fde)	{ ?>
							<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateFlapDetectionEnabled, '<? echo $fde ?>', '');">
						<? } ?>
						<input name="host[host_flap_detection_enabled]" type="radio" id="templateFlapDetectionEnabled" value="1" <? if (isset($_POST["htm_id"])) if ($fde == 1) echo "checked"; ?> <? if ($fde) echo "disabled";?>> Yes - 
						<input name="host[host_flap_detection_enabled]" type="radio" id="templateFlapDetectionEnabled" value="3" <? if (isset($_POST["htm_id"])) if ($fde == 3) echo "checked"; ?> <? if ($fde) echo "disabled";?>> No - 
						<input name="host[host_flap_detection_enabled]" type="radio" id="templateFlapDetectionEnabled" value="2" <? if (isset($_POST["htm_id"])) { if ($fde == 2) echo "checked";} else echo "checked"; ?> <? if ($fde) echo "disabled";?>> Nothing 
						</td>
					</tr>
					<tr>
						<td>Process_perf_data :</td>
						<td class="text10b">
						<?
						$ppd = NULL;
						if (isset($_POST["htm_id"]))
							$ppd = $hosts[$htm_id]->get_process_perf_data();
						if ($ppd)	{ ?>
							<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateProcessPerfData, '<? echo $ppd; ?>', '');">
						<? } ?>
						<input name="host[host_process_perf_data]" type="radio" id="templateProcessPerfData" value="1" <? if (isset($_POST["htm_id"])) if ($ppd == 1) echo "checked"; ?> <? if ($ppd) echo "disabled";?>> Yes - 
						<input name="host[host_process_perf_data]" type="radio" id="templateProcessPerfData" value="3" <? if (isset($_POST["htm_id"])) if ($ppd == 3) echo "checked"; ?> <? if ($ppd) echo "disabled";?>> No - 
						<input name="host[host_process_perf_data]" type="radio" id="templateProcessPerfData" value="2" <? if (isset($_POST["htm_id"])) { if ($ppd == 2) echo "checked";} else echo "checked"; ?> <? if ($ppd) echo "disabled";?>> Nothing 
						</td>
					</tr>
					<tr>
						<td>Retain_status_information :</td>
						<td class="text10b">
						<?
						$rsi = NULL;
						if (isset($_POST["htm_id"]))
							$rsi = $hosts[$htm_id]->get_retain_status_information();
						if ($rsi)	{ ?>
							<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateRetainStatusInformation, '<? echo $rsi; ?>', '');">
						<? } ?>
						<input name="host[host_retain_status_information]" type="radio" id="templateRetainStatusInformation" value="1" <? if (isset($_POST["htm_id"])) if ($rsi == 1) echo "checked"; ?> <? if ($rsi) echo "disabled";?>> Yes - 
						<input name="host[host_retain_status_information]" type="radio" id="templateRetainStatusInformation" value="3" <? if (isset($_POST["htm_id"])) if ($rsi == 3) echo "checked"; ?> <? if ($rsi) echo "disabled";?>> No - 
						<input name="host[host_retain_status_information]" type="radio" id="templateRetainStatusInformation" value="2" <? if (isset($_POST["htm_id"])) { if ($rsi == 2) echo "checked";} else echo "checked"; ?> <? if ($rsi) echo "disabled";?>> Nothing 
						</td>
					</tr>
					<tr>
						<td style="white-space: nowrap;">Retain_nonstatus_information :</td>
						<td class="text10b" style="white-space: nowrap;">
						<?
						$rni = NULL;
						if (isset($_POST["htm_id"]))
							$rni = $hosts[$htm_id]->get_retain_nonstatus_information();
						if ($rni)	{ ?>
							<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateRetainNonstatusInformation, '<? echo $rni; ?>', '');">
						<? } ?>
						<input name="host[host_retain_nonstatus_information]" type="radio" id="templateRetainNonstatusInformation" value="1" <? if (isset($_POST["htm_id"])) if ($rni == 1) echo "checked"; ?> <? if ($rni) echo "disabled";?>> Yes - 
						<input name="host[host_retain_nonstatus_information]" type="radio" id="templateRetainNonstatusInformation" value="3" <? if (isset($_POST["htm_id"])) if ($rni == 3) echo "checked"; ?> <? if ($rni) echo "disabled";?>> No - 
						<input name="host[host_retain_nonstatus_information]" type="radio" id="templateRetainNonstatusInformation" value="2" <? if (isset($_POST["htm_id"])) { if ($rni == 2) echo "checked";} else echo "checked";?> <? if ($rni) echo "disabled";?>> Nothing 
						</td>
					</tr>
					<?	if (!strcmp("2", $oreon->user->get_version()))	{	?>								
					<tr>
						<td colspan="2">
							<div align="center" class="text10b">
								Contact Groups <font color="red">*</font>
								<?
								$cgs = NULL;
								if (isset($_POST["htm_id"]))
									$cgs = & $hosts[$htm_id]->contactgroups;
								if (count($cgs))	{ ?>
									<input type="checkbox" onClick="enabledTemplateFieldSelect(this.form.templateContactGroupsBase);enabledTemplateFieldSelect(this.form.selectContactGroups);">
								<? } ?>
							</div>
							<table border="0" align="center">
								<tr>
									<td align="left" style="padding: 3px;">
										<select name="selectContactGroupsBase" id="templateContactGroupsBase" size="8" <? if (count($cgs)) echo "disabled";?> multiple>
										<?
											if (isset($contactGroups))
												foreach ($contactGroups as $contactGroup)	{
													if (isset($_POST["htm_id"]))	{
														if (!array_key_exists($contactGroup->get_id(), $hosts[$htm_id]->contactgroups))
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
										<input type="button" name="add" value="<? echo $lang['add']; ?>" onClick="Moove(this.form.selectContactGroupsBase,this.form.selectContactGroup);"><br><br><br>
										<input type="button" name="remove" value="<? echo $lang['delete']; ?>" onClick="Moove(this.form.selectContactGroup,this.form.selectContactGroupsBase);">
									</td>
									<td>
										<select id="selectContactGroup" name="selectContactGroup[]" size="8" <? if (count($cgs)) echo "disabled";?> multiple>
										<?
											if (isset($_POST["htm_id"]))	
												foreach ($hosts[$htm_id]->contactgroups as $existing_cg)	{
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
						<td>Notification_interval :<font color="red">*</font></td>
						<td class="text10b">	
							<?
							$nt = NULL;
							if (isset($_POST["htm_id"]))
								$nt = $hosts[$htm_id]->get_notification_interval();
							if ($nt)	{ ?>
								<input type="checkbox" onClick="enabledTemplateField(this.form.templateNotificationInterval, <? echo preg_replace("/(99999)/", "0", $nt); ?>, '');">
							<? } ?>
							<input size="5"  type="text" name="host[host_notification_interval]" id="templateNotificationInterval" value="<? echo preg_replace("/(99999)/", "0", $nt); ?>" <? if ($nt) echo "disabled";?>>
							<? echo $lang["time_min"]; ?>
						</td>
					</tr>
					<tr>
						<td>Notification_period :<font color="red">*</font></td>
						<td class="text10b">	
						<?
						$np = NULL;
						if (isset($_POST["htm_id"]))
							$np = $hosts[$htm_id]->get_notification_period();
						if ($np)	{ ?>
							<input type="checkbox" onClick="enabledTemplateField(this.form.templateNotificationPeriod, <? echo $np; ?>, '');">
						<? } ?>
						<select name="host[timeperiod_tp_id2]" id="templateNotificationPeriod" <? if ($np) echo "disabled";?>>
						<?
							if (isset($timePeriods))
								foreach ($timePeriods as $tp)	{
									echo "<option value='".$tp->get_id()."'";
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
						<td>Notification_options :<font color="red">*</font></td>
						<td class="text10b">
						<?
						$nos = NULL;
						if (isset($_POST["htm_id"]))
							$nos = $hosts[$htm_id]->get_notification_options();
						if (isset($_POST["htm_id"]) && $hosts[$htm_id]->get_notification_options())	{
							$option_not = array();
							$tab = split(",", $hosts[$htm_id]->get_notification_options());
							for ($i = 0; $i != 3; $i++)	{
								if (isset($tab[$i]))
									$option_not[$tab[$i]] = $tab[$i];
							}
						}
						if ($nos)	{ ?>
							<input type="checkbox" onClick="enabledTemplateFieldCheck(this.form.templateNotificationOptions, '<? echo $nos; ?>', '');">
						<? } ?>
						<input name="host[host_notification_options_d]" type="checkbox" id="templateNotificationOptions" value="d" <? if (isset($option_not["d"]) && strcmp($option_not["d"], "")) print "Checked";?> <? if ($nos) echo "disabled";?>> d -
						<input name="host[host_notification_options_u]" type="checkbox" id="templateNotificationOptions" value="u" <? if (isset($option_not["u"]) && strcmp($option_not["u"], "")) print "Checked";?> <? if ($nos) echo "disabled";?>> u -
						<input name="host[host_notification_options_r]" type="checkbox" id="templateNotificationOptions" value="r" <? if (isset($option_not["r"]) && strcmp($option_not["r"], "")) print "Checked";?> <? if ($nos) echo "disabled";?>> r																						
						</td>
					</tr>
					<tr>
						<td>Notifications_enabled :</td>
						<td class="text10b">
						<?
						$ne = NULL;
						if (isset($_POST["htm_id"]))
							$ne = $hosts[$htm_id]->get_notifications_enabled();
						if ($ne)	{ ?>
							<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateNotificationsEnabled, '<? echo $ne; ?>', '');">
						<? } ?>
						<input name="host[host_notifications_enabled]" type="radio" id="templateNotificationsEnabled" value="1" <? if (isset($_POST["htm_id"])) if ($ne == 1) echo "checked"; ?> <? if ($ne) echo "disabled"; ?>> Yes - 
						<input name="host[host_notifications_enabled]" type="radio" id="templateNotificationsEnabled" value="3" <? if (isset($_POST["htm_id"])) if ($ne == 3) echo "checked"; ?> <? if ($ne) echo "disabled"; ?>> No - 
						<input name="host[host_notifications_enabled]" type="radio" id="templateNotificationsEnabled" value="2" <? if (isset($_POST["htm_id"])) { if ($ne == 2) echo "checked";} else echo "checked"; ?> <? if ($ne) echo "disabled"; ?>> Nothing 
						</td>
					</tr>
					<tr>
						<td>Stalking_options :</td>
						<td class="text10b">
						<?
						$sos = NULL;
						if (isset($_POST["htm_id"]))
							$sos = $hosts[$htm_id]->get_stalking_options();
						if (isset($_POST["htm_id"]) && $hosts[$htm_id]->get_stalking_options())	{
							$option_sta = array();
							$tab = split(",", $hosts[$htm_id]->get_stalking_options());
							for ($i = 0; $i != 3; $i++)	{
								if (isset($tab[$i]))
									$option_sta[$tab[$i]] = $tab[$i];
							}
						}
						if ($sos)	{ ?>
							<input type="checkbox" name="templateStalkingOptionsBox" onClick="enabledTemplateFieldCheck(this.form.templateStalkingOptions, '<? echo $sos; ?>', '');">
						<? } ?>
						<input name="host[host_stalking_options_o]" type="checkbox" id="templateStalkingOptions" value="o" <? if (isset($option_sta["o"]) && strcmp($option_sta["o"], "")) print "Checked"; ?> <? if ($sos) echo "disabled"; ?>> o -
						<input name="host[host_stalking_options_d]" type="checkbox" id="templateStalkingOptions" value="d" <? if (isset($option_sta["d"]) && strcmp($option_sta["d"], "")) print "Checked"; ?> <? if ($sos) echo "disabled"; ?>> d -
						<input name="host[host_stalking_options_u]" type="checkbox" id="templateStalkingOptions" value="u" <? if (isset($option_sta["u"]) && strcmp($option_sta["u"], "")) print "Checked"; ?> <? if ($sos) echo "disabled"; ?>> u
						</td>
					</tr>
					<tr>
						<td valign="top">Activate :</td>
						<td class="text10b">
							<input type="checkbox" name="host[host_activate]" checked>
						</td>
					</tr>
					<tr>
						<td valign="top">Comment :</td>
						<td class="text10b">	
							<?
							$ct = NULL;
							if (isset($_POST["htm_id"]))
								$ct = $hosts[$htm_id]->get_comment();
							if ($ct)	{ ?>
								<input type="checkbox" name="templateCommentBox" onClick="enabledTemplateFieldTarea(this.form.templateComment);">
							<? } ?>
							<textarea name="host[host_comment]" cols="25" rows="4" id="templateComment" <? if ($ct) echo "disabled"; ?>><? echo preg_replace("/(#BLANK#)/", "", $ct); ?></textarea>
						</td>
					</tr>
					<tr>
						<td align="center" colspan="2" style="padding:20px;">
						<input type="submit" name="AddHost" value="<? echo $lang['save']; ?>" onClick=" selectAll(this.form.selectHostParent); selectAll(this.form.selectContactGroup); selectAll(this.form.selectHostGroup);">
						</td>
					</tr>
				</table>
				</form>
			</td>
		</tr>
	</table>
</td>