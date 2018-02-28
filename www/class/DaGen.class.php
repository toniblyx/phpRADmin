<?
/*
phpRADmin is developped under GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt or read LICENSE file.

Developed by : Toni de la Fuente (blyx) from Madrid and Alfacar (Granada), Spain  
For information : toni@blyx.com http://blyx.com

We are using Oreon for base code: http://www.oreon-project.org
We are using Dialup Admin for user management 
and many more things: http://www.freeradius.org
We are using PHPKI for Certificates management: http://phpki.sourceforge.org/ 

Thanks very much!!
*/
class daGen
{

  // Attributes

var $general_prefered_lang;
var $general_prefered_lang_name;
var $general_charset;
var $general_base_dir;
var $general_radiusd_base_dir;
var $general_domain;
var $general_use_session;
var $general_most_recent_fl;
var $general_strip_realms;
var $general_realm_delimiter;
var $general_realm_format;
var $general_show_user_password;
var $general_raddb_dir;
var $general_ldap_attrmap;
var $general_clients_conf;
var $general_sql_attrmap;
var $general_accounting_attrs_file;
var $general_extra_ldap_attrmap;
var $general_lib_type;
var $general_user_edit_attrs_file;
var $general_sql_attrs_file;
var $general_default_file;
var $general_finger_type;
var $general_nas_type;
var $general_snmpfinger_bin;
var $general_radclient_bin;
var $general_test_account_login;
var $general_test_account_password;
var $general_radius_server;
var $general_radius_server_port;
var $general_radius_server_auth_proto;
var $general_radius_server_secret;
var $general_auth_request_file;
var $general_encryption_method;
var $general_accounting_info_order;
var $general_stats_use_totacct;
var $general_restrict_badusers_access;
var $general_caption_finger_free_lines;
var $ldap_server;
var $ldap_write_server;
var $ldap_base;
var $ldap_binddn;
var $ldap_bindpw;
var $ldap_default_new_entry_suffix;
var $ldap_default_dn;
var $ldap_regular_profile_attr;
var $ldap_use_http_credentials;
var $ldap_directory_manager;
var $ldap_map_to_directory_manager;
var $ldap_debug;
var $ldap_filter;
var $ldap_userdn;
var $sql_type;
var $sql_server;
var $sql_port;
var $sql_username;
var $sql_password;
var $sql_database;
var $sql_accounting_table;
var $sql_badusers_table;
var $sql_check_table;
var $sql_reply_table;
var $sql_user_info_table;
var $sql_groupcheck_table;
var $sql_groupreply_table;
var $sql_usergroup_table;
var $sql_total_accounting_table;
var $sql_nas_table;
var $sql_command;
var $general_snmp_type;
var $general_snmpwalk_command;
var $general_snmpget_command;
var $sql_debug;
var $sql_use_user_info_table;
var $sql_use_operators;
var $sql_password_attribute;
var $sql_date_format;
var $sql_full_date_format;
var $sql_row_limit;
var $sql_connect_timeout;
var $sql_extra_servers;
var $counter_default_daily;
var $counter_default_weekly;
var $counter_default_monthly;
var $counter_monthly_calculate_usage;


  // Operations

