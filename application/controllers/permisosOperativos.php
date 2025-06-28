<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class PermisosOperativos extends CI_Controller{
	private $quitarSicas = array('<p>', '</p>', '<br />', ',');
	private $ponerSicas = array('', '', '\n\r', '');
	var $datos=array();//$datos="";
//--------------------------------------------------------------------------
	function __construct(){
		parent::__construct();
				$this->load->model('catalogos_model');
				$this->load->model('personamodelo');
				$this->load->model('procesamientoncmodel');
				$this->load->model("metacomercial_modelo");
				$this->load->model("capitalhumano_model");
				$this->load->model("preguntamodel"); //Dennis [2021-08-07]
				$this->load->model("actividades_model");
				$this->load->model('incidenciasmodel', 'incidencias_model');
				$this->load->model("permisooperativo", "PermisoOperativo"); //Creado [Suemy][2024-03-21]
	}
//--------------------------------------------------------------------------
	function i()
	{$this->datos['ramos']=$this->catalogos_model->get_Ramos();
	$this->datos['actividades'] = $this->actividades_model->TablaActividades();
	   	$this->datos['actividades'] = $this->actividades_model->TablaActividades();
		$this->datos['ramos']=$this->catalogos_model->get_Ramos();
		$this->datos['rankings']=$this->personamodelo->obtenerRankingAgente();
		$this->datos['calificacionAgente']=$this->catalogos_model->calificacionAgente();
		$this->datos['ramoPromotoria']=$this->catalogos_model->obtenerTodoRamoPromotoria();
		//$this->datos['empleados']=$this->personamodelo->obtenerEmpleados();
		//$this->datos['empleados']=$this->personamodelo->devolverColaboradoresActivos();
		$array['grupos']=1;
        $this->datos['empleados']=$this->personamodelo->devolverColaboradoresActivos($array);
  
		if(!isset($this->datos['modulosPermisosPersona'])){
		$this->datos['modulosPermisosPersona']="";}//$this->personamodelo->devolverModulosPermisos();
        $this->datos['companiasDocumentos']=$this->catalogos_model->devolverCompanias();
        $this->datos['documentosNecesarios']=$this->catalogos_model->catalogpromotoriadocumento(null);
        $this->datos['coordinadoresHijos']=$this->personamodelo->coordinadoreshijos(null);           
        $arrayASMS['idTareasProgramadas']=1;
		$this->datos['tareasProgramadasSMS']=$this->catalogos_model->tareasProgramadas($arrayASMS);
		//--------------------------
		//[Dennis 2020-10-05]
		$this->datos["personalSuperior"]=$this->personamodelo->devuelveCoordinadoresVentas();
		$this->datos["ramoPoliza"]=$this->personamodelo->devuelveRamo();
		$this->datos["coorAsignados"]=$this->personamodelo->devuelveCoorMetaComercial();
		$this->datos["coorAsignadosIT"]=$this->personamodelo->devuelveCoorMetaComercialIngresoTotal(); //Dennis 2021-05-07
		//-------------------------
		//[Dennis 2021-07-12]
		$this->datos["cierresMensuales"] = $this->metacomercial_modelo->devuelveCierreComercial();
		$this->datos["mesComercialActivado"] = $this->metacomercial_modelo->devuelveActivacionComercial();
		//-------------------------
       	$this->datos['causaRaiz']=$this->procesamientoncmodel->causaraiz(null);
	$this->datos['accionCorrectiva']=$this->procesamientoncmodel->accionCorrectiva(null);
	   $this->datos['estadoRobotActividades']=(string)$this->db->query('select dr.estaFuncionando from tareasrobot dr where dr.tipoRobot="semaforoActividad"')->result()[0]->estaFuncionando;

	   //--------------------------
		//[TIC Consultores Miguel Avila 2020-27-05]
		$this->datos["modulos"]=$this->personamodelo->getTreedb();
		$this->datos["acciones"]=$this->personamodelo->getTableNombre('modulo_acciones');
		$this->datos["puestos"]=$this->getPuestos();
		$this->load->view('permisosOperativos/permisosActividades',$this->datos);
	}
	function index(){
				if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
    	$this->datos['actividades'] = $this->actividades_model->TablaActividades();
		$this->datos['ramos']=$this->catalogos_model->get_Ramos();
		$this->datos['subramos'] = $this->catalogos_model->get_SubRamos(); //Agregado [Suemy][2024-07-23]
		$this->datos['promotorias'] = $this->catalogos_model->get_Promotorias(); //Agregado [Suemy][2024-07-23]
		$this->datos['rankings']=$this->personamodelo->obtenerRankingAgente();
		$this->datos['calificacionAgente']=$this->catalogos_model->calificacionAgente();
		$this->datos['ramoPromotoria']=$this->catalogos_model->obtenerTodoRamoPromotoria();
		//$this->datos['empleados']=$this->personamodelo->obtenerEmpleados();
		//$this->datos['empleados']=$this->personamodelo->devolverColaboradoresActivos();
		$array['grupos']=1;
        $this->datos['empleados']=$this->personamodelo->devolverColaboradoresActivos($array);
  
		if(!isset($this->datos['modulosPermisosPersona'])){
		$this->datos['modulosPermisosPersona']="";}//$this->personamodelo->devolverModulosPermisos();
        $this->datos['companiasDocumentos']=$this->catalogos_model->devolverCompanias();
        $this->datos['documentosNecesarios']=$this->catalogos_model->catalogpromotoriadocumento(null);
        $this->datos['coordinadoresHijos']=$this->personamodelo->coordinadoreshijos(null);           
        $arrayASMS['idTareasProgramadas']=1;
		$this->datos['tareasProgramadasSMS']=$this->catalogos_model->tareasProgramadas($arrayASMS);
		//--------------------------
		//[Dennis 2020-10-05]
		$this->datos["personalSuperior"]=$this->personamodelo->devuelveCoordinadoresVentas();
		$this->datos["ramoPoliza"]=$this->personamodelo->devuelveRamo();
		$this->datos["coorAsignados"]=$this->personamodelo->devuelveCoorMetaComercial();
		$this->datos["coorAsignadosIT"]=$this->personamodelo->devuelveCoorMetaComercialIngresoTotal(); //Dennis 2021-05-07
		//-------------------------
		//[Dennis 2021-07-12]
		$this->datos["cierresMensuales"] = $this->metacomercial_modelo->devuelveCierreComercial();
		$this->datos["mesComercialActivado"] = $this->metacomercial_modelo->devuelveActivacionComercial();
		//-------------------------
       	$this->datos['causaRaiz']=$this->procesamientoncmodel->causaraiz(null);
	$this->datos['accionCorrectiva']=$this->procesamientoncmodel->accionCorrectiva(null);
	   $this->datos['estadoRobotActividades']=(string)$this->db->query('select dr.estaFuncionando from tareasrobot dr where dr.tipoRobot="semaforoActividad"')->result()[0]->estaFuncionando;
		//Cambios Edwin Marin
		$this->datos['prospeccion']=$this->personamodelo->obtenerPuntosProspeccion();
	   //--------------------------
		//[TIC Consultores Miguel Avila 2020-27-05]
		$this->datos["modulos"]=$this->personamodelo->getTreedb();
		$this->datos["acciones"]=$this->personamodelo->getTableNombre('modulo_acciones');
		$this->datos["puestos"]=$this->getPuestos();
		//------------------------
		//Dennis Castillo [2021-08-07]
		$select = "select * from guion_telefonico_modulo where activo = 1";
        $query = $this->db->query($select);
        $this->datos["modulos_guiones"] = $query->result();
        $guiones = $this->preguntamodel->obtenerGuionTelefonico(null);
        $arr_guiones = array();

        if(!empty($guiones)){
            foreach($guiones as $d_g){

                $arr_guiones[$d_g->idModulo]["modulo"] = $d_g->modulo;
                $arr_guiones[$d_g->idModulo]["guion"][$d_g->idNombre]["nombre"] = $d_g->nombre;
                $arr_guiones[$d_g->idModulo]["guion"][$d_g->idNombre]["mensajes"][] = array("etiqueta" => $d_g->etiqueta, "texto" => $d_g->mensaje);
            }
        }
		
		$this->datos["lista_guion"] = $arr_guiones;
		//------------------------- //Dennis [2021-12-07]
		$this->datos["tutorial_modules"] = $this->preguntamodel->getTutorialModules();
		$this->datos["tutorial_list"] = $this->getTutorial();
		//-------------------------

		//------------------------- //Miguel Jaime [2022-07-08]
		$this->load->model("valoracion_model");
		$this->datos["puntos"] = $this->valoracion_model->getPuntos();
		//------------------------- [Suemy][2024-03-21]
		$this->datos['reportes'] = $this->PermisoOperativo->getReports("");
		$this->datos['reportes_asignados'] = $this->PermisoOperativo->getConfiguracionReportesDiarios(1);
		//-------------------------
         $this->datos['userEmail']=$this->tank_auth->get_usermail();
       $this->load->view('permisosOperativos/permisoCompanias',$this->datos);
     }
	}
