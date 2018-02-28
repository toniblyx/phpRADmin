<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*//* Nagios V1

	host_name 				host_name 
	contact_groups 			contactgroup_name 
	first_notification	 	# 
	last_notification 		# 
	notification_interval 	# 


	Nagios V2
	
	host_name 				host_name 
	hostgroup_name 			hostgroup_name : optionnal
	contact_groups 			contactgroup_name 
	first_notification 		# 
	last_notification 		# 
	notification_interval 	# 
	escalation_period 		timeperiod_name : optionnal
	escalation_options 		[d,u,r] : optionnal
*/

class HostEscalation
{

	// Attributes
	
	var $id;
	
	var $first_notification;
	
	var $last_notification;
	
	var $notification_interval;
	
	var $escalation_options;
	
	var $errCode;
	
	// Associations
	
	var $escalation_period;
	
	var $host;
	
	var $hostGroups;
	
	var $contactGroups;
	
	// Operations
	
	function HostEscalation($he)	{
		$this->id = $he["he_id"];
		$this->host = $he["host_host_id"];
		$this->first_notification = $he["he_first_notification"];
		$this->last_notification = $he["he_last_notification"];
		$this->notification_interval = $he["he_notification_interval"];
		$this->hostGroups = array();
		$this->contactGroups = array();
		$this->errCode = true;
	}
	
	function is_complete($version)	{
		$this->errCode = -2;
		if (!$this->host)
			return false;
		if (!$this->first_notification)
			return false;
		if (!$this->last_notification)
			return false;
		if (!$this->notification_interval)
			return false;
		if (!count($this->contactGroups))
			return false;
		$this->errCode = true;			
		return true;
	}

	function twiceTest($hes) 	{
		$this->errCode = -3;
		/*if (isset($hes) && count($hes))
			foreach($hes as $he)
				if ($this->get_host() == $he->get_host())
					if ($this->get_id() != $he->get_id())
						return false;*/
		$this->errCode = true;
		return true;
	}
		
	function get_id ()	{
		return $this->id;
	}
	
	function get_first_notification ()	{
		return $this->first_notification;
	}
	
	function get_last_notification ()	{
		return $this->last_notification;
	}
	
	function get_notification_interval ()	{
		return $this->notification_interval;
	}
	
	function get_escalation_options ()	{
		return $this->escalation_options;
	}
	
	function get_escalation_period()	{
		return $this->escalation_period;
	}
	
	function get_host ()	{
		return $this->host;
	}

	function get_contactGroups ()	{
		return $this->contactGroups;
	}
	
	function get_hostGroups ()	{
		return $this->hostGroups;
	}
			
	function get_errCode()	{
		return $this->errCode;
	}
	
	function set_id ($id)	{
		$this->id = $id;
	}
	
	function set_first_notification ($first_notification)	{
		$this->first_notification = $first_notification;
	}
	
	function set_last_notification ($last_notification)	{
		$this->last_notification = $last_notification;
	}
	
	function set_notification_interval ($notification_interval)	{
		$this->notification_interval = $notification_interval;
	}
	
	function set_escalation_options ($escalation_options)	{
		$this->escalation_options = $escalation_options;
	}
	
	function set_escalation_period ($escalation_period)	{
		$this->escalation_period = $escalation_period;
	}
	
	function set_host ($host)	{
		$this->host = $host;
	}
	
	function set_contactGroups($cg)	{
		$this->contactGroups = $cg;
	}
	
	function set_hostGroups($hg)	{
		$this->hostGroups = $hg;
	}
	
} /* end class HostEscalation */
?>
