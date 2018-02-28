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

	$ses = & $oreon->ses;
	if (isset($_GET) && array_key_exists("o", $_GET) && $_GET["o"] != "a" && $_GET["o"] != "l")
		if (!isset($_GET["se_id"]) || (isset($_GET["se_id"]) && !array_key_exists($_GET["se_id"], $ses)))	{
			echo "<td width='85%'></td>";
			include ("./footer.php");
			exit();
		}
	$timeperiods = & $oreon->time_periods;
	$services = & $oreon->services;
	$hosts = & $oreon->hosts;
	$contactGroups = & $oreon->contactGroups;

	if (!isset($oreon->user)){
		$lang = $oreon->user->get_lang();
	}
	if (isset($_POST["ChangeSE"]))	{
		$se_array = & $_POST["se"];

		$se_array["se_escalation_options"] = NULL;
		if (isset($se_array["se_escalation_options_w"])) $se_array["se_escalation_options"] .= $se_array["se_escalation_options_w"];
		if (strcmp($se_array["se_escalation_options"], "") && isset($se_array["se_escalation_options_u"])  && strcmp($se_array["se_escalation_options_w"], "")) $se_array["se_escalation_options"] .= ",";
		if (isset($se_array["se_escalation_options_u"])) $se_array["se_escalation_options"] .= $se_array["se_escalation_options_u"];
		if (strcmp($se_array["se_escalation_options"], "") && isset($se_array["se_escalation_options_c"]) && strcmp($se_array["se_escalation_options_u"], "")) $se_array["se_escalation_options"] .= ",";
		if (isset($se_array["se_escalation_options_c"])) $se_array["se_escalation_options"] .= $se_array["se_escalation_options_c"];
		if (strcmp($se_array["se_escalation_options"], "") && isset($se_array["se_escalation_options_r"]) && strcmp($se_array["se_escalation_options_r"], "")) $se_array["se_escalation_options"] .= ",";
		if (isset($se_array["se_escalation_options_r"])) $se_array["se_escalation_options"] .= $se_array["se_escalation_options_r"];

		// Manage value 0
		if (isset($se_array["se_notification_interval"]) && !$se_array["se_notification_interval"])
			$se_array["se_notification_interval"] = 99999;
		if (isset($se_array["se_last_notification"]) && !$se_array["se_last_notification"])
			$se_array["se_last_notification"] = 99999;

		$se_object = new ServiceEscalation($se_array);
		if (isset($_POST["selectContactGroup"]))	{
			$selectContactGroup = $_POST["selectContactGroup"];
			for ($i = 0; $i < count($selectContactGroup); $i++)
				$se_object->contactGroups[$selectContactGroup[$i]] = & $contactGroups[$selectContactGroup[$i]];
		}

		if ($se_object->is_complete($oreon->user->get_version()) && $se_object->twiceTest($ses))	{
			$oreon->saveServiceEscalation($se_object);
			$ses[$se_array["se_id"]] = $se_object;
			// log oreon
			system("echo \"[" . time() . "] ChangeServiceEscalation;" . addslashes($services[$se_object->get_service()]->get_description()) . "/" . addslashes($hosts[$se_object->get_host()]->get_name()) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
			if (isset($se_array["timeperiod_tp_id"]) && $se_array["timeperiod_tp_id"])
				$ses[$se_array["se_id"]]->set_escalation_period($se_array["timeperiod_tp_id"]);
			else
				$ses[$se_array["se_id"]]->set_escalation_period(NULL);
			$ses[$se_array["se_id"]]->set_escalation_options($se_array["se_escalation_options"]);
			$oreon->saveServiceEscalation($ses[$se_array["se_id"]]);
			$msg = $lang['errCode'][2];
			$_GET["o"] = "w";
		}
		else
			$msg = $lang['errCode'][$se_object->get_errCode()];
		unset ($se_object);
	} else if (isset($_POST["AddSE"]))	{
		$se_array = & $_POST["se"];
		$se_array["se_id"] = -1;

		$se_array["se_escalation_options"] = NULL;
		if (isset($se_array["se_escalation_options_w"])) $se_array["se_escalation_options"] .= $se_array["se_escalation_options_w"];
		if (strcmp($se_array["se_escalation_options"], "") && isset($se_array["se_escalation_options_u"])  && strcmp($se_array["se_escalation_options_w"], "")) $se_array["se_escalation_options"] .= ",";
		if (isset($se_array["se_escalation_options_u"])) $se_array["se_escalation_options"] .= $se_array["se_escalation_options_u"];
		if (strcmp($se_array["se_escalation_options"], "") && isset($se_array["se_escalation_options_c"]) && strcmp($se_array["se_escalation_options_u"], "")) $se_array["se_escalation_options"] .= ",";
		if (isset($se_array["se_escalation_options_c"])) $se_array["se_escalation_options"] .= $se_array["se_escalation_options_c"];
		if (strcmp($se_array["se_escalation_options"], "") && isset($se_array["se_escalation_options_r"]) && strcmp($se_array["se_escalation_options_r"], "")) $se_array["se_escalation_options"] .= ",";
		if (isset($se_array["se_escalation_options_r"])) $se_array["se_escalation_options"] .= $se_array["se_escalation_options_r"];

		// Manage value 0
		if (isset($se_array["se_notification_interval"]) && !$se_array["se_notification_interval"])
			$se_array["se_notification_interval"] = 99999;
		if (isset($se_array["se_last_notification"]) && !$se_array["se_last_notification"])
			$se_array["se_last_notification"] = 99999;

		$se_object = new ServiceEscalation($se_array);
		if (isset($_POST["selectContactGroup"]))	{
			$selectContactGroup = $_POST["selectContactGroup"];
			for ($i = 0; $i < count($selectContactGroup); $i++)
				$se_object->contactGroups[$selectContactGroup[$i]] = & $contactGroups[$selectContactGroup[$i]];
		}

		if ($se_object->is_complete($oreon->user->get_version()) && $se_object->twiceTest($ses))	{
			$oreon->saveServiceEscalation($se_object);
			$se_id = $oreon->database->database->get_last_id();
			$ses[$se_id] = $se_object;
			// log oreon
			system("echo \"[" . time() . "] AddServiceEscalation;" . addslashes($services[$se_object->get_service()]->get_description()) . "/" . addslashes($hosts[$se_object->get_host()]->get_name()) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
			$ses[$se_id]->set_id($se_id);
			if (isset($se_array["timeperiod_tp_id"]) && $se_array["timeperiod_tp_id"])
				$ses[$se_id]->set_escalation_period($se_array["timeperiod_tp_id"]);
			else
				$ses[$se_id]->set_escalation_period(NULL);
			$ses[$se_id]->set_escalation_options($se_array["se_escalation_options"]);
			$oreon->saveServiceEscalation($ses[$se_id]);
			$msg = $lang['errCode'][3];
			$_GET["o"] = "w";
			$_GET["se_id"] = $se_id;
		}
		else
			$msg = $lang['errCode'][$se_object->get_errCode()];
		unset ($se_object);
	}
	if (isset($_GET["o"]) && !strcmp($_GET["o"], "d"))	{
		// log oreon
		system("echo \"[" . time() . "] DeleteServiceEscalation;" . addslashes($services[$ses[$_GET["se_id"]]->get_service()]->get_description()) . "/" . addslashes($hosts[$ses[$_GET["se_id"]]->get_host()]->get_name()) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
		$oreon->deleteServiceEscalation($ses[$_GET["se_id"]]);
		unset($_GET["o"]);
		unset($_GET["se_id"]);
	} else if (isset($_GET["o"]) && !strcmp($_GET["o"], "l"))	{
		if (isset($_GET["box"]))	{
			$boxx = & $_GET["box"];
			foreach ($boxx as $box)	{
				// log add
				system("echo \"[" . time() . "] DeleteServiceEscalation;" . addslashes($services[$ses[$box]->get_service()]->get_description()) . "/" . addslashes($hosts[$ses[$box]->get_host()]->get_name()) . ";" . addslashes($oreon->user->get_alias()) . "\" > ./include/log/" . date("Ymd") . ".txt");
				$oreon->deleteServiceEscalation($ses[$box]);
			}
		}
		unset($_GET["o"]);
	}

	function write_ses_list(&$ses, &$hosts, &$services, $lang)	{
		?>
		<table cellpadding="0" cellspacing="0" width="200">
			<tr>
				<td class="tabTableTitleMenu"><? print $lang["m_options"]; ?></td>
			</tr>
			<tr>
				<td class="tabTableMenu">
					<div style="padding: 8px; text-align: center;">
						<img src="img/picto2.gif">
							<a href="phpradmin.php?p=117&o=a" class="text9"><? echo $lang['add']; ?></a>
						<img src="img/picto2_bis.gif">
					</div>
				</td>
			</tr>
		</table>
		<br>
		<table cellpadding="0" cellspacing="0" width="200">
			<tr>
				<td class="tabTableTitleMenu" style="white-space: nowrap"><? print $lang['se_available']; ?></td>
			</tr>
			<tr>
				<td class="tabTableMenu">
				 <?
				 if (isset($ses))
					foreach ($ses as $se)	{ 	?>
						<div style="padding: 2px; white-space: nowrap" align="left">
							<li>
								<a href="phpradmin.php?p=117&se_id=<? echo $se->get_id(); ?>&o=w" class="text10" <? if(!$hosts[$se->get_host()]->get_activate()) echo "style='text-decoration: line-through;'"; ?>>
									<? echo $hosts[$se->get_host()]->get_name()." / ".$services[$se->get_service()]->get_description(); ?>
								</a>
							</li>
						</div>
				<? 	unset($se); }?>
				</td>
			</tr>
		</table><?
	}

	function write_ses_list2(&$ses, &$hosts, &$services, $lang)	{	?>
		<form action="" name="serviceEscalationMenu" method="get">
			<table cellpadding="3" cellspacing="3">
				<tr>
					<td class="listTop"></td>
					<td align="left" class="listTop" style="padding-left: 20px; padding-right: 20px;"><? echo $lang['h']; ?></td>
					<td align="left" class="listTop" style="padding-left: 20px; padding-right: 20px;"><? echo $lang['s']; ?></td>
					<td align="center" class="listTop" style="padding-left: 20px; padding-right: 20px;"><? echo $lang['status']; ?></td>
					<td align="center" class="listTop" style="padding-left: 20px; padding-right: 20px;"><? echo $lang['options']; ?></td>
				</tr>
	<?
		if (!isset($_GET["num"]))
			$num = 1;
		else
			$num = $_GET["num"];
		if (isset($ses) && count($ses) != 0)	{
			$cpt = 0;
			foreach ($ses as $se)	{
				if ($cpt < (VIEW_MAX * $num) && ($cpt >= ((VIEW_MAX * $num) - (VIEW_MAX)))){	?>
				<tr>
					<td class="listSub<? echo $cpt%2; ?>"><input type="checkbox" name="box[<? echo $se->get_id(); ?>]" value="<? echo $se->get_id(); ?>"></td>
					<td align="left" class="listSub<? echo $cpt%2; ?>"><a href="phpradmin.php?p=102&h=<? echo $se->get_host(); ?>&o=w" class="text11"><? echo $hosts[$se->get_host()]->get_name(); ?></a></td>
					<td align="left" class="listSub<? echo $cpt%2; ?>"><a href="phpradmin.php?p=104&sv=<? echo $se->get_service(); ?>&o=w" class="text11"><? echo $services[$se->get_service()]->get_description(); ?></a></td>
					<td align="center" class="listSub<? echo $cpt%2; ?>"><? if($hosts[$se->get_host()]->get_activate()) echo $lang['enable']; else echo $lang['disable']; ?></td>
					<td class="listSub<? echo $cpt%2; ?>">
						&nbsp;&nbsp;
						<a href="phpradmin.php?p=117&se_id=<? echo $se->get_id(); ?>&o=w" class="text11"><img src="img/listView.gif" border="0" alt="<? echo $lang['view']; ?>" title="<? echo $lang['view']; ?>"></a>&nbsp;
						<a href="phpradmin.php?p=117&se_id=<? echo $se->get_id(); ?>&o=c" class="text11"><img src="img/listPen.gif" border="0" alt="<? echo $lang['modify']; ?>" title="<? echo $lang['modify']; ?>"></a>&nbsp;
						<a href="phpradmin.php?p=117&se_id=<? echo $se->get_id(); ?>&o=d&num=<? echo $num; ?>&limit=<? echo VIEW_MAX; ?>" class="text11" onclick="return confirm('<? echo $lang['confirm_removing']; ?>')"><img src="img/listDel.gif" border="0" alt="<? echo $lang['delete']; ?>" title="<? echo $lang['delete']; ?>"></a>&nbsp;&nbsp;
					</td>
				</tr>
			<?	}
				unset($se);
				$cpt++;
				}
			} ?>
			<tr>
				<td colspan="2" valign="top"><img src="img/arrow_ltr.gif" style="padding-left: 5px;">&nbsp;&nbsp;	<a href="#" class="text10bc" onclick=" if (confirm('<? echo $lang['confirm_removing']; ?>')){document.forms['serviceEscalationMenu'].submit();}"><? echo $lang['m_delete_selection']; ?></a></td>
				<td></td>
				<td colspan="2" align="right" class="text10">
					<a href="phpradmin.php?p=117&o=a" class="text10bc"><? echo $lang['add']; ?></a>&nbsp;&nbsp;<br><br>
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
					<? $nbrPage = floor(count($ses)/VIEW_MAX); if(count($ses)%VIEW_MAX) $nbrPage++; ?>
					<? echo "<font class='text11b'>".$lang["page"]. ":&nbsp;&nbsp;</font>[&nbsp;&nbsp;";
						for ($i = 1; $i <= $nbrPage; $i++)	{
							if($num == $i)
								echo "<a href='./phpradmin.php?p=117&num=$i&limit=".VIEW_MAX."' class='text10'><b>$i</b></a>&nbsp;&nbsp;";
							else
								echo "<a href='./phpradmin.php?p=117&num=$i&limit=".VIEW_MAX."' class='text10'>$i</a>&nbsp;&nbsp;";
						}
						echo "]";
					?>
				</td>
			</tr>
		</table>
		<input type="hidden" name="p" value="117">
		<input type="hidden" name="o" value="l" id="option">
	</form>
	<? } ?>

<? if (!isset($_GET["o"]))	{ ?>
	<table border="0">
		<tr>
			<td valign="top" align="left"><? write_ses_list2($ses, $hosts, $services, $lang); ?></td>
		</tr>
	</table>
<? } else if (isset($_GET["o"]))	{
		if (!strcmp($_GET["o"], "c") || !strcmp($_GET["o"], "w"))
			$se_id = $_GET["se_id"];
?>
	<table align="left" border="0">
		<tr>
			<td align="left" valign="top"><? write_ses_list($ses, $hosts, $services, $lang); ?></td>
			<td valign="top" style="padding-left: 20px;"></td>
			<td valign="top" align='left'>
				<? if (isset($msg))
					echo "<div align='center' class='msg' style='padding-bottom: 10px;'>$msg</div>";?>
				<table border='0' align="left" cellpadding="0" cellspacing="0">
					<tr>
						<td class="tabTableTitle" style="white-space: nowrap;">Service Escalation <? if (!strcmp($_GET["o"], "c") || !strcmp($_GET["o"], "w")) {  echo "\"" . $services[$ses[$se_id]->get_service()]->get_description() ." \ ". $hosts[$ses[$se_id]->get_host()]->get_name() . "\"";} ?></td>
					</tr>
					<tr>
						<td class="tabTableForTab">
						<? 	if (!strcmp($_GET["o"], "w") || !strcmp($_GET["o"], "c") || !strcmp($_GET["o"], "a"))
								include("./include/configuration/service_escalation/service_escalation_".$_GET["o"].".php"); ?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
<? } ?>