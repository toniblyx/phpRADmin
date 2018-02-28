<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*//* Nagios V1

	hostgroup_name			hostgroup_name 
	contact_groups 			contactgroup_name 
	first_notification	 	# 
	last_notification 		# 
	notification_interval 	# 
*/

class HostGroupEscalation
{

	// Attributes
	
	var $id;
	
	var $first_notification;
	
	var $last_notification;
	
	var $notification_interval;
	
	var $errCode;
	
	// Associations
		
	var $hostgroup;
	
	var $contactGroups;
	
	// Operations
	
	function HostGroupEscalation($hge)	{
		$this->id = $hge["hge_id"];
		$this->hostgroup = $hge["hostgroup_hg_id"];
		$this->first_notification = $hge["hge_first_notification"];
		$this->last_notification = $hge["hge_last_notification"];
		$this->notification_interval = $hge["hge_notification_interval"];
		$this->contactGroups = array();
		$this->errCode = true;
	}
	
	function is_complete($version)	{
		$this->errCode = -2;
		if (!strcmp($version, "1")) {
			if (!$this->hostgroup)
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
	}

	function twiceTest($hges) 	{
		$this->errCode = -3;
		/*if (isset($hges) && count($hges))
			foreach($hges as $hge)
				if ($this->get_hostgroup() == $hge->get_hostgroup())
					if ($this->get_id() != $hge->get_id())
						return false;
		*/
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
	
	function get_hostgroup ()	{
		return $this->hostgroup;
	}

	function get_contactGroups ()	{
		return $this->contactGroups;
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
	
	function set_hostgroup ($hostgroup)	{
		$this->hostgroup = $hostgroup;
	}
	
	function set_contactGroups($cg)	{
		$this->contactGroups = $cg;
	}
	
} /* end class HostEscalation */
?>
