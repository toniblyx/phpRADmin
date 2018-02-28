<?
/**
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by :Julien Mathis - Mathieu Mettre - Romain Le Merlus - Christophe Coraboeuf

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

if ($oreon->is_accessible($oreon->hosts[$oreon->services[$_GET["gr"]]->get_host()]->get_id())){
	$gr = $_GET["gr"];
	$namerrd = $graphs[$gr]->get_id().".rrd";
	$path = $oreon->optGen->get_rrd_base_pwd();
	$verticallabel = $graphs[$gr]->get_verticallabel();
	$imgformat = $graphs[$gr]->get_imgformat();
	$width = $graphs[$gr]->get_width();
	$height = $graphs[$gr]->get_height();
	$ColGrilFond = $graphs[$gr]->get_ColGrilFond();
	$ColFond = $graphs[$gr]->get_ColFond();
	$ColPolice = $graphs[$gr]->get_ColPolice();
	$ColGrGril = $graphs[$gr]->get_ColGrGril();
	$ColPtGril = $graphs[$gr]->get_ColPtGril();
	$ColContCub = $graphs[$gr]->get_ColContCub();
	$ColArrow = $graphs[$gr]->get_ColArrow();
	$ColImHau = $graphs[$gr]->get_ColImHau();
	$ColImBa = $graphs[$gr]->get_ColImBa();
	$ds1name = $graphs[$gr]->get_dsname(1);
	$ds2name = $graphs[$gr]->get_dsname(2);
	$ColDs1 = $graphs[$gr]->get_ColDs(1);
	$ColDs2 = $graphs[$gr]->get_ColDs(2);
	$ds3name = $graphs[$gr]->get_dsname(3);
	$ds4name = $graphs[$gr]->get_dsname(4);
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
?>
<? $file = $oreon->optGen->get_rrd_base_pwd().$namerrd; ?>
<table cellpadding="0" cellspacing="0" border="0">
<tr>
	<td class='tabTableTitle'>
		<? echo "<font class='text14b'>" . $hosts[$services[$_GET["gr"]]->get_host()]->get_name(). "</font> - <a href='./phpradmin.php?p=104&sv=".$_GET["gr"]."&o=w' class='text12b'>" . $oreon->services[$_GET["gr"]]->get_description()."</a>&nbsp;&nbsp;<a href='phpradmin.php?p=310&gr=" . $_GET["gr"] . "&o=c' class='msg'><img src='./img/graph_properties.gif' border=0></a>"; ?>
	</td>
</tr>
<tr>
	<td class="tabTableForTab" style="padding:10px;">
	<table cellpadding='0' cellspacing='0'>
	    <? if (is_file($file) && is_readable($file) ){ ?>
		<tr>
			<td align="left" style="padding-top: 5px;" class="text12b"><? echo $lang['g_lcurrent']; ?></td>
		</tr>
		<tr>
			<td>
			    <? echo "<img src='./include/graph/graph_image.php?time=-7200&time2=0&timename=". urlencode($lang['g_lcurrent']) ."&namerrd=$namerrd&path=$path&verticallabel=" . htmlentities(urlencode($verticallabel)). "&imgformat=$imgformat&width=$width&height=$height&ColGrilFond=$ColGrilFond&ColFond=$ColFond&ColPolice=$ColPolice&ColGrGril=$ColGrGril&ColPtGril=$ColPtGril&ColContCub=$ColContCub&ColArrow=$ColArrow&ColImHau=$ColImHau&ColImBa=$ColImBa&ds1name=" . htmlentities(urlencode($ds1name)) ."&ds2name=" . htmlentities(urlencode($ds2name)). "&ColDs1=$ColDs1&ColDs2=$ColDs2&ds3name=" . htmlentities(urlencode($ds3name)). "&ds4name=" . htmlentities(urlencode($ds4name)). "&ColDs3=$ColDs3&ColDs4=$ColDs4&flamming=$flamming&lowerlimit=$lowerlimit&areads1=$areads1&ticknessds1=$ticknessds1&gprintlastds1=$gprintlastds1&gprintminds1=$gprintminds1&gprintaverageds1=$gprintaverageds1&gprintmaxds1=$gprintmaxds1&areads2=$areads2&ticknessds2=$ticknessds2&gprintlastds2=$gprintlastds2&gprintminds2=$gprintminds2&gprintaverageds2=$gprintaverageds2&gprintmaxds2=$gprintmaxds2&areads3=$areads3&ticknessds3=$ticknessds3&gprintlastds3=$gprintlastds3&gprintminds3=$gprintminds3&gprintaverageds3=$gprintaverageds3&gprintmaxds3=$gprintmaxds3&areads4=$areads4&ticknessds4=$ticknessds4&gprintlastds4=$gprintlastds4&gprintminds4=$gprintminds4&gprintaverageds4=$gprintaverageds4&gprintmaxds4=$gprintmaxds4&dsflg=$dsflg&name=".htmlentities(urlencode($oreon->services[$gr]->get_description()))." - ".htmlentities(urlencode($oreon->hosts[$oreon->services[$gr]->get_host()]->get_name()))."'><br>"; ?>
			</td>
		</tr>
		<tr>
			<td align="left" style="padding-top: 15px;" class="text12b"><? echo $lang['g_lday']; ?></td>
		</tr>
		<tr>
			<td style="padding-top: 1px;">
			    <? echo "<img src='./include/graph/graph_image.php?time=-86400&time2=0&timename=". urlencode($lang['g_lday']) ."&namerrd=$namerrd&path=$path&verticallabel=" . htmlentities(urlencode($verticallabel)). "&imgformat=$imgformat&width=$width&height=$height&ColGrilFond=$ColGrilFond&ColFond=$ColFond&ColPolice=$ColPolice&ColGrGril=$ColGrGril&ColPtGril=$ColPtGril&ColContCub=$ColContCub&ColArrow=$ColArrow&ColImHau=$ColImHau&ColImBa=$ColImBa&ds1name=" . htmlentities(urlencode($ds1name)) ."&ds2name=" . htmlentities(urlencode($ds2name)). "&ColDs1=$ColDs1&ColDs2=$ColDs2&ds3name=" . htmlentities(urlencode($ds3name)). "&ds4name=" . htmlentities(urlencode($ds4name)). "&ColDs3=$ColDs3&ColDs4=$ColDs4&flamming=$flamming&lowerlimit=$lowerlimit&areads1=$areads1&ticknessds1=$ticknessds1&gprintlastds1=$gprintlastds1&gprintminds1=$gprintminds1&gprintaverageds1=$gprintaverageds1&gprintmaxds1=$gprintmaxds1&areads2=$areads2&ticknessds2=$ticknessds2&gprintlastds2=$gprintlastds2&gprintminds2=$gprintminds2&gprintaverageds2=$gprintaverageds2&gprintmaxds2=$gprintmaxds2&areads3=$areads3&ticknessds3=$ticknessds3&gprintlastds3=$gprintlastds3&gprintminds3=$gprintminds3&gprintaverageds3=$gprintaverageds3&gprintmaxds3=$gprintmaxds3&areads4=$areads4&ticknessds4=$ticknessds4&gprintlastds4=$gprintlastds4&gprintminds4=$gprintminds4&gprintaverageds4=$gprintaverageds4&gprintmaxds4=$gprintmaxds4&dsflg=$dsflg&name=".htmlentities(urlencode($oreon->services[$gr]->get_description()))." - ".htmlentities(urlencode($oreon->hosts[$oreon->services[$gr]->get_host()]->get_name()))."'><br>"; ?>
			</td>
		</tr>
		<tr>
			<td align="left" style="padding-top: 15px;" class="text12b"><? echo $lang['g_lweek']; ?></td>
		</tr>
		<tr>
			<td style="padding-top: 1px;">
			    <? echo "<img src='./include/graph/graph_image.php?time=-604800&time2=0&timename=". urlencode($lang['g_lweek']) ."&namerrd=$namerrd&path=$path&verticallabel=" . htmlentities(urlencode($verticallabel)). "&imgformat=$imgformat&width=$width&height=$height&ColGrilFond=$ColGrilFond&ColFond=$ColFond&ColPolice=$ColPolice&ColGrGril=$ColGrGril&ColPtGril=$ColPtGril&ColContCub=$ColContCub&ColArrow=$ColArrow&ColImHau=$ColImHau&ColImBa=$ColImBa&ds1name=" . htmlentities(urlencode($ds1name)) ."&ds2name=" . htmlentities(urlencode($ds2name)). "&ColDs1=$ColDs1&ColDs2=$ColDs2&ds3name=" . htmlentities(urlencode($ds3name)). "&ds4name=" . htmlentities(urlencode($ds4name)). "&ColDs3=$ColDs3&ColDs4=$ColDs4&flamming=$flamming&lowerlimit=$lowerlimit&areads1=$areads1&ticknessds1=$ticknessds1&gprintlastds1=$gprintlastds1&gprintminds1=$gprintminds1&gprintaverageds1=$gprintaverageds1&gprintmaxds1=$gprintmaxds1&areads2=$areads2&ticknessds2=$ticknessds2&gprintlastds2=$gprintlastds2&gprintminds2=$gprintminds2&gprintaverageds2=$gprintaverageds2&gprintmaxds2=$gprintmaxds2&areads3=$areads3&ticknessds3=$ticknessds3&gprintlastds3=$gprintlastds3&gprintminds3=$gprintminds3&gprintaverageds3=$gprintaverageds3&gprintmaxds3=$gprintmaxds3&areads4=$areads4&ticknessds4=$ticknessds4&gprintlastds4=$gprintlastds4&gprintminds4=$gprintminds4&gprintaverageds4=$gprintaverageds4&gprintmaxds4=$gprintmaxds4&dsflg=$dsflg&name=".htmlentities(urlencode($oreon->services[$gr]->get_description()))." - ".htmlentities(urlencode($oreon->hosts[$oreon->services[$gr]->get_host()]->get_name()))."'><br>"; ?>
			</td>
		</tr>
		<tr>
			<td align="left" style="padding-top: 15px;" class="text12b"><? echo $lang['g_lyear']; ?></td>
		</tr>
		<tr>
			<td style="padding-top: 1px;">
			    <? echo "<img src='./include/graph/graph_image.php?time=-31536000&time2=0&timename=". urlencode($lang['g_lyear']) ."&namerrd=$namerrd&path=$path&verticallabel=" . htmlentities(urlencode($verticallabel)). "&imgformat=$imgformat&width=$width&height=$height&ColGrilFond=$ColGrilFond&ColFond=$ColFond&ColPolice=$ColPolice&ColGrGril=$ColGrGril&ColPtGril=$ColPtGril&ColContCub=$ColContCub&ColArrow=$ColArrow&ColImHau=$ColImHau&ColImBa=$ColImBa&ds1name=" . htmlentities(urlencode($ds1name)) ."&ds2name=" . htmlentities(urlencode($ds2name)). "&ColDs1=$ColDs1&ColDs2=$ColDs2&ds3name=" . htmlentities(urlencode($ds3name)). "&ds4name=" . htmlentities(urlencode($ds4name)). "&ColDs3=$ColDs3&ColDs4=$ColDs4&flamming=$flamming&lowerlimit=$lowerlimit&areads1=$areads1&ticknessds1=$ticknessds1&gprintlastds1=$gprintlastds1&gprintminds1=$gprintminds1&gprintaverageds1=$gprintaverageds1&gprintmaxds1=$gprintmaxds1&areads2=$areads2&ticknessds2=$ticknessds2&gprintlastds2=$gprintlastds2&gprintminds2=$gprintminds2&gprintaverageds2=$gprintaverageds2&gprintmaxds2=$gprintmaxds2&areads3=$areads3&ticknessds3=$ticknessds3&gprintlastds3=$gprintlastds3&gprintminds3=$gprintminds3&gprintaverageds3=$gprintaverageds3&gprintmaxds3=$gprintmaxds3&areads4=$areads4&ticknessds4=$ticknessds4&gprintlastds4=$gprintlastds4&gprintminds4=$gprintminds4&gprintaverageds4=$gprintaverageds4&gprintmaxds4=$gprintmaxds4&dsflg=$dsflg&name=".htmlentities(urlencode($oreon->services[$gr]->get_description()))." - ".htmlentities(urlencode($oreon->hosts[$oreon->services[$gr]->get_host()]->get_name()))."'><br>"; ?>
			</td>
		</tr>
	    <? } else { ?>
		<tr>
			<td style="padding-top: 1px;"><br>
			   <? echo "<div align='center' class='msg'>". sprintf($lang['g_no_access_file'], $file)."</div>"; ?>
			</td>
		</tr>
	    <? } ?>
	</table>
	</td>
</tr>
</table>
<? 	} ?>