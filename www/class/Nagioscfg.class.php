<?
/*
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)
For information : toni@blyx.com
*/

class Nagioscfg
{
	var $log_file;
	var $cfg_pwd;
	var $stt_file;
	var $nag_user;
	var $nag_grp;
	var $check_external_commands;
	var $command_check_interval;
	var $command_file;
	var $comment_file;
	var $downtime_file;
	var $lock_file;
	var $temp_file;
	var $log_rotation_method;
	var $log_archive_path;
	var $use_syslog;
	var $log_notifications;
	var $log_service_retries;
	var $log_host_retries;
	var $log_event_handlers;
	var $log_initial_states;
	var $log_external_commands;
	var $service_interleave_factor;
	var $max_concurrent_checks;
	var $service_reaper_frequency;
	var $sleep_time;
	var $service_check_timeout;
	var $host_check_timeout;
	var $event_handler_timeout;
	var $notification_timeout;
	var $ocsp_timeout;
	var $perfdata_timeout;
	var $retain_state_information;
	var $state_retention_file;
	var $retention_update_interval;
	var $use_retained_program_state;
	var $interval_length;
	var $use_agressive_host_checking;
	var $execute_service_checks;
	var $accept_passive_service_checks;
	var $enable_notifications;
	var $enable_event_handlers;
	var $process_performance_data;
	var $obsess_over_services;
	var $ocsp_command;
	var $check_for_orphaned_services;
	var $check_service_freshness;
	var $aggregate_status_updates;
	var $status_update_interval;
	var $enable_flap_detection;
	var $low_service_flap_threshold;
	var $high_service_flap_threshold;
	var $low_host_flap_threshold;
	var $high_host_flap_threshold;
	var $date_format;
	var $illegal_object_name_chars;
	var $illegal_object_name_chars_array;
	var $illegal_macro_output_chars;
	var $admin_email;
	var $admin_pager;
	
	// disappear from v1 to v2
	var $log_passive_service_checks;
	var $inter_check_delay_method;
	var $freshness_check_interval;
	
	// appear in v2
	var $object_cache_file;
	var $execute_host_checks;
	var $accept_passive_host_checks;
	var $use_retained_scheduling_info;
	var $log_passive_checks;
	var $service_inter_check_delay_method;
	var $max_service_check_spread;
	var $host_inter_check_delay_method;
	var $max_host_check_spread;
	var $auto_reschedule_checks;
	var $auto_rescheduling_interval;
	var $auto_rescheduling_window;
	var $ochp_timeout;
	var $obsess_over_hosts;
	var $ochp_command;
	var $host_perfdata_command;
	var $service_perfdata_command;
	var $host_perfdata_file;
	var $service_perfdata_file;
	var $host_perfdata_file_template;
	var $service_perfdata_file_template;
	var $host_perfdata_file_mode;
	var $service_perfdata_file_mode;
	var $host_perfdata_file_processing_interval;
	var $service_perfdata_file_processing_interval;
	var $host_perfdata_file_processing_command;
	var $service_perfdata_file_processing_command;
	var $check_host_freshness;
	var $host_freshness_check_interval;
	var $service_freshness_check_interval;
	var $use_regexp_matching;
	var $use_true_regexp_matching;
	
