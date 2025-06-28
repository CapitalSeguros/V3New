<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class reportes extends CI_Controller{
	//var $datosEF="";
	var $datosEF=array();
	var $meses;
	var $coordinador=null;
	function __construct(){
				
		parent::__construct();
		$this->meses = 
		array(
			'Enero',
			'Febrero',
			'Marzo',
			'Abril',
			'Mayo',
			'Junio',
			'Julio',
			'Agosto',
			'Septiembre',
			'Octubre',
			'Noviembre',
			'Diciembre',
		);
		$this->load->library(array("webservice_sicas_soap","role"));	
		$this->load->library("libreriav3");
		$this->load->model(array("catalogos_model","capsysdre_actividades","reportes_model"));	
		$this->load->model('cuadromando_model');
		$this->load->model('personamodelo');
		$this->load->model('metacomercial_modelo');
        $this->load->model('reportepresupuestomodel');
		$this->load->model("crmproyecto_model");
		$this->load->model("capacita_modelo");
		$this->load->model("procesamientoncmodel");
		$this->load->model("graficas_model");
		$this->load->model('contabilidadmodelo');
		$this->load->model("funnelM");
		$this->load->library('Ws_sicas');
		if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');}

	}
	
	public function exportReport(){

		$reports = $this->reportes_model->getBitReporte();

		if(!empty($reports)){
			$reports = $reports[0];
			$this->reportes_model->updateBitReporte($reports['id'],1);
			$reportDetails = $this->reportes_model->getBitReporteDetalle($reports['id']);

			if(count($reportDetails) <= $reports['totalPaginas']){

				$data_report = json_decode($reports['parametros'],true);
				$page = 0;

				if(count($reportDetails) == 0)
					$page = 1;
				else{
					$page = count($reportDetails);
				}

				$pageLimit = (($page + 10) < $reports['totalPaginas'])? ($page + 10) : $reports['totalPaginas'];
				$skey = $data_report['TypeReporte'];
				$data_report['ItemforPage'] = 1000;


				for ($i= $page; $i <= $pageLimit; $i++) { 

					$tb_renovacion = array();
					$data_report['page'] = $i;

					if($skey == 'cli'){

					 	$data_client = $this->webservice_sicas_soap->GetReportJob($data_report);

					 	
					 	if($data_client['reporte'] != null){
					 								
						 	foreach ($data_client['reporte'] as $value) {
							 	$item = new \stdClass;

						 		$item->IDCli =  $this->getValue($value->IDCli);
						 		$item->Nombre = $this->getValue($value->NombreCompleto);
						 		$item->RFC = $this->getValue($value->RFC);
						 		$item->Telefono1 = $this->getValue($value->Telefono1);
						 		$item->Correo = $this->getValue($value->EMail1);
						 		$item->Direccion = $this->getValue($value->Calle).' '.$this->getValue($value->NOExt).' '.$this->getValue($value->NOInt).' '.$this->getValue($value->Colonia);
					 			array_push($tb_renovacion, $item);
						 	}
					 	}


					}else{
						$data_client =$this->webservice_sicas_soap->GetReportJob($data_report);	

						if(isset($data_client['paginacion']['MaxRecords'])){
		 		 		
			 		 		foreach ($data_client['reporte'] as $value) {
							 	$item = new \stdClass;

						 		$item->TipoDocto =  $this->getValue($value->TipoDocto_TXT);
						 		$item->Documento = $this->getValue($value->Documento);
						 		if($skey == 'cobp' || $skey == 'cobe' || $skey == 'cobc' ){
						 			$item->Serie = $this->getValue($value->Serie);
						 		}
						 		$item->DAnterior = $this->getValue($value->DAnterior);
						 		$item->DPosterior = $this->getValue($value->DPosterior);

						 		if ($skey == "ren" || $skey == 'pro'){
						 			$item->FDesde = $this->formatDate($this->getValue($value->FDesde));
						 		}else{
						 			$item->FDesde = $this->formatDate($this->getValue($value->FLimPago));
						 		}																

						 		$item->FHasta = $this->formatDate($this->getValue($value->FHasta));
						 		$item->Status = $this->getValue($value->Status_TXT);
						 		$item->NombreCompleto = $this->getValue($value->NombreCompleto);
						 		$item->Grupo = $this->getValue($value->Grupo);
						 		$item->SubGrupo = $this->getValue($value->SubGrupo);
						 		$item->Concepto = $this->getValue($value->Concepto);
						 		$item->Referencia1 = $this->getValue($value->Referencia1);
						 		$item->Referencia2 = $this->getValue($value->Referencia2);
						 		$item->FolioNo = $this->getValue($value->FolioNo);
						 		$item->Moneda = $this->getValue($value->Moneda);
						 		$item->FPago = $this->getValue($value->FPago);
						 		$item->CAgente = $this->getValue($value->CAgente);
						 		$item->AgenteNombre = $this->getValue($value->AgenteNombre);
						 		$item->SRamoAbreviacion = $this->getValue($value->SRamoAbreviacion);
						 		$item->PrimaNeta = $this->formatMoney($this->getValue($value->PrimaNeta));
						 		$item->PrimaTotal = $this->formatMoney($this->getValue($value->PrimaTotal));
						 		$item->EjecutNombre = $this->getValue($value->EjecutNombre);
						 		$item->VendNombre = $this->getValue($value->VendNombre);
						 		// $oDocto = $this->webservice_sicas_soap->GetPolicy_forID_Docto($value->IDDocto);
						 		$item->ClaveBit = $this->getValue($value->ClaveBit);
						 		$item->RamosNombre = $this->getValue($value->RamosNombre);
						 		$item->IDDocto = $this->getValue($value->IDDocto);

						 		array_push($tb_renovacion, $item);
						 	}
					 	}
					}

					$this->reportes_model->addReporteDetalle($reports['id'],$i,json_encode($tb_renovacion));
				}
				
				if($pageLimit == $reports['totalPaginas']){
					$this->reportes_model->updateBitReporte($reports['id'],2);
					$this->reportes_model->updateReporteStatus($reports['id'],100);
				}else{
					$this->reportes_model->updateReporteStatus($reports['id'],(($pageLimit/$reports['totalPaginas'])*100));
				}
			}
		
}		//$data["titulo_pa"g] = "Reportes";
		$this->load->view('actualizaInformacion/actualizarClienteVendedores',$data);
	}

	public function descarReporte($consultar){

		//$consultar = $this->input->post('consultar',true);
		$consultar = urldecode($consultar);

		if($consultar != ""){

			$skey = "";
			$typeR = 0;
			switch ($consultar) {
				case 'Renovacin':
					$skey = 'ren';
					$typeR = 0;
				break;
				case 'Produccin':
					$skey = 'pro';
					$typeR = 1;
				break;
				case 'Cobranza Pendiente':
					$skey = 'cobp';
					$typeR = 2;
				break;
				case 'Cobranza Efectuada':
					$skey = 'cobe';
					$typeR = 3;
				break;
				case 'Cobranza Cancelada':
					$skey = 'cobc';
					$typeR = 4;
				break;
				case 'Buscador Clientes':
					$skey = 'cli';
					$typeR = 5;
				break;
			}
			$userID = $this->tank_auth->get_user_id();

			$res = $this->reportes_model->reportActive($userID,$typeR);
			if(count($res) > 0){

				$res = $res[0];
				$reportDetails = $this->reportes_model->getBitReporteDetalle($res['id']);
				$allReportes = array();
				foreach ($reportDetails as $value) {
					$tmp = json_decode($value['valor'],true);
					$allReportes = array_merge($allReportes,$tmp);
				}

				 // file name for download
			    $fileName = "capSys" . date('Ymdhis') . ".xls";
			    
			    // headers for download
			    header("Content-Disposition: attachment; filename=\"$fileName\"");
			    header("Content-Type: application/vnd.ms-excel");
			    
			    $flag = false;
			    foreach($allReportes as $row) {
			        if(!$flag) {
			            // display column names as first row
			            echo implode("\t", array_keys($row)) . "\n";
			            $flag = true;
			        }
			        // filter data
			        array_walk($row, array($this,'filterData'));
			        echo implode("\t", array_values($row)) . "\n";

			    }
			    exit;
				//echo json_encode(array('data'=>$allReportes));
			}
	    }

	}

	public function reportStatus(){

		$result = new \stdClass;
		$result->status = false;
		$result->message = "Error al realizar la operación";
		$result->code = 'BAD';
		$consultar = $this->input->post('consultar',true);

		if($consultar != ""){
			if($consultar == null || $consultar == ""){
				echo json_encode(array('data' => $result));
				return;
			}

			$skey = "";
			$typeR = 0;
			switch ($consultar) {
				case 'Renovacin':
					$skey = 'ren';
					$typeR = 0;
				break;
				case 'Produccin':
					$skey = 'pro';
					$typeR = 1;
				break;
				case 'Cobranza Pendiente':
					$skey = 'cobp';
					$typeR = 2;
				break;
				case 'Cobranza Efectuada':
					$skey = 'cobe';
					$typeR = 3;
				break;
				case 'Cobranza Cancelada':
					$skey = 'cobc';
					$typeR = 4;
				break;
				case 'Buscador Clientes':
					$skey = 'cli';
					$typeR = 5;
				break;
			}

			
			$userID = $this->tank_auth->get_user_id();
			$res = $this->reportes_model->reportActive($userID,$typeR);

			if(count($res) > 0){
				$res = $res[0];

				if($res['status'] == 2){
					$result->status = true;
					$result->message = "El reporte se genero con exito ¿Desea descargarlo?";
					$result->percentage = $res['porcentaje'];
					$result->code = 'OK';

					$this->reportes_model->updateReportDownload($userID,$typeR);
				}else{
					$result->status = true;
					$result->message = "Se está generando el reporte.";
					$result->percentage = $res['porcentaje'];	
					$result->code = 'WAIT';
				}				
			}else{
				$result->message = "No existe información del reporte seleccionado";
			}

		}

		echo json_encode(array('data' => $result));
		return;
	}

	public function existReportActive($consultar){
		$result = false;

		if($consultar == null || $consultar == "")
			return $result;

		$skey = "";
		$typeR = 0;
		switch ($consultar) {
			case 'Renovacin':
				$skey = 'ren';
				$typeR = 0;
			break;
			case 'Produccin':
				$skey = 'pro';
				$typeR = 1;
			break;
			case 'Cobranza Pendiente':
				$skey = 'cobp';
				$typeR = 2;
			break;
			case 'Cobranza Efectuada':
				$skey = 'cobe';
				$typeR = 3;
			break;
			case 'Cobranza Cancelada':
				$skey = 'cobc';
				$typeR = 4;
			break;
			case 'Buscador Clientes':
				$skey = 'cli';
				$typeR = 5;
			break;
		}

		$userID = $this->tank_auth->get_user_id();
		$res = $this->reportes_model->existReportActive($userID,$typeR);

		if(count($res) > 0){
			$result = true;
		}
		return $result;
	}
	
	function index(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$data['Ramo']		= $this->catalogos_model->get_Ramos();	
			//$data['SubRamo']	= $this->catalogos_model->get_SubRamos();
			$data['Grupo']		= $this->catalogos_model->get_Grupos();
			$data['vendedor']	= $this->catalogos_model->get_Vendedor($this->tank_auth->get_IDVend(),$this->tank_auth->get_IDVendNS());
			$data['promotor']	= $this->catalogos_model->get_Promotor($this->tank_auth->get_IDVend(),$this->tank_auth->get_IDVendNS());
			
			$this->load->view('reportes/principal', $data);
		}
	}/*! index */
	
	function getVendedor(){
		if($_REQUEST["IDVend"] != null){
			$ID = $_REQUEST["IDVend"];
			if($ID > 0){
				$data['Vendedor'] = $this->catalogos_model->get_Vendedor($ID,$ID);
			}else{
				$data['Vendedor'] = $this->catalogos_model->get_Vendedor($this->tank_auth->get_IDVend(),$this->tank_auth->get_IDVendNS());
			}
			echo json_encode($data['Vendedor']);
		}
	}/*! getVendedor */
	
	function getSubRamo(){
		if($_REQUEST["IDRamo"] != null){
			$ID					= $_REQUEST["IDRamo"];
			$data['SubRamo']	= $this->catalogos_model->get_SubRamos($ID);
			echo json_encode($data['SubRamo']);
		}
	}/*! getSubRamo */
	
	function getSubGrupos(){
		if($_REQUEST["IDGrupo"] != null){
			$ID = $_REQUEST["IDGrupo"];
			$data['SubGrupo'] = $this->catalogos_model->get_SubGrupos($ID);
			echo json_encode($data['SubGrupo']);
		}
	}/*! getSubGrupos */

	function _getMeses($nMes){
		$tmpMonth	= array();
		$star		= 0;
		$end		= 12;
		//$anio		= (date("y")-1); //año 2016
		$anio		= date("y"); //año 2017
		if($nMes >= 0){

			for($star=0; $star < $end  ; $star++){
				$tmpMonth[$nMes.'_'.$anio] = $this->meses[$nMes].'-'.$anio;

				if($nMes == 5){
                  $anio		= (date("y")-1);    
                 }
				if($nMes == 11){
					$nMes	= 0;
					$anio++;
				} else {
					$nMes ++;
				}
			}
		}
		return $tmpMonth;
	}/*! _getMeses */
	
	function formatDate($date){
		$tmpDate	= new DateTime($date);
		return $tmpDate->format('Y/m/d');
	}/*! formatDate */
	
	function formatMoney($num){
		return '$ '.number_format((Double)$num, 2, '.', ',');
	}/*! formatMoney */
	
	function formatStatusVend($Status){
		$Status_TXT = "Litu";
		if($Status == 0){
			$Status_TXT = "ACTIVO";
		} else if($Status == 1){
			$Status_TXT = "INACTIVO";
		} else if($Status == 2){
			$Status_TXT = "SUSPENDIDO";
		}
		
		return
			$Status_TXT;
		
	}/*! formatStatus */

  	function filterData(&$str){
		$str = preg_replace("/\t/", "\\t", $str);
		$str = preg_replace("/\r?\n/", "\\n", $str);
		if(strstr($str, '"')){
			$str = '"'.str_replace('"', '""', $str).'"';
		}
    }/*! filterData */

	function object_to_array($obj){
		if(is_object($obj)){
			$obj = (array) $obj; 
		}
		if(is_array($obj)){
			$new = array();
			foreach($obj as $key => $val){
				if(is_object($val)){
	        		$new[$key] = ' ';
				} else {
	        		$new[$key] = $val;
				}
			}
	    } else {
			$new = $obj;
		}
	    return $new;       
	}/*! object_to_array */

	function getPolicyforIDCli(){
		if($_REQUEST["IDCli"] != null ){

			$sPage = $this->input->post("start");
			if($sPage > 0){
				$sPage = ($sPage / 10) + 1;	
			}else{
				$sPage = 1;
			}

			$posCol = intval($_POST['order'][0]['column']);
	 		$colDir = $_POST['order'][0]['dir'];

			$colsPolicy = array();

			$colsPolicy[] = 'Status_TXT';
	 		$colsPolicy[] = 'VDatDocumentos.Documento';
	 		$colsPolicy[] = 'VDatDocumentos.FDesde';
	 		$colsPolicy[] = 'VDatDocumentos.FHasta';
			$colsPolicy[] = 'VCatVendedores.VendNombre';
	 		$colsPolicy[] = 'VCatSRamos.Nombre';
	 		$colsPolicy[] = 'VCatAgentes.AgenteNombre';
	 		// $colsPolicy[] = 'VCatFPagos.Nombre';
	 		$colsPolicy[] = 'VDatDocumentos.SubGrupo';
	 		$colsPolicy[] = 'VDatDocumentos.PrimaNeta';
	 		$colsPolicy[] = 'VDatDocumentos.PrimaTotal';


 			$seardd = json_decode($this->input->post("search_d",TRUE));
 			$sExtraFilter = "";
 			$data_policy = array('idCli' => $_REQUEST["IDCli"],'page'=>$sPage);
 			if(is_array($seardd) || is_object($seardd)){

 				foreach ($seardd as $key => $row) {

 					$pKey = intval($row->id );
	 				$sKess = $colsPolicy[$pKey ];
	 				if($row->type == "date"){
	 					$sExtraFilter .= "TableFilter;0;0;".$row->val.";".$row->val.";".$sKess." ! ";
	 				}else{
	 					$sExtraFilter .= "TableFilter;0;0;*".$row->val."*;".$row->val.";".$sKess." ! ";	
	 				}
	 				
	 			}
	 			if($sExtraFilter != ""){
	 				$data_policy['ExtraFilter'] = $sExtraFilter;
	 			}
 			}

			
			if($posCol > 0)
	 			$data_policy['Sort'] = $colsPolicy[$posCol].' '.$colDir;

	 		$data_policy['ItemForPage'] = 10;
	 		
			$tb_policy = array();
			$data_result = $this->webservice_sicas_soap->GetPolicy_forClient($data_policy);
			if($data_result != null){


				
				foreach ($data_result->TableInfo as $value) {
					$item = new \stdClass;

			 		$item->Status =  $this->getValue($value->Status_TXT);
			 		$item->Documento = $this->getValue($value->Documento);
			 		$item->FDesde = $this->formatDate($this->getValue($value->FDesde));
			 		$item->FHasta = $this->formatDate($this->getValue($value->FHasta));
					$item->VendNombre = $this->getValue($value->VendNombre);
			 		$item->IDSRamo = $this->getValue($value->SRamoNombre);
			 		$item->IDAseg = $this->getValue($value->AgenteNombre);
			 		$item->IDFPago = $this->getValue($value->FPago);
			 		$item->IDSSGrupo = $this->getValue($value->SubGrupo);
			 		$item->PrimaNeta = $this->formatMoney($this->getValue($value->PrimaNeta));
			 		$item->PrimaTotal = $this->formatMoney($this->getValue($value->PrimaTotal));

			 		array_push($tb_policy, $item);	
				}

				echo json_encode(array(
					'data'=>$tb_policy,
					'recordsTotal'=>$this->getValue($data_result->TableControl->MaxRecords),
					'recordsFiltered'=> $this->getValue($data_result->TableControl->MaxRecords)));	
			}else{
				echo json_encode(array(
					'data'=>$tb_policy,
					'recordsTotal'=> '0',
					'recordsFiltered'=> '0'));
			}

		}
	}

	function getPolicyforIDCliExcel(){
		if($_REQUEST["IDCli"] != null ){

			$page = 1;
			$pages = 1;
			$tb_policy = array();

			do{

				$data_policy = array('idCli' => $_REQUEST["IDCli"],'page'=>$page);

				$data_result = $this->webservice_sicas_soap->GetPolicy_forClient($data_policy);
				if($data_result != null){

					if(isset($data_result->TableControl->Pages)){
						$pages = $data_result->TableControl->Pages;
					}

					foreach ($data_result->TableInfo as $value) {
						$item = new \stdClass;

				 		$item->Status =  $this->getValue($value->Status_TXT);
				 		$item->Documento = $this->getValue($value->Documento);
				 		$item->FDesde = $this->formatDate($this->getValue($value->FDesde));
				 		$item->FHasta = $this->formatDate($this->getValue($value->FHasta));
						$item->VendNombre = $this->getValue($value->VendNombre);
				 		$item->IDSRamo = $this->getValue($value->SRamoNombre);
				 		$item->IDAseg = $this->getValue($value->AgenteNombre);
				 		$item->IDFPago = $this->getValue($value->FPago);
				 		$item->IDSSGrupo = $this->getValue($value->SubGrupo);
				 		$item->PrimaNeta = $this->formatMoney($this->getValue($value->PrimaNeta));
				 		$item->PrimaTotal = $this->formatMoney($this->getValue($value->PrimaTotal));

				 		array_push($tb_policy, $item);	
					}
				}
				$page++;
			}while($page <= $pages);
			
			echo json_encode(array(
				'data'=>$tb_policy,
			));	

		}
	}

	function getValue($data){
		return isset($data) ? strval($data) : '';
	}

	function GetDoctoForID(){
		
		// $this->webservice_sicas($this->tank_auth->get_UserSICAS(),$this->tank_auth->get_PassSICAS());
		if($_REQUEST["idDocto"] != null){
			$Doct = $this->webservice_sicas_soap->GetPolicy_forID_Docto($_REQUEST["idDocto"]);
			$Clit = $this->webservice_sicas_soap->GetClient_forID($Doct->IDCli);

			$oRest = new \stdClass;
			$oRest->IDCli = $this->getValue($Doct->IDCli);
			$oRest->IDSRamo = $this->getValue($Doct->IDSRamo);
			$oRest->IDDocto = $this->getValue($Doct->Documento);
			$oRest->IDCont = $this->getValue($Clit['cliente']->IDCont);

			echo json_encode($oRest);
		}	
		
		//$this->load->view('reportes/GetDoctoForID', $data);
	
	}

	function GetPolizaAnt(){
		$Doc = $_POST['Documento'];
		$Tipo = $_POST['Consultar'];

		if(isset($Doc) && isset($Tipo)){
			$skey = '';
			switch ($Tipo) {
				case 'Renovacin':
					$skey = 'ren';
				break;
				case 'Produccin':
					$skey = 'pro';
					
				break;
				case 'Cobranza Pendiente':
					$skey = 'cobp';
				break;
				case 'Cobranza Efectuada':
					$skey = 'cobe';
					
				break;
				case 'Cobranza Cancelada':
					$skey = 'cobc';
				break;
			}

			$value = $this->webservice_sicas_soap->GetPolicy_forDocto($Doc);
			$item = new \stdClass;

			$item->TipoDocto =  $this->getValue($value->TipoDocto_TXT);
	 		$item->Documento = $this->getValue($value->Documento);
	 		if($skey == 'cobp' || $skey == 'cobe' || $skey == 'cobc' ){
	 			$item->Serie = $this->getValue($value->Serie);
	 		}
	 		$item->DAnterior = $this->getValue($value->DAnterior);
	 		$item->DPosterior = $this->getValue($value->DPosterior);

	 		if ($skey == "ren" || $skey == 'pro'){
	 			$item->FDesde = $this->formatDate($this->getValue($value->FDesde));
	 		}else{
	 			$item->FDesde = $this->formatDate($this->getValue($value->FLimPago));
	 		}																

	 		$item->FHasta = $this->formatDate($this->getValue($value->FHasta));
	 		$item->Status = $this->getValue($value->Status_TXT);
	 		$item->NombreCompleto = $this->getValue($value->NombreCompleto);
	 		$item->Grupo = $this->getValue($value->Grupo);
	 		$item->SubGrupo = $this->getValue($value->SubGrupo);
	 		$item->Concepto = $this->getValue($value->Concepto);
	 		$item->Referencia1 = $this->getValue($value->Referencia1);
	 		$item->Referencia2 = $this->getValue($value->Referencia2);
	 		$item->FolioNo = $this->getValue($value->FolioNo);
	 		$item->Moneda = $this->getValue($value->Moneda);
	 		$item->FPago = $this->getValue($value->FPago);
	 		$item->CAgente = $this->getValue($value->CAgente);
	 		$item->AgenteNombre = $this->getValue($value->AgenteNombre);
	 		$item->SRamoAbreviacion = $this->getValue($value->SRamoAbreviacion);
	 		$item->PrimaNeta = $this->formatMoney($this->getValue($value->PrimaNeta));
	 		$item->PrimaTotal = $this->formatMoney($this->getValue($value->PrimaTotal));
	 		$item->EjecutNombre = $this->getValue($value->EjecutNombre);
	 		$item->VendNombre = $this->getValue($value->VendNombre);
	 		// $oDocto = $this->webservice_sicas_soap->GetPolicy_forID_Docto($value->IDDocto);
	 		$item->ClaveBit = $this->getValue($value->ClaveBit);
	 		$item->RamosNombre = $this->getValue($value->RamosNombre);
	 		$item->IDDocto = $this->getValue($value->IDDocto);

			echo json_encode($item);
		}	
	}

	function GetInfoBit(){

		$claveBit = "";
		if($_REQUEST["claveBit"] != null){
			$claveBit = $_REQUEST["claveBit"];
			$sPage = $_REQUEST["start"];
			if($sPage > 0){
				$sPage = ($sPage / 10) + 1;	
			}else{
				$sPage = 1;
			}
			$data_body = array('claveBit' => $claveBit, 'page'=>$sPage );

			$data_infoBit = $this->webservice_sicas_soap->GetInfoBit($data_body);

			$tb_infoBit = array();
			if($data_infoBit != null){

				foreach ($data_infoBit->TableInfo as  $value) {
					$item = new \stdClass;
					
					// echo  $value->FechaHora;

					$item->Fecha = $this->capsysdre_actividades->fechaHoraEspActividades($this->getValue($value->FechaHora),'lineal');
					$item->Comentario = $this->getValue($value->Comentario);
					
					array_push($tb_infoBit, $item);
				}



				echo json_encode(array(
	 		'recordsTotal'=> strval($this->getValue($data_infoBit->TableControl->MaxRecords)) != NULL ? strval($this->getValue($data_infoBit->TableControl->MaxRecords)):'0',
	 		'recordsFiltered'=>strval($this->getValue($data_infoBit->TableControl->MaxRecords)) != NULL ? strval($this->getValue($data_infoBit->TableControl->MaxRecords)):'0',
	 		'data'=>$tb_infoBit
 			));	

			}else{
				echo json_encode(array(
					'data'=>$tb_infoBit,
				'recordsTotal'=>'0',
				'recordsFiltered'=> 0));
			}
			

		}	
	}

	function GetInfoBitExcel(){

		$claveBit = "";
		if($_REQUEST["claveBit"] != null){
			$claveBit = $_REQUEST["claveBit"];
			$page = 1;
			$pages = 1;
			$tb_infoBit = array();
			do{

			 	$data_body = array('claveBit' => $claveBit, 'page'=>$page );
				$data_infoBit = $this->webservice_sicas_soap->GetInfoBit($data_body);

				
				if($data_infoBit != null){ 	

			 		if(isset($data_infoBit->TableControl->Pages)){
						$pages = $data_infoBit->TableControl->Pages;
					}
					
					foreach ($data_infoBit->TableInfo as  $value) {
						$item = new \stdClass;						
						$item->Fecha = $this->capsysdre_actividades->fechaHoraEspActividades($this->getValue($value->FechaHora),'lineal');
						$item->Comentario = $this->getValue($value->Comentario);
						
						array_push($tb_infoBit, $item);
					}
				}

			 	$page++;
			}while($page <= $pages);
			
		
			echo json_encode(array(
	 			'data'=>$tb_infoBit
 			));	

		}
	}

	function updateReport(){
		if(!$this->tank_auth->is_logged_in()){
			redirect('/auth/login/');
		}else{

			$skey = "";
			$disabled = false;
			$month = "";
			$name_consultar = "";
			$tipoReporte = '0';

			switch ($this->input->get("consultar")) {
				case 'Renovacin':
					$skey = 'ren';
					$disabled = true;
					$data["mes"] = ($this->input->get("mes") == null ? "" : $this->input->get("mes"));
					$month = $data["mes"];
					$data["meses"] = $this->_getMeses(((int)date("m"))-1);
					$name_consultar = "Renovaci&#243;n";
					$tipoReporte = '1';
				break;
				case 'Produccin':
					$skey = 'pro';
					$name_consultar = "Producci&#243;n";
					$tipoReporte = '2';
				break;
				case 'Cobranza Pendiente':
					$skey = 'cobp';
					$name_consultar = $this->input->get("consultar");
					$tipoReporte = '3';
				break;
				case 'Cobranza Efectuada':
					$skey = 'cobe';
					$name_consultar = $this->input->get("consultar");
					$tipoReporte = '4';
				break;
				case 'Cobranza Cancelada':
					$skey = 'cobc';
					$name_consultar = $this->input->get("consultar");
					$tipoReporte = '5';
				break;
				case 'Buscador Clientes':
					$skey = 'cli';
					$name_consultar = $this->input->get("consultar");
					$tipoReporte = '6';
				break;
				case 'Actividades':
					$skey = 'act';
					redirect('/reportes/actividades/');
				break;
			}

			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();

			$sPage = $this->input->post("start");
			if($sPage > 0){
				$sPage = ($sPage / 25) + 1;	
			}else{
				$sPage = 1;
			}

			
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();

			$data["page"] 			= ($this->input->get("page") 		== "null" ? 1 : $this->input->get("page"));
			$data["cliente"] 		= ($this->input->get("cliente") 	== "null" ? "" : $this->input->get("cliente"));
			$data["ramo"] 			= ($this->input->get("ramo") 		== "null" ? "" : $this->input->get("ramo"));
			$data["subramo"] 		= ($this->input->get("subramo") 	== "null" ? "" : $this->input->get("subramo"));
			$data["fechaini"] 		= ($this->input->get("fechaini") 	== "null" ? "" : $this->input->get("fechaini"));
			$data["fechafin"] 		= ($this->input->get("fechafin") 	== "null" ? "" : $this->input->get("fechafin"));
			$data["aseguradora"]	= ($this->input->get("aseguradora") == "null" ? "" : $this->input->get("aseguradora"));
			$data["habilitarf"]		= ($this->input->get("habilitarf") == "null" ? "" : (bool)$this->input->get("habilitarf"));
			
			$data["poliza"] 		= ($this->input->get("poliza") 	== "null" ? "" : $this->input->get("poliza"));
			$data["estatus"] 		= ($this->input->get("estatus") 	== "null" ? "" : $this->input->get("estatus"));
			$data["vendedor"]		= ($this->input->get("vendedor") 	== "null" ? "" : $this->input->get("vendedor"));
			$data["promotor"]		= ($this->input->get("promotor") 	== "null" ? "" : $this->input->get("promotor"));
			$data["grupo"] 			= ($this->input->get("grupo") 		== "null" ? "" : $this->input->get("grupo"));
			$data["subgrupo"] 		= ($this->input->get("subgrupo") 	== "null" ? "" : $this->input->get("subgrupo"));
			$data["consultar"] 		=($this->input->get("consultar") == "null" ? "": $this->input->get("consultar"));
			$data["title"] = $name_consultar;
			
				
			$vigencia = "";

			if(!empty($data["fechaini"]) && !empty($data["fechafin"])){
				$vigencia = $data["fechaini"] . "|" . $data["fechafin"];
			}	
			
			$data_report = array(
			'page'=> $sPage, 
			'TypeReporte'=>$skey,
			'IdVend' => $this->tank_auth->get_IDVend(),
			'Month' => $month,
			'FilterEnable' => $disabled,
			'filter' => array(
				'name_client' => $data["cliente"],
				'branch' => $data["ramo"],
				'sub_branch'=>$data['subramo'],
				'insurance' => $data['aseguradora'],
				'status' => $data['estatus'],
				'vigencia' => $vigencia,
				'policy' => $data["poliza"],
				'salesman' => $data["vendedor"],
				'promoter'=> $data["promotor"],
				'group' => $data["grupo"] ,
				'sub_group' => $data["subgrupo"] ,
			));
			$page = 1;
			$data_report['page'] = $page;
			$everything_is_ok = true;
			$sDate = "";
			if($skey == 'cli'){	

			 	$this->reportes_model->clearCli($this->tank_auth->get_user_id(),$tipoReporte);
			 	$this->reportes_model->clearDoc($this->tank_auth->get_user_id(),$tipoReporte);
				do{
					$data_client = $this->webservice_sicas_soap->GetReport($data_report);

					if($data_client['reporte'] != null){
						if(isset($data_client['paginacion'])){
							$pages = $data_client['paginacion']['Pages'];
						}

					 	foreach ($data_client['reporte'] as $value) {

						 	$tmpDocto = $this->object_to_array($value);

						 	$tmpDocto['IDUserLocal'] = $this->tank_auth->get_user_id();
						 	$tmpDocto['TipoReporte'] = $tipoReporte;
						 	$polizas = array();
						 	$polizas = $this->getPolicyforIDCli($value->IDCli,$tipoReporte);

					 	 	$this->reportes_model->addClientes($tmpDocto,$polizas,$this->tank_auth->get_user_id(),$tipoReporte);
					 	}
					 }

					$page++;
					$data_report['page'] = $page;
				}while($page < $pages);	
				$dt = new DateTime();
				$sDate = $dt->format('Y-m-d HH:mm:ss');
				$bitacora_rep = array(
						'IDUserLocal'=>$this->tank_auth->get_user_id(),
						'TipoReporte'=>$tipoReporte,
						'Fecha'=> $sDate);
				
					$rs = $this->reportes_model->addBitReg($bitacora_rep	);
					if(!$rs){
						$everything_is_ok = false;
					 		goto end;
				 	}

		 	}else {
		 		

		 		$this->reportes_model->clearDoc($this->tank_auth->get_user_id(),$tipoReporte);
		 		$this->reportes_model->clearBit($this->tank_auth->get_user_id(),$tipoReporte);
		 		$this->reportes_model->clearDocBot($this->tank_auth->get_user_id(),$tipoReporte);

	 			do{	
		 			$data_client = $this->webservice_sicas_soap->GetReport($data_report);

	 		 		if(isset($data_client['paginacion']['MaxRecords'])){

	 		 			if(isset($data_client['paginacion'])){
							$pages = $data_client['paginacion']['Pages'];
						}

	 		 		
		 		 		foreach ($data_client['reporte'] as $value) {
		 		 			

						 	$tmpDocto = $this->object_to_array($value);

						 	$tmpDocto['IDUserLocal'] = $this->tank_auth->get_user_id();
						 	$tmpDocto['TipoReporte'] = $tipoReporte;

						 	$bitacoras = $this->SaveInfoBit($tmpDocto['ClaveBit'],$tipoReporte);
						 	$rs = $this->reportes_model->addReportes($tmpDocto,$bitacoras,$this->tank_auth->get_user_id(),$tipoReporte);
						 	if(!$rs)
						 	{
						 		$everything_is_ok = false;
						 		goto end;
						 	}
					 	}

					 	$dt = new DateTime();
						$sDate = $dt->format('Y-m-d HH:mm:ss');
						$bitacora_rep = array(
							'IDUserLocal'=>$this->tank_auth->get_user_id(),
							'TipoReporte'=>$tipoReporte,
							'Fecha'=> $sDate);
					
						$rs = $this->reportes_model->addBitReg($bitacora_rep	);
						if(!$rs){
							$everything_is_ok = false;
						 		goto end;
					 	}
					}
					$page++;
					$data_report['page'] = $page;
				}while($page < $pages);		
		 	}
		 	goto end;
		 	$everything_is_ok = false;

		 	end:
			if ($everything_is_ok)
		    {
		        header('Content-Type: application/json');
		        print('{ "code" : 200, "message": "Actualizacion realizada con exito.", "Fecha":"'.$sDate.'"}');
		        // echo json_encode(array('code'=>'200','message'=>'Actualización realizada con éxito.','Fecha'=> $sDate));
		        // print (json_encode());
		    }
			else
		    {
		        header('HTTP/1.1 500 Internal Server Booboo');
		        header('Content-Type: application/json; charset=UTF-8');
		        die(json_encode(array('message' => 'ERROR', 'code' => 1337)));
		    }

		}		
	}
	
	function SaveInfoBit($claveBit,$TipoRep){
		$tb_infoBit = array();
		if($claveBit != null){
			$sPage = 1;
			$data_body = array('claveBit' => $claveBit, 'page'=>$sPage );

			$data_infoBit = $this->webservice_sicas_soap->GetInfoBit($data_body);

			if($data_infoBit != null){

				foreach ($data_infoBit->TableInfo as  $value) {

					$tmpBit = $this->object_to_array($value);

					 	//$tmpDocto = (array) $value;
					 	$tmpBit['IDUserLocal'] = $this->tank_auth->get_user_id();
					 	$tmpBit['TipoReporte'] = $TipoRep;					
					array_push($tb_infoBit, $tmpBit);
				}
			}
			

		}
		return $tb_infoBit;
	}
	
	function actividades(){
		//echo APPPATH.'../assets/phpgrid/conf.php';
	   require_once('assets/phpgrid/conf.php'); // APPPATH is path to application folder
	   
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			$usermail 			= $data['usermail']		= $this->tank_auth->get_usermail();
			$usermailPromo 		= "";
			
			$data['Ramo'] = $this->catalogos_model->get_Ramos();	
			// $data['SubRamo'] = $this->catalogos_model->get_SubRamos();
			$data['Grupo'] = $this->catalogos_model->get_Grupos();
			
			$data['vendedor'] = $this->catalogos_model->get_Vendedor($this->tank_auth->get_IDVend(),$this->tank_auth->get_IDVendNS());
			$data['promotor'] = $this->catalogos_model->get_Promotor($this->tank_auth->get_IDVend(),$this->tank_auth->get_IDVendNS());
			
			$sqlConsultaActividades = "
				Select
					`semaforo`
					,`actividadUrgente`
					,`folioActividad`
--					,`Status`
					,`Status_Txt`
					,`poliza`
					,`nombreCliente`
					,`tipoActividad`
					,`ramoActividad`
					,`subRamoActividad`
					,`satisfaccion`
					,`usuarioCreacion`
--					,`usuarioVendedor`
					,`nombreUsuarioVendedor`
					,`usuarioResponsable`
					,`usuarioCotizador`
					,`superior`
					,`fechaCreacion`
					,`fechaPromesa`
					,`fechaCotizacion`
					,`fechaEmision`
					,`fechaTermino`
					,`fechaTermino`
					,`rankingVendedor`
				From
					`actividades`
									  ";
			switch($this->tank_auth->get_userprofile()){
				case "1":
			$sqlFiltroProfile = "
				`usuarioCreacion` = '".$usermail."'
								";
				break;
				
				case "2":
			$sqlFiltroProfile = "
				`usuarioCreacion` Like '%$usermail%'
				Or
				`superior` Like '%$usermailPromo%'
								";
				break;
				
				case "3":
				case "4":
				case "5":
			$sqlFiltroProfile = "
				`usuarioCreacion` Like '%%'
				And
				`idSicas` Is Not Null
								";
				break;
			}
			$habilitarf	= $this->input->get("habilitarf");			
			if($habilitarf == "on"){

				$fechaini	= explode("/",$this->input->get("fechaini"));
				$fechaini 	= $fechaini[2]."-".$fechaini[1]."-".$fechaini[0];
			
				$fechafin	= explode("/",$this->input->get("fechafin"));
				$fechafin 	= $fechafin[2]."-".$fechafin[1]."-".$fechafin[0];

				$sqlFiltroProfile.= "
					And
						`fechaCreacion` Between '".$fechaini."' And '".$fechafin."'
									";
			}
			$data['phpgrid'] = new C_DataGrid($sqlConsultaActividades, "folioActividad", "Reporte_Actividades"); //$this->ci_phpgrid->example_method(3);
			$data['phpgrid'] -> set_query_filter($sqlFiltroProfile);
			$data['phpgrid'] -> set_sortname('fechaActualizacion', 'Desc');

			//* Personalizacion Particular
			$data['phpgrid'] -> set_col_title("actividadUrgente", "Urgente");
			$data['phpgrid'] -> set_col_title("semaforo", "Semaforo");
			$data['phpgrid'] -> set_col_title("folioActividad", "Folio");
			$data['phpgrid'] -> set_col_title("Status", "Estado");
			
			//* Personalizacion General
			$data['phpgrid'] -> set_caption("Reporte Actividades Todas");
			$data['phpgrid'] -> set_dimension(1100, 460, false); 
			$data['phpgrid'] -> enable_search(true);
			$data['phpgrid'] -> enable_export('EXCEL'); //PDF
			$data['phpgrid'] -> set_locale("sp");
			$data['phpgrid'] -> enable_resize(true); 
			$this->load->view('reportes/reporteactividades', $data);
		}
	}
	
	function verReporteAjax(){
		if(!$this->tank_auth->is_logged_in()){
			redirect('/auth/login/');
		}else{
			$skey			= "";
			$disabled		= false;
			$month			= "";
			$name_consultar	= "";
					
			switch($this->input->post("consultar")){
				case 'Renovacin':
					$skey			= 'ren';
					$disabled		= true;
					$data["mes"]	= ($this->input->post("mes") == null ? "" : $this->input->post("mes"));
					$month			= $data["mes"];
					$data["meses"]	= $this->_getMeses(((int)date("m"))-1);
					$name_consultar	= "Renovación";
				break;
				
				case 'Produccin':
					$skey			= 'pro';
					$name_consultar	= "Producción";
				break;
				
				case 'Cobranza Pendiente':
					$skey			= 'cobp';
					$name_consultar	= $this->input->post("consultar");
				break;
				
				case 'Cobranza Efectuada':
					$skey			= 'cobe';
					$name_consultar	= $this->input->post("consultar");
				break;
				
				case 'Cobranza Cancelada':
					$skey			= 'cobc';
					$name_consultar	= $this->input->post("consultar");
				break;
				
				case 'Buscador Clientes':
					$skey			= 'cli';
					$name_consultar	= $this->input->post("consultar");
				break;
			}

			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();

			$sPage = $this->input->post("start");
		if($sPage > 0){
			$sPage = ($sPage / 25) + 1;	
		}else{
			$sPage = 1;
		}
			$data['user_id']		= $this->tank_auth->get_user_id();
			$data['username']		= $this->tank_auth->get_username();
			$data["page"] 			= ($this->input->post("page") 		== "null" ?  1 : $this->input->post("page"));
			$data["cliente"] 		= ($this->input->post("cliente") 	== "null" ? "" : $this->input->post("cliente"));
			$data["ramo"] 			= ($this->input->post("ramo") 		== "null" ? "" : $this->input->post("ramo"));
			$data["subramo"] 		= ($this->input->post("subramo") 	== "null" ? "" : $this->input->post("subramo"));
			$data["fechaini"] 		= ($this->input->post("fechaini") 	== "null" ? "" : $this->input->post("fechaini"));
			$data["fechafin"] 		= ($this->input->post("fechafin") 	== "null" ? "" : $this->input->post("fechafin"));
			$data["aseguradora"]	= ($this->input->post("aseguradora")== "null" ? "" : $this->input->post("aseguradora"));
			$data["habilitarf"]		= ($this->input->post("habilitarf") == "null" ? "" : (bool)$this->input->post("habilitarf"));
			$data["poliza"] 		= ($this->input->post("poliza") 	== "null" ? "" : $this->input->post("poliza"));
			$data["estatus"] 		= ($this->input->post("estatus") 	== "null" ? "" : $this->input->post("estatus"));
			$data["vendedor"]		= ($this->input->post("vendedor") 	== "null" ? "" : $this->input->post("vendedor"));
			$data["promotor"]		= ($this->input->post("promotor") 	== "null" ? "" : $this->input->post("promotor"));
			$data["grupo"] 			= ($this->input->post("grupo") 		== "null" ? "" : $this->input->post("grupo"));
			$data["subgrupo"] 		= ($this->input->post("subgrupo") 	== "null" ? "" : $this->input->post("subgrupo"));
			$data["consultar"] 		= ($this->input->post("consultar")	== "null" ? "" : $name_consultar);
			$vigencia				= "";
             
		if(!empty($data["fechaini"]) && !empty($data["fechafin"])){
			$vigencia				= $data["fechaini"]."|".$data["fechafin"];
		}	
			$data_report			= array(
										'page'			=> $sPage,
										'TypeReporte'	=> $skey,
										'IdVend'		=> $this->tank_auth->get_IDVend(),
										'Month'			=> $month,
										'FilterEnable'	=> $disabled,
										'Sort'			=> 'VDatDocumentos.IDDocto',
										'ExtraFilter'	=> '',
										'filter'		=> array(

																'name_client' => $data["cliente"],
																'branch' => $data["ramo"],
																'sub_branch'=>$data['subramo'],
																'insurance' => $data['aseguradora'],
																'status' => $data['estatus'],
																'vigencia' => $vigencia,
																'policy' => $data["poliza"],
																'salesman' => $data["vendedor"],
																'promoter'=> $data["promotor"],
																'group' => $data["grupo"] ,
																'sub_group' => $data["subgrupo"] ,
														   )
									  );
			 // var_dump($data_report);

			if($skey == 'cli'){
				$posCol					= intval($_POST['order'][0]['column']);
		 		$colDir					= $_POST['order'][0]['dir'];
				$colsCli				= array();
				$data_report['Sort']	= 'VCatClientes.IDCli';
		 		$colsCli[]				= 'VCatClientes.Nombre';
		 		$colsCli[]				= 'VCatClientes.RFC  ';
		 		$colsCli[]				= 'VCatClientes.Telefono1 ';
		 		$colsCli[]				= 'VCatClientes.Correo ';
		 		$colsCli[]				= 'VCatClientes.IDCli ';
		 		// $colsCli[] = 'Direccion';
		 	   if($posCol > 0){
				$data_report['Sort']	= $colsCli[$posCol - 1].' '.$colDir;
			}
		 		$seardd					= json_decode($this->input->post("search_d",TRUE));
	 			$sExtraFilter			= "";
				if(is_array($seardd) || is_object($seardd)){
					foreach ($seardd as $key => $row) {
						$pKey		= intval($row->id );
		 				$sKess		= $colsCli[$pKey ];
		 				if($row->type == "date"){
		 					$sExtraFilter .= "TableFilter;0;0;".$row->val.";".$row->val.";".$sKess." ! ";
		 				}else{
		 					$sExtraFilter .= "TableFilter;0;0;*".$row->val."*;".$row->val.";".$sKess." ! ";	
		 				}
		 			}
		 			if($sExtraFilter != ""){
		 				$data_report['ExtraFilter'] = $sExtraFilter;
		 			}
				}
               

	 			$data_client	= $this->webservice_sicas_soap->GetReport($data_report);
                 

	 			$tb_client		= array();
				if($data_client['reporte'] != null){
					foreach ($data_client['reporte'] as $value) {
						$item				= new \stdClass;
						$item->IDCli		=  $this->getValue($value->IDCli);
						$item->Nombre		= $this->getValue($value->NombreCompleto);
						$item->RFC			= $this->getValue($value->RFC);
						$item->Telefono1	= $this->getValue($value->Telefono1);
						$item->Correo		= $this->getValue($value->EMail1);
						$item->Direccion	= $this->getValue($value->Calle)
												.' '.$this->getValue($value->NOExt)
												.' '.$this->getValue($value->NOInt)
												.' '.$this->getValue($value->Colonia);
						$item->Ranking		= "";
						array_push($tb_client, $item);
					}
					if(isset($data_client['paginacion']['MaxRecords'])){
						echo json_encode(
							array(
								'recordsTotal'		=> 
									(strval($data_client['paginacion']['MaxRecords']) != NULL)?strval($data_client['paginacion']['MaxRecords']):'0',
								'recordsFiltered'	=>
									(strval($data_client['paginacion']['MaxRecords']) != NULL)?strval($data_client['paginacion']['MaxRecords']):'0',
								'data'				=>
									$tb_client
							)
						);
					}
				} else {
					echo json_encode(
						array(
				 			'recordsTotal'		=> '0',
				 			'recordsFiltered'	=> '0',
				 			'data'				=> $tb_client
						)
					);	
			 	}
			} 
			else {
		 		$posCol		= intval($_POST['order'][0]['column']);
		 		$colDir		= $_POST['order'][0]['dir'];
		 		$colsResp	= array();
	 			$colsResp[] = 'VDatDocumentos.TipoDocto';
		 		$colsResp[] = 'VDatDocumentos.Documento';
			if($skey == 'cobp' || $skey == 'cobe' || $skey == 'cobc' ){
		 		$colsResp[] = 'VDatRecibos.Serie  ';
			}
		 		$colsResp[] = 'VDatDocumentos.DAnterior';
	 			$colsResp[] = 'VDatDocumentos.DPosterior';	
			if ($skey == "ren" || $skey == 'pro'){
		 		$colsResp[] = 'VDatDocumentos.FDesde';
		 	}else{
		 		$colsResp[] = 'VDatRecibos.FLimPago';
			}
		 		$colsResp[] = 'VDatDocumentos.FHasta';
		 		$colsResp[] = 'VDatDocumentos.Status';
		 		$colsResp[] = 'VCatClientes.NombreCompleto';
		 		$colsResp[] = 'VDatDocumentos.Grupo';
		 		$colsResp[] = 'VDatDocumentos.SubGrupo';
		 		$colsResp[] = 'VDatDocumentos.Concepto';
		 		$colsResp[] = 'VDatDocumentos.Referencia1';
		 		$colsResp[] = 'VDatDocumentos.Referencia2';
	 			$colsResp[] = 'VDatDocumentos.FolioNo';
		 		$colsResp[] = 'VDatDocumentos.Moneda';
		 		$colsResp[] = 'VDatDocumentos.FPago';
		 		$colsResp[] = 'VCatAgentes.CAgente';
		 		$colsResp[] = 'VCatAgentes.AgenteNombre';
		 		$colsResp[] = 'VCatSRamo.SRamoAbreviacion';
		 		$colsResp[] = 'VDatDocumentos.PrimaNeta';
		 		$colsResp[] = 'VDatDocumentos.PrimaTotal';
		 		$colsResp[] = 'VCatEjecutivos.EjecutNombre';
		 		$colsResp[] = 'VCatVendedores.VendNombre';
		 		// $oDocto = $this->webservice_sicas_soap->GetPolicy_forID_Docto($value->IDDocto);
		 		$colsResp[] = 'ClaveBit ';
		 		$colsResp[] = 'RamosNombre ';
		 		$colsResp[] = 'IDDocto ';



	 			$seardd			= json_decode($this->input->post("search_d",TRUE));
	 			$sExtraFilter	= "";
	 			if(is_array($seardd) || is_object($seardd)){
	 				foreach ($seardd as $key => $row) {
	 					$pKey	= intval($row->id );
		 				$sKess	= $colsResp[$pKey ];
		 				if($row->type == "date"){
		 					$sExtraFilter .= "TableFilter;0;0;".$row->val.";".$row->val.";".$sKess." ! ";
		 				}else{
		 					$sExtraFilter .= "TableFilter;0;0;*".$row->val."*;".$row->val.";".$sKess." ! ";	
		 				}
					}
		 			if($sExtraFilter != ""){
						$data_report['ExtraFilter']	= $sExtraFilter;
					}
				}

		 		if($posCol > 0){
					$data_report['Sort'] = $colsResp[$posCol - 1].' '.$colDir;
			}
		 		
				$data_client	= $this->webservice_sicas_soap->GetReport($data_report);

		 		$tb_renovacion	= array();
	 		 	if(isset($data_client['paginacion']['MaxRecords'])){
					foreach($data_client['reporte'] as $value){
						$item					= new \stdClass;
				 		$item->TipoDocto		= $this->getValue($value->TipoDocto_TXT);
					 	$item->Documento		= $this->getValue($value->Documento);
					if($skey == 'cobp' || $skey == 'cobe' || $skey == 'cobc'){
						$item->Serie = $this->getValue($value->Serie);
					//LOCM
						$item->FLim=$this->formatDate($this->getValue($value->FLimPago));
					}
				 		$item->DAnterior		= $this->getValue($value->DAnterior);
			 			$item->DPosterior		= $this->getValue($value->DPosterior);
					if ($skey == "ren" || $skey == 'pro'){
						$item->FDesde			= $this->formatDate($this->getValue($value->FDesde));
					}else{
						$item->FDesde			= $this->formatDate($this->getValue($value->FLimPago));
					}												
						$item->FHasta			= $this->formatDate($this->getValue($value->FHasta));
					 	$item->Status			= $this->getValue($value->Status_TXT);
					 	$item->NombreCompleto	= $this->getValue($value->NombreCompleto);
					 	$item->Grupo			= $this->getValue($value->Grupo);
					 	$item->SubGrupo			= $this->getValue($value->SubGrupo);
					 	$item->Concepto			= $this->getValue($value->Concepto);
					 	$item->Referencia1		= $this->getValue($value->Referencia1);
					 	$item->Referencia2		= $this->getValue($value->Referencia2);
				 		$item->FolioNo			= $this->getValue($value->FolioNo);
					 	$item->Moneda			= $this->getValue($value->Moneda);
					 	$item->FPago			= $this->getValue($value->FPago);
					 	$item->CAgente			= $this->getValue($value->CAgente);
					 	$item->AgenteNombre		= $this->getValue($value->AgenteNombre);
					 	$item->SRamoAbreviacion	= $this->getValue($value->SRamoAbreviacion);
					 	$item->PrimaNeta		= $this->formatMoney($this->getValue($value->PrimaNeta));
					 	$item->PrimaTotal		= $this->formatMoney($this->getValue($value->PrimaTotal));
					 	$item->EjecutNombre		= $this->getValue($value->EjecutNombre);
					 	$item->VendNombre		= $this->getValue($value->VendNombre);
					 	// $oDocto = $this->webservice_sicas_soap->GetPolicy_forID_Docto($value->IDDocto);
					 	$item->ClaveBit			= $this->getValue($value->ClaveBit);
					 	$item->RamosNombre		= $this->getValue($value->RamosNombre);
					 	$item->IDDocto			= $this->getValue($value->IDDocto);
                       //AÑADE UN ELEMENTO AL ARRAY
                        
						array_push($tb_renovacion, $item);
					}
					 
/*//GUARDA EL UN TXT UN ARREGLO EN FORMATO JASON  					
$encodedString = json_encode($tb_renovacion);
//Save the JSON string to a text file.
file_put_contents('data.txt', $encodedString);
//Retrieve the data from our text file.
$fileContents = file_get_contents('data.txt');
//Convert the JSON string back into an array.
$decoded = json_decode($fileContents, true);
//The end result.
var_dump($decoded);*/

//RETORNA LA REPRESENTACION EN FORMATO JSON DEL VALOR
				 	echo json_encode(array(
				 		'recordsTotal'=> $data_client['paginacion']['MaxRecords'] != NULL ? strval($data_client['paginacion']['MaxRecords']):'0',
				 		'recordsFiltered'=> $data_client['paginacion']['MaxRecords'] != NULL ? strval($data_client['paginacion']['MaxRecords']):'0',
				 		'data'=>$tb_renovacion
			 			));
				 	


			 	}else{
					echo json_encode(
						array(
				 			'recordsTotal'		=> '0',
				 			'recordsFiltered'	=> '0',
				 			'data'				=> $tb_renovacion
				 		)
					);
			 	}
				
		 	}
		}

		 
	}/*! verReporteAjax */
	
	function verReporte(){
		if(!$this->tank_auth->is_logged_in()){
			redirect('/auth/login/');
		}else{
			$skey			= "";
			$disabled		= false;
			$month			= "";
			$name_consultar	= "";
			$tipoReporte	= '0';

			switch($this->input->get("consultar")){
				case 'Renovacin':
					$skey			= 'ren';
					$disabled		= true;
					$data["mes"]	= ($this->input->get("mes") == null ? "" : $this->input->get("mes"));
					$month			= $data["mes"];
					$data["meses"]	= $this->_getMeses(((int)date("m"))-1);
					$name_consultar	= "Renovaci&#243;n";
					$tipoReporte	= '1';
				break;
				
				case 'Produccin':
					$skey			= 'pro';
					$name_consultar	= "Producci&#243;n";
					$tipoReporte = '2';
				break;
				
				case 'Cobranza Pendiente':
					$skey			= 'cobp';
					$name_consultar	= $this->input->get("consultar");
					$tipoReporte	= '3';
				break;
				
				case 'Cobranza Efectuada':
					$skey			= 'cobe';
					$name_consultar	= $this->input->get("consultar");
					$tipoReporte	= '4';
				break;
				
				case 'Cobranza Cancelada':
					$skey			= 'cobc';
					$name_consultar	= $this->input->get("consultar");
					$tipoReporte	= '5';
				break;
				
				case 'Buscador Clientes':
					$skey			= 'cli';
					$name_consultar	= $this->input->get("consultar");
					$tipoReporte	= '6';
				break;
				
				case 'Actividades':
					$skey			= 'act';
					$name_consultar	= $this->input->get("consultar");
					$cliente		= $this->input->get("cliente");
					$estatus		= $this->input->get("estatus");
					$ramo			= $this->input->get("ramo");
					$subramo		= $this->input->get("subramo");
					$promotor		= $this->input->get("promotor");
					$vendedor		= $this->input->get("vendedor");
					$grupo			= $this->input->get("grupo");
					$subgrupo		= $this->input->get("subgrupo");
					$poliza			= $this->input->get("poliza");
					$habilitarf		= $this->input->get("habilitarf");
					$fechaini		= $this->input->get("fechaini");
					$fechafin		= $this->input->get("fechafin");
					$tipoReporte	= '7';
				//	$urlRedirect	= "/reportes/actividades";
				//	$urlRedirect	.= "?consultar=Actividades";
				//	$urlRedirect	.= "&cliente=".$cliente;
				//	$urlRedirect	.= "&estatus=".$estatus;
				//	$urlRedirect	.= "&ramo=".$ramo;
				//	$urlRedirect	.= "&subramo=".$subramo;
				//	$urlRedirect	.= "&promotor=".$promotor;
				//	$urlRedirect	.= "&vendedor=".$vendedor;
				//	$urlRedirect	.= "&grupo=".$grupo;
				//	$urlRedirect	.= "&subgrupo=".$subgrupo;
				//	$urlRedirect	.= "&poliza=".$poliza;
				//	$urlRedirect	.= "&habilitarf=".$habilitarf;
				//	$urlRedirect	.= "&fechaini=".$fechaini;
				//	$urlRedirect	.= "&fechafin=".$fechafin;
				//	redirect($urlRedirect);
				break;

				case 'Vendedores':
					$skey			= 'vend'; //'cli'; //'vend';
					//$name_consultar	= $this->input->get("consultar");
					//$cliente		= $this->input->get("cliente");
					//$estatus		= $this->input->get("estatus");
					//$ramo			= $this->input->get("ramo");
					//$subramo		= $this->input->get("subramo");
					//$promotor		= $this->input->get("promotor");
					//$vendedor		= $this->input->get("vendedor");
					//$grupo			= $this->input->get("grupo");
					//$subgrupo		= $this->input->get("subgrupo");
					//$poliza			= $this->input->get("poliza");
					//$habilitarf		= $this->input->get("habilitarf");
					//$fechaini		= $this->input->get("fechaini");
					//$fechafin		= $this->input->get("fechafin");
					$tipoReporte	= '8'; //'6';//'8';
				break;
			}

			$data['user_id']		= $this->tank_auth->get_user_id();
			$data['username']		= $this->tank_auth->get_username();
			$sPage					= $this->input->post("start");

		if($sPage > 0){
			$sPage = ($sPage / 25) + 1;	
		}else{
			$sPage = 1;
		}
			$data['user_id']		= $this->tank_auth->get_user_id();
			$data['username']		= $this->tank_auth->get_username();
			$data["page"] 			= ($this->input->get("page") 		== "null" ?  1 : $this->input->get("page"));
			$data["cliente"] 		= ($this->input->get("cliente") 	== "null" ? "" : $this->input->get("cliente"));
			$data["ramo"] 			= ($this->input->get("ramo") 		== "null" ? "" : $this->input->get("ramo"));
			$data["subramo"] 		= ($this->input->get("subramo") 	== "null" ? "" : $this->input->get("subramo"));
			$data["fechaini"] 		= ($this->input->get("fechaini") 	== "null" ? "" : $this->input->get("fechaini"));
			$data["fechafin"] 		= ($this->input->get("fechafin") 	== "null" ? "" : $this->input->get("fechafin"));
			$data["aseguradora"]	= ($this->input->get("aseguradora") == "null" ? "" : $this->input->get("aseguradora"));
			$data["habilitarf"]		= ($this->input->get("habilitarf")	== "null" ? "" : (bool)$this->input->get("habilitarf"));
			$data["poliza"] 		= ($this->input->get("poliza")		== "null" ? "" : $this->input->get("poliza"));
			$data["estatus"] 		= ($this->input->get("estatus") 	== "null" ? "" : $this->input->get("estatus"));
			$data["vendedor"]		= ($this->input->get("vendedor") 	== "null" ? "" : $this->input->get("vendedor"));
			$data["promotor"]		= ($this->input->get("promotor") 	== "null" ? "" : $this->input->get("promotor"));
			$data["grupo"] 			= ($this->input->get("grupo") 		== "null" ? "" : $this->input->get("grupo"));
			$data["subgrupo"] 		= ($this->input->get("subgrupo") 	== "null" ? "" : $this->input->get("subgrupo"));
			$data["consultar"] 		= ($this->input->get("consultar")	== "null" ? "": $this->input->get("consultar"));
			$data["title"]			= $name_consultar;
			$data['activeReporte']	= $this->existReportActive($this->input->get("consultar"));
			$vigencia				= "";

		if(!empty($data["fechaini"]) && !empty($data["fechafin"])){
			$vigencia				= $data["fechaini"]."|".$data["fechafin"];
		}	

		//echo '<pre>'; print_r($data); echo '</pre>'; 
			// --->
			$data_report			= array(
										'page'			=> $sPage, 
										'TypeReporte'	=> $skey,
										'IdVend'		=> $this->tank_auth->get_IDVend(),
										'Month'			=> $month,
										'FilterEnable'	=> $disabled,
										'filter'		=> array(
																'name_client'	=> $data["cliente"],
																'branch'		=> $data["ramo"],
																'sub_branch'	=> $data['subramo'],
																'insurance'		=> $data['aseguradora'],
																'status'		=> $data['estatus'],
																'vigencia'		=> $vigencia,
																'policy'		=> $data["poliza"],
																'salesman'		=> $data["vendedor"],
																'promoter'		=> $data["promotor"],
																'group'			=> $data["grupo"] ,
																'sub_group'		=> $data["subgrupo"] ,
														   )
									);
			$page					= 1;
			$data_report['page']	= $page;

			//echo '<pre>'; print_r($data_report); echo '</pre>'; 

			if($skey == 'cli'){
	 		 	$this->load->view('reportes/reportecliente', $data);
		 	} else if($skey == 'vend'){
			 	$this->load->view('reportes/reportevendedores', $data);
			} else if($skey == 'act'){
			 	$this->load->view('reportes/reporteactividades', $data);
			} else {

                //echo '<pre>'; print_r($data); echo '</pre>'; 
			 	$this->load->view('reportes/reporte', $data);
			}
		}	
		 

	}/*! verReporte */
	
	function getExcelAjax(){
		if(!$this->tank_auth->is_logged_in()){
			redirect('/auth/login/');
		}else{
			$skey				= "";
			$disabled			= false;
			$month				= "";
			$name_consultar		= "";
					
			switch ($this->input->post("consultar")) {
				case 'Renovacin':
					$skey = 'ren';
					$disabled = true;
					$data["mes"] = ($this->input->post("mes") == null ? "" : $this->input->post("mes"));
					$month = $data["mes"];
					$data["meses"] = $this->_getMeses(((int)date("m"))-1);
					$name_consultar = "Renovación";
					$typeR = 0;
				break;
				case 'Produccin':
					$skey = 'pro';
					$name_consultar = "Producción";
					$typeR = 1;
				break;
				case 'Cobranza Pendiente':
					$skey = 'cobp';
					$name_consultar = $this->input->post("consultar");
					$typeR = 2;
				break;
				case 'Cobranza Efectuada':
					$skey = 'cobe';
					$name_consultar = $this->input->post("consultar");
					$typeR = 3;
				break;
				case 'Cobranza Cancelada':
					$skey = 'cobc';
					$name_consultar = $this->input->post("consultar");
					$typeR = 4;
				break;
				case 'Buscador Clientes':
				$skey = 'cli';
					$name_consultar = $this->input->post("consultar");
					$typeR = 5;
				break;
			}

			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();

			$sPage = $this->input->post("start");
			if($sPage > 0){
				$sPage = ($sPage / 25) + 1;	
			}else{
				$sPage = 1;
			}

			
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();

			$data["page"] 			= ($this->input->post("page") 		== "null" ? 1 : $this->input->post("page"));
			$data["cliente"] 		= ($this->input->post("cliente") 	== "null" ? "" : $this->input->post("cliente"));
			$data["ramo"] 			= ($this->input->post("ramo") 		== "null" ? "" : $this->input->post("ramo"));
			$data["subramo"] 		= ($this->input->post("subramo") 	== "null" ? "" : $this->input->post("subramo"));
			$data["fechaini"] 		= ($this->input->post("fechaini") 	== "null" ? "" : $this->input->post("fechaini"));
			$data["fechafin"] 		= ($this->input->post("fechafin") 	== "null" ? "" : $this->input->post("fechafin"));
			$data["aseguradora"]	= ($this->input->post("aseguradora") == "null" ? "" : $this->input->post("aseguradora"));
			$data["habilitarf"]		= ($this->input->post("habilitarf") == "null" ? "" : (bool)$this->input->post("habilitarf"));
			
			$data["poliza"] 		= ($this->input->post("poliza") 	== "null" ? "" : $this->input->post("poliza"));
			$data["estatus"] 		= ($this->input->post("estatus") 	== "null" ? "" : $this->input->post("estatus"));
			$data["vendedor"]		= ($this->input->post("vendedor") 	== "null" ? "" : $this->input->post("vendedor"));
			$data["promotor"]		= ($this->input->post("promotor") 	== "null" ? "" : $this->input->post("promotor"));
			$data["grupo"] 			= ($this->input->post("grupo") 		== "null" ? "" : $this->input->post("grupo"));
			$data["subgrupo"] 		= ($this->input->post("subgrupo") 	== "null" ? "" : $this->input->post("subgrupo"));
			$data["consultar"] 		=($this->input->post("consultar") == "null" ? "": $name_consultar);
			
			$isNew = $this->input->post("isNew",true);
				
			$vigencia = "";

			if(!empty($data["fechaini"]) && !empty($data["fechafin"])){
				$vigencia = $data["fechaini"] . "|" . $data["fechafin"];
			}	
			
			
			$data_report = array(
			'page'=> $sPage, 
			'TypeReporte'=>$skey,
			'ItemforPage' => 1,
			'IdVend' => $this->tank_auth->get_IDVend(),
			'Month' => $month,
			'FilterEnable' => $disabled,
			'Sort' => 'VDatDocumentos.IDDocto',
			'ExtraFilter' => '',
			'filter' => array(
				'name_client' => $data["cliente"],
				'branch' => $data["ramo"],
				'sub_branch'=>$data['subramo'],
				'insurance' => $data['aseguradora'],
				'status' => $data['estatus'],
				'vigencia' => $vigencia,
				'policy' => $data["poliza"],
				'salesman' => $data["vendedor"],
				'promoter'=> $data["promotor"],
				'group' => $data["grupo"] ,
				'sub_group' => $data["subgrupo"] ,
			));

			$pages = 1;
			$page = 1;

			$oResponse = new \stdClass;
			$oResponse->disabled_controls = false;
			// var_dump($data_report);
			if($skey == 'cli'){		

				$data_report['Sort'] = 'VCatClientes.IDCli';

				$posCol = intval($_POST['order'][0]['column']);
		 		$colDir = $_POST['order'][0]['dir'];
				$colsCli = array();

				$colsCli[] = 'IDCli ';
		 		$colsCli[] = 'Nombre ';
		 		$colsCli[] = 'RFC  ';
		 		$colsCli[] = 'Telefono1 ';
		 		$colsCli[] = 'Correo ';
		 		// $colsCli[] = 'Direccion';

		 		if($posCol > 0)
		 			$data_report['Sort'] = $colsCli[$posCol].' '.$colDir;



	 			$seardd = json_decode($this->input->post("search_d",TRUE));
	 			$sExtraFilter = "";
	 			if(is_array($seardd) || is_object($seardd)){

 					foreach ($seardd as $key => $row) {

	 					$pKey = intval($row->id );
		 				$sKess = $colsCli[$pKey ];
		 				if($row->type == "date"){
		 					$sExtraFilter .= "TableFilter;0;0;".$row->val.";".$row->val.";".$sKess." ! ";
		 				}else{
		 					$sExtraFilter .= "TableFilter;0;0;*".$row->val."*;".$row->val.";".$sKess." ! ";	
	 				}
		 				
		 				
		 			}
		 			if($sExtraFilter != ""){
		 				$data_report['ExtraFilter'] = $sExtraFilter;
		 			}
	 			}

		 	}else {

		 		$posCol = intval($_POST['order'][0]['column']);
		 		$colDir = $_POST['order'][0]['dir'];
		 		$colsResp = array();

		 		$colsResp[] =  'VDatDocumentos.TipoDocto ';
		 		$colsResp[] =  'VDatDocumentos.Documento';
		 		if($skey == 'cobp' || $skey == 'cobe' || $skey == 'cobc' ){
		 			$colsResp[] =  'VDatRecibos.Serie  ';
		 		}
		 		$colsResp[] =  'VDatDocumentos.DAnterior ';
		 		$colsResp[] = 'DPosterior';

		 		if ($skey == "ren" || $skey == 'pro'){
		 			$colsResp[] =  'VDatDocumentos.FDesde ';
		 		}else{
		 			$colsResp[] =  'VDatRecibos.FLimPago ';
		 		}																

		 		$colsResp[] =  'VDatDocumentos.FHasta';
		 		$colsResp[] =  'VDatDocumentos.Status';
		 		$colsResp[] =  'VCatClientes.NombreCompleto';
		 		$colsResp[] =  'VDatDocumentos.Grupo';
		 		$colsResp[] =  'VDatDocumentos.SubGrupo';
		 		$colsResp[] =  'VDatDocumentos.Concepto';
		 		$colsResp[] =  'VDatDocumentos.Referencia1';
		 		$colsResp[] =  'VDatDocumentos.Referencia2';
		 		$colsResp[] =  'VDatDocumentos.FolioNo';
		 		$colsResp[] =  'VDatDocumentos.Moneda';
		 		$colsResp[] =  'VDatDocumentos.FPago';
		 		$colsResp[] =  'VCatAgentes.CAgente';
		 		$colsResp[] =  'VCatAgentes.AgenteNombre';
		 		$colsResp[] =  'VCatSRamo.SRamoAbreviacion';
		 		$colsResp[] =  'VDatDocumentos.PrimaNeta';
		 		$colsResp[] =  'VDatDocumentos.PrimaTotal';
		 		$colsResp[] =  'VCatVendedores.EjecutNombre';
		 		$colsResp[] =  'VCatVendedores.VendNombre';
		 		// $oDocto = $this->webservice_sicas_soap->GetPolicy_forID_Docto($value->IDDocto);
		 		$colsResp[] =  'ClaveBit ';
		 		$colsResp[] =  'RamosNombre ';
		 		$colsResp[] =  'IDDocto ';

	 			$seardd = json_decode($this->input->post("search_d",TRUE));
	 			$sExtraFilter = "";
	 			if(is_array($seardd) || is_object($seardd)){

	 				foreach ($seardd as $key => $row) {

	 					$pKey = intval($row->id );
		 				$sKess = $colsResp[$pKey ];
		 				if($row->type == "date"){
		 					$sExtraFilter .= "TableFilter;0;0;".$row->val.";".$row->val.";".$sKess." ! ";
		 				}else{
		 					$sExtraFilter .= "TableFilter;0;0;*".$row->val."*;".$row->val.";".$sKess." ! ";	
		 				}
		 				
		 				
		 			}
		 			if($sExtraFilter != ""){
		 				$data_report['ExtraFilter'] = $sExtraFilter;
		 			}
	 			}
	 			
		 		if($posCol > 0)
		 			$data_report['Sort'] = $colsResp[$posCol - 1].' '.$colDir;
	 			
		 	}

		 	$data_report['salesmanIds'] = $this->webservice_sicas_soap->getConditionalVendedor($skey);

				$data_client = $this->webservice_sicas_soap->GetReport($data_report);	
				if(isset($data_client['paginacion']['MaxRecords'])){
					if(isset($data_client['paginacion'])){
						$pages = $data_client['paginacion']['Pages'];
					}

					$userID = $this->tank_auth->get_user_id();
					$sjson = json_encode($data_report);
					if($isNew == "true"){
						$this->reportes_model->deleteBitReporte($userID,$typeR);
						$this->reportes_model->addBitReporte($sjson,$userID,$typeR, ceil($pages / 1000));	
						$oResponse->message = "Se procedera a generar su reporte de ".$name_consultar." este puede demorar unos minutos, se habilitara un botón en la parte superior de la pantalla."; 
						$oResponse->status = true; 
					}else{
						$existR = $this->reportes_model->reportActive($userID,$typeR);
						if(count($existR) > 0){
							$existR = $existR[0];

							if($existR['status'] == 1 || $existR['status'] == 0){
								$oResponse->message = "Se esta procesando un reporte con las mismas condiciones.";	
								$oResponse->status = false;	
								$oResponse->disabled_controls = true;
							}else{
								$oResponse->message = "Existe un reporte de ".$name_consultar." en el sistema con la fecha: ".$existR['fecha'];	
								$oResponse->status = false;	
							}
							
						}else{
							$this->reportes_model->deleteBitReporte($userID,$typeR);

							$this->reportes_model->addBitReporte($sjson,$userID,$typeR,ceil($pages / 1000));	
							$oResponse->message = "Se procedera a generar su reporte de ".$name_consultar." este puede demorar unos minutos, se habilitara un botón en la parte superior de la pantalla."; 
							$oResponse->status = true; 
						}
					}
					
				}

			echo json_encode(array(
			 		'data'=>$oResponse
		 			));	

		}
	}
	
	function reporteVendedoresAjax(){
		if(!$this->tank_auth->is_logged_in()){
			redirect('/auth/login/');
		}else{
			//** Pagina de Consulta
			$sPage = $this->input->post("start");
			if($sPage > 0){
				$sPage = $sPage;
			}else{
				$sPage = 0;
			}
			
			//** Busqueda Filtrada
		 		$posCol		= intval($_POST['order'][0]['column']);
		 		$colDir		= $_POST['order'][0]['dir'];
				
		 		$colsResp	= array();
		 		$colsResp[] = 'Status_TXT';		// 0
		 		$colsResp[] = 'NombreCompleto';	// 1
		 		$colsResp[] = 'DespNombre';		// 2
		 		$colsResp[] = 'Giro';			// 3 
		 		$colsResp[] = 'Expediente';		// 4
		 		$colsResp[] = 'Clasifica_TXT';	// 5
		 		$colsResp[] = 'EMail1';			// 6
		 		$colsResp[] = 'FechaNac';		// 7
		 		$colsResp[] = 'FechaCap';		// 8

	 			$sExtraFilter	= "1";
		 		$seardd			= json_decode($this->input->post("search_d",TRUE));
	 			if(is_array($seardd) || is_object($seardd)){
					$sExtraFilter	= "";
	 				foreach ($seardd as $key => $row) {
	 					$pKey	= intval($row->id );
		 				$sKess	= $colsResp[$pKey ];

		 				if($sKess == "Status_TXT"){
							$sExtraFilter	.= "`$sKess` Like '".strtoupper($row->val)."%' And ";
		 				} else if($sKess == "FechaNac" || $sKess == "FechaCap"){
							$sExtraFilter	.= "`$sKess` Like '%".str_replace('/','-',$row->val)."%' And ";
		 				} else {
							$sExtraFilter	.= "`$sKess` Like '%".strtoupper($row->val)."%' And ";
						}
					}
					$sExtraFilter = trim($sExtraFilter, ' And ');
				}
				$orderBy = "`".$colsResp[$posCol ]."` ".$colDir;

			$sqlConsulta_TotalVendedores = "
				Select * From
					`catalog_vendedores`
				Where
					$sExtraFilter
										   ";
			$query_TotalVendedores	= $this->db->query($sqlConsulta_TotalVendedores);
			$sTotalRegistros		= $query_TotalVendedores->num_rows();

			$sqlConsulta_Vendedores = "
				Select 
					`IDVend`,
					`Status_TXT`,
					`NombreCompleto`,
					`DespNombre`,
					`Giro`,
					`Expediente`,
					`Clasifica_TXT`,
					`EMail1`,
					`FechaNac`,
					`FechaCap`
				From
					`catalog_vendedores`
				Where
					$sExtraFilter
				Order By
					$orderBy
				Limit
					$sPage,25
									  ";

			$query	= $this->db->query($sqlConsulta_Vendedores);

			$tb_vendedores	= array();
			if($query->num_rows()>0){
				foreach($query->result_array() as $value){
					$item					= new \stdClass;
/*0*/			 	$item->Status_TXT		= $this->getValue($value['Status_TXT']); //$this->formatStatusVend($value['Status']);
/*1*/		 		$item->NombreCompleto	= $this->getValue($value['NombreCompleto']);
/*2*/		 		$item->DespNombre		= $this->getValue($value['DespNombre']);
/*3*/			 	$item->Giro				= $this->getValue($value['Giro']);
/*4*/			 	$item->Expediente		= $this->getValue($value['Expediente']);
/*5*/		 		$item->Clasifica_TXT	= $this->getValue($value['Clasifica_TXT']);
/*6*/		 		$item->EMail1			= $this->getValue($value['EMail1']);
/*7*/				$item->FechaNac			= $this->formatDate($this->getValue($value['FechaNac']));
/*8*/				$item->FechaCap			= $this->formatDate($this->getValue($value['FechaCap']));
/* */			 	$item->IDVend			= $this->getValue($value['IDVend']);

//				 	$item->IDVendNS			= $this->getValue($value['IDVendNS']);
//					$item->FHasta			= $this->formatDate($this->getValue($value->FHasta));
//					$item->PrimaNeta		= $this->formatMoney($this->getValue($value->PrimaNeta));
					array_push($tb_vendedores, $item);
				}
			echo json_encode(
				array(
						 		'recordsTotal'		=> $sTotalRegistros,//$query->num_rows(),
				 				'recordsFiltered'	=> $sTotalRegistros,//$query->num_rows(),
				 				'data'				=> $tb_vendedores
						 	)
					 );
			 	}else{
				 	echo json_encode(
						 array(
						 		'recordsTotal'		=> '0',
				 				'recordsFiltered'	=> '0',
				 				'data'				=> $tb_vendedores
						 	)
						 );
				}
		}
	}
