<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/?>
<table cellpadding="0" cellspacing="3" width="350" align='center'>
	<tr>
		<td style="white-space: nowrap;" width="50%">Host_name :</td>
		<td class="text10b">
			<?
			if (isset($hosts[$ehis[$ehi_id]->get_host()]))
				echo $hosts[$ehis[$ehi_id]->get_host()]->get_name();
			?>
		</td>
	</tr>
	<tr>
		<td style="white-space: nowrap;">Notes :</td>
		<td class="text10b"><? echo $ehis[$ehi_id]->get_notes(); ?></td>
	</tr>
	<tr>
		<td style="white-space: nowrap;">Notes Url :</td>
		<td class="text10b"><? echo $ehis[$ehi_id]->get_notes_url(); ?></td>
	</tr>
	<? if ($oreon->user->get_version() == 2)	{ ?>
	<tr>
		<td style="white-space: nowrap;">Action Url :</td>
		<td class="text10b"><? echo $ehis[$ehi_id]->get_action_url(); ?></td>
	</tr>
	<? } ?>
	<tr>
		<td style="white-space: nowrap;">Icon image :</td>
		<td class="text10b"><? echo $ehis[$ehi_id]->get_icon_image(); ?></td>
	</tr>
	<tr>
		<td style="white-space: nowrap;">Icon image alt :</td>
		<td class="text10b"><? echo $ehis[$ehi_id]->get_icon_image_alt(); ?></td>
	</tr>
	<tr>
		<td style="white-space: nowrap;">Vrml image :</td>
		<td class="text10b"><? echo $ehis[$ehi_id]->get_vrml_image(); ?></td>
	</tr>
	<tr>
		<td style="white-space: nowrap;">Statusmap image :</td>
		<td class="text10b"><? echo $ehis[$ehi_id]->get_statusmap_image(); ?></td>
	</tr>
	<tr>
		<td style="white-space: nowrap;">2d coords :</td>
		<td class="text10b"><? echo $ehis[$ehi_id]->get_d2_coords(); ?></td>
	</tr>
	<tr>
		<td style="white-space: nowrap;">3d coords :</td>
		<td class="text10b"><? echo $ehis[$ehi_id]->get_d3_coords(); ?></td>
	</tr>
</table>
<div align="center" style="padding: 10px;">
	<a href="phpradmin.php?p=113&o=c&ehi_id=<? echo $ehi_id ?>" class="text10bc"><? echo $lang['modify']; ?></a>&nbsp;&nbsp;&nbsp;&nbsp;
	<a href="phpradmin.php?p=113&o=d&ehi_id=<? echo $ehi_id ?>" class="text10bc" onclick="return confirm('<? echo $lang['confirm_removing']; ?>')"><? echo $lang['delete']; ?></a>
</div>