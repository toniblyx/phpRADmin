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

/*
This file contains almost all text. This method facilitate us to do a multi-language tool.
It will be easy to guess what variables are corresponding to.
*/

/* Error Code */
$lang['errCode'][-2] = "Object definition not complete";
$lang['errCode'][-3] = "Object definition already exist";
$lang['errCode'][-4] = "Invalid Email, xxx@xxx.xx format";
$lang['errCode'][-5] = "Definition is circular";
$lang['errCode'][-6] = "You have to choose a Host or a Hostgroup";
$lang['errCode'][-7] = "Password is not correct";
$lang['errCode'][-8] = "The date of beginning must be lower than the completion date";
$lang['errCode'][-9] = "Some values are missing";
$lang['errCode'][2] = "Object definition has been changed";
$lang['errCode'][3] = "Object definition has been created";
$lang['errCode'][4] = "Password has been changed";
$lang['errCode'][5] = "Host has been duplicated";

/* menu */

$lang['m_home'] = "Home";
$lang['m_configuration'] = "Configuration";
$lang['m_monitoring'] = "Monitoring";
$lang['m_reporting'] = "Reporting";
$lang['m_graphs'] = "Graphs";
$lang['m_graphs_host'] = "Graphs by Host";
$lang['m_bbreport'] = "Reporting";
$lang['m_options'] = "Options";

$lang['m_host'] = "Host";
$lang['m_host_template_model'] = "Host Template Model";
$lang['m_hostgroup'] = "Host Group";
$lang['m_hostgroupesc'] = "Host Group Escalation";
$lang['m_host_extended_info'] = "Host Extended Infos";
$lang['m_extended_info'] = "Extended Infos";
$lang['m_hostesc'] = "Host Escalation";
$lang['m_host_dependencies'] = "Host Dependencies";
$lang['m_service'] = "Service";
$lang['m_servicegroup'] = "Service Group";
$lang['m_contact'] = "Contact";
$lang['m_contactgroup'] = "Contact Group";
$lang['m_timeperiod'] = "Time Period";
$lang['m_command'] = "Command";
$lang['m_service_extended_info'] = "Service Extended Infos";
$lang['m_service_dependencies'] = "Service Dependencies";
$lang['m_service_template_model'] = "Service Template Model";
$lang['m_serviceesc'] = "Service Escalation";
$lang['m_profile'] = "Your profile";
$lang['m_users_profile'] = "Users profile";
$lang['m_lang'] = "Language";
$lang['m_backup_db'] = "Database backup";
$lang['m_server_status'] = "Server status";
$lang['m_logout'] = "Logout";
$lang['m_apply'] = "Apply";
$lang['m_histo'] = "History";
$lang['m_tools'] = "Tools";
$lang['m_about'] = "About";
$lang['m_users'] = "Users";
$lang['m_configuration'] = "Configuration";
$lang['m_general'] = "General";
$lang['m_plugins'] = "Plugins";
$lang['m_updates'] = "Updates";
$lang['update_error_connect'] = "Unable to connect to update server";
$lang['m_trafficMap'] = "Traffic Map";
$lang['m_options_report'] = "Report options";
$lang['m_load_nagios_files'] = "Load a Nagios conf";
$lang['m_auto_detect'] = "Auto Detect";
$lang['m_notification'] = "Notification";
$lang['m_check'] = "Check";
$lang['m_nagios'] = "Nagios";
$lang['m_delete_selection'] = "Delete selection";
$lang['m_is_connected'] = "Who is connected" ;

$lang['m_graph_template'] = "Graph model";

$lang["m_host_detail"] = "Host detail";
$lang["m_service_detail"] = "Service detail";
$lang["m_hosts_problems"] = "Hosts problems";
$lang["m_services_problems"] = "Services problems";
$lang["m_hostgroup_detail"] = "Host Group detail";
$lang["m_servicegroup_detail"] = "Service Group detail";
$lang["m_status_scheduling"] = "Status and scheduling";
$lang["m_status_summary"] = "Status Summary";
$lang["m_status_grid"] = "Status Grid";
$lang["m_scheduling"] = "Scheduling Queue";
$lang["m_process_info"] = "Process Info";
$lang["m_event_log"] = "Event Log";
$lang["m_downtime"] = "Downtime";
$lang["m_comments"] = "Comments";
$lang["m_inventory"] = "Inventory";

$lang["m_report_custom"] = "Log report";
$lang["m_traffic_map"] = "Traffic Map";

$lang["m_dev"] = "Development";

$lang["m_notifications"] = "Notifications";
$lang["m_alerts"] = "Alertes history";

/* Dictionary - Plugins */

$lang["plugins1"] = "Dictionary deleted";
$lang["plugins2"] = "Are you sure you want to delete this dictionary? ";
$lang["plugins3"] = "Dictionary sent";
$lang["plugins4"] = "A error occured during Plugin upload. May be a rights problem. Try unloking first.";
$lang["plugins5"] = "A error occured during &#146;phpradmin.conf&#146; file creation. May be a right problem. Try unloking first";
$lang["plugins6"] = "Generated file";
$lang["plugins_add"] = "Add dictionary for RADIUS";
$lang["dictionaries"] = "Dictionaries";
$lang["dictionary_list"] = "List of dictionaries";
$lang["plugins_pm_conf"] = "phpradmin.conf";
$lang["plugins_pm_conf_desc"] = "Generate configuration file for Oreon.pm with informations include in General menu";
$lang["upload"] = "Upload";


/* index100 */

$lang['ind_infos'] = "In this section, you can manage users to authenticate";
$lang['ind_detail'] = "---";

/* index */

$lang['ind_first'] = "You are already connected to phpRADmin, firstly, close the other session<br>If this window is only the first windo you&acute;ve got, click";

/* alt main */

$lang['am_intro'] = "monitoring now :";
$lang['host_health'] = "Host health";
$lang['service_health'] = "Service health";
$lang['network_health'] = "Network health";
$lang['am_hg_vdetail'] = 'View Hostgroup details';
$lang['am_sg_vdetail'] = 'View Servicegroup details';
$lang['am_hg_detail'] = 'Hostgroup details';
$lang['am_sg_detail'] = 'Servicegroup details';

/* Monitoring */

