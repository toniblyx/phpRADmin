-- MySQL dump 8.23
--
-- Host: localhost    Database: phpradmin
---------------------------------------------------------
-- Server version	3.23.58

--
-- Table structure for table `badusers`
--

CREATE TABLE badusers (
  id int(10) NOT NULL auto_increment,
  UserName varchar(30) default NULL,
  Date datetime NOT NULL default '0000-00-00 00:00:00',
  Reason varchar(200) default NULL,
  Admin varchar(30) default '-',
  PRIMARY KEY  (id),
  KEY UserName (UserName),
  KEY Date (Date)
) TYPE=MyISAM;

--
-- Dumping data for table `badusers`
--



--
-- Table structure for table `colors`
--

CREATE TABLE colors (
  color_id mediumint(8) unsigned NOT NULL auto_increment,
  hex varchar(6) NOT NULL default '',
  PRIMARY KEY  (color_id)
) TYPE=MyISAM;

--
-- Dumping data for table `colors`
--


INSERT INTO colors VALUES (1,'000000');
INSERT INTO colors VALUES (2,'FFFFFF');
INSERT INTO colors VALUES (3,'FEFEFE');
INSERT INTO colors VALUES (4,'FAFD9E');
INSERT INTO colors VALUES (5,'C0C0C0');
INSERT INTO colors VALUES (6,'74C366');
INSERT INTO colors VALUES (7,'6DC8FE');
INSERT INTO colors VALUES (8,'EA8F00');
INSERT INTO colors VALUES (9,'FF0000');
INSERT INTO colors VALUES (10,'4444FF');
INSERT INTO colors VALUES (11,'FF00FF');
INSERT INTO colors VALUES (12,'00FF00');
INSERT INTO colors VALUES (13,'8D85F3');
INSERT INTO colors VALUES (14,'AD3B6E');
INSERT INTO colors VALUES (15,'EACC00');
INSERT INTO colors VALUES (16,'12B3B5');
INSERT INTO colors VALUES (17,'157419');
INSERT INTO colors VALUES (18,'C4FD3D');
INSERT INTO colors VALUES (19,'817C4E');
INSERT INTO colors VALUES (20,'002A97');
INSERT INTO colors VALUES (21,'0000FF');
INSERT INTO colors VALUES (22,'00CF00');
INSERT INTO colors VALUES (24,'F9FD5F');
INSERT INTO colors VALUES (25,'FFF200');
INSERT INTO colors VALUES (26,'CCBB00');
INSERT INTO colors VALUES (27,'837C04');
INSERT INTO colors VALUES (28,'EAAF00');
INSERT INTO colors VALUES (29,'FFD660');
INSERT INTO colors VALUES (30,'FFC73B');
INSERT INTO colors VALUES (31,'FFAB00');
INSERT INTO colors VALUES (33,'FF7D00');
INSERT INTO colors VALUES (34,'ED7600');
INSERT INTO colors VALUES (35,'FF5700');
INSERT INTO colors VALUES (36,'EE5019');
INSERT INTO colors VALUES (37,'B1441E');
INSERT INTO colors VALUES (38,'FFC3C0');
INSERT INTO colors VALUES (39,'FF897C');
INSERT INTO colors VALUES (40,'FF6044');
INSERT INTO colors VALUES (41,'FF4105');
INSERT INTO colors VALUES (42,'DA4725');
INSERT INTO colors VALUES (43,'942D0C');
INSERT INTO colors VALUES (44,'FF3932');
INSERT INTO colors VALUES (45,'862F2F');
INSERT INTO colors VALUES (46,'FF5576');
INSERT INTO colors VALUES (47,'562B29');
INSERT INTO colors VALUES (48,'F51D30');
INSERT INTO colors VALUES (49,'DE0056');
INSERT INTO colors VALUES (50,'ED5394');
INSERT INTO colors VALUES (51,'B90054');
INSERT INTO colors VALUES (52,'8F005C');
INSERT INTO colors VALUES (53,'F24AC8');
INSERT INTO colors VALUES (54,'E8CDEF');
INSERT INTO colors VALUES (55,'D8ACE0');
INSERT INTO colors VALUES (56,'A150AA');
INSERT INTO colors VALUES (57,'750F7D');
INSERT INTO colors VALUES (58,'8D00BA');
INSERT INTO colors VALUES (59,'623465');
INSERT INTO colors VALUES (60,'55009D');
INSERT INTO colors VALUES (61,'3D168B');
INSERT INTO colors VALUES (62,'311F4E');
INSERT INTO colors VALUES (63,'D2D8F9');
INSERT INTO colors VALUES (64,'9FA4EE');
INSERT INTO colors VALUES (65,'6557D0');
INSERT INTO colors VALUES (66,'4123A1');
INSERT INTO colors VALUES (67,'4668E4');
INSERT INTO colors VALUES (68,'0D006A');
INSERT INTO colors VALUES (69,'00004D');
INSERT INTO colors VALUES (70,'001D61');
INSERT INTO colors VALUES (71,'00234B');
INSERT INTO colors VALUES (72,'002A8F');
INSERT INTO colors VALUES (73,'2175D9');
INSERT INTO colors VALUES (74,'7CB3F1');
INSERT INTO colors VALUES (75,'005199');
INSERT INTO colors VALUES (76,'004359');
INSERT INTO colors VALUES (77,'00A0C1');
INSERT INTO colors VALUES (78,'007283');
INSERT INTO colors VALUES (79,'00BED9');
INSERT INTO colors VALUES (80,'AFECED');
INSERT INTO colors VALUES (81,'55D6D3');
INSERT INTO colors VALUES (82,'00BBB4');
INSERT INTO colors VALUES (83,'009485');
INSERT INTO colors VALUES (84,'005D57');
INSERT INTO colors VALUES (85,'008A77');
INSERT INTO colors VALUES (86,'008A6D');
INSERT INTO colors VALUES (87,'00B99B');
INSERT INTO colors VALUES (88,'009F67');
INSERT INTO colors VALUES (89,'00694A');
INSERT INTO colors VALUES (90,'00A348');
INSERT INTO colors VALUES (91,'00BF47');
INSERT INTO colors VALUES (92,'96E78A');
INSERT INTO colors VALUES (93,'00BD27');
INSERT INTO colors VALUES (94,'35962B');
INSERT INTO colors VALUES (95,'7EE600');
INSERT INTO colors VALUES (96,'6EA100');
INSERT INTO colors VALUES (97,'CAF100');
INSERT INTO colors VALUES (98,'F5F800');
INSERT INTO colors VALUES (99,'CDCFC4');
INSERT INTO colors VALUES (100,'BCBEB3');
INSERT INTO colors VALUES (101,'AAABA1');
INSERT INTO colors VALUES (102,'8F9286');
INSERT INTO colors VALUES (103,'797C6E');
INSERT INTO colors VALUES (104,'2E3127');
INSERT INTO colors VALUES (105,'800000');
INSERT INTO colors VALUES (106,'808080');
INSERT INTO colors VALUES (107,'909090');
INSERT INTO colors VALUES (108,'FF9900');
INSERT INTO colors VALUES (109,'F83838');
INSERT INTO colors VALUES (110,'FFFF00');
INSERT INTO colors VALUES (111,'ACACAC');

