<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/if (!isset($oreon))
		exit();
		
	if (!isset($oreon->user))
		$oreon->loadUser();
		
	if (isset($_POST["ChangePasswd"]))	{
		$user = & $_POST["user"];
		$user_id = $user["user_id"];
		if (strcmp($user["user_passwd"], "") && !strcmp($user["user_passwd"], $user["user_passwd1"]))	{
			$oreon->user->set_passwd($user["user_passwd"]);
			$oreon->saveUserPasswd($oreon->user);
			$msg = $lang['errCode'][4];
			unset($_GET["o"]);
		}
		else 
			$msg = $lang['errCode'][-7];
	} else if (isset($_POST["ChangeUser"]))	{
		$user = & $_POST["user"];
		$user["user_status"] = $oreon->user->get_status();
		$user["user_version"] = $oreon->user->get_version();
		$user_object = new User($user);
		if ($user_object->is_complete() && $user_object->twiceTest($oreon->users))	{
			$oreon->user = $user_object;
			$oreon->saveUser($oreon->user);
			$oreon->users[$oreon->user->get_id()] = $oreon->user;
			$msg = $lang['errCode'][2];
			unset($_GET["o"]);
			include_once ("./lang/" . $oreon->user->get_lang() . ".php");		
		}	else
				$msg = $lang['errCode'][$user_object->get_errCode()];
		unset($user_object);
	}
	
	function write_user_list($oreon, $lang)	{
		include("tab3Top.php"); ?>
		<table border="0" cellpadding="2" cellspacing="2">
		<tr>
			<td class="text11b" align="center"><? echo $lang['u_list']; ?></td>
		</tr>
		<?
		foreach($oreon->users as $usr)	{
			if (strcmp($usr->get_id(), $oreon->user->get_id()))
				print "<tr><td align='center'><a href='phpradmin.php?p=202&usr=" . $usr->get_id() . "&o=w' class='text10'>" . $usr->get_firstname() . " " . $usr->get_lastname() . "</a></td></tr>";
			unset($usr);
		}
		?>
		</table>
		<? include("tab3Bot.php"); 
	}
?>
	<table border="0" cellpadding="0" cellspacing="0" align="left">
		<tr>
			<td align="left">
				<? if (isset($msg))
					echo "<div class='msg' align='center' style='padding-bottom: 10px;'>" . $msg . "</div>";
				?>	
				<form action="" method="post">
				<table border="0" align="center" cellpadding="0" cellspacing="0" width="300">
					<tr>
						<td class="tabTableTitle"><? echo $lang['u_profile']; ?></td>
					</tr>
					<tr>
						<td class="tabTableForTab">
							<table border="0" align="center">
							<tr>
								<td colspan="2" height="10">&nbsp;<input name="user[user_id]" type="hidden" value="<? echo $oreon->user->get_id(); ?>" size="30"></td>
							</tr>
							<tr>
								<td style="white-space: nowrap;"><? echo $lang['u_name']; ?> <font color='red'>*</font></td>
								<td> <input name="user[user_lastname]" type="text" value='<? echo $oreon->user->get_lastname();?>' size="20"></td>
							</tr>
							<tr>
								<td style="white-space: nowrap;"><? echo $lang['u_lastname']; ?> <font color='red'>*</font></td>
								<td><input name="user[user_firstname]" type="text" value='<? echo $oreon->user->get_firstname();?>' size="20"></td>
							</tr>
							<tr>
								<td style="white-space: nowrap;"><? echo $lang['u_login']; ?> <font color='red'>*</font></td>
								<td><input name="user[user_alias]" type="text" value='<? echo $oreon->user->get_alias();?>' size="15"></td>
							</tr>
							<tr>
								<td style="white-space: nowrap;"><? echo $lang['u_email']; ?> <font color='red'>*</font></td>
								<td><input name="user[user_mail]" type="text" value='<? echo $oreon->user->get_email();?>' size="30"></td>
							</tr>
							<tr>
								<td style="white-space: nowrap;"><? echo $lang['u_lang']; ?><font color='red'>*</font></td>
								<td>
								<select name="user[user_lang]">
								<?
								print "<option>" . $oreon->user->get_lang() . "</option>";
								$chemintotal = "./lang/";
								if ($handle  = opendir($chemintotal))	{
									while ($file = readdir($handle))
										if	(!is_dir("$chemintotal/$file") && strcmp($file, "index.php")) {
											$tab = split('\.', $file);
											if (strcmp($oreon->user->get_lang(), $tab[0]))
												print "<option>" . $tab[0] . "</option>";
										}
									closedir($handle);
								}
								?>
								</select>
								</td>
							</tr>
							<tr>
								<td colspan="2" align="center" style="padding-top: 20px;"><input name="ChangeUser" value="<? echo $lang['save']; ?>" type="submit"></td>
							</tr>
						</table>
						</td>
					</tr>
				</table>
				</form>
			</td>
			<td  style="padding-left: 20px;"></td>
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
								<td style="white-space: nowrap;"><? echo $lang['u_passwd']; ?><font color='red'>*</font></td>
								<td><input name="user[user_id]" type="hidden" value='<? print $oreon->user->get_id(); ?>'><input name="user[user_passwd]" type="password" value='' size="12"></td>
							</tr>
							<tr>
								<td style="white-space: nowrap;"><? echo $lang['u_ppasswd'] ; ?><font color='red'>*</font></td>
								<td><input name="user[user_passwd1]" type="password" value='' size="12"></td>
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