<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/?>
<table border="0" cellpadding="3" cellspacing="3">
	<tr>
		<td>Description :</td>
		<td class="text10b"><? echo $services[$stm_id]->get_description(); ?></td>
	</tr>
	<tr>
		<td>Is Volatile :</td>
		<td class="text10b"><? if ($services[$stm_id]->get_is_volatile()){ echo $value_flag[$services[$stm_id]->get_is_volatile()];} ?></td>
	</tr>
	<tr>
		<td>Service Groups :</td>
		<td class="text10b">
		<?
			foreach ($services[$stm_id]->serviceGroups as $sg)	{
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
				if ($services[$stm_id]->get_check_command())
					echo $commands[$services[$stm_id]->get_check_command()]->get_name();
			?>
		</td>
	</tr>
	<tr>
		<td>Check_command_arguments :</td>
		<td class="text10b"><? echo $services[$stm_id]->get_check_command_arg(); ?></td>
	</tr>
	<tr>
		<td>Max_check_attempts :</td>
		<td class="text10b"><? echo $services[$stm_id]->get_max_check_attempts(); ?></td>
	</tr>
	<tr>
		<td>Normal_check_interval :</td>
		<td class="text10b"><? echo $services[$stm_id]->get_normal_check_interval()." * ".$oreon->Nagioscfg->get_interval_length()." ".$lang["time_sec"]; ?></td>
	</tr>
	<tr>
		<td>Retry_check_interval :</td>
		<td class="text10b"><? echo $services[$stm_id]->get_retry_check_interval()." * ".$oreon->Nagioscfg->get_interval_length()." ".$lang["time_sec"]; ?></td>
	</tr>
	<tr>
		<td>Active_checks_enabled :</td>
		<td class="text10b"><? echo $value_flag[$services[$stm_id]->get_active_checks_enabled()]; ?></td>
	</tr>
	<tr>
		<td>Passive_checks_enabled :</td>
		<td class="text10b"><? echo $value_flag[$services[$stm_id]->get_passive_checks_enabled()]; ?></td>
	</tr>
	<tr>
		<td>Check_period :</td>
		<td class="text10b">
		<?
			if ($services[$stm_id]->get_check_period())
				echo $timePeriods[$services[$stm_id]->get_check_period()]->get_name();
		?>
		</td>
	</tr>
	<tr>
		<td>Parallelize_check :</td>
		<td class="text10b"><? echo $value_flag[$services[$stm_id]->get_parallelize_check()]; ?></td>
	</tr>
	<tr>
		<td>Obsess_over_service :</td>
		<td class="text10b"><? echo $value_flag[$services[$stm_id]->get_obsess_over_service()]; ?></td>
	</tr>
	<tr>
		<td>Check_freshness :</td>
		<td class="text10b"><? echo $value_flag[$services[$stm_id]->get_check_freshness()] ; ?></td>
	</tr>
	<tr>
		<td>Freshness treshold :</td>
		<td class="text10b" style="white-space: nowrap;">
			<?
			if ($services[$stm_id]->get_freshness_threshold())
				echo preg_replace("/(99999)/", "0", $services[$stm_id]->get_freshness_threshold())." ".$lang["time_sec"];
			else
				echo $value_flag[2];
			?>
		</td>
	</tr>
	<tr>
		<td>Event_handler :</td>
		<td class="text10b">
		<?
			if ($services[$stm_id]->get_event_handler())
				echo $commands[$services[$stm_id]->get_event_handler()]->get_name();
		?>
		</td>
	</tr>
	<tr>
		<td>Event_handler_arguments :</td>
		<td class="text10b"><? echo $services[$stm_id]->get_event_handler_arg(); ?></td>
	</tr>
	<tr>
		<td>Event_handler enabled :</td>
		<td class="text10b"><? echo $value_flag[$services[$stm_id]->get_event_handler_enabled()] ; ?></td>
	</tr>
	<tr>
		<td>Low flap treshold :</td>
		<td class="text10b">
			<?
			if ($services[$stm_id]->get_low_flap_threshold())
				echo preg_replace("/(99999)/", "0", $services[$stm_id]->get_low_flap_threshold())." %";
			else
				echo $value_flag[2];
			?>
		</td>
	</tr>
	<tr>
		<td>High flap treshold :</td>
		<td class="text10b">
			<?
			if ($services[$stm_id]->get_high_flap_threshold())
				echo preg_replace("/(99999)/", "0", $services[$stm_id]->get_high_flap_threshold())." %";
			else
				echo $value_flag[2];
			?>
		</td>
	</tr>
	<tr>
		<td>Flap_detection_enabled :</td>
		<td class="text10b"><? echo $value_flag[$services[$stm_id]->get_flap_detection_enabled()] ; ?></td>
	</tr>
	<tr>
		<td>Process_perf_data :</td>
		<td class="text10b"><? echo $value_flag[$services[$stm_id]->get_process_perf_data()] ; ?></td>
	</tr>
	<tr>
		<td>Retain_status_information :</td>
		<td class="text10b"><? echo $value_flag[$services[$stm_id]->get_retain_status_information()] ; ?></td>
	</tr>
	<tr>
		<td style="white-space: nowrap;">Retain_nonstatus_information :</td>
		<td class="text10b" style="white-space: nowrap;"><? echo $value_flag[$services[$stm_id]->get_retain_nonstatus_information()] ; ?></td>
	</tr>
	<tr>
		<td>Notification_interval :</td>
		<td class="text10b"><? echo preg_replace("/(99999)/", "0", $services[$stm_id]->get_notification_interval())." * ".$oreon->Nagioscfg->get_interval_length()." ".$lang["time_sec"]; ?></td>
	</tr>
	<tr>
		<td>Notification_period :</td>
		<td class="text10b">
		<?
			if ($services[$stm_id]->get_notification_period())
				echo $timePeriods[$services[$stm_id]->get_notification_period()]->get_name();
		?>
		</td>
	</tr>
	<tr>
		<td>Notification_options :</td>
		<td class="text10b"><? echo $services[$stm_id]->get_notification_options(); ?></td>
	</tr>
	<tr>
		<td>Notification_enabled :</td>
		<td class="text10b"><? echo $value_flag[$services[$stm_id]->get_notification_enabled()]; ?></td>
	</tr>
	<tr>
		<td>Contact Groups :</td>
		<td class="text10b">
		<? 	foreach ($services[$stm_id]->contactGroups as $cg)	{
				echo "<li><a href='phpradmin.php?p=107&cg=" .$cg->get_id(). "&o=w' class='text10' style='white-space: nowrap;";
				if (!$cg->get_activate()) echo " text-decoration: line-through;'";
				echo "'>".$cg->get_name()."</a></li>";
				unset($cg);
			}
		?>
		</td>
	</tr>
	<tr>
		<td>Stalking_options :</td>
		<td class="text10b"><? echo $services[$stm_id]->get_stalking_options(); ?></td>
	</tr>
	<tr>
		<td valign="top">Comment :</td>
		<td class="text10b"><? echo "<textarea cols='20' rows='4' readonly>".$services[$stm_id]->get_comment()."</textarea>";	?></td>
	</tr>
</table>
<div align="center" style="padding: 10px;">
	<a href="phpradmin.php?p=125&o=c&stm_id=<? echo $stm_id ?>" class="text10bc"><? echo $lang['modify']; ?></a>&nbsp;&nbsp;&nbsp;&nbsp;
	<a href="phpradmin.php?p=125&o=d&stm_id=<? echo $stm_id ?>" class="text10bc" onclick="return confirm('<? echo $lang['confirm_removing']; ?>')"><? echo $lang['delete']; ?></a>
</div>