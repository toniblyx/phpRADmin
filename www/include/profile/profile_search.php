<?
/*
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)
For information : toni@blyx.com
*/
	if (!isset($oreon))
		exit();

$hosts = & $oreon->hosts;
if (!isset($oreon->profileHosts))
	$oreon->loadProfileHosts();
$phs = & $oreon->profileHosts;
$phsResults = array();

if (isset($_POST["searchByIp"]))	{
	$ip = $_POST["ip"];
	preg_match(" /^([0-9]+|\*)$/", $ip[0], $ip1);
	preg_match(" /^([0-9]+|\*)$/", $ip[1], $ip2);
	preg_match(" /^([0-9]+|\*)$/", $ip[2], $ip3);
	preg_match(" /^([0-9]+|\*)$/", $ip[3], $ip4);
	if (isset($ip1[0]) && isset($ip2[0]) && isset($ip3[0]) && isset($ip4[0]))	{
		if (isset($phs))
			foreach ($phs as $ph)	{
				if (isset($ph->netInterfaces))
					foreach ($ph->netInterfaces as $netInterface)	{
						$netInterfaceIp = explode(".", $netInterface->get_ip());
						if (ip_match($ip, $netInterfaceIp))
							$phsResults[$ph->get_host()] = $ph->get_host();
						unset($netInterface);
					}
			unset($ph);
			}
	}
}

function ip_match($ip1, $ip2)	{
	if ($ip1[0] == '*')
		$f1 = true;
	else if ($ip1[0] == $ip2[0])
		$f1 = true;
	else
		$f1 = false;
	if ($ip1[1] == '*')
		$f2 = true;
	else if ($ip1[1] == $ip2[1])
		$f2 = true;
	else
		$f2 = false;
	if ($ip1[2] == '*')
		$f3 = true;
	else if ($ip1[2] == $ip2[2])
		$f3 = true;
	else
		$f3 = false;
	if ($ip1[3] == '*')
		$f4 = true;
	else if ($ip1[3] == $ip2[3])
		$f4 = true;
	else
		$f4 = false;
	if ($f1 && $f2 && $f3 && $f4)
		return true;
	else
		return false;

}

if (isset($_POST["searchByOs"]))	{
	$os = $_POST["os"];
	if (isset($phs))
		foreach ($phs as $ph)	{
			if (isset($ph->os)) {
				if (!strcmp($ph->get_os(), stripslashes($os)))
					$phsResults[$ph->get_host()] = $ph->get_host();
				}
			unset($ph);
		}
}

if (isset($_POST["searchBySoft"]))	{
	$soft = $_POST["soft"];
	if (isset($phs))
		foreach ($phs as $ph)	{
			if (isset($ph->softwares)) {
				foreach ($ph->softwares as $software) {
					if (!strcmp($software, $soft))
						$phsResults[$ph->get_host()] = $ph->get_host();
					}
				}
			unset($ph);
		}
}

if (isset($_POST["searchBySoftUp"]))	{
	$softUp = $_POST["softUp"];
	if (isset($phs))
		foreach ($phs as $ph)	{
			if (isset($ph->softwaresUP))	{
				foreach ($ph->softwaresUP as $softwareUP) {
					if (!strcmp($softwareUP, $softUp))
						$phsResults[$ph->get_host()] = $ph->get_host();
					}
				}
			}
			unset($ph);
		}