--
-- Table structure for table `dialup_admin_cfg`
--

CREATE TABLE dialup_admin_cfg (
  general_prefered_lang varchar(200) NOT NULL default 'en',
  general_prefered_lang_name varchar(200) NOT NULL default 'English',
  general_charset varchar(200) NOT NULL default 'iso-8859-1',
  general_base_dir varchar(200) NOT NULL default '/var/www/html/phpradmin/include/dialup_admin',
  general_radiusd_base_dir varchar(200) NOT NULL default '/usr/sbin',
  general_domain varchar(200) NOT NULL default 'phpradmin.org',
  general_use_session varchar(100) NOT NULL default 'no',
  general_most_recent_fl varchar(100) NOT NULL default '50',
  general_strip_realms varchar(100) NOT NULL default 'no',
  general_realm_delimiter varchar(200) NOT NULL default '@',
  general_realm_format varchar(200) NOT NULL default 'suffix',
  general_show_user_password varchar(200) NOT NULL default 'yes',
  general_raddb_dir varchar(200) NOT NULL default '/etc/raddb',
  general_ldap_attrmap varchar(200) NOT NULL default '/etc/raddb/ldap.attrmap',
  general_clients_conf varchar(200) NOT NULL default '/etc/raddb/clients.conf',
  general_sql_attrmap varchar(200) NOT NULL default '/var/www/html/phpradmin/include/dialup_admin/conf/sql.attrmap',
  general_accounting_attrs_file varchar(200) NOT NULL default '/var/www/html/phpradmin/include/dialup_admin/conf/accounting.attrs',
  general_extra_ldap_attrmap varchar(200) NOT NULL default '/var/www/html/phpradmin/include/dialup_admin/conf/extra.ldap-attrmap',
  general_lib_type varchar(200) NOT NULL default 'sql',
  general_user_edit_attrs_file varchar(200) NOT NULL default '/var/www/html/phpradmin/include/dialup_admin/conf/user_edit.attrs',
  general_sql_attrs_file varchar(200) NOT NULL default '/var/www/html/phpradmin/include/dialup_admin/conf/sql.attrs',
  general_default_file varchar(200) NOT NULL default '/var/www/html/phpradmin/include/dialup_admin/conf/default.vals',
  general_finger_type varchar(200) NOT NULL default '',
  general_nas_type varchar(200) NOT NULL default 'other',
  general_snmpfinger_bin varchar(200) NOT NULL default '/var/www/html/phpradmin/include/dialup_admin/bin/snmpfinger',
  general_radclient_bin varchar(200) NOT NULL default '/usr/bin/radclient',
  general_test_account_login varchar(200) NOT NULL default 'test',
  general_test_account_password varchar(100) NOT NULL default 'testpass',
  general_radius_server varchar(100) NOT NULL default 'localhost',
  general_radius_server_port varchar(100) NOT NULL default '1812',
  general_radius_server_auth_proto varchar(100) NOT NULL default 'chap',
  general_radius_server_secret varchar(200) NOT NULL default 'secret',
  general_auth_request_file varchar(200) NOT NULL default '/var/www/html/phpradmin/include/dialup_admin/conf/auth.request',
  general_encryption_method varchar(200) NOT NULL default 'md5',
  general_accounting_info_order varchar(200) NOT NULL default 'desc',
  general_stats_use_totacct varchar(200) NOT NULL default 'no',
  general_restrict_badusers_access varchar(200) NOT NULL default 'no',
  general_caption_finger_free_lines varchar(200) NOT NULL default 'free lines',
  ldap_server varchar(200) NOT NULL default '',
  ldap_write_server varchar(200) NOT NULL default '',
  ldap_base varchar(200) NOT NULL default '',
  ldap_binddn varchar(200) NOT NULL default '',
  ldap_bindpw varchar(200) NOT NULL default '',
  ldap_default_new_entry_suffix varchar(200) NOT NULL default '',
  ldap_default_dn varchar(200) NOT NULL default '',
  ldap_regular_profile_attr varchar(200) NOT NULL default '',
  ldap_use_http_credentials varchar(200) NOT NULL default '',
  ldap_directory_manager varchar(200) NOT NULL default '',
  ldap_map_to_directory_manager varchar(200) NOT NULL default '',
  ldap_debug varchar(200) NOT NULL default '',
  ldap_filter varchar(200) NOT NULL default '',
  ldap_userdn varchar(255) NOT NULL default '',
  sql_type varchar(255) NOT NULL default 'mysql',
  sql_server varchar(255) NOT NULL default 'localhost',
  sql_port varchar(255) NOT NULL default '3306',
  sql_username varchar(255) NOT NULL default 'phpradmin',
  sql_password varchar(255) NOT NULL default 'passwordpra',
  sql_database varchar(255) NOT NULL default 'phpradmin',
  sql_accounting_table varchar(255) NOT NULL default 'radacct',
  sql_badusers_table varchar(200) NOT NULL default 'badusers',
  sql_check_table varchar(200) NOT NULL default 'radcheck',
  sql_reply_table varchar(255) NOT NULL default 'radreply',
  sql_user_info_table varchar(255) NOT NULL default 'userinfo',
  sql_groupcheck_table varchar(200) NOT NULL default 'radgroupcheck',
  sql_groupreply_table varchar(200) NOT NULL default 'radgroupreply',
  sql_usergroup_table varchar(255) NOT NULL default 'usergroup',
  sql_total_accounting_table varchar(255) NOT NULL default 'totacct',
  sql_nas_table varchar(200) NOT NULL default 'nas',
  sql_command varchar(200) NOT NULL default '/usr/bin/mysql',
  general_snmp_type varchar(200) NOT NULL default 'net',
  general_snmpwalk_command varchar(200) NOT NULL default '/usr/bin/snmpwalk',
  general_snmpget_command varchar(200) NOT NULL default '/usr/bin/snmpget',
  sql_debug varchar(200) NOT NULL default 'false',
  sql_use_user_info_table varchar(200) NOT NULL default 'true',
  sql_use_operators varchar(200) NOT NULL default 'true',
  sql_password_attribute varchar(200) NOT NULL default 'User-Password',
  sql_date_format varchar(100) NOT NULL default 'Y-m-d',
  sql_full_date_format varchar(100) NOT NULL default 'Y-m-d H:i:s',
  sql_row_limit varchar(20) NOT NULL default '50',
  sql_connect_timeout varchar(20) NOT NULL default '3',
  sql_extra_servers varchar(255) NOT NULL default '',
  counter_default_daily varchar(200) NOT NULL default 'none',
  counter_default_weekly varchar(200) NOT NULL default 'none',
  counter_default_monthly varchar(200) NOT NULL default 'none',
  counter_monthly_calculate_usage varchar(200) NOT NULL default 'false'
) TYPE=MyISAM;

