<?
/*
phpRADmin is developped under GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt or read LICENSE file.

Developed by : Toni de la Fuente (blyx) from Madrid and Alfacar (Granada), Spain  
For information : toni@blyx.com http://blyx.com

We are using Oreon for base code: http://www.oreon-project.org
We are using Dialup Admin for user management 
and many more things: http://www.freeradius.org
We are using PHPKI for Certificates management: http://phpki.sourceforge.org/ 

Thanks very much!!
*/
	// configuration
include_once ("../class/Session.class.php");

Session::start();

$DEBUG = 0;
			
function Connexion ($pName, $pPassword, $pServer)	{
	$connexion = @mysql_pconnect($pServer, $pName, $pPassword) or die("<center><span class='stop'>Error : ".mysql_error() . "</span></center><br><br>");
	return $connexion;
}

function aff_header($str, $str2, $nb){
?>
<html>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <meta http-equiv="Content-Style-Type" content="text/css">
   <title><? print $str; ?></title>
   <link rel="shortcut icon" href="../img/favicon.ico">
   <link rel="stylesheet" href="./install.css" type="text/css">
   <SCRIPT language='javascript' src='../include/javascript/functions.js'></SCRIPT>
   <SCRIPT language='javascript'>
	function LicenceAccepted(){
		var theForm     = document.forms[0];
		var nextButton  = document.getElementById("button_next");
	
		if( theForm.setup_license_accept.checked ){
			nextButton.disabled = '';
			nextButton.focus();
		}
		else {
			nextButton.disabled = "disabled";
		}
	}
	</SCRIPT>
</head>
<body rightmargin="O" topmargin="0" leftmargin="0">
<table cellspacing="0" cellpadding="0" border="0" align="center" class="shell">
<tr>
  <th width="400"><? print $nb . ". " . $str2; ?></th>
  <th width="100" height="30" style="text-align: right;"><img src="../img/logo-name.jpg"></th>
</tr>
<tr>
  <td colspan="2" width="600" style="background-position : right; background-color: #DDDDDD; background-repeat : no-repeat;">
	<form action="setup.php" method="post" name="theForm" id="theForm">
	<input type="hidden" name="step" value="<? print $nb; ?>">
<?
}

function aff_middle(){
?>

<tr>
  <td align="right" colspan="2" height="20">
	<hr>
	<table cellspacing="0" cellpadding="0" border="0" class="stdTable">
	  <tr>
		<td>
<?
}