$lang['mon_last_update'] = "Last update :";
$lang['mon_up'] = "UP";
$lang['mon_down'] = "DOWN";
$lang['mon_unreachable'] = "UNREACHABLE";
$lang['mon_ok'] = "OK";
$lang['mon_critical'] = "CRITICAL";
$lang['mon_warning'] = "WARNING";
$lang['mon_pending'] = "PENDING";
$lang['mon_unknown'] = "UNKNOWN";
$lang['mon_status'] = "Status";
$lang['mon_ip'] = "IP";
$lang['mon_last_check'] = "Last Check";
$lang['mon_next_check'] = "Next Check";
$lang['mon_active_check'] = "Active Check";
$lang['mon_duration'] = "Duration";
$lang['mon_retry'] = "Retry";
$lang['mon_status_information'] = "Status information";
$lang['mon_service_overview_fah'] = "Service Overview For All Host Groups";
$lang['mon_service_overview_fas'] = "Service Overview For All Service Groups";
$lang['mon_status_summary_foh'] = "Status Summary For All Host Groups";
$lang['mon_status_grid_fah'] = "Status Grid for ALL Host Groups";
$lang['mon_sv_hg_detail1'] = "Service details";
$lang['mon_sv_hg_detail2'] = "for Host Group";
$lang['mon_sv_hg_detail3'] = "for Host";
$lang['mon_host_status_total'] = "Host Status Total";
$lang['mon_service_status_total'] = "Service Status Total";
$lang['mon_scheduling'] = "Scheduling queue";
$lang['mon_actions'] = "Actions";
$lang['mon_active'] = "ACTIVE";
$lang['mon_inactive'] = "INACTIVE";
$lang['mon_request_submit_host'] = "Your request had been submitted. <br><br>You&#146;re gonna be send at the Host page'.";
$lang['Details'] = "Details";

/* Monitoring command */

$lang['mon_hg_commands'] = "Host Group Commands";
$lang['mon_h_commands'] = "Host Commands";
$lang['mon_sg_commands'] = "Service Group Commands";
$lang['mon_s_commands'] = "Service Commands";
$lang['mon_no_stat_for_host'] = "No stat for this Host.<br><br> Think has generate the configuration files.";
$lang['mon_no_stat_for_service'] = "No stat for this Service.<br><br> Think has generate the configuration files.";
$lang['mon_hg_cmd1'] = "Schedule downtime for all hosts in this hostgroup";
$lang['mon_hg_cmd2'] = "Schedule downtime for all services in this hostgroup";
$lang['mon_hg_cmd3'] = "Enable notifications for all hosts in this hostgroup";
$lang['mon_hg_cmd4'] = "Disable notifications for all hosts in this hostgroup";
$lang['mon_hg_cmd5'] = "Enable notifications for all services in this hostgroup";
$lang['mon_hg_cmd6'] = "Disable notifications for all services in this hostgroup";
$lang['mon_hg_cmd7'] = "Enable checks of all services in this hostgroup";
$lang['mon_hg_cmd8'] = "Disable checks of all services in this hostgroup";
$lang['mon_host_state_info'] = "Host State Information";
$lang['mon_host_status'] = "Host Status";
$lang['mon_status_info'] = "Status Information";
$lang['mon_last_status_check'] = "Last Status Check";
$lang['mon_status_data_age'] = "Status Data Age";
$lang['mon_current_state_duration'] = "Current State Duration";
$lang['mon_last_host_notif'] = "Last Host Notification";
$lang['mon_current_notif_nbr'] = "Current Notification Number";
$lang['mon_is_host_flapping'] = "Is This Host Flapping ?";
$lang['mon_percent_state_change'] = "Percent State Change";
$lang['mon_is_sched_dt'] = "Is Scheduled Downtime ?";
$lang['mon_last_update'] = "Last Update";
$lang['mon_sch_imm_cfas'] = "Schedule an immediate check of all services";
$lang['mon_sch_dt'] = "Schedule downtime";
$lang['mon_dis_notif_fas'] = "Disable notifications for all services";
$lang['mon_enable_notif_fas'] = "Enable notifications for all services";
$lang['mon_dis_checks_fas'] = "Disable checks of all services";
$lang['mon_enable_checks_fas'] = "Enable checks of all services";
$lang['mon_service_state_info'] = "Service State Information";
$lang['mon_service_status'] = "Service State";
$lang['mon_current_attempt'] = "Current Attempt";
$lang['mon_state_type'] = "State Type";
$lang['mon_last_check_type'] = "Last Check Type";
$lang['mon_last_check_time'] = "Last Check Time";
$lang['mon_next_sch_active_check'] = "Next Scheduled Active Check";
$lang['mon_last_service_notif'] = "Last Service Notification";
$lang['mon_is_service_flapping'] = "Is This Service Flapping ?";
$lang['mon_percent_state_change'] = "Percent State Change";
$lang['mon_checks_for_service'] = "checks of this service";
$lang['mon_accept_pass_check'] = "accepting passive checks for this service";
$lang['mon_notif_service'] = "notifications for this service";
$lang['mon_eh_service'] = "event handler for this service";
$lang['mon_fp_service'] = "flap detection for this service";
$lang['mon_submit_pass_check_service'] = "Submit passive check result for this service";
$lang['mon_sch_dt_service'] = "Schedule downtime for this service";
$lang['mon_service_check_executed'] = "Service Checks Being Executed";
$lang['mon_passive_service_check_executed'] = "Passive Service Checks Being Accepted";
$lang['mon_eh_enabled'] = "Event Handlers Enabled";
$lang['mon_obess_over_services'] = "Obsessing Over Services";
$lang['mon_fp_detection_enabled'] = "Flap Detection Enabled";
$lang['mon_perf_data_process'] = "Performance Data Being Processed";
$lang['mon_request_submit_host'] = "Your request has been recorded<br><br>You&#146;re gonna be redirected to the host page.";
$lang['mon_process_infos'] = "Process Informations";
$lang['mon_process_start_time'] = "Program Start Time";
$lang['mon_total_run_time'] = "Total Running Time";
$lang['mon_last_ext_command_check'] = "Last External Command Check";
$lang['mon_last_log_file_rotation'] = "Last Log File Rotation";
$lang['mon_nagios_pid'] = "Nagios PID";
$lang['mon_process_cmds'] = "Process Commands";
$lang['mon_stop_nagios_proc'] = "Stop the Nagios Process";
$lang['mon_start_nagios_proc'] = "Start the Nagios Process";
$lang['mon_restart_nagios_proc'] = "Restart the Nagios Process";
$lang['mon_proc_options'] = "Process Options";
$lang['mon_notif_enabled'] = "Notifications Enabled";
$lang['mon_notif_disabled'] = "Notifications Disabled";
$lang['mon_service_check_disabled'] = "Service Check Disabled";
$lang['mon_service_check_passice_only'] = "Passive Check Only";
$lang['mon_service_view_graph'] = "View graph";
$lang['mon_service_sch_check'] = "Schedule an immediate check of this service";

