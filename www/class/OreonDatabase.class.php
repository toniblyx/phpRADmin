<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/
include_once "Database.class.php";
include_once "MySqlDatabase.class.php";

class OreonDatabase // Execute request in the database
{

  var $database;

  // Operations

	/**
	 *	check if a user is in the oreon's database
	 *
	 */
	function checkUser($useralias, $password) {
		$password = md5($password);
		$this->database->query("SELECT user_id FROM user WHERE user_alias='$useralias' and user_passwd='$password'");
		if (!($line = $this->database->fetch_array()))
			return false;
		return $line["user_id"];
	}

	function OreonDatabase($host, $user, $password, $db)
	{
		$this->database = new MySqlDatabase ($host, $user, $password, $db);
	}

	// User

	function getUser($user_id)
	{
		if ($user_id == -1) {
			$this->database->query("SELECT * FROM user ORDER BY user_alias");
			$users = array();
			for ($i = 0; ($user = $this->database->fetch_array()); $i++)
				foreach ($user as $key => $value){
					$users[$i][$key] = $value;
				}
			return $users;
		} else {
			$this->database->query("SELECT * FROM user WHERE user_id='$user_id'");
			$res = $this->database->fetch_array();
			return $res;
		}
	}

	function saveUser($user)
	{
		if ($user->get_id() == -1)	{ // INSERT
			$req  = "INSERT INTO `user` ( ";
			$req  .= "`user_id`, `user_firstname`, `user_lastname`, `user_alias`,";
			$req  .= " `user_passwd`, `user_mail`, `user_status`, `user_lang`, `user_version`) ";
			$req  .= "VALUES (";
			$req  .= "'', ";
			$req  .= "'".addslashes($user->get_firstname())."', ";
			$req  .= "'".addslashes($user->get_lastname())."', ";
			$req  .= "'".addslashes($user->get_alias())."', ";
			$req  .= "'".addslashes(md5($user->get_passwd()))."', ";
			$req  .= "'".addslashes($user->email->get_email())."', ";
			$req  .= "'".$user->get_status()."', ";
			$req  .= "'".addslashes($user->get_lang())."', ";
			$req  .= "'".$user->get_version()."')";
			$this->database->query($req);
		}
		else	{
			$req  = "UPDATE user SET ";
			$req .= "user_firstname = '".addslashes($user->get_firstname())."', ";
			$req .= "user_lastname = '".addslashes($user->get_lastname())."', ";
			$req .= "user_alias = '".addslashes($user->get_alias())."', ";
			$req .= "user_mail = '".addslashes($user->email->get_email())."', ";
			$req .= "user_status = '".$user->get_status()."', ";
			$req .= "user_lang = '".addslashes($user->get_lang())."', ";
			$req .= "user_version = '".$user->get_version()."' ";
			$req .= "WHERE user_id = '". $user->get_id() . "'";
			$this->database->query($req);
		}
	}

	function saveUserPasswd($user)
	{
		$req  = "UPDATE user SET ";
		$req .= "user_passwd = '".md5($user->get_passwd())."' ";
		$req .= "WHERE user_id = '". $user->get_id() . "'";
		$this->database->query($req);
	}


	function deleteUsers($user)
	{
		if (isset($user))	{
			$req = "DELETE FROM user WHERE `user_id` = ".$user->get_id()."";
			$this->database->query($req);
		}
	}

	// LCA

	function getLCA($user_id)
	{
		if ($user_id == -1) {
			$this->database->query("SELECT * FROM lca_users ORDER BY user_id");
			$lca = array();
			$lcas = array();
			for ($i = 0; ($lca = $this->database->fetch_array()); $i++)
				foreach ($lca as $key => $value)
					$lcas[$i][$key] = $value;
			return $lcas;
		} else {
			$this->database->query("SELECT * FROM lca_users WHERE user_id='$user_id'");
			$res = $this->database->fetch_array();
			return $res;
		}
	}

	function getHostLCA($user_id)
	{
		//print "SELECT * FROM lca_hosts WHERE user_id='" . $user_id . "'";
		$this->database->query("SELECT * FROM lca_hosts WHERE user_id='" . $user_id . "'");
		$lca = array();
		$lca_host = array();
		for ($i = 0; ($lca = $this->database->fetch_array()); $i++)
			foreach ($lca as $key => $value)
				$lca_host[$i][$key] = $value;
		return $lca_host;
	}

	function saveLCA($restrict)
	{
		if (isset($restrict) && ($restrict->get_id() == -1))	{ // INSERT
			$req = "INSERT INTO `lca_users` (`id`, `user_id`, `comment`, `downtime`, `watch_log`, `traffic_map`,";
			$req.= " `admin_server`) VALUES ('', '".$restrict->get_user_id()."', '".$restrict->get_comment()."', '".$restrict->get_downtime()."', '".$restrict->get_watch_log()."', ";
			$req.= "'".$restrict->get_traffic_map()."', '".$restrict->get_admin_server()."')";
			$this->database->query($req);
		}
		else if (isset($restrict))	{
			$req = "UPDATE `lca_users` SET ";
			$req.= "`user_id` = '".$restrict->get_id()."', ";
			$req.= "`comment` = '".$restrict->get_comment()."', ";
			$req.= "`downtime` = '".$restrict->get_downtime()."', ";
			$req.= "`watch_log` = '".$restrict->get_watch_log()."', ";
			$req.= "`traffic_map` = '".$restrict->get_traffic_map()."', ";
			$req.= "`admin_server` = '".$restrict->get_admin_server()."' ";
			$req.= "WHERE `id` = '".$restrict->get_id()."' LIMIT 1;";
			$this->database->query($req);
		}
	}

	function saveLCA_hosts($lca)
	{
		if (isset($lca))	{ // INSERT
			$req = "INSERT INTO `lca_hosts` (`id`, `host_host_id`, `user_id`, `lca_right`) VALUES ('', ";
			$req.= "'".$lca["host_host_id"]."', '".$lca["user_id"]."', '".$lca["lca_right"]."')";
			$this->database->query($req);
		}
	}

	function deleteLCA($user_id)
	{
		if (isset($user_id))	{
			$req = "DELETE FROM `lca_users` WHERE `user_id` = ".$user_id."";
			$this->database->query($req);
		}
	}

	function deleteLCAHosts($user_id, $host_id)
	{
		if ($user_id != 0 && $host_id != 0){
			$req = "DELETE FROM `lca_hosts` WHERE `user_id` = ".$user_id." AND `host_host_id` = ".$host_id."";
			$this->database->query($req);
		}  else if (isset($user_id) && $host_id == 0){
			$req = "DELETE FROM `lca_hosts` WHERE `user_id` = ".$user_id;
			$this->database->query($req);
		} else if (isset($host_id) && $user_id == 0){
			$req = "DELETE FROM `lca_hosts` WHERE `host_host_id` = ".$host_id;
			$this->database->query($req);
		}
	}

	// Options Generales

	function getoptgen()
	{
		$this->database->query("SELECT * FROM general_opt");
		$Nagioscfg_obj = array();
		$Nagioscfg = $this->database->fetch_array();
		foreach ($Nagioscfg as $key => $value)
			$Nagioscfg_obj[$key] = $value;
		return $Nagioscfg_obj;
	}

	function saveoptgen($opt)
	{
		$req  = "UPDATE general_opt SET ";
		$req .= "radius_pwd = '".addslashes($opt->radius_pwd)."', ";
		$req .= "radius_bin_pwd = '".addslashes($opt->radius_bin_pwd)."', ";
		$req .= "phpradmin_pwd = '".addslashes($opt->phpradmin_pwd)."', ";
		$req .= "refresh = '".addslashes($opt->refresh)."', ";
		$req .= "rrd_pwd = '".addslashes($opt->rrd_pwd)."', ";
		$req .= "dictionary_path = '".addslashes($opt->dictionary_path)."', ";
		$req .= "session_expire = '".addslashes($opt->session_expire)."', ";
		$req .= "startup_script = '".addslashes($opt->startup_script)."', ";
		$req .= "sudo_bin_path = '".addslashes($opt->sudo_bin_path)."', ";
		$req .= "system_log_path = '".addslashes($opt->system_log_path)."', ";
		$req .= "radius_log_path = '".addslashes($opt->radius_log_path)."'";
		$this->database->query($req);
	}
	
	// Dialup Admin Options

	function getdagen()
	{
		$this->database->query("SELECT * FROM dialup_admin_cfg");
		$Nagioscfg_obj = array();
		$Nagioscfg = $this->database->fetch_array();
		foreach ($Nagioscfg as $key => $value)
			$Nagioscfg_obj[$key] = $value;
		return $Nagioscfg_obj;
	}

	function savedagen($da)
	{
		$req  = "UPDATE dialup_admin_cfg SET ";
		$req .= "general_prefered_lang = '".addslashes($da->general_prefered_lang)."', "; 
		$req .= "general_prefered_lang_name = '".addslashes($da->general_prefered_lang_name)."', "; 
		$req .= "general_charset = '".addslashes($da->general_charset)."', "; 
		$req .= "general_base_dir = '".addslashes($da->general_base_dir)."', "; 
		$req .= "general_radiusd_base_dir = '".addslashes($da->general_radiusd_base_dir)."', "; 
		$req .= "general_domain = '".addslashes($da->general_domain)."', "; 
		$req .= "general_use_session = '".addslashes($da->general_use_session)."', "; 
		$req .= "general_most_recent_fl = '".addslashes($da->general_most_recent_fl)."', "; 
		$req .= "general_strip_realms = '".addslashes($da->general_strip_realms)."', "; 
		$req .= "general_realm_delimiter = '".addslashes($da->general_realm_delimiter)."', "; 
		$req .= "general_realm_format = '".addslashes($da->general_realm_format)."', "; 
		$req .= "general_show_user_password = '".addslashes($da->general_show_user_password)."', "; 
		$req .= "general_raddb_dir = '".addslashes($da->general_raddb_dir)."', "; 
		$req .= "general_ldap_attrmap = '".addslashes($da->general_ldap_attrmap)."', "; 
		$req .= "general_clients_conf = '".addslashes($da->general_clients_conf)."', "; 
		$req .= "general_sql_attrmap = '".addslashes($da->general_sql_attrmap)."', "; 
		$req .= "general_accounting_attrs_file = '".addslashes($da->general_accounting_attrs_file)."', "; 
		$req .= "general_extra_ldap_attrmap = '".addslashes($da->general_extra_ldap_attrmap)."', "; 
		$req .= "general_lib_type = '".addslashes($da->general_lib_type)."', "; 
		$req .= "general_user_edit_attrs_file = '".addslashes($da->general_user_edit_attrs_file)."', "; 
		$req .= "general_sql_attrs_file = '".addslashes($da->general_sql_attrs_file)."', "; 
		$req .= "general_default_file = '".addslashes($da->general_default_file)."', "; 
		$req .= "general_finger_type = '".addslashes($da->general_finger_type)."', "; 
		$req .= "general_nas_type = '".addslashes($da->general_nas_type)."', "; 
		$req .= "general_snmpfinger_bin = '".addslashes($da->general_snmpfinger_bin)."', "; 
		$req .= "general_radclient_bin = '".addslashes($da->general_radclient_bin)."', "; 
		$req .= "general_test_account_login = '".addslashes($da->general_test_account_login)."', "; 
		$req .= "general_test_account_password = '".addslashes($da->general_test_account_password)."', "; 
		$req .= "general_radius_server = '".addslashes($da->general_radius_server)."', "; 
		$req .= "general_radius_server_port = '".addslashes($da->general_radius_server_port)."', "; 
		$req .= "general_radius_server_auth_proto = '".addslashes($da->general_radius_server_auth_proto)."', "; 
		$req .= "general_radius_server_secret = '".addslashes($da->general_radius_server_secret)."', "; 
		$req .= "general_auth_request_file = '".addslashes($da->general_auth_request_file)."', "; 
		$req .= "general_encryption_method = '".addslashes($da->general_encryption_method)."', "; 
		$req .= "general_accounting_info_order = '".addslashes($da->general_accounting_info_order)."', "; 
		$req .= "general_stats_use_totacct = '".addslashes($da->general_stats_use_totacct)."', "; 
		$req .= "general_restrict_badusers_access = '".addslashes($da->general_restrict_badusers_access)."', "; 
		$req .= "general_caption_finger_free_lines = '".addslashes($da->general_caption_finger_free_lines)."', "; 
		$req .= "ldap_server = '".addslashes($da->ldap_server)."', "; 
		$req .= "ldap_write_server = '".addslashes($da->ldap_write_server)."', "; 
		$req .= "ldap_base = '".addslashes($da->ldap_base)."', "; 
		$req .= "ldap_binddn = '".addslashes($da->ldap_binddn)."', "; 
		$req .= "ldap_bindpw = '".addslashes($da->ldap_bindpw)."', "; 
		$req .= "ldap_default_new_entry_suffix = '".addslashes($da->ldap_default_new_entry_suffix)."', "; 
		$req .= "ldap_default_dn = '".addslashes($da->ldap_default_dn)."', "; 
		$req .= "ldap_regular_profile_attr = '".addslashes($da->ldap_regular_profile_attr)."', "; 
		$req .= "ldap_use_http_credentials = '".addslashes($da->ldap_use_http_credentials)."', "; 
		$req .= "ldap_directory_manager = '".addslashes($da->ldap_directory_manager)."', "; 
		$req .= "ldap_map_to_directory_manager = '".addslashes($da->ldap_map_to_directory_manager)."', "; 
		$req .= "ldap_debug = '".addslashes($da->ldap_debug)."', "; 
		$req .= "ldap_filter = '".addslashes($da->ldap_filter)."', "; 
		$req .= "ldap_userdn = '".addslashes($da->ldap_userdn)."', "; 
		$req .= "sql_type = '".addslashes($da->sql_type)."', "; 
		$req .= "sql_server = '".addslashes($da->sql_server)."', "; 
		$req .= "sql_port = '".addslashes($da->sql_port)."', "; 
		$req .= "sql_username = '".addslashes($da->sql_username)."', "; 
		$req .= "sql_password = '".addslashes($da->sql_password)."', "; 
		$req .= "sql_database = '".addslashes($da->sql_database)."', "; 
		$req .= "sql_accounting_table = '".addslashes($da->sql_accounting_table)."', "; 
		$req .= "sql_badusers_table = '".addslashes($da->sql_badusers_table)."', "; 
		$req .= "sql_check_table = '".addslashes($da->sql_check_table)."', "; 
		$req .= "sql_reply_table = '".addslashes($da->sql_reply_table)."', "; 
		$req .= "sql_user_info_table = '".addslashes($da->sql_user_info_table)."', "; 
		$req .= "sql_groupcheck_table = '".addslashes($da->sql_groupcheck_table)."', "; 
		$req .= "sql_groupreply_table = '".addslashes($da->sql_groupreply_table)."', "; 
		$req .= "sql_usergroup_table = '".addslashes($da->sql_usergroup_table)."', "; 
		$req .= "sql_total_accounting_table = '".addslashes($da->sql_total_accounting_table)."', "; 
		$req .= "sql_nas_table = '".addslashes($da->sql_nas_table)."', "; 
		$req .= "sql_command = '".addslashes($da->sql_command)."', "; 
		$req .= "general_snmp_type = '".addslashes($da->general_snmp_type)."', "; 
		$req .= "general_snmpwalk_command = '".addslashes($da->general_snmpwalk_command)."', "; 
		$req .= "general_snmpget_command = '".addslashes($da->general_snmpget_command)."', "; 
		$req .= "sql_debug = '".addslashes($da->sql_debug)."', "; 
		$req .= "sql_use_user_info_table = '".addslashes($da->sql_use_user_info_table)."', "; 
		$req .= "sql_use_operators = '".addslashes($da->sql_use_operators)."', "; 
		$req .= "sql_password_attribute = '".addslashes($da->sql_password_attribute)."', "; 
		$req .= "sql_date_format = '".addslashes($da->sql_date_format)."', "; 
		$req .= "sql_full_date_format = '".addslashes($da->sql_full_date_format)."', "; 
		$req .= "sql_row_limit = '".addslashes($da->sql_row_limit)."', "; 
		$req .= "sql_connect_timeout = '".addslashes($da->sql_connect_timeout)."', "; 
		$req .= "sql_extra_servers = '".addslashes($da->sql_extra_servers)."', "; 
		$req .= "counter_default_daily = '".addslashes($da->counter_default_daily)."', "; 
		$req .= "counter_default_weekly = '".addslashes($da->counter_default_weekly)."', "; 
		$req .= "counter_default_monthly = '".addslashes($da->counter_default_monthly)."', "; 
		$req .= "counter_monthly_calculate_usage = '".addslashes($da->counter_monthly_calculate_usage)."' ";
		$this->database->query($req);
	}

