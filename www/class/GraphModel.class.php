<?
/*
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)
For information : toni@blyx.com
*/

class GraphModel{

  // Attributes

	var $gmod_id;
	var $gmod_imgformat;
	var $gmod_verticallabel;
	var $gmod_width;
	var $gmod_height;
	var $gmod_lowerlimit;
	var $gmod_ColGrilFond;
	var $gmod_ColFond;
	var $gmod_ColPolice;	
	var $gmod_ColGrGril;	
	var $gmod_ColPtGril;
	var $gmod_ColContCub;
	var $gmod_ColArrow;
	var $gmod_ColImHau;
	var $gmod_ColImBa;
	var $errCode;

  // Operations

  	function GraphModel($gmod)  	{
		$this->gmod_id = $gmod["gmod_id"];
		$this->gmod_name = str_replace($_SESSION["oreon"]->Nagioscfg->get_illegal_object_name_chars_array(), "", $gmod["gmod_name"]);
		$this->gmod_name = str_replace(" ", "_", $this->gmod_name);
		$this->gmod_imgformat = $gmod["gmod_imgformat"];
		$this->gmod_verticallabel = $gmod["gmod_verticallabel"];
		$this->gmod_width = $gmod["gmod_width"];
		$this->gmod_height = $gmod["gmod_height"];
		$this->gmod_lowerlimit = $gmod["gmod_lowerlimit"];
		$this->gmod_ColGrilFond = $gmod["gmod_ColGrilFond"];
		$this->gmod_ColFond = $gmod["gmod_ColFond"];
		$this->gmod_ColPolice = $gmod["gmod_ColPolice"];
		$this->gmod_ColGrGril = $gmod["gmod_ColGrGril"];
		$this->gmod_ColPtGril = $gmod["gmod_ColPtGril"];
		$this->gmod_ColContCub = $gmod["gmod_ColContCub"];
		$this->gmod_ColArrow = $gmod["gmod_ColArrow"];
		$this->gmod_ColImHau = $gmod["gmod_ColImHau"];
		$this->gmod_ColImBa= $gmod["gmod_ColImBa"];
		$this->errCode = true;
	}
	
	function twiceTest($gmods) 	{
		$this->errCode = -3;
		if (isset($gmods) && count($gmods))
			foreach($gmods as $gmod)	{
				if (!strcmp($this->get_name(), $gmod->get_name()))
					if ($this->get_id() != $gmod->get_id())
						return false;
				unset($gmod);
			}
		$this->errCode= true;
		return true;
	}	
	
	function is_complete() 	{
		$this->errCode = -2;
		if (!$this->gmod_name)
			return false;
		$this->errCode= true;
		return true;
	}
			
  // Get
  
	function get_id()	{
		return $this->gmod_id;
	}	
	function get_name()	{
		return stripslashes($this->gmod_name);
	}	
	function get_imgformat()	{
		return stripslashes($this->gmod_imgformat);
	}	
	function get_verticallabel()	{
		return $this->gmod_verticallabel;
	}	
	function get_width()	{
		return $this->gmod_width;
	}	
	function get_height()	{
		return $this->gmod_height;
	}	
	function get_lowerlimit()	{
		return $this->gmod_lowerlimit;
	}	
	function get_ColGrilFond()	{
		return $this->gmod_ColGrilFond;
	}	
	function get_ColFond()	{
		return $this->gmod_ColFond;
	}	
	function get_ColPolice()	{
		return $this->gmod_ColPolice;
	}	
	function get_ColGrGril()	{
		return $this->gmod_ColGrGril;
	}	
	function get_ColPtGril()	{
		return $this->gmod_ColPtGril;
	}	
	function get_ColContCub()	{
		return $this->gmod_ColContCub;
	}	
	function get_ColArrow()	{
		return $this->gmod_ColArrow;
	}	
	function get_ColImHau()	{
		return $this->gmod_ColImHau;
	}	
	function get_ColImBa()	{
		return $this->gmod_ColImBa;
	}
	function get_errCode()	{
		return $this->errCode;
	}
	
	function set_id($id)	{
		$this->gmod_id = $id;
	}
}

class GraphModelDS{

  // Attributes

	var $gmod_ds_id;
	var $gmod_ds_alias;
	var $gmod_ds_name;
	var $gmod_ds_col;
	var $gmod_ds_flamming;
	var $gmod_ds_area;
	var $gmod_ds_tickness;
	var $gmod_ds_gprintlast;
	var $gmod_ds_gprintmin;	
	var $gmod_ds_gprintaverage;	
	var $gmod_ds_gprintmax;
	var $errCode;

  // Operations

  	function GraphModelDS($gmod_ds)  	{
		$this->gmod_ds_id = $gmod_ds["gmod_ds_id"];
		$this->gmod_ds_alias= str_replace($_SESSION["oreon"]->Nagioscfg->get_illegal_object_name_chars_array(), "", $gmod_ds["gmod_ds_alias"]);
		$this->gmod_ds_alias = str_replace(" ", "_", $this->gmod_ds_alias);
		$this->gmod_ds_name = $gmod_ds["gmod_ds_name"];
		$this->gmod_ds_col = $gmod_ds["gmod_ds_col"];
		$this->gmod_ds_flamming = $gmod_ds["gmod_ds_flamming"];
		$this->gmod_ds_area = $gmod_ds["gmod_ds_area"];
		$this->gmod_ds_tickness = $gmod_ds["gmod_ds_tickness"];
		$this->gmod_ds_gprintlast = $gmod_ds["gmod_ds_gprintlast"];
		$this->gmod_ds_gprintmin = $gmod_ds["gmod_ds_gprintmin"];
		$this->gmod_ds_gprintaverage = $gmod_ds["gmod_ds_gprintaverage"];
		$this->gmod_ds_gprintmax = $gmod_ds["gmod_ds_gprintmax"];
		$this->errCode = true;
	}
	
	function twiceTest($gmod_ds) 	{
		$this->errCode = -3;
		if (isset($gmod_ds) && count($gmod_ds))
			foreach($gmod_ds as $gmod_ds)	{
				if (!strcmp($this->get_alias(), $gmod_ds->get_alias()))
					if ($this->get_id() != $gmod_ds->get_id())
						return false;
				unset($gmod_ds);
			}
		$this->errCode= true;
		return true;
	}
	
	function is_complete()	{
		$this->errCode = -2;
		if (!$this->gmod_ds_alias)
			return false;
		$this->errCode= true;
		return true;
	}
		
	function get_id()	{
		return $this->gmod_ds_id;
	}	
	function get_alias()	{
		return $this->gmod_ds_alias;
	}	
	function get_name()	{
		return $this->gmod_ds_name;
	}	
	function get_col()	{
		return $this->gmod_ds_col;
	}	
	function get_flamming()	{
		return $this->gmod_ds_flamming;
	}	
	function get_area()	{
		return $this->gmod_ds_area;
	}	
	function get_tickness()	{
		return $this->gmod_ds_tickness;
	}	
	function get_gprintlast()	{
		return $this->gmod_ds_gprintlast;
	}	
	function get_gprintmin()	{
		return $this->gmod_ds_gprintmin;
	}	
	function get_gprintaverage()	{
		return $this->gmod_ds_gprintaverage;
	}	
	function get_gprintmax()	{
		return $this->gmod_ds_gprintmax;
	}
	function get_errCode()	{
		return $this->errCode;
	}
	function set_id($id)	{
		$this->gmod_ds_id = $id;
	}
}
?>
