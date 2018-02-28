<?
/**
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Jean Baptiste Gouret - Julien Mathis - Mathieu Mettre - Romain Le Merlus - Christophe Coraboeuf

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


	// w = display graph without the possibility to modify with all options
	// c = display graph with the possibility to modify with all options	?>
<?
$namerrd = $graphs[$gr]->get_id().".rrd";
$path = $oreon->optGen->get_rrd_base_pwd();
$verticallabel = html_entity_decode(urldecode($graphs[$gr]->get_verticallabel()));
$imgformat = $graphs[$gr]->get_imgformat();
$width = 250;
$height = 80;
$ColGrilFond = $graphs[$gr]->get_ColGrilFond();
$ColFond = $graphs[$gr]->get_ColFond();
$ColPolice = $graphs[$gr]->get_ColPolice();
$ColGrGril = $graphs[$gr]->get_ColGrGril();
$ColPtGril = $graphs[$gr]->get_ColPtGril();
$ColContCub = $graphs[$gr]->get_ColContCub();
$ColArrow = $graphs[$gr]->get_ColArrow();
$ColImHau = $graphs[$gr]->get_ColImHau();
$ColImBa = $graphs[$gr]->get_ColImBa();
$ds1name = html_entity_decode(urldecode($graphs[$gr]->get_dsname(1)));
$ds2name = html_entity_decode(urldecode($graphs[$gr]->get_dsname(2)));
$ColDs1 = $graphs[$gr]->get_ColDs(1);
$ColDs2 = $graphs[$gr]->get_ColDs(2);
$ds3name = html_entity_decode(urldecode($graphs[$gr]->get_dsname(3)));
$ds4name = html_entity_decode(urldecode($graphs[$gr]->get_dsname(4)));
$ColDs3 = $graphs[$gr]->get_ColDs(3);
$ColDs4 = $graphs[$gr]->get_ColDs(4);
$flamming = $graphs[$gr]->get_flamming();
$lowerlimit = $graphs[$gr]->get_lowerlimit();
$areads1 = $graphs[$gr]->get_areads(1);
$ticknessds1 = $graphs[$gr]->get_ticknessds(1);
$gprintlastds1 = $graphs[$gr]->get_gprintlastds(1);
$gprintminds1 = $graphs[$gr]->get_gprintminds(1);
$gprintaverageds1 = $graphs[$gr]->get_gprintaverageds(1);
$gprintmaxds1 = $graphs[$gr]->get_gprintmaxds(1);
$areads2 = $graphs[$gr]->get_areads(2);
$ticknessds2 = $graphs[$gr]->get_ticknessds(2);
$gprintlastds2 = $graphs[$gr]->get_gprintlastds(2);
$gprintminds2 = $graphs[$gr]->get_gprintminds(2);
$gprintaverageds2 = $graphs[$gr]->get_gprintaverageds(2);
$gprintmaxds2 = $graphs[$gr]->get_gprintmaxds(2);
$areads3 = $graphs[$gr]->get_areads(3);
$ticknessds3 = $graphs[$gr]->get_ticknessds(3);
$gprintlastds3 = $graphs[$gr]->get_gprintlastds(3);
$gprintminds3 = $graphs[$gr]->get_gprintminds(3);
$gprintaverageds3 = $graphs[$gr]->get_gprintaverageds(3);
$gprintmaxds3 = $graphs[$gr]->get_gprintmaxds(3);
$areads4 = $graphs[$gr]->get_areads(4);
$ticknessds4 = $graphs[$gr]->get_ticknessds(4);
$gprintlastds4 = $graphs[$gr]->get_gprintlastds(4);
$gprintminds4 = $graphs[$gr]->get_gprintminds(4);
$gprintaverageds4 = $graphs[$gr]->get_gprintaverageds(4);
$gprintmaxds4 = $graphs[$gr]->get_gprintmaxds(4);
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
$file = $oreon->optGen->get_oreon_pwd()."rrd/".$namerrd;
?>
	<table border='0' align="left" cellpadding="0" cellspacing="0">
		<tr>
			<td class="tabTableTitle"><? print $lang['graph']; ?></td>
		</tr>
		<tr>
			<td class='TabTableForTab'>
				<? if (!strcmp($_GET["o"], "c")) { // display graph with the possibility to modify with all options
					include("./include/graph/graph_c.php");
				} else if (!strcmp($_GET["o"], "w")) { //display graph without the possibility to modify with all options
					include("./include/graph/graph_w.php");
				} ?>
			</td>
		</tr>
	</table>