//---------------------------------------------------------------------------------------------------------------------------------
function estadoFinanciero(){
//	$this->load->library('libreriaV3');
   
   $anioInicial['anio']=date('Y');
	$this->datosEF['meses']=$this->libreriav3->devolverMeses();
	$this->datosEF['anios']=$this->libreriav3->devolverAnios();
	$this->datosEF['canales']=$this->personamodelo->obtenerCatalogCanales();
	$this->datosEF['coordinadores']=$this->personamodelo->devuelveCoordinadoresVentas();
	$this->datosEF['coordinadoresCatalogo']=$this->catalogos_model->canalesCatalogos($anioInicial);
	
	//$this->datosEF['coordinadoresReportes']=$this->datosEF['coordinadores'];
	$this->datosEF['coordinadoresReportes']=$this->datosEF['coordinadoresCatalogo'];
/*===========ES UN PERMISO PARA VER TODOS(CORREGIR DESPUES)=============*/
if(count($this->datosEF['coordinadoresReportes'])>3)
{
	 $todo=new stdClass();;
     $todo->idPersona=-1;
     $todo->nombres='Todo';
     $todo->apellidoPaterno='';
     $todo->apellidoMaterno='';
     $todo->email='';
     array_push($this->datosEF['coordinadoresReportes'],$todo);
 }



	if(!isset($this->datosEF['fecInicialAvance'])){$this->datosEF['fecInicialAvance']=$this->libreriav3->devolverPrimerDiaMesActual("/",null);$fechaActual=getdate();
     $this->datosEF['fecFinalAvance']=$fechaActual['mday'].'/'.$fechaActual['mon'].'/'.$fechaActual['year'];
    }
    if(!isset($this->datosEF['trPestania'])){$this->datosEF['trPestania']=0;}
	//$this->datosEF['agentesDelCoordinador']=$devuelveCoordinadoresVentas['agentesCoordinador'];
      $consulta['consulta']='ultimaActualizacion';
      //$this->datosEF['ultimaActualizacion']=$this->reportes_model->reportecobranzaclientes($consulta);	
     $this->datosEF['ultimaActualizacion']=$this->reportes_model->ultimaActualizacionReporteCobranzaClientes(null);
     $this->datosEF['fechaInicial']=$this->libreriav3->devolverPrimerDiaMesActual('/','');
     $this->datosEF['fechaFinal']=$this->libreriav3->devolverFechaActual('/','');
    $this->load->view('reportes/estadoFinanciero',$this->datosEF);
   }
