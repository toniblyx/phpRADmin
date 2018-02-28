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
?>
<table align="center" border="0" cellpadding="0" cellspacing="0">
<?
$flg = NULL;
if (isset($oreon->hosts[$_GET["gr"]]->services))
	foreach ($oreon->hosts[$_GET["gr"]]->services as $s) {
		$file = $oreon->optGen->get_rrd_base_pwd().$s->get_id().".rrd" ;
		if (array_key_exists($s->get_id(), $oreon->graphs)  ){
			$gr = $s->get_id();
			$namerrd = $gr.".rrd";
			$path = $graphs[$gr]->get_path();
			$verticallabel = html_entity_decode(urldecode($graphs[$gr]->get_verticallabel()));
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
			$stdout = shell_exec($oreon->optGen->get_rrd_pwd()." info ".$file);
			$tab = preg_split ("/[\n]+/", htmlentities($stdout));
			for ($i = 0, $dsflg = 1; $tab[$i]; $i++) {
				if (!strncmp($tab[$i], "ds[b]", 5))
					$dsflg = 2;
				if (!strncmp($tab[$i], "ds[c]", 5))
					$dsflg = 3;
				if (!strncmp($tab[$i], "ds[d]", 5))
					$dsflg = 4;
			}
			if (!$flg)	{
				echo '<tr><td style="padding-top: 1px;" valign="top" class="tabTableTitle">';
				echo "<div class='text14b'>".$lang['g_available']." - ".$oreon->hosts[$_GET["gr"]]->name."</div>";
				echo "</td></tr>";
			}
			echo '<tr><td style="padding-top: 1px;padding-left:10px;padding-right:10px;" valign="top" class="tabTable">';
			print '<div class="text12b" style="padding-top:5px;"><a href="./phpradmin.php?p=310&gr='.$s->get_id().'&o=v" class="text12b">'.$lang['s'].' : ' . $s->get_description() . "</a>&nbsp;&nbsp;";
			print "<a href='./phpradmin.php?p=310&gr=".$s->get_id()."&o=c'><img src='./img/graph_properties.gif' border=0 width='16'></a></div>";
			if ( is_file($file) && is_readable($file) ) {
				print "<a href=\"./phpradmin.php?p=310&gr=".$s->get_id()."&o=v\"><img src='./include/graph/graph_image.php?time=-86400&time2=0&timename=".  htmlentities(urlencode($lang['g_lcurrent'])) ."&namerrd=$namerrd&path=$path&verticallabel=" . htmlentities(urlencode($verticallabel)). "&imgformat=$imgformat&width=$width&height=$height&ColGrilFond=$ColGrilFond&ColFond=$ColFond&ColPolice=$ColPolice&ColGrGril=$ColGrGril&ColPtGril=$ColPtGril&ColContCub=$ColContCub&ColArrow=$ColArrow&ColImHau=$ColImHau&ColImBa=$ColImBa&ds1name=" . htmlentities(urlencode($ds1name)) ."&ds2name=" . htmlentities(urlencode($ds2name)). "&ColDs1=$ColDs1&ColDs2=$ColDs2&ds3name=" . htmlentities(urlencode($ds3name)). "&ds4name=" . htmlentities(urlencode($ds4name)). "&ColDs3=$ColDs3&ColDs4=$ColDs4&flamming=$flamming&lowerlimit=$lowerlimit&areads1=$areads1&ticknessds1=$ticknessds1&gprintlastds1=$gprintlastds1&gprintminds1=$gprintminds1&gprintaverageds1=$gprintaverageds1&gprintmaxds1=$gprintmaxds1&areads2=$areads2&ticknessds2=$ticknessds2&gprintlastds2=$gprintlastds2&gprintminds2=$gprintminds2&gprintaverageds2=$gprintaverageds2&gprintmaxds2=$gprintmaxds2&areads3=$areads3&ticknessds3=$ticknessds3&gprintlastds3=$gprintlastds3&gprintminds3=$gprintminds3&gprintaverageds3=$gprintaverageds3&gprintmaxds3=$gprintmaxds3&areads4=$areads4&ticknessds4=$ticknessds4&gprintlastds4=$gprintlastds4&gprintminds4=$gprintminds4&gprintaverageds4=$gprintaverageds4&gprintmaxds4=$gprintmaxds4&dsflg=$dsflg&name=".htmlentities(urlencode($s->get_description()))."' border=0></a><br>";	
			$flg++;
			?>
				</td>
			</tr>
			<?
			
		}
	}
	 if (!$flg)
	 	echo "<tr><td><div style='padding-bottom: 10px;' class='msg' align='center'>".$lang['g_no_graphs']."</div></td></tr>";
}
	 ?>
	 <tr>
		<td height="1" style="margin-top:10px;" class="tabTable">&nbsp;</td>
	 </tr>
	 <tr>
		<td bgcolor="#CCCCCC" height="1"></td>
	</tr>
</table>