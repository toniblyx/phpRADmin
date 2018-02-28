<?
/*
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)
For information : toni@blyx.com
*/

function Create_extended_info($oreon, $path){
	$str = NULL;
	$handle = create_file($path . "hostextinfo.cfg", $oreon->user->get_firstname(), $oreon->user->get_lastname()); 
	if (isset($oreon->ehis) && count($oreon->ehis))	{
		$ehis = & $oreon->ehis;
		foreach ($ehis as $ei)	{
			if ($oreon->hosts[$ei->get_host()]->generated)	{
				$str .= "define hostextinfo{\n";
				if ($ei->get_host()){$str .= print_line("host_name", $oreon->hosts[$ei->get_host()]->get_name());}
				if ($ei->get_notes()){$str .= print_line("notes", $ei->get_notes());}
				if ($ei->get_notes_url()){$str .= print_line("notes_url", $ei->get_notes_url());}
				if ($ei->get_action_url()){$str .= print_line("action_url", $ei->get_action_url());}
				if ($ei->get_icon_image()){$str .= print_line("icon_image", $ei->get_icon_image());}
				if ($ei->get_icon_image_alt()){$str .= print_line("icon_image_alt", $ei->get_icon_image_alt());}
				if ($ei->get_vrml_image()){$str .= print_line("vrml_image", $ei->get_vrml_image());}
				if ($ei->get_statusmap_image()){$str .= print_line("statusmap_image", $ei->get_statusmap_image());}
				if ($ei->get_d2_coords()){$str .= print_line("2d_coords", $ei->get_d2_coords());}
				if ($ei->get_d3_coords()){$str .= print_line("3d_coords", $ei->get_d3_coords());}
				$str .= "\t}\n\n";
			}
			unset($ei); 
		}
	}
	write_in_file($handle, $str, $path . "hostextinfo.cfg");
	$str = NULL;
	$handle = create_file($path . "serviceextinfo.cfg", $oreon->user->get_firstname(), $oreon->user->get_lastname()); 
	if (isset($oreon->esis) && count($oreon->esis))	{
		$esis = & $oreon->esis;	 
		foreach ($esis as $ei)	{
			if ($oreon->hosts[$ei->get_host()]->generated)	{
				$str .= "define serviceextinfo{\n";
				if ($ei->get_host()){$str .= print_line("host_name", $oreon->hosts[$ei->get_host()]->get_name());}
				if ($ei->get_service()){$str .= print_line("service_description", $oreon->services[$ei->get_service()]->get_description());}
				if ($ei->get_notes()){$str .= print_line("notes", $ei->get_notes());}
				if ($ei->get_notes_url()){$str .= print_line("notes_url", $ei->get_notes_url());}
				if ($ei->get_action_url()){$str .= print_line("action_url", $ei->get_action_url());}
				if ($ei->get_icon_image()){$str .= print_line("icon_image", $ei->get_icon_image());}
				if ($ei->get_icon_image_alt()){$str .= print_line("icon_image_alt", $ei->get_icon_image_alt());}
				$str .= "\t}\n\n"; 
			}
			unset($ei);
		}	 
	}
	write_in_file($handle, $str, $path . "serviceextinfo.cfg");
	fclose($handle);
}
?>