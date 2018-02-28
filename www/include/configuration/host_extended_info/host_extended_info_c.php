<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/?>
<form name="hei" action="" method="post" enctype="multipart/form-data">
<table  cellpadding="0" cellspacing="3" width="350" align='center'>
	<tr>
		<td style="white-space: nowrap;" width="50%">Host_name :<font color='red'>*</font></td>
		<td class="text10b">
			<? echo "<input type='hidden' name='ehi[host_host_id]' value='$ehis[$ehi_id]->get_host()'>";?>
			<? echo $hosts[$ehis[$ehi_id]->get_host()]->get_name(); ?>
		</td>
	</tr>
	<tr>
		<td style="white-space: nowrap;">Notes : </td>
		<td class="text10b">
			<input type="text" name="ehi[ehi_notes]" value="<?  echo $ehis[$ehi_id]->get_notes(); ?>">
		</td>
	</tr>
	<tr>
		<td style="white-space: nowrap;">Notes Url : </td>
		<td class="text10b">
			<input type="text" name="ehi[ehi_notes_url]" value="<? echo $ehis[$ehi_id]->get_notes_url(); ?>">
		</td>
	</tr>
	<? if ($oreon->user->get_version() == 2)	{ ?>
	<tr>
		<td style="white-space: nowrap;">Action Url : </td>
		<td class="text10b">
			<input type="text" name="ehi[ehi_action_url]" value="<? echo $ehis[$ehi_id]->get_action_url(); ?>">
		</td>
	</tr>
	<? } ?>
	<tr>
		<td style="white-space: nowrap;">Icon image : </td>
		<td class="text10b" style="white-space: nowrap;">
			<input id="ehi_icon_image" type="text" name="ehi[ehi_icon_image]" value="<? echo $ehis[$ehi_id]->get_icon_image(); ?>">
			&nbsp;<img src="img/help.gif" onClick="window.open('pictures.php?p=113&id=2','Pictures', 'toolbar=0,scrollbars=1,resizable=1,WIDTH=600,HEIGHT=500');return(false)">
		</td>
	</tr>
	<tr>
		<td style="white-space: nowrap;">Icon image alt : </td>
		<td class="text10b" style="white-space: nowrap;">
			<input type="text" name="ehi[ehi_icon_image_alt]" value="<? echo $ehis[$ehi_id]->get_icon_image_alt(); ?>">
		</td>
	</tr>
	<tr>
		<td style="white-space: nowrap;">Vrml image : </td>
		<td class="text10b" style="white-space: nowrap;">
			<input id="ehi_vrml_image" type="text" name="ehi[ehi_vrml_image]" value="<? echo $ehis[$ehi_id]->get_vrml_image(); ?>">
			&nbsp;<img src="img/help.gif" onClick="window.open('pictures.php?p=113&id=3','Pictures', 'toolbar=0,scrollbars=1,resizable=1,WIDTH=600,HEIGHT=500');return(false)">
		</td>
	</tr>
	<tr>
		<td style="white-space: nowrap;">Statusmap image : </td>
		<td class="text10b" style="white-space: nowrap;">
			<input id="ehi_statusmap_image" type="text" name="ehi[ehi_statusmap_image]" value="<? echo $ehis[$ehi_id]->get_statusmap_image(); ?>">
			&nbsp;<img src="img/help.gif" onClick="window.open('pictures.php?p=113&id=4','Pictures', 'toolbar=0,scrollbars=1,resizable=1,WIDTH=600,HEIGHT=500');return(false)">
		</td>
	</tr>
	<tr>
		<td style="white-space: nowrap;">2d coords : </td>
		<td class="text10b">
			<input type="text" name="ehi[ehi_d2_coords]" value="<? echo $ehis[$ehi_id]->get_d2_coords(); ?>">
		</td>
	</tr>
	<tr>
		<td style="white-space: nowrap;">3d coords : </td>
		<td class="text10b">
			<input type="text" name="ehi[ehi_d3_coords]" value="<? echo $ehis[$ehi_id]->get_d3_coords(); ?>">
		</td>
	</tr>
</table>
</div>
<div align="center" style="padding: 10px;">
	<input type="hidden" name="ehi[ehi_id]" value="<? echo $ehi_id ?>">
	<input type="submit" name="ChangeEHI" value="<? echo $lang['save']; ?>">
</div>
</form>