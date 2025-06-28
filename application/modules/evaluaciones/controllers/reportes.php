<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class reportes extends TIC_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('cookie');
        $this->load->model('reportesmodel', 'reportes_model');
        $this->load->library('graficos');
    }

    public function reporte()
    {
        $head = array("title" => "Capsys - Reportes");
        $data = array();
        $footer = array();
        $this->breadcrumbs->push('Reportes', 'reportes/reporte');
        $this->breadcrumbs->unshift('Reportes', 'reportes/reporte');
        $this->breadcrumbs->unshift('Inicio', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();

        $this->render('reportes/reporte', $head, $data, $footer);
    }

    public function getreporteevaluacion()
    {
        header('Content-Type: application/json');
        $data = $this->reportes_model->getreporteevaluacion();
        echo json_encode($this->response("200", "Éxito", $data));
    }


    public function getreporteprueba()
    {        
        $data = $this->reportes_model->getreporteincidencia();  
        //$data = $this->reportes_model->getreporteevaluacion();

        //if (count($data) > 0) {
            print_r($this->graficos->render("INCIDENCIAS_FALTAS",$data));
            // $this->graficos->render("INCIDENCIAS_FALTAS2", $data);
            // $this->graficos->render("INCIDENCIAS_FALTAS3", $data);
        //}
    }
}
