<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Inicio extends TIC_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library(array('session'));
        $this->lang->load('tank_auth');
    }

    public function index()
    {
        $head = array('title' => 'Capsys - Inicio');
        $data = array();
        $footer = array();
        $data["url"]=$this->tank_auth->get_idPersonaPuesto();
        $this->render('validation/inicio', $head, $data, $footer);
    }

   
}
