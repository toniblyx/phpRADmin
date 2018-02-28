<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/if (!isset($oreon))
		exit();
	
	if (isset($_GET["o"]) && isset($_GET["u"]) && !strcmp($_GET["o"],"d") && strcmp($_GET["h"], "") && strcmp($_GET["u"], "")){
		unset($oreon->Lca[$_GET["u"]]->restrict[$_GET["h"]]);
		$oreon->deleteLCAHosts($_GET["u"], $_GET["h"]);
		$_GET["o"] = "w";
	}
	if (isset($_GET["o"]) && isset($_GET["usr"]) && $_GET["o"] == "du" && strcmp($_GET["usr"], ""))	{
		if (isset($oreon->Lca[$_GET["usr"]]->restrict))
			foreach($oreon->Lca[$_GET["usr"]]->restrict as $restrict)
				unset($restrict);
		unset($oreon->Lca[$_GET["usr"]]);
		$oreon->deleteLCA($_GET["usr"]);
		$oreon->deleteLCAHosts($_GET["usr"], 0);
		$_GET["o"] = "w";
	}
	if (isset($_POST["reloadHostrestrict"]))	{
		if (!isset($_POST["restrict_host_id"]))
			$restrict_array = array();
		else
			$restrict_array = & $_POST["restrict_host_id"];
		$restrict_data = & $_POST["restricts"];
		$restrict_data["id"] = -1;
		$oreon->deleteLCAHosts($restrict_data["user_id"], 0);
		foreach ($restrict_array as $ra){
			$lca["host_host_id"] = $ra;
			$lca["user_id"] = $restrict_data["user_id"];
			$lca["lca_right"] = "1";
			$restrict_object = new Lca_hosts($lca);
			$oreon->saveLcaHosts($lca);
			$restrict_id = $oreon->database->database->get_last_id();
			$oreon->Lca[$restrict_data["user_id"]]->restrict[$lca["host_host_id"]] = $restrict_object;
		}				
		$_GET["o"] = "w";
		$_GET["u"] = $restrict_data["user_id"];
	}
	if (isset($_POST["apply_restriction"]))	{
		$restrict_array = & $_POST["restrict"];
		$restrict_array["id"] = -1;
		if (isset($restrict_array["user_id"]) && $restrict_array["user_id"])	{
			$restrict_object = new Lca($restrict_array);		
			$oreon->saveLca($restrict_object);
			$restrict_id = $oreon->database->database->get_last_id();		
			$oreon->Lca[$restrict_array["user_id"]] = $restrict_object;
			$_GET["o"] = "w";
			$_GET["u"] = $restrict_array["user_id"];
		}
	}		

	//defined value
	$value = array();
	$value["0"] = "NO";
	$value["1"] = "YES";
?>		
		