//---------------------------------------------------------------------------------------------------------------------------------
function buscarEstadoFinanciero()
 {

 	/*
 	--LA META COMERCIAL DE DONDE SE ES EL MISMO QUE TIENE DENNIS O ES OTRO
 	--EL GASTO DE OPERACION SIGUE SIENDO EL MISMO VALOR(2500)
 	--SIGUE TENIENDO EL MISMO OBJETIVO EL REPORTE SOLO PRESENTAR LO QUE SE LE PAGA AL AGENTE
 	--COMO TRATAR LA INFORMACION CUANDO YA QUE CUANDO SE SINCRONIZA EN ESE MOMENTO SE PUEDE PERDER LA INFORMACION(SE PUEDEN MANEJAR UNAS BANDERAS TANTO EN EL ROBOT QUE TRAE LAS POLIZAS COMO EN EL CONTROLADOR QUE HACE REFERENCIA AL ESTADO FINANCIERO)
 	--SE ELIMINA LAS PESTANIAS DE AVANCE DE ESTADO FINANCIERO Y REPORTE CLIENTES EN ESTADO FINANCIERO

 	--PREGUNTARLE A CRIS EN QUE STATUS ESTA CUANDO SE E PAGA AL AGENTE
 	 */
	$this->datosEF['anioEscogido']=$_POST['selectAnio']; 
	$this->datosEF['mesEscogido']=$_POST['selectMes'];
	$this->datosEF["canal"]="Fianzas";

	#$coordinador=$this->personamodelo->obtenerDatosUsers($_POST['selectCoordinadoresEF']);
	#if($coordinador->email=="COORDINADOR@FIANZASCAPITAL.COM"){$coordinador->email="GERENTE@FIANZASCAPITAL.COM"; $this->datosEF["canal"]="Seguros";}
	#if($coordinador->email=="COORDINADORCOMERCIAL@FIANZASCAPITAL.COM"){$this->datosEF["canal"]="Seguros";}
	
	#$selectEF=$this->reportes_model->getEstadoFinanciero($_POST['selectAnio'],$_POST['selectMes'],$coordinador->email);
#$selectEF=$this->reportes_model->getEstadoFinanciero($_POST['selectAnio'],$_POST['selectMes'],$_POST['selectCoordinadoresEF']);	
	//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($_POST, TRUE));fclose($fp);
	$this->datosEF['estadoFinanciero']=$this->reportes_model->obtenerEstadoFinanciero($_POST['selectAnio'],$_POST['selectMes'],$_POST['selectCoordinadoresEF']);

	
	$this->datosEF['idPersona']=$_POST['selectCoordinadoresEF'];

	$contadorIT=0;
	$contadorCV=0;
	$contadorCVC=0;
	$contadorC=0;
	$contadorCM=0;

	if(isset($selectEF))
	{
		foreach($selectEF as $valor)
		{
			#if($valor->ingresoContrario>0){$contadorIT++;} 
			#if($valor->costoVentaContrario>0){$contadorCV++;} 
			#if($valor->comisionVentaContrario>0){$contadorCVC++;} 
			#if($valor->contribucion>0){$contadorC++;} 
			#if($valor->contribucionMarginalContrario>0){$contadorCM++;}
		}
	}

	#$this->datosEF["ingresoContrarioC"]=$contadorIT;
	#$this->datosEF["costoVentaContrarioC"]=$contadorCV;
	#$this->datosEF["comisionVentaContrarioC"]=$contadorCVC;
	#$this->datosEF["contribucionC"]=$contadorC;
	#$this->datosEF["contribucionMarginalContrarioC"]=$contadorCM;


	$this->estadoFinanciero();
}
//--------------------------------------------------------------------------------------------------------------------------------
function estadoFinancieroAgente(){

$consulta['anio']=$_POST['anio'];
$consulta['idPersona']=$_POST['idPersona'];
$datos['estadoFinanciero']=$this->reportes_model->devolverEstadoFinancieroAgente($consulta);
$sumIT=0;$sumCV=0;$sumCM=0;$sumGO=0;$sumUP=0;$sumMC=0;$sumComVen=0;

foreach ($datos['estadoFinanciero'] as $key =>   $value) 
{
 $value->metaComercialEABFormato=number_format($value->metaComercialEAB,2);
 $sumMC=$sumMC+$value->metaComercialEAB;
 $value->comisionVentaEABFormato=number_format($value->comisionVentaEAB,2);
 $sumComVen=$sumComVen+$value->comisionVentaEAB;
 $value->ingresoTotalesEABFormato=number_format($value->ingresoTotalesEAB,2);
 $sumIT=$sumIT+$value->ingresoTotalesEAB;
 $value->costoVentaEABFormato=number_format($value->costoVentaEAB,2);
 $sumCV=$sumCV+$value->costoVentaEAB;
 $value->gastoOperacionEABFormato=number_format($value->gastoOperacionEAB,2);
 $sumGO=$sumGO+$value->gastoOperacionEAB;
 $value->utilidadPerdidaEABFormato=number_format($value->utilidadPerdidaEAB,2);
 $sumUP=$sumUP+$value->utilidadPerdidaEAB;
 $value->contribucionMarginalEABFormato=number_format($value->contribucionMarginalEAB,2);
 $sumCM=$sumCM+$value->contribucionMarginalEAB;
 //$datos['estadoFinanciero'][$key]->metaComercialEABFormato=number_format($value->metaComercialEAB,2);
}

$datos['meses']=$this->libreriav3->devolverMeses();
$datos['ingresoTotalesEAB']=number_format($sumIT,2);
$datos['costoVentaEAB']=number_format($sumCV,2);
$datos['contribucionMarginalEAB']=number_format($sumCM,2);
$datos['gastoOperacionEAB']=number_format($sumGO,2);
$datos['utilidadPerdidaEAB']=number_format($sumUP,2);
$datos['comisionVentaEAB']=number_format($sumComVen,2);
$datos['metaComercialEAB']=number_format($sumMC,2);
echo json_encode($datos);

}
//--------------------------------------------------------------------------------------------------------------------------------
function BAEF(){
	$this->load->library("WS_Sicas"); 
	 $respuesta=$this->ws_sicas->envioMensualAgentes(1,'01/10/2019','30/10/2019'); 
}
//--------------------------------------------------------------------------------------------------------------------------------

