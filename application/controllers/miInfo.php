<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class miInfo extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		
		$params['id_sicas'] = $this->tank_auth->get_IDUserSICAS();
		"get_IDUserSICAS";
		$params['user_sicas'] = $this->tank_auth->get_UserSICAS();
		"get_UserSICAS";
		$params['pass_sicas'] = $this->tank_auth->get_PassSICAS();
		"get_PassSICAS";
		$this->load->library('Ws_sicasdre', $params);
		$this->load->library('webservice_sicas_soap');
		$this->load->library('localfileuploader');
		$this->load->library('libreriav3');

		$this->load->helper('ckeditor');
		$this->load->model('capsysdre_miinfo');
		$this->load->model('personamodelo');
		$this->load->model('funnelM');
		$this->load->model("metacomercial_modelo");
		$this->load->model("menu_model");
		$this->load->model("capacita_modelo");
		$this->load->model("capitalhumano_model", "capitalhumano");

	}

	function saveImage()
	{
		if (isset($_FILES['upload'])) {
			// $_FILES['upload']['extension'] = 'jpg';
			$email = $this->tank_auth->get_usermail();
			$fileUploader = new localfileuploader();
			$url = $fileUploader->moveFileB($_FILES['upload'], $email);

			if (!empty($url)) {

				$data = array('fotoUser' => $email . '.jpg');
				$this->capsysdre->miInfo_GuardarUsuario($this->tank_auth->get_usermail(), $data);

				echo 'true';
			} else {
				echo 'false';
			}
			return;
		}

		echo 'false';
	}

	function index()
	{

		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			// variables
			$msg = "";
			$emailUsuario = "";
			$idPersona = "";
			$configModulos = array();
			$path_foto = "./assets/img/miInfo/userPhotos/";

			//================CODIGO ANTES DE LOCM 21-03-2019================================
			//$emailUsuario=$_GET['userMail'];
			if (isset($_GET['userMail'])) {
				$emailUsuario = $_GET['userMail'];
				$idPersona = $_GET['idPersona'];
			} else {
				if (isset($_POST['userMail'])) {
					$emailUsuario = $_POST['userMail'];
					$idPersona = $_POST['idPersona'];
				} else {
					$emailUsuario = $this->tank_auth->get_usermail();
					$idPersona = $this->tank_auth->get_idPersona();
				}
			}
			//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($emailUsuario,TRUE));fclose($fp);
			//$emailUsuario='CLORIA@ASESORESCAPITAL.COM';
			//====================================================

			$proximoBaneo = $this->capsysdre->fechaProximoBaneo($emailUsuario);
			$infoProspectos['mes'] = date('m');
			$infoProspectos['anio'] = date('Y');
			$infoProspectos['Usuario'] = $emailUsuario;
			$data['prospectos'] = $this->funnelM->clientesXmesX($infoProspectos);
			//================CODIGO ANTES DE LOCM 21-03-2019================================			
			//$miInfo_Datos = $this->capsysdre->miInfo_DatosUsuario($emailUsuario);
			//===================================================================================		


			//================CODIGO ANTES DE LOCM 21-03-2019================================

			/*	if(empty($miInfo_Datos)){
				$msg = "No se pudieron cargar los datos del usuario, el correo es vacio";
				$miInfo_Datos = array();
			}else{
				
				/*$IDCont			= $miInfo_Datos->IDCont;
			
				if( ((int)$IDCont) > 0 ){
					
					$infoContacto	= $this->capsysdre_miinfo->DetalleContacto($IDCont);
						
					if(!empty($infoContacto)){
						
						$emailUser								= strtoupper($infoContacto[0]->EMail1);
						//$emailUser								= 1;
						$dataMiInfo['nombre'] 					= "".$infoContacto[0]->Nombre."";
						$dataMiInfo['apellidop'] 				= "".$infoContacto[0]->ApellidoP."";
						$dataMiInfo['apellidom'] 				= "".$infoContacto[0]->ApellidoM."";
						$dataMiInfo['rfc'] 						= "".$infoContacto[0]->RFC;
						$dataMiInfo['telefono_celular'] 		= "".$infoContacto[0]->Telefono1."";
						$dataMiInfo['telefono_casa'] 			= "".$infoContacto[0]->Telefono2."";
						$dataMiInfo['telefono_trabajo'] 		= "".$infoContacto[0]->Telefono3."";
						$dataMiInfo['estado_civil'] 			= "".$infoContacto[0]->EdoCivil."";
						$dataMiInfo['fecha_nacimiento'] 		= "".$infoContacto[0]->FechaNac."";
						$dataMiInfo['imss'] 					= "".$infoContacto[0]->NSS."";
						//$dataMiInfo['cuanto_te_gustaria_ganar'] = "".$infoContacto[0]->Percepcion."";
						$dataMiInfo['licencia_conducir'] 		= "".$infoContacto[0]->LicenciaNum."";
						$dataMiInfo['pasaporte'] 				= "".$infoContacto[0]->NumPasaporte."";
						$dataMiInfo['Expediente'] 				= "".$infoContacto[0]->Expediente."";
						$dataMiInfo['Giro'] 					= "".$infoContacto[0]->Giro."";
						$dataMiInfo['Actividad'] 				= "".$infoContacto[0]->Actividad."";
						$dataMiInfo['Clasifica'] 				= "".$infoContacto[0]->Clasifica."";
						
						if(empty($emailUser)){
							$msg = "El email esta vacio, no se actualizaron los campos.";
						}else{
							$this->db->trans_begin();
							$this->db->where('user_miInfo.emailUser', $emailUser);
							$this->db->update('user_miInfo', $dataMiInfo);
							
							if ($this->db->trans_status() === FALSE)
							{
								$msg = "Ocurrio un error en la transaccion.";
								$this->db->trans_rollback();
							}
							else
							{
								$msg = "Sus registros fueron actualizados correctamente";
								$this->db->trans_commit();
							}
						}
					}else{
						$msg = "El detalle del contacto del ws sicas esta vacio, por lo tanto no se realiza ninguna actualizacion local.";
					}	
					
				}
				$miInfo_Datos = $this->capsysdre->miInfo_DatosUsuario('CLORIA@ASESORESCAPITAL.COM');
				if(file_exists( $path_foto .$emailUsuario.".jpg")){			
					
					$miInfo_Datos->fotoUser = $path_foto . $this->tank_auth->get_usermail().".jpg";
				} else {
					$miInfo_Datos->fotoUser = $path_foto . "noPhoto.png";
				}

				$configModulos = $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail());	
			}*/
			//$miInfo_Datos = $this->capsysdre->miInfo_DatosUsuario($emailUsuario);
			//$miInfo_Datos = $this->personamodelo->datos_personales($emailUsuario);
			$miInfo_Datos = $this->personamodelo->datos_personales($idPersona);
			if (file_exists($path_foto . $emailUsuario . ".jpg")) {

				$miInfo_Datos->fotoUser = $path_foto . $emailUsuario . ".jpg";
			} else {
				$miInfo_Datos->fotoUser = $path_foto . "noPhoto.png";
			}
			//=======================================================

			//=========================================CODIGO 1===========================================
			//$configModulos = $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail());		
			$configModulos = $this->capsysdre->ConfiguracionUsuarios($emailUsuario);
			//====================================================================================



			###### Semaforo de Actividades ######
			$meses["01"]	= "Enero";
			$meses["02"]	= "Febrero";
			$meses["03"]	= "Marzo";
			$meses["04"]	= "Abril";
			$meses["05"]	= "Mayo";
			$meses["06"]	= "Junio";
			$meses["07"]	= "Julio";
			$meses["08"]	= "Agosto";
			$meses["09"]	= "Septiembre";
			$meses["10"]	= "Octubre";
			$meses["11"]	= "Noviembre";
			$meses["12"]	= "Diciembre";
			$data['meses']	= $meses;


			$sqlConsultaVendedores = "
				Select
					`NombreCompleto`, `Status_TXT`, `EMail1`, `Giro`, `Clasifica_TXT`
				From
					`catalog_vendedores`
				Where
					(
					`EMail1` Is Not Null
					And
					`EMail1` != ''
					)
					And
					(
					`EMail1` = '" . $emailUsuario . "'
					)
				Order By
					`Status_TXT`, `NombreCompleto` Asc
									 ";/*$this->session->userdata["usermail"]*/


			$quesyConsultaVendedores	= $this->db->query($sqlConsultaVendedores);

			$monitorear			= $this->input->post('monitorear', true);
			$mesActividades		= $this->input->post('mesActividades', true);
			$tipoActividad		= $this->input->post('tipoActividad', true);
			$subRamoActividad	= $this->input->post('subRamoActividad', true);

			$data['usuVend_Array']	= $quesyConsultaVendedores->result_array();
			//var_dump($data);
			$data['anoActual']		= $anoActual	= date('Y');
			$data['mesActivo']		= $mesActivo	= date('m');

			$data['usuarioVendedor'] = $usuarioVendedor	= $emailUsuario; //$this->session->userdata["usermail"]; //$this->input->post('usuarioVendedor',true);
			$data['filtroFechas']	= $filtroFechas		= $this->input->post('filtroFechas', true);
			$data['fechaStart']		= $fechaStart		= $this->input->post('fechaStart', true);
			$data['fechaEnd']		= $fechaEnd			= $this->input->post('fechaEnd', true);
			$data['idPersona']		= $idPersona;
			/*======================================== TRAIGO INFORMACION DE CALIFICACION ==============================================*/
			$urgentes = "select (count(actividades.actividadUrgente)) as cantidad from actividades where actividadUrgente=1 ";
			$satisfaccionMala = 'select (count(satisfaccion)) as mala from actividades where actividades.satisfaccion="malo"';
			$satisfaccionBuena = 'select (count(satisfaccion)) as buena from actividades where actividades.satisfaccion="bueno"';
			$satisfaccionRegular = 'select (count(satisfaccion)) as regular from actividades where actividades.satisfaccion="regular"';
			$satisfaccionSinCalificar = 'select (count(idinterno)) as sinCalificar from actividades where actividades.satisfaccion is null';
			if ($usuarioVendedor != "") {
				$urgentes = $urgentes . ' and usuarioVendedor="' . $usuarioVendedor . '"';
				$satisfaccionMala = $satisfaccionMala . ' and usuarioVendedor="' . $usuarioVendedor . '"';
				$satisfaccionBuena = $satisfaccionBuena . ' and usuarioVendedor="' . $usuarioVendedor . '"';
				$satisfaccionRegular = $satisfaccionRegular . ' and usuarioVendedor="' . $usuarioVendedor . '"';
				$satisfaccionSinCalificar = $satisfaccionSinCalificar . ' and usuarioVendedor="' . $usuarioVendedor . '"';
			}

			if ($filtroFechas != "") {
				$urgentes = $urgentes . ' and cast(actividades.fechaCreacion as date) BETWEEN "' . $fechaStart . '" and "' . $fechaEnd . '"';
				$satisfaccionMala = $satisfaccionMala . ' and cast(actividades.fechaCreacion as date) BETWEEN "' . $fechaStart . '" and "' . $fechaEnd . '"';
				$satisfaccionBuena = $satisfaccionBuena . ' and cast(actividades.fechaCreacion as date) BETWEEN "' . $fechaStart . '" and "' . $fechaEnd . '"';
				$satisfaccionRegular = $satisfaccionRegular . ' and cast(actividades.fechaCreacion as date) BETWEEN "' . $fechaStart . '" and "' . $fechaEnd . '"';
				$satisfaccionSinCalificar = $satisfaccionSinCalificar . ' and cast(actividades.fechaCreacion as date) BETWEEN "' . $fechaStart . '" and "' . $fechaEnd . '"';
			} else {
				if ($mesActividades == "") {
					$urgentes = $urgentes . ' and year(actividades.fechaCreacion)=year(NOW()) and month(actividades.fechaCreacion)=' . $mesActivo;
					$satisfaccionMala = $satisfaccionMala . ' and year(actividades.fechaCreacion)=year(NOW()) and month(actividades.fechaCreacion)=' . $mesActivo;
					$satisfaccionBuena = $satisfaccionBuena . ' and year(actividades.fechaCreacion)=year(NOW()) and month(actividades.fechaCreacion)=' . $mesActivo;
					$satisfaccionRegular = $satisfaccionRegular . ' and year(actividades.fechaCreacion)=year(NOW()) and month(actividades.fechaCreacion)=' . $mesActivo;
					$satisfaccionSinCalificar = $satisfaccionSinCalificar . ' and year(actividades.fechaCreacion)=year(NOW()) and month(actividades.fechaCreacion)=' . $mesActivo;
				} else {
					$urgentes = $urgentes . ' and year(actividades.fechaCreacion)=year(NOW()) and month(actividades.fechaCreacion)=' . $mesActividades;
					$satisfaccionMala = $satisfaccionMala . ' and year(actividades.fechaCreacion)=year(NOW()) and month(actividades.fechaCreacion)=' . $mesActividades;
					$satisfaccionBuena = $satisfaccionBuena . ' and year(actividades.fechaCreacion)=year(NOW()) and month(actividades.fechaCreacion)=' . $mesActividades;
					$satisfaccionRegular = $satisfaccionRegular . ' and year(actividades.fechaCreacion)=year(NOW()) and month(actividades.fechaCreacion)=' . $mesActividades;
					$satisfaccionSinCalificar = $satisfaccionSinCalificar . ' and year(actividades.fechaCreacion)=year(NOW()) and month(actividades.fechaCreacion)=' . $mesActividades;
				}
			}




			$cantUrgentes = $this->db->query($urgentes);
			$cantMalas = $this->db->query($satisfaccionMala);
			$cantBuenas = $this->db->query($satisfaccionBuena);
			$cantRegular = $this->db->query($satisfaccionRegular);
			$cantSinCalificar = $this->db->query($satisfaccionSinCalificar);
			if (isset($_POST['tipoActividad'])) {
				/* $cantMalasPorTipo=$satisfaccionMala." and tipoActividad='".$_POST['tipoActividad']."'";
	 $cantBuenasPorTipo=$satisfaccionBuena." and tipoActividad='".$_POST['tipoActividad']."'";
	 $cantRegularPorTipo=$satisfaccionRegular." and tipoActividad='".$_POST['tipoActividad']."'";
	  $cantSinCalificarPorTipo=$satisfaccionSinCalificar." and tipoActividad='".$_POST['tipoActividad']."'";
	  $cantMalasPorTipoResult=$this->db->query($cantMalasPorTipo);
	  $cantBuenasPorTipoResult=$this->db->query($cantBuenasPorTipo);
	  $cantRegularResult=$this->db->query($cantRegularPorTipo);
	  $cantSinCalificarResult=$this->db->query($cantSinCalificarPorTipo);*/
				//$cantMalasPorTipoResult->result()[0]->mala=0;$cantBuenasPorTipoResult->result()[0]->buena=20 , $cantRegularResult->result()[0]->regular=2;$cantSinCalificarResult->result()[0]->sinCalificar
				// $fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r(""	, TRUE));fclose($fp);
			}


			/*===========================================================================================================================*/
			//=======================================LOCM====================================//


			if ($mesActividades) {
				$data['mesActivo']		= $mesActivo	= $mesActividades;
			} else {
				$data['mesActivo']		= $mesActivo;
			}
			// var_dump($data);
			if ($filtroFechas == "si") {
				$filtrandoFechas	= "
							(
							`fechaCreacion` Between '" . $fechaStart . "' And '" . $fechaEnd . "'
							Or
							`fechaCreacion` Like '%" . $fechaEnd . "%'
							)
									  ";
			} else {
				$filtrandoFechas	= "
							(
							`fechaCreacion` Like '" . $anoActual . "-" . $mesActivo . "%'
							)
									  ";
			}

			if ($usuarioVendedor != "") {
				$filtrandoUsuarioVendedor	= "
							`usuarioVendedor` = upper('" . $usuarioVendedor . "')
							And

											  ";
			} else {
				$filtrandoUsuarioVendedor	= "
											  ";
			}
			//////////////////////////////////////////////////////////////////////////////
			//=> Consulta Seccion Uno de Monitor
			$sqlConsultaActividades	= "
						Select 
							Count(*) As `noTipoActividad`, 
							`tipoActividad`
						From
							`actividades`
						Where
							$filtrandoUsuarioVendedor
							$filtrandoFechas
						Group By
							`tipoActividad`
						Order By
							`tipoActividad` Asc
											  ";
			$data['ConsultaActivi']	= $queConsultaActividades	= $this->db->query($sqlConsultaActividades);
			$resConsultaActividades = $queConsultaActividades->result_array();

			//=> Consulta Seccion Dos de Monitor
			if ($tipoActividad) {
				$data['tipoActividad']	= $tipoActividad; //			= $resConsultaActividades[0]['tipoActividad'];
			} else if (isset($resConsultaActividades[0]['tipoActividad'])) {
				$data['tipoActividad']	= $tipoActividad			= $resConsultaActividades[0]['tipoActividad'];
			} else {
				//--> $data['tipoActividad']	= $tipoActividad			= "Cotizacion";
			}

			$cantMalasPorTipo = $satisfaccionMala . " and tipoActividad='" . $tipoActividad . "'";
			$cantBuenasPorTipo = $satisfaccionBuena . " and tipoActividad='" . $tipoActividad . "'";
			$cantRegularPorTipo = $satisfaccionRegular . " and tipoActividad='" . $tipoActividad . "'";
			$cantSinCalificarPorTipo = $satisfaccionSinCalificar . " and tipoActividad='" . $tipoActividad . "'";
			$cantMalasPorTipoResult = $this->db->query($cantMalasPorTipo);
			$cantBuenasPorTipoResult = $this->db->query($cantBuenasPorTipo);
			$cantRegularResult = $this->db->query($cantRegularPorTipo);
			$cantSinCalificarResult = $this->db->query($cantSinCalificarPorTipo);
			$sqlConsultaTiposActividad	= "
						Select 
							Count(*) As `noActividadTipo`,
							`tipoActividad`,
							`ramoActividad`,
							`subRamoActividad`
						From
							`actividades`
						Where
							$filtrandoUsuarioVendedor
							$filtrandoFechas
							And
							`tipoActividad` Like '" . $tipoActividad . "%'
						Group By
							`ramoActividad`, `subRamoActividad`
						Order By
							`ramoActividad`, `subRamoActividad` Asc
												 ";
			$data['ConsultaTipoAct']	= $queConsultaTiposActividad	= $this->db->query($sqlConsultaTiposActividad);
			$resConsultaTiposActividad	= $queConsultaTiposActividad->result_array();

			//=> Consulta Seccion Tres de Monitor
			if ($subRamoActividad) {
				$data['subRamoActividad']		= $subRamoActividad; //		= $resConsultaTiposActividad[0]['subRamoActividad']; 
			} else if (isset($resConsultaTiposActividad[0]['subRamoActividad'])) {
				$data['subRamoActividad']		= $subRamoActividad = $resConsultaTiposActividad[0]['subRamoActividad'];
			} else {
				$data['subRamoActividad']		= $subRamoActividad = "AUTOMOVILES INDIVIDUALES";
			}
			if ($monitorear == "SemaforoEnCurso") {

				$usermail = $emailUsuario; //$this->tank_auth->get_usermail();
				if ($usermail == "COORDINADORDIVISIONBIENES@ASESORESCAPITAL.COM") //MONICA
				{
				}
				if ($usermail == "COORDINADORDIVISIONPERSONAS@ASESORESCAPITAL.COM") //karent
				{
				}
				if ($usermail != "COORDINADORDIVISIONPERSONAS@ASESORESCAPITAL.COM" && $usermail != "COORDINADORDIVISIONBIENES@ASESORESCAPITAL.COM") {
				}	//fin de todos


				$queConsultaRamoGrupoActividad	= $this->db->query($sqlConsultaRamoGrupoActividad);
				$data['ConsultaSubRamosAct']	= $queConsultaRamoGrupoActividad->result_array();
			} else {
				$sqlConsultaRamoGrupoActividad	= "";
				$sqlConsultaRamoGrupoActividad	= "
						Select
							`folioActividad`,
							`tipoActividad`,
							`ramoActividad`,
							`subRamoActividad`,
							`datosExpres`,
							`nombreUsuarioCreacion`,
							`nombreUsuarioVendedor`,
							`nombreUsuarioResponsable`,
							`nombreUsuarioCotizador`,
							`fechaCreacion`,
							`fechaActualizacion`,
							`Status_Txt`
						From
							`actividades`
						Where
							$filtrandoUsuarioVendedor
							$filtrandoFechas
							And
							`tipoActividad`		Like '" . $tipoActividad . "%'
							And
							`subRamoActividad`	= '" . $subRamoActividad . "'
						Order By
							`fechaCreacion`, `ramoActividad`, `subRamoActividad` Asc

													  ";
				$data['ConsultaSubRamosAct']	= $queConsultaRamoGrupoActividad	= $this->db->query($sqlConsultaRamoGrupoActividad);
			}

			////////////////////////////////////////////////////////////////////////////// SEMAFORO A 30 DIAS

			if ($monitorear == "SemaforoEnCursoMes") {


				$usermail = $emailUsuario; //$this->tank_auth->get_usermail();
				if ($usermail == "COORDINADORDIVISIONBIENES@ASESORESCAPITAL.COM") //MONICA
				{
					$sqlConsultaRamoGrupoActividad	= "	
select 
(
if(TIMESTAMPDIFF(minute,`act`.`fechaCreacion`,`fechaGrabado`)>=120,'Purple','Green')) as color,

											`act`.`folioActividad`,
								   `act`.`tipoActividad`,
								   `act`.`ramoActividad`,
								   `act`.`subRamoActividad`, 
								   `act`.`datosExpres`,
								   `act`.`nombreUsuarioCreacion`,
								   `act`.`nombreUsuarioVendedor`,
								   `act`.`nombreUsuarioResponsable`,
								   `act`.`nombreUsuarioCotizador`,
								   `act`.`fechaCreacion`,
								   `act`.`fechaActualizacion`,
								   `act`.`Status_Txt`,`acp`.`status`,min(acp.fechaGrabado) as fechaGrabado
 from `actividades` `act`
 left join `actividadespartidas` acp on  `act`.`folioActividad`=`acp`.`folioActividad`
 where (`act`.`Status_Txt`='AGENTE GAP')
 and (`act`.ramoActividad='VEHICULOS' OR `act`.ramoActividad='DANOS' OR `act`.ramoActividad='DAÑOS')
 and (`act`.subRamoActividad<>'FLOTILLA DE VEHICULOS')
and  cast(`act`.`fechaCreacion` as date) between '" . $fechaStart . "' And '" . $fechaEnd . "'
group by 1,2,3,4,5,6,7,8,9,10,11,12
union
select 
(
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=120,'Red',
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=30,'Orange','Blue'))
) as color    ,
							  `act`.`folioActividad`,
								   `act`.`tipoActividad`,
								   `act`.`ramoActividad`,
								   `act`.`subRamoActividad`,
								   `act`.`datosExpres`,
								   `act`.`nombreUsuarioCreacion`,
								   `act`.`nombreUsuarioVendedor`,
								   `act`.`nombreUsuarioResponsable`,
								   `act`.`nombreUsuarioCotizador`,
								   `act`.`fechaCreacion`,
								   `act`.`fechaActualizacion`,
								   `act`.`Status_Txt`,'5' as status,now() as fechaGRabado
from `actividades` act
where (`act`.`Status_Txt`='EN CURSO')
and (`act`.ramoActividad='VEHICULOS' OR `act`.ramoActividad='DANOS' OR `act`.ramoActividad='DAÑOS')
and (`act`.subRamoActividad<>'FLOTILLA DE VEHICULOS')
and  cast(`act`.`fechaCreacion` as date) between '" . $fechaStart . "' And '" . $fechaEnd . "'

union

select 
(
if(TIMESTAMPDIFF(minute,`act`.`fechaCreacion`,`fechaGrabado`)>=7200,'Purple','Green')) as color,

											`act`.`folioActividad`,
								   `act`.`tipoActividad`,
								   `act`.`ramoActividad`,
								   `act`.`subRamoActividad`,
								   `act`.`datosExpres`,
								   `act`.`nombreUsuarioCreacion`,
								   `act`.`nombreUsuarioVendedor`,
								   `act`.`nombreUsuarioResponsable`,
								   `act`.`nombreUsuarioCotizador`,
								   `act`.`fechaCreacion`,
								   `act`.`fechaActualizacion`,
								   `act`.`Status_Txt`,`acp`.`status`,min(acp.fechaGrabado) as fechaGrabado
 from `actividades` `act`
 left join `actividadespartidas` acp on  `act`.`folioActividad`=`acp`.`folioActividad`
 where (`act`.`Status_Txt`='AGENTE GAP')
 and (`act`.ramoActividad='VEHICULOS')
 and (`act`.subRamoActividad='FLOTILLA DE VEHICULOS')
 and (`act`.tipoActividad='Cotizacion' or `act`.tipoActividad='Emision')
and  cast(`act`.`fechaCreacion` as date) between '" . $fechaStart . "' And '" . $fechaEnd . "'
group by 1,2,3,4,5,6,7,8,9,10,11,12
union
select 
(
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=7200,'Red',
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=1440,'Orange','Blue'))
) as color    ,
							  `act`.`folioActividad`,
								   `act`.`tipoActividad`,
								   `act`.`ramoActividad`,
								   `act`.`subRamoActividad`,
								   `act`.`datosExpres`,
								   `act`.`nombreUsuarioCreacion`,
								   `act`.`nombreUsuarioVendedor`,
								   `act`.`nombreUsuarioResponsable`,
								   `act`.`nombreUsuarioCotizador`,
								   `act`.`fechaCreacion`,
								   `act`.`fechaActualizacion`,
								   `act`.`Status_Txt`,'5' as status,now() as fechaGRabado
