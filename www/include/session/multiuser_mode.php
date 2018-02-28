<?
/*
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)
For information : toni@blyx.com
*/

function check_reload_data(& $oreon)
{
		$objtoreload = $oreon->load_current_data_to_reload(session_id());
		if ($objtoreload["nagioscfg"]){
			unset($oreon->nagioscfg);
			$oreon->loadNagioscfg();
		}
		if ($objtoreload["ressourcecfg"]){
			unset($oreon->ressourcecfg);
			$oreon->loadResourcecfg();
		}
		if ($objtoreload["timeperiod"]){
			unset($oreon->time_periods);
			$oreon->loadTimePeriod();
		}
		if ($objtoreload["command"]){
			unset($oreon->commands);
			$oreon->loadCommand();
		}
		if ($objtoreload["contact"]){
			unset($oreon->contacts);
			$oreon->loadContact();
		}
		if ($objtoreload["contact_group"]){
			unset($oreon->contactGroups);	
			$oreon->loadContactgroup();
		}
		if ($objtoreload["host"]){
			unset($oreon->hosts);
			$oreon->loadHost();
		}
		if ($objtoreload["host_template_model"]){
			unset($oreon->htms);
			$oreon->loadHostTemplateModel();
		}
		if ($objtoreload["host_group"]){
			unset($oreon->hostGroups);
			$oreon->loadHostGroup();
		}
		if ($objtoreload["service"]){
			unset($oreon->services);
			$oreon->loadService();
		}
		if ($objtoreload["service_template_model"]){
			unset($oreon->stms);
			$oreon->loadServiceTemplateModel();
		}
		if ($objtoreload["service_group"]){
			unset($oreon->serviceGroups);
			$oreon->loadServiceGroup();
		}
		if ($objtoreload["service_extended_infos"]){
			unset($oreon->esis);
			$oreon->loadExtendedServiceInformation();
		}
		if ($objtoreload["host_extended_infos"]){
			unset($oreon->ehis);
			$oreon->loadExtendedHostInformation();
		}
		if ($objtoreload["host_escalation"]){
			unset($oreon->hes);
			$oreon->loadHostEscalation();
		}
		if ($objtoreload["service_escalation"]){
			unset($oreon->ses);
			$oreon->loadServiceEscalation();
		}
		if ($objtoreload["host_dependency"]){
		 	unset($oreon->hds);
			$oreon->loadHostDependency();
		}
		if ($objtoreload["service_dependency"]){
			unset($oreon->sds);
			$oreon->loadServiceDependency();
		}
		if ($objtoreload["host_group_escalation"]){
			unset($oreon->hges);
			$oreon->loadHostGroupEscalation();
		}
		if ($objtoreload["trafficMap"]){
			unset($oreon->trafficMaps);
			$oreon->loadTrafficMaps();
		}
		if ($objtoreload["graph"]){
			unset($oreon->graphs);
			$oreon->loadGraph();
		}
		if ($objtoreload["graph_model_ds"] || $objtoreload["graph_model_conf"]){
			unset($oreon->graphModels);
			unset($oreon->graphModelDS);
			$oreon->loadGraphModels();
		}
		if ($objtoreload["general"]){
			unset($oreon->optGen);
			$oreon->loadoptgen();
		}
		if ($objtoreload["lca"]){
			unset($oreon->Lca);
			$oreon->loadLca();
		}
		if ($objtoreload["profile_user"]){
			unset($oreon->users);
			$oreon->loadUsers();
		}
		$oreon->clean_table_from_current_user();
}

?>