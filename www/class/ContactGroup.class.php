<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*//* Nagios V1 & V2

 contactgroup_name 		contactgroup_name 
 alias 					alias 
 members 				members 
 
*/

class ContactGroup
{

  // Attributes

  var $name;

  var $alias;

  var $id;

 var $comment;
 
 var $errCode;
 
 var $activate;
 
 var $generated;
 
  // Associations

  /** 
     *  
     * @element-type Contact
   */
 var $contacts;  // contact_object_array

  // Operations
	
  	
	function ContactGroup($cg)
  	{
		$this->id = $cg["cg_id"];
		$this->name = str_replace($_SESSION["oreon"]->Nagioscfg->get_illegal_object_name_chars_array(), "", $cg["cg_name"]);		
		$this->name = str_replace(" ", "", $this->name);
		$this->alias = str_replace($_SESSION["oreon"]->Nagioscfg->get_illegal_object_name_chars_array(), "", $cg["cg_alias"]);
		$this->contacts = array();
		$this->errCode = true;
  	}
	
	function is_complete($version)	{
		$this->errCode = -2;
		if (!$this->name)
			return false;
		if (!$this->alias)
			return false;
		if (!count($this->contacts))
			return false;
		$this->errCode = true;			
		return true;
	}

	function twiceTest($cgs) 	{
		$this->errCode = -3;
		if (isset($cgs) && count($cgs))
			foreach($cgs as $cg)
				if (!strcmp($this->get_name(), $cg->get_name()))
						if ($this->get_id() != $cg->get_id())
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
	
	function get_errCode()		{
		return $this->errCode;
	}
	
	function get_activate()		{
		return $this->activate;
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
} /* end class ContactGroup */
?>
