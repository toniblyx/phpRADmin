<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*//**
Nagios V1 & V2

	timeperiod_name timeperiod_name 
	alias 			alias 
	sunday 			timeranges : optionnal
	monday 			timeranges : optionnal
	tuesday 		timeranges : optionnal
	wednesday 		timeranges : optionnal
	thursday 		timeranges : optionnal
	friday 			timeranges : optionnal
	saturday 		timeranges : optionnal

*/
class TimePeriod
{

	// Attributes
	
	var $id;
	
	var $name;
	
	var $alias;
	
	var $sunday;
	
	var $monday;
	
	var $tuesday;
	
	var $wednesday;
	
	var $thursday;
	
	var $friday;
	
	var $saturday;

  	var $errCode;
	
	// Associations
	
	// Operations
	
	function TimePeriod($time_period)	{
		$this->id = $time_period["tp_id"];
		$this->name = str_replace($_SESSION["oreon"]->Nagioscfg->get_illegal_object_name_chars_array(), "", $time_period["tp_name"]);
		$this->alias = $time_period["tp_alias"];
		$this->sunday = $time_period["tp_sunday"];
		$this->monday = $time_period["tp_monday"];
		$this->tuesday = $time_period["tp_tuesday"];
		$this->wednesday = $time_period["tp_wednesday"];
		$this->thursday = $time_period["tp_thursday"];
		$this->friday = $time_period["tp_friday"];
		$this->saturday = $time_period["tp_saturday"];
		$this->errCode = true;
	}
	
	function is_complete($version)	{
		$this->errCode = -2;
		if (!$this->name)
			return false;
		if (!$this->alias)
			return false;
		$this->errCode = true;			
		return true;
	}

	function twiceTest($timePeriods) 	{
		$this->errCode = -3;
		if (isset($timePeriods) && count($timePeriods))
			foreach($timePeriods as $timePeriod)
				if (!strcmp($this->get_name(), $timePeriod->get_name()))
						if ($this->get_id() != $timePeriod->get_id())
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
	
	function get_sunday()	{
		return stripslashes($this->sunday);
	}
	
	function get_monday()	{
		return stripslashes($this->monday);
	}
	
	function get_tuesday()	{
		return stripslashes($this->tuesday);
	}
	
	function get_wednesday()	{
		return stripslashes($this->wednesday);
	}
	
	function get_thursday()	{
		return stripslashes($this->thursday);
	}
	
	function get_friday()	{
		return stripslashes($this->friday);
	}
	
	function get_saturday()	{
		return stripslashes($this->saturday);
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
	
	function set_sunday($sunday)	{
		$this->sunday = $sunday;
	}
	
	function set_monday($monday)	{
		$this->monday = $monday;
	}
	
	function set_tuesday($tuesday)	{
		$this->tuesday = $tuesday;
	}
	
	function set_wednesday($wednesday)	{
		$this->wednesday = $wednesday;
	}
	
	function set_thursday($thursday)	{
		$this->thursday = $thursday;
	}
	
	function set_friday($friday)	{
		$this->friday = $friday;
	}
	
	function set_saturday($saturday)	{
		$this->saturday = $saturday;
	}
	
} /* end class TimePeriod */
?>
