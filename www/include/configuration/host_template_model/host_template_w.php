<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/?>
<table cellpadding="0" cellspacing="3" width="350" align='center'>
	<tr>
		<td width="50%">Name :</td>
		<td class="text10b"><? echo $hosts[$htm_id]->get_name();?></td>
	</tr>
	<tr>
		<td>Alias :</td>
		<td class="text10b"><? echo $hosts[$htm_id]->get_alias();?></td>
	</tr>
	<tr>
		<td>Address :</td>
		<td class="text10b"><? echo $hosts[$htm_id]->get_address();?></td>
	</tr>
	<tr>
		<td valign="top">Parents :</td>
		<td style="white-space: nowrap;">
		<?
			foreach ($hosts[$htm_id]->parents as $parent)	{
				echo "<li><a href='phpradmin.php?p=102&h=".$parent->get_id()."&o=w' class='text10'";
				if (!$parent->get_activate())
					echo " style='text-decoration: line-through;'";
				echo ">".$parent->get_name()."</a><br></li>";
				unset($parent);
			}
		?>
		</td>
	</tr>
	<tr>
		<td>Host Groups :</td>
		<td style="white-space: nowrap;">
		<?
			foreach ($hosts[$htm_id]->hostGroups as $hostGroup)	{
				echo "<li><a href='phpradmin.php?p=103&hg=".$hostGroup->get_id()."&o=w' class='text10'";
				if (!$hostGroup->get_activate())
					echo " style='text-decoration: line-through;'";
				echo ">".$hostGroup->get_name()."</a><br></li>";
			}
		?>
		</td>
	</tr>
	<tr>
		<td>Check_command :</td>
		<td class="text10b">
		<? 	if ($hosts[$htm_id]->get_check_command())
				echo $commands[$hosts[$htm_id]->get_check_command()]->get_name();
		?>
		</td>
	</tr>
	<tr>
		<td>Max_check_attempts :</td>
		<td class="text10b"><? echo $hosts[$htm_id]->get_max_check_attempts(); ?></td>
	</tr>
	<?	if (!strcmp("1", $oreon->user->get_version()))	{	?>
	<tr>
		<td>Checks_enabled :</td>
		<td class="text10b"><? echo $value_flag[$hosts[$htm_id]->get_checks_enabled()]; ?></td>
	</tr>
	<?	}	if (!strcmp("2", $oreon->user->get_version()))	{	?>
	<tr>
		<td>Check_interval :</td>
		<td class="text10b"><? echo preg_replace("/(99999)/", "0", $hosts[$htm_id]->get_check_interval())." * ".$oreon->Nagioscfg->get_interval_length()." ".$lang["time_sec"]; ?></td>
	</tr>
	<tr>
		<td>Active_checks_enabled :</td>
		<td class="text10b"><? echo $value_flag[$hosts[$htm_id]->get_active_checks_enabled()]; ?></td>
	</tr>
	<tr>
		<td>Passive_checks_enabled :</td>
		<td class="text10b"><? echo $value_flag[$hosts[$htm_id]->get_passive_checks_enabled()]; ?></td>
	</tr>
	<tr>
		<td>Check_period :</td>
		<td class="text10b">
		<?	if ($hosts[$htm_id]->get_check_period())
				echo $timePeriods[$hosts[$htm_id]->get_check_period()]->get_name();
		?>
		</td>
	</tr>
	<tr>
		<td>Obsess_over_host :</td>
		<td class="text10b"><? echo $value_flag[$hosts[$htm_id]->get_obsess_over_host()]; ?></td>
	</tr>
	<tr>
		<td>Check_freshness :</td>
		<td class="text10b"><? echo $value_flag[$hosts[$htm_id]->get_check_freshness()]; ?></td>
	</tr>
	<tr>
		<td>Freshness_threshold :</td>
		<td class="text10b">
			<?
			if ($hosts[$htm_id]->get_freshness_threshold())
				echo preg_replace("/(99999)/", "0", $hosts[$htm_id]->get_freshness_threshold())." ".$lang["time_sec"];
			else
				echo $value_flag[2];
			?>
		</td>
	</tr>
	<? }	?>
	<tr>
		<td>Event_handler_enabled :</td>
		<td class="text10b"><? echo  $value_flag[$hosts[$htm_id]->get_event_handler_enabled()] ; ?></td>
	</tr>
	<tr>
		<td>Event_handler :</td>
		<td class="text10b">
		<?	if ($hosts[$htm_id]->get_event_handler())
				echo $commands[$hosts[$htm_id]->get_event_handler()]->get_name();
		?>
		</td>
	</tr>
	<tr>
		<td>Low_flap_threshold :</td>
		<td class="text10b">
			<?
				if ($hosts[$htm_id]->get_low_flap_threshold())
					echo preg_replace("/(99999)/", "0", $hosts[$htm_id]->get_low_flap_threshold())." %";
				else
					echo $value_flag[2];
			?>
		</td>
	</tr>
	<tr>
		<td>High_flap_threshold :</td>
		<td class="text10b">
			<?
				if ($hosts[$htm_id]->get_high_flap_threshold())
					echo preg_replace("/(99999)/", "0", $hosts[$htm_id]->get_high_flap_threshold())." %";
				else
					echo $value_flag[2];
			?>
		</td>
	</tr>
	<tr>
		<td>Flap_detection_enabled :</td>
		<td class="text10b"><? echo  $value_flag[$hosts[$htm_id]->get_flap_detection_enabled()] ; ?></td>
	</tr>
	<tr>
		<td>Process_perf_data :</td>
		<td class="text10b"><? echo  $value_flag[$hosts[$htm_id]->get_process_perf_data()] ; ?></td>
	</tr>
	<tr>
		<td>Retain_status_information :</td>
		<td class="text10b"><? echo  $value_flag[$hosts[$htm_id]->get_retain_status_information()] ; ?></td>
	</tr>
	<tr>
		<td style="white-space: nowrap;">Retain_nonstatus_information :</td>
		<td class="text10b" style="white-space: nowrap;"><? echo  $value_flag[$hosts[$htm_id]->get_retain_nonstatus_information()] ; ?></td>
	</tr>
	<?	if (!strcmp("2", $oreon->user->get_version()))	{	?>
	<tr>
		<td>Contact Groups :</td>
		<td style="white-space: nowrap;">
		<?	foreach ($hosts[$htm_id]->contactgroups as $contactGroup)	{
				echo "<li><a href='phpradmin.php?p=107&h=".$contactGroup->get_id()."&o=w' class='text10'";
				if (!$contactGroup->get_activate()) echo " style='text-decoration: line-through;'";
				echo ">".$contactGroup->get_name()."</a><br></li>";
				unset($contactGroup);
			}
		?>
		</td>
	</tr>
	<?	}	?>
	<tr>
		<td>Notification_interval :</td>
		<td class="text10b"><? echo preg_replace("/(99999)/", "0", $hosts[$htm_id]->get_notification_interval())." * ".$oreon->Nagioscfg->get_interval_length()." ".$lang["time_sec"]; ?></td>
	</tr>
	<tr>
		<td>Notification_period :</td>
		<td class="text10b">
		<? 	if ($hosts[$htm_id]->get_notification_period())
				echo $timePeriods[$hosts[$htm_id]->get_notification_period()]->get_name();
		?>
		</td>
	</tr>
	<tr>
		<td>Notification_options :</td>
		<td class="text10b"><? echo $hosts[$htm_id]->get_notification_options(); ?></td>
	</tr>
	<tr>
		<td>Notifications_enabled :</td>
		<td class="text10b"><? echo $value_flag[$hosts[$htm_id]->get_notifications_enabled()] ; ?></td>
	</tr>
	<tr>
		<td>Stalking_options :</td>
		<td class="text10b"><? echo $hosts[$htm_id]->get_stalking_options(); ?></td>
	</tr>
	<tr>
		<td valign="top">Comment :</td>
		<td class="text10b"><? echo "<textarea cols='20' rows='4'  readonly>".preg_replace("/(#BLANK#)/", "", $hosts[$htm_id]->get_comment())."</textarea>";	?></td>
	</tr>
</table>
<div align="center" style="padding: 10px;">
	<a href="phpradmin.php?p=123&o=c&htm_id=<? echo $htm_id ?>" class="text10bc"><? echo $lang['modify']; ?></a>&nbsp;&nbsp;&nbsp;&nbsp;
	<a href="phpradmin.php?p=123&o=d&htm_id=<? echo $htm_id ?>" class="text10bc" onclick="return confirm('<? echo $lang['confirm_removing']; ?>')"><? echo $lang['delete']; ?></a>
</div>