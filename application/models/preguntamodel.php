<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class preguntaModel extends CI_Model {
	var $funcionLlamar;
	var $datos;
//-----------------------------------------------------------------
	function __construct(){
		parent::__construct();     

	}
	public function TPreguntas($IdEncuesta){
    $consulta="select * from pregunta where idcabencuesta = '".$IdEncuesta."'";
	$datos=$this->db->query($consulta)->result();
    return $datos;
  }
  public function tipoEncuesta($IdEncuesta){
    $consulta="select tipoencuesta from cabencuesta where idcabencuesta = '".$IdEncuesta."'";
	$datos=$this->db->query($consulta)->result();
    return $datos;
  }
  public function TEncuesta(){ //Modificado [2024-01-19]
    $consulta='select * from cabencuesta where activa = 0 order by idcabencuesta asc';
	$datos=$this->db->query($consulta)->result();
    return $datos;
  }
  public function TEncuestaEmpleado($idEncuesta){
    $consulta="select * from encuesta where idcabencuesta = '".$idEncuesta."'";;
	$datos=$this->db->query($consulta)->result();
    return $datos;
  }
  public function TRespuesta(){
    $consulta='select * from respuesta';
	$datos=$this->db->query($consulta)->result();
    return $datos;
  }
  public function TCalificacion($valid,$ano,$mes){
   
  /*if($valid =='0')
   {
    $consulta="select ca.idcalificaencuesta,en.descripcion,ca.usuario,ca.calificacion 
               from calificaencuesta ca ,cabencuesta en 
               where ca.idencuesta = en.idcabencuesta and ca.activa = '5' and cliente = '0'";
	}
  if($valid =='1')
   {
    $consulta="select ca.idcalificaencuesta,en.descripcion,ca.usuario,ca.calificacion 
               from calificaencuesta ca left join cabencuesta en on ca.idencuesta=ca.idencuesta left join persona p on p.idPersona=ca.idusuario 
               where ca.idencuesta = en.idcabencuesta and ca.activa = '1' and cliente = '0' and p.tipoPersona=1";
	}
  if($valid =='3')
   {
    $consulta="select ca.idcalificaencuesta,en.descripcion,ca.usuario,ca.calificacion 
               from calificaencuesta ca left join cabencuesta en on ca.idencuesta=ca.idencuesta left join persona p on p.idPersona=ca.idusuario 
               where ca.idencuesta = en.idcabencuesta and ca.activa = '1' and cliente = '0' and p.tipoPersona=3";
	}
	if($valid =='2')
	{
		 $consulta="select ca.idcalificaencuesta,en.descripcion,ca.usuario,ca.calificacion 
               from calificaencuesta ca ,cabencuesta en 
               where ca.idencuesta = en.idcabencuesta and ca.activa = '1' and cliente = '1'";
	}
	$datos=$this->db->query($consulta)->result();
    return $datos;
	*/
	if($valid =='0')
	{
	 $consulta="select ca.idcalificaencuesta,en.descripcion,ca.usuario,ca.calificacion,'' as tipo 
				from calificaencuesta ca ,cabencuesta en 
				where ca.idencuesta = en.idcabencuesta and ca.activa = '5' and cliente = '0' and en.activa=0
				and  year(ca.fechacontesta)=".$ano." and month(ca.fechacontesta)=".$mes;
	
	
	 }
   if($valid =='1')
	{
	  /* $consulta="select ca.idcalificaencuesta,en.descripcion,ca.usuario,ca.calificacion 
				from calificaencuesta ca left join cabencuesta en on ca.idencuesta=ca.idencuesta left join persona p on p.idPersona=ca.idusuario 
				where ca.idencuesta = en.idcabencuesta and ca.activa = '1' and cliente = '0' and p.tipoPersona=1 and en.activa=0";*/
				$consulta="	select ca.idcalificaencuesta,ca.usuario,ca.calificacion,en.descripcion,'COLABORADOR' as tipo
               from calificaencuesta ca, cabencuesta en, persona p
               where ca.idencuesta = en.idcabencuesta and p.idPersona=ca.idusuario 
                and en.activa = 0 and p.tipoPersona=1 and ca.activa = '1' and  year(ca.fechacontesta)=".$ano." and month(ca.fechacontesta)=".$mes;			
	 }
   if($valid =='3')
	{
	 $consulta="select ca.idcalificaencuesta,en.descripcion,ca.usuario,ca.calificacion , 'AGENTE' as tipo
				from calificaencuesta ca left join cabencuesta en on ca.idencuesta=ca.idencuesta left join persona p on p.idPersona=ca.idusuario 
				where ca.idencuesta = en.idcabencuesta and ca.activa = '1' and cliente = '0' and p.tipoPersona=3 and en.activa=0
				and  year(ca.fechacontesta)=".$ano." and month(ca.fechacontesta)=".$mes;
	 }
	 if($valid =='2')
	 {
		  $consulta="select ca.idcalificaencuesta,en.descripcion,ca.usuario,ca.calificacion, 'CLIENTE' as tipo 
				from calificaencuesta ca ,cabencuesta en 
				where ca.idencuesta = en.idcabencuesta and ca.activa = '1' and cliente = '1' and en.activa=0
				and  year(ca.fechacontesta)=".$ano." and month(ca.fechacontesta)=".$mes;			
	 }
	 $datos=$this->db->query($consulta)->result();
	 return $datos;
 
  }
  public function TClaveSecreta(){
    $consulta="select * from clavesecreta";
	$query=$this->db->query($consulta);  

    return $query->row();
  }
  public function TCantidadPreguntas($iden){
    $consulta="select count(idpregunta) as cont from pregunta where idcabencuesta ='".$iden."'";
	$query=$this->db->query($consulta);
   if($query->num_rows()>0){
            $fila=$query->row();
            return $fila->cont;
        }else{
            return 0;
        }

    return $query['cont'];
  }
  /***************************************** */
  public function TNPS($iden){
  	
    $consulta="select tiprespuesta from cabencuesta where idcabencuesta ='".$iden."'";
	$query=$this->db->query($consulta)->result();
	
	//return $query[0];
       return $query[0]->tiprespuesta;
  }
  /********************************** */
  public function ActualizaPregunta($id,$datos){
    $this->db->where('idcabencuesta',$id);
    $this->db->update('cabencuesta',$datos);
     }
 public function EnviaPregunta($idpre){
	
        $sqlBusquedapro = "select * from persona where tipoPersona in(".$idpre.")";
		$query = $this->db->query($sqlBusquedapro)->result();
		return
			$query;
	}
 public function EnviaUsuario($usuario){
		
        
        $sqlBusquedapro = "
			select * from persona f 
			where f.idpregunta='".$idpre."'
							   ";
		$query = $this->db->query($sqlBusquedapro);
		return
			$query;
	}
	public function DevuelveUsuario($idusuario){
		
        
        $sqlBusquedapro = "
			select concat(nombres,' ',apellidoPaterno,' ',apellidoMaterno) as nombres from persona f 
			where f.idPersona='".$idusuario."'
							   ";
		$query = $this->db->query($sqlBusquedapro);
		return
			$query->row();
	}
	public function DevuelveAsigna(){
		
        
        $sqlBusquedapro = "
			select * from asignaempleado f 
			where f.contesto = 0 order by idasigna desc";							   
		$query = $this->db->query($sqlBusquedapro);
		return
			$query;
	}
	public function cabEncuesta(){
		        
        $sqlBusquedapro = "
			select * from cabencuesta f 
			where f.activa = 0 ";							   
		$query = $this->db->query($sqlBusquedapro);
		return
			$query;
	}
	public function CompruebaAsigna($idusuario){
       
        $sqlBusquedapro = "
			select * from asignaempleado f 
			where f.contesto = 0 and f.idempleado = '".$idusuario."'";							   
		$query = $this->db->query($sqlBusquedapro);
		return
			$query;
	}
	public function EnviaPersona(){
		
        
        $sqlBusquedapro = "
			select f.idPersona,coalesce(CONCAT(f.nombres,' ',f.apellidoPaterno,' ',f.apellidoMaterno),' ')as nombres ,if(f.tipoPersona = 1,'OPERATIVO','AGENTES') AS TIPO  from persona f 	
			where CONCAT(f.nombres,' ',f.apellidoPaterno,' ',f.apellidoMaterno)  is not null ORDER BY TIPO";
		$query = $this->db->query($sqlBusquedapro);
		return
			$query;
	}	
	public function EnviaPersona2($tipo){
		
        if($tipo =='1')
        {	
        $sqlBusquedapro = "
			select f.idPersona,coalesce(CONCAT(f.nombres,' ',f.apellidoPaterno,' ',f.apellidoMaterno),' ')as nombres ,if(f.tipoPersona = 1,'COLABORADOR','AGENTES') AS TIPO, emailUsers as EMail1  from persona f 	
			where CONCAT(f.nombres,' ',f.apellidoPaterno,' ',f.apellidoMaterno)is not null and f.tipoPersona='1'
			   ORDER BY TIPO";
		}
		else
		{	
		 if($tipo =='2')
		 {
		  $sqlBusquedapro = "
			select f.idPersona,coalesce(CONCAT(f.nombres,' ',f.apellidoPaterno,' ',f.apellidoMaterno),' ')as nombres ,if(f.tipoPersona = 1,'COLABORADOR','AGENTES') AS TIPO ,emailUsers as EMail1 from persona f 	
			where CONCAT(f.nombres,' ',f.apellidoPaterno,' ',f.apellidoMaterno)is not null and f.tipoPersona in(3,4)
			   ORDER BY TIPO";	
		 }
		 else
		 {	
		  if($tipo =='4')
		  {

		  	$sqlBusquedapro = "
            select IDCli as idPersona, nombrecompleto as nombres,'CLIENTES' as TIPO,'CLIENTE' as clasificacion,EMail1 from clientelealtadpuntos
            where  (EMail1 <> '') and idPersonaAgente=254"; 
		  }	
          else
          {
         	 $sqlBusquedapro = "
			select f.idPersona,coalesce(CONCAT(f.nombres,' ',f.apellidoPaterno,' ',f.apellidoMaterno),' ')as nombres ,if(f.tipoPersona = 1,'OPERATIVO','AGENTES') AS TIPO, emailUsers as EMail1  from persona f 	
			where CONCAT(f.nombres,' ',f.apellidoPaterno,' ',f.apellidoMaterno)is not null 
			   ORDER BY TIPO";
          }
         } 	
	    }

		$query = $this->db->query($sqlBusquedapro)->result();
		return
			$query;
	}	
 public function contadorPregunta(){
		
        $sqlBusquedapro = "select count(idpregunta) as cont from pregunta";
		$query = $this->db->query($sqlBusquedapro);
		return
			$query->cont;
	}

		///---------------------- Dennis [2021-08-05]
		function obtenerGuionTelefonico($modulo){

			$this->db->from("guion_telefonico_relacion_modulo_nombre a");
			$this->db->join("guion_telefonico_modulo b","a.idModulo=b.idModulo", "inner");
			$this->db->join("guion_telefonico_nombre_guion c","a.idNombre=c.idNombre", "inner");
			$this->db->join("guion_telefonico_mensaje d","c.idNombre=d.idNombre", "inner");
	
			if(!empty($modulo)){
				$this->db->where("b.modulo", $modulo);
			}
			$query = $this->db->get();
	
			return $query->num_rows() > 0 ? $query->result() : array();
		}
		//----------------------- Dennis [2021-08-05]
		function eliminaRegistroDeGuion($id){
	
			$this->db->trans_begin();
			$return_bool = false;
	
			$this->db->where("idNombre", $id);
			$this->db->delete(array("guion_telefonico_nombre_guion", "guion_telefonico_mensaje", "guion_telefonico_relacion_modulo_nombre"));
	
			if($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
			} else{
				$this->db->trans_commit();
				$return_bool = true;
			}
	
			return $return_bool;
		}
		//----------------------- Dennis [2021-08-05]
		function obtenerDatosDelGuion($idModulo, $idNombre){
	
			$this->db->from("guion_telefonico_relacion_modulo_nombre a");
			$this->db->join("guion_telefonico_modulo b","a.idModulo=b.idModulo", "inner");
			$this->db->join("guion_telefonico_nombre_guion c","a.idNombre=c.idNombre", "inner");
			$this->db->join("guion_telefonico_mensaje d","c.idNombre=d.idNombre", "inner");
			$this->db->where("c.idNombre", $idNombre);
			$this->db->where("a.idModulo", $idModulo);
			$query = $this->db->get();
	
			return $query->num_rows() > 0 ? $query->result() : array();
		}
		//---------------------- Dennis [2021-12-07]
		function insertSafely($array, $table){

			$response = false;
			$this->db->trans_begin();
			$this->db->insert($table, $array);
			$lastID = $this->db->insert_id();

			if($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
			} else{
				$this->db->trans_commit();
				$response = true;
			}

			return array("lastId" => $lastID, "status" => $response);
		}
		//---------------------- Dennis [2021-12-07]
		function updateSafely($array, $table, $condition){

			$response = false;
			$this->db->trans_begin();
			$this->db->where("idTutorial", $condition);
			$this->db->update($table, $array);

			if($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
			} else{
				$this->db->trans_commit();
				$response = true;
			}

			return array("lastId" => $condition, "status" => $response);
		}
		//---------------------- Dennis [2021-12-07]
		function getTutorial($id){

			$this->db->where("idTutorial", $id);
			$query = $this->db->get("tutorial_videos");
		
			return $query->num_rows() > 0 ? $query->row() : array();
		}
		//---------------------- Dennis [2021-12-07]
		function getTutorialList($module = null){  

			$this->db->from("tutorial_module_relationship a");
			$this->db->join("tutorial_modules b", "a.idModule = b.idModulo", "inner");
			$this->db->join("tutorial_videos c", "a.idTutorial = c.idTutorial", "inner");
			
			if(!empty($module)){
				$this->db->where("b.modulo", $module);
			}

			$query = $this->db->get();

			return $query->num_rows() > 0 ? $query->result() : array();
		}
		//--------------------- Dennis [2021-12-07]
		function deleteSafely($idReg){

			$response = false;
			$this->db->trans_begin();
			$this->db->where("idTutorial", $idReg);
			$this->db->delete(array("tutorial_module_relationship","tutorial_videos"));

			if($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
			} else{
				$this->db->trans_commit();
				$response = true;
			}

			return $response;
		}
		//------------------- Dennis [2021-12-07]
		function getTutorialModules(){

			$this->db->where("activo", 1);
			$query = $this->db->get("tutorial_modules");

			return $query->num_rows() > 0 ? $query->result() : array();
		}
		//-------------------

 }