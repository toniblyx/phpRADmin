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

	$contactGroups = & $oreon->contactGroups;
	if (isset($_GET) && array_key_exists("o", $_GET) && $_GET["o"] != "a" && $_GET["o"] != "l")
		if (!isset($_GET["cg"]) || (isset($_GET["cg"]) && !array_key_exists($_GET["cg"], $contactGroups)))	{
			echo "<td width='85%'></td>";
			include ("./footer.php");
			exit();
		}
	$contacts = & $oreon->contacts;
	$services = & $oreon->services;
	$hes = & $oreon->hes;
	$ses = & $oreon->ses;

	if (isset($_POST["Changecg"]))	{
		$cg_array = & $_POST["cg"];
		$cg_object = new ContactGroup($cg_array);
		if (isset($_POST["selectContact"]))	{
			$selectContact = $_POST["selectContact"];
			for ($i = 0; $i < count($selectContact); $i++)
				$cg_object->contacts[$selectContact[$i]] = & $contacts[$selectContact[$i]];
		}
		if ($cg_object->is_complete($oreon->user->get_version()) && $cg_object->twiceTest($contactGroups))	{
			// log oreon
			system("echo \"[" . time() . "] ChangeContactGroup;" . addslashes($cg_object->get_name()) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
			$contactGroups[$cg_object->get_id()] = $cg_object;
			$contactGroups[$cg_object->get_id()]->set_comment($cg_array["cg_comment"]);
			if ($cg_array["cg_activate"]) $contactGroups[$cg_object->get_id()]->set_activate(1); else $contactGroups[$cg_object->get_id()]->set_activate(0);
			$oreon->saveContactGroup($contactGroups[$cg_object->get_id()]);
			$msg = $lang['errCode'][2];
			$_GET["o"] = "w";
		}
		else
			$msg = $lang['errCode'][$cg_object->get_errCode()];
		unset ($cg_object);
	}
	if (isset($_POST["AddCG"]))	{
		$cg_array = & $_POST["cg"];
		$cg_array["cg_id"] = -1;
		$cg_object = new ContactGroup($cg_array);
		if (isset($_POST["selectContact"]))	{
			$selectContact = $_POST["selectContact"];
			for ($i = 0; $i < count($selectContact); $i++)
				$cg_object->contacts[$selectContact[$i]] = & $contacts[$selectContact[$i]];
		}
		if ($cg_object->is_complete($oreon->user->get_version()) && $cg_object->twiceTest($contactGroups))	{
			// log oreon
			system("echo \"[" . time() . "] AddContactGroup;" . addslashes($cg_object->get_name()) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
			$oreon->saveContactGroup($cg_object);
			$cg_id = $oreon->database->database->get_last_id();
			$contactGroups[$cg_id] = $cg_object;
			$contactGroups[$cg_id]->set_id($cg_id);
			$contactGroups[$cg_id]->set_comment($cg_array["cg_comment"]);
			if ($cg_array["cg_activate"]) $contactGroups[$cg_id]->set_activate(1); else $contactGroups[$cg_id]->set_activate(0);
			$oreon->saveContactGroup($contactGroups[$cg_id]);
			$msg = $lang['errCode'][3];
			$_GET["o"] = "w";
			$_GET["cg"] = $cg_id;
		}
		else
			$msg = $lang['errCode'][$cg_object->get_errCode()];
		unset ($cg_object);
	}

	if (isset($_GET["o"]) && !strcmp($_GET["o"], "dup"))	{
		$cg_cpy = $_GET["cg"];
		$cg_array = array();
		$cg_array["cg_id"] = -1;
		$cg_array["cg_name"] = $contactGroups[$cg_cpy]->get_name()."_1";
		$cg_array["cg_alias"] = $contactGroups[$cg_cpy]->get_alias();
		$cg_object = new ContactGroup($cg_array);
		foreach ($contactGroups[$cg_cpy]->contacts as $cct)	{
			$cg_object->contacts[$cct->get_id()] = & $contacts[$cct->get_id()];
			unset($cct);
		}
		if ($cg_object->is_complete($oreon->user->get_version()) && $cg_object->twiceTest($contactGroups))	{
			// log oreon
			system("echo \"[".time()."] AddContactGroup;".addslashes($cg_array["cg_name"]).";".addslashes($oreon->user->get_alias())."\" >>./include/log/".date("Ymd").".txt");
			$oreon->saveContactGroup($cg_object);
			$cg_id = $oreon->database->database->get_last_id();
			$contactGroups[$cg_id] = $cg_object;
			$contactGroups[$cg_id]->set_id($cg_id);
			$contactGroups[$cg_id]->set_comment($contactGroups[$cg_cpy]->get_comment());
			$contactGroups[$cg_id]->set_activate(0);
			$oreon->saveContactGroup($contactGroups[$cg_id]);
			$msg = $lang['errCode'][3];
			$_GET["o"] = "w";
			$_GET["cg"] = $cg_id;
		}
		else
			$msg = $lang['errCode'][$cg_object->get_errCode()];
		unset ($cg_object);
	}

	if (isset($_GET["o"]) && !strcmp($_GET["o"], "d"))	{
		system("echo \"[" . time() . "] DeleteContactGroup;" . addslashes($contactGroups[$_GET["cg"]]->get_name()) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
		$oreon->deleteContactGroup($contactGroups[$_GET["cg"]]);
		unset($_GET["o"]);
		unset($_GET["cg"]);
	}

	if (isset($_GET["o"]) && !strcmp($_GET["o"], "l"))	{
		if (isset($_GET["box"]))	{
			$boxx = & $_GET["box"];
			foreach ($boxx as $box)	{
				// log add
				system("echo \"[" . time() . "] DeleteContactGroup;" . addslashes($contactGroups[$box]->get_name()) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
				$oreon->deleteContactGroup($contactGroups[$box]);
			}
		}
		unset($_GET["o"]);
	}

	function write_cg_list(&$contactGroups, $lang)	{
		?>
		<table cellpadding="0" cellspacing="0" width="210">
			<tr>
				<td class="tabTableTitleMenu"><? print $lang["m_options"]; ?></td>
			</tr>
			<tr>
				<td class="tabTableMenu">
					<div style="padding: 8px; text-align: center;">
					<img src="img/picto2.gif">
					<a href="phpradmin.php?p=107&o=a" class="text9"><? echo $lang['add']; ?></a>
					<img src="img/picto2_bis.gif">
				</div>
				</td>
			</tr>
		</table>
		<br>
		<table cellpadding="0" cellspacing="0" width="210">
			<tr>
				<td class="tabTableTitleMenu" style="white-space: nowrap"><? print $lang['cg_available']; ?></td>
			</tr>
			<tr>
				<td class="tabTableMenu"> <?
				if (isset($contactGroups))	{
					foreach ($contactGroups as $cg)	{ ?>
						<div style="padding: 2px; white-space: nowrap" align="left">
							<li>
								<a href="phpradmin.php?p=107&cg=<? echo $cg->get_id(); ?>&o=w" class="text10" <? if(!$cg->get_activate()) echo "style='text-decoration: line-through;'"; ?>>
									<? echo $cg->get_name(); ?>
								</a>
							</li>
						</div>
				<?  } unset($cg); } ?>
				</td>
			</tr>
		</table><?
	}

	function write_cg_list2(&$contactGroups, $lang)	{	?>
		<form action="" name="contactGroupMenu" method="get">
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
		if (isset($contactGroups) && count($contactGroups) != 0)	{
			$cpt = 0;
			foreach ($contactGroups as $contactGroup)	{
				if ($cpt < (VIEW_MAX * $num) && ($cpt >= ((VIEW_MAX * $num) - (VIEW_MAX)))){	?>
				<tr>
					<td class="listSub<? echo $cpt%2; ?>"><input type="checkbox" name="box[<? echo $contactGroup->get_id(); ?>]" value="<? echo $contactGroup->get_id(); ?>"></td>
					<td align="left" class="listSub<? echo $cpt%2; ?>"><? echo $contactGroup->get_name(); ?></td>
					<td align="left" class="listSub<? echo $cpt%2; ?>"><? echo $contactGroup->get_alias(); ?></td>
					<td align="center" class="listSub<? echo $cpt%2; ?>"><? if ($contactGroup->get_activate()) echo $lang['enable']; else echo $lang['disable']; ?></td>
					<td class="listSub<? echo $cpt%2; ?>">
						&nbsp;&nbsp;
						<a href="phpradmin.php?p=107&cg=<? echo $contactGroup->get_id(); ?>&o=w" class="text11"><img src="img/listView.gif" border="0" alt="<? echo $lang['view']; ?>" title="<? echo $lang['view']; ?>"></a>&nbsp;
						<a href="phpradmin.php?p=107&cg=<? echo $contactGroup->get_id(); ?>&o=c" class="text11"><img src="img/listPen.gif" border="0" alt="<? echo $lang['modify']; ?>" title="<? echo $lang['modify']; ?>"></a>&nbsp;
						<a href="phpradmin.php?p=107&cg=<? echo $contactGroup->get_id(); ?>&o=dup" class="text11"><img src="img/listDup.gif" border="0" alt="<? echo $lang['dup']; ?>" title="<? echo $lang['dup']; ?>"></a>&nbsp;
						<a href="phpradmin.php?p=107&cg=<? echo $contactGroup->get_id(); ?>&o=d&num=<? echo $num; ?>&limit=<? echo VIEW_MAX; ?>" class="text11" onclick="return confirm('<? echo $lang['confirm_removing']; ?>')"><img src="img/listDel.gif" border="0" alt="<? echo $lang['delete']; ?>" title="<? echo $lang['delete']; ?>"></a>&nbsp;&nbsp;
					</td>
				</tr>
			<?	}
				unset($contactGroup);
				$cpt++;
				}
			} ?>
			<tr>
				<td colspan="2" valign="top"><img src="img/arrow_ltr.gif" style="padding-left: 5px;">&nbsp;&nbsp;	<a href="#" class="text10bc" onclick=" if (confirm('<? echo $lang['confirm_removing']; ?>')){document.forms['contactGroupMenu'].submit();}"><? echo $lang['m_delete_selection']; ?></a></td>
				<td></td>
				<td colspan="2" align="right" class="text10">
					<a href="phpradmin.php?p=107&o=a" class="text10bc"><? echo $lang['add']; ?></a>&nbsp;&nbsp;<br><br>
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
					<? $nbrPage = floor(count($contactGroups)/VIEW_MAX); if(count($contactGroups)%VIEW_MAX) $nbrPage++; ?>
					<? echo "<font class='text11b'>".$lang["page"]. ":&nbsp;&nbsp;</font>[&nbsp;&nbsp;";
						for ($i = 1; $i <= $nbrPage; $i++)	{
							if($num == $i)
								echo "<a href='./phpradmin.php?p=107&num=$i&limit=".VIEW_MAX."' class='text10'><b>$i</b></a>&nbsp;&nbsp;";
							else
								echo "<a href='./phpradmin.php?p=107&num=$i&limit=".VIEW_MAX."' class='text10'>$i</a>&nbsp;&nbsp;";
						}
						echo "]";
					?>
				</td>
			</tr>
		</table>
		<input type="hidden" name="p" value="107">
		<input type="hidden" name="o" value="l" id="option">
	</form>
	<? } ?>
<?
if (!isset($_GET["o"])){ ?>
	<table border="0" align="left">
		<tr>
			<td valign="top"><? write_cg_list2($contactGroups, $lang); ?> 	</td>
		</tr>
	</table>
<? } else if (isset($_GET["o"]))	{
		if (isset($_GET["cg"]))
			$cg = $_GET["cg"];
?>
	<table align="left" border="0">
		<tr>
			<td valign="top" align="center"><? write_cg_list($contactGroups, $lang); ?></td>
			<td style="padding-left: 20px;"></td>
			<td valign="top" align='left'>
			<? if (isset($msg))
				echo "<div align='center' class='msg' style='padding-bottom: 10px;'>$msg</div>"; ?>
			<table border='0' align="left" cellpadding="0" cellspacing="0">
				<tr>
					<td class="tabTableTitle" style="white-space: nowrap;"><? echo $lang['cg']; if (!strcmp($_GET["o"], "c") || !strcmp($_GET["o"], "w")) {  echo " \"" . $contactGroups[$cg]->get_name() . "\"";} ?></td>
				</tr>
				<tr>
					<td class="tabTableForTab">
						<? 	if (!strcmp($_GET["o"], "w") || !strcmp($_GET["o"], "c") || !strcmp($_GET["o"], "a"))
								include("./include/configuration/contact_group/contact_group_".$_GET["o"].".php"); ?>
					</td>
				</tr>
			</table>
		</td>
		<td style="padding-left: 20px;"></td>
		<? if (!strcmp($_GET["o"], "w") || !strcmp($_GET["o"], "c")) { ?>
		<td valign="top" align="left">
			<table border='0' cellpadding="0" cellspacing="0">
				<tr>
					<td class="tabTableTitle" style="white-space: nowrap;">
						<? echo $contactGroups[$cg]->get_name(); echo $lang['cg_related']; ?> :
					</td>
				</tr>
				<tr>
					<td class="tabTable">
						<?
						$i = 0;
						if (isset($services))
							foreach ($services as $sv)	{
								if (isset($sv->contactGroups))
									if (array_key_exists($contactGroups[$cg]->get_id(), $sv->contactGroups))
										$i++;
								unset($sv);
							}
						echo "<li>".$i . " " . $lang['s']."</li>";
						$i = 0;
						if (isset($hes))
							foreach ($hes as $he)	{
								if (isset($he->contactGroups))
									if (array_key_exists($contactGroups[$cg]->get_id(), $he->contactGroups))
										$i++;
								unset($he);
							}
						echo "<li>".$i . " " . $lang['he']."</li>";
						$i = 0;
						if (isset($ses))
							foreach ($ses as $se)	{
								if (isset($se->contactGroups))
									if (array_key_exists($contactGroups[$cg]->get_id(), $se->contactGroups))
										$i++;
								unset($se);
							}
						echo "<li>".$i . " " . $lang['se']."</li>";
						?>
					</td>
				</tr>
				<tr>
					<td bgcolor="#CCCCCC"></td>
				</tr>
			</table>
		</td>
		<? } ?>
		</tr>
	</table>
<?  } ?>