from `actividades` act
where (`act`.`Status_Txt`='EN CURSO')
and (`act`.ramoActividad='VEHICULOS')
and (`act`.subRamoActividad='FLOTILLA DE VEHICULOS')
and (`act`.tipoActividad='Cotizacion' or `act`.tipoActividad='Emision')
and  cast(`act`.`fechaCreacion` as date) between '" . $fechaStart . "' And '" . $fechaEnd . "'

union

select 
(
if(TIMESTAMPDIFF(minute,`act`.`fechaCreacion`,`fechaGrabado`)>=4320,'Purple','Green')) as color,

											`act`.`folioActividad`,
								   `act`.`tipoActividad`,
								   `act`.`ramoActividad`,
								   `act`.`subRamoActividad`,
								   `act`.`datosExpres`,
								   `act`.`nombreUsuarioCreacion`,
								   `act`.`nombreUsuarioVendedor`,
								   `act`.`nombreUsuarioResponsable`,
								   `act`.`nombreUsuarioCotizador`,
								   `act`.`fechaCreacion`,
								   `act`.`fechaActualizacion`,
								   `act`.`Status_Txt`,`acp`.`status`,min(acp.fechaGrabado) as fechaGrabado
 from `actividades` `act`
 left join `actividadespartidas` acp on  `act`.`folioActividad`=`acp`.`folioActividad`
 where (`act`.`Status_Txt`='AGENTE GAP')
 and (`act`.ramoActividad='VEHICULOS')
 and (`act`.subRamoActividad='FLOTILLA DE VEHICULOS')
 and (`act`.tipoActividad='Endoso' or `act`.tipoActividad='Cancelacion')
and  cast(`act`.`fechaCreacion` as date) between '" . $fechaStart . "' And '" . $fechaEnd . "'
group by 1,2,3,4,5,6,7,8,9,10,11,12
union
select 
(
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=4320,'Red',
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=1440,'Orange','Blue'))
) as color    ,
							  `act`.`folioActividad`,
								   `act`.`tipoActividad`,
								   `act`.`ramoActividad`,
								   `act`.`subRamoActividad`,
								   `act`.`datosExpres`,
								   `act`.`nombreUsuarioCreacion`,
								   `act`.`nombreUsuarioVendedor`,
								   `act`.`nombreUsuarioResponsable`,
								   `act`.`nombreUsuarioCotizador`,
								   `act`.`fechaCreacion`,
								   `act`.`fechaActualizacion`,
								   `act`.`Status_Txt`,'5' as status,now() as fechaGRabado
from `actividades` act
where (`act`.`Status_Txt`='EN CURSO')
and (`act`.ramoActividad='VEHICULOS')
and (`act`.subRamoActividad='FLOTILLA DE VEHICULOS')
and (`act`.tipoActividad='Endoso' or `act`.tipoActividad='Cancelacion')
and  cast(`act`.`fechaCreacion` as date) between '" . $fechaStart . "' And '" . $fechaEnd . "'


union

