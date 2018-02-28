<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*//* Nagios V1

	hostgroup_name 	hostgroup_name 
	alias 			alias 
	contact_groups 	contact_groups 
	members 		members 



	Nagios V2
	
	hostgroup_name 	hostgroup_name 
	alias 			alias 
	members 		members 

*/


class HostGroup{

  // Attributes

  var $id;

  var $name;

  var $alias;
  
  var $comment;
  
  var	$activate;
  	
	var $errCode;
  	
	var $generated;

  // Associations
	
  var $contact_groups;
  /** 
     *  
     * @element-type Host
   */
  var $hosts; // host_object_array
  var $hostsEmul;
  
  // Operations

	function HostGroup($hostgroup)  	{
		$this->id = $hostgroup["hg_id"];
		$this->name = str_replace($_SESSION["oreon"]->Nagioscfg->get_illegal_object_name_chars_array(), "", $hostgroup["hg_name"]);		
		$this->name = str_replace(" ", "", $this->name);
		$this->alias = str_replace($_SESSION["oreon"]->Nagioscfg->get_illegal_object_name_chars_array(), "", $hostgroup["hg_alias"]);
		$this->contact_groups = array();
		$this->hosts = array();
		$this->errCode = true;	
	}

	function is_complete($version)	{
		$this->errCode = -2;
		if (!strcmp($version, "1"))	{
			if (!$this->name)
				return false;
			if (!$this->alias)
				return false;
			if (!count($this->hosts))
				return false;
			if (!count($this->contact_groups))
				return false;
		}
		else if (!strcmp($version, "2"))	{
			if (!$this->name)
				return false;
			if (!$this->alias)
				return false;
			if (!count($this->hosts))
				return false;
		}
		$this->errCode = true;				
		return true;
	}

	function twiceTest($hostGroups) 	{
		$this->errCode = -3;
		if (isset($hostGroups) && count($hostGroups))
			foreach($hostGroups as $hg)
				if (!strcmp($this->get_name(), $hg->get_name()))
					if ($this->get_id() != $hg->get_id())
					return false;
		$this->errCode = true;
		return true;
	}
			
	function get_id()	{
		return $this->id;
	}
		
	function get_name()	{
		return stripslashes($this->name);
	}
	
	function get_alias()	{
		return stripslashes($this->alias);
	}
	
	function get_comment()	{
		return stripslashes($this->comment);
	}
	
	function get_activate()	{
		return $this->activate;
	}
			
	function get_errCode()	{
		return $this->errCode;
	}
	
	function set_id($id)	{
		$this->id = $id;
	}
	
	function set_name($name)	{
		$this->name = $name;
	}
	
	function set_alias($alias)	{
		$this->alias = $alias;
	}
	
	function set_comment($comment)	{
		$this->comment = $comment;
	}
	
	function set_activate($activate)	{
		$this->activate = $activate;
	}
	
} /* end class HostGroup */
?>
