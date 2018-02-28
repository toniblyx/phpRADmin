<?
/*
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)
For information : toni@blyx.com
*/
?>
	<br><br>
	<table border=0 width="35%" height="50%">
	<tr>
		<td>
		<? include("./tab3Top.php"); ?>
		<form action="" method="get">
			<table width="100%" height='100%' border=0>
			<tr>
				<td class="text10b">Host Name<font color="red">*</font></td>
				<td><input name="p" type="hidden" value="306"><input name="cmd" type="hidden" value="0">
					  <select name="cmt[host_name]">
						<? 
						if (isset($oreon->hosts))
							foreach ($oreon->hosts as $h)
								if ($h->register != 0)
									print "<option>".$h->get_name()."</option>";
					  	?>
					  </select>
				</td>
			</tr>
			<tr>
				<td class="text10b">Persistent</td>
				<td><input name="cmt[pers]" type="checkbox" checked></td>
			</tr>	
			<tr>
				<td class="text10b">Auteur<font color="red">*</font> </td>
				<td><input name="cmt[auther]" type="text" value="<? print $oreon->user->get_alias(); ?>"></td>
			</tr>
			<tr>
				<td class="text10b" valign="top">Comment<font color="red">*</font></td>
				<td><textarea name="cmt[comment]" cols="40" rows="7"></textarea></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><br><bR><br> <input name="envoyer" type="submit"></td>
			</tr>
			</table>
		<? include("./tab3Bot.php"); ?></form>
		</td>
	</tr>
	</table>	