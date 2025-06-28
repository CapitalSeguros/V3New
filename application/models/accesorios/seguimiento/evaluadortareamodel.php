<?php
defined('BASEPATH') or exit('No direct script access allowed');

class EvaluadorTareaModel extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Obtiene el idRowTabla correspondiente a una tarea generada desde una incidencia
   *
   * @param {int} $id_tarea - El identificador de la tarea para buscar
   * @returns {int} - Retorna el idRowTabla si se encuentra, o 0 si no hay coincidencias
   */
  public function obtenerFolioIncidencia($id_tarea)
  {
    $this->db->select('tc.idRowTabla');
    $this->db->from('tareas t');
    $this->db->join('tablanoconformidad tc', 'tc.idTablaNoConformidad = t.idTabla', 'left');
    $this->db->where('t.idtarea', $id_tarea);
    $query = $this->db->get();

    if ($query->num_rows() > 0) {
      return $query->row()->idRowTabla;
    } else {
      return 0;
    }
  }

  /**
   * Obtiene los datos de una tarea a partir de su ID
   *
   * @param int $id_tarea - El ID de la tarea a buscar
   * @return array|null - Un array con los datos de la tarea si se encuentra; de lo contrario, null
   */
  public function obtenerDatosTarea($id_tarea)
  {
    $this->db->select([ 'idtarea', 'idproyecto', 'nombre' ]);
    $this->db->where('idtarea', $id_tarea);
    $query = $this->db->get('tareas');

    if ($query->num_rows() > 0) {
      return $query->row_array();
    } else {
      return null;
    }
  }

  /**
   * Obtiene el ID del area de un colaborador a partir del nombre
   *
   * @param string $nombre_area - El nombre del area del colaborador
   * @return int - El ID del area si se encuentra; 0 en caso contrario
   */
  private function obtenerIdAreaColaborador($nombre_area)
  {
    $this->db->select('idColaboradorArea');
    $this->db->where('colaboradorArea', $nombre_area);
    $query = $this->db->get('colaboradorarea');
    $result = $query->row_array();
    return isset($result[ 'idColaboradorArea' ]) ? $result[ 'idColaboradorArea' ] : 0;
  }

  /**
   * Obtiene una lista de vendedores activos filtrados por tipo de persona
   *
   * @param int $tipo_persona - El tipo de persona para filtrar los resultados
   * @return array - Un array de objetos que representan los vendedores activos
   */
  private function obtenerListaVendActivos($tipo_persona)
  {
    $this->db->select('p.idPersona, p.nombres, p.emailUsers, p.emailPersonal, p.idpersonarankingagente');
    $this->db->from('persona p');
    $this->db->join('users u', 'u.idPersona = p.idPersona', 'left');
    $this->db->where('p.tipoPersona', 3);
    $this->db->where('u.banned', 0);
    $this->db->where('u.activated', 1);
    $this->db->where('p.esAgenteColaborador', 0);
    $this->db->where('p.idpersonarankingagente', $tipo_persona);

    $query = $this->db->get();
    return $query->result();
  }

  /**
   * Obtiene una lista de colaboradores filtrados por area
   *
   * @param int $id_area_colaborador - El ID del area del colaborador para filtrar los resultados
   * @return array - Un array de objetos que representan los colaboradores activos en el area especificada
   */
  private function obtenerListaColaboradores($id_area_colaborador)
  {
    $this->db->select('p.idpersonarankingagente, p.nombres, p.idPersona, u.email AS emailUsers, u.email AS emailPersonal');
    $this->db->from('persona p');
    $this->db->join('users u', 'u.idPersona = p.idPersona', 'left');
    $this->db->where('(p.tipoPersona = 1 OR p.esAgenteColaborador = 1)', null, false);
    $this->db->where('u.banned', 0);
    $this->db->where('u.activated', 1);
    $this->db->where('p.idColaboradorArea', $id_area_colaborador);

    $query = $this->db->get();
    return $query->result();
  }

  /**
   * Obtiene una lista de clientes y sus datos correspondientes
   * Version que busca datos en la tabla <clientes_actualiza>
   *
   * @return array - Un array de arrays, cada uno representando un cliente con su ID, nombres, email y tipo de evaluador
   */
  private function obtenerListaClientes()
  {
    $this->db->select([ 'IDCli', 'Nombre', 'ApellidoP', 'ApellidoM', 'RazonSocial', 'EMail1' ]);
    $this->db->from('clientes_actualiza');
    $query = $this->db->get();
    $results = $query->result_array();

    $lista_clientes = array();

    foreach ($results as $row) {
      $nombre_completo = trim(trim($row[ 'Nombre' ]) . ' ' . trim($row[ 'ApellidoP' ]) . ' ' . trim($row[ 'ApellidoM' ]));
      $razon_social = trim($row[ 'RazonSocial' ]);
      $email = trim($row[ 'EMail1' ]);
      if ($email == '') {
        $email = ' ';
      }

      $nombres = $nombre_completo != '' ? $nombre_completo : $razon_social;

      // Renombramos los nombres de las columnas en los resultados
      $lista_clientes[  ] = array(
        'idPersona' => $row[ 'IDCli' ],
        'nombres' => $nombres,
        'emailUsers' => $email,
        'idpersonarankingagente' => 'Clientes',
      );
    }

    return $lista_clientes;
  }

  /**
   * Obtiene una lista de clientes y sus datos correspondientes
   * Version que usa la misma busqueda utilizada en "Agregar Responsable"
   *
   * @return array - Un array de arrays, cada uno representando un cliente con su ID, nombres, email y tipo de evaluador
   */
  private function obtenerListaClientesv2()
  {
    $sql = 'SELECT IDCli AS idPersona, nombrecompleto AS nombres, "Clientes" AS idpersonarankingagente, EMail1 AS emailUsers FROM clientelealtadpuntos WHERE EMail1 <> "" AND idPersonaAgente = 254';
    $query = $this->db->query($sql);
    return $query->result_array();
  }

  /**
   * Obtiene una lista de personas segun el tipo de persona especificado
   *
   * @param string $tipo_persona - El tipo de persona para filtrar la lista (ej. 'BRONCE', 'Clientes', etc.)
   * @return array - Un array de objetos o arrays que representan a las personas segun el tipo especificado
   */
  public function obtenerListaPersonas($tipo_persona)
  {
    $lista_personas = array();

    switch ($tipo_persona) {
      case 'BRONCE':
      case 'ORO':
      case 'PLATINO VIP':
        $lista_personas = $this->obtenerListaVendActivos($tipo_persona);
        break;
      case 'Comercial':
      case 'Operativo':
      case 'Administrativo':
      case 'Gerencial':
      case 'Directivo':
      case 'Operativo Corporativo':
      case 'Operativo Fianzas':
        $lista_personas = $this->obtenerListaColaboradores($this->obtenerIdAreaColaborador($tipo_persona));
        break;
      case 'Clientes':
        $lista_personas = $this->obtenerListaClientesv2();
        break;
    }

    return $lista_personas;
  }

  /**
   * Obtiene una lista de evaluadores asociados a una tarea especifica
   *
   * @param int $id_tarea - El ID de la tarea para la cual se obtienen los evaluadores
   * @return array - Un array de objetos que representan a los evaluadores de la tarea
   */
  public function obtenerListaEvaluadores($id_tarea)
  {
    $this->db->select([ 'id_persona', 'nombre_persona', 'email_persona', 'es_invitado', 'id_pproyectos' ]);
    $this->db->where('id_tarea', $id_tarea);

    $query = $this->db->get('tareas_evaluadores');
    return $query->result();
  }

  /**
   * Verifica si un evaluador especifico esta asociado a una tarea dada
   *
   * @param int $id_tarea - El ID de la tarea a verificar
   * @param int $id_persona - El ID de la persona que se quiere verificar como evaluador
   * @param string $tipo_evaluador - El tipo de evaluador (ej. 'Clientes', 'Operativo')
   * @return bool - Retorna true si el evaluador esta asociado a la tarea; false en caso contrario
   */
  public function verificarEvaluador($id_tarea, $id_persona, $tipo_evaluador)
  {
    $this->db->where('id_tarea', $id_tarea);
    $this->db->where('id_persona', $id_persona);
    $this->db->where('tipo_evaluador', $tipo_evaluador);
    $query = $this->db->get('tareas_evaluadores');

    if ($query->num_rows() > 0) {
      return true;
    } else {
      return false;
    }
  }

  /**
   * Verifica si un evaluador externo esta asociado a una tarea dada mediante su correo electronico
   *
   * @param int $id_tarea - El ID de la tarea a verificar
   * @param string $email_persona - El correo electronico del evaluador externo que se quiere verificar
   * @return bool - Retorna true si el evaluador externo esta asociado a la tarea; false en caso contrario
   */
  public function verificarEvaluadorExterno($id_tarea, $email_persona)
  {
    $this->db->where('id_tarea', $id_tarea);
    $this->db->where('email_persona', $email_persona);
    $query = $this->db->get('tareas_evaluadores');

    if ($query->num_rows() > 0) {
      return true;
    } else {
      return false;
    }
  }

  /**
   * Asigna un evaluador a una tarea insertando sus datos en la base de datos
   *
   * @param array $datos - Un array asociativo con los datos del evaluador a asignar
   * @return bool - Retorna true si la insercion fue exitosa; false en caso contrario
   */
  public function asignarEvaluador($datos)
  {
    return $this->db->insert('tareas_evaluadores', $datos);
  }

  /**
   * Elimina un evaluador de una tarea en la base de datos
   *
   * @param array $datos - Un array asociativo con los datos necesarios para la eliminacion (incluyendo 'id_tarea' e 'id_persona')
   * @return bool - Retorna true si la eliminacion fue exitosa; false en caso contrario
   */
  public function eliminarEvaluador($datos)
  {
    $this->db->where('id_tarea', $datos[ 'id_tarea' ]);
    $this->db->where('id_persona', $datos[ 'id_persona' ]);
    $this->db->delete('tareas_evaluadores');

    return $this->db->affected_rows() > 0;
  }

  /**
   * Genera una contraseña aleatoria de una longitud especifica
   *
   * @param int $longitud - La longitud deseada de la contraseña (por defecto es 6)
   * @return string - La contraseña generada aleatoriamente
   */
  private function generarContrasena($longitud = 6)
  {
    $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $contrasena = '';
    $caracteresLongitud = strlen($caracteres);

    for ($i = 0; $i < $longitud; $i++) {
      $indice = rand(0, $caracteresLongitud - 1);
      $contrasena .= $caracteres[ $indice ];
    }

    return $contrasena;
  }

  /**
   * Asigna un evaluador externo a un proyecto y lo registra en las tablas correspondientes
   *
   * @param array $datos - Un array asociativo con los datos del evaluador externo
   * @return bool - Retorna true si la asignacion fue exitosa; false en caso contrario
   */
  public function asignarEvaluadorExterno($datos)
  {
    // Primero lo agregamos a la tabla pproyectos
    $datos_eval_pproyectos = array(
      'idproyecto' => $datos[ 'id_proyecto' ],
      'tipo' => $datos[ 'tipo_evaluador' ],
      'idpersona' => $datos[ 'id_persona' ],
      'nombre' => 's/n',
      'correo' => $datos[ 'email_persona' ],
      'contrasena' => $this->generarContrasena(),
      'url' => base_url() . 'cproyecto/muestraProyectosExternos?idproyecto=' . $datos[ 'id_proyecto' ],
    );
    $exito_pproyecto = $this->db->insert('pproyectos', $datos_eval_pproyectos);

    if ($exito_pproyecto) {
      // Ahora procedemos a generar el registro en la tabla tareas_evaluadores
      $new_id_pproyectos = $this->db->insert_id();
      $datos[ 'id_pproyectos' ] = $new_id_pproyectos;

      $exito_eval = $this->db->insert('tareas_evaluadores', $datos);

      // Si el registro del nuevo evaluador fue exitoso regresamos un true, sino, eliminamos su registro en pproyectos y devolvemos false
      if ($exito_eval) {
        return true;
      } else {
        $this->db->where('id', $new_id_pproyectos);
        $this->db->delete('pproyectos');
        return false;
      }
    }
  }

  /**
   * Elimina un evaluador externo de las tablas <pproyectos> y <tareas_evaluadores>
   *
   * @param array $datos - Un array asociativo que contiene la informacion necesaria para la eliminacion
   * @return bool - Retorna true si al menos un registro fue eliminado; false en caso contrario
   */
  public function eliminarEvaluadorExterno($datos)
  {
    // Eliminamos su registro en la tabla pproyectos
    $this->db->where('id', $datos[ 'id_pproyecto' ]);
    $this->db->delete('pproyectos');

    // Eliminamos su registro en la tabla tareas_evaluadores
    $this->db->where('id_tarea', $datos[ 'id_tarea' ]);
    $this->db->where('email_persona', $datos[ 'email_persona' ]);
    $this->db->delete('tareas_evaluadores');

    return $this->db->affected_rows() > 0;
  }
}
