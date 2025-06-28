<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CronogramaModel extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Devuelve la lista de tareas del año actual vinculadas al usuario
   */
  public function obtenerDatosCrono($year, $idproyecto)
  {
    $id_persona = $this->tank_auth->get_idPersona();

    // Obtenemos la lista de tareas desde los proyectos a los que el usuario tiene acceso
    $this->db->distinct();
    $this->db->select('p.idproyecto, p.nombre AS nombre_proyecto, t.idtarea, t.nombre AS nombre_tarea, t.fechaentrega, t.fechaCreacion, t.fechaEnProduccion, t.finalizaTiempo');
    $this->db->from('proyectos p');
    $this->db->join('pproyectos pp', 'p.idproyecto = pp.idproyecto', 'left');
    $this->db->join('tareas t', 'p.idproyecto = t.idproyecto AND t.tareaEliminada = 0 AND YEAR(t.fechaCreacion) = ' . $year, 'left');
    $this->db->where("(p.usuario = " . $this->db->escape($id_persona) . " OR pp.idpersona = " . $this->db->escape($id_persona) . ")");
    if ($idproyecto) {
      $this->db->where('p.idproyecto', $idproyecto);
    }
    $this->db->order_by('p.idproyecto', 'ASC');
    $this->db->order_by('t.fechaCreacion', 'ASC');

    $query = $this->db->get();
    $tareas = $query->result();

    $datos = array();

    foreach ($tareas as $tarea) {
      // Obtenemos los estatus de la tarea (actualmente solo el de marcado como completado)
      $this->db->select('tipo_accion, descripcion_accion, nombre_usuario, fecha_evento');
      $this->db->from('tareas_estatus');
      $this->db->where('id_tarea', $tarea->idtarea);
      $this->db->where('id_usuario', $id_persona);

      $query = $this->db->get();
      $tarea->estatus = $query->result();

      // Obtenemos la lista de responsables asignados a la tarea
      $this->db->select('nombre, correo, registro, idpersona');
      $this->db->from('ptareas');
      $this->db->where('idtarea', $tarea->idtarea);

      $query = $this->db->get();
      $tarea->responsables = $query->result();

      // Obtenemos la lista de evaluadores asignados a la tarea
      $this->db->select('nombre_persona, fecha_asignacion, asignadopor_nombre');
      $this->db->from('tareas_evaluadores');
      $this->db->where('id_tarea', $tarea->idtarea);

      $query = $this->db->get();
      $tarea->evaluadores = $query->result();

      $datos[  ] = $tarea;
    }

    return $datos;
  }

  /**
   * Devuelve los registros de vacaciones de los usuarios y año especificados
   */
  function obtenerVacacionesUsuario($ids_personas, $year){
    $this->db->select('idPersona, fecha_salida, fecha_retorno');
    $this->db->from('vacaciones');
    $this->db->where_in('idPersona', $ids_personas);
    $this->db->where('estado', 'aprobado');
    $this->db->where('YEAR(fecha_salida)', $year);
    $this->db->order_by('idPersona', 'ASC');

    $query = $this->db->get();
    return $query->result();
  }
}