function aff_footer(){
?>				</td>
			  </tr>
		</table>
		</form>
	  </td>
	</tr>
  </table>
</body>
</html>
<?
}

	if (isset($_POST["Recheck"]))
		 $_POST["step"] = 3;
	if (isset($_POST["goto"]) && !strcmp($_POST["goto"], "Back"))
		 $_POST["step"] -= 2;
	if (isset($_POST["step"]) && isset($_POST["pwdPraDB"])&& $_POST["step"] == 5 && strcmp($_POST["pwdPraDB"], $_POST["pwdPraDB2"])){
		$_POST["step"] = 4;
		$passwd_error = "Password not confimed correctly.";
	}
	if (isset($_POST["step"]) && $_POST["step"] == 6 && strcmp($_POST["phpradminpassword"], $_POST["phpradminpassword2"])){
		$_POST["step"] = 5;
		$passwd_error = "Password not confimed correctly.";
	}
	if (!isset($_POST["step"])){
		aff_header("phpRADmin Setup Wizard", "Welcome to phpRADmin Setup", 1);
		$str = "<p>This installer creates the phpRADmin database tables and sets the
        configuration variables that you need to start. The entire process
        should take about ten minutes.</p><p>Before start you must be sure your system is <b>phpRADmin Ready!</b>. </p>
	  <p>Please read <b>Howto Install Documents</b> and <b>Depencence List</b> from <a href=\"http://www.phpradmin.net\">phpRADmin project page</a>.</p>
	  	<br><br><br><center><p><b>Arrikitaun!!!</b></p></center>";
		print $str;
		aff_middle();
		$str = "<input class='button' type='submit' name='goto' value='Start' id='defaultFocus' /></td>";
		print $str;
		aff_footer();
	} else if (isset($_POST["step"]) && $_POST["step"] == 1){
		aff_header("phpRADmin Setup Wizard", "Licence", 2);
		$license_file_name = "./LICENSE.txt";
		$fh = fopen( $license_file_name, 'r' ) or die( "License file not found!" );
		$license_file = fread( $fh, filesize( $license_file_name ) );
		fclose( $fh );
		$str = "<textarea cols='80' rows='20' readonly>".$license_file."</textarea>";
		$str .= "</td>
		</tr>
		<tr>
		  <td align=left>
			<input type='checkbox' class='checkbox' name='setup_license_accept' onClick='LicenceAccepted();' value='0' /><a href='javascript:void(0)' onClick='document.getElementById('button_next').disabled = false;'>I Accept</a>
		  </td>
		  <td align=right>
			&nbsp;
		  </td>
		</tr>";
		print $str;
		aff_middle();
		$str = "<input class='button' type='submit' name='goto' value='Next' id='button_next' disabled='disabled' />";
		print $str;
		aff_footer();
	} else if (isset($_POST["step"]) && $_POST["step"] == 2){
		aff_header("phpRADmin Setup Wizard", "Environment Configuration", 3);
		?>
		In order for your phpRADmin installation to function properly, please complete the following fields.<br><br>
		<table cellpadding="0" cellspacing="0" border="0" width="80%" class="StyleDottedHr" align="center">
          <tr>
            <th style="padding-left:20px " colspan="2">Environment Configurations</th>
          </tr>
		  <tr>
            <td style="padding-left:50px ">phpRADmin install directory</td>
			<td><input name="phpradmin_pwd" type="text" value="/usr/local/phpradmin"></td>
		  </tr>
		  <tr>
            <td style="padding-left:50px ">FreeRADIUS binary files directory</td>
                        <td><input name="radius_bin" type="text" value="/usr/sbin/" size="40"></td>
                  </tr>
		  <tr>
            <td style="padding-left:50px ">FreeRADIUS config files directory</td>
			<td><input name="radius_conf" type="text" value="/etc/raddb/" size="40"></td>
		  </tr>
		  <tr>
            <td style="padding-left:50px ">FreeRADIUS Dictionary directory</td>
			<td><input name="radius_dictionary" type="text" value="/usr/share/freeradius/" size="40"></td>
		  </tr>
		  <tr>
            <td style="padding-left:50px ">FreeRADIUS start/stop/restart/status script</td>
                        <td><input name="radius_startscript" type="text" value="/etc/init.d/radiusd" size="40"></td>
                  </tr>
		  <tr>
            <td style="padding-left:50px ">RRDTOOL binary path</td>
                        <td><input name="rrdtool_bin" type="text" value="/usr/bin/rrdtool" size="40"></td>
                  </tr>
		  <tr>
            <td style="padding-left:50px ">Sudo binary path</td>
                        <td><input name="sudo_bin" type="text" value="/usr/bin/sudo" size="40"></td>
                  </tr>
		  <tr>
            <td style="padding-left:50px ">System log file path</td>
			<td><input name="system_log" type="text" value="/var/log/messages" size="60"></td>
		  </tr>
		  <tr>
            <td style="padding-left:50px ">FreeRADIUS radius.log file path</td>
                        <td><input name="radius_log" type="text" value="/var/log/radius/radius.log" size="60"></td>
                  </tr>
		  <tr>
            <td style="padding-left:50px ">Radclient command</td>
                        <td><input name="radclient" type="text" value="/usr/bin/radclient" size="60"></td>
                  </tr>
		  <tr>
            <td style="padding-left:50px ">MySQL client command</td>
                        <td><input name="mysqlclient" type="text" value="/usr/bin/mysql" size="60"></td>
                  </tr>
		  <tr>
            <td style="padding-left:50px ">snmpwalk command</td>
                        <td><input name="snmpwalk" type="text" value="/usr/bin/snmpwalk" size="60"></td>
                  </tr>
		  <tr>
            <td style="padding-left:50px ">snmpget command</td>
                        <td><input name="snmpget" type="text" value="/usr/bin/snmpget" size="60"></td>
                  </tr>
		</table>
		<?
		aff_middle();
		$str = "<input class='button' type='submit' name='goto' value='Back' /><input class='button' type='submit' name='goto' value='Next' id='button_next' />";
		print $str;
		aff_footer();
	} else if (isset($_POST["step"]) && $_POST["step"] == 3){
		if (isset($_POST["goto"]) && strcmp($_POST["goto"], "Back")){
			$_SESSION["phpradmin_pwd"] = $_POST["phpradmin_pwd"];
			$_SESSION["radius_bin"] = $_POST["radius_bin"];
			$_SESSION["radius_conf"] = $_POST["radius_conf"];
			$_SESSION["radius_dictionary"] = $_POST["radius_dictionary"];
			$_SESSION["radius_startscript"] = $_POST["radius_startscript"];
			$_SESSION["rrdtool_bin"] = $_POST["rrdtool_bin"];
			$_SESSION["sudo_bin"] = $_POST["sudo_bin"];
			$_SESSION["system_log"] = $_POST["system_log"];
			$_SESSION["radius_log"] = $_POST["radius_log"];
			$_SESSION["radclient"] = $_POST["radclient"];
			$_SESSION["mysqlclient"] = $_POST["mysqlclient"];
			$_SESSION["snmpwalk"] = $_POST["snmpwalk"];
			$_SESSION["snmpget"] = $_POST["snmpget"];
		}
		aff_header("phpRADmin Setup Wizard", "Verifying Configuration", 4);
		?>
		<table cellpadding="0" cellspacing="0" border="0" width="100%" class="StyleDottedHr">
          <tr>
            <th align="left">Component</th>

            <th style="text-align: right;">Status</th>
          </tr>
          <tr>
            <td><b>PHP Version 4.X.X (5.X not supported)</b></td>
            <td align="right">
			<?
			// Only support for php 4.X (no support for 5.X by now... jur jur)
				$return_false = 0;
				$php_version = phpversion();
               if(str_replace(".", "", $php_version) < "500" && str_replace(".", "", $php_version) > "611"){
              // if(str_replace(".", "", $php_version) >= "500"){
                 echo "<b><span class=stop>Invalid version ($php_version) Installed</span></b>";
				  $return_false = 1;
               } else {
                  echo "<b><span class=go>OK (ver $php_version)</span></b>";
               }
            ?></td>
          </tr>
		  	<?
		/*		
		print $_SESSION['setup_db_type'];
            	if (isset($_SESSION['setup_db_type']) && !strcmp($_SESSION['setup_db_type'], "mysql")){
                    $db_name        = "MySQL Database (Not obligatory : may be external database)";
                    $function_name  = "mysql_connect";
                }
		*/
			?>
	  <!--
          <tr>
            <td><strong><?php //echo "$db_name"; ?></strong></td>

            <td align="right"><?php /*
               if( function_exists( $function_name ) ){
                  echo '<b><span class=go>OK</font></b>';
               } else {
                  echo '<b><span class=stop>Not Available</font></b>';
               } */
            ?></td>
          </tr>
	  -->
		  <tr>
            <td><b>Writable phpRADmin Configuration File (phpradmin.conf.php)</b></td>
            <td align="right"><?
				if(is_writable('..')){
                  	echo '<b><span class="go">OK</font></b>';
			} else {
                 	echo '<b><span class="stop">Warning: Not Writeable by webserver user</font></b>';
					echo '<br><b>NOTE:</b> chmod 777 phpradmin_dir/www </b>';
				    $return_false = 1;
               }
            ?></td>
          </tr>
	  <tr>
            <td><b>Writable phpRADmin Logs Directory</b></td>
            <td align="right"><?
                      		if(is_writable('../include/log')){
                      		echo '<b><span class="go">OK</font></b>';
                              	} else {
                        	echo '<b><span class="stop">Warning: Not Writeable by webserver user</font></b>';
                        	echo '<br><b>NOTE:</b> chown apache:apache phpradmin_dir/www/include/log <b>' .$_ENV["USERNAME"]; '</b>';
                                $return_false = 1;
               }
            ?></td>
          </tr>
			  <?php
				$memory_msg     = "";
				$memory_limit   = ini_get('memory_limit');
			
				// logic based on: http://us2.php.net/manual/en/ini.core.php#ini.memory-limit
			
				if( $memory_limit == "" ){          // memory_limit disabled at compile time, no memory limit
					$memory_msg = "<b><span class=\"go\">OK (No Limit)</span></b>";
				}
				else if( $memory_limit == "-1" ){   // memory_limit enabled, but set to unlimited
					$memory_msg = "<b><span class=\"go\">OK (Unlimited)</span></b>";
				}
				else{
					rtrim($memory_limit, 'M');
					$memory_limit_int = (int) $memory_limit;
					if( $memory_limit_int < 16 ){
						$memory_msg = "<b><span class=\"stop\">Warning: $memory_limit (Set this to 16M or larger in your php.ini file)</span></b>";
					}
					else {
						$memory_msg = "<b><span class=\"go\">OK ($memory_limit)</span></b>";
					}
				}
			?>
          <tr>
            <td><b>PHP Memory Limit >= 16 MB</b></td>
            <td align="right"><?php print( $memory_msg ); ?></td>
          </tr>
          <tr>
            <td><b>Check for your Operating System</b></td>
            <td align="right"><?
				if(strncmp($_ENV["OS"], "Windows", 6)){
					echo '<b><span class="go">OK</font></b>';
				} else {
 	                echo '<b><span class="stop">OOOOOHH!!! Bad news... I don\'t like your taste.</font></b>';
 	                echo '<br>Try with a real SO like Linux or *BSD';
				    $return_false = 1;
               }
            ?></td>
          </tr>
        </table>
		<?
		
		aff_middle();
		$str = "<input class='button' type='submit' name='Recheck' value='Recheck' /><input class='button' type='submit' name='goto' value='Back' /><input class='button' type='submit' name='goto' value='Next' id='button_next'";
		if ($return_false)
			$str .= " disabled";
		$str .= " />";
		print $str;
		aff_footer();
	} else if (isset($_POST["step"]) && $_POST["step"] == 4){
		aff_header("phpRADmin Setup Wizard", "DataBase Configuration", 5);
		if (isset($passwd_error) && $passwd_error)
			print "<center><b><span class=\"stop\">$passwd_error</span></b></center><br>";
		?>
		<table cellpadding="0" cellspacing="0" border="0" width="80%" class="StyleDottedHr" align="center">
          <tr>
            <th align="left">Component</th>
            <th style="text-align: right;">Status</th>
          </tr>
		  <tr>
            <td><b>Root password for Mysql</b></td>
            <td align="right"><input type="password" name="pwdroot" value="<? if (isset($_SESSION["pwdroot"])) print $_SESSION["pwdroot"]; ?>"></td>
          </tr> 
		  <tr>
            <td><b>phpRADmin Database Name (phpradmin)</b></td>
            <td align="right"><input type="text" name="namePraDB" value="<? if (isset($_SESSION["namePraDB"])) print $_SESSION["namePraDB"]; ?>"></td>
          </tr> 
		  <tr>
            <td><b>phpRADmin Database Password</b></td>
            <td align="right"><input type="password" name="pwdPraDB" value="<? if (isset($_SESSION["pwdPraDB"])) print $_SESSION["pwdPraDB"]; ?>"></td>
          </tr> 
		  <tr>
            <td><b>Confirm Password</b></td>
            <td align="right"><input type="password" name="pwdPraDB2" value="<? if (isset($_SESSION["pwdPraDB2"])) print $_SESSION["pwdPraDB2"]; ?>"></td>
          </tr> 
		  <tr>
            <td><b>Database location (localhost)</b></td>
            <td align="right"><input type="text" name="dbLocation" value="<? if (isset($_SESSION["dbLocation"])) print $_SESSION["dbLocation"]; ?>"></td>
          </tr> 
		  <tr>
            <td><b>FreeRADIUS location (localhost). *Not applicable by now</b></td>
            <td align="right"><input type="text" name="radiusLocation" value="<? if (isset($_SESSION["radiusLocation"])) print $_SESSION["radiusLocation"]; ?>"></td>
          </tr> 
		  <tr>
            <td><b>FreeRADIUS version. *Not applicable by now</b></td>
            <td align="right">1.X <input type="radio" name="radiusVersion" value="1" checked> - 0.X <input type="radio" name="radiusVersion" value="2" enabled  <? if (isset($_SESSION["radiusVersion"]) && $_SESSION["radiusVersion"] == 2) print "checked"; ?>></td>
          </tr> 
		</table>
		<?
		aff_middle();
		$str = "<input class='button' type='submit' name='goto' value='Back' /><input class='button' type='submit' name='goto' value='Next' id='button_next' />";
		print $str;
		aff_footer();
	} else if (isset($_POST["step"]) && $_POST["step"] == 5){
		if (isset($_POST["goto"]) && strcmp($_POST["goto"], "Back")){
			if (isset($_POST["radiusLocation"]) && strcmp($_POST["radiusLocation"], ""))
				$_SESSION["radiusLocation"] = $_POST["radiusLocation"];
			else
				$_SESSION["radiusLocation"] = "localhost";
			if (isset($_POST["dbLocation"]) && strcmp($_POST["dbLocation"], ""))
				$_SESSION["dbLocation"] = $_POST["dbLocation"];
			else
				$_SESSION["dbLocation"] = "localhost";
			if (isset($_POST["pwdPraDB"])) $_SESSION["pwdPraDB"] = $_POST["pwdPraDB"];
			if (isset($_POST["pwdPraDB2"])) $_SESSION["pwdPraDB2"] = $_POST["pwdPraDB2"];
			if (isset($_POST["pwdroot"])) $_SESSION["pwdroot"] = $_POST["pwdroot"];
			if (isset($_POST["namePraDB"])) $_SESSION["namePraDB"] = $_POST["namePraDB"];
			if (isset($_POST["radiusVersion"])) $_SESSION["radiusVersion"] = $_POST["radiusVersion"];
		}
		aff_header("phpRADmin Setup Wizard", "User Interface Configuration", 6);
		if (isset($passwd_error) && $passwd_error)
			print "<center><b><span class=\"stop\">$passwd_error</span></b></center><br>";
		?>
		<table cellpadding="0" cellspacing="0" border="0" width="80%" class="StyleDottedHr" align="center">
          <tr>
            <th align="left">Component</th>
            <th style="text-align: right;">Status</th>
          </tr>
		  <tr>
            <td><b>Administrator login for phpRADmin</b></td>
            <td align="right"><input type="text" name="pralogin" value="<? if (isset($_SESSION["pralogin"])) print $_SESSION["pralogin"]; ?>"></td>
          </tr>
		  <tr>
            <td><b>Administrator password for phpRADmin</b></td>
            <td align="right"><input type="password" name="phpradminpassword" value="<? if (isset($_SESSION["phpradminpassword"])) print $_SESSION["phpradminpassword"]; ?>"></td>
          </tr> 
		  <tr>
            <td><b>Confirm Password</b></td>
            <td align="right"><input type="password" name="phpradminpassword2" value="<? if (isset($_SESSION["phpradminpassword"])) print $_SESSION["phpradminpassword"]; ?>"></td>
          </tr> 
		  <tr>
            <td><b>Administrator name for phpRADmin</b></td>
            <td align="right"><input type="text" name="prafirstname" value="<? if (isset($_SESSION["prafirstname"])) print $_SESSION["prafirstname"]; ?>"></td>
          </tr>
		  <tr>
            <td><b>Administrator surname for phpRADmin</b></td>
            <td align="right"><input type="text" name="pralastname" value="<? if (isset($_SESSION["pralastname"])) print $_SESSION["pralastname"]; ?>"></td>
          </tr>  
		  <tr>
            <td><b>Administrator email for phpRADmin</b></td>
            <td align="right"><input type="text" name="praemail" value="<? if (isset($_SESSION["praemail"])) print $_SESSION["praemail"]; ?>"></td>
          </tr> 
		  <tr>
            <td><b>Administrator language for phpRADmin. *Only english is supported by now.</b></td>
            <td align="right"><select name="pralang">
					<?
					$chemintotal = "../lang/";
					if ($handle  = opendir($chemintotal))	{
						while ($file = readdir($handle))
							if	(!is_dir("$chemintotal/$file") && strcmp($file, "index.php")) {
								$tab = split('\.', $file);
								print "<option ";
								if (isset($_SESSION["pralang"]) && !strcmp($_SESSION["pralang"], $tab[0]))
									print "selected";
								print ">" . $tab[0] . "</option>";
							}
						closedir($handle);
					}
					?>
					</select>
			</td>
          </tr>  
		</table>
		<?
		aff_middle();
		$str = "<input class='button' type='submit' name='goto' value='Back' /><input class='button' type='submit' name='goto' value='Next' id='button_next' />";
		print $str;
		aff_footer();
	} else if (isset($_POST["step"]) && $_POST["step"] == 6){
		if (isset($_POST["goto"]) && strcmp($_POST["goto"], "Back")){
			$_SESSION["pralogin"] = $_POST["pralogin"];
			$_SESSION["phpradminpassword"] = $_POST["phpradminpassword"];
			$_SESSION["prafirstname"] = $_POST["prafirstname"];
			$_SESSION["pralastname"] = $_POST["pralastname"];
			$_SESSION["praemail"] = $_POST["praemail"];
			$_SESSION["pralang"] = $_POST["pralang"];
		}
		aff_header("phpRADmin Setup Wizard", "Creating Database", 7);
		?>
		<table cellpadding="0" cellspacing="0" border="0" width="80%" class="StyleDottedHr" align="center">
          <tr>
            <th align="left">Component</th>
            <th style="text-align: right;">Status</th>
          </tr>
		 <?
		
			$file[0] = "<?\n";
			$file[1] = "/*\n";
			$file[2] = "phpRADmin is developped with GPL Licence 2.0 :\n";
			$file[3] = "http://www.gnu.org/licenses/gpl.txt or read LICENSE file.\n\n";
			$file[4] = "Developped by : Toni de la Fuente (blyx) from Madrid and Alfacar (Granada), Spain\n";
			$file[5] = "For information : toni@blyx.com http://blyx.com\n\n";
			$file[6] = "We are using Oreon for base code: http://www.oreon-project.org. Dialup Admin for user management and many more things: http://www.freeradius.org. PHPKI for Certificates management: http://phpki.sourceforge.org/\n";
			$file[7] = "*/";	
			$file[8] = "\n";
			$file[9] = "// database\n";
        	$file[10] = "\$conf_pra['host'] = \"". $_SESSION["dbLocation"] ."\";\n";
        	$file[11] = "\$conf_pra['user'] = \"". $_SESSION["namePraDB"] . "\";\n";
        	$file[12] = "\$conf_pra['password'] = \"". $_SESSION["pwdPraDB"] . "\";\n";
        	$file[13] = "\$conf_pra['db'] = \"". $_SESSION["namePraDB"] . "\";\n";
        	$file[14] = "\$conf_pra['dbtype'] = \"mysql\";\n";
        	$file[15] = "\$conf_pra['sqlport'] = \"3306\";\n";
			$file[16] = "\n";
			$file[17] = "// path to classes\n";
       		$file[18] = "\$classdir='./class'; \n";
       		$file[19] = "?>";
       		 
			if ($fd = fopen("../phpradmin.conf.php", "w+"))	{
				for ($i = 0; $i <= 20; $i++)
					fwrite ($fd, $file[$i]);
				fclose ($fd);
			} else {
				die ("<center><span class='stop'>Can't open configuration file !</span></center><br><br>");
			}
			?>
			<tr>
				<td><b>Configuration file </b></td>
				<td align="right">done</td>
			</tr>
			<?
			if (!$_SESSION["pwdroot"])
				$res = connexion('root', '', $_SESSION["dbLocation"]) or die ("Can't connect to Mysql Server : ".mysql_error());
			else
				$res = connexion('root', $_SESSION["pwdroot"], $_SESSION["dbLocation"]) or die ("Can't connect to Mysql Server : ".mysql_error()); //$_SESSION["pwdroot"]
			$requete = "CREATE DATABASE ". $_SESSION["namePraDB"] . ";";
			if ($DEBUG) print $requete . "<br>";
			mysql_query($requete, $res);
			?>
			<tr>
				<td><b>Database Creation </b></td>
				<td align="right">done</td>
			</tr>
			<?
			$requete = "GRANT ALL PRIVILEGES ON `". $_SESSION["namePraDB"] . "` . * TO `". $_SESSION["namePraDB"] . "`@`". $_SESSION["radiusLocation"] . "` IDENTIFIED BY '". $_SESSION["pwdPraDB"] . "' WITH GRANT OPTION";
			if ($DEBUG) print $requete. "<br>";
			@mysql_query($requete, $res) or die("Error : ".mysql_error()); 
			@mysql_select_db($_SESSION["namePraDB"], $res) or die("Error : ".mysql_error());
			
			?>
			<tr>
				<td><b>Database user phpradmin </b></td>
				<td align="right">done</td>
			</tr>
			<?
			
			$file_sql = file("./phpradmin_mysql.sql", "r");
            $str = NULL;
            for ($i = 0; $i <= count($file_sql) - 1; $i++)       	{
	            $line = $file_sql[$i];
	            if ($line[0] != '#')    {
	                $pos = strrpos($line, ";");
	                if ($pos != false)      {
	                    $str .= $line;
	                    $str = chop ($str);
	                    $result = mysql_query($str, $res);
	                    $str = NULL;
	                }
	                else
	                	$str .= $line;
	            }
            }			
			@mysql_close($res);
			$res = connexion($_SESSION["namePraDB"], $_SESSION["pwdPraDB"], $_SESSION["dbLocation"]);
			@mysql_select_db($_SESSION["namePraDB"], $res) or die("Error : ".mysql_error());
            
			$req = "SELECT * FROM `user` WHERE user_alias = '".$_SESSION["pralogin"]."' ";
			$r = @mysql_query($req, $res);
			if (!$r)
				@print mysql_error($res);
			$nb = @mysql_num_rows($r);
			while ($tab = @mysql_fetch_array($r))
				break;
			if (!$tab && !$nb){
			// ADD phpRADmin admin user info    	
				$requete = "INSERT INTO `user` (`user_firstname` , `user_lastname` , `user_alias` , `user_passwd` , `user_lang` , `user_mail` , `user_version` , `user_status` ) VALUES ";
				$requete .= "('".$_SESSION["prafirstname"]."', '".$_SESSION["pralastname"]."', '".$_SESSION["pralogin"]."', '". md5($_SESSION["phpradminpassword"]) ."', '".$_SESSION["pralang"]."', '".$_SESSION['praemail']."', '".$_SESSION['radiusVersion']."', '3');";
				
			//ADD general options 	
				$requete2 = "INSERT INTO `general_opt` (`radius_pwd`, `phpradmin_pwd`, `refresh`, `rrd_pwd`, `session_expire`, `startup_script`, `dictionary_path`, `radius_log_path`, `system_log_path`, `sudo_bin_path`, `radius_bin_pwd`) VALUES ";
				$requete2 .= "('".$_SESSION["radius_conf"]."', '".$_SESSION["phpradmin_pwd"]."', 60,'".$_SESSION["rrdtool_bin"]."', 0, '". $_SESSION["radius_startscript"] ."', '".$_SESSION["radius_dictionary"]."', '".$_SESSION['radius_log']."', '".$_SESSION['system_log']."', '".$_SESSION['sudo_bin']."', '".$_SESSION['radius_bin']."');";
				
			//ADD dialup_admin options
				$requete3 = "INSERT INTO `dialup_admin_cfg` (`general_prefered_lang`, `general_prefered_lang_name`, `general_charset`, `general_base_dir`, `general_radiusd_base_dir`, `general_domain`, `general_use_session`, `general_most_recent_fl`, `general_strip_realms`, `general_realm_delimiter`, `general_realm_format`, `general_show_user_password`, `general_raddb_dir`, `general_ldap_attrmap`, `general_clients_conf`, `general_sql_attrmap`, `general_accounting_attrs_file`, `general_extra_ldap_attrmap`, `general_lib_type`, `general_user_edit_attrs_file`, `general_sql_attrs_file`, `general_default_file`, `general_finger_type`, `general_nas_type`, `general_snmpfinger_bin`, `general_radclient_bin`, `general_test_account_login`, `general_test_account_password`, `general_radius_server`, `general_radius_server_port`, `general_radius_server_auth_proto`, `general_radius_server_secret`, `general_auth_request_file`, `general_encryption_method`, `general_accounting_info_order`, `general_stats_use_totacct`, `general_restrict_badusers_access`, `general_caption_finger_free_lines`, `ldap_server`, `ldap_write_server`, `ldap_base`, `ldap_binddn`, `ldap_bindpw`, `ldap_default_new_entry_suffix`, `ldap_default_dn`, `ldap_regular_profile_attr`, `ldap_use_http_credentials`, `ldap_directory_manager`, `ldap_map_to_directory_manager`, `ldap_debug`, `ldap_filter`, `ldap_userdn`, `sql_type`, `sql_server`, `sql_port`, `sql_username`, `sql_password`, `sql_database`, `sql_accounting_table`, `sql_badusers_table`, `sql_check_table`, `sql_reply_table`, `sql_user_info_table`, `sql_groupcheck_table`, `sql_groupreply_table`, `sql_usergroup_table`, `sql_total_accounting_table`, `sql_nas_table`, `sql_command`, `general_snmp_type`, `general_snmpwalk_command`, `general_snmpget_command`, `sql_debug`, `sql_use_user_info_table`, `sql_use_operators`, `sql_password_attribute`, `sql_date_format`, `sql_full_date_format`, `sql_row_limit`, `sql_connect_timeout`, `sql_extra_servers`, `counter_default_daily`, `counter_default_weekly`, `counter_default_monthly`, `counter_monthly_calculate_usage`) VALUES ";
				$requete3 .= "('en', 'English', 'iso-8859-1', '".$_SESSION["phpradmin_pwd"]."/www/include/dialup_admin', '".$_SESSION['radius_bin']."', 'phpradmin.org', 'no', '50', 'no', '@', 'suffix', 'yes', '".$_SESSION["radius_conf"]."', '".$_SESSION["radius_conf"]."/ldap.attrmap', '".$_SESSION["radius_conf"]."/clients.conf', '".$_SESSION["phpradmin_pwd"]."/conf/dialup_admin/conf/sql.attrmap', '".$_SESSION["phpradmin_pwd"]."/conf/dialup_admin/conf/accounting.attrs', '".$_SESSION["phpradmin_pwd"]."/phpradmin/conf/dialup_admin/conf/extra.ldap-att', 'sql', '".$_SESSION["phpradmin_pwd"]."/conf/dialup_admin/conf/user_edit.attrs', '".$_SESSION["phpradmin_pwd"]."/conf/dialup_admin/conf/sql.attrs', '".$_SESSION["phpradmin_pwd"]."/conf/dialup_admin/conf/default.vals', '', 'other', '".$_SESSION["phpradmin_pwd"]."/conf/dialup_admin/bin/snmpfinger', '".$_SESSION["radclient"]."', 'test', 'testpass', 'localhost', '1812', 'chap', 'secret', '".$_SESSION["phpradmin_pwd"]."/conf/dialup_admin/conf/auth.request', 'clear', 'desc', 'no', 'no', 'free lines', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'mysql', '".$_SESSION["dbLocation"]."', '3306', '".$_SESSION["namePraDB"]."', '".$_SESSION["pwdPraDB"]."', '".$_SESSION["namePraDB"]."', 'radacct', 'badusers', 'radcheck', 'radreply', 'userinfo', 'radgroupcheck', 'radgroupreply', 'usergroup', 'totacct', 'nas', '".$_SESSION["mysqlclient"]."', 'net', '".$_SESSION["snmpwalk"]."', '".$_SESSION["snmpget"]."', 'false', 'true', 'true', 'User-Password', 'Y-m-d', 'Y-m-d H:i:s', '50', '3', '', 'none', 'none', 'none', 'false');";


				if ($DEBUG) print "larequete: ". $requete ." larequete2: " . $requete2 ." la requete3: ". $requete3. "<br>";
				$result = @mysql_query($requete, $res);
				$result2 = @mysql_query($requete2, $res);
				$result3 = @mysql_query($requete3, $res);
			}else {
				$requete = "UPDATE `user` SET `user_firstname` = '".$_SESSION["prafirstname"]."',`user_lastname` = '".$_SESSION["pralastname"]."',`user_alias` = '".$_SESSION["pralogin"]."',`user_passwd` = '". md5($_SESSION["phpradminpassword"]) ."',`user_mail` = '".$_SESSION['praemail']."',`user_status` = '32',`user_lang` = '".$_SESSION["pralang"]."' WHERE `user_id` =1 LIMIT 1 ;";
				if ($DEBUG) print "larequete: ". $requete ." larequete2: " . $requete2 ." la requete3: ". $requete3. "<br>";
				$result = @mysql_query($requete, $res);
			}
			?>
			<tr>
				<td><b>Database updated </b></td>
				<td align="right">done</td>
			</tr>
			<?
			@mysql_close($res); 
		// end last code
		aff_middle();
		$str = "<input class='button' type='submit' name='goto' value='Back' /><input class='button' type='submit' name='goto' value='Next' id='button_next' />";
		print $str;
		aff_footer();
	} else if (isset($_POST["step"]) && $_POST["step"] == 7){
		session_destroy();
		aff_header("phpRADmin Setup Wizard", "Installation Finished", 8);
		?>
<?

print "Config sudo to allow phpRADmin to do some task securely from apache user:<br><br>";
print "<font style=courier> # visudo</font><br>";
print "<font style=courier> apache     ALL=NOPASSWD: ".$_SESSION["phpradmin_pwd"]. "/conf/phpradmintool.sh</font><br><br>";

print "

Please before to put next crontab lines edit every file and adjust your perl binary, with your needs add and entire path for ".$_SESSION["phpradmin_pwd"]. "/conf/dialup_admin/conf/admin.conf. <br><br>

Adjust every shell scripts to generate graphs in directory ".$_SESSION["phpradmin_pwd"]. "/conf/graphs<br><br>

Modify PHPRADIMIN_DIR and MYSQL_CLIENT_BIN in ".$_SESSION["phpradmin_pwd"]. "/conf/phpradmintool.sh<br><br>

# crontab -e<br>
*/5 * * * * ".$_SESSION["phpradmin_pwd"]. "/www/rrd/phpradmin_update.sh > /dev/null 2>&1<br>
1 0 * * * ".$_SESSION["phpradmin_pwd"]. "/conf/dialup_admin/bin/tot_stats >/dev/null 2>&1<br>
5 0 * * * ".$_SESSION["phpradmin_pwd"]. "/conf/dialup_admin/bin/monthly_tot_stats >/dev/null 2>&1<br>
10 0 1 * * ".$_SESSION["phpradmin_pwd"]. "/conf/dialup_admin/bin/truncate_radacct >/dev/null 2>&1<br>
15 0 1 * * ".$_SESSION["phpradmin_pwd"]. "/conf/dialup_admin/bin/clean_radacct >/dev/null 2>&1<br><br>

You must be sure that all previus files are executables: chmod +x file_name<br><br>

Add to your /etc/local.conf or run at system init next script:<br>
".$_SESSION["phpradmin_pwd"]. "/bin/log_badlogins freeradius_dir_log/radius.log ".$_SESSION["phpradmin_pwd"]. "/conf/dialup_admin/conf/admin.conf & <br><br>

To allow phpRADmin write logs for your history (recommended!!). Use apacheuser:apachegroup :<br>

chmod -R apache:apache ".$_SESSION["phpradmin_pwd"]. "/www/include/log/<br><br>

If you want to use PKI (certificates):<br>
# chown -R apache:apache ".$_SESSION["phpradmin_pwd"]. "/conf/phpki-store/<br>
# chmod -R 770 ".$_SESSION["phpradmin_pwd"]. "/conf/phpki-store/<br>
<br>
Open in your browser http://SERVER-IP/phpradmin/include/phpki/setup.php<br>
<br>
Please be sure that your radiusd startup script (/etc/init.d/radiusd) have restart and status options.<br><br>

Go to Options section and configure as your needs. After finish installation configure your FreeRADIUS with phpRADmin, unlock, modify and generate files and restart.<br><br>

Remember to configure FreeRADIUS to connect to phpradmin database (/etc/raddb/sql.conf) and modify radiusd.conf to authenticate to sql database.<br><br>

Discover, learn and teach phpRADmin.<br><br>

Help us to make it better.<br><br>

NOTE: This documentation is from scratch and over CC 2.5 License.<br><br>"
?>

			<center>You can now return to your configured <a href='../'>interface</a>.</center>
		<?
		aff_middle();
		aff_footer();
	}
	exit(); 
?>
