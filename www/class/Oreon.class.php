<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/
include_once "AbstractHost.class.php";
include_once "AbstractService.class.php";
include_once "AutoDetect.class.php";
include_once "Colors.class.php";
include_once "Command.class.php";
include_once "Contact.class.php";
include_once "ContactGroup.class.php";
include_once "OreonDatabase.class.php";
include_once "Email.class.php";
include_once "ExtendedHostInformation.class.php";
include_once "ExtendedServiceInformation.class.php";
include_once "Graph.class.php";
include_once "GraphModel.class.php";
include_once "HostFather.class.php";
include_once "Host.class.php";
include_once "HostDependency.class.php";
include_once "HostEscalation.class.php";
include_once "HostGroup.class.php";
include_once "HostGroupEscalation.class.php";
include_once "HostParent.class.php";
include_once "HostTemplateModel.class.php";
include_once "HtmlImage.class.php";
include_once "Image.class.php";
include_once "Nagioscfg.class.php";
include_once "ProfileHost.class.php";
include_once "ServiceFather.class.php";
include_once "Service.class.php";
include_once "ServiceDependency.class.php";
include_once "ServiceEscalation.class.php";
include_once "ServiceGroup.class.php";
include_once "ServiceTemplateModel.class.php";
include_once "TimePeriod.class.php";
include_once "User.class.php";
include_once "TrafficMap.class.php";
include_once "OptGen.class.php";
include_once "DaGen.class.php";
include_once "Log.class.php";
include_once "Lca.class.php";
include_once "class.pdf.php";
include_once "class.ezpdf.php";
include_once "Resources.class.php";
include_once "NagiosConfigFile.class.php";
include_once "RedirectTo.class.php";


class Oreon	{

	/** "Host object" array */
	var $hosts;

	/**  "Command object" array */
	var $commands;

	/**  "Service object" array	*/
	var $services;

	var $database;

	var $user;

	var $users;

	/**  "Contact Group object" array */
	var $contactGroups;

	/**  "Time Period object" array */
	var $time_periods;

	/**  "Host Template Model" array */
	var $htms;

	/**  "Service Template Model" array */
	var $stms;

	/**  "Contact object" array */
	var $contacts;

	/**  "Host Group object" array */
	var $hostGroups;

	/**  "Service Group object" array */
	var $serviceGroups;

	/**  "Extended service information object" array */
	var $esis;

	/**  "Extended host information object" array	*/
	var $ehis;

	/**  "Host escalation object" array */
	var $hes;

	/**  "HostGroup escalation object" array */
	var $hges;

	/**  "Service escalation object" array	*/
	var $ses;

	/**  "Service Dependencies object" array	*/
	var $sds;

	/**  "Host Dependencies object" array */
	var $hds;

	/** Profile Hosts	*/

	var $profileHosts;

	/** Auto Detect	*/

	var $AutoDetect;

	var $Nagioscfg;

	var $resourcecfg;

	/**	Graphs	*/

	var $graphs;
	var $graphModels;
	var $graphModelDS;

	/** Color */
	var $colors_list;

	/**	traffic Map	*/

	var $trafficMaps;

	/**	Options Generales ?	*/

	var $optGen;
	
	/**	Dialup admin Options	*/

	var $daGen;

	/**  Program logs */

	var $Log_p;

	/**  logs	*/

	var $Logs;

	/**  Program lca */

	var $Lca;

	/** Users Online */

	var $user_online;

	// Operations

	function Oreon($user, $database)
	{
		$this->user = $user;
		$this->database = $database;
	}

	function loadUser($user = -1)
	{
		$this->user[$user["user_id"]] = new User($user);
	}

	function loadUsers($user = -1)
	{
		$user = $this->database->getUser($user);
		foreach ($user as $usr)	{
			$this->users[$usr["user_id"]] = new User($usr);
			unset($usr);
		}
	}

	function saveUser($new_user)
	{
		$this->set_flag_user(session_id(), '24');
		if ($new_user->get_id() == -1) // Insert new user in database
			$this->database->saveUser($new_user);
		else // Update user in database
			$this->database->saveUser($new_user);
	}

	function saveUserPasswd($user)
	{
		$this->database->saveUserPasswd($user);
	}

	function deleteUsers($user)
	{
		$this->set_flag_user(session_id(), '24');
		$this->database->deleteUsers($user);
		//$this->deleteLCAHosts($user->get_id(), 0);
		if (isset($this->Lca[$user->get_id()]))
		{
			unset($this->Lca[$user->get_id()]);
			$this->deleteLCA($user->get_id());
			$this->deleteLCAHosts($user->get_id(), 0);
		}
		unset($this->users[$user->get_id()]);
	}

	// Load Option Generale

	function loadoptgen()	{
		$opt = $this->database->getoptGen();
		$this->optGen = new optGen($opt);
	}

	function saveoptgen($opt)	{
		$this->set_flag_user(session_id(), '21');
		$this->database->saveoptGen($opt);
	}
	
	// Load Dialup admin Option

	function loaddagen()	{
		$da = $this->database->getdaGen();
		$this->daGen = new daGen($da);
	}

	function savedagen($da)	{
		$this->set_flag_user(session_id(), '21');
		$this->database->savedaGen($da);
	}

	// LCA
	function is_accessible($host_id)	{
		if ($this->user->get_status() == 1){
			if (isset($this->Lca[$this->user->get_id()])){
				if (count($this->Lca[$this->user->get_id()]->restrict) == 0)
					return true;

				else if (isset($this->Lca[$this->user->get_id()]->restrict[$host_id]))
					return true;
				else
					return false;
			}
			else if (!isset($this->Lca[$this->user->get_id()]))
					return true;
		} else if ($this->user->get_status() == 2)
			return true;
		else if ($this->user->get_status() == 3)
			return true;
		else
			return false;
	}

	function loadLca($lca = -1) 	{
		$lcas = $this->database->getLCA($lca);
		foreach ($lcas as $lca)	{
			$this->Lca[$lca["user_id"]] = new Lca($lca);
			$tab = $this->database->getHostLCA($lca["user_id"]); // get right informations of each user...
			$this->Lca[$lca["user_id"]]->restrict = array(); // create a new tab
			foreach ($tab as $lca_host)	{
				$this->Lca[$lca["user_id"]]->restrict[$lca_host["host_host_id"]] = new Lca_hosts($lca_host);
				unset($lca_host);
			}
			unset($lca);
		}
	}

	function saveLcaHosts($lca)	{
		$this->set_flag_user(session_id(), '25');
		//$this->database->deleteLCA_hosts($lca);
		$this->database->saveLCA_hosts($lca);
	}

	function saveLca($restrict)	{
		$this->set_flag_user(session_id(), '25');
		if ($restrict->get_id() == -1)// Insert new lca entry in database
			$this->database->saveLca($restrict);
		else // Update Lca in database
			$this->database->saveLCA($this->Lca[$restrict->get_id()]);
	}

	function deleteLCAHosts($user_id, $host_id)	{
		$this->set_flag_user(session_id(), '25');
		$this->database->deleteLCAHosts($user_id, $host_id);
		unset($this->Lca);
		$this->LoadLca();
	}

	function deleteLCA($user_id)	{
		$this->set_flag_user(session_id(), '25');
		$this->database->deleteLCA($user_id);
	}

	// NagiosCFG

	function loadNagioscfg()	{
		$opt = $this->database->getNagioscfg();
		$this->Nagioscfg = new Nagioscfg($opt);
	}

	function saveNagioscfg($opt)	{
		$this->set_flag_user(session_id(), '22');
		$this->database->saveNagioscfg($opt);
	}

	// ResourcesCFG

	function loadResourcecfg()	{
		$this->resourcecfg = array();
		$rscfg = $this->database->getResourcecfg();
		foreach ($rscfg as $rs)
			$this->resourcecfg[$rs["resource_id"]] = new Resourcecfg($rs);
	}

	function saveResourcecfg($rscfg)	{
		$this->set_flag_user(session_id(), '23');
		$this->database->saveResourcecfg($rscfg);
	}

	function deleteResourcecfg($rscfg)	{
		$this->set_flag_user(session_id(), '23');
		$this->database->deleteResourcecfg($rscfg);
		unset($this->resourcecfg[$rscfg->get_id()]);
	}

	//Service

	function loadService($serv = -1)	{	// set an array of "service object" for current object oreon
		$this->services = array();
		$s =& $this->database->getService($serv);
		foreach ($s as $service)	{
			$this->services[$service["service_id"]] = new Service($service);
			//
			$this->services[$service["service_id"]]->set_service_template($service["service_template_model_stm_id"]);
			$this->services[$service["service_id"]]->set_is_volatile($service["service_is_volatile"]);
			$this->services[$service["service_id"]]->set_active_checks_enabled($service["service_active_checks_enabled"]);
			$this->services[$service["service_id"]]->set_passive_checks_enabled($service["service_passive_checks_enabled"]);
			$this->services[$service["service_id"]]->set_parallelize_check($service["service_parallelize_check"]);
			$this->services[$service["service_id"]]->set_obsess_over_service($service["service_obsess_over_service"]);
			$this->services[$service["service_id"]]->set_check_freshness($service["service_check_freshness"]);
			$this->services[$service["service_id"]]->set_freshness_threshold($service["service_freshness_threshold"]);
			$this->services[$service["service_id"]]->set_event_handler_enabled($service["service_event_handler_enabled"]);
			$this->services[$service["service_id"]]->set_check_command_arg($service["command_command_id_arg"]);
			$this->services[$service["service_id"]]->set_event_handler($service["command_command_id2"]);
			$this->services[$service["service_id"]]->set_event_handler_arg($service["command_command_id_arg2"]);
			$this->services[$service["service_id"]]->set_low_flap_threshold($service["service_low_flap_threshold"]);
			$this->services[$service["service_id"]]->set_high_flap_threshold($service["service_high_flap_threshold"]);
			$this->services[$service["service_id"]]->set_flap_detection_enabled($service["service_flap_detection_enabled"]);
			$this->services[$service["service_id"]]->set_process_perf_data($service["service_process_perf_data"]);
			$this->services[$service["service_id"]]->set_retain_status_information($service["service_retain_status_information"]);
			$this->services[$service["service_id"]]->set_retain_nonstatus_information($service["service_retain_nonstatus_information"]);
			$this->services[$service["service_id"]]->set_notification_enabled($service["service_notification_enabled"]);
			$this->services[$service["service_id"]]->set_stalking_options($service["service_stalking_options"]);
			$this->services[$service["service_id"]]->set_comment($service["service_comment"]);
			$this->services[$service["service_id"]]->set_register($service["service_register"]);
			$this->services[$service["service_id"]]->set_activate($service["service_activate"]);
			//
			$this->loadserviceContactGroup($this->services[$service["service_id"]]);
			$this->loadHostServiceRelation(-1, $this->services[$service["service_id"]]);
			unset($service);
		}
		unset($s);
		if (isset($this->hosts))
			foreach ($this->hosts as $host)	{
				$this->loadHostServiceRelation($host);
				unset($host);
			}
	}

