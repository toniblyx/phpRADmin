<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*//*	Nagios V2
	
	servicegroup_name 	servicegroup_name 
	alias 				alias 
	members 			members
*/

class ServiceGroup
{

  // Attributes

  var $name;

  var $alias;

  var $id;
  
  var $comment;
  
  var $activate;
  
  var $errCode;

  // Associations

  var $services; // service_object_array
  var $servicesEmul;
  
  // Operations
	
  	
	function ServiceGroup($sg)  	{
		$this->id = $sg["sg_id"];
		$this->name = str_replace($_SESSION["oreon"]->Nagioscfg->get_illegal_object_name_chars_array(), "", $sg["sg_name"]);
		$this->name = str_replace(" ", "", $this->name);
		$this->alias = str_replace($_SESSION["oreon"]->Nagioscfg->get_illegal_object_name_chars_array(), "", $sg["sg_alias"]);
		$this->services = array();
		$this->errCode = true;
  	}
	
	function is_complete($version)	{
		$this->errCode = -2;
		if (!$this->name)
			return false;
		if (!$this->alias)
			return false;
		if (!count($this->services))
			return false;
		$this->errCode = true;			
		return true;
	}

	function twiceTest($serviceGroups) 	{
		$this->errCode = -3;
		if (isset($serviceGroups) && count($serviceGroups))
			foreach($serviceGroups as $sg)
				if (!strcmp($this->get_name(), $sg->get_name()))
					if ($this->get_id() != $sg->get_id())
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

	function get_comment()	{
		return stripslashes($this->comment);
	}
	
	function get_alias()	{
		return stripslashes($this->alias);
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
} /* end class ServiceGroup */
?>