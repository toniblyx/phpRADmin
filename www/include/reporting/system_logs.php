<?
/**
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Julien Mathis - Romain Le Merlus- Christophe Coraboeuf

The Software is provided to you AS IS and WITH ALL FAULTS.
OREON makes no representation and gives no warranty whatsoever,
whether express or implied, and without limitation, with regard to the quality,
safety, contents, performance, merchantability, non-infringement or suitability for
any particular or intended purpose of the Software found on the OREON web site.
In no event will OREON be liable for any direct, indirect, punitive, special,
incidental or consequential damages however they may arise and even if OREON has
been previously advised of the possibility of such damages.

For information : contact@oreon.org
*/
	if (!isset($oreon))
		exit();
?>
<table border=0 width="100%" class="tabTableTitleHome">
		<tr>
			<td style="text-align:left;font-family:Arial, Helvetica, Sans-Serif;font-size:13px;padding-left:20px;font-weight: bold;">System Logs<? echo $lang['system_logs']; ?></td>
		</tr>
	</table>
	<table border=0 width="100%" class="tabTableHome" style="padding-top:8px;">
		<tr>
		  <td width="100%" align="center" colspan="2">
			<center>
			<table border=0 cellpadding="0" cellspacing="0" align="center">
						
					<td class="text10b" align="left" style="padding-right: 3px;"><br />
						<td align="left" style="padding-right: 3px;">
						<?php
						$handle = popen("/usr/bin/sudo /usr/local/phpradmin/conf/phpradmintool.sh systemlog 2>&1", 'r');
						while(!feof($handle)) {
   						$buffer = fgets($handle);
   						echo "$buffer<br/>\n";
   						ob_flush();
   						flush();
						}
						pclose($handle);
						?>
						</td>
						<strong>Last 30 lines for System Log</strong><br><br>
					</td>
			</table>
		  </td>
		</tr>
	</table>


