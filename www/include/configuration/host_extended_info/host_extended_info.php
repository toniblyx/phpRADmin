<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/if (!isset($oreon))
		exit();

	if (!isset($_GET["limit"]))
		$limit = 20;
	else
		$limit = $_GET["limit"];
	define("VIEW_MAX", $limit);

	$ehis = & $oreon->ehis;
	if (isset($_GET) && array_key_exists("o", $_GET) && $_GET["o"] != "a" && $_GET["o"] != "l")
		if (!isset($_GET["ehi_id"]) || (isset($_GET["ehi_id"]) && !array_key_exists($_GET["ehi_id"], $ehis)))	{
			echo "<td width='85%'></td>";
			include ("./footer.php");
			exit();
		}
	$hosts = & $oreon->hosts;
	$services = & $oreon->services;

	if (isset($_POST["AddEHI"]))	{
		$ehi_array = & $_POST["ehi"];
		$ehi_array["ehi_id"] = -1;
		$ehi_object = new ExtendedHostInformation($ehi_array);
		if ($ehi_object->is_complete($oreon->user->get_version()) && $ehi_object->twiceTest($ehis))	{
			// log oreon
			system("echo \"[" . time() . "] AddHostExtendedInfo;" . addslashes($oreon->hosts[$ehi_object->get_host()]->get_name()) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
			$oreon->saveExtendedHostInformation($ehi_object);
			$ehi_id = $oreon->database->database->get_last_id();
			$ehis[$ehi_id] = $ehi_object;
			$ehis[$ehi_id]->set_id($ehi_id);
			$ehis[$ehi_id]->set_notes($ehi_array["ehi_notes"]);
			$ehis[$ehi_id]->set_notes_url($ehi_array["ehi_notes_url"]);
			if (isset($ehi_array["ehi_action_url"]))
				$ehis[$ehi_id]->set_action_url($ehi_array["ehi_action_url"]);
			$ehis[$ehi_id]->set_icon_image($ehi_array["ehi_icon_image"]);
			$ehis[$ehi_id]->set_icon_image_alt($ehi_array["ehi_icon_image_alt"]);
			$ehis[$ehi_id]->set_vrml_image($ehi_array["ehi_vrml_image"]);
			$ehis[$ehi_id]->set_statusmap_image($ehi_array["ehi_statusmap_image"]);
			$ehis[$ehi_id]->set_d2_coords($ehi_array["ehi_d2_coords"]);
			$ehis[$ehi_id]->set_d3_coords($ehi_array["ehi_d3_coords"]);
			$oreon->saveExtendedHostInformation($ehis[$ehi_id]);
			$msg = $lang['errCode'][3];
			$_GET["o"] = "w";
			$_GET["ehi_id"] = $ehi_id;
		}
		else
			$msg = $lang['errCode'][$ehi_object->get_errCode()];
		unset ($ehi_object);
	}

	if (isset($_POST["ChangeEHI"]))	{
		$ehi_array = & $_POST["ehi"];
		$ehi_object = new ExtendedHostInformation($ehi_array);
		if ($ehi_object->is_complete($oreon->user->get_version()) && $ehi_object->twiceTest($ehis))	{
			// log oreon
			system("echo \"[" . time() . "] ChangeHostExtendedInfo;" . addslashes($hosts[$ehis[$ehi_array["ehi_id"]]->get_host()]->get_name()) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
			$oreon->saveExtendedHostInformation($ehi_object);
			$ehis[$ehi_array["ehi_id"]]->set_notes($ehi_array["ehi_notes"]);
			$ehis[$ehi_array["ehi_id"]]->set_notes_url($ehi_array["ehi_notes_url"]);
			if (isset($ehi_array["ehi_action_url"]))
				$ehis[$ehi_array["ehi_id"]]->set_action_url($ehi_array["ehi_action_url"]);
			$ehis[$ehi_array["ehi_id"]]->set_icon_image($ehi_array["ehi_icon_image"]);
			$ehis[$ehi_array["ehi_id"]]->set_icon_image_alt($ehi_array["ehi_icon_image_alt"]);
			$ehis[$ehi_array["ehi_id"]]->set_vrml_image($ehi_array["ehi_vrml_image"]);
			$ehis[$ehi_array["ehi_id"]]->set_statusmap_image($ehi_array["ehi_statusmap_image"]);
			$ehis[$ehi_array["ehi_id"]]->set_d2_coords($ehi_array["ehi_d2_coords"]);
			$ehis[$ehi_array["ehi_id"]]->set_d3_coords($ehi_array["ehi_d3_coords"]);
			$oreon->saveExtendedHostInformation($ehis[$ehi_array["ehi_id"]]);
			$msg = $lang['errCode'][2];
			$_GET["o"] = "w";
		}
		else
			$msg = $lang['errCode'][$ehi_object->get_errCode()];
		unset ($ehi_object);
	}

	if (isset($_GET["o"]) && !strcmp($_GET["o"], "d"))	{
		// log oreon
		system("echo \"[" . time() . "] DeleteHostExtendedInfo;" . addslashes($hosts[$ehis[$_GET["ehi_id"]]->get_host()]->get_name()) . ";" .addslashes($oreon->user->get_alias()). "\" >> ./include/log/" . date("Ymd") . ".txt");
		$oreon->deleteExtendedHostInformation($ehis[$_GET["ehi_id"]]);
		unset($_GET["o"]);
		unset($_GET["ehi_id"]);
	}

	if (isset($_GET["o"]) && !strcmp($_GET["o"], "l"))	{
		if (isset($_GET["box"]))	{
			$boxx = & $_GET["box"];
			foreach ($boxx as $box)	{
				// log add
				system("echo \"[" . time() . "] DeleteHostExtendedInfo;" . addslashes($hosts[$ehis[$box]->get_host()]->get_name()) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
				$oreon->deleteExtendedHostInformation($ehis[$box]);
			}
		}
		unset($_GET["o"]);
	}

	function write_ehi_list($hosts, $ehis, $lang)	{?>
		<table cellpadding="0" cellspacing="0" width="160">
			<tr>
				<td class="tabTableTitleMenu"><? print $lang["m_options"]; ?></td>
			</tr>
			<tr>
				<td class="tabTableMenu">
					<div style="padding: 8px; text-align: center;">
						<img src="img/picto2.gif">
						<a href="phpradmin.php?p=113&o=a" class="text9"><? echo $lang['add']; ?></a>
						<img src="img/picto2_bis.gif">
					</div>
				</td>
			</tr>
		</table>
		<br>
		<table cellpadding="0" cellspacing="0" width="160">
			<tr>
				<td class="tabTableTitleMenu"><? print $lang['ehi_available']; ?></td>
			</tr>
			<tr>
				<td class="tabTableMenu">
				 <? 
				 if (isset($ehis))
					foreach ($ehis as $ehi)	{ ?>
						<div style="padding: 2px; white-space: nowrap" align="left">
							<li>
								<a href="phpradmin.php?p=113&ehi_id=<? echo $ehi->get_id(); ?>&o=w" class="text10" <? if (!$hosts[$ehis[$ehi->get_id()]->get_host()]->get_activate()) echo "style='text-decoration: line-through;'"; ?>>
									<? echo $hosts[$ehis[$ehi->get_id()]->get_host()]->get_name(); ?>
								</a>
							</li>
						</div>
				<?  unset($ehi); }?>
				</td>
			</tr>
		</table><?
	}

	function write_ehi_list2(&$hosts,  &$ehis, $lang)	{	?>
		<form action="" name="hostExtendedInfoMenu" method="get">
			<table cellpadding="3" cellspacing="3">
				<tr>
					<td class="listTop"></td>
					<td align="left" class="listTop" style="padding-left: 20px; padding-right: 20px;"><? echo $lang['name']; ?></td>
					<td align="left" class="listTop" style="padding-left: 20px; padding-right: 20px;"><? echo $lang['description']; ?></td>
					<td align="center" class="listTop" style="padding-left: 20px; padding-right: 20px;"><? echo $lang['status']; ?></td>
					<td align="center" class="listTop" style="padding-left: 20px; padding-right: 20px;"><? echo $lang['options']; ?></td>
				</tr>
	<?
		if (!isset($_GET["num"]))
			$num = 1;
		else
			$num = $_GET["num"];
		if (isset($ehis) && count($ehis) != 0)	{
			$cpt = 0;
			foreach ($ehis as $ehi)	{
				if ($cpt < (VIEW_MAX * $num) && ($cpt >= ((VIEW_MAX * $num) - (VIEW_MAX)))){	?>
				<tr>
					<td class="listSub<? echo $cpt%2; ?>"><input type="checkbox" name="box[<? echo $ehi->get_id(); ?>]" value="<? echo $ehi->get_id(); ?>"></td>
					<td align="left" class="listSub<? echo $cpt%2; ?>"><a href="phpradmin.php?p=102&h=<? echo $ehi->get_host(); ?>&o=w" class="text11"><? echo $hosts[$ehi->get_host()]->get_name(); ?></a></td>
					<td align="left" class="listSub<? echo $cpt%2; ?>"><? echo $ehi->get_notes(); ?></td>
					<td align="center" class="listSub<? echo $cpt%2; ?>"><? if ($hosts[$ehi->get_host()]->get_activate()) echo $lang['enable']; else echo $lang['disable']; ?></td>
					<td class="listSub<? echo $cpt%2; ?>">
						&nbsp;&nbsp;
						<a href="phpradmin.php?p=113&ehi_id=<? echo $ehi->get_id(); ?>&o=w" class="text11"><img src="img/listView.gif" border="0" alt="<? echo $lang['view']; ?>" title="<? echo $lang['view']; ?>"></a>&nbsp;
						<a href="phpradmin.php?p=113&ehi_id=<? echo $ehi->get_id(); ?>&o=c" class="text11"><img src="img/listPen.gif" border="0" alt="<? echo $lang['modify']; ?>" title="<? echo $lang['modify']; ?>"></a>&nbsp;
						<a href="phpradmin.php?p=113&ehi_id=<? echo $ehi->get_id(); ?>&o=d&num=<? echo $num; ?>&limit=<? echo VIEW_MAX; ?>" class="text11" onclick="return confirm('<? echo $lang['confirm_removing']; ?>')"><img src="img/listDel.gif" border="0" alt="<? echo $lang['delete']; ?>" title="<? echo $lang['delete']; ?>"></a>&nbsp;&nbsp;
					</td>
				</tr>
			<?	}
				unset($ehi);
				$cpt++;
				}
			} ?>
			<tr>
				<td colspan="2" valign="top"><img src="img/arrow_ltr.gif" style="padding-left: 5px;">&nbsp;&nbsp;	<a href="#" class="text10bc" onclick=" if (confirm('<? echo $lang['confirm_removing']; ?>')){document.forms['hostExtendedInfoMenu'].submit();}"><? echo $lang['m_delete_selection']; ?></a></td>
				<td></td>
				<td colspan="2" align="right" class="text10">
					<a href="phpradmin.php?p=113&o=a" class="text10bc"><? echo $lang['add']; ?></a>&nbsp;&nbsp;<br><br>
					<? echo $lang['nbr_per_page']; ?>&nbsp;
					<select name="limit" class="select" onChange="this.form['option'].disabled = true; this.form.submit();">
						<? for ($i = 10; $i <= 50; $i = $i + 10)	{
								echo "<option";
								if (VIEW_MAX == $i)
									echo " selected";
								echo ">$i</option>";
							}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td align="center" colspan="5">
					<? $nbrPage = floor(count($ehis)/VIEW_MAX); if(count($ehis)%VIEW_MAX) $nbrPage++; ?>
					<? echo "<font class='text11b'>".$lang["page"]. ":&nbsp;&nbsp;</font>[&nbsp;&nbsp;";
						for ($i = 1; $i <= $nbrPage; $i++)	{
							if($num == $i)
								echo "<a href='./phpradmin.php?p=113&num=$i&limit=".VIEW_MAX."' class='text10'><b>$i</b></a>&nbsp;&nbsp;";
							else
								echo "<a href='./phpradmin.php?p=113&num=$i&limit=".VIEW_MAX."' class='text10'>$i</a>&nbsp;&nbsp;";
						}
						echo "]";
					?>
				</td>
			</tr>
		</table>
		<input type="hidden" name="p" value="113">
		<input type="hidden" name="o" value="l" id="option">
	</form>
	<? } ?>

<?
if (!isset($_GET["o"]))	{
?>
	<table border="0" align="left">
		<tr>
			<td valign="top"><? write_ehi_list2($hosts, $ehis, $lang); ?></td>
		</tr>
	</table>
<? } else if (isset($_GET["o"]))	{
		if (isset($_GET["ehi_id"]))
			$ehi_id = $_GET["ehi_id"];?>
	<table border="0" align="left">
		<tr>
			<td align="left" valign="top"><? write_ehi_list($hosts, $ehis, $lang); ?></td>
			<td style="padding-left: 20px;"></td>
			<td valign="top" align="left">
			<? if (isset($msg))
				echo "<div align='center' class='msg' style='padding-bottom: 10px;'>$msg</div>"; ?>
				<table border='0' align="left" cellpadding="0" cellspacing="0" width="400">
					<tr>
						<td align="center" class="tabTableTitle"><? echo "Host Extended Information "; if (!strcmp($_GET["o"], "c") || !strcmp($_GET["o"], "w")) {  echo "\"" . $hosts[$ehis[$ehi_id]->get_host()]->get_name(). "\"";} ?></td>
					</tr>
					<tr>
						<td class="tabTableForTab">
						<? 	if (!strcmp($_GET["o"], "w") || !strcmp($_GET["o"], "c") || !strcmp($_GET["o"], "a"))
								include("./include/configuration/host_extended_info/host_extended_info_".$_GET["o"].".php"); ?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<? } ?>