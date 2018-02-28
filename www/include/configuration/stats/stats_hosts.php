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
				<td class="text12"><? echo $lang['h']; ?></td>
				<?
				$ok = 0;
				$ko = 0;
				if (isset($oreon->hosts))
					foreach ($oreon->hosts as $host)	{
						if ($host->get_register())	{
							if ($host->get_activate())
								$ok++;
							else
								$ko++;
						}	
						unset($host);
					}
				?>
				<td class="text12" align="center"><? echo $ok; ?></td>
				<td class="text12" align="center"><? echo $ko; ?></td>
			</tr>
			<tr>
				<td class="text12"><? echo $lang['hg']; ?></td>
				<?
				$ok = 0;
				$ko = 0;
				if (isset($oreon->hostGroups))
					foreach ($oreon->hostGroups as $hostGroup)	{
						if ($hostGroup->get_activate())
							$ok++;
						else
							$ko++;
						unset($hostGroup);
					}
				?>
				<td class="text12" align="center"><? echo $ok; ?></td>
				<td class="text12" align="center"><? echo $ko; ?></td>
			</tr>
			<? if ($oreon->user->get_version() == 1)	{	?>
			<tr>
				<td class="text12"><? echo $lang['hge']; ?></td>
				<?
				$ok = 0;
				$ko = 0;
				if (isset($oreon->hges))
					foreach ($oreon->hges as $hge)	{
						if ($oreon->hostGroups[$hge->get_hostgroup()]->get_activate())
							$ok++;
						else
							$ko++;
						unset($hge);
					}
				?>
				<td class="text12" align="center"><? echo $ok; ?></td>
				<td class="text12" align="center"><? echo $ko; ?></td>
			</tr>
			<? } ?>
			<tr>
				<td class="text12"><? echo $lang['he']; ?></td>
				<?
				$ok = 0;
				$ko = 0;
				if (isset($oreon->hes))
					foreach ($oreon->hes as $he)	{
						if ($oreon->hosts[$he->get_host()]->get_activate())
							$ok++;
						else
							$ko++;
						unset($he);
					}
				?>
				<td class="text12" align="center"><? echo $ok; ?></td>
				<td class="text12" align="center"><? echo $ko; ?></td>
			</tr>
			<tr>
				<td class="text12"><? echo $lang['hd']; ?></td>
				<?
				$ok = 0;
				$ko = 0;
				if (isset($oreon->hds))
					foreach ($oreon->hds as $hd)	{
						if ($oreon->hosts[$hd->get_host()]->get_activate() && $oreon->hosts[$hd->get_host_dependent()]->get_activate())
							$ok++;
						else
							$ko++;
						unset($hd);
					}
				?>
				<td class="text12" align="center"><? echo $ok; ?></td>
				<td class="text12" align="center"><? echo $ko; ?></td>
			</tr>
			<tr>
				<td class="text12"><? echo $lang['htm']; ?></td>
				<?
				$ok = 0;
				$ko = 0;
				if (isset($oreon->htms))
					$ok = count($oreon->htms);
				?>
				<td class="text12" align="center"><? echo $ok; ?></td>
				<td class="text12" align="center"><? echo $ko; ?></td>
			</tr>
			<tr>
				<td class="text12"><? echo $lang['ehi']; ?></td>
				<?
				$ok = 0;
				$ko = 0;
				if (isset($oreon->ehis))
					foreach ($oreon->ehis as $ehi)	{
						if ($oreon->hosts[$oreon->ehis[$ehi->get_id()]->get_host()]->get_activate())
							$ok++;
						else
							$ko++;
						unset($ehi);
					}
				?>
				<td class="text12" align="center"><? echo $ok; ?></td>
				<td class="text12" align="center"><? echo $ko; ?></td>
			</tr>
		</table>
	</div>