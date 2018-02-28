<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/function Create_service($oreon, $path)	{
	$value_flag = array();
	$value_flag[1] = 1;
    $value_flag[3] = 0;
	$str = NULL;
	$handle = create_file( $path ."services.cfg", $oreon->user->get_firstname(), $oreon->user->get_lastname());
	if (isset($oreon->services) && count($oreon->services))	{
		$i = 0;
		foreach ($oreon->services as $sv)	{
			$strTemp = NULL;
			$oreon->services[$sv->get_id()]->generated = false;
			if (($sv->get_host() && $oreon->hosts[$sv->get_host()]->get_activate() && $sv->get_activate()) || !$sv->get_register())	{
				if ($sv->get_description())
					$strTemp .= "# '" . $sv->get_description() . "' service definition " . $i . "\n#\n";
				if ($sv->get_comment()){
					$strTemp .= "#".str_replace("\n", "\n#", preg_replace("/(#BLANK#)/", "", $sv->get_comment()))."\n";
				}
				$strTemp .= "#service_id ".$sv->get_id()." \n";
				$strTemp .= "define service{\n";
				if ($sv->get_service_template())
					$strTemp .= print_line("use", $oreon->services[$sv->get_service_template()]->get_description());
				// Template case
				if (!$sv->get_host())
					$strTemp .= print_line("name", $sv->get_description());
				if ($sv->get_description())
					$strTemp .= print_line("service_description", $sv->get_description());
				if ($sv->get_host())
					$strTemp .= print_line("host_name", $oreon->hosts[$sv->get_host()]->get_name());
				$tmp_sg = NULL;
				foreach ($sv->serviceGroups as $sg)	{
					if ($sg->get_activate())	{
						if ($tmp_sg)
							$tmp_sg .= ", ";
						$tmp_sg .= $sg->get_name();
					}
					unset($sg);
				}
				if ($oreon->user->get_version() == 2 && $strTemp)
					$strTemp .= print_line("servicegroups", $tmp_sg);
				unset($tmp_sg);
				if ($sv->get_is_volatile() && $sv->get_is_volatile() != 2)
					$strTemp .= print_line("is_volatile", $value_flag[$sv->get_is_volatile()]);
				if ($sv->get_service_template())	{
					$cc = NULL;
					$cc_arg = NULL;
					$cc = $sv->get_check_command();
					$cc_arg = $sv->get_check_command_arg();
					if ($cc || $cc_arg)	{
						if (!$cc)
							$cc = $oreon->services[$sv->get_service_template()]->get_check_command();
						if (!$cc_arg)
							$cc_arg = $oreon->services[$sv->get_service_template()]->get_check_command_arg();
						if ($cc)
							$strTemp .= print_line("check_command", $oreon->commands[$cc]->get_name() . preg_replace("/(#BLANK#)/", "", $cc_arg));
					}
				}	else if ($sv->get_check_command())
					$strTemp .= print_line("check_command", $oreon->commands[$sv->get_check_command()]->get_name() . preg_replace("/(#BLANK#)/", "", $sv->get_check_command_arg()));
				if ($sv->get_max_check_attempts())	$strTemp .= print_line("max_check_attempts", $sv->get_max_check_attempts());
				if ($sv->get_normal_check_interval())	$strTemp .= print_line("normal_check_interval", $sv->get_normal_check_interval());
				if ($sv->get_retry_check_interval())	$strTemp .= print_line("retry_check_interval", $sv->get_retry_check_interval());
				if ($sv->get_active_checks_enabled() && $sv->get_active_checks_enabled() != 2)
					$strTemp .= print_line("active_checks_enabled", $value_flag[$sv->get_active_checks_enabled()]);
				if ($sv->get_passive_checks_enabled() && $sv->get_passive_checks_enabled() != 2)
					$strTemp .= print_line("passive_checks_enabled", $value_flag[$sv->get_passive_checks_enabled()]);
				if ($sv->get_check_period())
					$strTemp .= print_line("check_period", $oreon->time_periods[$sv->check_period]->get_name());
				if ($sv->get_parallelize_check() && $sv->get_parallelize_check() != 2)
					$strTemp .= print_line("parallelize_check", $value_flag[$sv->get_parallelize_check()]);
				if ($sv->get_obsess_over_service() && $sv->get_obsess_over_service() != 2)
					$strTemp .= print_line("obsess_over_service", $value_flag[$sv->get_obsess_over_service()]);
				if ($sv->get_check_freshness() && $sv->get_check_freshness() != 2)
					$strTemp .= print_line("check_freshness", $value_flag[$sv->get_check_freshness()]);
				if ($sv->get_freshness_threshold())
					$strTemp .= print_line("freshness_threshold", preg_replace("/(99999)/", "0", $sv->get_freshness_threshold()));
				if ($sv->get_service_template())	{
					$eh = NULL;
					$eh_arg = NULL;
					$eh = $sv->get_event_handler();
					$eh_arg = $sv->get_event_handler_arg();
					if ($eh || $eh_arg)	{
						if (!$eh)
							$eh = $oreon->services[$sv->get_service_template()]->get_event_handler();
						if (!$eh_arg)
							$eh_arg = $oreon->services[$sv->get_service_template()]->get_event_handler_arg();
						if ($eh)
							$strTemp .= print_line("event_handler", $oreon->commands[$eh]->get_name() . preg_replace("/(#BLANK#)/", "", $eh_arg));
					}
				}	else if ($sv->get_event_handler())
					$strTemp .= print_line("event_handler", $oreon->commands[$sv->get_event_handler()]->get_name() . preg_replace("/(#BLANK#)/", "", $sv->get_event_handler_arg()));
				if ($sv->get_event_handler_enabled() && $sv->get_event_handler_enabled() != 2)
					$strTemp .= print_line("event_handler_enabled", $value_flag[$sv->get_event_handler_enabled()]);
				if ($sv->get_low_flap_threshold())
					$strTemp .= print_line("low_flap_threshold", preg_replace("/(99999)/", "0", $sv->get_low_flap_threshold()));
				if ($sv->get_high_flap_threshold())
					$strTemp .= print_line("high_flap_threshold", preg_replace("/(99999)/", "0", $sv->get_high_flap_threshold()));
				if ($sv->get_flap_detection_enabled() && $sv->get_flap_detection_enabled() != 2)
					$strTemp .= print_line("flap_detection_enabled", $value_flag[$sv->get_flap_detection_enabled()]);
				if ($sv->get_process_perf_data() && $sv->get_process_perf_data() != 2)
					$strTemp .= print_line("process_perf_data", $value_flag[$sv->get_process_perf_data()]);
				if ($sv->get_retain_status_information() && $sv->get_retain_status_information() != 2)
					$strTemp .= print_line("retain_status_information", $value_flag[$sv->get_retain_status_information()]);
				if ($sv->get_retain_nonstatus_information() && $sv->get_retain_nonstatus_information() != 2)
					$strTemp .= print_line("retain_nonstatus_information", $value_flag[$sv->get_retain_nonstatus_information()]);
				if ($sv->get_notification_interval())
					$strTemp .= print_line("notification_interval", preg_replace("/(99999)/", "0", $sv->get_notification_interval()));
				if ($sv->get_notification_period())
					$strTemp .= print_line("notification_period", $oreon->time_periods[$sv->notification_period]->get_name());
				if ($sv->get_notification_options())
					$strTemp .= print_line("notification_options", $sv->get_notification_options());
				if ($sv->get_notification_enabled() && $sv->get_notification_enabled() != 2)
					$strTemp .= print_line("notifications_enabled", $value_flag[$sv->get_notification_enabled()]);
				$tmp_cg = NULL;
				foreach ($sv->contactGroups as $cg){
					if ($cg->generated)	{
						if ($tmp_cg) $tmp_cg .= ', ';
						$tmp_cg .= $cg->get_name();
					}
					unset($cg);
				}
				if ($tmp_cg)
					$strTemp .= print_line("contact_groups", $tmp_cg);
				if ($sv->get_stalking_options())
					$strTemp .= print_line("stalking_options", $sv->get_stalking_options());
				if (!$sv->get_register())
					$strTemp .= print_line("register", $sv->get_register());
				$strTemp .= "\t}\n\n";
				$oreon->services[$sv->get_id()]->generated = true;
				unset($tmp_cg);
				$i++;
			}
			unset($sv);
			$str .= $strTemp;
		}
	}
	write_in_file($handle, $str, $path . "services.cfg");
  	fclose($handle);
}

?>