<?
/*
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)
For information : toni@blyx.com
*/

class User_status
{
	var $user_id;
	var $current_page;
	var $last_reload;
	
	function User_status($user_status_array)
	{
		$this->user_id = $user_status_array["user_id"];
		$this->last_reload = $user_status_array["last_reload"];
		$this->current_page = $user_status_array["current_page"];
	}
	
	function get_user_id(){
		return $this->user_id;
	}
	function get_current_page(){
		return $this->current_page;
	}
	function get_last_reload(){
		return $this->last_reload; 
	}
}

class User
{

  // Attributes

  var $user_id;

  var $firstname;
  
  var $lastname;
  
  var $alias;

  var $passwd;

  var $ppasswd;
  
  var $email;
  
  var $status;
  
  var $lang;
  
  var $version;
  
  var $errCode;
    
  // Variables de l'interface
  
  var $refresh;
  
  // For stat 
  
  var $Host_health;
  
  var $Service_health;	

  // Associations

  var $reload_object;
  
  // Operations

  function User($user)  {
  	$illegal_chars = array(0=>"'", 1=>"\"");
	$this->user_id = $user["user_id"];
	$this->firstname = str_replace($illegal_chars, "", $user["user_firstname"]);
	$this->lastname = str_replace($illegal_chars, "", $user["user_lastname"]);
	$this->alias = str_replace($illegal_chars, "", $user["user_alias"]);
	$this->email = new Email ($user["user_mail"]);
	$this->status = $user["user_status"];
	$this->lang = $user["user_lang"];
	$this->version = $user["user_version"];
	$this->errCode= true;
	$this->relaod_object = array();
  }
  
  	function is_complete()	{
		$this->errCode = -2;
		if (!$this->firstname)
			return false;
		if (!$this->lastname)
			return false;
		if (!$this->alias)
			return false;
		if (!$this->email || !$this->email->check())	{
			$this->errCode = -4;
			return false;
		}
		$this->errCode= true;			
		return true;
	}

	function twiceTest($users) 	{
		$this->errCode = -3;
		if (isset($users) && count($users))
			foreach($users as $user)	{
				if (!strcmp($this->get_alias(), $user->get_alias()))
					if ($this->get_id() != $user->get_id())
						return false;
			}
		$this->errCode= true;
		return true;
	}
		
  // Get
  
  function get_id(){
  	return $this->user_id;
  }
  
  function get_firstname(){
  	return stripslashes($this->firstname);
  }
  
  function get_lastname(){
  	return stripslashes($this->lastname);
  }
  
  function get_passwd(){
  	return $this->passwd;
  }
  
  function get_email(){
  	return stripslashes($this->email->get_email());
  }
  
  function get_alias(){
  	return stripslashes($this->alias);
  }
  
  function get_version()	{
  	return $this->version;
  }  
  
  function get_status()	{
  	return $this->status;
  }
  
  function get_lang(){
  	return $this->lang;
  }
  
  function get_errCode(){
  	return $this->errCode;
  }
  
  // Set
  
  function set_id($id)	{
  	$this->user_id = $id;
  }
  
  function set_firstname($firstname)	{
  	$this->firstname = $firstname;
  }
  
  function set_lastname($lastname)	{
  	$this->lastname = $lastname;
  }
  
  function set_passwd($passwd)	{
  	$this->passwd = $passwd;
  }  
  
  function set_ppasswd($ppasswd)	{
  	$this->ppasswd = $ppasswd;
  }
  
  function set_email($email)	{
  	$this->email->set_email($email);
  }
  
  function set_lang($lang)	{
  	$this->lang = $lang;
  }
 
  function set_status($status)	{
  	$this->status = $status;
  }
  
  function set_alias($alias)	{
  	$this->alias = $alias;
  }
  
  function set_version($version)	{
  	$this->version = $version;
  }
  
} /* end class User */
?>
