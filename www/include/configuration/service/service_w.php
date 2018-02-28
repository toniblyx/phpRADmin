<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/?>
<table acellpadding="0" cellspacing="3" width="350" align='center'">
<? if ($services[$sv]->get_service_template())	{
	$stm_id = $services[$sv]->get_service_template();
?>
<tr>
	<td colspan="2" align="center" class="text10b" width="50%">
		<? echo $lang["stm_use"].":<br>"."<a href='phpradmin.php?p=125&stm_id=$stm_id&o=w' class='text10bc'>".$services[$stm_id]->get_description()."</a>"; ?>
	</td>
</tr>
<? } ?>
<tr>
	<td>Host name :</td>
	<td class="text10b"><? echo $hosts[$services[$sv]->get_host()]->get_name(); ?></td>
</tr>
<tr>
	<td>Description :</td>
	<td class="text10b"><? echo $services[$sv]->get_description(); ?></td>
</tr>
<tr>
	<td>Is Volatile :</td>
	<td class="text10b">
	<?
	if ($services[$sv]->get_is_volatile() && $services[$sv]->get_is_volatile() != 2)
		echo $value_flag[$services[$sv]->get_is_volatile()];
	else if ($services[$sv]->get_service_template() && $services[$services[$sv]->get_service_template()]->get_is_volatile())
		echo $value_flag[$services[$services[$sv]->get_service_template()]->get_is_volatile()];
	else
		echo $value_flag[2];
	?>
	</td>
</tr>
<tr>
	<td>Service Groups :</td>
	<td class="text10b" style="white-space: nowrap;">
	<?
	if (isset($services[$sv]->serviceGroups) && count($services[$sv]->serviceGroups))	{
		foreach ($services[$sv]->serviceGroups as $sg)	{
			echo "<li><a href='phpradmin.php?p=105&sg=" .$sg->get_id(). "&o=w' class='text10' style='white-space: nowrap;";
			if(!$sg->get_activate())
				echo " text-decoration: line-through;";
			echo "'>".$sg->get_name()."</a></li>";
			unset($sg);
		}
	} else if ($services[$sv]->get_service_template() && count($services[$services[$sv]->get_service_template()]->serviceGroups))
		foreach ($services[$services[$sv]->get_service_template()]->serviceGroups as $sg)	{
			echo "<li><a href='phpradmin.php?p=105&sg=" .$sg->get_id(). "&o=w' class='text10' style='white-space: nowrap;";
			if(!$sg->get_activate())
				echo " text-decoration: line-through;";
			echo "'>".$sg->get_name()."</a></li>";
			unset($sg);
		}
	?>
	</td>
</tr>
<tr>
	<td>Check_command :</td>
	<td class="text10b">
		<?
		if ($services[$sv]->get_check_command())
			echo $commands[$services[$sv]->get_check_command()]->get_name();
		else if ($services[$sv]->get_service_template() && $services[$services[$sv]->get_service_template()]->get_check_command())
			echo $commands[$services[$services[$sv]->get_service_template()]->get_check_command()]->get_name();
		?>
	</td>
</tr>
<tr>
	<td style="white-space: nowrap;">Check_command_arguments :</td>
	<td class="text10b" style="white-space:nowrap;">
		<?
		$check_command_arg = NULL;
		if ($services[$sv]->get_check_command_arg() && $services[$sv]->get_check_command_arg() != "!".$sv)
			$check_command_arg = $services[$sv]->get_check_command_arg();
		else if ($services[$sv]->get_service_template() && $services[$services[$sv]->get_service_template()]->get_check_command_arg())
			$check_command_arg = $services[$services[$sv]->get_service_template()]->get_check_command_arg();
		if ($services[$sv]->get_check_command() && strstr($commands[$services[$sv]->get_check_command()]->get_name(), "check_graph"))
			$check_command_arg = preg_replace("/(\![0-9]+)$/", "", $check_command_arg);
		else if ($services[$sv]->get_service_template() && $services[$services[$sv]->get_service_template()]->get_check_command() && strstr($commands[$services[$services[$sv]->get_service_template()]->get_check_command()]->get_name(), "check_graph"))
			$check_command_arg = preg_replace("/(\![0-9]+)$/", "", $check_command_arg);
		if (isset($check_command_arg))
			echo preg_replace("/(#BLANK#)/", "", $check_command_arg);
		?>
	</td>
