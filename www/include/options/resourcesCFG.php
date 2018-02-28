<?
/*
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)
For information : toni@blyx.com
*/
	if (!isset($oreon))
		exit();
	
	$resourcecfg = & $oreon->resourcecfg;

	if (isset($_POST["addResource"]))	{
		$rs_array = & $_POST["rs"];
		if (!isset($rs_array["resource_line"]))
			$rs_array["resource_line"] = NULL;
		if (!isset($rs_array["resource_comment"]))
			$rs_array["resource_comment"] = NULL;
		$rs_object = new Resourcecfg($rs_array);
		if ($rs_object->is_complete($oreon->user->get_version()) && $rs_object->twiceTest($resourcecfg))	{
			$rs_object->set_line("\$USER".$rs_object->get_id()."$=".$rs_object->get_line());
			// log oreon
			system("echo \"[".time()."] AddResource;".$rs_object->get_line().";".$oreon->user->get_alias()."\" >>./include/log/".date("Ymd").".txt");
			$resourcecfg[$rs_array["resource_id"]] = $rs_object;
			$oreon->saveResourcecfg($resourcecfg[$rs_array["resource_id"]]);
			$msg = $lang['resources_new'];
			unset($_GET["o"]);
		}	
		else	{
			$msg = $lang['uncomplete_form'];
			unset ($rs_object);
		}
	}

	if (isset($_GET["o"]) && !strcmp($_GET["o"], "d") && isset($_GET["rs"]))	{
		// log oreon
		system("echo \"[".time()."] DeleteResource;".$resourcecfg[$_GET["rs"]]->get_line().";".$oreon->user->get_alias()."\" >>./include/log/".date("Ymd").".txt");
		$oreon->deleteResourcecfg($resourcecfg[$_GET["rs"]]);
		unset($_GET["o"]);
		unset($_GET["rs"]);
	}
?>

<? if (isset($msg))
		echo "<div align='center' class='msg'>$msg</div>"; ?>
	<table align="left" border="0">
		<tr>
			<td valign="top" align="left">
				<table border="0">
					<tr>
						<td style="padding: 10px;" valign="top">
							<div class="text10b" style="padding-bottom: 10px; padding-top: 10px;">
								<? echo $lang['resources_example']; ?>
							</div>
							<div style="padding: 10px;">				
								# Sets $USER1$ to be the path to the plugins<br><br>
								$USER1$=/usr/local/nagios/libexec<br><br><br>
								
								<b>Comment :</b> Sets $USER1$ to be the path to the plugins<br><br>
								<b>n from $USERn$ value :</b> 1<br><br>
								<b>line :</b> /usr/local/nagios/libexec<br>
							</div>
						</td>
					</tr>
				</table>
			</td>
			<td style="padding-left: 20px;"></td>
			<td valign="top" align='left'>
				<table align="left" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>
							<table border='0' align="left">
								<tr>
									<td align="center">
										<table width="350" cellpadding="0" cellspacing="0">
											<tr>
												<td width="150" class="tabMultiCellTitleLeft" align="center">Resources</td>
												<td width="75" class="tabMultiCellTitleRight" align="center">Actions</td>
											</tr>
											<?
											if (isset($resourcecfg))
												foreach ($resourcecfg as $resource)	{
													echo "<tr>\n<td style='white-space: nowrap; padding: 5px;' class='tabMultiCellLeft'>\n";
													echo "<b>".$resource->get_comment()."</b><br><br>";
													echo $resource->get_line();
													echo "</td>\n<td style='white-space: nowrap;' align='center' class='tabMultiCellRight'>\n";													
													echo "<a href='./phpradmin.php?p=216&rs=".$resource->get_id()."&o=d' onclick=\"return confirm('". $lang['confirm_removing'] . "')\"><img src='./img/deleted.gif' border='0'></a>";
													echo "</td>\n</tr>\n";	
												}											
											?>
											<tr>
												<td colspan="2" bgcolor="#CCCCCC" height="1"></td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td style="padding-top: 15px;">
										<form action="" method="post">
										<table  cellpadding="0" cellspacing="0" width="350">
											<tr>
												<td align="center" class="tabTableTitle"><b><? echo $lang['resources_add']; ?></b></td>
											</tr>
										</table>
										<table  cellpadding="0" cellspacing="0" width="350" class="tabTableWithPadding">
											<tr>
												<td style="padding-left: 8px;">Comment</td>
												<td style="padding-top: 8px;"><input type="text" name="rs[resource_comment]" size="30"></td>
											</tr>
											<tr>
												<td style="white-space: nowrap;padding-left: 8px;">n from $USERn$ value :</td>
												<td>
													<select name="rs[resource_id]">
														<? for ($i = 1; $i <= 32; $i++)
																if (!array_key_exists($i, $resourcecfg))
																	echo "<option value='$i'>$i</option>\n";
														?> 
													</select>
												</td>
											</tr>
											<tr>
												<td style="white-space: nowrap;padding-left: 8px;">Line</td>
												<td><input type="text" name="rs[resource_line]" size="30"></td>
											</tr>
											<tr>
												<td colspan="2" align="center" style="padding-top: 10px;padding-left: 8px;">
													<input type="submit" name="addResource" value="<? echo $lang['add']; ?>">
												</td>
											</tr>
										</table>
										</form>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>