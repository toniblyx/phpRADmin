<?
/*
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)
For information : toni@blyx.com
*/

print "<tr><td width='100%' colspan='2'><center>";
print "<div align='left'><img style=\"cursor: hand;\" id=\"handle1\" name=\"handle1\" src=\"img/picto1.gif\" alt=\"\" onclick='hideobject(\"hostGroup\", \"showHostGroup\", \"handle1\", \"./img/picto1.gif\");'>&nbsp;&nbsp;<a onclick='hideobject(\"hostGroup\", \"showHostGroup\", \"handle1\", \"./img/picto1.gif\");' class='text11b'>";
print $lang['am_hg_detail'] ;
print "</a></div><div style=\"display: none;\" id=\"hostGroup\"><br><br>";
					
if (isset($oreon->hostGroups))	{
	foreach ($oreon->hostGroups as $hg)	{
		if (isset($hg) && $hg->get_activate()){
			$status_s = array("OK" => 0, "PENDING" => 0, "WARNING" => 0, "CRITICAL" => 0, "UNKNOWN" => 0);
			$status_h = array("UP" => 0, "DOWN" => 0, "PENDING" => 0, "UNREACHABLE" => 0, "UNKNOWN" => 0);
			$oreon->emulHostGroupHosts($hg);
			foreach ($hg->hostsEmul as $h){ 
				if ($h->get_register() && isset($Logs->log_h[$h->get_id()]) && $oreon->is_accessible($h->get_id())){
					$status_h[$Logs->log_h[$h->get_id()]->get_status()]++;
					foreach ($Logs->log_h[$h->get_id()]->log_s as $s){
						if ($oreon->services[$s->get_id()]->get_register()){
							$status_s[$s->get_status()]++;
							unset ($s);
						}
					}
					unset($h);
				}
			}
			$x = 320;
			$y = 150;
			$sn_s = $hg->get_name() . " - ".$lang['s'];
			$sn_h = $hg->get_name() . " - ".$lang['h'];
			$fontcolor='0000ff';
			$theme = "pastel";
			// For Hosts
			$total = $status_h["UP"] + $status_h["DOWN"] + $status_h["PENDING"] + $status_h["UNREACHABLE"];
			if ($total != 0){	
				$data = array($status_h["UP"] * 100 / $total, $status_h["DOWN"] * 100 / $total, $status_h["UNREACHABLE"] * 100 / $total, $status_h["PENDING"] * 100 / $total);
				$label = array("UP - ".$status_h["UP"], "DOWN - ".$status_h["DOWN"], "UNREA - ".$status_h["UNREACHABLE"], "PENDING - ".$status_h["PENDING"],);
				
				$str = "<a href='./phpradmin.php?p=303&o=h'><img src='./include/reports/draw_graph_host.php?sn=$sn_h&coord_x=$x&coord_y=$y&fontcolor=";
				$str .= "$fontcolor&theme=$theme&dataA=$data[0]&dataB=$data[1]&dataC=$data[2]&&colorA=$color[0]&colorB=$color[1]";
				$str .= "&colorC=$color[2]&&labelA=$label[0]&labelB=$label[1]&labelC=$label[2]' border=0></a>";
				print $str . "&nbsp;";
			}
			// For services
			$total = $status_s["OK"] + $status_s["WARNING"] + $status_s["CRITICAL"] + $status_s["PENDING"] + $status_s["UNKNOWN"];	
			if ($total != 0){
				$data = array($status_s["OK"] * 100 / $total, $status_s["WARNING"] * 100 / $total, $status_s["CRITICAL"] * 100 / $total, $status_s["PENDING"] * 100 / $total, $status_s["UNKNOWN"] * 100 / $total);
				$label = array("OK - ".$status_s["OK"], "WARNING - ".$status_s["WARNING"], "CRITICAL - ".$status_s["CRITICAL"], "PENDING - ".$status_s["PENDING"], "UNKNOWN - ".$status_s["UNKNOWN"]);
				
				$str = "<a href='./phpradmin.php?p=303&host_group=".$hg->get_id()."'><img src='./include/reports/draw_graph_service.php?sn=$sn_s&coord_x=$x&coord_y=$y&fontcolor=";
				$str .= "$fontcolor&theme=$theme&dataA=$data[0]&dataB=$data[1]&dataC=$data[2]&dataD=$data[3]&dataE=$data[4]&colorA=$color[0]&colorB=$color[1]";
				$str .= "&colorC=$color[2]&colorD=$color[3]&colorE=$color[4]&labelA=$label[0]&labelB=$label[1]&labelC=$label[2]&labelD=$label[3]&labelE=$label[4]' border=0></a>";
				
			}
			print $str . "<br>";								
		} 
		unset($hg);
	}
}
?>
</div>
	<script language="Javascript">
	if (!Get_Cookie('showHostGroup')) {
		Set_Cookie('showHostGroup','true',30,'/','','');
	}
	var show = Get_Cookie('showHostGroup');

	if (show == 'true') {
		this.document.getElementById('hostGroup').style.display='inline';
		document['handle1'].src = './img/picto1.gif';
	} else {
		this.document.getElementById('hostGroup').style.display='none';
		document['handle1'].src = './img/picto1.gif';	
		
	}
	</script>	
<?
print "</center></td></tr>";
?>