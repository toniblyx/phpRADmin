<?
/*
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)
For information : toni@blyx.com
*/

/* Nagios V1

	dependent_host_name 			host_name 
	dependent_service_description 	service_description 
	host_name 						host_name 
	service_description 			service_description 
	execution_failure_criteria 		[o,w,u,c,n] : optionnal
	notification_failure_criteria 	[o,w,u,c,n] : optionnal

	Nagios V2
	
	dependent_host_name 			host_name 
	dependent_service_description 	service_description 
	host_name 						host_name 
	service_description 			service_description 
	inherits_parent 				[0/1] : optionnal
	execution_failure_criteria	 	[o,w,u,c,n] : optionnal
	notification_failure_criteria 	[o,w,u,c,n] : optionnal
*/

class ServiceDependency
{

	// Attributes
	
	var $id;
	
	var $inherits_parent;
	
	var $execution_failure_criteria;
	
	var $notification_failure_criteria;
	
	var $errCode;
	
	// Associations
	
	var $host;
	
	var $host_dependent;
	
	var $service;
	
	var $service_dependent;
	
	// Operations
	
	function ServiceDependency($sd)	{
		$this->id = $sd["sd_id"];
		$this->host = $sd["host_host_id"];
		$this->host_dependent = $sd["host_host_id2"];
		$this->service = $sd["service_service_id"];
		$this->service_dependent = $sd["service_service_id2"];
		$this->errCode = true;
	}
 	
	function is_complete($version)	{
		$this->errCode = -2;
		if (!$this->host)
			return false;
		if (!$this->host_dependent)
			return false;
		if (!$this->service)
			return false;
		if (!$this->service_dependent)
			return false;
		$this->errCode = true;			
		return true;
	}
	
	function twiceTest($sds) 	{
		$this->errCode = -3;
		if ($this->get_host() == $this->get_host_dependent() && $this->get_service() == $this->get_service_dependent())	{
			$this->errCode = -5;
			return false;
		}
		if (isset($sds) && count($sds))
			foreach($sds as $sd)
				if ($this->get_host() == $sd->get_host())
					if ($this->get_host_dependent() == $sd->get_host_dependent())
						if ($this->get_service() == $sd->get_service())
							if ($this->get_service_dependent() == $sd->get_service_dependent())
								if ($this->get_id() != $sd->get_id())
									return false;
		$this->errCode = true;
		return true;
	}
			
	function get_id()	{
		return $this->id;
	}
	
	function get_host()	{
		return $this->host;
	}
	
	function get_host_dependent()	{
		return $this->host_dependent;
	}

	function get_service()	{
		return $this->service;
	}
	
	function get_service_dependent()	{
		return $this->service_dependent;
	}
			
	function get_inherits_parent()	{
		return $this->inherits_parent;
	}
  	
	function get_execution_failure_criteria()	{
		return $this->execution_failure_criteria;
	}
	
	function get_notification_failure_criteria()	{
		return $this->notification_failure_criteria;
	}
	
	function get_errCode()	{
		return $this->errCode;
	}
		
	function set_id($id)	{
		$this->id = $id;
	}
	
	function set_host($host)	{
		$this->host = $host;
	}
	
	function set_host_dependent($host_dependent)	{
		$this->host_dependent = $host_dependent;
	}

	function set_service($service)	{
		$this->service = $service;
	}
	
	function set_service_dependent($service_dependent)	{
		$this->service_dependent = $service_dependent;
	}	
	
	function set_inherits_parent($inherits_parent)	{
		$this->inherits_parent = $inherits_parent;
	}
	
	function set_execution_failure_criteria($execution_failure_criteria)	{
		$this->execution_failure_criteria = $execution_failure_criteria;
	}
	
	function set_notification_failure_criteria($notification_failure_criteria)	{
		$this->notification_failure_criteria = $notification_failure_criteria;
	}
		
} /* end class ServiceDependency */
?>
