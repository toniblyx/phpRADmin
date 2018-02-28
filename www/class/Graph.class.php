<?
/**
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Jean Baptiste Gouret - Julien Mathis - Romain Le Merlus - Christophe Coraboeuf

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

class GraphRRD
{

	// Attributes

	var $id;
	var $path;
	var $cmdline;
	var $imgformat;
	var $verticallabel;
	var $width;
  	var $height;
	var $ColGrilFond;
	var $ColFond;
	var $ColPolice;
	var $ColGrGril;
	var $ColPtGril;
	var $ColContCub;
	var $ColArrow;
	var $ColImHau;
	var $ColImBa;
	var $ds1name;
	var $ds2name;
	var $ColDs1;
	var $ColDs2;
	var $ds3name;
	var $ds4name;
	var $ColDs3;
	var $ColDs4;
	var $flamming;
	var $lowerlimit;
  	var $areads1;
	var $ticknessds1;
	var $gprintlastds1;
	var $gprintminds1;
	var $gprintaverageds1;
	var $gprintmaxds1;
	var $areads2;
	var $ticknessds2;
	var $gprintlastds2;
	var $gprintminds2;
	var $gprintaverageds2;
	var $gprintmaxds2;
	var $areads3;
	var $ticknessds3;
	var $gprintlastds3;
	var $gprintminds3;
	var $gprintaverageds3;
	var $gprintmaxds3;
	var $areads4;
	var $ticknessds4;
	var $gprintlastds4;
	var $gprintminds4;
	var $gprintaverageds4;
	var $gprintmaxds4;
	var $errCode;

	// Associations

	// Operations

	function GraphRRD($graph)	{
		$this->id = $graph["graph_id"];
		$this->path = $graph["graph_path"];
		$this->imgformat = $graph["graph_imgformat"];
		$this->verticallabel = $graph["graph_verticallabel"];
		//$this->verticallabel = str_replace($_SESSION["oreon"]->Nagioscfg->get_illegal_object_name_chars_array(), "", $graph["graph_verticallabel"]);
		//$this->verticallabel = str_replace(" ", "_", $this->verticallabel);
		$this->width = $graph["graph_width"];
		$this->height = $graph["graph_height"];
		$this->ColGrilFond = $graph["graph_ColGrilFond"];
		$this->ColFond = $graph["graph_ColFond"];
		$this->ColPolice = $graph["graph_ColPolice"];
		$this->ColGrGril = $graph["graph_ColGrGril"];
		$this->ColPtGril = $graph["graph_ColPtGril"];
		$this->ColContCub = $graph["graph_ColContCub"];
		$this->ColArrow = $graph["graph_ColArrow"];
		$this->ColImHau = $graph["graph_ColImHau"];
		$this->ColImBa = $graph["graph_ColImBa"];
		$this->ds1name = str_replace($_SESSION["oreon"]->Nagioscfg->get_illegal_object_name_chars_array(), "", $graph["graph_ds1name"]);
		//$this->ds1name = str_replace(" ", "_", $this->ds1name);
		$this->flamming = $graph["graph_flamming"];
		$this->lowerlimit = $graph["graph_lowerlimit"];
		$this->areads1 = $graph["graph_areads1"];
		$this->ticknessds1 = $graph["graph_ticknessds1"];
		$this->gprintlastds1 = $graph["graph_gprintlastds1"];
		$this->gprintminds1 = $graph["graph_gprintminds1"];
		$this->gprintaverageds1 = $graph["graph_gprintaverageds1"];
		$this->gprintmaxds1 = $graph["graph_gprintmaxds1"];
		$this->ColDs1 = $graph["graph_ColDs1"];
		if (isset($graph["graph_ds2name"])){
			$this->ds2name = str_replace($_SESSION["oreon"]->Nagioscfg->get_illegal_object_name_chars_array(), "", $graph["graph_ds2name"]);
		//	$this->ds2name = str_replace(" ", "_", $this->ds2name);
			$this->ColDs2 = $graph["graph_ColDs2"];
			$this->areads2 = $graph["graph_areads2"];
			$this->ticknessds2 = $graph["graph_ticknessds2"];
			$this->gprintlastds2 = $graph["graph_gprintlastds2"];
			$this->gprintminds2 = $graph["graph_gprintminds2"];
			$this->gprintaverageds2 = $graph["graph_gprintaverageds2"];
			$this->gprintmaxds2 = $graph["graph_gprintmaxds2"];
		} else {
			$this->ds2name = '';
			$this->ColDs2 = '';
			$this->areads2 = '';
			$this->ticknessds2 = '';
			$this->gprintlastds2 = '';
			$this->gprintminds2 = '';
			$this->gprintaverageds2 = '';
			$this->gprintmaxds2 = '';
		}
		if (isset($graph["graph_ds3name"])){
			$this->ds3name = str_replace($_SESSION["oreon"]->Nagioscfg->get_illegal_object_name_chars_array(), "", $graph["graph_ds3name"]);
			//$this->ds3name = str_replace(" ", "_", $this->ds3name);
			$this->ColDs3 = $graph["graph_ColDs3"];
			$this->areads3 = $graph["graph_areads3"];
			$this->ticknessds3 = $graph["graph_ticknessds3"];
			$this->gprintlastds3 = $graph["graph_gprintlastds3"];
			$this->gprintminds3 = $graph["graph_gprintminds3"];
			$this->gprintaverageds3 = $graph["graph_gprintaverageds3"];
			$this->gprintmaxds3 = $graph["graph_gprintmaxds3"];
		} else {
			$this->ds3name = '';
			$this->ColDs3 = '';
			$this->areads3 = '';
			$this->ticknessds3 = '';
			$this->gprintlastds3 = '';
			$this->gprintminds3 = '';
			$this->gprintaverageds3 = '';
			$this->gprintmaxds3 = '';
		}
		if (isset($graph["graph_ds4name"])){
			$this->ds4name = str_replace($_SESSION["oreon"]->Nagioscfg->get_illegal_object_name_chars_array(), "", $graph["graph_ds4name"]);
			//$this->ds4name = str_replace(" ", "_", $this->ds4name);
			$this->ColDs4 = $graph["graph_ColDs4"];
			$this->areads4 = $graph["graph_areads4"];
			$this->ticknessds4 = $graph["graph_ticknessds4"];
			$this->gprintlastds4 = $graph["graph_gprintlastds4"];
			$this->gprintminds4 = $graph["graph_gprintminds4"];
			$this->gprintaverageds4 = $graph["graph_gprintaverageds4"];
			$this->gprintmaxds4 = $graph["graph_gprintmaxds4"];
		} else {
			$this->ds4name = '';
			$this->ColDs4 = '';
			$this->areads4 = '';
			$this->ticknessds4 = '';
			$this->gprintlastds4 = '';
			$this->gprintminds4 = '';
			$this->gprintaverageds4 = '';
			$this->gprintmaxds4 = '';
		}
		$this->errCode = true;
	}

	function is_complete($version)	{
		$this->errCode = -2;
		if (!$this->path)
			return false;
		if (!$this->imgformat)
			return false;
		if (!$this->verticallabel)
			return false;
		if (!$this->width)
			return false;
		if (!$this->height)
			return false;
		if (!$this->ColGrilFond)
			return false;
		if (!$this->ColFond)
			return false;
		if (!$this->ColPolice)
			return false;
		if (!$this->ColGrGril)
			return false;
		if (!$this->ColPtGril)
			return false;
		if (!$this->ColContCub)
			return false;
		if (!$this->ColArrow)
			return false;
		if (!$this->ColImHau)
			return false;
		if (!$this->ColImBa)
			return false;
		$this->errCode = true;
		return true;
	}

	function twiceTest($graphs) 	{
		$this->errCode = -3;
		if (isset($graphs) && count($graphs))
			foreach($graphs as $graph)
				if ($this->id != $graph->get_id())
					return false;
		$this->errCode = true;
		return true;
	}

	function get_id()	{
		return $this->id;
	}

	function get_path()	{
		return stripslashes($this->path);
	}

	function get_imgformat()	{
		return $this->imgformat;
	}

	function get_verticallabel()	{
		return stripslashes($this->verticallabel);
	}

	function get_width()	{
		return $this->width;
	}

	function get_height()	{
		return $this->height;
	}

	function get_ColGrilFond()	{
		return $this->ColGrilFond;
	}

	function get_ColFond()	{
		return $this->ColFond;
	}

	function get_ColPolice()	{
		return $this->ColPolice;
	}

	function get_ColGrGril()	{
		return $this->ColGrGril;
	}

	function get_ColPtGril()	{
		return $this->ColPtGril;
	}

	function get_ColContCub()	{
		return $this->ColContCub;
	}

	function get_ColArrow()	{
		return $this->ColArrow;
	}

	function get_ColImHau()	{
		return $this->ColImHau;
	}

	function get_ColImBa()	{
		return $this->ColImBa;
	}

	function get_dsname($i)	{
		switch ($i){
			case 1: return stripslashes($this->ds1name);
			case 2: return stripslashes($this->ds2name);
			case 3: return stripslashes($this->ds3name);
			case 4: return stripslashes($this->ds4name);
		}
	}

	function get_ColDs($i)	{
		switch ($i){
			case 1: return stripslashes($this->ColDs1);
			case 2: return stripslashes($this->ColDs2);
			case 3: return stripslashes($this->ColDs3);
			case 4: return stripslashes($this->ColDs4);
		}
	}

	function get_flamming()	{
		return $this->flamming;
	}

	function get_lowerlimit()	{
		return $this->lowerlimit;
	}

	function get_areads($i)	{
		switch ($i){
			case 1: return stripslashes($this->areads1);
			case 2: return stripslashes($this->areads2);
			case 3: return stripslashes($this->areads3);
			case 4: return stripslashes($this->areads4);
		}
	}

	function get_ticknessds($i)	{
		switch ($i){
			case 1: return stripslashes($this->ticknessds1);
			case 2: return stripslashes($this->ticknessds2);
			case 3: return stripslashes($this->ticknessds3);
			case 4: return stripslashes($this->ticknessds4);
		}
	}

	function get_gprintlastds($i)	{
		switch ($i){
			case 1: return stripslashes($this->gprintlastds1);
			case 2: return stripslashes($this->gprintlastds2);
			case 3: return stripslashes($this->gprintlastds3);
			case 4: return stripslashes($this->gprintlastds4);
		}
	}

	function get_gprintminds($i)	{
		switch ($i){
			case 1: return stripslashes($this->gprintminds1);
			case 2: return stripslashes($this->gprintminds2);
			case 3: return stripslashes($this->gprintminds3);
			case 4: return stripslashes($this->gprintminds4);
		}
	}

	function get_gprintaverageds($i)	{
		switch ($i){
			case 1: return stripslashes($this->gprintaverageds1);
			case 2: return stripslashes($this->gprintaverageds2);
			case 3: return stripslashes($this->gprintaverageds3);
			case 4: return stripslashes($this->gprintaverageds4);
		}
	}

	function get_gprintmaxds($i)	{
		switch ($i){
			case 1: return stripslashes($this->gprintmaxds1);
			case 2: return stripslashes($this->gprintmaxds2);
			case 3: return stripslashes($this->gprintmaxds3);
			case 4: return stripslashes($this->gprintmaxds4);
		}
	}

	function get_errCode()	{
		return $this->errCode;
	}
	//

	function set_id($id)	{
		$this->id = $id;
	}

	function set_host($host)	{
		$this->host = $host;
	}

	function set_path($path)	{
		$this->path = $path;
	}

	function set_checkrrd($checkrrd)	{
		$this->checkrrd = $checkrrd;
	}

	function set_verticallabel($verticallabel)	{
		$this->verticallabel = $verticallabel;
	}

	function set_imgformat($imgformat)	{
		$this->imgformat = $imgformat;
	}

	function set_width($width)	{
		$this->width = $width;
	}

	function set_height($height)	{
		$this->height = $height;
	}

	function set_ColGrilFond($ColGrilFond)	{
		$this->ColGrilFond = $ColGrilFond;
	}

	function set_ColFond($ColFond)	{
		$this->ColFond = $ColFond;
	}

	function set_ColPolice($ColPolice)	{
		$this->ColPolice = $ColPolice;
	}

	function set_ColGrGril($ColGrGril)	{
		$this->ColGrGril = $ColGrGril;
	}

	function set_ColPtGril($ColPtGril)	{
		$this->ColPtGril = $ColPtGril;
	}

	function set_ColContCub($ColContCub)	{
		$this->ColContCub = $ColContCub;
	}

	function set_ColArrow($ColArrow)	{
		$this->ColArrow = $ColArrow;
	}

	function set_ColImHau($ColImHau)	{
		$this->ColImHau = $ColImHau;
	}

	function set_ColImBa($ColImBa)	{
		$this->ColImBa = $ColImBa;
	}

	function set_ds1name($ds1name)	{
		$this->ds1name = $ds1name;
	}

	function set_ds2name($ds2name)	{
		$this->ds2name = $ds2name;
	}

	function set_ColDs1($ColDs1)	{
		$this->ColDs1 = $ColDs1;
	}

	function set_ColDs2($ColDs2)	{
		$this->ColDs2 = $ColDs2;
	}

	function set_ds3name($ds3name)	{
		$this->ds3name = $ds3name;
	}

	function set_ds4name($ds4name)	{
		$this->ds4name = $ds4name;
	}

	function set_ColDs3($ColDs3)	{
		$this->ColDs3 = $ColDs3;
	}

	function set_ColDs4($ColDs4)	{
		$this->ColDs4 = $ColDs4;
	}

	function set_flamming($flamming)	{
		$this->flamming = $flamming;
	}

	function set_lowerlimit($lowerlimit)	{
		$this->lowerlimit = $lowerlimit;
	}

	function set_areads1($areads1)	{
		$this->areads1 = $areads1;
	}

	function set_ticknessds1($ticknessds1)	{
		$this->ticknessds1 = $ticknessds1;
	}

	function set_gprintlastds1($gprintlastds1)	{
		$this->gprintlastds1 = $gprintlastds1;
	}

	function set_gprintminds1($gprintminds1)	{
		$this->gprintminds1 = $gprintminds1;
	}

	function set_gprintaverageds1($gprintaverageds1)	{
		$this->gprintaverageds1 = $gprintaverageds1;
	}

	function set_gprintmaxds1($gprintmaxds1)	{
		$this->gprintmaxds1 = $gprintmaxds1;
	}

	function set_areads2($areads2)	{
		$this->areads2 = $areads2;
	}

	function set_ticknessds2($ticknessds2)	{
		$this->ticknessds2 = $ticknessds2;
	}

	function set_gprintlastds2($gprintlastds2)	{
		$this->gprintlastds2 = $gprintlastds2;
	}

	function set_gprintminds2($gprintminds2)	{
		$this->gprintminds2 = $gprintminds2;
	}

	function set_gprintaverageds2($gprintaverageds2)	{
		$this->gprintaverageds2 = $gprintaverageds2;
	}

	function set_gprintmaxds2($gprintmaxds2)	{
		$this->gprintmaxds2 = $gprintmaxds2;
	}
	//
	function set_areads3($areads3)	{
		$this->areads3 = $areads3;
	}

	function set_ticknessds3($ticknessds3)	{
		$this->ticknessds3 = $ticknessds3;
	}

	function set_gprintlastds3($gprintlastds3)	{
		$this->gprintlastds3 = $gprintlastds3;
	}

	function set_gprintminds3($gprintminds3)	{
		$this->gprintminds3 = $gprintminds3;
	}

	function set_gprintaverageds3($gprintaverageds3)	{
		$this->gprintaverageds3 = $gprintaverageds3;
	}

	function set_gprintmaxds3($gprintmaxds3)	{
		$this->gprintmaxds3 = $gprintmaxds3;
	}

	function set_areads4($areads4)	{
		$this->areads4 = $areads4;
	}

	function set_ticknessds4($ticknessds4)	{
		$this->ticknessds4 = $ticknessds4;
	}

	function set_gprintlastds4($gprintlastds4)	{
		$this->gprintlastds4 = $gprintlastds4;
	}

	function set_gprintminds4($gprintminds4)	{
		$this->gprintminds4 = $gprintminds4;
	}

	function set_gprintaverageds4($gprintaverageds4)	{
		$this->gprintaverageds4 = $gprintaverageds4;
	}

	function set_gprintmaxds4($gprintmaxds4)	{
		$this->gprintmaxds4 = $gprintmaxds4;
	}
} /* end class Graph */
?>
