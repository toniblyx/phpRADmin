<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/?>
<table border="0" width="100%">
	<tr>
		<td class="text10b">Host</td>
		<td style="padding: 3px;" nowrap><?	echo $hosts[$ses[$se_id]->get_host()]->get_name();?></td>
	</tr>
	<tr>
		<td class="text10b">Service</td>
		<td style="padding: 3px;" nowrap><? echo $services[$ses[$se_id]->get_service()]->get_description();	?></td>
	</tr>
	<tr>
		<td class="text10b">first_notification</td>
		<td class="text10" style="padding: 3px;"><? echo $ses[$se_id]->get_first_notification(); ?></td>
	</tr>
	<tr>
		<td class="text10b">last_notification</td>
		<td class="text10" style="padding: 3px;"><? echo preg_replace("/(99999)/", "0", $ses[$se_id]->get_last_notification()); ?></td>
	</tr>
	<tr>
		<td class="text10b">notification_interval</td>
		<td class="text10" style="padding: 3px;"><? echo preg_replace("/(99999)/", "0", $ses[$se_id]->get_notification_interval())." * ".$oreon->Nagioscfg->get_interval_length()." ".$lang["time_sec"]; ?></td>
	</tr>
	<tr>
		<td colspan="2" align="center" class="text10b" style="padding:20px">
			Contact Group
		</td>
	</tr>
	<tr>
		<td align="left" style="padding: 3px;" class="text10">
			<?
			if (isset($ses[$se_id]->contactGroups))
				foreach ($ses[$se_id]->contactGroups as $cg)	{
					echo "<li><a href='phpradmin.php?p=107&cg=".$cg->get_id()."&o=w' class='text10'";
					if (!$cg->get_activate()) echo " style='text-decoration: line-through;'";
					echo ">".$cg->get_name()."</a></li>";
					unset($cg);
				}
			?>
		</td>
	</tr>
	<? if (!strcmp ($oreon->user->get_version(), 2)) { ?>
	<tr>
		<td class="text10b">escalation_period</td>
		<td align="left" style="padding: 3px;">
			<?
			if (isset($ses[$se_id]->escalation_period))
				echo $timeperiods[$ses[$se_id]->get_escalation_period()]->get_name();
			?>
		</td>
	</tr>
	<tr>
		<td class="text10b">escalation_options</td>
		<td align="left" style="padding: 3px;"><? echo $ses[$se_id]->get_escalation_options(); ?></td>
	</tr>
	<? } ?>
	<tr>
		<td colspan="2" style="padding-top:25px" align="center" class="text10b">
			<a href="phpradmin.php?p=117&o=c&se_id=<? echo $se_id ?>" class="text10bc"><? echo $lang['modify']; ?></a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="phpradmin.php?p=117&o=d&se_id=<? echo $se_id ?>" class="text10bc" onclick="return confirm('<? echo $lang['confirm_removing']; ?>')"><? echo $lang["delete"]; ?></a>
		</td>
	</tr>
</table>