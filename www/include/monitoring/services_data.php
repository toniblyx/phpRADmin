<?
/*
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)
For information : toni@blyx.com
*/
	$sv = $_GET["id"];
	$str = "";
	$rep = array();
	$rep["1"] = "YES";
	$rep["0"] = "NO";
	$h = $oreon->services[$sv]->get_host();
	
	require_once './class/other.class.php';
	
	if (isset($h) && isset($Logs->log_h[$h]) && isset($Logs->log_h[$h]->log_s[$sv])) { ?>
<table border=0 cellpadding="0" cellspacing="0">
	<tr>
		<td valign="top">
			<table border='0' cellpadding="0" cellspacing="0">
				<tr>
					<td class="tabTableTitle"><? echo $lang['mon_service_state_info']; ?>&nbsp;<? print $oreon->hosts[$oreon->services[$sv]->get_host()]->get_name() . "  /  " . $oreon->services[$sv]->get_description(); ?></td>
				</tr>
				<tr>
					<td class="tabTableForTab">
					<table border='0'>
						<tr>
							<td><? echo $lang['mon_service_status'] ; ?></td>
							<td><b><? print $Logs->log_h[$h]->log_s[$sv]->get_status(); ?></b></td>
						</tr>
						<tr>
							<td colspan="2"><? echo $lang['mon_status_info']; ?></td>
						</tr>
						</tr>
							<td colspan=2 style="padding-left:10px"><b><? print $Logs->log_h[$h]->log_s[$sv]->get_Output(); ?></b></td>
						</tr>
						<tr>
							<td><? echo $lang['mon_current_attempt']; ?></td>
							<td nowrap><? print  $Logs->log_h[$h]->log_s[$sv]->get_retry(); ?></td>
						</tr>
						<tr>
							<td><? echo $lang['mon_state_type']; ?></td>
							<td nowrap><? print  $Logs->log_h[$h]->log_s[$sv]->get_stat_type(); ?></td>
						</tr>
						<tr>
							<td><? echo $lang['mon_last_check_type']; ?></td>
							<td><? print $Logs->log_h[$h]->log_s[$sv]->get_check_type(); ?></td>
						</tr>
						<tr>
							<td><? echo $lang['mon_last_check_time']; ?></td>
							<td><? print date("d-m-Y", $Logs->log_h[$h]->log_s[$sv]->get_last_check()) . " at " . date("G:i:s", $Logs->log_h[$h]->log_s[$sv]->get_last_check()); ?></td>
						</tr>
						<tr>
							<td><? echo $lang['mon_status_data_age']; ?> :</td>
							<td><? //print date("d-m-Y", print $Logs->log_h[$h]->log_s[$sv]->get_last_stat()) . " at " . date("G:i:s", print $Logs->log_h[$h]->log_s[$sv]->get_last_stat()); ?></td>
						</tr>
						<tr>
							<td><? echo $lang['mon_next_sch_active_check']; ?></td>
							<td><? print date("d-m-Y",  $Logs->log_h[$h]->log_s[$sv]->get_next_check()) . " at " . date("G:i:s", $Logs->log_h[$h]->log_s[$sv]->get_next_check()); ?></td>
						</tr>
						<tr>
							<td><? echo $lang['mon_current_state_duration']; ?></td>
							<td><? print Duration::toString($Logs->log_h[$h]->log_s[$sv]->get_time_ok()); ?>
							</td>
						</tr>
						<tr>
							<td><? echo $lang['mon_last_service_notif']; ?></td>
							<td><?
							if ($Logs->log_h[$h]->log_s[$sv]->get_last_not_time() == 0)
								print "N/A";
							else
								print date("d-m-Y", $Logs->log_h[$h]->log_s[$sv]->get_last_not_time()) . " at " . date("G:i:s", $Logs->log_h[$h]->log_s[$sv]->get_last_not_time()); ?></td>
						</tr>
						<tr>
							<td><? echo $lang['mon_current_notif_nbr']; ?></td>
							<td><? print  $Logs->log_h[$h]->log_s[$sv]->get_current_not_nb(); ?></td>
						</tr>
						<tr>
							<td><? echo $lang['mon_is_service_flapping']; ?></td>
							<td><? 
									if ( $Logs->log_h[$h]->log_s[$sv]->get_sv_is_flapping() == 0)
										print "N/A";
									else
										print $Logs->log_h[$h]->log_s[$sv]->get_sv_is_flapping() . "%"; ?>
							</td>
						</tr>
						<tr>
							<td><? echo $lang['mon_percent_state_change']; ?></td>
							<td> 
								<? 
									if ($Logs->log_h[$h]->log_s[$sv]->get_percent_stat_change() == 0)
										print "N/A";
									else
										print $Logs->log_h[$h]->log_s[$sv]->get_percent_stat_change() . "%"; ?>
							</td>
						</tr>
						<tr>
							<td><? echo $lang['mon_is_sched_dt']; ?></td>
							<td><b><? 
								if ($Logs->log_h[$h]->log_s[$sv]->get_scheduled_downtime_depth() == 1)
									print 'YES'; 
								else
									print 'NO'; 
								?></b>
							</td>
						</tr>
						<tr>
							<td><? echo $lang['mon_last_update']; ?></td>
							<td><? print date("d-m-Y",$Logs->log_p->get_last_command_check()) . " at " . date("G:i:s", $Logs->log_p->get_last_command_check()); ?></td>
						</tr>
					</table>
					<table border='0'>
						<tr>
							<td align="align" class="text10b" style="padding-top:15px;" nowrap><? echo $lang['mon_host_state_info']; ?><br></td>
						</tr>
						<?
							// translate data
							$rep["1"] = $lang['enable'];
							$rep["0"] = $lang['disable'];
						?>
						<tr>
							<td>Service Checks :</td>
							<td><? print $rep[$Logs->log_h[$h]->log_s[$sv]->get_checks_en()]; ?></td>
						</tr>
						<tr>
							<td>Passive Checks :</td>
							<td><? print $rep[$Logs->log_h[$h]->log_s[$sv]->get_accept_passive_check()]; ?></td>
						</tr>
						<tr>
							<td>Service Notifications:</td>
							<td><? print $rep[$Logs->log_h[$h]->log_s[$sv]->get_not_en()]; ?></td>
						</tr>
						<tr>
							<td>Event Handler:</td>
							<td><? print $rep[$Logs->log_h[$h]->log_s[$sv]->get_ev_handler_en()]; ?></td>
						</tr>
						<tr>
							<td>Flap Detection:</td>
							<td><? print $rep[$Logs->log_h[$h]->log_s[$sv]->get_sv_is_flapping()]; ?></td>
						</tr>
					</table>
					</td>
				</tr>			
			</table>
		<td width="50">&nbsp;</td>
		<td width="350" valign="top">
			<table border='0' cellpadding="0" cellspacing="0">
				<tr>
				<td class="tabTableTitle" nowrap><? echo $lang['options']; ?></td>
				<tr>
					<td class="tabTableForTab">
					<ul>
						<li><a href='./phpradmin.php?p=306&cmd=<? if ($Logs->log_h[$h]->log_s[$sv]->get_checks_en()) print "11"; else print "10"; ?>&id=<? print $sv; // ?>' class="text9"><? if ($Logs->log_h[$h]->log_s[$sv]->get_checks_en()) print $lang['disable']." "; else print $lang['enable']." "; ?> <? echo $lang['mon_checks_for_service']; ?></a></li>
						<li><a href='./phpradmin.php?p=306&cmd=8&id=<? print $sv; ?>' class="text9">Re-schedule an imediate check of this service</a></li>
						<li><a href='./phpradmin.php?p=306&cmd=67&id=<? print $sv; ?>' class="text9">Re-schedule an imediate check of this service (forced)</a></li>
						<li><? echo $lang['mon_submit_pass_check_service']; ?></li>
						<li><a href='./phpradmin.php?p=306&cmd=<? if ($Logs->log_h[$h]->log_s[$sv]->get_accept_passive_check()) print "54"; else print "53"; ?>&id=<? print $sv; // ?>' class="text9"><? if ($Logs->log_h[$h]->log_s[$sv]->get_accept_passive_check()) print "Stop "; else print "Start "; ?><? echo $lang['mon_accept_pass_check']; ?></a></li>
						<li><a href='./phpradmin.php?p=306&cmd=<? if ($Logs->log_h[$h]->log_s[$sv]->get_not_en()) print "13"; else print "12"; ?>&id=<? print $sv; // ?>' class="text9"><? if ($Logs->log_h[$h]->log_s[$sv]->get_not_en()) print $lang['disable']." "; else $lang['enable']." "; ?><? echo $lang['mon_notif_service']; ?></a></li>
						<li><a href='./phpradmin.php?p=308&o=2' class="text9"><? echo $lang['mon_sch_dt_service']; ?></a></li>
						<li><a href='./phpradmin.php?p=306&cmd=<? if ($Logs->log_h[$h]->log_s[$sv]->get_ev_handler_en()) print "56"; else print "55"; ?>&id=<? print $sv; // ?>' class="text9"><? if ($Logs->log_h[$h]->log_s[$sv]->get_ev_handler_en()) print $lang['disable']." "; else $lang['enable']." "; ?><? echo $lang['mon_eh_service']; ?></a></li>
						<li><a href='./phpradmin.php?p=306&cmd=<? if ($Logs->log_h[$h]->log_s[$sv]->get_sv_is_flapping()) print "58"; else print "57"; ?>&id=<? print $sv; // ?>' class="text9"><? if ($Logs->log_h[$h]->log_s[$sv]->get_sv_is_flapping()) print $lang['disable']." "; else $lang['enable']." "; ?><? echo $lang['mon_fp_service']; ?></a></li>
					</ul>
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
<?
	} else {
		print "<div class='text11b' style='padding:40px'>".$lang['mon_no_stat_for_service']."</div>";
		print "<SCRIPT LANGUAGE='JavaScript'> setTimeout(\"javascript:history.go(-1)\",2000)</SCRIPT>";
	} ?>