	// NagiosCFG

	function getNagioscfg()
	{
		$this->database->query("SELECT * FROM nagioscfg");
		$Nagioscfg_obj = array();
		$Nagioscfg = $this->database->fetch_array();
		foreach ($Nagioscfg as $key => $value)
			$Nagioscfg_obj[$key] = $value;
		return $Nagioscfg_obj;
	}

	function saveNagioscfg($opt)
	{
		$req  = "UPDATE nagioscfg SET ";
		$req .= "cfg_pwd = '".addslashes($opt->cfg_pwd)."',  ";
		$req .= "status_file = '".addslashes($opt->stt_file)."',  ";
		$req .= "object_cache_file = '".addslashes($opt->object_cache_file)."',  ";
		$req .= "nagios_user = '".addslashes($opt->nag_user)."',  ";
		$req .= "nagios_group = '".addslashes($opt->nag_grp)."',  ";
		$req .= "check_external_commands = '".addslashes($opt->check_external_commands)."',  ";
		$req .= "command_check_interval  = '".addslashes($opt->command_check_interval)."',  ";
		$req .= "command_file  = '".addslashes($opt->command_file)."',  ";
		$req .= "comment_file = '".addslashes($opt->comment_file)."',  ";
		$req .= "downtime_file  = '".addslashes($opt->downtime_file)."',  ";
		$req .= "lock_file  = '".addslashes($opt->lock_file)."',  ";
		$req .= "temp_file   = '".addslashes($opt->temp_file)."',  ";
		$req .= "log_rotation_method   = '".addslashes($opt->log_rotation_method)."',  ";
		$req .= "log_archive_path  = '".addslashes($opt->log_archive_path)."',  ";
		$req .= "use_syslog  = '".addslashes($opt->use_syslog)."',  ";
		$req .= "log_notifications  = '".addslashes($opt->log_notifications)."',  ";
		$req .= "log_service_retries   = '".addslashes($opt->log_service_retries)."',  ";
		$req .= "log_host_retries   = '".addslashes($opt->log_host_retries)."',  ";
		$req .= "log_event_handlers  = '".addslashes($opt->log_event_handlers)."',  ";
		$req .= "log_initial_states   = '".addslashes($opt->log_initial_states)."',  ";
		$req .= "log_external_commands  = '".addslashes($opt->log_external_commands)."',  ";
		$req .= "log_passive_service_checks  = '".addslashes($opt->log_passive_service_checks)."',  ";
		$req .= "inter_check_delay_method  = '".addslashes($opt->inter_check_delay_method)."',  ";
		$req .= "service_inter_check_delay_method  = '".addslashes($opt->service_inter_check_delay_method)."',  ";
		$req .= "host_inter_check_delay_method  = '".addslashes($opt->host_inter_check_delay_method)."',  ";
		$req .= "service_interleave_factor  = '".addslashes($opt->service_interleave_factor)."',  ";
		$req .= "max_service_check_spread  = '".addslashes($opt->max_service_check_spread)."',  ";
		$req .= "max_host_check_spread  = '".addslashes($opt->max_host_check_spread)."',  ";
		$req .= "max_concurrent_checks  = '".addslashes($opt->max_concurrent_checks)."',  ";
		$req .= "service_reaper_frequency  = '".addslashes($opt->service_reaper_frequency)."',  ";
		$req .= "sleep_time  = '".addslashes($opt->sleep_time)."',  ";
		$req .= "service_check_timeout   = '".addslashes($opt->service_check_timeout)."',  ";
		$req .= "host_check_timeout   = '".addslashes($opt->host_check_timeout)."',  ";
		$req .= "event_handler_timeout   = '".addslashes($opt->event_handler_timeout)."',  ";
		$req .= "notification_timeout   = '".addslashes($opt->notification_timeout)."',  ";
		$req .= "ocsp_timeout   = '".addslashes($opt->ocsp_timeout)."',  ";
		$req .= "ochp_timeout   = '".addslashes($opt->ochp_timeout)."',  ";
		$req .= "perfdata_timeout    = '".addslashes($opt->perfdata_timeout)."',  ";
		$req .= "retain_state_information  = '".addslashes($opt->retain_state_information)."',  ";
		$req .= "state_retention_file   = '".addslashes($opt->state_retention_file)."',  ";
		$req .= "retention_update_interval   = '".addslashes($opt->retention_update_interval)."',  ";
		$req .= "use_retained_program_state   = '".addslashes($opt->use_retained_program_state)."',  ";
		$req .= "use_retained_scheduling_info   = '".addslashes($opt->use_retained_scheduling_info)."',  ";
		$req .= "interval_length   = '".addslashes($opt->interval_length)."',  ";
		$req .= "use_agressive_host_checking   = '".addslashes($opt->use_agressive_host_checking)."',  ";
		$req .= "execute_service_checks   = '".addslashes($opt->execute_service_checks)."',  ";
		$req .= "accept_passive_service_checks  = '".addslashes($opt->accept_passive_service_checks)."',  ";
		$req .= "log_passive_checks  = '".addslashes($opt->log_passive_checks)."',  ";
		$req .= "execute_host_checks  = '".addslashes($opt->execute_host_checks)."',  ";
		$req .= "accept_passive_host_checks  = '".addslashes($opt->accept_passive_host_checks)."',  ";
		$req .= "enable_notifications   = '".addslashes($opt->enable_notifications)."',  ";
		$req .= "enable_event_handlers   = '".addslashes($opt->enable_event_handlers)."',  ";
		$req .= "process_performance_data   = '".addslashes($opt->process_performance_data)."',  ";
		$req .= "host_perfdata_command   = '".addslashes($opt->host_perfdata_command)."',  ";
		$req .= "service_perfdata_command  = '".addslashes($opt->service_perfdata_command)."',  ";
		$req .= "host_perfdata_file  = '".addslashes($opt->host_perfdata_file)."',  ";
		$req .= "service_perfdata_file  = '".addslashes($opt->service_perfdata_file)."',  ";
		$req .= "host_perfdata_file_template  = '".addslashes($opt->host_perfdata_file_template)."',  ";
		$req .= "service_perfdata_file_template  = '".addslashes($opt->service_perfdata_file_template)."',  ";
		$req .= "host_perfdata_file_mode  = '".addslashes($opt->host_perfdata_file_mode)."',  ";
		$req .= "service_perfdata_file_mode  = '".addslashes($opt->service_perfdata_file_mode)."',  ";
		$req .= "host_perfdata_file_processing_interval  = '".addslashes($opt->host_perfdata_file_processing_interval)."',  ";
		$req .= "service_perfdata_file_processing_interval  = '".addslashes($opt->service_perfdata_file_processing_interval)."',  ";
		$req .= "host_perfdata_file_processing_command  = '".addslashes($opt->host_perfdata_file_processing_command)."',  ";
		$req .= "service_perfdata_file_processing_command  = '".addslashes($opt->service_perfdata_file_processing_command)."',  ";
		$req .= "obsess_over_services  = '".addslashes($opt->obsess_over_services)."',  ";
		$req .= "obsess_over_hosts  = '".addslashes($opt->obsess_over_hosts)."',  ";
		$req .= "ocsp_command  = '".addslashes($opt->ocsp_command)."',  ";
		$req .= "ochp_command  = '".addslashes($opt->ochp_command)."',  ";
		$req .= "check_for_orphaned_services  = '".addslashes($opt->check_for_orphaned_services)."',  ";
		$req .= "check_service_freshness   = '".addslashes($opt->check_service_freshness)."',  ";
		$req .= "check_host_freshness   = '".addslashes($opt->check_host_freshness)."',  ";
		$req .= "service_freshness_check_interval   = '".addslashes($opt->service_freshness_check_interval)."',  ";
		$req .= "host_freshness_check_interval   = '".addslashes($opt->host_freshness_check_interval)."',  ";
		$req .= "freshness_check_interval   = '".addslashes($opt->freshness_check_interval)."',  ";
		$req .= "aggregate_status_updates  = '".addslashes($opt->aggregate_status_updates)."',  ";
		$req .= "status_update_interval   = '".addslashes($opt->status_update_interval)."',  ";
		$req .= "enable_flap_detection   = '".addslashes($opt->enable_flap_detection)."',  ";
		$req .= "low_service_flap_threshold   = '".addslashes($opt->low_service_flap_threshold)."',  ";
		$req .= "high_service_flap_threshold   = '".addslashes($opt->high_service_flap_threshold)."',  ";
		$req .= "low_host_flap_threshold   = '".addslashes($opt->low_host_flap_threshold)."',  ";
		$req .= "high_host_flap_threshold   = '".addslashes($opt->high_host_flap_threshold)."',  ";
		$req .= "date_format   = '".addslashes($opt->date_format)."',  ";
		$req .= "illegal_object_name_chars   = '".addslashes($opt->illegal_object_name_chars)."',  ";
		$req .= "illegal_macro_output_chars   = '".addslashes($opt->illegal_macro_output_chars)."',  ";
		$req .= "use_regexp_matching   = '".addslashes($opt->use_regexp_matching)."',  ";
		$req .= "use_true_regexp_matching   = '".addslashes($opt->use_true_regexp_matching)."',  ";
		$req .= "admin_email   = '".addslashes($opt->admin_email)."',  ";
		$req .= "admin_pager   = '".addslashes($opt->admin_pager)."', ";
		$req .= "log_file   = '".addslashes($opt->log_file)."', ";
		$req .= "auto_reschedule_checks  = '".addslashes($opt->auto_reschedule_checks)."', ";
		$req .= "auto_rescheduling_interval = '".addslashes($opt->auto_rescheduling_interval)."', ";
		$req .= "auto_rescheduling_window = '".addslashes($opt->auto_rescheduling_window)."'";
		$this->database->query($req);
	}

	// ResourcesCFG

	function getResourcecfg()
	{
		$this->database->query("SELECT * FROM resources ORDER BY resource_id");
		$Resourcecfg_array = array();
		for ($i = 0; ($Resourcecfg = $this->database->fetch_array()); $i++)
			foreach ($Resourcecfg as $key => $value)
				$Resourcecfg_array[$i][$key] = $value;
		return $Resourcecfg_array;
	}

	function saveResourcecfg($rscfg)
	{
		$req  = "INSERT INTO resources ";
		$req .= "(resource_id, resource_line, resource_comment) VALUES ";
		$req .= "('".$rscfg->get_id()."', '".addslashes($rscfg->get_line())."', '".addslashes($rscfg->get_comment())."')";
		$this->database->query($req);
	}

	function deleteResourcecfg($rscfg)
	{
		$req  = "DELETE FROM resources ";
		$req .= "WHERE resource_id = '".$rscfg->get_id()."'";
		$this->database->query($req);
	}

	// Host

	function getHost($host_id)
	{
		if ($host_id == -1) {
			$this->database->query("SELECT * FROM host ORDER BY host_name");
			$hosts = array();
			for ($i = 0; ($host = $this->database->fetch_array()); $i++)
				foreach ($host as $key => $value)
					$hosts[$i][$key] = $value;
			return $hosts;
		} else {
			$this->database->query("SELECT * FROM host WHERE host_id='$host_id'");
			$res = $this->database->fetch_array();
			return $res;
		}
	}

	function saveHost($host)
	{
		if (isset($host) && ($host->get_id() == -1))	{ // INSERT
			$req = "INSERT INTO `host` (`host_id`, `host_template_model_htm_id`, `command_command_id`, `timeperiod_tp_id`, `timeperiod_tp_id2`,";
			$req.= " `command_command_id2`, `host_name`, `host_alias`, `host_address`, `host_max_check_attempts`, `host_check_interval`, ";
			$req.= "`host_active_checks_enabled`, `host_passive_checks_enabled`, `host_check_enabled`, `host_obsess_over_host`, `host_check_freshness`, ";
			$req.= "`host_freshness_threshold`, `host_event_handler_enabled`, `host_low_flap_threshold`, `host_high_flap_threshold`, ";
			$req.= "`host_flap_detection_enabled`, `host_process_perf_data`, `host_retain_status_information`, `host_retain_nonstatus_information`, ";
			$req.= "`host_notification_interval`, `host_notification_options`, `host_notifications_enabled`, `host_stalking_options`,`host_comment`, `host_register`, `host_activate`) VALUES ('', ";
			$req.= "'".$host->get_host_template()."', '".$host->get_check_command()."', '".$host->get_check_period()."', '".$host->get_notification_period()."', '".$host->get_event_handler()."', ";
			$req.= "'".addslashes($host->get_name())."', '".addslashes($host->get_alias())."', '".addslashes($host->get_address())."', '".$host->get_max_check_attempts()."', '".$host->get_check_interval()."', ";
			$req.= "'".$host->get_active_checks_enabled()."', '".$host->get_passive_checks_enabled()."', '".$host->get_checks_enabled()."', '".$host->get_obsess_over_host()."', ";
			$req.= "'".$host->get_check_freshness()."', '".$host->get_freshness_threshold()."', '".$host->get_event_handler_enabled()."', '".$host->get_low_flap_threshold()."', ";
			$req.= "'".$host->get_high_flap_threshold()."', '".$host->get_flap_detection_enabled()."', '".$host->get_process_perf_data()."', '".$host->get_retain_status_information()."', ";
			$req.= "'".$host->get_retain_nonstatus_information()."', '".$host->get_notification_interval()."', '".$host->get_notification_options()."', '".$host->get_notifications_enabled();
			$req.= "', '".$host->get_stalking_options()."',  '".addslashes($host->get_comment())."', '". $host->get_register() ."', '".$host->get_activate()."')";
			$this->database->query($req);
		}
		else if (isset($host))	{
			$req = "UPDATE `host` SET ";
			$req.= "`host_template_model_htm_id` = '".$host->get_host_template()."', ";
			$req.= "`command_command_id` = '".$host->get_check_command()."', ";
			$req.= "`timeperiod_tp_id` = '".$host->get_check_period()."', ";
			$req.= "`timeperiod_tp_id2` = '".$host->get_notification_period()."', ";
			$req.= "`command_command_id2` = '".$host->get_event_handler()."', ";
			$req.= "`host_name` = '".addslashes($host->get_name())."', ";
			$req.= "`host_alias` = '".addslashes($host->get_alias())."', ";
			$req.= "`host_address` = '".addslashes($host->get_address())."', ";
			$req.= "`host_max_check_attempts` = '".$host->get_max_check_attempts()."', ";
			$req.= "`host_check_interval` = '".$host->get_check_interval()."', ";
			$req.= "`host_active_checks_enabled` = '".$host->get_active_checks_enabled()."', ";
			$req.= "`host_passive_checks_enabled` = '".$host->get_passive_checks_enabled()."', ";
			$req.= "`host_check_enabled` = '".$host->get_checks_enabled()."', ";
			$req.= "`host_obsess_over_host` = '".$host->get_obsess_over_host()."', ";
			$req.= "`host_check_freshness` = '".$host->get_check_freshness()."', ";
			$req.= "`host_freshness_threshold` = '".$host->get_freshness_threshold()."', ";
			$req.= "`host_event_handler_enabled` = '".$host->get_event_handler_enabled()."', ";
			$req.= "`host_low_flap_threshold` = '".$host->get_low_flap_threshold()."', ";
			$req.= "`host_high_flap_threshold` = '".$host->get_high_flap_threshold()."', ";
			$req.= "`host_flap_detection_enabled` = '".$host->get_flap_detection_enabled()."', ";
			$req.= "`host_process_perf_data` = '".$host->get_process_perf_data()."', ";
			$req.= "`host_retain_status_information` = '".$host->get_retain_status_information()."', ";
			$req.= "`host_retain_nonstatus_information` = '".$host->get_retain_nonstatus_information()."', ";
			$req.= "`host_notification_interval` = '".$host->get_notification_interval()."', ";
			$req.= "`host_notification_options` = '".$host->get_notification_options()."', ";
			$req.= "`host_notifications_enabled` = '".$host->get_notifications_enabled(). "', ";
			$req.= "`host_stalking_options` = '".$host->get_stalking_options(). "', ";
			$req.= "`host_comment` = '".addslashes($host->get_comment()). "', ";
			$req.= "`host_register` = '".$host->get_register(). "', ";
			$req.= "`host_activate` = '".$host->get_activate(). "' ";
			$req.= "WHERE `host_id` = '".$host->get_id()."' LIMIT 1;";
			$this->database->query($req);
		}
	}

