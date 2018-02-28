<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/class optGen
{

  // Attributes

  	var $radius_pwd;
  	var $radius_bin_pwd;
	var $phpradmin_pwd;
	var $refresh;
	var $rrd_pwd;
	var $dictionary_path;
	var $session_expire;
	var $startup_script;
	var $sudo_bin_path;
	var $system_log_path;
	var $radius_log_path;

  // Operations

  function optGen($opt)  {
	$this->radius_pwd = rtrim($opt["radius_pwd"], "/")."/";
	$this->radius_bin_pwd = rtrim($opt["radius_bin_pwd"], "/")."/";
	$this->phpradmin_pwd = rtrim($opt["phpradmin_pwd"], "/")."/";
	$this->refresh = $opt["refresh"];
	$this->rrd_pwd = rtrim($opt["rrd_pwd"], "/");
	$this->session_expire = $opt["session_expire"];
	$this->startup_script = rtrim($opt["startup_script"], "/");
	$this->sudo_bin_path = rtrim($opt["sudo_bin_path"], "/");
	$this->system_log_path = rtrim($opt["system_log_path"], "/");
	$this->radius_log_path = rtrim($opt["radius_log_path"], "/");
	$this->dictionary_path = rtrim($opt["dictionary_path"], "/")."/";
}

  function get_radius_pwd()	{
	return stripslashes($this->radius_pwd);
  }
  function get_radius_bin_pwd()	{
	return stripslashes($this->radius_bin_pwd);
  }
  function get_phpradmin_pwd()	{
	return stripslashes($this->phpradmin_pwd);
  }
  function get_refresh()	{
	return stripslashes($this->refresh);
  }
  function get_rrd_pwd()	{
	return stripslashes($this->rrd_pwd);
  }
  function get_dictionary_path()	{
	return stripslashes($this->dictionary_path);
  }
  function get_sudo_bin_path()	{
	return stripslashes($this->sudo_bin_path);
  }
  function get_session_expire()	{
	return stripslashes($this->session_expire);
  }
  function get_startup_script()	{
	return stripslashes($this->startup_script);
  }
  function get_system_log_path()	{
	return stripslashes($this->system_log_path);
  }
  function get_radius_log_path()	{
	return stripslashes($this->radius_log_path);
  }
  function is_valid_path($path)	{
	if (is_dir($path) )  {
	    $style = '';
	} else {
	    $style = 'class="invalid_path"';
	}
	return $style;
  }
  function is_readable_directory($path)	{
	$style = $this->is_valid_path($path);
	if ($style == '') {
	    if (is_readable($path) )  {
		$style = '';
	    } else {
		$style = 'class="unreadable_path"';
	    }
	} else {
	    $style = 'class="invalid_path"';
	}
	return $style;
  }
  function is_executable_binary($path)	{
	if (is_file($path)) {
	    if (is_executable($path) )  {
		$style = '';
	    } else {
		$style = 'class="unexecutable_binary"';
	    }
	} else {
	    $style = 'class="invalid_path"';
	}
	return $style;
  }
  function is_writable_path($path)	{
	$style = $this->is_valid_path($path);
	if ($style == '') {
	    if (is_writable($path) )  {
		$style = '';
	    } else {
		$style = 'class="unwritable_path"';
	    }
	}
	return $style;
  }
  function is_writable_file($path)	{
	if (is_file($path)) {
	    if (is_writable($path) )  {
		$style = '';
	    } else {
		$style = 'class="unwritable_path"';
	    }
	} else {
	    $style = 'class="invalid_path"';
	}
	return $style;
  }

} /* end class optGen */
?>
