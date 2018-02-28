<?
/*
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)
For information : toni@blyx.com
*/
	if (!isset($oreon))
		exit();
?>	
<table border=0 align="center">
	<tr>
		<td align="center" style="padding-bottom: 20px;">
			<?	include("./include/status/resume.php"); ?>
		</td>
	</tr>
	<tr>
	 	<td class="text14b" align="center" style="text-decoration: underline; padding-bottom: 10px;"><? echo $lang['mon_status_grid_fah']; ?></td>
	</tr>	
	<tr>
		<td align="center">
			<table style="border-width: thin; border-style: dashed; border-color=#9C9C9C;" cellpadding="4" cellspacing="2">
			<?
				if (isset($oreon->hostGroups))
					foreach ($oreon->hostGroups as $hg)	{
						$str = NULL;
						if (isset($hg)){
							echo "<div align='center' style='padding-bottom: 8px;'><a href='./phpradmin.php?p=303&host_group=".$hg->get_id()."' class='text11b'>".$hg->get_name()."</a>&nbsp;<a href='./phpradmin.php?p=317&hg=".$hg->get_id()."' class='text11b'><img src='./img/info2.gif' border=0 height='8'></a></div>";
							echo "<table style='border-width: thin; border-style: dashed; border-color=#9C9C9C;' cellpadding='4' cellspacing='2'>\n";
							echo "<tr bgcolor='#eaecef'><td class='text11b' align='center'>".$lang['h']."</td><td class='text11b' align='center'>".$lang['s']."</td></tr>";
							foreach ($hg->hosts as $h)	{ 
								if ($oreon->is_accessible($h->get_id()) && $h->get_register())	{
									echo "<tr bgcolor='#E9E9E9'><td valign='top'>";
									echo "<a href='./phpradmin.php?p=303&o=s&host_id=".$h->get_id()."' class='text10'>".$h->get_name()."</a>&nbsp;&nbsp;&nbsp;&nbsp;";
									echo "<a href='./phpradmin.php?p=314&h=".$h->get_id()."'><img src='./img/info2.gif' border=0 height='8'></a></td>";
									echo "<td align=left>&nbsp;";
									$i = 0;
									if (isset($h->services))	{
										foreach ($h->services as $s){
											if ($i == 4) {
												echo "<br>";
												$i = 0;
											}
											if (isset($Logs->log_h[$h->get_id()]) && isset($Logs->log_h[$h->get_id()]->log_s[$s->get_id()]))
												echo "&nbsp;<font color='424242' class='miniStatus".$Logs->log_h[$h->get_id()]->log_s[$s->get_id()]->get_status()."'><a href='./phpradmin.php?p=315&id=".$s->get_id()."'>".$s->get_description()."</a></font>";				
											$i++;
											unset($s);
										}
									}
									$str.=  "</td>";
								}
								unset($h);
							}
						}
						echo "</tr></table><br>";
						unset($hg);
					}	
			?>
		</td>
	</tr>
</table>
	