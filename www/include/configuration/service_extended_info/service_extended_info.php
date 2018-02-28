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

	$esis = & $oreon->esis;
	if (isset($_GET) && array_key_exists("o", $_GET) && $_GET["o"] != "a" && $_GET["o"] != "l")
		if (!isset($_GET["esi_id"]) || (isset($_GET["esi_id"]) && !array_key_exists($_GET["esi_id"], $esis)))	{
			echo "<td width='85%'></td>";
			include ("./footer.php");
			exit();
		}
	$hosts = & $oreon->hosts;
	$services = & $oreon->services;

	if (isset($_POST["AddESI"]))	{
		$esi_array = & $_POST["esi"];
		$esi_array["esi_id"] = -1;
		$esi_object = new ExtendedServiceInformation($esi_array);
		if ($esi_object->is_complete($oreon->user->get_version()) && $esi_object->twiceTest($esis))	{
			$oreon->saveExtendedServiceInformation($esi_object);
			$esi_id = $oreon->database->database->get_last_id();
			$esis[$esi_id] = $esi_object;
			// log oreon
			system("echo \"[" . time() . "] AddServiceExtendedInfos;" . addslashes($services[$esis[$esi_id]->get_service()]->get_description()) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
			$esis[$esi_id]->set_id($esi_id);
			$esis[$esi_id]->set_notes($esi_array["esi_notes"]);
			$esis[$esi_id]->set_notes_url($esi_array["esi_notes_url"]);
			$esis[$esi_id]->set_action_url($esi_array["esi_action_url"]);
			$esis[$esi_id]->set_icon_image($esi_array["esi_icon_image"]);
			$esis[$esi_id]->set_icon_image_alt($esi_array["esi_icon_image_alt"]);
			$oreon->saveExtendedServiceInformation($esis[$esi_id]);
			$msg = $lang['errCode'][3];
			$_GET["o"] = "w";
			$_GET["esi_id"] = $esi_id;
		}
		else
			$msg = $lang['errCode'][$esi_object->get_errCode()];
		unset ($esi_object);
	}

	if (isset($_POST["ChangeESI"]))	{
		$esi_array = & $_POST["esi"];
		$esi_object = new ExtendedServiceInformation($esi_array);
		if ($esi_object->is_complete($oreon->user->get_version()) && $esi_object->twiceTest($esis))	{
			$oreon->saveExtendedServiceInformation($esi_object);
			// log oreon
			system("echo \"[" . time() . "] ChangeServiceExtendedInfos;" . addslashes($services[$esis[$esi_array["esi_id"]]->get_service()]->get_description()) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
			$esis[$esi_array["esi_id"]]->set_notes($esi_array["esi_notes"]);
			$esis[$esi_array["esi_id"]]->set_notes_url($esi_array["esi_notes_url"]);
			$esis[$esi_array["esi_id"]]->set_action_url($esi_array["esi_action_url"]);
			$esis[$esi_array["esi_id"]]->set_icon_image($esi_array["esi_icon_image"]);
			$esis[$esi_array["esi_id"]]->set_icon_image_alt($esi_array["esi_icon_image_alt"]);
			$oreon->saveExtendedServiceInformation($esis[$esi_array["esi_id"]]);
			$msg = $lang['errCode'][2];
			$_GET["o"] = "w";
		}
		else
			$msg = $lang['errCode'][$esi_object->get_errCode()];
		unset ($esi_object);
	}

	if (isset($_GET["o"]) && !strcmp($_GET["o"], "d"))	{
		// log oreon
		system("echo \"[" . time() . "] DeleteServiceExtendedInfos;" . addslashes($services[$esis[$_GET["esi_id"]]->get_service()]->get_description()) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
		$oreon->deleteExtendedServiceInformation($esis[$_GET["esi_id"]]);
		unset($_GET["o"]);
		unset($_GET["esi_id"]);
	}

	if (isset($_GET["o"]) && !strcmp($_GET["o"], "l"))	{
		if (isset($_GET["box"]))	{
			$boxx = & $_GET["box"];
			foreach ($boxx as $box)	{
				// log add
				system("echo \"[" . time() . "] DeleteServiceExtendedInfos;" . addslashes($services[$esis[$box]->get_service()]->get_description()) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
				$oreon->deleteExtendedServiceInformation($esis[$box]);
			}
		}
		unset($_GET["o"]);
	}

	function write_esi_list(&$hosts, &$services, &$esis, $lang)	{
		?>
		<table cellpadding="0" cellspacing="0" width="200">
			<tr>
				<td class="tabTableTitleMenu"><? print $lang["m_options"]; ?></td>
			</tr>
			<tr>
				<td class="tabTableMenu">
					<div style="padding: 8px; text-align: center;">
						<img src="img/picto2.gif">
						<a href="phpradmin.php?p=114&o=a" class="text9"><? echo $lang['add']; ?></a>
						<img src="img/picto2_bis.gif">
					</div>
				</td>
			</tr>
		</table>
		<br>
		<table cellpadding="0" cellspacing="0" width="200">
			<tr>
				<td class="tabTableTitleMenu" style="white-space: nowrap"><? print $lang['esi_available']; ?></td>
			</tr>
			<tr>
				<td class="tabTableMenu">
				 <?
				 if (isset($esis))
					foreach ($esis as $esi)	{ ?>
						<div style="padding: 2px; white-space: nowrap" align="left">
							<li>
								<a href="phpradmin.php?p=114&esi_id=<? echo $esi->get_id(); ?>&o=w" class="text10" <? if (!$services[$esi->get_service()]->get_activate() || !$hosts[$esi->get_host()]->get_activate()) echo "style='text-decoration: line-through;'"; ?>>
									<? echo $hosts[$esi->get_host()]->get_name(). " / ".$services[$esi->get_service()]->get_description(); ?>
								</a>
							</li>
						</div>
				<?  unset($esi); }?>
				</td>
			</tr>
		</table><?
	}

	function write_esi_list2(&$hosts, &$services, &$esis, $lang)	{	?>
		<form action="" name="serviceExtendedInfosMenu" method="get">
			<table cellpadding="3" cellspacing="3">
				<tr>
					<td class="listTop"></td>
					<td align="left" class="listTop" style="padding-left: 20px; padding-right: 20px;"><? echo $lang['h']; ?></td>
					<td align="left" class="listTop" style="padding-left: 20px; padding-right: 20px;"><? echo $lang['s']; ?></td>
					<td align="left" class="listTop" style="padding-left: 20px; padding-right: 20px;"><? echo $lang['description']; ?></td>
					<td align="center" class="listTop" style="padding-left: 20px; padding-right: 20px;"><? echo $lang['status']; ?></td>
					<td align="center" class="listTop" style="padding-left: 20px; padding-right: 20px;"><? echo $lang['options']; ?></td>
				</tr>
	<?
		if (!isset($_GET["num"]))
			$num = 1;
		else
			$num = $_GET["num"];
		if (isset($esis) && count($esis) != 0)	{
			$cpt = 0;
			foreach ($esis as $esi)	{
				if ($cpt < (VIEW_MAX * $num) && ($cpt >= ((VIEW_MAX * $num) - (VIEW_MAX)))){	?>
				<tr>
					<td class="listSub<? echo $cpt%2; ?>"><input type="checkbox" name="box[<? echo $esi->get_id(); ?>]" value="<? echo $esi->get_id(); ?>"></td>
					<td align="left" class="listSub<? echo $cpt%2; ?>"><a href="phpradmin.php?p=102&h=<? echo $esi->get_host(); ?>&o=w" class="text11"><? echo $hosts[$esi->get_host()]->get_name(); ?></a></td>
					<td align="left" class="listSub<? echo $cpt%2; ?>"><a href="phpradmin.php?p=104&sv=<? echo $esi->get_service(); ?>&o=w" class="text11"><? echo $services[$esi->get_service()]->get_description(); ?></a></td>
					<td align="left" class="listSub<? echo $cpt%2; ?>"><? echo $esi->get_notes(); ?></td>
					<td align="center" class="listSub<? echo $cpt%2; ?>"><? if ($services[$esi->get_service()]->get_activate() && $hosts[$esi->get_host()]->get_activate()) echo $lang['enable']; else echo $lang['disable']; ?></td>
					<td align="center" class="listSub<? echo $cpt%2; ?>">
						&nbsp;&nbsp;
						<a href="phpradmin.php?p=114&esi_id=<? echo $esi->get_id(); ?>&o=w" class="text11"><img src="img/listView.gif" border="0" alt="<? echo $lang['view']; ?>" title="<? echo $lang['view']; ?>"></a>&nbsp;
						<a href="phpradmin.php?p=114&esi_id=<? echo $esi->get_id(); ?>&o=c" class="text11"><img src="img/listPen.gif" border="0" alt="<? echo $lang['modify']; ?>" title="<? echo $lang['modify']; ?>"></a>&nbsp;
						<a href="phpradmin.php?p=114&esi_id=<? echo $esi->get_id(); ?>&o=d&num=<? echo $num; ?>&limit=<? echo VIEW_MAX; ?>" class="text11" onclick="return confirm('<? echo $lang['confirm_removing']; ?>')"><img src="img/listDel.gif" border="0" alt="<? echo $lang['delete']; ?>" title="<? echo $lang['delete']; ?>"></a>&nbsp;&nbsp;
					</td>
				</tr>
			<?	}
				unset($serviceGroup);
				$cpt++;
				}
			} ?>
			<tr>
				<td colspan="2" valign="top"><img src="img/arrow_ltr.gif" style="padding-left: 5px;">&nbsp;&nbsp;	<a href="#" class="text10bc" onclick=" if (confirm('<? echo $lang['confirm_removing']; ?>')){document.forms['serviceExtendedInfosMenu'].submit();}"><? echo $lang['m_delete_selection']; ?></a></td>
				<td></td>
				<td colspan="2" align="right" class="text10">
					<a href="phpradmin.php?p=114&o=a" class="text10bc"><? echo $lang['add']; ?></a>&nbsp;&nbsp;<br><br>
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
					<? $nbrPage = floor(count($esis)/VIEW_MAX); if(count($esis)%VIEW_MAX) $nbrPage++; ?>
					<? echo "<font class='text11b'>".$lang["page"]. ":&nbsp;&nbsp;</font>[&nbsp;&nbsp;";
						for ($i = 1; $i <= $nbrPage; $i++)	{
							if($num == $i)
								echo "<a href='./phpradmin.php?p=114&num=$i&limit=".VIEW_MAX."' class='text10'><b>$i</b></a>&nbsp;&nbsp;";
							else
								echo "<a href='./phpradmin.php?p=114&num=$i&limit=".VIEW_MAX."' class='text10'>$i</a>&nbsp;&nbsp;";
						}
						echo "]";
					?>
				</td>
			</tr>
		</table>
		<input type="hidden" name="p" value="114">
		<input type="hidden" name="o" value="l" id="option">
	</form>
	<? } 

if (!isset($_GET["o"])){ ?>
	<table border="0">
		<tr>
			  <td valign="top" align="left">
				<? write_esi_list2($hosts, $services, $esis, $lang); ?>
			  </td>
		</tr>
	</table>
<? } else if (isset($_GET["o"])){
		if (isset($_GET["esi_id"]))
			$esi_id= $_GET["esi_id"]; ?>
	<table align="left" border="0">
		<tr>
			<td valign="top" align="left"><?  write_esi_list($hosts, $services, $esis, $lang); ?></td>
			<td valign="top" style="padding-left: 20px;"></td>
			<td valign="top" align='left'>
				<? if (isset($msg))
					echo "<div align='center' class='msg' style='padding-bottom: 10px;'>$msg</div>";?>
				<table border='0' align="left" cellpadding="0" cellspacing="0">
					<tr>
						<td class="tabTableTitle" style="white-space: nowrap;">Service Extended Infos <? if (!strcmp($_GET["o"], "c") || !strcmp($_GET["o"], "w")) {  echo "\"" . $hosts[$services[$esis[$esi_id]->get_service()]->get_host()]->get_name(). " / ".$services[$esis[$esi_id]->get_service()]->get_description() . "\"";} ?></td>
					</tr>
					<tr>
						<td class="tabTableForTab">
						<? 	if (!strcmp($_GET["o"], "w") || !strcmp($_GET["o"], "c") || !strcmp($_GET["o"], "a"))
								include("./include/configuration/service_extended_info/service_extended_info_".$_GET["o"].".php"); ?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
<? } ?>