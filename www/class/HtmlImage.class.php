<?
/*
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)
For information : toni@blyx.com
*/
class HtmlImage {
	var $name;
	
	var $type;
	
	var $cid;
	
	/**
	 *	complete path to the image
	 */
	var $path;
	
	/**
	 *	image encoding in base64
	 */
	var $b64coding;
	
	function HtmlImage ($name, $cid, $type, $path, $b64coding) {
		$this->name = str_replace($_SESSION["oreon"]->Nagioscfg->get_illegal_object_name_chars_array(), "", $name);
		$this->name = str_replace(" ", "_", $this->name);
		$this->cid = $cid;
		$this->type = $type;
		$this->path = $path;
		$this->b64coding = chunk_split($b64coding, 72);
		
		// all in lower case for type
		if (!strcasecmp($this->type, "image/jpg") || !strcasecmp($this->type, "image/jpeg"))
			$this->type = "image/jpeg";
		 if (!strcasecmp($this->type, "image/gif"))
			$this->type = "image/gif";
	}
	
	/**
	 *	Static function
	 *	return only printable characters
	 */
	function kill_accent_space($s) {
		$t = "";
		for ($i = 0, $m = strlen($s); $i < $m; $i++) {
			$c = ord($s[$i]);
			if ($c > 127) // convert only special chars
				$t .= "_";
			else
				$t .= chr($c);
		}
		return ereg_replace("[ \t\n\r]", "", $t);
	}
	
	function get_name () {
		return $this->name;
	}
	
	function get_type () {
		return $this->type;
	}
	
	function get_cid () {
		return $this->cid;
	}
	
	function get_b64coding () {
		if (!$this->b64coding) {
			$fd = fopen($this->path, "rb");
			$this->b64coding = chunk_split(base64_encode(fread($fd, filesize($this->path))), 72);
			fclose($fd);
		}
		return $this->b64coding;			
	}
}
?>