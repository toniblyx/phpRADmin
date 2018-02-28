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
				<td class="text12"><? echo $lang['s']; ?></td>
				<?
				$ok = 0;
				$ko = 0;
				if (isset($oreon->services))
					foreach ($oreon->services as $service)	{
						if ($service->get_register())	{
							if (($service->get_activate() && $oreon->hosts[$service->get_host()]->get_activate()))
								$ok++;
							else
								$ko++;
						}	
						unset($service);
					}
				?>
				<td class="text12" align="center"><? echo $ok; ?></td>
				<td class="text12" align="center"><? echo $ko; ?></td>
			</tr>
			<tr>
				<td class="text12"><? echo $lang['sg']; ?></td>
				<?
				$ok = 0;
				$ko = 0;
				if (isset($oreon->serviceGroups))
					foreach ($oreon->serviceGroups as $serviceGroup)	{
						if ($serviceGroup->get_activate())
							$ok++;
						else
							$ko++;
						unset($serviceGroup);
					}
				?>
				<td class="text12" align="center"><? echo $ok; ?></td>
				<td class="text12" align="center"><? echo $ko; ?></td>
			</tr>
			<tr>
				<td class="text12"><? echo $lang['se']; ?></td>
				<?
				$ok = 0;
				$ko = 0;
				if (isset($oreon->ses))
					foreach ($oreon->ses as $se)	{
						if ($oreon->hosts[$se->get_host()]->get_activate())
							$ok++;
						else
							$ko++;
						unset($se);
					}
				?>
				<td class="text12" align="center"><? echo $ok; ?></td>
				<td class="text12" align="center"><? echo $ko; ?></td>
			</tr>
			<tr>
				<td class="text12"><? echo $lang['sd']; ?></td>
				<?
				$ok = 0;
				$ko = 0;
				if (isset($oreon->sds))
					foreach ($oreon->sds as $sd)	{
						if ($oreon->hosts[$sd->get_host()]->get_activate() && $oreon->hosts[$sd->get_host_dependent()]->get_activate() && $oreon->services[$sd->get_service()]->get_activate() && $oreon->services[$sd->get_service_dependent()]->get_activate())
							$ok++;
						else
							$ko++;
						unset($sd);
					}
				?>
				<td class="text12" align="center"><? echo $ok; ?></td>
				<td class="text12" align="center"><? echo $ko; ?></td>
			</tr>
			<tr>
				<td class="text12"><? echo $lang['stm']; ?></td>
				<?
				$ok = 0;
				$ko = 0;
				if (isset($oreon->stms))
					$ok = count($oreon->stms);
				?>
				<td class="text12" align="center"><? echo $ok; ?></td>
				<td class="text12" align="center"><? echo $ko; ?></td>
			</tr>
			<tr>
				<td class="text12"><? echo $lang['esi']; ?></td>
				<?
				$ok = 0;
				$ko = 0;
				if (isset($oreon->esis))
					foreach ($oreon->esis as $esi)	{
						if ($oreon->hosts[$oreon->services[$oreon->esis[$esi->get_id()]->get_service()]->get_host()]->get_activate() && $oreon->services[$oreon->esis[$esi->get_id()]->get_service()]->get_activate())
							$ok++;
						else
							$ko++;
						unset($esi);
					}
				?>
				<td class="text12" align="center"><? echo $ok; ?></td>
				<td class="text12" align="center"><? echo $ko; ?></td>
			</tr>
		</table>
	</div>