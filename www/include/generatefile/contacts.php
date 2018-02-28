<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/function Create_contact($oreon, $path)	{
	$str = NULL;
	$handle = create_file($path . "contacts.cfg", $oreon->user->get_firstname(), $oreon->user->get_lastname());
	if (isset($oreon->contacts) && count($oreon->contacts))	{
		$contacts = & $oreon->contacts;
 		$i = 0;
		foreach ($contacts as $ctt)	{
			$oreon->contacts[$ctt->get_id()]->generated = false;
			$strTemp = NULL;
			if ($ctt->get_activate()){
				$strTemp .= "# '" . $ctt->get_name() . "' contact definition " . $i . "\n#\n";
				if ($ctt->get_comment())
					$strTemp .= "#".str_replace("\n", "\n#", $ctt->get_comment())."\n";
				$strTemp .= "define contact{\n";
				if ($ctt->get_name())
					$strTemp .= print_line("contact_name", $ctt->get_name());
				if ($ctt->get_alias())
					$strTemp .= print_line("alias", $ctt->get_alias());
				$tmp_cg = NULL;
				if ($oreon->user->get_version() == 2 && count($ctt->contact_groups)){
					foreach ($ctt->contact_groups as $cg)	{
						if ($cg->get_activate())	{
							$flg = 0;
							foreach ($cg->contacts as $cct2)	{
								if ($cct2->get_activate())
									$flg++;
								unset($cct2);
							}
							if ($flg)	{
								if ($x) $tmp_cg .= ", ";
								$tmp_cg .= $cg->get_name();
							}
						}
						unset($cg);
					}
					$strTemp .= print_line("contactgroups", $tmp_cg);
				}
				if ($oreon->time_periods[$ctt->get_host_notification_period()]->get_name())
					$strTemp .= print_line("host_notification_period", $oreon->time_periods[$ctt->get_host_notification_period()]->get_name());
				if ($ctt->get_host_notification_options())
					$strTemp .= print_line("host_notification_options", $ctt->get_host_notification_options());
				if (count($ctt->host_notification_commands)){
					$tmp_str = NULL;
					$x = 0;
					foreach ($ctt->host_notification_commands as $hnc){
						if ($x)
							$tmp_str .= ", ";
						$tmp_str .= $hnc->get_name();
						$x++;
						unset($hnc);
					}
					$strTemp .= print_line("host_notification_commands", $tmp_str);
					unset($tmp_str);
				}
				if ($ctt->get_service_notification_period())
					$strTemp .= print_line("service_notification_period", $oreon->time_periods[$ctt->get_service_notification_period()]->get_name());
				if ($ctt->get_service_notification_options())
					$strTemp .= print_line("service_notification_options", $ctt->get_service_notification_options());
				if (count($ctt->service_notification_commands)){
					$tmp_str = NULL;
					$x = 0;
					foreach ($ctt->service_notification_commands as $snc){
						if ($x)
							$tmp_str .= ", ";
						$tmp_str .= $snc->get_name();
						$x++;
						unset($snc);
					}
					$strTemp .= print_line("service_notification_commands", $tmp_str);
					unset($tmp_str);
				}
				if ($ctt->get_email())
					$strTemp .= print_line("email", $ctt->get_email());
				if ($ctt->get_pager())
					$strTemp .= print_line("pager", $ctt->get_pager());
				$strTemp .= "}\n\n";
				$i++;
				if (!$tmp_cg && $oreon->user->get_version() == 2)
					$strTemp = NULL;
				else
					$oreon->contacts[$ctt->get_id()]->generated = true;
				unset($tmp_cg);
			}
			unset($ctt);
			$str .= $strTemp;
		}
	}
	write_in_file($handle, $str, $path . "contacts.cfg");
	fclose($handle);
}
?>