	function saveService($service)	{
		$this->set_flag_user(session_id(), '7');
		$this->set_flag_user(session_id(), '11');
		if ($service->get_id() == -1)	// Insert new service in database
			$this->database->saveService($service);
		else	{// Update service in database
			$this->database->saveService($this->services[$service->get_id()]);
			$this->database->saveServiceContactGroups($service);
			if ($service->get_register())
				$this->database->saveServiceHostRelation($this->hosts[$service->get_host()], $service);
			$this->database->saveServicegroupServiceRelation(-1, $service);
			$this->updateServiceInServiceGroups($service);
			if (isset($this->hosts) && $service->get_register())	{
				foreach ($this->hosts as $host)	{
					if (isset($host->services) && array_key_exists($service->get_id(), $host->services))
						unset($this->hosts[$host->get_id()]->services[$service->get_id()]);
					unset($host);
				}
				$this->hosts[$service->get_host()]->services[$service->get_id()] = & $this->services[$service->get_id()];
			}
		}
	}

	function deleteService($service)	{
		$this->set_flag_user(session_id(), '7');
		$this->set_flag_user(session_id(), '11');
		$this->database->deleteService($service);
		$this->database->deleteCGServiceRelation($service);
		$this->database->deleteServiceGroupServiceRelation($service);
		$this->database->deleteServiceExtendedServiceInformation($service);
		$this->database->deleteHostServiceRelation($service);
		if (!$service->get_register())
			foreach($this->services as $service_temp)	{
				if ($service_temp->get_service_template() == $service->get_id() && $service_temp->get_register())
					$this->deleteService($service_temp);
				unset($service_temp);
			}
		if (isset($this->trafficMaps)) // Delete traffic map host service associated with service
			foreach ($this->trafficMaps as $trafficMap)	{
				if (isset($trafficMap->TMHosts))
					foreach ($trafficMap->TMHosts as $TMHost)	{
						if ($TMHost->get_service() == $service->get_id())
							$this->deleteTrafficMapHost($TMHost);
						unset($TMHost);
					}
				unset($trafficMap);
			}
		if (isset($this->graphs)) // Delete graph associated with service
			if (array_key_exists($service->get_id(), $this->graphs))
				$this->deleteGraph($this->graphs[$service->get_id()]);
		if (isset($this->esis)) // Unset Extended service information
			foreach ($this->esis as $esi)	{
				if ($service->get_id() == $esi->get_service())
					unset($this->esis[$esi->get_id()]);
				unset($esi);
			}
		if (isset($this->hosts)) // Unset Service in host "service array"
			foreach ($this->hosts as $host)	{
				if (isset($host->services))
					if (array_key_exists($service->get_id(), $host->services))
						unset($this->hosts[$host->get_id()]->services[$service->get_id()]);
				unset($host);
			}
		if (isset($this->serviceGroups)) // Delete Service group if there's only one service associated with it
			foreach ($this->serviceGroups as $serviceGroup)	{
				if (isset($serviceGroup->services))
					if (array_key_exists($service->get_id(), $serviceGroup->services))	{
						if (count($serviceGroup->services) == 1)
							$this->deleteServiceGroup($serviceGroup);
						else // Just unset in service group the service we delete
							unset($this->serviceGroups[$serviceGroup->get_id()]->services[$service->get_id()]);
					}
				unset($serviceGroup);
			}
		if (isset($this->ses)) // Delete Service escalation associated with service
			foreach ($this->ses as $se)	{
				if ($service->get_id() == $se->get_service())
					$this->deleteServiceEscalation($se);
				unset($se);
			}
		if (isset($this->sds)) // Delete Service dependecies associated with service
			foreach ($this->sds as $sd)	{
				if ($service->get_id() == $sd->get_service())
					$this->deleteServiceDependency($sd);
				if ($service->get_id() == $sd->get_service_dependent())
					$this->deleteServiceDependency($sd);
				unset($sd);
			}
		unset($this->services[$service->get_id()]);
		unset($this->stms[$service->get_id()]);
		unset($service);
		reset($this->services);
	}

	// Update Service In Service Groups (V2 style...)

	function updateServiceInServiceGroups($service = -1, $serviceGroup = -1)
	{
		$this->set_flag_user(session_id(), '10');
		if (isset($service) && $service != -1)	{
			if (isset($service->serviceGroups) && isset($this->serviceGroups))	{
				foreach ($this->serviceGroups as $serviceGroup)	{
					if (array_key_exists($serviceGroup->get_id(), $service->serviceGroups))
						$this->serviceGroups[$serviceGroup->get_id()]->services[$service->get_id()] = & $this->services[$service->get_id()];
					else	{
						unset ($this->serviceGroups[$serviceGroup->get_id()]->services[$service->get_id()]);
						if (!count($this->serviceGroups[$serviceGroup->get_id()]->services))
							$this->deleteServiceGroup($serviceGroup);
					}
					unset($serviceGroup);
				}
			}	else if (isset($this->serviceGroups))	{
					foreach ($this->serviceGroups as $serviceGroup)	{
						if (array_key_exists($service->get_id(), $serviceGroup->services))	{
							unset ($this->serviceGroups[$serviceGroup->get_id()]->services[$service->get_id()]);
							if (!count($this->serviceGroups[$serviceGroup->get_id()]->services))
								$this->deleteServiceGroup($serviceGroup);
						}
						unset($serviceGroup);
					}
				}
		}	else if (isset($this->serviceGroups))	{
				foreach ($this->services as $service)	{
					if (array_key_exists($service->get_id(), $serviceGroup->services))
						$this->services[$service->get_id()]->serviceGroups[$serviceGroup->get_id()] = & $this->serviceGroups[$serviceGroup->get_id()];
					else
						unset ($this->services[$service->get_id()]->serviceGroups[$serviceGroup->get_id()]);
					unset($service);
				}
			}
	}


	// Service Template Model
	function loadServiceTemplateModel() {	// set an array of "Service Template Model" for current object oreon
		$this->stms = array();
		if (isset($this->services))
			foreach ($this->services as $service)
				if (!$service->get_register())	{
					$stm["stm_id"] = $service->get_id();
					$this->stms[$stm["stm_id"]] = new ServiceTemplateModel($stm);
					unset($stm);
			}
	}

	// Service Contact group Relation
	function loadserviceContactGroup($service = -1) {	// set an array of "cg object" for current object service
		$contactGroups = $this->database->getServiceContactGroup($service);
		foreach ($contactGroups as $contactGroup)	{
			$this->services[$service->get_id()]->contactGroups[$contactGroup["contactgroup_cg_id"]] = & $this->contactGroups[$contactGroup["contactgroup_cg_id"]];
			unset($contactGroup);
		}
	}

	// Service Escalation
	function loadServiceEscalation() {	// set an array of "Service Escalation object" for current object oreon
		$this->ses = array();
		$ses = $this->database->getServiceEscalation();
		foreach ($ses as $se)	{
			$se["contactGroups"] = array();
			$this->ses[$se["se_id"]] = new ServiceEscalation($se);
			if ($se["timeperiod_tp_id"])
				$this->ses[$se["se_id"]]->set_escalation_period($se["timeperiod_tp_id"]);
			else
				$this->ses[$se["se_id"]]->set_escalation_period(NULL);
			$this->ses[$se["se_id"]]->set_escalation_options($se["se_escalation_options"]);
			$this->loadContactGroupServiceEscalation($this->ses[$se["se_id"]]);
			unset($se);
		}
	}

	function saveServiceEscalation($se)	{
		$this->set_flag_user(session_id(), '8');
		if ($se->get_id() == -1) // Insert new service escalation in database
			$this->database->saveServiceEscalation($se);
		else	{ // Update service escalation in database
			$this->database->saveServiceEscalation($this->ses[$se->get_id()]);
			$this->database->saveContactGroupServiceEscalation($se);
		}
	}

	function deleteServiceEscalation($se)		{
		$this->set_flag_user(session_id(), '8');
		$this->database->deleteServiceEscalation($this->ses[$se->get_id()]);
		$this->database->deleteContactGroupServiceEscalation($this->ses[$se->get_id()], NULL);
		unset ($this->ses[$se->get_id()]);
	}

	// Service Escalation Contact Group Relation
	function loadContactGroupServiceEscalation($se)		{
		$cgs = $this->database->getContactGroupServiceEscalation($se);
		foreach ($cgs as $cg)	{
			$this->ses[$se->get_id()]->contactGroups[$cg["contactgroup_cg_id"]] = & $this->contactGroups[$cg["contactgroup_cg_id"]];
			unset($cg);
		}
	}

	// Service Dependency
	function loadServiceDependency() {	// set an array of "Service Dependency object" for current object oreon
		$this->sds = array();
		$sds = $this->database->getServiceDependency();
		foreach ($sds as $sd)	{
			$this->sds[$sd["sd_id"]] = new ServiceDependency($sd);
			$this->sds[$sd["sd_id"]]->set_inherits_parent($sd["sd_inherits_parent"]);
			$this->sds[$sd["sd_id"]]->set_execution_failure_criteria($sd["sd_execution_failure_criteria"]);
			$this->sds[$sd["sd_id"]]->set_notification_failure_criteria($sd["sd_notification_failure_criteria"]);
			unset($sd);
		}
	}

	function saveServiceDependency($sd)	{
		$this->set_flag_user(session_id(), '9');
		if ($sd->get_id() == -1) // Insert new service dependency in database
			$this->database->saveServiceDependency($sd);
		else // Update service escalation in database
			$this->database->saveServiceDependency($this->sds[$sd->get_id()]);
	}

	function deleteServiceDependency($sd)	{
		$this->set_flag_user(session_id(), '9');
		$this->database->deleteServiceDependency($this->sds[$sd->get_id()]);
		unset ($this->sds[$sd->get_id()]);
	}

