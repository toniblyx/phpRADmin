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

	$hosts =& $oreon->hosts;
	if (isset($_GET) && array_key_exists("o", $_GET) && $_GET["o"] != "a" && $_GET["o"] != "l")
		if (!isset($_GET["h"]) || (isset($_GET["h"]) && !array_key_exists($_GET["h"], $hosts)))	{
			echo "<td width='85%'></td>";
			include ("./footer.php");
			exit();
		}
	$services =& $oreon->services;
	$hostGroups =& $oreon->hostGroups;
	$contactGroups =& $oreon->contactGroups;
	$htms =& $oreon->htms;
	$commands =& $oreon->commands;
	$timePeriods =& $oreon->time_periods;

	if (isset($_POST["ChangeHost"]))	{
		$host_array = & $_POST["host"];
		if (isset($host_array["htm_id"]) && $host_array["htm_id"])
			$htm_id = $host_array["htm_id"];
		// Concat options
		$host_array["host_stalking_options"] = NULL;
		if (isset($host_array["host_stalking_options_o"])) $host_array["host_stalking_options"] .= $host_array["host_stalking_options_o"];
		if (strcmp($host_array["host_stalking_options"], "") && isset($host_array["host_stalking_options_d"])  && strcmp($host_array["host_stalking_options_d"], "")) $host_array["host_stalking_options"] .= ",";
		if (isset($host_array["host_stalking_options_d"])) $host_array["host_stalking_options"] .= $host_array["host_stalking_options_d"];
		if (strcmp($host_array["host_stalking_options"], "") && isset($host_array["host_stalking_options_u"]) && strcmp($host_array["host_stalking_options_u"], "")) $host_array["host_stalking_options"] .= ",";
		if (isset($host_array["host_stalking_options_u"])) $host_array["host_stalking_options"] .= $host_array["host_stalking_options_u"];
		// Concat options
		$host_array["host_notification_options"] = NULL;
		if (isset($host_array["host_notification_options_d"])) $host_array["host_notification_options"] .= $host_array["host_notification_options_d"];
		if (strcmp($host_array["host_notification_options"], "") && isset($host_array["host_notification_options_u"]) && strcmp($host_array["host_notification_options_u"], "")) $host_array["host_notification_options"] .= ",";
		if (isset($host_array["host_notification_options_u"])) $host_array["host_notification_options"] .= $host_array["host_notification_options_u"];
		if (strcmp($host_array["host_notification_options"], "") && isset($host_array["host_notification_options_r"]) && strcmp($host_array["host_notification_options_r"], "")) $host_array["host_notification_options"] .= ",";
		if (isset($host_array["host_notification_options_r"]))$host_array["host_notification_options"] .= $host_array["host_notification_options_r"];

		if (isset($host_array["host_check_interval"]) && !$host_array["host_check_interval"])
			$host_array["host_check_interval"] = 99999;
		if (isset($host_array["host_freshness_threshold"]) && !$host_array["host_freshness_threshold"])
			$host_array["host_freshness_threshold"] = 99999;
		else if (!isset($host_array["host_freshness_threshold"]) && isset($host_array["ftNothingBox"]))
			$host_array["host_freshness_threshold"] = 0;
		if (isset($host_array["host_low_flap_threshold"]) && !$host_array["host_low_flap_threshold"])
			$host_array["host_low_flap_threshold"] = 99999;
		else if (!isset($host_array["host_low_flap_threshold"]) && isset($host_array["lftNothingBox"]))
			$host_array["host_low_flap_threshold"] = 0;
		if (isset($host_array["host_high_flap_threshold"]) && !$host_array["host_high_flap_threshold"])
			$host_array["host_high_flap_threshold"] = 99999;
		else if (!isset($host_array["host_high_flap_threshold"]) && isset($host_array["hftNothingBox"]))
			$host_array["host_high_flap_threshold"] = 0;
		if (isset($host_array["host_notification_interval"]) && !$host_array["host_notification_interval"])
			$host_array["host_notification_interval"] = 99999;
		if (isset($host_array["host_comment"]) && !$host_array["host_comment"])
			$host_array["host_comment"] = "#BLANK#";

		// Copy array if we have to keep it for the template
		$host_array_tmp = $host_array;

		// Init with template value if it's necessary
		if (isset($htm_id) && !isset($host_array["host_alias"]))
			$host_array["host_alias"] = $hosts[$htm_id]->get_alias();
		if (isset($htm_id) && !isset($host_array["host_address"]))
			$host_array["host_address"] = $hosts[$htm_id]->get_address();
		if (isset($htm_id) && !isset($host_array["host_max_check_attempts"]))
			$host_array["host_max_check_attempts"] = $hosts[$htm_id]->get_max_check_attempts();
		if (isset($htm_id) && !isset($host_array["timeperiod_tp_id"]))
			$host_array["timeperiod_tp_id"] = $hosts[$htm_id]->get_check_period();
		if (isset($htm_id) && !isset($host_array["host_notification_interval"]))
			$host_array["host_notification_interval"] = $hosts[$htm_id]->get_notification_interval();
		if (isset($htm_id) && !isset($host_array["timeperiod_tp_id2"]))
			$host_array["timeperiod_tp_id2"] = $hosts[$htm_id]->get_notification_period();
		if (isset($htm_id) && !isset($host_array["host_notification_options"]))
			$host_array["host_notification_options"] = $hosts[$htm_id]->get_notification_options();

		// Create new host object with new data
		$host_object = new Host($host_array);

		// Init Contact Group
		if (isset($_POST["selectContactGroup"]))	 {
			$selectContactGroup = $_POST["selectContactGroup"];
			for ($i = 0; $i < count($selectContactGroup); $i++)
				$host_object->contactgroups[$selectContactGroup[$i]] = & $contactGroups[$selectContactGroup[$i]];
		}	else if (isset($htm_id) && !isset($_POST["templateContactGroupsBox"]))
				$host_object->contactgroups = $hosts[$htm_id]->contactgroups;
		// Check_period is only in V2
		if (isset($host_array["timeperiod_tp_id"]) && $host_array["timeperiod_tp_id"])
			$host_object->set_check_period($host_array["timeperiod_tp_id"]);
		// If it's complet -> set new data
		if ($host_object->is_complete($oreon->user->get_version()) && $host_object->twiceTest($hosts))	{
			// log change
			system("echo \"[" . time() . "] ChangeHost;" . addslashes($host_object->get_name()) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
			// If we use the template, we have to set a new object host, in order to take only the value off the form - record in $host_array_tmp
			if (isset($htm_id))	{
				$host_object = new Host($host_array_tmp);
				if (isset($_POST["selectContactGroup"])) 	{
					$selectContactGroup	= $_POST["selectContactGroup"];
					for ($i = 0; $i < count($selectContactGroup); $i++)
						$host_object->contactgroups[$selectContactGroup[$i]] = & $contactGroups[$selectContactGroup[$i]];
				}
				if (isset($host_array_tmp["timeperiod_tp_id"]) && $host_array_tmp["timeperiod_tp_id"])
					$host_object->set_check_period($host_array_tmp["timeperiod_tp_id"]);
			}
			$host_object->services = $hosts[$host_array["host_id"]]->services;
			$hosts[$host_array["host_id"]] = $host_object;
			if (isset($htm_id)) $hosts[$host_array["host_id"]]->set_host_template($htm_id);
			if (isset($host_array["command_command_id"])) $hosts[$host_array["host_id"]]->set_check_command($host_array["command_command_id"]);
			if (isset($host_array["command_command_id2"])) $hosts[$host_array["host_id"]]->set_event_handler($host_array["command_command_id2"]);
			if (isset($host_array["host_check_interval"])) $hosts[$host_array["host_id"]]->set_check_interval($host_array["host_check_interval"]);
			if (isset($host_array["host_active_checks_enabled"])) $hosts[$host_array["host_id"]]->set_active_checks_enabled($host_array["host_active_checks_enabled"]);
			if (isset($host_array["host_passive_checks_enabled"])) $hosts[$host_array["host_id"]]->set_passive_checks_enabled($host_array["host_passive_checks_enabled"]);
			if (isset($host_array["host_check_enabled"])) $hosts[$host_array["host_id"]]->set_checks_enabled($host_array["host_check_enabled"]);
			if (isset($host_array["host_obsess_over_host"])) $hosts[$host_array["host_id"]]->set_obsess_over_host($host_array["host_obsess_over_host"]);
			if (isset($host_array["host_check_freshness"])) $hosts[$host_array["host_id"]]->set_check_freshness($host_array["host_check_freshness"]);
			if (isset($host_array["host_freshness_threshold"])) $hosts[$host_array["host_id"]]->set_freshness_threshold($host_array["host_freshness_threshold"]);
			if (isset($host_array["host_event_handler_enabled"])) $hosts[$host_array["host_id"]]->set_event_handler_enabled($host_array["host_event_handler_enabled"]);
			if (isset($host_array["host_low_flap_threshold"])) $hosts[$host_array["host_id"]]->set_low_flap_threshold($host_array["host_low_flap_threshold"]);
			if (isset($host_array["host_high_flap_threshold"])) $hosts[$host_array["host_id"]]->set_high_flap_threshold($host_array["host_high_flap_threshold"]);
			if (isset($host_array["host_flap_detection_enabled"])) $hosts[$host_array["host_id"]]->set_flap_detection_enabled($host_array["host_flap_detection_enabled"]);
			if (isset($host_array["host_process_perf_data"])) $hosts[$host_array["host_id"]]->set_process_perf_data($host_array["host_process_perf_data"]);
			if (isset($host_array["host_retain_status_information"])) $hosts[$host_array["host_id"]]->set_retain_status_information($host_array["host_retain_status_information"]);
			if (isset($host_array["host_retain_nonstatus_information"])) $hosts[$host_array["host_id"]]->set_retain_nonstatus_information($host_array["host_retain_nonstatus_information"]);
			if (isset($host_array["host_notifications_enabled"])) $hosts[$host_array["host_id"]]->set_notifications_enabled($host_array["host_notifications_enabled"]);
			if (isset($host_array["host_stalking_options"])) $hosts[$host_array["host_id"]]->set_stalking_options($host_array["host_stalking_options"]);
			if (isset($host_array["host_comment"])) $hosts[$host_array["host_id"]]->set_comment($host_array["host_comment"]);
			if ($host_array["host_activate"]) $hosts[$host_array["host_id"]]->set_activate(1); else $hosts[$host_array["host_id"]]->set_activate(0);
			$hosts[$host_array["host_id"]]->set_register(1);
			// Init Host Parent
			if (isset($_POST["selectHostParent"]))	{
				$selectHostParent = $_POST["selectHostParent"];
				for ($i = 0; $i < count($selectHostParent); $i++)
					$hosts[$host_array["host_id"]]->parents[$selectHostParent[$i]] = & $hosts[$selectHostParent[$i]];
			}
			// Init Host Group
			if (isset($_POST["selectHostGroup"]))	{
				$selectHostGroup = $_POST["selectHostGroup"];
				for ($i = 0; $i < count($selectHostGroup); $i++)
					$hosts[$host_array["host_id"]]->hostGroups[$selectHostGroup[$i]] = & $hostGroups[$selectHostGroup[$i]];
			}
			// Update Host in database
			$oreon->saveHost($hosts[$host_array["host_id"]]);
			$msg = $lang['errCode'][2];
			$_GET["o"] = "w";
		}	else
			$msg = $lang['errCode'][$host_object->get_errCode()];
		unset($host_object);
	}
	if (isset($_POST["AddHost"]))	{
		$host_array = & $_POST["host"];
		if (isset($_POST["htm_id"]) && $_POST["htm_id"])
			$htm_id = $_POST["htm_id"];
		else
			unset ($_POST["htm_id"]);
		$host_array["host_id"] = -1;
		// Concat options
		$host_array["host_stalking_options"] = NULL;
		if (isset($host_array["host_stalking_options_o"])) $host_array["host_stalking_options"] .= $host_array["host_stalking_options_o"];
		if (strcmp($host_array["host_stalking_options"], "") && isset($host_array["host_stalking_options_d"])  && strcmp($host_array["host_stalking_options_d"], "")) $host_array["host_stalking_options"] .= ",";
		if (isset($host_array["host_stalking_options_d"])) $host_array["host_stalking_options"] .= $host_array["host_stalking_options_d"];
		if (strcmp($host_array["host_stalking_options"], "") && isset($host_array["host_stalking_options_u"]) && strcmp($host_array["host_stalking_options_u"], "")) $host_array["host_stalking_options"] .= ",";
		if (isset($host_array["host_stalking_options_u"])) $host_array["host_stalking_options"] .= $host_array["host_stalking_options_u"];

		// Concat options
		$host_array["host_notification_options"] = NULL;
		if (isset($host_array["host_notification_options_d"])) $host_array["host_notification_options"] .= $host_array["host_notification_options_d"];
		if (strcmp($host_array["host_notification_options"], "") && isset($host_array["host_notification_options_u"]) && strcmp($host_array["host_notification_options_u"], "")) $host_array["host_notification_options"] .= ",";
		if (isset($host_array["host_notification_options_u"])) $host_array["host_notification_options"] .= $host_array["host_notification_options_u"];
		if (strcmp($host_array["host_notification_options"], "") && isset($host_array["host_notification_options_r"]) && strcmp($host_array["host_notification_options_r"], "")) $host_array["host_notification_options"] .= ",";
		if (isset($host_array["host_notification_options_r"]))$host_array["host_notification_options"] .= $host_array["host_notification_options_r"];

		if (isset($host_array["host_check_interval"]) && !$host_array["host_check_interval"])
			$host_array["host_check_interval"] = 99999;
		if (isset($host_array["host_freshness_threshold"]) && !$host_array["host_freshness_threshold"])
			$host_array["host_freshness_threshold"] = 99999;
		else if (!isset($host_array["host_freshness_threshold"]) && isset($host_array["ftNothingBox"]))
			$host_array["host_freshness_threshold"] = 0;
		if (isset($host_array["host_low_flap_threshold"]) && !$host_array["host_low_flap_threshold"])
			$host_array["host_low_flap_threshold"] = 99999;
		else if (!isset($host_array["host_low_flap_threshold"]) && isset($host_array["lftNothingBox"]))
			$host_array["host_low_flap_threshold"] = 0;
		if (isset($host_array["host_high_flap_threshold"]) && !$host_array["host_high_flap_threshold"])
			$host_array["host_high_flap_threshold"] = 99999;
		else if (!isset($host_array["host_high_flap_threshold"]) && isset($host_array["hftNothingBox"]))
			$host_array["host_high_flap_threshold"] = 0;
		if (isset($host_array["host_notification_interval"]) && !$host_array["host_notification_interval"])
			$host_array["host_notification_interval"] = 99999;
		if (isset($host_array["host_comment"]) && !$host_array["host_comment"])
			$host_array["host_comment"] = "#BLANK#";

		// Copy array if we have to keep it for the template
		$host_array_tmp = $host_array;

		// Init with template value if it's necessary
		if (isset($htm_id) && !isset($host_array["host_alias"]))
			$host_array["host_alias"] = $hosts[$htm_id]->get_alias();
		if (isset($htm_id) && !isset($host_array["host_address"]))
			$host_array["host_address"] = $hosts[$htm_id]->get_address();
		if (isset($htm_id) && !isset($host_array["host_max_check_attempts"]))
			$host_array["host_max_check_attempts"] = $hosts[$htm_id]->get_max_check_attempts();
		if (isset($htm_id) && !isset($host_array["timeperiod_tp_id"]))
			$host_array["timeperiod_tp_id"] = $hosts[$htm_id]->get_check_period();
		if (isset($htm_id) && !isset($host_array["host_notification_interval"]))
			$host_array["host_notification_interval"] = $hosts[$htm_id]->get_notification_interval();
		if (isset($htm_id) && !isset($host_array["timeperiod_tp_id2"]))
			$host_array["timeperiod_tp_id2"] = $hosts[$htm_id]->get_notification_period();
		if (isset($htm_id) && !isset($host_array["host_notification_options"]))
			$host_array["host_notification_options"] = $hosts[$htm_id]->get_notification_options();

		// Create new host object with new data
		$host_object = new Host($host_array);

		// Init Contact Group
		if (isset($_POST["selectContactGroup"]))	 {
			$selectContactGroup = $_POST["selectContactGroup"];
			for ($i = 0; $i < count($selectContactGroup); $i++)
				$host_object->contactgroups[$selectContactGroup[$i]] = & $contactGroups[$selectContactGroup[$i]];
		}	else if (isset($htm_id) && !isset($_POST["templateContactGroupsBox"]))
				$host_object->contactgroups = $hosts[$htm_id]->contactgroups;
		if (isset($host_array["timeperiod_tp_id"]))
			$host_object->set_check_period($host_array["timeperiod_tp_id"]);
		// If it's complet -> set new data
		if ($host_object->is_complete($oreon->user->get_version()) && $host_object->twiceTest($hosts)) {
			// log add
			system("echo \"[" . time() . "] AddHost;" . addslashes($host_object->get_name()) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
			// If we use the template, we have to set a new object host, in order to take only the value off the form - record in $host_array_tmp
			if (isset($htm_id))	{
				$host_object = new Host($host_array_tmp);
				if (isset($_POST["selectContactGroup"])) 	{
					$selectContactGroup	= $_POST["selectContactGroup"];
					for ($i = 0; $i < count($selectContactGroup); $i++)
						$host_object->contactgroups[$selectContactGroup[$i]] = & $contactGroups[$selectContactGroup[$i]];
				}
				if (isset($host_array_tmp["timeperiod_tp_id"]) && $host_array_tmp["timeperiod_tp_id"])
					$host_object->set_check_period($host_array_tmp["timeperiod_tp_id"]);
			}
			// Insert Host in database
			$oreon->saveHost($host_object);
			$host_id = $oreon->database->database->get_last_id();
			$hosts[$host_id] = $host_object;
			$hosts[$host_id]->set_id($host_id);
			// Get host_id to order in $oreon->hosts
			$host_id = $oreon->database->database->get_last_id();
			if (isset($_POST["htm_id"])) $hosts[$host_id]->set_host_template($_POST["htm_id"]);
			if (isset($host_array["command_command_id"])) $hosts[$host_id]->set_check_command($host_array["command_command_id"]);
			if (isset($host_array["command_command_id2"])) $hosts[$host_id]->set_event_handler($host_array["command_command_id2"]);
			if (isset($host_array["host_check_interval"])) $hosts[$host_id]->set_check_interval($host_array["host_check_interval"]);
			if (isset($host_array["host_active_checks_enabled"])) $hosts[$host_id]->set_active_checks_enabled($host_array["host_active_checks_enabled"]);
			if (isset($host_array["host_passive_checks_enabled"])) $hosts[$host_id]->set_passive_checks_enabled($host_array["host_passive_checks_enabled"]);
			if (isset($host_array["host_check_enabled"])) $hosts[$host_id]->set_checks_enabled($host_array["host_check_enabled"]);
			if (isset($host_array["host_obsess_over_host"])) $hosts[$host_id]->set_obsess_over_host($host_array["host_obsess_over_host"]);
			if (isset($host_array["host_check_freshness"])) $hosts[$host_id]->set_check_freshness($host_array["host_check_freshness"]);
			if (isset($host_array["host_freshness_threshold"])) $hosts[$host_id]->set_freshness_threshold($host_array["host_freshness_threshold"]);
			if (isset($host_array["host_event_handler_enabled"])) $hosts[$host_id]->set_event_handler_enabled($host_array["host_event_handler_enabled"]);
			if (isset($host_array["host_low_flap_threshold"])) $hosts[$host_id]->set_low_flap_threshold($host_array["host_low_flap_threshold"]);
			if (isset($host_array["host_high_flap_threshold"])) $hosts[$host_id]->set_high_flap_threshold($host_array["host_high_flap_threshold"]);
			if (isset($host_array["host_flap_detection_enabled"])) $hosts[$host_id]->set_flap_detection_enabled($host_array["host_flap_detection_enabled"]);
			if (isset($host_array["host_process_perf_data"])) $hosts[$host_id]->set_process_perf_data($host_array["host_process_perf_data"]);
			if (isset($host_array["host_retain_status_information"])) $hosts[$host_id]->set_retain_status_information($host_array["host_retain_status_information"]);
			if (isset($host_array["host_retain_nonstatus_information"])) $hosts[$host_id]->set_retain_nonstatus_information($host_array["host_retain_nonstatus_information"]);
			if (isset($host_array["host_notifications_enabled"])) $hosts[$host_id]->set_notifications_enabled($host_array["host_notifications_enabled"]);
			if (isset($host_array["host_stalking_options"])) $hosts[$host_id]->set_stalking_options($host_array["host_stalking_options"]);
			if (isset($host_array["host_comment"])) $hosts[$host_id]->set_comment($host_array["host_comment"]);
			if ($host_array["host_activate"]) $hosts[$host_id]->set_activate(1); else $hosts[$host_id]->set_activate(0);
			$hosts[$host_id]->set_register(1);
			// Init Host Parent
			if (isset($_POST["selectHostParent"]))	{
				$selectHostParent = $_POST["selectHostParent"];
				for ($i = 0; $i < count($selectHostParent); $i++)
					$hosts[$host_id]->parents[$selectHostParent[$i]] = & $hosts[$selectHostParent[$i]];
			}
			// Init Host Group
			if (isset($_POST["selectHostGroup"]))	{
				$selectHostGroup = $_POST["selectHostGroup"];
				for ($i = 0; $i < count($selectHostGroup); $i++)
					$hosts[$host_id]->hostGroups[$selectHostGroup[$i]] = & $hostGroups[$selectHostGroup[$i]];
			}
			// Update Host in database
			$oreon->saveHost($hosts[$host_id]);
			$msg = $lang['errCode'][3];
			$_GET["o"] = "w";
			$_GET["h"] = $host_id;
		}
		else
			$msg = $lang['errCode'][$host_object->get_errCode()];
		unset($host_object);
	}
	if (isset($_GET["o"]) && !strcmp($_GET["o"], "d"))	{
		// log add
		system("echo \"[" . time() . "] DeleteHost;" . addslashes($hosts[$_GET["h"]]->get_name()) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
		$oreon->deleteHost($hosts[$_GET["h"]]);
		unset($_GET["o"]);
		unset($_GET["h"]);
	}
	if (isset($_GET["o"]) && !strcmp($_GET["o"], "l"))	{
		if (isset($_GET["box"]))	{
			$boxx = $_GET["box"];
			foreach ($boxx as $box)	{
				// log add
				system("echo \"[" . time() . "] DeleteHost;" . addslashes($hosts[$box]->get_name()) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
				$oreon->deleteHost($hosts[$box]);
			}
		}
		unset($_GET["o"]);
	}
	//------------------------------------
	// Initialise YES NO or NOTHING Value

		$value_flag["1"] = "Yes";
		$value_flag["3"] = "No";
		$value_flag["2"] = "Nothing";

	// -----------------------------------
	function write_host_list(&$hosts, $lang)	{?>
		<div style="display: yes;" id="hostListconf">
			<form action="" name="hostMenu" method="post">
				<table cellpadding="0" cellspacing="0" width="130">
					<tr>
						<td class="tabTableTitleMenu">Options</td>
					</tr>
					<tr>
						<td class="tabTableMenu">
							<div style="padding: 8px; text-align: center;">
								<img src="img/picto2.gif">
								<a href="phpradmin.php?p=102&o=a" class="text9"><? echo $lang['add']; ?></a>
								<img src="img/picto2_bis.gif">
								<br>
								<img src="img/picto2.gif">
								<a href="phpradmin.php?p=121" class="text9"><? echo $lang['dup']; ?></a>
								<img src="img/picto2_bis.gif">
							</div>
						</td>
					</tr>
				</table>
				<br>
				<table cellpadding="0" cellspacing="0" width="130">
					<tr>
						<td class="tabTableTitleMenu" style='white-space: nowrap;'><? print $lang['h_available']; ?></td>
					</tr>
					<tr>
						<td align='left' class="tabTableMenu"><?
			
				 	if (isset($hosts) && count($hosts) != 0)	{
					foreach ($hosts as $h)
						if ($h->get_register())	{?>
						
							<li style="white-space: nowrap;">
								<a href="phpradmin.php?p=102&h=<? echo $h->get_id(); ?>&o=w" class="text10" style="white-space: nowrap; <? if (!$h->get_activate()) echo "text-decoration: line-through;"; ?>">
								<? echo $h->get_name(); ?>
								</a>
							</li>
					<? unset($h);	}
				}?>
						</td>
					</tr>
				</table><?
	}

	function write_host_list2(&$hosts, &$htms, $lang)	{	?>
		<form action="" name="hostMenu" method="get">
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
		 if (isset($hosts) && count($hosts) != 0)	{
			$cpt = 0;
			foreach ($hosts as $h)		{
				if ($h->get_register() && $cpt < (VIEW_MAX * $num) && ($cpt >= ((VIEW_MAX * $num) - (VIEW_MAX))))	{	?>
				<tr>
					<td class="listSub<? echo $cpt%2; ?>"><input type="checkbox" name="box[<? echo $h->get_id(); ?>]" value="<? echo $h->get_id(); ?>"></td>
					<td align="left" class="listSub<? echo $cpt%2; ?>"><a href="phpradmin.php?p=102&h=<? echo $h->get_id(); ?>&o=w" class="text11"><? echo $h->get_name(); ?></a></td>
					<td align="left" class="listSub<? echo $cpt%2; ?>"><? echo $h->get_alias(); ?></td>
					<td align="center" class="listSub<? echo $cpt%2; ?>"><? if ($h->get_activate()) echo $lang['enable']; else echo $lang['disable']; ?></td>
					<td class="listSub<? echo $cpt%2; ?>">
						&nbsp;&nbsp;
						<a href="phpradmin.php?p=102&h=<? echo $h->get_id(); ?>&o=w" class="text11"><img src="img/listView.gif" border="0" alt="<? echo $lang['view']; ?>" title="<? echo $lang['view']; ?>"></a>&nbsp;
						<a href="phpradmin.php?p=102&h=<? echo $h->get_id(); ?>&o=c" class="text11"><img src="img/listPen.gif" border="0" alt="<? echo $lang['modify']; ?>" title="<? echo $lang['modify']; ?>"></a>&nbsp;
						<a href="phpradmin.php?p=121&h=<? echo $h->get_id(); ?>" class="text11"><img src="img/listDup.gif" border="0" alt="<? echo $lang['dup']; ?>" title="<? echo $lang['dup']; ?>"></a>&nbsp;
						<a href="phpradmin.php?p=102&h=<? echo $h->get_id(); ?>&o=d&num=<? echo $num; ?>&limit=<? echo VIEW_MAX; ?>" class="text11" onclick="return confirm('<? echo $lang['confirm_removing']; ?>')"><img src="img/listDel.gif" border="0" alt="<? echo $lang['delete']; ?>" title="<? echo $lang['delete']; ?>"></a>&nbsp;&nbsp;
					</td>
				</tr>
				<?
				}
				if ($h->get_register())
					$cpt++;
				unset($h);
			}
		}
		?>
			<tr>
				<td colspan="2" valign="top"><img src="img/arrow_ltr.gif" style="padding-left: 5px;">&nbsp;&nbsp;	<a href="#" class="text10bc" onclick=" if (confirm('<? echo $lang['confirm_removing']; ?>')){document.forms['hostMenu'].submit();}"><? echo $lang['m_delete_selection']; ?></a></td>
				<td></td>
				<td colspan="2" align="right">
					<a href="phpradmin.php?p=102&o=a" class="text10bc"><? echo $lang['add']; ?></a>&nbsp;&nbsp;
					<a href="phpradmin.php?p=121" class="text10bc"><? echo $lang['dup']; ?></a><br><br>
					<? echo $lang['nbr_per_page']; ?>&nbsp;
					<select name="limit" class="select" onChange="this.form['option'].disabled = true; this.form.submit();">
						<? for ($i = 10; $i <= 50; $i = $i + 10 )	{
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
					<? $nbrPage = floor((count($hosts) - count($htms))/VIEW_MAX); if((count($hosts) - count($htms))%VIEW_MAX) $nbrPage++; ?>
					<? echo "<font class='text11b'>".$lang["page"]. ":&nbsp;&nbsp;</font>[&nbsp;&nbsp;";
						for ($i = 1; $i <= $nbrPage; $i++)	{
							if($num == $i)
								echo "<a href='./phpradmin.php?p=102&num=$i&limit=".VIEW_MAX."' class='text10'><b>$i</b></a>&nbsp;&nbsp;";
							else
								echo "<a href='./phpradmin.php?p=102&num=$i&limit=".VIEW_MAX."' class='text10'>$i</a>&nbsp;&nbsp;";
						}
						echo "]";
					?>
				</td>
			</tr>
		</table>
		<input type="hidden" name="p" value="102">
		<input type="hidden" name="o" value="l" id="option">
	</form>
	<? } ?>
<td width="85%" valign="top" align="center" style="border: 1px solid #E9E5E5;padding-top:5px;padding-left:5px;">
<?
if (!isset($_GET["o"]))	{ // Without options ?>
	<table align="left">
		<tr>
			<td><? write_host_list2($hosts, $htms, $lang); ?></td>
		</tr>
	</table>
<? } else if (isset($_GET["o"]))	{
		if (isset($_GET["h"]))
			$h = $_GET["h"];
?>
	<table align="left" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td valign="top" align="left"><? write_host_list($hosts, $lang); ?></td>
			<td style="padding-left: 20px;"></td>
			<td valign="top" align='left'>
				<?if (isset($msg))
					echo "<div style='padding-bottom: 10px;' class='msg' align='center'>$msg</div>";?>
				<table border='0' cellpadding="0" cellspacing="0" class="tabTableTitle" width="400">
					<tr>
						<td align="center" class="text12b">Host <? if (!strcmp($_GET["o"], "c") || !strcmp($_GET["o"], "w")) {  echo "\"" . $hosts[$h]->get_name() . "\"";} ?></td>
					</tr>
				</table>
				<table border='0' cellpadding="0" cellspacing="0" class="tabTableForTab" width="400">
					<tr>
						<td>
						<? if (!strcmp($_GET["o"], "c")) {
								if (isset($_POST["host"]))	{
									$host_temp = & $_POST["host"];
									if (isset($host_temp["htm_id"]) && strcmp($host_temp["htm_id"], NULL))
										$TPL = $host_temp["htm_id"];
									else if (isset($host_temp["htm_id"]) && !strcmp($host_temp["htm_id"], NULL))
										$TPL = false;
									else
										$TPL = $hosts[$h]->get_host_template();
								}	else
										$TPL = $hosts[$h]->get_host_template();
						?>
							<form action="" method="POST" name="ChangeHostForm">
							<table align="center" border="0" cellpadding="0" cellspacing="3">
							<? if (isset($htms) && count($htms)) { ?>
								<tr>
									<td class="text10b" style="white-space: nowrap;"><? echo $lang['htm_use']; ?> :</td>
									<td>
										<select name="host[htm_id]" onChange="this.form.submit();">
											<option value=""></option>
											<?
											if (isset($htms))
												foreach ($htms as $htm)	{
													echo "<option value='" .$htm->get_id(). "'";
													if ($TPL == $htm->get_id())
														echo " selected";
													echo ">" .$hosts[$htm->get_id()]->get_name(). "</option>";
													unset($htm);
												}
											?>
										</select>
									</td>
								</tr>
								<? } ?>
								<tr>
									<td>Name :<font color="red">*</font></td>
									<td class="text10b"><input type="text" name="host[host_name]" value="<? echo $hosts[$h]->get_name(); ?>"></td>
								</tr>
								<tr>
									<td>Alias :<font color="red">*</font></td>
									<td class="text10b">
									<?
									$alias = NULL;
									$alias_temp = NULL;
									$alias = $hosts[$h]->get_alias();
									if ($TPL)
										$alias_temp = $hosts[$TPL]->get_alias();
									if ($TPL)	{ ?>
										<input type="checkbox" onClick="enabledTemplateField(this.form.templateAlias, '<? echo $alias_temp; ?>', '<? echo $alias; ?>');" <? if ($alias) echo "checked"; ?>>
									<? } ?>
										<input type="text" name="host[host_alias]" id="templateAlias" value="<? if ($alias) echo $alias; else echo $alias_temp; ?>" <? if ($TPL && !$alias) echo "disabled";?>>
									</td>
								</tr>
								<tr>
									<td>Address (ip, dns) :<font color="red">*</font></td>
									<td class="text10b">
									<?
									$address = NULL;
									$address_temp = NULL;
									$address = $hosts[$h]->get_address();
									if ($TPL)
										$address_temp = $hosts[$TPL]->get_address();
									if ($TPL)	{ ?>
										<input type="checkbox" onClick="enabledTemplateField(this.form.templateAddress, '<? echo $address_temp; ?>', '<? echo $address; ?>');" <? if ($address) echo "checked"; ?>>
									<? } ?>
										<input type="text" name="host[host_address]" id="templateAddress" value="<? if ($address) echo $address; else echo $address_temp; ?>" <? if ($TPL && !$address) echo "disabled";?>>
									</td>
								</tr>
								<tr>
									<td  colspan="2">
										<div align="center" class="text10b">
											Parents
											<?
											$ps = array();
											$ps_temp = array();
											if ($TPL)
												$ps_temp = & $hosts[$TPL]->parents;
											$ps = & $hosts[$h]->parents;
											if ($TPL)	{ ?>
												<input type="checkbox" id="templateHostParentBox" onClick="enabledTemplateFieldSelect(this.form.templateHostParentBase); enabledTemplateFieldSelect(this.form.selectHostParent);" <? if ($ps) echo "checked"; ?>>
											<? } ?>
										</div>
										<table border="0" align="center">
											<tr>
												<td align="left" style="padding: 3px;">
													<select name="selectHostParentBase" id="templateHostParentBase" size="8"<? if ($TPL && !$ps) echo "disabled";?> multiple>
													<?
														if (isset($hosts))
															foreach ($hosts as $host)	{
																if ($host->get_register() && $host->get_id() != $h)
																	if (!array_key_exists($host->get_id(), $ps) && !array_key_exists($host->get_id(), $ps_temp))
																		echo "<option value='".$host->get_id()."'>".$host->get_name()."</option>";
																unset($host);
															}
													?>
													</select>
												</td>
												<td style="padding-left: 5px; padding-right: 5px;" valign="middle" align="center">
													<input type="button" name="add" value="<? echo $lang['add']; ?>" onClick="Moove(this.form.selectHostParentBase,this.form.selectHostParent);"><br><br><br>
													<input type="button" name="remove" value="<? echo $lang['delete']; ?>" onClick="Moove(this.form.selectHostParent,this.form.selectHostParentBase);">
												</td>
												<td>
													<select id="selectHostParent" name="selectHostParent[]" size="8" <? if ($TPL && !$ps) echo "disabled";?> multiple>
													<?
													if (count($ps))
														foreach ($ps as $existing_parent)	{
															echo "<option value='".$existing_parent->get_id()."'>".$existing_parent->get_name()."</option>";
															unset($existing_parent);
														}
													else if (count($ps_temp))
														foreach ($ps_temp as $existing_parent)	{
															echo "<option value='".$existing_parent->get_id()."'>".$existing_parent->get_name()."</option>";
															unset($existing_parent);
														}
													?>
													</select>
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td  colspan="2">
										<div align="center" class="text10b">
											Host Groups
											<?
											$hgs = array();
											$hgs_temp = array();
											if ($TPL)
												$hgs_temp = & $hosts[$TPL]->hostGroups;
											$hgs = & $hosts[$h]->hostGroups;
											if ($TPL)	{ ?>
												<input type="checkbox" id="templateHostGroupBox" onClick="enabledTemplateFieldSelect(this.form.templateHostGroupBase); enabledTemplateFieldSelect(this.form.selectHostGroup);" <? if ($hgs) echo "checked"; ?>>
											<? } ?>
										</div>
										<table border="0" align="center">
											<tr>
												<td align="left" style="padding: 3px;">
													<select name="selectHostGroupBase" id="templateHostGroupBase" size="8"<? if ($TPL && !$hgs) echo "disabled";?> multiple>
													<?
														if (isset($hostGroups))
															foreach ($hostGroups as $hostGroup)	{
																if (!array_key_exists($hostGroup->get_id(), $hgs) && !array_key_exists($hostGroup->get_id(), $hgs_temp))
																	echo "<option value='".$hostGroup->get_id()."'>".$hostGroup->get_name()."</option>";
																unset($hostGroup);
															}
													?>
													</select>
												</td>
												<td style="padding-left: 5px; padding-right: 5px;" valign="middle" align="center">
													<input type="button" name="add" value="<? echo $lang['add']; ?>" onClick="Moove(this.form.selectHostGroupBase,this.form.selectHostGroup);"><br><br><br>
													<input type="button" name="remove" value="<? echo $lang['delete']; ?>" onClick="Moove(this.form.selectHostGroup,this.form.selectHostGroupBase);">
												</td>
												<td>
													<select id="selectHostGroup" name="selectHostGroup[]" size="8" <? if ($TPL && !$hgs) echo "disabled";?> multiple>
													<?
													if (count($hgs))
														foreach ($hgs as $existing_hostGroup)	{
															echo "<option value='".$existing_hostGroup->get_id()."'>".$existing_hostGroup->get_name()."</option>";
															unset($existing_hostGroup);
														}
													else if (count($hgs_temp))
														foreach ($hgs_temp as $existing_hostGroup)	{
															echo "<option value='".$existing_hostGroup->get_id()."'>".$existing_hostGroup->get_name()."</option>";
															unset($existing_hostGroup);
														}
													?>
													</select>
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td>Check_command :</td>
									<td class="text10b" style="white-space: nowrap;">
									<?
										$cc = NULL;
										$cc_temp = NULL;
										if ($hosts[$h]->get_check_command())
											$cc = $hosts[$h]->get_check_command();
										if ($TPL)
											$cc_temp = $hosts[$TPL]->get_check_command();
										if ($TPL)	{ ?>
											<input type="checkbox" onClick="enabledTemplateField(this.form.templateCheckCommand, '<? echo $cc_temp; ?>', '<? echo $cc; ?>');" <? if ($cc) echo "checked"; ?>>
										<? } ?>
									<select name="host[command_command_id]" id="templateCheckCommand" <? if ($TPL && !$cc) echo "disabled"; ?>>
										<option></option>
									<?
										if (isset($commands))
											foreach ($commands as $cmd)	{
												if (!strcmp($cmd->get_type(), "2"))	{
													echo "<option value='" . $cmd->get_id() . "'";
													if ($cc == $cmd->get_id())
														echo " selected";
													if (!$cc && $cc_temp == $cmd->get_id())
														echo " selected";
													echo ">" . $cmd->get_name() . "</option>";
												}
												unset($cmd);
											}
										?>
										</select>
									</td>
								</tr>
								<tr>
									<td>Max_check_attempts :<font color="red">*</font></td>
									<td class="text10b">
									<?
									$mca = NULL;
									$mca_temp = NULL;
									if ($hosts[$h]->get_max_check_attempts())
										$mca = $hosts[$h]->get_max_check_attempts();
									if ($TPL)
										$mca_temp = $hosts[$TPL]->get_max_check_attempts();
									if ($TPL)	{ ?>
										<input type="checkbox" onClick="enabledTemplateField(this.form.templateMaxCheckAttempts, '<? echo $mca_temp; ?>', '<? echo $mca; ?>');" <? if ($mca) echo "checked"; ?>>
									<? } ?>
										<input size="5" type="text" name="host[host_max_check_attempts]" id="templateMaxCheckAttempts" value="<? if ($mca) echo $mca; else echo $mca_temp; ?>" <? if ($TPL && !$mca) echo "disabled";?>>
									</td>
								</tr>
								<?	if (!strcmp("1", $oreon->user->get_version()))	{	?>
								<tr>
									<td>Checks_enabled :</td>
									<td class="text10b">
									<?
									$ce = NULL;
									$ce_temp = NULL;
									if ($hosts[$h]->get_checks_enabled())
										$ce = $hosts[$h]->get_checks_enabled();
									if ($TPL)
										$ce_temp = $hosts[$TPL]->get_checks_enabled();
									if (!$hosts[$h]->get_checks_enabled() && !$TPL)
										$ce = 2;
									if ($TPL)	{ ?>
										<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateChecksEnabled, '<? echo $ce_temp; ?>', '<? echo $ce; ?>');" <? if ($ce && $ce != 2) echo "checked"; ?>>
									<? } ?>
									<input name="host[host_check_enabled]" type="radio" id="templateChecksEnabled" value="1" <? if ($ce == 1) echo "checked"; else if ((!$ce || $ce == 2) && $ce_temp == 1) echo "checked"; ?> <? if (!$ce && $ce_temp || ($ce == 2 && $ce_temp)) echo "disabled"; ?>> Yes -
									<input name="host[host_check_enabled]" type="radio" id="templateChecksEnabled" value="3" <? if ($ce == 3) echo "checked"; else if ((!$ce || $ce == 2) && $ce_temp == 3) echo "checked"; ?> <? if (!$ce && $ce_temp || ($ce == 2 && $ce_temp)) echo "disabled"; ?>> No -
									<input name="host[host_check_enabled]" type="radio" id="templateChecksEnabled" value="2" <? if ($ce == 2 && !$ce_temp) echo "checked"; else if ((!$ce || $ce == 2) && $ce_temp == 2) echo "checked"; ?> <? if (!$ce && $ce_temp || ($ce == 2 && $ce_temp)) echo "disabled"; ?>> Nothing
									</td>
								</tr>
								<?	}	if (!strcmp("2", $oreon->user->get_version()))	{	?>
								<tr>
									<td>Check_interval :</td>
									<td class="text10b">
									<?
									$ci = 0;
									$ci_temp = 0;
									if ($hosts[$h]->get_check_interval())
										$ci = $hosts[$h]->get_check_interval();
									if ($TPL)
										$ci_temp = $hosts[$TPL]->get_check_interval();
									if ($TPL)	{ ?>
										<input type="checkbox" onClick="enabledTemplateField(this.form.templateCheckInterval, '<? echo preg_replace("/(99999)/", "0", $ci_temp); ?>', '<? echo preg_replace("/(99999)/", "0", $ci); ?>');" <? if ($ci) echo "checked"; ?>>
									<? } ?>
										<input size="5"  type="text" name="host[host_check_interval]" id="templateCheckInterval" value="<? if ($ci) echo preg_replace("/(99999)/", "0", $ci); else echo preg_replace("/(99999)/", "0", $ci_temp); ?>" <? if ($TPL && !$ci) echo "disabled";?>>
										<? echo " * ".$oreon->Nagioscfg->get_interval_length()." ".$lang["time_sec"]; ?>
									</td>
								</tr>
								<tr>
									<td>Active_checks_enabled :</td>
									<td class="text10b">
									<?
									$ace = NULL;
									$ace_temp = NULL;
									if ($hosts[$h]->get_active_checks_enabled())
										$ace = $hosts[$h]->get_active_checks_enabled();
									if ($TPL)
										$ace_temp = $hosts[$TPL]->get_active_checks_enabled();
									if (!$hosts[$h]->get_active_checks_enabled() && !$TPL)
										$ace = 2;
									if ($TPL)	{ ?>
										<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateActiveChecksEnabled, '<? echo $ace_temp; ?>', '<? echo $ace; ?>');" <? if ($ace && $ace != 2) echo "checked"; ?>>
									<? } ?>
									<input name="host[host_active_checks_enabled]" type="radio" id="templateActiveChecksEnabled" value="1" <? if ($ace == 1) echo "checked"; else if ((!$ace || $ace == 2) && $ace_temp == 1) echo "checked"; ?> <? if (!$ace && $ace_temp || ($ace == 2 && $ace_temp)) echo "disabled"; ?>> Yes -
									<input name="host[host_active_checks_enabled]" type="radio" id="templateActiveChecksEnabled" value="3" <? if ($ace == 3) echo "checked"; else if ((!$ace || $ace == 2) && $ace_temp == 3) echo "checked"; ?> <? if (!$ace && $ace_temp || ($ace == 2 && $ace_temp)) echo "disabled"; ?>> No -
									<input name="host[host_active_checks_enabled]" type="radio" id="templateActiveChecksEnabled" value="2" <? if ($ace == 2 && !$ace_temp) echo "checked"; else if ((!$ace || $ace == 2) && $ace_temp == 2) echo "checked"; ?> <? if (!$ace && $ace_temp || ($ace == 2 && $ace_temp)) echo "disabled"; ?>> Nothing
									</td>
								</tr>
								<tr>
									<td>Passive_checks_enabled :</td>
									<td class="text10b">
									<?
									$pce = NULL;
									$pce_temp = NULL;
									if ($hosts[$h]->get_active_checks_enabled())
										$pce = $hosts[$h]->get_active_checks_enabled();
									if ($TPL)
										$pce_temp = $hosts[$TPL]->get_passive_checks_enabled();
									if (!$hosts[$h]->get_passive_checks_enabled() && !$TPL)
										$pce = 2;
									if ($TPL)	{ ?>
										<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templatePassiveChecksEnabled, '<? echo $pce_temp; ?>', '<? echo $pce; ?>');" <? if ($pce && $pce != 2) echo "checked"; ?>>
									<? } ?>
									<input name="host[host_passive_checks_enabled]" type="radio" id="templatePassiveChecksEnabled" value="1" <? if ($pce == 1) echo "checked"; else if ((!$pce || $pce == 2) && $pce_temp == 1) echo "checked"; ?> <? if (!$pce && $pce_temp || ($pce == 2 && $pce_temp)) echo "disabled"; ?>> Yes -
									<input name="host[host_passive_checks_enabled]" type="radio" id="templatePassiveChecksEnabled" value="3" <? if ($pce == 3) echo "checked"; else if ((!$pce || $pce == 2) && $pce_temp == 3) echo "checked"; ?> <? if (!$pce && $pce_temp || ($pce == 2 && $pce_temp)) echo "disabled"; ?>> No -
									<input name="host[host_passive_checks_enabled]" type="radio" id="templatePassiveChecksEnabled" value="2" <? if ($pce == 2 && !$pce_temp) echo "checked"; else if ((!$pce || $pce == 2) && $pce_temp == 2) echo "checked"; ?> <? if (!$pce && $pce_temp || ($pce == 2 && $pce_temp)) echo "disabled"; ?>> Nothing
									</td>
								</tr>
								<tr>
									<td>Check_period :<font color="red">*</font></td>
									<td class="text10b">
									<?
										$cp = NULL;
										$cp_temp = NULL;
										if ($hosts[$h]->get_check_period())
											$cp = $hosts[$h]->get_check_period();
										if ($TPL)
											$cp_temp = $hosts[$TPL]->get_check_period();
										if ($TPL)	{ ?>
											<input type="checkbox" name="templateCheckPeriodBox" onClick="enabledTemplateField(this.form.templateCheckPeriod, '<? echo $cp_temp; ?>', '<? echo $cp; ?>');" <? if ($cp) echo "checked"; ?>>
										<? } ?>
										<select name="host[timeperiod_tp_id]" id="templateCheckPeriod" <? if ($TPL && !$cp) echo "disabled";?>>
											<option></option>
										<?
											if (isset($timePeriods))
												foreach ($timePeriods as $tp)	{
													echo "<option value='" . $tp->get_id() . "'";
													if ($cp == $tp->get_id())
														echo " selected";
													if (!$cp && $cp_temp == $tp->get_id())
														echo " selected";
													echo ">" . $tp->get_name() . "</option>";
													unset($tp);
												}
										?>
										</select>
									</td>
								</tr>
								<tr>
									<td>Obsess_over_host :</td>
									<td class="text10b">
									<?
									$ooh = NULL;
									$ooh_temp = NULL;
									if ($hosts[$h]->get_obsess_over_host())
										$ooh = $hosts[$h]->get_obsess_over_host();
									if ($TPL)
										$ooh_temp = $hosts[$TPL]->get_obsess_over_host();
									if (!$hosts[$h]->get_obsess_over_host() && !$TPL)
										$ooh = 2;
									if ($TPL)	{ ?>
										<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateObsessOverHost, '<? echo $ooh_temp; ?>', '<? echo $ooh; ?>');" <? if ($ooh && $ooh != 2) echo "checked"; ?>>
									<? } ?>
									<input name="host[host_obsess_over_host]" type="radio" id="templateObsessOverHost" value="1" <? if ($ooh == 1) echo "checked"; else if ((!$ooh || $ooh == 2) && $ooh_temp == 1) echo "checked"; ?> <? if (!$ooh && $ooh_temp || ($ooh == 2 && $ooh_temp)) echo "disabled"; ?>> Yes -
									<input name="host[host_obsess_over_host]" type="radio" id="templateObsessOverHost" value="3" <? if ($ooh == 3) echo "checked"; else if ((!$ooh || $ooh == 2) && $ooh_temp == 3) echo "checked"; ?> <? if (!$ooh && $ooh_temp || ($ooh == 2 && $ooh_temp)) echo "disabled"; ?>> No -
									<input name="host[host_obsess_over_host]" type="radio" id="templateObsessOverHost" value="2" <? if ($ooh == 2 && !$ooh_temp) echo "checked"; else if ((!$ooh || $ooh == 2) && $ooh_temp == 2) echo "checked"; ?> <? if (!$ooh && $ooh_temp || ($ooh == 2 && $ooh_temp)) echo "disabled"; ?>> Nothing
									</td>
								</tr>
								<tr>
									<td>Check_freshness :</td>
									<td class="text10b">
									<?
									$cf = NULL;
									$cf_temp = NULL;
									if ($hosts[$h]->get_check_freshness())
										$cf = $hosts[$h]->get_check_freshness();
									if ($TPL)
										$cf_temp = $hosts[$TPL]->get_check_freshness();
									if (!$hosts[$h]->get_check_freshness() && !$TPL)
										$cf = 2;
									if ($TPL)	{ ?>
										<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateCheckFreshness, '<? echo $cf_temp; ?>', '<? echo $cf; ?>');" <? if ($cf && $cf != 2) echo "checked"; ?>>
									<? } ?>
									<input name="host[host_check_freshness]" type="radio" id="templateCheckFreshness" value="1" <? if ($cf == 1) echo "checked"; else if ((!$cf || $cf == 2) && $cf_temp == 1) echo "checked";?> <? if (!$cf && $cf_temp || ($cf == 2 && $cf_temp)) echo "disabled"; ?>> Yes -
									<input name="host[host_check_freshness]" type="radio" id="templateCheckFreshness" value="3" <? if ($cf == 3) echo "checked"; else if ((!$cf || $cf == 2) && $cf_temp == 3) echo "checked";?> <? if (!$cf && $cf_temp || ($cf == 2 && $cf_temp)) echo "disabled"; ?>> No -
									<input name="host[host_check_freshness]" type="radio" id="templateCheckFreshness" value="2" <? if ($cf == 2 && !$cf_temp) echo "checked"; else if ((!$cf || $cf == 2) && $cf_temp == 2) echo "checked";?> <? if (!$cf && $cf_temp || ($cf == 2 && $cf_temp)) echo "disabled"; ?>> Nothing
									</td>
								</tr>
								<tr>
									<td>Freshness_threshold :</td>
									<td class="text10b">
									<?
									$ft = 0;
									$ft_temp = 0;
									if ($hosts[$h]->get_freshness_threshold())
										$ft = $hosts[$h]->get_freshness_threshold();
									if ($TPL)
										$ft_temp = $hosts[$TPL]->get_freshness_threshold();
									if ($TPL)	{ ?>
										<input type="checkbox" OnClick="enabledTemplateFieldSelect(this.form.ftNothingBox); if (<? echo $ft; ?>) {	 enabledTemplateField(this.form.templateFreshnessThreshold, '<? echo preg_replace("/(99999)/", "0", $ft_temp); ?>', '<? echo preg_replace("/(99999)/", "0", $ft); ?>') } ;" <? if ($ft) echo "checked"; ?>>
									<? } ?>
										<input size="5"  type="text" name="host[host_freshness_threshold]" id="templateFreshnessThreshold" value="<? if ($ft) echo preg_replace("/(99999)/", "0", $ft); else echo preg_replace("/(99999)/", "0", $ft_temp); ?>" <? if ($TPL && !$ft) echo "disabled"; ?>>
										<? echo $lang["time_sec"];?>
										&nbsp;&nbsp;<input type="checkbox" name="ftNothingBox" value="" <? if (!$ft) echo "checked"; ?> OnClick="enabledTemplateFieldSelect(this.form.templateFreshnessThreshold);" <? if ($TPL && !$ft) echo "disabled"; ?>>Nothing
									</td>
								</tr>
								<?	}	?>
								<tr>
									<td>Event_handler_enabled :</td>
									<td class="text10b">
									<?
									$ehe = NULL;
									$ehe_temp = NULL;
									if ($hosts[$h]->get_event_handler_enabled())
										$ehe = $hosts[$h]->get_event_handler_enabled();
									if ($TPL)
										$ehe_temp = $hosts[$TPL]->get_event_handler_enabled();
									if (!$hosts[$h]->get_event_handler_enabled() && !$TPL)
										$ehe = 2;
									if ($TPL)	{ ?>
										<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateEventHandlerEnabled, '<? echo $ehe_temp; ?>', '<? echo $ehe; ?>');" <? if ($ehe && $ehe != 2) echo "checked"; ?>>
									<? } ?>
									<input name="host[host_event_handler_enabled]" type="radio" id="templateEventHandlerEnabled" value="1" <? if ($ehe == 1) echo "checked"; else if ((!$ehe || $ehe == 2) && $ehe_temp == 1) echo "checked";?> <? if (!$ehe && $ehe_temp || ($ehe == 2 && $ehe_temp)) echo "disabled"; ?>> Yes -
									<input name="host[host_event_handler_enabled]" type="radio" id="templateEventHandlerEnabled" value="3" <? if ($ehe == 3) echo "checked"; else if ((!$ehe || $ehe == 2) && $ehe_temp == 3) echo "checked";?> <? if (!$ehe && $ehe_temp || ($ehe == 2 && $ehe_temp)) echo "disabled"; ?>> No -
									<input name="host[host_event_handler_enabled]" type="radio" id="templateEventHandlerEnabled" value="2" <? if ($ehe == 2 && !$ehe_temp) echo "checked"; else if ((!$ehe || $ehe == 2) && $ehe_temp == 2) echo "checked";?> <? if (!$ehe && $ehe_temp || ($ehe == 2 && $ehe_temp)) echo "disabled"; ?>> Nothing
									</td>
								</tr>
								<tr>
									<td>Event_handler :</td>
									<td class="text10b" style="white-space: nowrap;">
									<?
									$eh = NULL;
									$eh_temp = NULL;
									if ($TPL)
										$eh_temp = $hosts[$TPL]->get_event_handler();
									if ($hosts[$h]->get_event_handler())
										$eh = $hosts[$h]->get_event_handler();
									if ($TPL)	{ ?>
										<input type="checkbox" onClick="enabledTemplateField(this.form.templateEventHandler, '<? echo $eh_temp; ?>', '<? echo $eh; ?>');" <? if ($eh) echo "checked"; ?>>
									<? } ?>
										<select name="host[command_command_id2]" id="templateEventHandler" <? if ($TPL && !$eh) echo "disabled"; ?>>
											<option></option>
											<?
											if (isset($commands))
												foreach ($commands as $cmd)	{
													if (!strcmp($cmd->get_type(), "2") && !strstr($cmd->get_name(), "check_graph"))	{
														echo "<option value='" . $cmd->get_id() . "'";
														if ($eh == $cmd->get_id())
															echo " selected";
														if (!$eh && $eh_temp == $cmd->get_id())
															echo " selected";
														echo ">" . $cmd->get_name() . "</option>";
													}
													unset($cmd);
												}
											?>
										</select>
									</td>
								</tr>
								<tr>
									<td>Low_flap_threshold :</td>
									<td class="text10b">
									<?
									$lft = 0;
									$lft_temp = 0;
									if ($hosts[$h]->get_low_flap_threshold())
										$lft = $hosts[$h]->get_low_flap_threshold();
									if ($TPL)
										$lft_temp = $hosts[$TPL]->get_low_flap_threshold();
									if ($TPL)	{ ?>
										<input type="checkbox" onClick="enabledTemplateField(this.form.lftNothingBox); if (<? echo $lft; ?>) {	enabledTemplateField(this.form.templateLowFlapThreshold, '<? echo preg_replace("/(99999)/", "0", $lft_temp); ?>', '<? echo preg_replace("/(99999)/", "0", $lft); ?>') };" <? if ($lft) echo "checked"; ?>>
									<? } ?>
										<input size="5"  type="text" name="host[host_low_flap_threshold]" id="templateLowFlapThreshold" value="<? if ($lft) echo preg_replace("/(99999)/", "0", $lft); else echo preg_replace("/(99999)/", "0", $lft_temp); ?>" <? if (!$lft) echo "disabled"; ?>>
										%
										&nbsp;&nbsp;<input type="checkbox" name="lftNothingBox" value="" <? if (!$lft) echo "checked"; ?> OnClick="enabledTemplateFieldSelect(this.form.templateLowFlapThreshold);" <? if ($TPL && !$lft) echo "disabled"; ?>>Nothing
									</td>
								</tr>
								<tr>
									<td>High_flap_threshold :</td>
									<td class="text10b">
									<?
									$hft = 0;
									$hft_temp = 0;
									if ($hosts[$h]->get_high_flap_threshold())
										$hft = $hosts[$h]->get_high_flap_threshold();
									if ($TPL)
										$hft_temp = $hosts[$TPL]->get_high_flap_threshold();
									if ($TPL)	{ ?>
										<input type="checkbox" onClick="enabledTemplateField(this.form.hftNothingBox); if (<? echo $hft; ?>) {	enabledTemplateField(this.form.templateHighFlapThreshold, '<? echo preg_replace("/(99999)/", "0", $hft_temp); ?>', '<? echo preg_replace("/(99999)/", "0", $hft); ?>') } ;" <? if ($hft) echo "checked"; ?>>
									<? }  ?>
										<input size="5"  type="text" name="host[host_high_flap_threshold]" id="templateHighFlapThreshold" value="<? if ($hft) echo preg_replace("/(99999)/", "0", $hft); else echo preg_replace("/(99999)/", "0", $hft_temp); ?>" <? if (!$hft) echo "disabled"; ?>>
										%
										&nbsp;&nbsp;<input type="checkbox" name="hftNothingBox" value=""  <? if (!$hft) echo "checked"; ?> OnClick="enabledTemplateFieldSelect(this.form.templateHighFlapThreshold);" <? if ($TPL && !$hft) echo "disabled"; ?>>Nothing
									</td>
								</tr>
								<tr>
									<td>Flap_detection_enabled :</td>
									<td class="text10b">
									<?
									$fde = NULL;
									$fde_temp = NULL;
									if ($hosts[$h]->get_flap_detection_enabled())
										$fde = $hosts[$h]->get_flap_detection_enabled();
									if ($TPL)
										$fde_temp = $hosts[$TPL]->get_flap_detection_enabled();
									if (!$hosts[$h]->get_flap_detection_enabled() && !$TPL)
										$fde = 2;
									if ($TPL)	{ ?>
										<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateFlapDetectionEnabled, '<? echo $fde_temp; ?>', '<? echo $fde; ?>');" <? if ($fde && $fde != 2) echo "checked"; ?>>
									<? } ?>
									<input name="host[host_flap_detection_enabled]" type="radio" id="templateFlapDetectionEnabled" value="1" <? if ($fde == 1) echo "checked"; else if ((!$fde || $fde == 2) && $fde_temp == 1) echo "checked";?> <? if (!$fde && $fde_temp || ($fde == 2 && $fde_temp)) echo "disabled"; ?>> Yes -
									<input name="host[host_flap_detection_enabled]" type="radio" id="templateFlapDetectionEnabled" value="3" <? if ($fde == 3) echo "checked"; else if ((!$fde || $fde == 2) && $fde_temp == 3) echo "checked";?> <? if (!$fde && $fde_temp || ($fde == 2 && $fde_temp)) echo "disabled"; ?>> No -
									<input name="host[host_flap_detection_enabled]" type="radio" id="templateFlapDetectionEnabled" value="2" <? if ($fde == 2 && !$fde_temp) echo "checked"; else if ((!$fde || $fde == 2) && $fde_temp == 2) echo "checked";?> <? if (!$fde && $fde_temp || ($fde == 2 && $fde_temp)) echo "disabled"; ?>> Nothing
									</td>
								</tr>
								<tr>
									<td>Process_perf_data :</td>
									<td class="text10b">
									<?
									$ppd = NULL;
									$ppd_temp = NULL;
									if ($hosts[$h]->get_process_perf_data())
										$ppd = $hosts[$h]->get_process_perf_data();
									if ($TPL)
										$ppd_temp = $hosts[$TPL]->get_process_perf_data();
									if (!$hosts[$h]->get_process_perf_data() && !$TPL)
										$ppd = 2;
									if ($TPL)	{ ?>
										<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateProcessPerfData, '<? echo $ppd_temp; ?>', '<? echo $ppd; ?>');" <? if ($ppd && $ppd != 2) echo "checked"; ?>>
									<? } ?>
									<input name="host[host_process_perf_data]" type="radio" id="templateProcessPerfData" value="1" <? if ($ppd == 1) echo "checked"; else if ((!$ppd || $ppd == 2) && $ppd_temp == 1) echo "checked";?> <? if (!$ppd && $ppd_temp || ($ppd == 2 && $ppd_temp)) echo "disabled"; ?>> Yes -
									<input name="host[host_process_perf_data]" type="radio" id="templateProcessPerfData" value="3" <? if ($ppd == 3) echo "checked"; else if ((!$ppd || $ppd == 2) && $ppd_temp == 3) echo "checked";?> <? if (!$ppd && $ppd_temp || ($ppd == 2 && $ppd_temp)) echo "disabled"; ?>> No -
									<input name="host[host_process_perf_data]" type="radio" id="templateProcessPerfData" value="2" <? if ($ppd == 2 && !$ppd_temp) echo "checked"; else if ((!$ppd || $ppd == 2) && $ppd_temp == 2) echo "checked";?> <? if (!$ppd && $ppd_temp || ($ppd == 2 && $ppd_temp)) echo "disabled"; ?>> Nothing
									</td>
								</tr>
								<tr>
									<td>Retain_status_information :</td>
									<td class="text10b">
									<?
									$rsi = NULL;
									$rsi_temp = NULL;
									if ($hosts[$h]->get_retain_status_information())
										$rsi = $hosts[$h]->get_retain_status_information();
									if ($TPL)
										$rsi_temp = $hosts[$TPL]->get_retain_status_information();
									if (!$hosts[$h]->get_retain_status_information() && !$TPL)
										$rsi = 2;
									if ($TPL)	{ ?>
										<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateRetainStatusInformation, '<? echo $rsi_temp; ?>', '<? echo $rsi; ?>');" <? if ($rsi && $rsi != 2) echo "checked"; ?>>
									<? } ?>
									<input name="host[host_retain_status_information]" type="radio" id="templateRetainStatusInformation" value="1" <? if ($rsi == 1) echo "checked"; else if ((!$rsi || $rsi == 2) && $rsi_temp == 1) echo "checked";?> <? if (!$rsi && $rsi_temp || ($rsi == 2 && $rsi_temp)) echo "disabled"; ?>> Yes -
									<input name="host[host_retain_status_information]" type="radio" id="templateRetainStatusInformation" value="3" <? if ($rsi == 3) echo "checked"; else if ((!$rsi || $rsi == 2) && $rsi_temp == 3) echo "checked";?> <? if (!$rsi && $rsi_temp || ($rsi == 2 && $rsi_temp)) echo "disabled"; ?>> No -
									<input name="host[host_retain_status_information]" type="radio" id="templateRetainStatusInformation" value="2" <? if ($rsi == 2 && !$rsi_temp) echo "checked"; else if ((!$rsi || $rsi == 2) && $rsi_temp == 2) echo "checked";?> <? if (!$rsi && $rsi_temp || ($rsi == 2 && $rsi_temp)) echo "disabled"; ?>> Nothing
									</td>
								</tr>
								<tr>
									<td style="white-space: nowrap;">Retain_nonstatus_information :</td>
									<td class="text10b" style="white-space: nowrap;">
									<?
									$rni = NULL;
									$rni_temp = NULL;
									if ($hosts[$h]->get_retain_nonstatus_information())
										$rni = $hosts[$h]->get_retain_nonstatus_information();
									if ($TPL)
										$rni_temp = $hosts[$TPL]->get_retain_nonstatus_information();
									if (!$hosts[$h]->get_retain_nonstatus_information() && !$TPL)
										$rni = 2;
									if ($TPL)	{ ?>
										<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateRetainNonstatusInformation, '<? echo $rni_temp; ?>', '<? echo $rni; ?>');" <? if ($rni && $rni != 2) echo "checked"; ?>>
									<? } ?>
									<input name="host[host_retain_nonstatus_information]" type="radio" id="templateRetainNonstatusInformation" value="1" <? if ($rni == 1) echo "checked"; else if ((!$rni || $rni == 2) && $rni_temp == 1) echo "checked";?> <? if (!$rni && $rni_temp || ($rni == 2 && $rni_temp)) echo "disabled"; ?>> Yes -
									<input name="host[host_retain_nonstatus_information]" type="radio" id="templateRetainNonstatusInformation" value="3" <? if ($rni == 3) echo "checked"; else if ((!$rni || $rni == 2) && $rni_temp == 3) echo "checked";?> <? if (!$rni && $rni_temp || ($rni == 2 && $rni_temp)) echo "disabled"; ?>> No -
									<input name="host[host_retain_nonstatus_information]" type="radio" id="templateRetainNonstatusInformation" value="2" <? if ($rni == 2 && !$rni_temp) echo "checked"; else if ((!$rni || $rni == 2) && $rni_temp == 2) echo "checked";?> <? if (!$rni && $rni_temp || ($rni == 2 && $rni_temp)) echo "disabled"; ?>> Nothing
									</td>
								</tr>
								<?	if (!strcmp("2", $oreon->user->get_version()))	{	?>
								<tr>
									<td  colspan="2">
										<div align="center" class="text10b">
											Contact Groups <font color="red">*</font>
											<?
											$cgs = array();
											$cgs_temp = array();
											if ($TPL)
												$cgs_temp = & $hosts[$TPL]->contactgroups;
											$cgs = & $hosts[$h]->contactgroups;
											if ($TPL)	{ ?>
												<input type="checkbox" id="templateContactGroupBox" onClick="enabledTemplateFieldSelect(this.form.templateContactGroupBase); enabledTemplateFieldSelect(this.form.selectContactGroup);" <? if ($cgs) echo "checked"; ?>>
											<? } ?>
										</div>
										<table border="0" align="center">
											<tr>
												<td align="left" style="padding: 3px;">
													<select name="selectContactGroupBase" id="templateContactGroupBase" size="8"<? if ($TPL && !$cgs) echo "disabled";?> multiple>
													<?
														if (isset($contatGroups))
															foreach ($contactGroups as $contactGroup)	{
																if (!array_key_exists($contactGroup->get_id(), $cgs) && !array_key_exists($contactGroup->get_id(), $cgs_temp))
																	echo "<option value='".$contactGroup->get_id()."'>".$contactGroup->get_name()."</option>";
																unset($contactGroup);
															}
													?>
													</select>
												</td>
												<td style="padding-left: 5px; padding-right: 5px;" valign="middle" align="center">
													<input type="button" name="add" value="<? echo $lang['add']; ?>" onClick="Moove(this.form.selectContactGroupBase,this.form.selectContactGroup);"><br><br><br>
													<input type="button" name="remove" value="<? echo $lang['delete']; ?>" onClick="Moove(this.form.selectContactGroup,this.form.selectContactGroupBase);">
												</td>
												<td>
													<select id="selectContactGroup" name="selectContactGroup[]" size="8" <? if ($TPL && !$cgs) echo "disabled";?> multiple>
													<?
													if (count($cgs))
														foreach ($cgs as $existing_contactGroup)	{
															echo "<option value='".$existing_contactGroup->get_id()."'>".$existing_contactGroup->get_name()."</option>";
															unset($existing_contactGroup);
														}
													else if (count($cgs_temp))
														foreach ($cgs_temp as $existing_contactGroup)	{
															echo "<option value='".$existing_contactGroup->get_id()."'>".$existing_contactGroup->get_name()."</option>";
															unset($existing_contactGroup);
														}
													?>
													</select>
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<?	}	?>
								<tr>
									<td>Notification_interval :<font color="red">*</font></td>
									<td class="text10b">
									<?
									$ni = 0;
									$ni_temp = 0;
									if ($hosts[$h]->get_notification_interval())
										$ni = $hosts[$h]->get_notification_interval();
									if ($TPL)
										$ni_temp = $hosts[$TPL]->get_notification_interval();
									if ($TPL)	{ ?>
										<input type="checkbox" onClick="enabledTemplateField(this.form.templateNotificationInterval, '<? echo preg_replace("/(99999)/", "0", $ni_temp); ?>', '<? echo preg_replace("/(99999)/", "0", $ni); ?>');" <? if ($ni) echo "checked"; ?>>
									<? } ?>
										<input size="5"  type="text" name="host[host_notification_interval]" id="templateNotificationInterval" value="<? if ($ni) echo preg_replace("/(99999)/", "0", $ni); else echo preg_replace("/(99999)/", "0", $ni_temp); ?>" <? if ($TPL && !$ni) echo "disabled";?>>
										<? echo " * ".$oreon->Nagioscfg->get_interval_length()." ".$lang["time_sec"]; ?>
									</td>
								</tr>
								<tr>
									<td>Notification_period :<font color="red">*</font></td>
									<td class="text10b">
									<?
										$np = NULL;
										$np_temp = NULL;
										if ($hosts[$h]->get_notification_period())
											$np = $hosts[$h]->get_notification_period();
										if ($TPL)
											$np_temp = $hosts[$TPL]->get_notification_period();
										if ($TPL)	{ ?>
											<input type="checkbox" onClick="enabledTemplateField(this.form.templateNotificationPeriod, '<? echo $np_temp; ?>', '<? echo $np; ?>');" <? if ($np) echo "checked"; ?>>
										<? } ?>
										<select name="host[timeperiod_tp_id2]" id="templateNotificationPeriod" <? if ($TPL && !$np) echo "disabled";?>>
										<?
											if (isset($timePeriods))
												foreach ($timePeriods as $tp)	{
													echo "<option value='" . $tp->get_id() . "'";
													if ($np == $tp->get_id())
														echo " selected";
													if (!$np && $np_temp == $tp->get_id())
														echo " selected";
													echo ">" . $tp->get_name() . "</option>";
													unset($tp);
												}
										?>
										</select>
									</td>
								</tr>
								<tr>
									<td>Notification_options :<font color="red">*</font></td>
									<td class="text10b">
									<?	$no = NULL;
										$no_temp = NULL;
										$option_not = array();
										$option_not_temp = array();
										if ($hosts[$h]->get_notification_options())
											$no = $hosts[$h]->get_notification_options();
										if ($TPL)
											$no_temp = $hosts[$TPL]->get_notification_options();
										if ($no)	{
											$tab = split(",", $no);
											for ($i = 0; $i != 3; $i++)
												if (isset($tab[$i]))
													$option_not[$tab[$i]] = $tab[$i];
										}
										if ($no_temp)	{
											$tab_temp = split(",", $no_temp);
											for ($i = 0; $i != 3; $i++)
												if (isset($tab_temp[$i]))
													$option_not_temp[$tab_temp[$i]] = $tab_temp[$i];
										}
										if ($TPL)	{ ?>
											<input type="checkbox" onClick="enabledTemplateFieldCheck(this.form.templateNotificationOptions, '<? echo $no_temp; ?>', '<? echo $no; ?>');" <? if ($no) echo "checked"; ?>>
										<? } ?>
										<input ONMOUSEOVER="montre_legende('Down', '');" ONMOUSEOUT="cache_legende();" name="host[host_notification_options_d]" type="checkbox" id="templateNotificationOptions" value="d" <? if (isset($option_not["d"])) print "checked"; else if (isset($option_not_temp["d"]) && !count($option_not)) echo "checked"; ?> <? if ($TPL && !$no) echo "disabled"; ?>> d -
										<input ONMOUSEOVER="montre_legende('Unreachable', '');" ONMOUSEOUT="cache_legende();"  name="host[host_notification_options_u]" type="checkbox" id="templateNotificationOptions" value="u" <? if (isset($option_not["u"])) print "checked"; else if (isset($option_not_temp["u"]) && !count($option_not)) echo "checked"; ?> <? if ($TPL && !$no) echo "disabled"; ?>> u -
										<input ONMOUSEOVER="montre_legende('Recovery', '');" ONMOUSEOUT="cache_legende();" name="host[host_notification_options_r]" type="checkbox" id="templateNotificationOptions" value="r" <? if (isset($option_not["r"])) print "checked"; else if (isset($option_not_temp["r"]) && !count($option_not)) echo "checked"; ?> <? if ($TPL && !$no) echo "disabled"; ?>> r
									</td>
								</tr>
								<tr>
									<td>Notifications_enabled :</td>
									<td class="text10b">
									<?
									$ne = NULL;
									$ne_temp = NULL;
									if ($hosts[$h]->get_notifications_enabled())
										$ne = $hosts[$h]->get_notifications_enabled();
									if ($TPL)
										$ne_temp = $hosts[$TPL]->get_notifications_enabled();
									if (!$hosts[$h]->get_notifications_enabled() && !$TPL)
										$ne = 2;
									if ($TPL)	{ ?>
										<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateNotificationEnabled, '<? echo $ne_temp; ?>', '<? echo $ne; ?>');" <? if ($ne && $ne != 2) echo "checked"; ?>>
									<? } ?>
										<input name="host[host_notifications_enabled]" type="radio" id="templateNotificationEnabled" value="1" <? if ($ne == 1) echo "checked"; else if ((!$ne || $ne == 2) && $ne_temp == 1) echo "checked";?> <? if (!$ne && $ne_temp || ($ne == 2 && $ne_temp)) echo "disabled"; ?>> Yes -
										<input name="host[host_notifications_enabled]" type="radio" id="templateNotificationEnabled" value="3" <? if ($ne == 3) echo "checked"; else if ((!$ne || $ne == 2) && $ne_temp == 3) echo "checked";?> <? if (!$ne && $ne_temp || ($ne == 2 && $ne_temp)) echo "disabled"; ?>> No -
										<input name="host[host_notifications_enabled]" type="radio" id="templateNotificationEnabled" value="2" <? if ($ne == 2 && !$ne_temp) echo "checked"; else if ((!$ne || $ne == 2) && $ne_temp == 2) echo "checked";?> <? if (!$ne && $ne_temp || ($ne == 2 && $ne_temp)) echo "disabled"; ?>> Nothing
									</td>
								</tr>
								<tr>
									<td>Stalking_options :</td>
									<td class="text10b">
									<?	$so = NULL;
										$so_temp = NULL;
										$option_sta = array();
										$option_sta_temp = array();
										if ($hosts[$h]->get_stalking_options())
											$so = $hosts[$h]->get_stalking_options();
										if ($TPL)
											$so_temp = $hosts[$TPL]->get_stalking_options();
										if ($TPL)	{ ?>
											<input type="checkbox" name="templateStalkingOptionsBox" onClick="enabledTemplateFieldCheck(this.form.templateStalkingOptions, '<? echo $so_temp; ?>', '<? echo $so; ?>');" <? if ($so) echo "checked"; ?>>
										<? }
										if ($so)	{
											$tab = split(",", $so);
											for ($i = 0; $i != 3; $i++)
												if (isset($tab[$i]))
													$option_sta[$tab[$i]] = $tab[$i];
										}
										if ($so_temp)	{
											$tab_temp = split(",", $so_temp);
											for ($i = 0; $i != 3; $i++)
												if (isset($tab_temp[$i]))
													$option_sta_temp[$tab_temp[$i]] = $tab_temp[$i];
										}
									?>
										<input ONMOUSEOVER="montre_legende('Ok/UP', '');" ONMOUSEOUT="cache_legende();" name="host[host_stalking_options_o]" type="checkbox" value="o" id="templateStalkingOptions" <? if (isset($option_sta["o"])) print "checked"; else if (isset($option_sta_temp["o"]) && !count($option_sta)) echo "checked"; ?> <? if ($TPL && !$so) echo "disabled"; ?>> o -
										<input ONMOUSEOVER="montre_legende('Down', '');" ONMOUSEOUT="cache_legende();" name="host[host_stalking_options_d]" type="checkbox" value="d" id="templateStalkingOptions" <? if (isset($option_sta["d"])) print "checked"; else if (isset($option_sta_temp["d"]) && !count($option_sta)) echo "checked"; ?> <? if ($TPL && !$so) echo "disabled"; ?>> d -
										<input ONMOUSEOVER="montre_legende('Unreachable', '');" ONMOUSEOUT="cache_legende();" name="host[host_stalking_options_u]" type="checkbox" value="u" id="templateStalkingOptions" <? if (isset($option_sta["u"])) print "checked"; else if (isset($option_sta_temp["u"]) && !count($option_sta)) echo "checked"; ?> <? if ($TPL && !$so) echo "disabled"; ?>> u
									</td>
								</tr>
								<tr>
									<td valign="top" class='text10b'><? echo $lang['status']; ?> :</td>
									<td class="text10b">
										<input type="radio" name="host[host_activate]" value="1" <? if ($hosts[$h]->get_activate()) echo "checked"; ?>> <? echo $lang['enable']; ?>&nbsp;&nbsp;&nbsp;&nbsp;
										<input type="radio" name="host[host_activate]" value="0" <? if (!$hosts[$h]->get_activate()) echo "checked"; ?>> <? echo $lang['disable']; ?>
									</td>
								</tr>
								<tr>
									<td valign="top">Comment :</td>
									<td class="text10b">
									<?
									$ct = NULL;
									$ct_temp = NULL;
									if ($hosts[$h]->get_comment())
										$ct = $hosts[$h]->get_comment();
									if ($TPL)
										$ct_temp = $hosts[$TPL]->get_comment();
									if ($TPL)	{ ?>
										<input type="checkbox" onClick="enabledTemplateFieldTarea(this.form.templateComment);" <? if ($ct) echo "checked"; ?>>
									<? } ?>
										<textarea name="host[host_comment]" cols="25" rows="4" id="templateComment" <? if ($TPL && !$ct) echo "disabled";?>><? if ($ct) echo preg_replace("/(#BLANK#)/", "", $ct); else echo preg_replace("/(#BLANK#)/", "", $ct_temp); ?></textarea>
									</td>
								</tr>
								<tr>
									<td align="left">
										<? echo $lang['required']; ?>&nbsp;&nbsp;
									</td>
									<td align="center">
										<input type="hidden" name="host[host_id]" value="<? echo $h ?>">
										<input type="submit" name="ChangeHost" value="<? echo $lang['save']; ?>"  onClick="selectAll(this.form.selectHostParent); selectAll(this.form.selectHostGroup); selectAll(this.form.selectContactGroup);">
									</td>
								</tr>
							</table>
							</form>
					<? } else if (!strcmp($_GET["o"], "w")) { ?>
							<table align="center" border="0" width="390" cellpadding="0" cellspacing="4">
								<? if ($hosts[$h]->get_host_template())	{
									$htm_id = $hosts[$h]->get_host_template();
								?>
								<tr>
									<td colspan="2" align="center" class="text10b">
										<? echo $lang["htm_use"].":<br>"."<a href='phpradmin.php?p=123&htm_id=$htm_id&o=w' class='text10bc'>".$hosts[$htm_id]->get_name()."</a>"; ?>
									</td>
								</tr>
								<? } ?>
								<tr>
									<td>Name :</td>
									<td class="text10b"><? echo $hosts[$h]->get_name();?></td>
								</tr>
								<tr>
									<td>Alias :</td>
									<td class="text10b">
									<?
									if ($hosts[$h]->get_alias())
										echo $hosts[$h]->get_alias();
									else if ($hosts[$h]->get_host_template() && $hosts[$hosts[$h]->get_host_template()]->get_alias())
										echo $hosts[$hosts[$h]->get_host_template()]->get_alias();
									?>
									</td>
								</tr>
								<tr>
									<td>Address :</td>
									<td class="text10b">
									<?
									if ($hosts[$h]->get_address())
										echo $hosts[$h]->get_address();
									else if ($hosts[$h]->get_host_template() && $hosts[$hosts[$h]->get_host_template()]->get_address())
										echo $hosts[$hosts[$h]->get_host_template()]->get_address();
									?>
									</td>
								</tr>
								<tr>
									<td valign="top">Parents :</td>
									<td style="white-space: nowrap;">
									<?
									if (count($hosts[$h]->parents))	{
										foreach ($hosts[$h]->parents as $parent)	{
											echo "<li><a href='phpradmin.php?p=102&h=" .$parent->get_id(). "&o=w' class='text10' style='white-space: nowrap;";
											if (!$parent->get_activate()) echo " text-decoration: line-through;";
											echo "'>".$parent->get_name()."</a></li>";
											unset($parent);
										}
									} else if ($hosts[$h]->get_host_template() && count($hosts[$hosts[$h]->get_host_template()]->parents))
										foreach ($hosts[$hosts[$h]->get_host_template()]->parents as $parent)	{
											echo "<li><a href='phpradmin.php?p=102&h=" .$parent->get_id(). "&o=w' class='text10' style='white-space: nowrap;'";
											if (!$parent->get_activate()) echo " text-decoration: line-through;";
											echo ">".$parent->get_name()."</a></li>";
											unset($parent);
										}
									?>
									</td>
								</tr>
								<tr>
									<td>Host Groups :</td>
									<td style="white-space: nowrap;">
									<?
									if (isset($hosts[$h]->hostGroups) && count($hosts[$h]->hostGroups))	{
										foreach ($hosts[$h]->hostGroups as $hg)	{
											echo "<li><a href='phpradmin.php?p=103&hg=" .$hg->get_id(). "&o=w' class='text10' style='white-space: nowrap;";
											if (!$hg->get_activate()) echo " text-decoration: line-through;";
											echo "'>".$hg->get_name()."</a></li>";
											unset($hg);
										}
									} else if ($hosts[$h]->get_host_template() && count($hosts[$hosts[$h]->get_host_template()]->hostGroups))
										foreach ($hosts[$hosts[$h]->get_host_template()]->hostGroups as $hg)	{
											echo "<li><a href='phpradmin.php?p=103&hg=" .$hg->get_id(). "&o=w' class='text10' style='white-space: nowrap;";
											if (!$hg->get_activate()) echo " text-decoration: line-through;";
											echo "'>".$hg->get_name()."</a></li>";
											unset($hg);
										}
									?>
									</td>
								</tr>
								<tr>
									<td>Check_command :</td>
									<td class="text10b">
									<?
									if ($hosts[$h]->get_check_command())
										echo $commands[$hosts[$h]->get_check_command()]->get_name();
									else if ($hosts[$h]->get_host_template() && $hosts[$hosts[$h]->get_host_template()]->get_check_command())
										echo $commands[$hosts[$hosts[$h]->get_host_template()]->get_check_command()]->get_name();
									?>
									</td>
								</tr>
								<tr>
									<td>Max_check_attempts :</td>
									<td class="text10b">
									<?
									if ($hosts[$h]->get_max_check_attempts())
										echo $hosts[$h]->get_max_check_attempts();
									else if ($hosts[$h]->get_host_template() && $hosts[$hosts[$h]->get_host_template()]->get_max_check_attempts())
										echo $hosts[$hosts[$h]->get_host_template()]->get_max_check_attempts();
									?>
									</td>
								</tr>
								<?	if (!strcmp("2", $oreon->user->get_version()))	{	?>
								<tr>
									<td>Check_interval :</td>
									<td class="text10b">
									<?
									if ($hosts[$h]->get_check_interval())
										echo preg_replace("/(99999)/", "0", $hosts[$h]->get_check_interval())." * ".$oreon->Nagioscfg->get_interval_length()." ".$lang["time_sec"];
									else if ($hosts[$h]->get_host_template() && $hosts[$hosts[$h]->get_host_template()]->get_check_interval())
										echo preg_replace("/(99999)/", "0", $hosts[$hosts[$h]->get_host_template()]->get_check_interval())." * ".$oreon->Nagioscfg->get_interval_length()." ".$lang["time_sec"];
									?>
									</td>
								</tr>
								<?	}	if (!strcmp("1", $oreon->user->get_version()))	{	?>
								<tr>
									<td>Checks_enabled :</td>
									<td class="text10b">
									<?
									if ($hosts[$h]->get_checks_enabled() && $hosts[$h]->get_checks_enabled() != 2)
										echo $value_flag[$hosts[$h]->get_checks_enabled()];
									else if ($hosts[$h]->get_host_template() && $hosts[$hosts[$h]->get_host_template()]->get_checks_enabled())
										echo $value_flag[$hosts[$hosts[$h]->get_host_template()]->get_checks_enabled()];
									else
										echo $value_flag[2];
									?>
									</td>
								</tr>
								<?	}	if (!strcmp("2", $oreon->user->get_version()))	{	?>
								<tr>
									<td>Active_checks_enabled :</td>
									<td class="text10b">
									<?
									if ($hosts[$h]->get_active_checks_enabled() && $hosts[$h]->get_active_checks_enabled() != 2)
										echo $value_flag[$hosts[$h]->get_active_checks_enabled()];
									else if ($hosts[$h]->get_host_template() && $hosts[$hosts[$h]->get_host_template()]->get_active_checks_enabled())
										echo $value_flag[$hosts[$hosts[$h]->get_host_template()]->get_active_checks_enabled()];
									else
										echo $value_flag[2];
									?>
									</td>
								</tr>
								<tr>
									<td>Passive_checks_enabled :</td>
									<td class="text10b">
									<?
									if ($hosts[$h]->get_passive_checks_enabled() && $hosts[$h]->get_passive_checks_enabled() != 2)
										echo $value_flag[$hosts[$h]->get_passive_checks_enabled()];
									else if ($hosts[$h]->get_host_template() && $hosts[$hosts[$h]->get_host_template()]->get_passive_checks_enabled())
										echo $value_flag[$hosts[$hosts[$h]->get_host_template()]->get_passive_checks_enabled()];
									else
										echo $value_flag[2];
									?>
									</td>
								</tr>
								<tr>
									<td>Check_period :</td>
									<td class="text10b">
									<?
									if ($hosts[$h]->get_check_period())
										echo $timePeriods[$hosts[$h]->get_check_period()]->get_name();
									else if ($hosts[$h]->get_host_template() && $hosts[$hosts[$h]->get_host_template()]->get_check_period())
										echo $timePeriods[$hosts[$hosts[$h]->get_host_template()]->get_check_period()]->get_name();
									?>
									</td>
								</tr>
								<tr>
									<td>Obsess_over_host :</td>
									<td class="text10b">
									<?
									if ($hosts[$h]->get_obsess_over_host() && $hosts[$h]->get_obsess_over_host() != 2)
										echo $value_flag[$hosts[$h]->get_obsess_over_host()];
									else if ($hosts[$h]->get_host_template() && $hosts[$hosts[$h]->get_host_template()]->get_obsess_over_host())
										echo $value_flag[$hosts[$hosts[$h]->get_host_template()]->get_obsess_over_host()];
									else
										echo $value_flag[2];
									?>
									</td>
								</tr>
								<tr>
									<td>Check_freshness :</td>
									<td class="text10b">
									<?
									if ($hosts[$h]->get_check_freshness() && $hosts[$h]->get_check_freshness() != 2)
										echo $value_flag[$hosts[$h]->get_check_freshness()];
									else if ($hosts[$h]->get_host_template() && $hosts[$hosts[$h]->get_host_template()]->get_check_freshness())
										echo $value_flag[$hosts[$hosts[$h]->get_host_template()]->get_check_freshness()];
									?>
									</td>
								</tr>
								<tr>
									<td>Freshness_threshold :</td>
									<td class="text10b">
									<?
									if ($hosts[$h]->get_freshness_threshold())
										echo preg_replace("/(99999)/", "0", $hosts[$h]->get_freshness_threshold())." ".$lang["time_sec"];
									else if ($hosts[$h]->get_host_template() && $hosts[$hosts[$h]->get_host_template()]->get_freshness_threshold())
										echo preg_replace("/(99999)/", "0", $hosts[$hosts[$h]->get_host_template()]->get_freshness_threshold())." ".$lang["time_sec"];
									else
										echo $value_flag[2];
									?>
									</td>
								</tr>
								<? } ?>
								<tr>
									<td>Event_handler_enabled :</td>
									<td class="text10b">
									<?
									if ($hosts[$h]->get_event_handler_enabled() && $hosts[$h]->get_event_handler_enabled() != 2)
										echo $value_flag[$hosts[$h]->get_event_handler_enabled()];
									else if ($hosts[$h]->get_host_template() && $hosts[$hosts[$h]->get_host_template()]->get_event_handler_enabled())
										echo $value_flag[$hosts[$hosts[$h]->get_host_template()]->get_event_handler_enabled()];
									else
										echo $value_flag[2];
									?>
									</td>
								</tr>
								<tr>
									<td>Event_handler :</td>
									<td class="text10b">
									<?
									if ($hosts[$h]->get_event_handler())
										echo $commands[$hosts[$h]->get_event_handler()]->get_name();
									else if ($hosts[$h]->get_host_template() && $hosts[$hosts[$h]->get_host_template()]->get_event_handler())
										echo $commands[$hosts[$hosts[$h]->get_host_template()]->get_event_handler()]->get_name();
									?>
									</td>
								</tr>
								<tr>
									<td>Low_flap_threshold :</td>
									<td class="text10b">
									<?
									if ($hosts[$h]->get_low_flap_threshold())
										echo preg_replace("/(99999)/", "0", $hosts[$h]->get_low_flap_threshold())." %";
									else if ($hosts[$h]->get_host_template() && $hosts[$hosts[$h]->get_host_template()]->get_low_flap_threshold())
										echo preg_replace("/(99999)/", "0", $hosts[$hosts[$h]->get_host_template()]->get_low_flap_threshold())." %";
									else
										echo $value_flag[2];
									?>
									</td>
								</tr>
								<tr>
									<td>High_flap_threshold :</td>
									<td class="text10b">
									<?
									if ($hosts[$h]->get_high_flap_threshold())
										echo preg_replace("/(99999)/", "0", $hosts[$h]->get_high_flap_threshold())." %";
									else if ($hosts[$h]->get_host_template() && $hosts[$hosts[$h]->get_host_template()]->get_high_flap_threshold())
										echo preg_replace("/(99999)/", "0", $hosts[$hosts[$h]->get_host_template()]->get_high_flap_threshold())." %";
									else
										echo $value_flag[2];
									?>
									</td>
								</tr>
								<tr>
									<td>Flap_detection_enabled :</td>
									<td class="text10b">
									<?
									if ($hosts[$h]->get_flap_detection_enabled() && $hosts[$h]->get_flap_detection_enabled() != 2)
										echo $value_flag[$hosts[$h]->get_flap_detection_enabled()];
									else if ($hosts[$h]->get_host_template() && $hosts[$hosts[$h]->get_host_template()]->get_flap_detection_enabled())
										echo $value_flag[$hosts[$hosts[$h]->get_host_template()]->get_flap_detection_enabled()];
									else
										echo $value_flag[2];
									?>
									</td>
								</tr>
								<tr>
									<td>Process_perf_data :</td>
									<td class="text10b">
									<?
									if ($hosts[$h]->get_process_perf_data() && $hosts[$h]->get_process_perf_data() != 2)
										echo $value_flag[$hosts[$h]->get_process_perf_data()];
									else if ($hosts[$h]->get_host_template() && $hosts[$hosts[$h]->get_host_template()]->get_process_perf_data())
										echo $value_flag[$hosts[$hosts[$h]->get_host_template()]->get_process_perf_data()];
									else
										echo $value_flag[2];
									?>
									</td>
								</tr>
								<tr>
									<td>Retain_status_information :</td>
									<td class="text10b">
									<?
									if ($hosts[$h]->get_retain_status_information() && $hosts[$h]->get_retain_status_information() != 2)
										echo $value_flag[$hosts[$h]->get_retain_status_information()];
									else if ($hosts[$h]->get_host_template() && $hosts[$hosts[$h]->get_host_template()]->get_retain_status_information())
										echo $value_flag[$hosts[$hosts[$h]->get_host_template()]->get_retain_status_information()];
									else
										echo $value_flag[2];
									?>
									</td>
								</tr>
								<tr>
									<td style="white-space: nowrap;">Retain_nonstatus_information :</td>
									<td class="text10b">
									<?
									if ($hosts[$h]->get_retain_nonstatus_information() && $hosts[$h]->get_retain_nonstatus_information() != 2)
										echo $value_flag[$hosts[$h]->get_retain_nonstatus_information()];
									else if ($hosts[$h]->get_host_template() && $hosts[$hosts[$h]->get_host_template()]->get_retain_nonstatus_information())
										echo $value_flag[$hosts[$hosts[$h]->get_host_template()]->get_retain_nonstatus_information()];
									else
										echo $value_flag[2];
									?>
									</td>
								</tr>
								<?	if (!strcmp("2", $oreon->user->get_version()))	{	?>
								<tr>
									<td>Contact Groups :</td>
									<td style="white-space: nowrap;">
									<?
									if (count($hosts[$h]->contactgroups))	{
										foreach ($hosts[$h]->contactgroups as $cg)	{
											echo "<li><a href='phpradmin.php?p=107&cg=" .$cg->get_id(). "&o=w' class='text10' style='white-space: nowrap;";
											if (!$cg->get_activate()) echo " text-decoration: line-through;";
											echo "'>".$cg->get_name()."</a></li>";
											unset($cg);
										}
									} else if ($hosts[$h]->get_host_template() && count($hosts[$hosts[$h]->get_host_template()]->contactgroups))
										foreach ($hosts[$hosts[$h]->get_host_template()]->contactgroups as $cg)	{
											echo "<li><a href='phpradmin.php?p=107&cg=" .$cg->get_id(). "&o=w' class='text10' style='white-space: nowrap;";
											if (!$cg->get_activate()) echo " text-decoration: line-through;";
											echo "'>".$cg->get_name()."</a></li>";
											unset($cg);
										}
									?>
									</td>
								</tr>
								<?	}	?>
								<tr>
									<td>Notification_interval :</td>
									<td class="text10b">
									<?
									if ($hosts[$h]->get_notification_interval())
										echo preg_replace("/(99999)/", "0", $hosts[$h]->get_notification_interval())." * ".$oreon->Nagioscfg->get_interval_length()." ".$lang["time_sec"];
									else if ($hosts[$h]->get_host_template() && $hosts[$hosts[$h]->get_host_template()]->get_notification_interval())
										echo preg_replace("/(99999)/", "0", $hosts[$hosts[$h]->get_host_template()]->get_notification_interval())." * ".$oreon->Nagioscfg->get_interval_length()." ".$lang["time_sec"];
									?>
									</td>
								</tr>
								<tr>
									<td>Notification_period :</td>
									<td class="text10b">
									<?
									if ($hosts[$h]->get_notification_period())
										echo $timePeriods[$hosts[$h]->get_notification_period()]->get_name();
									else if ($hosts[$h]->get_host_template() && $hosts[$hosts[$h]->get_host_template()]->get_notification_period())
										echo $timePeriods[$hosts[$hosts[$h]->get_host_template()]->get_notification_period()]->get_name();
									?>
									</td>
								</tr>
								<tr>
									<td>Notification_options :</td>
									<td class="text10b">
									<?
									if ($hosts[$h]->get_notification_options())
										echo $hosts[$h]->get_notification_options();
									else if ($hosts[$h]->get_host_template() && $hosts[$hosts[$h]->get_host_template()]->get_notification_options())
										echo $hosts[$hosts[$h]->get_host_template()]->get_notification_options();
									?>
									</td>
								</tr>
								<tr>
									<td>Notifications_enabled :</td>
									<td class="text10b">
									<?
									if ($hosts[$h]->get_notifications_enabled() && $hosts[$h]->get_notifications_enabled() != 2)
										echo $value_flag[$hosts[$h]->get_notifications_enabled()];
									else if ($hosts[$h]->get_host_template() && $hosts[$hosts[$h]->get_host_template()]->get_notifications_enabled())
										echo $value_flag[$hosts[$hosts[$h]->get_host_template()]->get_notifications_enabled()];
									else
										echo $value_flag[2];
									?>
									</td>
								</tr>
								<tr>
									<td>Stalking_options :</td>
									<td class="text10b">
									<?
									if ($hosts[$h]->get_stalking_options())
										echo $hosts[$h]->get_stalking_options();
									else if ($hosts[$h]->get_host_template() && $hosts[$hosts[$h]->get_host_template()]->get_stalking_options())
										echo $hosts[$hosts[$h]->get_host_template()]->get_stalking_options();
									?>
									</td>
								</tr>
								<tr>
									<td><? echo $lang['status']; ?> :</td>
									<td class="text10b">
									<?
									if ($hosts[$h]->get_activate())
										echo $lang['enable'];
									else
										echo $lang['disable'];
									?>
									</td>
								</tr>
								<tr>
									<td valign="top">Comment :</td>
									<td class="text10b">
									<?
									if ($hosts[$h]->get_comment())
										echo "<textarea cols='20' rows='4' readonly>".preg_replace("/(#BLANK#)/", "", $hosts[$h]->get_comment())."</textarea>";
									else if ($hosts[$h]->get_host_template() && $hosts[$hosts[$h]->get_host_template()]->get_comment())
										echo "<textarea cols='20' rows='4' readonly>".preg_replace("/(#BLANK#)/", "", $hosts[$hosts[$h]->get_host_template()]->get_comment())."</textarea>";
									?>
									</td>
								</tr>
								<tr>
									<td colspan="2">
									<div align="center" style="padding: 10px;">
										<a href="phpradmin.php?p=102&o=c&h=<? echo $h ?>" class="text10bc"><? echo $lang['modify']; ?></a>&nbsp;&nbsp;&nbsp;&nbsp;
										<a href="phpradmin.php?p=102&o=d&h=<? echo $h ?>" class="text10bc" onclick="return confirm('<? echo $lang['confirm_removing']; ?>')"><? echo $lang['delete']; ?></a>
									</div>
									</td>
								</tr>
							</table>
						<?
						} else if (!strcmp($_GET["o"], "a")) {
							if (isset($_POST["htm_id"]) && strcmp($_POST["htm_id"], NULL))
								$htm_id = $_POST["htm_id"];
							else
								unset ($_POST["htm_id"]);
							if (isset($_POST["h"]))
								$h = $_POST["h"];
						?>
							<form action="" method="post" name="AddHostForm">
							<table border="0" cellpadding="0" cellspacing="3" width="390">
								<? if (isset($htms) && count($htms)) { ?>
								<tr>
									<td class="text10b" style="white-space: nowrap;"><? echo $lang['htm_use']; ?> :</td>
									<td>
										<select name="htm_id" onChange="this.form.submit();">
											<option value=""></option>
											<?
											if (isset($htms))
												foreach ($htms as $htm)	{
													echo "<option value='" .$htm->get_id(). "'";
													if (isset($_POST["htm_id"]) && ($htm_id == $htm->get_id()))
														echo " selected";
													echo ">" .$hosts[$htm->get_id()]->get_name(). "</option>";
													unset($htm);
												}
											?>
										</select>
									</td>
								</tr>
								<? } ?>
								<tr>
									<td>Name :<font color="red">*</font></td>
									<td class="text10b">
										<?
										$name = NULL;
										if (isset($_POST["htm_id"]) && $hosts[$htm_id]->get_name())
											$name = $hosts[$htm_id]->get_name();
										?>
										<input type="text" name="host[host_name]" value="<? echo str_replace("HTemplate_", "", $name); ?>">
									</td>
								</tr>
								<tr>
									<td>Alias :<font color="red">*</font></td>
									<td class="text10b">
										<?
										$alias = NULL;
										if (isset($_POST["htm_id"]) && $hosts[$htm_id]->get_alias())
											$alias = $hosts[$htm_id]->get_alias();
										if ($alias)	{ ?>
											<input type="checkbox" onClick="enabledTemplateField(this.form.templateAlias, '<? echo $alias; ?>', '');">
										<? } ?>
										<input type="text" name="host[host_alias]" id="templateAlias" value="<? echo $alias; ?>" <? if ($alias) echo "disabled";?>>
									</td>
								</tr>
								<tr>
									<td>Address (ip, dns) :<font color="red">*</font></td>
									<td class="text10b">
										<?
										$address = NULL;
										if (isset($_POST["htm_id"]) && $hosts[$htm_id]->get_address())
											$address = $hosts[$htm_id]->get_address();
										if ($address)	{ ?>
											<input type="checkbox" onClick="enabledTemplateField(this.form.templateAddress, '<? echo $address; ?>', '');">
										<? } ?>
										<input type="text" name="host[host_address]" id="templateAddress" value="<? echo $address; ?>" <? if ($address) echo "disabled";?>>
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<div align="center" class="text10b">
											Parents
											<?
											$parents = NULL;
											if (isset($_POST["htm_id"]))
												$parents = & $hosts[$htm_id]->parents;
											if (count($parents))	{ ?>
												<input type="checkbox" onClick="enabledTemplateFieldSelect(this.form.templateHostParentBase);enabledTemplateFieldSelect(this.form.selectHostParent);">
											<? } ?>
										</div>
										<table border="0" align="center">
											<tr>
												<td align="left" style="padding: 3px;">
													<select name="selectHostParentBase" id="templateHostParentBase" size="8" <? if (count($parents)) echo "disabled";?> multiple>
													<?
														if (isset($hosts))
															foreach ($hosts as $host)		{
																if ($host->get_register())	{
																	if (isset($_POST["htm_id"]))	{
																		if (!array_key_exists($host->get_id(), $hosts[$htm_id]->parents))
																			echo "<option value='".$host->get_id()."'>".$host->get_name()."</option>";
																	}
																	else
																		echo "<option value='".$host->get_id()."'>".$host->get_name()."</option>";
																}
																unset($host);
															}
													?>
													</select>
												</td>
												<td style="padding-left: 5px; padding-right: 5px;" valign="middle" align="center">
													<input type="button" name="add" value="<? echo $lang['add']; ?>" onClick="Moove(this.form.selectHostParentBase,this.form.selectHostParent);"><br><br><br>
													<input type="button" name="remove" value="<? echo $lang['delete']; ?>" onClick="Moove(this.form.selectHostParent,this.form.selectHostParentBase);">
												</td>
												<td>
													<select id="selectHostParent" name="selectHostParent[]" size="8" <? if (count($parents)) echo "disabled";?> multiple>
													<?
														if (isset($_POST["htm_id"]))
															foreach ($hosts[$htm_id]->parents as $existing_parent)	{
																echo "<option value='".$existing_parent->get_id()."'>".$existing_parent->get_name()."</option>";
																unset($existing_parent);
															}
													?>
													</select>
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<div align="center" class="text10b">
											Host Groups
											<?
											$hgs = NULL;
											if (isset($_POST["htm_id"]))
												$hgs = & $hosts[$htm_id]->hostGroups;
											if (count($hgs))	{ ?>
												<input type="checkbox" onClick="enabledTemplateFieldSelect(this.form.templateHostGroupBase);enabledTemplateFieldSelect(this.form.selectHostGroup);">
											<? } ?>
										</div>
										<table border="0" align="center">
											<tr>
												<td align="left" style="padding: 3px;">
													<select name="selectHostGroupBase" id="templateHostGroupBase" size="8" <? if (count($hgs)) echo "disabled";?> multiple>
													<?
														if (isset($hostGroups))
															foreach ($hostGroups as $hostGroup)	{
																if (isset($_POST["htm_id"]))	{
																	if (!array_key_exists($hostGroup->get_id(), $hosts[$htm_id]->hostGroups))
																		echo "<option value='".$hostGroup->get_id()."'>".$hostGroup->get_name()."</option>";
																}
																else
																	echo "<option value='".$hostGroup->get_id()."'>".$hostGroup->get_name()."</option>";
																unset($hostGroup);
															}
													?>
													</select>
												</td>
												<td style="padding-left: 5px; padding-right: 5px;" valign="middle" align="center">
													<input type="button" name="add" value="<? echo $lang['add']; ?>" onClick="Moove(this.form.selectHostGroupBase,this.form.selectHostGroup);"><br><br><br>
													<input type="button" name="remove" value="<? echo $lang['delete']; ?>" onClick="Moove(this.form.selectHostGroup,this.form.selectHostGroupBase);">
												</td>
												<td>
													<select id="selectHostGroup" name="selectHostGroup[]" size="8" <? if (count($hgs)) echo "disabled";?> multiple>
													<?
														if (isset($_POST["htm_id"]))
															foreach ($hosts[$htm_id]->hostGroups as $existing_hg)	{
																echo "<option value='".$existing_hg->get_id()."'>".$existing_hg->get_name()."</option>";
																unset($existing_hg);
															}
													?>
													</select>
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td>Check_command :</td>
									<td class="text10b" style="white-space: nowrap;">
									<?
									$cc = NULL;
									if (isset($_POST["htm_id"]))
										$cc = $hosts[$htm_id]->get_check_command();
									if ($cc)	{ ?>
										<input type="checkbox" onClick="enabledTemplateField(this.form.templateCheckCommand, <? echo $cc; ?>, '');">
									<? } ?>
									<select name="host[command_command_id]" id="templateCheckCommand" <? if ($cc) echo "disabled"; ?>>
									<?
										echo "<option></option>";
										if (isset($commands))
											foreach ($commands as $cmd)	{
												if (!strstr($cmd->get_name(), "check_graph") && !strcmp($cmd->get_type(), "2"))	{
													echo "<option value='" . $cmd->get_id() . "'";
													if ($cmd->get_id() == $cc)
														echo " selected";
													echo ">" . $cmd->get_name() . "</option>";
												}
												unset($cmd);
											}
									?>
									</select>
									</td>
								</tr>
								<tr>
									<td>Max_check_attempts :<font color="red">*</font></td>
									<td class="text10b">
										<?
										$mca = NULL;
										if (isset($_POST["htm_id"]))
											$mca = $hosts[$htm_id]->get_max_check_attempts();
										if ($mca)	{ ?>
											<input type="checkbox" onClick="enabledTemplateField(this.form.templateMaxCheckAttempts, <? echo $mca; ?>, '');">
										<? } ?>
										<input size="5"  type="text" name="host[host_max_check_attempts]" id="templateMaxCheckAttempts" value="<? echo $mca; ?>" <? if ($mca) echo "disabled";?>>
									</td>
								</tr>
								<? if (!strcmp("1", $oreon->user->get_version()))	{	?>
								<tr>
									<td>Checks_enabled :</td>
									<td class="text10b">
									<?
									$ce = NULL;
									if (isset($_POST["htm_id"]))
										$ce = $hosts[$htm_id]->get_checks_enabled();
									if ($ce)	{ ?>
										<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateChecksEnabled, '<?  echo $ce; ?>', '');">
									<? } ?>
									<input name="host[host_check_enabled]" type="radio" value="1" id="templateChecksEnabled" <? if (isset($_POST["htm_id"])) if ($ce == 1) echo "checked"; ?> <? if ($ce) echo "disabled"; ?>> Yes -
									<input name="host[host_check_enabled]" type="radio" value="3" id="templateChecksEnabled" <? if (isset($_POST["htm_id"])) if ($ce == 3) echo "checked"; ?> <? if ($ce) echo "disabled"; ?>> No -
									<input name="host[host_check_enabled]" type="radio" value="2" id="templateChecksEnabled" <? if (isset($_POST["htm_id"])) { if ($ce == 2) echo "checked";} else echo "checked"; ?> <? if ($ce) echo "disabled"; ?>> Nothing
									</td>
								</tr>
								<? } if (!strcmp("2", $oreon->user->get_version()))	{	?>
								<tr>
									<td>Check_interval :</td>
									<td class="text10b">
									<?
										$ci = NULL;
										if (isset($_POST["htm_id"]))
											$ci = $hosts[$htm_id]->get_check_interval();
										if ($ci)	{ ?>
											<input type="checkbox" onClick="enabledTemplateField(this.form.templateCheckInterval, <? echo preg_replace("/(99999)/", "0", $ci); ?>, '');">
										<? } ?>
										<input size="5"  type="text" name="host[host_check_interval]" id="templateCheckInterval" value="<? echo preg_replace("/(99999)/", "0", $ci); ?>" <? if ($ci) echo "disabled";?>>
										<? echo $lang["time_min"]; ?>
									</td>
								</tr>
								<tr>
									<td>Active_checks_enabled :</td>
									<td class="text10b">
									<?
									$ace = NULL;
									if (isset($_POST["htm_id"]))
										$ace = $hosts[$htm_id]->get_active_checks_enabled();
									if ($ace)	{ ?>
										<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateActiveChecksEnabled, '<?  echo $ace; ?>', '');">
									<? } ?>
									<input name="host[host_active_checks_enabled]" type="radio" value="1" id="templateActiveChecksEnabled" <? if (isset($_POST["htm_id"])) if ($ace == 1) echo "checked"; ?> <? if ($ace) echo "disabled"; ?>> Yes -
									<input name="host[host_active_checks_enabled]" type="radio" value="3" id="templateActiveChecksEnabled" <? if (isset($_POST["htm_id"])) if ($ace == 3) echo "checked"; ?> <? if ($ace) echo "disabled"; ?>> No -
									<input name="host[host_active_checks_enabled]" type="radio" value="2" id="templateActiveChecksEnabled" <? if (isset($_POST["htm_id"])) { if ($ace == 2) echo "checked";} else echo "checked"; ?> <? if ($ace) echo "disabled"; ?>> Nothing
									</td>
								</tr>
								<tr>
									<td>Passive_checks_enabled :</td>
									<td class="text10b">
									<?
									$pce = NULL;
									if (isset($_POST["htm_id"]))
										$pce = $hosts[$htm_id]->get_passive_checks_enabled();
									if ($pce)	{ ?>
										<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templatePassiveChecksEnabled, '<? echo $pce; ?>', '');">
									<? } ?>
									<input name="host[host_passive_checks_enabled]" type="radio" id="templatePassiveChecksEnabled" value="1" <? if (isset($_POST["htm_id"])) if ($pce == 1) echo "checked"; ?> <? if ($pce) echo "disabled";?>> Yes -
									<input name="host[host_passive_checks_enabled]" type="radio" id="templatePassiveChecksEnabled" value="3" <? if (isset($_POST["htm_id"])) if ($pce == 3) echo "checked"; ?> <? if ($pce) echo "disabled";?>> No -
									<input name="host[host_passive_checks_enabled]" type="radio" id="templatePassiveChecksEnabled" value="2" <? if (isset($_POST["htm_id"])) { if ($pce == 2) echo "checked";} else echo "checked"; ?> <? if ($pce) echo "disabled";?>> Nothing
									</td>
								</tr>
								<tr>
									<td>Check_period :<font color="red">*</font></td>
									<td class="text10b">
									<?
									$cp = NULL;
									if (isset($_POST["htm_id"]))
										$cp = $hosts[$htm_id]->get_check_period();
									if ($cp)	{ ?>
										<input type="checkbox" onClick="enabledTemplateField(this.form.templateCheckPeriod, <? echo $cp; ?>, '');">
									<? } ?>
									<select name="host[timeperiod_tp_id]" id="templateCheckPeriod" <? if ($cp) echo "disabled"; ?>>
									<?
										if (isset($timePeriods))
											foreach ($timePeriods as $tp)	{
												echo "<option value='".$tp->get_id()."'";
												if ($tp->get_id() == $cp)
													echo " selected";
												echo ">" . $tp->get_name() . "</option>";
												unset($tp);
											}
									?>
									</select>
									</td>
								</tr>
								<tr>
									<td>Obsess_over_host :</td>
									<td class="text10b">
									<?
									$ooh = NULL;
									if (isset($_POST["htm_id"]))
										$ooh = $hosts[$htm_id]->get_obsess_over_host();
									if ($ooh)	{ ?>
										<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateObsessOverHost, '<? echo $ooh; ?>', '');">
									<? } ?>
									<input name="host[host_obsess_over_host]" type="radio" value="1" id="templateObsessOverHost" <? if (isset($_POST["htm_id"])) if ($ooh == 1) echo "checked"; ?> <? if ($ooh) echo "disabled";?>> Yes -
									<input name="host[host_obsess_over_host]" type="radio" value="3" id="templateObsessOverHost" <? if (isset($_POST["htm_id"])) if ($ooh == 3) echo "checked"; ?> <? if ($ooh) echo "disabled";?>> No -
									<input name="host[host_obsess_over_host]" type="radio" value="2" id="templateObsessOverHost" <? if (isset($_POST["htm_id"])) { if ($ooh == 2) echo "checked";} else echo "checked"; ?> <? if ($ooh) echo "disabled";?>> Nothing
									</td>
								</tr>
								<tr>
									<td>Check_freshness :</td>
									<td class="text10b">
									<?
									$cf = NULL;
									if (isset($_POST["htm_id"]))
										$cf = $hosts[$htm_id]->get_check_freshness();
									if ($cf)	{ ?>
										<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateCheckFreshness, '<? echo $cf; ?>', '');">
									<? } ?>
									<input name="host[host_check_freshness]" type="radio" value="1" id="templateCheckFreshness" <? if (isset($_POST["htm_id"])) if ($cf == 1) echo "checked"; ?> <? if ($cf) echo "disabled";?>> Yes -
									<input name="host[host_check_freshness]" type="radio" value="3" id="templateCheckFreshness" <? if (isset($_POST["htm_id"])) if ($cf == 3) echo "checked"; ?> <? if ($cf) echo "disabled";?>> No -
									<input name="host[host_check_freshness]" type="radio" value="2" id="templateCheckFreshness" <? if (isset($_POST["htm_id"])) { if ($ooh == 2) echo "checked";} else echo "checked"; ?> <? if ($cf) echo "disabled";?>> Nothing
									</td>
								</tr>
								<tr>
									<td>Freshness_threshold :</td>
									<td class="text10b">
										<?
										$ft = NULL;
										if (isset($_POST["htm_id"]))
											$ft = $hosts[$htm_id]->get_freshness_threshold();
										if ($ft)	{ ?>
											<input type="checkbox" OnClick="enabledTemplateFieldSelect(this.form.ftNothingBox);enabledTemplateField(this.form.templateFreshnessThreshold, <? echo preg_replace("/(99999)/", "0", $ft); ?>, '');">
										<? } ?>
										<input size="5"  type="text" id="templateFreshnessThreshold" name="host[host_freshness_threshold]" value="<? echo preg_replace("/(99999)/", "0", $ft) ?>" <? if ($ft) echo "disabled";?>>
										<? echo $lang["time_sec"]; ?>
										&nbsp;&nbsp;<input type="checkbox" name="ftNothingBox" value="" OnClick="enabledTemplateFieldSelect(this.form.templateFreshnessThreshold);" <? if ($ft) echo "disabled"; ?>>Nothing
									</td>
								</tr>
								<?	}	?>
								<tr>
									<td>Event_handler_enabled :</td>
									<td class="text10b">
									<?
									$ehe = NULL;
									if (isset($_POST["htm_id"]))
										$ehe = $hosts[$htm_id]->get_event_handler_enabled();
									if ($ehe)	{ ?>
										<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateEventHandlerEnabled, '<? echo $ehe; ?>', '');">
									<? } ?>
									<input name="host[host_event_handler_enabled]" type="radio" id="templateEventHandlerEnabled" value="1" <? if (isset($_POST["htm_id"])) if ($ehe == 1) echo "checked"; ?> <? if ($ehe) echo "disabled";?>> Yes -
									<input name="host[host_event_handler_enabled]" type="radio" id="templateEventHandlerEnabled" value="3" <? if (isset($_POST["htm_id"])) if ($ehe == 3) echo "checked"; ?> <? if ($ehe) echo "disabled";?>> No -
									<input name="host[host_event_handler_enabled]" type="radio" id="templateEventHandlerEnabled" value="2" <? if (isset($_POST["htm_id"])) { if ($ehe == 2) echo "checked";} else echo "checked"; ?> <? if ($ehe) echo "disabled";?>> Nothing
									</td>
								</tr>
								<tr>
									<td>Event_handler :</td>
									<td class="text10b">
									<?
									$eh = NULL;
									if (isset($_POST["htm_id"]))
										$eh = $hosts[$htm_id]->get_event_handler();
									if ($eh)	{ ?>
										<input type="checkbox" onClick="enabledTemplateField(this.form.templateEventHandler, <? echo $eh; ?>, '');">
									<? } ?>
									<select name="host[command_command_id2]" id="templateEventHandler" <? if ($eh) echo "disabled"; ?>>
									<?
										echo "<option></option>";
										if (isset($commands))
											foreach ($commands as $cmd)	{
												if (!strstr($cmd->get_name(), "check_graph") && !strcmp($cmd->get_type(), "2"))	{
													echo "<option value='" . $cmd->get_id() . "'";
													if ($cmd->get_id() == $eh)
														echo " selected";
													echo ">" . $cmd->get_name() . "</option>";
												}
												unset($cmd);
											}
									?>
									</select>
									</td>
								</tr>
								<tr>
									<td>Low_flap_threshold :</td>
									<td class="text10b">
										<?
										$lft = NULL;
										if (isset($_POST["htm_id"]))
											$lft = $hosts[$htm_id]->get_low_flap_threshold();
										if ($lft)	{ ?>
											<input type="checkbox" OnClick="enabledTemplateFieldSelect(this.form.lftNothingBox); enabledTemplateField(this.form.templateLowFlapThreshold, <? echo preg_replace("/(99999)/", "0", $lft); ?>, '');">
										<? } ?>
										<input size="5"  type="text" id="templateLowFlapThreshold" name="host[host_low_flap_threshold]" value="<? echo preg_replace("/(99999)/", "0", $lft); ?>" <? if ($lft) echo "disabled"; ?>>
										%
										&nbsp;&nbsp;<input type="checkbox" name="lftNothingBox" value="" OnClick="enabledTemplateFieldSelect(this.form.templateLowFlapThreshold);" <? if ($lft) echo "disabled"; ?>>Nothing
									</td>
								</tr>
								<tr>
									<td>High_flap_threshold :</td>
									<td class="text10b">
										<?
										$hft = NULL;
										if (isset($_POST["htm_id"]))
											$hft = $hosts[$htm_id]->get_high_flap_threshold();
										if ($hft)	{ ?>
											<input type="checkbox" OnClick="enabledTemplateFieldSelect(this.form.hftNothingBox); enabledTemplateField(this.form.templateHighFlapThreshold, <? echo preg_replace("/(99999)/", "0", $hft); ?>, '');">
										<? } ?>
										<input size="5"  type="text" id="templateHighFlapThreshold" name="host[host_high_flap_threshold]" value="<? echo preg_replace("/(99999)/", "0", $hft); ?>" <? if ($hft) echo "disabled"; ?>>
										%
										&nbsp;&nbsp;<input type="checkbox" name="hftNothingBox" value="" OnClick="enabledTemplateFieldSelect(this.form.templateHighFlapThreshold);" <? if ($hft) echo "disabled"; ?>>Nothing
									</td>
								</tr>
								<tr>
									<td>Flap_detection_enabled :</td>
									<td class="text10b">
									<?
									$fde = NULL;
									if (isset($_POST["htm_id"]))
										$fde = $hosts[$htm_id]->get_flap_detection_enabled();
									if ($fde)	{ ?>
										<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateFlapDetectionEnabled, '<? echo $fde ?>', '');">
									<? } ?>
									<input name="host[host_flap_detection_enabled]" type="radio" id="templateFlapDetectionEnabled" value="1" <? if (isset($_POST["htm_id"])) if ($fde == 1) echo "checked"; ?> <? if ($fde) echo "disabled";?>> Yes -
									<input name="host[host_flap_detection_enabled]" type="radio" id="templateFlapDetectionEnabled" value="3" <? if (isset($_POST["htm_id"])) if ($fde == 3) echo "checked"; ?> <? if ($fde) echo "disabled";?>> No -
									<input name="host[host_flap_detection_enabled]" type="radio" id="templateFlapDetectionEnabled" value="2" <? if (isset($_POST["htm_id"])) { if ($fde == 2) echo "checked";} else echo "checked"; ?> <? if ($fde) echo "disabled";?>> Nothing
									</td>
								</tr>
								<tr>
									<td>Process_perf_data :</td>
									<td class="text10b">
									<?
									$ppd = NULL;
									if (isset($_POST["htm_id"]))
										$ppd = $hosts[$htm_id]->get_process_perf_data();
									if ($ppd)	{ ?>
										<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateProcessPerfData, '<? echo $ppd; ?>', '');">
									<? } ?>
									<input name="host[host_process_perf_data]" type="radio" id="templateProcessPerfData" value="1" <? if (isset($_POST["htm_id"])) if ($ppd == 1) echo "checked"; ?> <? if ($ppd) echo "disabled";?>> Yes -
									<input name="host[host_process_perf_data]" type="radio" id="templateProcessPerfData" value="3" <? if (isset($_POST["htm_id"])) if ($ppd == 3) echo "checked"; ?> <? if ($ppd) echo "disabled";?>> No -
									<input name="host[host_process_perf_data]" type="radio" id="templateProcessPerfData" value="2" <? if (isset($_POST["htm_id"])) { if ($ppd == 2) echo "checked";} else echo "checked"; ?> <? if ($ppd) echo "disabled";?>> Nothing
									</td>
								</tr>
								<tr>
									<td>Retain_status_information :</td>
									<td class="text10b">
									<?
									$rsi = NULL;
									if (isset($_POST["htm_id"]))
										$rsi = $hosts[$htm_id]->get_retain_status_information();
									if ($rsi)	{ ?>
										<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateRetainStatusInformation, '<? echo $rsi; ?>', '');">
									<? } ?>
									<input name="host[host_retain_status_information]" type="radio" id="templateRetainStatusInformation" value="1" <? if (isset($_POST["htm_id"])) if ($rsi == 1) echo "checked"; ?> <? if ($rsi) echo "disabled";?>> Yes -
									<input name="host[host_retain_status_information]" type="radio" id="templateRetainStatusInformation" value="3" <? if (isset($_POST["htm_id"])) if ($rsi == 3) echo "checked"; ?> <? if ($rsi) echo "disabled";?>> No -
									<input name="host[host_retain_status_information]" type="radio" id="templateRetainStatusInformation" value="2" <? if (isset($_POST["htm_id"])) { if ($rsi == 2) echo "checked";} else echo "checked"; ?> <? if ($rsi) echo "disabled";?>> Nothing
									</td>
								</tr>
								<tr>
									<td style="white-space: nowrap;">Retain_nonstatus_information :</td>
									<td class="text10b" style="white-space: nowrap;">
									<?
									$rni = NULL;
									if (isset($_POST["htm_id"]))
										$rni = $hosts[$htm_id]->get_retain_nonstatus_information();
									if ($rni)	{ ?>
										<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateRetainNonstatusInformation, '<? echo $rni; ?>', '');">
									<? } ?>
									<input name="host[host_retain_nonstatus_information]" type="radio" id="templateRetainNonstatusInformation" value="1" <? if (isset($_POST["htm_id"])) if ($rni == 1) echo "checked"; ?> <? if ($rni) echo "disabled";?>> Yes -
									<input name="host[host_retain_nonstatus_information]" type="radio" id="templateRetainNonstatusInformation" value="3" <? if (isset($_POST["htm_id"])) if ($rni == 3) echo "checked"; ?> <? if ($rni) echo "disabled";?>> No -
									<input name="host[host_retain_nonstatus_information]" type="radio" id="templateRetainNonstatusInformation" value="2" <? if (isset($_POST["htm_id"])) { if ($rni == 2) echo "checked";} else echo "checked";?> <? if ($rni) echo "disabled";?>> Nothing
									</td>
								</tr>
								<?	if (!strcmp("2", $oreon->user->get_version()))	{	?>
								<tr>
									<td colspan="2">
										<div align="center" class="text10b">
											Contact Groups <font color="red">*</font>
											<?
											$cgs = NULL;
											if (isset($_POST["htm_id"]))
												$cgs = & $hosts[$htm_id]->contactgroups;
											if (count($cgs))	{ ?>
												<input type="checkbox" onClick="enabledTemplateFieldSelect(this.form.templateContactGroupsBase);enabledTemplateFieldSelect(this.form.selectContactGroups);">
											<? } ?>
										</div>
										<table border="0" align="center">
											<tr>
												<td align="left" style="padding: 3px;">
													<select name="selectContactGroupsBase" id="templateContactGroupsBase" size="8" <? if (count($cgs)) echo "disabled";?> multiple>
													<?
														if (isset($contactGroups))
															foreach ($contactGroups as $contactGroup)	{
																if (isset($_POST["htm_id"]))	{
																	if (!array_key_exists($contactGroup->get_id(), $hosts[$htm_id]->contactgroups))
																		echo "<option value='".$contactGroup->get_id()."'>".$contactGroup->get_name()."</option>";
																}
																else
																	echo "<option value='".$contactGroup->get_id()."'>".$contactGroup->get_name()."</option>";
																unset($contactGroup);
															}
													?>
													</select>
												</td>
												<td style="padding-left: 5px; padding-right: 5px;" valign="middle" align="center">
													<input type="button" name="add" value="<? echo $lang['add']; ?>" onClick="Moove(this.form.selectContactGroupsBase,this.form.selectContactGroup);"><br><br><br>
													<input type="button" name="remove" value="<? echo $lang['delete']; ?>" onClick="Moove(this.form.selectContactGroup,this.form.selectContactGroupsBase);">
												</td>
												<td>
													<select id="selectContactGroup" name="selectContactGroup[]" size="8" <? if (count($cgs)) echo "disabled";?> multiple>
													<?
														if (isset($_POST["htm_id"]))
															foreach ($hosts[$htm_id]->contactgroups as $existing_cg)	{
																echo "<option value='".$existing_cg->get_id()."'>".$existing_cg->get_name()."</option>";
																unset($existing_cg);
															}
													?>
													</select>
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<?	}	?>
								<tr>
									<td>Notification_interval :<font color="red">*</font></td>
									<td class="text10b">
										<?
										$nt = NULL;
										if (isset($_POST["htm_id"]))
											$nt = $hosts[$htm_id]->get_notification_interval();
										if ($nt)	{ ?>
											<input type="checkbox" onClick="enabledTemplateField(this.form.templateNotificationInterval, <? echo preg_replace("/(99999)/", "0", $nt); ?>, '');">
										<? } ?>
										<input size="5"  type="text" name="host[host_notification_interval]" id="templateNotificationInterval" value="<? echo preg_replace("/(99999)/", "0", $nt); ?>" <? if ($nt) echo "disabled";?>>
										&nbsp;* <? echo $oreon->Nagioscfg->get_interval_length() . " " .$lang["time_sec"]; ?>
									</td>
								</tr>
								<tr>
									<td>Notification_period :<font color="red">*</font></td>
									<td class="text10b">
									<?
									$np = NULL;
									if (isset($_POST["htm_id"]))
										$np = $hosts[$htm_id]->get_notification_period();
									if ($np)	{ ?>
										<input type="checkbox" onClick="enabledTemplateField(this.form.templateNotificationPeriod, <? echo $np; ?>, '');">
									<? } ?>
									<select name="host[timeperiod_tp_id2]" id="templateNotificationPeriod" <? if ($np) echo "disabled";?>>
									<?
										if (isset($timePeriods))
											foreach ($timePeriods as $tp)	{
												echo "<option value='".$tp->get_id()."'";
												if ($tp->get_id() == $np)
													echo " selected";
												echo ">" . $tp->get_name() . "</option>";
												unset($tp);
											}
									?>
									</select>
									</td>
								</tr>
								<tr>
									<td>Notification_options :<font color="red">*</font></td>
									<td class="text10b">
									<?
									$nos = NULL;
									if (isset($_POST["htm_id"]))
										$nos = $hosts[$htm_id]->get_notification_options();
									if (isset($_POST["htm_id"]) && $hosts[$htm_id]->get_notification_options())	{
										$option_not = array();
										$tab = split(",", $hosts[$htm_id]->get_notification_options());
										for ($i = 0; $i != 3; $i++)	{
											if (isset($tab[$i]))
												$option_not[$tab[$i]] = $tab[$i];
										}
									}
									if ($nos)	{ ?>
										<input type="checkbox" onClick="enabledTemplateFieldCheck(this.form.templateNotificationOptions, '<? echo $nos; ?>', '');">
									<? } ?>
									<input ONMOUSEOVER="montre_legende('Down', '');" ONMOUSEOUT="cache_legende();" name="host[host_notification_options_d]" type="checkbox" id="templateNotificationOptions" value="d" <? if (isset($option_not["d"]) && strcmp($option_not["d"], "")) print "Checked";?> <? if ($nos) echo "disabled";?>> d -
									<input ONMOUSEOVER="montre_legende('Unreachable', '');" ONMOUSEOUT="cache_legende();" name="host[host_notification_options_u]" type="checkbox" id="templateNotificationOptions" value="u" <? if (isset($option_not["u"]) && strcmp($option_not["u"], "")) print "Checked";?> <? if ($nos) echo "disabled";?>> u -
									<input ONMOUSEOVER="montre_legende('Recovery', '');" ONMOUSEOUT="cache_legende();" name="host[host_notification_options_r]" type="checkbox" id="templateNotificationOptions" value="r" <? if (isset($option_not["r"]) && strcmp($option_not["r"], "")) print "Checked";?> <? if ($nos) echo "disabled";?>> r
									</td>
								</tr>
								<tr>
									<td>Notifications_enabled :</td>
									<td class="text10b">
									<?
									$ne = NULL;
									if (isset($_POST["htm_id"]))
										$ne = $hosts[$htm_id]->get_notifications_enabled();
									if ($ne)	{ ?>
										<input type="checkbox" onClick="enabledTemplateFieldRadio(this.form.templateNotificationsEnabled, '<? echo $ne; ?>', '');">
									<? } ?>
									<input name="host[host_notifications_enabled]" type="radio" id="templateNotificationsEnabled" value="1" <? if (isset($_POST["htm_id"])) if ($ne == 1) echo "checked"; ?> <? if ($ne) echo "disabled"; ?>> Yes -
									<input name="host[host_notifications_enabled]" type="radio" id="templateNotificationsEnabled" value="3" <? if (isset($_POST["htm_id"])) if ($ne == 3) echo "checked"; ?> <? if ($ne) echo "disabled"; ?>> No -
									<input name="host[host_notifications_enabled]" type="radio" id="templateNotificationsEnabled" value="2" <? if (isset($_POST["htm_id"])) { if ($ne == 2) echo "checked";} else echo "checked"; ?> <? if ($ne) echo "disabled"; ?>> Nothing
									</td>
								</tr>
								<tr>
									<td>Stalking_options :</td>
									<td class="text10b">
									<?
									$sos = NULL;
									if (isset($_POST["htm_id"]))
										$sos = $hosts[$htm_id]->get_stalking_options();
									if (isset($_POST["htm_id"]) && $hosts[$htm_id]->get_stalking_options())	{
										$option_sta = array();
										$tab = split(",", $hosts[$htm_id]->get_stalking_options());
										for ($i = 0; $i != 3; $i++)	{
											if (isset($tab[$i]))
												$option_sta[$tab[$i]] = $tab[$i];
										}
									}
									if ($sos)	{ ?>
										<input type="checkbox" name="templateStalkingOptionsBox" onClick="enabledTemplateFieldCheck(this.form.templateStalkingOptions, '<? echo $sos; ?>', '');">
									<? } ?>
									<input ONMOUSEOVER="montre_legende('Ok/UP', '');" ONMOUSEOUT="cache_legende();" name="host[host_stalking_options_o]" type="checkbox" id="templateStalkingOptions" value="o" <? if (isset($option_sta["o"]) && strcmp($option_sta["o"], "")) print "Checked"; ?> <? if ($sos) echo "disabled"; ?>> o -
									<input ONMOUSEOVER="montre_legende('Down', '');" ONMOUSEOUT="cache_legende();" name="host[host_stalking_options_d]" type="checkbox" id="templateStalkingOptions" value="d" <? if (isset($option_sta["d"]) && strcmp($option_sta["d"], "")) print "Checked"; ?> <? if ($sos) echo "disabled"; ?>> d -
									<input ONMOUSEOVER="montre_legende('Unreachable', '');" ONMOUSEOUT="cache_legende();" name="host[host_stalking_options_u]" type="checkbox" id="templateStalkingOptions" value="u" <? if (isset($option_sta["u"]) && strcmp($option_sta["u"], "")) print "Checked"; ?> <? if ($sos) echo "disabled"; ?>> u
									</td>
								</tr>
								<tr>
									<td valign="top" class='text10b'><? echo $lang['status']; ?> :</td>
									<td class="text10b">
										<input type="radio" name="host[host_activate]" value="1" checked><? echo $lang['enable']; ?>&nbsp;&nbsp;&nbsp;&nbsp;
										<input type="radio" name="host[host_activate]" value="0"><? echo $lang['disable']; ?>
									</td>
								</tr>
								<tr>
									<td valign="top">Comment :</td>
									<td class="text10b">
										<?
										$ct = NULL;
										if (isset($_POST["htm_id"]))
											$ct = $hosts[$htm_id]->get_comment();
										if ($ct)	{ ?>
											<input type="checkbox" name="templateCommentBox" onClick="enabledTemplateFieldTarea(this.form.templateComment);">
										<? } ?>
										<textarea name="host[host_comment]" cols="25" rows="4" id="templateComment" <? if ($ct) echo "disabled"; ?>><? echo preg_replace("/(#BLANK#)/", "", $ct); ?></textarea>
									</td>
								</tr>
								<tr>
									<td align="left">
										<? echo $lang['required']; ?>&nbsp;&nbsp;
									</td>
									<td align="center">
										<input type="submit" name="AddHost" value="<? echo $lang['save']; ?>" onClick="selectAll(this.form.selectHostParent); selectAll(this.form.selectHostGroup); selectAll(this.form.selectContactGroup);">
									</td>
								</tr>
							</table>
							</form>
							<? } ?>
						</td>
					</tr>
				</table>
			</td>
			<td style="padding-left: 20px;"></td>
			<? if (!strcmp($_GET["o"], "w") || !strcmp($_GET["o"], "c")) { ?>
			<td valign="top" align="left">
				<table border='0' cellpadding="0" cellspacing="0" class='tabTableTitle' width="180">
					<tr>
						<td><? echo $lang['usage_stats']; ?></td>
					</tr>
				</table>
				<table border='0' cellpadding="0" cellspacing="0" class='tabTable' width="180">
					<tr>
						<td style="padding-top:10px;padding-bottom:10px;">
							<?
							$i = 0;
							if (isset($services))
								foreach ($services as $sv)	{
									if ($sv->get_register() && $sv->get_host() == $h)
										$i++;
									unset($sv);
								}
							echo "<li style='white-space: nowrap'> " . $i . " " . $lang["h_services"] .  "</li>";
							?>
							<? $i = 0;
							if (isset($hostGroups))
								foreach ($hostGroups as $hg)	{
									if (array_key_exists($h, $hg->hosts))
										$i++;
									unset($hg);
								}
							echo "<li style='white-space: nowrap'> " . $i . " " . $lang["h_hostgroup"] .  "</li>";
							?>
						</td>
					</tr>
					<tr>
						<td width="1" bgcolor="#CCCCCC"></td>
					</tr>
				</table>
				<br>
				<table border='0' cellpadding="0" cellspacing="0" class='tabTableTitle' width="180">
					<tr>
						<td><? echo $lang['cmd_utils']; ?></td>
					</tr>
				</table>
				<table border='0' cellpadding="0" cellspacing="0" class='tabTable' width="180">
					<tr>
						<td style="padding-top:10px;padding-bottom:10px;">
						<ul>
							<li><a href='<? print "./include/utilitaires/ping.php?ip=". $hosts[$h]->get_address(); ?>' target="_blank" class="text10b"><? echo $lang["cmd_ping"]; ?></a> </li>
							<li><a href='<? print "./include/utilitaires/traceroute.php?ip=". $hosts[$h]->get_address(); ?>' target="_blank" class="text10b"><? echo $lang["cmd_traceroute"]; ?></a> </li>
						</ul>
						</td>
					</tr>
					<tr>
						<td width="1" bgcolor="#CCCCCC"></td>
					</tr>
				</table>
				<br>
				<table border='0' cellpadding="0" cellspacing="0" class='tabTableTitle' width="180">
					<tr>
						<td><? echo $lang['status'] ; ?></td>
					</tr>
				</table>
				<table border='0' cellpadding="0" cellspacing="0" class='tabTable' width="180">
					<tr>
						<td style="white-space: nowrap; padding-left: 20px;padding-top:10px;padding-bottom:10px;"><a href='<? print "./phpradmin.php?p=314&h=". $h; ?>' class="text10"><? echo $lang['status_options'] ; ?></a></td>
					</tr>
					<tr>
						<td width="1" bgcolor="#CCCCCC"></td>
					</tr>
				</table>
			</td>
			<? } ?>	
		</tr>
	</table>
<? } ?>
</td>