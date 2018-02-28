<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/if (!isset($oreon))
		exit();

if (isset($_POST['loadGz']) && $_FILES["gzFile"]['tmp_name'])	{
	foreach (glob("./nagios_cfg/upload/*.cfg") as $tmp)
		if (!strstr($tmp, "nagios.cfg") || !strstr($tmp, "resource.cfg"))
			unlink($tmp);
	move_uploaded_file($_FILES["gzFile"]["tmp_name"], "./nagios_cfg/upload/" . $_FILES["gzFile"]["name"]);
	$upload = true;
	$type = "cfg";
}	else if (isset($_POST['loadResourcefile']) && $_FILES["resourceFile"]['tmp_name'])	{
	foreach (glob("./nagios_cfg/upload/*.cfg") as $tmp)
		if (strstr($tmp, "resource.cfg"))
			unlink($tmp);
	move_uploaded_file($_FILES["resourceFile"]["tmp_name"], "./nagios_cfg/upload/" . $_FILES["resourceFile"]["name"]);
	$upload = true;
	$type = "res";
}	else if (isset($_POST['loadNagiosfile']) && $_FILES["nagiosFile"]['tmp_name'])	{
	foreach (glob("./nagios_cfg/upload/*.cfg") as $tmp)
		if (strstr($tmp, "nagios.cfg"))
			unlink($tmp);
	move_uploaded_file($_FILES["nagiosFile"]["tmp_name"], "./nagios_cfg/upload/" . $_FILES["nagiosFile"]["name"]);
	$upload = true;
	$type = "nag";
}	else
	$upload = false;
	
?>
	<table align="left" border="0">
		<tr>
			<td align="left">
			<?	if (isset($msg))
					echo "<div style='padding-bottom: 10px;' class='msg' align='center'>$msg</div>"; ?>
				<form action="" method="post" enctype="multipart/form-data">
					<table cellpadding="0" cellspacing="0">
						<tr>
							<td colspan="2" class="tabTableTitle"><? echo $lang['nfc_enum']; ?></td>
						</tr>
						<tr>
							<td style="padding-top: 20px;" class='TabTable'>
								<? echo $lang['nfc_limit']; ?>
							</td>
						</tr>
						<tr>
							<td style="padding-top: 10px;" class='TabTable'>
								<? echo $lang['nfc_generated_by_oreon']; ?>
								<input type="radio" name="FO" value="1" checked><? echo $lang['yes']; ?>
								<input type="radio" name="FO" value="0"><? echo $lang['no']; ?>
							</td>
						</tr>
						<tr>
							<td class='TabTable' style="padding-top: 10px;">
								<? echo $lang['nfc_targz']; ?>&nbsp;&nbsp;<input type="file" name="gzFile">
							</td>
						</tr>
						<tr>
							<td align="center" style="padding-top: 15px;padding-bottom: 10px;" class='TabTable'><input type="submit" name="loadGz" value="Upload"></td>
						</tr>
						<tr>
							<td bgcolor="#CCCCCC"></td>
						</tr>
					</table>						
				</form>
			</td>
		</tr>
		<tr>
			<td align="left" style="padding-top: 15px;">
				<form action="" method="post" enctype="multipart/form-data">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td class="tabTableTitle"><? echo $lang['nfc_ncfg']; ?></td>
						</tr>
						<tr>
							<td class='TabTable'>
								<div style="padding-top:15px;padding-left:25px;padding-right:25px;">
								<? echo $lang['nfc_ncfgFile']; ?>
								<input type="file" name="nagiosFile">
								</div>
							</td>
						<tr>
							<td align="center" style="padding-top: 15px;padding-bottom: 5px;" class='TabTable'><input type="submit" name="loadNagiosfile" value="Upload"></td>
						</tr>
						<tr>
							<td bgcolor="#CCCCCC"></td>
						</tr>
					</table>						
				</form>		
			</td>
		</tr>
		<tr>
			<td align="left" style="padding-top: 15px;">
				<form action="" method="post" enctype="multipart/form-data">
					<table align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td class="tabTableTitle"><? echo $lang['nfc_rcfg']; ?></td>
						</tr>
						<tr>
							<td class='TabTable'>
								<div style="padding-top:15px;padding-left:25px;padding-right:25px;">
								<? echo $lang['nfc_rcfgFile']; ?>
								<input type="file" name="resourceFile">
								</div>
							</td>
						<tr>
							<td align="center" style="padding-top: 15px;padding-bottom: 5px;" class='TabTable'><input type="submit" name="loadResourcefile" value="Upload"></td>
						</tr>
						<tr>
							<td bgcolor="#CCCCCC"></td>
						</tr>
					</table>						
				</form>		
			</td>
		</tr>
		<? if ($upload)	{ ?>
		<tr>
			<td align="left" style="padding-top: 15px;" class='tabTableTitle'>
				<div align="center">
					<b>* <? echo $lang['nfc_fileUploaded']; ?></b><br><br>
					<?	
					if (!strcmp($type, "cfg"))	{
						if ($stdout = shell_exec("tar -xvzf ./nagios_cfg/upload/".$_FILES["gzFile"]["name"]." -C ./nagios_cfg/upload/" ))    {
							$stdout = preg_split ("/[\n]+/", $stdout);
							$unpack = true;
							echo "<b>* ".$lang['nfc_extractComplete']."</b> :<br>";
							foreach ($stdout as $out)
								echo $out."<br>";
						}	else	{
							$unpack = false;
							echo "* ".$lang['nfc_unzipUncomplete']."<br>";
						}
						if ($unpack)	{
							$ccf = new cfgConfigFiles();
							$ccf->unsetOreon($oreon);
							$ccf->dropEverything($oreon->database->database);
							$ccf->getConf();
							$ccf->saveCheckCommand($oreon);
							$ccf->saveMiscCommand($oreon);
							$ccf->saveTimePeriod($oreon);
							$ccf->saveContact($oreon);
							$ccf->saveContactGroup($oreon);
							$ccf->saveHost($oreon);
							$ccf->saveHostGroup($oreon);
							$ccf->saveHostEscalation($oreon);
							$ccf->saveHostGroupEscalation($oreon);
							$ccf->saveHostDependencies($oreon);
							$ccf->saveService($oreon, $_POST['FO']);
							$ccf->saveServiceGroup($oreon);
							$ccf->saveServiceEscalation($oreon);
							$ccf->saveServiceDependencies($oreon);
							$ccf->saveHostExtendedInfos($oreon);
							$ccf->saveServiceExtendedInfos($oreon);
							echo "<b>* ".$lang['nfc_uploadComplete']."</b><br><br>";
						}
						unlink("./nagios_cfg/upload/".$_FILES["gzFile"]["name"]);
					}	else if (!strcmp($type, "res"))	{
						echo $_FILES["resourceFile"]["name"]."<br>";
						$res = new ResourceFile($_FILES["resourceFile"]["name"]);
						$res->unsetOreon($oreon);
						$res->dropEverything($oreon->database->database);
						$res->getResource($oreon);
						//unlink("./nagios_cfg/".$_FILES["resourceFile"]["name"]);
					}	else if (!strcmp($type, "nag"))	{
						echo $_FILES["nagiosFile"]["name"]."<br>";
						$nag = new NagiosFile($_FILES["nagiosFile"]["name"]);
						$nag->unsetOreon($oreon);
						$nag->dropEverything($oreon->database->database);
						$nag->getNagios($oreon);	
						//unlink("./nagios_cfg/".$_FILES["nagiosFile"]["name"]);
					}
				?>
				</div>
			</td>
		</tr>
		<? } ?>
	</table>