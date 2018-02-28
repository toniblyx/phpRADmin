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
		<td valign="top" style="white-space: nowrap;"><? echo $lang['cmd_type']; ?> <font color='red'>*</font></td>
		<td class="text10b" valign="top">
			<input type="radio" name="command[command_type]" value="1" checked>&nbsp;Notification
			<input type="radio" name="command[command_type]" value="2">&nbsp;Check
		</td>
	</tr>
	<tr>
		<td valign="top" style="white-space: nowrap;"><? echo $lang['cmd_name']; ?> <font color='red'>*</font></td>
		<td class="text10b" valign="top"><input type="text" name="command[command_name]"></td>
	</tr>
	<tr>
		<td valign="top" style="white-space: nowrap;" colspan="2"><? echo $lang['cmd_line']; ?> <font color='red'>*</font></td>
	</tr>
	<tr>
		<td class="text10b" valign="top" colspan="2">
			<textarea name="command[command_line]" cols="70" rows="15"></textarea>
		</td>
	</tr>
	<tr>
		<td align="left">
			<? echo $lang['required']; ?>&nbsp;&nbsp;
		</td>
		<td align="center"><input type="submit" name="AddCMD" value="<? echo $lang['save']; ?>"></td>
	</tr>
</table>
</form>