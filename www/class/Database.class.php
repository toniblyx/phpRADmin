<?
/*
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)
For information : toni@blyx.com
*/

class Database
{
	
	// Attributes
	
	var $host;	
	
	var $user;	
	
	var $password;	
	
	var $db;	
	
	var $result;	
	
	var $res;	
	
	// Associations
	
	// Operations
	
	function Database($host, $user, $password, $db)
	{
	$this->host = $host;
	$this->user = $user;
	$this->password = $password;
	$this->db = $db;
	$this->res = 0;
	$this->result = false;
	}
	
	function connect()	{
	
	}
	
	function query($query)	{
	
	}
	
	function result_num_rows()	{
	
	}
	
	function fetch_row()	{
	
	}
	
	function close()	{
	
	}
  
	/**
	 *	@return last inserted id
	 */
	 
	function get_last_id () {}
	
} /* end class Database */
?>