	function deleteHost($host)
	{
		if (isset($host))	{
			$req = "DELETE FROM host WHERE `host_id` = ".$host->get_id()."";
			$this->database->query($req);
		}
	}

	// Host Parent relation

	function getHostParentRelation($host)
	{
		if (isset($host))	{
			$req = "SELECT * FROM host_hostparent_relation WHERE host_host_id = ".$host->get_id()."";
			$this->database->query($req);
			$parents = array();
			for ($i = 0; ($parent = $this->database->fetch_array()); $i++)
				foreach ($parent as $key => $value)
					$parents[$i][$key] = $value;
			return $parents;
		}
	}

	function saveHostParentRelation($host)
	{
		if (isset($host))	{
			$req = "DELETE FROM host_hostparent_relation WHERE host_host_id = '". $host->get_id() ."'";
			$this->database->query($req);
			if (isset($host) && isset($host->parents))
				foreach ($host->parents as $parent)	{
					$req = "INSERT INTO host_hostparent_relation (`hhr_id`,`host_parent_hp_id`, `host_host_id`) ";
					$req .= "VALUES ('','" . $parent->get_id() . "','" . $host->get_id() . "')";
					$this->database->query($req);
				}
		}
	}

	function deleteHostParentRelation($host)
	{
		if (isset($host))	{
			$req = "DELETE FROM host_hostparent_relation WHERE host_host_id = '". $host->get_id() ."'";
			$this->database->query($req);
			$req = "DELETE FROM host_hostparent_relation WHERE host_parent_hp_id = '". $host->get_id() ."'";
			$this->database->query($req);
		}
	}

	// Host Escalation

	function getHostEscalation()
	{
		$this->database->query("SELECT * FROM host_escalation ORDER BY host_host_id");
		$ret_he = array();
		for ($i = 0; ($he = $this->database->fetch_array()); $i++)
			foreach ($he as $key => $value)
				$ret_he[$i][$key] = $value;
		return $ret_he;
	}

	function saveHostEscalation($he)
	{
		if (isset($he) && ($he->get_id() == -1))	{
			$req = "INSERT INTO host_escalation (`he_id`,`host_host_id`, `timeperiod_tp_id`, `he_first_notification`, `he_last_notification`, ";
			$req .= "`he_notification_interval`, `he_escalation_options`) ";
			$req .= "VALUES ('','" . $he->get_host() . "','" . $he->get_escalation_period() . "', '". $he->get_first_notification(). "', '". $he->get_last_notification() ."', ";
			$req .= "'" . $he->get_notification_interval() . "', '" . $he->get_escalation_options() . "')";
			$this->database->query($req);
		}
		else if (isset($he))	{
			$req  = "UPDATE host_escalation SET ";
			$req .= "host_host_id = '".$he->get_host()."', ";
			$req .= "timeperiod_tp_id = '".$he->get_escalation_period()."', ";
			$req .= "he_first_notification = '".$he->get_first_notification()."', ";
			$req .= "he_last_notification= '".$he->get_last_notification()."', ";
			$req .= "he_notification_interval = '".$he->get_notification_interval()."', ";
			$req .= "he_escalation_options = '".$he->get_escalation_options()."' ";
			$req .= "WHERE he_id = '".$he->get_id()."'";
			$this->database->query($req);
		}
	}

	function deleteHostEscalation($he)
	{
		if (isset($he))	{
			$req = "DELETE FROM host_escalation WHERE he_id = '". $he->get_id() ."'";
			$this->database->query($req);
		}
	}

	// Host Dependency

	function getHostDependency()
	{
		$this->database->query("SELECT * FROM host_dependency ORDER BY host_host_id");
		$ret_hds = array();
		for ($i = 0; ($hd = $this->database->fetch_array()); $i++)
			foreach ($hd as $key => $value)
				$ret_hds[$i][$key] = $value;
		return $ret_hds;
	}

	function saveHostDependency($hd)
	{
		if (isset($hd) && ($hd->get_id() == -1))	{
			$req = "INSERT INTO host_dependency (`hd_id`,`host_host_id`, `host_host_id2`, `hd_inherits_parent`, ";
			$req .= "`hd_execution_failure_criteria`, `hd_notification_failure_criteria`) ";
			$req .= "VALUES ('','" . $hd->get_host() . "','" . $hd->get_host_dependent() . "', '". $hd->get_inherits_parent(). "', ";
			$req .= "'" . $hd->get_execution_failure_criteria() . "', '" . $hd->get_notification_failure_criteria() . "')";
			$this->database->query($req);
		}
		else if (isset($hd))	{
			$req  = "UPDATE host_dependency SET ";
			$req .= "host_host_id = '".$hd->get_host()."', ";
			$req .= "host_host_id2 = '".$hd->get_host_dependent()."', ";
			$req .= "hd_inherits_parent= '".$hd->get_inherits_parent()."', ";
			$req .= "hd_execution_failure_criteria = '".$hd->get_execution_failure_criteria()."', ";
			$req .= "hd_notification_failure_criteria = '".$hd->get_notification_failure_criteria()."' ";
			$req .= "WHERE hd_id = '".$hd->get_id()."'";
			$this->database->query($req);
		}
	}

	function deleteHostDependency($hd)
	{
		if (isset($hd))	{
			$req = "DELETE FROM host_dependency WHERE hd_id = '". $hd->get_id() ."'";
			$this->database->query($req);
		}
	}


	// HostGroup Host Relation

	function getHostContactGroupRelation($host = -1)
	{
		if (isset($host) && $host != -1)	{
			$req = "SELECT * FROM contactgroup_host_relation WHERE host_host_id = ".$host->get_id()."";
			$this->database->query($req);
			$ret_cgs = array();
			for ($i = 0; ($cg = $this->database->fetch_array()); $i++)
				foreach ($cg as $key => $value)
					$ret_cgs[$i][$key] = $value;
			return $ret_cgs;
		}
	}

	function saveHostContactGroupRelation($host = -1)
	{
		if (isset($host) && ($host != -1))	{
			$req = "DELETE FROM contactgroup_host_relation WHERE host_host_id = '". $host->get_id() ."'";
			$this->database->query($req);
			if (isset($host->contactgroups))
				foreach ($host->contactgroups as $contactgroup)	{
					$req = "INSERT INTO contactgroup_host_relation (`cghr_id`,`host_host_id`, `contactgroup_cg_id`) ";
					$req .= "VALUES ('','" . $host->get_id() . "','" . $contactgroup->get_id() . "')";
					$this->database->query($req);
				}
		}
	}

	function deleteHostContactGroupRelation($host = -1)
	{
		if (isset($host) && ($host != -1))
			$this->database->query("DELETE FROM contactgroup_host_relation WHERE `host_host_id` = ".$host->get_id()."");
	}

	// Contact Group Host Escalation

	function getContactGroupHostEscalation($he)
	{
		if (isset($he))	{
			$req = "SELECT * FROM contactgroup_hostescalation_relation WHERE  host_escalation_he_id = ".$he->get_id()."";
			$this->database->query($req);
			$contactGroups = array();
			for ($i = 0; ($contactGroup = $this->database->fetch_array()); $i++)
				foreach ($contactGroup as $key => $value)
					$contactGroups[$i][$key] = $value;
			return $contactGroups;
		}
	}

	function saveContactGroupHostEscalation($he)
	{
		if (isset($he))	{
			$req = "DELETE FROM contactgroup_hostescalation_relation WHERE host_escalation_he_id = '". $he->get_id() ."'";
			$this->database->query($req);
			foreach ($he->contactGroups as $cg)	{
				$req = "INSERT INTO contactgroup_hostescalation_relation (`cgher_id`,`contactgroup_cg_id`, `host_escalation_he_id`) ";
				$req .= "VALUES ('','" . $cg->get_id() . "','" . $he->get_id() . "')";
				$this->database->query($req);
			}
		}
	}

	function deleteContactGroupHostEscalation($he, $cg)
	{
		if (isset($he) && !isset($cg))	{
			$req = "DELETE FROM contactgroup_hostescalation_relation WHERE host_escalation_he_id = '". $he->get_id() ."'";
			$this->database->query($req);
		}
		else	{
			$req = "DELETE FROM contactgroup_hostescalation_relation WHERE contactgroup_cg_id = '". $cg->get_id() ."' AND host_escalation_he_id='". $he->get_id() ."'";
			$this->database->query($req);
		}
	}

	// Host Group Host Escalation

	function getHostGroupHostEscalation($he)
	{
		if (isset($he))	{
			$req = "SELECT * FROM hostgroup_hostescalation_relation WHERE  host_escalation_he_id = ".$he->get_id()."";
			$this->database->query($req);
			$hosts = array();
			for ($i = 0; ($host = $this->database->fetch_array()); $i++)
				foreach ($host as $key => $value)
					$hosts[$i][$key] = $value;
			return $hosts;
		}
	}

	function saveHostGroupHostEscalation($he)
	{
		if (isset($he))	{
			$req = "DELETE FROM hostgroup_hostescalation_relation WHERE host_escalation_he_id = '". $he->get_id() ."'";
			$this->database->query($req);
			if (isset($he->hostGroups))
				foreach ($he->hostGroups as $hg)	{
					$req = "INSERT INTO hostgroup_hostescalation_relation (`hgher_id`,`hostgroup_hg_id`, `host_escalation_he_id`) ";
					$req .= "VALUES ('','" . $hg->get_id() . "','" . $he->get_id() . "')";
					$this->database->query($req);
				}
		}
	}

	function deleteHostGroupHostEscalation($he, $hg)
	{
		if (isset($he) && !isset($hg))	{
			$req = "DELETE FROM hostgroup_hostescalation_relation WHERE host_escalation_he_id = '". $he->get_id() ."'";
			$this->database->query($req);
		}
		else	{
			$req = "DELETE FROM hostgroup_hostescalation_relation WHERE hostgroup_hg_id = '". $hg->get_id() ."' AND host_escalation_he_id = '". $he->get_id() ."'";
			$this->database->query($req);
		}
	}

	// Host Group Contact Group Escalation

	function getHostGroupCGRelation($hg)
	{
		if (isset($hg))	{
			$req = "SELECT * FROM contactgroup_hostgroup_relation  WHERE  hostgroup_hg_id  = ".$hg->get_id()."";
			$this->database->query($req);
			$hosts = array();
			for ($i = 0; ($host = $this->database->fetch_array()); $i++){
				foreach ($host as $key => $value)
					$hosts[$i][$key] = $value;
			}
			return $hosts;
		}
	}

	function saveHostGroupCGRelation($hg)
	{
		if (isset($hg))	{
			$req = "DELETE FROM contactgroup_hostgroup_relation  WHERE hostgroup_hg_id = '". $hg->get_id() ."'";
			$this->database->query($req);
			if (isset($hg->contact_groups))
				foreach ($hg->contact_groups as $cg)	{
					$req = "INSERT INTO contactgroup_hostgroup_relation  (`cghgr_id`,`hostgroup_hg_id`, `contactgroup_cg_id`) ";
					$req .= "VALUES ('','" . $hg->get_id() . "','" . $cg->get_id() . "')";
					$this->database->query($req);
				}
		}
	}

	function deleteHostGroupCGRelation($hg = -1, $cg = -1)
	{
		if (isset($hg) && ($cg == -1)) {
			$req = "DELETE FROM contactgroup_hostgroup_relation  WHERE hostgroup_hg_id = '". $hg->get_id() ."'";
			$this->database->query($req);
		} else 	if (isset($cg) && ($hg == -1)){
			$req = "DELETE FROM contactgroup_hostgroup_relation  WHERE contactgroup_cg_id = '". $cg->get_id() ."'";
			$this->database->query($req);
		}
	}

	// Extended Host Information

	function getExtendedHostInformation($ehi = -1)
	{
		if ($ehi == -1) {
			$this->database->query("SELECT * FROM extended_host_information ORDER BY ehi_id DESC");
			$ret_ehi = array();
			for ($i = 0; ($ehi = $this->database->fetch_array()); $i++)
				foreach ($ehi as $key => $value)
					$ret_ehi[$i][$key] = $value;
			return $ret_ehi;
		} else {
			$this->database->query("SELECT * FROM extended_host_information WHERE `ehi_id` = '" . $ehi->get_id() . "'");
			$res = $this->database->fetch_array();
			return $res;
		}
	}

	function saveExtendedHostInformation($ehi)
	{
		if (isset($ehi) && ($ehi->get_id() == -1))	{
			$req = "INSERT INTO extended_host_information ( `ehi_id` , `host_host_id` , `ehi_notes`, ";
			$req .= "`ehi_notes_url`, `ehi_action_url`, `ehi_icon_image`, `ehi_icon_image_alt`, `ehi_vrml_image`, ";
			$req .= "`ehi_statusmap_image`, `ehi_2d_coords`, `ehi_3d_coords`)";
			$req .= " VALUES ('', '" . $ehi->get_host() . "', '". addslashes($ehi->get_notes()) ."', '". addslashes($ehi->get_notes_url()) ."',";
			$req .= " '". addslashes($ehi->get_action_url()) ."', '". addslashes($ehi->get_icon_image()) ."', '". addslashes($ehi->get_icon_image_alt()) ."',";
			$req .= " '". addslashes($ehi->get_vrml_image()) ."', '". addslashes($ehi->get_statusmap_image()) ."', '". addslashes($ehi->get_d2_coords()) ."', '". addslashes($ehi->get_d3_coords()) ."')";
			$this->database->query($req);
		}
		else if (isset($ehi))	{
			$req  = "UPDATE extended_host_information SET ";
			$req .= "host_host_id = '". $ehi->get_host() ."', ";
			$req .= "ehi_notes = '". addslashes($ehi->get_notes()) ."', ";
			$req .= "ehi_notes_url = '". addslashes($ehi->get_notes_url()) ."', ";
			$req .= "ehi_action_url = '". addslashes($ehi->get_action_url()) ."', ";
			$req .= "ehi_icon_image = '". addslashes($ehi->get_icon_image()) ."', ";
			$req .= "ehi_icon_image_alt = '". addslashes($ehi->get_icon_image_alt()) ."', ";
			$req .= "ehi_vrml_image = '". addslashes($ehi->get_vrml_image()) ."', ";
			$req .= "ehi_statusmap_image = '". addslashes($ehi->get_statusmap_image()) ."', ";
			$req .= "ehi_2d_coords = '". addslashes($ehi->get_d2_coords()) ."', ";
			$req .= "ehi_3d_coords = '". addslashes($ehi->get_d3_coords()) ."' ";
			$req .= "WHERE ehi_id = '".$ehi->get_id()."'";
			$this->database->query($req);
		}
	}

