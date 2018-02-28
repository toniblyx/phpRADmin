<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/if (!isset($oreon))
		exit();
?>
<table border=0 align="center">
	<tr>
		<td align="center" style="padding-bottom: 20px;">
			<?	include("./include/status/resume.php"); ?>
		</td>
	</tr>
	<tr>
	 	<td class="text14b" align="center" style="text-decoration: underline; padding-bottom: 10px;"><? echo $lang['mon_scheduling']; ?></td>
	</tr>
	<tr>
		<td align="center">
			<table style="border-width: thin; border-style: dashed; border-color=#9C9C9C;" cellpadding="3" cellspacing="2">
				<tr bgcolor="#eaecef">
				  <td align="center" class="text12b">&nbsp;&nbsp;<? echo $lang['h']; ?>&nbsp;&nbsp;</td>
				  <td align="center" class="text12b">&nbsp;&nbsp;<? echo $lang['s']; ?>&nbsp;&nbsp;</td>
				  <td align="center" class="text12b">&nbsp;&nbsp;<? echo $lang['mon_last_check']; ?>&nbsp;&nbsp;</td>
				  <td align="center" class="text12b">&nbsp;&nbsp;<? echo $lang['mon_next_check']; ?>&nbsp;&nbsp;</td>
				  <td align="center" class="text12b">&nbsp;&nbsp;<? echo $lang['mon_active_check']; ?>&nbsp;&nbsp;</td>
				  <td align="center" class="text12b">&nbsp;&nbsp;<? echo $lang['mon_actions']; ?>&nbsp;&nbsp;</td>
				</tr>
				<?
					foreach ($Logs->log_h as $log_h)	{
						foreach ($log_h->log_s as $s)	{
							if (!$oreon->is_accessible($log_h->get_id()))
								break;
							$hosts = & $oreon->hosts;
							if (strcmp($s->get_host_name(), $old))
								echo "<tr><td bgcolor='". return_color($i, $s->get_status()) ."'> <a href='./phpradmin.php?p=102&h=".$log_h->get_id()."&o=w' class='text10'>".$s->get_host_name()."</a></td>";
							else
								echo "<tr><td>&nbsp;</td>";
							if (isset($oreon->services))
								foreach ($oreon->services as $service)
									if (!strcmp($service->get_description(), $s->get_description()))
										$id_service = $service->get_id();
								echo "<td bgcolor='". return_color($i, $s->get_status()) ."'> <a href='./phpradmin.php?p=104&sv=" . $id_service . "&o=w' class='text10'>".$s->get_description()."</a></td>";
								echo "<td bgcolor='". return_color($i, $s->get_status()) ."'> ".date($lang["date_time_format_status"], $s->get_last_check())."</td>";
								echo "<td bgcolor='". return_color($i, $s->get_status()) ."'> ".date($lang["date_time_format_status"], $s->get_next_check())."</td>";
							if (!strcmp($s->get_checks_en(), "1"))
								print "<td align='center' bgcolor='#33FF00'>".$lang['mon_active']."</td>";
							else
								print "<td align='center' bgcolor='#F83838'>".$lang['mon_inactive']."</td>";
							printf("<td bgcolor=" . return_color($i, $s->get_status()) . "><!-- <img src='./img/.gif' alt='submit new check'>--></td></tr>", $s->get_Output());
							$i++;
							$old = $s->get_host_name();
							unset($s);
						}
						unset($log_h);
					}
				?>
			</table>
		</td>
	</tr>
</table>