<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*//**  A class that represents LCA 
     *  	Liste des controles d'accès
     *    
     *     
     */
class Lca
{

  // Attributes
  var $id;
  var $user_id;
  var $comment;
  var $downtime;
  var $watch_log;
  var $traffic_map;
  var $admin_server;
  var $restrict;

  // Associations

  // Operations

  function Lca($lca)
  {
  	$this->id = $lca["id"];
	$this->user_id = $lca["user_id"];
	$this->comment = $lca["comment"];
	$this->downtime = $lca["downtime"];
	$this->view_log = $lca["watch_log"];
	$this->trafic_map = $lca["traffic_map"];
	$this->admin_server = $lca["admin_server"];
  	$this->restrict = array();
  }

  function get_id()
  {
	return $this->id;
  }
  
  function get_user_id()
  {
	return $this->user_id;
  }
  
  function get_comment()
  {
	return $this->comment;
  }
  
  function get_downtime()
  {
	return $this->downtime;
  }
  
  function get_watch_log()
  {
	return $this->view_log;
  }
  
  function get_traffic_map()
  {
	return $this->trafic_map;
  }
  
  function get_admin_server()
  {
	return $this->admin_server;
  }
  
  function get_restrict($id)
  {
	return $this->restrict[$id];
  }
  
} /* end class LCA */

class Lca_hosts
{
  // Attributes
  var $id;
  var $right;
  
  function Lca_hosts($lca_host)
  {
  		$this->id = $lca_host["host_host_id"];
		$this->right = $lca_host["lca_right"];				
  }
  
  function get_id()
  {
  	return $this->id;
  }
  
  function get_right()
  {
  	return $this->right;
  }
  
  function set_id($id)
  {
  	$this->id = $id;
  }
}
?>
