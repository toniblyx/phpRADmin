<?
/** 
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Jean Baptiste Gouret - Julien Mathis - Mathieu Mettre - Romain Le Merlus

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

function initGraph($service_dup_id, $path)	{
	$graph_array = array();
	$graph_array["graph_id"] = $service_dup_id;
	$graph_array["graph_path"] = $path."/rrd/";
	$graph_array["graph_imgformat"] = "PNG";
	$graph_array["graph_verticallabel"] = "label";
	$graph_array["graph_width"] = "500";
	$graph_array["graph_height"] = "100";
	$graph_array["graph_ColGrilFond"] = "FFFFFF";
	$graph_array["graph_ColFond"] = "FEFEFE";
	$graph_array["graph_ColPolice"] = "000000";
	$graph_array["graph_ColGrGril"] = "800000";
	$graph_array["graph_ColPtGril"] = "808080";
	$graph_array["graph_ColContCub"] = "000000";
	$graph_array["graph_ColArrow"] = "FFFFFF";
	$graph_array["graph_ColImHau"] = "C0C0C0";
	$graph_array["graph_ColImBa"] = "909090";
	$graph_array["graph_ds1name"] = "DataSource1";
	$graph_array["graph_ds2name"] = "DataSource2";
	$graph_array["graph_ColDs1"] = "ff0000";
	$graph_array["graph_ColDs2"] = "00ff00";
	$graph_array["graph_ds3name"] = "DataSource3";
	$graph_array["graph_ds4name"] = "DataSource4";
	$graph_array["graph_ColDs3"] = "0000ff";
	$graph_array["graph_ColDs4"] = "5BACB3";
	$graph_array["graph_flamming"] = "no";
	$graph_array["graph_lowerlimit"] = "0";
	$graph_array["graph_areads1"] = "no";
	$graph_array["graph_ticknessds1"] = "2";
	$graph_array["graph_gprintlastds1"] = "no";
	$graph_array["graph_gprintminds1"] = "no";
	$graph_array["graph_gprintaverageds1"] = "no";
	$graph_array["graph_gprintmaxds1"] = "no";
	$graph_array["graph_areads2"] = "no";
	$graph_array["graph_ticknessds2"] = "2";
	$graph_array["graph_gprintlastds2"] = "no";
	$graph_array["graph_gprintminds2"] = "no";
	$graph_array["graph_gprintaverageds2"] = "no";
	$graph_array["graph_gprintmaxds2"] = "no";
	$graph_array["graph_areads3"] = "no";
	$graph_array["graph_ticknessds3"] = "2";
	$graph_array["graph_gprintlastds3"] = "no";
	$graph_array["graph_gprintminds3"] = "no";
	$graph_array["graph_gprintaverageds3"] = "no";
	$graph_array["graph_gprintmaxds3"] = "no";
	$graph_array["graph_areads4"] = "no";
	$graph_array["graph_ticknessds4"] = "2";
	$graph_array["graph_gprintlastds4"] = "no";
	$graph_array["graph_gprintminds4"] = "no";
	$graph_array["graph_gprintaverageds4"] = "no";
	$graph_array["graph_gprintmaxds4"] = "no";
	return $graph_array;
}
?>