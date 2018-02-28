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
// Block access
	if (!isset($oreon))
		exit;


$sudo_bin = $oreon->optGen->get_sudo_bin_path();
$phpradmintool = $oreon->optGen->get_phpradmin_pwd() ."/conf/phpradmintool.sh";
	
if (isset($_POST["lock"]) && !strcmp($_POST["lock"], "lock")) {
	$sec_status = shell_exec("$sudo_bin $phpradmintool lock");
	$msg .= $sec_status."<br>";

}

if (isset($_POST["unlock"]) && !strcmp($_POST["unlock"], "unlock")) {
	$sec_status = shell_exec("$sudo_bin $phpradmintool unlock");
	$msg .= $sec_status."<br>";
}

if (isset($_POST["restart"]) && !strcmp($_POST["restart"], "restart")) {
	$stdout = shell_exec("$sudo_bin $phpradmintool restart"); 
	//$msg .= $lang['edb_nagios_restart_ok']."<br>";
	$msg .= $stdout."<br>";
} 

?>


	<table border="0" cellpadding="2" cellspacing="2">
		<tr>
		<td valign="top" align="left">
				<table cellpadding="0" cellspacing="0">
					<tr>
						<td class="tabTableTitle"><? print $lang['system_security_status']; ?>: </td>
					</tr>
					<tr>
						<td class="tabTableForTab">
						<TABLE width='200' CELLPADDING=3 CELLSPACING='1' nowrap align=center>
						<TR>
						<TD ALIGN='left' class="tabTableForTab"><b class='link'><? print $lang['system_security_status_expl']; ?>. <br /><br /> <? print $lang['system_security_status_change']; ?>.</b>
						</TD>
						</TR>
							<TR>
							<td class="tabTableForTab" ALIGN='center' style='white-space: nowrap;'>
							<?
			  				$sec_status = shell_exec("$sudo_bin $phpradmintool ask");
			  				if (strstr($sec_status, "UNLOCKED")) {
							echo "<img src=\"img/unlock.png\" alt=\"UNLOCKED\" width=\"70\" height=\"50\" /><br>" ;
							echo "System <strong>UNLOCKED</strong>";
							?>
							<br />
							<form action="" method="post">
										<input name="lock" type="hidden" value="lock">
										<input name="Generate" type="submit" value="<? echo $lang['lock']; ?>">
							</form>
							<?
							} else {
							echo "<img src=\"img/lock.png\" alt=\"LOCKED\" width=\"50\" height=\"50\" /><br>" ;
							echo "System <strong>LOCKED</strong>";
							?>
							<br />
							<form action="" method="post">
										<input name="unlock" type="hidden" value="unlock">
										<input name="Generate" type="submit" value="<? echo $lang['unlock']; ?>">
							</form>
							<?
							}
		      				?>
							
							</td>
							</TR>
						</TABLE>
		  </TABLE><br>
		  </td>
			<td valign="top" align="left">
				<? 
				if ($msg)
					echo "<div style='padding-bottom: 10px;' class='msg' align='center'>$msg</div>"; ?> 
				<table border='0' align="center" cellpadding="0" cellspacing="0">
					<tr>
						<td style="white-space: nowrap;" class="tabTableTitle">Generate and Restart</td>
					<tr>
					<tr>
						<td class="tabTableForTab">	
					
							<ul>
								<div style="float:left;padding-top:10px;width:250px;">1 - <? echo $lang['db_genesis']; ?></div>
								<div style="padding-top:10px">
									<form action="" method="post">
										<input name="generate" type="hidden" value="generate">
										<input name="Generate" type="submit" value="<? echo $lang['db_generate']; ?>">
									</form>
								</div>
								
												<div style="float:left;width:250px;">2 - <? echo $lang['edb_radius_restart']; ?></div>
				<div style="padding-right:20px">
									<form action="" method="post">
										<input name="restart" type="hidden" value="restart">
										<input name="Reboot" type="submit" value="<? echo $lang['edb_restart']; ?>">
									</form>
								</div>
							</ul>
						</td>
					</tr>
				<? if (isset($_POST["generate"]) && !strcmp($_POST["generate"], "generate")) { ?>	
						<tr>
							<td class="tabTable">
							<?	
								$sec_status = shell_exec("$sudo_bin $phpradmintool ask");
			  					if (strstr($sec_status, "UNLOCKED")) {
								print "<font color='blue'>" . "Generating files results..." . "</font><br><br>";
								include_once ("include/options/dialup_admin_configuration_generate.php");
								include_once ("include/options/nas_configuration_generate.php");
								
								} else {
								print "<font color='red'>" . "System is LOCKED!! Unlock before generate files" . "</font><br>";
								}
							?>
							</td>
						</tr>
						<tr>
							<td bgcolor="#CCCCCC"></td>
						</tr>
			  </table>
				<? } else if (isset($_POST["o"]) && !strcmp($_POST["o"], "r")) {	?>	
	  
</table>
				<? } else { ?>
					</table>
				<? } ?>
			</td>
			
					</tr>
				</table>
			</td>
		</tr>
	</table>