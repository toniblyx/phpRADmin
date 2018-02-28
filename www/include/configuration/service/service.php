<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/if (!isset($oreon))
		exit();

	if (!isset($_GET["limit"]))
		$limit = 8;
	else
		$limit = $_GET["limit"];
	define("VIEW_MAX", $limit);

	$services = & $oreon->services;
	if (isset($_GET) && array_key_exists("o", $_GET) && $_GET["o"] != "a" && $_GET["o"] != "l")
		if (!isset($_GET["sv"]) || (isset($_GET["sv"]) && !array_key_exists($_GET["sv"], $services)))	{
			echo "<td width='85%'></td>";
			include ("./footer.php");
			exit();
		}
	$stms = & $oreon->stms;
	$hosts = & $oreon->hosts;
	$timePeriods = & $oreon->time_periods;
	$commands = & $oreon->commands;
	$serviceGroups = & $oreon->serviceGroups;
	$contactGroups = & $oreon->contactGroups;
	$hostGroups = & $oreon->hostGroups;
	$graphs = & $oreon->graphs;

	if (isset($_GET["o"]) && !strcmp($_GET["o"], "d"))	{
		// log oreon
		system("echo \"[" . time() . "] DeleteService;" . addslashes($services[$_GET["sv"]]->get_description()) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
		$oreon->deleteService($services[$_GET["sv"]]);
		unset($_GET["o"]);
		unset($_GET["sv"]);
	}

	if (isset($_POST["Changeservice"]))	{
		$sv_array = & $_POST["sv"];
		if (get_magic_quotes_gpc()) {
		 if (isset($sv_array[command_command_id_arg]))
			$sv_array[command_command_id_arg] =  stripslashes($sv_array[command_command_id_arg]);
		 if (isset($sv_array[command_command_id2_arg]))
			$sv_array[command_command_id2_arg] =  stripslashes($sv_array[command_command_id2_arg]);
		}
		if (isset($sv_array["stm_id"]) && $sv_array["stm_id"])
			$stm_id = $sv_array["stm_id"];
		// Concat options
		$sv_array["service_stalking_options"] = NULL;
		if (isset($sv_array["service_stalking_options_o"])) $sv_array["service_stalking_options"] .= $sv_array["service_stalking_options_o"];
		if (strcmp($sv_array["service_stalking_options"], "") && isset($sv_array["service_stalking_options_w"])  && strcmp($sv_array["service_stalking_options_w"], "")) $sv_array["service_stalking_options"] .= ",";
		if (isset($sv_array["service_stalking_options_w"])) $sv_array["service_stalking_options"] .= $sv_array["service_stalking_options_w"];
		if (strcmp($sv_array["service_stalking_options"], "") && isset($sv_array["service_stalking_options_u"])  && strcmp($sv_array["service_stalking_options_u"], "")) $sv_array["service_stalking_options"] .= ",";
		if (isset($sv_array["service_stalking_options_u"])) $sv_array["service_stalking_options"] .= $sv_array["service_stalking_options_u"];
		if (strcmp($sv_array["service_stalking_options"], "") && isset($sv_array["service_stalking_options_c"]) && strcmp($sv_array["service_stalking_options_c"], "")) $sv_array["service_stalking_options"] .= ",";
		if (isset($sv_array["service_stalking_options_c"])) $sv_array["service_stalking_options"] .= $sv_array["service_stalking_options_c"];
		// Concat options
		$sv_array["service_notification_options"] = NULL;
		if (isset($sv_array["service_notification_options_w"])) $sv_array["service_notification_options"] .= $sv_array["service_notification_options_w"];
		if (strcmp($sv_array["service_notification_options"], "") && isset($sv_array["service_notification_options_u"]) && strcmp($sv_array["service_notification_options_u"], "")) $sv_array["service_notification_options"] .= ",";
		if (isset($sv_array["service_notification_options_u"])) $sv_array["service_notification_options"] .= $sv_array["service_notification_options_u"];
		if (strcmp($sv_array["service_notification_options"], "") && isset($sv_array["service_notification_options_c"]) && strcmp($sv_array["service_notification_options_c"], "")) $sv_array["service_notification_options"] .= ",";
		if (isset($sv_array["service_notification_options_c"])) $sv_array["service_notification_options"] .= $sv_array["service_notification_options_c"];
		if (strcmp($sv_array["service_notification_options"], "") && isset($sv_array["service_notification_options_r"]) && strcmp($sv_array["service_notification_options_r"], "")) $sv_array["service_notification_options"] .= ",";
		if (isset($sv_array["service_notification_options_r"]))$sv_array["service_notification_options"] .= $sv_array["service_notification_options_r"];

		if (isset($sv_array["command_command_id_arg"]))
			$sv_array["command_command_id_arg"] = preg_replace("/^([\t| ]+)/", "", $sv_array["command_command_id_arg"]);
		if (isset($sv_array["command_command_id2_arg"]))
			$sv_array["command_command_id2_arg"] = preg_replace("/^([\t| ]+)/", "", $sv_array["command_command_id2_arg"]);
		if (isset($sv_array["command_command_id_arg"]) && !$sv_array["command_command_id_arg"])
			$sv_array["command_command_id_arg"] = "#BLANK#";
		if (isset($sv_array["command_command_id2_arg"]) && !$sv_array["command_command_id2_arg"])
			$sv_array["command_command_id2_arg"] = "#BLANK#";
		if (isset($sv_array["service_freshness_threshold"]) && !$sv_array["service_freshness_threshold"])
			$sv_array["service_freshness_threshold"] = 99999;
		else if (!isset($sv_array["service_freshness_threshold"]) && isset($sv_array["ftNothingBox"]))
			$sv_array["service_freshness_threshold"] = 0;
		if (isset($sv_array["service_low_flap_threshold"]) && !$sv_array["service_low_flap_threshold"])
			$sv_array["service_low_flap_threshold"] = 99999;
		else if (!isset($sv_array["service_low_flap_threshold"]) && isset($sv_array["lftNothingBox"]))
			$sv_array["service_low_flap_threshold"] = 0;
		if (isset($sv_array["service_high_flap_threshold"]) && !$sv_array["service_high_flap_threshold"])
			$sv_array["service_high_flap_threshold"] = 99999;
		else if (!isset($sv_array["service_high_flap_threshold"]) && isset($sv_array["hftNothingBox"]))
			$sv_array["service_high_flap_threshold"] = 0;
		if (isset($sv_array["service_notification_interval"]) && !$sv_array["service_notification_interval"])
			$sv_array["service_notification_interval"] = 99999;
		if (isset($sv_array["service_comment"]) && !$sv_array["service_comment"])
			$sv_array["service_comment"] = "#BLANK#";

		// Copy array if we have to keep it for the template
		$sv_array_tmp = $sv_array;

		// Init with template value if it's necessary
		if (isset($stm_id) && !isset($sv_array["command_command_id"]))
			$sv_array["command_command_id"] = $services[$stm_id]->get_check_command();
		if (isset($stm_id) && !isset($sv_array["command_command_id_arg"]))
			$sv_array["command_command_id_arg"] = $services[$stm_id]->get_check_command_arg();
		if (isset($stm_id) && !isset($sv_array["service_max_check_attempts"]))
			$sv_array["service_max_check_attempts"] = $services[$stm_id]->get_max_check_attempts();
		if (isset($stm_id) && !isset($sv_array["service_normal_check_interval"]))
			$sv_array["service_normal_check_interval"] = $services[$stm_id]->get_normal_check_interval();
		if (isset($stm_id) && !isset($sv_array["service_retry_check_interval"]))
			$sv_array["service_retry_check_interval"] = $services[$stm_id]->get_retry_check_interval();
		if (isset($stm_id) && !isset($sv_array["timeperiod_tp_id"]))
			$sv_array["timeperiod_tp_id"] = $services[$stm_id]->get_check_period();
		if (isset($stm_id) && !isset($sv_array["service_notification_interval"]))
			$sv_array["service_notification_interval"] = $services[$stm_id]->get_notification_interval();
		if (isset($stm_id) && !isset($sv_array["timeperiod_tp_id2"]))
			$sv_array["timeperiod_tp_id2"] = $services[$stm_id]->get_notification_period();
		if (isset($stm_id) && !isset($sv_array["service_notification_options"]))
			$sv_array["service_notification_options"] = $services[$stm_id]->get_notification_options();

		// Create new service object with new data
		$sv_object = new Service($sv_array);
		$sv_object->set_host($sv_array["host_host_id"]);

		// init contact group with form or template value
		if (isset($_POST["selectCG"])) 	{
			$selectContactGroup	= $_POST["selectCG"];
			for ($i = 0; $i < count($selectContactGroup); $i++)
				$sv_object->contactGroups[$selectContactGroup[$i]] = & $contactGroups[$selectContactGroup[$i]];
		}	else if (isset($stm_id) && !isset($_POST["templateContactGroupsBox"]))
				$sv_object->contactGroups = $services[$stm_id]->contactGroups;
		// If it's complet -> set new data
		if ($sv_object->is_complete($oreon->user->get_version()) && $sv_object->twiceTest($services))	{
			// log oreon
			system("echo \"[" . time() . "] ChangeService;" . addslashes($sv_array["service_description"]) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
			// If we use the template, we have to set a new object service, in order to take only the value off the form - record in $sv_array_tmp
			if (isset($stm_id))	{
				$sv_object = new Service($sv_array_tmp);
				$sv_object->set_host($sv_array_tmp["host_host_id"]);
				if (isset($_POST["selectCG"])) 	{
					$selectContactGroup	= $_POST["selectCG"];
					for ($i = 0; $i < count($selectContactGroup); $i++)
						$sv_object->contactGroups[$selectContactGroup[$i]] = & $contactGroups[$selectContactGroup[$i]];
				}
			}
			// Before put the modify service in Oreon object, we have to check if 'check_command' have changed from check_graph to no check_graph command to delete service_id in the check_command_argument
			if (strstr($commands[$sv_array["command_command_id"]]->get_name(), "check_graph"))
				$sv_object->set_check_command_arg($sv_array["command_command_id_arg"]."!".$sv_array["service_id"]);
			else if (isset($graphs[$sv_array["service_id"]]))
				$oreon->deleteGraph($graphs[$sv_array["service_id"]]);
			$services[$sv_array["service_id"]] = $sv_object;
			if (isset($stm_id)) $services[$sv_array["service_id"]]->set_service_template($stm_id);
			if (isset($sv_array["service_is_volatile"])) $services[$sv_array["service_id"]]->set_is_volatile($sv_array["service_is_volatile"]);
			if (isset($sv_array["service_active_checks_enabled"])) $services[$sv_array["service_id"]]->set_active_checks_enabled($sv_array["service_active_checks_enabled"]);
			if (isset($sv_array["service_passive_checks_enabled"])) $services[$sv_array["service_id"]]->set_passive_checks_enabled($sv_array["service_passive_checks_enabled"]);
			if (isset($sv_array["service_parallelize_check"])) $services[$sv_array["service_id"]]->set_parallelize_check($sv_array["service_parallelize_check"]);
			if (isset($sv_array["service_obsess_over_service"])) $services[$sv_array["service_id"]]->set_obsess_over_service($sv_array["service_obsess_over_service"]);
			if (isset($sv_array["service_check_freshness"])) $services[$sv_array["service_id"]]->set_check_freshness($sv_array["service_check_freshness"]);
			if (isset($sv_array["service_freshness_threshold"])) $services[$sv_array["service_id"]]->set_freshness_threshold($sv_array["service_freshness_threshold"]);
			if (isset($sv_array["service_event_handler_enabled"])) $services[$sv_array["service_id"]]->set_event_handler_enabled($sv_array["service_event_handler_enabled"]);
			if (isset($sv_array["command_command_id2"])) $services[$sv_array["service_id"]]->set_event_handler($sv_array["command_command_id2"]);
			if (isset($sv_array["command_command_id2_arg"])) $services[$sv_array["service_id"]]->set_event_handler_arg($sv_array["command_command_id2_arg"]);
			if (isset($sv_array["service_low_flap_threshold"])) $services[$sv_array["service_id"]]->set_low_flap_threshold($sv_array["service_low_flap_threshold"]);
			if (isset($sv_array["service_high_flap_threshold"])) $services[$sv_array["service_id"]]->set_high_flap_threshold($sv_array["service_high_flap_threshold"]);
			if (isset($sv_array["service_flap_detection_enabled"])) $services[$sv_array["service_id"]]->set_flap_detection_enabled($sv_array["service_flap_detection_enabled"]);
			if (isset($sv_array["service_process_perf_data"])) $services[$sv_array["service_id"]]->set_process_perf_data($sv_array["service_process_perf_data"]);
			if (isset($sv_array["service_retain_status_information"])) $services[$sv_array["service_id"]]->set_retain_status_information($sv_array["service_retain_status_information"]);
			if (isset($sv_array["service_retain_nonstatus_information"])) $services[$sv_array["service_id"]]->set_retain_nonstatus_information($sv_array["service_retain_nonstatus_information"]);
			if (isset($sv_array["service_notification_enabled"])) $services[$sv_array["service_id"]]->set_notification_enabled($sv_array["service_notification_enabled"]);
			if (isset($sv_array["service_stalking_options"])) $services[$sv_array["service_id"]]->set_stalking_options($sv_array["service_stalking_options"]);
			if (isset($sv_array["service_comment"])) $services[$sv_array["service_id"]]->set_comment($sv_array["service_comment"]);
			if ($sv_array["service_activate"]) $services[$sv_array["service_id"]]->set_activate(1); else $services[$sv_array["service_id"]]->set_activate(0);
			$services[$sv_array["service_id"]]->set_register(1);
			// init service group
			if (isset($_POST["selectSG"])) 	{
				$selectServiceGroup	= $_POST["selectSG"];
				for ($i = 0; $i < count($selectServiceGroup); $i++)
					$services[$sv_array["service_id"]]->serviceGroups[$selectServiceGroup[$i]] = & $serviceGroups[$selectServiceGroup[$i]];
			}
			// Update Service in database
			$oreon->saveService($services[$sv_array["service_id"]]);
			$msg = $lang['errCode'][2];
			$_GET["o"] = "w";

			// Add Graph for special service which name begin by "check_graph".. horrible isn't it ?
			if (strstr($commands[$sv_array["command_command_id"]]->get_name(), "check_graph"))	{
				if (!isset($graphs[$sv_array["service_id"]]))	{
					include_once("./include/graph/graphFunctions.php");
					$graph_array = & initGraph($sv_array["service_id"], getcwd());
					$graph = new GraphRRD($graph_array);
					$oreon->saveGraph($graph);
					$graphs[$sv_array["service_id"]] = $graph;
				}
			}
		}
		else
			$msg = $lang['errCode'][$sv_object->get_errCode()];
		unset($sv_object);
	}
	if (isset($_POST["AddService"]))	{
		$hostApplyService = array();
		$sv_array = & $_POST["sv"];
		if (get_magic_quotes_gpc()) {
		 if (isset($sv_array[command_command_id_arg]))
			$sv_array[command_command_id_arg] =  stripslashes($sv_array[command_command_id_arg]);
		 if (isset($sv_array[command_command_id2_arg]))
			$sv_array[command_command_id2_arg] =  stripslashes($sv_array[command_command_id2_arg]);
		}

		if (isset($_POST["stm_id"]) && $_POST["stm_id"])
			$stm_id = $_POST["stm_id"];
		else
			unset ($_POST["stm_id"]);
		$sv_array["service_id"] = -1;
		// Concat options
		$sv_array["service_stalking_options"] = NULL;
		if (isset($sv_array["service_stalking_options_o"])) $sv_array["service_stalking_options"] .= $sv_array["service_stalking_options_o"];
		if (strcmp($sv_array["service_stalking_options"], "") && isset($sv_array["service_stalking_options_w"])  && strcmp($sv_array["service_stalking_options_w"], "")) $sv_array["service_stalking_options"] .= ",";
		if (isset($sv_array["service_stalking_options_w"])) $sv_array["service_stalking_options"] .= $sv_array["service_stalking_options_w"];
		if (strcmp($sv_array["service_stalking_options"], "") && isset($sv_array["service_stalking_options_u"])  && strcmp($sv_array["service_stalking_options_u"], "")) $sv_array["service_stalking_options"] .= ",";
		if (isset($sv_array["service_stalking_options_u"])) $sv_array["service_stalking_options"] .= $sv_array["service_stalking_options_u"];
		if (strcmp($sv_array["service_stalking_options"], "") && isset($sv_array["service_stalking_options_c"]) && strcmp($sv_array["service_stalking_options_c"], "")) $sv_array["service_stalking_options"] .= ",";
		if (isset($sv_array["service_stalking_options_c"])) $sv_array["service_stalking_options"] .= $sv_array["service_stalking_options_c"];
		// Concat options
		$sv_array["service_notification_options"] = NULL;
		if (isset($sv_array["service_notification_options_w"])) $sv_array["service_notification_options"] .= $sv_array["service_notification_options_w"];
		if (strcmp($sv_array["service_notification_options"], "") && isset($sv_array["service_notification_options_u"]) && strcmp($sv_array["service_notification_options_u"], "")) $sv_array["service_notification_options"] .= ",";
		if (isset($sv_array["service_notification_options_u"])) $sv_array["service_notification_options"] .= $sv_array["service_notification_options_u"];
		if (strcmp($sv_array["service_notification_options"], "") && isset($sv_array["service_notification_options_c"]) && strcmp($sv_array["service_notification_options_c"], "")) $sv_array["service_notification_options"] .= ",";
		if (isset($sv_array["service_notification_options_c"])) $sv_array["service_notification_options"] .= $sv_array["service_notification_options_c"];
		if (strcmp($sv_array["service_notification_options"], "") && isset($sv_array["service_notification_options_r"]) && strcmp($sv_array["service_notification_options_r"], "")) $sv_array["service_notification_options"] .= ",";
		if (isset($sv_array["service_notification_options_r"])) $sv_array["service_notification_options"] .= $sv_array["service_notification_options_r"];

		if (isset($sv_array["command_command_id_arg"]))
			$sv_array["command_command_id_arg"] = preg_replace("/^([\t| ]+)/", "", $sv_array["command_command_id_arg"]);
		if (isset($sv_array["command_command_id2_arg"]))
			$sv_array["command_command_id2_arg"] = preg_replace("/^([\t| ]+)/", "", $sv_array["command_command_id2_arg"]);
		if (isset($sv_array["command_command_id_arg"]) && !$sv_array["command_command_id_arg"])
			$sv_array["command_command_id_arg"] = "#BLANK#";
		if (isset($sv_array["command_command_id2_arg"]) && !$sv_array["command_command_id2_arg"])
			$sv_array["command_command_id2_arg"] = "#BLANK#";
		if (isset($sv_array["service_freshness_threshold"]) && !$sv_array["service_freshness_threshold"])
			$sv_array["service_freshness_threshold"] = 99999;
		else if (!isset($sv_array["service_freshness_threshold"]) && isset($sv_array["ftNothingBox"]))
			$sv_array["service_freshness_threshold"] = 0;
		if (isset($sv_array["service_low_flap_threshold"]) && !$sv_array["service_low_flap_threshold"])
			$sv_array["service_low_flap_threshold"] = 99999;
		else if (!isset($sv_array["service_low_flap_threshold"]) && isset($sv_array["lftNothingBox"]))
			$sv_array["service_low_flap_threshold"] = 0;
		if (isset($sv_array["service_high_flap_threshold"]) && !$sv_array["service_high_flap_threshold"])
			$sv_array["service_high_flap_threshold"] = 99999;
		else if (!isset($sv_array["service_high_flap_threshold"]) && isset($sv_array["hftNothingBox"]))
			$sv_array["service_high_flap_threshold"] = 0;
		if (isset($sv_array["service_notification_interval"]) && !$sv_array["service_notification_interval"])
			$sv_array["service_notification_interval"] = 99999;
		if (isset($sv_array["service_comment"]) && !$sv_array["service_comment"])
			$sv_array["service_comment"] = "#BLANK#";

		// Copy array if we have to keep it for the template
		$sv_array_tmp = $sv_array;

		// Init with template value if it's necessary
		if (isset($_POST["stm_id"]) && !isset($sv_array["command_command_id"]))
			$sv_array["command_command_id"] = $services[$stm_id]->get_check_command();
		if (isset($_POST["stm_id"]) && !isset($sv_array["command_command_id_arg"]))
			$sv_array["command_command_id_arg"] = $services[$stm_id]->get_check_command_arg();
		if (isset($_POST["stm_id"]) && !isset($sv_array["service_max_check_attempts"]))
			$sv_array["service_max_check_attempts"] = $services[$stm_id]->get_max_check_attempts();
		if (isset($_POST["stm_id"]) && !isset($sv_array["service_normal_check_interval"]))
			$sv_array["service_normal_check_interval"] = $services[$stm_id]->get_normal_check_interval();
		if (isset($_POST["stm_id"]) && !isset($sv_array["service_retry_check_interval"]))
			$sv_array["service_retry_check_interval"] = $services[$stm_id]->get_retry_check_interval();
		if (isset($_POST["stm_id"]) && !isset($sv_array["timeperiod_tp_id"]))
			$sv_array["timeperiod_tp_id"] = $services[$stm_id]->get_check_period();
		if (isset($_POST["stm_id"]) && !isset($sv_array["service_notification_interval"]))
			$sv_array["service_notification_interval"] = $services[$stm_id]->get_notification_interval();
		if (isset($_POST["stm_id"]) && !isset($sv_array["timeperiod_tp_id2"]))
			$sv_array["timeperiod_tp_id2"] = $services[$stm_id]->get_notification_period();
		if (isset($_POST["stm_id"]) && !isset($sv_array["service_notification_options"]))
			$sv_array["service_notification_options"] = $services[$stm_id]->get_notification_options();

		// Create new host object with new data
		$sv_object = new Service($sv_array);

		// HostGroup / host case
		if (isset($sv_array["hostgroup_id"]) && $sv_array["hostgroup_id"])	{
			if (isset($hostGroups[$sv_array["hostgroup_id"]]))
				$hg_temp = $hostGroups[$sv_array["hostgroup_id"]];
			$oreon->emulHostGroupHosts($hg_temp);
			foreach($hg_temp->hostsEmul as $host)	{
				$hostApplyService[$host->get_id()] = $host->get_id();
				unset($host);
			}
			unset($hg_temp);
		}
		else if (isset($sv_array["host_host_id"]) && $sv_array["host_host_id"])
			$hostApplyService[$sv_array["host_host_id"]] = $sv_array["host_host_id"];

		// init contact group with form or template value
		if (isset($_POST["selectCG"])) 	{
			$selectContactGroup	= $_POST["selectCG"];
			for ($i = 0; $i < count($selectContactGroup); $i++)
				$sv_object->contactGroups[$selectContactGroup[$i]] = & $contactGroups[$selectContactGroup[$i]];
		}	else if (isset($stm_id) && !isset($_POST["templateContactGroupsBox"]))
				$sv_object->contactGroups = $services[$stm_id]->contactGroups;

		if (count($hostApplyService))	{
			foreach($hostApplyService as $host_host_id)	{
				$sv_object->set_host($host_host_id);
				// If it's complet -> set new data
				if ($sv_object->is_complete($oreon->user->get_version()) && $sv_object->twiceTest($services))	{
					// If we use the template, we have to set a new object service, in order to take only the value off the form - record in $sv_array_tmp
					if (isset($_POST["stm_id"]))	{
						$sv_object2 = new Service($sv_array_tmp);
						$sv_object2->set_host($host_host_id);
						if (isset($_POST["selectCG"]))	{
							$selectContactGroup	= $_POST["selectCG"];
							for ($i = 0; $i < count($selectContactGroup); $i++)
								$sv_object2->contactGroups[$selectContactGroup[$i]] = & $contactGroups[$selectContactGroup[$i]];
						}
					} else
						$sv_object2 = $sv_object;
					// Insert Service in database
					$oreon->saveService($sv_object2);
					$sv_id = $oreon->database->database->get_last_id();
					$services[$sv_id] = $sv_object2;
					$services[$sv_id]->set_id($sv_id);
					// log oreon
					system("echo \"[" . time() . "] AddService;" . addslashes($sv_array["service_description"]) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
					if (isset($_POST["stm_id"])) $services[$sv_id]->set_service_template($_POST["stm_id"]);
					if (isset($sv_array["service_is_volatile"])) $services[$sv_id]->set_is_volatile($sv_array["service_is_volatile"]);
					if (isset($sv_array["service_active_checks_enabled"])) $services[$sv_id]->set_active_checks_enabled($sv_array["service_active_checks_enabled"]);
					if (isset($sv_array["service_passive_checks_enabled"])) $services[$sv_id]->set_passive_checks_enabled($sv_array["service_passive_checks_enabled"]);
					if (isset($sv_array["service_parallelize_check"])) $services[$sv_id]->set_parallelize_check($sv_array["service_parallelize_check"]);
					if (isset($sv_array["service_obsess_over_service"])) $services[$sv_id]->set_obsess_over_service($sv_array["service_obsess_over_service"]);
					if (isset($sv_array["service_check_freshness"])) $services[$sv_id]->set_check_freshness($sv_array["service_check_freshness"]);
					if (isset($sv_array["service_freshness_threshold"])) $services[$sv_id]->set_freshness_threshold($sv_array["service_freshness_threshold"]);
					if (isset($sv_array["service_event_handler_enabled"])) $services[$sv_id]->set_event_handler_enabled($sv_array["service_event_handler_enabled"]);
					if (isset($sv_array["command_command_id2"])) $services[$sv_id]->set_event_handler($sv_array["command_command_id2"]);
					if (isset($sv_array["command_command_id2_arg"])) $services[$sv_id]->set_event_handler_arg($sv_array["command_command_id2_arg"]);
					if (isset($sv_array["service_low_flap_threshold"])) $services[$sv_id]->set_low_flap_threshold($sv_array["service_low_flap_threshold"]);
					if (isset($sv_array["service_high_flap_threshold"])) $services[$sv_id]->set_high_flap_threshold($sv_array["service_high_flap_threshold"]);
					if (isset($sv_array["service_flap_detection_enabled"])) $services[$sv_id]->set_flap_detection_enabled($sv_array["service_flap_detection_enabled"]);
					if (isset($sv_array["service_process_perf_data"])) $services[$sv_id]->set_process_perf_data($sv_array["service_process_perf_data"]);
					if (isset($sv_array["service_retain_status_information"])) $services[$sv_id]->set_retain_status_information($sv_array["service_retain_status_information"]);
					if (isset($sv_array["service_retain_nonstatus_information"])) $services[$sv_id]->set_retain_nonstatus_information($sv_array["service_retain_nonstatus_information"]);
					if (isset($sv_array["service_notification_enabled"])) $services[$sv_id]->set_notification_enabled($sv_array["service_notification_enabled"]);
					if (isset($sv_array["service_stalking_options"])) $services[$sv_id]->set_stalking_options($sv_array["service_stalking_options"]);
					if (isset($sv_array["service_comment"])) $services[$sv_id]->set_comment($sv_array["service_comment"]);
					if ($sv_array["service_activate"]) $services[$sv_id]->set_activate(1); else $services[$sv_id]->set_activate(0);
					$services[$sv_id]->set_register(1);
					$sv_array["command_command_id_arg"] = preg_replace("/^([\t| ]+)/", "", $sv_array["command_command_id_arg"]);
					// Add service_id in check command arguments for graph
					if (isset($_POST["stm_id"]))	{ // Service Template case
						if (isset($sv_array["command_command_id"]) && strstr($commands[$sv_array["command_command_id"]]->get_name(), "check_graph"))	{
							if (isset($sv_array["command_command_id_arg"]))
								$services[$sv_id]->set_check_command_arg($sv_array["command_command_id_arg"]."!".$sv_id);
							else
								$services[$sv_id]->set_check_command_arg($services[$stm_id]->get_check_command_arg()."!".$sv_id);
						}
						else if ($services[$stm_id]->get_check_command() && strstr($commands[$services[$stm_id]->get_check_command()]->get_name(), "check_graph") && !isset($_POST["templateCheckCommandBox"]))	{
							if (isset($sv_array["command_command_id_arg"]))
								$services[$sv_id]->set_check_command_arg($sv_array["command_command_id_arg"]."!".$sv_id);
							else
								$services[$sv_id]->set_check_command_arg($services[$stm_id]->get_check_command_arg()."!".$sv_id);
						}
					}
					else if (strstr($commands[$sv_array["command_command_id"]]->get_name(), "check_graph"))
						$services[$sv_id]->set_check_command_arg($sv_array["command_command_id_arg"]."!".$sv_id);

					// init service group
					if (isset($_POST["selectSG"])) 	{
						$selectServiceGroup	= $_POST["selectSG"];
						for ($i = 0; $i < count($selectServiceGroup); $i++)
							$services[$sv_id]->serviceGroups[$selectServiceGroup[$i]] = & $serviceGroups[$selectServiceGroup[$i]];
					}
					// Update service in database
					$oreon->saveService($services[$sv_id]);
					$msg = $lang['errCode'][3];
					$_GET["o"] = "w";
					$_GET["sv"] = $sv_id;

					// Add Graph for special service which name begin by "check_graph".. horrible isn't it ?
					if (strstr($commands[$sv_array["command_command_id"]]->get_name(), "check_graph"))	{
						include_once("./include/graph/graphFunctions.php");
						$graph_array = & initGraph($sv_id, getcwd());
						$graph = new GraphRRD($graph_array);
						$oreon->saveGraph($graph);
						$graphs[$sv_id] = $graph;
					}
				}
				else
					$msg = $lang['errCode'][$sv_object->get_errCode()];
			}
		} else
			$msg = $lang['errCode'][-6];
		unset($sv_object);
		unset($sv_object2);
	}
	if (isset($_GET["o"]) && !strcmp($_GET["o"], "l"))	{
		if (isset($_GET["box"]))	{
			$boxx = $_GET["box"];
			foreach ($boxx as $box)	{
				// log add
				system("echo \"[" . time() . "] DeleteService;" . addslashes($services[$box]->get_description()). ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
				$oreon->deleteService($services[$box]);
			}
		}
		unset($_GET["o"]);
	}

	// Initialise YES NO or NOTHING Value
		$value_flag["1"] = "Yes";
		$value_flag["2"] = "Nothing";
		$value_flag["3"] = "No";

	function write_services_list(&$services, &$hosts, &$lang)	{
		?><form action='' name='serviceMenu' method='post'>
		<table cellpadding="0" cellspacing="0" width="200">
			<tr>
				<td class="tabTableTitleMenu"><? print $lang["m_options"]; ?></td>
			</tr>
			<tr>
				<td class="tabTableMenu">
					<div style="padding: 8px; text-align: center;">
						<img src="img/picto2.gif">
						<a href="phpradmin.php?p=104&o=a" class="text9"><? echo $lang['add']; ?></a>
						<img src="img/picto2_bis.gif">
					</div>
				</td>
			</tr>
		</table>
		<br>
		<table cellpadding="0" cellspacing="0" width="200">
			<tr>
				<td class="tabTableTitleMenu"><? print $lang['s_available']; ?></td>
			</tr>
			<tr>
				<td class="tabTableMenu">
				 <? 
				echo "<div align='left'>";
				echo "<ul id='myMenu'>\n";
				$i = 1;
				if (isset($hosts))
					foreach($hosts as $host)	{
						if (isset($host->services) && count($host->services))	{
							echo "<li class='text10b' style='list-style-image:url(./img/folder.gif);'><a name='".$host->get_id()."' href=\"#".$host->get_id()."\" class='text10b'";
							if (!$host->get_activate()) echo " style='text-decoration: line-through;'";
							echo ">".$host->get_name()."</a>\n";
							echo "<ul>\n";
							foreach ($host->services as $service)	{
								echo "<li style='white-space: nowrap; list-style-image:url(./img/page.gif);";
								if (!$service->get_activate() || !$host->get_activate()) echo " text-decoration: line-through;";
								echo "' class='text10'>";
								echo "<a href=\"./phpradmin.php?p=104&sv=".$service->get_id()."&o=w\" class='text10'>".$service->get_description()."</a>";
								echo "</li>\n";
								unset($service);
							}
							echo "</ul></li>\n";
							$i++;
						}
						unset ($host);
						}
				echo "</ul>";
				echo "</div>";
				?>
				<SCRIPT language='javascript' src='./include/menu/dhtmlMenu.js'></SCRIPT>
				<input type="hidden" name="o" value="l">
				</form>
				</td>
			</tr>
		</table>
<?	}

	function write_services_list2(&$services, &$hosts, &$htms, $lang)	{	?>
		<form action="" name="serviceMenu" method="get">
			<table cellpadding="3" cellspacing="3">
				<tr>
					<td class="listTop"></td>
					<td align="left" class="listTop" style="padding-left: 20px; padding-right: 20px;"><? echo $lang['name']; ?></td>
					<td align="left" class="listTop" style="padding-left: 20px; padding-right: 20px;"><? echo $lang['s']; ?></td>
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
				$flag = 1;
				if ($h->get_register() && count($h->services) && $cpt < (VIEW_MAX * $num) && ($cpt >= ((VIEW_MAX * $num) - (VIEW_MAX))))
					foreach($h->services as $s)	{
				?>
				<tr>
					<td class="listSub<? echo $cpt%2; ?>"><input type="checkbox" name="box[<? echo $s->get_id(); ?>]" value="<? echo $s->get_id(); ?>"></td>
					<td align="left" class="listSub<? echo $cpt%2; ?>"><? if ($flag) { ?><a href="phpradmin.php?p=102&h=<? echo $h->get_id(); ?>&o=w" class="text11"><? echo $h->get_name(); ?></a><? } ?></td>
					<td align="left" class="listSub<? echo $cpt%2; ?>"><a href="phpradmin.php?p=104&sv=<? echo $s->get_id(); ?>&o=w" class="text11"><? echo $s->get_description(); ?></a></td>
					<td align="center" class="listSub<? echo $cpt%2; ?>"><? if ($s->get_activate() && $hosts[$s->get_host()]->get_activate()) echo $lang['enable']; else echo $lang['disable']; ?></td>
					<td class="listSub<? echo $cpt%2; ?>">
						&nbsp;&nbsp;
						<a href="phpradmin.php?p=104&sv=<? echo $s->get_id(); ?>&o=w" class="text11"><img src="img/listView.gif" border="0" alt="<? echo $lang['view']; ?>" title="<? echo $lang['view']; ?>"></a>&nbsp;
						<a href="phpradmin.php?p=104&sv=<? echo $s->get_id(); ?>&o=c" class="text11"><img src="img/listPen.gif" border="0" alt="<? echo $lang['modify']; ?>" title="<? echo $lang['modify']; ?>"></a>&nbsp;
						<a href="phpradmin.php?p=104&sv=<? echo $s->get_id(); ?>&o=d&num=<? echo $num; ?>&limit=<? echo VIEW_MAX; ?>" class="text11" onclick="return confirm('<? echo $lang['confirm_removing']; ?>')"><img src="img/listDel.gif" border="0" alt="<? echo $lang['delete']; ?>" title="<? echo $lang['delete']; ?>"></a>&nbsp;&nbsp;
					</td>
				</tr>
				<?
					if ($flag)
						$flag = 0;
					unset($s);
				}
				if ($h->get_register() && count($h->services))
					$cpt++;
				unset($h);
			}
		}
		?>
			<tr>
				<td colspan="2" valign="top"><img src="img/arrow_ltr.gif" style="padding-left: 5px;">&nbsp;&nbsp;	<a href="#" class="text10bc" onclick=" if (confirm('<? echo $lang['confirm_removing']; ?>')){document.forms['serviceMenu'].submit();}"><? echo $lang['m_delete_selection']; ?></a></td>
				<td></td>
				<td colspan="2" align="right">
					<a href="phpradmin.php?p=104&o=a" class="text10bc"><? echo $lang['add']; ?></a><br><br>
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
					<?
					$hList = 0;
					if (isset($hosts))
						foreach ($hosts as $h)	{
							if (count($h->services))
								$hList++;
							unset($h);
						}
					$nbrPage = floor(($hList - count($htms))/VIEW_MAX); if(($hList - count($htms))%VIEW_MAX) $nbrPage++; ?>
					<? echo "<font class='text11b'>".$lang["page"]. ":&nbsp;&nbsp;</font>[&nbsp;&nbsp;";
						for ($i = 1; $i <= $nbrPage; $i++)	{
							if($num == $i)
								echo "<a href='./phpradmin.php?p=104&num=$i&limit=".VIEW_MAX."' class='text10'><b>$i</b></a>&nbsp;&nbsp;";
							else
								echo "<a href='./phpradmin.php?p=104&num=$i&limit=".VIEW_MAX."' class='text10'>$i</a>&nbsp;&nbsp;";
						}
						echo "]";
					?>
				</td>
			</tr>
		</table>
		<input type="hidden" name="p" value="104">
		<input type="hidden" name="o" value="l" id="option">
	</form>
	<? } 

if (!isset($_GET["o"]))	{  ?>
	<table border="0">
		<tr>
			<td valign="top" align="left"><? write_services_list2($services, $hosts, $htms, $lang); ?></td>
		</tr>
	</table>
<? } else if (isset($_GET["o"]))	{
		if (isset($_GET["sv"]))
			$sv = $_GET["sv"]; ?>
	<table align="left" border="0">
		<tr>
			<td valign="top" align="left"><? write_services_list($services, $hosts, $lang); ?></td>
			<td valign="top" style="padding-left: 20px;"></td>
			<td valign="top" align='left' width='400'>
				<? if (isset($msg))
					echo "<div align='center' class='msg' style='padding-bottom: 10px;'>$msg</div>"; ?>
				<table border='0' align="left" cellpadding="0" cellspacing="0" width="400">
					<tr>
						<td align="center" class="tabTableTitle">
							<? echo $lang['s']; ?> <? if (!strcmp($_GET["o"], "c") || !strcmp($_GET["o"], "w")) {  echo "\"" . $services[$sv]->get_description() . "\"";} ?>
						</td>
					</tr>
					<tr>
						<td class="tabTableForTab">
						<? 	if (!strcmp($_GET["o"], "w") || !strcmp($_GET["o"], "c") || !strcmp($_GET["o"], "a"))
								include("./include/configuration/service/service_".$_GET["o"].".php"); ?>
						</td>
					</tr>
				</table>
			</td>
			<td valign="top" style="padding-left: 20px;">
			<? if (!strcmp($_GET["o"], "w") || !strcmp($_GET["o"], "c")) { 	?>
			<!-- <td valign="top" align="left">-->
				<table border='0' cellpadding="0" cellspacing="0" width="180">
					<tr>
						<td align="align" class="tabTableTitle"><? echo $lang['options']; ?></td>
					</tr>
					<tr>
						<td style="white-space: nowrap;" class="tabTableMenu">
						<ul>
							<li><a href='./phpradmin.php?p=315&id=<? print $sv; ?>' class="text10"><? echo $lang['status_options']; ?></a> </li>
							<? if (isset($oreon->graphs[$sv]))
									echo "<li><a href='./phpradmin.php?p=310&gr=$sv&o=v' class='text10'>".$lang['g_see'] ."</a> </li>";	?>
						</ul>
						</td>
					</tr>
				</table>
			</td>
			<? }?>
		</tr>
	</table>
<? } ?>