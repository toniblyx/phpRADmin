<?
/*
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)
For information : toni@blyx.com
*/

if (!isset($oreon))
	exit();

$Nagioscfg = & $oreon->Nagioscfg;

if (isset($_POST["ChangeOPTNAG"]))	{
	$opt_array = & $_POST["opt"];
	if (isset($opt_array["inter_check_delay_method"]) && $opt_array["inter_check_delay_method"] == "v")
		$opt_array["inter_check_delay_method"] = $opt_array["inter_check_delay_method2"];
	if (isset($opt_array["service_inter_check_delay_method"]) && $opt_array["service_inter_check_delay_method"] == "v")
		$opt_array["service_inter_check_delay_method"] = $opt_array["service_inter_check_delay_method2"];
	if (isset($opt_array["host_inter_check_delay_method"]) && $opt_array["host_inter_check_delay_method"] == "v")
		$opt_array["host_inter_check_delay_method"] = $opt_array["host_inter_check_delay_method2"];
	if (isset($opt_array["service_interleave_factor2"]))
		$opt_array["service_interleave_factor"] = $opt_array["service_interleave_factor2"];
	$opt_object = new Nagioscfg($opt_array);
	$Nagioscfg = $opt_object;
	$oreon->saveNagioscfg($opt_object);
	$msg = $lang['nagios_save'];
	unset ($opt_object);
}
include("./include/Nagioscfg/comments.php");

if (isset($msg))
	echo "<div align='left' class='text12b' style='padding-top: 30px;'>$msg</div>";
