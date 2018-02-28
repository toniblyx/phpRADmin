<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/if (!isset($oreon))
		exit();
	
	if (!isset($oreon->users))
		$oreon->loadUsers();	
	
	if (isset($_POST["deleteProfil"]))	{
		$user = & $_POST["user"];
		$oreon->deleteUsers($oreon->users[$user['user_id']]);
		unset($_GET["o"]);
		unset($user);
	} else if (isset($_POST["ChangePasswd"]))	{
		$user = & $_POST["user"];
		$user_id = $user["user_id"];
		if (strcmp($user["user_passwd"], "") && !strcmp($user["user_passwd"], $user["user_passwd1"])){
			$oreon->users[$user_id]->set_passwd($user["user_passwd"]);
			$oreon->saveUserPasswd($oreon->users[$user_id]);
			$msg = $lang['errCode'][4];
			$_GET["o"] = "w";
			$_GET["usr"] = $user_id;
		}
		else 
			$msg = $lang['errCode'][-7];
	} else if (isset($_POST["ChangeUsers"]))	{
		$user = & $_POST["user"];
		$user["user_version"] = $oreon->user->get_version();
		$id = $user["user_id"];
		$user_object = new User($user);
		if ($user_object->is_complete() && $user_object->twiceTest($oreon->users))	{
			$oreon->users[$id] = $user_object;
			$oreon->users[$id]->set_passwd($oreon->users[$id]->get_passwd());
			$oreon->saveUser($oreon->users[$id]);
			$msg = $lang['errCode'][2];
			$_GET["o"] = "w";
			$_GET["usr"] = $id;
		}	else
				$msg = $lang['errCode'][$user_object->get_errCode()];
		unset($user_object);
	} else if (isset($_POST["AddUser"]))	{
		$user = & $_POST["user"];
		$user["user_version"] = $oreon->user->get_version();
		$user["user_id"] = -1;
		$user_object = new User($user);
		$user_object->set_passwd($user["user_passwd"]);
		$user_object->set_ppasswd($user["user_ppasswd"]);		
		if ($user_object->is_complete() && $user_object->twiceTest($oreon->users))	{
			$oreon->saveUser($user_object);
			$user_id = $oreon->database->database->get_last_id();
			$oreon->users[$user_id] = $user_object;
			$oreon->users[$user_id]->set_id($user_id);
			$oreon->saveUser($oreon->users[$user_id]);
			$msg = $lang['errCode'][3];
			$_GET["o"] = "w";
			$_GET["usr"] = $user_id;
		}	else
				$msg = $lang['errCode'][$user_object->get_errCode()];
		unset($user_object);
	}
	
	function write_user_list($oreon, $lang)	{
		include("tab3Top.php"); ?>
		<table border="0" cellpadding="2" cellspacing="2">
		<tr>
			<td class="text11b" align="center" nowrap><? echo $lang['u_list']; ?></td>
		</tr>
		<?
		foreach($oreon->users as $usr){
			if (strcmp($usr->get_id(), $oreon->user->get_id()) && !strcmp($usr->get_status(), "1"))
				print "<tr><td align='center' nowrap><a href='phpradmin.php?p=4102&usr=" . $usr->get_id() . "&o=w' class='text10'>" . $usr->get_firstname() . " " . $usr->get_lastname() . "</a></td></tr>";
		}
		?>
		</table>
		<? include("tab3Bot.php"); 
	}	
	
	function write_admin_list($oreon, $lang)	{
		include("tab3Top.php"); ?>
		<table border="0" cellpadding="2" cellspacing="2">
		<tr>
			<td class="text11b" align="center" nowrap><? echo $lang['u_admin_list']; ?></td>
		</tr>
		<?
		foreach($oreon->users as $usr){
			if (strcmp($usr->get_id(), $oreon->user->get_id()) && !strcmp($usr->get_status(), "2"))
				print "<tr><td align='center' nowrap><a href='phpradmin.php?p=4102&usr=" . $usr->get_id() . "&o=w' class='text10'>" . $usr->get_firstname() . " " . $usr->get_lastname() . "</a></td></tr>";
		}
		?>
		</table>
		<? include("tab3Bot.php"); 
	}	
	
	function write_sadmin_list($oreon, $lang)	{
		include("tab3Top.php"); ?>
		<table border="0" cellpadding="2" cellspacing="2">
		<tr>
			<td class="text11b" align="center" nowrap><? echo $lang['u_sadmin_list']; ?></td>
		</tr>
		<?
		foreach($oreon->users as $usr){
			if (strcmp($usr->get_id(), $oreon->user->get_id()) && !strcmp($usr->get_status(), "3"))
				print "<tr><td align='center' nowrap><a href='phpradmin.php?p=4102&usr=" . $usr->get_id() . "&o=w' class='text10'>" . $usr->get_firstname() . " " . $usr->get_lastname() . "</a></td></tr>";
		}
		?>
		</table>
		<? include("tab3Bot.php"); 
	}