/* comments */

$lang['cmt_service_comment'] = "Service Comments";
$lang['cmt_host_comment'] = "Host Comments";
$lang['cmt_addH'] = "Add a Host comment";
$lang['cmt_addS'] = "Add a Service comment";
$lang["cmt_added"] = "Comment added with succes. <br><br>Click <a href='./phpradmin.php?p=307' class='text11b'>here</a> to return to the comments page. ";
$lang["cmt_del"] = "Comment deleted with succes. <br><br>Click <a href='./phpradmin.php?p=307' class='text11b'>here</a> to return to the comments page. ";
$lang["cmt_del_all"] = "All Comments deleted with succes. <br><br>Click <a href='./phpradmin.php?p=307' class='text11b'>here</a> to return to the comments page. ";
$lang['cmt_host_name'] = "Host Name";
$lang['cmt_entry_time'] = "Entry Time";
$lang['cmt_author'] = "Author";
$lang['cmt_comment'] = "Comment";
$lang['cmt_persistent'] = "Persistent";
$lang['cmt_actions'] = "Actions";

/* downtime */

$lang['dtm_addH'] = "Add a Host downtime";
$lang['dtm_addS'] = "Add a Service downtime";
$lang['dtm_addHG'] = "Add a Host Group downtime";
$lang['dtm_added'] = "Downtime added with succes. <br><br>Click <a href='./phpradmin.php?p=308' class='text11b'>here</a> to return to the Downtimes page. ";
$lang['dtm_del'] = "Downtime deleted with succes. <br><br>Click <a href='./phpradmin.php?p=308' class='text11b'>here</a> to return to the Downtimes page. ";
$lang['dtm_start_time'] = "Start Time";
$lang['dtm_end_time'] = "End Time";
$lang['dtm_fixed'] = "Fixed";
$lang['dtm_duration'] = "Duration";
$lang['dtm_sch_dt_fht'] = "Schedule Downtime For Hosts Too";
$lang['dtm_host_downtimes'] = "Host Downtimes";
$lang['dtm_service_downtimes'] = "Service Downtimes";
$lang['dtm_dt_no_file'] = "Downtime file not found";
$lang['dtm_host_delete'] = "Delete host downtime";

/* cmd externe */

$lang['cmd_utils'] = 'Useful';
$lang["cmd_send"] = "Your command has been send";
$lang["cmd_ping"] = "Ping";
$lang["cmd_traceroute"] = "Traceroute.";

/* actions & recurrent text */

$lang['home'] = "Home";
$lang['oreon'] = "Oreon";
$lang['add'] = "Add";
$lang['dup'] = "Duplicate";
$lang['save'] = "Save";
$lang['modify'] = "Modify";
$lang['delete'] = "Delete";
$lang['update'] = "Update";
$lang['ex'] = "Example ";
$lang['name'] = "Name ";
$lang['alias'] = "Alias ";
$lang['user'] = "User ";
$lang['here'] = "here";
$lang['this'] = "this";
$lang['confirm_removing'] = "Are you sure you want to delete this item ?";
$lang['confirm_update'] = "Are you sure you want to update the traffic map ?";
$lang['file_exist'] = "Sorry the file already exist.";
$lang['uncomplete_form'] = "Uncomplete form or invalid";
$lang['none'] = "none";
$lang['already_logged'] = "You are already connected to phpRADmin, close firstly the other session. <br> If this window is the only phpRADmin window, click <br><a href='?disconnect=1' class='text11b'>here</a>";
$lang['not_allowed'] = "You are not allowed to reach this page";
$lang['usage_stats'] = "Statistics usage";
$lang['check'] = "Check";
$lang['uncheck'] = "Uncheck";
$lang['options'] = "Options";
$lang['status'] = "Status";
$lang['status_options'] = "Status and options";
$lang['details'] = "D&eacute;tails";
$lang['back'] = "Retour";
$lang['view'] = "View";
$lang['choose'] = "Choose";
$lang['enable'] = "Enabled";
$lang['disable'] = "Disabled";
$lang['yes'] = "Yes";
$lang['no'] = "No";
$lang['description'] = "Description";
$lang['page'] = "Page";
$lang['required'] = "<font color='red'>*</font> required";
$lang['nbr_per_page'] = "Nbr per page";
$lang['reset'] = "Reset";
$lang['time_sec'] = " seconds ";
$lang['time_min'] = " minutes ";
$lang['time_hours'] = " Hours ";
$lang['time_days'] = " Days ";
$lang['size'] = "Size";

/* host */

$lang['h_available'] = "Available Host";
$lang['h'] = "Host ";
$lang['h_services'] = "Associated Service(s)";
$lang['h_hostgroup'] = "Associated Host Group(s)";
$lang['h_dependancy'] = "Belonging Host Groups ";
$lang['h_nbr_dup'] = "Quantity to duplicate";

/* extended host infos */

$lang['ehi'] = "Extended Host Informations";
$lang['ehi_available'] = "Available extended informations for Hosts ";
$lang['ehi_notes'] = "Note";
$lang['ehi_notes_url'] = "Note address";
$lang['ehi_action_url'] = "Action url";
$lang['ehi_icon_image'] = "Icon image";
$lang['ehi_icon_image_alt'] = "Icon image alt";

/* host template model*/

$lang['htm_available'] = "Host(s) Template(s) Model(s) available(s)";
$lang['htm'] = "Host Template Model ";
$lang['htm_use'] = "Use a Host Template Model";
$lang['htm_stats1'] = "This Template Model is used by ";

/* host group */

$lang['hg_title'] = "Host Groups ";
$lang['hg_available'] = "Available Host Group(s)";
$lang['hg'] = "Host Groups";
$lang['hg_belong'] = "Host Groups belonged";