--
-- Dumping data for table `dialup_admin_cfg`
--



--
-- Table structure for table `general_opt`
--

CREATE TABLE general_opt (
  radius_pwd varchar(200) NOT NULL default '',
  phpradmin_pwd varchar(200) NOT NULL default '',
  refresh int(11) NOT NULL default '0',
  rrd_pwd varchar(200) NOT NULL default '',
  session_expire int(11) NOT NULL default '0',
  startup_script varchar(200) NOT NULL default '',
  dictionary_path varchar(200) NOT NULL default '',
  radius_log_path varchar(200) NOT NULL default '',
  system_log_path varchar(200) NOT NULL default '',
  sudo_bin_path varchar(200) NOT NULL default '',
  radius_bin_pwd varchar(200) NOT NULL default ''
) TYPE=MyISAM;

--
-- Dumping data for table `general_opt`
--



--
-- Table structure for table `mtotacct`
--

CREATE TABLE mtotacct (
  MTotAcctId bigint(21) NOT NULL auto_increment,
  UserName varchar(64) NOT NULL default '',
  AcctDate date NOT NULL default '0000-00-00',
  ConnNum bigint(12) default NULL,
  ConnTotDuration bigint(12) default NULL,
  ConnMaxDuration bigint(12) default NULL,
  ConnMinDuration bigint(12) default NULL,
  InputOctets bigint(12) default NULL,
  OutputOctets bigint(12) default NULL,
  NASIPAddress varchar(15) default NULL,
  PRIMARY KEY  (MTotAcctId),
  KEY UserName (UserName),
  KEY AcctDate (AcctDate),
  KEY UserOnDate (UserName,AcctDate),
  KEY NASIPAddress (NASIPAddress)
) TYPE=MyISAM;

