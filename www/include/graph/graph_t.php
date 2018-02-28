<?
/** 
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Julien Mathis - Mathieu Mettre - Romain Le Merlus - Christophe Coraboeuf

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

?>

<form action="phpradmin.php?p=310&o=u" method="post" name="graphMenu">
<table align="left" cellpadding="0" cellspacing="0">
	<tr>
		<td valign="top">
			<table cellpadding="0" cellspacing="0">
				<tr>
					<td class="tabTableTitle"><? echo $lang['g_graphorama']; ?></td>
				</tr>
				<tr>
					<td class="tabTableForTab">
						<table border='0' cellpadding="2" cellspacing="2" nowrap align="center">
							<tr>
								<td style="padding-top:20px; white-space: nowrap;" class="text10b"><? echo $lang['g_date_begin']; ?></td>
								<td valign="bottom" style='white-space: nowrap;'>
									<input type="text" name="startDate" size="10" maxlength="10"><input type="button" value="<? echo $lang['choose']; ?>" onclick="displayDatePicker('startDate');">&nbsp;
									<? echo $lang['g_hours']; ?> : <select name="starthours" size="1">
									<? for ($cpthours = 00; $cpthours < 24; $cpthours++)	echo "<option value='$cpthours'>$cpthours</option>";	?>
									</select>
								</td>
							</tr>
							<tr>
								<td class="text10b" style='white-space: nowrap;'><? echo $lang['g_date_end']; ?></td>
								<td style='white-space: nowrap;'>
									<input type="text" name="endDate" size="10" maxlength="10"><input type="button" value="<? echo $lang['choose']; ?>" onclick="displayDatePicker('endDate');">&nbsp;
									<? echo $lang['g_hours']; ?> : <select name="endhours" size="1">
									<? 	for ($cpthours = 00; $cpthours < 24; $cpthours++)	echo "<option value='$cpthours'>$cpthours</option>";	?>
									</select> 
								</td>
							</tr>
							<tr>
								<td class="text10b" style='white-space: nowrap;'><? echo $lang['g_number_per_line']; ?></td>
								<td style='white-space: nowrap;'>
									<select name="modulo" size="1">
									<?
										for ($str2 = "", $t = 1; $t != 8; $t++) {
											$str2 .= "<option value='".$t."'";
											if ($t == 2)
												$str2 .= " selected";
											$str2 .= ">".$t."</option>"; 
										} 
										print $str2;
										unset($str2);
									?>
									</select>
								</td>
							</tr>
							<tr>
								<td class="text10b" style='white-space: nowrap;'><? echo $lang['g_height']; ?></td>
								<td style='white-space: nowrap;'><input size="6" type="text" name="height" value="100"></td>
							</tr>
							<tr>
								<td class="text10b" style='white-space: nowrap;'><? echo $lang['g_width']; ?></td>
								<td style='white-space: nowrap;'><input size="6" type="text" name="width" value="270"> </td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
		<td style="padding-left: 20px;"></td>
		<td valign="top" align="left">	
			<table cellpadding="0" cellspacing="0">
				<tr>
					<td class="tabTableTitle"><? print $lang['g_available']; ?></td>
				</tr>
				<tr>
					<td class="tabTableForTab">
						<? 
						echo "<ul id='myMenu'>\n";
						$i = 1;			
						if (isset($oreon->hosts))
							foreach ($oreon->hosts as $h)	{
								if ($oreon->is_accessible($h->get_id()))	{
									$tab = 0;
									$flg = 0;
									if (isset($h->services))
										foreach ($h->services as $s)
											if (isset($graphs[$s->get_id()])){
												$flg=1;
												break;
											}
									if ($flg)	{
										echo "<li style='list-style-image:url(./img/folder.gif); white-space: nowrap;' class='text10b'><a name='".$h->get_id()."' href=\"#".$h->get_id()."\" class='text10b'>".$h->get_name()."</a>\n";
										echo "<ul>\n";
										foreach ($h->services as $s)
											if (array_key_exists($s->get_id(), $oreon->graphs)){
												echo "<li style='list-style-image:url(./img/page.gif); white-space: nowrap;' class='text10'>";
												?>
												<input type="checkbox" id="bbox<? echo $i; ?>" name="box[<? echo $s->get_id(); ?>]" value="<? echo $s->get_id(); ?>" style="width: 10px; height: 10px;">&nbsp;
												<?
												echo $s->get_description();
												echo "</li>\n";
												unset($s);
											}
										?>
										<div style="white-space: nowrap;">
											<img src="img/arrow_ltr.gif" style="padding-left: 5px;">&nbsp;&nbsp;
											<a href="#" onClick="multipleCheck(document.forms['graphMenu'].elements['bbox<? echo $i; ?>'], true);" class="text10b"><? echo $lang['check']; ?></a> - 
											<a href="#" onClick="multipleCheck(document.forms['graphMenu'].elements['bbox<? echo $i; ?>'], false);" class="text10b"><? echo $lang['uncheck']; ?></a>
										</div>
										<?
										echo "</ul></li>\n";
										$i++;
									}						
								}
								unset($h);
							}
						echo "</ul>"; ?>
						<SCRIPT language='javascript' src='./include/menu/dhtmlMenu.js'></SCRIPT>
						<? print "<div align='center' style='padding-bottom:10px;'><input type='submit' value='".$lang['view']."'></div>"; ?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</form>