	function deleteExtendedHostInformation($ehi)
	{
		if (isset($ehi))	{
			$req = "DELETE FROM extended_host_information WHERE `ehi_id` = ".$ehi->get_id()."";
			$this->database->query($req);
		}
	}

	// Host Group

	function getHostGroup($hg_id = -1)
	{
		if ($hg_id == -1) {
		$this->database->query("SELECT * FROM hostgroup ORDER BY hg_name DESC");
		$ret_hg = array();
		for ($i = 0; ($hostgroup = $this->database->fetch_array()); $i++)
			foreach ($hostgroup as $key => $value)
				$ret_hg[$i][$key] = $value;
		return $ret_hg;
		} else {
			$this->database->query("SELECT * FROM hostgroup WHERE `hg_id` = '" . $hg_id . "'");
			$res = $this->database->fetch_array();
			return $res;
		}
	}

	function saveHostGroup($hg)
	{
		if (isset($hg) && ($hg->get_id() == -1))	{
			$req = "INSERT INTO hostgroup ( `hg_id` , `hg_name` , `hg_alias`, `hg_comment`, `hg_activate`)";
			$req .= " VALUES ('', '" . addslashes($hg->get_name()) . "', '" . addslashes($hg->get_alias()) . "', '" . addslashes($hg->get_comment()) . "', '".$hg->get_activate()."')";
			$this->database->query($req);
		}
		else if (isset($hg))	{
			$req  = "UPDATE hostgroup SET ";
			$req .= "hg_name = '".addslashes($hg->get_name())."', ";
			$req .= "hg_alias = '".addslashes($hg->get_alias())."', ";
			$req .= "hg_comment = '".addslashes($hg->get_comment())."', ";
			$req .= "hg_activate = '".$hg->get_activate()."' ";
			$req .= "WHERE hg_id = '".$hg->get_id()."'";
			$this->database->query($req);
		}
	}

	function deleteHostGroup($hg)
	{
		if (isset($hg))	{
			$req = "DELETE FROM hostgroup WHERE `hg_id` = ".$hg->get_id()."";
			$this->database->query($req);
		}
	}

	// HostGroup Host Relation

	function getHostGroupHost($hostgroup, $host = -1)
	{
		if (isset($hostgroup) && $hostgroup != -1)	{
			$req = "SELECT * FROM hostgroup_relation WHERE hostgroup_hg_id = ".$hostgroup->get_id()."";
			$this->database->query($req);
			$ret_hs = array();
			for ($i = 0; ($host = $this->database->fetch_array()); $i++)
				foreach ($host as $key => $value)
					$ret_hs[$i][$key] = $value;
			return $ret_hs;
		}	else	{
				$req = "SELECT * FROM hostgroup_relation WHERE host_host_id = ".$host->get_id()."";
				$this->database->query($req);
				$ret_hgs = array();
				for ($i = 0; ($hostGroup = $this->database->fetch_array()); $i++)
					foreach ($hostGroup as $key => $value)
						$ret_hgs[$i][$key] = $value;
				return $ret_hgs;
		}
	}

	function saveHostGroupHostRelation($hostgroup = -1, $host = -1)
	{
		if (isset($hostgroup) && ($hostgroup != -1))	{
			$req = "DELETE FROM hostgroup_relation WHERE hostgroup_hg_id = '". $hostgroup->get_id() ."'";
			$this->database->query($req);
			if (isset($hostgroup))
				foreach ($hostgroup->hosts as $host)	{
					$req = "INSERT INTO hostgroup_relation (`hgr_id`,`host_host_id`, `hostgroup_hg_id`) ";
					$req .= "VALUES ('','" . $host->get_id() . "','" . $hostgroup->get_id() . "')";
					$this->database->query($req);
				}
		}	else	{
			$req = "DELETE FROM hostgroup_relation WHERE host_host_id = '". $host->get_id() ."'";
			$this->database->query($req);
			if (isset($host->hostGroups))
			foreach ($host->hostGroups as $hostGroup)	{
				$req = "INSERT INTO hostgroup_relation (`hgr_id`,`host_host_id`, `hostgroup_hg_id`) ";
				$req .= "VALUES ('','" . $host->get_id() . "','" . $hostGroup->get_id() . "')";
				$this->database->query($req);
			}
		}
	}

	function deleteHostGroupHostRelation($host = -1, $hostgroup = -1)
	{
		if (isset($hostgroup) && ($hostgroup != -1))	{
			$req = "DELETE FROM hostgroup_relation WHERE `hostgroup_hg_id` = ".$hostgroup->get_id()."";
			$this->database->query($req);
		}
		else if (isset($host) && ($host != -1))	{
			$req = "DELETE FROM hostgroup_relation WHERE `host_host_id` = ".$host->get_id()."";
			$this->database->query($req);
		}
	}


	// Host Group Escalation

	function getHostGroupEscalation()
	{
		$this->database->query("SELECT * FROM hostgroup_escalation");
		$ret_hge = array();
		for ($i = 0; ($hge = $this->database->fetch_array()); $i++)
			foreach ($hge as $key => $value)
				$ret_hge[$i][$key] = $value;
		return $ret_hge;
	}

	function saveHostGroupEscalation($hge)
	{
		if (isset($hge) && ($hge->get_id() == -1))	{
			$req = "INSERT INTO hostgroup_escalation (`hge_id`,`hostgroup_hg_id`, `hge_first_notification`, `hge_last_notification`, `hge_notification_interval`) ";
			$req .= "VALUES ('','" . $hge->get_hostgroup() . "', '". $hge->get_first_notification(). "', '". $hge->get_last_notification() ."', '" . $hge->get_notification_interval() . "')";
			$this->database->query($req);
		}
		else if (isset($hge))	{
			$req  = "UPDATE hostgroup_escalation SET ";
			$req .= "hostgroup_hg_id = '".$hge->get_hostgroup()."', ";
			$req .= "hge_first_notification = '".$hge->get_first_notification()."', ";
			$req .= "hge_last_notification= '".$hge->get_last_notification()."', ";
			$req .= "hge_notification_interval = '".$hge->get_notification_interval()."'";
			$req .= "WHERE hge_id = '".$hge->get_id()."'";
			$this->database->query($req);
		}
	}

	function deleteHostGroupEscalation($hge)
	{
		if (isset($hge))	{
			$req = "DELETE FROM hostgroup_escalation WHERE hge_id = '". $hge->get_id() ."'";
			$this->database->query($req);
		}
	}

	// Contact Group Host Escalation

	function getContactGroupHostGroupEscalation($hge)
	{
		if (isset($hge))	{
			$req = "SELECT * FROM contactgroup_hostgroupescalation_relation WHERE  hostgroup_escalation_hge_id = ".$hge->get_id()."";
			$this->database->query($req);
			$contactGroups = array();
			for ($i = 0; ($contactGroup = $this->database->fetch_array()); $i++)
				foreach ($contactGroup as $key => $value)
					$contactGroups[$i][$key] = $value;
			return $contactGroups;
		}
	}

	function saveContactGroupHostGroupEscalation($hge)
	{
		if (isset($hge))	{
			$req = "DELETE FROM contactgroup_hostgroupescalation_relation WHERE hostgroup_escalation_hge_id = '". $hge->get_id() ."'";
			$this->database->query($req);
			foreach ($hge->contactGroups as $cg)	{
				$req = "INSERT INTO contactgroup_hostgroupescalation_relation (`cghge_id`,`contactgroup_cg_id`, `hostgroup_escalation_hge_id`) ";
				$req .= "VALUES ('','" . $cg->get_id() . "','" . $hge->get_id() . "')";
				$this->database->query($req);
			}
		}
	}

	function deleteContactGroupHostGroupEscalation($hge, $cg)
	{
		if (isset($hge) && !isset($cg))	{
			$req = "DELETE FROM contactgroup_hostgroupescalation_relation WHERE hostgroup_escalation_hge_id = '". $hge->get_id() ."'";
			$this->database->query($req);
		}
		else	{
			$req = "DELETE FROM contactgroup_hostgroupescalation_relation WHERE contactgroup_cg_id = '". $cg->get_id() ."' AND hostgroup_escalation_hge_id='". $hge->get_id() ."'";
			$this->database->query($req);
		}
	}

	// Contact

	function saveContact($cct)
	{
		if ($cct->get_id() == -1)	{ // INSERT
			$req = "INSERT INTO contact ";
			$req .= "(`contact_id` , `timeperiod_tp_id`, `timeperiod_tp_id2`, `contact_name`";
			$req .= " , `contact_alias`, `contact_host_notification_options`, `contact_service_notification_options`, `contact_email`, `contact_comment`, `contact_activate`)";
			$req .= " VALUES ('', '" . $cct->get_host_notification_period() . "', '" . $cct->get_service_notification_period() . "', '" . addslashes($cct->get_name());
			$req .= "', '" . addslashes($cct->get_alias()) . "', '" . $cct->get_host_notification_options() . "', '" . $cct->get_service_notification_options() . "', '".addslashes($cct->email->get_email())."', '".addslashes($cct->get_comment())."', '".addslashes($cct->get_activate())."');";
			$this->database->query($req);
		}
		else	{
			$req  = "UPDATE contact SET ";
			$req .= "`timeperiod_tp_id` = '" . $cct->get_host_notification_period() . "', ";
			$req .= "`timeperiod_tp_id2` = '" . $cct->get_service_notification_period() . "', ";
			$req .= "`contact_name` = '". addslashes($cct->get_name()) . "', ";
			$req .= "`contact_alias` = '" . addslashes($cct->get_alias()) . "', ";
			$req .= "`contact_host_notification_options` = '" . $cct->get_host_notification_options() . "', ";
			$req .= "`contact_service_notification_options` = '" . $cct->get_service_notification_options() . "', ";
			$req .= "`contact_email` = '" . $cct->email->get_email() . "', ";
			$req .= "`contact_pager` = '" . addslashes($cct->get_pager()) . "', ";
			$req .= "`contact_comment` = '" . addslashes($cct->get_comment()) . "', ";
			$req .= "`contact_activate` = '" . addslashes($cct->get_activate()) . "'";
			$req .= " WHERE `contact_id` = '" . $cct->get_id() . "'";
			$this->database->query($req);
		}
	}

	function getContact($ct_id = -1)
	{
		if ($ct_id == -1) {
		$this->database->query("SELECT * FROM contact ORDER BY contact_name");
		$ret_contact = array();
		for ($i = 0; ($contact = $this->database->fetch_array()); $i++)
			foreach ($contact as $key => $value)
				$ret_contact[$i][$key] = $value;
		return $ret_contact;
		} else {
			$this->database->query("SELECT * FROM contact WHERE `contact_id` = '" . $ct_id . "'");
			$res = $this->database->fetch_array();
			return $res;
		}
	}

	function deleteContact($contact)
	{
		if (isset($contact))	{
			$req = "DELETE FROM contact WHERE contact_id = '". $contact->get_id() ."'";
			$this->database->query($req);
		}
	}

	// Service

	function getHostServiceRelation($host = -1, $service = -1)
	{
		if (isset($host) && $host != -1)	{
			$this->database->query("SELECT * FROM host_service_relation WHERE host_host_id = ".$host->get_id()."");
			$ret_services = array();
			for ($i = 0; ($service = $this->database->fetch_array()); $i++)
				foreach ($service as $key => $value)
					$ret_services[$i][$key] = $value;
			return $ret_services;
		}	else	{
			$this->database->query("SELECT * FROM host_service_relation WHERE service_service_id = ".$service->get_id()."");
			$host = $this->database->fetch_array();
			return $host;
			}
	}

	function deleteHostServiceRelation($sv)
	{
		if (isset($sv))	{
			$req = "DELETE FROM host_service_relation WHERE `service_service_id` = ".$sv->get_id()."";
			$this->database->query($req);
		}
	}

	// service hostname

	function getHostnameService($id)
	{
		$this->database->query("SELECT host_host_id FROM host_service_relation WHERE service_service_id = " . $id . " LIMIT 1");
		$ret_sv = $this->database->fetch_array();
		return $ret_sv["host_host_id"];
	}

	/// service

	function getService($sv_id = -1)
	{
		if ($sv_id == -1) {
			$this->database->query("SELECT * FROM service ORDER BY service_description");
			$ret_sv = array();
			for ($i = 0; ($service = $this->database->fetch_array()); $i++){
				foreach ($service as $key => $value)
					$ret_sv[$i][$key] = $value;
			}
			for ($x = 0; $x != $i; $x++)
				$ret_sv[$x]["host_name"] = $this->getHostnameService($ret_sv[$x]["service_id"]);
			return $ret_sv;
		} else {
			$this->database->query("SELECT * FROM service WHERE `service_id` = '" . $sv_id . "'");
			$res = $this->database->fetch_array();
			return $res;
		}
	}

