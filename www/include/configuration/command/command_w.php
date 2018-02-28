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
		<td valign="top" height="25" nowrap><? echo $lang['cmd_type']; ?></td>
		<td class="text10b" valign="top">
			<?
			if (!strcmp($commands[$cmd]->get_type(), "1"))
				echo "Notification";
			else if (!strcmp($commands[$cmd]->get_type(), "2"))
				echo "Check";
			?>
		</td>
	</tr>
	<tr>
		<td valign="top" height="25" style="white-space: nowrap;"><? echo $lang['cmd_name']; ?></td>
		<td class="text10b" valign="top" style="white-space: nowrap;"><? echo $commands[$cmd]->get_name(); ?></td>
	</tr>
	<tr>
		<td valign="top" height="25" style="white-space: nowrap;" colspan="2"><? echo $lang['cmd_line']; ?></td>
	</tr>
	<tr>
		<td class="text10b" valign="top" colspan="2"><fiedset border="1"><? echo $commands[$cmd]->get_line(); ?></fieldset></td>
	</tr>
	<tr>
		<td colspan="2" align="center">
			<a href="phpradmin.php?p=109&o=c&cmd=<? echo $cmd ?>&type=<? print $_GET['type']; ?>" class="text10bc"><? echo $lang['modify']; ?></a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="phpradmin.php?p=109&o=d&cmd=<? echo $cmd ?>&type=<? print $_GET['type']; ?>" class="text10bc" onclick="return confirm('<? echo $lang['confirm_removing']; ?>')"><? echo $lang['delete']; ?></a>
		</td>
	</tr>
</table>
</form>