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
	if (isset($_GET['dataE'])){
		$data = array($_GET['dataA'], $_GET['dataB'], $_GET['dataC'], $_GET['dataD'], $_GET['dataE']);
		$legend_color = array(hex2color("#".$_GET['colorA']), hex2color("#".$_GET['colorB']), hex2color("#".$_GET['colorC']), hex2color("#".$_GET['colorD']), hex2color("#".$_GET['colorE']));
		$legend_label = array($_GET['labelA'], $_GET['labelB'], $_GET['labelC'], $_GET['labelD'], $_GET['labelE']);
	} else {
		$data = array($_GET['dataA'], $_GET['dataB'], $_GET['dataC'], $_GET['dataD']);
		$legend_color = array(hex2color("#".$_GET['colorA']), hex2color("#".$_GET['colorB']), hex2color("#".$_GET['colorC']), hex2color("#".$_GET['colorD']));
		$legend_label = array($_GET['labelA'], $_GET['labelB'], $_GET['labelC'], $_GET['labelD']);
	}
	$x = $_GET["coord_x"];
	$y = $_GET["coord_y"];
	$servicename = $_GET['sn'];
	$font_color = hex2color("#".$_GET["fontcolor"]);
	$theme = $_GET["theme"];

	$graph = new Graph($x, $y);
	$graph->setAntiAliasing(TRUE);
	/*
		$graph->setBackgroundGradient(
	    new LinearGradient(
	        new White,
	        new VeryLightGray(40),
	        0
	    )
	);
	*/
	$graph->title->set($servicename, $font_color);
	$graph->title->setfont(new TuffyBold(12));
	$graph->shadow->setSize(5);
	$graph->shadow->smooth(TRUE);
	$graph->shadow->setPosition(4);
	$graph->shadow->setColor(new DarkGray);

	$plot = new Pie($data,$legend_color);
	$plot->setCenter(0.30, 0.55);
	$plot->setSize(0.55, 0.92);
	$plot->set3D(10);
	//$plot->setStartAngle(180);
	//$plot->setBorder(new Black);
	$plot->setLabelPosition(-20);
	$plot->label->setPadding(2, 2, 2, 2);
	$plot->label->setBackgroundColor(new White(60));
	$plot->explode(array(1 => 10, 2 => 10, 3 => 10, 4 => 10));

	$plot->setLegend($legend_label);

	//$plot->setAbsSize(120, 120);
	//$plot->setBorder(new White);

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