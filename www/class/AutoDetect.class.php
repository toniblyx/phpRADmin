<?
/*
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)
For information : toni@blyx.com
*/

/**  A class that represents ...
     *  
     *     @see OtherClasses
     *     @author your_name_here
     */
class	Detected
{
	var $id;
	var $ip;
	var $dns;
	var $check;
	var $port_list;
	var $type_list;
	var $name_list;
	var $check_list;

	function Detected($ip, $dns, $id)
	{
		$this->ip = $ip;
		$this->id = $id;
		$this->dns = $dns; 
		$this->check = "0"; 
		$this->port_list = array();
		$this->type_list = array();
		$this->name_list = array();
		$this->check_list = array();
	}
	
	// Get function
	
	function get_id(){
		return $this->id;
	} 
	function get_ip(){
		return $this->ip;
	} 
	function get_dns(){
		return $this->dns;
	} 
	function get_check(){
		return $this->check;
	} 
	
	// Set fonction 
	
	function set_ip($ip){
		$this->ip = $ip;
	} 
	function set_dns($dns){
		$this->dns = $dns;
	} 
	function set_check($check){
		$this->check = $check;
	} 
	
	
}
?>