</tr>
<tr>
	<td>Max_check_attempts :</td>
	<td class="text10b">
		<?
		if ($services[$sv]->get_max_check_attempts())
			echo $services[$sv]->get_max_check_attempts();
		else if ($services[$sv]->get_service_template() && $services[$services[$sv]->get_service_template()]->get_max_check_attempts())
			echo $services[$services[$sv]->get_service_template()]->get_max_check_attempts();
		?>
	</td>
</tr>
<tr>
	<td>Normal_check_interval :</td>
	<td class="text10b">
		<?
		if ($services[$sv]->get_normal_check_interval())
			echo $services[$sv]->get_normal_check_interval()." * ".$oreon->Nagioscfg->get_interval_length()." ".$lang["time_sec"];
		else if ($services[$sv]->get_service_template() && $services[$services[$sv]->get_service_template()]->get_normal_check_interval())
			echo $services[$services[$sv]->get_service_template()]->get_normal_check_interval()." * ". $oreon->Nagioscfg->interval_length . " " .$lang["time_sec"];
		?>
	</td>
</tr>
<tr>
	<td>Retry_check_interval :</td>
	<td class="text10b">
		<?
		if ($services[$sv]->get_retry_check_interval())
			echo $services[$sv]->get_retry_check_interval()." * ".$oreon->Nagioscfg->get_interval_length()." ".$lang["time_sec"];
		else if ($services[$sv]->get_service_template() && $services[$services[$sv]->get_service_template()]->get_retry_check_interval())
			echo $services[$services[$sv]->get_service_template()]->get_retry_check_interval()." * ".$oreon->Nagioscfg->get_interval_length()." ".$lang["time_sec"];
		?>
	</td>
</tr>
<tr>
	<td>Active_checks_enabled :</td>
	<td class="text10b">
		<?
		if ($services[$sv]->get_active_checks_enabled() && $services[$sv]->get_active_checks_enabled() != 2)
			echo $value_flag[$services[$sv]->get_active_checks_enabled()];
		else if ($services[$sv]->get_service_template() && $services[$services[$sv]->get_service_template()]->get_active_checks_enabled())
			echo $value_flag[$services[$services[$sv]->get_service_template()]->get_active_checks_enabled()];
		else
			echo $value_flag[2];
		?>
	</td>
</tr>
<tr>
	<td>Passive_checks_enabled :</td>
	<td class="text10b">
		<?
		if ($services[$sv]->get_passive_checks_enabled() && $services[$sv]->get_passive_checks_enabled() != 2)
			echo $value_flag[$services[$sv]->get_passive_checks_enabled()];
		else if ($services[$sv]->get_service_template() && $services[$services[$sv]->get_service_template()]->get_passive_checks_enabled())
			echo $value_flag[$services[$services[$sv]->get_service_template()]->get_passive_checks_enabled()];
		else
			echo $value_flag[2];
		?>
	</td>
</tr>
<tr>
	<td>Check_period :</td>
	<td class="text10b">
		<?
		if ($services[$sv]->get_check_period())
			echo $timePeriods[$services[$sv]->get_check_period()]->get_name();
		else if ($services[$sv]->get_service_template() && $services[$services[$sv]->get_service_template()]->get_check_period())
			echo $timePeriods[$services[$services[$sv]->get_service_template()]->get_check_period()]->get_name();
		?>
	</td>
</tr>
<tr>
	<td>Parallelize_check :</td>
	<td class="text10b">
		<?
		if ($services[$sv]->get_parallelize_check() && $services[$sv]->get_parallelize_check() != 2)
			echo $value_flag[$services[$sv]->get_parallelize_check()];
		else if ($services[$sv]->get_service_template() && $services[$services[$sv]->get_service_template()]->get_parallelize_check())
			echo $value_flag[$services[$services[$sv]->get_service_template()]->get_parallelize_check()];
		else
			echo $value_flag[2];
		?>
	</td>
