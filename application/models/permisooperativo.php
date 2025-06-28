<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PermisoOperativo extends CI_Model {


  function devolverCanalesCobranza()
  {
  	$respuesta=array();
    $consulta='select * from personapermiso pp
left join personapermisorelacion ppr on ppr.idPersonaPermiso=pp.idPersonaPermiso
where pp.idLlavePermiso="selectcobranzacanal" and ppr.idPersona='.$this->tank_auth->get_idPersona().' order by pp.orden';
//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($consulta,TRUE));fclose($fp);
    $respuesta=$this->db->query($consulta)->result();
   return $respuesta;
  }
 //-----------------------------------------------------------------------------
 function devolverPermisoAplicacionPago()
 {
    $consulta='select * from personapermiso pp
left join personapermisorelacion ppr on ppr.idPersonaPermiso=pp.idPersonaPermiso
where pp.idLlavePermiso="aplicacionpago" and ppr.idPersona='.$this->tank_auth->get_idPersona();
$datos=$this->db->query($consulta)->result();
 
if((count($datos))>0){return 1;}
return 0;
   
 }
 //-----------------------------------------------------------------------------
 function PermisoModuloPersonaCorreos($array)
{
	
  $consulta='select u.idPersona,u.email from personapermiso pp left join personapermisorelacion ppr on ppr.idPersonaPermiso=pp.idPersonaPermiso left join users u on u.idPersona=ppr.idPersona where pp.idLlavePermiso="'.$array['idLlavePermiso'].'" and pp.value="'.$array['value'].'" and ppr.idPersona is not null';
  
return $this->db->query($consulta)->result();
}
//------------------------------------------------------------------------------
 function ayuda()
 {
 	$funciones=array();
 	$funciones['devolverCanalesCobranza'];
 	$funciones['devolverCanalesCobranza']->texto='Nos da permiso para obtener los canales de cobranza.Este se aplica compo ejemplo en el select de cobranza pendiente';
 	$funciones['devolverCanalesCobranza']->parametros='No recibe ningun parametro';
 	$funciones['devolverCanalesCobranza']->valorDevuelto='Lista de canales';

 	$funciones['devolverPermisoAplicacionPago'];
 	$funciones['devolverPermisoAplicacionPago']->texto='Devuelve si el usuario tiene permiso para la aplicar un pago';
 	$funciones['devolverPermisoAplicacionPago']->parametros='No recibe ningun parametro';
 	$funciones['devolverPermisoAplicacionPago']->valorDevuelto='1 si tiene permiso 0 si no lo tiene';
 }
  
//------------------------------------------------

  function devolverCanalesRenovacion()
  {
    $consulta='select * from personapermiso pp left join personapermisorelacion ppr on ppr.idPersonaPermiso=pp.idPersonaPermiso where pp.idLlavePermiso="selectrenovacioncanal" and ppr.idPersona='.$this->tank_auth->get_idPersona().' order by pp.orden';
  //$consulta='select * from personapermiso pp left join personapermisorelacion ppr on ppr.idPersonaPermiso=pp.idPersonaPermiso where pp.idLlavePermiso="selectrenovacioncanal" order by  pp.nombrePersonaPermiso desc';
        

   return $this->db->query($consulta)->result();
  }
//-----------------------------------------------
//-----------------------------------------------------------------------------
 function devolverPermisoPorLlaveAndValue($idLlavePermiso='',$value='')
 {
  $filtro='';
  /*
  SE TIENE QUE RECIBIR  LA $idLlavePermiso AL MENOS SI NO DEVOLVERA FALSE;
  */
   
  if($idLlavePermiso!=''){$filtro=' and pp.idLlavePermiso="'.$idLlavePermiso.'"';}
  if($value!=''){$filtro.=' and pp.value="'.$value.'"';}

    $consulta='select * from personapermiso pp left join personapermisorelacion ppr on ppr.idPersonaPermiso=pp.idPersonaPermiso where ppr.idPersona='.$this->tank_auth->get_idPersona().' '.$filtro;
    $datos=$this->db->query($consulta)->result();
if($idLlavePermiso!=''){if((count($datos))>0){return 1;}}
return 0;
   
 }


//** Miguel jaime 11-03-2023***//
function getConfiguracionReportesDiarios($tipo){
  $sql="SELECT * FROM config_reportes_diarios WHERE tipo='$tipo'";
  return $this->db->query($sql)->result();
}


//------------------------------------------------------------------------------------
  function getReports($sql) { //Creado [Suemy][2024-03-21]
    $query = $this->db->query('SELECT * FROM reportes_diarios '.$sql)->result();
    return $query;
  }
  function getEmployeesOfReport() { //Creado [Suemy][2024-03-21]
    $query = $this->db->query('SELECT c.*, r.titulo, r.informacion FROM config_reportes_diarios c INNER JOIN reportes_diarios r ON r.id = c.tipo')->result();
    return $query;
  }
//------------------------------------------------------------------------------------

/**
 * Devuelve la lista de permisos sobre el listado de polizas del usuario
 */
function obtenerPermisosPolizas()
{
  $this->db->select('pp.value');
  $this->db->from('personapermisorelacion ppr');
  $this->db->join('personapermiso pp', 'ppr.idPersonaPermiso = pp.idPersonaPermiso', 'left');
  $this->db->where('ppr.idPersona', $this->tank_auth->get_idPersona());
  $this->db->where('pp.idLlavePermiso', 'listaPolizas');
  $query = $this->db->get();

  return array_column($query->result_array(), 'value');
}

/**
 * Verifica si el usuario cuenta con el permiso para ver la pestaña 2 en cobranza
 */
function devolverPermisoPestania(){
  $idPersona = $this->tank_auth->get_idPersona();
  $idPersonaPermiso = 60; // ID(idPersonaPermiso) tomado directamente de la tabla personapermiso

  $query = $this->db->query("
      SELECT EXISTS(
          SELECT 1
          FROM personapermisorelacion
          WHERE idPersona = ?
            AND idPersonaPermiso = ?
      ) AS existe", array($idPersona, $idPersonaPermiso)
  );

  $result = $query->row();

  return $result->existe;
}

}