//--------------------------------------------------------------------------
function PermisoModuloPersona(){
       
	if(isset($_POST['moduloPermisos']))
	{

		$permisos=explode(';',$_POST['moduloPermisos']);
		$eliminar['idPersona']=$_POST['idPersona'];
		$eliminar['idPersonaPermiso']=-1;
		$this->personamodelo->personapermisorelacion($eliminar);
		$permiteemision['idPersona']=$_POST['idPersona'];
		$permiteemision['delete']="";
		$this->personamodelo->permiteemision($permiteemision);
       foreach ($permisos as  $value) 
       {

       	if($value!='')
       	{
      switch ($value) {
      	case 5:
      	  $permiteemision=array(); //$permiteemision="";
      	  $permiteemision['idPersona']=$_POST['idPersona'];
		  $permiteemision['insert']="";
		  $this->personamodelo->permiteemision($permiteemision);
      		break;

      }
        $insertar['idPersona']=$_POST['idPersona'];
		$insertar['idPersonaPermiso']=$value;
		$this->personamodelo->personapermisorelacion($insertar);
      	}
       }
     	$delete='delete from instanciaswhats where idPersona='.$_POST['idPersona'];
	$this->db->query($delete);
	if($_POST['instanciaCelular']!='' && $_POST['tokenCelular']!='')
	{
	 $insertIW['idPersona']=$_POST['idPersona'];
	 $insertIW['instanciaWhats']=$_POST['instanciaCelular'];
	 $insertIW['numeroCelular']=$_POST['numeroCelular'];
	 $insertIW['tokenWhats']=$_POST['tokenCelular'];

	 $this->db->insert('instanciaswhats',$insertIW);
	}
	}

	$this->datos['modulosPermisosPersona']=$this->personamodelo->devolverModulosPermisosPersona($_POST['idPersona']);
	$consulta="select * from instanciaswhats where idPersona=".$_POST['idPersona'];

	$dat=$this->db->query($consulta)->result();
	
    $this->datos['celular']='';
    $this->datos['instancia']='';
    $this->datos['token']=''; 
    if(count($dat)>0){
    $this->datos['celular']=$dat[0]->numeroCelular;
    $this->datos['instancia']=$dat[0]->instanciaWhats;
    $this->datos['token']=$dat[0]->tokenWhats; 

    }
    $consultaSMS="select * from incidencias_sms where idPersona=".$_POST['idPersona'];

		$datSMS=$this->db->query($consultaSMS)->result();

		$this->datos['celularSMS']=''; 
    if(count($datSMS)>0){
    $this->datos['celularSMS']=$datSMS[0]->celSMS;
  }
		
	$this->datos['idPersonaPermisosModulos']=$_POST['idPersona'];

$this->datos['pestania']="divPermisosModulos";
	$this->index();	
}
//--------------------------------------------------------------------------


function guardarCambioCartera(){
	$this->load->library("webservice_sicas_soap");
	/*$this->load->library("Ws_sicas");
			$array['IDCli']=29240;
		$array['FieldInt1']=1;
		$array['FieldInt2']="0";*/
	//	$this->ws_sicas->modificarCliente($array);
    //$this->webservice_sicas_soap->SetVendedorID($_POST['IDCli'],$_POST['IDVend']);
    $this->webservice_sicas_soap->UpdateClienteForVendedor(1,$_POST['IDVend'],$_POST['IDCli']);//Numero de Paginas
	
$this->datos['pestania']="divCambioCartera";
	$this->index();
}
//--------------------------------------------------------------------------
function traerSubRamos(){
	if($_POST['idRamo']>0){
$subRamos=$this->catalogos_model->get_SubRamos($_POST['idRamo']);
$this->datos['idRamo']=$_POST['idRamo'];
$tabla='<table class="table table-style" id="tableSubRamos"><thead class="table-thead"><tr><td>SUBRAMO</td></thead></tr><tbody>';
foreach ($subRamos as $value) {
$class = ($value['activo']==0) ? 'subramoActivo' : 'subramoInActivo' ;
$tabla=$tabla.'<tr class="'.$class.'" onclick="traeCompaniasSubRamo('.$value['IDSRamo'].',this)">';
$tabla=$tabla.'<td>'.$value['nombre'].'</td>';
//$tabla=$tabla.'<td><button onclick=asignarCompaniaRamo('.$value['IDSRamo'].')>Guardar</button></td>';
$tabla=$tabla.'</tr>';
}
$tabla=$tabla.'</tbody></table>';
$companias=$this->catalogos_model->devolverCompanias();
$check="";
$tabla2 = '<table class="table table-hover table-style"><thead class="table-thead" style="z-index: 1;"><tr><td>COMPAÑÍAS</td></tr></thead><tbody id="divCompanias">';
foreach ($companias as  $value) {
	$check=$check.'<tr><td><div class="checkbox column-flex-center"><label><input type="checkbox" class="form-check-input checkbox-item check-input checkCompanias" value="'.$value->idPromotoria.'" style="margin-top: 0px;"></label><label class="textLabel" style="padding: 0px 5px;">'.$value->Promotoria.'</label></div></td></tr>';
}
$tabla2.=$check.'</tbody></table>';
$this->datos['subRamos']=$tabla;
$this->datos['companias']=$tabla2;
}
$this->datos['pestania']="divSubRamoCompania";
	$this->index();
}
//-------------------------------------------------------------------------------
public function asignarCompaniaRamo(){
	if($_POST['idSubRamo']!=""){
	$companias=explode(";",$_POST['companias']);
	$this->catalogos_model->borrarRelacionRP($_POST['idSubRamo']);
	foreach ($companias as $value) {
		if($value!=""){
            $insertar['idSubRamo']=$_POST['idSubRamo'];    
            $insertar['idPromotoria']=$value;
            $this->catalogos_model->insertarRelacionRP($insertar);
		}
	}
   }
	echo json_encode("");

}
//---------------------------------------------------------------------------------
public function devolverCompaniasAsignadas(){
	$companias=$this->catalogos_model->devolverCompaniasAsignadas($_POST['idSubRamo']);	
echo json_encode($companias);
}
//---------------------------------------------------------------------------------
public function guardarPermitidoPorRanking(){

	
	 $cantidad=(int)$_POST['numeroPermitido'];
  if($_POST['ranking']!="" ){  
   if($cantidad>0){$this->catalogos_model->actualizarCantidadCompaniasRanking($_POST['ranking'],$_POST['numeroPermitido']);}
  }
    $this->datos['pestania']='divRanking';
 	$this->index();
}
//---------------------------------------------------------------------------------
public function guardarPuntaje(){

//Cambios Edwin Marin	
	 $cantidad=(int)$_POST['numeroOtorgado'];
  if($_POST['prospeccion']!="" ){  
   if($cantidad>0){$this->catalogos_model->actualizarPuntosProspeccion($_POST['prospeccion'],$_POST['numeroOtorgado']);}
  }
    $this->datos['pestania']='divPuntajeProspeccion';
 	$this->index();
}
//---------------------------------------------------------------------------------
public function guardarCalificacion(){
	//$_POST['idCalificacionAgente']=1;
	$this->catalogos_model->guardarCalificacion($_POST);
	$this->datos['pestania']="divCalificacionAgente";	
	$this->index();
  //redirect('/permisosOperativos');
}
//---------------------------------------------------------------------------------
public function guardarRamoPromotoria(){
	$idRamoPromotoria=$_POST['idRamoPromotoria'];
	unset($_POST['idRamoPromotoria']);
	foreach ($_POST as $key => $value) {
		$update=null;
		$update[$key]=$value;
		$update['idRamoPromotoria']=$idRamoPromotoria;
		$update['operacion']=1;
		$this->catalogos_model->ramoPromotoria($update);
	}
   $this->datos['pestania']='divCompaniaHoras';
 $this->index();
}
//---------------------------------------------------------------------------------
function asignaResponsableRamo(){
     $datos=$this->personamodelo->obtenerDatosUsers($_POST['idPersona']);
     $update['idPersona']=$_POST['idPersona'];
     $update['emailResponsable']=$datos->email;
     $update['IDRamo']=$_POST['IDRamo'];
     $update['operacion']=1;
     $respuesta=$this->catalogos_model->catalog_ramos($update);


	   $this->datos['pestania']='divResponsableEmision';
 $this->index();
}