--
-- Dumping data for table `mtotacct`
--



--
-- Table structure for table `nagioscfg`
--

CREATE TABLE nagioscfg (
  cfg_pwd varchar(200) NOT NULL default '',
  object_cache_file varchar(255) NOT NULL default '',
  status_file varchar(200) NOT NULL default '',
  nagios_user varchar(100) NOT NULL default '',
  nagios_group varchar(100) NOT NULL default '',
  check_external_commands int(11) NOT NULL default '0',
  command_check_interval int(11) NOT NULL default '0',
  command_file varchar(200) NOT NULL default '',
  comment_file varchar(200) NOT NULL default '',
  downtime_file varchar(200) NOT NULL default '',
  lock_file varchar(200) NOT NULL default '',
  temp_file varchar(200) NOT NULL default '',
  log_rotation_method char(2) NOT NULL default '',
  log_archive_path varchar(200) NOT NULL default '',
  use_syslog int(11) NOT NULL default '0',
  log_notifications int(11) NOT NULL default '0',
  log_service_retries int(11) NOT NULL default '0',
  log_host_retries int(11) NOT NULL default '0',
  log_event_handlers int(11) NOT NULL default '0',
  log_initial_states int(11) NOT NULL default '0',
  log_external_commands int(11) NOT NULL default '0',
  log_passive_service_checks int(11) NOT NULL default '0',
  log_passive_checks int(11) NOT NULL default '0',
  inter_check_delay_method varchar(10) NOT NULL default '',
  service_inter_check_delay_method varchar(10) NOT NULL default '',
  host_inter_check_delay_method varchar(10) NOT NULL default '',
  service_interleave_factor varchar(10) NOT NULL default '',
  max_concurrent_checks int(11) NOT NULL default '0',
  max_service_check_spread int(11) NOT NULL default '0',
  max_host_check_spread int(11) NOT NULL default '0',
  service_reaper_frequency int(11) NOT NULL default '0',
  sleep_time int(11) NOT NULL default '0',
  service_check_timeout int(11) NOT NULL default '0',
  host_check_timeout int(11) NOT NULL default '0',
  event_handler_timeout int(11) NOT NULL default '0',
  notification_timeout int(11) NOT NULL default '0',
  ocsp_timeout int(11) NOT NULL default '0',
  ochp_timeout int(11) NOT NULL default '0',
  perfdata_timeout int(11) NOT NULL default '0',
  retain_state_information int(11) NOT NULL default '0',
  state_retention_file varchar(200) NOT NULL default '',
  retention_update_interval int(11) NOT NULL default '0',
  use_retained_program_state int(11) NOT NULL default '0',
  use_retained_scheduling_info int(11) NOT NULL default '0',
  interval_length int(11) NOT NULL default '0',
  use_agressive_host_checking int(11) NOT NULL default '0',
  execute_service_checks int(11) NOT NULL default '0',
  accept_passive_service_checks int(11) NOT NULL default '0',
  execute_host_checks int(11) NOT NULL default '0',
  accept_passive_host_checks int(11) NOT NULL default '0',
  enable_notifications int(11) NOT NULL default '0',
  enable_event_handlers int(11) NOT NULL default '0',
  process_performance_data int(11) NOT NULL default '0',
  host_perfdata_command varchar(255) NOT NULL default '',
  service_perfdata_command varchar(255) NOT NULL default '',
  host_perfdata_file varchar(255) NOT NULL default '',
  service_perfdata_file varchar(255) NOT NULL default '',
  host_perfdata_file_template text NOT NULL,
  service_perfdata_file_template text NOT NULL,
  host_perfdata_file_mode varchar(255) NOT NULL default '',
  service_perfdata_file_mode varchar(255) NOT NULL default '',
  host_perfdata_file_processing_interval int(11) NOT NULL default '0',
  service_perfdata_file_processing_interval int(11) NOT NULL default '0',
  host_perfdata_file_processing_command varchar(255) NOT NULL default '',
  service_perfdata_file_processing_command varchar(255) NOT NULL default '',
  obsess_over_services int(11) NOT NULL default '0',
  obsess_over_hosts int(11) NOT NULL default '0',
  ocsp_command varchar(255) NOT NULL default '',
  ochp_command varchar(255) NOT NULL default '',
  check_for_orphaned_services int(11) NOT NULL default '0',
  check_service_freshness int(11) NOT NULL default '0',
  service_freshness_check_interval int(11) NOT NULL default '0',
  check_host_freshness int(11) NOT NULL default '0',
  host_freshness_check_interval int(11) NOT NULL default '0',
  freshness_check_interval int(11) NOT NULL default '0',
  aggregate_status_updates int(11) NOT NULL default '0',
  status_update_interval int(11) NOT NULL default '0',
  enable_flap_detection int(11) NOT NULL default '0',
  low_service_flap_threshold varchar(20) NOT NULL default '',
  high_service_flap_threshold varchar(20) NOT NULL default '',
  low_host_flap_threshold varchar(20) NOT NULL default '',
  high_host_flap_threshold varchar(20) NOT NULL default '',
  date_format varchar(50) NOT NULL default '',
  illegal_object_name_chars varchar(200) NOT NULL default '',
  illegal_macro_output_chars varchar(200) NOT NULL default '',
  use_regexp_matching int(11) NOT NULL default '0',
  use_true_regexp_matching int(11) NOT NULL default '0',
  admin_email varchar(200) NOT NULL default '',
  admin_pager varchar(200) NOT NULL default '',
  Last_update time NOT NULL default '00:00:00',
  log_file varchar(200) NOT NULL default '',
  auto_reschedule_checks int(11) NOT NULL default '0',
  auto_rescheduling_interval int(11) NOT NULL default '0',
  auto_rescheduling_window int(11) NOT NULL default '0'
) TYPE=MyISAM;

