<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*//**
	Nagios V1

	contact_name 					contact_name 
	alias 							alias 
	host_notification_period 		timeperiod_name 
	service_notification_period 	timeperiod_name 
	host_notification_options		[d,u,r,n] 
	service_notification_options 	[w,u,c,r,n] 
	host_notification_commands 		command_name
	service_notification_commands 	command_name
	email 							email_address
	pager 							pager_number or pager_email_gateway : optionnal
	
	Nagios V2
	
	contact_name 					contact_name 
	alias 							alias 
	contactgroups 					contactgroup_names : optionnal
	host_notification_period 		timeperiod_name 
	service_notification_period 	timeperiod_name 
	host_notification_options 		[d,u,r,f,n] 
	service_notification_options 	[w,u,c,r,f,n] 
	host_notification_commands 		command_name
	service_notification_commands 	command_name
	email 							email_address
	pager 							pager_number or pager_email_gateway : optionnal
	addressx 						additional_contact_address : optionnal

*/
class Contact
{
	
	// Attributes
	
	var $id; 
	
	var $name;
	
	var $alias;
	
	var $host_notification_options;
	
	var $service_notification_options;
	
	var $email;
	
	var $pager;
	
	var $comment;
	
	var $errCode;
	
	var $activate;
	
	var $generated;
	
	// Associations
	
	/**
	*
	* @element-type ContactGroup
	*/
	var $contact_groups;
	
	/** 
	 *  
	 * @element-type Command
	*/
	var $host_notification_commands; // commands_object_array
	
	/** 
	 *  
	 * @element-type Command
	*/
	var $service_notification_commands;// commands_object_array : optionnal
	
	/** 
	 *  
	 */
	var $address; // array 

	
	/** 
	 *  
	 */
	var $host_notification_period; // TimePeriod Object
	
	/** 
	 *  
	 */
	var $service_notification_period; // TimePeriod Object
	
	// Operations
	
	function Contact($cct)	{
		$this->id = $cct["contact_id"];
		$this->name = str_replace($_SESSION["oreon"]->Nagioscfg->get_illegal_object_name_chars_array(), "", $cct["contact_name"]);
		$this->name = str_replace(" ", "", $this->name);
		$this->alias = str_replace($_SESSION["oreon"]->Nagioscfg->get_illegal_object_name_chars_array(), "", $cct["contact_alias"]);
		$this->host_notification_options = $cct["contact_host_notification_options"];
		$this->service_notification_options = $cct["contact_service_notification_options"];
		$this->host_notification_period = $cct["timeperiod_tp_id"];
		$this->service_notification_period =  $cct["timeperiod_tp_id2"];
		$this->email = new Email($cct["contact_email"]);
		$this->contact_groups = array();
		$this->host_notification_commands = array();
		$this->service_notification_commands = array();
		$this->errCode = true;
	}
	
	function is_complete($version)	{
		$this->errCode = -2;
		if (!$this->name)
			return false;
		if (!$this->alias)
			return false;
		if (!$this->host_notification_period)
			return false;
		if (!$this->service_notification_period)
			return false;
		if (!$this->host_notification_options)
			return false;
		if (!$this->service_notification_options)
			return false;
		if (!count($this->host_notification_commands))
			return false;
		if (!count($this->service_notification_commands))
			return false;
		if (!$this->email || !$this->email->check())	{
			$this->errCode = -4;
			return false;
		}
		$this->errCode = true;			
		return true;
	}

	function twiceTest($contacts) 	{
		$this->errCode = -3;
		if (isset($contacts) && count($contacts))
			foreach($contacts as $contact)
				if (!strcmp($this->get_name(), $contact->get_name()))
					if ($this->get_id() != $contact->get_id())
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
	
	function get_host_notification_options()	{
		return $this->host_notification_options;
	}
	
	function get_service_notification_options()	{
		return $this->service_notification_options;
	}
	
	function get_email()	{
		return $this->email->get_email();
	}
	
	function get_pager()	{
		return stripslashes($this->pager);
	}
	
	function get_host_notification_commands()	{
		return $this->host_notification_commands;
	}
	
	function get_service_notification_commands()	{
		return $this->service_notification_commands;
	}
	
	function get_address()	{
		return stripslashes($this->address);
	}
	
	function get_host_notification_period()	{
		return $this->host_notification_period;
	}
	
	function get_service_notification_period()	{
		return $this->service_notification_period;
	}
	
	function get_comment()	{
		return stripslashes($this->comment);
	}
		
	function get_errCode()	{
		return $this->errCode;
	}
		
	function get_activate()	{
		return $this->activate;
	}
	// SET
	
	function set_id($id)	{
		$this->id = $id;
	}
	
	function set_name($name)	{
		$this->name = $name;
	}	
	
	function set_alias($alias)	{
		$this->alias = $alias;
	}	
	
	function set_host_notification_options($host_notification_options)	{
		$this->host_notification_options = $host_notification_options;
	}	
	
	function set_service_notification_options($service_notification_options)	{
		$this->service_notification_options = $service_notification_options;
	}	
		
	function set_pager($pager)	{
		$this->pager = $pager;
	}	
	
	function set_host_notification_commands($host_notification_commands)	{
		$this->host_notification_commands = $host_notification_commands;
	}	
	
	function set_service_notification_commands($service_notification_commands)	{
		$this->service_notification_commands = $service_notification_commands;
	}	
	
	function set_address($address)	{
		$this->address = $address;
	}	
	
	function set_host_notification_period($host_notification_period)	{
		$this->host_notification_period = $host_notification_period;
	}	
	
	function set_service_notification_period($service_notification_period)	{
		$this->service_notification_period = $service_notification_period;
	}	
	
	function set_comment($comment)	{
		$this->comment = $comment;
	}	
	
	function set_activate($activate)	{
		$this->activate = $activate;
	}
	
} /* end class Contact */
?>
