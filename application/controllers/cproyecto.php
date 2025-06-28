<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class cproyecto extends CI_Controller
{

     var $datos="";
     function __construct()
      {
        parent::__construct();     
        $this->CI =& get_instance();
        //$this->load->model('Mcliente');
        $this->load->library("libreriav3"); //Agregado [Suemy][2024-05-10]
         $this->load->model('Modelo_usuario'); 
         $this->load->model('PersonaModelo');
         $this->load->model('modeloproyecto');
         $this->load->model('manejodocumento_modelo');
         $this->load->model('notificacionmodel');
         $this->load->model('superestrella_model'); //Agregado [Suemy][2024-05-10]
      }
    function index()
    {
   if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');} 
      //$this->load->model('Mcliente'); 
      $this->load->model('Modelo_usuario'); 
      $data['clasificacionUsuarios']=$this->PersonaModelo->clasificacionUsuariosParaEnvios(1);
       $usuario =  $this->tank_auth->get_idPersona();
      $data['proyectos']= $this->Modelo_usuario->devProyectos($usuario);
      $data['devuelveEstrellas']=$this->modeloproyecto->devuelveEstrellas($usuario);
      $data['devuelveCompletos']=$this->modeloproyecto->devuelveCompletos($usuario);
      $data['devuelveEntregas']=$this->modeloproyecto->devuelveEntregas($usuario);
      $data['devuelveAlertas']=$this->modeloproyecto->devuelveAlertas($usuario);
      $data['devuelveTareas']=$this->modeloproyecto->devuelveTareas(0);
      $data['devuelvesubTareas']=$this->modeloproyecto->devuelvesubTareas(0);
      $data['devuelveComites']=$this->modeloproyecto->devuelveComites($usuario);
     // $data['devuelveComites']=$this->modeloproyecto->devuelveComites();
     $data['emailUsuario']= $this->tank_auth->get_usermail();
     // $data['devuelvesubTareas']=$this->modeloproyecto->devuelvesubTareas(0);
        $data['id_proyecto'] =0;
        $data['usuario'] = $this->tank_auth->get_idPersona();
      $this->load->view('proyecto/proyecto.php',$data);
    }
//*+++++++++++++++++++++++++++++++++++++++++++/
function tareasAsignadas()
{
  $data['clasificacionUsuarios']=$this->PersonaModelo->clasificacionUsuariosParaEnvios(1);
  $usuario =  $this->tank_auth->get_idPersona();
 
     
 $data['proyectos']= $this->Modelo_usuario->devProyectos($usuario);
 $data['devuelveEstrellas']=$this->modeloproyecto->devuelveEstrellas($usuario);
 $data['devuelveCompletos']=$this->modeloproyecto->devuelveCompletos($usuario);
 $data['devuelveEntregas']=$this->modeloproyecto->devuelveEntregas($usuario);
 $data['devuelveAlertas']=$this->modeloproyecto->devuelveAlertas($usuario);
 //$data['devuelveTareas']=$this->modeloproyecto->devuelveTareas(0);
 $data['devuelveTareas']=$this->modeloproyecto->devuelveTareasUsuario(0);
 $data['devuelvesubTareas']=$this->modeloproyecto->devuelvesubTareas(0);
 $data['devuelveComites']=$this->modeloproyecto->devuelveComites($usuario);
$data['emailUsuario']= $this->tank_auth->get_usermail();
// $data['devuelvesubTareas']=$this->modeloproyecto->devuelvesubTareas(0);
   $data['id_proyecto'] =0;
   $data['usuario'] = $this->tank_auth->get_idPersona();
 $this->load->view('proyecto/proyecto.php',$data);

} 
//*+++++++++++++++++++++++++++++++++++++++++++/
function grabaposFecha()
{
  $fecha = $_POST['posfecha'];
  $idposfecha = $_POST['idposfecha']; 
  $idproyecto = $_POST['idproyecto'];
  $idusuario = $this->tank_auth->get_idPersona();
  $correo = $this->tank_auth->get_usermail();
  $fechaproyecto = $this->modeloproyecto->devfechaProyecto($idposfecha,$fecha,'1');
  //Actualizamos la nueva fecha en el proyecto
  //$this->modeloproyecto->ActfechaProyecto(,);
  $reg =$this->modeloproyecto->devuelveusuproy($idposfecha);
  $sqlenviaCorreo ="";
  //$usuario = $_GET['usuario'];
 if(isset($reg))
 {
  foreach($reg as $row)
  {
  // $sqlenviaCorreo = $row->emailUsers; 
     $sqlenviaCorreo = "Insert Ignore Into
     `envio_correos`
        ( `fechaCreacion`, 
        `desde`,
        `para`, 
        `asunto`,
        `mensaje`, 
        `status`
         )
        Values
        (
         current_timestamp,
         'Avisos de GAP<avisosgap@aserorescapital.com>',
          '".$row->emailUsers."',  
          'Proyecto: ".$row->nombre."',
          'El Proyecto: ".$row->nombre." <br> Se Ha Pospuesto Fecha del Proyecto a la fecha ".$fecha."<br> Resposable:".$row->nombres."',
          '0'
        );
       ";
        $this->db->query($sqlenviaCorreo);
    }
  }
  //echo json_encode($sqlenviaCorreo);
  echo json_encode('1');
}
//*+++++++++++++++++++++++++++++++++++++++++++/
function retornatareasCompletas()
{
  $usuario =  $this->tank_auth->get_idPersona();
  // $consulta = "Select * from "
}
/********************************************* */
/* function muestraProyectos()
  {
    $idproyecto = $_GET['idproyecto']; 
    $data['id_proyecto'] = $_GET['idproyecto']; 
    //$data['empresa']= $this->Modelo_usuario->devempresa();
    $usuario =  $this->tank_auth->get_idPersona();
    $data['proyectos']= $this->Modelo_usuario->devProyectos($usuario);
    $data['proyectosActual']= $this->Modelo_usuario->devProyectoActual($idproyecto); 
    $data['clasificacionUsuarios']=$this->PersonaModelo->clasificacionUsuariosParaEnvios(1);
    $data['devuelveTareas']=$this->modeloproyecto->devuelveTareas($idproyecto);
    $data['devuelvesubTareas']=$this->modeloproyecto->devuelvesubTareas($idproyecto);
    $data['devuelveEstrellas']=$this->modeloproyecto->devuelveEstrellas($usuario);
    $data['devuelveCompletos']=$this->modeloproyecto->devuelveCompletos($usuario);
    $data['devuelveEntregas']=$this->modeloproyecto->devuelveEntregas($usuario);
    $data['devuelveAlertas']=$this->modeloproyecto->devuelveAlertas($usuario);
    $data['devuelveComites']=$this->modeloproyecto->devuelveComites();
    $data['emailUsuario']= $this->tank_auth->get_usermail();
    $data['idPersona'] =  $this->tank_auth->get_idPersona();
    //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp,print_r($data['proyectosActual']->result(),TRUE));fclose($fp); 
     $this->load->view('proyecto/proyecto.php',$data);
  }*/
  /********************************************* */
 function muestraProyectos()
 {
   $idproyecto = $_GET['idproyecto']; 
   $data['id_proyecto'] =  $idproyecto;//$_GET['idproyecto']; 
   //$data['empresa']= $this->Modelo_usuario->devempresa();
   $usuario =  $this->tank_auth->get_idPersona();
   $data['proyectos']= $this->Modelo_usuario->devProyectos($usuario);
   $data['proyectosActual']= $this->Modelo_usuario->devProyectoActual($idproyecto); 
   $data['clasificacionUsuarios']=$this->PersonaModelo->clasificacionUsuariosParaEnvios(1);
   $data['devuelveTareas']=$this->modeloproyecto->devuelveTareas($idproyecto);
   $data['devuelvesubTareas']=$this->modeloproyecto->devuelvesubTareas($idproyecto);
   $data['devuelveEstrellas']=$this->modeloproyecto->devuelveEstrellas($usuario);
   $data['devuelveCompletos']=$this->modeloproyecto->devuelveCompletos($usuario);
   $data['devuelveEntregas']=$this->modeloproyecto->devuelveEntregas($usuario);
   $data['devuelveAlertas']=$this->modeloproyecto->devuelveAlertas($usuario);
   $data['emailUsuario']= $this->tank_auth->get_usermail();
   $data['idPersona'] =  $this->tank_auth->get_idPersona();
   $data['devuelveComites']=$this->modeloproyecto->devuelveComites($usuario);
   $data['devuelveCom']=$this->modeloproyecto->devuelveCom();
   $data['usuario'] = $this->tank_auth->get_idPersona();
   //$data['devuelveComites']=$this->modeloproyecto->devuelveComites();
   
   if(isset($_GET['idNotificacion']))
   {
     
     $consulta['id']=$_GET['idNotificacion'];
     $notificacion=$this->notificacionmodel->notificacion($consulta);
     $data['idTabla']=$_GET['idNotificacion'];
     if($notificacion->email==$this->tank_auth->get_usermail())
     {
      $actualizar['id']=$_GET['idNotificacion'];
      $actualizar['check']=2;
      $this->notificacionmodel->actualizarNotificacion($actualizar);
     }
   }
    $_POST['return']=1;
    $_POST['idproyecto']=$idproyecto;
    $data['invitados']=$this->devuelveInvitados();
 

    $this->load->view('proyecto/proyecto.php',$data);
 }
  /************************************** */
  function muestraProyectosExternos2()
  {
    $idproyecto = $_GET['idproyecto']; 
    $data['id_proyecto'] = $_GET['idproyecto']; 

    //$data['empresa']= $this->Modelo_usuario->devempresa();
    $usuario = $_GET['usuario'];// $this->tank_auth->get_idPersona();
    $data['usuario'] = $usuario ;
    $data['devuelveTareas']=$this->modeloproyecto->devuelveTareas($idproyecto);
    $data['proyectos']= $this->Modelo_usuario->devProyectosExt($usuario);
    $data['proyectosActual']= $this->Modelo_usuario->devProyectoActual($idproyecto); 
    $data['clasificacionUsuarios']=$this->PersonaModelo->clasificacionUsuariosParaEnvios(1);
    $data['devuelveTareas']=$this->modeloproyecto->devuelveTareas($idproyecto);
    
    $data['devuelveEstrellas']=$this->modeloproyecto->devuelveEstrellas($usuario);
    $data['devuelveCompletos']=$this->modeloproyecto->devuelveCompletos($usuario);
    $data['devuelveEntregas']=$this->modeloproyecto->devuelveEntregas($usuario);
    $data['devuelveAlertas']=$this->modeloproyecto->devuelveAlertas($usuario);
    $data['devuelvesubTareas']=$this->modeloproyecto->devuelvesubTareas($idproyecto);
     $this->load->view('proyecto/vproyecto.php',$data);
  }
  //*+++++++++++++++++++++++++++++++++++++++++++/
  function muestraposFecha()
  {
    $tipo = $_POST['tipo'];
    $ano = $_POST['ano']; 
    $mes = $_POST['mes']; 
    $dia = $_POST['dia']; 
    $usuario =  $this->tank_auth->get_idPersona(); 
    if($tipo ==1)
    {
      $resultado = $this->modeloproyecto->devuelvesubfechas($usuario,$ano,$mes,$dia,$tipo );   
      //echo json_encode($usuario);
    }
    if($tipo ==2)
    {
      $resultado = $this->modeloproyecto->devuelvesubfechas($usuario,$ano,$mes,$dia,$tipo );   
      //echo json_encode($usuario);
    }
    if($tipo ==3)
    {
      $resultado = $this->modeloproyecto->devuelvesubfechas($usuario,$ano,$mes,$dia,$tipo );   
      //echo json_encode($usuario);
    }
    // echo json_encode($resultado);
     echo json_encode($resultado);

  }
  //*+++++++++++++++++++++++++++++++++++++++++++/

function muestraProyectosExternos()
  {
    
     $this->load->view('proyecto/vpasword.php');
  }
  /******************************* */
 function devuelveEstrellas()
 {
  $usuario =  $this->tank_auth->get_idPersona(); 
  $consulta="select  t.idtarea,t.nombre,concat('Tarea--', p.nombre) as tarea from proyectos p, tareas t where
  p.idproyecto = t.idproyecto and
   p.usuario='".$usuario."'   and estrella =1
   union
   select  t.idtarea,t.nombre,concat('Tarea--', p.nombre)as tarea from proyectos p, tareas t, ptareas pt where
  p.idproyecto = t.idproyecto and t.idtarea  = pt.idtarea and
   pt.idpersona='".$usuario."'  and estrella =1
   UNION
   select  t.idtarea,t.nombre,concat('Tarea--', p.nombre)as tarea from proyectos p, pproyectos pp, tareas t where
   pp.idproyecto = p.idproyecto and
   pp.idproyecto = t.idproyecto and
    pp.idpersona='".$usuario."'  and estrella =1
    union
    select  t.idtarea,t.nombre,concat('SubTarea--', p.nombre) as tarea from proyectos p, subtareas t where
    p.idproyecto = t.idproyecto and
     p.usuario='".$usuario."'    and t.estrella =1  
     union
     select  t.idtarea,t.nombre,concat('SubTarea--', p.nombre) as tarea  from proyectos p, subtareas t, psubtareas pt where
    p.idproyecto = t.idproyecto and t.idtarea  = pt.idtarea and
     pt.idpersona='".$usuario."'  and t.estrella =1    
   
     union
     select  t.idtarea,t.nombre,concat('SubTarea--', p.nombre) as tarea  from proyectos p, pproyectos pp, subtareas t where
     pp.idproyecto = p.idproyecto and
     pp.idproyecto = t.idproyecto and
      pp.idpersona='".$usuario."'  and t.estrella =1"    ;
   
   $estrella=$this->db->query($consulta)->result();
  //$fechaEntrega =  $this->Modelo_usuario->devuelveEntregas($usuario);
  echo json_encode($estrella);
  //echo json_encode('hola');

 }
  /******************************* */
  function devuelveTareascompletas()
  {
   $usuario =  $this->tank_auth->get_idPersona(); 
   $consulta="select  t.idtarea,t.nombre,concat('Tarea--', p.nombre) as tarea  from proyectos p, tareas t where
   p.idproyecto = t.idproyecto and
    p.usuario='".$usuario."'   and t.completado =1
    union
    select  t.idtarea,t.nombre,concat('Tarea--', p.nombre) as tarea  from proyectos p, tareas t, ptareas pt where
   p.idproyecto = t.idproyecto and t.idtarea  = pt.idtarea and
    pt.idpersona='".$usuario."'  and t.completado =1
    UNION
    select  t.idtarea,t.nombre,concat('Tarea--', p.nombre)as tarea  from proyectos p, pproyectos pp, tareas t where
    pp.idproyecto = p.idproyecto and
    pp.idproyecto = t.idproyecto and
     pp.idpersona='".$usuario."'  and t.completado =1
     union
     select  t.idtarea,t.nombre,concat('SubTarea--', p.nombre) as tarea from proyectos p, subtareas t where
     p.idproyecto = t.idproyecto and
      p.usuario='".$usuario."'   and t.completado =1  
      union
      select  t.idtarea,t.nombre,concat('SubTarea--', p.nombre) as tarea from proyectos p, subtareas t, psubtareas pt where
     p.idproyecto = t.idproyecto and t.idtarea  = pt.idtarea and
      pt.idpersona='".$usuario."'  and t.completado =1  
       union
      select  t.idtarea,t.nombre,concat('SubTarea--', p.nombre) as tarea from proyectos p, pproyectos pp, subtareas t where
      pp.idproyecto = p.idproyecto and
      pp.idproyecto = t.idproyecto and
       pp.idpersona='".$usuario."' and t.completado =1  ";
    
    $estrella=$this->db->query($consulta)->result();
   //$fechaEntrega =  $this->Modelo_usuario->devuelveEntregas($usuario);
   echo json_encode($estrella);  
   //echo json_encode($consulta);  
  }
  /****************************** */
  function devuelveFechaEntrega()
  {
    //echo json_encode("LLego");  
    // $this->load->view('proyecto/vpasword.php');
    //$this->load->model('modeloproyecto');
    $usuario =  $this->tank_auth->get_idPersona();
    $consulta="select  t.idtarea,t.nombre,concat(t.fechaentrega,'--Tarea--',p.nombre) as tarea  from proyectos p, tareas t where
    p.idproyecto = t.idproyecto and
     p.usuario='".$usuario."'   and fechaentrega is not null
     union
     select  t.idtarea,t.nombre,concat(t.fechaentrega,'--Tarea--',p.nombre) as tarea from proyectos p, tareas t, ptareas pt where
    p.idproyecto = t.idproyecto and t.idtarea  = pt.idtarea and
     pt.idpersona='".$usuario."'  and fechaentrega is not null
     union 
     select  t.idtarea,t.nombre,concat(t.fechaentrega,'--Tarea--',p.nombre) as tarea from proyectos p, pproyectos pp, tareas t where
    pp.idproyecto = p.idproyecto and
    pp.idproyecto = t.idproyecto and
     pp.idpersona='6'  and fechaentrega is not null
     union
     select  t.idtarea,t.nombre,concat(t.fechaentrega,'--SubTarea--',p.nombre)as tarea from proyectos p, subtareas t where
     p.idproyecto = t.idproyecto and
      p.usuario='6'   and  fechaentrega is not null
      union
      select  t.idtarea,t.nombre,concat(t.fechaentrega,'--SubTarea--',p.nombre)as tarea from proyectos p, subtareas t, psubtareas pt where
   p.idproyecto = t.idproyecto and t.idtarea  = pt.idtarea and
    pt.idpersona='6'  and fechaentrega is not null
    
    union
    select  t.idtarea,t.nombre,concat(t.fechaentrega,'--SubTarea--',p.nombre)as tarea from proyectos p, pproyectos pp, subtareas t where
    pp.idproyecto = p.idproyecto and
    pp.idproyecto = t.idproyecto and
     pp.idpersona='6' and fechaentrega is not null"  ;
     $fechaEntrega=$this->db->query($consulta)->result();
    //$fechaEntrega =  $this->Modelo_usuario->devuelveEntregas($usuario);
    echo json_encode($fechaEntrega);  
   //echo json_encode($consulta);  
  }

  //*+++++++++++++++++++++++++++++++++++++++++++/
  function verificaUsuario()
  {
   $idusuario = $_POST['idusuario'];
   $pasword = $_POST['idpassword'];
   $sqlInsert_Referencia = "select * from pproyectos where correo ='".$idusuario."' and contrasena ='".$pasword."'";
   $datos=$this->db->query($sqlInsert_Referencia)->result();  
   $respuesta = "";
   if($datos)
   {
       $this->load->model('Modelo_usuario'); 
      $data['clasificacionUsuarios']=$this->PersonaModelo->clasificacionUsuariosParaEnvios(1);
      $data['usuario'] = $idusuario ;// $this->tank_auth->get_idPersona();
      $usuario  = $idusuario ;
      $data['proyectos']= $this->Modelo_usuario->devProyectosExt($usuario);
      $data['id_proyecto'] =0;
      $data['devuelveTareas']=$this->modeloproyecto->devuelveTareasExt(0);
      $this->load->view('proyecto/vproyecto.php',$data);
   }
   else
   {
     $this->load->view('proyecto/vpasword.php');
   }
   
   // return $respuesta; 
  
    //return($data);
    //echo json_encode($respuesta); 
   //echo json_encode($_POST);
   //echo json_encode($sqlInsert_Referencia);  
  }
//-----------------------------------------------------------
function muestraPrueba()
{
   $this->load->view('prueba/prueba.php');
}
//-----------------------------------------------------------
  function retornaFechaTarea()
  {
    $idtarea = $_POST['idtarea'];
    $sqlInsert_Referencia = "select fechaentrega from tareas   where idtarea = '".$idtarea."'";
    $datos=$this->db->query($sqlInsert_Referencia)->result();  
    echo json_encode($datos[0]->fechaentrega); 
   // echo json_encode($sqlInsert_Referencia); 
  }
//-----------------------------------------------------------
   function retornasubFechaTarea()
   {
     $idtarea = $_POST['idtarea'];
     $sqlInsert_Referencia = "select fechaentrega from subtareas   where idsubtarea = '".$idtarea."'";
     $datos=$this->db->query($sqlInsert_Referencia)->result();  
     echo json_encode($datos[0]->fechaentrega); 
    // echo json_encode($sqlInsert_Referencia); 
   }
//-----------------------------------------------------------
    function retornasubFechaAlerta()
    {
      $idtarea = $_POST['idtarea'];
      $sqlInsert_Referencia = "select fechaalerta from subtareas   where idsubtarea = '".$idtarea."'";
      $datos=$this->db->query($sqlInsert_Referencia)->result();  
      echo json_encode($datos[0]->fechaalerta); 
    }    
//-----------------------------------------------------------
     function retornaFechaAta()
     {
       $idtarea = $_POST['idtarea'];
       $sqlInsert_Referencia = "select fechaalerta, tipoalerta from tareas   where idtarea = '".$idtarea."'";
       $datos=$this->db->query($sqlInsert_Referencia)->result();  
       echo json_encode($datos[0]); 
     }  
//-----------------------------------------------------------
    function retornaFechaAlerta()
    {
     /* $idtarea = $_POST['idtarea'];
      //$sqlInsert_Referencia = "select fechaalerta from tareas   where idtarea = '".$idtarea."'";*/
      $idusuario =  $this->tank_auth->get_idPersona();
      $sqlInsert_Referencia = "select  t.idtarea,t.nombre,concat(t.fechaalerta,'--Tarea--',p.nombre) as tarea  from proyectos p, tareas t where
           p.idproyecto = t.idproyecto and
     p.usuario='".$idusuario."'   and t.alerta =1
     union 
     select  t.idtarea,t.nombre,concat(t.fechaalerta,'--Tarea--',p.nombre) as tarea from proyectos p, tareas t, ptareas pt where
     p.idproyecto = t.idproyecto and t.idtarea  = pt.idtarea and
      pt.idpersona='".$idusuario."'   and t.alerta =1
      UNION
     select  t.idtarea,t.nombre,concat(t.fechaalerta,'--Tarea--',p.nombre) as tarea  from proyectos p, pproyectos pp, tareas t where
     pp.idproyecto = p.idproyecto and
     pp.idproyecto = t.idproyecto and
      pp.idpersona='".$idusuario."'   and t.alerta =1
      union
      select  t.idtarea,t.nombre,concat(t.fechaalerta,'--SubTarea--',p.nombre) as tarea  from proyectos p, subtareas t where
      p.idproyecto = t.idproyecto and
       p.usuario='6'   and t.alerta =1  
       union
       select  t.idtarea,t.nombre,concat(t.fechaalerta,'--SubTarea--',p.nombre) as tarea   from proyectos p, subtareas t, psubtareas pt where
      p.idproyecto = t.idproyecto and t.idtarea  = pt.idtarea and
       pt.idpersona='6'  and t.alerta =1  
      
     
       union
       select  t.idtarea,t.nombre,concat(t.fechaalerta,'--SubTarea--',p.nombre) as tarea  from proyectos p, pproyectos pp, subtareas t where
       pp.idproyecto = p.idproyecto and
       pp.idproyecto = t.idproyecto and
        pp.idpersona='6' and t.alerta =1  
      ";
      $datos=$this->db->query($sqlInsert_Referencia)->result();  
      //echo json_encode('hola'); 
     echo json_encode($datos); 
    }
   /*********************************************** */
 function eliminaAlertaTarea() //Modificado* [Suemy][2023-03-13]
 {
   $idtarea = $_POST['idtarea'];
   $idproyecto = $_POST['idproyecto'];
   $sqlInsert_Referencia = "Update tareas set alerta =0  where idtarea = '".$idtarea."'";   
   $this->db->query($sqlInsert_Referencia); 
    $insert = array(
      "idTarea" => $_POST['idtarea'],
      "accion" => "Alerta",
      "comentario" => "Alerta eliminada de Tarea",
      "hecho_por" => $this->tank_auth->get_idPersona(),
      "registro" => date("Y-m-d H:i:s")
    );
    $data['insert'] = $this->modeloproyecto->insertTrackingTask($insert);
   //$personal = $this->mproyectos->devuelveusuario($idproyecto);
   //$informa= $this->mproyectos->actualizaRefrescar($idproyecto,$idusuario ,$personal,$correo);
   $reg =$this->modeloproyecto->devuelveusuproyecto($idtarea);
   $sqlenviaCorreo ="";
     if(isset($reg))
   {
    foreach($reg as $row)
    {
    // $sqlenviaCorreo = $row->emailUsers; 
       $sqlenviaCorreo = "Insert Ignore Into
       `envio_correos`
          ( `fechaCreacion`, 
          `desde`,
          `para`, 
          `asunto`,
          `mensaje`, 
          `status`
           )
          Values
          (
           current_timestamp,
           'Avisos de GAP<avisosgap@aserorescapital.com>',
            '".$row->emailUsers."',  
            'Proyecto: ".$row->nombre."',
            'El Proyecto: ".$row->nombre."<br> Tarea: ".$row->tarea." <br>Se ha Eliminado la Alerta del ".$row->fechaalerta."<br> Resposable:".$row->usuario."<br> Tarea:".$row->tarea." ', 
            '0'
          );
         ";
          $this->db->query($sqlenviaCorreo);
      }
    }

/*


  if(isset($reg))
  {
   foreach($reg as $row)
   {
     
   }
     $mail->Body    = 'El Proyecto '.$row->nombre.' <br> Se ha Eliminado la alerta <br> Responsable :' .$persona.'<br> Tarea: '.$row->tarea;
     $mail->send();
     }
   }*/
   echo json_encode('Listo');      
 }
  
   //-----------------------------------------------------------
   function grabaAlertaTarea() //Modificado* [Suemy][2023-03-13]
   {
     $idtarea = $_POST['idtarea'];
     $fecha = $_POST['fecha'];
     $idproyecto = $_POST['idproyecto'];
     $tipo = $_POST['tipo'];  
     //$sqlInsert_Referencia = "Update tareas set fechaalerta ='".$fecha."' ,alerta =1  where idtarea = '".$idtarea."'";   
     $sqlInsert_Referencia = "Update tareas set fechaalerta ='".$fecha."' ,alerta =1,tipoalerta = ".$tipo."  where idtarea = '".$idtarea."'";   
  
     $this->db->query($sqlInsert_Referencia); 
    $insert = array(
      "idTarea" => $_POST['idtarea'],
      "accion" => "Alerta",
      "comentario" => "Alerta agregada a Tarea",
      "hecho_por" => $this->tank_auth->get_idPersona(),
      "registro" => date("Y-m-d H:i:s")
    );
    $data['insert'] = $this->modeloproyecto->insertTrackingTask($insert);

     $reg =$this->modeloproyecto->devuelveusuproyecto($idtarea);
     $sqlenviaCorreo ="";
    if(isset($reg))
    {
     foreach($reg as $row)
     {
     // $sqlenviaCorreo = $row->emailUsers; 
        $sqlenviaCorreo = "Insert Ignore Into
        `envio_correos`
           ( `fechaCreacion`, 
           `desde`,
           `para`, 
           `asunto`,
           `mensaje`, 
           `status`
            )
           Values
           (
            current_timestamp,
            'Avisos de GAP<avisosgap@aserorescapital.com>',
             '".$row->emailUsers."',  
             'Proyecto: ".$row->nombre."',
             'El Proyecto: ".$row->nombre."<br> Tarea: ".$row->tarea." <br> Ha generado una fecha de Alerta del ".$fecha."<br> Resposable:".$row->usuario."<br> Tarea:".$row->tarea." ', 
             '0'
           );
          ";
           $this->db->query($sqlenviaCorreo);
       }
     }
    // $this->db->query($sqlInsert_Referencia); 
     echo json_encode('Listo');   
    // echo json_encode($reg);  
   }
//-----------------------------------------------------------
 function eliminaAlertasubTarea()
 {
  $idtarea = $_POST['idtarea'];
  $idproyecto = $_POST['idproyecto'];
  $tarea = $_POST['tarea'];
  $fecha = $_POST['fecha'];
  $sqlInsert_Referencia = "Update subtareas set alerta =0  where idsubtarea = '".$idtarea."'";   
  $this->db->query($sqlInsert_Referencia);
  //$personal = $this->mproyectos->devuelveusuario($idproyecto);
  $suarea = $this->modeloproyecto->devuelveusuariosdesubTarea($idtarea);
     $sqlenviaCorreo = "";
     foreach ($suarea->result() as $row){ 
       $sqlenviaCorreo = "Insert Ignore Into
       `envio_correos`
          ( `fechaCreacion`, 
          `desde`,
          `para`, 
          `asunto`,
          `mensaje`, 
          `status`
           )
          Values
          (
           current_timestamp,
           'Avisos de GAP<avisosgap@aserorescapital.com>',
            '".$row->correo."',  
            'Proyecto: ".$tarea."',
            'Se ha Eliminado una alerta para lea fecha  ".$fecha."', 
            '0'
          );
         ";
        // $this->db->query($sqlenviaCorreo);
     }
 // $informa= $this->mproyectos->actualizaRefrescar($idproyecto,$idusuario ,$personal,$correo);
  //$this->enviaCorreos($idtarea,2,""); */
  echo json_encode('listo');  
 }
   
//-----------------------------------------------------------
  function grabasubAlertaTarea()
   {
      //$numreg = $this->modeloproyecto->devuelveEstado($tipo,$id,$idtarea);
     $idtarea = $_POST['idtarea'];
     $fecha = $_POST['fecha'];
     $tipo = $_POST['tipo'];
     $tarea = $_POST['tarea'];
    // $sqlInsert_Referencia = "Update subtareas set fechaalerta ='".$fecha."' ,alerta =1  where idsubtarea = '".$idtarea."'";
     $sqlInsert_Referencia = "Update subtareas set fechaalerta ='".$fecha."' ,alerta =1, tipoalerta = ".$tipo." where idsubtarea = '".$idtarea."'";
   
     $this->db->query($sqlInsert_Referencia); 
     $suarea = $this->modeloproyecto->devuelveusuariosdesubTarea($idtarea);
     $sqlenviaCorreo = "";
     foreach ($suarea->result() as $row){ 
       $sqlenviaCorreo = "Insert Ignore Into
       `envio_correos`
          ( `fechaCreacion`, 
          `desde`,
          `para`, 
          `asunto`,
          `mensaje`, 
          `status`
           )
          Values
          (
           current_timestamp,
           'Avisos de GAP<avisosgap@aserorescapital.com>',
            '".$row->correo."',  
            'Proyecto: ".$tarea."',
            'Se ha Agregado una alerta para lea fecha  ".$fecha."', 
            '0'
          );
         ";
        // $this->db->query($sqlenviaCorreo);
     }
      //echo json_encode('Listo');  
      echo json_encode($sqlenviaCorreo);  
 
   }
//-----------------------------------------------------------
 function eliminasubFecha()
 {
  $idtarea = $_POST['idtarea'];
  $idproyecto = $_POST['idproyecto'];
  $fecha = $_POST['fecha'];
  $subtarea = $_POST['subtarea'];
 /* session_start();
  $idusuario = $_SESSION['idusuario'];*/
  $usuario =  $this->tank_auth->get_idPersona();
  //$correo = $_SESSION['correo'];
  $sqlInsert_Referencia = "Update subtareas set agregafecha =0  where idsubtarea = '".$idtarea."'";   
  $this->db->query($sqlInsert_Referencia);
  //$personal = $this->modeloproyecto->devuelveusuario($idproyecto);
  /*$informa= $this->mproyectos->actualizaRefrescar($idproyecto,$idusuario ,$personal,$correo);
  $this->enviaCorreos($idtarea,5,$fecha); */
  $suarea = $this->modeloproyecto->devuelveusuariosdesubTarea($idtarea);
  $sqlenviaCorreo = "";
  foreach ($suarea->result() as $row){ 
    $sqlenviaCorreo = "Insert Ignore Into
    `envio_correos`
       ( `fechaCreacion`, 
       `desde`,
       `para`, 
       `asunto`,
       `mensaje`, 
       `status`
        )
       Values
       (
        current_timestamp,
        'Avisos de GAP<avisosgap@aserorescapital.com>',
         '".$row->correo."',  
         'Proyecto: ".$subtarea."',
         'Se ha Elinado la fecha de entrega ', 
         '0'
       );
      ";
      $this->db->query($sqlenviaCorreo);
  }
   echo json_encode('listo');  
 
   //echo json_encode($suarea->result()); 
 }
   
//-----------------------------------------------------------
  function grabasubFechaTarea()
  {
    $idtarea = $_POST['idtarea'];
    $fecha = $_POST['fecha'];
    $tipo = $_POST['tipo'];
    $subProy= $_POST['subProy'];
    $responsables= $_POST['responsables'];
    $sqlInsert_Referencia = "select fechaentrega from subtareas where idsubtarea = '".$idtarea."'";
    $fechaAlerta = $this->db->query($sqlInsert_Referencia)->result();
   // $sqlInsert_Referencia = "Update subtareas set fechaentrega ='".$fecha."',agregafecha = 1  where idsubtarea = '".$idtarea."'";
   $sqlInsert_Referencia = "Update subtareas set fechaentrega ='".$fecha."',tipoentrega =".$tipo.",agregafecha = 1 ,fcomienzaentrega = current_date where idsubtarea = '".$idtarea."'"; 
   $this->db->query($sqlInsert_Referencia); 
    $consulta = "INSERT INTO posfecha (idproy, fechaanterior, tipo)VALUES (".$idtarea.",'".$fechaAlerta[0]->fechaentrega."' ,3 )";
    $this->db->query($consulta); 
    //Devuelve Tarea 
    $tarea = $this->modeloproyecto->devuelveusuariosdeTarea($idtarea);
    //echo json_encode($tarea->result());  
    //grabamos en el calendario
    if(isset($tarea ))
    {
    foreach ($tarea->result() as $row){
      $sqlInsert_Referencia = "INSERT INTO`citascalendar`(`emailUsuario`,`titulo`,`fechaInicial`,`fechaFinal`,`emailEstado`,`tabla`) VALUES
                  ('".$row->correo."','Entrega Tarea','".$fecha."','".$fecha."','A','clientes_actualiza')";
     $this->db->query($sqlInsert_Referencia); 
    
    }   
   }
  

    //}  
    $subtarea = $this->modeloproyecto->devuelveusuariosdesubTarea($idtarea);
  
    foreach ($subtarea->result() as $row){ 
      $sqlenviaCorreo = "Insert Ignore Into
      `envio_correos` ( `fechaCreacion`, `desde`,`para`, `asunto`,`mensaje`, `status`) Values(current_timestamp,'Avisos de GAP<avisosgap@aserorescapital.com>','".$row->correo."',  'Proyecto: ".$subProy."','Se ha dado una fecha de entrega al : ".$subProy." <br> El dia ".$fecha."<br> Resposable:".$responsables."', '0');";
        // $this->db->query($sqlenviaCorreo);
    }
    echo json_encode($sqlenviaCorreo);  
   // echo json_encode($_POST);  
      
  }
//-----------------------------------------------------------
  function buscaComision()
  {
    $comite = $_POST['comite'];
    $ano = $_POST['ano'];
    $mes = $_POST['mes'];
    $dia = $_POST['dia'];
    $consulta ="";
    $respuesta="";
    $usuario =  $this->tank_auth->get_idPersona();

    if($comite == "")
    {
      if($ano =="")
      {
      $consulta="select  t.idtarea,t.nombre,concat('Tarea--', p.nombre) as tarea  from proyectos p, tareas t where
      p.idproyecto = t.idproyecto and
      p.usuario='".$usuario."'   and t.comision =1
      union
      select  t.idtarea,t.nombre,concat('Tarea--', p.nombre) as tarea  from proyectos p, tareas t, ptareas pt where
      p.idproyecto = t.idproyecto and t.idtarea  = pt.idtarea and
      pt.idpersona='".$usuario."'  and t.comision =1
      UNION
      select  t.idtarea,t.nombre,concat('Tarea--', p.nombre)as tarea  from proyectos p, pproyectos pp, tareas t where
      pp.idproyecto = p.idproyecto and
      pp.idproyecto = t.idproyecto and
      pp.idpersona='".$usuario."'  and t.comision =1"    ;
       $respuesta = $this->db->query($consulta)->result();
      }
      else{
        if($mes =="")
        {
        $consulta="select  t.idtarea,t.nombre,concat('Tarea--', p.nombre) as tarea  from proyectos p, tareas t where
        p.idproyecto = t.idproyecto and
        p.usuario='".$usuario."'   and t.comision =1 and  year(t.fechacomite) = '".$ano."'
        union
        select  t.idtarea,t.nombre,concat('Tarea--', p.nombre) as tarea  from proyectos p, tareas t, ptareas pt where
        p.idproyecto = t.idproyecto and t.idtarea  = pt.idtarea and
        pt.idpersona='".$usuario."'  and t.comision =1 and  year(t.fechacomite) = '".$ano."'
        UNION
        select  t.idtarea,t.nombre,concat('Tarea--', p.nombre)as tarea  from proyectos p, pproyectos pp, tareas t where
        pp.idproyecto = p.idproyecto and
        pp.idproyecto = t.idproyecto and
        pp.idpersona='".$usuario."'  and t.comision =1 and  year(t.fechacomite) = '".$ano."'"    ;
         $respuesta = $this->db->query($consulta)->result();       
        }
        else{
          if($dia =="")
         {        
          $consulta="select  t.idtarea,t.nombre,concat('Tarea--', p.nombre) as tarea  from proyectos p, tareas t where
        p.idproyecto = t.idproyecto and
        p.usuario='".$usuario."'   and t.comision =1 and  year(t.fechacomite) = '".$ano."' and  month(t.fechacomite) ='".$mes."'
        union
        select  t.idtarea,t.nombre,concat('Tarea--', p.nombre) as tarea  from proyectos p, tareas t, ptareas pt where
        p.idproyecto = t.idproyecto and t.idtarea  = pt.idtarea and
        pt.idpersona='".$usuario."'  and t.comision =1 and  year(t.fechacomite) = '".$ano."' and  month(t.fechacomite) ='".$mes."'
        UNION
        select  t.idtarea,t.nombre,concat('Tarea--', p.nombre)as tarea  from proyectos p, pproyectos pp, tareas t where
        pp.idproyecto = p.idproyecto and
        pp.idproyecto = t.idproyecto and
        pp.idpersona='".$usuario."'  and t.comision =1 and  year(t.fechacomite) = '".$ano."' and  month(t.fechacomite) ='".$mes."'"    ;
         $respuesta = $this->db->query($consulta)->result();       
         }
         else
         {
          $consulta="select  t.idtarea,t.nombre,concat('Tarea--', p.nombre) as tarea  from proyectos p, tareas t where
          p.idproyecto = t.idproyecto and
          p.usuario='".$usuario."'   and t.comision =1 and  year(t.fechacomite) = '".$ano."' and  month(t.fechacomite) ='".$mes."'
           and day(t.fechacomite) = '".$dia."'
          union
          select  t.idtarea,t.nombre,concat('Tarea--', p.nombre) as tarea  from proyectos p, tareas t, ptareas pt where
          p.idproyecto = t.idproyecto and t.idtarea  = pt.idtarea and
          pt.idpersona='".$usuario."'  and t.comision =1 and  year(t.fechacomite) = '".$ano."' and  month(t.fechacomite) ='".$mes."'
           and day(t.fechacomite) = '".$dia."'
          UNION
          select  t.idtarea,t.nombre,concat('Tarea--', p.nombre)as tarea  from proyectos p, pproyectos pp, tareas t where
          pp.idproyecto = p.idproyecto and
          pp.idproyecto = t.idproyecto and
          pp.idpersona='".$usuario."'  and t.comision =1 and  year(t.fechacomite) = '".$ano."' and  month(t.fechacomite) ='".$mes."' and day(t.fechacomite) = '".$dia."'"    ;
           $respuesta = $this->db->query($consulta)->result();     
         }
        } 
      } 
    }
    else{
      if($ano =="")
      {
      $consulta="select  t.idtarea,t.nombre,concat('Tarea--', p.nombre) as tarea  from proyectos p, tareas t where
      p.idproyecto = t.idproyecto and
      p.usuario='".$usuario."'   and t.comision =1 and comite = '".$comite."'
      union
      select  t.idtarea,t.nombre,concat('Tarea--', p.nombre) as tarea  from proyectos p, tareas t, ptareas pt where
     p.idproyecto = t.idproyecto and t.idtarea  = pt.idtarea and
      pt.idpersona='".$usuario."'  and t.comision =1 and comite = '".$comite."'
      UNION
      select  t.idtarea,t.nombre,concat('Tarea--', p.nombre)as tarea  from proyectos p, pproyectos pp, tareas t where
      pp.idproyecto = p.idproyecto and
      pp.idproyecto = t.idproyecto and
       pp.idpersona='".$usuario."'  and t.comision =1 and comite = '".$comite."'"    ;
       $respuesta = $this->db->query($consulta)->result();
      }
      else{
        if($mes =="")
        {
        $consulta="select  t.idtarea,t.nombre,concat('Tarea--', p.nombre) as tarea  from proyectos p, tareas t where
        p.idproyecto = t.idproyecto and
        p.usuario='".$usuario."'   and t.comision =1 and comite = '".$comite."' and  year(t.fechacomite) = '".$ano."'
        union
        select  t.idtarea,t.nombre,concat('Tarea--', p.nombre) as tarea  from proyectos p, tareas t, ptareas pt where
       p.idproyecto = t.idproyecto and t.idtarea  = pt.idtarea and
        pt.idpersona='".$usuario."'  and t.comision =1 and comite = '".$comite."' and  year(t.fechacomite) = '".$ano."'
        UNION
        select  t.idtarea,t.nombre,concat('Tarea--', p.nombre)as tarea  from proyectos p, pproyectos pp, tareas t where
        pp.idproyecto = p.idproyecto and
        pp.idproyecto = t.idproyecto and
         pp.idpersona='".$usuario."'  and t.comision =1 and comite = '".$comite."' and  year(t.fechacomite) = '".$ano."'"    ;
         $respuesta = $this->db->query($consulta)->result();
        }
        else{
          if($dia =="")
          {  
          $consulta="select  t.idtarea,t.nombre,concat('Tarea--', p.nombre) as tarea  from proyectos p, tareas t where
        p.idproyecto = t.idproyecto and
        p.usuario='".$usuario."'   and t.comision =1 and comite = '".$comite."' and  year(t.fechacomite) = '".$ano."' and month(t.fechacomite) ='".$mes."'
        union
        select  t.idtarea,t.nombre,concat('Tarea--', p.nombre) as tarea  from proyectos p, tareas t, ptareas pt where
       p.idproyecto = t.idproyecto and t.idtarea  = pt.idtarea and
        pt.idpersona='".$usuario."'  and t.comision =1 and comite = '".$comite."' and  year(t.fechacomite) = '".$ano."' and month(t.fechacomite) ='".$mes."'
        UNION
        select  t.idtarea,t.nombre,concat('Tarea--', p.nombre)as tarea  from proyectos p, pproyectos pp, tareas t where
        pp.idproyecto = p.idproyecto and
        pp.idproyecto = t.idproyecto and
         pp.idpersona='".$usuario."'  and t.comision =1 and comite = '".$comite."' and  year(t.fechacomite) = '".$ano."' and month(t.fechacomite) ='".$mes."'"    ;
         $respuesta = $this->db->query($consulta)->result();     
          }
          else{
            $consulta="select  t.idtarea,t.nombre,concat('Tarea--', p.nombre) as tarea  from proyectos p, tareas t where
            p.idproyecto = t.idproyecto and
            p.usuario='".$usuario."'   and t.comision =1 and comite = '".$comite."' and  year(t.fechacomite) = '".$ano."' and month(t.fechacomite) ='".$mes."'
            and day(t.fechacomite) = '".$dia."'
            union
            select  t.idtarea,t.nombre,concat('Tarea--', p.nombre) as tarea  from proyectos p, tareas t, ptareas pt where
           p.idproyecto = t.idproyecto and t.idtarea  = pt.idtarea and
            pt.idpersona='".$usuario."'  and t.comision =1 and comite = '".$comite."' and  year(t.fechacomite) = '".$ano."' and month(t.fechacomite) ='".$mes."' 
            and day(t.fechacomite) = '".$dia."'
            UNION
            select  t.idtarea,t.nombre,concat('Tarea--', p.nombre)as tarea  from proyectos p, pproyectos pp, tareas t where
            pp.idproyecto = p.idproyecto and
            pp.idproyecto = t.idproyecto and
             pp.idpersona='".$usuario."'  and t.comision =1 and comite = '".$comite."' and  year(t.fechacomite) = '".$ano."' and month(t.fechacomite) ='".$mes."' and day(t.fechacomite) = '".$dia."'"    ;   
             $respuesta = $this->db->query($consulta)->result();     
          }
        }
      }
    }
    //echo  json_encode( $consulta);
    echo  json_encode($respuesta);
  }
//-----------------------------------------------------------
  function updateComision()
  {
    $idtarea = $_POST['idtarea'];
    $comite = $_POST['comite'];
    $idproyecto = $_POST['idproyecto'];
    $sqlInsert_Referencia = "Update tareas set comision = 1,fechacomite= current_date ,comite = '".$comite."'  where idtarea = '".$idtarea."'";
    $this->db->query($sqlInsert_Referencia); 
    $insert = array(
      "idTarea" => $_POST['idtarea'],
      "accion" => "Historico",
      "comentario" => "Tarea agregada al Historico",
      "hecho_por" => $this->tank_auth->get_idPersona(),
      "registro" => date("Y-m-d H:i:s")
    );
    $data['insert'] = $this->modeloproyecto->insertTrackingTask($insert);
   $reg =$this->modeloproyecto->devuelveusuproyecto($idtarea);
    if(isset($reg))
    {
     foreach($reg as $row)
     {
     // $sqlenviaCorreo = $row->emailUsers; 
        $sqlenviaCorreo = "Insert Ignore Into
        `envio_correos`
           ( `fechaCreacion`, 
           `desde`,
           `para`, 
           `asunto`,
           `mensaje`, 
           `status`
            )
            Values
            (
             current_timestamp,
             'Avisos de GAP<avisosgap@aserorescapital.com>',
              '".$row->emailUsers."',  
              'Proyecto: ".$row->nombre."',
              'El Proyecto: ".$row->nombre."<br> Tarea: ".$row->tarea." <br> Se ha agregado al comite<br>', 
              '0'
            ); 
          ";
           $this->db->query($sqlenviaCorreo);
       }
     }
    //echo json_encode('Listo');  
    echo json_encode($sqlenviaCorreo);
  }
//-----------------------------------------------------------
  function grabaFechaTarea() //Modificado* [Suemy][2023-03-13]
  {
    $idtarea = $_POST['idtarea'];
    $fecha = $_POST['fecha'];
    $sqlInsert_Referencia = "select fechaentrega from tareas where idtarea = '".$idtarea."'";
    $fechaAlerta = $this->db->query($sqlInsert_Referencia)->result();
    $fechaEntrega=explode('-',$fechaAlerta[0]->fechaentrega );

    $sqlInsert_Referencia = "Update tareas set fechaentrega ='".$fecha."',agregafecha = 1,fcomienzaentrega = current_date,tipoentrega = 1  where idtarea = '".$idtarea."'";
    $this->db->query($sqlInsert_Referencia); 
    $insert = array(
      "idTarea" => $_POST['idtarea'],
      "accion" => "Compromiso",
      "comentario" => "Fecha compromiso agregada",
      "hecho_por" => $this->tank_auth->get_idPersona(),
      "registro" => date("Y-m-d H:i:s")
    );
    $data['insert'] = $this->modeloproyecto->insertTrackingTask($insert);
    
    if(count($fechaEntrega)==3){
    $consulta = "INSERT INTO posfecha (idproy, fechaanterior, tipo)VALUES (".$idtarea.",'".$fechaAlerta[0]->fechaentrega."' ,2 )";    
    $this->db->query($consulta);} 
    //Devuelve Tarea 
    $tarea = $this->modeloproyecto->devuelveusuariosdeTarea($idtarea);
    
    if(isset($tarea ))
    {
     foreach ($tarea->result() as $row){
      $sqlInsert_Referencia = "INSERT INTO`citascalendar`(`emailUsuario`,`titulo`,`fechaInicial`,`fechaFinal`,`emailEstado`,`tabla`) VALUES
                  ('".$row->correo."','Entrega Tarea','".$fecha."','".$fecha."','A','clientes_actualiza')";
     $this->db->query($sqlInsert_Referencia);   
    }
   }
   $proyecto = $this->modeloproyecto->devuelveusuariosdeProyecto($idtarea);
   if(isset($proyecto ))
   {
    foreach ($proyecto->result() as $row){
     $sqlInsert_Referencia = "INSERT INTO`citascalendar`(`emailUsuario`,`titulo`,`fechaInicial`,`fechaFinal`,`emailEstado`,`tabla`) VALUES
                 ('".$row->correo."','Entrega Tarea','".$fecha."','".$fecha."','A','clientes_actualiza')";
    $this->db->query($sqlInsert_Referencia);   
   }
  }
  //Enviamos alerta de fecha
  $reg =$this->modeloproyecto->devuelveusuproyecto($idtarea);
  $sqlenviaCorreo ="";
 if(isset($reg))
 {
  foreach($reg as $row)
  {
  // $sqlenviaCorreo = $row->emailUsers; 
     $sqlenviaCorreo = "Insert Ignore Into `envio_correos` ( `fechaCreacion`, `desde`,`para`, `asunto`,`mensaje`, `status`) Values (current_timestamp,'Avisos de GAP<avisosgap@aserorescapital.com>','".$row->emailUsers."','Proyecto: ".$row->nombre."','El Proyecto: ".$row->nombre." <br> Ha generado una fecha de Entrega de la terea".$fecha."<br> Tarea: ".$row->tarea."','0');";
        $this->db->query($sqlenviaCorreo);
    }
  }

    $this->logger->logTarea(Logger::PROGRAMAR, "Se asigna fecha de entrega: ".$fecha, $idtarea, $fecha);
    //echo json_encode($sqlInsert_Referencia);
    echo json_encode('Listo');
    // echo json_encode($proyecto);
  }
  /*+++++++++++++++++++++++++++++++++++++++++++*/
  function subtareaEstrella()
  {
     //$numreg = $this->modeloproyecto->devuelveEstado($tipo,$id,$idtarea);
    $idtarea = $_POST['idtarea'];
//    $idusuario =  $this->tank_auth->get_idPersona();
  //  $idusuario =  $this->tank_auth->get_idPersona();//$usuario = 5;
   $numreg = $this->modeloproyecto->devuelvesubEstrella($idtarea);
   $sqlInsert_Referencia ="";
    //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($idtarea, TRUE));fclose($fp);
   if($numreg == 1)
    {
     $sqlInsert_Referencia = "Update subtareas set estrella = 1 where idsubtarea = '".$idtarea."'";
    /* $sqlInsert_Referencia ="INSERT INTO `acciones` (`idtarea`, `idusuario`, `idaccion`) VALUES 
                         ('".$idtarea."','".$idusuario."','1')";     */
    }
   if($numreg == 2)
    {
      $sqlInsert_Referencia = "Update subtareas set estrella = 0 where idsubtarea = '".$idtarea."'";
     //$sqlInsert_Referencia = "Update acciones set idaccion = 0 where idtarea = '".$idtarea."' and idusuario ='".$idusuario ."'";
     //$numreg =2;
    }
    if($numreg == 3)
    {
      $sqlInsert_Referencia = "Update subtareas set estrella = 1 where idsubtarea = '".$idtarea."'";
    //$sqlInsert_Referencia = "Update acciones set idaccion = 1 where idtarea = '".$idtarea."' and idusuario ='".$idusuario ."'";
    // $numreg =1;
    } 
   $this->db->query($sqlInsert_Referencia); 
   $reg =$this->modeloproyecto->devuelveusuproyecto($idtarea);
  $sqlenviaCorreo ="";
 if(isset($reg))
 {
  foreach($reg as $row)
  {
  // $sqlenviaCorreo = $row->emailUsers; 
     $sqlenviaCorreo = "Insert Ignore Into
     `envio_correos`
        ( `fechaCreacion`, 
        `desde`,
        `para`, 
        `asunto`,
        `mensaje`, 
        `status`
         )
        Values
        (
         current_timestamp,
         'Avisos de GAP<avisosgap@aserorescapital.com>',
          '".$row->emailUsers."',  
          'Proyecto: ".$row->nombre."',
          'El Proyecto: ".$row->nombre." <br> Ha generado una subatrea Importante terea".$fecha."<br> Tarea: ".$row->tarea."',
          '0'
        );
       ";
        $this->db->query($sqlenviaCorreo);
    }
  }
   echo json_encode($numreg); 
 //  echo json_encode( $numreg);  

  }
  /*+++++++++++++++++++++++++++++++++++++++++++*/
  function tareaEstrella() //Modificado* [Suemy][2023-03-13]
  {
     //$numreg = $this->modeloproyecto->devuelveEstado($tipo,$id,$idtarea);
    $idtarea = $_POST['idtarea'];
//    $idusuario =  $this->tank_auth->get_idPersona();
    $idusuario =  $this->tank_auth->get_idPersona();//$usuario = 5;
   $numreg = $this->modeloproyecto->devuelveEstrella($idtarea,$idusuario );
   $sqlInsert_Referencia ="";
   $status = "agregó";
    //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($idtarea, TRUE));fclose($fp);
   if($numreg == 1)
    {
     $sqlInsert_Referencia = "Update tareas set estrella = 1 where idtarea = '".$idtarea."'";
    /* $sqlInsert_Referencia ="INSERT INTO `acciones` (`idtarea`, `idusuario`, `idaccion`) VALUES 
                         ('".$idtarea."','".$idusuario."','1')";     */
    }
   if($numreg == 2)
    {
      $sqlInsert_Referencia = "Update tareas set estrella = 0 where idtarea = '".$idtarea."'";
     //$sqlInsert_Referencia = "Update acciones set idaccion = 0 where idtarea = '".$idtarea."' and idusuario ='".$idusuario ."'";
     //$numreg =2;
      $status = "eliminó";
    }
    if($numreg == 3)
    {
      $sqlInsert_Referencia = "Update tareas set estrella = 1 where idtarea = '".$idtarea."'";
    //$sqlInsert_Referencia = "Update acciones set idaccion = 1 where idtarea = '".$idtarea."' and idusuario ='".$idusuario ."'";
    // $numreg =1;
    } 
   $this->db->query($sqlInsert_Referencia); 
    $insert = array(
      "idTarea" => $_POST['idtarea'],
      "accion" => "Estrella",
      "comentario" => "Se ".$status." Estrella",
      "hecho_por" => $this->tank_auth->get_idPersona(),
      "registro" => date("Y-m-d H:i:s")
    );
    $data['insert'] = $this->modeloproyecto->insertTrackingTask($insert);
   $reg =$this->modeloproyecto->devuelveusuproyecto($idtarea);
   $sqlenviaCorreo ="";
  if(isset($reg))
  {
   foreach($reg as $row)
   {
   // $sqlenviaCorreo = $row->emailUsers; 
      $sqlenviaCorreo = "Insert Ignore Into
      `envio_correos`
         ( `fechaCreacion`, 
         `desde`,
         `para`, 
         `asunto`,
         `mensaje`, 
         `status`
          )
         Values
         (
          current_timestamp,
          'Avisos de GAP<avisosgap@aserorescapital.com>',
           '".$row->emailUsers."',  
           'Proyecto: ".$row->nombre."',    
           'El Proyecto: ".$row->nombre." <br> Ha generado una Tarea Importante <br> Resposable:".$row->nombres."<br> Tarea: ".$row->tarea. "',  
           '0'
         );
        ";
         $this->db->query($sqlenviaCorreo);
     }
   }
   echo json_encode($numreg); 
 //  echo json_encode( $numreg);  

  }
  /*+++++++++++++++++++++++++++++++++++++++++++*/
  function devuelveTareas()
 {
  $idproyecto = $_POST['idproyecto']; 
  $datos=$this->modeloproyecto->devuelveTar($idproyecto);
  //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($datos, TRUE));fclose($fp);
  echo json_encode($datos);
 }  
  /*+++++++++++++++++++++++++++++++++++++++++++*/
  function eliminaTarea() //Modificado [Suemy][2024-03-13]
  {

    $respuesta['idTarea']=$_POST['idTarea']; 
   $idtarea = $_POST['idTarea']; 
   $idusuario =  $this->tank_auth->get_idPersona();
   //$datos=$this->modeloproyecto->devuelveTar($idproyecto);
   //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($datos, TRUE));fclose($fp);
   $consulta = "select p.usuario from proyectos p where p.idproyecto = (select t.idproyecto from tareas t where t.idtarea ='".$idtarea."')";
   $usuario = $this->db->query($consulta)->result(); 
   #if($usuario[0]->usuario == $idusuario)
   #{ 
    $reg =$this->modeloproyecto->devuelveusuproyecto($idtarea);
    $update['tareaEliminada']=1;
    $update['idPersonaQuienElimina']=$idusuario;
     
    $this->db->where('idtarea',$idtarea);
    $this->db->update('tareas',$update);
   /*$sqlInsert_Referencia = "delete from tareas where idtarea = ".$idtarea;
   $this->db->query($sqlInsert_Referencia); 
   $sqlInsert_Referencia = "delete from subtareas where idtarea = ".$idtarea;
   $this->db->query($sqlInsert_Referencia); */
    $insert = array(
      "idTarea" => $_POST['idTarea'],
      "accion" => "Eliminado",
      "comentario" => "Tarea eliminada",
      "hecho_por" => $this->tank_auth->get_idPersona(),
      "registro" => date("Y-m-d H:i:s")
    );
    $data['insert'] = $this->modeloproyecto->insertTrackingTask($insert);
    $respuesta = "ELIMINADO";
   //Envia correos de tarea eliminda
   $reg =$this->modeloproyecto->devuelveusuproyecto($idtarea);
   $sqlenviaCorreo ="";
  //if(isset($reg))
  //{
   foreach($reg as $row)
   {
   // $sqlenviaCorreo = $row->emailUsers; 
      $sqlenviaCorreo = "Insert Ignore Into
      `envio_correos` ( `fechaCreacion`, `desde`,`para`, `asunto`,`mensaje`, `status`)
         Values (current_timestamp,'Avisos de GAP<avisosgap@aserorescapital.com>','".$row->emailUsers."',  'Proyecto: ".$row->nombre."','El Proyecto: ".$row->nombre." <br> Se ha Eliminado una Tarea <br> Terea:".$row->tarea."','0');";
       $this->db->query($sqlenviaCorreo);
     }
   //}

   echo json_encode($respuesta); 
   //echo json_encode($sqlenviaCorreo);
  #}
   /*else{
    echo json_encode('ERROR');
   }*/
   
  }  
   /*+++++++++++++++++++++++++++++++++++++++++++*/
   function eliminasubTarea()
   {
    $idtarea = $_POST['idtarea']; 
    $idusuario =  $this->tank_auth->get_idPersona();
    //$datos=$this->modeloproyecto->devuelveTar($idproyecto);
    //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($datos, TRUE));fclose($fp);
    $consulta = "select p.usuario from proyectos p where p.idproyecto = (select st.idproyecto from subtareas st where st.idsubtarea  ='".$idtarea."')";
    $usuario = $this->db->query($consulta)->result(); 
    if($usuario[0]->usuario == $idusuario)
    {
    $sqlInsert_Referencia = "delete from subtareas where idsubtarea = ".$idtarea;
    $this->db->query($sqlInsert_Referencia); 
    $reg =$this->modeloproyecto->devuelveusuproyecto($idtarea);
    $sqlenviaCorreo ="";
    if(isset($reg))
    {
     foreach($reg as $row)
     {
     // $sqlenviaCorreo = $row->emailUsers; 
       $sqlenviaCorreo = "Insert Ignore Into
       `envio_correos`
          ( `fechaCreacion`, 
          `desde`,
          `para`, 
          `asunto`,
          `mensaje`, 
          `status`
           )
          Values
          (
           current_timestamp,
           'Avisos de GAP<avisosgap@aserorescapital.com>',
            '".$row->emailUsers."',  
            'Proyecto: ".$row->nombre."',
            'El Proyecto: ".$row->nombre." <br> Se ha Eliminado una subtarea <br> Tarea:".$row->tarea."',
            '0'
          );
         ";
          $this->db->query($sqlenviaCorreo);
        }  
     }
     echo json_encode('ELIMINADO');
    }
    else{
      echo json_encode('ERROR');
     }
   }
    /********************************** */
 function responsablesubEmpleado()
 {
  $idsubtarea = $_POST['idsubtarea'];
  $sqlInsert_Referencia = "select idtarea,idsubtareas,correo,responsable from psubtareas  where idpsubtareas = '".$idsubtarea."'";
  $tarea = $datos=$this->db->query($sqlInsert_Referencia)->result()[0]; 
  $correo =$tarea->correo;
  $idtarea =$tarea->idtarea;
  $responsable = $tarea->responsable;
  if($responsable == 1)
    $sqlInsert_Referencia = "Update psubtareas set responsable = 0  where idpsubtareas = ".$idsubtarea;
  else
    $sqlInsert_Referencia = "Update psubtareas set responsable = 1  where idpsubtareas = ".$idsubtarea;
  $this->db->query($sqlInsert_Referencia) ;
 $sqlInsert_Referencia = "select nombre from subtareas where idtarea =  ".$idtarea;
  // $this->db->query($sqlInsert_Referencia) ;
   $nombre = $datos=$this->db->query($sqlInsert_Referencia)->result()[0]; 
   //$reg =$this->modeloproyecto->devuelveusuproyecto($idtarea);
  // foreach($nombre as $row)
   //{
    $sqlenviaCorreo =""; 
  if($responsable == 1)
   {
      $sqlenviaCorreo = "Insert Ignore Into
      `envio_correos`
         ( `fechaCreacion`, 
         `desde`,
         `para`, 
         `asunto`,
         `mensaje`, 
         `status`
          )
          Values
          (
           current_timestamp,
           'Avisos de GAP<avisosgap@aserorescapital.com>',
           '".$correo."',  
           'Proyecto: ".$nombre->nombre."',
           'El Proyecto: ".$nombre->nombre." <br> Se ha Agregado Responsable de la subtarea <br> subTarea:".$nombre->nombre."',
           '0'
         );
        ";
     }
     else{
      $sqlenviaCorreo = "Insert Ignore Into
      `envio_correos`
         ( `fechaCreacion`, 
         `desde`,
         `para`, 
         `asunto`,
         `mensaje`, 
         `status`
          )
         Values
         (
          current_timestamp,
          'Avisos de GAP<avisosgap@aserorescapital.com>',
           '".$correo."',  
           'Proyecto: ".$nombre->nombre."',
           'El Proyecto: ".$nombre->nombre." <br> Se ha Quitado de  Responsable de la subtarea <br> subTarea:".$nombre->nombre."',
           '0'
         );
        "; 
     } 
      // $this->db->query($sqlenviaCorreo);
     //}*/ 
  //Enviamos correo al nuevo responsable
  /* $mail = $this->phpmailer_lib->load();
   $mail->isSMTP();
   $mail->protocol='mail';
   $mail->Host     = 'mail.sloanventas.com';
   $mail->SMTPAuth = true;
   $mail->Username = 'avisos@sloanventas.com';
   $mail->Password = 'inform@tion_2021';
   $mail->SMTPSecure = 'ssl';
   $mail->Port     = 465;
   $mail->setFrom("avisos@sloanventas.com");
   $mail->addAddress($correo);      
   //$mail->SMTPDebug = 2;
   $mail->isHTML(true);                                  //Set email format to HTML
  // $mail->Subject = $row->nombre;
   $persona =$correo;
   $mail->Body    = 'Se ha agregado como Responsable de la subtarea  '.$nombre->nombre;
   $mail->send();*/
  echo json_encode( $nombre); 
  //echo json_encode( $nombre->nombre); 
 }
  //*************************************** */
  function agregasubEmpleados()   
  {
    $nombre    = $_POST['nombre']; 
    $correo    = $_POST['correo']; 
    $id    = $_POST['id']; 
    $tipo   = $_POST['tipo']; 
    $idtarea   = $_POST['idtarea']; 
    $idsubtarea = $_POST['idsubtarea']; 
     $numreg = $this->modeloproyecto->verificasubEmpleado($tipo,$correo,$idtarea);
     if($numreg == 0)
     {
      $sqlInsert_Referencia = "Insert Ignore Into `psubtareas` (`idtarea`, `idsubtareas`,`tipo`, `idpersona`,`nombre`,`correo`) Values('". $idtarea."','". $idsubtarea."','".$tipo."','".$id."','".$nombre."','".$correo."');";    
            
      $this->db->query($sqlInsert_Referencia); 
     if($this->db->affected_rows() > 0)
     {
       $respuesta = array('respuesta' =>'correcto','idproyecto' => $this->db->insert_id(),'nombre_proyecto' =>$nombre, 'tipoerror' =>'Se Grabo Correctamente');
     }
     else
     {
      $respuesta = array('respuesta' =>'error','tipoerror' =>'No se Guardo');
      }
    
 
     }
   else{
     $respuesta = array(
       'respuesta' =>'error',
       'tipoerror' =>'Ya existe el Invitado'
        );    }
  //Termina opretivo  
   //}*/
       // echo json_encode($respuesta);
       echo json_encode($respuesta);

  }
  //*************************************** */
function agregaEmpleados() //Modificado* [Suemy][2023-03-13]
 {
   $nombre    = $_POST['nombre']; 
   $correo    = $_POST['correo']; 
   $id    = $_POST['id']; 
   $tipo   = $_POST['tipo']; 
   $idtarea   = $_POST['idtarea']; 
   
    $numreg = $this->modeloproyecto->verificaEmpleado($tipo,$correo,$idtarea);
    if($numreg == 0)
    {
     $sqlInsert_Referencia = "Insert Ignore Into `ptareas` (`idtarea`, `tipo`, `idpersona`,`nombre`,`correo`) Values ('". $idtarea."','".$tipo."','".$id."','".$nombre."','".$correo."')";    
     $this->db->query($sqlInsert_Referencia); 
    if($this->db->affected_rows() > 0)
    {
      $respuesta = array('respuesta' =>'correcto','idproyecto' => $this->db->insert_id(),'nombre_proyecto' =>$nombre, 'tipoerror' =>'Se Grabo Correctamente');
    $insert = array(
      "idTarea" => $_POST['idtarea'],
      "accion" => "Responsable",
      "comentario" => "Responsable agregado a Tarea",
      "hecho_por" => $this->tank_auth->get_idPersona(),
      "registro" => date("Y-m-d H:i:s")
    );
    $data['insert'] = $this->modeloproyecto->insertTrackingTask($insert);
     }
    else{$respuesta = array('respuesta' =>'error','tipoerror' =>'No se Guardo');}
   

    }
  else{
    $respuesta = array(
      'respuesta' =>'error',
      'tipoerror' =>'Ya existe el Invitado'
       );    }
 //Termina opretivo  
  //}
      $respuesta['responsables']=array();
      $respuesta['responsables']=$this->modeloproyecto->devolverResponsablesTarea($_POST['idtarea']);
      $respuesta['idTarea']=$idtarea;
       echo json_encode($respuesta);
  } 
//************************************************************ */
function subtareaCompletada()
{
  //$numreg = $this->modeloproyecto->devuelveEstado($tipo,$id,$idtarea);
  $idtarea = $_POST['idtarea'];
  $numreg = $this->modeloproyecto->devuelvesubEstado($idtarea);
  //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($idtarea, TRUE));fclose($fp);
  if($numreg > 0)
  {
   $sqlInsert_Referencia = "Update subtareas set completado = 0 where idsubtarea = '".$idtarea."'";
   $numreg =0;
  }
  else{
    $sqlInsert_Referencia = "Update subtareas set completado = 1 where idsubtarea = '".$idtarea."'";
    $numreg =1;
  } 
  $this->db->query($sqlInsert_Referencia); 
  $reg =$this->modeloproyecto->devuelveusuproyecto($idtarea);
  $sqlenviaCorreo ="";
 if(isset($reg))
 {
  if($numreg > 0)
  {
    foreach($reg as $row)
    {
    // $sqlenviaCorreo = $row->emailUsers; 
       $sqlenviaCorreo = "Insert Ignore Into
       `envio_correos`
          ( `fechaCreacion`, 
          `desde`,
          `para`, 
          `asunto`,
          `mensaje`, 
          `status`
           )
          Values
          (
           current_timestamp,
           'Avisos de GAP<avisosgap@aserorescapital.com>',
            '".$row->emailUsers."',  
            'Proyecto: ".$row->nombre."',
            'El Proyecto: ".$row->nombre." <br> Se ha completado una tarea <br> Tarea:".$row->tarea."',
            '0'
          );
         ";
          $this->db->query($sqlenviaCorreo);
      }  
  }
  else{
  foreach($reg as $row)
  {
  // $sqlenviaCorreo = $row->emailUsers; 
     $sqlenviaCorreo = "Insert Ignore Into
     `envio_correos`
        ( `fechaCreacion`, 
        `desde`,
        `para`, 
        `asunto`,
        `mensaje`, 
        `status`
         )
        Values
        (
         current_timestamp,
         'Avisos de GAP<avisosgap@aserorescapital.com>',
          '".$row->emailUsers."',  
          'Proyecto: ".$row->nombre."',
          'El Proyecto: ".$row->nombre." <br> Se ha Activado una tarea <br> Tarea:".$row->tarea."',
          '0'
        );
       ";
        $this->db->query($sqlenviaCorreo);
    }
   }
  }
  

  echo json_encode($numreg);  
 // echo json_encode($numreg);
}
/*+++++++++++++++++++++++++++++++++++++++++++*/

function tareaCompletada() //Modificado [Suemy][2024-03-13]
{
  //$numreg = $this->modeloproyecto->devuelveEstado($tipo,$id,$idtarea);
  $idtarea = $_POST['idtarea'];
  $numreg = $this->modeloproyecto->devuelveEstado($idtarea);
  $status = "completó";
  //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($idtarea, TRUE));fclose($fp);
  if($numreg > 0)
  {
   $sqlInsert_Referencia = "Update tareas set completado = 0, fechaCompletada = NULL where idtarea = '".$idtarea."' ";
   $numreg =0;
$this->logger->logTarea(Logger::REABRIR, "Tarea activada de nuevo", $idtarea);
   $status = "activó";
  }
  else{
    $sqlInsert_Referencia = "Update tareas set completado = 1, fechaCompletada = '".date('Y-m-d H:i:s')."' where idtarea = '".$idtarea."'";
    $numreg =1;
$this->logger->logTarea(Logger::COMPLETAR, "Tarea marcada como completada", $idtarea);
  } 
  $this->db->query($sqlInsert_Referencia); 

  $reg =$this->modeloproyecto->devuelveusuproyecto($idtarea);
    $insert = array(
      "idTarea" => $_POST['idtarea'],
      "accion" => "Completada",
      "comentario" => "Se ".$status." Tarea",
      "hecho_por" => $this->tank_auth->get_idPersona(),
      "registro" => date("Y-m-d H:i:s")
    );
    $data['insert'] = $this->modeloproyecto->insertTrackingTask($insert);
  $sqlenviaCorreo ="";
 if(isset($reg))
 {
  foreach($reg as $row)
  {
  // $sqlenviaCorreo = $row->emailUsers; 
     $sqlenviaCorreo = "Insert Ignore Into
     `envio_correos`
        ( `fechaCreacion`, 
        `desde`,
        `para`, 
        `asunto`,
        `mensaje`, 
        `status`
         )
        Values
        (
         current_timestamp,
         'Avisos de GAP<avisosgap@aserorescapital.com>',
          '".$row->emailUsers."',  
          'Proyecto: ".$row->nombre."',
          'El Proyecto: ".$row->nombre." <br> Se ha completado una tarea <br> Tarea:".$row->tarea."',
          '0'
        );
       ";
        $this->db->query($sqlenviaCorreo);
    }
  }
  echo json_encode($numreg);  
  
}
/*+++++++++++++++++++++++++++++++++++++++++++*/
function grabaSubtarea()
{
   $nombre       = $_POST['nombre'];
   $idproyecto  = $_POST['idproyecto'];
   $idtarea  = $_POST['idtaera'];
   $sqlInsert_Referencia = "
   Insert Ignore Into
     `subtareas` 
           (
            `idtarea`,
             `idproyecto`,
            `nombre`,
            `terminado`
           )
           Values
           (
            '".$idtarea."',
             '".$idproyecto."',
             '".$nombre."',
             '0'              
           );
               ";        
     $this->db->query($sqlInsert_Referencia);
               //echo json_encode($_POST);
              if($this->db->affected_rows() > 0)
              {
               $respuesta = array(
               'respuesta' =>'correcto',
               'idtarea' => $this->db->insert_id(),
               'tarea' =>$nombre 
               );
             }
             else{
               $respuesta = array(
                 'respuesta' =>'error'
               );
             }
       
           echo json_encode($respuesta);
         //echo json_encode($sqlInsert_Referencia);

 } 
//-----------------------------------------------------------
 function grabaTarea() //Modificado [Suemy][2024-04-05]
 {
    $tarea       = $_POST['nombre'];
    $idproyecto  = $_POST['idproyecto'];
    $tituloTarea = $_POST['tituloTarea'];
    $fechaActual = date('d-m-Y');
    $sqlInsert_Referencia = "
    Insert Ignore Into
      `tareas` 
            (
             `idproyecto`,
              `nombre`,
             `terminado`,
             `ftarea`,
             `tituloTarea`
            )
            Values
            (

              '".$idproyecto."',
              '".$tarea."',
              '0',
              CURDATE(),
              '".$tituloTarea."'

            );
                ";        
      $this->db->query($sqlInsert_Referencia);
                //echo json_encode($_POST);
    if($this->db->affected_rows() > 0){
                $respuesta = array(
                'respuesta' =>'correcto',
                'idtarea' => $this->db->insert_id(),
                'tarea' =>$tarea,
                'titulo' => $tituloTarea,
                'fecha'=> date('d/m/Y',strtotime($fechaActual))
                );
      $insert = array(
        "idTarea" => $this->db->insert_id(),
        "accion" => "Creado",
        "comentario" => "Tarea nueva agregada",
        "hecho_por" => $this->tank_auth->get_idPersona(),
        "registro" => date("Y-m-d H:i:s")
      );
      $data['insert'] = $this->modeloproyecto->insertTrackingTask($insert);
//$this->logger->logTarea(Logger::CREAR, "Tarea creada desde interfaz", $id_tarea);
              }
              else{
                $respuesta = array(
                  'respuesta' =>'error'
                );
              }
        
            echo json_encode($respuesta);
          //echo json_encode($_POST);

  } 
//-----------------------------------------------------------
  /**
   * Crea una nueva tarea en el modulo de Seguimiento utilizando la informacion enviada desde una incidencia del modulo de calidad
   */
  public function crearTareaDesdeIncidencia()
  {
    $_respuesta = array();

    $_datos = array(
      'idproyecto' => $_POST[ 'idproyecto' ],
      'nombre' => $this->input->post('descripcionTarea', true),
      'tituloTarea' => "Folio " . $_POST[ 'folio' ],
      'pausado' => 0,
      'ftarea' => date('Y-m-d'),
      'idTabla' => $_POST[ 'noconformidad_id' ],
      'tabla' => "tablanoconformidad",
    );

    $exito = $this->modeloproyecto->crearTareaDesdeIncidencia($_datos);

    if ($exito[ 'success' ]) {
      //ahora tambien agregamos la bitacora de la incidencia como un comentario para la nueva tarea de seguimiento generada
      $datos_comentario = array(
        'idTareas' => $exito[ 'id_tarea' ],
        'comentario' => $_POST[ 'bitacora' ],
        'email' => $this->tank_auth->get_usermail(),
        'idPersona' => $this->tank_auth->get_idPersona(),
      );
      $this->modeloproyecto->agregarComentarioTareaSeguimiento($datos_comentario);

      $this->logger->logTarea(Logger::CREAR, "Tarea generada desde Incidencia", $exito[ 'id_tarea' ]);

      $_respuesta[ 'success' ] = true;
      $_respuesta[ 'message' ] = $exito['message'];
    } else {
      $_respuesta[ 'success' ] = false;
      $_respuesta[ 'message' ] = $exito[ 'message' ];
    }

    echo json_encode($_respuesta);
  }

 function grabaProyecto()
 {
    $nombreProyecto    = $_POST['nombre'];
    $fechaProyecto     = $_POST['fecha'];
    //$hora              = $_POST['hora'];
    $idusuario =  $this->tank_auth->get_idPersona();
    $correo =$this->tank_auth->get_usermail();
    //echo json_encode($_POST);
   //try 
   // {
     //Si vienen operativos 
      
       $sqlInsert_Referencia = "Insert Ignore Into `proyectos` (`nombre`, `fecha`, `usuario`) Values('".$nombreProyecto."','".$fechaProyecto."','".$idusuario."');
                      ";    
          
         $this->db->query($sqlInsert_Referencia);
         
        //echo json_encode($_POST);
       if($this->db->affected_rows() > 0)
       {
        $respuesta = array(
        'respuesta' =>'correcto',
        'idproyecto' => $this->db->insert_id(),
        'nombre_proyecto' =>$nombreProyecto 
        );
      }
      else{
        $respuesta = array(
          'respuesta' =>'error'
        );
      }
      //grabamos calendario
      //foreach ($tarea->result() as $row){
      $sqlInsert_Referencia = "INSERT INTO`citascalendar`(`emailUsuario`,`titulo`,`fechaInicial`,`fechaFinal`,`emailEstado`,`tabla`) VALUES
                    ('".$correo."','".$nombreProyecto."','".$fechaProyecto."','".$fechaProyecto."','A','clientes_actualiza')";
       $this->db->query($sqlInsert_Referencia);   

    echo json_encode($respuesta);
 } 
 /****************************************** */
 function agregasubTareaextra()
 {
  $nombre    = $_POST['nombreTarea']; 
  $correo    = $_POST['correo']; 
  $id    = $_POST['id']; 
  $contrasena   = $_POST['contrasena']; 
  $nomurl   = $_POST['nomurl']; 
  $idsub   = $_POST['idsub']; 
  //echo json_encode($nomurl);
  $numreg = $this->modeloproyecto->verificaTareaextra($correo,$id);
  //echo json_encode($numreg);
  if($numreg == 0)
  {
    $sqlenviaCorreo = "
    Insert Ignore Into
    `envio_correos`
           ( `fechaCreacion`, 
           `desde`,
           `para`, 
           `asunto`,
           `mensaje`, 
           `status`
            )
           Values
           (
            current_timestamp,
            'Avisos de GAP<avisosgap@aserorescapital.com>',
             '".$correo."',  
             'Tarea: ".$nombre."',
             'Se le Asino La Tarea: ".$nombre."<br> Clave de Acceso: ".$contrasena."<br> link :".$nomurl."',
             '0'
           );
  ";
   $this->db->query($sqlenviaCorreo);                      
    $sqlInsert_Referencia = "
   Insert Ignore Into
   `psubtareas` 
       (
                           
         `idtarea`, 
         `idsubtareas`,
         `tipo`, 
         `idpersona`,
          `contrasena`,
          `correo`,
          `url`,
          `cliente`							
       ) 
       Values
       (

         '". $id."',
         '". $idsub."',
         'CLIENTE',
         '0',
         '".$contrasena."',
         '".$correo."',
         '".$nomurl."',
         '1'
       );
           ";    
        
  //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($sqlInsert_Referencia, TRUE));fclose($fp);
    $this->db->query($sqlInsert_Referencia); 
  //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($datos, TRUE));fclose($fp);
  if($this->db->affected_rows() > 0)
  {
    $respuesta = array(
    'respuesta' =>'correcto',
    'idproyecto' => $this->db->insert_id(),
    'nombre_proyecto' =>$nombre, 
    'tipoerror' =>'Se Grabo Correctamente'
   );
  }
  else{
   $respuesta = array(
  'respuesta' =>'error',
  'tipoerror' =>'No se Guardo'
   );
   }
  }
else{
  $respuesta = array(
    'respuesta' =>'error',
    'tipoerror' =>'Ya existe el Invitado'
     );    
    }
  echo json_encode($respuesta);
 // }
  //echo json_encode($sqlInsert_Referencia);
 }
 /****************************************** */
 function agregaTareaextra() //Modificado* [Suemy][2023-03-13]
 {
  $nombre    = $_POST['nombreTarea']; 
  $correo    = $_POST['correo']; 
  $id    = $_POST['id']; 
  $contrasena   = $_POST['contrasena']; 
  $nomurl   = $_POST['nomurl']; 
  //echo json_encode($nomurl);
  $numreg = $this->modeloproyecto->verificaTareaextra($correo,$id);
  //echo json_encode($numreg);
  if($numreg == 0)
  {
    $sqlenviaCorreo = "
    Insert Ignore Into
    `envio_correos`
           ( `fechaCreacion`, 
           `desde`,
           `para`, 
           `asunto`,
           `mensaje`, 
           `status`
            )
           Values
           (
            current_timestamp,
            'Avisos de GAP<avisosgap@aserorescapital.com>',
             '".$correo."',  
             'Tarea: ".$nombre."',
             'Se le Asino La Tarea: ".$nombre."<br> Clave de Acceso: ".$contrasena."<br> link :".$nomurl."',
             '0'
           );
  ";
   $this->db->query($sqlenviaCorreo);                      
    $sqlInsert_Referencia = "
   Insert Ignore Into
   `ptareas` 
       (
                           
         `idtarea`, 
         `tipo`, 
         `idpersona`,
          `contrasena`,
          `correo`,
          `url`,
          `cliente`							
       ) 
       Values
       (

         '". $id."',
         'CLIENTE',
         '0',
         '".$contrasena."',
         '".$correo."',
         '".$nomurl."',
         '1'
       );
           ";    
        
  //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($sqlInsert_Referencia, TRUE));fclose($fp);
    $this->db->query($sqlInsert_Referencia); 
  //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($datos, TRUE));fclose($fp);
  if($this->db->affected_rows() > 0)
  {
    $respuesta = array(
    'respuesta' =>'correcto',
    'idproyecto' => $this->db->insert_id(),
    'nombre_proyecto' =>$nombre, 
    'tipoerror' =>'Se Grabo Correctamente'
   );
    $insert = array(
      "idTarea" => $id,
      "accion" => "Responsable",
      "comentario" => "Responsable extra agregado a Tarea",
      "hecho_por" => $this->tank_auth->get_idPersona(),
      "registro" => date("Y-m-d H:i:s")
    );
    $data['insert'] = $this->modeloproyecto->insertTrackingTask($insert);
  }
  else{
   $respuesta = array(
  'respuesta' =>'error',
  'tipoerror' =>'No se Guardo'
   );
   }
  }
else{
  $respuesta = array(
    'respuesta' =>'error',
    'tipoerror' =>'Ya existe el Invitado'
     );    
    }
  echo json_encode($respuesta);
 // }
  //echo json_encode($sqlInsert_Referencia);
 }
 /****************************************** */
 function agregaInvitado()
 {
   $nombre    = $_POST['nombre']; 
   $correo    = $_POST['correo']; 
   $id    = $_POST['id']; 
   $tipo   = $_POST['tipo']; 
   $idproyecto   = $_POST['idproyecto']; 
   
    $numreg = $this->modeloproyecto->verificaInvitado($tipo,$id,$idproyecto);
   if($numreg == 0)
    {
     $sqlInsert_Referencia = "
     Insert Ignore Into
     `pproyectos` 
         (
                             
           `idproyecto`, 
           `tipo`, 
           `idpersona`,
            `nombre`,
            `correo`							
         ) 
         Values
         (

           '". $idproyecto."',
           '".$tipo."',
           '".$id."',
           '".$nombre."',
           '".$correo."'
         );
             ";    
     //             echo json_encode($sqlInsert_Referencia);
     $datos = $this->db->query($sqlInsert_Referencia); 
    // $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($sqlInsert_Referencia, TRUE));fclose($fp);
    if($this->db->affected_rows() > 0)
    {
      $respuesta = array(
      'respuesta' =>'correcto',
      'idproyecto' => $this->db->insert_id(),
      'nombre_proyecto' =>$nombre, 
      'tipoerror' =>'Se Grabo Correctamente'
     );
    }
    else{
     $respuesta = array(
    'respuesta' =>'error',
    'tipoerror' =>'No se Guardo'
     );
     }
     $registro = $this->modeloproyecto->devuelveProyecto($idproyecto);
    // echo json_encode($registro->result());
     foreach ($registro->result() as $row){
      $proyecto = $row->nombre;
      $fechaProyecto = $row->fecha;
    }  
  
     /*$sqlInsert_Referencia = "INSERT INTO `citascalendar` (`emailUsuario`,`titulo`,`fechaInicial`,`fechaFinal`,`emailEstado`,`tabla`) VALUES
     ('".$correo."','".$proyecto."','".$fechaProyecto."','".$fechaProyecto."','A','clientes_actualiza')";
 
     $this->db->query($sqlInsert_Referencia);   */
 
    }
  else{
    $respuesta = array(
      'respuesta' =>'error',
      'tipoerror' =>'Ya existe el Invitado'
       );    }
 //Termina opretivo  
  //}
  
    echo json_encode($respuesta);
  //     echo json_encode($numreg);
  } 
//************************************************************ */
  function agregaInvitadoextra() //Modificado* [Suemy][2023-03-13]
  {
    $correo    = $_POST['correo']; 
    $tipo   = "EXTERNO";
    $idproyecto   = $_POST['idproyecto']; 
    $contrasena   = $_POST['contrasena']; 
    $nomurl       =  $_POST['nomurl'];
    $nombreProy   =  $_POST['nombreProy'];
    $fechaProy   =  $_POST['fechaProy'];
    $horaProy   =  $_POST['horaProy'];
    $numreg = $this->modeloproyecto->verificaClente($tipo,$correo,$idproyecto);
     if($numreg == 0)
     {
      
      //INSERT INTO `envio_correos` (`fechaCreacion`, `desde`, `para`, `asunto`, `mensaje`, `fileAdjunto`, `nameAdjunto`, `status`, `fechaEnvio`, `identificaModulo`) VALUES (3766, '2020-09-18 17:07:26', 'JIMENEZ ABURTO CLAUDIA <MARKETING@AGENTECAPITAL.COM>', 'manuel.cal7@gmail.com', NULL, NULL, 'Puntos Capital Seguros', '<div>. MARTINEZ VICTOR MANUEL</div><div>Tienes: 5.5 Puntos para canjear.</div>', NULL, NULL, 0, '1900-01-01 00:00:00', 'PuntosClientes');
      $sqlenviaCorreo = "
        Insert Ignore Into
        `envio_correos`
               ( `fechaCreacion`, 
               `desde`,
               `para`, 
               `asunto`,
               `mensaje`, 
               `status`
                )
               Values
               (
                current_timestamp,
                'Avisos de GAP<avisosgap@aserorescapital.com>',
                 '".$correo."',  
                 'Proyecto: ".$nombreProy."',
                 'Se le Invita a la Reunion del Proyecto: ".$nombreProy." <br> El Dia ".$fechaProy." A las ".$horaProy."<br> Clave de Acceso: ".$contrasena."<br> link :".$nomurl."',
                 '0'
               );
      ";
      $this->db->query($sqlenviaCorreo);                      
      
      $sqlInsert_Referencia = "
      Insert Ignore Into
      `pproyectos` 
          (
                              
            `idproyecto`, 
            `tipo`, 
            `idpersona`,
             `nombre`,
             `correo`,	
             `contrasena`,
             `url`						
          ) 
          Values
          (
  
            '". $idproyecto."',
            '".$tipo."',
            '0',
            's/n',
            '".$correo."',
            '".$contrasena."',
            '".$nomurl."'
          );
              ";    
       //            echo json_encode($sqlInsert_Referencia);
      $this->db->query($sqlInsert_Referencia); 
     if($this->db->affected_rows() > 0)
     {
       $respuesta = array(
       'respuesta' =>'correcto',
       'idproyecto' => $this->db->insert_id(),
       'nombre_proyecto' =>$correo, 
       'tipoerror' =>'Se Grabo Correctamente'
      );
      $insert = array(
        "idTarea" => $_POST['idtarea'],
        "accion" => "Responsable",
        "comentario" => "Responsable eliminado de Tarea",
        "hecho_por" => $this->tank_auth->get_idPersona(),
        "registro" => date("Y-m-d H:i:s")
      );
      $data['insert'] = $this->modeloproyecto->insertTrackingTask($insert);
     }
     else{
      $respuesta = array(
     'respuesta' =>'error',
     'tipoerror' =>'No se Guardo'
      );
      }
     }
   else{
     $respuesta = array(
       'respuesta' =>'error',
       'tipoerror' =>'Ya existe el Invitado'
        );    
      }
      //  $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($sqlenviaCorreo, TRUE));fclose($fp);
  //Termina opretivo   
        echo json_encode($respuesta);
  }
//************************************************************ */
function agregaCliente()
{
  $nombre    = $_POST['nombre']; 
  $correo    = $_POST['correo']; 
  $id    = $_POST['id']; 
  $tipo   = $_POST['tipo']; 
  $idproyecto   = $_POST['idproyecto']; 
  $contrasena   = $_POST['contrasena']; 
  $nomurl       =  $_POST['nomurl'];
  $nombreProy   =  $_POST['nombreProy'];
  $fechaProy   =  $_POST['fechaProy'];
  $horaProy   =  $_POST['horaProy'];

  $numreg = $this->modeloproyecto->verificaClente($tipo,$correo,$idproyecto);
   if($numreg == 0)
   {
    $sqlenviaCorreo = "
    Insert Ignore Into
    `envio_correos`
           ( `fechaCreacion`, 
           `desde`,
           `para`, 
           `asunto`,
           `mensaje`, 
           `status`
            )
           Values
           (
            current_timestamp,
            'Avisos de GAP<avisosgap@aserorescapital.com>',
             '".$correo."',  
             'Proyecto: ".$nombreProy."',
             'Se le Invita a la Reunion del Proyecto: ".$nombreProy." <br> El Dia ".$fechaProy." A las ".$horaProy."<br> Clave de Acceso: ".$contrasena."<br> link :".$nomurl."',
             '0'
           );
  ";
   $this->db->query($sqlenviaCorreo);                      

    $sqlInsert_Referencia = "
    Insert Ignore Into
    `pproyectos` 
        (
                            
          `idproyecto`, 
          `tipo`, 
          `idpersona`,
           `nombre`,
           `correo`,	
           `contrasena`,
           `url`						
        ) 
        Values
        (

          '". $idproyecto."',
          '".$tipo."',
          '".$id."',
          '".$nombre."',
          '".$correo."',
          '".$contrasena."',
          '".$nomurl."'
        );
            ";    
     //            echo json_encode($sqlInsert_Referencia);
    $this->db->query($sqlInsert_Referencia); 
   if($this->db->affected_rows() > 0)
   {
     $respuesta = array(
     'respuesta' =>'correcto',
     'idproyecto' => $this->db->insert_id(),
     'nombre_proyecto' =>$nombre, 
     'tipoerror' =>'Se Grabo Correctamente'
    );
   }
   else{
    $respuesta = array(
   'respuesta' =>'error',
   'tipoerror' =>'No se Guardo'
    );
    }
   }
 else{
   $respuesta = array(
     'respuesta' =>'error',
     'tipoerror' =>'Ya existe el Invitado'
      );    }
//Termina opretivo   
      echo json_encode($respuesta); 
}
//************************************************************ */

function eliminaInvitado()
{
  /*MODIFACACION OMAR*/
  $idinvitado = $_POST["idinvitado"];
 $consulta = "delete from pproyectos where id=".$idinvitado;
  $this->db->query($consulta);
  $respuesta['success']=true;
  echo json_encode( $respuesta);
}
//************************************************************ */

function eliminaEmpleado() //Modificado* [Suemy][2023-03-13]
{
  $idEmpleado = $_POST["idEmpleado"];
 $consulta = "delete from ptareas where idptarea =".$idEmpleado;
  $this->db->query($consulta);
    $insert = array(
      "idTarea" => $_POST['idtarea'],
      "accion" => "Responsable",
      "comentario" => "Responsable ha sido eliminado de Tarea",
      "hecho_por" => $this->tank_auth->get_idPersona(),
      "registro" => date("Y-m-d H:i:s")
    );
    $data['insert'] = $this->modeloproyecto->insertTrackingTask($insert);
  echo json_encode('Listo');
}
//************************************************************ */
function eliminasubEmpleado()
{
  $idEmpleado = $_POST["idEmpleado"];
 $consulta = "delete from psubtareas where idpsubtareas =".$idEmpleado;
  $this->db->query($consulta)->result();
  echo json_encode('Listo');
}
//************************************************************ */

function devuelveInvitados()
{
  $idproyecto = $_POST["idproyecto"];
  $consulta = "Select *,(idpersona) as idPersona,(correo) as EMail1,(nombre) as nombres,(tipo) as clasificacion from pproyectos where idproyecto =".$idproyecto;
   
  $datos=$this->db->query($consulta)->result();
       foreach ($datos as $key => $value) 
     {
       $consulta='select fotoUser from user_miInfo where idPersona='.$value->idPersona;
       $respuesta=$this->db->query($consulta)->result();
         (count($respuesta)>0)? $fotoUser=(string)$respuesta[0]->fotoUser : $respuesta='noPhoto.jpg';
       $value->fotoUser=$fotoUser;
    }
  if(isset($_POST['return'])){return $datos;   }
  else{echo json_encode($datos);}
}
//-----------------------------------------------------------
function devolverInvitados()
{
  $idproyecto = $_POST["idproyecto"];
  $consulta = "Select *,(idpersona) as idPersona,(correo) as EMail1,(nombre) as nombres,(tipo) as clasificacion from pproyectos where idproyecto =".$idproyecto;
  $datos['success']=true;
  $datos['invitados']=$this->db->query($consulta)->result();
       foreach ($datos['invitados'] as $value) 
     {
       $consulta='select fotoUser from user_miInfo where idPersona='.$value->idPersona;
       $respuesta=$this->db->query($consulta)->result();
         (count($respuesta)>0)? $fotoUser=(string)$respuesta[0]->fotoUser : $respuesta='noPhoto.jpg';
       $value->fotoUser=$fotoUser;
    }
  if(isset($_POST['return'])){return $datos;   }
  else{echo json_encode($datos);}
}
//-----------------------------------------------------------

function devuelveEmpleados()
{
 /* $idtarea = $_POST["idtarea"];
  $consulta = "Select * from ptareas where idtarea =".$idtarea;
  $datos=$this->db->query($consulta)->result();
  echo json_encode($datos);
 // echo json_encode($consulta);*/
 $idtarea = $_POST["idtarea"];
 //session_start();
 //$idusuario = $_SESSION['idusuario'];
 $idusuario =  $this->tank_auth->get_idPersona();
 $consulta = "select ptareas.*,tareas.nombre as tareas from ptareas,tareas
 where 
 ptareas.idtarea = tareas.idtarea  and ptareas.idtarea =".$idtarea;
 $datos['tareas']=$this->db->query($consulta)->result();
   
   $_POST['return']=1;
   $datos['invitados']=array();
   $datos['invitados']=$this->devuelveInvitados();
 //$consulta = "select idusuario as id,nombre,apellidop,apellidom,email as correo  from usuario	where idusuarioPadre = ".$idusuario;
 //$datos['usuarios']=$this->db->query($consulta)->result();
 //$datos['consulta']=$consulta;
 echo json_encode($datos);
 //echo json_encode($consulta);
}    
//************************************************************ */

function devuelvesubEmpleados()
{
  $idtarea = $_POST["idtarea"];
  $idusuario =  $this->tank_auth->get_idPersona();
  $consulta = "Select * from psubtareas where idsubtareas =".$idtarea;
  $datos['externos']=$this->db->query($consulta)->result();
 /* $consulta = "select idusuario as id,nombre,apellidop,apellidom,email as correo  from usuario	where idusuarioPadre = ".$idusuario;
 
  $datos['usuarios']=$this->db->query($consulta)->result();*/
  echo json_encode($datos);
  //echo json_encode($consulta);
}    
//************************************************************ */
function actualizaAlerta()
{
  $idtarea = $_POST["idtarea"];
  $idusuario =  $this->tank_auth->get_idPersona();
  $consulta = "update ptareas pt set pt.alerta = 0  where pt.idpersona ='".$idusuario."'  and pt.idtarea ='".$idtarea."'";
  $this->db->query($consulta);
  $consulta ="select idproyecto from tareas WHERE idtarea ='".$idtarea."'";
  $datos= $this->db->query($consulta)->result();  ;
  echo json_encode($datos[0]->idproyecto);
 
}
//************************************************************ */
function grabaTareaautomatica()
{
  $tarea = $_POST["tarea"];
  $idusuario = $_POST["idusuario"];
  $nombre = $_POST["nombre"];
  $correo = $_POST["correo"];
  $numreg = $this->modeloproyecto->verificaProyecto($tarea);
  if($numreg ==0)
  {
    $sqlInsert_Referencia = "
    Insert Ignore Into
      `proyectos` 
          (
                              
            `nombre`, 
            `fecha`, 
            `usuario`
            								
          ) 
          Values
          (

            'Automatico',
            CURDATE(),
            '6'            
          );
              "; 
      $this->db->query($sqlInsert_Referencia);
      
      $sqlInsert_Referencia = "
       Insert Ignore Into
      `tareas` 
            (
             `idproyecto`,
              `nombre`,
             `terminado`
            )
            Values
            (

              '".$this->db->insert_id()."',
              '".$tarea."',
              '0'              
            );
                ";
       $this->db->query($sqlInsert_Referencia);   
       $sqlInsert_Referencia = "
                Insert Ignore Into
                `ptareas` 
                    (
                                        
                      `idtarea`, 
                      `tipo`, 
                      `idpersona`,
                       `nombre`,
                       `correo`             
                    ) 
                    Values
                    (
           
                      '".$this->db->insert_id()."',
                      'OPERATIVO',
                      '".$idusuario."',
                      '".$nombre."',
                      '".$correo."'
                    );
                        ";  
         $this->db->query($sqlInsert_Referencia);                                
     }
   else
   {
    $sqlInsert_Referencia = "
    Insert Ignore Into
      `tareas` 
            (
             `idproyecto`,
              `nombre`,
             `terminado`
            )
            Values
            (

              '".$numreg."',
              '".$tarea."',
              '0'              
            );
                ";
       $this->db->query($sqlInsert_Referencia);   
       $sqlInsert_Referencia = "
                Insert Ignore Into
                `ptareas` 
                    (
                                        
                      `idtarea`, 
                      `tipo`, 
                      `idpersona`,
                       `nombre`,
                       `correo`							
                    ) 
                    Values
                    (
           
                      '".$this->db->insert_id()."',
                      'OPERATIVO',
                      '".$idusuario."',
                      '".$nombre."',
                      '".$correo."'
                    );
                        ";  
                        $this->db->query($sqlInsert_Referencia);                                
   }  
 
  //$consulta = "Select * from proyecto where nombre = 'Automatico'";
  //$datos=$this->db->query($consulta)->result();
  echo json_encode($numreg);
 // echo json_encode($tarea);
 // echo json_encode($consulta);
}    
 //----------------------------------------------------
function eliminarArchivo()
 {
   
     $directorio=$this->manejodocumento_modelo->obtenerRuta();
     $rutaArchivo=$directorio.'archivosSeguimiento/'.$_POST['idSeguimiento'].'/'.$_POST['nombreArchivo'];

      $this->manejodocumento_modelo->eliminarArchivo($rutaArchivo);
      $this->devolverArchivosSeguimiento();
  
 }

//--------------------------------------------------------------------
function subirArchivoSeguimiento() //Modificado* [Suemy][2023-03-13]
{
  
  
  
    $ruta=$this->manejodocumento_modelo->obtenerRuta();
  $ruta.='archivosSeguimiento/'.$_POST['idSeguimientoDocumento'];
  $extension=$this->manejodocumento_modelo->devolverExtension($_FILES['Archivo']['name']);
  $nombre=$this->manejodocumento_modelo->obtenerNombreArchivo($_FILES['Archivo']['name']);;
   $nombre = str_replace(
        array("\\", "¨", "º", "~",
             "#", "@", "|", "!", "\"",
             "·", "$", "%", "&", "/",
             "(", ")", "?", "'", "¡",
             "¿", "[", "^", "`", "]",
             "+", "}", "{", "¨", "´",
             ">", "< ", ";", ",", ":",
             ".", " "),
        '',
        $nombre
    );
    $this->manejodocumento_modelo->guardarArchivo($ruta,$_FILES,$nombre,$extension); 
    $respuesta['archivos']=$this->manejodocumento_modelo->devolverArchivos('archivosSeguimiento/'.$_POST['idSeguimientoDocumento'].'/');

           $insert['email']=$this->tank_auth->get_usermail();
       $insert['idPersona']=$this->tank_auth->get_idPersona();
      $consultaPartidasTareas=$this->db->query('select * from ptareas where idtarea='.$_POST['idSeguimientoDocumento'])->result(); 
      $tareasCreador=$this->db->query('select u.email,u.idPersona,p.idproyecto,(p.nombre) as nombreProyecto,t.idtarea,t.nombre from tareas t left join proyectos p on p.idproyecto=t.idproyecto left join users u on u.idPersona=p.usuario where t.idtarea='.$_POST['idSeguimientoDocumento'])->result()[0];
       
        $notificacion=array();
        $notificacion['tabla']='tareas';          
        $notificacion['idTabla']=$_POST['idSeguimientoDocumento'];
        $notificacion['tipo_id']='email';
        $notificacion['referencia']='COMENTARIO_PROYECTOS';
        $notificacion['referencia_id']='1001';
        $notificacion['check']=0;
        $notificacion['comentarioAdicional']='EL USUARIO  '.$insert['email'].' AGREGO UN ARCHIVO AL PROYECTO '.$tareasCreador->nombreProyecto.' TAREA:'.$tareasCreador->nombre;
        $notificacion['tipo']='OTRO';        
       foreach ($consultaPartidasTareas as $value) 
       {
         if($value->correo!=$insert['email'])
         {
           $notificacion['persona_id']=$value->idpersona;
           $notificacion['email']=  $value->correo;
           $notificacion['id']=-1;
           $notificacion['controlador']='cproyecto/muestraProyectos?idproyecto='.$tareasCreador->idproyecto;        
           $ultimoId=$this->notificacionmodel->notificacion($notificacion);
           $actualizar['id']=$ultimoId;
           $actualizar['controlador']='cproyecto/muestraProyectos?idproyecto='.$tareasCreador->idproyecto.'&idNotificacion='.$ultimoId;
           $this->notificacionmodel->actualizarNotificacion($actualizar);
         }
       }
       if($insert['email']!=$tareasCreador->email)
       {
           $notificacion['persona_id']=$tareasCreador->idPersona;
           $notificacion['email']=  $tareasCreador->email;
           $notificacion['id']=-1;
           $notificacion['controlador']='cproyecto/muestraProyectos?idproyecto='.$tareasCreador->idproyecto;        
           $ultimoId=$this->notificacionmodel->notificacion($notificacion);
           $actualizar['id']=$ultimoId;
           $actualizar['controlador']='cproyecto/muestraProyectos?idproyecto='.$tareasCreador->idproyecto.'&idNotificacion='.$ultimoId;
           $this->notificacionmodel->actualizarNotificacion($actualizar);

       }
    $insert = array(
      "idTarea" => $_POST['idSeguimientoDocumento'],
      "accion" => "Documento",
      "comentario" => "Documento agregado",
      "hecho_por" => $this->tank_auth->get_idPersona(),
      "registro" => date("Y-m-d H:i:s")
    );
    $data['insert'] = $this->modeloproyecto->insertTrackingTask($insert);




    echo json_encode($respuesta);


}
/****************************** */
/*function subirArchivoSeguimiento()
{
  
  
  
    $ruta=$this->manejodocumento_modelo->obtenerRuta();
  $ruta.='archivosSeguimiento/'.$_POST['idSeguimientoDocumento'];
  $extension=$this->manejodocumento_modelo->devolverExtension($_FILES['Archivo']['name']);
  $nombre=$this->manejodocumento_modelo->obtenerNombreArchivo($_FILES['Archivo']['name']);;
   $nombre = str_replace(
        array("\\", "¨", "º", "~",
             "#", "@", "|", "!", "\"",
             "·", "$", "%", "&", "/",
             "(", ")", "?", "'", "¡",
             "¿", "[", "^", "`", "]",
             "+", "}", "{", "¨", "´",
             ">", "< ", ";", ",", ":",
             ".", " "),
        '',
        $nombre
    );
  $this->manejodocumento_modelo->guardarArchivo($ruta,$_FILES,$nombre,$extension); 
  
   $respuesta['archivos']=$this->manejodocumento_modelo->devolverArchivos('archivosSeguimiento/'.$_POST['idSeguimientoDocumento'].'/');
  
    echo json_encode($respuesta);


}*/
//-----------------------------------------------------------------
 function devolverArchivosSeguimiento()
 { 
   $respuesta['archivos']=$this->manejodocumento_modelo->devolverArchivos('archivosSeguimiento/'.$_POST['idSeguimiento'].'/');
     
    echo json_encode($respuesta);
 }
//-----------------------------------------------------------------
function grabaComentarioSeguimiento() //Modificado* [Suemy][2023-03-13]
{
  
  $datos=array();
  if(isset($_POST['idTareasComentario']))
  {
    if(isset($_POST['delete']))
    {
      $this->db->where('idTareasComentario',$_POST['idTareasComentario']);
      $this->db->delete('tareascomentario');
            $consult='select * from tareascomentario where idTareas='.$_POST['idSeguimiento'].' order by fechaInsercion desc';

       $datos['comentarios']=$this->db->query($consult)->result();

    }
  }
  else
  {
    if(isset($_POST['comentario']) and isset($_POST['idSeguimiento']))
    {
       $insert['idTareas']=$_POST['idSeguimiento'];
       $insert['comentario']=$_POST['comentario'];
       $insert['email']=$this->tank_auth->get_usermail();
       $insert['idPersona']=$this->tank_auth->get_idPersona();

       $this->db->insert('tareascomentario',$insert);
       $consult='select * from tareascomentario where idTareas='.$_POST['idSeguimiento'].' order by fechaInsercion desc';
       $datos['comentarios']=$this->db->query($consult)->result();
       $consultaPartidasTareas=$this->db->query('select * from ptareas where idtarea='.$_POST['idSeguimiento'])->result();
       $tareasCreador=$this->db->query('select u.email,u.idPersona,p.idproyecto,(p.nombre) as nombreProyecto,t.idtarea,t.nombre from tareas t left join proyectos p on p.idproyecto=t.idproyecto left join users u on u.idPersona=p.usuario where t.idtarea='.$_POST['idSeguimiento'])->result()[0];
       
        $notificacion=array();
        $notificacion['tabla']='tareas';          
        $notificacion['idTabla']=$_POST['idSeguimiento'];
        $notificacion['tipo_id']='email';
        $notificacion['referencia']='COMENTARIO_PROYECTOS';
        $notificacion['referencia_id']='1001';
        $notificacion['check']=0;
        $notificacion['comentarioAdicional']='EL USUARIO  '.$insert['email'].' AGREGO UN COMENTARIO AL PROYECTO '.$tareasCreador->nombreProyecto.' TAREA:'.$tareasCreador->nombre;
        $notificacion['tipo']='OTRO';        
      foreach ($consultaPartidasTareas as $value) 
       {
         if($value->correo!=$insert['email'])
         {
           $notificacion['persona_id']=$value->idpersona;
           $notificacion['email']=  $value->correo;
           $notificacion['id']=-1;
           $notificacion['controlador']='cproyecto/muestraProyectos?idproyecto='.$tareasCreador->idproyecto;        
           $ultimoId=$this->notificacionmodel->notificacion($notificacion);
           $actualizar['id']=$ultimoId;
           $actualizar['controlador']='cproyecto/muestraProyectos?idproyecto='.$tareasCreador->idproyecto.'&idNotificacion='.$ultimoId;
           $this->notificacionmodel->actualizarNotificacion($actualizar);
         }
       }
       if($insert['email']!=$tareasCreador->email)
       {
           $notificacion['persona_id']=$tareasCreador->idPersona;
           $notificacion['email']=  $tareasCreador->email;
           $notificacion['id']=-1;
           $notificacion['controlador']='cproyecto/muestraProyectos?idproyecto='.$tareasCreador->idproyecto;        
           $ultimoId=$this->notificacionmodel->notificacion($notificacion);
           $actualizar['id']=$ultimoId;
           $actualizar['controlador']='cproyecto/muestraProyectos?idproyecto='.$tareasCreador->idproyecto.'&idNotificacion='.$ultimoId;
           $this->notificacionmodel->actualizarNotificacion($actualizar);
          
       }

    }
    else
    {
     if(isset($_POST['idSeguimiento'])) 
     {
       $consult='select * from tareascomentario where idTareas='.$_POST['idSeguimiento'].' order by fechaInsercion desc';
       $datos['comentarios']=$this->db->query($consult)->result();
    $insert = array(
      "idTarea" => $_POST['idSeguimiento'],
      "accion" => "Comentario",
      "comentario" => "Comentario agregado",
      "hecho_por" => $this->tank_auth->get_idPersona(),
      "registro" => date("Y-m-d H:i:s")
    );
    $data['insert'] = $this->modeloproyecto->insertTrackingTask($insert);
     }
    }
  }
  echo json_encode($datos);
}
/*function grabaComentarioSeguimiento()
{
  
  $datos=array();
  if(isset($_POST['idTareasComentario']))
  {
    if(isset($_POST['delete']))
    {
      $this->db->where('idTareasComentario',$_POST['idTareasComentario']);
      $this->db->delete('tareascomentario');
            $consult='select * from tareascomentario where idTareas='.$_POST['idSeguimiento'].' order by fechaInsercion desc';

       $datos['comentarios']=$this->db->query($consult)->result();

    }
  }
  else
  {
    if(isset($_POST['comentario']) and isset($_POST['idSeguimiento']))
    {
       $insert['idTareas']=$_POST['idSeguimiento'];
       $insert['comentario']=$_POST['comentario'];
       $insert['email']=$this->tank_auth->get_usermail();
       $insert['idPersona']=$this->tank_auth->get_idPersona();

       $this->db->insert('tareascomentario',$insert);
      $consult='select * from tareascomentario where idTareas='.$_POST['idSeguimiento'].' order by fechaInsercion desc';
       $datos['comentarios']=$this->db->query($consult)->result();

    }
    else
    {
     if(isset($_POST['idSeguimiento'])) 
     {
       $consult='select * from tareascomentario where idTareas='.$_POST['idSeguimiento'].' order by fechaInsercion desc';
       $datos['comentarios']=$this->db->query($consult)->result();
     }
    }
  }
  echo json_encode($datos);
}*/
//-----------------------------------------------------------
function borrarProyecto()
{
  $insert=array();
  $consulta="select * from proyectos where idproyecto=".$_POST['idProyecto'];
  $datos=$this->db->query($consulta)->result()[0];
   $insert["idproyecto"] = $datos->idproyecto;
    $insert["nombre"] =$datos->nombre;
    if($datos->fecha!='0000-00-00'){$insert["fecha"] =$datos->fecha;}
    $insert["usuario"] =$datos->usuario;
    $insert["hora"] =$datos->hora;
    $insert["identificaProyectoAutomatico"] =$datos->identificaProyectoAutomatico;
    $insert["tabla"] =$datos->tabla;
    $insert["idTabla"] = $datos->idTabla;
    if($datos->agregafecha!='0000-00-00'){$insert["agregafecha"] =$datos->agregafecha;}
    $insert['usuarioQuienBorro'] =$this->tank_auth->get_usermail();
 $this->db->insert('proyectosreciclaje',$insert);
 $this->db->query('delete from proyectos where idProyecto='.$datos->idproyecto);
// $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($datos, TRUE));fclose($fp);
  $this->index();

}
 //-----------------------------------------------------------
 function responsableTarea() //Modificado* [Suemy][2023-03-13]
 {
  $idproyecto = $_POST['responsable'];
  $banadera =$_POST['actualiza'];
  $nombre=$_POST['nombre'];
  $correo=$_POST['correo'];
  $id=$_POST['idproyecto'];
  $status = "asignado a";
  if($banadera == 1)
  {
  $sqlInsert_Referencia = "Update ptareas set responsable = 0  where idptarea = ".$idproyecto;
  $status = "asignado fue eliminado de";
  }
  else
  {
  $sqlInsert_Referencia = "Update ptareas set responsable = 1  where idptarea = ".$idproyecto;
  }
  $datos=$this->db->query($sqlInsert_Referencia);
  $sqlInsert_Referencia = "select ptareas.*,tareas.nombre as tareas from ptareas,tareas
  where 
  ptareas.idtarea = tareas.idtarea and
  ptareas.responsable = 1 and ptareas.idtarea =".$id;
  $proyectos =  $datos=$this->db->query($sqlInsert_Referencia)->result();
    $insert = array(
      "idTarea" => $_POST['idtarea'],
      "accion" => "Responsable",
      "comentario" => "Responsable ".$status." Tarea",
      "hecho_por" => $this->tank_auth->get_idPersona(),
      "registro" => date("Y-m-d H:i:s")
    );
    $data['insert'] = $this->modeloproyecto->insertTrackingTask($insert);
 //Enviamos correo al nuevo responsable
 /*$mail = $this->phpmailer_lib->load();
 $mail->isSMTP();
 $mail->protocol='mail';
 $mail->Host     = 'mail.sloanseguimiento.com';
 $mail->SMTPAuth = true;
 $mail->Username = 'avisos@sloanseguimiento.com';
 $mail->Password = 'inform@tion_2021';
 $mail->SMTPSecure = 'ssl';
 $mail->Port     = 465;
 $mail->setFrom("avisos@sloanseguimiento.com");
 $mail->addAddress($correo);      
 //$mail->SMTPDebug = 2;
 $mail->isHTML(true);  */                                //Set email format to HTML
// $mail->Subject = $row->nombre;
 /*$persona =$correo;
 if($banadera == 1)
 {
 $mail->Body    = 'Se ha quitado como Responsable de la tarea  '.$nombre;
 }
 else{
  $mail->Body    = 'Se ha agregado como Responsable de la tarea  '.$nombre;
 }
 $mail->send();*/
echo json_encode($proyectos); 
//echo json_encode($sqlInsert_Referencia); 
 }
//************************************************************ */
function exporExcel() //Modificado [Suemy][2024-05-10]
{
  $exporta = $this->input->post('idexportar');
  $this->load->library('excel'); 
  $this->excel->setActiveSheetIndex(0);
  $consulta="select * from proyectos where idproyecto = ".$exporta;
  $Proyecto=$this->db->query($consulta)->result();
  //tareas 
  $consulta="select * from tareas where idproyecto = ".$exporta;
  $tareas=$this->db->query($consulta)->result();

  $this->excel->getActiveSheet()->setTitle($Proyecto[0]->nombre);
  //$this->excel->getActiveSheet()->setCellValue("B1",$exporta); 
  $contador =1;
  $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
  $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(120);  
  $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(80);
  $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
  $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
  $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
  $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
  $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
  $styleArray = [
    'font' => [
        'bold'  =>  false,
        'size'  =>  10,
        'name'  =>  'Franklin Gothic Book',
        'color' => array('rgb' => 'FFFFDF'),
    ],
    'alignment' => [
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => ['rgb' => '000000']
        ]
        ],
    'fill' =>[
      'type'=>PHPExcel_Style_Fill::FILL_SOLID,
      'color' => ['rgb' => '497E2D']
    ]   
  ];
  $this->excel->getActiveSheet()->getStyle('A1:M1')->applyFromArray($styleArray);
  $this->excel->getActiveSheet()->setCellValue("A{$contador}","TIPO"); 
  $this->excel->getActiveSheet()->setCellValue("B{$contador}","NOMBRE");
  $this->excel->getActiveSheet()->setCellValue("C{$contador}","RESPONSABLE");
  $this->excel->getActiveSheet()->setCellValue("D{$contador}","COMPLETADO");
  $this->excel->getActiveSheet()->setCellValue("E{$contador}","FECHA ENTREGA");
  $this->excel->getActiveSheet()->setCellValue("F{$contador}","FECHA TAREA");
  $border_style= array('borders' => array('bottom' => array('style' => 
  PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '766f6e'),)));

  if (!empty($tareas)) {
    foreach($tareas as $che)
    {
      $name = str_replace(array("=", "¨", "º", "~","^", "`","+", "}", "{"),'',$che->nombre);
      $contador++;
      $this->excel->getActiveSheet()->setCellValue("A{$contador}","TAREA"); 
      $this->excel->getActiveSheet()->setCellValue("B{$contador}",$name); 
      $consulta="select correo from ptareas where idtarea = ".$che->idtarea;
      $resptareas=$this->db->query($consulta)->result();
      $responsableTarea ="";
      if (!empty($resptareas)) {
        foreach($resptareas as $rest)
        {
          $responsableTarea = $responsableTarea." ".$rest->correo;
        }
        $this->excel->getActiveSheet()->setCellValue("C{$contador}",$responsableTarea); 
        if($che->completado == 1) {
          $this->excel->getActiveSheet()->setCellValue("D{$contador}","COMPLETO"); 
        }
        else {
          $this->excel->getActiveSheet()->setCellValue("D{$contador}","NO COMPLETO"); 
          $this->excel->getActiveSheet()->setCellValue("E{$contador}",$che->fechaentrega);
          $this->excel->getActiveSheet()->setCellValue("F{$contador}",$che->ftarea);   
          //subatreas
          $consulta="select * from subtareas where idtarea = ".$che->idtarea;
          $subtareas =$this->db->query($consulta)->result();
          if (!empty($subtareas)) {
            foreach($subtareas as $restsub)
            {
              $contador++;  
              $this->excel->getActiveSheet()->getStyle("A{$contador}:F{$contador}")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('D3D3D3');
              $this->excel->getActiveSheet()->setCellValue("A{$contador}","SUBTAREA"); 
              $this->excel->getActiveSheet()->setCellValue("B{$contador}",$restsub->nombre); 
              $consulta="select correo from psubtareas where idtarea = ".$restsub->idtarea;
              $respsubtareas=$this->db->query($consulta)->result();
              $responsablesubTarea ="";
              if (!empty($respsubtareas)) {
                foreach($respsubtareas as $ressubtarea)
                {
                  $responsablesubTarea = $responsablesubTarea." ".$ressubtarea->correo;
                }
                $this->excel->getActiveSheet()->setCellValue("C{$contador}",$responsableTarea); 
                if($restsub->completado == 1) {
                  $this->excel->getActiveSheet()->setCellValue("D{$contador}","COMPLETO"); 
                }
                else {
                  $this->excel->getActiveSheet()->setCellValue("D{$contador}","NO COMPLETO"); 
                  $this->excel->getActiveSheet()->setCellValue("E{$contador}",$restsub->fechaentrega);
                  $this->excel->getActiveSheet()->setCellValue("F{$contador}",$restsub->fsubtarea);
                }
              }
            }
          }
        }
      }  
    }
  }
  header("Content-Type: aplication/vnd.ms-excel ");
  $nombre ="Reporte".date("Y-m-d H:i:s");
  header("Content-Disposition: attachment; filename=\"$nombre.xls\"");
  header("Cache-Control: max-age=0")        ;

  

  $writer = PHPExcel_IOFactory::CreateWriter($this->excel,"Excel5");
  file_put_contents('depuracion.txt', ob_get_contents());
  /* Limpiamos el búfer */
   ob_end_clean();
  $writer->save("php://output");
 // redirect('/' . $nombre . ".xlsx");
 // $writer->save('participantes.xlsx');
  //echo json_encode('listo');
}
//-----------------------------------------------------------
  public function ponerEnProduccion()
  {
    $id_tarea = $_POST[ 'idTarea' ];
    $respuesta[ 'success' ] = 1;
    $respuesta[ 'idTarea' ] = $id_tarea;

    $update = 'update tareas set estaProduccion=' . $_POST[ 'estaProduccion' ] . ' where idtarea=' . $id_tarea;
    $respuesta[ 'estaProduccion' ] = $_POST[ 'estaProduccion' ];
   $this->db->query($update);

    $this->logger->logTarea(Logger::DESPLEGAR, "Tarea puesta en producción", $id_tarea);

  echo json_encode($respuesta);
  }
