<?
/*
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)
For information : toni@blyx.com
*/
class ServiceTemplateModel
{
	
	// Attributes
	
	var $id;
		
	function ServiceTemplateModel($stm)	{
		$this->id = $stm["stm_id"];
	}
	
	function set_id ($id)	{
		$this->id = $id;
	}
	
	function get_id ()	{
		return $this->id;
	}

} /* end class ServiceTemplateModel */
?>
