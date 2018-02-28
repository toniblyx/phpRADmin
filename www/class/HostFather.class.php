<?
/*
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)
For information : toni@blyx.com
*/

/* Nagios V1

	host_name 						host_name 
	alias 							alias 
	address 						address 
	parents 						host_names : optionnal
	check_command 					command_name : optionnal
	max_check_attempts 				# 
	checks_enabled 					[0/1] : optionnal
	event_handler 					command_name : optionnal
	event_handler_enabled 			[0/1] : optionnal
	low_flap_threshold 				# : optionnal
	high_flap_threshold 			# : optionnal
	flap_detection_enabled 			[0/1] : optionnal
	process_perf_data 				[0/1] : optionnal
	retain_status_information 		[0/1] : optionnal
	retain_nonstatus_information	[0/1] : optionnal
	notification_interval 			# 
	notification_period 			timeperiod_name 
	notification_options 			[d,u,r] 
	notifications_enabled 			[0/1] : optionnal
	stalking_options 				[o,d,u] : optionnal

Nagios V2

	host_name 						host_name 
	alias 							alias 
	address 						address 
	parents 						host_names : optionnal
	hostgroups 						hostgroup_names : optionnal
	check_command 					command_name : optionnal
	max_check_attempts				# 
	check_interval 					# : optionnal
	active_checks_enabled 			[0/1] : optionnal
	passive_checks_enabled 			[0/1] : optionnal
	check_period 					timeperiod_name 
	obsess_over_host 				[0/1] : optionnal
	check_freshness 				[0/1] : optionnal
	freshness_threshold 			# : optionnal
	event_handler 					command_name : optionnal
	event_handler_enabled 			[0/1] : optionnal
	low_flap_threshold 				# : optionnal
	high_flap_threshold 			# : optionnal
	flap_detection_enabled 			[0/1] : optionnal
	process_perf_data 				[0/1] : optionnal
	retain_status_information 		[0/1] : optionnal
	retain_nonstatus_information 	[0/1] : optionnal
	contact_groups 					contact_groups 
	notification_interval 			# 
	notification_period 			timeperiod_name 
	notification_options 			[d,u,r,f] 
	notifications_enabled 			[0/1] : optionnal
	stalking_options 				[o,d,u] : optionnal

*/


class HostFather
{
  // Attributes
	
	var $host_template;
	
	var $id;
	
	var $name;
	
	var $alias;
	
	var $address;
	
	var $max_check_attempts;
	
	var $check_interval;
	
	var $active_checks_enabled;
	
	var $passive_checks_enabled;
	
	var $checks_enabled;
	
	var $obsess_over_host;
	
	var $check_freshness;
	
	var $freshness_threshold;
	
	var $event_handler_enabled;
	
	var $low_flap_threshold;
	
	var $high_flap_threshold;
	
	var $flap_detection_enabled;
	
	var $process_perf_data;
	
	var $retain_status_information;
	
	var $retain_nonstatus_information;
	
	var $notification_interval;
	
	var $notification_options;
	
	var $notifications_enabled;
	
	var $stalking_options;
	
	var $register;
	
	var $host_created_date;
	
	// Associations
	
	/** 
	*  
	*/
	var $event_handler;
	
	/** 
	*  
	*/
	var $event_handler_arg;
	
	/** 
	*  
	*/
	var $check_command;
		
	/** 
	*  
	*/
	var $extendedHostInformation;
	
	/** 
	*  
	* @element-type HostParent
	*/
	var $parents;
	
	/** 
	*  
	*/
	var $dependency;
	
	/** 
	*  
	*/
	var $check_period;
	
	/** 
	*  
	*/
	var $notification_period;
	
	/** 
	*  
	*/
	var $contactgroups;
	
	/** 
	*  
	*/
	var $hostGroups;
	
	/** 
	*  
	*/
	var $services;
	
	// Operations
	
	function Host($host)
	{
		$this->id = $host["host_id"];
		$this->name = str_replace($_SESSION["oreon"]->Nagioscfg->get_illegal_object_name_chars_array(), "", $host["host_name"]);
		$this->name = str_replace(" ", "_", $this->name);
		$this->alias = str_replace($_SESSION["oreon"]->Nagioscfg->get_illegal_object_name_chars_array(), "", $host["host_alias"]);
		$this->alias = str_replace(" ", "_", $this->alias);
		$this->address = $host["host_address"];
		$this->max_check_attempts = $host["host_max_check_attempts"];
		$this->notification_interval = $host["host_notification_interval"];
		$this->notification_period = $host["timeperiod_tp_id2"];
		$this->notification_options = $host["host_notification_options"];
	}

	function twiceTest($hosts)
 	{
		if (isset($hosts) && count($hosts))
			foreach($hosts as $host)	{
				if (!strcmp($this->get_name(), $host->get_name()))
					if ($this->get_id() != $host->get_id())
						return false;
				unset($host);
			}
		return true;
	}
	
	function is_complete($version)	{
		if (!strcmp($version, "1"))	{
			if (!$this->name)
				return false;
			if (!$this->alias)
				return false;
			if (!$this->address)
				return false;
			if (!$this->max_check_attempts)
				return false;
			if (!$this->notification_interval)
				return false;
			if (!$this->notification_options)
				return false;
			if (!$this->notification_period)
				return false;
			return true;
		}	
		else if (!strcmp($version, "2"))	{
			if (!$this->name)
				return false;
			if (!$this->alias)
				return false;
			if (!$this->address)
				return false;
			if (!$this->max_check_attempts)
				return false;
			if (!$this->check_period)
				return false;
			if (!count($this->contactgroups))
				return false;
			if (!$this->notification_period)
				return false;
			if (!$this->notification_interval)
				return false;
			if (!$this->notification_options)
				return false;			
			return true;
		}
	}
  
