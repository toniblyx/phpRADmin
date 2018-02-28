<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/if (!isset($oreon))
	exit();

	$hosts = & $oreon->hosts;
	$hostGroups = & $oreon->hostGroups;
	$contactGroups = & $oreon->contactGroups;
	$serviceGroups = & $oreon->serviceGroups;
	$htms = & $oreon->htms;
	$stms = & $oreon->stms;
	$commands= & $oreon->commands;
	$timePeriods = & $oreon->time_periods;
	$services = & $oreon->services;
	$graphs = & $oreon->graphs;

	// Detecting Hosts and Services
	function detect($oreon, $ip)	{ 	
		$ip_after = preg_split ("/;/", $ip);
		$stdout = shell_exec($oreon->optGen->get_sudo_path()." " . $ip_after[0]);
		$tab = preg_split ("/[\n]+/", $stdout);
		$index = -1;
		foreach ($tab as $str){
			if (preg_match("/^Interesting ports on[ ]*([a-zA-z0-9\-\_\.]+)[ ]+[\(]*([0-9]+[\.]{1}[0-9]+[\.]{1}[0-9]+[\.]{1}[0-9]+)[\)]*/", $str, $matches)){
				$index++;
				$index_port = -1;
				$oreon->AutoDetect[$index] = new Detected($matches[2], $matches[1], $index);
			}
			else if (preg_match("/^Interesting ports on[ ]*[\(]*([0-9]+[\.]{1}[0-9]+[\.]{1}[0-9]+[\.]{1}[0-9]+)[\)]*/", $str, $matches)){
				$index++;
				$index_port = -1;
				$oreon->AutoDetect[$index] = new Detected($matches[1], "", $index);
			}
			if (preg_match("/^([0-9]+)\/tcp[ ]+open[ ]{2}([A-Za-z0-9\-\_]+)/", $str, $matches)){
				$index_port++;
				$oreon->AutoDetect[$index]->port_list[$index_port] = $matches[1];
				$oreon->AutoDetect[$index]->name_list[$index_port] = $matches[2];
				$oreon->AutoDetect[$index]->check_list[$index_port] = 0;
			}
		}
		return $oreon ;
	}
	// End Detecting

	// redirect page			
	if (isset($oreon->AutoDetect) && !isset($_GET["o"]))
		$_GET["o"] = "d";
	// End redirect
	
	// Return color
	function return_color($i)	{
		if ($i % 2 == 1)
			return  "#E9E9E9";
		else
			return "#E0E0E0";
	} 
	// end return color

	// Add Host
	if (isset($_POST["AddHost"]) && isset($_POST["o"]) && !strcmp($_POST["o"], "ahf") && isset($_POST["id"]) && strcmp($_POST["id"], ""))	{
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
		$host_object->contactgroups = array();
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
			system("echo \"[" . time() . "] AddHost;" . $host_object->get_name() . ";" . $oreon->user->get_alias() . "\" >> ./include/log/" . date("Ymd") . ".txt");
			// If we use the template, we have to set a new object host, in order to take only the value off the form - record in $host_array_tmp
			if (isset($htm_id))	{
				$host_object = new Host($host_array_tmp);
				if (isset($_POST["selectContactGroup"])) 	{
					$selectContactGroup	= $_POST["selectContactGroup"];		
					for ($i = 0; $i < count($selectContactGroup); $i++)
						$host_object->contactgroups[$selectContactGroup[$i]] = & $contactGroups[$selectContactGroup[$i]];
				} else
					$host_object->contactgroups = array();
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
			if (isset($host_array["host_activate"])) $hosts[$host_id]->set_activate(1); else $hosts[$host_id]->set_activate(0);
			$hosts[$host_id]->set_register(1);
			// Init Host Parent
			$hosts[$host_id]->parents = array();
			if (isset($_POST["selectHostParent"]))	{
				$selectHostParent = $_POST["selectHostParent"];
				for ($i = 0; $i < count($selectHostParent); $i++)
					$hosts[$host_id]->parents[$selectHostParent[$i]] = & $hosts[$selectHostParent[$i]];
			}							
			// Init Host Group
			$hosts[$host_id]->hostGroups = array();
			if (isset($_POST["selectHostGroup"]))	{
				$selectHostGroup = $_POST["selectHostGroup"];
				for ($i = 0; $i < count($selectHostGroup); $i++)
					$hosts[$host_id]->hostGroups[$selectHostGroup[$i]] = & $hostGroups[$selectHostGroup[$i]];
			}					
			// Update Host in database
			$oreon->saveHost($hosts[$host_id]);
			$msg = $lang['errCode'][3];
			$_GET["o"] = "d";
		}
		else
			$msg = $lang['errCode'][$host_object->get_errCode()];
		unset($host_object);
	}
	
	// Add Service
	if (isset($_POST["AddService"]) && !strcmp($_POST["o"], "asf") && isset($_POST["id"]) && strcmp($_POST["id"], ""))	{
		$hostApplyService = array();
		$sv_array = & $_POST["sv"];
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
					if (isset($sv_array["service_activate"])) $services[$sv_id]->set_activate(1); else $services[$sv_id]->set_activate(0);
					$services[$sv_id]->set_register(1);
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
?>
	<table>
		<tr>
			<td valign="top" align="left">
				<table align="left" cellpadding="0" cellspacing="0">
					<tr>
						<td align="left" valign="top"><? 
							if (isset($msg))
								echo "<div style='padding-bottom: 10px;' class='msg' align='center'>$msg</div>"; ?>
							<form action="phpradmin.php" method="get">
							<table align="left" border="0" cellpadding="0" cellspacing="0">		
								<tr>
									<td class="tabTableTitle">
										<? echo $lang['ad_title']; ?>
									</td>
								</tr>
								<tr>
									<td style="padding-bottom: 15px;" class="tabTableForTab">
										<div class="text12b" style="text-align: center'">
											<? echo $lang['ad_infos1']; ?>
										</div>
										<div class="text11" style="white-space: nowrap;">
											<ul>
												<li><? echo $lang['ad_infos2']; ?></li>
												<li><? echo $lang['ad_infos3']; ?></li>
												<li>
													<? echo $lang['ad_infos4']; ?>
														<ul>
															<li><? echo $lang['ad_infos5']; ?></li>
															<li><? echo $lang['ad_infos6']; ?></li>
															<li><? echo $lang['ad_infos7']; ?></li>
														</ul>
												</li>
											</ul>
										</div>
										<div align="center">
											<input name="p" type="hidden" value="124">
											<input name="o" type="hidden" value="d">
											<input name="a" type="hidden" value="clean">
											<? echo $lang['ad_ip']; ?>&nbsp;&nbsp;
											<input name="ip" type="text">
											<input name="go" type="submit" value="Go">
										</div>
									</td>
								</tr>
							</table>
							</form>
						</td>
					</tr>
				</table>			
			</td>
			<td style="padding-left: 20px;"></td>
			<?  if (isset($_GET["o"]) && !strcmp($_GET["o"], "d")){
			// Launch Research
				if (isset($_GET["a"]) && !strcmp($_GET["a"], "clean"))
					unset($oreon->AutoDetect);
				if (!isset($oreon->AutoDetect)){
					if (isset($_GET["ip"]))
						$oreon = detect($oreon, $_GET["ip"]);
					else if (isset($_POST["ip"]))
						$oreon = detect($oreon, $_POST["ip"]);
				}
			// End Research
			?>
			<td valign="top" align="left">
				<table cellpadding="0" cellspacing="0">		
					<tr>
						<td style="font-size: 12px;" class="tabTableTitle">
						<? echo $lang['ad_res_result']; ?>
						</td>							
					</tr>
					<tr>
						<td class="tabTableForTab">
							<table cellSpacing="1" cellPadding="1" border="0" align="center" style="padding:5px">
								<tr bgColor="#eaecef">
								  <td align="center" class="text11b"><? echo $lang['ad_number']; ?></td>
								  <td align="center" class="text11b"><? echo $lang['ad_ip']; ?></td>
								  <td class="text11b" align="center"><? echo $lang['ad_dns']; ?></td>
								  <td class="text11b" align="center"><? echo $lang['ad_actions']; ?></td>
								</tr>
								<?
									if (isset($oreon->AutoDetect))
										foreach ($oreon->AutoDetect as $value => $key)	{
											print "<tr bgcolor='" . return_color($value) . "'><td height=20 align='center'>$value</td><td>" . $key->ip . "</td><td>&nbsp;" . $key->dns . "</td>";
											print "<td align='center'><a href='phpradmin.php?p=124&o=w&type=h&id=".$key->id."' class='text10'>detail</a>";
											$flg = 0;
											if (isset($oreon->hosts))
												foreach ($oreon->hosts as $h)
													if (!strcmp($h->get_address(), $key->ip))
														$flg = 1;
											if ($flg == 0)
												print " - <a href='phpradmin.php?p=124&o=ah&id=".$key->id."' class='text10'>".$lang['add']."</a></td></tr>";
										} 
									else
										print "<tr><td colspan=4> 0 ".$lang['h']. " ".$lang['ad_found']."</td></tr>";										
								?>
							</table>
						</td>
					</tr>
				</table>	
			</td>
	<? } else if (isset($_GET["o"]) && !strcmp($_GET["o"], "as") && strcmp($_GET["id"], ""))
				include("./include/AutoDetect/add_service.php");
			else if (isset($_GET["o"]) && !strcmp($_GET["o"], "ah") && strcmp($_GET["id"], "")) { 
				if (isset($_POST["htm_id"]) && strcmp($_POST["htm_id"], "NULL"))
					$htm_id = $_POST["htm_id"];
				else
					unset ($_POST["htm_id"]);		
				include("./include/AutoDetect/add_host.php");
			 } else if (isset($_GET["o"]) && isset($_GET["type"]) && !strcmp($_GET["o"], "w") && !strcmp($_GET["type"], "h")) { ?>
			<td align="left" valign="top">
				<table border="0" bordercolor="#213B82" cellpadding="0" cellspacing="0">
					<tr>
						<td class="tabTableTitle"><? echo $lang['ad_title2']; ?></td>
					</tr>
					<tr>
					  <td class="tabTableForTab">
					  	<div align="center" class="text11">
							<? echo $lang['ad_ser_result']; 
								echo "<br><b>";
								if (isset($_GET["id"])){
									if (isset($oreon->AutoDetect[$_GET["id"]]->dns) && strcmp($oreon->AutoDetect[$_GET["id"]]->dns, "")) 
										print $oreon->AutoDetect[$_GET["id"]]->dns;
								} else if (isset($_POST["id"])) {
									if (isset($oreon->AutoDetect[$_POST["id"]]->dns) && strcmp($oreon->AutoDetect[$_POST["id"]]->dns, "")) 
										print $oreon->AutoDetect[$_POST["id"]]->dns;
								} else {
									if (isset($_GET["id"]))
										print $oreon->AutoDetect[$_GET["id"]]->ip; 
									else
										print $oreon->AutoDetect[$_POST["id"]]->ip;
								}
							echo "</b><br><br>".$lang['ad_ser_result2']."<br><br>"; ?>
						</div>
					  </td>
					</tr>		
					<tr>
						<td style="padding-left:10px; padding-top:10px; padding-bottom:10px;"><br>
							<table cellSpacing=1 cellPadding=5 align="center">
									<tr bgColor=#eaecef>
									  <td align="center" class="text11b"><? echo $lang['ad_number']; ?></td>
									  <td align="center" class="text11b"><? echo $lang['ad_port']; ?></td>
									  <td align="center" class="text11b"><? echo $lang['ad_name']; ?></td>
									  <td align="center" class="text11b"><? echo $lang['ad_actions']; ?></td>
									</tr>
									<?	
										if (!isset($oreon->AutoDetect) && isset($_GET["addr_serv"]))
											foreach ($oreon->AutoDetect as $ad )
												if (!strcmp($ad->ip, $_GET["addr_serv"]))
														$id = $ad->id;
										$flg = 0;
										if (isset($_GET["id"]))
											$id = $_GET["id"];
										if (isset($id) && isset($oreon->AutoDetect[$id]->ip))
											if (isset($oreon->hosts))
												foreach ($oreon->hosts as $h)
													if (!strcmp($h->get_address(), $oreon->AutoDetect[$id]->ip))
														$flg = 1;
										if (isset($id) && isset($oreon->AutoDetect[$id])){	
												for ($i = 0 ; $i != count($oreon->AutoDetect[$id]->port_list); $i++)	{
													$adresse_serveur = $oreon->AutoDetect[$id]->ip;
													print "<tr bgcolor='" . return_color($i) . "'><td height=20 align='center'>$i</td><td>" . $oreon->AutoDetect[$id]->port_list[$i] . "</td><td>&nbsp;" . $oreon->AutoDetect[$id]->name_list[$i] . "</td>";
													if ($flg == 1)
														print "<td align='center'><a href='phpradmin.php?p=124&o=as&id=$id&addr_serv=". $adresse_serveur ."&port=" . $oreon->AutoDetect[$id]->port_list[$i] . "&ids=". $i ."' class='text10'>".$lang['add']."</a></td></tr>";
													else
														print "<td align='center' style='text-decoration:line-through;'>".$lang['add']."</td></tr>";
												} 
											}
		
										else
											print "<tr><td colspan=4> 0 ".$lang['h']." ".$lang['ad_found']."</td></tr>";											
									?>
							</table>
						</td>
					</tr>
					<tr>
						<td align="center" style="padding: 20px;"><a href="./phpradmin.php?p=124" class='text11b'><? echo $lang['back']; ?></a></td>
					</tr>
				</table>
			</td>
			<? } ?>
		</tr>
	</table>