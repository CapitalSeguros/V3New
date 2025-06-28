<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pruebastic extends TIC_Controller{
    function __construct()
    {
        parent::__construct();
        //$this->load->library(array('session'));
        //$this->load->helper('url');
        $this->load->model('gmm_model', 'gmm');//modelo de gmm
        $this->load->model('documentsmodel');
        $this->load->library(array('form_validation', 'JbUpload'));
        $this->lang->load('tank_auth');
        $this->load->library('googledrive');
        $this->load->model("documentsmodel", "documento");
        //$this->load->library('ws_sicas');
    }

    //pagina de inicio de GMMM
    function index(){
        $head = array('title' => 'Capsys - GMM');
        $data = array();
        $footer = array();
        $this->breadcrumbs->push('Registros GMM', 'Bonos');
        $this->breadcrumbs->unshift('Inicio', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['padecimientos']=$this->gmm->getCoberturasGMM();
        $data['reclamo']=$this->gmm->getTipostramites();
        $actualyears=$this->gmm->getYearsDocs();
        $cierre=$this->gmm->getCausaCierre();
        $FechaFin=true;
        //$data['estatus']=$this->gmm->getStatus();
        $coberturas=$this->gmm->getCoberurasGmm();
        $data["coberturas"]=$coberturas;
        $documentos=$this->gmm->getDocuments();
        $estatus=$this->gmm->getStatus();
        $data["tipo"] = "C_GMM";
        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            )
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode($estatus) . ";"."const _Documents = " . json_encode($documentos) . ";"."const _Causa = " . json_encode($cierre) . ";"
                ."const _years = " . json_encode($actualyears) . ";"."const _FechaFin = " . json_encode($FechaFin) . ";"."const _cobertura = " . json_encode($coberturas) . ";"
            ), 
        ));
        $this->render('GMM/prueba', $head, $data, $footer);
    }

}