function buscarAvanceEstadoFinanciero()
{
	$this->load->library("WS_Sicas"); 	 	
	$datos=$this->personamodelo->devuelveAgentesPorCoordinadorActivos($_POST['selectCoordinadores']);	
	$row="";
    $cont=0; 	
     	$row=$row.'<tr><th class="EdoFinAgenteClass">#</th><th class="EdoFinAgenteClass">Agente</th><th  class="EdoFinAgenteClass">Venta Nueva</th><th class="EdoFinAgenteClass">Ranking</th><th class="EdoFinAgenteClass">Tipo Agente</th><th class="EdoFinAgenteClass"><label>Canal</label><select id="selectFiltroCanalAvance" class="selectFiltroTabla"  onchange="aplicarFiltro(this.nextSibling,this)"></select><input type="checkbox" id="cc" onclick="aplicarFiltro(this,selectFiltroCanalAvance)"><label>Filtro</label></th><th class="EdoFinAgenteClass">Sucursal</th>';
     	$cont=0;
     	$sumTotal=0;
     	$row=$row.'</tr>';

	foreach ($datos as $value) {

		 $sumaImporteNuevo=0;
		$row=$row.'<tr>';
		$cont++;
		     $respuesta=$this->ws_sicas->envioMensualAgentes($value->IDVend,$_POST['fecInicialAvanceEF'],$_POST['fecFinalAvanceEF']); 
		    // $fp=fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($respuesta, TRUE));fclose($fp);	
	
    foreach($respuesta as $valores)
      {
        //$sumaImporte=$sumaImporte+floatval($valores->ImporteP);
        if($valores->Renovacion==0)
        {
            if($valores->Periodo==1){$sumaImporteNuevo=$sumaImporteNuevo+floatval($valores->ImporteP);}
        }
      }
      $sumTotal=$sumTotal+$sumaImporteNuevo;
      $row=$row.'<td class="EdoFinAgenteClass">'.$cont.'</td>';
      $row=$row.'<td class="EdoFinAgenteClass">'.$value->nombres.' '.$value->apellidoPaterno.'</td>';
      $row=$row.'<td class="EdoFinAgenteClass" align="right">$'.number_format($sumaImporteNuevo,2).'</td>';
      $row=$row.'<td class="EdoFinAgenteClass">'.$value->idpersonarankingagente.'</td>';
      $row=$row.'<td class="EdoFinAgenteClass">'.$value->personaTipoAgente.'</td>';
      $row=$row.'<td class="EdoFinAgenteClass">'.$value->nombreTitulo.'</td>';
      $row=$row.'<td class="EdoFinAgenteClass">'.$value->NombreSucursal.'</td>';     
      $row=$row.'</tr>';

		 }
         $row=$row.'<tr>';
      $row=$row.'<td class="EdoFinAgenteClass"></td>';
      $row=$row.'<td class="EdoFinAgenteClass"></td>';
      $row=$row.'<td class="EdoFinAgenteClass" align="right">$'.number_format($sumTotal,2).'</td>';
      $row=$row.'<td class="EdoFinAgenteClass"></td>';
      $row=$row.'<td class="EdoFinAgenteClass"></td>';
      $row=$row.'<td class="EdoFinAgenteClass"></td>';
      $row=$row.'<td class="EdoFinAgenteClass"></td>';     
      $row=$row.'</tr>';       
		
	$this->datosEF['avanceEF']=$row;
	$this->datosEF['fecInicialAvance']=$_POST['fecInicialAvanceEF'];
	$this->datosEF['fecFinalAvance']=$_POST['fecFinalAvanceEF'];
	$this->datosEF['trPestania']=1;
	$this->datosEF['idPersona']=$_POST['selectCoordinadores'];
	$this->estadoFinanciero();
}

//--------------------------------------------------------------------------------------------------------------------------------
function pagoCompania(){
  $this->load->library("libreriav3");
  $this->datosEF['meses']=$this->libreriav3->devolverMeses();
  $this->datosEF['anios']=$this->libreriav3->devolverAnios();  

 $this->load->view('reportes/pagoCompania',$this->datosEF);
}

//--------------------------------------------------------------------------------------------------------------------------------
function verificarPC(){
if(isset($_POST['selectMesConfig'])){$consultar['mesPC']= $_POST['selectMesConfig'];}
$consultar['anioPC']= $_POST['selectAnioConfig'];
$datos=$this->reportes_model->verificarPC($consultar);
 if(count($datos)>0){
 	$this->datosEF['mensaje']='alert("La fecha de la ultima actualizacion:'.$datos[0]->fechaActualizacionPC.'");';

 }
 else{
 	$this->datosEF['mensaje']='alert("No hay datos disponibles");';
 }
$this->pagoCompania();
}

//-------------------------------------------------------------------------------------------------------------------------------
function actualizarPC(){
	
	    $this->load->library("libreriav3");
	    $this->load->library("WS_Sicas");
//$this->ws_sicas->pruebaWS();
     //$this->datosEF['selectTipoComparasion']=$_POST['selectConfigComparacion'];
      $this->datosEF['selectAnio1']=$_POST['selectAnioConfig'];
      $this->datosEF['selectAnio2']=$_POST['selectAnioConfig'];
      $this->datosEF['selectMes1']=$_POST['selectMesConfig'];

	 if(isset($_POST['selectMesConfig'])){
	 	 $ultimoDiaMes=$this->libreriav3->devolverUltimoDiaDeMes('/',$_POST['selectMesConfig'],$_POST['selectAnioConfig']);
	 	 $primerDiaMes='01/'.$_POST['selectMesConfig'].'/'.$_POST['selectAnioConfig'];
       $recibos=$this->ws_sicas->obtenerRecibosPorFecha($primerDiaMes,$ultimoDiaMes,null);
        $companias=$this->reportes_model->obtenerPromotorias();        
 foreach ($recibos as $value) {
	    foreach ($companias as  $valueCompania) {
	    		if($valueCompania->idPromotoria==$value->IDCia){
                    $valueCompania->primaNetaPC=(double)$valueCompania->primaNetaPC+((double)$value->PrimaNeta*(double)$value->TCPago);
                    $valueCompania->comisionGeneradaPC=(double)$valueCompania->comisionGeneradaPC+(((double)$value->Comision0+(double)$value->Comision1+(double)$value->Comision2+(double)$value->Comision3+(double)$value->Comision4)*(double)$value->TCPago);
	    			break;
	    		}
	    	}	
         }
        //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($companias,TRUE));fclose($fp); 
       $eliminar="delete from pagocompania where anioPC=".$_POST['selectAnioConfig'].' && mesPC='.$_POST['selectMesConfig'];
      $this->reportes_model->manejarPagosCompania($eliminar,'Q');
      foreach ($companias as  $value) { 
      $insert['idPromotoriaCP']= $value->idPromotoria;
      $insert['anioPC']=$_POST['selectAnioConfig'] ;
      $insert['mesPC']= $_POST['selectMesConfig'];
      $insert['primaNetaPC']=$value->primaNetaPC ;
      $insert['comisionGeneradaPC']=$value->comisionGeneradaPC ;
      $this->reportes_model->manejarPagosCompania($insert,'i');      
      }

	   
	 }
	 else{
        
       for($i=1;$i<=12;$i++)
       {
       	$ultimoDiaMes=$this->libreriav3->devolverUltimoDiaDeMes('/',$i,$_POST['selectAnioConfig']);
       	       $recibos=$this->ws_sicas->obtenerRecibosPorFecha();
        //$recibos=$this->ws_sicas->obtenerRecibo($cadena);
        $companias=$this->reportes_model->obtenerPromotorias();
       	 foreach ($recibos as $value) {
	    foreach ($companias as  $valueCompania) {
	    		if($valueCompania->idPromotoria==$value->IDCia){
                    $valueCompania->primaNetaPC=(double)$valueCompania->primaNetaPC+((double)$value->PrimaNeta*(double)$value->TCPago);
                    $valueCompania->comisionGeneradaPC=(double)$valueCompania->comisionGeneradaPC+(((double)$value->Comision0+(double)$value->Comision1+(double)$value->Comision2+(double)$value->Comision3+(double)$value->Comision4)*(double)$value->TCPago);
	    			//break;
	    		}
	    	}	
         }

       }
	 } 
	  $this->pagoCompania();
}
//-------------------------------------------------------------------------------------------------------------------------------
public function compararPagoCompania(){
	$tabla="";
 $sumAnio1=0;$sumAnio2=0;$sumComision1=0;$sumComision2=0;$sumComision0=0;$sumComision1=0;
      $tabla="<thead><tr><td align='center'></td><td align='center' colspan='4'>PRIMA NETA PESOS</td><td align='center' colspan='4'>COMISION GENERADA</td></tr><tr><td align='center'>CIA</td><td align='center'>".$_POST['selectAnio1']."</td><td align='center'>".$_POST['selectAnio2']."</td><td align='center'>CRECIMIENTO</td><td align='right'>DIFERENCIA IMPORTE</td><td align='center'>".$_POST['selectAnio1']."</td><td align='center'>".$_POST['selectAnio2']."</td><td align='center'>CRECIMIENTO</td><td align='right'>DIFERENCIA IMPORTE</td></tr></thead>";
     $tabla=$tabla.'<tbody>';
     $companias=$this->reportes_model->obtenerPromotorias();
	if($_POST['selectTipoComparasion']=='Mes'){
    if((int)$_POST['selectAnio2']>=(int)$_POST['selectAnio1']){
     foreach ($companias as $value) {
     	 $tabla=$tabla.'<tr>';
         $tabla=$tabla.'<td>'.$value->Promotoria.'</td>'; 
         //$consulta="select * from pagocompania pc where pc.idPromotoriaCP=".$value->idPromotoria.' and pc.mesPC='.$_POST['selectMes1'].' and (pc.anioPC='.$_POST['selectAnio1'].' or pc.anioPC='.$_POST['selectAnio2'].')';
         $consulta="select sum(pc.primaNetaPC) as primaNetaPC,sum(pc.comisionGeneradaPC) as comisionGeneradaPC,pc.idPromotoriaCP,pc.anioPC,pc.mesPC from pagocompania pc where pc.idPromotoriaCP=".$value->idPromotoria.' and pc.mesPC='.$_POST['selectMes1'].' and (pc.anioPC='.$_POST['selectAnio1'].' or pc.anioPC='.$_POST['selectAnio2'].') group by pc.anioPC,pc.mesPC';
       
         $datos=$this->reportes_model->manejarPagosCompania($consulta,'qR');

          $primaNetaPC0=0;
           $primaNetaPC1=0;
         if(count($datos)>0){

         	if(count($datos)==1){

         		if((int)$datos[0]->anioPC==(int)$_POST['selectAnio1']){

         	           if((int)$_POST['selectAnio2']==(int)$_POST['selectAnio1']){
         		  $primaNetaPC0=$datos[0]->primaNetaPC;$primaNetaPC1=$datos[0]->primaNetaPC;}
         		  else{$primaNetaPC0=$datos[0]->primaNetaPC;$primaNetaPC1=0;}
         	    }
         	    else{
         		  $primaNetaPC0=0;$primaNetaPC1=$datos[0]->primaNetaPC;
         	    }
         	}
         	else{$primaNetaPC0=$datos[0]->primaNetaPC;$primaNetaPC1=$datos[1]->primaNetaPC;}
         $diferencia=0;$crecimiento=0;
         if($primaNetaPC0==0){
         	$diferencia=$primaNetaPC1;
         	if($primaNetaPC1==0){$crecimiento;}else{$crecimiento=100;}
         }else{
         $diferencia=(float)$primaNetaPC0-(float)$primaNetaPC1;
         $crecimiento=((float)$diferencia*(-100))/(float)($primaNetaPC0);
          }
        
         $sumAnio1=$sumAnio1+$primaNetaPC0; $sumAnio2=$sumAnio2+$primaNetaPC1;
          $tabla=$tabla.'<td align=\'right\'>$'.number_format($primaNetaPC0,2).'</td>'; 
          $tabla=$tabla.'<td align=\'right\'>$'.number_format($primaNetaPC1,2).'</td>'; 
          $tabla=$tabla.'<td align=\'right\'>'.number_format($crecimiento,2).'%</td>'; 
          $tabla=$tabla.'<td align=\'right\'>$'.number_format((float)$diferencia*(-1),2).'</td>';    


            $diferencia=0;$crecimiento=0;$primaNetaPC0=0;$primaNetaPC1=0;
            if(count($datos)==1){
                         		if($datos[0]->anioPC==$_POST['selectAnio1']){
         		$primaNetaPC0=$datos[0]->comisionGeneradaPC;$primaNetaPC1=0;
         	    }
         	    if($datos[0]->anioPC==$_POST['selectAnio1']){
         		  $primaNetaPC0=0;$primaNetaPC1=$datos[0]->comisionGeneradaPC;
         	    }
            	//$primaNetaPC0=$datos[0]->comisionGeneradaPC;$primaNetaPC1=$datos[0]->comisionGeneradaPC;
            	}
            else{$primaNetaPC0=$datos[0]->comisionGeneradaPC;$primaNetaPC1=$datos[1]->comisionGeneradaPC;}
                   if($primaNetaPC0==0){
         	$diferencia=$primaNetaPC1;
         	if($primaNetaPC1==0){$crecimiento;}else{$crecimiento=100;}
         }else{
         $diferencia=(float)$primaNetaPC0-(float)$primaNetaPC1;
         $crecimiento=((float)$diferencia*(-100))/(float)($primaNetaPC0);
          }
          $sumComision1=$sumComision1+$primaNetaPC0;$sumComision2=$sumComision2+$primaNetaPC1;
          $tabla=$tabla.'<td align=\'right\'>$'.number_format($primaNetaPC0,2).'</td>'; 
          $tabla=$tabla.'<td align=\'right\'>$'.number_format($primaNetaPC1,2).'</td>'; 
          $tabla=$tabla.'<td align=\'right\'>'.number_format($crecimiento,2).'%</td>'; 
          $tabla=$tabla.'<td align=\'right\'>$'.number_format((float)$diferencia*(-1),2).'</td>';
   
     	 $tabla=$tabla.'</tr>';
     	}
     	else{
     	$this->datosEF['mensaje']='alert("No existen datos en estos meses");';	
     	}

     }
    }
    else{$this->datosEF['mensaje']='alert("El primer año debe ser menor");';	}
   

     $tabla=$tabla.'<tfoot>';
      $tabla=$tabla.'<tr>';
      $tabla=$tabla.'<td></td>';
      $tabla=$tabla.'<td align=\'right\'>$'.number_format($sumAnio1,2).'</td>';
      $tabla=$tabla.'<td align=\'right\'>$'.number_format($sumAnio2,2).'</td>';
      $tabla=$tabla.'<td align=\'right\'>'.number_format(((($sumAnio2-$sumAnio1)*100)/$sumAnio1),2).'%</td>';
      $tabla=$tabla.'<td align=\'right\'>$'.number_format($sumAnio2-$sumAnio1,2).'</td>';
      $tabla=$tabla.'<td align=\'right\'>$'.number_format($sumComision1,2).'</td>';
      $tabla=$tabla.'<td align=\'right\'>$'.number_format($sumComision2,2).'</td>';
      $comisionG=(($sumComision2-$sumComision1)==0) ? number_format(((($sumComision2-$sumComision1)*100)/$sumComision1),2):0;
      $tabla=$tabla.'<td align=\'right\'>'.$comisionG.'%</td>';
      $tabla=$tabla.'<td align=\'right\'>$'.number_format($sumComision2-$sumComision1,2).'</td>';
      $tabla=$tabla.'</tr>';
     $tabla=$tabla.'</tfoot>';
    
     
 
      $this->datosEF['selectMes1']=$_POST['selectMes1'];
	}
	else
	{/*======COMPARACION POR AÑO=============================*/

     if((int)$_POST['selectAnio2']>=(int)$_POST['selectAnio1']){
     foreach ($companias as $value) {
 
     	 $tabla=$tabla.'<tr>';
         $tabla=$tabla.'<td>'.$value->Promotoria.'</td>';        
         $primaNetaPC0=0;
         $primaNetaPC1=0;
         $comisionNetaPC0=0;
         $comisionNetaPC1=0;
         $sumAnioComision2=0;
         $sumAnioComision1=0;
         for($i=1;$i<=12;$i++){
         $consulta="select sum(pc.primaNetaPC) as primaNetaPC,sum(pc.comisionGeneradaPC) as comisionGeneradaPC,pc.idPromotoriaCP,pc.anioPC,pc.mesPC from pagocompania pc where pc.idPromotoriaCP=".$value->idPromotoria.' and pc.mesPC='.$i.' and (pc.anioPC='.$_POST['selectAnio1'].' or pc.anioPC='.$_POST['selectAnio2'].')  group by pc.anioPC,pc.mesPC';

         $datos=$this->reportes_model->manejarPagosCompania($consulta,'qR');
         if(count($datos)>0){

         	if(count($datos)==1){

         		if((int)$datos[0]->anioPC==(int)$_POST['selectAnio1']){
         			//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r((int)$datos[0]->anioPC.(int)$_POST['selectAnio1'],TRUE));fclose($fp); 
         	           if((int)$_POST['selectAnio2']==(int)$_POST['selectAnio1']){
         		  $primaNetaPC0=$primaNetaPC0+$datos[0]->primaNetaPC;$primaNetaPC1=$primaNetaPC1+$datos[0]->primaNetaPC;
                    $comisionNetaPC0=$comisionNetaPC0+$datos[0]->comisionGeneradaPC;$comisionNetaPC1=$comisionNetaPC0+$datos[0]->comisionGeneradaPC;
         		}
         		  else{$primaNetaPC0=$primaNetaPC0+$datos[0]->primaNetaPC;$primaNetaPC1=$primaNetaPC1+0;
                       $comisionNetaPC0=$comisionNetaPC0+$datos[0]->comisionGeneradaPC;$comisionNetaPC1=$comisionNetaPC1+0; 
         		  }
         	    }
         	    else{
         		  $primaNetaPC0=$primaNetaPC0+0;$primaNetaPC1=$primaNetaPC1+$datos[0]->primaNetaPC;
         		  $comisionNetaPC0=$comisionNetaPC0+0;$comisionNetaPC1=$comisionNetaPC1+$datos[0]->comisionGeneradaPC;
         	    }
         	}
         	else{$primaNetaPC0=$primaNetaPC0+$datos[0]->primaNetaPC;$primaNetaPC1=$primaNetaPC1+$datos[1]->primaNetaPC;
                 $comisionNetaPC0= $comisionNetaPC0+$datos[0]->comisionGeneradaPC;$comisionNetaPC1=$comisionNetaPC1+$datos[1]->comisionGeneradaPC;
         	    }
         }
       
     }
     $diferencia=0;$crecimiento=0;$diferenciaComision=0;$crecimientoComision=0;
         if($primaNetaPC0==0){
         	$diferencia=$primaNetaPC1;$diferenciaComision=$comisionNetaPC1;
         	if($primaNetaPC1==0){$crecimiento;}else{$crecimiento=100;$crecimientoComision=100;}
         }else{
         $diferencia=(float)$primaNetaPC0-(float)$primaNetaPC1;
         $crecimiento=((float)$diferencia*(-100))/(float)($primaNetaPC0);

                  $diferenciaComision=(float)$comisionNetaPC0-(float)$comisionNetaPC1;
            //  $porcentaje=($sumComision1!=0 || $sumComision0!=0) ? (number_format(((($sumComision1-$sumComision0)*100)/$sumComision0),2)) : 0;
         //$crecimientoComision=((float)$diferenciaComision*(-100))/(float)($comisionNetaPC0);
         $crecimientoComision=($diferenciaComision!=0 || $comisionNetaPC0!=0) ? ((float)$diferenciaComision*(-100))/(float)($comisionNetaPC0) : 0;
          }
        
         $sumAnio1=$sumAnio1+$primaNetaPC0; $sumAnio2=$sumAnio2+$primaNetaPC1;
         $sumComision0=$sumComision0+$comisionNetaPC0; $sumComision1=$sumComision1+$comisionNetaPC1;
          $tabla=$tabla.'<td align=\'right\'>$'.number_format($primaNetaPC0,2).'</td>'; 
          $tabla=$tabla.'<td align=\'right\'>$'.number_format($primaNetaPC1,2).'</td>'; 
          $tabla=$tabla.'<td align=\'right\'>'.number_format($crecimiento,2).'%</td>'; 
          $tabla=$tabla.'<td align=\'right\'>$'.number_format((float)$diferencia*(-1),2).'</td>';    

                    $tabla=$tabla.'<td align=\'right\'>$'.number_format($comisionNetaPC0,2).'</td>'; 
          $tabla=$tabla.'<td align=\'right\'>$'.number_format($comisionNetaPC1,2).'</td>'; 
          $tabla=$tabla.'<td align=\'right\'>'.number_format($crecimientoComision,2).'%</td>'; 
          $tabla=$tabla.'<td align=\'right\'>$'.number_format((float)$diferenciaComision*(-1),2).'</td>'; 

      $tabla=$tabla.'</tr>';
    }

$tabla=$tabla.'<tr>';
$tabla=$tabla.'<td></td>';
$tabla=$tabla.'<td align=\'right\'>$'.number_format($sumAnio1,2).'</td>';
$tabla=$tabla.'<td align=\'right\'>$'.number_format($sumAnio2,2).'</td>';
$tabla=$tabla.'<td align=\'right\'>'.number_format(((($sumAnio2-$sumAnio1)*100)/$sumAnio1),2).'%</td>';
$tabla=$tabla.'<td align=\'right\'>$'.number_format($sumAnio2-$sumAnio1,2).'</td>';
$tabla=$tabla.'<td align=\'right\'>$'.number_format($sumComision0,2).'</td>';
$tabla=$tabla.'<td align=\'right\'>$'.number_format($sumComision1,2).'</td>';
$porcentaje=($sumComision1!=0 || $sumComision0!=0) ? (number_format(((($sumComision1-$sumComision0)*100)/$sumComision0),2)) : 0;
$tabla=$tabla.'<td align=\'right\'>'.$porcentaje.'%</td>';
$tabla=$tabla.'<td align=\'right\'>$'.number_format($sumComision1-$sumComision0,2).'</td>';
$tabla=$tabla.'<tr>';


    }
     else{$this->datosEF['mensaje']='alert("El primer año debe ser menor");';	}
   

}

 $tabla=$tabla.'</tbody>';	


     $this->datosEF['selectTipoComparasion']=$_POST['selectTipoComparasion'];
      $this->datosEF['selectAnio1']=$_POST['selectAnio1'];
      $this->datosEF['selectAnio2']=$_POST['selectAnio2'];
 $this->datosEF['tablePagoCompania']=$tabla;

	$this->pagoCompania();
}
//----------------------------------------------------------------------------------------------
function reporteCobranzaCliente(){
	if(empty($_POST))
	{     
       $_POST=$_GET;
       $_POST['exportar']=1;
	}
   
  $status=array();
  $consulta['idPersona']=$_POST['idPersona'];
  $fInicial=explode('/', $_POST['fechaInicial']);
  $fFinal=explode('/', $_POST['fechaFinal']);
  $_POST['where']='';
  if($_POST['fechaFiltro']!=''){
  //$_POST['where']=' and (rcc.fLimPago>="'.$fInicial[2].'-'.$fInicial[1].'-'.$fInicial[0].'" and rcc.fLimPago<="'.$fFinal[2].'-'.$fFinal[1].'-'.$fFinal[0].'")';	
  $_POST['where']=' and (rcc.'.$_POST['fechaFiltro'].'>="'.$fInicial[2].'-'.$fInicial[1].'-'.$fInicial[0].'" and rcc.'.$_POST['fechaFiltro'].'<="'.$fFinal[2].'-'.$fFinal[1].'-'.$fFinal[0].'")';
  }    
  if($_POST['renovacion']==0){$_POST['where'].=' and renovacion=0 and periodo=1';}
  else{if($_POST['renovacion']==1){$_POST['where'].=' and  periodo>1';}}
  if($_POST['Liquidado']==1){array_push($status,'status_TXT="Liquidado"');}
  if($_POST['Cancelado']==1){array_push($status,'status_TXT="Cancelado"');}
  if($_POST['Pagado']==1){array_push($status,'status_TXT="Pagado"');}
  if($_POST['Pendiente']==1){array_push($status,'status_TXT="Pendiente"');}
  $totalStatus=count($status);
  if($totalStatus>0){
  	$cont=1;
  	$_POST['where'].=' and (';
   foreach ($status as  $value) {
   	if($totalStatus==1){$_POST['where'].=$value;}
   	else
   	{
   	 if($cont==1){$_POST['where'].=$value;$cont++;}
   	 else{$_POST['where'].=' || '.$value;}	
    }
   }
   $_POST['where'].=')';
  }
  $datos['reportecobranzaclientes']=$this->reportes_model->reportecobranzaclientes($_POST);

   if(isset($_POST['exportar'])){$this->exportarReporteCobranzaCliente($datos['reportecobranzaclientes']);} 
  else{	echo json_encode($datos);}

}

