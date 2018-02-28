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
	if (!isset($oreon))
		exit();

	if (!isset($oreon->colors))
		$oreon->loadColors();

	$colors  = & $oreon->colors_list;

	if (isset($_POST["ChangeDAGEN"]))	{
		$opt_array = & $_POST["opt"];
		unset($oreon->daGen);
		$oreon->daGen = new daGen($opt_array);
		$oreon->savedagen($oreon->daGen);
		$msg = $lang["da_gen_save"];
	}
	if (isset($msg))
		echo "<div align='left' class='text12b' style='padding-top: 10px; padding-bottom: 10px;'>$msg</div>";


include_once ("class/Oreon.class.php");
include_once ("phpradmin.conf.php");

$oreon_db = new OreonDatabase($conf_pra["host"], $conf_pra["user"], $conf_pra["password"], $conf_pra["db"]);

?>

<form method="post" action="">
<table border="0" align="left" cellpadding="0" cellspacing="0">
<tr>
	<td class="tabTableTitle">Dialup Admin configuration</td>
</tr>
	<tr>
			<td class="tabTableForTab">
			<table cellpadding="4" cellspacing="4">
			<input name="opt[general_base_dir]" type="hidden" size="50" value="<? print $oreon->optGen->get_phpradmin_pwd();?>www/include/dialup_admin">
			<input name="opt[general_radiusd_base_dir]" type="hidden" size="50" value="<? print $oreon->optGen->get_radius_bin_pwd(); ?>">
			<tr>
				<td class="text11" width="30%">Domain</td>
				<td class="color1"><input name="opt[general_domain]" type="text" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(general_domain); ?>"></td>
				<td class="color1" width="10%" align="center"><img src="img/info.gif" ONMOUSEOVER="montre_legende('<? print $lang["general_domain"]; ?>','Help:');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="text11" width="30%">Most recent failed logins</td>
				<td class="color1" width="60%"><input name="opt[general_most_recent_fl]" type="text" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(general_most_recent_fl); ?>"></td>
				<td class="color1" width="10%" align="center"><img src="img/info.gif" ONMOUSEOVER="montre_legende('<? print $lang["general_most_recent_fl"]; ?>','Help:');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="text11" width="30%">Strip realms</td>
				<td class="color1"><input name="opt[general_strip_realms]" type="text" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(general_strip_realms); ?>"></td>
				<td class="color1" width="10%" align="center"><img src="img/info.gif" ONMOUSEOVER="montre_legende('<? print $lang["general_strip_realms"]; ?>','Help:');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="text11" width="30%">Realm delimiter</td>
				<td class="color1" width="60%"><input name="opt[general_realm_delimiter]" type="text" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(general_realm_delimiter); ?>"></td>
				<td class="color1" width="10%" align="center"><img src="img/info.gif" ONMOUSEOVER="montre_legende('<? print $lang["general_realm_delimiter"]; ?>','Help:');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<tr>
				<td class="text11" width="30%">Realm format</td>
				<td class="color1" width="60%"><input name="opt[general_realm_format]" type="text" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(general_realm_format); ?>" /></td>
				<td class="color1" width="10%" align="center"><img src="img/info.gif"  ONMOUSEOVER="montre_legende('<? print $lang["general_realm_format"]; ?>','Help:');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<input name="opt[general_raddb_dir]" type="hidden" size="50" value="<? print $oreon->optGen->get_radius_pwd(); ?>">
			<tr>
				<td class="text11" width="30%">Show user password</td>
				<td class="color1" width="60%">
					<select name="opt[general_show_user_password]">
							<option value="yes"<? if (!strcmp($oreon_db ->getdialupadminconfiguration(general_show_user_password), "yes")) print "selected"; ?>>yes</option>
							<option value="no"<? if (!strcmp($oreon_db ->getdialupadminconfiguration(general_show_user_password), "no")) print "selected"; ?>>no</option>
					</select>				</td>
				<td class="color1" width="10%" align="center"><img src="img/info.gif"  ONMOUSEOVER="montre_legende('<? print $lang["general_show_user_password"]; ?>','Help:');" ONMOUSEOUT="cache_legende();"></td>
			</tr>
			<input name="opt[general_prefered_lang_name]" type="hidden" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(general_prefered_lang_name); ?>">
			<input name="opt[general_prefered_lang]" type="hidden" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(general_prefered_lang); ?>">
			<input name="opt[general_charset]" type="hidden" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(general_charset); ?>">
			<input name="opt[general_use_session]" type="hidden" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(general_use_session); ?>">
			<input name="opt[general_ldap_attrmap]" type="hidden" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(general_ldap_attrmap); ?>">
			<input name="opt[general_clients_conf]" type="hidden" size="50" value="<? print $oreon->optGen->get_radius_pwd(); ?>clients.conf">
			<input name="opt[general_sql_attrmap]" type="hidden" size="50" value="<? print $oreon->optGen->get_phpradmin_pwd();?>conf/dialup_admin/conf/sql.attrmap">
			<input name="opt[general_accounting_attrs_file]" type="hidden" size="50"  value="<? print $oreon->optGen->get_phpradmin_pwd();?>conf/dialup_admin/conf/accounting.attrs">
			<input name="opt[general_extra_ldap_attrmap]" type="hidden" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(general_extra_ldap_attrmap); ?>">
			<input name="opt[general_lib_type]" type="hidden" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(general_lib_type); ?>">
			<input name="opt[general_user_edit_attrs_file]" type="hidden" size="50" value="<? print $oreon->optGen->get_phpradmin_pwd();?>conf/dialup_admin/conf/user_edit.attrs">
			<input name="opt[general_sql_attrs_file]" type="hidden" size="50" value="<? print $oreon->optGen->get_phpradmin_pwd();?>conf/dialup_admin/conf/sql.attrs">
			<input name="opt[general_default_file]" type="hidden" size="50" value="<? print $oreon->optGen->get_phpradmin_pwd();?>conf/dialup_admin/conf/default.vals">
			
