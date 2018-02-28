<?
/*
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)
For information : toni@blyx.com
*/
	
	/* Nagios V2
	
	host_name 				host_name 
	service_description 	service_description 
	notes 					note_string : optionnal
	notes_url 				url : optionnal
	action_url 				url : optionnal
	icon_image 				image_file : optionnal
	icon_image_alt 			alt_string : optionnal
	*/
	
class ExtendedServiceInformation
{
	
	// Attributes
	
	var $id;
	
	var $host;
	
	var $service;
	
	var $notes;
	
	var $notes_url;
	
	var $action_url;
	
	var $icon_image;
	
	var $icon_image_alt;
	
	var $errCode;
	
	// Associations
	
	// Operations
	
	function ExtendedServiceInformation($esi)
	{
		$this->id = $esi["esi_id"];
		$this->service = $esi["service_service_id"];
		$this->host = $esi["host_host_id"];
		$this->errCode = true;
	}
	
	function is_complete($version)	{
		$this->errCode = -2;
		if (!$this->service)
			return false;
		if (!$this->host)
			return false;
		$this->errCode = true;		
		return true;
	}

	function twiceTest($esis) 	{
		$this->errCode = -3;
		if (isset($esis) && count($esis))
			foreach($esis as $esi)
				if ($this->get_host() == $esi->get_host())
					if ($this->get_service() == $esi->get_service())
						if ($this->get_id() != $esi->get_id())
							return false;
		$this->errCode = true;
		return true;
	}
		
	function get_id()	{
		return $this->id;
	}
	
	function get_host()	{
		return $this->host;
	}
	
	function get_service()	{
		return $this->service;
	}
	
	function get_notes()	{
		return stripslashes($this->notes);
	}
	
	function get_notes_url()	{
		return stripslashes($this->notes_url);
	}
	
	function get_action_url()	{
		return stripslashes($this->action_url);
	}
	
	function get_icon_image()	{
		return stripslashes($this->icon_image);
	}
	
	function get_icon_image_alt()	{
		return stripslashes($this->icon_image_alt);
	}
			
	function get_errCode()	{
		return $this->errCode;
	}
	
	function set_id($id)	{
		$this->id = $id;
	}
	
	function set_host($host)	{
		$this->host = $host;
	}
	
	function set_service($service)	{
		$this->service = $service;
	}
	
	function set_notes($notes)	{
		$this->notes = str_replace($_SESSION["oreon"]->Nagioscfg->get_illegal_object_name_chars_array(), "", $notes);
		$this->notes = str_replace(" ", "_", $this->notes);
	}
	
	function set_notes_url($notes_url)	{
		$this->notes_url = $notes_url;
	}
	
	function set_action_url($action_url)	{
		$this->action_url = $action_url;
	}
	
	function set_icon_image($icon_image)	{
		$this->icon_image = $icon_image;
	}
	
	function set_icon_image_alt($icon_image_alt)	{
		$this->icon_image_alt = str_replace($_SESSION["oreon"]->Nagioscfg->get_illegal_object_name_chars_array(), "", $icon_image_alt);
		$this->icon_image_alt = str_replace(" ", "_", $this->icon_image_alt);
	}
	
} /* end class ExtendedServiceInformation */
?>
