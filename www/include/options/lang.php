<?
/*
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)
For information : toni@blyx.com
*/
		$chemintotal = "./lang/";
		$cpt = 0;
		if ($handle  = @opendir($chemintotal))	{
			while ($file = @readdir($handle))
				if (is_file("$chemintotal/$file") && strcmp($file, "index.php") && strcmp($file, "exemple.php"))	{
					$table_file[$cpt] = $file;
					$cpt++;
				}
			@closedir($handle);
		}
		if (isset($_POST["uploader"]) && isset($HTTP_POST_FILES["file_name"]["name"]))	{
			$exist = 0;
			foreach ($table_file as $files)
				if (!strcmp($files, $file))
					$exist = 1;
			if (!$exist)	{
				if (move_uploaded_file($HTTP_POST_FILES["file_name"]["tmp_name"], "lang/" . $HTTP_POST_FILES["file_name"]["name"]))
					$table_file[$cpt] = $HTTP_POST_FILES["file_name"]["name"];					
				else
					$msg = "Can't upload file";	
			}
			else
				$msg = $lang[file_exist];
		}

?>
<table align="left" cellpadding="0" cellspacing="0" width="400">
	<tr>
		<td class="tabTableTitle"><? print $lang["m_lang"]; ?></td>
	</tr>
	<tr>
		<td align="left" class="tabTableForTab">
			<form action="" method="POST" enctype="multipart/form-data">
			<table border='0' align="left">
				<tr>
					<td align="center">
						<? 
						if (isset($msg)) 
							print "<br><br>" . $msg . "<br><br>";
						$cpt = 0;
						echo "<TABLE WIDTH='' BORDER='0' CELLPADDING=0 CELLSPACING='1' nowrap>";
						echo "<TR>";
						echo "	<TD background='./img/menu.jpg' width=35 align='center'>&nbsp;</TD>";
						echo "	<TD background='./img/menu.jpg' ALIGN='center' width='150'><b class='link'>Name</b></TD>";
						echo "	<TD background='./img/menu.jpg' width=50 ALIGN='center' COLSPAN='1'><B class='link'>Size</B></TD>";
						echo "</TR>";
						foreach ($table_file as $file)	{
							echo "<TR>";
							echo "	<TD BGCOLOR='#EBEEF3' bordercolor='#EBEEF3' width=35 ALIGN='center'><IMG SRC ='./img/text.gif'></TD>";
							echo "	<TD BGCOLOR='#EBEEF3' bordercolor='#EBEEF3' align='right' style='padding-right:12px'>$file</TD>";
							echo "	<TD BGCOLOR='#EBEEF3' bordercolor='#EBEEF3' ALIGN='center' COLSPAN='1'><font class='link'>" . filesize("$chemintotal/$file") . " bytes</font></TD>";
							echo "</TR>";
						}
					echo "</TABLE>";
					?>
					</td>
				</tr>
				<tr>
					<td valign="top" style="padding:25px" align="left">
						<table cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td>
									<p align="justify" class="text10">
										<? echo $lang['lang_infos']; ?><? echo count($table_file);?> 
										<? echo $lang['lang_infos2']; ?><br>
										<? echo $lang['lang_infos3'];?><br>
										<? echo $lang['lang_detail']; ?>
										<a href='./lang/index.php?file=en.php' target="_blank" class="text11b"><? echo $lang['this']; ?></a> 
										<? echo $lang['lang_detail2']; ?><br>
									</p>
								</td>
							</tr>
						</table>
						<div align="center" style="padding-top: 10px;">
							<input name="file_name" type="file"><br><br>
							<input name="uploader" type="submit" value='Upload'>
						</div>	
					</td>
				</tr>
			</table>
			</form>
		</td>
	</tr>
</table>