select 
(
if(TIMESTAMPDIFF(minute,`act`.`fechaCreacion`,`fechaGrabado`)>=7200,'Purple','Green')) as color,

											`act`.`folioActividad`,
								   `act`.`tipoActividad`,
								   `act`.`ramoActividad`,
								   `act`.`subRamoActividad`,
								   `act`.`datosExpres`,
								   `act`.`nombreUsuarioCreacion`,
								   `act`.`nombreUsuarioVendedor`,
								   `act`.`nombreUsuarioResponsable`,
								   `act`.`nombreUsuarioCotizador`,
								   `act`.`fechaCreacion`,
								   `act`.`fechaActualizacion`,
								   `act`.`Status_Txt`,`acp`.`status`,min(acp.fechaGrabado) as fechaGrabado
 from `actividades` `act`
 left join `actividadespartidas` acp on  `act`.`folioActividad`=`acp`.`folioActividad`
 where (`act`.`Status_Txt`='ASEGURADORA')
 and (`act`.ramoActividad='DANOS' OR `act`.ramoActividad='DAÑOS')
 and (`act`.tipoActividad='Cotizacion' or `act`.tipoActividad='Emision')
and  cast(`act`.`fechaCreacion` as date) between '" . $fechaStart . "' And '" . $fechaEnd . "'
group by 1,2,3,4,5,6,7,8,9,10,11,12
union
select 
(
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=7200,'Red',
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=1440,'Orange','Blue'))
) as color    ,
							  `act`.`folioActividad`,
								   `act`.`tipoActividad`,
								   `act`.`ramoActividad`,
								   `act`.`subRamoActividad`,
								   `act`.`datosExpres`,
								   `act`.`nombreUsuarioCreacion`,
								   `act`.`nombreUsuarioVendedor`,
								   `act`.`nombreUsuarioResponsable`,
								   `act`.`nombreUsuarioCotizador`,
								   `act`.`fechaCreacion`,
								   `act`.`fechaActualizacion`,
								   `act`.`Status_Txt`,'5' as status,now() as fechaGRabado
from `actividades` act
where (`act`.`Status_Txt`='ASEGURADORA')
and (`act`.ramoActividad='DANOS' OR `act`.ramoActividad='DAÑOS')
and (`act`.tipoActividad='Cotizacion' or `act`.tipoActividad='Emision')
and  cast(`act`.`fechaCreacion` as date) between '" . $fechaStart . "' And '" . $fechaEnd . "'

union

select 
(
if(TIMESTAMPDIFF(minute,`act`.`fechaCreacion`,`fechaGrabado`)>=4320,'Purple','Green')) as color,

											`act`.`folioActividad`,
								   `act`.`tipoActividad`,
								   `act`.`ramoActividad`,
								   `act`.`subRamoActividad`,
								   `act`.`datosExpres`,
								   `act`.`nombreUsuarioCreacion`,
								   `act`.`nombreUsuarioVendedor`,
								   `act`.`nombreUsuarioResponsable`,
								   `act`.`nombreUsuarioCotizador`,
								   `act`.`fechaCreacion`,
								   `act`.`fechaActualizacion`,
								   `act`.`Status_Txt`,`acp`.`status`,min(acp.fechaGrabado) as fechaGrabado
 from `actividades` `act`
 left join `actividadespartidas` acp on  `act`.`folioActividad`=`acp`.`folioActividad`
 where (`act`.`Status_Txt`='ASEGURADORA')
 and (`act`.ramoActividad='DANOS' OR `act`.ramoActividad='DAÑOS')
 and (`act`.tipoActividad='Endoso' or `act`.tipoActividad='Cancelacion')
and  cast(`act`.`fechaCreacion` as date) between '" . $fechaStart . "' And '" . $fechaEnd . "'
group by 1,2,3,4,5,6,7,8,9,10,11,12
union
select 
(
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=4320,'Red',
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=1440,'Orange','Blue'))
) as color    ,
							  `act`.`folioActividad`,
								   `act`.`tipoActividad`,
								   `act`.`ramoActividad`,
								   `act`.`subRamoActividad`,
								   `act`.`datosExpres`,
								   `act`.`nombreUsuarioCreacion`,
								   `act`.`nombreUsuarioVendedor`,
								   `act`.`nombreUsuarioResponsable`,
								   `act`.`nombreUsuarioCotizador`,
								   `act`.`fechaCreacion`,
								   `act`.`fechaActualizacion`,
								   `act`.`Status_Txt`,'5' as status,now() as fechaGRabado
from `actividades` act
where (`act`.`Status_Txt`='ASEGURADORA')
and (`act`.ramoActividad='DANOS' OR `act`.ramoActividad='DAÑOS')
and (`act`.tipoActividad='Endoso' or `act`.tipoActividad='Cancelacion')
and  cast(`act`.`fechaCreacion` as date) between '" . $fechaStart . "' And '" . $fechaEnd . "'";
				} //fin del if de monica

				if ($usermail == "COORDINADORDIVISIONPERSONAS@ASESORESCAPITAL.COM") //karent
				{
					$sqlConsultaRamoGrupoActividad	= "
select 
(
if(TIMESTAMPDIFF(minute,`act`.`fechaCreacion`,`fechaGrabado`)>=7200,'Purple','Green')) as color,

											`act`.`folioActividad`,
								   `act`.`tipoActividad`,
								   `act`.`ramoActividad`,
								   `act`.`subRamoActividad`,
								   `act`.`datosExpres`,
								   `act`.`nombreUsuarioCreacion`,
								   `act`.`nombreUsuarioVendedor`,
								   `act`.`nombreUsuarioResponsable`,
								   `act`.`nombreUsuarioCotizador`,

								   `act`.`fechaCreacion`,
								   `act`.`fechaActualizacion`,
								   `act`.`Status_Txt`,`acp`.`status`,min(acp.fechaGrabado) as fechaGrabado
 from `actividades` `act`
 left join `actividadespartidas` acp on  `act`.`folioActividad`=`acp`.`folioActividad`
 where (`act`.`Status_Txt`='AGENTE GAP')
 and (`act`.ramoActividad!='VIDA')
 and (`act`.tipoActividad='Emision' or `act`.tipoActividad='Endoso')
 and  cast(`act`.`fechaCreacion` as date) between '" . $fechaStart . "' And '" . $fechaEnd . "'
 group by 1,2,3,4,5,6,7,8,9,10,11,12

union

select 
(
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=7200,'Red',
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=1440,'Orange','Blue'))
) as color    ,
							  `act`.`folioActividad`,
								   `act`.`tipoActividad`,
								   `act`.`ramoActividad`,
								   `act`.`subRamoActividad`,
								   `act`.`datosExpres`,
								   `act`.`nombreUsuarioCreacion`,
								   `act`.`nombreUsuarioVendedor`,
								   `act`.`nombreUsuarioResponsable`,
								   `act`.`nombreUsuarioCotizador`,
								   `act`.`fechaCreacion`,
								   `act`.`fechaActualizacion`,
								   `act`.`Status_Txt`,'5' as status,now() as fechaGRabado
from `actividades` act
where (`act`.`Status_Txt`='EN CURSO')
and (`act`.ramoActividad!='VIDA')
and (`act`.tipoActividad='Emision' or `act`.tipoActividad='Endoso')
and  cast(`act`.`fechaCreacion` as date) between '" . $fechaStart . "' And '" . $fechaEnd . "'
				
union

select 
(
if(TIMESTAMPDIFF(minute,`act`.`fechaCreacion`,`fechaGrabado`)>=10080,'Purple','Green')) as color,

											`act`.`folioActividad`,
								   `act`.`tipoActividad`,
								   `act`.`ramoActividad`,
								   `act`.`subRamoActividad`,
								   `act`.`datosExpres`,
								   `act`.`nombreUsuarioCreacion`,
								   `act`.`nombreUsuarioVendedor`,
								   `act`.`nombreUsuarioResponsable`,
								   `act`.`nombreUsuarioCotizador`,
								   `act`.`fechaCreacion`,
								   `act`.`fechaActualizacion`,
								   `act`.`Status_Txt`,`acp`.`status`,min(acp.fechaGrabado) as fechaGrabado
 from `actividades` `act`
 left join `actividadespartidas` acp on  `act`.`folioActividad`=`acp`.`folioActividad`
 where (`act`.`Status_Txt`='AGENTE GAP')
 and (`act`.ramoActividad!='VIDA')
 and (`act`.tipoActividad='Cotizacion')
 and  cast(`act`.`fechaCreacion` as date) between '" . $fechaStart . "' And '" . $fechaEnd . "'
 group by 1,2,3,4,5,6,7,8,9,10,11,12

union

select 
(
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=10080,'Red',
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=1440,'Orange','Blue'))
) as color    ,
							  `act`.`folioActividad`,
								   `act`.`tipoActividad`,
								   `act`.`ramoActividad`,
								   `act`.`subRamoActividad`,
								   `act`.`datosExpres`,
								   `act`.`nombreUsuarioCreacion`,
								   `act`.`nombreUsuarioVendedor`,
								   `act`.`nombreUsuarioResponsable`,
								   `act`.`nombreUsuarioCotizador`,
								   `act`.`fechaCreacion`,
								   `act`.`fechaActualizacion`,
								   `act`.`Status_Txt`,'5' as status,now() as fechaGRabado
from `actividades` act
where (`act`.`Status_Txt`='EN CURSO')
and (`act`.ramoActividad!='VIDA')
and (`act`.tipoActividad='Cotizacion')
and  cast(`act`.`fechaCreacion` as date) between '" . $fechaStart . "' And '" . $fechaEnd . "'		


union

select 
(
if(TIMESTAMPDIFF(minute,`act`.`fechaCreacion`,`fechaGrabado`)>=7200,'Purple','Green')) as color,

											`act`.`folioActividad`,
								   `act`.`tipoActividad`,
								   `act`.`ramoActividad`,
								   `act`.`subRamoActividad`,
								   `act`.`datosExpres`,
								   `act`.`nombreUsuarioCreacion`,
								   `act`.`nombreUsuarioVendedor`,
								   `act`.`nombreUsuarioResponsable`,
								   `act`.`nombreUsuarioCotizador`,
								   `act`.`fechaCreacion`,
								   `act`.`fechaActualizacion`,
								   `act`.`Status_Txt`,`acp`.`status`,min(acp.fechaGrabado) as fechaGrabado
 from `actividades` `act`
 left join `actividadespartidas` acp on  `act`.`folioActividad`=`acp`.`folioActividad`
 where (`act`.`Status_Txt`='AGENTE GAP')
 and (`act`.ramoActividad!='ACCIDENTES_Y_ENFERMEDADES')
 and (`act`.tipoActividad='Emision' or `act`.tipoActividad='Endoso')
 and  cast(`act`.`fechaCreacion` as date) between '" . $fechaStart . "' And '" . $fechaEnd . "'
 group by 1,2,3,4,5,6,7,8,9,10,11,12

union

select 
(
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=7200,'Red',
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=1440,'Orange','Blue'))
) as color    ,
							  `act`.`folioActividad`,
								   `act`.`tipoActividad`,
								   `act`.`ramoActividad`,
								   `act`.`subRamoActividad`,
								   `act`.`datosExpres`,
								   `act`.`nombreUsuarioCreacion`,
								   `act`.`nombreUsuarioVendedor`,
								   `act`.`nombreUsuarioResponsable`,
								   `act`.`nombreUsuarioCotizador`,
								   `act`.`fechaCreacion`,
								   `act`.`fechaActualizacion`,
								   `act`.`Status_Txt`,'5' as status,now() as fechaGRabado
from `actividades` act
where (`act`.`Status_Txt`='EN CURSO')
and (`act`.ramoActividad!='ACCIDENTES_Y_ENFERMEDADES')
and (`act`.tipoActividad='Emision' or `act`.tipoActividad='Endoso')
and  cast(`act`.`fechaCreacion` as date) between '" . $fechaStart . "' And '" . $fechaEnd . "'	

union

select 
(
if(TIMESTAMPDIFF(minute,`act`.`fechaCreacion`,`fechaGrabado`)>=180,'Purple','Green')) as color,

											`act`.`folioActividad`,
								   `act`.`tipoActividad`,
								   `act`.`ramoActividad`,
								   `act`.`subRamoActividad`,
								   `act`.`datosExpres`,
								   `act`.`nombreUsuarioCreacion`,
								   `act`.`nombreUsuarioVendedor`,
								   `act`.`nombreUsuarioResponsable`,
								   `act`.`nombreUsuarioCotizador`,
								   `act`.`fechaCreacion`,
								   `act`.`fechaActualizacion`,
								   `act`.`Status_Txt`,`acp`.`status`,min(acp.fechaGrabado) as fechaGrabado
 from `actividades` `act`
 left join `actividadespartidas` acp on  `act`.`folioActividad`=`acp`.`folioActividad`
 where (`act`.`Status_Txt`='AGENTE GAP')
 and (`act`.ramoActividad!='ACCIDENTES_Y_ENFERMEDADES')
 and (`act`.tipoActividad='Cotizacion')
 and  cast(`act`.`fechaCreacion` as date) between '" . $fechaStart . "' And '" . $fechaEnd . "'
 group by 1,2,3,4,5,6,7,8,9,10,11,12

union

select 
(
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=180,'Red',
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=30,'Orange','Blue'))
) as color    ,
							  `act`.`folioActividad`,
								   `act`.`tipoActividad`,
								   `act`.`ramoActividad`,
								   `act`.`subRamoActividad`,
								   `act`.`datosExpres`,
								   `act`.`nombreUsuarioCreacion`,
								   `act`.`nombreUsuarioVendedor`,
								   `act`.`nombreUsuarioResponsable`,
								   `act`.`nombreUsuarioCotizador`,
								   `act`.`fechaCreacion`,
								   `act`.`fechaActualizacion`,
								   `act`.`Status_Txt`,'5' as status,now() as fechaGRabado
