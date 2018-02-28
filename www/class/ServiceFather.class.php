<?
/*
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)
For information : toni@blyx.com
*/

/*	Nagios V1

	host_name 						host_name 
	service_description 			service_description 
	is_volatile 					[0/1] : optionnal
	check_command 					command_name 
	max_check_attempts 				# 
	normal_check_interval 			# 
	retry_check_interval 			# 
	active_checks_enabled 			[0/1] : optionnal
	passive_checks_enabled 			[0/1] : optionnal
	check_period					timeperiod_name 
	parallelize_check 				[0/1] : optionnal
	obsess_over_service 			[0/1] : optionnal
	check_freshness 				[0/1] : optionnal
	freshness_threshold 			# : optionnal
	event_handler 					command_name : optionnal
	event_handler_enabled 			[0/1] : optionnal
	low_flap_threshold 				# : optionnal
	high_flap_threshold 			# : optionnal
	flap_detection_enabled 			[0/1] : optionnal
	process_perf_data				[0/1] : optionnal
	retain_status_information 		[0/1] : optionnal
	retain_nonstatus_information 	[0/1] : optionnal
	notification_interval 			# 
	notification_period 			timeperiod_name 
	notification_options 			[w,u,c,r] 
	notifications_enabled 			[0/1] : optionnal
	contact_groups 					contact_groups 
	stalking_options 				[o,w,u,c] : optionnal
	
	Nagios V2

	host_name 						host_name 
	service_description 			service_description 
	servicegroups 					servicegroup_names : optionnal
	is_volatile 					[0/1] : optionnal
	check_command 					command_name 
	max_check_attempts 				# 
	normal_check_interval 			# 
	retry_check_interval 			# 
	active_checks_enabled 			[0/1] : optionnal
	passive_checks_enabled 			[0/1] : optionnal
	check_period 					timeperiod_name 
	parallelize_check 				[0/1] : optionnal
	obsess_over_service 			[0/1] : optionnal
	check_freshness 				[0/1] : optionnal
	freshness_threshold 			# : optionnal
	event_handler 					command_name : optionnal
	event_handler_enabled 			[0/1] : optionnal
	low_flap_threshold 				# : optionnal
	high_flap_threshold 			# : optionnal
	flap_detection_enabled 			[0/1] : optionnal
	process_perf_data 				[0/1] : optionnal
	retain_status_information		[0/1] : optionnal
	retain_nonstatus_information 	[0/1] : optionnal
	notification_interval 			# 
	notification_period 			timeperiod_name 
	notification_options 			[w,u,c,r,f] 
	notifications_enabled 			[0/1] : optionnal
	contact_groups 					contact_groups 
	stalking_options 				[o,w,u,c] : optionnal

*/


class ServiceFather
{
	
	// Attributes
	
	var $service_template;
	
	var $id;
		
	var $host;
	
	var $description;
	
	var $is_volatile;
	
	var $max_check_attempts;
	
	var $normal_check_interval;
	
	var $retry_check_interval;
	
	var $active_checks_enabled;
	
	var $passive_checks_enabled;
	
	var $parallelize_check;
	
	var $obsess_over_service;
	
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
	
	var $notification_enabled;
		
	var $stalking_options;
	
	var $register;
	
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
	var $check_command_arg;
	
	/** 
	 *  
	 */
	var $extended_service_information;
	
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
	var $contactGroups;
	
	/** 
	 *  
	 */
	var $serviceGroups;
	
	// Operations
	
	function Service($sv)
	{
	$this->id = $sv["service_id"];
	$this->description = str_replace($_SESSION["oreon"]->Nagioscfg->get_illegal_object_name_chars_array(), "", $sv["service_description"]);
	$this->description = str_replace(" ", "_", $this->description);
	// In case of service Template, array fields can be blank, we have to test if you don't want warning (And we don't want it ;-) )
	if (isset($sv["command_command_id"]))
		$this->check_command = $sv["command_command_id"];
	if (isset($sv["command_command_id_arg"]))
		$this->check_command_arg = $sv["command_command_id_arg"];
	if (isset($sv["service_max_check_attempts"]))
		$this->max_check_attempts = $sv["service_max_check_attempts"];
	if (isset($sv["service_normal_check_interval"]))
		$this->normal_check_interval = $sv["service_normal_check_interval"];
	if (isset($sv["service_retry_check_interval"]))
		$this->retry_check_interval = $sv["service_retry_check_interval"];
	if (isset($sv["timeperiod_tp_id"]))
		$this->check_period = $sv["timeperiod_tp_id"];
	if (isset($sv["service_notification_interval"]))
		$this->notification_interval = $sv["service_notification_interval"];
	if (isset($sv["timeperiod_tp_id2"]))
		$this->notification_period = $sv["timeperiod_tp_id2"];
	if (isset($sv["service_notification_options"]))
		$this->notification_options = $sv["service_notification_options"];
	}
	
