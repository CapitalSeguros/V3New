<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class capsysDre extends CI_Model { 
	function __construct(){
		parent::__construct();
	}

	function ConfiguracionAddUsuarios(){
		
		$data = array(
						'username' => $username
					 );

		$this->db->insert('users', $data);
	} /*! ConfiguracionAddUsuarios */
}