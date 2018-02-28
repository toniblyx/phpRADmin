<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/?>
<form action="" method="post">
<table cellpadding="0" cellspacing="3" width="350" align='center'>
<tr>
	<td style="white-space: nowrap;" width="50%"><? echo $lang['name']; ?><font color='red'>*</font></td>
	<td class="text10b"><input type="text" name="sg[sg_name]" value="<? echo $serviceGroups[$sg]->get_name(); ?>"></td>
</tr>
<tr>
	<td style="white-space: nowrap;"><? echo $lang['alias']; ?><font color='red'>*</font></td>
	<td class="text10b"><input type="text" name="sg[sg_alias]" value="<? echo $serviceGroups[$sg]->get_alias(); ?>"></td>
</tr>
<tr>
	<td colspan="2">Service(s)<font color='red'>*</font></td>
</tr>
<tr>
	<td colspan="2" align="center" style="white-space: nowrap;">
	<table>
	<tr>
		<td align="left" style="padding: 3px;">
			<select name="selectServiceBase" size="8" multiple>
			<?
				if (isset($hosts))
					foreach ($hosts as $host)	{
						if (isset($host->services))
							foreach ($host->services as $service)	{
								if ($service->get_register() && !array_key_exists($service->get_id(), $serviceGroups[$sg]->services))
									echo "<option value='".$service->get_id()."'>".$hosts[$service->get_host()]->get_name()." / ".$service->get_description()."</option>";
								else if (!$service->get_register() && !array_key_exists($service->get_id(), $serviceGroups[$sg]->services))
									echo "<option value='".$service->get_id()."'>".$service->get_description()."</option>";
								unset($service);
							}
						unset($host);
					}
			?>
			</select>
		</td>
		<td style="padding-left: 5px; padding-right: 5px;" valign="middle" align="center">
			<input type="button" name="add" value="<? echo $lang['add']; ?>" onClick="Moove(this.form.selectServiceBase,this.form.selectService)"><br><br><br>
			<input type="button" name="remove" value="<? echo $lang['delete']; ?>" onClick="Moove(this.form.selectService,this.form.selectServiceBase)">
		</td>
		<td>
			<select id="selectService" name="selectService[]" size="8" multiple>
			<?
				foreach ($serviceGroups[$sg]->services as $existing_service)	{
					if ($existing_service->get_register())
						echo "<option value='".$existing_service->get_id()."'>".$hosts[$existing_service->get_host()]->get_name()." / ".$existing_service->get_description()."</option>";
					else
						echo "<option value='".$existing_service->get_id()."'>".$existing_service->get_description()."</option>";
					unset($existing_service);
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
		<input type="radio" name="sg[sg_activate]" value="1" <? if ($serviceGroups[$sg]->get_activate()) echo "checked"; ?>> <? echo $lang['enable']; ?>&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="radio" name="sg[sg_activate]" value="0" <? if (!$serviceGroups[$sg]->get_activate()) echo "checked"; ?>> <? echo $lang['disable']; ?>
	</td>
</tr>
<tr>
	<td valign="top" style="white-space: nowrap;">Comment :</td>
	<td class="text10b">
		<textarea name="sg[sg_comment]" cols="25" rows="4"><? echo $serviceGroups[$sg]->get_comment(); ?></textarea>
	</td>
</tr>
<tr>
	<td align="left">
		<? echo $lang['required']; ?>&nbsp;&nbsp;
	</td>
	<td align="center">
		<input type="hidden" name="sg[sg_id]" value="<? echo $sg ?>">
		<input type="submit" name="Changesg" value="<? echo $lang['save']; ?>" onClick="selectAll(this.form.selectService)">
	</td>
</tr>
</table>
</form>