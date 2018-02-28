<?
/*
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)
For information : toni@blyx.com
*/

class HostTemplateModel
{
	
	// Attributes
	
	var $id;
	
	function HostTemplateModel($htm)	{
		$this->id = $htm["htm_id"];
	}
	
	function set_id ($id)	{
		$this->id = $id;
	}
	
	function get_id ()	{
		return $this->id;
	}
		
  // Operations
} /* end class HostTemplateModel */
?>