--
-- Dumping data for table `nagioscfg`
--


INSERT INTO nagioscfg VALUES ('/usr/local/nagios/etc/','','/usr/local/nagios/var/status.log','nagios','nagios',1,-1,'/usr/local/nagios/var/rw/nagios.cmd','/usr/local/nagios/var/comment.log','/usr/local/nagios/var/downtime.log','/usr/local/nagios/var/nagios.lock','/usr/local/nagios/var/rw/nagios.tmp','d','/usr/local/nagios/var/archives/',1,1,1,1,1,0,1,0,0,'n','','','s',20,0,0,10,1,60,30,30,30,5,0,5,1,'/usr/local/nagios/var/status.sav',60,1,0,60,0,1,1,0,0,1,1,1,'','','','','','','','',0,0,'','',0,0,'','',0,0,0,0,0,60,1,15,0,'5.0','20.0','5.0','20.0','euro','`~!$^&*|\'\"<>,()?=','`~$&|\'\"<>',0,0,'nagios','nagiospager','00:00:00','/usr/local/nagios/var/nagios.log',0,0,0);
INSERT INTO nagioscfg VALUES ('/usr/local/nagios/etc/','','/usr/local/nagios/var/status.log','nagios','nagios',1,-1,'/usr/local/nagios/var/rw/nagios.cmd','/usr/local/nagios/var/comment.log','/usr/local/nagios/var/downtime.log','/usr/local/nagios/var/nagios.lock','/usr/local/nagios/var/rw/nagios.tmp','d','/usr/local/nagios/var/archives/',1,1,1,1,1,0,1,0,0,'n','','','s',20,0,0,10,1,60,30,30,30,5,0,5,1,'/usr/local/nagios/var/status.sav',60,1,0,60,0,1,1,0,0,1,1,1,'','','','','','','','',0,0,'','',0,0,'','',0,0,0,0,0,60,1,15,0,'5.0','20.0','5.0','20.0','euro','`~!$^&*|\'\"<>,()?=','`~$&|\'\"<>',0,0,'nagios','nagiospager','00:00:00','/usr/local/nagios/var/nagios.log',0,0,0);

--
-- Table structure for table `nas`
--

CREATE TABLE nas (
  id int(10) NOT NULL auto_increment,
  nasname varchar(128) NOT NULL default '',
  shortname varchar(32) default NULL,
  type varchar(30) default 'other',
  ports int(5) default NULL,
  secret varchar(60) NOT NULL default 'secret',
  community varchar(50) default NULL,
  description varchar(200) default 'RADIUS Client',
  PRIMARY KEY  (id),
  KEY nasname (nasname)
) TYPE=MyISAM;

--
-- Dumping data for table `nas`
--


INSERT INTO nas VALUES (1,'localhost','localhost','other',0,'veryverys3cr3t','public','localhost');

--
-- Table structure for table `radacct`
--

CREATE TABLE radacct (
  RadAcctId bigint(21) NOT NULL auto_increment,
  AcctSessionId varchar(32) NOT NULL default '',
  AcctUniqueId varchar(32) NOT NULL default '',
  UserName varchar(64) NOT NULL default '',
  Realm varchar(64) default '',
  NASIPAddress varchar(15) NOT NULL default '',
  NASPortId int(12) default NULL,
  NASPortType varchar(32) default NULL,
  AcctStartTime datetime NOT NULL default '0000-00-00 00:00:00',
  AcctStopTime datetime NOT NULL default '0000-00-00 00:00:00',
  AcctSessionTime int(12) default NULL,
  AcctAuthentic varchar(32) default NULL,
  ConnectInfo_start varchar(32) default NULL,
  ConnectInfo_stop varchar(32) default NULL,
  AcctInputOctets bigint(12) default NULL,
  AcctOutputOctets bigint(12) default NULL,
  CalledStationId varchar(50) NOT NULL default '',
  CallingStationId varchar(50) NOT NULL default '',
  AcctTerminateCause varchar(32) NOT NULL default '',
  ServiceType varchar(32) default NULL,
  FramedProtocol varchar(32) default NULL,
  FramedIPAddress varchar(15) NOT NULL default '',
  AcctStartDelay int(12) default NULL,
  AcctStopDelay int(12) default NULL,
  PRIMARY KEY  (RadAcctId),
  KEY UserName (UserName),
  KEY FramedIPAddress (FramedIPAddress),
  KEY AcctSessionId (AcctSessionId),
  KEY AcctUniqueId (AcctUniqueId),
  KEY AcctStartTime (AcctStartTime),
  KEY AcctStopTime (AcctStopTime),
  KEY NASIPAddress (NASIPAddress)
) TYPE=MyISAM;

