<?
/*
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)
For information : toni@blyx.com
*/
	if (!isset($oreon))
		exit();

	$status_h = array();
	$status_s = array();
?>
<table border=0 align="center">
	<tr>
		<td align="center" style="padding-bottom: 20px;">
			<?	include("./include/status/resume.php"); ?>
		</td>
	</tr>
	<tr>
	 	<td class="text14b" align="center" style="text-decoration: underline; padding-bottom: 10px;"><? echo $lang['mon_status_summary_foh']; ?></td>
	</tr>
	<tr>
		<td align="center">
			<table style="border-width: thin; border-style: dashed; border-color=#9C9C9C;" cellpadding="4" cellspacing="2">
				<tr  bgcolor="#eaecef">
				  <td align="center" class="text12b">&nbsp;&nbsp;<? echo $lang['hg']; ?>&nbsp;&nbsp;</td>
				  <td align="center" class="text12b">&nbsp;&nbsp;<? echo $lang['mon_host_status_total']; ?>&nbsp;&nbsp;</td>
				  <td align="center" class="text12b">&nbsp;&nbsp;<? echo $lang['mon_service_status_total']; ?>&nbsp;&nbsp;</td>
				</tr>	
				<?
				foreach ($oreon->hostGroups as $hg)	{
					if (isset($hg)){
						$status_s["OK"] = 0;
						$status_s["PENDING"] = 0;
						$status_s["WARNING"] = 0;
						$status_s["CRITICAL"] = 0;
						$status_s["UNKNOWN"] = 0;
						$status_s["nb"] = 0;			
						$status_h["UP"] = 0;
						$status_h["DOWN"] = 0;
						$status_h["PENDING"] = 0;
						$status_h["UNREACHABLE"] = 0;
						$status_h["UNKNOWN"] = 0;
						$status_host = 0;
						foreach ($hg->hosts as $h){ 
							if (isset($Logs->log_h[$h->get_id()]) && $oreon->is_accessible($h->get_id())){
								$status_host++;
								$status_h[$Logs->log_h[$h->get_id()]->get_status()]++;
								foreach ($Logs->log_h[$h->get_id()]->log_s as $s){
									$status_s[$s->get_status()]++;
									unset ($s);
								}
							}
							unset($h);
						}
						if ($status_host != 0){
							echo "<tr bgcolor='#E9E9E9'><td valign='top'>\n";
							echo "<a href='./phpradmin.php?p=103&hg=".$hg->get_id()."&o=w' class='text10'>".$hg->get_name()."</a>&nbsp;&nbsp;&nbsp;&nbsp;";
							echo "<a href='./phpradmin.php?p=317&hg=".$hg->get_id()."' class='text11b'><img src='./img/info2.gif' border=0 height='8'></a>\n</td>\n";
							print "<td align=center valign='top'>&nbsp;";
							$t = 0;
							foreach ($status_h as $stt => $vl)	{
								if ($vl != 0){
									print "<font color='424242' class='hostTotals".$stt."'>".$stt ." " .$vl . "</font>";
									if ($t % 2)
										print "<br>";
								}
								unset($stt);
								unset($vl);
								$t ++;
							}
							$t = 0;
							print "</td><td align=center valign='top'>&nbsp;"; 
							foreach ($status_s as $stt => $vl){
								if ($vl != 0){
									print "<font color='424242' class='miniStatus".$stt."'><a href='./phpradmin.php?p=303&host_group=".$hg->get_id()."' class='text11b'>".$stt ." " .$vl . "</a></font>";	
									if ($t % 2 && $t != 0) 
										print "<br>";
									else
										print "&nbsp;";
								}
								unset($stt);
								unset($vl);
								$t ++;
							}
							print "</td></tr>";
						}
					}	 
				}
				?>	
			</table>
		</td>
	</tr>
</table>
	