  function daGen($da)  {
	$this->general_prefered_lang = $da["general_prefered_lang"];
	$this->general_prefered_lang_name = $da["general_prefered_lang_name"];
	$this->general_charset = $da["general_charset"];
	$this->general_base_dir = $da["general_base_dir"];
	$this->general_radiusd_base_dir = $da["general_radiusd_base_dir"];
	$this->general_domain = $da["general_domain"];
	$this->general_use_session = $da["general_use_session"];
	$this->general_most_recent_fl = $da["general_most_recent_fl"];
	$this->general_strip_realms = $da["general_strip_realms"];
	$this->general_realm_delimiter = $da["general_realm_delimiter"];
	$this->general_realm_format = $da["general_realm_format"];
	$this->general_show_user_password = $da["general_show_user_password"];
	$this->general_raddb_dir = $da["general_raddb_dir"];
	$this->general_ldap_attrmap = $da["general_ldap_attrmap"];
	$this->general_clients_conf = $da["general_clients_conf"];
	$this->general_sql_attrmap = $da["general_sql_attrmap"];
	$this->general_accounting_attrs_file = $da["general_accounting_attrs_file"];
	$this->general_extra_ldap_attrmap = $da["general_extra_ldap_attrmap"];
	$this->general_lib_type = $da["general_lib_type"];
	$this->general_user_edit_attrs_file = $da["general_user_edit_attrs_file"];
	$this->general_sql_attrs_file = $da["general_sql_attrs_file"];
	$this->general_default_file = $da["general_default_file"];
	$this->general_finger_type = $da["general_finger_type"];
	$this->general_nas_type = $da["general_nas_type"];
	$this->general_snmpfinger_bin = $da["general_snmpfinger_bin"];
	$this->general_radclient_bin = $da["general_radclient_bin"];
	$this->general_test_account_login = $da["general_test_account_login"];
	$this->general_test_account_password = $da["general_test_account_password"];
	$this->general_radius_server = $da["general_radius_server"];
	$this->general_radius_server_port = $da["general_radius_server_port"];
	$this->general_radius_server_auth_proto = $da["general_radius_server_auth_proto"];
	$this->general_radius_server_secret = $da["general_radius_server_secret"];
	$this->general_auth_request_file = $da["general_auth_request_file"];
	$this->general_encryption_method = $da["general_encryption_method"];
	$this->general_accounting_info_order = $da["general_accounting_info_order"];
	$this->general_stats_use_totacct = $da["general_stats_use_totacct"];
	$this->general_restrict_badusers_access = $da["general_restrict_badusers_access"];
	$this->general_caption_finger_free_lines = $da["general_caption_finger_free_lines"];
	$this->ldap_server = $da["ldap_server"];
	$this->ldap_write_server = $da["ldap_write_server"];
	$this->ldap_base = $da["ldap_base"];
	$this->ldap_binddn = $da["ldap_binddn"];
	$this->ldap_bindpw = $da["ldap_bindpw"];
	$this->ldap_default_new_entry_suffix = $da["ldap_default_new_entry_suffix"];
	$this->ldap_default_dn = $da["ldap_default_dn"];
	$this->ldap_regular_profile_attr = $da["ldap_regular_profile_attr"];
	$this->ldap_use_http_credentials = $da["ldap_use_http_credentials"];
	$this->ldap_directory_manager = $da["ldap_directory_manager"];
	$this->ldap_map_to_directory_manager = $da["ldap_map_to_directory_manager"];
	$this->ldap_debug = $da["ldap_debug"];
	$this->ldap_filter = $da["ldap_filter"];
	$this->ldap_userdn = $da["ldap_userdn"];
	$this->sql_type = $da["sql_type"];
	$this->sql_server = $da["sql_server"];
	$this->sql_port = $da["sql_port"];
	$this->sql_username = $da["sql_username"];
	$this->sql_password = $da["sql_password"];
	$this->sql_database = $da["sql_database"];
	$this->sql_accounting_table = $da["sql_accounting_table"];
	$this->sql_badusers_table = $da["sql_badusers_table"];
	$this->sql_check_table = $da["sql_check_table"];
	$this->sql_reply_table = $da["sql_reply_table"];
	$this->sql_user_info_table = $da["sql_user_info_table"];
	$this->sql_groupcheck_table = $da["sql_groupcheck_table"];
	$this->sql_groupreply_table = $da["sql_groupreply_table"];
	$this->sql_usergroup_table = $da["sql_usergroup_table"];
	$this->sql_total_accounting_table = $da["sql_total_accounting_table"];
	$this->sql_nas_table = $da["sql_nas_table"];
	$this->sql_command = $da["sql_command"];
	$this->general_snmp_type = $da["general_snmp_type"];
	$this->general_snmpwalk_command = $da["general_snmpwalk_command"];
	$this->general_snmpget_command = $da["general_snmpget_command"];
	$this->sql_debug = $da["sql_debug"];
	$this->sql_use_user_info_table = $da["sql_use_user_info_table"];
	$this->sql_use_operators = $da["sql_use_operators"];
	$this->sql_password_attribute = $da["sql_password_attribute"];
	$this->sql_date_format = $da["sql_date_format"];
	$this->sql_full_date_format = $da["sql_full_date_format"];
	$this->sql_row_limit = $da["sql_row_limit"];
	$this->sql_connect_timeout = $da["sql_connect_timeout"];
	$this->sql_extra_servers = $da["sql_extra_servers"];
	$this->counter_default_daily = $da["counter_default_daily"];
	$this->counter_default_weekly = $da["counter_default_weekly"];
	$this->counter_default_monthly = $da["counter_default_monthly"];
	$this->counter_monthly_calculate_usage = $da["counter_monthly_calculate_usage"];
}

