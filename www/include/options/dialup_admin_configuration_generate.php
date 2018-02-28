<?php

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

include_once ("class/Oreon.class.php");
include_once ("phpradmin.conf.php");

$oreon_db = new OreonDatabase($conf_pra["host"], $conf_pra["user"], $conf_pra["password"], $conf_pra["db"]);

$phpradmin_dir = $oreon->optGen->get_phpradmin_pwd();
$general_prefered_lang = $oreon_db ->getdialupadminconfiguration(general_prefered_lang);
$general_prefered_lang_name = $oreon_db ->getdialupadminconfiguration(general_prefered_lang_name);
$general_charset = $oreon_db ->getdialupadminconfiguration(general_charset);
$general_base_dir = $oreon_db ->getdialupadminconfiguration(general_base_dir);
$general_radiusd_base_dir = $oreon_db ->getdialupadminconfiguration(general_radiusd_base_dir);
$general_domain = $oreon_db ->getdialupadminconfiguration(general_domain);
$general_use_session = $oreon_db ->getdialupadminconfiguration(general_use_session);
$general_most_recent_fl = $oreon_db ->getdialupadminconfiguration(general_most_recent_fl);
$general_strip_realms = $oreon_db ->getdialupadminconfiguration(general_strip_realms);
$general_realm_delimiter = $oreon_db ->getdialupadminconfiguration(general_realm_delimiter);
$general_realm_format = $oreon_db ->getdialupadminconfiguration(general_realm_format);
$general_show_user_password = $oreon_db ->getdialupadminconfiguration(general_show_user_password);
$general_raddb_dir = $oreon_db ->getdialupadminconfiguration(general_raddb_dir);
$general_ldap_attrmap = $oreon_db ->getdialupadminconfiguration(general_ldap_attrmap);
$general_clients_conf = $oreon_db ->getdialupadminconfiguration(general_clients_conf);
$general_sql_attrmap = $oreon_db ->getdialupadminconfiguration(general_sql_attrmap);
$general_accounting_attrs_file = $oreon_db ->getdialupadminconfiguration(general_accounting_attrs_file);
$general_extra_ldap_attrmap = $oreon_db ->getdialupadminconfiguration(general_extra_ldap_attrmap);
$general_lib_type = $oreon_db ->getdialupadminconfiguration(general_lib_type);
$general_user_edit_attrs_file = $oreon_db ->getdialupadminconfiguration(general_user_edit_attrs_file);
$general_sql_attrs_file = $oreon_db ->getdialupadminconfiguration(general_sql_attrs_file);
$general_default_file = $oreon_db ->getdialupadminconfiguration(general_default_file);
$general_finger_type = $oreon_db ->getdialupadminconfiguration(general_finger_type);
$general_nas_type = $oreon_db ->getdialupadminconfiguration(general_nas_type);
$general_snmpfinger_bin = $oreon_db ->getdialupadminconfiguration(general_snmpfinger_bin);
$general_radclient_bin = $oreon_db ->getdialupadminconfiguration(general_radclient_bin);
$general_test_account_login = $oreon_db ->getdialupadminconfiguration(general_test_account_login);
$general_test_account_password = $oreon_db ->getdialupadminconfiguration(general_test_account_password);
$general_radius_server = $oreon_db ->getdialupadminconfiguration(general_radius_server);
$general_radius_server_port = $oreon_db ->getdialupadminconfiguration(general_radius_server_port);
$general_radius_server_auth_proto = $oreon_db ->getdialupadminconfiguration(general_radius_server_auth_proto);
$general_radius_server_secret = $oreon_db ->getdialupadminconfiguration(general_radius_server_secret);
$general_auth_request_file = $oreon_db ->getdialupadminconfiguration(general_auth_request_file);
$general_encryption_method = $oreon_db ->getdialupadminconfiguration(general_encryption_method);
$general_accounting_info_order = $oreon_db ->getdialupadminconfiguration(general_accounting_info_order);
$general_stats_use_totacct = $oreon_db ->getdialupadminconfiguration(general_stats_use_totacct);
$general_restrict_badusers_access = $oreon_db ->getdialupadminconfiguration(general_restrict_badusers_access);
$general_caption_finger_free_lines = $oreon_db ->getdialupadminconfiguration(general_caption_finger_free_lines);
$ldap_server = $oreon_db ->getdialupadminconfiguration(ldap_server);
$ldap_write_server = $oreon_db ->getdialupadminconfiguration(ldap_write_server);
$ldap_base = $oreon_db ->getdialupadminconfiguration(ldap_base);
$ldap_binddn = $oreon_db ->getdialupadminconfiguration(ldap_binddn);
$ldap_bindpw = $oreon_db ->getdialupadminconfiguration(ldap_bindpw);
$ldap_default_new_entry_suffix = $oreon_db ->getdialupadminconfiguration(ldap_default_new_entry_suffix);
$ldap_default_dn = $oreon_db ->getdialupadminconfiguration(ldap_default_dn);
$ldap_regular_profile_attr = $oreon_db ->getdialupadminconfiguration(ldap_regular_profile_attr);
$ldap_use_http_credentials = $oreon_db ->getdialupadminconfiguration(ldap_use_http_credentials);
$ldap_directory_manager = $oreon_db ->getdialupadminconfiguration(ldap_directory_manager);
$ldap_map_to_directory_manager = $oreon_db ->getdialupadminconfiguration(ldap_map_to_directory_manager);
$ldap_debug = $oreon_db ->getdialupadminconfiguration(ldap_debug);
$ldap_filter = $oreon_db ->getdialupadminconfiguration(ldap_filter);
$ldap_userdn = $oreon_db ->getdialupadminconfiguration(ldap_userdn);
$sql_type = $oreon_db ->getdialupadminconfiguration(sql_type);
$sql_server = $oreon_db ->getdialupadminconfiguration(sql_server);
$sql_port = $oreon_db ->getdialupadminconfiguration(sql_port);
$sql_username = $oreon_db ->getdialupadminconfiguration(sql_username);
$sql_password = $oreon_db ->getdialupadminconfiguration(sql_password);
$sql_database = $oreon_db ->getdialupadminconfiguration(sql_database);
$sql_accounting_table = $oreon_db ->getdialupadminconfiguration(sql_accounting_table);
$sql_badusers_table = $oreon_db ->getdialupadminconfiguration(sql_badusers_table);
$sql_check_table = $oreon_db ->getdialupadminconfiguration(sql_check_table);
$sql_reply_table = $oreon_db ->getdialupadminconfiguration(sql_reply_table);
$sql_user_info_table = $oreon_db ->getdialupadminconfiguration(sql_user_info_table);
$sql_groupcheck_table = $oreon_db ->getdialupadminconfiguration(sql_groupcheck_table);
$sql_groupreply_table = $oreon_db ->getdialupadminconfiguration(sql_groupreply_table);
$sql_usergroup_table = $oreon_db ->getdialupadminconfiguration(sql_usergroup_table);
$sql_total_accounting_table = $oreon_db ->getdialupadminconfiguration(sql_total_accounting_table);
$sql_nas_table = $oreon_db ->getdialupadminconfiguration(sql_nas_table);
$sql_command = $oreon_db ->getdialupadminconfiguration(sql_command);
$general_snmp_type = $oreon_db ->getdialupadminconfiguration(general_snmp_type);
$general_snmpwalk_command = $oreon_db ->getdialupadminconfiguration(general_snmpwalk_command);
$general_snmpget_command = $oreon_db ->getdialupadminconfiguration(general_snmpget_command);
$sql_debug = $oreon_db ->getdialupadminconfiguration(sql_debug);
$sql_use_user_info_table = $oreon_db ->getdialupadminconfiguration(sql_use_user_info_table);
$sql_use_operators = $oreon_db ->getdialupadminconfiguration(sql_use_operators);
$sql_password_attribute = $oreon_db ->getdialupadminconfiguration(sql_password_attribute);
$sql_date_format = $oreon_db ->getdialupadminconfiguration(sql_date_format);
$sql_full_date_format = $oreon_db ->getdialupadminconfiguration(sql_full_date_format);
$sql_row_limit = $oreon_db ->getdialupadminconfiguration(sql_row_limit);
$sql_connect_timeout = $oreon_db ->getdialupadminconfiguration(sql_connect_timeout);
$sql_extra_servers = $oreon_db ->getdialupadminconfiguration(sql_extra_servers);
$counter_default_daily = $oreon_db ->getdialupadminconfiguration(counter_default_daily);
$counter_default_weekly = $oreon_db ->getdialupadminconfiguration(counter_default_weekly);
$counter_default_monthly = $oreon_db ->getdialupadminconfiguration(counter_default_monthly);
$counter_monthly_calculate_usage = $oreon_db ->getdialupadminconfiguration(counter_monthly_calculate_usage);

