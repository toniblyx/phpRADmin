<?
/*
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)
For information : toni@blyx.com
*/

class Session
{
	// Attributes
	
	// Associations
	
	// Operations
	
	function start()
	{
		session_start();
	}
	
	function stop()
	{
		session_unset();
		session_destroy();
	}
	
	function restart()
	{
		$this->stop();
		$this->start();
	}
	
	function s_unset()
	{
		session_unset();
	}
	
	function unregister_var($register_var)
	{
		session_unregister($register_var);
	}
  
	function register_var ($register_var) 
	{
		session_register($register_var);
	}
	
} /* end class Session */
?>
