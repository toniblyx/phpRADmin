<?
/**
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Christophe Coraboeuf

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
/**  A class that represents Color
     *  	Classe de Couleur pour les graphs
     *
     *
     */
class Colors
{
	var $id;
	var $color_value;

	function Colors($color){
		$this->id = $color["color_id"];
		$this->color_value = $color["hex"];
	}

	function get_color_id(){
		return $this->id;
  	}

	function get_color(){
		return strtoupper($this->color_value);
	}

  	function is_dark_color()
  	{
    	$color =  $this->color_value;
    	$rgb = array(substr($color,0,2), substr($color,2,2), substr($color,4,2));
		$brightness = ((hexdec($rgb[0]) * 299) + (hexdec($rgb[1]) * 587) + (hexdec($rgb[2]) * 114)) / 1000;
		if ( $brightness < 130  )
			$is_dark = true;
		else
			$is_dark = false;
		return $is_dark;
  	}

  	function set_id($id)	{
		$this->id = $id;
	}

} /* end class Color */
?>