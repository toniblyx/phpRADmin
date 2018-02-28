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

	$contacts = & $oreon->contacts;
	if (isset($_GET) && array_key_exists("o", $_GET) && $_GET["o"] != "a" && $_GET["o"] != "l")
		if (!isset($_GET["c"]) || (isset($_GET["c"]) && !array_key_exists($_GET["c"], $contacts)))	{
			echo "<td width='85%'></td>";
			include ("./footer.php");
			exit();
		}
	$commands = & $oreon->commands;
	$time_periods = & $oreon->time_periods;
	$contactGroups = & $oreon->contactGroups;

	if (isset($_POST["Changecontact"]))	{
		$cct_array = & $_POST["cct"];
		$cct_array["contact_host_notification_options"] = NULL;
		if (isset($cct_array["contact_host_notification_options_d"])) $cct_array["contact_host_notification_options"] .= $cct_array["contact_host_notification_options_d"];
		if (strcmp($cct_array["contact_host_notification_options"], "") && isset($cct_array["contact_host_notification_options_u"])  && strcmp($cct_array["contact_host_notification_options_u"], "")) $cct_array["contact_host_notification_options"] .= ",";
		if (isset($cct_array["contact_host_notification_options_u"])) $cct_array["contact_host_notification_options"] .= $cct_array["contact_host_notification_options_u"];
		if (strcmp($cct_array["contact_host_notification_options"], "") && isset($cct_array["contact_host_notification_options_r"]) && strcmp($cct_array["contact_host_notification_options_r"], "")) $cct_array["contact_host_notification_options"] .= ",";
		if (isset($cct_array["contact_host_notification_options_r"])) $cct_array["contact_host_notification_options"] .= $cct_array["contact_host_notification_options_r"];
		if (strcmp($cct_array["contact_host_notification_options"], "") && isset($cct_array["contact_host_notification_options_f"]) && strcmp($cct_array["contact_host_notification_options_f"], "")) $cct_array["contact_host_notification_options"] .= ",";
		if (isset($cct_array["contact_host_notification_options_f"])) $cct_array["contact_host_notification_options"] .= $cct_array["contact_host_notification_options_f"];
		if (strcmp($cct_array["contact_host_notification_options"], "") && isset($cct_array["contact_host_notification_options_n"])  && strcmp($cct_array["contact_host_notification_options_n"], "")) $cct_array["contact_host_notification_options"] .= ",";
		if (isset($cct_array["contact_host_notification_options_n"])) $cct_array["contact_host_notification_options"] .= $cct_array["contact_host_notification_options_n"];
		$cct_array["contact_service_notification_options"] = NULL;
		if (isset($cct_array["contact_service_notification_options_w"])) $cct_array["contact_service_notification_options"] .= $cct_array["contact_service_notification_options_w"];
		if (strcmp($cct_array["contact_service_notification_options"], "") && isset($cct_array["contact_service_notification_options_u"])  && strcmp($cct_array["contact_service_notification_options_u"], "")) $cct_array["contact_service_notification_options"] .= ",";
		if (isset($cct_array["contact_service_notification_options_u"])) $cct_array["contact_service_notification_options"] .= $cct_array["contact_service_notification_options_u"];
		if (strcmp($cct_array["contact_service_notification_options"], "") && isset($cct_array["contact_service_notification_options_c"]) && strcmp($cct_array["contact_service_notification_options_c"], "")) $cct_array["contact_service_notification_options"] .= ",";
		if (isset($cct_array["contact_service_notification_options_c"])) $cct_array["contact_service_notification_options"] .= $cct_array["contact_service_notification_options_c"];
		if (strcmp($cct_array["contact_service_notification_options"], "") && isset($cct_array["contact_service_notification_options_r"]) && strcmp($cct_array["contact_service_notification_options_r"], "")) $cct_array["contact_service_notification_options"] .= ",";
		if (isset($cct_array["contact_service_notification_options_r"])) $cct_array["contact_service_notification_options"] .= $cct_array["contact_service_notification_options_r"];
		if (strcmp($cct_array["contact_service_notification_options"], "") && isset($cct_array["contact_service_notification_options_f"])  && strcmp($cct_array["contact_service_notification_options_f"], "")) $cct_array["contact_service_notification_options"] .= ",";
		if (isset($cct_array["contact_service_notification_options_f"])) $cct_array["contact_service_notification_options"] .= $cct_array["contact_service_notification_options_f"];
		if (strcmp($cct_array["contact_service_notification_options"], "") && isset($cct_array["contact_service_notification_options_n"])  && strcmp($cct_array["contact_service_notification_options_n"], "")) $cct_array["contact_service_notification_options"] .= ",";
		if (isset($cct_array["contact_service_notification_options_n"])) $cct_array["contact_service_notification_options"] .= $cct_array["contact_service_notification_options_n"];
		$cct_object = new Contact($cct_array);
		if (isset($_POST["selectHostCmd"]))	{
			$selectHostCmd = $_POST["selectHostCmd"];
			for ($i = 0; $i < count($selectHostCmd); $i++)
				$cct_object->host_notification_commands[$selectHostCmd[$i]] = & $commands[$selectHostCmd[$i]];
		}
		if (isset($_POST["selectServiceCmd"]))	{
			$selectServiceCmd = $_POST["selectServiceCmd"];
			for ($i = 0; $i < count($selectServiceCmd); $i++)
				$cct_object->service_notification_commands[$selectServiceCmd[$i]] = & $commands[$selectServiceCmd[$i]];
		}
		if ($cct_object->is_complete($oreon->user->get_version()) && $cct_object->twiceTest($contacts))	{
			system("echo \"[" . time() . "] ChangeContact;" . addslashes($cct_object->get_name()) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
			$contacts[$cct_array["contact_id"]] = $cct_object;
			$contacts[$cct_array["contact_id"]]->set_pager($cct_array["contact_pager"]);
			$contacts[$cct_array["contact_id"]]->set_host_notification_period($cct_array["timeperiod_tp_id"]);
			$contacts[$cct_array["contact_id"]]->set_service_notification_period($cct_array["timeperiod_tp_id2"]);
			$contacts[$cct_array["contact_id"]]->set_comment($cct_array["contact_comment"]);
			if ($cct_array["contact_activate"]) $contacts[$cct_array["contact_id"]]->set_activate(1); else $contacts[$cct_array["contact_id"]]->set_activate(0);
			if (isset($_POST["selectContactGroup"]))	{
				$selectContactGroup = $_POST["selectContactGroup"];
				for ($i = 0; $i < count($selectContactGroup); $i++)
					$contacts[$cct_array["contact_id"]]->contact_groups[$selectContactGroup[$i]] = & $contactGroups[$selectContactGroup[$i]];
			}
			$oreon->saveContact($contacts[$cct_array["contact_id"]]);
			$msg = $lang['errCode'][2];
			$_GET["o"] = "w";
		}
		else
			$msg = $lang['errCode'][$cct_object->get_errCode()];
		unset($cct_object);
	}

	if (isset($_POST["AddContact"]))	{ // Add contact in oreon object and in the database
		$cct_array = & $_POST["cct"];
		$cct_array["contact_id"] = -1;
		$cct_array["contact_host_notification_options"] = NULL;
		if (isset($cct_array["contact_host_notification_options_d"])) $cct_array["contact_host_notification_options"] .= $cct_array["contact_host_notification_options_d"];
		if (strcmp($cct_array["contact_host_notification_options"], "") && isset($cct_array["contact_host_notification_options_u"])  && strcmp($cct_array["contact_host_notification_options_u"], "")) $cct_array["contact_host_notification_options"] .= ",";
		if (isset($cct_array["contact_host_notification_options_u"])) $cct_array["contact_host_notification_options"] .= $cct_array["contact_host_notification_options_u"];
		if (strcmp($cct_array["contact_host_notification_options"], "") && isset($cct_array["contact_host_notification_options_r"]) && strcmp($cct_array["contact_host_notification_options_r"], "")) $cct_array["contact_host_notification_options"] .= ",";
		if (isset($cct_array["contact_host_notification_options_r"])) $cct_array["contact_host_notification_options"] .= $cct_array["contact_host_notification_options_r"];
		if (strcmp($cct_array["contact_host_notification_options"], "") && isset($cct_array["contact_host_notification_options_f"]) && strcmp($cct_array["contact_host_notification_options_f"], "")) $cct_array["contact_host_notification_options"] .= ",";
		if (isset($cct_array["contact_host_notification_options_f"])) $cct_array["contact_host_notification_options"] .= $cct_array["contact_host_notification_options_f"];
		if (strcmp($cct_array["contact_host_notification_options"], "") && isset($cct_array["contact_host_notification_options_n"])  && strcmp($cct_array["contact_host_notification_options_n"], "")) $cct_array["contact_host_notification_options"] .= ",";
		if (isset($cct_array["contact_host_notification_options_n"])) $cct_array["contact_host_notification_options"] .= $cct_array["contact_host_notification_options_n"];
		$cct_array["contact_service_notification_options"] = NULL;
		if (isset($cct_array["contact_service_notification_options_w"])) $cct_array["contact_service_notification_options"] .= $cct_array["contact_service_notification_options_w"];
		if (strcmp($cct_array["contact_service_notification_options"], "") && isset($cct_array["contact_service_notification_options_u"])  && strcmp($cct_array["contact_service_notification_options_u"], "")) $cct_array["contact_service_notification_options"] .= ",";
		if (isset($cct_array["contact_service_notification_options_u"])) $cct_array["contact_service_notification_options"] .= $cct_array["contact_service_notification_options_u"];
		if (strcmp($cct_array["contact_service_notification_options"], "") && isset($cct_array["contact_service_notification_options_c"]) && strcmp($cct_array["contact_service_notification_options_c"], "")) $cct_array["contact_service_notification_options"] .= ",";
		if (isset($cct_array["contact_service_notification_options_c"])) $cct_array["contact_service_notification_options"] .= $cct_array["contact_service_notification_options_c"];
		if (strcmp($cct_array["contact_service_notification_options"], "") && isset($cct_array["contact_service_notification_options_r"]) && strcmp($cct_array["contact_service_notification_options_r"], "")) $cct_array["contact_service_notification_options"] .= ",";
		if (isset($cct_array["contact_service_notification_options_r"])) $cct_array["contact_service_notification_options"] .= $cct_array["contact_service_notification_options_r"];
		if (strcmp($cct_array["contact_service_notification_options"], "") && isset($cct_array["contact_service_notification_options_f"])  && strcmp($cct_array["contact_service_notification_options_f"], "")) $cct_array["contact_service_notification_options"] .= ",";
		if (isset($cct_array["contact_service_notification_options_f"])) $cct_array["contact_service_notification_options"] .= $cct_array["contact_service_notification_options_f"];
		if (strcmp($cct_array["contact_service_notification_options"], "") && isset($cct_array["contact_service_notification_options_n"])  && strcmp($cct_array["contact_service_notification_options_n"], "")) $cct_array["contact_service_notification_options"] .= ",";
		if (isset($cct_array["contact_service_notification_options_n"])) $cct_array["contact_service_notification_options"] .= $cct_array["contact_service_notification_options_n"];
		$cct_object = new Contact($cct_array);
		if (isset($_POST["selectHostCmd"]))	{
			$selectHostCmd = $_POST["selectHostCmd"];
			for ($i = 0; $i < count($selectHostCmd); $i++)
				$cct_object->host_notification_commands[$selectHostCmd[$i]] = & $commands[$selectHostCmd[$i]];
		}
		if (isset($_POST["selectServiceCmd"]))	{
			$selectServiceCmd = $_POST["selectServiceCmd"];
			for ($i = 0; $i < count($selectServiceCmd); $i++)
				$cct_object->service_notification_commands[$selectServiceCmd[$i]] = & $commands[$selectServiceCmd[$i]];
		}
		if ($cct_object->is_complete($oreon->user->get_version()) && $cct_object->twiceTest($contacts))	{
			system("echo \"[" . time() . "] AddContact;" . addslashes($cct_object->get_name()) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
			$oreon->saveContact($cct_object);
			$cct_id = $oreon->database->database->get_last_id();
			$contacts[$cct_id] = $cct_object;
			$contacts[$cct_id]->set_id($cct_id);
			$contacts[$cct_id]->set_pager($cct_array["contact_pager"]);
			$contacts[$cct_id]->set_host_notification_period($cct_array["timeperiod_tp_id"]);
			$contacts[$cct_id]->set_service_notification_period($cct_array["timeperiod_tp_id2"]);
			$contacts[$cct_id]->set_comment($cct_array["contact_comment"]);
			if ($cct_array["contact_activate"]) $contacts[$cct_id]->set_activate(1); else $contacts[$cct_id]->set_activate(0);
			if (isset($_POST["selectContactGroup"]))	{
				$selectContactGroup = $_POST["selectContactGroup"];
				for ($i = 0; $i < count($selectContactGroup); $i++)
					$contacts[$cct_id]->contact_groups[$selectContactGroup[$i]] = & $oreon->contactGroups[$selectContactGroup[$i]];
			}
			$oreon->saveContact($contacts[$cct_id]);
			$msg = $lang['errCode'][3];
			$_GET["o"] = "w";
			$_GET["c"] = $cct_id;
		}
		else
			$msg = $lang['errCode'][$cct_object->get_errCode()];
		unset($cct_object);
	}

	if (isset($_GET["o"]) && !strcmp($_GET["o"], "dup"))	{
		$cct_cpy = $_GET["c"];
		$cct_array = array();
		$cct_array["contact_id"] = -1;
		$cct_array["contact_name"] = $contacts[$cct_cpy]->get_name()."_1";
		$cct_array["contact_alias"] = $contacts[$cct_cpy]->get_alias();
		$cct_array["contact_host_notification_options"] = $contacts[$cct_cpy]->get_host_notification_options();
		$cct_array["contact_service_notification_options"] = $contacts[$cct_cpy]->get_service_notification_options();
		$cct_array["timeperiod_tp_id"] = $contacts[$cct_cpy]->get_host_notification_period();
		$cct_array["timeperiod_tp_id2"] = $contacts[$cct_cpy]->get_service_notification_period();
		$cct_array["contact_email"] = $contacts[$cct_cpy]->get_email();
		$cct_object = new Contact($cct_array);
		foreach ($contacts[$cct_cpy]->host_notification_commands as $cmd)	{
			$cct_object->host_notification_commands[$cmd->get_id()] = & $commands[$cmd->get_id()];
			unset($cmd);
		}
		foreach ($contacts[$cct_cpy]->service_notification_commands as $cmd)	{
			$cct_object->service_notification_commands[$cmd->get_id()] = & $commands[$cmd->get_id()];
			unset($cmd);
		}
		if ($cct_object->is_complete($oreon->user->get_version()) && $cct_object->twiceTest($contacts))	{
			// log oreon
			system("echo \"[".time()."] AddContact;".addslashes($cct_array["contact_name"]).";".addslashes($oreon->user->get_alias())."\" >>./include/log/".date("Ymd").".txt");
			$oreon->saveContact($cct_object);
			$cct_id = $oreon->database->database->get_last_id();
			$contacts[$cct_id] = $cct_object;
			$contacts[$cct_id]->set_id($cct_id);
			$contacts[$cct_id]->set_pager($contacts[$cct_cpy]->get_pager());
			$contacts[$cct_id]->set_comment($contacts[$cct_cpy]->get_comment());
			$contacts[$cct_id]->set_activate(1);
			foreach ($contacts[$cct_cpy]->contact_groups as $cg)	{
				$contacts[$cct_id]->contact_groups[$cg->get_id()] = & $contactGroups[$cg->get_id()];
				unset($cg);
			}
			$oreon->saveContact($contacts[$cct_id]);
			$msg = $lang['errCode'][3];
			$_GET["o"] = "w";
			$_GET["c"] = $cct_id;
		}
		else
			$msg = $lang['errCode'][$cct_object->get_errCode()];
		unset ($cct_object);
	}

	if (isset($_GET["o"]) && !strcmp($_GET["o"], "d"))	{
		system("echo \"[" . time() . "] DeleteContact;" . addslashes($contacts[$_GET["c"]]->get_name()) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
		$oreon->deleteContact($contacts[$_GET["c"]]);
		unset($_GET["o"]);
		unset($_GET["c"]);
	}

	if (isset($_GET["o"]) && !strcmp($_GET["o"], "l"))	{
		if (isset($_GET["box"]))	{
			$boxx = & $_GET["box"];
			foreach ($boxx as $box)	{
				// log add
				system("echo \"[" . time() . "] DeleteContact;" . addslashes($contacts[$box]->get_name()) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
				$oreon->deleteContact($contacts[$box]);
			}
		}
		unset($_GET["o"]);
	}

	// -----------------------------------
	function write_contact_list($contacts, $lang)	{
		?>
		<table cellpadding="0" cellspacing="0" width="160">
			<tr>
				<td class="tabTableTitleMenu"><? print $lang["m_options"]; ?></td>
			</tr>
			<tr>
				<td class="tabTableMenu">
					<div style="padding: 8px; text-align: center;">
						<img src="img/picto2.gif">
						<a href="phpradmin.php?p=106&o=a" class="text9"><? echo $lang['add']; ?></a>
						<img src="img/picto2_bis.gif">
					</div>
				</td>
			</tr>
		</table>
		<br>
		<table cellpadding="0" cellspacing="0" width="160">
			<tr>
				<td class="tabTableTitleMenu" style="white-space: nowrap"><? print $lang['c_available']; ?></td>
			</tr>
			<tr>
				<td class="tabTableMenu"> <?
				if (isset($contacts))
					foreach ($contacts as $ct)	{ ?>
						<div style="padding: 2px; white-space: nowrap" align="left">
							<li>
								<a href="phpradmin.php?p=106&c=<? echo $ct->get_id(); ?>&o=w" class="text10" <? if(!$ct->get_activate()) echo "style='text-decoration: line-through;'"; ?>>
									<? echo $ct->get_name(); ?>
								</a>
							</li>
						</div>
				<? unset ($ct); } ?>
				</td>
			</tr>
		</table><?
	}

	function write_contact_list2(&$contacts, $lang)	{	?>
		<form action="" name="contactMenu" method="get">
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
		if (isset($contacts) && count($contacts) != 0)	{
			$cpt = 0;
			foreach ($contacts as $contact)	{
				if ($cpt < (VIEW_MAX * $num) && ($cpt >= ((VIEW_MAX * $num) - (VIEW_MAX)))){	?>
				<tr>
					<td class="listSub<? echo $cpt%2; ?>"><input type="checkbox" name="box[<? echo $contact->get_id(); ?>]" value="<? echo $contact->get_id(); ?>"></td>
					<td align="left" class="listSub<? echo $cpt%2; ?>"><? echo $contact->get_name(); ?></td>
					<td align="left" class="listSub<? echo $cpt%2; ?>"><? echo $contact->get_alias(); ?></td>
					<td align="center" class="listSub<? echo $cpt%2; ?>"><? if ( $contact->get_activate()) echo $lang['enable']; else echo $lang['disable']; ?></td>
					<td class="listSub<? echo $cpt%2; ?>">
						&nbsp;&nbsp;
						<a href="phpradmin.php?p=106&c=<? echo $contact->get_id(); ?>&o=w" class="text11"><img src="img/listView.gif" border="0" alt="<? echo $lang['view']; ?>" title="<? echo $lang['view']; ?>"></a>&nbsp;
						<a href="phpradmin.php?p=106&c=<? echo $contact->get_id(); ?>&o=c" class="text11"><img src="img/listPen.gif" border="0" alt="<? echo $lang['modify']; ?>" title="<? echo $lang['modify']; ?>"></a>&nbsp;
						<a href="phpradmin.php?p=106&c=<? echo $contact->get_id(); ?>&o=dup" class="text11"><img src="img/listDup.gif" border="0" alt="<? echo $lang['dup']; ?>" title="<? echo $lang['dup']; ?>"></a>&nbsp;
						<a href="phpradmin.php?p=106&c=<? echo $contact->get_id(); ?>&o=d&num=<? echo $num; ?>&limit=<? echo VIEW_MAX; ?>" class="text11" onclick="return confirm('<? echo $lang['confirm_removing']; ?>')"><img src="img/listDel.gif" border="0" alt="<? echo $lang['delete']; ?>" title="<? echo $lang['delete']; ?>"></a>&nbsp;&nbsp;
					</td>
				</tr>
			<?	}
				unset($contact);
				$cpt++;
				}
			} ?>
			<tr>
				<td colspan="2" valign="top"><img src="img/arrow_ltr.gif" style="padding-left: 5px;">&nbsp;&nbsp;	<a href="#" class="text10bc" onclick=" if (confirm('<? echo $lang['confirm_removing']; ?>')){document.forms['contactMenu'].submit();}"><? echo $lang['m_delete_selection']; ?></a></td>
				<td></td>
				<td colspan="2" align="right" class="text10">
					<a href="phpradmin.php?p=106&o=a" class="text10bc"><? echo $lang['add']; ?></a>&nbsp;&nbsp;<br><br>
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
					<? $nbrPage = floor(count($contacts)/VIEW_MAX); if(count($contacts)%VIEW_MAX) $nbrPage++; ?>
					<? echo "<font class='text11b'>".$lang["page"]. ":&nbsp;&nbsp;</font>[&nbsp;&nbsp;";
						for ($i = 1; $i <= $nbrPage; $i++)	{
							if($num == $i)
								echo "<a href='./phpradmin.php?p=106&num=$i&limit=".VIEW_MAX."' class='text10'><b>$i</b></a>&nbsp;&nbsp;";
							else
								echo "<a href='./phpradmin.php?p=106&num=$i&limit=".VIEW_MAX."' class='text10'>$i</a>&nbsp;&nbsp;";
						}
						echo "]";
					?>
				</td>
			</tr>
		</table>
		<input type="hidden" name="p" value="106">
		<input type="hidden" name="o" value="l" id="option">
	</form>
	<? } ?>

<?
if (!isset($_GET["o"]))	{ ?>
	<table border="0" align="left">
		<tr>
  			<td valign="top">
				<? write_contact_list2($contacts, $lang); ?>
  			</td>
		</tr>
	</table>
<? } else if (isset($_GET["o"]))	{
		if (isset($_GET["c"]))
			$contact_id = $_GET["c"];
?>
	<table align="left" border="0">
		<tr>
			<td valign="top" align="left"><? write_contact_list($contacts, $lang)	?>	</td>
			<td style="padding-left: 20px;"></td>
			<td valign="top" align='left'>
			<? if (isset($msg))
					echo "<div align='center' class='msg' style='padding-bottom: 10px;'>$msg</div>";?>
				<table border='0' align="left" cellpadding="0" cellspacing="0">
					<tr>
						<td valign="top" class="tabTableTitle">Contact <? if (!strcmp($_GET["o"], "c") || !strcmp($_GET["o"], "w")) {  echo "\"" . $contacts[$contact_id]->get_name() . "\"";} ?></td>
					</tr>
					<tr>
						<td class="tabTableForTab">
							<? 	if (!strcmp($_GET["o"], "w") || !strcmp($_GET["o"], "c") || !strcmp($_GET["o"], "a"))
								include("./include/configuration/contact/contact_".$_GET["o"].".php"); ?>
						</td>
					</tr>
				</table>
		</td>
		<td style="padding-left: 20px;"></td>
		<? if (!strcmp($_GET["o"], "w") || !strcmp($_GET["o"], "c")) { ?>
		<td valign="top" align="left">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td class="tabTableTitle"><? echo $lang['usage_stats']; ?></td>
				</tr>
				<tr>
					<td class='tabTable' nowrap><? echo $lang['c_use']; ?>
					<?
					if (isset($oreon->contactGroups) && count($oreon->contactGroups))
						foreach ($oreon->contactGroups as $cg){
							foreach ($cg->contacts as $ct)	{
								if ($ct->get_id() == $oreon->contacts[$contact_id]->get_id())
									print "<li><a href='phpradmin.php?p=107&cg=" . $cg->get_id() . "&o=w' class='text10b'>" . $cg->get_name() . "</a></li>";
								unset($ct);
							}
							unset($cg);
						}
					?>
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