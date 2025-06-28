<?php
require_once("fileuploader.php");
class localfileuploader extends fileuploader
{
    // ensure your HTTP server instance can write to this path.
    // e.g., for Apache
    //     chmod 0774 assets/upload/images/
    //     chown www-data:www-data assets/upload/images/
    const IMAGE_UPLOAD_DIR =  'files';
    const IMAGE_UPLOAD_DIR2 = 'assets/img/miInfo/userPhotos';

    public function __construct()
    {
        $this->_supported_extensions = array('jpg', 'jpeg', 'gif', 'png', 'pdf');
    }

    /**
     * Move uploaded file to the storage directory only if its MIME type is
     * accepted.
     *
     * @param $temp_location $_FILES array entry w/ details of local file.
     * @throws Exception When there are issues moving file to upload directory.
     */
    public function moveFile($temp_location)
    {
        $filename = basename($temp_location['name']);
        $info = pathinfo($filename);
        $ext = strtolower($info['extension']);

        if (isset($temp_location['tmp_name']) &&
            isset($info['extension']) &&
            in_array($ext, $this->_supported_extensions)) {
            // $new_file_path = self::IMAGE_UPLOAD_DIR .'/'. $filename;
            $new_file_path = self::IMAGE_UPLOAD_DIR . DIRECTORY_SEPARATOR  .  $this->sanear_string ($filename);
            if (!is_dir(self::IMAGE_UPLOAD_DIR) ||
                !is_writable(self::IMAGE_UPLOAD_DIR)) {
                // Attempt to auto-create upload directory.
                // if (!is_writable(self::IMAGE_UPLOAD_DIR) ||
                //     FALSE === @mkdir(self::IMAGE_UPLOAD_DIR, null , TRUE)) {
                //     throw new Exception('Error: File permission issue, ' .
                //         'please consult your system administrator');
                // }
            }

            if (move_uploaded_file($temp_location['tmp_name'], $new_file_path)) {
                return '/' . $new_file_path;
            }
        }

        throw new Exception('File could not be uploaded.');
    }

    public function moveFileB($temp_location,$name)
    {
        $filename = basename($temp_location['name']);
        $info = pathinfo($filename);
        // $ext = strtolower($info['extension']);

        if (isset($temp_location['tmp_name'])) 
            {
            $new_file_path = self::IMAGE_UPLOAD_DIR2 .'/'. $name.'.jpg';
            if (!is_dir(self::IMAGE_UPLOAD_DIR2) ||
                !is_writable(self::IMAGE_UPLOAD_DIR2)) {
                // Attempt to auto-create upload directory.
                // if (!is_writable(self::IMAGE_UPLOAD_DIR) ||
                //     FALSE === @mkdir(self::IMAGE_UPLOAD_DIR, null , TRUE)) {
                //     throw new Exception('Error: File permission issue, ' .
                //         'please consult your system administrator');
                // }
            }

            if (move_uploaded_file($temp_location['tmp_name'], $new_file_path)) {
                return '/' . $new_file_path;
            }
        }

        throw new Exception('File could not be uploaded.');
    }
	/**
	 * Reemplaza todos los acentos por sus equivalentes sin ellos
	 *
	 * @param $string
	 *  string la cadena a sanear
	 *
	 * @return $string
	 *  string saneada
	 */
	function sanear_string($string)
	{
	 
		$string = trim($string);
	 
		$string = str_replace(
			array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
			array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
			$string
		);
	 
		$string = str_replace(
			array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
			array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
			$string
		);
	 
		$string = str_replace(
			array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
			array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
			$string
		);
	 
		$string = str_replace(
			array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
			array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
			$string
		);
	 
		$string = str_replace(
			array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
			array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
			$string
		);
	 
		$string = str_replace(
			array('ñ', 'Ñ', 'ç', 'Ç'),
			array('n', 'N', 'c', 'C',),
			$string
		);
	 
		//Esta parte se encarga de eliminar cualquier caracter extraño
		//"·",
		//".",
		$string = str_replace(
			
			array("\\","¨", "º", "-", "~","#",
				 "@", "|", "!", "\"", "$", "%", "&", "/",
				 "(", ")", "?", "'", "¡",
				 "¿", "[", "^", "<code>", "]",
				 "+", "}", "{", "¨", "´",
				 ">", "< ", ";", ",", ":",
				  " "),
			'',
			$string
		);
	 
	 
		return $string;
	}

}
?>