else 	{ ?>
<form method="post" action="">
<table border="0" align="left" cellpadding="0" cellspacing="0">
<tr>
	<td class='tabTableTitle'>radiusd.conf Configuration</td>
</tr>
<tr>
	<td align="left" class='tabTableForTab'>
	<table border="0" width="330" align="center">
	<tr>
		<td valign="top" align="center">
			<fieldset>
			<legend class="text11b">RADIUS Files</legend>
			<table width="400" cellpadding="2" cellspacing="2" border="0" style="padding:10px">
			<tr>
				<td class="color1" width="30%" style="padding-left:10px"><li>Log file</li></td>
				<td class="color1" width="60%"><input name="opt[log_file]" type="text" size="35" value="<? print $Nagioscfg->log_file ; ?>"></td>
				<td class="color1" width="10%" align="center"><img src="./img/info.gif" ONMOUSEOVER="montre_legende('<? print $nagios_comment["log_file"]; ?>','Log File');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1" width="30%" style="padding-left:10px"><li>cfg Directory</li></td>
				<td class="color1" width="60%"><input name="opt[cfg_pwd]" type="text" size="35" value="<? print $Nagioscfg->cfg_pwd ; ?>"></td>
				<td class="color1" width="10%" align="center"><img src="./img/info.gif" ONMOUSEOVER="montre_legende('<? print $nagios_comment["cfg_file"]; ?>','Log File');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<? if ($oreon->user->get_version() == 2)	{ ?>
			<tr>
				<td class="color1" width="30%" style="padding-left:10px"><li>cfg Cache File</li></td>
				<td class="color1" width="60%"><input name="opt[object_cache_file]" type="text" size="35" value="<? print $Nagioscfg->object_cache_file ; ?>"></td>
				<td class="color1" width="10%" align="center"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["object_cache_file"]; ?>','Object Cache File');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<? } ?>
			<tr>
				<td class="color1" width="30%" style="padding-left:10px"><li>Status File</li></td>
				<td class="color1" width="60%"><input name="opt[status_file]" type="text" size="35" value="<? print $Nagioscfg->stt_file ; ?>"></td>
				<td class="color1" width="10%" align="center"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["status_file"]; ?>','Status File');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1" width="30%" style="padding-left:10px"><li>command_file</li></td>
				<td class="color1" width="60%"><input name="opt[command_file]" type="text" size="35" value="<? print $Nagioscfg->command_file ; ?>"></td>
				<td class="color1" width="10%" align="center"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["command_file"]; ?>','Command File');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1" width="30%" style="padding-left:10px"><li>comment_file</li></td>
				<td class="color1" width="60%"><input name="opt[comment_file]" type="text" size="35" value="<? print $Nagioscfg->comment_file ; ?>"></td>
				<td class="color1" width="10%" align="center"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["comment_file"]; ?>','Comment File');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1" width="30%" style="padding-left:10px"><li>downtime_file</li></td>
				<td class="color1" width="60%"><input name="opt[downtime_file]" type="text" size="35" value="<? print $Nagioscfg->downtime_file ; ?>"></td>
				<td class="color1" width="10%" align="center"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["downtime_file"]; ?>','Downtime File');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1" width="30%" style="padding-left:10px"><li>lock_file</li></td>
				<td class="color1" width="60%"><input name="opt[lock_file]" type="text" size="35" value="<? print $Nagioscfg->lock_file ; ?>"></td>
				<td class="color1" width="10%" align="center"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["lock_file"]; ?>','Lock File');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1" width="30%" style="padding-left:10px"><li>temp_file</li></td>
				<td class="color1" width="60%"><input name="opt[temp_file]" type="text" size="35" value="<? print $Nagioscfg->temp_file ; ?>"></td>
				<td class="color1" width="10%" align="center"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["temp_file"]; ?>','Temp File');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1" width="30%" style="padding-left:10px; white-space: nowrap;"><li>stat_retention_file</li></td>
				<td class="color1" width="60%"><input name="opt[state_retention_file]" type="text" value="<? print $Nagioscfg->state_retention_file ; ?>" size="35"></td>
				<td class="color1" width="10%" align="center"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["state_retention_file"]; ?>','State retention file');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			</table></fieldset>
		</td>
	</tr>
	</table><br><br>
	<table border="0" width="400" align="center">
	<tr>
		<td valign="top" width="400">
			<fieldset><legend class="text11b">Logs Configuration</legend>
			<table width="400" cellpadding="2" cellspacing="2" border="0">
			<tr>
				<td class="color1" style="padding-left:10px"><li>log_rotation_method</li></td>
				<td class="color1" width="30%">
					<select name="opt[log_rotation_method]">
							<option value="n"<? if (!strcmp($Nagioscfg->log_rotation_method, "n")) print "selected"; ?>>None</option>
							<option value="h"<? if (!strcmp($Nagioscfg->log_rotation_method, "h")) print "selected"; ?>>Hourly</option>
							<option value="d"<? if (!strcmp($Nagioscfg->log_rotation_method, "d")) print "selected"; ?>>Daily</option>
							<option value="w"<? if (!strcmp($Nagioscfg->log_rotation_method, "w")) print "selected"; ?>>Weekly</option>
							<option value="m"<? if (!strcmp($Nagioscfg->log_rotation_method, "m")) print "selected"; ?>>Monthly</option>
					</select>
				</td>
				<td class="color1"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["log_rotation_method"]; ?>','Use syslog');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1" style="padding-left:10px"><li>log_archive_path&nbsp;</li></td>
				<td class="color1" width="30%"><input name="opt[log_archive_path]" type="text" size="35" value="<? print $Nagioscfg->log_archive_path ; ?>"></td>
				<td class="color1"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["log_archive_path"]; ?>','Log path Archive');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1" style="padding-left:10px"><li>use_syslog</li></td>
				<td class="color1" width="30%"><select name="opt[use_syslog]"><option value="1" <? if (!strcmp($Nagioscfg->use_syslog, "1")) print "selected"; ?>>Yes</option><option value="0"<? if (!strcmp($Nagioscfg->use_syslog, "0")) print "selected"; ?>>No</option></select></td>
				<td class="color1"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["use_syslog"]; ?>','Use syslog');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1" style="padding-left:10px"><li>log_notifications</li></td>
				<td class="color1" width="30%"><select name="opt[log_notifications]"><option value="1" <? if (!strcmp($Nagioscfg->log_notifications, "1")) print "selected"; ?>>Yes</option><option value="0"<? if (!strcmp($Nagioscfg->log_notifications, "0")) print "selected"; ?>>No</option></select></td>
				<td class="color1"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["log_notifications"]; ?>','log notifications');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1" style="padding-left:10px"><li>log_service_retries</li></td>
				<td class="color1" width="30%"><select name="opt[log_service_retries]"><option value="1" <? if (!strcmp($Nagioscfg->log_service_retries, "1")) print "selected"; ?>>Yes</option><option value="0"<? if (!strcmp($Nagioscfg->log_service_retries, "0")) print "selected"; ?>>No</option></select></td>
				<td class="color1"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["log_service_retries"]; ?>','log service retries');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1" style="padding-left:10px"><li>log_host_retries</li></td>
				<td class="color1" width="30%"><select name="opt[log_host_retries]"><option value="1" <? if (!strcmp($Nagioscfg->log_host_retries, "1")) print "selected"; ?>>Yes</option><option value="0"<? if (!strcmp($Nagioscfg->log_host_retries, "0")) print "selected"; ?>>No</option></select></td>
				<td class="color1"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["log_host_retries"]; ?>','log host retries');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1" style="padding-left:10px"><li>log_event_handlers</li></td>
				<td class="color1" width="30%"><select name="opt[log_event_handlers]"><option value="1" <? if (!strcmp($Nagioscfg->log_event_handlers, "1")) print "selected"; ?>>Yes</option><option value="0"<? if (!strcmp($Nagioscfg->log_event_handlers, "0")) print "selected"; ?>>No</option></select></td>
				<td class="color1"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["log_event_handlers"]; ?>','log_event_handlers');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1" style="padding-left:10px"><li>log_initial_states</li></td>
				<td class="color1" width="30%"><select name="opt[log_initial_states]"><option value="1" <? if (!strcmp($Nagioscfg->log_initial_states, "1")) print "selected"; ?>>Yes</option><option value="0"<? if (!strcmp($Nagioscfg->log_initial_states, "0")) print "selected"; ?>>No</option></select></td>
				<td class="color1"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["log_initial_states"]; ?>','log_initial_states');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1" style="padding-left:10px; white-space: nowrap;"><li>log_external_commands</li></td>
				<td class="color1" width="30%"><select name="opt[log_external_commands]"><option value="1" <? if (!strcmp($Nagioscfg->log_external_commands, "1")) print "selected"; ?>>Yes</option><option value="0"<? if (!strcmp($Nagioscfg->log_external_commands, "0")) print "selected"; ?>>No</option></select></td>
				<td class="color1"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["log_external_commands"]; ?>','log_external_commands');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<? if ($oreon->user->get_version() == 1) { ?>
			<tr>
				<td class="color1" style="padding-left:10px; white-space: nowrap;"><li>log_passive_service_checks</li></td>
				<td class="color1" width="30%"><select name="opt[log_passive_service_checks]"><option value="1" <? if (!strcmp($Nagioscfg->log_passive_service_checks, "1")) print "selected"; ?>>Yes</option><option value="0"<? if (!strcmp($Nagioscfg->log_passive_service_checks, "0")) print "selected"; ?>>No</option></select></td>
				<td class="color1"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["log_passive_service_checks"]; ?>','log_passive_service_checks');" ONMOUSEOUT="cache_legende();"><br><br></td>
			</tr>
			<? } ?>
			<? if ($oreon->user->get_version() == 2) { ?>
			<tr>
				<td class="color1" style="padding-left:10px; white-space: nowrap;"><li>log_passive_checks</li></td>
				<td class="color1" width="30%"><select name="opt[log_passive_checks]"><option value="1" <? if (!strcmp($Nagioscfg->log_passive_checks, "1")) print "selected"; ?>>Yes</option><option value="0"<? if (!strcmp($Nagioscfg->log_passive_checks, "0")) print "selected"; ?>>No</option></select></td>
				<td class="color1"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["log_passive_checks"]; ?>','Log passive checks');" ONMOUSEOUT="cache_legende();"><br><br></td>
			</tr>
			<? } ?>
			</table>
			</fieldset>
		</td>
	</tr>
	</table>
	<br><br>
	<table border="0" width="400" align="center">
	<tr>
		<td valign="top" width="400">
			<fieldset><legend class="text11b"><div ONMOUSEOVER="montre_legende('<? print $nagios_comment["timeout"]; ?>','Timeout');" ONMOUSEOUT="cache_legende();"> Timeouts </div></legend>
			<table width="400" cellpadding="2" cellspacing="2" border="0">
			<tr>
				<td class="color1" style="padding-left:10px"><li>service_check_timeout</li></td>
				<td class="color1" width="30%"><input name="opt[service_check_timeout]" type="text" value="<? print $Nagioscfg->service_check_timeout ; ?>" size="3" maxlength="4"></td>
				<td class="color1"><br></td>
			</tr>
			<tr>
				<td class="color1" style="padding-left:10px"><li>host_check_timeout</li></td>
				<td class="color1" width="30%"><input name="opt[host_check_timeout]" type="text" value="<? print $Nagioscfg->host_check_timeout ; ?>" size="3" maxlength="4"></td>
				<td class="color1"><br></td>
			</tr>
			<tr>
				<td class="color1" style="padding-left:10px"><li>event_handler_timeout</li></td>
				<td class="color1" width="30%"><input name="opt[event_handler_timeout]" type="text" value="<? print $Nagioscfg->event_handler_timeout ; ?>" size="3" maxlength="4"></td>
				<td class="color1"><br></td>
			</tr>
			<tr>
				<td class="color1" style="padding-left:10px"><li>notification_timeout</li></td>
				<td class="color1" width="30%"><input name="opt[notification_timeout]" type="text" value="<? print $Nagioscfg->notification_timeout ; ?>" size="3" maxlength="4"></td>
				<td class="color1"><br></td>
			</tr>
			<tr>
				<td class="color1" style="padding-left:10px"><li>ocsp_timeout</li></td>
				<td class="color1" width="30%"><input name="opt[ocsp_timeout]" type="text" value="<? print $Nagioscfg->ocsp_timeout ; ?>" size="3" maxlength="4"></td>
				<td class="color1"><br></td>
			</tr>
			<? if ($oreon->user->get_version() == 2)	{ ?>
			<tr>
				<td class="color1" style="padding-left:10px"><li>ochp_timeout</li></td>
				<td class="color1" width="30%"><input name="opt[ochp_timeout]" type="text" value="<? print $Nagioscfg->ochp_timeout ; ?>" size="3" maxlength="4"></td>
				<td class="color1"><br></td>
			</tr>
			<? } ?>
			<tr>
				<td class="color1" style="padding-left:10px"><li>perfdata_timeout</li></td>
				<td class="color1" width="30%"><input name="opt[perfdata_timeout]" type="text" value="<? print $Nagioscfg->perfdata_timeout ; ?>" size="3" maxlength="4"></td>
				<td class="color1"><br></td>
			</tr>
			</table>
			</fieldset>
		</td>
	</tr>
	</table>

	<br><br>
	<table border="0" width="400" align="center">
	<tr>
		<td valign="top" width="400">
			<fieldset><legend class="text11b">User / Group / Admin</legend>
			<table width="400" cellpadding="2" cellspacing="2" border="0">
			<tr>
				<td class="color1" style="padding-left:10px"><li>Nagios User</li></td>
				<td class="color1" width="30%"><input name="opt[nagios_user]" type="text" value="<? print $Nagioscfg->nag_user ; ?>" size="10"></td>
				<td class="color1"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["nagios_user"]; ?>','Nagios User');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1" style="padding-left:10px"><li>Nagios Group</li></td>
				<td class="color1" width="30%"><input name="opt[nagios_group]" type="text" value="<? print $Nagioscfg->nag_grp ; ?>" size="10"></td>
				<td class="color1"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["nagios_group"]; ?>','Nagios Group');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1" style="padding-left:10px"><li>admin_email</li></td>
				<td class="color1" width="30%"><input name="opt[admin_email]" type="text" value="<? print $Nagioscfg->admin_email ; ?>"></td>
			<td class="color1"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["admin_email"]; ?>','Admin email');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1" style="padding-left:10px"><li>admin_pager</li></td>
				<td class="color1" width="30%"><input name="opt[admin_pager]" type="text" value="<? print $Nagioscfg->admin_pager ; ?>"></td>
				<td class="color1"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["admin_pager"]; ?>','Admin pager');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			</table>
			</fieldset>
		</td>
	</tr>
	</table><br><br>
	<table border="0" width="400" align="center">
	<tr>
		<td valign="top" width="400">
			<fieldset><legend class="text11b"><div ONMOUSEOVER="montre_legende('<? print $nagios_comment["flap_threshold"]; ?>','Flap threshold');" ONMOUSEOUT="cache_legende();">Flap Detection Threshold</div></legend>
			<table width="400" cellpadding="2" cellspacing="2" border="0">
			<tr>
				<td class="color1" style="padding-left:10px"><li>low_service_flap_threshold</li></td>
				<td class="color1" width="30%"><input name="opt[low_service_flap_threshold]" type="text" value="<? print $Nagioscfg->low_service_flap_threshold ; ?>" size="3" maxlength="6"></td>
				<td class="color1">&nbsp;</td>
			</tr>
			<tr>
				<td class="color1" style="padding-left:10px"><li>high_service_flap_threshold</li></td>
				<td class="color1" width="30%"><input name="opt[high_service_flap_threshold]" type="text" value="<? print $Nagioscfg->high_service_flap_threshold ; ?>" size="3" maxlength="6"></td>
				<td class="color1">&nbsp;</td>
			</tr>
			<tr>
				<td class="color1" style="padding-left:10px"><li>low_host_flap_threshold</li></td>
				<td class="color1" width="30%"><input name="opt[low_host_flap_threshold]" type="text" value="<? print $Nagioscfg->low_host_flap_threshold ; ?>" size="3" maxlength="6"></td>
				<td class="color1">&nbsp;</td>
			</tr>
			<tr>
				<td class="color1" style="padding-left:10px"><li>high_host_flap_threshold</li></td>
				<td class="color1" width="30%"><input name="opt[high_host_flap_threshold]" type="text" value="<? print $Nagioscfg->high_host_flap_threshold ; ?>" size="3" maxlength="6"></td>
				<td class="color1">&nbsp;</td>
			</tr>
			</table>
			</fieldset>
		</td>
	</tr>
	</table>
	<? if ($oreon->user->get_version() == 1) { ?>
	<br><br>
	<table border="0" width="400" align="center">
	<tr>
		<td valign="top" width="400">
			<fieldset><legend class="text11b">Inter check delay method</legend>
			<table width="400" cellpadding="2" cellspacing="2" border="0">
			<tr>
				<td class="color1" width="80%"><br>
				<input name="opt[inter_check_delay_method]" type="radio" value="n" <? if (!strcmp($Nagioscfg->inter_check_delay_method, "n")) print "checked"; ?> onClick="document.getElementById('inter_check_delay_method').disabled = true;"> None - Don't use any delay between checks<br>
				<input name="opt[inter_check_delay_method]" type="radio" value="d" <? if (!strcmp($Nagioscfg->inter_check_delay_method, "d")) print "checked"; ?> onClick="document.getElementById('inter_check_delay_method').disabled = true;"> Use a "dumb" delay of 1 second between checks<br>
				<input name="opt[inter_check_delay_method]" type="radio" value="s" <? if (!strcmp($Nagioscfg->inter_check_delay_method, "s")) print "checked"; ?> onClick="document.getElementById('inter_check_delay_method').disabled = true;"> Use "smart" inter-check delay calculation<br>
				<input name="opt[inter_check_delay_method]" type="radio" value="v" <? if (strcmp($Nagioscfg->inter_check_delay_method, "s") && strcmp($Nagioscfg->inter_check_delay_method, "d") && strcmp($Nagioscfg->inter_check_delay_method, "n")) print "checked"; ?> onClick="document.getElementById('inter_check_delay_method').disabled = false;"> Use an inter_checks delay of x.xx seconds &nbsp;
				<input name="opt[inter_check_delay_method2]" type="text" value="<? if (strcmp($Nagioscfg->inter_check_delay_method, "n") && strcmp($Nagioscfg->inter_check_delay_method, "d") && strcmp($Nagioscfg->inter_check_delay_method, "s") && strcmp($Nagioscfg->inter_check_delay_method, "v")) print $Nagioscfg->inter_check_delay_method; ?>" size="3" maxlength="4" id="inter_check_delay_method"<? if (!strcmp($Nagioscfg->inter_check_delay_method, "d") || !strcmp($Nagioscfg->inter_check_delay_method, "n") || !strcmp($Nagioscfg->inter_check_delay_method, "s")) print "disabled"; ?>><br><br></td>
				<td class="color1" valign="top"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["inter_check"]; ?>','inter check delay method');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			</table>
			</fieldset>
		</td>
	</tr>
	</table>
	<? } ?>
	<? if ($oreon->user->get_version() == 2) { ?>
	<br><br>
	<table border="0" width="400" align="center">
	<tr>
		<td valign="top" width="400">
			<fieldset><legend class="text11b">Service inter check delay method</legend>
			<table width="400" cellpadding="2" cellspacing="2" border="0">
			<tr>
				<td class="color1" width="80%"><br>
				<input name="opt[service_inter_check_delay_method]" type="radio" value="n" <? if (!strcmp($Nagioscfg->service_inter_check_delay_method, "n")) print "checked"; ?> onClick="document.getElementById('service_inter_check_delay_method').disabled = true;"> None - Don't use any delay between checks<br>
				<input name="opt[service_inter_check_delay_method]" type="radio" value="d" <? if (!strcmp($Nagioscfg->service_inter_check_delay_method, "d")) print "checked"; ?> onClick="document.getElementById('service_inter_check_delay_method').disabled = true;"> Use a "dumb" delay of 1 second between checks<br>
				<input name="opt[service_inter_check_delay_method]" type="radio" value="s" <? if (!strcmp($Nagioscfg->service_inter_check_delay_method, "s")) print "checked"; ?> onClick="document.getElementById('service_inter_check_delay_method').disabled = true;"> Use "smart" inter-check delay calculation<br>
				<input name="opt[service_inter_check_delay_method]" type="radio" value="v" <? if (strcmp($Nagioscfg->service_inter_check_delay_method, "s") && strcmp($Nagioscfg->service_inter_check_delay_method, "d") && strcmp($Nagioscfg->service_inter_check_delay_method, "n")) print "checked"; ?> onClick="document.getElementById('service_inter_check_delay_method').disabled = false;"> Use an inter_checks delay of x.xx seconds &nbsp;
				<input name="opt[service_inter_check_delay_method2]" type="text" value="<? if (strcmp($Nagioscfg->service_inter_check_delay_method, "n") && strcmp($Nagioscfg->service_inter_check_delay_method, "d") && strcmp($Nagioscfg->service_inter_check_delay_method, "s") && strcmp($Nagioscfg->service_inter_check_delay_method, "v")) print $Nagioscfg->service_inter_check_delay_method; ?>" size="3" maxlength="4" id="service_inter_check_delay_method"<? if (!strcmp($Nagioscfg->service_inter_check_delay_method, "d") || !strcmp($Nagioscfg->service_inter_check_delay_method, "n") || !strcmp($Nagioscfg->service_inter_check_delay_method, "s")) print "disabled"; ?>><br><br></td>
				<td class="color1" valign="top"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["service_inter_check"]; ?>','Service inter check delay method');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			</table>
			</fieldset>
		</td>
	</tr>
	</table>
	<br><br>
	<table border="0" width="400" align="center">
	<tr>
		<td valign="top" width="400">
			<fieldset><legend class="text11b">Host inter check delay method</legend>
			<table width="400" cellpadding="2" cellspacing="2" border="0">
			<tr>
				<td class="color1" width="80%"><br>
				<input name="opt[host_inter_check_delay_method]" type="radio" value="n" <? if (!strcmp($Nagioscfg->host_inter_check_delay_method, "n")) print "checked"; ?> onClick="document.getElementById('host_inter_check_delay_method').disabled = true;"> None - Don't use any delay between checks<br>
				<input name="opt[host_inter_check_delay_method]" type="radio" value="d" <? if (!strcmp($Nagioscfg->host_inter_check_delay_method, "d")) print "checked"; ?> onClick="document.getElementById('host_inter_check_delay_method').disabled = true;"> Use a "dumb" delay of 1 second between checks<br>
				<input name="opt[host_inter_check_delay_method]" type="radio" value="s" <? if (!strcmp($Nagioscfg->host_inter_check_delay_method, "s")) print "checked"; ?> onClick="document.getElementById('host_inter_check_delay_method').disabled = true;"> Use "smart" inter-check delay calculation<br>
				<input name="opt[host_inter_check_delay_method]" type="radio" value="v" <? if (strcmp($Nagioscfg->host_inter_check_delay_method, "s") && strcmp($Nagioscfg->host_inter_check_delay_method, "d") && strcmp($Nagioscfg->host_inter_check_delay_method, "n")) print "checked"; ?> onClick="document.getElementById('host_inter_check_delay_method').disabled = false;"> Use an inter_checks delay of x.xx seconds &nbsp;
				<input name="opt[host_inter_check_delay_method2]" type="text" value="<? if (strcmp($Nagioscfg->host_inter_check_delay_method, "n") && strcmp($Nagioscfg->host_inter_check_delay_method, "d") && strcmp($Nagioscfg->host_inter_check_delay_method, "s") && strcmp($Nagioscfg->host_inter_check_delay_method, "v")) print $Nagioscfg->host_inter_check_delay_method; ?>" size="3" maxlength="4" id="host_inter_check_delay_method"<? if (!strcmp($Nagioscfg->host_inter_check_delay_method, "d") || !strcmp($Nagioscfg->host_inter_check_delay_method, "n") || !strcmp($Nagioscfg->host_inter_check_delay_method, "s")) print "disabled"; ?>><br><br></td>
				<td class="color1" valign="top"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["host_inter_check"]; ?>','Host inter check delay method');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			</table>
			</fieldset>
		</td>
	</tr>
	</table>
	<br><br>
	<table border="0" width="400" align="center">
	<tr>
		<td valign="top" width="400">
			<fieldset><legend class="text11b">Rescheduling</legend>
			<table width="400" cellpadding="2" cellspacing="2" border="0">
			<tr>
				<td class="color1">auto_reschedule_checks&nbsp;</td>
				<td class="color1"  width="30%"><select name="opt[auto_reschedule_checks]"><option value="1" <? if (!strcmp($Nagioscfg->auto_reschedule_checks, "1")) print "selected"; ?>>Yes</option><option value="0"<? if (!strcmp($Nagioscfg->auto_reschedule_checks, "0")) print "selected"; ?>>No</option></select></td>
				<td class="color1"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["auto_reschedule_checks"]; ?>','Auto reschedule checks');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1" >auto_rescheduling_interval&nbsp;</td>
				<td class="color1"  width="30%"><input name="opt[auto_rescheduling_interval]" type="text" value="<? print $Nagioscfg->auto_rescheduling_interval ; ?>" size="3"></td>
				<td class="color1" ><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["auto_rescheduling_interval"]; ?>','Auto rescheduling interval');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1" >auto_rescheduling_window&nbsp;</td>
				<td class="color1"  width="30%"><input name="opt[auto_rescheduling_window]" type="text" value="<? print $Nagioscfg->auto_rescheduling_window ; ?>" size="3"></td>
				<td class="color1" ><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["auto_rescheduling_window"]; ?>','Auto rescheduling window');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			</table>
			</fieldset>
		</td>
	</tr>
	</table>
	<? } ?>
	<br><br>
	<table border="0" width="400" align="center">
	<tr>
		<td valign="top" width="400">
			<fieldset><legend class="text11b">Date Format</legend>
			<table width="400" cellpadding="2" cellspacing="2" border="0">
			<tr>
				<td class="color1"  width="90%"><br>
				<ul>
					<select name="opt[date_format]">
						<option value="us" <? if (!strcmp($Nagioscfg->date_format, "us")) print "selected" ; ?>>us - (MM-DD-YYYY HH:MM:SS)</option>
						<option value="euro" <? if (!strcmp($Nagioscfg->date_format, "euro")) print "selected" ; ?>>euro - (DD-MM-YYYY HH:MM:SS)</option>
						<option value="iso8601" <? if (!strcmp($Nagioscfg->date_format, "iso8601")) print "selected" ; ?>>iso8601 - (YYYY-MM-DD HH:MM:SS)</option>
						<option value="Strict-iso8601" <? if (!strcmp($Nagioscfg->date_format, "Strict-iso8601")) print "selected" ; ?>>Strict-iso8601 - (YYYY-MM-DDTHH:MM:SS)</option>
					</select>
				</ul>
				</td>
				<td class="color1" ><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["date_format"]; ?>','Date format');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			</table>
			</fieldset>
		</td>
	</tr>
	</table>
	<br><br>
	<table border="0" width="400" align="center">
	<tr>
		<td valign="top" width="400">
			<fieldset><legend class="text11b">Check Options</legend>
			<table width="400" cellpadding="2" cellspacing="2" border="0">
			<? if ($oreon->user->get_version() == 2)	{ ?>
			<tr>
				<td class="color1">max_service_check_spread&nbsp;</td>
				<td class="color1"  width="30%"><input name="opt[max_service_check_spread]" type="text" value="<? print $Nagioscfg->max_service_check_spread ; ?>" size="3" maxlength="3"></td>
				<td class="color1"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["max_service_check_spread"]; ?>','Max service check spread');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1">max_host_check_spread&nbsp;</td>
				<td class="color1"  width="30%"><input name="opt[max_host_check_spread]" type="text" value="<? print $Nagioscfg->max_host_check_spread ; ?>" size="3" maxlength="3"></td>
				<td class="color1"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["max_host_check_spread"]; ?>','Max host check spread');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<? } ?>
			<tr>
				<td class="color1">max_concurrent_checks&nbsp;</td>
				<td class="color1"  width="30%"><input name="opt[max_concurrent_checks]" type="text" value="<? print $Nagioscfg->max_concurrent_checks ; ?>" size="3" maxlength="3"></td>
				<td class="color1"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["max_concurrent_checks"]; ?>','Max concurrent checks');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1">use_agressive_host_checking&nbsp;</td>
				<td class="color1"  width="30%"><select name="opt[use_agressive_host_checking]"><option value="1" <? if (!strcmp($Nagioscfg->use_agressive_host_checking, "1")) print "selected"; ?>>Yes</option><option value="0"<? if (!strcmp($Nagioscfg->use_agressive_host_checking, "0")) print "selected"; ?>>No</option></select></td>
				<td class="color1"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["use_agressive_host_checking"]; ?>','Use agressive host checking');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1">execute_service_checks&nbsp;</td>
				<td class="color1"  width="30%"><select name="opt[execute_service_checks]"><option value="1" <? if (!strcmp($Nagioscfg->execute_service_checks, "1")) print "selected"; ?>>Yes</option><option value="0"<? if (!strcmp($Nagioscfg->execute_service_checks, "0")) print "selected"; ?>>No</option></select></td>
				<td class="color1" ><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["execute_service_checks"]; ?>','Execute service checks');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1" >accept_passive_service_checks&nbsp;</td>
				<td class="color1"  width="30%"><select name="opt[accept_passive_service_checks]"><option value="1" <? if (!strcmp($Nagioscfg->accept_passive_service_checks, "1")) print "selected"; ?>>Yes</option><option value="0"<? if (!strcmp($Nagioscfg->accept_passive_service_checks, "0")) print "selected"; ?>>No</option></select></td>
				<td class="color1" ><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["accept_passive_service_checks"]; ?>','Accept passive service checks');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<? if ($oreon->user->get_version() == 2)	{	?>
			<tr>
				<td class="color1" >execute_host_checks&nbsp;</td>
				<td class="color1"  width="30%"><select name="opt[execute_host_checks]"><option value="1" <? if (!strcmp($Nagioscfg->execute_host_checks, "1")) print "selected"; ?>>Yes</option><option value="0"<? if (!strcmp($Nagioscfg->execute_host_checks, "0")) print "selected"; ?>>No</option></select></td>
				<td class="color1" ><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["execute_host_checks"]; ?>','Execute host checks');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1" >accept_passive_host_checks&nbsp;</td>
				<td class="color1"  width="30%"><select name="opt[accept_passive_host_checks]"><option value="1" <? if (!strcmp($Nagioscfg->accept_passive_host_checks, "1")) print "selected"; ?>>Yes</option><option value="0"<? if (!strcmp($Nagioscfg->accept_passive_host_checks, "0")) print "selected"; ?>>No</option></select></td>
				<td class="color1" ><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["accept_passive_host_checks"]; ?>','Accept passive host checks');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<? } ?>
			<tr>
				<td class="color1" >check_for_orphaned_services&nbsp;</td>
				<td class="color1"  width="30%"><select name="opt[check_for_orphaned_services]"><option value="1" <? if (!strcmp($Nagioscfg->check_for_orphaned_services, "1")) print "selected"; ?>>Yes</option><option value="0"<? if (!strcmp($Nagioscfg->check_for_orphaned_services, "0")) print "selected"; ?>>No</option></select></td>
				<td class="color1" ><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["check_for_orphaned_services"]; ?>','check for orphaned services');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<? if ($oreon->user->get_version() == 2)	{ ?>
			<tr>
				<td class="color1" >check_host_freshness&nbsp;</td>
				<td class="color1"  width="30%"><select name="opt[check_host_freshness]"><option value="1" <? if (!strcmp($Nagioscfg->check_host_freshness, "1")) print "selected"; ?>>Yes</option><option value="0"<? if (!strcmp($Nagioscfg->check_host_freshness, "0")) print "selected"; ?>>No</option></select></td>
				<td class="color1" ><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["check_host_freshness"]; ?>','check host freshness');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1" >host_freshness_check_interval&nbsp;</td>
				<td class="color1"  width="30%"><input name="opt[host_freshness_check_interval]" type="text" value="<? print $Nagioscfg->host_freshness_check_interval ; ?>" size="4" maxlength="5"></td>
				<td class="color1" ><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["host_freshness_check_interval"]; ?>','Host freshness check interval');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<? } ?>
			<tr>
				<td class="color1" >check_service_freshness&nbsp;</td>
				<td class="color1"  width="30%"><select name="opt[check_service_freshness]"><option value="1" <? if (!strcmp($Nagioscfg->check_service_freshness, "1")) print "selected"; ?>>Yes</option><option value="0"<? if (!strcmp($Nagioscfg->check_service_freshness, "0")) print "selected"; ?>>No</option></select></td>
				<td class="color1" ><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["check_service_freshness"]; ?>','Check service freshness');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<? if ($oreon->user->get_version() == 1)	{ ?>
			<tr>
				<td class="color1" >freshness_check_interval&nbsp;</td>
				<td class="color1"  width="30%"><input name="opt[freshness_check_interval]" type="text" value="<? print $Nagioscfg->freshness_check_interval ; ?>" size="4" maxlength="5"></td>
				<td class="color1" ><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["freshness_check_interval"]; ?>','Freshness check interval');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<? } ?>
			<? if ($oreon->user->get_version() == 2)	{ ?>
			<tr>
				<td class="color1" >service_freshness_check_interval&nbsp;</td>
				<td class="color1"  width="30%"><input name="opt[service_freshness_check_interval]" type="text" value="<? print $Nagioscfg->service_freshness_check_interval ; ?>" size="4" maxlength="5"></td>
				<td class="color1" ><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["service_freshness_check_interval"]; ?>','Service freshness check interval');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<? } ?>
			<tr>
				<td class="color1">command_check_interval&nbsp;</td>
				<td class="color1"  width="30%"><input name="opt[command_check_interval]" type="text" value="<? print $Nagioscfg->command_check_interval ; ?>" size="4"></td>
				<td class="color1"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["command_check_interval"]; ?>','Command check interval');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1">Check external commands</td>
				<td class="color1" width="30%"><select name="opt[check_external_commands]"><option value="1" <? if (!strcmp($Nagioscfg->check_external_commands, "1")) print "selected"; ?>>Yes</option><option value="0"<? if (!strcmp($Nagioscfg->check_external_commands, "0")) print "selected"; ?>>No</option></select></td>
				<td class="color1"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["check_external_commands"]; ?>','Check external commands');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			</table>
			</fieldset>
		</td>
	</tr>
	</table>
	<br><br>
	<? if ($oreon->user->get_version() == 2 )	{ ?>
	<table border="0" width="400" align="center">
	<tr>
		<td valign="top" width="400">
			<fieldset><legend class="text11b">Perfdata</legend>
			<table width="400" cellpadding="2" cellspacing="2" border="0">
			<tr>
				<td class="color1" >host_perfdata_command&nbsp;</td>
				<td class="color1"  width="30%">
					<select name="opt[host_perfdata_command]">
						<option></option>
						<? if (isset($oreon->commands))
								foreach($oreon->commands as $cmd)	{
									if (!strstr($cmd->get_name(), "check_graph")){
										echo "<option value='".$cmd->get_name()."'";
										if (!strcmp($cmd->get_name(), $Nagioscfg->host_perfdata_command))
											echo " selected";
										echo ">".$cmd->get_name()."</option>";
									}
									unset ($cmd);
								}
						?>
					</select>
				</td>
				<td class="color1" ><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["host_perfdata_command"]; ?>','Host perfdata command');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1" >service_perfdata_command&nbsp;</td>
				<td class="color1"  width="30%">
					<select name="opt[service_perfdata_command]">
						<option></option>
						<? if (isset($oreon->commands))
								foreach($oreon->commands as $cmd)	{
									if (!strstr($cmd->get_name(), "check_graph")){
										echo "<option value='".$cmd->get_name()."'";
										if (!strcmp($cmd->get_name(), $Nagioscfg->service_perfdata_command))
											echo " selected";
										echo ">".$cmd->get_name()."</option>";
									}
									unset ($cmd);
								}
						?>
					</select>
				</td>
				<td class="color1" ><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["service_perfdata_command"]; ?>','Service perfdata command');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1">host_perfdata_file</td>
				<td class="color1" width="60%"><input name="opt[host_perfdata_file]" type="text" size="35" value="<? print $Nagioscfg->host_perfdata_file ; ?>"></td>
				<td class="color1" width="10%" align="center"><img src="./img/info.gif" ONMOUSEOVER="montre_legende('<? print $nagios_comment["host_perfdata_file"]; ?>','Host perfdata file');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1">service_perfdata_file</td>
				<td class="color1" width="60%"><input name="opt[service_perfdata_file]" type="text" size="35" value="<? print $Nagioscfg->service_perfdata_file ; ?>"></td>
				<td class="color1" width="10%" align="center"><img src="./img/info.gif" ONMOUSEOVER="montre_legende('<? print $nagios_comment["service_perfdata_file"]; ?>','Service perfdata file');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1">host_perfdata_file_template</td>
				<td class="color1" width="60%"><input name="opt[host_perfdata_file_template]" type="text" size="35" value="<? print $Nagioscfg->host_perfdata_file_template ; ?>"></td>
				<td class="color1" width="10%" align="center"><img src="./img/info.gif" ONMOUSEOVER="montre_legende('<? print $nagios_comment["host_perfdata_file_template"]; ?>','Host perfdata file template');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1">service_perfdata_file_template</td>
				<td class="color1" width="60%"><input name="opt[service_perfdata_file_template]" type="text" size="35" value="<? print $Nagioscfg->service_perfdata_file_template ; ?>"></td>
				<td class="color1" width="10%" align="center"><img src="./img/info.gif" ONMOUSEOVER="montre_legende('<? print $nagios_comment["service_perfdata_file_template"]; ?>','Service perfdata file template');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1">host_perfdata_file_mode</td>
				<td class="color1" width="60%"><input name="opt[host_perfdata_file_mode]" type="text" size="1" value="<? print $Nagioscfg->host_perfdata_file_mode ; ?>"></td>
				<td class="color1" width="10%" align="center"><img src="./img/info.gif" ONMOUSEOVER="montre_legende('<? print $nagios_comment["host_perfdata_file_mode"]; ?>','Host perfdata file mode');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1">service_perfdata_file_mode</td>
				<td class="color1" width="60%"><input name="opt[service_perfdata_file_mode]" type="text" size="1" value="<? print $Nagioscfg->service_perfdata_file_mode ; ?>"></td>
				<td class="color1" width="10%" align="center"><img src="./img/info.gif" ONMOUSEOVER="montre_legende('<? print $nagios_comment["service_perfdata_file_mode"]; ?>','Service perfdata file mode');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1">host_perfdata_file_processing_interval&nbsp;</td>
				<td class="color1"  width="30%"><input name="opt[host_perfdata_file_processing_interval]" type="text" size="5" value="<? print $Nagioscfg->host_perfdata_file_processing_interval ; ?>"></td>
				<td class="color1"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["host_perfdata_file_processing_interval"]; ?>','Host perfdata file processing interval');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1">service_perfdata_file_processing_interval&nbsp;</td>
				<td class="color1"  width="30%"><input name="opt[service_perfdata_file_processing_interval]" type="text" size="5" value="<? print $Nagioscfg->service_perfdata_file_processing_interval ; ?>"></td>
				<td class="color1"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["service_perfdata_file_processing_interval"]; ?>','Service perfdata file processing interval');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1">host_perfdata_file_processing_command&nbsp;</td>
				<td class="color1"  width="30%">
					<select name="opt[host_perfdata_file_processing_command]">
						<option></option>
						<? if (isset($oreon->commands))
								foreach($oreon->commands as $cmd)	{
									if (!strstr($cmd->get_name(), "check_graph")){
										echo "<option value='".$cmd->get_name()."'";
										if (!strcmp($cmd->get_name(), $Nagioscfg->host_perfdata_file_processing_command))
											echo " selected";
										echo ">".$cmd->get_name()."</option>";
									}
									unset ($cmd);
								}
						?>
					</select>
				</td>
				<td class="color1"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["host_perfdata_file_processing_command"]; ?>','Host perfdata file processing interval command');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1">service_perfdata_file_processing_command&nbsp;</td>
				<td class="color1"  width="30%">
					<select name="opt[service_perfdata_file_processing_command]">
						<option></option>
						<? if (isset($oreon->commands))
								foreach($oreon->commands as $cmd)	{
									if (!strstr($cmd->get_name(), "check_graph")){
										echo "<option value='".$cmd->get_name()."'";
										if (!strcmp($cmd->get_name(), $Nagioscfg->service_perfdata_file_processing_command))
											echo " selected";
										echo ">".$cmd->get_name()."</option>";
									}
									unset ($cmd);
								}
						?>
					</select>
				</td>
				<td class="color1"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["service_perfdata_file_processing_command"]; ?>','Service perfdata file processing interval command');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			</table>
			</fieldset>
		</td>
	</tr>
	</table>
	<br><br>
	<? } ?>
	<table border="0" width="400" align="center">
	<tr>
		<td valign="top" width="400">
			<fieldset><legend class="text11b">Others Things</legend>
			<table width="400" cellpadding="2" cellspacing="2" border="0">
			<tr>
				<td class="color1">service_interleave_factors &nbsp;</td>
				<td class="color1"width="30%"><input name="opt[service_interleave_factor]" type="checkbox" value="s" <? if (!strcmp($Nagioscfg->service_interleave_factor, "s")) print "checked"; ?>> other (>= 1)<input name="opt[service_interleave_factor2]" type="text" value="<? if (strcmp($Nagioscfg->service_interleave_factor, "") && strcmp($Nagioscfg->service_interleave_factor, "s")) print $Nagioscfg->service_interleave_factor; ?>" size="5" disabled></td>
				<td class="color1"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["service_interleave_factor"]; ?>','service_interleave_factor');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1">service_reaper_frequency&nbsp;</td>
				<td class="color1"  width="30%"><input name="opt[service_reaper_frequency]" type="text" value="<? print $Nagioscfg->service_reaper_frequency ; ?>"></td>
				<td class="color1"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["service_reaper_frequency"]; ?>','Service reaper frequency');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1">sleep_time&nbsp;</td>
				<td class="color1"  width="30%"><input name="opt[sleep_time]" type="text" value="<? print $Nagioscfg->sleep_time ; ?>" size="4" maxlength="4"></td>
				<td class="color1"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["sleep_time"]; ?>','Sleep time');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1">retain_stat_information&nbsp;</td>
				<td class="color1"  width="30%"><select name="opt[retain_state_information]"><option value="1" <? if (!strcmp($Nagioscfg->retain_state_information, "1")) print "selected"; ?>>Yes</option><option value="0"<? if (!strcmp($Nagioscfg->retain_state_information, "0")) print "selected"; ?>>No</option></select></td>
				<td class="color1"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["retain_state_information"]; ?>','retain state information');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1">retention_update_interval&nbsp;</td>
				<td class="color1"  width="30%"><input name="opt[retention_update_interval]" type="text" value="<? print $Nagioscfg->retention_update_interval ; ?>" size="3" maxlength="4"></td>
				<td class="color1"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["retention_update_interval"]; ?>','Retention update interval');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1">use_retained_program_state&nbsp;</td>
				<td class="color1"  width="30%"><select name="opt[use_retained_program_state]"><option value="1" <? if (!strcmp($Nagioscfg->use_retained_program_state, "1")) print "selected"; ?>>Yes</option><option value="0"<? if (!strcmp($Nagioscfg->use_retained_program_state, "0")) print "selected"; ?>>No</option></select></td>
				<td class="color1"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["use_retained_program_state"]; ?>','Use retained program state');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<? if ($oreon->user->get_version() == 2)	{ ?>
			<tr>
				<td class="color1">use_retained_scheduling_info&nbsp;</td>
				<td class="color1"  width="30%"><select name="opt[use_retained_scheduling_info]"><option value="1" <? if (!strcmp($Nagioscfg->use_retained_scheduling_info, "1")) print "selected"; ?>>Yes</option><option value="0"<? if (!strcmp($Nagioscfg->use_retained_scheduling_info, "0")) print "selected"; ?>>No</option></select></td>
				<td class="color1"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["use_retained_scheduling_info"]; ?>','Use retained scheduling info');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<? } ?>
			<tr>
				<td class="color1">interval_length&nbsp;</td>
				<td class="color1"  width="30%"><input name="opt[interval_length]" type="text" value="<? print $Nagioscfg->interval_length ; ?>" size="3" maxlength="4"></td>
				<td class="color1"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["interval_length"]; ?>','Interval length');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1" >enable_notifications&nbsp;</td>
				<td class="color1"  width="30%"><select name="opt[enable_notifications]"><option value="1" <? if (!strcmp($Nagioscfg->enable_notifications, "1")) print "selected"; ?>>Yes</option><option value="0"<? if (!strcmp($Nagioscfg->enable_notifications, "0")) print "selected"; ?>>No</option></select></td>
				<td class="color1" ><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["enable_notifications"]; ?>','Enable notifications');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1" >enable_event_handlers&nbsp;</td>
				<td class="color1"  width="30%"><select name="opt[enable_event_handlers]"><option value="1" <? if (!strcmp($Nagioscfg->enable_event_handlers, "1")) print "selected"; ?>>Yes</option><option value="0"<? if (!strcmp($Nagioscfg->enable_event_handlers, "0")) print "selected"; ?>>No</option></select></td>
				<td class="color1" ><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["enable_event_handlers"]; ?>','Enable event handlers');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1" >process_performance_data&nbsp;</td>
				<td class="color1"  width="30%"><select name="opt[process_performance_data]"><option value="1" <? if (!strcmp($Nagioscfg->process_performance_data, "1")) print "selected"; ?>>Yes</option><option value="0"<? if (!strcmp($Nagioscfg->process_performance_data, "0")) print "selected"; ?>>No</option></select></td>
				<td class="color1" ><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["process_performance_data"]; ?>','Process performance data');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1" >obsess_over_services&nbsp;</td>
				<td class="color1"  width="30%"><select name="opt[obsess_over_services]"><option value="1" <? if (!strcmp($Nagioscfg->obsess_over_services, "1")) print "selected"; ?>>Yes</option><option value="0"<? if (!strcmp($Nagioscfg->obsess_over_services, "0")) print "selected"; ?>>No</option></select></td>
				<td class="color1" ><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["obsess_over_services"]; ?>','Obsess over services');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<? if ($oreon->user->get_version() == 2)	{ ?>
			<tr>
				<td class="color1" >obsess_over_hosts&nbsp;</td>
				<td class="color1"  width="30%"><select name="opt[obsess_over_hosts]"><option value="1" <? if (!strcmp($Nagioscfg->obsess_over_hosts, "1")) print "selected"; ?>>Yes</option><option value="0"<? if (!strcmp($Nagioscfg->obsess_over_hosts, "0")) print "selected"; ?>>No</option></select></td>
				<td class="color1" ><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["obsess_over_hosts"]; ?>','Obsess over hosts');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<? } ?>
			<tr>
				<td class="color1" >ocsp_command&nbsp;</td>
				<td class="color1"  width="30%">
					<select name="opt[ocsp_command]">
						<option></option>
						<? if (isset($oreon->commands))
								foreach($oreon->commands as $cmd)	{
									if (!strstr($cmd->get_name(), "check_graph")){
										echo "<option value='".$cmd->get_name()."'";
										if (!strcmp($cmd->get_name(), $Nagioscfg->ocsp_command))
											echo " selected";
										echo ">".$cmd->get_name()."</option>";
									}
									unset ($cmd);
								}
						?>
					</select>
				</td>
				<td class="color1" ><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["ocsp_command"]; ?>','Ocsp command');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<? if ($oreon->user->get_version() == 2) { ?>
			<tr>
				<td class="color1" >oshp_command&nbsp;</td>
				<td class="color1"  width="30%">
					<select name="opt[ochp_command]">
						<option></option>
						<? if (isset($oreon->commands))
								foreach($oreon->commands as $cmd)	{
									if (!strstr($cmd->get_name(), "check_graph")){
										echo "<option value='".$cmd->get_name()."'";
										if (!strcmp($cmd->get_name(), $Nagioscfg->ochp_command))
											echo " selected";
										echo ">".$cmd->get_name()."</option>";
									}
									unset ($cmd);
								}
						?>
					</select>
				</td>
				<td class="color1" ><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["ochp_command"]; ?>','Ochp command');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<? } ?>
			<tr>
				<td class="color1" >aggregate_status_updates&nbsp;</td>
				<td class="color1"  width="30%"><select name="opt[aggregate_status_updates]"><option value="1" <? if (!strcmp($Nagioscfg->aggregate_status_updates, "1")) print "selected"; ?>>Yes</option><option value="0"<? if (!strcmp($Nagioscfg->aggregate_status_updates, "0")) print "selected"; ?>>No</option></select></td>
				<td class="color1" ><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["aggregate_status_updates"]; ?>','Aggregate status updates');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1" >status_update_interval&nbsp;</td>
				<td class="color1"  width="30%"><input name="opt[status_update_interval]" type="text" value="<? print $Nagioscfg->status_update_interval ; ?>" size="3" maxlength="4"></td>
				<td class="color1" ><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["status_update_interval"]; ?>','Status update interval');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1" >enable_flap_detection&nbsp;</td>
				<td class="color1"  width="30%"><select name="opt[enable_flap_detection]"><option value="1" <? if (!strcmp($Nagioscfg->enable_flap_detection, "1")) print "selected"; ?>>Yes</option><option value="0"<? if (!strcmp($Nagioscfg->enable_flap_detection, "0")) print "selected"; ?>>No</option></select></td>
				<td class="color1" ><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["enable_flap_detection"]; ?>','Enable flap detection');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			</table>
		</td>
		</tr>
	</table>
	<br><br>
	<table border="0" width="400" align="center">
	<tr>
		<td valign="top" width="400">
			<fieldset><legend class="text11b">Illegal Chars and matching</legend>
			<table width="400" cellpadding="2" cellspacing="2" border="0">
			<tr>
				<td class="color1" >illegal_object_name_chars&nbsp;</td>
				<td class="color1"  width="30%"><input name="opt[illegal_object_name_chars]" type="text" value="<? print htmlspecialchars(stripslashes($Nagioscfg->illegal_object_name_chars)) ; ?>"></td>
				<td class="color1" align="center"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["illegal_object_name_chars"]; ?>','Illegal object name chars');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1" >illegal_macro_output_chars&nbsp;</td>
				<td class="color1"  width="30%"><input name="opt[illegal_macro_output_chars]" type="text" value="<? print htmlspecialchars(stripslashes($Nagioscfg->illegal_macro_output_chars)) ; ?>"></td>
				<td class="color1" align="center"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["illegal_macro_output_chars"]; ?>','Illegal macro output chars');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<? if ($oreon->user->get_version() == 2)	{ ?>
			<tr>
				<td class="color1" >use_regexp_matching&nbsp;</td>
				<td class="color1"  width="30%"><select name="opt[use_regexp_matching]"><option value="1" <? if (!strcmp($Nagioscfg->use_regexp_matching, "1")) print "selected"; ?>>Yes</option><option value="0"<? if (!strcmp($Nagioscfg->use_regexp_matching, "0")) print "selected"; ?>>No</option></select></td>
				<td class="color1" ><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["use_regexp_matching"]; ?>','Use regexp matching');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="color1" >use_true_regexp_matching&nbsp;</td>
				<td class="color1"  width="30%"><select name="opt[use_true_regexp_matching]"><option value="1" <? if (!strcmp($Nagioscfg->use_true_regexp_matching, "1")) print "selected"; ?>>Yes</option><option value="0"<? if (!strcmp($Nagioscfg->use_true_regexp_matching, "0")) print "selected"; ?>>No</option></select></td>
				<td class="color1" ><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $nagios_comment["use_true_regexp_matching"]; ?>','Use true regexp matching');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<? } ?>
			</table>
		</td>
		</tr>
	</table>
	<center><input name="ChangeOPTNAG" type="submit" value="<? print $lang["save"]; ?>"></center>
</td>
</tr>
</table>
</form>
<? } ?>