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

	$hds = & $oreon->hds;
	if (isset($_GET) && array_key_exists("o", $_GET) && $_GET["o"] != "a" && $_GET["o"] != "l")
		if (!isset($_GET["hd_id"]) || (isset($_GET["hd_id"]) && !array_key_exists($_GET["hd_id"], $hds)))	{
			echo "<td width='85%'></td>";
			include ("./footer.php");
			exit();
		}
	$hosts = & $oreon->hosts;

	if (isset($_POST["ChangeHD"]))	{
		$hd_array = & $_POST["hd"];
		$hd_array["hd_notification_failure_criteria"] = NULL;
		if (isset($hd_array["hd_notification_failure_criteria_o"])) $hd_array["hd_notification_failure_criteria"] .= $hd_array["hd_notification_failure_criteria_o"];
		if (strcmp($hd_array["hd_notification_failure_criteria"], "") && isset($hd_array["hd_notification_failure_criteria_d"])  && strcmp($hd_array["hd_notification_failure_criteria_d"], "")) $hd_array["hd_notification_failure_criteria"] .= ",";
		if (isset($hd_array["hd_notification_failure_criteria_d"])) $hd_array["hd_notification_failure_criteria"] .= $hd_array["hd_notification_failure_criteria_d"];
		if (strcmp($hd_array["hd_notification_failure_criteria"], "") && isset($hd_array["hd_notification_failure_criteria_u"]) && strcmp($hd_array["hd_notification_failure_criteria_u"], "")) $hd_array["hd_notification_failure_criteria"] .= ",";
		if (isset($hd_array["hd_notification_failure_criteria_u"])) $hd_array["hd_notification_failure_criteria"] .= $hd_array["hd_notification_failure_criteria_u"];
		if (strcmp($hd_array["hd_notification_failure_criteria"], "") && isset($hd_array["hd_notification_failure_criteria_n"]) && strcmp($hd_array["hd_notification_failure_criteria_n"], "")) $hd_array["hd_notification_failure_criteria"] .= ",";
		if (isset($hd_array["hd_notification_failure_criteria_n"])) $hd_array["hd_notification_failure_criteria"] .= $hd_array["hd_notification_failure_criteria_n"];
		$hd_array["hd_execution_failure_criteria"] = NULL;
		if (isset($hd_array["hd_execution_failure_criteria_o"])) $hd_array["hd_execution_failure_criteria"] .= $hd_array["hd_execution_failure_criteria_o"];
		if (strcmp($hd_array["hd_execution_failure_criteria"], "") && isset($hd_array["hd_execution_failure_criteria_d"])  && strcmp($hd_array["hd_execution_failure_criteria_d"], "")) $hd_array["hd_execution_failure_criteria"] .= ",";
		if (isset($hd_array["hd_execution_failure_criteria_d"])) $hd_array["hd_execution_failure_criteria"] .= $hd_array["hd_execution_failure_criteria_d"];
		if (strcmp($hd_array["hd_execution_failure_criteria"], "") && isset($hd_array["hd_execution_failure_criteria_u"]) && strcmp($hd_array["hd_execution_failure_criteria_u"], "")) $hd_array["hd_execution_failure_criteria"] .= ",";
		if (isset($hd_array["hd_execution_failure_criteria_u"])) $hd_array["hd_execution_failure_criteria"] .= $hd_array["hd_execution_failure_criteria_u"];
		if (strcmp($hd_array["hd_execution_failure_criteria"], "") && isset($hd_array["hd_execution_failure_criteria_n"]) && strcmp($hd_array["hd_execution_failure_criteria_n"], "")) $hd_array["hd_execution_failure_criteria"] .= ",";
		if (isset($hd_array["hd_execution_failure_criteria_n"])) $hd_array["hd_execution_failure_criteria"] .= $hd_array["hd_execution_failure_criteria_n"];
		$hd_object = new HostDependency($hd_array);
		if ($hd_object->is_complete($oreon->user->get_version()) && $hd_object->twiceTest($hds))	{
			$oreon->saveHostDependency($hd_object);
			$hds[$hd_array["hd_id"]] = $hd_object;
			if (isset($hd_array["hd_inherits_parent"]))
				$hds[$hd_array["hd_id"]]->set_inherits_parent($hd_array["hd_inherits_parent"]);
			if (isset($hd_array["hd_execution_failure_criteria"]))
				$hds[$hd_array["hd_id"]]->set_execution_failure_criteria($hd_array["hd_execution_failure_criteria"]);
			$oreon->saveHostDependency($hds[$hd_array["hd_id"]]);
			$msg = $lang['errCode'][2];
			// log oreon
			system("echo \"[" . time() . "] ChangeHostDependency;;" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
			$_GET["o"] = "w";
		}
		else
			$msg = $lang['errCode'][$hd_object->get_errCode()];
		unset ($hd_object);
	}

	if (isset($_POST["AddHD"]))	{
		$hd_array = & $_POST["hd"];
		$hd_array["hd_id"] = -1;
		$hd_array["hd_notification_failure_criteria"] = NULL;
		if (isset($hd_array["hd_notification_failure_criteria_o"])) $hd_array["hd_notification_failure_criteria"] .= $hd_array["hd_notification_failure_criteria_o"];
		if (strcmp($hd_array["hd_notification_failure_criteria"], "") && isset($hd_array["hd_notification_failure_criteria_d"])  && strcmp($hd_array["hd_notification_failure_criteria_d"], "")) $hd_array["hd_notification_failure_criteria"] .= ",";
		if (isset($hd_array["hd_notification_failure_criteria_d"])) $hd_array["hd_notification_failure_criteria"] .= $hd_array["hd_notification_failure_criteria_d"];
		if (strcmp($hd_array["hd_notification_failure_criteria"], "") && isset($hd_array["hd_notification_failure_criteria_u"]) && strcmp($hd_array["hd_notification_failure_criteria_u"], "")) $hd_array["hd_notification_failure_criteria"] .= ",";
		if (isset($hd_array["hd_notification_failure_criteria_u"])) $hd_array["hd_notification_failure_criteria"] .= $hd_array["hd_notification_failure_criteria_u"];
		if (strcmp($hd_array["hd_notification_failure_criteria"], "") && isset($hd_array["hd_notification_failure_criteria_n"]) && strcmp($hd_array["hd_notification_failure_criteria_n"], "")) $hd_array["hd_notification_failure_criteria"] .= ",";
		if (isset($hd_array["hd_notification_failure_criteria_n"])) $hd_array["hd_notification_failure_criteria"] .= $hd_array["hd_notification_failure_criteria_n"];
		$hd_array["hd_execution_failure_criteria"] = NULL;
		if (isset($hd_array["hd_execution_failure_criteria_o"])) $hd_array["hd_execution_failure_criteria"] .= $hd_array["hd_execution_failure_criteria_o"];
		if (strcmp($hd_array["hd_execution_failure_criteria"], "") && isset($hd_array["hd_execution_failure_criteria_d"])  && strcmp($hd_array["hd_execution_failure_criteria_d"], "")) $hd_array["hd_execution_failure_criteria"] .= ",";
		if (isset($hd_array["hd_execution_failure_criteria_d"])) $hd_array["hd_execution_failure_criteria"] .= $hd_array["hd_execution_failure_criteria_d"];
		if (strcmp($hd_array["hd_execution_failure_criteria"], "") && isset($hd_array["hd_execution_failure_criteria_u"]) && strcmp($hd_array["hd_execution_failure_criteria_u"], "")) $hd_array["hd_execution_failure_criteria"] .= ",";
		if (isset($hd_array["hd_execution_failure_criteria_u"])) $hd_array["hd_execution_failure_criteria"] .= $hd_array["hd_execution_failure_criteria_u"];
		if (strcmp($hd_array["hd_execution_failure_criteria"], "") && isset($hd_array["hd_execution_failure_criteria_n"]) && strcmp($hd_array["hd_execution_failure_criteria_n"], "")) $hd_array["hd_execution_failure_criteria"] .= ",";
		if (isset($hd_array["hd_execution_failure_criteria_n"])) $hd_array["hd_execution_failure_criteria"] .= $hd_array["hd_execution_failure_criteria_n"];
		$hd_object = new HostDependency($hd_array);
		if ($hd_object->is_complete($oreon->user->get_version()) && $hd_object->twiceTest($hds))	{
			$oreon->saveHostDependency($hd_object);
			$hd_id = $oreon->database->database->get_last_id();
			$hds[$hd_id] = $hd_object;
			$hds[$hd_id]->set_id($hd_id);
			if (isset($hd_array["hd_inherits_parent"]))
				$hds[$hd_id]->set_inherits_parent($hd_array["hd_inherits_parent"]);
			if (isset($hd_array["hd_execution_failure_criteria"]))
				$hds[$hd_id]->set_execution_failure_criteria($hd_array["hd_execution_failure_criteria"]);
			$oreon->saveHostDependency($hds[$hd_id]);
			$msg = $lang['errCode'][3];
			// log oreon
			system("echo \"[" . time() . "] AddHostDependency;;" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
			$_GET["o"] = "w";
			$_GET["hd_id"] = $hd_id;
		}
		else
			$msg = $lang['errCode'][$hd_object->get_errCode()];
		unset ($hd_object);
	}

	if (isset($_GET["o"]) && !strcmp($_GET["o"], "d"))	{
		// log oreon
		system("echo \"[" . time() . "] DeleteHostDependency;;" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
		$oreon->deleteHostDependency($hds[$_GET["hd_id"]]);
		unset($_GET["o"]);
		unset($_GET["hd_id"]);
	}

	if (isset($_GET["o"]) && !strcmp($_GET["o"], "l"))	{
		if (isset($_GET["box"]))	{
			$boxx = & $_GET["box"];
			foreach ($boxx as $box)	{
				// log add
				system("echo \"[" . time() . "] DeleteHostDependency;;" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
				$oreon->deleteHostDependency($hds[$box]);
			}
		}
		unset($_GET["o"]);
	}

	// Initialise YES NO or NOTHING Value

	$value_flag["1"] = "YES";
	$value_flag["0"] = "NO";
	$value_flag["2"] = "NOTHING";

	function write_hds_list($hds, $hosts, $lang)	{
		?>
		<table cellpadding="0" cellspacing="0" width="160">
			<tr>
				<td class="tabTableTitleMenu"><? print $lang["m_options"]; ?></td>
			</tr>
			<tr>
				<td class="tabTableMenu">
					<div style="padding: 8px; text-align: center;">
						<img src="img/picto2.gif">
						<a href="phpradmin.php?p=118&o=a" class="text9"><? echo $lang['add']; ?></a>
						<img src="img/picto2_bis.gif">
					</div>
				</td>
			</tr>
		</table>
		<br>
		<table cellpadding="0" cellspacing="0" width="160">
			<tr>
				<td class="tabTableTitleMenu"><? print $lang['hg_available']; ?></td>
			</tr>
			<tr>
				<td class="tabTableMenu">
				 <?
				 if (isset($hds))
					foreach ($hds as $hd)	{ 	?>
						<div style="padding: 2px; white-space: nowrap" align="left">
							<li>
								<a href="phpradmin.php?p=118&hd_id=<? echo $hd->get_id(); ?>&o=w" class="text10" <? if (!$hosts[$hd->get_host()]->get_activate() || !$hosts[$hd->get_host_dependent()]->get_activate()) echo "style='text-decoration: line-through;'"; ?>>
									<? echo $hosts[$hd->get_host()]->get_name() ." / ". $hosts[$hd->get_host_dependent()]->get_name(); ?>
								</a>
							</li>
						</div>
				<? 	unset($hd); }?>
				</td>
			</tr>
		</table><?
	}

	function write_hds_list2(&$hosts, &$hds, $lang)	{	?>
		<form action="" name="hostDependencyMenu" method="get">
			<table cellpadding="3" cellspacing="3">
				<tr>
					<td class="listTop"></td>
					<td align="left" class="listTop" style="padding-left: 20px; padding-right: 20px;"><? echo $lang['h']; ?></td>
					<td align="left" class="listTop" style="padding-left: 20px; padding-right: 20px;"><? echo $lang['hd_dependent']; ?></td>
					<td align="center" class="listTop" style="padding-left: 20px; padding-right: 20px;"><? echo $lang['status']; ?></td>
					<td align="center" class="listTop" style="padding-left: 20px; padding-right: 20px;"><? echo $lang['options']; ?></td>
				</tr>
	<?
		if (!isset($_GET["num"]))
			$num = 1;
		else
			$num = $_GET["num"];
		if (isset($hds) && count($hds) != 0)	{
			$cpt = 0;
			foreach ($hds as $hd)	{
				if ($cpt < (VIEW_MAX * $num) && ($cpt >= ((VIEW_MAX * $num) - (VIEW_MAX)))){	?>
				<tr>
					<td class="listSub<? echo $cpt%2; ?>"><input type="checkbox" name="box[<? echo $hd->get_id(); ?>]" value="<? echo $hd->get_id(); ?>"></td>
					<td align="left" class="listSub<? echo $cpt%2; ?>"><a href="phpradmin.php?p=102&h=<? echo $hd->get_host(); ?>&o=w" class="text11"><? echo $hosts[$hd->get_host()]->get_name(); ?></a></td>
					<td align="left" class="listSub<? echo $cpt%2; ?>"><a href="phpradmin.php?p=102&h=<? echo $hd->get_host_dependent(); ?>&o=w" class="text11"><? echo $hosts[$hd->get_host_dependent()]->get_name(); ?></a></td>
					<td align="center" class="listSub<? echo $cpt%2; ?>"><?  if ($hosts[$hd->get_host()]->get_activate() && $hosts[$hd->get_host_dependent()]->get_activate()) echo $lang['enable']; else echo $lang['disable']; ?></td>
					<td class="listSub<? echo $cpt%2; ?>">
						&nbsp;&nbsp;
						<a href="phpradmin.php?p=118&hd_id=<? echo $hd->get_id(); ?>&o=w" class="text11"><img src="img/listView.gif" border="0" alt="<? echo $lang['view']; ?>" title="<? echo $lang['view']; ?>"></a>&nbsp;
						<a href="phpradmin.php?p=118&hd_id=<? echo $hd->get_id(); ?>&o=c" class="text11"><img src="img/listPen.gif" border="0" alt="<? echo $lang['modify']; ?>" title="<? echo $lang['modify']; ?>"></a>&nbsp;
						<a href="phpradmin.php?p=118&hd_id=<? echo $hd->get_id(); ?>&o=d&num=<? echo $num; ?>&limit=<? echo VIEW_MAX; ?>" class="text11" onclick="return confirm('<? echo $lang['confirm_removing']; ?>')"><img src="img/listDel.gif" border="0" alt="<? echo $lang['delete']; ?>" title="<? echo $lang['delete']; ?>"></a>&nbsp;&nbsp;
					</td>
				</tr>
			<?	}
				unset($hd);
				$cpt++;
				}
			} ?>
			<tr>
				<td colspan="2" valign="top"><img src="img/arrow_ltr.gif" style="padding-left: 5px;">&nbsp;&nbsp;	<a href="#" class="text10bc" onclick=" if (confirm('<? echo $lang['confirm_removing']; ?>')){document.forms['hostDependencyMenu'].submit();}"><? echo $lang['m_delete_selection']; ?></a></td>
				<td></td>
				<td colspan="2" align="right" class="text10">
					<a href="phpradmin.php?p=118&o=a" class="text10bc"><? echo $lang['add']; ?></a>&nbsp;&nbsp;<br><br>
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
					<? $nbrPage = floor(count($hds)/VIEW_MAX); if(count($hds)%VIEW_MAX) $nbrPage++; ?>
					<? echo "<font class='text11b'>".$lang["page"]. ":&nbsp;&nbsp;</font>[&nbsp;&nbsp;";
						for ($i = 1; $i <= $nbrPage; $i++)	{
							if($num == $i)
								echo "<a href='./phpradmin.php?p=118&num=$i&limit=".VIEW_MAX."' class='text10'><b>$i</b></a>&nbsp;&nbsp;";
							else
								echo "<a href='./phpradmin.php?p=118&num=$i&limit=".VIEW_MAX."' class='text10'>$i</a>&nbsp;&nbsp;";
						}
						echo "]";
					?>
				</td>
			</tr>
		</table>
		<input type="hidden" name="p" value="118">
		<input type="hidden" name="o" value="l" id="option">
	</form>
	<? } ?>

<?
if (!isset($_GET["o"]))	{
?>
	<table border="0" align="left">
		<tr>
			<td valign="top"><? write_hds_list2($hosts, $hds, $lang); ?></td>
		</tr>
	</table>
<? } else if (isset($_GET["o"]))	{
		if (isset($_GET["hd_id"]))
			$hd_id = $_GET["hd_id"];
?>
	<table align="left" border="0">
		<tr>
			<td valign="top" align="left"><? write_hds_list($hds, $hosts, $lang); ?></td>
			<td style="padding-left: 20px;"></td>
			<td valign="top" align='left'>
				<? if (isset($msg))
					echo "<div align='center' class='msg' style='padding-bottom: 10px;'>$msg</div>"; ?>
				<table border='0' align="left" cellpadding="0" cellspacing="0" width="400">
					<tr>
						<td align="center" class="tabTableTitle"><? echo "Host Dependency "; if (!strcmp($_GET["o"], "c") || !strcmp($_GET["o"], "w")) {  echo "\"" . $hosts[$hds[$hd_id]->get_host()]->get_name() ." \ ". $hosts[$hds[$hd_id]->get_host_dependent()]->get_name() . "\"";} ?></td>
					</tr>
					<tr>
						<td class="tabTableForTab">
						<? 	if (!strcmp($_GET["o"], "w") || !strcmp($_GET["o"], "c") || !strcmp($_GET["o"], "a"))
								include("./include/configuration/host_dependency/host_dependency_".$_GET["o"].".php"); ?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
<? } ?>