	//Extended service information

	function loadExtendedServiceInformation($esi = -1) {	// set an array of "Extended service information object" for current object oreon
		$this->esis = array();
		$esis = $this->database->getExtendedServiceInformation($esi);
		foreach ($esis as $esi)	{
			$this->esis[$esi["esi_id"]] = new ExtendedServiceInformation($esi);
			$this->esis[$esi["esi_id"]]->set_notes($esi["esi_notes"]);
			$this->esis[$esi["esi_id"]]->set_notes_url($esi["esi_notes_url"]);
			$this->esis[$esi["esi_id"]]->set_action_url($esi["esi_action_url"]);
			if ($esi["esi_icon_image"] != NULL)
				$this->esis[$esi["esi_id"]]->set_icon_image($esi["esi_icon_image"]);
			else
				$this->esis[$esi["esi_id"]]->set_icon_image(NULL);
			$this->esis[$esi["esi_id"]]->set_icon_image_alt($esi["esi_icon_image_alt"]);
			unset($esi);
		}
	}

	function saveExtendedServiceInformation($esi)	{
		$this->set_flag_user(session_id(), '12');
		if ($esi->get_id() == -1) // Insert new extended service information in database
			$this->database->saveExtendedServiceInformation($esi);
		else // Update extended service information in database
			$this->database->saveExtendedServiceInformation($this->esis[$esi->get_id()]);
	}

	function deleteExtendedServiceInformation($esi)	{
		$this->set_flag_user(session_id(), '12');
		$this->database->deleteExtendedServiceInformation($this->esis[$esi->get_id()]);
		unset ($this->esis[$esi->get_id()]);
	}

	// Service Group

	function loadServiceGroup($sg_id = -1) {	// set an array of "Service Group object" for current object oreon
		$this->serviceGroups = array();
		$serviceGroups = $this->database->getServiceGroup($sg_id);
		foreach ($serviceGroups as $serviceGroup)	{
			$this->serviceGroups[$serviceGroup["sg_id"]] = new ServiceGroup($serviceGroup);
			$this->serviceGroups[$serviceGroup["sg_id"]]->set_comment($serviceGroup["sg_comment"]);
			$this->serviceGroups[$serviceGroup["sg_id"]]->set_activate($serviceGroup["sg_activate"]);
			$this->serviceGroups[$serviceGroup["sg_id"]]->services = array();
			$this->loadServiceGroupService($this->serviceGroups[$serviceGroup["sg_id"]]);
			unset($serviceGroup);
		}
		if (isset($this->services))
			foreach ($this->services as $service)	{
				$this->loadServiceGroupService(-1, $service);
				unset($service);
			}
	}

	function saveServiceGroup($serviceGroup)	{
		$this->set_flag_user(session_id(), '10');
		if ($serviceGroup->get_id() == -1) // Insert new service Group in database
			$this->database->saveServiceGroup($serviceGroup);
		else	{ // Update Service Group in database
			$this->database->saveServiceGroup($this->serviceGroups[$serviceGroup->get_id()]);
			$this->database->saveServiceGroupServiceRelation($serviceGroup);
			$this->updateServiceInServiceGroups(-1, $serviceGroup);
		}
	}

	function deleteServiceGroup($serviceGroup)	{ // Delete Service Group in database
		$this->set_flag_user(session_id(), '10');
		$this->database->deleteServiceGroup($this->serviceGroups[$serviceGroup->get_id()]);
		$this->database->deleteServiceGroupServiceRelation(-1, $this->serviceGroups[$serviceGroup->get_id()]); //Delete ServiceGroup Service Relation in database
		if (isset($this->services))
			foreach ($this->services as $service)	{
				if (isset($service->serviceGroups))
					if (array_key_exists($serviceGroup->get_id(), $service->serviceGroups))
						unset($this->services[$service->get_id()]->serviceGroups[$serviceGroup->get_id()]);
				unset($service);
			}
		unset ($this->serviceGroups[$serviceGroup->get_id()]);
	}

	// Emul services from service group for monitoring

	function emulServiceGroupServices(& $svg)		{
		if (isset($svg) && !isset($svg->servicesEmul))	{
			$svg->servicesEmul = array();
			foreach ($svg->services as $SGservice)	{
				if ($SGservice->get_register())
					$svg->servicesEmul[$SGservice->get_id()] = & $this->services[$SGservice->get_id()];
				else	{
					foreach($this->services as $service)	{
						if ($service->get_service_template() == $SGservice->get_id())
							$svg->servicesEmul[$service->get_id()] = & $this->services[$service->get_id()];
						unset($service);
					}
				}
				unset($SGservice);
			}
		}
	}

	// Service Group Service Relation

	function loadServiceGroupService($serviceGroup = -1, $service = -1) {	// set an array of "Service object" for current object ServiceGroups
		if (isset($serviceGroup) && $serviceGroup != -1)	{
			$this->serviceGroups[$serviceGroup->get_id()]->services = array();
			$services = $this->database->getServiceGroupService($serviceGroup);
			if (isset($services))
				foreach ($services as $service)	{
					$this->serviceGroups[$serviceGroup->get_id()]->services[$service["service_service_id"]] = & $this->services[$service["service_service_id"]];
					unset($service);
				}
		}	else	{
			$this->services[$service->get_id()]->serviceGroups = array();
			$serviceGroups = $this->database->getServiceGroupService(-1, $service);
			if (isset($serviceGroups))
				foreach ($serviceGroups as $serviceGroup)	{
					$this->services[$service->get_id()]->serviceGroups[$serviceGroup["servicegroup_sg_id"]] = & $this->serviceGroups[$serviceGroup["servicegroup_sg_id"]];
					unset($serviceGroup);
				}
		}
	}

	// Host

	function loadHost($host = -1) {	// set an array of "Host object" for current object oreon
		$this->hosts = array();
		$h = $this->database->getHost($host);
		foreach ($h as $host)	{
			$this->hosts[$host["host_id"]] = new Host($host);
			$this->hosts[$host["host_id"]]->set_host_template($host["host_template_model_htm_id"]);
			$this->hosts[$host["host_id"]]->set_check_command($host["command_command_id"]);
			$this->hosts[$host["host_id"]]->set_event_handler($host["command_command_id2"]);
			$this->hosts[$host["host_id"]]->set_check_period($host["timeperiod_tp_id"]);
			$this->hosts[$host["host_id"]]->set_notification_period($host["timeperiod_tp_id2"]);
			$this->hosts[$host["host_id"]]->set_check_interval($host["host_check_interval"]);
			$this->hosts[$host["host_id"]]->set_active_checks_enabled($host["host_active_checks_enabled"]);
			$this->hosts[$host["host_id"]]->set_passive_checks_enabled($host["host_passive_checks_enabled"]);
			$this->hosts[$host["host_id"]]->set_checks_enabled($host["host_check_enabled"]);
			$this->hosts[$host["host_id"]]->set_obsess_over_host($host["host_obsess_over_host"]);
			$this->hosts[$host["host_id"]]->set_check_freshness($host["host_check_freshness"]);
			$this->hosts[$host["host_id"]]->set_freshness_threshold($host["host_freshness_threshold"]);
			$this->hosts[$host["host_id"]]->set_event_handler_enabled($host["host_event_handler_enabled"]);
			$this->hosts[$host["host_id"]]->set_low_flap_threshold($host["host_low_flap_threshold"]);
			$this->hosts[$host["host_id"]]->set_high_flap_threshold($host["host_high_flap_threshold"]);
			$this->hosts[$host["host_id"]]->set_flap_detection_enabled($host["host_flap_detection_enabled"]);
			$this->hosts[$host["host_id"]]->set_process_perf_data($host["host_process_perf_data"]);
			$this->hosts[$host["host_id"]]->set_retain_status_information($host["host_retain_status_information"]);
			$this->hosts[$host["host_id"]]->set_retain_nonstatus_information($host["host_retain_nonstatus_information"]);
			$this->hosts[$host["host_id"]]->set_notifications_enabled($host["host_notifications_enabled"]);
			$this->hosts[$host["host_id"]]->set_stalking_options($host["host_stalking_options"]);
			$this->hosts[$host["host_id"]]->set_comment($host["host_comment"]);
			$this->hosts[$host["host_id"]]->set_register($host["host_register"]);
			$this->hosts[$host["host_id"]]->set_host_created_date($host["host_created_date"]);
			$this->hosts[$host["host_id"]]->set_activate($host["host_activate"]);
			//
			$this->loadHostParent($this->hosts[$host["host_id"]]);
			$this->loadHostContactGroupRelation($this->hosts[$host["host_id"]]);
			unset($host);
		}
	}

	function saveHost($host)	{
		$this->set_flag_user(session_id(), '0');
		$this->set_flag_user(session_id(), '5');
		if ($host->get_id() == -1) // Insert new Host in database
			$this->database->saveHost($host);
		else	{ // Update Host in database
			$this->database->saveHost($this->hosts[$host->get_id()]);
			$this->database->saveHostParentRelation($this->hosts[$host->get_id()]);
			$this->database->saveHostGroupHostRelation(-1, $host);
			$this->database->saveHostContactGroupRelation($host);
			$this->updateHostInHostGroups($host);
		}
	}