//-----------------------------------------------------------------------------------------------
function exportarReporteCobranzaCliente($array){
 $body="";

 $nombre="reporteClientes";
 //$datos=$this->reportes_model->reportecobranzaclientes($_GET);	
 $datos=$array;	
 //
 $body='<table border="1"><thead>
    <tr>
      <th>documento</th>
      <th>endoso</th>
      <th>periodo</th>
      <th>serie</th>
      <th>renovacion</th>
      <th>fDesde</th>
      <th>fHasta</th>
      <th>fLimPago</th>
      <th>fStatus</th>
      <th>status_TXT</th>
      <th>primaNeta</th>
      <th>recargos</th>
      <th>derechos</th>
      <th>impuesto1</th>
      <th>primaTotal</th>
      <th>comision0</th>
      <th>anterior</th>
      <th>grupo</th>
      <th>subGrupo</th>
      <th>cCobro_TXT</th>
      <th>statusDoc_TXT</th>
      <th>concepto</th>
      <th>nombreCompleto</th>
      <th>email1</th>
      <th>telefono1</th>
      <th>nombreCompania</th>
      <th>ejecutNombre</th>
      <th>vendNombre</th>
      <th>fPago</th>
      <th>moneda</th>
      <th>sRamoNombre</th>
      <th>ramosNombre</th>
      <th>tipoDocto_TXT</th>
      <th>abreviacionVend</th>
      <th>TCPago</th>
    </tr>
  </thead>
  <tbody id="tbodyReporteClientes">';
  foreach ($datos as  $value) {

    $body=$body.'<tr>';
    $body=$body.'<td>'.$value['documento'].'</td>';
    $body=$body.'<td>'.$value['endoso'].'</td>';
    $body=$body.'<td>'.$value['periodo'].'</td>';
    $body=$body.'<td>'.$value['serie'].'</td>';
    $body=$body.'<td>'.$value['renovacion'].'</td>';
    $body=$body.'<td>'.$value['fDesde'].'</td>';
    $body=$body.'<td>'.$value['fHasta'].'</td>';
    $body=$body.'<td>'.$value['fLimPago'].'</td>';
    $body=$body.'<td>'.$value['fStatus'].'</td>';
    $body=$body.'<td>'.$value['status_TXT'].'</td>';
    $body=$body.'<td align="right">'.$value['primaNeta'].'</td>';
    $body=$body.'<td align="right">'.$value['recargos'].'</td>';
    $body=$body.'<td align="right">'.$value['derechos'].'</td>';
    $body=$body.'<td align="right">'.$value['impuesto1'].'</td>';
    $body=$body.'<td align="right">'.$value['primaTotal'].'</td>';
    $body=$body.'<td align="right">'.$value['comision0'].'</td>';
    $body=$body.'<td>'.$value['anterior'].'</td>';
    $body=$body.'<td>'.$value['grupo'].'</td>';
    $body=$body.'<td>'.$value['subGrupo'].'</td>';
    $body=$body.'<td>'.$value['cCobro_TXT'].'</td>';
    $body=$body.'<td>'.$value['statusDoc_TXT'].'</td>';
    $body=$body.'<td>'.$value['concepto'].'</td>';
    $body=$body.'<td>'.$value['nombreCompleto'].'</td>';
    $body=$body.'<td>'.$value['email1'].'</td>';
    $body=$body.'<td>'.$value['telefono1'].'</td>';
    $body=$body.'<td>'.$value['nombreCompania'].'</td>';
    $body=$body.'<td>'.$value['ejecutNombre'].'</td>';
    $body=$body.'<td>'.$value['vendNombre'].'</td>';
    $body=$body.'<td>'.$value['fPago'].'</td>';
    $body=$body.'<td>'.$value['moneda'].'</td>';
    $body=$body.'<td>'.$value['sRamoNombre'].'</td>';
    $body=$body.'<td>'.$value['ramosNombre'].'</td>';
    $body=$body.'<td>'.$value['tipoDocto_TXT'].'</td>';
    $body=$body.'<td>'.$value['abreviacionVend'].'</td>';
    $body=$body.'<td>'.$value['TCPago'].'</td>';
    $body=$body.'</tr>'; 
  }
  $body.='</tbody></table>';
    //Inicio de la instancia para la exportación en Excel
  header('Content-type: application/vnd.ms-excel');
  header("Content-Disposition: attachment; filename=".$nombre.".xls");
  header("Pragma: no-cache");
  header("Expires: 0");

  echo $body;

}

//-----------------------------------------------------------------------------------------------
//Dennis [2020-12-30]
function rendicionDeCuentas(){

	$array_index=array();
	$id_vendedores=array();

	$sucursales=$this->personamodelo->obtenerCatalogSucursales();
	$ramosSicas=$this->catalogos_model->get_Ramos();
	$canales=$this->personamodelo->obtenerCatalogCanalSicas();
	$idMeta=$this->personamodelo->obtenerMetaComercialAnual($this->tank_auth->get_idPersona());
	//$metaComercial=$this->personamodelo->regresaMontodelMes(date("m"),$idMeta->idMetaComercial);
	$vendedoresActivos=$this->personamodelo->obtVendAct();

	foreach($vendedoresActivos as $valores){
		array_push($id_vendedores, $valores->idVend);
	}

	$grupos=$this->catalogos_model->obtener_grupos_habilitados();
	$subgrupos=$this->catalogos_model->obtener_subgrupos();

	$array_index["sucursal"]=$sucursales;
	$array_index["ramosSicas"]=$ramosSicas;
	$array_index["canales"]=$canales;
	$array_index["id_vendedores"]=$id_vendedores;
	//$array_index["metaComercial"]=$metaComercial;
	$array_index["grupos"]=$grupos;
	$array_index["subgrupos"]=$subgrupos;
	$array_index["vendedores"]=$vendedoresActivos;


	$this->load->view("rendicionDeCuenta/principal",$array_index);


}
//-----------------------------------------------------------------------------------------------
//Dennis [2020-12-30]
function verificarResultado(){

	set_time_limit(0);
  $this->load->library("WS_Sicas"); 
  $array['fechaInicial']='1-10-2020';
  $array['fechaFinal']='31-10-2020';
  $array['filtroGrupo']=array();//[10,14,16,3,1];
  $array['filtroDespacho']=array();//[6];//[1,2,4,5,6,7,8,9];
  $array['filtroGerencia']=array();//[7]; //[5,6,9];
  $array['filtroRamo']=[6]; //[1,2,3,4];
  //$array['tipoReporte']='institucional';
  $array['tipoFecha']='FDocto'; //(FDesde,FHasta,FLimPago,FGeneracion,FStatus,FDocto)/
  $array['filtroStatus']=[3];

	$respuesta=$this->ws_sicas->polizas_emitidas_asesores(); //polizas_emitidas_asesores //recibosClientes($array)
	//$respuesta=$this->personamodelo->devuelveAgentesPorCoordinadorActivos(195);
	$vend=array();

	foreach($respuesta as $rr){

		array_push($vend,$rr->IDVend);
	}

	

	var_dump($respuesta);
}
//--------------------------------------------------------------------------------------------

// Miguel Jaime 02/11/2020
function reporteCitasOnline(){
	$this->load->model('crmProyecto_Model');
	$data['AgentesActivos']=$this->crmProyecto_Model->AgentesActivos();
	$citasOnline=$this->crmProyecto_Model->getCitasOnline();
	
	$fechaCitas='';
	$ctEnero=0;$ctFebrero=0;$ctMarzo=0;$ctAbril=0;
	$ctMayo=0;$ctJunio=0;$ctJulio=0;$ctAgosto=0;
	$ctSeptiembre=0;$ctOctubre=0;$ctNoviembre=0;$ctDiciembre=0;
	
	foreach ($citasOnline as $citas) {
		$fechaCitas=$citas->fecha;
		if($fechaCitas!=""){
			$mesCita = explode("/", $fechaCitas);
			if($mesCita[1]==1){$ctEnero++;}
			if($mesCita[1]==2){$ctFebrero++;}
			if($mesCita[1]==3){$ctMarzo++;}
			if($mesCita[1]==4){$ctAbril++;}
			if($mesCita[1]==5){$ctMayo++;}
			if($mesCita[1]==6){$ctJunio++;}
			if($mesCita[1]==7){$ctJulio++;}
			if($mesCita[1]==8){$ctAgosto++;}
			if($mesCita[1]==9){$ctSeptiembre++;}
			if($mesCita[1]==10){$ctOctubre++;}
			if($mesCita[1]==11){$ctNoviembre++;}
			if($mesCita[1]==12){$ctDiciembre++;}
		}
	}
	$data['enero']=$ctEnero;
	$data['febrero']=$ctFebrero;
	$data['marzo']=$ctMarzo;
	$data['abril']=$ctAbril;
	$data['mayo']=$ctMayo;
	$data['junio']=$ctJunio;
	$data['julio']=$ctJulio;
	$data['agosto']=$ctAgosto;
	$data['septiembre']=$ctSeptiembre;
	$data['octubre']=$ctOctubre;
	$data['noviembre']=$ctNoviembre;
	$data['diciembre']=$ctDiciembre;
	$this->load->view('reportes/citas_online',$data);
}

function detalleCitas(){
	$id=$_GET['id'];
	$this->load->model('crmProyecto_Model');
	$data['citas_online']=$this->crmProyecto_Model->get_all_citas_asesores($id);
	$data['promedio']=$this->crmProyecto_Model->promedio($id);
	$this->load->view('reportes/detalle_citas_online',$data);	
}

//----------------------------------------------------------------------------------------------
//Dennis [2020-12-11] -> [2020-12-30]->[2021-01-13]->[2021-02-17]->[2021-04-20]-> [2021-05-11] -> [2021-06-15] -> [2021-06-22]

function consultaPolizas(){

	$resultados=array();

	set_time_limit(0); 
	$tipoRep=array();
	$tipoRep=($_GET["tipoReporte"]==3) ? array(3,4) : array($_GET["tipoReporte"]);

	$this->load->library("WS_Sicas"); 
	$array['fechaInicial']=str_replace("/","-",$_GET["fechaI"]);
	$array['fechaFinal']=str_replace("/","-",$_GET["fechaF"]);
	$array['filtroGrupo']= (!empty($_GET["grupoSicas"])) ? $_GET["grupoSicas"] : array(); //[10,14,16,3,1]; //array
	$array['excepcionGrupo']=$_GET["excepcion_grupos"];
	$array['filtroSubGrupo']= (!empty($_GET["subgrupoSicas"])) ? $_GET["subgrupoSicas"] : array();
	$array['excepcionSubGrupo']=$_GET["excepcion_subgrupos"];
	$array['filtroDespacho']=(!empty($_GET["despachoSicas"])) ? $_GET["despachoSicas"] : array(); //[1,2,4,5,6,7,8,9]; //array
	$array['excepcionDespacho']=$_GET["excepcion_sucursal"];
	$array['filtroGerencia']=(!empty($_GET["canalSicas"])) ? $_GET["canalSicas"] : array(); //$_GET["canalSicas"]; //[5,6,9]; //array
	$array['excepcionCanales']=$_GET["excepcion_canales"];
	$array['filtroRamo']=(!empty($_GET["ramosSicas"])) ? array_unique($_GET["ramosSicas"]) : array(); //$_GET["ramosSicas"]; //[1,2,3,4]; //array
	$array['excepcionRamos']=$_GET["excepcion_ramos"];
	//$array['tipoReporte']='institucional';
	$array['tipoFecha']=(!empty($_GET["tipoFechaDoc"])) ? $_GET["tipoFechaDoc"] : array(); //'FLimPago';//FDesde,FHasta,FLimPago,FGeneracion,FStatus,FDocto
	$array['filtroVendedor']=(!empty($_GET["vendSicas"])) ? $_GET["vendSicas"] : array(); //'FLimPago';
	$array['excepcionVendedor']=$_GET["excepcion_vendedor"];
	$array['filtroStatus']=$tipoRep; //$_GET["tipoReporte"]; //[1]; //[3,4];

	$resultado=$this->ws_sicas->recibosClientes($array); //Solicitud a Sicas.
	$result1 = array(
        'recibos' => $resultado->TableInfo,
        'pginacion' => $resultado->TableControl
      );
	$result2 = array();
	foreach ($result1['recibos'] as $rc) {
			if ($rc->IDEnd == "-1") { //Recibos activos por medio de H03430_003
				array_push($result2, $rc);
			}
		}
	$respuesta = array(
		"TableInfo" => $result2
	);
	//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($array,TRUE));fclose($fp);
	//Armado de array mensual.

	$meses_anio=array(1,2,3,4,5,6,7,8,9,10,11,12);
	$semanas_mes=array(0,1,2,3);
	$pila_meses=array();
	$mes_cont=array();
	$valida_meses=array();

	$cobranza_general=array();

	$array_doc=array();

	$totalPolizas=0;
	$colaboradores=array();
	$nombres_columnas=array();
	//$ppp=0;
	//$comisionUnitaria=0;

	$tipo_docto="";

	$cont_meses=count($meses_anio);

	$primaFP=array();
	$primaFPa=0;
	$comisionFP=0;
	$ultimaFecha="";

	//------------------------------------------------
	//Gestión de fechas semanales.
	$p_s_f_s=array();
	$p_s_f_u=array();

	//$fecha_filtro = explode("-", date("Y-m-d", strtotime(str_replace("/","-",$_GET["fechaI"])))); //Descomentar para validar 5 semanas
	//$ultimo_fecha_del_mes = date("Y-m-d", mktime(0,0,0,$fecha_filtro[1] + 1,0,$fecha_filtro[0])); //Descomentar para validar 5 semanas
	//$_valida_dias = array("Thursday","Friday","Saturday"); //Descomentar para validar 5 semanas
	$_semanas = 3;

	for($b=strtotime(str_replace("/","-",$_GET["fechaI"])); $b<=strtotime(str_replace("/","-",$_GET["fechaF"]."+ 1 days")); $b+=86400){
			
		if(date("l", $b)=="Sunday"){
			array_push($p_s_f_s,date("Y-m-d", $b));
		}
	}

	//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($p_s_f_s,TRUE));fclose($fp);
	$p_s_f_u=array_values(array_unique($p_s_f_s)); //(!empty($p_s_f[$meses_anio[$i]])) ? array_values(array_unique($p_s_f[$meses_anio[$i]])) : array_values(array_unique($p_s_f_s[$meses_anio[$i]])); //array_values(array_unique($p_s_f[$meses_anio[$i]])); //Eliminar duplicador y re-indexar array.

	sort($p_s_f_u); //Ordenar los domingos.
	//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($p_s_f_u,TRUE));fclose($fp);
	//Si la fecha inicial es un jueves, viernes y fin de semana eliminar el primer domingo del array: [0].
	if(date("l", strtotime(str_replace("/","-",$_GET["fechaI"])))=="Friday" || date("l", strtotime(str_replace("/","-",$_GET["fechaI"])))=="Thursday" || date("l", strtotime(str_replace("/","-",$_GET["fechaI"])))=="Sunday" || date("l", strtotime(str_replace("/","-",$_GET["fechaI"])))=="Saturday"){
		unset($p_s_f_u[0]);
	}

	//Descomentar para validar semana 5
	//if(date("Y-m-d", strtotime(str_replace("/","-",$_GET["fechaF"]))) == $ultimo_fecha_del_mes && in_array(date("l", strtotime($ultimo_fecha_del_mes)), $_valida_dias)){

	//	$_semanas = 4;
		//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r("correcto",TRUE));fclose($fp);
	//}

	$domingos_fijos=array_values($p_s_f_u);
	$array_fechas_semanal=array();
	$array_semanal_definitivo=array();

	$contador_domingo=0;

	for($a=0; $a<count($domingos_fijos);$a++){

		 if($a < $_semanas){ //4 //$domingos_fijos[$a]!=end($domingos_fijos)

			array_push($array_fechas_semanal, date("Y-m-d", strtotime($domingos_fijos[$a]."+ 1 days"))); //$domingos_fijos[$meses_anio[$i]][$a]
			array_push($array_fechas_semanal,$domingos_fijos[$a]); //Almacenar los domingos en un nuevo array contenedor.
		}
	}
	
	//Almacenar fechas iniciales.
	array_push($array_fechas_semanal,date("Y-m-d", strtotime(str_replace("/","-",$_GET["fechaI"]))),date("Y-m-d", strtotime(str_replace("/","-",$_GET["fechaF"]))));

	$array_semanal_definitivo=array_values(array_unique($array_fechas_semanal)); //Eliminar duplicador y re-indexar array.

	sort($array_semanal_definitivo); //Ordenar el mes.

	$segmentacion_fechas=array_chunk($array_semanal_definitivo,2); //Dividir el array en segmentos de doe elementos.

	$validador_semanas=array();

		//Proceso de relleno de semanas.
	for($j=0;$j<count($semanas_mes); $j++){
		for($k=0;$k<count($segmentacion_fechas); $k++){
			if($j==$k){
				array_push($validador_semanas,$j); //Almacena numero de semana validado.
			}
			if(count($segmentacion_fechas[$k])==1){ //Proceso que asigna una fecha final (asigna misma fecha de inicio como final) siempre y cuando haya una fecha vigente en la semana.
				$segmentacion_fechas[$k][1]=$segmentacion_fechas[$k][0];
			}
		}
		if(!in_array($j,$validador_semanas)){
			$segmentacion_fechas[$k][0]=0;
			$segmentacion_fechas[$k][1]=0;
		}
	}
	
	//------------------------------------------------
	//En caso de que el reporte sea meramente de Fianzas.
	if($this->tank_auth->get_idPersona()==805){

		$historico_reg=array();
		
		$requestFianzas=$this->consultaDeEmitidosFianzas($array); //Polizas emitidas.
		$requestPendientesFianzas=$this->ws_sicas->polizasPendientesFianzas($array);
		

		if(!empty($requestPendientesFianzas)){
			foreach($requestPendientesFianzas->TableInfo as $dataFP){

				$primaFPa+=(Float)$dataFP->PrimaNeta*(Float)$dataFP->TCDay;
				$comisionFP+=((float)$dataFP->Comision0+(float)$dataFP->Comision1+(float)$dataFP->Comision2+(float)$dataFP->Comision3+(float)$dataFP->Comision4+(float)$dataFP->Comision5+(float)$dataFP->Comision6+(float)$dataFP->Comision7+(float)$dataFP->Comision8+(float)$dataFP->Comision9)*(Float)$dataFP->TCDay;
			}
		}

		//Proceso de guardado de historial
		$historico_reg["ultima_fecha"]=end($domingos_fijos); //!empty($domingos_fijos) ? end($domingos_fijos) : date("Y-m-d", strtotime(str_replace("/","-",$_GET["fechaI"]))); //end($domingos_fijos);
		$historico_reg["comision_pendiente"]=$comisionFP;
		$historico_reg["prima_pendiente"]=$primaFPa;

		$validador_de_historico=$this->reportes_model->consultaFechasDePolizasPendientesDeFianzas(end($domingos_fijos));

		if(empty($validador_de_historico) && date("W")==date("W", strtotime(end($domingos_fijos)."+  1 days"))){
			$this->reportes_model->insertaPolizasPendientesSicas($historico_reg);
			
		} elseif(!empty($validador_de_historico) && date("W")==date("W", strtotime(end($domingos_fijos)."+  1 days"))){
			$this->reportes_model->actualizaPolizasPendientesSicas($historico_reg);
		}
	}
	//domingos_fijos
	//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r(date("W", strtotime(end($domingos_fijos)."+ 1 days")),TRUE));fclose($fp);
	//------------------------------------------------

	for($i=0;$i<$cont_meses;$i++){

		$contenedor_documento[$meses_anio[$i]]=array();
		$primasEmitidas[$meses_anio[$i]]=array(); //$primasEmitidas[11]=array(); $primasEmitidas[10]=array(); $primasEmitidas[09]=array();
		$comisionEmitida[$meses_anio[$i]]=0;
		//$segmentacion_fechas[$meses_anio[$i]]=array();
		$meta_mensual[$meses_anio[$i]]=0;
		$meta_ideal[$meses_anio[$i]]=0;
		$idMeta[$meses_anio[$i]]=array();
		$idMeta_ingreso_total[$meses_anio[$i]]=array();
		$metacomercial[$meses_anio[$i]]=array();
		$contador_polizas[$meses_anio[$i]]=0;
		$comisionUnitarioPagado[$meses_anio[$i]]=0;
		$comision_subsecuente[$meses_anio[$i]]=array();
		$pila_total_pn[$meses_anio[$i]]=array();
		$pila_total_ps[$meses_anio[$i]]=array();
		$pila_total_pt[$meses_anio[$i]]=array();
		$pila_total_pp[$meses_anio[$i]]=array();
		$pila_total_pe[$meses_anio[$i]]=array();
		$pila_total_pe_n[$meses_anio[$i]]=array();
		$pila_fianzas_emitidos[$meses_anio[$i]] = array();
		$pila_fianzas_efectuados[$meses_anio[$i]] = array();

		foreach($respuesta['TableInfo'] as $valor){

			switch($_GET["tipoFechaDoc"]){
				case "FLimPago": $tipo_docto=(string)$valor->FLimPago;
				break;
				case "FDoctoPago" || "FDocto": $tipo_docto=(string)$valor->FechaDocto;
				break;
				case "FHasta": $tipo_docto=(string)$valor->FHasta;
				break;
				case "FDesde": $tipo_docto=(string)$valor->FDesde;
				break;
				case "FEmision": $tipo_docto=(string)$valor->FEmision;
				break;
			}

			$porEmision=$_GET["tipoFechaDoc"] == "FEmision" ? explode("T",(string)$valor->FEmision) : "";

			$mes_numerico[$meses_anio[$i]]=date("n", strtotime(($_GET["tipoFechaDoc"] == "FEmision" ? $porEmision[0] : $tipo_docto)));
			$dia_numerico[$meses_anio[$i]]=date("l", strtotime(($_GET["tipoFechaDoc"] == "FEmision" ? $porEmision[0] : $tipo_docto)));
			$fecha_registro[$meses_anio[$i]]=date("Y-m-d", strtotime(($_GET["tipoFechaDoc"] == "FEmision" ? $porEmision[0] : $tipo_docto))); //$tipo_docto

			if($meses_anio[$i] == $mes_numerico[$meses_anio[$i]] && (array_key_exists("GerneciaNombre", $valor) || array_key_exists("GerenciaNombre", $valor))){ //Valida que en el año haya una coincidencia con los meses de la consulta en sicas

				//------------------------------------------------------------
				//Nueva implementación: validar primas y comisiones negativos por registros. Dennis [2021-06-15]
				$PrimaNetaRegistro[$meses_anio[$i]] = (Float)$valor->PrimaNeta;
				$ComisionTotalRegistro[$meses_anio[$i]] = (float)$valor->Comision0+(float)$valor->Comision1+(float)$valor->Comision2+(float)$valor->Comision3+(float)$valor->Comision4+(float)$valor->Comision5+(float)$valor->Comision6+(float)$valor->Comision7+(float)$valor->Comision8+(float)$valor->Comision9;
				//-------------------------------------------------------------

				//if($PrimaNetaRegistro[$meses_anio[$i]] >= 0 && $ComisionTotalRegistro[$meses_anio[$i]] >= 0){
						
					//array_push($primasEmitidas[$meses_anio[$i]], (float)$valor->PrimaNeta); //Almacena todas las primas emitidas.
					array_push($valida_meses, date("n", strtotime($tipo_docto))); //Almacena los meses coincidentes.

					array_push($primasEmitidas[$meses_anio[$i]], (Float)$valor->PrimaNeta);

					array_push($contenedor_documento[$meses_anio[$i]],(String)$valor->Documento);

					//------------------------------------------------------------
					//Acumulado de estructura de agentes.
					$sum_com_uni[$meses_anio[$i]]=0;
					$sum_com_uni[$meses_anio[$i]]=(float)$valor->Comision0+(float)$valor->Comision1+(float)$valor->Comision2+(float)$valor->Comision3+(float)$valor->Comision4+(float)$valor->Comision5+(float)$valor->Comision6+(float)$valor->Comision7+(float)$valor->Comision8+(float)$valor->Comision9;

					if($this->tank_auth->get_idPersona()!=805 && ($_GET["tipoFechaDoc"]=="FEmision" || $_GET["tipoFechaDoc"]=="FLimPago")){

						array_push($pila_total_pe[$meses_anio[$i]],array(
							$fecha_registro[$meses_anio[$i]]=>array(
								"PrimaPolizaEmitida"=>($_GET["tipoFechaDoc"]=="FDocto" || in_array((Int)$valor->Status,array(3,4)) ) ? (Float)$valor->PrimaNeta*(Float)$valor->TCPago : (Float)$valor->PrimaNeta*(Float)$valor->TCDay, //(Float)$valor->PrimaNeta*(Float)$valor->TCPago,
								"ComisionPolizaEmitida"=>($_GET["tipoFechaDoc"]=="FDocto" || in_array((Int)$valor->Status,array(3,4)) ) ? $sum_com_uni[$meses_anio[$i]]*(Float)$valor->TCPago : ($sum_com_uni[$meses_anio[$i]])*(Float)$valor->TCDay, //
									"idVendedor"=>(Int)$valor->IDVend,
									"Nombre"=>(String)$valor->VendNombre,
									"Ramo"=>((string)$valor->RamosNombre=="Accidentes y Enfermedades") ? (string)$valor->SRamoNombre : (string)$valor->RamosNombre,
									"Renovacion" =>(string)$valor->Renovacion
								)
							)
						);

						//Recibos emitidos nuevos
						if((String)$valor->Renovacion == 0){

							array_push($pila_total_pe_n[$meses_anio[$i]],array(
								$fecha_registro[$meses_anio[$i]]=>array(
									"PrimaPolizaEmitidaNueva"=>($_GET["tipoFechaDoc"]=="FDocto" || in_array((Int)$valor->Status,array(3,4)) ) ? (Float)$valor->PrimaNeta*(Float)$valor->TCPago : (Float)$valor->PrimaNeta*(Float)$valor->TCDay, //(Float)$valor->PrimaNeta*(Float)$valor->TCPago,
									"ComisionPolizaEmitidaNueva"=>($_GET["tipoFechaDoc"]=="FDocto" || in_array((Int)$valor->Status,array(3,4)) ) ? $sum_com_uni[$meses_anio[$i]]*(Float)$valor->TCPago : ($sum_com_uni[$meses_anio[$i]])*(Float)$valor->TCDay, //
										"idVendedor"=>(Int)$valor->IDVend,
										"Nombre"=>(String)$valor->VendNombre,
										"Ramo"=>((string)$valor->RamosNombre=="Accidentes y Enfermedades") ? (string)$valor->SRamoNombre : (string)$valor->RamosNombre,
										//"Renovacion" =>(string)$valor->Renovacion
									)
								)
							);

						}
					}
					//-------------------------------------------------------------

					$idMeta[$meses_anio[$i]]=$this->personamodelo->obtenerMetaComercialAnual($this->tank_auth->get_idPersona());
					$idMeta_ingresoTotal[$meses_anio[$i]]=$this->metacomercial_modelo->obtenerMetaAnualPorId($this->tank_auth->get_idPersona(),2);

					if(!empty($idMeta[$meses_anio[$i]])){

						$metacomercial[$meses_anio[$i]]=$this->personamodelo->regresaMontodelMes($meses_anio[$i],$idMeta[$meses_anio[$i]]->idMetaComercial,1);
					}

					if(!empty($idMeta_ingresoTotal[$meses_anio[$i]])){

						$metacomercial_ingreso_total[$meses_anio[$i]]=$this->personamodelo->regresaMontodelMes($meses_anio[$i],$idMeta_ingresoTotal[$meses_anio[$i]]->idMetaComercial,2);
					}
									
					//Sumatoria de comisiones emitidas.
					$comisionEmitida[$meses_anio[$i]]+=(float)$valor->Comision0+(float)$valor->Comision1+(float)$valor->Comision2+(float)$valor->Comision3+(float)$valor->Comision4+(float)$valor->Comision5+(float)$valor->Comision6+(float)$valor->Comision7+(float)$valor->Comision8+(float)$valor->Comision9;

					if((string)$valor->Status_TXT=="Liquidado" || (string)$valor->Status_TXT=="Pagado"){ //Validación para primas y comisiones cobradas.

						$comisionUnitarioPagado[$meses_anio[$i]]=((float)$valor->Comision0+(float)$valor->Comision1+(float)$valor->Comision2+(float)$valor->Comision3+(float)$valor->Comision4+(float)$valor->Comision5+(float)$valor->Comision6+(float)$valor->Comision7+(float)$valor->Comision8+(float)$valor->Comision9);

						//-----------------------------------------------------

						$PrimaNetaTotal[$meses_anio[$i]]=0;
						$comision_subsecuente_sum[$meses_anio[$i]]=0;
						$comision_subsecuente_sum[$meses_anio[$i]]=(float)$valor->Comision0+(float)$valor->Comision1+(float)$valor->Comision2+(float)$valor->Comision3+(float)$valor->Comision4+(float)$valor->Comision5+(float)$valor->Comision6+(float)$valor->Comision7+(float)$valor->Comision8+(float)$valor->Comision9;

						//if($_GET["tipoFechaDoc"]=="FDocto"){

							$PrimaNetaTotal[$meses_anio[$i]]=(Float)$valor->PrimaNeta*(Float)$valor->TCPago;
						
							if((Int)$valor->RenovacionDocto == 0 && (float)$valor->PrimaNeta >= 0){ //Almacenar subsecuentes. && (Int)$valor->RenovacionDocto==0 (Int)$valor->Renovacion==0 && 
		
								array_push($pila_total_ps[$meses_anio[$i]],array(
									$fecha_registro[$meses_anio[$i]]=>array(
										"PrimaPolizaSubsecuente"=>(Float)$valor->PrimaNeta*(Float)$valor->TCPago,
										"ComisionPolizaSubsecuente"=>$comision_subsecuente_sum[$meses_anio[$i]]*(Float)$valor->TCPago,
											"idVendedor"=>(Int)$valor->IDVend,
											"Nombre"=>(String)$valor->VendNombre,
											"Ramo"=>((string)$valor->RamosNombre=="Accidentes y Enfermedades") ? (string)$valor->SRamoNombre : (string)$valor->RamosNombre
											)
									)
								);
							}

						array_push($pila_total_pt[$meses_anio[$i]],array(
							$fecha_registro[$meses_anio[$i]]=>array(
								"PrimaPolizaTotal"=>$PrimaNetaTotal[$meses_anio[$i]], //(Float)$valor->PrimaNeta,
								"ComisionPolizaTotal"=> $comision_subsecuente_sum[$meses_anio[$i]]*(Float)$valor->TCPago, //($_GET["tipoFechaDoc"]=="FDocto") ? $comision_subsecuente_sum[$meses_anio[$i]]*(Float)$valor->TCPago : $comision_subsecuente_sum[$meses_anio[$i]], //$com_sb_sum[$meses_anio[$i]], //$comisionUnitarioPagado[$meses_anio[$i]],
									"idVendedor"=>(Int)$valor->IDVend,
									"Nombre"=>(String)$valor->VendNombre,
									"Ramo"=>((string)$valor->RamosNombre=="Accidentes y Enfermedades") ? (string)$valor->SRamoNombre : (string)$valor->RamosNombre
								)
							)
						);

						array_push($pila_fianzas_efectuados[$meses_anio[$i]], array( //Efectuados GAP y asesores fianzasaa
						
							"_Fecha" => $fecha_registro[$meses_anio[$i]],
							"_PrimaEfectuada" => $PrimaNetaTotal[$meses_anio[$i]],
							"_ComisionEfectuada" => array(
								"comision0" => (float)$valor->Comision0 * (Float)$valor->TCPago,
								"comision1" => (float)$valor->Comision1 * (Float)$valor->TCPago,
								"comision2" => (float)$valor->Comision2 * (Float)$valor->TCPago,
								"comision3" => (float)$valor->Comision3 * (Float)$valor->TCPago,
							),
							"_idVendedor" => (Int)$valor->IDVend,
						));

						$comision_poliza_nueva_sum[$meses_anio[$i]]=0;
						$comision_poliza_nueva_sum[$meses_anio[$i]]=(float)$valor->Comision0+(float)$valor->Comision1+(float)$valor->Comision2+(float)$valor->Comision3+(float)$valor->Comision4+(float)$valor->Comision5+(float)$valor->Comision6+(float)$valor->Comision7+(float)$valor->Comision8+(float)$valor->Comision9;

						if((Int)$valor->Periodo==1 && (Int)$valor->Renovacion==0 && (Int)$valor->RenovacionDocto==0 && (float)$valor->PrimaNeta >= 0){ //Polizas nuevas. //&& (Int)$valor->RenovacionDocto==0 && $_GET["tipoFechaDoc"]=="FDocto"

							array_push($pila_total_pn[$meses_anio[$i]],array(
								$fecha_registro[$meses_anio[$i]]=>array(
									"PrimaPolizaNueva"=>(Float)$valor->PrimaNeta*(Float)$valor->TCPago,
									"ComisionPolizaNueva"=>$comision_poliza_nueva_sum[$meses_anio[$i]]*(Float)$valor->TCPago, //$comision_poliza_nueva_sum[$meses_anio[$i]],
										"idVendedor"=>(Int)$valor->IDVend,
										"Nombre"=>(String)$valor->VendNombre,
										"Ramo"=>((string)$valor->RamosNombre=="Accidentes y Enfermedades") ? (string)$valor->SRamoNombre : (string)$valor->RamosNombre,
										"Prima"=>(Float)$valor->PrimaNeta*(Float)$valor->TCPago,
										"Comision"=>(Float)$valor->PrimaNeta*(Float)$valor->TCPago,
									)
								)
							);
						}
					}

					if((string)$valor->Status_TXT=="Pendiente"){ //Validación para primas pendientes.

						$comision_pendiente[$meses_anio[$i]]=0;
						$comision_pendiente[$meses_anio[$i]]=((float)$valor->Comision0+(float)$valor->Comision1+(float)$valor->Comision2+(float)$valor->Comision3+(float)$valor->Comision4+(float)$valor->Comision5+(float)$valor->Comision6+(float)$valor->Comision7+(float)$valor->Comision8+(float)$valor->Comision9);

						array_push($pila_total_pp[$meses_anio[$i]],array(
							$fecha_registro[$meses_anio[$i]]=>array(
								"PrimaPolizaPendienteEmitida"=>(Float)$valor->PrimaNeta*(Float)$valor->TCDay,
									"ComisionPolizaPendienteEmitida"=>$comision_pendiente[$meses_anio[$i]]*(Float)$valor->TCDay,
									"idVendedor"=>(Int)$valor->IDVend,
									"Nombre"=>(String)$valor->VendNombre,
									"Ramo"=>((string)$valor->RamosNombre=="Accidentes y Enfermedades") ? (string)$valor->SRamoNombre : (string)$valor->RamosNombre
								)
							)
						);
					}
					
					$contador_polizas[$meses_anio[$i]]++;
				//} //Fin del proceso de validación de números negativos
			} //Final de proceso
		}

		//------------------------
		//Para módulo de fianzas.

		if($this->tank_auth->get_idPersona()==805){

			//Recibos emitidos fianzas.
			foreach($requestFianzas as $datosEF){
				
				$mes_iteracion[$meses_anio[$i]]=date("n",strtotime((String)$datosEF->FEmision));
				$fecha_iteracion[$meses_anio[$i]]=date("Y-m-d", strtotime((String)$datosEF->FEmision));
				
				if($meses_anio[$i]==$mes_iteracion[$meses_anio[$i]]){

					$sum_emitido_fianzas[$meses_anio[$i]]=0;
					$sum_emitido_fianzas[$meses_anio[$i]]=(float)$datosEF->Comision0+(float)$datosEF->Comision1+(float)$datosEF->Comision2+(float)$datosEF->Comision3+(float)$datosEF->Comision4+(float)$datosEF->Comision5+(float)$datosEF->Comision6+(float)$datosEF->Comision7+(float)$datosEF->Comision8+(float)$datosEF->Comision9;

					array_push($pila_total_pe[$meses_anio[$i]],array(
						$fecha_iteracion[$meses_anio[$i]]=>array(
							"PrimaPolizaEmitida"=>(Float)$datosEF->PrimaNeta*(Float)$datosEF->TCDay, //(Float)$valor->PrimaNeta*(Float)$valor->TCPago,
							"ComisionPolizaEmitida"=>$sum_emitido_fianzas[$meses_anio[$i]]*(Float)$datosEF->TCDay, //
							"idVendedor"=>(Int)$datosEF->IDVend,
							"Nombre"=>(String)$datosEF->VendNombre,
							"Ramo"=>((string)$datosEF->RamosNombre=="Accidentes y Enfermedades") ? (string)$datosEF->SRamoNombre : (string)$datosEF->RamosNombre
							)
						)
					);
					//------------------------------------------
					array_push($pila_fianzas_emitidos[$meses_anio[$i]], array(
						
						"_Fecha" => $fecha_iteracion[$meses_anio[$i]],
						"_PrimaEmitida" => (Float)$datosEF->PrimaNeta*(Float)$datosEF->TCDay,
						"_ComisionEmitida" => array(
							"comision0" => (float)$datosEF->Comision0 * (Float)$datosEF->TCDay,
							"comision1" => (float)$datosEF->Comision1 * (Float)$datosEF->TCDay,
							"comision2" => (float)$datosEF->Comision2 * (Float)$datosEF->TCDay,
							"comision3" => (float)$datosEF->Comision3 * (Float)$datosEF->TCDay,
						),
						"_idVendedor" => (Int)$datosEF->IDVend,
					));
				}
			}
			//-------------------------------------------------------
			//Pendientes de fianzas.
			//$contadorPPF[$meses_anio[$i]]=0;

			$polizas_pendientes_fianzas[$meses_anio[$i]]=$this->reportes_model->obtenerRegistrosPendientesFianzas(end($domingos_fijos));

			//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($pila_total_pn[$meses_anio[$i]],TRUE));fclose($fp);
			if(!empty($polizas_pendientes_fianzas[$meses_anio[$i]])){

				foreach($polizas_pendientes_fianzas[$meses_anio[$i]] as $ii){

					array_push($pila_total_pp[$meses_anio[$i]],array(
						($ii->ultima_fecha)=>array( //date("Y-m-d", strtotime(str_replace("/","-",$_GET["fechaF"])))
							"PrimaPolizaPendienteEmitida"=>$ii->prima_pendiente,//(Float)$dataFP->PrimaNeta,
							"ComisionPolizaPendienteEmitida"=>$ii->comision_pendiente//(float)$dataFP->Comision0+(float)$dataFP->Comision1+(float)$dataFP->Comision2+(float)$dataFP->Comision3+(float)$dataFP->Comision4+(float)$dataFP->Comision5+(float)$dataFP->Comision6+(float)$dataFP->Comision7+(float)$dataFP->Comision8+(float)$dataFP->Comision9
							)
						)
					);
				}
			}
		}
		//---------------------------------------------------
		$meta_mensual[$meses_anio[$i]]=0;
		$meta_ideal[$meses_anio[$i]]=0;

		$meta_mensual_ingreso_total[$meses_anio[$i]]=0;
		$meta_ideal_ingreso_total[$meses_anio[$i]]=0;

		if(isset($metacomercial[$meses_anio[$i]])){
			foreach($metacomercial[$meses_anio[$i]] as $valor){

				$meta_mensual[$meses_anio[$i]]=$valor->monto_al_mes;
				$meta_ideal[$meses_anio[$i]]=$valor->monto_al_mes/5;
			}
		}

		if(isset($metacomercial_ingreso_total[$meses_anio[$i]])){
			foreach($metacomercial_ingreso_total[$meses_anio[$i]] as $_valor){

				$meta_mensual_ingreso_total[$meses_anio[$i]]=$_valor->monto_al_mes;
				$meta_ideal_ingreso_total[$meses_anio[$i]]=$_valor->monto_al_mes/5;
			}
		}
		//------------------------------------------------------------

		$cobranza_general["datosMensuales"][$meses_anio[$i]]["metaComercial"]=$meta_mensual[$meses_anio[$i]];
		$cobranza_general["datosMensuales"][$meses_anio[$i]]["MetaIdeal"]=$meta_ideal[$meses_anio[$i]];
		$cobranza_general["datosMensuales"][$meses_anio[$i]]["metaComercial_ingreso_total"]=$meta_mensual_ingreso_total[$meses_anio[$i]];
		$cobranza_general["datosMensuales"][$meses_anio[$i]]["MetaIdeal_ingreso_total"]=$meta_ideal_ingreso_total[$meses_anio[$i]];
		$cobranza_general["datosMensuales"][$meses_anio[$i]]["fechaInicio"]=$_GET["fechaI"];
		$cobranza_general["datosMensuales"][$meses_anio[$i]]["primaPendienteFianzas"]=$primaFPa;
		$cobranza_general["datosMensuales"][$meses_anio[$i]]["comisionPendienteFianzas"]=$comisionFP;
		$cobranza_general["datosMensuales"][$meses_anio[$i]]["cantidadPolizas"]=$contador_polizas[$meses_anio[$i]];
		//$cobranza_general["datosMensuales"][$meses_anio[$i]]["vendedores"]=$vendedores_registro[$meses_anio[$i]];
		$cobranza_general["datosMensuales"][$meses_anio[$i]]["segmentacionDeFechas"]=$segmentacion_fechas;//[$meses_anio[$i]];  //$contador_polizas[$meses_anio[$i]];
		//$cobranza_general[$meses_anio[$i]]["recibosSemanales"]=$semana_registro[$meses_anio[$i]];

		//Validador de opciones segun lo seleccionado.
		if(($_GET["tipoReporte"]==3 && $_GET["tipoFechaDoc"]=="FDocto") && $this->tank_auth->get_idPersona() != 805){  // || ($_GET["tipoReporte"]== -1 && $_GET["tipoFechaDoc"]=="FLimPago")
			$cobranza_general["datosMensuales"][$meses_anio[$i]]["PolizasNuevas"]=$pila_total_pn[$meses_anio[$i]];
			$cobranza_general["datosMensuales"][$meses_anio[$i]]["PolizasYSubsecuentes"]=$pila_total_ps[$meses_anio[$i]];
			$cobranza_general["datosMensuales"][$meses_anio[$i]]["PolizasCobradas"]=$pila_total_pt[$meses_anio[$i]];

		} elseif($_GET["tipoReporte"] == 0 && $_GET["tipoFechaDoc"] == "FLimPago"){

			$cobranza_general["datosMensuales"][$meses_anio[$i]]["PolizasPendientesEmitidas"]=$pila_total_pp[$meses_anio[$i]];

		} elseif($_GET["tipoFechaDoc"]=="FEmision"){

			$cobranza_general["datosMensuales"][$meses_anio[$i]]["PolizasEmitidas"]=$pila_total_pe[$meses_anio[$i]];
			$cobranza_general["datosMensuales"][$meses_anio[$i]]["PolizasEmitidasNuevas"]=$pila_total_pe_n[$meses_anio[$i]];

		} elseif(($_GET["tipoReporte"] == -1 && $_GET["tipoFechaDoc"]=="FLimPago") || $this->tank_auth->get_idPersona() == 805){

			$cobranza_general["datosMensuales"][$meses_anio[$i]]["PolizasNuevas"]=$pila_total_pn[$meses_anio[$i]];
			$cobranza_general["datosMensuales"][$meses_anio[$i]]["PolizasYSubsecuentes"]=$pila_total_ps[$meses_anio[$i]];
			$cobranza_general["datosMensuales"][$meses_anio[$i]]["PolizasCobradas"]=$pila_total_pt[$meses_anio[$i]];
			$cobranza_general["datosMensuales"][$meses_anio[$i]]["PolizasEmitidas"]=$pila_total_pe[$meses_anio[$i]];
			$cobranza_general["datosMensuales"][$meses_anio[$i]]["PolizasPendientesEmitidas"]=$pila_total_pp[$meses_anio[$i]];
			$cobranza_general["datosMensuales"][$meses_anio[$i]]["PolizasFianzasEmitidas"] = $pila_fianzas_emitidos[$meses_anio[$i]];
			$cobranza_general["datosMensuales"][$meses_anio[$i]]["PolizasFianzasEfectuadas"] = $pila_fianzas_efectuados[$meses_anio[$i]];
			//$pila_fianzas_emitidos[$meses_anio[$i]]
		}

		//$cobranza_general["datosMensuales"][$meses_anio[$i]]["PolizasNuevas"]=$pila_total_pn[$meses_anio[$i]];
		//$cobranza_general["datosMensuales"][$meses_anio[$i]]["PolizasYSubsecuentes"]=$pila_total_ps[$meses_anio[$i]];
		//$cobranza_general["datosMensuales"][$meses_anio[$i]]["PolizasCobradas"]=$pila_total_pt[$meses_anio[$i]];
		//$cobranza_general["datosMensuales"][$meses_anio[$i]]["PolizasEmitidas"]=$pila_total_pe[$meses_anio[$i]];
		//$cobranza_general["datosMensuales"][$meses_anio[$i]]["PolizasPendientesEmitidas"]=$pila_total_pp[$meses_anio[$i]];
		//$cobranza_general["datosMensuales"][$meses_anio[$i]]["visor"]=$polizas_pendientes_fianzas[$meses_anio[$i]];

	}

	$cobranza_general["infoTotal"]["RespuestaPolizas"]=(Array)$respuesta;
	$cobranza_general["infoTotal"]["RespuestaPolizasPendientesFianzas"]=($this->tank_auth->get_idPersona()==805) ?  (Array)$requestPendientesFianzas : array();
	$cobranza_general["infoTotal"]["RespuestaPolizasEmitidosFianzas"]= ($this->tank_auth->get_idPersona()==805) ?  (Array)$requestFianzas : array();//(Array)$requestFianzas;

	//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($cobranza_general,TRUE));fclose($fp);

	echo json_encode($cobranza_general);

}