/* host group escalation */

$lang['hge'] = "Host Group Escalations";
$lang['hge_available'] = "Available(s) Host Group escalation";

/* host escalation */

$lang['he'] = "Host Escalations";
$lang['he_available'] = "Available(s) Host Escalation";

/* host dependencies */

$lang['hd'] = "Host Dependencies";
$lang['hd_available'] = "available Host Dependencies";
$lang['hd_dependent'] = "Host Dependent";

/* host template model */

$lang['htm'] = "Host Template Model";
$lang['htm_u'] = "Use as a Host Template Model";
$lang['htm_v'] = "Use Template in Host monitoring";

/* service escalation */

$lang['se'] = "Service Escalation";
$lang['se_available'] = "Available(s) Service Escalation";

/* service */

$lang['s_ping_response'] = "ping response";
$lang['s_logged_users'] = "logged users";
$lang['s_free_disk_space'] = "free disk space";
$lang['s_available'] = "Available Services";
$lang['s_contact_groups'] = "Contact Groups :";
$lang['s'] = "Service";

/* extended service infos */

$lang['esi'] = "Extended Service Informations";
$lang['esi_available'] = "Available Extended Informations for Services ";
$lang['esi_notes'] = "Note";
$lang['esi_notes_url'] = "Note address";
$lang['esi_action_url'] = "Action url";
$lang['esi_icon_image'] = "Icon image";
$lang['esi_icon_image_alt'] = "Icon image alt";

/* service template model*/

$lang['stm_available'] = "Service(s) Template(s) Model(s) available(s)";
$lang['stm'] = "Service Template Model ";
$lang['stm_use'] = "Use a Service Template Model";
$lang['stm_stats1'] = "This Template Model is used by ";

/* service dependencies */

$lang['sd'] = "Service Dependencie";
$lang['sd_available'] = "available Service Dependencies";
$lang['sd_dependent'] = "Service Dependent";

/* service group*/

$lang['sg_available'] = "Available Service Group";
$lang['sg'] = "Service Group";

/* contact */

$lang['c_available'] = "Available Contact(s)";
$lang['c'] = "Contact";
$lang['c_use'] = "This Contact is use in the Contact Groups :";

/* contact group */

$lang['cg_title'] = "Contact Group";
$lang['cg_available'] = "Availables Contact Groups";
$lang['cg'] = "Contact Group";
$lang['cg_related'] = " is used with ";

/* time period */

$lang['tp_title'] = "Time Period";
$lang['tp_notifications'] = "notifications ";
$lang['tp_service_check'] = "service check ";
$lang['tp_name'] = "Time Period name";
$lang['tp_alias'] = "Alias ";
$lang['tp_sunday'] = "Sunday ";
$lang['tp_monday'] = "Monday ";
$lang['tp_tuesday'] = "Tuesday ";
$lang['tp_wednesday'] = "Wednesday ";
$lang['tp_thursday'] = "Thursday ";
$lang['tp_friday'] = "Friday ";
$lang['tp_saturday'] = "Saturday ";
$lang['tp_available'] = "Available Time Period";
$lang['tp'] = "Time Period(s) ";
$lang['tp_more_ex'] = " is used like a check Command on following Hosts :";
$lang['tp_more_ex2'] ="is like an event handler on following Hosts :";

/* command */

$lang['cmd_title'] = "Command";
$lang['cmd_notifications'] = "Service notifications ";
$lang['cmd_service_check'] = "Service check ";
$lang['cmd_event'] = "Service event handler ";
$lang['cmd_host_check'] = "Host check ";
$lang['cmd_host_notifications'] = "Host notifications ";
$lang['cmd_host_event_handler'] = "Host event handler ";
$lang['cmd_comment'] = "Command definitions can contain macros, but you must make sure that you include only those macros that are &quot;valid&quot; for the circumstances when the command will be used.";
$lang['cmd_macro_infos'] = "More informations about macro can be found here :";
$lang['ckcmd_available'] = "Available Check-Command(s)";
$lang['ntcmd_available'] = "Available Notification-Command(s)";
$lang['cmd_name'] = "Command name";
$lang['cmd_line'] = "Command line ";
$lang['cmd'] = "Command(s) ";
$lang['cmd_more_ex'] = " is used like a check command on following hosts :";
$lang['cmd_more_ex2'] =" is used like an event_Handler on following hosts :";
$lang['cmd_type'] = "Command type";

/* Load Nagios CFG */

$lang['nfc_generated_by_oreon'] = 'Are the files generated with Oreon ?';
$lang['nfc_targz'] = 'You have to upload a tar.gz file';
$lang['nfc_limit'] = 'To load a Nagios configuration, you have to :<ul><li>Specify at least the misccommands.cfg and checkcommands.cfg files</li><li>Other definition can be in any file you want</li><li>Oreon doesn\'t manage the Nagios time-saving tricks</li></ul>';
$lang['nfc_enum'] = "Hosts, services, contacts, commands, escalations, templates....";
$lang['nfc_ncfg'] = "Nagios.cfg";
$lang['nfc_rcfg'] = "Resource.cfg";
$lang['nfc_ncfgFile'] = "Nagios.cfg file";
$lang['nfc_rcfgFile'] = "Resource.cfg file";
$lang['nfc_fileUploaded'] = "Files uploaded correctly";
$lang['nfc_extractComplete'] = "Extract Complete";
$lang['nfc_unzipComplete'] = "Unzip Complete";
$lang['nfc_unzipUncomplete'] = "Unzip Uncomplete";
$lang['nfc_uploadComplete'] = "Upload Complete";

/* profile */

