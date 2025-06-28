<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//require_once __DIR__.'dompdf/autoload.inc.php';
//use Dompdf\Dompdf;
//require_once(dirname(__FILE__) . '\dompdf\autoload.inc');

class capitalHumano extends CI_Controller{
  var $mensaje  = "";
  var $datos    = array();

  
  function __construct(){
    parent::__construct();
    $this->load->model('PersonaModelo');
    $this->load->model('manejodocumento_modelo');
    $this->load->model('capitalhumano_model');
    $this->load->model('modeloproyecto');
    $this->load->model('documentos_capitalhumano_model');
    $this->load->model('crmproyecto_model'); //Agregado [2024-02-13]
    $this->load->model('metacomercial_modelo'); //Agregado [2024-02-13]
    $this->load->model('cuadromando_model'); //Agregado [2024-02-14]
    $this->load->library("libreriav3");
    if (!$this->tank_auth->is_logged_in()){redirect('/auth/login/');}
  }
  //---------------------------------------------------------------
  function index(){
    if (!$this->tank_auth->is_logged_in()) {
      redirect('/auth/login/');
    } 
    else {
    //$this->datosParaCapital();
    //$this->datos['organigrama']=$this->capitalhumano_model->crearOrganigrama(); 
     //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp,print_r($this->datos,TRUE));fclose($fp); 
    //$this->datos['cargaAutomatica']=true;
    //$permissions = $this->PersonaModelo->permisosPersona('documentos');
    //var_dump($permissions);
    //$deletePermission = isset($permissions["Eliminar documento del puesto"]) ? array("disabled" => "", "label" => "Eliminar") : array("disabled" => "disabled", "label" => "Eliminar (bloqueado)");
    //$showOption = isset($permissions["Ver opción de documentos del puesto"]) ? true : false;
    //$uploadFile = isset($permissions["Subir documento para un puesto"]) ? true : false;
    //$viewAllJobDocs = isset($permissions["Ver documentos generales del puesto"]) ? true : false;
    //$this->datos["permission"]["delete"] = $deletePermission;
    //$this->datos["permission"]["showOption"] = $showOption;
    //$this->datos["permission"]["uploadFile"] = $uploadFile;
    //$this->datos["permission"]["viewAllDocs"] = $viewAllJobDocs;

    //$this->load->view('persona/capitalHumano',$this->datos);
    $this->getPosition(); //Dennis Castillo [2022-04-11]
  }
  }
  
//---------------------------------
function getPosition(){ //Modificado [Suemy][2024-11-06]

  $idPersona = $this->tank_auth->get_idPersona();
  $email = $this->tank_auth->get_usermail();
  $getMyPosition = $this->PersonaModelo->puestoDePersona($idPersona); //puestoDePersona
  //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($getMyPosition, TRUE));fclose($fp); 
  $matrizProc=$this->capitalhumano_model->devolverMatrizAsignadaPuesto($getMyPosition[0]->idPuesto);     
  $option="";

  $option=$option.'<option value="-1"></option>';
  foreach ($matrizProc as $value) {
    $option=$option.'<option value="'.$value->idFuncionProcesoFP.'">'.$value->descripcionFP.'</option>';
  }
  
  $this->datos["months"] = $this->libreriav3->devolverMeses();
  $this->datos['matrizProcesos']=$option;
  $this->datos['personaPuesto']=$this->capitalhumano_model->buscarPuesto($getMyPosition[0]->idPuesto);
  //$this->datos['contenidoMU']=$this->capitalhumano_model->devolverManualUsuario($getMyPosition[0]->idPuesto);
  $this->datos['funcionesPuesto']=$this->capitalhumano_model->devolverFuncionesAsignadasPuesto($getMyPosition[0]->idPuesto);
  //-------------------------------------------------------------------------------------
  $show = 0;
  if ($email == "DIRECTORGENERAL@AGENTECAPITAL.COM" || $email == "CAPITALHUMANO@AGENTECAPITAL.COM" || $email == "ASISTENTEDIRECCION@AGENTECAPITAL.COM" || $email == "SISTEMAS@ASESORESCAPITAL.COM") {
    $show = 1;
  }

  //------------------------ //Dennis Castillo [2022-03-15]
  $permissions = $this->PersonaModelo->permisosPersona('documentos');
  $deletePermission = isset($permissions["Eliminar documento del puesto"]) ? array("disabled" => "", "label" => "Eliminar") : array("disabled" => "disabled", "label" => "Eliminar (bloqueado)");
  $showOption = isset($permissions["Ver opción de documentos del puesto"]) ? true : false;
  $uploadToRepositories = $this->getPermissionDocumentsEmployees(1);
  $viewAllJobDocs = isset($permissions["Ver documentos generales del puesto"]) ? true : false;
  $uploadFile = !empty($permissions["Subir documentos a repositorios generales"]) ? true : false;
  $this->datos["permission"]["delete"] = $deletePermission;
  $this->datos["permission"]["showOption"] = $showOption;
  $this->datos["permission"]["uploadFile"] = $uploadFile;
  $this->datos["permission"]["viewAllDocs"] = $viewAllJobDocs;
  $this->datos["permission"]["uploadToRepositories"] = $uploadToRepositories;
  $this->datos["permission"]["showSE"] = $show;
//------------------------
  $vacaciones=$this->getDiasVacaciones($this->tank_auth->get_idPersona());
  $per=$this->getDateDataFromMyRecord($this->tank_auth->get_idPersona());
  $this->datos['vacations']['cantidadDiasPeriodo']=$vacaciones[0];
  $this->datos['diasVacaciones']=$vacaciones[0];
  $this->datos["vacations"]["periodoActual"]=$per['currentDatePeriod'];  

  $initialJobDatesData = $this->getDateDataFromMyRecord($this->tank_auth->get_idPersona());
  $this->datos["vacations"]["period"] = !empty($initialJobDatesData) ? $initialJobDatesData["periodNumber"] : "Sin periodo";
  $this->datos['diasSolicitados']=$this->getDiasSolicitados($this->tank_auth->get_idPersona());
  $this->datos['daysVacations']=$this->buscarFechaVacas($this->tank_auth->get_idPersona());
  $this->datos['VacationsPendientes']=$this->buscarFechaVacasPendientes($this->tank_auth->get_idPersona());
  //------------------------
  $this->datosParaCapital();
  $this->load->view('persona/capitalHumano',$this->datos);
}//---------------------------------
    function buscarFechaVacas($idPersona){
        //Determinar dias de antiguedad
        $sql="SELECT fecha_salida,fecha_retorno FROM vacaciones WHERE idPersona='$idPersona' and estado='Aprobado'";
        $datos=$this->db->query($sql)->result();
        return $datos;
      }
      //---------------------------------
    function buscarFechaVacasPendientes($idPersona){
        //Determinar dias de antiguedad
        $sql="SELECT fecha_salida,fecha_retorno FROM vacaciones WHERE idPersona='$idPersona' and estado='Pendiente'";
        $datos=$this->db->query($sql)->result();
        return $datos;
      }
//---------------------------------
    function getDiasVacaciones($idPersona){
        //Determinar dias de antiguedad
        $sql="SELECT * FROM persona WHERE idPersona='$idPersona'";
        $rs=$this->db->query($sql)->result();
        $fecha_ingreso = new DateTime($rs[0]->fecAltaSistemPersona);
        $hoy = new DateTime("now");
        $yearAntiguedad = $hoy->diff($fecha_ingreso);
        $yearAntiguedad=$yearAntiguedad->y;
        //determinar cantidad de dias de vacaciones correspondientes

        ;
        $anio=explode('-', $this->getDateDataFromMyRecord($idPersona)['currentDatePeriod']);
        if($anio[0]>2022)
        {$sqlX="SELECT * FROM tabla_vacaciones_nueva WHERE anio='$yearAntiguedad'";}
        else
        {$sqlX="SELECT * FROM tabla_vacaciones WHERE anio='$yearAntiguedad'"; }
         $period = $this->PersonaModelo->getWorkStartPeriod($idPersona);

        
        $rsDias=$this->db->query($sqlX)->result();
        if($rsDias){
            $datos[0]=$rsDias[0]->dias;
            $datos[1]=$yearAntiguedad;
        }else{
            $datos[0]='';
            $datos[1]='';
        }
        return $datos;
      }
//---------------------------------------- 
  function getDateDataFromMyRecord($idPersona){

    $test = array();
    $response = array();
    $countFromLimit = 0;
    $getInitialDate = $this->PersonaModelo->getFechaIngreso($idPersona);

    if(!empty($getInitialDate)){

      $now = new DateTime("now");
      $limitDate = new DateTime(date("Y-m-d", strtotime($getInitialDate))); //date("Y-m-d", strtotime($getInitialDate))
      $diff = $limitDate->diff($now);
      $limitDate = $limitDate->modify("".$diff->format("%R%y")." year"); //Limite de cambio de periodo;

      $response = array(
        "haveVacations" => $diff->format("%y") > 0,
        "initialJobDate" => date("Y-m-d", strtotime($getInitialDate)),
        "currentDatePeriod" => $limitDate->format("Y-m-d"), //date("Y-m-d", strtotime($getInitialDate)),
        "nextDatePeriod" => $limitDate->modify("+ 1 year")->format("Y-m-d"),
        "periodNumber" => $diff->format("%y"),
        "dayAndMonthLimit" => [$limitDate->format("n-j")]
        //"intervalDates" => $test,
      );
    }

  ;
    ;
    return $response;
  }
//---------------------------------------- 
      function getDiasSolicitados($idPersona){
      //determinar los dias solicitados en el año por Usuario
    $period = $this->PersonaModelo->getWorkStartPeriod($idPersona);
    $year=date('Y');

    $data=$this->getDateDataFromMyRecord($idPersona);
           $fechaEntera = strtotime($data['currentDatePeriod']);
      $year=date('Y',$fechaEntera);

    
    $sqlX="SELECT SUM(cantidad_dias) as dias FROM vacaciones WHERE  antiguedad = ".$period->anio." AND aprobado IN (0, 1) and idPersona = $idPersona"; //aprobado<>-1
    return $this->db->query($sqlX)->result();
    }
    
//---------------------------------
function puesto(){
  //$this->datos['vista']='altaPuestoDiv';  
  if($_POST['idPuesto']==0){
    /*======== SE GUARDA EL NUEVO PUESTO=====================*/
    $_POST['buscarIdPuesto']=$this->capitalhumano_model->guardarPuesto();
    //$this->buscarPuesto();
  }
  else{
     /*======== SE ACTUALIZA EL PUESTO ========================*/
     $actualizar['personaPuesto'] = $_POST['personaPuesto'];
     $actualizar['padrePuesto'] = $_POST['padrePuesto'];
     $actualizar['idColaboradorArea'] = $_POST['areaPuesto']; //Dennis Castillo [2022-01-20]
     $actualizar['result'] = $this->capitalhumano_model->actualizarPuesto($_POST['idPuesto'],$actualizar);
     //$_POST['buscarIdPuesto']=$_POST['idPuesto'];
     $actualizar['idPuesto'] = $_POST['idPuesto'];
     $actualizar['selectPuestos'] = $_POST['selectPuestos'];
  //   $this->buscarPuesto();
  }
  $actualizar['success'] = true;
  echo json_encode($actualizar);

}
//-------------------------------------------------------------
function moverProcedimiento(){
 
  $funcionProceso=$this->capitalhumano_model->devolverFuncionProceso($_GET['idProcesoFuncion']);

  $procedimientoFuncion=$this->capitalhumano_model->devolverProcedimientosFuncion($funcionProceso->padreFP);
$tabla='Pasos';$opcionTabla=5;
/*SUBE EL PROCEDIMIENTO DE POSICION*/
  if($_GET['tipoMovimiento']==1){
   if($procedimientoFuncion[0]->idFuncionProceso!=$_GET['idProcesoFuncion']){

      $posicionSuperior="";
     foreach ($procedimientoFuncion as  $value) 
       {
          if($_GET['idProcesoFuncion']==$value->idFuncionProceso){break;}
          else{$posicionSuperior=$value->idFuncionProceso;}
       } 
       $array['posicionMover1']=$_GET['idProcesoFuncion'];
       $array['posicionMover2']= $posicionSuperior;
       $this->capitalhumano_model->moverProcedimientoModelo($array);       
      if($funcionProceso->clasificacionFP==2){
       $this->capitalhumano_model->cambiarHijos($array);            
       $this->manejodocumento_modelo->renombrarCarpetaMoverProcedimiento($array);
       $tabla="Procedimientos"; 
       $opcionTabla=3;             
     }
   }
  }
  else{
  /*BAJA EL PROCEDIMIENTO DE POSICION*/
    $count=count($procedimientoFuncion);$count--;
    if($procedimientoFuncion[$count]->idFuncionProceso!=$_GET['idProcesoFuncion'])
     {
         $posicionInferior="";$band=0;
     foreach ($procedimientoFuncion as  $value) 
       {
          if($_GET['idProcesoFuncion']==$value->idFuncionProceso){$band=1;}
          else{if($band==1){$posicionInferior=$value->idFuncionProceso;break;}}
       } 
       $array['posicionMover1']=$posicionInferior;
       $array['posicionMover2']=$_GET['idProcesoFuncion'];
       $this->capitalhumano_model->moverProcedimientoModelo($array);  
        if($funcionProceso->clasificacionFP==2){
       $this->capitalhumano_model->cambiarHijos($array);
       $this->manejodocumento_modelo->renombrarCarpetaMoverProcedimiento($array); 
       $tabla="Procedimientos";$opcionTabla=3;
       }
     }

  }
  $datos['datos']=$this->capitalhumano_model->devolverProcedimientosFuncion($funcionProceso->padreFP);
  $datos['tabla']=$tabla;
  $datos['opcionTabla']=$opcionTabla;
  echo json_encode($datos);
 // echo json_encode('ejemplo()');
}
//-------------------------------------------------------------
function buscarPuesto()
{

  if($_POST['buscarIdPuesto']>1)
  {
    //$datos;
    $this->datos['personaPuesto']=$this->capitalhumano_model->buscarPuesto($_POST['buscarIdPuesto']);
    //$this->datos['contenidoMU']=$this->capitalhumano_model->devolverManualUsuario($_POST['buscarIdPuesto']);
    $this->datos['funcionesPuesto']=$this->capitalhumano_model->devolverFuncionesAsignadasPuesto($_POST['buscarIdPuesto']);
    $this->datos["months"] = $this->libreriav3->devolverMeses();

    //------------------------ //Dennis Castillo [2022-03-15]
    $permissions = $this->PersonaModelo->permisosPersona('documentos');
    
    $deletePermission = isset($permissions["Eliminar documento del puesto"]) ? array("disabled" => "", "label" => "Eliminar") : array("disabled" => "disabled", "label" => "Eliminar (bloqueado)");
    $showOption = isset($permissions["Ver opción de documentos del puesto"]) ? true : false;
    $uploadFile = isset($permissions["Subir documento para un puesto"]) ? true : false;
    $viewAllJobDocs = isset($permissions["Ver documentos generales del puesto"]) ? true : false;
    $uploadToRepositories = isset($permissions["Subir documentos a repositorios generales"]) ? 1 : 0;
    $this->datos["permission"]["delete"] = $deletePermission;
    $this->datos["permission"]["showOption"] = $showOption;
    $this->datos["permission"]["uploadFile"] = $uploadFile;
    $this->datos["permission"]["viewAllDocs"] = $viewAllJobDocs;
    $this->datos["permission"]["uploadToRepositories"] = $uploadToRepositories;
    //------------------------

    /*$matrizProc=$this->capitalhumano_model->devolverMatrizAsignadaPuesto($_POST['buscarIdPuesto']);     
    $option="";
    $option=$option.'<option value="-1"></option>';
    foreach ($matrizProc as $value) {$option=$option.'<option value="'.$value->idFuncionProcesoFP.'">'.$value->descripcionFP.'</option>';}
    $this->datos['matrizProcesos']=$option;*/   
  }
  else
  {
     //$this->datos['mensaje']='alert("Escoja un puesto");';
  }
  $this->datosParaCapital();
      $this->datos['cargaAutomatica']=false;
   /*   $permiso  = $this->PersonaModelo->permisosPersona('VerTodosLosPuestos');

    if(isset($permiso['value'])){$this->datos['puestos']  = $this->capitalhumano_model->devolverPuestos(1);} 
    else {$this->datos['puestos'] = $this->capitalhumano_model->devolverPuestos(null);}

    $this->datos['puestosTodos']=$this->capitalhumano_model->devolverPuestos(1);
    $this->datos['organigrama']=$this->capitalhumano_model->crearOrganigrama();
    $this->datos['anios']=$this->libreriav3->devolverAnios();
    $this->datos['meses']=$this->libreriav3->devolverMeses();
    $this->datos['mapa']=$this->capitalhumano_model->get_organigrama();
    $this->datos['documentos']=$this->documentos_capitalhumano_model->get_documentos();
    $this->datos['puestosGrupos']=$this->PersonaModelo->personapuestogrupo(null);
    $this->datos['colaboradorConPuesto']=$this->PersonaModelo->devolverColaboradorConPuesto();
    $permiso=$this->PersonaModelo->permisosPersona('agregarPuestos');
    $this->datos['puestoUsuario']=$this->tank_auth->get_idPersonaPuesto();
    $this->datos['IdUsuario']=$this->tank_auth->get_idPersona();
    $this->datos['permisoAgregar']=$permiso['valor'];    
    $this->datos['cargaAutomatica']=false;*/
    $this->load->view('persona/capitalHumano',$this->datos);
}

//------------------------------------------------------------
function buscarPuestoAntiguo(){
  if($_POST['buscarIdPuesto']>1)
  {
    //$datos;
    $this->datos['personaPuesto']=$this->capitalhumano_model->buscarPuesto($_POST['buscarIdPuesto']);
    $this->datos['contenidoMU']=$this->capitalhumano_model->devolverManualUsuario($_POST['buscarIdPuesto']);
    $this->datos['funcionesPuesto']=$this->capitalhumano_model->devolverFuncionesAsignadasPuesto($_POST['buscarIdPuesto']);
    $matrizProc=$this->capitalhumano_model->devolverMatrizAsignadaPuesto($_POST['buscarIdPuesto']);     
    $option="";
    $option=$option.'<option value="-1"></option>';
    foreach ($matrizProc as $value) {$option=$option.'<option value="'.$value->idFuncionProcesoFP.'">'.$value->descripcionFP.'</option>';}
    $this->datos['matrizProcesos']=$option;   
  }
  else
  {
     $this->datos['mensaje']='alert("Escoja un puesto");';
  }
 $this->index();
}
//-------------------------------------------------------------
function guardaDocumentoProc(){
  $datos=array();
    $datos['mensaje']='EL ARCHIVO SE SUBIO CON EXITO';

  $nombre=$this->manejodocumento_modelo->obtenerNombreArchivo($_FILES['documentos']['name']);
  $extension=$this->manejodocumento_modelo->devolverExtension($_FILES['documentos']['name']);
  $directorio=$this->manejodocumento_modelo->obtenerDirectorio('U').'ArchivosProcedimientos/'.$_POST['idFuncionProcedimiento'];
  $respuesta=$this->manejodocumento_modelo->guardarArchivo($directorio,$_FILES,$nombre,$extension);
      
  echo json_encode($datos);
}
//-------------------------------------------------------------
function guardarDiagrama(){
 
  $nombre=$this->libreriav3->numeroAleatorioHexadecimal();//'Diagrama';//$this->manejodocumento_modelo->obtenerNombreArchivo($_FILES['documentos']['name']);
  $extension=$this->manejodocumento_modelo->devolverExtension($_FILES['documentos']['name']);
  $directorio=$this->manejodocumento_modelo->obtenerDirectorio('U').'ArchivosProcedimientos/'.$_POST['idFuncionProcedimiento'].'/Diagrama';  
   
  if($this->manejodocumento_modelo->verificaExtensionImagen($extension)){
    $this->manejodocumento_modelo->eliminarContenidoDeDirectorio($directorio);
  $respuesta=$this->manejodocumento_modelo->guardarArchivo($directorio,$_FILES,$nombre,'bmp');
  echo json_encode('Archivo guardado');
  }else{echo json_encode('El formato no es valido');}
}
//-------------------------------------------------------------
function eliminarDocumento(){
  $datos=array();
  $datos['mensaje']='EL ARCHIVO SE ELIMINO CORRECTAMENTO';
  $datos['eliminarDoc']=true;
  $eliminar=explode(";",$_POST['idFuncionMP']);
  $directorio=$this->manejodocumento_modelo->obtenerDirectorio('U');
  $rutaArchivo=$directorio.'ArchivosProcedimientos/'.$eliminar[0]."/".$eliminar[1];
  $this->manejodocumento_modelo->eliminarArchivo($rutaArchivo);
  $datos['archivo']=$eliminar[1];
  $datos['eliminarArchivo']=true;
 
  echo json_encode($datos);
}
//------------------------------------------------------------
function verDocumentos(){
 $directorio="ArchivosProcedimientos/".$_POST['idFuncionMP'];
     
$datos=$this->manejodocumento_modelo->devolverDocumentosGenerico($directorio);

$documentos['idFuncionProceso']=$_POST['idFuncionMP'];
if(is_int($datos) or is_string($datos) ){$documentos['datos']="No hay documentos";$documentos['bandera']=0;}
else{$documentos['datos']=$datos;$documentos['bandera']=1;}

 
 echo json_encode($documentos);
}
//------------------------------------------------------------


function funcionProceso(){

    $this->datos['funciones']=$this->capitalhumano_model->devolverFuncionesProcesos(0);
     $this->datos['procesos']=$this->capitalhumano_model->devolverFuncionesProcesos(1);
  //$this->load->view('persona/funcionProceso',$this->datos);

}
//------------------------------------------------------------
function operacionFuncionProceso(){
  
 if($_POST['idFuncionProceso']>0){
 if($this->capitalhumano_model->actualizarFuncionProceso($_POST['idFuncionProceso'],$_POST)){
  $this->datos['mensage']='alert("actualizacion correcta")';
    $_POST['buscarFuncionProceso']=$_POST['idFuncionProceso'];
 }
  else{$this->datos['mensage']='alert("error en la actualizacion")';$_POST['buscarFuncionProceso']=$_POST['idFuncionProceso'];}
 }
 else{
$_POST['buscarFuncionProceso']=$this->capitalhumano_model->crearFuncionProceso($_POST);
 //$_POST['idFuncionProceso']=$this->capitalhumano_model->crearFuncionProceso($_POST);
 unset($_POST['idFuncionProceso']);
 unset($_POST['descripcionFP']);
 unset($_POST['clasificacionFP']);
  unset($_POST['tipoFP']);
 if($_POST['buscarFuncionProceso']>0){$this->datos['mensage']='alert("se creo correctamente el parametro")';
   $this->asignarFuncionesPuesto();
  }
 }
 echo json_encode($_POST['buscarFuncionProceso']);
 //$this->buscarFuncionProceso();
}
//------------------------------------------------------------
function buscarFuncionProceso(){
 
  $this->datos['buscarFuncionProceso']=$this->capitalhumano_model->devolverFuncionProceso($_POST['buscarFuncionProceso']);
    if($this->capitalhumano_model->devolverTipoFP($_POST['buscarFuncionProceso'])==1){
      $this->datos['funcionesProcesosAsignados']=$this->capitalhumano_model->funcionesAsignadasProcesos($_POST['buscarFuncionProceso'],1);
      $funciones=$this->capitalhumano_model->funcionesAsignadasProcesos($_POST['buscarFuncionProceso'],0);
      $cantidadFunciones=count($funciones);      
      foreach ($this->datos['funcionesProcesosAsignados'] as $key => $value) {

          foreach ($funciones as $llave => $valores) {
            if($valores->idFuncionProceso==$value->idFuncionFP){
              unset($funciones[$llave]);
            }
          }
        }           
      $this->datos['funcionesProcesosNoAsignados']=$funciones;
    }    
    $this->funcionProceso();
}

//------------------------------------------------------------
public function asignarFPU(){       
   $this->capitalhumano_model->manejaCambiosFPU($_POST['idFuncionProceso'],$_POST['idFuncionMP'],1);
   $_POST['noAJAX']=1;
   $lista="";
   $funcionesAsignadas=$this->procedimientosAsignados();
   
   $lista="<ul>";
   foreach ($funcionesAsignadas as  $value) {
   
    $lista=$lista.'<li>'.$value->descripcionFP;
    $lista=$lista.'<label>('.$value->personaPuesto.')</label>';
    $lista=$lista.'<button class="btn" onclick="subirFuncionMP('.$value->idFuncionFP.')">▲</button>';
    $lista=$lista.'<button class="btn" onclick="bajarFuncionMP('.$value->idFuncionFP.')">▼</button>';
    $lista=$lista.'<button class="btn" onclick="eliminarFuncionMP('.$value->idFuncionFP.')">X</button>';
    $lista=$lista.'</li>';
     
   }
   $lista=$lista."</ul>";  
   echo json_encode($lista);
}
//------------------------------------------------------------
function modificarFP()
{
   
    $update['descripcionFP']=$_POST['descripcionFP'];
      $respuesta=$this->capitalhumano_model->actualizarFuncionProceso($_POST['idFuncionProceso'],$update);
      if($respuesta){$respuesta="Cambios con exito";}else{$respuesta="Error en el grabado";}


        echo json_encode($respuesta);
      
}

function devolverFPUDatos(){
  $_POST['noAJAX']=1;
   $funcionesAsignadas=$this->procedimientosAsignados();
   $descripFPU=$this->capitalhumano_model->devolverDescripPFU($_POST['idFuncionMP']);     
    for($i=0;$i<count($funcionesAsignadas);$i++){
      
        $directorio="ArchivosProcedimientos/".$funcionesAsignadas[$i]->idFuncionFP;
        $documentos= $this->manejodocumento_modelo->devolverDocumentosGenerico($directorio);
        if(count($documentos)>0){
        $funcionesAsignadas[$i]->documento=$documentos;
    
        }
    }

   /*foreach ($funcionesAsignadas as  $value) {
    $directorio="ArchivosProcedimientos/".$value->idFuncionFP;
  $documentos= $this->manejodocumento_modelo->devolverDocumentosGenerico($directorio);
  
   }*/
   foreach ($descripFPU as  $value) {
       $d['idFuncionFP'] = $value->idDivContenedor;
            $d['descripcionFP'] = $value->contenido;
            $d['idPuestoFP'] = 0;
           // $d['personaPuesto'] =$value->id;
            $d['funcion'] = $value->funcion;
            $d['documento']=0;
      array_push($funcionesAsignadas, (object)$d);
   }

  

    echo json_encode($funcionesAsignadas);  
}
//------------------------------------------------------------
function devolverFPU(){
   $_POST['noAJAX']=1;
   $lista="";

   $funcionesAsignadas=$this->procedimientosAsignados();
   
      
   $lista="<ul>";
   foreach ($funcionesAsignadas as  $value) {
   
    $lista=$lista.'<li data-value="'.$value->idFuncionFP.'" onclick="escogerMatrizProcedimiento(this)"><label style="width:60%;overflow:scroll;height:60px">('.$value->descripcionFP;
    $lista=$lista.$value->personaPuesto.')</label>';
    $lista=$lista.'<button class="btn btn-primary btn-xs buttonMP" onclick="subirFuncionMP('.$value->idFuncionFP.',this)">▲</button> ';
    $lista=$lista.'<button class="btn btn-primary btn-xs  buttonMP" onclick="bajarFuncionMP('.$value->idFuncionFP.',this)">▼</button> ';
    $lista=$lista.'<button class="btn btn-primary btn-xs  buttonMP"  onclick="eliminarFuncionMP('.$value->idFuncionFP.',this)">X</button> ';
    $lista=$lista.'</li>';
     
   }
   $lista=$lista."</ul>";  
   echo json_encode($lista);  
}

//------------------------------------------------------------
public function procedimientosAsignados(){

  $datos=$this->capitalhumano_model->devolverProcedimientosAsignadasMP($_POST['idFuncionMP']);

   if(isset($_POST['noAJAX'])){return $datos; }
   else{echo json_encode($datos);}
}
//------------------------------------------------------------
function eliminarProcMP(){

    $this->capitalhumano_model->manejaCambiosFPU($_POST['idFuncionProceso'],$_POST['idFuncionMP'],0);
  echo json_encode(1);
}
//------------------------------------------------------------
public function cambioPosicionFuncion(){

   $this->capitalhumano_model->cambiarOrdenFPU($_POST['idFuncionMP'],$_POST['idFuncionProceso'],$_POST['direccion']);
     $this->devolverFPU();
    //echo json_encode(1);
}
//------------------------------------------------------------
public function devuelveFunciones(){  
    $opciones="";
    $opciones='<button class="btn btn-primary btn-xs contact-item" onclick="document.getElementById(\'divFuncionesAsignar\').classList.remove(\'ventanaFPStyle\');document.getElementById(\'divFuncionesAsignar\').innerHTML=\'\'">cerrar</button><br><br>';
     if($_GET['idPuesto']!=''){
     $funciones=$this->capitalhumano_model->devolverFuncionesProcesos(0);
     $funcionesDePuesto=$this->capitalhumano_model->devolverFuncionesDePuesto($_GET['idPuesto']);
     $opciones=$opciones.'<input type="hidden" id="idPuesto" class="asignaFPEstilo" value="'.$_GET['idPuesto'].'">';
 
     foreach ($funciones as $key => $value) {
      $band=0;
      foreach ($funcionesDePuesto as $keyPuesto => $puesto) {
        if($value->idFuncionProceso==$puesto->idFuncionProcesoFP){$band=1;}
      }
      if($band){$opciones=$opciones.'<input type="checkbox" id="funcion'.$value->idFuncionProceso.'" value="'.$value->idFuncionProceso.'" onclick="funcionesPuesto(this)" class="asignaFPEstilo" checked>'.$value->descripcionFP.'<br>';}
      else{$opciones=$opciones.'<input type="checkbox" id="funcion'.$value->idFuncionProceso.'" value="'.$value->idFuncionProceso.'" onclick="funcionesPuesto(this)">'.$value->descripcionFP.'<br>';}
     }
     $opciones=$opciones.'<br><button class="btn-primary" onclick="enviaForm(3)">Guardar</button>';
    }
    else{ $opciones=$opciones.'<h1>Seleccionar un puesto para ver las funciones</h1>';}
    echo json_encode($opciones);
}
//-----------------------------------------------------------
public function asignarFuncionesPuesto()
 {
  $idPuesto=$_POST['idPuesto'];
  unset($_POST['idPuesto']);
       $this->capitalhumano_model->asignarFuncionesPuesto($idPuesto,$_POST);
 }

//-----------------------------------------------------------
public function devolverFuncionesAsignadas(){
   
   $datos=$this->capitalhumano_model->devolverFuncionesAsignadasPuesto($_GET['idPuesto']);
     $opciones="";
     $opciones='<button class="btn btn-primary btn-xs contact-item" onclick="document.getElementById(\'divFuncionesAsignar\').classList.remove(\'ventanaFPStyle\');document.getElementById(\'divFuncionesAsignar\').innerHTML=\'\'">cerrar</button><br><br>';
      
   if(count($datos)>0){
       foreach ($datos as $key => $value) {
        $opciones=$opciones.'<label class="labelFAP btn">->'.$value->descripcionFP.'</label><br>';
       }
   }
   else
   {
      $opciones=$opciones.'<h1>Este puesto no tiene funciones asignadas</h1>';
   }
    echo json_encode($opciones);
}

//-----------------------------------------------------------
function agregarProcedimientos(){   

  $idFuncionProceso=$this->capitalhumano_model->agregarProcedimientos($_POST);
  echo json_encode($idFuncionProceso);
}
//-----------------------------------------------------------
function agregarPasos(){

}
//-----------------------------------------------------------
function devolverProcedimientosFuncion(){
   echo json_encode($this->capitalhumano_model->devolverProcedimientosFuncion($_POST['idFuncionProceso']));
}
//-----------------------------------------------------------
function devolverDescripPF()
{ $dirLocal=$this->manejodocumento_modelo->obtenerDirectorio('U').'ArchivosProcedimientos/'.$_POST['idFuncionProceso'].'/Diagrama';
  $directorio="ArchivosProcedimientos/".$_POST['idFuncionProceso'];
  $documentos= $this->manejodocumento_modelo->devolverDocumentosGenerico($directorio);
 
  $cantidad=count($documentos);
  $archivos['archivos']=(object)$documentos;
  $archivos['funcion']="2";
  $archivos['cantidad']=$cantidad;
  $archivos['idFuncionProceso']=$_POST['idFuncionProceso'];
  $archivoDiagrama=$this->manejodocumento_modelo->obtenerArchivosDelDirectorio($dirLocal);

  if($archivoDiagrama!=""){ $diagrama['diagrama']=base_url().$directorio.'/Diagrama/'.$archivoDiagrama[0];}
  else{$diagrama['diagrama']="";}
  $diagrama['funcion']="3";

    $datos=$this->capitalhumano_model->devolverDescripPF($_POST['idFuncionProceso']);

    array_push($datos,(object)$archivos);        
    array_push($datos,(object)$diagrama);
   //
  
  echo json_encode($datos);
}
//-----------------------------------------------------------
function agregarPasosProcedimiento(){
  
}
//-----------------------------------------------------------

public function grabarManualProcedimientoMP(){
  $idFuncionProceso=$_POST['idFuncionProceso'];
  //unset($_POST['idFuncionProceso']);
   
  $this->capitalhumano_model->borrarManualProcedimiento($idFuncionProceso); 
  $this->capitalhumano_model->grabarManualProcedimiento($idFuncionProceso,'divContODPProc',$_POST['divContODPProc']);
  $this->capitalhumano_model->grabarManualProcedimiento($idFuncionProceso,'divContAPProc',$_POST['divContAPProc']);
  $this->capitalhumano_model->grabarManualProcedimiento($idFuncionProceso,'divContRAProc',$_POST['divContRAProc']);
  $this->capitalhumano_model->grabarManualProcedimiento($idFuncionProceso,'divContDTAProc',$_POST['divContDTAProc']);
  $this->capitalhumano_model->grabarManualProcedimiento($idFuncionProceso,'divContPPProc',$_POST['divContPPProc']);
  $this->datos['pestania']="divProcesos";
  $this->datos['selectOpcionProc']="divCapturaMP";
  //$this->datos['selectCapturaFuncion']=$_POST['selectCapturaFuncion'];
  $this->datos['selectCapturaMP']=$idFuncionProceso;
  echo json_encode($this->datos);

}
//-----------------------------------------------------------
public function grabarManualProcedimiento(){
  $idFuncionProceso=$_POST['idFuncionProceso'];
  //unset($_POST['idFuncionProceso']);
   
  $this->capitalhumano_model->borrarManualProcedimiento($idFuncionProceso); 
  $this->capitalhumano_model->grabarManualProcedimiento($idFuncionProceso,'divContODPProc',$_POST['divContODPProc']);
  $this->capitalhumano_model->grabarManualProcedimiento($idFuncionProceso,'divContAPProc',$_POST['divContAPProc']);
  $this->capitalhumano_model->grabarManualProcedimiento($idFuncionProceso,'divContRAProc',$_POST['divContRAProc']);
  $this->capitalhumano_model->grabarManualProcedimiento($idFuncionProceso,'divContDTAProc',$_POST['divContDTAProc']);
  $this->capitalhumano_model->grabarManualProcedimiento($idFuncionProceso,'divContPPProc',$_POST['divContPPProc']);
  $this->datos['pestania']="divProcesos";
  $this->datos['selectOpcionProc']="divCapturaFuncion";
  $this->datos['selectCapturaFuncion']=$_POST['selectCapturaFuncion'];
  $this->datos['selectCapturaProc']=$idFuncionProceso;
     $this->datos['vista']="verPuestoDiv";
   $this->datos['manejoPestanias']="divProcesos";

  $this->buscarPuesto();

}
//-----------------------------------------------------------
public function imprimirTodoElManual(){
       $html="";$pdf="";$nombre="";    
       $matrizProc=$this->capitalhumano_model->devolverFuncionesAsignadasPuesto($_POST['idPuesto']);
       $nombrePuesto=$this->capitalhumano_model->buscarPuesto($_POST['idPuesto'])->personaPuesto;
     
       foreach ($matrizProc as  $value) 
       {
         $procedimientosFuncion=$this->capitalhumano_model->devolverProcedimientosFuncion($value->idFuncionProcesoFP);
        $nombreFuncion=$this->capitalhumano_model->devolverFuncionProceso($value->idFuncionProcesoFP)->descripcionFP;
           $html.='<section><div>Puesto: '.$nombrePuesto.'</div>';
           $html.='<div>Funcion: '.$nombreFuncion.'</div>';            
         foreach ($procedimientosFuncion as  $valuePF) 
          {
           $nombreProceso="";  
        $nombreProceso=$this->capitalhumano_model->devolverFuncionProceso($valuePF->idFuncionProceso)->descripcionFP;      
        $manual=$this->capitalhumano_model->devolverManualPocedimientos($valuePF->idFuncionProceso);

       
        $pasosProceso=$this->capitalhumano_model->devolverPasosDelProcedimiento($valuePF->idFuncionProceso);
        $html.='<section><div>Puesto: '.$nombrePuesto.'</div>';
        $html.='<div>Funcion: '.$nombreFuncion.'</div>';
        $html.='<div>Proceso: '.$valuePF->descripcionFP.'</div>';  
        $dirLocal=$this->manejodocumento_modelo->obtenerDirectorio('U').'ArchivosProcedimientos/'.$valuePF->idFuncionProceso.'/Diagrama'; 
          $archivoDiagrama=$this->manejodocumento_modelo->obtenerArchivosDelDirectorio($dirLocal);
     
     foreach ($manual as  $valueM) {
          $html.='<div style=\'border:solid;color:white;background-color:#6b6b6b\'>'.$valueM->descripcionMUP.'</div>';
          $html.='<div>'.$valueM->contenido.'</div>';
          if($valueM->descripcionMUP=='POLITICAS DE PROCEDIMIENTO'){
            $html.='<div style=\'border:solid;color:white;background-color:#6b6b6b\'>DIAGRAMA DE PROCEDIMIENTOS</div>';
                     if($archivoDiagrama!=""){ 
             $diagrama='ArchivosProcedimientos/'.$valuePF->idFuncionProceso.'/Diagrama/'.$archivoDiagrama[0];
             $html.='<div style=\'width:600px;height:300px\'><img src="'.$diagrama.'"  style="width:600px;height:300px"></div>';} 
                                                  
          }
  }
  $html.='<div style=\'border:solid;color:white;background-color:#6b6b6b\'>DESCRIPCION DEL PROCEDIMIENTO</div>';
  $html.='<div><table border=\'1\'><tr><td>#</td><td>Responsable</td><td>Actividad</td><td>Formato o Anexo</td></tr>';
  $cont=0;
  foreach ($pasosProceso as  $valuePP) {
    $cont=$cont+1;
    $html=$html.'<tr>';
    $html=$html.'<td>'.$cont.'</td>';
    $html=$html.'<td>'.$nombrePuesto.'</td>';
    $html=$html.'<td>'.$valuePP->descripcionFP.'</td>';
    $html=$html.'<td></td>';
    $html=$html.'</tr>';
  }
  $directorio="";$documentos="";
  $directorio="ArchivosProcedimientos/".$valuePF->idFuncionProceso;
  $documentos= $this->manejodocumento_modelo->devolverDocumentosGenerico($directorio);    
    $html.='<tr><td colspan=\'4\'>';
  if(is_array($documentos)){foreach ($documentos as  $valueD) {$html.=base_url().$directorio.'/'.$valueD.'<br>';}}
   $html.='</td></tr></table></section><hr style="page-break-after: always;border: 0;margin: 0;padding: 0;"';    
         }
       }
  $nombre=$nombrePuesto;
    
    
  $this->load->library('mydompdf');
  $this->mydompdf->load_html($html);
  $this->mydompdf->set_paper('A4','portrait');
  $this->mydompdf->render();
  $this->mydompdf->stream($nombre.".pdf", array("Attachment" => false));
}
//-----------------------------------------------------------
function muestraImagen(){
  $html='<div>imagen</div>';
  $html.='<img src="http://192.168.0.100/Capsys/www/V3/ArchivosProcedimientos/193/Diagrama/193.bmp">';
  $html.='<img src="ArchivosProcedimientos/193/Diagrama/193.bmp">';
  $html.='<img src="V3/ArchivosProcedimientos/193/Diagrama/193.bmp" style="width:100px;height:150px">'; 
  $nombreAleatorio=$this->libreriav3->numeroAleatorioHexadecimal();
  $this->load->library('mydompdf');
  $this->mydompdf->load_html($html);
  $this->mydompdf->set_paper('A4','portrait');
  $this->mydompdf->render();
  $this->mydompdf->stream($nombreAleatorio.".pdf", array("Attachment" => false));
}
//-----------------------------------------------------------

public function  generaPDF(){
  //$this->load->library('dompdf/lib/Cpdf'); 
          
  $html="";$pdf="";$nombre="";
  if(!isset($_POST['selectCapturaFuncion'])){
  $manual=$this->capitalhumano_model->devolverPartesManualUsuario($_POST['idPuesto']);
  $nombrePuesto=$this->capitalhumano_model->buscarPuesto($_POST['idPuesto']);
  $html="";
  foreach ($manual as  $value) {
    $html=$html.'<div style=\'border:solid;color:white;background-color:#6b6b6b\'>'.$value->descripcionMUP.'</div>';
    $html=$html.'<div>'.$value->contenido.'</div>';
  }
    $nombre=$nombrePuesto->personaPuesto;//"manualUsuario";
    //$html="<div>prueba</prueba>";
    
   }else{
    $nombreFuncion=$this->capitalhumano_model->devolverFuncionProceso($_POST['selectCapturaFuncion'])->descripcionFP;
    $nombreProceso=$this->capitalhumano_model->devolverFuncionProceso($_POST['selectCapturaProc'])->descripcionFP;
    $nombrePuesto=$this->capitalhumano_model->buscarPuesto($_POST['idPuesto'])->personaPuesto;
    $manual=$manual=$this->capitalhumano_model->devolverManualPocedimientos($_POST['selectCapturaProc']);
    $pasosProceso=$this->capitalhumano_model->devolverPasosDelProcedimiento($_POST['selectCapturaProc']);
    $html=$html.'<div>Puesto: '.$nombrePuesto.'</div>';
    $html=$html.'<div>Funcion: '.$nombreFuncion.'</div>';
    $html=$html.'<div>Proceso: '.$nombreProceso.'</div>';
 
     foreach ($manual as  $value) {
    $html=$html.'<div style=\'border:solid;color:white;background-color:#6b6b6b\'>'.$value->descripcionMUP.'</div>';
    $html=$html.'<div>'.$value->contenido.'</div>';
  }
  $html=$html.'<div style=\'border:solid;color:white;background-color:#6b6b6b\'>DESCRIPCION DEL PROCEDIMIENTO</div>';
  $html=$html.'<div><table border=\'1\'><tr><td>#</td><td>Responsable</td><td>Actividad</td><td>Formato o Anexo</td></tr>';
  $cont=0;
  foreach ($pasosProceso as  $value) {
    $cont=$cont+1;
     $html=$html.'<tr>';
    $html=$html.'<td>'.$cont.'</td>';
    $html=$html.'<td>'.$nombrePuesto.'</td>';
    $html=$html.'<td>'.$value->descripcionFP.'</td>';
    $html=$html.'<td></td>';
     $html=$html.'</tr>';
  }
  $directorio="";$documentos="";
      $directorio="ArchivosProcedimientos/".$_POST['selectCapturaProc'];
  $documentos= $this->manejodocumento_modelo->devolverDocumentosGenerico($directorio);
    
    $html=$html.'<tr>';
  $html=$html.'<td colspan=\'4\'>';
  if(is_array($documentos)){
  foreach ($documentos as  $value) {
     $html=$html.base_url().$directorio.'/'.$value.'<br>';
  }}
 $html=$html.'</td>';
  $html=$html.'</tr>';
    $nombre=$nombrePuesto.'-'.$nombreFuncion.'-'.$nombreProceso;



   }
  //$pdf='<html>';$pdf.='<head>';$pdf.='<style>';$pdf.='</style>';$pdf.='</head>';$pdf.='<body>';$pdf.='<h1>Ejemplo de generacion de un pdfr</h1>';$pdf.='Almacen todo lo que quieras en una variable imagenes textos listas';$pdf.='</body>';$pdf.='</html>';
  $this->load->library('mydompdf');
  $this->mydompdf->load_html($html);
  $this->mydompdf->set_paper('A4','portrait');
  $this->mydompdf->render();
  $this->mydompdf->stream($nombre.".pdf", array("Attachment" => false));
}

//-------------------------------------------------------------------------------------------------------------------------------
public function guardarManualUsuario(){
  $this->capitalhumano_model->borrarManualUsuario($_POST['idPuesto']);

  $delete = "DELETE FROM job_description WHERE idPuesto = ".$_POST['idPuesto']."";
  $this->db->query($delete);

  $idPuesto=$_POST['idPuesto'];
  unset($_POST['idPuesto']);
  foreach ($_POST as $key => $value) {
    
    if($key == "forNewTable"){

      $insert = "INSERT INTO job_description(idPuesto, mision) VALUES(".$idPuesto.", '".$value."')";
      $this->db->query($insert);
    } else{
      $this->capitalhumano_model->grabarManualUsuario($idPuesto,$key,$value);
    }

  }
	/*
	$this->capitalhumano_model->borrarManualUsuario($idPuesto);
	$this->capitalhumano_model->grabarManualUsuario($idPuesto,'divContenidoPRP',$_POST['divContenidoPRP']);
	$this->capitalhumano_model->grabarManualUsuario($idPuesto,'divContenidoPP',$_POST['divContenidoPP']);
	$this->capitalhumano_model->grabarManualUsuario($idPuesto,'divContenidoMP',$_POST['divContenidoMP']);
	$this->capitalhumano_model->grabarManualUsuario($idPuesto,'divContenidoFPR',$_POST['divContenidoFPR']);
	$this->capitalhumano_model->grabarManualUsuario($idPuesto,'divContenidoAGT',$_POST['divContenidoAGT']);
	$this->capitalhumano_model->grabarManualUsuario($idPuesto,'divContenidoCTD',$_POST['divContenidoCTD']);
	$this->capitalhumano_model->grabarManualUsuario($idPuesto,'divContenidoPER',$_POST['divContenidoPER']);
	$this->capitalhumano_model->grabarManualUsuario($idPuesto,'divContenidoNCBC',$_POST['divContenidoNCBC']);
	$this->capitalhumano_model->grabarManualUsuario($idPuesto,'divContenidoPO',$_POST['divContenidoPO']);
	$this->capitalhumano_model->grabarManualUsuario($idPuesto,'divContenidoDIO',$_POST['divContenidoDIO']);
	//$this->capitalhumano_model->grabarManualUsuario($idPuesto,'buscarIdPuesto',$_POST['buscarIdPuesto']);*/
	 $this->datos['pestania']="divManual";
	  $_POST['buscarIdPuesto']=$idPuesto;
	 echo json_encode($this->datos);
}
//-----------------------------------------------------------

public function guardarManualUsuario_respaldo(){
  $this->capitalhumano_model->borrarManualUsuario($_POST['idPuesto']);
  $idPuesto=$_POST['idPuesto'];
  unset($_POST['idPuesto']);
  foreach ($_POST as $key => $value) {$this->capitalhumano_model->grabarManualUsuario($idPuesto,$key,$value);}
  /*
  $this->capitalhumano_model->borrarManualUsuario($idPuesto);
  $this->capitalhumano_model->grabarManualUsuario($idPuesto,'divContenidoPRP',$_POST['divContenidoPRP']);
  $this->capitalhumano_model->grabarManualUsuario($idPuesto,'divContenidoPP',$_POST['divContenidoPP']);
  $this->capitalhumano_model->grabarManualUsuario($idPuesto,'divContenidoMP',$_POST['divContenidoMP']);
  $this->capitalhumano_model->grabarManualUsuario($idPuesto,'divContenidoFPR',$_POST['divContenidoFPR']);
  $this->capitalhumano_model->grabarManualUsuario($idPuesto,'divContenidoAGT',$_POST['divContenidoAGT']);
  $this->capitalhumano_model->grabarManualUsuario($idPuesto,'divContenidoCTD',$_POST['divContenidoCTD']);
  $this->capitalhumano_model->grabarManualUsuario($idPuesto,'divContenidoPER',$_POST['divContenidoPER']);
  $this->capitalhumano_model->grabarManualUsuario($idPuesto,'divContenidoNCBC',$_POST['divContenidoNCBC']);
  $this->capitalhumano_model->grabarManualUsuario($idPuesto,'divContenidoPO',$_POST['divContenidoPO']);
  $this->capitalhumano_model->grabarManualUsuario($idPuesto,'divContenidoDIO',$_POST['divContenidoDIO']);
  //$this->capitalhumano_model->grabarManualUsuario($idPuesto,'buscarIdPuesto',$_POST['buscarIdPuesto']);*/
   $this->datos['pestania']="divManual";
   $this->datos['vista']="verPuestoDiv";
   $this->datos['manejoPestanias']="divManual";
    $_POST['buscarIdPuesto']=$idPuesto;

   $this->buscarPuesto();
}

//-----------------------------------------------------------
public function devuelveManualUsuario(){

}

//-----------------------------------------------------------
public function EliminarPF(){
  /*NO BORRA LA FUNCION SOLO CAMBIA EL STATUS A NO VISIBLE*/
  $update['statusFP']=0;
  $this->capitalhumano_model->actualizarFuncionProceso($_POST['idFuncionProceso'],$update);
  echo json_encode(true);

}

//-----------------------------------------------------------
function traePFParaMatriz(){
  /*SIRVE PARA LLEVAR LAS FUNCIONES PARA ASIGNAR A LOS  PROCEDMIENTOS*/

     $funciones=$this->capitalhumano_model->devolverFuncionesAsignadasPuesto($_POST['idFuncionProceso']);
   $lista="";
   foreach ($funciones as  $value) {
    $lista=$lista.'<ul class="ulMP mpOcultar"><label onclick="listaMatrizProc(this)" class="labelLlaveMP btn-xs">+</label><label class="labelMP">'.$value->descripcionFP.'</label>';
    $hijos=$this->capitalhumano_model->devolverProcedimientosFuncion($value->idFuncionProcesoFP);
       
        foreach ($hijos as  $id) {
          $lista=$lista.'<li>'.$id->descripcionFP.'<button class="btn btn-primary btn-xs" onclick="asignarMP('.$id->idFuncionProceso.')">-></button></li>';
         
         } 
    $lista=$lista.'</ul>';
    
   }

   echo json_encode($lista);
  
}
//-----------------------------------------------------------
function nuevoMP()
{
  /*AGREGA UNA NUEVA MATRIZ DE PROCEDIMIENTO POR PUESTO*/

  $_POST['buscarFuncionProceso']=$this->capitalhumano_model->crearFuncionProceso($_POST);
 //$_POST['idFuncionProceso']=$this->capitalhumano_model->crearFuncionProceso($_POST);
 unset($_POST['idFuncionProceso']);
 unset($_POST['descripcionFP']);
 unset($_POST['clasificacionFP']);
  unset($_POST['tipoFP']);
 if($_POST['buscarFuncionProceso']>0)
  {
  //$this->datos['mensage']='alert("se creo correctamente el parametro")';
  $idPuesto=$_POST['idPuesto'];
     $this->asignarFuncionesPuesto();
     $matrizProc=$this->capitalhumano_model->devolverMatrizAsignadaPuesto($idPuesto);

    $option="";
    foreach ($matrizProc as $value) {
      $option=$option.'<option value="'.$value->idFuncionProcesoFP.'">'.$value->descripcionFP.'</option>';
    }
    echo json_encode($option);
  }

}
//------------------------------------------------------------
//******** Modificacion Miguel Jaime 21/10/2020*********
  function guardar_organigrama(){
     $mi_archivo = 'organigrama';
    $directorio=$this->manejodocumento_modelo->obtenerDirectorio("U"); //'C:/wamp64/www/Capsys/www/V3/';
     $rutaTotal=$directorio."assets/documentos/capitalHumano/organigrama";
     $rutaAlmacenaje=$rutaTotal."/".str_replace("1","",$this->input->post("rutaArchivo",true));
     $config['upload_path'] = $rutaAlmacenaje;
     $config['file_name'] =  str_replace(" ","_",$_FILES['organigrama']['name']);
     $config['allowed_types'] = "*";
     $config['max_size'] = "5000000";
     $config['max_width'] = "200000";
     $config['max_height'] = "200000";
    $config['overwrite'] = "TRUE";
     $this->load->library('upload', $config);
     if (!$this->upload->do_upload($mi_archivo)) {
        $data['uploadError'] = $this->upload->display_errors();
      $data['message'] = "PROBLEMAS AL PROCESAR EL ARCHIVO";
     }
    else {
     $data['uploadSuccess'] = $this->upload->data();
      $data['registro'] = array(
        'url_imagen' => str_replace(" ","_",$data['uploadSuccess']['file_name'])
      );
      $this->capitalhumano_model->guardar_organigrama($data['registro']);
      $data['message'] = "GUARDADO";
    }
    $data['file'] = $_FILES['organigrama'];
    //redirect('capitalHumano');
    echo json_encode($data);
  }
//******************************

//*** Modificacion Miguel Jaime 04/08/2021
  function guardar_documento(){

  $validRepository = $this->input->post('chkasignar',TRUE) == "general";
     $mi_archivo = 'documento';
    $directorio=$this->manejodocumento_modelo->obtenerDirectorio("U"); //'C:/wamp64/www/Capsys/www/V3/';
     $rutaTotal=$directorio."assets/documentos/capitalHumano";
     $rutaAlmacenaje=$rutaTotal."/".str_replace("1","",$this->input->post("rutaArchivo",true));
     $config['upload_path'] = $rutaAlmacenaje;
     $config['file_name'] =  str_replace(" ","_",$_FILES['documento']['name']);
     $config['allowed_types'] = "*";
     $config['max_size'] = "50000";
     $config['max_width'] = "2000";
     $config['max_height'] = "2000";
    $config['overwrite'] = "TRUE";
     $this->load->library('upload', $config);
     if (!$this->upload->do_upload($mi_archivo)) {
        $data['uploadError'] = $this->upload->display_errors();
      $data['message'] = "PROBLEMAS AL PROCESAR EL ARCHIVO";
    }
    else {
    $data['uploadSuccess'] = $this->upload->data();
      $data['registro'] = array(
        'propietario' => strtoupper($this->input->post('propietario',TRUE)),
        'nombre' => strtoupper($this->input->post('nombre',TRUE)),
        'carpeta'=>str_replace("1","raiz",$this->input->post("rutaArchivo",true)),
        'url' => str_replace(" ","_",$data['uploadSuccess']['file_name']), //str_replace(" ","_",$_FILES['documento']['name']),
        'idPuesto' => $validRepository ? null : strtoupper($this->input->post('puesto_documento',TRUE)),
      );
      $this->documentos_capitalhumano_model->guardar_documento($data['registro']);
      $data['message'] = "GUARDADO";
    }
    $data['file'] = $_FILES['documento'];
    $data['uploadInfo'] = $config;
    //redirect('capitalHumano');
    echo json_encode($data);
  }




//----------------------------------------------------------
function borrar_documento($id){
  $this->documentos_capitalhumano_model->borrar_documento($id);
  redirect('capitalHumano');
}



//-----------------------------------------------------------
function aumentoDecrementoPuesto()
{
  
  $this->PersonaModelo->aumentaDecrementapersonapuestogrupo($_POST['idPersonaPuestoGrupo'],$_POST['aumentodecremento']);
  $this->index();
}

//-----------------------------------------------------------
function creaPuestoHomonimo()
{
  $insert['idPersonaPuestoGrupo']=-1;
  $insert['personaPuestoGrupo']=$_POST['personaPuestoGrupo'];
  $this->PersonaModelo->personapuestogrupo($insert);
  $data['success'] = true;
  // $direccion='Location:'.base_url()."capitalHumano";
  // header($direccion);
  echo json_encode($data);
}
//----------------------------------------------- //Dennis Castillo [2022-03-15]
function eliminar_documento(){

  $select=$this->documentos_capitalhumano_model->selectDoc($_GET["q"]);
  $directorio=$this->manejodocumento_modelo->obtenerDirectorio("U"); //U

  //$rutaTotal=$_SERVER["DOCUMENT_ROOT"]."/Capsys/www/V3/assets/documentos/capitalHumano";
  $rutaTotal=$directorio."assets/documentos/capitalHumano";
  $deleteRuta="";
  $respuesta=array();

  $countRegister = $this->documentos_capitalhumano_model->countFilesRegisters(array(
    "propietario" => $select->propietario, "nombre" => $select->nombre, "carpeta" => $select->carpeta, "url" => $select->url, "idPuesto" => $select->idPuesto
  ));

  if(!empty($countRegister) && !empty($select)){

    if($countRegister->total == 1){

      $deleteRuta = $select->carpeta == "materialDidactico" ? $rutaTotal."/".$select->carpeta."/".$select->url : $rutaTotal."/".$select->url;
      $eliminar = unlink($deleteRuta);
    }

    $delete = $this->documentos_capitalhumano_model->eliminaDoc($_GET["q"]);
    $respuesta["bool"] = $delete;
    $respuesta["mensaje"] = $delete ? "Archivo eliminado correctamente" : "No se eliminó correctamente el archivo";
  }
  
  echo json_encode($respuesta); //$respuesta
}

//----------------------------------------------
function devolverProximoDiaHabil($dia)
{  
  try{ 
  $bandBuscarDiaLaboral=true;
 while($bandBuscarDiaLaboral==true)
 {
      $consulta='select * from dianolaboral where diaNoLaboral="'.$dia.'"';
      $datos=$this->db->query($consulta)->result();      
      if(count($datos)>0){$bandBuscarDiaLaboral=true;}
      else
      {
       $diaDeLaSemana=date("w",strtotime($dia));
       if($diaDeLaSemana==0 || $diaDeLaSemana==6){$bandBuscarDiaLaboral=true;}
       else{$bandBuscarDiaLaboral=false;}
      }
     if($bandBuscarDiaLaboral==true){$dia=date("Y-m-d",strtotime($dia."+ 1 days"));}

  }
  return $dia;
 }catch(Exception $e)
 {
   return $e->getMessage();
 }
}
//---------------------------------------------
function guardarPeriocidad()
{
  
  $datos['success']=true;
  $datos['mensaje']='El guardado fue un exito';
  if($_POST['tipoPeriocidad']=='Fecha' and $_POST['fechaPeriocidad']==''){$datos['success']=false;$datos['mensaje']='Escoger una fecha';}
  else
  {
    $idPersona=$this->db->query('select idPersona from personapuesto where idPuesto='.$_POST['idPuesto'])->result()[0]->idPersona;
    $descripcionProceso=$this->db->query('select descripcionFP from funcionproceso fp where fp.idFuncionProceso='.$_POST['idProcedimiento'])->result()[0]->descripcionFP;
    //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($_POST, TRUE));fclose($fp);     
   if($_POST['tipoPeriocidad']=='Fecha')
   {
     $fecha=explode('-', $_POST['fechaPeriocidad']);
      
     $fechaDia=$fecha[2];
     $fechaAnio=$fecha[0];
     for($i=1;$i<=12;$i++)
     {
      $fechaEntrega=$fechaAnio.'-'.$i.'-'.$fechaDia;
      $insert['nombre']=$descripcionProceso.'( '.$fechaEntrega.' )';
      $insert['identificaProyectoAutomatico']='PROCEDIMIENTO_DE_PUESTOS';
      $insert['usuario']=$idPersona;
      $insert['tituloProyecto']='PROCEDIMIENTO DE PUESTOS';
      $insert['idTablaParaTarea']=$_POST['idProcedimiento'];
      $insert['tablaParaTarea']='funcionproceso';
      $insert['fechaentrega']=$fechaEntrega;
      $validaFecha=$this->devolverProximoDiaHabil($fechaEntrega);
      if($fechaEntrega!=$validaFecha){$insert['nombre']=$descripcionProceso.'( '.$fechaEntrega.' DIA INHABIL, POSPUESTO PARA '.$validaFecha.' )';$insert['fechaentrega']=$validaFecha;}
      $this->modeloproyecto->crearProyectoAutomatico($insert);
        
     }

   }
   else
   {
    $fecha=getdate();    
    $fechaInicio=strtotime($fecha['year']."-01-01");
     $fechaFin=strtotime($fecha['year']."-12-31");
    for($i=$fechaInicio; $i<=$fechaFin; $i+=86400)
    {    
     $dia = date('N', $i);
     if($dia==$_POST['diaPeriocidad'])
     {
        //echo "Lunes. ". date ("Y-m-d", $i)."<br>";
        //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r(date ("Y-m-d", $i), TRUE));fclose($fp);      
      $fechaEntrega=date ("Y-m-d", $i);
      $insert['nombre']=$descripcionProceso.'( '.$fechaEntrega.' )';
      $insert['identificaProyectoAutomatico']='PROCEDIMIENTO_DE_PUESTOS';
      $insert['usuario']=$idPersona;
      $insert['tituloProyecto']='PROCEDIMIENTO DE PUESTOS';
      $insert['idTablaParaTarea']=$_POST['idProcedimiento'];
      $insert['tablaParaTarea']='funcionproceso';
      $insert['fechaentrega']=$fechaEntrega;
      $validaFecha=$this->devolverProximoDiaHabil($fechaEntrega);
      if($fechaEntrega!=$validaFecha){$insert['nombre']=$descripcionProceso.'( '.$fechaEntrega.' DIA INHABIL, POSPUESTO PARA '.$validaFecha.' )';$insert['fechaentrega']=$validaFecha;}
      $this->modeloproyecto->crearProyectoAutomatico($insert);
      }
    }
   }
  }
  echo json_encode($datos);
}
//----------------------------------------------
function f()
{
  $fechaInicio=strtotime("2021-01-01");
$fechaFin=strtotime("2021-12-31");
    $fecha=getdate();    
    $fechaInicio=strtotime($fecha['year']."-01-01");
     $fechaFin=strtotime($fecha['year']."-12-31");
//Recorro las fechas y con la función strotime obtengo los lunes
for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
    //Sacar el dia de la semana con el modificador N de la funcion date
    $dia = date('N', $i);
    if($dia==3){
        echo "Lunes. ". date ("Y-m-d", $i)."<br>";
    }
}
}
//-----------------------------------------
function datosParaCapital()
{
    $permiso  = $this->PersonaModelo->permisosPersona('VerTodosLosPuestos');

    if(isset($permiso['value'])){
    $this->datos['puestos'] = $this->capitalhumano_model->devolverPuestos(1);
  } else {
    $this->datos['puestos'] = $this->capitalhumano_model->devolverPuestos(null);
  }

    $this->datos['puestosTodos']=$this->capitalhumano_model->devolverPuestos(1);
   #$this->datos['organigrama']=$this->capitalhumano_model->crearOrganigrama();
    $this->datos['anios']=$this->libreriav3->devolverAnios();
    $this->datos['meses']=$this->libreriav3->devolverMeses();
    $this->datos['mapa']=$this->capitalhumano_model->get_organigrama();
    $this->datos["area"] = $this->PersonaModelo->colaboradorarea(null);

    //***Modificaciones 14-jun 2021
    //$this->datos['documentospuesto']=$this->documentos_capitalhumano_model->get_documentos_puesto($this->tank_auth->get_idPersona());
    //$this->datos['documentospuestoasignados']=$this->documentos_capitalhumano_model->get_documentos_puesto_asignados();
    
    //$this->datos['documentos']= array_filter($this->documentos_capitalhumano_model->get_documentos(), function($arr){ return is_null($arr->idPuesto);});
    $this->datos['puestosGrupos']=$this->PersonaModelo->personapuestogrupo(null);
    $this->datos['colaboradorConPuesto']=$this->PersonaModelo->devolverColaboradorConPuesto();
    $permiso=$this->PersonaModelo->permisosPersona('agregarPuestos');

    //visor de documentos de DRIVE Tic Consultores
  $this->datos['puestoUsuario']=$this->tank_auth->get_idPersonaPuesto();
    $this->datos['IdUsuario']=$this->tank_auth->get_idPersona();
    $this->datos['permisoAgregar']=$permiso['valor'];
     
    //$this->datos['organigrama']=$this->capitalhumano_model->crearOrganigrama(); 
     
    
    
}
//----------------------------- //Dennis Castillo [2022-03-23]
function getEmployeeData(){

  $id = $_GET["id"];
  $data = $this->employeeData($id);

  echo json_encode($data);
}
//----------------------------- //Dennis Castillo [2022-03-23]
function employeeData($id){

  return $this->capitalhumano_model->getEmployeeData($id);
}
//----------------------------- //Dennis Castillo [2022-03-23]
function manageEmployeeDoc(){ //Modificado [Suemy][2024-06-20]

  //$okk = $this->input->post("downloadLink");
  
  $response = array();

  switch($_POST["process"]){
    case "insert": 
    $idPuesto = isset($_POST['idPuesto']) ? $_POST['idPuesto'] : "";

    $response = $this->insertRegister($_POST,$idPuesto);
    break;
  }

  echo json_encode($response);
}
//----------------------------- //Dennis Castillo [2022-03-23]
function insertRegister($array,$idPuesto=''){


  $fileData = json_decode($array["fileData"]);
  
  $arrayInsert = array(
    "downloadURL" => $array["downloadLink"],
    "whoUploadFile" => $this->tank_auth->get_usermail(),
    "dateInsert" => date("Y-m-d H:i:s"),
    "document" => $fileData->name,
    "folder" => $fileData->typeDoc,
    "tag" => $fileData->tag,
    "idEmployee" => $fileData->employeId,
    "subDirectory" => $fileData->subDirectory,
    
  );
  if($idPuesto!='')
  {

    $arrayInsert['idPuestoPersona']=$idPuesto;
    $arrayInsert['idEmployee']=$idPuesto;
    $consultaId="select idPersona from personapuesto where idPuesto=".$idPuesto; 
    $arrayInsert['idPersona']=$this->db->query($consultaId)->result()[0]->idPersona;         
  }

  $insert = $this->capitalhumano_model->insertRegister("capital_humano_documentos_de_puestos", $arrayInsert);
  $message = $insert ? "Documento subido con éxito" : "Ocurrió un error en el momento de la carga.\nFavor de contactar al departamento de sistemas";

  return array("bool" => $insert, "message" => $message);
}
//----------------------------- //Dennis Castillo [2022-03-23]
function docsAndFormats(){

  $id = $_GET["id"];
  $docsAndFormats = $this->getDocsAndFormats($id);

  echo json_encode($docsAndFormats);
}
//----------------------------- //Dennis Castillo [2022-03-23]
function getDocsAndFormats($id){

  $getData = $this->capitalhumano_model->getAllDocsAndFormats($id);
  return $getData;
}
//----------------------------- //Dennis Castillo [2022-03-23]
function deleteDocs(){

  $array = json_decode($_POST["forDelete"]);
  $delete = $this->capitalhumano_model->deleteDocsAndFormat($array);
  //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($array, TRUE));fclose($fp); 

  echo json_encode(array("bool" => $delete));
}
//----------------------------- //Dennis Castillo [2022-03-23]
function getAllEmployeeInfo(){

  $id = $_GET["dni"];
  $getData = $this->getEmployeeInfo($id);

  echo json_encode($getData);
}
//----------------------------- //Dennis Castillo [2022-03-23]
function getEmployeeInfo($id){

  $getData = $this->capitalhumano_model->getEmployeeInfo($id);
  
  return $getData;
}
//----------------------------- //Dennis Castillo [2022-03-23] | Mofificado [Suemy][2024-11-06]
function getRepositories(){
  $email = $this->tank_auth->get_usermail();
  $getData = $this->capitalhumano_model->getRepositories();
  $active = $this->getPermissionDocumentsEmployees(2);
  $repositories = array();
  if ($active == 2) {
    foreach ($getData as $val) {
      $val->descargar = 1;
      if ($val->id == 1 || $val->id == 9 || $val->id == 10) {
        $val->descargar = 0;
        array_push($repositories, $val);
      }
    }
  }
  $data = $active == 1 ? $getData : $repositories;
  echo json_encode($data);
}
//----------------------------- //Dennis Castillo [2022-03-23]
function getAllRepositories(){
  
  $job = $_GET["job"];
  
}
//-----------------------------
function getJobAccounts(){

  $job = $_GET["job"];
  $getJobs = $this->capitalhumano_model->getJobsAvailable(array("idJob" => $job, "reallyDeleted" => 0));
  
  echo json_encode($getJobs);
}
//------------------------------------------------------------------------------------------------------------------
  //Funciones para Puestos
  function buscarFunciones(){
    $idPuesto = $this->input->post('buscarIdPuesto');
    $datos['funcionesPuesto']=$this->capitalhumano_model->devolverFuncionesAsignadasPuesto($idPuesto);

    $mision=$this->db->query('select * from job_description where idPuesto = '.$idPuesto)->result();
  
    $datos['mision']='';
    if(count($mision)>0){$datos['mision']=$mision[0]->mision;}
    $datos['idPersona'] = $this->db->query('select idPersona from personapuesto where idPuesto = '.$idPuesto)->row()->idPersona;
    echo json_encode($datos);
  }

  function getInfoPuesto() {
    $id = $this->input->get('id');
    $type = $this->input->get('tp');
    if ($type == "1") {
      $data = $this->capitalhumano_model->devolverManualUsuario($id);
    }
    else if ($type == "2") {
      $data = $this->PersonaModelo->personapuestogrupo(null);
    }
    else if ($type == "3") {
      $data = $this->capitalhumano_model->buscarPuesto($id);
    }
    else if ($type == "4") {
      $data['documentospuesto']=$this->documentos_capitalhumano_model->get_documentos_puesto($this->tank_auth->get_idPersona());
      $data['documentospuestoasignados']=$this->documentos_capitalhumano_model->get_documentos_puesto_asignados();
      $data['documentos']= array_filter($this->documentos_capitalhumano_model->get_documentos(), function($arr){ return is_null($arr->idPuesto);});
    }
    else if ($type == "5") {
      $data['puestosGrupos'] = $this->PersonaModelo->personapuestogrupo(null);
      $data['colaboradorConPuesto'] = $this->PersonaModelo->devolverColaboradorConPuesto();
    }
    else if ($type == "6") {
      $permissions = $this->PersonaModelo->permisosPersona('documentos');
      $deletePermission = isset($permissions["Eliminar documento del puesto"]) ? array("disabled" => "", "label" => "Eliminar") : array("disabled" => "disabled", "label" => "Eliminar (bloqueado)");
      $showOption = isset($permissions["Ver opción de documentos del puesto"]) ? true : false;
      $uploadFile = isset($permissions["Subir documento para un puesto"]) ? true : false;
      $viewAllJobDocs = isset($permissions["Ver documentos generales del puesto"]) ? true : false;
      $uploadToRepositories = isset($permissions["Subir documentos a repositorios generales"]) ? 1 : 0;
      $data["permission"]["delete"] = $deletePermission;
      $data["permission"]["showOption"] = $showOption;
      $data["permission"]["uploadFile"] = $uploadFile;
      $data["permission"]["viewAllDocs"] = $viewAllJobDocs;
      $data["permission"]["uploadToRepositories"] = $uploadToRepositories;
    }
    echo json_encode($data);
  }

  function delete_archivo(){
    $id = $this->input->post('id');
    $result['success'] = $this->documentos_capitalhumano_model->borrar_documento($id);
    echo json_encode($result);
  }

  function getTablesReport() {
    $data['vacaciones'] = $this->capitalhumano_model->getAllVacations();
    $data['asistencias'] = $this->capitalhumano_model->getAllAsistencias();
    $data['puntualidad'] = $this->capitalhumano_model->getAllPuntualidad();
    echo json_encode($data);
  }

  //-----------------------------------------------------------
  function misionPuestoGuardar()
  {
    $respuesta['success']='true';

    $verificaExistencia='select idPuesto from job_description where idPuesto='.$_POST['idPuesto'];
     $total=$this->db->query($verificaExistencia)->result();

     if(count($total)>0)
     {
        $update['mision']=$_POST['mision'];
        $this->db->where('idPuesto',$_POST['idPuesto']);      
        $this->db->update('job_description',$update);
     }
     else
     {
        $insert['idPuesto']=$_POST['idPuesto'];
        $insert['mision']=$_POST['mision'];
        $this->db->insert('job_description',$insert);
     }
 
    echo json_encode($respuesta);
  }
  //------------------------------------------------------------------------------------------------------------------
  function getTableKPICobranza() { //Creado [Suemy][2024-02-16]
    $employment = $this->input->get('id');
    $employee = $this->db->query('select idPersona from personapuesto where idPuesto = '.$employment)->row()->idPersona;
    $email = $this->db->query('select email from users where idPersona = '.$employee)->row()->email;
    $data['kpi'] = "Cobranza";
    $data['email'] = $email;
    $data['permiso'] = 0;
    $data['resultados'] = '<tr><td colspan="5"><center>Sin resultados</center></td></tr>';
    if ($email == "ASISTENTECUN2@AGENTECAPITAL.COM" || $email == "ATENCIONAGENTESMID@ASESORESCAPITAL.COM" || $email == "ATENCIONCLIENTES@ASESORESCAPITAL.COM" || $email == "SOPORTEOPERATIVO@ASESORESCAPITAL.COM" || $email == "COORDINADORINSTITUCIONAL@AGENTECAPITAL.COM" || $email == "COORDINADOR@CAPCAPITAL.COM.MX" || $email == "COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX" || $email == "COORDINADORCOMERCIAL@FIANZASCAPITAL.COM") {
      $cobranza = array();
      $result = $this->crmproyecto_model->avance_cobranza_agente_region($employee);
      array_push($cobranza, $result);
      $dxnData = $this->crmproyecto_model->getDxnData();
      $semaphore = "";
      $data['dxn'] = array_reduce($dxnData, function($acc, $curr){
        if($curr->tipoRecibo == "efectuado"){
          $acc["effected"] += $curr->recibos; 
        } elseif($curr->tipoRecibo == "atrasado"){
          $acc["late"] += $curr->recibos; 
        }
        return $acc;
        },
        array("effected" => 0, "late" => 0)
      );
      if (!empty($result)) {
        $semaphore = array_reduce($cobranza, function($acc, $curr){ // $kpi
          $acc["effected"] += ($curr->recibos_efectuados + $curr->recibos_efectuados_grupo_cer);
          $acc["ontime"] += ($curr->recibos_a_tiempo + $curr->recibos_a_tiempo_cer);
          $acc["pending"] += ($curr->recibos_pendientes + $curr->recibos_pendientes_grupo_cer);
          $acc["late"] += ($curr->recibos_atrasados + $curr->recibos_atrasados_grupo_cer);
          return $acc;
          },
          array("effected" => 0, "ontime" => 0, "pending" => 0, "late" => 0)
        );
        $dtEfecutada = $semaphore['effected'] - $data['dxn']['effected'];
        $dtAtrasada = $semaphore['late'] - $data['dxn']['late'];
        $data['resultados'] = '<tr><td>Recibos</td><td>'.$semaphore['effected'].'</td><td>'.$semaphore['ontime'].'</td><td>'.$semaphore['pending'].'</td><td>'.$semaphore['late'].'</td></tr><tr><td colspan="5" class="tr-cobranza">RECIBOS DXN</td></tr><tr><td>Recibos</td><td>'.$data['dxn']['effected'].'</td><td>---</td><td>---</td><td>'.$data['dxn']['late'].'</td></tr><tr><td>Recibos DT</td><td>'.$dtEfecutada.'</td><td>---</td><td>---</td><td>'.$dtAtrasada.'</td></tr>';
      }
      else {
        $data['resultados'] = '<tr><td>Recibos</td><td>0</td><td>0</td><td>0</td><td>0</td></tr><tr><td colspan="5" class="tr-cobranza">RECIBOS DXN</td></tr><tr><td>Recibos</td><td>'.$data['dxn']['effected'].'</td><td>---</td><td>---</td><td>'.$data['dxn']['late'].'</td></tr><tr><td>Recibos DT</td><td>0</td><td>---</td><td>---</td><td>0</td></tr>';
      }
      $data['cobranza'] = $result;
      $data['semaphore'] = $semaphore;
      $data['permiso'] = 1;
    }
    else if ($email == "DIRECTORGENERAL@AGENTECAPITAL.COM" || $email == "DIRECTORCOMERCIAL@AGENTECAPITAL.COM" || $email == "GERENTEOPERATIVO@AGENTECAPITAL.COM" || $email == "COORDINADOROPERATIVO@ASESORESCAPITAL.COM" || $email == "COBRANZA@ASESORESCAPITAL.COM" || $email == "DATACENTER@AGENTECAPITAL.COM") {
      $cobranza = $this->crmproyecto_model->devuelveTodosLosRegistrosPorRegion();
      $oficina = array_reduce($cobranza, function($acc, $curr){
        if($curr->reporte !== "fianzas"){
          $acc .= '
            <tr>
              <td>'.ucwords($curr->reporte).'</td>
              <td class="text-center">'.number_format($curr->recibos_efectuados + $curr->recibos_efectuados_grupo_cer).'</td>
              <td class="text-center">'.number_format($curr->recibos_a_tiempo + $curr->recibos_a_tiempo_cer).'</td>
              <td class="text-center">'.number_format($curr->recibos_pendientes + $curr->recibos_pendientes_grupo_cer).'</td>
              <td class="text-center">'.number_format($curr->recibos_atrasados + $curr->recibos_atrasados_grupo_cer).'</td>
            </tr>';
        }
        return $acc;
        }, ""
      );
      $data['fianzas'] = array_reduce($cobranza, function($acc, $curr){
        if($curr->reporte == "fianzas"){
          $acc["effected"] += ($curr->recibos_efectuados + $curr->recibos_efectuados_grupo_cer);
          $acc["ontime"] += ($curr->recibos_a_tiempo + $curr->recibos_a_tiempo_cer);
          $acc["pending"] += ($curr->recibos_pendientes + $curr->recibos_pendientes_grupo_cer);
          $acc["late"] += ($curr->recibos_atrasados + $curr->recibos_atrasados_grupo_cer);
        }
        return $acc;
        }, array("effected" => 0, "ontime" => 0, "pending" => 0, "late" => 0)
      );
      $data['seguros'] = array_reduce($cobranza, function($acc, $curr){
        if($curr->reporte !== "fianzas"){
          $acc["effected"] += ($curr->recibos_efectuados + $curr->recibos_efectuados_grupo_cer);
          $acc["ontime"] += ($curr->recibos_a_tiempo + $curr->recibos_a_tiempo_cer);
          $acc["pending"] += ($curr->recibos_pendientes + $curr->recibos_pendientes_grupo_cer);
          $acc["late"] += ($curr->recibos_atrasados + $curr->recibos_atrasados_grupo_cer);
        }
        return $acc;
        }, array("effected" => 0, "ontime" => 0, "pending" => 0, "late" => 0)
      );
      $data['total'] = array_reduce($cobranza, function($acc, $curr){       
        $acc["effected"] += ($curr->recibos_efectuados + $curr->recibos_efectuados_grupo_cer);
        $acc["ontime"] += ($curr->recibos_a_tiempo + $curr->recibos_a_tiempo_cer);
        $acc["pending"] += ($curr->recibos_pendientes + $curr->recibos_pendientes_grupo_cer);
        $acc["late"] += ($curr->recibos_atrasados + $curr->recibos_atrasados_grupo_cer);
        return $acc;
        }, array("effected" => 0, "ontime" => 0, "pending" => 0, "late" => 0)
      );
      $data['cobranza'] = $cobranza;
      $data['oficina'] = $oficina;
      $data['permiso'] = 1;
      $data['resultados'] = $data['oficina'].'<tr><td colspan="5" style="border-top: solid"></td></tr><tr><td>Seguros</td><td class="text-center">'.$data['seguros']['effected'].'</td><td class="text-center">'.$data['seguros']['ontime'].'</td><td class="text-center">'.$data['seguros']['pending'].'</td><td class="text-center">'.$data['seguros']['late'].'</td></tr><tr><td>Fianzas</td><td class="text-center">'.$data['fianzas']['effected'].'</td><td class="text-center">'.$data['fianzas']['ontime'].'</td><td class="text-center">'.$data['fianzas']['pending'].'</td><td class="text-center">'.$data['fianzas']['late'].'</td></tr><tr><td>Total</td><td class="text-center">'.$data['total']['effected'].'</td><td class="text-center">'.$data['total']['ontime'].'</td><td class="text-center">'.$data['total']['pending'].'</td><td class="text-center">'.$data['total']['late'].'</td></tr>';
    }
    echo json_encode($data);
  }

  function getTableKPIComercial() { //Creado [Suemy][2024-02-16]
    //-------------------------- Encontrar días disponibles del mes sin contar fin de semana y feriados --------------
    //Fechas inhábiles
    function datesHolidays($mes){
      $anio=date("Y");
      switch($mes){
        case 1:return [$anio."-01-01"];break;
        case 2:return [$anio."-02-01"];break;
        case 3:return [$anio."-03-15"];break;
        case 5:return [$anio."-05-01"];break;
        case 9:return [$anio."-09-16"];break;
        case 11:return [$anio."-11-15"];break;
        case 12:return [$anio."-12-25"];break;
      }
    }
    //Filtar fechas
    function filterDates($fi, $ff, $fih){
      if(empty($fih)){
        $fih=array();
      }
      $int_i=strtotime($fi);
      $int_f=strtotime($ff);
      $d_h=array();
      for($it=$int_i; $it<=$int_f; $it+=86400){
        if(!in_array(date("N",$it), array(6,7)) && !in_array(date("Y-m-d", $it),$fih)){
          array_push($d_h, date("Y-m-d", $it));
        }
      }
      return $d_h;
    }
    //Conteo de los resultados
    $days = 0;
    $today = date("Y-m-d");
    $day_f = date("Y-m-d", mktime(0,0,0,(date("m"))+1,0,date("Y")));
    $count = filterDates($today,$day_f,datesHolidays(date("m")));
    if(!empty($count)){
      for($i=0; $i<count($count); $i++){
        $days++;
      }
    } else{
      $days = 1;
    }

    //----------------------------------------------------------------------------------------------

    $employment = $this->input->get('id');
    $employee = $this->db->query('select idPersona from personapuesto where idPuesto = '.$employment)->row()->idPersona;
    $email = $this->db->query('select email from users where idPersona = '.$employee)->row()->email;
    $objective = $this->metacomercial_modelo->devuelveRelacionComisionPersona(array("idPersona" => $employee, "correo" => $email));
    $cobranza = $this->crmproyecto_model->devuelveRelacionKPIPorPersona($employee);
    $metaVN = "";
    $metaIT = "";
    $data['kpi'] = "Comercial";
    $data['permiso'] = 0;
    foreach ($objective as $key => $val) {
      if (!empty($cobranza)) {
        if ($key == "venta_nueva") { $band = 1; }
        else { $band = 2; }
        $meta = $this->metacomercial_modelo->devuelveMensualidadDeMeta(date("m"),$val->id_referencia,$band);
        $recibos = $this->crmproyecto_model->avance_cobranza_agente_region($employee);
        $comision = $this->crmproyecto_model->devuelveDatosCobranzaPorComision($employee,1);
        // $add['meta'] = !empty($meta) ? $meta->monto_al_mes : 0;
        // $add['comision'] = $key == "venta_nueva" ? $comision->comision_efectuada_venta_nueva : $comision->comision_efectuada;
        // $add['recibos'] = $key == "venta_nueva" ? $recibos->recibos_efectuados_venta_nueva : $recibos->recibos_efectuados;
        // array_push($metaFinal, $add);
        if ($val->referencia == "venta_nueva") {
          $metaVN = array(
            "meta" => !empty($meta) ? $meta->monto_al_mes : 0,
            "comision" => $comision->comision_efectuada_venta_nueva,
            "recibos" => $recibos->recibos_efectuados_venta_nueva,
            "comision_real" => $comision->comision_efectuada_venta_nueva / $recibos->recibos_efectuados_venta_nueva,
            "comision_sugerida" =>  $comision->comision_efectuada_venta_nueva / $days
          );
        }
        else {
          $metaIT = array(
            "meta" => !empty($meta) ? $meta->monto_al_mes : 0,
            "comision" => $comision->comision_efectuada,
            "recibos" => $recibos->recibos_efectuados,
            "comision_real" => $comision->comision_efectuada / $recibos->recibos_efectuados,
            "comision_sugerida" =>  $comision->comision_efectuada / $days
          );
        }
        $data['permiso'] = 1;
      }
    }
    /*$data['idPuesto'] = $employment;
    $data['idPersona'] = $employee;
    $data['email'] = $email;
    $data['contador_dias'] = $count;
    $data['dias_disponibles'] = $days;*/
    $data['venta_nueva'] = $metaVN;
    $data['ingreso_total'] = $metaIT;
    echo json_encode($data);
  }

  function getTableKPIProspeccion() { //Creado [Suemy][2024-02-16]
    $employment = $this->input->get('id');
    $employee = $this->db->query('select idPersona from personapuesto where idPuesto = '.$employment)->row()->idPersona;
    $email = $this->db->query('select email from users where idPersona = '.$employee)->row()->email;
    $data['kpi'] = "Prospeccion";
    $data['email'] = $email;
    $data['permiso'] = 0;
    $data['resultados'] = '<tr><td colspan="6"><center>Sin resultados</center></td></tr>';
    if ($email == "DIRECTORCOMERCIAL@AGENTECAPITAL.COM") {
      $ct['SinVenta'] = $this->cuadromando_model->getProspectosKPI(date('m'),date('Y'),'DIMENSION',0);
      $ct['Perfilados'] = $this->cuadromando_model->getProspectosKPI(date('m'),date('Y'),'PERFILADO',0);
      $ct['Contactados'] = $this->cuadromando_model->getProspectosKPI(date('m'),date('Y'),'CONTACTADO',0);
      $ct['Cotizados'] = $this->cuadromando_model->getProspectosKPI(date('m'),date('Y'),'COTIZADO',0);
      $ct['Emitidos'] = $this->cuadromando_model->getProspectosKPI(date('m'),date('Y'),'COTIZADO',1);
      $ct['Cerrados'] = $this->cuadromando_model->getProspectosKPI(date('m'),date('Y'),'CERRADO',0);
      $data['permiso'] = 1;
      $data['prospectos'] = $ct;
      $data['resultados'] = '<tr><td>'.$ct['SinVenta'].'</td><td>'.$ct['Perfilados'].'</td><td>'.$ct['Contactados'].'</td><td>'.$ct['Cotizados'].'</td><td>'.$ct['Emitidos'].'</td><td>'.$ct['Cerrados'].'</td></tr>';
    }
    echo json_encode($data);
  }

  function getTableKPIEjecutivo() { //Creado [Suemy][2024-02-16]
    $employment = $this->input->get('id');
    $employee = $this->db->query('select idPersona from personapuesto where idPuesto = '.$employment)->row()->idPersona;
    $email = $this->db->query('select email from users where idPersona = '.$employee)->row()->email;
    $data['kpi'] = "Ejecutivo";
    $data['email'] = $email;
    $data['permiso'] = 0;
    $data['trtd1'] = '<tr><td colspan="3"><center>Sin resultados</center></td></tr>';
    $data['trtd2'] = '<tr><td colspan="4"><center>Sin resultados</center></td></tr>';
    $data['trtd3'] = '<tr><td colspan="5"><center>Sin resultados</center></td></tr>';
    if ($email == "AUTOS@ASESORESCAPITAL.COM" || $email == "BIENES@ASESORESCAPITAL.COM" || $email == "LINEASPERSONALES@ASESORESCAPITAL.COM" || $email == "AUTOSRENOVACIONES@ASESORESCAPITAL.COM" || $email == "EJECUTIVOCOTIZACIONES@AGENTECAPITAL.COM") {
      $label = "noavailable";
      //Semaforo Renovaciones a renovadas
      $renovacion=$this->cuadromando_model->getRenovaciones();
      //Semaforo Renovaciones pendientes por renovar
      $pendientes=$this->cuadromando_model->getRenovacionesPendientes(date('m'));
      switch ($email) {
        case 'AUTOS@ASESORESCAPITAL.COM':
            $ramo='AUTOS';
            $ramo_name='Autos';
            $Pdiario=$this->cuadromando_model->promedio_atencion_actividades("AUTOS");
            $label = "vehiculos";
            //Pólizas renovadas
            $renovacionV = $renovacion[0];
            $renovacionA = $renovacion[1];
            $renovacionR = $renovacion[2];
            $renovacionT = $renovacion[0] + $renovacion[1] + $renovacion[2];
            //Pólizas pendientes
            $pendientesV = $pendientes[0];
            $pendientesA = $pendientes[1];
            $pendientesR = $pendientes[2];
            $pendientesT = $pendientes[0] + $pendientes[1] + $pendientes[2];
            break;
        case 'AUTOSRENOVACIONES@ASESORESCAPITAL.COM':
            $ramo='AUTOS';
            $ramo_name='Autos';
            $Pdiario=$this->cuadromando_model->promedio_atencion_actividades("AUTOS");
            $label = "vehiculos";
            //Pólizas renovadas
            $renovacionV = $renovacion[0];
            $renovacionA = $renovacion[1];
            $renovacionR = $renovacion[2];
            $renovacionT = $renovacion[0] + $renovacion[1] + $renovacion[2];
            //Pólizas pendientes
            $pendientesV = $pendientes[0];
            $pendientesA = $pendientes[1];
            $pendientesR = $pendientes[2];
            $pendientesT = $pendientes[0] + $pendientes[1] + $pendientes[2];
            break;
        case 'EJECUTIVOCOTIZACIONES@AGENTECAPITAL.COM':
            $ramo='AUTOS';
            $ramo_name='Autos';
            $Pdiario=$this->cuadromando_model->promedio_atencion_actividades("AUTOS");
            $label = "vehiculos";
            //Pólizas renovadas
            $renovacionV = $renovacion[0];
            $renovacionA = $renovacion[1];
            $renovacionR = $renovacion[2];
            $renovacionT = $renovacion[0] + $renovacion[1] + $renovacion[2];
            //Pólizas pendientes
            $pendientesV = $pendientes[0];
            $pendientesA = $pendientes[1];
            $pendientesR = $pendientes[2];
            $pendientesT = $pendientes[0] + $pendientes[1] + $pendientes[2];
            break;
        case 'LINEASPERSONALES@ASESORESCAPITAL.COM':
            $ramo='VIDA';
            $ramo_name='Lineas Personales';
            $Pdiario=$this->cuadromando_model->promedio_atencion_actividades("VIDA");
            $label = "lineas_personales";
            //Pólizas renovadas
            $renovacionV = $renovacion[3];
            $renovacionA = $renovacion[4];
            $renovacionR = $renovacion[5];
            $renovacionT = $renovacion[3] + $renovacion[4] + $renovacion[5];
            //Pólizas pendientes
            $pendientesV = $pendientes[3];
            $pendientesA = $pendientes[4];
            $pendientesR = $pendientes[5];
            $pendientesT = $pendientes[3] + $pendientes[4] + $pendientes[5];
            break;
        case 'BIENES@ASESORESCAPITAL.COM':
            $ramo='DANIOS';
            $ramo_name='Daños';
            $Pdiario=$this->cuadromando_model->promedio_atencion_actividades("DANIOS");
            $label = "danos";
            //Pólizas renovadas
            $renovacionV = $renovacion[6];
            $renovacionA = $renovacion[7];
            $renovacionR = $renovacion[8];
            $renovacionT = $renovacion[6] + $renovacion[7] + $renovacion[8];
            //Pólizas pendientes
            $pendientesV = $pendientes[6];
            $pendientesA = $pendientes[7];
            $pendientesR = $pendientes[8];
            $pendientesT = $pendientes[6] + $pendientes[7] + $pendientes[8];
            break;
      }
      //Promedio diario
      $promedioDiario = $this->cuadromando_model->promedio_atencion_actividades($ramo)[0];
      //Promedio semanal
      $promedioSemanal = $this->cuadromando_model->promedio_atencion_actividades($ramo)[1];
      $semaforo=$this->cuadromando_model->getSemaforo($ramo,date('m'),date('Y'));
      //Cotización
      $cotizacionV=$semaforo[0];
      $cotizacionA=$semaforo[1];
      $cotizacionR=$semaforo[2];
      //Cancelado
      $cancelacionV=$semaforo[3];
      $cancelacionA=$semaforo[4];
      $cancelacionR=$semaforo[5];
      //Endoso
      $endosoV=$semaforo[6];
      $endosoA=$semaforo[7];
      $endosoR=$semaforo[8];
      //Emisión
      $emisionV=$semaforo[9];
      $emisionA=$semaforo[10];
      $emisionR=$semaforo[11];
      //
      $totalV=$renovacion[0]+$renovacion[6]+$renovacion[3];
      $totalA=$renovacion[1]+$renovacion[7]+$renovacion[4];
      $totalR=$renovacion[2]+$renovacion[8]+$renovacion[5];
      $total=$totalV+$totalA+$totalR;
      //
      $totalVPendientes=$pendientes[0]+$pendientes[6]+$pendientes[3];
      $totalAPendientes=$pendientes[1]+$pendientes[7]+$pendientes[4];
      $totalRPendientes=$pendientes[2]+$pendientes[8]+$pendientes[5];
      $totalPendientes=$totalVPendientes+$totalAPendientes+$totalRPendientes;

      $data['permiso'] = 1;
      $data['ramo'] = $ramo_name;
      $data['trtd1'] = '<tr><td>Promedio</td><td>'.$promedioDiario.'</td><td>'.$promedioSemanal.'</td></tr>';
      $data['trtd2'] = '<tr><td>Cotizaciones</td><td>'.$cotizacionV.'</td><td>'.$cotizacionA.'</td><td>'.$cotizacionR.'</td></tr><tr><td>Cancelaciones</td><td>'.$cancelacionV.'</td><td>'.$cancelacionA.'</td><td>'.$cancelacionR.'</td></tr><tr><td>Endosos</td><td>'.$endosoV.'</td><td>'.$endosoA.'</td><td>'.$endosoR.'</td></tr><tr><td>Emisiones</td><td>'.$emisionV.'</td><td>'.$emisionA.'</td><td>'.$emisionR.'</td></tr>';
      $data['trtd3'] = '<tr><td colspan="5" class="tr-cobranza">Pólizas Renovadas</td></tr><tr><td>Líneas Personales</td><td>'.$renovacionV.'</td><td>'.$renovacionA.'</td><td>'.$renovacionR.'</td><td>'.$renovacionT.'</td></tr><tr><td>Totales</td><td>'.$totalV.'</td><td>'.$totalA.'</td><td>'.$totalR.'</td><td>'.$total.'</td></tr><tr><td colspan="5" class="tr-cobranza">Pólizas Pendientes por Renovar</td></tr><tr><td>Líneas Personales</td><td>'.$pendientesV.'</td><td>'.$pendientesA.'</td><td>'.$pendientesR.'</td><td>'.$pendientesT.'</td></tr><tr style="display:none;"><td>Totales</td><td>'.$totalVPendientes.'</td><td>'.$totalAPendientes.'</td><td>'.$totalRPendientes.'</td><td>'.$totalPendientes.'</td></tr>';
    }
    echo json_encode($data);
  }

  function getTableKPIOperativo() { //Creado [Suemy][2024-02-16]
    $employment = $this->input->get('id');
    $employee = $this->db->query('select idPersona from personapuesto where idPuesto = '.$employment)->row()->idPersona;
    $email = $this->db->query('select email from users where idPersona = '.$employee)->row()->email;
    $data['kpi'] = "Operativo";
    $data['email'] = $email;
    $data['permiso'] = 0;
    if ($email == "DIRECTORGENERAL@AGENTECAPITAL.COM" || $email == "GERENTEOPERATIVO@AGENTECAPITAL.COM" || $email == "COORDINADOROPERATIVO@ASESORESCAPITAL.COM") {
      $renovaciones = $this->cuadromando_model->getRenovaciones();
      $rnPendientes = $this->cuadromando_model->getRenovacionesPendientes(date('m'));
      //----------- Autos ------------
      $semaforoAutos=$this->cuadromando_model->getSemaforo('AUTOS',date('m'),date('Y'));
      $autos = $this->getArrayRamo($semaforoAutos);
      //->Promedio diario
      $autos['diario'] = $this->cuadromando_model->promedio_atencion_actividades('AUTOS')[0];
      //->Promedio semanal
      $autos['semanal'] = $this->cuadromando_model->promedio_atencion_actividades('AUTOS')[1];
      //->Pólizas renovadas
      $renovacion['autosRenV'] = $renovaciones[0];
      $renovacion['autosRenA'] = $renovaciones[1];
      $renovacion['autosRenR'] = $renovaciones[2];
      $renovacion['autosRenT'] = $renovaciones[0] + $renovaciones[1] + $renovaciones[2];
      //->Pólizas pendientes
      $pendientes['autosPenV'] = $rnPendientes[0];
      $pendientes['autosPenA'] = $rnPendientes[1];
      $pendientes['autosPenR'] = $rnPendientes[2];

      //---------- Daños ----------
      $semaforoDanios=$this->cuadromando_model->getSemaforo('DANIOS',date('m'),date('Y'));
      $danios = $this->getArrayRamo($semaforoDanios);
      //->Promedio diario
      $danios['diario'] = $this->cuadromando_model->promedio_atencion_actividades('DANIOS')[0];
      //->Promedio semanal
      $danios['semanal'] = $this->cuadromando_model->promedio_atencion_actividades('DANIOS')[1];
      //->Pólizas renovadas
      $renovacion['daniosRenV'] = $renovaciones[6];
      $renovacion['daniosRenA'] = $renovaciones[7];
      $renovacion['daniosRenR'] = $renovaciones[8];
      $renovacion['daniosRenT'] = $renovaciones[6] + $renovaciones[7] + $renovaciones[8];
      //->Pólizas pendientes
      $pendientes['daniosPenV'] = $rnPendientes[6];
      $pendientes['daniosPenA'] = $rnPendientes[7];
      $pendientes['daniosPenR'] = $rnPendientes[8];

      //----------- Vida ---------- 
      $semaforoVida=$this->cuadromando_model->getSemaforo('VIDA',date('m'),date('Y'));
      $vida = $this->getArrayRamo($semaforoVida);
      //->Promedio diario
      $vida['diario'] = $this->cuadromando_model->promedio_atencion_actividades('VIDA')[0];
      //->Promedio semanal
      $vida['semanal'] = $this->cuadromando_model->promedio_atencion_actividades('VIDA')[1];
      //->Pólizas renovadas
      $renovacion['vidaRenV'] = $renovaciones[3];
      $renovacion['vidaRenA'] = $renovaciones[4];
      $renovacion['vidaRenR'] = $renovaciones[5];
      $renovacion['vidaRenT'] = $renovaciones[3] + $renovaciones[4] + $renovaciones[5];
      //->Pólizas pendientes
      $pendientes['vidaPenV'] = $rnPendientes[3];
      $pendientes['vidaPenA'] = $rnPendientes[4];
      $pendientes['vidaPenR'] = $rnPendientes[5];

      //-------------- Renovaciones --------------
      //Ramos
      $renovacion['totalAutos'] = $renovaciones[0]+$renovaciones[1]+$renovaciones[2];
      $renovacion['totalDanios'] = $renovaciones[6]+$renovaciones[7]+$renovaciones[8];
      $renovacion['totalVida'] = $renovaciones[3]+$renovaciones[4]+$renovaciones[5];
      //Semáforo
      $renovacion['totalVerde'] = $renovaciones[0]+$renovaciones[6]+$renovaciones[3];
      $renovacion['totalAmarillo'] = $renovaciones[1]+$renovaciones[7]+$renovaciones[4];
      $renovacion['totalRojo'] = $renovaciones[2]+$renovaciones[8]+$renovaciones[5];
      //Total renovadas
      $renovacion['total'] = $renovacion['totalVerde'] + $renovacion['totalAmarillo'] + $renovacion['totalRojo'];

      //-------------- Pendientes --------------
      //Ramos
      $pendientes['totalAutos'] = $rnPendientes[0]+$rnPendientes[1]+$rnPendientes[2];
      $pendientes['totalDanios'] = $rnPendientes[6]+$rnPendientes[7]+$rnPendientes[8];
      $pendientes['totalVida'] = $rnPendientes[3]+$rnPendientes[4]+$rnPendientes[5] + $rnPendientes[9] + $rnPendientes[10] + $rnPendientes[11];
      //Semáforo
      $pendientes['totalVerde'] = $rnPendientes[0]+$rnPendientes[6]+$rnPendientes[3] + $rnPendientes[9];
      $pendientes['totalAmarillo'] = $rnPendientes[1]+$rnPendientes[7]+$rnPendientes[4] + $rnPendientes[10];
      $pendientes['totalRojo'] = $rnPendientes[2]+$rnPendientes[8]+$rnPendientes[5] + $rnPendientes[11];
      //Total pendientes
      $pendientes['totalPendientes'] = $pendientes['totalVerde'] + $pendientes['totalAmarillo'] + $pendientes['totalRojo'];

      $data['permiso'] = 1;
      $data['autos'] = $autos;
      $data['daños'] = $danios;
      $data['vida'] = $vida;
      $data['renovaciones'] = $renovacion;
      $data['pendientes'] = $pendientes;
      $data['semaforoVida'] = $semaforoVida;
    }
    echo json_encode($data);
  }

  function getArrayRamo($semaphore) { //Creado [Suemy][2024-02-16]
      //->Cotización
      $data['CotizacionV'] = $semaphore[0];
      $data['CotizacionA'] = $semaphore[1];
      $data['CotizacionR'] = $semaphore[2];
      $data['CotizacionT'] = $semaphore[0] + $semaphore[1] + $semaphore[2];
      //->Cancelados
      $data['CancelacionV'] = $semaphore[3];
      $data['CancelacionA'] = $semaphore[4];
      $data['CancelacionR'] = $semaphore[5];
      $data['CancelacionT'] = $semaphore[3] + $semaphore[4] + $semaphore[5];
      //->Endosos
      $data['EndosoV'] = $semaphore[6];
      $data['EndosoA'] = $semaphore[7];
      $data['EndosoR'] = $semaphore[8];
      $data['EndosoT'] = $semaphore[6] + $semaphore[7] + $semaphore[8];
      //->Emision
      $data['EmisionV'] = $semaphore[9];
      $data['EmisionA'] = $semaphore[10];
      $data['EmisionR'] = $semaphore[11];
      $data['EmisionT'] = $semaphore[9] + $semaphore[10] + $semaphore[11];
      //->Semáforo
      $data['totalVerde'] = $semaphore[0] + $semaphore[3] + $semaphore[6] + $semaphore[9];
      $data['totalAmarillo'] = $semaphore[1] + $semaphore[4] + $semaphore[7] + $semaphore[10];
      $data['totalRojo'] = $semaphore[2] + $semaphore[5] + $semaphore[8] + $semaphore[11];
      $data['total'] = $data['totalVerde'] + $data['totalAmarillo'] + $data['totalRojo'];
      return $data;
  }

  function repositorioGeneral()
  {
  
    $respuesta['success']=1;
    $respuesta['documentos']=$this->capitalhumano_model->getAllDocumentsofJob();
  
    echo json_encode($respuesta);
  }

  //------------------------------------------------------------------------------------------------------
  function getPermissionDocumentsEmployees($type) { //Modificado [Suemy][2024-11-06]
    $active = 0;
    $permission_repositories = $this->capitalhumano_model->getEmailsPermissionPosition(); //Repositorio limitado
    $permission_complete = $this->db->query('SELECT * FROM `personapermisorelacion` WHERE idPersonaPermiso = 32 AND idPersona = '.$this->tank_auth->get_idPersona())->result(); //Repositorio completo
    $employees = $this->db->query('SELECT * FROM `personapuesto` WHERE `statusPuesto` = 1 AND `padrePuesto` = '.$this->tank_auth->get_idPersonaPuesto())->result(); //Subordinados
    //->Permission
    switch($type) {
      case 1:
        if (!empty($permission_complete) || in_array($this->tank_auth->get_usermail(), $permission_repositories) || !empty($employees)) {
          $active = 1;
        }
      break;
      case 2:
        if (!empty($permission_complete)) {
          $active = 1;
        }
        else if (in_array($this->tank_auth->get_usermail(), $permission_repositories) || !empty($employees)) {
          $active = 2;
        }
      break;
    }    
    return $active;
  }
}
