<?
/*
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)
For information : toni@blyx.com
*/
	if (!isset($oreon))
		exit();
?>
<table border=0 align="center">
	<tr>
		<td align="center" style="padding-bottom: 20px;">
			<?	include("./include/status/resume.php"); ?>
		</td>
	</tr>
	<tr>
	 	<td class="text14b" align="center" style="text-decoration: underline; padding-bottom: 10px;"><? echo $lang['m_hosts_problems']; ?></td>
	</tr>
	<tr>
		<td align="center">
			<table style="border-width: thin; border-style: dashed; border-color=#9C9C9C;" cellpadding="2" cellspacing="1">
				<tr bgColor="#eaecef">
				  <td align="center" class="text12b"><? echo $lang['h']; ?></td>
				  <td align="center" class="text12b"><? echo $lang['mon_status']; ?></td>
				  <td align="center" class="text12b"><? echo $lang['mon_last_check']; ?></td>
				  <td align="center" class="text12b"><? echo $lang['mon_duration']; ?></td>
				  <td align="center" class="text12b"><? echo $lang['mon_status_information']; ?></td>
				</tr>
			<?
			foreach ($Logs->log_h as $log_h)	{
				$id_host = 0;
				if ($oreon->is_accessible($log_h->get_id()) && (!strcmp($log_h->get_status(), "DOWN") || !strcmp($log_h->get_status(), "UNREACHABLE"))){
					if (strcmp($log_h->get_name(), $old))
						echo "<tr><td bgcolor='". return_color($i, $log_h->get_status()) ."'> <a href='phpradmin.php?p=102&h=".$log_h->get_id()."&o=w' class='text9'>".$log_h->get_name()."</a></td>";
					else
						echo "<tr><td>&nbsp;</td>";
					echo "<td bgcolor=" . return_color_status($log_h->get_status()) . " class='text9'> " . $log_h->get_status() . "</td>";
					if ($log_h->get_last_check() != 0)
						echo "<td bgcolor='". return_color($i, $log_h->get_status()) ."' class='text9'' align='center' style='white-space: nowrap;'> ".date($lang["date_time_format_status"], $log_h->get_last_check())."</td>";
					else
						echo "<td bgcolor='". return_color($i, $log_h->get_status()) ."' class='text9' align='center' style='white-space: nowrap;'>&nbsp;</td>";
					$duration =  time() - $log_h->get_last_check();
					if ($log_h->get_last_check() != 0){
						$hour = date("h", $duration) - 1;
						echo "<td bgcolor='". return_color($i, $log_h->get_status()) ."' class='text9' align='center' style='white-space: nowrap;'> " . $hour . date(":i:s", $duration) ."&nbsp;&nbsp;</td>";
					} else
						echo "<td bgcolor='". return_color($i, $log_h->get_status()) ."' class='text9' align='center' style='white-space: nowrap;'>&nbsp;</td>";
					if (isset($_GET["type"]) && (!strcmp($_GET["type"], "0") || !strcmp($_GET["type"], "")))
						printf("<td bgcolor=" . return_color($i, $log_h->get_status()) . "><a href='phpradmin.php?p=303&o=h&type=1' class='text9'>%.50s</a></td></tr>", $log_h->get_output());
					else
						printf("<td bgcolor=" . return_color($i, $log_h->get_status()) . " class='text9'> %s</td></tr>", $log_h->get_output());
				}
				$i++;
				$old = $log_h->get_name();
				unset($log_h);
			}
			?>
			</table>
		</td>
	</tr>
</table>