<tr>
                                <td class="text11" width="30%">Finger type</td>
                                <td class="color1" width="60%"><input name="opt[general_finger_type]" type="text" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(general_finger_type); ?>"></td>
                                <td class="color1" width="10%" align="center"><img src="img/info.gif" ONMOUSEOVER="montre_legende('<? print $lang["general_finger_type"]; ?>','Help:');" ONMOUSEOUT="cache_legende();"></td>
                        </tr>
<tr>
                                <td class="text11" width="30%">NAS type</td>
                                <td class="color1" width="60%"><input name="opt[general_nas_type]" type="text" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(general_nas_type); ?>"></td>
                                <td class="color1" width="10%" align="center"><img src="img/info.gif" ONMOUSEOVER="montre_legende('<? print $lang["general_nas_type"]; ?>','Help:');" ONMOUSEOUT="cache_legende();"></td>
                        </tr>
			<input name="opt[general_snmpfinger_bin]" type="hidden" size="50" value="<? print $oreon->optGen->get_phpradmin_pwd();?>conf/dialup_admin/bin/snmpfinger">
<tr>
                                <td class="text11" width="30%">radclient command </td>
                                <td class="color1" width="60%"><input name="opt[general_radclient_bin]" type="text" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(general_radclient_bin); ?>"></td>
                                <td class="color1" width="10%" align="center"><img src="img/info.gif" ONMOUSEOVER="montre_legende('<? print $lang["general_radclient_bin"]; ?>','Help:');" ONMOUSEOUT="cache_legende();"></td>
                        </tr>
			<input name="opt[general_test_account_login]" type="hidden" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(general_test_account_login); ?>">
			<input name="opt[general_test_account_password]" type="hidden" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(general_test_account_password); ?>">
			<input name="opt[general_radius_server]" type="hidden" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(general_radius_server); ?>">
			<input name="opt[general_radius_server_port]" type="hidden" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(general_radius_server_port); ?>">
			<input name="opt[general_radius_server_auth_proto]" type="hidden" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(general_radius_server_auth_proto); ?>">
			<input name="opt[general_radius_server_secret]" type="hidden" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(general_radius_server_secret); ?>">
			<input name="opt[general_auth_request_file]" type="hidden" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(general_auth_request_file); ?>">
<tr>
                                <td class="text11" width="30%">Encryption method</td>
                                <td class="color1" width="60%"><input name="opt[general_encryption_method]" type="text" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(general_encryption_method); ?>"></td>
                                <td class="color1" width="10%" align="center"><img src="img/info.gif" ONMOUSEOVER="montre_legende('<? print $lang["general_encryption_method"]; ?>','Help:');" ONMOUSEOUT="cache_legende();"></td>
                        </tr>