//---------------------------------------------------------------------------------
function agregarDocumentoNecesario()
{
  $array['idCatalogPromotoriaDocumento']=-1;	
  $array['documento']=$_POST['Documento'];
  $respuesta['documento']=$this->catalogos_model->catalogpromotoriadocumento($array)[0];
  echo json_encode($respuesta);
   
}

//---------------------------------------------------------------------------------
function documentoDelCliente(){
	$array['idCatalogPromotoriaDocumento']=$_POST['id'];
	$array['personal']=$_POST['status'];
	$array['update']="";
	$respuesta['documento']=$this->catalogos_model->catalogpromotoriadocumento($array);
	$respuesta['mensaje']="Cambio realizado con exito";
	echo json_encode($respuesta);
	
}
//---------------------------------------------------------------------------------
function relaciondocumentopromotoria()
{	 
	 $datos['idPromotoria']=$_POST['idPromotoria'];
	 $datos['idCatalogPromotoriaDocumento']=$_POST['id'];
	 if($_POST['insertar']==1){$datos['insert']="";}
     $this->catalogos_model->relaciondocumentopromotoria($datos);
}
//---------------------------------------------------------------------------------
function traeDocumentoDePromotoria()
{ 
 $consulta['idPromotoria']=$_POST['idPromotoria'];
 $respuesta['documentoPromotorias']=$this->catalogos_model->seleccionaDocumentPorPromotoria($consulta);
 echo json_encode($respuesta);   
}
//---------------------------------------------------------------------------------
function guardarTareaEnvioMensajes()
{
	
	$respuesta['mensaje']="Actualizacion correcta";
	$update['mensaje']=$_POST['mensage'];
	$update['activo']=$_POST['activado'];
	$update['dias']=$_POST['diasAntesVencimiento'];
	$update['tipoFecha']=$_POST['tipoFecha'];
	$update['idTareasProgramadas']=1;
	$update['update']='';
	$this->catalogos_model->tareasProgramadas($update);
	echo json_encode($respuesta);
}
//---------------------------------------------------------------------------------
function obtenerNumeroEmpresa(){
	$idPersona= $_POST['idPersona'];
	$respuesta= $this->personamodelo->devolvercelOficina($idPersona);
	echo json_encode($respuesta);

}

function guardarNumeroSMS(){
	$insert['idPersona']=$_POST['idPersona'];
	$insert['celSMS']=$_POST['numero'];
	$respuesta=$this->incidencias_model->insertCelSMS($insert,$_POST['idPersona']);
}
//---------------------------------------------------------------------------------
function guardarAsignacionParaCoordinadores()
{
	$respuesta['mensaje']='Los cambios se guardaron con exito';
	if($_POST['idPersonaCoordinador']!='-1')
	{
	$array['idPersonaCoordinador']=$_POST['idPersonaCoordinador'];
	$array['delete']='';
	$this->personamodelo->coordinadoreshijos($array);

	$idPersonaHijo=explode(',', $_POST['idPersonaHijo']);
    foreach ($idPersonaHijo as  $value) {
    	if($value!='')
    	{   $array=null;
        	$array['idPersonaCoordinador']=$_POST['idPersonaCoordinador'];
	        $array['idPersonaHijo']=$value;
	        $this->personamodelo->coordinadoreshijos($array);

    	}
    }
    }
    else
    {
    	$respuesta['mensaje']='Los cambios se guardaron con exito';
    }
    $array=null;
	$array['idPersonaCoordinador']=$_POST['idPersonaCoordinador'];
	$hijos=$this->personamodelo->coordinadoreshijos($array);
	  	   
	$hijosId="";

	$respuesta['idPersonaCoordinador']=$_POST['idPersonaCoordinador'];
	foreach ($hijos as $value) {$hijosId.=$value->idPersonaHijo.' ';}
	$respuesta['hijosId']=$hijosId;	
	echo json_encode($respuesta);
}
//--------------------------------------------------------
//Módulo realizado por Dennis Castillo.
//Instrucción para almacenar en la base de datos
function guardarMetasComerciales() {
	if(!empty($_POST['metaAnio'])) {
		//En caso de que sea anual.
		if($_POST['tipo']=='metaCA') {
			$idPersona=$_POST['coordinador'];
			$meta=$_POST['metaAnio'];
			#$anioMeta=$_POST['anio'];
			$tipo=$_POST['tipo'];
			$this->personamodelo->insertaMetaComercial($idPersona,$meta,$tipo);
			}
		header("Location:".base_url()."miInfo" );}
	else{header("Location:".base_url()."permisosOperativos" );}
}

