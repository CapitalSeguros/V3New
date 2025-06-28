<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class reportes extends CI_Controller{

	var $meses;
	function __construct(){
		parent::__construct();


		$this->meses = array(
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
		
	    // $config = array (
				 // 'user_sicas' => $this->tank_auth->get_UserSICAS(),
				 // 'pass_sicas' => $this->tank_auth->get_PassSICAS()
			   // );
		
		// $this->load->library("webservice_sicas_soap",$config);
		
		// $this->load->model("catalogos_model");
		
		$this->load->library(array("webservice_sicas_soap","role"));	
		$this->load->model(array("catalogos_model","capsysdre_actividades","reportes_model"));
		
	}

	function index(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();			
			
			$data['Ramo'] = $this->catalogos_model->get_Ramos();	
			// $data['SubRamo'] = $this->catalogos_model->get_SubRamos();
			$data['Grupo'] = $this->catalogos_model->get_Grupos();
			
			$data['vendedor'] = $this->catalogos_model->get_Vendedor($this->tank_auth->get_IDVend(),$this->tank_auth->get_IDVendNS());
			$data['promotor'] = $this->catalogos_model->get_Promotor($this->tank_auth->get_IDVend(),$this->tank_auth->get_IDVendNS());
			$this->load->view('reportes/principal', $data);
		}
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
					,`Status`
					,`poliza`
					,`nombreCliente`
					,`tipoActividad`
					,`ramoActividad`
					,`subRamoActividad`
					,`satisfaccion`
					,`usuarioCreacion`
					,`usuarioResponsable`
					,`usuarioCotizador`
					,`superior`
					,`fechaCreacion`
					,`fechaPromesa`
					,`fechaCotizacion`
					,`fechaEmision`
					,`fechaTermino`
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
								";
				break;
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

	
	function getVendedor(){
		if($_REQUEST["IDVend"] != null){

			$ID = $_REQUEST["IDVend"];
			
			// var_dump($ID);

			if($ID > 0){
				$data['Vendedor'] = $this->catalogos_model->get_Vendedor($ID,$ID);
			}else{
				$data['Vendedor'] = $this->catalogos_model->get_Vendedor($this->tank_auth->get_IDVend(),$this->tank_auth->get_IDVendNS());
			}
			
			echo json_encode($data['Vendedor']);
		}

	}
	function getSubRamo(){
		if($_REQUEST["IDRamo"] != null){

			$ID = $_REQUEST["IDRamo"];
			
			$data['SubRamo'] = $this->catalogos_model->get_SubRamos($ID);

			echo json_encode($data['SubRamo']);
		}

	}
	function getSubGrupos(){

		if($_REQUEST["IDGrupo"] != null){
			$ID = $_REQUEST["IDGrupo"];
			$data['SubGrupo'] = $this->catalogos_model->get_SubGrupos($ID);

			echo json_encode($data['SubGrupo']);
		}
	}
	function demos(){
		$this->webservice_sicas_soap->UpdateClienteForVendedor();
	}
	
	function _getMeses($nMes){

		$tmpMonth = array();
		$star = 0;
		$end = 12;
		$anio = date("y");
		if($nMes > 0){
			for ($star=0; $star < $end  ; $star++) { 
				$tmpMonth[$nMes.'_'.$anio] = $this->meses[$nMes].'-'.$anio;
				if($nMes == 11){
					$nMes = 0;
					$anio++;
				}
				else{
					$nMes ++;
				}
			}
		}
		return $tmpMonth;
	}


	function verReporteAjax(){
		if(!$this->tank_auth->is_logged_in()){
			redirect('/auth/login/');
		}else{

			$skey = "";
			$disabled = false;
			$month = "";
			$name_consultar = "";
					
			switch ($this->input->post("consultar")) {
				case 'Renovacin':
					$skey = 'ren';
					$disabled = true;
					$data["mes"] = ($this->input->post("mes") == null ? "" : $this->input->post("mes"));
					$month = $data["mes"];
					$data["meses"] = $this->_getMeses(((int)date("m"))-1);
					$name_consultar = "Renovación";
				break;
				case 'Produccin':
					$skey = 'pro';
					$name_consultar = "Producción";
				break;
				case 'Cobranza Pendiente':
					$skey = 'cobp';
					$name_consultar = $this->input->post("consultar");
				break;
				case 'Cobranza Efectuada':
					$skey = 'cobe';
					$name_consultar = $this->input->post("consultar");
				break;
				case 'Cobranza Cancelada':
					$skey = 'cobc';
					$name_consultar = $this->input->post("consultar");
				break;
				case 'Buscador Clientes':
				$skey = 'cli';
					$name_consultar = $this->input->post("consultar");
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


			// var_dump($data_report);
			if($skey == 'cli'){		

				$posCol = intval($_POST['order'][0]['column']);
		 		$colDir = $_POST['order'][0]['dir'];
				$colsCli = array();

				$data_report['Sort'] = 'VCatClientes.IDCli';

				
		 		$colsCli[] = 'VCatClientes.Nombre';
		 		$colsCli[] = 'VCatClientes.RFC  ';
		 		$colsCli[] = 'VCatClientes.Telefono1 ';
		 		$colsCli[] = 'VCatClientes.Correo ';
		 		$colsCli[] = 'VCatClientes.IDCli ';
		 		// $colsCli[] = 'Direccion';

		 		if($posCol > 0)
		 			$data_report['Sort'] = $colsCli[$posCol - 1].' '.$colDir;

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


				 $data_client = $this->webservice_sicas_soap->GetReport($data_report);
				 $tb_client = array();
				 if($data_client['reporte'] != null){

					 foreach ($data_client['reporte'] as $value) {
					 	$item = new \stdClass;

					 		$item->IDCli =  $this->getValue($value->IDCli);
					 		$item->Nombre = $this->getValue($value->NombreCompleto);
					 		$item->RFC = $this->getValue($value->RFC);
					 		$item->Telefono1 = $this->getValue($value->Telefono1);
					 		$item->Correo = $this->getValue($value->EMail1);
					 		$item->Direccion = $this->getValue($value->Calle).' '.$this->getValue($value->NOExt).' '.$this->getValue($value->NOInt).' '.$this->getValue($value->Colonia);

					 		array_push($tb_client, $item);
					 }
					 if(isset($data_client['paginacion']['MaxRecords']))
				 	echo json_encode(array(
				 		'recordsTotal'=> strval($data_client['paginacion']['MaxRecords']) != NULL ? strval($data_client['paginacion']['MaxRecords']):'0',
				 		'recordsFiltered'=>strval($data_client['paginacion']['MaxRecords']) != NULL ? strval($data_client['paginacion']['MaxRecords']):'0',
				 		'data'=>$tb_client
				 		));	
			 	}else{
				 	echo json_encode(array(
				 		'recordsTotal'=> '0',
				 		'recordsFiltered'=> '0',
				 		'data'=>$tb_client
				 		));	
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
		 		
	 			$colsResp[] = 'VDatDocumentos.DPosterior';	
		 		

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

		 		$data_client = $this->webservice_sicas_soap->GetReport($data_report);
		 		$tb_renovacion = array();
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
					 
				 	echo json_encode(array(
				 		'recordsTotal'=> $data_client['paginacion']['MaxRecords'] != NULL ? strval($data_client['paginacion']['MaxRecords']):'0',
				 		'recordsFiltered'=> $data_client['paginacion']['MaxRecords'] != NULL ? strval($data_client['paginacion']['MaxRecords']):'0',
				 		'data'=>$tb_renovacion
			 			));	
			 	}else{
				 	echo json_encode(array(
				 		'recordsTotal'=> '0',
				 		'recordsFiltered'=> '0',
				 		'data'=>$tb_renovacion
				 		));	
			 	}
	 			
		 	}

		}
	}

	function getExcelAjax(){
		if(!$this->tank_auth->is_logged_in()){
			redirect('/auth/login/');
		}else{

			$skey = "";
			$disabled = false;
			$month = "";
			$name_consultar = "";
					
			switch ($this->input->post("consultar")) {
				case 'Renovacin':
					$skey = 'ren';
					$disabled = true;
					$data["mes"] = ($this->input->post("mes") == null ? "" : $this->input->post("mes"));
					$month = $data["mes"];
					$data["meses"] = $this->_getMeses(((int)date("m"))-1);
					$name_consultar = "Renovación";
				break;
				case 'Produccin':
					$skey = 'pro';
					$name_consultar = "Producción";
				break;
				case 'Cobranza Pendiente':
					$skey = 'cobp';
					$name_consultar = $this->input->post("consultar");
				break;
				case 'Cobranza Efectuada':
					$skey = 'cobe';
					$name_consultar = $this->input->post("consultar");
				break;
				case 'Cobranza Cancelada':
					$skey = 'cobc';
					$name_consultar = $this->input->post("consultar");
				break;
				case 'Buscador Clientes':
				$skey = 'cli';
					$name_consultar = $this->input->post("consultar");
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
			

				
			$vigencia = "";

			if(!empty($data["fechaini"]) && !empty($data["fechafin"])){
				$vigencia = $data["fechaini"] . "|" . $data["fechafin"];
			}	
			
			
			$data_report = array(
			'page'=> $sPage, 
			'TypeReporte'=>$skey,
			'ItemforPage' => 1000,
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


		 		$tb_client = array();
		 		do{

				 	$data_client = $this->webservice_sicas_soap->GetReport($data_report);

				 	
				 	if($data_client['reporte'] != null){
				 		if(isset($data_client['paginacion'])){
							$pages = $data_client['paginacion']['Pages'];
						}
					

					 	foreach ($data_client['reporte'] as $value) {
						 	$item = new \stdClass;

					 		$item->IDCli =  $this->getValue($value->IDCli);
					 		$item->Nombre = $this->getValue($value->NombreCompleto);
					 		$item->RFC = $this->getValue($value->RFC);
					 		$item->Telefono1 = $this->getValue($value->Telefono1);
					 		$item->Correo = $this->getValue($value->EMail1);
					 		$item->Direccion = $this->getValue($value->Calle).' '.$this->getValue($value->NOExt).' '.$this->getValue($value->NOInt).' '.$this->getValue($value->Colonia);

				 			array_push($tb_client, $item);
					 	}
				 	}

				 	$page++;
					$data_report['page'] = $page;
				}while($page <= $pages);
					 
			 	echo json_encode(array(
			 		'data'=>$tb_client	));	


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

				$tb_renovacion = array();

		 		do{

			 		$data_client = $this->webservice_sicas_soap->GetReport($data_report);
			 		
		 		 	if(isset($data_client['paginacion']['MaxRecords'])){

		 		 		if(isset($data_client['paginacion'])){
							$pages = $data_client['paginacion']['Pages'];
						}
		 		 		
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

			 	 	$page++;
					$data_report['page'] = $page;
				}while($page <= $pages);
					 
			 	echo json_encode(array(
			 		'data'=>$tb_renovacion
		 			));	
			 	
	 			
		 	}

		}
	}

	function formatDate($date){
		$tmpDate = new DateTime($date);
		return $tmpDate->format('Y/m/d');

	}
	function formatMoney($num){
		return '$ '.number_format((Double)$num, 2, '.', ',');
	}

	function verReporte()
	{
		if(!$this->tank_auth->is_logged_in()){
			redirect('/auth/login/');
		}else{
			// require_once('assets/phpgrid/conf.php');

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
			if($skey == 'cli'){	

				// $this->reportes_model->clearCli($this->tank_auth->get_user_id(),$tipoReporte);
			 // 	$this->reportes_model->clearDoc($this->tank_auth->get_user_id(),$tipoReporte);
				// do{
				// 	$data_client = $this->webservice_sicas_soap->GetReport($data_report);

				// 	if($data_client['reporte'] != null){
				// 		if(isset($data_client['paginacion'])){
				// 			$pages = $data_client['paginacion']['Pages'];
				// 		}

				// 	 	foreach ($data_client['reporte'] as $value) {

				// 		 	$tmpDocto = $this->object_to_array($value);

				// 		 	$tmpDocto['IDUserLocal'] = $this->tank_auth->get_user_id();
				// 		 	$tmpDocto['TipoReporte'] = $tipoReporte;
				// 		 	$polizas = array();
				// 		 	$polizas = $this->getPolicyforIDCli($value->IDCli,$tipoReporte);

				// 	 	 	$this->reportes_model->addClientes($tmpDocto,$polizas,$this->tank_auth->get_user_id(),$tipoReporte);
				// 	 	}
				// 	 }

				// 	$page++;
				// 	$data_report['page'] = $page;
				// }while($page < $pages);	
				// $dt = new DateTime();
				// $sDate = $dt->format('Y-m-d HH:mm:ss');
				// $bitacora_rep = array(
				// 		'IDUserLocal'=>$this->tank_auth->get_user_id(),
				// 		'TipoReporte'=>$tipoReporte,
				// 		'Fecha'=> $sDate);
				
				// 	$rs = $this->reportes_model->addBitReg($bitacora_rep	);
				// 	if(!$rs){
				// 		$everything_is_ok = false;
					 		
				//  	}

				// $SQL = "SELECT 
				// 				NombreCompleto,
				// 				RFC,
				// 				Telefono1,
				// 				EMail1,
				// 				Direccion,
				// 				IDCli,
				// 				IDCont
				//  	 		FROM cliente";

		 	// 	$data['phpgrid'] = new C_DataGrid($SQL, "IDCli", "cliente");
		 	// 	$data['phpgrid'] -> set_query_filter("IDUserLocal = ". $this->tank_auth->get_user_id()." AND TipoReporte = ".$tipoReporte);
 			//  	$data['phpgrid'] -> set_col_hidden('IDCont');
 			//  	$data['phpgrid'] -> set_col_hidden('IDCli');

 			//  	$data['phpgrid'] -> set_caption("Reporte ".$name_consultar);
				// $data['phpgrid'] -> set_dimension(1100, 460, false); 
				// $data['phpgrid'] -> enable_search(true);
				// $data['phpgrid'] -> enable_export('true'); //PDF
				// $data['phpgrid'] -> set_locale("sp");
				// $data['phpgrid'] -> enable_resize(true); 

				// $SQL = "SELECT 
				// 			IDDocto,
				// 			TipoDocto_TXT AS Tipo,
				// 			Status_TXT AS Estatus,
				// 			Documento,
				// 			FDesde AS Desde,
				// 			FHasta AS Hasta,
				// 			VendNombre AS Vendedor,
				// 			CAgente AS `ClaveAgente`,
				// 			AgenteNombre AS Compania,
				// 			FPago AS `FormaPago`,
				// 			SRamoAbreviacion AS `SubRamo`,
				// 			PrimaNeta AS `PrimaNeta`,
				// 			PrimaTotal AS `PrimaTotal`,									
				// 			ClaveBit,
				// 			IDSRamo,
				// 			IDCli,
				// 			RowNumber,
				// 			RamosNombre
				// 		FROM documento ";

				// $datos = new C_DataGrid($SQL, array("IDDocto"), "documento");
				// $datos->set_query_filter("IDUserLocal = ". $this->tank_auth->get_user_id()." AND TipoReporte = '".$tipoReporte."'");

			 // 	$datos -> set_col_hidden('IDDocto');
			 // 	$datos -> set_col_hidden('ClaveBit');
			 // 	$datos -> set_col_hidden('IDSRamo');
			 // 	$datos -> set_col_hidden('IDCli');
			 // 	$datos -> set_col_hidden('RowNumber');
			 // 	$datos -> set_col_hidden('RamosNombre');

 			//  	$datos -> set_col_date("Desde", "Y/m/d", "Y/m/d", "Y/m/d");
			 // 	$datos -> set_col_date("Hasta", "Y/m/d", "Y/m/d", "Y/m/d");
			 // 	$datos -> set_col_currency("PrimaNeta", "$", "",",", ".", 2, "0.00");
			 // 	$datos -> set_col_currency("PrimaTotal", "$", "",",", ".", 2, "0.00");

				// $data['phpgrid'] -> set_subgrid($datos, 'IDCli');

	 		 	$this->load->view('reportes/reportecliente', $data);

		 	}else {

		 		// $this->reportes_model->clearDoc($this->tank_auth->get_user_id(),$tipoReporte);
		 		// $this->reportes_model->clearBit($this->tank_auth->get_user_id(),$tipoReporte);
		 		// $this->reportes_model->clearDocBot($this->tank_auth->get_user_id(),$tipoReporte);

		 	// 	$tmpDoctos = array();
	 		// 	do{	
		 	// 		$data_client = $this->webservice_sicas_soap->GetReport($data_report);

	 		//  		if(isset($data_client['paginacion']['MaxRecords'])){

	 		//  			if(isset($data_client['paginacion'])){
				// 			$pages = $data_client['paginacion']['Pages'];
				// 		}

		 	// 	 		foreach ($data_client['reporte'] as $value) {
		 	// 	 			$tmpDocto = array();

	 		// 			 	$sSerie = "";
				// 		 	$sFDesde = "";
				// 	 		if($skey == 'cobp' || $skey == 'cobe' || $skey == 'cobc' ){
				// 	 			$tmpDocto['Serie'] = $this->getValue($value->Serie);
				// 	 		}

				// 	 		if ($skey == "ren" || $skey == 'pro'){
				// 	 			$tmpDocto['FDesde'] = $this->getValue($value->FDesde);
				// 	 		}else{
				// 	 			$tmpDocto['FLimPago'] = $this->getValue($value->FLimPago);
				// 	 		}
		 		 		
		 	// 	 			$tmpDocto['IDDocto'] = $this->getValue($value->IDDocto);
				// 			$tmpDocto['TipoDocto_TXT'] = $this->getValue($value->TipoDocto_TXT);
				// 			$tmpDocto['Documento'] = $this->getValue($value->Documento);
				// 			$tmpDocto['DAnterior'] = $this->getValue($value->DAnterior);
				// 			$tmpDocto['DPosterior'] = $this->getValue($value->DPosterior);
				// 			$tmpDocto['FHasta'] = $this->getValue($value->FHasta);
				// 			$tmpDocto['Status_TXT'] = $this->getValue($value->Status_TXT);
				// 			$tmpDocto['NombreCompleto'] = $this->getValue($value->NombreCompleto);
				// 			$tmpDocto['Grupo'] = $this->getValue($value->Grupo);
				// 			$tmpDocto['SubGrupo'] = $this->getValue($value->SubGrupo);
				// 			$tmpDocto['Concepto'] = $this->getValue($value->Concepto);
				// 			$tmpDocto['Referencia1'] = $this->getValue($value->Referencia1);
				// 			$tmpDocto['Referencia2'] = $this->getValue($value->Referencia2);
				// 			$tmpDocto['FolioNo'] = $this->getValue($value->FolioNo);
				// 			$tmpDocto['Moneda'] = $this->getValue($value->Moneda);
				// 			$tmpDocto['FPago'] = $this->getValue($value->FPago);
				// 			$tmpDocto['CAgente'] = $this->getValue($value->CAgente);
				// 			$tmpDocto['AgenteNombre'] = $this->getValue($value->AgenteNombre);
				// 			$tmpDocto['SRamoAbreviacion']  = $this->getValue($value->SRamoAbreviacion);
				// 			$tmpDocto['PrimaNeta']  = $this->getValue($value->PrimaNeta);
				// 			$tmpDocto['PrimaTotal']  = $this->getValue($value->PrimaTotal);
				// 			$tmpDocto['EjecutNombre']  = $this->getValue($value->EjecutNombre);
				// 			$tmpDocto['VendNombre']  = $this->getValue($value->VendNombre);
				// 			$tmpDocto['ClaveBit'] = $this->getValue($value->ClaveBit);
				// 			$tmpDocto['IDSRamo'] = $this->getValue($value->IDSRamo);
				// 			$tmpDocto['IDCli'] = $this->getValue($value->IDCli);
				// 			$tmpDocto['RowNumber'] = $this->getValue($value->RowNumber);
				// 			$tmpDocto['RamosNombre'] = $this->getValue($value->RamosNombre);

						

				// 		 	$tmpDocto['IDUserLocal'] = $this->tank_auth->get_user_id();
				// 		 	$tmpDocto['TipoReporte'] = $tipoReporte;

				// 		 	array_push($tmpDoctos, $tmpDocto);
				// 	 	}
				// 	}
				// 	$page++;
				// 	$data_report['page'] = $page;
				// }while($page < $pages);	

				// $data['doctos'] = $tmpDoctos;

				// $this->reportes_model->addReportes($tmpDoctos,array(),$this->tank_auth->get_user_id(),$tipoReporte);

				// $dt = new DateTime();
				// $sDate = $dt->format('Y-m-d HH:mm:ss');
				// $bitacora_rep = array(
				// 	'IDUserLocal'=>$this->tank_auth->get_user_id(),
				// 	'TipoReporte'=>$tipoReporte,
				// 	'Fecha'=> $sDate);
			
				// $rs = $this->reportes_model->addBitReg($bitacora_rep	);
				// if(!$rs){
				// 	$everything_is_ok = false;
				 		
			 // 	}
				// // $bitacoras = $this->SaveInfoBit($tmpDocto['ClaveBit'],$tipoReporte);

			 // 	$rs = $this->reportes_model->addReportes($tmpDocto,$bitacoras,$this->tank_auth->get_user_id(),$tipoReporte);
			 // 	if(!$rs)
			 // 	{
			 // 		$everything_is_ok = false;
			 		
			 // 	}

			 // 	$sSerie = "";
			 // 	$sFDesde = "";
		 	// 	if($skey == 'cobp' || $skey == 'cobe' || $skey == 'cobc' ){
		 	// 		$sSerie = 'Serie,';
		 	// 	}

		 	// 	if ($skey == "ren" || $skey == 'pro'){
		 	// 		$sFDesde = 'FDesde';
		 	// 	}else{
		 	// 		$sFDesde = 'FLimPago';
		 	// 	}		

			 // 	$SQL = "SELECT 
				// 			IDDocto,
				// 			TipoDocto_TXT,
				// 			Documento,
				// 			".$sSerie."
				// 			DAnterior,
				// 			DPosterior,
				// 			".$sFDesde.",
				// 			FHasta,
				// 			Status_TXT,
				// 			NombreCompleto,
				// 			Grupo,
				// 			SubGrupo,
				// 			Concepto,
				// 			Referencia1,
				// 			Referencia2,
				// 			FolioNo,
				// 			Moneda,
				// 			FPago,
				// 			CAgente,
				// 			AgenteNombre,
				// 			SRamoAbreviacion ,
				// 			PrimaNeta ,
				// 			PrimaTotal ,
				// 			EjecutNombre ,
				// 			VendNombre ,
				// 			ClaveBit,
				// 			IDSRamo,
				// 			IDCli,
				// 			RowNumber,
				// 			RamosNombre
				// 		FROM documento ";


			 // 	$data['phpgrid'] = new C_DataGrid($SQL, "IDDocto", "Documento");
			 // 	$data['phpgrid'] -> set_query_filter("IDUserLocal = ". $this->tank_auth->get_user_id()." AND TipoReporte = ".$tipoReporte);
			 // 	// $data['phpgrid']->enable_edit("INLINE", "CRUD");

			 // 	$data['phpgrid'] -> set_col_hidden('IDDocto');
			 // 	$data['phpgrid'] -> set_col_hidden('ClaveBit');
			 // 	$data['phpgrid'] -> set_col_hidden('IDSRamo');
			 // 	$data['phpgrid'] -> set_col_hidden('IDCli');
			 // 	$data['phpgrid'] -> set_col_hidden('RowNumber');
			 // 	$data['phpgrid'] -> set_col_hidden('RamosNombre');

				// $data['phpgrid'] -> set_col_title("TipoDocto_TXT", "Tipo");
				// $data['phpgrid'] -> set_col_title("DAnterior", "Anterior");
				// $data['phpgrid'] -> set_col_title("DPosterior", "Posterior");
				// $data['phpgrid'] -> set_col_title("FDesde", "Desde");
				// $data['phpgrid'] -> set_col_title("FHasta", "Hasta");
				// $data['phpgrid'] -> set_col_title("Status_TXT", "Estatus");
									
				// $data['phpgrid'] -> set_col_title("FolioNo", "Folio");
				// // $data['phpgrid'] -> set_col_title("Moneda", "Moneda");					
				// $data['phpgrid'] -> set_col_title("FPago", "Forma Pago");
				// $data['phpgrid'] -> set_col_title("CAgente", "Clave Agente");
				// $data['phpgrid'] -> set_col_title("AgenteNombre", "Compania");
				// $data['phpgrid'] -> set_col_title("SRamoAbreviacion", "SubRamo");
				// $data['phpgrid'] -> set_col_title("PrimaNeta", "Prima Neta");
				// $data['phpgrid'] -> set_col_title("PrimaTotal", "Prima Total");
				// $data['phpgrid'] -> set_col_title("EjecutNombre", "Ejecutivo");
				// $data['phpgrid'] -> set_col_title("VendNombre", "Vendedor");		

		 	// 	$data['phpgrid'] -> set_col_date("FDesde", "Y/m/d", "Y/m/d", "Y/m/d");				
			 // 	$data['phpgrid'] -> set_col_date("FHasta", "Y-m-d", "Y/m/d", "Y/m/d");					
			 // 	$data['phpgrid'] -> set_col_currency("PrimaNeta", "$", "",",", ".", 2, "0.00");
			 // 	$data['phpgrid'] -> set_col_currency("PrimaTotal", "$", "",",", ".", 2, "0.00");
			 // 	if ($skey == "ren"){
 			// 		$data['phpgrid'] -> set_conditional_format("Status_TXT","ROW",array("condition"=>"eq","value"=>"Renovada","css"=> array("color"=>"#FFFFFF", "background-color"=>"#0000FF")));
				// 	$data['phpgrid'] ->set_conditional_format("Status_TXT","ROW",array("condition"=>"eq","value"=>"No Renovada","css"=> array("color"=>"black", "background-color"=>"#FFFF00")));
				// 	$data['phpgrid'] ->set_conditional_format("Status_TXT","ROW",array("condition"=>"eq","value"=>"Cancelada","css"=> array("color"=>"black", "background-color"=>"#FF0000")));
				// 	$data['phpgrid'] ->set_conditional_format("Status_TXT","ROW",array("condition"=>"eq","value"=>"Anulada","css"=> array("color"=>"#FFFFFF", "background-color"=>"#FF9900")));
		 	// 	}

			 // 	//* Personalizacion General
				// $data['phpgrid'] -> set_caption("Reporte ".$name_consultar);
				// $data['phpgrid'] -> set_dimension(1100, 460, false); 
				// $data['phpgrid'] -> enable_search(true);
				// $data['phpgrid'] -> enable_export('EXCEL'); //PDF
				// $data['phpgrid'] -> set_locale("sp");
				// $data['phpgrid'] -> enable_resize(true); 

				// $data['phpgrid']->set_col_format("Documento", "showlink", array("baseLinkUrl"=>"javascript:", "target"=>"_self",
				// "showAction"=>"showPoliza(jQuery('#Documento'),'",
				// "addParam"=> "');"));
				// $data['phpgrid']->set_col_format("DAnterior", "showlink", array("baseLinkUrl"=>"javascript:", "target"=>"_self",
				// "showAction"=>"showPoliza(jQuery('#Documento'),'",
				// "addParam"=> "');"));
				// $data['phpgrid']->set_col_format("DPosterior", "showlink", array("baseLinkUrl"=>"javascript:", "target"=>"_self",
				// "showAction"=>"showPoliza(jQuery('#Documento'),'",
				// "addParam"=> "');"));

			 // 	$SQL = "SELECT IDDocto,IDSRamo,IDCli,Documento,ClaveBit,'Cotizacion','Emision','Endoso','Cancelacion','Diligencia','CapturaRenovacion' FROM documento_botones";

				// $datos = new C_DataGrid($SQL, array("IDDocto"), "documento_botones");
				// $datos->set_query_filter("IDUserLocal = ". $this->tank_auth->get_user_id()." AND TipoReporte = '".$tipoReporte."'");

				// // Columnas Ocultas
				// $datos -> set_col_hidden("IDDocto");
				// $datos -> set_col_hidden("IDSRamo");
				// $datos -> set_col_hidden("IDCli");
				// $datos -> set_col_hidden("Documento");
				// $datos -> set_col_hidden("ClaveBit");


				// 	// Cambiar Nombre de la Columna
				// $datos -> set_col_title("Cotizacion", "");
				// $datos -> set_col_title("Emision", "");
				// $datos -> set_col_title("Endoso", "");
				// $datos -> set_col_title("Cancelacion", "");
				// $datos -> set_col_title("Diligencia", "");
				// $datos -> set_col_title("CapturaRenovacion", "");

				


				// $datos->set_col_format("Cotizacion", "showlink", array("baseLinkUrl"=>"javascript:", "target"=>"_self",
				// "showAction"=>"enviarActividad(jQuery('#Documento'),'",
				// "addParam"=> "&".base_url()."actividades/agregar/Cotizacion');"));

				// $datos->set_col_format("Emision", "showlink", array("baseLinkUrl"=>"javascript:", "target"=>"_self",
				// "showAction"=>"enviarActividad(jQuery('#Documento'),'",
				// "addParam"=> "&".base_url()."actividades/agregar/Emision');"));

				// $datos->set_col_format("Endoso", "showlink", array("baseLinkUrl"=>"javascript:", "target"=>"_self",
				// "showAction"=>"enviarActividad(jQuery('#Documento'),'",
				// "addParam"=> "&".base_url()."actividades/agregar/Endoso');"));

				// $datos->set_col_format("Cancelacion", "showlink", array("baseLinkUrl"=>"javascript:", "target"=>"_self",
				// "showAction"=>"enviarActividad(jQuery('#Documento'),'",
				// "addParam"=> "&".base_url()."actividades/agregar/Cancelacion');"));

				// $datos->set_col_format("Diligencia", "showlink", array("baseLinkUrl"=>"javascript:", "target"=>"_self",
				// "showAction"=>"enviarActividad(jQuery('#Documento'),'",
				// "addParam"=> "&".base_url()."actividades/agregar/Diligencia');"));

				// $datos->set_col_format("CapturaRenovacion", "showlink", array("baseLinkUrl"=>"javascript:", "target"=>"_self",
				// "showAction"=>"enviarActividad(jQuery('#Documento'),'",
				// "addParam"=> "&".base_url()."actividades/agregar/Enviar');"));

				// $SQL = "SELECT IDBit,ClaveBit,".$sSerie."RowNumber,IDUserLocal,TipoReporte,Comentario FROM bitacora ";

				
			 // 	$sdg = new C_DataGrid($SQL, array("IDBit","ClaveBit"), "Bitacora");
			 // 	$sdg -> set_query_filter("IDUserLocal = ". $this->tank_auth->get_user_id()." AND TipoReporte = '".$tipoReporte."'");

			 // 	$sdg -> set_col_hidden('IDBit');

		 	// 	if($skey == 'cobp' || $skey == 'cobe' || $skey == 'cobc' ){
		 	// 		$sdg -> set_col_hidden('Serie');
		 	// 	}
			 // 	$sdg -> set_col_hidden('RowNumber');
			 // 	$sdg -> set_col_hidden('IDUserLocal');
			 // 	$sdg -> set_col_hidden('TipoReporte');

			 // 	$datos -> set_subgrid($sdg, 'ClaveBit');

			 // 	$data['phpgrid'] -> set_subgrid($datos, 'IDDocto');
			 	

			 	$this->load->view('reportes/reporte', $data);		 	
	 			
		 	}

		}		
	}


	function updateReport()
	{
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

	function object_to_array($obj) {
	    if(is_object($obj)) $obj = (array) $obj;

	    if(is_array($obj)) {
	        $new = array();
	        foreach($obj as $key => $val) {
	        	if(is_object($val))
	        		$new[$key] = ' ';
	        	else
	        		$new[$key] = $val;	
	            
	        }
	    }
	    else $new = $obj;
	    return $new;       
	}

	function hverReporte()
	{
		if(!$this->tank_auth->is_logged_in()){
			redirect('/auth/login/');
		}else{
		
			/* name="cliente"
			name="ramo"
			name="subramo"
			name="fechaini"
			name="fechafin"
			name="poliza"
			name="estatus"
			name="vendedor"
			name="grupo"
			name="subgrupo"
			name="promotor" */

			$skey = "";
			// $disabled = false;
			// $month = "";



			switch ($this->input->get("consultar")) {
				case 'Renovacin':
					$skey = 'ren';
					$disabled = true;
					$data["mes"] = ($this->input->get("mes") == null ? "" : $this->input->get("mes"));
					$month = $data["mes"];
					$data["meses"] = $this->_getMeses(((int)date("m"))-1);
				break;
				
				case 'Produccin':
					$skey = 'pro';
				break;
				
				case 'Cobranza Pendiente':
					$skey = 'cob';
				break;
				
				case 'Buscador Clientes':
					$skey = 'cli';
				break;
				
				case 'Actividades':
					$skey = 'act';
					redirect('/reportes/actividades/');
				break;
			}


			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();

			
			$data["page"] 			= ($this->input->get("page") 		== null ? 1 : $this->input->get("page"));
			$data["cliente"] 		= ($this->input->get("cliente") 	== null ? "" : $this->input->get("cliente"));
			$data["ramo"] 			= ($this->input->get("ramo") 		== null ? "" : $this->input->get("ramo"));
			$data["subramo"] 		= ($this->input->get("subramo") 	== null ? "" : $this->input->get("subramo"));
			$data["fechaini"] 		= ($this->input->get("fechaini") 	== null ? "" : $this->input->get("fechaini"));
			$data["fechafin"] 		= ($this->input->get("fechafin") 	== null ? "" : $this->input->get("fechafin"));
			$data["aseguradora"]	= ($this->input->get("aseguradora") == null ? "" : $this->input->get("aseguradora"));
			$data["habilitarf"]		= ($this->input->get("habilitarf") == null ? "" : (bool)$this->input->get("habilitarf"));
			
			$data["poliza"] 		= ($this->input->get("poliza") 	== null ? "" : $this->input->get("poliza"));
			$data["estatus"] 		= ($this->input->get("estatus") 	== null ? "" : $this->input->get("estatus"));
			$data["vendedor"]		= ($this->input->get("vendedor") 	== null ? "" : $this->input->get("vendedor"));
			$data["grupo"] 			= ($this->input->get("grupo") 		== null ? "" : $this->input->get("grupo"));
			$data["subgrupo"] 		= ($this->input->get("subgrupo") 	== null ? "" : $this->input->get("subgrupo"));
			$data["consultar"] 		= ($this->input->get("consultar") == null ? "":$this->input->get("consultar"));
			
				
			// $vigencia = "";
			// if($data["habilitarf"] != ""){
			// 	if(!empty($data["fechaini"]) && !empty($data["fechafin"])){
			// 		$vigencia = $data["fechaini"] . "|" . $data["fechafin"];
			// 	}	
			// }
			
			// $data_report = array(
			// 'page'=> $data["page"], 
			// 'TypeReporte'=>$skey,
			// 'IdVend' => $this->tank_auth->get_IDVend(),
			// 'Month' => $month,
			// 'FilterEnable' => $disabled,
			// 'filter' => array(
			// 	'name_client' => $data["cliente"],
			// 	'branch' => $data["ramo"],
			// 	'sub_branch'=>$data['subramo'],
			// 	'insurance' => $data['aseguradora'],
			// 	'status' => $data['estatus'],
			// 	'vigencia' => $vigencia,
			// 	'policy' => $data["poliza"],
			// 	'salesman' => $data["vendedor"],
			// 	'group' => $data["grupo"] ,
			// 	'sub_group' => $data["subgrupo"] ,
			// ));

			// var_dump($data["data_report"]);

			if($skey == 'cli')
			{
				//  $data_client = $this->webservice_sicas_soap->GetReport($data_report);
				//  $tb_client = array();
				//  foreach ($data_client['reporte'] as $value) {
				//  	$item = array(
				//  		'IDCli' => $value->IDCli, 
				//  		'Nombre' => $value->NombreCompleto,
				//  		'RFC'=> $value->RFC,
				//  		'Telefono1' =>$value->Telefono1,
				//  		'Direccion' => $this->getValue($value->Calle).' '.$this->getValue($value->NOExt).' '.$this->getValue($value->NOInt).' '.$this->getValue($value->Colonia));

				//  		array_push($tb_client, $item);
				//  }

				//  echo json_encode($tb_client);
				$this->load->view('reportes/reportecliente', $data);
			}else{
				// $date = new DateTime();
				// echo $date->format('Y-m-d H:i:s');
				// $data["data_report"] = $this->webservice_sicas_soap->GetReport($data_report);

				
				// foreach ($data["data_report"]["reporte"] as $value) {
				// 	$this->webservice_sicas_soap->GetPolicy_forID_Docto($value->IDDocto);

				// }
				// $date = new DateTime();
				// echo $date->format('Y-m-d H:i:s');
				$this->load->view('reportes/reporte', $data);
			}
		}		
	}

	function getPolicyforIDCli2($IDCli,$tipoReporte){
		$tb_policy = array();

		if ($IDCli != null) {
			$sPage = 1;
			$data_policy = array('idCli' => $IDCli, 'page' => $sPage);
			$result;
			$data_result = $this->webservice_sicas_soap->GetPolicy_forClient($data_policy);

			if ($data_result != null) {
				
				foreach ($data_result->TableInfo as $value) {

					$tmpDocto = $this->object_to_array($value);

					$tmpDocto['IDUserLocal'] = $this->tank_auth->get_user_id();
					$tmpDocto['TipoReporte'] = $tipoReporte;
					array_push($tb_policy, $tmpDocto);
				}
			} 
		}

		return $tb_policy;
	}

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
	 		$colsPolicy[] = 'VCatSRamo.IDSRamo';
	 		$colsPolicy[] = 'VCatAgentes.AgenteNombre';
	 		$colsPolicy[] = 'FPago';
	 		$colsPolicy[] = 'VDatDocumentos.SubGrupo';
	 		$colsPolicy[] = 'VDatDocumentos.PrimaNeta';
	 		$colsPolicy[] = 'VDatDocumentos.PrimaTotal';


 			$seardd = json_decode($this->input->post("search_d",TRUE));
 			$sExtraFilter = "";
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
	 				$data_report['ExtraFilter'] = $sExtraFilter;
	 			}
 			}

			$data_policy = array('idCli' => $_REQUEST["IDCli"],'page'=>$sPage);
			if($posCol > 0)
	 			$data_policy['Sort'] = $colsPolicy[$posCol].' '.$colDir;

	 		$data_policy['ItemForPage'] = 10;
	 		

			$data_result = $this->webservice_sicas_soap->GetPolicy_forClient($data_policy);
			if($data_result != null){


				$tb_policy = array();
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

		$Doc = $_GET['Documento'];
		$Tipo = $_GET['Consultar'];

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
}

/* End of file inicio.php */
/* Location: ./application/controllers/inicio.php */