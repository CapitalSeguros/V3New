<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cronograma extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->CI = &get_instance();

    if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');}

    $this->load->helper('security');

    $this->load->model('accesorios/seguimiento/cronogramamodel', 'cronomodel');
  }

  public function mostrarCrono()
  {
    $this->load->view('accesorios/seguimiento/cronograma.php');
  }

  public function obtenerDatosCrono()
  {
    $year = $this->input->post('year');
    $idproyecto = $this->input->post('idproyecto');
    $datos = $this->cronomodel->obtenerDatosCrono($year, $idproyecto);
    echo json_encode($datos);
  }

  public function obtenerVacacionesUsuario(){
    $ids_personas = (array) $this->input->post('ids_personas');
    $year = $this->input->post('year');
    $resultados = $this->cronomodel->obtenerVacacionesUsuario($ids_personas, $year);
    echo json_encode($resultados);
  }
}
