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

class TrafficMap
{

  // Attributes

  var $id;

  var $name;

  var $width;

  var $height;

  var $keyxpos;

  var $keyypos;

  var $dateTM;

  var $background;

  // Associations

  /**
     *
     * @element-type Host
   */
  var $TMHosts; // host_object_array

  var $TMrelations;

  // Operations

	function TrafficMap($tm)
  	{
		$this->id = $tm["tm_id"];
		$this->name = str_replace($_SESSION["oreon"]->Nagioscfg->get_illegal_object_name_chars_array(), "", $tm["tm_name"]);
		$this->width = $tm["tm_width"];
		$this->height = $tm["tm_height"];
		$this->keyxpos = $tm["tm_keyxpos"];
		$this->keyypos = $tm["tm_keyypos"];
		$this->dateTM = $tm["tm_date"];
		$this->background = $tm["tm_background"];
		$this->TMHosts = array();
		$this->TMrelations = array();
  	}

	function is_complete()	{
		if (!$this->name)
			return false;
		if (!$this->dateTM)
			return false;
		return true;
	}

	function twiceTest($tms)
 	{
		if (isset($tms) && count($tms))
			foreach($tms as $tm)
				if (!strcmp($this->get_name(), $tm->get_name()))
					if ($this->get_id() != $tm->get_id())
						return false;
		return true;
	}

	function get_id()	{
		return $this->id;
	}

	function get_name()	{
		return stripslashes($this->name);
	}

	function get_dateTM()	{
		return $this->dateTM;
	}

	function get_width()	{
		return $this->width;
	}

	function get_height()	{
		return $this->height;
	}

	function get_keyxpos()	{
		return $this->keyxpos;
	}

	function get_keyypos()	{
		return $this->keyypos;
	}

	function get_background()	{
		return $this->background;
	}

	function set_id($id)	{
		$this->id = $id;
	}

	function set_name($name)	{
		$this->name = $name;
	}

	function set_width($width)	{
		$this->width = $width;
	}

	function set_height($height)	{
		$this->height = $height;
	}

	function set_keyxpos($keyxpos)	{
		$this->keyxpos = $keyxpos;
	}

	function set_keyypos($keyypos)	{
		$this->keyypos = $keyypos;
	}

	function set_dateTM($dateTM)	{
		$this->dateTM = $dateTM;
	}

	function set_background($background)	{
		$this->background = $background;
	}

} /* end class Traffic Map*/

class TrafficMapHost
{

  // Attributes

  var $id;

  var $label;

  var $trafficMap;

  var $x;

  var $y;

  var $host;

  var $service;

  // Operations

	function TrafficMapHost($tmh)
  	{
		$this->id = $tmh["tmh_id"];
		$this->label = str_replace($_SESSION["oreon"]->Nagioscfg->get_illegal_object_name_chars_array(), "", $tmh["tmh_label"]);
		$this->trafficMap = $tmh["trafficMap_tm_id"];
		$this->x = $tmh["tmh_x"];
		$this->y = $tmh["tmh_y"];
		$this->host = $tmh["host_host_id"];
		$this->service = $tmh["service_service_id"];
  	}

	function is_complete()	{
		if (!$this->label)
			return false;
		if (!$this->x)
			return false;
		if (!$this->y)
			return false;
		if ($this->host == -1)
			return true;
		if (!$this->host)
			return false;
		return true;
	}

	function twiceTest($tm)	{
		if (isset($tm->TMHosts))
			foreach ($tm->TMHosts as $TMHost)
				if ($TMHost->get_host() == $this->host)
					if ($TMHost->get_service() == $this->service)
						if ($TMHost->get_id() != $this->get_id())
							return false;
		return true;
	}

	function get_id()	{
		return $this->id;
	}

	function get_label()	{
		return stripslashes($this->label);
	}

	function get_trafficMap()	{
		return $this->trafficMap;
	}

	function get_x()	{
		return $this->x;
	}

	function get_y()	{
		return $this->y;
	}

	function get_host()	{
		return $this->host;
	}

	function get_service()	{
		return $this->service;
	}

	function set_id($id)	{
		$this->id = $id;
	}

	function set_label($label)	{
		$this->label = $label;
	}

	function set_dateTM($dateTM)	{
		$this->dateTM = $dateTM;
	}

	function set_trafficMap($trafficMap)	{
		$this->trafficMap = $trafficMap;
	}

	function set_x($x)	{
		$this->x = $x;
	}

	function set_y($y)	{
		$this->y = $y;
	}

	function set_host($host)	{
		$this->host = $host;
	}

	function set_service($service)	{
		$this->service = $service;
	}

} /* end class TrafficMapHost */

class trafficMapRelation	{

	var $id;
	var $trafficMap;
	var $TMHost1;
	var $TMHost2;
	var $bin;
	var $bout;

	function trafficMapRelation($tmr)	{
		$this->id = $tmr["tmhr_id"];
		$this->trafficMap = $tmr["trafficMap_tm_id"];
		$this->TMHost1 = $tmr["trafficMap_host_tmh_id"];
		$this->TMHost2 = $tmr["trafficMap_host_tmh_id2"];
		$this->bin = $tmr["tmhr_bin"];
		$this->bout = $tmr["tmhr_bout"];
	}

	function isComplete()	{
		if (!$this->TMHost1)
			return false;
		if (!$this->TMHost2)
			return false;
		if (!$this->trafficMap)
			return false;
		if ($this->TMHost1 == $this->TMHost2)
			return false;
		return true;
	}

	function twiceTest($tms)	{
		if (isset($tms[$this->trafficMap]->TMrelations) && count($tms[$this->trafficMap]->TMrelations))
			foreach($tms[$this->trafficMap]->TMrelations as $relation)	{
				if ($relation->TMHost1 == $this->TMHost1 && $relation->TMHost2 == $this->TMHost2)
					if ($relation->get_id() != $this->get_id())
						return false;
				if ($relation->TMHost2 == $this->TMHost1)
					return false;
				if ($relation->TMHost1 == $this->TMHost2)
					return false;
				if ($relation->TMHost1 == $this->TMHost1)
					if ($relation->get_id() != $this->get_id())
						return false;
			}
		return true;
	}

	function get_id()	{
		return $this->id;
	}

	function get_trafficMap()	{
		return $this->trafficMap;
	}

	function get_TMHost1()	{
		return $this->TMHost1;
	}

	function get_TMHost2()	{
		return $this->TMHost2;
	}

	function get_bin()	{
		return $this->bin;
	}

	function get_bout()	{
		return $this->bout;
	}

	function set_id($id)	{
		$this->id = $id;
	}
}
?>