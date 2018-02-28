<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/?>
<form action="" method="post">
<table  cellpadding="0" cellspacing="3" width="500" border="0">
<tr>
	<td style="white-space: nowrap;padding-left:20px;" width="50%">Name :<font color='red'>*</font></td>
	<td class="text10b" align="center"><input type="text" name="sg[sg_name]" value=""></td>
</tr>
<tr>
	<td  style="white-space: nowrap;padding-left:20px;">Alias :<font color='red'>*</font></td>
	<td class="text10b" align="center"><input type="text" name="sg[sg_alias]" value=""></td>
</tr>
<tr>
	<td colspan="2" class="text10b" align="center">Service(s) <font color='red'>*</font></td>
</tr>
<tr>
	<td colspan="2" align="center" style="white-space: nowrap;">
		<table border="0">
		<tr>
			<td align="left" style="padding: 3px;">
				<select name="selectServiceBase" size="8" multiple>
				<?
					if (isset($hosts))
						foreach ($hosts as $host)	{
							if (isset($host->services))
								foreach ($host->services as $service)	{
									if ($service->get_register())
										echo "<option value='".$service->get_id()."'>".$hosts[$service->get_host()]->get_name()." / ".$service->get_description()."</option>";
									unset($service);
								}
							unset($host);
						}
					if (isset($services))
						foreach ($services as $service)	{
							if (!$service->get_register())
								echo "" ; //"<option value='".$service->get_id()."'>".$service->get_description()."</option>";
							unset($service);
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
				</select>
			</td>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td valign="top" style="white-space: nowrap;padding-left:20px;"><? echo $lang['status']; ?> :</td>
	<td class="text10b">
		<input type="radio" name="sg[sg_activate]" value="1" checked><? echo $lang['enable']; ?>&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="radio" name="sg[sg_activate]" value="0"><? echo $lang['disable']; ?>
	</td>
</tr>
<tr>
	<td valign="top" style="white-space: nowrap;padding-left:20px;">Comment :</td>
	<td class="text10b">
		<textarea name="sg[sg_comment]" cols="25" rows="4"></textarea>
	</td>
</tr>
<tr>
	<td align="left" style="padding-left:20px;"><? echo $lang['required']; ?>&nbsp;&nbsp;</td>
	<td align="center">
		<input type="submit" name="AddSG" value="<? echo $lang['save']; ?>" onClick="selectAll(this.form.selectService)">
	</td>
</tr>
</table>
</form>