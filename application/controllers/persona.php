<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//require_once __DIR__.'dompdf/autoload.inc.php';
//use Dompdf\Dompdf;
//require_once(dirname(__FILE__) . '\dompdf\autoload.inc');
class Persona extends CI_Controller{
var $operPersona;
var $emailUser;
var $idPersona;
var $mensaje="";
var $datos	= array(); //"";
	var $auth = "vsDMquPhx68SZrY8wGcxEh2bk1XiPlR0EZkBVLmax3A4Mab7sDeeyodY3BjDuyB";	
	var $user = "GAP#aCap%2015";		
	var $pass = "CAP15gap20Ag";	
	var $Url = 'https://{host}/SOnlineWS/WS_SICASOnline.asmx?WSDL';
	var $host = 'www.sicasonline.info:448';
	function __construct()
  {
	parent::__construct();
    $this->load->model('PersonaModelo');
    $this->load->model("capitalhumano_model", "capitalhumano");
    //-----------------------------------------------
    //[Dennis 2020-09-30]
    $this->load->model('capacita_modelo');
    $this->load->model("documentos_capitalhumano_model");
    $this->load->model('notificacionmodel');
    //Dennis [2021-10-02]
    $this->load->model("crmproyecto_model", "crmproyecto");
    //-----------------------------------------------
		$this->load->model('manejodocumento_modelo');
    $this->load->library('libreriav3');
		$this->load->library('serviciowebsicas');
    $this->load->library("imgedit_cenis"); //Dennis Castillo [2021-10-31]
        $this->load->library('webservice_sicasdre'); 
  $this->load->library('Ws_sicas'); 

/*================== PARA TRAER POLZA DE AGENTES======================================*/
	$params['id_sicas'] = $this->tank_auth->get_IDUserSICAS(); "get_IDUserSICAS";
	$params['user_sicas'] = $this->tank_auth->get_UserSICAS(); "get_UserSICAS";
	$params['pass_sicas'] = $this->tank_auth->get_PassSICAS(); "get_PassSICAS";
	$this->load->library('Ws_sicasdre',$params);

	$this->load->helper('ckeditor');
	$this->load->model('capsysdre_actividades');
	$this->load->library(array("webservice_sicas_soap","role"));	
/*====================================================================================*/
           // $this->load->library('dompdf/lib/Cpdf');             
		$this->operPersona=new $this->PersonaModelo;
   //$this->load->library('converterPDF');
		$this->emailUser=$this->tank_auth->get_usermail();
    $this->idPersona=$this->tank_auth->get_idPersona();

		if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');}

	}

//--------------------------------------------------------------------------------------------

public function index(){
  /*TABLAS USADAS PRINCIPALMENTE PERSONA,USERS,VEND_PERMISOS,USER_MIINFO,CATALOG_VENDEDORES*/
    $this->agente();
	}
//----------------------------------------------------------------------------------------------



  
public function agente(){
  $bandGuardado=0;
  $band=0;
  $coorPermit = array("COORDINADOR@CAPCAPITAL.COM.MX", "COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX"); //Dennis Castillo [2021-10-31]
  $permissions = $this->operPersona->permisosPersona('agregarPersona');
  $deletePermission = !empty($permissions["Eliminar colaborador"]) ? array("label" => "Eliminar", "typePerson" => $permissions["value"], "operation" => "delete", "show" => 0) : array("label" => "Solicitar baja", "typePerson" => 1, "operation" => "request",  "show" => 0);
  $welcomePermission = !empty($permissions["Enviar bienvenida"]);

  $this->datos['colaboradorArea']=0;
    if($this->emailUser=="SISTEMAS@ASESORESCAPITAL.COM" || $this->emailUser=="DIRECTORGENERAL@AGENTECAPITAL.COM" || $this->emailUser=="AUDITORINTERNO@AGENTECAPITAL.COM" || $this->emailUser=="CAPITALHUMANO@AGENTECAPITAL.COM" || $this->emailUser=="SUBGERENTE@CAPCAPITAL.COM.MX" || $this->emailUser=='ASISTENTEDIRECCION@AGENTECAPITAL.COM'){$band=1;}

    if(isset($_POST['idPersonas'])){
      $creator = $this->operPersona->obtenerUsuarioCreacion($_POST['idPersonas']);
      //var_dump($creator);
      $this->buscarPersona($this->operPersona->obtenerTipoPersona($_POST['idPersonas']), $creator);
      $deletePermission["show"] = 1;
    }
  if(isset($_POST['idPasarAgente'])){$this->permisoAgenteV3();} //[Dennis 2020-03-31]
  if(isset($_POST['idPersona']))
  {      
    if((int)$_POST['idPersona']>0)
   {
      $tipoPersona=$this->operPersona->obtenerTipoPersona($_POST['idPersona']);
      $idPersona=$_POST['idPersona'];
      if($tipoPersona==3 || $tipoPersona==4)
      {
        $deletePermission["show"] = $_POST["IDVend"] > 0 ? 0 : 1;
        $this->manejoAgentes();
      }
      else
      {
        $this->manejoColaborador();
        $deletePermission["show"] = 1;
      }
      $_POST['idPersonas']=$idPersona;
      $creator = $this->operPersona->obtenerUsuarioCreacion($_POST['idPersonas']);
      $this->buscarPersona($tipoPersona, $creator);
    }
    else
   {
    /*$_POST['tipoPersona']==1 es colaborador si no es agente*/
      $bandPermiteGrabado=true;
      $perm=$this->operPersona->permisosPersona('agregarPersona');  
      
      if(isset($perm['value']))
      {
  
       if($perm['value']==$_POST['tipoPersona'])
       {    $this->datos['mensajePersona']='alert("Puedes Grabar")';}
        else{
          $this->datos['mensajePersona']='alert("El tipo de persona que le vas a dar de alta no lo tienes permitido. Contactar a auditoria\n\nSolicitud pasada a capital humano")';
          $bandPermiteGrabado=false;
          
          //----------------
          //Pasar solicitud a Capital Humano Dennis [2021-10-21] 

          $dataTemporalPerson = $this->manejoDePersonaTemporal(); //array("idPersona" => $idPersona_->idPersona,"email" => $email_)
          $emails = array("CAPITALHUMANO@AGENTECAPITAL.COM", "ASISTENTEDIRECCION@AGENTECAPITAL.COM"); // //"SISTEMAS@ASESORESCAPITAL.COM"
          $typePerson =  $dataTemporalPerson["tipoPersona"] == 1 ? "COLABORADOR" : "AGENTE";
          $idPersonas_and_emails = array_map(function($arr){

            $idPersona = $this->operPersona->obtenerIdPersonaPorEmail($arr);
            return array("idPersona" => $idPersona->idPersona, "email" => $arr);

          }, $emails);

          $notification = $this->sendNotification($idPersonas_and_emails, $typePerson, $dataTemporalPerson['idPersona'], "SOLICITUD_DE_ALTA_DE_".$typePerson."", "ALTA");
          
          //---------------
          
        }
      }
    else
      {
        $this->datos['mensajePersona']='alert("No tienes permiso para dar de alta a personas. Contactar a auditoria")';
         $bandPermiteGrabado=false;
          
       }

      if($bandPermiteGrabado)
      {
      if($band){if($_POST['tipoPersona']==1)
      {
       $this->manejoColaborador();$this->buscarPersona(1);}else{$this->manejoAgentes();$this->buscarPersona(3);} 
      }
      else
      {
        $_POST['tipoPersona']=3;
        $_POST['idPersonaPuesto']=0;

        if(isset($_POST["prospectiveAgent"])){
          $this->manejoAgentes();
          $this->buscarPersona(3);
        } else{
          $this->datos['mensajePersona']='alert("La alta de agentes ahora se realiza desde el módulo de prospección/alta de prospecto/prospecto agente. \n Ver progreso del prospecto en seguimiento de prospecto/prospectos agentes ")';
        }
      }
      }
    }
  }

    //-----------------
    $mailFather = $this->tank_auth->get_usermail();
    $parentsAccounts = array_map(function($arr){ return $arr->emailCoordinador; }, $this->operPersona->getParentsEmail(array("emailCoordinador !=" => "DIRECTORCOMERCIAL@AGENTECAPITAL.COM")));
    $getMyEmployees = array_map(function($arr){ return $arr->idChild; }, $this->operPersona->getMyEmployees($mailFather));
    $userAccount = $this->emailUser == "CAPITALHUMANO@AGENTECAPITAL.COM" || $this->emailUser == "ASISTENTEDIRECCION@AGENTECAPITAL.COM" ? "SISTEMAS@ASESORESCAPITAL.COM" : $this->emailUser;
    $agentesTemporales_ = $this->operPersona->obtenerPersonas($userAccount, 3); //$this->emailUser
    
    if(!in_array($mailFather, $parentsAccounts)){

      $employees = array_filter($this->operPersona->obtenerPersonas("CAPITALHUMANO@AGENTECAPITAL.COM",1), function($arr)use($getMyEmployees){

        return in_array($arr->idPersona, $getMyEmployees);
      });
        
      foreach($employees as $d_e){
        array_push($agentesTemporales_, $d_e);
      }
    }
    //-----------------

    $this->datos['personarankingagente']=$this->operPersona->obtenerRankingAgente();
    $this->datos['escolaridad']=$this->operPersona->obtenerEscolaridad();     
    $this->datos['estadoCivil']=$this->operPersona->obtenerEstadoCivil();
    $this->datos['agentesTemporales'] = $agentesTemporales_; //$this->operPersona->obtenerPersonas($this->emailUser,3);
    $this->datos['personas']=$this->libreriav3->agrupaPersonasParaSelect($this->datos['agentesTemporales']);
    
    //$this->datos['personaTipoAgente']=$this->operPersona->obtenerTipoAgente();
    //$this->datos['catalog_sucursales']=$this->operPersona->obtenerCatalogSucursales();
    $this->datos['catalog_sucursales']=$this->operPersona->devuelveSucursalCoor($this->idPersona);
    $this->datos['catalog_canales']=$this->operPersona->obtenerCatalogCanales();
    $this->datos['personagiroagente']=$this->operPersona->obtenerGiroAgente();
    $this->datos['bancos']=$this->operPersona->obtenerBancos();
    $this->datos['agentesEnEspera']=$this->operPersona->agentesEnEstadoCapsys($this->emailUser);
    $this->datos['catalogoHonorarios']=$this->operPersona->obtenerCatalogoHonorarios();
    $this->datos['IDVendNS']=$this->operPersona->obtenerVendedoresActivos();
    $this->datos['catalogoPromotorias']=$this->operPersona->obtenerCatalogPromotorias();
    //[Dennis]
    $this->datos['tipoModalidad']=$this->operPersona->obtenerModalidades($this->idPersona);
    $this->datos['capacitacion']=$this->operPersona->devuelveTipoCapacitacion();
    $this->datos['permisoAgenteNuevo']=$this->operPersona->permisosPersona('persona_agregaAgente');
    $this->datos['personaTipoPersonaCatalogo']=$this->operPersona->obtenerCatalogoTipoPersona();
    $this->datos['coordinadores']=$this->operPersona->devuelveCoordinadoresVentas();
    $this->datos['forRegistrationRequests']=$this->operPersona->getTemporalPersons(); //Dennis Castillo [2021-10-31]
    $this->datos["showInducctionModal"] = $this->operPersona->getCreatorEmployee();
    $this->datos['forSetFreePerson'] = array_filter($this->operPersona->obtenerPersonas("SISTEMAS@ASESORESCAPITAL.COM",3), function($arr){ //Dennis Castillo [2021-10-31]
	$this->datos["forDeleteList"] = $this->capitalhumano->getJobsAvailable(array("reallyDeleted" => 0));

      $validateInducctionFree = $this->operPersona->getInducctionFreePerson($arr->idPersona);
      return !empty($validateInducctionFree) && $validateInducctionFree->status == "free";
    });

    //--------------------- Dennis [2021-12-22]
    $superior = array("DIRECTORGENERAL@AGENTECAPITAL.COM", "DIRECTORCOMERCIAL@AGENTECAPITAL.COM", "GERENTEOPERATIVO@AGENTECAPITAL.COM","SISTEMAS@ASESORESCAPITAL.COM", "CAPITALHUMANO@AGENTECAPITAL.COM", "ASISTENTEDIRECCION@AGENTECAPITAL.COM", "AUDITORINTERNO@AGENTECAPITAL.COM","ASISTENTEDIRECCION@AGENTECAPITAL.COM");
    //$positionData = $this->operPersona->puestoDePersona($this->tank_auth->get_idPersona());
    $positions = $this->operPersona->getAllPositions(); //Obtener todas los puestos
    $areas = $this->operPersona->colaboradorarea(null); //obtener todas las areas
    //$areasFilter = array();
    $areas_ = array();

    $this->datos['personaArea'] = !in_array($this->tank_auth->get_usermail(), $superior) ? $this->operPersona->getMyAreas() : $areas; //$areasFilter;

    if(isset($_POST["idPersonas"])){

      $positionData = $this->operPersona->puestoDePersona($_POST['idPersonas']); //Obtener el puesto de la persona
      $getAreaActual = $this->operPersona->getPositionInPersonalData($_POST['idPersonas']); //Ubica en la tabla de puestos el puesto que tiene en su registro en la tabla de personas.
      $idd = !empty($getAreaActual) ? $getAreaActual->idColaboradorArea : 0;
      $idd2 = !empty($getAreaActual) ? $getAreaActual->creator : $this->tank_auth->get_usermail();
      $acco = !in_array($this->tank_auth->get_usermail(), $superior) ? $this->tank_auth->get_usermail() : $idd2;
      
      if(!empty($positionData)){ //Si tiene un puesto en personapuesto

        $idArea = $positionData[0]->idColaboradorArea;
        $areas_ = $this->operPersona->obtenerColaboradorArea($idArea); //Obtener el area (nombre) del puesto de usuario seleccionado

        $this->datos['personaPuestoCatalogo'] = !in_array($this->tank_auth->get_usermail(), $superior) ? 
          $this->operPersona->getMyPositionsByAreaAndEmail($idd2, $areas_[0]->idColaboradorArea) : 
          $this->operPersona->getAvaliblePositions(array_values($areas_));

      } else{
        
        //$_areas = $this->operPersona->getMyPositionsByAreaAndEmail($acco, $idd); //devuelve el area especifico
        $this->datos['personaPuestoCatalogo'] = $this->operPersona->getMyPositionsByAreaAndEmail($idd2, $idd);
      }
    } else{
      //En caso de que no, devuelve los puestos disponibles del primer área
      $this->datos['personaPuestoCatalogo'] = $this->operPersona->getPositions_($this->tank_auth->get_usermail(), $this->datos['personaArea']);
    }
    //---------------------

    if(isset($_GET["prospecto"])){ //Dennis Castillo [2021-10-31]
      $this->datos["prospectiveAgent"] = $_GET["prospecto"];
    }

    if(isset($_GET["liberar"])){ //Dennis Castillo [2021-10-31]
      $this->datos["setfree"] = $_GET["liberar"];
    }

    if(isset($_GET["permitir"])){ //Dennis Castillo [2021-10-31]
      $this->datos["permit"] = $_GET["permitir"];
    }
    //$this->datos['personaPuestoCatalogo']=$this->operPersona->obtenerPuestos();
    //$this->datos['personaArea']=$this->operPersona->colaboradorarea(null);
    //$this->datos['coordinadores']=$this->operPersona->devuelveCoordinadoresVentas();
   
   
   if(!isset($this->datos['puestoColaborador']))
    {
      $this->datos['puestoColaborador']['personaPuesto']='';
     $this->datos['puestoColaborador']['idPuesto']=0;
    }

    //Modificacion
    if(isset($_POST['idPersonas'])){
    $dia=date('d');
    $mes=date('m');
    $year=date('Y');

    $this->datos['btnFastFile']="<a href=".base_url()."fastFile/getTablero?idPersona=".$_POST['idPersonas']."&year=".$year."><button class='btn btn-primary btn-md'><i class='fa fa-file-text'></i> Fast File</button></a>";
    }
    if(isset($_POST['quitarFiltroActivo'])){$this->datos['quitarFiltroActivo']='';}

     //Modificacion Miguel Jaime 26-11-2021
    $this->datos['experiencias']=$this->operPersona->experienciasPuesto();  
    $this->datos['deletePermission'] = $deletePermission;
    $this->datos["inDeleteProcessing"] = array_map(function($arr){ return $arr->idPersona; }, $this->operPersona->getAllDeleteRequest());
	$this->datos["welcomePermission"] = $welcomePermission;

	
	$this->load->view('persona/agregaAgente',$this->datos);

} 
//--------------------------------------------------------------------------------------------
function manejoColaborador(){

  try{

    $_POST['fechaNacimiento'] =$this->convierteFecha($_POST['fechaNacimiento']);
    $_POST['fecAltaSistemPersona'] =$this->convierteFecha($_POST['fecAltaSistemPersona']); //Dennis [2021-07-29]
    $_POST['fecIniCedulaPersona']=$this->convierteFecha($_POST['fecIniCedulaPersona']);
    $_POST['fecFinCedulaPersona']=$this->convierteFecha($_POST['fecFinCedulaPersona']);
    $_POST['fecIniPRCAgentePersona']=$this->convierteFecha($_POST['fecIniPRCAgentePersona']);
    $_POST['fecFinPRCAgentePersona']=$this->convierteFecha($_POST['fecFinPRCAgentePersona']);
    unset($_POST['cotizasAcciEnferm']);
    unset($_POST['cotizaFianzas']);
    unset($_POST['cotizaVehiculos']);
    unset($_POST['cotizaDanios']);
    unset($_POST['cotizaVida']);
    unset($_POST['endoModif']);
    unset($_POST['recabarInfo']);
    unset($_POST['cobranzaPri']);
    unset($_POST['asesoriaProduc']);

    $banned=$_POST['banned'];

    if($this->emailUser!="CAPITALHUMANO@AGENTECAPITAL.COM" )
    {
        if(isset($_POST['usuarioPersona'])){$usuarioPersona=$_POST['usuarioPersona'];}
        if(isset($_POST['usuarioPassword'])){$usuarioPassword=$_POST['usuarioPassword'];}
        if(isset($_POST['IDVend'])){$idVend=$_POST['IDVend'];}
        $banned=$_POST['banned'];
        $usuarioCarCapital=$_POST['UsuarioCarCapital'];
		$aliadoCarCapital=$_POST['aliadoCarCapital'];
        $codeCarCapital=$_POST['CodeAuthUserPersonaSicas'];   
        
    }
    else
    {
        $_POST["id_catalog_canales"]=17; //unset($_POST['id_catalog_canales']);
        unset($_POST['idpersonarankingagente']);
        unset($_POST['banned']);
        unset($_POST['UsuarioCarCapital']);
		unset($_POST['aliadoCarCapital']);
        unset($_POST['usuarioPersona']);
        unset($_POST['usuarioPassword']);
        unset($_POST['IDVend']);
        unset($_POST['CodeAuthUserPersonaSicas']);
    }
    if((int)$_POST['idPersona']>0)
    {
      
      $this->operPersona->guardarPermisoTipoAgente($_POST['idPersona'],$_POST['permisoPTA']);
      unset($_POST['permisoPTA']);
      $id=$_POST['idPersona'];unset($_POST['idPersona']); 
          /*=====================ACTUALIZA COLABORADOR======================*/
          if($this->tank_auth->get_usermail()=='DIRECTORGENERAL@AGENTECAPITAL.COM' or $this->tank_auth->get_usermail()=='AUDITORINTERNO@AGENTECAPITAL.COM' or $this->tank_auth->get_usermail()=='SISTEMAS@ASESORESCAPITAL.COM')
          {
            
          /*ACTUALIZA LOS DATOS DE EMPRESA EN LA TABLA DE USERS Y USER_MIINFO*/                  
          $this->actualizaDatosEmpresa($id,$usuarioPersona,$usuarioPassword,$idVend,$banned,$usuarioCarCapital,$codeCarCapital,$aliadoCarCapital);                  
                // $this->ws_sicas->actualizarVendedorSicas($id);
                  unset($_POST['usuarioPersona']);unset($_POST['usuarioPassword']);unset($_POST['banned']);unset($_POST['UsuarioCarCapital']);unset($_POST['IDVend']);
                  unset($_POST['aliadoCarCapital']);
            }
            else
            {
              unset($_POST['banned']);
              unset($_POST['aliadoCarCapital']);
              unset($_POST['UsuarioCarCapital']);unset($_POST['id_catalog_canales']);unset($_POST['idpersonarankingagente']);unset($_POST['usuarioPersona']);unset($_POST['usuarioPassword']);
                }             
            $this->operPersona->actualizaPersona($_POST,$id);
            $_POST['idPersonas']=$id;
            $_POST['banned']=$banned;
            $this->guardaEnUser(1,"U");
            unset($_POST['banned']);
            $this->guardaMiInfo($_POST,1,"U");

            if(isset($_POST["setfree"])){ //Dennis Castillo [2021-10-31] //&& $_POST["sendNotification"] == 1

              $this->generatePassCode($_POST["setfree"]);
              //$this->sendWelcomeMessage($_POST["setfree"]);
              $update = $this->operPersona->updateStatusEmployeeToUser(
                array("avance" => "liberado"),
                $_POST["setfree"], 
                array("person" => $_POST["setfree"], "status" => "released")
              );
              //$released = $this->operPersona->updateProgressNewPerson($_POST["setfree"], array("status" => "released")); //Tabla general
            }

    }
    else
    {
      
      $this->operPersona->guardarPermisoTipoAgente($_POST['idPersona'],$_POST['permisoPTA']);

      unset($_POST['permisoPTA']);
      $_POST['userEmailCreacion']=$this->emailUser;
      //$_POST['idPersonas']=$this->operPersona->insertaPersona($_POST);
      //------------------
      //Dennis Castillo [2021-11-04]
      $_idPersona = $this->operPersona->insertaPersona($_POST);
      $_POST['idPersonas'] = $_idPersona;
      //------------------
      $this->guardaEnUser(1,"I");
      $this->guardaMiInfo($_POST,1,"I");

      if(isset($_POST["permit"])){ //Dennis Castillo [2021-10-31]

        $emails = array("ASISTENTEDIRECCION@AGENTECAPITAL.COM", "CONTABILIDAD@AGENTECAPITAL.COM", "DIRECTORGENERAL@AGENTECAPITAL.COM", "SISTEMAS@ASESORESCAPITAL.COM"); //"CAPITALHUMANO@AGENTECAPITAL.COM",
        $typePerson = "COLABORADOR";
        $getTemporalData = array_filter($this->operPersona->getTemporalPersons(), function($arr){
          return $arr->idTemporalPerson == $_POST["permit"];
        });
        $idPersonas_and_emails = array_map(function($arr){

          $idPersona = $this->operPersona->obtenerIdPersonaPorEmail($arr);
          return array("idPersona" => $idPersona->idPersona, "email" => $arr);
      
        }, $emails);

        if(!empty($getTemporalData)){
          foreach($getTemporalData as $t_d){

            $getMail = $this->operPersona->obtenerIdPersonaPorEmail($t_d->creator);
            $creator = $t_d->creator;
            $notification = $this->sendNotification(array(array("idPersona" => $getMail->idPersona, "email" => $t_d->creator)), "COLABORADOR", $_POST["permit"], "RESPUESTA_ALTA", "RESPUESTA_ALTA");

          }
        }

        $notification = $this->sendNotification($idPersonas_and_emails, $typePerson, $_idPersona, "PROGRESO_DOCUMENTACION_".$typePerson, "PROGRESO_DOCUMENTACION_".$typePerson);
        $this->operPersona->deleteTemporalPerson($_POST["permit"]);
      }

      //if(empty($getCreatorEmployee)){ //$permitCreator && 

        //$insert = $this->operPersona->insertaRegistro(array("idChild" => $_idPersona, "creator" => $creator), "true_creator");
      //}

      $this->datos['mensajePersona']='alert("Colaborador guardado")';
      
      /*CREAR NUEVO COLABORADOR*/
    }
  //  $this->datos['mensajePersona']='alert("Colaborador")';
	//Fin del try
  } catch(Exception $e){
	echo "Excepción capturado: ".$e->getMessage();
  }
}
//------------------------------------------------------------------------------
function permisoAgenteV3(){
  /*NOS PERMITE PASAR AL AGENTE PARA QUE SE VERIFIQUEN SUS DATOS Y PODER DAR DE ALTA EN V3*/
    if($_POST['idPasarAgente']!=''){
    $id=$_POST['idPasarAgente']; 
      $this->operPersona->solicitarPermisoCapsys($id,4);}
    else{$this->datos['mensajePersona']='alert("Escoge al agente, buscalo y luego solicitas permiso para CAPSYS")';}
 
}
//-------------------------------------------------------------------------------
function buscarPersona($tipoPersona, $email = null){
    /*BUSCA LOS DATOS DE LA PERSONA*/
    /*EL $tipoPersona SE REFIERE  A SI ES EMPLEADO(1) O AGENTE(3) */
      //$this->datos['datosAgente']= $this->operPersona->buscaPersona($_POST["idPersonas"],$this->emailUser,0);
      //var_dump($email);
      $creator = !empty($email) ? $email : $this->tank_auth->get_usermail();
      $this->datos['datosAgente']= $this->operPersona->buscaPersona($_POST["idPersonas"], $creator, 0);

      $idColaborador = $this->datos['datosAgente']->idColaboradorArea;
      $datosMiInfo=$this->operPersona->obtenerDatosMiInfo($_POST['idPersonas']);
      $agenteActual=$this->operPersona->devuelveTipoAgenteActual($_POST['idPersonas']); //[Dennis 2020-06-02]
      $canalActual=$this->operPersona->devuelveCanalActual($_POST['idPersonas']); //[Dennis 2020-06-02]
      $requerimientosExtras=$this->operPersona->requerimientosExtras($_POST['idPersonas']); //[Dennis 2020-06-02]
      $requerimientosPerfil=$this->operPersona->requerimientosPerfil($_POST['idPersonas']); //[Dennis 2020-06-02]

      $this->datos['datosAgente']->fechaNacimiento=$this->convierteFecha($this->datos['datosAgente']->fechaNacimiento);
      $this->datos['datosAgente']->fecIniCedulaPersona=$this->convierteFecha($this->datos['datosAgente']->fecIniCedulaPersona);
      $this->datos['datosAgente']->fecFinCedulaPersona=$this->convierteFecha($this->datos['datosAgente']->fecFinCedulaPersona);
      $this->datos['datosAgente']->fecIniPRCAgentePersona=$this->convierteFecha($this->datos['datosAgente']->fecIniPRCAgentePersona);
      $this->datos['datosAgente']->fecFinPRCAgentePersona=$this->convierteFecha($this->datos['datosAgente']->fecFinPRCAgentePersona);
      $this->datos['datosAgente']->fecInicioBaneo=$this->convierteFecha($this->datos['datosAgente']->fecInicioBaneo);
      $this->datos['datosAgente']->fecAltaSistemPersona=$this->convierteFecha(date("Y-m-d", strtotime($this->datos['datosAgente']->fecAltaSistemPersona))); //Dennis [2021-07-29]

      $this->datos['colaboradorArea']=$this->datos['datosAgente']->idColaboradorArea;
      $this->datos['datosAgente']->sueldoPercibido = !empty($requerimientosExtras) ? $requerimientosExtras->sueldoPercibido : null;
      $this->datos['datosAgente']->fondoAhorro = !empty($requerimientosExtras) ? $requerimientosExtras->fondoAhorro : null;
      $this->datos['datosAgente']->contrato = !empty($requerimientosExtras) ? $requerimientosExtras->contrato : null;
      $this->datos['datosAgente']->escolar = !empty($requerimientosPerfil) ? $requerimientosPerfil->escolar : null;
      $this->datos['datosAgente']->habilidadDecision = !empty($requerimientosPerfil) ? $requerimientosPerfil->habilidadDecision : null;
      $this->datos['datosAgente']->habilidadPersonal = !empty($requerimientosPerfil) ? $requerimientosPerfil->habilidadPersonal : null;
      $this->datos['datosAgente']->habilidadAdministrativa = !empty($requerimientosPerfil) ? $requerimientosPerfil->habilidadAdministrativa : null;
      $this->datos['datosAgente']->psicometria = !empty($requerimientosPerfil) ? $requerimientosPerfil->psicometria : null;
      $this->datos['datosAgente']->valorOrganizacional = !empty($requerimientosPerfil) ? $requerimientosPerfil->valorOrganizacional : null;
      $this->datos['datosAgente']->experienciaLaboral = !empty($requerimientosPerfil) ? $requerimientosPerfil->experienciaLaboral : null;
      //---------------------
      $this->datos['personalPhoto'] = $this->operPersona->getPersonalPicture($_POST['idPersonas']);
      $this->datos["crossToInducction"] = $this->manageProgressRegister($_POST['idPersonas'], $tipoPersona);
      $this->datos["sendWelcome"] = $this->operPersona->getInducctionFreePerson($_POST['idPersonas']);
      //---------------------
      //Necesario en caso de liberar a un usuario (Ultimo proceso de alta).

      $areaParam = new stdClass();
      $areaParam->idColaboradorArea = $this->datos['datosAgente']->idColaboradorArea;
      $jobsForInsert = $this->operPersona->getAvaliblePositions(array($areaParam));

      $this->datos["datosAgente"]->arrayTypeAgent = !empty($this->datos['datosAgente']->idModalidad) ? $this->operPersona->obtenerTipoAgentePorModalidad($this->datos['datosAgente']->idModalidad) : array();
      $this->datos["datosAgente"]->arrayTypeChannel = $this->operPersona->obtenerCanalPorTipoAgente($this->datos['datosAgente']->personaTipoAgente);
      $this->datos["datosAgente"]->arrayTypeJobs = $jobsForInsert; //$this->operPersona->obtenerCanalPorTipoAgente($this->datos['datosAgente']->personaTipoAgente);
      //---------------------

      if($tipoPersona==3 || $tipoPersona==4)
      {
          $this->datos['datosAgente']->cotizasAcciEnferm=$this->operPersona->obtenerPermisoVendedores("ACCIDENTES_Y_ENFERMEDADES",$_POST["idPersonas"]);
          $this->datos['datosAgente']->cotizaDanios=$this->operPersona->obtenerPermisoVendedores("DANOS",$_POST["idPersonas"]);
          $this->datos['datosAgente']->cotizaFianzas=$this->operPersona->obtenerPermisoVendedores("FIANZAS",$_POST["idPersonas"]);
          $this->datos['datosAgente']->cotizaVehiculos=$this->operPersona->obtenerPermisoVendedores("VEHICULOS",$_POST["idPersonas"]);
          $this->datos['datosAgente']->cotizaVida=$this->operPersona->obtenerPermisoVendedores("VIDA",$_POST["idPersonas"]);
          $this->datos['datosAgente']->permisosAgentes=$this->traeFacultadesMiinfo($_POST["idPersonas"]); 
          $this->datos['documentosSubidos']=$this->operPersona->obtenerDocumentosSubidosLaoyut($_POST['idPersonas']);/*CHECAR ESTE PUNTO*/
          $this->datos['obtenerArchivosObligatorios']=$this->operPersona->obtenerArchivosObligatorios($_POST['idPersonas']); //[Dennis 2020-04-01]
          //$this->datos['agenteActual']=$this->operPersona->devuelveTipoAgenteActual($_POST['idPersonas']); //[Dennis 2020-04-15]
          $this->datos['datosAgente']->personTipoAgenteNombre=$agenteActual->personaTipoAgente;
          $this->datos['datosAgente']->canalNombre=$canalActual->nombreTitulo;
          //$this->datos['canalActual']=$this->operPersona->devuelveCanalActual($_POST['idPersonas']);//[Dennis 2020-04-15]
          $this->datos['docObligatorios']=$this->operPersona->docObligatorios($_POST['idPersonas']);
          $datosCatalogoVendedores=$this->operPersona->obtenerDatosCatalogoVendedores($_POST['idPersonas'],'honorariosCVH,IDVendNS,promotoriasActivadasCP');
          $this->datos['datosAgente']->honorariosCVH=$datosCatalogoVendedores->honorariosCVH;
          $this->datos['datosAgente']->IDVendNS=$datosCatalogoVendedores->IDVendNS; 
          $this->datos['datosAgente']->promotoriasActivadasCP=$datosCatalogoVendedores->promotoriasActivadasCP;
          $this->datos['datosAgente']->certificacion=$datosMiInfo->certificacion;
          $this->datos['datosAgente']->certificacionAutos=$datosMiInfo->certificacionAutos;
          $this->datos['datosAgente']->certificacionGmm=$datosMiInfo->certificacionGmm;
          $this->datos['datosAgente']->certificacionVida=$datosMiInfo->certificacionVida;
          $this->datos['datosAgente']->certificacionDanos=$datosMiInfo->certificacionDanos;
          $this->datos['datosAgente']->certificacionFianzas=$datosMiInfo->certificacionFianzas;
          $this->datos['datosAgente']->IDValida=$datosMiInfo->IDValida;
          $target=$this->operPersona->obtenerTarget($_POST['idPersonas'],0);
          $this->datos['target']=$target['target'];
          $this->datos['targetPersona']=$target['targetPersona'];  
          $this->datos['documentosFormato']=$this->operPersona->obtenerLayout($_POST['idPersonas']);
          $this->datos['camposObligatorios']=$this->operPersona->verificarCantidadObligatorios($_POST['idPersonas']);
          $this->datos['tipoPersona']=3;
      }
      else
      {
        $this->datos['tipoPersona']=1; 
          $this->datos['datosAgente']->IDValida="SN";          
          $this->datos['datosAgente']->personTipoAgenteNombre=$agenteActual->personaTipoAgente;
          $this->datos['datosAgente']->canalNombre=$canalActual->nombreTitulo; //requerimientosExtras
          $this->datos['documentosFormato'] = $this->operPersona->geteEmployeLayout();
          $this->datos['documentosSubidos'] = $this->operPersona->getEmployeFileUpload($_POST['idPersonas'], null, 8);
          //--------------------------          
      }
           $datosUsuario=$this->operPersona->obtenerDatosUsuarios($_POST['idPersonas'],'email,passwordVisible,banned,UsuarioCarCapital,CodeAuthPersonaSicas,CodeAuthUserPersonaSicas,aliadoCarCapital');                  
           $this->datos['datosAgente']->emailUsuario=$datosUsuario->email;
           $this->datos['datosAgente']->passwordUsuario=$datosUsuario->passwordVisible;
           $this->datos['datosAgente']->banned=$datosUsuario->banned;
           $this->datos['datosAgente']->UsuarioCarCapital=$datosUsuario->UsuarioCarCapital;
           $this->datos['datosAgente']->aliadoCarCapital=$datosUsuario->aliadoCarCapital;
           $this->datos['datosAgente']->CodeAuthPersonaSicas=$datosUsuario->CodeAuthPersonaSicas;
           $this->datos['datosAgente']->CodeAuthUserPersonaSicas=$datosUsuario->CodeAuthUserPersonaSicas;
          $this->datos['permisoPersonaTipoAgente']=$this->operPersona->devuelvePermisoTipoAgente($_POST['idPersonas']);
          $this->datos["deleteInProcessing"] = $this->operPersona->getDeleteRequest($_POST['idPersonas']);
           $puestoColaborador=$this->operPersona->puestoDePersona($_POST['idPersonas']);
       
           if((count($puestoColaborador))>0)
            {
              if($puestoColaborador[0]->idPersona>0)
              {

                $this->datos['puestoColaborador']['personaPuesto']=$puestoColaborador[0]->personaPuesto;
                $this->datos['puestoColaborador']['idPuesto']=$puestoColaborador[0]->idPuesto;
              }
              else
                {                
                   $this->datos['puestoColaborador']['personaPuesto']='';
                 $this->datos['puestoColaborador']['idPuesto']=0;

              }
            }
           else{
                 $this->datos['puestoColaborador']['personaPuesto']='';
                $this->datos['puestoColaborador']['idPuesto']=0;
                }

           if($this->mensaje!=""){$datos['mensajePersona']=$this->mensaje;}

          //return $datos;
}
//------------------------ //Dennis Castillo [2022-06-16]
function manageProgressRegister($person, $typePerson){

  $response = array();
  $picture = $this->operPersona->getPersonalPicture($person);

  switch($typePerson){
    case 1:
        $requiredDocs = array_filter($this->operPersona->geteEmployeLayout($person), function($arr){ return $arr->obligatorioPD == "SI" || $arr->obligatorioPD == 1; });
        $docsUploaded = array_filter($this->operPersona->getEmployeFileUpload($person, null, 8), function($arr){ return $arr->obligatorioPD == "SI" || $arr->obligatorioPD == 1;});
        $getCreator = $this->operPersona->getCreatorEmployee(array("idChild" => $person));
        $status = $this->operPersona->getEmployeeById($_POST['idPersonas']);

        $validCreator = !empty($getCreator) && $getCreator[0]->creator == $this->tank_auth->get_usermail();
        $statusProgress = !empty($status) && $status->avance == "documento";
        $countUpladed = !empty($picture) ? count($docsUploaded) + 1 : count($docsUploaded);

        $response = (count($requiredDocs) + 1) == $countUpladed && $statusProgress && $validCreator;
      break;
      default: $response = false;
  }

  return $response;
}
//--------------------------------------------------------------------------------
function manejoAgentes(){
        unset($_POST['permisoPTA']);
        $_POST['fechaNacimiento'] =$this->convierteFecha($_POST['fechaNacimiento']);
        $_POST['fecAltaSistemPersona'] =$this->convierteFecha($_POST['fecAltaSistemPersona']); //Dennis [2021-07-29]
        $_POST['fecIniCedulaPersona']=$this->convierteFecha($_POST['fecIniCedulaPersona']);
        $_POST['fecFinCedulaPersona']=$this->convierteFecha($_POST['fecFinCedulaPersona']);
        $_POST['fecIniPRCAgentePersona']=$this->convierteFecha($_POST['fecIniPRCAgentePersona']);
        $_POST['fecFinPRCAgentePersona']=$this->convierteFecha($_POST['fecFinPRCAgentePersona']);
        $_POST['fecInicioBaneo']=$this->convierteFecha($_POST['fecInicioBaneo']);

         if((int)$_POST['idPersona']>0)
         {  /*ACTUALIZA A PERSONA*/
          
            $id=$_POST['idPersona'];unset($_POST['idPersona']);               
             $this->actualizaCotizacion($id,'ACCIDENTES_Y_ENFERMEDADES',$_POST['cotizasAcciEnferm']);
             $this->actualizaCotizacion($id,'DANOS',$_POST['cotizaDanios']);
             $this->actualizaCotizacion($id,'FIANZAS',$_POST['cotizaFianzas']);
             $this->actualizaCotizacion($id,'VEHICULOS',$_POST['cotizaVehiculos']);
             $this->actualizaCotizacion($id,'VIDA',$_POST['cotizaVida']);
             unset($_POST['cotizasAcciEnferm']);unset($_POST['cotizaFianzas']);unset($_POST['cotizaVehiculos']);unset($_POST['cotizaDanios']);unset($_POST['cotizaVida']);

             $facultades=$_POST['recabarInfo'].";".$_POST['asesoriaProduc'].";".$_POST['cobranzaPri'].";".$_POST['endoModif'].";";
             unset($_POST['recabarInfo']);unset($_POST['asesoriaProduc']);unset($_POST['cobranzaPri']);unset($_POST['endoModif']);
             //unset($_POST['personaTipoAgente']);
             //unset($_POST['id_catalog_sucursales']);
          
              /*=====================ACTUALIZA PERSONA======================*/
            if($this->tank_auth->get_usermail()=='DIRECTORGENERAL@AGENTECAPITAL.COM' or $this->tank_auth->get_usermail()=='AUDITORINTERNO@AGENTECAPITAL.COM' or $this->tank_auth->get_usermail()=='SISTEMAS@ASESORESCAPITAL.COM' ){
                 /*ACTUALIZA LOS DATOS DE EMPRESA EN LA TABLA DE USERS Y USER_MIINFO*/
                $this->actualizaDatosEmpresa($id,$_POST['usuarioPersona'],$_POST['usuarioPassword'],$_POST['IDVend'],$_POST['banned'],$_POST['UsuarioCarCapital'],$_POST['CodeAuthUserPersonaSicas'], $_POST["aliadoCarCapital"]);                  
               //$this->ws_sicas->actualizarVendedorSicas($id);
               $this->actualizarVendedorSicas($id);
                unset($_POST['usuarioPersona']);unset($_POST['usuarioPassword']);unset($_POST['banned']);unset($_POST['UsuarioCarCapital']);unset($_POST['IDVend']);unset($_POST['CodeAuthUserPersonaSicas']);
				        unset($_POST["aliadoCarCapital"]);
              }else{
                unset($_POST['banned']);unset($_POST['UsuarioCarCapital']);unset($_POST['id_catalog_canales']);unset($_POST['idpersonarankingagente']);unset($_POST['usuarioPersona']);unset($_POST['usuarioPassword']);unset($_POST['CodeAuthUserPersonaSicas']);
				unset($_POST["aliadoCarCapital"]);
              }
              //--------------------
              //[Dennis 202-06-03]
              if($this->tank_auth->get_usermail()!="COORDINADORCOMERCIAL@FIANZASCAPITAL.COM"){
                if($_POST["personaTipoAgente"]==1 || $_POST["personaTipoAgente"]==4 ){
                  $_POST['id_catalog_canales']=11;
                }elseif($_POST["personaTipoAgente"]==2 || $_POST["personaTipoAgente"]==3){
                  $_POST['id_catalog_canales']=10;
                }elseif($_POST["personaTipoAgente"]==5 || $_POST["personaTipoAgente"]==7){
                  $_POST['id_catalog_canales']=2;
                }
              } else{
                if($_POST["personaTipoAgente"]==2 || $_POST["personaTipoAgente"]==3){
                $_POST['id_catalog_canales']=3;
                }elseif($_POST["personaTipoAgente"]==7){
                  $_POST['id_catalog_canales']=2;
                }
              }
              //--------------------
              //Actualización realizado por Dennis Castillo.
              //Actualización de cedulaPersonal dependiendo del canal de negocio asignado y Poliza de Responsabilidad Civil.
              if($_POST['cedulaPersona']=="" || $_POST['cedulaPersona']==NULL){
                switch($_POST['id_catalog_canales']){
                  case $_POST['id_catalog_canales']==3: $_POST['cedulaPersona']='Y259406'; #exclusivo a fianzas.
                                                        break;
                  case $_POST['id_catalog_canales']!=3: $_POST['cedulaPersona']='Y259393'; #todos menos fianzas.
                                                        break;}}
              
              if($_POST['tipoCedulaAgentePersona']=="" || $_POST['tipoCedulaAgentePersona']==NULL){
                switch($_POST['id_catalog_canales']){
                  case $_POST['id_catalog_canales']==3: $_POST['tipoCedulaAgentePersona']='F';
                                                        break;
                  case $_POST['id_catalog_canales']!=3: $_POST['tipoCedulaAgentePersona']='W5';
                                                        break;}}
              if($_POST['fecIniCedulaPersona']=="" || $_POST['fecIniCedulaPersona']==NULL){$_POST['fecIniCedulaPersona']="2018-01-12";}
              if($_POST['fecFinCedulaPersona']=="" || $_POST['fecFinCedulaPersona']==NULL){$_POST['fecFinCedulaPersona']="2021-01-12";}
              $_POST['PRCAgentePersona']='05-051-07000113-0000-06';
              $_POST['fecIniPRCAgentePersona']='2020-01-18';
              $_POST['fecFinPRCAgentePersona']='2021-01-18';
              
            //$_POST['idPersonaPuesto']=0;
             $this->operPersona->actualizaPersona($_POST,$id);
            $_POST['idPersonas']=$id;
            $_POST['facultades']=$facultades;
            $this->guardaMiInfo($_POST,3,"U");
            $tipoPersona=0;
            if($_POST['tipoPersona']==5){
            $tipoPersona=5;
           }else{
            $tipoPersona=3;   
           }
            $this->guardaEnUser($tipoPersona,"U"); 
            $this->guardaEnCatalogVendedores("agente","U") ;
            $this->actualizarVendedorSicas($id);
            
            //----------------------
            //Dennis Castillo [2021-10-31]
            if(isset($_POST["setfree"])){ //&& $_POST["sendNotification"] == 1
              $this->generatePassCode($_POST["setfree"]);
              //$this->sendWelcomeMessage($_POST["setfree"]);
              //$released = $this->operPersona->updateProgressNewPerson($_POST["setfree"], array("status" => "released"));
              $prospectiveData = $this->crmproyecto->getProspectiveAgentProgressByIdPerson($_POST["setfree"]);

              if(!empty($prospectiveData)){
                $this->crmproyecto->updateProspectiveStatus(
                  array("b.idProspecto" => $prospectiveData->idProspecto), 
                  array("b.avance" => "liberado", "a.status" => "RECLUTADO"), 
                  array("person" => $_POST["setfree"], "status" => "released")
                );
                //$this->crmproyecto->recruitProspective($prospectiveData->idProspecto);
                //$this->crmproyecto->updateProspectiveUser($prospectiveData->idProspecto, array("avance" => "liberado"));
              }
            }
            //----------------------

            $this->datos['mensajePersona']='alert("Actualizacion Correcta.<br>'.$this->mensaje.'")'; 
          
          }

       else
         {/*=========================INSERTA A PERSONA======================*/
 
           unset($_POST['idPersona']);
           $_POST['userEmailCreacion']=$this->emailUser;
if($_POST['tipoPersona']==5){
            $_POST['tipoPersona']=5;
           }else{
           $_POST['tipoPersona']=3;           
           }
             $cotizasAcciEnferm=$_POST['cotizasAcciEnferm'];
             $cotizaDanios=$_POST['cotizaDanios'];
             $cotizaFianzas=$_POST['cotizaFianzas'];
             $cotizaVehiculos=$_POST['cotizaVehiculos'];
             $cotizaVida=$_POST['cotizaVida'];
             unset($_POST['cotizasAcciEnferm']);
             unset($_POST['cotizaFianzas']);
             unset($_POST['cotizaVehiculos']);
             unset($_POST['cotizaDanios']);
             unset($_POST['cotizaVida']);
             $facultades=$_POST['recabarInfo'].";".$_POST['asesoriaProduc'].";".$_POST['cobranzaPri'].";".$_POST['endoModif'].";";
              unset($_POST['endoModif']);
             unset($_POST['recabarInfo']);
             unset($_POST['asesoriaProduc']);
             unset($_POST['cobranzaPri']);
             //unset($_POST['personaTipoAgente']);
             //unset($_POST['id_catalog_sucursales']);
             //unset($_POST['id_catalog_canales']); [Dennis 2020-06-03]
             unset($_POST['idpersonarankingagente']);
             unset($_POST['banned']);
             unset($_POST['UsuarioCarCapital']);
             unset($_POST['usuarioPersona']);
             unset($_POST['usuarioPassword']);
             unset($_POST['IDVend']);
             unset($_POST['permit']); //Dennis Castillo [2021-10-31]
	//----------------------------------------------------------------------------------------------------------
            //[Dennis 2020-06-03]
            if($this->tank_auth->get_usermail()!="COORDINADORCOMERCIAL@FIANZASCAPITAL.COM"){
              if($_POST["personaTipoAgente"]==1 || $_POST["personaTipoAgente"]==4 ){
                $_POST['id_catalog_canales']=11;
              }elseif($_POST["personaTipoAgente"]==2 || $_POST["personaTipoAgente"]==3){
                $_POST['id_catalog_canales']=10;
              }elseif($_POST["personaTipoAgente"]==5 || $_POST["personaTipoAgente"]==7){
                $_POST['id_catalog_canales']=2;
              }
            } else{
              if($_POST["personaTipoAgente"]==2 || $_POST["personaTipoAgente"]==3){
              $_POST['id_catalog_canales']=3;
              }
            }
            
	//----------------------------------------------------------------------------------------------------------
             //Actualización realizado por Dennis Castillo.
             //Asignación de cedulaPersonal.
            if($_POST['cedulaPersona']=="" || $_POST['cedulaPersona']==NULL){
              switch($_POST['id_catalog_canales']){
                case $_POST['id_catalog_canales']==3: $_POST['cedulaPersona']='Y259406'; #exclusivo a fianzas.
                                                      break;
                case $_POST['id_catalog_canales']!=3: $_POST['cedulaPersona']='Y259393'; #todos menos fianzas.
                                                      break;}}
            if($_POST['tipoCedulaAgentePersona']=="" || $_POST['tipoCedulaAgentePersona']==NULL){
              switch($_POST['id_catalog_canales']){
                case $_POST['id_catalog_canales']==3: $_POST['tipoCedulaAgentePersona']='F';
                                                      break;
                case $_POST['id_catalog_canales']!=3: $_POST['tipoCedulaAgentePersona']='W5';
                                                      break;}}
            if($_POST['fecIniCedulaPersona']=="" || $_POST['fecIniCedulaPersona']==NULL){$_POST['fecIniCedulaPersona']="2018-01-12";}
            if($_POST['fecFinCedulaPersona']=="" || $_POST['fecFinCedulaPersona']==NULL){$_POST['fecFinCedulaPersona']="2021-01-12";}
            $_POST['PRCAgentePersona']='05-051-07000113-0000-06';
            $_POST['fecIniPRCAgentePersona']='2020-01-18';
            $_POST['fecFinPRCAgentePersona']='2021-01-18';          

             /*=========================INSERTAR PERSONA===================*/
            //------------------------
            //Dennis Castillo [2021-10-31]
            //$_POST['idPersonas']=$this->operPersona->insertaPersona($_POST);
            $idPersona_ = $this->operPersona->insertaPersona($_POST);
            $_POST['idPersonas'] = $idPersona_;

            if(isset($_POST["prospectiveAgent"])){

              $updateProspectiveData  = $this->crmproyecto->updateProspectiveStatus(array("a.id" => $_POST["prospectiveAgent"]), array(
                "a.status" => "EN PROCESO",
                "b.idPersona" => $idPersona_,
                "b.avance" => "documento",
              ), null);

              //$insertInProspective = $this->crmproyecto->updateProspectiveUser($_POST["prospectiveAgent"], array(
                //"idPersona" => $idPersona_,
                //"avance" => "documento"
              //));

              //------------------
              $emails = array("ASISTENTEDIRECCION@AGENTECAPITAL.COM", "CONTABILIDAD@AGENTECAPITAL.COM", "DIRECTORGENERAL@AGENTECAPITAL.COM", "SISTEMAS@ASESORESCAPITAL.COM"); //"CAPITALHUMANO@AGENTECAPITAL.COM",
              $typePerson = "AGENTE";
              $idPersonas_and_emails = array_map(function($arr){

                $idPersona = $this->operPersona->obtenerIdPersonaPorEmail($arr);
                return array("idPersona" => $idPersona->idPersona, "email" => $arr);

              }, $emails);

              $notification = $this->sendNotification($idPersonas_and_emails, $typePerson, $idPersona_, "PROGRESO_DOCUMENTACION_".$typePerson, "PROGRESO_DOCUMENTACION_".$typePerson);
              //------------------

              //$updateStatus = $this->crmproyecto->updateStatusProspective($_POST["prospectiveAgent"]);
            }
             
            //$insertInTemporal = $this->operPersona->insertaRegistro(array("idPersona" => $idPersona_), "temporal_persons");
            
            //------------------------
             /*=========================GUARDA FACULTADES===================*/
             $this->guardaCotizacion($_POST['idPersonas'],'ACCIDENTES_Y_ENFERMEDADES',$cotizasAcciEnferm);           
             $this->guardaCotizacion($_POST['idPersonas'],'DANOS',$cotizaDanios);           
             $this->guardaCotizacion($_POST['idPersonas'],'FIANZAS',$cotizaFianzas);           
             $this->guardaCotizacion($_POST['idPersonas'],'VEHICULOS',$cotizaVehiculos);           
             $this->guardaCotizacion($_POST['idPersonas'],'VIDA',$cotizaVida);                                       
             $_POST['facultades']=$facultades;
              
            /*==========================INSERTA EN USER_MIINFO===============*/   
               $tipoPersona=0;
            if($_POST['tipoPersona']==5){
            $tipoPersona=5;
           }else{
            $tipoPersona=3;   
           }   
             $this->guardaMiInfo($_POST,$tipoPersona,"I"); 

             
            /*==========================INSERTA EN USER======================*/
            $this->guardaEnUser(3,"I");                        
             $this->datos['mensajePersona']='alert("Agente temporal guardado")';
             /*=========================INSERTA EN CATALOG_VENDEDORES=================*/
             $this->guardaEnCatalogVendedores("agente","I");

             
             
          }

}
//--------------------------------------------------------------------------------------------
public function guardaTarget(){
 if(isset($_POST['target'])){
 	 $total=count($_POST['target']);
  $tipoTarget=$this->operPersona->obtenerTipoTarget($_POST['target'][0]);

  for($i=0;$i<$total;$i++){
  	$datos['idTarget']=$_POST['target'][$i];
  	$datos['tipoTarget']=$tipoTarget[0]->tipoTarget;
  	$datos['idPersona']=$_POST['idPersonaTarget'];
  	$this->operPersona->guardarTargetPersona($datos);
  	//
  }
 
 }
 $_POST['idPersonas']=$_POST['idPersonaTarget'];
 $this->agente();
}
//--------------------------------------------------------------------------------------------
private function guardaEnUser($tipoPersona,$tipoGuardado){
/*PARA EMPEZAR VER SI EXISTE*/
	$insertar['name_complete']=$_POST['apellidoPaterno']." ".$_POST['apellidoMaterno']." ".$_POST['nombres'];	
  $insertar['IDVendNS']=$_POST['IDVendNS'];
  
   if(isset($_POST['idpersonarankingagente']))
   {
          if($_POST['idpersonarankingagente']==""){$insertar['idTipoUser']=6;}
          else{$ranking=$this->operPersona->obtenerIdCatalogTipoUser($_POST['idpersonarankingagente']);$insertar['idTipoUser']=$ranking->idTipoUser;}
   }
 

	if($tipoGuardado=='I'){	
     if($tipoPersona==1){$insertar['IDVend']=0;$insertar['IDVendNS']=0;$insertar['idTipoUser']=11;}
     else{$insertar['IDVend']=($_POST['idPersonas']*1000);$insertar['IDVendNS']=7;$insertar['idTipoUser']=6;}

	if($tipoPersona==1){
      $insertar['profile'] = 4;
      $carCapital="SI";
     }else{
      if($tipoPersona==5){
        $insertar['profile'] = 6;
        $carCapital="NO";
      }else{
        $insertar['profile'] = 1;
        $carCapital="SI";
      }
     } 
     $insertar['IDGrupo']=0;	$insertar['IDSGrupo']=0;	$insertar['ActCreadaPorOtro']="NO";$insertar['activated']=1;	$insertar['UsuarioCarCapital']=$carCapital;$insertar['banned']=0;$insertar['username']=$_POST['idPersonas'];$insertar['idPersona']=$_POST['idPersonas'];	$insertar['email']=$_POST['idPersonas'];$insertar['password']="";
     $this->operPersona->insertarEnUSer($insertar);
   }
	else{
         if($_POST['tipoPersona']==1)
          { 
            $insertar['banned']=$_POST['banned'];
            $insertar['tipoPersona']=1;
          }
          else
          {
 if($_POST['tipoPersona']==5){
              $insertar['profile']=6;
              $insertar['UsuarioCarCapital']="NO";
            }else{
            $insertar['idTipoUser']=6;
            $insertar['profile']=1;
}
          }
         $insertar['CodeAuthPersonaSicas']=$_POST['CodeAuthPersonaSicas']; //$insertar['CodeAuthUserPersonaSicas']=$_POST['CodeAuthUserPersonaSicas'];
         $this->operPersona->actualizaUser($insertar,$_POST['idPersonas']);
      }
}
//--------------------------------------------------------------------------------------------
private function guardaEnCatalogVendedores($tipoPersona,$tipoGuardado){

	$insertar['NombreCompleto']=$_POST['apellidoPaterno']." ".$_POST['apellidoMaterno']." ".$_POST['nombres'];
	$insertar['ApellidoP']=$_POST['apellidoPaterno'];
	$insertar['ApellidoM']=$_POST['apellidoMaterno'];
	$insertar['Nombre']=$_POST['nombres'];	
  $insertar['honorariosCVH']=$_POST['honorariosCVH'];	
  $insertar['IDVendNS']=$_POST['IDVendNS'];
  $insertar['promotoriasActivadasCP']=$_POST['promotoriasActivadas'];
  
	if($tipoGuardado=='I'){	$insertar['IDVend']=($_POST['idPersonas']*1000);$insertar['idPersona']=$_POST['idPersonas'];	$insertar['IDVendNS']=7;$insertar['tipoVend']=1;$insertar['Status_txt']="INACTIVO";$this->operPersona->insertarEnCatalogVendedores($insertar);}
	else{$this->operPersona->actualizarCatalogVendedores($insertar,$_POST['idPersonas']); }
}

//--------------------------------------------------------------------------------------------

public function rechazoAgente(){

  $idPersona=$_POST['textRechazoAgente'] ;
  $this->operPersona->solicitarPermisoCapsys($idPersona,$_POST['textRechazoAgente'] );
  $nombre=$this->operPersona->obtenerNombrePersona($idPersona);
  $para= $this->operPersona->obtenerUsuarioCreacion($idPersona); 
    $mensaje="El agente ".$nombre." es rechazado por: ".$_POST['ttRechazoAgente'];
   $this->operPersona->enviarCorreo($para,"Agente rechazado para V3",$mensaje);
  $_POST=NULL;
  //$_POST["idPersonas"]=$idPersona;
  $this->agente();	
}

//--------------------------------------------------------------------------------------------
public function actualizaDatosEmpresa($idPersona,$email,$password,$idVend,$banned,$carCapital,$codeCarCapital, $aliadoCarCapital){
	//$idPersona=$_POST['idActualizaAgente'] ;

   if($this->operPersona->compruebaExistenciaEmail($email,$idPersona))
   {
	$this->mensaje='La actualizacion del campo usuario es invalido ya existe';
   }
   else
   {                       
  if($email=="" || $password==""){$this->mensaje="EL campo usuario y/o password no pueden estar en blanco";}
    else
     {
   $idUsuario=$this->operPersona->obtenerIdUser($idPersona);
   $this->tank_auth->change_password_user($idUsuario,strtoupper($password));
   $datosUsers['email']=$email;
   $datosUsers['passWordVisible']=$password;
   $datosUsers['IDVend']=$idVend;
   $datosUsers['banned']=$banned;
   $datosUsers['UsuarioCarCapital']=$carCapital;
   $datosUsers['CodeAuthUserPersonaSicas']=$codeCarCapital;
$datosUsers['aliadoCarCapital'] = $aliadoCarCapital;
   $this->operPersona->actualizarDatosEmpresa($idUsuario,$datosUsers,$idPersona);
   $this->operPersona->solicitarPermisoCapsys($idPersona,3);

   }
 }
  //$_POST["idPersonas"]=$idPersona;
  //$this->agente();	
}

//-------------------------------------------------------------------------------------------

public function colaborador(){

       if(isset($_POST["idPersona"]))
       {
        $_POST['fechaNacimiento'] =$this->convierteFecha($_POST['fechaNacimiento']);
        $_POST['fecAltaSistemPersona'] =$this->convierteFecha($_POST['fecAltaSistemPersona']); //Dennis [2021-07-29]
        $_POST['fecIngresoPersona'] =$this->convierteFecha($_POST['fecIngresoPersona']);
         if((int)$_POST['idPersona']>0)
         {  /*ACTUALIZA PERSONA*/
         	$personDepartamentoPuesto['idPersonaDepartamento']=$_POST['personaDepartamento'];
         	$personDepartamentoPuesto['idPersonaPuesto']=$_POST['personaPuesto'];
         	unset($_POST['personaDepartamento']);
          unset($_POST['personaPuesto']);
          $id=$_POST['idPersona'];unset($_POST['idPersona']); 

             $this->operPersona->index("2",$_POST,$id);
            $_POST['idPersonas']=$id;
             $this->operPersona->index("4",$personDepartamentoPuesto,$id);
           
                     $datos['mensajePersona']='alert("Actualizacion Correcta")';

         }
       else
         {/*INSERTA PERSONA*/
           unset($_POST['idPersona']);  
           $_POST['userEmailCreacion']=$this->emailUser;
             $_POST['tipoPersona']=1;
                  if($_POST['personaDepartamento']==""){$personDepartamentoPuesto['departamento']=0;}else{$personDepartamentoPuesto['idPersonaDepartamento']=$_POST['personaDepartamento'];}
                  if($_POST['personaPuesto']==""){$personDepartamentoPuesto['idPersonaPuesto']=0;}else{$personDepartamentoPuesto['idPersonaPuesto']=$_POST['personaPuesto'];}
                     unset($_POST['personaDepartamento']);
                     unset($_POST['personaPuesto']);
                  $_POST['idPersonas']=$this->operPersona->index("1",$_POST,null);
                  $personDepartamentoPuesto['idPersona']= $_POST['idPersonas'];
                  $_POST['idPersonas']=$this->operPersona->index("3",$personDepartamentoPuesto,null);

                     $datos['mensajePersona']='alert("Colaborador guardado")';
          }
        }
       
       if(isset($_POST["idPersonas"]))
        {/*BUSCA PERSONA*/
       	if($_POST["idPersonas"]!="-1"){
       	  $this->operPersona->index("0","select * from persona where   idPersona=".$_POST["idPersonas"],null);
              unset($this->operPersona->datos[0]->userEmailCreacion);          
          $datos['datosAgente']=$this->operPersona->datos[0];
          $datos['datosAgente']->fechaNacimiento=$this->convierteFecha($datos['datosAgente']->fechaNacimiento);
          $datos['datosAgente']->fecIngresoPersona=$this->convierteFecha($datos['datosAgente']->fecIngresoPersona);
          $this->operPersona->index("0","select idPersonaDepartamento,idPersonaPuesto from personadepartamentopuesto where   idPersona=".$_POST["idPersonas"],null);
          $datos['idPersonaDepartamento']=$this->operPersona->datos[0]->idPersonaDepartamento;
          $datos['idPersonaPuesto']=$this->operPersona->datos[0]->idPersonaPuesto;

          }
       }   

       $this->operPersona->index("0","select * from personaescolaridad ",null);
         $datos['escolaridad']=$this->operPersona->datos;
       $this->operPersona->index("0","select * from personaestadocivil ",null);
         $datos['estadoCivil']=$this->operPersona->datos;    
       $this->operPersona->index("0","select idPersona, apellidoPaterno,nombres,apellidoMaterno from persona where tipoPersona=1",null);       
         $datos['agentesTemporales']=$this->operPersona->datos;
       $this->operPersona->index("0","select * from personapuesto ",null);
         $datos['personaPuesto']=$this->operPersona->datos;
	       $this->operPersona->index("0","select * from personadepartamento ",null);
         $datos['personaDepartamento']=$this->operPersona->datos;

       $this->load->view('persona/agregaColaborador',$datos);

}   
//-------------------------------------------------------------------------------------------------------------------------------
private function convierteFecha($fecha){
	$result="";	       
	if($fecha!="")
	{
      if(strpos($fecha,'/')){$fecha=explode('/',$fecha);    $result=$fecha[2].'-'.$fecha[1].'-'.$fecha[0];}
      else{$fecha=explode('-',$fecha);    $result=$fecha[2].'/'.$fecha[1].'/'.$fecha[0];} 
   
	}else{$result=NULL;}

    return $result;
}
//-------------------------------------------------------------------------------------------------------------------------------
public function guardaCotizacion($id,$ramo,$valInicial){

	         $insertar['emailUser']= $id;
	         $insertar['idpersona']= $id;
             $insertar['modulo']='actividades' ;
             $insertar['subModulo']='agregar' ;
             $insertar['tipo']='Cotizacion' ;
             $insertar['ramo']= $ramo;
             $insertar['accion']= 'VER';
             $insertar['permiso']= $valInicial;
            
             $this->operPersona->nuevoPermisoVend($insertar);
}
//-------------------------------------------------------------------------------------------------------------------------------
public function actualizaCotizacion($id,$ramo,$valor){
 $update['idpersona']=$id;
 $update['ramo']=$ramo;
 $update['permiso']=$valor;
 $this->operPersona->actualizaPermisoVend($update);

}
//-------------------------------------------------------------------------------------------------------------------------------
private function guardaMiInfo($datos,$tipoPersona,$tipoGuardado){

	        $insertar['idPersona']=$datos['idPersonas'] ;                   
            $insertar['nombre']=$datos['nombres'] ;
            $insertar['apellidop']=$datos['apellidoPaterno'];
            $insertar['apellidom']=$datos['apellidoMaterno']  ;
            $insertar['rfc']=$datos['rfc']  ;
            $insertar['telefono_casa']=$datos['telCasa']  ;        
            $insertar['telefono_trabajo']=$datos['telOficina']  ;
            $insertar['telefono_celular']=$datos['celPersonal']  ;
            $insertar['fecha_nacimiento']=$datos['fechaNacimiento']  ;
            $insertar['lugar_nacimiento']=$datos['estadoNacimiento']  ;
            $insertar['accidente_avisar']=$datos['accidtePersonaAvisa']  ;
            $insertar['accidente_telefono']=$datos['telPersonaAvisa']  ;
           $insertar['recomendado_por']=$datos['recomendarPersona']  ;
            $insertar['referencias']=$datos['referenciaPersona']  ;
            $insertar['imss']=$datos['imssPersona']  ;
            $insertar['tiene_hijos']=$datos['hijosPersona']  ;
            $insertar['gasto_promedio_mensual']=$datos['gastoMenPersona']  ;
            //$insertar['vehiculo_propio']=$datos['vehiculoPersona']  ;
            $insertar['color_favorito']=$datos['colorFavPersona']  ;
            $insertar['comida_favorita']=$_POST['comidaFavPersona']  ;            
            $insertar['pasatiempo']=$datos['pasatiempoFavPersona']  ;
            $insertar['club_social']=$datos['clubSocialPersona']  ;                       
            $insertar['idPersona']=$datos['idPersonas']  ;
            $insertar['banco']=$this->operPersona->obtenerNombreBanco($datos['idBanco']);
            $insertar['tipo_cuenta']=$datos['cuentaBancoPersona'];
            $insertar['clabe']=$datos['claveBancoPersona'];
            $insertar['cuenta_bancaria']=$datos['tipoCuentaBancoPersona'];
            $insertar['cedula_cnsf']=$datos['cedulaPersona'];
            $insertar['tipo_cedula_cnsf']=$datos['tipoCedulaAgentePersona'];
            $insertar['vigencia_cnsf']=$datos['fecFinCedulaPersona'];
            $insertar['polrescivil']=$datos['PRCAgentePersona'];
            $insertar['vigenciapolrescivil']=$datos['fecFinPRCAgentePersona'];
            $insertar['calle']=$datos['calle'];
            $insertar['no_ext']=$datos['numero'];
            $insertar['cruzamiento']=$datos['cruzamiento'];
            $insertar['colonia']=$datos['colonia'];
            $insertar['cp']=$datos['codigoPostal'];
            $insertar['ciudad']=$datos['municipioDomicilio'];
            //$insertar['modelo_vehiculo']=$datos['modeloVehiculoPersona'];
            /*$insertar['certificacion']=$datos['certificacion'];
            $insertar['certificacionAutos']=$datos['certificacionAutos'];
            $insertar['certificacionGmm']=$datos['certificacionGmm'];
            $insertar['certificacionVida']=$datos['certificacionVida'];
            $insertar['certificacionDanos']=$datos['certificacionDanos'];
            $insertar['certificacionFianzas']=$datos['certificacionFianzas']; */

             $cadFacultades="";
            if($tipoPersona==3){
              $facultades=explode(';',$datos['facultades']);
              $cont=count($facultades);
              for($i=0;$i<$cont;$i++){
              	if($facultades[$i]>-1){
                $cadFacultades=$cadFacultades.$facultades[$i].';';
                }
              }
             $insertar['agenteFacultades']=$cadFacultades;
             $insertar['cedula_cnsf']=$datos['cedulaPersona']  ;  
          
             //$insertar['Giro']=$datos['idpersonagiroagente']  ;

           // $insertar['Ranking']=$datos['idpersonarankingagente']  ;          
          }

            
             //$inserta['estado_civil']=$this->operPersona->obtenerUnEstadoCivil($_POST['estadoCivil']);
             //$inserta['escolaridad']=$this->operPersona->obtenerUnaEscolaridad($_POST['escolaridad']);
            $insertar['cuanto_te_gustaria_ganar']=$datos['metaPersona']  ;                    
            //$insertar['modelo_vehiculo']=$datos['modeloVehiculoPersona']  ;

           if($tipoGuardado=="I")
           {
              if($tipoPersona==3){$insertar['IDVend']=($datos['idPersonas']*1000);}              
             $insertar['emailUser']=$datos['idPersonas'] ;$this->operPersona->nuevoUserConfig($insertar);
            }
           else{$this->operPersona->actualizaUserConfig($insertar,$datos['idPersonas']);}
           

}
//---------------------------------------------------------------------------------------------------------------------------
public function traeFacultadesMiinfo($idPersona){
		
  //$this->operPersona->index("0","select agenteFacultades from  user_miinfo where idPersona=	".$idPersona,null);
  //$resultado=$this->operPersona->datos;
  $resultado=$this->operPersona->obtenerAgenteFacultades($idPersona);
  
  $facultades=explode(';',$resultado[0]->agenteFacultades);
          $cont=count($facultades);
          $recabarInfo=-1;
          $asesoriaProduc=-1;
          $cobranzaPri=-1;
          $endoModif=-1;
          for($i=0;$i<$cont;$i++){
          	switch ($facultades[$i]) {
          		case 0:$recabarInfo=0;break;
                case 1:$asesoriaProduc=1;break;
                case 2:$cobranzaPri=2;break;
                case 3:$endoModif=3;break;
          	}
          }
   $permisos=['recabarInfo'=>$recabarInfo,'asesoriaProduc'=>$asesoriaProduc,'cobranzaPri'=>$cobranzaPri,'endoModif'=>$endoModif];

 return $permisos;	

}


//-------------------------------------------------------------------------------------------------------------------------------
public function recibeTarget(){
    $datos=$this->operPersona->obtenerTarget($_POST['idPersonas'],0);
    $target=$datos['target'];
    $targetPersona=$datos['targetPersona'];
    $nombre=$datos['nombre'][0]->nombre;
    $fecha=$this->convierteFecha($datos['fecha'][0]->fecha);
	$total=count($target);
    $cont=count($targetPersona);

  $options='<style>.classFilaPrimar{background-color: #85cae7}</style><div><table style="margin-left:100px" border=""><tr><td>Estatus</td><td>Agente:'.$nombre.'    Fecha:'.$fecha.'</td></tr>';
  
  for($i=0;$i<$total;$i++){
    $band=0;
    for($j=0;$j<$cont;$j++)
    {
      if($target[$i]->idTarget==$targetPersona[$j]->idTarget){$band=1;$band=$cont;}
    }
   if($band==0){$options=$options.'<tr class="'.$target[$i]->claseFilaTarget.'"><td ><input  type="checkbox" disabled="true" ></td><td>'.$target[$i]->descripcionTarget.'</td></tr>';}
  	else{$options=$options.'<tr class="'.$target[$i]->claseFilaTarget.'"><td ><input  type="checkbox"  disabled="true" checked></td><td>'.$target[$i]->descripcionTarget.'</td></tr>';}
  }
  $options=$options.'</table></div>';
  
  $this->generaPDF($options,$nombre."-Target");

}
//-------------------------------------------------------------------------------------------------------------------------------
public function caratulaAltaAgentes(){
  if($_POST['idPersonaCaratula']!=""){
	$nombrePersona="";$calle="";$numero="";$cruzamientos="";$colonia="";$telefono="";$correo="";  
	$rfc="";$cedulaCNSF="";$tipoCedula="";$vigIniCed="";$vigFinCed="";$polizaRC="";$compania="";$vigIniRC="";$vigFinRC="";$cuentaBanco="";$banco="";$beneficiario="";$fecInicioRelacion="";$curp="";
	$datosPersona=$this->operPersona->buscaPersona($_POST['idPersonaCaratula'],$this->emailUser,0);


  $nombrePersona=$datosPersona->nombres.' '.$datosPersona->apellidoPaterno.' '.$datosPersona->apellidoMaterno;
  $calle=$datosPersona->calle;$numero=$datosPersona->numero;$cruzamientos=$datosPersona->cruzamiento;$colonia=$datosPersona->colonia;$telefono=$datosPersona->telCasa;$correo=$datosPersona->emailPersonal;$rfc=$datosPersona->rfc;
  $cedulaCNSF=$datosPersona->cedulaPersona;$tipoCedula=$datosPersona->tipoCedulaAgentePersona;$vigIniCed=$this->convierteFecha($datosPersona->fecIniCedulaPersona);$vigFinCed=$this->convierteFecha($datosPersona->fecFinCedulaPersona);
  $polizaRC=$datosPersona->PRCAgentePersona;$compania=$datosPersona->PRCCompaniaAgentePersona;$vigIniRC=$this->convierteFecha($datosPersona->fecIniPRCAgentePersona);$vigFinRC=$this->convierteFecha($datosPersona->fecFinPRCAgentePersona);
  $cuentaBanco=$datosPersona->cuentaBancoPersona;
  $banco=$this->operPersona->obtenerNombreBanco($datosPersona->idBanco);
  $curp=$datosPersona->curpPersona;
  $beneficiario=$datosPersona->beneficiarioPersona;
	$caratula='<table width="439"  style="margin-left:20px; margin-right:20px; margin-top:0px">
     <tr><td> <table  border="1" width="100%"><tr align="center"><td>CARATULA DEL CONTRATO MARCO DE PROSPECCION DE NEGOCIOS, MEDIACION Y ADMINISTRACION; AGENTE APODERADO; Y ADMINISTRACION DE CARTERA</td></tr><tr align="right"><td><label style="background:#CCC">FOLIO DE CONTRATO</label>_______________________</td></tr></table></td></tr><tr>
     <td><table  border="1" width="100%"><tr><td ><label class="tdGris">AGENTE MERCANTIL</label><label>             '.$nombrePersona.' </label></td></tr></table></td></tr>
   <tr>
    <td><table border="1" width="100%"><tr><td width="44%"><label class="tdGris">Calle</label><label>             '.$calle.'</label></td><td width="56%"><label class="tdGris">Numero</label><label>             '.$numero.'</label></td></tr><tr><td><label class="tdGris">Cruzamientos</label><label>             '.$cruzamientos.'</label></td><td><label class="tdGris">Colonia</label><label>             '.$colonia.'</label></td></tr><tr><td><label class="tdGris">Telefono</label><label>             '.$telefono.'</label></td><td><label class="tdGris">Correo</label><label>             '.$correo.'</label></td></tr><tr><td><label class="tdGris">Curp</label><label>             '.$curp.'</label></td><td><label class="tdGris">RFC</label><label>             '.$rfc.'</label></td></tr></table></td>
     </tr><tr><td><table border="1" width="100%" height="150"><tr><td width="71" rowspan="6" height="150" class="tdGris">Modalidad</td><td rowspan="2" height="50" class="tdGris">Tipos de modalidad</td>
     <td width="50" colspan="4" class="tdGris" ><label style="width:100px">Porcentaje de Comision</label></td></tr>
     <tr height="50" ><td  height="25" width="50"   class="tdGris"><label>Seguros</label></td><td width="50"  colspan="2" height="25" class="tdGris"><label>Fianzas</label></td>
    </tr><tr>
    <td width="257" height="25"><pre><label style="border:solid 1px;">  </label><label>Prospeccion de negocios</label></pre></td>
    <td>&nbsp;</td>
    <td width="49" colspan="2">&nbsp;</td>
    </tr>
    <tr>
    <td height="25"><pre><label style="border:solid 1px;">  </label><label>Mediacion con administracion</label></pre></td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
    <td height="25"><pre><label style="border:solid 1px;">  </label><label>Agente apoderado</label></pre></td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
    <td height="25"><pre><label style="border:solid 1px;">  </label><label>Administracion de cartera</label></pre></td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    </tr>
    </table></td></tr><tr>
    <td><table border="1" width="100%"><tr>
   <td width="41%"><label class="tdGris">Cedula de CNSF</label><label>             '.$cedulaCNSF.'</label></td>
   <td width="59%"><label class="tdGris">Tipo de Cedula</label><label>             '.$tipoCedula.' </label></td></tr><tr>
       <td><label class="tdGris">Vigencia de cedula de</label><label>             '.$vigIniCed.'</label>
         </td>
       <td><label class="tdGris">a</label><label>             '.$vigFinCed.'</label><tr><td><label class="tdGris">Poliza de RC</label><label>             '.$polizaRC.'    </label></td><td><label class="tdGris">Compañia</label><label>             '.$compania.'</label></td></tr><tr><td><label class="tdGris">Vigencia de Poliza de</label><label>             '.$vigIniRC.'</label></td><td><label class="tdGris">a</label><label>             '.$vigFinRC.'</label></td></tr><tr><td><label class="tdGris">Cuenta de Pago</label><label>             '.$cuentaBanco.'</label></td><td><label class="tdGris">Banco</label><label>             '.$banco.'</label></td></tr><tr><td colspan="2"><label class="tdGris">Beneficiario</label><label>             '.$beneficiario.' </label></td></tr><tr><td colspan="2"><label class="tdGris">Fecha en que inicio la relacion     </label></td></tr></table></td>
     </tr>
   <tr>
   <td><table width="100%" height="93" border="1"><tr><td><label class="tdGris">Merida, Yucatan  a los</label></td><td><label class="tdGris">dias del mes de </label></td><td><label class="tdGris">del año</label></td></tr></table></td>
  </tr>
   <tr>
   <td><table width="100%" height="93" border="1"><tr valign="bottom" align="center"><td width="53%" height="56"><label>POR GAP</label></td><td width="47%"><label>POR EL AGENTE MERCANTIL</label></td></tr></table></td></tr></table>
   <style>label{ font-size:12px;font-weight: 600}.tdGris{ background:#ccc} </style>';
   $this->generaPDF($caratula,$nombrePersona.'-Contrato');
  }
  else{
  	$this->agente();
  }
}

//-------------------------------------------------------------------------------------------------------------------------------
public function manuales(){
  $datos="";
  /*$datos='    @page { margin: 180px 50px; } 
    #header { position: fixed; left: 0px; top: -180px; right: 0px; height: 150px; background-color: orange; text-align: center; } 
    #footer { position: fixed; left: 0px; bottom: -180px; right: 0px; height: 150px; background-color: lightblue; } 
    #footer .page:after { content: counter(page, upper-roman); } 
    </style> ';*/
  $datos=$datos.'<div style="position: fixed; left: 0px; top: 0px; right: 0px; height: 150px; background-color: orange; text-align: center; ">cabecera para todas las hojas</div>';
  $datos=$datos.'<div style="position: fixed; left: 0px; bottom: 0px; right: 0px; height: 150px; background-color: lightblue; ">este es pied de pagina</div>';
$nombre="prueba";
  $datos=$datos.'<div><p>La sabia decisión del rey


Hace muchos años, en un reino muy lejano, vivía un rey viudo con sus queridos hijos los príncipes Luis, Jaime y Alberto. Los muchachos eran trillizos y se parecían muchísimo físicamente: los tres tenían los ojos de un azul casi violeta, la piel blanquísima, el cabello ondulado hasta los hombros, y una exquisita elegancia natural heredada de su madre. Desde su nacimiento habían recibido la misma educación e iguales privilegios, pero lo cierto es que aunque a simple vista solían confundirlos, en cuanto a forma de ser eran completamente distintos.

Luis era un joven un poco estirado, superficial y de gustos refinados que se preocupaba mucho por su aspecto. ¡Nada le gustaba más que vivir rodeado de lujos y adornarse con joyas, cuanto más grandes mejor! Jaime, en cambio, no concedía demasiada importancia a las cosas materiales; él era el típico bromista nato que irradiaba alegría a todas horas y que tenía como objetivo en la vida trabajar poco y divertirse mucho. Alberto, el tercer hermano, era el más tímido y tranquilo; apasionado del arte y la cultura, solía pasar las tardes escribiendo poemas, tocando el arpa o leyendo libros antiguos en la fastuosa biblioteca del palacio.

El día que cumplieron dieciocho años el monarca quiso hacerles un regalo muy especial, y por eso, después de un suculento desayuno en familia, los reunió en el salón donde se celebraban las audiencias y los actos más solemnes. Desde su trono de oro y terciopelo rojo miró feliz a los chicos que, situados de pie frente a él, se preguntaban por qué su padre les había convocado a esa hora tan temprana.


 
– Hijos míos, hoy es un día clave en vuestra vida. Parece que fue ayer cuando vinisteis al mundo y miraos ahora… ¡ya sois unos hombres hechos y derechos!  El tiempo pasa volando  ¿no es cierto?…

La emoción quebró su voz y tuvo que hacer una pequeña pausa antes de poder continuar su  discurso. – He de confesar que llevo meses  pensando qué regalaros en esta importante ocasión y espero de corazón que os guste lo que he dispuesto para vosotros.


 
Cogió una pequeña caja de nácar que reposaba sobre la mesa que tenía a su lado y del interior sacó tres bolsitas de cuero atadas con un hilo dorado.

– ¡Acercaos y tomad una cada uno!

El  viejo rey hizo el reparto y siguió hablando.

– Cada bolsa contiene cien monedas de oro. ¡Creo que es una cantidad suficiente para que os vayáis de viaje durante un mes! Ya sois adultos, así que tenéis libertad para hacer lo que os apetezca y gastaros el dinero como os venga en gana.Los chicos se miraron estupefactos. Un  mes  para hacer lo que quisieran, como quisieran y donde quisieran… ¡y encima con todos los gastos pagados! Al escuchar la palabra ‘regalo’ habían imaginado una capa de gala o unos calzones de seda, pero para nada esta magnífica sorpresa.

– Mi única condición es que partáis este mediodía, así que id a preparar el equipaje mientras los criados ensillan los caballos. Dentro de treinta días, ni uno más ni uno menos, y exactamente a esta hora, nos reuniremos aquí y me contaréis vuestra experiencia ¿De acuerdo?


 
Los tres jóvenes, todavía desconcertados, dieron las gracias y un fuerte abrazo a su padre. Después, como flotando en una nube de felicidad, se fueron a sus aposentos con los bolsillos llenos y la cabeza rebosante de proyectos para las siguientes cuatro semanas.

Cuando el reloj marcó las doce en punto los príncipes abandonaron el palacio, decididos a disfrutar de un mes único e inolvidable. Como es obvio, cada uno tomó la dirección que se le antojó conforme a sus planes.

Luis decidió cabalgar hacia el Este porque allí se concentraban las familias nobles más ricas e influyentes y creyó que había llegado el momento de conocerlas.  Jaime, como buen vividor que era, se fue directo al Sur en busca de sol y alegría. ¡Necesitaba juerga y sabía de sobra dónde encontrarla! A diferencia de sus hermanos, Alberto concluyó que lo mejor era no hacer planes y recorrer el reino sin un rumbo fijo, sin un destino en concreto al que dirigirse.

Un día tras otro las semanas fueron pasando hasta que por fin llegó el momento de regresar y  presentarse en el salón del trono para dar cuentas al rey. Con diferencia de unos minutos los príncipes saludaron a su padre, quien les recibió con cariñoso achuchón.

– Sed bienvenidos, hijos míos. ¡No os imagináis lo mucho que os he echado de menos! Este castillo estaba tan vacío sin vosotros… ¿A qué esperáis para contarme vuestras aventuras? ¡Me tenéis en ascuas!

Luis estaba entusiasmado y deseando ser el primero en relatar su historia. Mirando a su padre y sus hermanos, se explayó:

– ¡La verdad es que yo he tenido un viaje magnífico!  No tardé más de un par de  jornadas en llegar a la ciudad más próspera del reino.

– ¡Caramba, eso es estupendo! ¿Y qué tal te recibieron?

– ¡Uy, maravillosamente! En cuanto se enteraron de mi presencia  los aristócratas me agasajaron con desfiles, fuegos artificiales y todo tipo de festejos. Además, como es natural, el tiempo que permanecí allí me alojé en elegantes palacetes, degusté  exquisitos manjares, y me presentaron a una hermosa y sofisticada duquesa que me robó el corazón…

Luis se quedó mirando al infinito, rememorando con nostalgia aquellos inalmente, el rey se acercó al bueno de Alberto.

– Querido Alberto… Te has convertido en un hombre culto y compasivo. Has aprovechado todos estos años para estudiar y formarte lo mejor posible porque has entendido perfectamente cuáles son las responsabilidades de un príncipe. Te interesa el bienestar de tu pueblo y te preocupan los más desfavorecidos. Mi corazón me dice que tú eres el elegido.

Dicho esto, y ante el asombro del príncipe Luis y del príncipe Jaime,  depositó la corona sobre su cabeza.

– A partir de hoy serás el rey de este reino. Gobierna con justicia y traerás prosperidad, gobierna con bondad y serás amado, gobierna con la razón y serás respetado por las generaciones venideras.  Como a tus hermanos, también a ti te deseo amor y felicidad el resto de tu vida.Hace muchos años, en un reino muy lejano, vivía un rey viudo con sus queridos hijos los príncipes Luis, Jaime y Alberto. Los muchachos eran trillizos y se parecían muchísimo físicamente: los tres tenían los ojos de un azul casi violeta, la piel blanquísima, el cabello ondulado hasta los hombros, y una exquisita elegancia natural heredada de su madre. Desde su nacimiento habían recibido la misma educación e iguales privilegios, pero lo cierto es que aunque a simple vista solían confundirlos, en cuanto a forma de ser eran completamente distintos.

Luis era un joven un poco estirado, superficial y de gustos refinados que se preocupaba mucho por su aspecto. ¡Nada le gustaba más que vivir rodeado de lujos y adornarse con joyas, cuanto más grandes mejor! Jaime, en cambio, no concedía demasiada importancia a las cosas materiales; él era el típico bromista nato que irradiaba alegría a todas horas y que tenía como objetivo en la vida trabajar poco y divertirse mucho. Alberto, el tercer hermano, era el más tímido y tranquilo; apasionado del arte y la cultura, solía pasar las tardes escribiendo poemas, tocando el arpa o leyendo libros antiguos en la fastuosa biblioteca del palacio.

El día que cumplieron dieciocho años el monarca quiso hacerles un regalo muy especial, y por eso, después de un suculento desayuno en familia, los reunió en el salón donde se celebraban las audiencias y los actos más solemnes. Desde su trono de oro y terciopelo rojo miró feliz a los chicos que, situados de pie frente a él, se preguntaban por qué su padre les había convocado a esa hora tan temprana.


 
– Hijos míos, hoy es un día clave en vuestra vida. Parece que fue ayer cuando vinisteis al mundo y miraos ahora… ¡ya sois unos hombres hechos y derechos!  El tiempo pasa volando  ¿no es cierto?…

La emoción quebró su voz y tuvo que hacer una pequeña pausa antes de poder continuar su  discurso. – He de confesar que llevo meses  pensando qué regalaros en esta importante ocasión y espero de corazón que os guste lo que he dispuesto para vosotros.


 
Cogió una pequeña caja de nácar que reposaba sobre la mesa que tenía a su lado y del interior sacó tres bolsitas de cuero atadas con un hilo dorado.

– ¡Acercaos y tomad una cada uno!

El  viejo rey hizo el reparto y siguió hablando.

– Cada bolsa contiene cien monedas de oro. ¡Creo que es una cantidad suficiente para que os vayáis de viaje durante un mes! Ya sois adultos, así que tenéis libertad para hacer lo que os apetezca y gastaros el dinero como os venga en gana.Los chicos se miraron estupefactos. Un  mes  para hacer lo que quisieran, como quisieran y donde quisieran… ¡y encima con todos los gastos pagados! Al escuchar la palabra ‘regalo’ habían imaginado una capa de gala o unos calzones de seda, pero para nada esta magnífica sorpresa.

– Mi única condición es que partáis este mediodía, así que id a preparar el equipaje mientras los criados ensillan los caballos. Dentro de treinta días, ni uno más ni uno menos, y exactamente a esta hora, nos reuniremos aquí y me contaréis vuestra experiencia ¿De acuerdo?


 
Los tres jóvenes, todavía desconcertados, dieron las gracias y un fuerte abrazo a su padre. Después, como flotando en una nube de felicidad, se fueron a sus aposentos con los bolsillos llenos y la cabeza rebosante de proyectos para las siguientes cuatro semanas.

Cuando el reloj marcó las doce en punto los príncipes abandonaron el palacio, decididos a disfrutar de un mes único e inolvidable. Como es obvio, cada uno tomó la dirección que se le antojó conforme a sus planes.

Luis decidió cabalgar hacia el Este porque allí se concentraban las familias nobles más ricas e influyentes y creyó que había llegado el momento de conocerlas.  Jaime, como buen vividor que era, se fue directo al Sur en busca de sol y alegría. ¡Necesitaba juerga y sabía de sobra dónde encontrarla! A diferencia de sus hermanos, Alberto concluyó que lo mejor era no hacer planes y recorrer el reino sin un rumbo fijo, sin un destino en concreto al que dirigirse.

Un día tras otro las semanas fueron pasando hasta que por fin llegó el momento de regresar y  presentarse en el salón del trono para dar cuentas al rey. Con diferencia de unos minutos los príncipes saludaron a su padre, quien les recibió con cariñoso achuchón.

– Sed bienvenidos, hijos míos. ¡No os imagináis lo mucho que os he echado de menos! Este castillo estaba tan vacío sin vosotros… ¿A qué esperáis para contarme vuestras aventuras? ¡Me tenéis en ascuas!

Luis estaba entusiasmado y deseando ser el primero en relatar su historia. Mirando a su padre y sus hermanos, se explayó:

– ¡La verdad es que yo he tenido un viaje magnífico!  No tardé más de un par de  jornadas en llegar a la ciudad más próspera del reino.

– ¡Caramba, eso es estupendo! ¿Y qué tal te recibieron?

– ¡Uy, maravillosamente! En cuanto se enteraron de mi presencia  los aristócratas me agasajaron con desfiles, fuegos artificiales y todo tipo de festejos. Además, como es natural, el tiempo que permanecí allí me alojé en elegantes palacetes, degusté  exquisitos manjares, y me presentaron a una hermosa y sofisticada duquesa que me robó el corazón…

Luis se quedó mirando al infinito, rememorando con nostalgia aquellos inalmente, el rey se acercó al bueno de Alberto.

– Querido Alberto… Te has convertido en un hombre culto y compasivo. Has aprovechado todos estos años para estudiar y formarte lo mejor posible porque has entendido perfectamente cuáles son las responsabilidades de un príncipe. Te interesa el bienestar de tu pueblo y te preocupan los más desfavorecidos. Mi corazón me dice que tú eres el elegido.

Dicho esto, y ante el asombro del príncipe Luis y del príncipe Jaime,  depositó la corona sobre su cabeza.

– A partir de hoy serás el rey de este reino. Gobierna con justicia y traerás prosperidad, gobierna con bondad y serás amado, gobierna con la razón y serás respetado por las generaciones venideras.  Como a tus hermanos, también a ti te deseo amor y felicidad el resto de tu vida.';
  $datos=$datos.'</p></div>';
  $this->generaPDF($datos,$nombre);
}

//-------------------------------------------------------------------------------------------
public function pdfPrueba(){
  $html='<p contenteditable="true" class="estlGnralMU" onclick="objetoFocoEvent(this)"><b>experiencia: </b><u>minima de 5 años de de director comercial</u></p><p contenteditable="true" class="estlGnralMU" onclick="objetoFocoEvent(this)"><b>habilidades:</b></p><ul contenteditable="true" class="estlGnralMU" onclick="objetoFocoEvent(this)"><li>conocimientos en planificacion</li><li><font color="#0000ff">gestion estrategica</font></li><li>empatia&nbsp;</li><li>resolver <span style="background-color: rgb(0, 0, 255);">problemas</span></li></ul>';
  $nombre="manual";

  $pdf='<html>';
  $pdf.='<head>';
  $pdf.='<style>';
  $pdf.='</style>';
  $pdf.='</head>';
  $pdf.='<body>';
  $pdf.='<h1>Ejemplo de generacion de un pdfr</h1>';
  $pdf.='Almacen todo lo que quieras en una variable imagenes textos listas';
  $pdf.='</body>';
  $pdf.='</html>';





        $this->load->library('mydompdf');

        $data["saludo"] = "Hola mundo!";

        $this->mydompdf->load_html($html);
       $this->mydompdf->set_paper('A4','portrait');
        $this->mydompdf->render();
        $this->mydompdf->stream($nombre.".pdf", array(
            "Attachment" => false
        ));

}

//-------------------------------------------------------------------------------------------
public function reporteAgentes(){

  $datos=$this->operPersona->obtVendAct();
  $tabla='<table border="1">';
  $tabla=$tabla."<tr>";//<td>nombre</td><td>apellido paterno</td><td>apellido materno</td><td>tipo agente</td><td>ranking</td><td>sucursal</td></tr>";

/*foreach ($datos[0] as $key => $value) {

  if($key!="idPersona" and $key!="promotoriasActivadasCP" and $key!='id' and $key!='IdSucursal' and $key!='name_complete' and $key!='email' and $key!='idVend' and $key!='celularSMS' and $key!='fecFinCedulaPersona' and $key!='userEmailCreacion'){
    $tabla=$tabla."<td>".$key."</td>";    
  }
}*/
foreach ($datos[0] as $key => $value) {

  if($key=="nombre" || $key=="apellidoPaterno" || $key=='apellidoMaterno' || $key=='personaTipoAgente' || $key=='ranking' || $key=='sucursal' || $key=='nombreTitulo' || $key=='fecAltaSistemPersona' || $key=='IDValida' || $key=='passwordVisible' || $key=='email' || $key=='telCasa' || $key=='celPersonal' || $key=='status' || $key=='comisionCVH' ){
    $tabla=$tabla."<td>".$key."</td>";    
  }
}
 $catalogo=$this->operPersona->obtenerCatalogPromotorias();
        foreach ($catalogo as $promotoria) { $tabla=$tabla.'<td>'.$promotoria->Promotoria.'</td>';}
$tabla=$tabla."</tr>";
  foreach ($datos as $key=>$value) {
    
     if($key!="idPersona" and $key!="promotoriasActivadasCP")
     {
          $tabla=$tabla.'<tr>';
    // $tabla=$tabla.'<td>'.$value.'</td>';
    $tabla=$tabla.'<td>'.$value->nombre.'</td>';
     $tabla=$tabla.'<td>'.$value->apellidoPaterno.'</td>';
     $tabla=$tabla.'<td>'.$value->apellidoMaterno.'</td>';
     $tabla=$tabla.'<td>'.$value->personaTipoAgente.'</td>';
     $tabla=$tabla.'<td>'.$value->ranking.'</td>';
     $tabla=$tabla.'<td>'.$value->sucursal.'</td>';
     $tabla=$tabla.'<td>'.$value->nombreTitulo.'</td>';
     $tabla=$tabla.'<td>'.$value->fecAltaSistemPersona.'</td>';
     $tabla=$tabla.'<td>'.$value->IDValida.'</td>';
     $tabla=$tabla.'<td>'.$value->passwordVisible.'</td>';
             $tabla=$tabla.'<td>'.$value->email.'</td>';
         $tabla=$tabla.'<td>'.$value->telCasa.'</td>';
          $tabla=$tabla.'<td>'.$value->celPersonal.'</td>';
          $tabla=$tabla.'<td>'.$value->status.'</td>';
            $tabla=$tabla.'<td>'.$value->comisionCVH.'</td>';
     foreach ($catalogo as $promotoria) {
      $stringPromotoria=(string)$promotoria->Promotoria;
       $tabla=$tabla.'<td>'.$value->$stringPromotoria.'</td>';

     }

     $tabla=$tabla.'</tr>';
     }
  }
  $tabla=$tabla."</table>";
    
  $this->generaReportesExcel($tabla,'agentes');
}
//--------------------------------------------------------------------------------------------
public function generaReportesExcel($tabla,$nombre){
    //Inicio de la instancia para la exportación en Excel
  header('Content-type: application/vnd.ms-excel');
  header("Content-Disposition: attachment; filename=".$nombre.".xls");
  header("Pragma: no-cache");
  header("Expires: 0");

  echo $tabla;
}
//------------------------------------------------------------------------------------------
public function  generaPDF($html,$nombre){
	//$this->load->library('dompdf/lib/Cpdf');    
	  
	
	$pdf='<html>';
	$pdf.='<head>';
	$pdf.='<style>';
	$pdf.='</style>';
	$pdf.='</head>';
	$pdf.='<body>';
	$pdf.='<h1>Ejemplo de generacion de un pdfr</h1>';
	$pdf.='Almacen todo lo que quieras en una variable imagenes textos listas';
	$pdf.='</body>';
	$pdf.='</html>';




        //Carga la librería que agregamos
        $this->load->library('mydompdf');
        //$saludo será una variable dentro la vista
        $data["saludo"] = "Hola mundo!";
        //$html tendrá el contenido de la vista
       // $html           = '';//$this->load->view('pdf/blanco', $data, true);
        /*
         * load_html carga en dompdf la vista
         * render genera el pdf
         * stream ("nombreDelDocumento.pdf", Attachment: true | false)
         * true = forza a descargar el pdf
         * false = genera el pdf dentro del navegador
         */
        $this->mydompdf->load_html($html);
       $this->mydompdf->set_paper('A4','portrait');
        $this->mydompdf->render();
        $this->mydompdf->stream($nombre.".pdf", array(
            "Attachment" => false
        ));







	// $this->converterPDF->load_html($pdf);
	//echo $pdf;exit; // SE MUESTRA EN EL NAVEGADOR SOLO COMO HTML Y NO SIGUEN PARA GENERAR EL PDF
	//$dompdf=new dompdf();
	
	/*$dompdf->loadHtml($content);
	$dompdf->setPaper('A4','landscape');  // OPCIONAL CONFIGURAR PAPEL Y ORIENTACION
	$dompdf->render(); //GENERAMOS EL PDF DESDE EL CONTENIDO HTML
	$salida=$dompdf->output();// OBTENEMOS EL PDF GENERADO
	$dompdf->stream();//ENVIAR EL PDF GENERADO AL NAVEGADOR*/
}

//-------------------------------------------------------------------------------------------------------------------------------


private function armaComboBoxSelect($datosCombo,$selectNombre){

  $total=count($datosCombo);
   $options='document.getElementById("'.$selectNombre.'").innerHTML=\'';
   for($i=0;$i<$total;$i++){$options=$options.'<option value="'.$datosCombo[$i]->idEscolaridad.'">'.$escolaridad[$i]->escolaridad.'</option>';}
   $options=$options.'\';';	
}


//-------------------------------------------------------------------------------------------------------------------------------
public function guardaDocumento(){
  $this->manejodocumento_modelo->guardarDocumentoPersona($_POST,$_FILES);          
  $idPersona=$_POST['idPersona'];
        $_POST=NULL;
           $_POST['idPersonas']=$idPersona;

  $this->agente();

}
//-------------------------------------------------------------------------------------------------------------------------------
public function guardaImagen(){
  if($_POST['idPersona']!=""){
     switch($_POST['caso']){
      case 0:$this->mensaje=$this->manejodocumento_modelo->guardarImagenPersona() ;break;
      case 1:$this->mensaje=$this->manejodocumento_modelo->guardarImagenPersonaCursos('I')  ;break;
     }
$this->buscaPersona($_POST['idPersona']);
  }
 // $_POST['idPersona']=209;
  //$_POST['name']="formato.JPEG";
  
  
  
  
}
//-------------------------------------------------------------------------------------------------------------------------------
public function verImagenesPersona(){

  switch ($_GET['tipoVentana']) {
    case 0:
  $datos=$this->manejodocumento_modelo->devolverImagenes('archivosPersona/'.$_GET['idPersona'].'/misCursos/',0);

  
 $imagenes="";
  $cantidad=count($datos['imagenes']);
  for($i=0;$i<$cantidad;$i++){ $imagenes=$imagenes.'<div class="divGenericoImagenes">'.$datos['imagenes'][$i].'<button onclick="direccionAJAX(\'borraImagenCurso\',\''.$datos['idImagenes'][$i].'\')" class="btn">Eliminar</button></div>';   }
   $imprime['datos']=$datos['botonCerrar'].$imagenes;
   $imprime['estilo']=$datos['estilo'];
      break;
    
    case 1:
      $datos=$this->manejodocumento_modelo->devolverImagenes('archivosPersona/'.$_GET['idPersona'].'/miFoto/',0);
   
  $imagenes="";
  $cantidad=count($datos['imagenes']);
  for($i=0;$i<$cantidad;$i++){ $imagenes=$imagenes.$datos['imagenes'][$i];   }
   $imprime['datos']=$datos['botonCerrar'].$imagenes;
    $imprime['estilo']=$datos['estilo'];
      break;
  case 2:   
    $idPersonaImagen=explode('.',$_GET['idImagen']);
    $direccion='archivosPersona/'.$_GET['idPersona'].'/misCursos/'.$_GET['idImagen'];
    $imagen['direccion']=$direccion;
    $imagen['tabla']='personaimagen';
    $imagen['campo']='idPersonaImagen';
    $imagen['valor']=$idPersonaImagen[0];
      //
    $this->manejodocumento_modelo->eliminaImagen($imagen);
    $imprime("ventana borrado");
  break;
  }
 
echo json_encode($imprime);
}
//-----------------------------------------------------------------------------
private function buscaPersona($idPersona){
  /*DESPUES DE HACER UNA MODIFICACION BUSCO A LA PERSONA NUEVAMENTE*/

    $_POST=NULL;
    $_POST['idPersonas']=$idPersona;
    $this->agente();
}

//-------------------------------------------------------------------------------------------------------------------------------

  /*========FUNCION QUE SE DEBE EJECUTAR TODOS LOS DIAS PARA VERIFICAR SI SE BANEAN LOS AGENTES============*/
public function personaAgentesPolza(){
          //$datosBaneo['idPersona']=0;
         //$this->db->insert('baneousuario',$datosBaneo);
         $this->load->library('Ws_sicas');
		     $D_Cred=new stdClass();
       	 $datoCredenciales['username']="SISTEMAS@ASESORESCAPITAL.COM";
       	 $datoCredenciales['Password']="ECHAN2018";
       	 $datoCredenciales['CodeAuth']="codigo";
         $datos['TipoEntidad']='0';
         $datos['TypeDestinoCDigital']='CONTACT';
         $datos['IDValuePK']='0';
         $datos['ActionCDigital']='GETFiles';
         $datos['TypeFormat']='JSON';
         $datos['TProct']='Read_Data';
         $datos['KeyProcess']='REPORT';
         $datos['KeyCode']='H02930_003';
         $datos['Page']='1';
         $datos['ItemForPage']='1000';
         $datos['InfoSort']='DatHonRecibos.Status_TXT';
         $datos['IDRelation']='0';
		    $datosConsulta=$this->db->query('select (TIMESTAMPDIFF(MONTH, cast(persona.fecInicioBaneo as date), curdate() ) ) as difMeses,(cast(persona.fecAltaSistemPersona as date)) fechaAlta,persona.fecAltaSistemPersona,persona.IDVend,persona.idPersona,cast(now() as date) as fechaActual,persona.nombres,personatipoagente.personaTipoAgente from persona left join users on users.idPersona=persona.idPersona left join personatipoagente on personatipoagente.idPersonaTipoAgente=persona.personaTipoAgente where (persona.personaTipoAgente=1 or persona.personaTipoAgente=2 or persona.personaTipoAgente=7) and persona.idpersonarankingagente="BRONCE" and users.banned=0 and persona.id_catalog_canales!=3');

		$datosConsultaBaneados=$this->db->query("select distinct(u.IDVend),u.name_complete,um.Ranking from users u left join user_miInfo um on um.IDVend=u.IDVend where u.banned=1 and  u.IdCanal=1 and um.Ranking='PROVISIONAL' and u.idTipoUser=12  order by u.name_complete");

		$totalRows=$datosConsulta->num_rows();
		$vendedor="";
		$i=0;
		$monto=0;
		$datosRestrinccion=array();
		$Importe="";$sumaImporte=0;
		
     foreach ($datosConsulta->result() as $value) 
      {//resultadoJasonac
     	$vendedor=$value->IDVend;
     	$fecIni=$this->convierteFecha($value->fechaAlta);
  	  $fecAct=$this->convierteFecha($value->fechaActual);	
 
      if($value->difMeses>0){  	
      if(is_int($value->difMeses/3)){
  	    $datos['ConditionsAdd']='Recibos;0;0;1;Pagados;1;-1;DatHonRecibos.Pagado ! Desde|Hasta|Fecha de Pago;3;0;'.$fecIni.'|'.$fecAct.';'.$fecIni.'|'.$fecAct.';0;-1;DatHonDocto.FPago ! VendedorID;2;0;'.$vendedor.';'.$vendedor.';51;DatHonRecibos.IDVE' ;
      // $respuestaSicas=$this->webservice_sicas_soap->datosComisiones($datos);
        $respuestaSicas=$this->ws_sicas->envioMensualAgentes($vendedor,$fecIni,$fecAct);    
         $sumaImporte=0;
         $bandEntrada=0;
          foreach ($respuestaSicas as $dato ) {$sumaImporte=$sumaImporte+floatval($dato->ImporteP);$bandEntrada=1;}
                   $cantMes=$sumaImporte/$value->difMeses;
           
         if($cantMes<2500){
           if($bandEntrada==1){ 
          
          $this->operPersona->manejarBanner($value->idPersona,1);
           $insertar['idPersona']=$value->idPersona;
            $insertar['fecIniBaneoUsuario']=$value->fechaAlta;
            $insertar['fecFinBaneoUsuario']=$value->fechaActual;
            $this->db->insert('baneousuario',$insertar);         
            $datosPersona=$this->operPersona->buscaPersonaBaneo($value->idPersona); 
          
            $nombre=$datosPersona->apellidoPaterno.' '.$datosPersona->apellidoMaterno.' '.$datosPersona->nombres;
            $this->operPersona->enviarCorreo($datosPersona->userEmailCreacion,"Baneo","La cuenta de ".$nombre.'('.$datosPersona->emailUsers.') se deshabilito del V3');
            $this->operPersona->enviarCorreo($datosPersona->emailUsers,"Baneo","Su cuenta se ha baneado del V3");
            $this->operPersona->enviarCorreo("DIRECTORGENERAL@AGENTECAPITAL.COM","Baneo","La cuenta de ".$nombre.'('.$datosPersona->emailUsers.') se deshabilito del V3');
            $this->operPersona->enviarCorreo("AUDITORINTERNO@AGENTECAPITAL.COM","Baneo","La cuenta de ".$nombre.'('.$datosPersona->emailUsers.') se deshabilito del V3');
          }
         }

      }

    }
   } 
 }

//-------------------------------------------------------------------------------------------------------------------------------
public function banear(){
   
       $this->operPersona->manejarBanner($_POST['idPersona'],1); 
       $idPersona=$_POST['idPersona'];
       $_POST=NULL;
       $_POST["idPersonas"]=$idPersona;
       $this->mensaje="El usuario esta banneado";
       $this->agente();	
}
//-------------------------------------------------------------------------------------------------------------------------------


function actualizaCatalogVendedores(){
	$datos=$this->db->query('select idPersona,IDVend from persona where IDVend>0')->result();
	foreach ($datos as $value) {
      $update['idPersona']=$value->idPersona;
      $this->db->where('IDVend',$value->IDVend);
      $this->db->update('catalog_vendedores',$update);
		
	}
}
//-------------------------------------------------------------------------------------------------------------------------------
public function crearUsuarioSicas(){
 
$idPersona=$_POST['idPersona'];
$contacto=$this->ws_sicas->crearContactoSicas();
if(isset($contacto['NewIDValue'])){
  $vendedor=$this->ws_sicas->crearVendedorSicas($contacto['NewIDValue']);
  if(isset($vendedor['NewIDValue'])){
  $actualizar['idContactoSicas']=$contacto['NewIDValue'];
  $actualizar['idClaveBitContSicas']=$contacto['ClaveBit'];
   $actualizar['IDVend']=$vendedor['NewIDValue'];
   $actualizar['idClaveBitVendSicas']=$vendedor['ClaveBit'];

  $this->operPersona->actualizarPersonaGeneral($actualizar,$idPersona);

  }

}
else{
  

}

  $_POST=NULL;
  $_POST["idPersonas"]=$idPersona;
  $this->agente();  


}
//-------------------------------------------------------------------------------------------------------------------------------
function obtenerDatosVendedor(){
   $this->ws_sicas->obtenerDatosAgente(447); 
}
//-----------------------------------------------------------------
private function actualizarVendedorSicas($idPersona){

  $datosPersona=$this->PersonaModelo->buscaPersonaPorCampo($idPersona,'IDVend,idpersonarankingagente,personaTipoAgente,id_catalog_sucursales,id_catalog_canales,idContactoSicas,nombres,apellidoMaterno,apellidoPaterno,fechaNacimiento,curpPersona,rfc,estadoNacimiento,paisNacimiento,celPersonal');

  if($datosPersona->IDVend>0){
    $datosVendedor=$this->PersonaModelo->obtenerDatosCatalogoVendedores($idPersona,'honorariosCVH,IDVendNS');
    $datosUser=$this->PersonaModelo->obtenerDatosUsuarios($idPersona,'email');
  $arreglo['IDVend']=$datosPersona->IDVend;
  $arreglo['CCosto']=$datosPersona->idpersonarankingagente;
  $arreglo['IDDespacho']=$this->PersonaModelo->buscarIdDespachoSicas($datosPersona->id_catalog_sucursales)->idDespachoSicas;
  $arreglo['IDCatCom']=$datosVendedor->honorariosCVH;
  $arreglo['IDVendNS']=$datosVendedor->IDVendNS;
  $arreglo['TipoVend']=$this->PersonaModelo->buscarTipoVendedorSicas($datosPersona->personaTipoAgente)->idTipoVendedorSicas;
 $arreglo['IDGerencia']=$this->PersonaModelo->buscarGerenciaSicasEnCatalogCanales($datosPersona->id_catalog_canales)->idGerenciaSicas;

  $this->ws_sicas->actualizarVendedorSicas($arreglo); 
  
  $arregloContacto['IDCont']=$datosPersona->idContactoSicas;
  $arregloContacto['Nombre']=$datosPersona->nombres;
  $arregloContacto['ApellidoP']=$datosPersona->apellidoPaterno;
  $arregloContacto['ApellidoM']=$datosPersona->apellidoMaterno;
  $arregloContacto['Email1']= $datosUser->email;
  $arregloContacto['FechaNac']= $this->convierteFecha($datosPersona->fechaNacimiento);
  $arregloContacto['CURP']= $datosPersona->curpPersona;
  $arregloContacto['RFC']= $datosPersona->rfc;
  $arregloContacto['EstadoNac']= $datosPersona->estadoNacimiento;
  $arregloContacto['LugarNac']= $datosPersona->paisNacimiento;
  //$arregloContacto['Telefono1']= $datosPersona->celPersonal;
  
  $this->ws_sicas->actualizarContactoVendedorSicas($arregloContacto);
 }
}
//--------------------------------------------------------------------------------------------------------------------------------
public function crearOrganigrama(){
$datos=$this->db->query("select (max(nivelPuesto)) as niveles from personapuesto")->result()[0]->niveles;
$ultimoNodo=$this->db->query("select * from personapuesto where nivelPuesto=".$datos)->result();

$hijoNodo="";
 for($i=0;$i<count($ultimoNodo);$i++){
  $hijoNodo[$ultimoNodo[$i]->idPuesto]['padrePuesto']=$ultimoNodo[$i]->padrePuesto;
  $hijoNodo[$ultimoNodo[$i]->idPuesto]['personaPuesto']=$ultimoNodo[$i]->personaPuesto;
  $hijoNodo[$ultimoNodo[$i]->idPuesto]['listaPuesto']="<li>".$ultimoNodo[$i]->personaPuesto."</li>";
 } 
 for($i=($datos-1);$i>-1;$i--){
  $anteriorNodo=$this->db->query("select * from personapuesto where nivelPuesto=".$i)->result();
  $countAnteriorNodo=count($anteriorNodo);
  for($j=0;$j<$countAnteriorNodo;$j++){
    $tieneHijos="";
    $band=0;
   foreach ($hijoNodo as $key => $value) {
        if($value['padrePuesto']==$anteriorNodo[$j]->idPuesto){
          $band=1;
            $tieneHijos=$tieneHijos.$value['listaPuesto'];
        }
     } 
     if($band)
      { $hijoNodo[$anteriorNodo[$j]->idPuesto]['padrePuesto']=$anteriorNodo[$j]->padrePuesto;
        $hijoNodo[$anteriorNodo[$j]->idPuesto]['personaPuesto']=$anteriorNodo[$j]->personaPuesto;
        $hijoNodo[$anteriorNodo[$j]->idPuesto]['listaPuesto']='<li>'.$anteriorNodo[$j]->personaPuesto.'<ul>'.$tieneHijos.'</ul></li>';
      }
      else{
        $hijoNodo[$anteriorNodo[$j]->idPuesto]['padrePuesto']=$anteriorNodo[$j]->padrePuesto;
        $hijoNodo[$anteriorNodo[$j]->idPuesto]['personaPuesto']=$anteriorNodo[$j]->personaPuesto;
        $hijoNodo[$anteriorNodo[$j]->idPuesto]['listaPuesto']='<li>'.$anteriorNodo[$j]->personaPuesto.'</li>';
      }
   }
 }


}

//--------------------------------------------------------------------------------------------------------------------------------

public function crearOrganigrama2(){
$datos=$this->db->query("select (max(nivelPuesto)) as niveles from personapuesto")->result()[0]->niveles;
$ultimoNodo=$this->db->query("select * from personapuesto where nivelPuesto=5")->result();
 
   $cadena=""; $tieneHijos="";$band=0;$esPadre="";
for($i=($datos-1);$i>3;$i--){
  $countUltimoNodo=count($ultimoNodo);
  $anteriorNodo=$this->db->query("select * from personapuesto where nivelPuesto=".$i)->result();

  $countAnteriorNodo=count($anteriorNodo);
  for($j=0;$j<$countAnteriorNodo;$j++){
     $tieneHijos="";
    for($t=0;$t<$countUltimoNodo;$t++){
        if($ultimoNodo[$t]->padrePuesto==$anteriorNodo[$j]->idPuesto){
          $band=1;
          $tieneHijos=$tieneHijos."<li>".$ultimoNodo[$t]->personaPuesto."</li>";
          
        }
    }
    if($band==1){$cadena[$anteriorNodo[$j]->idPuesto]="<li>".$anteriorNodo[$j]->personaPuesto."<ul>".$tieneHijos."</ul></li>";}
     else{$cadena[$anteriorNodo[$j]->idPuesto]="<li>".$anteriorNodo[$j]->personaPuesto."</li>";}
  }
 

}


}
//-----------------------------------------------------------------------------------------------
function actualizarHorario(){
  
  $datos= array(
    "entLunes" => $_POST['entLunes'],
    "salLunes" => $_POST['salLunes'],
    "entMartes" => $_POST['entMartes'],
    "salMartes" => $_POST['salMartes'],
    "entMiercoles" => $_POST['entMiercoles'],
    "salMiercoles" => $_POST['salMiercoles'],
    "entJueves" => $_POST['entJueves'],
    "salJueves" => $_POST['salJueves'],
    "entViernes" => $_POST['entViernes'],
    "salViernes" => $_POST['salViernes'],
    "entSabado" => $_POST['entSabado'],
    "salSabado" => $_POST['salSabado'],
    "entDomingo" => $_POST['entDomingo'],
    "salDomingo" => $_POST['salDomingo'],
    "tipoTrabajo" => $_POST['tipoTrabajo'],
);
  $this->PersonaModelo->actualizaHorario($_POST['idPersona'],$datos);
  header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
}
//-----------------------------------------------------------
function horariosColaboradorDevolver()
{
  $respuesta['success']=1;
  $consulta='select entradaLunes,entradaMartes,entradaMiercoles,entradaJueves,entradaViernes,entradaSabado,entradaDomingo,salidaLunes,salidaMartes,salidaMiercoles,salidaJueves,salidaViernes,
salidaSabado,salidaDomingo,tipoTrabajo
 from persona where idPersona='.$_POST['idPersona'];
  $respuesta['horarios']=$this->db->query($consulta)->result()[0];
 
  echo json_encode($respuesta);
}
//-----------------------------------------------------------
function bajaTotal(){
    
    $datosPersona=$this->PersonaModelo->buscaPersonaPorCampo($_POST['idPersona'],'*');
 
    //$datosSicas=$this->ws_sicas->obtenerDatosAgente(182);
    if($datosPersona->IDVend>0){
      $actualiza['IDVend']=$datosPersona->IDVend;
      $actualiza['Status']=1;
      $datosSicas=$this->ws_sicas->actualizarVendedorSicas($actualiza);
          if(isset($datosSicas['Sucess']))
          {
            if((String)$datosSicas['Sucess']==1)
            {
                //---------------------- //Dennis Castillo [2022-02-25]
                $getProspectives = $this->crmproyecto->getProspectivesAgentsByIdPerson($_POST['idPersona']);
                $forData = array_map(function($arr){ return $arr->idProspecto; }, $getProspectives);
                $tyPerson = $this->operPersona->obtenerTipoPersona($_POST['idPersona']);
				        //$email = $this->operPersona->obtenerEmail($_POST['idPersona']);
                $deleteProspectiveProgress = false;

                switch($tyPerson){
                  case 1: 
                    $dataEmployee = $this->operPersona->getEmployeeById($_POST['idPersona']);
                    $deleteProspectiveProgress = $this->operPersona->updateStatusEmployeeToUser(array("avance" => $dataEmployee->estadoBaja), $_POST['idPersona'], array("person" => $id, "status" => $dataEmployee->deleteStatus));
                    break;
                  case 4:
                  case 3:
                    if(!empty($forData)){
                      $dataAgent = $this->operPersona->getAgentById($_POST['idPersona']);
                      $deleteProspectiveProgress = $this->crmproyecto->updateProspectiveForStatus($forData, array("a.estadoRegistro" => "inactivo", "b.avance" => $dataAgent->estadoBaja));
                    }
                    break;
                }

                $department = $this->operPersona->updatePersonsUserAndPendingData(
                  array(
                    "a.idPersona" => 0, 
                    "a.email" => null, 
                    //"c.status" => "cancelled"
                  ), 
                  array("a.idPersona" => $_POST['idPersona'])
                );
                //----------------------

               $actualizaPersona['idPersona']=$datosPersona->idPersona;
               $actualizaPersona['bajaPersona']=1;
               $actualizaPersona['update']=1;
               $datosA=$this->PersonaModelo->persona($actualizaPersona);
              //$_POST['idPersonas']=$_POST['idPersona'];
                   
              unset($_POST['idPersona']);
              $_POST['quitarFiltroActivo']=1;
              $this->datos['mensajePersona']='alert("La persona fue dado de baja correctamento")';
              $this->agente();

            }
            else
            {
              $this->mensaje="No se pudo realizar la baja contactar con sistemas";  
            }
          }
          else
          {
            $this->mensaje="No se pudo realizar la baja contactar con sistemas";
          }
    
    }
    

}

//--------------------------------------------------------------------------------------------------------------------------------
public function llama(){
  $this->ws_sicas->obtenerDatosAgente(105);
//$this->actualizarVendedorSicas(593);
/*  $datosPersona=$this->PersonaModelo->buscaPersonaPorCampo(593,'IDVend,idpersonarankingagente');
  $arreglo['IDVend']=$datosPersona->IDVend;
  $arreglo['CCosto']=$datosPersona->idpersonarankingagente;
  $arreglo['GenComision']=1;
  $arreglo['IDDespacho']=$this->PersonaModelo->buscaIdDespachoSicas(1)->idDespachoSicas;
  $arreglo['Status']=0;
  $this->ws_sicas->actualizarVendedorSicas($arreglo);*/
		//$this->ws_sicas->obtenerDatosAgente(1);

	/*	$data_body = array(
			"Page"			=> "1",
			"ItemForPage"	=> "500",
			"KeyCode"		=> "H01110",
			"InfoSort"		=> "CatVendedores.IDVend",
			"ConditionsAdd"	=> "Devueltos;5;1;389;389;IDVend",
			//"ConditionsAdd"	=> "Devueltos;0;0;1;1;IDVend",
			"KeyProcess"	=> "REPORT",
		);	
		//  <InfoSort>CatVendedores.IDVend</InfoSort>	<ConditionsAdd>Devueltos;5;1;389;389;IDVend</ConditionsAdd>	
		//$datos = $this->webservice_sicasdre->ObtenerDatos($data_body); 

     $TextEncript='<InfoData><CatVendedores><IDVend>-1</IDVend><NombreCompleto>Luis Omar Ceja</NombreCompleto><IDDespacho>1</IDDespacho><TipoVend>0</TipoVend><CCosto>ORO</CCosto><Clave></Clave> <GenComision>1</GenComision></CatVendedores></InfoData>';

		$encriptado=$this->encripta('%SOnlineBOGO2001-2015WS#','GAP#aCap',$TextEncript);
				$xml = '<?xml version="1.0" encoding="utf-8"?>
					<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
					  <soap:Body>
					    <ProcesarWS xmlns="http://tempuri.org/">
					      <oDataWS>
					        <Credentials>
					          <UserName>'.$this->user.'</UserName>
								<Password>'.$this->pass.'</Password>
	  							<CodeAuth>'.$this->auth.'</CodeAuth><UserName>'.$this->user.'</UserName>
								<Password>'.$this->pass.'</Password>
	  							<CodeAuth>'.$this->auth.'</CodeAuth>
					        </Credentials>
					        <CredentialsUserSICAS>
					          	<UserName>SISTEMAS@ASESORESCAPITAL.COM</UserName>
								<Password>ECHAN2018</Password>
					        </CredentialsUserSICAS>
					        <TypeFormat>JSON</TypeFormat>
					        <KeyProcess>DATA</KeyProcess>
					        <KeyCode>H01110</KeyCode>
					        <TProc>Save_Data</TProc>';
					             
					     $xml =$xml.'<DataXML>'.$encriptado.'</DataXML>';	
					     $xml =$xml.' </oDataWS>
					    </ProcesarWS>
					  </soap:Body>
					</soap:Envelope>';

		         $headers = array(
                        "POST /SOnlineWSQua/WS_SICASOnline.asmx HTTPS/1.1",
                        "Content-Type: text/xml; charset=utf-8",
                        "Accept: text/xml",                        
                        "Host: www.sicasonline.info",
                        "Pragma: no-cache",
                        "SOAPAction: http://tempuri.org/ProcesarWS", 
                        "Content-length: ".strlen($xml),
                    );
	           
	     $soap_do = curl_init();
	     $url="https://www.sicasonline.info:448/SOnlineWS/WS_SICASOnline.asmx?WSDL";
	      curl_setopt($soap_do, CURLOPT_URL,$url );
	      curl_setopt($soap_do, CURLOPT_POSTFIELDS,$xml);
	      curl_setopt($soap_do, CURLOPT_HTTPHEADER,$headers);
	      curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, 0);
          curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($soap_do, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
         curl_setopt($soap_do, CURLOPT_TIMEOUT, 10);
          curl_setopt($soap_do, CURLOPT_POST, true);
	      $respuesta=curl_exec($soap_do);
	      curl_close($soap_do);*/

 /* $objeto=json_decode('<xml version="1.0" encoding="utf-8"?><soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema"><soap:Body><ProcesarWSResponse xmlns="http://tempuri.org/"><ProcesarWSResult>{"Sucess":true,"NewIDValue":"398","NewSubIDValue":"-1","ClaveBit":"1826324001164239255"}</ProcesarWSResult></ProcesarWSResponse></soap:Body></soap:Envelope>',true);
  //$json = json_encode($xml);
//$array = json_decode($objeto,TRUE);*/

//xml file path
//$path = "files/path-to-document.xml";

//read entire file into string
//$xmlfile = file_get_contents($path);




/*  //DECODIFICA EL  XML FUNCIONANDO
$xml = ('<?xml version="1.0" encoding="utf-8"?><soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema"><soap:Body><ProcesarWSResponse xmlns="http://tempuri.org/"><ProcesarWSResult>{"Sucess":true,"NewIDValue":"398","NewSubIDValue":"-1","ClaveBit":"1826324001164239255"}</ProcesarWSResult></ProcesarWSResponse></soap:Body></soap:Envelope>');
$xml ='<?xml version="1.0" encoding="utf-8"?><soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema"><soap:Body><ProcesarWSResponse xmlns="http://tempuri.org/"><ProcesarWSResult>{"Sucess":true,"NewIDValue":"29949","NewSubIDValue":"-1","ClaveBit":"1826298001102725785"}</ProcesarWSResult></ProcesarWSResponse></soap:Body></soap:Envelope>';

$xml = preg_replace('/(<\/?)(\w+):([^>]*>)/', '$1$2$3', $xml);
$xml = simplexml_load_string($xml);
$json = json_encode($xml);
$responseArray = json_decode($json,true);
$array=json_decode($responseArray['soapBody']['ProcesarWSResponse']['ProcesarWSResult'],true);

if(isset($array['NewIDValue'])){
//
}
if(isset($array['NewIDValues'])){$fp =fopen('resultadoJason.txt', 'a');fwrite($fp, print_r("No existe llave\n", TRUE));fclose($fp); }
else{$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r("No existe llave", TRUE));fclose($fp);}*/




/* //CREA CONTACTO
   // $TextEncript='<InfoData><CatContactos><IDCont>-1</IDCont><ApellidoP>Prueba</ApellidoP><ApelliodoM>Prueba</ApelliodoM><Nombre>LOCM</Nombre></CatContactos></InfoData>';
 $TextEncript='<InfoData><CatContactos><IDCont>-1</IDCont></CatContactos></InfoData>';

		$encriptado=$this->encripta('%SOnlineBOGO2001-2015WS#','GAP#aCap',$TextEncript);
      $en=$this->ws_sicas->encripta($TextEncript);

				$xml = '<?xml version="1.0" encoding="utf-8"?>
					<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
					  <soap:Body>
					    <ProcesarWS xmlns="http://tempuri.org/">
					      <oDataWS>
					        <Credentials>
					          <UserName>'.$this->user.'</UserName>
								<Password>'.$this->pass.'</Password>
	  							<CodeAuth>'.$this->auth.'</CodeAuth><UserName>'.$this->user.'</UserName>
								<Password>'.$this->pass.'</Password>
	  							<CodeAuth>'.$this->auth.'</CodeAuth>
					        </Credentials>
					        <CredentialsUserSICAS>
					          	<UserName>SISTEMAS@ASESORESCAPITAL.COM</UserName>
								<Password>ECHAN2018</Password>
					        </CredentialsUserSICAS>
					        <TypeFormat>JSON</TypeFormat>
					        <KeyProcess>DATA</KeyProcess>
					        <KeyCode>HCONTACT</KeyCode>
					        <TProc>Save_Data</TProc>';
					             
					     $xml =$xml.'<DataXML>'.$encriptado.'</DataXML>';	
					     $xml =$xml.' </oDataWS>
					    </ProcesarWS>
					  </soap:Body>
					</soap:Envelope>';

		         $headers = array(
                        "POST /SOnlineWSQua/WS_SICASOnline.asmx HTTPS/1.1",
                        "Content-Type: text/xml; charset=utf-8",
                        "Accept: text/xml",                        
                        "Host: www.sicasonline.info",
                        "Pragma: no-cache",
                        "SOAPAction: http://tempuri.org/ProcesarWS", 
                        "Content-length: ".strlen($xml),
                    );
	           
	     $soap_do = curl_init();*/

	   /*  $url="https://www.sicasonline.info:448/SOnlineWS/WS_SICASOnline.asmx?WSDL";
	      curl_setopt($soap_do, CURLOPT_URL,$url );
	      curl_setopt($soap_do, CURLOPT_POSTFIELDS,$xml);
	      curl_setopt($soap_do, CURLOPT_HTTPHEADER,$headers);
	      curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, 0);
          curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($soap_do, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
         curl_setopt($soap_do, CURLOPT_TIMEOUT, 10);
          curl_setopt($soap_do, CURLOPT_POST, true);
	      $respuesta=curl_exec($soap_do);
	      curl_close($soap_do);*/


//convert xml string into an object
/*$xml = ('<?xml version="1.0" encoding="utf-8"?><soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema"><soap:Body><ProcesarWSResponse xmlns="http://tempuri.org/"><ProcesarWSResult>{"Sucess":true,"NewIDValue":"398","NewSubIDValue":"-1","ClaveBit":"1826324001164239255"}</ProcesarWSResult></ProcesarWSResponse></soap:Body></soap:Envelope>');*/


 

//ACTULIZA EL VENDEDOR CON EL ID DEL CONTACTO

 //$TextEncript='<InfoData><CatVendedores><IDVend>408</IDVend><IDCont>30019</IDCont><IDCatCom>6</IDCatCom></CatVendedores></InfoData>';
 /*$TextEncript='<InfoData><CatVendedores><IDVend>408</IDVend><IDCont>30019</IDCont><IDCatCom>6</IDCatCom></CatVendedores></InfoData>';
		$encriptado=$this->encripta('%SOnlineBOGO2001-2015WS#','GAP#aCap',$TextEncript);
				$xml = '<?xml version="1.0" encoding="utf-8"?>
					<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
					  <soap:Body>
					    <ProcesarWS xmlns="http://tempuri.org/">
					      <oDataWS>
					        <Credentials>
					          <UserName>'.$this->user.'</UserName>
								<Password>'.$this->pass.'</Password>
	  							<CodeAuth>'.$this->auth.'</CodeAuth><UserName>'.$this->user.'</UserName>
								<Password>'.$this->pass.'</Password>
	  							<CodeAuth>'.$this->auth.'</CodeAuth>
					        </Credentials>
					        <CredentialsUserSICAS>
					          	<UserName>SISTEMAS@ASESORESCAPITAL.COM</UserName>
								<Password>ECHAN2018</Password>
					        </CredentialsUserSICAS>
					        <TypeFormat>JSON</TypeFormat>
					        <KeyProcess>DATA</KeyProcess>
					        <KeyCode>H01110</KeyCode>
					        <TProc>Save_Data</TProc>';
					             
					     $xml =$xml.'<DataXML>'.$encriptado.'</DataXML>';	
					     $xml =$xml.' </oDataWS>
					    </ProcesarWS>
					  </soap:Body>
					</soap:Envelope>';

		         $headers = array(
                        "POST /SOnlineWSQua/WS_SICASOnline.asmx HTTPS/1.1",
                        "Content-Type: text/xml; charset=utf-8",
                        "Accept: text/xml",                        
                        "Host: www.sicasonline.info",
                        "Pragma: no-cache",
                        "SOAPAction: http://tempuri.org/ProcesarWS", 
                        "Content-length: ".strlen($xml),
                    );
	           
	    $soap_do = curl_init();
	     $url="https://www.sicasonline.info:448/SOnlineWS/WS_SICASOnline.asmx?WSDL";
	      curl_setopt($soap_do, CURLOPT_URL,$url );
	      curl_setopt($soap_do, CURLOPT_POSTFIELDS,$xml);
	      curl_setopt($soap_do, CURLOPT_HTTPHEADER,$headers);
	      curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, 0);
          curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($soap_do, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
         curl_setopt($soap_do, CURLOPT_TIMEOUT, 10);
          curl_setopt($soap_do, CURLOPT_POST, true);
	      $respuesta=curl_exec($soap_do);
	      curl_close($soap_do);
echo($respuesta);*/




}


function encripta($key,$ivPass,$TextPlain){
 if(strlen($key)!=24){throw new Exception('La longitud de la key ha de ser de 24 dígitos.<br>'); return -1; }
 if((strlen($ivPass) % 8 )!=0){ throw new Exception('La longitud del vector iv Passsword ha de ser múltiple de 8 dígitos.<br>'); return -2;}
 return @base64_encode(mcrypt_encrypt(MCRYPT_3DES, $key, $TextPlain, MCRYPT_MODE_CBC, $ivPass)); 
       @base64_encode(mcrypt_encrypt(MCRYPT_3DES, $key, $TextPlain, MCRYPT_MODE_CBC, $ivPass));
}

public function agenteReporteCapacitacion(){
		$coordinacion = $this->input->post('coordinacion', TRUE);
	
	//if($userEmailCreacion){
		$sqlAgentes	= "
			Select 

				`persona`.`nombres`, 
				`persona`.`apellidoPaterno`, 
				`persona`.`apellidoMaterno`,				
				`persona`.`userEmailCreacion`,

				`user_miInfo`.`sucursal`,
				`user_miInfo`.`certificacion`,
				`user_miInfo`.`certificacionAutos`,
				`user_miInfo`.`certificacionGmm`,
				`user_miInfo`.`certificacionVida`,
				`user_miInfo`.`certificacionDanos`,
				`user_miInfo`.`certificacionFianzas`
			From 
				`persona` INNER JOIN `user_miInfo`
				On
				`persona`.`idPersona` = `user_miInfo`.`idPersona`
			Where

				(
					`user_miInfo`.`sucursal` != '0'
					Or
					(`user_miInfo`.`certificacion` != '0' And `user_miInfo`.`certificacion` != '')
					Or
					(`user_miInfo`.`certificacionAutos` != '0' And `user_miInfo`.`certificacionAutos` != '')
					Or
					(`user_miInfo`.`certificacionGmm` != '0' And `user_miInfo`.`certificacionGmm` != '')
					Or
					(`user_miInfo`.`certificacionVida` != '0' And `user_miInfo`.`certificacionVida` != '')
					Or
					(`user_miInfo`.`certificacionDanos` != '0' And `user_miInfo`.`certificacionDanos` != '')
					Or
					(`user_miInfo`.`certificacionFianzas` != '0' And `user_miInfo`.`certificacionFianzas` != '')
				)
				And
				`persona`.`userEmailCreacion` Like '%".$coordinacion."%'
			Order By
				`persona`.`apellidoPaterno` Asc, 
				`persona`.`apellidoMaterno` Asc,	
				`persona`.`nombres` ASC			
					  ";

		$this->datos['CoordinadoresVentas']	= $this->PersonaModelo->devuelveCoordinadoresVentas();
		$this->datos['Agentes']				= $this->db->query($sqlAgentes)->result();
		$this->datos['coordinacion']	= $coordinacion;
	//}
	
    $this->load->view('persona/agenteReporteCapacitacion',$this->datos);
}
//--------------------------------------------------------
//Dennis [2020-04-13]
function obtieneTipoAgente(){
  $modalidad=$this->input->post('tipoModalidad');
  
  if(isset($modalidad)){
  $tipoAgente=$this->operPersona->obtenerTipoAgentePorModalidad($modalidad);
  if(count($tipoAgente)>0){
    $option="";
    //$option="<option value=''>Seleccione</option>";
    foreach($tipoAgente as $valor){
      if($this->emailUser==="COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX"){
        if($valor->idPersonaTipoAgente==1){
          $option.="<option value=".$valor->idPersonaTipoAgente.">".$valor->personaTipoAgente."</option>";}
        elseif($valor->idModalidad!=4){
          $option.="<option value=".$valor->idPersonaTipoAgente.">".$valor->personaTipoAgente."</option>";}
      }
      elseif($this->emailUser==="COORDINADOR@CAPCAPITAL.COM.MX"){
        if($valor->idPersonaTipoAgente==1){
          $option.="<option value=".$valor->idPersonaTipoAgente.">".$valor->personaTipoAgente."</option>";}
        elseif($valor->idModalidad==3){
          $option.="<option value=".$valor->idPersonaTipoAgente.">".$valor->personaTipoAgente."</option>";}
      }
      elseif($this->emailUser==="COORDINADORINSTITUCIONAL@AGENTECAPITAL.COM" || $this->emailUser==="COORDINADORCARIBE@AGENTECAPITAL.COM"){
        if($valor->idModalidad==4 && $valor->idPersonaTipoAgente!=1){
          $option.="<option value=".$valor->idPersonaTipoAgente.">".$valor->personaTipoAgente."</option>";
        }
      }
      elseif($this->emailUser==="COORDINADOR@ASESORESCAPITAL.COM"){
        if($valor->idModalidad!=4){
          $option.="<option value=".$valor->idPersonaTipoAgente.">".$valor->personaTipoAgente."</option>";
        }
      }
      elseif($this->emailUser==="COORDINADORCOMERCIAL@FIANZASCAPITAL.COM"){//COORDINADORCOMERCIAL@FIANZAS.COM
        if($valor->idPersonaTipoAgente==7){
          $option.="<option value=".$valor->idPersonaTipoAgente.">".$valor->personaTipoAgente."</option>";
        }
        elseif($valor->idModalidad!=3 && $valor->idModalidad!=4){
          $option.="<option value=".$valor->idPersonaTipoAgente.">".$valor->personaTipoAgente."</option>";
        }
      }
      elseif($this->emailUser==="SISTEMAS@ASESORESCAPITAL.COM" || $this->emailUser==="CAPITALHUMANO@AGENTECAPITAL.COM" || $this->emailUser==="AUDITORINTERNO@AGENTECAPITAL.COM" || $this->emailUser==="DIRECTORGENERAL@AGENTECAPITAL.COM"){
        $option.="<option value=".$valor->idPersonaTipoAgente.">".$valor->personaTipoAgente."</option>";
      }
    }
    echo $option;
    
  }
  else{echo "No hay valor";}
}}
//Dennis [2020-04-14]
function obtieneTipoCanal(){
  $canal=$this->input->post('tipoAgente');
  if(isset($canal)){
    $tipoCanal=$this->operPersona->obtenerCanalPorTipoAgente($canal);
    $option="";
    if(count($tipoCanal)>0){
      //$option="<option value=''>Seleccione</option>";
      foreach($tipoCanal as $valor){
        if($this->emailUser==="COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX" || $this->emailUser==="COORDINADOR@ASESORESCAPITAL.COM"){
          if($valor->IdCanal==10 || $valor->IdCanal==11){
          $option.="<option value=".$valor->IdCanal.">".$valor->nombreTitulo."</option>";}
        }
        elseif($this->emailUser==="COORDINADORCOMERCIAL@FIANZASCAPITAL.COM"){
          if($valor->IdCanal==3 || $valor->IdCanal==2){
            $option.="<option value=".$valor->IdCanal.">".$valor->nombreTitulo."</option>";}
        }
        else{$option.="<option value=".$valor->IdCanal.">".$valor->nombreTitulo."</option>";}
       }
    echo $option;}
  }
  
  else{echo "No hay datos";}
}
//[Dennis 2020-04-23]
function ingresaCapacitacion(){
  $asignaCapa=array();
  $agente=$_POST['idPersona'];

  for($i=0;$i<count($agente);$i++){
    $asignaCapa[$i]=array(
      "idPersona"=>$agente[$i],
      "emailCreador"=>$this->emailUser,
      "certificacion"=>$_POST['certificacion'],
      "certificacionAutos"=>$_POST['certificacionAutos'],
      "certificacionGmm"=>$_POST['certificacionGmm'],
      "certificacionVida"=>$_POST['certificacionVida'],
      "certificacionDanos"=>$_POST['certificacionDanos'],
      "certificacionFianzas"=>$_POST['certificacionFianzas'],
      "descripcion"=>$_POST['descripcion'],
      "mes"=>date("n"),
      "anio"=>date("Y"),
      "fechaAsignada"=>date("Y-m-d"),
      "id_certificado"=> $_POST["nameSelectCerti"]);
  }
  
  $this->operPersona->insertaCertificaciones($asignaCapa);
  }

//[Dennis 2020-04-24]
function buscaVendedor(){
  $busqueda=$this->input->post('buscaVendedor');
  $fila="";
  if(isset($busqueda)){
    $respuesta=$this->operPersona->buscarVendedor($busqueda,$this->emailUser);
    if($respuesta!=""){
      foreach($respuesta as $valor){
        $fila.="<tr style='border-bottom-color:#D5D8DC; border-bottom-style: solid; border-bottom-width:1px'><td><input type='checkbox' class='opcionSelect' name='idPersona[]' value='".$valor->idPersona."'></td><td style='text-align: left'>".$valor->nombres." ".$valor->apellidoPaterno." ".$valor->apellidoMaterno."</td><td>".$valor->personaTipoAgente."</td><td>".$valor->nombreTitulo."</td><td>".$valor->NombreSucursal."</td></tr>";
    }}
    else{
      $fila="<tr>No hay coincidencias</tr>";
    }
    echo $fila;
  }
  else{echo "Dato vacio";} 
}

function prueba(){
  $recepcion=$this->input->post('usuarioACargo');
  //echo "El controlador recibió".$recepcion;
  $resultado=$this->operPersona->prueba2($recepcion);
  
  echo json_encode($resultado);
  /*$cuerpo="";
  if(isset($resultado)){
    foreach($resultado as $valor){
      $cuerpo.="<tr style='border-bottom-color:#D5D8DC; border-bottom-style: solid; border-bottom-width:1px'><td><input type='checkbox' class='opcionSelect' name='idPersona[]' value='".$valor->idPersona."'></td><td style='text-align: left'>".$valor->nombres." ".$valor->apellidoPaterno." ".$valor->apellidoMaterno."</td><td>".$valor->personaTipoAgente."</td><td>".$valor->nombreTitulo."</td><td>".$valor->NombreSucursal."</td></tr>";
    }
  }
  else{echo "No hay valores";}
  echo $cuerpo; */
}
//[Dennis 2020-05-04]
function resumenCapacitacion(){
  //$resumenCoor=$this->operPersona->obtenerHrsCapaCoor($this->emailUser);
  //$conteoMes=$this->operPersona->obtenerMesesCapa($this->emailUser);
  //$personal_superior=array("DIRECTORGENERAL@AGENTECAPITAL.COM","DIRECTORCOMERCIAL@AGENTECAPITAL.COM");
  $correos_validos=array("SISTEMAS@ASESORESCAPITAL.COM","ASISTENTEDIRECCION@AGENTECAPITAL.COM","DIRECTORGENERAL@AGENTECAPITAL.COM","DIRECTORCOMERCIAL@AGENTECAPITAL.COM","GERENTECORPORATIVO@CAPITALSEGUROS.COM.MX","MARKETING@AGENTECAPITAL.COM","GERENTEOPERATIVO@AGENTECAPITAL.COM");
  $controlCapa=$this->operPersona->devuelveCertificadoActivoCoor(!in_array($this->emailUser,$correos_validos) ? $this->emailUser : ""); //$this->emailUser
  //$datos['resumenCoor']=$resumenCoor;
  //$datos['conteoMes']=$conteoMes;
  $datos['controlCapa']=$controlCapa;


  //$datos['meses']=$this->libreriav3->devolverMeses();
  $this->load->view("persona/resumenCapacitacion", $datos);
}

function resumenGeneral(){
  $rGeneral=$this->operPersona->resumenGeneral();
  //$datos['resumenG']=$rGeneral;
  $datos['meses']=$this->libreriav3->devolverMeses();
  $datos["tipoCapacitacion"]=$this->operPersona->devuelveTipoCapacitacion();

  $agentes=array();
  $capa=array();
  $mensual=array();
  $mesActivo=array();
  $capacitaRamo=array();
  foreach($rGeneral as $key=>$arreglo){
    array_push($mensual, $arreglo->mes);
    $mesActivo=array_values(array_unique($mensual));

    $capa["profesional"]=$arreglo->certificacion;
    $capa["autos"]=$arreglo->certificacionAutos;
    $capa["GMM"]=$arreglo->certificacionGmm;
    $capa["vida"]=$arreglo->certificacionVida;
    $capa["danios"]=$arreglo->certificacionDanos;
    $capa["fianzas"]=$arreglo->certificacionFianzas;
    if($arreglo->id_catalog_sucursales==2 && $arreglo->id_catalog_canales!=11 && $arreglo->tipoPersona==3){
      $agentes["cancun"][$arreglo->nombres." ".$arreglo->apellidoPaterno." ".$arreglo->apellidoMaterno][$arreglo->mes]=array_sum($capa);
    }
    elseif(($arreglo->id_catalog_sucursales==1 || $arreglo->id_catalog_sucursales==7) && $arreglo->id_catalog_canales!=11 && $arreglo->tipoPersona==3){
      $agentes["merida"][$arreglo->nombres." ".$arreglo->apellidoPaterno." ".$arreglo->apellidoMaterno][$arreglo->mes]=array_sum($capa);
    }
    elseif($arreglo->id_catalog_canales==11 && $arreglo->tipoPersona==3){
      $agentes["cap"][$arreglo->nombres." ".$arreglo->apellidoPaterno." ".$arreglo->apellidoMaterno][$arreglo->mes]=array_sum($capa);
    }
    elseif($arreglo->tipoPersona==1){
      $agentes["colaborador"][$arreglo->nombres." ".$arreglo->apellidoPaterno." ".$arreglo->apellidoMaterno][$arreglo->mes]=array_sum($capa);
    }
  }

  $datos["mesActivo"]=$mesActivo;
  $datos["agentesActivos"]=$agentes;
  
  $this->load->view("persona/resumenGeneral",$datos);
}
//--------------------------------------------------------------------------------------------------
function asignaImgCurso(){
  $agentes=$_POST["agente"];
  if($_FILES["archivo"]["name"]!="" && $_POST["agente"]!=""){
    $this->manejodocumento_modelo->insertaImgsCurso($agentes,$_FILES);
  }
  else{
    echo "Se recibieron datos incompletos, intenta de nuevo";
  }
}
//-------------------------------------------------------------------------------------------------------
function consultaCertificadoXCapacitacion(){
  //echo $_GET["selectCapacitacionName"];
  $tipoCapa=$_GET["selectCapacitacionName"];
  $correos_validos=array("SISTEMAS@ASESORESCAPITAL.COM","ASISTENTEDIRECCION@AGENTECAPITAL.COM","DIRECTORGENERAL@AGENTECAPITAL.COM","DIRECTORCOMERCIAL@AGENTECAPITAL.COM","GERENTECORPORATIVO@CAPITALSEGUROS.COM.MX","MARKETING@AGENTECAPITAL.COM","GERENTEOPERATIVO@AGENTECAPITAL.COM");
  $resultado=$this->operPersona->devuelveCapaXCerti($tipoCapa, !in_array($this->emailUser, $correos_validos) ? $this->emailUser : "");

  
  echo json_encode($resultado);
}

function resumenCapaAsincrono(){
  $tipoCert=$_GET["nameSelectCerti"];
  $correos_validos=array("SISTEMAS@ASESORESCAPITAL.COM","ASISTENTEDIRECCION@AGENTECAPITAL.COM","DIRECTORGENERAL@AGENTECAPITAL.COM","DIRECTORCOMERCIAL@AGENTECAPITAL.COM","GERENTECORPORATIVO@CAPITALSEGUROS.COM.MX","MARKETING@AGENTECAPITAL.COM","GERENTEOPERATIVO@AGENTECAPITAL.COM");
  $resumenCoor=$this->operPersona->obtenerHrsCapaCoor(!in_array($this->emailUser, $correos_validos) ? $this->emailUser : "",$tipoCert);  
  echo json_encode($resumenCoor);
}

function devuelveCerti(){
  $tipoCapa=$_GET["selectCapacitacionName"];
  $resultado=$this->operPersona->devuelveTipoCertificado($tipoCapa);

  echo json_encode($resultado);
}

function devuelveDatosParaGrafos(){

  $valorCapa=$_GET["selectCapacitacionName"];
  $valorMes=$_GET["selectMesName"];
  $valorSubCapa=$_GET["selectSubCapacitacionName"];
  $resp=$this->operPersona->resumenGeneralGraficas($valorCapa,$valorSubCapa,$valorMes);  
  echo json_encode($resp);
}

function obtenerMesXSubCapa(){

  $subCapa=$_GET["selectSubCapacitacionName"];
  $resultado=$this->operPersona->devuelveInfoXSubCapa($subCapa);

  $datosMensuales=array();
  $ramos=array();
  $resultadoMensual=array();
  foreach($resultado as $valor){

    $ramos["profesional"]=$valor->certificacion;
    $ramos["autos"]=$valor->certificacionAutos;
    $ramos["gmm"]=$valor->certificacionGmm;
    $ramos["vida"]=$valor->certificacionVida;
    $ramos["danios"]=$valor->certificacionDanos;
    $ramos["fianzas"]=$valor->certificacionFianzas;

    $datosMensuales[$valor->mes][$valor->nombres]=array_sum($ramos);
  }
  foreach($datosMensuales as $mes=>$agentes){
    $mansual=array_sum(array_values($agentes));
    $resultadoMensual[$mes]=$mansual;
  }

  
  echo json_encode($resultadoMensual);
}
//-----------------------------------------------------------------
function devuelveBanderaDePersonaComentarioArchivos()
{
  $respuesta=array();
  $respuesta['success']=',';
  $idColaborador=explode(',', $_POST['idColaborador']);
  $idAgente=explode(',', $_POST['idAgente']);
  /* ESTOS TIPOS ES PARA COLABORADORES(induccionempresa,capacitacionsistema,reglamentointeriordetrabajo,experienciacapital)*/
  /* ESTOS TIPOS ES PARA AGENTES(induccionempresa,manualagente,agenteideal,capacitacionsistema)*/

  $respuesta['colaborador']=array();
  foreach ($idColaborador as  $value) 
  {
    if($value!='')
    {
      $insert=null;
      $miArray=array();
      $miArray['idPersona']=$value;
      $query['idPersona']=$value;
      $query['tipoComentario']='induccionempresa';
      $miArray['induccionempresa']=count($this->operPersona->comentarioagenteanuevo($query))>0?1:0;
      $query['tipoComentario']='capacitacionsistema';
      $miArray['capacitacionsistema']=count($this->operPersona->comentarioagenteanuevo($query))>0?1:0;
      $query['tipoComentario']='reglamentointeriordetrabajo';
      $miArray['reglamentointeriordetrabajo']=count($this->operPersona->comentarioagenteanuevo($query))>0?1:0;
      $query['tipoComentario']='experienciacapital';
      $miArray['experienciacapital']=count($this->operPersona->comentarioagenteanuevo($query))>0?1:0;


      $miArray['induccionempresaDoc']=count($this->manejodocumento_modelo->devolverArchivos('archivosPersona/'.$value.'/agenteNuevo/induccionempresa/'))>0?1:0;
      $miArray['capacitacionsistemaDoc']=count( $this->manejodocumento_modelo->devolverArchivos('archivosPersona/'.$value.'/agenteNuevo/capacitacionsistema/'))>0?1:0;
      $miArray['reglamentointeriordetrabajoDoc']=count( $this->manejodocumento_modelo->devolverArchivos('archivosPersona/'.$value.'/agenteNuevo/reglamentointeriordetrabajo/'))>0?1:0;
      $miArray['experienciacapitalDoc']=count( $this->manejodocumento_modelo->devolverArchivos('archivosPersona/'.$value.'/agenteNuevo/experienciacapital/'))>0?1:0;
      array_push($respuesta['colaborador'], $miArray);
    }
   }

  $respuesta['agente']=array();
  foreach ($idAgente as  $value) 
  {
    if($value!='')
    {
      $insert=null;
      $miArray=array();
      $miArray['idPersona']=$value;
      $query['idPersona']=$value;
      /*========ESTE ES PARA OBTENER LA BANDERA DE COMENTARIOS======*/
      $query['tipoComentario']='induccionempresa';
      $miArray['induccionempresa']=count($this->operPersona->comentarioagenteanuevo($query))>0?1:0;
      $query['tipoComentario']='manualagente';
      $miArray['manualagente']=count($this->operPersona->comentarioagenteanuevo($query))>0?1:0;
      $query['tipoComentario']='agenteideal';
      $miArray['agenteideal']=count($this->operPersona->comentarioagenteanuevo($query))>0?1:0;
      $query['tipoComentario']='capacitacionsistema';
      $miArray['capacitacionsistema']=count($this->operPersona->comentarioagenteanuevo($query))>0?1:0;
      
       
    
      /*=======================================================*/


      $miArray['induccionempresaDoc']=count($this->manejodocumento_modelo->devolverArchivos('archivosPersona/'.$value.'/agenteNuevo/induccionempresa/'))>0?1:0;
      $miArray['manualagenteDoc']=count( $this->manejodocumento_modelo->devolverArchivos('archivosPersona/'.$value.'/agenteNuevo/manualagente/'))>0?1:0;
      $miArray['agenteidealDoc']=count( $this->manejodocumento_modelo->devolverArchivos('archivosPersona/'.$value.'/agenteNuevo/agenteideal/'))>0?1:0;
      $miArray['capacitacionsistemaDoc']=count( $this->manejodocumento_modelo->devolverArchivos('archivosPersona/'.$value.'/agenteNuevo/capacitacionsistema/'))>0?1:0;
      array_push($respuesta['agente'], $miArray);

    }
   }



  
  echo json_encode($respuesta);
}
//-----------------------------------------------------------------
function grabaComentarioAgenteNuevo()
{    
  if(isset($_POST['comentario']))
  { 
   if(isset($_POST['idComentarioAgenteNuevo']))
   {
     $insert['comentario']=$_POST['comentario'];
     $insert['idComentarioAgenteNuevo']=$_POST['idComentarioAgenteNuevo'];
     if(isset($_POST['activo'])){$insert['activo']=$_POST['activo'];}
     $insert['update']="";    
   }
   else
   {
    $respuesta['mensaje']="Comentario guardado";
    $insert['comentario']=$_POST['comentario'];
    $insert['idPersona']=$_POST['idPersona'];
    $insert['tipoComentario']=$_POST['tipoComentario'];
    $insert['insert']="";
   }
   $this->operPersona->comentarioagenteanuevo($insert);
  }

    $insert=null;
    $insert['idPersona']=$_POST['idPersona'];
    $insert['tipoComentario']=$_POST['tipoComentario'];
    $respuesta['comentarios']=$this->operPersona->comentarioagenteanuevo($insert);
    
  echo json_encode($respuesta);
}
//------------------------------------------------------------------------
 function  subirArchivoAgenteNuevo()
 {
  $respuesta['mensaje']='prueba';  
  $ruta=$this->manejodocumento_modelo->obtenerRuta();
  $ruta.='archivosPersona/'.$_POST['idPersona'].'/agenteNuevo/'.$_POST['idTipoArchivo'];
  $extension=$this->manejodocumento_modelo->devolverExtension($_FILES['Archivo']['name']);
  $nombre=$this->manejodocumento_modelo->obtenerNombreArchivo($_FILES['Archivo']['name']);;
  $this->manejodocumento_modelo->guardarArchivo($ruta,$_FILES,$nombre,$extension);
 
   $respuesta['archivos']=$this->manejodocumento_modelo->devolverArchivos('archivosPersona/'.$_POST['idPersona'].'/agenteNuevo/'.$_POST['idTipoArchivo'].'/');
    echo json_encode($respuesta);
 }
 //----------------------------------------------------------------
 function devolverArchivosAgenteNuevo()
 { 
   $respuesta['archivos']=$this->manejodocumento_modelo->devolverArchivos('archivosPersona/'.$_POST['idPersona'].'/agenteNuevo/'.$_POST['idTipoArchivo'].'/');
 
    echo json_encode($respuesta);
 }
 //----------------------------------------------------
 function eliminarArchivo()
 {
     $directorio=$this->manejodocumento_modelo->obtenerRuta();
     $rutaArchivo=$directorio.'archivosPersona/'.$_POST['idPersona'].'/agenteNuevo/'.$_POST['idTipoArchivo'].'/'.$_POST['nombreArchivo'];
      $this->manejodocumento_modelo->eliminarArchivo($rutaArchivo);
      $this->devolverArchivosAgenteNuevo();
  
 }
//----------------------------------------------------------
function guardarCaracteristicasAgenteNuevo()
{
  $respuesta['mensaje']='Guardado';
 
  $this->operPersona->caracteristicasagentenuevopersonarelacion($_POST);
  echo json_encode($respuesta);
}
//--------------------------------------------------
function caracteristicaAgenteNuevo()
{
 
 $respuesta['caracteristicas']=$this->operPersona->caracteristicasAgenteNuevo($_POST); 
 if(isset($_POST['return']))
 {
   return $respuesta; 
 }
 else{
 echo json_encode($respuesta);}
}
//-----------------------------
//Dennis Castillo [2021-10-31]
function pasarComoAgente()
{
  $respuesta['mensaje']='El Agente nuevo se ha convertido en Agente';  
  $respuesta['idPersona']=$_POST['idPersona'];
  $update['esAgenteNuevo']=0; //fecAltaSistemPersona
  $update['fecAltaSistemPersona'] = date("Y-m-d H:i:s");
  $update['quienLoPasaComoAgente']=$this->emailUser;
  $this->operPersona->actualizarPersonaGeneral($update,$_POST['idPersona']);
  $updateNotificacion['referencia']='CAPACITACION_NUEVO_INGRESO';
  $updateNotificacion['idTabla']=$_POST['idPersona'];
  $updateNotificacion['check']=2;
  $this->notificacionmodel->actualizarNotificacion($updateNotificacion);
  $respuesta['idPersona']=$_POST['idPersona'];
  $respuesta['type']=$_POST['type'];

  $setFreePerson = $this->operPersona->insertRegister("set_free_of_inducction", array("inducctionPerson" => $_POST['idPersona'], "status" => "free"));

  $email_ = "SISTEMAS@ASESORESCAPITAL.COM"; //$_POST['type'] == "Agentes" ? "SISTEMAS@ASESORESCAPITAL.COM" : "ASISTENTEDIRECCION@AGENTECAPITAL.COM";
  $typePerson =  $_POST['type'] == "Agentes" ? "AGENTE" : "COLABORADOR";
  $idPersona_ = $this->operPersona->obtenerIdPersonaPorEmail($email_);

  $sendNotification_ = $this->sendNotification(array(array("idPersona" => $idPersona_->idPersona,"email" => $email_)), $typePerson, $_POST['idPersona'], "LIBERAR_".$typePerson."", "LIBERAR");

  echo json_encode($respuesta);  
}
//-----------------------------
//Dennis Castillo [2021-10-31]
function sendNotification($array, $type, $newUser, $typeNotification, $reference){

  $us=array();

  foreach($array as $k => $v){

    $data_= new stdClass;
    $data_->idPersona = $v["idPersona"];
    $data_->email = $v["email"];

    array_push($us, $data_);
  }
  //$us[0]=$data_;
  
  $this->notificacionmodel->add($us, "email", "ENVIADO", $typeNotification, $reference, array("evaluacion_id" => $newUser));

  return 1;
}
//-----------------------------
//Dennis Castillo [2021-10-31] -> [2022-06-16]
function sendWelcomeMessage(){

  $getAllPersons = $this->operPersona->obtenerTodasLasPersonas();
  $getOnlyEmploye = array_filter($getAllPersons, function($arr){ return $arr->tipoPersona == 1; });
  //----------------------------------------
  $email = $this->operPersona->getPersonalEmail($_GET["person"]);
  $personName = $this->operPersona->obtenerNombrePersona($_GET["person"]);
  $getPassCode = $this->operPersona->getPassCodeNewUser($_GET["person"]);
  $getSendStatus = $this->operPersona->getInducctionFreePerson($_GET["person"]);

  if(!$getSendStatus->welcomeTemplateCreate){

    $data["name"] = $personName;
    $data["passCode"] = $getPassCode->passCode;
    $message = $this->load->view("capacita/correoBienvenida", $data, true);

    $validSending = array();
    $response = array();
    $response["data"]["newUser"]["status"] = false;
    $response["data"]["newUser"]["label"] = "<span class='label label-primary'>Nuevo</span> Notificación al nuevo usuario";
    $response["data"]["notifications"]["noSend"] = array();
    $response["data"]["notifications"]["status"] = false;
    $response["data"]["notifications"]["label"] = "<span class='label label-primary'>Nuevo</span> Notificación al personal";

    if(!empty($email)) {
      $sendtonew = $this->capacita_modelo->insertaRegistro(array(
        "fechaCreacion" => date("Y-m-d H:i:s"),
        "desde" => "Avisos de GAP<avisos@agentecapital.com>",
        "para" => $email->emailPersonal,
        "asunto" => "Mensaje de bienvenida",
        "mensaje" => $message,
        "status" => 0,
        "fechaEnvio" => date("Y-m-d H:i:s"),
        "identificaModulo" => "capacita/induccion"
      ), "envio_correos");
  
      $response["data"]["newUser"]["status"] = $sendtonew["bool"];
    }
    //----------------------------------------
    $htmlMessage = '<html>
      <head></head>
      <body>
        <p>Le damos una cordial bienvenida a '.ucwords($personName).' y le deseamos una estancia llena de éxitos.</p>
        <img src='.base_url().'assets/plantillas_ingreso/plantillas_nuevas_personas/person_'.$_GET["person"].'_'.$_GET["template"].'></img>
      </body>
      </html>';

    foreach($getOnlyEmploye as $d_p){

      if($d_p->idPersona != $_GET["person"]){
  
        if(filter_var($d_p->email, FILTER_VALIDATE_EMAIL)){
  
          $sending = $this->capacita_modelo->insertaRegistro(array(
            "fechaCreacion" => date("Y-m-d H:i:s"),
            "desde" => "Avisos de GAP<avisos@agentecapital.com>",
            "para" => $d_p->email, //"AUXILIARDESARROLLO@AGENTECAPITAL.COM", //$email->email,
            "asunto" => "Bienvenido (a) ".ucwords($personName)."",
            "mensaje" => $htmlMessage,
            "status" => 0,
            "fechaEnvio" => date("Y-m-d H:i:s"),
            "identificaModulo" => "capacita/presentation"
          ), "envio_correos");
  
          array_push($validSending, $sending["bool"]);
  
          if(!$sending["bool"]){
            array_push($response["data"]["notifications"]["noSend"], $d_p->email);
          }
        }
      }
    }

    $updateTemplateStus = $this->capacita_modelo->updateTrainingDataSafely(
      array("inducctionPerson" => $_GET["person"]), 
      array("welcomeTemplateCreate" => true), 
      "set_free_of_inducction"
    );

    $response["data"]["notifications"]["status"] = !in_array(false, $validSending);
  } else{

    $response["data"]["sendMessage"]["status"] = $getSendStatus->welcomeTemplateCreate;
    $response["data"]["sendMessage"]["label"] = "<span class='label label-primary'>Nuevo</span> Envio de correos";
  }

  echo json_encode($response);
}
//-----------------------------
//Dennis Castillo [2021-10-31]
function prueba_vista(){

  $getAllPersons = $this->operPersona->obtenerTodasLasPersonas();
  $getOnlyEmploye = array_filter($getAllPersons, function($arr){ return $arr->tipoPersona == 1; });

  foreach($getOnlyEmploye as $data){
    var_dump($data->email);
  }
  //var_dump($getOnlyEmploye);
  //$this->load->view("capacita/correoBienvenida");
}
//-----------------------------
function agentesEnProceso()
{
  $validateAccounts = array("ASISTENTEDIRECCION@AGENTECAPITAL.COM", "CAPITALHUMANO@AGENTECAPITAL.COM","SISTEMAS@ASESORESCAPITAL.COM","DIRECTORGENERAL@AGENTECAPITAL.COM", "DIRECTORCOMERCIAL@AGENTECAPITAL.COM", "GERENTEOPERATIVO@AGENTECAPITAL.COM","CAPITALHUMANO@AGENTECAPITAL.COM");
  $account = !in_array($this->tank_auth->get_usermail(), $validateAccounts) ? $this->tank_auth->get_usermail() : null;
  $agentesEnProceso=$this->operPersona->obtenerPersonas("SISTEMAS@ASESORESCAPITAL.COM",3); //$this->emailUser

  $myAgents = array_map(function($arr){ return $arr->idPersona; }, $this->crmproyecto->newAgentsOnInducction($account));
  $myEmployees_ = array_filter($this->operPersona->getMyEmployeesByEmail($account), function($arr){ return $arr->avance == "induccion" || $arr->avance == "induccion_libre"; }); //$this->crmproyecto->getAllProspectiveAgents()
  $myEmployees = array_map(function($arr){ return $arr->idPersona; }, $myEmployees_); //idPersona from employes in inducction
  $creators = array_map(function($arr){ return $arr->creator; }, $myEmployees_); //Creators from employes in inducction
  $myPersonal = array_merge($myAgents, $myEmployees); //join agents and employees

  $this->datos['personasEnProceso']=array();
  $id="";
  foreach ($agentesEnProceso as $key => $value) 
  {   
      //----------
      //Dennis Castillo [2021-11-08]
      if(!in_array($this->tank_auth->get_usermail(), $validateAccounts)){
        if(in_array($value->idPersona, $myPersonal) && in_array($this->emailUser, $creators)){
          $value->userEmailCreacion = $this->emailUser;
        }
      }

      if(in_array($value->idPersona, $myPersonal) && $value->esAgenteNuevo == '1'){ // || $value->esAgenteNuevo=='1'

        $id=$id.$value->idPersona.',';
        array_push($this->datos['personasEnProceso'], $value);
      }
      //---------
  }

  $_POST['idPersona']=$id;
  $_POST['return']=1;
  if($id!="")
  {
    $this->datos['caracteristicas']=$this->operPersona->caracteristicasAgenteNuevo($_POST); 
  }
  else
  {
    $this->datos['caracteristicas']=array();
  }
    $permiso=$this->operPersona->permisosPersona('persona_agregaAgente');
    if(isset($permiso['PasarAgenteNuevoParaAgente'])){$this->datos['permisoAgenteNuevo']=1;}
    else{$this->datos['permisoAgenteNuevo']=0;}
    $this->datos['coordinadores']=$this->operPersona->devuelveCoordinadoresVentas(); 
    
    //--------------------
    //Dennis Castillo [2021-10-31]
    $select = "select * from caracteristicascolaboradornuevo order by posicion asc";
    $query = $this->db->query($select);

    $select_ = "select * from caracteristicaagentenuevo order by posicion asc";
    $query_ = $this->db->query($select_);

    $this->datos["headsEmploye"] = $query->num_rows() > 0 ? $query->result() : array();
    $this->datos["headsAgent"] = $query_->num_rows() > 0 ? $query_->result() : array();
    //-------------------
      //[Dennis 2020-09-30]
    
    //$ruta_documento="https://firebasestorage.googleapis.com/v0/b/v3plus-279402.appspot.com/o/documentosCapacita%2F";

    $datos_docs=$this->documentos_capitalhumano_model->get_documentos();
    $this->datos["documentos"]=$datos_docs;

    $this->load->view('capacita/agentesEnProceso',$this->datos);

  //---------------------------------------------------------------------------
}
//-----------------------------
/*function pasarComoAgente()
{
  $respuesta['mensaje']='El Agente nuevo se ha convertido en Agente';  
  $respuesta['idPersona']=$_POST['idPersona'];
  $update['esAgenteNuevo']=0;
  $update['quienLoPasaComoAgente']=$this->emailUser;
  $update['fecAltaSistemPersona'] = date("Y-m-d H:i:s");
  $this->operPersona->actualizarPersonaGeneral($update,$_POST['idPersona']);
  $updateNotificacion['referencia']='CAPACITACION_NUEVO_INGRESO';
  $updateNotificacion['idTabla']=$_POST['idPersona'];
  $updateNotificacion['check']=2;
  $this->notificacionmodel->actualizarNotificacion($updateNotificacion);
  $respuesta['idPersona']=$_POST['idPersona'];
  echo json_encode($respuesta);
 
}*/
//----------------------------
/*function agentesEnProceso()
{
  $agentesEnProceso=$this->operPersona->obtenerPersonas($this->emailUser,3);
  $this->datos['personasEnProceso']=array();
  $id="";
  foreach ($agentesEnProceso as $key => $value) 
  {
      if($value->esAgenteNuevo=='1')
      {  $id=$id.$value->idPersona.',';
        array_push($this->datos['personasEnProceso'], $value);
     }    
  }

  $_POST['idPersona']=$id;
  $_POST['return']=1;
 if($id!="")
 {
  $this->datos['caracteristicas']=$this->operPersona->caracteristicasAgenteNuevo($_POST); 
 }
 else
 {
  $this->datos['caracteristicas']=array();
 }
  $permiso=$this->operPersona->permisosPersona('persona_agregaAgente');
  if(isset($permiso['PasarAgenteNuevoParaAgente'])){$this->datos['permisoAgenteNuevo']=1;}
  else{$this->datos['permisoAgenteNuevo']=0;}
 $this->datos['coordinadores']=$this->operPersona->devuelveCoordinadoresVentas(); 
   
  

  //---------------------------------------------------------------------------
  //[Dennis 2020-09-30]
 
 //$ruta_documento="https://firebasestorage.googleapis.com/v0/b/v3plus-279402.appspot.com/o/documentosCapacita%2F";

 $datos_docs=$this->documentos_capitalhumano_model->get_documentos();
 $this->datos["documentos"]=$datos_docs;

 

 $this->load->view('capacita/agentesEnProceso',$this->datos);

  //---------------------------------------------------------------------------
}*/

//Ultimas Modificaciones Miguel Jaime 28/09/2020

function asesores(){
    $this->datos['asesores']=$this->PersonaModelo->devuelveInfoUserAll(); 
   $this->load->view('persona/agregaAsesores',$this->datos);
}

function getAsesor($id){
  $activo=-1;
  $sql="SELECT * FROM activar_userInfo WHERE id_user='$id'";
  $query=$this->db->query($sql);
  $result = $query->result();
  foreach($result as $row) {
        $activo=$row->activo;
  }
  return $activo;
}


function activarAsesor(){
   $id=$this->input->get('id',TRUE);
   $activo=$this->getAsesor($id);
   if($activo==-1){
    $texto="Mi meta es proporcionar la seguridad, confianza y tranquilidad de que la familia, patrimonio y negocio de nuestros asegurados, se encuentran protegidos con un plan de seguros de alta calidad y acorde a sus necesidades.";
      $data = array(
        'id_user' => $this->input->get('id',TRUE),
        'acerca_de' => $texto
       );
      $this->db->insert("activar_userInfo",$data);
    }   
    if($activo==1){
         $query = "UPDATE activar_userInfo SET activo=0 WHERE id_user='$id'";
         $this->db->query($query);
    }
    if($activo==0){
         $query = "UPDATE activar_userInfo SET activo=1 WHERE id_user='$id'";
          $this->db->query($query);
    }

   redirect(base_url()."persona/asesores");
}


function modificar_acerca_de_mi(){
   $id=$this->input->post('id_editar',TRUE);
   $detalle=$this->input->post('txtdetalle',TRUE);
   $formacion=$this->input->post('txtformacion',TRUE);
   $experiencia=$this->input->post('txtexperiencia',TRUE);
   
   if($this->input->post('chkautos',TRUE)==1){$autos=1;}else{$autos=0;}
   if($this->input->post('chkgmm',TRUE)==1){$gmm=1;}else{$gmm=0;}
   if($this->input->post('chkvidas',TRUE)==1){$vidas=1;}else{$vidas=0;}
   if($this->input->post('chkdanos',TRUE)==1){$danos=1;}else{$danos=0;}
   if($this->input->post('chkfianzas',TRUE)==1){$fianzas=1;}else{$fianzas=0;}
   if($this->input->post('chkespanol',TRUE)==1){$espanol=1;}else{$espanol=0;}
   if($this->input->post('chkingles',TRUE)==1){$ingles=1;}else{$ingles=0;}
   if($this->input->post('chkfrances',TRUE)==1){$frances=1;}else{$frances=0;}

  if($this->getAsesor($id)==-1){
     $texto="Mi meta es proporcionar la seguridad, confianza y tranquilidad de que la familia, patrimonio y negocio de nuestros asegurados, se encuentran protegidos con un plan de seguros de alta calidad y acorde a sus necesidades.";
      $data = array(
        'id_user' => $id,
        'acerca_de' => $texto,
        'formacion' => $formacion,
        'experiencia' => $experiencia,
        'autos' => $autos,
        'gmm' => $gmm,
        'vidas' => $vidas,
        'danos' => $danos,
        'fianzas' => $fianzas,
       );
      $this->db->insert("activar_userInfo",$data);
  }

   $imagen1= $this->manejodocumento_modelo->eliminaCaracteres($_FILES['imagen1']['name']);
   if(isset($detalle)){
      $query = "UPDATE activar_userInfo SET acerca_de='$detalle', formacion='$formacion', experiencia='$experiencia', autos='$autos', gmm='$gmm', vidas='$vidas', danos='$danos', fianzas='$fianzas', espanol='$espanol', ingles='$ingles', frances='$frances' WHERE id_user='$id'";
       $this->db->query($query);
    }
    if($imagen1!=""){
        $query = "UPDATE user_miInfo SET fotoUser='$imagen1' WHERE idPersona='$id'";
        $this->db->query($query);
     
      // Subir Imagen  ************
       $this->load->model('manejodocumento_modelo');
       $mi_archivo = 'imagen1';
       $directorio=$this->manejodocumento_modelo->obtenerDirectorio("U");
       $config['upload_path'] = $directorio."assets/img/miInfo/userPhotos";
       $config['file_name'] =  $this->manejodocumento_modelo->eliminaCaracteres($_FILES['imagen1']['name']);
       $config['allowed_types'] = "*";
       $config['max_size'] = "50000";
       $config['max_width'] = "2000";
       $config['max_height'] = "2000";
       $this->load->library('upload', $config);
           if (!$this->upload->do_upload($mi_archivo)) {
              $data['uploadError'] = $this->upload->display_errors();
              echo $this->upload->display_errors();
              return;
           }
      $data['uploadSuccess'] = $this->upload->data();
    }
    $this->asesores();
}
//**** Modificación 25 oct 2021 MJ


function activarTarjetaDigital(){
    $sql="SELECT user_miInfo.* from user_miInfo,persona where persona.idPersona=user_miInfo.idPersona AND persona.bajaPersona=0";
    $this->data['asesores']=$this->db->query($sql)->result();
    $this->load->view('persona/agregaAsesoresTarjeta',$this->data);
}

//**** Modificación 25 oct 2021 MJ
function verificarActivo(){
    $id=$_GET['id'];
    $sql="SELECT * from user_miInfo WHERE id='$id'";
    $rs=$this->db->query($sql)->result();
    if( (isset($rs[0]->IDValida)) && (isset($rs[0]->fotoUser)) && (isset($rs[0]->nombre)) && (isset($rs[0]->apellidop)) && (isset($rs[0]->emailUser)) && (isset($rs[0]->ciudad)) && (isset($rs[0]->telefono_celular)) ){
          $nombre=$rs[0]->nombre.' '.$rs[0]->apellidop;
          $this->generarQR($rs[0]->IDValida,$nombre);
      }else{
         echo "<div class='alert alert-danger'>Datos incompletos del usuario seleccionado, <b>no se puede Generar QR</b>, Favor completar en edicion&nbsp;<i class='fa fa-edit' style='font-weight:bold;font-size:16px;'></i></div>";
    }
}

function generarQR($IDValida,$nombre){
  $qr="https://www.asesoresonline.mx/tarjeta/index.php?id=".$IDValida;
  $PNG_TEMP_DIR = "assets/temp/";
  $PNG_WEB_DIR = "../assets/temp/";
  include "assets/phpcode/qrlib.php";
  if (!file_exists($PNG_TEMP_DIR))
      mkdir($PNG_TEMP_DIR);
  $filename = $PNG_TEMP_DIR.'test.png';
  $matrixPointSize = 7;
  $errorCorrectionLevel = 'L';
  $filename = $PNG_TEMP_DIR.'test'.md5($qr.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
  QRcode::png($qr, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
  echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" />';
  echo "<br><br><div class='alert alert-info'><b>Codigo QR, generado con exito! para:</b> ".$nombre."</div>";
}
//Fin
//****************************************

//--------------------------------------------------------------------------------------
//[Dennis 2020-09-29]
function enviarSolicitudEvaluacion(){
  
  //carga de configuración SMTP.
  $config["protocol"]="smtp";
  $config["smtp_user"]="invitacion@asesorescapital.com";
  $config["smtp_pass"]="Invitacion2020#";
  $config["smtp_port"]=587;
  $config["smtp_host"]="mail.asesorescapital.com";
  $config["mailtype"]="html";
  $config["charset"]="UTF-8";
  $config["wordwrap"]=TRUE;

  //$respuesta=array();

  $this->email->initialize($config);

  /*$respuesta["bool"]=true;
  $respuesta["mensaje"]="Solicitud enviado correctamente";*/

  //$mensajeCorreo=$this->load->view("capacita/mensajeCorreo",true);
  /*$mensajeCorreo="
    <!DOCTYPE html>
    <html>
    <head>
    </head>
    <body>
      <div style='width:100%; border: 1px red solid; height: 20%'>
      </div>
    </body>
    </html>
  "; */
  
  //Obtener datos del solicitante.
  $info=$this->operPersona->devuelveInfoUser($_GET["q"]);

  if(isset($info)){
    foreach($info as $valor){
      $mensajeCorreo="<DOCTYPE html>
        <html>
        <head>
          <title></title>
        </head>
        <body>
        <table width='75%' align='center' border='1' style='border-collapse:collapse; border-color: #b2b2b2;'>
          <tr>
            <td align='center' colspan='2'>
              <img src='https://www.capsys.com.mx/V3/assets/images/logo_capacita.png' width='25%'>
            </td>
          </tr>
          <tr>
            <td colspan='2' align='left'><b>Fecha solicitud:&nbsp;&nbsp;</b>". date("Y-m-d")."</td>
          </tr>
          <tr align='center'><td colspan='2'><h2 style='color: blue;'>SOLICITUD DE EVALUACIÓN</h2></td></tr>
          <tr>
            <td><b>Tipo de evaluación:</b></td>
            <td>".$_GET["r"]."</td>
          </tr>        
          <tr>
            <td colspan='2' align='center'>
              <b>********* DATOS DEL SOLICITANTE *********</b>
            </td>
          </tr>
          <tr>
            <td><b>Nombre solicitante:</b></td>
            <td>".ucwords($valor->name_complete)."</td>
          </tr>
          <tr>
            <td><b>Email del solicitante:</b></td>
            <td>".$valor->email."</td>
          </tr>
        </table>
        </body>
        </html>";

      //Envio de correo electrónico.
      $this->email->from("invitacion@asesorescapital.com","Solicitud");
      $this->email->to("auxiliardesarrollo@agentecapital.com");
      $this->email->subject("Solicitud de evaluación de capacidades");
      $this->email->message($mensajeCorreo);

      $respuesta["bool"]=true;
      $respuesta["mensaje"]="Solicitud enviado correctamente";

      if(!$this->email->send()){
        $respuesta["bool"]=false;
        $respuesta["mensaje"]="Hubo un detalle con el envío de la solicitud \n".$this->email->print_debugger();
      } else{
        
        $this->operPersona->actualizaEvaluacion($_GET["q"],$_GET["r"]);
      }

      echo json_encode($respuesta);

    }
  }
}
//-------------------------------------------------------------------------------------
//[Dennis 2020-09-29]
function agenteNuevoEnProceso(){

  $agenteNuevo=array();

  $infoPersona=$this->operPersona->obtenerInfoIndividual($this->idPersona);
  $caracteristica=$this->operPersona->obtenerCaracteristicaIndividual($this->idPersona);
  $defaulCaracteristicas=$this->operPersona->obtenerCaracteristicasDefault();

  $agenteNuevo["datosPersonales"]=$infoPersona;
  //$agenteNuevo["capacitacionActiva"]=$caracteristica;

  $arregloCar=array();
  $validador=array();

  foreach($defaulCaracteristicas as $elementos){
    foreach($caracteristica as $datos){
      if(trim($elementos->caracteristicaAgenteNuevo)==trim($datos->caracteristicaAgenteNuevo)){
        
        //$arregloCar[$elementos->posicion]["caracteristica"]=$datos->caracteristicaAgenteNuevo;
        $arregloCar[$elementos->posicion][$datos->caracteristicaAgenteNuevo]=array(
          //"idPersona"=>$datos->idPersona,
          "evaluacion"=>$datos->envioSolicitudEvaluacion
        );//$datos->envioSolicitudEvaluacion;
        //$arregloCar[$elementos->posicion]["evaluacion"]=$datos->envioSolicitudEvaluacion;

        //array_push($arregloCar,$conDatos);

        array_push($validador,trim($elementos->caracteristicaAgenteNuevo));

      } 
      
      if(!in_array($elementos->caracteristicaAgenteNuevo,$validador)){
        //array_push($prueba,$elementos->caracteristicaAgenteNuevo);
        $arregloCar[$elementos->posicion][$elementos->caracteristicaAgenteNuevo]=0;
        //$arregloCar[$elementos->posicion]["caracteristica"]=0;
        //$arregloCar[$elementos->posicion]["evaluacion"]=0;
      }
    }
  }

  $agenteNuevo["capacitacionActiva"]=$arregloCar;

  

  $this->load->view("capacita/procesoAgenteNuevo",$agenteNuevo);
}

//**** Modificación 25 oct 2021 MJ
function modificar_info_tarjetas_digitales(){
   $idPersona=$this->input->post('idPersona',TRUE);
   $IDValida=$this->input->post('IDValida',TRUE);
   //$canal=$this->input->post('idCanal',TRUE);
   $ciudad=$this->input->post('ciudad',TRUE);
   $celular=$this->input->post('celular',TRUE);
   $nombre=$this->input->post('nombre_edit',TRUE);
   $apellidop=$this->input->post('apellido_edit',TRUE);

   $sqlX="UPDATE user_miInfo SET IDValida='$IDValida', ciudad='$ciudad', telefono_celular='$celular', nombre='$nombre', apellidop='$apellidop' WHERE idPersona='$idPersona'";
  $this->db->query($sqlX);
  //$sqlY="UPDATE persona SET id_catalog_canales='$canal' WHERE idPersona='$idPersona'";
  //$this->db->query($sqlY);
  $imagen1= $this->manejodocumento_modelo->eliminaCaracteres($_FILES['imagen1']['name']);
  if($imagen1!=""){
      $query = "UPDATE user_miInfo SET fotoUser='$imagen1' WHERE idPersona='$idPersona'";
      $this->db->query($query);
     
      // Subir Imagen  ************
       $this->load->model('manejodocumento_modelo');
       $mi_archivo = 'imagen1';
       $directorio=$this->manejodocumento_modelo->obtenerDirectorio("U");
       $config['upload_path'] = $directorio."assets/img/miInfo/userPhotos";
       $config['file_name'] =  $this->manejodocumento_modelo->eliminaCaracteres($_FILES['imagen1']['name']);
       $config['allowed_types'] = "*";
       $config['max_size'] = "50000";
       $config['max_width'] = "2000";
       $config['max_height'] = "2000";
       $this->load->library('upload', $config);
           if (!$this->upload->do_upload($mi_archivo)) {
              $data['uploadError'] = $this->upload->display_errors();
              echo $this->upload->display_errors();
              return;
           }
      $data['uploadSuccess'] = $this->upload->data();
    }
   $this->activarTarjetaDigital();
}

//-----------------------------------------------------------------
function devuelveInfoCumpleanios(){

  //json_encode($_GET["q"]);
  $this->load->model("menu_model","menu_");
  $this->load->model("notificacionmodel","notificacion_");
  $json_array_return=array();
  $json_array_return["mensaje"]="Sin resultados";
  $personas_hb=array();

  $informacion=$this->operPersona->devuelveFelicitaciones($_GET["q"]);

  $ruta_foto = "assets/img/miInfo/userPhotos/";

  if(!empty($informacion)){

    $this->notificacion_->updateSingle($_GET["r"]);

    $json_array_return["mensaje"]="";
    foreach($informacion as $datos){

      $json_array_return["comentario"]=$datos->mensaje;
      $json_array_return["mes"]=$datos->mes;
      $json_array_return["dia"]=$datos->dia;

      $img=$this->menu_->buscaFotoPersonal($datos->idPersona_cumpleanio);
      
      $ruta_img_absoluta= isset($img) ? base_url().$ruta_foto.$img : base_url().$ruta_foto."noPhoto.png";

      $nombre_completo=$datos->nombres." ".$datos->apellidoPaterno." ".$datos->apellidoMaterno;

      $area = "sin área";
      $puesto = "sin puesto";

      if($datos->aliadoCarCapital == 1){
        
        $area = "car capital";
        $puesto = "aliado";
      } else {
        if($datos->tipoPersona == 3){

          $area = "comercial";
          $puesto = $datos->nombreTitulo == "FIANZAS" ? "agente de fianzas" : "agente de seguros (".$datos->nombreTitulo.")";
        } else{

          $area = $datos->colaboradorArea;
          $puesto = $datos->personaPuesto;
        }
      }

      array_push($personas_hb, array(
        "idPersona_cumpleanio" => $datos->idPersona_cumpleanio,
        "nombre_completo" => $nombre_completo,
        "fotoPersonal" => $ruta_img_absoluta,
        "fechaNacimiento" => $datos->fechaNacimiento,
        "puesto" => $puesto, //$datos->personaPuesto,
        "area" => $area //!empty($datos->colaboradorArea) ? $datos->colaboradorArea : "Comercial"
      ));

    }

    $json_array_return["personas_hb"]=$personas_hb;
  }


  
  echo json_encode($json_array_return);
}
//--------------------------
//Dennis Castillo [2021-10-31]
function getProspectiveData(){

  $getData = $this->crmproyecto->getAgentDataForCreate($_GET["id"]);
  $getData[0]->idModalidad = 0;
  $getData[0]->idColaboradorArea = 1;
  $getData[0]->tipoPersona = 3;
  //$getData[0]->usuarioPassword = "temporalPassword".rand();
  //$getData[0]->personaTipoAgente = array("value" => 1, "label" => "Agente en Formacion");
  //$getData[0]->id_catalog_canales = array("value" => 11, "label" => "CAP CAPITAL");
  $getData[0]->fecAltaSistemPersona = date("d-m-Y");
  
  echo json_encode($getData);
}
//-----------------------------
//Dennis Castillo [2021-10-31]
function registerTemporalUser(){

  $idPersona = $_POST["id"];

  $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
  $idUsuario=$this->operPersona->obtenerIdUser($idPersona);
  $password = substr(str_shuffle($permitted_chars), 0, 10);
  $usermail = "usuario".rand();
  $this->tank_auth->change_password_user($idUsuario,strtoupper($password));
  $progressData = $this->crmproyecto->getProspectiveAgentProgressByIdPerson($idPersona);

  $data["idPersona"] = $idPersona;
  $data["username"] = $usermail;
  $data["email"] = $usermail;
  $data["passwordVisible"] = strtoupper($password);
  //$data["fecAltaSistemPersona"] = date("Y-m-d H:i:s");

  $assingTemporalUser = $this->operPersona->updateToTemporalCount($data);
  $updateDate = $this->operPersona->actualizarPersonaGeneral(array("fecAltaSistemPersona" => date("Y-m-d H:i:s")),  $idPersona);
  $updateTypeProspective = $this->crmproyecto->updateProspectiveUser($progressData->idProspecto, array("avance" => "induccion"));
  //$this->sendNotification($idPersona);
  echo json_encode(array("success" => 1, "message" => "Prospecto liberado. Ahora es un agente temporal"));
}
//-----------------------------
//Dennis Castillo [2021-10-31]
function inducctionProgress(){

  $employes = $this->operPersona->obtenerPersonas("DIRECTORGENERAL@AGENTECAPITAL.COM", 3);
  $inducctionEmployee = array_filter($this->operPersona->getEmployeeUsers(), function($arr){ return ($arr->avance == "induccion" || $arr->avance == "documento" || $arr->avance == "liberado") && $arr->revisado == 0; });
  $employes_ = array_map(function($arr){ //$employes

    $dataPerson = $this->operPersona->buscaPersona($arr->idPersona, "", 3);
    $dataUser = $this->operPersona->obtenerDatosUsuarios($arr->idPersona,'email,username');
    $dataPerson->username = $dataUser->username;
    $dataPerson->email = $dataUser->email;
    $dataPerson->avance = $arr->avance;
    
    return $dataPerson;
  }, $inducctionEmployee);
  
  foreach($employes_ as $d_e){
    //------------------------
    $d_e->reviewer = array(
      array(
        "reviewer_" => "ASISTENTEDIRECCION@AGENTECAPITAL.COM", 
        "label" => "ASISTENTE DE DIRECCION",  
        "check" => !empty($this->operPersona->getReviewer($d_e->idPersona, "ASISTENTEDIRECCION@AGENTECAPITAL.COM")) ? "checked" : ""),
      array(
        "reviewer_" => "CONTABILIDAD@AGENTECAPITAL.COM", 
        "label" => "CONTABILIDAD", 
        "check" => !empty($this->operPersona->getReviewer($d_e->idPersona, "CONTABILIDAD@AGENTECAPITAL.COM")) ? "checked" : "")
    );
    //---------------------
  }

  //$agents = array_filter($this->crmproyecto->newAgentsOnInducction(), function($arr){ return $arr->revisado == 0; });
  $agents = array_filter($this->crmproyecto->newAgentsOnInducctionAndDocuments(), function($arr){ return $arr->revisado == 0; });
  //var_dump($agents);
  foreach($agents as $data_){
    //------------------------
    $data_->reviewer = array(
      array(
        "reviewer_" => "ASISTENTEDIRECCION@AGENTECAPITAL.COM", 
        "label" => "ASISTENTE DE DIRECCION",  
        "check" => !empty($this->operPersona->getReviewer($data_->idPersona, "ASISTENTEDIRECCION@AGENTECAPITAL.COM")) ? "checked" : ""),
      array(
        "reviewer_" => "CONTABILIDAD@AGENTECAPITAL.COM", 
        "label" => "CONTABILIDAD", 
        "check" => !empty($this->operPersona->getReviewer($data_->idPersona, "CONTABILIDAD@AGENTECAPITAL.COM")) ? "checked" : "")
    );
    //------------------------
    
  }

  $data["personsInduction"][] = array(
    "tab" => "Colaboradores",
    "values" => array_values($employes_)
  );
  $data["personsInduction"][] = array(
    "tab" => "Agentes",
    "values" => $agents //$this->crmproyecto->newAgentsOnInducction()
  );


  $data["tabs"] = array("colaboradores", "agentes");
  
  $this->load->view("capacita/inducctionProgress", $data);
}
//-----------------------------
function getPersonalData(){ //aqq

  $_POST["idPersonas"] = $_GET["id"];
  $typePerson = $this->operPersona->obtenerTipoPersona($_GET["id"]);
  //$data["nombre"] = $this->operPersona->obtenerNombrePersona($_GET["id"]);
  //obtenerNombrePersona
  $this->buscarPersona($typePerson);
  $validateKeys = array("datosAgente", "puestoColaborador", "tipoPersona");

  foreach($this->datos as $key => $values){
    if(!in_array($key, $validateKeys)){
      unset($this->datos[$key]);
    }

	$this->datos["availibleAccounts"] = $this->operPersona->getUsersForDelete($this->datos["puestoColaborador"]["idPuesto"]);
  }
  

  echo json_encode($this->datos);
}
//-----------------------------
//Dennis Castillo [2021-10-31]
//function getPersonalData(){ //aqq

  //$_POST["idPersonas"] = $_GET["id"];
  //$typePerson = $this->operPersona->obtenerTipoPersona($_GET["id"]);
  //$data["nombre"] = $this->operPersona->obtenerNombrePersona($_GET["id"]);
  //obtenerNombrePersona
  //$this->buscarPersona($typePerson);

  

  //echo json_encode($this->datos["datosAgente"]);
//}
//----------------------------- //Dennis Castillo [2022-06-10]
function getWelcomeTemplate(){

  $generate = $this->generateWelcomeTemplate($_GET["person"], $_GET["template"]); //"assets/plantillas_ingreso/platillas_nuevas_personas/person_1058.png"
  echo json_encode(array(
    "data" => "assets/plantillas_ingreso/plantillas_nuevas_personas/person_".$_GET["person"]."_".$_GET["template"].".png")
  );

}
//-----------------------------
//Dennis Castillo [2021-10-31] -> [2022-06-10]
function generateWelcomeTemplate($idPerson, $template){

  //$nameTemplate = array("institucional", "asesores", "cap capital", "fianzas");
  $dataPerson = $this->operPersona->buscaPersona($idPerson, $this->tank_auth->get_usermail(), 3);
  $dataUser = $this->operPersona->obtenerDatosUsuarios($idPerson,'email');
  $userPhoto = $this->db->query("select fotoUser from user_miInfo where idPersona = ".$idPerson."")->row();
  $job = $this->db->query("select * from personapuesto where idPuesto =".$dataPerson->idPersonaPuesto)->row();

  $agentDescription = $template == "fianzas" ? 132 : 131;
  $iddescription = $dataPerson->tipoPersona == 1 ? $dataPerson->idPersonaPuesto : $agentDescription;
  $jobDescription = $this->db->query("select * from job_description where idPuesto = ".$iddescription."")->row();

  $name = $dataPerson->nombres." ".$dataPerson->apellidoPaterno." ".$dataPerson->apellidoMaterno;
  $mission = !empty($jobDescription) ? $jobDescription->mision : "Sin misión";
  $typeEmployee = $dataPerson->tipoPersona == 1 ? $job->personaPuesto : "AGENTE DE ".strtoupper($template)."";

  $img = $this->imgedit_cenis->createWelcomeTemplate(
    $userPhoto->fotoUser, 
    $idPerson, 
    $name, 
    $dataPerson->fecAltaSistemPersona, 
    $dataUser->email, 
    $typeEmployee, 
    str_replace('"', '', $mission), 
    strtolower(str_replace(" ", "", $template))
  );

  return $img;
}
//-----------------------------
//Dennis Castillo [2021-10-31]
function manejoDePersonaTemporal(){
  
  $fields = $this->db->list_fields("persona_temporal");
  $readyForInsert = array();

  foreach($_POST as $key => $value){

    if(in_array($key, $fields) && !empty($value)){
      $readyForInsert[$key] = $key == "fecAltaSistemPersona" ? $this->convierteFecha($value) : $value;
    }
  }

  $insert = $this->operPersona->insertRegister("persona_temporal", $readyForInsert);
  $insertCreator = $this->operPersona->insertRegister("persona_temporal_creator", array("idTemporalPerson" => $insert, "creator" => $this->tank_auth->get_usermail()));
  

  return array("idPersona" => $insert, "tipoPersona" => $readyForInsert["tipoPersona"]);
}
//-----------------------------
//Dennis Castillo [2021-10-31]
function getTemporalPersonData(){
  $idPersona = $_GET["id"];

  //$temporal = "select * from persona_temporal a left join persona_temporal_creator b on a.idPersona = b.idTemporalPerson where a.idPersona = ".$idPersona."";
  $temporal = "select * from persona_temporal a left join persona_temporal_creator b on a.idPersona = b.idTemporalPerson left join personapuesto  c on a.idPersonaPuesto = c.idPuesto where a.idPersona = ".$idPersona."";
  $queryT = $this->db->query($temporal);
  $result = $queryT->num_rows() > 0 ? $queryT->result() : array();
  
  echo json_encode($result);
}
//-----------------------------
//Dennis Castillo [2021-10-31]
function generatePassCode($idPersona){

  $validateExists = $this->operPersona->getPassCodeNewUser($idPersona);
  $newPassCode = rand();

  if(empty($validateExists)){

    $this->operPersona->insertRegister("new_person_passcode", array("idPersona" => $idPersona, "passCode" => $newPassCode, "dateCreation" => date("Y-m-d H:i:s")));
  } else{
    $this->operPersona->updatePassCode($idPersona, array("passCode" => $newPassCode, "dateCreation" => date("Y-m-d H:i:s")));
  }
}
//-----------------------------
//Dennis Castillo [2021-10-31]
function registerTemporalUserDirectly(){

  $idPersona = $_POST["idPerson"];
  $puesto = $_POST["employment"];
  
  $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
  $idUsuario=$this->operPersona->obtenerIdUser($idPersona);
  $password = substr(str_shuffle($permitted_chars), 0, 10);
  $usermail = "usuario".rand();
  $this->tank_auth->change_password_user($idUsuario,strtoupper($password));
  
  //---------------------- Apply change employment
  $actualizaPuesto = $this->operPersona->changePersonPosition($idPersona, $puesto);
  //----------------------
  $data["idPersona"] = $idPersona;
  $data["username"] = $usermail;
  $data["email"] = $usermail;
  $data["passwordVisible"] = strtoupper($password);
  //$data["fecAltaSistemPersona"] = date("Y-m-d H:i:s");

  $assingTemporalUser = $this->operPersona->updateToTemporalCount($data);
  $updateDate = $this->operPersona->actualizarPersonaGeneral(array("fecAltaSistemPersona" => date("Y-m-d H:i:s")),  $idPersona);
  $updateStatus = $this->operPersona->updateStatusEmployeeToUser(array("avance" => "induccion"), $idPersona, null);
  
  $this->sendMailNotification($idPersona);

  echo json_encode(array("success" => 1, "message" => "Usuario liberado.\nSe ha realizado la notificación a su correo personal.\nAhora esta listo para la inducción"));
}
//-----------------------------
//Dennis Castillo [2021-10-31]
function sendMailNotification($idPersona){

  $name = $this->operPersona->obtenerNombrePersona($idPersona);
	$data["name"] = $name;
	$data["person"] = $idPersona;
	$mensaje = $this->load->view("crmproyecto/correo_notificacion", $data, true); //emailPersonal

  $select = "select emailPersonal from persona where idPersona=".$idPersona;
  $query = $this->db->query($select);
  $getpersonalMail = $query->num_rows() > 0 ? $query->row() : array();
		//idCorreo, fechaCreacion, desde, para, copia, copiaOculta, asunto, mensaje, fileAdjunto, nameAdjunto, status, fechaEnvio, identificaModulo
  if(!empty($getpersonalMail->emailPersonal)){
    $sendMail = $this->crmproyecto->insertaRegistros(array(
      "desde" => "Avisos de GAP<avisosgap@aserorescapital.com>", 
      "para" => $getpersonalMail->emailPersonal, 
      "asunto" => "Inducción para nuevo personal",
      "mensaje" => $mensaje,
    ), "envio_correos");
  }
}
//-----------------------------
function updateLayouts(){

  $select = "select * from personatipoagente;"; //where  idPersonaTipoAgente = 3"; //idPersonaTipoAgente <> 8 AND idPersonaTipoAgente <> 0 AND
  $tipoAgente = $this->db->query($select)->result();

  $selectupload = "select * from personadocumento";
  $upladedDocs = $this->db->query($selectupload)->result();

  foreach($tipoAgente as $d_a){

    $selectupload = "select * from personadocumento where layoutPD = ".$d_a->idPersonaTipoAgente."";
    $upladedDocs = $this->db->query($selectupload)->result();

    foreach($upladedDocs as $d_d){

      if($d_d->descripcionPD == "FOTO" || $d_d->descripcionPD == "CONTRATO"){

        $update = "update personadocumento set layoutPD = 0 where layoutPD = ".$d_a->idPersonaTipoAgente." and descripcionPD = '".$d_d->descripcionPD."'";
        $this->db->query($update);
        var_dump($update);
        var_dump($d_d->descripcionPD);
        var_dump($d_d->idPersonaDocumento);
      }
    }

    $insert = "insert into personadocumento(descripcionPD, textoPD, obligatorioPD, classFilaPD, layoutPD) values('CONTRATOOUTSOURSING', 'Contrato digitalizado del outsoursing, debidamente firmado y con huella digital en cada hoja', 'SI', 'filaImportante', ".$d_a->idPersonaTipoAgente.")";
    $insert_ = "insert into personadocumento(descripcionPD, textoPD, obligatorioPD, classFilaPD, layoutPD) values('CONTRATOMERCANTIL', 'Contrato digitalizado mercantil, debidamente firmado y con huella digital en cada hoja', 'SI', 'filaImportante', ".$d_a->idPersonaTipoAgente.")";
    $this->db->query($insert);
    $this->db->query($insert_);
    var_dump($insert);
    var_dump($insert_);
  }

}
//-----------------------------
function updateCheck(){

  $idPerson = $_POST["id"];
  $updateRegister = $_POST["typePerson"] == 1 ? 
    $this->operPersona->updateStatusEmployeeToUser(array("revisado" => 1), $idPerson, null) //updateCheckProspectiveByPerson
    :
    $this->crmproyecto->updateCheckProspectiveByPerson(array("revisado" => 1), $idPerson);

  echo json_encode(array(
    "message" => $updateRegister ? "Registro marcado como revisado" : "Ocurrio un error. Por favor, contacte al depto de sistemas.",
    "bool" => $updateRegister
  ));
}
//-----------------------------
function manageReviewer(){

  $queryString = "";
  switch($_POST["action"]){
    case "agree": $queryString = "insert into induction_user_reviewer(idPerson, reviewer) values(".$_POST["id"].", '".$_POST["viewer"]."')";
      break;
    case "delete": $queryString = "delete from induction_user_reviewer where idPerson = ".$_POST["id"]." and reviewer = '".$_POST["viewer"]."'";
      break;
  }

  $query = $this->operPersona->executeQuery($queryString);
  $response["message"] = $query ? "executado con exito" : "hubo un fallo";
  $response["bool"] = $query;

  echo json_encode($response);

}
//-----------------------------
function updateAllInducctionUsers(){

  //$select = 'SELECT * FROM persona WHERE tipoPersona = 1 AND esAgenteNuevo = 1';
  $select = 'SELECT * FROM persona LEFT JOIN users ON persona.idPersona = users.idPersona WHERE tipoPersona = 3 AND esAgenteNuevo = 1 AND bajaPersona = 0 AND banned = 0 AND activated = 1;';
  $query = $this->db->query($select)->result();

  foreach($query as $d_q){

    $subSelect = 'SELECT * FROM prospective_to_user WHERE idPersona = '.$d_q->idPersona;
    $query_ = $this->db->query($subSelect);
    $result_ = $query_->num_rows() > 0 ? $query_->result() : array();

    if(empty($result_)){

      $insert = 'INSERT INTO prospective_to_user(idPersona, avance, revisado) VALUES('.$d_q->idPersona.',"induccion",0)';
      $this->db->query($insert);
    }
  }
}
//-----------------------------
function assingToMyGroup(){

  $data["personal"] = array_filter($this->operPersona->obtenerPersonas("DIRECTORGENERAL@AGENTECAPITAL.COM", 1), function($arr){ return $arr->tipoPersona == 1;});
  $data["personalToAssing"] = $this->operPersona->devuelveHijosCoordinador("DIRECTORGENERAL@AGENTECAPITAL.COM");

  //var_dump($data["personal"]);
  $this->load->view("persona/onlyForAssigToMyEmployess", $data);
}
//------------------------------
function passToMyGroup(){

  
  //var_dump($_POST["myPerson"]);
  $arr = array();
  foreach ($_POST["myPerson"] as $key => $value) {
    # code...
    $validate = "select * from true_creator where idChild = ".$value." and creator = '".$_POST["forAssign"]."'";
    $executeQuery = $this->db->query($validate)->row();

    if(empty($executeQuery)){
      $insert = 'insert into true_creator(creator, idChild) values("'.$_POST["forAssign"].'", '.$value.')';
      $executeInsert = $this->db->query($insert);
      array_push($arr, $value);
    }
  }
  
  $this->assingToMyGroup();
}
//-----------------------------
//Miguel Jaime 18/11/2021
function mostrarTablaHijosPersona(){
  $this->data['hijos']=$_REQUEST['hijos'];
  $this->load->view('persona/tablaHijosPersona',$this->data);
}

//Miguel Jaime 26/11/2021
function mostrarExperienciaRequerimiento(){
  $id=$_REQUEST['id'];
  $sql="SELECT * FROM requerimientos_puesto WHERE id='$id'";
  $rsExperiencia=$this->db->query($sql)->result();
  
  //Extraer Habilidades
  $rel_habilidad=explode('|',$rsExperiencia[0]->rel_habilidad);
  for($i=0;$i<sizeof($rel_habilidad);$i++){
    $id_rel=$rel_habilidad[$i];
    $sqlX="SELECT id,titulo,detalle FROM requerimientos_puesto WHERE id='$id_rel'";
    $this->data['habilidades'][$i]=$this->db->query($sqlX)->result();
  }

  //Extraer Competencias
  $rel_competencia=explode('|',$rsExperiencia[0]->rel_competencia);
  for($i=0;$i<sizeof($rel_competencia);$i++){
    $id_rel=$rel_competencia[$i];
    $sqlY="SELECT id,titulo,detalle FROM requerimientos_puesto WHERE id='$id_rel'";
    $this->data['competencias'][$i]=$this->db->query($sqlY)->result();
  }

  $this->data['experiencia']=$rsExperiencia;
  $this->load->view('persona/detalles_requerimientos',$this->data);
}
//------------------------- Dennis [2021-12-22]
function getPositions(){

  $area = $_GET["area"];
  $person = $_GET["idPersona"];
  $superior = array("DIRECTORGENERAL@AGENTECAPITAL.COM", "DIRECTORCOMERCIAL@AGENTECAPITAL.COM", "GERENTEOPERATIVO@AGENTECAPITAL.COM", "SISTEMAS@ASESORESCAPITAL.COM", "CAPITALHUMANO@AGENTECAPITAL.COM");
  $getArea = $this->operPersona->obtenerColaboradorArea($area);
  $positionPerson = array();
  $response = array();

  $getPositions = !in_array($this->tank_auth->get_usermail(), $superior) ? 
    $this->operPersona->getPositions_($this->tank_auth->get_usermail(), $getArea) :
    $this->operPersona->getAvaliblePositions($getArea);

  if($person > 0){
    $positionPerson = $this->operPersona->puestoDePersona($person);
  }

  if(!empty($positionPerson)){
    $response = $positionPerson[0]->idColaboradorArea == $area ? array_merge($getPositions, $positionPerson) : $getPositions;
  } else{
    $response = $getPositions;
  }

  
  echo json_encode(array_values($response));
}
//------------------------- //Dennis Castillo [2022-02-22]
function passRequestForDismissal(){

  $idPersona = $_POST["id"];
  $typeRequest = $_POST["typeRequest"];

  $response = array();
  switch($typeRequest){
    case "request": $response = $this->generateDeleteRequest($idPersona);
    break;
    case "delete": $response = $this->passPersonAsInactive($idPersona);
    break;
  }
  
  echo json_encode($response);
}
//------------------------ //Dennis Castillo [2022-02-22]
function passPersonAsInactive($id){

  $success = array();
  $getProspectives = $this->crmproyecto->getProspectivesAgentsByIdPerson($id);
  $tyPerson = $this->operPersona->obtenerTipoPersona($id);
  //$email = $this->operPersona->obtenerEmail($id);
  $forData = array_map(function($arr){ return $arr->idProspecto; }, $getProspectives);
  $prospective = "";
  $deleteProspectiveProgress = true;
  
  switch($tyPerson){
    case 1:
      $dataEmployee = $this->operPersona->getEmployeeById($id);
      $deleteProspectiveProgress = $this->operPersona->updateStatusEmployeeToUser(array("avance" => $dataEmployee->estadoBaja), $id, array("person" => $id, "status" => $dataEmployee->deleteStatus));
      break;
    case 4:
    case 3:
      if(!empty($forData)){
      	$dataAgent = $this->operPersona->getAgentById($id);
        $deleteProspectiveProgress = $this->crmproyecto->updateProspectiveForStatus($forData, array("a.estadoRegistro" => "inactivo", "b.avance" => $dataAgent->estadoBaja));
        $prospective .= 'Quitar de la lista el registro del prospecto: '.( $deleteProspectiveProgress ? "Completado": "Fallido");
      }
      break;
  }

  $department = $this->operPersona->updatePersonsUserAndPendingData(
    array(
      //"a.bajaPersona" => 1,
      "a.idPersona" => 0,
      "a.email" => null,
    ), 
    array("a.idPersona" => $id));
  
  
  array_push($success, $department, $deleteProspectiveProgress); //$inactivePerson

  return array(
    "bool" => in_array(false, $success) ? false : true,
    "message" => "La baja de la persona ha sido compleado:\nDejar puesto como vacante disponible: ".($department ? "Completado" : "Fallido")."\nEliminar persona del sistema: ".($department ? "Completado" : "Fallido")."\n".$prospective."",
    "type" => "delete"
  );
}
//----------------------- //Dennis Castillo [2022-02-22]
function generateDeleteRequest($idPersona){

  $insert = $this->operPersona->insertRegister(
    "casualty_list", 
    array(
      "idPersona" => $idPersona, 
      "dateRequest" => date("Y-m-d H:i:s"), 
      "whoRequested" => $this->tank_auth->get_usermail()
    ));
    
  if($insert > 0){

    $rem = array_map(function($arr){

      $id = $this->operPersona->obtenerIdPersonaPorEmail($arr);

      return array("idPersona" => $id->idPersona, "email" => $arr);

    }, array("SISTEMAS@ASESORESCAPITAL.COM"));
    
    
    $sendNotification_ = $this->sendNotification($rem, null, $insert, "SOLICITUD_BAJA", "SOLICITUD_BAJA");
  }

  return array(
    "bool" => $insert ? 1 : 0,
    "message" => $insert ? "Se ha pasado la solicitud al departamento de sistemas." : "Ocurrio un error. Favor de contactar al departamento de sistemas.",
    "lastId" => $insert,
    "type" => "request"
  );
}
//------------------------ //Dennis Castillo [2022-02-22]
function deleteRequest(){

  $id = $_POST["id"];
  $updateNotification = $this->notificacionmodel->replaceDataNotification("SOLICITUD_BAJA", "SOLICITUD_BAJA", $id, array("check" => 2));
  $delete = $this->operPersona->removeRequest($id);

  echo json_encode(array(
    "bool" => $delete,
    "message" => $delete ? "Solicitud de baja descartada" : "Ocurrió un error. Favor de notificar al departamento de sistemas.",
  ));
}
//------------------------- //Dennis Castillo [2022-03-01]
function verifyExistsStaff(){
  
  $id = $_GET["id"];
  $getData = $this->operPersona->searchPerson($id);
  
  echo json_encode($getData);
}
//------------------------- //Dennis Castillo [2022-06-02]
function manageSupportLinks(){

  $this->load->view("persona/supportLinksView");
}
//------------------------- //Dennis Castillo [2022-06-02]
function createLink(){

  try{

    $data = false;
    $postdata = json_decode($_POST["link"], true);
    $id = $postdata["id"];
    $postdata["creator"] = $this->tank_auth->get_usermail();
    $postdata["createDate"] = date("Y-m-d H:i:s");

    if(empty($postdata["label"])){
      throw new Exception('Se sebe contener una etiqueta para la liga');
    }

    if(empty($postdata["link"])){
      throw new Exception('Se sebe contener un enlace');
    }

    

    switch($id){
      case 0: 
        unset($postdata["id"]);
        $data = $this->operPersona->createSupportLink($postdata);
        break;
      default: 
        unset($postdata["id"]);
        unset($postdata["active"]);
        $data = $this->operPersona->updateSupportLink(array("id" => $id), $postdata);
    }

    //$insert = $this->operPersona->createSupportLink($postdata);
    $response["bool"] = $data;
    $response["code"] = $data ? "200" : "201";
    $response["status"] = $data ? "success" : "failed";
    $response["message"] = $data ? "Operación realizado con exito" : "Ocurrió un error. Favor de intentar más tarde";
  
    echo json_encode($response);
  } catch(Exception $e){

    echo json_encode(array("bool" => false, "code" => "400", "status" => "Bad Request", "message" => $e->getMessage()));
  }
}
//------------------------ //Dennis Castillo [2022-06-02]
function getLinkList(){

  $reponse = array();
  $getList = $this->operPersona->getLikList();
  
  $response["bool"] = count($getList) > 0 ? true : false;
  $response["code"] = count($getList) > 0 ? "200" : "201";
  $response["status"] = count($getList) > 0 ? "success" : "failed";
  $response["data"] = $getList;

  echo json_encode($response);
}
//----------------------- //Dennis Castillo [2022-06-02]
function deleteLink(){
  
  $id = $_POST["id"];
  $response = array();
  $delete = $this->operPersona->deleteLinkOfList(array("id" => $id));

  $response["bool"] = $delete;
  $response["status"] = $delete ? "success" : "failed";
  $response["code"] = $delete ? "200" : "201";
  $response["message"] = $delete ? "Registro eliminado con éxito" : "Ocurrio un error.\nFavor de contactar al departamento de sistemas";

  echo json_encode($response);
}
//----------------------- //Dennis Castillo [2022-06-02]
function getOnlyLink(){

  $id = $_GET["id"];
  $getData = $this->operPersona->getOnlyLink($id);

  $response = array();
  $response["status"] = "success";
  $response["code"] = "200";
  $response["data"] = $getData;

  echo json_encode($response);
}
//----------------------- //Dennis Castillo [2022-06-02]
function changeLinkStatus(){

  try{

    $id = $_POST["id"];
    $value = $_POST["value"];

    $changeStatus = $this->operPersona->updateSupportLink(array("id" => $id), array("active" => $value));

    if($changeStatus == false){
      throw new Exception("Ocurrio un error al modificar el registro");
    }

    $response = array();
    $response["status"] = "success";
    $response["code"] = "200";

    echo json_encode($response);
  } catch(Exception $e){

    echo json_encode(array("status" => "Server Error", "code" => 500, "message" => $e->getMessage()));
  }
}
//----------------------- //Dennis Castillo [2022-06-02]
function getInfoNewPerson(){

  $idPerson = $_GET["idPerson"];
  $layouts = $_GET["typePerson"] == 1 ? $this->operPersona->geteEmployeLayout() : $this->operPersona->obtenerLayout($idPerson);
  $getCreator = $this->operPersona->getTrueCreator($idPerson);
  $response = array();
  $getXtraData = $this->operPersona->requerimientosExtras($idPerson);
  //$getXtraData->creator = $getCreator;

  $docsUploaded_ = array_map(function($arr) use($idPerson){

    $thisDoc = $this->operPersona->getEmployeFileUpload($idPerson, $arr->idPersonaDocumento, $arr->layoutPD);
    $validateDoc = !empty($thisDoc) ? $arr->descripcionPD.".".$thisDoc[0]->extensionPDG : "";
    return  array(
      "layout" => $arr->descripcionPD == "CUENTABANCO" ? "Cuenta bancaria" : $arr->textoPD,
      "docUploaded" => "archivosPersona/".$idPerson."/".$validateDoc,
      "disabled" => !empty($thisDoc) ? "" : "disabled",
      "exists" => !empty($thisDoc) ? true : false,
      "require" => in_array($arr->obligatorioPD, array("SI", 1)) ? true : false,
    );

  }, $layouts);

  //--------------------------
  $userPhoto = "select fotoUser from user_miInfo where idPersona = ".$idPerson."";
  $queryP = $this->db->query($userPhoto);
  $photo = $queryP->num_rows() > 0 ? $queryP->row() : array();
  array_push($docsUploaded_,array( //docs
    "layout" => "FOTO DE PERFIL",
    "docUploaded" => !empty($photo->fotoUser) ? "assets/img/miInfo/userPhotos/".$photo->fotoUser : "",
    "disabled" => !empty($photo) ? "" : "disabled",
    "require" => true,
    "exists" => true,
  ));

  $response["documents"]= $docsUploaded_;
  $response["xtraData"]= $getXtraData;
  $response["creator"]= $getCreator;

  echo json_encode(array("status" => "success", "code" => 200,"data" => $response));

}
//----------------------- //Dennis Castillo [2022-06-16]
function getAllPersons(){

  $getPersons = $this->operPersona->obtenerPersonas("SISTEMAS@ASESORESCAPITAL.COM", 1);
  $domainfilter = array("agentecapital.com", "asesorescapital.com", "fianzascapital.com", "capcapital.com.mx", "capitalseguros.com.mx", "carcapital.com.mx", "capitalrisk.com.mx");
  $aliance = array();
  $alianceValid = array();
  $others = array();

  foreach($getPersons as $data){

    $domain = explode("@", $data->email);
    if(filter_var($data->email, FILTER_VALIDATE_EMAIL) && !in_array(strtolower($domain[1]), $domainfilter) && $data->personaTipoAgente == "Car Capital"){
      array_push($aliance, $data->idPersona);
      array_push($alianceValid, $data);

    } elseif(filter_var($data->email, FILTER_VALIDATE_EMAIL) && in_array(strtolower($domain[1]), $domainfilter)){
      array_push($others, $data->idPersona);
    }
  }

  $this->db->trans_begin();
  $this->db->where_in("idPersona", $aliance);
  $this->db->update("users", array("aliadoCarCapital" => true));

  $this->db->where_in("idPersona", $others);
  $this->db->update("users", array("aliadoCarCapital" => false));

  if($this->db->trans_status() === FALSE){
    $this->db->trans_rollback();
  } else{
    $this->db->trans_commit();
    echo "Cambios realizado con éxito";
  }

  var_dump($alianceValid);
  
}
//-----------------------
}