	function deleteHost($host)	{ // Delete Host in database
		$this->set_flag_user(session_id(), '0');
		$this->set_flag_user(session_id(), '5');
		$this->deleteLCAHosts(0, $host->get_id());
		$this->database->deleteHost($host);
		$this->database->deleteHostGroupHostRelation($host, -1);
		$this->database->deleteHostParentRelation($host); // Delete relation between parent(s) and host
		$this->database->deleteHostContactGroupRelation($host);
		$this->database->deleteHostGroupHostRelation(-1, $host);
		if (!$host->get_register())
			foreach($this->hosts as $host_temp)	{
				if ($host_temp->get_host_template() == $host->get_id() && $host_temp->get_register())
					$this->deleteHost($host_temp);
				unset($host_temp);
			}
		if (isset($this->profileHosts) && isset($this->profileHosts[$host->get_id()]))
			$this->deleteProfileHost($this->profileHosts[$host->get_id()]);
		if (isset($this->trafficMaps))
			foreach ($this->trafficMaps as $trafficMap)	{
				if (isset($trafficMap->TMHosts))
					foreach ($trafficMap->TMHosts as $TMHost)
						if ($TMHost->get_host() == $host->get_id())
							$this->DeleteTrafficMapHost($TMHost);
				unset($trafficMap);
			}
		if (isset($this->hostGroups)) // Delete host group if there's only one host associated with it
			foreach ($this->hostGroups as $hostGroup)	{
				if (isset($hostGroup->hosts))
					if (array_key_exists($host->get_id(), $hostGroup->hosts))	{
						if (count($hostGroup->hosts) == 1)
							$this->deleteHostGroup($hostGroup);
						else // Just unset in host group the host we delete
							unset($this->hostGroups[$hostGroup->get_id()]->hosts[$host->get_id()]);
					}
				unset($hostGroup);
			}
		if (isset($this->hes)) // Delete host escalation associated with host
			foreach ($this->hes as $he)	{
				if ($host->get_id() == $he->get_host())
					$this->deleteHostEscalation($he);
				unset($he);
			}
		if (isset($this->esis)) // Delete Extended service information associated with host
			foreach ($this->esis as $esi)	{
				if (!$host->get_id() == $esi->get_host())	{
					$this->deleteExtendedServiceInformation($esi);
					unset($this->esis[$esi->get_id()]);
				}
				unset($esi);
			}
		if (isset($this->hosts)) // Unset Host in Host Parent array in other host
			foreach ($this->hosts as $host_temp)	{
				if (isset($host_temp->parents))
					if (array_key_exists($host->get_id(), $host_temp->parents))
						unset($this->hosts[$host_temp->get_id()]->parents[$host->get_id()]);
				unset($host_temp);
			}
		if (isset($this->services)) // Delete service associated with host
			foreach ($this->services as $service)	{
				if ($host->get_id() == $service->get_host())
					$this->deleteService($service);
				unset($service);
			}
		if (isset($this->ehis)) // Delete extended host information associated with host
			foreach ($this->ehis as $ehi)	{
				if ($host->get_id() == $ehi->get_host())
					$this->deleteExtendedHostInformation($ehi);
				unset($ehi);
			}
		if (isset($this->ses)) // Delete Service escalation associated with host
			foreach ($this->ses as $se)	{
				if ($host->get_id() == $se->get_host())
					$this->deleteServiceEscalation($se);
				unset($se);
			}
		if (isset($this->hds)) // Delete Host Dependency associated with host
			foreach ($this->hds as $hd)	{
				if ($host->get_id() == $hd->get_host())
					$this->deleteHostDependency($hd);
				if ($host->get_id() == $hd->get_host_dependent())
					$this->deleteHostDependency($hd);
				unset($hd);
			}
		if (isset($this->sds)) // Delete Service Dependency associated with host
			foreach ($this->sds as $sd)	{
				if ($host->get_id() == $sd->get_host())
					$this->deleteServiceDependency($sd);
				if ($host->get_id() == $sd->get_host_dependent())
					$this->deleteServiceDependency($sd);
				unset($sd);
			}
		unset ($this->hosts[$host->get_id()]); // unset object host in oreon
		unset ($this->htms[$host->get_id()]);
		unset($host);
		reset($this->hosts);
	}

	// Update Host In Host Groups (V2 style...)

	function updateHostInHostGroups($host = -1, $hostGroup = -1)	{
		if (isset($host) && $host != -1)	{
			if (isset($host->hostGroups))	{
				foreach ($this->hostGroups as $hostGroup)	{
					if (array_key_exists($hostGroup->get_id(), $host->hostGroups))
						$this->hostGroups[$hostGroup->get_id()]->hosts[$host->get_id()] = & $this->hosts[$host->get_id()];
					else	{
						unset ($this->hostGroups[$hostGroup->get_id()]->hosts[$host->get_id()]);
						if (!count($this->hostGroups[$hostGroup->get_id()]->hosts))
							$this->deleteHostGroup($hostGroup);
					}
					unset($hostGroup);
				}
			}	else	{
				foreach ($this->hostGroups as $hostGroup)	{
					if (array_key_exists($host->get_id(), $hostGroup->hosts))	{
						unset ($this->hostGroups[$hostGroup->get_id()]->hosts[$host->get_id()]);
						if (!count($this->hostGroups[$hostGroup->get_id()]->hosts))
							$this->deleteHostGroup($hostGroup);
					}
					unset($hostGroup);
				}
			}
		}	else if ($hostGroup != -1)	{
				foreach ($this->hosts as $host)	{
					if (array_key_exists($host->get_id(), $hostGroup->hosts))
						$this->hosts[$host->get_id()]->hostGroups[$hostGroup->get_id()] = & $this->hostGroups[$hostGroup->get_id()];
					else
						unset ($this->hosts[$host->get_id()]->hostGroups[$hostGroup->get_id()]);
					unset($host);
				}
			}
	}

	// Host Services Relation

	function loadHostServiceRelation($host = -1, $service = -1) {	// set an array of "service object" for current object host
		if (isset($host) && $host != -1)	{
			$services = $this->database->getHostServiceRelation($host);
			foreach ($services as $service)	{
				$this->hosts[$host->get_id()]->services[$service["service_service_id"]] = & $this->services[$service["service_service_id"]];
				unset($service);
			}
		}	else	{
			$host = $this->database->getHostServiceRelation(-1, $service);
			if (isset($host))
				$this->services[$service->get_id()]->set_host($host["host_host_id"]);
		}
	}

	// Host Contact Group Relation (V2)

	function loadHostContactGroupRelation($host = -1)	{
		if (isset($host) && $host != -1)	{
			$contactGroups = $this->database->getHostContactGroupRelation($host);
			if (isset($contactGroups))
				foreach ($contactGroups as $contactGroup)	{
					$this->hosts[$host->get_id()]->contactgroups[$contactGroup["contactgroup_cg_id"]] = & $this->contactGroups[$contactGroup["contactgroup_cg_id"]];
					unset($contactGroup);
				}
		}
	}

	//Extended host information

	function loadExtendedHostInformation($ehi = -1)	{ // set an array of "Extended host information object" for current object oreon
		$this->ehis = array();
		$ehis = $this->database->getExtendedHostInformation($ehi);
		foreach ($ehis as $ehi)	{
			$this->ehis[$ehi["ehi_id"]] = new ExtendedHostInformation($ehi);
			$this->ehis[$ehi["ehi_id"]]->set_notes($ehi["ehi_notes"]);
			$this->ehis[$ehi["ehi_id"]]->set_notes_url($ehi["ehi_notes_url"]);
			$this->ehis[$ehi["ehi_id"]]->set_action_url($ehi["ehi_action_url"]);
			$this->ehis[$ehi["ehi_id"]]->set_icon_image($ehi["ehi_icon_image"]);
			$this->ehis[$ehi["ehi_id"]]->set_icon_image_alt($ehi["ehi_icon_image_alt"]);
			$this->ehis[$ehi["ehi_id"]]->set_vrml_image($ehi["ehi_vrml_image"]);
			$this->ehis[$ehi["ehi_id"]]->set_statusmap_image($ehi["ehi_statusmap_image"]);
			$this->ehis[$ehi["ehi_id"]]->set_d2_coords($ehi["ehi_2d_coords"]);
			$this->ehis[$ehi["ehi_id"]]->set_d3_coords($ehi["ehi_3d_coords"]);
			unset($ehi);
		}
	}

	function saveExtendedHostInformation($ehi)	{
		$this->set_flag_user(session_id(), '6');
		if ($ehi->get_id() == -1) // Insert new extended host information in database
			$this->database->saveExtendedHostInformation($ehi);
		else // Update extended host information in database
			$this->database->saveExtendedHostInformation($this->ehis[$ehi->get_id()]);
	}

	function deleteExtendedHostInformation($ehi)	{
		$this->set_flag_user(session_id(), '6');
		$this->database->deleteExtendedHostInformation($this->ehis[$ehi->get_id()]);
		unset ($this->ehis[$ehi->get_id()]);
	}

	// Host Template Model

	function loadHostTemplateModel() {	// set an array of "Host Template Model" for current object oreon
		$this->htms = array();
		if (isset($this->hosts))
			foreach ($this->hosts as $host)
				if (!$host->get_register())	{
					$htm["htm_id"] = $host->get_id();
					$this->htms[$htm["htm_id"]] = new HostTemplateModel($htm);
					unset($htm);
			}
	}

	// Host Escalation

	function loadHostEscalation() {	// set an array of "Host Escalation object" for current object oreon
		$this->hes = array();
		$hes = $this->database->getHostEscalation();
		foreach ($hes as $he)	{
			$this->hes[$he["he_id"]] = new HostEscalation($he);
			$this->hes[$he["he_id"]]->hostGroups = array();
			$this->hes[$he["he_id"]]->contactGroups = array();
			if ($he["timeperiod_tp_id"])
				$this->hes[$he["he_id"]]->set_escalation_period($he["timeperiod_tp_id"]);
			else
				$this->hes[$he["he_id"]]->set_escalation_period(NULL);
			$this->hes[$he["he_id"]]->set_escalation_options($he["he_escalation_options"]);
			$this->loadContactGroupHostEscalation($this->hes[$he["he_id"]]);
			$this->loadHostGroupHostEscalation($this->hes[$he["he_id"]]);
			unset($he);
		}
	}

	function saveHostEscalation($he)	{
		$this->set_flag_user(session_id(), '3');
		if ($he->get_id() == -1) // Insert new host escalation in database
			$this->database->saveHostEscalation($he);
		else	{ // Update host escalation in database
			$this->database->saveHostEscalation($this->hes[$he->get_id()]);
			$this->database->saveContactGroupHostEscalation($this->hes[$he->get_id()]);
			$this->database->saveHostGroupHostEscalation($this->hes[$he->get_id()]);
		}
	}

	function deleteHostEscalation($he)	{
		$this->set_flag_user(session_id(), '3');
		$this->database->deleteHostEscalation($this->hes[$he->get_id()]);
		$this->database->deleteContactGroupHostEscalation($this->hes[$he->get_id()], NULL);
		unset ($this->hes[$he->get_id()]);
	}

	// Host Escalation Host Group Relation

	function loadHostGroupHostEscalation($he)	{
		$hgs = $this->database->getHostGroupHostEscalation($he);
		foreach ($hgs as $hg)	{
			$this->hes[$he->get_id()]->hostGroups[$hg["hostgroup_hg_id"]] = & $this->hostGroups[$hg["hostgroup_hg_id"]];
			unset($hg);
		}
	}

	// Host Escalation Contact Group Relation