if (!isset($_GET["o"]))	{ ?>
	<table border="0" cellpadding="0" cellspacing="0" width="400" style="border-top: 1px solid #CCCCCC;border-left: 1px solid #CCCCCC;border-bottom: 1px solid #CCCCCC;border-right: 1px solid #CCCCCC">
		<tr>
			<td class="dataTableTitleLeft"><? echo $lang['u_name']; ?></td>
			<td class="dataTableTitle"><? echo $lang['u_lastname']; ?></td>
			<td class="dataTableTitle"><? echo $lang['u_login']; ?></td>
			<td class="dataTableTitle"><? echo $lang['u_status']; ?></td>
			<td class="dataTableTitle"><? echo $lang['mon_actions']; ?></td>
		</tr>
		<?
		
		$tab[1] = $lang['u_user'];
		$tab[2] = $lang['u_administrator'];
		$tab[3] = $lang['u_sadministrator'];
		
		for ($i = 1; $i != 4; $i++)
			foreach($oreon->users as $usr){
				if (strcmp($usr->get_id(), $oreon->user->get_id()) && !strcmp($i, $usr->get_status())){
					print "<tr><td>".$oreon->users[$usr->get_id()]->get_lastname()."</td>";
					print "    <td>".$oreon->users[$usr->get_id()]->get_firstname()."</td>";
					print "    <td>".$oreon->users[$usr->get_id()]->get_alias()."</td>";
					print "    <td>".$tab[$oreon->users[$usr->get_id()]->get_status()]."</td>";
					print "	   <td align='center' nowrap><a href='phpradmin.php?p=4102&usr=" . $usr->get_id() . "&o=w' class='text10'><img src='./img/listPen.gif' border='0'></a></td></tr>";
				}
			}
		?>
	</table>
<? } else if (isset($_GET["o"]) && !strcmp($_GET["o"], "a"))	{ ?>
	<table border="0" cellpadding="0" cellspacing="0" align="left">
		<tr>
			<td align="left">
				<form action="" method="post">
				<? if (isset($msg))
						echo "<div class='msg' align='center' style='padding-bottom: 10px;'>" . $msg . "</div>"; ?>
				<font class="text11b">
				<table border="0" align="center" cellpadding="0" cellspacing="0" width="300">
					<tr>
						<td class="tabTableTitle"><? echo $lang['u_new_profile']; ?></td>
					</tr>
					<tr>
						<td class="tabTableForTab">
							<table border="0" align="center" cellpadding='1'>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['u_name']; ?><font color='red'>*</font></td>
									<td> <input name="user[user_lastname]" type="text" value='' size="30"></td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['u_lastname']; ?><font color='red'>*</font></td>
									<td><input name="user[user_firstname]" type="text" value='' size="20"></td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['u_login']; ?><font color='red'>*</font></td>
									<td><input name="user[user_alias]" type="text" value='' size="20"></td>
								</tr>
								<tr>
									<td  style="white-space: nowrap;"><? echo $lang['u_passwd']; ?><font color='red'>*</font></td>
									<td><input name="user[user_passwd]" type="password" value='' size="12"></td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['u_ppasswd']; ?><font color='red'>*</font></td>
									<td><input name="user[user_ppasswd]" type="password" value='' size="12"></td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['u_email']; ?><font color='red'>*</font></td>
									<td><input name="user[user_mail]" type="text" value='' size="30"></td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['u_lang']; ?><font color='red'>*</font></td>
									<td>
									<select name="user[user_lang]">
									<?
									print "<option>" . $oreon->user->get_lang() . "</option>";
									$chemintotal = "./lang/";
									if ($handle  = opendir($chemintotal))	{
										while ($file = readdir($handle))	{
											if(!is_dir("$chemintotal/$file") && strcmp($file, "index.php")) {
												$tab = split('\.', $file);
												if (strcmp($oreon->user->get_lang(), $tab[0]))
													print "<option>" . $tab[0] . "</option>";
											}
										}
										closedir($handle);
									}
									?>
									</select>
									</td>
								</tr>
								<tr>
									<td><? echo $lang['u_status']; ?><font color='red'>*</font></td>
									<td>
										<select name="user[user_status]">
											<option value='1'><? echo $lang['u_user']; ?></option>
											<option value='2'><? echo $lang['u_administrator']; ?></option>
											<option value='3'><? echo $lang['u_sadministrator']; ?></option>
										</select>
									</td>
								</tr>
								<tr>
									<td colspan="2" align="center"><input name="AddUser" value="<? echo $lang['save'] ?>" type="submit"></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				</form>
			</td>
		</tr>
	</table>
<? } else if (isset($_GET["o"]) && !strcmp($_GET["o"], "w")){ 
	$usr = $_GET["usr"];
?>
	<table border="0"  align="left">
		<tr>
			<td align="center" valign="top">
				<form action="" method="post">
				<? if (isset($msg))
					echo "<div class='msg' align='center' style='padding-bottom: 10px;'>" . $msg . "</div>"; ?>
				<table border="0" align="center" cellpadding="0" cellspacing="0" width="300">
					<tr>
						<td class="tabTableTitle"><? echo $lang['u_some_profile']." ";  echo $oreon->users[$usr]->get_lastname();?> <? echo $oreon->users[$usr]->get_firstname();?></td>
					</tr>
					<tr>
						<td class="tabTableForTab">
							<table border="0" align="center">
								<tr>
									<td colspan="2" height="10">&nbsp;<input name="user[user_id]" type="hidden" value="<? echo $oreon->users[$usr]->get_id(); ?>" ></td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['u_name']; ?> <font color='red'>*</font></td>
									<td> <input name="user[user_lastname]" type="text" value='<? echo $oreon->users[$usr]->get_lastname();?>' size="30"></td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['u_lastname']; ?><font color='red'>*</font></td>
									<td><input name="user[user_firstname]" type="text" value='<? echo $oreon->users[$usr]->get_firstname();?>' size="20"></td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['u_login']; ?><font color='red'>*</font></td>
									<td><input name="user[user_alias]" type="text" value='<? echo $oreon->users[$usr]->get_alias();?>' size="20"></td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['u_email']; ?><font color='red'>*</font></td>
									<td><input name="user[user_mail]" type="text" value='<? echo $oreon->users[$usr]->get_email();?>' size="30"></td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['u_lang']; ?><font color='red'>*</font></td>
									<td>
									<select name="user[user_lang]">
									<?
									print "<option>" . $oreon->users[$usr]->get_lang() . "</option>";
									$chemintotal = "./lang/";
									if ($handle  = @opendir($chemintotal))	{
										while ($file = @readdir($handle))						{
											if(!is_dir("$chemintotal/$file") && strcmp($file, "index.php") && strcmp($file, "exemple.php") && strcmp($file, "lang_fr.php")) {
												$tab = split('\.', $file);
												if (strcmp($oreon->users[$usr]->get_lang(), $tab[0]))
													print "<option>" . $tab[0] . "</option>";
											}
										}
										@closedir($chemintotal);
									}
									?>
									</select>
									</td>
								</tr>
								<tr>
									<td style="white-space: nowrap;"><? echo $lang['u_status']; ?><font color='red'>*</font></td>
									<td>
										<select name="user[user_status]">
											<option value='1'<?  if ($oreon->users[$usr]->get_status() == 1) echo " selected"; ?>><? echo $lang['u_user']; ?></option>
											<option value='2'<?  if ($oreon->users[$usr]->get_status() == 2) echo " selected"; ?>><? echo $lang['u_administrator']; ?></option>
											<option value='3'<?  if ($oreon->users[$usr]->get_status() == 3) echo " selected"; ?>><? echo $lang['u_sadministrator']; ?></option>
										</select>
									</td>
								</tr>
								<tr>
									<td colspan="2" align="center" style="padding-top: 20px;">
										<input name="ChangeUsers" value="<? echo $lang['save']; ?>" type="submit">
										<input type="submit" name="deleteProfil" value="<? print $lang['u_delete_profile']; ?>" onclick="return confirm('<? echo $lang['confirm_removing']; ?>')">
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				</form>
			</td>
			<td style="padding-left: 20px;"></td>
			<td valign="top" align="center">
				<form action="" method="post">
					<table border="0" align="center" cellpadding="0" cellspacing="0" width="250">
						<tr>
							<td class="tabTableTitle"><? echo $lang['u_cpasswd']; ?></td>
						</tr>
						<tr>
							<td class="tabTableForTab">
								<table border="0" align="center">
									<tr>
										<td style="white-space: nowrap;"><? echo $lang['u_passwd']; ?></td>
										<td><input name="user[user_id]" type="hidden" value='<? print $oreon->users[$usr]->get_id(); ?>'><input name="user[user_passwd]" type="password" value=''></td>
									</tr>
									<tr>
										<td style="white-space: nowrap;"><? echo $lang['u_ppasswd'] ; ?></td>
										<td><input name="user[user_passwd1]" type="password" value=''></td>
									</tr>
									<tr>
										<td style="white-space: nowrap; padding-top: 20px;" colspan="2" align="center"><input name="ChangePasswd" type="submit" value="<? echo $lang['save']; ?>"></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</form>
			</td>
		</tr>
	</table>
<? } ?>	