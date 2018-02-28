<?
/*
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)
For information : toni@blyx.com
*/

function Create_dependencies( $oreon, $path)	{
	$str = NULL;
  	$handle = create_file($path . "dependencies.cfg", $oreon->user->get_firstname(), $oreon->user->get_lastname());
	$i = 0;
	if (isset($oreon->hds) && count($oreon->hds))
		foreach ($oreon->hds as $hd)	{
			if ($oreon->hosts[$hd->get_host_dependent()]->generated && $oreon->hosts[$hd->get_host()]->generated)	{
				$str .= "# '" . $oreon->hosts[$hd->get_host_dependent()]->get_name() . "' hostdependency definition " . $i . "\n";
				$str .= "define hostdependency{\n";
				if ($hd->get_host_dependent())
					$str .= print_line("dependent_host_name", $oreon->hosts[$hd->get_host_dependent()]->get_name());
				if ($hd->get_host())
					$str .= print_line("host_name", $oreon->hosts[$hd->get_host()]->get_name());
				if ($oreon->user->get_version() == 2 && $hd->get_inherits_parent() != 2)
					$str .= print_line("inherits_parent", $hd->get_inherits_parent());
				if ($oreon->user->get_version() == 2 && $hd->get_execution_failure_criteria())
					$str .= print_line("execution_failure_criteria", $hd->get_execution_failure_criteria());
				if ($hd->get_notification_failure_criteria())
					$str .= print_line("notification_failure_criteria", $hd->get_notification_failure_criteria());
				$str .= "\t}\n\n";
			}
			unset($hd);
			$i++;
		}
	if (isset($oreon->sds) && count($oreon->sds))
		foreach ($oreon->sds as $sd)	{
			if ($oreon->hosts[$sd->get_host_dependent()]->generated && $oreon->hosts[$sd->get_host()]->generated)	{
				$str .= "# '" . $oreon->hosts[$sd->get_host_dependent()]->get_name() . "' / '".$oreon->services[$sd->get_service_dependent()]->get_description() ."' servicedependency definition " . $i . "\n";
				$str .= "define servicedependency{\n";
				if ($sd->get_host())
					$str .= print_line("host_name", $oreon->hosts[$sd->get_host()]->get_name());
				if ($sd->get_service())
					$str .= print_line("service_description", $oreon->services[$sd->get_service()]->get_description());
				if ($sd->get_host_dependent())
					$str .= print_line("dependent_host_name", $oreon->hosts[$sd->get_host_dependent()]->get_name());
				if ($sd->get_service_dependent())
					$str .= print_line("dependent_service_description", $oreon->services[$sd->get_service_dependent()]->get_description());
				if ($oreon->user->get_version() == 2 && $sd->get_inherits_parent() != 2)
					$str .= print_line("inherits_parent", $sd->get_inherits_parent());
				if ($sd->get_execution_failure_criteria())
					$str .= print_line("execution_failure_criteria", $sd->get_execution_failure_criteria());
				if ($sd->get_notification_failure_criteria())
					$str .= print_line("notification_failure_criteria", $sd->get_notification_failure_criteria());
				$str .= "\t}\n\n";
			}
			unset($sd);
			$i++;
		}
	write_in_file($handle, $str, $path . "dependencies.cfg");
  	fclose($handle);
}

?>