//-------------------------------------------------------- Dennis 202-05-07
function almacenaMetaComercial(){
	
	

	$datosUsuario=$this->personamodelo->devuelveInfoUser($_GET["q"]);
	//echo json_encode($datosUsuario);

	$existencia=$this->metacomercial_modelo->devuelveInfoMC($_GET["a"]);

	$validador=array();

	foreach($existencia as $value){
		array_push($validador,$value->idPersona);
	}

	$insertaMeta=array();

	$proceso=array();

	

	foreach($datosUsuario as $valor){
		$insertaMeta=array(
			"fechaCreacion"=>date("Y-m-d"),
			"idPersona"=>$_GET["q"],
			"idUser"=>$valor->id,
			"IdVend"=>$valor->IDVendNS,
			"email"=>$valor->email,
			"mes"=>date("n"),
			"tipoDeMeta"=>"anual",
			"anio"=>date("Y"),
			"montoDeMetaComercial"=>$_GET["r"]
		);

		if($_GET["p"]>0){

			$update=$this->personamodelo->actualizaMeta($insertaMeta,$_GET["p"],$_GET["a"]);
			
			
			if($update){
				$montosMensuales=$this->metacomercial_modelo->obtenerMensualidadesDeMeta($_GET["p"],$_GET["q"],$_GET["a"]);

				
				echo json_encode($montosMensuales);
			}

			//array_push($proceso,$montosMensuales);
		} else{

			if(!in_array($_GET["q"],$validador)){

				$relacion=array();

				$insert=$this->personamodelo->insertaMeta($insertaMeta,$_GET["a"]);

				$relacion["idPersona"]=$_GET["q"];
				$relacion["id_referencia"]=$insert;
				$relacion["referencia"]= $_GET["a"] == 1 ? "venta_nueva" : "ingreso_total";
				$relacion["anio"]=date("Y");

				$insert_enlace=$this->metacomercial_modelo->generaRelacionUsuarioMeta($relacion);
				
				array_push($proceso,$insert);
			} else{

				$proceso=array();
			}
			
			echo json_encode($proceso);
		}
	}

}
//-------------------------------------------------------- Dennis 202-05-07
function almacenaMontosMensuales(){

	//echo $_GET["r"];

	$mensualidad=json_decode($_GET["r"]);
	
	$prueba=array();

	foreach($mensualidad as $key=>$valor){
		if($valor!=""){

			$valida_existencia=$this->personamodelo->regresaMontodelMes($key,$_GET["p"],$_GET["a"]);

			$montoMES=array(
				"mes_num"=>$key,
				"monto_al_mes"=>$valor,
				"idMetaComercial"=>$_GET["q"],
				"anio"=>date("Y")
			);

			if($_GET["p"]>0 && !empty($valida_existencia)){

				$montoMESAct=array(
					"mes_num"=>$key,
					"monto_al_mes"=>$valor,
					"idMetaComercial"=>$_GET["q"],
					"anio"=>date("Y")
				);

				array_push($prueba,$montoMESAct);

				$resultado=$this->personamodelo->actualizaMontosMensuales($montoMESAct,$_GET["p"],$key,$_GET["a"]);
			} else{
				$resultado=$this->personamodelo->insertaMontoMensual($montoMES,$_GET["a"]);
			}
		}
	}

	
	echo $resultado;
}
//-------------------------------------------------------- Dennis 202-05-07
function eliminaMetaAsignado(){
	
	$resultado=array();
	$arreglo=array();

	if(isset($_GET["q"])){

		$resp=$this->metacomercial_modelo->eliminarRegistroDeMeta($_GET["q"], date("Y"),$_GET["r"]);
		$arreglo["proceso"]=$resp;

		if($resp){
			$arreglo["mensaje"]="Resistro eliminado con exito";
			
		} else{
			$arreglo["mensaje"]="No se logró eliminar la meta seleccionada";
		}

	}

	if(empty($_GET["q"])){

		$arreglo["mensaje"]="Hubo un problema el la operación, intente más tarde";

	}

	array_push($resultado,$arreglo);

	echo json_encode($resultado);
}
//--------------------------------------------------------
function inserta_meta_por_ramo(){


	try{
		$datos_ramos=json_decode($_REQUEST["send"]);

		$prueba=array();

		foreach($datos_ramos as $key=>$valor){
			foreach($valor  as $mes=>$ramos){
				foreach($ramos  as $nombre=>$montos){
						
					$insert=array();

					$insert["idPersona"]=$key;
					$insert["mes_asignado"]=$mes;
					$insert["ramo"]=$nombre;
					$insert["cantidad_polizas"]=(!empty($montos->cantidad_polizas)) ? $montos->cantidad_polizas : 0;
					$insert["prima_polizas"]=(!empty($montos->prima)) ? $montos->prima : 0;
					$insert["anio"]=date("Y");

					$valida_existencia=$this->metacomercial_modelo->validaExitenciaRamo($insert,"id_meta_ramo","registro_meta_mensual_ramo_coordinador_generico");
					//array_push($prueba, $insert);
					if(empty($valida_existencia)){
						$inserccion=$this->metacomercial_modelo->inserta_metas($insert);

						/*if($nombre == "autos" || $nombre == "gmm"){ //Dennis [2021-06-02]
							$this->gestionaMetaPorRamoAAgente($key,$mes,$nombre,0);
						}*/
						
						if($inserccion){
							$prueba["mensaje"]="Asignación completada";
						} else{
							$prueba["mensaje"]="No se guardó la información, contacté al departamento de sistemas";
						}
					}
					
				}
			}

		}

	} catch(Exception $e){

		echo 'Excepción capturada: ',  $e->getMessage(), "\n";
		
	}

	
	echo json_encode($prueba);
}
//--------------------------------------------------------
function obtenerAgentesYRamos(){ //Modificación: 31-05-2023

	//echo json_encode($_GET["q"]);

	//realización de consulta a la db.

	$consulta=$this->metacomercial_modelo->obtenerPolizas($_GET["r"], $_GET["q"]);

	$resultado=array();

	

	if(!empty($consulta)){
		$resultado["mensaje"]="";
		
		$data_info=array();

		foreach($consulta as $valores){

			$resultado[$valores->idPersona]["Nombre"]=$valores->nombres." ".$valores->apellidoPaterno." ".$valores->apellidoMaterno;
			$resultado[$valores->idPersona]["Correo"]=$valores->email;
			$resultado[$valores->idPersona]["Mes"]=$valores->mes_asignado;
			$resultado[$valores->idPersona]["Polizas"][$valores->ramo]=number_format($valores->resultado1);
			$resultado[$valores->idPersona]["Primas"][$valores->ramo]=number_format($valores->resultado2);
		}

	} else{
		$resultado["mensaje"]="No se encontraron resultados";
	}



	echo json_encode($resultado);
}