	function saveService($sv)
	{
		if ($sv->get_id() == -1)	{ // INSERT
			$req = "INSERT INTO `service` (`service_id`, `service_template_model_stm_id`, `command_command_id`, `timeperiod_tp_id`, `command_command_id2`, ";
			$req.= "`timeperiod_tp_id2`, `service_description`, `service_is_volatile`, ";
			$req.= "`service_max_check_attempts`, `service_normal_check_interval`, `service_retry_check_interval`, ";
			$req.= "`service_active_checks_enabled`, `service_passive_checks_enabled`, `service_parallelize_check`, ";
			$req.= "`service_obsess_over_service`, `service_check_freshness`, `service_freshness_threshold`, ";
			$req.= "`service_event_handler_enabled`, `service_low_flap_threshold`, `service_high_flap_threshold`, ";
			$req.= "`service_flap_detection_enabled`, `service_process_perf_data`, `service_retain_status_information`, ";
			$req.= "`service_retain_nonstatus_information`, `service_notification_interval`, `service_notification_options`, ";
			$req.= "`service_notification_enabled`, `service_stalking_options`, `service_comment`, `command_command_id_arg`, `command_command_id_arg2`, `service_register`,  `service_activate`) VALUES ('', '". $sv->get_service_template() ."', '";
			$req.= $sv->get_check_command() . "', '" . $sv->get_check_period() . "', '" . $sv->get_event_handler(). "', '";
			$req.= $sv->get_notification_period() . "', '" . addslashes($sv->get_description()) . "', '" . $sv->get_is_volatile() . "', '";
			$req.= $sv->get_max_check_attempts() . "', '" . $sv->get_normal_check_interval() . "', '" . $sv->get_retry_check_interval(). "', '";
			$req.= $sv->get_active_checks_enabled() . "', '" . $sv->get_passive_checks_enabled() . "', '" . $sv->get_parallelize_check() . "', '";
			$req.= $sv->get_obsess_over_service() . "', '" . $sv->get_check_freshness() . "', '" . $sv->get_freshness_threshold() . "', '";
			$req.= $sv->get_event_handler_enabled() . "', '" . $sv->get_low_flap_threshold() . "', '" . $sv->get_high_flap_threshold() . "', '";
			$req.= $sv->get_flap_detection_enabled() . "', '" . $sv->get_process_perf_data() . "', '" . $sv->get_retain_status_information() . "', '";
			$req.= $sv->get_retain_nonstatus_information() . "', '" . $sv->get_notification_interval() . "', '" . $sv->get_notification_options() . "', '";
			$req.= $sv->get_notification_enabled() . "', '" . $sv->get_stalking_options() . "', '".addslashes($sv->get_comment())."', '" . addslashes($sv->get_check_command_arg()) . "', '" . addslashes($sv->get_event_handler_arg()) . "', '". $sv->get_register() ."',  '". $sv->get_activate() ."' )";
			$this->database->query($req);
		}
		else	{
			$req  = "UPDATE service SET ";
			$req .= "`service_template_model_stm_id` = '" . $sv->get_service_template() . "'";
			$req .= ", `command_command_id` = '" . $sv->get_check_command() . "'";
			$req .= ", `timeperiod_tp_id` = '" . $sv->get_check_period() . "'";
			$req .= ", `command_command_id2` = '" . $sv->get_event_handler() . "'";
			$req .= ", `timeperiod_tp_id2` = '" . $sv->get_notification_period() . "'";
			$req .= ", `service_description` = '" . addslashes($sv->get_description()) . "'";
			$req .= ", `service_is_volatile` = '" . $sv->get_is_volatile() . "'";
			$req .= ", `service_max_check_attempts` = '" . $sv->get_max_check_attempts() . "'";
			$req .= ", `service_normal_check_interval` = '" . $sv->get_normal_check_interval() . "'";
			$req .= ", `service_retry_check_interval` = '" .$sv->get_retry_check_interval() . "'";
			$req .= ", `service_active_checks_enabled` = '" . $sv->get_active_checks_enabled() . "'";
			$req .= ", `service_passive_checks_enabled` = '" . $sv->get_passive_checks_enabled() . "'";
			$req .= ", `service_parallelize_check` = '" . $sv->get_parallelize_check() . "'";
			$req .= ", `service_obsess_over_service` = '" . $sv->get_obsess_over_service() . "'";
			$req .= ", `service_check_freshness` = '" . $sv->get_check_freshness() . "'";
			$req .= ", `service_freshness_threshold` = '" . $sv->get_freshness_threshold() . "'";
			$req .= ", `service_event_handler_enabled` = '" . $sv->get_event_handler_enabled() . "'";
			$req .= ", `service_low_flap_threshold` = '" . $sv->get_low_flap_threshold() . "'";
			$req .= ", `service_high_flap_threshold` = '" . $sv->get_high_flap_threshold() . "'";
			$req .= ", `service_flap_detection_enabled` = '" . $sv->get_flap_detection_enabled() . "'";
			$req .= ", `service_process_perf_data` = '" . $sv->get_process_perf_data() . "'";
			$req .= ", `service_retain_status_information` = '" . $sv->get_retain_status_information() . "'";
			$req .= ", `service_retain_nonstatus_information` = '" . $sv->get_retain_nonstatus_information() . "'";
			$req .= ", `service_notification_interval` = '" . $sv->get_notification_interval() . "'";
			$req .= ", `service_notification_options` = '" . $sv->get_notification_options() . "'";
			$req .= ", `service_notification_enabled` = '" . $sv->get_notification_enabled() . "'";
			$req .= ", `service_stalking_options` = '" . $sv->get_stalking_options() . "'";
			$req .= ", `service_comment` = '" . addslashes($sv->get_comment()) . "'";
			$req .= ", `command_command_id_arg` = '" . addslashes($sv->get_check_command_arg()) . "'";
			$req .= ", `command_command_id_arg2` = '" . addslashes($sv->get_event_handler_arg()) . "'";
			$req .= ", `service_register` = '" . $sv->get_register() . "'";
			$req .= ", `service_activate` = '" . $sv->get_activate() . "'";
			$req .= " WHERE `service_id` = '" . $sv->get_id() . "'";
			$this->database->query($req);
		}
	}

	function deleteService($sv)
	{
		if (isset($sv))	{
			$req = "DELETE FROM service WHERE `service_id` = ".$sv->get_id()."";
			$this->database->query($req);
		}
	}

	// Service Host Relation

	function saveServiceHostRelation($host, $service)
	{
		if (isset($host) && isset($service))	{
			$req = "DELETE FROM host_service_relation WHERE service_service_id = '". $service->get_id() ."'";
			$this->database->query($req);
			$req = "INSERT INTO host_service_relation (`hsr_id`,`host_host_id`, `service_service_id`) ";
					$req .= "VALUES ('','" . $host->get_id() . "','" . $service->get_id() . "')";
			$this->database->query($req);
		}
	}

	// Service Escalation

	function getServiceEscalation()
	{
		$this->database->query("SELECT * FROM service_escalation ORDER BY host_host_id");
		$ret_se = array();
		for ($i = 0; ($se = $this->database->fetch_array()); $i++)
			foreach ($se as $key => $value)
				$ret_se[$i][$key] = $value;
		return $ret_se;
	}

	function saveServiceEscalation($se)
	{
		if (isset($se) && ($se->get_id() == -1))	{
			$req = "INSERT INTO service_escalation (`se_id`, `timeperiod_tp_id`, `host_host_id`, `service_service_id`, `se_first_notification`, `se_last_notification`, ";
			$req .= "`se_notification_interval`, `se_escalation_options`) ";
			$req .= "VALUES ('', '" . $se->get_escalation_period() . "', '" . $se->get_host() . "', '" . $se->get_service() . "', '". $se->get_first_notification(). "', '". $se->get_last_notification() ."', ";
			$req .= "'" . $se->get_notification_interval() . "', '" . $se->get_escalation_options() . "')";
			$this->database->query($req);
		}
		else if (isset($se))	{
			$req  = "UPDATE service_escalation SET ";
			$req .= "timeperiod_tp_id = '".$se->get_escalation_period()."', ";
			$req .= "host_host_id = '".$se->get_host()."', ";
			$req .= "service_service_id = '".$se->get_service()."', ";
			$req .= "se_first_notification = '".$se->get_first_notification()."', ";
			$req .= "se_last_notification= '".$se->get_last_notification()."', ";
			$req .= "se_notification_interval = '".$se->get_notification_interval()."', ";
			$req .= "se_escalation_options = '".$se->get_escalation_options()."' ";
			$req .= "WHERE se_id = '".$se->get_id()."'";
			$this->database->query($req);
		}
	}

	function deleteServiceEscalation($se)
	{
		if (isset($se))	{
			$req = "DELETE FROM service_escalation WHERE se_id = '". $se->get_id() ."'";
			$this->database->query($req);
		}
	}

	// Service Dependency

	function getServiceDependency()
	{
		$this->database->query("SELECT * FROM service_dependency ORDER BY host_host_id");
		$ret_sds = array();
		for ($i = 0; ($sd = $this->database->fetch_array()); $i++)
			foreach ($sd as $key => $value)
				$ret_sds[$i][$key] = $value;
		return $ret_sds;
	}

	function saveServiceDependency($sd)
	{
		if (isset($sd) && ($sd->get_id() == -1))	{
			$req = "INSERT INTO service_dependency (`sd_id`,`host_host_id`, `host_host_id2`, `service_service_id`, `service_service_id2`, `sd_inherits_parent`, ";
			$req .= "`sd_execution_failure_criteria`, `sd_notification_failure_criteria`) ";
			$req .= "VALUES ('','" . $sd->get_host() . "','" . $sd->get_host_dependent() . "', '". $sd->get_service() ."', '". $sd->get_service_dependent() ."', '". $sd->get_inherits_parent(). "', ";
			$req .= "'" . $sd->get_execution_failure_criteria() . "', '" . $sd->get_notification_failure_criteria() . "')";
			$this->database->query($req);
		}
		else if (isset($sd))	{
			$req  = "UPDATE service_dependency SET ";
			$req .= "host_host_id = '".$sd->get_host()."', ";
			$req .= "host_host_id2 = '".$sd->get_host_dependent()."', ";
			$req .= "service_service_id = '".$sd->get_service()."', ";
			$req .= "service_service_id2 = '".$sd->get_service_dependent()."', ";
			$req .= "sd_inherits_parent= '".$sd->get_inherits_parent()."', ";
			$req .= "sd_execution_failure_criteria = '".$sd->get_execution_failure_criteria()."', ";
			$req .= "sd_notification_failure_criteria = '".$sd->get_notification_failure_criteria()."' ";
			$req .= "WHERE sd_id = '".$sd->get_id()."'";
			$this->database->query($req);
		}
	}

	function deleteServiceDependency($sd)
	{
		if (isset($sd))	{
			$req = "DELETE FROM service_dependency WHERE sd_id = '". $sd->get_id() ."'";
			$this->database->query($req);
		}
	}

	// Contact Group Service Escalation

	function getContactGroupServiceEscalation($se)
	{
		if (isset($se))	{
			$req = "SELECT * FROM contactgroup_serviceescalation_relation WHERE  service_escalation_se_id = ".$se->get_id()."";
			$this->database->query($req);
			$contactGroups = array();
			for ($i = 0; ($contactGroup = $this->database->fetch_array()); $i++)
				foreach ($contactGroup as $key => $value)
					$contactGroups[$i][$key] = $value;
			return $contactGroups;
		}
	}

	function saveContactGroupServiceEscalation($se)
	{
		if (isset($se))	{
			$req = "DELETE FROM contactgroup_serviceescalation_relation WHERE service_escalation_se_id = '". $se->get_id() ."'";
			$this->database->query($req);
			foreach ($se->contactGroups as $cg)	{
				$req = "INSERT INTO contactgroup_serviceescalation_relation (`cgser_id`,`contactgroup_cg_id`, `service_escalation_se_id`) ";
				$req .= "VALUES ('','" . $cg->get_id() . "','" . $se->get_id() . "')";
				$this->database->query($req);
			}
		}
	}

	function deleteContactGroupServiceEscalation($se, $cg)
	{
		if (isset($se) && !isset($cg))	{
			$req = "DELETE FROM contactgroup_serviceescalation_relation WHERE service_escalation_se_id = '". $se->get_id() ."'";
			$this->database->query($req);
		}
		else	{
			$req = "DELETE FROM contactgroup_serviceescalation_relation WHERE contactgroup_cg_id = '". $cg->get_id() ."' AND service_escalation_se_id='". $se->get_id() ."'";
			$this->database->query($req);
		}
	}

	// Service Group

	function getServiceGroup($sg_id = -1)
	{
		if ($sg_id == -1) {
		$this->database->query("SELECT * FROM servicegroup ORDER BY sg_alias DESC");
		$ret_sg = array();
		for ($i = 0; ($sg = $this->database->fetch_array()); $i++)
			foreach ($sg as $key => $value)
				$ret_sg[$i][$key] = $value;
		return $ret_sg;
		} else {
			$this->database->query("SELECT * FROM servicegroup WHERE sg_id = '$sg_id'");
			$res = $this->database->fetch_array();
			return $res;
		}
	}

	function saveServiceGroup($sg)
	{
		if (isset($sg) && ($sg->get_id() == -1))	{
			$req = "INSERT INTO servicegroup ( `sg_id` , `sg_name` , `sg_alias`, `sg_comment`, `sg_activate` )";
			$req .= " VALUES ('', '".addslashes($sg->get_name())."', '".addslashes($sg->get_alias())."', '".addslashes($sg->get_comment())."', '".$sg->get_activate()."' )";
			$this->database->query($req);
		}
		else if (isset($sg))	{
			$req  = "UPDATE servicegroup SET ";
			$req .= "sg_name = '".addslashes($sg->get_name())."', ";
			$req .= "sg_alias = '".addslashes($sg->get_alias())."', ";
			$req .= "sg_comment = '".addslashes($sg->get_comment())."', ";
			$req .= "sg_activate = '".$sg->get_activate()."' ";
			$req .= "WHERE sg_id = '".$sg->get_id()."'";
			$this->database->query($req);
		}
	}

	function deleteServiceGroup($sg)
	{
		if (isset($sg))	{
			$req = "DELETE FROM servicegroup WHERE `sg_id` = ".$sg->get_id()."";
			$this->database->query($req);
		}
	}

	// ServiceGroup Service Relation

	function getServiceGroupService($serviceGroup, $service = -1)
	{
		if (isset($serviceGroup) && $serviceGroup != -1)	{
			$req = "SELECT * FROM servicegroup_relation WHERE servicegroup_sg_id = ".$serviceGroup->get_id()."";
			$this->database->query($req);
			$ret_ss = array();
			for ($i = 0; ($service = $this->database->fetch_array()); $i++)
				foreach ($service as $key => $value)
					$ret_ss[$i][$key] = $value;
			return $ret_ss;
		}	else if (isset($service) && $service != -1)	{
			$req = "SELECT * FROM servicegroup_relation WHERE service_service_id = ".$service->get_id()."";
			$this->database->query($req);
			$ret_sgs = array();
			for ($i = 0; ($serviceGroup = $this->database->fetch_array()); $i++)
				foreach ($serviceGroup as $key => $value)
					$ret_sgs[$i][$key] = $value;
			return $ret_sgs;
		}
	}

	function saveServiceGroupServiceRelation($serviceGroup, $service = -1)
	{
		if (isset($serviceGroup) && $serviceGroup != -1)	{
			$req = "DELETE FROM servicegroup_relation WHERE servicegroup_sg_id = '". $serviceGroup->get_id() ."'";
			$this->database->query($req);
			foreach ($serviceGroup->services as $service)	{
				$req = "INSERT INTO servicegroup_relation (`sgr_id`,`service_service_id`, `servicegroup_sg_id`) ";
				$req .= "VALUES ('','" . $service->get_id() . "','" . $serviceGroup->get_id() . "')";
				$this->database->query($req);
			}
		}	else	{
			$req = "DELETE FROM servicegroup_relation WHERE service_service_id = '". $service->get_id() ."'";
			$this->database->query($req);
			if (isset($service->serviceGroups))
			foreach ($service->serviceGroups as $serviceGroup)	{
				$req = "INSERT INTO servicegroup_relation (`sgr_id`,`service_service_id`, `servicegroup_sg_id`) ";
				$req .= "VALUES ('','" . $service->get_id() . "','" . $serviceGroup->get_id() . "')";
				$this->database->query($req);
			}
		}
	}

	function deleteServiceGroupServiceRelation($service = -1, $servicegroup = -1)
	{
		if (isset($servicegroup) && ($servicegroup != -1))	{
			$req = "DELETE FROM servicegroup_relation WHERE `servicegroup_sg_id` = ".$servicegroup->get_id()."";
			$this->database->query($req);
		}
		else if (isset($service) && ($service != -1))	{
			$req = "DELETE FROM servicegroup_relation WHERE `service_service_id` = ".$service->get_id()."";
			$this->database->query($req);
		}
	}

	//Service ContactGroup Relation

	function saveServiceContactGroups($service)
	{
		if (isset($service))	{
			$req = "DELETE FROM contactgroup_service_relation WHERE service_service_id = '". $service->get_id() ."'";
			$this->database->query($req);
			if (isset($service->contactGroups))
				foreach ($service->contactGroups as $contactGroup)	{
					$req = "INSERT INTO contactgroup_service_relation (`cgsr_id`,`contactgroup_cg_id`, `service_service_id`) ";
					$req .= "VALUES ('','" . $contactGroup->get_id() . "','" . $service->get_id() . "')";
					$this->database->query($req);
				}
		}
	}

	function getServiceContactGroup($service)
	{
		if (isset($service))	{
			$req = "SELECT * FROM contactgroup_service_relation WHERE service_service_id = ".$service->get_id()."";
			$this->database->query($req);
			$contactgroups = array();
			for ($i = 0; ($contactgroup = $this->database->fetch_array()); $i++)
				foreach ($contactgroup as $key => $value)
					$contactgroups[$i][$key] = $value;
			return $contactgroups;
		}
	}

	function deleteCGServiceRelation($sv, $cg = -1)
	{
		if (isset($sv) && ($cg == -1))	{
			$req = "DELETE FROM contactgroup_service_relation WHERE `service_service_id` = ".$sv->get_id()."";
			$this->database->query($req);
		}
		else if (isset($cg) && ($cg != -1))
			$req = "DELETE FROM contactgroup_service_relation WHERE `contactgroup_cg_id` = ".$cg->get_id()."";
			$this->database->query($req);
	}

	// Extended Service Information

