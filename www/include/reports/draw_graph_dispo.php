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
	require_once "../Artichow/Pie.class.php";

	// Init all data
	$data = array($_GET['dataA'], $_GET['dataB']);
	$legend_color = array(hex2color("#".$_GET['colorA']), hex2color("#".$_GET['colorB']));
	$legend_label = array($_GET['labelA'], $_GET['labelB']);
	$x = $_GET["coord_x"];
	$y = $_GET["coord_y"];
	$servicename = $_GET['sn'];
	$font_color = hex2color("#".$_GET["fontcolor"]);
	$theme = $_GET["theme"];

	$graph = new Graph($x, $y);
	$graph->setBackgroundGradient(
	    new LinearGradient(
	        new White,
	        new VeryLightGray(40),
	        0
	    )
	);
	$graph->title->set($servicename, $font_color);
	$graph->title->setfont(new TuffyBold(12));
	$graph->shadow->setSize(5);
	$graph->shadow->smooth(TRUE);
	$graph->shadow->setPosition(4);
	$graph->shadow->setColor(new DarkGray);

	$plot = new Pie($data,$legend_color);
	$plot->setCenter(0.30, 0.55);
	$plot->setSize(0.55, 0.6);
	$plot->set3D(10);
	$plot->setBorder(new White);
	$plot->setLabelPosition(5);
	$plot->explode(array(1 => 15, 2 => 15, 3 => 15, 4 => 15));

	$plot->setLegend($legend_label);

	$plot->legend->setPosition(1.75);
	$plot->legend->shadow->setSize(2);
	$plot->legend->shadow->smooth(TRUE);
	$plot->legend->shadow->setPosition(4);
	$plot->legend->shadow->setColor(new DarkGray);
	$plot->legend->setBackgroundColor(new LightYellow(60));

	$graph->add($plot);
	$graph->draw();

	function hex2color($couleur = "#000000"){
		$R = substr($couleur, 1, 2);
		$rouge = hexdec($R);
		$V = substr($couleur, 3, 2);
		$vert = hexdec($V);
		$B = substr($couleur, 5, 2);
		$bleu = hexdec($B);
		return new Color($rouge, $vert, $bleu);
	}

?>