	function 	Nagioscfg($opt)
	{
		if (isset($opt["log_file"]))
			$this->log_file = $opt["log_file"];
		if (isset($opt["cfg_pwd"]))
		$this->cfg_pwd = $opt["cfg_pwd"];
		if (isset($opt["status_file"]))
		$this->stt_file = $opt["status_file"];
		if (isset($opt["nagios_user"]))
		$this->nag_user = $opt["nagios_user"];
		if (isset($opt["nagios_group"]))
		$this->nag_grp = $opt["nagios_group"];
		if (isset($opt["check_external_commands"]))
		$this->check_external_commands = $opt["check_external_commands"];
		if (isset($opt["command_check_interval"]))
		$this->command_check_interval = $opt["command_check_interval"];
		if (isset($opt["command_file"]))
		$this->command_file = $opt["command_file"];
		if (isset($opt["comment_file"]))
		$this->comment_file = $opt["comment_file"];
		if (isset($opt["downtime_file"]))
		$this->downtime_file = $opt["downtime_file"];
		if (isset($opt["lock_file"]))
		$this->lock_file = $opt["lock_file"];
		if (isset($opt["temp_file"]))
		$this->temp_file = $opt["temp_file"];
		if (isset($opt["log_rotation_method"]))
		$this->log_rotation_method = $opt["log_rotation_method"];
		if (isset($opt["log_archive_path"]))
		$this->log_archive_path = $opt["log_archive_path"];
		if (isset($opt["use_syslog"]))
		$this->use_syslog = $opt["use_syslog"];
		if (isset($opt["log_notifications"]))
		$this->log_notifications = $opt["log_notifications"];
		if (isset($opt["log_service_retries"]))
		$this->log_service_retries = $opt["log_service_retries"];
		if (isset($opt["log_host_retries"]))
		$this->log_host_retries = $opt["log_host_retries"];
		if (isset($opt["log_event_handlers"]))
		$this->log_event_handlers = $opt["log_event_handlers"];
		if (isset($opt["log_initial_states"]))
		$this->log_initial_states = $opt["log_initial_states"];
		if (isset($opt["log_external_commands"]))
		$this->log_external_commands = $opt["log_external_commands"];
		if (isset($opt["service_interleave_factor"]))
		$this->service_interleave_factor = $opt["service_interleave_factor"];
		if (isset($opt["max_concurrent_checks"]))
		$this->max_concurrent_checks = $opt["max_concurrent_checks"];
		if (isset($opt["service_reaper_frequency"]))
		$this->service_reaper_frequency = $opt["service_reaper_frequency"];
		if (isset($opt["sleep_time"]))
		$this->sleep_time = $opt["sleep_time"];
		if (isset($opt["service_check_timeout"]))
		$this->service_check_timeout = $opt["service_check_timeout"];
		if (isset($opt["host_check_timeout"]))
		$this->host_check_timeout = $opt["host_check_timeout"];
		if (isset($opt["event_handler_timeout"]))
		$this->event_handler_timeout = $opt["event_handler_timeout"];
		if (isset($opt["notification_timeout"]))
		$this->notification_timeout = $opt["notification_timeout"];
		if (isset($opt["ocsp_timeout"]))
		$this->ocsp_timeout = $opt["ocsp_timeout"];
		if (isset($opt["perfdata_timeout"]))
		$this->perfdata_timeout = $opt["perfdata_timeout"];
		if (isset($opt["retain_state_information"]))
		$this->retain_state_information = $opt["retain_state_information"];
		if (isset($opt["state_retention_file"]))
		$this->state_retention_file = $opt["state_retention_file"];
		if (isset($opt["retention_update_interval"]))
		$this->retention_update_interval = $opt["retention_update_interval"];
		if (isset($opt["use_retained_program_state"]))
		$this->use_retained_program_state = $opt["use_retained_program_state"];
		if (isset($opt["interval_length"]))
		$this->interval_length = $opt["interval_length"];
		if (isset($opt["use_agressive_host_checking"]))
		$this->use_agressive_host_checking = $opt["use_agressive_host_checking"];
		if (isset($opt["execute_service_checks"]))
		$this->execute_service_checks = $opt["execute_service_checks"];
		if (isset($opt["accept_passive_service_checks"]))
		$this->accept_passive_service_checks = $opt["accept_passive_service_checks"];
		if (isset($opt["enable_notifications"]))
		$this->enable_notifications = $opt["enable_notifications"];
		if (isset($opt["enable_event_handlers"]))
		$this->enable_event_handlers = $opt["enable_event_handlers"];
		if (isset($opt["process_performance_data"]))
		$this->process_performance_data = $opt["process_performance_data"];
		if (isset($opt["obsess_over_services"]))
		$this->obsess_over_services = $opt["obsess_over_services"];
		if (isset($opt["ocsp_command"]))
		$this->ocsp_command = $opt["ocsp_command"];
		if (isset($opt["check_for_orphaned_services"]))
		$this->check_for_orphaned_services = $opt["check_for_orphaned_services"];
		if (isset($opt["check_service_freshness"]))
		$this->check_service_freshness = $opt["check_service_freshness"];
		if (isset($opt["aggregate_status_updates"]))
		$this->aggregate_status_updates = $opt["aggregate_status_updates"];
		if (isset($opt["status_update_interval"]))
		$this->status_update_interval = $opt["status_update_interval"];
		if (isset($opt["enable_flap_detection"]))
		$this->enable_flap_detection = $opt["enable_flap_detection"];
		if (isset($opt["low_service_flap_threshold"]))
		$this->low_service_flap_threshold = $opt["low_service_flap_threshold"];
		if (isset($opt["high_service_flap_threshold"]))
		$this->high_service_flap_threshold = $opt["high_service_flap_threshold"];
		if (isset($opt["low_host_flap_threshold"]))
		$this->low_host_flap_threshold = $opt["low_host_flap_threshold"];
		if (isset($opt["high_host_flap_threshold"]))
		$this->high_host_flap_threshold = $opt["high_host_flap_threshold"];
		if (isset($opt["date_format"]))
		$this->date_format = $opt["date_format"];
		if (isset($opt["illegal_object_name_chars"]))
		$this->illegal_object_name_chars = $opt["illegal_object_name_chars"];
		for ($i = 0; $i < strlen($this->illegal_object_name_chars); $i++)
			$this->illegal_object_name_chars_array[$i] = $this->illegal_object_name_chars[$i];
		$this->illegal_macro_output_chars = $opt["illegal_macro_output_chars"];
		$this->admin_email = $opt["admin_email"];
		$this->admin_pager = $opt["admin_pager"];

		if (isset($opt["log_passive_service_checks"]))
			$this->log_passive_service_checks = $opt["log_passive_service_checks"];
		if (isset($opt["inter_check_delay_method"]))
			$this->inter_check_delay_method = $opt["inter_check_delay_method"];;
		if (isset($opt["freshness_check_interval"]))
			$this->freshness_check_interval = $opt["freshness_check_interval"];
		
		if (isset($opt["object_cache_file"]))
			$this->object_cache_file = $opt["object_cache_file"];
		if (isset($opt["execute_host_checks"]))
			$this->execute_host_checks = $opt["execute_host_checks"];
		if (isset($opt["accept_passive_host_checks"]))
			$this->accept_passive_host_checks = $opt["accept_passive_host_checks"];
		if (isset($opt["use_retained_scheduling_info"]))
			$this->use_retained_scheduling_info = $opt["use_retained_scheduling_info"];
		if (isset($opt["log_passive_checks"]))
			$this->log_passive_checks = $opt["log_passive_checks"];
		if (isset($opt["service_inter_check_delay_method"]))
			$this->service_inter_check_delay_method = $opt["service_inter_check_delay_method"];
		if (isset($opt["max_service_check_spread"]))
			$this->max_service_check_spread = $opt["max_service_check_spread"];
		if (isset($opt["host_inter_check_delay_method"]))
			$this->host_inter_check_delay_method = $opt["host_inter_check_delay_method"];
		if (isset($opt["max_host_check_spread"]))
			$this->max_host_check_spread = $opt["max_host_check_spread"];
		if (isset($opt["auto_reschedule_checks"]))
			$this->auto_reschedule_checks = $opt["auto_reschedule_checks"];
		if (isset($opt["auto_rescheduling_interval"]))
			$this->auto_rescheduling_interval = $opt["auto_rescheduling_interval"];
		if (isset($opt["auto_rescheduling_window"]))
			$this->auto_rescheduling_window = $opt["auto_rescheduling_window"];
		if (isset($opt["ochp_timeout"]))
			$this->ochp_timeout = $opt["ochp_timeout"];
		if (isset($opt["obsess_over_hosts"]))
			$this->obsess_over_hosts = $opt["obsess_over_hosts"];
		if (isset($opt["ochp_command"]))
			$this->ochp_command = $opt["ochp_command"];
		if (isset($opt["host_perfdata_command"]))
			$this->host_perfdata_command = $opt["host_perfdata_command"];
		if (isset($opt["service_perfdata_command"]))
			$this->service_perfdata_command = $opt["service_perfdata_command"];
		if (isset($opt["host_perfdata_file"]))
			$this->host_perfdata_file = $opt["host_perfdata_file"];
		if (isset($opt["service_perfdata_file"]))
			$this->service_perfdata_file = $opt["service_perfdata_file"];
		if (isset($opt["host_perfdata_file_template"]))
			$this->host_perfdata_file_template = $opt["host_perfdata_file_template"];
		if (isset($opt["service_perfdata_file_template"]))
			$this->service_perfdata_file_template = $opt["service_perfdata_file_template"];
		if (isset($opt["host_perfdata_file_mode"]))
			$this->host_perfdata_file_mode = $opt["host_perfdata_file_mode"];
		if (isset($opt["service_perfdata_file_mode"]))
			$this->service_perfdata_file_mode = $opt["service_perfdata_file_mode"];
		if (isset($opt["host_perfdata_file_processing_interval"]))
			$this->host_perfdata_file_processing_interval = $opt["host_perfdata_file_processing_interval"];
		if (isset($opt["service_perfdata_file_processing_interval"]))
			$this->service_perfdata_file_processing_interval = $opt["service_perfdata_file_processing_interval"];
		if (isset($opt["host_perfdata_file_processing_command"]))
			$this->host_perfdata_file_processing_command = $opt["host_perfdata_file_processing_command"];
		if (isset($opt["service_perfdata_file_processing_command"]))
			$this->service_perfdata_file_processing_command = $opt["service_perfdata_file_processing_command"];
		if (isset($opt["check_host_freshness"]))
			$this->check_host_freshness = $opt["check_host_freshness"];
		if (isset($opt["host_freshness_check_interval"]))
			$this->host_freshness_check_interval = $opt["host_freshness_check_interval"];
		if (isset($opt["service_freshness_check_interval"]))
			$this->service_freshness_check_interval = $opt["service_freshness_check_interval"];
		if (isset($opt["use_regexp_matching"]))
			$this->use_regexp_matching = $opt["use_regexp_matching"];
		if (isset($opt["use_true_regexp_matching"]))
			$this->use_true_regexp_matching = $opt["use_true_regexp_matching"];
	}
/*	
	function is_complete($version){
		if (!$this->cfg_pwd)
			return false;
		if (!$this->stt_file)
			return false;
		if (!$this->nag_user)
			return false;
		if (!$this->nag_grp)
			return false;
		if (!$this->command_file)
			return false;
		if (!$this->comment_file)
			return false;
		if (!$this->downtime_file)
			return false;
		if (!$this->lock_file)
			return false;
		if (!$this->temp_file)
			return false;
		if (!$this->log_archive_path)
			return false;
		if (!$this->max_concurrent_checks)
			return false;
		if (!$this->service_reaper_frequency)
			return false;
		if (!$this->sleep_time)
			return false;
		if (!$this->service_check_timeout)
			return false;
		if (!$this->host_check_timeout)
			return false;
		if (!$this->event_handler_timeout)
			return false;
		if (!$this->notification_timeout)
			return false;
		if (!$this->ocsp_timeout)
			return false;
		if (!$this->perfdata_timeout)
			return false;
		if (!$this->state_retention_file)
			return false;
		if (!$this->retention_update_interval)
			return false;
		if (!$this->interval_length)
			return false;
		if (!$this->low_service_flap_threshold)
			return false;
		if (!$this->high_service_flap_threshold)
			return false;
		if (!$this->low_host_flap_threshold)
			return false;
		if (!$this->high_host_flap_threshold)
			return false;
		if (!$this->admin_email)
			return false;
		if (!$this->admin_pager)
			return false;
		else
			return true;				
	}
*/

