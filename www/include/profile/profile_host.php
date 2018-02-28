<?
/**
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Jean Baptiste Gouret - Julien Mathis - Romain Le Merlus - Christophe Coraboeuf

The Software is provided to you AS IS and WITH ALL FAULTS.
OREON makes no representation and gives no warranty whatsoever,
whether express or implied, and without limitation, with regard to the quality,
safety, contents, performance, merchantability, non-infringement or suitability for
any particular or intended purpose of the Software found on the OREON web site.
In no event will OREON be liable for any direct, indirect, punitive, special,
incidental or consequential damages however they may arise and even if OREON has
been previously advised of the possibility of such damages.

For information : contact@oreon.org
*/
	if (!isset($oreon))
		exit();

$hosts = & $oreon->hosts;
if (!isset($oreon->profileHosts))
	$oreon->loadProfileHosts();

if (isset($_GET["host_host_id"]))	{
	$host_id = $_GET["host_host_id"];
	$update = false;
	if (isset($_GET["update"]))
		$update = true;
	else	{
		if (!isset($oreon->profileHosts[$host_id]))
			$update = true;
		else
			$ph = $oreon->profileHosts[$host_id];
	}
	if ($update)	{
	    $timeout = 30 * 1000;
	    $retries = 5;
	    $ph = new ProfileHost($host_id);
	    $contact =  @snmpget($hosts[$host_id]->get_address(), $oreon->optGen->get_snmp_community(), ".1.3.6.1.2.1.1.4.0", $timeout , $retries)  ;
	    if ($contact) {
		    $ph->set_contact( str_replace( "STRING: ", '', $contact) );
		    $ph->set_location( str_replace( "STRING: ", '', @snmpget($hosts[$host_id]->get_address(), $oreon->optGen->get_snmp_community(), ".1.3.6.1.2.1.1.6.0" , $timeout , $retries )));
		    $ph->set_os(str_replace( "STRING: ", '', @snmpget($hosts[$host_id]->get_address(), $oreon->optGen->get_snmp_community(), ".1.3.6.1.2.1.1.1.0" , $timeout , $retries)));
		    $ph->set_uptime(str_replace( "Timeticks: ", '', @snmpget($hosts[$host_id]->get_address(), $oreon->optGen->get_snmp_community(), ".1.3.6.1.2.1.1.3.0" , $timeout , $retries )));
		    $nb_interface = str_replace( "INTEGER: ", '', @snmpget($hosts[$host_id]->get_address(), $oreon->optGen->get_snmp_community(), ".1.3.6.1.2.1.2.1.0" , $timeout , $retries ));
		    $index = str_replace( "INTEGER: ", '', @snmpwalk($hosts[$host_id]->get_address(), $oreon->optGen->get_snmp_community(), ".1.3.6.1.2.1.2.2.1.1" , $timeout , $retries ));
		    $interfaces =  @snmpwalk($hosts[$host_id]->get_address(), $oreon->optGen->get_snmp_community(), ".1.3.6.1.2.1.4.20.1.2" , $timeout , $retries );
		    $ip_addresses =  @snmpwalk($hosts[$host_id]->get_address(), $oreon->optGen->get_snmp_community(), ".1.3.6.1.2.1.4.20.1.1" , $timeout , $retries );
		    $i=0;
		    if ($interfaces ) {
				foreach ($interfaces as $interface ) {
					$array_int[$i++] = str_replace( "INTEGER: ", '', $interface);
				}
		    }
		    $i=0;
		    if ($interfaces ) {
				foreach ($ip_addresses  as $ip_addresse ) {
					$array_ip[$i++] = str_replace( "IpAddress: ", '', $ip_addresse);
				}
		    }
		    $len =  $nb_interface;
		    for ($k = 0; $k < $len; $k++)	{
		    	if (isset($array_int[$k]) && isset($array_ip[$k]))
					$array[$array_int[$k]] = $array_ip[$k];
		    }

		    for ($k = 0; $k < $len; $k++)		{
			    $ni["pi_id"] = $k;
			    $ni["host_host_id"] = $host_id;
			    $modele =  @snmpget($hosts[$host_id]->get_address(), $oreon->optGen->get_snmp_community(), ".1.3.6.1.2.1.2.2.1.2.$index[$k]" , $timeout , $retries );
			    $modele = trim($modele);
			    $modele = str_replace( "STRING: ", '',$modele);
			    if (stristr($modele,"Hex: ") ) {
					$modele = str_replace( "Hex: ", '', $modele);
					$modele = str_replace( "\n", ' ', $modele);
					$modele = str_replace( chr(0), ' ', $modele);
					$modele_hex = explode(" ", $modele );
					$modele  ='';
					foreach ($modele_hex  as $modele_hex_char ) {
						if (hexdec($modele_hex_char) >= 20 )
							$modele .=chr(hexdec($modele_hex_char));
					}
			    }
			    $ni["pi_model"] = $modele;

			    $f =  $index[$k] ;
			    if (isset($array[$f]))
				    $ni["pi_ip"] = $array[$f];
			    $speed = str_replace( "Gauge32: ", '', @snmpget($hosts[$host_id]->get_address(), $oreon->optGen->get_snmp_community(), ".1.3.6.1.2.1.2.2.1.5.$index[$k]" , $timeout , $retries ));
			    $speed = $speed / 1000000;
			    $ni["pi_speed"] = $speed;
			    $mac =  str_replace( "STRING: ", '', @snmpget($hosts[$host_id]->get_address(), $oreon->optGen->get_snmp_community(), ".1.3.6.1.2.1.2.2.1.6.$index[$k]" , $timeout , $retries ));
			    $mac = str_replace( "Hex: ", '', $mac);
			    $ni["pi_mac"] = $mac;
			    $ph->netInterfaces[$k] = new NetInterface($ni);
			    }
		    $ph->set_ram( str_replace( "INTEGER: ", '', @snmpget($hosts[$host_id]->get_address(), $oreon->optGen->get_snmp_community(), ".1.3.6.1.2.1.25.2.2.0" , $timeout , $retries )));
		    $disk_index =  str_replace( "INTEGER: ", '', @snmpwalk($hosts[$host_id]->get_address(), $oreon->optGen->get_snmp_community(), ".1.3.6.1.2.1.25.2.3.1.1" , $timeout , $retries ));
		    $j = 0;
		    if ($disk_index) {
			while ($j < count($disk_index))	{
				$dk["pdisk_id"] = -1;
				$dk["host_host_id"] = $host_id;
				$part[$j] = str_replace( "STRING: ", '', @snmpget($hosts[$host_id]->get_address(), $oreon->optGen->get_snmp_community(), ".1.3.6.1.2.1.25.2.3.1.3.$disk_index[$j]" , $timeout , $retries ));
				$block[$j] = str_replace( "INTEGER: ", '', @snmpget($hosts[$host_id]->get_address(), $oreon->optGen->get_snmp_community(), ".1.3.6.1.2.1.25.2.3.1.4.$disk_index[$j]" , $timeout , $retries ));
				$size[$j] = str_replace( "INTEGER: ", '', @snmpget($hosts[$host_id]->get_address(), $oreon->optGen->get_snmp_community(), ".1.3.6.1.2.1.25.2.3.1.5.$disk_index[$j]" , $timeout , $retries ));
				$space_used[$j] = str_replace( "INTEGER: ", '', @snmpget($hosts[$host_id]->get_address(), $oreon->optGen->get_snmp_community(), ".1.3.6.1.2.1.25.2.3.1.6.$disk_index[$j]" , $timeout , $retries ));
				$size[$j] = round ($size[$j] * $block[$j] / 1073741824, 2);
				$space_used[$j] = round ($space_used[$j] * $block[$j] / 1073741824, 2);
				$partition = $part[$j];
				// save new information about disk in DB
				$space_free = $size[$j] - $space_used[$j];

				$dk["pdisk_name"] = $partition;
				$dk["pdisk_space"] = $size[$j];
				$dk["pdisk_used_space"] = $space_used[$j];
				$dk["pdisk_free_space"] = $space_free;
				$ph->disks[$j-1] = new Disk($dk);
				$j++;
			}
		    }
		    $soft = str_replace( "STRING: ", '', @snmpwalk($hosts[$host_id]->get_address(), $oreon->optGen->get_snmp_community(), ".1.3.6.1.2.1.25.6.3.1.2" , $timeout , $retries ));
		    if (isset($soft))	{
			    $ph->softwares = array();
			    $ph->softwaresUP = array();
			    for ($s = 0; isset ($soft[$s]); $s++) {
				    if (strcmp($soft[$s], "")) {
					    if  ( !stristr($soft[$s], "Hex-") &&  !stristr($soft[$s], "Windows ") && (!stristr($soft[$s], " - KB"))) {
						    $soft_tab = split ("\"", $soft[$s]);
						    $ph->softwares[$s] = $soft_tab[1];}

					    if   ( (!stristr($soft[$s], "Hex-")) &&  stristr($soft[$s], "Correctif") && (stristr($soft[$s], "KB"))){
						    $soft_tab = split ("\"", $soft[$s]);
						    $ph->softwaresUP[$s] = $soft_tab[1];}

				    }
			    }
			    sort($ph->softwares);
			    sort($ph->softwaresUP);
		    }
		    $soft = NULL;

		$ph->set_update(time());
		$oreon->saveProfileHost($ph);
	    } else {
		$msg = $lang['profile_error_snmp'];
	    }
	}
}
?>
	<table align="left">
		<tr>
			<td align="left" valign="top">
				<? if (isset($msg))
				    echo "<div class='msg' style='padding-bottom: 10px;' align='center'>".$msg."</div>"; ?>
				<form method="get" action="">
				<table cellpadding='0' cellspacing="0" width="200">
					<tr>
						<td>
							<table class="tabTableTitle" cellpadding='0' cellspacing="3" width="100%">
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['profile_h_list_host']; ?>&nbsp;&nbsp;</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>	
						<td class="tabTableForTab">
							<table align="left" border="0" width="200">
								<tr>	
									<td colspan="2" align="center">
										<select name="host_host_id" size="1">
											<?
											if (isset($hosts))
												foreach($hosts as $host)
													if ($host->get_register() && $oreon->is_accessible($host->get_id()))	{
														echo "<option value=".$host->get_id();
														if (isset($_GET["host_host_id"]) && $_GET["host_host_id"] == $host->get_id())
															echo " selected";
														echo ">".$host->get_name()."</option>";
												}
											?>
										</select>
									</td>
								</tr>
								<tr>
									<td style="white-space: nowrap;padding-left:10px;"><? echo $lang['profile_o_live_update']; ?>&nbsp;&nbsp;&nbsp;<input type="checkbox" name="update"></td>
								</tr>
								<tr>
									<td colspan="2" align="center">
										<input type="submit" value="OK">
										<input type="hidden" name="p" value="<? echo $_GET["p"]; ?>">
									</td>
								</tr>
								</form>
							</table>
						</td>
					</tr>
				</table>	
			</td>
			<? if (isset($host_id)) { ?>
			<td style="padding-top: 20px;">&nbsp;</td>
			<td>
				<table align="center" border="0" cellpadding="1" cellspacing="3" class="tabTableForTab" style="border-top: 1px solid #CCCCCC;padding-left:20px;">
					<tr>
						<td style="white-space: nowrap;"><? echo $lang['profile_h_name']; ?> : </td>
						<td  class="text10b"><? echo stripslashes($hosts[$host_id]->get_name()); ?></td>
					</tr>
					<tr>
						<td style="white-space: nowrap;"><? echo $lang['profile_h_location']; ?> : </td>
						<td  class="text10b"><? echo stripslashes($ph->get_location()); ?> &nbsp;</td>
					</tr>
					<tr>
						<td style="white-space: nowrap;"><? echo $lang['profile_h_contact']; ?> : </td>
						<td  class="text10b"><? echo stripslashes($ph->get_contact()); ?> &nbsp;</td>
					</tr>
					<tr>
						<td style="white-space: nowrap;" valign="top"><? echo $lang['profile_h_os']; ?> : </td>
						<td class="text10b"><? echo stripslashes($ph->get_os()); ?></td>
					</tr>
					<tr>
						<td style="white-space: nowrap;"><? echo $lang['profile_h_uptime']; ?> : </td>
						<td class="text10b"><? echo stripslashes($ph->get_uptime()); ?><br></td>
					</tr>
					<? if (isset($ph->netInterfaces)) { ?>
					<tr>
						<td valign='top' style="white-space: nowrap;"><? echo $lang['profile_h_interface']; ?> : </td>
						<td class="text10b">
							<table width='100%' border='0' align='left' cellpadding='2' cellspacing='3'>
							<? foreach ($ph->netInterfaces as $netInterface) {	?>
								<tr>
									<td colspan='3' bgcolor="#CCCCCC"><font class="text10b"><? echo stripslashes($netInterface->get_model()); ?> : </font><font class="text10"><? echo $netInterface->get_ip(); ?></font></td>
								</tr>
								<tr>
									<td width="20">&nbsp;</td>
									<td width='50'><? echo $lang['profile_h_speed']; ?> : </td>
									<td width='150' class="text10b"><? echo $netInterface->get_speed(); ?>  Mbps</td>
								</tr>
								<tr>
									<td width="20">&nbsp;</td>
									<td><? echo $lang['profile_h_mac']; ?></td>
									<td class="text10b"><? echo stripslashes($netInterface->get_mac()); ?></td>
								</tr>
							<? } ?>
							</table>
						</td>
					</tr>
					<? } ?>
					<tr>
						<td style="white-space: nowrap;"><? echo $lang['profile_h_ram']; ?> : </td>
						<td class="text10b"><? echo $ph->get_ram();?><br></td>
					</tr>
					<? if (isset($ph->disks))	{ ?>
					<tr>
						<td valign='top' style="white-space: nowrap;"><? echo $lang['profile_h_disk']; ?> : </td>
						<td class="text10b">
							<table width='420' border='0' bordercolor="#CCCCCC" align='left' cellpadding='1' cellspacing='0'>
								<tr bgcolor='#CCCCCC'>
									<td valign='middle' align="center" class="text10b" style="padding: 8px; white-space: nowrap;" width="270"><? echo $lang['profile_title_partition']; ?></td>
									<td valign='middle' align="center" class="text10b" style="padding: 8px; white-space: nowrap;" width="50"><? echo $lang['profile_title_size']; ?></td>
									<td valign='middle' align="center" class="text10b" style="padding: 8px; white-space: nowrap;" width="50"><? echo $lang['profile_title_used_space']; ?></td>
									<td valign='middle' align="center" class="text10b" style="padding: 8px; white-space: nowrap;" width="50"><? echo $lang['profile_title_free_space']; ?></td>
								</tr>
								<?	
								$i = 0;
								foreach ($ph->disks as $disk) {	
									if ($i % 2)
										$color = "#E0DCDC";
									else
										$color = "#E7E7E";	
								?>
								<tr>
									<td valign='top' align='left' class="text10b" style="white-space: nowrap;" bgcolor="<? print $color; ?>"><? echo $disk->get_name();?></td>
									<td valign='top' align='right' class="text10b" style="white-space: nowrap;" bgcolor="<? print $color; ?>"><? echo $disk->get_space();?> Go</td>
									<td valign='top' align='right' class="text10b" style="white-space: nowrap;" bgcolor="<? print $color; ?>"><? echo sprintf("%01.3f", $disk->get_used_space() ) ;?> Go</td>
									<td valign='top' align='right' class="text10b" style="white-space: nowrap;" bgcolor="<? print $color; ?>"><? echo sprintf("%01.3f", $disk->get_free_space() ) ;?> Go</td>
								</tr>
								<? $i++;} ?>
							</table>
						</td>
					</tr>
					<? } ?>
					<? if (isset($ph->softwares) && count($ph->softwares))	{ ?>
					<tr>
						<td valign="top" style="white-space: nowrap;"><? echo $lang['profile_h_software']; ?> : </td>
						<td class="text10b" align="center">
						    <table width='100%' border='0' align='center' cellpadding='0' cellspacing='0'>
							<tr>
							    <td valign="top">
								<select size='10'>
								    <?
									foreach ($ph->softwares as $soft)
									    echo "<option>". $soft ."</option>";
								    ?>
								</select>
							    </td>
							</tr>
						    </table>
						</td>
					</tr>
					<? } ?>
					<? if (isset($ph->softwaresUP) && count ($ph->softwaresUP))	{ ?>
					<tr>
						<td valign="top" style="white-space: nowrap;"><? echo $lang['profile_h_update']; ?> : </td>
						<td class="text10b" align="center">
						    <table width='100%' border='0' align='center' cellpadding='0' cellspacing='0'>
							<tr>
							    <td valign="top">
								<select size='10'>
								    <?
									foreach ($ph->softwaresUP as $softUp)
									    echo "<option>". $softUp ."</option>";
								    ?>
								</select>
							    </td>
							</tr>
						    </table>
						</td>
					</tr>
					<? } ?>
					<tr>
						<td valign="top" style="white-space: nowrap;"><? echo $lang['profile_o_live_update']; ?> : </td>
						<td class="text10b">
							<table width='100%' border='0' align='center' cellpadding='0' cellspacing='0'>
								<tr>
									<td><? echo date($lang["date_time_format"], $ph->get_update()); ?></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	<? } ?>
	</table>