//--------------------------------------------------------
function eliminarRegistroRamo(){

	$resultado=array();

	$eliminar=$this->metacomercial_modelo->eliminarInformacionRamo($_GET["q"],$_GET["r"]);

	if($eliminar){
		//eliminarRegistrosAgentesAsignados
		$this->metacomercial_modelo->eliminarRegistrosAgentesAsignados($_GET["q"],$_GET["r"]);
	}

	if($eliminar){
		$resultado["mensaje"]="Registro eliminado con éxito.";
	} else{
		$resultado["mensaje"]="Hubo un detalle con la eliminación, favor de contactar al departamento de sistemas.";
	}

	echo json_encode($resultado);
}
//--------------------------------------------------------
function actualizarRegistroRamo(){

	$js_post=json_decode($_REQUEST["send"]);

	$success_update=array();
	$resultado=array();

	foreach($js_post as $id=>$datos){
		foreach($datos->ramos as $ramo=>$valor){

			$data_update=array();
			$data_update["mes_asignado"]=$datos->mes_act;
			$data_update[$datos->tipo_act]=(!empty($valor)) ? $valor: 0;

			$update=$this->metacomercial_modelo->actualizarMetaDeRamo($id,$datos->mes_ant,$ramo,$data_update);
			array_push($success_update,$update);

			/*if($ramo == "autos" || $ramo == "gmm"){ //Dennis [2021-06-02]

				$this->gestionaMetaPorRamoAAgente($id,$datos->mes_act,$ramo,1);
			}*/
		}
		//
	}

	if(in_array(false, $success_update)){
		$resultado["mensaje"]="Hubo un detalle en la actualización del registro, intente más tarde.";
		$resultado["bool"]=false;

	} else{
		$resultado["mensaje"]="Registro modificado con éxito.";
		$resultado["bool"]=true;
	}


	echo json_encode($resultado);

}
//--------------------------------------------------------
function consultaAvanceSicasCoor(){

	$coor=$_GET["q"];

	//echo json_encode($coor);
	$this->load->library("ws_sicas");

	$contenedor_agentes=array();
	$json_respuesta=array();

	$prueba=0;

	$f_i="";
	$f_f="";

	$agentes=$this->personamodelo->devuelveAgentesPorCoordinadorActivos($coor);
	//$agentes=$this->metacomercial_modelo->obtenerAsignadosMetasRamo($coor, null);

	foreach($agentes as $val){

		array_push($contenedor_agentes,$val->IDVend);
		//array_push($contenedor_agentes,$val->idVend);
	}

	//$_f_i=new DateTime();
	$f_i=date("d-m-Y", mktime(0,0,0,$_GET["r"],1,date("Y")));

	if($_GET["r"]<date("m") || $_GET["r"]>date("m")){ // 

		$f_f=date("d-m-Y", mktime(0,0,0,$_GET["r"]+1,0,date("Y")));

	}
	else{
		
		$f_f=date("d-m-Y");
	}

	if(!empty($agentes)){

		$requestSicas=$this->ws_sicas->consultaAvanceSicas($coor,array_values(array_unique($contenedor_agentes)),$f_i,$f_f,null); //Solicitud a Sicas

		if(array_key_exists("TableInfo", $requestSicas)){

			$json_respuesta["mensaje"]="";
	
			$incremental_autos=0;
			$incremental_vida=0;
			$incremental_danios=0;
			$incremental_gmm=0;
			$incremental_fianzas=0;
	
			foreach($requestSicas->TableInfo as $res_data){
				
				if((Int)$res_data->Renovacion==0 && (Int)$res_data->Periodo==1){

					$prueba+=(Float)$res_data->ImporteP;

					switch((String)$res_data->Ramo){
	
						case "Accidentes y Enfermedades": ($_GET["p"]==2) ? $incremental_gmm+=(Float)$res_data->PrimaNeta : $incremental_gmm++; //array_push($prueba, (Float)$res_data->PrimaNeta);
							break;
						case "Vehiculos": ($_GET["p"]==2) ? $incremental_autos+=(Float)$res_data->PrimaNeta : $incremental_autos++;
							break;
						case "Vida": ($_GET["p"]==2) ? $incremental_vida+=(Float)$res_data->PrimaNeta : $incremental_vida++;
							break;
						case "Daños": ($_GET["p"]==2) ? $incremental_danios+=(Float)$res_data->PrimaNeta : $incremental_danios++;
							break;
						case "Fianzas": ($_GET["p"]==2) ? $incremental_fianzas+=(Float)$res_data->PrimaNeta : $incremental_fianzas++;
							break;
					}
				}
			}
	
			

			if($coor==805){
				$json_respuesta["resultado"][($_GET["p"]==2) ? "prima_polizas" : "cantidad_polizas"]["fianzas"]=$incremental_fianzas;
			} else{
				$json_respuesta["resultado"][($_GET["p"]==2) ? "prima_polizas" : "cantidad_polizas"]["autos"]=$incremental_autos;
				$json_respuesta["resultado"][($_GET["p"]==2) ? "prima_polizas" : "cantidad_polizas"]["vida"]=$incremental_vida;
				$json_respuesta["resultado"][($_GET["p"]==2) ? "prima_polizas" : "cantidad_polizas"]["danios"]=$incremental_danios;
				$json_respuesta["resultado"][($_GET["p"]==2) ? "prima_polizas" : "cantidad_polizas"]["gmm"]=$incremental_gmm;
			}
	
		} else{
			$json_respuesta["mensaje"]="No se encontraron resultados del mes seleccionado y coordinador";
		}

	} else{
		$json_respuesta["mensaje"]="No hay agentes asignados para esta cuenta.";
	}
	
	

	echo json_encode($json_respuesta);
}
//--------------------------------------------------------
function pararRobot()
{
  $respuesta['mensaje']='Cambios guardados con exito';
  $eliminaEspacios=trim($_POST['comentario']);
  if($eliminaEspacios=='' and $_POST['estaFuncionando']==0)
  {
   $respuesta['mensaje']='Necesita agregar un comentario'; 
  }
  else
  {
  	$respuesta['mensaje']='El robot de semaforo de actividades esta en funcionamiento';
  	if($_POST['estaFuncionando']==0){$respuesta['mensaje']='El robot de semaforo de actvidades se ha apagado. Se iniciara automaticamente despues de las 18:00 horas';}
     $actualizar['estaFuncionando']=$_POST['estaFuncionando'];
     $this->db->where('tipoRobot',$_POST['tipoRobot']);
     $this->db->update('tareasrobot',$actualizar);
     if($_POST['estaFuncionando']==0)
     {
     	$insert['tipoRobot']=$_POST['tipoRobot'];
     	$insert['comentario']=$_POST['comentario'];
     	$insert['user']=$this->tank_auth->get_usermail();
     	$this->db->insert('tareasrobotmotivodetener',$insert);

     }
  }
  //
  echo json_encode($respuesta);
}
//--------------------------------------------------------
function agregarDiaInhabil()
{
	if(isset($_POST['diaNoLaboral']))
	{
	 if(isset($_POST['delete']))
	 {
       $this->db->where('diaNoLaboral',$_POST['diaNoLaboral']);
       $this->db->delete('dianolaboral');
	 }
	 else{
	 $respuesta['mensaje']='Dia guardado como no laboral';
	 if($_POST['diaNoLaboral']==''){$respuesta['mensaje']='Necesitas escoger un dia';}
	 else
	 {
      $insert['diaNoLaboral']=$_POST['diaNoLaboral'];
      $this->db->insert('dianolaboral',$insert);
	 }
	 }
    }
    $consulta='select distinct(diaNoLaboral) from dianolaboral order by diaNoLaboral desc';
    $respuesta['diaNoLaboral']=$this->db->query($consulta)->result();
    
	echo json_encode($respuesta);
	
}

//-------------------------------------------------------- Dennis 202-05-07
function devuelveMetasMensuales(){

	$idMeta = $_GET["q"];
	$idPersona = $_GET["r"];
	$bandera = $_GET["a"];

	$metasMensuales = $this->metacomercial_modelo->obtenerMensualidadesDeMeta($idMeta,$idPersona,$bandera);
	$metaAnual = $this->metacomercial_modelo->obtenerMetaAnualPorId($idPersona,$bandera);
	$account = $this->personamodelo->obtenerDatosUsuarios($idPersona,'email');
	$agentes = $this->personamodelo->obtenerPersonas($account->email, 3);
	$totalAgentes = array_reduce($agentes, function($acc, $curr){

		if(array_key_exists($curr->ranking, $acc)){
			$acc[$curr->ranking] ++;
		} else{
			$acc[$curr->ranking] = 1;
		}

		return $acc;
	}, array());

	$array_mensual=array();
	$array_datos= array();
	if(!empty($metasMensuales)){

		$array_datos["mensaje"]="";
		foreach($metasMensuales as $datos){

			$array_datos["idMeta"]=$datos->idMetaComercial;
			$array_datos["metaTotal"]=$metaAnual->montoDeMetaComercial;
			$array_mensual[$datos->mes_num]=$datos->monto_al_mes;
		}

		$array_datos["mensualidades"]=$array_mensual;
		$array_datos["agents"] = $totalAgentes;
	} else{
		$array_datos["mensaje"]="No se encontraron datos mensuales";
	}

	echo json_encode($array_datos);

}
//-------------------------------------------------------- Dennis 202-05-07
function actualizaMetaMensual(){

	$datos_json = json_decode($_REQUEST["send"]);
	$res_json = array();

	$montoMESAct=array(
		"mes_num"=>$datos_json->mes,
		"monto_al_mes"=>$datos_json->monto,
		"idMetaComercial"=>$datos_json->idMeta,
		"anio"=>date("Y")
	);

	$update=$this->personamodelo->actualizaMontosMensuales($montoMESAct,$datos_json->idMeta,$datos_json->mes,$datos_json->bandera);
	//echo json_encode($datos_json->idMeta);

	$res_json["mensaje"] = $update == true ? "" : "No se realizó el cambio";
	$res_json["bool"] = $update;

	echo json_encode($res_json);

}

