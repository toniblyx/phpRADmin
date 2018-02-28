<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/?>
<form action="" method="post">
<table  cellpadding="0" cellspacing="3" width="350" align='center'>
	<tr>
		<td class="text10b" style="white-space: nowrap;" width="50%">HostGroup<font color='red'>*</font></td>
		<td style="padding: 3px;">
		<select name="hge[hostgroup_hg_id]">
		<?
			if (isset($hostGroups))	{
				foreach ($hostGroups as $hostGroup)	{
					echo "<option value='".$hostGroup->get_id()."'";
					if ($hostGroup->get_id() == $hges[$hge_id]->get_hostGroup())
						echo " selected";
					echo ">".$hostGroup->get_name()."</option>";
					unset($hostGroup);
				}
			}
		?>
		</select>
		</td>
	</tr>
	<tr>
		<td class="text10b" style="white-space: nowrap;">first_notification<font color='red'>*</font></td>
		<td class="text10b"><input size="5" type="text" name="hge[hge_first_notification]" value="<? echo $hges[$hge_id]->get_first_notification(); ?>"></td>
	</tr>
	<tr>
		<td class="text10b" style="white-space: nowrap;">last_notification<font color='red'>*</font></td>
		<td class="text10b"><input size="5" type="text" name="hge[hge_last_notification]" value="<? echo preg_replace("/(99999)/", "0", $hges[$hge_id]->get_last_notification()); ?>"></td>
	</tr>
	<tr>
		<td class="text10b" style="white-space: nowrap;">notification_interval<font color='red'>*</font></td>
		<td class="text10b"><input size="5" type="text" name="hge[hge_notification_interval]" value="<?  echo preg_replace("/(99999)/", "0", $hges[$hge_id]->get_notification_interval()); ?>"> <? echo " * ".$oreon->Nagioscfg->get_interval_length()." ".$lang["time_sec"]; ?></td>
	</tr>
	<tr>
		<td colspan="2" style="white-space: nowrap;">
			<table border="0" align="center">
				<tr>
					<td colspan="3" align="center" class="text10b" style="padding:20px">
						Contact Group<font color='red'>*</font>
					</td>
				</tr>
				<tr>
					<td align="left" style="padding: 3px;">
						<select name="selectContactGroupBase" size="8" multiple>
						<?
							if (isset($contactGroups))
								foreach ($contactGroups as $contactGroup)	{
									if (!array_key_exists($contactGroup->get_id(), $hges[$hge_id]->contactGroups))
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
							<?
								foreach ($hges[$hge_id]->contactGroups as $existing_contactGroup)	{
									echo "<option value='".$existing_contactGroup->get_id()."'>".$existing_contactGroup->get_name()."</option>";
									unset($existing_contactGroup);
								}
							?>
						</select>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align="left">
			<? echo $lang['required']; ?>&nbsp;&nbsp;
		</td>
		<td align="center">
			<input type="hidden" name="hge[hge_id]" value="<? echo $hge_id; ?>">
			<input type="submit" name="ChangeHGE" value="<? echo $lang['save']; ?>" onClick="selectAll(this.form.selectContactGroup);">
		</td>
	</tr>
</table>
</form>