--
-- Dumping data for table `radacct`
--



--
-- Table structure for table `radcheck`
--

CREATE TABLE radcheck (
  id int(11) unsigned NOT NULL auto_increment,
  UserName varchar(64) NOT NULL default '',
  Attribute varchar(64) NOT NULL default '',
  op char(2) NOT NULL default '==',
  Value varchar(253) NOT NULL default '',
  PRIMARY KEY  (id),
  KEY UserName (UserName(32))
) TYPE=MyISAM;

--
-- Dumping data for table `radcheck`
--


INSERT INTO radcheck VALUES (1,'toni','User-Password','==','pass');
INSERT INTO radcheck VALUES (2,'toni','Simultaneous-Use',':=','1');

--
-- Table structure for table `radgroupcheck`
--

CREATE TABLE radgroupcheck (
  id int(11) unsigned NOT NULL auto_increment,
  GroupName varchar(64) NOT NULL default '',
  Attribute varchar(64) NOT NULL default '',
  op char(2) NOT NULL default '==',
  Value varchar(253) NOT NULL default '',
  PRIMARY KEY  (id),
  KEY GroupName (GroupName(32))
) TYPE=MyISAM;

--
-- Dumping data for table `radgroupcheck`
--


INSERT INTO radgroupcheck VALUES (1,'eap','Auth-Type',':=','EAP');
INSERT INTO radgroupcheck VALUES (2,'pppoe','Auth-Type',':=','PAP');

--
-- Table structure for table `radgroupreply`
--

CREATE TABLE radgroupreply (
  id int(11) unsigned NOT NULL auto_increment,
  GroupName varchar(64) NOT NULL default '',
  Attribute varchar(32) NOT NULL default '',
  op char(2) NOT NULL default '=',
  Value varchar(253) NOT NULL default '',
  prio int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (id),
  KEY GroupName (GroupName(32))
) TYPE=MyISAM;

--
-- Dumping data for table `radgroupreply`
--


INSERT INTO radgroupreply VALUES (1,'pppoe','Framed-Protocol',':=','PPP',0);
INSERT INTO radgroupreply VALUES (2,'pppoe','Framed-IP-Address',':=','255.255.255.254',0);
INSERT INTO radgroupreply VALUES (3,'pppoe','Framed-IP-Netmask',':=','255.255.255.255',0);
INSERT INTO radgroupreply VALUES (4,'pppoe','Framed-Routing',':=','Broadcast-Listen',0);
INSERT INTO radgroupreply VALUES (5,'pppoe','Framed-MTU',':=','1472',0);
INSERT INTO radgroupreply VALUES (6,'pppoe','Framed-Compression',':=','Van-Jacobsen-TCP-IP',0);
INSERT INTO radgroupreply VALUES (7,'pppoe','Service-Type',':=','Framed-User',0);
INSERT INTO radgroupreply VALUES (8,'pppoe','Session-Timeout',':=','14400',0);
INSERT INTO radgroupreply VALUES (9,'pppoe','Idle-Timeout',':=','600',0);
INSERT INTO radgroupreply VALUES (10,'pppoe','Port-Limit',':=','1',0);

--
-- Table structure for table `radpostauth`
--

