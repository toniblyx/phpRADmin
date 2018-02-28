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
	$services = & $oreon->services;
	$graphs = & $oreon->graphs;
	$commands = & $oreon->commands;
	$stms = & $oreon->stms;
	
	if (isset($_POST["duplicateHost"]) && isset($_POST["dup_host"]))	{
		$msg = NULL;
		if (isset($_POST["dup_host"]) && isset($_POST["nbr_host"]))	{
			for ($i = 1; $i <= $_POST["nbr_host"]; $i++)	{
				$defAlias = false;
				$defAddress = false;
				$host_dup = $hosts[$_POST["dup_host"]];
				$host = $_POST["host_$i"];
				$host_dup->set_id(-1);
				$host_dup->set_name(str_replace(" ", "_", $host["host_name"]));
				if (isset($host["host_alias"]) && $host["host_alias"])	{
					$host_dup->set_alias(str_replace(" ", "_", $host["host_alias"]));
					$defAlias = true;
				}
				else if (isset($host["host_alias"]) && !$host["host_alias"])
					$defAlias = false;
				else if ($host_dup->get_host_template() && $hosts[$host_dup->get_host_template()]->get_alias())
					$defAlias= true;
				if (isset($host["host_address"]) && $host["host_address"])	{
					$host_dup->set_address($host["host_address"]);
					$defAddress = true;
				}
				else if (isset($host["host_address"]) && !$host["host_address"])
					$defAddress = false;
				else if ($host_dup->get_host_template() && $hosts[$host_dup->get_host_template()]->get_address())
					$defAddress= true;						
				if ($host_dup->get_name() && $defAddress && $defAlias && $host_dup->twiceTest($hosts))	{
					system("echo \"[" . time() . "] AddHost;" . $host_dup->get_name() . ";" . $oreon->user->get_alias() . "\" >> ./include/log/" . date("Ymd") . ".txt");
					$oreon->saveHost($host_dup);
					$host_id = $oreon->database->database->get_last_id();
					$host_dup->set_id($host_id);
					$hosts[$host_id] = $host_dup;
					$oreon->saveHost($hosts[$host_id]);
					if (isset($hosts[$host_id]->services))
						foreach ($hosts[$host_id]->services as $service)	{
							$service_dup = $services[$service->get_id()];
							$service_dup->set_id(-1);
							$service_dup->set_host($host_id);
							$oreon->saveService($service_dup);
							$service_dup_id = $oreon->database->database->get_last_id();
							$service_dup->set_id($service_dup_id);
							$services[$service_dup_id] = $service_dup;
							$dup_graph = false;
							if ($service_dup->get_service_template())	{ // Service Template case
								if ($service_dup->get_check_command() && strstr($commands[$service_dup->get_check_command()]->get_name(), "check_graph"))	{
									$services[$service_dup_id]->set_check_command_arg(preg_replace("/(\![0-9]+)$/", "!".$service_dup_id, $service_dup->get_check_command_arg()));
									$dup_graph = true;
								}
								else if ($services[$service_dup->get_service_template()]->get_check_command() && strstr($commands[$services[$service_dup->get_service_template()]->get_check_command()]->get_name(), "check_graph"))	{
									$services[$service_dup_id]->set_check_command_arg(preg_replace("/(\![0-9]+)$/", "!".$service_dup_id, $service_dup->get_check_command_arg()));
									$dup_graph = true;
								}
							} else if (strstr($commands[$service_dup->get_check_command()]->get_name(), "check_graph"))	{
									$services[$service_dup_id]->set_check_command_arg(preg_replace("/(\![0-9]+)$/", "!".$service_dup_id, $service_dup->get_check_command_arg()));
									$dup_graph = true;
								}
							// Duplicate Graph for special service which name begin by "check_graph".. horrible isn't it ?
							if ($dup_graph)	{
								$graph_dup = $graphs[$service->get_id()];
								$graph_dup->set_id($service_dup_id);
								$graph_dup->set_host($host_id);
								$oreon->saveGraph($graph_dup);
								$graphs[$service_dup_id] = $graph_dup;
							}
							$oreon->saveService($services[$service_dup_id]);
							unset($hosts[$host_id]->services[$service->get_id()]);
							unset($service);
							unset ($_POST["o"]);
						}
						$msg .= $host_dup->get_name(). " : ".$lang['errCode'][3]."<br>";						
				}
				else	{
					if ($host_dup->get_name())
						$msg .= $host_dup->get_name(). " : ".$lang['errCode'][-2]."<br>";
					else if ($host_dup->get_alias())
						$msg .= $host_dup->get_alias(). " : ".$lang['errCode'][-2]."<br>";
					else if ($host_dup->get_address())
						$msg .= $host_dup->get_address(). " : ".$lang['errCode'][-2]."<br>";
					else
						$msg .= $lang['errCode'][-2]."<br>";
				}
				unset($host_dup);
			}
		}
		else	{
			$msg = $lang['errCode'][$command_object->get_errCode()];
			unset ($_POST["o"]);
		}
	}
	
	//------------------------------------
	// Initialise YES NO or NOTHING Value
	
		$value_flag["1"] = "YES";
		$value_flag["0"] = "NO";
		$value_flag["2"] = "NOTHING";	

	// -----------------------------------
	function write_host_list_dup($hosts, $lang, $nbr_host = -1, $dup_host = -1)	{?>
		 <table cellpadding="0" cellspacing="0">
		 	<tr>
		 		<td class='tabTableTitle'>
			 	<? echo "<div style='white-space: nowrap;' class='text11b'>".$lang['h_available']."</div>" ; ?>
				</td>
			</tr>
			<tr>
				<td class='tabTable' style="padding-top: 7px;">
				<form action="" method="post">
				<? 
					$flg = 0;
					if (isset($hosts) && count($hosts) != 0)
						foreach ($hosts as $h)	{
							if ($h->get_register())	{ ?>
								<div align="left" style="padding: 0; white-space: nowrap;">
									<input type="radio" name="dup_host" value="<? echo $h->get_id(); ?>" <? if(!$flg && $dup_host == -1) { echo "checked"; $flg++; } ?> <? if ($dup_host == $h->get_id()) echo "checked"; ?>>&nbsp;&nbsp;
									<a href="phpradmin.php?p=102&h=<? echo $h->get_id(); ?>&o=w" class="text10" title="<? echo $h->get_alias(); ?> / <? echo $h->get_address(); ?>" <? if(!$h->get_activate()) echo "style='text-decoration: line-through;'"; ?>>
										<? echo $h->get_name(); ?>
									</a>
								</div>
					<?  } unset($h); } ?>
					<div style="padding: 5px; text-align: center; white-space: nowrap;">
						<? echo $lang['h_nbr_dup']; ?>
						<select name="nbr_host">
							<? for ($i = 1; $i <= 150; $i++)	{
									echo "<option value='$i'";
									if ($i == $nbr_host)
										echo " selected";
									echo ">$i</option>\n";
								}
							?>
						</select>
					</div>
					<div style="padding: 10px; text-align: center;">
						<input type="hidden" name="o" value="dup">
						<input type="submit" value="<? echo $lang['dup'] ?>" id="submit">
					</div>
				</form>
				</td>
			</tr>
		</table><? 	
	}