	function get_log_file(){
		return $this->log_file; }
	function get_cfg_pwd(){
		return $this->cfg_pwd; }
	function get_cfg_file(){
		return $this->cfg_file; }
	function get_status_file(){
		return $this->stt_file; }
	function get_nagios_user(){
		return $this->nag_user; }
	function get_nagios_group(){
		return $this->nag_grp; }
	function get_check_external_commands(){
		return $this->check_external_commands; }
	function get_command_check_interval(){
		return $this->command_check_interval; }
	function get_command_file(){
		return $this->command_file;}
	function get_comment_file(){
		return $this->comment_file; }
	function get_downtime_file(){
		return $this->downtime_file; }
	function get_lock_file(){
		return $this->lock_file; }
	function get_temp_file(){
		return $this->temp_file; }
	function get_log_rotation_method(){
		return $this->log_rotation_method; }
	function get_log_archive_path(){
		return $this->log_archive_path; }
	function get_use_syslog(){
		return $this->use_syslog; }
	function get_log_notifications(){
		return $this->log_notifications; }
	function get_log_service_retries(){
		return $this->log_service_retries; }
	function get_log_host_retries(){
		return $this->log_host_retries; }
	function get_log_event_handlers(){
		return $this->log_event_handlers; }
	function get_log_initial_states(){
		return $this->log_initial_states; }
	function get_log_external_commands(){
		return $this->log_external_commands; }
	function get_log_passive_service_checks(){
		return $this->log_passive_service_checks; }
	function get_inter_check_delay_method(){
		return $this->inter_check_delay_method; }
	function get_service_interleave_factor(){
		return $this->service_interleave_factor; }
	function get_max_concurrent_checks(){
		return $this->max_concurrent_checks; }
	function get_service_reaper_frequency(){
		return $this->service_reaper_frequency; }
	function get_sleep_time(){
		return $this->sleep_time; }
	function get_service_check_timeout(){
		return $this->service_check_timeout; }
	function get_host_check_timeout(){
		return $this->host_check_timeout; }
	function get_event_handler_timeout(){
		return $this->event_handler_timeout; }
	function get_notification_timeout(){
		return $this->notification_timeout; }
	function get_ocsp_timeout(){
		return $this->ocsp_timeout; }
	function get_perfdata_timeout(){
		return $this->perfdata_timeout; }
	function get_retain_state_information(){
		return $this->retain_state_information; }
	function get_state_retention_file(){
		return $this->state_retention_file; }
	function get_retention_update_interval(){
		return $this->retention_update_interval; }
	function get_use_retained_program_state(){
		return $this->use_retained_program_state; }
	function get_interval_length(){
		return $this->interval_length; }
	function get_use_agressive_host_checking(){
		return $this->use_agressive_host_checking; }
	function get_execute_service_checks(){
		return $this->execute_service_checks; }
	function get_accept_passive_service_checks(){
		return $this->accept_passive_service_checks; }
	function get_enable_notifications(){
		return $this->enable_notifications; }
	function get_enable_event_handlers(){
		return $this->enable_event_handlers; }
	function get_process_performance_data(){
		return $this->process_performance_data; }
	function get_obsess_over_services(){
		return $this->obsess_over_services; }
	function get_ocsp_command(){
		return $this->ocsp_command; }
	function get_check_for_orphaned_services(){
		return $this->check_for_orphaned_services; }
	function get_check_service_freshness(){
		return $this->check_service_freshness; }
	function get_freshness_check_interval(){
		return $this->freshness_check_interval; }
	function get_aggregate_status_updates(){
		return $this->aggregate_status_updates; }
	function get_status_update_interval(){
		return $this->status_update_interval; }
	function get_enable_flap_detection(){
		return $this->enable_flap_detection; }
	function get_low_service_flap_threshold(){
		return $this->low_service_flap_threshold; }
	function get_high_service_flap_threshold(){
		return $this->high_service_flap_threshold; }
	function get_low_host_flap_threshold(){
		return $this->low_host_flap_threshold; }
	function get_high_host_flap_threshold(){
		return $this->high_host_flap_threshold; }
	function get_date_format(){
		return $this->date_format; }
	function get_illegal_object_name_chars(){
		return $this->illegal_object_name_chars; }
	function get_illegal_object_name_chars_array(){
		return $this->illegal_object_name_chars_array; }
	function get_illegal_macro_output_chars(){
		return $this->illegal_macro_output_chars; }
	function get_admin_email(){
		return $this->admin_email; }
	function get_admin_pager(){
		return $this->admin_pager; }

