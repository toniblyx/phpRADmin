<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/?>
<table border="0" cellpadding="3" cellspacing="3">
	<tr>
		<td nowrap><? echo $lang['tp_name']; ?></td>
		<td class="text10b" nowrap><? echo $time_periods[$tp]->get_name(); ?></td>
	</tr>
	<tr>
		<td><? echo $lang['tp_alias']; ?></td>
		<td class="text10b" nowrap><? echo $time_periods[$tp]->get_alias(); ?></td>
	</tr>
	<tr>
		<td><? echo $lang['tp_sunday']; ?></td>
		<td class="text10b" nowrap><? echo $time_periods[$tp]->get_sunday(); ?></td>
	</tr>
	<tr>
		<td><? echo $lang['tp_monday']; ?></td>
		<td class="text10b" nowrap><? echo $time_periods[$tp]->get_monday(); ?></td>
	</tr>
	<tr>
		<td><? echo $lang['tp_tuesday']; ?></td>
		<td class="text10b" nowrap><? echo $time_periods[$tp]->get_tuesday(); ?></td>
	</tr>
	<tr>
		<td><? echo $lang['tp_wednesday']; ?></td>
		<td class="text10b" nowrap><? echo $time_periods[$tp]->get_wednesday(); ?></td>
	</tr>
	<tr>
		<td><? echo $lang['tp_thursday']; ?></td>
		<td class="text10b" nowrap><? echo $time_periods[$tp]->get_thursday(); ?></td>
	</tr>
	<tr>
		<td><? echo $lang['tp_friday']; ?></td>
		<td class="text10b" nowrap><? echo $time_periods[$tp]->get_friday(); ?></td>
	</tr>
	<tr>
		<td><? echo $lang['tp_saturday']; ?></td>
		<td class="text10b" nowrap><? echo $time_periods[$tp]->get_saturday(); ?></td>
	</tr>
	<tr>
		<td colspan="2" align="center" height="35" valign="bottom">
		<a href="phpradmin.php?p=108&o=c&tp=<? echo $tp ?>" class="text10bc"><? echo $lang['modify']; ?></a>&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="phpradmin.php?p=108&o=d&tp=<? echo $tp ?>" class="text10bc" onclick="return confirm('<? echo $lang['confirm_removing']; ?>')"><? echo $lang['delete']; ?></a>
		</td>
	</tr>
</table>