	function getExtendedServiceInformation($esi = -1)
	{
		if ($esi == -1) {
		$this->database->query("SELECT * FROM extended_service_information ORDER BY esi_id DESC");
		$ret_esi = array();
		for ($i = 0; ($esi = $this->database->fetch_array()); $i++)
			foreach ($esi as $key => $value)
				$ret_esi[$i][$key] = $value;
		return $ret_esi;
		} else {
			$this->database->query("SELECT * FROM extended_service_information WHERE `esi_id` = '" . $esi->get_id() . "'");
			$res = $this->database->fetch_array();
			return $res;
		}
	}

	function saveExtendedServiceInformation($esi)
	{
		if ($esi->get_id() == -1)	{
			$req = "INSERT INTO extended_service_information ( `esi_id` , `host_host_id` , `service_service_id`, `esi_notes`, ";
			$req .= "`esi_notes_url`, `esi_action_url`, `esi_icon_image`, `esi_icon_image_alt`)";
			$req .= " VALUES ('', '" . $esi->get_host() . "', '" . $esi->get_service() . "', '". addslashes($esi->get_notes()) ."', '". addslashes($esi->get_notes_url()) ."',";
			$req .= " '". addslashes($esi->get_action_url()) ."', '". addslashes($esi->get_icon_image()) ."', '". addslashes($esi->get_icon_image_alt()) ."')";
			$this->database->query($req);
		}
		else	{
			$req  = "UPDATE extended_service_information SET ";
			$req .= "host_host_id = '". $esi->get_host() ."', ";
			$req .= "service_service_id = '". $esi->get_service() ."', ";
			$req .= "esi_notes = '". addslashes($esi->get_notes()) ."', ";
			$req .= "esi_notes_url = '". addslashes($esi->get_notes_url()) ."', ";
			$req .= "esi_action_url = '". addslashes($esi->get_action_url()) ."', ";
			$req .= "esi_icon_image = '". addslashes($esi->get_icon_image()) ."', ";
			$req .= "esi_icon_image_alt = '". addslashes($esi->get_icon_image_alt()) ."' ";
			$req .= "WHERE esi_id = '".$esi->get_id()."'";
			$this->database->query($req);
		}
	}

	function deleteExtendedServiceInformation($esi)
	{
		if (isset($esi))	{
			$req = "DELETE FROM extended_service_information WHERE `esi_id` = ".$esi->get_id()."";
			$this->database->query($req);
		}
	}

	function deleteServiceExtendedServiceInformation($sv)
	{
		if (isset($sv))	{
			$req = "DELETE FROM extended_service_information WHERE `service_service_id` = ".$sv->get_id()."";
			$this->database->query($req);
		}
	}

	// Contact Group

	function getContactGroup($cg_id = -1)
	{
		if ($cg_id == -1) {
		$this->database->query("SELECT * FROM contactgroup ORDER BY cg_alias DESC");
		$ret_cg = array();
		for ($i = 0; ($cg = $this->database->fetch_array()); $i++)
			foreach ($cg as $key => $value)
				$ret_cg[$i][$key] = $value;
		return $ret_cg;
		} else {
			$this->database->query("SELECT * FROM contactgroup WHERE cg_id = '$cg_id'");
			$res = $this->database->fetch_array();
			return $res;
		}
	}

	function saveContactGroup($cg)
	{
		if ($cg->get_id() == -1)	{
			$req = "INSERT INTO contactgroup ( `cg_id` , `cg_name` , `cg_alias`, `cg_comment`, `cg_activate`)";
			$req .= " VALUES ('', '".addslashes($cg->get_name())."', '" .addslashes($cg->get_alias())."', '".addslashes($cg->get_comment())."', '".addslashes($cg->get_activate())."')";
			$this->database->query($req);
		}
		else	{
			$req  = "UPDATE contactgroup SET ";
			$req .= "cg_name = '".addslashes($cg->get_name())."', ";
			$req .= "cg_alias = '".addslashes($cg->get_alias())."', ";
			$req .= "cg_comment = '".addslashes($cg->get_comment())."', ";
			$req .= "cg_activate = '".addslashes($cg->get_activate())."' ";
			$req .= "WHERE cg_id = '".$cg->get_id()."'";
			$this->database->query($req);
		}
	}

	function deleteContactGroup($contactgroup)
	{
		if (isset($contactgroup))	{
			$req = "DELETE FROM contactgroup WHERE `cg_id` = ".$contactgroup->get_id()."";
			$this->database->query($req);
		}
	}

	// ContactGroup Contact Relation

	function getContactGroupContact($contactgroup, $contact = -1)
	{
		if (isset($contactgroup) && ($contact == -1))	{
			$req = "SELECT * FROM contactgroup_contact_relation WHERE contactgroup_cg_id = ".$contactgroup->get_id()."";
			$this->database->query($req);
			$ret_cgc = array();
			for ($i = 0; ($contact = $this->database->fetch_array()); $i++)
				foreach ($contact as $key => $value)
					$ret_cgc[$i][$key] = $value;
			return $ret_cgc;
		}
		else if ($contact == -1)	{
			$req = "SELECT * FROM contactgroup_contact_relation WHERE contact_contact_id = ".$contact->get_id()."";
			$this->database->query($req);
			$ret_cgc = array();
			for ($i = 0; ($contact = $this->database->fetch_array()); $i++)
				foreach ($contact as $key => $value)
					$ret_cgc[$i][$key] = $value;
			return $ret_cgc;
		}
	}

	function saveContactGroupContactRelation($contactgroup, $contact = -1)
	{
		if (isset($contactgroup) && ($contact == -1))	{
			$req = "DELETE FROM contactgroup_contact_relation WHERE contactgroup_cg_id = '". $contactgroup->get_id() ."'";
			$this->database->query($req);
			if (isset($contactgroup))
				foreach ($contactgroup->contacts as $contact)	{
					$req = "INSERT INTO contactgroup_contact_relation (`cgr_id`,`contact_contact_id`, `contactgroup_cg_id`) ";
					$req .= "VALUES ('','" . $contact->get_id() . "','" . $contactgroup->get_id() . "')";
					$this->database->query($req);
				}
		}
		else if (isset($contact) && ($contact != -1))	{
			$req = "DELETE FROM contactgroup_contact_relation WHERE contact_contact_id = '". $contact->get_id() ."'";
			$this->database->query($req);
			if (isset($contact->contact_groups))
				foreach ($contact->contact_groups as $cg)	{
					$req = "INSERT INTO contactgroup_contact_relation (`cgr_id`,`contact_contact_id`, `contactgroup_cg_id`) ";
					$req .= "VALUES ('','" . $contact->get_id() . "','" . $cg->get_id() . "')";
					$this->database->query($req);
				}
		}
	}

	function deleteContactGroupContactRelation($contact = -1, $contactgroup = -1)
	{
		if (isset($contactgroup) && ($contactgroup != -1))	{
			$req = "DELETE FROM contactgroup_contact_relation WHERE `contactgroup_cg_id` = ".$contactgroup->get_id()."";
			$this->database->query($req);
		}
		else if (isset($contact) && ($contact != -1))	{
			$req = "DELETE FROM contactgroup_contact_relation WHERE `contact_contact_id` = ".$contact->get_id()."";
			$this->database->query($req);
		}
	}

	// Command

	function getCommand($command_id = -1)
	{
		if ($command_id == -1) {
		$this->database->query("SELECT * FROM command ORDER BY command_name");
		$ret_cmd = array();
		for ($i = 0; ($cmd = $this->database->fetch_array()); $i++)
			foreach ($cmd as $key => $value)
				$ret_cmd[$i][$key] = $value;
		return $ret_cmd;
		} else {
			$this->database->query("SELECT * FROM command WHERE command_id = '$command_id'");
			$res = $this->database->fetch_array();
			return $res;
		}
	}

	function saveCommand($command)
	{
		if ($command->get_id() == -1)	{
			$req = "INSERT INTO command ( `command_name`, `command_line`, `command_type` )";
			$req .= " VALUES ('".addslashes($command->get_name()). "', '" .addslashes($command->get_line()). "', '".$command->get_type(). "' )";
			$this->database->query($req);
		}
		else	{
			$req  = "UPDATE command SET ";
			$req .= "command_name = '".addslashes($command->get_name())."', ";
			$req .= "command_line = '".addslashes($command->get_line())."', ";
			$req .= "command_type = '".$command->get_type()."' ";
			$req .= "WHERE command_id = '".$command->get_id()."';";
			$this->database->query($req);
		}
	}

	function deleteCommand($command)
	{
		if (isset($command))	{
			$req = "DELETE FROM command WHERE `command_id` = ".$command->get_id()."";
			$this->database->query($req);
		}
	}

	// Timeperiod

	function getTimePeriod($tp_id = -1)
	{
		if ($tp_id == -1) {
			$this->database->query("SELECT * FROM timeperiod ORDER BY tp_alias");
			$ret_tp = array();
			for ($i = 0; ($tp = $this->database->fetch_array()); $i++)
				foreach ($tp as $key => $value)
					$ret_tp[$i][$key] = $value;
			return $ret_tp;
		} else {
			$this->database->query("SELECT * FROM timeperiod WHERE tp_id = '$tp_id'");
			$res = $this->database->fetch_array();
			return $res;
		}
	}

	function saveTimePeriod($tp)
	{
		if ($tp->get_id() == -1)	{ // INSERT
			$req = "INSERT INTO timeperiod ( tp_name , tp_alias, tp_sunday, tp_monday, tp_tuesday, tp_wednesday, tp_thursday, tp_friday, tp_saturday )";
			$req .= " VALUES ('" . addslashes($tp->get_name()) . "', '" . addslashes($tp->get_alias()) . "', '" .addslashes($tp->get_sunday()) . "', '" . addslashes($tp->get_monday()) . "', '" . addslashes($tp->get_tuesday());
			$req .= "', '" . addslashes($tp->get_wednesday()) . "', '" . addslashes($tp->get_thursday()) . "', '" . addslashes($tp->get_friday()). "', '" . addslashes($tp->get_saturday()) . "' )";
			$this->database->query($req);
			return $this->database->get_last_id();
		}
		else	{ // UPDATE
			$req  = "UPDATE timeperiod SET ";
			$req .= "tp_name = '".addslashes($tp->get_name())."', ";
			$req .= "tp_alias = '".addslashes($tp->get_alias())."', ";
			$req .= "tp_sunday = '".addslashes($tp->get_sunday())."', ";
			$req .= "tp_monday = '".addslashes($tp->get_monday())."', ";
			$req .= "tp_tuesday = '".addslashes($tp->get_tuesday())."', ";
			$req .= "tp_wednesday = '".addslashes($tp->get_wednesday())."', ";
			$req .= "tp_thursday = '".addslashes($tp->get_thursday())."', ";
			$req .= "tp_friday = '".addslashes($tp->get_friday())."', ";
			$req .= "tp_saturday = '".addslashes($tp->get_saturday())."' ";
			$req .= "WHERE tp_id = '".addslashes($tp->get_id())."'";
			$this->database->query($req);
			return 0;
		}
	}

	function deleteTimePeriod($tp)
	{
		if (isset($tp))	{
			$req = "DELETE FROM timeperiod WHERE `tp_id` = ".$tp->get_id()."";
			$this->database->query($req);
		}
	}

	//	Graphs

	function getGraph($graph_id = -1)
	{
		if ($graph_id == -1) {
			$this->database->query("SELECT * FROM graph");
			$ret_gr = array();
			for ($i = 0; ($gr = $this->database->fetch_array()); $i++)
				foreach ($gr as $key => $value)
					$ret_gr[$i][$key] = $value;
			return $ret_gr;
		} else {
			$this->database->query("SELECT * FROM graph WHERE graph_id = '$graph_id'");
			$res = $this->database->fetch_array();
			return $res;
		}
	}