  function get_general_prefered_lang() {
     return stripslashes($this->general_prefered_lang);
	}
	function get_general_prefered_lang_name() {
		 return stripslashes($this->general_prefered_lang_name);
	}
	function get_general_charset() {
		 return stripslashes($this->general_charset);
	}
	function get_general_base_dir() {
		 return stripslashes($this->general_base_dir);
	}
	function get_general_radiusd_base_dir() {
		 return stripslashes($this->general_radiusd_base_dir);
	}
	function get_general_domain() {
		 return stripslashes($this->general_domain);
	}
	function get_general_use_session() {
		 return stripslashes($this->general_use_session);
	}
	function get_general_most_recent_fl() {
		 return stripslashes($this->general_most_recent_fl);
	}
	function get_general_strip_realms() {
		 return stripslashes($this->general_strip_realms);
	}
	function get_general_realm_delimiter() {
		 return stripslashes($this->general_realm_delimiter);
	}
	function get_general_realm_format() {
		 return stripslashes($this->general_realm_format);
	}
	function get_general_show_user_password() {
		 return stripslashes($this->general_show_user_password);
	}
	function get_general_raddb_dir() {
		 return stripslashes($this->general_raddb_dir);
	}
	function get_general_ldap_attrmap() {
		 return stripslashes($this->general_ldap_attrmap);
	}
	function get_general_clients_conf() {
		 return stripslashes($this->general_clients_conf);
	}
	function get_general_sql_attrmap() {
		 return stripslashes($this->general_sql_attrmap);
	}
	function get_general_accounting_attrs_file() {
		 return stripslashes($this->general_accounting_attrs_file);
	}
	function get_general_extra_ldap_attrmap() {
		 return stripslashes($this->general_extra_ldap_attrmap);
	}
	function get_general_lib_type() {
		 return stripslashes($this->general_lib_type);
	}
	function get_general_user_edit_attrs_file() {
		 return stripslashes($this->general_user_edit_attrs_file);
	}
	function get_general_sql_attrs_file() {
		 return stripslashes($this->general_sql_attrs_file);
	}
	function get_general_default_file() {
		 return stripslashes($this->general_default_file);
	}
	function get_general_finger_type() {
		 return stripslashes($this->general_finger_type);
	}
	function get_general_nas_type() {
		 return stripslashes($this->general_nas_type);
	}
	function get_general_snmpfinger_bin() {
		 return stripslashes($this->general_snmpfinger_bin);
	}
	function get_general_radclient_bin() {
		 return stripslashes($this->general_radclient_bin);
	}
	function get_general_test_account_login() {
		 return stripslashes($this->general_test_account_login);
	}
	function get_general_test_account_password() {
		 return stripslashes($this->general_test_account_password);
	}
	function get_general_radius_server() {
		 return stripslashes($this->general_radius_server);
	}
	function get_general_radius_server_port() {
		 return stripslashes($this->general_radius_server_port);
	}
	function get_general_radius_server_auth_proto() {
		 return stripslashes($this->general_radius_server_auth_proto);
	}
	function get_general_radius_server_secret() {
		 return stripslashes($this->general_radius_server_secret);
	}
	function get_general_auth_request_file() {
		 return stripslashes($this->general_auth_request_file);
	}
	function get_general_encryption_method() {
		 return stripslashes($this->general_encryption_method);
	}
	function get_general_accounting_info_order() {
		 return stripslashes($this->general_accounting_info_order);
	}
	function get_general_stats_use_totacct() {
		 return stripslashes($this->general_stats_use_totacct);
	}
	function get_general_restrict_badusers_access() {
		 return stripslashes($this->general_restrict_badusers_access);
	}
	function get_general_caption_finger_free_lines() {
		 return stripslashes($this->general_caption_finger_free_lines);
	}
	function get_ldap_server() {
		 return stripslashes($this->ldap_server);
	}
	function get_ldap_write_server() {
		 return stripslashes($this->ldap_write_server);
	}
	function get_ldap_base() {
		 return stripslashes($this->ldap_base);
	}
	function get_ldap_binddn() {
		 return stripslashes($this->ldap_binddn);
	}
	function get_ldap_bindpw() {
		 return stripslashes($this->ldap_bindpw);
	}
	function get_ldap_default_new_entry_suffix() {
		 return stripslashes($this->ldap_default_new_entry_suffix);
	}
	function get_ldap_default_dn() {
		 return stripslashes($this->ldap_default_dn);
	}
	function get_ldap_regular_profile_attr() {
		 return stripslashes($this->ldap_regular_profile_attr);
	}
	function get_ldap_use_http_credentials() {
		 return stripslashes($this->ldap_use_http_credentials);
	}
	function get_ldap_directory_manager() {
		 return stripslashes($this->ldap_directory_manager);
	}
	function get_ldap_map_to_directory_manager() {
		 return stripslashes($this->ldap_map_to_directory_manager);
	}
	function get_ldap_debug() {
		 return stripslashes($this->ldap_debug);
	}
	function get_ldap_filter() {
		 return stripslashes($this->ldap_filter);
	}
	function get_ldap_userdn() {
		 return stripslashes($this->ldap_userdn);
	}
	function get_sql_type() {
		 return stripslashes($this->sql_type);
	}
	function get_sql_server() {
		 return stripslashes($this->sql_server);
	}
	function get_sql_port() {
		 return stripslashes($this->sql_port);
	}
	function get_sql_username() {
		 return stripslashes($this->sql_username);
	}
	function get_sql_password() {
		 return stripslashes($this->sql_password);
	}
	function get_sql_database() {
		 return stripslashes($this->sql_database);
	}
	function get_sql_accounting_table() {
		 return stripslashes($this->sql_accounting_table);
	}
	function get_sql_badusers_table() {
		 return stripslashes($this->sql_badusers_table);
	}
	function get_sql_check_table() {
		 return stripslashes($this->sql_check_table);
	}
	function get_sql_reply_table() {
		 return stripslashes($this->sql_reply_table);
	}
	function get_sql_user_info_table() {
		 return stripslashes($this->sql_user_info_table);
	}
	function get_sql_groupcheck_table() {
		 return stripslashes($this->sql_groupcheck_table);
	}
	function get_sql_groupreply_table() {
		 return stripslashes($this->sql_groupreply_table);
	}
	function get_sql_usergroup_table() {
		 return stripslashes($this->sql_usergroup_table);
	}
	function get_sql_total_accounting_table() {
		 return stripslashes($this->sql_total_accounting_table);
	}
	function get_sql_nas_table() {
		 return stripslashes($this->sql_nas_table);
	}
	function get_sql_command() {
		 return stripslashes($this->sql_command);
	}
	function get_general_snmp_type() {
		 return stripslashes($this->general_snmp_type);
	}
	function get_general_snmpwalk_command() {
		 return stripslashes($this->general_snmpwalk_command);
	}
	function get_general_snmpget_command() {
		 return stripslashes($this->general_snmpget_command);
	}
	function get_sql_debug() {
		 return stripslashes($this->sql_debug);
	}
	function get_sql_use_user_info_table() {
		 return stripslashes($this->sql_use_user_info_table);
	}
	function get_sql_use_operators() {
		 return stripslashes($this->sql_use_operators);
	}
	function get_sql_password_attribute() {
		 return stripslashes($this->sql_password_attribute);
	}
	function get_sql_date_format() {
		 return stripslashes($this->sql_date_format);
	}
	function get_sql_full_date_format() {
		 return stripslashes($this->sql_full_date_format);
	}
	function get_sql_row_limit() {
		 return stripslashes($this->sql_row_limit);
	}
	function get_sql_connect_timeout() {
		 return stripslashes($this->sql_connect_timeout);
	}
	function get_sql_extra_servers() {
		 return stripslashes($this->sql_extra_servers);
	}
	function get_counter_default_daily() {
		 return stripslashes($this->counter_default_daily);
	}
	function get_counter_default_weekly() {
		 return stripslashes($this->counter_default_weekly);
	}
	function get_counter_default_monthly() {
		 return stripslashes($this->counter_default_monthly);
	}
	function get_counter_monthly_calculate_usage() {
		 return stripslashes($this->counter_monthly_calculate_usage);
	}

