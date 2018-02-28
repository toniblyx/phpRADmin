<?
/**
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Julien Mathis - Mathieu Mettre - Romain Le Merlus - Christophe Coraboeuf

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

	$tab_convert = array("01" => "1", "02" => "2", "03" => "3", "04" => "4", "05" => "5", "06" => "6", "07" => "7", "08" => "8", "09" => "9");
	$msg = NULL;
	$enddate = & $_POST['endDate'];
	$begdate = & $_POST['startDate'];
	$box= & $_POST['box'];

	if (!$_POST["height"] || !$_POST["width"])
		$msg = $lang['errCode'][-9];
	else if ($enddate + $_POST["endhours"] <= $begdate + $_POST["starthours"])
		$msg = $lang['errCode'][-8];
	else if (!count($box))	{
		$msg = $lang['errCode'][-9];
	}	else {
		$tab_beg = preg_split ("/\//", $_POST['startDate']);
		$tab_end = preg_split ("/\//", $_POST['endDate']);
		$now = mktime(0, 0, date("h"), date("n"), date("j"), date("Y"));
		if (isset($tab_beg[1]) &&  $tab_beg[1] <= 9)
			$tab_beg[1] = $tab_convert[$tab_beg[1]];
		if (isset($tab_beg[0]) && $tab_beg[0] <= 9)
			$tab_beg[0] = $tab_convert[$tab_beg[0]];
		if (isset($tab_end[1]) && $tab_end[1] <= 9)
			$tab_end[1] = $tab_convert[$tab_end[1]];
		if (isset($tab_end[0]) && $tab_end[0] <= 9)
			$tab_end[0] = $tab_convert[$tab_end[0]];
		$time_beg = mktime($_POST['starthours'], 0, 0, $tab_beg[0], $tab_beg[1], $tab_beg[2]);
		$time_end = mktime($_POST['endhours'], 0, 0, $tab_end[0], $tab_end[1], $tab_end[2]);
		$time1 = time() - $time_beg;
		$time2 = time() - $time_end;
		if ($time1 >= 0)
			$time1 *= -1;
		if ($time2 >= 0)
			$time2 *= -1;
		?>
		<td align="left" valign="top" style='padding-left: 20px;'>
			<table cellpadding="0" cellspacing="0">
				<tr>
					<td class="TabTableTitle">
						<table cellspacing="0" cellpadding="0" style="padding:10px">
						<?
						$cpt = 0;
						$errorstartend = NULL;
						if (isset($_POST["box"]))
							$graphBox = $_POST["box"];
						if (isset($graphBox) && count($graphBox))
							foreach($graphBox as $graph_id)
								if ($oreon->is_accessible($oreon->hosts[$oreon->services[$graph_id]->get_host()]->get_id())){
									$graph = & $oreon->graphs[$graph_id];
									$namerrd = $graph->get_id().".rrd";
									$path = $oreon->optGen->get_rrd_base_pwd();
									$verticallabel = html_entity_decode(urldecode($graph->get_verticallabel()));
									$imgformat = $graph->get_imgformat();
									$width = $_POST["width"];
									$height = $_POST["height"];
									$ColGrilFond = $graph->get_ColGrilFond();
									$ColFond = $graph->get_ColFond();
									$ColPolice = $graph->get_ColPolice();
									$ColGrGril = $graph->get_ColGrGril();
									$ColPtGril = $graph->get_ColPtGril();
									$ColContCub = $graph->get_ColContCub();
									$ColArrow = $graph->get_ColArrow();
									$ColImHau = $graph->get_ColImHau();
									$ColImBa = $graph->get_ColImBa();
									$ds1name = html_entity_decode(urldecode($graph->get_dsname(1)));
									$ds2name = html_entity_decode(urldecode($graph->get_dsname(2)));
									$ColDs1 = $graph->get_ColDs(1);
									$ColDs2 = $graph->get_ColDs(2);
									$ds3name = html_entity_decode(urldecode($graph->get_dsname(3)));
									$ds4name = html_entity_decode(urldecode($graph->get_dsname(4)));
									$ColDs3 = $graph->get_ColDs(3);
									$ColDs4 = $graph->get_ColDs(4);
									$flamming = $graph->get_flamming();
									$lowerlimit = $graph->get_lowerlimit();
									$areads1 = $graph->get_areads(1);
									$ticknessds1 = $graph->get_ticknessds(1);
									$gprintlastds1 = $graph->get_gprintlastds(1);
									$gprintminds1 = $graph->get_gprintminds(1);
									$gprintaverageds1 = $graph->get_gprintaverageds(1);
									$gprintmaxds1 = $graph->get_gprintmaxds(1);
									$areads2 = $graph->get_areads(2);
									$ticknessds2 = $graph->get_ticknessds(2);
									$gprintlastds2 = $graph->get_gprintlastds(2);
									$gprintminds2 = $graph->get_gprintminds(2);
									$gprintaverageds2 = $graph->get_gprintaverageds(2);
									$gprintmaxds2 = $graph->get_gprintmaxds(2);
									$areads3 = $graph->get_areads(3);
									$ticknessds3 = $graph->get_ticknessds(3);
									$gprintlastds3 = $graph->get_gprintlastds(3);
									$gprintminds3 = $graph->get_gprintminds(3);
									$gprintaverageds3 = $graph->get_gprintaverageds(3);
									$gprintmaxds3 = $graph->get_gprintmaxds(3);
									$areads4 = $graph->get_areads(4);
									$ticknessds4 = $graph->get_ticknessds(4);
									$gprintlastds4 = $graph->get_gprintlastds(4);
									$gprintminds4 = $graph->get_gprintminds(4);
									$gprintaverageds4 = $graph->get_gprintaverageds(4);
									$gprintmaxds4 = $graph->get_gprintmaxds(4);
									$stdout = shell_exec($oreon->optGen->get_rrd_pwd()." info ".$path.$namerrd);
									$tab = preg_split ("/[\n]+/", htmlentities($stdout));
									for ($i = 0, $dsflg = 1; $tab[$i]; $i++) {
										if (!strncmp($tab[$i], "ds[b]", 5))
											$dsflg = 2;
										if (!strncmp($tab[$i], "ds[c]", 5))
											$dsflg = 3;
										if (!strncmp($tab[$i], "ds[d]", 5))
											$dsflg = 4;
									}
									// Calcul in sec the start date (ex: -6000) & the end date (ex: -5000)
									$file = $oreon->optGen->get_oreon_pwd()."rrd/".$namerrd;
									$cptmod = $cpt % $_POST['modulo'];
									if ($cptmod == 0)
										echo "<tr>";
									echo "<td valign='top'>";
									
									
									if (is_file($file) && is_readable($file)) {
										echo "<a href='./phpradmin.php?p=310&o=v&gr=".$graph->get_id()."'>\n<img src='./include/graph/graph_image.php?time=$time1&time2=$time2&namerrd=$namerrd&path=$path&verticallabel=" . htmlentities(urlencode($verticallabel)). "&imgformat=$imgformat&width=$width&height=$height&ColGrilFond=$ColGrilFond&ColFond=$ColFond&ColPolice=$ColPolice&ColGrGril=$ColGrGril&ColPtGril=$ColPtGril&ColContCub=$ColContCub&ColArrow=$ColArrow&ColImHau=$ColImHau&ColImBa=$ColImBa&ds1name=" .  htmlentities(urlencode($ds1name)) ."&ds2name=" .  htmlentities(urlencode($ds2name))."&ColDs1=$ColDs1&ColDs2=$ColDs2&ds3name=" .  htmlentities(urlencode($ds3name))."&ds4name=" .  htmlentities(urlencode($ds4name))."&ColDs3=$ColDs3&ColDs4=$ColDs4&flamming=$flamming&lowerlimit=$lowerlimit&areads1=$areads1&ticknessds1=$ticknessds1&gprintlastds1=$gprintlastds1&gprintminds1=$gprintminds1&gprintaverageds1=$gprintaverageds1&gprintmaxds1=$gprintmaxds1&areads2=$areads2&ticknessds2=$ticknessds2&gprintlastds2=$gprintlastds2&gprintminds2=$gprintminds2&gprintaverageds2=$gprintaverageds2&gprintmaxds2=$gprintmaxds2&areads3=$areads3&ticknessds3=$ticknessds3&gprintlastds3=$gprintlastds3&gprintminds3=$gprintminds3&gprintaverageds3=$gprintaverageds3&gprintmaxds3=$gprintmaxds3&areads4=$areads4&ticknessds4=$ticknessds4&gprintlastds4=$gprintlastds4&gprintminds4=$gprintminds4&gprintaverageds4=$gprintaverageds4&gprintmaxds4=$gprintmaxds4&dsflg=$dsflg&name=".htmlentities(urlencode($oreon->services[$graph->get_id()]->get_description()))." - ".htmlentities(urlencode($oreon->hosts[$oreon->services[$graph->get_id()]->get_host()]->get_name()))."' border='0'></a>";
									} else {
										echo "<div align='center' class='msg'>". sprintf($lang['g_no_access_file'], $file)."</div>";
									}
									
									echo "\n</td>\n";
									if ($cptmod == ($tab_beg[2] - 1))
										echo "</TR>\n";
									
									$cpt += 1;
							}
				 }	?>
				 	</table>
				</td>
			</tr>
		</table>