<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Procesamientoncmodel extends CI_Model {
	
	function __construct(){
		parent::__construct();
		
	}
//------------------------------------------------------------------
    /**
     * Obtenemos todos los proyectos a los que tiene acceso el usuario
     */
    public function obtenerProyectosSeguimiento($idPersona)
    {
        $sql = "SELECT DISTINCT p.idproyecto, p.nombre FROM proyectos p LEFT JOIN pproyectos pp ON p.idproyecto = pp.idproyecto WHERE p.usuario = ? OR pp.idpersona = ?";
        $query = $this->db->query($sql, array($idPersona, $idPersona));
        return $query->result();
    }

//------------------------------------------------------------------

public function causaraiz($array){

  	$salida=0;$seguridad=0;$datos="";
  	do{
    if(isset($array['idCausaRaiz']) )
    {
     if($array['idCausaRaiz']==-1)
     {
     	unset($array['idCausaRaiz']);
     	unset($array['update']);
     	$this->db->insert('causaraiz',$array);
     	$array['idCausaRaiz']=$this->db->insert_id();
     } 
     else
     {
     	if(isset($array['update']))
     	{
     	  unset($array['update']);
     	  if($array['idCausaRaiz']!=''){

          $this->db->where('idCausaRaiz',$array['idCausaRaiz']);
         $this->db->update('causaraiz',$array);
      
           }else{$salida=1;}
           	
     	}
     	else
     	{
          $this->db->where('idCausaRaiz',$array['idCausaRaiz']);
          $datos=$this->db->get('causaraiz')->result();
          $salida=1;
     	}
     }
    }
    else
    { 
    	//$where->db->where('Usuario',$this->tank_auth->get_usermail());
         $this->db->where('estaHabilitado',1);
         $datos=$this->db->get('causaraiz')->result();        
         $salida=1;
    }
    $seguridad++;
    if($seguridad>4){$salida=1;}

  }while($salida==0);
  return $datos;

}
//------------------------------------------------------------------

public function accioncorrectiva($array){

  	$salida=0;$seguridad=0;$datos="";
  	do{
    if(isset($array['idAccionCorrectiva']) )
    {
     if($array['idAccionCorrectiva']==-1)
     {
     	unset($array['idAccionCorrectiva']);
     	unset($array['update']);
     	$this->db->insert('accioncorrectiva',$array);
     	$array['idAccionCorrectiva']=$this->db->insert_id();
     } 
     else
     {
     	if(isset($array['update']))
     	{
     	  unset($array['update']);
     	  if($array['idAccionCorrectiva']!=''){

          $this->db->where('idAccionCorrectiva',$array['idAccionCorrectiva']);
         $this->db->update('accioncorrectiva',$array);
      
           }else{$salida=1;}
           	
     	}
     	else
     	{
          $this->db->where('idAccionCorrectiva',$array['idAccionCorrectiva']);
          $datos=$this->db->get('accioncorrectiva')->result();
          $salida=1;
     	}
     }
    }
    else
    { 
    	//$where->db->where('Usuario',$this->tank_auth->get_usermail())
          $this->db->where('estaHabilitado',1);
         $datos=$this->db->get('accioncorrectiva')->result();        
         $salida=1;
    }
    $seguridad++;
    if($seguridad>4){$salida=1;}

  }while($salida==0);
  return $datos;

}
//------------------------------------------------------------------

public function tipoInconformidad(){

    $salida=0;$seguridad=0;$datos="";
    do{
           //$where->db->where('Usuario',$this->tank_auth->get_usermail())
          //$this->db->where('estaHabilitado',1);
            $consulta="select distinct idCBI, catalogBuzonInconformidad from catalog_buzoninconformidad c join inconformidades i on c.idCBI = i.idCBITipo";
         $datos=$this->db->query($consulta)->result();        
         $salida=1;

  }while($salida==0);
  return $datos;

}
//------------------------------------------------------------------

public function inconformidad(){

    $salida=0;$seguridad=0;$datos="";
    do{
           //$where->db->where('Usuario',$this->tank_auth->get_usermail())
          //$this->db->where('estaHabilitado',1);
            $consulta="select distinct idCBI, catalogBuzonInconformidad from catalog_buzoninconformidad c join inconformidades i on c.idCBI = i.idCBIOpcion GROUP BY catalogBuzonInconformidad";
         $datos=$this->db->query($consulta)->result();        
         $salida=1;

  }while($salida==0);
  return $datos;

}
//------------------------------------------------------------------

public function areaInconformidad(){

    $salida=0;$seguridad=0;$datos="";
    do{
           //$where->db->where('Usuario',$this->tank_auth->get_usermail())
          //$this->db->where('estaHabilitado',1);
            $consulta="select distinctrow idCBI, catalogBuzonInconformidad from catalog_buzoninconformidad c join inconformidades i on c.idCBI = i.idCBIArea";
         $datos=$this->db->query($consulta)->result();        
         $salida=1;

  }while($salida==0);
  return $datos;

}
//------------------------------------------------------------------
function tablanoconformidadresponsables($array){$this->db->insert('tablanoconformidadresponsables',$array);
                 $consultaEmail="select emailUsers from persona where idPersona=".$array['idPersona'];
                 $email=$this->db->query($consultaEmail)->result()[0];
                 $consultaFolio="select idRowTabla from tablanoconformidad where idTablaNoConformidad=".$array['idTablaNoConformidad'];
                 $folio=$this->db->query($consultaFolio)->result()[0];
                $this->db->insert("envio_correos", array(
                                "desde" => "Buzon de quejas<avisosgap@aserorescapital.com>",
                                "para" => $email->emailUsers,
                                "asunto" => "Notificación del buzón de inconformidad",
                                "mensaje" => "Se le ha asignado un ticket de seguimiento a inconformidad con folio: IN".$folio->idRowTabla,
            ));
}
//------------------------------------------------------------------
function tablanoconformidad($array)
{
  if(isset($array['idTablaNoConformidad']))
  {
    if(isset($array['update']))
    {     
      unset($array['update']);
	$this->db->where('idTablaNoConformidad',$array['idTablaNoConformidad']);
	 $this->db->update('tablanoconformidad',$array);  
  }
   else
   {
    $consulta="select * from tablanoconformidad where idTablaNoConformidad=".$array['idTablaNoConformidad'];
    return $this->db->query($consulta)->result()[0];
   }
  }
}
//-----------------------------------------------
function insertarNC($array){$respueta=$this->db->insert('tablanoconformidad',$array);}
//-------------------------------------------------------
function inconformidadesBitacora($idTablaNoConformidad,$comentarioInicial=false)
{


  $tablanoconformidad=$this->db->query('select * from tablanoconformidad t where t.idTablaNoConformidad='.$idTablaNoConformidad)->result()[0];
     
   $comentarioBitacora=$this->db->query('select ib.*,u.name_complete from inconformidades_bitacora ib left join users u on u.email=ib.email where inconformidad='.$idTablaNoConformidad.' order by ib.fechaMovimiento desc')->result();
   if($comentarioInicial)
   {$comentarioInicial=new \stdClass();
      switch ($tablanoconformidad->nombreTabla) 
      {
         case 'inconformidades':
        $parametrosIniciales=$this->db->query('select descripcion,correoProcedente,u.name_complete from inconformidades i left join users u on u.email=i.correoProcedente where i.id='.$tablanoconformidad->idRowTabla)->result()[0];        
        $comentarioInicial->movimiento=$parametrosIniciales->descripcion;        
        $comentarioInicial->email=$parametrosIniciales->correoProcedente;
        $comentarioInicial->name_complete=$parametrosIniciales->name_complete;
           # code...
           break;
           case 'actividades':
                           $parametrosIniciales=$this->db->query('select a.comentarioActividad,a.usuarioCreacion,u.name_complete from actividades a
left join users u on u.email=a.usuarioCreacion where a.idInterno='.$tablanoconformidad->idRowTabla)->result()[0];        
        $comentarioInicial->movimiento=$parametrosIniciales->comentarioActividad;        
        $comentarioInicial->email=$parametrosIniciales->usuarioCreacion;
         $comentarioInicial->name_complete=$parametrosIniciales->name_complete;
             break;
         case 'calificacionactividad':
             $consulta='select * from calificacionactividad ca left join calificacionagente cg on cg.idCalificacionAgente=ca.idCalificacionAgente where ca.idInternoActividad='.$tablanoconformidad->idRowTabla;
                           $parametrosIniciales=$this->db->query('select a.comentarioActividad,a.usuarioResponsable,u.name_complete from actividades a
left join users u on u.email=a.usuarioCreacion where a.idInterno='.$tablanoconformidad->idRowTabla)->result()[0];        
               $estrellas=$this->db->query($consulta)->result();
             $estrellasMovimiento='';  
           
        foreach ($estrellas as $valueEstrellas) 
        {
            $tipoEstrella='estrellaBuena';
            
            if($valueEstrellas->calificacionActividad==0){$estrellasMovimiento.='<span style="font-size:15px;">✩'.$valueEstrellas->calificacionAgente.'</span><br>';}
            
         }
        $comentarioInicial->movimiento=$estrellasMovimiento;        
        $comentarioInicial->email=$parametrosIniciales->usuarioResponsable;
        $comentarioInicial->name_complete=$parametrosIniciales->name_complete;

           break;
         default:
           # code...
           break;
       } 
     
     $comentarioInicial->inconformidad=$idTablaNoConformidad;
     $comentarioInicial->fechaMovimiento=$tablanoconformidad->fechaCreacion;
     array_push($comentarioBitacora, $comentarioInicial);
   }
   return $comentarioBitacora;
}
//-------------------------------------------------------------------------
function tablaNC($array){
	$respuesta=array();
  $condicion="";
  if(isset($array['idResponsable'])){
  if($array['idResponsable']==910){
    $array=null;
  } 
  }
  if($array!=null){if(isset($array['idPersona'])){$condicion=" and idPersonaInconforme=".$array['idPersona'];}if(isset($array['idResponsable'])){$condicion=" and tr.idPersona=".$array['idResponsable'];}}
  /*VIENE DE CALIFICACION DEL BUZON DE INCONFORMIDADES CUANDO EL USUARIO EN GENERAL AGENTE U OPERATIVO QUIERE EXTERNAR UNA QUEJA REFERENTE A ALGO O ALGUIEN*/
$consulta='select 
  (select u.name_complete from users u where u.email=i.correoProcedente) as personaInconforme,
  cast(tnc.fechaCreacion as date) as fCreacion,
  DATE_FORMAT(tnc.fechaCreacion, "%d/%m/%Y %r") as fechaHoraRegistro,
  i.correoProcedente,
  i.nombreProcedente,
  i.descripcion,
  tnc.idTablaNoConformidad,
  tnc.idPersonaInconforme,
  tnc.idPersonaResponsable,
  CONCAT(if(pr.nombres is null or pr.nombres="","",pr.nombres)," ",if(pr.apellidoPaterno is null || pr.apellidoPaterno="","",pr.apellidoPaterno)," ",if(pr.apellidoMaterno is null || pr.apellidoMaterno="","",pr.apellidoMaterno)) as personaResponsable,
  i.datosAlternos,
  tnc.estaModificado,
  tnc.idCausaRaiz,
  tnc.idAccionCorrectiva,
  tnc.nombreNoConformidad,
  tnc.statusNoconformidad,
  tnc.comentarioCierre,
  tnc.aFavor,
  tnc.comentarioAccionCorrectiva,
  tnc.comentarioCausaRaiz,
  tnc.comentarioResponsable,
  tnc.comentarioInconforme,
  i.folioInconformidad,
  i.idCBITipo,
  i.idCBIOpcion,
  i.idCBIArea,
  tnc.idRowTabla,
  tnc.nombreTabla,
  (select causaRaiz from causaraiz where idCausaRaiz=tnc.idCausaRaiz) as causaRaiz,
  (select accionCorrectiva from accioncorrectiva where idAccionCorrectiva=tnc.idAccionCorrectiva) as accionCorrectiva,
  (select catalogBuzonInconformidad from catalog_buzoninconformidad where idCBI=i.idCBITipo) as tipoInconformidad,
  (select catalogBuzonInconformidad from catalog_buzoninconformidad where idCBI=i.idCBIOpcion) as opcionInconformidad,
  (select catalogBuzonInconformidad from catalog_buzoninconformidad where idCBI=i.idCBIArea) as areaInconformidad,
  CASE
    WHEN tnc.aFavor = 0 THEN "primary"
    WHEN tnc.aFavor = 1 THEN "success"
    WHEN tnc.aFavor = 3 THEN "danger"
    ELSE "oka"
  END AS label,
  IF(ts.status IS NULL, "NUEVO", ts.status) AS status
  from tablanoconformidad tnc  left join inconformidades i on i.id=tnc.idRowTabla left join persona pr on pr.idPersona=tnc.idPersonaResponsable left join tablanoconformidadstatus ts on tnc.aFavor = ts.idTNCStatus left join tablanoconformidadresponsables tr on tnc.idTablaNoConformidad=tr.idTablaNoConformidad where tnc.nombreTabla="inconformidades" and tnc.noConformidadRevisada=0 and i.tipoInconformidad=0 and i.tipoInconformidad=0 '.$condicion.' GROUP by idTablaNoConformidad order by fCreacion desc';
$respuesta['calificaUsuario']=$this->db->query($consulta)->result();

foreach ($respuesta['calificaUsuario'] as $value) 
{  
   $consulta='select tr.*,p.nombres,p.apellidoPaterno,p.apellidoMaterno,u.email from tablanoconformidadresponsables tr left join persona p on p.idPersona=tr.idPersona left join users u on u.idPersona=p.idPersona where tr.idTablaNoConformidad='.$value->idTablaNoConformidad;
 $value->personaResponsables=$this->db->query($consulta)->result();
  $value->comentariosBitacora=$this->inconformidadesBitacora($value->idTablaNoConformidad,true);//$this->db->query('select * from inconformidades_bitacora where inconformidad='.$value->idTablaNoConformidad.' order by fechaMovimiento desc')->result();
  
}

/*VIENE CUANDO EN CLIENTE CALIFICA A UN AGENTE EN LA PAGINA DE CAPITALSEGUROS EN LA PARTE DEL VALIDADOR*/
$consulta='select cast(tnc.fechaCreacion as date) as fCreacion,CONCAT(if(p.nombres is null or p.nombres="","",p.nombres)," ",if(p.apellidoPaterno is null || p.apellidoPaterno="","",p.apellidoPaterno)," ",if(p.apellidoMaterno is null || p.apellidoMaterno="","",p.apellidoMaterno)) as personaInconforme,i.correoProcedente,
i.nombreProcedente,i.descripcion,tnc.idTablaNoConformidad, tnc.idRowTabla, tnc.nombreTabla,
tnc.idPersonaInconforme,tnc.idPersonaResponsable,
DATE_FORMAT(tnc.fechaCreacion, "%d/%m/%Y %r") as fechaHoraRegistro,
CONCAT(if(pr.nombres is null or pr.nombres="","",pr.nombres)," ",if(pr.apellidoPaterno is null || pr.apellidoPaterno="","",pr.apellidoPaterno)," ",if(pr.apellidoMaterno is null || pr.apellidoMaterno="","",pr.apellidoMaterno)) as personaResponsable,i.datosAlternos,tnc.estaModificado,tnc.idCausaRaiz,tnc.idAccionCorrectiva,tnc.nombreNoConformidad,tnc.statusNoconformidad,tnc.comentarioCierre,tnc.aFavor,tnc.comentarioAccionCorrectiva,tnc.comentarioCausaRaiz,tnc.comentarioResponsable,tnc.comentarioInconforme,
CASE
    WHEN tnc.aFavor = 0 THEN "primary"
    WHEN tnc.aFavor = 1 THEN "success"
    WHEN tnc.aFavor = 3 THEN "danger"
    ELSE "oka"
END AS label,
IF(ts.status IS NULL, "NUEVO", ts.status) AS status
from tablanoconformidad tnc 
left join inconformidades i on i.id=tnc.idRowTabla
left join tablanoconformidadstatus ts on tnc.aFavor = ts.idTNCStatus
left join persona p on p.idPersona=tnc.idPersonaInconforme
left join persona pr on pr.idPersona=tnc.idPersonaResponsable
left join tablanoconformidadresponsables tr on tnc.idTablaNoConformidad=tr.idTablaNoConformidad
where tnc.nombreTabla="inconformidades" and tnc.noConformidadRevisada=0 and i.tipoInconformidad=1'.$condicion.' GROUP by idTablaNoConformidad order by fCreacion desc';
$respuesta['calificaCliente']=$this->db->query($consulta)->result();


foreach ($respuesta['calificaCliente'] as $value) {
  
   $consulta='select tr.*,p.nombres,p.apellidoPaterno,p.apellidoMaterno,u.email from tablanoconformidadresponsables tr 
left join persona p on p.idPersona=tr.idPersona
left join users u on u.idPersona=p.idPersona 
where tr.idTablaNoConformidad='.$value->idTablaNoConformidad;
$value->personaResponsables=array();
 $value->personaResponsables=$this->db->query($consulta)->result();
  
}


/*CUANDO EL AGENTE CALIFICA MAL UNA ACTIVIDAD QUE ESTA ACARGO DE LA PARTE DE OPERATIVA*/
$consulta='select cast(tnc.fechaCreacion as date) as fCreacion,CONCAT(if(p.nombres is null or p.nombres="","",p.nombres)," ",if(p.apellidoPaterno is null || p.apellidoPaterno="","",p.apellidoPaterno)," ",if(p.apellidoMaterno is null || p.apellidoMaterno="","",p.apellidoMaterno)) as personaInconforme,a.comentarioActividad,a.folioActividad,a.tipoActividad,
tnc.idTablaNoConformidad,tnc.idPersonaInconforme,tnc.idPersonaResponsable, tnc.idRowTabla, tnc.nombreTabla,
CONCAT(if(pr.nombres is null or pr.nombres="","",pr.nombres)," ",if(pr.apellidoPaterno is null || pr.apellidoPaterno="","",pr.apellidoPaterno)," ",if(pr.apellidoMaterno is null || pr.apellidoMaterno="","",pr.apellidoMaterno)) as personaResponsable,a.usuarioResponsable,tnc.estaModificado,tnc.idCausaRaiz,tnc.idAccionCorrectiva,tnc.nombreNoConformidad,tnc.statusNoconformidad,tnc.comentarioCierre,tnc.aFavor,tnc.comentarioAccionCorrectiva,tnc.comentarioCausaRaiz,tnc.comentarioResponsable,tnc.comentarioInconforme,(a.folioActividad) as folioInconformidad,tnc.idCBITipo,tnc.idCBIOpcion,tnc.idCBIArea,
DATE_FORMAT(tnc.fechaCreacion, "%d/%m/%Y %r") as fechaHoraRegistro,
CASE
    WHEN tnc.aFavor = 0 THEN "primary"
    WHEN tnc.aFavor = 1 THEN "success"
    WHEN tnc.aFavor = 3 THEN "danger"
    ELSE "oka"
END AS label,
IF(ts.status IS NULL, "NUEVO", ts.status) AS status,
  (select causaRaiz from causaraiz where idCausaRaiz=tnc.idCausaRaiz) as causaRaiz,
  (select accionCorrectiva from accioncorrectiva where idAccionCorrectiva=tnc.idAccionCorrectiva) as accionCorrectiva,
(select catalogBuzonInconformidad from catalog_buzoninconformidad where idCBI=tnc.idCBITipo) as tipoInconformidad,
(select catalogBuzonInconformidad from catalog_buzoninconformidad where idCBI=tnc.idCBIOpcion) as opcionInconformidad,
(select catalogBuzonInconformidad from catalog_buzoninconformidad where idCBI=tnc.idCBIArea) as areaInconformidad
from tablanoconformidad tnc 
left join actividades a on a.idInterno=tnc.idRowTabla
left join tablanoconformidadstatus ts on tnc.aFavor = ts.idTNCStatus
left join persona p on p.idPersona=tnc.idPersonaInconforme
left join persona pr on pr.idPersona=tnc.idPersonaResponsable
left join tablanoconformidadresponsables tr on tnc.idTablaNoConformidad=tr.idTablaNoConformidad
where tnc.nombreTabla="actividades" AND tnc.noConformidadRevisada=0'.$condicion.' GROUP by idTablaNoConformidad order by fCreacion desc';
$respuesta['calificaAgente']=$this->db->query($consulta)->result();
foreach ($respuesta['calificaAgente'] as $value) {
  
   $consulta='select tr.*,p.nombres,p.apellidoPaterno,p.apellidoMaterno,u.email from tablanoconformidadresponsables tr 
left join persona p on p.idPersona=tr.idPersona
left join users u on u.idPersona=p.idPersona 
where tr.idTablaNoConformidad='.$value->idTablaNoConformidad;
 $value->personaResponsables=$this->db->query($consulta)->result();

  $value->comentariosBitacora=$value->comentariosBitacora=$this->inconformidadesBitacora($value->idTablaNoConformidad,true);//$this->db->query('select * from inconformidades_bitacora where inconformidad='.$value->idTablaNoConformidad.' order by fechaMovimiento desc')->result();
  
  
}



/*$consulta='select * from tablanoconformidad tnc 
left join actividades a on a.idInterno=tnc.idRowTabla
left join calificacionactividad caa on caa.idInternoActividad=a.idInterno
left join calificacionagente ca on ca.idCalificacionAgente=caa.idCalificacionAgente
where tnc.nombreTabla="calificacionactividad" and tnc.noConformidadRevisada=0';*/
/*VIENE CUANDO EL OPERTATIVA CALIFICA AL AGENTE EN LA PARTE DEL DETALLE DE LA ACTIVIDAD LA ACTIVIDAD*/
$consulta="select cast(tnc.fechaCreacion as date) as fCreacion,tnc.*,a.tipoActividad,a.folioActividad,
(concat(p.nombres,' ',p.apellidoPaterno,' ',p.apellidoMaterno)) as personaInconforme, tnc.idRowTabla, tnc.nombreTabla,
(concat(p2.nombres,' ',p2.apellidoPaterno,' ',p2.apellidoMaterno)) as personaResponsable,tnc.estaModificado,tnc.idCausaRaiz,tnc.idAccionCorrectiva,tnc.nombreNoConformidad,tnc.statusNoconformidad,tnc.comentarioCierre,tnc.aFavor,tnc.comentarioAccionCorrectiva,tnc.comentarioCausaRaiz,tnc.comentarioResponsable,tnc.comentarioInconforme,(a.folioActividad) as folioInconformidad,tnc.idCBITipo,tnc.idCBIOpcion,tnc.idCBIArea,
DATE_FORMAT(tnc.fechaCreacion, '%d/%m/%Y %r') as fechaHoraRegistro,
CASE
    WHEN tnc.aFavor = 0 THEN 'primary'
    WHEN tnc.aFavor = 1 THEN 'success'
    WHEN tnc.aFavor = 3 THEN 'danger'
    ELSE 'oka'
END AS label,
IF(ts.status IS NULL, 'NUEVO', ts.status) AS status,
  (select causaRaiz from causaraiz where idCausaRaiz=tnc.idCausaRaiz) as causaRaiz,
  (select accionCorrectiva from accioncorrectiva where idAccionCorrectiva=tnc.idAccionCorrectiva) as accionCorrectiva,
(select catalogBuzonInconformidad from catalog_buzoninconformidad where idCBI=tnc.idCBITipo) as tipoInconformidad,
(select catalogBuzonInconformidad from catalog_buzoninconformidad where idCBI=tnc.idCBIOpcion) as opcionInconformidad,
(select catalogBuzonInconformidad from catalog_buzoninconformidad where idCBI=tnc.idCBIArea) as areaInconformidad
from tablanoconformidad tnc 
left join actividades a on a.idInterno=tnc.idRowTabla
left join tablanoconformidadstatus ts on tnc.aFavor = ts.idTNCStatus
left join persona p on p.idPersona=tnc.idPersonaInconforme
left join persona p2 on p2.idPersona=tnc.idPersonaResponsable
left join tablanoconformidadresponsables tr on tnc.idTablaNoConformidad=tr.idTablaNoConformidad
where tnc.nombreTabla='calificacionactividad' and tnc.noConformidadRevisada=0".$condicion." GROUP by idTablaNoConformidad order by fCreacion desc";
$respuesta['calificaOperativo']=$this->db->query($consulta)->result();

foreach ($respuesta['calificaOperativo'] as $value) 
{
  $consulta='select * from calificacionactividad ca
left join calificacionagente cg on cg.idCalificacionAgente=ca.idCalificacionAgente
where ca.idInternoActividad='.$value->idRowTabla;
 $value->estrellas=$this->db->query($consulta)->result();
   $consulta='select tr.*,p.nombres,p.apellidoPaterno,p.apellidoMaterno,u.email from tablanoconformidadresponsables tr 
left join persona p on p.idPersona=tr.idPersona
left join users u on u.idPersona=p.idPersona 
where tr.idTablaNoConformidad='.$value->idTablaNoConformidad;
 $value->personaResponsables=$this->db->query($consulta)->result();

  $value->comentariosBitacora=$value->comentariosBitacora=$this->inconformidadesBitacora($value->idTablaNoConformidad,true);//$this->db->query('select * from inconformidades_bitacora where inconformidad='.$value->idTablaNoConformidad.' order by fechaMovimiento desc')->result();
  
}


return $respuesta;


}
//--------------------------------------------------------------------------------
function tablaNCFechas($array){
  $respuesta=array();
  $revisadas=0;$pendientes=0;$total=0;
  $personaRevisada = array();
  $where="";
  //if(isset($array['where'])){$where=' and (tnc.idPersonaInconforme  '.$array['where'].' || tnc.idPersonaResponsable '.$array['where'].')';}
  /*VIENE DE CALIFICACION DEL BUZON DE INCONFORMIDADES CUANDO EL USUARIO EN GENERAL AGENTE U OPERATIVO QUIERE EXTERNAR UNA QUEJA REFERENTE A ALGO O ALGUIEN*/
$consulta='select  cast(tnc.fechaCreacion as date) as fCreacion,tnc.comentarioTNC,i.tipoInconformidad,tnc.fechaCreacion,tnc.aFavor,CONCAT(if(p.nombres is null or p.nombres="","",p.nombres)," ",if(p.apellidoPaterno is null || p.apellidoPaterno="","",p.apellidoPaterno)," ",if(p.apellidoMaterno is null || p.apellidoMaterno="","",p.apellidoMaterno)) as personaInconforme,i.correoProcedente,i.nombreProcedente,i.descripcion,tnc.idTablaNoConformidad,tnc.idPersonaInconforme,tnc.idPersonaResponsable,CONCAT(if(pr.nombres is null or pr.nombres="","",pr.nombres)," ",if(pr.apellidoPaterno is null || pr.apellidoPaterno="","",pr.apellidoPaterno)," ",if(pr.apellidoMaterno is null || pr.apellidoMaterno="","",pr.apellidoMaterno)) as personaResponsable,i.datosAlternos,tnc.noConformidadRevisada,(if(tnc.noConformidadRevisada=1,"Revisada","Pendiente")) as descrNoConfomridadRevisada,"" as ramoActividad,(if(cr.causaRaiz is null,"",cr.causaraiz)) as causaRaiz,(if(ac.accionCorrectiva is null,"",ac.accionCorrectiva)) as accionCorrectiva,tnc.comentarioCausaRaiz,tnc.comentarioAccionCorrectiva,tnc.comentarioCierre from tablanoconformidad tnc  left join inconformidades i on i.id=tnc.idRowTabla  left join causaraiz cr on cr.idCausaRaiz=tnc.idCausaRaiz
left join accioncorrectiva ac on ac.idAccionCorrectiva=tnc.idAccionCorrectiva left join persona p on p.idPersona=tnc.idPersonaInconforme left join persona pr on pr.idPersona=tnc.idPersonaResponsable where tnc.nombreTabla="inconformidades"  and i.tipoInconformidad=0 and ((cast(tnc.fechaCreacion as date))>="'.$array['fechaInicial'].'" and (cast(tnc.fechaCreacion as date))<="'.$array['fechaFinal'].'") '.$where ;


$respuesta['calificaUsuario']=$this->db->query($consulta)->result();
foreach($respuesta['calificaUsuario'] as $value){
  $consulta="";
  $consulta='select r.idTablaNoConformidad ,r.idPersona,(if(r.conformidadMala=1,"Mala","Buena")) as descricpioConformidadMala,r.conformidadMala,
CONCAT(IF(p.nombres IS NULL OR p.nombres="","",p.nombres)," ", IF(p.apellidoPaterno IS NULL || p.apellidoPaterno="","",p.apellidoPaterno)," ", IF(p.apellidoMaterno IS NULL || p.apellidoMaterno="","",p.apellidoMaterno)) AS persona,p.tipoPersona from tablanoconformidadresponsables r left join persona p on p.idPersona=r.idPersona where r.idTablaNoConformidad='.$value->idTablaNoConformidad; 

  $value->responsables=$this->db->query($consulta)->result();
  $consulta="select * from tablanoconformidadcomentarios c where c.tipoComentario=0 and c.idTablaNoConformidad=".$value->idTablaNoConformidad;
  $value->comentarioPersonal=$this->db->query($consulta)->result();
  $consulta="select * from tablanoconformidadcomentarios c where c.tipoComentario=1 and c.idTablaNoConformidad=".$value->idTablaNoConformidad;
  $value->comentarioInconforme=$this->db->query($consulta)->result();
  $consulta="select * from tablanoconformidadcomentarios c where c.tipoComentario=2 and c.idTablaNoConformidad=".$value->idTablaNoConformidad;
  $value->comentarioResponsable=$this->db->query($consulta)->result();
    if($value->noConformidadRevisada==1)
    {
  
     foreach ($value->responsables as $valuePersona) 
     {
        $id=(string)$valuePersona->idPersona;           
        $personaRevisada[$id]['nombre']=(string)$valuePersona->persona;  
        if (!array_key_exists('conformidadMala', $personaRevisada[$id])){ $personaRevisada[$id]['conformidadMala']="";}
     if (!array_key_exists('conformidaBuena', $personaRevisada[$id])){ $personaRevisada[$id]['conformidaBuena']="";}
        if($valuePersona->conformidadMala==1){ $personaRevisada[$id]['conformidadMala']=$personaRevisada[$id]['conformidadMala']."1";}
         else{$personaRevisada[$id]['conformidaBuena']=$personaRevisada[$id]['conformidaBuena']."1";   }
         $personaRevisada[$id]['tipoPersona']=$valuePersona->tipoPersona;
     }

    }    
  if($value->noConformidadRevisada==0){$pendientes++;}
  else{$revisadas++;}
  $total++;
}
   

/*VIENE CUANDO EN CLIENTE CALIFICA A UN AGENTE EN LA PAGINA DE CAPITALSEGUROS EN LA PARTE DEL VALIDADOR*/
$consulta='select  cast(tnc.fechaCreacion as date) as fCreacion,tnc.comentarioTNC,i.tipoInconformidad,tnc.fechaCreacion,tnc.aFavor,CONCAT(if(p.nombres is null or p.nombres="","",p.nombres)," ",if(p.apellidoPaterno is null || p.apellidoPaterno="","",p.apellidoPaterno)," ",if(p.apellidoMaterno is null || p.apellidoMaterno="","",p.apellidoMaterno)) as personaInconforme,i.correoProcedente,i.nombreProcedente,i.descripcion,tnc.idTablaNoConformidad,tnc.idPersonaInconforme,tnc.idPersonaResponsable,CONCAT(if(pr.nombres is null or pr.nombres="","",pr.nombres)," ",if(pr.apellidoPaterno is null || pr.apellidoPaterno="","",pr.apellidoPaterno)," ",if(pr.apellidoMaterno is null || pr.apellidoMaterno="","",pr.apellidoMaterno)) as personaResponsable,i.datosAlternos,tnc.noConformidadRevisada,(if(tnc.noConformidadRevisada=1,"Revisada","Pendiente")) as descrNoConfomridadRevisada,"" as ramoActividad,(if(cr.causaRaiz is null,"",cr.causaraiz)) as causaRaiz,(if(ac.accionCorrectiva is null,"",ac.accionCorrectiva)) as accionCorrectiva,tnc.comentarioCausaRaiz,tnc.comentarioAccionCorrectiva,tnc.comentarioCierre from tablanoconformidad tnc  left join inconformidades i on i.id=tnc.idRowTabla  left join causaraiz cr on cr.idCausaRaiz=tnc.idCausaRaiz
left join accioncorrectiva ac on ac.idAccionCorrectiva=tnc.idAccionCorrectiva left join persona p on p.idPersona=tnc.idPersonaInconforme left join persona pr on pr.idPersona=tnc.idPersonaResponsable where tnc.nombreTabla="inconformidades"  and i.tipoInconformidad=1 and ((cast(tnc.fechaCreacion as date))>="'.$array['fechaInicial'].'" and (cast(tnc.fechaCreacion as date))<="'.$array['fechaFinal'].'") '.$where;

$respuesta['calificaCliente']=$this->db->query($consulta)->result();

foreach($respuesta['calificaCliente'] as $value){
  $consulta="";
  $consulta='select r.idTablaNoConformidad ,r.idPersona,(if(r.conformidadMala=1,"Mala","Buena")) as descricpioConformidadMala,r.conformidadMala,
CONCAT(IF(p.nombres IS NULL OR p.nombres="","",p.nombres)," ", IF(p.apellidoPaterno IS NULL || p.apellidoPaterno="","",p.apellidoPaterno)," ", IF(p.apellidoMaterno IS NULL || p.apellidoMaterno="","",p.apellidoMaterno)) AS persona,p.tipoPersona
from tablanoconformidadresponsables r
left join persona p on p.idPersona=r.idPersona
where r.idTablaNoConformidad='.$value->idTablaNoConformidad;
  $value->responsables=$this->db->query($consulta)->result();

  $consulta="select * from tablanoconformidadcomentarios c where c.tipoComentario=0 and c.idTablaNoConformidad=".$value->idTablaNoConformidad;
  $value->comentarioPersonal=$this->db->query($consulta)->result();
  $consulta="select * from tablanoconformidadcomentarios c where c.tipoComentario=1 and c.idTablaNoConformidad=".$value->idTablaNoConformidad;
  $value->comentarioInconforme=$this->db->query($consulta)->result();
  $consulta="select * from tablanoconformidadcomentarios c where c.tipoComentario=2 and c.idTablaNoConformidad=".$value->idTablaNoConformidad;
  $value->comentarioResponsable=$this->db->query($consulta)->result();
    if($value->noConformidadRevisada==1){
      
     foreach ($value->responsables as $valuePersona) 
     {
        $id=(string)$valuePersona->idPersona;      
     
        $personaRevisada[$id]['nombre']=(string)$valuePersona->persona;  
        if (!array_key_exists('conformidadMala', $personaRevisada[$id])){ $personaRevisada[$id]['conformidadMala']="";}
     if (!array_key_exists('conformidaBuena', $personaRevisada[$id])){ $personaRevisada[$id]['conformidaBuena']="";}
        if($valuePersona->conformidadMala==1){$personaRevisada[$id]['conformidadMala']=$personaRevisada[$id]['conformidadMala']."1"; }
         else{$personaRevisada[$id]['conformidaBuena']=$personaRevisada[$id]['conformidaBuena']."1"; }
         $personaRevisada[$id]['tipoPersona']=$valuePersona->tipoPersona;
     }

    }    
  if($value->noConformidadRevisada==0){$pendientes++;}
  else{$revisadas++;}
  $total++;
}




/*CUANDO EL AGENTE CALIFICA MAL UNA ACTIVIDAD QUE ESTA ACARGO DE LA PARTE DE OPERATIVA*/
$consulta='select  cast(tnc.fechaCreacion as date) as fCreacion,tnc.comentarioTNC,tnc.fechaCreacion,tnc.aFavor,CONCAT(if(p.nombres is null or p.nombres="","",p.nombres)," ",if(p.apellidoPaterno is null || p.apellidoPaterno="","",p.apellidoPaterno)," ",if(p.apellidoMaterno is null || p.apellidoMaterno="","",p.apellidoMaterno)) as personaInconforme,a.comentarioActividad,a.folioActividad,a.tipoActividad,
tnc.idTablaNoConformidad,tnc.idPersonaInconforme,tnc.idPersonaResponsable,tnc.noConformidadRevisada,(if(tnc.noConformidadRevisada=1,"Revisada","Pendiente")) as descrNoConfomridadRevisada,
CONCAT(if(pr.nombres is null or pr.nombres="","",pr.nombres)," ",if(pr.apellidoPaterno is null || pr.apellidoPaterno="","",pr.apellidoPaterno)," ",if(pr.apellidoMaterno is null || pr.apellidoMaterno="","",pr.apellidoMaterno)) as personaResponsable,a.ramoActividad,(if(cr.causaRaiz is null,"",cr.causaraiz)) as causaRaiz,(if(ac.accionCorrectiva is null,"",ac.accionCorrectiva)) as accionCorrectiva,tnc.comentarioCausaRaiz,tnc.comentarioAccionCorrectiva,tnc.comentarioCierre
from tablanoconformidad tnc 
left join actividades a on a.idInterno=tnc.idRowTabla 
left join causaraiz cr on cr.idCausaRaiz=tnc.idCausaRaiz
left join accioncorrectiva ac on ac.idAccionCorrectiva=tnc.idAccionCorrectiva
left join persona p on p.idPersona=tnc.idPersonaInconforme
left join persona pr on pr.idPersona=tnc.idPersonaResponsable
where tnc.nombreTabla="actividades" and ((cast(tnc.fechaCreacion as date))>="'.$array['fechaInicial'].'" and (cast(tnc.fechaCreacion as date))<="'.$array['fechaFinal'].'") '.$where;

$respuesta['calificaAgente']=$this->db->query($consulta)->result();


foreach($respuesta['calificaAgente'] as $value){
  $consulta="";
  $consulta='select r.idTablaNoConformidad ,r.idPersona,(if(r.conformidadMala=1,"Mala","Buena")) as descricpioConformidadMala,r.conformidadMala,
CONCAT(IF(p.nombres IS NULL OR p.nombres="","",p.nombres)," ", IF(p.apellidoPaterno IS NULL || p.apellidoPaterno="","",p.apellidoPaterno)," ", IF(p.apellidoMaterno IS NULL || p.apellidoMaterno="","",p.apellidoMaterno)) AS persona,p.tipoPersona
from tablanoconformidadresponsables r
left join persona p on p.idPersona=r.idPersona
where r.idTablaNoConformidad='.$value->idTablaNoConformidad;

  $value->responsables=$this->db->query($consulta)->result();
     $consulta="select * from tablanoconformidadcomentarios c where c.tipoComentario=0 and c.idTablaNoConformidad=".$value->idTablaNoConformidad;
  $value->comentarioPersonal=$this->db->query($consulta)->result();
  $consulta="select * from tablanoconformidadcomentarios c where c.tipoComentario=1 and c.idTablaNoConformidad=".$value->idTablaNoConformidad;
  $value->comentarioInconforme=$this->db->query($consulta)->result();
  $consulta="select * from tablanoconformidadcomentarios c where c.tipoComentario=2 and c.idTablaNoConformidad=".$value->idTablaNoConformidad;
  $value->comentarioResponsable=$this->db->query($consulta)->result();
     if($value->noConformidadRevisada==1){
      
     foreach ($value->responsables as $valuePersona) 
     {
        $id=(string)$valuePersona->idPersona;      
        $personaRevisada[$id]['nombre']=(string)$valuePersona->persona;      
        
        if (!array_key_exists('conformidadMala', $personaRevisada[$id])){ $personaRevisada[$id]['conformidadMala']="";}
        if (!array_key_exists('conformidaBuena', $personaRevisada[$id])){ $personaRevisada[$id]['conformidaBuena']="";}
 
        if($valuePersona->conformidadMala==1){ $personaRevisada[$id]['conformidadMala']=$personaRevisada[$id]['conformidadMala']."1";  }
        else{$personaRevisada[$id]['conformidaBuena']=$personaRevisada[$id]['conformidaBuena']."1"; }
       $personaRevisada[$id]['tipoPersona']=$valuePersona->tipoPersona; 
     }

    }    
  if($value->noConformidadRevisada==0){$pendientes++;}
  else{$revisadas++;}
  $total++;
}
    


$consulta='select  cast(tnc.fechaCreacion as date) as fCreacion,tnc.*,a.tipoActividad,a.folioActividad,
(concat(p.nombres," ",p.apellidoPaterno," ",p.apellidoMaterno)) as personaInconforme,
(concat(p2.nombres," ",p2.apellidoPaterno," ",p2.apellidoMaterno)) as personaResponsable,(if(tnc.noConformidadRevisada=1,"Revisada","Pendiente")) as descrNoConfomridadRevisada,a.ramoActividad,(if(cr.causaRaiz is null,"",cr.causaraiz)) as causaRaiz,(if(ac.accionCorrectiva is null,"",ac.accionCorrectiva)) as accionCorrectiva,tnc.comentarioCausaRaiz,tnc.comentarioAccionCorrectiva,tnc.comentarioCierre
from tablanoconformidad tnc 
left join actividades a on a.idInterno=tnc.idRowTabla
left join causaraiz cr on cr.idCausaRaiz=tnc.idCausaRaiz
left join accioncorrectiva ac on ac.idAccionCorrectiva=tnc.idAccionCorrectiva
left join persona p on p.idPersona=tnc.idPersonaInconforme
left join persona p2 on p2.idPersona=tnc.idPersonaResponsable
where tnc.nombreTabla="calificacionactividad" and ((cast(tnc.fechaCreacion as date))>="'.$array['fechaInicial'].'" and (cast(tnc.fechaCreacion as date))<="'.$array['fechaFinal'].'") '.$where;

$respuesta['calificaOperativo']=$this->db->query($consulta)->result();

//$personaRevisada=array();

foreach($respuesta['calificaOperativo'] as $value){
  $consulta="";
  $consulta='select r.idTablaNoConformidad ,r.idPersona,(if(r.conformidadMala=1,"Mala","Buena")) as descricpioConformidadMala,r.conformidadMala,
CONCAT(IF(p.nombres IS NULL OR p.nombres="","",p.nombres)," ", IF(p.apellidoPaterno IS NULL || p.apellidoPaterno="","",p.apellidoPaterno)," ", IF(p.apellidoMaterno IS NULL || p.apellidoMaterno="","",p.apellidoMaterno)) AS persona,p.tipoPersona
from tablanoconformidadresponsables r
left join persona p on p.idPersona=r.idPersona
where r.idTablaNoConformidad='.$value->idTablaNoConformidad;
  $value->responsables=$this->db->query($consulta)->result();
    $consulta="select * from tablanoconformidadcomentarios c where c.tipoComentario=0 and c.idTablaNoConformidad=".$value->idTablaNoConformidad;
  $value->comentarioPersonal=$this->db->query($consulta)->result();
  $consulta="select * from tablanoconformidadcomentarios c where c.tipoComentario=1 and c.idTablaNoConformidad=".$value->idTablaNoConformidad;
  $value->comentarioInconforme=$this->db->query($consulta)->result();
  $consulta="select * from tablanoconformidadcomentarios c where c.tipoComentario=2 and c.idTablaNoConformidad=".$value->idTablaNoConformidad;
  $value->comentarioResponsable=$this->db->query($consulta)->result();
     if($value->noConformidadRevisada==1){
      
     foreach ($value->responsables as $valuePersona) 
     {
        $id=(string)$valuePersona->idPersona;           
        $personaRevisada[$id]['nombre']=(string)$valuePersona->persona;  
       if (!array_key_exists('conformidadMala', $personaRevisada[$id])){ $personaRevisada[$id]['conformidadMala']="";}
       if (!array_key_exists('conformidaBuena', $personaRevisada[$id])){ $personaRevisada[$id]['conformidaBuena']="";}        
       if($valuePersona->conformidadMala==1){$personaRevisada[$id]['conformidadMala']=$personaRevisada[$id]['conformidadMala']."1";}
       else{$personaRevisada[$id]['conformidaBuena']=$personaRevisada[$id]['conformidaBuena']."1"; }
       $personaRevisada[$id]['tipoPersona']=$valuePersona->tipoPersona;
     }

    }    
  if($value->noConformidadRevisada==0){$pendientes++;}
  else{$revisadas++;}
  $total++;
}



foreach ($respuesta['calificaOperativo'] as $value) {
  $consulta='select * from calificacionactividad ca left join calificacionagente cg on cg.idCalificacionAgente=ca.idCalificacionAgente where ca.idInternoActividad='.$value->idRowTabla;
 $value->estrellas=$this->db->query($consulta)->result();  
}

foreach ($personaRevisada as $key => $value) {
  $personaRevisada[$key]['idPersona']=$key;
}
$respuesta['personaRevisada']=array();
foreach ($personaRevisada as $key => $value) {
array_push($respuesta['personaRevisada'], $value);  
}
 
$respuesta['pendientes']=$pendientes;
$respuesta['revisadas']=$revisadas;
$respuesta['total']=$total;
//$respuesta['personaRevisada']=$personaRevisada;

return $respuesta;


}
//---------------------------------------------
function reporteBuzonInconformidad($array){
  $respuesta="";
  $revisadas=0;$pendientes=0;$total=0;
  $personaRevisada = array();
  $where="";
  //if(isset($array['where'])){$where=' and (tnc.idPersonaInconforme  '.$array['where'].' || tnc.idPersonaResponsable '.$array['where'].')';}
  /*VIENE DE CALIFICACION DEL BUZON DE INCONFORMIDADES CUANDO EL USUARIO EN GENERAL AGENTE U OPERATIVO QUIERE EXTERNAR UNA QUEJA REFERENTE A ALGO O ALGUIEN*/

$consulta='select  cast(tnc.fechaCreacion as date) as fCreacion,tnc.comentarioTNC,i.tipoInconformidad,tnc.fechaCreacion,tnc.aFavor,CONCAT(if(p.nombres is null or p.nombres="","",p.nombres)," ",if(p.apellidoPaterno is null || p.apellidoPaterno="","",p.apellidoPaterno)," ",if(p.apellidoMaterno is null || p.apellidoMaterno="","",p.apellidoMaterno)) as personaInconforme,i.correoProcedente,i.nombreProcedente,i.descripcion,tnc.idTablaNoConformidad,tnc.idPersonaInconforme,tnc.idPersonaResponsable,CONCAT(if(pr.nombres is null or pr.nombres="","",pr.nombres)," ",if(pr.apellidoPaterno is null || pr.apellidoPaterno="","",pr.apellidoPaterno)," ",if(pr.apellidoMaterno is null || pr.apellidoMaterno="","",pr.apellidoMaterno)) as personaResponsable,i.datosAlternos,tnc.noConformidadRevisada,(if(tnc.noConformidadRevisada=1,"Revisada","Pendiente")) as descrNoConfomridadRevisada,"" as ramoActividad,(if(cr.causaRaiz is null,"",cr.causaraiz)) as causaRaiz,(if(ac.accionCorrectiva is null,"",ac.accionCorrectiva)) as accionCorrectiva,tnc.comentarioCausaRaiz,tnc.comentarioAccionCorrectiva,tnc.comentarioCierre from tablanoconformidad tnc  left join inconformidades i on i.id=tnc.idRowTabla  left join causaraiz cr on cr.idCausaRaiz=tnc.idCausaRaiz
left join accioncorrectiva ac on ac.idAccionCorrectiva=tnc.idAccionCorrectiva left join persona p on p.idPersona=tnc.idPersonaInconforme left join persona pr on pr.idPersona=tnc.idPersonaResponsable where tnc.nombreTabla="inconformidades"  and i.tipoInconformidad=0 and YEAR(cast(tnc.fechaCreacion as date))='.$array['fecha'].' and tnc.idPersonaInconforme='.$this->tank_auth->get_idPersona();


$respuesta['calificaUsuario']=$this->db->query($consulta)->result();
foreach($respuesta['calificaUsuario'] as $value){
  $consulta="";
  $consulta='select r.idTablaNoConformidad ,r.idPersona,(if(r.conformidadMala=1,"Mala","Buena")) as descricpioConformidadMala,r.conformidadMala,
CONCAT(IF(p.nombres IS NULL OR p.nombres="","",p.nombres)," ", IF(p.apellidoPaterno IS NULL || p.apellidoPaterno="","",p.apellidoPaterno)," ", IF(p.apellidoMaterno IS NULL || p.apellidoMaterno="","",p.apellidoMaterno)) AS persona,p.tipoPersona from tablanoconformidadresponsables r left join persona p on p.idPersona=r.idPersona where r.idTablaNoConformidad='.$value->idTablaNoConformidad; 

  $value->responsables=$this->db->query($consulta)->result();
  $consulta="select * from tablanoconformidadcomentarios c where c.tipoComentario=0 and c.idTablaNoConformidad=".$value->idTablaNoConformidad;
  $value->comentarioPersonal=$this->db->query($consulta)->result();
  $consulta="select * from tablanoconformidadcomentarios c where c.tipoComentario=1 and c.idTablaNoConformidad=".$value->idTablaNoConformidad;
  $value->comentarioInconforme=$this->db->query($consulta)->result();
  $consulta="select * from tablanoconformidadcomentarios c where c.tipoComentario=2 and c.idTablaNoConformidad=".$value->idTablaNoConformidad;
  $value->comentarioResponsable=$this->db->query($consulta)->result();
    if($value->noConformidadRevisada==1)
    {
  
     foreach ($value->responsables as $valuePersona) 
     {
        $id=(string)$valuePersona->idPersona;           
        $personaRevisada[$id]['nombre']=(string)$valuePersona->persona;  
        if (!array_key_exists('conformidadMala', $personaRevisada[$id])){ $personaRevisada[$id]['conformidadMala']="";}
     if (!array_key_exists('conformidaBuena', $personaRevisada[$id])){ $personaRevisada[$id]['conformidaBuena']="";}
        if($valuePersona->conformidadMala==1){ $personaRevisada[$id]['conformidadMala']=$personaRevisada[$id]['conformidadMala']."1";}
         else{$personaRevisada[$id]['conformidaBuena']=$personaRevisada[$id]['conformidaBuena']."1";   }
         $personaRevisada[$id]['tipoPersona']=$valuePersona->tipoPersona;
     }

    }    
  if($value->noConformidadRevisada==0){$pendientes++;}
  else{$revisadas++;}
  $total++;
}
   

/*VIENE CUANDO EN CLIENTE CALIFICA A UN AGENTE EN LA PAGINA DE CAPITALSEGUROS EN LA PARTE DEL VALIDADOR*/
$consulta='select  cast(tnc.fechaCreacion as date) as fCreacion,tnc.comentarioTNC,i.tipoInconformidad,tnc.fechaCreacion,tnc.aFavor,CONCAT(if(p.nombres is null or p.nombres="","",p.nombres)," ",if(p.apellidoPaterno is null || p.apellidoPaterno="","",p.apellidoPaterno)," ",if(p.apellidoMaterno is null || p.apellidoMaterno="","",p.apellidoMaterno)) as personaInconforme,i.correoProcedente,i.nombreProcedente,i.descripcion,tnc.idTablaNoConformidad,tnc.idPersonaInconforme,tnc.idPersonaResponsable,CONCAT(if(pr.nombres is null or pr.nombres="","",pr.nombres)," ",if(pr.apellidoPaterno is null || pr.apellidoPaterno="","",pr.apellidoPaterno)," ",if(pr.apellidoMaterno is null || pr.apellidoMaterno="","",pr.apellidoMaterno)) as personaResponsable,i.datosAlternos,tnc.noConformidadRevisada,(if(tnc.noConformidadRevisada=1,"Revisada","Pendiente")) as descrNoConfomridadRevisada,"" as ramoActividad,(if(cr.causaRaiz is null,"",cr.causaraiz)) as causaRaiz,(if(ac.accionCorrectiva is null,"",ac.accionCorrectiva)) as accionCorrectiva,tnc.comentarioCausaRaiz,tnc.comentarioAccionCorrectiva,tnc.comentarioCierre from tablanoconformidad tnc  left join inconformidades i on i.id=tnc.idRowTabla  left join causaraiz cr on cr.idCausaRaiz=tnc.idCausaRaiz
left join accioncorrectiva ac on ac.idAccionCorrectiva=tnc.idAccionCorrectiva left join persona p on p.idPersona=tnc.idPersonaInconforme left join persona pr on pr.idPersona=tnc.idPersonaResponsable where tnc.nombreTabla="inconformidades"  and i.tipoInconformidad=1 and YEAR(cast(tnc.fechaCreacion as date))='.$array['fecha'].' and tnc.idPersonaInconforme='.$this->tank_auth->get_idPersona();

$respuesta['calificaCliente']=$this->db->query($consulta)->result();

foreach($respuesta['calificaCliente'] as $value){
  $consulta="";
  $consulta='select r.idTablaNoConformidad ,r.idPersona,(if(r.conformidadMala=1,"Mala","Buena")) as descricpioConformidadMala,r.conformidadMala,
CONCAT(IF(p.nombres IS NULL OR p.nombres="","",p.nombres)," ", IF(p.apellidoPaterno IS NULL || p.apellidoPaterno="","",p.apellidoPaterno)," ", IF(p.apellidoMaterno IS NULL || p.apellidoMaterno="","",p.apellidoMaterno)) AS persona,p.tipoPersona
from tablanoconformidadresponsables r
left join persona p on p.idPersona=r.idPersona
where r.idTablaNoConformidad='.$value->idTablaNoConformidad;
  $value->responsables=$this->db->query($consulta)->result();

  $consulta="select * from tablanoconformidadcomentarios c where c.tipoComentario=0 and c.idTablaNoConformidad=".$value->idTablaNoConformidad;
  $value->comentarioPersonal=$this->db->query($consulta)->result();
  $consulta="select * from tablanoconformidadcomentarios c where c.tipoComentario=1 and c.idTablaNoConformidad=".$value->idTablaNoConformidad;
  $value->comentarioInconforme=$this->db->query($consulta)->result();
  $consulta="select * from tablanoconformidadcomentarios c where c.tipoComentario=2 and c.idTablaNoConformidad=".$value->idTablaNoConformidad;
  $value->comentarioResponsable=$this->db->query($consulta)->result();
    if($value->noConformidadRevisada==1){
      
     foreach ($value->responsables as $valuePersona) 
     {
        $id=(string)$valuePersona->idPersona;      
     
        $personaRevisada[$id]['nombre']=(string)$valuePersona->persona;  
        if (!array_key_exists('conformidadMala', $personaRevisada[$id])){ $personaRevisada[$id]['conformidadMala']="";}
     if (!array_key_exists('conformidaBuena', $personaRevisada[$id])){ $personaRevisada[$id]['conformidaBuena']="";}
        if($valuePersona->conformidadMala==1){$personaRevisada[$id]['conformidadMala']=$personaRevisada[$id]['conformidadMala']."1"; }
         else{$personaRevisada[$id]['conformidaBuena']=$personaRevisada[$id]['conformidaBuena']."1"; }
         $personaRevisada[$id]['tipoPersona']=$valuePersona->tipoPersona;
     }

    }    
  if($value->noConformidadRevisada==0){$pendientes++;}
  else{$revisadas++;}
  $total++;
}




/*CUANDO EL AGENTE CALIFICA MAL UNA ACTIVIDAD QUE ESTA ACARGO DE LA PARTE DE OPERATIVA*/
$consulta='select  cast(tnc.fechaCreacion as date) as fCreacion,tnc.comentarioTNC,tnc.fechaCreacion,tnc.aFavor,CONCAT(if(p.nombres is null or p.nombres="","",p.nombres)," ",if(p.apellidoPaterno is null || p.apellidoPaterno="","",p.apellidoPaterno)," ",if(p.apellidoMaterno is null || p.apellidoMaterno="","",p.apellidoMaterno)) as personaInconforme,a.comentarioActividad,a.folioActividad,a.tipoActividad,
tnc.idTablaNoConformidad,tnc.idPersonaInconforme,tnc.idPersonaResponsable,tnc.noConformidadRevisada,(if(tnc.noConformidadRevisada=1,"Revisada","Pendiente")) as descrNoConfomridadRevisada,
CONCAT(if(pr.nombres is null or pr.nombres="","",pr.nombres)," ",if(pr.apellidoPaterno is null || pr.apellidoPaterno="","",pr.apellidoPaterno)," ",if(pr.apellidoMaterno is null || pr.apellidoMaterno="","",pr.apellidoMaterno)) as personaResponsable,a.ramoActividad,(if(cr.causaRaiz is null,"",cr.causaraiz)) as causaRaiz,(if(ac.accionCorrectiva is null,"",ac.accionCorrectiva)) as accionCorrectiva,tnc.comentarioCausaRaiz,tnc.comentarioAccionCorrectiva,tnc.comentarioCierre,"" as descripcion
from tablanoconformidad tnc 
left join actividades a on a.idInterno=tnc.idRowTabla 
left join causaraiz cr on cr.idCausaRaiz=tnc.idCausaRaiz
left join accioncorrectiva ac on ac.idAccionCorrectiva=tnc.idAccionCorrectiva
left join persona p on p.idPersona=tnc.idPersonaInconforme
left join persona pr on pr.idPersona=tnc.idPersonaResponsable
where tnc.nombreTabla="actividades" and YEAR(cast(tnc.fechaCreacion as date))='.$array['fecha'].' and tnc.idPersonaInconforme='.$this->tank_auth->get_idPersona();

$respuesta['calificaAgente']=$this->db->query($consulta)->result();


foreach($respuesta['calificaAgente'] as $value){
  $consulta="";
  $consulta='select r.idTablaNoConformidad ,r.idPersona,(if(r.conformidadMala=1,"Mala","Buena")) as descricpioConformidadMala,r.conformidadMala,
CONCAT(IF(p.nombres IS NULL OR p.nombres="","",p.nombres)," ", IF(p.apellidoPaterno IS NULL || p.apellidoPaterno="","",p.apellidoPaterno)," ", IF(p.apellidoMaterno IS NULL || p.apellidoMaterno="","",p.apellidoMaterno)) AS persona,p.tipoPersona
from tablanoconformidadresponsables r
left join persona p on p.idPersona=r.idPersona
where r.idTablaNoConformidad='.$value->idTablaNoConformidad;

  $value->responsables=$this->db->query($consulta)->result();
     $consulta="select * from tablanoconformidadcomentarios c where c.tipoComentario=0 and c.idTablaNoConformidad=".$value->idTablaNoConformidad;
  $value->comentarioPersonal=$this->db->query($consulta)->result();
  $consulta="select * from tablanoconformidadcomentarios c where c.tipoComentario=1 and c.idTablaNoConformidad=".$value->idTablaNoConformidad;
  $value->comentarioInconforme=$this->db->query($consulta)->result();
  $consulta="select * from tablanoconformidadcomentarios c where c.tipoComentario=2 and c.idTablaNoConformidad=".$value->idTablaNoConformidad;
  $value->comentarioResponsable=$this->db->query($consulta)->result();
     if($value->noConformidadRevisada==1){
      
     foreach ($value->responsables as $valuePersona) 
     {
        $id=(string)$valuePersona->idPersona;      
        $personaRevisada[$id]['nombre']=(string)$valuePersona->persona;      
        
        if (!array_key_exists('conformidadMala', $personaRevisada[$id])){ $personaRevisada[$id]['conformidadMala']="";}
        if (!array_key_exists('conformidaBuena', $personaRevisada[$id])){ $personaRevisada[$id]['conformidaBuena']="";}
 
        if($valuePersona->conformidadMala==1){ $personaRevisada[$id]['conformidadMala']=$personaRevisada[$id]['conformidadMala']."1";  }
        else{$personaRevisada[$id]['conformidaBuena']=$personaRevisada[$id]['conformidaBuena']."1"; }
       $personaRevisada[$id]['tipoPersona']=$valuePersona->tipoPersona; 
     }

    }    
  if($value->noConformidadRevisada==0){$pendientes++;}
  else{$revisadas++;}
  $total++;
}
    


$consulta='select  cast(tnc.fechaCreacion as date) as fCreacion,tnc.*,a.tipoActividad,a.folioActividad,
(concat(p.nombres," ",p.apellidoPaterno," ",p.apellidoMaterno)) as personaInconforme,
(concat(p2.nombres," ",p2.apellidoPaterno," ",p2.apellidoMaterno)) as personaResponsable,(if(tnc.noConformidadRevisada=1,"Revisada","Pendiente")) as descrNoConfomridadRevisada,a.ramoActividad,(if(cr.causaRaiz is null,"",cr.causaraiz)) as causaRaiz,(if(ac.accionCorrectiva is null,"",ac.accionCorrectiva)) as accionCorrectiva,tnc.comentarioCausaRaiz,tnc.comentarioAccionCorrectiva,tnc.comentarioCierre,"" as descripcion
from tablanoconformidad tnc 
left join actividades a on a.idInterno=tnc.idRowTabla
left join causaraiz cr on cr.idCausaRaiz=tnc.idCausaRaiz
left join accioncorrectiva ac on ac.idAccionCorrectiva=tnc.idAccionCorrectiva
left join persona p on p.idPersona=tnc.idPersonaInconforme
left join persona p2 on p2.idPersona=tnc.idPersonaResponsable
where tnc.nombreTabla="calificacionactividad" and YEAR(cast(tnc.fechaCreacion as date))='.$array['fecha'].' and tnc.idPersonaInconforme='.$this->tank_auth->get_idPersona();

$respuesta['calificaOperativo']=$this->db->query($consulta)->result();

//$personaRevisada=array();

foreach($respuesta['calificaOperativo'] as $value){
  $consulta="";
  $consulta='select r.idTablaNoConformidad ,r.idPersona,(if(r.conformidadMala=1,"Mala","Buena")) as descricpioConformidadMala,r.conformidadMala,
CONCAT(IF(p.nombres IS NULL OR p.nombres="","",p.nombres)," ", IF(p.apellidoPaterno IS NULL || p.apellidoPaterno="","",p.apellidoPaterno)," ", IF(p.apellidoMaterno IS NULL || p.apellidoMaterno="","",p.apellidoMaterno)) AS persona,p.tipoPersona
from tablanoconformidadresponsables r
left join persona p on p.idPersona=r.idPersona
where r.idTablaNoConformidad='.$value->idTablaNoConformidad;
  $value->responsables=$this->db->query($consulta)->result();
    $consulta="select * from tablanoconformidadcomentarios c where c.tipoComentario=0 and c.idTablaNoConformidad=".$value->idTablaNoConformidad;
  $value->comentarioPersonal=$this->db->query($consulta)->result();
  $consulta="select * from tablanoconformidadcomentarios c where c.tipoComentario=1 and c.idTablaNoConformidad=".$value->idTablaNoConformidad;
  $value->comentarioInconforme=$this->db->query($consulta)->result();
  $consulta="select * from tablanoconformidadcomentarios c where c.tipoComentario=2 and c.idTablaNoConformidad=".$value->idTablaNoConformidad;
  $value->comentarioResponsable=$this->db->query($consulta)->result();
     if($value->noConformidadRevisada==1){
      
     foreach ($value->responsables as $valuePersona) 
     {
        $id=(string)$valuePersona->idPersona;           
        $personaRevisada[$id]['nombre']=(string)$valuePersona->persona;  
       if (!array_key_exists('conformidadMala', $personaRevisada[$id])){ $personaRevisada[$id]['conformidadMala']="";}
       if (!array_key_exists('conformidaBuena', $personaRevisada[$id])){ $personaRevisada[$id]['conformidaBuena']="";}        
       if($valuePersona->conformidadMala==1){$personaRevisada[$id]['conformidadMala']=$personaRevisada[$id]['conformidadMala']."1";}
       else{$personaRevisada[$id]['conformidaBuena']=$personaRevisada[$id]['conformidaBuena']."1"; }
       $personaRevisada[$id]['tipoPersona']=$valuePersona->tipoPersona;
     }

    }    
  if($value->noConformidadRevisada==0){$pendientes++;}
  else{$revisadas++;}
  $total++;
}



foreach ($respuesta['calificaOperativo'] as $value) {
  $consulta='select * from calificacionactividad ca left join calificacionagente cg on cg.idCalificacionAgente=ca.idCalificacionAgente where ca.idInternoActividad='.$value->idRowTabla;
 $value->estrellas=$this->db->query($consulta)->result();  
}

foreach ($personaRevisada as $key => $value) {
  $personaRevisada[$key]['idPersona']=$key;
}
$respuesta['personaRevisada']=array();
foreach ($personaRevisada as $key => $value) {
array_push($respuesta['personaRevisada'], $value);  
}
 
$respuesta['pendientes']=$pendientes;
$respuesta['revisadas']=$revisadas;
$respuesta['total']=$total;
//$respuesta['personaRevisada']=$personaRevisada;

return $respuesta;


}

//---------------------------------------------
function buscarcalificacionesactividad($array){
    $add="";
    if($array['todos']=="no"){
       $add= 'where ((cast(fechaCalificacionActividad  as date))>="'.$array['fechaInicial'].'" and (cast(fechaCalificacionActividad as date))<="'.$array['fechaFinal'].'")';
    }
    $consulta = 'select * FROM `calificacionactividad`'.$add; 
    return $this->db->query($consulta)->result();
    }

function buscarcalfbuenasporpersona($array){
    $add="";
    if($array['todos']=="no"){
       $add= 'and ((cast(fechaCalificacionActividad  as date))>="'.$array['fechaInicial'].'" and (cast(fechaCalificacionActividad as date))<="'.$array['fechaFinal'].'")';
    }
    $consulta="select concat(p.nombres,' ',p.apellidoPaterno,' ',p.apellidoMaterno) as nombreCompleto, COUNT(calificacionActividad) as buena FROM `calificacionactividad` c left JOIN `persona` p ON p.idPersona=c.idPersona where calificacionActividad=1 ".$add." group by c.idPersona";
    return $this->db->query($consulta)->result();
}

function buscarcalfmalasporpersona($array){
    $add="";
    if($array['todos']=="no"){
       $add= 'and ((cast(fechaCalificacionActividad  as date))>="'.$array['fechaInicial'].'" and (cast(fechaCalificacionActividad as date))<="'.$array['fechaFinal'].'")';
    }
    $consulta="select concat(p.nombres,' ',p.apellidoPaterno,' ',p.apellidoMaterno) as nombreCompleto, COUNT(calificacionActividad) as mala FROM `calificacionactividad` c left JOIN `persona` p ON p.idPersona=c.idPersona where calificacionActividad=0 ".$add." group by c.idPersona";
    return $this->db->query($consulta)->result();
}
//---------------------------------------------
function buscarcalificacionesactividadEjecutivo($array){
    $add="";
    if($array['todos']=="no"){
       $add= 'AND ((cast(fechaCreacion  as date))>="'.$array['fechaInicial'].'" and (cast(fechaCreacion as date))<="'.$array['fechaFinal'].'")';
    }
    $consulta="select count(`folioActividad`) as bueno FROM `actividades` where status=6 ".$add;
    return $this->db->query($consulta)->result();
}
function buscarcalificacionesactividadEjecutivoMalas($array){
    $add="";
    if($array['todos']=="no"){
       $add= 'and ((cast(fechaCreacion  as date))>="'.$array['fechaInicial'].'" and (cast(fechaCreacion as date))<="'.$array['fechaFinal'].'")';
    }
    $consulta="select count(`folioActividad`) as malo FROM `actividades` WHERE `satisfaccion`='malo' AND status=6".$add;
    return $this->db->query($consulta)->result();
}
//---------------------------------------------
function devolverInconformidadesPorAnioPorPersona($array)
{
  

  $consulta='select  cast(tnc.fechaCreacion as date) as fCreacion,tnc.comentarioTNC,i.tipoInconformidad,tnc.fechaCreacion,tnc.aFavor,
CONCAT(if(p.nombres is null or p.nombres="","",p.nombres)," ",if(p.apellidoPaterno is null || p.apellidoPaterno="","",p.apellidoPaterno)," ",
if(p.apellidoMaterno is null || p.apellidoMaterno="","",p.apellidoMaterno)) as personaInconforme,i.correoProcedente,i.nombreProcedente,
i.descripcion,tnc.idTablaNoConformidad,tnc.idPersonaInconforme,tnc.idPersonaResponsable,CONCAT(if(pr.nombres is null or pr.nombres="","",pr.nombres)," ",
if(pr.apellidoPaterno is null || pr.apellidoPaterno="","",pr.apellidoPaterno)," ",
if(pr.apellidoMaterno is null || pr.apellidoMaterno="","",pr.apellidoMaterno)) as personaResponsable,i.datosAlternos,tnc.noConformidadRevisada,
(if(tnc.noConformidadRevisada=1,"Revisada","Pendiente")) as descrNoConfomridadRevisada from tablanoconformidad tnc  
left join inconformidades i on i.id=tnc.idRowTabla left join persona p on p.idPersona=tnc.idPersonaInconforme 
left join persona pr on pr.idPersona=tnc.idPersonaResponsable 
where tnc.nombreTabla="inconformidades"  and i.tipoInconformidad=0 and YEAR(cast(tnc.fechaCreacion as date))='.$array['fecha'].' and tnc.idPersonaInconforme='.$this->tank_auth->get_idPersona();


$respuesta['calificaUsuario']=$this->db->query($consulta)->result();
foreach($respuesta['calificaUsuario'] as $value){
  $consulta="";
  $consulta='select r.idTablaNoConformidad ,r.idPersona,(if(r.conformidadMala=1,"Mala","Buena")) as descricpioConformidadMala,r.conformidadMala,
CONCAT(IF(p.nombres IS NULL OR p.nombres="","",p.nombres)," ", IF(p.apellidoPaterno IS NULL || p.apellidoPaterno="","",p.apellidoPaterno)," ", IF(p.apellidoMaterno IS NULL || p.apellidoMaterno="","",p.apellidoMaterno)) AS persona from tablanoconformidadresponsables r left join persona p on p.idPersona=r.idPersona where r.idTablaNoConformidad='.$value->idTablaNoConformidad;

  $value->responsables=$this->db->query($consulta)->result();

    if($value->noConformidadRevisada==1){
  
     foreach ($value->responsables as $valuePersona) 
     {
        $id=(string)$valuePersona->idPersona;           
        $personaRevisada[$id]['nombre']=(string)$valuePersona->persona;  
        if (!array_key_exists('conformidadMala', $personaRevisada[$id])){ $personaRevisada[$id]['conformidadMala']="";}
     if (!array_key_exists('conformidaBuena', $personaRevisada[$id])){ $personaRevisada[$id]['conformidaBuena']="";}
        if($valuePersona->conformidadMala==1){          
           $personaRevisada[$id]['conformidadMala']=$personaRevisada[$id]['conformidadMala']."1";                  
         }
         else{

          
           $personaRevisada[$id]['conformidaBuena']=$personaRevisada[$id]['conformidaBuena']."1"; 
         
          //$personaRevisada[$id]['conformidaBuena']=(string)$personaRevisada[$id]['conformidadBuena'].0;  
         }
     }

    }    
  
}
 
return $respuesta;
}
//-------------------------------------
function reporteEstrellasAgente($array=null)
{
  $fecha="";
  
  if(isset($array['fechaInicial']) && isset($array['fechaFinal']))
  {
    $fecha=' where cast(fechaCreacion as date)>="'.$array['fechaInicial'].'" and cast(fechaCreacion as date)<="'.$array['fechaFinal'].'"';
  }
  
  $consulta='select (sum(if(evc.tipoEstrellas= 0 and evcp.calificacionValidador=1,1,0))) sumClienteNuevo,(sum(if(evc.tipoEstrellas=1 and evcp.calificacionValidador=1,1,0))) sumCliente,(sum(if(evcp.calificacionValidador=1,1,0))) sumTotal,(sum(if(evc.tipoEstrellas= 0 ,1,0))) totalClienteNuevo,(sum(if(evc.tipoEstrellas= 1 ,1,0))) totalCliente,(count(distinct(evc.idestrellasvalidadorcabecera))) as totalPersonas,(sum(if(evc.tipoEstrellas= 1 || evc.tipoEstrellas= 0,1,0))) total,p.nombres,p.apellidoPaterno,p.apellidoMaterno from estrellasvalidadorcabecera evc
left join estrellasvalidadorcabecerapartidas evcp on evcp.idEstrellasValidadorCabecera=evc.idestrellasvalidadorcabecera
  left join persona p on p.idPersona =evc.idPersona '.$fecha.' group by evc.idPersona ';
  
$informacion=$this->db->query($consulta)->result();
return $informacion;
}
//-----------------------------------------------------------
function tablanoconformidadcomentarios($array)
{
  
  if(isset($array['idTNCComentarios']))
  {
    if($array['idTNCComentarios']==-1)
     {
      unset($array['idTNCComentarios']);
      $this->db->insert('tablanoconformidadcomentarios',$array);      
     }
     else
     {
      if(isset($array['update']))
      {
        unset($array['update']);
        $this->db->where('idTNCComentarios',$array['idTNCComentarios']);
        $this->db->update('tablanoconformidadcomentarios',$array);
      }
     }
  }
  else
  {
    if(isset($array['idTablaNoConformidad']))
    {
     $consulta="select * from tablanoconformidadcomentarios tnc where tnc.estaEliminado=0 and tnc.idTablaNoConformidad=".$array['idTablaNoConformidad'];
     $datos=$this->db->query($consulta)->result();
     return $datos;
    }
  }

}

//----------------------------------------------------------
function tablanoconformidadDatos($array)
{
  if(isset($array['idTablaNoConformidad']))
  {
    $consulta=" select tnc.*,cr.causaRaiz,ac.accionCorrectiva from tablanoconformidad tnc left join causaraiz cr on cr.idCausaRaiz=tnc.idCausaRaiz left join accioncorrectiva ac on ac.idAccionCorrectiva=tnc.idAccionCorrectiva where tnc.idTablaNoConformidad=".$array['idTablaNoConformidad'];
    $datos=$this->db->query($consulta)->result();
    return $datos;
  }
}
//-----------------------------------
function tablanoconformidadresponsablesBorrar($idTablaNoConformidad)
{
  $this->db->where('idTablaNoConformidad',$idTablaNoConformidad);
  $this->db->delete('tablanoconformidadresponsables');
}
//-----------------------------------
function tablanoconformidadeliminarResponsable($idTablaNoConformidad, $idPersona)
{
    $consulta="delete from tablanoconformidadresponsables where idTablaNoConformidad=".$idTablaNoConformidad." and idPersona=".$idPersona;
    $datos=$this->db->query($consulta)->result();      
    return $datos;
}
//-----------------------------------
function tablanoconformidadresponsablesSeleccionar($idTablaNoConformidad)
{
  $consulta="select r.*,p.apellidoPaterno,p.apellidoMaterno,p.nombres,u.email from tablanoconformidadresponsables r left join persona p on p.idPersona=r.idPersona left join users u on u.idPersona=p.idPersona where idTablaNoConformidad=".$idTablaNoConformidad;

  return $this->db->query($consulta)->result();
}
//-----------------------------------
function statusNoConformidad($array=null)
{
  $consulta='select * from tablanoconformidadstatus t order by t.orden';
  $respuesta=$this->db->query($consulta)->result();
  return $respuesta;
}
//-----------------------------------
}
