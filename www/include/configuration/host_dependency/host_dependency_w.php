<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/?>
<table cellpadding="0" cellspacing="3" width="350" align='center'>
	<tr>
		<td valign="top" style="white-space: nowrap;" width="50%"><? echo $lang['h']; ?></td>
		<td class="text10b" valign="top"><? echo $hosts[$hds[$hd_id]->get_host()]->get_name(); ?></td>
	</tr>
	<tr>
		<td valign="top" style="white-space: nowrap;"><? echo $lang['h']; ?> dependent</td>
		<td class="text10b" valign="top"><? echo $hosts[$hds[$hd_id]->get_host_dependent()]->get_name(); ?></td>
	</tr>
	<? if (!strcmp ($oreon->user->get_version(), 1)) { ?>
	<tr>
		<td valign="top" style="white-space: nowrap;">Notification failure criteria</td>
		<td class="text10b" valign="top" nowrap><? echo $hds[$hd_id]->get_notification_failure_criteria(); ?></td>
	</tr>
	<? } ?>
	<? if (!strcmp ($oreon->user->get_version(), 2)) { ?>
	<tr>
		<td valign="top" style="white-space: nowrap;">Inherits parent</td>
		<td class="text10b" valign="top"><?  $str = $hds[$hd_id]->get_inherits_parent(); if (isset($str)) print $value_flag[$str];  ?></td>
	</tr>
	<tr>
		<td valign="top" style="white-space: nowrap;">Execution failure criteria</td>
		<td class="text10b" valign="top" nowrap><? echo $hds[$hd_id]->get_execution_failure_criteria(); ?></td>
	</tr>
	<tr>
		<td valign="top" style="white-space: nowrap;">Notification failure criteria</td>
		<td class="text10b" valign="top" nowrap><? echo $hds[$hd_id]->get_notification_failure_criteria(); ?></td>
	</tr>
	<? } ?>
	<tr>
		<td colspan="2" style="padding-top:25px" align="center" class="text10b">
			<a href="phpradmin.php?p=118&o=c&hd_id=<? echo $hd_id ?>" class="text10bc"><? echo $lang['modify']; ?></a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="phpradmin.php?p=118&o=d&hd_id=<? echo $hd_id ?>" class="text10bc" onclick="return confirm('<? echo $lang['confirm_removing']; ?>')"><? echo $lang["delete"]; ?></a>
		</td>
	</tr>
</table>