<tr>
                                <td class="text11" width="30%">Accounting info order</td>
                                <td class="color1" width="60%"><input name="opt[general_accounting_info_order]" type="text" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(general_accounting_info_order); ?>"></td>
                                <td class="color1" width="10%" align="center"><img src="img/info.gif" ONMOUSEOVER="montre_legende('<? print $lang["general_accounting_info_order"]; ?>','Help:');" ONMOUSEOUT="cache_legende();"></td>
                        </tr>
<tr>
                                <td class="text11" width="30%">Stats use totacct</td>
                                <td class="color1" width="60%"><input name="opt[general_stats_use_totacct]" type="text" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(general_stats_use_totacct); ?>"></td>
                                <td class="color1" width="10%" align="center"><img src="img/info.gif" ONMOUSEOVER="montre_legende('<? print $lang["general_stats_use_totacct"]; ?>','Help:');" ONMOUSEOUT="cache_legende();"></td>
                        </tr>
			<input name="opt[general_restrict_badusers_access]" type="hidden" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(general_restrict_badusers_access); ?>">
<tr>
                                <td class="text11" width="30%">Caption finger free lines</td>
                                <td class="color1" width="60%"><input name="opt[general_caption_finger_free_lines]" type="text" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(general_caption_finger_free_lines); ?>"></td>
                                <td class="color1" width="10%" align="center"><img src="img/info.gif" ONMOUSEOVER="montre_legende('<? print $lang["general_caption_finger_free_lines"]; ?>','Help:');" ONMOUSEOUT="cache_legende();"></td>
                        </tr>
			<input name="opt[ldap_server]" type="hidden" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(ldap_server); ?>">
			<input name="opt[ldap_write_server]" type="hidden" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(ldap_write_server); ?>">		
			<input name="opt[ldap_base]" type="hidden" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(ldap_base); ?>">
			<input name="opt[ldap_binddn]" type="hidden" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(ldap_binddn); ?>">
			<input name="opt[ldap_bindpw]" type="hidden" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(ldap_bindpw); ?>">
			<input name="opt[ldap_default_new_entry_suffix]" type="hidden" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(ldap_default_new_entry_suffix); ?>">
			<input name="opt[ldap_default_dn]" type="hidden" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(ldap_default_dn); ?>">
			<input name="opt[ldap_regular_profile_attr]" type="hidden" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(ldap_regular_profile_attr); ?>">
			<input name="opt[ldap_use_http_credentials]" type="hidden" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(ldap_use_http_credentials); ?>">
			<input name="opt[ldap_directory_manager]" type="hidden" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(ldap_directory_manager); ?>">
			<input name="opt[ldap_map_to_directory_manager]" type="hidden" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(ldap_map_to_directory_manager); ?>">
			<input name="opt[ldap_debug]" type="hidden" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(ldap_debug); ?>">
			<input name="opt[ldap_filter]" type="hidden" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(ldap_filter); ?>">
			<input name="opt[ldap_userdn]" type="hidden" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(ldap_userdn); ?>">
			<input name="opt[sql_type]" type="hidden" size="50" value="<? print $conf_pra['dbtype']; ?>">
			<input name="opt[sql_server]" type="hidden" size="50" value="<? print $conf_pra['host']; ?>">
			<input name="opt[sql_port]" type="hidden" size="50" value="<? print $conf_pra['sqlport']; ?>">
			<input name="opt[sql_username]" type="hidden" size="50" value="<? print $conf_pra['user']; ?>">
			<input name="opt[sql_password]" type="hidden" size="50" value="<? print $conf_pra['password']; ?>">
			<input name="opt[sql_database]" type="hidden" size="50" value="<? print $conf_pra['db']; ?>">
			<input name="opt[sql_accounting_table]" type="hidden" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(sql_accounting_table); ?>">
			<input name="opt[sql_badusers_table]" type="hidden" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(sql_badusers_table); ?>">
			<input name="opt[sql_check_table]" type="hidden" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(sql_check_table); ?>">
			<input name="opt[sql_reply_table]" type="hidden" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(sql_reply_table); ?>">
			<input name="opt[sql_user_info_table]" type="hidden" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(sql_user_info_table); ?>">
			<input name="opt[sql_groupcheck_table]" type="hidden" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(sql_groupcheck_table); ?>">
			<input name="opt[sql_groupreply_table]" type="hidden" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(sql_groupreply_table); ?>">
			<input name="opt[sql_usergroup_table]" type="hidden" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(sql_usergroup_table); ?>">
			<input name="opt[sql_total_accounting_table]" type="hidden" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(sql_total_accounting_table); ?>">
			<input name="opt[sql_nas_table]" type="hidden" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(sql_nas_table); ?>">
