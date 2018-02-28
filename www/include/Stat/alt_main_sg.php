<?
/*
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)
For information : toni@blyx.com
*/
print "<tr><td width='100%' colspan='2'><center>";
print "<div align='left'><img style=\"cursor: hand;\" id=\"handle2\" name=\"handle2\" src=\"img/picto1.gif\" alt=\"\" onclick='hideobject(\"servGroup\", \"showServGroup\", \"handle2\", \"./img/picto1.gif\");'>&nbsp;&nbsp;<a  onclick='hideobject(\"servGroup\", \"showServGroup\", \"handle2\", \"./img/picto1.gif\");' class='text11b'>";
print $lang['am_sg_detail'] ;
print "</a></div><div style=\"display: none;\" id=\"servGroup\"><br><br>";$i = 0;
if (isset($oreon->serviceGroups)){
	foreach ($oreon->serviceGroups as $svg)	{
		if (isset($svg) && $svg->get_activate())		{
			$status_s = array("OK" => 0, "PENDING" => 0, "WARNING" => 0, "CRITICAL" => 0, "UNKNOWN" => 0);
			$oreon->emulServiceGroupServices($svg);
			foreach ($svg->servicesEmul as $service){
				if ($service->get_register() && isset($Logs->log_h[$oreon->hosts[$service->get_host()]->get_id()]->log_s[$service->get_id()]))
					$status_s[$Logs->log_h[$oreon->hosts[$service->get_host()]->get_id()]->log_s[$service->get_id()]->get_status()]++;
				unset($service);
			}
			$x = 320;
			$y = 150;
			$sn_s = "ServiceGroup : " . $svg->get_name();
			$fontcolor='000000';
			$theme = "pastel";
			// For services
			$total = $status_s["OK"] + $status_s["WARNING"] + $status_s["CRITICAL"] + $status_s["PENDING"] + $status_s["UNKNOWN"];	
			if ($total != 0){
				$data = array($status_s["OK"] * 100 / $total, $status_s["WARNING"] * 100 / $total, $status_s["CRITICAL"] * 100 / $total, $status_s["PENDING"] * 100 / $total, $status_s["UNKNOWN"] * 100 / $total);
				$label = array("OK - ".$status_s["OK"], "WARNING - ".$status_s["WARNING"], "CRITICAL - ".$status_s["CRITICAL"], "PENDING - ".$status_s["PENDING"], "UNKNOWN - ".$status_s["UNKNOWN"]);
				$str = "<img src='./include/reports/draw_graph_service.php?sn=$sn_s&coord_x=$x&coord_y=$y&fontcolor=";
				$str .= "$fontcolor&theme=$theme&dataA=$data[0]&dataB=$data[1]&dataC=$data[2]&dataD=$data[3]&dataE=$data[4]&colorA=$color[0]&colorB=$color[1]";
				$str .= "&colorC=$color[2]&colorD=$color[3]&colorE=$color[4]&labelA=$label[0]&labelB=$label[1]&labelC=$label[2]&labelD=$label[3]&labelE=$label[4]'>";
				print $str;
				if ($i % 2 == 1)
					print "<br><br>";
			}								
		}
		$i++;
		unset($svg);
	}	
}
?>
</div>
	<script language="Javascript">
	if (!Get_Cookie('showServGroup')) {
		Set_Cookie('showServGroup','true',30,'/','','');
	}
	var show = Get_Cookie('showServGroup');

	if (show == 'true') {
		this.document.getElementById('servGroup').style.display='inline';
		document['handle2'].src = 'img/picto1.gif';
	} else {
		this.document.getElementById('servGroup').style.display='none';
		document['handle2'].src = 'img/picto1.gif';	
		
	}
	</script>	
<?
print "</center></td></tr>";
?>
