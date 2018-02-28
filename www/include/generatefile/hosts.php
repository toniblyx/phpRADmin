<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/// Create host File 

function Create_host($oreon, $path)	{
	$str = NULL;
	$value_flag = array();
	$value_flag[1] = 1;
    $value_flag[3] = 0;
	$handle = create_file($path . "hosts.cfg", $oreon->user->get_firstname(), $oreon->user->get_lastname());
	if (isset($oreon->hosts) && count($oreon->hosts))	{
  		$i = 0;
		foreach ($oreon->hosts as $h)	{
			$strTemp = NULL;
			$oreon->hosts[$h->get_id()]->generated = false;
			if ($h->get_activate())	{
				$strTemp .= "# '" . $h->get_name() . "' host definition " . $i . "\n#\n";
				if ($h->get_comment()){
					$strTemp .= "#".str_replace("\n", "\n#", preg_replace("/(#BLANK#)/", "0", $h->get_comment()))."\n";
				}
				$strTemp .= "define host{\n";
				if ($h->get_host_template()) $strTemp .= print_line("use", $oreon->hosts[$h->get_host_template()]->get_name());
				if ($h->get_name() && $h->get_register())
					$strTemp .= print_line("host_name", $h->get_name());
				else
					$strTemp .= print_line("name", $h->get_name());
				if ($h->get_alias()) $strTemp .= print_line("alias", $h->get_alias());
				if ($h->get_address()) $strTemp .= print_line("address", $h->get_address());
				$tmp_str = NULL;
				if (isset($h->parents))
					foreach ($h->parents as $p){
						if ($p->get_activate())	{
							$flg = 0;
							foreach ($p->contactgroups as $cg)	{
								if ($cg->generated)
									$flg++;
								unset($cg);
							}
							if ($flg)	{
								if ($tmp_str)	$tmp_str .= ', ';
								$tmp_str .= $p->get_name();
							}	else if ($oreon->user->get_version() == 1)	{
									if ($tmp_str)	$tmp_str .= ', ';
									$tmp_str .= $p->get_name();
							}
						}
						unset($p);	
					}
				if ($tmp_str) $strTemp .= print_line("parents", $tmp_str);
				$tmp_str = NULL;
				foreach ($h->hostGroups as $hg)	{
					if ($hg->get_activate())	{
						if ($tmp_str) 
							$tmp_str .= ", ";
						$tmp_str .= $hg->get_name();
					}
					unset($hg);
				}
				if ($oreon->user->get_version() == 2 && $tmp_str)
					$strTemp .= print_line("hostgroups", $tmp_str);
				unset($tmp_str);	
				if ($h->get_check_command())
					$strTemp .= print_line("check_command", $oreon->commands[$h->get_check_command()]->get_name());
				if ($h->get_max_check_attempts()) $strTemp .= print_line("max_check_attempts", $h->get_max_check_attempts());
				if ($oreon->user->get_version() == 2)	{
					if ($h->get_check_interval()){$strTemp .= print_line("check_interval", preg_replace("/(99999)/", "0", $h->get_check_interval()));}
					if ($h->get_active_checks_enabled() && $h->get_active_checks_enabled() != 2){$strTemp.= print_line("active_checks_enabled", $h->get_active_checks_enabled());}
					if ($h->get_passive_checks_enabled() && $h->get_passive_checks_enabled() != 2){$strTemp .= print_line("passive_checks_enabled", $h->get_passive_checks_enabled());}
					if ($h->get_check_period()){$strTemp .= print_line("check_period", $oreon->time_periods[$h->get_check_period()]->get_name());}
					if ($h->get_obsess_over_host() && $h->get_obsess_over_host() != 2){$strTemp .= print_line("obsess_over_host", $h->get_obsess_over_host());}
					if ($h->get_check_freshness() && $h->get_check_freshness() != 2){$strTemp .= print_line("check_freshness", $h->get_check_freshness());}
					if ($h->get_freshness_threshold()){$strTemp .= print_line("freshness_threshold", preg_replace("/(99999)/", "0", $h->get_freshness_threshold()));}
				}
				if ($oreon->user->get_version() == 1)
					if ($h->get_checks_enabled() && $h->get_checks_enabled() != 2)
						$strTemp .= print_line("checks_enabled", $value_flag[$h->get_checks_enabled()]);
				 if ($h->get_event_handler())
					$strTemp .= print_line("event_handler", $oreon->commands[$h->get_event_handler()]->get_name());	
				if ($h->get_event_handler_enabled() && $h->get_event_handler_enabled() != 2)
					$strTemp .= print_line("event_handler_enabled", $value_flag[$h->get_event_handler_enabled()]);
				if ($h->get_low_flap_threshold())
					$strTemp .= print_line("low_flap_threshold", preg_replace("/(99999)/", "0", $h->get_low_flap_threshold()));
				if ($h->get_high_flap_threshold())
					$strTemp .= print_line("high_flap_threshold", preg_replace("/(99999)/", "0", $h->get_high_flap_threshold()));
				if ($h->get_flap_detection_enabled() && $h->get_flap_detection_enabled() != 2)
					$strTemp .= print_line("flap_detection_enabled", $value_flag[$h->get_flap_detection_enabled()]);
				if ($h->get_process_perf_data() && $h->get_process_perf_data() != 2)
					$strTemp .= print_line("process_perf_data", $value_flag[$h->get_process_perf_data()]);
				if ($h->get_retain_status_information() && $h->get_retain_status_information() != 2)
					$strTemp .= print_line("retain_status_information", $value_flag[$h->get_retain_status_information()]);
				if ($h->get_retain_nonstatus_information() && $h->get_retain_nonstatus_information() != 2)
					$strTemp .= print_line("retain_nonstatus_information", $value_flag[$h->get_retain_nonstatus_information()]);
				$tmp_cg = NULL;
				foreach ($h->contactgroups as $cg)	{
					if ($cg->generated)	{
						if ($tmp_cg) $tmp_cg .= ", ";
						$tmp_cg .= $cg->get_name();						
					}
					unset($cg);
				}
				if ($tmp_cg)
					$strTemp .= print_line("contact_groups", $tmp_cg);
				if ($h->get_notification_interval())
					$strTemp .= print_line("notification_interval", preg_replace("/(99999)/", "0", $h->get_notification_interval()));
				if ($h->get_notification_period())
					$strTemp .= print_line("notification_period", $oreon->time_periods[$h->get_notification_period()]->get_name());
				if ($h->get_notification_options())
					$strTemp .= print_line("notification_options", $h->get_notification_options());
				if ($h->get_notifications_enabled() && $h->get_notifications_enabled() != 2)
					$strTemp .= print_line("notifications_enabled", $value_flag[$h->get_notifications_enabled()]);
				if ($h->get_stalking_options())
					$strTemp .= print_line("stalking_options", $h->get_stalking_options());
				if (!$h->get_register())
					$strTemp .= print_line("register", $h->get_register());
				$strTemp .= "\t}\n\n";
				$oreon->hosts[$h->get_id()]->generated = true;
				$i++;
				unset($tmp_cg);
			}
			unset($h);
			$str .= $strTemp;
		}  
	}
	write_in_file($handle, $str, $path . "hosts.cfg");
  	fclose($handle);
}
?>