	function is_complete($version)	{
		if (!$this->host)
			return false;
		if (!$this->description)
			return false;
		if (!$this->check_command)
			return false;
		if (!$this->max_check_attempts)
			return false;
		if (!$this->normal_check_interval)
			return false;
		if (!$this->retry_check_interval)
			return false;
		if (!$this->check_period)
			return false;
		if (!$this->notification_interval)
			return false;
		if (!$this->notification_options)
			return false;
		if (!$this->notification_period)
			return false;
		if (!count($this->contactGroups))
			return false;
		return true;
	}

	function twiceTest($services)
 	{
		if (isset($services) && count($services))
			foreach($services as $sv)
				if ($this->get_host() == $sv->get_host())
					if (!strcmp($this->get_description(), $sv->get_description()))
						if ($this->get_id() != $sv->get_id())
							return false;
		return true;
	}
	
	function get_id(){
		return $this->id;
	}
	
	function get_service_template()	{
		return $this->service_template;
	}
	
	function get_host(){
		return $this->host;
	}
	
	function get_description(){
		return stripslashes($this->description);
	}
	
	function get_is_volatile(){
		return $this->is_volatile;
	}
	
	function get_max_check_attempts(){
		return $this->max_check_attempts;
	}
	
	function get_normal_check_interval(){
		return $this->normal_check_interval;
	}
	
	function get_retry_check_interval(){
		return $this->retry_check_interval;
	}
	
	function get_active_checks_enabled(){
		return $this->active_checks_enabled;
	}
	
	function get_passive_checks_enabled(){
		return $this->passive_checks_enabled;
	}
	
	function get_parallelize_check(){
		return $this->parallelize_check;
	}
	
	function get_obsess_over_service(){
		return $this->obsess_over_service;
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
	
	function get_register()	{
		return $this->register;
	}
	
	
	/*  function get_event_handler(){
		return $this->event_handler;
	}
	*/	
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
	
	function get_notification_enabled(){
		return $this->notification_enabled;
	}
	
	function get_stalking_options(){
		return $this->stalking_options;
	}
	
	function get_event_handler(){
		return $this->event_handler;
	}
	
	function get_event_handler_arg(){
		return $this->event_handler_arg;
	}
	 
	function get_check_command(){
		return $this->check_command;
	}
	 
	function get_check_command_arg(){
		return $this->check_command_arg;
	}
	
	function get_check_period(){
		return $this->check_period;
	}
	
	function get_notification_period(){
		return $this->notification_period;
	}
	
	function get_contact_groups(){
		return $this->contact_groups;
	}
	
	
	//   SET
	
	function set_id($id){
		$this->id = $id;
	}
	
	function set_service_template($service_template)	{
		$this->service_template = $service_template;
	}
	
	function set_host($host){
		$this->host = $host;
	}
	
	function set_description($description){
		$this->description = $description;
	}
	
	function set_is_volatile($is_volatile){
		$this->is_volatile = $is_volatile;
	}
	
	function set_max_check_attempts($max_check_attempts){
		$this->max_check_attempts = $max_check_attempts; 
	}
	
	function set_normal_check_interval($normal_check_interval){
		$this->normal_check_interval = $normal_check_interval;
	}
	
	function set_retry_check_interval($retry_check_interval){
		$this->retry_check_interval = $retry_check_interval;
	}
	
	function set_active_checks_enabled($active_checks_enabled){
		$this->active_checks_enabled = $active_checks_enabled;
	}
	
	function set_passive_checks_enabled($passive_checks_enabled){
		$this->passive_checks_enabled = $passive_checks_enabled;
	}
	
	function set_parallelize_check($parallelize_checks){
		$this->parallelize_check = $parallelize_checks;
	}
	
	function set_obsess_over_service($obsess_over_service){
		$this->obsess_over_service = $obsess_over_service;
	}
	
	function set_check_freshness($check_freshness){
		$this->check_freshness = $check_freshness;
	}
	
	function set_freshness_threshold($freshness_threshold){
		$this->freshness_threshold = $freshness_threshold;
	}
	
	function set_event_handler_enabled($freshness_treshold){
		$this->event_handler_enabled = $freshness_treshold;
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
	
	function set_retain_status_information( $retain_status_information){
		$this->retain_status_information = $retain_status_information;
	}
	
	function set_retain_nonstatus_information($retain_nonstatus_information){
		$this->retain_nonstatus_information = $retain_nonstatus_information;
	}
	
	function set_notification_interval($notification_interval){
		$this->notification_interval = $notification_interval;
	}
	
	function set_notification_options($notification_options){
		$this->notification_options = $notification_options;
	}
	
	function set_notification_enabled($notification_enabled){
		$this->notification_enabled = $notification_enabled;
	}
	
	function set_stalking_options($stalking_options){
		$this->stalking_options = $stalking_options;
	}
	
	function set_check_command($check_command){
		$this->check_command = $check_command;
	}
	
	function set_check_command_arg($check_command_arg){
		$this->check_command_arg = $check_command_arg;
	}
	
	function set_check_period($check_period){
		$this->check_period = $check_period;
	}
	
	function set_notification_period($notification_period){
		$this->notification_period = $notification_period;
	}
	
	function set_contact_groups($cg){
		$this->contact_groups = $cg;
	}
	
	function set_register($register)	{
		$this->register = $register;
	}

} /* end class Service */
?>
