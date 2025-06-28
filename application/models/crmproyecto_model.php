<?php
class crmProyecto_Model extends CI_Model{
		public $CI;
//----------------------------------------------------------------------------------------------------	
	public function __Construct(){
		parent::__Construct();
		$this->CI =& get_instance();
   
	}
//----------------------------------------------------------------------------------------------------	
  function clientes_actualiza($array){ 

  	$salida=0;$seguridad=0;
  	$datos="";
  
  	do{
    if(isset($array['IDCli']) )
    {
     if($array['IDCli']==-1)
     {
     	unset($array['IDCli']);
     	unset($array['update']);
     	$this->db->insert('clientes_actualiza',$array);
     	$array['IDCli']=$this->db->insert_id();
     } 
     else
     {
     	if(isset($array['update']))
     	{
     	  unset($array['update']);
     	  if($array['IDCli']!=''){

          $this->db->where('IDCli',$array['IDCli']);
         $this->db->update('clientes_actualiza',$array);
      
           }else{$salida=1;}
           	
     	}
     	else
     	{
          $this->db->where('IDCli',$array['IDCli']);
          $datos=$this->db->get('clientes_actualiza')->result();
          $salida=1;
     	}
     }
    }
    else
    { 
    	$where->db->where('Usuario',$this->tank_auth->get_usermail());
         $datos=$this->db->get('clientes_actualiza')->result();        
         $salida=1;
    }
    $seguridad++;
    if($seguridad>4){$salida=1;}

  }while($salida==0);
  return $datos;
 }

//----------------------------------------------------------------------------------------------------
function devuelveEnPausa($array){
	$Usuario="";
	if(isset($array['Usuario'])){$Usuario=$array['Usuario'];}
    else{$Usuario=$this->tank_auth->get_usermail();}
    $consulta='select ca.* from clientes_actualiza ca where  ca.EstadoActual="PAUSA"  && (TIMESTAMPDIFF(day, cast(ca.fechaMensajePausa as date), curdate() ))>=0 &&  ca.Usuario="'.$Usuario.'"';
  
    return $this->db->query($consulta)->result();    	
}

//----------------------------------------------------------------------------------------------------
function puntaje($array){

  	$salida=0;$seguridad=0;$datos="";
  	do{
    if(isset($array['IDPuntaje']) )
    {
     if($array['IDPuntaje']==-1)
     {
     	unset($array['IDPuntaje']);unset($array['update']);
     	$this->db->insert('puntaje',$array);
     	$array['IDPuntaje']=$this->db->insert_id();
     } 
     else
     {
     	if(isset($array['update']))
     	{
     	  unset($array['update']);
     	  if($array['IDPuntaje']!='')
     	  {
           $this->db->where('IDPuntaje',$array['IDPuntaje']);
           $this->db->update('puntaje',$array);      
          }
           else{$salida=1;}           	
     	}
     	else
     	{
          $this->db->where('IDPuntaje',$array['IDPuntaje']);
          $datos=$this->db->get('puntaje')->result();
          $salida=1;
     	}
     }
    }
    else
    { 
    	//$where->db->where('Usuario',$this->tank_auth->get_usermail());
         $datos=$this->db->get('puntaje')->result();        
         $salida=1;
    }
    $seguridad++;
    if($seguridad>4){$salida=1;}

  }while($salida==0);
  return $datos;


}
//----------------------------------------------------------------------------------------------------
function ultimoEdoActualPuntaje($IDCliente){
 $consulta="select max(p.IDPuntaje),p.* from puntaje p where p.IDCliente=".$IDCliente;
 $datos=$this->db->query($consulta)->result();
 if((count($datos))>0){
 	if($datos[0]->EdoActual==''){
 		$datos[0]->EdoActual='DIMENSION';
 	}
 }
 return $datos;
}


//**** Ultima Actualizacion Miguel Jaime 11/11/2020

  function cliente_primera_cita_notificacion($usuario){
    $query="SELECT  clientes_actualiza_notificacion.IDCli, clientes_actualiza_notificacion.EstadoActual, clientes_actualiza_notificacion.fechaActualizacion,clientes_actualiza.Usuario from clientes_actualiza_notificacion,clientes_actualiza WHERE  clientes_actualiza_notificacion.EstadoActual='DIMENSION' AND clientes_actualiza.usuario='$usuario' AND  clientes_actualiza_notificacion.IDCli=clientes_actualiza.IDCli OR  clientes_actualiza_notificacion.EstadoActual='PERFILADO' AND  clientes_actualiza_notificacion.tipo_prospecto=0 AND clientes_actualiza.usuario='$usuario' AND clientes_actualiza_notificacion.IDCli=clientes_actualiza.IDCli;";
    $datos=$this->db->query($query)->result();
    return $datos;
   }

   

   function cliente_cierre_notificacion($usuario){
    $query="SELECT  clientes_actualiza_notificacion.IDCli, clientes_actualiza_notificacion.EstadoActual, clientes_actualiza_notificacion.fechaActualizacion,clientes_actualiza.Usuario from clientes_actualiza_notificacion,clientes_actualiza WHERE  clientes_actualiza_notificacion.EstadoActual='REGISTRADO' AND clientes_actualiza_notificacion.tipo_prospecto=0 AND clientes_actualiza.usuario='$usuario' AND  clientes_actualiza_notificacion.IDCli=clientes_actualiza.IDCli OR  clientes_actualiza_notificacion.EstadoActual='REGISTRADO' AND clientes_actualiza_notificacion.tipo_prospecto=0 AND  clientes_actualiza_notificacion.tipo_prospecto=0 AND clientes_actualiza.usuario='$usuario' AND clientes_actualiza_notificacion.IDCli=clientes_actualiza.IDCli";
    $datos=$this->db->query($query)->result();
    return $datos;
   }

  function cliente_leads_notificacion($usuario){
    $query="SELECT  clientes_actualiza_notificacion.IDCli, clientes_actualiza_notificacion.EstadoActual, clientes_actualiza_notificacion.fechaActualizacion,clientes_actualiza.Usuario from clientes_actualiza_notificacion,clientes_actualiza WHERE  clientes_actualiza_notificacion.EstadoActual='SIN VENTA' AND clientes_actualiza_notificacion.tipo_prospecto=3 AND clientes_actualiza.usuario='$usuario' AND  clientes_actualiza_notificacion.IDCli=clientes_actualiza.IDCli OR  clientes_actualiza_notificacion.EstadoActual='SIN VENTA' AND clientes_actualiza_notificacion.tipo_prospecto=0 AND  clientes_actualiza_notificacion.tipo_prospecto=3 AND clientes_actualiza.usuario='$usuario' AND clientes_actualiza_notificacion.IDCli=clientes_actualiza.IDCli";
    $datos=$this->db->query($query)->result();
    return $datos;
   }




  function cliente_primera_cita(){
    $query="SELECT IDCli,EstadoActual,fechaActualizacion,Usuario from clientes_actualiza WHERE EstadoActual='DIMENSION' OR EstadoActual='PERFILADO' AND tipo_prospecto=0";
    $datos=$this->db->query($query)->result();
    return $datos;
   }

  function cliente_cierre(){
    $query="SELECT IDCli,EstadoActual,fechaActualizacion,Usuario from clientes_actualiza WHERE EstadoActual='REGISTRADO' AND tipo_prospecto=0";
    $datos=$this->db->query($query)->result();
    return $datos;
   }

   function cliente_leads(){
    $query="SELECT IDCli,EstadoActual,fechaActualizacion,Usuario from clientes_actualiza WHERE EstadoActual='SIN VENTA' AND tipo_prospecto=3";
    $datos=$this->db->query($query)->result();
    return $datos;
   }

   function existeNotificacion($id){
    $query="SELECT * from clientes_actualiza_notificacion WHERE IDCli='$id'";
    $datos=$this->db->query($query)->result();
    return $datos;
   }



   function nombreCliente($id){
    $nombre="";
    $query="SELECT Nombre, ApellidoP from clientes_actualiza WHERE IDCli='$id'";
    $datos=$this->db->query($query)->result();
   foreach ($datos as $row) {
        $nombre=$row->ApellidoP." ".$row->Nombre;
    }
    return $nombre;
   }