	function loadContactGroupHostEscalation($he)	{
		$cgs = $this->database->getContactGroupHostEscalation($he);
		foreach ($cgs as $cg)	{
			$this->hes[$he->get_id()]->contactGroups[$cg["contactgroup_cg_id"]] = & $this->contactGroups[$cg["contactgroup_cg_id"]];
			unset($cg);
		}
	}

	// Host Dependency

	function loadHostDependency() {	// set an array of "Host Dependency object" for current object oreon
		$this->hds = array();
		$hds = $this->database->getHostDependency();
		foreach ($hds as $hd)	{
			$this->hds[$hd["hd_id"]] = new HostDependency($hd);
			$this->hds[$hd["hd_id"]]->set_inherits_parent($hd["hd_inherits_parent"]);
			$this->hds[$hd["hd_id"]]->set_execution_failure_criteria($hd["hd_execution_failure_criteria"]);
			$this->hds[$hd["hd_id"]]->set_notification_failure_criteria($hd["hd_notification_failure_criteria"]);
			unset($hd);
		}
	}

	function saveHostDependency($hd)	{
		$this->set_flag_user(session_id(), '4');
		if ($hd->get_id() == -1) // Insert new host dependency in database
			$this->database->saveHostDependency($hd);
		else // Update host escalation in database
			$this->database->saveHostDependency($this->hds[$hd->get_id()]);
	}

	function deleteHostDependency($hd)		{
		$this->set_flag_user(session_id(), '4');
		$this->database->deleteHostDependency($this->hds[$hd->get_id()]);
		unset ($this->hds[$hd->get_id()]);
	}

	// Host Group

	function loadHostGroup($hg_id = -1) {	// set an array of "Host Group object" for current object oreon
		$this->hostGroups = array();
		$hostGroups = $this->database->getHostGroup($hg_id);
		foreach ($hostGroups as $hostGroup)	{
			$this->hostGroups[$hostGroup["hg_id"]] = new HostGroup($hostGroup);
			$this->hostGroups[$hostGroup["hg_id"]]->set_comment($hostGroup["hg_comment"]);
			$this->hostGroups[$hostGroup["hg_id"]]->set_activate($hostGroup["hg_activate"]);
			$this->hostGroups[$hostGroup["hg_id"]]->contact_groups = array();
			$this->hostGroups[$hostGroup["hg_id"]]->hosts = array();
			$this->loadHostGroupHost($this->hostGroups[$hostGroup["hg_id"]], -1);
			$this->loadHostGroupCG($this->hostGroups[$hostGroup["hg_id"]]);
			unset($hostGroup);
		}
		if (isset($this->hosts))
			foreach ($this->hosts as $host)	{
				$this->loadHostGroupHost(-1, $host);
				unset($host);
			}
	}

	function saveHostGroup($hostGroup)	{
		$this->set_flag_user(session_id(), '1');
		if ($hostGroup->get_id() == -1) // Insert new host Group in database
			$this->database->saveHostGroup($hostGroup);
		else	{ // Update Host Group in database
			$this->database->saveHostGroup($this->hostGroups[$hostGroup->get_id()]);
			$this->database->saveHostGroupHostRelation($hostGroup);
			$this->database->saveHostGroupCGRelation($hostGroup);
			$this->updateHostInHostGroups(-1, $hostGroup);
		}
	}

	function deleteHostGroup($hostGroup)	{ // Delete Host Group in database
		$this->set_flag_user(session_id(), '1');
		$this->database->deleteHostGroup($this->hostGroups[$hostGroup->get_id()]);
		$this->database->deleteHostGroupHostRelation(-1, $this->hostGroups[$hostGroup->get_id()]); //Delete HostGroup Host Relation in database
		$this->database->deleteHostGroupCGRelation($this->hostGroups[$hostGroup->get_id()]);
		if (isset($this->hes))
			foreach ($this->hes as $he)	{
				if (isset($he->hostGroups))
					if (array_key_exists($hostGroup->get_id(), $he->hostGroups))	{
						$this->database->deleteHostGroupHostEscalation($this->hes[$he->get_id()], $hostGroup);
						unset($this->hes[$he->get_id()]->hostGroups[$hostGroup->get_id()]);
					}
				unset($he);
			}
		if (isset($this->hosts))
			foreach ($this->hosts as $host)	{
				if (isset($host->hostGroups))
					if (array_key_exists($hostGroup->get_id(), $host->hostGroups))
						unset($this->hosts[$host->get_id()]->hostGroups[$hostGroup->get_id()]);
				unset($host);
			}
		if (isset($this->hges))
			foreach ($this->hges as $hge)	{
				if ($hge->get_hostgroup() == $hostGroup->get_id())
					$this->deleteHostGroupEscalation($hge);
				unset($hge);
			}
		unset ($this->hostGroups[$hostGroup->get_id()]);
	}

	// Emul hosts from host group for monitoring

	function emulHostGroupHosts(& $hg)		{
		$this->set_flag_user(session_id(), '1');
		if (isset($hg) && !isset($hg->hostsEmul))	{
			$hg->hostsEmul = array();
			foreach ($hg->hosts as $HGhost)	{
				if ($HGhost->get_register())
					$hg->hostsEmul[$HGhost->get_id()] = & $this->hosts[$HGhost->get_id()];
				else	{
					foreach($this->hosts as $host)	{
						if ($host->get_host_template() == $HGhost->get_id())
							$hg->hostsEmul[$host->get_id()] = & $this->hosts[$host->get_id()];
						unset($host);
					}
				}
				unset($HGhost);
			}
		}
	}

	// Host Group Contact Groups Relation

	function loadHostGroupCG($hostgroup = -1) 	{
		$contact_groups = $this->database->getHostGroupCGRelation($hostgroup);
		foreach ($contact_groups as $cg)	{
			$this->hostGroups[$hostgroup->get_id()]->contact_groups[$cg["contactgroup_cg_id"]] = & $this->contactGroups[$cg["contactgroup_cg_id"]];
			unset($cg);
		}
	}

	// Host Group Host Relation

	function loadHostGroupHost($hostgroup = -1, $host = -1) {	// set an array of "Host object" for current object HostGroups
		if (isset($hostgroup) && $hostgroup != -1)	{
			$hosts = $this->database->getHostGroupHost($hostgroup, -1);
			foreach ($hosts as $host)	{
				$this->hostGroups[$hostgroup->get_id()]->hosts[$host["host_host_id"]] = & $this->hosts[$host["host_host_id"]];
				unset($host);
			}
		}	else	{
			$hostGroups = $this->database->getHostGroupHost(-1, $host);
			foreach ($hostGroups as $hostGroup)	{
				$this->hosts[$host->get_id()]->hostGroups[$hostGroup["hostgroup_hg_id"]] = & $this->hostGroups[$hostGroup["hostgroup_hg_id"]];
				unset($hostGroup);
			}
		}
	}

	// Host Parents

	function loadHostParent($host = -1) {	// set an array of "host object" for current object hosts
		$this->hosts[$host->get_id()]->parents = array();
		$parents = $this->database->getHostParentRelation($host);
		foreach ($parents as $parent)	{
			$this->hosts[$host->get_id()]->parents[$parent["host_parent_hp_id"]] = & $this->hosts[$parent["host_parent_hp_id"]];
			unset($parent);
		}
	}

	// Host Group Escalation

	function loadHostGroupEscalation()	{ // set an array of "HostGroup Escalation object" for current object oreon
		$this->hges = array();
		$hges = $this->database->getHostGroupEscalation();
		foreach ($hges as $hge)	{
			$this->hges[$hge["hge_id"]] = new HostGroupEscalation($hge);
			$this->hges[$hge["hge_id"]]->contactGroups = array();
			$this->loadContactGroupHostGroupEscalation($this->hges[$hge["hge_id"]]);
			unset($hge);
		}
	}

	function saveHostGroupEscalation($hge)	{
		$this->set_flag_user(session_id(), '2');
		if ($hge->get_id() == -1)	{ // Insert new host escalation in database
			$this->database->saveHostGroupEscalation($hge);
		}
		else	{ // Update hostgroup escalation in database
			$this->database->saveHostGroupEscalation($this->hges[$hge->get_id()]);
			$this->database->saveContactGroupHostGroupEscalation($hge);
		}
	}

	function deleteHostGroupEscalation($hge)	{
		$this->set_flag_user(session_id(), '2');
		$this->database->deleteHostGroupEscalation($this->hges[$hge->get_id()]);
		$this->database->deleteContactGroupHostGroupEscalation($this->hges[$hge->get_id()], NULL);
		unset ($this->hges[$hge->get_id()]);
	}

	// Host Group Escalation Contact Group Relation

	function loadContactGroupHostGroupEscalation($hge)	{
		$cgs = $this->database->getContactGroupHostGroupEscalation($hge);
		foreach ($cgs as $cg)	{
			$this->hges[$hge->get_id()]->contactGroups[$cg["contactgroup_cg_id"]] = & $this->contactGroups[$cg["contactgroup_cg_id"]];
			unset($cg);
		}
	}

	// Command

	function loadCommand($command = -1) {	// set an array of "Command object" for current object oreon
		$this->commands = array();
		$commands = $this->database->getCommand($command);
		foreach ($commands as $command)	{
			$this->commands[$command["command_id"]] = new Command($command);
			unset($command);
		}
	}

	function saveCommand($command)	{
		$this->set_flag_user(session_id(), '16');
		if ($command->get_id() == -1) // Insert new Command in database
			$this->database->saveCommand($command);
		else // Update Command in database
			$this->database->saveCommand($this->commands[$command->get_id()]);
	}

