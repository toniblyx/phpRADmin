<?
/**
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Jean Baptiste Gouret - Julien Mathis - Romain Le Merlus - Christophe Coraboeuf

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
	if (!isset($oreon))
		exit();

	if (!isset($oreon->colors))
		$oreon->loadColors();

	$graphModels = & $oreon->graphModels;
	$graphModelDS = & $oreon->graphModelDS;
	$colors  = & $oreon->colors_list;

	unset($oreon->colors);
/*	if (isset($_GET) && array_key_exists("o", $_GET) && $_GET["o"] != "a")
		if (!isset($_GET["gmod"]) || (isset($_GET["gmod"]) && !array_key_exists($_GET["gmod"], $graphModels)))	{
			echo "<td width='85%'></td>";
			include ("./footer.php");
			exit();
		}*/
	if (isset($_POST["ChangeGmod"]))	{
		$gmod_array = & $_POST["gmod"];
		$gmod_object = new GraphModel($gmod_array);
		if ($gmod_object->is_complete($oreon->user->get_version()) && $gmod_object->twiceTest($graphModels))	{
			// log oreon
			system("echo \"[" . time() . "] ChangeGraphModel;" . $gmod_object->get_name() . ";" . $oreon->user->get_alias() . "\" >> ./include/log/" . date("Ymd") . ".txt");
			$graphModels[$gmod_object->get_id()] = $gmod_object;
			$oreon->saveGraphModel($graphModels[$gmod_object->get_id()]);
			$msg = $lang['errCode'][2];
			$_GET["o"] = "w";
			$_GET["type"] = "1";
		}
		else
			$msg = $lang['errCode'][$gmod_object->get_errCode()];
		unset ($gmod_object);
	}
	if (isset($_POST["ChangeGmodDS"]))	{
		$gmodDS_array = & $_POST["gmodDS"];
		$gmodDS_object = new GraphModelDS($gmodDS_array);
		if ($gmodDS_object->is_complete($oreon->user->get_version()) && $gmodDS_object->twiceTest($graphModelDS))	{
			// log oreon
			system("echo \"[" . time() . "] ChangeGraphModelDS;" . $gmodDS_object->get_name() . ";" . $oreon->user->get_alias() . "\" >> ./include/log/" . date("Ymd") . ".txt");
			$graphModelDS[$gmodDS_object->get_id()] = $gmodDS_object;
			$oreon->saveGraphModelDS($graphModelDS[$gmodDS_object->get_id()]);
			$msg = $lang['errCode'][2];
			$_GET["o"] = "w";
			$_GET["type"] = "2";
		}
		else
			$msg = $lang['errCode'][$gmodDS_object->get_errCode()];
		unset ($gmodDS_object);
	}
	if (isset($_POST["AddGmod"]))	{
		$gmod_array = & $_POST["gmod"];
		$gmod_array["gmod_id"] = -1;
		$gmod_object = new GraphModel($gmod_array);
		if ($gmod_object->is_complete($oreon->user->get_version()) && $gmod_object->twiceTest($graphModels))	{
			// log oreon
			system("echo \"[" . time() . "] AddGraphModel;" . $gmod_object->get_name() . ";" . $oreon->user->get_alias() . "\" >> ./include/log/" . date("Ymd") . ".txt");
			$oreon->saveGraphModel($gmod_object);
			$gmod_id = $oreon->database->database->get_last_id();
			$graphModels[$gmod_id] = $gmod_object;
			$graphModels[$gmod_id]->set_id($gmod_id);
			$msg = $lang['errCode'][3];
			$_GET["o"] = "w";
			$_GET["gmod"] = $gmod_id;
			$_GET["type"] = 1;
		}
		else
			$msg = $lang['errCode'][$gmod_object->get_errCode()];
		unset ($gmod_object);
	}
	if (isset($_POST["AddGmodDS"]))	{
		$gmodDS_array = & $_POST["gmodDS"];
		$gmodDS_array["gmod_ds_id"] = -1;
		$gmodDS_object = new GraphModelDS($gmodDS_array);
		if ($gmodDS_object->is_complete($oreon->user->get_version()) && $gmodDS_object->twiceTest($graphModelDS))	{
			// log oreon
			system("echo \"[" . time() . "] AddGraphModelDS;" . $gmodDS_object->get_alias() . ";" . $oreon->user->get_alias() . "\" >> ./include/log/" . date("Ymd") . ".txt");
			$oreon->saveGraphModelDS($gmodDS_object);
			$gmodDS_id = $oreon->database->database->get_last_id();
			$graphModelDS[$gmodDS_id] = $gmodDS_object;
			$graphModelDS[$gmodDS_id]->set_id($gmodDS_id);
			$msg = $lang['errCode'][3];
			$_GET["o"] = "w";
			$_GET["gmod_ds"] = $gmodDS_id;
			$_GET["type"] = 2;
		}
		else
			$msg = $lang['errCode'][$gmodDS_object->get_errCode()];
		unset ($gmodDS_object);
	}
	if (isset($_POST["AddColor"]))	{
		$color_array = & $_POST["color"];
		$color_array["color_id"] = -1;
		$color_object = new Colors($color_array);

		// log oreon
		system("echo \"[" . time() . "] AddColor;" . $color_object->get_color() . ";" . $oreon->user->get_alias() . "\" >> ./include/log/" . date("Ymd") . ".txt");
		$oreon->saveColor($color_object);
		$color_id = $oreon->database->database->get_last_id();
		$color_object->set_id($color_id);
		$colors[$color_id] = $color_object;
		$msg = $lang['errCode'][3];
		$_GET["o"] = "a";
		$_GET["type"] = 3;
		unset ($color_object);
	}



	if (isset($_GET["o"]) && !strcmp($_GET["o"], "d") && isset($_GET["type"]))	{
		if ($_GET["type"] == 1)	{
			// log oreon
			system("echo \"[" . time() . "] DeleteGraphModel;" . $graphModels[$_GET["gmod"]]->get_name() . ";" . $oreon->user->get_alias() . "\" >> ./include/log/" . date("Ymd") . ".txt");
			$oreon->deleteGraphModel($graphModels[$_GET["gmod"]]);
			unset($_GET["gmod"]);
		}	else if ($_GET["type"] == 2)	{
			// log oreon
			system("echo \"[" . time() . "] DeleteGraphModelDS;" . $graphModelDS[$_GET["gmod_ds"]]->get_name() . ";" . $oreon->user->get_alias() . "\" >> ./include/log/" . date("Ymd") . ".txt");
			$oreon->deleteGraphModelDS($graphModelDS[$_GET["gmod_ds"]]);
		unset($_GET["gmod_ds"]);
		} else if ($_GET["type"] == 3)	{
			// log oreon
			system("echo \"[" . time() . "] DeleteColor;" . $colors[$_GET["color"]]->get_color() . ";" . $oreon->user->get_alias() . "\" >> ./include/log/" . date("Ymd") . ".txt");
			$oreon->deleteColor($colors[$_GET["color"]]);
			unset($colors[$_GET["color"]]);
		unset($_GET["color"]);
		}
		unset($_GET["o"]);
	}

	// -----------------------------------
	function write_gmod_list($graphModels, $lang)	{
		?>
		<table cellpadding="0" cellspacing="0" width="160">
			<tr>
				<td class="tabTableTitleMenu"><? echo $lang['m_options']; ?></td>
			</tr>
			<tr>
				<td class="tabTableMenu">
					<div style="padding: 8px; text-align: center;">
						<img src="img/picto2.gif">
						<a href="phpradmin.php?p=319&o=a&type=1" class="text9"><? echo $lang['add']; ?></a>
						<img src="img/picto2_bis.gif">
					</div>
				</td>
			</tr>
		</table>
		<br>
		<table border="0" cellpadding="0" cellspacing="0" width="160">
		<tr>
			<td class="tabTableTitleMenu"><? echo $lang['gmod_available']; ?></td>
		</tr>
		<tr>
			<td class="tabTableMenu">
				<table border="0" cellpadding="3" cellspacing="3" ><?
					if (isset($graphModels))	{
						foreach ($graphModels as $graphModel)	{ ?>
							<tr><td align="left">
							<div style="padding: 2px; white-space: nowrap" align="left">
								<li>
									<a href="phpradmin.php?p=319&gmod=<? echo $graphModel->get_id(); ?>&o=w&type=1" class="text10">
										<? echo $graphModel->get_name(); ?>
									</a>
								</li>
							</td></tr>
					<?  } unset($graphModel); } ?>
				</table>
			</td>
		</tr>
		</table>
<?
	}

	function write_gmodDS_list($graphModelDS, $lang)	{
		?>
		<table cellpadding="0" cellspacing="0" width="160">
			<tr>
				<td class="tabTableTitleMenu"><? echo $lang['m_options']; ?></td>
			</tr>
			<tr>
				<td class="tabTableMenu">
					<div style="padding: 8px; text-align: center;">
						<img src="img/picto2.gif">
						<a href="phpradmin.php?p=319&o=a&type=2" class="text9"><? echo $lang['add']; ?></a>
						<img src="img/picto2_bis.gif">
					</div>
				</td>
			</tr>
		</table>
		<br>
		<table border="0" cellpadding="0" cellspacing="0" width="160">
			<tr>
				<td colspan="3" class="tabTableTitleMenu"><? echo $lang['gmod_ds_available']; ?></td>
			</tr>
			<tr>
				<td colspan="3" class="tabTableMenu">
					<table border="0" cellpadding="3" cellspacing="3" >
					<?
					if (isset($graphModelDS))	{
						foreach ($graphModelDS as $graphModelDS_)	{ ?>
							<tr><td align="left">
								<li>
									<a href="phpradmin.php?p=319&gmod_ds=<? echo $graphModelDS_->get_id(); ?>&o=w&type=2" class="text10">
										<? echo $graphModelDS_->get_alias(); ?>
									</a>
								</li>
							</td></tr>
					<?  } unset($graphModelDS_); } ?>
					</table></td></tr>
					</table>
<?	}

	function write_colors_list($colors, $lang)	{ ?>

		<table border="0" cellpadding="0" cellspacing="0" >
			<tr><td colspan="3" class="tabTableTitleMenu"> <? echo $lang['colors'] ?></td></tr>
			<tr><td colspan="3" class="tabTableMenu">
				<table border="0" cellpadding="3" cellspacing="3" > <?
		$i = 0;
		$line = 0;
		if (isset($colors))	{
			foreach ($colors as $color)	{
				if (!fmod($i , 8)) {
					if ($line % 2 )
					echo "<tr>\n";
					$line++;
				} ?>
						<td style='color: #<? echo ($color->is_dark_color()?"FFFFFF":"000000"); ?>; background: #<? echo $color->get_color(); ?>;' class="text10b" align="center" ><? echo $color->get_color(); ?></td>
						<td class="text10b" ><a href="phpradmin.php?p=319&o=d&color=<? echo $color->get_color_id(); ?>&type=3" class="text11"><img src="./img/listDel.gif" border="0"  alt="<? echo $lang['delete']; ?>" title="<? echo $lang['delete'] ?>"></a></td>
						<td class="text10b" >&nbsp;</td>
			<?	$i++;
				 if (!fmod($i , 8)){
					if ($line % 2 )
					echo "</tr>\n";
					$line++;
				}
				unset($color);
			} ?>
		</table></td></tr>
		</table>
	<?	}
	}