   function ClientesGenericosFiltroEstadoActual($estado){
    $query="SELECT * from clientes_actualiza WHERE EstadoActual='$estado'";
    $datos=$this->db->query($query)->result();
    return $datos;
   }
   //Modificacion 30/22
   function confguracion_agenda($usuario){
    $query="SELECT * from calendario_conf_personal WHERE idPersona='$usuario' ORDER BY id ASC";
    $datos=$this->db->query($query)->result();
    return $datos;
   }

   function configuracion_agenda_capital($usuario){
    $query="SELECT * from calendario_conf_capital WHERE idPersona='$usuario' ORDER BY id ASC";
    $datos=$this->db->query($query)->result();
    return $datos;
   }

   function agenda_citas_asesores($usuario){
    $query="SELECT * from calendario_citas_asesores WHERE id_userInfo='$usuario' AND asesor_online=1 ORDER BY fecha ASC";
    $datos=$this->db->query($query)->result();
    return $datos;
   }

   function agenda_citas_asesores_capital($usuario){
    $query="SELECT * from calendario_citas_asesores WHERE id_userInfo='$usuario' AND asesor_online=0 ORDER BY fecha ASC";
    $datos=$this->db->query($query)->result();
    return $datos;
   }

  


   //fin

   
//---------------------------------------
function cliente_tareas_notificacion($usuario)
   {
    $query="select pt.idtarea,t.nombre,'ALERTA',t.fechaalerta  from ptareas pt,tareas t where pt.alerta = 1
    and pt.idtarea=t.idtarea and pt.idpersona = '$usuario'";
    $datos=$this->db->query($query)->result();
    return $datos;
   }
//-----------------------------------------

//*** Miguel Jaime 05/11/2020
  function promedio($id){
    $query="SELECT (sum(if(evc.tipoEstrellas= 0 and evcp.calificacionValidador=1,1,0))) sumClienteNuevo,(sum(if(evc.tipoEstrellas=1 and evcp.calificacionValidador=1,1,0)))sumCliente,(sum(if(evcp.calificacionValidador=1,1,0))) sumTotal,(sum(if(evc.tipoEstrellas= 0 ,1,0))) totalClienteNuevo,(sum(if(evc.tipoEstrellas= 1 ,1,0))) totalCliente,(sum(if(evc.tipoEstrellas= 1 || evc.tipoEstrellas= 0,1,0))) total,(cast(min(evc.fechaCreacion)as date)) as primerFechaCalificacion from estrellasvalidadorcabecera evc
    left join estrellasvalidadorcabecerapartidas evcp on evcp.idEstrellasValidadorCabecera=evc.idestrellasvalidadorcabecera where idPersona='$id'";
    $datos=$this->db->query($query)->result();
    return $datos;
  }

    function cuantos($id){
      $query="SELECT count(idPersona) as cuantosCalificaron from estrellasvalidadorcabecera where idPersona='$id'";
      $datos=$this->db->query($query)->result();
      $cuantos=0;
      foreach ($datos as $row) {
        $cuantos=$row->cuantosCalificaron;
      }
      return $cuantos;
    }

   function get_all_citas_asesores($id_user){
    $query="SELECT user_miInfo.fotoUser,user_miInfo.nombre,user_miInfo.apellidoP,user_miInfo.emailUser,calendario_citas_asesores.cliente,calendario_citas_asesores.fecha,calendario_citas_asesores.dia,calendario_citas_asesores.hora,calendario_citas_asesores.id_userInfo FROM user_miInfo,calendario_citas_asesores where calendario_citas_asesores.activo=0  AND user_miInfo.idPersona=calendario_citas_asesores.id_userInfo AND calendario_citas_asesores.asesor_online=1 AND calendario_citas_asesores.id_userInfo='$id_user' ORDER BY calendario_citas_asesores.fecha DESC";
    $datos=$this->db->query($query)->result();
    return $datos;
   }

   //-------------------------------- //Dennis Castillo 2024-01-14 "Actualización de citas de asesores online y tarjeta digital en convocar reunión"
   function get_all_diaries($id_user){
    //$query="SELECT user_miInfo.fotoUser,user_miInfo.nombre,user_miInfo.apellidoP,user_miInfo.emailUser,calendario_citas_asesores.cliente,calendario_citas_asesores.fecha,calendario_citas_asesores.dia,calendario_citas_asesores.hora,calendario_citas_asesores.id_userInfo FROM user_miInfo,calendario_citas_asesores where calendario_citas_asesores.activo=0  AND user_miInfo.idPersona=calendario_citas_asesores.id_userInfo AND calendario_citas_asesores.asesor_online=1 AND calendario_citas_asesores.id_userInfo='$id_user' ORDER BY calendario_citas_asesores.fecha DESC";
    $query="SELECT user_miInfo.fotoUser,user_miInfo.nombre,user_miInfo.apellidoP,user_miInfo.emailUser, calendario_citas_asesores.*
            FROM user_miInfo,calendario_citas_asesores 
            where calendario_citas_asesores.activo = 0  
            AND user_miInfo.idPersona=calendario_citas_asesores.id_userInfo AND calendario_citas_asesores.asesor_online IN (0, 1) 
            AND calendario_citas_asesores.id_userInfo='$id_user'
            AND calendario_citas_asesores.fecha != ''
            AND calendario_citas_asesores.fecha IS NOT NULL
            AND calendario_citas_asesores.hora != ''
            AND calendario_citas_asesores.hora IS NOT NULL
            ORDER BY calendario_citas_asesores.fecha DESC";
    $datos=$this->db->query($query)->result();
    return $datos;
   }
   //--------------------------------

//Extraer todos los asesores online activados para mostrar en la pagina asesores online
   function AgentesActivos(){
    $query="SELECT activar_userInfo.id_user,user_miInfo.fotoUser,user_miInfo.nombre,user_miInfo.apellidoP,user_miInfo.emailUser FROM user_miInfo,activar_userInfo where activar_userInfo.activo=1  AND activar_userInfo.id_user=user_miInfo.idPersona";
    $datos=$this->db->query($query)->result();
    return $datos;
   }
  
//Extraer todas las citas online pendientes no agendadas  
function getCitasOnline(){
    $query="SELECT fecha  FROM calendario_citas_asesores where activo=0 AND asesor_online=1 order by fecha asc";
    return $this->db->query($query)->result();

  }

//Extraer citas de asesores online que ya fueron enviadas las notificaciones con liga de videollamada
  function getCitasOnlineEnviados(){
    $query="SELECT user_miInfo.nombre, calendario_citas_asesores.* FROM calendario_citas_asesores,user_miInfo where calendario_citas_asesores.activo=0  AND calendario_citas_asesores.enviado=1 AND user_miInfo.idPersona=calendario_citas_asesores.id_userInfo AND calendario_citas_asesores.asesor_online=1
     ORDER BY calendario_citas_asesores.id desc";
    return $this->db->query($query)->result();
  }

//Extraer todas la citas de asesores online que requieran crear liga de video llamada como zoom y meet
  function getCitasOnlinePendientes(){
    $query="SELECT user_miInfo.nombre,user_miInfo.emailUser, calendario_citas_asesores.* FROM calendario_citas_asesores,user_miInfo where calendario_citas_asesores.medio='zoom' AND calendario_citas_asesores.activo=0 AND calendario_citas_asesores.enviado=0 AND user_miInfo.idPersona=calendario_citas_asesores.id_userInfo AND calendario_citas_asesores.asesor_online=1 OR calendario_citas_asesores.medio='meet' AND calendario_citas_asesores.activo=0 AND calendario_citas_asesores.enviado=0 AND user_miInfo.idPersona=calendario_citas_asesores.id_userInfo AND calendario_citas_asesores.asesor_online=1
     ORDER BY calendario_citas_asesores.id desc";
    return $this->db->query($query)->result();
  }

//Actualizar el calendario de citas online con la liga y el password de la video conferencia 
  function guardar_liga_asesores($data){
    $this->db->set('liga_zoom',$data['liga']);
    $this->db->set('password_liga',$data['password']);
    $this->db->where('id',$data['id']);
    $this->db->update('calendario_citas_asesores');
    return;

  }
  

