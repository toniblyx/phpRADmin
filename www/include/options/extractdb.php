<?
/** 
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Julien Mathis - Romain Le Merlus - Christophe Coraboeuf

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
		
	$sql = "SELECT VERSION() AS mysql_version";
	if($oreon->database->database->query($sql)){
		$row = $oreon->database->database->fetch_array();
		$version = $row['mysql_version'];
		if( preg_match("/^(3\.23|4\.)/", $version) ){
			$db = $conf_pra["db"];
			$db_name = ( preg_match("/^(3\.23\.[6-9])|(3\.23\.[1-9][1-9])|(4\.)/", $version) ) ? "`$db`" : $db;
			$sql = "SHOW TABLE STATUS FROM " . $db_name;
			if($oreon->database->database->query($sql))
			{
				$dbsize = 0;
				$rows = 0;
				$datafree = 0;
				while ($tabledata_ary = $oreon->database->database->fetch_array())
					if(isset($tabledata_ary['Type']) && $tabledata_ary['Type'] != "MRG_MyISAM" )
					{
						$dbsize += $tabledata_ary['Data_length'] + $tabledata_ary['Index_length'];
						$rows += $tabledata_ary['Rows'];
						$datafree += $tabledata_ary['Data_free']; 
					}
			} 
		} else {
			$dbsize = 'Not_available';
			$rows = 'Not_available';
			$datafree = 'Not_available';
		}
	}
	
?>
<table cellpadding='0' cellspacing='0'>
	<tr>
		<td class="tabTableTitle"><? print $lang["DB_status"]; ?></td>
	</tr>
	<tr>
		<td class="tabTableForTab">
			<table width="300">
				<tr>
					<td class="text11b"><? print $lang["db_lenght"] ; ?></td>
					<td class="text11b"><? print $lang["db_nb_entry"] ; ?></td>
				</tr>
				<tr>
					<td><? $dbsize /= 1024; print round($dbsize, 0); ?>KB</td>
					<td><? print $rows; ?></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<table cellpadding='0' cellspacing='0' style="padding-top:15px;padding-bottom:15px;">
	<tr>
		<td class="tabTableTitle">DB Options</td>
	</tr>
	<tr>
		<td class="tabTableForTab">
			<table border="0" align="left">
				<tr>
					<td align="left" class="text11">
					<lu>
						<li><? echo $lang['db_backup']; ?></li>
						<table border="0" width="100%" height="35">
						<tr>
							<td width="20%">&nbsp;</td>
							<td width="60%" valign="middle" align="center">
							<br>
							<form action="" method="post">
								<input name="s" type="hidden" value="1">
								<input name="export_sub_list" type="submit" value="<? echo $lang['db_extract']; ?>">
							</form>
							</td>
							<td width="20%">&nbsp;</td>
						</tr>
						</table>
					</lu>
					</tD>
				</tr>
			</table>
		</td>
	</tr>
</table>