?>
	<table border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td class="tabTableTitle"><? echo $lang['profile_s_os']; ?></td>
		</tr>
		<tr>
			<td class="tabTableForTab">
				<form method='post'>
     			 <table border="0" cellpadding="0" cellspacing="0" style="padding-top: 10px;">
					<tr>
          				<td align="center">
							<?
							$searchOs = array();
							if (isset($phs))
								foreach($phs as $ph)	{
									if ($ph->get_os() && !array_key_exists($ph->get_os(), $searchOs))
										$searchOs[$ph->get_os()] = $ph->get_os();
									unset ($ph);
								}
							sort($searchOs);
							?>
							<select name="os">
								<option value=''></option>
								<?
									if (isset($searchOs))
										foreach($searchOs as $sOs)	{
											echo "<option value='".$sOs."'>";
											printf("%.60s", stripslashes($sOs));
											echo "</option>\n";
											unset ($sOs);
										}
								?>
							</select>
						</td>
          				<td align="center">
							<div align="center" style="padding: 8px;">
								<input type="submit" name="searchByOs" value="<? echo $lang['profile_s_submit']; ?>">
							</div>
						</td>
        			</tr>
       			</table>
				</form>
			</td>
		</tr>
		<tr>
			<td style="padding-left: 20px;">&nbsp;</td>
		</tr>
		<tr>
			<td class="tabTableTitle"><? echo $lang['profile_s_update'];?></td>
		</tr>
		<tr>				
			<td class="tabTableForTab">
			<form method='post'>
     			<table width="500" border="0" align="center" cellpadding="0" cellspacing="0" style="padding-top: 10px;">
       				<tr>
         				<td align="center">
							<?
							$searchSoftUp = array();
							if (isset($phs))
								foreach($phs as $ph)	{
									if (isset($ph->softwaresUP))
										foreach($ph->softwaresUP as $soft)	{
											if (!array_key_exists($soft, $searchSoftUp))
												$searchSoftUp[$soft] = $soft;
											unset($soft);
										}
									unset($ph);
								}
							sort($searchSoftUp);
							?>
							<select name="softUp">
								<option value=''></option>
							<?
							foreach($searchSoftUp as $sSoftUp)	{
								echo "<option value='". $sSoftUp ."'>". stripslashes($sSoftUp) ."</option>";
								unset($sSoftUp);
							}
							?>
							</select>
						</td>
		  				<td align="center">
							<div align="center" style="padding: 8px;">
								<input type="submit" name="searchBySoftUp" value="<? echo $lang['profile_s_submit']; ?>">
							</div>
						</td>
        			</tr>
      			</table>
				</form>
			</td>
		</tr>
		<tr>
			<td style="padding-left: 20px;">&nbsp;</td>
		</tr>
		<tr>
			<td valign="top" class="tabTableTitle">
					<? echo $lang['profile_s_network']; ?>
			</td>
		</tr>
		<tr>
			<td class="tabTableForTab">
				<form method='post'>
     			 <table width="500" border="0" align="center" cellpadding="0" cellspacing="0" style="padding-top: 10px;">
					<tr>
          				<td align="center">IP&nbsp;&nbsp;</td>
          				<td align="center">
							<input name="ip[0]" size="4" maxlength="3">.
							<input name="ip[1]" size="4" maxlength="3">.
							<input name="ip[2]" size="4" maxlength="3">.
							<input name="ip[3]" size="4" maxlength="3">
						</td>
          				<td align="center" style="padding: 8px;">
							<div align="center"><input type="submit" name="searchByIp" value="<? echo $lang['profile_s_submit']; ?>"></div>
						</td>
        			</tr>
       			</table>
				</form>
			</td>
		</tr>
		<tr>
			<td style="padding-left: 20px;">&nbsp;</td>
		</tr>
		<tr>
			<td class="tabTableTitle"><? echo $lang['profile_s_software'];?></td>
		</tr>
		<tr>
			<td class="tabTableForTab">
				<form method='post'>
				<table width="500" border="0" align="center" cellpadding="0" cellspacing="0" style="padding-top: 10px;">
        			<tr>
         				<td align="center">
							<?
							$searchSoft = array();
							if (isset($phs))
								foreach($phs as $ph)	{
									if (isset($ph->softwares))
										foreach($ph->softwares as $soft)	{
											if (!array_key_exists($soft, $searchSoft))
												$searchSoft[$soft] = $soft;
											unset ($soft);
										}
									unset ($ph);
								}
							sort($searchSoft);
							?>
							<select name="soft">
							<?
							foreach($searchSoft as $sSoft)
								echo "<option value='". $sSoft ."'>". stripslashes($sSoft) ."</option>";
							?>
							</select>
						</td>
		  				<td align="center">
							<div align="center" style="padding: 8px;">
								<input type="submit" name="searchBySoft" value="<? echo $lang['profile_s_submit']; ?>">
							</div>
						</td>
        			</tr>
      			</table>
				</form>
			</td>
  		</tr>
		<tr>
			<td style="padding-left: 20px;">&nbsp;</td>
		</tr>
		<? if (count($phsResults) && isset($_POST["searchByIp"])) { ?>
		<tr>
			<td valign="top" style="padding-top: 20px; padding-bottom: 20px;" colspan="3" align="center">
			<table cellpadding="0" cellspacing="0" width="450">
				<tr>
					<td class="tabTableTitle"><? echo $lang['profile_search_results'] . " '". $_POST["ip"][0] . "." . $_POST["ip"][1] . "." . $_POST["ip"][2] . "." . $_POST["ip"][3] ."'" ; ?></td>
				</tr>
				<tr>
					<td class="tabTableForTab">
					<table align="center" cellpadding="3" cellspacing="3">	
						<?
							if (isset($phsResults))
								foreach ($phsResults as $phsResult)	{
									if ($oreon->is_accessible($phsResult))	{
										echo "<tr>";
										echo "<td>".$hosts[$phsResult]->get_name()."</td>";
										echo "<td>".$hosts[$phsResult]->get_address()."</td>";
										echo "<td><a href='phpradmin.php?p=302&host_host_id=".$phsResult."' class='text10b'>".$lang['profile_menu_options']."</a>"."&nbsp;&nbsp;<a href='phpradmin.php?o=w&p=102&h=".$phsResult."' class='text10b'>".$lang['h']."</a></td>";
										echo "</tr>";
									}
									unset($phsResult);
								}
							?>
						</table>
					</td>
				</tr>
			</table>
			</td>
		</tr>
		<? } ?>
		<? if (count($phsResults) && isset($_POST["searchBySoft"])) { ?>
		<tr>
			<td valign="top" style="padding-top: 20px; padding-bottom: 20px;" colspan="3" align="center">
			<table cellpadding="0" cellspacing="0" width="450">
				<tr>
					<td class="tabTableTitle"><? echo $lang['profile_search_results'] . " '". stripslashes($_POST["soft"]). "'"; ?></td>
				</tr>
				<tr>
					<td class="tabTableForTab">
					<table align="center" cellpadding="3" cellspacing="3">	
						<?
						if (isset($phsResults))
							foreach ($phsResults as $phsResult)	{
								if ($oreon->is_accessible($phsResult))	{
									echo "<tr>";
									echo "<td>".$hosts[$phsResult]->get_name()."</td>";
									echo "<td>".$hosts[$phsResult]->get_address()."</td>";
									echo "<td><a href='phpradmin.php?p=302&host_host_id=".$phsResult."' class='text10b'>".$lang['profile_menu_options']."</a>"."&nbsp;&nbsp;<a href='phpradmin.php?o=w&p=102&h=".$phsResult."' class='text10b'>".$lang['h']."</a></td>";
									echo "</tr>";
								}
								unset($phsResult);
							}
						?>
						</table>
					</td>
				</tr>
			</table>
			</td>
		</tr>
		<? } ?>

		<? if (count($phsResults) && isset($_POST["searchByOs"])) { ?>
		<tr>
			<td valign="top" style="padding-top: 20px; padding-bottom: 20px;" colspan="3" align="center">
			<table cellpadding="0" cellspacing="0" width="450">
				<tr>
					<td class="tabTableTitle"><? echo $lang['profile_search_results'] . " '". stripslashes($_POST["os"]). "'" ; ?></td>
				</tr>
				<tr>
					<td class="tabTableForTab">
					<table align="center" cellpadding="3" cellspacing="3">	
						<?
							if (isset($phsResults))
								foreach ($phsResults as $phsResult)	{
									if ($oreon->is_accessible($phsResult)){
										echo "<tr>";
										echo "<td>".$hosts[$phsResult]->get_name()."</td>";
										echo "<td>".$hosts[$phsResult]->get_address()."</td>";
										echo "<td><a href='phpradmin.php?p=302&host_host_id=".$phsResult."' class='text10b'>".$lang['profile_menu_options']."</a>"."&nbsp;&nbsp;<a href='phpradmin.php?o=w&p=102&h=".$phsResult."' class='text10b'>".$lang['h']."</a></td>";
										echo "</tr>";
									}
									unset($phsResult);
								}
						?>
						</table>
					</td>
				</tr>
			</table>
			</td>
		</tr>
		<? } 
		 if (count($phsResults) && isset($_POST["searchBySoftUp"])) { ?>
		<tr>
			<td valign="top" style="padding-top: 20px; padding-bottom: 20px;" colspan="3" align="center">
			<table cellpadding="0" cellspacing="0" width="450">
				<tr>
					<td class="tabTableTitle"><? echo $lang['profile_search_results'] . " '".stripslashes($_POST["softUp"]) . "'" ; ?></td>
				</tr>
				<tr>
					<td class="tabTableForTab">
					<table align="center" cellpadding="3" cellspacing="3">	
						<?
							if (isset($phsResults))
								foreach ($phsResults as $phsResult)	{
									if ($oreon->is_accessible($phsResult))	{
										echo "<tr>";
										echo "<td>".$hosts[$phsResult]->get_name()."</td>";
										echo "<td>".$hosts[$phsResult]->get_address()."</td>";
										echo "<td><a href='phpradmin.php?p=302&host_host_id=".$phsResult."' class='text10b'>".$lang['profile_menu_options']."</a>"."&nbsp;&nbsp;<a href='phpradmin.php?o=w&p=102&h=".$phsResult."' class='text10b'>".$lang['h']."</a></td>";
										echo "</tr>";
									}
									unset($phsResult);
								}
						?>
						</table>
					</td>
				</tr>
			</table>
			</td>
		</tr>
		<? } ?>
	</table>