//-------------------------------------------------------- Tic Consultores 2021-05-27
public function getPuestos(){
	$data = $this->capitalhumano_model->devolverPuestos(1);
	$fullA=array();
	//estructura que se necesita el select especifico
	foreach ($data as $key => $value) {
		$algo=array(
			"label"=>$key,
			"options"=>array()
		);
		foreach ($value as  $valuePP) {
			array_push($algo["options"],array("value"=>$valuePP->idPuesto,"label"=>$valuePP->personaPuesto));
		}
		array_push($fullA,$algo);
		
	}
	$otro=array(
		"label"=>"Sin puesto",
		"options"=>array(
			array(
				"value"=>"98",
				"label"=>"MOVER DE PUESTO PUESTO",
			),
			array(
				"value"=>"0",
				"label"=>"NO COLABORADOR",
			)
		)
	);
	array_push($fullA,$otro);
	sort($fullA);
	return $fullA;
}
//-------------------------------------------------------- Dennis [2021-06-02]
function gestionaMetaPorRamoAAgente($id,$mes,$ramo,$update){

	$array_select["idPersona"] = $id;
	$array_select["mes_asignado"] = $mes;
	$array_select["ramo"] = $ramo;

	$contador_autos = 0;
	$contador_gmm = 0;

	$prima_segmentada = 0;
	$prima_de_ramo = 0;

	$metas_por_ramo = $this->metacomercial_modelo->validaExitenciaRamo($array_select,"*","registro_meta_mensual_ramo_coordinador_generico");
	$agentes_del_coordinador = $this->personamodelo->devuelveAgentesPorCoordinadorActivos($id);
	
	$ranking_valido = array("BRONCE", "ORO", "PLATINO");

	foreach($agentes_del_coordinador as $dd){ //gestion de agentes en autos y gmm

		if(in_array($dd->idpersonarankingagente, $ranking_valido)){
			
			$contador_autos++;
			//var_dump($dd);
		}
		
		if($dd->idpersonarankingagente == "ORO" || $dd->idpersonarankingagente == "PLATINO"){
			$contador_gmm++;
		}
	}

	if(!empty($metas_por_ramo)){ //Obtencion de la prima total del mes.

		foreach($metas_por_ramo as $aa){

			$prima_de_ramo = $aa->prima_polizas;
		}
	}

	switch($ramo){
		case "autos": $prima_segmentada = $prima_de_ramo > 0 ? $prima_de_ramo/$contador_autos : 0;
			break;
		case "gmm": $prima_segmentada = $prima_de_ramo > 0 ? $prima_de_ramo/$contador_gmm : 0;
			break;
	}

	$response = array();

	foreach($agentes_del_coordinador as $dd){

		$array_insert = array();
		//$array_response = array();

		$array_insert["idPersona"] = $dd->idPersona;
		$array_insert["mes_asignado"] = $mes;
		//$array_insert["ramo"] = $ramo;
		$array_insert["cantidad_polizas"] = 1;
		$array_insert["prima_polizas"] = $prima_segmentada;
		$array_insert["anio"] = date("Y");
		$array_insert["idCoor"] = $id;
		$array_insert["asignacion"] = "dinamico";
		$array_insert["reciente"] = 1;


		if(in_array($dd->idpersonarankingagente, $ranking_valido) && $ramo == "autos"){
			
			$array_insert["ramo"] = "autos";

			switch($update){
				case 0: $rr = $this->metacomercial_modelo->insertaMetaRamoAgente($array_insert);
				break;
				case 1: $rr = $this->metacomercial_modelo->actualizaMetaRamoAgente($array_insert,$array_insert);
				break; 
			}
			//$this->metacomercial_modelo->insertaMetaRamoAgente($array_insert);
			array_push($response, array(
				"idPersona" => $dd->idPersona,
				"nombre_completo" => $dd->nombres." ".$dd->apellidoPaterno." ".$dd->apellidoMaterno,
				"correo" => $dd->email,
				"ranking" => $dd->idpersonarankingagente,
				"ramo" => $ramo,
				"insert" => $rr
			));
		}
		
		if(($dd->idpersonarankingagente == "ORO" || $dd->idpersonarankingagente == "PLATINO") && $ramo == "gmm"){
			
			$array_insert["ramo"] = "gmm";

			switch($update){
				case 0: $rr2 = $this->metacomercial_modelo->insertaMetaRamoAgente($array_insert);
				break;
				case 1: $rr2 = $this->metacomercial_modelo->actualizaMetaRamoAgente($array_insert,$array_insert);
				break; 
			}
			//$this->metacomercial_modelo->insertaMetaRamoAgente($array_insert);
			array_push($response, array(
				"idPersona" => $dd->idPersona,
				"nombre_completo" => $dd->nombres." ".$dd->apellidoPaterno." ".$dd->apellidoMaterno,
				"correo" => $dd->email,
				"ranking" => $dd->idpersonarankingagente,
				"ramo" => $ramo,
				"insert" => $rr2
			));
		}
	}

	return $response; 
	//var_dump($metas_por_ramo);
	//var_dump($contador_gmm	);
	//var_dump($prima_segmentada);
	//var_dump($agentes_del_coordinador);
}
//--------------------------------------------------------
function asignaMetaAgenteAutomatico(){

	$json_decode = json_decode($_POST["sendData"]);
	$resultado = array();
	

	foreach($json_decode->ramos as $d_r){

		$res = $this->gestionaMetaPorRamoAAgente($json_decode->id,$json_decode->mes,$d_r->ramo,0);
		
		array_push($resultado, $res);
	}

		/*if($nombre == "autos" || $nombre == "gmm"){ //Dennis [2021-06-02]
							$this->gestionaMetaPorRamoAAgente($key,$mes,$nombre,0);
						}*/

	echo json_encode($resultado);
}
//--------------------------------------------------------
function almacenaACtivacionComercial(){
	
	
	date_default_timezone_set('America/Mexico_City');
	$insert = $this->metacomercial_modelo->activacion_consulta_comercial(array(
		"fecha_activacion" => date("Y-m-d H:i:s"),
		"mes_activado" => $_POST["q"],
		"anio" => $_POST["r"],
		"cuenta_cierre" => $this->tank_auth->get_username(),
		"cierre" => $_POST["p"] == 1 ? true : false
	));

	return $insert;
}//------------------------ Dennis [2021-08-05]
function registraGuionTelefonico(){

	$json_object = json_decode($_REQUEST["sendData"]);     

	if(!empty($json_object->mensajes)){

		if($json_object->actualiza_modulo > 0 && $json_object->actualiza_guion > 0){

			$delete = $this->preguntamodel->eliminaRegistroDeGuion($json_object->actualiza_guion);

		}

		$insert_guion = $this->metacomercial_modelo->insertaRegistro(
			array(
				"nombre" => $json_object->nombreGuion
			),"guion_telefonico_nombre_guion"
		);

		foreach($json_object->mensajes as $d_m){

			$insert_mensaje = $this->metacomercial_modelo->insertaRegistro(
				array(
					"mensaje" => $d_m->mensaje,
					"etiqueta" => $d_m->etiqueta,
					"idNombre" => $insert_guion
				),"guion_telefonico_mensaje"
			);

		}

		$insert_relacion = $this->metacomercial_modelo->insertaRegistro(
			array(
				"idModulo" => $json_object->modulo,
				"idNombre" => $insert_guion
			),"guion_telefonico_relacion_modulo_nombre"
		);
	}

	echo json_encode($json_object->nombreGuion);
}
//--------------------- Dennis [2021-08-05]
function eliminaRegistroDeGuion(){

	$deleteGuion = $this->preguntamodel->eliminaRegistroDeGuion($_GET["q"]);

	echo json_encode(array("bool" => $deleteGuion));
}
//--------------------- Dennis [2021-08-05]
function devuelveDatosGuion(){

	$guion = $this->preguntamodel->obtenerDatosDelGuion($_GET["q"], $_GET["r"]);
	$response = array();

	if(!empty($guion)){
		foreach($guion as $d_g){

			$response["idModulo"] = $d_g->idModulo;
			$response["idNombre"] = $d_g->idNombre;
			$response["nombre"] = $d_g->nombre;
			$response["mensaje"][] = array("etiqueta" => $d_g->etiqueta, "texto" => $d_g->mensaje);
		}
	}

	echo json_encode($response);
}
//-------------------------------- Dennis [2021-12-07]
function registerTutorial(){
	
	$module = $_POST["moduleId"];
	$name = $_POST["name"];
	$filename = $_POST["file"];
	$idTutorial = $_POST["idTutorial"];
	$description = $_POST["description"];
	//Insert in table
	$extension = "";
	$file_ = explode(".", $filename);

	foreach($file_ as $d_f){
		if($d_f === end($file_)){
			$extension = $d_f;
		}
	}

	$response = array();

	if($idTutorial > 0){
		$updateTutorial = $this->preguntamodel->updateSafely(array(
			"name" => $name,
			"description" => $description,
			"nameDoc" => $filename, 
			"format" => $extension, 
			"dateUpdate" => date("Y-m-d H:i:s"), 
		), "tutorial_videos", $idTutorial);
	
		$updateRelation = $this->preguntamodel->updateSafely(array(
			"idModule" => $module, 
			"idTutorial" => $idTutorial,
		), "tutorial_module_relationship", $idTutorial);

		$response["lastId"] = $idTutorial;
		$response["status"] = $updateTutorial["status"];
		$response["type"] = "update";

	} else{
		$insertTutorial = $this->preguntamodel->insertSafely(array(
			"name" => $name,
			"description" => $description,
			"nameDoc" => $filename, 
			"format" => $extension, 
			"dateCreation" => date("Y-m-d H:i:s"), 
		), "tutorial_videos");
	
		$insertRelation = $this->preguntamodel->insertSafely(array(
			"idModule" => $module, 
			"idTutorial" => $insertTutorial["lastId"],
		), "tutorial_module_relationship");

		$response["lastId"] = $insertTutorial["lastId"];
		$response["status"] = $insertRelation["status"];
		$response["type"] = "creat";
	}

	$tutorialData = $this->preguntamodel->getTutorial($response["lastId"]);
	if(!empty($tutorialData)){
		$response["dateUpload"] = $idTutorial > 0 ? date("d-m-Y", strtotime($tutorialData->dateUpdate)) : date("d-m-Y", strtotime($tutorialData->dateCreation));
	} else{
		$response["dateUpload"] = "Sin fecha";
	}
	echo json_encode($response);
}
//---------------------------------- Dennis [2021-12-07]
function deleteTutorialRegister(){

	$register = $_POST["register"];
	$result = $this->preguntamodel->deleteSafely($register);
	
	echo json_encode(array("result" => $result));
}
//--------------------------------- Dennis [2021-12-07]
function getTutorial(){
	$tutoriales = $this->preguntamodel->getTutorialList();
	$arr_tutorial = array();

	if(!empty($tutoriales)){
		foreach($tutoriales as $d_t){

			$arr_tutorial[$d_t->idModulo]["modulo"] = $d_t->modulo;
			$arr_tutorial[$d_t->idModulo]["tutorial"][] = $d_t;

		}
	}

	return $arr_tutorial;
}
//------------------------------ Dennis [2021-12-07]
function getTutorialForUpdate(){
	//$tutorial = $_GET["idRegister"];
	echo json_encode($this->preguntamodel->getTutorialList());
}
//---------------------------------- Dennis [2021-12-22]

