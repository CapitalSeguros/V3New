<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Seguimiento extends TIC_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('seguimiento_model', 'seguimiento');
        // include APPPATH . 'third_party/TC/Chart.php';
    }

    public function getSeguimiento()
    {
        $id = $this->input->get('id');
        $referencia = $this->input->get('referencia');

        $data = $this->seguimiento->selectByParams($referencia, $id);

        $this->responseJSON("200", "Éxito", $data);
    }
}
