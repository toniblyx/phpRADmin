<?
/*
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)
For information : toni@blyx.com
*/

function Create_resource($oreon, $path)
{
  	$str = NULL;
  	$handle = create_file($path . "resource.cfg", $oreon->user->get_firstname(), $oreon->user->get_lastname());
  	if (isset($oreon->resourcecfg) && count($oreon->resourcecfg))	{
		$resourcecfg = & $oreon->resourcecfg;
		foreach ($resourcecfg as $r){
			if ($r->get_comment()){
				$str .= "#".str_replace("\n", "\n#", $r->get_comment())."\n";
			}
			if ($r->get_line()){$str .= $r->get_line()."\n";}
			unset($r);
		}
	}
  	write_in_file($handle, $str, $path . "resource.cfg");
  	fclose($handle);
}

function Create_nagioscfg( $oreon, $path)
{
	$str = NULL;
  	$handle = create_file($path . "nagios.cfg", $oreon->user->get_firstname(), $oreon->user->get_lastname());
	if (isset($oreon->Nagioscfg))	{
		if ($oreon->Nagioscfg->get_log_file())	$str .= "log_file=".stripslashes($oreon->Nagioscfg->get_log_file()) . "\n\n\n";
		// Config file
		if ($oreon->Nagioscfg->get_cfg_pwd())	{
			$str .= "cfg_file=" . stripslashes($oreon->Nagioscfg->get_cfg_pwd()) . "checkcommands.cfg\n";
			$str .= "cfg_file=" . stripslashes($oreon->Nagioscfg->get_cfg_pwd()) . "misccommands.cfg\n";
			$str .= "cfg_file=" . stripslashes($oreon->Nagioscfg->get_cfg_pwd()) . "contactgroups.cfg\n";
			$str .= "cfg_file=" . stripslashes($oreon->Nagioscfg->get_cfg_pwd()) . "contacts.cfg\n";
			$str .= "cfg_file=" . stripslashes($oreon->Nagioscfg->get_cfg_pwd()) . "dependencies.cfg\n";
			$str .= "cfg_file=" . stripslashes($oreon->Nagioscfg->get_cfg_pwd()) . "escalations.cfg\n";
			$str .= "cfg_file=" . stripslashes($oreon->Nagioscfg->get_cfg_pwd()) . "hostgroups.cfg\n";
			$str .= "cfg_file=" . stripslashes($oreon->Nagioscfg->get_cfg_pwd()) . "hosts.cfg\n";
			$str .= "cfg_file=" . stripslashes($oreon->Nagioscfg->get_cfg_pwd()) . "services.cfg\n";
			$str .= "cfg_file=" . stripslashes($oreon->Nagioscfg->get_cfg_pwd()) . "timeperiods.cfg\n\n";
			$str .= "resource_file=" . stripslashes($oreon->Nagioscfg->get_cfg_pwd()) . "resource.cfg\n\n";
		}
		//v2
		if ($oreon->user->get_version() == 2)
			if ($oreon->Nagioscfg->get_object_cache_file())	$str .= "object_cache_file=" . stripslashes($oreon->Nagioscfg->get_object_cache_file()) . "\n\n";
		if (strcmp($oreon->Nagioscfg->get_aggregate_status_updates(), ""))	$str .= "aggregate_status_updates=" . stripslashes($oreon->Nagioscfg->get_aggregate_status_updates()) . "\n\n";
		if (strcmp($oreon->Nagioscfg->get_status_update_interval(), ""))	$str .= "status_update_interval=" . stripslashes($oreon->Nagioscfg->get_status_update_interval()) . "\n\n";
		if ($oreon->Nagioscfg->get_status_file())	$str .= "status_file=" . stripslashes($oreon->Nagioscfg->get_status_file()) . "\n\n";
		if ($oreon->Nagioscfg->get_nagios_user()) $str .= "nagios_user=" . stripslashes($oreon->Nagioscfg->get_nagios_user()) . "\n";
		if ($oreon->Nagioscfg->get_nagios_group())	$str .= "nagios_group=" . stripslashes($oreon->Nagioscfg->get_nagios_group()) . "\n\n";
		$str .= "check_external_commands=" . stripslashes($oreon->Nagioscfg->get_check_external_commands()) . "\n";
		if (strcmp($oreon->Nagioscfg->get_command_check_interval(), ""))	$str .= "command_check_interval=" . stripslashes($oreon->Nagioscfg->get_command_check_interval()) . "\n\n";
		if ($oreon->Nagioscfg->get_command_file())	$str .= "command_file=" . stripslashes($oreon->Nagioscfg->get_command_file()) . "\n";
		if ($oreon->Nagioscfg->get_comment_file())	$str .= "comment_file=" . stripslashes($oreon->Nagioscfg->get_comment_file()) . "\n";
		if ($oreon->Nagioscfg->get_downtime_file())	$str .= "downtime_file=" . stripslashes($oreon->Nagioscfg->get_downtime_file()) . "\n";
		if ($oreon->Nagioscfg->get_lock_file())	$str .= "lock_file=" . stripslashes($oreon->Nagioscfg->get_lock_file()) . "\n";
		if ($oreon->Nagioscfg->get_temp_file())	$str .= "temp_file=" . stripslashes($oreon->Nagioscfg->get_temp_file()) . "\n\n\n";
		if ($oreon->Nagioscfg->get_log_rotation_method())	$str .= "log_rotation_method=" . stripslashes($oreon->Nagioscfg->get_log_rotation_method()) . "\n";
		if ($oreon->Nagioscfg->get_log_archive_path())	$str .= "log_archive_path=" . stripslashes($oreon->Nagioscfg->get_log_archive_path()) . "\n\n";
		$str .= "use_syslog=" . stripslashes($oreon->Nagioscfg->get_use_syslog()) . "\n";
		$str .= "log_notifications=" . stripslashes($oreon->Nagioscfg->get_log_notifications()) . "\n";
		$str .= "log_service_retries=" . stripslashes($oreon->Nagioscfg->get_log_service_retries()) . "\n";
		$str .= "log_host_retries=" . stripslashes($oreon->Nagioscfg->get_log_host_retries()) . "\n";
		$str .= "log_event_handlers=" . stripslashes($oreon->Nagioscfg->get_log_event_handlers()) . "\n";
		$str .= "log_initial_states=" . stripslashes($oreon->Nagioscfg->get_log_initial_states()) . "\n\n";
		$str .= "log_external_commands=" . stripslashes($oreon->Nagioscfg->get_log_external_commands()) . "\n\n";
		//v2
		if ($oreon->user->get_version() == 2)	{
			$str .= "log_passive_checks=" . stripslashes($oreon->Nagioscfg->get_log_passive_checks()) . "\n\n";
			if (strcmp($oreon->Nagioscfg->get_service_inter_check_delay_method(), ""))	$str .= "service_inter_check_delay_method=" . stripslashes($oreon->Nagioscfg->get_service_inter_check_delay_method()) . "\n\n";
			if (strcmp($oreon->Nagioscfg->get_max_service_check_spread(), ""))	$str .= "max_service_check_spread=" . stripslashes($oreon->Nagioscfg->get_max_service_check_spread()) . "\n\n";
			if (strcmp($oreon->Nagioscfg->get_host_inter_check_delay_method(), ""))	$str .= "host_inter_check_delay_method=" . stripslashes($oreon->Nagioscfg->get_host_inter_check_delay_method()) . "\n\n";
			if (strcmp($oreon->Nagioscfg->get_max_host_check_spread(), ""))	$str .= "max_host_check_spread=" . stripslashes($oreon->Nagioscfg->get_max_host_check_spread()) . "\n\n";
		}
		//log_passive_service_checks and inter_check_delay_method disappear in v2
		if ($oreon->user->get_version() == 1)	{
			$str .= "log_passive_service_checks=" . stripslashes($oreon->Nagioscfg->get_log_passive_service_checks()) . "\n\n";
			if ($oreon->Nagioscfg->get_inter_check_delay_method())	$str .= "inter_check_delay_method=" . stripslashes($oreon->Nagioscfg->get_inter_check_delay_method()) . "\n";
		}
		//Scheduling v2
		if ($oreon->user->get_version() == 2)	{
			if (strcmp($oreon->Nagioscfg->get_auto_reschedule_checks(), '')){$str .= "auto_reschedule_checks=" . stripslashes($oreon->Nagioscfg->get_auto_reschedule_checks()) . "\n";}
			if (strcmp($oreon->Nagioscfg->get_auto_rescheduling_interval(), "")){$str .= "auto_rescheduling_interval=" . stripslashes($oreon->Nagioscfg->get_auto_rescheduling_interval()) . "\n";}
			if (strcmp($oreon->Nagioscfg->get_auto_rescheduling_window(), "")){$str .= "auto_rescheduling_window=" . stripslashes($oreon->Nagioscfg->get_auto_rescheduling_window()) . "\n\n\n";}
		}
		if ($oreon->Nagioscfg->get_service_interleave_factor())	$str .= "service_interleave_factor=" . stripslashes($oreon->Nagioscfg->get_service_interleave_factor()) . "\n\n";
		if (strcmp($oreon->Nagioscfg->get_max_concurrent_checks(), '')){$str .= "max_concurrent_checks=" . stripslashes($oreon->Nagioscfg->get_max_concurrent_checks()) . "\n";}
		if (strcmp($oreon->Nagioscfg->get_service_reaper_frequency(), "")){$str .= "service_reaper_frequency=" . stripslashes($oreon->Nagioscfg->get_service_reaper_frequency()) . "\n";}
		if (strcmp($oreon->Nagioscfg->get_sleep_time(), "")){$str .= "sleep_time=" . stripslashes($oreon->Nagioscfg->get_sleep_time()) . "\n\n\n";}
		// Timeout
		if (strcmp($oreon->Nagioscfg->get_service_check_timeout(), "")){$str .= "service_check_timeout=" . stripslashes($oreon->Nagioscfg->get_service_check_timeout()) . "\n";}
		if (strcmp($oreon->Nagioscfg->get_host_check_timeout(), "")){$str .= "host_check_timeout=" . stripslashes($oreon->Nagioscfg->get_host_check_timeout()) . "\n";}
		if (strcmp($oreon->Nagioscfg->get_event_handler_timeout(), "")){$str .= "event_handler_timeout=" . stripslashes($oreon->Nagioscfg->get_event_handler_timeout()) . "\n";}
		if (strcmp($oreon->Nagioscfg->get_notification_timeout(), "")){$str .= "notification_timeout=" . stripslashes($oreon->Nagioscfg->get_notification_timeout()) . "\n";}
		if (strcmp($oreon->Nagioscfg->get_ocsp_timeout(), "")){$str .= "ocsp_timeout=" . stripslashes($oreon->Nagioscfg->get_ocsp_timeout()) . "\n";}
		if (strcmp($oreon->Nagioscfg->get_perfdata_timeout(), "")){$str .= "perfdata_timeout=" . stripslashes($oreon->Nagioscfg->get_perfdata_timeout()) . "\n\n\n";}

		$str .= "retain_state_information=" . stripslashes($oreon->Nagioscfg->get_retain_state_information()) . "\n";
		if ($oreon->Nagioscfg->get_state_retention_file())	$str .= "state_retention_file=" . stripslashes($oreon->Nagioscfg->get_state_retention_file()) . "\n";
		if (strcmp($oreon->Nagioscfg->get_retention_update_interval(), "")){$str .= "retention_update_interval=" . stripslashes($oreon->Nagioscfg->get_retention_update_interval()) . "\n";}
		$str .= "use_retained_program_state=" . stripslashes($oreon->Nagioscfg->get_use_retained_program_state()) . "\n\n";
		if (strcmp($oreon->Nagioscfg->get_interval_length(), "")){$str .= "interval_length=" . stripslashes($oreon->Nagioscfg->get_interval_length()) . "\n";}
		//v2
		if ($oreon->user->get_version() == 2)
			if (strcmp($oreon->Nagioscfg->get_use_retained_scheduling_info(), ""))	$str .= "use_retained_scheduling_info=" . stripslashes($oreon->Nagioscfg->get_use_retained_scheduling_info()) . "\n\n";

		//Check
		$str .= "use_agressive_host_checking=" . stripslashes($oreon->Nagioscfg->get_use_agressive_host_checking()) . "\n";
		$str .= "execute_service_checks=" . stripslashes($oreon->Nagioscfg->get_execute_service_checks()) . "\n";
		$str .= "accept_passive_service_checks=" . stripslashes($oreon->Nagioscfg->get_accept_passive_service_checks()) . "\n\n";
		$str .= "check_service_freshness=" . stripslashes($oreon->Nagioscfg->get_check_service_freshness()) . "\n";
		//v2
		if ($oreon->user->get_version() == 2)	{
			if (strcmp($oreon->Nagioscfg->get_execute_host_checks(), ""))	$str .= "execute_host_checks=" . stripslashes($oreon->Nagioscfg->get_execute_host_checks()) . "\n\n";
			if (strcmp($oreon->Nagioscfg->get_accept_passive_host_checks(), ""))	$str .= "accept_passive_host_checks=" . stripslashes($oreon->Nagioscfg->get_accept_passive_host_checks()) . "\n\n";
			if (strcmp($oreon->Nagioscfg->get_service_freshness_check_interval(), ""))	$str .= "service_freshness_check_interval=" . stripslashes($oreon->Nagioscfg->get_service_freshness_check_interval()) . "\n\n";
			if (strcmp($oreon->Nagioscfg->get_check_host_freshness(), ""))	$str .= "check_host_freshness=" . stripslashes($oreon->Nagioscfg->get_check_host_freshness()) . "\n\n";
			if (strcmp($oreon->Nagioscfg->get_host_freshness_check_interval(), ""))	$str .= "host_freshness_check_interval=" . stripslashes($oreon->Nagioscfg->get_host_freshness_check_interval()) . "\n\n";
		}
		$str .= "enable_notifications=" . stripslashes($oreon->Nagioscfg->get_enable_notifications()) . "\n";
		$str .= "enable_event_handlers=" . stripslashes($oreon->Nagioscfg->get_enable_event_handlers()) . "\n";
		$str .= "process_performance_data=" . stripslashes($oreon->Nagioscfg->get_process_performance_data()) . "\n";
		//Perfdata v2
		if ($oreon->user->get_version() == 2)	{
			if (strcmp($oreon->Nagioscfg->get_host_perfdata_command(), "")){$str .= "host_perfdata_command=" . stripslashes($oreon->Nagioscfg->get_host_perfdata_command()) . "\n";}
			if (strcmp($oreon->Nagioscfg->get_service_perfdata_command(), "")){$str .= "service_perfdata_command=" . stripslashes($oreon->Nagioscfg->get_service_perfdata_command()) . "\n";}
			if (strcmp($oreon->Nagioscfg->get_host_perfdata_file(), "")){$str .= "host_perfdata_file=" . stripslashes($oreon->Nagioscfg->get_host_perfdata_file()) . "\n";}
			if (strcmp($oreon->Nagioscfg->get_service_perfdata_file(), "")){$str .= "service_perfdata_file=" . stripslashes($oreon->Nagioscfg->get_service_perfdata_file()) . "\n";}
			if (strcmp($oreon->Nagioscfg->get_host_perfdata_file_template(), "")){$str .= "host_perfdata_file_template=" . stripslashes($oreon->Nagioscfg->get_host_perfdata_file_template()) . "\n";}
			if (strcmp($oreon->Nagioscfg->get_service_perfdata_file_template(), "")){$str .= "service_perfdata_file_template=" . stripslashes($oreon->Nagioscfg->get_service_perfdata_file_template()) . "\n";}
			if (strcmp($oreon->Nagioscfg->get_host_perfdata_file_mode(), "")){$str .= "host_perfdata_file_mode=" . stripslashes($oreon->Nagioscfg->get_host_perfdata_file_mode()) . "\n";}
			if (strcmp($oreon->Nagioscfg->get_service_perfdata_file_mode(), "")){$str .= "service_perfdata_file_mode=" . stripslashes($oreon->Nagioscfg->get_service_perfdata_file_mode()) . "\n";}
			if (strcmp($oreon->Nagioscfg->get_host_perfdata_file_processing_interval(), "")){$str .= "host_perfdata_file_processing_interval=" . stripslashes($oreon->Nagioscfg->get_host_perfdata_file_processing_interval()) . "\n";}
			if (strcmp($oreon->Nagioscfg->get_service_perfdata_file_processing_interval(), "")){$str .= "service_perfdata_file_processing_interval=" . stripslashes($oreon->Nagioscfg->get_service_perfdata_file_processing_interval()) . "\n";}
			if (strcmp($oreon->Nagioscfg->get_host_perfdata_file_processing_command(), "")){$str .= "host_perfdata_file_processing_command=" . stripslashes($oreon->Nagioscfg->get_host_perfdata_file_processing_command()) . "\n";}
			if (strcmp($oreon->Nagioscfg->get_service_perfdata_file_processing_command(), "")){$str .= "service_perfdata_file_processing_command=" . stripslashes($oreon->Nagioscfg->get_service_perfdata_file_processing_command()) . "\n";}
		}
		$str .= "\n\n";
		if ($oreon->user->get_version() == 2)	{
			if (strcmp($oreon->Nagioscfg->get_ochp_timeout(), "")){$str .= "ochp_timeout=" . stripslashes($oreon->Nagioscfg->get_ochp_timeout()) . "\n";}
			if (strcmp($oreon->Nagioscfg->get_obsess_over_hosts(), "")){$str .= "obsess_over_hosts=" . stripslashes($oreon->Nagioscfg->get_obsess_over_hosts()) . "\n";}
			if (strcmp($oreon->Nagioscfg->get_ochp_command(), "")){$str .= "ochp_command=" . stripslashes($oreon->Nagioscfg->get_ochp_command()) . "\n";}
		}
		$str .= "obsess_over_services=" . stripslashes($oreon->Nagioscfg->get_obsess_over_services()) . "\n";
		if ($oreon->Nagioscfg->get_ocsp_command())	$str .= "ocsp_command=" . stripslashes($oreon->Nagioscfg->get_ocsp_command()) . "\n";
		$str .= "check_for_orphaned_services=" . stripslashes($oreon->Nagioscfg->get_check_for_orphaned_services()) . "\n";
		$str .= "\n\n";
		if ($oreon->user->get_version() == 1)
			if (strcmp($oreon->Nagioscfg->get_freshness_check_interval(), "")){$str .= "freshness_check_interval=" . stripslashes($oreon->Nagioscfg->get_freshness_check_interval()) . "\n";}
		$str .= "aggregate_status_updates=" . stripslashes($oreon->Nagioscfg->get_aggregate_status_updates()) . "\n";
		if (strcmp($oreon->Nagioscfg->get_status_update_interval(), "")){$str .= "status_update_interval=" . stripslashes($oreon->Nagioscfg->get_status_update_interval()) . "\n";}
		$str .= "enable_flap_detection=" . stripslashes($oreon->Nagioscfg->get_enable_flap_detection()) . "\n";
		$str .= "\n\n";
		if (strcmp($oreon->Nagioscfg->get_low_service_flap_threshold(), "")){$str .= "low_service_flap_threshold=" . stripslashes($oreon->Nagioscfg->get_low_service_flap_threshold()) . "\n";}
		if (strcmp($oreon->Nagioscfg->get_high_service_flap_threshold(), "")){$str .= "high_service_flap_threshold=" . stripslashes($oreon->Nagioscfg->get_high_service_flap_threshold()) . "\n";}
		if (strcmp($oreon->Nagioscfg->get_low_host_flap_threshold(), "")){$str .= "low_host_flap_threshold=" . stripslashes($oreon->Nagioscfg->get_low_host_flap_threshold()) . "\n";}
		if (strcmp($oreon->Nagioscfg->get_high_host_flap_threshold(), "")){$str .= "high_host_flap_threshold=" . stripslashes($oreon->Nagioscfg->get_high_host_flap_threshold()) . "\n";}
		$str .= "\n\n";
		//v2
		if ($oreon->user->get_version() == 2)	{
			if (strcmp($oreon->Nagioscfg->get_use_regexp_matching(), ""))	$str .= "use_regexp_matching=" . stripslashes($oreon->Nagioscfg->get_use_regexp_matching()) . "\n";
			if (strcmp($oreon->Nagioscfg->get_use_true_regexp_matching(), ""))	$str .= "use_true_regexp_matching=" . stripslashes($oreon->Nagioscfg->get_use_true_regexp_matching()) . "\n";
		}
		if ($oreon->Nagioscfg->get_date_format())	$str .= "date_format=" . stripslashes($oreon->Nagioscfg->get_date_format()) . "\n\n";
		if ($oreon->Nagioscfg->get_illegal_object_name_chars())		$str .= "illegal_object_name_chars=" . stripslashes($oreon->Nagioscfg->get_illegal_object_name_chars()) . "\n";
		if ($oreon->Nagioscfg->get_illegal_macro_output_chars())	$str .= "illegal_macro_output_chars=" . stripslashes($oreon->Nagioscfg->get_illegal_macro_output_chars()) . "\n\n";
		if ($oreon->Nagioscfg->get_admin_email())	$str .= "admin_email=" . stripslashes($oreon->Nagioscfg->get_admin_email()) . "\n";
		if ($oreon->Nagioscfg->get_admin_pager())	$str .= "admin_pager=" . stripslashes($oreon->Nagioscfg->get_admin_pager()) . "\n";
	}
	write_in_file($handle, $str, $path . "nagios.cfg");
  	fclose($handle);
}

?>