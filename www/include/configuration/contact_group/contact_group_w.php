<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/?>
<table border="0" cellpadding="3" cellspacing="3">
	<tr>
		<td nowrap><? echo $lang['name']; ?></td>
		<td class="text10b" nowrap><? echo $contactGroups[$cg]->get_name(); ?></td>
	</tr>
	<tr>
		<td nowrap><? echo $lang['alias']; ?></td>
		<td class="text10b" nowrap><? echo $contactGroups[$cg]->get_alias(); ?></td>
	</tr>
	<tr>
		<td colspan="2" nowrap> Contacts : <br><ul>
		<?
		if (isset($contactGroups[$cg]->contacts))	{
			foreach ($contactGroups[$cg]->contacts as $contact)	{
				echo "<li><a href='phpradmin.php?p=106&c=" . $contact->get_id() . "&o=w' class='text10b'";
				if (!$contact->get_activate()) echo " style='text-decoration: line-through;'";
				echo "'>" . $contact->get_name() . "</a></li>";
				unset($contact);
			}
		}
		?>
		</ul>
		</td>
	</tr>
	<tr>
		<td><? echo $lang['status']; ?> :</td>
		<td class="text10b">
		<?
		if ($contactGroups[$cg]->get_activate())
			echo $lang['enable'];
		else
			echo $lang['disable'];
		?>
		</td>
	<tr>
	<tr>
		<td valign="top" style="white-space: nowrap;">Comment :</td>
		<td class="text10b"><? echo "<textarea cols='20' rows='4' disabled>".$contactGroups[$cg]->get_comment()."</textarea>";	?></td>
	</tr>
	<tr>
		<td colspan="2" align="center" nowrap>
			<a href="phpradmin.php?p=107&o=c&cg=<? echo $cg ?>" class="text10bc"><? echo $lang['modify']; ?></a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="phpradmin.php?p=107&o=d&cg=<? echo $cg ?>" class="text10bc" onclick="return confirm('<? echo $lang['confirm_removing']; ?>')"><? echo $lang['delete']; ?></a>
		</td>
	</tr>
</table>