<tr>
                                <td class="text11" width="30%">SQL client command</td>
                                <td class="color1" width="60%"><input name="opt[sql_command]" type="text" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(sql_command); ?>"></td>
                                <td class="color1" width="10%" align="center"><img src="img/info.gif" ONMOUSEOVER="montre_legende('<? print $lang["sql_command"]; ?>','Help:');" ONMOUSEOUT="cache_legende();"></td>
                        </tr>
<tr>
                                <td class="text11" width="30%">SNMP type</td>
                                <td class="color1" width="60%"><input name="opt[general_snmp_type]" type="text" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(general_snmp_type); ?>"></td>
                                <td class="color1" width="10%" align="center"><img src="img/info.gif" ONMOUSEOVER="montre_legende('<? print $lang["general_snmp_type"]; ?>','Help:');" ONMOUSEOUT="cache_legende();"></td>
                        </tr>
<tr>
                                <td class="text11" width="30%">snmpwalk command</td>
                                <td class="color1" width="60%"><input name="opt[general_snmpwalk_command]" type="text" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(general_snmpwalk_command); ?>"></td>
                                <td class="color1" width="10%" align="center"><img src="img/info.gif" ONMOUSEOVER="montre_legende('<? print $lang["general_snmpwalk_command"]; ?>','Help:');" ONMOUSEOUT="cache_legende();"></td>
                        </tr>
<tr>
                                <td class="text11" width="30%">snmpget command</td>
                                <td class="color1" width="60%"><input name="opt[general_snmpget_command]" type="text" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(general_snmpget_command); ?>"></td>
                                <td class="color1" width="10%" align="center"><img src="img/info.gif" ONMOUSEOVER="montre_legende('<? print $lang["general_snmpget_command"]; ?>','Help:');" ONMOUSEOUT="cache_legende();"></td>
                        </tr>
<tr>
                                <td class="text11" width="30%">SQL debug enabled</td>
                                <td class="color1" width="60%"><input name="opt[sql_debug]" type="text" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(sql_debug); ?>"></td>
                                <td class="color1" width="10%" align="center"><img src="img/info.gif" ONMOUSEOVER="montre_legende('<? print $lang["sql_debug"]; ?>','Help:');" ONMOUSEOUT="cache_legende();"></td>
                        </tr>
<tr>
                                <td class="text11" width="30%">SQL Use user info table</td>
                                <td class="color1" width="60%"><input name="opt[sql_use_user_info_table]" type="text" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(sql_use_user_info_table); ?>"></td>
                                <td class="color1" width="10%" align="center"><img src="img/info.gif" ONMOUSEOVER="montre_legende('<? print $lang["sql_use_user_info_table"]; ?>','Help:');" ONMOUSEOUT="cache_legende();"></td>
                        </tr>
<tr>
                                <td class="text11" width="30%">SQL Use operators</td>
                                <td class="color1" width="60%"><input name="opt[sql_use_operators]" type="text" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(sql_use_operators); ?>"></td>
                                <td class="color1" width="10%" align="center"><img src="img/info.gif" ONMOUSEOVER="montre_legende('<? print $lang["sql_use_operators"]; ?>','Help:');" ONMOUSEOUT="cache_legende();"></td>
                        </tr>
<tr>
                                <td class="text11" width="30%">SQL Password attribute</td>
                                <td class="color1" width="60%"><input name="opt[sql_password_attribute]" type="text" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(sql_password_attribute); ?>"></td>
                                <td class="color1" width="10%" align="center"><img src="img/info.gif" ONMOUSEOVER="montre_legende('<? print $lang["sql_password_attribute"]; ?>','Help:');" ONMOUSEOUT="cache_legende();"></td>
                        </tr>
<tr>
                                <td class="text11" width="30%">SQL date format</td>
                                <td class="color1" width="60%"><input name="opt[sql_date_format]" type="text" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(sql_date_format); ?>"></td>
                                <td class="color1" width="10%" align="center"><img src="img/info.gif" ONMOUSEOVER="montre_legende('<? print $lang["sql_date_format"]; ?>','Help:');" ONMOUSEOUT="cache_legende();"></td>
                        </tr>