  function guardar_liga_reunion($data){
    $this->db->set('liga',$data['liga']);
    $this->db->set('password',$data['password']);
    $this->db->where('id_cal',$data['id']);
    $this->db->update('cal_events_json');
    return;

  }

//Extraer todas la citas pendientes de asesores online
  function getCitaOnlinePendiente($id){
    $query="SELECT user_miInfo.nombre, user_miInfo.emailUser, calendario_citas_asesores.* FROM calendario_citas_asesores,user_miInfo where calendario_citas_asesores.id='$id' AND user_miInfo.idPersona=calendario_citas_asesores.id_userInfo";
    return $this->db->query($query)->result();
  }

//Actualizar la tabla de calendario de citas de asesores online una vez enviado el correo
  function setCitaOnlinePendiente($id){
    $this->db->set('enviado',1);
    $this->db->where('id',$id);
    $this->db->update('calendario_citas_asesores');
    return;
  }

//Convocatoria de Reuniones//

//Extraer todas las convocatorias enviadas
  function getAllConvocatoriaReunionEnviados(){
   $query="SELECT cal_events.*,cal_events_json.liga,cal_events_json.password FROM cal_events,cal_events_json where cal_events_json.enviado=1 AND cal_events.cal_id=cal_events_json.id_cal ORDER BY cal_events.id DESC";
    return $this->db->query($query)->result();
  }

//Extraer una convocatoria especifica
  function getConvocatoriaReunion($id){
    $query="SELECT * FROM cal_events where cal_id='$id'";
    return $this->db->query($query)->result();
  }

//Extraer correo de invitados externos
  function getAllEmailConvocatoriaExternos($id){
   $query="SELECT * FROM catalog_correos_externos where id_evento='$id' and activo=1";
    return $this->db->query($query)->result();
  }
//Extraer correo de invitados internos 
  function getAllEmailConvocatoriaInternos($id){
   $query="SELECT * FROM invitados_eventos where id_evento='$id'";
    return $this->db->query($query)->result();
  }

//Insertar datos del json que proviene del calendario convocar reunion
function setCalEventsJson($data){
  $json=array(
        "id_cal"=>$data['idEvento'],
        "correo"=>$data['correo'],
        "titulo"=>$data['titulo'],
        "descripcion"=>$data['descripcion'],
        "fecha_inicio"=>$data['fecha_inicio'],
        "fecha_final"=>$data['fecha_final'],
        "hora_inicio"=>$data['hora_inicio'],
        "hora_final"=>$data['hora_final'],
        "lugar"=>$data['lugar'],
        "clasificacion"=>$data['clasificacion'],
        "sub_categoria_capacitacion"=>$data['sub_categoria_capacitacion'],
        "ramo_capacitacion"=>$data['ramo_capacitacion'],
        "liga"=>$data['liga'],
        "password"=>$data['password'],
        "idLiga"=>$data['idLiga']

  );
  $this->db->insert('cal_events_json',$json);
                /*Envia SMS de Notificacion a Marketing
                 $telefono="9996439995";
                 $mensaje="*** Solicitud de Creacion - Liga para VideoLlamada Convocatoria de Reunion GAP ***";
                 $mensaje.="Creador: ".$data['correo']." Evento:".$data['titulo']." Fecha: ".$data['fecha_inicio']." Hora: ".$data['hora_inicio'];
                 $this->enviaSMS($telefono,$mensaje);
                 */
  }
  //Extraer una convocatoria especifica Json
  function getConvocatoriaReunionJson($id){
    $query="SELECT * FROM cal_events_json where id_cal='$id'";
    return $this->db->query($query)->row(); //result();
  }
  //----------------------------------------
  function getEmailNoDeclined($evento){ //Nuevo Dennis [2021-08-23]

    $where = 'id_evento = "'.$evento.'" AND (estado = "pendiente" OR estado = "aceptado" OR estado = "tentativo")';
    $this->db->where($where);
    $query = $this->db->get("invitados_eventos");

    return $query->num_rows() > 0 ? $query->result() : array();
  }

  //----------------------------------------
//actualizar la tabla cal events json en caso de ya haber enviado los correos
  function setCorreoEnviado($id){
    $this->db->set('enviado',1);
    $this->db->where('id_cal',$id);
    $this->db->update('cal_events_json');
    return;
  }

function enviaSMS($numero,$mensaje){
     $filename = getcwd()."/../xml/config.xml";
      $response = "";
      $params = array("apikey" => "0bf959dfc9127cef8131396dd312548c6f93354c");
      curl_setopt_array($ch = curl_init(), array(
        CURLOPT_URL => "https://api.smsmasivos.com.mx/auth",
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_POST => 1,
        CURLOPT_POSTFIELDS => http_build_query($params),
        CURLOPT_RETURNTRANSFER => 1
      ));
      $response = curl_exec($ch);
      curl_close($ch);
      $response_obj = json_decode($response, true);
      $text =$mensaje;
      $number = $numero; 
      $country = "052";
      $name = "ASESORES CAPITAL SEGUROS Y FIANZAS";
      $sandbox = "0";

      if($name == ""){$name = "Escribe un nombre para tu campaña ".date("Y-m-d H:i:s");}
      $params = array("message" => $text,"numbers" => $number,"country_code" => $country,"name" => $name,"sandbox" => $sandbox);
     $headers = array("token: ".$response_obj['token']);

      curl_setopt_array($ch = curl_init(), array(
        CURLOPT_URL => "https://api.smsmasivos.com.mx/sms/send",
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_HEADER => 0,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_POST => 1,
        CURLOPT_POSTFIELDS => http_build_query($params),
        CURLOPT_RETURNTRANSFER => 1
      ));
      $response = curl_exec($ch);
      curl_close($ch);
  }
  //-------------Dennis [2021-03-11]--------------------------------------------------------------------
  function devuelveAvanceCobranzaKpi($idPersona){

    $resultado=array();
  
    $this->db->where("idPersona",$idPersona);
    $query=$this->db->get("avance_cobranza_kpi");
  
    if($query->num_rows()>0){
      $resultado=$query->row();
    }
  
    return $resultado;
  }
  //-------------Dennis [2021-03-11]--------------------------------------------------------------------
  function inserta_avance_cobranza_kpi($array){
  
    $bandera=false;
  
    $this->db->insert("avance_cobranza_kpi",$array);
  
    if($this->db->trans_status()===FALSE){
      $this->db->trans_rollback();
    } else{
      $this->db->trans_commit();
      $bandera=true;
    }
  
    return $bandera;
  
  }
  //-------------Dennis [2021-03-11]--------------------------------------------------------------------
  function actualiza_avance_cobranza_kpi($agente,$array){
  
    $bandera=false;
  
    $this->db->where("idPersona",$agente);
    $this->db->update("avance_cobranza_kpi",$array);
  
    if($this->db->trans_status()===FALSE){
      $this->db->trans_rollback();
    } else{
      $this->db->trans_commit();
      $bandera=true;
    }
  
    return $bandera;
  
  }
 //modificacion [Miguel Jaime]

 function get_prospecto_agente($id){
   $sql="SELECT * FROM  prospectos_agentes where id='$id'";
   return $this->db->query($sql)->result();
 }

 function modificar_agentes_seleccionados_asignacion($data){
   $asignado=$data['asignado'];
   $prospectos=$data['prospectos'];
   $rs=explode(',', $prospectos);
   foreach ($rs as $row) {
       $sql="UPDATE prospectos_agentes set asignado='$asignado'  WHERE id='$row'";
       $this->db->query($sql);
   }
   return;
 }

 function modificar_agentes_seleccionados($data){
   $status=$data['status'];
   $prospectos=$data['prospectos'];
   $rs=explode(',', $prospectos);
   foreach ($rs as $row) {
     $sql="UPDATE prospectos_agentes set status='$status' WHERE id='$row'";
     $this->db->query($sql);
   }
   return;
 }

