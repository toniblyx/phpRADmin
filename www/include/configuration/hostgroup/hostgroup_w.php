<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/?>
<table border="0" cellpadding="0" cellspacing="3" width="350" align="center">
	<tr>
		<td style="white-space: nowrap;" width='50%'><? echo $lang['name']; ?></td>
		<td class="text10b" nowrap><? echo $hostGroups[$hg]->get_name(); ?></td>
	</tr>
	<tr>
		<td style="white-space: nowrap;"><? echo $lang['alias']; ?></td>
		<td class="text10b" nowrap><? echo $hostGroups[$hg]->get_alias(); ?></td>
	</tr>
	<tr>
		<td style="white-space: nowrap;" valign="top" colspan="2">Host(s)</td>
	<tr>
		<td colspan="2" style="white-space: nowrap;padding-left:120px;padding-top:5px;padding-bottom:5px;">
		<ul>
		<?
		if (isset($hostGroups[$hg]->hosts))
			foreach ($hostGroups[$hg]->hosts as $host)	{
				if ($host->get_register())	{
					echo "<li><a href='phpradmin.php?p=102&h=".$host->get_id()."&o=w' class='text10'";
					if (!$host->get_activate()) echo " style='text-decoration: line-through;'";
					echo ">".$host->get_name()."</a></li>";
				}	else
					echo "<li><a href='phpradmin.php?p=123&htm_id=".$host->get_id()."&o=w' class='text10'>".$host->get_name()."</a></li>";
				unset($host);
			}
		?>
		</ul>
		</td>
	</tr>
	<? if (!strcmp($oreon->user->get_version(), "1")) {?>
	<tr>
		<td style="white-space: nowrap;" valign="top" colspan="2">Contact Group(s)</td>
	</tr>
	<tr>
		<td colspan="2" style="white-space: nowrap;padding-left:120px;padding-top:5px;padding-bottom:5px;">
		<ul>
		<?
		if (isset($hostGroups[$hg]->contact_groups))
			foreach ($hostGroups[$hg]->contact_groups as $cg)	{
				echo "<li><a href='phpradmin.php?p=107&cg=".$cg->get_id()."&o=w' class='text10'>".$cg->get_name()."</a></li>";
				unset($cg);
			}
		?></ul>
		</td>
	</tr>
	<? } ?>
	<tr>
		<td><? echo $lang['status']; ?> :</td>
		<td class="text10b">
		<?
		if ($hostGroups[$hg]->get_activate())
			echo $lang['enable'];
		else
			echo $lang['disable'];
		?>
		</td>
	<tr>
		<td valign="top" style="white-space: nowrap;">Comment :</td>
		<td class="text10b"><? echo "<textarea cols='20' rows='4' disabled>".$hostGroups[$hg]->get_comment()."</textarea>";	?></td>
	</tr>
	<tr>
		<td colspan="2" height="35" align="center">
		<a href="phpradmin.php?p=103&o=c&hg=<? echo $hg ?>" class="text10bc"><? echo $lang['modify']; ?></a>&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="phpradmin.php?p=103&o=d&hg=<? echo $hg ?>" class="text10bc" onclick="return confirm('<? echo $lang['confirm_removing']; ?>')"><? echo $lang["delete"]; ?></a>
		</td>
	</tr>
</table>