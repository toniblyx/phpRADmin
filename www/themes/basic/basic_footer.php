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
?>
		<table cellpadding="0" cellspacing="0" height="1" width='100%'>
			<tr>
				<td height="1" width='100%' bgcolor="#CCCCCC"><img src="img/blank.gif" width="1" height="1" hspace="0"></td>
			</tr>
		</table>
		<table cellpadding='0' cellspacing='0' width='100%' border='0'>
			<tr>
			  <td align='center' class='copyRight'>
					<? echo $lang['generated']; ?> <? $time_end = microtime_float(); $now = $time_end - $time_start; print round($now,3) . $lang["time_sec"]; ?><br />
					<a href="http://www.phpradmin.org" target="_blank" class="text10b">phpRADmin</a> <? include ("include/version/version.php"); ?> - 
					&copy; 2006 <a href="http://blyx.com" target="_blank" class="text10b">Toni de la Fuente Diaz</a>. All
				Rights Reserved.</td>
			</tr>
		</table>
		<? 
			//$memory = xdebug_memory_usage() / 1000000; 
			//$memory = sprintf ("%.2f",$memory); 
			//$memory = "<h4 style=\"color: blue\">Memory Used = " . $memory . "M</h>"; 
			//echo $memory; 
			//xdebug_dump_function_trace();
			//xdebug_stop_trace(); 	
		?>