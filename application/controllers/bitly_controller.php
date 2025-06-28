<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class bitly_controller extends CI_Controller
{
	private $quitarBitly	= array('<p>', '</p>', '<br />', ',');
	private $ponerBitly	= array('', '', '\n\r', '');
	
	function __construct()
	{
		parent::__construct();		
		$this->load->model('bitly_model');
	}


	function index()
	{	
		if (!$this->tank_auth->is_logged_in()){
			redirect('/auth/login/');
		} else {
			
		}
	}/* !index */
	
	// $this->bitly_model->linkCorto($documentos->PathWWW)
	
	function getLinkCorto(){
		//Variables
		$linkLargo	= $_REQUEST['linkLargo'];
		
		if($linkLargo != "" && $linkLargo!=false){
			$linkCorto	= $this->bitly_model->linkCorto($linkLargo);
		} else {
			$linkCorto	= NULL;
		}

		return
			print(json_encode($linkCorto));
	}
}