$filename = $phpradmin_dir .'conf/dialup_admin/conf/admin.conf';
$content =  "general_prefered_lang: $general_prefered_lang\n"
. "general_prefered_lang_name: $general_prefered_lang_name\n"
. "general_charset: $general_charset\n"
. "general_base_dir: $general_base_dir\n"
. "general_radiusd_base_dir: $general_radiusd_base_dir\n"
. "general_domain: $general_domain\n"
. "general_use_session: $general_use_session\n"
. "general_most_recent_fl: $general_most_recent_fl\n"
. "general_strip_realms: $general_strip_realms\n"
. "general_realm_delimiter: $general_realm_delimiter\n"
. "general_realm_format: $general_realm_format\n"
. "general_show_user_password: $general_show_user_password\n"
. "general_raddb_dir: $general_raddb_dir\n"
. "general_ldap_attrmap: $general_ldap_attrmap\n"
. "general_clients_conf: $general_clients_conf\n"
. "general_sql_attrmap: $general_sql_attrmap\n"
. "general_accounting_attrs_file: $general_accounting_attrs_file\n"
. "general_extra_ldap_attrmap: $general_extra_ldap_attrmap\n"
. "general_lib_type: $general_lib_type\n"
. "general_user_edit_attrs_file: $general_user_edit_attrs_file\n"
. "general_sql_attrs_file: $general_sql_attrs_file\n"
. "general_default_file: $general_default_file\n"
. "general_finger_type: $general_finger_type\n"
. "general_nas_type: $general_nas_type\n"
. "general_snmpfinger_bin: $general_snmpfinger_bin\n"
. "general_radclient_bin: $general_radclient_bin\n"
. "general_test_account_login: $general_test_account_login\n"
. "general_test_account_password: $general_test_account_password\n"
. "general_radius_server: $general_radius_server\n"
. "general_radius_server_port: $general_radius_server_port\n"
. "general_radius_server_auth_proto: $general_radius_server_auth_proto\n"
. "general_radius_server_secret: $general_radius_server_secret\n"
. "general_auth_request_file: $general_auth_request_file\n"
. "general_encryption_method: $general_encryption_method\n"
. "general_accounting_info_order: $general_accounting_info_order\n"
. "general_stats_use_totacct: $general_stats_use_totacct\n"
. "general_restrict_badusers_access: $general_restrict_badusers_access\n"
. "general_caption_finger_free_lines: $general_caption_finger_free_lines\n"
. "ldap_server: $ldap_server\n"
. "ldap_write_server: $ldap_write_server\n"
. "ldap_base: $ldap_base\n"
. "ldap_binddn: $ldap_binddn\n"
. "ldap_bindpw: $ldap_bindpw\n"
. "ldap_default_new_entry_suffix: $ldap_default_new_entry_suffix\n"
. "ldap_default_dn: $ldap_default_dn\n"
. "ldap_regular_profile_attr: $ldap_regular_profile_attr\n"
. "ldap_use_http_credentials: $ldap_use_http_credentials\n"
. "ldap_directory_manager: $ldap_directory_manager\n"
. "ldap_map_to_directory_manager: $ldap_map_to_directory_manager\n"
. "ldap_debug: $ldap_debug\n"
. "ldap_filter: $ldap_filter\n"
. "ldap_userdn: $ldap_userdn\n"
. "sql_type: $sql_type\n"
. "sql_server: $sql_server\n"
. "sql_port: $sql_port\n"
. "sql_username: $sql_username\n"
. "sql_password: $sql_password\n"
. "sql_database: $sql_database\n"
. "sql_accounting_table: $sql_accounting_table\n"
. "sql_badusers_table: $sql_badusers_table\n"
. "sql_check_table: $sql_check_table\n"
. "sql_reply_table: $sql_reply_table\n"
. "sql_user_info_table: $sql_user_info_table\n"
. "sql_groupcheck_table: $sql_groupcheck_table\n"
. "sql_groupreply_table: $sql_groupreply_table\n"
. "sql_usergroup_table: $sql_usergroup_table\n"
. "sql_total_accounting_table: $sql_total_accounting_table\n"
. "sql_nas_table: $sql_nas_table\n"
. "sql_command: $sql_command\n"
. "general_snmp_type: $general_snmp_type\n"
. "general_snmpwalk_command: $general_snmpwalk_command\n"
. "general_snmpget_command: $general_snmpget_command\n"
. "sql_debug: $sql_debug\n"
. "sql_use_user_info_table: $sql_use_user_info_table\n"
. "sql_use_operators: $sql_use_operators\n"
. "sql_password_attribute: $sql_password_attribute\n"
. "sql_date_format: $sql_date_format\n"
. "sql_full_date_format: $sql_full_date_format\n"
. "sql_row_limit: $sql_row_limit\n"
. "sql_connect_timeout: $sql_connect_timeout\n"
. "sql_extra_servers: $sql_extra_servers\n"
. "counter_default_daily: $counter_default_daily\n"
. "counter_default_weekly: $counter_default_weekly\n"
. "counter_default_monthly: $counter_default_monthly\n"
. "counter_monthly_calculate_usage: $counter_monthly_calculate_usage\n"
. "INCLUDE: ". $phpradmin_dir. "conf/dialup_admin/conf/naslist.conf\n"
. "INCLUDE: ". $phpradmin_dir . "conf/dialup_admin/conf/captions.conf\n";


// Let's make sure the file exists and is writable first.
if (is_writable($filename)) {

   // w = write, a = append (I use w to generate entire document.)
   if (!$handle = fopen($filename, 'w')) {
         echo "Cannot open file ($filename)";
         exit;
   }

   // Write $content to our opened file.
   if (fwrite($handle, $content) === FALSE) {
       echo "Cannot write to file ($filename)";
       exit;
   }
	print "<font color='green'>" . "Success, configuration has been saved to file ($filename)" . "</font><br>";
  
   fclose($handle);

} else {
	print "<br><font color='red'>" . "The file $filename do not exist or is not writable" . "</font><br>";
}
?> 