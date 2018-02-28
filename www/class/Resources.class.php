<?
/*
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)
For information : toni@blyx.com
*/

class Resourcecfg
{

  // Attributes

  var $id;

  var $line;

  var $comment;

  // Operations

	function Resourcecfg($resource)
  	{
		$this->id = $resource["resource_id"];
		$this->line = $resource["resource_line"];
		$this->comment = $resource["resource_comment"];	
	}

	function is_complete($version)	{
		if (!$this->id)
			return false;
		if (!$this->line)
			return false;
		if (!$this->comment)
			return false;
		return true;
	}

	function twiceTest($resources)
 	{
		if (isset($resources) && count($resources))
			foreach($resources as $rs)
				if ($this->get_id() == $rs->get_id())
					return false;
		return true;
	}
			
	function get_id()	{
		return $this->id;
	}
		
	function get_line()	{
		return stripslashes($this->line);
	}
	
	function get_comment()	{
		return stripslashes($this->comment);
	}
	
	function set_id($id)	{
		$this->id = $id;
	}
	
	function set_line($line)	{
		$this->line = $line;
	}
		
	function set_comment($comment)	{
		$this->comment = $comment;
	}
	
} /* end class Resources */
?>
