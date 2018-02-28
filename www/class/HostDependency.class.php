<?
/*
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)
For information : toni@blyx.com
*/
/* Nagios V1

	dependent_host_name 			host_name 
	host_name 						host_name 
	notification_failure_criteria 	[o,d,u,n] 

	Nagios V2
	
	dependent_host_name 			host_name 
	host_name 						host_name 
	inherits_parent 				[0/1] : optionnal
	execution_failure_criteria 		[o,d,u,n] : optionnal
	notification_failure_criteria 	[o,d,u,n] : optionnal

*/

class HostDependency
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
	
	// Operations
	
	function HostDependency($hd)
	{
		$this->id = $hd["hd_id"];
		$this->host = $hd["host_host_id"];
		$this->host_dependent = $hd["host_host_id2"];
		$this->notification_failure_criteria = $hd["hd_notification_failure_criteria"];
		$this->errCode = true;
	}
 	
	function is_complete($version)	{
		$this->errCode = -2;
		if (!strcmp($version, "1")) {
			if (!$this->host)
				return false;
			if (!$this->host_dependent)
				return false;
			if (!$this->notification_failure_criteria)
				return false;
			$this->errCode = true;			
			return true;
		} 
		else if (!strcmp($version, "2"))	{
			if (!$this->host)
				return false;
			if (!$this->host_dependent)
				return false;
			$this->errCode = true;			
			return true;
		}
	}
	
	function twiceTest($hds) 	{
		$this->errCode = -3;
		if (isset($hds) && count($hds))
			foreach($hds as $hd)
				if ($this->get_host() == $hd->get_host())
					if ($this->get_host_dependent() == $hd->get_host_dependent())
						if ($this->get_id() != $hd->get_id())
							return false;
		if ($this->get_host() == $this->get_host_dependent())	{
			$this->errCode = -5;
			return false;
		}
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
	
	function set_inherits_parent($inherits_parent)	{
		$this->inherits_parent = $inherits_parent;
	}
	
	function set_execution_failure_criteria($execution_failure_criteria)	{
		$this->execution_failure_criteria = $execution_failure_criteria;
	}
	
	function set_notification_failure_criteria($notification_failure_criteria)	{
		$this->notification_failure_criteria = $notification_failure_criteria;
	}
	
} /* end class HostDependency */
?>
