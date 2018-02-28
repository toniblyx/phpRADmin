<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/?>
<form action="" method="post">
<table border="0" cellpadding="3" cellspacing="3">
	<tr>
		<td nowrap><? echo $lang['tp_name']; ?><font color='red'>*</font></td>
		<td class="text10b"><input type="text" name="time_period[tp_name]" value="<? echo $time_periods[$tp]->get_name(); ?>"></td>
	</tr>
	<tr>
		<td nowrap><? echo $lang['tp_alias']; ?><font color='red'>*</font></td>
		<td class="text10b"><input type="text" name="time_period[tp_alias]" value="<? echo $time_periods[$tp]->get_alias(); ?>"></td>
	</tr>
	<tr>
		<td nowrap><? echo $lang['tp_sunday']; ?></td>
		<td class="text10b"><input type="text" name="time_period[tp_sunday]" value="<? echo $time_periods[$tp]->get_sunday(); ?>"></td>
	</tr>
	<tr>
		<td nowrap><? echo $lang['tp_monday']; ?></td>
		<td class="text10b"><input type="text" name="time_period[tp_monday]" value="<? echo $time_periods[$tp]->get_monday(); ?>"></td>
	</tr>
	<tr>
		<td nowrap><? echo $lang['tp_tuesday']; ?></td>
		<td class="text10b"><input type="text" name="time_period[tp_tuesday]" value="<? echo $time_periods[$tp]->get_tuesday(); ?>"></td>
	</tr>
	<tr>
		<td nowrap><? echo $lang['tp_wednesday']; ?></td>
		<td class="text10b"><input type="text" name="time_period[tp_wednesday]" value="<? echo $time_periods[$tp]->get_wednesday(); ?>"></td>
	</tr>
	<tr>
		<td nowrap><? echo $lang['tp_thursday']; ?></td>
		<td class="text10b"><input type="text" name="time_period[tp_thursday]" value="<? echo $time_periods[$tp]->get_thursday(); ?>"></td>
	</tr>
	<tr>
		<td nowrap><? echo $lang['tp_friday']; ?></td>
		<td class="text10b"><input type="text" name="time_period[tp_friday]" value="<? echo $time_periods[$tp]->get_friday(); ?>"></td>
	</tr>
	<tr>
		<td nowrap><? echo $lang['tp_saturday']; ?></td>
		<td class="text10b"><input type="text" name="time_period[tp_saturday]" value="<? echo $time_periods[$tp]->get_saturday(); ?>"></td>
	</tr>
	<tr>
		<td align="left">
			<? echo $lang['required']; ?>&nbsp;&nbsp;
		</td>
		<td align="center">
		<input type="hidden" name="time_period[tp_id]" value="<? echo $tp ?>">
		<input type="submit" name="ChangeTP" value="<? echo $lang['save']; ?>">
		</td>
	</tr>
</table>
</form>