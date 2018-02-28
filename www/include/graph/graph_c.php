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

	if (!isset($oreon->colors))
		$oreon->loadColors();

	$colors  = & $oreon->colors_list;
	unset($oreon->colors);
?>
<form action="" method="post">
<table border="0" cellpadding="3" cellspacing="0">
	<tr>
		<td class="text16b" valign="top" style="padding:px" colspan="2">
			<? print $lang['graph'].": ".$oreon->services[$gr]->get_description(); ?>&nbsp;&nbsp;&nbsp;<a href="./phpradmin.php?p=310&gr=<?= $gr ?>&o=v"><img src="./img/graph_zoom.gif" border=0></a>
			<br><br>
		</td>
		<td rowspan="8" colspan="2" valign="top">
		<?
		if (is_file($file) && is_readable($file)){
			echo "<img src='./include/graph/graph_image.php?time=-7200&time2=0&timename=".  htmlentities(urlencode($lang['g_lcurrent'])) ."&namerrd=$namerrd&path=$path&verticallabel=" . htmlentities(urlencode($verticallabel)). "&imgformat=$imgformat&width=$width&height=$height&ColGrilFond=$ColGrilFond&ColFond=$ColFond&ColPolice=$ColPolice&ColGrGril=$ColGrGril&ColPtGril=$ColPtGril&ColContCub=$ColContCub&ColArrow=$ColArrow&ColImHau=$ColImHau&ColImBa=$ColImBa&ds1name=" .  htmlentities(urlencode($ds1name))."&ds2name=" .  htmlentities(urlencode($ds2name))."&ColDs1=$ColDs1&ColDs2=$ColDs2&ds3name=" .  htmlentities(urlencode($ds3name))."&ds4name=" .  htmlentities(urlencode($ds4name))."&ColDs3=$ColDs3&ColDs4=$ColDs4&flamming=$flamming&lowerlimit=$lowerlimit&areads1=$areads1&ticknessds1=$ticknessds1&gprintlastds1=$gprintlastds1&gprintminds1=$gprintminds1&gprintaverageds1=$gprintaverageds1&gprintmaxds1=$gprintmaxds1&areads2=$areads2&ticknessds2=$ticknessds2&gprintlastds2=$gprintlastds2&gprintminds2=$gprintminds2&gprintaverageds2=$gprintaverageds2&gprintmaxds2=$gprintmaxds2&areads3=$areads3&ticknessds3=$ticknessds3&gprintlastds3=$gprintlastds3&gprintminds3=$gprintminds3&gprintaverageds3=$gprintaverageds3&gprintmaxds3=$gprintmaxds3&areads4=$areads4&ticknessds4=$ticknessds4&gprintlastds4=$gprintlastds4&gprintminds4=$gprintminds4&gprintaverageds4=$gprintaverageds4&gprintmaxds4=$gprintmaxds4&dsflg=$dsflg&name=". htmlentities(urlencode($oreon->services[$gr]->get_description()))." - ". htmlentities(urlencode($oreon->hosts[$oreon->services[$gr]->get_host()]->get_name()))."'>";
		} else {
			echo "<div align='center' class='msg'>". sprintf($lang['g_no_access_file'], $file)."</div>";
		} ?>
		</td>
	</tr>
	<? if (count($graphModels)) { ?>
	<tr>
		<td colspan="2" class="text12b" align="left">
			<? echo $lang['gmod_use_model']; ?>
			<select name="model" onChange="this.form.submit();">
				<option></option>
				<?
				foreach ($graphModels as $graphModel)	{
					echo "<option value='".$graphModel->get_id()."'";
					if (isset($_POST["model"]) && $_POST["model"] == $graphModel->get_id())
						echo " selected";
					echo ">".$graphModel->get_name()."</option>";
					unset($graphModel);
				}
				?>
			</select>
			<br><br>
		</td>
	</tr>
	<? } ?>
	<tr>
		<td colspan="2" class="text12b" style="padding-left:10px"><? echo $lang['g_basic_conf']; ?></td>
	</tr>
	<tr>
		<td style="white-space: nowrap; padding-left:20px"><? echo $lang['g_path']; ?></td>
		<td class="text10b">
			<? echo $graphs[$gr]->get_path().$gr.".rrd"; ?>
			<input type="hidden" name="graph[graph_path]" value="<? echo $graphs[$gr]->get_path(); ?>">
		</td>
	</tr>
	<tr>
		<td style="white-space: nowrap; padding-left:20px"><? echo $lang['g_imgformat']; ?></td>
		<td class="text10b">
			<select size="1" name="graph[graph_imgformat]">
				 <?
				 for ($i = 0; $i < count($imgFormat); $i++)	{
					if (!strcmp($imgFormat[$i], "GIF") && !strcmp($oreon->optGen->rrdtool_version, "1.2"))
						;
					else
					{
						echo "<option value='".$imgFormat[$i]."'";
						if (isset($_POST["model"]) && $_POST["model"] && !strcmp($graphModels[$_POST["model"]]->get_imgformat(), $imgFormat[$i]))
							echo " selected";
						else if (!isset($_POST["model"]) && !strcmp($imgFormat[$i], $graphs[$gr]->get_imgformat()))
							echo " selected";
						echo ">".$imgFormat[$i]."</option>";
				 	}
				 }
				 ?>
			 </select>
		</td>
	</tr>
	<tr>
		<td style="white-space: nowrap; padding-left:20px"><? echo $lang['g_verticallabel']; ?></td>
		<td class="text10b" style="white-space: nowrap;"><input size="20" type="text" name="graph[graph_verticallabel]" value="<? if (isset($_POST["model"]) && $_POST["model"] && $graphModels[$_POST["model"]]->get_verticallabel()) echo $graphModels[$_POST["model"]]->get_verticallabel(); else echo $graphs[$gr]->get_verticallabel(); ?>"></td>
	</tr>
	<tr>
	   <td style="white-space: nowrap; padding-left:20px"><? echo $lang['g_width']; ?></td>
	   <td class="text10b" style="white-space: nowrap;"><input size="6" type="text" name="graph[graph_width]" value="<? if (isset($_POST["model"]) && $_POST["model"]  && $graphModels[$_POST["model"]]->get_width()) echo $graphModels[$_POST["model"]]->get_width(); else echo $graphs[$gr]->get_width(); ?>"></td>
	</tr>
	<tr>
		<td style="white-space: nowrap; padding-left:20px"><? echo $lang['g_height']; ?></td>
		<td class="text10b" style="white-space: nowrap;"><input size="6" type="text" name="graph[graph_height]" value="<? if (isset($_POST["model"]) && $_POST["model"]  && $graphModels[$_POST["model"]]->get_height()) echo $graphModels[$_POST["model"]]->get_height(); else echo $graphs[$gr]->get_height(); ?>"></td>
	</tr>
	<tr>
	   <td style="white-space: nowrap; padding-left:20px"><? echo $lang['g_lowerlimit']; ?></td>
	   <td class="text10b" style="white-space: nowrap;"><input size="6" type="text" name="graph[graph_lowerlimit]" value="<? if (isset($_POST["model"]) && $_POST["model"]  && $graphModels[$_POST["model"]]->get_lowerlimit()) echo $graphModels[$_POST["model"]]->get_lowerlimit(); else echo $graphs[$gr]->get_lowerlimit(); ?>"></td>
	</tr>
	<tr>
		<td colspan="4" class="text12b"  style="padding-left:10px"><? echo $lang['g_Couleurs']; ?></td>
	</tr>
	<tr>
		<td style="white-space: nowrap; padding-left:20px"><? echo $lang['g_ColGrilFond']; ?></td>
		<td class="text10b" style="white-space: nowrap;">
			<table width="100%" border="0">
				<tr>
					<td>
						<? if (isset($_POST["model"])  && $_POST["model"] && $graphModels[$_POST["model"]]->get_ColGrilFond())
					 			$ColGrilFond = $graphModels[$_POST["model"]]->get_ColGrilFond();
					 		else
					 			$ColGrilFond = $graphs[$gr]->get_ColGrilFond();
					    echo "<select style='background: #".$ColGrilFond.";' size=\"1\" name=\"graph[graph_ColGrilFond]\" onChange=\"this.style.backgroundColor=this.value;\">";
						foreach ($colors as $color)	{
							echo "<option   style='color: #" . ($color->is_dark_color()?"FFFFFF":"000000") . "; background: #". $color->get_color() .";' value='".$color->get_color()."'";
							if (isset($ColGrilFond) && strtoupper($ColGrilFond) == $color->get_color())
								echo " selected";
							echo ">".$color->get_color()."</option>";
							unset($color);
						} ?>
						</select>
					</td>
				</tr>
			</table>
		</td>
		<td style="white-space: nowrap; padding-left:20px"><? echo $lang['g_ColFond']; ?></td>
	   	<td class="text10b" style="white-space: nowrap;">
			<table width="100%" border="0">
				<tr>
					<td>
						<? if (isset($_POST["model"])  && $_POST["model"] && $graphModels[$_POST["model"]]->get_ColFond())
					 			$ColFond = $graphModels[$_POST["model"]]->get_ColFond();
					 		else
					 			$ColFond = $graphs[$gr]->get_ColFond();
					    echo "<select style='background: #".$ColFond.";' size=\"1\" name=\"graph[graph_ColFond]\" onChange=\"this.style.backgroundColor=this.value;\">";
						foreach ($colors as $color)	{
							echo "<option   style='color: #" . ($color->is_dark_color()?"FFFFFF":"000000") . "; background: #". $color->get_color() .";' value='".$color->get_color()."'";
							if (isset($ColFond) && strtoupper($ColFond) == $color->get_color())
								echo " selected";
							echo ">".$color->get_color()."</option>";
							unset($color);
						} ?>
						</select>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td style="white-space: nowrap; padding-left:20px"><? echo $lang['g_ColPolice']; ?></td>
		<td class="text10b" style="white-space: nowrap;">
			<table width="100%" border="0">
				<tr>
					<td>
						<? if (isset($_POST["model"])  && $_POST["model"] && $graphModels[$_POST["model"]]->get_ColPolice())
					 			$ColPolice = $graphModels[$_POST["model"]]->get_ColPolice();
					 		else
					 			$ColPolice = $graphs[$gr]->get_ColPolice();
					    echo "<select style='background: #".$ColPolice.";' size=\"1\" name=\"graph[graph_ColPolice]\" onChange=\"this.style.backgroundColor=this.value;\">";
						foreach ($colors as $color)	{
							echo "<option   style='color: #" . ($color->is_dark_color()?"FFFFFF":"000000") . "; background: #". $color->get_color() .";' value='".$color->get_color()."'";
							if (isset($ColPolice) && strtoupper($ColPolice) == $color->get_color())
								echo " selected";
							echo ">".$color->get_color()."</option>";
							unset($color);
						} ?>
						</select>
					</td>
				</tr>
			</table>
		</td>
		 <td style="white-space: nowrap; padding-left:20px"><? echo $lang['g_ColGrGril']; ?></td>
	   <td class="text10b" style="white-space: nowrap;">
			<table width="100%" border="0">
				<tr>
					<td>
					<? if (isset($_POST["model"])  && $_POST["model"] && $graphModels[$_POST["model"]]->get_ColGrGril())
					 		$ColGrGril = $graphModels[$_POST["model"]]->get_ColGrGril();
					 	else
					 		$ColGrGril = $graphs[$gr]->get_ColGrGril();
					echo "<select style='background: #".$ColGrGril.";' size=\"1\" name=\"graph[graph_ColGrGril]\" onChange=\"this.style.backgroundColor=this.value;\">";
					foreach ($colors as $color)	{
						echo "<option   style='color: #" . ($color->is_dark_color()?"FFFFFF":"000000") . "; background: #". $color->get_color() .";' value='".$color->get_color()."'";
						if (isset($ColGrGril) && strtoupper($ColGrGril) == $color->get_color())
							echo " selected";
						echo ">".$color->get_color()."</option>";
						unset($color);
					} ?>
					</select>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
	   <td style="white-space: nowrap; padding-left:20px"><? echo $lang['g_ColPtGril']; ?></td>
	   <td class="text10b" style="white-space: nowrap;">
			<table width="100%" border="0">
				<tr>
				 <td>
					<? if (isset($_POST["model"])  && $_POST["model"] && $graphModels[$_POST["model"]]->get_ColPtGril())
					 		$ColPtGril = $graphModels[$_POST["model"]]->get_ColPtGril();
					 	else
					 		$ColPtGril = $graphs[$gr]->get_ColPtGril();
					echo "<select style='background: #".$ColPtGril.";' size=\"1\" name=\"graph[graph_ColPtGril]\" onChange=\"this.style.backgroundColor=this.value;\">";
					foreach ($colors as $color)	{
						echo "<option   style='color: #" . ($color->is_dark_color()?"FFFFFF":"000000") . "; background: #". $color->get_color() .";' value='".$color->get_color()."'";
						if (isset($ColPtGril) && strtoupper($ColPtGril) == $color->get_color())
							echo " selected";
						echo ">".$color->get_color()."</option>";
						unset($color);
					} ?>
					</select>
				  </td>
				</tr>
			</table>
		</td>
		<td style="white-space: nowrap; padding-left:20px"><? echo $lang['g_ColContCub']; ?></td>
		<td class="text10b" style="white-space: nowrap;">
			<table width="100%" border="0">
				<tr>
				  <td>
					<? if (isset($_POST["model"])  && $_POST["model"] && $graphModels[$_POST["model"]]->get_ColContCub())
					 		$ColContCub = $graphModels[$_POST["model"]]->get_ColContCub();
					 	else
					 		$ColContCub = $graphs[$gr]->get_ColContCub();
					echo "<select style='background: #".$ColContCub .";' size=\"1\" name=\"graph[graph_ColContCub]\" onChange=\"this.style.backgroundColor=this.value;\">";
					foreach ($colors as $color)	{
						echo "<option   style='color: #" . ($color->is_dark_color()?"FFFFFF":"000000") . "; background: #". $color->get_color() .";' value='".$color->get_color()."'";
						if (isset($ColContCub) && strtoupper($ColContCub) == $color->get_color())
							echo " selected";
						echo ">".$color->get_color()."</option>";
						unset($color);
					} ?>
					</select>
				  </td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
	   <td style="white-space: nowrap; padding-left:20px"><? echo $lang['g_ColArrow']; ?></td>
	   <td class="text10b" style="white-space: nowrap;">
			<table width="100%" border="0">
				<tr>
				  <td>
					<? if (isset($_POST["model"])  && $_POST["model"] && $graphModels[$_POST["model"]]->get_ColArrow())
					 		$ColArrow = $graphModels[$_POST["model"]]->get_ColArrow();
					 	else
					 		$ColArrow = $graphs[$gr]->get_ColArrow();
					echo "<select style='background: #".$ColArrow .";' size=\"1\" name=\"graph[graph_ColArrow]\" onChange=\"this.style.backgroundColor=this.value;\">";
					foreach ($colors as $color)	{
						echo "<option   style='color: #" . ($color->is_dark_color()?"FFFFFF":"000000") . "; background: #". $color->get_color() .";' value='".$color->get_color()."'";
						if (isset($ColArrow) && strtoupper($ColArrow) == $color->get_color())
							echo " selected";
						echo ">".$color->get_color()."</option>";
						unset($color);
					} ?>
					</select>
				  </td>
				</tr>
			</table>
		</td>
		<td style="white-space: nowrap; padding-left:20px"><? echo $lang['g_ColImHau']; ?></td>
	   <td class="text10b" style="white-space: nowrap;">
			<table width="100%" border="0">
				<tr>
				  <td>
					<? if (isset($_POST["model"])  && $_POST["model"] && $graphModels[$_POST["model"]]->get_ColImHau())
					 		$ColImHau = $graphModels[$_POST["model"]]->get_ColImHau();
					 	else
					 		$ColImHau = $graphs[$gr]->get_ColImHau();
					echo "<select style='background: #".$ColImHau .";' size=\"1\" name=\"graph[graph_ColImHau]\" onChange=\"this.style.backgroundColor=this.value;\">";
					foreach ($colors as $color)	{
						echo "<option   style='color: #" . ($color->is_dark_color()?"FFFFFF":"000000") . "; background: #". $color->get_color() .";' value='".$color->get_color()."'";
						if (isset($ColImHau) && strtoupper($ColImHau) == $color->get_color())
							echo " selected";
						echo ">".$color->get_color()."</option>";
						unset($color);
					} ?>
					</select>
				  </td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
	   <td style="white-space: nowrap; padding-left:20px"><? echo $lang['g_ColImBa']; ?></td>
	   <td class="text10b" style="white-space: nowrap;">
			<table width="100%" border="0">
				<tr>
				  <td>
					<? if (isset($_POST["model"])  && $_POST["model"] && $graphModels[$_POST["model"]]->get_ColImBa())
					 		$ColImBa = $graphModels[$_POST["model"]]->get_ColImBa();
					 	else
					 		$ColImBa = $graphs[$gr]->get_ColImBa();
					echo "<select style='background: #".$ColImBa.";' size=\"1\" name=\"graph[graph_ColImBa]\" onChange=\"this.style.backgroundColor=this.value;\">";
					foreach ($colors as $color)	{
						echo "<option style='color: #" . ($color->is_dark_color()?"FFFFFF":"000000") . "; background: #". $color->get_color() .";' value='".$color->get_color()."'";
						if (isset($ColImBa) && strtoupper($ColImBa) == $color->get_color())
							echo " selected";
						echo ">".$color->get_color()."</option>";
						unset($color);
					} ?>
					</select>
				  </td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="4"><hr></td>
	</tr>
