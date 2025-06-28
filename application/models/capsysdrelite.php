<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CapsysDre
 *
 */
class capsysdreLite extends CI_Model{

	function __construct(){
		parent::__construct();
		$ci =& get_instance();
	}
/**
 * Funciones de Generales
 *
**/	
	public function nombreTypeUser($idTypeUser){
		$sqlConsulta_TypeUser = "
			Select * From
				`user_types`
			Where
				`idUserTypes` = '".$idTypeUser."'
								";
		$query = $this->db->query($sqlConsulta_TypeUser);

		if($query->num_rows > 0){
			$result = $query->result();
			return
				strtoupper($result[0]->nombreTitulo);
		} else {
			return
				false;
		}
	}

	public function mesTextoEsp($mesNumero){
		$mesTituloEsp[1] = 'Enero';
		$mesTituloEsp[2] = 'Febrero';
		$mesTituloEsp[3] = 'Marzo';
		$mesTituloEsp[4] = 'Abril';
		$mesTituloEsp[5] = 'Mayo';
		$mesTituloEsp[6] = 'Junio';
		$mesTituloEsp[7] = 'Julio';
		$mesTituloEsp[8] = 'Agosto';
		$mesTituloEsp[9] = 'Septiembre';
		$mesTituloEsp[10] = 'Octubre';
		$mesTituloEsp[11] = 'Noviembre';
		$mesTituloEsp[12] = 'Diciembre';
		
		return
			$return = strtoupper($mesTituloEsp[$mesNumero]);
	}

