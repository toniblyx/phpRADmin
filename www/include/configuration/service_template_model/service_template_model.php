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

	$stms = & $oreon->stms;
	if (isset($_GET) && array_key_exists("o", $_GET) && $_GET["o"] != "a" && $_GET["o"] != "l")
		if (!isset($_GET["stm_id"]) || (isset($_GET["stm_id"]) && !array_key_exists($_GET["stm_id"], $stms)))	{
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
	$serviceGroups = & $oreon->serviceGroups;
	$graphs = & $oreon->graphs;

	if (isset($_POST["AddSTM"]))	{
		$stm_array = & $_POST["stm"];
		if (get_magic_quotes_gpc()) {
		 if (isset($stm_array[command_command_id_arg]))
		 	$stm_array[command_command_id_arg] =  stripslashes($stm_array[command_command_id_arg]);
		 if (isset($stm_array[command_command_id2_arg]))
			$stm_array[command_command_id2_arg] =  stripslashes($stm_array[command_command_id2_arg]);
		}
		// Concat options
		$stm_array["service_stalking_options"] = NULL;
		if (isset($stm_array["service_stalking_options_o"])) $stm_array["service_stalking_options"] .= $stm_array["service_stalking_options_o"];
		if (strcmp($stm_array["service_stalking_options"], "") && isset($stm_array["service_stalking_options_w"])  && strcmp($stm_array["service_stalking_options_w"], "")) $stm_array["service_stalking_options"] .= ",";
		if (isset($stm_array["service_stalking_options_w"])) $stm_array["service_stalking_options"] .= $stm_array["service_stalking_options_w"];
		if (strcmp($stm_array["service_stalking_options"], "") && isset($stm_array["service_stalking_options_u"])  && strcmp($stm_array["service_stalking_options_u"], "")) $stm_array["service_stalking_options"] .= ",";
		if (isset($stm_array["service_stalking_options_u"])) $stm_array["service_stalking_options"] .= $stm_array["service_stalking_options_u"];
		if (strcmp($stm_array["service_stalking_options"], "") && isset($stm_array["service_stalking_options_c"]) && strcmp($stm_array["service_stalking_options_c"], "")) $stm_array["service_stalking_options"] .= ",";
		if (isset($stm_array["service_stalking_options_c"])) $stm_array["service_stalking_options"] .= $stm_array["service_stalking_options_c"];
		// Concat options
		$stm_array["service_notification_options"] = NULL;
		if (isset($stm_array["service_notification_options_w"])) $stm_array["service_notification_options"] .= $stm_array["service_notification_options_w"];
		if (strcmp($stm_array["service_notification_options"], "") && isset($stm_array["service_notification_options_u"]) && strcmp($stm_array["service_notification_options_u"], "")) $stm_array["service_notification_options"] .= ",";
		if (isset($stm_array["service_notification_options_u"])) $stm_array["service_notification_options"] .= $stm_array["service_notification_options_u"];
		if (strcmp($stm_array["service_notification_options"], "") && isset($stm_array["service_notification_options_c"]) && strcmp($stm_array["service_notification_options_c"], "")) $stm_array["service_notification_options"] .= ",";
		if (isset($stm_array["service_notification_options_c"])) $stm_array["service_notification_options"] .= $stm_array["service_notification_options_c"];
		if (strcmp($stm_array["service_notification_options"], "") && isset($stm_array["service_notification_options_r"]) && strcmp($stm_array["service_notification_options_r"], "")) $stm_array["service_notification_options"] .= ",";
		if (isset($stm_array["service_notification_options_r"]))$stm_array["service_notification_options"] .= $stm_array["service_notification_options_r"];

		if (isset($stm_array["command_command_id_arg"]) )
			$stm_array["command_command_id_arg"] = preg_replace("/^([\t| ]+)/", "", $stm_array["command_command_id_arg"] );
		if (isset($stm_array["command_command_id2_arg"]) )
			$stm_array["command_command_id2_arg"] = preg_replace("/^([\t| ]+)/", "", $stm_array["command_command_id2_arg"] );
		/* if (isset($stm_array["command_command_id_arg"]) && !$stm_array["command_command_id_arg"])
			$stm_array["command_command_id_arg"] = "#BLANK#";
		if (isset($stm_array["command_command_id2_arg"]) && !$stm_array["command_command_id2_arg"])
			$stm_array["command_command_id2_arg"] = "#BLANK#"; */
		if (isset($stm_array["service_freshness_threshold"]) && !$stm_array["service_freshness_threshold"])
			$stm_array["service_freshness_threshold"] = 99999;
		else if (!isset($stm_array["service_freshness_threshold"]) && isset($stm_array["ftNothingBox"]))
			$stm_array["service_freshness_threshold"] = 0;
		if (isset($stm_array["service_low_flap_threshold"]) && !$stm_array["service_low_flap_threshold"])
			$stm_array["service_low_flap_threshold"] = 99999;
		else if (!isset($stm_array["service_low_flap_threshold"]) && isset($stm_array["lftNothingBox"]))
			$stm_array["service_low_flap_threshold"] = 0;
		if (isset($stm_array["service_high_flap_threshold"]) && !$stm_array["service_high_flap_threshold"])
			$stm_array["service_high_flap_threshold"] = 99999;
		else if (!isset($stm_array["service_high_flap_threshold"]) && isset($stm_array["hftNothingBox"]))
			$stm_array["service_high_flap_threshold"] = 0;
		if (isset($stm_array["service_notification_interval"]) && !$stm_array["service_notification_interval"])
			$stm_array["service_notification_interval"] = 99999;
		if (isset($sv_array["service_comment"]) && !$stm_array["service_comment"])
			$stm_array["service_comment"] = "#BLANK#";

		// put id to -1
		$stm_array["service_id"] = -1;
		$service_object = new Service($stm_array);
		// Init Contact Group
		if (isset($_POST["selectCG"]))	{
			$selectContactGroup = $_POST["selectCG"];
			for ($i = 0; $i < count($selectContactGroup); $i++)
				$service_object->contactGroups[$selectContactGroup[$i]] = & $contactGroups[$selectContactGroup[$i]];
		}	else
				$service_object->contactGroups = array();
		// log add
		system("echo \"[" . time() . "] AddServiceTemplate;" . addslashes($service_object->get_description()) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
		$oreon->saveService($service_object);
		$service_id = $oreon->database->database->get_last_id();
		// Set a description for the Template Model
		if (!$stm_array["service_description"])
			$service_object->set_description("STemplate_".$service_id);
		else
			$service_object->set_description("STemplate_".str_replace(" ", "_", $stm_array["service_description"]));
		$stm_array["stm_id"] = $service_id;
		$stm_object = new ServiceTemplateModel($stm_array);
		$stms[$service_id] = $stm_object;
		// Add Template Model as a Service not register in oreon->services
		$services[$service_id] = $service_object;
		$services[$service_id]->set_id($service_id);
		if (isset($stm_array["service_is_volatile"])) $services[$service_id]->set_is_volatile($stm_array["service_is_volatile"]);
		if (isset($stm_array["service_active_checks_enabled"])) $services[$service_id]->set_active_checks_enabled($stm_array["service_active_checks_enabled"]);
		if (isset($stm_array["service_passive_checks_enabled"])) $services[$service_id]->set_passive_checks_enabled($stm_array["service_passive_checks_enabled"]);
		if (isset($stm_array["service_parallelize_check"])) $services[$service_id]->set_parallelize_check($stm_array["service_parallelize_check"]);
		if (isset($stm_array["service_obsess_over_service"])) $services[$service_id]->set_obsess_over_service($stm_array["service_obsess_over_service"]);
		if (isset($stm_array["service_check_freshness"])) $services[$service_id]->set_check_freshness($stm_array["service_check_freshness"]);
		if (isset($stm_array["service_freshness_threshold"])) $services[$service_id]->set_freshness_threshold($stm_array["service_freshness_threshold"]);
		if (isset($stm_array["service_event_handler_enabled"])) $services[$service_id]->set_event_handler_enabled($stm_array["service_event_handler_enabled"]);
		if (isset($stm_array["command_command_id2"])) $services[$service_id]->set_event_handler($stm_array["command_command_id2"]);
		if (isset($stm_array["command_command_id2_arg"])) {
			$stm_array["command_command_id2_arg"] =  ltrim($stm_array["command_command_id2_arg"] );
		//	$stm_array["command_command_id2_arg"] = preg_replace("/^([\t| ]*)/", "", $stm_array["command_command_id2_arg"] );
			$services[$service_id]->set_event_handler_arg($stm_array["command_command_id2_arg"]);
		}
		if (isset($stm_array["service_low_flap_threshold"])) $services[$service_id]->set_low_flap_threshold($stm_array["service_low_flap_threshold"]);
		if (isset($stm_array["service_high_flap_threshold"])) $services[$service_id]->set_high_flap_threshold($stm_array["service_high_flap_threshold"]);
		if (isset($stm_array["service_flap_detection_enabled"])) $services[$service_id]->set_flap_detection_enabled($stm_array["service_flap_detection_enabled"]);
		if (isset($stm_array["service_process_perf_data"])) $services[$service_id]->set_process_perf_data($stm_array["service_process_perf_data"]);
		if (isset($stm_array["service_retain_status_information"])) $services[$service_id]->set_retain_status_information($stm_array["service_retain_status_information"]);
		if (isset($stm_array["service_retain_nonstatus_information"])) $services[$service_id]->set_retain_nonstatus_information($stm_array["service_retain_nonstatus_information"]);
		if (isset($stm_array["service_notification_enabled"])) $services[$service_id]->set_notification_enabled($stm_array["service_notification_enabled"]);
		if (isset($stm_array["service_stalking_options"])) $services[$service_id]->set_stalking_options($stm_array["service_stalking_options"]);
		if (isset($stm_array["service_comment"])) $services[$service_id]->set_comment($stm_array["service_comment"]);
		$services[$service_id]->set_register(0);
		$services[$service_id]->set_activate(1);
		// Init Service Group
		if (isset($_POST["selectSG"]))	{
			$selectServiceGroup = $_POST["selectSG"];
			for ($i = 0; $i < count($selectServiceGroup); $i++)
				$services[$service_id]->serviceGroups[$selectServiceGroup[$i]] = & $serviceGroups[$selectServiceGroup[$i]];
		}	else
				$services[$service_id]->serviceGroups = array();
		// Update Service and Template Model in database
		$oreon->saveService($services[$service_id]);
		$msg = $lang['errCode'][3];
		$_GET["o"] = "w";
		$_GET["stm_id"] = $service_id;
	}

	if (isset($_POST["ChangeSTM"]))	{
		$stm_array = & $_POST["stm"];
		if (get_magic_quotes_gpc()) {
		 if (isset($stm_array[command_command_id_arg]))
		 	$stm_array[command_command_id_arg] =  stripslashes($stm_array[command_command_id_arg]);
		 if (isset($stm_array[command_command_id2_arg]))
			$stm_array[command_command_id2_arg] =  stripslashes($stm_array[command_command_id2_arg]);
		}

		$stm_id = $stm_array["stm_id"];
		$stm_array["service_id"] = $stm_id;
		// We keep old Service Template ($service)
		$service_temp = $services[$stm_id];

		// Init Service Template
		// Concat options
		$stm_array["service_stalking_options"] = NULL;
		if (isset($stm_array["service_stalking_options_o"])) $stm_array["service_stalking_options"] .= $stm_array["service_stalking_options_o"];
		if (strcmp($stm_array["service_stalking_options"], "") && isset($stm_array["service_stalking_options_w"])  && strcmp($stm_array["service_stalking_options_w"], "")) $stm_array["service_stalking_options"] .= ",";
		if (isset($stm_array["service_stalking_options_w"])) $stm_array["service_stalking_options"] .= $stm_array["service_stalking_options_w"];
		if (strcmp($stm_array["service_stalking_options"], "") && isset($stm_array["service_stalking_options_u"])  && strcmp($stm_array["service_stalking_options_u"], "")) $stm_array["service_stalking_options"] .= ",";
		if (isset($stm_array["service_stalking_options_u"])) $stm_array["service_stalking_options"] .= $stm_array["service_stalking_options_u"];
		if (strcmp($stm_array["service_stalking_options"], "") && isset($stm_array["service_stalking_options_c"]) && strcmp($stm_array["service_stalking_options_c"], "")) $stm_array["service_stalking_options"] .= ",";
		if (isset($stm_array["service_stalking_options_c"])) $stm_array["service_stalking_options"] .= $stm_array["service_stalking_options_c"];
		// Concat options
		$stm_array["service_notification_options"] = NULL;
		if (isset($stm_array["service_notification_options_w"])) $stm_array["service_notification_options"] .= $stm_array["service_notification_options_w"];
		if (strcmp($stm_array["service_notification_options"], "") && isset($stm_array["service_notification_options_u"]) && strcmp($stm_array["service_notification_options_u"], "")) $stm_array["service_notification_options"] .= ",";
		if (isset($stm_array["service_notification_options_u"])) $stm_array["service_notification_options"] .= $stm_array["service_notification_options_u"];
		if (strcmp($stm_array["service_notification_options"], "") && isset($stm_array["service_notification_options_c"]) && strcmp($stm_array["service_notification_options_c"], "")) $stm_array["service_notification_options"] .= ",";
		if (isset($stm_array["service_notification_options_c"])) $stm_array["service_notification_options"] .= $stm_array["service_notification_options_c"];
		if (strcmp($stm_array["service_notification_options"], "") && isset($stm_array["service_notification_options_r"]) && strcmp($stm_array["service_notification_options_r"], "")) $stm_array["service_notification_options"] .= ",";
		if (isset($stm_array["service_notification_options_r"]))$stm_array["service_notification_options"] .= $stm_array["service_notification_options_r"];

		if (isset($stm_array["command_command_id_arg"]) )
			$stm_array["command_command_id_arg"] = preg_replace("/^([\t| ]+)/", "", $stm_array["command_command_id_arg"] );
		if (isset($stm_array["command_command_id2_arg"]) )
			$stm_array["command_command_id2_arg"] = preg_replace("/^([\t| ]+)/", "", $stm_array["command_command_id2_arg"] );
		/* if (isset($stm_array["command_command_id_arg"]) && !$stm_array["command_command_id_arg"])
			$stm_array["command_command_id_arg"] = "#BLANK#";
		if (isset($stm_array["command_command_id2_arg"]) && !$stm_array["command_command_id2_arg"])
			$stm_array["command_command_id2_arg"] = "#BLANK#"; */
		if (isset($stm_array["service_freshness_threshold"]) && !$stm_array["service_freshness_threshold"])
			$stm_array["service_freshness_threshold"] = 99999;
		else if (!isset($stm_array["service_freshness_threshold"]) && isset($stm_array["ftNothingBox"]))
			$stm_array["service_freshness_threshold"] = 0;
		if (isset($stm_array["service_low_flap_threshold"]) && !$stm_array["service_low_flap_threshold"])
			$stm_array["service_low_flap_threshold"] = 99999;
		else if (!isset($stm_array["service_low_flap_threshold"]) && isset($stm_array["lftNothingBox"]))
			$stm_array["service_low_flap_threshold"] = 0;
		if (isset($stm_array["service_high_flap_threshold"]) && !$stm_array["service_high_flap_threshold"])
			$stm_array["service_high_flap_threshold"] = 99999;
		else if (!isset($stm_array["service_high_flap_threshold"]) && isset($stm_array["hftNothingBox"]))
			$stm_array["service_high_flap_threshold"] = 0;
		if (isset($stm_array["service_notification_interval"]) && !$stm_array["service_notification_interval"])
			$stm_array["service_notification_interval"] = 99999;
		if (isset($sv_array["service_comment"]) && !$stm_array["service_comment"])
			$stm_array["service_comment"] = "#BLANK#";

		// Replace white space
		if (!$stm_array["service_description"])
			$stm_array["service_description"] = "STemplate_".$service_id;
		if (!strstr($stm_array["service_description"], "STemplate_"))
			$stm_array["service_description"] = "STemplate_".$stm_array["service_description"];
		$stm_array["service_description"] = str_replace(" ", "_", $stm_array["service_description"]);
		$service_object = new Service($stm_array);
		// log add
		system("echo \"[" . time() . "] ModifServiceTemplate;" . addslashes($service_object->get_description()) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
		// Init Contact Group
		if (isset($_POST["selectCG"]))	{
			$selectContactGroup = $_POST["selectCG"];
			for ($i = 0;  $i < count($selectContactGroup); $i++)
				$service_object->contactGroups[$selectContactGroup[$i]] = & $contactGroups[$selectContactGroup[$i]];
		}	else
				$service_object->contactGroups = array();
		$services[$stm_id] = $service_object;
		if (isset($stm_array["service_is_volatile"])) $services[$stm_id]->set_is_volatile($stm_array["service_is_volatile"]);
		if (isset($stm_array["service_active_checks_enabled"])) $services[$stm_id]->set_active_checks_enabled($stm_array["service_active_checks_enabled"]);
		if (isset($stm_array["service_passive_checks_enabled"])) $services[$stm_id]->set_passive_checks_enabled($stm_array["service_passive_checks_enabled"]);
		if (isset($stm_array["service_parallelize_check"])) $services[$stm_id]->set_parallelize_check($stm_array["service_parallelize_check"]);
		if (isset($stm_array["service_obsess_over_service"])) $services[$stm_id]->set_obsess_over_service($stm_array["service_obsess_over_service"]);
		if (isset($stm_array["service_check_freshness"])) $services[$stm_id]->set_check_freshness($stm_array["service_check_freshness"]);
		if (isset($stm_array["service_freshness_threshold"])) $services[$stm_id]->set_freshness_threshold($stm_array["service_freshness_threshold"]);
		if (isset($stm_array["service_event_handler_enabled"])) $services[$stm_id]->set_event_handler_enabled($stm_array["service_event_handler_enabled"]);
		if (isset($stm_array["command_command_id2"])) $services[$stm_id]->set_event_handler($stm_array["command_command_id2"]);
		if (isset($stm_array["command_command_id2_arg"])) {
			$stm_array["command_command_id2_arg"] = preg_replace("/^([\t| ]*)/", "", $stm_array["command_command_id2_arg"] );
			$services[$stm_id]->set_event_handler_arg($stm_array["command_command_id2_arg"]);
		}
		if (isset($stm_array["service_low_flap_threshold"])) $services[$stm_id]->set_low_flap_threshold($stm_array["service_low_flap_threshold"]);
		if (isset($stm_array["service_high_flap_threshold"])) $services[$stm_id]->set_high_flap_threshold($stm_array["service_high_flap_threshold"]);
		if (isset($stm_array["service_flap_detection_enabled"])) $services[$stm_id]->set_flap_detection_enabled($stm_array["service_flap_detection_enabled"]);
		if (isset($stm_array["service_process_perf_data"])) $services[$stm_id]->set_process_perf_data($stm_array["service_process_perf_data"]);
		if (isset($stm_array["service_retain_status_information"])) $services[$stm_id]->set_retain_status_information($stm_array["service_retain_status_information"]);
		if (isset($stm_array["service_retain_nonstatus_information"])) $services[$stm_id]->set_retain_nonstatus_information($stm_array["service_retain_nonstatus_information"]);
		if (isset($stm_array["service_notification_enabled"])) $services[$stm_id]->set_notification_enabled($stm_array["service_notification_enabled"]);
		if (isset($stm_array["service_stalking_options"])) $services[$stm_id]->set_stalking_options($stm_array["service_stalking_options"]);
		if (isset($stm_array["service_comment"])) $services[$stm_id]->set_comment($stm_array["service_comment"]);
		$services[$stm_id]->set_register(0);
		$services[$stm_id]->set_activate(1);
		// Add service_id in check command arguments for graph
		if ($stm_array["command_command_id"] && strstr($commands[$stm_array["command_command_id"]]->get_name(), "check_graph"))	{
			if (isset($services))
				foreach ($services as $service)	{
					if ($service->get_service_template() == $stm_id)	{
						if (!$service->get_check_command() && $service->get_check_command_arg() && !preg_match("/(\!".$service->get_id().")$/", $service->get_check_command_arg()))
							$services[$service->get_id()]->set_check_command_arg($service->get_check_command_arg()."!".$service->get_id());
						else if (!$service->get_check_command() && $service->get_check_command_arg() && preg_match("/(\!".$service->get_id().")$/", $service->get_check_command_arg()) && !strcmp($service_temp->get_check_command_arg(), preg_replace("/(\!".$service->get_id().")$/", "", $service->get_check_command_arg())))
							$services[$service->get_id()]->set_check_command_arg($services[$stm_id]->get_check_command_arg()."!".$service->get_id());
						else if (!$service->get_check_command() && !$service->get_check_command_arg())
							$services[$service->get_id()]->set_check_command_arg($services[$stm_id]->get_check_command_arg()."!".$service->get_id());
						if (!$service->get_check_command())	{
							include_once("./include/graph/graphFunctions.php");
							$graph_array = & initGraph($service->get_id(), getcwd());
							$graph = new GraphRRD($graph_array);
							$oreon->saveGraph($graph);
							$graphs[$service->get_id()] = $graph;
							$oreon->saveService($services[$service->get_id()]);
						}
					}
					unset($service);
				}
		}	else {
				if (isset($services))
					foreach ($services as $service)	{
						if ($service->get_service_template() == $stm_id)	{
							if (!$service->get_check_command() && $service->get_check_command_arg() && preg_match("/(\!".$service->get_id().")$/", $service->get_check_command_arg()))	{
								$services[$service->get_id()]->set_check_command_arg(preg_replace("/(\!".$service->get_id().")$/", "", $service->get_check_command_arg()));
								$services[$service->get_id()]->set_check_command_arg(NULL);
								if (isset($graphs[$service->get_id()]))
									$oreon->deleteGraph($graphs[$service->get_id()]);
								$oreon->saveService($services[$service->get_id()]);
							}
						}
						unset($service);
					}
		}
		// Init Service Group
		if (isset($_POST["selectSG"]))	{
			$selectServiceGroup = $_POST["selectSG"];
			for ($i = 0; $i < count($selectServiceGroup); $i++)
				$services[$stm_id]->serviceGroups[$selectServiceGroup[$i]] = & $serviceGroups[$selectServiceGroup[$i]];
		}	else
				$services[$stm_id]->serviceGroups = array();
		// Update Template Model in database (as a service not register)
		$oreon->saveService($services[$stm_id]);
		$msg = $lang['errCode'][2];
		$_GET["o"] = "w";
	}

	if (isset($_GET["o"]) && !strcmp($_GET["o"], "d"))	{
		// log add
		system("echo \"[" . time() . "] DeleteServiceTemplateModel;" . addslashes($services[$_GET["stm_id"]]->get_description()) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
		$oreon->deleteService($services[$_GET["stm_id"]]);
		unset($_GET["o"]);
		unset($_GET["stm_id"]);
	}

	if (isset($_GET["o"]) && !strcmp($_GET["o"], "l"))	{
		if (isset($_GET["box"]))	{
			$boxx = & $_GET["box"];
			foreach ($boxx as $box)	{
				// log add
				system("echo \"[" . time() . "] DeleteServiceTemplateModel;" . addslashes( $services[$box]->get_description()) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
				$oreon->deleteService($services[$box]);
			}
		}
		unset($_GET["o"]);
	}

	// Initialise YES NO or NOTHING Value

		$value_flag["1"] = "Yes";
		$value_flag["2"] = "Nothing";
		$value_flag["3"] = "No";

	// -----------------------------------
	function write_stm_list(&$services, &$stms, $lang)	{
		?>
		<table cellpadding="0" cellspacing="0" width="200">
			<tr>
				<td class="tabTableTitleMenu"><? print $lang["m_options"]; ?></td>
			</tr>
			<tr>
				<td class="tabTableMenu">
					<div style="padding: 8px; text-align: center;">
						<img src="img/picto2.gif">
						<a href="phpradmin.php?p=125&o=a" class="text9"><? echo $lang['add']; ?></a>
						<img src="img/picto2_bis.gif">
					</div>
				</td>
			</tr>
		</table>
		<br>
		<table cellpadding="0" cellspacing="0" width="200">
			<tr>
				<td class="tabTableTitleMenu" style="white-space: nowrap"><? print $lang['stm_available']; ?></td>
			</tr>
			<tr>
				<td class="tabTableMenu"> <?
				if (isset($stms))
					foreach ($stms as $stm)	{ ?>
						<div style="padding: 2px; white-space: nowrap" align="left">
							<li>
								<a href="phpradmin.php?p=125&stm_id=<? echo $stm->get_id(); ?>&o=w" class="text10">
									<? echo $services[$stm->get_id()]->get_description(); ?>
								</a>
							</div>
						</div>
				<?  unset($stm); } ?>
				</td>
			</tr>
		</table><?
	}

	function write_stm_list2(&$services, &$stms, $lang)	{	?>
		<form action="" name="serviceTemplateModelMenu" method="get">
			<table cellpadding="3" cellspacing="3">
				<tr>
					<td class="listTop"></td>
					<td align="left" class="listTop" style="padding-left: 20px; padding-right: 20px;"><? echo $lang['description']; ?></td>
					<td align="center" class="listTop" style="padding-left: 20px; padding-right: 20px;"><? echo $lang['status']; ?></td>
					<td align="center" class="listTop" style="padding-left: 20px; padding-right: 20px;"><? echo $lang['options']; ?></td>
				</tr>
	<?
		if (!isset($_GET["num"]))
			$num = 1;
		else
			$num = $_GET["num"];
		if (isset($stms) && count($stms) != 0)	{
			$cpt = 0;
			foreach ($stms as $stm)	{
				if ($cpt < (VIEW_MAX * $num) && ($cpt >= ((VIEW_MAX * $num) - (VIEW_MAX)))){	?>
				<tr>
					<td class="listSub<? echo $cpt%2; ?>"><input type="checkbox" name="box[<? echo $stm->get_id(); ?>]" value="<? echo $stm->get_id(); ?>"></td>
					<td align="left" class="listSub<? echo $cpt%2; ?>"><? echo $services[$stm->get_id()]->get_description(); ?></td>
					<td align="center" class="listSub<? echo $cpt%2; ?>"><? echo $lang['enable']; ?></td>
					<td align="center" class="listSub<? echo $cpt%2; ?>">
						&nbsp;&nbsp;
						<a href="phpradmin.php?p=125&stm_id=<? echo $stm->get_id(); ?>&o=w" class="text11"><img src="img/listView.gif" border="0" alt="<? echo $lang['view']; ?>" title="<? echo $lang['view']; ?>"></a>&nbsp;
						<a href="phpradmin.php?p=125&stm_id=<? echo $stm->get_id(); ?>&o=c" class="text11"><img src="img/listPen.gif" border="0" alt="<? echo $lang['modify']; ?>" title="<? echo $lang['modify']; ?>"></a>&nbsp;
						<a href="phpradmin.php?p=125&stm_id=<? echo $stm->get_id(); ?>&o=d&num=<? echo $num; ?>&limit=<? echo VIEW_MAX; ?>" class="text11" onclick="return confirm('<? echo $lang['confirm_removing']; ?>')"><img src="img/listDel.gif" border="0" alt="<? echo $lang['delete']; ?>" title="<? echo $lang['delete']; ?>"></a>&nbsp;&nbsp;
					</td>
				</tr>
			<?	}
				unset($serviceGroup);
				$cpt++;
				}
			} ?>
			<tr>
				<td colspan="2" valign="top"><img src="img/arrow_ltr.gif" style="padding-left: 5px;">&nbsp;&nbsp;	<a href="#" class="text10bc" onclick=" if (confirm('<? echo $lang['confirm_removing']; ?>')){document.forms['serviceTemplateModelMenu'].submit();}"><? echo $lang['m_delete_selection']; ?></a></td>
				<td></td>
				<td colspan="2" align="right" class="text10">
					<a href="phpradmin.php?p=125&o=a" class="text10bc"><? echo $lang['add']; ?></a>&nbsp;&nbsp;<br><br>
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
					<? $nbrPage = floor(count($stms)/VIEW_MAX); if(count($stms)%VIEW_MAX) $nbrPage++; ?>
					<? echo "<font class='text11b'>".$lang["page"]. ":&nbsp;&nbsp;</font>[&nbsp;&nbsp;";
						for ($i = 1; $i <= $nbrPage; $i++)	{
							if($num == $i)
								echo "<a href='./phpradmin.php?p=125&num=$i&limit=".VIEW_MAX."' class='text10'><b>$i</b></a>&nbsp;&nbsp;";
							else
								echo "<a href='./phpradmin.php?p=125&num=$i&limit=".VIEW_MAX."' class='text10'>$i</a>&nbsp;&nbsp;";
						}
						echo "]";
					?>
				</td>
			</tr>
		</table>
		<input type="hidden" name="p" value="125">
		<input type="hidden" name="o" value="l" id="option">
	</form>
	<? } 

if (!isset($_GET["o"])){ ?>
	<table border="0">
		<tr>
			  <td valign="top" align="left">
				<? write_stm_list2($services, $stms, $lang); ?>
			  </td>
		</tr>
	</table><?
} else if (isset($_GET["o"]))	{
		if (isset($_GET["stm_id"]))
			$stm_id= $_GET["stm_id"]; ?>
	<table align="left" border="0">
		<tr>
			<td valign="top" align="left"><?  write_stm_list($services, $stms, $lang); ?></td>
			<td valign="top" style="padding-left: 20px;"></td>
			<td valign="top" align='left'>
				<? if (isset($msg))
				echo "<div align='center' class='msg' style='padding-bottom: 10px;'>$msg</div>"; ?>
				<table border='0' align="left" cellpadding="0" cellspacing="0">
					<tr>
						<td class="tabTableTitle" style="white-space: nowrap;">Service Template Model <? if (!strcmp($_GET["o"], "c") || !strcmp($_GET["o"], "w")) {  echo "\"" .$services[$stm_id]->get_description() . "\"";} ?></td>
					</tr>
					<tr>
						<td class="tabTableForTab">
						<? 	if (!strcmp($_GET["o"], "w") || !strcmp($_GET["o"], "c") || !strcmp($_GET["o"], "a"))
								include("./include/configuration/service_template_model/service_template_model_".$_GET["o"].".php"); ?>
					</td>
				</tr>
			</table>
		</td>
		<td valign="top" style="padding-left: 20px;">
		<? if (isset($_GET["o"]) && (!strcmp($_GET["o"], "w") || !strcmp($_GET["o"], "c"))) { ?>
		<td valign="top" align="left">
			<table border='0' cellpadding="0" cellspacing="0">
				<tr>
					<td align="align" class="tabTableTitle" style="white-space: nowrap;"><? echo $lang['stm_stats1']; ?></td>
				</tr>
				<tr>
					<td style="white-space: nowrap;" class="tabTable">
						<?
						if (isset($services))
							foreach ($services as $service)	{
								if ($service->get_service_template() == $_GET["stm_id"])
									echo "<li><a href='./phpradmin.php?p=104&sv=" . $service->get_id() . "&o=w' class='text10b'>".$hosts[$service->get_host()]->get_name()." - ".$service->get_description()."</a></li>";
								unset($service);
							}
						?>
					</td>
				</tr>
				<tr>
					<td bgcolor="#CCCCCC"></td>
				</tr>
			</table>
		</td>
		<? } ?>
		</tr>
	</table>
	<? } ?>