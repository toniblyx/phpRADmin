<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/class ResourceFile	{
var $name;
	
	function ResourceFile($file)	{
		$this->resource = array();
		$this->name = $file;
	}
	
	function unsetOreon(& $oreon)	{
		unset($oreon->resourcecfg);
		$oreon->resourcecfg = array();
	}
	
	function dropEverything(& $db)	{
		$db->query("DELETE FROM resources;");
	}

	function getResource(& $oreon)		{
		$i = 0;
		$lines = array();
		$rs_array = array();
		$handle = fopen("./nagios_cfg/upload/".$this->name, "r");
		while ($str = fgets($handle))	{
			$lines[$i] = $str;
			$i++;
		}
		fclose($handle);
		for ($i = 0; $i < count($lines); $i++)		{
			$regs = array();
			$regs2 = array();
			if (preg_match("/^[ \t]*[\$]USER([0-9]+)[\$][ \t]*=[ \t]*(.+)/", $lines[$i], $regs))	{
				$rs_array['resource_id'] = trim($regs[1]);
				$rs_array['resource_line'] = trim($regs[2]);
				if (isset($lines[$i-1]) && preg_match("/[ \t]*#[ \t]*(.+)/", $lines[$i-1], $regs2))
					$rs_array['resource_comment'] = trim($regs2[1]);
				else
					$rs_array['resource_comment'] = "";					
				$rs_object = new Resourcecfg($rs_array);
				$rs_object->set_line("\$USER".$rs_object->get_id()."$=".$rs_object->get_line());
				$oreon->resourcecfg[$rs_array["resource_id"]] = $rs_object;
				$oreon->saveResourcecfg($oreon->resourcecfg[$rs_array["resource_id"]]);
				unset($rs_object);
			}
			unset($regs);
			unset($regs2);
		}
	}
}

class NagiosFile	{
var $name;
	
	function NAgiosFile($file)	{
		$this->name = $file;
	}
	
	function unsetOreon(& $oreon)	{
		unset($oreon->Nagioscfg);
		$oreon->Nagioscfg = array();
	}
	
	function dropEverything(& $db)	{
		;//$db->query("DELETE FROM nagioscfg;");
	}

	function getNagios(& $oreon)		{
		$nagios_array = array();
		$flag = false;
		if ($handle = fopen("./nagios_cfg/upload/".$this->name, "r"))	{
			while ($str = fgets($handle))	{
				$regs = array();
				if (preg_match("/^[ \t]*([0-9a-zA-Z\_ ]+)[ \t]*=[ \t]*(.+)/", $str, $regs))	{
					if (!$flag && !strcmp("cfg_file", trim($regs[1])))	{
						$path = explode("/", $regs[2]);
						array_pop($path);
						$regs[2] = implode("/", $path);
						if (!trim($regs[2]))
							$nagios_array["cfg_pwd"] = "/";
						else
							$nagios_array["cfg_pwd"] = trim($regs[2])."/";
						$flag = true;
					}	else
						$nagios_array[trim($regs[1])] = trim($regs[2]);
				}
				unset($regs);
			}
			fclose($handle);					
			$nagios_object = new Nagioscfg($nagios_array);
			$oreon->Nagioscfg = $nagios_object;
			$oreon->saveNagioscfg($oreon->Nagioscfg);
			unset($nagios_object);
		}
	}
}