	function Get_Siniestros(){

        $usermail		= $this->tank_auth->get_usermail();

		$profile = $this->capsysdre->ProfilexEmail($usermail);

		if($profile>'3') //solo operativos
		{
			 $sqlActividadesActualizar = "
              select `clientes`.`fechaCreacion` as FechaAlta,`catalog_office`.`nombreTitulo` as Oficina,`catalog_branch`.`nombreTitulo` as Sucursal,
            `catalog_canales`.`nombreTitulo` as Canal,`crm`.`tipoCrm`,`catalog_estatus-siniestros`.`tipoTramite_txt` as TipoTramite,
            `catalog_estatus-siniestros`.`nombreTitulo` as EstadoSiniestro,`catalog_estatus-siniestros`.`orden` as orden,
				`clientes`.`nombreCompleto` as NombreCompleto,`clientes`.`email`,
            `clientes`.`telefono`,`catalog_referencias`.`nombreTitulo` as referencia,`users`.`name_complete` as Usuario
			from `clientes` 
			left Join `crm` On `clientes`.`idCliente` = `crm`.`idCliente`
			left Join `users` On `users`.`id` = `crm`.`idUser`
			left Join `catalog_office` On `catalog_office`.`idDespacho` = `crm`.`office`
			left Join `catalog_branch` On `catalog_branch`.`idSucursal` = `crm`.`branch`
			left Join `catalog_canales` On `catalog_canales`.`idCanal` = `crm`.`canal`
			left Join `catalog_estatus-siniestros` On `catalog_estatus-siniestros`.`IdEstatusSiniestro` = `crm`.`siniestros-estatus`
			left Join `catalog_referencias` On `catalog_referencias`.`IdReferencia` = `crm`.`referencia`
				Where
                    `eliminado` = '0'
                    And
                    `crm`.`tipoProspecto` = 'SINIESTRO'
                    And
                    `clientes`.`estatusPerfil` = 'PROSPECTO'
                    
			order by `clientes`.`fechaCreacion` desc

									";


		}
		else
		{

			$idvend = $this->capsysdre->IDxEmail($usermail);

		    $sqlActividadesActualizar = "
              select `clientes`.`fechaCreacion` as FechaAlta,`catalog_office`.`nombreTitulo` as Oficina,`catalog_branch`.`nombreTitulo` as Sucursal,
            `catalog_canales`.`nombreTitulo` as Canal,`crm`.`tipoCrm`,`catalog_estatus-siniestros`.`tipoTramite_txt` as TipoTramite,
            `catalog_estatus-siniestros`.`nombreTitulo` as EstadoSiniestro,`catalog_estatus-siniestros`.`orden` as orden,
				`clientes`.`nombreCompleto` as NombreCompleto,`clientes`.`email`,
            `clientes`.`telefono`,`catalog_referencias`.`nombreTitulo` as referencia,`users`.`name_complete` as Usuario
			from `clientes` 
			left Join `crm` On `clientes`.`idCliente` = `crm`.`idCliente`
			left Join `users` On `users`.`id` = `crm`.`idUser`
			left Join `catalog_office` On `catalog_office`.`idDespacho` = `crm`.`office`
			left Join `catalog_branch` On `catalog_branch`.`idSucursal` = `crm`.`branch`
			left Join `catalog_canales` On `catalog_canales`.`idCanal` = `crm`.`canal`
			left Join `catalog_estatus-siniestros` On `catalog_estatus-siniestros`.`IdEstatusSiniestro` = `crm`.`siniestros-estatus`
			left Join `catalog_referencias` On `catalog_referencias`.`IdReferencia` = `crm`.`referencia`
			Where
                    `eliminado` = '0'
                    And
                    `crm`.`tipoProspecto` = 'SINIESTRO'
                    And
                    `clientes`.`estatusPerfil` = 'PROSPECTO'
                      And
                    `crm`.`siniestros-agente`='".$idvend."'

			order by `clientes`.`fechaCreacion` desc
		

									";
		}	


        $this->db2 = $this->load->database('dbLite', TRUE); //Instancion otra base de Datos
		$query = $this->db2->query($sqlActividadesActualizar); 
			
         
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return false;
		}
		
	}/* Trae Siniestros*/

	public function get_Office($idOffice){
		if(isset($idOffice) && ($idOffice != "" || $idOffice != 0)){
			$sqlConsulta_Office = "
				Select * From
					`catalog_office`
				Where
					`idDespacho` = '".$idOffice."';
								  ";

			$query = $this->db->query($sqlConsulta_Office);
			if($query->num_rows() > 0){
					$result = $query->result_array();
				return
					$result['0']['nombreTitulo'];
			}
		}
	}

	public function get_Branch($idBranch){
		if(isset($idBranch) && ($idBranch != "" || $idBranch != 0)){
			$sqlConsulta_Branch = "
				Select * From
					`catalog_branch`
				Where
					`idSucursal` = '".$idBranch."';
								  ";
			 $db=$this->load->database('dbLite', TRUE);
			$query_Branch = $this->db->query($sqlConsulta_Branch);
			if($query_Branch->num_rows() > 0){
					$result_Branch = $query_Branch->result_array();
				return
					$result_Branch['0']['nombreTitulo'];
			}
		}
	}

	public function get_UserName($idUser){

		if(isset($idUser) && ($idUser != "" || $idUser != 0)){
			$sqlConsulta_UserName = "
				Select `name_complete` From
					`users`
				Where
					`id` = '".$idUser."';
								  ";
			$query_UserName = $this->db->query($sqlConsulta_UserName);
			if($query_UserName->num_rows() > 0){
					$result_UserName = $query_UserName->result_array();
				return
					$result_UserName['0']['name_complete'];
			}
		}
	}

	public function get_nameReference($IdReferencia){

		if(isset($IdReferencia) && ($IdReferencia != "" || $IdReferencia != 0)){
			$sqlConsulta_nameReference = "
				Select `nombreTitulo` From
					`catalog_referencias`
				Where
					`IdReferencia` = '".$IdReferencia."';
								  ";
			$query_nameReference = $this->db->query($sqlConsulta_nameReference);
			if($query_nameReference->num_rows() > 0){
					$result_nameReference = $query_nameReference->result_array();
				return
					$result_nameReference['0']['nombreTitulo'];
			}
		}
	}

	public function get_nameProcessType($idTipoTramite){

		if(isset($idTipoTramite) && ($idTipoTramite != "" || $idTipoTramite != 0)){
			$sqlConsulta_ProcessType = "
				Select `nombreTitulo` From
					`catalog_tipotramite-siniestros`
				Where
					`idTipoTramite` = '".$idTipoTramite."';
								  ";
			$query_ProcessType = $this->db->query($sqlConsulta_ProcessType);
			if($query_ProcessType->num_rows() > 0){
					$result_ProcessType = $query_ProcessType->result_array();
				return
					$result_ProcessType['0']['nombreTitulo'];
			}
		}
	}

	public function get_nameStateProspectus($IdEstatusProspecto){

		if(isset($IdEstatusProspecto) && ($IdEstatusProspecto != "" || $IdEstatusProspecto != 0)){
			$sqlConsulta_StateProspectus = "
				Select `nombreTitulo` From
					`catalog_estatus-prospecto`
				Where
					`IdEstatusProspecto` = '".$IdEstatusProspecto."';
								  ";
			$query_StateProspectus = $this->db->query($sqlConsulta_StateProspectus);
			if($query_StateProspectus->num_rows() > 0){
					$result_StateProspectus = $query_StateProspectus->result_array();
				return
					$result_StateProspectus['0']['nombreTitulo'];
			}
		}
	}

	public function get_nameCompani($idCompani){
		if(isset($idCompani) && ($idCompani != "" || $idCompani != 0)){
			$sqlConsulta_companies = "
				Select * From
					`catalog_companies`
				Where
					`IdCompani` = '".$idCompani."';
								  ";
			$query = $this->db->query($sqlConsulta_companies);
			if($query->num_rows() > 0){
					$result = $query->result_array();
				return
					$result['0']['nombreTitulo'];
			}
		}
	}

	public function get_nameRamo($idRamo){
		if(isset($idRamo) && ($idRamo != "" || $idRamo != 0)){
			$sqlConsulta_Ramo = "
				Select * From
					`catalog_ramos`
				Where
					`IdRamo` = '".$idRamo."';
								  ";
			$query = $this->db->query($sqlConsulta_Ramo);
			if($query->num_rows() > 0){
					$result = $query->result_array();
				return
					$result['0']['nombreTitulo'];
			}
		}
	}

	public function get_nameSubRamo($idRamo){
		if(isset($idRamo) && ($idRamo != "" || $idRamo != 0)){
			$sqlConsulta_Ramo = "
				Select * From
					`catalog_ramos`
				Where
					`IdRamo` = '".$idRamo."';
								  ";
			$query = $this->db->query($sqlConsulta_Ramo);
			if($query->num_rows() > 0){
					$result = $query->result_array();
				return
					$result['0']['nombreTitulo'];
			}
		}
	}		

	public function get_nameSRamo($idSubRamo){
		if(isset($idSubRamo) && ($idSubRamo != "" || $idSubRamo != 0)){
			$sqlConsulta_SRamo = "
				Select * From
					`catalog_subramos`
				Where
					`IdSubRamo` = '".$idSubRamo."';
								  ";
			$query = $this->db->query($sqlConsulta_SRamo);
			if($query->num_rows() > 0){
					$result = $query->result_array();
				return
					$result['0']['nombreTitulo'];
			}
		}
	}

	public function get_nameCanal($IdCanal){
		if(isset($IdCanal) && ($IdCanal != "" || $IdCanal != 0)){
			$sqlConsulta_Canal = "
				Select * From
					`catalog_canales`
				Where
					`IdCanal` = '".$IdCanal."';
								  ";
			$query = $this->db->query($sqlConsulta_Canal);
			if($query->num_rows() > 0){
					$result = $query->result_array();
				return
					$result['0']['nombreTitulo'];
			}
		}
	}

	public function get_Companies($idUser = 0){
		try{
			if($idUser != 0){
				$where = "
					(`idUser` = '".$idUser."' Or `idUser` = '0')
						 ";
			} else {
				$where = "1";
			}

			$sqlConsulta_Companies	= "
				Select
					`IdCompani`, `nombreTitulo`
				From
					`catalog_companies`
				Where
					".$where."
				Order By
					`nombre` Asc
									 ";
			$query_Companies		= $this->db->query($sqlConsulta_Companies);
			if($query_Companies->num_rows() > 0){
				return
					$query_Companies->result_array();
			} else {
				return
					false;
			}
		}catch(Exception $e){

		}
	}/*! get_Companies */

	public function get_Ramos(){
		try{
			$sqlConsulta_Ramos	= "
			Select
				`IdRamo`, `nombreTitulo` 
			From
				`catalog_ramos`
			Where
				`activo` = '0'
			Order By
				`orden` Asc
							 ";
			$query_Ramos		= $this->db->query($sqlConsulta_Ramos);
			if($query_Ramos->num_rows() > 0){
				return
					$query_Ramos->result_array();
			} else {
				return
					false;
			}
		}catch(Exception $e){

		}
	}/*! get_Ramos */

	public function get_SubRamos($idRamo){
		try{
			if($idRamo!= "" && $idRamo != false){
				$sqlConsulta_SubRamos	= "
					Select
						`IdSubRamo`, `IdRamo`, `nombre`, `nombreRamo`, `nombreTitulo`
					From
						`catalog_subramos`
					Where
						(
						`nombreRamo` Like '%".$idRamo."%'
						Or
						`IdRamo` Like '%".$idRamo."%'
						)
						And
						`activo` = '0'
					Order By
						`orden` Asc
										  ";
				$query_SubRamos			= $this->db->query($sqlConsulta_SubRamos);
				if($query_SubRamos->num_rows() > 0){
					return
						$query_SubRamos->result_array();
				}else{
					return
						false;
				}
			}
		}catch(Exception $e){

		}
	}/*! get_SubRamos */

	public function get_TipoDocumento(){
		try{
			$sqlConsulta_TipoDocumento	= "
				Select
					`IdTipoDocumento`, `nombreTitulo`
				From
					`catalog_tipodocumento`
				Where
					`activo` = '0'
				Order By
					`orden` Asc
										  ";
			$query_TipoDocumento		= $this->db->query($sqlConsulta_TipoDocumento);
			if($query_TipoDocumento->num_rows() > 0){
				return
					$query_TipoDocumento->result_array();
			} else {
				return
					false;
			}
		}catch(Exception $e){

		}
	}/*! get_TipoDocumento */

	public function get_NivelEstudios(){
		try{
			$sqlConsulta_NivelEstudios	= "
				Select
					`idNivelEstudios`, `nombreTitulo`
				From
					`catalog_nivel-estudios`
				Where
					`activo` = '0'
				Order By
					`orden` Asc
										  ";
			$query_NivelEstudios		= $this->db->query($sqlConsulta_NivelEstudios);
			if($query_NivelEstudios->num_rows() > 0){
				return
					$query_NivelEstudios->result_array();
			} else {
				return
					false;
			}
		}catch(Exception $e){

		}
	}/*! get_NivelEstudios */

	public function get_Recordar($fechaInicio = 0, $intervalo = 0){
		
		return
			date('Y-m-d',strtotime('+1 week',strtotime(date('Y-m-j'))));
	}/*! get_Recordar */

	public function get_Negocios($idCanal = 0, $userType = 0){
		try{
			            
  
			if($userType != 0 && $userType == 9){
				$where = "1";
			} else {
				if($idCanal != 0){
					$where = "`idCanal` = '".$idCanal."'";
				}
			}

			$sqlConsulta_Canales	= "
				Select
					`IdCanal`, `nombreTitulo`
				From
					`catalog_canales`
				Where
					".$where."
				Order By
					`nombre` Asc
									 ";

									


			$query_Canales		= $this->db->query($sqlConsulta_Canales);
			if($query_Canales->num_rows() > 0){
				return
					$query_Canales->result_array();
			} else {
				return
					false;
			}
		}catch(Exception $e){

		}
	}/*! get_Negocios */

	public function get_Referencias($idUser = 0, $tipoProspecto = 'CLIENTE'){
		try{
			if($idUser != 0){
				$where = "
					(`idUser` = '".$idUser."' Or `idUser` = '0')
					And
					`tipoProspecto` = '".$tipoProspecto."'
						 ";
			} else {
				$where = "
					`tipoProspecto` = '".$tipoProspecto."'
						 ";
			}
			$sqlConsulta_Referencias	= "
				Select
					`IdReferencia`, `nombreTitulo`
				From
					`catalog_referencias`
				Where
					".$where."
				Order By
					`nombre` Asc
									 	 ";
			$query_Referencias		= $this->db->query($sqlConsulta_Referencias);

			if($query_Referencias->num_rows() > 0){
				return
					$query_Referencias->result_array();
			} else {
				return
					false;
			}
		}catch(Exception $e){

		}
	}/*! get_Referencias */

	public function get_Ckeditor($id,$toolbar){
		
		return
			array(
					'id'		=> $id,
					'path'		=> 'assets/plugins/ckeditor',
					'config'	=> array(	
											//'extraPlugins' 			=> 'filebrowser',
											//'filebrowserBrowseUrl'	=> base_url().'documents/ckeditor/',
											'filebrowserUploadUrl'	=> base_url().'correo/uploadCkeditor/',
											'width'					=> 'auto',		
											'height'				=> '100px',
//											'toolbarGroups' => '[]',
//											'removeButtons' => 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar',
											'toolbar'	=> $toolbar,
										)

										
				);
	}/*! get_Ckeditor */

