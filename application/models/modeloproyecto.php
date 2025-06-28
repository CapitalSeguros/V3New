<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class modeloproyecto extends CI_Model {
	var $funcionLlamar;
	var $datos;
//-----------------------------------------------------------------
	function __construct(){
		parent::__construct();     
    $this->idusuario=$this->tank_auth->get_idPersona();
    $this->load->model('manejodocumento_modelo');
    }
 function verificaInvitado($tipo,$idpersona,$idproyecto)
 {
    if($tipo == 'OPERATIVO') 
    {
     $consulta="select * from pproyectos where idpersona = '".$idpersona."' and idproyecto ='".$idproyecto."'";
	 $datos=$this->db->query($consulta);
      if( $datos->num_rows() > 0)
      {  
       return 1;
      }
      else
      {
        return 0;   
      }
     // return $consulta;
    }

 }   
 /************************************* */
 function devuelveCom()
 {
  $consulta="select * from comite";
  $datos=$this->db->query($consulta);
  return $datos->result(); 
}
 /************************************* */
 function devuelveComites($usuario)
 {
  //huricm 12-05-2023
  $consulta="select pr.idproyecto,CONCAT(pr.nombre,'-', tr.nombre) as nombre,tr.idtarea,tr.fechacomite,tr.comite from proyectos pr,tareas tr where pr.usuario = ".$usuario." and tr.idproyecto = pr.idproyecto and tr.comision =1";
   
  $datos=$this->db->query($consulta);
  return $datos->result(); 
  /*
  $consulta="select * from comite";
  $datos=$this->db->query($consulta);
  return $datos->result(); */
 }
 /****************************************************** */
 function devuelvesubfechas($usuario,$ano,$mes,$dia,$tipo )
 {
  $cadena ="";
  $tarea ="";
  $subtarea ="";
  if($tipo == 1)
  {
    //devuelve Proyectos
     $cadena = "select p.nombre,p.fecha from proyectos p where 
     p.usuario =".$usuario." and YEAR(p.fecha) ='".$ano."'
     union
     select p.nombre,p.fecha from proyectos p,pproyectos pp where 
     p.idproyecto = pp.idproyecto and
     pp.idpersona =".$usuario." and YEAR(p.fecha) ='".$ano."'";
     $tarea = "select t.nombre,t.fechaentrega from tareas t,proyectos p, pproyectos pp where
     p.idproyecto = pp.idproyecto and
      t.idproyecto =pp.idproyecto and p.usuario =".$usuario." and YEAR(t.fechaentrega) ='".$ano."'
      union
      select t.nombre,t.fechaentrega from tareas t,proyectos p,pproyectos pp where
     p.idproyecto = pp.idproyecto and
      t.idproyecto =pp.idproyecto and pp.idpersona =".$usuario." and YEAR(t.fechaentrega) ='".$ano."'";
      $subtarea ="select t.nombre,t.fechaentrega from subtareas t,proyectos p,pproyectos pp where
      p.idproyecto = pp.idproyecto and
       t.idproyecto =pp.idproyecto and p.usuario =".$usuario." and YEAR(t.fechaentrega) ='".$ano."'
       union
       select t.nombre,t.fechaentrega from subtareas t,proyectos p,pproyectos pp where
      p.idproyecto = pp.idproyecto and
       t.idproyecto =pp.idproyecto and pp.idpersona = ".$usuario." and YEAR(t.fechaentrega) ='".$ano."'";
  } 
  if($tipo == 2)
  {
    //devuelve Proyectos
     $cadena = "select p.nombre,p.fecha from proyectos p where 
     p.usuario =".$usuario." and YEAR(p.fecha) ='".$ano."' and MONTH(p.fecha)= ".$mes."
     union
     select p.nombre,p.fecha from proyectos p,pproyectos pp where 
     p.idproyecto = pp.idproyecto and
     pp.idpersona =".$usuario." and YEAR(p.fecha) ='".$ano."' and MONTH(p.fecha)= ".$mes;
     $tarea = "select t.nombre,t.fechaentrega from tareas t,proyectos p,pproyectos pp where
     p.idproyecto = pp.idproyecto and
      t.idproyecto =pp.idproyecto and p.usuario =".$usuario." and YEAR(t.fechaentrega) ='".$ano."' and MONTH(t.fechaentrega)= ".$mes."
      union
      select t.nombre,t.fechaentrega from tareas t,proyectos p,pproyectos pp where
     p.idproyecto = pp.idproyecto and
      t.idproyecto =pp.idproyecto and pp.idpersona =".$usuario." and YEAR(t.fechaentrega) ='".$ano."' and MONTH(t.fechaentrega)= ".$mes;
      $subtarea ="select t.nombre,t.fechaentrega from subtareas t,proyectos p,pproyectos pp where
      p.idproyecto = pp.idproyecto and
       t.idproyecto =pp.idproyecto and p.usuario =".$usuario." and YEAR(t.fechaentrega) ='".$ano."' and MONTH(t.fechaentrega)= ".$mes."
       union
       select t.nombre,t.fechaentrega from subtareas t,proyectos p,pproyectos pp where
      p.idproyecto = pp.idproyecto and
       t.idproyecto =pp.idproyecto and pp.idpersona = ".$usuario." and YEAR(t.fechaentrega) ='".$ano."' and MONTH(t.fechaentrega)= ".$mes;
  } 
  if($tipo == 3)
  {
    $cadena = "select p.nombre,p.fecha from proyectos p where 
    p.usuario =".$usuario." and YEAR(p.fecha) ='".$ano."' and MONTH(p.fecha)= ".$mes." and DAY(p.fecha)= ".$dia."
    union
    select p.nombre,p.fecha from proyectos p,pproyectos pp where 
    p.idproyecto = pp.idproyecto and
    pp.idpersona =".$usuario." and YEAR(p.fecha) ='".$ano."' and MONTH(p.fecha)= ".$mes." and DAY(p.fecha)= ".$dia;
    $tarea = "select t.nombre,t.fechaentrega from tareas t,proyectos p,pproyectos pp where
    p.idproyecto = pp.idproyecto and
     t.idproyecto =pp.idproyecto and p.usuario =".$usuario." and YEAR(t.fechaentrega) ='".$ano."' and MONTH(t.fechaentrega)= ".$mes." and DAY(t.fechaentrega)= ".$dia."
     union
     select t.nombre,t.fechaentrega from tareas t,proyectos p,pproyectos pp where
    p.idproyecto = pp.idproyecto and
     t.idproyecto =pp.idproyecto and pp.idpersona =".$usuario." and YEAR(t.fechaentrega) ='".$ano."' and MONTH(t.fechaentrega)= ".$mes." and DAY(t.fechaentrega)= ".$dia;
     $subtarea ="select t.nombre,t.fechaentrega from subtareas t,proyectos p,pproyectos pp where
     p.idproyecto = pp.idproyecto and
      t.idproyecto =pp.idproyecto and p.usuario =".$usuario." and YEAR(t.fechaentrega) ='".$ano."' and MONTH(t.fechaentrega)= ".$mes." and DAY(t.fechaentrega)= ".$dia."
      union
      select t.nombre,t.fechaentrega from subtareas t,proyectos p,pproyectos pp where
     p.idproyecto = pp.idproyecto and
      t.idproyecto =pp.idproyecto and pp.idpersona = ".$usuario." and YEAR(t.fechaentrega) ='".$ano."' and MONTH(t.fechaentrega)= ".$mes." and DAY(t.fechaentrega)= ".$dia;
  }
  $datos['proyecto'] = $this->db->query($cadena)->result();
  $datos['tarea'] =$this->db->query($tarea)->result();
  $datos['subtarea'] =$this->db->query($subtarea)->result();
  return $datos;

 }
 /****************************************************** */
 function devfechaProyecto($idproyecto,$fecha,$tipo)
 {
   $consulta = "Select fecha from proyectos where idproyecto =".$idproyecto;
   // return $consulta;
   $datos=$this->db->query($consulta)->result();
   //Actualizamos la fecha 
   $nuevafecha =$datos[0]->fecha;
   $consulta = "update proyectos set fecha = '".$fecha."', agregafecha =1 where idproyecto =".$idproyecto;
   $datos=$this->db->query($consulta);
   
   $consulta="";
   $consulta = "INSERT INTO posfecha (idproy, fechaanterior, tipo)VALUES (".$idproyecto.",'".$nuevafecha."' ,".$tipo." )";
   $this->db->query($consulta);
   return  1;

 }
 /****************************************************** */
 function verificaInvitadoexterno($tipo,$correo,$idproyecto)
 {
    
     $consulta="select * from pproyectos where correo = '".$correo."' and idproyecto ='".$idproyecto."'";
	 $datos=$this->db->query($consulta);
      if( $datos->num_rows() > 0)
      {  
       return 1;
      }
      else
      {
        return 0;   
      }
    

 }   
 /****************************************************** */
 function devuelveusuariosdesubTarea($idtarea)
  {
   $consulta="select * from psubtareas where idsubtareas = '".$idtarea."'";
   $datos=$this->db->query($consulta);
   if($datos->num_rows()>0){
    return $datos;
   }
   //return $consulta;
  } 
  /************************************************** */
 function verificaProyecto($proyecto)
 {
      $consulta="select idproyecto from proyectos where nombre = 'Automatico'";
     // return $consulta;
       $datos=$this->db->query($consulta);
      if( $datos->num_rows() > 0)
      {  
        $id= $datos->result();
        return $id[0]->idproyecto;
      }
      else
      {
        return 0;   
      }
    
 }   
 /****************************************************** */
 function devuelveProyecto($idproyecto)
 {
    //if($tipo == 'OPERATIVO') 
   // {
     $consulta="select * from proyectos where  idproyecto ='".$idproyecto."'";
  	 $datos=$this->db->query($consulta);
      if( $datos->num_rows() > 0)
      {  
       return $datos;
      }
      else
      {
        return 0;   
      }
      //return $consulta;
   // }

 }
 
 
 /****************************************************** */

 function verificaClente($tipo,$correo,$idproyecto)
 {
    //if($tipo == 'OPERATIVO') 
   // {
     $consulta="select * from pproyectos where correo = '".$correo."' and idproyecto ='".$idproyecto."'";
  	 $datos=$this->db->query($consulta);
      if( $datos->num_rows() > 0)
      {  
       return 1;
      }
      else
      {
        return 0;   
      }
     // return $consulta;
   // }

 }
  /****************************************************** */
  function verificaEmpleado($tipo,$correo,$idtarea)
  {
     //if($tipo == 'OPERATIVO') 
    // {
      $consulta="select * from ptareas where correo = '".$correo."' and idtarea ='".$idtarea."'";
      $datos=$this->db->query($consulta);
       if( $datos->num_rows() > 0)
       {  
        return 1;
       }
       else
       {
         return 0;   
       }
      // return $consulta;
    // }
 
  }
  
  /****************************************************** */
  function verificasubEmpleado($tipo,$correo,$idtarea)
  {
     //if($tipo == 'OPERATIVO') 
    // {
      $consulta="select * from psubtareas where correo = '".$correo."' and idtarea ='".$idtarea."'";
      $datos=$this->db->query($consulta);
       if( $datos->num_rows() > 0)
       {  
        return 1;
       }
       else
       {
         return 0;   
       }
      // return $consulta;
    // }
 
  }
  /************************************************** */
function devuelveusuario($idproyecto){
  $consulta="select usuario from proyectos where idproyecto =".$idproyecto;
  $datos=$this->db->query($consulta)->result();
  return $datos[0]->usuario;
}
   /****************************************************** */
   function devuelveusuariosdeTarea($idtarea)
   {
   $consulta="select * from ptareas where idtarea = '".$idtarea."'";
   $datos=$this->db->query($consulta);
   if($datos->num_rows()>0){
    return $datos;
   }
   //return $consulta;
   }  
     /****************************************************** */
     function devuelveusuariosdeProyecto($idtarea)
     {
     $consulta="select * from tareas t ,pproyectos pp
             where pp.idproyecto = t.idproyecto and t.idtarea = '".$idtarea."'";
     $datos=$this->db->query($consulta);
     if($datos->num_rows()>0){
      return $datos;
     }
    // return $consulta;
     }  
   /****************************************************** */
   function verificaTareaextra($correo,$idtarea)
   {
      //if($tipo == 'OPERATIVO') 
     // {
       $consulta="select * from ptareas where correo = '".$correo."' and idtarea ='".$idtarea."'";
       $datos=$this->db->query($consulta);
        if( $datos->num_rows() > 0)
        {  
         return 1;
        }
        else
        {
          return 0;   
        }
       // return $consulta;
     // }
  
   }
     /****************************************************** */
 function devuelveTareasExt($idproyecto)
 {
       $consulta="select * from tareas where idproyecto ='".$idproyecto."'";
  	 $datos=$this->db->query($consulta);
       return $datos;
 }
 /****************************************************** */
 function devuelveTareasUsuario()
 {
     //$consulta="select * from tareas where idproyecto ='".$idproyecto."'";
    // $usuario = 5;
     $usuario =  $this->tank_auth->get_idPersona(); 
     $consulta= "select (t.idtarea) as orderT,t.* from tareas t,ptareas pt 
       where t.idtarea=pt.idtarea and pt.idpersona = " .$usuario;
$datos=$this->db->query($consulta);
foreach ($datos->result() as $key => $value) 
{
  $archivos=$this->manejodocumento_modelo->devolverArchivos('archivosSeguimiento/'.$value->idtarea.'/');
  $value->tieneArchivo=0;
  if(count($archivos)>0){$value->tieneArchivo=1;}
  $consulta='select * from tareascomentario where idTareas='.$value->idtarea.' order by fechaInsercion desc';
  $comentarios=$this->db->query($consulta)->result();
  
  $value->tieneComentario=0;
  if(count($comentarios)>0){$value->tieneComentario=1;}

  $consulta='select nombre,correo from ptareas where idtarea='.$value->idtarea;
  $responsables=$this->db->query($consulta)->result();
  $value->responsables=$responsables;
}
       return $datos;
 } 
 //-----------------------------------------------------------
 function devuelveTareas($idproyecto)
 {
     //$consulta="select * from tareas where idproyecto ='".$idproyecto."'";
    // $usuario = 5;
     $usuario =  $this->tank_auth->get_idPersona();
     if($idproyecto == 0)
     {
      $consulta= "select (t.idtarea) as orderT,t.*,(if(t.iniciaTiempo is null,0,1)) as inicia,(if(t.finalizaTiempo is null,0,1)) as termina from tareas t,proyectos p,pproyectos pp where
      t.idproyecto = pp.idproyecto and p.idproyecto = pp.idproyecto and (t.comision = 0 or t.comision is null) and tareaEliminada!=1
       and pp.idpersona = ".$usuario."
       union
       
      select (t.idtarea) as orderT,t.*,(if(t.iniciaTiempo is null,0,1)) as inicia,(if(t.finalizaTiempo is null,0,1)) as termina  from tareas t,ptareas pp where
      t.idtarea = pp.idtarea and
       pp.idpersona = ".$usuario."
       union
       select (t.idtarea) as orderT,t.*,(if(t.iniciaTiempo is null,0,1)) as inicia,(if(t.finalizaTiempo is null,0,1)) as termina  from tareas t,proyectos p,pproyectos pp where
        t.idproyecto = pp.idproyecto and p.idproyecto = pp.idproyecto and  (t.comision = 0 or t.comision is null) and tareaEliminada!=1
       and p.usuario =  ".$usuario." order by orderT desc";
           
     }else
     {
       $consulta="select *,(if(iniciaTiempo is null,0,1)) as inicia,(if(finalizaTiempo is null,0,1)) as termina  from tareas where  (comision = 0 or comision is null) and tareaEliminada!=1 and  idproyecto ='".$idproyecto."' order by idtarea desc,fechaentrega desc,ftarea";

     }
  	 $datos=$this->db->query($consulta);
     foreach ($datos->result() as $key => $value) 
     {
       $archivos=$this->manejodocumento_modelo->devolverArchivos('archivosSeguimiento/'.$value->idtarea.'/');
       $value->tieneArchivo=0;
       if(count($archivos)>0){$value->tieneArchivo=1;}
       $consulta='select * from tareascomentario where idTareas='.$value->idtarea.' order by fechaInsercion desc';
       $comentarios=$this->db->query($consulta)->result();
       
       $value->tieneComentario=0;
       if(count($comentarios)>0){$value->tieneComentario=1;}


       $responsables=$this->devolverResponsablesTarea($value->idtarea);
       $value->responsables=$responsables;
       $value->evaluadores = $this->devolverEvaluadoresTarea($value->idtarea);
     }
       //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($datos,TRUE));fclose($fp);            
       return $datos;
 } 
//-----------------------------------------------------------
function devolverResponsablesTarea($idTarea) //Modificado* [Suemy][2024-03-08]
{
  $consulta='select distinct p.nombre,p.correo,p.registro,ui.fotoUser from ptareas p left join user_miInfo ui on ui.idPersona=p.idpersona where  responsable in (1,0) and  idtarea='.$idTarea;       
  $responsables=$this->db->query($consulta)->result();
  return $responsables;
}
//-----------------------------------------------------------
  function devuelvesubTareas($idproyecto)
  {
      //$consulta="select * from tareas where idproyecto ='".$idproyecto."'";
     // $usuario = 5;
   $usuario =  $this->tank_auth->get_idPersona();
   if($idproyecto == 0)
   {
    $consulta= "select t.* from subtareas t,proyectos p,pproyectos pp where
    t.idproyecto = pp.idproyecto and p.idproyecto = pp.idproyecto
     and pp.idpersona = ".$usuario."
     union     
    select t.* from subtareas t,ptareas pp where
    t.idtarea = pp.idtarea and
     pp.idpersona = ".$usuario."
     union
     select t.* from subtareas t,proyectos p,pproyectos pp where
        t.idproyecto = pp.idproyecto and p.idproyecto = pp.idproyecto
       and p.usuario =  ".$usuario;      
   }else
   {
      $consulta="select * from subtareas sub where sub.idproyecto = '".$idproyecto."'";
   }  
      $datos=$this->db->query($consulta);
        return $datos;
  } 
    /****************************************************** */
 function devuelveTar($idproyecto)
 {
     $consulta="select * from tareas where idproyecto ='".$idproyecto."'";
  	 $datos=$this->db->query($consulta);
       return $datos->result();
 } 
    /****************************************************** */
    function devuelveEstado($idtarea)
    {
        $consulta="select completado from tareas where idtarea ='".$idtarea."'";
        $datos=$this->db->query($consulta)->result();
          return $datos[0]->completado;
    }  
    /****************************************************** */ 
 function devuelvesubEstado($idtarea)
 {
     $consulta="select completado from subtareas where idsubtarea ='".$idtarea."'";
  	 $datos=$this->db->query($consulta)->result();
       return $datos[0]->completado;
    //return $consulta;   
 }  
 /****************************************************** */ 
 function devuelveusuproyecto($idtarea)
 {
  $consulta ="select p.usuario,per.nombres, per.emailUsers,p.nombre,t.nombre as tarea,t.fechaalerta 
from tareas t,proyectos p,persona per
where t.idproyecto = p.idproyecto and p.usuario =per.idPersona
and t.idtarea=".$idtarea."
union 
select p.usuario,pp.nombre, pp.correo as emailUsers,p.nombre,t.nombre as tarea,t.fechaalerta   
from tareas t,proyectos p, pproyectos pp
where t.idproyecto = p.idproyecto and p.idproyecto=pp. idproyecto
and t.idtarea= ".$idtarea;
 $datos=$this->db->query($consulta)->result();
 return $datos;
 }
 /****************************************************** */ 
 function devuelveusuproy($idproyecto)
 {
  $consulta ="select p.usuario,per.nombres,per.emailUsers,p.nombre from proyectos p,persona per
  where p.usuario =per.idPersona and p.idproyecto = ".$idproyecto."
  union
  select p.usuario,pp.nombre, pp.correo ,p.nombre 
  from proyectos p, pproyectos pp
  where  p.idproyecto=pp. idproyecto
  and p.idproyecto= ".$idproyecto;
 $datos=$this->db->query($consulta)->result();
 return $datos;
 }
 /****************************************************** */ 
 function devuelveEstrella($idtarea,$usuario)
 {
  //$consulta="select acciones from tareas where idtarea ='".$idtarea."'";
  //$consulta="select idaccion from acciones where idtarea ='".$idtarea."' and idusuario = '".$usuario."'";
  $consulta="select estrella from tareas where idtarea ='".$idtarea."'";
  $datos=$this->db->query($consulta)->result();
  $respuesta = "1";
  /*if(!$datos)
  {
    $respuesta = 1;
  }
  else
  {*/
    if($datos[0]->estrella == '1')
    {
      $respuesta = 2;
    }
    if($datos[0]->estrella == '0')
    {
      $respuesta = 3;
    }
 // }
    //return $respuesta; //$datos[0]->idaccion;
    return $respuesta; 
 }
  /****************************************************** */ 
  function devuelvesubEstrella($idtarea)
  {
   //$consulta="select acciones from tareas where idtarea ='".$idtarea."'";
   //$consulta="select idaccion from acciones where idtarea ='".$idtarea."' and idusuario = '".$usuario."'";
   $consulta="select estrella from subtareas where idsubtarea ='".$idtarea."'";
   $datos=$this->db->query($consulta)->result();
   $respuesta = "1";
   /*if(!$datos)
   {
     $respuesta = 1;
   }
   else
   {*/
     if($datos[0]->estrella == '1')
     {
       $respuesta = 2;
     }
     if($datos[0]->estrella == '0')
     {
       $respuesta = 3;
     }
  // }
     //return $respuesta; //$datos[0]->idaccion;
     return $respuesta; 
  }
  /****************************************************** */
  function devuelveEstrellas($usuario)
  {
    $consulta="select ac.idtarea,ta.nombre from acciones ac,tareas ta
    where ac.idtarea=ta.idtarea and idaccion =1 and idusuario ='".$usuario."'";
    $datos=$this->db->query($consulta)->result();
    return $datos;
  }
   /****************************************************** */
  function devuelveCompletos($usuario)
  {
    $consulta="select p.idtarea,t.nombre   from ptareas p,tareas t
     where t.idtarea= p.idtarea and idpersona ='".$usuario."'";
    $datos=$this->db->query($consulta)->result();
    return $datos;
  }
  /************************************ */
  function devuelveEntregas($usuario)
  {
    /*$consulta="select t.idtarea,t.nombre,t.fechaentrega from tareas t,ptareas pt
    where t.idtarea=pt.idtarea  and t.fechaentrega is not null
    and idpersona ='".$usuario."'";*/
    $consulta="select  t.idtarea,t.nombre,t.fechaentrega from proyectos p, tareas t where
    p.idproyecto = t.idproyecto and
     p.usuario='".$usuario."'   and fechaentrega is not null
     union
     select  t.idtarea,t.nombre,t.fechaentrega from proyectos p, tareas t, ptareas pt where
    p.idproyecto = t.idproyecto and t.idtarea  = pt.idtarea and
     pt.idpersona='".$usuario."'  and fechaentrega is not null";
   // $datos=$this->db->query($consulta)->result();
   // return $datos;
   return $consulta;
  }
  /******************************************** */
  function devuelveAlertas($usuario)
  {
    $consulta="select t.idtarea,t.nombre,t.fechaalerta from tareas t,ptareas pt
    where t.idtarea=pt.idtarea  and t.fechaalerta is not null
    and idpersona ='".$usuario."'";
    $datos=$this->db->query($consulta)->result();
    return $datos;
  }
//--------------------------------------------------------------------------
function crearProyectoAutomatico($array)
{  
/*ARRAY QUE DEBE RECIBIR
        $array['nombre']='nombre de ejemplo'//ES EL NOMBRE QUE SE VA A VISUALIZAR LA TAREA DEL PROYECTO OBLIGATORIO
        $array['tabla']='project_implementation_plan';//SI ESTA RELACIONADO A ALGUNA TABLA NO OBLIGATORIO
        $array['idTabla']=15//SI TIENE UN ID LA TABLA NO OBLIGATORIO
        $array['identificaProyectoAutomatico']='accionesPIP'//OBLIGATORIO;
        $array['usuario']=13//ES EL idPersona SI NO LO TRAE AGARRA EL QUE ESTE LOGUEADO
        $array["tituloProyecto"]=//ES EL TITULO QUE LLEVA EL PROYECTO
        $array['idTablaParaTarea']=//ES EL NOMBRE DE LA TABLA CON LA QUE LA TAREA ESTA RELACIONADO NO ES OBLIGATORIO
        $array['tablaParaTarea']=//ES L ID DE LA TABLA CON LA QUE ESTA RELACIONADO LA TAREA NO ES OBLIGATORIO
 */
   //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($array, TRUE));fclose($fp); 
   if(isset($array['nombre']) and isset($array['identificaProyectoAutomatico']))
   {
    if(!isset($array['usuario'])){$array['usuario']=$this->tank_auth->get_idPersona();}
    $consulta='select * from proyectos  p where p.identificaProyectoAutomatico="'.$array['identificaProyectoAutomatico'].'" and p.usuario='.$array['usuario'];
    $datos=$this->db->query($consulta)->result_array();
   
    if((count($datos))===0)
    {
      $insertProyectos['usuario']=$array['usuario'];
      $insertProyectos['nombre']=isset($array["tituloProyecto"]) ? $array["tituloProyecto"] : 'ACCIONES PARA EL PIP';
      $insertProyectos['identificaProyectoAutomatico']=$array['identificaProyectoAutomatico'];
      if(isset($array['tabla'])){$insertProyectos['tabla']=$array['tabla'];}
      if(isset($array['idTabla'])){$insertProyectos['idTabla']=$array['idTabla'];}

      $this->db->insert('proyectos',$insertProyectos);
      $last=$this->db->insert_id();
    }
    else
    {
     // $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($datos,TRUE));fclose($fp);      
      $last=$datos[0]['idproyecto'];
    }

    $insertaTareas['idProyecto']=$last;
    $insertaTareas['nombre']=$array['nombre'];
    if(isset($array['idTabla'])){$insertaTareas['idNota']=$array['idTabla'];}
    if(isset($array['tablaParaTarea']))
      {
        $insertaTareas['tabla']=$array['tablaParaTarea'];
        if($insertaTareas['tabla']=='tablanoconformidad')
        {
         $consulta="select (count(idtarea)) as total from tareas t where t.tabla='".$insertaTareas['tabla']."' and t.idTabla=".$array['idTablaParaTarea'];
         $total=$this->db->query($consulta)->result()[0]->total;
         if($total>0){return false;}

        }
      }
    if(isset($array['idTablaParaTarea'])){$insertaTareas['idTabla']=$array['idTablaParaTarea'];}
    if(isset($array['fechaentrega'])){$insertaTareas['fechaentrega']=$array['fechaentrega'];}
    $this->db->insert('tareas',$insertaTareas);

   }
}

//-------------------------------------------------------------------------------------------------------
  function getHistoricoAcumulado($sql){ //Creado [Suemy][2024-03-13]
    $data = array();
    $consulta='select t.*,(date_format(t.fechaCreacion,"%d/%m/%Y %h:%m:%S %p")) as tareaFechaCreacion, (if(t.fechaCompletada is null,"",date_format(t.fechaCompletada,"%d/%m/%Y %h:%m:%S %p"))) as tareaCompletada, (if(t.finalizaTiempo is  null,"",date_format(t.finalizaTiempo,"%d/%m/%Y %h:%m:%S %p"))) as tareaFinalizadaTiempo, (if(t.fechaEnProduccion is  null,"",date_format(t.fechaEnProduccion,"%d/%m/%Y %h:%m:%S %p"))) as fechaDeProduccion from tareas t where comision=1 '.$sql;// comision=1
    $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($consulta,TRUE));fclose($fp);
    $query = $this->db->query($consulta)->result();

    foreach ($query as $val) {
      $add['idtarea'] = $val->idtarea;
      $add['idproyecto'] = $val->idproyecto;
      $add['asignados'] = $this->getProjectEmployee($val->idtarea,$val->fechaentrega,$val->fechaCompletada);
      $add['titulo'] = $val->tituloTarea;
      $add['descripcion'] = $val->nombre;
      $add['estatus_terminado'] = $val->terminado;
      $add['estatus_completado'] = $val->completado;
      $add['fecha_completado'] = $val->tareaCompletada;
      $add['fecha_compromiso'] = $val->fechaentrega;
      $add['fecha_comite'] = $val->fechacomite;
      $add['fecha_creacion'] = $val->tareaFechaCreacion;
      $add['fecha_produccion'] = $val->fechaDeProduccion;
      $add['fecha_tarea'] = $val->ftarea;
      $add['fecha_tareaFinalizada'] = $val->tareaFinalizadaTiempo;
      $add['tiempo_completada'] = $this->getTimeElapsed($val->fechaCompletada,date('Y-m-d H:i:s'));
      $add['tiempo_produccion'] = $this->getTimeElapsed($val->fechaEnProduccion,date('Y-m-d H:i:s'));
      $add['duracion_completada'] = $this->getTimeElapsed($val->fechaentrega,$val->fechaCompletada);
      $add['duracion_produccion'] = $this->getTimeElapsed($val->fechaCompletada,$val->fechaEnProduccion);
      $add['duracion_tarea'] = $this->getTimeElapsed($val->fechaCreacion,$val->finalizaTiempo);
      array_push($data, $add);
    }
    return $data;
  }

  function getTaskProject($id) { //Creado [Suemy][2024-03-13]
    $data = array();
    $query = $this->db->query('SELECT * FROM tareas WHERE idtarea = '.$id)->result();
    return $query;
  }

  function getProjectEmployee($id,$dateC,$dateR) { //Creado [Suemy][2024-03-13]
    $data = array();
    $dateCommitment = $dateC;
    $dateEmployee = $dateR;
    $query = $this->db->query('SELECT t.*, (if(t.registro is null,"",date_format(t.registro,"%d/%m/%Y %h:%m:%S %p"))) as fechaAsignado, us.name_complete FROM ptareas t INNER JOIN users us ON us.idPersona = t.idpersona WHERE t.idtarea = '.$id)->result();
    if (empty($dateC)) {
      $search = array("data" => "fechaentrega", "table" => "tareas", "field" => "idtarea = ".$id);
      $dateCommitment = $this->getDataTable($search)->fechaentrega;
    }
    if (empty($dateR)) {
      $search = array("data" => "fechaCompletada", "table" => "tareas", "field" => "idtarea = ".$id);
      $dateEmployee = $this->getDataTable($search)->fechaCompletada;
    }
    foreach ($query as $val) {
      $add['id'] = $val->idptarea;
      $add['idtarea'] = $val->idtarea;
      $add['idPersona'] = $val->idpersona;
      $add['nombres'] = $val->nombre;
      $add['nombre_completo'] = $val->name_complete;
      $add['correo'] = $val->correo;
      $add['completado'] = $val->completado;
      $add['alerta'] = $val->alerta;
      $add['registro'] = $val->fechaAsignado;
      $add['fechaCompromiso'] = $dateCommitment;
      $add['duracion_compromiso'] = $this->getTimeElapsed($val->registro,$dateCommitment);
      $add['duracion_responsable'] = $this->getTimeElapsed($val->registro,$dateEmployee);
      array_push($data, $add);
    }
    return $data;
  }

  function getTimeElapsed($dateI,$dateF) { //Creado [Suemy][2024-03-13]
    $time = "";
    if (!empty($dateI) && !empty($dateF)) {
      $dateA = date('Y-m-d H:i:s',strtotime($dateI));
      $dateB = date('Y-m-d H:i:s',strtotime($dateF));
      $hoursD = (strtotime($dateB) - strtotime($dateA)) / 3600; //36400
      $seconds = (strtotime($dateB) - strtotime($dateA));
      //Obtener Días y Años
      $days = number_format(($hoursD / 24),2);
      $days = explode('.',$days);
      $year = number_format(($days[0] / 365),4);
      $year = explode('.', $year);
      if ($year[0] > 0) {
          $time .= $year[0].' año';
          $time .= $this->addLetter($year[0]);
          $time .= ', ';
      }
      if ($days[0] > 0) {
          $dd = ($year[1] * 365) / 10000;
          $time .= round($dd).' día';
          $time .= $this->addLetter($days[0]);
          $time .= ' con ';
      }
      //Obtener Horas
      $hours = ($days[1] * 24) / 100;
      $hours = explode('.', $hours);
      if ($hours[0] > 0) {
          $time .= $hours[0]. ' hora';
          $time .= $this->addLetter($hours[0]);
          $time .= ' y ';
      }
      //Obtener Minutos
      $hour = number_format($hoursD,2);
      $hour = explode('.',$hour);
      $minutes = (60 * $hour[1]) / 100;
      $second = $minutes;
      $minutes = number_format($minutes,0);
      //$time .= $hour[0].' hora';
      //if ($hour[0] == 0 || $hour[0] > 1) { $time .= "s"; }
      $time .= $minutes.' minuto';
      $time .= $this->addLetter($minutes);
      if ($year[0] == 0 && $days[0] == 0 && $hours[0] == 0 && $second == 0) {
          /*$second = number_format($second,2);
          $second = explode('.', $second);
          $second = ($second[1] * 60) / 100;
          $second = round($second);
          $time .= ' con '.$second.' segundos';*/
          $time = "Hace unos momentos";
      }
    }
    return $time;
  }

  function addLetter($text) { //Creado [Suemy][2024-03-13]
    $data = "";
    if ($text == 0 || $text > 1) { $data .= 's'; }
    return $data;
  }

  function getDataTable($info) { //Creado [Suemy][2024-03-13]
    $query = $this->db->query('SELECT '.$info['data'].' FROM '.$info['table'].' WHERE '.$info['field'])->row();
    return $query;
  }

  function insertTrackingTask($data) { //Creado [Suemy][2024-03-13]
    $query = $this->db->insert('tareas_seguimiento',$data);
    return $this->db->insert_id();
  }

  function updateTrackingTask($data,$id) { //Creado [Suemy][2024-03-13]
    $this->db->where('idtarea',$id);
    $query = $this->db->update('tareas',$data);
    return $query;
  }

  function getTrackingStatus($id) { //Creado [Suemy][2024-03-13]
    $query = $this->db->query('SELECT * FROM tareas_seguimiento WHERE idTarea = '.$id.' ORDER BY id DESC')->result();
    return $query;
  }

  function getTrackingPause($id) { //Creado [Suemy][2024-03-13]
    $query = $this->db->query('SELECT t.idtarea, t.pausado, t.fechaPausa, t.fechaContinua, s.* FROM tareas t INNER JOIN tareas_seguimiento s ON s.idTarea = t.idtarea WHERE s.accion = "Pausar" AND t.idtarea = '.$id.' ORDER BY s.id DESC LIMIT 1')->result();
    return $query;
  }

  function getTaskInfoComplete($sql = NULL) { //Creado [Suemy][2024-05-10]
    $data = array();
    $query = $this->db->query('SELECT * FROM tareas '.$sql)->result();
    if (!empty($query)) {
      foreach($query as $val){
        //Responsables
        $responsible = $this->db->query('SELECT correo FROM ptareas WHERE idtarea = '.$val->idtarea)->result();
        $ptask = array();
        if (!empty($responsible)) {
          foreach($responsible as $row){
            array_push($ptask, $row);
          }
        }
        //SubTareas
        $sTask = $this->db->query('SELECT * FROM subtareas WHERE idtarea = '.$val->idtarea)->result();
        $subtask = array();
        if (!empty($sTask)) {
          foreach($sTask as $row){
            //Responsables SubTareas
            $responsibleSubTask = $this->db->query('SELECT * FROM psubtareas WHERE idtarea = '.$row->idtarea)->result();
            $responsablesubTarea ="";
            $psubtask = array();
            if (!empty($responsibleSubTask)) {
              foreach($responsibleSubTask as $value){
                array_push($psubtask, $value);
              }
            }
            $insert['idsubtarea'] = $row->idsubtarea;
            $insert['idtarea'] = $row->idtarea;
            $insert['idproyecto'] = $row->idproyecto;
            $insert['nombre'] = $row->nombre;
            $insert['terminado'] = $row->terminado;
            $insert['completado'] = $row->completado;
            $insert['finalizacion'] = $row->finalizaTiempo;
            $insert['psubtareas'] = $psubtask;
            array_push($subtask, $insert);
          }
        }
        $status = 0;
        $status_txt = "En Proceso";
        if ($val->pausado == 1) { $status = 1; $status_txt = "Pausado"; }
        if ($val->completado == 1) { $status = 2; $status_txt = "Completado"; }
        if ($val->estaProduccion == 1) { $status = 3; $status_txt = "En Produccion"; }
        $add['idtarea'] = $val->idtarea;
        $add['titulo'] = $val->tituloTarea != "0" ? $val->tituloTarea : "Ninguno";
        $add['estatus'] = $status;
        $add['estatus_txt'] = $status_txt;
        $add['pausado'] = $val->pausado;
        $add['completado'] = $val->completado;
        $add['terminado'] = $val->comision;
        $add['produccion'] = $val->estaProduccion;
        $add['fechaCreacion'] = $val->fechaCreacion;
        $add['fechaEntrega'] = $val->fechaentrega;
        $add['fechaPausa'] = $val->fechaPausa;
        $add['fechaContinua'] = $val->fechaContinua;
        $add['fechaCompletada'] = $val->fechaContinua;
        $add['fechaEnProduccion'] = $val->fechaEnProduccion;
        $add['fechaEnHistorico'] = $val->fechacomite;
        $add['nombre'] = $val->nombre;
        $add['responsables'] = $ptask;
        $add['subtareas'] = $subtask;
        array_push($data, $add);
      }  
    }
    return $data;
  }

  const ID_ESTATUS_MODULO_MEJORA = 4; // Valor tomado de la tabla <tablanoconformidadstatus>

  /**
   * Devuelve la lista de evaluadores asignados a una tarea (nombre, correo y foto)
   */
  public function devolverEvaluadoresTarea($idTarea){
    $consulta = 'select distinct te.nombre_persona, te.email_persona, ui.fotoUser from tareas_evaluadores te left join user_miInfo ui on ui.idPersona = te.id_persona where id_tarea = ' . $idTarea;
    $evaluadores = $this->db->query($consulta)->result();
    return $evaluadores;
  }

  /**
   * Creamos la nueva tarea en el modulo de Seguimiento con los datos enviados
   */
  public function crearTareaDesdeIncidencia($datos)
  {
    // Verificamos que la incidencia no este vinculada ya a una tarea de seguimiento
    $aviso = "";
    $this->db->where('idTabla', $datos[ 'idTabla' ]); //id de la incidencia
    //$this->db->where('idproyecto', $datos['idproyecto']);
    $this->db->limit(1);
    $query = $this->db->get('tareas');
    if ($query->num_rows() > 0) {
      // Devolvemos un error personalizado si el registro ya existe
      //return array('success' => false, 'message' => 'La incidencia ya se encuentra vinculada a una tarea en el sistema.');
      $aviso = "\n\nAviso: La incidencia ya se encuentra vinculada a una tarea en el sistema.";
    }

    // Si la incidencia no ha generado ninguna tarea antes, procedemos a crear la tarea
    $result = $this->db->insert('tareas', $datos);
    if ($result) {
      // Ahora actualizamos el estatus de la incidencia en la tabla <tablanoconformidad>
      $id_tarea = $this->db->insert_id();

      $this->db->where('idTablaNoConformidad', $datos[ 'idTabla' ]);
      $updateResult = $this->db->update('tablanoconformidad', array('aFavor' => self::ID_ESTATUS_MODULO_MEJORA));

      // Tambien agregamos a la persona inconforme como evaluador de la tarea generada
      $this->asignarEvaluadorTarea($datos, $id_tarea);

      return array('success' => true, 'message' => ''.$aviso, 'id_tarea' => $id_tarea);
    } else {
      $error = $this->db->error();
      return array('success' => false, 'message' => isset($error[ 'message' ]) ? $error[ 'message' ] : 'Error desconocido');
    }
  }

  /**
   * Asignamos a la persona inconforme como evaluador de la nueva tarea
   */
  private function asignarEvaluadorTarea($datos, $id_tarea)
  {
    // Obtenemos los datos de la persona que levanto la incidencia
    $this->db->select('t.idPersonaInconforme, p.nombres, p.emailUsers');
    $this->db->from('tablanoconformidad t');
    $this->db->join('persona p', 'p.idPersona = t.idPersonaInconforme');
    $this->db->where('t.idTablaNoConformidad', $datos[ 'idTabla' ]);

    $query = $this->db->get();

    if ($query->num_rows() > 0) {
      $result = $query->row_array();
      $id_persona = $result[ 'idPersonaInconforme' ];
      $nombres = $result[ 'nombres' ];
      $emailUsers = $result[ 'emailUsers' ];

      // Asignamos a la persona como evaluador de la tarea
      $datos_evaluador = array(
        'id_proyecto' => $datos[ 'idproyecto' ],
        'id_tarea' => $id_tarea,
        'tipo_evaluador' => 'OPERATIVO',
        'id_persona' => $id_persona,
        'nombre_persona' => $nombres,
        'email_persona' => $emailUsers,
        'es_invitado' => 0,
        'id_pproyectos' => 0,
      );

      $this->db->insert('tareas_evaluadores', $datos_evaluador);
    }
  }

  /**
   * Agregamos un nuevo comentario a una tarea en el modulo de Seguimiento utilizando los datos proporcionados
   */
  public function agregarComentarioTareaSeguimiento($datos)
  {
    $this->db->insert('tareascomentario', $datos);
  }

}
