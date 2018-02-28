<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/?>
<form action="" method="post">
<table border="0"  cellpadding="0" cellspacing="0" width="350" align='center'>
	<tr>
		<td style="white-space: nowrap;" width='50%'><? echo $lang['name']; ?><font color='red'>*</font></td>
		<td class="text10b"><input type="text" name="hg[hg_name]" value="<? echo $hostGroups[$hg]->get_name(); ?>"></td>
	</tr>
	<tr>
		<td style="white-space: nowrap;"><? echo $lang['alias']; ?><font color='red'>*</font></td>
		<td class="text10b"><input type="text" name="hg[hg_alias]" value="<? echo $hostGroups[$hg]->get_alias(); ?>"></td>
	</tr>
	<tr>
		<td colspan="2" height="25" align="center"><b><? echo $lang['h'] ?></b><font color='red'>*</font></td>
	</tr>
	<tr>
		<td colspan="2" align="center" style="white-space: nowrap;">
		<table>
		<tr>
			<td align="left" style="padding: 3px;">
				<select name="selectHostBase" size="8" multiple>
				<?
					if (isset($hosts))
						foreach ($hosts as $host)	{
							if (!array_key_exists($host->get_id(), $hostGroups[$hg]->hosts))
								echo "<option value='".$host->get_id()."'>".$host->get_name()."</option>";
							unset($host);
						}
				?>
				</select>
			</td>
			<td style="padding-left: 5px; padding-right: 5px;" valign="middle" align="center">
				<input type="button" name="add" value="<? echo $lang['add']; ?>" onClick="Moove(this.form.selectHostBase,this.form.selectHost)"><br><br><br>
				<input type="button" name="remove" value="<? echo $lang['delete']; ?>" onClick="Moove(this.form.selectHost,this.form.selectHostBase)">
			</td>
			<td>
				<select id="selectHost" name="selectHost[]" size="8" multiple>
				<?
					foreach ($hostGroups[$hg]->hosts as $existing_host)	{
						echo "<option value='".$existing_host->get_id()."'>".$existing_host->get_name()."</option>";
						unset($existing_host);
					}
				?>
				</select>
			</td>
		</tr>
		</table>
		</td>
	</tr>
	<? if (!strcmp($oreon->user->get_version(), "1")) {?>
	<tr>
		<td colspan="2" height="25" align="center"><b><? echo $lang['cg'] ?></b><font color='red'>*</font></td>
	</tr>
	<tr>
		<td colspan="2" align="center" style="white-space: nowrap;">
		<table>
		<tr>
			<td align="left" style="padding: 3px;">
				<select name="selectCGBase" size="8" multiple>
				<?
					if (isset($oreon->contactGroups))
						foreach ($oreon->contactGroups as $cg)	{
							if (!array_key_exists($cg->get_id(), $hostGroups[$hg]->contact_groups))
								echo "<option value='".$cg->get_id()."'>".$cg->get_name()."</option>";
							unset($cg);
						}
				?>
				</select>
			</td>
			<td style="padding-left: 5px; padding-right: 5px;" valign="middle" align="center">
				<input type="button" name="add" value="<? echo $lang['add']; ?>" onClick="Moove(this.form.selectCGBase,this.form.selectCG)"><br><br><br>
				<input type="button" name="remove" value="<? echo $lang['delete']; ?>" onClick="Moove(this.form.selectCG,this.form.selectCGBase)">
			</td>
			<td>
				<select id="selectCG" name="selectCG[]" size="8" multiple>
				<?
					if (isset($oreon->hostGroups[$hg]->contact_groups))
						foreach ($oreon->hostGroups[$hg]->contact_groups as $existing_cg)	{
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
		<td valign="top" style="white-space: nowrap;"><? echo $lang['status']; ?> :</td>
		<td class="text10b">
			<input type="radio" name="hg[hg_activate]" value="1" <? if ($hostGroups[$hg]->get_activate()) echo "checked"; ?>> <? echo $lang['enable']; ?>&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="radio" name="hg[hg_activate]" value="0" <? if (!$hostGroups[$hg]->get_activate()) echo "checked"; ?>> <? echo $lang['disable']; ?>
		</td>
	</tr>
	<tr>
		<td valign="top" style="white-space: nowrap;">Comment :</td>
		<td class="text10b">
			<textarea name="hg[hg_comment]" cols="25" rows="4"><? echo $hostGroups[$hg]->get_comment(); ?></textarea>
		</td>
	</tr>
	<tr>
		<td align="left">
			<? echo $lang['required']; ?>&nbsp;&nbsp;
		</td>
		<td align="center">
			<input type="hidden" name="hg[hg_id]" value="<? echo $hg ?>">
			<input type="submit" name="ChangeHG" value="<? echo $lang['save']; ?>" onClick="selectAll(this.form.selectHost);selectAll(this.form.selectCG);">
		</td>
	</tr>
</table>
</form>