<?
$iArr = array();
foreach ($_POST as $key=>$value)
	if (preg_match('/modelDS([0-9]+)/', $key, $regs))
		$iArr[$regs[1]] = $value;
for ($i = 1; $dsflg >= $i; $i++) {
	if (!isset($iArr[$i]))
		$iArr[$i] = NULL;
	if (($i % 2) == 0)
		print "<td colspan=2 valign='top'>";
	else
		print "<tr><td colspan=2 valign='top'>";
	?>
		<fieldset><legend class="text12b" align="top"><font class="text12b"><? echo $lang['g_ds']. " ".$i; ?></font></legend>
		<table border=0>
		<? if (count($graphModelDS)) { ?>
		<tr>
			<td colspan="2" class="text12b" align="left">
				<? echo $lang['gmod_use_model']; ?>
				<select name="modelDS<? echo $i; ?>" onChange="this.form.submit();">
					<option></option>
					<?
					foreach ($graphModelDS as $graphModelDS_)	{
						echo "<option value='".$graphModelDS_->get_id()."'";
						if (array_key_exists($i, $iArr) && $iArr[$i] == $graphModelDS_->get_id())
							echo " selected";
						echo ">".$graphModelDS_->get_alias()."</option>";
						unset($graphModelDS_);
					}
					?>
				</select>
				<br><br>
			</td>
		</tr>
		<? } ?>
		<tr>
		   <td style="white-space: nowrap;"><? echo $lang['g_dsname']; ?></td>
		   <td class="text10b" style="white-space: nowrap;">
		   		<input size="20" type="text" name="graph[graph_ds<? print $i; ?>name]" value="<?	if (isset($graphModelDS[$iArr[$i]]))	echo $graphModelDS[$iArr[$i]]->get_name(); else echo $graphs[$gr]->get_dsname($i); ?>">
			</td>
		</tr>
		<tr>
		   <td style="white-space: nowrap;"><? echo $lang['g_ColDs']; ?></td>
		   <td class="text10b" style="white-space: nowrap;">
				<table width="100%" border="0">
					<tr>
						<td>
						<?  if (isset($graphModelDS[$iArr[$i]]))
						 		$Col = $graphModelDS[$iArr[$i]]->get_Col();
						 	else
						 		$Col = $graphs[$gr]->get_ColDs($i);

						echo "<select style='background: #".$Col.";' size=\"1\" name=\"graph[graph_ColDs".$i."]\" onChange=\"this.style.backgroundColor=this.value;\">";
						foreach ($colors as $color)	{
							echo "<option style='color: #" . ($color->is_dark_color()?"FFFFFF":"000000") . "; background: #". $color->get_color() .";' value='".$color->get_color()."'";
							if (isset($Col) && strtoupper($Col) == $color->get_color())
								echo " selected";
							echo ">".$color->get_color()."</option>";
							unset($color);
						} ?>
						</select>
					  </td>
					</tr>
				</table>
			</td>
		</tr>
		<? if ($i <= 1) { ?>
		<tr>
		   <td style="white-space: nowrap;"><? echo $lang['g_flamming']; ?></td>
		   <td class="text10b" style="white-space: nowrap;">
			<select name="graph[graph_flamming]">
				<option value="yes" <? if (isset($graphModelDS[$iArr[$i]]) && !strcmp($graphModelDS[$iArr[$i]]->get_flamming(), "yes"))	echo "selected";  else if (!isset($graphModelDS[$iArr[$i]]) && !strcmp($graphs[$gr]->get_flamming(), "yes")) echo "selected";?>>yes</option>
				<option value="no" <? if (isset($graphModelDS[$iArr[$i]]) && !strcmp($graphModelDS[$iArr[$i]]->get_flamming(), "no")) echo "selected"; else if (!isset($graphModelDS[$iArr[$i]]) && !strcmp($graphs[$gr]->get_flamming(), "no")) echo "selected";?>>no</option>
			</select>
			</td>
		</tr>
		<? } ?>
		<tr>
		   <td style="white-space: nowrap;"><? echo $lang['g_Area']; ?></td>
		   <td class="text10b" style="white-space: nowrap;">
			<select name="graph[graph_areads<? print $i ; ?>]">
				<option value="yes" <? if (isset($graphModelDS[$iArr[$i]]) && !strcmp($graphModelDS[$iArr[$i]]->get_area(), "yes")) echo "selected"; else if (!isset($graphModelDS[$iArr[$i]]) && strcmp($graphs[$gr]->get_areads($i), "yes")) echo "selected";?>>yes</option>
				<option value="no" <? if (isset($graphModelDS[$iArr[$i]]) && !strcmp($graphModelDS[$iArr[$i]]->get_area(), "no")) echo "selected"; else if (!isset($graphModelDS[$iArr[$i]]) && !strcmp($graphs[$gr]->get_areads($i), "no")) echo "selected";?>>no</option>
			</select>
			</td>
		</tr>
		<tr>
		   <td style="white-space: nowrap;"><? echo $lang['g_tickness']; ?></td>
		   <td class="text10b" style="white-space: nowrap;">
			<select name="graph[graph_ticknessds<? print $i ; ?>]">
				<option value="1" <? if (isset($graphModelDS[$iArr[$i]]) && !strcmp($graphModelDS[$iArr[$i]]->get_tickness(), "1")) echo "selected"; else if (!isset($graphModelDS[$iArr[$i]]) && !strcmp($graphs[$gr]->get_ticknessds($i), "1")) echo "selected";?>>1</option>
				<option value="2" <? if (isset($graphModelDS[$iArr[$i]]) && !strcmp($graphModelDS[$iArr[$i]]->get_tickness(), "2")) echo "selected"; else if (!isset($graphModelDS[$iArr[$i]]) && !strcmp($graphs[$gr]->get_ticknessds($i), "2")) echo "selected";?>>2</option>
				<option value="3" <? if (isset($graphModelDS[$iArr[$i]]) && !strcmp($graphModelDS[$iArr[$i]]->get_tickness(), "3")) echo "selected"; else if (!isset($graphModelDS[$iArr[$i]]) && !strcmp($graphs[$gr]->get_ticknessds($i), "3")) echo "selected";?>>3</option>
			</select>
			</td>
		</tr>
		<tr>
		   <td style="white-space: nowrap;"><? echo $lang['g_gprintlastds']; ?></td>
		   <td class="text10b" style="white-space: nowrap;">
			<select name="graph[graph_gprintlastds<? print $i; ?>]">
				<option value="yes" <? if (isset($graphModelDS[$iArr[$i]]) && !strcmp($graphModelDS[$iArr[$i]]->get_gprintlast(), "yes")) echo "selected"; else if (!isset($graphModelDS[$iArr[$i]]) && !strcmp($graphs[$gr]->get_gprintlastds($i), "yes")) echo "selected";?>>yes</option>
				<option value="no" <?  if (isset($graphModelDS[$iArr[$i]]) && !strcmp($graphModelDS[$iArr[$i]]->get_gprintlast(), "no")) echo "selected"; else if (!isset($graphModelDS[$iArr[$i]]) && !strcmp($graphs[$gr]->get_gprintlastds($i), "no")) echo "selected";?>>no</option>
			</select>
			</td>
		</tr>
		<tr>
		   <td style="white-space: nowrap;"><? echo $lang['g_gprintminds']; ?></td>
		   <td class="text10b" style="white-space: nowrap;">
			<select name="graph[graph_gprintminds<? print $i; ?>]">
				<option value="yes" <? if (isset($graphModelDS[$iArr[$i]]) && !strcmp($graphModelDS[$iArr[$i]]->get_gprintmin(), "yes")) echo "selected"; else if (!isset($graphModelDS[$iArr[$i]]) && !strcmp($graphs[$gr]->get_gprintminds($i), "yes")) echo "selected";?>>yes</option>
				<option value="no" <? if (isset($graphModelDS[$iArr[$i]]) && !strcmp($graphModelDS[$iArr[$i]]->get_gprintmin(), "no")) echo "selected"; else if (!isset($graphModelDS[$iArr[$i]]) && !strcmp($graphs[$gr]->get_gprintminds($i), "no")) echo "selected";?>>no</option>
			</select>
			</td>
		</tr>
		<tr>
		   <td style="white-space: nowrap;"><? echo $lang['g_gprintaverageds']; ?></td>
		   <td class="text10b" style="white-space: nowrap;">
			<select name="graph[graph_gprintaverageds<? print $i ; ?>]">
				<option value="yes" <? if (isset($graphModelDS[$iArr[$i]]) && !strcmp($graphModelDS[$iArr[$i]]->get_gprintaverage(), "yes")) echo "selected";	else if (!isset($graphModelDS[$iArr[$i]]) && !strcmp($graphs[$gr]->get_gprintaverageds($i), "yes")) echo "selected";?>>yes</option>
				<option value="no" <? if (isset($graphModelDS[$iArr[$i]]) && !strcmp($graphModelDS[$iArr[$i]]->get_gprintaverage(), "no")) echo "selected"; else if (!isset($graphModelDS[$iArr[$i]]) && !strcmp($graphs[$gr]->get_gprintaverageds($i), "no")) echo "selected";?>>no</option>
			</select>
			</td>
		</tr>
		<tr>
		   <td style="white-space: nowrap;"><? echo $lang['g_gprintmaxds']; ?></td>
		   <td class="text10b" style="white-space: nowrap;">
			<select name="graph[graph_gprintmaxds<? print $i ; ?>]">
				<option value="yes" <?  if (isset($graphModelDS[$iArr[$i]]) && !strcmp($graphModelDS[$iArr[$i]]->get_gprintmax(), "yes")) echo "selected"; else if (!isset($graphModelDS[$iArr[$i]]) && !strcmp($graphs[$gr]->get_gprintmaxds($i), "yes")) echo "selected";?>>yes</option>
				<option value="no" <? if (isset($graphModelDS[$iArr[$i]]) && !strcmp($graphModelDS[$iArr[$i]]->get_gprintmax(), "no")) echo "selected"; else if (!isset($graphModelDS[$iArr[$i]]) && !strcmp($graphs[$gr]->get_gprintmaxds($i), "no")) echo "selected";?>>no</option>
			</select>
			</td>
		</tr>
		</table>
		</fieldset>
	<? 	}	unset($_POST["modelDS$i"]);?>
		<tr>
			<td colspan="4" align="center">
			<input type="hidden" name="graph[graph_id]" value="<? echo $gr ?>">
			<input type="submit" name="ChangeGR" value="<? echo $lang['save']; ?>">
			</td>
		</tr>
		<?
		if (($i % 2) != 0)
			print "</td></tr>";
		else
			print "</td>";
		?>
</table>
</form>