from `actividades` act
where (`act`.`Status_Txt`='EN CURSO')
and (`act`.ramoActividad!='ACCIDENTES_Y_ENFERMEDADES')
and (`act`.tipoActividad='Cotizacion')
and  cast(`act`.`fechaCreacion` as date) between '" . $fechaStart . "' And '" . $fechaEnd . "'
						";
				} //fin del if de karent

				if ($usermail != "COORDINADORDIVISIONPERSONAS@ASESORESCAPITAL.COM" && $usermail != "COORDINADORDIVISIONBIENES@ASESORESCAPITAL.COM") {


					$sqlConsultaRamoGrupoActividad	= "	
select 
(
if(TIMESTAMPDIFF(minute,`act`.`fechaCreacion`,`fechaGrabado`)>=120,'Purple','Green')) as color,

											`act`.`folioActividad`,
								   `act`.`tipoActividad`,
								   `act`.`ramoActividad`,
								   `act`.`subRamoActividad`, 
								   `act`.`datosExpres`,
								   `act`.`nombreUsuarioCreacion`,
								   `act`.`nombreUsuarioVendedor`,
								   `act`.`nombreUsuarioResponsable`,
								   `act`.`nombreUsuarioCotizador`,
								   `act`.`fechaCreacion`,
								   `act`.`fechaActualizacion`,
								   `act`.`Status_Txt`,`acp`.`status`,min(acp.fechaGrabado) as fechaGrabado
 from `actividades` `act`
 left join `actividadespartidas` acp on  `act`.`folioActividad`=`acp`.`folioActividad`
 where (`act`.`Status_Txt`='AGENTE GAP')
 and (`act`.ramoActividad='VEHICULOS' OR `act`.ramoActividad='DANOS' OR `act`.ramoActividad='DAÑOS')
 and (`act`.subRamoActividad<>'FLOTILLA DE VEHICULOS')
and  cast(`act`.`fechaCreacion` as date) between '" . $fechaStart . "' And '" . $fechaEnd . "'
group by 1,2,3,4,5,6,7,8,9,10,11,12
union
select 
(
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=120,'Red',
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=30,'Orange','Blue'))
) as color    ,
							  `act`.`folioActividad`,
								   `act`.`tipoActividad`,
								   `act`.`ramoActividad`,
								   `act`.`subRamoActividad`,
								   `act`.`datosExpres`,
								   `act`.`nombreUsuarioCreacion`,
								   `act`.`nombreUsuarioVendedor`,
								   `act`.`nombreUsuarioResponsable`,
								   `act`.`nombreUsuarioCotizador`,
								   `act`.`fechaCreacion`,
								   `act`.`fechaActualizacion`,
								   `act`.`Status_Txt`,'5' as status,now() as fechaGRabado
from `actividades` act
where (`act`.`Status_Txt`='EN CURSO')
and (`act`.ramoActividad='VEHICULOS' OR `act`.ramoActividad='DANOS' OR `act`.ramoActividad='DAÑOS')
and (`act`.subRamoActividad<>'FLOTILLA DE VEHICULOS')
and  cast(`act`.`fechaCreacion` as date) between '" . $fechaStart . "' And '" . $fechaEnd . "'

union

select 
(
if(TIMESTAMPDIFF(minute,`act`.`fechaCreacion`,`fechaGrabado`)>=7200,'Purple','Green')) as color,

											`act`.`folioActividad`,
								   `act`.`tipoActividad`,
								   `act`.`ramoActividad`,
								   `act`.`subRamoActividad`,
								   `act`.`datosExpres`,
								   `act`.`nombreUsuarioCreacion`,
								   `act`.`nombreUsuarioVendedor`,
								   `act`.`nombreUsuarioResponsable`,
								   `act`.`nombreUsuarioCotizador`,
								   `act`.`fechaCreacion`,
								   `act`.`fechaActualizacion`,
								   `act`.`Status_Txt`,`acp`.`status`,min(acp.fechaGrabado) as fechaGrabado
 from `actividades` `act`
 left join `actividadespartidas` acp on  `act`.`folioActividad`=`acp`.`folioActividad`
 where (`act`.`Status_Txt`='AGENTE GAP')
 and (`act`.ramoActividad='VEHICULOS')
 and (`act`.subRamoActividad='FLOTILLA DE VEHICULOS')
 and (`act`.tipoActividad='Cotizacion' or `act`.tipoActividad='Emision')
and  cast(`act`.`fechaCreacion` as date) between '" . $fechaStart . "' And '" . $fechaEnd . "'
group by 1,2,3,4,5,6,7,8,9,10,11,12
union
select 
(
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=7200,'Red',
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=1440,'Orange','Blue'))
) as color    ,
							  `act`.`folioActividad`,
								   `act`.`tipoActividad`,
								   `act`.`ramoActividad`,
								   `act`.`subRamoActividad`,
								   `act`.`datosExpres`,
								   `act`.`nombreUsuarioCreacion`,
								   `act`.`nombreUsuarioVendedor`,
								   `act`.`nombreUsuarioResponsable`,
								   `act`.`nombreUsuarioCotizador`,
								   `act`.`fechaCreacion`,
								   `act`.`fechaActualizacion`,
								   `act`.`Status_Txt`,'5' as status,now() as fechaGRabado
from `actividades` act
where (`act`.`Status_Txt`='EN CURSO')
and (`act`.ramoActividad='VEHICULOS')
and (`act`.subRamoActividad='FLOTILLA DE VEHICULOS')
and (`act`.tipoActividad='Cotizacion' or `act`.tipoActividad='Emision')
and  cast(`act`.`fechaCreacion` as date) between '" . $fechaStart . "' And '" . $fechaEnd . "'

union

select 
(
if(TIMESTAMPDIFF(minute,`act`.`fechaCreacion`,`fechaGrabado`)>=4320,'Purple','Green')) as color,

											`act`.`folioActividad`,
								   `act`.`tipoActividad`,
								   `act`.`ramoActividad`,
								   `act`.`subRamoActividad`,
								   `act`.`datosExpres`,
								   `act`.`nombreUsuarioCreacion`,
								   `act`.`nombreUsuarioVendedor`,
								   `act`.`nombreUsuarioResponsable`,
								   `act`.`nombreUsuarioCotizador`,
								   `act`.`fechaCreacion`,
								   `act`.`fechaActualizacion`,
								   `act`.`Status_Txt`,`acp`.`status`,min(acp.fechaGrabado) as fechaGrabado
 from `actividades` `act`
 left join `actividadespartidas` acp on  `act`.`folioActividad`=`acp`.`folioActividad`
 where (`act`.`Status_Txt`='AGENTE GAP')
 and (`act`.ramoActividad='VEHICULOS')
 and (`act`.subRamoActividad='FLOTILLA DE VEHICULOS')
 and (`act`.tipoActividad='Endoso' or `act`.tipoActividad='Cancelacion')
and  cast(`act`.`fechaCreacion` as date) between '" . $fechaStart . "' And '" . $fechaEnd . "'
group by 1,2,3,4,5,6,7,8,9,10,11,12
union
select 
(
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=4320,'Red',
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=1440,'Orange','Blue'))
) as color    ,
							  `act`.`folioActividad`,
								   `act`.`tipoActividad`,
								   `act`.`ramoActividad`,
								   `act`.`subRamoActividad`,
								   `act`.`datosExpres`,
								   `act`.`nombreUsuarioCreacion`,
								   `act`.`nombreUsuarioVendedor`,
								   `act`.`nombreUsuarioResponsable`,
								   `act`.`nombreUsuarioCotizador`,
								   `act`.`fechaCreacion`,
								   `act`.`fechaActualizacion`,
								   `act`.`Status_Txt`,'5' as status,now() as fechaGRabado
from `actividades` act
where (`act`.`Status_Txt`='EN CURSO')
and (`act`.ramoActividad='VEHICULOS')
and (`act`.subRamoActividad='FLOTILLA DE VEHICULOS')
and (`act`.tipoActividad='Endoso' or `act`.tipoActividad='Cancelacion')
and  cast(`act`.`fechaCreacion` as date) between '" . $fechaStart . "' And '" . $fechaEnd . "'


union

select 
(
if(TIMESTAMPDIFF(minute,`act`.`fechaCreacion`,`fechaGrabado`)>=7200,'Purple','Green')) as color,

											`act`.`folioActividad`,
								   `act`.`tipoActividad`,
								   `act`.`ramoActividad`,
								   `act`.`subRamoActividad`,
								   `act`.`datosExpres`,
								   `act`.`nombreUsuarioCreacion`,
								   `act`.`nombreUsuarioVendedor`,
								   `act`.`nombreUsuarioResponsable`,
								   `act`.`nombreUsuarioCotizador`,
								   `act`.`fechaCreacion`,
								   `act`.`fechaActualizacion`,
								   `act`.`Status_Txt`,`acp`.`status`,min(acp.fechaGrabado) as fechaGrabado
 from `actividades` `act`
 left join `actividadespartidas` acp on  `act`.`folioActividad`=`acp`.`folioActividad`
 where (`act`.`Status_Txt`='ASEGURADORA')
 and (`act`.ramoActividad='DANOS' OR `act`.ramoActividad='DAÑOS')
 and (`act`.tipoActividad='Cotizacion' or `act`.tipoActividad='Emision')
and  cast(`act`.`fechaCreacion` as date) between '" . $fechaStart . "' And '" . $fechaEnd . "'
group by 1,2,3,4,5,6,7,8,9,10,11,12
union
select 
(
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=7200,'Red',
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=1440,'Orange','Blue'))
) as color    ,
							  `act`.`folioActividad`,
								   `act`.`tipoActividad`,
								   `act`.`ramoActividad`,
								   `act`.`subRamoActividad`,
								   `act`.`datosExpres`,
								   `act`.`nombreUsuarioCreacion`,
								   `act`.`nombreUsuarioVendedor`,
								   `act`.`nombreUsuarioResponsable`,
								   `act`.`nombreUsuarioCotizador`,
								   `act`.`fechaCreacion`,
								   `act`.`fechaActualizacion`,
								   `act`.`Status_Txt`,'5' as status,now() as fechaGRabado
from `actividades` act
where (`act`.`Status_Txt`='ASEGURADORA')
and (`act`.ramoActividad='DANOS' OR `act`.ramoActividad='DAÑOS')
and (`act`.tipoActividad='Cotizacion' or `act`.tipoActividad='Emision')
and  cast(`act`.`fechaCreacion` as date) between '" . $fechaStart . "' And '" . $fechaEnd . "'

union

select 
(
if(TIMESTAMPDIFF(minute,`act`.`fechaCreacion`,`fechaGrabado`)>=4320,'Purple','Green')) as color,

											`act`.`folioActividad`,
								   `act`.`tipoActividad`,
								   `act`.`ramoActividad`,
								   `act`.`subRamoActividad`,
								   `act`.`datosExpres`,
								   `act`.`nombreUsuarioCreacion`,
								   `act`.`nombreUsuarioVendedor`,
								   `act`.`nombreUsuarioResponsable`,
								   `act`.`nombreUsuarioCotizador`,
								   `act`.`fechaCreacion`,
								   `act`.`fechaActualizacion`,
								   `act`.`Status_Txt`,`acp`.`status`,min(acp.fechaGrabado) as fechaGrabado
 from `actividades` `act`
 left join `actividadespartidas` acp on  `act`.`folioActividad`=`acp`.`folioActividad`
 where (`act`.`Status_Txt`='ASEGURADORA')
 and (`act`.ramoActividad='DANOS' OR `act`.ramoActividad='DAÑOS')
 and (`act`.tipoActividad='Endoso' or `act`.tipoActividad='Cancelacion')
and  cast(`act`.`fechaCreacion` as date) between '" . $fechaStart . "' And '" . $fechaEnd . "'
group by 1,2,3,4,5,6,7,8,9,10,11,12
union
select 
(
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=4320,'Red',
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=1440,'Orange','Blue'))
) as color    ,
							  `act`.`folioActividad`,
								   `act`.`tipoActividad`,
								   `act`.`ramoActividad`,
								   `act`.`subRamoActividad`,
								   `act`.`datosExpres`,
								   `act`.`nombreUsuarioCreacion`,
								   `act`.`nombreUsuarioVendedor`,
								   `act`.`nombreUsuarioResponsable`,
								   `act`.`nombreUsuarioCotizador`,
								   `act`.`fechaCreacion`,
								   `act`.`fechaActualizacion`,
								   `act`.`Status_Txt`,'5' as status,now() as fechaGRabado
from `actividades` act
where (`act`.`Status_Txt`='ASEGURADORA')
and (`act`.ramoActividad='DANOS' OR `act`.ramoActividad='DAÑOS')
and (`act`.tipoActividad='Endoso' or `act`.tipoActividad='Cancelacion')
and  cast(`act`.`fechaCreacion` as date) between '" . $fechaStart . "' And '" . $fechaEnd . "'



union

select 
(
if(TIMESTAMPDIFF(minute,`act`.`fechaCreacion`,`fechaGrabado`)>=7200,'Purple','Green')) as color,

											`act`.`folioActividad`,
								   `act`.`tipoActividad`,
								   `act`.`ramoActividad`,
								   `act`.`subRamoActividad`,
								   `act`.`datosExpres`,
								   `act`.`nombreUsuarioCreacion`,
								   `act`.`nombreUsuarioVendedor`,
								   `act`.`nombreUsuarioResponsable`,
								   `act`.`nombreUsuarioCotizador`,
								   `act`.`fechaCreacion`,
								   `act`.`fechaActualizacion`,
								   `act`.`Status_Txt`,`acp`.`status`,min(acp.fechaGrabado) as fechaGrabado
 from `actividades` `act`
 left join `actividadespartidas` acp on  `act`.`folioActividad`=`acp`.`folioActividad`
 where (`act`.`Status_Txt`='AGENTE GAP')
 and (`act`.ramoActividad!='VIDA')
 and (`act`.tipoActividad='Emision' or `act`.tipoActividad='Endoso')
 and  cast(`act`.`fechaCreacion` as date) between '" . $fechaStart . "' And '" . $fechaEnd . "'
 group by 1,2,3,4,5,6,7,8,9,10,11,12

union

select 
(
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=7200,'Red',
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=1440,'Orange','Blue'))
) as color    ,
							  `act`.`folioActividad`,
								   `act`.`tipoActividad`,
								   `act`.`ramoActividad`,
								   `act`.`subRamoActividad`,
								   `act`.`datosExpres`,
								   `act`.`nombreUsuarioCreacion`,
								   `act`.`nombreUsuarioVendedor`,
								   `act`.`nombreUsuarioResponsable`,
								   `act`.`nombreUsuarioCotizador`,
								   `act`.`fechaCreacion`,
								   `act`.`fechaActualizacion`,
								   `act`.`Status_Txt`,'5' as status,now() as fechaGRabado
from `actividades` act
where (`act`.`Status_Txt`='EN CURSO')
and (`act`.ramoActividad!='VIDA')
and (`act`.tipoActividad='Emision' or `act`.tipoActividad='Endoso')
and  cast(`act`.`fechaCreacion` as date) between '" . $fechaStart . "' And '" . $fechaEnd . "'
				
union