function assignNewSalesGoal(){

	$idPersona = $_POST["id"];
	$array_batch = array();
	$metaAnual = $this->metacomercial_modelo->obtenerMetaAnualPorId($idPersona,1);
	$metasMensuales = $this->metacomercial_modelo->obtenerMensualidadesDeMeta($metaAnual->idMetaComercial, $idPersona, 1);
	$account = $this->personamodelo->obtenerDatosUsuarios($idPersona,'email');
	$agentes = $this->personamodelo->obtenerPersonas($account->email, 3);
	$totalAgentes = array_reduce($agentes, function($acc, $curr){
		$acc ++;
		return $acc;
	}, 0);

	$metasMensual = array_reduce($metasMensuales, function($acc, $curr) use($totalAgentes){
		$acc[] = array(
			"mes" => $curr->mes_num,
			"meta" => ($curr->monto_al_mes / $totalAgentes)
		);

		return $acc;
	}, array());

	foreach($agentes as $da){
		foreach($metasMensual as $dm){
			if($da->ranking == "ORO" || $da->ranking == "PLATINO VIP"){

				$array_batch[] = array(
					"idPersona" => $da->idPersona,
					"idVend" => $da->idVend,
					"montoMes" => $dm["meta"],
					"mes" => $dm["mes"],
					"email" => $account->email,
					"anio" => date("Y"),
					"asignacion" => "dinamico"
				);
			}
		}
	}

	$delete = $this->metacomercial_modelo->deleteAgentsGoals($account->email);

	if($delete){
		$insert_batch = $this->metacomercial_modelo->insertData($array_batch, "metasmensualesagentes");

		$response["bool"] = $insert_batch;
		$response["message"] = $insert_batch ? "Metas asignadas con éxito" : "Ocurrió un detalle al momento de asignar. Favor de contactar al depto sistemas.";
	} else{
		$response["bool"] = false;
		$response["message"] = "Ocurrió un detalle en el proceso. Favor de contactar al depto de sistemas.";
	}
	
	echo json_encode($response);
}
 //Funcion para guardar los puntos de valoracion Miguel jaime
function savePuntoValoracion(){
	$punto=$_REQUEST['punto'];
	$this->load->model("valoracion_model");
	$this->data['puntos']=$this->valoracion_model->savePuntoValoracion($punto);
	$this->load->view('permisosOperativos/puntosValoracion',$this->data);
}

function delPuntoValoracion(){
	$id=$_REQUEST['id'];
	$this->load->model("valoracion_model");
	$this->data['puntos']=$this->valoracion_model->delPuntoValoracion($id);
	$this->load->view('permisosOperativos/puntosValoracion',$this->data);
}