 function eliminar_prospecto_agente($id){
   $sql="DELETE FROM prospectos_agentes where id='$id'";
   return $this->db->query($sql);
 }

 function prospectos_agentes(){
   $user=$this->tank_auth->get_usermail();
   switch ($user) {
      case 'DIRECTORGENERAL@AGENTECAPITAL.COM':
       $sql="SELECT * FROM  prospectos_agentes order by id DESC";
       break;
     case 'MARKETING@AGENTECAPITAL.COM':
       $sql="SELECT * FROM  prospectos_agentes order by id DESC";
       break;
     case 'COORDINADOR@CAPCAPITAL.COM.MX':
       $sql="SELECT * FROM  prospectos_agentes WHERE asignado='COORDINADOR@CAPCAPITAL.COM.MX' order by id DESC";
     break;
     case 'COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX':
       $sql="SELECT * FROM  prospectos_agentes WHERE asignado='COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX' order by id DESC";
     break;
     case 'EJECUTIVOCOMERCIAL@ASESORESCAPITAL.COM':
        $sql="SELECT * FROM  prospectos_agentes WHERE asignado='EJECUTIVOCOMERCIAL@ASESORESCAPITAL.COM' order by id DESC";
     break;
     case 'AUXILIARCOMERCIAL@CAPCAPITAL.COM.MX':
       $sql="SELECT * FROM  prospectos_agentes WHERE asignado='AUXILIARCOMERCIAL@CAPCAPITAL.COM.MX' order by id DESC";
     break;
     default:
     return false;
     break;
   }
   return $this->db->query($sql)->result();
 }
    
    function prospectos_leads(){
      $query="SELECT * from clientes_actualiza WHERE leads<>'' AND tipo_prospecto=0";
      $datos=$this->db->query($query)->result();
      return $datos;
    }

 //fin de modificacion

 //-------------- Dennis [2021-04-19] ---------------------------
 function obtenerAvanceCobranzaPorRegion($region){

  $resultado=array();

  $this->db->where("reporte", $region);
  $query=$this->db->get("avance_cobranza_kpi_por_reporte");

  if($query->num_rows()>0){

    $resultado=$query->row();
  }

  return $resultado;
 }

  //----------------- Dennis [2021-04-19] -----------------------
  function inserta_avance_cobranza_kpi_por_region($array){
    
    //$bandera=false;

    $this->db->insert("avance_cobranza_kpi_por_reporte",$array);

    /*if($this->db->trans_status()===FALSE){
      $this->db->trans_rollback();
    } else{
      $this->db->trans_commit();
      $bandera=true;
    }*/

    return $this->db->insert_id();//$bandera;
  }
  //------------------ Dennis [2021-04-19] ----------------------
  function avance_cobranza_agente_region($idPersona){

    $resultado=array();

    if($idPersona!=822){
      //$this->db->from("enlace_kpi_cobranza_reporte");
      $this->db->from("relacion_usuario_cobranza");
      $this->db->join("avance_cobranza_kpi_por_reporte", "avance_cobranza_kpi_por_reporte.id_tipoReporte_avance=relacion_usuario_cobranza.id_referencia","inner");
      $this->db->where("relacion_usuario_cobranza.idPersona",$idPersona);
      //$this->db->join("avance_cobranza_kpi","avance_cobranza_kpi.idPersona=enlace_kpi_cobranza_reporte.idPersona","inner");
      //$this->db->join("avance_cobranza_kpi_por_reporte","avance_cobranza_kpi_por_reporte.id_tipoReporte_avance=enlace_kpi_cobranza_reporte.id_tipoReporte_avance");   
      //$this->db->where("enlace_kpi_cobranza_reporte.idPersona",$idPersona);
    } else{
      //$this->db->group_by("avance_cobranza_kpi.idPersona");
      return $this->devuelveAvanceCobranzaKpi($idPersona);
    }

    $query=$this->db->get(); //"avance_cobranza_kpi"
  
    if($query->num_rows()>0){
      $resultado= $idPersona != 822 ? $query->row() : $query->result();
    }
  
    return $resultado;

  }
  //----------------- Dennis [2021-04-19] -----------------------
  function devuelveTodosLosRegistrosPorRegion(){

    $resultado=array();
    
    $query=$this->db->get("avance_cobranza_kpi_por_reporte");

    if($query->num_rows()>0){
      $resultado=$query->result();
    }

    return $resultado;
  }
  //----------------- Dennis [2021-04-28] -----------------------
  function insertaAvanceKPIEnPrima($insert_array){

    //$rr=false;

    $this->db->insert("avance_cobranza_kpi_por_prima",$insert_array);

    /*if($this->db->trans_status()===FALSE){
      $this->db->trans_rollback();
    } else{
      $this->db->trans_commit();
      $rr=true;
    }*/

    return $this->db->insert_id();
  }
  //----------------- Dennis [2021-04-28] -----------------------
  function insertaAvanceKPIEnComision($insert_array){

    //$rr=false;

    $this->db->insert("avance_cobranza_kpi_por_comision",$insert_array);

    /*if($this->db->trans_status()===FALSE){
      $this->db->trans_rollback();
    } else{
      $this->db->trans_commit();
      $rr=true;
    }*/

    return $this->db->insert_id();
  }
  //----------------- Dennis [2021-04-28] -----------------------
  function devuelveRelacionKPI($id,$reporte,$referencia){

    $array=array();

    $this->db->where("idPersona",$id);
    $this->db->where("reporte",$reporte);
    $this->db->where("tipo",$referencia);

    $query=$this->db->get("relacion_usuario_cobranza");

    if($query->num_rows()>0){
      $array=$query->result();
    }

    return $array;
  }
  //----------------- Dennis [2021-04-28] -----------------------
  function devuelveRegistroCobranza($reporte, $indicador, $resultado){

    $respuesta= array();
    $tabla= "";
    $this->db->where("reporte",$reporte);

    switch($indicador){
      case "recibos": $tabla="avance_cobranza_kpi_por_reporte";
      break;
      case "prima": $tabla="avance_cobranza_kpi_por_prima";
      break;
      case "comision": $tabla="avance_cobranza_kpi_por_comision";
      break;

    }

    $query = $this->db->get($tabla);

    if($query->num_rows()>0){

      $respuesta= $resultado == 1 ? $query->row() : $query->result();
    }

    return $respuesta;
  }
  //----------------- Dennis [2021-04-28] -----------------------
  function asignaRelacionKpi($arr){    
    
    $resultado=false;

    $this->db->insert("relacion_usuario_cobranza",$arr);

    if($this->db->trans_status()===FALSE){
      $this->db->trans_rollback();
    } else{
      $this->db->trans_commit();
      $resultado=true;
    }

    return $resultado;
  }
  //----------------- Dennis [2021-04-28] -----------------------
  function actualizaAvanceKPIEnPrima($array,$idReporte){

    $res=true;

    $this->db->where("id_tipoReporte_avance",$idReporte);
    $this->db->update("avance_cobranza_kpi_por_prima", $array);

    if($this->db->trans_status()===FALSE){

      $this->db->trans_rollback();
    } else{
      $this->db->trans_commit();
      $res=true;
    }

    return $res;
  }
  //----------------- Dennis [2021-04-28] -----------------------
  function actualizaAvanceKPIEnComision($array,$idReporte){
    $res=true;

    $this->db->where("id_tipoReporte_avance",$idReporte);
    $this->db->update("avance_cobranza_kpi_por_comision", $array);

    if($this->db->trans_status()===FALSE){

      $this->db->trans_rollback();
    } else{
      $this->db->trans_commit();
      $res=true;
    }

    return $res;
  }
  //----------------- Dennis [2021-04-28] -----------------------
  function actualizaAvanceKPIEnRecibos($array,$idReporte){

    $res=true;

    $this->db->where("id_tipoReporte_avance",$idReporte);
    $this->db->update("avance_cobranza_kpi_por_reporte", $array);

    if($this->db->trans_status()===FALSE){

      $this->db->trans_rollback();
    } else{
      $this->db->trans_commit();
      $res=true;
    }

    return $res;
  }
  //----------------- Dennis [2021-04-28] -----------------------
  function devuelveDatosCobranzaPorComision($idPersona,$indicador = 0){

    $res=array();

    $this->db->from("relacion_usuario_cobranza");
    $this->db->join("avance_cobranza_kpi_por_comision","avance_cobranza_kpi_por_comision.id_tipoReporte_avance=relacion_usuario_cobranza.id_referencia","inner");
    $this->db->where("idPersona", $idPersona);
    $this->db->where("tipo", "comision");
    $query=$this->db->get();

    if($query->num_rows()>0){
      $res= $indicador == 1 ? $query->row() : $query->result();
    }

    return $res;
  }
   //----------------- Dennis [2021-05-10] ----------------------
   function insertaCambioDivisas($moneda){

    $respuesta = false;
 
    $this->db->insert("cambioDeMoneda",$moneda);

    if($this->db->trans_status() === FALSE){
      $this->db->trans_rollback();
    } else{

      $this->db->trans_commit();
      $respuesta = true;
    }

    return $respuesta;
  }
  //----------------- Dennis [2021-05-12] ----------------------
  function devuelveRelacionKPIPorPersona($idPersona){

    $res = array();

    $this->db->where("idPersona",$idPersona);
    $query = $this->db->get("relacion_usuario_cobranza");

    if($query->num_rows()>0){

      $res = $query->result();
    }

    return $res;
  }
  //-----------------------------
  //Dennis [2021-09-07]
  function getAllCommission(){

    $query = $this->db->get("avance_cobranza_kpi_por_comision");

    return $query->num_rows() > 0 ? $query->result() : array();
  }
  //-----------------------------
  //Dennis [2021-09-07]
  function getAllBonus(){

    $query = $this->db->get("avance_cobranza_kpi_por_prima");

    return $query->num_rows() > 0 ? $query->result() : array();
  }
  //---------------------------
  //Dennis [2021-09-07]
  function getAllCount(){

    $query = $this->db->get("avance_cobranza_kpi_por_reporte");

    return $query->num_rows() > 0 ? $query->result() : array();
  }