$lang['profile_h_name'] = "Name";
$lang['profile_h_contact'] = "Contact";
$lang['profile_h_location'] = "Location";
$lang['profile_h_uptime'] = "Uptime";
$lang['profile_h_os'] = "Operating system";
$lang['profile_h_interface'] = "Interface";
$lang['profile_h_ram'] = "Memory";
$lang['profile_h_disk'] = "Disk";
$lang['profile_h_software'] = "Software";
$lang['profile_h_update'] = "Windows update";
$lang['profile_s_network'] = "By network";
$lang['profile_s_os'] = "By operating system";
$lang['profile_s_software'] = "By software";
$lang['profile_s_update'] = "By Windows update";
$lang['profile_s_submit'] = "search";
$lang['profile_o_system'] = "System";
$lang['profile_o_network'] = "Network";
$lang['profile_o_storage'] = "Storage";
$lang['profile_o_software'] = "Software";
$lang['profile_o_live_update'] = "Live update";
$lang['profile_h_ip'] = "IP";
$lang['profile_h_speed'] = "Speed";
$lang['profile_h_mac'] = "Mac";
$lang['profile_h_status'] = "Status";
$lang['profile_h_used_space'] = "Used space";
$lang['profile_h_size'] = "Size";
$lang['profile_h_partition'] = "Partition";
$lang['profile_h_list_host'] = "Select your server";
$lang['profile_menu_list'] = "Hosts";
$lang['profile_menu_search'] = "Search";
$lang['profile_menu_options'] = "Inventory";
$lang['profile_search_results'] = "Search results for :";
$lang['profile_title_partition'] = "Partition";
$lang['profile_title_size'] = "Size";
$lang['profile_title_used_space'] = "Used space";
$lang['profile_title_free_space'] = "Free space";
$lang['profile_error_snmp'] = "The SNMP deamon does not seem to running on host target";

/* db */

$lang['db_cannot_open'] = "File cannot be open :";
$lang['db_cannot_write'] = "Unable to write into file :";
$lang['db_genesis'] = "Generate configuration files";
$lang['db_file_state'] = "Generated files's current state :";
$lang['db_create_backup'] = "You should backup before creating new configuration file";
$lang['db_create'] = "Create Database";
$lang['db_generate'] = "Generate";
$lang['db_nagiosconf_backup'] = "Nagios configuration backup ";
$lang['db_backup'] = "phpRADmin database backup";
$lang['db_nagiosconf_backup_on_server'] = "Backup Nagios configuration on server.";
$lang['db_backup_spec_users'] = "backup user's configuration ";
$lang['db_insert_new_database'] = "Insert a new database";
$lang['db_reset_old_conf'] = "Load an old registered configuration";
$lang['db_extract'] = "Extract";
$lang['db_execute'] = "Execute";
$lang['db_save'] = "Save";
$lang["DB_status"] = "DataBase Statistics";
$lang["db_lenght"] = "Lenght";
$lang["db_nb_entry"] = "Entries Number";
$lang["db_datafree"] = "Free Data";

/* user */

$lang['u_list'] = "Users&acute;s list";
$lang['u_admin_list'] = "Administrator list";
$lang['u_sadmin_list'] = "Super administrator list";
$lang['u_user'] = "User";
$lang['u_administrator'] = "Administrator";
$lang['u_sadministrator'] = "Super administrator";
$lang['u_profile'] = "Your profile";
$lang['u_new_profile'] = "New profile";
$lang['u_some_profile'] = "Profile for ";
$lang['u_name'] = "Name ";
$lang['u_lastname'] = "Lastname ";
$lang['u_login'] = "Login ";
$lang['u_passwd'] = "Password ";
$lang['u_cpasswd'] = "Change password";
$lang['u_ppasswd'] = "Confirm password ";
$lang['u_email'] = "Email ";
$lang['u_lang'] = "Choosen language ";
$lang['u_status'] = "Status ";
$lang['u_delete_profile'] = "delete this profile";

/* lang */

$lang['lang_infos'] = "There is already ";
$lang['lang_infos2'] = "different languages reday to use.";
$lang['lang_infos3'] = "If you want to add a new one. You have to upload a file in the following form. ";
$lang['lang_detail'] = "This file should have same fields like ";
$lang['lang_detail2'] = "in the choosen language";

/* bug resolver */

$lang['bug_infos'] = "On this page, you can erase all relations beetween ressources and database content which can contents errors if there is a bug.";
$lang['bug_action'] = "Click here if you want to reset database if you get bugs while tests step, thanks to report us which step failed.";
$lang['bug_kick'] = "Reset it";

/* Parseenevlog */

$lang['hours'] = "Hours";

/* Log report */

$lang['add_report'] = "The report has been added";
$lang['change_report'] = "The report has been changed";
$lang['add_reportHost'] = "A new Host has been added";
$lang['add_reportService'] = "Service(s) has been added";
$lang['daily_report'] = "Daily report (choose format)";
$lang['report_select_host'] = "select host";
$lang['report_select_service'] = "one of his services (not required)";
$lang['report_select_period'] = "select a period";
$lang['report_sp'] = "start period";
$lang['report_ep'] = "end period";
$lang['report_generate_pdf'] = "Generate PDF report";
$lang['custom_start_date'] = "custom start date";
$lang['custom_end_date'] = "custom end date";
$lang['report_change_host'] = "change host";
$lang['custom_report'] = "Custom Report";
$lang['report_color_up'] = "Color UP";
$lang['report_color_down'] = "Color DOWN";
$lang['report_color_unreachable'] = "Color UNREACHABLE";
$lang['report_color_ok'] = "Color OK";
$lang['report_color_warning'] = "Color WARNING";
$lang['report_color_critical'] = "Color CRITICAL";
$lang['report_color_unknown'] = "Color UNKNOWN";
$lang['report_kindof_report'] = "There is 3 kind of report";
$lang['report_daily_report'] = "The Actual Nagios status Report";
$lang['report_daily_report_explain'] = "It interprets this file :";
$lang['report_daily_report_availability'] = "Available in those formats :";
$lang['report_spec_info'] = "The specific information report";
$lang['report_spec_info_explain'] = "You can easily check immediately an host or/and his associated service(s) like :";
$lang['report_spec_info_ex1'] = "Host status during a specific period";
$lang['report_spec_info_ex2'] = "Service status during a specific period";
$lang['report_spec_info_ex3'] = "All services status associated to a host during a specific period";
$lang['available'] = "Available in those formas :";
$lang['report_cont_info'] = "The continous information report";
$lang['report_cont_info_explain'] = "Used if you want to get information on each interval you have selected, it works like :";
$lang['report_cont_info_ex1'] = "notification by mail every day of status from the day before of a host(s)/services(s) selection";
$lang['report_cont_info_ex2'] = "notification by mail every week of status from the week before of a host(s)/services(s) selection";
$lang['report_cont_info_ex3'] = "notification by mail everymonth of status from the month before of a host(s)/services(s) selection";
$lang['report_logs_explain'] = "Those logs restart every time Nagios is shutting down";

