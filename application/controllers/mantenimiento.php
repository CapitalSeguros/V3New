<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
set_include_path(get_include_path() . PATH_SEPARATOR . './Classes/');

class mantenimiento extends CI_Controller{
	function index(){
		print("En Mantenimiento ...");
	}
}
/* End of file monitores.php */
/* Location: ./application/controllers/monitores.php */