<?
/*
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)
For information : toni@blyx.com
*/

/* Nagios V2

	host_name 		host_name 
	notes 			note_string : optionnal
	notes_url 		url : optionnal
	action_url 		url : optionnal
	icon_image 		image_file : optionnal
	icon_image_alt 	alt_string : optionnal
	vrml_image 		image_file : optionnal
	statusmap_image image_file : optionnal
	2d_coords 		x_coord,y_coord : optionnal
	3d_coords 		x_coord,y_coord,z_coord : optionnal
*/

class ExtendedHostInformation
{

	// Attributes
	
	var $id;
	
	var $host;
	
	var $notes;
	
	var $notes_url;
	
	var $action_url;
	
	var $icon_image;
	
	var $icon_image_alt;
	
	var $vrml_image;
	
	var $statusmap_image;
	
	var $d2_coords;
	
	var $d3_coords;
	
	var $errCode;
	
	// Associations
	
	// Operations
	
	function ExtendedHostInformation($ehi)
	{
		$this->id = $ehi["ehi_id"];
		$this->host = $ehi["host_host_id"];
		$this->errCode = true;
	}
	
	function is_complete($version)	{
		$this->errCode = -2;
		if (!$this->host)
			return false;
		$this->errCode = true;		
		return true;
	}

	function twiceTest($ehis) 	{
		$this->errCode = -3;
		if (isset($ehis) && count($ehis))
			foreach($ehis as $ehi)
				if ($this->get_host() == $ehi->get_host())
					if ($this->get_id() != $ehi->get_id())
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
	
	function get_vrml_image()	{
		return stripslashes($this->vrml_image);
	}
	
	function get_statusmap_image()	{
		return stripslashes($this->statusmap_image);
	}
	
	function get_d2_coords()	{
		return stripslashes($this->d2_coords);
	}
	
	function get_d3_coords()	{
		return stripslashes($this->d3_coords);
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
	
	function set_vrml_image($vrml_image)	{
		$this->vrml_image = $vrml_image;
	}
	
	function set_statusmap_image($statusmap_image)	{
		$this->statusmap_image = $statusmap_image;
	}
	
	function set_d2_coords($d2_coords)	{
		$this->d2_coords = $d2_coords;
	}
	
	function set_d3_coords($d3_coords)	{
		$this->d3_coords = $d3_coords;
	}	
} /* end class ExtendedHostInformation */
?>
