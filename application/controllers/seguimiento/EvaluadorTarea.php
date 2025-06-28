<?php
defined('BASEPATH') or exit('No direct script access allowed');

class EvaluadorTarea extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->CI = &get_instance();

    if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');}

    $this->load->helper('security');

    $this->load->model('accesorios/seguimiento/EvaluadorTareaModel');
  }

  /**
   * Muestra la vista para agregar un evaluador a una tarea
   */
  public function mostrarAgregarEvaluador()
  {
    $id_tarea = $this->input->get('id_tarea');
    if ($id_tarea) {
      $datos_tarea = $this->EvaluadorTareaModel->obtenerDatosTarea($id_tarea);
      $datos_tarea['folio_nc'] = $this->EvaluadorTareaModel->obtenerFolioIncidencia($id_tarea);
      if ($datos_tarea !== null) {
        $this->load->view('accesorios/seguimiento/agregar_evaluador_tarea.php', $datos_tarea);
      } else {
        show_404();
      }
    } else {
      show_404();
    }
  }

  /**
   * Devuelve la lista de personas por tipo solicitada
   */
  public function obtenerListaPersonas()
  {
    $tipo_persona = $this->input->post('tipo_persona');
    $resultados = $this->EvaluadorTareaModel->obtenerListaPersonas($tipo_persona);
    echo json_encode($resultados);
  }

  /**
   * Devuelve la lista de evaluadores asignados a una tarea
   */
  public function obtenerListaEvaluadores()
  {
    $id_tarea = $this->input->post('id_tarea');
    $resultados = $this->EvaluadorTareaModel->obtenerListaEvaluadores($id_tarea);
    echo json_encode($resultados);
  }

  /**
   * Asigna un nuevo evaluador(interno o externo) a una tarea
   */
  public function asignarEvaluador()
  {
    $eval_respuesta = array();

    $datos_evaluador = array(
      'id_proyecto' => $_POST[ 'id_proyecto' ],
      'id_tarea' => $_POST[ 'id_tarea' ],
      'tipo_evaluador' => $_POST[ 'tipo_evaluador' ],
      'id_persona' => $_POST[ 'id_persona' ],
      'nombre_persona' => $_POST[ 'nombre_persona' ],
      'email_persona' => $_POST[ 'email_persona' ],
      'es_invitado' => $_POST[ 'es_invitado' ] === 'true' ? true : false,
      'asignadopor_id' => $this->tank_auth->get_idPersona(),
      'asignadopor_nombre' => $this->tank_auth->get_usernamecomplete()
    );

    if ($datos_evaluador[ 'es_invitado' ]) {
      // Validamos que la persona no este ya asignada a la tarea
      $asignado = $this->EvaluadorTareaModel->verificarEvaluadorExterno($datos_evaluador[ 'id_tarea' ], $datos_evaluador[ 'email_persona' ]);
      if ($asignado) {
        $eval_respuesta[ 'status' ] = 'info';
        $eval_respuesta[ 'asignado' ] = true;
        $eval_respuesta[ 'mensaje' ] = 'La persona ya está asignada como evaluador para esta tarea.';
      } else {
        $exito = $this->EvaluadorTareaModel->asignarEvaluadorExterno($datos_evaluador);
        if ($exito) {
          $eval_respuesta[ 'status' ] = 'success';
          $eval_respuesta[ 'asignado' ] = true;
          $eval_respuesta[ 'mensaje' ] = 'Evaluador asignado con éxito.';
        } else {
          $eval_respuesta[ 'status' ] = 'error';
          $eval_respuesta[ 'asignado' ] = false;
          $eval_respuesta[ 'mensaje' ] = 'No se ha podido completar la operación en el servidor.';
        }
      }
    } else {
      // Validamos que la persona no este ya asignada a la tarea
      $asignado = $this->EvaluadorTareaModel->verificarEvaluador($datos_evaluador[ 'id_tarea' ], $datos_evaluador[ 'id_persona' ], $datos_evaluador[ 'tipo_evaluador' ]);
      if ($asignado) {
        $eval_respuesta[ 'status' ] = 'info';
        $eval_respuesta[ 'asignado' ] = true;
        $eval_respuesta[ 'mensaje' ] = 'La persona ya está asignada como evaluador para esta tarea.';
      } else {
        $exito = $this->EvaluadorTareaModel->asignarEvaluador($datos_evaluador);
        if ($exito) {
          $eval_respuesta[ 'status' ] = 'success';
          $eval_respuesta[ 'asignado' ] = true;
          $eval_respuesta[ 'mensaje' ] = 'Evaluador asignado con éxito.';
        } else {
          $eval_respuesta[ 'status' ] = 'error';
          $eval_respuesta[ 'asignado' ] = false;
          $eval_respuesta[ 'mensaje' ] = 'No se ha podido completar la operación en el servidor.';
        }
      }
    }

    echo json_encode($eval_respuesta);
  }

  /**
   * Elimina a un evaluador(interno) de una tarea
   */
  public function eliminarEvaluador()
  {
    $eval_respuesta = array();

    $datos_evaluador = array(
      'id_tarea' => $_POST[ 'id_tarea' ],
      'id_persona' => $_POST[ 'id_persona' ],
    );

    $exito = $this->EvaluadorTareaModel->eliminarEvaluador($datos_evaluador);
    if ($exito) {
      $eval_respuesta[ 'status' ] = 'success';
      $eval_respuesta[ 'eliminado' ] = true;
      $eval_respuesta[ 'mensaje' ] = 'Evaluador removido de la tarea con éxito.';
    } else {
      $eval_respuesta[ 'status' ] = 'error';
      $eval_respuesta[ 'eliminado' ] = true;
      $eval_respuesta[ 'mensaje' ] = 'El evaluador ya ha sido removido de la tarea.';
    }

    echo json_encode($eval_respuesta);
  }

  /**
   * Elimina a un evaluador externo de una tarea
   */
  public function eliminarEvaluadorExterno()
  {
    $eval_ext_respuesta = array();

    $datos_invitado = array(
      'id_tarea' => $_POST[ 'id_tarea' ],
      'id_pproyecto' => $_POST[ 'id_pproyecto' ],
      'email_persona' => $_POST[ 'email_persona' ],
    );

    $exito = $this->EvaluadorTareaModel->eliminarEvaluadorExterno($datos_invitado);

    if ($exito) {
      $eval_ext_respuesta[ 'status' ] = 'success';
      $eval_ext_respuesta[ 'eliminado' ] = true;
      $eval_ext_respuesta[ 'mensaje' ] = 'Evaluador removido de la tarea con éxito.';
    } else {
      $eval_ext_respuesta[ 'status' ] = 'info';
      $eval_ext_respuesta[ 'eliminado' ] = true;
      $eval_ext_respuesta[ 'mensaje' ] = 'El evaluador ya ha sido removido de la tarea.';
    }

    echo json_encode($eval_ext_respuesta);
  }
}
