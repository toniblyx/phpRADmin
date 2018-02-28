<?
/*
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)
For information : toni@blyx.com
*/

class ProfileHost	{
	var $host;
	var $location;
	var $contact;
	var $os;
	var $uptime;
	var $ram;
	var $update;
	
	var $netInterfaces;
	var $disks;
	var $softwares;
	var $softwaresUP;
	
	function ProfileHost($host_id)	{
		$this->host = $host_id;
		$this->netInterfaces = array();
		$this->disks = array();
		$this->softwares = NULL;
		$this->softwaresUp = NULL;
	}
	
	function get_host()	{
		return $this->host;
	}
	
	function get_location()	{
		return $this->location;
	}

	function get_contact()	{
		return $this->contact;
	}
		
	function get_os()	{
		return $this->os;
	}

	function get_uptime()	{
		return $this->uptime;
	}

	function get_ram()	{
		return $this->ram;
	}

	function get_update()	{
		return $this->update;
	}

	function get_softwares()	{
		return $this->softwares;
	}

	function get_softwaresUP()	{
		return $this->softwares;
	}
		
	function set_host($host)	{
		$this->host = $host;
	}
		
	function set_location($location)	{
		$this->location = $location;
	}

	function set_contact($contact)	{
		$this->contact = $contact;
	}
		
	function set_os($os)	{
		$this->os = $os;
	}

	function set_uptime($uptime)	{
		$this->uptime = $uptime;
	}

	function set_ram($ram)	{
		$this->ram = $ram;
	}

	function set_update($update)	{
		$this->update = $update;
	}
}

class NetInterface
{
	var $id;
	var $host;
	var $ip;
	var $speed;
	var $model;
	var $mac;
	var $status;
	
	function NetInterface($ni)	{
		$this->id = $ni["pi_id"];
		$this->host = $ni["host_host_id"];
		$this->ip = $ni["pi_ip"];
		$this->speed = $ni["pi_speed"];
		$this->model = $ni["pi_model"];
		$this->mac = $ni["pi_mac"];
	}
		
	function get_id()	{
		return $this->id;
	}
		
	function get_host()	{
		return $this->host;
	}
	
	function get_ip()	{
		return $this->ip;
	}

	function get_speed()	{
		return $this->speed;
	}

	function get_model()	{
		return $this->model;
	}

	function get_mac()	{
		return $this->mac;
	}
	
	function get_status()	{
		return $this->status;
	}

	function set_id($id)	{
		$this->id = $id;
	}
	
	function set_host($host)	{
		$this->host = $host;
	}
	
	function set_ip($ip)	{
		$this->ip = $ip;
	}
	
	function set_speed($speed)	{
		$this->speed = $speed;
	}
	
	function set_mac($mac)	{
		$this->mac = $mac;
	}
		
	function set_model($model)	{
		$this->model = $model;
	}
		
	function set_status($status)	{
		$this->status = $status;
	}
}

class Disk
{
	var $id;
	var $host;
	var $name;
	var $space;
	var $used_space;
	var $free_space;
  
  	function Disk($dk)	{
		$this->id = $dk["pdisk_id"];
		$this->host = $dk["host_host_id"];
		$this->name = $dk["pdisk_name"];
		$this->space = $dk["pdisk_space"];
		$this->used_space = $dk["pdisk_used_space"];
		$this->free_space = $dk["pdisk_free_space"];
	}
	
	function get_id()	{
		return $this->id;
	}
	
	function get_host()	{
		return $this->host;
	}
	
	function get_name()	{
		return $this->name;
	}

	function get_space()	{
		return $this->space;
	}
		
	function get_used_space()	{
		return $this->used_space;
	}

	function get_free_space()	{
		return $this->free_space;
	}

	function set_id($id)	{
		$this->id = $id;
	}

	function set_host($host)	{
		$this->host = $host;
	}

	function set_name($name)	{
		$this->name = $name;
	}

	function set_space($space)	{
		$this->space = $space;
	}
		
	function set_used_space($used_space)	{
		$this->used_space = $used_space;
	}

	function set_free_space($free_space)	{
		$this->free_space = $free_space;
	}
}
 /* end class Profile_host */
?>