	function deleteCommand($command)	{
		$this->set_flag_user(session_id(), '16');
		$this->database->deleteCommand($command);
		$this->database->deleteHostNotificationCommandRelation(-1, $command);
		$this->database->deleteServiceNotificationCommandRelation(-1, $command);
		if (isset($this->hosts))	{ // unset command used associated with host
			foreach ($this->hosts as $host)	{
				if (isset($host->check_command))
					if ($command->get_id() == $host->get_check_command())	{
						$this->hosts[$host->get_id()]->set_check_command(NULL);
						$this->saveHost($this->hosts[$host->get_id()]);
					}
				unset($host);
			}
			foreach ($this->hosts as $host)	{
				if (isset($host->event_handler))
					if ($command->get_id() == $host->get_event_handler())	{
						$this->hosts[$host->get_id()]->set_event_handler(NULL);
						$this->saveHost($this->hosts[$host->get_id()]);
					}
				unset($host);
			}
		}
		if (isset($this->contacts))	{ // unset command associated with contact
			foreach ($this->contacts as $contact)	{
				if (isset($contact->host_notification_commands))
					if (array_key_exists($command->get_id(), $contact->host_notification_commands))	{
						if (count($contact->host_notification_commands) == 1)
							$this->deleteContact($contact);
						else
							unset($this->contacts[$contact->get_id()]->host_notification_commands[$command->get_id()]);
					}
				unset($contact);
			}
			foreach ($this->contacts as $contact)	{
				if (isset($contact->service_notification_commands))
					if (array_key_exists($command->get_id(), $contact->service_notification_commands))	{
						if (count($contact->service_notification_commands) == 1)
							$this->deleteContact($contact);
						else
							unset($this->contacts[$contact->get_id()]->service_notification_commands[$command->get_id()]);
					}
				unset($contact);
			}
		}
		if (isset($this->services))	{ // Delete and unset service associated with command
			foreach ($this->services as $service)	{
				if ($command->get_id() == $service->get_check_command())
					$this->deleteService($service);
				unset($service);
			}
			foreach ($this->services as $service)	{
				if ($command->get_id() == $service->get_event_handler())	{
					$this->services[$service->get_id()]->set_event_handler(NULL);
					$this->services[$service->get_id()]->set_event_handler_arg(NULL);
					$this->saveService($this->services[$service->get_id()]);
				}
				unset($service);
			}
		}
		unset($this->commands[$command->get_id()]);
	}

	// Contact

	function loadContact($contact = -1) {	// set an array of "Contact object" for current object oreon
		$this->contacts = array();
		$cct = $this->database->getContact($contact);
		foreach ($cct as $contact)	{
			$this->contacts[$contact["contact_id"]] = new Contact($contact);
			$this->contacts[$contact["contact_id"]]->set_host_notification_period($contact["timeperiod_tp_id"]);
			$this->contacts[$contact["contact_id"]]->set_service_notification_period($contact["timeperiod_tp_id2"]);
			$this->loadHostNotificationCommands($this->contacts[$contact["contact_id"]]);
			$this->loadServiceNotificationCommands($this->contacts[$contact["contact_id"]]);
			$this->contacts[$contact["contact_id"]]->set_pager($contact["contact_pager"]);
			$this->contacts[$contact["contact_id"]]->set_comment($contact["contact_comment"]);
			$this->contacts[$contact["contact_id"]]->set_activate($contact["contact_activate"]);
			unset($contact);
		}
	}

	function saveContact($contact)	{
		$this->set_flag_user(session_id(), '13');
		if ($contact->get_id() == -1) // Insert new Contact in database
			$this->database->saveContact($contact);
		else	{// Update Contact in database
			$this->database->saveContact($this->contacts[$contact->get_id()]);
			$this->database->saveServiceNotificationCommandRelation($this->contacts[$contact->get_id()]);
			$this->database->saveHostNotificationCommandRelation($this->contacts[$contact->get_id()]);
			if ($this->user->get_version() == "2")	{
				$this->database->saveContactGroupContactRelation(-1, $contact);
				$this->updateContactInContactGroups($contact);
			}
		}
	}

	function DeleteContact($contact)	{ // Delete object in database
		$this->set_flag_user(session_id(), '13');
		$this->database->deleteHostNotificationCommandRelation($contact);
		$this->database->deleteServiceNotificationCommandRelation($contact);
		$this->database->deleteContactGroupContactRelation($contact);
		$this->database->deleteContact($contact);
		if (isset($this->contactGroups)) // Unset contact in ContactGroups
			foreach ($this->contactGroups as $contactGroup)	{
				if (isset($contactGroup))
					if (array_key_exists($contact->get_id(), $contactGroup->contacts))	{
						if (!strcmp(count($contactGroup->contacts), "1"))
							$this->deleteContactGroup($contactGroup);
						else // Just unset in contact group the contact we delete
							unset ($this->contactGroups[$contactGroup->get_id()]->contacts[$contact->get_id()]);
					}
				unset($contactGroup);
			}
		unset($this->contacts[$contact->get_id()]);
	}

	function updateContactInContactGroups($contact)	{
		if (isset($contact->contact_groups))	{ // Update contact array in Contact Groups
			foreach ($contact->contact_groups as $cg)	{
				$this->contactGroups[$cg->get_id()]->contacts[$contact->get_id()] = & $this->contacts[$contact->get_id()];
				unset($cg);
			}
		if (isset($contact->contact_groups))
			foreach ($this->contactGroups as $cg)	{
				if (array_key_exists($contact->get_id(), $cg->contacts) && !array_key_exists($cg->get_id(), $contact->contact_groups))	{
					if (count($cg->contacts) == 1)
						$this->deleteContactGroup($cg); // Delete contact group if it don't have no more contact
					else
						unset($this->contactGroups[$cg->get_id()]->contacts[$contact->get_id()]);
				}
				unset($cg);
			}
		}
		else
			if (isset($this->contactGroups))
				foreach ($this->contactGroups as $cg)	{
					if (isset($cg->contacts))
						if (array_key_exists($contact->get_id(), $cg->contacts))	{
							if (count($cg->contacts) == 1)
								$this->deleteContactGroup($cg); // Delete contact group if it don't have no more contact
							else
								unset($this->contactGroups[$cg->get_id()]->contacts[$contact->get_id()]);
						}
					unset($cg);
				}
	}

	// Update Contact Group In Contact

	function updateContactGroupInContact($contactgroup)	{
		foreach ($this->contacts as $contact)	{ // Update contact group array in Contact
			if (isset($contact->contact_groups))
				if (array_key_exists($contactgroup->get_id(), $contact->contact_groups))
					unset ($this->contacts[$contact->get_id()]->contact_groups[$contactgroup->get_id()]);
			unset($contact);
		}
		foreach ($contactgroup->contacts as $contact)	{
			$this->contacts[$contact->get_id()]->contact_groups[$contactgroup->get_id()] = & $this->contactGroups[$contactgroup->get_id()];
			unset($contact);
		}
	}

	// Contact Group

	function loadContactGroup($cg = -1) {	// set an array of "Contact Group object" for current object oreon
		$this->contactGroups = array();
		$cgs = $this->database->getContactGroup($cg);
		foreach ($cgs as $cg)	{
			$cg["cg_contacts"] = NULL;
			$this->contactGroups[$cg["cg_id"]] = new ContactGroup($cg);
			$this->contactGroups[$cg["cg_id"]]->set_comment($cg["cg_comment"]);
			$this->contactGroups[$cg["cg_id"]]->set_activate($cg["cg_activate"]);
			$this->loadContactGroupContact($this->contactGroups[$cg["cg_id"]]);
			unset($cg);
		}
	}

	function saveContactGroup($contactgroup)	{
		$this->set_flag_user(session_id(), '14');
		if ($contactgroup->get_id() == -1) // Insert new Contact Group in database
			$this->database->saveContactGroup($contactgroup);
		else	{	// Update Contact Group in database
			$this->database->saveContactGroup($this->contactGroups[$contactgroup->get_id()]);
			$this->database->saveContactGroupContactRelation($contactgroup);
			$this->updateContactGroupInContact($contactgroup);
		}
	}

	function deleteContactGroup($contactgroup)	{ // Delete Contact Group in database
		$this->set_flag_user(session_id(), '14');
		$this->database->deleteContactGroup($this->contactGroups[$contactgroup->get_id()]);
		$this->database->deleteContactGroupContactRelation(-1, $this->contactGroups[$contactgroup->get_id()]); //Delete ContactGroup Contact Relation in database
		$this->database->deleteHostGroupCGRelation(-1, $contactgroup);
		$this->database->deleteCGServiceRelation(-1, $contactgroup);
		foreach ($this->contacts as $contact)	{  // Update contact group array in Contact
			if (isset($contact->contact_groups))
				if (array_key_exists($contactgroup->get_id(), $contact->contact_groups))
					unset ($this->contacts[$contact->get_id()]->contact_groups[$contactgroup->get_id()]);
			unset($contact);
		}
		if (isset($this->hes)) // Delete host escalation if there's only one contact group associated with it
			foreach ($this->hes as $he)	{
				if (isset($he->contactGroups))
					if (array_key_exists($contactgroup->get_id(), $he->contactGroups))	{
						if (count($he->contactGroups) == 1)
							$this->deleteHostEscalation($he);
						else	{ // Just unset in host escalation the contact group we delete
							$this->database->deleteContactGroupHostEscalation($this->hes[$he->get_id()], $contactgroup);
							unset($this->hes[$he->get_id()]->contactGroups[$contactgroup->get_id()]);
						}
					}
				unset($he);
			}
		if (isset($this->hges)) // Delete host group escalation if there's only one contact group associated with it
			foreach ($this->hges as $hge)	{
				if (isset($hge->contactGroups))
					if (array_key_exists($contactgroup->get_id(), $hge->contactGroups))	{
						if (count($hge->contactGroups) == 1)
							$this->deleteHostGroupEscalation($hge);
						else	{ // Just unset in host group escalation the contact group we delete
							$this->database->deleteContactGroupHostGroupEscalation($this->hges[$hge->get_id()], $contactgroup);
							unset($this->hges[$hge->get_id()]->contactGroups[$contactgroup->get_id()]);
						}
					}
				unset($hge);
			}
		if (isset($this->ses)) // Delete service escalation if there's only one contact group associated with it
			foreach ($this->ses as $se)	{
				if (isset($se->contactGroups))
					if (array_key_exists($contactgroup->get_id(), $se->contactGroups))	{
						if (count($se->contactGroups) == 1)
							$this->deleteServiceEscalation($se);
						else	{ // Just unset in service escalation the contact group we delete
							$this->database->deleteContactGroupServiceEscalation($this->ses[$se->get_id()], $contactgroup);
							unset($this->ses[$se->get_id()]->contactGroups[$contactgroup->get_id()]);
						}
					}
				unset($se);
			}
		if (isset($this->services)) // Delete service if there's only one contact group associated with it
			foreach ($this->services as $service)	{
				if (array_key_exists($contactgroup->get_id(), $service->contactGroups))	{
					if ((count($service->contactGroups) == 1))
						$this->deleteService($service);
					else // Just unset in service the contact group we delete
						unset($this->services[$service->get_id()]->contactGroups[$contactgroup->get_id()]);
				}
				unset($service);
			}
		if (isset($this->hostGroups)) // Unset contact group in host group
			foreach ($this->hostGroups as $hostGroup)	{
				if (isset($hostGroup->contact_groups))
					if (array_key_exists($contactgroup->get_id(), $hostGroup->contact_groups))	{
						if (count($hostGroup->contact_groups) == 1)
							$this->deleteHostGroup($hostGroup);
						else // Just unset in host group the contact group we delete
							unset($this->hostGroups[$hostGroup->get_id()]->contact_groups[$contactgroup->get_id()]);
					}
				unset($hostGroup);
			}
		if (isset($this->hosts)) // V2 Delete host if there's only one contact group associated with it
			foreach ($this->hosts as $host)	{
				if (isset($host->contactgroups))
					if (array_key_exists($contactgroup->get_id(), $host->contactgroups))	{
						if (count($host->contactgroups) == 1)
							$this->deleteHost($host);
						else	{ // Just unset in host the contact group we delete
							$this->database->deleteHostContactGroupRelation($host);
							unset($this->hosts[$host->get_id()]->contactgroups[$contactgroup->get_id()]);
						}
					}
				else	{
					$this->database->deleteHostContactGroupRelation($host);
					unset($this->hosts[$host->get_id()]->contactgroups[$contactgroup->get_id()]);
				}
				unset($host);
			}
		unset($this->contactGroups[$contactgroup->get_id()]);
	}