  //-------------------------
  // Dennis Castillo [2021-10-31]
  function insertaRegistros($array, $table){

    $this->db->insert($table, $array);    
}
//--------------------------------------
// Dennis Castillo [2021-10-31]
function getProspectiveAgents($email){

  $management = array("DIRECTORGENERAL@AGENTECAPITAL.COM", "DIRECTORCOMERCIAL@AGENTECAPITAL.COM", "SISTEMAS@ASESORESCAPITAL.COM", "MARKETING@AGENTECAPITAL.COM");

  //$this->db->select("b.*, a.asignado, a.ubicacion, a.medio, a.tiene_cedula, a.comentarios, a.status");
  $this->db->from("prospectos_agentes a");
  $this->db->where("a.status !=", "RECLUTADO");
  $this->db->where("a.status !=", "DESCARTADO");
  $this->db->where("a.estadoRegistro", "activo");
  //$this->db->join("prospecto_agente_a_capital_humano b", "a.id = b.referenciaProspecto", "inner");

  if(!in_array($email, $management)){
    $this->db->where("a.asignado", $email);
    $this->db->or_where("a.asignado", "");
  }
  $query = $this->db->get();

  return $query->num_rows() > 0 ? $query->result() : array();
}
//--------------------------------------
// Dennis Castillo [2021-10-31]
function getProspectiveAgentProgress($id){

  $this->db->where("idProspecto", $id);
  $query = $this->db->get("prospective_to_user");

  return $query->num_rows() > 0 ? $query->row() : array();
}
//--------------------------------------
// Dennis Castillo [2021-10-31]
function getGeneralDataAgent($id){

    $this->db->from("prospectos_agentes a");
    $this->db->join("direccion_prospecto_agente b", "a.id = b.idProspecto", "left");
    $this->db->where("a.id", $id);
    $query = $this->db->get();

    return $query->num_rows() > 0 ? $query->result() : array();
}
//--------------------------------------
// Dennis Castillo [2021-10-31]
function getAgentDataForCreate($id){

  $this->db->select("prospecto AS nombres, apellido_paterno AS apellidoPaterno, apellido_materno AS apellidoMaterno, correo AS emailPersonal, numero_telefono AS celPersonal");
  $this->db->from("prospectos_agentes");
  $this->db->where("id", $id);
  $query = $this->db->get();

  return $query->num_rows() > 0 ? $query->result() : array();
}
//--------------------------------------
// Dennis Castillo [2021-10-31]
function updateProspectiveUser($id, $array){ //Obsoleto

  $this->db->where("idProspecto", $id);
  $this->db->update("prospective_to_user", $array);
}
//--------------------------------------
// Dennis Castillo [2021-10-31]
//function updateStatusProspective($id){ //Obsoleto

  //$set = array("status" => "EN PROCESO");