	function saveGraph($gr, $flag)
	{
		if (!$flag)	{ // INSERT
			$req = "INSERT INTO graph (graph_id, graph_path, graph_imgformat, graph_verticallabel, graph_width, graph_height, graph_ColGrilFond, graph_ColFond, graph_ColPolice, graph_ColGrGril, graph_ColPtGril, graph_ColContCub, graph_ColArrow, graph_ColImHau, graph_ColImBa, graph_ds1name, graph_ds2name, graph_ColDs1, graph_ColDs2, graph_ds3name, graph_ds4name, graph_ColDs3, graph_ColDs4, graph_flamming, graph_lowerlimit, graph_areads1, graph_ticknessds1, graph_gprintlastds1, graph_gprintminds1, graph_gprintaverageds1, graph_gprintmaxds1, graph_areads2, graph_ticknessds2, graph_gprintlastds2, graph_gprintminds2, graph_gprintaverageds2, graph_gprintmaxds2, graph_areads3, graph_ticknessds3, graph_gprintlastds3, graph_gprintminds3, graph_gprintaverageds3, graph_gprintmaxds3, graph_areads4, graph_ticknessds4, graph_gprintlastds4, graph_gprintminds4, graph_gprintaverageds4, graph_gprintmaxds4)";
			$req .= " VALUES ('". $gr->get_id() ."', '" . addslashes($gr->get_path()) . "',";
			$req .= " '" . addslashes($gr->get_imgformat()) .  "', '" . addslashes($gr->get_verticallabel());
			$req .= "', '" . addslashes($gr->get_width()) .  "', '" . addslashes($gr->get_height());
			$req .= "', '" . addslashes($gr->get_ColGrilFond()) .  "', '" . addslashes($gr->get_ColFond());
			$req .= "', '" . addslashes($gr->get_ColPolice()) .  "', '" . addslashes($gr->get_ColGrGril());
			$req .= "', '" . addslashes($gr->get_ColPtGril()) .  "', '" . addslashes($gr->get_ColContCub());
			$req .= "', '" . addslashes($gr->get_ColArrow()) .  "', '" . addslashes($gr->get_ColImHau());
			$req .= "', '" . addslashes($gr->get_ColImBa()) .  "', '" . addslashes($gr->get_dsname(1));
			$req .= "', '" . addslashes($gr->get_dsname(2)) .  "', '" . addslashes($gr->get_ColDs(1));
			$req .= "', '" . addslashes($gr->get_ColDs(2)) .  "', '" . addslashes($gr->get_dsname(3));
			$req .= "', '" . addslashes($gr->get_dsname(4)) .  "', '" . addslashes($gr->get_ColDs(3));
			$req .= "', '" . addslashes($gr->get_ColDs(4)) .  "', '" . addslashes($gr->get_flamming());
			$req .= "', '" . addslashes($gr->get_lowerlimit()) .  "', '" . addslashes($gr->get_areads(1));
			$req .= "', '" . addslashes($gr->get_ticknessds(1)) .  "', '" . addslashes($gr->get_gprintlastds(1));
			$req .= "', '" . addslashes($gr->get_gprintminds(1)) .  "', '" . addslashes($gr->get_gprintaverageds(1));
			$req .= "', '" . addslashes($gr->get_gprintmaxds(1)) .  "', '" . addslashes($gr->get_areads(2));
			$req .= "', '" . addslashes($gr->get_ticknessds(2)) .  "', '" . addslashes($gr->get_gprintlastds(2));
			$req .= "', '" . addslashes($gr->get_gprintminds(2)) .  "', '" . addslashes($gr->get_gprintaverageds(2));
			$req .= "', '" . addslashes($gr->get_gprintmaxds(2)) .  "', '" . addslashes($gr->get_areads(3));
			$req .= "', '" . addslashes($gr->get_ticknessds(3)) .  "', '" . addslashes($gr->get_gprintlastds(3));
			$req .= "', '" . addslashes($gr->get_gprintminds(3)) .  "', '" . addslashes($gr->get_gprintaverageds(3));
			$req .= "', '" . addslashes($gr->get_gprintmaxds(3)) .  "', '" . addslashes($gr->get_areads(4));
			$req .= "', '" . addslashes($gr->get_ticknessds(4)) .  "', '" . addslashes($gr->get_gprintlastds(4));
			$req .= "', '" . addslashes($gr->get_gprintminds(4)) .  "', '" . addslashes($gr->get_gprintaverageds(4));
			$req .= "', '" . addslashes($gr->get_gprintmaxds(4)) . "' )";
			$this->database->query($req);
		}
		else	{ // UPDATE
			$req  = "UPDATE graph SET ";
			$req .= "graph_path = '".addslashes($gr->get_path())."', ";
			$req .= "graph_imgformat = '".addslashes($gr->get_imgformat())."', ";
			$req .= "graph_verticallabel = '".addslashes($gr->get_verticallabel())."', ";
			$req .= "graph_width = '".addslashes($gr->get_width())."', ";
			$req .= "graph_height = '".addslashes($gr->get_height())."', ";
			$req .= "graph_ColGrilFond = '".addslashes($gr->get_ColGrilFond())."', ";
			$req .= "graph_ColFond = '".addslashes($gr->get_ColFond())."', ";
			$req .= "graph_ColPolice = '".addslashes($gr->get_ColPolice())."', ";
			$req .= "graph_ColGrGril = '".addslashes($gr->get_ColGrGril())."', ";
			$req .= "graph_ColPtGril = '".addslashes($gr->get_ColPtGril())."', ";
			$req .= "graph_ColContCub = '".addslashes($gr->get_ColContCub())."', ";
			$req .= "graph_ColArrow = '".addslashes($gr->get_ColArrow())."', ";
			$req .= "graph_ColImHau = '".addslashes($gr->get_ColImHau())."', ";
			$req .= "graph_ColImBa = '".addslashes($gr->get_ColImBa())."', ";
			$req .= "graph_ds1name = '".addslashes($gr->get_dsname(1))."', ";
			$req .= "graph_ds2name = '".addslashes($gr->get_dsname(2))."', ";
			$req .= "graph_ColDs1 = '".addslashes($gr->get_ColDs(1))."', ";
			$req .= "graph_ColDs2 = '".addslashes($gr->get_ColDs(2))."', ";
			$req .= "graph_ds3name = '".addslashes($gr->get_dsname(3))."', ";
			$req .= "graph_ds4name = '".addslashes($gr->get_dsname(4))."', ";
			$req .= "graph_ColDs3 = '".addslashes($gr->get_ColDs(3))."', ";
			$req .= "graph_ColDs4 = '".addslashes($gr->get_ColDs(4))."', ";
			$req .= "graph_flamming = '".addslashes($gr->get_flamming())."', ";
			$req .= "graph_lowerlimit = '".addslashes($gr->get_lowerlimit())."', ";
			$req .= "graph_areads1 = '".addslashes($gr->get_areads(1))."', ";
			$req .= "graph_ticknessds1 = '".addslashes($gr->get_ticknessds(1))."', ";
			$req .= "graph_gprintlastds1 = '".addslashes($gr->get_gprintlastds(1))."', ";
			$req .= "graph_gprintminds1 = '".addslashes($gr->get_gprintminds(1))."', ";
			$req .= "graph_gprintaverageds1 = '".addslashes($gr->get_gprintaverageds(1))."', ";
			$req .= "graph_gprintmaxds1 = '".addslashes($gr->get_gprintmaxds(1))."', ";
			$req .= "graph_areads2 = '".addslashes($gr->get_areads(2))."', ";
			$req .= "graph_ticknessds2 = '".addslashes($gr->get_ticknessds(2))."', ";
			$req .= "graph_gprintlastds2 = '".addslashes($gr->get_gprintlastds(2))."', ";
			$req .= "graph_gprintminds2 = '".addslashes($gr->get_gprintminds(2))."', ";
			$req .= "graph_gprintaverageds2 = '".addslashes($gr->get_gprintaverageds(2))."', ";
			$req .= "graph_gprintmaxds2 = '".addslashes($gr->get_gprintmaxds(2))."', ";
			$req .= "graph_areads3 = '".addslashes($gr->get_areads(3))."', ";
			$req .= "graph_ticknessds3 = '".addslashes($gr->get_ticknessds(3))."', ";
			$req .= "graph_gprintlastds3 = '".addslashes($gr->get_gprintlastds(3))."', ";
			$req .= "graph_gprintminds3 = '".addslashes($gr->get_gprintminds(3))."', ";
			$req .= "graph_gprintaverageds3 = '".addslashes($gr->get_gprintaverageds(3))."', ";
			$req .= "graph_gprintmaxds3 = '".addslashes($gr->get_gprintmaxds(3))."', ";
			$req .= "graph_areads4 = '".addslashes($gr->get_areads(4))."', ";
			$req .= "graph_ticknessds4 = '".addslashes($gr->get_ticknessds(4))."', ";
			$req .= "graph_gprintlastds4 = '".addslashes($gr->get_gprintlastds(4))."', ";
			$req .= "graph_gprintminds4 = '".addslashes($gr->get_gprintminds(4))."', ";
			$req .= "graph_gprintaverageds4 = '".addslashes($gr->get_gprintaverageds(4))."', ";
			$req .= "graph_gprintmaxds4 = '".addslashes($gr->get_gprintmaxds(4))."' ";
			$req .= "WHERE graph_id = '".$gr->get_id()."'";
			$this->database->query($req);
		}
	}

	function deleteGraph($gr)
	{
		if (isset($gr))	{
			$req = "DELETE FROM graph WHERE `graph_id` = ".$gr->get_id()."";
			$this->database->query($req);
		}
	}

	//	GraphModels

	function getGraphModels()
	{
		$gmod_array = array();
		$this->database->query("SELECT * FROM gmod_properties");
		for ($i = 0; ($gmod = $this->database->fetch_array()); $i++)
			foreach ($gmod as $key => $value)
				$gmod_array[$i][$key] = $value;
		return $gmod_array;
	}

	function getGraphModelDS()
	{
		$gmodDS_array = array();
		$this->database->query("SELECT * FROM gmod_ds");
		for ($i = 0; ($gmodDS = $this->database->fetch_array()); $i++)
			foreach ($gmodDS as $key => $value)
				$gmodDS_array[$i][$key] = $value;
		return $gmodDS_array;
	}

	function saveGraphModel($graphModel)
	{
		if ($graphModel->get_id() == -1)	{ // INSERT
			$req = "INSERT INTO gmod_properties (gmod_name, gmod_imgformat, gmod_verticallabel, gmod_width, gmod_height, gmod_lowerlimit, gmod_ColGrilFond, gmod_ColFond, gmod_ColPolice, gmod_ColGrGril, gmod_ColPtGril, gmod_ColContCub, gmod_ColArrow, gmod_ColImHau, gmod_ColImBa)";
			$req .= " VALUES ('".$graphModel->get_name()."'";
			$req .= ", '" .$graphModel->get_imgformat()."', '".$graphModel->get_verticallabel();
			$req .= "', '" .$graphModel->get_width()."', '".$graphModel->get_height()."', '".$graphModel->get_lowerlimit()."";
			$req .= "', '" .$graphModel->get_ColGrilFond()."', '".$graphModel->get_ColFond();
			$req .= "', '" .$graphModel->get_ColPolice()."', '".$graphModel->get_ColGrGril();
			$req .= "', '" .$graphModel->get_ColPtGril()."', '".$graphModel->get_ColContCub();
			$req .= "', '" .$graphModel->get_ColArrow()."', '".$graphModel->get_ColImHau();
			$req .= "', '" .$graphModel->get_ColImBa()."')";
			$this->database->query($req);
		}
		else	{ // UPDATE
			$req  = "UPDATE gmod_properties SET ";
			$req .= "gmod_name = '".$graphModel->get_name()."', ";
			$req .= "gmod_imgformat = '".$graphModel->get_imgformat()."', ";
			$req .= "gmod_verticallabel = '".$graphModel->get_verticallabel()."', ";
			$req .= "gmod_width = '".$graphModel->get_width()."', ";
			$req .= "gmod_height = '".$graphModel->get_height()."', ";
			$req .= "gmod_lowerlimit = '".$graphModel->get_lowerlimit()."', ";
			$req .= "gmod_ColGrilFond = '".$graphModel->get_ColGrilFond()."', ";
			$req .= "gmod_ColFond = '".$graphModel->get_ColFond()."', ";
			$req .= "gmod_ColPolice = '".$graphModel->get_ColPolice()."', ";
			$req .= "gmod_ColGrGril = '".$graphModel->get_ColGrGril()."', ";
			$req .= "gmod_ColPtGril = '".$graphModel->get_ColPtGril()."', ";
			$req .= "gmod_ColContCub = '".$graphModel->get_ColContCub()."', ";
			$req .= "gmod_ColArrow = '".$graphModel->get_ColArrow()."', ";
			$req .= "gmod_ColImHau = '".$graphModel->get_ColImHau()."', ";
			$req .= "gmod_ColImBa = '".$graphModel->get_ColImBa()."' ";
			$req .= "WHERE gmod_id = '".$graphModel->get_id()."'";
			$this->database->query($req);
		}
	}

	function saveGraphModelDS($graphModelDS)	{
		if ($graphModelDS->get_id() == -1)	{ // INSERT
			$req = "INSERT INTO gmod_ds (gmod_ds_alias, gmod_ds_name, gmod_ds_col, gmod_ds_flamming, gmod_ds_area, gmod_ds_tickness, gmod_ds_gprintlast, gmod_ds_gprintmin, gmod_ds_gprintaverage, gmod_ds_gprintmax)";
			$req .= " VALUES ('".$graphModelDS->get_alias()."',";
			$req .= " '" .$graphModelDS->get_name()."', '".$graphModelDS->get_col();
			$req .= "', '" .$graphModelDS->get_flamming()."', '".$graphModelDS->get_area();
			$req .= "', '" .$graphModelDS->get_tickness()."', '".$graphModelDS->get_gprintlast();
			$req .= "', '" .$graphModelDS->get_gprintmin()."', '".$graphModelDS->get_gprintaverage();
			$req .= "', '" .$graphModelDS->get_gprintmax()."')";
			$this->database->query($req);
		}
		else	{ // UPDATE
			$req  = "UPDATE gmod_ds SET ";
			$req .= "gmod_ds_alias = '".$graphModelDS->get_alias()."', ";
			$req .= "gmod_ds_name = '".$graphModelDS->get_name()."', ";
			$req .= "gmod_ds_col = '".$graphModelDS->get_col()."', ";
			$req .= "gmod_ds_flamming = '".$graphModelDS->get_flamming()."', ";
			$req .= "gmod_ds_area = '".$graphModelDS->get_area()."', ";
			$req .= "gmod_ds_tickness = '".$graphModelDS->get_tickness()."', ";
			$req .= "gmod_ds_gprintlast = '".$graphModelDS->get_gprintlast()."', ";
			$req .= "gmod_ds_gprintmin = '".$graphModelDS->get_gprintmin()."', ";
			$req .= "gmod_ds_gprintaverage = '".$graphModelDS->get_gprintaverage()."', ";
			$req .= "gmod_ds_gprintmax = '".$graphModelDS->get_gprintmax()."' ";
			$req .= "WHERE gmod_ds_id = ".$graphModelDS->get_id().";";
			$this->database->query($req);
		}
	}

	function deleteGraphModelDS($graphModelDS)
	{
		if (isset($graphModelDS))	{
			$req = "DELETE FROM gmod_ds WHERE `gmod_ds_id` = ".$graphModelDS->get_id()."";
			$this->database->query($req);
		}
	}

	function deleteGraphModel($graphModel)
	{
		if (isset($graphModel))	{
			$req = "DELETE FROM gmod_properties WHERE `gmod_id` = ".$graphModel->get_id()."";
			$this->database->query($req);
		}
	}

	// Colors

	function getColors()
	{
		$this->database->query("SELECT * FROM colors");
		$ret_color = array();
		for ($i = 0; ($color = $this->database->fetch_array()); $i++) {
			foreach ($color as $key => $value) {
				$ret_color[$i][$key] = $value;
				}
		}
		return $ret_color;
	}

	function deleteColor($color)
	{
		if (isset($color))	{
			$req = "DELETE FROM colors WHERE `color_id` = ".$color->get_color_id();
			$this->database->query($req);
		}
	}

	function saveColor($color)
	{
		if ($color->get_color_id() == -1)	{ // INSERT
			$req = "INSERT INTO colors (hex)";
			$req .= " VALUES ('".$color->get_color()."')";
			$this->database->query($req);
		}
		else	{ // UPDATE
			$req  = "UPDATE colors SET ";
			$req .= "hex = '".$color->get_color()."'";
			$this->database->query($req);
		}
	}




	// Service Notification Commands

	function getServiceNotificationCommands($contact = -1)
	{
		if ($contact != -1)	{
			$this->database->query("SELECT * FROM contact_servicecommands_relation WHERE contact_contact_id = '". $contact->get_id() ."'");
			$ret_sncommands = array();
			for ($i = 0; ($snc = $this->database->fetch_array()); $i++)
				foreach ($snc as $key => $value)
					$ret_sncommands[$i][$key] = $value;
			return $ret_sncommands;
		}
	}

	function saveServiceNotificationCommandRelation($contact)
	{
		if (isset($contact))	{
			$req = "DELETE FROM contact_servicecommands_relation WHERE contact_contact_id = '". $contact->get_id() ."'";
			$this->database->query($req);
			if (isset($contact->service_notification_commands))
				foreach ($contact->service_notification_commands as $service_notification_command)	{
					$req = "INSERT INTO contact_servicecommands_relation (contact_contact_id, command_command_id)";
					$req .= " VALUES ('" . $contact->get_id() . "', '" . $service_notification_command->get_id() . "')";
					$this->database->query($req);
				}
		}
	}

	function deleteServiceNotificationCommandRelation($contact = -1, $command = -1)
	{
		if (isset($contact) && ($command == -1))	{
			$req = "DELETE FROM contact_servicecommands_relation WHERE contact_contact_id = '". $contact->get_id() ."'";
			$this->database->query($req);
		}
		else if (isset($command) && ($command != -1))	{
			$req = "DELETE FROM contact_servicecommands_relation WHERE command_command_id = '". $command->get_id() ."'";
			$this->database->query($req);
		}
	}

	// Host Notification Commands

	function getHostNotificationCommands($contact)
	{
		if (isset($contact))	{
			$this->database->query("SELECT * FROM contact_hostcommands_relation WHERE contact_contact_id = '". $contact->get_id() ."'");
			$ret_hncommands = array();
			for ($i = 0; ($snc = $this->database->fetch_array()); $i++)
				foreach ($snc as $key => $value)
					$ret_hncommands[$i][$key] = $value;
			return $ret_hncommands;
		}
	}

	function saveHostNotificationCommandRelation($contact)
	{
		if (isset($contact))	{
			$req = "DELETE FROM contact_hostcommands_relation WHERE contact_contact_id = '". $contact->get_id() ."'";
			$this->database->query($req);
			if (isset($contact->host_notification_commands))
				foreach ($contact->host_notification_commands as $host_notification_command)	{
					$req = "INSERT INTO contact_hostcommands_relation (contact_contact_id, command_command_id)";
					$req .= " VALUES ('" . $contact->get_id() . "', '" . $host_notification_command->get_id() . "')";
					$this->database->query($req);
				}
		}
	}

	function deleteHostNotificationCommandRelation($contact = -1, $command = -1)
	{
		if (isset($contact) && ($command == -1))	{
			$req = "DELETE FROM contact_hostcommands_relation WHERE contact_contact_id = '". $contact->get_id() ."'";
			$this->database->query($req);
		}
		else if (isset($command) && $command != -1)	{
			$req = "DELETE FROM contact_hostcommands_relation WHERE command_command_id = '". $command->get_id() ."'";
			$this->database->query($req);
		}
	}

	// Traffic Map

