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
?>
<form action="" method="post">
	<table border="0" cellpadding="3" cellspacing="3">
		<tr>
			<td style="white-space: nowrap;"><? echo $lang['name']; ?> <font color='red'>*</font></td>
			<td class="text10b" style="white-space: nowrap;"><input type="text" name="cct[contact_name]" value="<? echo $contacts[$contact_id]->get_name(); ?>"></td>
		</tr>
		<tr>
			<td style="white-space: nowrap;"><? echo $lang['alias']; ?> <font color='red'>*</font></td>
			<td class="text10b" style="white-space: nowrap;"><input type="text" name="cct[contact_alias]" value="<? echo $contacts[$contact_id]->get_alias(); ?>"></td>
		</tr>
		<tr>
			<td style="white-space: nowrap;">Host Notification options : <font color='red'>*</font> </td>
			<td style="padding: 3px; white-space: nowrap;">
				<?
				$option_not = array();
				if (strcmp($contacts[$contact_id]->get_host_notification_options(), "")){
					$tab = split(",", $contacts[$contact_id]->get_host_notification_options());
					for ($i = 0; $i != 5; $i++){
						if (isset($tab[$i]))
							$option_not[$tab[$i]] = $tab[$i];
					}
				}
				?>
				<input ONMOUSEOVER="montre_legende('Down', '');" ONMOUSEOUT="cache_legende();" name="cct[contact_host_notification_options_d]" type="checkbox" value="d" <? if (isset($option_not["d"]) && strcmp($option_not["d"], "")) print "Checked"; if (isset($option_not["n"]) && strcmp($option_not["n"], "")) print "disabled";?>  id="contact_host_notification_options_d"> d -
				<input ONMOUSEOVER="montre_legende('Unreachable', '');" ONMOUSEOUT="cache_legende();" name="cct[contact_host_notification_options_u]" type="checkbox" value="u" <? if (isset($option_not["u"]) && strcmp($option_not["u"], "")) print "Checked"; if (isset($option_not["n"]) && strcmp($option_not["n"], "")) print "disabled";?>  id="contact_host_notification_options_u"> u -
				<input ONMOUSEOVER="montre_legende('Recovery', '');" ONMOUSEOUT="cache_legende();" name="cct[contact_host_notification_options_r]" type="checkbox" value="r" <? if (isset($option_not["r"]) && strcmp($option_not["r"], "")) print "Checked"; if (isset($option_not["n"]) && strcmp($option_not["n"], "")) print "disabled";?>  id="contact_host_notification_options_r"> r -
				<? if (!strcmp($oreon->user->get_version(), "2")){ ?>
				<input ONMOUSEOVER="montre_legende('Flapping', '');" ONMOUSEOUT="cache_legende();" name="cct[contact_host_notification_options_f]" type="checkbox" value="f" <? if (isset($option_not["f"]) && strcmp($option_not["f"], "")) print "Checked"; if (isset($option_not["n"]) && strcmp($option_not["n"], "")) print "disabled";?>  id="contact_host_notification_options_f"> f -
				<? } ?>
				<input ONMOUSEOVER="montre_legende('None', '');" ONMOUSEOUT="cache_legende();" name="cct[contact_host_notification_options_n]" type="checkbox" value="n" <? if (isset($option_not["n"]) && strcmp($option_not["n"], "")) print "Checked";?> onClick="enabledOptionsCheck(contact_host_notification_options_d);enabledOptionsCheck(contact_host_notification_options_r);enabledOptionsCheck(contact_host_notification_options_u);<? if ($oreon->user->get_version() == 2) {echo "enabledOptionsCheck(contact_host_notification_options_f);";}?>"> n
			</td>
		</tr>
		<tr>
			<td style="white-space: nowrap;">Host notification period : <font color='red'>*</font></td>
			<td class="text10b" style="white-space: nowrap;">
			<select name="cct[timeperiod_tp_id]">
			<?
				foreach ($oreon->time_periods as $tp)	{
					if ($tp->get_id() == $contacts[$contact_id]->get_host_notification_period())
						echo "<option value='" . $tp->get_id() . "' selected>" . $tp->get_name() . "</option>";
					else
						echo "<option value='" . $tp->get_id() . "'>" . $tp->get_name() . "</option>";
					unset($tp);
				}
			?>
			</select>
			</td>
		</tr>
		<tr>
			<td style="white-space: nowrap;">Service Notification options : <font color='red'>*</font> </td>
			<td style="padding: 3px; white-space: nowrap;">
			<?
				$option_not = array();
				if (strcmp($contacts[$contact_id]->get_service_notification_options(), "")){
					$tab = split(",", $contacts[$contact_id]->get_service_notification_options());
					for ($i = 0; $i != 6; $i++){
						if (isset($tab[$i]))
							$option_not[$tab[$i]] = $tab[$i];
					}
				}
			?>
				<input ONMOUSEOVER="montre_legende('Warning', '');" ONMOUSEOUT="cache_legende();" name="cct[contact_service_notification_options_w]" type="checkbox" value="w" <? if (isset($option_not["w"]) && strcmp($option_not["w"], "")) print "Checked"; if (isset($option_not["n"]) && strcmp($option_not["n"], "")) print "disabled";?> id="contact_service_notification_options_w"> w -
				<input ONMOUSEOVER="montre_legende('Unknow', '');" ONMOUSEOUT="cache_legende();" name="cct[contact_service_notification_options_u]" type="checkbox" value="u" <? if (isset($option_not["u"]) && strcmp($option_not["u"], "")) print "Checked"; if (isset($option_not["n"]) && strcmp($option_not["n"], "")) print "disabled";?> id="contact_service_notification_options_u"> u -
				<input ONMOUSEOVER="montre_legende('Critical', '');" ONMOUSEOUT="cache_legende();" name="cct[contact_service_notification_options_c]" type="checkbox" value="c" <? if (isset($option_not["c"]) && strcmp($option_not["c"], "")) print "Checked"; if (isset($option_not["n"]) && strcmp($option_not["n"], "")) print "disabled";?> id="contact_service_notification_options_c"> c -
				<input ONMOUSEOVER="montre_legende('Recovery', '');" ONMOUSEOUT="cache_legende();" name="cct[contact_service_notification_options_r]" type="checkbox" value="r" <? if (isset($option_not["r"]) && strcmp($option_not["r"], "")) print "Checked"; if (isset($option_not["n"]) && strcmp($option_not["n"], "")) print "disabled";?> id="contact_service_notification_options_r"> r -
			<? if (!strcmp($oreon->user->get_version(), "2")){ ?>
				<input ONMOUSEOVER="montre_legende('Flapping', '');" ONMOUSEOUT="cache_legende();" name="cct[contact_service_notification_options_f]" type="checkbox" value="f" <? if (isset($option_not["f"]) && strcmp($option_not["f"], "")) print "Checked"; if (isset($option_not["n"]) && strcmp($option_not["n"], "")) print "disabled";?> id="contact_service_notification_options_f"> f -
			<? } ?>
				<input ONMOUSEOVER="montre_legende('None', '');" ONMOUSEOUT="cache_legende();" name="cct[contact_service_notification_options_n]" type="checkbox" value="n" <? if (isset($option_not["n"]) && strcmp($option_not["n"], "")) print "Checked";?> onClick="enabledOptionsCheck(contact_service_notification_options_w);enabledOptionsCheck(contact_service_notification_options_u);enabledOptionsCheck(contact_service_notification_options_c);enabledOptionsCheck(contact_service_notification_options_r);<? if ($oreon->user->get_version() == 2) {echo "enabledOptionsCheck(contact_service_notification_options_f);";}?>"> n
			</td>
		</tr>
		<tr>
			<td style="white-space: nowrap;">Service notification period : <font color='red'>*</font> </td>
			<td class="text10b"  style="white-space: nowrap;">
			<select name="cct[timeperiod_tp_id2]">
			<?
				foreach ($oreon->time_periods as $tp)	{
					if ($tp->get_id() == $contacts[$contact_id]->get_service_notification_period())
						echo "<option value='" . $tp->get_id() . "' selected>" . $tp->get_name() . "</option>";
					else
						echo "<option value='" . $tp->get_id() . "'>" . $tp->get_name() . "</option>";
					unset($tp);
				}
			?>
			</select>
			</td>
		</tr>
		<? if (!strcmp($oreon->user->get_version(), "2")){ ?>
		<tr>
			<td colspan="2" style="white-space: nowrap;" align="center">
				<div class="text10b" align="center">
					Contact Groups
				</div>
				<table border="0">
					<tr>
						<td align="left" style="padding: 3px;">
							<select name="selectContactGroupBase" size="8" multiple>
							<?
								if (isset($contactGroups))	{
									foreach ($contactGroups as $contactGroup)	{
										if (!array_key_exists($contactGroup->get_id(), $contacts[$contact_id]->contact_groups))
											echo "<option value='".$contactGroup->get_id()."'>".$contactGroup->get_name()."</option>";
										unset($contactGroup);
									}
								}
							?>
							</select>
						</td>
						<td style="padding-left: 5px; padding-right: 5px;" valign="middle" align="center">
							<input type="button" name="add" value="<? echo $lang['add']; ?>" onClick="Moove(this.form.selectContactGroupBase,this.form.selectContactGroup)"><br><br><br>
							<input type="button" name="remove" value="<? echo $lang['delete']; ?>" onClick="Moove(this.form.selectContactGroup,this.form.selectContactGroupBase)">
						</td>
						<td>
							<select id="selectContactGroup" name="selectContactGroup[]" size="8" multiple>
							<?
								foreach ($contacts[$contact_id]->contact_groups as $existing_cg)	{
									echo "<option value='".$existing_cg->get_id()."'>".$existing_cg->get_name()."</option>";
									unset($existing_cg);
								}
							?>
							</select>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<? } ?>
		<tr>
			<td colspan="2" style="white-space: nowrap;">
				<div class="text10b" align="center">
					Host_notification_command <font color='red'>*</font>
				</div>
				<table border="0">
					<tr>
						<td align="left" style="padding: 3px;">
							<select name="selectHostCmdBase" size="8" multiple>
							<?
								if (isset($commands))	{
									foreach ($commands as $command)	{
										if (!strcmp($command->get_type(), "1"))
											if (!array_key_exists($command->get_id(), $contacts[$contact_id]->host_notification_commands))
												echo "<option value='".$command->get_id()."'>".$command->get_name()."</option>";
										unset($command);
									}
								}
							?>
							</select>
						</td>
						<td style="padding-left: 5px; padding-right: 5px;" valign="middle" align="center">
							<input type="button" name="add" value="<? echo $lang['add']; ?>" onClick="Moove(this.form.selectHostCmdBase,this.form.selectHostCmd)"><br><br><br>
							<input type="button" name="remove" value="<? echo $lang['delete']; ?>" onClick="Moove(this.form.selectHostCmd,this.form.selectHostCmdBase)">
						</td>
						<td>
							<select id="selectHostCmd" name="selectHostCmd[]" size="8" multiple>
							<?
								foreach ($contacts[$contact_id]->host_notification_commands as $existing_commands)	{
									echo "<option value='".$existing_commands->get_id()."'>".$existing_commands->get_name()."</option>";
									unset($existing_commands);
								}
							?>
							</select>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="white-space: nowrap;">
				<div class="text10b" align="center">
					Service_notification_command <font color='red'>*</font>
				</div>
				<table border="0">
					<tr>
						<td align="left" style="padding: 3px;">
							<select name="selectServiceCmdBase" size="8" multiple>
							<?
								if (isset($commands))	{
									foreach ($commands as $command)	{
										if (!strcmp($command->get_type(), "1"))
											if (!array_key_exists($command->get_id(), $contacts[$contact_id]->service_notification_commands))
												echo "<option value='".$command->get_id()."'>".$command->get_name()."</option>";
										unset($command);
									}
								}
							?>
							</select>
						</td>
						<td style="padding-left: 5px; padding-right: 5px;" valign="middle" align="center">
							<input type="button" name="add" value="<? echo $lang['add']; ?>" onClick="Moove(this.form.selectServiceCmdBase,this.form.selectServiceCmd)"><br><br><br>
							<input type="button" name="remove" value="<? echo $lang['delete']; ?>" onClick="Moove(this.form.selectServiceCmd,this.form.selectServiceCmdBase)">
						</td>
						<td>
							<select id="selectServiceCmd" name="selectServiceCmd[]" size="8" multiple>
							<?
								foreach ($contacts[$contact_id]->service_notification_commands as $existing_commands)	{
									echo "<option value='".$existing_commands->get_id()."'>".$existing_commands->get_name()."</option>";
									unset($existing_commands);
								}
							?>
							</select>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="white-space: nowrap;">Email  <font color='red'>*</font>: </td>
			<td class="text10b" style="white-space: nowrap;">
				<input type="text" name="cct[contact_email]" value="<? echo $contacts[$contact_id]->get_email(); ?>">

			</td>
		</tr>
		<tr>
			<td style="white-space: nowrap;">Pager : </td>
			<td class="text10b" style="white-space: nowrap;"><input type="text" name="cct[contact_pager]" value="<? echo $contacts[$contact_id]->get_pager(); ?>"></td>
		</tr>
		<tr>
			<td valign="top" style="white-space: nowrap;"><? echo $lang['status']; ?> :</td>
			<td class="text10b">
				<input type="radio" name="cct[contact_activate]" value="1" <? if ($contacts[$contact_id]->get_activate()) echo "checked"; ?>> <? echo $lang['enable']; ?>&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="radio" name="cct[contact_activate]" value="0" <? if (!$contacts[$contact_id]->get_activate()) echo "checked"; ?>> <? echo $lang['disable']; ?>
			</td>
		</tr>
		<tr>
			<td valign="top" style="white-space: nowrap;">Comment :</td>
			<td class="text10b">
				<textarea name="cct[contact_comment]" cols="25" rows="4"><? echo $contacts[$contact_id]->get_comment(); ?></textarea>
			</td>
		</tr>
		<tr>
			<td align="left">
				<? echo $lang['required']; ?>&nbsp;&nbsp;
			</td>
			<td align="center">
				<input type="hidden" name="cct[contact_id]" value="<? echo $contact_id ?>">
				<input type="submit" name="Changecontact" value="<? echo $lang['save']; ?>" onClick="selectAll(this.form.selectHostCmd); selectAll(this.form.selectServiceCmd); selectAll(this.form.selectContactGroup)">
			</td>
		</tr>
	</table>
</form>