  //$this->db->where("id", $id);
  //$this->db->update("prospectos_agentes", $set);
//}
//------------------------------------
// Dennis Castillo [2021-10-31]
function updateProspectiveData($array){

  $set = "";
  $fieldListProspective = $this->db->list_fields("prospectos_agentes");
  $fieldListAddress = $this->db->list_fields("direccion_prospecto_agente");
  foreach($array as $k => $sets_){

    $table = in_array($k, $fieldListProspective) ? "a." : "b.";

    if($k != "id"){
      $set .= "".$table.$k." = '".$sets_."',";
    }
  }

  $update = "update prospectos_agentes a left join direccion_prospecto_agente b on a.id = b.idProspecto set ".trim($set, ",")." where a.id = ".$array["id"]."";
  
  $this->db->query($update);
  //$this->db->where("id", $array["id"]);
  //unset($array["id"]);
  //$this->db->update("prospectos_agentes", $array);

  return 1;
}
//------------------------------------
// Dennis Castillo [2021-10-31]
function getProspectiveAgentProgressByIdPerson($idPersona){

  $this->db->select("*, CASE WHEN avance = 'liberado' THEN 'fired' ELSE 'cancelled' END AS estadoBaja", false);
  $this->db->where("idPersona", $idPersona);
  $query = $this->db->get("prospective_to_user");

  return $query->num_rows() > 0 ? $query->row() : array();
}
//-------------------------------------------
// Dennis Castillo [2021-10-31]
function newAgentsOnInducction($usr = null){

    $this->db->select("b.*,c.*, a.*");
    $this->db->from("prospective_to_user a");
    $this->db->join("persona b", "a.idPersona = b.idPersona", "inner");
    $this->db->join("users c", "b.idPersona = c.idPersona", "left");
    $this->db->where("a.avance", "induccion");
    $this->db->where("b.bajaPersona", 0);
    $this->db->where("c.banned", 0);
    $this->db->where("c.activated", 1);
    if(!empty($usr)){
      $this->db->where("b.userEmailCreacion", $usr);
    }

    $query = $this->db->get();

    return $query->num_rows() > 0 ? $query->result() : array();
}
//-----------------------------------------  Dennis Castillo [2022-04-01]
function newAgentsOnInducctionAndDocuments($usr = null){

  $this->db->select("b.*,c.*, a.*");
  $this->db->from("prospective_to_user a");
  $this->db->join("persona b", "a.idPersona = b.idPersona", "inner");
  $this->db->join("users c", "b.idPersona = c.idPersona", "left");
  $this->db->where_in("a.avance", array("induccion", "documento", "liberado"));
  $this->db->where("b.bajaPersona", 0);
  $this->db->where("c.banned", 0);
  $this->db->where("c.activated", 1);
  if(!empty($usr)){
    $this->db->where("b.userEmailCreacion", $usr);
  }

  $query = $this->db->get();

  return $query->num_rows() > 0 ? $query->result() : array();
}
//-----------------------------------------
// Dennis Castillo [2021-10-31]
function recruitProspective($id){

  $set = array("status" => "RECLUTADO");

  $this->db->where("id", $id);
  $this->db->update("prospectos_agentes", $set);
}
//-----------------------------------------
//Dennis Castillo [2021-11-01]
function getAssigned(){

	//$this->db->distinct();
	//$this->db->select("asignado");
	//$this->db->from();
	$query = $this->db->get("account_to_assign");

	return $query->num_rows() > 0 ? $query->result() : array();
}
//-----------------------------------------
//Dennis Castillo [2021-11-08]
function updateCheckProspectiveByPerson($array, $id){

  $this->db->trans_start();
  $this->db->where("idPersona", $id);
  $this->db->update("prospective_to_user", $array);
  $this->db->trans_complete();
  $response = true;

  if($this->db->trans_status() === FALSE){
    $response = false;
  }

  return $response;
}
//-----------------------------------------
//Dennis Castillo [2021-11-08]
function getAllProspectiveAgents(){

  $query = $this->db->get("prospective_to_user");
  return $query->num_rows() > 0 ? $query->result() : array();
}
//----------------------------------------- //Dennis Castillo [2021-12-10]
function getDxnData(){
  
  $this->db->where("DATE(fechaConsulta) >=", "DATE(CURDATE(), INTERVAL 1 DAY)"); // 2022-03-02
  $this->db->where("DATE(fechaConsulta) <=", "CURDATE()"); // 2022-03-03
  $this->db->order_by("id", "desc");
  $this->db->limit(4);
  $query = $this->db->get("avance_comercial_kpi_bxn");

  return $query->num_rows() > 0 ? $query->result() : array();
}
//------------------------- //Dennis Castillo [2022-02-21]
function getReceiptsPaidPerChannel($channel, $group = null, $period = null, $renewal = null, $docRenewal = null, $useNegative){

  $condition = !$useNegative ? array("PrimaNeta >" => 0) : array();

  $this->db->where("canal", $channel);

  if(!is_null($group)){

    $this->db->where("Grupo !=", $group);
  }

  if(!is_null($period)){

    $this->db->where("Periodo", $period);
  }

  if(!is_null($renewal)){

    $this->db->where("Renovacion", $renewal);
  }

  if(!is_null($docRenewal)){

    $this->db->where("RenovacionDocto", $docRenewal);
  }

  $this->db->where($condition);
  $query = $this->db->get("estado_financiero_ahora");

  return $query->num_rows() > 0 ? $query->result() : array();
}
//------------------------------ //Dennis Castillo [2022-02-21]
function getPendingReciptsPerChannel($channel, $group = null){

  if(!is_null($group)){
    $this->db->where("Grupo", $group);
  }

  $this->db->where("canal", $channel);
  $query = $this->db->get("estado_financiero_pendiente");

  return $query->num_rows() > 0 ? $query->result() : array();
}
//----------------------------- //Dennis Castillo [2022-02-21]
function updateKpi($data, $channel){

  $response = false;
  $set = '';

  foreach($data as $key => $value){
    if(strpos($key, "recibos") !== false){
      $set .= 'a.'. $key .' = '.$value.',';

    } elseif(strpos($key, "prima") !== false){
      $set .= 'b.'. $key .' = '.$value.',';

    } elseif(strpos($key, "comision") !== false){
      $set .= 'c.'. $key .' = '.$value.',';
    }
  }

  $dates = array_reduce(array("a", "b", "c"), function($acc, $curr){ $acc .= $curr.'.fecha_consulta_sicas = "'.date("Y-m-d H:i:s").'",';  return $acc; }, "");

  $update = 'update avance_cobranza_kpi_por_reporte a 
    inner join avance_cobranza_kpi_por_prima b on a.reporte = b.reporte
    inner join avance_cobranza_kpi_por_comision c on a.reporte = c.reporte
    set '. trim($set.$dates, ",").' where a.reporte = "'.$channel.'" ';

  $this->db->trans_begin();
  $this->db->query($update);

  if($this->db->trans_status() === FALSE){
    $this->db->trans_rollback();
  } else{
    $this->db->trans_commit();
    $response = true;
  }

  return $response;
}
//------------------------------ //Dennis Castillo [2022-02-25] -> [2022-03-01]
function updateProspectiveForStatus($whereIn, $update){

  $response = false;
  $this->db->trans_begin();
  //$this->db->join("prospective_to_user b", "a.id = b.idProspecto", "inner");
  $this->db->where_in("a.id", $whereIn);
  $this->db->update("prospectos_agentes a INNER JOIN prospective_to_user b ON a.id = b.idProspecto", $update);
    
  if($this->db->trans_status() === FALSE){
    $this->db->trans_rollback();
  } else{
    $this->db->trans_commit();
    $response = true;
  }

  return $response;
}
//------------------------------ //Dennis Castillo [2022-02-25]
function getProspectivesAgentsByIdPerson($idPersona){

  $this->db->where("idPersona", $idPersona);
  $query = $this->db->get("prospective_to_user");

  return $query->num_rows() > 0 ? $query->result() : array();
}
//------------------------------
function getAllPendingRecords($condition){
  
  $this->db->where($condition);
  $query = $this->db->get("estado_financiero_pendiente");

  return $query->num_rows() > 0 ? $query->result() : array();
}
//--------------------------
function getAllEffectedRecords($condition){
  
  $this->db->where($condition);
  $query = $this->db->get("estado_financiero_ahora");

  return $query->num_rows() > 0 ? $query->result() : array();
}
//--------------------------
function getEffectedRecordsFromFinancialState($condition){

  $this->db->where($condition);
  $query = $this->db->get("estadofinanciero");

  return $query->num_rows() > 0 ? $query->result() : array();
}
//------------------------------ //Dennis Castillo [2022-06-16]
function updateProspectiveStatus($condition, $set, $changeRelaseStatus){

  $this->db->trans_begin();
  $this->db->trans_strict(TRUE);
  $this->db->where($condition);
  $this->db->update("prospectos_agentes a INNER JOIN prospective_to_user b ON a.id = b.idProspecto", $set);

  if(!empty($changeRelaseStatus) && is_array($changeRelaseStatus)){
    $this->db->where("inducctionPerson", $changeRelaseStatus["person"]);
    $this->db->update("set_free_of_inducction", array("status" => $changeRelaseStatus["status"])); //layoff (baja de personal)
  }

  if($this->db->trans_status() === FALSE){
    $this->db->trans_rollback();
    return $this->db->error();
  } else{
    $this->db->trans_commit();
    return array("code" => 200, "message" => "Execute has successfull");
  }

}
//------------------------------
function updateDiary($id, $request){ //Dennis Castillo 2024-01-14 "Actualización de citas de asesores online y tarjeta digital en convocar reunión"

  $this->db->trans_begin();
  $this->db->where("id", $id);
  $this->db->update("calendario_citas_asesores", $request);

  if($this->db->trans_status() === FALSE){

    $this->db->trans_rollback();
  } else {
    $this->db->trans_commit();
  }

  return $this->db->trans_status();
}
//-----------------------------------------------------------------------------------------------------

