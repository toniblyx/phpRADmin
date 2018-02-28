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

	if (!isset($_GET["limit"]))
		$limit = 20;
	else
		$limit = $_GET["limit"];
	define("VIEW_MAX", $limit);

	$htms = & $oreon->htms;
	if (isset($_GET) && array_key_exists("o", $_GET) && $_GET["o"] != "a" && $_GET["o"] != "l")
		if (!isset($_GET["htm_id"]) || (isset($_GET["htm_id"]) && !array_key_exists($_GET["htm_id"], $htms)))	{
			echo "<td width='85%'></td>";
			include ("./footer.php");
			exit();
		}
	$hosts = & $oreon->hosts;
	$hostGroups = & $oreon->hostGroups;
	$services = & $oreon->services;
	$timePeriods = & $oreon->time_periods;
	$commands = & $oreon->commands;
	$contactGroups = & $oreon->contactGroups;

	if (isset($_POST["AddHTM"]))	{
		$htm_array = & $_POST["htm"];
		$htm_array["host_id"] = -1;
		// Concat options
		$htm_array["host_stalking_options"] = NULL;
		if (isset($htm_array["host_stalking_options_o"])) $htm_array["host_stalking_options"].= $htm_array["host_stalking_options_o"];
		if (strcmp($htm_array["host_stalking_options"], "") && isset($htm_array["host_stalking_options_d"])  && strcmp($htm_array["host_stalking_options_d"], "")) $htm_array["host_stalking_options"].= ",";
		if (isset($htm_array["host_stalking_options_d"])) $htm_array["host_stalking_options"].= $htm_array["host_stalking_options_d"];
		if (strcmp($htm_array["host_stalking_options"], "") && isset($htm_array["host_stalking_options_u"]) && strcmp($htm_array["host_stalking_options_u"], "")) $htm_array["host_stalking_options"].= ",";
		if (isset($htm_array["host_stalking_options_u"])) $htm_array["host_stalking_options"].= $htm_array["host_stalking_options_u"];
		// Concat options
		$htm_array["host_notification_options"] = NULL;
		if (isset($htm_array["host_notification_options_d"])) $htm_array["host_notification_options"].= $htm_array["host_notification_options_d"];
		if (strcmp($htm_array["host_notification_options"], "") && isset($htm_array["host_notification_options_u"]) && strcmp($htm_array["host_notification_options_u"], "")) $htm_array["host_notification_options"].= ",";
		if (isset($htm_array["host_notification_options_u"])) $htm_array["host_notification_options"].= $htm_array["host_notification_options_u"];
		if (strcmp($htm_array["host_notification_options"], "") && isset($htm_array["host_notification_options_r"]) && strcmp($htm_array["host_notification_options_r"], "")) $htm_array["host_notification_options"].= ",";
		if (isset($htm_array["host_notification_options_r"]))$htm_array["host_notification_options"].= $htm_array["host_notification_options_r"];

		if (isset($htm_array["host_check_interval"]) && !$htm_array["host_check_interval"])
			$htm_array["host_check_interval"] = 99999;
		if (isset($htm_array["host_freshness_threshold"]) && !$htm_array["host_freshness_threshold"])
			$htm_array["host_freshness_threshold"] = 99999;
		else if (!isset($htm_array["host_freshness_threshold"]) && isset($htm_array["ftNothingBox"]))
			$htm_array["host_freshness_threshold"] = 0;
		if (isset($htm_array["host_low_flap_threshold"]) && !$htm_array["host_low_flap_threshold"])
			$htm_array["host_low_flap_threshold"] = 99999;
		else if (!isset($htm_array["host_low_flap_threshold"]) && isset($htm_array["lftNothingBox"]))
			$htm_array["host_low_flap_threshold"] = 0;
		if (isset($htm_array["host_high_flap_threshold"]) && !$htm_array["host_high_flap_threshold"])
			$htm_array["host_high_flap_threshold"] = 99999;
		else if (!isset($htm_array["host_high_flap_threshold"]) && isset($htm_array["hftNothingBox"]))
			$htm_array["host_high_flap_threshold"] = 0;
		if (isset($htm_array["host_notification_interval"]) && !$htm_array["host_notification_interval"])
			$htm_array["host_notification_interval"] = 99999;
		if (isset($htm_array["host_comment"]) && !$htm_array["host_comment"])
			$htm_array["host_comment"] = "#BLANK#";

		$host_object = new Host($htm_array);
		if (isset($_POST["selectContactGroup"]))	{
			$selectContactGroup = $_POST["selectContactGroup"];
			for ($i = 0; $i < count($selectContactGroup); $i++)
				$host_object->contactgroups[$selectContactGroup[$i]] = & $contactGroups[$selectContactGroup[$i]];
		}	else
				$host_object->contactgroups = array();
		// log add
		system("echo \"[".time()."] AddHostTemplate;".addslashes($host_object->get_name()).";".addslashes($oreon->user->get_alias())."\" >>./include/log/".date("Ymd").".txt");
		$oreon->saveHost($host_object);
		$htm_id = $oreon->database->database->get_last_id();
		if (!$htm_array["host_name"])
			$host_object->set_name("HTemplate_".$htm_id);
		else
			$host_object->set_name("HTemplate_".str_replace(" ", "_", $htm_array["host_name"]));
		$htm_array["htm_id"] = $htm_id;
		$htm_object = new HostTemplateModel($htm_array);
		$htms[$htm_id] = $htm_object;
		$hosts[$htm_id] = $host_object;
		$hosts[$htm_id]->set_id($htm_id);
		if (isset($htm_array["command_command_id"])) $hosts[$htm_id]->set_check_command($htm_array["command_command_id"]);
		if (isset($htm_array["command_command_id2"])) $hosts[$htm_id]->set_event_handler($htm_array["command_command_id2"]);
		if (isset($htm_array["timeperiod_tp_id"])) $hosts[$htm_id]->set_check_period($htm_array["timeperiod_tp_id"]);
		if (isset($htm_array["timeperiod_tp_id2"])) $hosts[$htm_id]->set_notification_period($htm_array["timeperiod_tp_id2"]);
		if (isset($htm_array["host_check_interval"])) $hosts[$htm_id]->set_check_interval($htm_array["host_check_interval"]);
		if (isset($htm_array["host_active_checks_enabled"])) $hosts[$htm_id]->set_active_checks_enabled($htm_array["host_active_checks_enabled"]);
		if (isset($htm_array["host_passive_checks_enabled"])) $hosts[$htm_id]->set_passive_checks_enabled($htm_array["host_passive_checks_enabled"]);
		if (isset($htm_array["host_check_enabled"])) $hosts[$htm_id]->set_checks_enabled($htm_array["host_check_enabled"]);
		if (isset($htm_array["host_obsess_over_host"])) $hosts[$htm_id]->set_obsess_over_host($htm_array["host_obsess_over_host"]);
		if (isset($htm_array["host_check_freshness"])) $hosts[$htm_id]->set_check_freshness($htm_array["host_check_freshness"]);
		if (isset($htm_array["host_freshness_threshold"])) $hosts[$htm_id]->set_freshness_threshold($htm_array["host_freshness_threshold"]);
		if (isset($htm_array["host_event_handler_enabled"])) $hosts[$htm_id]->set_event_handler_enabled($htm_array["host_event_handler_enabled"]);
		if (isset($htm_array["host_low_flap_threshold"])) $hosts[$htm_id]->set_low_flap_threshold($htm_array["host_low_flap_threshold"]);
		if (isset($htm_array["host_high_flap_threshold"])) $hosts[$htm_id]->set_high_flap_threshold($htm_array["host_high_flap_threshold"]);
		if (isset($htm_array["host_flap_detection_enabled"])) $hosts[$htm_id]->set_flap_detection_enabled($htm_array["host_flap_detection_enabled"]);
		if (isset($htm_array["host_process_perf_data"])) $hosts[$htm_id]->set_process_perf_data($htm_array["host_process_perf_data"]);
		if (isset($htm_array["host_retain_status_information"])) $hosts[$htm_id]->set_retain_status_information($htm_array["host_retain_status_information"]);
		if (isset($htm_array["host_retain_nonstatus_information"])) $hosts[$htm_id]->set_retain_nonstatus_information($htm_array["host_retain_nonstatus_information"]);
		if (isset($htm_array["host_notifications_enabled"])) $hosts[$htm_id]->set_notifications_enabled($htm_array["host_notifications_enabled"]);
		if (isset($htm_array["host_stalking_options"])) $hosts[$htm_id]->set_stalking_options($htm_array["host_stalking_options"]);
		if (isset($htm_array["host_comment"])) $hosts[$htm_id]->set_comment($htm_array["host_comment"]);
		$hosts[$htm_id]->set_register(0);
		$hosts[$htm_id]->set_activate(1);
		if (isset($_POST["selectHostParent"]))	{
			$selectHostParent = $_POST["selectHostParent"];
			for ($i = 0; $i < count($selectHostParent); $i++)
				$hosts[$htm_id]->parents[$selectHostParent[$i]] = & $hosts[$selectHostParent[$i]];
		}	else
				$hosts[$htm_id]->parents = array();
		if (isset($_POST["selectHostGroup"]))	{
			$selectHostGroup = $_POST["selectHostGroup"];
			for ($i = 0; $i < count($selectHostGroup); $i++)
				$hosts[$htm_id]->hostGroups[$selectHostGroup[$i]] = & $hostGroups[$selectHostGroup[$i]];
		}	else
				$hosts[$htm_id]->hostGroups = array();
		$oreon->saveHost($hosts[$htm_id]);
		$msg = $lang['errCode'][3];
		unset($host_object);
		unset($htm_object);
		$_GET["o"] = "w";
		$_GET["htm_id"] = $htm_id;
	}

	if (isset($_POST["ChangeHTM"]))	{
		$htm_array = & $_POST["htm"];
		$htm_id = $htm_array["htm_id"];
		// We keep Old Host Template
		$host_temp = $hosts[$htm_id];

		// Init Host Template
		$htm_array["host_id"] = $htm_id;
		// Concat options
		$htm_array["host_stalking_options"] = NULL;
		if (isset($htm_array["host_stalking_options_o"])) $htm_array["host_stalking_options"].= $htm_array["host_stalking_options_o"];
		if (strcmp($htm_array["host_stalking_options"], "") && isset($htm_array["host_stalking_options_d"])  && strcmp($htm_array["host_stalking_options_d"], "")) $htm_array["host_stalking_options"].= ",";
		if (isset($htm_array["host_stalking_options_d"])) $htm_array["host_stalking_options"].= $htm_array["host_stalking_options_d"];
		if (strcmp($htm_array["host_stalking_options"], "") && isset($htm_array["host_stalking_options_u"]) && strcmp($htm_array["host_stalking_options_u"], "")) $htm_array["host_stalking_options"].= ",";
		if (isset($htm_array["host_stalking_options_u"])) $htm_array["host_stalking_options"].= $htm_array["host_stalking_options_u"];
		// Concat options
		$htm_array["host_notification_options"] = NULL;
		if (isset($htm_array["host_notification_options_d"])) $htm_array["host_notification_options"].= $htm_array["host_notification_options_d"];
		if (strcmp($htm_array["host_notification_options"], "") && isset($htm_array["host_notification_options_u"]) && strcmp($htm_array["host_notification_options_u"], "")) $htm_array["host_notification_options"].= ",";
		if (isset($htm_array["host_notification_options_u"])) $htm_array["host_notification_options"].= $htm_array["host_notification_options_u"];
		if (strcmp($htm_array["host_notification_options"], "") && isset($htm_array["host_notification_options_r"]) && strcmp($htm_array["host_notification_options_r"], "")) $htm_array["host_notification_options"].= ",";
		if (isset($htm_array["host_notification_options_r"]))$htm_array["host_notification_options"].= $htm_array["host_notification_options_r"];

		if (isset($htm_array["host_check_interval"]) && !$htm_array["host_check_interval"])
			$htm_array["host_check_interval"] = 99999;
		if (isset($htm_array["host_freshness_threshold"]) && !$htm_array["host_freshness_threshold"])
			$htm_array["host_freshness_threshold"] = 99999;
		else if (!isset($htm_array["host_freshness_threshold"]) && isset($htm_array["ftNothingBox"]))
			$htm_array["host_freshness_threshold"] = 0;
		if (isset($htm_array["host_low_flap_threshold"]) && !$htm_array["host_low_flap_threshold"])
			$htm_array["host_low_flap_threshold"] = 99999;
		else if (!isset($htm_array["host_low_flap_threshold"]) && isset($htm_array["lftNothingBox"]))
			$htm_array["host_low_flap_threshold"] = 0;
		if (isset($htm_array["host_high_flap_threshold"]) && !$htm_array["host_high_flap_threshold"])
			$htm_array["host_high_flap_threshold"] = 99999;
		else if (!isset($htm_array["host_high_flap_threshold"]) && isset($htm_array["hftNothingBox"]))
			$htm_array["host_high_flap_threshold"] = 0;
		if (isset($htm_array["host_notification_interval"]) && !$htm_array["host_notification_interval"])
			$htm_array["host_notification_interval"] = 99999;
		if (isset($htm_array["host_comment"]) && !$htm_array["host_comment"])
			$htm_array["host_comment"] = "#BLANK#";

		// Replace white space
		if (!$htm_array["host_name"])
			$htm_array["host_name"] = "HTemplate_".$htm_id;
		if (!strstr($htm_array["host_name"], "HTemplate_"))
			$htm_array["host_name"] = "HTemplate_".$htm_array["host_name"];
		$host_object = new Host($htm_array);
		// log add
		system("echo \"[".time()."] ModifHostTemplate;".addslashes($host_object->get_name()).";".addslashes($oreon->user->get_alias())."\" >>./include/log/".date("Ymd").".txt");
		if (isset($_POST["selectContactGroup"]))	{
			$selectContactGroup = $_POST["selectContactGroup"];
			for ($i = 0; $i < count($selectContactGroup); $i++)
				$host_object->contactgroups[$selectContactGroup[$i]] = & $contactGroups[$selectContactGroup[$i]];
		}	else
				$host_object->contactgroups = array();
		$hosts[$htm_id] = $host_object;
		if (isset($htm_array["command_command_id"])) $hosts[$htm_id]->set_check_command($htm_array["command_command_id"]);
		if (isset($htm_array["command_command_id2"])) $hosts[$htm_id]->set_event_handler($htm_array["command_command_id2"]);
		if (isset($htm_array["timeperiod_tp_id"])) $hosts[$htm_id]->set_check_period($htm_array["timeperiod_tp_id"]);
		if (isset($htm_array["timeperiod_tp_id2"])) $hosts[$htm_id]->set_notification_period($htm_array["timeperiod_tp_id2"]);
		if (isset($htm_array["host_check_interval"])) $hosts[$htm_id]->set_check_interval($htm_array["host_check_interval"]);
		if (isset($htm_array["host_active_checks_enabled"])) $hosts[$htm_id]->set_active_checks_enabled($htm_array["host_active_checks_enabled"]);
		if (isset($htm_array["host_passive_checks_enabled"])) $hosts[$htm_id]->set_passive_checks_enabled($htm_array["host_passive_checks_enabled"]);
		if (isset($htm_array["host_check_enabled"])) $hosts[$htm_id]->set_checks_enabled($htm_array["host_check_enabled"]);
		if (isset($htm_array["host_obsess_over_host"])) $hosts[$htm_id]->set_obsess_over_host($htm_array["host_obsess_over_host"]);
		if (isset($htm_array["host_check_freshness"])) $hosts[$htm_id]->set_check_freshness($htm_array["host_check_freshness"]);
		if (isset($htm_array["host_freshness_threshold"])) $hosts[$htm_id]->set_freshness_threshold($htm_array["host_freshness_threshold"]);
		if (isset($htm_array["host_event_handler_enabled"])) $hosts[$htm_id]->set_event_handler_enabled($htm_array["host_event_handler_enabled"]);
		if (isset($htm_array["host_low_flap_threshold"])) $hosts[$htm_id]->set_low_flap_threshold($htm_array["host_low_flap_threshold"]);
		if (isset($htm_array["host_high_flap_threshold"])) $hosts[$htm_id]->set_high_flap_threshold($htm_array["host_high_flap_threshold"]);
		if (isset($htm_array["host_flap_detection_enabled"])) $hosts[$htm_id]->set_flap_detection_enabled($htm_array["host_flap_detection_enabled"]);
		if (isset($htm_array["host_process_perf_data"])) $hosts[$htm_id]->set_process_perf_data($htm_array["host_process_perf_data"]);
		if (isset($htm_array["host_retain_status_information"])) $hosts[$htm_id]->set_retain_status_information($htm_array["host_retain_status_information"]);
		if (isset($htm_array["host_retain_nonstatus_information"])) $hosts[$htm_id]->set_retain_nonstatus_information($htm_array["host_retain_nonstatus_information"]);
		if (isset($htm_array["host_notifications_enabled"])) $hosts[$htm_id]->set_notifications_enabled($htm_array["host_notifications_enabled"]);
		if (isset($htm_array["host_stalking_options"])) $hosts[$htm_id]->set_stalking_options($htm_array["host_stalking_options"]);
		if (isset($htm_array["host_comment"])) $hosts[$htm_id]->set_comment($htm_array["host_comment"]);
		$hosts[$htm_id]->set_register(0);
		$hosts[$htm_id]->set_activate(1);
		if (isset($_POST["selectHostParent"]))	{
			$selectHostParent = $_POST["selectHostParent"];
			for ($i = 0; $i < count($selectHostParent); $i++)
				$hosts[$htm_id]->parents[$selectHostParent[$i]] = & $hosts[$selectHostParent[$i]];
		}	else
				$hosts[$htm_id]->parents = array();
		if (isset($_POST["selectHostGroup"]))	{
			$selectHostGroup = $_POST["selectHostGroup"];
			for ($i = 0; $i < count($selectHostGroup); $i++)
				$hosts[$htm_id]->hostGroups[$selectHostGroup[$i]] = & $hostGroups[$selectHostGroup[$i]];
		}	else
				$hosts[$htm_id]->hostGroups = array();
		$oreon->saveHost($hosts[$htm_id]);
		$msg = $lang['errCode'][2];
		unset($host_object);
		$_GET["o"] = "w";
	}

	if (isset($_GET["o"]) && !strcmp($_GET["o"], "d"))	{
		system("echo \"[".time()."] DeleteHostTemplateModel;".addslashes($hosts[$_GET["htm_id"]]->get_name()).";".addslashes($oreon->user->get_alias())."\" >>./include/log/".date("Ymd").".txt");
		$oreon->deleteHost($hosts[$_GET["htm_id"]]);
		unset($_GET["o"]);
		unset($_GET["htm_id"]);
	}

	if (isset($_GET["o"]) && !strcmp($_GET["o"], "l"))	{
		if (isset($_GET["box"]))	{
			$boxx = & $_GET["box"];
			foreach ($boxx as $box)	{
				// log add
				system("echo \"[" . time() . "] DeleteHostTemplateModel;" . addslashes($hosts[$box]->get_name()) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
				$oreon->deleteHost($hosts[$box]);
			}
		}
		unset($_GET["o"]);
	}

	// Initialise YES NO or NOTHING Value
		$value_flag["1"] = "Yes";
		$value_flag["3"] = "No";
		$value_flag["2"] = "Nothing";

	function write_htm_list($hosts, $htms, $lang)	{
		?>
		<table cellpadding="0" cellspacing="0" width="160">
			<tr>
				<td class="tabTableTitleMenu"><? print $lang["m_options"]; ?></td>
			</tr>
			<tr>
				<td class="tabTableMenu">
					<div style="padding: 8px; text-align: center;">
						<img src="img/picto2.gif">
						<a href="phpradmin.php?p=123&o=a" class="text9"><? echo $lang['add']; ?></a>
						<img src="img/picto2_bis.gif">
					</div>
				</td>
			</tr>
		</table>
		<br>
		<table cellpadding="0" cellspacing="0" width="160">
			<tr>
				<td class="tabTableTitleMenu"><? print $lang['htm_available']; ?></td>
			</tr>
			<tr>
				<td class="tabTableMenu"><? 
				 if (isset($htms))
					foreach ($htms as $htm)	{ ?>
						<div style="padding: 2px; white-space: nowrap" align="left">
							<li>
								<a href="phpradmin.php?p=123&htm_id=<? echo $htm->get_id(); ?>&o=w" class="text10">
									<? echo $hosts[$htm->get_id()]->get_name(); ?>
								</a>
							</li>
						</div>
				<?  unset($htm); }?>
				</td>
			</tr>
		</table><?
	}

	function write_htm_list2(&$hosts, $htms, $lang)	{	?>
		<form action="" name="hostTemplateMenu" method="get">
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
		if (isset($htms) && count($htms) != 0)	{
			$cpt = 0;
			foreach ($htms as $htm)	{
				if ($cpt < (VIEW_MAX * $num) && ($cpt >= ((VIEW_MAX * $num) - (VIEW_MAX)))){	?>
				<tr>
					<td class="listSub<? echo $cpt%2; ?>"><input type="checkbox" name="box[<? echo $htm->get_id(); ?>]" value="<? echo $htm->get_id(); ?>"></td>
					<td align="left" class="listSub<? echo $cpt%2; ?>"><a href="phpradmin.php?p=123&htm_id=<? echo $htm->get_id(); ?>&o=w" class="text11"><? echo $hosts[$htm->get_id()]->get_name(); ?></a></td>
					<td align="left" class="listSub<? echo $cpt%2; ?>"><? echo $hosts[$htm->get_id()]->get_alias(); ?></td>
					<td align="center" class="listSub<? echo $cpt%2; ?>"><? echo $lang['enable']; ?></td>
					<td class="listSub<? echo $cpt%2; ?>">
						&nbsp;&nbsp;
						<a href="phpradmin.php?p=123&htm_id=<? echo $htm->get_id(); ?>&o=w" class="text11"><img src="img/listView.gif" border="0" alt="<? echo $lang['view']; ?>" title="<? echo $lang['view']; ?>"></a>&nbsp;
						<a href="phpradmin.php?p=123&htm_id=<? echo $htm->get_id(); ?>&o=c" class="text11"><img src="img/listPen.gif" border="0" alt="<? echo $lang['modify']; ?>" title="<? echo $lang['modify']; ?>"></a>&nbsp;
						<a href="phpradmin.php?p=123&htm_id=<? echo $htm->get_id(); ?>&o=d&num=<? echo $num; ?>&limit=<? echo VIEW_MAX; ?>" class="text11" onclick="return confirm('<? echo $lang['confirm_removing']; ?>')"><img src="img/listDel.gif" border="0" alt="<? echo $lang['delete']; ?>" title="<? echo $lang['delete']; ?>"></a>&nbsp;&nbsp;
					</td>
				</tr>
			<?	}
				unset($htm);
				$cpt++;
				}
			} ?>
			<tr>
				<td colspan="2" valign="top"><img src="img/arrow_ltr.gif" style="padding-left: 5px;">&nbsp;&nbsp;	<a href="#" class="text10bc" onclick=" if (confirm('<? echo $lang['confirm_removing']; ?>')){document.forms['hostTemplateMenu'].submit();}"><? echo $lang['m_delete_selection']; ?></a></td>
				<td></td>
				<td colspan="2" align="right" class="text10">
					<a href="phpradmin.php?p=123&o=a" class="text10bc"><? echo $lang['add']; ?></a>&nbsp;&nbsp;<br><br>
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
					<? $nbrPage = floor(count($htms)/VIEW_MAX); if(count($htms)%VIEW_MAX) $nbrPage++; ?>
					<? echo "<font class='text11b'>".$lang["page"]. ":&nbsp;&nbsp;</font>[&nbsp;&nbsp;";
						for ($i = 1; $i <= $nbrPage; $i++)	{
							if($num == $i)
								echo "<a href='./phpradmin.php?p=123&num=$i&limit=".VIEW_MAX."' class='text10'><b>$i</b></a>&nbsp;&nbsp;";
							else
								echo "<a href='./phpradmin.php?p=123&num=$i&limit=".VIEW_MAX."' class='text10'>$i</a>&nbsp;&nbsp;";
						}
						echo "]";
					?>
				</td>
			</tr>
		</table>
		<input type="hidden" name="p" value="123">
		<input type="hidden" name="o" value="l" id="option">
	</form>
	<? } ?>

<?
if (!isset($_GET["o"]))	{?>
	<table border="0" align="left">
		<tr>
			<td valign="top" align="left"><? write_htm_list2($hosts, $htms, $lang); ?></td>
		</tr>
	</table>
<? } else if (isset($_GET["o"]))	{
		if (isset($_GET["htm_id"]))
			$htm_id = $_GET["htm_id"];	?>
	<table border="0"  align="left">
		<tr>
			<td align="left" valign="top"><? write_htm_list($hosts, $htms, $lang); ?></td>
			<td style="padding-left: 20px;"></td>
			<td valign="top" align="left">
			<? if (isset($msg))
					echo "<div align='center' class='msg' style='padding-bottom: 10px;'>$msg</div>"; ?>
				<table align="left" cellpadding="0" cellspacing="0" width="400">
					<tr>
						<td align="center" nowrap class="tabTableTitle">
							<? echo "Host Template Model "; if (!strcmp($_GET["o"], "c") || !strcmp($_GET["o"], "w")) {  echo "\"" .$hosts[$htm_id]->get_name() ."\"";} ?>
						</td>
					</tr>
					<tr>
						<td class="tabTableForTab">
						<? 	if (!strcmp($_GET["o"], "w") || !strcmp($_GET["o"], "c") || !strcmp($_GET["o"], "a"))
								include("./include/configuration/host_template/host_template_".$_GET["o"].".php"); ?>
					</td>
				</tr>
			</table>
		</td>
		<td style="padding-left: 20px;"></td>
		<? if (isset($_GET["o"]) && (!strcmp($_GET["o"], "w") || !strcmp($_GET["o"], "c"))) { ?>
		<td valign="top" align="left">
			<table border='0'>
				<tr>
					<td align="align" class="tabTableTitleItem" style="white-space: nowrap;"><? echo $lang['usage_stats'] ?></td>
				</tr>
				<tr>
					<td class="tabTableItem"> 
					<?
						echo $lang['htm_stats1']."<br><br>";
						if (isset($hosts))
							foreach ($hosts as $host)	{
								if ($host->get_host_template() == $_GET["htm_id"])
									echo "<li><a href='phpradmin.php?p=102&o=w&h=".$host->get_id()."' class='text10b'>".$host->get_name()."</a></li>";
								unset($host);
							}
					?>
					</td>
				</tr>
			</table>
		</td>
		<? } ?>
		</tr>
	</table>
	<? } ?>