select 
(
if(TIMESTAMPDIFF(minute,`act`.`fechaCreacion`,`fechaGrabado`)>=10080,'Purple','Green')) as color,

											`act`.`folioActividad`,
								   `act`.`tipoActividad`,
								   `act`.`ramoActividad`,
								   `act`.`subRamoActividad`,
								   `act`.`datosExpres`,
								   `act`.`nombreUsuarioCreacion`,
								   `act`.`nombreUsuarioVendedor`,
								   `act`.`nombreUsuarioResponsable`,
								   `act`.`nombreUsuarioCotizador`,
								   `act`.`fechaCreacion`,
								   `act`.`fechaActualizacion`,
								   `act`.`Status_Txt`,`acp`.`status`,min(acp.fechaGrabado) as fechaGrabado
 from `actividades` `act`
 left join `actividadespartidas` acp on  `act`.`folioActividad`=`acp`.`folioActividad`
 where (`act`.`Status_Txt`='AGENTE GAP')
 and (`act`.ramoActividad!='VIDA')
 and (`act`.tipoActividad='Cotizacion')
 and  cast(`act`.`fechaCreacion` as date) between '" . $fechaStart . "' And '" . $fechaEnd . "'
 group by 1,2,3,4,5,6,7,8,9,10,11,12

union

select 
(
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=10080,'Red',
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=1440,'Orange','Blue'))
) as color    ,
							  `act`.`folioActividad`,
								   `act`.`tipoActividad`,
								   `act`.`ramoActividad`,
								   `act`.`subRamoActividad`,
								   `act`.`datosExpres`,
								   `act`.`nombreUsuarioCreacion`,
								   `act`.`nombreUsuarioVendedor`,
								   `act`.`nombreUsuarioResponsable`,
								   `act`.`nombreUsuarioCotizador`,
								   `act`.`fechaCreacion`,
								   `act`.`fechaActualizacion`,
								   `act`.`Status_Txt`,'5' as status,now() as fechaGRabado
from `actividades` act
where (`act`.`Status_Txt`='EN CURSO')
and (`act`.ramoActividad!='VIDA')
and (`act`.tipoActividad='Cotizacion')
and  cast(`act`.`fechaCreacion` as date) between '" . $fechaStart . "' And '" . $fechaEnd . "'		


union

select 
(
if(TIMESTAMPDIFF(minute,`act`.`fechaCreacion`,`fechaGrabado`)>=7200,'Purple','Green')) as color,

											`act`.`folioActividad`,
								   `act`.`tipoActividad`,
								   `act`.`ramoActividad`,
								   `act`.`subRamoActividad`,
								   `act`.`datosExpres`,
								   `act`.`nombreUsuarioCreacion`,
								   `act`.`nombreUsuarioVendedor`,
								   `act`.`nombreUsuarioResponsable`,
								   `act`.`nombreUsuarioCotizador`,
								   `act`.`fechaCreacion`,
								   `act`.`fechaActualizacion`,
								   `act`.`Status_Txt`,`acp`.`status`,min(acp.fechaGrabado) as fechaGrabado
 from `actividades` `act`
 left join `actividadespartidas` acp on  `act`.`folioActividad`=`acp`.`folioActividad`
 where (`act`.`Status_Txt`='AGENTE GAP')
 and (`act`.ramoActividad!='ACCIDENTES_Y_ENFERMEDADES')
 and (`act`.tipoActividad='Emision' or `act`.tipoActividad='Endoso')
 and  cast(`act`.`fechaCreacion` as date) between '" . $fechaStart . "' And '" . $fechaEnd . "'
 group by 1,2,3,4,5,6,7,8,9,10,11,12

union

select 
(
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=7200,'Red',
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=1440,'Orange','Blue'))
) as color    ,
							  `act`.`folioActividad`,
								   `act`.`tipoActividad`,
								   `act`.`ramoActividad`,
								   `act`.`subRamoActividad`,
								   `act`.`datosExpres`,
								   `act`.`nombreUsuarioCreacion`,
								   `act`.`nombreUsuarioVendedor`,
								   `act`.`nombreUsuarioResponsable`,
								   `act`.`nombreUsuarioCotizador`,
								   `act`.`fechaCreacion`,
								   `act`.`fechaActualizacion`,
								   `act`.`Status_Txt`,'5' as status,now() as fechaGRabado
from `actividades` act
where (`act`.`Status_Txt`='EN CURSO')
and (`act`.ramoActividad!='ACCIDENTES_Y_ENFERMEDADES')
and (`act`.tipoActividad='Emision' or `act`.tipoActividad='Endoso')
and  cast(`act`.`fechaCreacion` as date) between '" . $fechaStart . "' And '" . $fechaEnd . "'	

union

select 
(
if(TIMESTAMPDIFF(minute,`act`.`fechaCreacion`,`fechaGrabado`)>=180,'Purple','Green')) as color,

											`act`.`folioActividad`,
								   `act`.`tipoActividad`,
								   `act`.`ramoActividad`,
								   `act`.`subRamoActividad`,
								   `act`.`datosExpres`,
								   `act`.`nombreUsuarioCreacion`,
								   `act`.`nombreUsuarioVendedor`,
								   `act`.`nombreUsuarioResponsable`,
								   `act`.`nombreUsuarioCotizador`,
								   `act`.`fechaCreacion`,
								   `act`.`fechaActualizacion`,
								   `act`.`Status_Txt`,`acp`.`status`,min(acp.fechaGrabado) as fechaGrabado
 from `actividades` `act`
 left join `actividadespartidas` acp on  `act`.`folioActividad`=`acp`.`folioActividad`
 where (`act`.`Status_Txt`='AGENTE GAP')
 and (`act`.ramoActividad!='ACCIDENTES_Y_ENFERMEDADES')
 and (`act`.tipoActividad='Cotizacion')
 and  cast(`act`.`fechaCreacion` as date) between '" . $fechaStart . "' And '" . $fechaEnd . "'
 group by 1,2,3,4,5,6,7,8,9,10,11,12

union

select 
(
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=180,'Red',
if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=30,'Orange','Blue'))
) as color    ,
							  `act`.`folioActividad`,
								   `act`.`tipoActividad`,
								   `act`.`ramoActividad`,
								   `act`.`subRamoActividad`,
								   `act`.`datosExpres`,
								   `act`.`nombreUsuarioCreacion`,
								   `act`.`nombreUsuarioVendedor`,
								   `act`.`nombreUsuarioResponsable`,
								   `act`.`nombreUsuarioCotizador`,
								   `act`.`fechaCreacion`,
								   `act`.`fechaActualizacion`,
								   `act`.`Status_Txt`,'5' as status,now() as fechaGRabado