/* Traffic Map */

$lang['tm_update'] = "The Traffic Map has been updated";
$lang['tm_available'] = "Traffic Map available";
$lang['tm_add'] = "Traffic Map add";
$lang['tm_modify'] = "Traffic Map modify";
$lang['tm_delete'] = "Traffic Map removed";
$lang['tm_addHost'] = "A new Host had been added to the traffic map";
$lang['tm_changeHost'] = "The Host has been changed";
$lang['tm_deleteHost'] = "The Host has been removed";
$lang['tm_addRelation'] = "A new relation had been added";
$lang['tm_changeRelation'] = "The relation has been changed";
$lang['tm_deleteRelation'] = "The relation has been removed";
$lang['tm_hostServiceAssociated'] = "Hosts with a service check_traffic associated";
$lang['tm_checkTrafficAssociated'] = "Check_traffic associated";
$lang['tm_other'] = "Other ressources (without check_traffic)";
$lang['tm_networkEquipment'] = "Network equipment";
$lang['tm_selected'] = "selected";
$lang['tm_maxBWIn'] = "Max bandwith possible In (Kbps)";
$lang['tm_maxBWOut'] = "Max bandwith possible Out (Kbps)";
$lang['tm_background'] = "Background image";

/* Graphs */

$lang['graph'] = "Graph";
$lang['graphs'] = "Graphs";
$lang['g_title'] = "Graphs";
$lang['g_available'] = "Graphs available";
$lang['g_path'] = "Path of the RRDtool data-base";
$lang['g_imgformat'] = "Picture format";
$lang['g_verticallabel'] = "Vertical label";
$lang['g_width'] = "Picture size - width";
$lang['g_height'] = "Picture size - height";
$lang['g_lowerlimit'] = "Lower limit";
$lang['g_Couleurs'] = "Colors : ";
$lang['g_ColGrilFond'] = "Central graph background color";
$lang['g_ColFond'] = "Background color";
$lang['g_ColPolice'] = "Font color";
$lang['g_ColGrGril'] = "Main grid color";
$lang['g_ColPtGril'] = "Second grid color";
$lang['g_ColContCub'] = "Cube color";
$lang['g_ColArrow'] = "Arrow option color";
$lang['g_ColImHau'] = "Up picture - color";
$lang['g_ColImBa'] = "Down picture - color";
$lang['g_dsname'] = "Name of the data source";
$lang['g_ColDs'] = "Data source color";
$lang['g_flamming'] = "Flamming color";
$lang['g_Area'] = "Area";
$lang['g_tickness'] = "Tickness";
$lang['g_gprintlastds'] = "Show the last calculated value";
$lang['g_gprintminds'] = "Show the min calculated value";
$lang['g_gprintaverageds'] = "Show the average calculated value";
$lang['g_gprintmaxds'] = "Show the max calculated value";
$lang['g_graphorama'] = "GraphsVision";
$lang['g_graphoramaerror'] = "The date of beginning must be lower than the completion date";
$lang['g_date_begin'] = "Start time";
$lang['g_date_end'] = "End time";
$lang['g_hours'] = "Hours";
$lang['g_number_per_line'] = "Number per line";
$lang['g_height'] = "Weight";
$lang['g_width'] = "Width";
$lang['g_basic_conf'] = "Basic configuration :";
$lang['g_ds'] = "Data source";
$lang['g_lcurrent'] = "Current";
$lang['g_lday'] = "Last day";
$lang['g_lweek'] = "last week";
$lang['g_lyear'] = "Last year";
$lang['g_see'] = "See graph associated";
$lang['g_from'] = "From ";
$lang['g_to'] = " To ";
$lang['g_current'] = "Current:";
$lang['g_average'] = "Average:";
$lang['g_no_graphs'] = "No graph available";
$lang['g_no_access_file'] = "File %s is not accessible";

/* Graph Models */

$lang['gmod'] =  'Basic properties';
$lang['gmod_ds'] =  'Data source';
$lang['gmod_available'] = 'Graph properties models available';
$lang['gmod_ds_available'] = 'Graph DS models available';
$lang['gmod_use_model'] = 'Use a model';

/* Colors */
$lang['colors'] =  "Colors";
$lang['hexa'] =  "Color in hexadecimal";

/* Nagios.cfg */

$lang['nagios_save'] = 'La configuration a &eacute;t&eacute; sauvegard&eacute;.<br> Vous devez maintenant d&eacute;placer les fichiers et relancer Nagios pour que les changements soient pris en compte.';

/* Ressources.cfg */

$lang['resources_example'] = 'Resource file example';
$lang['resources_add'] = 'Add a new resource';
$lang['resources_new'] = 'A new resource has been added';

/* lca */

$lang['lca_user'] = 'User :';
$lang['lca_user_access'] = 'has acces to ';
$lang['lca_profile'] = 'profile';
$lang['lca_user_restriction'] = 'Users with access restrictions';
$lang['lca_access_comment'] = 'Enable acces to Comment :';
$lang['lca_access_downtime'] = 'Enable acces to Downtime :';
$lang['lca_access_watchlog'] = 'Enable to watch log :';
$lang['lca_access_trafficMap'] = 'Enable to watch traffic map :';
$lang['lca_access_processInfo'] = 'Enable to acces to process info :';
$lang['lca_add_user_access'] = 'Add attributs to an User';
$lang['lca_apply_restrictions'] = 'Apply restrictions';
$lang['lca_action_on_profile'] = 'Actions';

/* History */

$lang['log_detail'] = "Logs Detail for ";

/* General Options */

