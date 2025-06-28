<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Logger
{
  protected $CI;

  const CREAR = "Crear";
  const MODIFICAR = "Modificar";
  const ELIMINAR = "Eliminar";
  const COMPLETAR = "Completar";
  const ASIGNAR = "Asignar";
  const DESASIGNAR = "Desasignar";
  const REABRIR = "Reabrir";
  const DESPLEGAR = "Desplegar";
  const PROGRAMAR = "Programar";

  public function __construct()
  {
    $this->CI = &get_instance();
    $this->CI->load->library('tank_auth');
  }

  public function logTarea($accion, $descripcion, $id_tarea, $fecha = null)
  {
    $datos_log = array(
      'tipo_accion' => $accion,
      'descripcion_accion' => $descripcion,
      'id_tarea' => $id_tarea,
      'id_usuario' => $this->CI->tank_auth->get_idPersona(),
      'nombre_usuario' => $this->CI->tank_auth->get_usernamecomplete(),
    );

    $this->CI->db->insert('tareas_bitacora', $datos_log);

    if (!is_null($fecha)) {
      $datos_log[ 'fecha_evento' ] = $fecha;
    }

    switch ($accion) {
      case self::REABRIR:
        $this->CI->db->where([ 'id_tarea' => $id_tarea, 'tipo_accion' => self::COMPLETAR ]);
        $this->CI->db->delete('tareas_estatus');
        break;
      default:
        $this->CI->db->where([ 'id_tarea' => $id_tarea, 'tipo_accion' => $accion ]);
        $this->CI->db->update('tareas_estatus', $datos_log);
        if ($this->CI->db->affected_rows() == 0) {
          $this->CI->db->insert('tareas_estatus', $datos_log);
        }
    }
  }
}
