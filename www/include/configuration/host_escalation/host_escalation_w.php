<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/?>
<table cellpadding="0" cellspacing="3" width="350" align='center'>
	<tr>
		<td class="text10b" style="white-space: nowrap;" width='50%'>Host</td>
		<td class='text10' style="padding: 3px; white-space: nowrap;"><? echo $hosts[$hes[$he_id]->get_host()]->get_name(); ?></td>
	</tr>
	<tr>
		<td class="text10b" style="white-space: nowrap;">first_notification</td>
		<td class="text10" style="padding: 3px; white-space: nowrap;"><? echo $hes[$he_id]->get_first_notification(); ?></td>
	</tr>
	<tr>
		<td class="text10b" style="white-space: nowrap;">last_notification</td>
		<td class="text10" style="padding: 3px; white-space: nowrap;"><? echo preg_replace("/(99999)/", "0", $hes[$he_id]->get_last_notification()); ?></td>
	</tr>
	<tr>
		<td class="text10b" style="white-space: nowrap;">notification_interval</td>
		<td class="text10" style="padding: 3px; white-space: nowrap;"><? echo preg_replace("/(99999)/", "0", $hes[$he_id]->get_notification_interval())." * ".$oreon->Nagioscfg->get_interval_length()." ".$lang["time_sec"]; ?></td>
	</tr>
	<tr>
		<td colspan="2" align="center" class="text10b" style="padding:20px">
			Contact Group
		</td>
	</tr>
	<tr>
		<td align="left" style="padding: 3px; white-space: nowrap;" class="text10">
			<?
			if (isset($hes[$he_id]->contactGroups))
				foreach ($hes[$he_id]->contactGroups as $cg)	{
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
		<td colspan="2" align="center" class="text10b" style="padding:20px; white-space: nowrap;">
			Host Group
		</td>
	</tr>
	<tr>
		<td align="left" style="padding: 3px; white-space: nowrap;" class="text10">
			<?
			if (isset($hes[$he_id]->hostGroups))
				foreach ($hes[$he_id]->hostGroups as $hg)	{
					echo "<li><a href='phpradmin.php?p=103&hg=".$hg->get_id()."&o=w' class='text10'";
					if (!$hg->get_activate()) echo " style='text-decoration: line-through;'";
					echo ">".$hg->get_name()."</a></li>";
					unset($hg);
				}
			?>
		</td>
	</tr>
	<? } ?>
	<? if (!strcmp ($oreon->user->get_version(), 2)) { ?>
	<tr>
		<td class="text10b" style="white-space: nowrap;">Escalation period</td>
		<td align="left" style="padding: 3px;">
			<?
			if ($hes[$he_id]->escalation_period)
				echo $timeperiods[$hes[$he_id]->get_escalation_period()]->get_name();
			?>
		</td>
	</tr>
	<tr>
		<td class="text10b" style="white-space: nowrap;">escalation_options</td>
		<td align="left" style="padding: 3px;"><? echo $hes[$he_id]->get_escalation_options() ?></td>
	</tr>
	<? } ?>
	<tr>
		<td colspan="2" style="padding-top:25px" align="center" class="text10b">
			<a href="phpradmin.php?p=115&o=c&he=<? echo $he_id ?>" class="text10bc"><? echo $lang['modify']; ?></a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="phpradmin.php?p=115&o=d&he=<? echo $he_id ?>" class="text10bc" onclick="return confirm('<? echo $lang['confirm_removing']; ?>')"><? echo $lang["delete"]; ?></a>
		</td>
	</tr>
</table>