//----------------------------------------------------------------------------------------------
//Dennis [2020-12-28]
function consultaDeEmitidosFianzas($array){

	$total_emitidos_fianzas=array();
	$this->load->library("WS_Sicas");

	$resultado=$this->ws_sicas->produccionFianzas($array);

	return $resultado;
}



//Ultima Modificacion 25/03/2021 Renovaciones
function cuadroMando(){
  $mes=date('m');
  $year=date('Y');
  
  $datos['suspectos']=$this->cuadromando_model->getProspectos($mes,$year,'DIMENSION','0');
  $datos['perfilados']=$this->cuadromando_model->getProspectos($mes,$year,'PERFILADO','0');
  $datos['contactado']=$this->cuadromando_model->getProspectos($mes,$year,'CONTACTADO','0');
  $datos['cotizado']=$this->cuadromando_model->getProspectos($mes,$year,'COTIZADO','0');
  $datos['cotizado_emitido']=$this->cuadromando_model->getProspectos($mes,$year,'COTIZADO','1');
  $datos['pagado']=$this->cuadromando_model->getProspectos($mes,$year,'PAGADO','0');

  //Cobranza
  $datos['cobranza']=$this->cuadromando_model->getCobranza_kpi();

  $datos['coordinadores']=$this->cuadromando_model->getCoordinadores();
  $datos['todosCoordinadores']=$this->personamodelo->devuelveCoordinadoresVentas();

  $datos['auto']=$this->cuadromando_model->getActividadesAutos();
  $datos['danio']=$this->cuadromando_model->getActividadesDanios();
  $datos['vida']=$this->cuadromando_model->getActividadesVida();
  $datos['todasActividades']=$this->cuadromando_model->getAllActividades();

  $datos['nameAuto']=$this->cuadromando_model->getEjecutivoAutos();
  $datos['nameDanio']=$this->cuadromando_model->getEjecutivoDanios();
  $datos['nameVida']=$this->cuadromando_model->getEjecutivoVidas();

  $datos['renovacion']=$this->cuadromando_model->getRenovaciones();
  
  //$datos['renovacionPendientes']=$this->cuadromando_model->getRenovacionesPendientes();
  //[Mdificacion]
    $mes=date('m');
    $datos['renovacionPendientes']=$this->cuadromando_model->getRenovacionesPendientes($mes);
    
    //Modificacion Presupuesto
    $datos['presupuesto']=$this->reportepresupuestomodel->DevulvePresupuesto($year,2);
    $datos['semaforo']=$this->cuadromando_model->getSemaforoActividades();
    //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($datos['semaforo'],TRUE));fclose($fp);

    //Modificacion tablero de fastfile
  $datos['prestamos']=$this->cuadromando_model->getAllFastFile('prestamos',$mes,$year);
  $datos['vacaciones']=$this->cuadromando_model->getAllFastFile('vacaciones',$mes,$year);
  $datos['permisos']=$this->cuadromando_model->getAllFastFile('permiso',$mes,$year);
  $datos['incapacidad']=$this->cuadromando_model->getAllFastFile('incapacidad',$mes,$year);

  $datos['puntualidad']=$this->cuadromando_model->getAllFastFile('fastfile',$mes,$year);
  $datos['asistencia']=$this->cuadromando_model->getAllFastFileAsistencia($mes,$year);
  $datos['sueldo']=$this->cuadromando_model->getAllFastFile('solicitud_sueldo',$mes,$year);
  $datos['cambio_puesto']=$this->cuadromando_model->getAllFastFile('fastfile_cambio_puesto',$mes,$year);
  $datos['calificacion']=$this->cuadromando_model->getAllFastFile('calificacion',$mes,$year);
  $datos['capacitacion']=$this->personamodelo->resumenGeneral();


  $bajasComercial=$this->cuadromando_model->getBajas($mes,$year,1);
  $bajasOperativo=$this->cuadromando_model->getBajas($mes,$year,2);
  $bajasAdministrativo=$this->cuadromando_model->getBajas($mes,$year,3);
  $bajasGerencial=$this->cuadromando_model->getBajas($mes,$year,4);
  $bajasCorporativo=$this->cuadromando_model->getBajas($mes,$year,6);
  $bajasFianzas=$this->cuadromando_model->getBajas($mes,$year,7);

  $activosComercial=$this->cuadromando_model->getActivoByArea(1);
  $activosOperativo=$this->cuadromando_model->getActivoByArea(2);
  $activosAdministrativo=$this->cuadromando_model->getActivoByArea(3);
  $activosGerencial=$this->cuadromando_model->getActivoByArea(4);
  $activosCorporativo=$this->cuadromando_model->getActivoByArea(6);
  $activosFianzas=$this->cuadromando_model->getActivoByArea(7);

  $datos['bajasComercial']=$bajasComercial;
  $datos['bajasOperativo']=$bajasOperativo;
  $datos['bajasAdministrativo']=$bajasAdministrativo;
  $datos['bajasGerencial']=$bajasGerencial;
  $datos['bajasCorporativo']=$bajasCorporativo;
  $datos['bajasFianzas']=$bajasFianzas;

  $datos['activosComercial']=$activosComercial;
  $datos['activosOperativo']=$activosOperativo;
  $datos['activosAdministrativo']=$activosAdministrativo;
  $datos['activosGerencial']=$activosGerencial;
  $datos['activosCorporativo']=$activosCorporativo;
  $datos['activosFianzas']=$activosFianzas;
  
  $datos['rotacionComercial']=number_format(($bajasComercial/($activosComercial/2))*100,2);
  $datos['rotacionOperativo']=number_format(($bajasOperativo/($activosOperativo/2))*100,2);
  $datos['rotacionAdministrativo']=number_format(($bajasAdministrativo/($activosAdministrativo/2))*100,2);
  $datos['rotacionGerencial']=number_format(($bajasGerencial/($activosGerencial/2))*100,2);
  $datos['rotacionCorporativo']=number_format(($bajasCorporativo/($activosCorporativo/2))*100,2);
  $datos['rotacionFianzas']=number_format(($bajasFianzas/($activosFianzas/2))*100,2);

  $emisionesInfo=$this->cuadromando_model->getInfoEmisionActividades();

    $datos['emisionesTipoPago']=$emisionesInfo['tipoPago'];
    $datos['emisionTipoConducto']=$emisionesInfo['tipoConducto'];
    $datos['emisionTarjetas']=$emisionesInfo['tarjetas'];
    $datos['infoEmisiones']=$emisionesInfo;
   
            
 $this->load->view("reportes/cuadroMando",$datos);

}

function datosCoordinador(){
	$mes=date('m');
    $year=date('Y');
	 $sql="SELECT idPersona from registro_meta_mensual_ramo_coordinador_generico where mes_asignado='$mes' AND anio='$year' GROUP BY idPersona";
	$coordinadores=$this->db->query($sql)->result();
	foreach ($coordinadores as $coordinador) {
		$datos=$this->personamodelo->obtenerDatosUsers($coordinador->idPersona);
    	echo json_encode($datos);
	}
}

function getAllMetasComercialesAsignadasPrimas($coor){
	$mes=date('m');
    $year=date('Y');
	$sql="SELECT * from registro_meta_mensual_ramo_coordinador_generico where mes_asignado='$mes' AND anio='$year' AND idPersona='$coor'";
  	return $this->db->query($sql)->result();
}

function getAllMetasComercialesAsignadasPolizas($coor){
	$mes=date('m');
    $year=date('Y');
	$sql="SELECT * from registro_meta_mensual_ramo_coordinador_generico where mes_asignado='$mes' AND anio='$year' AND idPersona='$coor'";
  	return $this->db->query($sql)->result();
}

//Metas Comerciales Alcanzadas PrimasNetas, Numero de Polizas y comision
function getAllMetasComercialesAlcanzadas($coor){
	$metasAlcanzadas=array();
	$contenedor_agentes=array();
	$json_respuesta=array();
	$this->load->library("ws_sicas");
	$f_i="";
	$f_f="";
	$mes=date('m');
    $year=date('Y');

	$agentes=$this->personamodelo->devuelveAgentesPorCoordinadorActivos($coor);
	foreach($agentes as $val){
		array_push($contenedor_agentes,$val->IDVend);
	}
	$f_i=date("d-m-Y", mktime(0,0,0,$mes,1,date("Y")));
	if($mes<date("m") || $mes>date("m")){ // 
		$f_f=date("d-m-Y", mktime(0,0,0,$mes+1,0,date("Y")));
	}else{
		$f_f=date("d-m-Y");
	}
	if(!empty($agentes)){
		$requestSicas=$this->ws_sicas->consultaAvanceSicas($coor,array_values(array_unique($contenedor_agentes)),$f_i,$f_f,null);
		if(array_key_exists("TableInfo", $requestSicas)){
			
			$incremental_autos=0;$incremental_vida=0;$incremental_danios=0;
			$incremental_gmm=0;$incremental_fianzas=0;
			$acComisionGmm=0;$acComisionAutos=0;$acComisionVida=0; 
			$acComisionDanios=0;$acComisionFianzas=0;
			$acGmm=0;$acAutos=0;$acVida=0;$acDanios=0;$acFianzas=0;
							
			foreach($requestSicas->TableInfo as $res_data){
				if((Int)$res_data->Renovacion==0 && (Int)$res_data->Periodo==1){
					switch((String)$res_data->Ramo){
						case "Accidentes y Enfermedades": 
							$incremental_gmm++;
							$acGmm=$acGmm+($res_data->PrimaNeta*$res_data->TCPago); 
							for($i=0;$i<17;$i++){
								$acComisionGmm=$acComisionGmm+($res_data->Comision.$i)*$res_data->TCPago;
							} 
							break;
						case "Vehiculos": 
							$incremental_autos++;
							$acAutos=$acAutos+($res_data->PrimaNeta*$res_data->TCPago); 
							for($i=0;$i<17;$i++){
								$acComisionAutos=$acComisionAutos+($res_data->Comision.$i)*$res_data->TCPago;
							}
							break;
						case "Vida": 
							$incremental_vida++;
							$acVida=$acVida+($res_data->PrimaNeta*$res_data->TCPago); 
							for($i=0;$i<17;$i++){
								$acComisionVida=$acComisionVida+($res_data->Comision.$i)*$res_data->TCPago;
							}
							break;
						case "Daños": 
							$incremental_danios++;
							$acDanios=$acDanios+($res_data->PrimaNeta*$res_data->TCPago); 
							for($i=0;$i<17;$i++){
								$acComisionDanios=$acComisionDanios+($res_data->Comision.$i)*$res_data->TCPago;
							}
							break;
						case "Fianzas": 
							$incremental_fianzas++;
							$acFianzas=$acFianzas+($res_data->PrimaNeta*$res_data->TCPago); 
							for($i=0;$i<17;$i++){
								$acComisionFianzas=$acComisionFianzas+($res_data->Comision.$i)*$res_data->TCPago;
							}
							break;
					}
				}
			}
			$metasAlcanzadas[0]=$incremental_autos;
			$metasAlcanzadas[1]=$incremental_vida;
			$metasAlcanzadas[2]=$incremental_danios;
			$metasAlcanzadas[3]=$incremental_gmm;
			$metasAlcanzadas[4]=$incremental_fianzas;

			$metasAlcanzadas[5]=$acGmm;
			$metasAlcanzadas[6]=$acAutos;
			$metasAlcanzadas[7]=$acVida;
			$metasAlcanzadas[8]=$acDanios;
			$metasAlcanzadas[9]=$acFianzas;

			$metasAlcanzadas[10]=$acComisionGmm;
			$metasAlcanzadas[11]=$acComisionAutos;
			$metasAlcanzadas[12]=$acComisionVida;
			$metasAlcanzadas[13]=$acComisionDanios;
			$metasAlcanzadas[14]=$acComisionFianzas;
		} 
	}
	return $metasAlcanzadas;
}

