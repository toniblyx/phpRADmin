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

	$sds = & $oreon->sds;
	if (isset($_GET) && array_key_exists("o", $_GET) && $_GET["o"] != "a" && $_GET["o"] != "l")
		if (!isset($_GET["sd_id"]) || (isset($_GET["sd_id"]) && !array_key_exists($_GET["sd_id"], $sds)))	{
			echo "<td width='85%'></td>";
			include ("./footer.php");
			exit();
		}
	$hosts = & $oreon->hosts;
	$services = & $oreon->services;

	if (isset($_POST["ChangeSD"]))	{
		$sd_array = & $_POST["sd"];
		$sd_array["sd_notification_failure_criteria"] = NULL;
		if (isset($sd_array["sd_notification_failure_criteria_o"])) $sd_array["sd_notification_failure_criteria"] .= $sd_array["sd_notification_failure_criteria_o"];
		if (strcmp($sd_array["sd_notification_failure_criteria"], "") && isset($sd_array["sd_notification_failure_criteria_w"])  && strcmp($sd_array["sd_notification_failure_criteria_w"], "")) $sd_array["sd_notification_failure_criteria"] .= ",";
		if (isset($sd_array["sd_notification_failure_criteria_w"])) $sd_array["sd_notification_failure_criteria"] .= $sd_array["sd_notification_failure_criteria_w"];
		if (strcmp($sd_array["sd_notification_failure_criteria"], "") && isset($sd_array["sd_notification_failure_criteria_u"]) && strcmp($sd_array["sd_notification_failure_criteria_u"], "")) $sd_array["sd_notification_failure_criteria"] .= ",";
		if (isset($sd_array["sd_notification_failure_criteria_u"])) $sd_array["sd_notification_failure_criteria"] .= $sd_array["sd_notification_failure_criteria_u"];
		if (strcmp($sd_array["sd_notification_failure_criteria"], "") && isset($sd_array["sd_notification_failure_criteria_c"]) && strcmp($sd_array["sd_notification_failure_criteria_c"], "")) $sd_array["sd_notification_failure_criteria"] .= ",";
		if (isset($sd_array["sd_notification_failure_criteria_c"])) $sd_array["sd_notification_failure_criteria"] .= $sd_array["sd_notification_failure_criteria_c"];
		if (strcmp($sd_array["sd_notification_failure_criteria"], "") && isset($sd_array["sd_notification_failure_criteria_n"]) && strcmp($sd_array["sd_notification_failure_criteria_n"], "")) $sd_array["sd_notification_failure_criteria"] .= ",";
		if (isset($sd_array["sd_notification_failure_criteria_n"])) $sd_array["sd_notification_failure_criteria"] .= $sd_array["sd_notification_failure_criteria_n"];
		$sd_array["sd_execution_failure_criteria"] = NULL;
		if (isset($sd_array["sd_execution_failure_criteria_o"])) $sd_array["sd_execution_failure_criteria"] .= $sd_array["sd_execution_failure_criteria_o"];
		if (strcmp($sd_array["sd_execution_failure_criteria"], "") && isset($sd_array["sd_execution_failure_criteria_w"])  && strcmp($sd_array["sd_execution_failure_criteria_w"], "")) $sd_array["sd_execution_failure_criteria"] .= ",";
		if (isset($sd_array["sd_execution_failure_criteria_w"])) $sd_array["sd_execution_failure_criteria"] .= $sd_array["sd_execution_failure_criteria_w"];
		if (strcmp($sd_array["sd_execution_failure_criteria"], "") && isset($sd_array["sd_execution_failure_criteria_u"]) && strcmp($sd_array["sd_execution_failure_criteria_u"], "")) $sd_array["sd_execution_failure_criteria"] .= ",";
		if (isset($sd_array["sd_execution_failure_criteria_u"])) $sd_array["sd_execution_failure_criteria"] .= $sd_array["sd_execution_failure_criteria_u"];
		if (strcmp($sd_array["sd_execution_failure_criteria"], "") && isset($sd_array["sd_execution_failure_criteria_c"]) && strcmp($sd_array["sd_execution_failure_criteria_c"], "")) $sd_array["sd_execution_failure_criteria"] .= ",";
		if (isset($sd_array["sd_execution_failure_criteria_c"])) $sd_array["sd_execution_failure_criteria"] .= $sd_array["sd_execution_failure_criteria_c"];
		if (strcmp($sd_array["sd_execution_failure_criteria"], "") && isset($sd_array["sd_execution_failure_criteria_n"]) && strcmp($sd_array["sd_execution_failure_criteria_n"], "")) $sd_array["sd_execution_failure_criteria"] .= ",";
		if (isset($sd_array["sd_execution_failure_criteria_n"])) $sd_array["sd_execution_failure_criteria"] .= $sd_array["sd_execution_failure_criteria_n"];
		$sd_object = new ServiceDependency($sd_array);
		if ($sd_object->is_complete($oreon->user->get_version()) && $sd_object->twiceTest($sds))	{
			$oreon->saveServiceDependency($sd_object);
			$sds[$sd_array["sd_id"]] = $sd_object;
			// log oreon
			system("echo \"[" . time() . "] ChangeServiceDependency;" . addslashes($services[$sd_object->get_service()]->get_description()) . "/" . addslashes($hosts[$sd_object->get_host()]->get_name()) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
			if (isset($sd_array["sd_inherits_parent"]))
				$sds[$sd_array["sd_id"]]->set_inherits_parent($sd_array["sd_inherits_parent"]);
			$sds[$sd_array["sd_id"]]->set_execution_failure_criteria($sd_array["sd_execution_failure_criteria"]);
			$sds[$sd_array["sd_id"]]->set_notification_failure_criteria($sd_array["sd_notification_failure_criteria"]);
			$oreon->saveServiceDependency($sds[$sd_array["sd_id"]]);
			$msg = $lang['errCode'][2];
			$_GET["o"] = "w";
		}
		else
			$msg = $lang['errCode'][$sd_object->get_errCode()];
		unset ($sd_object);
	}

	if (isset($_POST["AddSD"]))	{
		$sd_array = & $_POST["sd"];
		$sd_array["sd_id"] = -1;
		$sd_array["sd_notification_failure_criteria"] = NULL;
		if (isset($sd_array["sd_notification_failure_criteria_o"])) $sd_array["sd_notification_failure_criteria"] .= $sd_array["sd_notification_failure_criteria_o"];
		if (strcmp($sd_array["sd_notification_failure_criteria"], "") && isset($sd_array["sd_notification_failure_criteria_w"])  && strcmp($sd_array["sd_notification_failure_criteria_w"], "")) $sd_array["sd_notification_failure_criteria"] .= ",";
		if (isset($sd_array["sd_notification_failure_criteria_w"])) $sd_array["sd_notification_failure_criteria"] .= $sd_array["sd_notification_failure_criteria_w"];
		if (strcmp($sd_array["sd_notification_failure_criteria"], "") && isset($sd_array["sd_notification_failure_criteria_u"]) && strcmp($sd_array["sd_notification_failure_criteria_u"], "")) $sd_array["sd_notification_failure_criteria"] .= ",";
		if (isset($sd_array["sd_notification_failure_criteria_u"])) $sd_array["sd_notification_failure_criteria"] .= $sd_array["sd_notification_failure_criteria_u"];
		if (strcmp($sd_array["sd_notification_failure_criteria"], "") && isset($sd_array["sd_notification_failure_criteria_c"]) && strcmp($sd_array["sd_notification_failure_criteria_c"], "")) $sd_array["sd_notification_failure_criteria"] .= ",";
		if (isset($sd_array["sd_notification_failure_criteria_c"])) $sd_array["sd_notification_failure_criteria"] .= $sd_array["sd_notification_failure_criteria_c"];
		if (strcmp($sd_array["sd_notification_failure_criteria"], "") && isset($sd_array["sd_notification_failure_criteria_n"]) && strcmp($sd_array["sd_notification_failure_criteria_n"], "")) $sd_array["sd_notification_failure_criteria"] .= ",";
		if (isset($sd_array["sd_notification_failure_criteria_n"])) $sd_array["sd_notification_failure_criteria"] .= $sd_array["sd_notification_failure_criteria_n"];
		$sd_array["sd_execution_failure_criteria"] = NULL;
		if (isset($sd_array["sd_execution_failure_criteria_o"])) $sd_array["sd_execution_failure_criteria"] .= $sd_array["sd_execution_failure_criteria_o"];
		if (strcmp($sd_array["sd_execution_failure_criteria"], "") && isset($sd_array["sd_execution_failure_criteria_w"])  && strcmp($sd_array["sd_execution_failure_criteria_w"], "")) $sd_array["sd_execution_failure_criteria"] .= ",";
		if (isset($sd_array["sd_execution_failure_criteria_w"])) $sd_array["sd_execution_failure_criteria"] .= $sd_array["sd_execution_failure_criteria_w"];
		if (strcmp($sd_array["sd_execution_failure_criteria"], "") && isset($sd_array["sd_execution_failure_criteria_u"]) && strcmp($sd_array["sd_execution_failure_criteria_u"], "")) $sd_array["sd_execution_failure_criteria"] .= ",";
		if (isset($sd_array["sd_execution_failure_criteria_u"])) $sd_array["sd_execution_failure_criteria"] .= $sd_array["sd_execution_failure_criteria_u"];
		if (strcmp($sd_array["sd_execution_failure_criteria"], "") && isset($sd_array["sd_execution_failure_criteria_c"]) && strcmp($sd_array["sd_execution_failure_criteria_c"], "")) $sd_array["sd_execution_failure_criteria"] .= ",";
		if (isset($sd_array["sd_execution_failure_criteria_c"])) $sd_array["sd_execution_failure_criteria"] .= $sd_array["sd_execution_failure_criteria_c"];
		if (strcmp($sd_array["sd_execution_failure_criteria"], "") && isset($sd_array["sd_execution_failure_criteria_n"]) && strcmp($sd_array["sd_execution_failure_criteria_n"], "")) $sd_array["sd_execution_failure_criteria"] .= ",";
		if (isset($sd_array["sd_execution_failure_criteria_n"])) $sd_array["sd_execution_failure_criteria"] .= $sd_array["sd_execution_failure_criteria_n"];
		$sd_object = new ServiceDependency($sd_array);
		if ($sd_object->is_complete($oreon->user->get_version()) && $sd_object->twiceTest($sds))	{
			$oreon->saveServiceDependency($sd_object);
			$sd_id = $oreon->database->database->get_last_id();
			$sds[$sd_id] = $sd_object;
			// log oreon
			system("echo \"[" . time() . "] AddServiceDependency;" . addslashes($services[$sd_object->get_service()]->get_description()) . "/" . addslashes($hosts[$sd_object->get_host()]->get_name()) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
			$sds[$sd_id]->set_id($sd_id);
			if (isset($sd_array["sd_inherits_parent"]))
				$sds[$sd_id]->set_inherits_parent($sd_array["sd_inherits_parent"]);
			$sds[$sd_id]->set_execution_failure_criteria($sd_array["sd_execution_failure_criteria"]);
			$sds[$sd_id]->set_notification_failure_criteria($sd_array["sd_notification_failure_criteria"]);
			$oreon->saveServiceDependency($sds[$sd_id]);
			$msg = $lang['errCode'][3];
			$_GET["o"] = "w";
			$_GET["sd_id"] = $sd_id;
		}
		else
			$msg = $lang['errCode'][$sd_object->get_errCode()];
		unset ($sd_object);
	}

	if (isset($_GET["o"]) && !strcmp($_GET["o"], "d"))	{
		// log oreon
		system("echo \"[" . time() . "] DeleteServiceDependency;" .addslashes($services[$sds[$_GET["sd_id"]]->get_service()]->get_description()) . "/" . addslashes($hosts[$sds[$_GET["sd_id"]]->get_host()]->get_name()) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
		$oreon->deleteServiceDependency($sds[$_GET["sd_id"]]);
		unset($_GET["o"]);
		unset($_GET["sd_id"]);
	}

	if (isset($_GET["o"]) && !strcmp($_GET["o"], "l"))	{
		if (isset($_GET["box"]))	{
			$boxx = & $_GET["box"];
			foreach ($boxx as $box)	{
				// log add
				system("echo \"[" . time() . "] DeleteServiceDependency;". addslashes($services[$sds[$box]->get_service()]->get_description()) . "/" .addslashes($hosts[$sds[$box]->get_host()]->get_name()) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
				$oreon->deleteServiceDependency($sds[$box]);
			}
		}
		unset($_GET["o"]);
	}

	// Initialise YES NO or NOTHING Value
	$value_flag["1"] = "YES";
	$value_flag["0"] = "NO";
	$value_flag["2"] = "NOTHING";

	function write_sds_list(&$sds, &$hosts, &$services, $lang)	{
		?>
		<table cellpadding="0" cellspacing="0" width="220">
			<tr>
				<td class="tabTableTitleMenu"><? print $lang["m_options"]; ?></td>
			</tr>
			<tr>
				<td class="tabTableMenu">
					<div style="padding: 8px; text-align: center;">
						<img src="img/picto2.gif">
						<a href="phpradmin.php?p=119&o=a" class="text9"><? echo $lang['add']; ?></a>
						<img src="img/picto2_bis.gif">
					</div>
				</td>
			</tr>
		</table>
		<br>
		<table cellpadding="0" cellspacing="0" width="220">
			<tr>
				<td class="tabTableTitleMenu" style="white-space: nowrap"><? print $lang['sd_available']; ?></td>
			</tr>
			<tr>
				<td class="tabTableMenu">
				 <?
				 if (isset($sds))
					foreach ($sds as $sd)	{ 	?>
						<div style="padding: 2px; white-space: nowrap" align="left">
							<li>
								<a href="phpradmin.php?p=119&sd_id=<? echo $sd->get_id(); ?>&o=w" class="text10" <? if (!$hosts[$sd->get_host()]->get_activate() || !$hosts[$sd->get_host_dependent()]->get_activate() || !$services[$sd->get_service()]->get_activate() || !$services[$sd->get_service_dependent()]->get_activate()) echo "style='text-decoration: line-through;'"; ?>>
									<? echo $hosts[$sd->get_host()]->get_name()." / ".$services[$sd->get_service()]->get_description() ." - ". $hosts[$sd->get_host_dependent()]->get_name()." / ".$services[$sd->get_service_dependent()]->get_description(); ?>
								</a>
							</li>
						</div>
				<? 	unset($sd); } ?>
				</td>
			</tr>
		</table><?
	}

	function write_sds_list2(&$sds, &$hosts, &$services, $lang)	{	?>
		<form action="" name="serviceDependencyMenu" method="get">
			<table cellpadding="3" cellspacing="3">
				<tr>
					<td class="listTop"></td>
					<td align="left" class="listTop" style="padding-left: 10px; padding-right: 10px;"><? echo $lang['h']; ?></td>
					<td align="left" class="listTop" style="padding-left: 10px; padding-right: 10px;"><? echo $lang['s']; ?></td>
					<td align="left" class="listTop" style="padding-left: 10px; padding-right: 10px;"><? echo $lang['hd_dependent']; ?></td>
					<td align="left" class="listTop" style="padding-left: 10px; padding-right: 10px;"><? echo $lang['sd_dependent']; ?></td>
					<td align="center" class="listTop" style="padding-left: 10px; padding-right: 10px;"><? echo $lang['status']; ?></td>
					<td align="center" class="listTop" style="padding-left: 10px; padding-right: 10px;"><? echo $lang['options']; ?></td>
				</tr>
	<?
		if (!isset($_GET["num"]))
			$num = 1;
		else
			$num = $_GET["num"];
		if (isset($sds) && count($sds) != 0)	{
			$cpt = 0;
			foreach ($sds as $sd)	{
				if ($cpt < (VIEW_MAX * $num) && ($cpt >= ((VIEW_MAX * $num) - (VIEW_MAX)))){	?>
				<tr>
					<td class="listSub<? echo $cpt%2; ?>"><input type="checkbox" name="box[<? echo $sd->get_id(); ?>]" value="<? echo $sd->get_id(); ?>"></td>
					<td align="left" class="listSub<? echo $cpt%2; ?>"><a href="phpradmin.php?p=102&h=<? echo $sd->get_host(); ?>&o=w" class="text11"><? echo $hosts[$sd->get_host()]->get_name(); ?></a></td>
					<td align="left" class="listSub<? echo $cpt%2; ?>"><a href="phpradmin.php?p=104&sv=<? echo $sd->get_service(); ?>&o=w" class="text11"><? echo $services[$sd->get_service()]->get_description(); ?></a></td>
					<td align="left" class="listSub<? echo $cpt%2; ?>"><a href="phpradmin.php?p=102&h=<? echo $sd->get_host_dependent(); ?>&o=w" class="text11"><? echo $hosts[$sd->get_host_dependent()]->get_name(); ?></a></td>
					<td align="left" class="listSub<? echo $cpt%2; ?>"><a href="phpradmin.php?p=104&sv=<? echo $sd->get_service_dependent(); ?>&o=w" class="text11"><? echo $services[$sd->get_service_dependent()]->get_description(); ?></a></td>
					<td align="center" class="listSub<? echo $cpt%2; ?>"><? if ($hosts[$sd->get_host()]->get_activate() && $hosts[$sd->get_host_dependent()]->get_activate() && $services[$sd->get_service()]->get_activate() && $services[$sd->get_service_dependent()]->get_activate()) echo $lang['enable']; else echo $lang['disable']; ?></td>
					<td class="listSub<? echo $cpt%2; ?>">
						&nbsp;&nbsp;
						<a href="phpradmin.php?p=119&sd_id=<? echo $sd->get_id(); ?>&o=w" class="text11"><img src="img/listView.gif" border="0" alt="<? echo $lang['view']; ?>" title="<? echo $lang['view']; ?>"></a>&nbsp;
						<a href="phpradmin.php?p=119&sd_id=<? echo $sd->get_id(); ?>&o=c" class="text11"><img src="img/listPen.gif" border="0" alt="<? echo $lang['modify']; ?>" title="<? echo $lang['modify']; ?>"></a>&nbsp;
						<a href="phpradmin.php?p=119&sd_id=<? echo $sd->get_id(); ?>&o=d&num=<? echo $num; ?>&limit=<? echo VIEW_MAX; ?>" class="text11" onclick="return confirm('<? echo $lang['confirm_removing']; ?>')"><img src="img/listDel.gif" border="0" alt="<? echo $lang['delete']; ?>" title="<? echo $lang['delete']; ?>"></a>&nbsp;&nbsp;
					</td>
				</tr>
			<?	}
				unset($sd);
				$cpt++;
				}
			} ?>
			<tr>
				<td colspan="2" valign="top"><img src="img/arrow_ltr.gif" style="padding-left: 5px;">&nbsp;&nbsp;	<a href="#" class="text10bc" onclick=" if (confirm('<? echo $lang['confirm_removing']; ?>')){document.forms['serviceDependencyMenu'].submit();}"><? echo $lang['m_delete_selection']; ?></a></td>
				<td></td>
				<td colspan="4" align="right" class="text10">
					<a href="phpradmin.php?p=119&o=a" class="text10bc"><? echo $lang['add']; ?></a>&nbsp;&nbsp;<br><br>
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
				<td align="center" colspan="7">
					<? $nbrPage = floor(count($sds)/VIEW_MAX); if(count($sds)%VIEW_MAX) $nbrPage++; ?>
					<? echo "<font class='text11b'>".$lang["page"]. ":&nbsp;&nbsp;</font>[&nbsp;&nbsp;";
						for ($i = 1; $i <= $nbrPage; $i++)	{
							if($num == $i)
								echo "<a href='./phpradmin.php?p=119&num=$i&limit=".VIEW_MAX."' class='text10'><b>$i</b></a>&nbsp;&nbsp;";
							else
								echo "<a href='./phpradmin.php?p=119&num=$i&limit=".VIEW_MAX."' class='text10'>$i</a>&nbsp;&nbsp;";
						}
						echo "]";
					?>
				</td>
			</tr>
		</table>
		<input type="hidden" name="p" value="119">
		<input type="hidden" name="o" value="l" id="option">
	</form>
	<? } 

if (!isset($_GET["o"]))	{	?>
	<table border="0" align="left">
		<tr>
			<td valign="top" align="center"><? write_sds_list2($sds, $hosts, $services, $lang); ?></td>
		</tr>
	</table><? 
} else if (isset($_GET["o"]))	{
		if (isset($_GET["sd_id"]))
			$sd_id = $_GET["sd_id"];?>
	<table align="left" border="0">
		<tr>
			<td valign="top" align="left"><? write_sds_list($sds, $hosts, $services, $lang); ?></td>
			<td valign="top" style="padding-left: 20px;"></td>
			<td valign="top" align='left'>
				<? if (isset($msg))
					echo "<div align='center' class='msg' style='padding-bottom: 10px;'>$msg</div>"; ?>
				<table border='0' align="left" cellpadding="0" cellspacing=0>
					<tr>
						<td align="center" class="tabTableTitle" style="white-space: nowrap;">Service Dependency <? if (!strcmp($_GET["o"], "c") || !strcmp($_GET["o"], "w")) {  echo "\"" . $hosts[$sds[$sd_id]->get_host()]->get_name() ." \ ". $hosts[$sds[$sd_id]->get_host_dependent()]->get_name() . "\"";} ?></td>
					</tr>
					<tr>
						<td class="tabTableForTab">
							<? 	if (!strcmp($_GET["o"], "w") || !strcmp($_GET["o"], "c") || !strcmp($_GET["o"], "a"))
								include("./include/configuration/service_dependency/service_dependency_".$_GET["o"].".php"); ?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
<? } ?>