	function get_id(){
	return $this->id;
	}
	
	function get_host_template(){
		return $this->host_template;
	}
	
	function get_name(){
	return stripslashes($this->name);
	}
	
	function get_alias(){
	return stripslashes($this->alias);
	}
	
	function get_address(){
	return $this->address;
	}
	
	function get_max_check_attempts(){
	return $this->max_check_attempts;
	}
	
	function get_check_interval(){
	return $this->check_interval;
	}
	
	function get_active_checks_enabled(){
	return $this->active_checks_enabled;
	}
	
	function get_passive_checks_enabled(){
	return $this->passive_checks_enabled;
	}
	
	function get_checks_enabled(){
	return $this->checks_enabled;
	}
	
	function get_check_period(){
	return $this->check_period;
	}
	
	function get_check_command(){
	return $this->check_command;
	}
	
	function get_obsess_over_host(){
	return $this->obsess_over_host;
	}
	
	function get_check_freshness(){
	return $this->check_freshness;
	}
	
	function get_freshness_threshold(){
	return $this->freshness_threshold;
	}
	
	function get_event_handler_enabled(){
	return $this->event_handler_enabled;
	}
	
	function get_event_handler(){
	return $this->event_handler;
	}
	
	function get_event_handler_arg(){
		return $this->event_handler_arg;
	}
	
	function get_low_flap_threshold(){
	return $this->low_flap_threshold;
	}
	
	function get_high_flap_threshold(){
	return $this->high_flap_threshold;
	}
	
	function get_flap_detection_enabled(){
	return $this->flap_detection_enabled;
	}
	
	function get_process_perf_data(){
	return $this->process_perf_data;
	}
	
	function get_contactgroup(){
	return $this->contactgroups;	
	}
	
	function get_retain_status_information(){
	return $this->retain_status_information;
	}
	
	function get_retain_nonstatus_information(){
	return $this->retain_nonstatus_information;
	}
	
	function get_notification_interval(){
	return $this->notification_interval;
	}
	
	function get_notification_options(){
	return $this->notification_options;
	}
	
	function get_notification_period(){
	return $this->notification_period;
	}	
	
	function get_notifications_enabled(){
	return $this->notifications_enabled;
	}
	
	function get_stalking_options(){
	return $this->stalking_options;
	}
		
	function get_register(){
		return $this->register;
	}	
	
	function get_created_date(){
		return $this->host_created_date;
	}	
	
	// SET
	
	function set_id($id){
	$this->id = $id;
	}
	
	function set_host_template($host_template){
	$this->host_template = $host_template;
	}
	
	function set_name($name){
	$this->name = $name;
	}
	
	function set_alias($alias){
	$this->alias = $alias;
	}
	function set_address($address){
	$this->address = $address;
	}
	
	function set_check_command($command){
	$this->check_command = $command;
	}
		
	function set_check_period($period){
	$this->check_period = $period;
	}
	
	function set_max_check_attempts($max_check_attempts){
	$this->max_check_attempts = $max_check_attempts;
	}
	
	function set_check_interval($check_interval){
	$this->check_interval = $check_interval;
	}
	
	function set_active_checks_enabled($active_checks_enabled){
	$this->active_checks_enabled = $active_checks_enabled;
	}
	
	function set_passive_checks_enabled($passive_checks_enabled){
	$this->passive_checks_enabled = $passive_checks_enabled;
	}
	
	function set_checks_enabled($checks_enabled){
	$this->checks_enabled = $checks_enabled;
	}
	
	function set_obsess_over_host($obsess_over_host){
	$this->obsess_over_host = $obsess_over_host;
	}
	
	function set_check_freshness($check_freshness){
	$this->check_freshness = $check_freshness;
	}
	
	function set_freshness_threshold($freshness_threshold){
	$this->freshness_threshold = $freshness_threshold;
	}
	
	function set_event_handler_enabled($event_handler_enabled){
	$this->event_handler_enabled = $event_handler_enabled;
	}
	
	function set_event_handler($event_handler){
	$this->event_handler = $event_handler;
	}
	
	function set_event_handler_arg($event_handler_arg){
	$this->event_handler_arg = $event_handler_arg;
	}
		
	function set_low_flap_threshold($low_flap_threshold){
	$this->low_flap_threshold = $low_flap_threshold;
	}
	
	function set_high_flap_threshold($high_flap_threshold){
	$this->high_flap_threshold = $high_flap_threshold;
	}
	
	function set_flap_detection_enabled($flap_detection_enabled){
	$this->flap_detection_enabled = $flap_detection_enabled;
	}
	
	function set_process_perf_data($process_perf_data){
	$this->process_perf_data = $process_perf_data;
	}
	
	function set_retain_status_information($retain_status_information){
	$this->retain_status_information = $retain_status_information;
	}
	
	function set_retain_nonstatus_information($retain_nonstatus_information){
	$this->retain_nonstatus_information = $retain_nonstatus_information;
	}
	
	function set_contactgroup($contactgroup){
	$this->contactgroups = $contactgroup;	
	}
	
	function set_notification_interval($notification_interval){
	$this->notification_interval = $notification_interval;
	}
	
	function set_notification_options($notification_options){
	$this->notification_options = $notification_options;
	}
	
	function set_notifications_enabled($notifications_enabled){
	$this->notifications_enabled = $notifications_enabled;
	}
	
	function set_notification_period($notification_period){
	$this->notification_period = $notification_period;
	}
	
	function set_stalking_options($stalking_options){
	$this->stalking_options = $stalking_options;
	}
	
	function set_register($register)	{
	$this->register = $register;
	}
	
	function set_host_created_date ($host_created_date )	{
	$this->host_created_date  = $host_created_date ;
	}
} /* end class Host */
?>
