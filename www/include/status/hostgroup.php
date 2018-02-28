<?
/*
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)
For information : toni@blyx.com
*/
if (!isset($oreon))
	exit();
	$status = array();
	$status_hg = array();
	$flg = 0;
	$cpt = 0;	

if (isset($oreon->hostGroups))
	foreach ($oreon->hostGroups as $hg)		{
		$status_hg[$hg->get_id()] = 0;
		if (isset($hg)){
			$oreon->emulHostGroupHosts($hg);
			foreach ($hg->hostsEmul as $h)				{
				if ($oreon->is_accessible($h->get_id()) && isset($Logs->log_h[$h->get_id()])) {
					$status_hg[$hg->get_id()]++;
					$status[$h->get_id()] = array();
					$status[$h->get_id()]["OK"] = 0;
					$status[$h->get_id()]["PENDING"] = 0;
					$status[$h->get_id()]["WARNING"] = 0;
					$status[$h->get_id()]["CRITICAL"] = 0;
					$status[$h->get_id()]["UNKNOWN"] = 0;
					foreach ($Logs->log_h[$h->get_id()]->log_s as $s){
						$status[$h->get_id()][$s->get_status()]++;
						unset ($s);
					}
				}
				unset ($h);
			}
			unset ($hg);
		}
	}
?>
<table border=0 align="center">
	<tr>
		<td align="center" style="padding-bottom: 20px;">
			<?	include("./include/status/resume.php"); ?>
		</td>
	</tr>
	<tr>
	 	<td class="text14b" align="center" style="text-decoration: underline; padding-bottom: 10px;"><? echo $lang['mon_service_overview_fah']; ?></td>
	</tr>	
	<tr>
		<td align="center">
			<table align="center" border="0">
			<?
				if (isset($oreon->hostGroups))
					foreach ($oreon->hostGroups as $hg)		{
						if ($status_hg[$hg->get_id()] != 0 && $hg->get_activate())			{
							if ($cpt % 2 == 0)
								print "<tr>\n<td valign='top' align='center'>\n";
							else
								print "<td align='center'>\n";
							echo "<div align='center' style='padding-bottom: 8px;'><a href='./phpradmin.php?p=303&host_group=".$hg->get_id()."' class='text12b'>".$hg->get_name()."</a> (".$hg->get_alias().") <a href='./phpradmin.php?p=317&hg=".$hg->get_id()."''><img src='./img/info2.gif' border=0>\n</div>";
							echo "<table border='1' style='border-width: thin; border-style: dashed; border-color=#9C9C9C;' cellpadding='4' cellspacing='2'>\n";
							echo "<tr bgcolor='#eaecef'><td class='text12b' align='center'>".$lang['h']."</td><td class='text12b' align='center'>".$lang['mon_status']."</td><td class='text12b' align='center'>".$lang['s']."</td></tr>";
							if (isset($hg)){
								$oreon->emulHostGroupHosts($hg);
								foreach ($hg->hostsEmul as $h)					{ 
									if (isset($Logs->log_h[$h->get_id()]) && isset($status[$h->get_id()]) && $h->get_register()) {
										echo "<tr bgcolor='#E9E9E9'><td  valign='top'>";
										echo "<a href='./phpradmin.php?p=102&h=".$h->get_id()."&o=w' class='text9'>".$h->get_name()."</a>&nbsp;&nbsp;&nbsp;&nbsp;";
										echo "<a href='./phpradmin.php?p=314&h=".$h->get_id()."'><img src='./img/info2.gif' border=0 ></a></td>";
										echo "<td bgcolor='". return_color_status($Logs->log_h[$h->get_id()]->get_status()) ."' valign='top' align='center' class='text9'>".$Logs->log_h[$h->get_id()]->get_status()."</td>"; 
										print "<td align=left>";
										foreach ($status[$h->get_id()] as $stt => $vl){
											if ($vl != 0)
												print "<font color='424242' class='miniStatus".$stt."'><a href='./phpradmin.php?p=303&o=s&host_id=".$h->get_id()."' class='hostTotals".$stt."'>".$stt ." " .$vl . "</a></font>&nbsp;&nbsp;";	
											unset($vl);
											unset($stt);
										}
										print "</td>";
										unset($h);
									}
								}
							}
							print "</tr></table>";
							if ($cpt % 2 == 0)
								print "</td>";
							else
								print "</td></tr>"; 
							$cpt++;
						}
						unset($hg);
					}	
				?>	
			</table>
		</td>
	</tr>
</table>