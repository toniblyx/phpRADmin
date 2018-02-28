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

	if (!isset($oreon->Lca[$oreon->user->get_id()]) || (isset($oreon->Lca[$oreon->user->get_id()]) && !strcmp($oreon->Lca[$oreon->user->get_id()]->get_downtime(), "1"))){?>
		<table border=0 cellpadding="0" cellspacing="0" style="margin-bottom: 40px;" class="tabTableTitle" width="500" align="center">
			<tr>
				<td align="center" style="white-space: nowrap;"><a href='phpradmin.php?p=308&o=1' class="text11b">[<? echo $lang['dtm_addH']; ?>]</a></td>
				<td align="center" style="white-space: nowrap; padding-left: 20px;"><a href='phpradmin.php?p=308&o=2' class="text11b">[<? echo $lang['dtm_addS']; ?>]</a></td>
				<td align="center" style="white-space: nowrap;" colspan="2"><a href='phpradmin.php?p=308&o=5' class="text12b">[<? echo $lang['dtm_addHG']; ?>]</a></td>
			</tr>
		</table>
		<?	if (isset($_GET["o"]) && !strcmp($_GET["o"], "1"))	{	?>
		<form action="phpradmin.php" method="get">
		<table style="margin-bottom: 35px;" cellpadding="0" cellspacing="0" align="center">
			<tr>
				<td class="tabTableTitle">
					<table width="100%" height='100%' border=0 cellpadding="4" cellspacing="0">
						<tr>
							<td ><? echo $lang['dtm_addH']; ?></td>
						</tr>
					</table>
				</td>	
			</tr>
			<tr>
				<td class="tabTableForTab">
					<table width="100%" height='100%' border=0 cellpadding="7" cellspacing="0">
						<tr>
							<td class="text10b" style="white-space: nowrap;"><? echo $lang['cmt_host_name']; ?><font color="red">*</font></td>
							<td>
								<input name="p" type="hidden" value="306"><input name="cmd" type="hidden" value="43">
								  <select name="dtm[host_name]">
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
							<td class="text10b" style="white-space: nowrap;"><? echo $lang['cmt_author']; ?><font color="red">*</font> </td>
							<td>
								<? echo $oreon->user->get_alias(); ?>
								<input name="dtm[auther]" type="hidden" value="<? print $oreon->user->get_alias(); ?>">
							</td>
						</tr>
						<tr>
							<td class="text10b" valign="top" style="white-space: nowrap;"><? echo $lang['cmt_comment']; ?><font color="red">*</font></td>
							<td><textarea name="dtm[comment]" cols="40" rows="7"></textarea></td>
						</tr>
						<tr>
							<td class="text10b" style="white-space: nowrap;"><? echo $lang["dtm_start_time"]; ?><font color="red">*</font> </td>
							<td><input name="dtm[strtime]" type="text" value="<? print date("d-m-Y G:i:s", time()); ?>"></td>
						</tr>
						<tr>
							<td class="text10b" style="white-space: nowrap;"><? echo $lang["dtm_end_time"]; ?><font color="red">*</font> </td>
							<td><input name="dtm[endtime]" type="text" value="<? print date("d-m-Y G:i:s", time() + 7200); ?>"></td>
						</tr>
						<tr>
							<td class="text10b" style="white-space: nowrap;"><? echo $lang['dtm_fixed']; ?><font color="red">*</font> </td>
							<td><input name="dtm[fixed]" type="checkbox" checked></td>
						</tr>
						<tr>
							<td class="text10b" style="white-space: nowrap;"><? echo $lang['dtm_duration']; ?><font color="red">*</font> </td>
							<td><input name="dtm[dur_d]" type="text" value="00" lang="2" SIZE=2 MAXLENGTH=2> Days <input name="dtm[dur_h]" type="text" value="02" lang="2" SIZE=2 MAXLENGTH=2> Hours <input name="dtm[dur_m]" type="text" value="00" SIZE=2 MAXLENGTH=2> minutes</td>
						</tr>
						<tr>
							<td colspan="2" align="center"><input value="<? echo $lang['save']; ?>" type="submit"></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		</form>
		<?	} else if (isset($_GET["o"]) && !strcmp($_GET["o"], "2"))	{
				if (isset($_GET["dtm"]))
					$dtm = & $_GET["dtm"];
		?>
		<form action="" method="get" name="addServiceDowntime">
		<table style="margin-bottom: 35px;" cellpadding="0" cellspacing="0" align="center">
			<tr>
				<td class="tabTableTitle">
					<table width="100%" height='100%' border=0 cellpadding="4" cellspacing="0">
						<tr>
							<td ><? echo $lang['dtm_addS']; ?></td>
						</tr>
					</table>
				</td>	
			</tr>
			<tr>
				<td class="tabTableForTab">
					<table width="100%" height='100%' border=0 cellpadding="7" cellspacing="0">
						<tr>
							<td class="text10b" style="white-space: nowrap;"><? echo $lang['cmt_host_name']; ?><font color="red">*</font></td>
							<td>
								<input name="p" type="hidden" value="306" id="pOk">
								<input name="p" type="hidden" value="308" id="pKo" disabled>
								<input name="o" type="hidden" value="2">
								<input name="cmd" type="hidden" value="44">
								<select name="dtm[host_id]"  onChange="document.forms['addServiceDowntime'].elements['pOk'].disabled = !(document.forms['addServiceDowntime'].elements['pOk'].disabled); document.forms['addServiceDowntime'].elements['pKo'].disabled = !(document.forms['addServiceDowntime'].elements['pKo'].disabled); this.form.submit();">
									<option></option>
								<?
									if (isset($oreon->hosts))
										foreach ($oreon->hosts as $h)	{
											if ($h->get_register() && $oreon->is_accessible($h->get_id()))	{
												echo "<option value='".$h->get_id()."'";
												if (isset($_GET["dtm"]) && isset($dtm['host_id']) && $h->get_id() == $dtm['host_id'])
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
							<td class="text10b" valign="top" style="white-space: nowrap;"><? echo $lang['s']; ?><font color="red">*</font></td>
							<td>
								<select name="dtm[service]">
									<option value=""></option>
									<?
									if (isset($_GET["dtm"]) && isset($dtm['host_id']))
										foreach ($oreon->hosts[$dtm['host_id']]->services as $service)	{
											echo "<option value='".$service->get_description()."'>".$service->get_description()."</option>\n";
											unset($service);
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td class="text10b" style="white-space: nowrap;"><? echo $lang['cmt_author']; ?><font color="red">*</font> </td>
							<td>
								<? echo $oreon->user->get_alias(); ?>
								<input name="dtm[auther]" type="hidden" value="<? print $oreon->user->get_alias(); ?>">
							</td>
						</tr>
						<tr>
							<td class="text10b" valign="top" style="white-space: nowrap;"><? echo $lang['cmt_comment']; ?><font color="red">*</font></td>
							<td><textarea name="dtm[comment]" cols="40" rows="7"></textarea></td>
						</tr>
						<tr>
							<td class="text10b" style="white-space: nowrap;"><? echo $lang['dtm_start_time']; ?><font color="red">*</font> </td>
							<td><input name="dtm[strtime]" type="text" value="<? print date("d-m-Y G:i:s"); ?>"></td>
						</tr>
						<tr>
							<td class="text10b" style="white-space: nowrap;"><? echo $lang['dtm_end_time']; ?><font color="red">*</font> </td>
							<td><input name="dtm[endtime]" type="text" value="<? print date("d-m-Y G:i:s", time() + 7200); ?>"></td>
						</tr>
						<tr>
							<td class="text10b" style="white-space: nowrap;"><? echo $lang['dtm_fixed']; ?><font color="red">*</font> </td>
							<td><input name="dtm[fixed]" type="checkbox" checked></td>
						</tr>
						<tr>
							<td class="text10b" style="white-space: nowrap;"><? echo $lang['dtm_duration']; ?><font color="red">*</font> </td>
							<td><input name="dtm[dur_d]" type="text" value="00" lang="2" SIZE=2 MAXLENGTH=2> Days <input name="dtm[dur_h]" type="text" value="02" lang="2" SIZE=2 MAXLENGTH=2> Hours <input name="dtm[dur_m]" type="text" value="00" SIZE=2 MAXLENGTH=2> minutes</td>
						</tr>
						<tr>
							<td colspan="2" align="center"><input value="<? echo $lang['save']; ?>" type="submit"></td>
						</tr>
					</table>
				</form>
				</td>
			</tr>
		</table>
		<?	} else if (isset($_GET["o"]) && !strcmp($_GET["o"], "5"))	{	?>
		<form action="phpradmin.php" method="get">
		<table style="margin-bottom: 35px;" cellpadding="0" cellspacing="0" align="center">
			<tr>
				<td class="tabTableTitle">
					<table width="100%" height='100%' border=0 cellpadding="4" cellspacing="0">
						<tr>
							<td ><? echo $lang['dtm_addHG']; ?></td>
						</tr>
					</table>
				</td>	
			</tr>
			<tr>
				<td class="tabTableForTab">
					<table width="100%" height='100%' border=0 cellpadding="7" cellspacing="0">
						<tr>
							<td class="text10b" style="white-space: nowrap;"><? echo $lang['hg']; ?><font color="red">*</font></td>
							<td><input name="p" type="hidden" value="306"><input name="cmd" type="hidden" value="59">
								  <select name="dtm[host_group]">
									<?
									$hg_selected = NULL;
									if (isset($oreon->hostGroups))
										foreach ($oreon->hostGroups as $hg)	{
											if (isset($hg) && isset($_GET["id"]) && $hg->get_id() == $_GET["id"])
												$hg_selected = " selected";
											print "<option value='".$hg->get_id()."'".$hg_selected.">".$hg->get_name()."</option>";
											$hg_selected = NULL;
										unset($h);
									}
									?>
								  </select>
							</td>
						</tr>
						<tr>
							<td class="text10b" style="white-space: nowrap;"><? echo $lang['cmt_author']; ?> <font color="red">*</font> </td>
							<td>
								<? echo $oreon->user->get_alias(); ?>
								<input name="dtm[auther]" type="hidden" value="<? print $oreon->user->get_alias(); ?>">
							</td>
						</tr>
						<tr>
							<td class="text10b" valign="top" style="white-space: nowrap;"><? echo $lang['cmt_comment']; ?><font color="red">*</font></td>
							<td><textarea name="dtm[comment]" cols="40" rows="7"></textarea></td>
						</tr>
						<tr>
							<td class="text10b" style="white-space: nowrap;"><? echo $lang['dtm_start_time']; ?><font color="red">*</font> </td>
							<td><input name="dtm[strtime]" type="text" value="<? print date("d-m-Y G:i:s"); ?>"></td>
						</tr>
						<tr>
							<td class="text10b" style="white-space: nowrap;"><? echo $lang['dtm_end_time']; ?><font color="red">*</font> </td>
							<td><input name="dtm[endtime]" type="text" value="<? print date("d-m-Y G:i:s", time() + 7200); ?>"></td>
						</tr>
						<tr>
							<td class="text10b" style="white-space: nowrap;"><? echo $lang['dtm_fixed']; ?><font color="red">*</font> </td>
							<td><input name="dtm[fixed]" type="checkbox" checked></td>
						</tr>
						<tr>
							<td class="text10b" style="white-space: nowrap;"><? echo $lang['dtm_duration']; ?><font color="red">*</font> </td>
							<td><input name="dtm[dur_d]" type="text" value="00" lang="2" SIZE=2 MAXLENGTH=2> Days <input name="dtm[dur_h]" type="text" value="02" lang="2" SIZE=2 MAXLENGTH=2> Hours <input name="dtm[dur_m]" type="text" value="00" SIZE=2 MAXLENGTH=2> minutes</td>
						</tr>
						<tr>
							<td colspan="2" align="center"><input value="<? echo $lang['save']; ?>" type="submit"></td>
						</tr>
					</table>
				</form>
				</td>
			</tr>
			</table>
			<?	}	else if (isset($_GET["o"]) && !strcmp($_GET["o"], "6"))	{	?>
			<form action="phpradmin.php" method="get">
			<table style="margin-bottom: 35px;" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td class="tabTableTitle">
						<table width="100%" height='100%' border=0 cellpadding="4" cellspacing="0">
							<tr>
								<td ><? echo $lang['dtm_addH']; ?></td>
							</tr>
						</table>
					</td>	
				</tr>
				<tr>
					<td class="tabTableForTab">
					<table border=0>
						<tr>
							<td class="text10b" style="white-space: nowrap;"><? echo $lang['hg']; ?><font color="red">*</font></td>
							<td><input name="p" type="hidden" value="306"><input name="cmd" type="hidden" value="60">
								  <select name="dtm[host_group]">
									<?
									$hg_selected = NULL;
									if (isset($oreon->hostGroups))
										foreach ($oreon->hostGroups as $hg)	{
											if (isset($hg) && $hg->get_id() == $_GET["id"])
												$hg_selected = " selected";
											print "<option value='".$hg->get_id()."'".$hg_selected.">".$hg->get_name()."</option>";
											$hg_selected = NULL;
										unset($h);
									}
									?>
								  </select>
							</td>
						</tr>
						<tr>
							<td class="text10b" style="white-space: nowrap;"><? echo $lang['cmt_author']; ?> <font color="red">*</font> </td>
							<td>
								<? echo $oreon->user->get_alias(); ?>
								<input name="dtm[auther]" type="hidden" value="<? print $oreon->user->get_alias(); ?>">
							</td>
						</tr>
						<tr>
							<td class="text10b" valign="top" style="white-space: nowrap;"><? echo $lang['cmt_comment']; ?><font color="red">*</font></td>
							<td><textarea name="dtm[comment]" cols="40" rows="7"></textarea></td>
						</tr>
						<tr>
							<td class="text10b" style="white-space: nowrap;"><? echo $lang['dtm_start_time']; ?><font color="red">*</font> </td>
							<td><input name="dtm[strtime]" type="text" value="<? print date("d-m-Y G:i:s"); ?>"></td>
						</tr>
						<tr>
							<td class="text10b" style="white-space: nowrap;"><? echo $lang['dtm_end_time']; ?><font color="red">*</font> </td>
							<td><input name="dtm[endtime]" type="text" value="<? print date("d-m-Y G:i:s", time() + 7200); ?>"></td>
						</tr>
						<tr>
							<td class="text10b" style="white-space: nowrap;"><? echo $lang['dtm_fixed']; ?><font color="red">*</font> </td>
							<td><input name="dtm[fixed]" type="checkbox" checked></td>
						</tr>
						<tr>
							<td class="text10b" style="white-space: nowrap;"><? echo $lang['dtm_duration']; ?><font color="red">*</font> </td>
							<td><input name="dtm[dur_d]" type="text" value="00" lang="2" SIZE=2 MAXLENGTH=2> Days <input name="dtm[dur_h]" type="text" value="02" lang="2" SIZE=2 MAXLENGTH=2> Hours <input name="dtm[dur_m]" type="text" value="00" SIZE=2 MAXLENGTH=2> minutes</td>
						</tr>
						<tr>
							<td class="text10b" style="white-space: nowrap;"><? echo $lang['dtm_sch_dt_fht']; ?></td>
							<td><input name="dtm[host_too]" type="checkbox"></td>
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
			<table style="border-width: thin; border-style: dashed; border-color=#9C9C9C;  margin-bottom: 35px;" cellpadding="3" cellspacing="2" align="center">
				<tr>
				  <td align="center" colspan="9" class="text14b"><? echo $lang['dtm_host_downtimes']; ?></td>
				</tr>
				<tr>
					<td bgcolor="#e9e9e9" style="white-space: nowrap;" class="text10b" align="center"><? echo $lang['h']; ?></td>
					<td bgcolor="#e9e9e9" style="white-space: nowrap;" class="text10b" align="center"><? echo $lang['cmt_entry_time'] ; ?></td>
					<td bgcolor="#e9e9e9" style="white-space: nowrap;" class="text10b" align="center"><? echo $lang['cmt_author']; ?></td>
					<td bgcolor="#e9e9e9" style="white-space: nowrap;" class="text10b" align="center"><? echo $lang['cmt_comment']; ?></td>
					<td bgcolor="#e9e9e9" style="white-space: nowrap;" class="text10b" align="center"><? echo $lang['dtm_start_time']; ?></td>
					<td bgcolor="#e9e9e9" style="white-space: nowrap;" class="text10b" align="center"><? echo $lang['dtm_end_time']; ?></td>
					<td bgcolor="#e9e9e9" style="white-space: nowrap;" class="text10b" align="center"><? echo $lang['dtm_fixed']; ?></td>
					<td bgcolor="#e9e9e9" style="white-space: nowrap;" class="text10b" align="center"><? echo $lang['dtm_duration']; ?></td>
					<td bgcolor="#e9e9e9" style="white-space: nowrap;" class="text10b" align="center"><? echo $lang['cmt_actions']; ?></td>
				</tr>
				<?
				$COLOR["1"] = "#e9e9e9";
				$COLOR["0"] = "#E0E0E0";
				if (!file_exists($oreon->Nagioscfg->downtime_file))
					echo $lang['dtm_dt_no_file'];
				else {
					$log = fopen($oreon->Nagioscfg->downtime_file, "r");
					$i = 0;
					while ($str = fgets($log))	{
						if (preg_match("/^\[([0-9]*)\] HOST_DOWNTIME;/", $str, $matches))	{
							$time = $matches[1];
							$res = preg_split("/;/", $str);
							print "<tr><td bgcolor='". $COLOR[$i % 2] ."' align='center'>".$res[2]."</td>";
							print "<td bgcolor='". $COLOR[$i % 2] ."' style='white-space: nowrap;' align='center'>".date("d-m-Y G:i:s", $time)."</td>";
							print "<td bgcolor='". $COLOR[$i % 2] ."' align='center'>".$res[7]."</td>";
							print "<td bgcolor='". $COLOR[$i % 2] ."' align='center'>".$res[8]."</td>";
							print "<td bgcolor='". $COLOR[$i % 2] ."' style='white-space: nowrap;' align='center'>".date("d-m-Y G:i:s", $res[3])."</td>";
							print "<td bgcolor='". $COLOR[$i % 2] ."' style='white-space: nowrap;' align='center'>".date("d-m-Y G:i:s", $res[4])."</td>";
							print "<td bgcolor='". $COLOR[$i % 2] ."' align='center' width='300'>".$res[5]."</td>";
							$d_duration = date("d", $res[6]) - 1;
							$h_duration = date("G", $res[6]) - 1;
							$i_duration = date("i", $res[6]);
							$s_duration = date("s", $res[6]);
							print "<td bgcolor='". $COLOR[$i % 2] ."' align='center'>".$d_duration.$lang['time_days'].$h_duration.$lang['time_hours'].$i_duration.$lang['time_min'].$s_duration.$lang['time_sec']."</td>";
							print "<td bgcolor='". $COLOR[$i % 2] ."' align='center'><a href='phpradmin.php?p=306&cmd=45&id=$res[1]' onclick=\"return confirm('".$lang['confirm_removing']."')\"><img src='./img/deleted.gif' border=0 alt='".$lang['dtm_host_delete']."' title='".$lang['dtm_host_delete']."' ></a></td></tr>";
							$i++;
						}
					}
				}
			?>
			</table>
			<table style="border-width: thin; border-style: dashed; border-color=#9C9C9C;  margin-bottom: 35px;" cellpadding="3" cellspacing="2" align="center">
				<tr>
				  <td colspan="10" align="center" class="text14b"><? echo $lang['dtm_service_downtimes']; ?></td>
				</tr>
				<tr>
					<td bgcolor="#e9e9e9" style="white-space: nowrap;" class="text10b" align="center"><? echo $lang['h'] ; ?></td>
					<td bgcolor="#e9e9e9" style="white-space: nowrap;" class="text10b" align="center"><? echo $lang['cmt_entry_time'] ; ?></td>
					<td bgcolor="#e9e9e9" style="white-space: nowrap;" class="text10b" align="center"><? echo $lang['s'] ; ?></td>
					<td bgcolor="#e9e9e9" style="white-space: nowrap;" class="text10b" align="center"><? echo $lang['cmt_author']; ?></td>
					<td bgcolor="#e9e9e9" style="white-space: nowrap;" class="text10b" align="center"><? echo $lang['cmt_comment']; ?></td>
					<td bgcolor="#e9e9e9" style="white-space: nowrap;" class="text10b" align="center"><? echo $lang['dtm_start_time']; ?></td>
					<td bgcolor="#e9e9e9" style="white-space: nowrap;" class="text10b" align="center"><? echo $lang['dtm_end_time']; ?></td>
					<td bgcolor="#e9e9e9" style="white-space: nowrap;" class="text10b" align="center"><? echo $lang['dtm_fixed']; ?></td>
					<td bgcolor="#e9e9e9" style="white-space: nowrap;" class="text10b" align="center"><? echo $lang['dtm_duration']; ?></td>
					<td bgcolor="#e9e9e9" style="white-space: nowrap;" class="text10b" align="center"><? echo $lang['cmt_actions']; ?></td>
				</tr>
				<?
				$COLOR["1"] = "#e9e9e9";
				$COLOR["0"] = "#E0E0E0";
				if (!file_exists($oreon->Nagioscfg->downtime_file))
					echo $lang['dtm_dt_no_file'];
				else {
					$log = fopen($oreon->Nagioscfg->downtime_file, "r");
					$i = 0;
					while ($str = fgets($log))	{
						if (preg_match("/^\[([0-9]*)\] SERVICE_DOWNTIME;/", $str, $matches))	{
							$time = $matches[1];
							$res = preg_split("/;/", $str);
							print "<tr><td bgcolor='". $COLOR[$i % 2] ."' align='center'>".$res[2]."</td>";
							print "<td bgcolor='". $COLOR[$i % 2] ."' style='white-space: nowrap;' align='center'>".date("d-m-Y G:i:s", $time)."</td>";
							print "<td bgcolor='". $COLOR[$i % 2] ."' align='center'>".$res[3]."</td>";
							print "<td bgcolor='". $COLOR[$i % 2] ."' align='center'>".$res[8]."</td>";
							print "<td bgcolor='". $COLOR[$i % 2] ."' align='center'>".$res[9]."</td>";
							print "<td bgcolor='". $COLOR[$i % 2] ."' style='white-space: nowrap;' align='center'>".date("d-m-Y G:i:s", $res[4])."</td>";
							print "<td bgcolor='". $COLOR[$i % 2] ."' style='white-space: nowrap;' align='center'>".date("d-m-Y G:i:s", $res[5])."</td>";
							print "<td bgcolor='". $COLOR[$i % 2] ."' align='center' width='300'>".$res[6]."</td>";
							$d_duration = date("d", $res[7]) - 1;
							$h_duration = date("G", $res[7]) - 1;
							$i_duration = date("i", $res[7]);
							$s_duration = date("s", $res[7]);
							print "<td bgcolor='". $COLOR[$i % 2] ."' align='center'>".$d_duration.$lang['time_days'].$h_duration.$lang['time_hours'].$i_duration.$lang['time_min'].$s_duration.$lang['time_sec']."</td>";
							print "<td bgcolor='". $COLOR[$i % 2] ."' align='center'><a href='phpradmin.php?p=306&cmd=46&id=$res[1]' onclick=\"return confirm('".$lang['confirm_removing']."')\"><img src='./img/deleted.gif' border=0 alt='".$lang['dtm_host_delete']."' title='".$lang['dtm_host_delete']."' ></a></td></tr>";
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