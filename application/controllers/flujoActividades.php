<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class flujoActividades extends CI_Controller
{
	private $quitarSicas = array('<p>', '</p>', '<br />', ',');
	private $ponerSicas = array('', '', '\n\r', ''); 
	function __construct()
	{
		parent::__construct();    
		$params['id_sicas'] = $this->tank_auth->get_IDUserSICAS(); "get_IDUserSICAS";
		$params['user_sicas'] = $this->tank_auth->get_UserSICAS(); "get_UserSICAS";
		$params['pass_sicas'] = $this->tank_auth->get_PassSICAS(); "get_PassSICAS";
		$this->load->library('Ws_sicasdre',$params);
		$this->load->library('Ws_sicas');

		$this->load->helper('ckeditor');
		$this->load->model('capsysdre_actividades');
		$this->load->library(array("webservice_sicas_soap","role"));
	}


	function index()
	{  
		if (!$this->tank_auth->is_logged_in()){
			redirect('/auth/login/');
		} else {
			$this->load->view('reportes/flujoActividades'); 
		}
	}/* !index */
	
	function traeDatos()
	{
    	if (!$this->tank_auth->is_logged_in()){
			redirect('/auth/login/');
		} else {
			if($this->input->post('fIni')=='' or $this->input->post('fFin')==''){
				$datos["mensaje"]="requiere fecha para la consulta";//$this->input->post('f_Ini');
				$this->load->view('reportes/cobranzaEfectuada',$datos); 
			} else {
				$fecha					= $this->input->post('fIni');
				$fec					= explode("/",$fecha);
				list($dia,$mes,$anio)	= $fec;
				$fechaCon1				= $dia."-".$mes."-".$anio;
				$fechaI					= date("d-m-y", strtotime($fechaCon1));
				$fecha					= $this->input->post('fFin');
				$fec					= explode("/",$fecha);
				list($dia,$mes,$anio)	= $fec;     
				$fechaCon2				= $dia."-".$mes."-".$anio;
				$fechaF					= date("d-m-y",strtotime($fechaCon2));
				
				$vendedor				= $this->tank_auth->get_IDVend();
				$xml					= $this->ws_sicas->obtenerReporteCobranza($vendedor,$fechaI,$fechaF,3);
				$contador				= 0;
				$contador				= $xml->TableControl->MaxRecords;
				
				if($contador>1){
					$xml->addChild('fecFin', $this->input->post('fFin'));
					$xml->addChild('fecIni', $this->input->post('fIni'));
					$this->load->view('reportes/cobranzaEfectuada',$xml);
				} else { 
					$x['fecFin']		= $this->input->post('fFin');
					$x['fecIni']		= $this->input->post('fIni');
					$x['TableInfo']		= $xml->TableInfo;
					$x['TableControl']	= $xml->TableControl;
					$this->load->view('reportes/cobranzaEfectuada',$x );
				}
			}
		}
	}/* !traeDatos */

	function traeArchivos()
	{
		try{    
			$idDocto	= $_REQUEST["IDDocto"];
			$data		= array(
							"IDDocto" => $idDocto
						  );

			$this->load->library("webservice_sicas_soap");
			$data_result	= $this->webservice_sicas_soap->GetCDDigital($data);
			
			echo json_encode($data_result);
		} catch(Exception $e) {

		}
	}/* !traeArchivos */
	
	function traeArchivosBit()
	{
		$claveBit = "";
		
		if($_REQUEST["claveBit"] != null){
			$claveBit	= $_REQUEST["claveBit"];
			$sPage		= 0;
			
			if($sPage > 0){
				$sPage	= ($sPage / 10) + 1;
			} else {
				$sPage	= 1;
			}
			
			$data_body	= array('claveBit' => $claveBit, 'page'=>$sPage );
			$data		= $this->webservice_sicas_soap->GetInfoBit($data_body);

			if($data != null){
				$json	= json_encode($data);
				$array	= json_decode($json, TRUE);
				echo json_encode($array);

			} else {
				echo json_encode(
									array(
										'data'=>$tb_infoBit,
										'recordsTotal'=>'0',
										'recordsFiltered'=> 0
									)
								);
			}
		}
	}/* !traeArchivosBit */
	
	function consultaDatos()
	{
    	if (!$this->tank_auth->is_logged_in()){
			redirect('/auth/login/');
		} else {
			if($this->input->post('fIni')=='' or $this->input->post('fFin')==''){
				$datos["mensaje"]="requiere fecha para la consulta";//$this->input->post('f_Ini');
				$this->load->view('reportes/flujoActividades',$datos); 
			} else {
				$fecha					= $this->input->post('fIni');
				$fec					= explode("/",$fecha);
				list($dia,$mes,$anio)	= $fec;
				$fechaCon1				= $anio."-".$mes."-".$dia;
				$fechaI					= date("d-m-y", strtotime($fechaCon1));
				$fecha					= $this->input->post('fFin');
				$fec					= explode("/",$fecha);
				list($dia,$mes,$anio)	= $fec;     
				$fechaCon2				= $anio."-".$mes."-".$dia;
				$fechaF					= date("d-m-y",strtotime($fechaCon2));
				$vendedor				= $this->tank_auth->get_IDVend();
				
				$sqlConsulta = "
					Select
						`Status_Txt`
					From
						`actividades`
					Where
						`fechaCreacion` Between '".$fechaCon1."' AND '".$fechaCon2."'
						And
						(`Status_Txt` != 'FINALIZADA' and `Status_Txt` != 'POSPUESTA')
					Group By
						`Status_Txt`
					Order By
						`Status_Txt` Asc
					;
							   ";
				$queryConsulta	= $this->db->query($sqlConsulta);
				$contIndice = 0;
				$TableInfo = array();
				
				foreach($queryConsulta->result() as $status){
				
					array_push($TableInfo, array("status"=>$status->Status_Txt));
				
					$sqlActividades = "
						Select
							`actividades`.`folioActividad`,
							`actividades`.`Status_Txt`,
							`actividades`.`SubRamoActividad`,
							`actividades`.`usuarioCreacion`,
							`actividades`.`nombreUsuarioCreacion`,
							`actividades`.`fechaCreacion`,
							`actividades`.`fechaActualizacion`,
							`actividades`.`tipoActividad`,
							DATEDIFF( NOW(),`actividades`.`fechaCreacion`) AS `diasPasadosCreacion`,
							DATEDIFF( NOW(),`actividades`.`fechaActualizacion`) AS `diasPasadosActualizacion`
						From 
							`actividades`
						Where
							`fechaCreacion` Between '".$fechaCon1."' AND '".$fechaCon2."'
							And
							`Status_Txt` = '".$status->Status_Txt."'
						;
									  ";
					$queryActividades	= $this->db->query($sqlActividades);
					
					$asegu = "";
					
					foreach($queryActividades->result() as $actividades){
						
						if($actividades->Status_Txt == "ASEGURADORA"){
							$sqlAseguradoras = 	"
										Select
											`catalog_promotorias`.`Promotoria` As `aseguradora`
										From
											`actividades` INNER JOIN `relactividadpromotoria`
											on
											`actividades`.`folioActividad` = `relactividadpromotoria`.`folioActividad` INNER JOIN `catalog_promotorias`
											on
											`relactividadpromotoria`.`idPromotoria` = `catalog_promotorias`.`idPromotoria`
										Where
											`actividades`.`folioActividad` = '".$actividades->folioActividad."'
										Order By
											`catalog_promotorias`.`Promotoria` Asc
										;
												";
							$queryAseguradoras	= $this->db->query($sqlAseguradoras);
							foreach($queryAseguradoras->result() as $aseguradoras){
								$asegu.= "<br />&bull; ".$aseguradoras->aseguradora;
							}
						}
						
						$TableInfo[$contIndice]['StatusDatos'][] = 
																	array(
																		"folioActividad" 			=> $actividades->folioActividad,
																		"Status_Txt"				=> $actividades->Status_Txt,
																		"SubRamoActividad"			=> $actividades->SubRamoActividad,
																		"usuarioCreacion"			=> $actividades->usuarioCreacion,
																		"nombreUsuarioCreacion"		=> $actividades->nombreUsuarioCreacion,
																		"fechaCreacion"				=> $actividades->fechaCreacion,
																		"fechaActualizacion"		=> $actividades->fechaActualizacion,
																		"tipoActividad"				=> $actividades->tipoActividad,
																		"diasPasadosCreacion"		=> $actividades->diasPasadosCreacion,
																		"diasPasadosActualizacion"	=> $actividades->diasPasadosActualizacion,
																		"aseguradoras"				=> $asegu,
																	);
					}
				$contIndice++;
				}

				$this->data['fecIni']		= $this->input->post('fIni');
				$this->data['fecFin']		= $this->input->post('fFin');
				$this->data['TableInfo']	= $TableInfo;

				//echo "<pre>";
					//print_r($this->data);
					//print_r($this->data['TableInfo'][0]['StatusDatos']);
				//echo "</pre>";
				
				$this->load->view('reportes/flujoActividades',$this->data );
			}
		}
	}/* !consultaDatos */

}