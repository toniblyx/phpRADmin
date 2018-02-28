<?
/*
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)
For information : toni@blyx.com
*/

class MySqlDatabase extends Database	{

	// Operations
	/**
	 *  Connect to the database
	 *
	 */
	function connect () {
		// Connecting server
      	$this->res = mysql_connect($this->host, $this->user, $this->password) or die("Error while connecting the sql server: ".mysql_error());
        // Selecting database
        mysql_select_db($this->db) or die("Error while selecting database: ".mysql_error());

	}
	
	/**
	 *  Query the database
	 *
	 */
	function query ($query) {
		if (!$this->res)
			$this->connect();
	
		$this->result = mysql_query($query, $this->res) or die("Error when query the database: ".mysql_error()."\nQuery: $query");
		return $this->result;
	}
	
	/**
	 *  Returns the number of rows in the result
	 *
	 */
	function result_num_rows () {
      if ($this->result)
		return mysql_num_rows($this->result);
      return 0;
	}
	
	/**
	 *  Fetch the result array
	 *
	 */
	function fetch_array () {
      if ($this->result)
		return mysql_fetch_array($this->result);
      return 0;
	}
	
	/**
	 *  Fetch the result row
	 *
	 */
	function fetch_row() {
      if ($this->result)
		return mysql_fetch_row($this->result);
      return 0;
	}
	
	/**
	 *  Close the database
	 *
	 */
	function close () {
      if ($this->res)
		  mysql_close($this->res) or die(mysql_error());
	}
	
	/**
	 *	@return last inserted id
	 */
	function get_last_id () {
		return mysql_insert_id($this->res);
	}

} /* end class MySqlDatabase */
?>