if (!isset($_GET["o"]))	{ ?>
	<table align="left">
		<tr>
			<? if (isset($_GET["type"]) && $_GET["type"] == "3") { ?>
			<td style="padding-left: 20px;" valign="top">
				<? write_colors_list($colors, $lang); ?>
			</td>
			<? } else { ?>
			<td valign="top">
				<? write_gmod_list($graphModels, $lang); ?>
			</td valign="top">
			<td style="padding-left: 20px;">
				<? write_gmodDS_list($graphModelDS, $lang); ?>
			</td>
			<? } ?>
		</tr>
	</table>
<?
}	else	{
	if (!strcmp($_GET["o"], "c") || !strcmp($_GET["o"], "w"))
		if (isset($_GET["gmod"]))
			$gmod = $_GET["gmod"];
		if (isset($_GET["gmod_ds"]))
			$gmod_ds = $_GET["gmod_ds"];
	?>
	<table align="left" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<? if ($_GET["type"] == "1") { ?>
			<td valign="top" align="center">
				<? write_gmod_list($graphModels, $lang); ?>
			</td>
			<? } else if ($_GET["type"] == "2") {	?>
			<td valign="top" align="center">
				<? write_gmodDS_list($graphModelDS, $lang); ?>
			</td>
			<? } else if ($_GET["type"] == "3") {	?>
			<td valign="top" align="center">
				<? write_colors_list($colors, $lang); ?>
			</td>
			<? } ?>
			<td style="padding-left: 20px;"></td>
			<td valign="top" align='left'>
				<?	if (isset($msg))
						echo "<div style='padding-bottom: 10px;' class='msg' align='center'>$msg</div>";?>
				<table border='0' align="center" cellpadding="0" cellspacing="0">
					<tr >
						<td class="tabTableTitleMenu">
							<?
							echo $lang['gmod'];
							if ((!strcmp($_GET["o"], "c") || !strcmp($_GET["o"], "w"))&& $_GET["type"] == 1)
								echo " \"" . $graphModels[$gmod]->get_name() . "\"";
							else if ((!strcmp($_GET["o"], "c") || !strcmp($_GET["o"], "w")) && $_GET["type"] == 2)
								echo " \"" . $graphModelDS[$gmod_ds]->get_alias() . "\"";
							?>
						</td>
					</tr>
					<tr >
						<td class="tabTableMenu">
						    <? if ($_GET["type"] == 3) { ?>
							<form action="" method="post">
							<table border="0" cellpadding="3" cellspacing="3">
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['hexa']; ?><font color='red'>*</font></td>
									<td class="text10b" colspan="2"><input size="6" maxlength="6" type="text" name="color[hex]" value="" onChange="this.style.backgroundColor=this.value;"></td>
								</tr>
								<tr>
									<td align="center" height="35" valign="bottom" colspan="3">
										<input type="submit" name="AddColor" value="<? echo $lang['save']; ?>">
									</td>
								</tr>
							</table>
							</form>
							<? } ?>
							<? if (!strcmp($_GET["o"], "c")) {
								if ($_GET["type"] == 1)	{ ?>
							<form action="" method="post">
							<table border="0" cellpadding="3" cellspacing="3">
								<tr>
									<td style="white-space: nowrap;">Name <font color='red'>*</font></td>
									<td class="text10b" colspan="2"><input type="text" name="gmod[gmod_name]" value="<? echo $graphModels[$gmod]->get_name(); ?>"></td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_imgformat']; ?></td>
									<td class="text10b" colspan="2">
									<select name="gmod[gmod_imgformat]">
										<? if (strcmp($oreon->optGen->rrdtool_version, "1.2")) { ?>
											<option value="GIF" <? if (!strcmp($graphModels[$gmod]->get_imgformat(), "GIF")) echo "selected"; ?>>GIF</option>
										<? } ?>
											<option value="PNG" <? if (!strcmp($graphModels[$gmod]->get_imgformat(), "PNG")) echo "selected"; ?>>PNG</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_verticallabel']; ?></td>
									<td class="text10b" colspan="2"><input type="text" name="gmod[gmod_verticallabel]" value="<? echo $graphModels[$gmod]->get_verticallabel(); ?>"></td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_width']; ?></td>
									<td class="text10b" colspan="2"><input size="6" type="text" name="gmod[gmod_width]" value="<? echo $graphModels[$gmod]->get_width(); ?>"></td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_height']; ?></td>
									<td class="text10b" colspan="2"><input size="6" type="text" name="gmod[gmod_height]" value="<? echo $graphModels[$gmod]->get_height(); ?>"></td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_lowerlimit']; ?></td>
									<td class="text10b" colspan="2"><input size="6" type="text" name="gmod[gmod_lowerlimit]" value="<? echo $graphModels[$gmod]->get_lowerlimit(); ?>"></td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_ColGrilFond']; ?></td>
									<td >
									<?
									    echo "<select style='background: #". $graphModels[$gmod]->get_ColGrilFond()  .";' size=\"1\" name=\"gmod[gmod_ColGrilFond]\">";
										foreach ($colors as $color)	{
											echo "<option style='color: #" . ($color->is_dark_color()?"FFFFFF":"000000") . "; background: #". $color->get_color() .";' value='".$color->get_color()."'";
											if (strtoupper($graphModels[$gmod]->get_ColGrilFond()) == $color->get_color())
												echo " selected";
											echo ">".$color->get_color()."</option>";
											unset($color);
									} ?>
										</select>
									</td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_ColFond']; ?></td>
									<td >
									<?
									    echo "<select style='background: #". $graphModels[$gmod]->get_ColFond()  .";' size=\"1\" name=\"gmod[gmod_ColFond]\" onChange=\"this.style.backgroundColor=this.value;\">";
										foreach ($colors as $color)	{
											echo "<option   style='color: #" . ($color->is_dark_color()?"FFFFFF":"000000") . "; background: #". $color->get_color() .";' value='".$color->get_color()."'";
											if (strtoupper($graphModels[$gmod]->get_ColFond()) == $color->get_color())
												echo " selected";
											echo ">".$color->get_color()."</option>";
											unset($color);
									} ?>
										</select>
									</td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_ColPolice']; ?></td>
									<td >
									<?
									    echo "<select style='background: #". $graphModels[$gmod]->get_ColPolice() .";' size=\"1\" name=\"gmod[gmod_ColPolice]\" onChange=\"this.style.backgroundColor=this.value;\">";
										foreach ($colors as $color)	{
											echo "<option   style='color: #" . ($color->is_dark_color()?"FFFFFF":"000000") . "; background: #". $color->get_color() .";' value='".$color->get_color()."'";
											if (strtoupper($graphModels[$gmod]->get_ColPolice()) == $color->get_color())
												echo " selected";
											echo ">".$color->get_color()."</option>";
											unset($color);
									} ?>
										</select>
									</td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_ColGrGril']; ?></td>
									<td >
									<?
									    echo "<select style='background: #". $graphModels[$gmod]->get_ColGrGril()  .";'  size=\"1\" name=\"gmod[gmod_ColGrGril]\" onChange=\"this.style.backgroundColor=this.value;\">";
										foreach ($colors as $color)	{
											echo "<option   style='color: #" . ($color->is_dark_color()?"FFFFFF":"000000") . "; background: #". $color->get_color() .";' value='".$color->get_color()."'";
											if (strtoupper($graphModels[$gmod]->get_ColGrGril()) == $color->get_color())
												echo " selected";
											echo ">".$color->get_color()."</option>";
											unset($color);
									} ?>
										</select>
									</td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_ColPtGril']; ?></td>
									<td >
									<?
									    echo "<select  style='background: #". $graphModels[$gmod]->get_ColPtGril()  .";'  size=\"1\" name=\"gmod[gmod_ColPtGril]\" onChange=\"this.style.backgroundColor=this.value;\">";
										foreach ($colors as $color)	{
											echo "<option   style='color: #" . ($color->is_dark_color()?"FFFFFF":"000000") . "; background: #". $color->get_color() .";' value='".$color->get_color()."'";
											if (strtoupper($graphModels[$gmod]->get_ColPtGril()) == $color->get_color())
												echo " selected";
											echo ">".$color->get_color()."</option>";
											unset($color);
									} ?>
										</select>
									</td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_ColContCub']; ?></td>
									<td >
									<?
									    echo "<select style='background: #". $graphModels[$gmod]->get_ColContCub()  .";'  size=\"1\" name=\"gmod[gmod_ColContCub]\" onChange=\"this.style.backgroundColor=this.value;\">";
										foreach ($colors as $color)	{
											echo "<option   style='color: #" . ($color->is_dark_color()?"FFFFFF":"000000") . "; background: #". $color->get_color() .";' value='".$color->get_color()."'";
											if (strtoupper($graphModels[$gmod]->get_ColContCub()) == $color->get_color())
												echo " selected";
											echo ">".$color->get_color()."</option>";
											unset($color);
									} ?>
										</select>
									</td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_ColArrow']; ?></td>
									<td >
									<?
									    echo "<select style='background: #". $graphModels[$gmod]->get_ColArrow()  .";'  size=\"1\" name=\"gmod[gmod_ColArrow]\" onChange=\"this.style.backgroundColor=this.value;\">";
										foreach ($colors as $color)	{
											echo "<option   style='color: #" . ($color->is_dark_color()?"FFFFFF":"000000") . "; background: #". $color->get_color() .";' value='".$color->get_color()."'";
											if (strtoupper($graphModels[$gmod]->get_ColArrow()) == $color->get_color())
												echo " selected";
											echo ">".$color->get_color()."</option>";
											unset($color);
									} ?>
										</select>
									</td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_ColImHau']; ?></td>
									<td >
									<?
									    echo "<select style='background: #". $graphModels[$gmod]->get_ColImHau()  .";'  size=\"1\" name=\"gmod[gmod_ColImHau]\" onChange=\"this.style.backgroundColor=this.value;\">";
										foreach ($colors as $color)	{
											echo "<option   style='color: #" . ($color->is_dark_color()?"FFFFFF":"000000") . "; background: #". $color->get_color() .";' value='".$color->get_color()."'";
											if (strtoupper($graphModels[$gmod]->get_ColImHau()) == $color->get_color())
												echo " selected";
											echo ">".$color->get_color()."</option>";
											unset($color);
									} ?>
										</select>
									</td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_ColImBa']; ?></td>
									<td >
									<?
									    echo "<select style='background: #". $graphModels[$gmod]->get_ColImBa()  .";'  size=\"1\" name=\"gmod[gmod_ColImBa]\" onChange=\"this.style.backgroundColor=this.value;\">";
										foreach ($colors as $color)	{
											echo "<option   style='color: #" . ($color->is_dark_color()?"FFFFFF":"000000") . "; background: #". $color->get_color() .";' value='".$color->get_color()."'";
											if (strtoupper($graphModels[$gmod]->get_ColImBa()) == $color->get_color())
												echo " selected";
											echo ">".$color->get_color()."</option>";
											unset($color);
									} ?>
										</select>
									</td>
								</tr>
								<tr>
									<td colspan="3" height="35" valign="bottom" align="center">
									<input type="hidden" name="gmod[gmod_id]" value="<? echo $gmod ?>">
									<input type="submit" name="ChangeGmod" value="<? echo $lang['save']; ?>">
									</td>
								</tr>
							</table>
							</form>
							<? } else if ($_GET["type"] == 2)	{ ?>
							<form action="" method="post">
							<table border="0" cellpadding="3" cellspacing="3">
								<tr>
									<td style="white-space: nowrap;">Alias <font color='red'>*</font></td>
									<td class="text10b" colspan="2"><input type="text" name="gmodDS[gmod_ds_alias]" value="<? echo $graphModelDS[$gmod_ds]->get_alias(); ?>"></td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_dsname']; ?></td>
									<td class="text10b" colspan="2"><input type="text" name="gmodDS[gmod_ds_name]" value="<? echo $graphModelDS[$gmod_ds]->get_name(); ?>"></td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_Couleurs']; ?></td>
									<td >
									<?
									    echo "<select style='background: #". $graphModelDS[$gmod_ds]->get_Col()  .";' size=\"1\" name=\"gmodDS[gmod_ds_col]\" onChange=\"this.style.backgroundColor=this.value;\">";
										foreach ($colors as $color)	{
											echo "<option style='color: #" . ($color->is_dark_color()?"FFFFFF":"000000") . "; background: #". $color->get_color() .";' value='".$color->get_color()."'";
											if (strtoupper($graphModelDS[$gmod_ds]->get_Col()) == $color->get_color())
												echo " selected";
											echo ">".$color->get_color()."</option>";
											unset($color);
									} ?>
										</select>
									</td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_flamming']; ?></td>
									<td class="text10b" colspan="2">
										<select name="gmodDS[gmod_ds_flamming]">
											<option value="yes" <? if (!strcmp($graphModelDS[$gmod_ds]->get_flamming(), "yes")) echo "selected"; ?>>yes</option>
											<option value="no" <? if (!strcmp($graphModelDS[$gmod_ds]->get_flamming(), "no")) echo "selected"; ?>>no</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_Area']; ?></td>
									<td class="text10b" colspan="2">
										<select name="gmodDS[gmod_ds_area]">
											<option value="yes" <? if (!strcmp($graphModelDS[$gmod_ds]->get_area(), "yes")) echo "selected"; ?>>yes</option>
											<option value="no" <? if (!strcmp($graphModelDS[$gmod_ds]->get_area(), "no")) echo "selected"; ?>>no</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_tickness']; ?></td>
									<td class="text10b" colspan="2">
										<select name="gmodDS[gmod_ds_tickness]">
											<option value="1" <? if ($graphModelDS[$gmod_ds]->get_flamming() == 1) echo "selected"; ?>>1</option>
											<option value="2" <? if ($graphModelDS[$gmod_ds]->get_flamming() == 2) echo "selected"; ?>>2</option>
											<option value="3" <? if ($graphModelDS[$gmod_ds]->get_flamming() == 3) echo "selected"; ?>>3</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_gprintlastds']; ?></td>
									<td class="text10b" colspan="2">
										<select name="gmodDS[gmod_ds_gprintlast]">
											<option value="yes" <? if (!strcmp($graphModelDS[$gmod_ds]->get_gprintlast(), "yes")) echo "selected"; ?>>yes</option>
											<option value="no" <? if (!strcmp($graphModelDS[$gmod_ds]->get_gprintlast(), "no")) echo "selected"; ?>>no</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_gprintminds']; ?></td>
									<td class="text10b" colspan="2">
										<select name="gmodDS[gmod_ds_gprintmin]">
											<option value="yes" <? if (!strcmp($graphModelDS[$gmod_ds]->get_gprintmin(), "yes")) echo "selected"; ?>>yes</option>
											<option value="no" <? if (!strcmp($graphModelDS[$gmod_ds]->get_gprintmin(), "no")) echo "selected"; ?>>no</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_gprintaverageds']; ?></td>
									<td class="text10b" colspan="2">
										<select name="gmodDS[gmod_ds_gprintaverage]">
											<option value="yes" <? if (!strcmp($graphModelDS[$gmod_ds]->get_gprintaverage(), "yes")) echo "selected"; ?>>yes</option>
											<option value="no" <? if (!strcmp($graphModelDS[$gmod_ds]->get_gprintaverage(), "no")) echo "selected"; ?>>no</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_gprintmaxds']; ?></td>
									<td class="text10b" colspan="2">
										<select name="gmodDS[gmod_ds_gprintmax]">
											<option value="yes" <? if (!strcmp($graphModelDS[$gmod_ds]->get_gprintmax(), "yes")) echo "selected"; ?>>yes</option>
											<option value="no" <? if (!strcmp($graphModelDS[$gmod_ds]->get_gprintmax(), "no")) echo "selected"; ?>>no</option>
										</select>
									</td>
								</tr>
								<tr>
									<td align="center" height="35" valign="bottom" colspan="3">
										<input type="hidden" name="gmodDS[gmod_ds_id]" value="<? echo $gmod_ds; ?>">
										<input type="submit" name="ChangeGmodDS" value="<? echo $lang['save']; ?>">
									</td>
								</tr>
							</table>
							</form>
							<? } } else if (!strcmp($_GET["o"], "w")) {
								if ($_GET["type"] == 1)	{
							?>
							<table border="0" cellpadding="3" cellspacing="3">
								<tr>
									<td style="white-space: nowrap;">Name <font color='red'>*</font></td>
									<td class="text10b" colspan="2" style="padding-right: 10px;"><? echo $graphModels[$gmod]->get_name();?></td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_imgformat']; ?></td>
									<td class="text10b" colspan="2" style="padding-right: 10px;"><? echo $graphModels[$gmod]->get_imgformat();?></td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_verticallabel']; ?></td>
									<td class="text10b" colspan="2" style="padding-right: 10px;"><? echo $graphModels[$gmod]->get_verticallabel();?></td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_width']; ?></td>
									<td class="text10b" colspan="2" style="padding-right: 10px;"><? echo $graphModels[$gmod]->get_width();?></td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_height']; ?></td>
									<td class="text10b" colspan="2" style="padding-right: 10px;"><? echo $graphModels[$gmod]->get_height();?></td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_lowerlimit']; ?></td>
									<td class="text10b" colspan="2" style="padding-right: 10px;"><? echo $graphModels[$gmod]->get_lowerlimit();?></td>
								</tr>
								<tr>
									<td style="white-space: nowrap; padding-right: 10px;"><? echo $lang['g_ColGrilFond']; ?></td>
									<td  width="10" bgcolor="<? if ($graphModels[$gmod]->get_ColGrilFond())	echo "#".$graphModels[$gmod]->get_ColGrilFond();?>"></td>
									<td class="text10b"><? echo $graphModels[$gmod]->get_ColGrilFond();?></td>
								</tr>
								<tr>
									<td style="white-space: nowrap; padding-right: 10px;"><? echo $lang['g_ColFond']; ?></td>
									<td  width="10" bgcolor="<? if ($graphModels[$gmod]->get_ColFond()) echo "#".$graphModels[$gmod]->get_ColFond();?>"></td>
									<td class="text10b"><? echo $graphModels[$gmod]->get_ColFond();?></td>
								</tr>
								<tr>
									<td style="white-space: nowrap; padding-right: 10px;"><? echo $lang['g_ColPolice']; ?></td>
									<td  width="10" bgcolor="<? if ($graphModels[$gmod]->get_ColPolice()) echo "#".$graphModels[$gmod]->get_ColPolice();?>"></td>
									<td class="text10b"><? echo $graphModels[$gmod]->get_ColPolice();?></td>
								</tr>
								<tr>
									<td style="white-space: nowrap; padding-right: 10px;"><? echo $lang['g_ColGrGril']; ?></td>
									<td  width="10" bgcolor="<? if ($graphModels[$gmod]->get_ColGrGril())	echo "#".$graphModels[$gmod]->get_ColGrGril();?>"></td>
									<td class="text10b"><? echo $graphModels[$gmod]->get_ColGrGril();?></td>
								</tr>
								<tr>
									<td style="white-space: nowrap; padding-right: 10px;"><? echo $lang['g_ColPtGril']; ?></td>
									<td  width="10" bgcolor="<? if ($graphModels[$gmod]->get_ColPtGril()) echo "#".$graphModels[$gmod]->get_ColPtGril();?>"></td>
									<td class="text10b"><? echo $graphModels[$gmod]->get_ColPtGril();?></td>
								</tr>
								<tr>
									<td style="white-space: nowrap; padding-right: 10px;"><? echo $lang['g_ColContCub']; ?></td>
									<td  width="10" bgcolor="<? if ($graphModels[$gmod]->get_ColContCub()) echo "#".$graphModels[$gmod]->get_ColContCub();?>"></td>
									<td class="text10b"><? echo $graphModels[$gmod]->get_ColContCub();?></td>
								</tr>
								<tr>
									<td style="white-space: nowrap; padding-right: 10px;"><? echo $lang['g_ColArrow']; ?></td>
									<td  width="10" bgcolor="<? if ($graphModels[$gmod]->get_ColArrow()) echo "#".$graphModels[$gmod]->get_ColArrow();?>"></td>
									<td class="text10b"><? echo $graphModels[$gmod]->get_ColArrow();?></td>
								</tr>
								<tr>
									<td style="white-space: nowrap; padding-right: 10px;"><? echo $lang['g_ColImHau']; ?></td>
									<td  width="10" bgcolor="<? if ($graphModels[$gmod]->get_ColImHau()) echo "#".$graphModels[$gmod]->get_ColImHau();?>"></td>
									<td class="text10b"><? echo $graphModels[$gmod]->get_ColImHau();?></td>
								</tr>
								<tr>
									<td style="white-space: nowrap; padding-right: 10px;"><? echo $lang['g_ColImBa']; ?></td>
									<td  width="10" bgcolor="<? if ($graphModels[$gmod]->get_ColImBa()) echo "#".$graphModels[$gmod]->get_ColImBa();?>"></td>
									<td class="text10b"><? echo $graphModels[$gmod]->get_ColImBa();?></td>
								</tr>
								<tr>
									<td colspan="3" align="center" style="padding-top: 15px;">
										<a href="phpradmin.php?p=319&o=c&gmod=<? echo $gmod ?>&type=<? echo $_GET["type"]; ?>" class="text10bc"><? echo $lang['modify']; ?></a>&nbsp;&nbsp;&nbsp;&nbsp;
										<a href="phpradmin.php?p=319&o=d&gmod=<? echo $gmod ?>&type=<? echo $_GET["type"]; ?>" class="text10bc" onclick="return confirm('<? echo $lang['confirm_removing']; ?>')"><? echo $lang['delete']; ?></a>
									</td>
								</tr>
							</table>
							<? } else if ($_GET["type"] == 2)	{ ?>
							<table border="0" cellpadding="3" cellspacing="3">
								<tr>
									<td style="white-space: nowrap;">Alias</td>
									<td class="text10b" colspan="2"><? echo $graphModelDS[$gmod_ds]->get_alias();?></td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_dsname']; ?></td>
									<td class="text10b" colspan="2"><? echo $graphModelDS[$gmod_ds]->get_name();?></td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_Couleurs']; ?></td>
									<td  width="10" bgcolor="<? if ($graphModelDS[$gmod_ds]->get_col())	echo "#".$graphModelDS[$gmod_ds]->get_col();?>"></td>
									<td class="text10b"><? echo $graphModelDS[$gmod_ds]->get_col();?></td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_flamming']; ?></td>
									<td class="text10b" colspan="2"><? echo $graphModelDS[$gmod_ds]->get_flamming();?></td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_Area']; ?></td>
									<td class="text10b" colspan="2"><? echo $graphModelDS[$gmod_ds]->get_area();?></td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_tickness']; ?></td>
									<td class="text10b"><? echo $graphModelDS[$gmod_ds]->get_tickness();?></td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_gprintlastds']; ?></td>
									<td class="text10b"><? echo $graphModelDS[$gmod_ds]->get_gprintlast();?></td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_gprintminds']; ?></td>
									<td class="text10b"><? echo $graphModelDS[$gmod_ds]->get_gprintmin();?></td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_gprintaverageds']; ?></td>
									<td class="text10b"><? echo $graphModelDS[$gmod_ds]->get_gprintaverage();?></td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_gprintmaxds']; ?></td>
									<td class="text10b"><? echo $graphModelDS[$gmod_ds]->get_gprintmax();?></td>
								</tr>
								<tr>
									<td colspan="3" align="center" style="padding-top: 15px;">
										<a href="phpradmin.php?p=319&o=c&gmod_ds=<? echo $gmod_ds ?>&type=<? echo $_GET["type"]; ?>" class="text10bc"><? echo $lang['modify']; ?></a>&nbsp;&nbsp;&nbsp;&nbsp;
										<a href="phpradmin.php?p=319&o=d&gmod_ds=<? echo $gmod_ds ?>&type=<? echo $_GET["type"]; ?>" class="text10bc" onclick="return confirm('<? echo $lang['confirm_removing']; ?>')"><? echo $lang['delete']; ?></a>
									</td>
								</tr>
							</table>
							<? } } else if (!strcmp($_GET["o"], "a")) {
								if ($_GET["type"] == 1)	{
							?>
							<form action="" method="post">
							<table border="0" cellpadding="3" cellspacing="3">
								<tr>
									<td style="white-space: nowrap;">Name <font color='red'>*</font></td>
									<td class="text10b" colspan="2"><input type="text" name="gmod[gmod_name]" value=""></td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_imgformat']; ?></td>
									<td class="text10b" colspan="2">
										<select name="gmod[gmod_imgformat]">
										<? if (strcmp($oreon->optGen->rrdtool_version, "1.2")) {    ?>
											<option value="GIF">GIF</option>
										<? } ?>
											<option value="PNG">PNG</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_verticallabel']; ?></td>
									<td class="text10b" colspan="2"><input type="text" name="gmod[gmod_verticallabel]" value=""></td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_width']; ?></td>
									<td class="text10b" colspan="2"><input size="6" type="text" name="gmod[gmod_width]" value=""></td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_height']; ?></td>
									<td class="text10b" colspan="2"><input size="6" type="text" name="gmod[gmod_height]" value=""></td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_lowerlimit']; ?></td>
									<td class="text10b" colspan="2"><input size="6" type="text" name="gmod[gmod_lowerlimit]" value=""></td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_ColGrilFond']; ?></td>
									<td >
									<?
									    echo "<select size=\"1\" name=\"gmod[gmod_ColGrilFond]\" onChange=\"this.style.backgroundColor=this.value;\">";
										foreach ($colors as $color)	{
											echo "<option   style='color: #" . ($color->is_dark_color()?"FFFFFF":"000000") . "; background: #". $color->get_color() .";' value='".$color->get_color()."'";
											echo ">".$color->get_color()."</option>";
											unset($color);
									} ?>
										</select>
									</td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_ColFond']; ?></td>
									<td >
									<?
									    echo "<select size=\"1\" name=\"gmod[gmod_ColFond]\" onChange=\"this.style.backgroundColor=this.value;\">";
										foreach ($colors as $color)	{
											echo "<option   style='color: #" . ($color->is_dark_color()?"FFFFFF":"000000") . "; background: #". $color->get_color() .";' value='".$color->get_color()."'";
											echo ">".$color->get_color()."</option>";
											unset($color);
									} ?>
										</select>
									</td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_ColPolice']; ?></td>
									<td >
									<?
									    echo "<select size=\"1\" name=\"gmod[gmod_ColPolice]\" onChange=\"this.style.backgroundColor=this.value;\">";
										foreach ($colors as $color)	{
											echo "<option   style='color: #" . ($color->is_dark_color()?"FFFFFF":"000000") . "; background: #". $color->get_color() .";' value='".$color->get_color()."'";
											echo ">".$color->get_color()."</option>";
											unset($color);
									} ?>
										</select>
									</td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_ColGrGril']; ?></td>
									<td >
									<?
									    echo "<select size=\"1\" name=\"gmod[gmod_ColGrGril]\" onChange=\"this.style.backgroundColor=this.value;\">";
										foreach ($colors as $color)	{
											echo "<option   style='color: #" . ($color->is_dark_color()?"FFFFFF":"000000") . "; background: #". $color->get_color() .";' value='".$color->get_color()."'";
											echo ">".$color->get_color()."</option>";
											unset($color);
									} ?>
										</select>
									</td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_ColPtGril']; ?></td>
									<td >
									<?
									    echo "<select size=\"1\" name=\"gmod[gmod_ColPtGril]\" onChange=\"this.style.backgroundColor=this.value;\">";
										foreach ($colors as $color)	{
											echo "<option   style='color: #" . ($color->is_dark_color()?"FFFFFF":"000000") . "; background: #". $color->get_color() .";' value='".$color->get_color()."'";
											echo ">".$color->get_color()."</option>";
											unset($color);
									} ?>
										</select>
									</td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_ColContCub']; ?></td>
									<td >
									<?
									    echo "<select size=\"1\" name=\"gmod[gmod_ColContCub]\" onChange=\"this.style.backgroundColor=this.value;\">";
										foreach ($colors as $color)	{
											echo "<option   style='color: #" . ($color->is_dark_color()?"FFFFFF":"000000") . "; background: #". $color->get_color() .";' value='".$color->get_color()."'";
											echo ">".$color->get_color()."</option>";
											unset($color);
									} ?>
										</select>
									</td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_ColArrow']; ?></td>
									<td >
									<?
									    echo "<select size=\"1\" name=\"gmod[gmod_ColArrow]\" onChange=\"this.style.backgroundColor=this.value;\">";
										foreach ($colors as $color)	{
											echo "<option   style='color: #" . ($color->is_dark_color()?"FFFFFF":"000000") . "; background: #". $color->get_color() .";' value='".$color->get_color()."'";
											echo ">".$color->get_color()."</option>";
											unset($color);
									} ?>
										</select>
									</td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_ColImHau']; ?></td>
									<td >
									<?
									    echo "<select size=\"1\" name=\"gmod[gmod_ColImHau]\" onChange=\"this.style.backgroundColor=this.value;\">";
										foreach ($colors as $color)	{
											echo "<option   style='color: #" . ($color->is_dark_color()?"FFFFFF":"000000") . "; background: #". $color->get_color() .";' value='".$color->get_color()."'";
											echo ">".$color->get_color()."</option>";
											unset($color);
									} ?>
										</select>
									</td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_ColImBa']; ?></td>
									<td >
									<?
									    echo "<select size=\"1\" name=\"gmod[gmod_ColImBa]\" onChange=\"this.style.backgroundColor=this.value;\">";
										foreach ($colors as $color)	{
											echo "<option   style='color: #" . ($color->is_dark_color()?"FFFFFF":"000000") . "; background: #". $color->get_color() .";' value='".$color->get_color()."'";
											echo ">".$color->get_color()."</option>";
											unset($color);
									} ?>
										</select>
									</td>
								</tr>
								<tr>
									<td align="center" height="35" valign="bottom" colspan="3">
									<input type="submit" name="AddGmod" value="<? echo $lang['save']; ?>">
									</td>
								</tr>
						</table>
						</form>
						<? } else if ($_GET["type"] == 2)	{	?>
							<form action="" method="post">
							<table border="0" cellpadding="3" cellspacing="3">
								<tr>
									<td style="white-space: nowrap;">Alias <font color='red'>*</font></td>
									<td class="text10b" colspan="2"><input type="text" name="gmodDS[gmod_ds_alias]" value=""></td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_dsname']; ?></td>
									<td class="text10b" colspan="2"><input type="text" name="gmodDS[gmod_ds_name]" value=""></td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_Couleurs']; ?></td>
									<td >
									<?
									    echo "<select size=\"1\" name=\"gmodDS[gmod_ds_col]\" onChange=\"this.style.backgroundColor=this.value;\">";
										foreach ($colors as $color)	{
											echo "<option style='color: #" . ($color->is_dark_color()?"FFFFFF":"000000");
											echo "; background: #". $color->get_color() .";' value='".$color->get_color()."'";
											echo ">".$color->get_color()."</option>";
											unset($color);
									} ?>
										</select>
									</td>

								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_flamming']; ?></td>
									<td class="text10b" colspan="2">
										<select name="gmodDS[gmod_ds_flamming]">
											<option value="yes">yes</option>
											<option value="no">no</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_Area']; ?></td>
									<td class="text10b" colspan="2">
										<select name="gmodDS[gmod_ds_area]">
											<option value="yes">yes</option>
											<option value="no">no</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_tickness']; ?></td>
									<td class="text10b" colspan="2">
										<select name="gmodDS[gmod_ds_tickness]">
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_gprintlastds']; ?></td>
									<td class="text10b" colspan="2">
										<select name="gmodDS[gmod_ds_gprintlast]">
											<option value="yes">yes</option>
											<option value="no">no</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_gprintminds']; ?></td>
									<td class="text10b" colspan="2">
										<select name="gmodDS[gmod_ds_gprintmin]">
											<option value="yes">yes</option>
											<option value="no">no</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_gprintaverageds']; ?></td>
									<td class="text10b" colspan="2">
										<select name="gmodDS[gmod_ds_gprintaverage]">
											<option value="yes">yes</option>
											<option value="no">no</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['g_gprintmaxds']; ?></td>
									<td class="text10b" colspan="2">
										<select name="gmodDS[gmod_ds_gprintmax]">
											<option value="yes">yes</option>
											<option value="no">no</option>
										</select>
									</td>
								</tr>
								<tr>
									<td align="center" height="35" valign="bottom" colspan="3">
									<input type="submit" name="AddGmodDS" value="<? echo $lang['save']; ?>">
									</td>
								</tr>
						</table>
						</form>
						<? } } ?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	</table>
<?  } ?>