  function is_valid_path($path)	{
	if (is_dir($path) )  {
	    $style = '';
	} else {
	    $style = 'class="invalid_path"';
	}
	return $style;
  }
  function is_readable_directory($path)	{
	$style = $this->is_valid_path($path);
	if ($style == '') {
	    if (is_readable($path) )  {
		$style = '';
	    } else {
		$style = 'class="unreadable_path"';
	    }
	} else {
	    $style = 'class="invalid_path"';
	}
	return $style;
  }
  function is_executable_binary($path)	{
	if (is_file($path)) {
	    if (is_executable($path) )  {
		$style = '';
	    } else {
		$style = 'class="unexecutable_binary"';
	    }
	} else {
	    $style = 'class="invalid_path"';
	}
	return $style;
  }
  function is_writable_path($path)	{
	$style = $this->is_valid_path($path);
	if ($style == '') {
	    if (is_writable($path) )  {
		$style = '';
	    } else {
		$style = 'class="unwritable_path"';
	    }
	}
	return $style;
  }
  function is_writable_file($path)	{
	if (is_file($path)) {
	    if (is_writable($path) )  {
		$style = '';
	    } else {
		$style = 'class="unwritable_path"';
	    }
	} else {
	    $style = 'class="invalid_path"';
	}
	return $style;
  }

} /* end class optGen */
?>
