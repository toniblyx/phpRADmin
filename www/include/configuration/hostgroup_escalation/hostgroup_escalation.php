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

	$hges = & $oreon->hges;
	if (isset($_GET) && array_key_exists("o", $_GET) && $_GET["o"] != "a" && $_GET["o"] != "l")
		if (!isset($_GET["hge"]) || (isset($_GET["hge"]) && !array_key_exists($_GET["hge"], $hges)))	{
			echo "<td width='85%'></td>";
			include ("./footer.php");
			exit();
		}
	$timeperiods = & $oreon->time_periods;
	$contactGroups = & $oreon->contactGroups;
	$hostGroups = & $oreon->hostGroups;
	$hosts = & $oreon->hosts;

	if (isset($_POST["AddHGE"]))	{
		$hge_array = & $_POST["hge"];
		$hge_array["hge_id"] = -1;
		// Manage value 0
		if (isset($hge_array["hge_notification_interval"]) && !$hge_array["hge_notification_interval"])
			$hge_array["hge_notification_interval"] = 99999;
		if (isset($hge_array["hge_last_notification"]) && !$hge_array["hge_last_notification"])
			$hge_array["hge_last_notification"] = 99999;

		$hge_object = new HostGroupEscalation($hge_array);
		if (isset($_POST["selectContactGroup"]))	{
			$selectContactGroup = $_POST["selectContactGroup"];
			for ($i = 0; $i < count($selectContactGroup); $i++)
				$hge_object->contactGroups[$selectContactGroup[$i]] = & $contactGroups[$selectContactGroup[$i]];
		}

		if ($hge_object->is_complete($oreon->user->get_version()) && $hge_object->twiceTest($hges))	{
			// log oreon
			system("echo \"[".time()."] AddHostGroupEscalation;".addslashes($hostGroups[$hge_array["hostgroup_hg_id"]]->get_name()).";".addslashes($oreon->user->get_alias())."\" >>./include/log/".date("Ymd").".txt");
			$oreon->saveHostGroupEscalation($hge_object);
			$hge_id = $oreon->database->database->get_last_id();
			$hges[$hge_id] = $hge_object;
			$hges[$hge_id]->set_id($hge_id);
			$oreon->saveHostGroupEscalation($hges[$hge_id]);
			$msg = $lang['errCode'][3];
			$_GET["o"] = "w";
			$_GET["hge"] = $hge_id;
		}
		else
			$msg = $lang['errCode'][$hge_object->get_errCode()];
		unset ($hge_object);
	}

	if (isset($_POST["ChangeHGE"]))	{
		$hge_array = & $_POST["hge"];

		// Manage value 0
		if (isset($hge_array["hge_notification_interval"]) && !$hge_array["hge_notification_interval"])
			$hge_array["hge_notification_interval"] = 99999;
		if (isset($hge_array["hge_last_notification"]) && !$hge_array["hge_last_notification"])
			$hge_array["hge_last_notification"] = 99999;

		$hge_object = new HostGroupEscalation($hge_array);
		if (isset($_POST["selectContactGroup"]))	{
			$selectContactGroup = $_POST["selectContactGroup"];
			for ($i = 0; $i < count($selectContactGroup); $i++)
				$hge_object->contactGroups[$selectContactGroup[$i]] = & $contactGroups[$selectContactGroup[$i]];
		}

		if ($hge_object->is_complete($oreon->user->get_version()) && $hge_object->twiceTest($hges))	{
			// log oreon
			system("echo \"[".time()."] ChangeHostGroupEscalation;".addslashes($hostGroups[$hge_array["hostgroup_hg_id"]]->get_name()).";".addslashes($oreon->user->get_alias())."\" >>./include/log/".date("Ymd").".txt");
			$hges[$hge_array["hge_id"]] = $hge_object;
			$oreon->saveHostGroupEscalation($hges[$hge_array["hge_id"]]);
			$msg = $lang['errCode'][2];
			$_GET["o"] = "w";
		}
		else
			$msg = $lang['errCode'][$hge_object->get_errCode()];
		unset ($hge_object);
	}

	if (isset($_GET["o"]) && !strcmp($_GET["o"], "d"))	{
		// log oreon
		system("echo \"[".time()."] DeleteHostGroupEscalation;".addslashes($hostGroups[$hges[$_GET["hge"]]->get_hostgroup()]->get_name()).";".addslashes($oreon->user->get_alias())."\" >>./include/log/".date("Ymd").".txt");
		$oreon->deleteHostGroupEscalation($hges[$_GET["hge"]]);
		unset($_GET["o"]);
		unset($_GET["hge"]);
	}

	if (isset($_GET["o"]) && !strcmp($_GET["o"], "l"))	{
		if (isset($_GET["box"]))	{
			$boxx = & $_GET["box"];
			foreach ($boxx as $box)	{
				// log add
				system("echo \"[" . time() . "] DeleteHostGroupEscalation;" . addslashes($hostGroups[$hges[$box]->get_hostGroup()]->get_name()) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
				$oreon->deleteHostGroupEscalation($hges[$box]);
			}
		}
		unset($_GET["o"]);
	}

	function write_he_list(&$hostGroups, &$hges, $lang)	{?>
		<table cellpadding="0" cellspacing="0" width="160">
			<tr>
				<td class="tabTableTitleMenu"><? print $lang["m_options"]; ?></td>
			</tr>
			<tr>
				<td class="tabTableMenu">
					<div style="padding: 8px; text-align: center;">
						<img src="img/picto2.gif">
						<a href="phpradmin.php?p=122&o=a" class="text9"><? echo $lang['add']; ?></a>
						<img src="img/picto2_bis.gif">
					</div>
				</td>
			</tr>
		</table>
		<br>
		<table cellpadding="0" cellspacing="0" width="160">
			<tr>
				<td class="tabTableTitleMenu"><? print $lang['hge_available']; ?></td>
			</tr>
			<tr>
				<td class="tabTableMenu"><?
				 if (isset($hges))
					foreach ($hges as $hge)	{?>
						<div style="padding: 2px; white-space: nowrap;" align="left">
							<li>
								<a href="phpradmin.php?p=122&hge=<? echo $hge->get_id(); ?>&o=w" class="text10" <? if(!$hostGroups[$hge->get_hostgroup()]->get_activate()) echo "style='text-decoration: line-through;'"; ?>>
									<? echo stripslashes($hostGroups[$hge->get_hostgroup()]->get_name()); ?>
								</a>
							</li>
						</div>
				<?  unset($hge); } ?>
				</td>
			</tr>
		</table><?
	}

	function write_hge_list2(&$hostGroups, &$hges, &$contactGroups, $lang)	{	?>
		<form action="" name="hostGroupEscalationMenu" method="get">
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
		if (isset($hges) && count($hges) != 0)	{
			$cpt = 0;
			foreach ($hges as $hge)	{
				if ($cpt < (VIEW_MAX * $num) && ($cpt >= ((VIEW_MAX * $num) - (VIEW_MAX)))){	?>
				<tr>
					<td class="listSub<? echo $cpt%2; ?>"><input type="checkbox" name="box[<? echo $hge->get_id(); ?>]" value="<? echo $hge->get_id(); ?>"></td>
					<td align="left" class="listSub<? echo $cpt%2; ?>"><a href="phpradmin.php?p=103&hg=<? echo $hge->get_hostGroup(); ?>&o=w" class="text11"><? echo $hostGroups[$hge->get_hostGroup()]->get_name(); ?></a></td>
					<td align="left" class="listSub<? echo $cpt%2; ?>">
						<?
						foreach($hge->contactGroups as $cg)	{
							echo " - ".$cg->get_name();
							unset($cg);
						}
						?>
					</td>
					<td align="center" class="listSub<? echo $cpt%2; ?>"><? if ($hostGroups[$hge->get_hostgroup()]->get_activate()) echo $lang['enable']; else echo $lang['disable']; ?></td>
					<td class="listSub<? echo $cpt%2; ?>">
						&nbsp;&nbsp;
						<a href="phpradmin.php?p=122&hge=<? echo $hge->get_id(); ?>&o=w" class="text11"><img src="img/listView.gif" border="0" alt="<? echo $lang['view']; ?>" title="<? echo $lang['view']; ?>"></a>&nbsp;
						<a href="phpradmin.php?p=122&hge=<? echo $hge->get_id(); ?>&o=c" class="text11"><img src="img/listPen.gif" border="0" alt="<? echo $lang['modify']; ?>" title="<? echo $lang['modify']; ?>"></a>&nbsp;
						<a href="phpradmin.php?p=122&hge=<? echo $hge->get_id(); ?>&o=d&num=<? echo $num; ?>&limit=<? echo VIEW_MAX; ?>" class="text11" onclick="return confirm('<? echo $lang['confirm_removing']; ?>')"><img src="img/listDel.gif" border="0" alt="<? echo $lang['delete']; ?>" title="<? echo $lang['delete']; ?>"></a>&nbsp;&nbsp;
					</td>
				</tr>
			<?	}
				unset($hge);
				$cpt++;
				}
			} ?>
			<tr>
				<td colspan="2" valign="top"><img src="img/arrow_ltr.gif" style="padding-left: 5px;">&nbsp;&nbsp;	<a href="#" class="text10bc" onclick=" if (confirm('<? echo $lang['confirm_removing']; ?>')){document.forms['hostGroupEscalationMenu'].submit();}"><? echo $lang['m_delete_selection']; ?></a></td>
				<td></td>
				<td colspan="2" align="right" class="text10">
					<a href="phpradmin.php?p=122&o=a" class="text10bc"><? echo $lang['add']; ?></a>&nbsp;&nbsp;<br><br>
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
					<? $nbrPage = floor(count($hges)/VIEW_MAX); if(count($hges)%VIEW_MAX) $nbrPage++; ?>
					<? echo "<font class='text11b'>".$lang["page"]. ":&nbsp;&nbsp;</font>[&nbsp;&nbsp;";
						for ($i = 1; $i <= $nbrPage; $i++)	{
							if($num == $i)
								echo "<a href='./phpradmin.php?p=122&num=$i&limit=".VIEW_MAX."' class='text10'><b>$i</b></a>&nbsp;&nbsp;";
							else
								echo "<a href='./phpradmin.php?p=122&num=$i&limit=".VIEW_MAX."' class='text10'>$i</a>&nbsp;&nbsp;";
						}
						echo "]";
					?>
				</td>
			</tr>
		</table>
		<input type="hidden" name="p" value="122">
		<input type="hidden" name="o" value="l" id="option">
	</form>
	<? }


if (!isset($_GET["o"])){ ?>
	<table border="0" align="left">
		<tr>
			<td valign="top"><? write_hge_list2($hostGroups, $hges, $contactGroups, $lang); ?></td>
		</tr>
	</table>
<? } else if (isset($_GET["o"]))	{
		if (isset($_GET["hge"]))
			$hge_id = $_GET["hge"]; ?>
	<table align="left" border="0">
		<tr>
			<td style="white-space: nowrap;" valign="top"><? write_he_list($hostGroups, $hges, $lang); ?></td>
			<td style="padding-left: 20px;"></td>
			<td valign="top" align='left'>
			<? if (isset($msg))
				echo "<div align='center' class='msg' style='padding-bottom: 10px;'>$msg</div>"; ?>
				<table border='0' align="left" cellpadding="0" cellspacing="0" width="400">
				<tr>
					<td align="center" class="tabTableTitle">Host Group Escalation <? if (!strcmp($_GET["o"], "c") || !strcmp($_GET["o"], "w")) {  echo "\"".$hostGroups[$hges[$hge_id]->get_hostgroup()]->get_name()."\"";} ?></td>
				</tr>
				<tr>
					<td class='tabTableForTab'>
					<? 	if (!strcmp($_GET["o"], "w") || !strcmp($_GET["o"], "c") || !strcmp($_GET["o"], "a"))
								include("./include/configuration/hostgroup_escalation/hostgroup_escalation_".$_GET["o"].".php"); ?>
					</td>
				</tr>
			</table>
			</td>
		</tr>
	</table>
<? } ?>