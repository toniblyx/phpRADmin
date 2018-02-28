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

	$serviceGroups = & $oreon->serviceGroups;
	if (isset($_GET) && array_key_exists("o", $_GET) && $_GET["o"] != "a" && $_GET["o"] != "l")
		if (!isset($_GET["sg"]) || (isset($_GET["sg"]) && !array_key_exists($_GET["sg"], $serviceGroups)))	{
			echo "<td width='85%'></td>";
			include ("./footer.php");
			exit();
		}
	$services = & $oreon->services;
	$hosts = & $oreon->hosts;

	if (isset($_POST["Changesg"]))	{
		$sg_array = & $_POST["sg"];
		$sg_object = new ServiceGroup($sg_array);
		if (isset($_POST["selectService"]))	{
			$selectService = $_POST["selectService"];
			for ($i = 0; $i < count($selectService); $i++)
				$sg_object->services[$selectService[$i]] = & $services[$selectService[$i]];
		}
		if ($sg_object->is_complete($oreon->user->get_version()))	{
			$oreon->saveServiceGroup($sg_object);
			$serviceGroups[$sg_array["sg_id"]] = $sg_object;
			$serviceGroups[$sg_array["sg_id"]]->set_comment($sg_array["sg_comment"]);
			if ($sg_array["sg_activate"]) $serviceGroups[$sg_array["sg_id"]]->set_activate(1); else $serviceGroups[$sg_array["sg_id"]]->set_activate(0);
			$oreon->saveServiceGroup($serviceGroups[$sg_array["sg_id"]]);
			// log oreon
			system("echo \"[" . time() . "] ChangeServiceGroup;" .addslashes($serviceGroups[$sg_array["sg_id"]]->get_name()) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
			$msg = $lang['errCode'][2];
			$_GET["o"] = "w";
		}
		else
			$msg = $lang['errCode'][$sg_object->get_errCode()];
		unset ($sg_obj);
	}

	if (isset($_POST["AddSG"]))	{
		$sg_array = & $_POST["sg"];
		$sg_array["sg_id"] = -1;
		$sg_object = new ServiceGroup($sg_array);
		if (isset($_POST["selectService"]))	{
			$selectService = $_POST["selectService"];
			for ($i = 0; $i < count($selectService); $i++)
				$sg_object->services[$selectService[$i]] = & $services[$selectService[$i]];
		}
		if ($sg_object->is_complete($oreon->user->get_version()))	{
			$oreon->saveServiceGroup($sg_object);
			$sg_id = $oreon->database->database->get_last_id();
			$serviceGroups[$sg_id] = $sg_object;
			$serviceGroups[$sg_id]->set_id($sg_id);
			$serviceGroups[$sg_id]->set_comment($sg_array["sg_comment"]);
			if ($sg_array["sg_activate"]) $serviceGroups[$sg_id]->set_activate(1); else $serviceGroups[$sg_id]->set_activate(0);
			$oreon->saveServiceGroup($serviceGroups[$sg_id]);
			// log oreon
			system("echo \"[" . time() . "] AddServiceGroup;" .addslashes($serviceGroups[$sg_id]->get_name()) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
			$msg = $lang['errCode'][3];
			$_GET["o"] = "w";
			$_GET["sg"] = $sg_id;
		}
		else
			$msg = $lang['errCode'][$sg_object->get_errCode()];
		unset ($sg_object);
	}

	if (isset($_GET["o"]) && !strcmp($_GET["o"], "d"))	{
		// log oreon
		system("echo \"[" . time() . "] DeleteServiceGroup;" .addslashes($serviceGroups[$_GET["sg"]]->get_name()) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
		$oreon->deleteServiceGroup($serviceGroups[$_GET["sg"]]);
		unset($_GET["o"]);
		unset($_GET["sg"]);
	}

	if (isset($_GET["o"]) && !strcmp($_GET["o"], "l"))	{
		if (isset($_GET["box"]))	{
			$boxx = & $_GET["box"];
			foreach ($boxx as $box)	{
				// log add
				system("echo \"[" . time() . "] DeleteServiceGroup;" . addslashes($serviceGroups[$box]->get_name()) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
				$oreon->deleteServiceGroup($serviceGroups[$box]);
			}
		}
		unset($_GET["o"]);
	}

	if (isset($_GET["o"]) && !strcmp($_GET["o"], "dup"))	{
		$sg_cpy = $_GET["sg"];
		$sg_array = array();
		$sg_array["sg_id"] = -1;
		$sg_array["sg_name"] = $serviceGroups[$sg_cpy]->get_name()."_1";
		$sg_array["sg_alias"] = $serviceGroups[$sg_cpy]->get_alias();
		$sg_object = new ServiceGroup($sg_array);
		foreach ($serviceGroups[$sg_cpy]->services as $s)	{
			$sg_object->services[$s->get_id()] = & $services[$s->get_id()];
			unset($s);
		}
		if ($sg_object->is_complete($oreon->user->get_version()) && $sg_object->twiceTest($serviceGroups))	{
			// log oreon
			system("echo \"[".time()."] AddServiceGroup;".addslashes($sg_array["sg_name"]).";".addslashes($oreon->user->get_alias())."\" >>./include/log/".date("Ymd").".txt");
			$oreon->saveServiceGroup($sg_object);
			$sg_id = $oreon->database->database->get_last_id();
			$serviceGroups[$sg_id] = $sg_object;
			$serviceGroups[$sg_id]->set_id($sg_id);
			$serviceGroups[$sg_id]->set_comment($serviceGroups[$sg_cpy]->get_comment());
			$serviceGroups[$sg_id]->set_activate(1);
			$oreon->saveServiceGroup($serviceGroups[$sg_id]);
			$msg = $lang['errCode'][3];
			$_GET["o"] = "w";
			$_GET["sg"] = $sg_id;
		}
		else
			$msg = $lang['errCode'][$sg_object->get_errCode()];
		unset ($sg_object);
	}

	function write_sg_list($serviceGroups, $lang)	{
	?>
		<table cellpadding="0" cellspacing="0" width="160">
			<tr>
				<td class="tabTableTitleMenu"><? print $lang["m_options"]; ?></td>
			</tr>
			<tr>
				<td class="tabTableMenu">
					<div style="padding: 8px; text-align: center;">
						<img src="img/picto2.gif">
						<a href="phpradmin.php?p=105&o=a" class="text9"><? echo $lang['add']; ?></a>
						<img src="img/picto2_bis.gif">
					</div>
				</td>
			</tr>
		</table>
		<br>
		<table cellpadding="0" cellspacing="0" width="160">
			<tr>
				<td class="tabTableTitleMenu"><? print $lang['sg_available']; ?></td>
			</tr>
			<tr>
				<td class="tabTableMenu">
				 <?
				if (isset($serviceGroups))
					foreach ($serviceGroups as $sg)	{ ?>
						<div style="padding: 2px; white-space: nowrap" align="left">
							<li>
								<a href="phpradmin.php?p=105&sg=<? echo $sg->get_id(); ?>&o=w" class="text10" <? if(!$sg->get_activate()) echo "style='text-decoration: line-through;'"; ?>>
									<? echo $sg->get_name(); ?>
								</a>
							</li>
						</div>
				<?  unset($sg); }?>
						</td>
					</tr>
				</table><?
	}

	function write_sg_list2(&$serviceGroups, $lang)	{	?>
		<form action="" name="serviceGroupMenu" method="get">
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
		if (isset($serviceGroups) && count($serviceGroups) != 0)	{
			$cpt = 0;
			foreach ($serviceGroups as $serviceGroup)	{
				if ($cpt < (VIEW_MAX * $num) && ($cpt >= ((VIEW_MAX * $num) - (VIEW_MAX)))){	?>
				<tr>
					<td class="listSub<? echo $cpt%2; ?>"><input type="checkbox" name="box[<? echo $serviceGroup->get_id(); ?>]" value="<? echo $serviceGroup->get_id(); ?>"></td>
					<td align="left" class="listSub<? echo $cpt%2; ?>"><a href="phpradmin.php?p=105&sg=<? echo $serviceGroup->get_id(); ?>&o=w" class="text11"><? echo $serviceGroup->get_name(); ?></a></td>
					<td align="left" class="listSub<? echo $cpt%2; ?>"><? echo $serviceGroup->get_alias(); ?></td>
					<td align="center" class="listSub<? echo $cpt%2; ?>"><? if ($serviceGroup->get_activate()) echo $lang['enable']; else echo $lang['disable']; ?></td>
					<td class="listSub<? echo $cpt%2; ?>">
						&nbsp;&nbsp;
						<a href="phpradmin.php?p=105&sg=<? echo $serviceGroup->get_id(); ?>&o=w" class="text11"><img src="img/listView.gif" border="0" alt="<? echo $lang['view']; ?>" title="<? echo $lang['view']; ?>"></a>&nbsp;
						<a href="phpradmin.php?p=105&sg=<? echo $serviceGroup->get_id(); ?>&o=c" class="text11"><img src="img/listPen.gif" border="0" alt="<? echo $lang['modify']; ?>" title="<? echo $lang['modify']; ?>"></a>&nbsp;
						<a href="phpradmin.php?p=105&sg=<? echo $serviceGroup->get_id(); ?>&o=dup" class="text11"><img src="img/listDup.gif" border="0" alt="<? echo $lang['dup']; ?>" title="<? echo $lang['dup']; ?>"></a>&nbsp;
						<a href="phpradmin.php?p=105&sg=<? echo $serviceGroup->get_id(); ?>&o=d&num=<? echo $num; ?>&limit=<? echo VIEW_MAX; ?>" class="text11" onclick="return confirm('<? echo $lang['confirm_removing']; ?>')"><img src="img/listDel.gif" border="0" alt="<? echo $lang['delete']; ?>" title="<? echo $lang['delete']; ?>"></a>&nbsp;&nbsp;
					</td>
				</tr>
			<?	}
				unset($serviceGroup);
				$cpt++;
				}
			} ?>
			<tr>
				<td colspan="2" valign="top"><img src="img/arrow_ltr.gif" style="padding-left: 5px;">&nbsp;&nbsp;	<a href="#" class="text10bc" onclick=" if (confirm('<? echo $lang['confirm_removing']; ?>')){document.forms['serviceGroupMenu'].submit();}"><? echo $lang['m_delete_selection']; ?></a></td>
				<td></td>
				<td colspan="2" align="right" class="text10">
					<a href="phpradmin.php?p=105&o=a" class="text10bc"><? echo $lang['add']; ?></a>&nbsp;&nbsp;<br><br>
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
					<? $nbrPage = floor(count($serviceGroups)/VIEW_MAX); if(count($serviceGroups)%VIEW_MAX) $nbrPage++; ?>
					<? echo "<font class='text11b'>".$lang["page"]. ":&nbsp;&nbsp;</font>[&nbsp;&nbsp;";
						for ($i = 1; $i <= $nbrPage; $i++)	{
							if($num == $i)
								echo "<a href='./phpradmin.php?p=105&num=$i&limit=".VIEW_MAX."' class='text10'><b>$i</b></a>&nbsp;&nbsp;";
							else
								echo "<a href='./phpradmin.php?p=105&num=$i&limit=".VIEW_MAX."' class='text10'>$i</a>&nbsp;&nbsp;";
						}
						echo "]";
					?>
				</td>
			</tr>
		</table>
		<input type="hidden" name="p" value="105">
		<input type="hidden" name="o" value="l" id="option">
	</form>
	<? } 
	
	
if (!isset($_GET["o"])){ ?>
	<table border="0">
		<tr>
			  <td valign="top" align="left">
				<? write_sg_list2($serviceGroups, $lang); ?>
			  </td>
		</tr>
	</table>
<? } else if (isset($_GET["o"]))	{
		if (isset($_GET["sg"]))
			$sg= $_GET["sg"]; ?>
	<table align="left" border="0">
		<tr>
			<td valign="top" align="left"><? write_sg_list($serviceGroups, $lang); ?></td>
			<td valign="top" style="padding-left: 20px;"></td>
			<td valign="top" align='left'>
				<? if (isset($msg))
					echo "<div align='center' class='msg' style='padding-bottom: 10px;'>$msg</div>"; ?>
				<table border='0' align="left" cellpadding="0" cellspacing="0" width="500">
					<tr>
						<td class="tabTableTitle" align='center' style="white-space: nowrap;">Service Groups <? if (!strcmp($_GET["o"], "c") || !strcmp($_GET["o"], "w")) {  echo "\"" . $serviceGroups[$sg]->get_name() . "\"";} ?></td>
					</tr>
					<tr>
						<td class="tabTableForTab">
						<? 	if (!strcmp($_GET["o"], "w") || !strcmp($_GET["o"], "c") || !strcmp($_GET["o"], "a"))
								include("./include/configuration/service_group/service_group_".$_GET["o"].".php"); ?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
<? } ?>