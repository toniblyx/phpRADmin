<?
/*
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)
For information : toni@blyx.com
*/
	$hg = $_GET["hg"];
	$str = "";
	$rep = array();
	$rep["1"] = "YES";
	$rep["0"] = "NO";

?>

<table border=0 cellpadding="0" cellspacing="0">
		<tr>
			<td align="center" class='tabTableTitle'><? print $lang['hg']." ".$oreon->hostGroups[$hg]->get_name() . " (". $oreon->hostGroups[$hg]->get_alias() . ")"; ?></td>
		</tr>
		<tr>
			<td valign="top" class="tabTableForTab">
				<table border='0'>
					<tr>
						<td align="align" class="text12b" style="white-space: nowrap;"><? echo $lang['mon_hg_commands']; ?></td>
					</tr>
					<tr>
						<td style="white-space: nowrap;"><br>
							- <a href='./phpradmin.php?p=308&o=5&id=<? print $hg; // ?>' class="text9"><? echo $lang['mon_hg_cmd1']; ?></a><br><br>
							- <a href='./phpradmin.php?p=308&o=6&id=<? print $hg; // ?>' class="text9"><? echo $lang['mon_hg_cmd2']; ?></a><br><br>
							- <a href='./phpradmin.php?p=306&cmd=61&id=<? print $hg; // ?>' class="text9"><? echo $lang['mon_hg_cmd3']; ?></a><br><br>
							- <a href='./phpradmin.php?p=306&cmd=62&id=<? print $hg; // ?>' class="text9"><? echo $lang['mon_hg_cmd4']; ?></a><br><br>
							- <a href='./phpradmin.php?p=306&cmd=63&id=<? print $hg; // ?>' class="text9"><? echo $lang['mon_hg_cmd5']; ?></a><br><br>
							- <a href='./phpradmin.php?p=306&cmd=64&id=<? print $hg; // ?>' class="text9"><? echo $lang['mon_hg_cmd6']; ?></a><br><br>
							- <a href='./phpradmin.php?p=306&cmd=65&id=<? print $hg; // ?>' class="text9"><? echo $lang['mon_hg_cmd7']; ?></a><br><br>
							- <a href='./phpradmin.php?p=306&cmd=66&id=<? print $hg; // ?>' class="text9"><? echo $lang['mon_hg_cmd8']; ?></a>
						</td>
					</tr>			
				</table>
			</td>
		</tr>
</table>
