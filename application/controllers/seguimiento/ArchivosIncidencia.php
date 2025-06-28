<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ArchivosIncidencia extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->CI = &get_instance();

    if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');}

    $this->load->helper('security');

    $this->load->model('accesorios/seguimiento/EvaluadorTareaModel', 'ETM');
  }

  /**
   * Muestra la vista para agregar un evaluador a una tarea
   */
  public function mostrarArchivosIncidencia()
  {
    $id_tarea = $this->input->get('id_tarea');
    if ($id_tarea) {
      $datos_tarea = array();
      $datos_tarea[ 'folio_nc' ] = $this->ETM->obtenerFolioIncidencia($id_tarea);
      $this->load->view('accesorios/seguimiento/mostrar_archivos_incidencia.php', $datos_tarea);
    } else {
      show_404();
    }
  }
}
