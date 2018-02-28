<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/?>
<table cellpadding="0" cellspacing="3" width="350" align='center'>
	<tr>
		<td class="text10b" style="white-space: nowrap;" width="50%">HostGroup</td>
		<td class="text10" style="padding: 3px;" nowrap><? echo $hostGroups[$hges[$hge_id]->get_hostgroup()]->get_name();?></td>
	</tr>
	<tr>
		<td class="text10b" style="white-space: nowrap;">first_notification</td>
		<td class="text10" style="padding: 3px;" ><? echo $hges[$hge_id]->get_first_notification() ?></td>
	</tr>
	<tr>
		<td class="text10b" style="white-space: nowrap;">last_notification</td>
		<td class="text10" style="padding: 3px;" ><? echo preg_replace("/(99999)/", "0", $hges[$hge_id]->get_last_notification()); ?></td>
	</tr>
	<tr>
		<td class="text10b" style="white-space: nowrap;">notification_interval</td>
		<td class="text10" style="padding: 3px;" ><? echo preg_replace("/(99999)/", "0", $hges[$hge_id]->get_notification_interval())." * ".$oreon->Nagioscfg->get_interval_length()." ".$lang["time_sec"]; ?></td>
	</tr>
	<tr>
		<td colspan="2" align="center" class="text10b" style="padding:20px">
			Contact Group
		</td>
	</tr>
	<tr>
		<td align="left" style="padding: 3px; white-space: nowrap;" class="text10">
			<?
			if (isset($hges[$hge_id]->contactGroups))
				foreach ($hges[$hge_id]->contactGroups as $cg)	{
					echo "<li><a href='phpradmin.php?p=107&cg=".$cg->get_id()."'&o=w class='text10'";
					if (!$cg->get_activate()) echo " style='text-decoration: line-through;'";
					echo ">".$cg->get_name()."</a></li>";
					unset($cg);
				}
			?>
		</td>
	</tr>
	<tr>
		<td colspan="2" style="padding-top:25px" align="center" class="text10b">
			<a href="phpradmin.php?p=122&o=c&hge=<? echo $hge_id ?>" class="text10bc"><? echo $lang['modify']; ?></a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="phpradmin.php?p=122&o=d&hge=<? echo $hge_id ?>" class="text10bc" onclick="return confirm('<? echo $lang['confirm_removing']; ?>')"><? echo $lang["delete"]; ?></a>
		</td>
	</tr>
</table>