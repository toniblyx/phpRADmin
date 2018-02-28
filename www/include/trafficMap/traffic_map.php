<?
/**
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Julien Mathis - Romain Le Merlus - Christophe Coraboeuf

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

	$msg = '';

	$tms = & $oreon->trafficMaps;
	if (isset($_GET) && array_key_exists("o", $_GET) && $_GET["o"] != "a")
		if (!isset($_GET["tm"]) || (isset($_GET["tm"]) && !array_key_exists($_GET["tm"], $tms)))	{
			include ("./footer.php");
			exit();
		}
	$hosts = & $oreon->hosts;
	$services = & $oreon->services;

	if (isset($_POST["addTM"]))	{
		$tm_array = & $_POST["tm"];
		$tm_array["tm_id"] = -1;
		$tm_array["tm_name"] = $tm_array["tm_name"];
		$tm_array["tm_date"] = time();
		$tm_array["tm_background"] = "";
		if (isset($_POST["x"]))
			$tm_array["tm_keyxpos"] = $_POST["x"];
		if (isset($_POST["y"]))
			$tm_array["tm_keyypos"] = $_POST["y"];
		if (!$tm_array["tm_width"])
			$tm_array["tm_width"] = 450;
		if (!$tm_array["tm_height"])
			$tm_array["tm_height"] = 400;
		$tm_object = new TrafficMap($tm_array);
		if ($tm_object->is_complete() && $tm_object->twiceTest($tms))	{
			// log Add
			system("echo \"[".time()."] AddTrafficMap;".$tm_array["tm_name"].";".$oreon->user->get_alias()."\" >>./include/log/".date("Ymd").".txt");
			$oreon->saveTrafficMap($tm_object);
			$tm_id = $oreon->database->database->get_last_id();
			if ($HTTP_POST_FILES["tm_background"])
				if (move_uploaded_file($HTTP_POST_FILES["tm_background"]["tmp_name"], "./include/trafficMap/bg/".$tm_id."BG.png"))
					$tms[$tm_id]->set_background("./include/trafficMap/bg/".$tm_id."BG.png");
			update_traffic_map ($tms, $tm_id, $hosts, $lang);
			$oreon->saveTrafficMap($tms[$tm_id]);
			$msg = $lang['tm_add'];
			unset($_GET["o"]);
		}	else
				$msg = $lang['uncomplete_form'];
		unset ($tm_object);
	}

	if (isset($_POST["changeTM"]))	{
		$tm_array = & $_POST["tm"];
		$tm_array["tm_name"] =  $tm_array["tm_name"];
		$tm_array["tm_date"] = $tms[$tm_array["tm_id"]]->get_dateTM();
		$tm_array["tm_background"] = "";
		if (isset($_POST["x"]))
			$tm_array["tm_keyxpos"] = $_POST["x"];
		if (isset($_POST["y"]))
			$tm_array["tm_keyypos"] = $_POST["y"];
		if (!$tm_array["tm_width"])
			$tm_array["tm_width"] = 450;
		if (!$tm_array["tm_height"])
			$tm_array["tm_height"] = 400;
		$tm_object = new TrafficMap($tm_array);
		$tm_object->TMHosts = & $tms[$tm_object->get_id()]->TMHosts;
		$tm_object->TMrelations = & $tms[$tm_object->get_id()]->TMrelations;
		if ($tm_object->is_complete() && $tm_object->twiceTest($tms))	{
			// log Add
			system("echo \"[".time()."] ChangeTrafficMap;".$tm_array["tm_name"].";".$oreon->user->get_alias()."\" >>./include/log/".date("Ymd").".txt");
			if ($HTTP_POST_FILES["tm_background"])
				if (move_uploaded_file($HTTP_POST_FILES["tm_background"]["tmp_name"], "./include/trafficMap/bg/".$tm_array["tm_id"]."BG.png"))
					$tm_object->set_background("./include/trafficMap/bg/".$tm_array["tm_id"]."BG.png");
			if (isset($tm_array["check_img"]))
				$tm_object->set_background(NULL);
			$oreon->saveTrafficMap($tm_object);
			$msg = $lang['tm_modify'];
			$_GET["o"] = 'w';
		}
		else
			$msg = $lang['uncomplete_form'];
		unset ($tm_object);
	}

	if (isset($_POST["addTMR"]))	{
		$tmr_array = & $_POST["tmr"];
		$tmr_array["tmhr_id"] = -1;
		$tmr_obj = new trafficMapRelation($tmr_array);
		if ($tmr_obj->isComplete() && $tmr_obj->twiceTest($tms))	{
			$oreon->saveTrafficMapHostRelation($tmr_obj);
			$tmr_id = $oreon->database->database->get_last_id();
			$tmr_obj->set_id($tmr_id);
			$tms[$tmr_array["trafficMap_tm_id"]]->TMrelations[$tmr_id] = $tmr_obj;
			$msg = $lang['tm_addRelation'];
		}
		else
			$msg = $lang['uncomplete_form'];
		unset ($tmr_object);
	}

	if (isset($_POST["changeTMR"]))	{
		$tmr_array = & $_POST["tmr"];
		$tmr_obj = new trafficMapRelation($tmr_array);
		if ($tmr_obj->isComplete() && $tmr_obj->twiceTest($tms))	{
			$oreon->saveTrafficMapHostRelation($tmr_obj);
			$tms[$tmr_array["trafficMap_tm_id"]]->TMrelations[$tmr_array["tmhr_id"]] = $tmr_obj;
			$msg = $lang['tm_changeRelation'];
			$_GET["o"] = "w";
			unset($_GET["tmr"]);
		}
		else
			$msg = $lang['uncomplete_form'];
		unset ($tmr_object);
	}

	if (isset($_POST["addTMHost"]))	{
		$tmh_array = & $_POST["tmh"];
		$tmh_array["tmh_label"] =  $tmh_array["tmh_label"];
		if (isset($_POST["x"]))
			$tmh_array["tmh_x"] = $_POST["x"];
		if (isset($_POST["y"]))
			$tmh_array["tmh_y"] = $_POST["y"];
		if ($tmh_array["host_host_id"] == "")
			$tmh_array["host_host_id"] = $tmh_array["host_host_id2"];
		if (!isset($tmh_array["service_service_id"]))
			$tmh_array["service_service_id"] = "";
		$tmh_array["tmh_id"] = -1;
		$tmh_object = new TrafficMapHost($tmh_array);
		if ($tmh_object->is_complete() && $tmh_object->twiceTest($tms[$tmh_array["trafficMap_tm_id"]]))	{
		// log Add
			system("echo \"[".time()."] AddTrafficMapHost;".$tmh_array["tmh_label"].";".$oreon->user->get_alias()."\" >>./include/log/".date("Ymd").".txt");
			$oreon->saveTrafficMapHost($tmh_object);
			$msg = $lang['tm_addHost'];
		}
		else
			$msg = $lang['uncomplete_form'];
		unset($tmh_object);
	}

	if (isset($_POST["changeTMHost"]))	{
		$tmh_array = & $_POST["tmh"];
		$tmh_array["tmh_label"] =  $tmh_array["tmh_label"];
		if (isset($_POST["x"]))
			$tmh_array["tmh_x"] = $_POST["x"];
		if (isset($_POST["y"]))
			$tmh_array["tmh_y"] = $_POST["y"];
		if (!isset($tmh_array["service_service_id"]))
			$tmh_array["service_service_id"] = "";
		$tmh_object = new TrafficMapHost($tmh_array);
		if ($tmh_object->is_complete() && $tmh_object->twiceTest($tms[$tmh_array["trafficMap_tm_id"]]))	{
		// log Add
			system("echo \"[".time()."] ChangeTrafficMapHost;".$tmh_array["tmh_label"].";".$oreon->user->get_alias()."\" >>./include/log/".date("Ymd").".txt");
			$oreon->saveTrafficMapHost($tmh_object);
			$msg = $lang['tm_changeHost'];
		}	else
				$msg = $lang['uncomplete_form'];
		unset($tmh_object);
	}

	if (isset($_GET["o"]) && !strcmp($_GET["o"], "d"))	{ // Delete traffic map in oreon object and in the database
		if (isset($_GET["TMHost"]) && isset($tms[$_GET["tm"]]->TMHosts[$_GET["TMHost"]]))	{
			$oreon->deleteTrafficMapHost($tms[$_GET["tm"]]->TMHosts[$_GET["TMHost"]]);
			$_GET["o"] = "w";
			unset($_GET["TMHost"]);
			$msg = $lang['tm_deleteHost'];
		}
		else if (isset($_GET["tmr"]))	{
			$oreon->deleteTrafficMapHostRelation($tms[$_GET["tm"]]->TMrelations[$_GET["tmr"]]);
			unset($_GET["tmr"]);
			$_GET["o"] = "w";
			$msg = $lang['tm_deleteRelation'];
		}
		else	{
			// log oreon
			system("echo \"[".time()."] DeleteTrafficMap;".$tms[$_GET["tm"]]->get_name().";".$oreon->user->get_alias()."\" >>./include/log/".date("Ymd").".txt");
			$oreon->deleteTrafficMap($tms[$_GET["tm"]]);
			unset($_GET["o"]);
			$msg = $lang['tm_delete'];
		}
	}

	if (isset($_GET["o"]) && !strcmp($_GET["o"], "u"))	{
		update_traffic_map($tms, $_GET["tm"], $hosts, $lang);
		$tms[$_GET["tm"]]->set_dateTM(time());
		$oreon->saveTrafficMap($tms[$_GET["tm"]]);
		$_GET["o"] = "w";
		$lang['tm_update'];
	}

	function update_traffic_map ($tms, $trafficMap_id, $hosts, $lang)	{
		global $msg;
		$filename = "./include/trafficMap/conf/trafficMap.conf".$trafficMap_id.".php";
		if (!$handle = fopen($filename, 'w')) {
			echo $lang['db_cannot_open'].$filename;
			exit;
		}
		if ($tms[$trafficMap_id]->get_background())
			$background = "BACKGROUND ".$tms[$trafficMap_id]->get_background()."\n\n";
		$keypos = "KEYPOS ".$tms[$trafficMap_id]->get_keyxpos()." ".$tms[$trafficMap_id]->get_keyypos()."\n\n";
		$width =  "WIDTH " .$tms[$trafficMap_id]->get_width()."\n\n";
		$height = "HEIGHT " .$tms[$trafficMap_id]->get_height()."\n\n";
		$scale = "#     low  high   red green blue\n";
		$scale.= "SCALE   1   10    140     0  255\n";
		$scale.= "SCALE  10   25     32    32  255\n";
		$scale.= "SCALE  25   40      0   192  255\n";
		$scale.= "SCALE  40   55      0   240    0\n";
		$scale.= "SCALE  55   70    240   240    0\n";
		$scale.= "SCALE  70   85    255   192    0\n";
		$scale.= "SCALE  85  100    255     0    0\n\n";

		if (isset($background))
			fwrite($handle, $background);
		fwrite($handle, $width);
		fwrite($handle, $height);
		fwrite($handle, $keypos);
		fwrite($handle, $scale);
		if (isset($tms[$trafficMap_id]->TMHosts))
			foreach ($tms[$trafficMap_id]->TMHosts as $TMHost)	{
				if ($TMHost->host != -1)
					$node = "NODE ". $hosts[$TMHost->get_host()]->get_name()."\n";
				else
					$node = "NODE ". $TMHost->get_label()."\n";
				$pos = "POSITION ".$TMHost->get_x()." ".$TMHost->get_y()."\n";
				$label = "LABEL ". $TMHost->get_label()."\n\n";
				fwrite($handle, $node);
				fwrite($handle, $pos);
				fwrite($handle, $label);
			}
		if (isset($tms[$trafficMap_id]->TMrelations))
			foreach ($tms[$trafficMap_id]->TMrelations as $relation)	{
				$link = "LINK ".$tms[$trafficMap_id]->TMHosts[$relation->get_TMHost1()]->get_label()."-".$tms[$trafficMap_id]->TMHosts[$relation->get_TMHost2()]->get_label()."\n";
				if ($tms[$trafficMap_id]->TMHosts[$relation->get_TMHost1()]->host != -1)
					$nodes = "NODES ". $hosts[$tms[$trafficMap_id]->TMHosts[$relation->get_TMHost1()]->get_host()]->get_name()." ";
				else
					$nodes = "NODES ". $tms[$trafficMap_id]->TMHosts[$relation->get_TMHost1()]->get_label()." ";
				if ($tms[$trafficMap_id]->TMHosts[$relation->get_TMHost2()]->host != -1)
					$nodes.=  $hosts[$tms[$trafficMap_id]->TMHosts[$relation->get_TMHost2()]->get_host()]->get_name()."\n";
				else
					$nodes.=  $tms[$trafficMap_id]->TMHosts[$relation->get_TMHost2()]->get_label()."\n";
				if ($tms[$trafficMap_id]->TMHosts[$relation->get_TMHost1()]->host != -1 && $tms[$trafficMap_id]->TMHosts[$relation->get_TMHost1()]->service)
					$target = "TARGET http://127.0.0.1/oreon/include/trafficMap/average/". $hosts[$tms[$trafficMap_id]->TMHosts[$relation->get_TMHost1()]->get_host()]->get_address()."_".$tms[$trafficMap_id]->TMHosts[$relation->get_TMHost1()]->get_service().".html\n";
				$bin = "BANDWIDTH_IN ".$relation->get_bin()."\n";
				$bout = "BANDWIDTH_OUT ".$relation->get_bout()."\n\n";
				fwrite($handle, $link);
				fwrite($handle, $nodes);
				fwrite($handle, $target);
				fwrite($handle, $bin);
				fwrite($handle, $bout);
			}
		fclose($handle);
		$msg = shell_exec('./include/trafficMap/trafficMap.pl '.$trafficMap_id.' '.$tms[$trafficMap_id]->get_width().' '.$tms[$trafficMap_id]->get_height().'  2>&1');
	}

	function write_trafficMap_list($tms, $lang)
	{
		?>
		<table cellpadding="0" cellspacing="0" width="150">
			<tr>
				<td class="tabTableTitleMenu"><? print $lang["m_options"]; ?></td>
			</tr>
			<tr>
				<td class="tabTableMenu">
					<div style="padding: 8px; text-align: center;">
						<img src="img/picto2.gif">
						<a href="phpradmin.php?p=313&o=a" class="text9"><? echo $lang['add']; ?></a>
						<img src="img/picto2_bis.gif">
					</div>
				</td>
			</tr>
		</table>
		<br>
		<table cellpadding="0" cellspacing="0" width="150">
			<tr>
				<td class="tabTableTitleMenu"><? echo $lang['tm_available'] ; ?></td>
			</tr>
			<tr>
				<td class="tabTableMenu">
				<?
				 if (isset($tms))
					foreach ($tms as $tm)	{ ?>
						<div style="padding: 2px; white-space: nowrap;" align="center"><a href="phpradmin.php?p=313&tm=<? echo $tm->get_id(); ?>&o=w" class="text10"><? echo $tm->get_name(); ?></a></div>
					<?  unset($tm); } ?>
				</td>
			</tr>
		</table>	
<?	} 
if (!isset($_GET["o"]))	{ // Without options ?>
	<table border="0" align="left" cellpadding="0" cellspacing="0">
		<tr>
	  		<td valign="top">
				<? write_trafficMap_list($tms, $lang); ?>
	  		</td>
	  		<td valign="top" width="300">
	  			<?
				if (isset($msg) && $msg)
					echo "<div align='center' class='msg'>$msg</div><br>";
				?>
			</td>
		</tr>
	</table>
<? } else if (isset($_GET["o"]))	{
		if (!strcmp($_GET["o"], "ch") || !strcmp($_GET["o"], "w") || !strcmp($_GET["o"], "r") || !strcmp($_GET["o"], "ah") || !strcmp($_GET["o"], "ra") || !strcmp($_GET["o"], "c"))
			$tm = $_GET["tm"]; ?>
	<table align="left" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td valign="top"><? write_trafficMap_list($tms, $lang); ?></td>
			<td style="padding-left:20px" width="20"></td>
			<td valign="top" align='center'>
			<?
				if (isset($msg) && $msg)
					echo "<div align='center' class='msg'>$msg</div><br>";
			?>
				<table border='0' align="center" cellpadding="0" cellspacing="0">
					<tr>
						<td align="center" valign="top" class="tabTableTitle">Traffic Map <? if ($_GET["o"] !="a") {  echo "\"".$tms[$tm]->get_name()."\"". " ".date("d/m/Y - H:i", $tms[$tm]->get_dateTM());} ?></td>
					</tr>
					<? if ($_GET["o"] != "a")	{ ?>
					<tr>
						<td align="center" style="padding-bottom: 10px;" class="tabTableForTab">
							<table align="center">
								<tr>
									<td align="center"><a href="phpradmin.php?p=313&o=ah&tm=<? echo $tm ?>" class="text10bc">[<? echo $lang['add']. " host"; ?>]</a></td>
									<td align="center"><a href="phpradmin.php?p=313&o=ra&tm=<? echo $tm ?>" class="text10bc">[<? echo $lang['add']. " relation"; ?>]</a></td>
									<td align="center"><a href="phpradmin.php?p=313&o=c&tm=<? echo $tm ?>" class="text10bc">[<? echo $lang['modify']; ?>]</a></td>
									<td align="center" valign="top" rowspan="2"><a href="phpradmin.php?p=313&o=u&tm=<? echo $tm ?>" class="text10bc" onclick="return confirm('<? echo $lang['confirm_update']; ?>')">[<? echo $lang["update"]; ?>]</a></td>
								</tr>
								<tr>
									<td align="center"><a href="phpradmin.php?p=313&o=ch&tm=<? echo $tm ?>" class="text10bc">[<? echo $lang['modify']. " hosts"; ?>]</a></td>
									<td align="center"><a href="phpradmin.php?p=313&o=r&tm=<? echo $tm ?>" class="text10bc">[<? echo $lang['modify']. " relations"; ?>]</a></td>
									<td align="center"><a href="phpradmin.php?p=313&o=d&tm=<? echo $tm ?>" class="text10bc" onclick="return confirm('<? echo $lang['confirm_removing']; ?>')">[<? echo $lang["delete"]; ?>]</a></td>
								</tr>
							</table>
						</td>
					</tr>
					<? } ?>
					<tr>
						<td>
							<? if (!strcmp($_GET["o"], "ah")) {
								if (isset($_POST["tmh"]))
									$tmhArray = $_POST["tmh"];

								if (isset($_POST["tmh"]) && $tmhArray["host_host_id"])
									if (isset($tms[$tm]->TMHosts))
										foreach ($tms[$tm]->TMHosts as $TMHost)	{
											if ($TMHost->get_host() == $tmhArray["host_host_id"])	{
												$hostLabel = $TMHost->get_label();
												$hostX = $TMHost->get_x();
												$hostY = $TMHost->get_y();
											}
											unset($TMHost);
										}
							?>
							<form action="" <? if (!isset($hostX) || !isset($hostY)) echo "name='trafficMapEvent'"; ?> method="post">
							<table border='0' align="center" cellpadding="0" cellspacing="0" class="tabTableForTab">
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['tm_hostServiceAssociated']; ?><font color='red'>*</font></td>
									<td>
										<select name="tmh[host_host_id]" onChange="this.form.submit()" id="host_host_id">
											<option></option>
											<?
											if (isset($hosts))
												foreach ($hosts as $host)	{
													if ($host->get_register() && $oreon->is_accessible($host->get_id()))	{
														$flag = 0;
														if (isset($host->services))
															foreach ($host->services as $service)	{
																if (stristr($service->get_description(), "traffic"))
																	$flag = 1;
																unset($service);
															}
														if ($flag)	{
															echo "<option value='".$host->get_id()."'";
															if (isset($_POST["tmh"]) && ($host->get_id() == $tmhArray["host_host_id"]))
																echo " selected";
															echo ">".$host->get_name()."</option>";
														}
													}
													unset($host);
												}
											?>
										</select>
									</td>
								</tr>
								<? if (isset($_POST["tmh"]) && $tmhArray["host_host_id"])	{ ?>
								<tr>
									<td style="white-space: nowrap; padding-right: 5px;"><? echo $lang['tm_checkTrafficAssociated']; ?></td>
									<td align="left">
										<select name="tmh[service_service_id]" id="service_service_id">
											<option></option>
											<?
											if (isset($_POST["tmh"]) && $tmhArray["host_host_id"])
												if (isset($hosts[$tmhArray["host_host_id"]]->services))	{
													$i = 0;
													foreach ($hosts[$tmhArray["host_host_id"]]->services as $service)	{
														if (stristr($service->get_description(), "traffic")) {
															echo "<option value='".$service->get_id()."'";
															if (!$i)
																echo " selected";
															echo ">".$service->get_description()."</option>";
														}
														$i++;
														unset($service);
													}
												}
											?>
										</select>
									</td>
								</tr>
								<? } ?>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['tm_other']; ?><font color='red'>*</font></td>
									<td>
										<select name="tmh[host_host_id2]" onChange="this.form['host_host_id'].options[0].selected = true; this.form['service_service_id'].options[0].selected = true">
											<option></option>
											<option value="-1">-<? echo $lang['tm_networkEquipment']; ?>-</option>
											<?
											if (isset($hosts))
												foreach ($hosts as $host)	{
													if ($host->get_register() && $oreon->is_accessible($host->get_id()))	{
														$flag = 0;
														if (isset($host->services))
															foreach ($host->services as $service)	{
																if (strstr(strtolower($service->get_description()), "traffic"))
																	$flag = 1;
																unset($service);
															}
														if (!$flag)	{
															echo "<option value='".$host->get_id()."'";
															if (isset($_POST["tmh"]) && ($host->get_id() == $tmhArray["host_host_id"]))
																echo " selected";
															echo ">".$host->get_name()."</option>";
														}
													}
													unset($host);
												}
											?>
										</select>
									</td>
								</tr>
								<tr>
									<td style="white-space: nowrap;">Host label&nbsp;<font color='red'>*</font></td>
									<td class="text10b"><input type="text" name="tmh[tmh_label]" value="<? if (isset($hostLabel)) echo $hostLabel; ?>" <? if (isset($hostLabel)) echo "readonly"; ?>></td>
								</tr>
								<tr>
									<td>X&nbsp;<font color='red'>*</font></td>
									<td><input name="x" type="text" value="<? if (isset($hostX)) echo $hostX; ?>" size=4 <? if (isset($hostX)) echo "readonly"; ?>></td>
								</tr>
								<tr>
									<td>Y&nbsp;<font color='red'>*</font></td>
									<td><input name="y" type="text" value="<? if (isset($hostY)) echo $hostY; ?>" size=4 <? if (isset($hostY)) echo "readonly"; ?>></td>
								</tr>
								<tr>
									<td style="white-space: nowrap;" valign="top">Hosts <? echo $lang['tm_selected']; ?></td>
									<td align="left" style="white-space: nowrap;">
									<?
										if (isset($tms[$tm]->TMHosts))
											foreach ($tms[$tm]->TMHosts as $TMHost)	{ ?>
												<li>
													<a href='./phpradmin.php?p=102&h=<? echo $TMHost->get_host(); ?>&o=w' class='text10b'>
														<? if (isset($hosts[$TMHost->get_host()])) echo $hosts[$TMHost->get_host()]->get_name()."</a> (".$TMHost->get_label().")"; else echo $TMHost->get_label()."</a>"; ?>
													<? if (isset($hosts[$TMHost->get_host()]) && isset($services[$TMHost->get_service()])) echo "&nbsp;&nbsp;(Check traffic :".$services[$TMHost->get_service()]->get_description().")"; else echo "&nbsp;&nbsp; (No check traffic)"; ?>
												</li>
									<? unset($TMHost); } ?>
									</td>
								</tr>
								<tr>
									<td colspan="2" align="center" style="padding-top: 10px;">
										<input type="hidden" name="tmh[trafficMap_tm_id]" value="<? echo $tm ?>">
										<input type="submit" name="addTMHost" value="<? echo $lang['save']; ?>">
									</td>
								</tr>
							</table>
							</form>
							<? } else if (!strcmp($_GET["o"], "ch")) {
								if (isset($_GET["TMHost"]))
									$tmHost = $_GET["TMHost"];
								else
									$tmHost = NULL;
							?>
							<form action="" name="trafficMapEvent" method="post">
							<table border='0' align="center" class="tabTableForTab">
								<tr>
									<td style="white-space: nowrap;" valign="top"><? echo $lang['h_available']; ?></td>
									<td align="left" style="white-space: nowrap;">
									<?
										if (isset($tms[$tm]->TMHosts))
											foreach ($tms[$tm]->TMHosts as $TMHost)	{ ?>
												<li>
													<? if (isset($hosts[$TMHost->get_host()])) echo $hosts[$TMHost->get_host()]->get_name()." (".$TMHost->get_label().")"; else echo $TMHost->get_label(); ?>
													<? if (isset($hosts[$TMHost->get_host()]) && isset($services[$TMHost->get_service()])) echo "&nbsp;(Check traffic :".$services[$TMHost->get_service()]->get_description().")"; else echo "&nbsp;&nbsp; (No check traffic)"; ?>
													<a href="./phpradmin.php?p=313&o=ch&tm=<? echo $tm; ?>&TMHost=<? echo $TMHost->get_id(); ?>" class="text10b"><? echo $lang['modify']; ?></a>&nbsp;&nbsp;
													<a href="./phpradmin.php?p=313&o=d&tm=<? echo $tm; ?>&TMHost=<? echo $TMHost->get_id(); ?>" class="text10b" onclick="return confirm('<? echo $lang['confirm_removing']; ?>')"><? echo $lang['delete']; ?></a>
												</li>
									<? unset($TMHost); } ?>
									</td>
								</tr>
								<? if (isset($_GET["TMHost"])) { ?>
								<tr>
									<td style="white-space: nowrap; padding-top: 10px;"><? echo $lang['tm_hostServiceAssociated']; ?></td>
									<td style=" padding-top: 10px;" class="text10b">
										<input name="tmh[host_host_id]" value="<? if (isset($_GET["TMHost"]) && isset($tms[$tm]->TMHosts[$tmHost]->host)) echo $tms[$tm]->TMHosts[$tmHost]->get_host(); ?>" type="hidden">
										<?
											if (isset($_GET["TMHost"]) && isset($hosts[$tms[$tm]->TMHosts[$tmHost]->get_host()]))
												echo $hosts[$tms[$tm]->TMHosts[$tmHost]->get_host()]->get_name()." / ".$tms[$tm]->TMHosts[$tmHost]->get_label();
											else if (isset($_GET["TMHost"]))
												echo $tms[$tm]->TMHosts[$tmHost]->get_label();
										?>
									</td>
								</tr>
								<? if (isset($hosts[$tms[$tm]->TMHosts[$tmHost]->get_host()]->services)) { ?>
								<tr>
									<td style="white-space: nowrap; padding-right: 5px;"><? echo $lang['tm_checkTrafficAssociated']; ?>&nbsp;<font color='red'>*</font></td>
									<td align="left">
										<select name="tmh[service_service_id]" id="service_service_id">
											<option></option>
											<?
												if (isset($hosts[$tms[$tm]->TMHosts[$tmHost]->get_host()]->services))
													foreach ($hosts[$tms[$tm]->TMHosts[$tmHost]->get_host()]->services as $service)	{
														if (stristr($service->get_description(), "traffic")) {
															echo "<option value='".$service->get_id()."'";
															if ($tms[$tm]->TMHosts[$tmHost]->get_service() == $service->get_id())
																echo " selected";
															echo ">".$service->get_description()."</option>";
														}
														unset($service);
													}
											?>
										</select>
									</td>
								</tr>
								<? } ?>
								<tr>
									<td style="white-space: nowrap;">Host label&nbsp;<font color='red'>*</font></td>
									<td class="text10b"><input type="text" name="tmh[tmh_label]" value="<? if (isset($_GET["TMHost"])) echo $tms[$tm]->TMHosts[$tmHost]->get_label(); ?>"></td>
								</tr>
								<tr>
									<td>X&nbsp;<font color='red'>*</font></td>
									<td><input name="x" type="text" value="<? if (isset($_GET["TMHost"])) echo $tms[$tm]->TMHosts[$tmHost]->get_x(); ?>" size=4></td>
								</tr>
								<tr>
									<td>Y&nbsp;<font color='red'>*</font></td>
									<td><input name="y" type="text" value="<? if (isset($_GET["TMHost"])) echo $tms[$tm]->TMHosts[$tmHost]->get_y(); ?>" size=4></td>
								</tr>
								<tr>
									<td colspan="2" align="center" style="padding-top: 10px;">
										<input type="hidden" name="tmh[trafficMap_tm_id]" value="<? echo $tm ?>">
										<input type="hidden" name="tmh[tmh_id]" value="<?  if (isset($_GET["TMHost"])) echo $tmHost ?>">
										<input type="submit" name="changeTMHost" value="<? echo $lang['save']; ?>">
									</td>
								</tr>
								<? } ?>
							</table>
							</form>
							<? } else if (!strcmp($_GET["o"], "r")) {
								if (isset($_GET["tmr"]))
									$tmr = $_GET["tmr"];
							?>
							<form action="" method="post">
							<table border='0' align="center"  class="tabTableForTab">
								<? if (isset($tms[$tm]->TMrelations) && count($tms[$tm]->TMrelations)) { ?>
								<tr>
									<td style="white-space: nowrap; padding-top: 15px;" valign="top">Relations</td>
									<td align="left" style="white-space: nowrap; padding-top: 15px;">
										<?
										if (isset($tms[$tm]->TMrelations))
											foreach ($tms[$tm]->TMrelations as $relation)	{
												echo "<div>";
												echo "<img src='./img/picto9.gif'>&nbsp;&nbsp;";
												echo $hosts[$tms[$tm]->TMHosts[$relation->get_TMHost1()]->get_host()]->get_name();
												echo "&nbsp;(".$tms[$tm]->TMHosts[$relation->get_TMHost1()]->get_label().")";
												echo " (". $services[$tms[$tm]->TMHosts[$relation->get_TMHost1()]->get_service()]->get_description().")";
												echo "&nbsp;<img src='./img/picto10.gif'>&nbsp;";
												if ($tms[$tm]->TMHosts[$relation->get_TMHost2()]->host != -1)
													echo $hosts[$tms[$tm]->TMHosts[$relation->get_TMHost2()]->get_host()]->get_name()." (".$tms[$tm]->TMHosts[$relation->get_TMHost2()]->get_label().")";
												else
													echo $tms[$tm]->TMHosts[$relation->get_TMHost2()]->get_label();
												if ($tms[$tm]->TMHosts[$relation->get_TMHost2()]->service)
													echo " (". $services[$tms[$tm]->TMHosts[$relation->get_TMHost2()]->get_service()]->get_description().")";
												?>
												&nbsp;&nbsp;<img src='./img/picto9.gif'>
												&nbsp;&nbsp;<a href='./phpradmin.php?p=313&o=r&tm=<? echo $tm; ?>&tmr=<? echo $relation->get_id()?>' class='text10b'>Edit</a>&nbsp;&nbsp;
												<a href='./phpradmin.php?p=313&o=d&tm=<? echo $tm ?>&tmr=<? echo $relation->get_id() ?>' class='text10b' onclick="return confirm('<? echo $lang['confirm_removing'] ?>')">Delete</a>
												</div>
										<?	unset($relation); } ?>
									</td>
								</tr>
								<? } if (isset($_GET["tmr"])) { ?>
								<tr>
									<td style="white-space: nowrap; padding-top: 15px;"><? echo $lang['tm_hostServiceAssociated']; ?> <font color='red'>*</font></td>
									<td align="left" style=" padding-top: 15px;">
										<? echo $hosts[$tms[$tm]->TMHosts[$tms[$tm]->TMrelations[$tmr]->get_TMHost1()]->get_host()]->get_name()." (".$tms[$tm]->TMHosts[$tms[$tm]->TMrelations[$tmr]->get_TMHost1()]->get_label().") (".$services[$tms[$tm]->TMHosts[$tms[$tm]->TMrelations[$tmr]->get_TMHost1()]->get_service()]->get_description().")" ?>
										<input type="hidden" name="tmr[trafficMap_host_tmh_id]" value="<? echo $tms[$tm]->TMrelations[$tmr]->get_TMHost1(); ?>">
									</td>
								</tr>
								<tr>
									<td style="white-space: nowrap;">Host <font color='red'>*</font></td>
									<td align="left">
										<select name="tmr[trafficMap_host_tmh_id2]">
											<?
											if (isset($tms[$tm]->TMHosts))
												foreach ($tms[$tm]->TMHosts as $TMHost)	{
													if ($TMHost->host != -1)	{
														echo "<option value='".$TMHost->get_id()."'";
														if ($tms[$tm]->TMrelations[$tmr]->get_TMHost2() == $TMHost->get_id())
															echo "selected";
														echo ">".$hosts[$TMHost->get_host()]->get_name()." (".$TMHost->get_label().")";
														if ($tms[$tm]->TMHosts[$tms[$tm]->TMrelations[$tmr]->get_TMHost2()]->get_service())
															echo "(". $services[$tms[$tm]->TMHosts[$tms[$tm]->TMrelations[$tmr]->get_TMHost2()]->get_service()]->get_description().")";
														echo "</option>";
													}
													else	{
														echo "<option value='".$TMHost->get_id()."'";
														if ($tms[$tm]->TMrelations[$tmr]->get_TMHost2() == $TMHost->get_id())
															echo "selected";
														echo ">".$TMHost->get_label()."</option>";
													}
													unset($TMHost);
												}
											?>
										</select>
									</td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['tm_maxBWIn']; ?> <font color='red'>*</font></td>
									<td align="left">
										<input type="text" name="tmr[tmhr_bin]" value="<? if (isset($_GET["tmr"])) echo $tms[$tm]->TMrelations[$tmr]->get_bin(); ?>">
									</td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['tm_maxBWOut']; ?> <font color='red'>*</font></td>
									<td align="left">
										<input type="text" name="tmr[tmhr_bout]" value="<? if (isset($_GET["tmr"])) echo $tms[$tm]->TMrelations[$tmr]->get_bout(); ?>">
									</td>
								</tr>
								<tr>
									<td colspan="2" align="center" style="padding-top: 10px;">
										<input type="hidden" name="tmr[trafficMap_tm_id]" value="<? echo $tm; ?>">
										<input type="hidden" name="tmr[tmhr_id]" value="<? if (isset($_GET["tmr"])) echo $tmr; ?>">
										<input type="submit" name="changeTMR" value="<? echo $lang['save']; ?>">
									</td>
								</tr>
								<? } ?>
							</table>
							</form>
							<? } else if (!strcmp($_GET["o"], "ra")) {
								if (isset($_POST["tmr"]))
									$tmr = $_POST["tmr"];
							?>
							<form action="" method="post">
							<table border='0' align="center" class="tabTableForTab">
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['tm_hostServiceAssociated']; ?><font color='red'>*</font></td>
									<td align="left">
										<select name="tmr[trafficMap_host_tmh_id]">
											<?
											if (isset($tms[$tm]->TMHosts))
												foreach ($tms[$tm]->TMHosts as $TMHost)	{
													if ($TMHost->host && $TMHost->service)
														echo "<option value='".$TMHost->get_id()."'>".$hosts[$TMHost->get_host()]->get_name()." (".$services[$TMHost->get_service()]->get_description().")</option>";
													unset($TMHost);
												}
											?>
										</select>
									</td>
								</tr>
								<tr>
									<td style="white-space: nowrap;">Host<font color='red'>*</font></td>
									<td align="left">
										<select name="tmr[trafficMap_host_tmh_id2]">
											<?
											if (isset($tms[$tm]->TMHosts))
												foreach ($tms[$tm]->TMHosts as $TMHost)	{
													if ($TMHost->host != -1)	{
														echo "<option value='".$TMHost->get_id()."'>".$hosts[$TMHost->get_host()]->get_name()." (".$TMHost->get_label().")";
														if ($TMHost->service)
															echo " (". $services[$TMHost->get_service()]->get_description().")";
														echo "</option>";
													}
													else
														echo "<option value='".$TMHost->get_id()."'>".$TMHost->get_label()."</option>";
													unset($TMHost);
												}
											?>
										</select>
									</td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['tm_maxBWIn']; ?><font color='red'>*</font></td>
									<td align="left">
										<input type="text" name="tmr[tmhr_bin]">
									</td>
								</tr>
								<tr>
									<td style="white-space: nowrap;">M<? echo $lang['tm_maxBWOut']; ?><font color='red'>*</font></td>
									<td align="left">
										<input type="text" name="tmr[tmhr_bout]">
									</td>
								</tr>
								<? if (isset($tms[$tm]->TMrelations) && count($tms[$tm]->TMrelations)) { ?>
								<tr>
									<td style="white-space: nowrap; padding-top: 15px;" valign="top">Relations</td>
									<td align="left" style="white-space: nowrap; padding-top: 15px;">
										<?
										foreach ($tms[$tm]->TMrelations as $relation)	{
											echo "<div>";
											echo "<img src='./img/picto9.gif'>&nbsp;&nbsp;";
											echo $hosts[$tms[$tm]->TMHosts[$relation->get_TMHost1()]->get_host()]->get_name();
											echo "&nbsp;(".$tms[$tm]->TMHosts[$relation->get_TMHost1()]->get_label().")";
											echo " (". $services[$tms[$tm]->TMHosts[$relation->get_TMHost1()]->get_service()]->get_description().")";
											echo "&nbsp;<img src='./img/picto10.gif'>&nbsp;";
											if ($tms[$tm]->TMHosts[$relation->get_TMHost2()]->host != -1)
												echo $hosts[$tms[$tm]->TMHosts[$relation->get_TMHost2()]->get_host()]->get_name()." (".$tms[$tm]->TMHosts[$relation->get_TMHost2()]->get_label().")";
											else
												echo $tms[$tm]->TMHosts[$relation->get_TMHost2()]->get_label();
											if ($tms[$tm]->TMHosts[$relation->get_TMHost2()]->service)
												echo " (". $services[$tms[$tm]->TMHosts[$relation->get_TMHost2()]->get_service()]->get_description().")";
											echo "&nbsp;&nbsp;<img src='./img/picto9.gif'>";
											echo "</div>";
											unset($relation);
										}
										?>
									</td>
								</tr>
								<? } ?>
								<tr>
									<td colspan="2" align="center" style="padding-top: 10px;">
										<input type="hidden" name="tmr[trafficMap_tm_id]" value="<? echo $tm; ?>">
										<input type="submit" name="addTMR" value="<? echo $lang['save']; ?>">
									</td>
								</tr>
							</table>
							</form>
							<? } else if (!strcmp($_GET["o"], "w") && isset($tms[$tm]->TMrelations)) { ?>
							<? if (isset($tms[$tm]->TMrelations) && count($tms[$tm]->TMrelations)) { ?>
							<table border="0" cellpadding="0" cellspacing="0" class="tabTableForTab">
								<tr>
									<td valign="top" class="text10b">Relation(s)</td>
									<td align="left" valign="top" style="white-space: nowrap;">
										<?
										foreach ($tms[$tm]->TMrelations as $relation)	{
											echo "<div>";
											echo "<img src='./img/picto9.gif'>&nbsp;&nbsp;";
											echo $hosts[$tms[$tm]->TMHosts[$relation->get_TMHost1()]->get_host()]->get_name();
											echo "&nbsp;(".$tms[$tm]->TMHosts[$relation->get_TMHost1()]->get_label().")";
											echo " (". $services[$tms[$tm]->TMHosts[$relation->get_TMHost1()]->get_service()]->get_description().")";
											echo "&nbsp;<img src='./img/picto10.gif'>&nbsp;";
											if ($tms[$tm]->TMHosts[$relation->get_TMHost2()]->host != -1)
												echo $hosts[$tms[$tm]->TMHosts[$relation->get_TMHost2()]->get_host()]->get_name()." (".$tms[$tm]->TMHosts[$relation->get_TMHost2()]->get_label().")";
											else
												echo $tms[$tm]->TMHosts[$relation->get_TMHost2()]->get_label();
											if ($tms[$tm]->TMHosts[$relation->get_TMHost2()]->service)
												echo " (". $services[$tms[$tm]->TMHosts[$relation->get_TMHost2()]->get_service()]->get_description().")";
											echo "&nbsp;&nbsp;<img src='./img/picto9.gif'>";
											echo "</div>";
											unset($relation);
										}
										?>
									</td>
								</tr>
							</table>
							<? }  } else if (!strcmp($_GET["o"], "a")) { ?>
							<form enctype="multipart/form-data" name="trafficMapEvent" method="post" action="">
							<table cellpaddin="0" cellspacing="0" class="tabTableForTab">
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['name']; ?>&nbsp;<font color='red'>*</font></td>
									<td><input type="text" name="tm[tm_name]" size="10"></td>
								</tr>
								<tr>
									<td style="white-space: nowrap;">Width</td>
									<td><input type="text" name="tm[tm_width]" size="10"></td>
								</tr>
								<tr>
									<td style="white-space: nowrap;">Height</td>
									<td><input type="text" name="tm[tm_height]" size="10"></td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['tm_background']; ?> (.png)</td>
									<td><input type="file" name="tm_background"></td>
								</tr>
								<tr>
									<td style="white-space: nowrap;">Key X pos</td>
									<td><input type="text" name="x" size="10"></td>
								</tr>
								<tr>
									<td style="white-space: nowrap;">Key Y pos</td>
									<td><input type="text" name="y" size="10"></td>
								</tr>
								<tr>
									<td	align="center" colspan="2" style="padding-top: 10px;">
										<input type="submit" name="addTM" value="<? echo $lang['save']; ?>">
									</td>
								</tr>
							</table>
							</form>
							<? } else if (!strcmp($_GET["o"], "c")) {	?>
							<form enctype="multipart/form-data" name="trafficMapEvent" method="post" action="">
							<table cellpaddin="0" cellspacing="0" width="100%" class="tabTableForTab">
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['name']; ?>&nbsp;<font color='red'>*</font></td>
									<td><input type="text" name="tm[tm_name]" size="30" value="<? echo $tms[$tm]->get_name(); ?>"></td>
								</tr>
								<tr>
									<td style="white-space: nowrap;">Width</td>
									<td><input type="text" name="tm[tm_width]" size="10" value="<? echo $tms[$tm]->get_width(); ?>"></td>
								</tr>
								<tr>
									<td style="white-space: nowrap;">Height</td>
									<td><input type="text" name="tm[tm_height]" size="10" value="<? echo $tms[$tm]->get_height(); ?>"></td>
								</tr>
								<tr>
									<td valign="middle" style="white-space: nowrap;"><? echo $lang['tm_background']; ?> (.png)</td>
									<td>
										<? if ($tms[$tm]->get_background())	{
											echo "<b>".$tms[$tm]->get_background()."</b>";
										?>
											<input type="checkbox" name="tm[check_img]" value="true">&nbsp;
											<? echo $lang['delete']; ?><br><br>
										<? } ?>
										<input type="file" name="tm_background">
									</td>
								</tr>
								<tr>
									<td style="white-space: nowrap;">Key X pos</td>
									<td><input type="text" name="x" size="10" value="<? echo $tms[$tm]->get_keyxpos(); ?>"></td>
								</tr>
								<tr>
									<td style="white-space: nowrap;">Key Y pos</td>
									<td><input type="text" name="y" size="10" value="<? echo $tms[$tm]->get_keyypos(); ?>"></td>
								</tr>
								<tr>
									<td	align="center" colspan="2" style="padding-top: 10px;">
										<input type="hidden" name="tm[tm_id]" value="<? echo $tm; ?>">
										<input type="submit" name="changeTM" value="<? echo $lang['save']; ?>">
									</td>
								</tr>
							</table>
							</form>
							<? } ?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	<? if (strcmp($_GET["o"], "a"))	{ ?>
		<tr>
			<td colspan="2">&nbsp;</td>
			<td style="padding-top: 5px;" align="center">
			<? $file = "./include/trafficMap/png/trafficMap". $tm . ".png" ;
				if (is_file( $file ) && is_readable( $file ) ) {
					echo '<img name="trafficMap" style="position:relative;top:0;left:0;" src="'. $file .'" border="1">';
				} else {
					echo "<div align='center' class='msg'>". sprintf($lang['g_no_access_file'], $file)."</div>";
				}
			?>
			</td>
		</tr>
	<? } ?>
	</table>
<?  } ?>