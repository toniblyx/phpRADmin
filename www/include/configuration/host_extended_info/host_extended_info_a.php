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
		<td style="white-space: nowrap;" width="50%"><? echo $lang['h']; ?><font color='red'>*</font></td>
		<td class="text10b" valign="top">
			<select name="ehi[host_host_id]">
				<?
				foreach ($hosts as $host)	{
					if ($host->get_register())
						echo "<option value='".$host->get_id()."'>".$host->get_name()."</option>";
					unset($host);
				}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td style="white-space: nowrap;"><? echo $lang['ehi_notes']; ?></td>
		<td class="text10b" valign="top"><input type="text" name="ehi[ehi_notes]" value=""></td>
	</tr>
	<tr>
		<td style="white-space: nowrap;"><? echo $lang['ehi_notes_url']; ?></td>
		<td class="text10b" valign="top"><input type="text" name="ehi[ehi_notes_url]"></td>
	</tr>
	<? if ($oreon->user->get_version() == 2)	{ ?>
	<tr>
		<td style="white-space: nowrap;"><? echo $lang['ehi_action_url']; ?></td>
		<td class="text10b" valign="top"><input type="text" name="ehi[ehi_action_url]" value=""></td>
	</tr>
	<? } ?>
	<tr>
		<td style="white-space: nowrap;"><? echo $lang['ehi_icon_image']; ?></td>
		<td class="text10b" valign="top" style="white-space: nowrap;">
			<input id="ehi_icon_image" type="text" name="ehi[ehi_icon_image]">
			&nbsp;<img src="img/help.gif" onClick="window.open('pictures.php?p=113&id=2','Pictures', 'toolbar=0,scrollbars=1,resizable=1,WIDTH=600,HEIGHT=500');return(false)">
		</td>
	</tr>
	<tr>
		<td style="white-space: nowrap;"><? echo $lang['ehi_icon_image_alt']; ?></td>
		<td class="text10b" valign="top" style="white-space: nowrap;"><input type="text" name="ehi[ehi_icon_image_alt]" value=""></td>
	</tr>
	<tr>
		<td style="white-space: nowrap;">Vrml image : </td>
		<td class="text10b" valign="top" style="white-space: nowrap;">
			<input id="ehi_vrml_image" type="text" name="ehi[ehi_vrml_image]">
			&nbsp;<img src="img/help.gif" onClick="window.open('pictures.php?p=113&id=3','Pictures', 'toolbar=0,scrollbars=1,resizable=1,WIDTH=600,HEIGHT=500');return(false)">
		</td>
	</tr>
	<tr>
		<td style="white-space: nowrap;">Statusmap image : </td>
		<td class="text10b" valign="top" style="white-space: nowrap;">
			<input id="ehi_statusmap_image" type="text" name="ehi[ehi_statusmap_image]">
			&nbsp;<img src="img/help.gif" onClick="window.open('pictures.php?p=113&id=4','Pictures', 'toolbar=0,scrollbars=1,resizable=1,WIDTH=600,HEIGHT=500');return(false)">
		</td>
	</tr>
	<tr>
		<td style="white-space: nowrap;">2d coords : </td>
		<td class="text10b"><input type="text" name="ehi[ehi_d2_coords]"></td>
	</tr>
	<tr>
		<td style="white-space: nowrap;">3d coords : </td>
		<td class="text10b"><input type="text" name="ehi[ehi_d3_coords]"></td>
	</tr>
</table>
<div align="center" style="padding: 10px;">
	<table border="0" cellspacing="5" align="center">
		<tr>
			<td align="center">
				<input type="submit" name="AddEHI" value="<? echo $lang['save']; ?>">
			</td>
		</tr>
	</table>
</div>
</form>