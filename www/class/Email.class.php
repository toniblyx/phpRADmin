<?
/** 
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Julien Mathis - Romain Le Merlus

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

class Email{

  // Attributes

  var $email;

  // Associations

  // Operations

  function Email($email)  {
	$this->email = $email;
  }

  function check()  {
	//if (!preg_match("/^[-a-z0-9\._]+@[-a-z0-9\.]+[.]+[-a-z]+$/i", $this->email))
	//	return false;
	return true;
  }

  function get_email()  {
	return $this->email;
  }
  
  function set_email($email)  {
	$this->email = $email;
  }
} /* end class Email */
?>