<table cellpadding="0" cellspacing="0" border="0" align="left">
	<tr>
		<td align="center" valign="top">
			<table cellpadding="0" cellspacing="0" style="padding-bottom:10px;width:240px;">
				<tr>
					<td class="tabTableTitle"><? echo $lang['m_options']; ?></td>
				</tr>
				<tr>
					<td class="tabTableMenu"><a href="phpradmin.php?p=215&o=a" class="text10"><? echo $lang['add']; ?></a></div>
					</td>
				</tr>
			</table>
			<table cellpadding="0" cellspacing="0" style="padding-bottom:10px;width:240px;">
				<tr>
					<td class="tabTableTitle"><? echo $lang['lca_user_restriction']; ?></td>
				</tr>
				<tr>
					<td class="tabTableMenu">
						<ul><?
						if (isset($oreon->Lca))
							foreach ($oreon->Lca as $lca)
								print "<li><a href='./phpradmin.php?p=215&u=".$oreon->users[$lca->get_user_id()]->get_id()."&o=w' class='text10'>" . $oreon->users[$lca->get_user_id()]->get_alias() . "</a></li>";?>
						</ul>
					</td>
				</tr>
			</table>
		</td>
		<td style="padding-left: 20px;"></td>
		<td valign="top" align="left">
		<? 	if (isset($_GET["u"]) && (!strcmp("w", $_GET["o"]) || !strcmp("a", $_GET["o"]))){?>
				<table cellpadding="0" cellspacing="0" style="padding-bottom:15px;width:350px;">
					<tr>
						<td class="tabTableTitle"><? print $oreon->users[$_GET["u"]]->get_alias()." : ".$lang["lca_action_on_profile"]; ?></td>
					</tr>
					<tr>
						<td class="tabTable" style="text-align:center"><a href='phpradmin.php?p=215&usr=<? print $_GET["u"]; ?>&o=du' class='text11' onclick="return confirm('<? echo $lang['confirm_removing']; ?>')"><? echo $lang['delete']; ?></a> - <a href="phpradmin.php?p=215&u=<? print $_GET["u"]; ?>&o=a" class="text11"><? echo $lang['modify']; ?></a></td>
					</tr>
					<tr>
						<td bgcolor='#CCCCCC' height='1'></td>
					</tr>
				</table>
				<table cellpadding="0" cellspacing="0" style="padding-bottom:15px;width:350px;">
					<tr>
						<td class="tabTableTitle"><? print $oreon->users[$_GET["u"]]->get_alias()." ".$lang['lca_profile']; ?></td>
					</tr>
					<tr>
						<td class="tabTableForTab" style="padding-bottom:10px">
						<? if (strcmp($_GET["o"], "a")) { ?> 
							<table cellpadding="1" cellspacing="2" align="center">
								<tr>  
									<td style="white-space: nowrap;"><? echo $lang['lca_access_comment']; ?></td>
									<td style="white-space: nowrap;"><? print $value[$oreon->Lca[$_GET["u"]]->get_comment()] ; ?></td>
								</tr>
								<tr> 
									<td style="white-space: nowrap;"><? echo $lang['lca_access_downtime']; ?></td>
									<td style="white-space: nowrap;"><? print $value[$oreon->Lca[$_GET["u"]]->get_downtime()] ; ?></td>
								</tr>
								<tr> 
									<td style="white-space: nowrap;"><? echo $lang['lca_access_watchlog']; ?></td>
									<td style="white-space: nowrap;"><? print $value[$oreon->Lca[$_GET["u"]]->get_watch_log()] ; ?></td>
								</tr>
								<tr> 
									<td style="white-space: nowrap;"><? echo $lang['lca_access_trafficMap']; ?></td>
									<td style="white-space: nowrap;"><? print $value[$oreon->Lca[$_GET["u"]]->get_traffic_map()] ; ?></td>
								</tr>
								<tr> 
									<td style="white-space: nowrap;"><? echo $lang['lca_access_processInfo']; ?></td>
									<td style="white-space: nowrap;"><? print $value[$oreon->Lca[$_GET["u"]]->get_admin_server()] ; ?></td>
								</tr>
							</table>
						<? } else { 
							$selected = array();
							$selected[1] = " selected";
							$selected[0] = "";
							$not_selected = array();
							$not_selected[0] = " selected";
							$not_selected[1] = "";	
							?>	
							<table cellpadding="1" cellspacing="2" align="center">
								<tr> 
									<td style="white-space: nowrap;"><? echo $lang['lca_access_comment']; ?></td>
									<td><select name="restrict[comment]">
										  <option value="1"<? print $selected[$oreon->Lca[$_GET["u"]]->get_comment()]; ?>>yes</option>
										  <option value="0"<? print $not_selected[$oreon->Lca[$_GET["u"]]->get_comment()]; ?>>No</option>
										</select>
									</td>
								</tr>
								<tr> 
									<td style="white-space: nowrap;"><? echo $lang['lca_access_downtime']; ?></td>
									<td>
										<select name="restrict[downtime]">
										  <option value="1"<? print $selected[$oreon->Lca[$_GET["u"]]->get_downtime()]; ?>>yes</option>
										  <option value="0"<? print $not_selected[$oreon->Lca[$_GET["u"]]->get_downtime()]; ?>>No</option>
										</select>
									</td>
								</tr>
								<tr> 
									<td style="white-space: nowrap;"><? echo $lang['lca_access_watchlog']; ?></td>
									<td>
										<select name="restrict[watch_log]">
										  <option value="1"<? print $selected[$oreon->Lca[$_GET["u"]]->get_watch_log()]; ?>>yes</option>
										  <option value="0"<? print $not_selected[$oreon->Lca[$_GET["u"]]->get_watch_log()]; ?>>No</option>
										</select>
									</td>
								</tr>
								<tr> 
									<td style="white-space: nowrap;"><? echo $lang['lca_access_trafficMap']; ?></td>
									<td>
										<select name="restrict[traffic_map]">
										  <option value="1"<? print $selected[$oreon->Lca[$_GET["u"]]->get_traffic_map()]; ?>>yes</option>
										  <option value="0"<? print $not_selected[$oreon->Lca[$_GET["u"]]->get_traffic_map()]; ?>>No</option>
										</select>
									</td>
								</tr>
								<tr> 
									<td style="white-space: nowrap;"><? echo $lang['lca_access_processInfo']; ?></td>
									<td>
										<select name="restrict[admin_server]">
										  <option value="1"<? print $selected[$oreon->Lca[$_GET["u"]]->get_admin_server()]; ?>>yes</option>
										  <option value="0"<? print $not_selected[$oreon->Lca[$_GET["u"]]->get_admin_server()]; ?>>No</option>
										</select>
									</td>
								</tr>
							</table>
						<? } ?>
						</td>
					</tr>
					</table>
					<table cellpadding="0" cellspacing="0" style="padding-bottom:15px;width:350px;">
					<tr>
						<td class="tabTableTitle"><? print $oreon->users[$_GET["u"]]->get_alias()." ".$lang['lca_user_access']; ?></td>
					</tr>
					<tr>
						<td class="tabTableForTab">
							<table border="0" cellpadding="0" cellspacing="0" style="padding-bottom:10px;width:250px;">
								<tr>
									<td valign="middle"> 
									<? if (strcmp($_GET["o"], "a")) {
											if (isset($oreon->Lca[$_GET["u"]]->restrict))
												foreach ($oreon->Lca[$_GET["u"]]->restrict as $r){
													print "<ul><li>&nbsp;".$oreon->hosts[$r->get_id()]->get_name();
													print "<a href='./phpradmin.php?p=215&u=".$_GET["u"]."&h=" . $oreon->hosts[$r->get_id()]->get_id() . "&o=d' onclick=\"return confirm('". $lang['confirm_removing'] . "')\"><img src='./img/deleted.gif' border='0' height='10'></a></li></ul>";
													unset($r);
												}
											?>
										
									<? } else if (!strcmp($_GET["o"], "a")) { ?>
										<form action="" method="post">
											<input name="restricts[user_id]" type="hidden" value="<? print $_GET["u"]; ?>">
											<input name="restricts[lca_right]" type="hidden" value="1">
											<table border="0" cellpadding="0" cellspacing="0" style="width:250px;">
												<tr>	
													<td align="left" style="padding: 3px;">
														<select  id="selectHostBase" name="selectHostBase" size="10" multiple>
														<?
															foreach ($oreon->hosts as $host)	{	
																if (!isset($oreon->Lca[$_GET["u"]]->restrict[$host->get_id()]) && $host->register != 0)
																	print ("<option value='".$host->get_id()."'>".$host->get_name()."</option>");
																unset($host);
															}
														?>
														</select>
													</td>
													<td style="padding-left: 5px; padding-right: 5px;" valign="middle" align="center">
														<input type="button" name="add" value="<? echo $lang['add']; ?>" onClick="Moove(this.form.selectHostBase,this.form.restrict_host_id)"><br><br><br>
														<input type="button" name="remove" value="<? echo $lang['delete']; ?>" onClick="Moove(this.form.restrict_host_id,this.form.selectHostBase)">
													</td>
													<td>
														<select id="restrict_host_id" name="restrict_host_id[]" size="10" multiple>
														<?	
															foreach ($oreon->hosts as $host)	{	
																if (isset($oreon->Lca[$_GET["u"]]->restrict[$host->get_id()]) && $host->register != 0)
																	print ("<option value='".$host->get_id()."'>".$host->get_name()."</option>");
																unset($host);
															}
														?>
														</select>
													</td>
												</tr>
												<tr>
													<td colspan="3" align="center"><input name="reloadHostrestrict" type="submit" value="<? echo $lang['save']; ?>"onClick="selectAll(this.form.restrict_host_id);"></td>
												</tr>
											</table> 
										</form>
										<?	} ?>
									</td>
								</tr>
							</table>			
						</td>
					</tr>
				</table>
	<?		} else 	if (isset($_GET["o"]) && !strcmp("a", $_GET["o"])){ ?>
				<form action="" method="post">
				<table cellpadding="0" cellspacing="0">
					<tr>
						<td class="tabTableTitle">Add LCA</td>
					</tr>
					<tr>
						<td align="center" class="tabTable">
							<table cellpadding="0" cellspacing="0">
								<tr> 
									<td><? echo $lang['lca_user']; ?></td>
									<td><select name="restrict[user_id]">
										<?
											if (isset($oreon->users))
												foreach ($oreon->users as $usr)
													if ($usr->get_status() <= 2)
														print "  <option value='".$usr->get_id()."'>".$usr->get_alias()."</option>";
										?>
										</select>
									</td>
								</tr>
								<tr> 
									<td style="white-space: nowrap;"><? echo $lang['lca_access_comment']; ?></td>
									<td><select name="restrict[comment]">
										  <option value="1">yes</option>
										  <option value="0">No</option>
										</select>
									</td>
								</tr>
								<tr> 
									<td style="white-space: nowrap;"><? echo $lang['lca_access_downtime']; ?></td>
									<td>
										<select name="restrict[downtime]">
										  <option value="1">yes</option>
										  <option value="0">No</option>
										</select>
									</td>
								</tr>
								<tr> 
									<td style="white-space: nowrap;"><? echo $lang['lca_access_watchlog']; ?></td>
									<td>
										<select name="restrict[watch_log]">
										  <option value="1">yes</option>
										  <option value="0">No</option>
										</select>
									</td>
								</tr>
								<tr> 
									<td style="white-space: nowrap;"><? echo $lang['lca_access_trafficMap']; ?></td>
									<td>
										<select name="restrict[traffic_map]">
										  <option value="1">yes</option>
										  <option value="0">No</option>
										</select>
									</td>
								</tr>
								<tr> 
									<td style="white-space: nowrap;"><? echo $lang['lca_access_processInfo']; ?></td>
									<td>
										<select name="restrict[admin_server]">
										  <option value="1">yes</option>
										  <option value="0">No</option>
										</select>
									</td>
								</tr>
								<tr> 
									<td colspan="2" align="center" style="padding:10px;"><input name="apply_restriction" type="submit" value="<? echo $lang['lca_apply_restrictions']; ?>"></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</form>
		<? } ?>
		</td>
	</tr>
</table>