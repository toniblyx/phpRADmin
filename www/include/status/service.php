<?
/*
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)
For information : toni@blyx.com
*/
	if (!isset($oreon))
		exit();
	require_once './class/other.class.php';

?>
<table border=0 align="center">
	<tr>
		<td align="center" style="padding-bottom: 20px;">
			<?	include("./include/status/resume.php"); ?>
		</td>
	</tr>
	<? if (isset($_GET["service_group"]))	{	?>
	<tr>
		<td style="padding-bottom: 8px;">
			<form name="form1" method="get" action="./phpradmin.php?p=303">
				<input name="p" type="hidden" value="303">
				<div class="text11b">
					<? echo $lang['sg']; ?>&nbsp;&nbsp;
					<select name="service_group" onChange="this.form.submit();">
					<?
						foreach ($oreon->serviceGroups as $sg)	{
							print "<option value='".$sg->get_id()."'";
							if ($sg->get_id() == $_GET["service_group"])
								print " selected";
							print ">".$sg->get_name()."</option>";
							unset($sg);
						}
					?>
					</select>
				</div>
			</form>
		</td>
	</tr>
	<? } ?>
	<tr>
		<td class="text14b" align="center" style="text-decoration: underline; padding-bottom: 10px;">
		  	<? echo $lang['mon_sv_hg_detail1'];
				if (isset($_GET["host_group"]))
					print " ".$lang['mon_sv_hg_detail2']." ".$oreon->hostGroups[$_GET["host_group"]]->get_name() ."";
				if (isset($_GET["host_id"]))
					print " ".$lang['mon_sv_hg_detail3']." ".$oreon->hosts[$_GET["host_id"]]->get_name() ."";
			?>
		</td>
	</tr>
	<tr>
		<td>
			<table style="border-width: thin; border-style: dashed; border-color=#9C9C9C;" cellpadding="2" cellspacing="1">
				<tr bgColor="#eaecef">
				  <td align="center" class="text12b"><? echo $lang['h']; ?></td>
				  <td align="center" class="text12b"><? echo $lang['s']; ?></td>
				  <td align="center" class="text12b"><? echo $lang['mon_status']; ?></td>
				  <td align="center" class="text12b"><? echo $lang['mon_last_check']; ?></td>
				  <td align="center" class="text12b"><? echo $lang['mon_duration']; ?></td>
				  <td align="center" class="text12b"><? echo $lang['mon_retry']; ?></td>
				  <td align="center" class="text12b"><? echo $lang['mon_status_information']; ?></td>
				</tr>
					<?
					if (!isset($_GET["host_id"]) && !isset($_GET["host_group"]) && !isset($_GET["service_group"]))	{
						foreach ($Logs->log_h as $log_h)		{
							foreach ($log_h->log_s as $s)	{
								if ($oreon->is_accessible($log_h->get_id()))	{
									if (strcmp($s->get_host_name(), $old))	{
										echo "<tr><td bgcolor='".return_color($i, $log_h->get_status())."'>";
										echo "<a href='./phpradmin.php?p=102&h=".$log_h->get_id()."&o=w' class='text9'>".$s->get_host_name()."</a>&nbsp;&nbsp;&nbsp;&nbsp;";
										echo "<a href='./phpradmin.php?p=314&h=".$log_h->get_id()."'><img src='./img/info2.gif' border=0 alt='". $lang['mon_host_state_info']."' title='".$lang['mon_host_state_info']."' ></a></td>";
									}
									else
										echo "<tr><td>&nbsp;</td>";
									echo "<td bgcolor='". return_color($i, $s->get_status()) ."'><table width='100%'><tr><td><a href='./phpradmin.php?p=104&sv=".$s->get_id()."&o=w' class='text9'>".$s->get_description()."</a></td><td align='right'>";
									if (!$s->get_accept_passive_check() && !$s->get_checks_en())
										echo "<img src='./img/check_stop.gif' border=0 height='8' alt='".$lang['mon_service_check_disabled']."'  title='".$lang['mon_service_check_disabled']."' >&nbsp;";
									if ($s->get_accept_passive_check() && !$s->get_checks_en())
										echo "<img src='./img/passiveonly.gif' border=0 height='8' alt='".$lang['mon_service_check_passice_only']."' title='".$lang['mon_service_check_passice_only']."' >&nbsp;";
									if (!$s->get_not_en())
										echo "<img src='./img/notifications.gif' border=0 height='8' alt='".$lang['mon_notif_disabled']."' title='".$lang['mon_notif_disabled']."' >&nbsp;";
									if (isset($oreon->graphs[$s->get_id()]))
										echo "<a href='./phpradmin.php?p=310&gr=".$s->get_id()."&o=v'><img src='./img/iconGraph.gif' border=0 width=8 alt='".$lang['mon_service_view_graph']."' title='".$lang['mon_service_view_graph']."' ></a>&nbsp;";
									echo "<a href='./phpradmin.php?p=315&id=".$s->get_id()."'><img src='./img/info2.gif' border=0 height='10' alt='".$lang['mon_service_state_info']."' title='".$lang['mon_service_state_info']."' ></a>&nbsp;<a href='./phpradmin.php?p=306&cmd=67&id=". $s->get_id(). "'><img src='./img/reschedule.gif' border=0 height='10' alt='".$lang['mon_service_sch_check']."' title='".$lang['mon_service_sch_check']."' ></a></td></tr></table></td>";
									echo "<td bgcolor=" . return_color_status($s->get_status()) . " align='center' class='text9'>" . $s->get_status() . "</td>";
									if (strcmp($s->get_last_check(), "0"))
										echo "<td bgcolor='". return_color($i, $s->get_status()) ."' class='text9' align='center' style='white-space: nowrap;'> ".date($lang["date_time_format_status"], $s->get_last_check())."</td>";
									else
										echo "<td bgcolor='". return_color($i, $s->get_status()) ."'>&nbsp;</td>";
									if (strcmp($s->get_last_check(), "0"))
										echo "<td bgcolor='". return_color($i, $s->get_status()) ."' align='right' class='text9'>".Duration::toString(time() - $s->get_last_change())."&nbsp;</td>";
									else
										echo "<td bgcolor='". return_color($i, $s->get_status()) ."'>&nbsp;</td>";
									echo "<td bgcolor='". return_color($i, $s->get_status()) ."' align='right' class='text9'> ".$s->get_retry()."&nbsp;&nbsp;&nbsp;</td>";
									print "<td bgcolor=" . return_color($i, $s->get_status()) . " class='text9'>" . $s->get_output() . "</td></tr>";
									$i++;
									$old = $s->get_host_name();
								}
								unset($s);
							}
							unset($log_h);
						}
					} else if (isset($_GET["host_id"]) && !isset($_GET["host_group"]) && !isset($_GET["service_group"]) && isset($oreon->hosts[$_GET["host_id"]])) {
						foreach ($Logs->log_h[$_GET["host_id"]]->log_s as $s)	{
							//if (!$oreon->is_accessible($Logs->log_h[$_GET["host_id"]]->get_id()))
							//	break;
							if (strcmp($s->get_host_name(), $old)){
								echo "<tr><td bgcolor='".return_color($i, $s->get_status())."'>";
								echo "<a href='./phpradmin.php?p=102&h=".$Logs->log_h[$_GET["host_id"]]->get_id()."&o=w' class='text9'>".$s->get_host_name()."</a>&nbsp;&nbsp;&nbsp;&nbsp;";
								echo "<a href='./phpradmin.php?p=314&h=".$Logs->log_h[$_GET["host_id"]]->get_id()."'><img src='./img/info2.gif' border=0 height='8' alt='".$lang['mon_host_state_info']."' title='".$lang['mon_host_state_info']."'></a></td>";
							}
							else
								echo "<tr><td>&nbsp;</td>";
							echo "<td bgcolor='". return_color($i, $s->get_status()) ."'><table width='100%'><tr><td><a href='./phpradmin.php?p=104&sv=".$s->get_id()."&o=w' class='text9'>".$s->get_description()."</a></td><td align='right'>";
							if (!$s->get_accept_passive_check() && !$s->get_checks_en())
								echo "<img src='./img/check_stop.gif' border=0 height='8' alt='".$lang['mon_service_check_disabled']."' title='".$lang['mon_service_check_disabled']."' >&nbsp;";
							if (!$s->get_not_en())
								echo "<img src='./img/notifications.gif' border=0 height='8' alt='".$lang['mon_notif_disabled']."' title='".$lang['mon_notif_disabled']."' >";
							if (isset($oreon->graphs[$s->get_id()]))
								echo "<a href='./phpradmin.php?p=310&gr=".$s->get_id()."&o=v'><img src='./img/iconGraph.gif' border=0 width=8 alt='".$lang['mon_service_view_graph']."' title='".$lang['mon_service_view_graph']."' ></a>&nbsp;";
							echo "<a href='./phpradmin.php?p=315&id=".$s->get_id()."'><img src='./img/info2.gif' border=0 alt='".$lang['mon_service_state_info']."' title='".$lang['mon_service_state_info']."' ></a>&nbsp;<a href='./phpradmin.php?p=306&cmd=67&id=". $s->get_id(). "'><img src='./img/reschedule.gif' border=0 height='10' alt='".$lang['mon_service_sch_check']."' title='".$lang['mon_service_sch_check']."' ></a></td></tr></table></td>";
							echo "<td bgcolor=" . return_color_status($s->get_status()) . " align='center' class='text9'>" . $s->get_status() . "</td>";
							if (strcmp($s->get_last_check(), "0"))
								echo "<td bgcolor='". return_color($i, $s->get_status()) ."' class='text9' align='center' style='white-space: nowrap;'> ".date($lang["date_time_format_status"], $s->get_last_check())."</td>";
							else
								echo "<td bgcolor='". return_color($i, $s->get_status()) ."'>&nbsp;</td>";
							if (strcmp($s->get_last_check(), "0"))
								echo "<td bgcolor='". return_color($i, $s->get_status()) ."' align='right' class='text9'>".Duration::toString(time() - $s->get_last_change())."&nbsp;</td>";
							else
								echo "<td bgcolor='". return_color($i, $s->get_status()) ."'>&nbsp;</td>";
							echo "<td bgcolor='". return_color($i, $s->get_status()) ."' align='right' class='text9'> ".$s->get_retry()."&nbsp;&nbsp;&nbsp;</td>";
							print "<td bgcolor=" . return_color($i, $s->get_status()) . " class='text9'>" . $s->get_output() . "</td></tr>";
							$i++;
							$old = $s->get_host_name();
							unset($s);
						}
					}
					else if (isset($_GET["host_group"]) && isset($oreon->hostGroups[$_GET["host_group"]]) && !isset($_GET["service_group"]))	{
						if ($oreon->hostGroups[$_GET["host_group"]])
							foreach ($oreon->hostGroups[$_GET["host_group"]]->hosts as $h)	{
								if (isset($Logs->log_h[$h->get_id()]))	{
									if ($oreon->is_accessible($h->get_id()))	{
										foreach ($Logs->log_h[$h->get_id()]->log_s as $s)	{
											if (strcmp($s->get_host_name(), $old))	{
												echo "<tr><td bgcolor='".return_color($i, $s->get_status())."'>";
												echo "<a href='./phpradmin.php?p=102&h=".$h->get_id()."&o=w' class='text9'>".$s->get_host_name()."</a>&nbsp;&nbsp;&nbsp;&nbsp;";
												echo "<a href='./phpradmin.php?p=314&h=".$h->get_id()."'><img src='./img/info2.gif' border=0 height='8' alt='".$lang['mon_host_state_info']."' title='".$lang['mon_host_state_info']."' ></a></td>";
											}
											else
												echo "<tr><td>&nbsp;</td>";
											echo "<td bgcolor='". return_color($i, $s->get_status()) ."'><table width='100%'><tr><td><a href='./phpradmin.php?p=104&sv=".$s->get_id()."&o=w' class='text9'>".$s->get_description()."</a></td><td align='right'>";
											if (!$s->get_accept_passive_check() && !$s->get_checks_en())
												echo "<img src='./img/check_stop.gif' border=0 height='8' alt='".$lang['mon_service_check_disabled']."' title='".$lang['mon_service_check_disabled']."' >&nbsp;";
											if (!$s->get_not_en())
												echo "<img src='./img/notifications.gif' border=0 height='8' alt='".$lang['mon_notif_disabled']."' title='".$lang['mon_notif_disabled']."'>";
											if (isset($oreon->graphs[$s->get_id()]))
												echo "<a href='./phpradmin.php?p=310&gr=".$s->get_id()."&o=v'><img src='./img/iconGraph.gif' border=0 width=8 alt='".$lang['mon_service_view_graph']."' title='".$lang['mon_service_view_graph']."'></a>&nbsp;";
											echo "<a href='./phpradmin.php?p=315&id=".$s->get_id()."'><img src='./img/info2.gif' border=0 height='10' alt='".$lang['mon_service_state_info']."' title='".$lang['mon_service_state_info']."'></a>&nbsp;<a href='./phpradmin.php?p=306&cmd=67&id=". $s->get_id(). "'><img src='./img/reschedule.gif' border=0 height='10' alt='".$lang['mon_service_sch_check']."' title='".$lang['mon_service_sch_check']."'></a></td></tr></table></td>";
											echo "<td bgcolor=" . return_color_status($s->get_status()) . " align='center' class='text9'>" . $s->get_status() . "</td>";
											if (strcmp($s->get_last_check(), "0"))
												echo "<td bgcolor='". return_color($i, $s->get_status()) ."' class='text9' align='center' style='white-space: nowrap;' heigh='12'> ".date($lang["date_time_format_status"], $s->get_last_check())."</td>";
											else
												echo "<td bgcolor='". return_color($i, $s->get_status()) ."'>&nbsp;</td>";
											if (strcmp($s->get_last_check(), "0"))
												echo "<td bgcolor='". return_color($i, $s->get_status()) ."' align='right' class='text9'>".Duration::toString(time() - $s->get_last_change())."&nbsp;</td>";
											else
												echo "<td bgcolor='". return_color($i, $s->get_status()) ."' heigh='12'>&nbsp;</td>";
											echo "<td bgcolor='". return_color($i, $s->get_status()) ."' align='right' class='text9'> ".$s->get_retry()."&nbsp;&nbsp;&nbsp;</td>";
											print "<td bgcolor=" . return_color($i, $s->get_status()) . " class='text9'>" . $s->get_output() . "</td></tr>";
											$i++;
											$old = $s->get_host_name();
											unset($s);
										}
									}
								}
								unset($h);
							}
					} else if (isset($_GET["service_group"]) && isset($oreon->serviceGroups[$_GET["service_group"]])) {
						foreach ($oreon->serviceGroups[$_GET["service_group"]]->services as $s)		{
							if (isset($s->activate) && !strcmp("1", $s->activate) && !strcmp("1", $oreon->hosts[$s->get_host()]->activate) && isset($Logs->log_h[$oreon->hosts[$s->get_host()]->get_id()]) && isset($Logs->log_h[$oreon->hosts[$s->get_host()]->get_id()]->log_s[$s->get_id()])){
								if ($s->get_register() && $oreon->is_accessible($s->get_host())){
									if ($s->get_register() && strcmp($oreon->hosts[$s->get_host()]->get_name(), $old)){
										echo "<tr><td bgcolor='".return_color($i, $Logs->log_h[$oreon->hosts[$s->get_host()]->get_id()]->log_s[$s->get_id()]->get_status())."'>"  ;
										echo "<a href='./phpradmin.php?p=102&h=".$oreon->hosts[$s->get_host()]->get_id()."&o=w' class='text9'>".$Logs->log_h[$oreon->hosts[$s->get_host()]->get_id()]->log_s[$s->get_id()]->get_host_name()."</a>&nbsp;&nbsp;&nbsp;&nbsp;";
										echo "<a href='./phpradmin.php?p=314&h=".$oreon->hosts[$s->get_host()]->get_id()."'><img src='./img/info2.gif' border=0 height='8' alt='".$lang['mon_host_state_info']."' title='".$lang['mon_host_state_info']."' ></a></td>";
									}
									else
										echo "<tr><td>&nbsp;</td>";
									echo "<td bgcolor='". return_color($i, $Logs->log_h[$oreon->hosts[$s->get_host()]->get_id()]->log_s[$s->get_id()]->get_status()) ."'>";
									echo "<table width='100%'><tr><td><a href='./phpradmin.php?p=104&sv=".$s->get_id()."&o=w' class='text9'>".$Logs->log_h[$oreon->hosts[$s->get_host()]->get_id()]->log_s[$s->get_id()]->get_description()."</a></td><td align='right'>";
									if (!$Logs->log_h[$oreon->hosts[$s->get_host()]->get_id()]->log_s[$s->get_id()]->get_accept_passive_check() && !$Logs->log_h[$oreon->hosts[$s->get_host()]->get_id()]->log_s[$s->get_id()]->get_checks_en())
											echo "<img src='./img/check_stop.gif' border=0 height='8' alt='".$lang['mon_service_check_disabled']."' title='".$lang['mon_service_check_disabled']."' >&nbsp;";
									if (!$Logs->log_h[$oreon->hosts[$s->get_host()]->get_id()]->log_s[$s->get_id()]->get_not_en())
										echo "<img src='./img/notifications.gif' border=0 height='8' alt='".$lang['mon_notif_disabled']."'  title='".$lang['mon_notif_disabled']."'>";
									if (isset($oreon->graphs[$s->get_id()]))
										echo "<a href='./phpradmin.php?p=310&gr=".$s->get_id()."&o=v'><img src='./img/iconGraph.gif' border=0 width=8 alt='".$lang['mon_service_view_graph']."'  title='".$lang['mon_service_view_graph']."'></a>&nbsp;";
									echo "<a href='./phpradmin.php?p=315&id=".$s->get_id()."'><img src='./img/info2.gif' border=0 height='10' alt='".$lang['mon_service_state_info']."' title='".$lang['mon_service_state_info']."'></a>&nbsp;<a href='./phpradmin.php?p=306&cmd=67&id=". $s->get_id(). "'><img src='./img/reschedule.gif' border=0 height='10' alt='".$lang['mon_service_sch_check']."' title='".$lang['mon_service_sch_check']."'></a></td></tr></table></td>";
									echo "<td bgcolor=" . return_color_status($Logs->log_h[$oreon->hosts[$s->get_host()]->get_id()]->log_s[$s->get_id()]->get_status()) . " align='center'>" . $Logs->log_h[$oreon->hosts[$s->get_host()]->get_id()]->log_s[$s->get_id()]->get_status() . "</td>";
									if (strcmp($Logs->log_h[$oreon->hosts[$s->get_host()]->get_id()]->log_s[$s->get_id()]->get_last_check(), "0"))
										echo "<td bgcolor='". return_color($i, $Logs->log_h[$oreon->hosts[$s->get_host()]->get_id()]->log_s[$s->get_id()]->get_status()) ."' class='text9' align='center' style='white-space: nowrap;' heigh='12'> ".date($lang["date_time_format_status"], $Logs->log_h[$oreon->hosts[$s->get_host()]->get_id()]->log_s[$s->get_id()]->get_last_check())."</td>";
									else
										echo "<td bgcolor='". return_color($i, $Logs->log_h[$oreon->hosts[$s->get_host()]->get_id()]->log_s[$s->get_id()]->get_status()) ."'>&nbsp;</td>";
									if (strcmp($Logs->log_h[$oreon->hosts[$s->get_host()]->get_id()]->log_s[$s->get_id()]->get_last_check(), "0"))
										echo "<td bgcolor='". return_color($i, $Logs->log_h[$oreon->hosts[$s->get_host()]->get_id()]->log_s[$s->get_id()]->get_status()) ."' align='right' class='text9'>".Duration::toString(time() - $Logs->log_h[$oreon->hosts[$s->get_host()]->get_id()]->log_s[$s->get_id()]->get_last_change())."&nbsp;</td>";
									else
										echo "<td bgcolor='". return_color($i, $Logs->log_h[$oreon->hosts[$s->get_host()]->get_id()]->log_s[$s->get_id()]->get_status()) ."'>&nbsp;</td>";
									echo "<td bgcolor='". return_color($i, $Logs->log_h[$oreon->hosts[$s->get_host()]->get_id()]->log_s[$s->get_id()]->get_status()) ."' align='right' class='text9'> ".$Logs->log_h[$oreon->hosts[$s->get_host()]->get_id()]->log_s[$s->get_id()]->get_retry()."&nbsp;&nbsp;&nbsp;</td>";
									print "<td bgcolor=" . return_color($i, $Logs->log_h[$oreon->hosts[$s->get_host()]->get_id()]->log_s[$s->get_id()]->get_status()) . " class='text9'>" . $Logs->log_h[$oreon->hosts[$s->get_host()]->get_id()]->log_s[$s->get_id()]->get_Output() . "</td></tr>";
									$i++;
									$old = $oreon->hosts[$s->get_host()]->get_name();

								}
							}
							//unset($s);
						}
						$i++;
						unset($svg);
					}
					?>
			</table>
		</td>
	</tr>
</table>