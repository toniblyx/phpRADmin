<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/?>
<form action="" method="post">
	<table border="0" cellpadding="3" cellspacing="3">
		<tr>
			<td nowrap><? echo $lang['name']; ?><font color='red'>*</font></td>
			<td class="text10b"><input type="text" name="cg[cg_name]" value="<? echo $contactGroups[$cg]->get_name(); ?>"></td>
		</tr>
		<tr>
			<td nowrap><? echo $lang['alias']; ?><font color='red'>*</font></td>
			<td class="text10b"><input type="text" name="cg[cg_alias]" value="<? echo $contactGroups[$cg]->get_alias(); ?>"></td>
		</tr>
		<tr>
			<td align="center" colspan="2" valign="top">
				<div align="center" class="text10b">
					Contacts<font color='red'>*</font>
				</div>
				<table>
					<tr>
						<td align="left" style="padding: 3px;">
							<select name="selectContactBase" size="8" multiple>
							<?
								if (isset($contacts))	{
									foreach ($contacts as $contact)	{
										if (!array_key_exists($contact->get_id(), $contactGroups[$cg]->contacts))
											echo "<option value='".$contact->get_id()."'>".$contact->get_name()."</option>";
										unset($contact);
									}
								}
							?>
							</select>
						</td>
						<td style="padding-left: 5px; padding-right: 5px;" valign="middle" align="center">
							<input type="button" name="add" value="<? echo $lang['add']; ?>" onClick="Moove(this.form.selectContactBase,this.form.selectContact)"><br><br><br>
							<input type="button" name="remove" value="<? echo $lang['delete']; ?>" onClick="Moove(this.form.selectContact,this.form.selectContactBase)">
						</td>
						<td>
							<select id="selectContact" name="selectContact[]" size="8" multiple>
							<?
								foreach ($contactGroups[$cg]->contacts as $existing_contact)	{
									echo "<option value='".$existing_contact->get_id()."'>".$existing_contact->get_name()."</option>";
									unset($existing_contact);
								}
							?>
							</select>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td valign="top" style="white-space: nowrap;"><? echo $lang['status']; ?> :</td>
			<td class="text10b">
				<input type="radio" name="cg[cg_activate]" value="1" <? if ($contactGroups[$cg]->get_activate()) echo "checked"; ?>> <? echo $lang['enable']; ?>&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="radio" name="cg[cg_activate]" value="0" <? if (!$contactGroups[$cg]->get_activate()) echo "checked"; ?>> <? echo $lang['disable']; ?>
			</td>
		</tr>
		<tr>
			<td valign="top" style="white-space: nowrap;">Comment :</td>
			<td class="text10b">
				<textarea name="cg[cg_comment]" cols="25" rows="4"><? echo $contactGroups[$cg]->get_comment(); ?></textarea>
			</td>
		</tr>
		<tr>
			<td align="left">
				<? echo $lang['required']; ?>&nbsp;&nbsp;
			</td>
			<td align="center">
			<input type="hidden" name="cg[cg_id]" value="<? echo $cg ?>">
			<input type="submit" name="Changecg" value="<? echo $lang['save']; ?>" onClick="selectAll(this.form.selectContact)">
			</td>
		</tr>
	</table>
	</form>