//-----------------------------------------------------------
function agregarEstrellas()
{
  $respuesta['success']=1;
  $respuesta['idTarea']=$_POST['idTarea'];
  $cantidadEstrellas=(integer)$_POST['cantidadEstrellas'];
  if($cantidadEstrellas>-1 and $cantidadEstrellas<11)
  {
   $update='update tareas set cantidadEstrellas='.$_POST['cantidadEstrellas'].' where idtarea='.$_POST['idTarea'];
   $respuesta['cantidadEstrellas']=$_POST['cantidadEstrellas'];
   $this->db->query($update);
  }
  else{$respuesta['success']=0;}
  echo json_encode($respuesta);
}
//-----------------------------------------------------------
function modificarHistorico() //Modificado [Suemy][2024-03-13]
{
  $respuesta['success']=1;
  $respuesta['idTarea']=$_POST['idTarea'];

   $update='update tareas set comision='.$_POST['comision'].' where idtarea='.$_POST['idTarea'];
   $this->db->query($update);
    $insert = array(
      "idTarea" => $_POST['idtarea'],
      "accion" => "Historico",
      "comentario" => "Tarea agregada al Historico",
      "hecho_por" => $this->tank_auth->get_idPersona(),
      "registro" => date("Y-m-d H:i:s")
    );
    $data['insert'] = $this->modeloproyecto->insertTrackingTask($insert);

  echo json_encode($respuesta);

}
//-----------------------------------------------------------
function obtenerHistoricoAcumulado() //Modificado [Suemy][2024-03-13]
{
  //Update ptareas set registro = '2024-02-05 10:17:53' where idptarea = 1258
  //DELETE FROM `ptareas` WHERE idptarea = 1283
  $dato = explode(';',$_POST['idProyecto']);
  $filtroIdProyecto='and idProyecto='.$dato[0].' order by fechacomite desc';
  if($_POST['idProyecto'] =='' || $_POST['idProyecto'] == ";"){$filtroIdProyecto ='order by fechacomite desc';}
  $data = $this->modeloproyecto->getHistoricoAcumulado($filtroIdProyecto);
  //$data['idProyecto'] = $_POST['idProyecto'];
  //$data['filtro'] = $filtroIdProyecto;
  echo json_encode($data);
}
//-----------------------------------------------------------
  function getTableStatus() { //Creado [Suemy][2024-03-13]
    $id = $this->input->get('id');
    $data = $this->modeloproyecto->getTrackingStatus($id);
    echo json_encode($data);
  }

  function getTaskStatus() { //Creado [Suemy][2024-03-13]
    $id = $this->input->get('id');
    $data = $this->modeloproyecto->getTrackingPause($id);
    echo json_encode($data);
  }

  function saveTracking() { //Creado [Suemy][2024-03-13]
    $id = $this->input->post('id');
    $status = $this->input->post('st');
    $comment = $this->input->post('cm');
    $pause =  0;
    $field = "fechaContinua";
    if ($status == "Pausar") {
      $pause = 1;
      $field = "fechaPausa";
    }
    $update = array(
      "pausado" => $pause,
      $field => date("Y-m-d H:i:s")
    );
    $insert = array(
      "idTarea" => $id,
      "accion" => $status,
      "comentario" => $comment,
      "hecho_por" => $this->tank_auth->get_idPersona(),
      "registro" => date("Y-m-d H:i:s")
    );
    $data['insert'] = $this->modeloproyecto->insertTrackingTask($insert);
    $data['update'] = $this->modeloproyecto->updateTrackingTask($update,$id);
    $data['data'] = array("idTarea" => $id, "Estatus" => $status, "Motivo" => $comment);
    echo json_encode($data);
  }

  function infoExportTask() {
    $m = $this->libreriav3->devolverMeses();
    $id = $this->input->post('id');
    $project = $this->db->query('SELECT * FROM proyectos WHERE idproyecto = '.$id)->result();
    $cells = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","AA","AB","AC","AD","AE","AF","AG","AH","AI","AJ","AK","AL","AM","AN","AO","AP","AQ","AR","AS","AT","AU","AV","AW","AX","AY","AZ");
    $months = array();
    $info = array();
    $nameHead = strval("Actividades ".$project[0]->nombre);
    $letter = 1;
    $cellI = 4; //2
    $cellT = 6;
    $cellH1 = "";
    $cellH2 = "";


    foreach ($m as $key => $val) {
      $days = array();
      $range = $this->superestrella_model->rangeMonth(date('Y').'-'.$key.'-01');
      $dates = $this->superestrella_model->getDaysWeek(3,$range);
      foreach ($dates as $row) {
        $mysql = 'WHERE idproyecto = '.$id.' AND comision = 0 AND tareaEliminada != 1 AND fechaentrega = "'.$row.'" ORDER BY fechaentrega DESC';
        $insert['date'] = $row;
        $insert['task'] = $this->modeloproyecto->getTaskInfoComplete($mysql);
        if (!empty($insert['task'])) {
          array_push($days, $insert);
        }
      }
      $add['month'] = $val[0].$val[1].$val[2];
      $add['number'] = $key;
      $add['days'] = $days;
      array_push($months, $add);
    }

    $this->load->library('excel'); 
    //Styles
    $styleTitle = [
      'font' => [
          'bold'  =>  true,
          'size'  =>  10,
          'name'  =>  'Franklin Gothic Book',
          'color' => array('rgb' => '3D3D3D'),
      ],
      'alignment' => [
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
          'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
      ]
    ];
    $styleSubTitle = [
      'font' => [
          'bold'  =>  true,
          'size'  =>  10,
          'name'  =>  'Franklin Gothic Book',
          'color' => array('rgb' => '3D3D3D'),
      ],
      'alignment' => [
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
          'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
      ]
    ];
    $styleProcess = [
      'font' => [
          'bold'  =>  false,
          'size'  =>  10,
          'name'  =>  'Franklin Gothic Book',
          'color' => array('rgb' => 'FFFFFF'),
      ],
      'fill' =>[
        'type'=>PHPExcel_Style_Fill::FILL_SOLID,
        'color' => ['rgb' => '45818e']
      ]
    ];
    $stylePaused = [
      'font' => [
          'bold'  =>  false,
          'size'  =>  10,
          'name'  =>  'Franklin Gothic Book',
          'color' => array('rgb' => 'FFFFFF'),
      ],
      'fill' =>[
        'type'=>PHPExcel_Style_Fill::FILL_SOLID,
        'color' => ['rgb' => '30383A']
      ]
    ];
    $styleCompleted = [
      'font' => [
          'bold'  =>  false,
          'size'  =>  10,
          'name'  =>  'Franklin Gothic Book',
          'color' => array('rgb' => 'FFFFFF'),
      ],
      'fill' =>[
        'type'=>PHPExcel_Style_Fill::FILL_SOLID,
        'color' => ['rgb' => '3f8f50']
      ]
    ];
    $styleProduction = [
      'font' => [
          'bold'  =>  false,
          'size'  =>  10,
          'name'  =>  'Franklin Gothic Book',
          'color' => array('rgb' => 'FFFFFF'),
      ],
      'fill' =>[
        'type'=>PHPExcel_Style_Fill::FILL_SOLID,
        'color' => ['rgb' => '0b5394']
      ]
    ];
    $styleText = [
      'font' => [
          'bold'  =>  true,
          'size'  =>  10,
          'name'  =>  'Franklin Gothic Book',
          'color' => array('rgb' => 'FFFFDF'),
      ],
      'alignment' => [
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
          'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
      ],
      'borders' => [
          'inside' => [
              'style' => PHPExcel_Style_Border::BORDER_THIN,
              'color' => ['rgb' => '7C7C7C']
          ]
      ],
      'fill' =>[
        'type'=>PHPExcel_Style_Fill::FILL_SOLID,
        'color' => ['rgb' => '434343']
      ] 
    ];
    $stylePair = [
      'font' => [
          'bold'  =>  true,
          'size'  =>  10,
          'name'  =>  'Franklin Gothic Book',
          'color' => array('rgb' => '3D3D3D'),
      ],
      'alignment' => [
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
          'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
      ],
      'borders' => [
          'inside' => [
              'style' => PHPExcel_Style_Border::BORDER_THIN,
              'color' => ['rgb' => '7C7C7C']
          ],
          'left' => [
              'style' => PHPExcel_Style_Border::BORDER_THIN,
              'color' => ['rgb' => '7C7C7C']
          ],
          'right' => [
              'style' => PHPExcel_Style_Border::BORDER_THIN,
              'color' => ['rgb' => '7C7C7C']
          ]
      ],
      'fill' =>[
        'type'=>PHPExcel_Style_Fill::FILL_SOLID,
        'color' => ['rgb' => 'd9d9d9']
      ]   
    ];
    $styleOdd = [
      'font' => [
          'bold'  =>  true,
          'size'  =>  10,
          'name'  =>  'Franklin Gothic Book',
          'color' => array('rgb' => '3D3D3D'),
      ],
      'alignment' => [
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
          'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
      ],
      'borders' => [
          'inside' => [
              'style' => PHPExcel_Style_Border::BORDER_THIN,
              'color' => ['rgb' => '7C7C7C']
          ],
          'left' => [
              'style' => PHPExcel_Style_Border::BORDER_THIN,
              'color' => ['rgb' => '7C7C7C']
          ],
          'right' => [
              'style' => PHPExcel_Style_Border::BORDER_THIN,
              'color' => ['rgb' => '7C7C7C']
          ]
      ],
      'fill' =>[
        'type'=>PHPExcel_Style_Fill::FILL_SOLID,
        'color' => ['rgb' => 'f2f2f2']
      ]   
    ];
    $styleCellEmpty = [
      'fill' =>[
        'type'=>PHPExcel_Style_Fill::FILL_SOLID,
        'color' => ['rgb' => 'e7e6e6']
      ]   
    ];
    $styleCell = [
      'borders' => [
          'inside' => [
              'style' => PHPExcel_Style_Border::BORDER_THIN,
              'color' => ['rgb' => '7C7C7C']
          ],
          'right' => [
              'style' => PHPExcel_Style_Border::BORDER_THIN,
              'color' => ['rgb' => '7C7C7C']
          ]
      ],
      'fill' =>[
        'type'=>PHPExcel_Style_Fill::FILL_SOLID,
        'color' => ['rgb' => 'FBFBFB']
      ]   
    ];
    $this->excel->setActiveSheetIndex(0);
    $this->excel->getActiveSheet()->setTitle($project[0]->nombre);
    $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
    $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(120);
    $this->excel->getActiveSheet()->getStyle('A1:F1')->applyFromArray($styleTitle);
    $this->excel->getActiveSheet()->mergeCells('A1:B1')->setCellValue('A1',$nameHead);
    $this->excel->getActiveSheet()->setCellValue("B2","Indicadores:")->getStyle('B2')->applyFromArray($styleSubTitle);
    $this->excel->getActiveSheet()->setCellValue("C2","Pausado")->getStyle('C2')->applyFromArray($stylePaused);
    $this->excel->getActiveSheet()->setCellValue("D2","Trabajando")->getStyle('D2')->applyFromArray($styleProcess);
    $this->excel->getActiveSheet()->setCellValue("E2","Completado")->getStyle('E2')->applyFromArray($styleCompleted);
    $this->excel->getActiveSheet()->setCellValue("F2","En Producción")->getStyle('F2')->applyFromArray($styleProduction);
    $this->excel->getActiveSheet()->setCellValue("A3","TITULO"); 
    $this->excel->getActiveSheet()->setCellValue("B3","DESCRIPCIÓN");

    if (!empty($months)) {
      $cellQuarterI = "";
      $cellQuarterF = "";
      foreach ($months as $val) {
        //Encabezado
        $letter = $letter + 1;
        $cellD = $letter;
        $cellI = $cells[$letter];
        $numdays = !empty($val['days']) ? (count($val['days']) - 1) : 0;
        $nameMonth = $val['month'];
        if ($numdays != 0) {
          $letter = $letter + $numdays;
        }
        $cellF = $cells[$letter];
        $cellHeadM = strval($cellI.'4:'.$cellF.'4');
        $cellMonth = $cellI.'4';
        $cellH0 = strval('A3:'.$cellF.'3');
        //Trimestre
        if ($val['number'] == 1 || $val['number'] == 4 || $val['number'] == 7 || $val['number'] == 10) {
          $cellQuarterI = $cellI.'3';
        }
        else if ($val['number'] == 3 || $val['number'] == 6 || $val['number'] == 9 || $val['number'] == 12) {
          $cellQuarterF = $cellF.'3';
          $cellHeadQ = strval($cellQuarterI.':'.$cellQuarterF);
          $nameQuarter = "T";
          switch ($val['number']) {
            case '3': $numQ = "1"; break;
            case '6': $numQ = "2"; break;
            case '9': $numQ = "3"; break;
            case '12': $numQ = "4"; break;
          }
          $nameQuarter = $nameQuarter.$numQ;
          $this->excel->getActiveSheet()->mergeCells($cellHeadQ)->setCellValue($cellQuarterI,$nameQuarter);
        }
        //Meses
        $this->excel->getActiveSheet()->mergeCells($cellHeadM)->setCellValue($cellMonth,$nameMonth);
        //Días
        if (!empty($val['days'])) {
          $letterD = $cellD;
          foreach ($val['days'] as $row) {
            $cellDay = $cells[$letterD].'5';
            $day = date('d',strtotime($row['date']));
            $this->excel->getActiveSheet()->getColumnDimension($cells[$letterD])->setWidth(13);
            $this->excel->getActiveSheet()->setCellValue($cellDay,$day);
            //Tareas
            // if (!empty($val['task'])) {
              foreach ($row['task'] as $value) {
                $cellTitle = strval('A'.$cellT);
                $cellDesc = strval('B'.$cellT);
                $cellDate = strval($cells[$letterD].$cellT);
                $title = $value['titulo'];
                $description = str_replace(array("=", "¨", "º", "~","^", "`","+", "}", "{"),'',$value['nombre']);
                $status = $value['estatus_txt'];
                $styleFill = "";
                switch ($value['estatus']) {
                  case '0': $styleFill = $styleProcess; break;
                  case '1': $styleFill = $stylePaused; break;
                  case '2': $styleFill = $styleCompleted; break;
                  case '3': $styleFill = $styleProduction; break;
                }
                $this->excel->getActiveSheet()->setCellValue($cellTitle,$title);
                $this->excel->getActiveSheet()->setCellValue($cellDesc,$description);
                $this->excel->getActiveSheet()->setCellValue($cellDate,$status)->getStyle($cellDate)->applyFromArray($styleFill);
                $cellT++;
              }
            // }
            $letterD = $letterD + 1;
          }
        }
        else {
          $cellDay = $cells[$cellD].'5';
          $this->excel->getActiveSheet()->getColumnDimension($cells[$cellD])->setWidth(15);
          $this->excel->getActiveSheet()->setCellValue($cellDay,"");
        }
        //Style
        $cellH1 = strval($cellI.'4:'.$cellF.'5');
        $style = (($val['number'] % 2) == 0) ? $stylePair : $styleOdd;
        $this->excel->getActiveSheet()->getStyle($cellH1)->applyFromArray($style);
      }
    }
    $cellInfo = strval('A6:B'.$cellT);
    $this->excel->getActiveSheet()->getStyle($cellH0)->applyFromArray($styleText);
    $this->excel->getActiveSheet()->getStyle("A4:B5")->applyFromArray($styleCellEmpty);
    $this->excel->getActiveSheet()->getStyle($cellInfo)->applyFromArray($styleCell);

    header("Content-Type: aplication/vnd.ms-excel ");
    $name = "Cronograma ".date("Y-m-d H:i:s");
    header("Content-Disposition: attachment; filename=\"$name.xls\"");
    header("Cache-Control: max-age=0");

    $writer = PHPExcel_IOFactory::CreateWriter($this->excel,"Excel5");
    file_put_contents('depuracion.txt', ob_get_contents());
    ob_end_clean();
    $writer->save("php://output");
  }
}
