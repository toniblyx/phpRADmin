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
		<td style="white-space: nowrap;" valign="top"><? echo $lang['cmd_type']; ?> <font color='red'>*</font></td>
		<td class="text10b" valign="top">
			<input type="radio" name="command[command_type]" value="1" <? if ($commands[$cmd]->get_type() == 1) echo "checked"; ?>>&nbsp;Notification
			<input type="radio" name="command[command_type]" value="2" <? if ($commands[$cmd]->get_type() == 2) echo "checked"; ?>>&nbsp;Check
		</td>
	</tr>
	<tr>
		<td style="white-space: nowrap;" valign="top"><? echo $lang['cmd_name']; ?> <font color='red'>*</font></td>
		<td class="text10b" valign="top"><input type="text" name="command[command_name]" value=<? echo $commands[$cmd]->get_name(); ?>></td>
	</tr>
	<tr>
		<td style="white-space: nowrap;" valign="top" colspan="2"><? echo $lang['cmd_line']; ?> <font color='red'>*</font></td>
	</tr>
	<tr>
		<td class="text10b" valign="top" colspan="2"><textarea name="command[command_line]" cols="70" rows="15"><? echo $commands[$cmd]->get_line(); ?></textarea></td>
	</tr>
	<tr>
		<td colspan="2" align="center">
			<input type="hidden" name="command[command_id]" value="<? echo $cmd ?>">
			<input type="submit" name="ChangeCmd" value="<? echo $lang['save']; ?>">
		</td>
	</tr>
</table>
</form>