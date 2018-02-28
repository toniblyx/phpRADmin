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

	$graphs = & $oreon->graphs;
	if (isset($_GET) && array_key_exists("o", $_GET) && $_GET["o"] != "a" && $_GET["o"] != "t" && $_GET["o"] != "u" && $_GET["o"] != "h")
		if (!isset($_GET["gr"]) || (isset($_GET["gr"]) && !array_key_exists($_GET["gr"], $graphs)))	{
			echo "<td width='85%'></td>";
			include ("./footer.php");
			exit();
		}
	$hosts = & $oreon->hosts;
	$services = & $oreon->services;
	$commands = & $oreon->commands;
	$graphModels = & $oreon->graphModels;
	$graphModelDS = & $oreon->graphModelDS;


	$imgFormat = array(0=>"GIF", 1=>"PNG");
	$msg = NULL;

	if (isset($_POST["ChangeGR"]))	{
		$gr_array = & $_POST["graph"];
		$gr_object = new GraphRRD($gr_array);
		if ($gr_object->is_complete($oreon->user->get_version()))	{
			$graphs[$gr_array["graph_id"]] = $gr_object;
			$oreon->saveGraph($graphs[$gr_array["graph_id"]]);
			$msg = $lang['errCode'][2];
			$_GET["o"] = "w";
		} else
			$msg = $lang['errCode'][$gr_object->get_errCode()];
		unset ($gr_object);
	}
?>
	<table cellpadding="0" cellspacing="0">
		<tr>
			<td valign="top">
				<?
				if (isset($_GET["o"]) && !strcmp($_GET["o"], "u")) // Graphorama: View on all selected graphs
					include("./include/graph/graph_u.php");
				else if (isset($_GET["o"]) && !strcmp($_GET["o"], "v"))	  // display four kind of a graph without the possibility to modify
					include("./include/graph/graph_v.php");
				else if (isset($_GET["o"]) && !strcmp($_GET["o"], "h"))
					include("./include/graph/graph_h.php");
				else if (isset($_GET["o"]) && (!strcmp($_GET["o"], "c") || !strcmp($_GET["o"], "w")))	{
					$gr = $_GET["gr"];
					if ($msg)
						echo "<div style='padding-bottom: 10px;' class='msg' align='center'>$msg</div>";
					unset($msg);
					include("./include/graph/graph_cw.php");
				}

				if ((isset($msg) && $msg) || !isset($_GET["o"]))	{
					echo "<div style='padding-bottom: 10px;' class='msg' align='center'>$msg</div>";
					include("./include/graph/graph_t.php");
				}	else	{
				?>
			</td>
			<td style="padding-left: 20px;"></td>
			<td valign="top" align="left">
				<table cellpadding="0" cellspacing="0">
					<tr>
						<td class="tabTableTitle" style="padding-left: 5px; padding-top: 3px; padding-bottom: 3px; white-space: nowrap;"><img src="img/picto1.gif">&nbsp;&nbsp;<? echo $lang['graphs']; ?></td>
					</tr>
					<tr>
						<td class="tabTableForTab">
							<?
							echo "<ul id='myMenu'>\n";
							if (isset($oreon->hosts))
								foreach($oreon->hosts as $host)	{
									if ($oreon->is_accessible($host->get_id())){
										$flg = 0;
										if (isset($host->services) && count($host->services))	{
											foreach ($host->services as $service)	{
												if (isset($oreon->graphs[$service->get_id()])){
													if ($flg == 0){
														echo "<li style='list-style-image:url(./img/folder.gif);'><a href=\"#\" class='text10b'>".$host->get_name()."</a>\n<ul>\n";
													}
													echo "<li style='list-style-image:url(./img/page.gif);'><a href=\"./phpradmin.php?p=310&gr=".$service->get_id()."&o=v\" class='text10'>".$service->get_description()."</a></li>\n";
													$flg++;
												}
												unset($service);
											}
											if ($flg != 0)
												echo "</ul></li>\n";
										}
										unset ($host);
									}
								}
							echo "</ul>";
							echo "</div>";
							?>
							<SCRIPT language='javascript' src='./include/menu/dhtmlMenu.js'></SCRIPT>
						</td>
					</tr>
				</table>

			</td>
			<? } ?>
		</tr>
	</table>