</tr>
<tr>
	<td>Obsess_over_service :</td>
	<td class="text10b">
		<?
		if ($services[$sv]->get_obsess_over_service() && $services[$sv]->get_obsess_over_service() != 2)
			echo $value_flag[$services[$sv]->get_obsess_over_service()];
		else if ($services[$sv]->get_service_template() && $services[$services[$sv]->get_service_template()]->get_obsess_over_service())
			echo $value_flag[$services[$services[$sv]->get_service_template()]->get_obsess_over_service()];
		else
			echo $value_flag[2];
		?>
	</td>
</tr>
<tr>
	<td>Check_freshness :</td>
	<td class="text10b">
		<?
		if ($services[$sv]->get_check_freshness() && $services[$sv]->get_check_freshness() != 2)
			echo $value_flag[$services[$sv]->get_check_freshness()];
		else if ($services[$sv]->get_service_template() && $services[$services[$sv]->get_service_template()]->get_check_freshness())
			echo $value_flag[$services[$services[$sv]->get_service_template()]->get_check_freshness()];
		else
			echo $value_flag[2];
		?>
	</td>
</tr>
<tr>
	<td>Freshness treshold :</td>
	<td class="text10b">
		<?
		if ($services[$sv]->get_freshness_threshold() && $services[$sv]->get_freshness_threshold() != 2)
			echo preg_replace("/(99999)/", "0", $services[$sv]->get_freshness_threshold())." ".$lang["time_sec"];
		else if ($services[$sv]->get_service_template() && $services[$services[$sv]->get_service_template()]->get_freshness_threshold())
			echo preg_replace("/(99999)/", "0", $services[$services[$sv]->get_service_template()]->get_freshness_threshold())." ".$lang["time_sec"];
		else
			echo $value_flag[2];
		?>
	</td>
</tr>
<tr>
	<td>Event_handler :</td>
	<td class="text10b">
		<?
		if ($services[$sv]->get_event_handler())
			echo $commands[$services[$sv]->get_event_handler()]->get_name();
		else if ($services[$sv]->get_service_template() && $services[$services[$sv]->get_service_template()]->get_event_handler())
			echo $commands[$services[$services[$sv]->get_service_template()]->get_event_handler()]->get_name();
		?>
	</td>
</tr>
<tr>
	<td>Event_handler_arguments :</td>
	<td class="text10b" style="white-space:nowrap;">
		<?
		if ($services[$sv]->get_event_handler_arg())
			echo preg_replace("/(#BLANK#)/", "", $services[$sv]->get_event_handler_arg());
		else if ($services[$sv]->get_service_template() && $services[$services[$sv]->get_service_template()]->get_event_handler_arg())
			echo $services[$services[$sv]->get_service_template()]->get_event_handler_arg();
		?>
	</td>
</tr>
<tr>
	<td>Event_handler enabled :</td>
	<td class="text10b">
		<?
		if ($services[$sv]->get_event_handler_enabled() && $services[$sv]->get_event_handler_enabled() != 2)
			echo $value_flag[$services[$sv]->get_event_handler_enabled()];
		else if ($services[$sv]->get_service_template() && $services[$services[$sv]->get_service_template()]->get_event_handler_enabled())
			echo $value_flag[$services[$services[$sv]->get_service_template()]->get_event_handler_enabled()];
		else
			echo $value_flag[2];
		?>
	</td>
</tr>
<tr>
	<td>Low flap treshold :</td>
	<td class="text10b">
		<?
		if ($services[$sv]->get_low_flap_threshold() && $services[$sv]->get_low_flap_threshold() != 2)
			echo preg_replace("/(99999)/", "0", $services[$sv]->get_low_flap_threshold())." %";
		else if ($services[$sv]->get_service_template() && $services[$services[$sv]->get_service_template()]->get_low_flap_threshold())
			echo preg_replace("/(99999)/", "0", $services[$services[$sv]->get_service_template()]->get_low_flap_threshold())." %";
		else
			echo $value_flag[2];
		?>
	</td>
