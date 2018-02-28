<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/?>
<table align="center" border="0" cellpadding="3" cellspacing="3">
	<tr>
		<td valign="top" nowrap><? echo $lang['h']; ?></td>
		<td class="text10b" valign="top"><? echo $hosts[$sds[$sd_id]->get_host()]->get_name(); ?></td>
	</tr>
	<tr>
		<td valign="top" nowrap><? echo $lang['s']; ?></td>
		<td class="text10b" valign="top"><? echo $services[$sds[$sd_id]->get_service()]->get_description(); ?></td>
	</tr>
	<tr>
		<td valign="top" nowrap><? echo $lang['h']; ?> dependent</td>
		<td class="text10b" valign="top"><? echo $hosts[$sds[$sd_id]->get_host_dependent()]->get_name(); ?></td>
	</tr>
	<tr>
		<td valign="top" nowrap><? echo $lang['s']; ?> dependent</td>
		<td class="text10b" valign="top"><? echo $services[$sds[$sd_id]->get_service_dependent()]->get_description(); ?></td>
	</tr>
	<? if (!strcmp ($oreon->user->get_version(), 2)) { ?>
	<tr>
		<td valign="top" nowrap>Inherits parent</td>
		<td class="text10b" valign="top"><?  $str = $sds[$sd_id]->get_inherits_parent(); if (isset($str)) print $value_flag[$str];  ?></td>
	</tr>
	<? } ?>
	<tr>
		<td valign="top" nowrap>Execution failure criteria</td>
		<td class="text10b" valign="top" nowrap><? echo $sds[$sd_id]->get_execution_failure_criteria(); ?></td>
	</tr>
	<tr>
		<td valign="top" nowrap>Notification failure criteria</td>
		<td class="text10b" valign="top" nowrap><? echo $sds[$sd_id]->get_notification_failure_criteria(); ?></td>
	</tr>
	<tr>
		<td colspan="2" style="padding-top:25px" align="center" class="text10b">
			<a href="phpradmin.php?p=119&o=c&sd_id=<? echo $sd_id ?>" class="text10bc"><? echo $lang['modify']; ?></a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="phpradmin.php?p=119&o=d&sd_id=<? echo $sd_id ?>" class="text10bc" onclick="return confirm('<? echo $lang['confirm_removing']; ?>')"><? echo $lang["delete"]; ?></a>
		</td>
	</tr>
</table>