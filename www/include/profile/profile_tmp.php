<?
/*
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)
For information : toni@blyx.com
*/
	if (!isset($oreon))
		exit();

	function loadPh_ProfileServer($host_id) // set an array of "Profile host name and address object" for current object oreon	
	{
		$profile_server = $this->database->getPh_ProfileServer($host_id);
		if (isset($profile_server))
			$this->phs[$host_id]->profile_server = new profile_server($profile_server);
	}
	
	function loadPh_NetInterface($host_id) // set an array of "Profile host netinterface object" for current object oreon	
	{
		$net_interfaces = $this->database->getPh_NetInterface($host_id);
		if (isset($net_interfaces))	{
			foreach ($net_interfaces as $net_interface)
				$this->phs[$host_id]->net_interface[$net_interface["INTERFACE_ID"]] = new net_interface($net_interface);
		}
	}
	
	function loadPh_Disk($host_id) // set an array of "Profile host disk object" for current object oreon	
	{
		$disks = $this->database->getPh_Disk($host_id);
		if (isset($disks))	
			foreach ($disks as $disk)
				$this->phs[$host_id]->disk[$disk["DISK_ID"]] = new disk($disk);
	}

	function loadPh_Menu_infos() // set an array of "Profile host disk object" for current object oreon	
	{
		$menus = $this->database->getPh_Menu_infos();
		if (isset($menus))	
			foreach ($menus as $menu)
				$this->phs[$host_id]->menu[$menu["INFOS_NAME"]] = new menu($menu);
	}
		
	function loadPh_Software($host_id) // set an array of "Profile host disk object" for current object oreon	
	{
		$softs = $this->database->getPh_Menu_infos($host_id);
		if (isset($softs))	
			foreach ($softs as $soft)
				$this->phs[$host_id]->software[$soft["software_name"]] = new software($soft);
	}
	
	
	//------------------------------------------------------------------------------------------------
	
	
	function getPh_Software($host_id)
	{
		if ($host_id >= 0)	{
			$this->database->query("SELECT software_id FROM `profile_host_software_relation` WHERE host_id = '$host_id';");
			$ret_sr = array();
			for ($i = 0; ($s = $this->database->fetch_array()); $i++)
				foreach ($s as $key => $value)
					$ret_s[$i][$key] = $value;
			return $ret_s;
		}
	}
		
	function getPh_Disk($host_id)
	{
		if ($host_id >= 0)	{
			$this->database->query("SELECT * FROM profile_disk WHERE disk_host = '$host_id' ORDER BY disk_name ASC;");
			$ret_d = array();
			for ($i = 0; ($d = $this->database->fetch_array()); $i++)
				foreach ($d as $key => $value)
					$ret_d[$i][$key] = $value;
			return $ret_d;
		}
	}
	
	function getPh_ProfileServer($host_id)
	{
		if ($host_id >= 0)	{
			$this->database->query("SELECT * FROM profile_server WHERE SERVER_HOST = '$host_id'");
			$ret_ps = $this->database->fetch_array();
			return $ret_ps;
		}
	}
	

	
	function getPh_NetInterface($host_id)
	{
		if ($host_id >= 0)	{
			$this->database->query("SELECT * FROM profile_interface WHERE interface_host = '$host_id'");
			$ret_ni = array();
			for ($i = 0; ($ni = $this->database->fetch_array()); $i++)
				foreach ($ni as $key => $value)
					$ret_ni[$i][$key] = $value;
			return $ret_ni;
		}
	}
	
	function getPh_Menu_infos()
	{
		$this->database->query("SELECT * FROM profile_infos WHERE infos_status = '1' ORDER BY infos_section");
		$ret_mi = array();
		for ($i = 0; ($mi = $this->database->fetch_array()); $i++)	
			foreach ($mi as $key => $value)	
				$ret_mi[$i][$key] = $value;
		return $ret_mi;
	}
	
   

	
	//--------------------------------------------------------------------------------------------------------------------------------------------------
	
	if (isset($_POST["insert_all_database"]))
	{
		unset ($_POST["insert_all_database"]);
		// clear profile database
		$oreon->database->database->query("DELETE FROM profile_server;");
		$oreon->database->database->query("DELETE FROM profile_interface ;");
		$oreon->database->database->query("DELETE FROM profile_disk;");
		$oreon->database->database->query("DELETE FROM profile_os;");
		$oreon->database->database->query("DELETE FROM profile_software;");
		$oreon->database->database->query("DELETE FROM profile_host_software_relation;");
		?>
			<div align="center">DB clean</div>
			<div align="center">Start discovery ...</div>
		<?
		$oreon->database->database->query("SELECT host_id FROM host;");
		for ($n = 0; $temp_host = $oreon->database->database->fetch_array(); $n++)
		{
			$host_tab[$n] = $temp_host;
		}
		for ($i = 0; $i < $n; $i++)
		{
			$host = $host_tab[$i];
			$srv = $host[0];
			// Get host id in host table 
			$oreon->database->database->query("SELECT host_name, host_address FROM host WHERE host_id = '$srv';");
			$host_infos = $oreon->database->database->fetch_array();
			$host_name = $host_infos["host_name"];
			$host_name = stripslashes($host_name);
			$ip = $host_infos["host_address"];
			$oreon->database->database->query("SELECT * FROM profile_conf WHERE conf_id='1';");
			$conf = $oreon->database->database->fetch_array();
			$snmp_path = $conf["CONF_PATH_SNMP"];
			$snmp_path = stripslashes($snmp_path);
			$community = $conf["CONF_COMMUNITY"];
			$community  = stripslashes($community);
			$oreon->database->database->query("SELECT server_id FROM profile_server WHERE server_host = '$srv';");
			$is_host = $oreon->database->database->fetch_array();
			//location
			$location = exec ("$snmp_path/snmpget -v 1 $ip -O v -c $community  .1.3.6.1.2.1.1.6.0 | cut -d ':' -f 2 ");
			$location= addslashes($location);
			// contact
			$contact = exec ("$snmp_path/snmpget -v 1 $ip -O v -c $community  .1.3.6.1.2.1.1.4.0 | cut -d ':' -f 2 ");
			$contact= addslashes($contact);
			// os
			$os = exec ("$snmp_path/snmpget -v 1 $ip -O v -c $community .1.3.6.1.2.1.1.1.0");
			$os_name = stripslashes($os);				
			if (!preg_match("/Hardware: /i", $os_name))
			{
				$os_tmp = split(":", $os_name);
				$os = split("#", $os_tmp[1]);
				$os_name = $os[0];
			}
			else 
			{
				$os_tmp = explode("Software: ", $os_name);
				$os_name = $os_tmp[1];
			}
			$os_name = addslashes($os_name);
			$oreon->database->database->query("SELECT DISTINCT os_id, os_name FROM profile_os;");
			$new_os = 0;
			for ($a =0 ; $temp = $oreon->database->database->fetch_array(); $a++)
			{
				$os_tab[$a] = $temp[1];
				$id_tab[$a] = $temp[0];
			}
			for ($b = 0; $b < $a; $b++)
			{
				if (!strcmp("$os_name", "$os_tab[$b]"))
				{
					$id_os = $id_tab[$b];
					$new_os = 1;
				}
			}
			if ($new_os == 0)
			{
				$oreon->database->database->query("INSERT INTO `profile_os` (`OS_NAME`) VALUES ('$os_name');");
				$id_os = $oreon->database->database->get_last_id();
			}	
			// uptime
			$uptime = exec ("$snmp_path/snmpget -v 1 $ip -O v -c $community  .1.3.6.1.2.1.1.3.0 | cut -d ')' -f 2 | cut -d '.' -f 1");
			$uptime = addslashes($uptime);
			
			// ram			
			$ram = exec ("$snmp_path/snmpget -v 1 $ip -O v -c $community  .1.3.6.1.2.1.25.2.2.0 | cut -d ' ' -f 2 ");
			
			// save server informations in profile_server
			$oreon->database->database->query("INSERT INTO  profile_server VALUES ('', '$srv', '$location', '$contact', '$ram', '$uptime', '$id_os');");
			
			// network interface
			$nb_interface = exec ("$snmp_path/snmpget -v 1 $ip -O v -c $community .1.3.6.1.2.1.2.1.0 | cut -d ':' -f 2");
			$k = 0;
			exec ("$snmp_path/snmpwalk -v 1 $ip -c $community  .1.3.6.1.2.1.4.20.1.2 | cut -d ' ' -f 4 ", $index);
			exec ("$snmp_path/snmpwalk -v 1 $ip -c $community .1.3.6.1.2.1.4.20.1.2 ", $interfaces);
			while ($k < $nb_interface)
			{
				$modele = exec ("$snmp_path/snmpget -v 1 $ip -O v -c $community  .1.3.6.1.2.1.2.2.1.2.$index[$k] | cut -d ':' -f 2 "); 
				$modele = addslashes($modele);
				$l = 0;
				$j = $k ;
				while ($l < $nb_interface)
				{
					$temp = split(" ", "$interfaces[$l]");
					if (!strcmp("$index[$j]", "$temp[3]"))
					{
						$iphost = split ("\.", "$temp[0]");
						$ip = "$iphost[1].$iphost[2].$iphost[3].$iphost[4]";
						break;
					}

					$l++;
				}
				$speed = exec ("$snmp_path/snmpget -v 1 $ip -O v -c $community  .1.3.6.1.2.1.2.2.1.5.$index[$k] | cut -d ' ' -f 2 ");
				$speed = $speed / 1000000;
				$mac = exec ("$snmp_path/snmpget -v 1 $ip -O v -c $community .1.3.6.1.2.1.2.2.1.6.$index[$k] | cut -d ' ' -f 2");
				$status = exec ("$snmp_path/snmpget -v 1 $ip -O v -c $community .1.3.6.1.2.1.2.2.1.7.$index[$k] | cut -d ':' -f 2");
				//Save new information
				$oreon->database->database->query("INSERT INTO `profile_interface` ( `INTERFACE_HOST` , `INTERFACE_IP` , `INTERFACE_MAC` , `INTERFACE_MODEL` , `INTERFACE_SPEED`) VALUES ('$srv', '$ip', '$mac', '$modele', '$speed');");
				$k++;
			}
			$nb = exec ("$snmp_path/snmpwalk -v 1 $ip -O v -c $community .1.3.6.1.2.1.25.2.3.1.1 | wc -l");
			$j = 1;
			while ($j < $nb)
			{
				$part[$j] = exec("$snmp_path/snmpget -v 1 $ip -O v -c $community .1.3.6.1.2.1.25.2.3.1.3.$j | cut -d ' ' -f 2,3 ");
				$block[$j] = exec("$snmp_path/snmpget -v 1 $ip -O v -c $community  .1.3.6.1.2.1.25.2.3.1.4.$j | cut -d ' ' -f 2");
				$size[$j] = exec("$snmp_path/snmpget -v 1 $ip -O v -c $community  .1.3.6.1.2.1.25.2.3.1.5.$j | cut -d ' ' -f 2");
				$space_used[$j] = exec("$snmp_path/snmpget -v 1 $ip -O v -c $community  .1.3.6.1.2.1.25.2.3.1.6.$j | cut -d ' ' -f 2");
				$size[$j] = round ($size[$j] * $block[$j] / 1000000000, 2);
				$space_used[$j] = round ($space_used[$j] * $block[$j] / 1000000000, 2);
				$partition = $part[$j];
				// save new information about disk in DB
				$space_free = $size[$j] - $space_used[$j];
				$len = strlen ($partition) - 1;
				if ($partition[$len] == '\\')
				{
					$oreon->database->database->query("INSERT INTO `profile_disk` ( `DISK_HOST` , `DISK_NAME` , `DISK_SPACE` , `DISK_USED_SPACE` , `DISK_FREE_SPACE` ) VALUES ('$srv', '$partition\', '$size[$j]', '$space_used[$j]', '$space_free');");
				}
				else
				{
					$oreon->database->database->query("INSERT INTO `profile_disk` ( `DISK_HOST` , `DISK_NAME` , `DISK_SPACE` , `DISK_USED_SPACE` , `DISK_FREE_SPACE` ) VALUES ('$srv', '$partition', '$size[$j]', '$space_used[$j]', '$space_free');");
				}
				$j++;
			}			
			// get software informations
			$oreon->database->database->query("SELECT software_id, software_name FROM profile_software WHERE software_type = '1';");
			$new_os = 0;
			for ($a = 0 ; $temp = $oreon->database->database->fetch_array(); $a++)
			{
				$software_tab[$a] = stripslashes($temp[1]);
				$id_tab[$a] = $temp[0];
			}
			$soft = 0;
			exec("$snmp_path/snmpwalk -v 1 $ip -O v -c $community  .1.3.6.1.2.1.25.6.3.1.2 | grep '\"' | cut -d ':' -f 2 ", $soft);
			$s = 0;
			if (isset($soft))
			{
				while ($soft[$s])
				{
					if ((strcmp($soft[$s], "")) && (!stristr($soft[$s], "Windows ")) && (!stristr($soft[$s], " - KB")))
					{
						$soft_tab = split ("\"", $soft[$s]); 
						$soft_name = $soft_tab[1];
						//save information in DB
						$new_software = 0;
						for ($b = 0; $b < $a; $b++)
						{
							if (!strcmp("$soft_name", "$software_tab[$b]"))
							{
								$oreon->database->database->query("INSERT INTO `profile_host_software_relation` (`HOST_ID` , `SOFTWARE_ID` ) VALUES ('$srv', '$id_tab[$b]');");
								$new_software = 1;
							}
						}
						if ($new_software == 0)
						{
							$soft_name = addslashes ($soft_name);
							$oreon->database->database->query("INSERT INTO `profile_software` (`SOFTWARE_TYPE` , `SOFTWARE_NAME` ) VALUES ('1', '$soft_name');");
							$last_id = $oreon->database->database->get_last_id();
							$oreon->database->database->query("INSERT INTO `profile_host_software_relation` (`HOST_ID` , `SOFTWARE_ID` ) VALUES ('$srv', '$last_id');");
						}

					}
					$s++;
				}
			}
			// get update informations
			$oreon->database->database->query("SELECT software_id, software_name FROM profile_software WHERE software_type = '2';");
			$new_os = 0;
			for ($a =0 ; $temp = $oreon->database->database->fetch_array(); $a++)
			{
				$software_tab[$a] = stripslashes($temp[1]);
				$id_tab[$a] = $temp[0];
			}
			$soft = 0;
			exec("$snmp_path/snmpwalk -v 1 $ip -O v -c $community  .1.3.6.1.2.1.25.6.3.1.2 | grep '\"' | cut -d ':' -f 2 ", $soft);
			$s = 0;
			if (isset($soft))
			{
				while ($soft[$s])
				{
					if ((strcmp($soft[$s], "")) && (stristr($soft[$s], "Windows ")) && (stristr($soft[$s], " - KB")))
					{
						$soft_tab = split ("\"", $soft[$s]); 
						$soft_name = $soft_tab[1];
						$new_software = 0;
						for ($b = 0; $b < $a; $b++)
						{
							if (!strcmp("$soft_name", "$software_tab[$b]"))
							{
								$oreon->database->database->query("INSERT INTO `profile_host_software_relation` (`HOST_ID` , `SOFTWARE_ID` ) VALUES ('$srv', '$id_tab[$b]');");
								$new_software = 1;
							}
						}
						if ($new_software == 0)
						{
							$soft_name = addslashes ($soft_name);
							$oreon->database->database->query("INSERT INTO `profile_software` (`SOFTWARE_TYPE` , `SOFTWARE_NAME` ) VALUES ('2', '$soft_name');");
							$last_id = $oreon->database->database->get_last_id();
							$oreon->database->database->query("INSERT INTO `profile_host_software_relation` (`HOST_ID` , `SOFTWARE_ID` ) VALUES ('$srv', '$last_id');");
						}
					}
					$s++;
				}
			}
		}
		print $lang['profile_o_conf_snmp_ok'] . "<br>";
	}
	
?>	