//--------------------------------
// Funciones de Permisos Actividades por Operativos
  	//function GetActividades() {
    	//$data['actividades'] = $this->actividades_model->TablaActividades();
    	//$data['TRamos'] = $this->actividades_model->TablaRamos();
    	//$data['TSubRamos'] = $this->actividades_model->TablaSubRamos();
    	//$this->load->view('permisosOperativos/permisoActividades',$data);
  	//}

  	function GetRamos() {
  		$id = $this->input->get('id');
  		$data = $this->actividades_model->TablaRamo($id);
  		$res = array();

  		foreach ($data as $var) {
  			$res[$var->IDRamo]['idRamo'] = $var->IDRamo;
  			$res[$var->IDRamo]['Nombre'] = $var->Nombre;
  		}
  		echo json_encode($res);
  	}

  	function GetSubRamos() {
  		$id = $this->input->get('id');
  		$data = $this->actividades_model->TablaSubRamo($id);

  		$res = array();
  		foreach ($data as $var) {
  			$res[$var->IDSRamo]['idSubRamo'] = $var->IDSRamo;
  			$res[$var->IDSRamo]['SNombre'] = $var->Nombre;
  		}
  		echo json_encode($res);
  	}

  	function GetPermisoOperativo() {
  		$email = $this->input->get('cr');

  		$correo = $this->actividades_model->PermisosOp($email,$_GET['ramo'],$_GET['actividad']);

  		$res = array();
  		$i=0;
  		foreach ($correo as $row) {
  			$res[$i]['OpActividad'] = $row->actividad;
  			$res[$i]['OpRamo'] = $row->ramo;
  			$res[$i]['OpSubRamo'] = $row->subRamo;
  			$res[$i]['correo'] = $row->email;
  			$res[$i]['area'] = $row->area;
  			$i=$i+1;

  		}
  		echo json_encode($res);
  	}

 	function ConsultarPermisos() {
  		$email = $this->input->get('cr');
  		//$active = $_GET['si'];
  		$data = $this->actividades_model->TablaPermisosGeneral('');
  
  		$respuesta = array();
  		foreach ($data as $var) {
  			/*$respuesta[$var->subRamo]['ANombre'] = $var->actividad;
  			$respuesta[$var->subRamo]['RNombre'] = $var->ramo;
  			$respuesta[$var->IDSRamo]['idSRamo'] = $var->IDSRamo;
  			$respuesta[$var->subRamo]['SRNombre'] = $var->Nombre;
  			$respuesta[$var->subRamo]['Correo'] = $var->email;*/

  			
  		}
  		//echo json_encode($respuesta);
  		echo json_encode($data);
  	}

  	/*function GuardarPermisosOperativos() {
  		$this->actividades_model->PermisosDeOperativo();
  	}*/

  	/*function ActualizarPermisoOperativo() {
  		$correo = $this->input->post('cr');
  		$actividad = $this->input->post('ac');
  		$ramo = $this->input->post('rm');
  		$subramo = $this->input->post('sr');
        $result = $this->actividades_model->CambioDePermiso($correo,$actividad,$ramo,$subramo);
  	}*/

  	function BorrarPermisoOperativo() {
  		$correo = $this->input->post('cr');
  		$actividad = $this->input->post('ac');
  		$ramo = $this->input->post('rm');
  		$subramo = $this->input->post('sr');
        $result = $this->actividades_model->BorrarPermisoActual($correo,$actividad,$ramo,$subramo);
  	}

  	function EliminarPermisosOperativo() {
  		$correo = $this->input->post('cr');
        $result = $this->actividades_model->EliminarPermisos($correo);
  	}

  	function OperacionesPermisos() {
  		if($_POST['area'] != 0) {
  		if ($_POST['in'] != 0) {
  			$agregar = $this->input->post('in');
  			$area = $this->input->post('area');
  			foreach ($area as $areavalor) {
			foreach ($agregar as $value) {
				if($value != ""){
					$insert['email'] = $this->input->post('cr');
					$insert['actividad'] = $this->input->post('ac');
    		        $insert['ramo'] = $this->input->post('rm');    
    		        $insert['subRamo'] = $value;
    		        $insert['area'] = $areavalor;
    		        $this->actividades_model->InsertPermisos($insert);
				}
			}
		}
		}
	} else{
		if ($_POST['in'] != 0) {
  			$agregar = $this->input->post('in');
			foreach ($agregar as $value) {
				if($value != ""){
					$insert['email'] = $this->input->post('cr');
					$insert['actividad'] = $this->input->post('ac');
    		        $insert['ramo'] = $this->input->post('rm');    
    		        $insert['subRamo'] = $value;
    		        $insert['area'] = null;
    		        $this->actividades_model->InsertPermisos($insert);
				}
			}
			
		}
	}

		if ($_POST['dl'] != 0) {
			$borrar = $this->input->post('dl');
			foreach ($borrar as $value) {
				if($value != ""){
					$delete['email'] = $this->input->post('cr');
					$delete['actividad'] = $this->input->post('ac');
    		        $delete['ramo'] = $this->input->post('rm');    
    		        $delete['subRamo'] = $value;
    		        $this->actividades_model->DeletePermisos($delete);
				}
			}
		}

		if ($_POST['dlarea'] != 0) {
			$borrarArea = $this->input->post('dlarea');
			foreach ($borrarArea as $value) {
				if($value != ""){
					$delete['email'] = $this->input->post('cr');
					$delete['actividad'] = $this->input->post('ac');
    		        $delete['ramo'] = $this->input->post('rm');    
    		        $delete['area'] = $value;
    		        $this->actividades_model->DeletePermisos($delete);
				}
			}
		}
  	}
//-------------------------------------------------
  	//Configuraciones: Tipo de Bajas
  	function getTipoBaja(){
      	$data = $this->personamodelo->selectTB();
      	echo json_encode($data);
    }

  	function addTipoBaja(){
        $name = $this->input->post('nm');
      	$data = $this->personamodelo->addTB($name);
      	echo json_encode($data);
    }

    function updateTipoBaja() {
    	$id = $this->input->post('id');
    	$name = $this->input->post('nm');
      	$data = $this->personamodelo->updateTB($id,$name);
      	echo json_encode($data);
    }

  	function deleteTipoBaja(){
        $id = $this->input->post('id');
      	$data = $this->personamodelo->deleteTB($id);
      	echo json_encode($data);
    }
//-------------------------------------------------
  	//Configuraciones: Tipo de Incidencias
  	function getTipoIncidencia(){
      	$data = $this->incidencias_model->selectTI();
      	echo json_encode($data);
    }

  	function addTipoIncidencia(){
        $name = $this->input->post('nm');
        $description = $this->input->post('ds');
      	$data = $this->incidencias_model->addTI($name,$description);
      	echo json_encode($data);
    }

    function updateTipoIncidencia() {
    	$id = $this->input->post('id');
    	$name = $this->input->post('nm');
        $description = $this->input->post('ds');
      	$data = $this->incidencias_model->updateTI($id,$name,$description);
      	echo json_encode($data);
    }

  	function deleteTipoIncidencia(){
        $id = $this->input->post('id');
      	$data = $this->incidencias_model->deleteTI($id);
      	echo json_encode($data);
    }
//-------------------------------------------------
function infoBD()
{   $respuesta['success']=true;
	$respuesta['procesosList']=$this->db->query('SHOW  PROCESSLIST')->result();

	echo json_encode($respuesta);
}
//-----------------------------------------------------------
function procesoMatar()
{
	$respuesta['success']=true;  
     $this->db->query('kill query '.$_POST['id']);
	echo json_encode($respuesta);
}
//-----------------------------------------------------------
function guardarPermisoCobranza()
{
	$this->db->query('delete from cobranza_responsable where tipoPermiso="'.$_POST['tipoPermiso'].'"');
	$insert['userEmail']=$_POST['userEmail'];
	$insert['tipoPermiso']=$_POST['tipoPermiso'];
	$insert['idPersona']=$_POST['idPersona'];
	$this->db->insert('cobranza_responsable',$insert);
	$respuesta['success']=true;
	echo json_encode($respuesta);
}
//-----------------------------------------------------------
	function getSearchReportEmail() { //Creado [Suemy][2024-03-21]
		$type = $this->input->get('tp');
		$sql = 'WHERE id ='.$type;
		$data['report'] = $this->PermisoOperativo->getReports($sql)[0];
		$data['result'] = $this->PermisoOperativo->getConfiguracionReportesDiarios($type);
		echo json_encode($data);
	}
//-------------------------------------------------------------------------------------------------
	//SubMódulo: Horas Compañía | Creado [Suemy][2024-07-23]
	function getTrainingHoraRamoPromotoria() {
		$id = $this->input->get('id');
		$sql = !empty($id) ? 'WHERE srr.idRamoPromotoria = '.$id : "";
		//$data['hourRmPr'] = $this->catalogos_model->obtenerTodoRamoPromotoria();
		$data['training'] = $this->catalogos_model->getTrainingHoraRamoPromotoria($sql);
		$data['data'] = array("idRamoPromotoria" => $id);
		echo json_encode($data);
	}

	function saveHourRamoPromotoria() {
		$info = $this->input->post('up');
		$result = array();
		foreach ($info as $val) {
			//Actualizar
			$update[$val['celda']] = $val['value'];
			$status_up = $this->catalogos_model->updateHourRamoPromotoria($val['id'],$update);
     		//Seguimiento
     		$insert = array(
     			"idRamoPromotoria" => $val['id'],
     			"campo" => $val['celda'],
     			"valor" => $val['value'],
     			"accion" => "actualizar",
     			"hecho_por" => $this->tank_auth->get_idPersona()
     		);
     		$status_in = $this->catalogos_model->insertTrainingRamoPromotoria($insert);
     		//Data
     		$add['idRamoPromotoria'] = $val['id'];
     		$add['celda'] = $val['celda'];
     		$add['value'] = $val['value'];
     		$add['update'] = $status_up;
     		$add['insert'] = $status_in;
     		array_push($result, $add);
		}
		$data['data'] = $result;
		echo json_encode($data);
	}
//-------------------------------------------------------------------------------------------------
}