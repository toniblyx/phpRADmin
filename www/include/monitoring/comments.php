<?
/** 
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Julien Mathis - Romain Le Merlus - Christophe Coraboeuf

The Software is provided to you AS IS and WITH ALL FAULTS.
OREON makes no representation and gives no warranty whatsoever,
whether express or implied, and without limitation, with regard to the quality,
safety, contents, performance, merchantability, non-infringement or suitability for
any particular or intended purpose of the Software found on the OREON web site.
In no event will OREON be liable for any direct, indirect, punitive, special,
incidental or consequential damages however they may arise and even if OREON has
been previously advised of the possibility of such damages.

For information : contact@oreon.org
*/
	if (!isset($oreon))
		exit();

	if (!isset($oreon->Lca[$oreon->user->get_id()]) || (isset($oreon->Lca[$oreon->user->get_id()]) && !strcmp($oreon->Lca[$oreon->user->get_id()]->get_comment(), "1"))){?>
		<table border=0 cellpadding="0" cellspacing="0" style="margin-bottom: 40px;" class="tabTableTitle" width="500" align="center">
			<tr>
				<td align="center"><a href='phpradmin.php?p=307&o=1' class="text12b">[<? echo $lang['cmt_addH']; ?>]</a></td>
				<td align="center"><a href='phpradmin.php?p=307&o=2' class="text12b">[<? echo $lang['cmt_addS']; ?>]</a></td>
			</tr>
		</table>
		<? 	if (isset($_GET["o"]) && !strcmp($_GET["o"], "1"))		{	?>
		<form action="" method="get">
		<table style="margin-bottom: 35px;" cellpadding="0" cellspacing="0" align="center">
			<tr>
				<td class="tabTableTitle">
					<table width="100%" height='100%' border=0 cellpadding="4" cellspacing="0">
						<tr>
							<td ><? echo $lang['cmt_addH']; ?></td>
						</tr>
					</table>
				</td>	
			</tr>
			<tr>
				<td class="tabTableForTab">
					<table width="100%" height='100%' border=0>
						<tr>
							<td class="text10b"><? echo $lang['cmt_host_name']; ?><font color="red">*</font></td>
							<td><input name="p" type="hidden" value="306"><input name="cmd" type="hidden" value="0">
								  <select name="cmt[host_name]">
									<? 
									if (isset($oreon->hosts))
										foreach ($oreon->hosts as $h)	{
											if ($h->get_register() && $oreon->is_accessible($h->get_id()))
												print "<option>".$h->get_name()."</option>";
											unset($h);		
										}	
									?>
								  </select>
							</td>
						</tr>
						<tr>
							<td class="text10b"><? echo $lang['cmt_persistent']; ?></td>
							<td>
								<input name="cmt[pers]" type="checkbox" checked>
								<input name="cmt[auther]" type="hidden" value="<? print $oreon->user->get_alias(); ?>">
							</td>
						</tr>	
						<tr>
							<td class="text10b" valign="top"><? echo $lang['cmt_comment']; ?><font color="red">*</font></td>
							<td><textarea name="cmt[comment]" cols="40" rows="7"></textarea></td>
						</tr>
						<tr>
							<td colspan="2" align="center"><input value="<? echo $lang['save']; ?>" type="submit"></td>
						</tr>
					</table>
				</form>
				</td>
			</tr>
			</table>	
			<?	
			}	else if (isset($_GET["o"]) && !strcmp($_GET["o"], "2"))	{
				if (isset($_GET["cmt"]))
					$cmt = & $_GET["cmt"];
			?>
			<form action="" method="get" name="addServiceComment">
			<table style="margin-bottom: 35px;" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td class="tabTableTitle">
						<table width="100%" height='100%' border=0 cellpadding="4" cellspacing="0">
							<tr>
								<td ><? echo $lang['cmt_addS']; ?></td>
							</tr>
						</table>
					</td>	
				</tr>
				<tr>
					<td class="tabTableForTab">
						<table width="100%" height='100%' border=0>
						<tr>
							<td class="text10b"><? echo $lang['cmt_host_name']; ?><font color="red">*</font></td>
							<td>
								<input name="p" type="hidden" value="306" id="pOk">
								<input name="p" type="hidden" value="307" id="pKo" disabled>
								<input name="o" type="hidden" value="2">
								<input name="cmd" type="hidden" value="1">
								<select name="cmt[host_id]" onChange="document.forms['addServiceComment'].elements['pOk'].disabled = !(document.forms['addServiceComment'].elements['pOk'].disabled); document.forms['addServiceComment'].elements['pKo'].disabled = !(document.forms['addServiceComment'].elements['pKo'].disabled); this.form.submit();">
								<option> </option>
								<? 
								if (isset($oreon->hosts))
									foreach ($oreon->hosts as $h)	{
										if ($h->get_register() && $oreon->is_accessible($h->get_id()))	{
											echo "<option value='".$h->get_id()."'";
											if (isset($_GET["cmt"]) && isset($cmt['host_id']) && $h->get_id() == $cmt['host_id'])
												echo " selected";
											echo ">".$h->get_name()."</option>";
										}
										unset($h);		
									}
								?>
								</select>
							</td>
						</tr>
						<tr>
							<td class="text10b"><? echo $lang['s']; ?><font color="red">*</font></td>
							<td>
								<select name="cmt[svc]" id="service">
									<option value=""></option>
									<?
									if (isset($_GET["cmt"]) && isset($cmt['host_id']))
										foreach ($oreon->hosts[$cmt['host_id']]->services as $service)	{
											echo "<option value='".$service->get_description()."'>".$service->get_description()."</option>\n";
											unset($service);
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td class="text10b"><? echo $lang['cmt_persistent']; ?></td>
							<td>
								<input name="cmt[pers]" type="checkbox" checked>
								<input name="cmt[auther]" type="hidden" value="<? print $oreon->user->get_alias(); ?>">
							</td>
						</tr>
						<tr>
							<td class="text10b" valign="top"><? echo $lang['cmt_comment']; ?><font color="red">*</font></td>
							<td><textarea name="cmt[comment]" cols="40" rows="7"></textarea></td>
						</tr>
						<tr>
							<td colspan="2" align="center"><input value="<? echo $lang['save']; ?>" type="submit"></td>
						</tr>
						</table>
					</form>
					</td>
				</tr>
			</table>
			<?	}	else	{	?>
			<table style="border-width: thin; border-style: dashed; border-color=#9C9C9C;  margin-bottom: 35px;" cellpadding="3" cellspacing="2" align='center'>
				<tr>
				  <td colSpan=6 align="center" class="text14b"><? echo $lang['cmt_host_comment']; ?></td>
				</tr>
				<tr>
					<td bgcolor="#e9e9e9" style="white-space: nowrap;" class="text10b" align="center"><? echo $lang['cmt_host_name']; ?></td>
					<td bgcolor="#e9e9e9" style="white-space: nowrap;" class="text10b" align="center"><? echo $lang['cmt_entry_time']; ?></td>
					<td bgcolor="#e9e9e9" style="white-space: nowrap;" class="text10b" align="center"><? echo $lang['cmt_author']; ?></td>
					<td bgcolor="#e9e9e9" style="white-space: nowrap;" class="text10b" align="center"><? echo $lang['cmt_comment']; ?></td>
					<td bgcolor="#e9e9e9" style="white-space: nowrap;" class="text10b" align="center"><? echo $lang['cmt_persistent']; ?></td>
					<td bgcolor="#e9e9e9" style="white-space: nowrap;" class="text10b" align="center"><? echo $lang['cmt_actions']; ?></td>
				</tr>
			<?
					$COLOR["1"] = "#e9e9e9";
					$COLOR["0"] = "#E0E0E0";			
					if (!file_exists($oreon->Nagioscfg->comment_file))
						print ("downtime file not found");
					else	{
						$log = fopen($oreon->Nagioscfg->comment_file, "r");
						$i = 0;
						while ($str = fgets($log))	{
							if (preg_match("/^\[([0-9]*)\] HOST_COMMENT;/", $str, $matches))	{
								$time = $matches[1];
								$res = preg_split("/;/", $str);
								print "<tr><td bgcolor='". $COLOR[$i % 2] ."' align='center'>".$res[2]."</td>";
								print "<td bgcolor='". $COLOR[$i % 2] ."' style='white-space: nowrap;' align='center'>".date("d-m-Y G:i:s", $time)."</td>";
								print "<td bgcolor='". $COLOR[$i % 2] ."' align='center'>".$res[4]."</td>";
								print "<td bgcolor='". $COLOR[$i % 2] ."' align='center'>".$res[5]."</td>";
								print "<td bgcolor='". $COLOR[$i % 2] ."' align='center'>".$res[3]."</td>";
								print "<td bgcolor='". $COLOR[$i % 2] ."' align='center'><a href='phpradmin.php?p=306&cmd=2&id=$res[1]' onclick=\"return confirm('".$lang['confirm_removing']."')\"><img src='./img/deleted.gif' border=0></a></td></tr>";
								$i++;
							}
						}
					}
			?>
			</table>
			<table style="border-width: thin; border-style: dashed; border-color=#9C9C9C;  margin-bottom: 35px;" cellpadding="3" cellspacing="2" align='center'>
				<tr>
				  <td colSpan=7 align="center" class="text14b"><? echo $lang['cmt_service_comment']; ?></td>
				</tr>
				<tr>
					<td bgcolor="#e9e9e9" style="white-space: nowrap;" class="text10b" align="center"><? echo $lang['cmt_host_name']; ?></td>
					<td bgcolor="#e9e9e9" style="white-space: nowrap;" class="text10b" align="center"><? echo $lang['s']; ?></td>
					<td bgcolor="#e9e9e9" style="white-space: nowrap;" class="text10b" align="center"><? echo $lang['cmt_entry_time']; ?></td>
					<td bgcolor="#e9e9e9" style="white-space: nowrap;" class="text10b" align="center"><? echo $lang['cmt_author']; ?></td>
					<td bgcolor="#e9e9e9" style="white-space: nowrap;" class="text10b" align="center"><? echo $lang['cmt_comment']; ?></td>
					<td bgcolor="#e9e9e9" style="white-space: nowrap;" class="text10b" align="center"><? echo $lang['cmt_persistent']; ?></td>
					<td bgcolor="#e9e9e9" style="white-space: nowrap;" class="text10b" align="center"><? echo $lang['cmt_actions']; ?></td>
				</tr>
			<?
					$COLOR["1"] = "#e9e9e9";
					$COLOR["0"] = "#E0E0E0";
			
					if (!file_exists($oreon->Nagioscfg->comment_file))
						print ("downtime file not found");
					else {
						$log = fopen($oreon->Nagioscfg->comment_file, "r");
						$i = 0;
						while ($str = fgets($log))	{
							if (preg_match("/^\[([0-9]*)\] SERVICE_COMMENT;/", $str, $matches))	{
								$time = $matches[1];
								$res = preg_split("/;/", $str);
								print "<tr><td bgcolor='". $COLOR[$i % 2] ."' align='center'>".$res[2]."</td>";
								print "<td bgcolor='". $COLOR[$i % 2] ."' align='center'>".$res[3]."</td>";
								print "<td bgcolor='". $COLOR[$i % 2] ."' style='white-space: nowrap;' align='center'>".date("d-m-Y G:i:s", $time)."</td>";
								print "<td bgcolor='". $COLOR[$i % 2] ."' align='center'>".$res[5]."</td>";
								print "<td bgcolor='". $COLOR[$i % 2] ."' align='center'>".$res[6]."</td>";
								print "<td bgcolor='". $COLOR[$i % 2] ."' align='center'>".$res[4]."</td>";
								print "<td bgcolor='". $COLOR[$i % 2] ."' align='center'><a href='phpradmin.php?p=306&cmd=4&id=$res[1]' onclick=\"return confirm('".$lang['confirm_removing']."')\"><img src='./img/deleted.gif' border=0></a></td></tr>";
								$i++;
							}
						}
					}
				?> </table> <?
			}
		}
		else
			include("./include/security/error.php");
		?>