//** **/
	public function get_TipoTramite($Ramo, $subRamo){
		try{
			$sqlConsulta_TipoTramite = "
				Select
					`idTipoTramite`, `nombreTitulo`
				From
					`catalog_tipotramite-siniestros`
				Where
					`activo` = '0'
					And 
					`Ramo` = '".$Ramo."'
					And
					`subRamo` = '".$subRamo."'
				Order By
					`orden` Asc
									   ";
			$query_TipoTramite		= $this->db->query($sqlConsulta_TipoTramite);
			if($query_TipoTramite->num_rows() > 0){
				return
					$query_TipoTramite->result_array();
			} else {
				return
					false;
			}
		}catch(Exception $e){

		}
	}/*! get_TipoTramite */
	
	public function get_EstatusSiniestro($idTipoTramite){
		try{
			$sqlConsulta_EstatusSiniestro	= "
				Select
					`IdEstatusSiniestro`, `nombreTitulo`
				From
					`catalog_estatus-siniestros`
				Where
					`activo` = '0'
					And
					`tipoTramite` = '".$idTipoTramite."'
				Order By
					`orden` Asc
											  ";
			$query_EstatusSiniestro			= $this->db->query($sqlConsulta_EstatusSiniestro);
			if($query_EstatusSiniestro->num_rows() > 0){
				return
					$query_EstatusSiniestro->result_array();
			} else {
				return
					false;
			}
		}catch(Exception $e){

		}
	}/*! get_EstatusSiniestro */
	
	public function get_EstadoProspecto($tipoProspecto){
		try{
			$sqlConsulta_EstadoProspecto	= "
				Select
					`IdEstatusProspecto`, `nombreTitulo`
				From
					`catalog_estatus-prospecto`
				Where
					`activo` = '0'
					And
					`tipoProspecto` = '".$tipoProspecto."'
				Order By
					`orden` Asc
											  ";
			$query_EstadoProspecto			= $this->db->query($sqlConsulta_EstadoProspecto);
			if($query_EstadoProspecto->num_rows() > 0){
				return
					$query_EstadoProspecto->result_array();
			} else {
				return
					false;
			}
		}catch(Exception $e){

		}
	}/*! get_EstadoProspecto */
	
	public function get_Agente(){
		try{
			$sqlConsulta_Agente = "
				Select
					`IdAgente`, `nombreTitulo`
				From
					`catalog_agentes`
				Where
					`activo` = '0'
				Order By
					`orden` Asc
									   ";
			$query_Agente		= $this->db->query($sqlConsulta_Agente);
			if($query_Agente->num_rows() > 0){
				return
					$query_Agente->result_array();
			} else {
				return
					false;
			}
		}catch(Exception $e){

		}
	}/*! get_Agente */
	
	public function get_RankingAgente(){
		try{
			$sqlConsulta_RankingAgente	= "
				Select
					`IdRanking`, `nombreTitulo`
				From
					`catalog_ranking-agentes`
				Where
					`activo` = '0'
				Order By
					`orden` Asc
									   ";
			$query_RankingAgente		= $this->db->query($sqlConsulta_RankingAgente);
			if($query_RankingAgente->num_rows() > 0){
				return
					$query_RankingAgente->result_array();
			} else {
				return
					false;
			}
		}catch(Exception $e){

		}
	}/*! get_RankingAgente */
	
	public function get_nameTipoTramite($idTipoTramite){
		try{
			$sqlConsulta	= "
			Select
				`idTipoTramite`, `nombreTitulo` 
			From
				`catalog_tipotramite-siniestros`
			Where
				`activo` = '0'
			Order By
				`orden` Asc
							 ";
			$query		= $this->db->query($sqlConsulta);
			if($query->num_rows() > 0){
				return
					$query->result_array();
			} else {
				return
					false;
			}
		}catch(Exception $e){

		}
	
	} /*! get_nameTipoTramite */
	
	public function get_nameEstatusSiniestro($IdEstatusSiniestro){
		$denominador="";

		if(isset($IdEstatusSiniestro) && ($IdEstatusSiniestro != "" || $IdEstatusSiniestro != 0)){
			$sqlConsulta = "
				Select * From
					`catalog_estatus-siniestros`
				Where
					`IdEstatusSiniestro` = '".$IdEstatusSiniestro."';
								  ";
			$query = $this->db->query($sqlConsulta);
			if($query->num_rows() > 0 ){
					$result = $query->result_array();

			if($result['0']['tipoTramite_txt']=="AUTOS ASISTENCIA VIAL")	//1
			   $denominador="3";
			if($result['0']['tipoTramite_txt']=="AUTOS PAGO DE DAÑOS")	//2
			   $denominador="5";
			if($result['0']['tipoTramite_txt']=="AUTOS PAGO DE TERCEROS")	//3
			   $denominador="5";
			if($result['0']['tipoTramite_txt']=="AUTOS PERDIDA TOTAL")	//4
			   $denominador="5";
			if($result['0']['tipoTramite_txt']=="AUTOS REPARACION")	//5
			   $denominador="7";
			if($result['0']['tipoTramite_txt']=="AUTOS ROBO TOTAL")	//6
			   $denominador="5";
			if($result['0']['tipoTramite_txt']=="GMM PRIMER RECLAMACION REEMBOLSO")	//7
			   $denominador="6";
			if($result['0']['tipoTramite_txt']=="GMM REEMBOLSO SUBSECUENTE")	//8
			   $denominador="6";
			if($result['0']['tipoTramite_txt']=="GMM PROGRAMACION DE CIRUGIA")	//9
			   $denominador="6";
			if($result['0']['tipoTramite_txt']=="GMM PAGO DIRECTO")	//10
			   $denominador="3";
			if($result['0']['tipoTramite_txt']=="DAÑOS EMPRESARIAL REEMBOLSO")	//11
			   $denominador="5";
			if($result['0']['tipoTramite_txt']=="DAÑOS EMPRESARIAL REPARACION")	//12
			   $denominador="7";
			if($result['0']['tipoTramite_txt']=="DAÑOS EMPRESARIAL ROBO")	//13
			   $denominador="5";
			if($result['0']['tipoTramite_txt']=="DAÑOS CASA HABITACION REEMBOLSO")	//14
			   $denominador="5";
			if($result['0']['tipoTramite_txt']=="DAÑOS CASA HABITACION REPARACION")	//15
			   $denominador="7";


				return  
					$result['0']['nombreTitulo']." ".$result['0']['orden']."/".$denominador;

						

			}
		}
	} /*! get_nameEstatusSiniestro */
	
	public function get_nameAgente(){
	}
	
	public function get_nameRankingAgente(){
	}
	
	public function get_documentosCrm($idCrm){

		try{
			$sqlConsulta	= "
				Select
					`tipoDocumento`,`descripcionAdjunto`,`nombreAdjunto`,`urlAdjunto`
				From
					`adjuntos`
				Where
					`idCrm` = '".$idCrm."'
				Order By
					`tipoDocumento` Asc
									   ";
			$query			= $this->db->query($sqlConsulta);
			if($query->num_rows() > 0){
				return
					$query->result_array();
			} else {
				return
					false;
			}
		}catch(Exception $e){

		}
	
	}/*! get_documentosCrm */

