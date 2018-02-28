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
<table border="0" cellpadding="3" cellspacing="3">
	<tr>
		<td style="white-space: nowrap;">Host_name : </td>
		<td class="text10b" style="white-space: nowrap; <? if (!$hosts[$services[$esis[$esi_id]->get_service()]->get_host()]->get_activate()) echo "text-decoration: line-through;"; ?>">
			<?
			if (isset($hosts[$esis[$esi_id]->get_host()]))
				echo $hosts[$esis[$esi_id]->get_host()]->get_name();
			?>
		</td>
	</tr>
	<tr>
		<td style="white-space: nowrap;">Service description : </td>
		<td class="text10b" style="white-space: nowrap;"><? echo $services[$esis[$esi_id]->get_service()]->get_description(); ?></td>
	</tr>
	<tr>
		<td style="white-space: nowrap;">Notes : </td>
		<td class="text10b" style="white-space: nowrap;"><? echo $esis[$esi_id]->get_notes(); ?></td>
	</tr>
	<tr>
		<td style="white-space: nowrap;">Notes Url : </td>
		<td class="text10b" style="white-space: nowrap;"><? echo $esis[$esi_id]->get_notes_url(); ?></td>
	</tr>
	<tr>
		<td style="white-space: nowrap;">Action Url : </td>
		<td class="text10b" style="white-space: nowrap;"><? echo $esis[$esi_id]->get_action_url(); ?></td>
	</tr>
	<tr>
		<td style="white-space: nowrap;">Icon image : </td>
		<td class="text10b" style="white-space: nowrap;"><? echo $esis[$esi_id]->get_icon_image(); ?></td>
	</tr>
	<tr>
		<td style="white-space: nowrap;">Icon image alt : </td>
		<td class="text10b" style="white-space: nowrap;"><? echo $esis[$esi_id]->get_icon_image_alt(); ?></td>
	</tr>
</table>
<div align="center" style="padding: 10px;">
	<a href="phpradmin.php?p=114&o=c&esi_id=<? echo $esi_id ?>" class="text10bc"><? echo $lang['modify']; ?></a>&nbsp;&nbsp;&nbsp;&nbsp;
	<a href="phpradmin.php?p=114&o=d&esi_id=<? echo $esi_id ?>" class="text10bc" onclick="return confirm('<? echo $lang['confirm_removing']; ?>')"><? echo $lang['delete']; ?></a>
</div>