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
	if (!isset($oreon))
		exit();

	exec("ping -c 1 www.phpradmin.org", $output, $return_val);
	if (!$return_val) { ?>
	<table align="left" border="0">
	  <tr>
		<td>
		<div style="margin-bottom:15px;">Your phpRADmin Version is <? include "./include/version/version.php"; ?></div>
			<? include "http://www.phpradmin.org/updates.php"; ?>
		</td>
	  </tr>
	</table>
<? } else { ?>
	<table  align="left"  border="0">
		<tr>
			 <td class="msg"><? echo $lang['update_error_connect']; ?></td>
		</tr>
	</table>
<? } ?>