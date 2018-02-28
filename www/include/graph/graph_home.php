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
//if (!isset($oreon))
	//exit();
	
include_once ("./jpgraph/jpgraph-1.17beta2/src/jpgraph.php");
include_once ("./jpgraph/jpgraph-1.17beta2/src/jpgraph_pie.php");
include_once ("./jpgraph/jpgraph-1.17beta2/src/jpgraph_pie3d.php");

// Some data

$data = array($_GET['dataA'], $_GET['dataB'], $_GET['dataC'], $_GET['dataD']);
//$data = array("12", "56");

// Create the Pie Graph.
$graph = new RadarPlot(350,200,"auto");
$graph->SetShadow();


$servicename = $_GET['sn'];

// Set A title for the plot
$graph->title->Set($servicename);
//$graph->title->SetFont("FF_COURIER",10); 
$graph->title->SetColor("darkblue");
$graph->legend->Pos(0.1,0.2);

// Create 3D pie plot
$p1 = new PiePlot3d($data);
$p1->SetTheme("water");
//sand, water, earth, pastel
$p1->SetCenter(0.4);
$p1->SetSize(80);

// Adjust projection angle
$p1->SetAngle(45);

// Adjsut angle for first slice
$p1->SetStartAngle(45);

// Display the slice values
//$p1->value->SetFont("FF_COURIER",10);
$p1->value->SetColor("navy");

// Add colored edges to the 3D pie
// NOTE: You can't have exploded slices with edges!
$p1->SetEdge("navy");

$p1->SetLegends(array("OK", "UNKNOWN", "WARNING", "CRITICAL"));

$graph->Add($p1);
$graph->Stroke();

?>