<tr>
                                <td class="text11" width="30%">SQL full date format</td>
                                <td class="color1" width="60%"><input name="opt[sql_full_date_format]" type="text" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(sql_full_date_format); ?>"></td>
                                <td class="color1" width="10%" align="center"><img src="img/info.gif" ONMOUSEOVER="montre_legende('<? print $lang["sql_full_date_format"]; ?>','Help:');" ONMOUSEOUT="cache_legende();"></td>
                        </tr>
<tr>
                                <td class="text11" width="30%">SQL row limit</td>
                                <td class="color1" width="60%"><input name="opt[sql_row_limit]" type="text" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(sql_row_limit); ?>"></td>
                                <td class="color1" width="10%" align="center"><img src="img/info.gif" ONMOUSEOVER="montre_legende('<? print $lang["sql_row_limit"]; ?>','Help:');" ONMOUSEOUT="cache_legende();"></td>
                        </tr>
<tr>
                                <td class="text11" width="30%">SQL connect timeout</td>
                                <td class="color1" width="60%"><input name="opt[sql_connect_timeout]" type="text" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(sql_connect_timeout); ?>"></td>
                                <td class="color1" width="10%" align="center"><img src="img/info.gif" ONMOUSEOVER="montre_legende('<? print $lang["sql_connect_timeout"]; ?>','Help:');" ONMOUSEOUT="cache_legende();"></td>
                        </tr>
<tr>
                                <td class="text11" width="30%">SQL extra servers</td>
                                <td class="color1" width="60%"><input name="opt[sql_extra_servers]" type="text" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(sql_extra_servers); ?>"></td>
                                <td class="color1" width="10%" align="center"><img src="img/info.gif" ONMOUSEOVER="montre_legende('<? print $lang["sql_extra_servers"]; ?>','Help:');" ONMOUSEOUT="cache_legende();"></td>
                        </tr>
<tr>
                                <td class="text11" width="30%">Counter default daily</td>
                                <td class="color1" width="60%"><input name="opt[counter_default_daily]" type="text" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(counter_default_daily); ?>"></td>
                                <td class="color1" width="10%" align="center"><img src="img/info.gif" ONMOUSEOVER="montre_legende('<? print $lang["counter_default_daily"]; ?>','Help:');" ONMOUSEOUT="cache_legende();"></td>
                        </tr>
<tr>
                                <td class="text11" width="30%">Counter default weekly</td>
                                <td class="color1" width="60%"><input name="opt[counter_default_weekly]" type="text" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(counter_default_weekly); ?>"></td>
                                <td class="color1" width="10%" align="center"><img src="img/info.gif" ONMOUSEOVER="montre_legende('<? print $lang["counter_default_weekly"]; ?>','Help:');" ONMOUSEOUT="cache_legende();"></td>
                        </tr>
<tr>
                                <td class="text11" width="30%">Counter default monthly</td>
                                <td class="color1" width="60%"><input name="opt[counter_default_monthly]" type="text" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(counter_default_monthly); ?>"></td>
                                <td class="color1" width="10%" align="center"><img src="img/info.gif" ONMOUSEOVER="montre_legende('<? print $lang["counter_default_monthly"]; ?>','Help:');" ONMOUSEOUT="cache_legende();"></td>
                        </tr>
<tr>
                                <td class="text11" width="30%">Counter monthly calculate usage</td>
                                <td class="color1" width="60%"><input name="opt[counter_monthly_calculate_usage]" type="text" size="50" value="<? print $oreon_db ->getdialupadminconfiguration(counter_monthly_calculate_usage); ?>"></td>
                                <td class="color1" width="10%" align="center"><img src="img/info.gif" ONMOUSEOVER="montre_legende('<? print $lang["counter_monthly_calculate_usage"]; ?>','Help:');" ONMOUSEOUT="cache_legende();"></td>
                        </tr>
			</table>
	  </td>
					</tr>
					<tr>
						<td colspan="2" align="center" style="padding-top: 10px;"><input name="ChangeDAGEN" type="submit" value="<? print $lang["save"]; ?>"></td>
					</tr>
			</td>
		</tr>
	</table>
</form>
