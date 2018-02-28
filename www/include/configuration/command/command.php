<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/if (!isset($oreon))
		exit();

	if (!isset($_GET["limit"]))
		$limit = 20;
	else
		$limit = $_GET["limit"];
	define("VIEW_MAX", $limit);

	$commands = & $oreon->commands;
	if (isset($_GET) && array_key_exists("o", $_GET) && $_GET["o"] != "a" && $_GET["o"] != "l")
		if (!isset($_GET["cmd"]) || (isset($_GET["cmd"]) && !array_key_exists($_GET["cmd"], $commands)))	{
			echo "<td width='85%'></td>";
			include ("./footer.php");
			exit();
		}

	if (isset($_POST["ChangeCmd"]))	{
		$command_array = & $_POST["command"];
		if (get_magic_quotes_gpc())
			$command_array[command_line] =  stripslashes($command_array[command_line]);
		$command_object = new Command($command_array);
		if ($command_object->is_complete($oreon->user->get_version()) && $command_object->twiceTest($commands))	{
			// log change
			system("echo \"[" . time() . "] ChangeCommand;" . addslashes($command_object->get_name()) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
			$commands[$command_object->get_id()] = $command_object;
			$oreon->saveCommand($commands[$command_object->get_id()]);
			$msg = $lang['errCode'][2];
			$_GET["o"] = "w";
		}	else
				$msg = $lang['errCode'][$command_object->get_errCode()];
		unset ($command_object);
	}

	if (isset($_POST["AddCMD"]))	{
		$command_array = & $_POST["command"];
		if (get_magic_quotes_gpc())
			$command_array[command_line] =  stripslashes($command_array[command_line]);
		$command_array["command_id"] = -1;
		$command_object = new Command($command_array);
		if ($command_object->is_complete($oreon->user->get_version()) && $command_object->twiceTest($commands))	{
			// log Add
			system("echo \"[" . time() . "] AddCommand;" . addslashes($command_object->get_name()) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
			$oreon->saveCommand($command_object);
			$command_id = $oreon->database->database->get_last_id();
			$commands[$command_id] = $command_object;
			$commands[$command_id]->set_id($command_id);
			$oreon->saveCommand($commands[$command_id]);
			$msg = $lang['errCode'][3];
			$_GET["o"] = "w";
			$_GET["cmd"] = $command_id;
			if ($commands[$command_id]->get_type() == 1)
				$_GET["type"] = "N";
			else
				$_GET["type"] = "C";
		}	else
				$msg = $lang['errCode'][$command_object->get_errCode()];
		unset ($command_object);
	}

	if (isset($_GET["o"]) && !strcmp($_GET["o"], "dup"))	{
		$cmd_cpy = $_GET["cmd"];
		$cmd_array = array();
		$cmd_array["command_id"] = -1;
		$cmd_array["command_name"] = $commands[$cmd_cpy]->get_name()."_1";
		$cmd_array["command_line"] = $commands[$cmd_cpy]->get_line();
		$cmd_array["command_type"] = $commands[$cmd_cpy]->get_type();
		$cmd_object = new Command($cmd_array);
		if ($cmd_object->is_complete($oreon->user->get_version()) && $cmd_object->twiceTest($commands))	{
			// log oreon
			system("echo \"[".time()."] AddCommand;".addslashes($cmd_array["command_name"]).";".addslashes($oreon->user->get_alias())."\" >>./include/log/".date("Ymd").".txt");
			$oreon->saveCommand($cmd_object);
			$cmd_id = $oreon->database->database->get_last_id();
			$commands[$cmd_id] = $cmd_object;
			$commands[$cmd_id]->set_id($cmd_id);
			$oreon->saveCommand($commands[$cmd_id]);
			$msg = $lang['errCode'][3];
			$_GET["o"] = "w";
			$_GET["cmd"] = $cmd_id;
		}
		else
			$msg = $lang['errCode'][$cmd_object->get_errCode()];
		unset ($cmd_object);
	}

	if (isset($_GET["o"]) && !strcmp($_GET["o"], "d"))	{
		// log add
		system("echo \"[" . time() . "] DeleteCommand;" . addslashes($commands[$_GET["cmd"]]->get_name()) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
		$oreon->deleteCommand($commands[$_GET["cmd"]]);
		unset($_GET["o"]);
		unset($_GET["cmd"]);
	}

	if (isset($_GET["o"]) && !strcmp($_GET["o"], "l"))	{
		if (isset($_GET["box"]))	{
			$boxx = & $_GET["box"];
			foreach ($boxx as $box)	{
				// log add
				system("echo \"[" . time() . "] DeleteCommand;" . addslashes($commands[$box]->get_name()) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
				$oreon->deleteCommand($commands[$box]);
			}
		}
		unset($_GET["o"]);
	}

	function write_Ccommands_list(&$commands, $lang)	{
		?>
		<table cellpadding="0" cellspacing="0" width="230">
			<tr>
				<td class="tabTableTitleMenu"><? print $lang["m_options"]; ?></td>
			</tr>
			<tr>
				<td class="tabTableMenu">
					<div style="padding: 8px; text-align: center;">
						<img src="img/picto2.gif">
						<a href="phpradmin.php?p=109&o=a" class="text9"><? echo $lang['add']; ?></a>
						<img src="img/picto2_bis.gif">
					</div>
				</td>
			</tr>
		</table>
		<br>
		<table cellpadding="0" cellspacing="0" width="230">
			<tr>
				<td class="tabTableTitleMenu" style="white-space: nowrap"><? print $lang['ckcmd_available']; ?></td>
			</tr>
			<tr>
				<td class="tabTableMenu"> <?
				if (isset($commands))
					foreach ($commands as $cmd)	{
						if (!strcmp($cmd->get_type(), "2"))	{	?>
							<div style="padding: 2px; white-space: nowrap" align="left">
								<li>
									<a href="phpradmin.php?p=109&cmd=<? echo $cmd->get_id(); ?>&o=w&type=C" class="text10">
										<? echo $cmd->get_name(); ?>
									</a>
								</li>
							</div>
				<?  	}
						unset($cmd);
					}?>
				</td>
			</tr>
		</table><?
	}

	function write_Ccommands_list2(&$commands, $lang)	{	?>
		<form action="" name="CcommandMenu" method="get">
			<table cellpadding="3" cellspacing="3">
				<tr>
					<td class="listTop"></td>
					<td align="left" class="listTop" style="padding-left: 20px; padding-right: 20px;"><? echo $lang['name']; ?></td>
					<td align="left" class="listTop" style="padding-left: 20px; padding-right: 20px;"><? echo $lang['description']; ?></td>
					<td align="center" class="listTop" style="padding-left: 20px; padding-right: 20px;"><? echo $lang['status']; ?></td>
					<td align="center" class="listTop" style="padding-left: 20px; padding-right: 20px;"><? echo $lang['options']; ?></td>
				</tr>
	<?
		if (!isset($_GET["num"]))
			$num = 1;
		else
			$num = $_GET["num"];
		$cpt = 0;
		$nbrC = 0;
		if (isset($commands) && count($commands) != 0)	{
			foreach ($commands as $command)	{
				if ($command->get_type() == 2)
					$nbrC++;
				if ($command->get_type() == 2 && $cpt < (VIEW_MAX * $num) && ($cpt >= ((VIEW_MAX * $num) - (VIEW_MAX)))){	?>
				<tr>
					<td class="listSub<? echo $cpt%2; ?>"><input type="checkbox" name="box[<? echo $command->get_id(); ?>]" value="<? echo $command->get_id(); ?>"></td>
					<td align="left" class="listSub<? echo $cpt%2; ?>"><? echo $command->get_name(); ?></td>
					<td align="left" class="listSub<? echo $cpt%2; ?>"><? echo substr($command->get_line(), 0, 50); if (strlen($command->get_line()) > 50) echo "..."; ?></td>
					<td align="center" class="listSub<? echo $cpt%2; ?>"><? echo $lang['enable']; ?></td>
					<td class="listSub<? echo $cpt%2; ?>">
						&nbsp;&nbsp;
						<a href="phpradmin.php?p=109&cmd=<? echo $command->get_id(); ?>&o=w&type=C" class="text11"><img src="img/listView.gif" border="0" alt="<? echo $lang['view']; ?>" title="<? echo $lang['view']; ?>"></a>&nbsp;
						<a href="phpradmin.php?p=109&cmd=<? echo $command->get_id(); ?>&o=c&type=C" class="text11"><img src="img/listPen.gif" border="0" alt="<? echo $lang['modify']; ?>" title="<? echo $lang['modify']; ?>"></a>&nbsp;
						<a href="phpradmin.php?p=109&cmd=<? echo $command->get_id(); ?>&o=dup&type=C" class="text11"><img src="img/listDup.gif" border="0" alt="<? echo $lang['dup']; ?>" title="<? echo $lang['dup']; ?>"></a>&nbsp;
						<a href="phpradmin.php?p=109&cmd=<? echo $command->get_id(); ?>&o=d&num=<? echo $num; ?>&limit=<? echo VIEW_MAX; ?>&type=C" class="text11" onclick="return confirm('<? echo $lang['confirm_removing']; ?>')"><img src="img/listDel.gif" border="0" alt="<? echo $lang['delete']; ?>" title="<? echo $lang['delete']; ?>"></a>&nbsp;&nbsp;
					</td>
				</tr>
			<?	}
				unset($contact);
				$cpt++;
				}
			} ?>
			<tr>
				<td colspan="2" valign="top"><img src="img/arrow_ltr.gif" style="padding-left: 5px;">&nbsp;&nbsp;	<a href="#" class="text10bc" onclick=" if (confirm('<? echo $lang['confirm_removing']; ?>')){document.forms['CcommandMenu'].submit();}"><? echo $lang['m_delete_selection']; ?></a></td>
				<td></td>
				<td colspan="2" align="right" class="text10">
					<a href="phpradmin.php?p=109&o=a" class="text10bc"><? echo $lang['add']; ?></a>&nbsp;&nbsp;<br><br>
					<? echo $lang['nbr_per_page']; ?>&nbsp;
					<select name="limit" class="select" onChange="this.form['option'].disabled = true; this.form.submit();">
						<? for ($i = 10; $i <= 50; $i = $i + 10)	{
								echo "<option";
								if (VIEW_MAX == $i)
									echo " selected";
								echo ">$i</option>";
							}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td align="center" colspan="5">
					<? $nbrPage = floor($nbrC/VIEW_MAX); if($nbrC%VIEW_MAX) $nbrPage++; ?>
					<? echo "<font class='text11b'>".$lang["page"]. ":&nbsp;&nbsp;</font>[&nbsp;&nbsp;";
						for ($i = 1; $i <= $nbrPage; $i++)	{
							if($num == $i)
								echo "<a href='./phpradmin.php?p=109&num=$i&limit=".VIEW_MAX."&type=C' class='text10'><b>$i</b></a>&nbsp;&nbsp;";
							else
								echo "<a href='./phpradmin.php?p=109&num=$i&limit=".VIEW_MAX."&type=C' class='text10'>$i</a>&nbsp;&nbsp;";
						}
						echo "]";
					?>
				</td>
			</tr>
		</table>
		<input type="hidden" name="p" value="109">
		<input type="hidden" name="type" value="C">
		<input type="hidden" name="o" value="l" id="option">
	</form>
	<? }

	function write_Ncommands_list($commands, $lang)	{
		?>
		<table cellpadding="0" cellspacing="0" width="230">
			<tr>
				<td class="tabTableTitleMenu"><? print $lang["m_options"]; ?></td>
			</tr>
			<tr>
				<td class="tabTableMenu">
					<div style="padding: 8px; text-align: center;">
						<img src="img/picto2.gif">
						<a href="phpradmin.php?p=109&o=a" class="text9"><? echo $lang['add']; ?></a>
						<img src="img/picto2_bis.gif">
					</div>
				</td>
			</tr>
		</table>
		<br>
		<table cellpadding="0" cellspacing="0" width="230">
			<tr>
				<td class="tabTableTitleMenu" style="white-space: nowrap"><? print $lang['ntcmd_available']; ?></td>
			</tr>
			<tr>
				<td class="tabTableMenu"> <?
				if (isset($commands))
					foreach ($commands as $cmd)	{
						if (!strcmp($cmd->get_type(), "1")){	?>
							<div style="padding: 2px; white-space: nowrap" align="left">
								<li>
									<a href="phpradmin.php?p=109&cmd=<? echo $cmd->get_id(); ?>&o=w&type=N" class="text10">
										<? echo $cmd->get_name(); ?>
									</a>
								</li>
							</div>
				<?  	}
						unset($cmd);
					} ?>
				</td>
			</tr>
		</table><?
	}

	function write_Ncommands_list2(&$commands, $lang)	{	?>
		<form action="" name="CcommandMenu" method="get">
			<table cellpadding="3" cellspacing="3">
				<tr>
					<td class="listTop"></td>
					<td align="left" class="listTop" style="padding-left: 20px; padding-right: 20px;"><? echo $lang['name']; ?></td>
					<td align="left" class="listTop" style="padding-left: 20px; padding-right: 20px;"><? echo $lang['description']; ?></td>
					<td align="center" class="listTop" style="padding-left: 20px; padding-right: 20px;"><? echo $lang['status']; ?></td>
					<td align="center" class="listTop" style="padding-left: 20px; padding-right: 20px;"><? echo $lang['options']; ?></td>
				</tr>
	<?
		if (!isset($_GET["num"]))
			$num = 1;
		else
			$num = $_GET["num"];
		$cpt = 0;
		if (isset($commands) && count($commands) != 0)	{
			foreach ($commands as $command)	{
				if ($command->get_type() == 1 && $cpt < (VIEW_MAX * $num) && ($cpt >= ((VIEW_MAX * $num) - (VIEW_MAX)))){	?>
				<tr>
					<td class="listSub<? echo $cpt%2; ?>"><input type="checkbox" name="box[<? echo $command->get_id(); ?>]" value="<? echo $command->get_id(); ?>"></td>
					<td align="left" class="listSub<? echo $cpt%2; ?>"><? echo $command->get_name(); ?></td>
					<td align="left" class="listSub<? echo $cpt%2; ?>"><? echo substr($command->get_line(), 0, 50); if (strlen($command->get_line()) > 50) echo "..."; ?></td>
					<td align="center" class="listSub<? echo $cpt%2; ?>"><? echo $lang['enable']; ?></td>
					<td class="listSub<? echo $cpt%2; ?>">
						&nbsp;&nbsp;
						<a href="phpradmin.php?p=109&cmd=<? echo $command->get_id(); ?>&o=w&type=N" class="text11"><img src="img/listView.gif" border="0" alt="<? echo $lang['view']; ?>" title="<? echo $lang['view']; ?>"></a>&nbsp;
						<a href="phpradmin.php?p=109&cmd=<? echo $command->get_id(); ?>&o=c&type=N" class="text11"><img src="img/listPen.gif" border="0" alt="<? echo $lang['modify']; ?>" title="<? echo $lang['modify']; ?>"></a>&nbsp;
						<a href="phpradmin.php?p=109&cmd=<? echo $command->get_id(); ?>&o=dup&type=N" class="text11"><img src="img/listDup.gif" border="0" alt="<? echo $lang['dup']; ?>" title="<? echo $lang['dup']; ?>"></a>&nbsp;
						<a href="phpradmin.php?p=109&cmd=<? echo $command->get_id(); ?>&o=d&num=<? echo $num; ?>&limit=<? echo VIEW_MAX; ?>&type=N" class="text11" onclick="return confirm('<? echo $lang['confirm_removing']; ?>')"><img src="img/listDel.gif" border="0" alt="<? echo $lang['delete']; ?>" title="<? echo $lang['delete']; ?>"></a>&nbsp;&nbsp;
					</td>
				</tr>
			<?	}
				if ($command->get_type() == 1)
					$cpt++;
				unset($command);
				}
			} ?>
			<tr>
				<td colspan="2" valign="top"><img src="img/arrow_ltr.gif" style="padding-left: 5px;">&nbsp;&nbsp;	<a href="#" class="text10bc" onclick=" if (confirm('<? echo $lang['confirm_removing']; ?>')){document.forms['CcommandMenu'].submit();}"><? echo $lang['m_delete_selection']; ?></a></td>
				<td></td>
				<td colspan="2" align="right" class="text10">
					<a href="phpradmin.php?p=109&o=a" class="text10bc"><? echo $lang['add']; ?></a>&nbsp;&nbsp;<br><br>
					<? echo $lang['nbr_per_page']; ?>&nbsp;
					<select name="limit" class="select" onChange="this.form['option'].disabled = true; this.form.submit();">
						<? for ($i = 10; $i <= 50; $i = $i + 10)	{
								echo "<option";
								if (VIEW_MAX == $i)
									echo " selected";
								echo ">$i</option>";
							}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td align="center" colspan="5">
					<? $nbrPage = floor($cpt/VIEW_MAX); if($cpt%VIEW_MAX) $nbrPage++; ?>
					<? echo "<font class='text11b'>".$lang["page"]. ":&nbsp;&nbsp;</font>[&nbsp;&nbsp;";
						for ($i = 1; $i <= $nbrPage; $i++)	{
							if($num == $i)
								echo "<a href='./phpradmin.php?p=109&num=$i&limit=".VIEW_MAX."&type=N' class='text10'><b>$i</b></a>&nbsp;&nbsp;";
							else
								echo "<a href='./phpradmin.php?p=109&num=$i&limit=".VIEW_MAX."&type=N' class='text10'>$i</a>&nbsp;&nbsp;";
						}
						echo "]";
					?>
				</td>
			</tr>
		</table>
		<input type="hidden" name="p" value="109">
		<input type="hidden" name="type" value="N">
		<input type="hidden" name="o" value="l" id="option">
	</form>
	<? } ?>
	
<?  if (!isset($_GET["o"]))	{	?>
	<table align="left">
		<tr>
			<? if ((isset($_GET['type']) && $_GET['type'] == "N")) {?>
			<td valign="top"><? write_Ncommands_list2($commands, $lang); ?></td>
			<? } ?>
			<td style="padding-left: 10px;"></td>
			<? if ((isset($_GET['type']) && $_GET['type'] == "C")) {?>
			<td valign="top"><? write_Ccommands_list2($commands, $lang); ?></td>
			<? } ?>
			<? if (!isset($_GET['type']))	{ ?>
			<td valign="top"><? write_Ncommands_list($commands, $lang); ?></td>
			<td style="padding-left: 10px;"></td>
			<td valign="top"><? write_Ccommands_list($commands, $lang); ?></td>
			<? } ?>
		</tr>
	</table>
<? } else if (isset($_GET["o"]))	{
		if (isset($_GET["cmd"]))
			$cmd = $_GET["cmd"];
?>
	<table align="left">
		<tr>
		<? if ((isset($_GET['type']) && $_GET['type'] == "N") || (isset($_POST['type']) && $_POST['type'] == "N"))	{ ?>
			<td valign="top" align="left">
				<? echo write_Ncommands_list($commands, $lang); ?>
			</td>
		<? } else if ((isset($_GET['type']) && $_GET['type'] == "C") ||(isset($_POST['type']) && $_POST['type'] == "C")) { ?>
			<td valign="top" align="left">
				<? echo write_Ccommands_list($commands, $lang); ?>
			</td>
		<? } else { ?>
			<td valign="top"><? write_Ncommands_list($commands, $lang); ?></td>
			<td style="padding-left: 10px;"></td>
			<td valign="top"><? write_Ccommands_list($commands, $lang); ?></td>
		<? } ?>
			<td style="padding-left: 20px;"></td>
			<td valign="top">
			<?
			if (isset($msg))
				echo "<div style='padding-bottom: 10px;' class='msg' align='center'>$msg</div>"; ?>
				<table border='0' cellpadding="0" cellspacing="0">
					<tr>
						<td class="tabTableTitle">Command <? if (!strcmp($_GET["o"], "c") || !strcmp($_GET["o"], "w")) {  echo "\"" . $commands[$cmd]->get_name() . "\"";} ?></td>
					</tr>
					<tr>
						<td class="tabTableForTab" width="400">
							<? 	if (!strcmp($_GET["o"], "w") || !strcmp($_GET["o"], "c") || !strcmp($_GET["o"], "a"))
								include("./include/configuration/command/command_".$_GET["o"].".php"); ?>
						</td>
					</tr>
				</table>
			</td>
			<td style="padding-left: 20px;"></td>
	<?  if (!strcmp($_GET["o"], "w") || !strcmp($_GET["o"], "c")) { ?>
			<td valign="top">
				<table border='0' cellpadding="0" cellspacing="0">
					<tr>
						<td class="tabTableTitle"><? echo $lang['usage_stats']; ?></td>
					<tr>
						<td class="tabTable" style="white-space: nowrap;">
							<li><a href='./phpradmin.php?p=104' class="text10">Services</a></li>
							<ul>
							<?
								$cc = 0;
								$hh = 0;
								if (isset($oreon->services))
									foreach ($oreon->services as $sv)	{
										if ($sv->get_check_command() == $commands[$cmd]->get_id())
											$cc++;
										if ($sv->get_event_handler() == $commands[$cmd]->get_id())
											$hh++;
										unset($sv);
								}
								echo "<li>$cc Check_commands</li>";
								echo "<li>$hh Event Handler</li><br>";
							?>
							</ul>
							<li><a href='./phpradmin.php?p=102' class="text10">Hosts</a></li>
							<ul>
							<?
								$cc = 0;
								$hh = 0;
								if (isset($oreon->hosts))
									foreach ($oreon->hosts as $h){
										if ($h->get_check_command() == $commands[$cmd]->get_id())
											$cc++;
										if ($h->get_event_handler() == $commands[$cmd]->get_id())
											$hh++;
										unset($h);
									}
								echo "<li>$cc Check_commands</li>";
								echo "<li>$hh Event Handler</li><br>";
							?>
							</ul>
							<li><a href='phpradmin.php?p=106' class="text10">Contacts</a></li>
							<ul>
							<?
								$hnc = 0;
								$snc = 0;
								if (isset($oreon->contacts))
									foreach ($oreon->contacts as $cct){
										if (isset($oreon->host_notification_commands))
											foreach($cct->host_notification_commands as $tab)	{
												if ($tab->get_id() == $commands[$cmd]->get_id())
													$hnc++;
												unset($tab);
											}
										if (isset($oreon->service_notification_commands))
											foreach($cct->service_notification_commands as $tab2)	{
												if ($tab2->get_id() == $commands[$cmd]->get_id())
													$snc++;
												unset($tab2);
											}
										unset($cct);
								}
								echo "<li>$hnc Hosts_notification_commands</li>";
								echo "<li>$snc Service_notification_commands</li><br>";
							?>
							</ul>
						</td>
					</tr>
					<tr>
						<td bgcolor="#CCCCCC" height="1"></td>
					</tr>
				</table>
			</td>
	<? } ?>
		</tr>
	</table>
<? } ?>