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
<table border="0" cellpadding="3" cellspacing="0" align="left">
	<tr>
		<td class="text16b" valign="top" style="padding:5px" colspan="2">
			<? echo $lang['graph']; ?> : <? print $oreon->services[$gr]->get_description(); ?>&nbsp;&nbsp;&nbsp;
			<a href="./phpradmin.php?p=310&gr=<? echo $gr; ?>&o=v"><img src="./img/graph_zoom.gif" border=0></a>&nbsp;&nbsp;&nbsp;
			<a href='./phpradmin.php?p=310&gr=<? echo $gr; ?>&o=c'><img src='./img/graph_properties.gif' border=0 width='16'></a>
			<br><br>
		</td>
		<td rowspan="8" colspan="2" style="padding-left: 5px;">
		<?
		$file = $oreon->optGen->get_rrd_base_pwd().$gr.".rrd";
		if (is_file($file) && is_readable($file) ){
			echo "<img src='./include/graph/graph_image.php?time=-7200&time2=0&timename=".  htmlentities(urlencode($lang['g_lcurrent'])) ."&namerrd=$namerrd&path=$path&verticallabel=" . htmlentities(urlencode($verticallabel)). "&imgformat=$imgformat&width=$width&height=$height&ColGrilFond=$ColGrilFond&ColFond=$ColFond&ColPolice=$ColPolice&ColGrGril=$ColGrGril&ColPtGril=$ColPtGril&ColContCub=$ColContCub&ColArrow=$ColArrow&ColImHau=$ColImHau&ColImBa=$ColImBa&ds1name=".htmlentities(urlencode($ds1name))."&ds2name=".htmlentities(urlencode($ds2name))."&ColDs1=$ColDs1&ColDs2=$ColDs2&ds3name=".htmlentities(urlencode($ds3name))."&ds4name=".htmlentities(urlencode($ds4name))."&ColDs3=$ColDs3&ColDs4=$ColDs4&flamming=$flamming&lowerlimit=$lowerlimit&areads1=$areads1&ticknessds1=$ticknessds1&gprintlastds1=$gprintlastds1&gprintminds1=$gprintminds1&gprintaverageds1=$gprintaverageds1&gprintmaxds1=$gprintmaxds1&areads2=$areads2&ticknessds2=$ticknessds2&gprintlastds2=$gprintlastds2&gprintminds2=$gprintminds2&gprintaverageds2=$gprintaverageds2&gprintmaxds2=$gprintmaxds2&areads3=$areads3&ticknessds3=$ticknessds3&gprintlastds3=$gprintlastds3&gprintminds3=$gprintminds3&gprintaverageds3=$gprintaverageds3&gprintmaxds3=$gprintmaxds3&areads4=$areads4&ticknessds4=$ticknessds4&gprintlastds4=$gprintlastds4&gprintminds4=$gprintminds4&gprintaverageds4=$gprintaverageds4&gprintmaxds4=$gprintmaxds4&dsflg=$dsflg&name=".htmlentities(urlencode($oreon->services[$gr]->get_description()))." - ".htmlentities(urlencode($oreon->hosts[$oreon->services[$gr]->get_host()]->get_name()))."'>";
	 	} else {
			echo "<div align='center' class='msg'>". sprintf($lang['g_no_access_file'], $file)."</div>";
		} ?>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="text12b" style="padding-left:10px"><? echo $lang['g_basic_conf']; ?></td>
	</tr>
	<tr>
		<td style="white-space: nowrap; padding-left:20px"><? echo $lang['g_path']; ?></td>
		<td class="text10b"><? echo $graphs[$gr]->get_path().$gr.".rrd"; ?></td>
	</tr>
	<tr>
		<td style="white-space: nowrap; padding-left:20px"><? echo $lang['g_imgformat']; ?></td>
		<td class="text10b"><? print $graphs[$gr]->get_imgformat(); ?></td>
	</tr>
	<tr>
		<td style="white-space: nowrap; padding-left:20px"><? echo $lang['g_verticallabel']; ?></td>
		<td class="text10b" style="white-space: nowrap;"><? echo $graphs[$gr]->get_verticallabel(); ?></td>
	</tr>
	<tr>
	   <td style="white-space: nowrap; padding-left:20px"><? echo $lang['g_width']; ?></td>
	   <td class="text10b" style="white-space: nowrap;"><? echo $graphs[$gr]->get_width(); ?></td>
	</tr>
	<tr>
		<td style="white-space: nowrap; padding-left:20px"><? echo $lang['g_height']; ?></td>
		<td class="text10b" style="white-space: nowrap;"><? echo $graphs[$gr]->get_height(); ?></td>
	</tr>
	<tr>
	   <td style="white-space: nowrap; padding-left:20px"><? echo $lang['g_lowerlimit']; ?></td>
	   <td class="text10b" style="white-space: nowrap;"><? echo $graphs[$gr]->get_lowerlimit(); ?></td>
	</tr>
	<tr>
		<td colspan="4" class="text12b"  style="padding-left:10px"><? echo $lang['g_Couleurs']; ?></td>
	</tr>
	<tr>
		<td style="white-space: nowrap; padding-left:20px"><? echo $lang['g_ColGrilFond']; ?></td>
		<td class="text10b" style="white-space: nowrap;">
			<table width="100%" border="0">
				<tr>
					<td width="10" bgcolor="#<? echo $graphs[$gr]->get_ColGrilFond(); ?>" id="changeColGrilFond"></td>
					<td><? echo $graphs[$gr]->get_ColGrilFond(); ?></td>
				</tr>
			</table>
		</td>
		<td style="white-space: nowrap; padding-left:20px"><? echo $lang['g_ColFond']; ?></td>
	   	<td class="text10b" style="white-space: nowrap;">
			<table width="100%" border="0">
				<tr>
					<td width="10" bgcolor="#<? echo $graphs[$gr]->get_ColFond(); ?>" id="changeColFond"></td>
					<td><? echo $graphs[$gr]->get_ColFond(); ?></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td style="white-space: nowrap; padding-left:20px"><? echo $lang['g_ColPolice']; ?></td>
		<td class="text10b" style="white-space: nowrap;">
			<table width="100%" border="0">
				<tr>
					<td width="10" bgcolor="#<? echo $graphs[$gr]->get_ColPolice(); ?>" id="changeColPolice"></td>
					<td><? echo $graphs[$gr]->get_ColPolice(); ?></td>
				</tr>
			</table>
		</td>
		 <td style="white-space: nowrap; padding-left:20px"><? echo $lang['g_ColGrGril']; ?></td>
	   <td class="text10b" style="white-space: nowrap;">
			<table width="100%" border="0">
				<tr>
					<td width="10" bgcolor="#<? echo $graphs[$gr]->get_ColGrGril(); ?>" id="changeColGrGril"></td>
					<td><? echo $graphs[$gr]->get_ColGrGril(); ?></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
	   <td style="white-space: nowrap; padding-left:20px"><? echo $lang['g_ColPtGril']; ?></td>
	   <td class="text10b" style="white-space: nowrap;">
			<table width="100%" border="0">
				<tr>
					<td width="10" bgcolor="#<? echo $graphs[$gr]->get_ColPtGril(); ?>" id="changeColPtGril"></td>
					<td><? echo $graphs[$gr]->get_ColPtGril(); ?></td>
				</tr>
			</table>
		</td>
		<td style="white-space: nowrap; padding-left:20px"><? echo $lang['g_ColContCub']; ?></td>
		<td class="text10b" style="white-space: nowrap;">
			<table width="100%" border="0">
				<tr>
					<td width="10" bgcolor="#<? echo $graphs[$gr]->get_ColContCub(); ?>" id="changeColContCub"></td>
					<td><? echo $graphs[$gr]->get_ColContCub(); ?></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
	   <td style="white-space: nowrap; padding-left:20px"><? echo $lang['g_ColArrow']; ?></td>
	   <td class="text10b" style="white-space: nowrap;">
			<table width="100%" border="0">
				<tr>
					<td width="10" bgcolor="#<? echo $graphs[$gr]->get_ColArrow(); ?>" id="changeColArrow"></td>
					<td><? echo $graphs[$gr]->get_ColArrow(); ?></td>
				</tr>
			</table>
		</td>
		<td style="white-space: nowrap; padding-left:20px"><? echo $lang['g_ColImHau']; ?></td>
	   <td class="text10b" style="white-space: nowrap;">
			<table width="100%" border="0">
				<tr>
					<td width="10" bgcolor="#<? echo $graphs[$gr]->get_ColImHau(); ?>" id="changeColImHau"></td>
					<td><? echo $graphs[$gr]->get_ColImHau(); ?></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
	   <td style="white-space: nowrap; padding-left:20px"><? echo $lang['g_ColImBa']; ?></td>
	   <td class="text10b" style="white-space: nowrap;">
			<table width="100%" border="0">
				<tr>
					<td width="10" bgcolor="#<? echo $graphs[$gr]->get_ColImBa(); ?>" id="changeColImBa"></td>
					<td><? echo $graphs[$gr]->get_ColImBa(); ?></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="4"><hr></td>
	</tr>