	function get_object_cache_file() {
	return $this->object_cache_file;}
	function get_execute_host_checks() {
	return $this->execute_host_checks;}
	function get_accept_passive_host_checks() {
	return $this->accept_passive_host_checks;}
	function get_use_retained_scheduling_info() {
	return $this->use_retained_scheduling_info;}
	function get_log_passive_checks() {
	return $this->log_passive_checks;}
	function get_service_inter_check_delay_method() {
	return $this->service_inter_check_delay_method;}
	function get_max_service_check_spread() {
	return $this->max_service_check_spread;}
	function get_host_inter_check_delay_method() {
	return $this->host_inter_check_delay_method;}
	function get_max_host_check_spread() {
	return $this->max_host_check_spread;}
	function get_auto_reschedule_checks() {
	return $this->auto_reschedule_checks;}
	function get_auto_rescheduling_interval() {
	return $this->auto_rescheduling_interval;}
	function get_auto_rescheduling_window() {
	return $this->auto_rescheduling_window;}
	function get_ochp_timeout() {
	return $this->ochp_timeout;}
	function get_obsess_over_hosts() {
	return $this->obsess_over_hosts;}
	function get_ochp_command() {
	return $this->ochp_command;}
	function get_host_perfdata_command() {
	return $this->host_perfdata_command;}
	function get_service_perfdata_command() {
	return $this->service_perfdata_command;}
	function get_host_perfdata_file() {
	return $this->host_perfdata_file;}
	function get_service_perfdata_file() {
	return $this->service_perfdata_file;}
	function get_host_perfdata_file_template() {
	return $this->host_perfdata_file_template;}
	function get_service_perfdata_file_template() {
	return $this->service_perfdata_file_template;}
	function get_host_perfdata_file_mode() {
	return $this->host_perfdata_file_mode;}
	function get_service_perfdata_file_mode() {
	return $this->service_perfdata_file_mode;}
	function get_host_perfdata_file_processing_interval() {
	return $this->host_perfdata_file_processing_interval;}
	function get_service_perfdata_file_processing_interval() {
	return $this->service_perfdata_file_processing_interval;}
	function get_host_perfdata_file_processing_command() {
	return $this->host_perfdata_file_processing_command;}
	function get_service_perfdata_file_processing_command() {
	return $this->service_perfdata_file_processing_command;}
	function get_check_host_freshness() {
	return $this->check_host_freshness;}
	function get_host_freshness_check_interval() {
	return $this->host_freshness_check_interval;}
	function get_service_freshness_check_interval() {
	return $this->service_freshness_check_interval;}
	function get_use_regexp_matching() {
	return $this->use_regexp_matching;}
	function get_use_true_regexp_matching() {
	return $this->use_true_regexp_matching;}
}
?>