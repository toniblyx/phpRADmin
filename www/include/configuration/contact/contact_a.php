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
		<td style="white-space: nowrap;"><? echo $lang['name']; ?><font color='red'>*</font></td>
		<td class="text10b"><input type="text" name="cct[contact_name]" value=""></td>
	</tr>
	<tr>
		<td style="white-space: nowrap;"><? echo $lang['alias']; ?><font color='red'>*</font></td>
		<td class="text10b"><input type="text" name="cct[contact_alias]" value=""></td>
	</tr>
	<tr>
		<td style="white-space: nowrap;">Host Notification options :<font color='red'>*</font></td>
		<td style="padding: 3px; white-space: nowrap;">
			<input ONMOUSEOVER="montre_legende('Down', '');" ONMOUSEOUT="cache_legende();" name="cct[contact_host_notification_options_d]" type="checkbox" value="d" id="contact_host_notification_options_d"> d -
			<input ONMOUSEOVER="montre_legende('Unreachable', '');" ONMOUSEOUT="cache_legende();" name="cct[contact_host_notification_options_u]" type="checkbox" value="u" id="contact_host_notification_options_u"> u -
			<input ONMOUSEOVER="montre_legende('Recovery', '');" ONMOUSEOUT="cache_legende();" name="cct[contact_host_notification_options_r]" type="checkbox" value="r" id="contact_host_notification_options_r"> r -
			<? if (!strcmp($oreon->user->get_version(), "2")){ ?>
			<input ONMOUSEOVER="montre_legende('Flapping', '');" ONMOUSEOUT="cache_legende();" name="cct[contact_host_notification_options_f]" type="checkbox" value="f" id="contact_host_notification_options_f"> f -
			<? } ?>
			<input ONMOUSEOVER="montre_legende('None', '');" ONMOUSEOUT="cache_legende();" name="cct[contact_host_notification_options_n]" type="checkbox" value="n" onClick="<? if ($oreon->user->get_version() == 2){echo "enabledOptionsCheck(contact_host_notification_options_f);";} ?> enabledOptionsCheck(contact_host_notification_options_d);enabledOptionsCheck(contact_host_notification_options_u);enabledOptionsCheck(contact_host_notification_options_r);"> n
		</td>
	</tr>
	<tr>
		<td style="white-space: nowrap;">Host notification period :<font color='red'>*</font> </td>
		<td class="text10b">
		<select name="cct[timeperiod_tp_id]">
		<?
			foreach ($time_periods as $tp)	{
				echo "<option value='".$tp->get_id()."'>" . $tp->get_name() . "</option>";
				unset($tp);
			}
		?>
		</select>
		</td>
	</tr>
	<tr>
		<td style="white-space: nowrap;">Service Notification options :<font color='red'>*</font> </td>
		<td style="padding: 3px; white-space: nowrap;">
			<input ONMOUSEOVER="montre_legende('Warning', '');" ONMOUSEOUT="cache_legende();" name="cct[contact_service_notification_options_w]" type="checkbox" value="w" id="contact_service_notification_options_w"> w -
			<input ONMOUSEOVER="montre_legende('Unknow', '');" ONMOUSEOUT="cache_legende();" name="cct[contact_service_notification_options_u]" type="checkbox" value="u" id="contact_service_notification_options_u"> u -
			<input ONMOUSEOVER="montre_legende('Critical', '');" ONMOUSEOUT="cache_legende();" name="cct[contact_service_notification_options_c]" type="checkbox" value="c" id="contact_service_notification_options_c"> c -
			<input ONMOUSEOVER="montre_legende('Recovery', '');" ONMOUSEOUT="cache_legende();" name="cct[contact_service_notification_options_r]" type="checkbox" value="r" id="contact_service_notification_options_r"> r -
			<? if (!strcmp($oreon->user->get_version(), "2")){ ?>
			<input ONMOUSEOVER="montre_legende('Flapping', '');" ONMOUSEOUT="cache_legende();" name="cct[contact_service_notification_options_f]" type="checkbox" value="f" id="contact_service_notification_options_f"> f -
			<? } ?>
			<input ONMOUSEOVER="montre_legende('None', '');" ONMOUSEOUT="cache_legende();" name="cct[contact_service_notification_options_n]" type="checkbox" value="n" onClick="<? if ($oreon->user->get_version() == 2){echo "enabledOptionsCheck(contact_service_notification_options_f);";} ?> enabledOptionsCheck(contact_service_notification_options_r);enabledOptionsCheck(contact_service_notification_options_c);enabledOptionsCheck(contact_service_notification_options_u);enabledOptionsCheck(contact_service_notification_options_w);"> n
		</td>
	</tr>
	<tr>
		<td style="white-space: nowrap;">Service notification period :<font color='red'>*</font> </td>
		<td class="text10b">
		<select name="cct[timeperiod_tp_id2]">
		<?
			foreach ($time_periods as $tp)	{
				echo "<option value='".$tp->get_id()."'>" . $tp->get_name() . "</option>";
				unset($tp);
			}
		?>
		</select>
		</td>
	</tr>
	<? if (!strcmp($oreon->user->get_version(), "2")){ ?>
	<tr>
		<td colspan="2">
			<div align="center" class="text10b">
				Contact Groups
			</div>
			<table border="0">
				<tr>
					<td align="left" style="padding: 3px;">
						<select name="selectContactGroupBase" size="8" multiple>
						<?
							if (isset($contactGroups))
								foreach ($contactGroups as $contactGroup)	{
									echo "<option value='".$contactGroup->get_id()."'>".$contactGroup->get_name()."</option>";
									unset($contactGroup);
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
						</select>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<? } ?>
	<tr>
		<td colspan="2" style="white-space: nowrap;">
			<div align="center" class="text10b">
				Host_notification_command <font color='red'>*</font>
			</div>
			<table border="0">
				<tr>
					<td align="left" style="padding: 3px;">
						<select name="selectHostCmdBase" size="8" multiple>
						<?
							if (isset($commands))
								foreach ($commands as $command)	{
									if (!strcmp($command->get_type(), "1"))
										if (!array_key_exists($command->get_id(), $contacts[$contact_id]->service_notification_commands))
											echo "<option value='".$command->get_id()."'>".$command->get_name()."</option>";
									unset($command);
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
						</select>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2" style="white-space: nowrap;">
			<div align="center" class="text10b">
				Service_notification_command <font color='red'>*</font>
			</div>
			<table border="0">
				<tr>
					<td align="left" style="padding: 3px;">
						<select name="selectServiceCmdBase" size="8" multiple>
						<?
							if (isset($commands))
								foreach ($commands as $command)	{
									if (!strcmp($command->get_type(),"1"))
										if (!array_key_exists($command->get_id(), $contacts[$contact_id]->service_notification_commands))
											echo "<option value='".$command->get_id()."'>".$command->get_name()."</option>";
									unset($command);
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
						</select>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td style="white-space: nowrap;">Email  <font color='red'>*</font>: </td>
		<td class="text10b"><input type="text" name="cct[contact_email]" value=""></td>
	</tr>
	<tr>
		<td style="white-space: nowrap;">Pager : </td>
		<td class="text10b"><input type="text" name="cct[contact_pager]" value=""></td>
	</tr>
	<tr>
		<td valign="top" style="white-space: nowrap;"><? echo $lang['status']; ?> :</td>
		<td class="text10b">
			<input type="radio" name="cct[contact_activate]" value="1" checked><? echo $lang['enable']; ?>&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="radio" name="cct[contact_activate]" value="0"><? echo $lang['disable']; ?>
		</td>
	</tr>
	<tr>
		<td valign="top" style="white-space: nowrap;">Comment :</td>
		<td class="text10b">
			<textarea name="cct[contact_comment]" cols="25" rows="4"></textarea>
		</td>
	</tr>
	<tr>
		<td align="left">
			<? echo $lang['required']; ?>&nbsp;&nbsp;
		</td>
		<td align="center">
			<input type="submit" name="AddContact" value="<? echo $lang['save']; ?>" onClick="selectAll(this.form.selectServiceCmd); selectAll(this.form.selectHostCmd); selectAll(this.form.selectContactGroup)">
		</td>
	</tr>
</table>
</form>