<?
for ($i = 1; $dsflg >= $i; $i++) {
	if (($i % 2) == 0)
		print "<td colspan=2 valign='top'>";
	else
		print "<tr><td colspan=2 valign='top'>";
	?>
		<fieldset><legend class="text12b" align="top"><font class="text12b"><? echo $lang['g_ds']; ?> : <? echo $i; ?></font></legend>
		<table border=0>
		<tr>
		   <td style="white-space: nowrap;"><? echo $lang['g_dsname']; ?></td>
		   <td class="text10b" style="white-space: nowrap;"><? echo $graphs[$gr]->get_dsname($i); ?></td>
		</tr>
		<tr>
		   <td style="white-space: nowrap;"><? echo $lang['g_ColDs']; ?></td>
		   <td class="text10b" style="white-space: nowrap;">
		   		<table width="100%" border="0">
					<tr>
						<td width="10" bgcolor="#<? echo $graphs[$gr]->get_ColDs($i); ?>" id="changeColDs<? print $i; ?>"></td>
						<td><? echo $graphs[$gr]->get_ColDs($i); ?></td>
					</tr>
				</table>
		 	</td>
		</tr>
		<? if ($i <= 1) { ?>
		<tr>
		   <td style="white-space: nowrap;"><? echo $lang['g_flamming']; ?></td>
		   <td class="text10b" style="white-space: nowrap;"><? print $graphs[$gr]->get_flamming(); ?></td>
		</tr>
		<? } ?>
		<tr>
		   <td style="white-space: nowrap;"><? echo $lang['g_Area']; ?></td>
		   <td class="text10b" style="white-space: nowrap;"><? print $graphs[$gr]->get_areads($i); ?></td>
		</tr>
		<tr>
		   <td style="white-space: nowrap;"><? echo $lang['g_tickness']; ?></td>
		   <td class="text10b" style="white-space: nowrap;"><? print $graphs[$gr]->get_ticknessds($i); ?></td>
		</tr>
		<tr>
		   <td style="white-space: nowrap;"><? echo $lang['g_gprintlastds']; ?></td>
		   <td class="text10b" style="white-space: nowrap;"><? print $graphs[$gr]->get_gprintlastds($i); ?></td>
		</tr>
		<tr>
		   <td style="white-space: nowrap;"><? echo $lang['g_gprintminds']; ?></td>
		   <td class="text10b" style="white-space: nowrap;"><? print $graphs[$gr]->get_gprintminds($i); ?></td>
		</tr>
		<tr>
		   <td style="white-space: nowrap; padding-right: 15px;"><? echo $lang['g_gprintaverageds']; ?></td>
		   <td class="text10b" style="white-space: nowrap;"><? print $graphs[$gr]->get_gprintaverageds($i); ?></td>
		</tr>
		<tr>
		   <td style="white-space: nowrap;"><? echo $lang['g_gprintmaxds']; ?></td>
		   <td class="text10b" style="white-space: nowrap;"><? print $graphs[$gr]->get_gprintmaxds($i); ?></td>
		</tr>
		</table>
		</fieldset>
	<? 	}
		if (($i % 2) != 0)
			print "</td></tr>";
		else
			print "</td>";
		?>
</table>