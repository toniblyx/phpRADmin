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
	 	<td class="text14b" align="center" style="text-decoration: underline; padding-bottom: 10px;"><? echo $lang['m_services_problems']; ?></td>
	</tr>
	<tr>
		<td>
			<table style="border-width: thin; border-style: dashed; border-color=#9C9C9C;" cellpadding="3" cellspacing="2">
				<tr bgColor="#eaecef">
				  <td align="center" class="text12b">&nbsp;&nbsp;<? echo $lang['h']; ?>&nbsp;&nbsp;</td>
				  <td align="center" class="text12b">&nbsp;&nbsp;<? echo $lang['s']; ?>&nbsp;&nbsp;</td>
				  <td align="center" class="text12b">&nbsp;&nbsp;<? echo $lang['mon_status']; ?>&nbsp;&nbsp;</td>
				  <td align="center" class="text12b">&nbsp;&nbsp;<? echo $lang['mon_last_check']; ?>&nbsp;&nbsp;</td>
				  <td align="center" class="text12b">&nbsp;&nbsp;<? echo $lang['mon_duration']; ?>&nbsp;&nbsp;</td>
				  <td align="center" class="text12b">&nbsp;&nbsp;<? echo $lang['mon_retry']; ?>&nbsp;&nbsp;</td>
				  <td align="center" class="text12b">&nbsp;&nbsp;<? echo $lang['mon_status_information']; ?>&nbsp;&nbsp;</td>
				</tr>
				<?
				foreach ($Logs->log_h as $log_h)	{
					foreach ($log_h->log_s as $s)	{
						if ($oreon->is_accessible($log_h->get_id()) && (!strcmp("CRITICAL", $s->get_status()) || !strcmp("WARNING", $s->get_status())))	{
							if (strcmp($s->get_host_name(), $old))
									echo "<tr><td bgcolor='". return_color($i, $log_h->get_status()) ."'><a href='./phpradmin.php?p=102&h=".$log_h->get_id()."&o=w' class='text9'>".$s->get_host_name()."</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='./phpradmin.php?p=314&h=".$log_h->get_id()."'><img src='./img/info2.gif' border=0 height='10'></a></td>";
							else
								echo "<tr><td>&nbsp;</td>";
							echo "<td bgcolor='". return_color($i, $s->get_status()) ."'><table width='100%'><tr><td><a href='./phpradmin.php?p=104&sv=".$s->get_id()."&o=w' class='text9'>".$s->get_description()."</a></td><td align='right'>";
							if ($s->get_not_en())
								echo "<img src='./img/notification.gif' border=0 height='10'>";
							echo "<a href='./phpradmin.php?p=315&id=".$s->get_id()."'><img src='./img/info2.gif' border=0 height='10'></a></td></tr></table></td>";
							echo "<td bgcolor=" . return_color_status($s->get_status()) . " align='center' class='text9'>" . $s->get_status() . "</td>";
							if (strcmp($s->get_last_check(), "0"))
								echo "<td bgcolor='". return_color($i, $s->get_status()) ."' class='text9' align='center' style='white-space: nowrap;'> ".date($lang["date_time_format_status"], $s->get_last_check())."</td>";
							else
								echo "<td bgcolor='". return_color($i, $s->get_status()) ."'>&nbsp;</td>";
							$duration = time() - $s->get_last_check();
							if (strcmp($s->get_last_check(), "0"))
								echo "<td bgcolor='". return_color($i, $s->get_status()) ."' align='center' class='text9'> ". date("h:i:s", $duration) ."&nbsp;&nbsp;</td>";
							else
								echo "<td bgcolor='". return_color($i, $s->get_status()) ."'>&nbsp;</td>";
							echo "<td bgcolor='". return_color($i, $s->get_status()) ."' align='right' class='text9'> ".$s->get_retry()."&nbsp;&nbsp;&nbsp;</td>";
							if ((isset($_GET["type"]) && !strcmp($_GET["type"], "0")) || !isset($_GET["type"]))
								printf("<td bgcolor=" . return_color($i, $s->get_status()) . "><a href='phpradmin.php?p=303&o=sp&type=1' class='text9'>%.50s</a></td></tr>", $s->get_output());
							else
								printf("<td bgcolor=" . return_color($i, $s->get_status()) . " class='text9'>%s</td></tr>", $s->get_output());
							$old = $s->get_host_name();
						}
						unset($s);
					}
					unset($log_h);
				}
				?>
			</table>
		</td>
	</tr>
</table>