$lang["opt_gen"] = "General Options";
$lang["nagios_version"] = "Nagios version : ";
$lang["phpradmin_path"] = "phpRADmin installation folder";
$lang["phpradmin_path_tooltip"] = "Where phpRADmin is installed? Ex.: /var/www/html/phpradmin";
$lang["radius_path"] = "RADIUS config files folder";
$lang["radius_path_tooltip"] = "Where is RADIUS configuration files folder? Ex.: /etc/raddb";
$lang["radius_bin_pwd"] = "RADIUS binary files folder";
$lang["radius_bin_pwd_tooltip"] = "Where is RADIUS binary files folder? Ex. radiusd location dir: /usr/sbin";
$lang["radius_init_script_path"] = "RADIUS startup script";
$lang["radius_init_script_path_tooltip"] ="Startup script location. Ex.: /etc/init.d/radiusd. Be sure that your script support reload option";
$lang["refresh_interface"] = "Interface refresh";
$lang["refresh_interface_tooltip"] = "Frontend reload frequency";
$lang["snmp_com"] = "SNMP community";
$lang["snmp_com_tooltip"] = "Default SNMP community";
$lang["snmp_version"] = "SNMP version";
$lang["snmp_path"] = "SNMP installation folder";
$lang["snmp_path_tooltip"] = "Where are snmpwalk and snmpget binary?";
$lang["cam_color"] = "Pie Colors";
$lang["for_hosts"] = "For hosts";
$lang["for_services"] = "For services";
$lang["rrd_path"] = "RRDTool binary path";
$lang["rrd_path_tooltip"] = "Where is rrdtool binary? Ex. /usr/bin/rrdtool";
$lang["rrd_base_path"] = "RRDTool base location";
$lang["rrd_base_path_tooltip"] = "Where the rrd databases are generated?";
$lang["mailer"] = "Mailer";
$lang["mailer_tooltip"] = "Where mail binary is installed?";
$lang["opt_gen_save"] = "General Options saved.<br>You have to generate the files.";
$lang["da_gen_save"] = "Dialup Admin Options saved.<br>You have to generate the files.";
$lang["session_expire"] = "Session expiration time";
$lang["session_expire_unlimited"] = "unlimited";
$lang["binary_path"] = "Nagios Binary path";
$lang["binary_path_tooltip"] = "Where is Nagios binary?";
$lang["images_logo_path"] = "Nagios picture path";
$lang["images_logo_path_tooltip"] = "Where are Nagios pictures?";
$lang["dictionary_path"] = "RADIUS Dictionary Path";
$lang["dictionary_path_tooltip"] = "Where are RADIUS dictionary installed? Ex. /usr/share/freeradius/dictionary/";
$lang["path_error_legend"] = "Color of the errors";
$lang["invalid_path"] = "The directory or file do not exist";
$lang["executable_binary"] = "The file is not executable";
$lang["writable_path"] = "The directory or file is not writable";
$lang["readable_path"] = "The directory is not readable";
$lang["rrdtool_version"] = "RRDTool version";
$lang["sudo_bin_path"] = "Sudo binary path";
$lang["sudo_path_tooltip"] = "Where is sudo binary?";

/* Auto Detect */

$lang['ad_title'] = "Automatic Host research";
$lang['ad_title2'] = "Automatic research";
$lang['ad_ser_result'] = "Automatic research discovered the following Services : ";
$lang['ad_ser_result2'] = "This list is not an exhaustive list and includes only<br> the services networks having opened a port network on the host.";
$lang['ad_infos1'] = "To make automatic research,<br>please fill the fields following with :";
$lang['ad_infos2'] = 'Maybe with an address IP (ex : 192.168.1.45),';
$lang['ad_infos3'] = 'Maybe with IP fields (ex : 192.168.1.1-254),';
$lang['ad_infos4'] = 'Maybe with an IP list :';
$lang['ad_infos5'] = '192.168.1.1,24,38';
$lang['ad_infos6'] = '192.168.*.*';
$lang['ad_infos7'] = '192.168.10-34.23-25,29-32';
$lang['ad_ip'] = 'IP';
$lang['ad_res_result'] = 'Research result';
$lang['ad_found'] = "found(s)";
$lang['ad_number'] = "Number";
$lang['ad_dns'] = "DNS";
$lang['ad_actions'] = "Actions";
$lang['ad_port'] = "Port";
$lang['ad_name'] = "Name";

/* Export DB */

$lang['edb_file_already_exist'] = "This file already exist, please enter a new name for your backup";
$lang['edb_file_move'] = "Moved files";
$lang['edb_file_ok'] = "Generated and moved files";
$lang['edb_file_nok'] = "Error during the generation or the displacement of the files";
$lang['edb_restart'] = "Host restart";
$lang['edb_save'] = "Make a backup";
$lang['edb_radius_restart'] = "Restart RADIUS";
$lang['edb_nagios_restart_ok'] = "RADIUS restart";
$lang['edb_restart'] = "Restart";

/* User_online */

$lang["wi_user"] = "Users";
$lang["wi_where"] = "Where";
$lang["wi_last_req"] = "Last Request";

/* Reporting */

$lang["pie_unavailable"] = "No Pie available for the moment";

/* Configuration Stats */

$lang['conf_stats_category'] = "Category";

/* Pictures */

$lang["pict_title"] = "Oreon Extended Infos Pictures";
$lang["pict_new_image"] = "New image (only .png)";

/* About */

$lang["developped"] = "Developed by";

/* Live Report */

$lang["lr_available"] = "Available  Hosts";
$lang["live_report"] = "Live Report";
$lang["bbreporting"] = "Reporting";
$lang["lr_host"] = "Host :";
$lang["lr_alias"] = "Alias :";
$lang["lr_ip"] = "IP Address :";
$lang["lr_view_services"] = "View Services Details for this host";
$lang["lr_configure_host"] = "Configure this host";
$lang["lr_details_host"] = "View host Informations";

/* Date and Time Format */

$lang["date_format"] = "Y/m/d";
$lang["time_format"] = "H:i:s";
$lang["header_format"] = "Y/m/d G:i";
$lang["date_time_format"] = "Y/m/d - H:i:s";
$lang["date_time_format_status"] = "Y/m/d H:i:s";
$lang["date_time_format_g_comment"] = "Y/m/d H:i";

/* */

$lang["top"] = "Top";
$lang["event"] = "Events";
$lang["date"] = "Date";
$lang["pel_l_details"] = "Logs Details for ";
$lang["pel_sort"] = "Filters";
$lang["pel_alerts_title"] = "Alerts for ";
$lang["pel_notify_title"] = "Notifications for ";

/* PHPRADMIN */

