<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*//* Nagios V1 & V2

 dependent_host_name 				host_name 
 dependent_service_description 		service_description 
 host_name 							host_name 
 service_description 				service_description 
 inherits_parent 					[0/1] 
 execution_failure_criteria 		[o,w,u,c,n] 
 notification_failure_criteria 		[o,w,u,c,n] 
 
*/

class Command
{

  // Attributes

  var $command_id;

  var $command_name;

  var $command_line;
  
  var $command_type;
  
  var $errCode;

  // Associations

  // Operations

  	function Command($command)  	{
		$this->command_id = $command["command_id"];
		$this->command_name = str_replace($_SESSION["oreon"]->Nagioscfg->get_illegal_object_name_chars_array(), "", $command["command_name"]);
		$this->command_line = addslashes($command["command_line"]);
		$this->command_type = $command["command_type"];
		$this->errCode = true;
	}
	
	function is_complete($version)	{
		$this->errCode = -2;
		if (!$this->command_name)
			return false;
		if (!$this->command_line)
			return false;
		if (!$this->command_type)
			return false;
		$this->errCode = true;			
		return true;
	}

	function twiceTest($cmds) 	{
		$this->errCode = -3;
		if (isset($cmds) && count($cmds))
			foreach($cmds as $cmd)
				if (!strcmp($this->get_name(), $cmd->get_name()))
					if ($this->get_id() != $cmd->get_id())
						return false;
		$this->errCode = true;
		return true;
	}
			
  // Get
  
	function get_id()	{
		return $this->command_id;
	}
	
	function get_name()	{
		return stripslashes($this->command_name);
	}
	
	function get_line()	{
		return stripslashes($this->command_line);
	}
	
	function get_type()	{
		return $this->command_type;
	}
	
	function get_errCode()	{
		return $this->errCode;
	}
	
  // Set

	function set_id($id)	{
		$this->command_id = $id;
	}
	
	function set_name($name)	{
		$this->command_name = $name;
	}
	
	function set_line($line)	{
		$this->command_line = $line;
	}	
	
	function set_type($type)	{
		$this->command_type = $type;
	}
	
} /* end class Command */
?>
