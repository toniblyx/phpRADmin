<?
/*
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)
For information : toni@blyx.com
*/
	if (!$oreon)
		exit();
	
	$oreon->load_user_status();
	
	$code_page["1"] = $lang['m_home'];
	$code_page["1001"] = $lang['m_users'] . " > " . $lang['da_adduser'];
	$code_page["1002"] = $lang['m_users'] . " > " . $lang['da_findedit'];
	$code_page["1003"] = $lang['m_users'] . " > " . $lang['da_failedlogins'];
	$code_page["1004"] = $lang['m_users'] . " > " . $lang['da_badusers'];
	$code_page["1005"] = $lang['m_users'] . " > " . $lang['pra_certs'];
	$code_page["1101"] = $lang['m_users'] . " > " . $lang['da_addgroup'];
	$code_page["1102"] = $lang['m_users'] . " > " . $lang['da_editgroup'];
	$code_page["2001"] = $lang['m_clients_devices'] . " > List" ;
	$code_page["2002"] = $lang['m_clients_devices'] . " > " . $lang['add'];
	$code_page["2003"] = $lang['m_clients_devices'] . " > Edit" ;
	$code_page["3001"] = $lang['m_bbreport'] . " > Online users" ;
	$code_page["3002"] = $lang['m_bbreport'] . " > Accounting" ;
	$code_page["3003"] = $lang['m_bbreport'] . " > Global Stats" ;
	$code_page["3004"] = $lang['m_bbreport'] . " > User Stats" ;
	$code_page["3100"] = $lang['m_bbreport'] . " > User graphs" ;
	$code_page["3101"] = $lang['m_bbreport'] . " > Client graphs" ;
	$code_page["3102"] = $lang['m_bbreport'] . " > DB graphs" ;
	$code_page["3200"] = $lang['m_bbreport'] . " > RADIUS logs" ;
	$code_page["3201"] = $lang['m_bbreport'] . " > System logs" ;
	$code_page["4001"] = $lang['m_options'] . " > " . $lang['m_general'];
	$code_page["4002"] = $lang['m_options'] . " > " . $lang['m_lang'];
	$code_page["4003"] = $lang['m_options'] . " > " . $lang['radiusd.conf'];
	$code_page["4004"] = $lang['m_options'] . " > Dialup_admin" ;
	$code_page["4005"] = $lang['m_options'] . " > Dictionary" ;
	$code_page["4006"] = $lang['m_options'] . " > " . $lang['m_apply'];
	$code_page["4100"] = $lang['m_options'] . " > " . $lang['m_is_connected'];
	$code_page["4101"] = $lang['m_options'] . " > " . $lang['m_profile'];
	$code_page["4102"] = $lang['m_options'] . " > " . $lang['m_users_profile'];
	$code_page["4200"] = $lang['m_options'] . " > " . $lang["m_histo"];
	$code_page["4201"] = $lang['m_options'] . " > " . $lang["m_backup_db"];
	$code_page["4202"] = $lang['m_options'] . " > " . $lang["m_server_status"];
	$code_page["4203"] = $lang['m_options'] . " > " . $lang["m_updates"];
	$code_page["4204"] = $lang['m_options'] . " > " . $lang["m_about"];
	$code_page["5001"] = $lang['m_billing'] . " > " . $lang['m_general'];

?>
	<table style="border-width: thin; border-style: dashed; border-color=#9C9C9C;" cellpadding="2" cellspacing="1">
		<tr bgColor="#eaecef">
			<td width="150" class="text12b"><? print $lang["wi_user"]; ?></td>
			<td align="left" class="text12b"><? print $lang["wi_where"]; ?></td>
			<td align="right" class="text12b"><? print $lang["wi_last_req"]; ?></td>
		</tr>
		<?
		foreach ($oreon->user_online as $uo){
			print "<tr><td><a href='./phpradmin.php?p=4102&usr=".$uo->get_user_id()."&o=w' class=text11>" . $oreon->users[$uo->get_user_id()]->get_firstname() . " " . $oreon->users[$uo->get_user_id()]->get_lastname() ."</a></td><td align='left'>";
			if (!isset($code_page[$uo->get_current_page()]) || !$code_page[$uo->get_current_page()])
				print "<a href='phpradmin.php?p=".$uo->get_current_page()."' class='text11'>".$uo->get_current_page()."</a></td><td align='right'>".date("H:i:s", $uo->get_last_reload())."</td></tr>";
			else
				print "<a href='phpradmin.php?p=".$uo->get_current_page()."' class='text11'>".$code_page[$uo->get_current_page()]."</a></td><td align='right'>".date("H:i:s", $uo->get_last_reload())."</td></tr>";
			unset($uo);
		}		?>
	</table>