	// Contact Group Contact Relation

	function loadContactGroupContact($contactgroup = -1) {	// set an array of "Contact object" for current object ContactGroups
		$contacts = $this->database->getContactGroupContact($contactgroup);
		foreach ($contacts as $contact)	{
			$this->contactGroups[$contactgroup->get_id()]->contacts[$contact["contact_contact_id"]] = & $this->contacts[$contact["contact_contact_id"]];
			$this->contacts[$contact["contact_contact_id"]]->contact_groups[$contactgroup->get_id()] = & $this->contactGroups[$contactgroup->get_id()];
			unset($contact);
		}
	}

	// Timeperiod

	function loadTimePeriod($time_period = -1) {	// set an array of "Time Period object" for current object oreon
		$this->time_periods = array();
		$time_periods = $this->database->getTimePeriod($time_period);
		foreach ($time_periods as $time_period)	{
			$this->time_periods[$time_period["tp_id"]] = new TimePeriod($time_period);
			unset($time_period);
		}
	}

	function saveTimePeriod($time_period)	{
		$this->set_flag_user(session_id(), '15');
		if ($time_period->get_id() == -1) // Insert new Time Period in database
			$this->database->saveTimePeriod($time_period);
		else // Update Time Period in database
			$this->database->saveTimePeriod($this->time_periods[$time_period->get_id()]);
	}

	function deleteTimePeriod($tp)	{
		$this->set_flag_user(session_id(), '15');
		$this->database->deleteTimePeriod($tp);
		if (isset($this->hosts))	{ // Delete host associated with timeperiod
			foreach ($this->hosts as $host)	{
				if ($tp->get_id() == $host->get_notification_period())
					$this->deleteHost($host);
				unset($host);
			}
			foreach ($this->hosts as $host)	{	// V2
				if (isset($host->check_period))
					if ($tp->get_id() == $host->get_check_period())
						$this->deleteHost($host);
				unset($host);
			}
		}
		if (isset($this->services))	{ // Delete service associated with timeperiod
			foreach ($this->services as $service)	{
				if ($tp->get_id() == $service->get_check_period())
					$this->deleteService($service);
				unset($service);
			}
			foreach ($this->services as $service)	{
				if ($tp->get_id() == $service->get_notification_period())
					$this->deleteService($service);
				unset($service);
			}
		}
		if (isset($this->contacts))	{ // Delete contact associated with timeperiod
			foreach ($this->contacts as $contact)	{
				if ($tp->get_id() == $contact->get_host_notification_period())
					$this->deleteContact($contact);
				unset($contact);
			}
			foreach ($this->contacts as $contact)	{
				if ($tp->get_id() == $contact->get_service_notification_period())
					$this->deleteContact($contact);
				unset($contact);
			}
		}
		unset($this->time_periods[$tp->get_id()]);
	}

	// Traffic Map

	function loadTrafficMaps() {	// set an array of "trafficMap object" for current object oreon
		$this->trafficMaps = array();
		$tms = $this->database->getTrafficMap();
		foreach ($tms as $tm)	{
			$this->trafficMaps[$tm["tm_id"]] = new TrafficMap($tm);
			$this->loadTrafficMapHosts($this->trafficMaps[$tm["tm_id"]]);
			$this->loadTrafficMapHostsRelation($this->trafficMaps[$tm["tm_id"]]);
			unset($tm);
		}
	}

	function saveTrafficMap($tm)	{
		$this->set_flag_user(session_id(), '17');
		if ($tm->get_id() == -1)	{ // Insert new traffic map in database
			$this->database->saveTrafficMap($tm);
			$tm_id = $this->database->database->get_last_id();
			$this->trafficMaps[$tm_id] = $tm;
			$this->trafficMaps[$tm_id]->set_id($tm_id);
		}
		else	{	// Update traffic map in database
			$this->database->saveTrafficMap($this->trafficMaps[$tm->get_id()]);
			$this->trafficMaps[$tm->get_id()] = $tm;
		}
	}

	function deleteTrafficMap($tm) {	// Delete object in database
		$this->set_flag_user(session_id(), '17');
		$this->database->deleteTrafficMap($tm);
		if (isset($tm->TMrelations))
			foreach ($tm->TMrelations as $TMrelation)	{
				$this->deleteTrafficMapHostRelation($TMrelation);
				unset($TMrelation);
			}
		if (isset($tm->TMHosts))
			foreach ($tm->TMHosts as $TMHost)	{
				$this->deleteTrafficMapHost($TMHost);
				unset($TMHost);
			}

		if (file_exists("./include/trafficMap/conf/trafficMap.conf".$tm->get_id().".php"))	
			unlink("./include/trafficMap/conf/trafficMap.conf".$tm->get_id().".php");
		if (file_exists("./include/trafficMap/png/trafficMap".$tm->get_id().".png"))
		unlink("./include/trafficMap/png/trafficMap".$tm->get_id().".png");
		if (is_file("./include/trafficMap/bg/".$tm->get_id()."BG.png"))
			unlink("./include/trafficMap/bg/".$tm->get_id()."BG.png");
		unset($this->trafficMaps[$tm->get_id()]);
	}

	// Traffic Map Hosts

	function loadTrafficMapHosts($tm) {	// set an array of "trafficMap hosts" for object TrafficMap
		$TMHosts = $this->database->getTrafficMapHosts($tm);
		foreach ($TMHosts as $TMHost)	{
			$this->trafficMaps[$tm->get_id()]->TMHosts[$TMHost["tmh_id"]] = new TrafficMapHost($TMHost);
			unset($TMHost);
		}
	}

	function saveTrafficMapHost($tmh)	{
		$this->set_flag_user(session_id(), '17');
		if ($tmh->get_id() == -1)	{ // Insert new traffic map host in database
			$this->database->saveTrafficMapHost($tmh);
			$tmh_id = $this->database->database->get_last_id();
			$this->trafficMaps[$tmh->get_trafficMap()]->TMHosts[$tmh_id] = $tmh;
			$this->trafficMaps[$tmh->get_trafficMap()]->TMHosts[$tmh_id]->set_id($tmh_id);
		}
		else	{	// Update traffic map host in database
			$this->database->saveTrafficMapHost($tmh);
			$this->trafficMaps[$tmh->get_trafficMap()]->TMHosts[$tmh->get_id()] = $tmh;
		}
		if (isset($this->trafficMaps[$tmh->get_trafficMap()]->TMHosts))
			foreach ($this->trafficMaps[$tmh->get_trafficMap()]->TMHosts as $TMHost)	{
				if ($TMHost->get_host() == $tmh->get_host() && $TMHost->get_id() != $tmh->get_id())	{
					$this->trafficMaps[$tmh->get_trafficMap()]->TMHosts[$TMHost->get_id()]->set_x($tmh->get_x());
					$this->trafficMaps[$tmh->get_trafficMap()]->TMHosts[$TMHost->get_id()]->set_y($tmh->get_y());
					$this->database->saveTrafficMapHost($TMHost);
				}
				unset($TMHost);
			}
	}

	function deleteTrafficMapHost($tmh) {	// Delete object in database
		$this->set_flag_user(session_id(), '17');
		$this->database->deleteTrafficMapHost($tmh);
		if (isset($this->trafficMaps[$tmh->get_trafficMap()]->TMrelations))
			foreach ($this->trafficMaps[$tmh->get_trafficMap()]->TMrelations as $relation)	{
				if ($relation->TMHost1 == $tmh->get_id() || $relation->TMHost2 == $tmh->get_id())
					$this->deleteTrafficMapHostRelation($relation);
				unset($relation);
			}
		unset($this->trafficMaps[$tmh->get_trafficMap()]->TMHosts[$tmh->get_id()]);
	}

	// Traffic Map Hosts Relation

	function loadTrafficMapHostsRelation($tm) {	// set an array of host link for object TrafficMap
		$TMHostsRelations = $this->database->getTrafficMapHostsRelation($tm);
		if (isset($TMHostsRelations))
			foreach ($TMHostsRelations as $TMHostsRelation)	{
				$this->trafficMaps[$tm->get_id()]->TMrelations[$TMHostsRelation["tmhr_id"]] = new trafficMapRelation($TMHostsRelation);
				unset($TMHostsRelation);
			}
	}

	function saveTrafficMapHostRelation($tmr)	{
		$this->set_flag_user(session_id(), '17');
		if (isset($tmr)) // Insert new traffic map host relation in database
			$this->database->saveTrafficMapHostRelation($tmr);
	}

	function deleteTrafficMapHostRelation($tmr = -1) {	// Delete object in database
		$this->set_flag_user(session_id(), '17');
		if ($tmr != -1)	{
			$this->database->deleteTrafficMapHostRelation($tmr);
			unset($this->trafficMaps[$tmr->get_trafficMap()]->TMrelations[$tmr->get_id()]);
		}
	}

	// Graphs

	function loadGraph($graph = -1) {	// set an array of "Graph object" for current object oreon
		$this->graphs = array();
		$graphs = $this->database->getGraph($graph);
		foreach ($graphs as $graph)	{
			$this->graphs[$graph["graph_id"]] = new GraphRRD($graph);
			unset($graph);
		}
	}

