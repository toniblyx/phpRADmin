<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/function Create_escalations($oreon, $path)
{
	$str = NULL;
	$handle = create_file($path . "escalations.cfg", $oreon->user->get_firstname(), $oreon->user->get_lastname());
	if (isset($oreon->hes) && count($oreon->hes))	{
		$hes = & $oreon->hes;
		if (isset($hes))
			foreach ($hes as $he)	{
				$strTemp = NULL;
				if ($oreon->hosts[$he->get_host()]->get_activate())	{
					$strTemp .= "define hostescalation{\n";
					if ($he->get_host())
						$strTemp .= print_line("host_name", $oreon->hosts[$he->get_host()]->get_name());
					$tmp_hg = NULL;
					if (count($he->hostGroups)){
						foreach ($he->hostGroups as $hg)	{
							if ($hg->generated)	{
								if ($tmp_hg) $tmp_hg .= ", ";
								$tmp_hg .= $hg->get_name();
							}
							unset($hg);
						}
						$strTemp .= print_line("hostgroup_name", $tmp_hg);
						unset($tmp_hg);
					}
					$tmp_cg = NULL;
					if (count($he->contactGroups)){
						foreach ($he->contactGroups as $cg)	{
							if ($cg->generated)	{
								if ($tmp_cg) $tmp_cg .= ", ";
								$tmp_cg .= $cg->get_name();
							}
							unset($cg);
						}
						$strTemp .= print_line("contact_groups", $tmp_cg);
					}
					if ($he->get_first_notification())
						$strTemp .= print_line("first_notification", $he->get_first_notification());
					if ($he->get_last_notification())
						$strTemp .= print_line("last_notification", preg_replace("/(99999)/", "0", $he->get_last_notification()));
					if ($he->get_notification_interval())
						$strTemp .= print_line("notification_interval", preg_replace("/(99999)/", "0", $he->get_notification_interval()));
					if ($he->get_escalation_period())
						$strTemp .= print_line("escalation_period", $oreon->time_periods[$he->get_escalation_period()]->get_name());
					if ($he->get_escalation_options())
						$strTemp .= print_line("escalation_options", $he->get_escalation_options());
					$strTemp .= "\t}\n\n";
					if (!$tmp_cg)
						$strTemp = NULL;
					unset($tmp_cg);
				}
				unset($he);
				$str .= $strTemp;
			}
	}
	if (isset($oreon->ses) && count($oreon->ses))	{
		$ses = & $oreon->ses;
		if (isset($ses))
			foreach ($ses as $se)	{
				$strTemp = NULL;
				if ($oreon->hosts[$se->get_host()]->get_activate())	{
					$strTemp .= "define serviceescalation{\n";
					if (strcmp($se->get_host(), ""))
						$strTemp .= print_line("host_name", $oreon->hosts[$se->get_host()]->get_name());
					if (strcmp($se->get_host(), ""))
						$strTemp .= print_line("service_description", $oreon->services[$se->get_service()]->get_description());
					$tmp_cg = NULL;
					if (count($se->contactGroups)){
						foreach ($se->contactGroups as $cg)	{
							if ($cg->generated)	{
								if ($tmp_cg) $tmp_cg .= ", ";
								$tmp_cg .= $cg->get_name();
							}
							unset($cg);
						}
						$strTemp .= print_line("contact_groups", $tmp_cg);					}
					if ($se->get_first_notification())
						$strTemp .= print_line("first_notification", $se->get_first_notification());
					if ($se->get_last_notification())
						$strTemp .= print_line("last_notification", preg_replace("/(99999)/", "0", $se->get_last_notification()));
					if ($se->get_notification_interval())
						$strTemp .= print_line("notification_interval", preg_replace("/(99999)/", "0", $se->get_notification_interval()));			
					if ($se->get_escalation_period())
						$strTemp .= print_line("escalation_period", $oreon->time_periods[$se->get_escalation_period()]->get_name());
					if ($se->get_escalation_options())
						$strTemp .= print_line("escalation_options", $se->get_escalation_options());
					$strTemp .= "\t}\n\n";
					if (!$tmp_cg)
						$strTemp = NULL;
					unset($tmp_cg);
				}
				unset($se); 
				$str .= $strTemp;
			}	 
	}
	if ($oreon->user->get_version() == 1 && isset($oreon->hges) && count($oreon->hges))	{
		$hges = & $oreon->hges;
		if (isset($hges))
			foreach ($hges as $hge)	{
				$strTemp = NULL;
				if ($oreon->hostGroups[$hge->get_hostgroup()]->get_activate())	{
					$nb_h = 0;
					foreach ($oreon->hostGroups[$hge->get_hostgroup()]->hosts as $host)	{
						if ($host->get_register() && $host->get_activate())
							$nb_h++;
						unset($host);
					}
					if ($nb_h){
						$strTemp = NULL;
						$strTemp .= "define hostgroupescalation{\n";
						if ($hge->get_hostgroup())
							$strTemp .= print_line("hostgroup_name", $oreon->hostGroups[$hge->get_hostgroup()]->get_name());
						if (count($hge->contactGroups)){
							$tmp_cg = NULL;
							foreach ($hge->contactGroups as $cg)	{
								if ($cg->generated)	{
									if ($tmp_cg) $tmp_cg .= ", ";
									$tmp_cg .= $cg->get_name();
								}
								unset($cg);
							}
							$strTemp .= print_line("contact_groups", $tmp_cg);
						}
						if ($hge->get_first_notification())
							$strTemp .= print_line("first_notification", $hge->get_first_notification());
						if ($hge->get_last_notification())
							$strTemp .= print_line("last_notification", preg_replace("/(99999)/", "0", $hge->get_last_notification()));
						if ($hge->get_notification_interval())
							$strTemp .= print_line("notification_interval", preg_replace("/(99999)/", "0", $hge->get_notification_interval()));
						$strTemp .= "\t}\n\n";
						if (!$tmp_cg)
							$strTemp = NULL;
						unset($tmp_cg);
					}
				}
				unset($hge);
				$str .= $strTemp;
			}	 
	}
	write_in_file($handle, $str, "escalations.cfg");
	fclose($handle);
}
?>