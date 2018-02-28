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
		<td class="text10b"><input type="text" name="cg[cg_name]" value=""></td>
	</tr>
	<tr>
		<td nowrap><? echo $lang['alias']; ?><font color='red'>*</font></td>
		<td class="text10b"><input type="text" name="cg[cg_alias]" value=""></td>
	</tr>
	<tr>
		<td colspan="2" align="center">
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
						</select>
					</td>
					</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td valign="top" style="white-space: nowrap;"><? echo $lang['status']; ?> :</td>
		<td class="text10b">
			<input type="radio" name="cg[cg_activate]" value="1" checked><? echo $lang['enable']; ?>&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="radio" name="cg[cg_activate]" value="0"><? echo $lang['disable']; ?>
		</td>
	</tr>
	<tr>
		<td valign="top" style="white-space: nowrap;">Comment :</td>
		<td class="text10b">
			<textarea name="cg[cg_comment]" cols="25" rows="4"></textarea>
		</td>
	</tr>
	<tr>
		<td align="left">
			<? echo $lang['required']; ?>&nbsp;&nbsp;
		</td>
		<td align="center">
		<input type="submit" name="AddCG" value="<? echo $lang['save']; ?>" onClick="selectAll(this.form.selectContact)">
		</td>
	</tr>
</table>
</form>