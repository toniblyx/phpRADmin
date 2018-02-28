<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/if (!isset($oreon))
		exit();
?>
	<div style="padding-top: 10px; padding-left: 50px;">
		<table cellpadding="5" cellspacing="5">
			<tr>
				<td class="listTop"><? echo $lang['conf_stats_category']; ?></td>
				<td class="listTop"><? echo $lang['enable']; ?></td>
				<td class="listTop"><? echo $lang['disable']; ?></td>
			</tr>
			<tr>
				<td class="text12"><? echo $lang['c']; ?></td>
				<?
				$ok = 0;
				$ko = 0;
				if (isset($oreon->contacts))
					foreach ($oreon->contacts as $cct)	{
						if ($cct->get_activate())
							$ok++;
						else
							$ko++;
						unset($cct);					
					}
				?>
				<td class="text12" align="center"><? echo $ok; ?></td>
				<td class="text12" align="center"><? echo $ko; ?></td>
			</tr>
			<tr>
				<td class="text12"><? echo $lang['cg']; ?></td>
				<?
				$ok = 0;
				$ko = 0;
				if (isset($oreon->contactGroups))
					foreach ($oreon->contactGroups as $cg)	{
						if ($cg->get_activate())
							$ok++;
						else
							$ko++;
						unset($cg);
					}
				?>
				<td class="text12" align="center"><? echo $ok; ?></td>
				<td class="text12" align="center"><? echo $ko; ?></td>
			</tr>
			<tr>
				<td class="text12"><? echo $lang['tp_title']; ?></td>
				<?
				$ok = 0;
				$ko = 0;
				if (isset($oreon->time_periods))
					$ok = count($oreon->time_periods);
				?>
				<td class="text12" align="center"><? echo $ok; ?></td>
				<td class="text12" align="center"><? echo $ko; ?></td>
			</tr>
			<tr>
				<td class="text12"><? echo $lang['cmd_title']; ?></td>
				<?
				$ok = 0;
				$ko = 0;
				if (isset($oreon->commands))
					$ok = count($oreon->commands);
				?>
				<td class="text12" align="center"><? echo $ok; ?></td>
				<td class="text12" align="center"><? echo $ko; ?></td>
			</tr>
		</table>
	</div>