//Fin Metas comerciales
/*
// Toda Cobranza Pendiente
function getAllCobranzaPendiente(){
        $ct=0;
        $vendedor=$this->tank_auth->get_IDVend();
        $mes=date('m');
        $year=date('Y');
        $fechaInicial='01'.'-'.$mes.'-'.$year;
        $fechaFinal=date("d-m-Y");
        $arrayCobranza['fechaInicial']=$fechaInicial;
        $arrayCobranza['fechaFinal']= $fechaFinal;
        $arrayCobranza['vendedor']=$vendedor;
        $arrayCobranza['tipoReporte']='todos';
        $arrayCobranza['tipoFecha']='FLimPago';
        $rs=$this->ws_sicas->cobranzareporte($arrayCobranza);
        foreach ($rs as $row){
            $FLimPago=(date("d-m-y",strtotime((string)$row->FLimPago)));
            $dias=(int)$FLimPago-(int)$fechaFinal;
             if(($dias > -10)&&($dias<=5)){ 
                $ct++;
             }
         }
         return $ct;
}

// Toda Cobranza Efectuada
function getAllCobranzaEfectuada(){

         $ct=0;
         $vendedor=$this->tank_auth->get_IDVend();
         $mes=date('m');
         $year=date('Y');
         $fechaInicial='01'.'-'.$mes.'-'.$year;
         $fechaFinal=date("d-m-Y");
         $rs=$this->ws_sicas->obtenerReporteCobranza($vendedor,$fechaInicial,$fechaFinal,3);
         foreach ($rs as $row){
            $ct++;
         }
         return $ct;
}

 //Toda Cobranza Atrasada
function getAllCobranzaAtrasada(){
 
       $ct=0;
       $mes=date('m');
       $year=date('y');
       $fechaFinal=date("d-m-y");
       $arrayCobranza['fechaInicial']='01'.'-'.$mes.'-'.$year;
       $arrayCobranza['fechaFinal']= $fechaFinal;
       $arrayCobranza['vendedor']=$this->tank_auth->get_IDVend();
       $arrayCobranza['tipoReporte']='todos';
       $arrayCobranza['tipoFecha']='FLimPago';
       $rs=$this->ws_sicas->cobranzareporte($arrayCobranza);
       $dias=0;
       foreach ($rs as $row){
       $FLimPago=(date("d-m-y",strtotime((string)$row->FLimPago)));
       $dias=(int)$FLimPago-(int)$fechaFinal;
          if($dias <= -10){ 
            $ct++;
          }
        }
       return $ct;
}
*/
function detalle_cobranza(){
  $mes=date('m');
   $year=date('y');
   $data['fechaI']='01-'.$mes.'-'.$year;
   $data['fechaF']=date("d-m-y");
  
   $data['CPINST']=$this->cuadromando_model->getCobranza_sucursal('institucional')->recibos_pendientes;
   $data['CPCUN']=$this->cuadromando_model->getCobranza_sucursal('cancun')->recibos_pendientes;
   $data['CPMID']=$this->cuadromando_model->getCobranza_sucursal('merida')->recibos_pendientes;

   $data['CAINST']=$this->cuadromando_model->getCobranza_sucursal('institucional')->recibos_atrasados;
   $data['CACUN']=$this->cuadromando_model->getCobranza_sucursal('cancun')->recibos_atrasados;
   $data['CAMID']=$this->cuadromando_model->getCobranza_sucursal('merida')->recibos_atrasados;

   $data['CEINST']=$this->cuadromando_model->getCobranza_sucursal('institucional')->recibos_efectuados;
   $data['CECUN']=$this->cuadromando_model->getCobranza_sucursal('cancun')->recibos_efectuados;
   $data['CEMID']=$this->cuadromando_model->getCobranza_sucursal('merida')->recibos_efectuados;
   
   $this->load->view("reportes/detalle_reporte_cobranza",$data);
}



function detalle_reporte_meta(){
	 $idPersona=$_REQUEST['idPersona'];
	 $datos['metasAsignadasPrimas']=$this->getAllMetasComercialesAsignadasPrimas($idPersona);
	 $datos['metasAsignadasPolizas']=$this->getAllMetasComercialesAsignadasPolizas($idPersona);
  	 $datos['metasAlcanzadas']=$this->getAllMetasComercialesAlcanzadas($idPersona);
	 $this->load->view("reportes/detalle_reporte_meta",$datos);
}


function detalle_reporte_actividades(){
	$datos['nameAuto']=$this->cuadromando_model->getEjecutivoAutos();
	$datos['nameDanio']=$this->cuadromando_model->getEjecutivoDanios();
	$datos['nameVida']=$this->cuadromando_model->getEjecutivoVidas();
	 
	$mes=date('m');
	$year=date('Y');
	$datos['actividadesAutos']=$this->cuadromando_model->getDesgloceActividadesAutos($mes,$year);
	$datos['actividadesDanios']=$this->cuadromando_model->getDesgloceActividadesDanios($mes,$year);
	$datos['actividadesVidas']=$this->cuadromando_model->getDesgloceActividadesVidas($mes,$year);
	$datos['autosSemaforo']=$this->cuadromando_model->getSemaforo('AUTOS',$mes,$year);
	$datos['daniosSemaforo']=$this->cuadromando_model->getSemaforo('DANIOS',$mes,$year);
	$datos['vidaSemaforo']=$this->cuadromando_model->getSemaforo('VIDA',$mes,$year);

	 $this->load->view("reportes/detalle_reporte_actividades",$datos);
}

function ajax_detalles_actividades($op){
	$ramo='';
	switch ($op) {
		case 1:
			$datos['datos']=$this->cuadromando_model->getAllActividadesDetallesSubramo('VEHICULOS','Cotizacion');
			$ramo='AUTOS';
			break;
		case 2:
			 $datos['datos']=$this->cuadromando_model->getAllActividadesDetallesSubramo('VEHICULOS','Cancelacion');
			 $ramo='AUTOS';
			break;
		case 3:
			$datos['datos']=$this->cuadromando_model->getAllActividadesDetallesSubramo('VEHICULOS','Endoso');
			$ramo='AUTOS';
			break;
		case 4:
			$datos['datos']=$this->cuadromando_model->getAllActividadesDetallesSubramo('VEHICULOS','Emision');
			$ramo='AUTOS';
			break;
		case 5:
			$datos['datos']=$this->cuadromando_model->getAllActividadesDetallesSubramo('DANOS','Cotizacion');
			$ramo='DAÑOS';
			break;
		case 6:
			 $datos['datos']=$this->cuadromando_model->getAllActividadesDetallesSubramo('DANOS','Cancelacion');
			 $ramo='DAÑOS';
			break;
		case 7:
			$datos['datos']=$this->cuadromando_model->getAllActividadesDetallesSubramo('DANOS','Endoso');
			$ramo='DAÑOS';
			break;
		case 8:
			$datos['datos']=$this->cuadromando_model->getAllActividadesDetallesSubramo('DANOS','Emision');
			$ramo='DAÑOS';
			break;
		case 9:
			$datos['datos']=$this->cuadromando_model->getAllActividadesDetallesSubramo('VIDA','Cotizacion');
			$ramo='VIDA';
			break;
		case 10:
			 $datos['datos']=$this->cuadromando_model->getAllActividadesDetallesSubramo('VIDA','Cancelacion');
			 $ramo='VIDA';
			break;
		case 11:
			$datos['datos']=$this->cuadromando_model->getAllActividadesDetallesSubramo('VIDA','Endoso');
			$ramo='VIDA';
			break;
		case 12:
			$datos['datos']=$this->cuadromando_model->getAllActividadesDetallesSubramo('VIDA','Emision');
			$ramo='VIDA';
			break;
	}
	$datos['ramo']=$ramo;
	$this->load->view("reportes/detalle_reporte_actividades_subramo",$datos);
}

//Modificaciones 28/04

function renovacionesPendientesRamo($mes){
    $ctAuto=0;$ctDanio=0;
    $ctVida=0;$ctAccEnf=0;
    $rs=$this->cuadromando_model->renovacionesPendientes($mes);
       $data=array();
       foreach ($rs as $row) {
        if($row->RamosNombre=='Vehiculos'){ $ctAuto++; }
        if($row->RamosNombre=='Daños'){ $ctDanio++; }
        if($row->RamosNombre=='Vida'){ $ctVida++;}
        if($row->RamosNombre=='Accidentes y Enfermedades'){ $ctAccEnf++; }
    }
    $data[0]=$ctAccEnf;
    $data[1]=$ctDanio;
    $data[2]=$ctAuto;
    $data[3]=$ctVida;	
    return $data;
} 

    function diaFinalMes($mes){
        switch ($mes) {
            case '01':return '31';break;
            case '02':return '28';break;
            case '03':return '31';break;
            case '04':return '30';break;
            case '05':return '31';break;
            case '06':return '30';break;
            case '07':return '30';break;
            case '08':return '31';break;
            case '09':return '30';break;
            case '10':return '29';break;
            case '11':return '30';break;
            case '12':return '31';break;
        }
    }

    
    function detalle_reporte_renovaciones(){
        $mes=date('m');
        $datos['totalAccEnf']=$this->cuadromando_model->getRenovacionesRenovadasTotalLineasPersonales('Accidentes y Enfermedades',$mes);
        $datos['totalDanios']=$this->cuadromando_model->getRenovacionesRenovadasTotal('DAÑOS',$mes);
        $datos['totalAutos']=$this->cuadromando_model->getRenovacionesRenovadasTotal('AUTOS INDIVIDUALES',$mes);
        $datos['totalVida']=$this->cuadromando_model->getRenovacionesRenovadasTotalLineasPersonales('Vida',$mes);

        $datos['autos_renovadas']=$this->cuadromando_model->setRenovacionesRenovadas('AUTOS INDIVIDUALES',$mes);
        $datos['danios_renovadas']=$this->cuadromando_model->setRenovacionesRenovadas('DAÑOS',$mes);
        $datos['vidas_renovadas']=$this->cuadromando_model->setRenovacionesRenovadasVida('LINEAS PERSONALES',$mes);

        $datos['renovacionesPendientes']=$this->cuadromando_model->renovacionesPendientes($mes);
        $datos['renovacionesPendientesRamo']=$this->renovacionesPendientesRamo($mes);

        $diaFinalMes=$this->diaFinalMes($mes);
        $datos['fdesde']='01/'.$mes.'/'.date('Y');
        $datos['fhasta']=$diaFinalMes.'/'.$mes.'/'.date('Y');
        
        $datos['comentario']=$this->getRenovacionJustificacion();
        $this->load->view("reportes/detalle_reporte_renovaciones",$datos);
    }

function getRenovacionJustificacion(){
    $mes=date('m');$year=date('Y');
    $sql="SELECT * FROM renovacionjustificacion where mes='$mes' AND anio='$year'";
    $rs=$this->db->query($sql)->result();
    if($rs){
        return $rs[0]->comentario;
    }else{
        return "";
    }
}

