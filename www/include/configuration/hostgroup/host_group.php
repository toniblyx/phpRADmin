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

	$hostGroups = & $oreon->hostGroups;
	if (isset($_GET) && array_key_exists("o", $_GET) && $_GET["o"] != "a" && $_GET["o"] != "l")
		if (!isset($_GET["hg"]) || (isset($_GET["hg"]) && !array_key_exists($_GET["hg"], $hostGroups)))	{
			echo "<td width='85%'></td>";
			include ("./footer.php");
			exit();
		}
	$hosts = & $oreon->hosts;
	$contactGroups = & $oreon->contactGroups;
	$htms = & $oreon->htms;

	if (isset($_POST["ChangeHG"]))	{
		$hg_array = & $_POST["hg"];
		$hg_object = new HostGroup($hg_array);
		if (isset($_POST["selectHost"]))	{
			$selectHost = $_POST["selectHost"];
			for ($i = 0; $i < count($selectHost); $i++)
				$hg_object->hosts[$selectHost[$i]] = & $hosts[$selectHost[$i]];
		}
		if (isset($_POST["selectCG"]))	{
			$selectCG = $_POST["selectCG"];
			for ($i = 0; $i < count($selectCG); $i++)
				$hg_object->contact_groups[$selectCG[$i]] = & $oreon->contactGroups[$selectCG[$i]];
		}
		if ($hg_object->is_complete($oreon->user->get_version()) && $hg_object->twiceTest($hostGroups))	{
			// log oreon
			system("echo \"[".time()."] ChangeHostGroup;".addslashes($hg_array["hg_name"]).";".addslashes($oreon->user->get_alias())."\" >>./include/log/".date("Ymd").".txt");
			$hostGroups[$hg_array["hg_id"]] = $hg_object;
			$hostGroups[$hg_array["hg_id"]]->set_comment($hg_array["hg_comment"]);
			if ($hg_array["hg_activate"]) $hostGroups[$hg_array["hg_id"]]->set_activate(1); else $hostGroups[$hg_array["hg_id"]]->set_activate(0);
			$oreon->saveHostGroup($hostGroups[$hg_array["hg_id"]]);
			$msg = $lang['errCode'][2];
			$_GET["o"] = "w";
		}
		else
			$msg = $lang['errCode'][$hg_object->get_errCode()];
		unset ($hg_object);
	}

	if (isset($_POST["AddHG"]))	{
		$hg_array = & $_POST["hg"];
		$hg_array["hg_id"] = -1;
		$hg_object = new HostGroup($hg_array);
		if (isset($_POST["selectHost"]))	{
			$selectHost = $_POST["selectHost"];
			for ($i = 0; $i < count($selectHost); $i++)
				$hg_object->hosts[$selectHost[$i]] = & $hosts[$selectHost[$i]];
		}
		if (isset($_POST["selectCG"]))	{
			$selectCG = $_POST["selectCG"];
			for ($i = 0; $i < count($selectCG); $i++)
				$hg_object->contact_groups[$selectCG[$i]] = & $oreon->contactGroups[$selectCG[$i]];
		}
		if ($hg_object->is_complete($oreon->user->get_version()) && $hg_object->twiceTest($hostGroups))	{
			// log oreon
			system("echo \"[".time()."] AddHostGroup;".addslashes($hg_array["hg_name"]).";".addslashes($oreon->user->get_alias())."\" >>./include/log/".date("Ymd").".txt");
			$oreon->saveHostGroup($hg_object);
			$hg_id = $oreon->database->database->get_last_id();
			$hostGroups[$hg_id] = $hg_object;
			$hostGroups[$hg_id]->set_id($hg_id);
			$hostGroups[$hg_id]->set_comment($hg_array["hg_comment"]);
			if ($hg_array["hg_activate"]) $hostGroups[$hg_id]->set_activate(1); else $hostGroups[$hg_id]->set_activate(0);
			$oreon->saveHostGroup($hostGroups[$hg_id]);
			$msg = $lang['errCode'][3];
			$_GET["o"] = "w";
			$_GET["hg"] = $hg_id;
		}
		else
			$msg = $lang['errCode'][$hg_object->get_errCode()];
		unset ($hg_object);
	}

	if (isset($_GET["o"]) && !strcmp($_GET["o"], "dup"))	{
		$hg_cpy = $_GET["hg"];
		$hg_array = array();
		$hg_array["hg_id"] = -1;
		$hg_array["hg_name"] = $hostGroups[$hg_cpy]->get_name()."_1";
		$hg_array["hg_alias"] = $hostGroups[$hg_cpy]->get_alias();
		$hg_object = new HostGroup($hg_array);
		foreach ($hostGroups[$hg_cpy]->hosts as $h)	{
			$hg_object->hosts[$h->get_id()] = & $hosts[$h->get_id()];
			unset($h);
		}
		foreach($hostGroups[$hg_cpy]->contact_groups as $cg)	{
			$hg_object->contact_groups[$cg->get_id()] = & $oreon->contactGroups[$cg->get_id()];
			unset($cg);
		}
		if ($hg_object->is_complete($oreon->user->get_version()) && $hg_object->twiceTest($hostGroups))	{
			// log oreon
			system("echo \"[".time()."] AddHostGroup;".addslashes($hg_array["hg_name"]).";".addslashes($oreon->user->get_alias())."\" >>./include/log/".date("Ymd").".txt");
			$oreon->saveHostGroup($hg_object);
			$hg_id = $oreon->database->database->get_last_id();
			$hostGroups[$hg_id] = $hg_object;
			$hostGroups[$hg_id]->set_id($hg_id);
			$hostGroups[$hg_id]->set_comment($hostGroups[$hg_cpy]->get_comment());
			$hostGroups[$hg_id]->set_activate(1);
			$oreon->saveHostGroup($hostGroups[$hg_id]);
			$msg = $lang['errCode'][3];
			$_GET["o"] = "w";
			$_GET["hg"] = $hg_id;
		}
		else
			$msg = $lang['errCode'][$hg_object->get_errCode()];
		unset ($hg_object);
	}

	if (isset($_GET["o"]) && !strcmp($_GET["o"], "d"))	{
		// log oreon
		system("echo \"[".time()."] DeleteHostGroup;".addslashes($hostGroups[$_GET["hg"]]->get_name()).";".addslashes($oreon->user->get_alias())."\" >>./include/log/".date("Ymd").".txt");
		$oreon->deleteHostGroup($hostGroups[$_GET["hg"]]);
		unset($_GET["o"]);
		unset($_GET["hg"]);
	}

	if (isset($_GET["o"]) && !strcmp($_GET["o"], "l"))	{
		if (isset($_GET["box"]))	{
			$boxx = & $_GET["box"];
			foreach ($boxx as $box)	{
				// log add
				system("echo \"[" . time() . "] DeleteHostGroup;" . addslashes($hostGroups[$box]->get_name()) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
				$oreon->deleteHostGroup($hostGroups[$box]);
			}
		}
		unset($_GET["o"]);
	}

	function write_hg_list(& $hostGroups, $lang)	{
		?>
		<table cellpadding="0" cellspacing="0" width="160">
			<tr>
				<td class="tabTableTitleMenu"><? print $lang["m_options"]; ?></td>
			</tr>
			<tr>
				<td class="tabTableMenu">
					<div style="padding: 8px; text-align: center;">
						<img src="img/picto2.gif">
						<a href="phpradmin.php?p=103&o=a" class="text9"><? echo $lang['add']; ?></a>
						<img src="img/picto2_bis.gif">
					</div>
				</td>
			</tr>
		</table>
		<br>
		<table cellpadding="0" cellspacing="0" width="160">
			<tr>
				<td class="tabTableTitleMenu"><? print $lang['hg_available']; ?></td>
			</tr>
			<tr>
				<td class="tabTableMenu">
		 <? 
		 if (isset($hostGroups))
			foreach ($hostGroups as $hostgroup)	{ ?>
				<div style="padding: 2px; white-space: nowrap;" align="left">
					<li>
						<a href="phpradmin.php?p=103&hg=<? echo $hostgroup->get_id(); ?>&o=w" class="text10" <? if(!$hostgroup->get_activate()) echo "style='text-decoration: line-through;'"; ?>>
							<? echo $hostgroup->get_name(); ?>
						</a>
					</li>
				</div>
			<? unset($hostgroup); }?>
				</td>
			</tr>
		</table><?
	}

	function write_hg_list2(&$hostGroups, $lang)	{	?>
		<form action="" name="hostGroupMenu" method="get">
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
		if (isset($hostGroups) && count($hostGroups) != 0)	{
			$cpt = 0;
			foreach ($hostGroups as $hostGroup)	{
				if ($cpt < (VIEW_MAX * $num) && ($cpt >= ((VIEW_MAX * $num) - (VIEW_MAX)))){	?>
				<tr>
					<td class="listSub<? echo $cpt%2; ?>"><input type="checkbox" name="box[<? echo $hostGroup->get_id(); ?>]" value="<? echo $hostGroup->get_id(); ?>"></td>
					<td align="left" class="listSub<? echo $cpt%2; ?>"><a href="phpradmin.php?p=103&hg=<? echo $hostGroup->get_id(); ?>&o=w" class="text11"><? echo $hostGroup->get_name(); ?></a></td>
					<td align="left" class="listSub<? echo $cpt%2; ?>"><? echo $hostGroup->get_alias(); ?></td>
					<td align="center" class="listSub<? echo $cpt%2; ?>"><? if ($hostGroup->get_activate()) echo $lang['enable']; else echo $lang['disable']; ?></td>
					<td class="listSub<? echo $cpt%2; ?>">
						&nbsp;&nbsp;
						<a href="phpradmin.php?p=103&hg=<? echo $hostGroup->get_id(); ?>&o=w" class="text11"><img src="img/listView.gif" border="0" alt="<? echo $lang['view']; ?>" title="<? echo $lang['view']; ?>"></a>&nbsp;
						<a href="phpradmin.php?p=103&hg=<? echo $hostGroup->get_id(); ?>&o=c" class="text11"><img src="img/listPen.gif" border="0" alt="<? echo $lang['modify']; ?>" title="<? echo $lang['modify']; ?>"></a>&nbsp;
						<a href="phpradmin.php?p=103&hg=<? echo $hostGroup->get_id(); ?>&o=dup" class="text11"><img src="img/listDup.gif" border="0" alt="<? echo $lang['dup']; ?>" title="<? echo $lang['dup']; ?>"></a>&nbsp;
						<a href="phpradmin.php?p=103&hg=<? echo $hostGroup->get_id(); ?>&o=d&num=<? echo $num; ?>&limit=<? echo VIEW_MAX; ?>" class="text11" onclick="return confirm('<? echo $lang['confirm_removing']; ?>')"><img src="img/listDel.gif" border="0" alt="<? echo $lang['delete']; ?>" title="<? echo $lang['delete']; ?>"></a>&nbsp;&nbsp;
					</td>
				</tr>
			<?	}
				unset($hostGroup);
				$cpt++;
				}
			} ?>
			<tr>
				<td colspan="2" valign="top"><img src="img/arrow_ltr.gif" style="padding-left: 5px;">&nbsp;&nbsp;	<a href="#" class="text10bc" onclick=" if (confirm('<? echo $lang['confirm_removing']; ?>')){document.forms['hostGroupMenu'].submit();}"><? echo $lang['m_delete_selection']; ?></a></td>
				<td></td>
				<td colspan="2" align="right" class="text10">
					<a href="phpradmin.php?p=103&o=a" class="text10bc"><? echo $lang['add']; ?></a>&nbsp;&nbsp;<br><br>
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
					<? $nbrPage = floor(count($hostGroups)/VIEW_MAX); if(count($hostGroups)%VIEW_MAX) $nbrPage++; ?>
					<? echo "<font class='text11b'>".$lang["page"]. ":&nbsp;&nbsp;</font>[&nbsp;&nbsp;";
						for ($i = 1; $i <= $nbrPage; $i++)	{
							if($num == $i)
								echo "<a href='./phpradmin.php?p=103&num=$i&limit=".VIEW_MAX."' class='text10'><b>$i</b></a>&nbsp;&nbsp;";
							else
								echo "<a href='./phpradmin.php?p=103&num=$i&limit=".VIEW_MAX."' class='text10'>$i</a>&nbsp;&nbsp;";
						}
						echo "]";
					?>
				</td>
			</tr>
		</table>
		<input type="hidden" name="p" value="103">
		<input type="hidden" name="o" value="l" id="option">
	</form>
	<? } 
	
if (!isset($_GET["o"])){?>
	<table border="0" align="left">
		<tr>
			<td valign="top"><? write_hg_list2($hostGroups, $lang); ?></td>
		</tr>
	</table>
<? } else if (isset($_GET["o"]))	{
		if (isset($_GET["hg"]))
			$hg = $_GET["hg"];?>
	<table align="left" border="0">
		<tr>
			<td valign="top" align="left"><? write_hg_list($hostGroups, $lang); ?></td>
			<td style="padding-left: 20px;"></td>
			<td valign="top" width='400'>
			<? if (isset($msg))
				echo "<div align='center' class='msg' style='padding-bottom: 10px;'>$msg</div>"; ?>
				<table border='0' align="left" cellpadding="0" cellspacing="0" width="400">
					<tr>
						<td align="center" class="tabTableTitle">HostGroup <? if (!strcmp($_GET["o"], "c") || !strcmp($_GET["o"], "w")) {  echo "\"".$hostGroups[$hg]->get_name()."\"";} ?></td>
					</tr>
					<tr>
						<td class="tabTableForTab">
						<? 	if (!strcmp($_GET["o"], "w") || !strcmp($_GET["o"], "c") || !strcmp($_GET["o"], "a"))
								include("./include/configuration/hostgroup/hostgroup_".$_GET["o"].".php"); ?>
				 		</td>
				 	</tr>
				</table>
			</td>
		</tr>
	</table>
<? } ?>