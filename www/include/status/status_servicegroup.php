<?
/*
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)
For information : toni@blyx.com
*/ 
	if (!isset($oreon))
		exit();
	$flg = 0;
	$cpt = 0;
?>	
<table border=0 align="center">
	<tr>
		<td align="center" style="padding-bottom: 20px;">
			<?	include("./include/status/resume.php"); ?>
		</td>
	</tr>
	<tr>
	 	<td class="text14b" align="center" style="text-decoration: underline; padding-bottom: 10px;"><? echo $lang['mon_service_overview_fas']; ?></td>
	</tr>	
	<tr>
		<td align="center">
			<table style="border-width: thin; border-style: dashed; border-color=#9C9C9C;" cellpadding="4" cellspacing="2">
			<tr align='center' bgcolor='#eaecef'><td class='text11b' wisth='200'>&nbsp;&nbsp;<? echo $lang['sg']; ?>&nbsp;&nbsp;</td><td class='text11b'>&nbsp;&nbsp;<? echo $lang['mon_status']; ?>&nbsp;&nbsp;</td></tr>
<?
				$status_s = array();
				if (isset($oreon->serviceGroups))
					foreach ($oreon->serviceGroups as $svg)	{
						if (isset($svg) && $svg->get_activate())		{
							$status_s = array("OK" => 0, "PENDING" => 0, "WARNING" => 0, "CRITICAL" => 0, "UNKNOWN" => 0);
							print "<tr bgcolor='#E9E9E9'><td>&nbsp;<a href='./phpradmin.php?p=303&service_group=".$svg->get_id()."' class='text9b'>".$svg->get_name()."</a> (".$svg->get_alias().") </td><td align='center'>";
							$oreon->emulServiceGroupServices($svg);
							foreach ($svg->servicesEmul as $service){
								if ($service->get_register() && isset($Logs->log_h[$oreon->hosts[$service->get_host()]->get_id()]) && isset($Logs->log_h[$oreon->hosts[$service->get_host()]->get_id()]->log_s[$service->get_id()]) )
									$status_s[$Logs->log_h[$oreon->hosts[$service->get_host()]->get_id()]->log_s[$service->get_id()]->get_status()]++;
								unset($service);
							}	
							foreach ($status_s as $key => $stt)
								if ($stt)
									print "<font color='424242' class='miniStatus".$key."'>".$stt." ".$key."</font>&nbsp;";
							print '</td></tr>';	
						}
						unset($svg);
					}	
				?>
			</table>
		</td>
	</tr>
</table>