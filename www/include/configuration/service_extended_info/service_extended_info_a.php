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
	if (isset($_POST["esi"]))
		$esi = & $_POST["esi"];
?>
<form name="sei" action="" method="post" enctype="multipart/form-data">
	<table border="0" cellpadding="3" cellspacing="3">
		<tr>
			<td valign="top" style="white-space: nowrap;"><? echo $lang['h']; ?><font color='red'>*</font></td>
			<td class="text10b" valign="top">
				<select name="esi[host_host_id]" onChange="this.form.submit();">
					<option value=""></option>
					<?
					foreach ($hosts as $host)	{
						if ($host->get_register())	{
							echo "<option value='".$host->get_id()."'";
							if (isset($_POST["esi"]) && ($host->get_id() == $esi["host_host_id"]))
								echo " selected";
							echo ">".$host->get_name()."</option>";
						}
						unset($host);
					}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td valign="top" style="white-space: nowrap;"><? echo $lang['s']; ?><font color='red'>*</font></td>
			<td class="text10b" valign="top">
				<select name="esi[service_service_id]" <? if (!isset($_POST["esi"])) echo " disabled"; ?>>
					<?
					if (isset($esi["host_host_id"]) && isset($hosts[$esi["host_host_id"]]->services))
						foreach ($hosts[$esi["host_host_id"]]->services as $service)	{
							if ($service->get_register())
								echo "<option value='".$service->get_id()."'>".$service->get_description()."</option>";
							unset($service);
						}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td valign="top" style="white-space: nowrap;"><? echo $lang['esi_notes']; ?></td>
			<td class="text10b" valign="top"><input type="text" name="esi[esi_notes]" value="" <? if (!isset($_POST["esi"])) echo " disabled"; ?>></td>
		</tr>
		<tr>
			<td valign="top" style="white-space: nowrap;"><? echo $lang['esi_notes_url']; ?></td>
			<td class="text10b" valign="top"><input type="text" name="esi[esi_notes_url]" value="" <? if (!isset($_POST["esi"])) echo " disabled"; ?>></td>
		</tr>
		<tr>
			<td valign="top" style="white-space: nowrap;"><? echo $lang['esi_action_url']; ?></td>
			<td class="text10b" valign="top"><input type="text" name="esi[esi_action_url]" value="" <? if (!isset($_POST["esi"])) echo " disabled"; ?>></td>
		</tr>
		<tr>
			<td valign="top" style="white-space: nowrap;"><? echo $lang['esi_icon_image']; ?></td>
			<td class="text10b" valign="top" style="white-space: nowrap;">
				<input id="esi_icon_image" type="text" name="esi[esi_icon_image]" <? if (!isset($_POST["esi"])) echo " disabled"; ?>>
				<? if (isset($_POST["esi"])) { ?>
				&nbsp;<img src="img/help.gif" onClick="window.open('pictures.php?p=114&id=1','Pictures', 'toolbar=0,scrollbars=1,resizable=1,WIDTH=600,HEIGHT=500');return(false)">
				<? } ?>
			</td>
		</tr>
		<tr>
			<td valign="top" style="white-space: nowrap;"><? echo $lang['esi_icon_image_alt']; ?></td>
			<td class="text10b" valign="top"><input type="text" name="esi[esi_icon_image_alt]" value="" <? if (!isset($_POST["esi"])) echo " disabled"; ?>></td>
		</tr>
		<tr>
			<td align="left">
				<? echo $lang['required']; ?>&nbsp;&nbsp;
			</td>
			<td align="center">
				<input type="submit" name="AddESI" value="<? echo $lang['save']; ?>" <? if (!isset($_POST["esi"])) echo " disabled"; ?>>
			</td>
		</tr>
	</table>
</form>