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

	$time_periods = & $oreon->time_periods;
	if (isset($_GET) && array_key_exists("o", $_GET) && $_GET["o"] != "a" && $_GET["o"] != "l")
		if (!isset($_GET["tp"]) || (isset($_GET["tp"]) && !array_key_exists($_GET["tp"], $time_periods)))	{
			echo "<td width='85%'></td>";
			include ("./footer.php");
			exit();
		}

	if (isset($_POST["ChangeTP"]))	{
		$tp_array = & $_POST["time_period"];
		$tp_object = new TimePeriod($tp_array);
		if ($tp_object->is_complete($oreon->user->get_version()) && $tp_object->twiceTest($time_periods))	{
			system("echo \"[" . time() . "] ChangeTimeperiod;" . addslashes($tp_array["tp_name"]) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
			$time_periods[$tp_object->get_id()] = $tp_object;
			$oreon->saveTimePeriod($tp_object);
			$time_periods[$tp_object->get_id()]->set_name($tp_array["tp_name"]);
			$time_periods[$tp_object->get_id()]->set_alias($tp_array["tp_alias"]);
			$time_periods[$tp_object->get_id()]->set_sunday($tp_array["tp_sunday"]);
			$time_periods[$tp_object->get_id()]->set_monday($tp_array["tp_monday"]);
			$time_periods[$tp_object->get_id()]->set_tuesday($tp_array["tp_tuesday"]);
			$time_periods[$tp_object->get_id()]->set_wednesday($tp_array["tp_wednesday"]);
			$time_periods[$tp_object->get_id()]->set_thursday($tp_array["tp_thursday"]);
			$time_periods[$tp_object->get_id()]->set_friday($tp_array["tp_friday"]);
			$time_periods[$tp_object->get_id()]->set_saturday($tp_array["tp_saturday"]);
			$oreon->saveTimePeriod($time_periods[$tp_object->get_id()]);
			$msg = $lang['errCode'][2];
			$_GET["o"] = "w";
		}	else
				$msg = $lang['errCode'][$tp_object->get_errCode()];
		unset ($tp_object);
	}

	if (isset($_POST["AddTP"]))	{
		$tp_array = & $_POST["time_period"];
		$tp_array["tp_id"] = -1;
		$tp_object = new TimePeriod($tp_array);
		if ($tp_object->is_complete($oreon->user->get_version()) && $tp_object->twiceTest($time_periods))	{
			system("echo \"[" . time() . "] AddTimeperiod;" . addslashes($tp_array["tp_name"]) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
			$oreon->saveTimePeriod($tp_object);
			$tp_id = $oreon->database->database->get_last_id();
			$time_periods[$tp_id] = $tp_object;
			$time_periods[$tp_id]->set_id($tp_id);
			$time_periods[$tp_id]->set_sunday($tp_array["tp_sunday"]);
			$time_periods[$tp_id]->set_monday($tp_array["tp_monday"]);
			$time_periods[$tp_id]->set_tuesday($tp_array["tp_tuesday"]);
			$time_periods[$tp_id]->set_wednesday($tp_array["tp_wednesday"]);
			$time_periods[$tp_id]->set_thursday($tp_array["tp_thursday"]);
			$time_periods[$tp_id]->set_friday($tp_array["tp_friday"]);
			$time_periods[$tp_id]->set_saturday($tp_array["tp_saturday"]);
			$oreon->saveTimePeriod($time_periods[$tp_id]);
			$msg = $lang['errCode'][3];
			$_GET["o"] = "w";
			$_GET["tp"] = $tp_id;
		}	else
				$msg = $lang['errCode'][$tp_object->get_errCode()];
		unset ($tp_object);
	}

	if (isset($_GET["o"]) && !strcmp($_GET["o"], "dup"))	{
		$tp_cpy = $_GET["tp"];
		$tp_array = array();
		$tp_array["tp_id"] = -1;
		$tp_array["tp_name"] = $time_periods[$tp_cpy]->get_name()." 1";
		$tp_array["tp_alias"] = $time_periods[$tp_cpy]->get_alias();
		$tp_array["tp_sunday"] = NULL;
		$tp_array["tp_monday"] = NULL;
		$tp_array["tp_tuesday"] = NULL;
		$tp_array["tp_wednesday"] = NULL;
		$tp_array["tp_thursday"] = NULL;
		$tp_array["tp_friday"] = NULL;
		$tp_array["tp_saturday"] = NULL;
		$tp_object = new TimePeriod($tp_array);
		if ($tp_object->is_complete($oreon->user->get_version()) && $tp_object->twiceTest($time_periods))	{
			// log oreon
			system("echo \"[".time()."] AddTimePeriod;".addslashes($tp_array["tp_name"]).";".addslashes($oreon->user->get_alias())."\" >>./include/log/".date("Ymd").".txt");
			$oreon->saveTimePeriod($tp_object);
			$tp_id = $oreon->database->database->get_last_id();
			$time_periods[$tp_id] = $tp_object;
			$time_periods[$tp_id]->set_id($tp_id);
			$time_periods[$tp_id]->set_sunday($time_periods[$tp_cpy]->get_sunday());
			$time_periods[$tp_id]->set_monday($time_periods[$tp_cpy]->get_monday());
			$time_periods[$tp_id]->set_tuesday($time_periods[$tp_cpy]->get_tuesday());
			$time_periods[$tp_id]->set_wednesday($time_periods[$tp_cpy]->get_wednesday());
			$time_periods[$tp_id]->set_thursday($time_periods[$tp_cpy]->get_thursday());
			$time_periods[$tp_id]->set_friday($time_periods[$tp_cpy]->get_friday());
			$time_periods[$tp_id]->set_saturday($time_periods[$tp_cpy]->get_saturday());
			$oreon->saveTimePeriod($time_periods[$tp_id]);
			$msg = $lang['errCode'][3];
			$_GET["o"] = "w";
			$_GET["tp"] = $tp_id;
		}
		else
			$msg = $lang['errCode'][$tp_object->get_errCode()];
		unset ($tp_object);
	}

	if (isset($_GET["o"]) && !strcmp($_GET["o"], "d"))	{
		system("echo \"[" . time() . "] DeleteTimeperiod;" . addslashes($time_periods[$_GET["tp"]]->get_name()) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
		$oreon->deleteTimePeriod($time_periods[$_GET["tp"]]);
		unset($_GET["o"]);
		unset($_GET["tp"]);
	}

	if (isset($_GET["o"]) && !strcmp($_GET["o"], "l"))	{
		if (isset($_GET["box"]))	{
			$boxx = & $_GET["box"];
			foreach ($boxx as $box)	{
				// log add
				system("echo \"[" . time() . "] DeleteTimePeriod;" . addslashes($time_periods[$box]->get_name()) . ";" . addslashes($oreon->user->get_alias()) . "\" >> ./include/log/" . date("Ymd") . ".txt");
				$oreon->deleteTimePeriod($time_periods[$box]);
			}
		}
		unset($_GET["o"]);
	}

	function write_tp_list(&$time_periods, $lang)	{
		?>
		<table cellpadding="0" cellspacing="0" width="210">
			<tr>
				<td class="tabTableTitleMenu"><? print $lang["m_options"]; ?></td>
			</tr>
			<tr>
				<td class="tabTableMenu">
					<div style="padding: 8px; text-align: center;">
						<img src="img/picto2.gif">
						<a href="phpradmin.php?p=108&o=a" class="text9"><? echo $lang['add']; ?></a>
						<img src="img/picto2_bis.gif">
					</div>
				</td>
			</tr>
		</table>
		<br>
		<table cellpadding="0" cellspacing="0" width="210">
			<tr>
				<td class="tabTableTitleMenu" style="white-space: nowrap"><? print $lang['tp_available']; ?></td>
			</tr>
			<tr>
				<td class="tabTableMenu"> <?
				if (isset($time_periods))
					foreach ($time_periods as $time_period)	{ ?>
					<div style="padding: 2px; white-space: nowrap" align="left">
						<li>
							<a href="phpradmin.php?p=108&tp=<? echo $time_period->get_id(); ?>&o=w" class="text10">
								<? echo $time_period->get_name(); ?>
							</a>
						</li>
					</div>
				<?  unset($time_period); } ?>
				</td>
			</tr>
		</table><?
	}

	function write_tp_list2(&$timePeriods, $lang)	{	?>
		<form action="" name="tpMenu" method="get">
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
		if (isset($timePeriods) && count($timePeriods) != 0)	{
			$cpt = 0;
			foreach ($timePeriods as $timePeriod)	{
				if ($cpt < (VIEW_MAX * $num) && ($cpt >= ((VIEW_MAX * $num) - (VIEW_MAX)))){	?>
				<tr>
					<td class="listSub<? echo $cpt%2; ?>"><input type="checkbox" name="box[<? echo $timePeriod->get_id(); ?>]" value="<? echo $timePeriod->get_id(); ?>"></td>
					<td align="left" class="listSub<? echo $cpt%2; ?>"><? echo $timePeriod->get_name(); ?></td>
					<td align="left" class="listSub<? echo $cpt%2; ?>"><? echo $timePeriod->get_alias(); ?></td>
					<td align="center" class="listSub<? echo $cpt%2; ?>"><? echo $lang['enable']; ?></td>
					<td class="listSub<? echo $cpt%2; ?>">
						&nbsp;&nbsp;
						<a href="phpradmin.php?p=108&tp=<? echo $timePeriod->get_id(); ?>&o=w" class="text11"><img src="img/listView.gif" border="0" alt="<? echo $lang['view']; ?>" title="<? echo $lang['view']; ?>"></a>&nbsp;
						<a href="phpradmin.php?p=108&tp=<? echo $timePeriod->get_id(); ?>&o=c" class="text11"><img src="img/listPen.gif" border="0" alt="<? echo $lang['modify']; ?>" title="<? echo $lang['modify']; ?>"></a>&nbsp;
						<a href="phpradmin.php?p=108&tp=<? echo $timePeriod->get_id(); ?>&o=dup" class="text11"><img src="img/listDup.gif" border="0" alt="<? echo $lang['dup']; ?>" title="<? echo $lang['dup']; ?>"></a>&nbsp;
						<a href="phpradmin.php?p=108&tp=<? echo $timePeriod->get_id(); ?>&o=d&num=<? echo $num; ?>&limit=<? echo VIEW_MAX; ?>" class="text11" onclick="return confirm('<? echo $lang['confirm_removing']; ?>')"><img src="img/listDel.gif" border="0" alt="<? echo $lang['delete']; ?>" title="<? echo $lang['delete']; ?>"></a>&nbsp;&nbsp;
					</td>
				</tr>
			<?	}
				unset($timePeriod);
				$cpt++;
				}
			} ?>
			<tr>
				<td colspan="2" valign="top"><img src="img/arrow_ltr.gif" style="padding-left: 5px;">&nbsp;&nbsp;	<a href="#" class="text10bc" onclick=" if (confirm('<? echo $lang['confirm_removing']; ?>')){document.forms['tpMenu'].submit();}"><? echo $lang['m_delete_selection']; ?></a></td>
				<td></td>
				<td colspan="2" align="right" class="text10">
					<a href="phpradmin.php?p=108&o=a" class="text10bc"><? echo $lang['add']; ?></a>&nbsp;&nbsp;<br><br>
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
					<? $nbrPage = floor(count($timePeriods)/VIEW_MAX); if(count($timePeriods)%VIEW_MAX) $nbrPage++; ?>
					<? echo "<font class='text11b'>".$lang["page"]. ":&nbsp;&nbsp;</font>[&nbsp;&nbsp;";
						for ($i = 1; $i <= $nbrPage; $i++)	{
							if($num == $i)
								echo "<a href='./phpradmin.php?p=108&num=$i&limit=".VIEW_MAX."' class='text10'><b>$i</b></a>&nbsp;&nbsp;";
							else
								echo "<a href='./phpradmin.php?p=108&num=$i&limit=".VIEW_MAX."' class='text10'>$i</a>&nbsp;&nbsp;";
						}
						echo "]";
					?>
				</td>
			</tr>
		</table>
		<input type="hidden" name="p" value="108">
		<input type="hidden" name="o" value="l" id="option">
	</form>
	<? } 

if (!isset($_GET["o"]))	{	?>
	<table align="left">
		<tr>
	  		<td>
				<? write_tp_list2($time_periods, $lang); ?>
	  		</td>
		</tr>
	</table>
<? } else if (isset($_GET["o"]))	{
		if (isset($_GET["tp"]))
			$tp = $_GET["tp"];
?>
	<table align="left">
		<tr>
			<td valign="top" align="left"><? write_tp_list($time_periods, $lang); ?></td>
			<td style="padding-left: 20px;"></td>
			<td valign="top" align='left'>
				<?
				if (isset($msg))
					echo "<div align='center' class='msg' style='padding-bottom: 10px;'>$msg</div>";?>
				<table border='0' align="left" cellpadding="0" cellspacing="0">
					<tr>
						<td class="tabTableTitle"><?  print $lang['tp_title']; if (!strcmp($_GET["o"], "c") || !strcmp($_GET["o"], "w")) {  echo " \"" . $time_periods[$tp]->get_name() . "\"";} ?></td>
					</tr>
					<tr>
						<td class="tabTableForTab">
							<? 	if (!strcmp($_GET["o"], "w") || !strcmp($_GET["o"], "c") || !strcmp($_GET["o"], "a"))
								include("./include/configuration/time_period/time_period_".$_GET["o"].".php"); ?>
						</td>
					</tr>
				</table>
			</td>
			<td style="padding-left: 20px;"></td>
	<?	if (!strcmp($_GET["o"], "w") || !strcmp($_GET["o"], "c")) { ?>
			<td valign="top" align="left">
				<table border='0' cellpadding="0" cellspacing="0">
				<tr>
					<td class="tabTableTitle"><? echo $lang['usage_stats']; ?></td>
				<tr>
					<td style="white-space: nowrap;" class="tabTable">
					<li><a href='./phpradmin.php?p=104' class="text10">Services</a></li>
					<ul>
					<?
						$cp = 0;
						$np = 0;
						if (isset($oreon->services))
							foreach ($oreon->services as $sv)	{
								if ($sv->get_check_period() == $time_periods[$tp]->get_id())
									$cp++;
								if ($sv->get_notification_period() == $time_periods[$tp]->get_id())
									$np++;
								unset($sv);
							}
						echo "<li>$cp Check_periods</li>";
						echo "<li>$np Notification_periods</li><br>";
					?>
					</ul>
					<li><a href='./phpradmin.php?p=102' class="text10">Hosts</a></li>
					<ul>
					<?
						$np = 0;
						if (isset($oreon->hosts))
						foreach ($oreon->hosts as $h){
							if ($h->get_notification_period() == $time_periods[$tp]->get_id())
								$np++;
							unset($h);
						}
						echo "<li>$np Notification_periods</li><br>";
					?>
					</ul>
					<li><a href='./phpradmin.php?p=106' class="text10">Contacts</a></li>
					<ul>
					<?
						$hnp = 0;
						$snp = 0;
						if (isset($oreon->contacts))
						foreach ($oreon->contacts as $cct){
							if ($cct->get_host_notification_period() == $time_periods[$tp]->get_id())
								$hnp++;
							if ($cct->get_service_notification_period() == $time_periods[$tp]->get_id())
								$snp++;
							unset($cct);
						}
						echo "<li>$hnp Hosts_notification_periods</li>";
						echo "<li>$snp Service_notification_periods</li><br>";
					?>
					</ul>
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
