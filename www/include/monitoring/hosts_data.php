<?
/*
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)
For information : toni@blyx.com
*/
	$h = $_GET["h"];
	$str = "";
	$rep = array();
	$rep["1"] = "YES";
	$rep["0"] = "NO";


if (isset($h) && isset($Logs->log_h[$h])) { ?>
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td class='tabTableTitle'><? echo $lang['mon_host_state_info']; ?>&nbsp;<? print $Logs->log_h[$h]->get_name(); ?></td>
		<td></td>
		<td class="tabTableTitle" style="white-space: nowrap;"><? echo $lang["options"]; ?></td>
	</tr>
	<tr>
		<td valign="top" class="tabTableForTab">
			<table border='0'>
				<tr>
					<td><? echo $lang['mon_host_status']; ?></td>
					<td><b><? print $Logs->log_h[$h]->get_status(); ?></b></td>
				</tr>
				<tr>
					<td colspan="2"><? echo $lang['mon_status_info']; ?></td>
				</tr>
				<tr>
					<td colspan="2" style="padding:15px "><? print $Logs->log_h[$h]->get_output(); ?></td>
				</tr>
				<tr>
					<td><? echo $lang['mon_last_status_check'] ; ?></td>
					<td><? print date("d-m-Y", $Logs->log_h[$h]->get_last_check()) . " at " . date("G:i:s", $Logs->log_h[$h]->get_last_check()); ?></td>
				</tr>
				<tr>
					<td><? echo $lang['mon_status_data_age']; ?></td>
					<td><? print date("d-m-Y", $Logs->log_h[$h]->get_last_stat()) . " at " . date("G:i:s", $Logs->log_h[$h]->get_last_stat()); ?></td>
				</tr>
				<tr>
					<td>Last State Change:</td>
					<td><? print date("d-m-Y", $Logs->log_h[$h]->get_last_stat()) . " at " . date("G:i:s", $Logs->log_h[$h]->get_last_stat()); ?></td>
				</tr>
				<tr>
					<td><? echo $lang['mon_current_state_duration']; ?></td>
					<td><? 
						if (!strcmp($Logs->log_h[$h]->get_status(), "UP") && $Logs->log_h[$h]->get_time_up() != 0)
							print date("d-m-Y", $Logs->log_h[$h]->get_time_up()) . " at " . date("H:i:s", $Logs->log_h[$h]->get_time_up());
						else if (!strcmp($Logs->log_h[$h]->get_status(), "DOWN"))
							print date("d-m-Y", $Logs->log_h[$h]->get_time_down()) . " at " . date("H:i:s", $Logs->log_h[$h]->get_time_down());
						else if (!strcmp($Logs->log_h[$h]->get_status(), "UNREACHEABLE"))
							print date("d-m-Y", $Logs->log_h[$h]->get_time_unrea()) . " at " . date("H:i:s", $Logs->log_h[$h]->get_time_unrea());
						else{
							$current_stat_duration = time() - $Logs->log_p->get_program_start();
							$day = date("d", $current_stat_duration) - 1;
							$month = date("m", $current_stat_duration) - 1;
							$year = date("Y", $current_stat_duration) - 1970;
							$hour = date("H", $current_stat_duration) - 1;
							$min = date("i", $current_stat_duration);
							$sec = date("s", $current_stat_duration);
							print $year . " y " . $day . " d " . $month . " m " . " - " . $hour . ":" . $min . ":" . $sec;
						}									
						?>
					</td>
				</tr>
				<tr>
					<td><? echo $lang['mon_last_host_notif']; ?></td>
					<td><?
					if ($Logs->log_h[$h]->get_last_notifi() == 0)
						print "N/A";
					else
						print date("d-m-Y", $Logs->log_h[$h]->get_last_notifi()) . " at " . date("G:i:s", $Logs->log_h[$h]->get_last_notifi()); ?></td>
				</tr>
				<tr>
					<td><? echo $lang['mon_current_notif_nbr']; ?></td>
					<td><? print $Logs->log_h[$h]->get_curr_not_number(); ?></td>
				</tr>
				<tr>
					<td><? echo $lang['mon_is_host_flapping']; ?></td>
					<td><? 
							if ($Logs->log_h[$h]->get_flapping() == 0)
								print "N/A";
							else
								print $Logs->log_h[$h]->get_flapping() . "%"; ?>
					</td>
				</tr>
				<tr>
					<td><? echo $lang['mon_percent_state_change']; ?></td>
					<td> 
						<? 
							if ($Logs->log_h[$h]->get_percent_stat_change() == 0)
								print "N/A";
							else
								print $Logs->log_h[$h]->get_percent_stat_change() . "%"; ?>
					</td>
				</tr>
				<tr>
					<td><? echo $lang['mon_is_sched_dt']; ?></td>
					<td><b><? 
						if ($Logs->log_h[$h]->get_sch_downtime_death() == 1)
							print 'YES'; 
						else
							print 'NO'; 
						?></b>
					</td>
				</tr>
				<tr>
					<td><? echo $lang['mon_last_update']; ?></td>
					<td><? print date("d-m-Y", $Logs->log_p->get_last_command_check()) . " at " . date("G:i:s", $Logs->log_p->get_last_command_check()); ?></td>
				</tr>
			</table>
			<table border='0'>
				<tr>
					<td align="align" class="text10b" style="padding-top:15px;" nowrap><? echo $lang['mon_host_state_info']; ?><br></td>
				</tr>
				<tr>
					<td>Host Checks:</td>
					<td><? print $rep[$Logs->log_h[$h]->get_checks_en()]; ?></td>
				</tr>
				<tr>
					<td>Host Notifications:</td>
					<td><? print $rep[$Logs->log_h[$h]->get_not_en()]; ?></td>
				</tr>
				<tr>
					<td>Event Handler:</td>
					<td><? print $rep[$Logs->log_h[$h]->get_ev_handler_en()]; ?></td>
				</tr>
				<tr>
					<td>Flap Detection:</td>
					<td><? print $rep[$Logs->log_h[$h]->get_flap_detect_en()]; ?></td>
				</tr>
			</table>
		</td>
		<td style="padding-left: 20px;"></td>
		<td valign="top">
			<table border='0' cellpadding="0" cellspacing="0">
				<tr>
					<td style="white-space: nowrap;" class="tabTableForTab">
						- <a href='./phpradmin.php?p=306&cmd=9&id=<? print $h; // ?>' class="text9"><? echo $lang['mon_sch_imm_cfas']; ?></a><br><br>
						- <a href='./phpradmin.php?p=306&cmd=<? if ($Logs->log_h[$h]->get_checks_en()) print "48"; else print "47"; ?>&id=<? print $h; // ?>' class="text9"><? if ($Logs->log_h[$h]->get_checks_en()) print $lang['disable']." "; else print $lang['enable']." "; ?>checks</a><br>
						- <a href='./phpradmin.php?p=306&cmd=<? if ($Logs->log_h[$h]->get_not_en()) print "19"; else print "18"; ?>&id=<? print $h; // ?>' class="text9"><? if ($Logs->log_h[$h]->get_not_en()) print $lang['disable']." "; else print $lang['enable']." "; ?>notifications</a><br>
						- <a href='./phpradmin.php?p=308&o=1' class="text9"><? echo $lang['mon_sch_dt']; ?></a><br>
						- <a href='./phpradmin.php?p=306&cmd=15&id=<? print $h; ?>' class="text9"><? echo $lang['mon_dis_notif_fas']; ?></a><br>
						- <a href='./phpradmin.php?p=306&cmd=14&id=<? print $h; ?>' class="text9"><? echo $lang['mon_enable_notif_fas']; ?></a><br>
						- <a href='./phpradmin.php?p=306&cmd=17&id=<? print $h; ?>' class="text9"><? echo $lang['mon_dis_checks_fas']; ?></a><br>
						- <a href='./phpradmin.php?p=306&cmd=16&id=<? print $h; ?>' class="text9"><? echo $lang['mon_enable_checks_fas']; ?></a><br>
						- <a href='./phpradmin.php?p=306&cmd=<? if ($Logs->log_h[$h]->get_ev_handler_en()) print "52"; else print "51"; ?>&id=<? print $h; // ?>' class="text9"><? if ($Logs->log_h[$h]->get_ev_handler_en()) print $lang['disable']." "; else print $lang['enable']." "; ?>event handler</a><br>
						- <a href='./phpradmin.php?p=306&cmd=<? if ($Logs->log_h[$h]->get_flap_detect_en()) print "50"; else print "49"; ?>&id=<? print $h; // ?>' class="text9"><? if ($Logs->log_h[$h]->get_flap_detect_en()) print $lang['disable']." "; else print $lang['enable']." "; ?>flap detection</a><br>
					</td>
				</tr>			
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="3" align="center" style="padding-top: 20px;">
			<a href="javascript:history.go(-1)" class='text11b'><? echo $lang['back']; ?></a>
		</td>
	</tr>
</table>
<? }	else {
		print "<div align='center' class='text14b' style='padding:40px'>".$lang['mon_no_stat_for_host']."</div>";
		print "<SCRIPT LANGUAGE='JavaScript'> setTimeout(\"javascript:history.go(-1)\",2000)</SCRIPT>";
	} ?>
