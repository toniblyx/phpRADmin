<?
/*
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)
For information : toni@blyx.com
*/

class ImageExtendInfos {
	
	/** name of image */
	var $name;
	
	/**
	 *	@param img is an http array
	 *	example: new Image (HTTP_POST_FILES["photo"])
	 *
	 */
	function ImageExtendInfos ($img) {
		@mkdir($this->get_path_real(), 0755);
	
		// move image
		$ext = strrchr($img["name"], '.');
		do {
			$this->name = substr($img["name"], 0, strlen($img["name"]) - strlen($ext)).(rand() % 1000).$ext;
		} while (file_exists($this->get_image()));
		move_uploaded_file($img["tmp_name"], $this->get_image());
	}
	
	/**
	 *	Delete the image
	 */
	function del () {
		@unlink($this->get_image());
	}
	
	
	/** Return the complete path to the image */
	function get_image () {
		return $this->get_path_real()."/".$this->name;
	}
	
	/** Return the complete path to the image without the name of the image*/
	function get_path_image () {
		return $this->get_path_real()."/";
	}
	
	// Accessors
	function get_name () {
		return $this->name;
	}
	
	/** static */
	function get_path_real () {
		return "img/ressources";
	}
}

?>