//**
	public function get_adjuntos($idCrm = 0, $idCliente = 0, $tipoBusqueda = 0){
		try{
			if($tipoBusqueda == "Crm"){
				$where	= "
					`idCrm` = '".$idCrm."'
						  ";
			} else if($tipoBusqueda == "Cliente"){
				$where	= "
					`idCliente` = '".$idCrm."'
						  ";
			}
			$sqlConsulta_Adjuntos	= "
				Select
					`tipoDocumento`, `descripcionAdjunto`, `urlAdjunto`
				From
					`adjuntos`
				Where
					".$where."
				Order By
					`idAdjunto` Desc
									  ";
			$query_Adjuntos			= $this->db->query($sqlConsulta_Adjuntos);
			if($query_Adjuntos->num_rows() > 0){
				return
					$query_Adjuntos->result_array();
			}else{
				return
					false;
			}
		}catch(Exception $e){

		}
	}/*! get_adjuntos */
	
	/* No Aun
	public	function GetCDDigital($data){
		$page = 1; 
		$itemforPage = 25;
		$role = "";
		$VendedorID = 0;
		$customConditionsAdd = "";
		$result = "";
		$busquedaCliente = "";
		
		if(is_array($data)){
			
			$IDDocto 	= $data["IDDocto"];
			
			$data_body = array(
				"Page" => 1,
				"ItemForPage" => "",
				"ConditionsAdd" => "",
				"InfoSort"=>"",
				"KeyCode"=>"",
				"KeyProcess"=> "CDIGITAL",
				"TypeDestinoCDigital"=> "DOCUMENT",
				"IDValuePK"=> $IDDocto,
				"ActionCDigital"=> "GETFiles"
			);	

			$result = $this->ObtenerDatos($data_body);
			if(isset($result)){
				$result_c = array();
				if($result->Datos != ""){

					$Level = 0;
					// foreach ($result->Datos as $value) {
						// if($value->Tipo == 0)
						// {
							// $result_c[$value->Level] = array(
						        // "isFolder"=> true,
						        // "text"=> $value->NameShow,
								// );
						// }else{
							
						// }
						// $Level = $value->Leve;
					// }
					foreach ($result->Datos as $value) {										
						array_push($result_c,$value);
					}
					$test = $this->CrearArbol($result_c,0);
				}
				// return $result_c;			
				return $test;
			}else{
				return array('text'=> 'No cuenta con documentos');
			}
		}
	}
	private	function CrearArbol($Arbol, $Nodo = 0){
				
		$isFolder 	= false;
		$text		= "";
		$level		= "";
		$href		= "";
		$hreftarget	= "";
		$level_int 		= 0;		
		foreach ($Arbol as $key => $value) {
						
			if((string)$value->Level == 0){
				
				unset($Arbol[$key]);
				
				if($value->Tipo == 0){
					
					$isFolder = true;
					$text = (string)$value->NameShow;
					$level = (string)$value->Level;
												
				}else{
					
					$isFolder = false;
					$text = (string)$value->NameShow;
					$href = (string)$value->PathWWW;
					$hrefTarget = "_blank";
					$level = (string)$value->Level;
									
				}
			
					$recursive = $this->Hijos($Arbol);
						
					$return["isFolder"] = $isFolder;
					$return["text"] = $text;
					if(!empty($href))
						$return["href"] = $href;
					if(!empty($hrefTarget))
						$return["hrefTarget"] = $hrefTarget;
					if(!empty($level))
						$return["level"] = $level;

					if($recursive != NULL)
						$return["children"] = $recursive;
					
			}
		}
		
		return empty($return) ? null : $return;   
	}
	private	function Hijos($Arbol){
		$isFolder 	= false;
		$text		= "";
		$level		= "";
		$href		= "";
		$hreftarget	= "";
		$level = 0;	

		$hijos = array();
		
		foreach ($Arbol as $key => $value) {
			
			unset($Arbol[$key]);
				
			if($value->Tipo == 0){
				
				// $isFolder = true;
				// $text = (string)$value->NameShow;
				// $level = (string)$value->Level;
				$return  = 
				array("isFolder" => true,
					  "text" => (string)$value->NameShow,
					  "level" => (string)$value->Level	
				);
											
			}else{
				
				$return  = 
				array("isFolder" => false,
					  "text" => (string)$value->NameShow,
					  "href" => (string)$value->PathWWW,
					  "hrefTarget" => "_blank",
					  "level" => (string)$value->Level	
				);
				
				// $isFolder = false;
				// $text = (string)$value->NameShow;
				// $href = (string)$value->PathWWW;
				// $hrefTarget = "_blank";
				// $level = (string)$value->Level;
								
			}
			
			// $hijos[] = array(
				// "isFolder" => $isFolder,
				// "text" => $text
			// );
			// $return["isFolder"] = $isFolder;
			// $return["text"] = $text;
			// if(!empty($href))
				// $return["href"] = $href;
			// if(!empty($hrefTarget))
				// $return["hrefTarget"] = $hrefTarget;
			// if(!empty($level))
				// $return["level"] = $level;			
			
			array_push($hijos,$return);
		}
		
		return empty($hijos) ? null : $hijos; 
	}
	No Aun */
	
	public function get_busquedaProspecto($buscando,$registroUsers){
		$sqlConsulta_busquedaCliente = "
			Select * From
				`clientes`
			Where
				`nombreCompleto` Like '%".$buscando."%'
				And
				`estatusPerfil` = 'CLIENTE'
									   ";
		$query_buscandoCliente = $this->db->query($sqlConsulta_busquedaCliente);
		if($query_buscandoCliente->num_rows() > 0){
			return
				$query_buscandoCliente->result();
		} else {
			return
				false;
		}
	}/*! get_busquedaProspecto */
	
	public function get_busquedaCliente($buscando,$registroUsers){
		$sqlConsulta_busquedaCliente = "
			Select * From
				`clientes`
			Where
				`nombreCompleto` Like '%".$buscando."%'
				And
				`estatusPerfil` = 'CLIENTE'
									   ";
		$query_buscandoCliente = $this->db->query($sqlConsulta_busquedaCliente);
		if($query_buscandoCliente->num_rows() > 0){
			return
				$query_buscandoCliente->result();
		} else {
			return
				false;
		}
	}/*! get_busquedaCliente */
	
	public function get_datosCliente($idCliente){
		$sqlConsulta_cliente = "
			Select * From
				`clientes`
			Where
				`idCliente` = '".$idCliente."';
							   ";
		$query_cliente = $this->db->query($sqlConsulta_cliente);
		if($query_cliente->num_rows() > 0){
			return
				$query_cliente->result();
		} else {
			return
				false;
		}
	}/*! get_datosCliente */
	
	public function get_datosCrm($idCrm){
		$sqlConsulta_crm = "
			Select
				*, 
				`siniestros-tipoTramite`		As `siniestrosTipoTramite`,
				`siniestros-estatus`			As `siniestrosEstatus`,
				`siniestros-numeroSiniestro`	As `siniestrosNumeroSiniestro`,
				`siniestros-fechaIngreso`		As `siniestrosFechaIngreso`,
				`siniestros-agente`				As `siniestrosAgente`,
				`siniestros-rankingAgente`		As `siniestrosRankingAgente`
			From
				`crm`
			Where
				`idCrm` = '".$idCrm."';
							   ";
		$query_crm = $this->db->query($sqlConsulta_crm);
		if($query_crm->num_rows() > 0){
			return
				$query_crm->result();
		} else {
			return
				false;
		}
	}/*! get_datosCrm */
	
