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

	$hes = & $oreon->hes;
	if (isset($_GET) && array_key_exists("o", $_GET) && $_GET["o"] != "a" && $_GET["o"] != "l")
		if (!isset($_GET["he"]) || (isset($_GET["he"]) && !array_key_exists($_GET["he"], $hes)))	{
			echo "<td width='85%'></td>";
			include ("./footer.php");
			exit();
		}
	$timeperiods = & $oreon->time_periods;
	$contactGroups = & $oreon->contactGroups;
	$hostGroups = & $oreon->hostGroups;
	$hosts = & $oreon->hosts;

	if (isset($_POST["AddHE"]))	{
		$he_array = & $_POST["he"];
		$he_array["he_id"] = -1;

		$he_array["he_escalation_options"] = NULL;
		if (isset($he_array["he_escalation_options_d"])) $he_array["he_escalation_options"] .= $he_array["he_escalation_options_d"];
		if (strcmp($he_array["he_escalation_options"], "") && isset($he_array["he_escalation_options_u"])  && strcmp($he_array["he_escalation_options_d"], "")) $he_array["he_escalation_options"] .= ",";
		if (isset($he_array["he_escalation_options_u"])) $he_array["he_escalation_options"] .= $he_array["he_escalation_options_u"];
		if (strcmp($he_array["he_escalation_options"], "") && isset($he_array["he_escalation_options_r"]) && strcmp($he_array["he_escalation_options_r"], "")) $he_array["he_escalation_options"] .= ",";
		if (isset($he_array["he_escalation_options_r"])) $he_array["he_escalation_options"] .= $he_array["he_escalation_options_r"];

		if (isset($he_array["he_notification_interval"]) && !$he_array["he_notification_interval"])
			$he_array["he_notification_interval"] = 99999;
		if (isset($he_array["he_last_notification"]) && !$he_array["he_last_notification"])
			$he_array["he_last_notification"] = 99999;

		$he_object = new HostEscalation($he_array);
		if (isset($_POST["selectHostGroup"]))	{
			$selectHostGroup = $_POST["selectHostGroup"];
			for ($i = 0; $i < count($selectHostGroup); $i++)
				$he_object->hostGroups[$selectHostGroup[$i]] = & $hostGroups[$selectHostGroup[$i]];
		}
		if (isset($_POST["selectContactGroup"]))	{
			$selectContactGroup = $_POST["selectContactGroup"];
			for ($i = 0; $i < count($selectContactGroup); $i++)
				$he_object->contactGroups[$selectContactGroup[$i]] = & $contactGroups[$selectContactGroup[$i]];
		}

		if ($he_object->is_complete($oreon->user->get_version()) && $he_object->twiceTest($hes))	{
			// log oreon
			system("echo \"[" . time() . "] AddHostEscalation;" . addslashes($oreon->hosts[$he_object->host]->get_name()) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
			$oreon->saveHostEscalation($he_object);
			$he_id = $oreon->database->database->get_last_id();
			$hes[$he_id] = $he_object;
			$hes[$he_id]->set_id($he_id);
			if (isset($he_array["timeperiod_tp_id"]) && $he_array["timeperiod_tp_id"])
				$hes[$he_id]->set_escalation_period($he_array["timeperiod_tp_id"]);
			else
				$hes[$he_id]->set_escalation_period(NULL);
			$hes[$he_id]->set_escalation_options($he_array["he_escalation_options"]);
			$oreon->saveHostEscalation($hes[$he_id]);
			$msg = $lang['errCode'][3];
			$_GET["o"] = "w";
			$_GET["he"] = $he_id;
		}
		else
			$msg = $lang['errCode'][$he_object->get_errCode()];
		unset ($he_object);
	}

	if (isset($_POST["ChangeHE"]))	{
		$he_array = & $_POST["he"];

		$he_array["he_escalation_options"] = NULL;
		if (isset($he_array["he_escalation_options_d"])) $he_array["he_escalation_options"] .= $he_array["he_escalation_options_d"];
		if (strcmp($he_array["he_escalation_options"], "") && isset($he_array["he_escalation_options_u"])  && strcmp($he_array["he_escalation_options_d"], "")) $he_array["he_escalation_options"] .= ",";
		if (isset($he_array["he_escalation_options_u"])) $he_array["he_escalation_options"] .= $he_array["he_escalation_options_u"];
		if (strcmp($he_array["he_escalation_options"], "") && isset($he_array["he_escalation_options_r"]) && strcmp($he_array["he_escalation_options_r"], "")) $he_array["he_escalation_options"] .= ",";
		if (isset($he_array["he_escalation_options_r"])) $he_array["he_escalation_options"] .= $he_array["he_escalation_options_r"];

		if (isset($he_array["he_notification_interval"]) && !$he_array["he_notification_interval"])
			$he_array["he_notification_interval"] = 99999;
		if (isset($he_array["he_last_notification"]) && !$he_array["he_last_notification"])
			$he_array["he_last_notification"] = 99999;

		$he_object = new HostEscalation($he_array);
		if (isset($_POST["selectHostGroup"]))	{
			$selectHostGroup = $_POST["selectHostGroup"];
			for ($i = 0; $i < count($selectHostGroup); $i++)
				$he_object->hostGroups[$selectHostGroup[$i]] = & $hostGroups[$selectHostGroup[$i]];
		}
		if (isset($_POST["selectContactGroup"]))	{
			$selectContactGroup = $_POST["selectContactGroup"];
			for ($i = 0; $i < count($selectContactGroup); $i++)
				$he_object->contactGroups[$selectContactGroup[$i]] = & $contactGroups[$selectContactGroup[$i]];
		}

		if ($he_object->is_complete($oreon->user->get_version()) && $he_object->twiceTest($hes))	{
			// log oreon
			system("echo \"[" . time() . "] AddHostEscalation;" . addslashes($oreon->hosts[$he_object->host]->get_name()) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
			$hes[$he_array["he_id"]] = $he_object;
			if (isset($he_array["timeperiod_tp_id"]) && $he_array["timeperiod_tp_id"])
				$hes[$he_array["he_id"]]->set_escalation_period($he_array["timeperiod_tp_id"]);
			else
				$hes[$he_array["he_id"]]->set_escalation_period(NULL);
			$hes[$he_array["he_id"]]->set_escalation_options($he_array["he_escalation_options"]);
			$oreon->saveHostEscalation($hes[$he_array["he_id"]]);
			$msg = $lang['errCode'][2];
			$_GET["o"] = "w";
		}
		else
			$msg = $lang['errCode'][$he_object->get_errCode()];
		unset ($he_object);
	}

	if (isset($_GET["o"]) && !strcmp($_GET["o"], "d"))	{
		// log oreon
		system("echo \"[" . time() . "] DeleteHostEscalation;" . addslashes($hosts[$hes[$_GET["he"]]->get_host()]->get_name()) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
		$oreon->deleteHostEscalation($hes[$_GET["he"]]);
		unset($_GET["o"]);
		unset($_GET["he"]);
	}

	if (isset($_GET["o"]) && !strcmp($_GET["o"], "l"))	{
		if (isset($_GET["box"]))	{
			$boxx = & $_GET["box"];
			foreach ($boxx as $box)	{
				// log add
				system("echo \"[" . time() . "] DeleteHostEscalation;" . addslashes($hosts[$hes[$box]->get_host()]->get_name()) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
				$oreon->deleteHostEscalation($hes[$box]);
			}
		}
		unset($_GET["o"]);
	}

	function write_he_list(&$hosts, &$hes, $lang)	{?>
		<table cellpadding="0" cellspacing="0" width="190">
			<tr>
				<td class="tabTableTitleMenu"><? print $lang["m_options"]; ?></td>
			</tr>
			<tr>
				<td class="tabTableMenu">
					<div style="padding: 8px; text-align: center;">
						<img src="img/picto2.gif">
						<a href="phpradmin.php?p=115&o=a" class="text9"><? echo $lang['add']; ?></a>
						<img src="img/picto2_bis.gif">
					</div>
				</td>
			</tr>
		</table>
		<br>
		<table cellpadding="0" cellspacing="0" width="190">
			<tr>
				<td class="tabTableTitleMenu"><? print $lang['he_available']; ?></td>
			</tr>
			<tr>
				<td class="tabTableMenu"><?
				  if (isset($hes))
					foreach ($hes as $he){?>
						<div style="padding: 2px; white-space: nowrap" align="left">
							<li>
								<a href="phpradmin.php?p=115&he=<? echo $he->get_id(); ?>&o=w" class="text10" <? if(!$hosts[$he->get_host()]->get_activate()) echo "style='text-decoration: line-through;'"; ?>>
									<? echo $hosts[$he->get_host()]->get_name(); ?>
								</a>
							</li>
						</div>
				<?  unset($he); ?>
				</td>
			</tr>
		</table><?}
	}

	function write_he_list2(&$hosts, &$hes, &$contactGroups, $lang)	{	?>
		<form action="" name="hostEscalationMenu" method="get">
			<table cellpadding="3" cellspacing="3">
				<tr>
					<td class="listTop"></td>
					<td align="left" class="listTop" style="padding-left: 20px; padding-right: 20px;"><? echo $lang['name']; ?></td>
					<td align="left" class="listTop" style="padding-left: 20px; padding-right: 20px;"><? echo $lang['cg']; ?></td>
					<td align="center" class="listTop" style="padding-left: 20px; padding-right: 20px;"><? echo $lang['status']; ?></td>
					<td align="center" class="listTop" style="padding-left: 20px; padding-right: 20px;"><? echo $lang['options']; ?></td>
				</tr>
	<?
		if (!isset($_GET["num"]))
			$num = 1;
		else
			$num = $_GET["num"];
		if (isset($hes) && count($hes) != 0)	{
			$cpt = 0;
			foreach ($hes as $he)	{
				if ($cpt < (VIEW_MAX * $num) && ($cpt >= ((VIEW_MAX * $num) - (VIEW_MAX)))){	?>
				<tr>
					<td class="listSub<? echo $cpt%2; ?>"><input type="checkbox" name="box[<? echo $he->get_id(); ?>]" value="<? echo $he->get_id(); ?>"></td>
					<td align="left" class="listSub<? echo $cpt%2; ?>"><a href="phpradmin.php?p=102&h=<? echo $he->get_host(); ?>&o=w" class="text11"><? echo $hosts[$he->get_host()]->get_name(); ?></a></td>
					<td align="left" class="listSub<? echo $cpt%2; ?>">
						<?
						foreach($he->contactGroups as $cg)	{
							echo " - ".$cg->get_name();
							unset($cg);
						}
						?>
					</td>
					<td align="center" class="listSub<? echo $cpt%2; ?>"><?  if($hosts[$he->get_host()]->get_activate()) echo $lang['enable']; else echo $lang['disable']; ?></td>
					<td class="listSub<? echo $cpt%2; ?>">
						&nbsp;&nbsp;
						<a href="phpradmin.php?p=115&he=<? echo $he->get_id(); ?>&o=w" class="text11"><img src="img/listView.gif" border="0" alt="<? echo $lang['view']; ?>" title="<? echo $lang['view']; ?>"></a>&nbsp;
						<a href="phpradmin.php?p=115&he=<? echo $he->get_id(); ?>&o=c" class="text11"><img src="img/listPen.gif" border="0" alt="<? echo $lang['modify']; ?>" title="<? echo $lang['modify']; ?>"></a>&nbsp;
						<a href="phpradmin.php?p=115&he=<? echo $he->get_id(); ?>&o=d&num=<? echo $num; ?>&limit=<? echo VIEW_MAX; ?>" class="text11" onclick="return confirm('<? echo $lang['confirm_removing']; ?>')"><img src="img/listDel.gif" border="0" alt="<? echo $lang['delete']; ?>" title="<? echo $lang['delete']; ?>"></a>&nbsp;&nbsp;
					</td>
				</tr>
			<?	}
				unset($he);
				$cpt++;
				}
			} ?>
			<tr>
				<td colspan="2" valign="top"><img src="img/arrow_ltr.gif" style="padding-left: 5px;">&nbsp;&nbsp;	<a href="#" class="text10bc" onclick=" if (confirm('<? echo $lang['confirm_removing']; ?>')){document.forms['hostEscalationMenu'].submit();}"><? echo $lang['m_delete_selection']; ?></a></td>
				<td></td>
				<td colspan="2" align="right" class="text10">
					<a href="phpradmin.php?p=115&o=a" class="text10bc"><? echo $lang['add']; ?></a>&nbsp;&nbsp;<br><br>
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
					<? $nbrPage = floor(count($hes)/VIEW_MAX); if(count($hes)%VIEW_MAX) $nbrPage++; ?>
					<? echo "<font class='text11b'>".$lang["page"]. ":&nbsp;&nbsp;</font>[&nbsp;&nbsp;";
						for ($i = 1; $i <= $nbrPage; $i++)	{
							if($num == $i)
								echo "<a href='./phpradmin.php?p=115&num=$i&limit=".VIEW_MAX."' class='text10'><b>$i</b></a>&nbsp;&nbsp;";
							else
								echo "<a href='./phpradmin.php?p=115&num=$i&limit=".VIEW_MAX."' class='text10'>$i</a>&nbsp;&nbsp;";
						}
						echo "]";
					?>
				</td>
			</tr>
		</table>
		<input type="hidden" name="p" value="115">
		<input type="hidden" name="o" value="l" id="option">
	</form>
	<? } ?>

<?	if (!isset($_GET["o"]))	{ ?>
	<table border="0">
		<tr>
			<td valign="top" align="left">
				<? write_he_list2($hosts, $hes, $contactGroups, $lang); ?>
			</td>
		</tr>
	</table>
<? } else if (isset($_GET["o"]))	{
		if (isset($_GET["he"]))
			$he_id = $_GET["he"];
?>
	<table align="left" border="0">
		<tr>
			<td valign="top" align="left"><? write_he_list($hosts, $hes, $lang); ?></td>
			<td style="padding-left: 20px;"></td>
			<td valign="top" align='left'>
			<? if (isset($msg))
				echo "<div align='center' class='msg' style='padding-bottom: 10px;'>$msg</div>"; ?>
				<table border='0' align="left" cellpadding="0" cellspacing="0" width="400">
					<tr>
						<td  align="center" class="tabTableTitle">
							<? echo "Host Escalation "; if (!strcmp($_GET["o"], "c") || !strcmp($_GET["o"], "w")) {  echo "\"" . $hosts[$hes[$he_id]->get_host()]->get_name() . "\"";} ?>
						</td>
					</tr>
					<tr>
						<td class="tabTableForTab">
						<? 	if (!strcmp($_GET["o"], "w") || !strcmp($_GET["o"], "c") || !strcmp($_GET["o"], "a"))
								include("./include/configuration/host_escalation/host_escalation_".$_GET["o"].".php"); ?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<? } ?>