  function getInformationSoldMonthly($info,$weeks) { //Creado [Suemy][2024-06-26]
    $data = array();
    foreach ($info['indicators'] as $key => $val) {
      $indicator = $key + 1;
      $class = "indicator";
      if ($info['report'] != 3) {
        $person = $this->db->query('SELECT p.tipoPersona FROM persona p INNER JOIN users us ON us.idPersona = p.idPersona WHERE us.email = "'.$info['email'].'"')->row()->tipoPersona;
        $IDVend = $this->db->query('SELECT IDVend FROM users WHERE email = "'.$info['email'].'"')->row()->IDVend;
        $con['sql_r1'] = $info['report'] != 1 ? 'Usuario = "'.$info['email'].'" AND' : "";
        $con['sql_r2'] = $info['report'] != 1 ? 'ca.Usuario = "'.$info['email'].'" AND' : "";
        $con['sql_cr'] = $info['report'] != 1 ? ($person == 1 ? 'usuarioResponsable = "'.$info['email'].'" AND' : 'usuarioVendedor = "'.$info['email'].'" AND') : "";
        $con['sql_cot'] = $info['report'] != 1 ? ($person == 1 ? 'ac.usuarioResponsable = "'.$info['email'].'" AND' : 'ac.usuarioVendedor = "'.$info['email'].'" AND') : "";
        $con['sql_com'] = $info['report'] != 1 ? ($person == 1 ? 'emailCanal = "'.$info['email'].'" AND' : 'IDVend = '.$IDVend.' AND') : "";
        $w1 = $this->getInformationByWeek($weeks['week1'],$info['type'],$con);
        $w2 = $this->getInformationByWeek($weeks['week2'],$info['type'],$con);
        $w3 = $this->getInformationByWeek($weeks['week3'],$info['type'],$con);
        $w4 = $this->getInformationByWeek($weeks['week4'],$info['type'],$con);
      }
      else {
        $w1 = $this->getInformationWeekByAgent($weeks['week1'],$info['email'],$info['type']);
        $w2 = $this->getInformationWeekByAgent($weeks['week2'],$info['email'],$info['type']);
        $w3 = $this->getInformationWeekByAgent($weeks['week3'],$info['email'],$info['type']);
        $w4 = $this->getInformationWeekByAgent($weeks['week4'],$info['email'],$info['type']);
      }
      switch($indicator) {
        case "1": $ind = 1; $week1 = $w1[0]; $week2 = $w2[0]; $week3 = $w3[0]; $week4 = $w4[0]; break;
        case "2": $ind = 2; $week1 = $w1[1]; $week2 = $w2[1]; $week3 = $w3[1]; $week4 = $w4[1]; break;
        case "3": $ind = 1; $week1 = $w1[2]; $week2 = $w2[2]; $week3 = $w3[2]; $week4 = $w4[2]; break;
        case "4": $ind = 3; $week1 = $w1[3]; $week2 = $w2[3]; $week3 = $w3[3]; $week4 = $w4[3]; break;
        case "5": $ind = 2; $week1 = $w1[4]; $week2 = $w2[4]; $week3 = $w3[4]; $week4 = $w4[4]; break;
        case "6": $ind = 1; $week1 = $w1[5]; $week2 = $w2[5]; $week3 = $w3[5]; $week4 = $w4[5]; break;
        case "7": $class = "indicator2"; $ind = 0; $week1 = $w1[6]; $week2 = $w2[6]; $week3 = $w3[6]; $week4 = $w4[6]; break;
        case "8": $class = "indicator2"; $ind = 0; $week1 = $w1[7]; $week2 = $w2[7]; $week3 = $w3[7]; $week4 = $w4[7]; break;
        case "9": $ind = 4; $week1 = $w1[8]; $week2 = $w2[8]; $week3 = $w3[8]; $week4 = $w4[8]; break;
      }
      //
      $add['title'] = $val;
      $add['class'] = $class;
      $add['tipo'] = strval($ind);
      $add['week1'] = $week1;
      $add['week2'] = $week2;
      $add['week3'] = $week3;
      $add['week4'] = $week4;
      array_push($data, $add);
    }
    return $data;
  }

  function getInformationByWeek($range,$type,$con) { //Modificado [Suemy][2024-09-19]
    switch ($type) {
      case '1':
        //
        $prospectos = $this->db->query('SELECT * FROM clientes_actualiza WHERE '.$con['sql_r1'].' DATE(fechaCreacionCA) BETWEEN "'.$range['dateI'].'" AND "'.$range['dateF'].'"')->result();
        //
        $cartera = $this->db->query('SELECT folioActividad, idSicas, nombreCliente, tipoActividad, subRamoActividad, Status_Txt, usuarioCreacion, usuarioVendedor, nombreUsuarioCreacion, nombreUsuarioVendedor, fechaCreacion, fechaActualizacion FROM actividades WHERE '.$con['sql_cr'].' DATE(fechaCreacion) BETWEEN "'.$range['dateI'].'" AND "'.$range['dateF'].'" AND cruce_cartera = "Si"')->result();
        //
        $referidos = $this->db->query('SELECT * FROM clientes_actualiza WHERE '.$con['sql_r1'].' DATE(fechaCreacionCA) BETWEEN "'.$range['dateI'].'" AND "'.$range['dateF'].'" AND referido = "Si"')->result();
        //
        $citas = $this->db->query('SELECT cc.*, ca.ApellidoP, ca.ApellidoM, ca.Nombre, ca.RazonSocial, ca.RFC, ca.EMail1, ca.Telefono1, ca.EstadoActual FROM comentarioscitacontacto cc INNER JOIN clientes_actualiza ca ON ca.IDCli = cc.idCli_CA WHERE cc.tipoCCC = 1 AND '.$con['sql_r2'].' DATE(cc.fechaCCC) BETWEEN "'.$range['dateI'].'" AND "'.$range['dateF'].'"')->result();
        //
        $cotizaciones = $this->db->query('SELECT ac.folioActividad, ac.idSicas, ac.nombreCliente, ac.tipoActividad, ac.subRamoActividad, ac.Status_Txt, ac.usuarioCreacion, ac.usuarioVendedor, ac.nombreUsuarioCreacion, ac.nombreUsuarioVendedor, ac.fechaCreacion, ac.fechaActualizacion FROM actividades ac INNER JOIN clientes_actualiza cl ON cl.IDCli = ac.IDCliClienteActualiza WHERE '.$con['sql_cot'].' DATE(ac.fechaCreacion) BETWEEN "'.$range['dateI'].'" AND "'.$range['dateF'].'"')->result();
        //
        $cierres = $this->db->query('SELECT * FROM clientes_actualiza WHERE '.$con['sql_r1'].' DATE(fechaActualizacion) BETWEEN "'.$range['dateI'].'" AND "'.$range['dateF'].'" AND EstadoActual = "EMITIDO"')->result();
        //
        $ratio1 = (count($cotizaciones) != 0) ? (count($cierres) != 0 ? count($cotizaciones) / count($cierres) : 0) : 0;
        $ratio2 = (count($prospectos) != 0) ? (count($cierres) != 0 ? count($prospectos) / count($cierres) : 0) : 0;
        //
        $comisiones = $this->db->query('SELECT * FROM estadofinanciero WHERE '.$con['sql_com'].' Periodo = 1 AND DATE(FechaPago) BETWEEN "'.$range['dateI'].'" AND "'.$range['dateF'].'"')->result();
        break;
      
      case '2':
        $prospectos = $this->db->query('SELECT COUNT(IDCli) AS cantidad FROM clientes_actualiza WHERE '.$con['sql_r1'].' DATE(fechaCreacionCA) BETWEEN "'.$range['dateI'].'" AND "'.$range['dateF'].'"')->row();
        $cartera = $this->db->query('SELECT COUNT(IdInterno) AS cantidad FROM actividades WHERE '.$con['sql_cr'].' DATE(fechaCreacion) BETWEEN "'.$range['dateI'].'" AND "'.$range['dateF'].'" AND cruce_cartera = "Si"')->row();
        $referidos = $this->db->query('SELECT COUNT(IDCli) AS cantidad FROM clientes_actualiza WHERE '.$con['sql_r1'].' DATE(fechaCreacionCA) BETWEEN "'.$range['dateI'].'" AND "'.$range['dateF'].'" AND referido = "Si"')->row();
        $citas = $this->db->query('SELECT COUNT(cc.idCCC) AS cantidad FROM comentarioscitacontacto cc INNER JOIN clientes_actualiza ca ON ca.IDCli = cc.idCli_CA WHERE cc.tipoCCC = 1 AND '.$con['sql_r2'].' DATE(cc.fechaCCC) BETWEEN "'.$range['dateI'].'" AND "'.$range['dateF'].'"')->row();
        $cotizaciones = $this->db->query('SELECT COUNT(ac.IdInterno) AS cantidad FROM actividades ac INNER JOIN clientes_actualiza cl ON cl.IDCli = ac.IDCliClienteActualiza WHERE '.$con['sql_cot'].' DATE(ac.fechaCreacion) BETWEEN "'.$range['dateI'].'" AND "'.$range['dateF'].'"')->row();
        $cierres = $this->db->query('SELECT COUNT(IDCli) AS cantidad FROM clientes_actualiza WHERE '.$con['sql_r1'].' DATE(fechaActualizacion) BETWEEN "'.$range['dateI'].'" AND "'.$range['dateF'].'" AND EstadoActual = "EMITIDO"')->row();
        $comisiones = $this->db->query('SELECT SUM(PrimaTotal) AS cantidad FROM estadofinanciero WHERE '.$con['sql_com'].' Periodo = 1 AND DATE(FechaPago) BETWEEN "'.$range['dateI'].'" AND "'.$range['dateF'].'"')->row(); //IDRecibo (Por cantidad) | PrimaNeta (Por ingreso)
        //
        $prospectos = !empty($prospectos) ? $prospectos->cantidad : 0;
        $referidos = !empty($referidos) ? $referidos->cantidad : 0;
        $cartera = !empty($cartera) ? $cartera->cantidad : 0;
        $citas = !empty($citas) ? $citas->cantidad : 0;
        $cotizaciones = !empty($cotizaciones) ? $cotizaciones->cantidad : 0;
        $cierres = !empty($cierres) ? $cierres->cantidad : 0;
        $ratio1 = ($cotizaciones != 0) ? ($cierres != 0 ? $cotizaciones / $cierres : 0) : 0;
        $ratio2 = ($prospectos != 0) ? ($cierres != 0 ? $prospectos / $cierres : 0) : 0;
        $comisiones = $comisiones->cantidad != NULL ? number_format($comisiones->cantidad,2) : 0;
        break;
    }
    
    $data['0'] = $prospectos;
    $data['1'] = $cartera;
    $data['2'] = $referidos;
    $data['3'] = $citas;
    $data['4'] = $cotizaciones;
    $data['5'] = $cierres;
    $data['6'] = $ratio1 != 0 ? (strpos($ratio1, ".") ? number_format($ratio1,2) : $ratio1) : $ratio1;
    $data['7'] = $ratio2 != 0 ? (strpos($ratio2, ".") ? number_format($ratio2,2) : $ratio2) : $ratio2;
    $data['8'] = $comisiones;
    return $data;
  }