	function getTrafficMap()
	{
		$this->database->query("SELECT * FROM trafficMap ORDER BY tm_name");
		$ret_tms = array();
		for ($i = 0; ($tm = $this->database->fetch_array()); $i++)
			foreach ($tm as $key => $value)
				$ret_tms[$i][$key] = $value;
		return $ret_tms;
	}

	function saveTrafficMap($tm)
	{
		if (isset($tm) && ($tm->get_id() == -1))	{
			$req = "INSERT INTO trafficMap ( `tm_id`, `tm_name`, `tm_width`, `tm_height`, `tm_keyxpos`, `tm_keyypos`, `tm_date`, `tm_background` )";
			$req .= " VALUES ('', '" . $tm->get_name() . "', '".$tm->get_width()."', '".$tm->get_height()."', '".$tm->get_keyxpos()."', '".$tm->get_keyypos()."', '" . $tm->get_dateTM() . "', '" . $tm->get_background() . "')";
			$this->database->query($req);
		}
		else if (isset($tm))	{
			$req  = "UPDATE trafficMap SET ";
			$req .= "tm_name = '".addslashes($tm->get_name())."', ";
			$req .= "tm_date = '".$tm->get_dateTM()."', ";
			$req .= "tm_width = '".$tm->get_width()."', ";
			$req .= "tm_height = '".$tm->get_height()."', ";
			$req .= "tm_keyxpos = '".$tm->get_keyxpos()."', ";
			$req .= "tm_keyypos = '".$tm->get_keyypos()."', ";
			$req .= "tm_background = '".addslashes($tm->get_background())."' ";
			$req .= "WHERE tm_id = '".$tm->get_id()."'";
			$this->database->query($req);
		}
	}

	function deleteTrafficMap($tm)
	{
		if (isset($tm))	{
			$req = "DELETE FROM trafficMap WHERE `tm_id` = ".$tm->get_id()."";
			$this->database->query($req);
		}
	}

	// Traffic Map Host

	function getTrafficMapHosts($tm)
	{
		$this->database->query("SELECT * FROM trafficMap_host WHERE trafficMap_tm_id = ". $tm->get_id() ."");
		$ret_hosts = array();
		for ($i = 0; ($hostTM = $this->database->fetch_array()); $i++)
			foreach ($hostTM as $key => $value)
				$ret_hosts[$i][$key] = $value;
		return $ret_hosts;
	}

	function saveTrafficMapHost($tmh)
	{
		if (isset($tmh) && ($tmh->get_id() == -1))	{
			$req = "INSERT INTO trafficMap_host ( `tmh_id`, `tmh_label`, `trafficMap_tm_id`, `tmh_x`, `tmh_y`, `host_host_id`, `service_service_id` )";
			$req .= " VALUES ('', '" . $tmh->get_label() . "', '" . $tmh->get_trafficMap() . "', '" . $tmh->get_x() . "', '" . $tmh->get_y() . "', '" . $tmh->get_host() . "', '" . $tmh->get_service() . "')";
			$this->database->query($req);
		}
		else if (isset($tmh))	{
			$req  = "UPDATE trafficMap_host SET ";
			$req .= "tmh_label = '".addslashes($tmh->get_label())."', ";
			$req .= "trafficMap_tm_id = '".$tmh->get_trafficMap()."', ";
			$req .= "tmh_x = '".addslashes($tmh->get_x())."', ";
			$req .= "tmh_y = '".addslashes($tmh->get_y())."', ";
			$req .= "host_host_id = '".$tmh->get_host()."', ";
			$req .= "service_service_id = '".$tmh->get_service()."' ";
			$req .= "WHERE tmh_id = '".$tmh->get_id()."'";
			$this->database->query($req);
		}
	}

	function deleteTrafficMapHost($tmh)
	{
		if (isset($tmh))	{
			$req = "DELETE FROM trafficMap_host WHERE tmh_id = ". $tmh->get_id() ."";
			$this->database->query($req);
		}
	}

	// Traffic Map Host Relation

	function getTrafficMapHostsRelation($tm)
	{
		$this->database->query("SELECT * FROM trafficMap_host_relation WHERE trafficMap_tm_id = ". $tm->get_id() ."");
		$ret_hosts = array();
		for ($i = 0; ($hostTM = $this->database->fetch_array()); $i++)
			foreach ($hostTM as $key => $value)
				$ret_hosts[$i][$key] = $value;
		return $ret_hosts;
	}

	function saveTrafficMapHostRelation($tmr)
	{
		if (isset($tmr) && ($tmr->id == -1))	{
			$req = "INSERT INTO trafficMap_host_relation ( `tmhr_id`, `trafficMap_tm_id`, `trafficMap_host_tmh_id`, `trafficMap_host_tmh_id2`, `tmhr_bin`, `tmhr_bout`)";
			$req .= " VALUES ('', '". $tmr->get_trafficMap() ."', '" . $tmr->get_TMHost1() . "', '" . $tmr->get_TMHost2() . "', '". $tmr->get_bin() ."', '". $tmr->get_bout() ."')";
			$this->database->query($req);
		}	else if (isset($tmr))	{
			$req  = "UPDATE trafficMap_host_relation SET ";
			$req .= "trafficMap_tm_id = '".$tmr->get_trafficMap()."', ";
			$req .= "trafficMap_host_tmh_id = '".$tmr->get_TMHost1()."', ";
			$req .= "trafficMap_host_tmh_id2 = '".$tmr->get_TMHost2()."', ";
			$req .= "tmhr_bin = '".$tmr->get_bin()."', ";
			$req .= "tmhr_bout = '".$tmr->get_bout()."' ";
			$req .= "WHERE tmhr_id = '".$tmr->get_id()."'";
			$this->database->query($req);
		}
	}

	function deleteTrafficMapHostRelation($tmr = -1)
	{
		if ($tmr != -1)	{
			$req = "DELETE FROM trafficMap_host_relation WHERE tmhr_id = ". $tmr->get_id() ."";
			$this->database->query($req);
		}
	}

	// Profile host Commands
	function getProfileHosts()
	{
		$this->database->query("SELECT * FROM profile_host");
		$phs = array();
		for ($i = 0; ($ph = $this->database->fetch_array()); $i++)
			foreach ($ph as $key => $value)
				$phs[$i][$key] = $value;
		return $phs;
	}

	function getProfileHostNetInterface($host_id = NULL)
	{
		if ($host_id)	{
			$this->database->query("SELECT * FROM profile_interface WHERE host_host_id = '$host_id'");
			$nis = array();
			for ($i = 0; ($ni = $this->database->fetch_array()); $i++)
				foreach ($ni as $key => $value)
					$nis[$i][$key] = $value;
			return $nis;
		}
	}

	function getProfileHostDisk($host_id = NULL)
	{
		if ($host_id)	{
			$this->database->query("SELECT * FROM profile_disk WHERE host_host_id = '$host_id' ORDER BY pdisk_name ASC;");
			$disks = array();
			for ($i = 0; ($disk = $this->database->fetch_array()); $i++)
				foreach ($disk as $key => $value)
					$disks[$i][$key] = $value;
			return $disks;
		}
	}

	function saveProfileHost($ph = NULL)	{
		if (isset($ph)) {
			$req = "DELETE FROM profile_host WHERE host_host_id = ".$ph->get_host()."";
			$this->database->query($req);
			$tempSoft = NULL;
			$tempSoftUP = NULL;
			foreach($ph->softwares as $soft)
				$tempSoft .= $soft."|";
			foreach($ph->softwaresUP as $softUP)
				$tempSoftUP .= $softUP."|";
			$req = "INSERT INTO `profile_host` ";
			$req .= "( `host_host_id` , `phost_location` , `phost_contact` , `phost_ram` , `phost_uptime` , `phost_os`, `phost_update`, `phost_softwares`, `phost_softwaresUP`) VALUES ";
			$req .= "('".$ph->get_host()."', '".addslashes($ph->get_location())."', '".addslashes($ph->get_contact())."', '".$ph->get_ram()."', '".$ph->get_uptime()."', '".addslashes($ph->get_os())."', '".$ph->get_update()."', '".addslashes($tempSoft)."', '".addslashes($tempSoftUP)."')";
			$this->database->query($req);
			unset($tempSoft);
			unset($tempSoftUP);
		}
	}

	function saveProfileHostNetInterface($ph = NULL)	{
		if (isset($ph))	{
			$req = "DELETE FROM profile_interface WHERE host_host_id = ".$ph->get_host()."";
			$this->database->query($req);
			if (isset($ph->netInterfaces))
				foreach ($ph->netInterfaces as $netInterface)	{
					$req = "INSERT INTO `profile_interface` ";
					$req .= "( `host_host_id` , `pi_ip` , `pi_mac` , `pi_model` , `pi_speed` ) VALUES ";
					$req .= "( '".$netInterface->get_host()."', '".$netInterface->get_ip()."', '".$netInterface->get_mac()."', '".addslashes($netInterface->get_model())."', '".$netInterface->get_speed()."')";
					$this->database->query($req);
			}
		}
	}

	function saveProfileHostDisk($ph = NULL)	{
		if (isset($ph))	{
			$req = "DELETE FROM profile_disk WHERE host_host_id = ".$ph->get_host()."";
			$this->database->query($req);
			if (isset($ph->disks))
				foreach ($ph->disks as $disk)	{
					$req = "INSERT INTO `profile_disk` ";
					$req .= "( `pdisk_id`, `host_host_id` , `pdisk_name` , `pdisk_space` , `pdisk_used_space` , `pdisk_free_space` ) VALUES ";
					$req .= "( '', '".$disk->get_host()."', '".addslashes($disk->get_name())."', '".$disk->get_space()."', '".$disk->get_used_space()."', '".$disk->get_free_space()."')";
					$this->database->query($req);
			}
		}
	}

	function deleteProfileHost($ph = NULL)	{
		if ($ph) {
			$req = "DELETE FROM profile_host WHERE host_host_id = ".$ph->get_host()."";
			$this->database->query($req);
		}
	}

	function deleteProfileHostNetInterface($ph = NULL)	{
		if ($ph)	{
			$req = "DELETE FROM profile_interface WHERE host_host_id = ".$ph->get_host()."";
			$this->database->query($req);
		}
	}

	function deleteProfileHostDisk($ph = NULL)	{
		if ($ph)	{
			$req = "DELETE FROM profile_disk WHERE host_host_id = ".$ph->get_host()."";
			$this->database->query($req);
		}
	}

	/* Session */

	function add_new_session($session_id, $user_id)
	{
		$req = "DELETE FROM session WHERE `session_id` = '". $session_id ."'";
		$this->database->query($req);
		$req = "INSERT INTO session ( `session_id`, `user_id`, `current_page`, `last_reload`) VALUES ('".$session_id."', '" . $user_id . "', '1', '".time()."') ";
		$this->database->query($req);
	}

	function update_current_session($session_id, $page_id, $action)
	{
		$req = "UPDATE session SET ";
		$req .= "`current_page` = '".$page_id."', ";
		$req .= "`type` = '".$action."', ";
		$req .= "`last_reload` = '".time()."' WHERE `session_id` = '" . $session_id . "';";
		$this->database->query($req);
	}

	function load_current_data_to_reload($session_id)
	{
		$req = "SELECT * FROM `session` WHERE `session_id` = '".$session_id."';";
		$this->database->query($req);
		$status = $this->database->fetch_array();
		$ret_status = array();
		if ($status)
			foreach ($status as $key => $value){
				$ret_status[$key] = $value;
			}
		return $ret_status;
	}

	function clean_session(& $expire)
	{
		if ($expire){
			$t = time() - ($expire * 60);
			$req = "DELETE FROM session WHERE `last_reload` <= '". $t ."'";
			$this->database->query($req);
		}
	}

	function load_user_status()
	{
		$req = "SELECT user_id,current_page,last_reload,session_id FROM `session` WHERE 1;";
		$this->database->query($req);
		$ret_status = array();
		for ($i = 0; ($status = $this->database->fetch_array()); $i++)
			foreach ($status as $key => $value){
				$ret_status[$i][$key] = $value;
			}
		return $ret_status;
	}

	function set_flag_user($session_id, $flag_id)
	{
		$flag["0"] = "host";
		$flag["1"] = "host_group";
		$flag["2"] = "host_group_escalation";
		$flag["3"] = "host_escalation";
		$flag["4"] = "host_dependency";
		$flag["5"] = "host_template_model";
		$flag["6"] = "host_extended_infos";
		$flag["7"] = "service";
		$flag["8"] = "service_escalation";
		$flag["9"] = "service_dependency";
		$flag["10"] = "service_group";
		$flag["11"] = "service_template_model";
		$flag["12"] = "service_extended_infos";
		$flag["13"] = "contact";
		$flag["14"] = "contact_group";
		$flag["15"] = "timeperiod";
		$flag["16"] = "command";
		$flag["17"] = "trafficMap";
		$flag["18"] = "graph_model_ds";
		$flag["19"] = "graph_model_conf";
		$flag["20"] = "graph";
		$flag["21"] = "general";
		$flag["22"] = "nagioscfg";
		$flag["23"] = "ressourcecfg";
		$flag["24"] = "profile_user";
		$flag["25"] = "lca";
		$req = "UPDATE session SET ";
		$req .= "`".$flag[$flag_id]."` = '1' WHERE `session_id` != '" . $session_id . "'";
		$this->database->query($req);

	}

	function clean_table_from_current_user()
	{
		$req = "UPDATE `session` SET `host` = '0', `host_group` = '0', `host_group_escalation` = 0, `host_escalation` = 0, `host_dependency` = 0, `host_template_model` = 0, ";
		$req .= "`host_extended_infos` = 0, `service` = 0, `service_escalation` = 0, `service_dependency` = 0, `service_group` = 0, `service_template_model` = 0, ";
		$req .= "`service_extended_infos` = 0, `contact` = 0, `contact_group` = 0, `timeperiod` = 0, `command` = 0, `trafficMap` = 0, `graph_model_ds` = 0, `graph_model_conf` = 0, ";
		$req .= "`graph` = 0, `nagioscfg` = 0, `ressourcecfg` = 0, `profile_user` = 0, `lca` = 0 WHERE `session_id` = '".session_id()."' LIMIT 1 ;";
		$this->database->query($req);
	}

	function check_if_session_ok($session_id)
	{
		$req = "SELECT last_reload FROM session WHERE `session_id` = '" . $session_id . "';";
		$this->database->query($req);
		$status = $this->database->fetch_array();
		if ($status['last_reload'])
			return "1";
		else
			return "0";
	}

	function getRedirectTo()
	{
		$this->database->query("SELECT * FROM `redirect_pages`");
		$data = array();
			for ($i = 0; ($res = $this->database->fetch_array()); $i++)
				foreach ($res as $key => $value){
					$data[$i][$key] = $value;
				}
		return $data;
	}
	
	function getTotalRowsInTable($table)
	{
		$req = "SELECT COUNT(*) FROM " . $table;
		$this->database->query($req);
		$value = $this->database->fetch_array();
		$status = $value[0];
		//echo $status; // lo saca por pantalla
		return $status; // lo devuelve al peticionario de la funcion
	}
	
	function getUserLang($iduserlogged)
	{
		$req = "SELECT user_lang FROM user WHERE user_id='" . $iduserlogged . "'";
		$this->database->query($req);
		$value = $this->database->fetch_array();
		$status = $value[0];
		return $status;
	}
	
	function getdialupadminconfiguration($row)
	{
		$req = "SELECT " . $row . " FROM dialup_admin_cfg";
		$this->database->query($req);
		$value = $this->database->fetch_array();
		$status = $value[0];
		return $status;
	}
	function getgeneralconfiguration($row)
	{
		$req = "SELECT " . $row . " FROM general_opt";
		$this->database->query($req);
		$value = $this->database->fetch_array();
		$status = $value[0];
		return $status;
	}

	function getnasconfiguration()
	{
		$req = $this->database->query("SELECT * FROM nas");
		return $req;
	}
	
} /* end class phpradminDatabase */
?>