$lang['generated'] = "Generated in";
$lang['m_users'] = "Users";
$lang['m_clients_devices'] = "Clients/NAS";
$lang['m_billing'] = "Billing";
$lang['da_users'] = "Users";
$lang['da_adduser'] = "Add";
$lang['da_findedit'] = "Find / Edit";
$lang['da_showkickusers'] = "Show / Kick users";
$lang['da_failedlogins'] = "Failed logins";
$lang['da_badusers'] = "Bad users";
$lang['da_groups'] = "Groups";
$lang['da_addgroup'] = "Add";
$lang['da_editgroup'] = "Edit";
$lang['da_customreport'] = "Custom report";
$lang['da_stats'] = "Statistics";
$lang['pra_certs'] = "Certificates";
$lang['pra_clients'] = "Clients";
$lang['pra_addclient'] = "Add";
$lang['pra_editclient'] = "Edit";
$lang['pra_list'] = "List";
$lang['pra_logs'] = "Logs";
$lang['pra_radiuslogs'] = "RADIUS logs";
$lang['pra_radiusstatus'] = "RADIUS status";
$lang['pra_serverlogs'] = "Server logs";
$lang['pra_auto_reload'] = "Auto reload";
$lang['pra_users_status_now'] = "Users status now";
$lang['pra_user_connections'] = "User connections";
$lang['pra_client_connections'] = "Client connections";
$lang['pra_server_status'] = "Server status";
$lang['pra_db_status'] = "Database status";
$lang['pra_total_users_in_db'] = "Total users in Data Base";
$lang['m_application_users'] = "Application Users";
$lang['system_security_status'] = "System security status";
$lang['system_security_status_expl'] = "To generate new files after your configuration you must to UNLOCK the system for security reasons";
$lang['system_security_status_change'] = "Click to change status";
$lang['lock'] = "Lock";
$lang['unlock'] = "Unlock";
$lang["sudo_bin_path"] = "Sudo binary path";
$lang["phpradmin_path"] = "phpRADmin installation folder";
$lang["radius_log_path"] = "FreeRADIUS radius.log file path";
$lang["system_log_path"] = "System log file path";

// HELP
$lang["general_base_dir"] = "The directory where dialupadmin is installed";
$lang["general_radiusd_base_dir"] = "The base directory of the freeradius radius installation";
$lang["general_domain"]="The domain or subdomain for your device names";
$lang["general_most_recent_fl"]="This is used by the failed logins page. It states the default back time in minutes";
$lang["general_strip_realms"] = "Set general_strip_realms to yes in order to strip realms from usernames. By default realms are not striped."; 
$lang["general_realm_delimiter"]= "The delimiter used in realms. Default is @ ";
$lang["general_realm_format"]= "The format of the realms. Can be either suffix (realm is after the username) or prefix (realm is before the username). Default is suffix";
$lang["general_show_user_password"]= "Determines if the administrator will be able to see and change the user password through the user edit page";
$lang["general_raddb_dir"]="The directory o RADIUS configuration files ";
$lang["general_lib_type"]="It can be either ldap* or sql. This affects the user base not accounting. Accounting is always in sql. LDAP not supported by now in phpRADmin :(";
$lang["general_user_edit_attrs_file"]="Define which attributes will be visible in the user edit page ";
$lang["general_sql_attrs_file"]="Used by the Accounting Report Generator ";
$lang["general_default_file"]="Set default values for various attributes ";
$lang["general_finger_type"]="can be snmp (for snmpfinger and supported CISCO devices) or empty to query the radacct table without first querying the nas. This is used by the online users page ";
$lang["general_nas_type"]="Defines the nas type. This is only used by snmpfinger Cisco and Lucent are supported for now ";
$lang["general_radclient_bin"]="Location for radclient binary (from FreeRADIUS package) Ex.: /usr/bin/radclient";
$lang["general_test_account_login"]="This information is used from the server check page ";
$lang["general_test_account_password"]="This information is used from the server check page ";
$lang["general_radius_server"]="These are used as default values for the user test page ";
$lang["general_radius_port"]="These are used as default values for the user test page ";
$lang["general_radius_server_auth_proto"]="Can be either pap or chap. For the user test page only ";
$lang["general_radius_server_secret"]="Can be only single value. For the user test page only ";
$lang["general_auth_request_file"]="The auth request file. For the user test page only ";
$lang["general_encryption_method"]="Can be one of crypt, md5, clear ";
$lang["general_accounting_info_order"]="Can be either asc (older dates first) or desc (recent dates first). This is used in the user accounting and badusers pages. ";
$lang["general_stats_use_totacct"]="Use the totacct table in the user statistics page instead of the radacct table. That will make the page run quicker. totacct should have data for this to work :-)";
$lang["general_restrict_badusers_access"]="If set to yes then we only allow each administrator to examine it is own entries in the badusers table ";
$lang["general_caption_finger_free_lines"]="asdfadsfsfd";
$lang["sql_command"]="This variable is used by the scripts in the bin folder. It should contain the path to the sql binary used to run sql commands";
$lang["general_snmp_type"]="This variable is used by the scripts in the bin folder. It should contain the snmp type and  path to the binary used to run snmp commands. (ucd = UCD-Snmp and net = Net-Snmp are only supported for now)";
$lang["sql_debug"]="To enable sql debug ";
$lang["sql_password_attribute"]="Attribute to store users passwords. Use User-Password for clear passwords or Crypt-Password md5 or des passwords. ";
$lang["sql_date_format"]="Date formats available ";
$lang["sql_full_date_format"]="Full date formats available";
$lang["sql_row_limit"]="Used in the accounting report generator so that we don not return too many results ";
$lang["sql_connect_timeout"]="These options are used by the log_badlogins script and by the mysql driver. Set the sql connect timeout (secs)";
$lang["sql_extra_servers"]="These options are used by the log_badlogins script and by the mysql driver. Give a space separated list of extra mysql servers to connect to when logging bad logins or adding users in the badusers table ";
$lang["counter_default_daily"]="Default values for the various user limits in case the counter module is used to impose such limits. The value should be the user limit in seconds or none for nothing ";
$lang["counter_default_weekly"]="Default values for the various user limits in case the counter module is used to impose such limits. The value should be the user limit in seconds or none for nothing ";
$lang["counter_default_monthly"]="Default values for the various user limits in case the counter module is used to impose such limits. The value should be the user limit in seconds or none for nothing ";
$lang["counter_monthly_calculate_usage"]="Since calculating monthly usage can be quite expensive we make it configurable. This is not needed if the monthly limit is not none";
$lang["radius_log_path_tooltip"] = "radius.log file path. Ex.: /var/log/radius/radius.log";
$lang["system_log_path_tooltip"] = "System log file path. Ex.: /var/log/messages";



?>