	function saveGraph($graph)	{
		$this->set_flag_user(session_id(), '20');
		if (!isset($this->graphs[$graph->get_id()])) // Insert new Graph in database
			$this->database->saveGraph($graph, 0);
		else
			$this->database->saveGraph($this->graphs[$graph->get_id()], 1);
	}

	function deleteGraph($gr)	{
		$this->set_flag_user(session_id(), '20');
		$this->database->deleteGraph($gr);
		if (is_file("./rrd/".$gr->get_id().".rrd"))
			unlink("./rrd/".$gr->get_id().".rrd");
		if (is_file("./include/trafficMap/average/".$this->hosts[$this->services[$gr->get_id()]->get_host()]->get_address()."_".$gr->get_id().".html"))
			unlink("./include/trafficMap/average/".$this->hosts[$this->services[$gr->get_id()]->get_host()]->get_address()."_".$gr->get_id().".html");
		unset($this->graphs[$gr->get_id()]);
	}

	// Graph Models

	function loadGraphModels() { // set an array of "Graph object" for current object oreon
		$this->graphModels = array();
		$this->graphModelDS = array();
		$graphModels = $this->database->getGraphModels();
		foreach ($graphModels as $graphModel)	{
			$this->graphModels[$graphModel["gmod_id"]] = new GraphModel($graphModel);
			unset($graphModel);
		}
		$graphModelDS = $this->database->getGraphModelDS();
		foreach ($graphModelDS as $graphModelDS_)	{
			$this->graphModelDS[$graphModelDS_["gmod_ds_id"]] = new GraphModelDS($graphModelDS_);
			unset($graphModelDS_);
		}
	}

	function saveGraphModel($graphModel)	{
		$this->set_flag_user(session_id(), '18');
		$this->set_flag_user(session_id(), '19');
		if ($graphModel->get_id() == -1) // Insert new GraphModel in database
			$this->database->saveGraphModel($graphModel);
		else
			$this->database->saveGraphModel($this->graphModels[$graphModel->get_id()]);
	}

	function saveGraphModelDS($graphModelDS)	{
		$this->set_flag_user(session_id(), '18');
		if ($graphModelDS->get_id() == -1)
			$this->database->saveGraphModelDS($graphModelDS);
		else
			$this->database->saveGraphModelDS($this->graphModelDS[$graphModelDS->get_id()]);
	}

	function deleteGraphModel($graphModel)	{
		$this->set_flag_user(session_id(), '18');
		$this->set_flag_user(session_id(), '19');
		$this->database->deleteGraphModel($graphModel);
		unset($this->graphModels[$graphModel->get_id()]);
	}

	function deleteGraphModelDS($graphModelDS)	{
		$this->set_flag_user(session_id(), '18');
		$this->database->deleteGraphModelDS($graphModelDS);
		unset($this->graphModelDS[$graphModelDS->get_id()]);
	}

	// Colors

	function loadColors() {	// set an array of "Graph object" for current object oreon
		$this->colors_list = array();
		$colors = $this->database->getColors();
		foreach ($colors as $color)	{
			$this->colors_list[$color["color_id"]] =  new Colors($color);
			unset($color);
		}
	}

	function deleteColor($color)	{
		$this->set_flag_user(session_id(), '18');
		$this->database->deleteColor($color);
		//unset($this->graphModelDS[$graphModelDS->get_id()]);
	}

	function saveColor($color)	{
		$this->set_flag_user(session_id(), '18');
		$this->database->saveColor($color);
	}

	// Service notification commands

	function loadServiceNotificationCommands($contact) {	// set an array of "Service notification commands object" for current object oreon
		$service_notification_commands = $this->database->getServiceNotificationCommands($contact);
		foreach ($service_notification_commands as $service_notification_command)	{
			$this->contacts[$contact->get_id()]->service_notification_commands[$service_notification_command["command_command_id"]] = & $this->commands[$service_notification_command["command_command_id"]];
			unset($service_notification_command);
		}
	}

	// Host notification commands

	function loadHostNotificationCommands($contact) {	// set an array of "Host notification commands object" for current object oreon
		$host_notification_commands = $this->database->getHostNotificationCommands($contact);
		foreach ($host_notification_commands as $host_notification_command)	{
			$this->contacts[$contact->get_id()]->host_notification_commands[$host_notification_command["command_command_id"]] = & $this->commands[$host_notification_command["command_command_id"]];
			unset($host_notification_command);
		}
	}

	// Host profile commands

   function loadProfileHosts() {	// set an array of "Profile host"" for current object oreon
		$this->profileHosts = array();
		$profiles = $this->database->getProfileHosts();
		if (isset($profiles))
			foreach ($profiles as $profile)	{
				$this->profileHosts[$profile["host_host_id"]] = new ProfileHost($profile["host_host_id"]);
				$this->profileHosts[$profile["host_host_id"]]->set_location($profile["phost_location"]);
				$this->profileHosts[$profile["host_host_id"]]->set_contact($profile["phost_contact"]);
				$this->profileHosts[$profile["host_host_id"]]->set_os($profile["phost_os"]);
				$this->profileHosts[$profile["host_host_id"]]->set_uptime($profile["phost_uptime"]);
				$this->profileHosts[$profile["host_host_id"]]->set_ram($profile["phost_ram"]);
				$this->profileHosts[$profile["host_host_id"]]->set_update($profile["phost_update"]);
				$this->loadProfileHostDisk($profile["host_host_id"]);
				$this->loadProfileHostNetInterface($profile["host_host_id"]);
				$this->loadProfileHostSoftware($profile["host_host_id"], $profile["phost_softwares"]);
				$this->loadProfileHostSoftwareUP($profile["host_host_id"], $profile["phost_softwares"]);
				unset($profile);
			}
	}

	function loadProfileHostNetInterface($host_id) {	// set an array of "Profile host netinterface object" for current object ProfileHost
		$netInterfaces = $this->database->getProfileHostNetInterface($host_id);
		foreach ($netInterfaces as $netInterface)	{
			$this->profileHosts[$host_id]->netInterfaces[$netInterface["pi_id"]] = new NetInterface($netInterface);
			unset($netInterface);
		}
	}

	function loadProfileHostDisk($host_id) {	// set an array of "Profile host disk object" for current object ProfileHost
		$disks = $this->database->getProfileHostDisk($host_id);
		foreach ($disks as $disk)	{
			$this->profileHosts[$host_id]->disks[$disk["pdisk_id"]] = new Disk($disk);
			unset($disk);
		}
	}

	function loadProfileHostSoftware($host_id, $softwares)	{
		$tab = array();
		$tab = explode("|", $softwares);
		sort($tab);
		for ($i = 0; $i < count($tab); $i++)
			if ($tab[$i])
				$this->profileHosts[$host_id]->softwares[$tab[$i]] = stripslashes($tab[$i]);
		unset($tab);
	}

	function loadProfileHostSoftwareUP($host_id, $softwaresUP)	{
		$tab = array();
		$tab = explode("|", $softwaresUP);
		sort($tab);
		for ($i = 0; $i < count($tab); $i++)
			if ($tab[$i])
				$this->profileHosts[$host_id]->softwaresUP[$tab[$i]] = stripslashes($tab[$i]);
		unset($tab);
	}

	function saveProfileHost($ph = NULL)	{
		if ($ph)	{
			$this->profileHosts[$ph->get_host()] = $ph;
			$this->saveProfileHostNetInterface($ph);
			$this->saveProfileHostDisk($ph);
			$this->database->saveProfileHost($this->profileHosts[$ph->get_host()]);
		}
	}

	function saveProfileHostNetInterface($ph = NULL)	{
		if ($ph)	{
			$this->profileHosts[$ph->get_host()]->netInterfaces = $ph->netInterfaces;
			$this->database->saveProfileHostNetInterface($this->profileHosts[$ph->get_host()]);
		}
	}

	function saveProfileHostDisk($ph = NULL)	{
		if ($ph)	{
			$this->profileHosts[$ph->get_host()]->disks = $ph->disks;
			$this->database->saveProfileHostDisk($this->profileHosts[$ph->get_host()]);
		}
	}

	function deleteProfileHost($ph = NULL)	{
		if ($ph)	{
			$this->deleteProfileHostNetInterface($ph);
			$this->deleteProfileHostDisk($ph);
			$this->database->deleteProfileHost($ph);
			unset($this->profileHosts[$ph->get_host()]);
		}
	}

	function deleteProfileHostNetInterface($ph = NULL)	{
		if ($ph)
			$this->database->deleteProfileHostNetInterface($ph);
	}

	function deleteProfileHostDisk($ph = NULL)	{
		if ($ph)
			$this->database->deleteProfileHostDisk($ph);
	}

	/* Session */

	function add_new_session($session_id, $user_id)
	{
		$this->database->add_new_session($session_id, $user_id);
	}

	function clean_session($expire)
	{
		$this->database->clean_session($expire);
	}

	function update_current_session($session_id, $page_id, $action)
	{
		$this->database->update_current_session($session_id, $page_id, $action);
	}

	function load_current_data_to_reload($session_id)
	{
		return $this->database->load_current_data_to_reload($session_id);
	}

	function load_user_status()
	{
		$ret_status_user = $this->database->load_user_status();
		foreach ($ret_status_user as $rsu)	{
			$this->user_online[$rsu["session_id"]] = new User_status($rsu);
			unset($rsu);
		}
	}

	function set_flag_user($session_id, $flag_id)
	{
		$this->database->set_flag_user($session_id, $flag_id);
	}

	function clean_table_from_current_user()
	{
		$this->database->clean_table_from_current_user();
	}

	function check_if_session_ok()
	{
		return $this->database->check_if_session_ok(session_id());
	}

	function loadRedirectTo()
	{
		$red = $this->database->getRedirectTo();
		foreach ($red as $data)	{
			$this->redirectTo[$data["id_pages"]] = new RedirectTo($data);
			unset($data);
		}
	}
	
	function loadGetTotalUsersInDbUserinfo()
	{
		$this->database->getTotalUsersInDbUserinfo();
	}
	
	function loadTotalUsersInDb($table)
	{
		return $this->database->getTotalUsersInDb($table);
	}
	
	function llamadaGetTotalUsersToni($tabla_a_consultar)
	{
		$this->database->getTotalUsersToni($tabla_a_consultar);
	}

} /* end class phpradmin */
?>