</tr>
<tr>
	<td>High flap treshold :</td>
	<td class="text10b">
		<?
		if ($services[$sv]->get_high_flap_threshold() && $services[$sv]->get_high_flap_threshold() != 2)
			echo preg_replace("/(99999)/", "0", $services[$sv]->get_high_flap_threshold())." %";
		else if ($services[$sv]->get_service_template() && $services[$services[$sv]->get_service_template()]->get_high_flap_threshold())
			echo preg_replace("/(99999)/", "0", $services[$services[$sv]->get_service_template()]->get_high_flap_threshold())." %";
		else
			echo $value_flag[2];
		?>
	</td>
</tr>
<tr>
	<td>Flap_detection_enabled :</td>
	<td class="text10b">
		<?
		if ($services[$sv]->get_flap_detection_enabled() && $services[$sv]->get_flap_detection_enabled() != 2)
			echo $value_flag[$services[$sv]->get_flap_detection_enabled()];
		else if ($services[$sv]->get_service_template() && $services[$services[$sv]->get_service_template()]->get_flap_detection_enabled())
			echo $value_flag[$services[$services[$sv]->get_service_template()]->get_flap_detection_enabled()];
		else
			echo $value_flag[2];
		?>
	</td>
</tr>
<tr>
	<td>Process_perf_data :</td>
	<td class="text10b">
		<?
		if ($services[$sv]->get_process_perf_data() && $services[$sv]->get_process_perf_data() != 2)
			echo $value_flag[$services[$sv]->get_process_perf_data()];
		else if ($services[$sv]->get_service_template() && $services[$services[$sv]->get_service_template()]->get_process_perf_data())
			echo $value_flag[$services[$services[$sv]->get_service_template()]->get_process_perf_data()];
		else
			echo $value_flag[2];
		?>
	</td>
</tr>
<tr>
	<td style="white-space: nowrap;">Retain_status_information :</td>
	<td class="text10b">
		<?
		if ($services[$sv]->get_retain_status_information() && $services[$sv]->get_retain_status_information() != 2)
			echo $value_flag[$services[$sv]->get_retain_status_information()];
		else if ($services[$sv]->get_service_template() && $services[$services[$sv]->get_service_template()]->get_retain_status_information())
			echo $value_flag[$services[$services[$sv]->get_service_template()]->get_retain_status_information()];
		else
			echo $value_flag[2];
		?>
	</td>
</tr>
<tr>
	<td style="white-space: nowrap;">Retain_nonstatus_information :</td>
	<td class="text10b" style="white-space: nowrap;">
		<?
		if ($services[$sv]->get_retain_nonstatus_information() && $services[$sv]->get_retain_nonstatus_information() != 2)
			echo $value_flag[$services[$sv]->get_retain_nonstatus_information()];
		else if ($services[$sv]->get_service_template() && $services[$services[$sv]->get_service_template()]->get_retain_nonstatus_information())
			echo $value_flag[$services[$services[$sv]->get_service_template()]->get_retain_nonstatus_information()];
		else
			echo $value_flag[2];
		?>
	</td>
</tr>
<tr>
	<td>Notification_interval :</td>
	<td class="text10b">
		<?
		if ($services[$sv]->get_notification_interval())
			echo preg_replace("/(99999)/", "0", $services[$sv]->get_notification_interval())." * ".$oreon->Nagioscfg->get_interval_length()." ".$lang["time_sec"];
		else if ($services[$sv]->get_service_template() && $services[$services[$sv]->get_service_template()]->get_notification_interval())
			echo preg_replace("/(99999)/", "0", $services[$services[$sv]->get_service_template()]->get_notification_interval())." * ".$oreon->Nagioscfg->get_interval_length()." ".$lang["time_sec"];
		?>
	</td>
</tr>
<tr>
	<td>Notification_period :</td>
	<td class="text10b">
		<?
		if ($services[$sv]->get_notification_period())
			echo $timePeriods[$services[$sv]->get_notification_period()]->get_name();
		else if ($services[$sv]->get_service_template() && $services[$services[$sv]->get_service_template()]->get_notification_period())
			echo $timePeriods[$services[$services[$sv]->get_service_template()]->get_notification_period()]->get_name();
		?>
	</td>
