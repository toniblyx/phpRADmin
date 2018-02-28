<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/if (isset($_POST["sv"]))	{
	$sv_temp = & $_POST["sv"];
	if (isset($sv_temp["stm_id"]) && strcmp($sv_temp["stm_id"], NULL))
		$TPL = $sv_temp["stm_id"];
	else if (isset($sv_temp["stm_id"]) && !strcmp($sv_temp["stm_id"], NULL))
		$TPL = false;
	else
		$TPL = $services[$sv]->get_service_template();
}	else
		$TPL = $services[$sv]->get_service_template();
?>
<form action="" method="POST" name="ChangeServiceForm">
<table cellpadding="0" cellspacing="3" width="350" align='center'>
<? if ($services[$sv]->get_service_template())	{
	$stm_id = $services[$sv]->get_service_template();
?>
<tr>
	<td colspan="2" align="center" class="text10b" width="50%">
		<? echo $lang["stm_use"].":<br>"."<a href='phpradmin.php?p=125&stm_id=$stm_id&o=w' class='text10bc'>".$services[$stm_id]->get_description()."</a>"; ?>
	</td>
</tr>
<? } ?>
<? if (isset($stms) && count($stms)) { ?>
<tr>
	<td class="text10b" style="white-space: nowrap;"><? echo $lang['stm_use']; ?> :</td>
	<td>
		<select name="sv[stm_id]" onChange="this.form.submit();">
			<option value=""></option>
			<?
			if (isset($stms))
				foreach ($stms as $stm)	{
					echo "<option value='" .$stm->get_id(). "'";
					if ($TPL == $stm->get_id())
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
	<td>Host name :<font color='red'>*</font></td>
	<td class="text10b" style="white-space: nowrap;">
	<select name="sv[host_host_id]">
	<?
		foreach ($hosts as $host)	{
			if ($host->get_register())	{
				echo "<option value='" . $host->get_id() . "' ";
				if ($host->get_id() == $services[$sv]->get_host())
					echo "selected";
				echo ">" . $host->get_name() . "</option>";
			}
			unset($host);
		}
	?>
	</select>
</tr>
<tr>
	<td>Description :<font color='red'>*</font></td>
	<td class="text10b"><input type="text" name="sv[service_description]" value="<? echo $services[$sv]->get_description(); ?>" maxlength="63"></td>
</tr>
<tr>
	<td>Is Volatile :</td>
	<td class="text10b">
	<?
		$iv = NULL;
		$iv_temp = NULL;
		if ($services[$sv]->get_is_volatile())
			$iv = $services[$sv]->get_is_volatile();
		if ($TPL)
			$iv_temp = $services[$TPL]->get_is_volatile();
		if (!$services[$sv]->get_is_volatile() && !$TPL)
			$iv = 2;
		if ($TPL)	{ ?>
			<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateIsVolatile, '<? echo $iv_temp; ?>', '<? echo $iv; ?>');" <? if ($iv && $iv != 2) echo "checked"; ?>>
		<? } ?>
		<input name="sv[service_is_volatile]" type="radio" value="1" id="templateIsVolatile" <? if ($iv == 1) echo "checked"; else if ((!$iv || $iv == 2) && $iv_temp == 1) echo "checked";?> <? if (!$iv && $iv_temp || ($iv == 2 && $iv_temp)) echo "disabled"; ?>> Yes -
		<input name="sv[service_is_volatile]" type="radio" value="3" id="templateIsVolatile" <? if ($iv == 3) echo "checked"; else if ((!$iv || $iv == 2) && $iv_temp == 3) echo "checked";?> <? if (!$iv && $iv_temp || ($iv == 2 && $iv_temp)) echo "disabled"; ?>> No -
		<input name="sv[service_is_volatile]" type="radio" value="2" id="templateIsVolatile" <? if ($iv == 2 && !$iv_temp) echo "checked"; else if ((!$iv || $iv == 2) && $iv_temp == 2) echo "checked";?> <? if (!$iv && $iv_temp || ($iv == 2 && $iv_temp)) echo "disabled"; ?>> Nothing
	</td>
</tr>
<tr>
	<td  colspan="2">
		<div align="center" class="text10b">
			Service Groups
			<?
			$sgs = array();
			$sgs_temp = array();
			if ($TPL)
				if (isset($services[$TPL]->serviceGroups))
					$sgs_temp = & $services[$TPL]->serviceGroups;
			if (isset($services[$sv]->serviceGroups))
				$sgs = & $services[$sv]->serviceGroups;
			if ($TPL)	{ ?>
				<input type="checkbox" id="templateServiceGroupsBox" onClick="enabledTemplateFieldSelect(this.form.templateSGBase); enabledTemplateFieldSelect(this.form.selectSG);" <? if ($sgs) echo "checked"; ?>>
			<? } ?>
		</div>
		<table border="0" align="center">
			<tr>
				<td align="left" style="padding: 3px;">
					<select name="selectSGBase" id="templateSGBase" size="8"<? if ($TPL &&  !$sgs) echo "disabled";?> multiple>
					<?
						if (isset($serviceGroups))
							foreach ($serviceGroups as $serviceGroup)	{
								if (!array_key_exists($serviceGroup->get_id(), $sgs) && !array_key_exists($serviceGroup->get_id(), $sgs_temp))
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
					<select id="selectSG" name="selectSG[]" size="8" <? if ($TPL && !$sgs) echo "disabled";?> multiple>
					<?
					if (count($sgs))
						foreach ($sgs as $existing_sg)	{
							echo "<option value='".$existing_sg->get_id()."'>".$existing_sg->get_name()."</option>";
							unset($existing_sg);
						}
					else if (count($sgs_temp))
						foreach ($sgs_temp as $existing_sg)	{
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
	<td>Check_command :<font color='red'>*</font></td>
	<td class="text10b" style="white-space: nowrap;">
	<?
		$cc = NULL;
		$cc_temp = NULL;
		if ($TPL)
			$cc_temp = $services[$TPL]->get_check_command();
		if ($services[$sv]->get_check_command())
			$cc = $services[$sv]->get_check_command();
		if ($TPL)	{ ?>
			<input type="checkbox" onClick="enabledTemplateField(this.form.templateCheckCommand, '<? echo $cc_temp; ?>', '<? echo $cc; ?>');" <? if ($cc) echo "checked"; ?>>
		<? } ?>
	<select name="sv[command_command_id]" id="templateCheckCommand" <? if ($TPL && !$cc) echo "disabled"; ?>>
		<option></option>
	<?
	if (isset($commands))
		foreach ($commands as $cmd)	{
			if ($cmd->get_type() == 2)	{
				echo "<option value='" . $cmd->get_id() . "'";
				if ($cc == $cmd->get_id())
					echo " selected";
				if (!$cc && $cc_temp == $cmd->get_id())
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
		$cca_temp = NULL;
		if ($services[$sv]->get_check_command_arg())
			$cca = $services[$sv]->get_check_command_arg();
		if ($TPL)
			$cca_temp = $services[$TPL]->get_check_command_arg();
		if ($services[$sv]->get_check_command() && strstr($commands[$services[$sv]->get_check_command()]->get_name(), "check_graph"))
			$cca = preg_replace("/(\![0-9]+)$/", "", $cca);
		else if ($TPL && $services[$TPL]->get_check_command() && strstr($commands[$services[$TPL]->get_check_command()]->get_name(), "check_graph"))
			$cca = preg_replace("/(\![0-9]+)$/", "", $cca);

		if ($TPL)	{ ?>
			<input type="checkbox" onClick="enabledTemplateField(this.form.templateCheckCommandArguments, '<? echo addslashes($cca_temp); ?>', '<? echo addslashes(preg_replace("/(#BLANK#)/", "", $cca)); ?>');" <? if ($cca && strcmp($cca, $cca_temp)) echo "checked"; ?>>
		<? } ?>
		<input type="text" name="sv[command_command_id_arg]" id="templateCheckCommandArguments" value="<? if ($cca) echo preg_replace("/(#BLANK#)/", "", $cca); else echo $cca_temp;?>" <? if ($TPL && (!$cca || ($cca == $cca_temp))) echo "disabled";?>>
		<img src="./img/info.gif" ONMOUSEOVER="var sel = document.forms['ChangeServiceForm'].elements['templateCheckCommand'].options[document.forms['ChangeServiceForm'].elements['templateCheckCommand'].options.selectedIndex].value; command = commands_arg(sel); montre_legende(command[1], command[0]);" ONMOUSEOUT="cache_legende();">
	</td>
</tr>
<tr>
	<td>Max_check_attempts :<font color='red'>*</font></td>
	<td class="text10b">
	<?
		$mca = NULL;
		$mca_temp = NULL;
		if ($services[$sv]->get_max_check_attempts())
			$mca = $services[$sv]->get_max_check_attempts();
		if ($TPL)
			$mca_temp = $services[$TPL]->get_max_check_attempts();
		if ($TPL)	{ ?>
			<input type="checkbox" onClick="enabledTemplateField(this.form.templateMaxCheckAttempts, '<? echo $mca_temp; ?>', '<? echo $mca; ?>');" <? if ($mca) echo "checked"; ?>>
		<? } ?>
		<input size="5" type="text" name="sv[service_max_check_attempts]" id="templateMaxCheckAttempts" value="<? if ($mca) echo $mca; else echo $mca_temp; ?>" <? if ($TPL && !$mca) echo "disabled";?>>
	</td>
</tr>
<tr>
	<td>Normal_check_interval :<font color='red'>*</font></td>
	<td class="text10b">
	<?
		$nci = NULL;
		$nci_temp = NULL;
		if ($services[$sv]->get_normal_check_interval())
			$nci = $services[$sv]->get_normal_check_interval();
		if ($TPL)
			$nci_temp = $services[$TPL]->get_normal_check_interval();
		if ($TPL)	{ ?>
			<input type="checkbox"onClick="enabledTemplateField(this.form.templateNormalCheckInterval, '<? echo $nci_temp; ?>', '<? echo $nci; ?>');" <? if ($nci) echo "checked"; ?>>
		<? } ?>
		<input size="5" type="text" name="sv[service_normal_check_interval]" id="templateNormalCheckInterval" value="<? if ($nci) echo $nci; else echo $nci_temp;?>" <? if ($TPL && !$nci) echo "disabled";?>>
		&nbsp;* <? echo $oreon->Nagioscfg->interval_length . " " .$lang["time_sec"]; ?>
	</td>
</tr>
<tr>
	<td>Retry_check_interval :<font color='red'>*</font></td>
	<td class="text10b">
	<?
		$rci = NULL;
		$rci_temp = NULL;
		if ($services[$sv]->get_retry_check_interval())
			$rci = $services[$sv]->get_retry_check_interval();
		if ($TPL)
			$rci_temp = $services[$TPL]->get_retry_check_interval();
		if ($TPL)	{ ?>
			<input type="checkbox" onClick="enabledTemplateField(this.form.templateRetryCheckInterval, '<? echo $rci_temp; ?>', '<? echo $rci; ?>');" <? if ($rci) echo "checked"; ?>>
		<? } ?>
		<input size="5" type="text" name="sv[service_retry_check_interval]" id="templateRetryCheckInterval" value="<? if ($rci) echo $rci; else echo $rci_temp; ?>" <? if ($TPL && !$rci) echo "disabled";?>>
		&nbsp;* <? echo $oreon->Nagioscfg->interval_length . " " .$lang["time_sec"]; ?>
	</td>
</tr>
<tr>
	<td>Active_checks_enabled :</td>
	<td class="text10b">
	<?
		$ace = NULL;
		$ace_temp = NULL;
		if ($services[$sv]->get_active_checks_enabled())
			$ace = $services[$sv]->get_active_checks_enabled();
		if ($TPL)
			$ace_temp = $services[$TPL]->get_active_checks_enabled();
		if (!$services[$sv]->get_active_checks_enabled() && !$TPL)
			$ace = 2;
		if ($TPL)	{ ?>
			<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateActiveChecksEnabled, '<? echo $ace_temp; ?>', '<? echo $ace; ?>');" <? if ($ace && $ace != 2) echo "checked"; ?>>
		<? } ?>
		<input name="sv[service_active_checks_enabled]" type="radio" id="templateActiveChecksEnabled" value="1" <? if ($ace == 1) echo "checked"; else if ((!$ace || $ace == 2) && $ace_temp == 1) echo "checked";?> <? if (!$ace && $ace_temp || ($ace == 2 && $ace_temp)) echo "disabled"; ?>> Yes -
		<input name="sv[service_active_checks_enabled]" type="radio" id="templateActiveChecksEnabled" value="3" <? if ($ace == 3) echo "checked"; else if ((!$ace || $ace == 2) && $ace_temp == 3) echo "checked";?> <? if (!$ace && $ace_temp || ($ace == 2 && $ace_temp)) echo "disabled"; ?>> No -
		<input name="sv[service_active_checks_enabled]" type="radio" id="templateActiveChecksEnabled" value="2" <? if ($ace == 2 && !$ace_temp) echo "checked"; else if ((!$ace || $ace == 2) && $ace_temp == 2) echo "checked";?> <? if (!$ace && $ace_temp || ($ace == 2 && $ace_temp)) echo "disabled"; ?>> Nothing
	</td>
</tr>
<tr>
	<td>Passive_checks_enabled :</td>
	<td class="text10b">
	<?
		$pce = NULL;
		$pce_temp = NULL;
		if ($services[$sv]->get_passive_checks_enabled())
			$pce = $services[$sv]->get_passive_checks_enabled();
		if ($TPL)
			$pce_temp = $services[$TPL]->get_passive_checks_enabled();
		if (!$services[$sv]->get_passive_checks_enabled() && !$TPL)
			$pce = 2;
		if ($TPL)	{ ?>
			<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templatePassiveChecksEnabled, '<? echo $pce_temp; ?>', '<? echo $pce; ?>');" <? if ($pce && $pce != 2) echo "checked"; ?>>
		<? } ?>
		<input name="sv[service_passive_checks_enabled]" type="radio" id="templatePassiveChecksEnabled" value="1" <? if ($pce == 1) echo "checked"; else if ((!$pce || $pce == 2) && $pce_temp == 1) echo "checked";?> <? if (!$pce && $pce_temp || ($pce == 2 && $pce_temp)) echo "disabled"; ?>> Yes -
		<input name="sv[service_passive_checks_enabled]" type="radio" id="templatePassiveChecksEnabled" value="3" <? if ($pce == 3) echo "checked"; else if ((!$pce || $pce == 2) && $pce_temp == 3) echo "checked";?> <? if (!$pce && $pce_temp || ($pce == 2 && $pce_temp)) echo "disabled"; ?>> No -
		<input name="sv[service_passive_checks_enabled]" type="radio" id="templatePassiveChecksEnabled" value="2" <? if ($pce == 2 && !$pce_temp) echo "checked"; else if ((!$pce || $pce == 2) && $pce_temp == 2) echo "checked";?> <? if (!$pce && $pce_temp || ($pce == 2 && $pce_temp)) echo "disabled"; ?>> Nothing
	</td>
</tr>
<tr>
	<td>Check_period :<font color='red'>*</font></td>
	<td class="text10b">
	<?
		$cp = NULL;
		$cp_temp = NULL;
		if ($TPL)
			$cp_temp = $services[$TPL]->get_check_period();
		if ($services[$sv]->get_check_period())
			$cp = $services[$sv]->get_check_period();
		if ($TPL)	{ ?>
			<input type="checkbox" onClick="enabledTemplateField(this.form.templateCheckPeriod, '<? echo $cp_temp; ?>', '<? echo $cp; ?>');" <? if ($cp) echo "checked"; ?>>
		<? } ?>
		<select name="sv[timeperiod_tp_id]" id="templateCheckPeriod" <? if ($TPL && !$cp) echo "disabled";?>>
		<?
			if (isset($timePeriods))
				foreach ($timePeriods as $tp)	{
					echo "<option value='" . $tp->get_id() . "'";
					if ($cp == $tp->get_id())
						echo " selected";
					if (!$cp && $cp_temp == $tp->get_id())
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
	<?	$pc = NULL;
		$pc_temp = NULL;
		if ($services[$sv]->get_parallelize_check())
			$pc = $services[$sv]->get_parallelize_check();
		if ($TPL)
			$pc_temp = $services[$TPL]->get_parallelize_check();
		if (!$services[$sv]->get_parallelize_check() && !$TPL)
			$pc = 2;
		if ($TPL)	{ ?>
			<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateServiceParallelizeCheck, '<? echo $pc_temp; ?>', '<? echo $pc; ?>');" <? if ($pc && $pc != 2) echo "checked"; ?>>
		<? } ?>
	<input name="sv[service_parallelize_check]" type="radio" id="templateServiceParallelizeCheck" value="1" <? if ($pc == 1) echo "Checked"; else if ((!$pc || $pc == 2) && $pc_temp == 1) echo "checked";?> <? if (!$pc && $pc_temp || ($pc == 2 && $pc_temp)) echo "disabled"; ?>> Yes -
	<input name="sv[service_parallelize_check]" type="radio" id="templateServiceParallelizeCheck" value="3" <? if ($pc == 3) echo "Checked"; else if ((!$pc || $pc == 2) && $pc_temp == 3) echo "checked";?> <? if (!$pc && $pc_temp || ($pc == 2 && $pc_temp)) echo "disabled"; ?>> No -
	<input name="sv[service_parallelize_check]" type="radio" id="templateServiceParallelizeCheck" value="2" <? if ($pc == 2 && !$pc_temp) echo "Checked"; else if ((!$pc || $pc == 2) && $pc_temp == 2) echo "checked";?> <? if (!$pc && $pc_temp || ($pc == 2 && $pc_temp)) echo "disabled"; ?>> Nothing
	</td>
</tr>
<tr>
	<td>Obsess_over_service :</td>
	<td class="text10b">
	<?	$oos = NULL;
		$oos_temp = NULL;
		if ($services[$sv]->get_obsess_over_service())
			$oos = $services[$sv]->get_obsess_over_service();
		if ($TPL)
			$oos_temp = $services[$TPL]->get_obsess_over_service();
		if (!$services[$sv]->get_obsess_over_service() && !$TPL)
			$oos = 2;
		if ($TPL)	{ ?>
			<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateObsessOverService, '<? echo $oos_temp; ?>', '<? echo $oos; ?>');" <? if ($oos && $oos != 2) echo "checked"; ?>>
		<? } ?>
	<input name="sv[service_obsess_over_service]" type="radio" id="templateObsessOverService" value="1" <? if ($oos == 1) echo "Checked"; else if ((!$oos || $oos == 2) && $oos_temp == 1) echo "checked";?> <? if (!$oos && $oos_temp || ($oos == 2 && $oos_temp)) echo "disabled"; ?>> Yes -
	<input name="sv[service_obsess_over_service]" type="radio" id="templateObsessOverService" value="3" <? if ($oos == 3) echo "Checked"; else if ((!$oos || $oos == 2) && $oos_temp == 3) echo "checked";?> <? if (!$oos && $oos_temp || ($oos == 2 && $oos_temp)) echo "disabled"; ?>> No -
	<input name="sv[service_obsess_over_service]" type="radio" id="templateObsessOverService" value="2" <? if ($oos == 2 && !$oos_temp) echo "Checked"; else if ((!$oos || $oos == 2) && $oos_temp == 2) echo "checked";?> <? if (!$oos && $oos_temp || ($oos == 2 && $oos_temp)) echo "disabled"; ?>> Nothing
	</td>
</tr>
<tr>
	<td>Check_freshness :</td>
	<td class="text10b">
	<?	$cf = NULL;
		$cf_temp = NULL;
		if ($services[$sv]->get_check_freshness())
			$cf = $services[$sv]->get_check_freshness();
		if ($TPL)
			$cf_temp = $services[$TPL]->get_check_freshness();
		if (!$services[$sv]->get_check_freshness() && !$TPL)
			$cf = 2;
		if ($TPL)	{ ?>
			<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateCheckFreshness, '<? echo $cf_temp; ?>', '<? echo $cf; ?>');" <? if ($cf && $cf != 2) echo "checked"; ?>>
		<? } ?>
	<input name="sv[service_check_freshness]" type="radio" id="templateCheckFreshness" value="1" <? if ($cf == 1) echo "Checked"; else if ((!$cf || $cf == 2) && $cf_temp == 1) echo "checked";?> <? if (!$cf && $cf_temp || ($cf == 2 && $cf_temp)) echo "disabled"; ?>> Yes -
	<input name="sv[service_check_freshness]" type="radio" id="templateCheckFreshness" value="3" <? if ($cf == 3) echo "Checked"; else if ((!$cf || $cf == 2) && $cf_temp == 3) echo "checked";?> <? if (!$cf && $cf_temp || ($cf == 2 && $cf_temp)) echo "disabled"; ?>> No -
	<input name="sv[service_check_freshness]" type="radio" id="templateCheckFreshness" value="2" <? if ($cf == 2 && !$cf_temp) echo "Checked"; else if ((!$cf || $cf == 2) & $cf_temp == 2) echo "checked";?> <? if (!$cf && $cf_temp || ($cf == 2 && $cf_temp)) echo "disabled"; ?>> Nothing
	</td>
</tr>
<tr>
	<td>Freshness_threshold :</td>
	<td class="text10b">
	<?	$ft = 0;
		$ft_temp = 0;
		if ($services[$sv]->get_freshness_threshold())
			$ft = $services[$sv]->get_freshness_threshold();
		if ($TPL)
			$ft_temp = $services[$TPL]->get_freshness_threshold();
		if ($TPL)	{ ?>
			<input type="checkbox" onClick="enabledTemplateFieldSelect(this.form.ftNothingBox); if (<? echo $ft; ?>) { enabledTemplateField(this.form.templateFreshnessThreshold, '<? echo preg_replace("/(99999)/", "0", $ft_temp); ?>', '<? echo preg_replace("/(99999)/", "0", $ft); ?>') } ;" <? if ($ft) echo "checked"; ?>>
		<? } ?>
		<input size="5" type="text" name="sv[service_freshness_threshold]" id="templateFreshnessThreshold" value="<? if ($ft) echo preg_replace("/(99999)/", "0", $ft); else echo preg_replace("/(99999)/", "0", $ft_temp); ?>" <? if (!$ft) echo "disabled";?>>
		<? echo $lang["time_sec"]; ?>
		&nbsp;&nbsp;<input type="checkbox" name="ftNothingBox" value="" <? if (!$ft) echo "checked"; ?> OnClick="enabledTemplateFieldSelect(this.form.templateFreshnessThreshold);" <? if ($TPL && !$ft) echo "disabled"; ?>>Nothing
	</td>
</tr>
<tr>
	<td>Event_handler :</td>
	<td class="text10b">
	<?
		$eh = NULL;
		$eh_temp = NULL;
		if ($services[$sv]->get_event_handler())
			$eh = $services[$sv]->get_event_handler();
		if ($TPL)
			$eh_temp = $services[$TPL]->get_event_handler();
		if ($TPL)	{ ?>
			<input type="checkbox" onClick="enabledTemplateField(this.form.templateEventHandler, '<? echo $eh_temp; ?>', '<? echo $eh; ?>');" <? if ($eh) echo "checked"; ?>>
		<? } ?>
	<select name="sv[command_command_id2]" id="templateEventHandler" <? if ($TPL && !$eh) echo "disabled";?>>
	<option></option>
	<?
	if (isset($commands))
		foreach ($commands as $cmd)	{
			if (!strstr($cmd->get_name(), "check_graph") && $cmd->get_type() == 2)	{
				echo "<option value='" . $cmd->get_id() . "'";
				if ($eh == $cmd->get_id())
					echo " selected";
				if (!$eh && $eh_temp == $cmd->get_id())
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
	<?	$eha = NULL;
		$eha_temp = NULL;
		if ($services[$sv]->get_event_handler_arg())
			$eha = $services[$sv]->get_event_handler_arg();
		if ($TPL)
			$eha_temp = $services[$TPL]->get_event_handler_arg();
		if ($TPL)	{ ?>
			<input type="checkbox" name="templateEventHandlerArgumentsBox" onClick="enabledTemplateField(this.form.templateEventHandlerArguments, '<? echo addslashes($eha_temp); ?>', '<? echo addslashes(preg_replace("/(#BLANK#)/", "", $eha)); ?>');" <? if ($eha) echo "checked"; ?>>
		<? } ?>
		<input type="text" name="sv[command_command_id2_arg]" id="templateEventHandlerArguments" value="<? if ($eha) echo preg_replace("/(#BLANK#)/", "", $eha); else echo $eha_temp; ?>" <? if ($TPL && !$eha) echo "disabled";?>>
		<img src="./img/info.gif" ONMOUSEOVER="var sel = document.forms['ChangeServiceForm'].elements['templateEventHandler'].options[document.forms['ChangeServiceForm'].elements['templateEventHandler'].options.selectedIndex].value; command = commands_arg(sel); montre_legende(command[1], command[0]);" ONMOUSEOUT="cache_legende();">
	</td>
</tr>
<tr>
	<td>Event_handler enabled :</td>
	<td class="text10b">
	<?	$ehe = NULL;
		$ehe_temp = NULL;
		if ($services[$sv]->get_event_handler_enabled())
			$ehe = $services[$sv]->get_event_handler_enabled();
		if ($TPL)
			$ehe_temp = $services[$TPL]->get_event_handler_enabled();
		if (!$services[$sv]->get_event_handler_enabled() && !$TPL)
			$ehe = 2;
		if ($TPL)	{ ?>
			<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateEventHandlerEnabled, '<? echo $ehe_temp; ?>', '<? echo $ehe; ?>');" <? if ($ehe && $ehe != 2) echo "checked"; ?>>
		<? } ?>
	<input name="sv[service_event_handler_enabled]" type="radio" id="templateEventHandlerEnabled" value="1" <? if ($ehe == 1) echo "Checked"; else if ((!$ehe || $ehe == 2) && $ehe_temp == 1) echo "checked";?> <? if (!$ehe && $ehe_temp || ($ehe == 2 && $ehe_temp)) echo "disabled"; ?>> Yes -
	<input name="sv[service_event_handler_enabled]" type="radio" id="templateEventHandlerEnabled" value="3" <? if ($ehe == 3) echo "Checked"; else if ((!$ehe || $ehe == 2) && $ehe_temp == 3) echo "checked";?> <? if (!$ehe && $ehe_temp || ($ehe == 2 && $ehe_temp)) echo "disabled"; ?>> No -
	<input name="sv[service_event_handler_enabled]" type="radio" id="templateEventHandlerEnabled" value="2" <? if ($ehe == 2 && !$ehe_temp) echo "Checked"; else if ((!$ehe || $ehe == 2) && $ehe_temp == 2) echo "checked";?> <? if (!$ehe && $ehe_temp || ($ehe == 2 && $ehe_temp)) echo "disabled"; ?>> Nothing
	</td>
</tr>
<tr>
	<td>Low_flap_threshold :</td>
	<td class="text10b">
	<?	$lft = 0;
		$lft_temp = 0;
		if ($services[$sv]->get_low_flap_threshold())
			$lft = $services[$sv]->get_low_flap_threshold();
		if ($TPL)
			$lft_temp = $services[$TPL]->get_low_flap_threshold();
		if ($TPL)	{ ?>
			<input type="checkbox" onClick="enabledTemplateFieldSelect(this.form.lftNothingBox); if (<? echo $lft; ?>) { enabledTemplateField(this.form.templateLowFlapThreshold, '<? echo preg_replace("/(99999)/", "0", $lft_temp); ?>', '<? echo  preg_replace("/(99999)/", "0", $lft); ?>') } ;" <? if ($lft) echo "checked"; ?>>
		<? } ?>
		<input size="5" type="text" name="sv[service_low_flap_threshold]" id="templateLowFlapThreshold" value="<? if ($lft) echo preg_replace("/(99999)/", "0", $lft); else echo preg_replace("/(99999)/", "0", $lft_temp); ?>" <? if (!$lft) echo "disabled";?>>
		%
		&nbsp;&nbsp;<input type="checkbox" name="lftNothingBox" value="" <? if (!$lft) echo "checked"; ?> OnClick="enabledTemplateFieldSelect(this.form.templateLowFlapThreshold);" <? if ($TPL && !$lft) echo "disabled"; ?>>Nothing
	</td>
</tr>
<tr>
	<td>High_flap_threshold :</td>
	<td class="text10b">
	<?	$hft = 0;
		$hft_temp = 0;
		if ($services[$sv]->get_high_flap_threshold())
			$hft = $services[$sv]->get_high_flap_threshold();
		if ($TPL)
			$hft_temp = $services[$TPL]->get_high_flap_threshold();
		if ($TPL)	{ ?>
			<input type="checkbox" onClick="enabledTemplateFieldSelect(this.form.hftNothingBox); if (<? echo $hft; ?>) { enabledTemplateField(this.form.templateHightFlapThreshold, '<? echo preg_replace("/(99999)/", "0", $hft_temp); ?>', '<? echo preg_replace("/(99999)/", "0", $hft); ?>') } ;" <? if ($hft) echo "checked"; ?>>
		<? } ?>
		<input size="5" type="text" name="sv[service_high_flap_threshold]" id="templateHighFlapThreshold" value="<? if ($hft) echo preg_replace("/(99999)/", "0", $hft); else echo preg_replace("/(99999)/", "0", $hft_temp); ?>" <? if (!$hft) echo "disabled";?>>
		%
		&nbsp;&nbsp;<input type="checkbox" name="hftNothingBox" value="" <? if (!$hft) echo "checked"; ?> OnClick="enabledTemplateFieldSelect(this.form.templateHighFlapThreshold);" <? if ($TPL && !$hft) echo "disabled"; ?>>Nothing
	</td>
</tr>
<tr>
	<td>Flap_detection_enabled :</td>
	<td class="text10b">
	<?	$fde = NULL;
		$fde_temp = NULL;
		if ($services[$sv]->get_flap_detection_enabled())
			$fde = $services[$sv]->get_flap_detection_enabled();
		if ($TPL)
			$fde_temp = $services[$TPL]->get_flap_detection_enabled();
		if (!$services[$sv]->get_flap_detection_enabled() && !$TPL)
			$fde = 2;
		if ($TPL)	{ ?>
			<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateFlapDetectionEnabled, '<? echo $fde_temp; ?>', '<? echo $fde; ?>');" <? if ($fde && $fde != 2) echo "checked"; ?>>
		<? } ?>
	<input name="sv[service_flap_detection_enabled]" type="radio" value="1" id="templateFlapDetectionEnabled" <? if ($fde == 1) echo "Checked"; else if ((!$fde || $fde == 2) && $fde_temp == 1) echo "checked";?> <? if (!$fde && $fde_temp || ($fde == 2 && $fde_temp)) echo "disabled"; ?>> Yes -
	<input name="sv[service_flap_detection_enabled]" type="radio" value="3" id="templateFlapDetectionEnabled" <? if ($fde == 3) echo "Checked"; else if ((!$fde || $fde == 2) && $fde_temp == 3) echo "checked";?> <? if (!$fde && $fde_temp || ($fde == 2 && $fde_temp)) echo "disabled"; ?>> No -
	<input name="sv[service_flap_detection_enabled]" type="radio" value="2" id="templateFlapDetectionEnabled" <? if ($fde == 2 && !$fde_temp) echo "Checked"; else if ((!$fde || $fde == 2) && $fde_temp == 2) echo "checked";?> <? if (!$fde && $fde_temp || ($fde == 2 && $fde_temp)) echo "disabled"; ?>> Nothing
	</td>
</tr>
<tr>
	<td>Process_perf_data :</td>
	<td class="text10b">
	<?	$ppd = NULL;
		$ppd_temp = NULL;
		if ($services[$sv]->get_process_perf_data())
			$ppd = $services[$sv]->get_process_perf_data();
		if ($TPL)
			$ppd_temp = $services[$TPL]->get_process_perf_data();
		if (!$services[$sv]->get_process_perf_data() && !$TPL)
			$ppd = 2;
		if ($TPL)	{ ?>
			<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateProcessPerfData, '<? echo $ppd_temp; ?>', '<? echo $ppd; ?>');" <? if ($ppd && $ppd != 2) echo "checked"; ?>>
		<? } ?>
	<input name="sv[service_process_perf_data]" type="radio" value="1" id="templateProcessPerfData" <? if ($ppd == 1) echo "Checked"; else if ((!$ppd || $ppd == 2) && $ppd_temp == 1) echo "checked";?> <? if (!$ppd && $ppd_temp || ($ppd == 2 && $ppd_temp)) echo "disabled"; ?>> Yes -
	<input name="sv[service_process_perf_data]" type="radio" value="3" id="templateProcessPerfData" <? if ($ppd == 3) echo "Checked"; else if ((!$ppd || $ppd == 2) && $ppd_temp == 3) echo "checked";?> <? if (!$ppd && $ppd_temp || ($ppd == 2 && $ppd_temp)) echo "disabled"; ?>> No -
	<input name="sv[service_process_perf_data]" type="radio" value="2" id="templateProcessPerfData" <? if ($ppd == 2 && !$ppd_temp) echo "Checked"; else if ((!$ppd || $ppd == 2) && $ppd_temp == 2) echo "checked";?> <? if (!$ppd && $ppd_temp || ($ppd == 2 && $ppd_temp)) echo "disabled"; ?>> Nothing
	</td>
</tr>
<tr>
	<td>Retain_status_information :</td>
	<td class="text10b">
	<?	$rsi = NULL;
		$rsi_temp = NULL;
		if ($services[$sv]->get_retain_status_information())
			$rsi = $services[$sv]->get_retain_status_information();
		if ($TPL)
			$rsi_temp = $services[$TPL]->get_retain_status_information();
		if (!$services[$sv]->get_retain_status_information() && !$TPL)
			$rsi = 2;
		if ($TPL)	{ ?>
			<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateRetainStatusInformation, '<? echo $rsi_temp; ?>', '<? echo $rsi; ?>');" <? if ($rsi && $rsi != 2) echo "checked"; ?>>
		<? } ?>
	<input name="sv[service_retain_status_information]" type="radio" value="1" id="templateRetainStatusInformation" <? if ($rsi == 1) echo "Checked"; else if ((!$rsi || $rsi == 2) && $rsi_temp == 1) echo "checked";?> <? if (!$rsi && $rsi_temp || ($rsi == 2 && $rsi_temp)) echo "disabled"; ?>> Yes -
	<input name="sv[service_retain_status_information]" type="radio" value="3" id="templateRetainStatusInformation" <? if ($rsi == 3) echo "Checked"; else if ((!$rsi || $rsi == 2) && $rsi_temp == 3) echo "checked";?> <? if (!$rsi && $rsi_temp || ($rsi == 2 && $rsi_temp)) echo "disabled"; ?>> No -
	<input name="sv[service_retain_status_information]" type="radio" value="2" id="templateRetainStatusInformation" <? if ($rsi == 2 && !$rsi_temp) echo "Checked"; else if ((!$rsi || $rsi == 2) && $rsi_temp == 2) echo "checked";?> <? if (!$rsi && $rsi_temp || ($rsi == 2 && $rsi_temp)) echo "disabled"; ?>> Nothing </td>
</tr>
<tr>
	<td style="white-space: nowrap;">Retain_nonstatus_information :</td>
	<td class="text10b" style="white-space: nowrap;">
	<?	$rni = NULL;
		$rni_temp = NULL;
		if ($services[$sv]->get_retain_nonstatus_information())
			$rni = $services[$sv]->get_retain_nonstatus_information();
		if ($TPL)
			$rni_temp = $services[$TPL]->get_retain_nonstatus_information();
		if (!$services[$sv]->get_retain_nonstatus_information() && !$TPL)
			$rni = 2;
		if ($TPL)	{ ?>
			<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateRetainNonstatusInformation, '<? echo $rni_temp; ?>', '<? echo $rni; ?>');" <? if ($rni && $rni != 2) echo "checked"; ?>>
		<? } ?>
	<input name="sv[service_retain_nonstatus_information]" type="radio" value="1" id="templateRetainNonstatusInformation" <? if ($rni == 1) echo "Checked"; else if ((!$rni || $rni == 2) && $rni_temp == 1) echo "checked";?> <? if (!$rni && $rni_temp || ($rni == 2 && $rni_temp)) echo "disabled"; ?>> Yes -
	<input name="sv[service_retain_nonstatus_information]" type="radio" value="3" id="templateRetainNonstatusInformation" <? if ($rni == 3) echo "Checked"; else if ((!$rni || $rni == 2) && $rni_temp == 1) echo "checked";?> <? if (!$rni && $rni_temp || ($rni == 2 && $rni_temp)) echo "disabled"; ?>> No -
	<input name="sv[service_retain_nonstatus_information]" type="radio" value="2" id="templateRetainNonstatusInformation" <? if ($rni == 2 && !$rni_temp) echo "Checked"; else if ((!$rni || $rni == 2) && $rni_temp == 1) echo "checked";?> <? if (!$rni && $rni_temp || ($rni == 2 && $rni_temp)) echo "disabled"; ?>> Nothing </td>
</tr>
<tr>
	<td>Notification_interval :<font color='red'>*</font></td>
	<td class="text10b">
	<?	$ni = NULL;
		$ni_temp = NULL;
		if ($services[$sv]->get_notification_interval())
			$ni = $services[$sv]->get_notification_interval();
		if ($TPL)
			$ni_temp = $services[$TPL]->get_notification_interval();
		if ($TPL)	{ ?>
			<input type="checkbox" onClick="enabledTemplateField(this.form.templateNotificationInterval, '<? echo preg_replace("/(99999)/", "0", $ni_temp); ?>', '<? echo preg_replace("/(99999)/", "0", $ni); ?>');" <? if ($ni) echo "checked"; ?>>
		<? } ?>
		<input size="5" type="text" name="sv[service_notification_interval]" id="templateNotificationInterval" value="<? if ($ni) echo preg_replace("/(99999)/", "0", $ni); else echo preg_replace("/(99999)/", "0", $ni_temp); ?>" <? if ($TPL && !$ni) echo "disabled";?>>
		* <? echo $oreon->Nagioscfg->interval_length . " " .$lang["time_sec"]; ?>
	</td>
</tr>
<tr>
	<td>Notification_period :<font color='red'>*</font></td>
	<td class="text10b">
	<?
		$np = NULL;
		$np_temp = NULL;
		if ($TPL)
			$np_temp = $services[$TPL]->get_notification_period();
		if ($services[$sv]->get_notification_period())
			$np = $services[$sv]->get_notification_period();
		if ($TPL)	{ ?>
			<input type="checkbox" onClick="enabledTemplateField(this.form.templateNotificationPeriod, '<? echo $np_temp; ?>', '<? echo $np; ?>');" <? if ($np) echo "checked"; ?>>
		<? } ?>
		<select name="sv[timeperiod_tp_id2]" id="templateNotificationPeriod" <? if ($TPL && !$np) echo "disabled";?>>
		<?
		if (isset($timePeriods))
			foreach ($timePeriods as $tp)	{
				echo "<option value='" . $tp->get_id() . "'";
				if ($np == $tp->get_id())
					echo " selected";
				if (!$np && $np_temp == $tp->get_id())
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
	<?	$no = NULL;
		$no_temp = NULL;
		$option_not = array();
		$option_not_temp = array();
		if ($services[$sv]->get_notification_options())
			$no = $services[$sv]->get_notification_options();
		if ($TPL)
			$no_temp = $services[$TPL]->get_notification_options();
		if ($no)	{
			$tab = split(",", $no);
			for ($i = 0; $i != 4; $i++)
				if (isset($tab[$i]))
					$option_not[$tab[$i]] = $tab[$i];
		}
		if ($no_temp)	{
			$tab_temp = split(",", $no_temp);
			for ($i = 0; $i != 4; $i++)
				if (isset($tab_temp[$i]))
					$option_not_temp[$tab_temp[$i]] = $tab_temp[$i];
		}
		if ($TPL)	{ ?>
			<input type="checkbox" onClick="enabledTemplateFieldCheck(this.form.templateNotificationOptions, '<? echo $no_temp; ?>', '<? echo $no; ?>');" <? if ($no) echo "checked"; ?>>
		<? } ?>
	<input ONMOUSEOVER="montre_legende('Warning', '');" ONMOUSEOUT="cache_legende();"  name="sv[service_notification_options_w]" type="checkbox" id="templateNotificationOptions" value="w" <? if (isset($option_not["w"])) print "checked"; else if (isset($option_not_temp["w"]) && !count($option_not)) echo "checked";?> <? if ($TPL && !$no) echo "disabled"; ?>> w -
	<input ONMOUSEOVER="montre_legende('Unknown', '');" ONMOUSEOUT="cache_legende();" name="sv[service_notification_options_u]" type="checkbox" id="templateNotificationOptions" value="u" <? if (isset($option_not["u"])) print "checked"; else if (isset($option_not_temp["u"]) && !count($option_not)) echo "checked";?> <? if ($TPL && !$no) echo "disabled"; ?>> u -
	<input ONMOUSEOVER="montre_legende('Critical', '');" ONMOUSEOUT="cache_legende();" name="sv[service_notification_options_c]" type="checkbox" id="templateNotificationOptions" value="c" <? if (isset($option_not["c"])) print "checked"; else if (isset($option_not_temp["c"]) && !count($option_not)) echo "checked";?> <? if ($TPL && !$no) echo "disabled"; ?>> c
	<input ONMOUSEOVER="montre_legende('Recovery', '');" ONMOUSEOUT="cache_legende();" name="sv[service_notification_options_r]" type="checkbox" id="templateNotificationOptions" value="r" <? if (isset($option_not["r"])) print "checked"; else if (isset($option_not_temp["r"]) && !count($option_not)) echo "checked";?> <?  if ($TPL && !$no) echo "disabled"; ?>> r
</tr>
<tr>
	<td>Notification_enabled :</td>
	<td class="text10b">
	<?	$ne = NULL;
		$ne_temp = NULL;
		if ($services[$sv]->get_notification_enabled())
			$ne = $services[$sv]->get_notification_enabled();
		if ($TPL)
			$ne_temp = $services[$TPL]->get_notification_enabled();
		if (!$services[$sv]->get_notification_enabled() && !$TPL)
			$ne = 2;
		if ($TPL)	{ ?>
			<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateNotificationEnabled, '<? echo $ne_temp; ?>', '<? echo $ne; ?>');" <? if ($ne && $ne != 2) echo "checked"; ?>>
		<? } ?>
	<input name="sv[service_notification_enabled]" type="radio" value="1" id="templateNotificationEnabled" <? if ($ne == 1) echo "Checked"; else if ((!$ne || $ne == 2) && $ne_temp == 1) echo "checked";?> <? if (!$ne && $ne_temp || ($ne == 2 && $ne_temp)) echo "disabled"; ?>> Yes -
	<input name="sv[service_notification_enabled]" type="radio" value="3" id="templateNotificationEnabled" <? if ($ne == 3) echo "Checked"; else if ((!$ne || $ne == 2) && $ne_temp == 3) echo "checked";?> <? if (!$ne && $ne_temp || ($ne == 2 && $ne_temp)) echo "disabled"; ?>> No -
	<input name="sv[service_notification_enabled]" type="radio" value="2" id="templateNotificationEnabled" <? if ($ne == 2 && !$ne_temp) echo "Checked"; else if ((!$ne || $ne == 2) && $ne_temp == 2) echo "checked";?> <? if (!$ne && $ne_temp || ($ne == 2 && $ne_temp)) echo "disabled"; ?>> Nothing
	</td>
</tr>
<tr>
	<td align="center" colspan="2">
		<div align="center" class="text10b">
			Contact Groups<font color='red'>*</font>
			<?
			$cgs_temp = array();
			$cgs = array();
			if ($TPL)
				if (isset($services[$TPL]->contactGroups))
					$cgs_temp = & $services[$TPL]->contactGroups;
			if ($services[$sv]->contactGroups)
				$cgs = & $services[$sv]->contactGroups;
			if ($TPL)	{ ?>
				<input type="checkbox" name="templateContactGroupsBox" onClick="enabledTemplateFieldSelect(this.form.templateCGBase); enabledTemplateFieldSelect(this.form.selectCG);" <? if ($cgs) echo "checked"; ?>>
			<? } ?>
		</div>
		<table border="0" align="center">
			<tr>
				<td align="left" style="padding: 3px;">
					<select name="selectCGBase" id="templateCGBase" size="8" <? if ($TPL && (($cgs_temp && !$cgs) || (!$cgs_temp && !$cgs))) echo "disabled"; ?> multiple>
					<?
						if (isset($contactGroups))
							foreach ($contactGroups as $contactGroup)	{
								if (!array_key_exists($contactGroup->get_id(), $cgs) && !array_key_exists($contactGroup->get_id(), $cgs_temp))
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
					<select id="selectCG" name="selectCG[]" size="8" <? if ($TPL && (($cgs_temp && !$cgs) || (!$cgs_temp && !$cgs))) echo "disabled"; ?> multiple>
					<?
					if (count($cgs))
						foreach ($cgs as $existing_cg)	{
							echo "<option value='".$existing_cg->get_id()."'>".$existing_cg->get_name()."</option>";
							unset($existing_cg);
						}
					else if (count($cgs_temp))
						foreach ($cgs_temp as $existing_cg)	{
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
	<?	$so = NULL;
		$so_temp = NULL;
		$option_sta = array();
		$option_sta_temp = array();
		if ($services[$sv]->get_stalking_options())
			$so = $services[$sv]->get_stalking_options();
		if ($TPL)
			$so_temp = $services[$TPL]->get_stalking_options();
		if ($TPL)	{ ?>
			<input type="checkbox" onClick="enabledTemplateFieldCheck(this.form.templateStalkingOptions, '<? echo $so_temp; ?>', '<? echo $so; ?>');" <? if ($so) echo "checked"; ?>>
		<? }
		if ($so)	{
			$tab = split(",", $so);
			for ($i = 0; $i != 4; $i++)
				if (isset($tab[$i]))
					$option_sta[$tab[$i]] = $tab[$i];
		}
		if ($so_temp)	{
			$tab_temp = split(",", $so_temp);
			for ($i = 0; $i != 4; $i++)
				if (isset($tab_temp[$i]))
					$option_sta_temp[$tab_temp[$i]] = $tab_temp[$i];
		}
	?>
	<input ONMOUSEOVER="montre_legende('Ok', '');" ONMOUSEOUT="cache_legende();"  name="sv[service_stalking_options_o]" type="checkbox" value="o" id="templateStalkingOptions" <? if (isset($option_sta["o"])) print "checked"; else if (isset($option_sta_temp["o"]) && !count($option_sta)) echo "checked";?> <? if ($TPL && !$so) echo "disabled"; ?>> o -
	<input ONMOUSEOVER="montre_legende('Warning', '');" ONMOUSEOUT="cache_legende();" name="sv[service_stalking_options_w]" type="checkbox" value="w" id="templateStalkingOptions" <? if (isset($option_sta["w"])) print "checked"; else if (isset($option_sta_temp["w"]) && !count($option_sta)) echo "checked";?> <? if ($TPL && !$so) echo "disabled"; ?>> w -
	<input ONMOUSEOVER="montre_legende('Unknown', '');" ONMOUSEOUT="cache_legende();"  name="sv[service_stalking_options_u]" type="checkbox" value="u" id="templateStalkingOptions" <? if (isset($option_sta["u"])) print "checked"; else if (isset($option_sta_temp["u"]) && !count($option_sta)) echo "checked";?> <? if ($TPL && !$so) echo "disabled"; ?>> u
	<input ONMOUSEOVER="montre_legende('Critical', '');" ONMOUSEOUT="cache_legende();"  name="sv[service_stalking_options_c]" type="checkbox" value="c" id="templateStalkingOptions" <? if (isset($option_sta["c"])) print "checked"; else if (isset($option_sta_temp["c"]) && !count($option_sta)) echo "checked";?> <? if ($TPL && !$so) echo "disabled"; ?>> c
	</td>
</tr>
<tr>
	<td valign="top"><? echo $lang['status']; ?> :</td>
	<td class="text10b">
		<input type="radio" name="sv[service_activate]" value="1" <? if ($services[$sv]->get_activate() && $hosts[$services[$sv]->get_host()]->get_activate()) echo "checked"; ?>> <? echo $lang['enable']; ?>&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="radio" name="sv[service_activate]" value="0" <? if (!$services[$sv]->get_activate() || !$hosts[$services[$sv]->get_host()]->get_activate()) echo "checked"; ?>> <? echo $lang['disable']; ?>
	</td>
</tr>
<tr>
	<td valign="top">Comment :</td>
	<td class="text10b">
	<?
	$ct = NULL;
	$ct_temp = NULL;
	if ($services[$sv]->get_comment())
		$ct = $services[$sv]->get_comment();
	if ($TPL)
		$ct_temp = $services[$TPL]->get_comment();
	if ($TPL)	{ ?>
		<input type="checkbox" onClick="enabledTemplateFieldTarea(this.form.templateComment);" <? if ($ct) echo "checked"; ?>>
	<? } ?>
		<textarea name="sv[service_comment]" cols="25" rows="4" id="templateComment" <? if ($TPL && (($ct_temp && !$ct) || (!$ct_temp && !$ct))) echo "disabled";?>><? if ($ct) echo preg_replace("/(#BLANK#)/", "", $ct); else echo preg_replace("/(#BLANK#)/", "", $ct_temp); ?></textarea>
	</td>
</tr>
<tr>
	<td align="center" colspan="2">
		<input type="hidden" name="sv[service_id]" value="<? echo $sv ?>">
		<input type="submit" name="Changeservice" value="<? echo $lang['save']; ?>" onClick="selectAll(this.form.selectCG); selectAll(this.form.selectSG)">
	</td>
</tr>
</table>
</form>