function guardar_renovacion_justificacion(){
    $mes=date('m');
    $year=date('Y');
    $comentario=trim($this->input->get('justificacion',true));
    $sql="SELECT * FROM renovacionjustificacion where mes='$mes' AND anio='$year'";
    $rs=$this->db->query($sql)->result();
    if($rs){
        $sql="UPDATE renovacionjustificacion set comentario='$comentario' Where mes='$mes' AND anio='$year'";
        $this->db->query($sql);
    }else{
        $sql="INSERT INTO renovacionjustificacion(mes,anio,comentario) VALUES ('$mes','$year','$comentario')";
        $this->db->query($sql);
    }
    $this->detalle_reporte_renovaciones();
}

    function renovaciones_fechas_pendiente(){
        $mes=$this->input->get('mes',true);
        
        $datos['totalAccEnf']=$this->cuadromando_model->getRenovacionesRenovadasTotalLineasPersonales('Accidentes y Enfermedades',$mes);
        $datos['totalDanios']=$this->cuadromando_model->getRenovacionesRenovadasTotal('DAÑOS',$mes);
        $datos['totalAutos']=$this->cuadromando_model->getRenovacionesRenovadasTotal('AUTOS INDIVIDUALES',$mes);
        $datos['totalVida']=$this->cuadromando_model->getRenovacionesRenovadasTotalLineasPersonales('Vida',$mes);

        $datos['autos_renovadas']=$this->cuadromando_model->setRenovacionesRenovadas('AUTOS INDIVIDUALES',$mes);
        $datos['danios_renovadas']=$this->cuadromando_model->setRenovacionesRenovadas('DAÑOS',$mes);
        $datos['vidas_renovadas']=$this->cuadromando_model->setRenovacionesRenovadasVida('LINEAS PERSONALES',$mes);

        $datos['renovacionesPendientes']=$this->cuadromando_model->renovacionesPendientes($mes);
        $datos['renovacionesPendientesRamo']=$this->renovacionesPendientesRamo($mes);

        $datos['comentario']=$this->getRenovacionJustificacion();
        $diaFinalMes=$this->diaFinalMes($mes);
        $datos['fdesde']='01/'.$mes.'/'.date('Y');
        $datos['fhasta']=$diaFinalMes.'/'.$mes.'/'.date('Y');
        $this->load->view("reportes/detalle_reporte_renovaciones_resumen",$datos);
    }

    //Modificacion Presupuesto
    function detalle_reporte_presupuesto(){
        $mes=date('m');
        $yearActual=date('Y');
        $yearPasado=date('Y')-1;
        
        for($i=1;$i<12+1;$i++){
            //SEGUROS COMISION Y GASTOS**************
            // Año Actual
            $this->datos['comisionActual'.$i]=$this->reportepresupuestomodel->DevulvePresupuesto($yearActual,$i);
            $this->datos['costoVenta'.$i]=$this->reportepresupuestomodel->DevulveCostoVenta($yearActual,$i);
            $this->datos['gastoOperaciones'.$i]=$this->reportepresupuestomodel->DevulveGasto($yearActual,$i);
            $this->datos['nomina'.$i]=$this->reportepresupuestomodel->DevulveNomina($yearActual,$i);
            $this->datos['bonoActual']=$this->reportepresupuestomodel->DevulveBono($yearActual);
            $this->datos['bonoPasado']=$this->reportepresupuestomodel->DevulveBono($yearPasado);

            //Año Pasado
            $this->datos['comisionPasado'.$i]=$this->reportepresupuestomodel->DevulvePresupuesto($yearPasado,$i);
            $this->datos['costoVentaPasado'.$i]=$this->reportepresupuestomodel->DevulveCostoVenta($yearPasado,$i);
            $this->datos['gastoOperacionesPasado'.$i]=$this->reportepresupuestomodel->DevulveGasto($yearPasado,$i);
            $this->datos['nominaPasado'.$i]=$this->reportepresupuestomodel->DevulveNomina($yearPasado,$i);
            

            //FIANZAS COMISION Y GASTOS ***************
            //Año Actual
            $this->datos['comisionActualFianzas'.$i]=$this->reportepresupuestomodel->DevuelveFianzas($yearActual,$i);
            $this->datos['costoVentaFianzas'.$i]=$this->reportepresupuestomodel->DevulveCostoFianza($yearActual,$i);
            $this->datos['gastoOperacionesFianzas'.$i]=$this->reportepresupuestomodel->DevulveGastoFianza($yearActual,$i);
            $this->datos['nominaFianzas'.$i]=$this->reportepresupuestomodel->DevulveNomina($yearActual,$i);

            //Año Pasado
            $this->datos['comisionPasadoFianzas'.$i]=$this->reportepresupuestomodel->DevuelveFianzas($yearPasado,$i);
            $this->datos['costoVentaPasadoFianzas'.$i]=$this->reportepresupuestomodel->DevulveCostoFianza($yearPasado,$i);
            $this->datos['gastoOperacionesPasadoFianzas'.$i]=$this->reportepresupuestomodel->DevulveGastoFianza($yearPasado,$i);
            $this->datos['nominaPasadoFianzas'.$i]=$this->reportepresupuestomodel->DevulveNominaFianza($yearPasado,$i);

            //CORPORATIVO****************
            //Año Actual
            $this->datos['comisionActualCorporativo'.$i]=$this->reportepresupuestomodel->DevulveComisionCoorpo($yearActual,$i);
            $this->datos['bonoActualCorporativo'.$i]=$this->reportepresupuestomodel->DevulveBonoCoorpo($yearActual,$i);

            $this->datos['gastoActualCorporativo'.$i]=$this->reportepresupuestomodel->DevulveGastoCoorpo($yearActual,$i);
            $this->datos['costoActualCorporativo'.$i]=$this->reportepresupuestomodel->DevulveCostoCoorpo($yearActual,$i);
            $this->datos['nominaActualCorporativo'.$i]=$this->reportepresupuestomodel->DevulveNominaCorpo($yearActual,$i);

            //Año Pasado
            $this->datos['comisionPasadoCorporativo'.$i]=$this->reportepresupuestomodel->DevulveComisionCoorpo($yearPasado,$i);
            $this->datos['bonoPasadoCorporativo'.$i]=$this->reportepresupuestomodel->DevulveBonoCoorpo($yearPasado,$i);

            $this->datos['gastoPasadoCorporativo'.$i]=$this->reportepresupuestomodel->DevulveGastoCoorpo($yearPasado,$i);
            $this->datos['costoPasadoCorporativo'.$i]=$this->reportepresupuestomodel->DevulveCostoCoorpo($yearPasado,$i);
            $this->datos['nominaPasadoCorporativo'.$i]=$this->reportepresupuestomodel->DevulveNominaCorpo($yearPasado,$i);
        }
        
        $this->load->view("reportes/detalle_reporte_presupuesto",$this->datos);
    }
    //-----------------------------------------------
	function reportePendienteFianzas(){

		$array_index=array();
		$id_vendedores=array();
	
		$sucursales=$this->personamodelo->obtenerCatalogSucursales();
		$ramosSicas=$this->catalogos_model->get_Ramos();
		$canales=$this->personamodelo->obtenerCatalogCanalSicas();
		//$idMeta=$this->personamodelo->obtenerMetaComercialAnual($this->tank_auth->get_idPersona());
		//$metaComercial=$this->personamodelo->regresaMontodelMes(date("m"),$idMeta->idMetaComercial);
		//$vendedoresActivos=$this->personamodelo->obtVendAct();
	
		/*foreach($vendedoresActivos as $valores){
			array_push($id_vendedores, $valores->idVend);
		}*/
	
		$grupos=$this->catalogos_model->obtener_grupos_habilitados();
	
		$array_index["sucursal"]=$sucursales;
		$array_index["ramosSicas"]=$ramosSicas;
		$array_index["canales"]=$canales;
		//$array_index["id_vendedores"]=$id_vendedores;
		//$array_index["metaComercial"]=$metaComercial;
		$array_index["grupos"]=$grupos;
		//$array_index["vendedores"]=$vendedoresActivos;
	
		$this->load->view("reportes/pendientesFianzas", $array_index);
	}
	//---------------------------------------------------------------------------
	function consultaRecibosFianzas(){
	
		set_time_limit(0); 
		$tipoRep=array();
		
		$this->load->library("WS_Sicas"); 
		$array['fechaInicial'] = str_replace("/","-",$_GET["fecha1"]);
		$array['fechaFinal'] = str_replace("/","-",$_GET["fecha2"]);
		$array['filtroGrupo'] = (!empty($_GET["grupo"])) ? $_GET["grupo"] : array(); //[10,14,16,3,1]; //array
		$array['excepcionGrupo'] = $_GET["check_grupo"];
		$array['filtroDespacho'] = (!empty($_GET["despacho"])) ? $_GET["despacho"] : array(); //[1,2,4,5,6,7,8,9]; //array
		$array['excepcionDespacho'] = $_GET["check_despacho"];
		$array['filtroGerencia'] = (!empty($_GET["canal"])) ? $_GET["canal"] : array(); //$_GET["canalSicas"]; //[5,6,9]; //array
		$array['excepcionCanales'] = $_GET["check_canal"];
		$array['filtroRamo'] = (!empty($_GET["ramo"])) ? $_GET["ramo"] : array(); //$_GET["ramosSicas"]; //[1,2,3,4]; //array
		$array['excepcionRamos'] = $_GET["check_ramo"];
		$array['tipoFecha'] = (!empty($_GET["fechaDocto"])) ? $_GET["fechaDocto"] : array(); //'FLimPago';//FDesde,FHasta,FLimPago,FGeneracion,FStatus,FDocto
		$array['filtroVendedor'] = array(); //(!empty($_GET["vendSicas"])) ? $_GET["vendSicas"] : array(); //'FLimPago';
		$array['excepcionVendedor'] = array(0); //$_GET["excepcion_vendedor"];
		$array['filtroStatus'] = array($_GET["reporte"]); //$tipoRep;
	
		$respuesta=$this->ws_sicas->recibosClientes($array); //Solicitud a Sicas.
	
		$Resultado = array();
	
		if(array_key_exists("TableInfo", $respuesta)){
	
			foreach($respuesta->TableInfo as $data_sicas){
	
				array_push($Resultado, array(
					"Documento" => (String)$data_sicas->Documento,
					"FDesde" => date("d-m-Y", strtotime((String)$data_sicas->FDesde)),//(String)$data_sicas->FDesde,
					"FHasta" => date("d-m-Y", strtotime((String)$data_sicas->FHasta)),//(String)$data_sicas->FHasta,
					"FLimPago" => date("d-m-Y", strtotime((String)$data_sicas->FLimPago)),//(String)$data_sicas->FLimPago,
					"Estado" => (String)$data_sicas->Status_TXT,
					"PrimaNeta" => (Float)$data_sicas->PrimaNeta,
					"PrimaTotal" => (Float)$data_sicas->PrimaTotal,
					"VendNombre" => (String)$data_sicas->VendNombre,
					"IDVendedor" => (Int)$data_sicas->IDVend,
					"Cliente" => (String)$data_sicas->NombreCompleto,
					"Afianzadora" => (String)$data_sicas->AgenteNombre,
					"Comision0" => (Float)$data_sicas->Comision0,
					"Comision3" => (Float)$data_sicas->Comision3,
				));
			}
		}
	
		echo json_encode($Resultado);
		
	
	}
	//----------------------------------------------------------------------------
	function gestionaAccion(){
	
		$response = array();
	
		switch($_POST["tipo"]){
			case "export": $response[$_POST["tipo"]] = $this->exportExcel($_POST["arr_obj"],$_POST["nombre"]);
			break;
			case "email": $response[$_POST["tipo"]] = $this->sendEmailNotification($_POST);
			break;
		}
	
		echo json_encode($response);
	}
	//----------------------------------------------------------------------------
	function exportExcel($array, $nombre){
	
		$this->load->library("excel");
	
		$nombreArchivo = "Reporte_pendientes";
		$this->excel->getActiveSheet()->setTitle("Registros Sicas");
		$this->excel->getActiveSheet(0)->setCellValue("A1", strtoupper($nombre));
		$this->excel->getActiveSheet(0)
					->setCellValue("A2", "Documento")
					->setCellValue("B2", "FDesde")
					->setCellValue("C2", "FHasta")
					->setCellValue("D2", "FLimPago")
					->setCellValue("E2", "PrimaNeta")
					->setCellValue("F2", "PrimaTotal")
					->setCellValue("G2", "Status")
					->setCellValue("H2", "Cliente")
					->setCellValue("I2", "Afianzadora")
					->setCellValue("J2", "Comision0")
					->setCellValue("K2", "Comision3");
	
		$i = 3;
	
		$styleCells = array(
			"alignment" => array(
				"horizontal" => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			)
		);
	
		foreach($array as $reg){
	
			$this->excel->getActiveSheet()
						->setCellValue("A".$i."", $reg["documento"])
						->setCellValue("B".$i."", $reg["fdesde"])
						->setCellValue("C".$i."", $reg["fhasta"])
						->setCellValue("D".$i."", $reg["flimpago"])
						->setCellValue("E".$i."", $reg["primaNeta"])
						->setCellValue("F".$i."", $reg["primaTotal"])
						->setCellValue("G".$i."", $reg["estado"])
						->setCellValue("H".$i."", $reg["cliente"])
						->setCellValue("I".$i."", $reg["afianzadora"])
						->setCellValue("J".$i."", $reg["comision0"])
						->setCellValue("K".$i."", $reg["comision3"]);
			$i++;
		}
	
		$objExcelWriter = PHPExcel_IOFactory::createWriter($this->excel, "Excel5");
		header('Content-Disposition: attachment;filename="'.$nombreArchivo.'.xlsx"');
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		$filePath = 'excel/'.$nombreArchivo.'.xls';
		ob_start();
		$objExcelWriter->save('php://output');
		$xlsdata = ob_get_contents();
		ob_end_clean();
	
		return array(
			"archivo" => $nombreArchivo.".xls",
			"file64" => "data:application/vnd.ms-excel;base64," . base64_encode($xlsdata)
		);
	}
	//---------------------------------------------------------------------------- //Dennis Castillo [2022-01-26]
	function sendEmailNotification($_array){
	
		$this->load->library("mailjet_api");
	
		$infoUsuario = $this->personamodelo->obtenerIdPersona($_array["idVend"]);
		$email_ =  $this->personamodelo->obtenerEmail($infoUsuario[0]->idPersona);
		$contenedor_email = array();

		if($_array["idVend"] == 7){

			array_push($contenedor_email, "COORDINADORCOMERCIAL@FIANZASCAPITAL.COM","EJECUTIVOCOMERCIAL@FIANZASCAPITAL.COM");
		} else{
			array_push($contenedor_email, $email_->email);
		}

		//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($contenedor_email,TRUE));fclose($fp);
		$tr_td = '';

		foreach($_array["arr_obj"] as $d_reg){
			$tr_td .= '
				<tr>
					<td style="padding: 3px 3px 3px 3px">'.$d_reg["documento"].'</td>
					<td style="padding: 3px 3px 3px 3px">'.$d_reg["fdesde"].'</td>
					<td style="padding: 3px 3px 3px 3px">'.$d_reg["fhasta"].'</td>
					<td style="padding: 3px 3px 3px 3px">'.$d_reg["flimpago"].'</td>
					<td style="padding: 3px 3px 3px 3px">'.$d_reg["primaTotal"].'</td>
					<td style="padding: 3px 3px 3px 3px">'.$d_reg["estado"].'</td>
					<td style="padding: 3px 3px 3px 3px">'.$d_reg["cliente"].'</td>
					<td style="padding: 3px 3px 3px 3px">'.$d_reg["afianzadora"].'</td>
				</tr>
			';
		}

		$mensaje = '
			<html>
				<head></head>
				<body>
					<div>
						<table>
							<tbody>
								<tr>
									<td>
										<div>
											<img src=\'cid:id1\' width="150" height="60"></img>
										</div>
									</td>
								</tr>
							</tbody>
							<div style="text-align: center;">
								<h4 style="font-family: helvetica;">Reporte de recibos pendientes</h4>
								<p style="font-family: helvetica;">
									Buen día. 
									En la siguiente tabla se muestra los recibos pendientes asociados a usted.
								</p>
							</div>
							<div>
								<table style="font-family: helvetica; text-align: center">
									<thead>
										<tr>
											<th>Documento</th>
											<th>FDesde</th>
											<th>FHasta</th>
											<th>FLimPago</th>
											<th>PrimaTotal</th>
											<th>Estado</th>
											<th>Cliente</th>
											<th>Afianzadora</th>
										</tr>
									</thead>
									<tbody>'.$tr_td.'</tbody>
								</table>
							</div>
						</table>
					</div>
				</body>
			</html>
		';

		$response_array = array();

		foreach($contenedor_email as $correo){

			$request_email = array();
			$request_email["to"] = $correo; //"AUXILIARDESARROLLO@AGENTECAPITAL.COM";
			$request_email["titulo"] = "Notificación de recibos pendientes";
			$request_email["mensaje"] = $mensaje;
			$request_email["nombre_archivo"] = "LogoFianzas.png";
			$request_email["encode_base64"] = base64_encode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/V3/assets/images/".$request_email["nombre_archivo"]));

			if(filter_var($correo, FILTER_VALIDATE_EMAIL) != false){

				$send_email = $this->mailjet_api->ejecuta_api_envio_de_correos($request_email);
				array_push($response_array, 
					$send_email["Messages"][0]["Status"] == "success" ? true : false
				);
			}
		}
		
		return in_array(false, $response_array) ? array("envio" => false) : array("envio" => true); //$response_array;

	}
	//--------------------------------------------
	//Dennis [2021-09-07]
	function getGoals(){

		$arrayResponse = array();
		$allCommission = $this->crmproyecto_model->getAllCommission();
		$allBonus = $this->crmproyecto_model->getAllBonus();
		$allCount = $this->crmproyecto_model->getAllCount();

		$commission = array_reduce($allCommission, function($acc, $curr){ 
			$acc += $curr->comision_efectuada_subsecuente; 
			return $acc; 
		}, 0);

		$bonus = array_reduce($allBonus, function($acc, $curr){
			$acc += $curr->prima_efectuada_subsecuente; 
			return $acc; 
		}, 0);

		$count = array_reduce($allCount, function($acc, $curr){
			$acc += $curr->recibos_efectuados_subsecuente; 
			return $acc; 
		}, 0);

		array_push($arrayResponse, 
			array("label" => "Comisión", "value" => $commission), 
			array("label" => "Prima", "value" => $bonus),
			array("label" => "Pólizas", "value" => $count));

		echo json_encode($arrayResponse);
	}

	//----------------------------------------------------------------------------

	//Modificacion MJ Detalles de FastFile y % de rotacion en cuadro de mando 07-12-2021
	
	function detalle_reporte_fastfile(){
	  if((isset($_REQUEST['mes']))&&(isset($_REQUEST['year']))){
	  	$mes=$_REQUEST['mes'];
	  	$year=$_REQUEST['year'];
	  }else{
	  	$mes=date('m');
	    $year=date('Y');
	  }
	  $datos['prestamos']=$this->cuadromando_model->getAllFastFile('prestamos',$mes,$year);
	  $datos['vacaciones']=$this->cuadromando_model->getAllFastFile('vacaciones',$mes,$year);
	  $datos['permisos']=$this->cuadromando_model->getAllFastFile('permiso',$mes,$year);
	  $datos['incapacidad']=$this->cuadromando_model->getAllFastFile('incapacidad',$mes,$year);

	  $datos['puntualidad']=$this->cuadromando_model->getAllFastFile('fastfile',$mes,$year);
	  $datos['sueldo']=$this->cuadromando_model->getAllFastFile('solicitud_sueldo',$mes,$year);
	  $datos['cambio_puesto']=$this->cuadromando_model->getAllFastFile('fastfile_cambio_puesto',$mes,$year);
	  $datos['calificacion']=$this->cuadromando_model->getAllFastFile('calificacion',$mes,$year);
	  $datos['capacitacion']=$this->cuadromando_model->getAllFastFile('capacitacion',$mes,$year);

	   //Fast File Rotacion
	  $datos['prestamosMensual']=$this->cuadromando_model->getAllFastFileMensual('prestamos',$mes,$year);
	  $datos['vacacionesMensual']=$this->cuadromando_model->getAllFastFileMensual('vacaciones',$mes,$year);
	  $datos['permisosMensual']=$this->cuadromando_model->getAllFastFileMensual('permiso',$mes,$year);
	  $datos['incapacidadMensual']=$this->cuadromando_model->getAllFastFileMensual('incapacidad',$mes,$year);
	  $datos['puntualidadMensual']=$this->cuadromando_model->getAllFastFileMensual('fastfile',$mes,$year);
	  $datos['sueldoMensual']=$this->cuadromando_model->getAllFastFileMensual('solicitud_sueldo',$mes,$year);
	  $datos['cambio_puestoMensual']=$this->cuadromando_model->getAllFastFileMensual('fastfile_cambio_puesto',$mes,$year);
	  $datos['calificacionMensual']=$this->cuadromando_model->getAllFastFileMensual('calificacion',$mes,$year);
	  $datos['capacitacionMensual']=$this->cuadromando_model->getAllFastFileMensual('capacitacion',$mes,$year);

	  $rs=$this->personamodelo->clasificacionUsuariosParaEnvios();
		$ct=0;
		foreach($rs as $i => $item){
            foreach($item["Data"] as $items){
                $ct++;
            }
        }
      $datos['todos']=$ct;
      $datos['mes']=$mes;
	  $datos['year']=$year;
	  $this->load->view("reportes/detalle_reporte_fastfile",$datos);
	}

	function detalle_reporte_rotacion(){
	  if((isset($_REQUEST['mes']))&&(isset($_REQUEST['year']))){
	  	$mes=$_REQUEST['mes'];
	  	$year=$_REQUEST['year'];
	  }else{
	  	$mes=date('m');
	    $year=date('Y');
	  }

	  $bajasComercialGlobal=$this->cuadromando_model->getBajasGlobal($year,1);
	  $bajasOperativoGlobal=$this->cuadromando_model->getBajasGlobal($year,2);
	  $bajasAdministrativoGlobal=$this->cuadromando_model->getBajasGlobal($year,3);
	  $bajasGerencialGlobal=$this->cuadromando_model->getBajasGlobal($year,4);
	  $bajasCorporativoGlobal=$this->cuadromando_model->getBajasGlobal($year,6);
	  $bajasFianzasGlobal=$this->cuadromando_model->getBajasGlobal($year,7);


	  $bajasComercial=$this->cuadromando_model->getBajas($mes,$year,1);
	  $bajasOperativo=$this->cuadromando_model->getBajas($mes,$year,2);
	  $bajasAdministrativo=$this->cuadromando_model->getBajas($mes,$year,3);
	  $bajasGerencial=$this->cuadromando_model->getBajas($mes,$year,4);
	  $bajasCorporativo=$this->cuadromando_model->getBajas($mes,$year,6);
	  $bajasFianzas=$this->cuadromando_model->getBajas($mes,$year,7);

	  $activosComercial=$this->cuadromando_model->getActivoByArea(1);
	  $activosOperativo=$this->cuadromando_model->getActivoByArea(2);
	  $activosAdministrativo=$this->cuadromando_model->getActivoByArea(3);
	  $activosGerencial=$this->cuadromando_model->getActivoByArea(4);
	  $activosCorporativo=$this->cuadromando_model->getActivoByArea(6);
	  $activosFianzas=$this->cuadromando_model->getActivoByArea(7);


	  $datos['bajasComercialGlobal']=$bajasComercialGlobal;
	  $datos['bajasOperativoGlobal']=$bajasOperativoGlobal;
	  $datos['bajasAdministrativoGlobal']=$bajasAdministrativoGlobal;
	  $datos['bajasGerencialGlobal']=$bajasGerencialGlobal;
	  $datos['bajasCorporativoGlobal']=$bajasCorporativoGlobal;
	  $datos['bajasFianzasGlobal']=$bajasFianzasGlobal;


	  $datos['bajasComercial']=$bajasComercial;
	  $datos['bajasOperativo']=$bajasOperativo;
	  $datos['bajasAdministrativo']=$bajasAdministrativo;
	  $datos['bajasGerencial']=$bajasGerencial;
	  $datos['bajasCorporativo']=$bajasCorporativo;
	  $datos['bajasFianzas']=$bajasFianzas;

	  $datos['activosComercial']=$activosComercial;
	  $datos['activosOperativo']=$activosOperativo;
	  $datos['activosAdministrativo']=$activosAdministrativo;
	  $datos['activosGerencial']=$activosGerencial;
	  $datos['activosCorporativo']=$activosCorporativo;
	  $datos['activosFianzas']=$activosFianzas;
	  
	  $datos['rotacionComercial']=number_format(($bajasComercial/($activosComercial/2))*100,2);
	  $datos['rotacionOperativo']=number_format(($bajasOperativo/($activosOperativo/2))*100,2);
	  $datos['rotacionAdministrativo']=number_format(($bajasAdministrativo/($activosAdministrativo/2))*100,2);
	  $datos['rotacionGerencial']=number_format(($bajasGerencial/($activosGerencial/2))*100,2);
	  $datos['rotacionCorporativo']=number_format(($bajasCorporativo/($activosCorporativo/2))*100,2);
	  $datos['rotacionFianzas']=number_format(($bajasFianzas/($activosFianzas/2))*100,2);

	  $datos['rotacionComercialGlobal']=number_format(($bajasComercialGlobal/($activosComercial/2))*100,2);
	  $datos['rotacionOperativoGlobal']=number_format(($bajasOperativoGlobal/($activosOperativo/2))*100,2);
	  $datos['rotacionAdministrativoGlobal']=number_format(($bajasAdministrativoGlobal/($activosAdministrativo/2))*100,2);
	  $datos['rotacionGerencialGlobal']=number_format(($bajasGerencialGlobal/($activosGerencial/2))*100,2);
	  $datos['rotacionCorporativoGlobal']=number_format(($bajasCorporativoGlobal/($activosCorporativo/2))*100,2);
	  $datos['rotacionFianzasGlobal']=number_format(($bajasFianzasGlobal/($activosFianzas/2))*100,2);


	  $datos['mes']=$mes;
	  $datos['year']=$year;
	  $this->load->view("reportes/detalle_reporte_rotacion",$datos);
	}

	//Fin de la midificacion

	//--------------------------
	function getGraphData(){

		$capacita = $this->getTrainingData();
		$incidencias = $this->getIncidencias();  //$this->procesamientoncmodel->tablaNCFechas($_POST);
		$siniestros = $this->getSiniestros();
		$marketing = $this->getMarketingData();
		$presupuesto = $this->getPresupuesto();
		$ventas = $this->getVentas();

		$response["capacita"] = $capacita;
		$response["incidencias"] = $incidencias;
		$response["siniestros"] = $siniestros;
		$response["marketing"] = $marketing;
		$response["presupuesto"] = $presupuesto;
		$response["ventas"] = $ventas;

		echo json_encode($response);
	}
	//--------------------------	
	function getVentas(){

		$params = array(
			"mes" => 1,
			"anio" => 2019,
			"posicion" => 0,
			"idPersona" => $this->tank_auth->get_idPersona(),
			"Usuario" => $this->tank_auth->get_usermail(),
		);

		$getData = $this->funnelM->clientesXmes($params);
		$onlyData = array_values($getData);

		$response["labels"] = array_keys($getData);
		$response["data"] = array_reduce($onlyData, function($acc, $curr){

			$acc[] = count($curr);
			return $acc;
		}, array());

		//$fp=fopen('resultadoJason.txt','a');fwrite($fp,print_r($response,true));fclose($fp); 
		return $response;
	}
	//--------------------------
	function getPresupuesto(){
		$meses=$this->libreriav3->devolverMeses();
		$mes=array();
		//$mes=['ENERO','FEBRERO','MARZO','ABRIL','MAYO','JUNIO','JULIO','AGOSTO','SEPTIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE'];
		//$datos="";
		$datos=array();
		$departamentos=$this->catalogos_model->obtenerCatAbtDpto(null);

		/*if($_POST['idPersonaDepartamento']==0){$departamentos=$this->catalogos_model->obtenerCatAbtDpto(null);}
		else{$buscar['idPersonaDepartamento']=$_POST['idPersonaDepartamento'];
			$departamentos=$this->catalogos_model->obtenerCatAbtDpto($buscar);}*/
		
		$relDptoApertura=$this->contabilidadmodelo->devolverDepartamentosPorApertura(3);
		
		$numMes=1;

		foreach ($meses as $key => $value) {
			$llave=$key;
			foreach ($departamentos as $valueDpto) {
				
				$datos[$value][$valueDpto->idPersonaDepartamento]['personaDepartamento']=$valueDpto->personaDepartamento;
				
				foreach ($relDptoApertura as  $valueDptoApertura) {
					if($valueDptoApertura->idPersonaDepartamento==$valueDpto->idPersonaDepartamento){;
						$datos[$value][$valueDpto->idPersonaDepartamento]['idPersonaDepartamento']=$valueDpto->idPersonaDepartamento;
						//$datos[$value][$valueDpto->idPersonaDepartamento]['presupuesto']=$valueDptoApertura->montoDAC/12;
						$montoMes['idAperturaContable']=3;
						$montoMes['idPersonaDepartamento']=$valueDpto->idPersonaDepartamento;
						$montoMes['idMes']=$numMes;
						//$presu=$this->db->get('aperturacontablemontomes')->result_array()[0]['montoMes'];
						$presu=$this->contabilidadmodelo->devolverAperturaContableMontoMes($montoMes);
						
						$datos[$value][$valueDpto->idPersonaDepartamento]['presupuesto']=$presu[0]['montoMes'];
						$datos[$value][$valueDpto->idPersonaDepartamento]['numMes']=$numMes;
						$datos[$value][$valueDpto->idPersonaDepartamento]['presupuestoAutorizado']=0;
						$consulta['mes']=$numMes;
						$consulta['idAperturaContable']=3;
						$consulta['idPersonaDepartamento']=$valueDpto->idPersonaDepartamento; 		
						$datos[$value][$valueDpto->idPersonaDepartamento]['presupuestoAutorizado']=$this->capsysdre->devolverPresupuestoAutorizado($consulta);
						$datos[$value][$valueDpto->idPersonaDepartamento]['presupuestoPagado']=$this->capsysdre->devolverPresupuestoPagado($consulta);
						$datos[$value][$valueDpto->idPersonaDepartamento]['saldoMes']=$datos[$value][$valueDpto->idPersonaDepartamento]['presupuesto']-$datos[$value][$valueDpto->idPersonaDepartamento]['presupuestoAutorizado'];
					}
				}
			}
			$numMes++;
		}
		//$fp=fopen('resultadoJason.txt','a');fwrite($fp,print_r($datos,true));fclose($fp); 
		$data['usuariosPresupuestos']= $this->capsysdre->usuariosDePresupuestos();
		$data['tipoVista']="controlPresupuesto";
		$data['Listafacturas']= $this->capsysdre->ListafacturasParaAutorizar();
		$data['presuma']= 0;//$this->capsysdre->SumaPresupuestos();
		$data['aperturaContable']=$this->contabilidadmodelo->aperturaContable(null);
		$data['departamentos']=$this->catalogos_model->obtenerCatAbtDpto(null);
		$data['reporte']=$datos;
		
		return $datos;

	}
	//--------------------------
	function getMarketingData(){

		$fields = array("AMIGODEESCUELA", "AMIGODEFAMILIA", "VECINOS", "CONOCIDOPASATIEMPOS", "FAMPROPIAOCONYUGUE", "CONOCIDOGRUPOSOCIAL", "CONOCIDOACTIVICOMUNIDAD", "CONOCIDOANTIGUOEMPLEO", "PERSONASHACENEGOCIO", "CENTRODEINFLUENCIA");
		$values = array();
		foreach($fields as $df){

			$query = $this->db->select("COUNT(*) AS total", false)
								->where("FuenteProspecto", $df)
								->get("clientes_actualiza")->row();
			array_push($values, $query->total);
		}


		$response["labels"] = array('Amigos de la Escuela', 'Amigos de la Familia', 'Vecinos','Conocido a traves de Pasatiempos','Familia propia o Conyugue','Conocidos a traves de Grupos Sociales','Conocidos por la Actividad de la Comunidad','Conocidos de los Antiguos Empleos','Personas con la que hace Negocios','Centro de Influencia');
		$response["data"] = $values;
		return $response;
	}
	//--------------------------
	function getSiniestros(){

		$values = array();
		$siniestros = array(
			"AUTOS INDIVIDUALES" => "AUTOSI",
			"GMM" => "GMM",
			"DAÑOS" => "DANOS",
			"AUTOS CORPORATIVO" => "AUTOSC",
		);

		foreach($siniestros as $label => $value){

			$getKPI = $this->graficas_model->getKPI_Siniestros($value, null, "2021", $this->tank_auth->get_idPersona());
			array_push($values, $getKPI["Totales"]["Total"]);
		}

		$response["labels"] = array_keys($siniestros);
		$response["data"] = $values;

		return $response;
	}
	//--------------------------
	function getIncidencias(){

		$values = array();
		$params = array(
			"fechaInicialGraf" => 1,
			"fechaFinalGraf" => 1,
			"tipoBusqueda" => "MES",
			"anioBusqueda" => 2021,
			"mesBusqueda" => 12,
			"mostrarTodos" => 1,
			"fechaInicial" => date("Y-m-d", mktime(0, 0 , 0, 1, 1, 2021)),
			"fechaFinal" => date("Y-m-d", mktime(0, 0 , 0, 12 + 1, 0, 2021)),
		);

		$data = $this->procesamientoncmodel->tablaNCFechas($params);
		array_push($values, $data["revisadas"], $data["pendientes"]);

		$response["labels"] = array("Revisadas", "Atrasadas");
		$response["data"] = $values;

		return $response;
	}
	//-------------------------
	function getTrainingData(){

		$getTrainings = $this->capacita_modelo->getTrainings();
		$trainings = array_reduce($getTrainings, function($acc, $curr){

			if(array_key_exists($curr->id_capacitacion, $acc)){
				$acc[$curr->id_capacitacion]["hours"] += $curr->horas;
				//$acc[$curr->id_capacitacion]["name"] = $curr->tipoCapacitacion;
			} else{
				$acc[$curr->id_capacitacion]["hours"] = floatval($curr->horas);
				$acc[$curr->id_capacitacion]["name"] = $curr->tipoCapacitacion;
			}
			return $acc;
		}, array());

		return $trainings;
	}
	//--------------------------
	function reporteCapacita(){

		$this->load->view("reportes/reporteCapacita");
	}
	//--------------------------
	function getFilterData(){

		$response = array();

		switch($_GET["band"]){
			case "budget": $response = $this->getYearFiltered($_GET["year"]);
			break;
			case "budget-fianzas": $response = $this->getYearFianzasFiltered($_GET["year"]);
			break;
			case "other": $response = $this->getYearExpensesFiltered($_GET["year"]);
			break;
			case "other-fianzas": $response = $this->getYearExpensesFianzasFiltered($_GET["year"]);
			break;
			case "budget-corporate": $response = $this->getYearCorporateFiltered($_GET["year"]);
			break;
			case "other-corporate": $response = $this->getYearExpensesCorporateFiltered($_GET["year"]);
			break;
		}

		echo json_encode($response);
	}
	//--------------------------
	function getYearExpensesCorporateFiltered($year){

		$salesCost = array();
		$getOperationExpenses = array();
		$getPaySheet = array();
		$restructuredExpends = array();

		for($i = 1; $i < 13; $i++){

			$data1[$i] = $this->reportepresupuestomodel->DevulveGastoCoorpo($year,$i);
			$data2[$i] = $this->reportepresupuestomodel->DevulveCostoCoorpo($year,$i);
			$data3[$i] = $this->reportepresupuestomodel->DevulveNominaCorpo($year,$i);
			array_push($salesCost, $data1[$i]);
			array_push($getOperationExpenses, $data2[$i]);
			array_push($getPaySheet, $data3[$i]);
		}

		foreach($getOperationExpenses as $mes => $data){

			$typeArray = !empty($data) ? $data : array((Object)array("sucursal" => "CCO", "total" => 0));
			array_push($restructuredExpends, $typeArray);
		}

		return $this->getExpensesJsonStructure($salesCost, $restructuredExpends, $getPaySheet);
		//return $this->getYearExpensesFiltered($year);
	}
	//--------------------------
	function getYearCorporateFiltered($year){

		$months = $this->libreriav3->devolverMeses();
		$comision = array();
		$bonos = array();
		$structure = array();

		for($i = 1; $i < 13; $i++){
			
			$data[$i] = $this->reportepresupuestomodel->DevulveComisionCoorpo($year, $i);
			$datab[$i] = $this->reportepresupuestomodel->DevulveBonoCoorpo($year, $i);
			array_push($comision, $data[$i]);
			array_push($bonos, $datab[$i]);
		}

		foreach($comision as $mes => $data){

			if(!empty($data)) {

				foreach($data as $ds){

					$structure[$ds->sucursal]["name"] = $ds->sucursal; //$ds->sucursal;
					$structure[$ds->sucursal]["records"][$mes] = !empty($ds->total) ? floatval($ds->total) : 0;
				}
			} else{
				$structure["comision"]["name"] = "comision"; //$ds->sucursal;
				$structure["comision"]["records"][$mes] = 0;
			}
		}

		foreach($bonos as $mes => $data){

			if(!empty($data)){
				foreach($data as $db){
					$structure[$db->sucursal]["name"] = $db->sucursal;
					$structure[$db->sucursal]["records"][$mes] = !empty($db->total) ? floatval($db->total) : 0;
				}
			} else{
				$structure["Bono"]["name"] = "Bono";
				$structure["Bono"]["records"][$mes] = 0;
			}
		}

		//$response["bono"] = !empty($bono) ? $bono->total : "0,00";
		$response["chart"] = array_values($structure);
		$response["months"] = array_values($months);
		//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($structure, TRUE));fclose($fp);
		return $response;
		//return $this->getYearFiltered($year);
	}
	//--------------------------
	function getYearExpensesFianzasFiltered($year){

		$getSalesCost = array();
		$getOperationExpenses = array();
		$getPaySheet = array();

		for($i = 1; $i < 13; $i++){

			$salesCost[$i] = $this->reportepresupuestomodel->DevulveCostoFianza($year,$i);
			$operationExpenses[$i] = $this->reportepresupuestomodel->DevulveGastoFianza($year,$i);
			$paysheet[$i] = $this->reportepresupuestomodel->DevulveNominaFianza($year,$i);
			array_push($getSalesCost, $salesCost[$i]);
			array_push($getOperationExpenses, $operationExpenses[$i]);
			array_push($getPaySheet, $paysheet[$i]);
		}
		
		return $this->getExpensesJsonStructure($getSalesCost, $getOperationExpenses, $getPaySheet);
		//return $this->getYearExpensesFiltered($year);
	}
	//--------------------------
	function getYearExpensesFiltered($year){

		$getSalesCost = array();
		$getOperationExpenses = array();
		$getPaySheet = array();

		for($i = 1; $i < 13; $i++){

			$salesCost[$i] = $this->reportepresupuestomodel->DevulveCostoVenta($year,$i);
			$operationExpenses[$i] = $this->reportepresupuestomodel->DevulveGasto($year,$i);
			$paysheet[$i] = $this->reportepresupuestomodel->DevulveNomina($year,$i);
			array_push($getSalesCost, $salesCost[$i]);
			array_push($getOperationExpenses, $operationExpenses[$i]);
			array_push($getPaySheet, $paysheet[$i]);
		}

		return $this->getExpensesJsonStructure($getSalesCost, $getOperationExpenses, $getPaySheet); //$response;
	}
	//--------------------------
	function getExpensesJsonStructure($arra1, $array2, $array3){

		$structure2 = array();
		$months = $this->libreriav3->devolverMeses();

		foreach($arra1 as $mes => $data){

			foreach($data as $ds){

				$structure2[$ds->sucursal]["name"] = $ds->sucursal;
				$structure2[$ds->sucursal]["records"][$mes] = !empty($ds->total) ? floatval($ds->total) : 0;
			}
		}

		foreach($array2 as $mes => $data){

			foreach($data as $ds){

				$structure2[$ds->sucursal]["name"] = $ds->sucursal;
				$structure2[$ds->sucursal]["records"][$mes] = !empty($ds->total) ? floatval($ds->total) : 0;
			}
		}

		foreach($array3 as $mes => $data){

			foreach($data as $ds){

				$structure2[$ds->sucursal]["name"] = $ds->sucursal;
				$structure2[$ds->sucursal]["records"][$mes] = !empty($ds->total) ? floatval($ds->total) : 0;
			}
		}

		$response["chart"] = array_values($structure2);
		$response["months"] = array_values($months);
		//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($structure2, TRUE));fclose($fp);
		return $response;
	}
	//--------------------------
	function getYearFianzasFiltered($year){

		$bono = $this->reportepresupuestomodel->DevulveBono($year);
		$months = $this->libreriav3->devolverMeses();
		$comision = array();
		$test = array();
		$structure = array();

		for($i = 1; $i < 13; $i++){
			
			//$data[$i] = $this->reportepresupuestomodel->DevulvePresupuesto($year , $i);
			$data[$i] = $this->reportepresupuestomodel->DevuelveFianzas($year, $i);
			array_push($comision, $data[$i]);
			//array_push($test, $otherData[$i]);
			//$test
		}

		foreach($comision as $mes => $data){

			foreach($data as $ds){

				$structure[$ds->Institucional]["name"] = $ds->Institucional;
				$structure[$ds->Institucional]["records"][$mes] = !empty($ds->Fianzas) ? floatval($ds->Fianzas) : 0;
			}
		}

		//$response["bono"] = !empty($bono) ? $bono->total : "0,00";
		$response["chart"] = array_values($structure);
		$response["months"] = array_values($months);
		//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($response, TRUE));fclose($fp);
		return $response;
	}
	//--------------------------
	function getYearFiltered($year){

		$bono = $this->reportepresupuestomodel->DevulveBono($year);
		$months = $this->libreriav3->devolverMeses();
		$comision = array();
		$structure = array();

		for($i = 1; $i < 13; $i++){
			
			$data[$i] = $this->reportepresupuestomodel->DevulvePresupuesto($year , $i);
			array_push($comision, $data[$i]);
		}

		foreach($comision as $mes => $data){

			foreach($data as $ds){

				$structure[$ds->Sucursal]["name"] = $ds->Sucursal;
				$structure[$ds->Sucursal]["records"][$mes] = !empty($ds->comision) ? floatval($ds->comision) : 0;
			}
		}

		$response["bono"] = !empty($bono) ? $bono->total : "0,00";
		$response["chart"] = array_values($structure);
		$response["months"] = array_values($months);
		//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($response, TRUE));fclose($fp);
		return $response;
		//echo json_encode($response);
	}
	//--------------------------

}

/* End of file reportes.php */
/* Location: ./application/controllers/reportes.php */