</tr>
<tr>
	<td>Notification_options :</td>
	<td class="text10b">
		<?
		if ($services[$sv]->get_notification_options())
			echo $services[$sv]->get_notification_options();
		else if ($services[$sv]->get_service_template() && $services[$services[$sv]->get_service_template()]->get_notification_options())
			echo $services[$services[$sv]->get_service_template()]->get_notification_options();
		?>
	</td>
</tr>
<tr>
	<td>Notification_enabled :</td>
	<td class="text10b">
		<?
		if ($services[$sv]->get_notification_enabled() && $services[$sv]->get_notification_enabled() != 2)
			echo $value_flag[$services[$sv]->get_notification_enabled()];
		else if ($services[$sv]->get_service_template() && $services[$services[$sv]->get_service_template()]->get_notification_enabled())
			echo $value_flag[$services[$services[$sv]->get_service_template()]->get_notification_enabled()];
		else
			echo $value_flag[2];
		?>
	</td>
</tr>
<tr>
	<td>Contact Groups :</td>
	<td class="text10b" style="white-space: nowrap;">
	<?
	if (isset($services[$sv]->contactGroups)  && count($services[$sv]->contactGroups))	{
		foreach ($services[$sv]->contactGroups as $cg)	{
			echo "<li><a href='phpradmin.php?p=107&cg=" .$cg->get_id(). "&o=w' class='text10' style='white-space: nowrap;";
			if (!$cg->get_activate()) echo " text-decoration: line-through;";
			echo "'>".$cg->get_name()."</a></li>";
			unset($cg);
		}
	} else if ($services[$sv]->get_service_template() && count($services[$services[$sv]->get_service_template()]->contactGroups)) {
		foreach ($services[$services[$sv]->get_service_template()]->contactGroups as $cg)	{
			echo "<li><a href='phpradmin.php?p=107&cg=" .$cg->get_id(). "&o=w' class='text10' style='white-space: nowrap;";
			if (!$cg->get_activate()) echo " text-decoration: line-through;";
			echo "'>".$cg->get_name()."</a></li>";
			unset($cg);
		}
	}
	?>
	</td>
</tr>
<tr>
	<td>Stalking_options :</td>
	<td class="text10b">
		<?
		if ($services[$sv]->get_stalking_options())
			echo $services[$sv]->get_stalking_options();
		else if ($services[$sv]->get_service_template() && $services[$services[$sv]->get_service_template()]->get_stalking_options())
			echo $services[$services[$sv]->get_service_template()]->get_stalking_options();
		?>
	</td>
</tr>
<tr>
	<td><? echo $lang['status']; ?> :</td>
	<td class="text10b">
	<?
	if ($services[$sv]->get_activate() && $hosts[$services[$sv]->get_host()]->get_activate())
		echo $lang['enable'];
	else
		echo $lang['disable'];
	?>
	</td>
</tr>
<tr>
	<td valign="top">Comment :</td>
	<td class="text10b">
	<?
	if ($services[$sv]->get_comment())
		echo "<textarea cols='20' rows='4' readonly>".preg_replace("/(#BLANK#)/", "", $services[$sv]->get_comment())."</textarea>";
	else if ($services[$sv]->get_service_template() && $services[$services[$sv]->get_service_template()]->get_comment())
		echo "<textarea cols='20' rows='4' readonly>".preg_replace("/(#BLANK#)/", "", $services[$services[$sv]->get_service_template()]->get_comment())."</textarea>";
	?>
	</td>
</tr>
<tr>
	<td colspan="2">
	<div align="center" style="padding: 10px;">
		<a href="phpradmin.php?p=104&o=c&sv=<? echo $sv ?>" class="text10bc"><? echo $lang['modify']; ?></a>&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="phpradmin.php?p=104&o=d&sv=<? echo $sv ?>" class="text10bc" onclick="return confirm('<? echo $lang['confirm_removing']; ?>')"><? echo $lang['delete']; ?></a>
	</div>
	</td>
</tr>
</table>