class cfgConfigFiles	{
var $hosts;
var $services;
var $hostTemplateModels;
var $serviceTemplateModels;
var $hostGroups;
var $serviceGroups;
var $contacts;
var $contactGroups;
var $timePeriods;
var $checkCommands;
var $miscCommands;
var $hostGroupEscalations;
var $hostEscalations;
var $serviceEscalations;
var $hostDependencies;
var $serviceDependencies;
var $hostExtendedInfos;
var $serviceExtendedInfos;
var $logMsg;

var $commandHash;
var $timePeriodHash;
var $contactHash;
var $contactGroupHash;
var $hostHash;
var $serviceHash;
var $hostGroupHash;
var $serviceGroupHash;

function cfgConfigFiles()	{
	$this->hosts = array();
	$this->services = array();
	$this->hostTemplateModels = array();
	$this->serviceTemplateModels = array();
	$this->hostGroups = array();
	$this->serviceGoups = array();
	$this->contacts = array();
	$this->contactGroups = array();
	$this->timePeriods = array();
	$this->miscCommands = array();
	$this->checkCommands = array();
	$this->hostEscalations = array();
	$this->hostGroupEscalations = array();
	$this->serviceEscalations = array();
	$this->hostDependencies = array();
	$this->serviceDependencies = array();
	$this->hostExtendedInfos = array();
	$this->serviceExtendedInfos = array();
	$this->logMsg = NULL;
	$this->commandHash = array();
	$this->timePeriodHash = array();
	$this->contactHash = array();
	$this->contactGroupHash = array();
	$this->hostHash = array();
	$this->serviceHash = array();
	$this->hostGroupHash = array();
	$this->serviceGroupHash = array();
}

function getConf()	{
	$tmpConf = array();
	$get = false;
	$typeDef = NULL;	
	$handle = opendir('./nagios_cfg/upload/');
	for ($cpt = 0; $file = readdir($handle);)
		if (strstr($file, ".cfg"))	{
			$files[$cpt] = "./nagios_cfg/upload/".$file;
			$cpt++;
		}
	closedir($handle);
	for ($j = 0; $j < count($files); $j++)
		if (is_file($files[$j]))
			if ($handle  = fopen($files[$j], "r"))	{
				while ($str = fgets($handle))	{
					if (preg_match("/}/", $str))	{
						switch ($typeDef)	{
							case "command": if (!strcmp("./nagios_cfg/upload/misccommands.cfg", $files[$j]))	$this->miscCommands[count($this->miscCommands)] = $tmpConf; else $this->checkCommands[count($this->checkCommands)] = $tmpConf;  break;
							case "service": $this->services[count($this->services)] = $tmpConf; break;
							case "timeperiod": $this->timePeriods[count($this->timePeriods)] = $tmpConf; break;
							case "host": $this->hosts[count($this->hosts)] = $tmpConf; break;
							case "contact": $this->contacts[count($this->contacts)] = $tmpConf; break;
							case "contactgroup": $this->contactGroups[count($this->contactGroups)] = $tmpConf; break;
							case "hostgroup": $this->hostGroups[count($this->hostGroups)] = $tmpConf; break;
							case "hostgroupescalation": $this->hostGroupEscalations[count($this->hostGroupEscalations)] = $tmpConf; break;
							case "servicegroup": $this->serviceGroups[count($this->serviceGroups)] = $tmpConf; break;
							case "hostdependency": $this->hostDependencies[count($this->hostDependencies)] = $tmpConf; break;
							case "servicedependency": $this->serviceDependencies[count($this->serviceDependencies)] = $tmpConf; break;
							case "hostescalation": $this->hostEscalations[count($this->hostEscalations)] = $tmpConf; break;
							case "serviceescalation": $this->serviceEscalations[count($this->serviceEscalations)] = $tmpConf; break;
							case "hostextinfo": $this->hostExtendedInfos[count($this->hostExtendedInfos)] = $tmpConf; break;
							case "serviceextinfo": $this->serviceExtendedInfos[count($this->serviceExtendedInfos)] = $tmpConf; break;							
							default :; break;
						}
						$get = false;
						$tmpConf = array();
						$typeDef = NULL;
					}
					if (preg_match("/^[ \t]*define ([a-zA-Z0-9\_\-]+)[ \t]*{/", $str, $def))	{
						$typeDef = $def[1];
						$get = true;
					}
					else if ($get)	{
						preg_match("/^[ \t]*([\w\-]+)[ \t]+([\|\(\)\>\<\?\!\{\}\$-_\/+:\.@\"\'\d\w\s]+)/", $str, $regs);
						if (isset($regs) && isset($regs[1]) && isset($regs[2]))
							$tmpConf[$regs[1]] = trim($regs[2]);
					}
				}
				fclose($handle);
			}
}

function unsetOreon(& $oreon)	{
	unset ($oreon->hosts);
	$oreon->hosts = array();
	unset ($oreon->commands);
	$oreon->commands = array();
	unset ($oreon->services);
	$oreon->services = array();
	unset ($oreon->contactGroups);
	$oreon->contactGroups = array();
	unset ($oreon->time_periods);
	$oreon->time_periods = array();
	unset ($oreon->htms);
	$oreon->stms = array();
	unset ($oreon->stms);
	$oreon->stms = array();
	unset ($oreon->contacts);
	$oreon->contacts = array();
	unset ($oreon->hostGroups);
	$oreon->hostGroups = array();
	unset ($oreon->serviceGroups);
	$oreon->serviceGroups = array();
	unset ($oreon->esis);
	$oreon->ehis = array();
	unset ($oreon->ehis);
	$oreon->ehis = array();
	unset ($oreon->hes);
	$oreon->hes = array();
	unset ($oreon->hges);
	$oreon->hges = array();
	unset ($oreon->ses);
	$oreon->ses = array();
	unset ($oreon->sds);
	$oreon->sds = array();
	unset ($oreon->hds);
	$oreon->hds = array();
	unset ($oreon->profileHosts);
	$oreon->profileHosts = array();	
	unset ($oreon->graphs);
	$oreon->graphs = array();
	unset ($oreon->Lca);
	$oreon->Lca = array();
}

function dropEverything(& $db)	{
	$db->query("DELETE FROM command;");
	$db->query("DELETE FROM contact;");
	$db->query("DELETE FROM contact_address;");
	$db->query("DELETE FROM contact_hostcommands_relation;");
	$db->query("DELETE FROM contact_servicecommands_relation;");
	$db->query("DELETE FROM contactgroup;");
	$db->query("DELETE FROM contactgroup_contact_relation;");
	$db->query("DELETE FROM contactgroup_host_relation;");
	$db->query("DELETE FROM contactgroup_hostescalation_relation;");
	$db->query("DELETE FROM contactgroup_hostgroup_relation;");
	$db->query("DELETE FROM contactgroup_hostgroupescalation_relation;");
	$db->query("DELETE FROM contactgroup_service_relation;");
	$db->query("DELETE FROM contactgroup_serviceescalation_relation;");
	$db->query("DELETE FROM contactgroup_servicegroup_relation;");
	$db->query("DELETE FROM extended_host_information;");
	$db->query("DELETE FROM extended_service_information;");
	$db->query("DELETE FROM graph;");
	$db->query("DELETE FROM host;");
	$db->query("DELETE FROM host_dependency;");
	$db->query("DELETE FROM host_escalation;");
	$db->query("DELETE FROM host_hostparent_relation;");
	$db->query("DELETE FROM host_parent;");
	$db->query("DELETE FROM host_service_relation;");
	$db->query("DELETE FROM hostgroup;");
	$db->query("DELETE FROM hostgroup_escalation;");
	$db->query("DELETE FROM hostgroup_hostescalation_relation;");
	$db->query("DELETE FROM hostgroup_relation;");
	$db->query("DELETE FROM lca_hosts;");
	$db->query("DELETE FROM lca_users;");
	$db->query("DELETE FROM profile_disk;");
	$db->query("DELETE FROM profile_host;");
	$db->query("DELETE FROM profile_interface;");
	$db->query("DELETE FROM service;");
	$db->query("DELETE FROM service_dependency;");
	$db->query("DELETE FROM service_escalation;");
	$db->query("DELETE FROM servicegroup;");
	$db->query("DELETE FROM servicegroup_relation;");
	$db->query("DELETE FROM timeperiod;");
	$db->query("DELETE FROM trafficMap;");
	$db->query("DELETE FROM trafficMap_host;");
	$db->query("DELETE FROM trafficMap_host_relation;");
	/*
	if ($handle = opendir('./rrd/'))	{
		while ($file = readdir($handle))
			if (!is_dir($file) && is_file($file))
				unlink("./rrd/".$file);
		closedir($handle);
	}

	if ($handle = opendir('./include/trafficMap/average/'))	{
		while ($file = readdir($handle))
			if (!is_dir($file) && is_file($file))
				unlink("./include/trafficMap/average/".$file);
		closedir($handle);
	}
	if ($handle = opendir('./include/trafficMap/bg/'))	{
		while ($file = readdir($handle))
			if (!is_dir($file) && is_file($file))
				unlink("./include/trafficMap/bg/".$file);
		closedir($handle);
	}
	if ($handle = opendir('./include/trafficMap/conf/'))	{
		while ($file = readdir($handle))
			if (!is_dir($file) && is_file($file))
				unlink("./include/trafficMap/conf/".$file);
		closedir($handle);
	}
	if ($handle = opendir('./include/trafficMap/png/'))	{
		while ($file = readdir($handle))
			if (!is_dir($file) && is_file($file))
				unlink("./include/trafficMap/png/".$file);
		closedir($handle);
	}
	if ($handle = opendir('../nagios/etc/'))	{
		while ($file = readdir($handle))	{
			$noDel = array('nagios'=>'', 'cgi'=>'', 'resource'=>'');
			$noExt = array();
			$noExt = explode('.', $file);
			array_pop($noExt);
			$file = implode('.', $noExt);
			if (is_file("../nagios/etc/".$file.".cfg"))
				if (!array_key_exists($file, $noDel))
					unlink("../nagios/etc/".$file.".cfg");
		}
		closedir($handle);
	}*/
}

function saveCheckCommand(& $oreon)	{
	for ($i = 0; $i < count($this->checkCommands); $i++)	{
		$commandArr = array();
		$commandArr["command_id"] = -1;
		$commandArr["command_type"] = 2;
		isset($this->checkCommands[$i]['command_name']) ? $commandArr['command_name'] = trim($this->checkCommands[$i]['command_name']) :  $commandArr['command_name'] = NULL;
		isset($this->checkCommands[$i]['command_line']) ? $commandArr['command_line'] = trim($this->checkCommands[$i]['command_line']) : $commandArr['command_line'] = NULL;	
		$command_object = new Command($commandArr);
		$oreon->saveCommand($command_object);
		$command_id = $oreon->database->database->get_last_id();
		$oreon->commands[$command_id] = $command_object;
		$oreon->commands[$command_id]->set_id($command_id);
		$this->commandHash[$oreon->commands[$command_id]->get_name()] = $command_id;
		unset($command_object);
		unset($commandArr);
	}
}

function	saveMiscCommand(& $oreon)	{
	for ($i = 0; $i < count($this->miscCommands); $i++)	{
		$commandArr = array();
		$commandArr["command_id"] = -1;
		$commandArr["command_type"] = 1;
		isset($this->miscCommands[$i]['command_name']) ? $commandArr['command_name'] = trim($this->miscCommands[$i]['command_name']) : $commandArr['command_name'] = NULL;
		isset($this->miscCommands[$i]['command_line']) ? $commandArr['command_line'] = trim($this->miscCommands[$i]['command_line']) : $commandArr['command_line'] = NULL;	
		$command_object = new Command($commandArr);
		$oreon->saveCommand($command_object);
		$command_id = $oreon->database->database->get_last_id();
		$oreon->commands[$command_id] = $command_object;
		$oreon->commands[$command_id]->set_id($command_id);
		$this->commandHash[$oreon->commands[$command_id]->get_name()] = $command_id;
		unset($command_object);
	}
}

function saveTimePeriod(& $oreon)	{
	for ($i = 0; $i < count($this->timePeriods); $i++)	{
		$tpArr = array();
		$tpArr['tp_id'] = -1;
		isset($this->timePeriods[$i]['timeperiod_name']) ? $tpArr['tp_name'] = trim($this->timePeriods[$i]['timeperiod_name']) : $tpArr['tp_name'] = NULL;
		isset($this->timePeriods[$i]['alias']) ? $tpArr['tp_alias'] = trim($this->timePeriods[$i]['alias']) :$tpArr['tp_alias'] = NULL;
		isset($this->timePeriods[$i]['monday']) ? $tpArr['tp_monday'] = trim($this->timePeriods[$i]['monday']) : $tpArr['tp_monday'] = NULL;
		isset($this->timePeriods[$i]['tuesday']) ? $tpArr['tp_tuesday'] = trim($this->timePeriods[$i]['tuesday']) : $tpArr['tp_tuesday'] = NULL;
		isset($this->timePeriods[$i]['wednesday']) ? $tpArr['tp_wednesday'] = trim($this->timePeriods[$i]['wednesday']) : $tpArr['tp_wednesday'] = NULL;
		isset($this->timePeriods[$i]['thursday']) ? $tpArr['tp_thursday'] = trim($this->timePeriods[$i]['thursday']) : $tpArr['tp_thursday'] = NULL;
		isset($this->timePeriods[$i]['friday']) ? $tpArr['tp_friday'] = trim($this->timePeriods[$i]['friday']) : $tpArr['tp_friday'] = NULL;
		isset($this->timePeriods[$i]['saturday']) ? $tpArr['tp_saturday'] = trim($this->timePeriods[$i]['saturday']) : $tpArr['tp_saturday'] = NULL;
		isset($this->timePeriods[$i]['sunday']) ? $tpArr['tp_sunday'] = trim($this->timePeriods[$i]['sunday']) : $tpArr['tp_sunday'] = NULL;
		$tp_object = new TimePeriod($tpArr);
		$oreon->saveTimePeriod($tp_object);
		$tp_id = $oreon->database->database->get_last_id();
		$oreon->time_periods[$tp_id] = $tp_object;
		$oreon->time_periods[$tp_id]->set_id($tp_id);
		$oreon->saveTimePeriod($oreon->time_periods[$tp_id]);
		$this->timePeriodHash[$oreon->time_periods[$tp_id]->get_name()] = $tp_id;
		unset($tp_object);
		unset($tpArr);
	}
}

function saveContact(& $oreon)	{
	for ($i = 0; $i < count($this->contacts); $i++)	{
		$contactArr = array();
		$contactArr = $this->contacts[$i];
		$contactArr['contact_id'] = -1;
		isset($this->contacts[$i]['alias']) ? $contactArr['contact_alias'] = trim($this->contacts[$i]['alias']) : $contactArr['contact_alias'] = NULL;
		isset($this->contacts[$i]['host_notification_period']) ? $contactArr['timeperiod_tp_id'] = $this->timePeriodHash[trim($this->contacts[$i]['host_notification_period'])] : $contactArr['timeperiod_tp_id'] = NULL;
		isset($this->contacts[$i]['service_notification_period']) ?	$contactArr['timeperiod_tp_id2'] = $this->timePeriodHash[trim($this->contacts[$i]['service_notification_period'])] : $contactArr['timeperiod_tp_id2'] = NULL;
		isset($this->contacts[$i]['host_notification_options']) ? $contactArr['contact_host_notification_options'] = trim($this->contacts[$i]['host_notification_options']) : $contactArr['contact_host_notification_options'] = NULL;
		isset($this->contacts[$i]['service_notification_options']) ? $contactArr['contact_service_notification_options'] = trim($this->contacts[$i]['service_notification_options']) : $contactArr['contact_service_notification_options'] = NULL;
		isset($this->contacts[$i]['email']) ? $contactArr['contact_email'] = trim($this->contacts[$i]['email']) : $contactArr['contact_email'] = NULL;
		isset($this->contacts[$i]['pager']) ? $contactArr['contact_pager'] = trim($this->contacts[$i]['pager']) : $contactArr['contact_pager'] = NULL;
		$contact_object = new Contact($contactArr);
		if (isset($this->contacts[$i]['host_notification_commands']))	{
			$cmds = array();
			$cmds = explode(',', $this->contacts[$i]['host_notification_commands']);
			for ($j = 0; $j < count($cmds) && trim($cmds[$j]); $j++)	{
				$cmds[$j] = trim($cmds[$j]);
				$contact_object->host_notification_commands[$this->commandHash[$cmds[$j]]] = & $oreon->commands[$this->commandHash[$cmds[$j]]];
			}
			unset($cmds);
		}
		if (isset($this->contacts[$i]['service_notification_commands']))	{
			$cmds = array();
			$cmds = explode(',', $this->contacts[$i]['service_notification_commands']);
			for ($j = 0; $j < count($cmds) && trim($cmds[$j]); $j++)	{
				$cmds[$j] = trim($cmds[$j]);
				$contact_object->service_notification_commands[$this->commandHash[$cmds[$j]]] = & $oreon->commands[$this->commandHash[$cmds[$j]]];
			}
			unset($cmds);
		}
		$oreon->saveContact($contact_object);
		$contact_id = $oreon->database->database->get_last_id();
		$oreon->contacts[$contact_id] = $contact_object;
		$oreon->contacts[$contact_id]->set_id($contact_id);
		$oreon->contacts[$contact_id]->set_pager($contactArr['contact_pager']);
		$oreon->contacts[$contact_id]->set_activate(1);
		$oreon->saveContact($oreon->contacts[$contact_id]);
		$this->contactHash[$oreon->contacts[$contact_id]->get_name()] = $contact_id;
		unset($contact_object);
		unset($contactArr);
	}
}

function saveContactGroup(& $oreon)	{
	for ($i = 0; $i < count($this->contactGroups); $i++)	{
		$contactGroupArr = array();
		$contactGroupArr['cg_id'] = -1;
		isset($this->contactGroups[$i]['contactgroup_name']) ? $contactGroupArr['cg_name'] = trim($this->contactGroups[$i]['contactgroup_name']) : $contactGroupArr['cg_name'] = NULL; 
		isset($this->contactGroups[$i]['alias']) ? $contactGroupArr['cg_alias'] = trim($this->contactGroups[$i]['alias']) : $contactGroupArr['cg_alias'] = NULL;
		$contactGroupArr['cg_contacts'] = '';
		$contactGroup_object = new ContactGroup($contactGroupArr);
		if (isset($this->contactGroups[$i]['members']))	{
			$contacts = array();
			$contacts = explode(',', $this->contactGroups[$i]['members']);
			for ($j = 0; $j < count($contacts) && trim($contacts[$j]); $j++)	{
				$contacts[$j] = trim($contacts[$j]);
				$contactGroup_object->contacts[$this->contactHash[$contacts[$j]]] = & $oreon->contacts[$this->contactHash[$contacts[$j]]];
			}
			unset($contacts);
		}
		$oreon->saveContactGroup($contactGroup_object);
		$contactGroup_id = $oreon->database->database->get_last_id();
		$oreon->contactGroups[$contactGroup_id] = $contactGroup_object;
		$oreon->contactGroups[$contactGroup_id]->set_id($contactGroup_id);
		$oreon->contactGroups[$contactGroup_id]->set_activate(1);		
		$oreon->saveContactGroup($oreon->contactGroups[$contactGroup_id]);
		$this->contactGroupHash[$oreon->contactGroups[$contactGroup_id]->get_name()] = $contactGroup_id;
		unset($contactGroup_object);
		unset($contactGroupArr);
	}
}

function saveHost(& $oreon)	{
	for ($i = 0; $i < count($this->hosts); $i++) 
		if (isset($this->hosts[$i]['register']) && $this->hosts[$i]['register'] == 0)	{
			$hostArr = array();
			$hostArr['host_id'] = -1;
			if (isset($this->hosts[$i]['host_name']))	$hostArr['host_name'] = trim($this->hosts[$i]['host_name']);
			if (isset($this->hosts[$i]['name']))	$hostArr['host_name'] = trim($this->hosts[$i]['name']);
			if (!isset($hostArr['host_name'])) $hostArr['host_name'] = '';
			isset($this->hosts[$i]['alias']) ?	$hostArr['host_alias'] = trim($this->hosts[$i]['alias']) : $hostArr['host_alias'] = NULL;
			isset($this->hosts[$i]['address']) ? $hostArr['host_address'] = trim($this->hosts[$i]['address']) : $hostArr['host_address'] = NULL;
			isset($this->hosts[$i]['max_check_attempts']) ? $hostArr['host_max_check_attempts'] = trim($this->hosts[$i]['max_check_attempts']) : $hostArr['host_max_check_attempts'] = NULL;
			isset($this->hosts[$i]['check_interval']) ? ($this->hosts[$i]['check_interval'] ? $hostArr['host_check_interval'] = trim($this->hosts[$i]['check_interval']) : $hostArr['host_check_interval'] = 99999) : $hostArr['host_check_interval'] = 0;
			isset($this->hosts[$i]['checks_enabled']) ? ($this->hosts[$i]['checks_enabled'] ? $hostArr['host_checks_enabled'] = 1 : $hostArr['host_checks_enabled'] = 3) : $hostArr['host_checks_enabled'] = 2;
			isset($this->hosts[$i]['active_checks_enabled']) ? ($this->hosts[$i]['active_checks_enabled'] ?	$hostArr['host_active_checks_enabled'] = 1 : $hostArr['host_active_checks_enabled'] = 3) : $hostArr['host_active_checks_enabled'] = 2;
			isset($this->hosts[$i]['passive_checks_enabled']) ? ($this->hosts[$i]['passive_checks_enabled']	? $hostArr['host_passive_checks_enabled'] = 1 : $hostArr['host_passive_checks_enabled'] = 3) : $hostArr['host_passive_checks_enabled'] = 2;
			isset($this->hosts[$i]['obsess_over_host']) ? ($this->hosts[$i]['obsess_over_host'] ?	$hostArr['host_obsess_over_host'] = 1 : $hostArr['host_obsess_over_host'] = 3) : $hostArr['host_obsess_over_host'] = 2;
			isset($this->hosts[$i]['check_freshness']) ? ($this->hosts[$i]['check_freshness'] ?	$hostArr['host_check_freshness'] = 1 : $hostArr['host_check_freshness'] = 3) : $hostArr['host_check_freshness'] = 2;
			isset($this->hosts[$i]['freshness_threshold']) ? (trim($this->hosts[$i]['freshness_threshold']) ? $hostArr['host_freshness_threshold'] = trim($this->hosts[$i]['freshness_threshold']) : $hostArr['host_freshness_threshold'] = 99999) : $hostArr['host_freshness_threshold'] = 0;
			isset($this->hosts[$i]['event_handler_enabled']) ? ($this->hosts[$i]['event_handler_enabled'] ? $hostArr['host_event_handler_enabled'] = 1 : $hostArr['host_event_handler_enabled'] = 3) : $hostArr['host_event_handler_enabled'] = 2;
			isset($this->hosts[$i]['low_flap_threshold']) ? (trim($this->hosts[$i]['low_flap_threshold']) ? $hostArr['host_low_flap_threshold'] = trim($this->hosts[$i]['low_flap_threshold']) :  $hostArr['host_low_flap_threshold'] = 99999) : $hostArr['host_low_flap_threshold'] = 0;
			isset($this->hosts[$i]['high_flap_threshold']) ? (trim($this->hosts[$i]['high_flap_threshold']) ?	$hostArr['host_high_flap_threshold'] = trim($this->hosts[$i]['high_flap_threshold']) : $hostArr['host_high_flap_threshold'] = 99999) : $hostArr['host_high_flap_threshold'] = 0;
			isset($this->hosts[$i]['flap_detection_enabled']) ? ($this->hosts[$i]['flap_detection_enabled'] ? $hostArr['host_flap_detection_enabled'] = 1 : $hostArr['host_flap_detection_enabled'] = 3) : $hostArr['host_flap_detection_enabled'] = 2;
			isset($this->hosts[$i]['process_perf_data']) ? ($this->hosts[$i]['process_perf_data'] ?	$hostArr['host_process_perf_data'] = 1 : $hostArr['host_process_perf_data'] = 3) : $hostArr['host_process_perf_data'] = 2;
			isset($this->hosts[$i]['retain_status_information']) ? ($this->hosts[$i]['retain_status_information'] ?	$hostArr['host_retain_status_information'] = 1 : $hostArr['host_retain_status_information'] = 3) : $hostArr['host_retain_status_information'] = 2;
			isset($this->hosts[$i]['retain_nonstatus_information']) ? ($this->hosts[$i]['retain_nonstatus_information'] ? $hostArr['host_retain_nonstatus_information'] = 1 : $hostArr['host_retain_nonstatus_information'] = 3) : $hostArr['host_retain_nonstatus_information'] = 2;
			isset($this->hosts[$i]['notification_interval']) ? (trim($this->hosts[$i]['notification_interval']) ? $hostArr['host_notification_interval'] = trim($this->hosts[$i]['notification_interval']) : $hostArr['host_notification_interval'] = 99999) : $hostArr['host_notification_interval'] = 0;
			isset($this->hosts[$i]['notification_options']) ? $hostArr['host_notification_options'] = trim($this->hosts[$i]['notification_options']) : $hostArr['host_notification_options'] = NULL;
			isset($this->hosts[$i]['notifications_enabled']) ? ($this->hosts[$i]['notifications_enabled'] ?	$hostArr['host_notifications_enabled'] = 1 : $hostArr['host_notifications_enabled'] = 3) : $hostArr['host_notifications_enabled'] = 2;
			isset($this->hosts[$i]['stalking_options']) ? $hostArr['host_stalking_options'] = trim($this->hosts[$i]['stalking_options']) : $hostArr['host_stalking_options'] = '';
			
			isset($this->hosts[$i]['check_period']) ? $hostArr['timeperiod_tp_id'] = $this->timePeriodHash[trim($this->hosts[$i]['check_period'])] : $hostArr['timeperiod_tp_id'] = '';
			isset($this->hosts[$i]['notification_period'])	? $hostArr['timeperiod_tp_id2'] = $this->timePeriodHash[trim($this->hosts[$i]['notification_period'])] :	$hostArr['timeperiod_tp_id2'] = '';
			isset($this->hosts[$i]['check_command']) ? $hostArr['command_command_id'] = $this->commandHash[trim($this->hosts[$i]['check_command'])] : $hostArr['command_command_id'] = '';
			isset($this->hosts[$i]['event_handler']) ? $hostArr['command_command_id2'] = $this->commandHash[trim($this->hosts[$i]['event_handler'])] : $hostArr['command_command_id2'] = '';

			$host_object = new Host($hostArr);
			if (isset($this->hosts[$i]['contact_groups']))	{
				$contactGroups = array();
				$contactGroups = explode(',', $this->hosts[$i]['contact_groups']);
				for ($j = 0; $j < count($contactGroups) && trim($contactGroups[$j]); $j++)	{
					$contactGroups[$j] = trim($contactGroups[$j]);
					$host_object->contactgroups[$this->contactGroupHash[$contactGroups[$j]]] = & $oreon->contactGroups[$this->contactGroupHash[$contactGroups[$j]]];
				}
				unset($contactGroups);
			}	else
				$host_object->contactgroups = array();
			
			$oreon->saveHost($host_object);
			$host_id = $oreon->database->database->get_last_id();

			$htm_array["htm_id"] = $host_id;
			$htm_object = new HostTemplateModel($htm_array);
			$oreon->htms[$host_id] = $htm_object;
						
			$oreon->hosts[$host_id] = $host_object;
			$oreon->hosts[$host_id]->set_id($host_id);
			$oreon->hosts[$host_id]->set_check_interval($hostArr['host_check_interval']);
			$oreon->hosts[$host_id]->set_checks_enabled($hostArr['host_checks_enabled']);
			$oreon->hosts[$host_id]->set_active_checks_enabled($hostArr['host_active_checks_enabled']);
			$oreon->hosts[$host_id]->set_passive_checks_enabled($hostArr['host_passive_checks_enabled']);
			$oreon->hosts[$host_id]->set_obsess_over_host($hostArr['host_obsess_over_host']);
			$oreon->hosts[$host_id]->set_check_freshness($hostArr['host_check_freshness']);
			$oreon->hosts[$host_id]->set_freshness_threshold($hostArr['host_freshness_threshold']);
			$oreon->hosts[$host_id]->set_event_handler_enabled($hostArr['host_event_handler_enabled']);
			$oreon->hosts[$host_id]->set_low_flap_threshold($hostArr['host_low_flap_threshold']);
			$oreon->hosts[$host_id]->set_high_flap_threshold($hostArr['host_high_flap_threshold']);
			$oreon->hosts[$host_id]->set_flap_detection_enabled($hostArr['host_flap_detection_enabled']);
			$oreon->hosts[$host_id]->set_process_perf_data($hostArr['host_process_perf_data']);
			$oreon->hosts[$host_id]->set_retain_status_information($hostArr['host_retain_status_information']);
			$oreon->hosts[$host_id]->set_retain_nonstatus_information($hostArr['host_retain_nonstatus_information']);
			$oreon->hosts[$host_id]->set_notifications_enabled($hostArr['host_notifications_enabled']);
			$oreon->hosts[$host_id]->set_stalking_options($hostArr['host_stalking_options']);
			$oreon->hosts[$host_id]->set_check_period($hostArr['timeperiod_tp_id']);
			$oreon->hosts[$host_id]->set_check_command($hostArr['command_command_id']);
			$oreon->hosts[$host_id]->set_event_handler($hostArr['command_command_id2']);
			$oreon->hosts[$host_id]->set_register(0);
			$oreon->hosts[$host_id]->set_activate(1);
			$oreon->hosts[$host_id]->parents = array();
			$oreon->hosts[$host_id]->hostGroups = array();
			$oreon->saveHost($oreon->hosts[$host_id]);
			$this->hostHash[$oreon->hosts[$host_id]->get_name()] = $host_id;
			unset($host_object);
			unset($htm_object);
			unset($htm_array);
			unset($hostArr);
		}
	for ($i = 0; $i < count($this->hosts); $i++) 
		if (!isset($this->hosts[$i]['register']))	{
			$hostArr = array();
			$hostArr['host_id'] = -1;
			if (isset($this->hosts[$i]['host_name']))	$hostArr['host_name'] = $this->hosts[$i]['host_name']; else $hostArr['host_name'] = '';
			if (isset($this->hosts[$i]['alias']))	$hostArr['host_alias'] = trim($this->hosts[$i]['alias']); else $hostArr['host_alias'] = '';
			if (isset($this->hosts[$i]['address']))	$hostArr['host_address'] = trim($this->hosts[$i]['address']); else $hostArr['host_address'] = '';
			
			isset($this->hosts[$i]['max_check_attempts']) ?	$hostArr['host_max_check_attempts'] = trim($this->hosts[$i]['max_check_attempts']) : $hostArr['host_max_check_attempts'] = NULL;
			
			isset($this->hosts[$i]['check_interval']) ? $hostArr['host_check_interval'] = trim($this->hosts[$i]['check_interval']) : $hostArr['host_check_interval'] = 99999; if (!isset($hostArr['host_check_interval'])) $hostArr['host_check_interval'] = 0;
			
			isset($this->hosts[$i]['checks_enabled']) ? ($this->hosts[$i]['checks_enabled'] ? $hostArr['host_checks_enabled'] = 1 : $hostArr['host_checks_enabled'] = 3)  : $hostArr['host_checks_enabled'] = 2;
			isset($this->hosts[$i]['active_checks_enabled']) ? ($this->hosts[$i]['active_checks_enabled'] ? $hostArr['host_active_checks_enabled'] = 1 : $hostArr['host_active_checks_enabled'] = 3 ) : $hostArr['host_active_checks_enabled'] = 2;
			isset($this->hosts[$i]['passive_checks_enabled']) ? ($this->hosts[$i]['passive_checks_enabled'] ? $hostArr['host_passive_checks_enabled'] = 1 : $hostArr['host_passive_checks_enabled'] = 3) : $hostArr['host_passive_checks_enabled'] = 2;
			isset($this->hosts[$i]['obsess_over_host']) ? ($this->hosts[$i]['obsess_over_host'] ? $hostArr['host_obsess_over_host'] = 1 : $hostArr['host_obsess_over_host'] = 3) : $hostArr['host_obsess_over_host'] = 2;
			isset($this->hosts[$i]['check_freshness']) ? ($this->hosts[$i]['check_freshness'] ? $hostArr['host_check_freshness'] = 1 : $hostArr['host_check_freshness'] = 3) : $hostArr['host_check_freshness'] = 2;
			isset($this->hosts[$i]['freshness_threshold']) ? (trim($this->hosts[$i]['freshness_threshold']) ? $hostArr['host_freshness_threshold'] = trim($this->hosts[$i]['freshness_threshold']) : $hostArr['host_freshness_threshold'] = 99999) : $hostArr['host_freshness_threshold'] = 0;
			isset($this->hosts[$i]['event_handler_enabled']) ? ($this->hosts[$i]['event_handler_enabled'] ? $hostArr['host_event_handler_enabled'] = 1 : $hostArr['host_event_handler_enabled'] = 3) : $hostArr['host_event_handler_enabled'] = 2;
			isset($this->hosts[$i]['low_flap_threshold']) ? (trim($this->hosts[$i]['low_flap_threshold']) ? $hostArr['host_low_flap_threshold'] = trim($this->hosts[$i]['low_flap_threshold']) : $hostArr['host_low_flap_threshold'] = 99999) : $hostArr['host_low_flap_threshold'] = 0;
			isset($this->hosts[$i]['high_flap_threshold']) ? (trim($this->hosts[$i]['high_flap_threshold']) ? $hostArr['host_high_flap_threshold'] = trim($this->hosts[$i]['high_flap_threshold']) : $hostArr['host_high_flap_threshold'] = 99999) : $hostArr['host_high_flap_threshold'] = 0;
			isset($this->hosts[$i]['flap_detection_enabled']) ? ($this->hosts[$i]['flap_detection_enabled'] ? $hostArr['host_flap_detection_enabled'] = 1 : $hostArr['host_flap_detection_enabled'] = 3) : $hostArr['host_flap_detection_enabled'] = 2;
			isset($this->hosts[$i]['process_perf_data']) ? ($this->hosts[$i]['process_perf_data'] ? $hostArr['host_process_perf_data'] = 1 : $hostArr['host_process_perf_data'] = 3) : $hostArr['host_process_perf_data'] = 2;
			isset($this->hosts[$i]['retain_status_information']) ? ($this->hosts[$i]['retain_status_information'] ? $hostArr['host_retain_status_information'] = 1 : $hostArr['host_retain_status_information'] = 3) : $hostArr['host_retain_status_information'] = 2;
			isset($this->hosts[$i]['retain_nonstatus_information']) ? ($this->hosts[$i]['retain_nonstatus_information'] ? $hostArr['host_retain_nonstatus_information'] = 1 : $hostArr['host_retain_nonstatus_information'] = 3) : $hostArr['host_retain_nonstatus_information'] = 2;
			isset($this->hosts[$i]['notification_interval']) ? (trim($this->hosts[$i]['notification_interval']) ? $hostArr['host_notification_interval'] = trim($this->hosts[$i]['notification_interval']) : $hostArr['host_notification_interval'] = 99999) : $hostArr['host_notification_interval'] = 0;
			isset($this->hosts[$i]['notification_options']) ? $hostArr['host_notification_options'] = trim($this->hosts[$i]['notification_options']) : $hostArr['host_notification_options'] = NULL;
			isset($this->hosts[$i]['notifications_enabled']) ? ($this->hosts[$i]['notifications_enabled'] ? $hostArr['host_notifications_enabled'] = 1 : $hostArr['host_notifications_enabled'] = 3) : $hostArr['host_notifications_enabled'] = 2;
			isset($this->hosts[$i]['stalking_options']) ? $hostArr['host_stalking_options'] = trim($this->hosts[$i]['stalking_options']) : $hostArr['host_stalking_options'] = NULL;
			if (isset($this->hosts[$i]['use']))	$hostArr['host_template_model'] = $this->hostHash[trim($this->hosts[$i]['use'])];
			
			isset($this->hosts[$i]['check_period']) ? $hostArr['timeperiod_tp_id'] = $this->timePeriodHash[trim($this->hosts[$i]['check_period'])] : $hostArr['timeperiod_tp_id'] = NULL;
			isset($this->hosts[$i]['notification_period']) ? $hostArr['timeperiod_tp_id2'] = $this->timePeriodHash[trim($this->hosts[$i]['notification_period'])] : $hostArr['timeperiod_tp_id2'] = NULL;
			isset($this->hosts[$i]['check_command']) ? $hostArr['command_command_id'] = $this->commandHash[trim($this->hosts[$i]['check_command'])] : $hostArr['command_command_id'] = NULL;
			isset($this->hosts[$i]['event_handler']) ? $hostArr['command_command_id2'] = $this->commandHash[trim($this->hosts[$i]['event_handler'])] : $hostArr['command_command_id2'] = NULL;

			$host_object = new Host($hostArr);
			if (isset($this->hosts[$i]['contact_groups']))	{
				$contactGroups = array();
				$contactGroups = explode(',', $this->hosts[$i]['contact_groups']);
				for ($j = 0; $j < count($contactGroups) && trim($contactGroups[$j]); $j++)	{
					$contactGroups[$j] = trim($contactGroups[$j]);
					$host_object->contactgroups[$this->contactGroupHash[$contactGroups[$j]]] = & $oreon->contactGroups[$this->contactGroupHash[$contactGroups[$j]]];
				}
				unset($contactGroups);
			}	else
				$host_object->contactgroups = array();
			$oreon->saveHost($host_object);
			$host_id = $oreon->database->database->get_last_id();
			$oreon->hosts[$host_id] = $host_object;
			$oreon->hosts[$host_id]->set_id($host_id);
			if (isset($hostArr['host_template_model'])) $oreon->hosts[$host_id]->set_host_template($hostArr['host_template_model']);	
			$oreon->hosts[$host_id]->set_check_interval($hostArr['host_check_interval']);
			$oreon->hosts[$host_id]->set_checks_enabled($hostArr['host_checks_enabled']);
			$oreon->hosts[$host_id]->set_active_checks_enabled($hostArr['host_active_checks_enabled']);
			$oreon->hosts[$host_id]->set_passive_checks_enabled($hostArr['host_passive_checks_enabled']);
			$oreon->hosts[$host_id]->set_obsess_over_host($hostArr['host_obsess_over_host']);
			$oreon->hosts[$host_id]->set_check_freshness($hostArr['host_check_freshness']);
			$oreon->hosts[$host_id]->set_freshness_threshold($hostArr['host_freshness_threshold']);
			$oreon->hosts[$host_id]->set_event_handler_enabled($hostArr['host_event_handler_enabled']);
			$oreon->hosts[$host_id]->set_low_flap_threshold($hostArr['host_low_flap_threshold']);
			$oreon->hosts[$host_id]->set_high_flap_threshold($hostArr['host_high_flap_threshold']);
			$oreon->hosts[$host_id]->set_flap_detection_enabled($hostArr['host_flap_detection_enabled']);
			$oreon->hosts[$host_id]->set_process_perf_data($hostArr['host_process_perf_data']);
			$oreon->hosts[$host_id]->set_retain_status_information($hostArr['host_retain_status_information']);
			$oreon->hosts[$host_id]->set_retain_nonstatus_information($hostArr['host_retain_nonstatus_information']);
			$oreon->hosts[$host_id]->set_notifications_enabled($hostArr['host_notifications_enabled']);
			$oreon->hosts[$host_id]->set_stalking_options($hostArr['host_stalking_options']);
			$oreon->hosts[$host_id]->set_check_period($hostArr['timeperiod_tp_id']);
			$oreon->hosts[$host_id]->set_check_command($hostArr['command_command_id']);
			$oreon->hosts[$host_id]->set_event_handler($hostArr['command_command_id2']);
			$oreon->hosts[$host_id]->set_register(1);
			$oreon->hosts[$host_id]->set_activate(1);
			$oreon->hosts[$host_id]->parents = array();
			$oreon->hosts[$host_id]->hostGroups = array();
			$oreon->saveHost($oreon->hosts[$host_id]);
			$this->hostHash[$oreon->hosts[$host_id]->get_name()] = $host_id;
			unset($host_object);
			unset($hostArr);
		}
		for ($i = 0; $i < count($this->hosts); $i++) 
			if (isset($this->hosts[$i]['parents']))	{
				if (isset($this->hosts[$i]['name']))	{
					$hostParents = array();
					$hostParents = explode(',', $this->hosts[$i]['parents']);
					for ($j = 0; $j < count($hostParents) && trim($hostParents[$j]); $j++)	{
						$hostParents[$j] = trim($hostParents[$j]);
						$oreon->hosts[$this->hostHash[$this->hosts[$i]['name']]]->parents[$this->hostHash[$hostParents[$j]]] = & $oreon->hosts[$this->hostHash[$hostParents[$j]]];
					}
					$oreon->saveHost($oreon->hosts[$this->hostHash[$this->hosts[$i]['name']]]);
					unset($hostParents);
				}	else if (isset($this->hosts[$i]['host_name']))	{
					$hostParents = array();
					$hostParents = explode(',', $this->hosts[$i]['parents']);
					for ($j = 0; $j < count($hostParents) && trim($hostParents[$j]); $j++)	{
						$hostParents[$j] = trim($hostParents[$j]);
						$oreon->hosts[$this->hostHash[$this->hosts[$i]['host_name']]]->parents[$this->hostHash[$hostParents[$j]]] = & $oreon->hosts[$this->hostHash[$hostParents[$j]]];
					}
					$oreon->saveHost($oreon->hosts[$this->hostHash[$this->hosts[$i]['host_name']]]);
					unset($hostParents);				
				}				
			}
}

function saveHostEscalation(& $oreon)	{
	for ($i = 0; $i < count($this->hostEscalations); $i++)	{
		$hostEscalationArr = array();
		$hostEscalationArr['he_id'] = -1;
		isset($this->hostEscalations[$i]['host_name']) ? $hostEscalationArr['host_host_id'] = $this->hostHash[trim($this->hostEscalations[$i]['host_name'])] : $hostEscalationArr['host_host_id'] = NULL;
		isset($this->hostEscalations[$i]['first_notification']) ? $hostEscalationArr['he_first_notification'] = trim($this->hostEscalations[$i]['first_notification']) : $hostEscalationArr['he_first_notification'] = NULL;
		isset($this->hostEscalations[$i]['last_notification']) ? (trim($this->hostEscalations[$i]['last_notification']) ? $hostEscalationArr['he_last_notification'] = trim($this->hostEscalations[$i]['last_notification']) : $hostEscalationArr['he_last_notification'] = 99999) : $hostEscalationArr['he_last_notification'] = 0;
		isset($this->hostEscalations[$i]['notification_interval']) ? (trim($this->hostEscalations[$i]['notification_interval']) ? $hostEscalationArr['he_notification_interval'] = trim($this->hostEscalations[$i]['notification_interval']) : $hostEscalationArr['he_notification_interval'] = 99999) : $hostEscalationArr['he_notification_interval'] = 0;
		isset($this->hostEscalations[$i]['escalation_period']) ? $hostEscalationArr['he_escalation_period'] = $this->timePeriodHash[trim($this->hostEscalations[$i]['escalation_period'])] : $hostEscalationArr['he_escalation_period'] = NULL;
		isset($this->hostEscalations[$i]['escalation_options']) ? $hostEscalationArr['he_escalation_options'] = trim($this->hostEscalations[$i]['escalation_options']) : $hostEscalationArr['he_escalation_options'] = NULL;
		$hostEscalation_object = new HostEscalation($hostEscalationArr);
		if (isset($this->hostEscalations[$i]['contact_groups']))	{
			$contactGroups = array();
			$contactGroups = explode(',', $this->hostEscalations[$i]['contact_groups']);
			for ($j = 0; $j < count($contactGroups) && trim($contactGroups[$j]); $j++)	{
				$contactGroups[$j] = trim($contactGroups[$j]);
				$hostEscalation_object->contactGroups[$this->contactGroupHash[$contactGroups[$j]]] = & $oreon->contactGroups[$this->contactGroupHash[$contactGroups[$j]]];
			}
			unset($contactGroups);
		}
		if (isset($this->hostEscalations[$i]['hostgroup_name']))	{
			$hostGroups = array();
			$hostGroups = explode(',', $this->hostEscalations[$i]['hostgroup_name']);
			for ($j = 0; $j < count($hostGroups) && trim($hostGroups[$j]); $j++)	{
				$hostGroups[$j] = trim($hostGroups[$j]);
				$hostEscalation_object->hostGroups[$this->hostGroupHash[$hostGroups[$j]]] = & $oreon->hostGroups[$this->hostGroupHash[$hostGroups[$j]]];
			}
			unset($hostGroups);
		}
		$oreon->saveHostEscalation($hostEscalation_object);
		$hostEscalation_id = $oreon->database->database->get_last_id();
		$oreon->hes[$hostEscalation_id] = $hostEscalation_object;
		$oreon->hes[$hostEscalation_id]->set_id($hostEscalation_id);
		$oreon->hes[$hostEscalation_id]->set_escalation_period($hostEscalationArr['he_escalation_period']);
		$oreon->hes[$hostEscalation_id]->set_escalation_options($hostEscalationArr['he_escalation_options']);
		$oreon->saveHostEscalation($oreon->hes[$hostEscalation_id]);
		unset($hostEscalation_object);
		unset($hostEscalationArr);
	}
}

function saveHostGroup(& $oreon)	{
	for ($i = 0; $i < count($this->hostGroups); $i++)	{
		$hostGroupArr = array();
		$hostGroupArr['hg_id'] = -1;
		isset($this->hostGroups[$i]['hostgroup_name']) ? $hostGroupArr['hg_name'] = trim($this->hostGroups[$i]['hostgroup_name']) : $hostGroupArr['hg_name'] = NULL;
		isset($this->hostGroups[$i]['alias']) ? $hostGroupArr['hg_alias'] = trim($this->hostGroups[$i]['alias']) : $hostGroupArr['hg_alias'] = NULL;
		$hostGroup_object = new HostGroup($hostGroupArr);
		if (isset($this->hostGroups[$i]['members']))	{
			$hosts = array();
			$hosts = explode(',', $this->hostGroups[$i]['members']);
			for ($j = 0; $j < count($hosts) && trim($hosts[$j]); $j++)	{
				$hosts[$j] = trim($hosts[$j]);
				$hostGroup_object->hosts[$this->hostHash[$hosts[$j]]] = & $oreon->hosts[$this->hostHash[$hosts[$j]]];
			}
			unset($hosts);
		}
		$oreon->saveHostGroup($hostGroup_object);
		$hostGroup_id = $oreon->database->database->get_last_id();
		$oreon->hostGroups[$hostGroup_id] = $hostGroup_object;
		$oreon->hostGroups[$hostGroup_id]->set_id($hostGroup_id);
		$oreon->hostGroups[$hostGroup_id]->set_activate(1);
		if (isset($this->hostGroups[$i]['contact_groups']))	{
			$contactGroups = array();
			$contactGroups = explode(',', $this->hostGroups[$i]['contact_groups']);
			for ($j = 0; $j < count($contactGroups) && trim($contactGroups[$j]); $j++)	{
				$contactGroups[$j] = trim($contactGroups[$j]);
				$oreon->hostGroups[$hostGroup_id]->contact_groups[$this->contactGroupHash[$contactGroups[$j]]] = & $oreon->contactGroups[$this->contactGroupHash[$contactGroups[$j]]];
			}
			unset($contactGroups);
		}		
		$oreon->saveHostGroup($oreon->hostGroups[$hostGroup_id]);
		$this->hostGroupHash[$oreon->hostGroups[$hostGroup_id]->get_name()] = $hostGroup_id;
		unset($hostGroup_object);
		unset($hostGroupArr);
	}
}

function saveHostGroupEscalation(& $oreon)	{
	for ($i = 0; $i < count($this->hostGroupEscalations); $i++)	{
		$hostGroupEscalationArr = array();
		$hostGroupEscalationArr['hge_id'] = -1;
		isset($this->hostGroupEscalations[$i]['hostgroup_name']) ? $hostGroupEscalationArr['hostgroup_hg_id'] = $this->hostGroupHash[trim($this->hostGroupEscalations[$i]['hostgroup_name'])] : $hostGroupEscalationArr['hostgroup_hg_id'] = NULL;
		isset($this->hostGroupEscalations[$i]['first_notification']) ? $hostGroupEscalationArr['hge_first_notification'] = trim($this->hostGroupEscalations[$i]['first_notification']) : $hostGroupEscalationArr['hge_first_notification'] = NULL;
		isset($this->hostGroupEscalations[$i]['last_notification']) ? (trim($this->hostGroupEscalations[$i]['last_notification']) ? $hostGroupEscalationArr['hge_last_notification'] = trim($this->hostGroupEscalations[$i]['last_notification']) : $hostGroupEscalationArr['hge_last_notification'] = 99999) : $hostGroupEscalationArr['hge_last_notification'] = 0;
		isset($this->hostGroupEscalations[$i]['notification_interval']) ? (trim($this->hostGroupEscalations[$i]['notification_interval']) ? $hostGroupEscalationArr['hge_notification_interval'] = trim($this->hostGroupEscalations[$i]['notification_interval']) : $hostGroupEscalationArr['hge_notification_interval'] = 99999) : $hostGroupEscalationArr['hge_notification_interval'] = 0;
		$hostGroupEscalation_object = new HostGroupEscalation($hostGroupEscalationArr);
		if (isset($this->hostGroupEscalations[$i]['contact_groups']))	{
			$contactGroups = array();
			$contactGroups = explode(',', $this->hostGroupEscalations[$i]['contact_groups']);
			for ($j = 0; $j < count($contactGroups) && trim($contactGroups[$j]); $j++)	{
				$contactGroups[$j] = trim($contactGroups[$j]);
				$hostGroupEscalation_object->contactGroups[$this->contactGroupHash[$contactGroups[$j]]] = & $oreon->contactGroups[$this->contactGroupHash[$contactGroups[$j]]];
			}
			unset($contactGroups);
		}
		$oreon->saveHostGroupEscalation($hostGroupEscalation_object);
		$hostGroupEscalation_id = $oreon->database->database->get_last_id();
		$oreon->hges[$hostGroupEscalation_id] = $hostGroupEscalation_object;
		$oreon->hges[$hostGroupEscalation_id]->set_id($hostGroupEscalation_id);
		$oreon->saveHostGroupEscalation($oreon->hges[$hostGroupEscalation_id]);
		unset($hostGroupEscalation_object);
		unset($hostGroupEscalationArr);
	}
}

function saveHostDependencies(& $oreon)	{
	for ($i = 0; $i < count($this->hostDependencies); $i++)	{
		$hostDependencyArr = array();
		$hostDependencyArr['hd_id'] = -1;
		isset($this->hostDependencies[$i]['host_name']) ? $hostDependencyArr['host_host_id'] = $this->hostHash[trim($this->hostDependencies[$i]['host_name'])] : $hostDependencyArr['host_host_id'] = NULL;
		isset($this->hostDependencies[$i]['dependent_host_name']) ? $hostDependencyArr['host_host_id2'] = $this->hostHash[trim($this->hostDependencies[$i]['dependent_host_name'])] : $hostDependencyArr['host_host_id2'] = NULL;
		isset($this->hostDependencies[$i]['notification_failure_criteria']) ? $hostDependencyArr['hd_notification_failure_criteria'] = trim($this->hostDependencies[$i]['notification_failure_criteria']) : $hostDependencyArr['hd_notification_failure_criteria'] = NULL;
		isset($this->hostDependencies[$i]['execution_failure_criteria']) ? $hostDependencyArr['hd_execution_failure_criteria'] = trim($this->hostDependencies[$i]['execution_failure_criteria']) : $hostDependencyArr['hd_execution_failure_criteria'] = NULL;
		isset($this->hostDependencies[$i]['inherits_parent']) ? ($this->hostDependencies[$i]['inherits_parent'] ? $hostDependencyArr['hd_inherits_parent'] = 1 : $hostDependencyArr['hd_inherits_parent'] = 3) : $hostDependencyArr['hd_inherits_parent'] = 2;
		$hostDependency_object = new HostDependency($hostDependencyArr);
		$oreon->saveHostDependency($hostDependency_object);
		$hostDependency_id = $oreon->database->database->get_last_id();
		$oreon->hds[$hostDependency_id] = $hostDependency_object;
		$oreon->hds[$hostDependency_id]->set_id($hostDependency_id);
		$oreon->hds[$hostDependency_id]->set_execution_failure_criteria($hostDependencyArr['hd_execution_failure_criteria']);
		$oreon->hds[$hostDependency_id]->set_inherits_parent($hostDependencyArr['hd_inherits_parent']);
		$oreon->saveHostDependency($oreon->hds[$hostDependency_id]);
		unset($hostDependency_object);
		unset($hostDependencyArr);
	}
}

function saveService(& $oreon, $FromOreon)	{
	for ($i = 0; $i < count($this->services); $i++) 
		if (isset($this->services[$i]['register']) && $this->services[$i]['register'] == 0)	{
			$serviceArr = array();
			$serviceArr['service_id'] = -1;
			if (isset($this->services[$i]['service_description']))	$serviceArr['service_description'] = trim($this->services[$i]['service_description']);
			if (isset($this->services[$i]['name']))	$serviceArr['service_description'] = trim($this->services[$i]['name']);
			if (!isset($serviceArr['service_description'])) $serviceArr['service_description'] = '';
			isset($this->services[$i]['is_volatile']) ? ($this->services[$i]['is_volatile'] ? $serviceArr['service_is_volatile'] = 1 : $serviceArr['service_is_volatile'] = 3) : $serviceArr['service_is_volatile'] = 2;
			isset($this->services[$i]['max_check_attempts']) ? $serviceArr['service_max_check_attempts'] = trim($this->services[$i]['max_check_attempts']) : $serviceArr['service_max_check_attempts'] = NULL;
			isset($this->services[$i]['normal_check_interval']) ? $serviceArr['service_normal_check_interval'] = trim($this->services[$i]['normal_check_interval']) : $serviceArr['service_normal_check_interval'] = NULL;
			isset($this->services[$i]['retry_check_interval']) ? $serviceArr['service_retry_check_interval'] = trim($this->services[$i]['retry_check_interval']) : $serviceArr['service_retry_check_interval'] = NULL;
			isset($this->services[$i]['active_checks_enabled']) ? ($this->services[$i]['active_checks_enabled'] ? $serviceArr['service_active_checks_enabled'] = 1 : $serviceArr['service_active_checks_enabled'] = 3) : $serviceArr['service_active_checks_enabled'] = 2;
			isset($this->services[$i]['passive_checks_enabled']) ? ($this->services[$i]['passive_checks_enabled'] ?	$serviceArr['service_passive_checks_enabled'] = 1 : $serviceArr['service_passive_checks_enabled'] = 3) : $serviceArr['service_passive_checks_enabled'] = 2;
			isset($this->services[$i]['parallelize_check']) ? ($this->services[$i]['parallelize_check'] ? $serviceArr['service_parallelize_check'] = 1 : $serviceArr['service_parallelize_check'] = 3) : $serviceArr['service_parallelize_check'] = 2;
			isset($this->services[$i]['obsess_over_service']) ? ($this->services[$i]['obsess_over_service'] ? $serviceArr['service_obsess_over_service'] = 1 : $serviceArr['service_obsess_over_service'] = 3) : $serviceArr['service_obsess_over_service'] = 2;
			isset($this->services[$i]['check_freshness']) ? ($this->services[$i]['check_freshness'] ? $serviceArr['service_check_freshness'] = 1 : $serviceArr['service_check_freshness'] = 3) : $serviceArr['service_check_freshness'] = 2;
			isset($this->services[$i]['freshness_threshold']) ? (trim($this->services[$i]['freshness_threshold']) ? $serviceArr['service_freshness_threshold'] = trim($this->services[$i]['freshness_threshold']) : $serviceArr['service_freshness_threshold'] = 99999) : $serviceArr['service_freshness_threshold'] = 0;
			isset($this->services[$i]['event_handler_enabled']) ? ($this->services[$i]['event_handler_enabled'] ? $serviceArr['service_event_handler_enabled'] = 1 : $serviceArr['service_event_handler_enabled'] = 3) : $serviceArr['service_event_handler_enabled'] = 2;
			isset($this->services[$i]['low_flap_threshold']) ? (trim($this->services[$i]['low_flap_threshold']) ? $serviceArr['service_low_flap_threshold'] = trim($this->services[$i]['low_flap_threshold']) : $serviceArr['service_low_flap_threshold'] = 99999) : $serviceArr['service_low_flap_threshold'] = 0;
			isset($this->services[$i]['high_flap_threshold']) ? (trim($this->services[$i]['high_flap_threshold']) ? $serviceArr['service_high_flap_threshold'] = trim($this->services[$i]['high_flap_threshold']) : $serviceArr['service_high_flap_threshold'] = 99999) : $serviceArr['service_high_flap_threshold'] = 0;
			isset($this->services[$i]['flap_detection_enabled']) ? ($this->services[$i]['flap_detection_enabled'] ? $serviceArr['service_flap_detection_enabled'] = 1 :	$serviceArr['service_flap_detection_enabled'] = 3) : $serviceArr['service_flap_detection_enabled'] = 2;
			isset($this->services[$i]['process_perf_data']) ? ($this->services[$i]['process_perf_data'] ? $serviceArr['service_process_perf_data'] = 1 : $serviceArr['service_process_perf_data'] = 3) : $serviceArr['service_process_perf_data'] = 2;
			isset($this->services[$i]['retain_status_information']) ? ($this->services[$i]['retain_status_information'] ? $serviceArr['service_retain_status_information'] = 1 : $serviceArr['service_retain_status_information'] = 3) : $serviceArr['service_retain_status_information'] = 2;
			isset($this->services[$i]['retain_nonstatus_information']) ? ($this->services[$i]['retain_nonstatus_information'] ? $serviceArr['service_retain_nonstatus_information'] = 1 : $serviceArr['service_retain_nonstatus_information'] = 3) : $serviceArr['service_retain_nonstatus_information'] = 2;
			isset($this->services[$i]['notification_interval']) ? (trim($this->services[$i]['notification_interval']) ? $serviceArr['service_notification_interval'] = trim($this->services[$i]['notification_interval']) : $serviceArr['service_notification_interval'] = 99999) : $serviceArr['service_notification_interval'] = 0;
			isset($this->services[$i]['notification_options']) ? $serviceArr['service_notification_options'] = trim($this->services[$i]['notification_options']) : $serviceArr['service_notification_options'] = NULL;
			isset($this->services[$i]['notifications_enabled']) ? ($this->services[$i]['notifications_enabled'] ? $serviceArr['service_notifications_enabled'] = 1 : $serviceArr['service_notifications_enabled'] = 3) : $serviceArr['service_notifications_enabled'] = 2;
			isset($this->services[$i]['stalking_options']) ? $serviceArr['service_stalking_options'] = trim($this->services[$i]['stalking_options']) : $serviceArr['service_stalking_options'] = NULL;
			
			isset($this->services[$i]['check_period']) ? $serviceArr['timeperiod_tp_id'] = $this->timePeriodHash[trim($this->services[$i]['check_period'])] : $serviceArr['timeperiod_tp_id'] = NULL;
			isset($this->services[$i]['notification_period']) ? $serviceArr['timeperiod_tp_id2'] = $this->timePeriodHash[trim($this->services[$i]['notification_period'])] : $serviceArr['timeperiod_tp_id2'] = NULL;
			if (isset($this->services[$i]['check_command']))	{
				$checkCommandArr = array();
				$checkCommandArr = explode('!', trim($this->services[$i]['check_command']), 2);
				$serviceArr['command_command_id'] = $this->commandHash[$checkCommandArr[0]];
				if (isset( $checkCommandArr[1]))
					$serviceArr['command_command_id_arg'] = "!".$checkCommandArr[1];
				else
					$serviceArr['command_command_id_arg'] = '';					
				unset($checkCommandArr);
			}	else	{
				$serviceArr['command_command_id'] = '';
				$serviceArr['command_command_id_arg'] = '';			
			}
			if (isset($this->services[$i]['event_handler']))	{
				$eventHandlerArr = array();
				$eventHandlerArr = explode("!", trim($this->services[$i]['event_handler']), 2);
				$serviceArr['command_command_id2'] = $this->commandHash[$eventHandlerArr[0]];
				if (isset($eventHandlerArr[1]))
					$serviceArr['command_command_id2_arg'] = "!".$eventHandlerArr[1];
				else
					$serviceArr['command_command_id2_arg'] = '';
				unset($eventHandlerArr);
			}	else	{
				$serviceArr['command_command_id2'] = '';
				$serviceArr['command_command_id2_arg'] = '';
			}			
			
			$service_object = new Service($serviceArr);
			if (isset($this->services[$i]['contact_groups']))	{
				$contactGroups = array();
				$contactGroups = explode(',', $this->services[$i]['contact_groups']);
				for ($j = 0; $j < count($contactGroups) && trim($contactGroups[$j]); $j++)	{
					$contactGroups[$j] = trim($contactGroups[$j]);
					$service_object->contactGroups[$this->contactGroupHash[$contactGroups[$j]]] = & $oreon->contactGroups[$this->contactGroupHash[$contactGroups[$j]]];
				}
				unset($contactGroups);
			}	else
				$service_object->contactGroups = array();
			$oreon->saveService($service_object);
			$service_id = $oreon->database->database->get_last_id();
			$stm_array["stm_id"] = $service_id;
			$stm_object = new ServiceTemplateModel($stm_array);
			$oreon->stms[$service_id] = $stm_object;
			$oreon->services[$service_id] = $service_object;
			$oreon->services[$service_id]->set_id($service_id);
			$oreon->services[$service_id]->set_is_volatile($serviceArr['service_is_volatile']);
			$oreon->services[$service_id]->set_normal_check_interval($serviceArr['service_normal_check_interval']);
			$oreon->services[$service_id]->set_retry_check_interval($serviceArr['service_retry_check_interval']);
			$oreon->services[$service_id]->set_active_checks_enabled($serviceArr['service_active_checks_enabled']);
			$oreon->services[$service_id]->set_passive_checks_enabled($serviceArr['service_passive_checks_enabled']);
			$oreon->services[$service_id]->set_parallelize_check($serviceArr['service_parallelize_check']);
			$oreon->services[$service_id]->set_obsess_over_service($serviceArr['service_obsess_over_service']);
			$oreon->services[$service_id]->set_check_freshness($serviceArr['service_check_freshness']);
			$oreon->services[$service_id]->set_freshness_threshold($serviceArr['service_freshness_threshold']);
			$oreon->services[$service_id]->set_event_handler_enabled($serviceArr['service_event_handler_enabled']);
			$oreon->services[$service_id]->set_low_flap_threshold($serviceArr['service_low_flap_threshold']);
			$oreon->services[$service_id]->set_high_flap_threshold($serviceArr['service_high_flap_threshold']);
			$oreon->services[$service_id]->set_flap_detection_enabled($serviceArr['service_flap_detection_enabled']);
			$oreon->services[$service_id]->set_process_perf_data($serviceArr['service_process_perf_data']);
			$oreon->services[$service_id]->set_retain_status_information($serviceArr['service_retain_status_information']);
			$oreon->services[$service_id]->set_retain_nonstatus_information($serviceArr['service_retain_nonstatus_information']);
			$oreon->services[$service_id]->set_notification_enabled($serviceArr['service_notifications_enabled']);
			$oreon->services[$service_id]->set_stalking_options($serviceArr['service_stalking_options']);
			$oreon->services[$service_id]->set_event_handler($serviceArr['command_command_id2']);
			$oreon->services[$service_id]->set_register(0);
			$oreon->services[$service_id]->set_activate(1);
			$oreon->services[$service_id]->serviceGroups = array();
			$oreon->saveService($oreon->services[$service_id]);
			$this->serviceHash[$oreon->services[$service_id]->get_description()] = $service_id;
			unset($service_object);
			unset($stm_object);
			unset($stm_array);
			unset($serviceArr);
		}
	for ($i = 0; $i < count($this->services); $i++) 
		if (!isset($this->services[$i]['register']))	{
			$serviceArr = array();
			$serviceArr['service_id'] = -1;
			if (isset($this->services[$i]['host_name']))	$serviceArr['host_host_id'] = $this->hostHash[trim($this->services[$i]['host_name'])]; else $serviceArr['host_host_id'] = '';
			isset($this->services[$i]['service_description']) ?	$serviceArr['service_description'] = trim($this->services[$i]['service_description']) : $serviceArr['service_description'] = NULL;
			isset($this->services[$i]['is_volatile']) ? ($this->services[$i]['is_volatile']  ? $serviceArr['service_is_volatile'] = 1 : $serviceArr['service_is_volatile'] = 3) : $serviceArr['service_is_volatile'] = 2;
			isset($this->services[$i]['max_check_attempts']) ? $serviceArr['service_max_check_attempts'] = trim($this->services[$i]['max_check_attempts']): $serviceArr['service_max_check_attempts'] = NULL;
			isset($this->services[$i]['normal_check_interval']) ? $serviceArr['service_normal_check_interval'] = trim($this->services[$i]['normal_check_interval']) : $serviceArr['service_normal_check_interval'] = NULL;
			isset($this->services[$i]['retry_check_interval']) ? $serviceArr['service_retry_check_interval'] = trim($this->services[$i]['retry_check_interval']) : $serviceArr['service_retry_check_interval'] = NULL;
			isset($this->services[$i]['active_checks_enabled']) ? ($this->services[$i]['active_checks_enabled']  ? $serviceArr['service_active_checks_enabled'] = 1 : $serviceArr['service_active_checks_enabled'] = 3) : $serviceArr['service_active_checks_enabled'] = 2;
			isset($this->services[$i]['passive_checks_enabled']) ? ($this->services[$i]['passive_checks_enabled']  ? $serviceArr['service_passive_checks_enabled'] = 1 : $serviceArr['service_passive_checks_enabled'] = 3) : $serviceArr['service_passive_checks_enabled'] = 2;
			isset($this->services[$i]['parallelize_check']) ? ($this->services[$i]['parallelize_check']  ? $serviceArr['service_parallelize_check'] = 1 : $serviceArr['service_parallelize_check'] = 3) : $serviceArr['service_parallelize_check'] = 2;
			isset($this->services[$i]['obsess_over_service']) ? ($this->services[$i]['obsess_over_service']  ? $serviceArr['service_obsess_over_service'] = 1 : $serviceArr['service_obsess_over_service'] = 3) : $serviceArr['service_obsess_over_service'] = 2;
			isset($this->services[$i]['check_freshness']) ? ($this->services[$i]['check_freshness']  ? $serviceArr['service_check_freshness'] = 1 : $serviceArr['service_check_freshness'] = 3) : $serviceArr['service_check_freshness'] = 2;
			isset($this->services[$i]['freshness_threshold']) ? (trim($this->services[$i]['freshness_threshold']) ? $serviceArr['service_freshness_threshold'] = trim($this->services[$i]['freshness_threshold']) : $serviceArr['service_freshness_threshold'] = 99999) : $serviceArr['service_freshness_threshold'] = 0;
			isset($this->services[$i]['event_handler_enabled']) ? ($this->services[$i]['event_handler_enabled']  ? $serviceArr['service_event_handler_enabled'] = 1 : $serviceArr['service_event_handler_enabled'] = 3) : $serviceArr['service_event_handler_enabled'] = 2;
			isset($this->services[$i]['low_flap_threshold']) ? (trim($this->services[$i]['low_flap_threshold']) ? $serviceArr['service_low_flap_threshold'] = trim($this->services[$i]['low_flap_threshold']) : $serviceArr['service_low_flap_threshold'] = 99999) : $serviceArr['service_low_flap_threshold'] = 0;
			isset($this->services[$i]['high_flap_threshold']) ? (trim($this->services[$i]['high_flap_threshold']) ? $serviceArr['service_high_flap_threshold'] = trim($this->services[$i]['high_flap_threshold']) : $serviceArr['service_high_flap_threshold'] = 99999) : $serviceArr['service_high_flap_threshold'] = 0;
			isset($this->services[$i]['flap_detection_enabled']) ? ($this->services[$i]['flap_detection_enabled'] ? $serviceArr['service_flap_detection_enabled'] = 1 : $serviceArr['service_flap_detection_enabled'] = 3) : $serviceArr['service_flap_detection_enabled'] = 2;
			isset($this->services[$i]['process_perf_data']) ? ($this->services[$i]['process_perf_data']  ? $serviceArr['service_process_perf_data'] = 1 : $serviceArr['service_process_perf_data'] = 3) : $serviceArr['service_process_perf_data'] = 2;
			isset($this->services[$i]['retain_status_information']) ? ($this->services[$i]['retain_status_information']  ? $serviceArr['service_retain_status_information'] = 1 : $serviceArr['service_retain_status_information'] = 3) : $serviceArr['service_retain_status_information'] = 2;
			isset($this->services[$i]['retain_nonstatus_information']) ? ($this->services[$i]['retain_nonstatus_information']  ? $serviceArr['service_retain_nonstatus_information'] = 1 : $serviceArr['service_retain_nonstatus_information'] = 3) : $serviceArr['service_retain_nonstatus_information'] = 2;
			isset($this->services[$i]['notification_interval']) ? (trim($this->services[$i]['notification_interval']) ? $serviceArr['service_notification_interval'] = trim($this->services[$i]['notification_interval']) : $serviceArr['service_notification_interval'] = 99999) : $serviceArr['service_notification_interval'] = 0;
			isset($this->services[$i]['notification_options']) ? $serviceArr['service_notification_options'] = trim($this->services[$i]['notification_options']) : $serviceArr['service_notification_options'] = NULL;
			isset($this->services[$i]['notifications_enabled']) ? ($this->services[$i]['notifications_enabled']  ? $serviceArr['service_notifications_enabled'] = 1 : $serviceArr['service_notifications_enabled'] = 3) : $serviceArr['service_notifications_enabled'] = 2;
			isset($this->services[$i]['stalking_options']) ? $serviceArr['service_stalking_options'] = trim($this->services[$i]['stalking_options']) : $serviceArr['service_stalking_options'] = NULL;
			if (isset($this->services[$i]['use']))	$serviceArr['service_template_model'] = $this->serviceHash[trim($this->services[$i]['use'])];
			
			if (isset($this->services[$i]['check_period']))	$serviceArr['timeperiod_tp_id'] = $this->timePeriodHash[trim($this->services[$i]['check_period'])]; else $serviceArr['timeperiod_tp_id'] = '';
			if (isset($this->services[$i]['notification_period']))	$serviceArr['timeperiod_tp_id2'] = $this->timePeriodHash[trim($this->services[$i]['notification_period'])]; else	$serviceArr['timeperiod_tp_id2'] = '';
			if (isset($this->services[$i]['check_command']))	{
				$checkCommandArr = array();
				$checkCommandArr = explode('!', trim($this->services[$i]['check_command']), 2);
				if (isset($checkCommandArr[0]) && isset($this->services[$i]['use']) && !strcmp($oreon->services[$this->serviceHash[$this->services[$i]['use']]]->get_check_command(), $this->commandHash[$checkCommandArr[0]]))	{
					$serviceArr['command_command_id'] = '';
				} else if ($checkCommandArr[0])	
					$serviceArr['command_command_id'] = $this->commandHash[$checkCommandArr[0]];
				else
					$serviceArr['command_command_id'] = '';
				if (isset( $checkCommandArr[1]))
					$serviceArr['command_command_id_arg'] = "!".$checkCommandArr[1];
				else
					$serviceArr['command_command_id_arg'] = '';				
			}	else	{
				$serviceArr['command_command_id'] = '';
				$serviceArr['command_command_id_arg'] = '';			
			}
			if (isset($this->services[$i]['event_handler']))	{
				$eventHandlerArr = array();
				$eventHandlerArr = explode("!", trim($this->services[$i]['event_handler']), 2);
				$serviceArr['command_command_id2'] = $this->commandHash[$eventHandlerArr[0]];
				if (isset($eventHandlerArr[1]))
					$serviceArr['command_command_id2_arg'] = "!".$eventHandlerArr[1];
				else
					$serviceArr['command_command_id2_arg'] = '';
				unset($eventHandlerArr);
			}	else	{
				$serviceArr['command_command_id2'] = '';
				$serviceArr['command_command_id2_arg'] = '';
			}

			$service_object = new Service($serviceArr);
			if (isset($this->services[$i]['contact_groups']))	{
				$contactGroups = array();
				$contactGroups = explode(',', $this->services[$i]['contact_groups']);
				for ($j = 0; $j < count($contactGroups) && trim($contactGroups[$j]); $j++)	{
					$contactGroups[$j] = trim($contactGroups[$j]);
					$service_object->contactGroups[$this->contactGroupHash[$contactGroups[$j]]] = & $oreon->contactGroups[$this->contactGroupHash[$contactGroups[$j]]];
				}
				unset($contactGroups);
			}	else
				$service_object->contactGroups = array();
			$oreon->saveService($service_object);
			$service_id = $oreon->database->database->get_last_id();
			$oreon->services[$service_id] = $service_object;
			$oreon->services[$service_id]->set_id($service_id);
			if (isset($serviceArr['service_template_model'])) $oreon->services[$service_id]->set_service_template($serviceArr['service_template_model']);
			$oreon->services[$service_id]->set_host($serviceArr['host_host_id']);	
			$oreon->services[$service_id]->set_is_volatile($serviceArr['service_is_volatile']);
			$oreon->services[$service_id]->set_normal_check_interval($serviceArr['service_normal_check_interval']);
			$oreon->services[$service_id]->set_retry_check_interval($serviceArr['service_retry_check_interval']);
			$oreon->services[$service_id]->set_active_checks_enabled($serviceArr['service_active_checks_enabled']);
			$oreon->services[$service_id]->set_passive_checks_enabled($serviceArr['service_passive_checks_enabled']);
			$oreon->services[$service_id]->set_parallelize_check($serviceArr['service_parallelize_check']);
			$oreon->services[$service_id]->set_obsess_over_service($serviceArr['service_obsess_over_service']);
			$oreon->services[$service_id]->set_check_freshness($serviceArr['service_check_freshness']);
			$oreon->services[$service_id]->set_freshness_threshold($serviceArr['service_freshness_threshold']);
			$oreon->services[$service_id]->set_event_handler_enabled($serviceArr['service_event_handler_enabled']);
			$oreon->services[$service_id]->set_low_flap_threshold($serviceArr['service_low_flap_threshold']);
			$oreon->services[$service_id]->set_high_flap_threshold($serviceArr['service_high_flap_threshold']);
			$oreon->services[$service_id]->set_flap_detection_enabled($serviceArr['service_flap_detection_enabled']);
			$oreon->services[$service_id]->set_process_perf_data($serviceArr['service_process_perf_data']);
			$oreon->services[$service_id]->set_retain_status_information($serviceArr['service_retain_status_information']);
			$oreon->services[$service_id]->set_retain_nonstatus_information($serviceArr['service_retain_nonstatus_information']);
			$oreon->services[$service_id]->set_notification_enabled($serviceArr['service_notifications_enabled']);
			$oreon->services[$service_id]->set_stalking_options($serviceArr['service_stalking_options']);
			$oreon->services[$service_id]->set_event_handler($serviceArr['command_command_id2']);
			$oreon->services[$service_id]->set_register(1);
			$oreon->services[$service_id]->set_activate(1);
			$oreon->services[$service_id]->serviceGroups = array();
			if (isset($checkCommandArr) && isset($checkCommandArr[0]) && strstr($checkCommandArr[0], "check_graph"))	{
				if ($FromOreon)
					$oreon->services[$service_id]->set_check_command_arg(preg_replace("/(\![0-9]+)$/", "!".$service_id, $oreon->services[$service_id]->get_check_command_arg()));
				else
					$oreon->services[$service_id]->set_check_command_arg($oreon->services[$service_id]->get_check_command_arg()."!".$service_id);		
				include_once("./include/graph/graphFunctions.php");
				$graph_array = & initGraph($service_id, getcwd());
				$graph = new GraphRRD($graph_array);
				$oreon->saveGraph($graph);
				$oreon->graphs[$service_id] = $graph;
				unset($graph_array);
				unset($graph);
			}
			$oreon->saveService($oreon->services[$service_id]);
			$this->serviceHash[$oreon->services[$service_id]->get_description()] = $service_id;
			unset($service_object);
			unset($serviceArr);
			unset($checkCommandArr);
		}			
}

function saveServiceGroup(& $oreon)	{
	for ($i = 0; $i < count($this->serviceGroups); $i++)	{
		$serviceGroupArr = array();
		$serviceGroupArr['sg_id'] = -1;
		isset($this->serviceGroups[$i]['servicegroup_name']) ? $serviceGroupArr['sg_name'] = trim($this->serviceGroups[$i]['servicegroup_name']) : $serviceGroupArr['sg_name'] = NULL;
		isset($this->serviceGroups[$i]['alias']) ? $serviceGroupArr['sg_alias'] = trim($this->serviceGroups[$i]['alias']) : $serviceGroupArr['sg_alias'] = NULL;
		$serviceGroup_object = new ServiceGroup($serviceGroupArr);
		if (isset($this->serviceGroups[$i]['members']))	{
			$services = array();
			$services = explode(',', $this->serviceGroups[$i]['members']);
			for ($j = 0; $j < count($services) && trim($services[$j]); $j += 2)	{
				$services[$j] = trim($services[$j]);
				$host = trim($services[$j+1]);
				$hostServicesArr = array();
				$hostServicesArr = $oreon->hosts[$this->hostHash[$host]]->services;
				foreach ($hostServicesArr as $service)
					if (!strcmp($service->get_description(), $services[$j]))
						$service_id = $service->get_id();
				$serviceGroup_object->services[$service_id] = & $oreon->services[$service_id];
				$host = NULL;
				unset($hostServicesArr);
			}
			unset($services);
		}
		$oreon->saveServiceGroup($serviceGroup_object);
		$serviceGroup_id = $oreon->database->database->get_last_id();
		$oreon->serviceGroups[$serviceGroup_id] = $serviceGroup_object;
		$oreon->serviceGroups[$serviceGroup_id]->set_id($serviceGroup_id);
		$oreon->serviceGroups[$serviceGroup_id]->set_activate(1);
		$oreon->saveServiceGroup($oreon->serviceGroups[$serviceGroup_id]);
		$this->serviceGroupHash[$oreon->serviceGroups[$serviceGroup_id]->get_name()] = $serviceGroup_id;
		unset($serviceGroup_object);
		unset($serviceGroupArr);
	}
}

function saveServiceEscalation(& $oreon)	{
	for ($i = 0; $i < count($this->serviceEscalations); $i++)	{
		$serviceEscalationArr = array();
		$serviceEscalationArr['se_id'] = -1;
		isset($this->serviceEscalations[$i]['host_name']) ? $serviceEscalationArr['host_host_id'] = $this->hostHash[trim($this->serviceEscalations[$i]['host_name'])] : $serviceEscalationArr['host_host_id'] = NULL;
		isset($this->serviceEscalations[$i]['first_notification']) ? $serviceEscalationArr['se_first_notification'] = trim($this->serviceEscalations[$i]['first_notification']) : $serviceEscalationArr['se_first_notification'] = NULL;
		isset($this->serviceEscalations[$i]['last_notification']) ? (trim($this->serviceEscalations[$i]['last_notification']) ? $serviceEscalationArr['se_last_notification'] = trim($this->serviceEscalations[$i]['last_notification']): $serviceEscalationArr['se_last_notification'] = 99999) : $serviceEscalationArr['se_last_notification'] = 0;
		isset($this->serviceEscalations[$i]['notification_interval']) ? (trim($this->serviceEscalations[$i]['notification_interval']) ? $serviceEscalationArr['se_notification_interval'] = trim($this->serviceEscalations[$i]['notification_interval']) : $serviceEscalationArr['se_notification_interval'] = 99999) : $serviceEscalationArr['se_notification_interval'] = 0;
		isset($this->serviceEscalations[$i]['escalation_period']) ? $serviceEscalationArr['se_escalation_period'] = $this->timePeriodHash[trim($this->serviceEscalations[$i]['escalation_period'])] : $serviceEscalationArr['se_escalation_period'] = NULL;
		isset($this->serviceEscalations[$i]['escalation_options']) ? $serviceEscalationArr['se_escalation_options'] = trim($this->serviceEscalations[$i]['escalation_options']) : $serviceEscalationArr['se_escalation_options'] = NULL;
		$serviceEscalationArr['service_service_id'] = '';
		$serviceEscalationArr['contactGroups'] = array();
		$serviceEscalation_object = new ServiceEscalation($serviceEscalationArr);
		if (isset($this->serviceEscalations[$i]['contact_groups']))	{
			$contactGroups = array();
			$contactGroups = explode(',', $this->serviceEscalations[$i]['contact_groups']);
			for ($j = 0; $j < count($contactGroups) && trim($contactGroups[$j]); $j++)	{
				$contactGroups[$j] = trim($contactGroups[$j]);
				$serviceEscalation_object->contactGroups[$this->contactGroupHash[$contactGroups[$j]]] = & $oreon->contactGroups[$this->contactGroupHash[$contactGroups[$j]]];
			}
			unset($contactGroups);
		}
		if (isset($this->serviceEscalations[$i]['service_description']) && isset($this->serviceEscalations[$i]['host_name']))	{
			$service_id = NULL;
			$hostServicesArr = array();
			$hostServicesArr = $oreon->hosts[$serviceEscalationArr['host_host_id']]->services;
			foreach ($hostServicesArr as $service)
				if (!strcmp($service->get_description(), trim($this->serviceEscalations[$i]['service_description'])))	
					$service_id = $service->get_id();
			$serviceEscalation_object->service = $service_id;
			unset($hostServicesArr);
		}
		$oreon->saveServiceEscalation($serviceEscalation_object);
		$serviceEscalation_id = $oreon->database->database->get_last_id();
		$oreon->ses[$serviceEscalation_id] = $serviceEscalation_object;
		$oreon->ses[$serviceEscalation_id]->set_id($serviceEscalation_id);
		$oreon->ses[$serviceEscalation_id]->set_escalation_period($serviceEscalationArr['se_escalation_period']);
		$oreon->ses[$serviceEscalation_id]->set_escalation_options($serviceEscalationArr['se_escalation_options']);
		$oreon->saveServiceEscalation($oreon->ses[$serviceEscalation_id]);
		unset($serviceEscalation_object);
		unset($serviceEscalationArr);
	}
}

function saveServiceDependencies(& $oreon)	{
	for ($i = 0; $i < count($this->serviceDependencies); $i++)	{
		$serviceDependencyArr = array();
		$serviceDependencyArr['sd_id'] = -1;
		isset($this->serviceDependencies[$i]['host_name']) ? $serviceDependencyArr['host_host_id'] = $this->hostHash[trim($this->serviceDependencies[$i]['host_name'])] : $serviceDependencyArr['host_host_id'] = NULL;
		isset($this->serviceDependencies[$i]['dependent_host_name']) ? $serviceDependencyArr['host_host_id2'] = $this->hostHash[trim($this->serviceDependencies[$i]['dependent_host_name'])] : $serviceDependencyArr['host_host_id2'] = NULL;
		isset($this->serviceDependencies[$i]['notification_failure_criteria']) ? $serviceDependencyArr['sd_notification_failure_criteria'] = trim($this->serviceDependencies[$i]['notification_failure_criteria']) : $serviceDependencyArr['sd_notification_failure_criteria'] = NULL;
		isset($this->serviceDependencies[$i]['execution_failure_criteria']) ? $serviceDependencyArr['sd_execution_failure_criteria'] = trim($this->serviceDependencies[$i]['execution_failure_criteria']) : $serviceDependencyArr['sd_execution_failure_criteria'] = NULL;
		isset($this->serviceDependencies[$i]['inherits_parent']) ? ($this->serviceDependencies[$i]['inherits_parent'] ? $serviceDependencyArr['sd_inherits_parent'] = 1 : $serviceDependencyArr['sd_inherits_parent'] = 3) : $serviceDependencyArr['sd_inherits_parent'] = 2;
		if (isset($this->serviceDependencies[$i]['service_description']) && isset($this->serviceDependencies[$i]['host_name']))	{
			$service_id = NULL;
			$hostServicesArr = array();
			$hostServicesArr = $oreon->hosts[$serviceDependencyArr['host_host_id']]->services;
			foreach ($hostServicesArr as $service)
				if (!strcmp($service->get_description(), trim($this->serviceDependencies[$i]['service_description'])))	
					$service_id = $service->get_id();
			$serviceDependencyArr['service_service_id'] = $service_id;
			unset($hostServicesArr);
		}
		if (isset($this->serviceDependencies[$i]['dependent_service_description']) && isset($this->serviceDependencies[$i]['dependent_host_name']))	{
			$service_id = NULL;
			$hostServicesArr = array();
			$hostServicesArr = $oreon->hosts[$serviceDependencyArr['host_host_id2']]->services;
			foreach ($hostServicesArr as $service)
				if (!strcmp($service->get_description(), trim($this->serviceDependencies[$i]['dependent_service_description'])))	
					$service_id = $service->get_id();
			$serviceDependencyArr['service_service_id2'] = $service_id;
			unset($hostServicesArr);
		}
		$hostDependency_object = new ServiceDependency($serviceDependencyArr);
		$oreon->saveServiceDependency($hostDependency_object);
		$serviceDependency_id = $oreon->database->database->get_last_id();
		$oreon->sds[$serviceDependency_id] = $hostDependency_object;
		$oreon->sds[$serviceDependency_id]->set_id($serviceDependency_id);
		$oreon->sds[$serviceDependency_id]->set_execution_failure_criteria($serviceDependencyArr['sd_execution_failure_criteria']);
		$oreon->sds[$serviceDependency_id]->set_notification_failure_criteria($serviceDependencyArr['sd_notification_failure_criteria']);
		$oreon->sds[$serviceDependency_id]->set_inherits_parent($serviceDependencyArr['sd_inherits_parent']);
		$oreon->saveServiceDependency($oreon->sds[$serviceDependency_id]);
		unset($hostDependency_object);
		unset($serviceDependencyArr);
	}
}

function	saveHostExtendedInfos(& $oreon)	{
	for ($i = 0; $i < count($this->hostExtendedInfos); $i++)	{
		$ehiArr = array();
		$ehiArr["ehi_id"] = -1;
		isset($this->hostExtendedInfos[$i]['host_name']) ? $ehiArr['host_host_id'] = $this->hostHash[trim($this->hostExtendedInfos[$i]['host_name'])] : $ehiArr['host_host_id'] = NULL;
		isset($this->hostExtendedInfos[$i]['notes']) ? $ehiArr['ehi_notes'] = trim($this->hostExtendedInfos[$i]['notes']) : $ehiArr['ehi_notes'] = NULL;
		isset($this->hostExtendedInfos[$i]['notes_url']) ? $ehiArr['ehi_notes_url'] = trim($this->hostExtendedInfos[$i]['notes_url']) : $ehiArr['ehi_notes_url'] = NULL;
		isset($this->hostExtendedInfos[$i]['action_url']) ? $ehiArr['ehi_action_url'] = trim($this->hostExtendedInfos[$i]['action_url']) : $ehiArr['ehi_action_url'] = NULL;
		isset($this->hostExtendedInfos[$i]['icon_image']) ? $ehiArr['ehi_icon_image'] = trim($this->hostExtendedInfos[$i]['icon_image']) : $ehiArr['ehi_icon_image'] = NULL;
		isset($this->hostExtendedInfos[$i]['icon_image_alt']) ? $ehiArr['ehi_icon_image_alt'] = trim($this->hostExtendedInfos[$i]['icon_image_alt']) : $ehiArr['ehi_icon_image_alt'] = NULL;
		isset($this->hostExtendedInfos[$i]['vrml_image']) ? $ehiArr['ehi_vrml_image'] = trim($this->hostExtendedInfos[$i]['vrml_image']) : $ehiArr['ehi_vrml_image'] = NULL;
		isset($this->hostExtendedInfos[$i]['statusmap_image']) ? $ehiArr['ehi_statusmap_image'] = trim($this->hostExtendedInfos[$i]['statusmap_image']) : $ehiArr['ehi_statusmap_image'] = NULL;
		isset($this->hostExtendedInfos[$i]['2d_coords']) ? $ehiArr['ehi_2d_coords'] = trim($this->hostExtendedInfos[$i]['2d_coords']) : $ehiArr['ehi_2d_coords'] = NULL;
		isset($this->hostExtendedInfos[$i]['3d_coords']) ? $ehiArr['ehi_3d_coords'] = trim($this->hostExtendedInfos[$i]['3d_coords']) : $ehiArr['ehi_3d_coords'] = NULL;	
		$ehi_object = new ExtendedHostInformation($ehiArr);
		$oreon->saveExtendedHostInformation($ehi_object);
		$ehi_id = $oreon->database->database->get_last_id();
		$oreon->ehis[$ehi_id] = $ehi_object;
		$oreon->ehis[$ehi_id]->set_id($ehi_id);
		$oreon->ehis[$ehi_id]->set_notes($ehiArr['ehi_notes']);
		$oreon->ehis[$ehi_id]->set_notes_url($ehiArr['ehi_notes_url']);
		$oreon->ehis[$ehi_id]->set_action_url($ehiArr['ehi_action_url']);
		$oreon->ehis[$ehi_id]->set_icon_image($ehiArr['ehi_icon_image']);
		$oreon->ehis[$ehi_id]->set_icon_image_alt($ehiArr['ehi_icon_image_alt']);
		$oreon->ehis[$ehi_id]->set_vrml_image($ehiArr['ehi_vrml_image']);
		$oreon->ehis[$ehi_id]->set_statusmap_image($ehiArr['ehi_statusmap_image']);
		$oreon->ehis[$ehi_id]->set_d2_coords($ehiArr['ehi_2d_coords']);
		$oreon->ehis[$ehi_id]->set_d3_coords($ehiArr['ehi_3d_coords']);
		$oreon->saveExtendedHostInformation($ehi_object);
		unset($ehi_object);
		unset($ehiArr);
	}
}

function	saveServiceExtendedInfos(& $oreon)	{
	for ($i = 0; $i < count($this->serviceExtendedInfos); $i++)	{
		$esiArr = array();
		$esiArr["esi_id"] = -1;
		isset($this->serviceExtendedInfos[$i]['host_name']) ? $esiArr['host_host_id'] = $this->hostHash[trim($this->serviceExtendedInfos[$i]['host_name'])] : $esiArr['host_host_id'] = NULL;
		isset($this->serviceExtendedInfos[$i]['notes']) ? $esiArr['esi_notes'] = trim($this->serviceExtendedInfos[$i]['notes']) : $esiArr['esi_notes'] = NULL;
		isset($this->serviceExtendedInfos[$i]['notes_url']) ? $esiArr['esi_notes_url'] = trim($this->serviceExtendedInfos[$i]['notes_url']) : $esiArr['esi_notes_url'] = NULL;
		isset($this->serviceExtendedInfos[$i]['action_url']) ? $esiArr['esi_action_url'] = trim($this->serviceExtendedInfos[$i]['action_url']) : $esiArr['esi_action_url'] = NULL;
		isset($this->serviceExtendedInfos[$i]['icon_image']) ? $esiArr['esi_icon_image'] = trim($this->serviceExtendedInfos[$i]['icon_image']) : $esiArr['esi_icon_image'] = NULL;
		isset($this->serviceExtendedInfos[$i]['icon_image_alt']) ? $esiArr['esi_icon_image_alt'] = trim($this->serviceExtendedInfos[$i]['icon_image_alt']) : $esiArr['esi_icon_image_alt'] = NULL;	
		if (isset($this->serviceExtendedInfos[$i]['service_description']) && isset($this->serviceExtendedInfos[$i]['host_name']))	{
			$service_id = NULL;
			$hostServicesArr = array();
			$hostServicesArr = $oreon->hosts[$esiArr['host_host_id']]->services;
			foreach ($hostServicesArr as $service)
				if (!strcmp($service->get_description(), trim($this->serviceExtendedInfos[$i]['service_description'])))	
					$service_id = $service->get_id();
			$esiArr['service_service_id'] = $service_id;
			unset($hostServicesArr);
		}
		$esi_object = new ExtendedServiceInformation($esiArr);
		$oreon->saveExtendedServiceInformation($esi_object);
		$esi_id = $oreon->database->database->get_last_id();
		$oreon->esis[$esi_id] = $esi_object;
		$oreon->esis[$esi_id]->set_id($esi_id);
		$oreon->esis[$esi_id]->set_notes($esiArr['esi_notes']);
		$oreon->esis[$esi_id]->set_notes_url($esiArr['esi_notes_url']);
		$oreon->esis[$esi_id]->set_action_url($esiArr['esi_action_url']);
		$oreon->esis[$esi_id]->set_icon_image($esiArr['esi_icon_image']);
		$oreon->esis[$esi_id]->set_icon_image_alt($esiArr['esi_icon_image_alt']);
		$oreon->saveExtendedServiceInformation($esi_object);
		unset($esi_object);
		unset($esiArr);
	}
}

}
?>