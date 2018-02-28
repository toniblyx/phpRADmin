<?
/*
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)
For information : toni@blyx.com
*/

function Create_hostgroup($oreon, $path)
{
	$str = NULL;
	$handle = create_file($path . "hostgroups.cfg", $oreon->user->get_firstname(), $oreon->user->get_lastname());
	if (isset($oreon->hostGroups) && count($oreon->hostGroups))	{
		$i = 0;
		foreach ($oreon->hostGroups as $hg)	{
			$strTemp = NULL;
			$oreon->hostGroups[$hg->get_id()]->generated = false;
			if ($hg->get_activate())	{
				$strTemp .= "# '" . $hg->get_name() . "' hostgroup definition " . $i . "\n#\n";
				if ($hg->get_comment())
					$strTemp .= "#".str_replace("\n", "\n#", $hg->get_comment())."\n";
				$strTemp .= "define hostgroup{\n";
				if ($hg->get_name())
					$strTemp .= print_line("hostgroup_name", $hg->get_name());
				if ($hg->get_alias())
					$strTemp .= print_line("alias", $hg->get_alias());
				$tmp_cg = NULL;
				if (count($hg->contact_groups))	{
					foreach ($hg->contact_groups as $cg)	{
						if ($cg->generated)	{
							if ($tmp_cg) $tmp_cg .= ", ";
							$tmp_cg .= $cg->get_name();
						}
						unset($cg);
					}
					if ($tmp_cg)
						$strTemp .= print_line("contact_groups", $tmp_cg);
				}
				if (count($hg->hosts))	{
					$tmp_h = NULL;
					foreach ($hg->hosts as $host)	{
						if ($host->get_register() && $host->generated)	{
							if ($tmp_h) $tmp_h .= ", ";
							$tmp_h .= $host->get_name();
						}
						unset($host);
					}
					if ($tmp_h)
						$strTemp .= print_line("members", $tmp_h);
				}
				$strTemp .= "\t}\n\n";
				if (!$tmp_cg || !$tmp_h)
					$strTemp = NULL;
				else
					$oreon->hostGroups[$hg->get_id()]->generated = true;
				unset($tmp_cg);
				unset($tmp_h);
			}
			unset($hg);
			$str .= $strTemp;			
		}
	}
	write_in_file($handle, $str, $path . "hostgroups.cfg");
  	fclose($handle);
}

?>