/**
 * Funciones de Clientes
 *
 */
	function verListadoClientes($user_type, $idUser, $office, $branch){
		$sqlConsultaClientes = "
			Select * From 
				`clientes`
			Where
							   ";

		switch($user_type){
			case 1: //--> agente
				$sqlConsultaClientes.= "
					`idUser` = '".$idUser."'
									   ";
			break;
			
			case 2: //--> capturista
				$sqlConsultaClientes.= "
					`office` = '".$office."'
					And
					`branch` = '".$branch."'
									   ";
			break;
			
			case 3: //--> supervisor
				$sqlConsultaClientes.= "
					`branch` = '".$branch."'
									   ";
			break;
			
			case 4: //--> despacho
				$sqlConsultaClientes.= "
					`office` = '".$office."'
									   ";
			break;
			
			case 9: //--> master
				$sqlConsultaClientes.= "
					1
									   ";
			break;
		}

		$query = $this->db->query($sqlConsultaClientes);
		
		if($query->num_rows() > 0){
			return
				$query;
		} else {
			return
				FALSE;
		}
	}

	function listaAjax_old($tabla, $columnas){
		$data['user_type']		= $user_type		= $this->tank_auth->get_user_type();
		$data['idUser']			= $idUser			= $this->tank_auth->get_user_id();
		$data['office']			= $office			= $this->tank_auth->get_office();
		$data['branch']			= $branch			= $this->tank_auth->get_branch();
		$data['registroUsers']	= $registroUsers	= $this->tank_auth->get_registroUsers();
						
		/* Configuracion Listado */
			$tabla		= "clientes";
		 	$columnas = array();					
				$columnas[] = 'clientes.tipoPersona';
				$columnas[] = 'clientes.nombreCompleto';
				$columnas[] = 'clientes.rfc';
				$columnas[] = 'clientes.email';
				$columnas[] = 'clientes.telefono';
				$columnas[] = 'clientes.ramo';
				$columnas[] = 'clientes.aseguradora';
				$columnas[] = 'clientes.ranking';
				$columnas[] = 'clientes.clubCap';
				$columnas[] = 'clientes.polizaVerde';

			/* Calculos Listado - Orden Columnas -*/
		 	$posCol = intval($_POST['order'][0]['column']);
		 	$colDir = $_POST['order'][0]['dir'];

			$orderBy = "";
//		 	if($posCol > 0){
				$orderBy = "Order By ";
		 		$orderBy.= $columnas[$posCol].' '.$colDir;
//			}

			/* Calculos Listado - Elementos Pagina Paginacion -*/
			$sqlListadoTotal = "
				Select 
					Found_Rows()
				From
					$tabla;
							   ";			
			$totalRegistros		= $this->db->query($sqlListadoTotal);
			$inicioRegistros	= intval($_POST['start']);
			$finRegistros		= intval($_POST['length']);
			
			$limit = "";
			if($inicioRegistros > 0){
				$limit = "Limit ";
				$limit.= $inicioRegistros.", ".$finRegistros;
			} else {
				$limit = "Limit ";
				$limit.= "0, ".$finRegistros;
			}
						
			/* Calculos Listado - Busqueda Elementos -*/		
			$searchValue = $_POST['search']['value']; //json_decode();
			$searchRegex = $_POST['search']['regex'];
			$where = "";
			if($searchRegex != ""){
				$where = "
					Where
						1
						 ";
			} else {
				$where = "
					Where
						`nombreCompleto` Like '%Juan Jose%'
						 ";
			}
/*
			$sExtraFilter = "";
			if(is_array($search) || is_object($search)){
				foreach ($search as $key => $row) {
					$pKey = intval($row->id );
		 			$sKess = $colsResp[$pKey ];
		 			if($row->type == "date"){
		 				$sExtraFilter .= $row->val." = '".$row->val."'";
		 			}else{
		 				$sExtraFilter .= $row->val." Like '%".$row->val."%'";	
		 			}
				}
				
				if($sExtraFilter != ""){
					$where = "Where ";
					$where.= $sExtraFilter;
				} else {
					$where = "Where ";
					$where.= "1";
				}
			}
*/
/*
			$where_test = "	
				Where
					1
					 ";
*/

			$sqlListado = "
				Select
					SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $columnas))."
				From 
					$tabla
				$where
				$orderBy
				$limit
								  ";

			$listado = $this->db->query($sqlListado);

			$dataListado = array();
			
			foreach($listado->result() as $elemento){
				$item = new \stdClass;
				$item->tipoPersona			= $this->obtenerValorCadena($elemento->tipoPersona);
				$item->nombreCompleto		= $this->obtenerValorCadena($elemento->nombreCompleto);
				$item->rfc					= $this->obtenerValorCadena($elemento->rfc);
				$item->email				= $this->obtenerValorCadena($elemento->email);
				$item->telefono				= $this->obtenerValorCadena($elemento->telefono);
				$item->ramo					= $this->obtenerValorCadena($elemento->ramo);
				$item->aseguradora			= $this->obtenerValorCadena($elemento->aseguradora);
				$item->ranking				= $this->obtenerValorCadena($elemento->ranking);
				$item->clubCap				= $this->obtenerValorCadena($elemento->clubCap);
				$item->polizaVerde			= $this->obtenerValorCadena($elemento->polizaVerde);

				array_push($dataListado, $item);
			}

			$dataTables = 
			json_encode(array(
				//--> 'sEcho' => '',
				'iTotalRecords'			=> $inicioRegistros, //$totalRegistros->num_rows(),
		 		'iTotalDisplayRecords'	=> $totalRegistros->num_rows(), 
				'aaData'				=> $dataListado
	 		));
			
			echo $dataTables;

		
	}/*! listaAjax */

}

/* End of file capsysdre.php */
/* Location: ./application/models/auth/capsysdre.php */