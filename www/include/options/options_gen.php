<?
/*
phpRADmin is developped under GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt or read LICENSE file.

Developed by : Toni de la Fuente (blyx) from Madrid and Alfacar (Granada), Spain  
For information : toni@blyx.com http://blyx.com

We are using Oreon for base code: http://www.oreon-project.org
We are using Dialup Admin for user management 
and many more things: http://www.freeradius.org
We are using PHPKI for Certificates management: http://phpki.sourceforge.org/ 

Thanks very much!!
*/
	if (!isset($oreon))
		exit();

	if (!isset($oreon->colors))
		$oreon->loadColors();

	$colors  = & $oreon->colors_list;

	if (isset($_POST["ChangeOPTGEN"]))	{
		$opt_array = & $_POST["opt"];
		unset($oreon->optGen);
		$oreon->optGen = new optGen($opt_array);
		$oreon->saveoptgen($oreon->optGen);
		$msg = $lang["opt_gen_save"];
	}
	if (isset($msg))
		echo "<div align='left' class='text12b' style='padding-top: 10px; padding-bottom: 10px;'>$msg</div>";
?>
<form method="post" action="">
	<table border="0" align="left" cellpadding="0" cellspacing="0">
		<tr>
			<td class="tabTableTitle"><? print $lang["opt_gen"]; ?></td>
		</tr>
		<tr>
			<td class="tabTableForTab">
				<table cellpadding="4" cellspacing="4">
					<tr>
						<td class="text11"><? print $lang["phpradmin_path"]; ?></td>
						<td><input <? print $oreon->optGen->is_valid_path($oreon->optGen->get_phpradmin_pwd()); ?> name="opt[phpradmin_pwd]" size="30" type="text" value="<? print $oreon->optGen->get_phpradmin_pwd(); ?>"></td>
						<td align="center"><img src="./img/info.gif" ONMOUSEOVER="montre_legende('<? print $lang["phpradmin_path_tooltip"]; ?>', '<? print $lang["phpradmin_path"]; ?>');" ONMOUSEOUT="cache_legende();" ></td>
					</tr>
					<tr>
						<td class="text11"><? print $lang["radius_bin_pwd"]; ?></td>
						<td><input  <? print $oreon->optGen->is_valid_path($oreon->optGen->get_radius_bin_pwd()); ?> name="opt[radius_bin_pwd]" size="30" type="text" value="<? print $oreon->optGen->get_radius_bin_pwd() ; ?>"></td>
						<td align="center"><img src="./img/info.gif" ONMOUSEOVER="montre_legende('<? print $lang["radius_bin_pwd_tooltip"]; ?>', '<? print $lang["radius_bin_pwd"]; ?>');" ONMOUSEOUT="cache_legende();" ></td>
					</tr>
					<tr>
						<td class="text11"><? print $lang["radius_path"]; ?></td>
						<td><input  <? print $oreon->optGen->is_valid_path($oreon->optGen->get_radius_pwd()); ?> name="opt[radius_pwd]" size="30" type="text" value="<? print $oreon->optGen->get_radius_pwd() ; ?>"></td>
						<td align="center"><img src="./img/info.gif" ONMOUSEOVER="montre_legende('<? print $lang["radius_path_tooltip"]; ?>', '<? print $lang["radius_path"]; ?>');" ONMOUSEOUT="cache_legende();" ></td>
					</tr>
					<tr>
						<td class="text11"><? print $lang["dictionary_path"]; ?></td>
						<td><input <? print $oreon->optGen->is_readable_directory($oreon->optGen->get_dictionary_path()); ?>  name="opt[dictionary_path]" size="30" type="text" value="<? print $oreon->optGen->get_dictionary_path() ; ?>"></td>
						<td align="center"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $lang["dictionary_path_tooltip"]; ?>', '<? print $lang["dictionary_path"]; ?>');" ONMOUSEOUT="cache_legende();" ></td>
					</tr>
					<tr>
						<td class="text11"><? print $lang["radius_init_script_path"]; ?></td>
						<td><input <? print $oreon->optGen->get_startup_script(); ?>  name="opt[startup_script]" size="30" type="text" value="<? print $oreon->optGen->get_startup_script() ; ?>"></td>
						<td align="center"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $lang["radius_init_script_path_tooltip"]; ?>', '<? print $lang["radius_init_script_path"]; ?>');" ONMOUSEOUT="cache_legende();" ></td>
					</tr>
					<tr>
						<td class="text11"><? print $lang["refresh_interface"]; ?></td>
						<td><input name="opt[refresh]" type="text" size="5" value="<? print $oreon->optGen->get_refresh() ; ?>"><? print $lang["time_sec"]; ?></td>
						<td align="center"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $lang["refresh_interface_tooltip"]; ?>', '<? print $lang["refresh_interface"]; ?>');" ONMOUSEOUT="cache_legende();" ></td>
					</tr>
					<tr>
						<td class="text11"><? print $lang["rrd_path"]; ?></td>
						<td><input name="opt[rrd_pwd]" size="30" type="text" value="<? print $oreon->optGen->get_rrd_pwd(); ?>"></td>
						<td align="center"><img src="./img/info.gif" ONMOUSEOVER="montre_legende('<? print $lang["rrd_path_tooltip"]; ?>', '<? print $lang["rrd_path"]; ?>');" ONMOUSEOUT="cache_legende();" ></td>
					</tr>
					<tr>
						<td class="text11"><? print $lang["sudo_bin_path"]; ?></td>
						<td><input name="opt[sudo_bin_path]" size="30" type="text" value="<? print $oreon->optGen->get_sudo_bin_path(); ?>"></td>
						<td align="center"><img src="./img/info.gif" ONMOUSEOVER="montre_legende('<? print $lang["sudo_path_tooltip"]; ?>', '<? print $lang["sudo_bin_path"]; ?>');" ONMOUSEOUT="cache_legende();"></td>
					</tr>
					<tr>
						<td class="text11"><? print $lang["system_log_path"]; ?></td>
						<td><input name="opt[system_log_path]" size="30" type="text" value="<? print $oreon->optGen->get_system_log_path(); ?>"></td>
						<td align="center"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $lang["system_log_path_tooltip"]; ?>', '<? print $lang["system_log_path"]; ?>');" ONMOUSEOUT="cache_legende();"></td>
					</tr>
					<tr>
						<td class="text11"><? print $lang["radius_log_path"]; ?></td>
						<td><input name="opt[radius_log_path]" size="30" type="text" value="<? print $oreon->optGen->get_radius_log_path(); ?>"></td>
						<td align="center"><img src="./img/info.gif"  ONMOUSEOVER="montre_legende('<? print $lang["radius_log_path_tooltip"]; ?>', '<? print $lang["radius_log_path"]; ?>');" ONMOUSEOUT="cache_legende();"></td>
					</tr>
					<tr>
						<td class="text11"><? print $lang["session_expire"]; ?></td>
						<td colspan="2"><select name="opt[session_expire]">
							<?
								for ($i = 0; $i <= 180; $i = $i + 10){
									print "<option value='".$i."' ";
									if ($oreon->optGen->session_expire == $i)
										print " selected ";
									if ($i == 0) {
										print ">".$lang["session_expire_unlimited"]."</option>\n";
									} else {
										print ">" . $i . "</option>\n";
									}
								}
							?>
							</select> <? print $lang["time_min"]; ?>
						</td>
					</tr>
					<tr>
						<td class="text11b" colspan="3" style="padding-bottom: 5px; padding-top: 10px;" align="center"><? print $lang["path_error_legend"]; ?></td>
					</tr>
					<tr>
						<td class="text11" colspan="2" style="padding-bottom: 5px; padding-top: 0px;" align="center">
						    <table>
							<tr>
								<td height="10" width="10" class="invalid_path">&nbsp;</td>
								<td style="white-space: nowrap;" class="text11"><? print $lang["invalid_path"]; ?></td>
							</tr>
							<tr>
								<td height="10" width="10" class="unexecutable_binary">&nbsp;</td>
								<td style="white-space: nowrap;" class="text11"><? print $lang["executable_binary"]; ?></td>
							</tr>
							<tr>
								<td height="10" width="10" class="unwritable_path">&nbsp;</td>
								<td style="white-space: nowrap;" class="text11"><? print $lang["writable_path"]; ?></td>
							</tr>
							<tr>
								<td height="10" width="10" class="unreadable_path">&nbsp;</td>
								<td style="white-space: nowrap;" class="text11"><? print $lang["readable_path"]; ?></td>
							</tr>
						    </table>
						</td>
					</tr>
					<tr>
						<td colspan="2" align="center" style="padding-top: 10px;"><input name="ChangeOPTGEN" type="submit" value="<? print $lang["save"]; ?>"></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</form>