from `actividades` act
where (`act`.`Status_Txt`='EN CURSO')
and (`act`.ramoActividad!='ACCIDENTES_Y_ENFERMEDADES')
and (`act`.tipoActividad='Cotizacion')
and  cast(`act`.`fechaCreacion` as date) between '" . $fechaStart . "' And '" . $fechaEnd . "'
					";
				}	//fin de todos

				$queConsultaRamoGrupoActividad	= $this->db->query($sqlConsultaRamoGrupoActividad);
				$data['ConsultaSubRamosAct']	= $queConsultaRamoGrupoActividad->result_array();
			}

			//////////////////////////////////////////////////////////////////////////////
			switch ($monitorear) {
				case "Actividades":
					$url					= "";
					$vistaMonitor			= "monitores/monitorActividades";
					$data['consultarView']	= $consultarView	= "Actividades";
					break;

				case "SemaforoActividades":
					$url					= "";
					$vistaMonitor			= "monitores/semaforoActividades";
					$data['consultarView']	= $consultarView	= "Actividades";
					break;
				case "SemaforoEnCurso":
					$url					= "";
					$vistaMonitor			= "monitores/semaforoEnCurso";
					$data['consultarView']	= $consultarView	= "Actividades";
					break;
				case "SemaforoEnCursoMes":
					$url					= "";
					$vistaMonitor			= "monitores/semaforoEnCursoMes";
					$data['consultarView']	= $consultarView	= "Actividades";
					break;
			}
			/*=========================PASO INFORMACION DE CALIFICACION============================*/
			$data['cantUrgentes'] = $cantUrgentes->result()[0]->cantidad;
			$data['cantMalas'] = $cantMalas->result()[0]->mala;
			$data['cantBuenas'] = $cantBuenas->result()[0]->buena;
			$data['cantRegulares'] = $cantRegular->result()[0]->regular;
			$data['cantSinCalificar'] = $cantSinCalificar->result()[0]->sinCalificar;

			$data['cantMalasPorTipoResult'] = $cantMalasPorTipoResult->result()[0]->mala;
			$data['cantBuenasPorTipoResult'] = $cantBuenasPorTipoResult->result()[0]->buena;
			$data['cantRegularResult'] = $cantRegularResult->result()[0]->regular;
			$data['cantSinCalificarResult'] = $cantSinCalificarResult->result()[0]->sinCalificar;

			if ($proximoBaneo[0]->personaTipoAgente == "1" && $proximoBaneo[0]->idpersonarankingagente == "BRONCE") {

				$miInfo_Datos->diasParaBaneo = $proximoBaneo[0]->diasBaneo;
			}
			
			$data['meses'] = $this->libreriav3->devolverMeses();
			$data['montoMensualAgente'] = $this->capsysdre->obtenerGananciaMensual($emailUsuario);
			//$data["montoMensualAgente"]= $this->metaComercial_modelo->devolverInfoGeneralMeta($emailUsuario);
			/*====================================================================================================================*/
			###### Semaforo de Actividades ######

			//---------------------------
			//imagen de perfil
			$foto = "";
			$path_foto = "assets/img/miInfo/userPhotos/";
			$imagenPersona  = $this->menu_model->buscaFotoPersonal($idPersona); //

			if(!empty($imagenPersona)){
				if($imagenPersona=="noPhoto.png"){
					$foto = $path_foto . "noPhoto.png";
				}else{
					$foto = $path_foto . $imagenPersona;
				}
			} else{
				$foto=$path_foto."noPhoto.png";
			}

			$data["fotoPersonal"] = $foto;
			//---------------------------
			//Nueva implementación de metas comerciales. Dennis Castillo 2021-05-20 //1818
			//$array_cuentas = array();
			$array_cuentas = array("COORDINADOR@CAPCAPITAL.COM.MX", "COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX", "COORDINADORCOMERCIAL@FIANZASCAPITAL.COM", "COORDINADORINSTITUCIONAL@AGENTECAPITAL.COM", "DIRECTORGENERAL@AGENTECAPITAL.COM", "DIRECTORCOMERCIAL@AGENTECAPITAL.COM");
			//$coordinaciones = $this->personamodelo->devuelveCoordinadoresVentas();

			//foreach($coordinaciones as $datos){
				//array_push($array_cuentas, $datos->email);
			//}

			$proceso = array();

			if(in_array($emailUsuario,$array_cuentas)){
				$proceso = $this->gestionaMetasSuperiores(array("idPersona" => $idPersona, "correo" => $emailUsuario));
			} else{
				$proceso = $this->gestionaMetasAgentes(array("idPersona" => $idPersona, "correo" => $emailUsuario));
			}
			/*switch($emailUsuario){
				case in_array($emailUsuario,$array_cuentas) ? $proceso = $this->gestionaMetasSuperiores(array("idPersona" => $idPersona, "correo" => $emailUsuario)) : array();
				break;
				default: $proceso = $this->gestionaMetasAgentes(array("idPersona" => $idPersona, "correo" => $emailUsuario));
				break;
			}*/

			$data["metas_comerciales"] = $proceso;
			//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($proceso, TRUE));fclose($fp); //qqqq
			//---------------------------
			//-------------------------------------------------------------------------------------------------------------
				$infoGCapa=$this->personamodelo->devuelveInfoGeneralCapa($idPersona,date("n"),1);

				$arregloMes=array();
				$ramos=array();
				if(isset($infoGCapa)){
					foreach($infoGCapa as $valor){

						$ramos["profesional"]=$valor->certificacion;
						$ramos["autos"]=$valor->certificacionAutos;
						$ramos["vida"]=$valor->certificacionVida;
						$ramos["danios"]=$valor->certificacionDanos;
						$ramos["gmm"]=$valor->certificacionGmm;
						$ramos["fianzas"]=$valor->certificacionFianzas;

						$arregloMes[$valor->tipoCapacitacion][$valor->nombreCertificado]=$ramos;
					}
				}
			
			$data['capacitacion']=$arregloMes;//$this->personamodelo->devuelveInfoGeneralCapa($idPersona,date("n"));
			//-------------------------------------------------------------------------------------------------------------
			$metasAsignadaEnRamos=$this->metacomercial_modelo->obtenerDatosGeneralesMetasRamos($idPersona);
			
			$validadorR=array();
			$array_ramo=array("autos","vida","danios","gmm","fianzas");
			//$validador_ramo_r=array();

			$pr_pr=array();

			if(!empty($metasAsignadaEnRamos)){

				for($a=1; $a<13; $a++){

					$validador_ramo_r[$a]=array();

					foreach($metasAsignadaEnRamos as $infoR){

						if($a==$infoR->mes_asignado){

							array_push($validadorR,$infoR->mes_asignado);
							//$pr_pr[$a]=1;

							for($s=0; $s<count($array_ramo); $s++){

								if($array_ramo[$s]==$infoR->ramo){

									array_push($validador_ramo_r[$a],$array_ramo[$s]);

									$pr_pr[$a][$infoR->ramo]["Polizas"]=$infoR->cantidad_polizas;
									$pr_pr[$a][$infoR->ramo]["Prima"]=$infoR->prima_polizas;

								}
							}
							
							for($q=0;$q<count($array_ramo); $q++){

								if(!in_array($array_ramo[$q],$validador_ramo_r[$a])){
								
									$pr_pr[$a][$array_ramo[$q]]["Polizas"]=0;
									$pr_pr[$a][$array_ramo[$q]]["Prima"]=0;
								}
							}
						}
					}
					if(!in_array($a,$validadorR)){
						//$pr_pr[$a]=0;
						for($z=0; $z<count($array_ramo); $z++){
							$pr_pr[$a][$array_ramo[$z]]["Polizas"]=0;
							$pr_pr[$a][$array_ramo[$z]]["Prima"]=0;
						}
					}
				}
			}
			//------------------------------------------------------
			$trainingHours = $this->capacita_modelo->devuelveMiCapacitacion($idPersona);
			$trainingArray = array();
			if(!empty($trainingHours)){
				foreach($trainingHours as $d_t){

					$style = $this->generateStyle($d_t->nombre_ramo);
					$trainingArray[$d_t->tipoCapacitacion][$d_t->nombreCertificado][] = array("ramo" =>$d_t->nombre_ramo , "horas" => $d_t->horas, "style" => $style);
				}
			}
			//------------------------------------------------------
			$data["metaPorRamoMensual"]=$pr_pr;
			$data["training"] = $trainingArray;
			$data["trainingNames"] = array_keys($trainingArray);
			$data["mesCapaA"]=$this->personamodelo->devuelveMesesActivos($idPersona);
			$data['configModulos'] = $configModulos;
			$data['miInfo_Datos'] = $miInfo_Datos;
			$data['msg'] = $msg;
			$data['imagenPersona'] = $this->personamodelo->buscaFotoPersonal($idPersona);


			/** PERFIL EVALUACIONEs*/
			$this->config->load('global', TRUE);
			$this->global = $this->config->item('global');
			$this->load->model('evaluacion_periodos_model', 'periodo');
			$this->load->model('bonos_model', 'bono');
			$this->load->model('incidenciasmodel', 'incidencia');
			$this->load->model('pipmodel', 'pip');
			$this->load->library('common');

			$obPeriodo = null;
			if (isset($_GET["periodo"])) {
				$periodoId = intval($_GET["periodo"]);
				$obPeriodo = $this->periodo->selectById($periodoId);
			} else {
				//cambios TIC_Consultores 17/03/2021
				//$obPeriodo = $this->periodo->activo();
				$obPeriodo = $this->periodo->activo($idPersona);
			}
			$id = $idPersona;
			$bonos = $this->bono->getMe($id);

			$data["evaluaciones_pendientes"] = array();
			$data["evaluaciones_pendientes2"] = array();
			$data["mis_evaluaciones"] = array();
			$data["bonos"] = $bonos;

			$data["_empleados"] = $this->personamodelo->getEmpleados();
			$data["_puestos"] = $this->personamodelo->getPuestos();
			$data["id"] = $id;
			$data["periodos"] = $this->periodo->selectCerrados($this->tank_auth->get_idPersona());
			//$data["periodos"] = $this->periodo->selectCerrados();

			$data["periodoId"] = @$obPeriodo->id;
			$data["periodoName"] = @$obPeriodo->titulo;
			$obPersona=$this->periodo->obtener($id);
			//$obPersona = $this->personamodelo->obtener($id);

			$testNT=$this->periodo->ntMyInfo($this->tank_auth->get_idPersonaPuesto(),$this->tank_auth->get_idPersona());
			$data["testNT"]=$testNT;
			
			$data["es_empleado"] = 0;
			
			if ($obPersona)
			{
				//$data["es_empleado"] = 1;
				$data["es_empleado"]=$obPersona->tipoPersona;
				$data["name_complete"] = $obPersona->name_complete;
				$startD = $this->common->first_date(date("Y-m-d"));
				$endD = $this->common->last_date(date("Y-m-d"));
				$data["minDayVacation"] = $this->global["minDayVacation"];
				$data["startBlock"] = $this->global["startBlock"];
				$data["daysBlock"] = $this->global["daysBlock"];
				$data["puedo_solicitar"] = true;
				
				$obPuesto = $this->personamodelo->obtenerPuestoBy($obPersona->idPersonaPuesto);
				$data["dias_vacaciones"] = $this->personamodelo->getVacaciones($id);
				$data["solicitud_vacaciones"] = $this->incidencia->getVacacionesByfechas($id);
				$data["mis_incidencias"] = $this->incidencia->getIncidenciasByfechas($startD, $endD, $id);
				//$data["pips"] = $this->pip->getSeguimientoByEmpleado(@$obPeriodo->id,$id);
				$data["pips"] = $this->pip->getSeguimientoByEmpleado2($this->tank_auth->get_idPersona(),$this->tank_auth->get_idPersonaPuesto());
				if ($obPeriodo != null) {
					$data["evaluaciones_pendientes"] = $this->periodo->selectEvaluacionesByEmpelado($obPeriodo->id, $id);
					$data["evaluaciones_pendientes2"] = $this->periodo->selectEvaluacionesByEmpeladoPendienteNew($obPeriodo->id, $id);
					$data["mis_evaluaciones"] = $this->periodo->selectEvaluacionByEmpleado($obPeriodo->id, $id);
					$data["promedio"]=$this->periodo->getPromedioEvaluaciones($obPeriodo->id,$id);
				}
				$data["puedo_solicitar"] =  $this->tank_auth->get_idPersona() == $id ?  true : $obPuesto->padrePuesto == $this->tank_auth->get_idPersonaPuesto() ? true : false;
				/**END EVALUACIONES */
			}
    
    //*** Determinar prestamos
    $data['prestamos']=$this->getPrestamos($this->tank_auth->get_idPersona());
     //*** Determinar ahorros
    $data['ahorros']=$this->getAhorros($this->tank_auth->get_idPersona(),0);
            
    //$data['antiguedad']=$vacaciones[1];
	$getWorkStart = $this->personamodelo->getWorkStartPeriod($idPersona);
	$data["vacations"]["canRequestVacation"] = !empty($getWorkStart); 

	if(!empty($getWorkStart)){

		//***Miguel Determinar numero de dias correspondiente de vacaciones por antiguead
		$vacaciones=$this->getDiasVacaciones($this->tank_auth->get_idPersona());
		//*********************//
		$invalidDates = $this->getBlackoutDates();
		$initialJobDatesData = $this->getDateDataFromMyRecord($idPersona);
		$getAvailableDates = $this->getAvailableDates($invalidDates["initialDateForQuery"], $initialJobDatesData["nextDatePeriod"]);
		$vacationPermission = array_filter($this->personamodelo->getMyPermissions($idPersona), function($arr){
			return $arr->idLlavePermiso == "vacacionesLibres";
		});

		$data['diasVacaciones']=$vacaciones[0];
		$data['vacaciones']=$this->getVacaciones($this->tank_auth->get_idPersona());
		$data['diasSolicitados']=$this->getDiasSolicitados($this->tank_auth->get_idPersona());
		$data["vacations"]["period"] = !empty($initialJobDatesData) ? $initialJobDatesData["periodNumber"] : "Sin periodo";
		$data["vacations"]["initialDate"] = !empty($initialJobDatesData) ? $initialJobDatesData["initialJobDate"] : "Sin fecha de inicio de labores";
		$data["vacations"]["haveVacations"] = !empty($initialJobDatesData) ? $initialJobDatesData["haveVacations"] : false;
		$data["vacations"]["countDays"] = $getAvailableDates["countDays"];
		$data["vacations"]["changeDate"] = date("d/m/Y", strtotime($initialJobDatesData["nextDatePeriod"]));
		$data["vacations"]["daysWithThePeriod"] = $getWorkStart->dias; //date("d/m/Y", strtotime($initialJobDatesData["nextDatePeriod"]));
		$data["vacations"]["requestPastPeriods"] = !empty($vacationPermission);
		$per=$this->getDateDataFromMyRecord($this->tank_auth->get_idPersona());
		
		$data['vacations']['cantidadDiasPeriodo']=$vacaciones[0];

		$data["vacations"]["periodoActual"]=$per['currentDatePeriod'];	
	}

	//$data["vacations"]["others"] = $invalidDates["initialDateForQuery"];
	

		//** Valoracion y Comentarios**//
    $this->load->model('valoracion_model');
    $data['totalCuantos']=$this->valoracion_model->getCuantos($this->tank_auth->get_idPersona());
    $data['comentarios']=$this->valoracion_model->getComentarios($this->tank_auth->get_idPersona());
    $data['idPersona']=$this->tank_auth->get_idPersona();
    $data['puntos']=$this->valoracion_model->getPuntos();

	//var_dump($data["vacations"]);
    $this->load->view('miInfo/principal', $data);
		
        }
	}

	/*
	* @$url_tumb_resize = Url de la imagen previamente reducida a recortar,
	* @$x_axis = valor x donde se leera la imagen a recortar,
	* @$y_axis = valor y donde se leera la imagen a recortar
	* Retorna la ruta completa donde se encuentra el archivo recortado
	*/
    
    //Miguel Jaime 28-mayo-2021
    //determinar cantidad de dias de vacaciones correspondientes segun tabla de ley
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
        {$sqlX="SELECT * FROM tabla_vacaciones WHERE anio='$yearAntiguedad'";	}
         $period = $this->personamodelo->getWorkStartPeriod($idPersona);

        
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
    
    function getVacaciones($idPersona){
      //determinar vacaciones en el año por Usuario
      $year=date('Y');

      $data=$this->getDateDataFromMyRecord($idPersona);
      
       $fechaEntera = strtotime($data['currentDatePeriod']);
      $year=date('Y',$fechaEntera);
     /* $sqlX="SELECT *, 
	  	CASE 
			WHEN aprobado = 1 THEN 'default'
			WHEN aprobado = 0 THEN 'success'
			ELSE 'danger'
		END AS classLabel
		FROM vacaciones WHERE year(fecha)='$year' and idPersona='$idPersona' and showInList = 1";*/

$periodo=$data["periodNumber"];
$sqlX="SELECT *, 
	  	CASE 
			WHEN aprobado = 1 THEN 'default'
			WHEN aprobado = 0 THEN 'success'
			ELSE 'danger'
		END AS classLabel
		FROM vacaciones WHERE antiguedad='$periodo' and idPersona='$idPersona' and showInList = 1";

		
		$res=$this->db->query($sqlX)->result();

      return $res;
    }
    
    function getDiasSolicitados($idPersona){
      //determinar los dias solicitados en el año por Usuario
		$period = $this->personamodelo->getWorkStartPeriod($idPersona);
		$year=date('Y');

		$data=$this->getDateDataFromMyRecord($idPersona);
		       $fechaEntera = strtotime($data['currentDatePeriod']);
      $year=date('Y',$fechaEntera);

		
		$sqlX="SELECT SUM(cantidad_dias) as dias FROM vacaciones WHERE  antiguedad = ".$period->anio." AND aprobado IN (0, 1) and idPersona = $idPersona"; //aprobado<>-1
		return $this->db->query($sqlX)->result();
    }
    
    function getPrestamos($idPersona)
    {
      //determinar prestamos en el año por Usuario
      $year=date('Y');
      $sqlX="SELECT * FROM prestamos WHERE year(fecha)='$year' and idPersona='$idPersona'";
      return $this->db->query($sqlX)->result();
    }
    
    function getAhorros($idPersona,$tipoBusqueda='-1')
    {
      /*
        $idPersona= ES EL idPersona RELACIONADO A LA TABLA PERSONA
        $tipoBusqueda= USUALMENTO RECIBE EL AÑO QUE QUIERES BUSCAR, CON LAS SIGUIENTES CARACTERISTICAS
           --SI NO MANDAS NADA TE DEVOLVER LOS AHORROS DEL AÑO EN CURSO QUE ES COMO ESTABA HABITUALMENTE
           --SI MANDAS 0 TE DEVOLVERA EL ULTIMO AHORRO QUE TENGAS
           --SI MANDAS 1 TE DEVOLVERA TODOS LOS AHORROS QUE TENGAS
           --SI MANDAS EL AÑO TE DEVOLVERA EL DE ESE AÑO
      */


      $year=date('Y');
 
     switch ($tipoBusqueda)
     {
     	case '-1':$sqlX="SELECT * FROM ahorros WHERE year(fecha)='$year' and idPersona='$idPersona'";     	break;
     	
     	case '0': $sqlX="SELECT * FROM ahorros WHERE  idPersona='$idPersona' ORDER BY id DESC LIMIT 1";break;
     	case '1': $sqlX="SELECT * FROM ahorros WHERE  idPersona='$idPersona' ORDER BY id DESC ";break;
     	default: $sqlX="SELECT * FROM ahorros WHERE year(fecha)='$tipoBusqueda' and idPersona='$idPersona'"; ;break;
     }
      
      return $this->db->query($sqlX)->result();
    }
    
    
    
	function Crop($url_tumb_resize, $x_axis, $y_axis)
	{

		$config['image_library'] = 'gd2';
		$config['source_image']	= $url_tumb_resize;
		$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = false;
		$config['width']	= '100';
		$config['height']	= '120';
		$config['x_axis'] = $x_axis;
		$config['y_axis'] = $y_axis;

		$this->load->library('image_lib');
		$this->image_lib->clear();
		$this->image_lib->initialize($config);
		$properti_image = $this->image_lib;

		$xp	= $this->image_lib->explode_name($properti_image->dest_image);


		$filename = $xp['name'];
		$file_ext = $xp['ext'];

		$this->image_lib->crop();

		$fotoUser = "assets/img/miInfo/userPhotos/" . $filename . $properti_image->thumb_marker . $file_ext;

		return $fotoUser;
	}
	/*
	* @$miInfo_Datos = Url de la imagen previamente reducida a recortar,
	* @$width = ancho de imagen a reducir,
	* @$height = alto de imagen a reducir
	* Retorna la ruta completa donde se encuentra el archivo reducido
	*/
	function Resize($miInfo_Datos, $width, $height)
	{


		$config['image_library'] 	= 'gd2';
		$config['source_image']		= "assets/img/miInfo/userPhotos/" . $miInfo_Datos->fotoUser;
		$config['create_thumb'] 	= TRUE;
		$config['maintain_ratio'] 	= true;
		$config['width']			= $width;
		$config['height']			= $height;

		$this->load->library('image_lib');
		$this->image_lib->clear();
		$this->image_lib->initialize($config);
		$properti_image = $this->image_lib;

		$xp	= $this->image_lib->explode_name($properti_image->dest_image);


		$filename = $xp['name'];
		$file_ext = $xp['ext'];

		$this->image_lib->resize();

		$fotoUser = "assets/img/miInfo/userPhotos/" . $filename . $properti_image->thumb_marker . $file_ext;

		return $fotoUser;
	}

	function editar()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {

			$miinfo = $this->capsysdre->miInfo_DatosUsuario($this->tank_auth->get_usermail());
			if (file_exists("assets/img/miInfo/userPhotos/" . $miinfo->fotoUser)) {
				$miinfo->fotoUser = base_url() . "assets/img/miInfo/userPhotos/" . $miinfo->fotoUser;
			} else {
				$miinfo->fotoUser = base_url() . "assets/images/default-lgAvatar.jpg";
			}


			$data = array(
				'configModulos'	=> $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail()), 'miInfo_Datos' => $miinfo
			);

			$this->load->view('miInfo/editar', $data);
		}
	}

	function guardar()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data = array(
				'rfc'		=>	$this->input->post('rfc', TRUE),
				'nombre'	=>	$this->input->post('nombre', TRUE),
				'apellidop'	=>	$this->input->post('apellidop', TRUE),
				'apellidom'	=>	$this->input->post('apellidom', TRUE),
				'calle'		=>	$this->input->post('calle', TRUE),
				'no_ext'	=>	$this->input->post('no_ext', TRUE),
				'cruzamiento'	=>	$this->input->post('cruzamiento', TRUE),
				'cp'		=>	$this->input->post('cp', TRUE),
				'colonia'	=>	$this->input->post('colonia', TRUE),
				'ciudad'	=>	$this->input->post('ciudad', TRUE),
				'telefono_casa'	=>	$this->input->post('telefono_casa', TRUE),
				'telefono_trabajo'	=>	$this->input->post('telefono_trabajo', TRUE),
				'telefono_celular'	=>	$this->input->post('telefono_celular', TRUE),
				'cia_celular'	=>	$this->input->post('cia_celular', TRUE),
				'estado_civil'	=>	$this->input->post('estado_civil', TRUE),
				'escolaridad'	=>	$this->input->post('escolaridad', TRUE),
				'lugar_nacimiento'	=>	$this->input->post('lugar_nacimiento', TRUE),
				'fecha_nacimiento'	=>	date("Y-m-d", strtotime($this->input->post('fecha_nacimiento', TRUE))),
				'vehiculo_propio'	=>	$this->input->post('vehiculo_propio', TRUE),
				'modelo_vehiculo'	=>	$this->input->post('modelo_vehiculo', TRUE),
				'banco'	=>	$this->input->post('banco', TRUE),
				'cuenta_bancaria'	=>	$this->input->post('cuenta_bancaria', TRUE),
				'clabe'	=>	$this->input->post('clabe', TRUE),
				'tipo_cuenta'	=>	$this->input->post('tipo_cuenta', TRUE),
				'accidente_avisar'	=>	$this->input->post('accidente_avisar', TRUE),
				'accidente_telefono'	=>	$this->input->post('accidente_telefono', TRUE),
				'recomendado_por'	=>	$this->input->post('recomendado_por', TRUE),
				'referencias'	=>	$this->input->post('referencias', TRUE),
				'imss'	=>	$this->input->post('imss', TRUE),
				'tiene_hijos'	=>	$this->input->post('tiene_hijos', TRUE),
				'gasto_promedio_mensual'	=>	$this->input->post('gasto_promedio_mensual', TRUE),
				'cuanto_te_gustaria_ganar'	=>	$this->input->post('cuanto_te_gustaria_ganar', TRUE),
				'comida_favorita'	=>	$this->input->post('comida_favorita', TRUE),
				'color_favorito'	=>	$this->input->post('color_favorito', TRUE),
				'pasatiempo'	=>	$this->input->post('pasatiempo', TRUE),
				'club_social'	=>	$this->input->post('club_social', TRUE),
				/*'cedula_cnsf'	=>	$this->input->post('cedula_cnsf', TRUE),
				'vigencia_cnsf'	=>	date("Y-m-d",strtotime($this->input->post('vigencia_cnsf', TRUE))),*/
				'licencia_conducir'	=>	$this->input->post('licencia_conducir', TRUE),
				'vigencia_licencia'	=>	date("Y-m-d", strtotime($this->input->post('vigencia_licencia', TRUE))),
				'pasaporte'	=>	$this->input->post('pasaporte', TRUE),
				'vigencia_pasaporte'	=>	date("Y-m-d", strtotime($this->input->post('vigencia_pasaporte', TRUE)))

			);
			$IDCont =   $this->input->post('idCont', TRUE);

			$Tel1 = explode('|', $this->input->post('telefono_celular', TRUE));
			$Tel2 = explode('|', $this->input->post('telefono_casa', TRUE));
			$Tel3 = explode('|', $this->input->post('telefono_trabajo', TRUE));

			//$oDate = new DateTime($this->input->post('fecha_nacimiento', TRUE));

			$datos = array(
				"CatContactos" => array(
					"IDCont"       => $IDCont,
					"Nombre"       => $this->input->post('nombre', TRUE),
					"ApellidoP"    => $this->input->post('apellidop', TRUE),
					"ApellidoM"    => $this->input->post('apellidom', TRUE),
					// "Abreviacion"  => $Alias,
					"FechaNac"     => $this->input->post('fecha_nacimiento', TRUE),
					// "FechaNac"     => $oDate->format('d/m/Y'),
					"NumID"       => $this->input->post('cedula_cnsf', TRUE),
					"Telefono1"    => count($Tel1) > 1 ? 'Celular|' . $Tel1[1] : 'Celular|' . $Tel1[0],
					'Telefono2'	=>	count($Tel2) > 1 ? 'Casa|' . $Tel2[1] : 'Casa|' . $Tel2[0],
					'Telefono3'	=>	count($Tel3) > 1 ? 'Trabajo|' . $Tel3[1] : 'Trabajo|' . $Tel3[0],
					"EdoCivil" => $this->input->post('estado_civil', TRUE),
					"RFC" => $this->input->post('rfc', TRUE),
					// "LugarNac" => $LugarNac,
					"LicenciaNum" => $this->input->post('licencia_conducir', TRUE),
					"NSS" => $this->input->post('imss', TRUE),
					"Profesion" => $this->input->post('escolaridad', TRUE),
					"Percepcion" => $this->input->post('cuanto_te_gustaria_ganar', TRUE),
				)
			);

			//$this->capsysdre_miinfo->ActualizarContacto($datos);

			$this->capsysdre->miInfo_GuardarUsuario($this->tank_auth->get_usermail(), $data);
			redirect('miInfo');
		}
	}

	function verAgente()
	{


		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			// variables
			$msg = "";
			$configModulos = array();
			$path_foto = "./assets/img/miInfo/userPhotos/";

			$agenteUserMail = $this->input->get("userMail", TRUE);

			$miInfo_Datos = $this->capsysdre->miInfo_DatosUsuario($agenteUserMail);

			if (empty($miInfo_Datos)) {
				$msg = "No se pudieron cargar los datos del usuario, el correo es vacio";
				$miInfo_Datos = array();
			} else {

				$IDCont			= $miInfo_Datos->IDCont;

				if (((int) $IDCont) > 0) {

					$infoContacto	= $this->capsysdre_miinfo->DetalleContacto($IDCont);

					if (!empty($infoContacto)) {

						$emailUser								= strtoupper($infoContacto[0]->EMail1);
						//$emailUser								= 1;
						$dataMiInfo['nombre'] 					= "" . $infoContacto[0]->Nombre . "";
						$dataMiInfo['apellidop'] 				= "" . $infoContacto[0]->ApellidoP . "";
						$dataMiInfo['apellidom'] 				= "" . $infoContacto[0]->ApellidoM . "";
						$dataMiInfo['rfc'] 						= "" . $infoContacto[0]->RFC;
						$dataMiInfo['telefono_celular'] 		= "" . $infoContacto[0]->Telefono1 . "";
						$dataMiInfo['telefono_casa'] 			= "" . $infoContacto[0]->Telefono2 . "";
						$dataMiInfo['telefono_trabajo'] 		= "" . $infoContacto[0]->Telefono3 . "";
						$dataMiInfo['estado_civil'] 			= "" . $infoContacto[0]->EdoCivil . "";
						$dataMiInfo['fecha_nacimiento'] 		= "" . $infoContacto[0]->FechaNac . "";
						$dataMiInfo['imss'] 					= "" . $infoContacto[0]->NSS . "";
						$dataMiInfo['cuanto_te_gustaria_ganar'] = "" . $infoContacto[0]->Percepcion . "";
						$dataMiInfo['licencia_conducir'] 		= "" . $infoContacto[0]->LicenciaNum . "";
						$dataMiInfo['pasaporte'] 				= "" . $infoContacto[0]->NumPasaporte . "";
						$dataMiInfo['Expediente'] 				= "" . $infoContacto[0]->Expediente . "";
						$dataMiInfo['Giro'] 					= "" . $infoContacto[0]->Giro . "";
						$dataMiInfo['Actividad'] 				= "" . $infoContacto[0]->Actividad . "";
						$dataMiInfo['Clasifica'] 				= "" . $infoContacto[0]->Clasifica . "";

						if (empty($emailUser)) {
							$msg = "El email esta vacio, no se actualizaron los campos.";
						} else {
							$this->db->trans_begin();
							$this->db->where('user_miInfo.emailUser', $emailUser);
							$this->db->update('user_miInfo', $dataMiInfo);

							if ($this->db->trans_status() === FALSE) {
								$msg = "Ocurrio un error en la transaccion.";
								$this->db->trans_rollback();
							} else {
								$msg = "Sus registros fueron actualizados correctamente";
								$this->db->trans_commit();
							}
						}
					} else {
						$msg = "El detalle del contacto del ws sicas esta vacio, por lo tanto no se realiza ninguna actualizacion local.";
					}
				}
				$miInfo_Datos = $this->capsysdre->miInfo_DatosUsuario($agenteUserMail);
				if (file_exists($path_foto . $this->tank_auth->get_usermail() . ".jpg")) {

					$miInfo_Datos->fotoUser = $path_foto . $agenteUserMail . ".jpg";
				} else {
					$miInfo_Datos->fotoUser = $path_foto . "noPhoto.png";
				}

				$configModulos = $this->capsysdre->ConfiguracionUsuarios($agenteUserMail);
			}

			$data['configModulos'] = $configModulos;
			$data['miInfo_Datos'] = $miInfo_Datos;

			$data['msg'] = $msg;

			$this->load->view('miInfo/agente', $data);
		}
	}

	function obtenerInfoSeleccionado(){

		$arregloG=array();
		$ramos=array();
		$mensual=array();

		if($_GET["q"]!="total"){
			
			$infoDatos=$this->personamodelo->devuelveInfoGeneralCapa($_GET["r"],$_GET["q"],1);

			if(isset($infoDatos)){
				foreach($infoDatos as $valor){
					$ramos["profesional"]=$valor->certificacion;
					$ramos["autos"]=$valor->certificacionAutos;
					$ramos["vida"]=$valor->certificacionVida;
					$ramos["danios"]=$valor->certificacionDanos;
					$ramos["gmm"]=$valor->certificacionGmm;
					$ramos["fianzas"]=$valor->certificacionFianzas;

					$arregloG[$valor->tipoCapacitacion][$valor->nombreCertificado]=$ramos;
				}
				
				echo json_encode($arregloG);
			}
		} else{
			$infoDatos=$this->personamodelo->devuelveInfoGeneralCapa($_GET["r"],null,2);

			if(isset($infoDatos)){
				//echo json_encode($infoDatos);
				$mesesA=array(1,2,3,4,5,6,7,8,9,10,11,12);
				$voidMounth=array();

				for($i=0;$i<count($mesesA);$i++){
					foreach($infoDatos as $datos){
						if($mesesA[$i]==$datos->mes){
							$ramos["profesional"]=$datos->certificacion;
							$ramos["autos"]=$datos->certificacionAutos;
							$ramos["vida"]=$datos->certificacionVida;
							$ramos["danios"]=$datos->certificacionDanos;
							$ramos["gmm"]=$datos->certificacionGmm;
							$ramos["fianzas"]=$datos->certificacionFianzas;

							array_push($voidMounth,$datos->mes);

							$arregloG[$datos->mes][$datos->id_capacitacion." - ".$datos->tipoCapacitacion][$datos->id_capacitacion." - ".$datos->nombreCertificado]=array_sum($ramos);
						}
					}
					if(!in_array($mesesA[$i],array_unique($voidMounth))){

						$arregloG[$mesesA[$i]]=0;
					}
				}
				/*foreach($infoDatos as $datos){

					$ramos["profesional"]=$datos->certificacion;
					$ramos["autos"]=$datos->certificacionAutos;
					$ramos["vida"]=$datos->certificacionVida;
					$ramos["danios"]=$datos->certificacionDanos;
					$ramos["gmm"]=$datos->certificacionGmm;
					$ramos["fianzas"]=$datos->certificacionFianzas;

					$arregloG[$datos->mes][$datos->tipoCapacitacion][$datos->nombreCertificado]=$ramos;
					

				}*/
				
				echo json_encode($arregloG);
			}
		}
	}

	//---------------------------------------- Dennis Castillo 2021-05-20 -> 2021-07-22  //1818
	function gestionaMetasSuperiores($array_cuenta){

		$relacion_persona_comision = $this->metacomercial_modelo->devuelveRelacionComisionPersona($array_cuenta);
		$closureBussiness = $this->metacomercial_modelo->devuelveActivacionComercial();
		$directivos = array("DIRECTORGENERAL@AGENTECAPITAL.COM","DIRECTORICOMERCIAL@AGENTECAPITAL.COM","SISTEMAS@ASESORESCAPITAL.COM");
		$array_retorno = array();
		$array_retorno_ = array();

		if(!in_array($array_cuenta["correo"],$directivos)){

			$dato_canal = $this->metacomercial_modelo->devuelveCanalEspecifico($array_cuenta);
			//var_dump($dato_canal);

			if(!empty($dato_canal)){
				foreach($dato_canal as $d_c){

					$tipo_comision = $d_c->tipo == "nuevo" ? "venta_nueva" : "ingreso_total";
					$meta = $this->metacomercial_modelo->obtenerMetaAnualPorId($array_cuenta["idPersona"],$d_c->idTipoComision);
					$closingGoal = $this->metacomercial_modelo->getGoalsForMonthAndYear($array_cuenta["idPersona"], $d_c->idTipoComision, $closureBussiness[0]->mes_activado, $closureBussiness[0]->anio);
					//var_dump($closingGoal);
					$goal = !empty($closingGoal) ? $closingGoal->monto_al_mes : 0;

					if(!empty($meta)){
						
						$registros_mensuales = $this->metacomercial_modelo->obtenerMensualidadesDeMeta($meta->idMetaComercial,$array_cuenta["idPersona"], $d_c->idTipoComision);
						
						foreach($registros_mensuales as $d_rm){

							$closingCommission = $this->metacomercial_modelo->devuelveComisionComercial($d_c->idUsuarioCanal, $d_c->idTipoComision, $closureBussiness[0]->mes_activado, $closureBussiness[0]->anio);
							$commission = !empty($closingCommission) ? $closingCommission->comision : 0;

							$comision = $this->metacomercial_modelo->devuelveComisionComercial($d_c->idUsuarioCanal, $d_c->idTipoComision, $d_rm->mes_num, date("Y"));
							$commission_ = !empty($comision) ? $comision->comision : 0;

							$array_retorno_[$tipo_comision][$d_rm->mes_num]["monto_mes"] = $closureBussiness[0]->mes_activado == $d_rm->mes_num ? $goal : $d_rm->monto_al_mes;
							$array_retorno_[$tipo_comision][$d_rm->mes_num]["comision_venta_nueva"] = $closureBussiness[0]->mes_activado == $d_rm->mes_num ? $commission : $commission_; //!empty($comision) ? $comision->comision : 0;
							$array_retorno_[$tipo_comision][$d_rm->mes_num]["ingresos_totales"] = 0;
							$array_retorno_[$tipo_comision][$d_rm->mes_num]["badge"] = $closureBussiness[0]->mes_activado == $d_rm->mes_num ? true : false;
							$array_retorno_[$tipo_comision][$d_rm->mes_num]["year"] = $closureBussiness[0]->mes_activado == $d_rm->mes_num ? $closureBussiness[0]->anio : date("Y");
						}
					}
				}
			}
			

		} else{
					
			$tipo_meta = $this->metacomercial_modelo->devuelveTipoComisionConsultaComercial(); //array("venta_nueva", "ingreso_total");

			for($i = 1; $i < 13; $i++){

				foreach($tipo_meta as $m){

					$_tipo = $m->tipo == "nuevo" ? "venta_nueva" : "ingreso_total";
					$dato_mensual = $i == $closureBussiness[0]->mes_activado ? 
						$this->metacomercial_modelo->sumatoriaRegistrosDeMetas($closureBussiness[0]->mes_activado, $m->idTipoComision, 1, $closureBussiness[0]->anio) : 
						$this->metacomercial_modelo->sumatoriaRegistrosDeMetas($i, $m->idTipoComision, 1, date("Y"));
					
					$comision_total = $i == $closureBussiness[0]->mes_activado ?
						$this->metacomercial_modelo->sumatoriaDeComisionConsultaComercial($closureBussiness[0]->mes_activado, $m->idTipoComision, $closureBussiness[0]->anio) :
						$this->metacomercial_modelo->sumatoriaDeComisionConsultaComercial($i, $m->idTipoComision, date("Y"));
					//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($comision_total, TRUE));fclose($fp);
					$array_retorno_[$_tipo][$i]["monto_mes"] = !empty($dato_mensual) ? $dato_mensual->monto_al_mes : 0;
					$array_retorno_[$_tipo][$i]["comision_venta_nueva"] = !empty($comision_total) ? $comision_total->comision : 0; //0;//$m == "venta_nueva" ? $dato_mensual->comision_subsecuente : $dato_mensual->comision_actual;
					$array_retorno_[$_tipo][$i]["ingresos_totales"] = 0; //$dato_mensual->monto_al_mes;
					$array_retorno_[$_tipo][$i]["badge"] =  $i == $closureBussiness[0]->mes_activado ? true : false;
					$array_retorno_[$_tipo][$i]["year"] =  $i == $closureBussiness[0]->mes_activado ? $closureBussiness[0]->anio : date("Y");

				}
			}
		}
		
		//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($array_retorno_, TRUE));fclose($fp);
		return $array_retorno_; //$array_retorno; //Retorno del mismo resultado pero diferente tabla
	}
	//---------------------------------------- Dennis Castillo 2021-05-20
	function gestionaMetasAgentes($array_cuenta){
		
		$comisiones = $this->capsysdre->obtenerGananciaMensual($array_cuenta["correo"]);
		$_obtenerMetasMensuales=$this->metacomercial_modelo->devuelveMetasMensuales($array_cuenta["idPersona"]);

		$ingresos_mensuales = array();
		$validador_ingresos = array();

		for($a = 1; $a < 13; $a++){

			foreach($comisiones as $dd){

				if($a == $dd->mesEAB){

					$ingresos_mensuales[$dd->mesEAB]["comision_venta_nueva"] = $dd->contribucionEAB;
					$ingresos_mensuales[$dd->mesEAB]["ingresos_totales"] = $dd->ingresoTotalesEAB;
					array_push($validador_ingresos, $dd->mesEAB);
				}
			}
			if(!in_array($a, $validador_ingresos)){

				$ingresos_mensuales[$a]["comision_venta_nueva"] = 0;
				$ingresos_mensuales[$a]["ingresos_totales"] = 0;
			}
		}

		$metaM=array();
		$validador=array();
		$arreglo = array();

		for($i=1; $i<13;$i++){
			foreach($_obtenerMetasMensuales as $meses){
				
				if($i == $meses->mes){
					$arreglo["venta_nueva"][$meses->mes]["monto_mes"]=$meses->montoMes;
					$arreglo["venta_nueva"][$meses->mes]["comision_venta_nueva"] = $ingresos_mensuales[$meses->mes]["comision_venta_nueva"];
					$arreglo["venta_nueva"][$meses->mes]["comision_ingreso_total"] = $ingresos_mensuales[$meses->mes]["ingresos_totales"];
					array_push($validador,$meses->mes);
				}
			}
			if(!in_array($i,$validador)){
				$arreglo["venta_nueva"][$i]["monto_mes"] = 2500;
				$arreglo["venta_nueva"][$i]["comision_venta_nueva"] = $ingresos_mensuales[$i]["comision_venta_nueva"]; //1;
				$arreglo["venta_nueva"][$i]["comision_ingreso_total"] = $ingresos_mensuales[$i]["ingresos_totales"]; //1;
			}
		}

		//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($arreglo, TRUE));fclose($fp);

		return $arreglo;
	}
	//---------------------------------------- Dennis Castillo 2021-09-24
	function generateStyle($category){

		$style = array();
		switch($category){
			case "autos": $style["background"] = "rgba(237, 187, 153, 0.7)"; $style["border"] = "rgba(237, 187, 153)"; $style["icon"] = "fa fa-car";
			break;
			case "daños": $style["background"] = "rgba(236, 112, 99, 0.7)"; $style["border"] = "rgba(236, 112, 99)"; $style["icon"] = "fa fa-ambulance";
			break;
			case "vida": $style["background"] = "rgba(52, 152, 219, 0.7)"; $style["border"] = "rgba(52, 152, 219)"; $style["icon"] = "fa fa-heartbeat";
			break;
			case "GMM": $style["background"] = "rgba(211, 84, 0, 0.7)"; $style["border"] = "rgba(211, 84, 0)"; $style["icon"] = "fa fa-user-md";
			break;
			case "fianzas": $style["background"] = "rgba(46, 204, 113, 0.7)"; $style["border"] = "rgba(46, 204, 113)"; $style["icon"] = "fa fa-money";
			break;
			case "profesional": $style["background"] = "rgba(86, 101, 115, 0.7)"; $style["border"] = "rgba(86, 101, 115)"; $style["icon"] = "fa fa-certificate";
			break;
		}

		return $style;
	}
	//---------------------------------------- Dennis Castillo 2021-09-24
	function getDatesAndHours(){

		$idPersona = $_GET["i"];
		//$parameter = $_GET["a"];
		//$training = $_GET["b"];
		//$subtraining = $_GET["c"];
		$response_ = array();
		$myTraining = $this->capacita_modelo->devuelveInformacionDeCapacitacion($idPersona);

		foreach($myTraining as $info){

			$response_[$info->tipoCapacitacion][$info->nombreCertificado][$info->nombre_ramo][] = array(
				"registerDate" => $info->fecha,
				"hours" => $info->horas,
				"type" => $info->tipoRegistro,
				"content" => $this->getContentFromType($info->tipoRegistro, $info->idRegistro),
			);
		}

		//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($response_, TRUE));fclose($fp);

		echo json_encode($response_);
	}
	//---------------------------------------- Dennis Castillo 2021-09-24
	function getContentFromType($type, $register){

		//$result_ = array();

		switch($type){
			case "interno": return $this->capacita_modelo->devuelveResponsables($register);
			break;
			case "externo": return $this->capacita_modelo->obtenerArchivosDeCapacitacion($register);
			break;
		}

	}
	//---------------------------------------- //Dennis Castillo [2022-06-28]
	function getHolydays(){
		
		try{

			$vacationPermission = array_filter($this->personamodelo->getMyPermissions($this->tank_auth->get_idPersona()), function($arr){
				return $arr->idLlavePermiso == "vacacionesLibres";
			});
			$myDates = $this->getDateDataFromMyRecord($this->tank_auth->get_idPersona());
			$weekendsAndHolydays = $this->getBlackoutDates();
			$datesAfterRequest = $this->getDatesAfterRequest($this->tank_auth->get_idPersona(), !empty($vacationPermission));
			
			echo json_encode(array(
				"holydays" => array_map(function($arr){ return date("n-j", $arr); }, $weekendsAndHolydays["holydays"]), 
				"interval" => empty($vacationPermission) ? $weekendsAndHolydays["interval"] : array(), 
				"periodChange" => $myDates["dayAndMonthLimit"],
				//"afterRequest" => array_map(function($arr){ return date("n-j", $arr); }, $datesAfterRequest["afterRequest"]),
				"vacations" => array_map(function($arr){ return date("Y-n-j", $arr); }, $datesAfterRequest["vacations"]),
				"datedDB" => $datesAfterRequest["dateddb"],
				"initialDayForQuery" => $weekendsAndHolydays["initialDayForQuery"]
			));
		} catch(Exception $e){
			echo "Excepción capturada: ".$e->getMessage();
		}
	}
	//---------------------------------------- //Dennis Castillo [2022-06-28]
	function getDatesAfterRequest($person, $applyPastPeriod){
		
		$response = array();
		$period = $this->personamodelo->getWorkStartPeriod($person);
		$applyPeriod = !$applyPastPeriod ? "AND antiguedad = ".(!empty($period) ? $period->anio : 0) : "";
		$dates = $this->capitalhumano->getVacationsRecords("idPersona = ".$this->tank_auth->get_idPersona()." ".$applyPeriod." AND YEAR(fecha_retorno) >= ".date("Y")." AND MONTH(fecha_retorno) >= ".date("n")." AND aprobado IN (0, 1)");
		$weekendsAndHolydays = $this->getBlackoutDates();
		//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r(array("valid" => $dates), TRUE));fclose($fp);
		$intervals = array();
		$vacations = array();

		if(!empty($dates)){

			foreach($dates as $dd){
			
				$if_date = new DateTime($dd->fecha_retorno);
				$ff_date = new DateTime($dd->fecha_retorno);
				$ff_date = $ff_date->modify("+ 1 month");
				$countAfterRequest = 0;
				
				//Contabiliza 15 días despues de solicitar vacaciones.
				for($a = strtotime($if_date->format("Y-m-d")); $a <= strtotime($ff_date->format("Y-m-d")); $a += 86400){
	
					if(!in_array(date("N", $a), array(6, 7)) && $countAfterRequest < 15){
						array_push($intervals, $a); //date("n-j", $a)
						$countAfterRequest ++;
					}
				}

				for($a = strtotime($dd->fecha_salida); $a < strtotime($dd->fecha_retorno); $a += 86400){
	
					if(!in_array(date("N", $a), array(6, 7)) && !in_array($a, $weekendsAndHolydays["holydays"])){
						array_push($vacations, $a); //date("n-j", $a)
					}

					/*if(!in_array($a, $weekendsAndHolydays["holydays"])){
						array_push($vacations, $a); //date("n-j", $a)
					}*/
				}
			}
		}

		//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r(array("valid" => $vacations), TRUE));fclose($fp);
		$response["afterRequest"] = $intervals;
		$response["vacations"] = $vacations; //dates
		$response["dateddb"] = $dates; //dates

		return $response;
	}
	//---------------------------------------- //Dennis Castillo [2022-06-28]
	function getBlackoutDates(){

		$intervals = array();
		$countInterval = 0;
		$lastIntervalDate = "";
		$initialDate = new DateTime("NOW");
		$finalDate = new DateTime("NOW"); //+1 month
		$finalDate = $finalDate->modify("+1 month");

		$holydays = $this->capitalhumano->getHolydays(array("YEAR(diaNoLaboral) >=" => date("Y")));
		$filtered = array_reduce($holydays, function($acc, $curr){ //Contabiliza los días de descanso obligatorio.

			if(!in_array(strtotime($curr->diaNoLaboral), $acc)){
				 array_push($acc, strtotime($curr->diaNoLaboral)); //date("n-j", strtotime($curr->diaNoLaboral))
			}

			return $acc;
		}, array());

		//Contabiliza 15 dias de anticipación para pedir vacaciones.
		/*for($a = strtotime($initialDate->format("Y-m-d")); $a <= strtotime($finalDate->format("Y-m-d")); $a += 86400){

			if(!in_array(date("N", $a), array(6, 7)) && $countInterval < 15){
				array_push($intervals, $a); //date("n-j", $a)
				$countInterval ++;
			}
		}*/
		
		return array(
			"initialDateForQuery" => date("Y-m-d", end($intervals)),
			"holydays" => $filtered,
			"interval" => array_map(function($arr){ return date("Y-n-j", $arr); }, $intervals),
			"initialDayForQuery" => date("n-j", end($intervals)),
		);
	}
	//---------------------------------------- //Dennis Castillo [2022-06-28]
	function getDateDataFromMyRecord($idPersona){

		$test = array();
		$response = array();
		$countFromLimit = 0;
		$getInitialDate = $this->personamodelo->getFechaIngreso($idPersona);

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
	//-------------------------- //Dennis Castillo [2022-06-28]
	function getAvailableDates($i, $f){

		$response["dates"] = array();
		$response["countDays"] = 0;
		$response["canRequestVacation"] = false;
		//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r(array($i, $f), TRUE));fclose($fp);
		$id = new DateTime($i);
		$fd = new DateTime($f);
		$times = array();

		for($a = strtotime($id->modify(" + 1 day")->format("Y-m-d")); $a <= strtotime($fd->modify(" - 1 day")->format("Y-m-d")); $a += 86400){

			if(!in_array(date("N", $a), array(6, 7))){
				array_push($times, $a);
				$response["countDays"] ++;
			}
		}

		//$response["canRequestVacation"] = $response["countDays"] > 0;
		$response["dates"]["fullDates"] = array_map(function($arr) { return date("Y-m-d", $arr); }, $times);
		$response["dates"]["noYear"] = array_map(function($arr) { return date("n-j", $arr); }, $times);
		return $response;
	}
	//---------------------------------------- Miguel Avila
	function getEvalPosteriores(){
		$this->load->model('evaluacion_periodos_model', 'periodo');
		$usuario= $this->input->post('usuario');
		$tipo_evaluacion= $this->input->post('tipo_evaluacion');
		$seguimiento= $this->input->post('seguimiento');
		$data=$this->periodo->getEvalPosterior($usuario,$tipo_evaluacion,$seguimiento);
		$this->load->view("evaluaciones/personas/evaluaciones_pendientes",array("evaluaciones_pendientes"=>$data,"id"=>$this->tank_auth->get_idPersona()));
		//echo json_encode($html);
	}
	//---------------------------------------- 
}

/* End of file miInfo.php */
/* Location: ./application/controllers/miInfo.php */