  function getInformationWeekByAgent($range,$user,$type) { //Modificado [Suemy][2024-09-19]
    $data = array();
    $d0 = 0;
    $d1 = 0;
    $d2 = 0;
    $d3 = 0;
    $d4 = 0;
    $d6 = 0;
    //$d8 = 0;
    $agents = $this->db->query('SELECT us.email FROM persona p INNER JOIN users us ON us.idPersona = p.idPersona WHERE p.idPersona != 0 AND us.activated = 1 AND us.banned = 0 AND p.userEmailCreacion = "'.$user.'"')->result();
    foreach ($agents as $val) {
      $IDVend = $this->db->query('SELECT IDVend FROM users WHERE email = "'.$val->email.'"')->row()->IDVend;
      $con['sql_r1'] = 'Usuario = "'.$val->email.'" AND';
      $con['sql_r2'] = 'ca.Usuario = "'.$val->email.'" AND'; 
      $con['sql_cr'] = 'usuarioVendedor = "'.$val->email.'" AND';
      $con['sql_cot'] = 'ac.usuarioVendedor = "'.$val->email.'" AND';
      $con['sql_com'] = $IDVend != 0 ? 'IDVend = '.$IDVend.' AND' : "";
      /*$info = $this->getInformationByWeek($range,2,$con); //Se tarda más
      $d0 = $d0 + $info[0]; //Prospectos
      $d1 = $d1 + $info[1]; //Cruce de cartera
      $d2 = $d2 + $info[2]; //Referidos
      $d3 = $d3 + $info[3]; //Citas
      $d4 = $d4 + $info[4]; //Cotizaciones
      $d5 = $d5 + $info[5];*/ //Cierres
      //$d8 = $d8 + $info[8]; //Comisiones
      //
      $prospectos = $this->db->query('SELECT COUNT(IDCli) AS cantidad FROM clientes_actualiza WHERE '.$con['sql_r1'].' DATE(fechaCreacionCA) BETWEEN "'.$range['dateI'].'" AND "'.$range['dateF'].'"')->row();
        $cartera = $this->db->query('SELECT COUNT(IdInterno) AS cantidad FROM actividades WHERE '.$con['sql_cr'].' DATE(fechaCreacion) BETWEEN "'.$range['dateI'].'" AND "'.$range['dateF'].'" AND cruce_cartera = "Si"')->row();
        $referidos = $this->db->query('SELECT COUNT(IDCli) AS cantidad FROM clientes_actualiza WHERE '.$con['sql_r1'].' DATE(fechaCreacionCA) BETWEEN "'.$range['dateI'].'" AND "'.$range['dateF'].'" AND referido = "Si"')->row();
        $citas = $this->db->query('SELECT COUNT(cc.idCCC) AS cantidad FROM comentarioscitacontacto cc INNER JOIN clientes_actualiza ca ON ca.IDCli = cc.idCli_CA WHERE cc.tipoCCC = 1 AND '.$con['sql_r2'].' DATE(cc.fechaCCC) BETWEEN "'.$range['dateI'].'" AND "'.$range['dateF'].'"')->row();
        $cotizaciones = $this->db->query('SELECT COUNT(ac.IdInterno) AS cantidad FROM actividades ac INNER JOIN clientes_actualiza cl ON cl.IDCli = ac.IDCliClienteActualiza WHERE '.$con['sql_cot'].' DATE(ac.fechaCreacion) BETWEEN "'.$range['dateI'].'" AND "'.$range['dateF'].'"')->row();
        $cierres = $this->db->query('SELECT COUNT(IDCli) AS cantidad FROM clientes_actualiza WHERE '.$con['sql_r1'].' DATE(fechaActualizacion) BETWEEN "'.$range['dateI'].'" AND "'.$range['dateF'].'" AND EstadoActual = "EMITIDO"')->row();
      //
      $prospectos = !empty($prospectos) ? $prospectos->cantidad : 0;
      $referidos = !empty($referidos) ? $referidos->cantidad : 0;
      $cartera = !empty($cartera) ? $cartera->cantidad : 0;
      $citas = !empty($citas) ? $citas->cantidad : 0;
      $cotizaciones = !empty($cotizaciones) ? $cotizaciones->cantidad : 0;
      $cierres = !empty($cierres) ? $cierres->cantidad : 0;
      //
      $d0 = $d0 + $prospectos;
      $d1 = $d1 + $cartera; //Cruce de cartera
      $d2 = $d2 + $referidos; //Referidos
      $d3 = $d3 + $citas; //Citas
      $d4 = $d4 + $cotizaciones; //Cotizaciones
      $d5 = $d5 + $cierres; //Cierres
    }
    $d6 = $d4 != 0 ? ($d5 != 0 ? $d4 / $d5 : 0) : 0;
    $d7 = $d0 != 0 ? ($d5 != 0 ? $d0 / $d5 : 0) : 0;
    $d6 = $d6 != 0 ? (strpos($d6, ".") ? number_format($d6,2) : $d6) : $d6;
    $d7 = $d7 != 0 ? (strpos($d7, ".") ? number_format($d7,2) : $d7) : $d7;
    $d8 = $this->db->query('SELECT SUM(PrimaTotal) AS cantidad FROM estadofinanciero WHERE Periodo = 1 AND emailCanal = "'.$user.'" AND DATE(FechaPago) BETWEEN "'.$range['dateI'].'" AND "'.$range['dateF'].'"')->row();
    $d8 = $d8->cantidad != NULL ? ($type == 1 ? $d8->cantidad : number_format($d8->cantidad,2)) : 0;
    $data = array("0" => $d0, "1" => $d1, "2" => $d2, "3" => $d3, "4" => $d4, "5" => $d5, "6" => $d6, "7" => $d7, "8" => $d8);
    return $data;
  }
//-----------------------------------------------------------------------------------------------------
}