if (!isset($_POST["o"]))	{ ?>	
	<table border="0" align="left">
		<? if (isset($msg))	{ ?>
		<tr>
			<td><div style='padding-bottom: 10px;' class='msg' align='center'><? echo $msg; ?></div></td>
		</tr>
		<? } ?>
		<tr>
		  	<td valign="top" align="left">
				<? 
				if (isset($_GET["h"]))
					$host = $_GET["h"];
				else
					$host = -1;
				write_host_list_dup($hosts, $lang, -1, $host);
				?>
		  	</td>
		</tr>
	</table>
<? } if (isset($_POST["o"]) && !strcmp($_POST["o"], "dup"))	{	?>
	<table align="left" border="0">
		<tr>
			<td valign="top" align="left"><? write_host_list_dup($hosts, $lang, $_POST["nbr_host"], $_POST["dup_host"]); ?></td>
			<td style="padding-left: 20px;"></td>
			<td valign="top" align="left">			 	
				<? if (isset($msg))
						echo "<div style='padding-bottom: 10px;' class='msg' align='center'>$msg</div>";?>
				<form action="" method="post">
				<? for ($i = 1; $i <= $_POST["nbr_host"]; $i++)	{ ?>
				<table style="padding: 4px;margin-top:10px;" class="tabTable2">
					<tr>
						<td style="white-space: nowrap;"><? echo $lang['name'];?> <font color='red'>*</font></td>
						<td><input type="text" name="host_<? echo $i; ?>[host_name]" value="<? echo $hosts[$_POST["dup_host"]]->get_name()."_".$i; ?>"></td>
					</tr>
					<tr>
						<td style="white-space: nowrap;"><? echo $lang['alias'];?> <font color='red'>*</font></td>
						<td>
							<?
							$alias = NULL;
							$alias_temp = NULL;
							$alias = $hosts[$_POST["dup_host"]]->get_alias();
							if ($hosts[$_POST["dup_host"]]->get_host_template())
								$alias_temp = $hosts[$hosts[$_POST["dup_host"]]->get_host_template()]->get_alias();
							if ($hosts[$_POST["dup_host"]]->get_host_template())	{ ?>
								<input type="checkbox" onClick="enabledTemplateField(this.form.templateAlias<? echo $i; ?>, '<? echo $alias_temp; ?>', '<? echo $alias; ?>');" <? if ($alias) echo "checked"; ?>>
							<? } ?>
							<input type="text" name="host_<? echo $i; ?>[host_alias]" id="templateAlias<? echo $i; ?>" value="<? if ($alias) echo $alias; else echo $alias_temp; ?>" <? if ($hosts[$_POST["dup_host"]]->get_host_template() && (($alias_temp && !$alias) || (!$alias_temp && !$alias))) echo "disabled";?>>

						</td>
					</tr>
					<tr>
						<td style="white-space: nowrap;">Address <font color='red'>*</font></td>
						<td>
							<?
							$address = NULL;
							$address_temp = NULL;
							$address = $hosts[$_POST["dup_host"]]->get_address();
							if ($hosts[$_POST["dup_host"]]->get_host_template())
								$address_temp = $hosts[$hosts[$_POST["dup_host"]]->get_host_template()]->get_address();
							if ($hosts[$_POST["dup_host"]]->get_host_template())	{ ?>
								<input type="checkbox" onClick="enabledTemplateField(this.form.templateAddress<? echo $i; ?>, '<? echo $address_temp; ?>', '<? echo $address; ?>');" <? if ($address) echo "checked"; ?>>
							<? } ?>
								<input type="text" name="host_<? echo $i; ?>[host_address]" id="templateAddress<? echo $i; ?>" value="<? if ($address) echo $address; else echo $address_temp; ?>" <? if ($hosts[$_POST["dup_host"]]->get_host_template() && (($address_temp && !$address) || (!$address_temp && !$address))) echo "disabled";?>>
						</td>
					</tr>
				</table>
				<? } ?>
				<div style="padding: 10px; text-align: center;">
					<input type="hidden" name="nbr_host" value="<? echo $_POST["nbr_host"]; ?>">
					<input type="hidden" name="dup_host" value="<? echo $_POST["dup_host"]; ?>">
					<input type="submit" name="duplicateHost" value="<? echo $lang['dup'] ?>">
				</div>
				</form>				
			</td>
		</tr>
	</table>
<? } ?>	