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
<form name="sei" action="" method="post" enctype="multipart/form-data">
<table border="0" cellpadding="3" cellspacing="3">
	<tr>
		<td style="white-space: nowrap;">Host_name :<font color='red'>*</font></td>
		<td class="text10b">
			<? echo "<input type='hidden' name='esi[host_host_id]' value='$esis[$esi_id]->get_host()'>";?>
			<? echo $hosts[$esis[$esi_id]->get_host()]->get_name(); ?>
		</td>
	</tr>
	<tr>
		<td style="white-space: nowrap;">Service description :<font color='red'>*</font></td>
		<td class="text10b">
			<? echo "<input type='hidden' name='esi[service_service_id]' value='$esis[$esi_id]->get_service()'>";?>
			<? echo $services[$esis[$esi_id]->get_service()]->get_description(); ?>
		</td>
	</tr>
	<tr>
		<td style="white-space: nowrap;">Notes : </td>
		<td class="text10b">
			<input type="text" name="esi[esi_notes]" value="<?  echo $esis[$esi_id]->get_notes(); ?>">
		</td>
	</tr>
	<tr>
		<td style="white-space: nowrap;">Notes Url : </td>
		<td class="text10b">
			<input type="text" name="esi[esi_notes_url]" value="<? echo $esis[$esi_id]->get_notes_url(); ?>">
		</td>
	</tr>
	<tr>
		<td style="white-space: nowrap;">Action Url : </td>
		<td class="text10b">
			<input type="text" name="esi[esi_action_url]" value="<? echo $esis[$esi_id]->get_action_url(); ?>">
		</td>
	</tr>
	<tr>
		<td style="white-space: nowrap;">Icon image : </td>
		<td class="text10b" style="white-space: nowrap;">
			<input id="esi_icon_image" type="text" name="esi[esi_icon_image]" value="<? echo $esis[$esi_id]->get_icon_image(); ?>">
			<img src="img/help.gif" onClick="window.open('pictures.php?p=114&id=1','Pictures', 'toolbar=0,scrollbars=1,resizable=1,WIDTH=600,HEIGHT=500');return(false)">
		</td>
	</tr>
	<tr>
		<td style="white-space: nowrap;">Icon image alt : </td>
		<td class="text10b">
			<input type="text" name="esi[esi_icon_image_alt]" value="<? echo $esis[$esi_id]->get_icon_image_alt(); ?>">
		</td>
	</tr>
	<tr>
		<td align="left">
			<? echo $lang['required']; ?>&nbsp;&nbsp;
		</td>
		<td align="center">
			<input type="hidden" name="esi[esi_id]" value="<? echo $esi_id ?>">
			<input type="submit" name="ChangeESI" value="<? echo $lang['save']; ?>">
		</td>
	</tr>
</table>
</form>