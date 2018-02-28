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
		<td style="white-space: nowrap;"><? echo $lang['name']; ?></td>
		<td class="text10b" style="white-space: nowrap;"><? echo $contacts[$contact_id]->get_name(); ?></td>
	</tr>
	<tr>
		<td style="white-space: nowrap;"><? echo $lang['alias']; ?></td>
		<td class="text10b" style="white-space: nowrap;"><? echo $contacts[$contact_id]->get_alias(); ?></td>
	</tr>
	<tr>
		<td style="white-space: nowrap;">host_notification_options : </td>
		<td class="text10b" style="white-space: nowrap;"><? echo $contacts[$contact_id]->get_host_notification_options(); ?></td>
	</tr>
	<tr>
		<td style="white-space: nowrap;">host_notification_period : </td>
		<td class="text10b" style="white-space: nowrap;"><? echo $time_periods[$contacts[$contact_id]->get_host_notification_period()]->get_name(); ?></td>
	</tr>
	<tr>
		<td style="white-space: nowrap;">service_notification_options : </td>
		<td class="text10b" style="white-space: nowrap;"><? echo $contacts[$contact_id]->get_service_notification_options(); ?></td>
	</tr>
	<tr>
		<td style="white-space: nowrap;">service_notification_period : </td>
		<td class="text10b" style="white-space: nowrap;"><? echo $time_periods[$contacts[$contact_id]->get_service_notification_period()]->get_name(); ?></td>
	</tr>
	<? if (!strcmp($oreon->user->get_version(), "2")){ ?>
	<tr>
		<td valign="top" style="white-space: nowrap;">contact group : </td>
		<td class="text10b" style="white-space: nowrap;">
		<?
			if (isset($contacts[$contact_id]->contact_groups))
				foreach ($contacts[$contact_id]->contact_groups as $contact_group)	{
					echo "<li><a class='text10b' href='./phpradmin.php?p=107&cg=".$contact_group->get_id()."&o=w' style='white-space: nowrap;";
					if (!$contact_group->get_activate())
						echo " text-decoration: line-through;";
					echo "'>".$contact_group->get_name()."</a></li>";
					unset($contact_group);
				}
		?>
		</td>
	</tr>
	<? } ?>
	<tr>
		<td valign="top" style="white-space: nowrap;">host_notification_command : </td>
		<td class="text10b" style="white-space: nowrap;">
		<?
			if (isset($contacts[$contact_id]->host_notification_commands))
				foreach ($contacts[$contact_id]->host_notification_commands as $host_notification_command)	{
					echo "<li><a class='text10b' href='./phpradmin.php?p=109&cmd=".$host_notification_command->get_id()."&o=w&type=N' style='white-space: nowrap;'>".$host_notification_command->get_name()."</a></li>";
					unset($host_notification_command);
				}
		?>
		</td>
	</tr>
	<tr>
		<td valign="top" style="white-space: nowrap;">service_notification_command : </td>
		<td class="text10b" style="white-space: nowrap;">
		<?
			if (isset($contacts[$contact_id]->service_notification_commands))
				foreach ($contacts[$contact_id]->service_notification_commands as $service_notification_command)	{
					echo "<li><a class='text10b' href='./phpradmin.php?p=109&cmd=".$service_notification_command->get_id()."&o=w&type=N' style='white-space: nowrap;'>".$service_notification_command->get_name()."</a></li>";
					unset($service_notification_command);
				}
		?>
		</td>
	</tr>
	<tr>
		<td style="white-space: nowrap;">Email : </td>
		<td class="text10b" style="white-space: nowrap;"><? echo $contacts[$contact_id]->get_email();?></td>
	</tr>
	<tr>
		<td style="white-space: nowrap;">Pager : </td>
		<td class="text10b" style="white-space: nowrap;"><? echo $contacts[$contact_id]->get_pager(); ?></td>
	</tr>
	<tr>
		<td><? echo $lang['status']; ?> :</td>
		<td class="text10b">
		<?
		if ($contacts[$contact_id]->get_activate())
			echo $lang['enable'];
		else
			echo $lang['disable'];
		?>
		</td>
	<tr>
	<tr>
		<td valign="top" style="white-space: nowrap;">Comment :</td>
		<td class="text10b"><? echo "<textarea cols='20' rows='4' disabled>".$contacts[$contact_id]->get_comment()."</textarea>";	?></td>
	</tr>
	<tr>
		<td colspan="2" align="center">
			<a href="phpradmin.php?p=106&o=c&c=<? echo $contact_id ?>" class="text10bc"><? echo $lang['modify']; ?></a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="phpradmin.php?p=106&o=d&c=<? echo $contact_id ?>" class="text10bc" onClick="return confirm('<? echo $lang['confirm_removing']; ?>');"><? echo $lang['delete']; ?></a>
		</td>
	</tr>
</table>