CREATE TABLE radpostauth (
  id int(11) NOT NULL auto_increment,
  user varchar(64) NOT NULL default '',
  pass varchar(64) NOT NULL default '',
  reply varchar(32) NOT NULL default '',
  date timestamp(14) NOT NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

--
-- Dumping data for table `radpostauth`
--



--
-- Table structure for table `radreply`
--

CREATE TABLE radreply (
  id int(11) unsigned NOT NULL auto_increment,
  UserName varchar(64) NOT NULL default '',
  Attribute varchar(64) NOT NULL default '',
  op char(2) NOT NULL default '=',
  Value varchar(253) NOT NULL default '',
  PRIMARY KEY  (id),
  KEY UserName (UserName(32))
) TYPE=MyISAM;

--
-- Dumping data for table `radreply`
--



--
-- Table structure for table `redirect_pages`
--

CREATE TABLE redirect_pages (
  id int(11) NOT NULL auto_increment,
  id_pages int(11) default NULL,
  pages varchar(255) NOT NULL default '',
  appright int(11) default '1',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

--
-- Dumping data for table `redirect_pages`
--


INSERT INTO redirect_pages VALUES (1,1,'./alt_main.php',1);
INSERT INTO redirect_pages VALUES (1013,1013,'./include/phpki/cacrl_show.php',1);
INSERT INTO redirect_pages VALUES (1012,1012,'./include/phpki/cacert_show.php',1);
INSERT INTO redirect_pages VALUES (4004,4004,'./include/phpconfig-freeradius/phpconfig_iframe.php',1);
INSERT INTO redirect_pages VALUES (4006,4006,'./include/phpconfig-da/phpconfig_iframe.php',1);
INSERT INTO redirect_pages VALUES (1011,1011,'./include/phpki/help_iframe.php',1);
INSERT INTO redirect_pages VALUES (1010,1010,'./include/phpki/download_ca_crl_iframe.php',1);
INSERT INTO redirect_pages VALUES (1009,1009,'./include/phpki/download_ca_cert_iframe.php',1);
INSERT INTO redirect_pages VALUES (1008,1008,'./include/phpki/update_crl_iframe.php',1);
INSERT INTO redirect_pages VALUES (1007,1007,'./include/phpki/manage_certs_iframe.php',1);
INSERT INTO redirect_pages VALUES (1006,1006,'./include/phpki/request_cert_iframe.php',1);
INSERT INTO redirect_pages VALUES (1001,1001,'./include/dialup_admin/user_new_iframe.php',1);
INSERT INTO redirect_pages VALUES (1002,1002,'./include/dialup_admin/find_iframe.php',1);
INSERT INTO redirect_pages VALUES (1003,1003,'./include/dialup_admin/failed_logins_iframe.php',1);
INSERT INTO redirect_pages VALUES (1004,1004,'./include/dialup_admin/badusers_iframe.php',1);
INSERT INTO redirect_pages VALUES (1005,1005,'./include/certs/certs.php',1);
INSERT INTO redirect_pages VALUES (1101,1101,'./include/dialup_admin/group_new_iframe.php',1);
INSERT INTO redirect_pages VALUES (1102,1102,'./include/dialup_admin/show_groups_iframe.php',1);
INSERT INTO redirect_pages VALUES (2001,2001,'./include/dialup_admin/nas_admin_iframe.php',1);
INSERT INTO redirect_pages VALUES (2002,2002,'./include/dialup_admin/nas_admin_iframe.php',1);
INSERT INTO redirect_pages VALUES (2003,2003,'./include/dialup_admin/nas_admin_iframe.php',1);
INSERT INTO redirect_pages VALUES (3001,3001,'./include/dialup_admin/user_finger_iframe.php',1);
INSERT INTO redirect_pages VALUES (3002,3002,'./include/dialup_admin/accounting_iframe.php',1);
INSERT INTO redirect_pages VALUES (3003,3003,'./include/dialup_admin/stats_iframe.php',1);
INSERT INTO redirect_pages VALUES (3004,3004,'./include/dialup_admin/user_stats_iframe.php',1);
INSERT INTO redirect_pages VALUES (3100,3100,'./include/graph/user_graphs.php',1);
INSERT INTO redirect_pages VALUES (3101,3101,'./include/graph/client_graphs.php',1);
INSERT INTO redirect_pages VALUES (3102,3102,'./include/graph/db_graphs.php',1);
INSERT INTO redirect_pages VALUES (3200,3200,'./include/reporting/radius_logs.php',1);
INSERT INTO redirect_pages VALUES (3201,3201,'./include/reporting/system_logs.php',1);
INSERT INTO redirect_pages VALUES (4001,4001,'./include/options/options_gen.php',1);
INSERT INTO redirect_pages VALUES (4002,4002,'./include/options/lang.php',1);
INSERT INTO redirect_pages VALUES (4003,4003,'./include/options/radiusd_configuration.php',1);
INSERT INTO redirect_pages VALUES (4005,4005,'./include/options/dialup_admin_configuration.php',1);
INSERT INTO redirect_pages VALUES (4007,4007,'./include/options/dictionary.php',1);
INSERT INTO redirect_pages VALUES (4008,4008,'./include/generatefile/generatefile.php',1);
INSERT INTO redirect_pages VALUES (4100,4100,'./include/options/show_user_online.php',1);
INSERT INTO redirect_pages VALUES (4101,4101,'./include/options/profile_user.php',1);
INSERT INTO redirect_pages VALUES (4102,4102,'./include/options/profile_users.php',1);
INSERT INTO redirect_pages VALUES (4200,4200,'./include/options/history.php',1);
INSERT INTO redirect_pages VALUES (4201,4201,'./include/options/extractdb.php',1);
INSERT INTO redirect_pages VALUES (4202,4202,'./stat.php',1);
INSERT INTO redirect_pages VALUES (4203,4203,'./include/options/update_phpradmin.php',1);
INSERT INTO redirect_pages VALUES (4204,4204,'./include/options/about.php',1);
INSERT INTO redirect_pages VALUES (5000,5000,'./include/billing/billing_main.php',1);

--
-- Table structure for table `resources`
--

CREATE TABLE resources (
  resource_id int(11) NOT NULL default '0',
  resource_line varchar(255) NOT NULL default '',
  resource_comment varchar(255) NOT NULL default '',
  PRIMARY KEY  (resource_id)
) TYPE=MyISAM;

--
-- Dumping data for table `resources`
--


INSERT INTO resources VALUES (1,'$USER1$=/usr/local/nagios/libexec','path tothe plugins');

--
-- Table structure for table `session`
--

CREATE TABLE session (
  session_id varchar(50) NOT NULL default '0',
  user_id int(11) NOT NULL default '0',
  current_page int(11) NOT NULL default '0',
  last_reload int(11) NOT NULL default '0',
  type char(2) NOT NULL default '0',
  host int(11) NOT NULL default '0',
  host_group int(11) NOT NULL default '0',
  host_group_escalation int(11) NOT NULL default '0',
  host_escalation int(11) NOT NULL default '0',
  host_dependency int(11) NOT NULL default '0',
  host_template_model int(11) NOT NULL default '0',
  host_extended_infos int(11) NOT NULL default '0',
  service int(11) NOT NULL default '0',
  service_escalation int(11) NOT NULL default '0',
  service_dependency int(11) NOT NULL default '0',
  service_group int(11) NOT NULL default '0',
  service_template_model int(11) NOT NULL default '0',
  service_extended_infos int(11) NOT NULL default '0',
  contact int(11) NOT NULL default '0',
  contact_group int(11) NOT NULL default '0',
  timeperiod int(11) NOT NULL default '0',
  command int(11) NOT NULL default '0',
  trafficMap int(11) NOT NULL default '0',
  graph_model_ds int(11) NOT NULL default '0',
  graph_model_conf int(11) NOT NULL default '0',
  graph int(11) NOT NULL default '0',
  general int(11) NOT NULL default '0',
  nagioscfg int(11) NOT NULL default '0',
  ressourcecfg int(11) NOT NULL default '0',
  profile_user int(11) NOT NULL default '0',
  lca int(11) default '0'
) TYPE=MyISAM;

--
-- Dumping data for table `session`
--


--
-- Table structure for table `totacct`
--

CREATE TABLE totacct (
  TotAcctId bigint(21) NOT NULL auto_increment,
  UserName varchar(64) NOT NULL default '',
  AcctDate date NOT NULL default '0000-00-00',
  ConnNum bigint(12) default NULL,
  ConnTotDuration bigint(12) default NULL,
  ConnMaxDuration bigint(12) default NULL,
  ConnMinDuration bigint(12) default NULL,
  InputOctets bigint(12) default NULL,
  OutputOctets bigint(12) default NULL,
  NASIPAddress varchar(15) default NULL,
  PRIMARY KEY  (TotAcctId),
  KEY UserName (UserName),
  KEY AcctDate (AcctDate),
  KEY UserOnDate (UserName,AcctDate),
  KEY NASIPAddress (NASIPAddress),
  KEY NASIPAddressOnDate (AcctDate,NASIPAddress)
) TYPE=MyISAM;

--
-- Dumping data for table `totacct`
--



--
-- Table structure for table `user`
--

CREATE TABLE user (
  user_id int(11) NOT NULL auto_increment,
  user_firstname varchar(200) default NULL,
  user_lastname varchar(200) default NULL,
  user_alias varchar(200) default NULL,
  user_passwd varchar(200) default NULL,
  user_mail varchar(200) default NULL,
  user_status tinyint(4) default NULL,
  user_lang char(2) NOT NULL default 'en',
  user_version tinyint(4) NOT NULL default '0',
  user_rapport_du_jour int(11) NOT NULL default '0',
  PRIMARY KEY  (user_id)
) TYPE=MyISAM;

--
-- Dumping data for table `user`
--


--
-- Table structure for table `usergroup`
--

CREATE TABLE usergroup (
  id int(11) unsigned NOT NULL auto_increment,
  UserName varchar(64) NOT NULL default '',
  GroupName varchar(64) NOT NULL default '',
  PRIMARY KEY  (id),
  KEY UserName (UserName(32))
) TYPE=MyISAM;

--
-- Dumping data for table `usergroup`
--


INSERT INTO usergroup VALUES (1,'','testgroup');
INSERT INTO usergroup VALUES (2,'','empty');
INSERT INTO usergroup VALUES (3,'','eap');
INSERT INTO usergroup VALUES (4,'','pppoe');

--
-- Table structure for table `userinfo`
--

CREATE TABLE userinfo (
  id int(10) NOT NULL auto_increment,
  UserName varchar(30) default NULL,
  Name varchar(200) default NULL,
  Mail varchar(200) default NULL,
  Department varchar(200) default NULL,
  WorkPhone varchar(200) default NULL,
  HomePhone varchar(200) default NULL,
  Mobile varchar(200) default NULL,
  mac varchar(20) default '00:00:00:00:00:00',
  PRIMARY KEY  (id),
  KEY UserName (UserName),
  KEY Departmet (Department)
) TYPE=MyISAM;

--
-- Dumping data for table `userinfo`
--


INSERT INTO userinfo VALUES (1,'toni','toni','','','','','','00:00:00:00:00:00');

