<?
/*
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)
For information : toni@blyx.com
*/

function Create_contactgoup($oreon, $path)	{
	$str = NULL;
	$handle = create_file($path . "contactgroups.cfg", $oreon->user->get_firstname(), $oreon->user->get_lastname());
	if (isset($oreon->contactGroups) && count($oreon->contactGroups))	{
		$i = 0;
		foreach ($oreon->contactGroups as $cg)	{
			$oreon->contactGroups[$cg->get_id()]->generated = false;
			$strTemp = NULL;	
			if ($cg->get_activate()){
				$strTemp .= "# '" . $cg->get_name() . "' Contactgroup definition " . $i . "\n#\n";
				if ($cg->get_comment())
					$strTemp .= "#".str_replace("\n", "\n#", $cg->get_comment())."\n";
				$strTemp .= "define contactgroup{\n";
				$strTemp .= print_line("contactgroup_name", $cg->get_name());
				$strTemp .= print_line("alias", $cg->get_alias());
				$mbrs = NULL;
				$x = 0;		
				foreach ($cg->contacts as $members)	{	
					if ($members->generated) {
						if ($x) $mbrs .= ", ";
						$mbrs .= $members->get_name();
						$x = 1;
					}
					unset($members);
				}
				$strTemp .= print_line("members", $mbrs);
				$strTemp .= "\t}\n\n";
				if (!$mbrs) // If there's no contact activated in contactGroup, we don't generate it.
					$strTemp = NULL;
				else
					$oreon->contactGroups[$cg->get_id()]->generated = true;
				$i++;
				unset($mbrs);
			}
			unset($cg);
			$str .= $strTemp;
		}
	}
	write_in_file($handle, $str, $path . "contactgroups.cfg");
  	fclose($handle);
}
?>