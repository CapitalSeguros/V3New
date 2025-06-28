<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class actualizaActividades extends CI_Controller{
	/*
		$quitar	= array(
						'<p>','</p>','<br />','<br>','&nbsp;','&acute;','&quot;','&uml;',
						'&Ntilde;','&ntilde;','&iquest;','&iexcl;','&uuml;','&Uuml;',
						'&aacute;','&eacute;','&iacute;','&oacute;','&uacute;',
						'&Aacute;','&Eacute;','&Iacute;','&Oacute;','&Uacute;',
						'&agrave;','&egrave;','&igrave;','&ograve;','&ugrave;',
						'&Agrave;','&Egrave;','&Igrave;','&Ograve;','&Ugrave;',
						'&lt;','&gt;',
						);
		$poner	= array(
						'','','\r\n','\r\n','','','','',
						'Ñ','ñ','¿','¡','u','U',
						'á','é','í','ó','ú',
						'Á','É','Í','Ó','Ú',
						'à','è','ì','ò','ù',
						'À','È','Ì','Ò','Ù',
						'<','>',
						);
	*/
	
	
	private	$quitar	= array(
						'<p>','</p>','<br />','<br>','&nbsp;','&acute;','&quot;','&uml;',
						'&Ntilde;','&ntilde;','&iquest;','&iexcl;','&uuml;','&Uuml;',
						'&aacute;','&eacute;','&iacute;','&oacute;','&uacute;',
						'&Aacute;','&Eacute;','&Iacute;','&Oacute;','&Uacute;',
						'&agrave;','&egrave;','&igrave;','&ograve;','&ugrave;',
						'&Agrave;','&Egrave;','&Igrave;','&Ograve;','&Ugrave;',
						'&lt;','&gt;',
						);
	private	$poner	= array(
						'','','\r\n','\r\n','','','','',
						'Ñ','ñ','¿','¡','u','U',
						'á','é','í','ó','ú',
						'Á','É','Í','Ó','Ú',
						'à','è','ì','ò','ù',
						'À','È','Ì','Ò','Ù',
						'<','>',
						);
	function __construct(){
		parent::__construct();     
		//$this->CI =& get_instance();
		$params['id_sicas'] = $this->tank_auth->get_IDUserSICAS(); "get_IDUserSICAS";
		$params['user_sicas'] = $this->tank_auth->get_UserSICAS(); "get_UserSICAS";
		$params['pass_sicas'] = $this->tank_auth->get_PassSICAS(); "get_PassSICAS";
		$this->load->library('Ws_sicasdre',$params);

		$this->load->helper('ckeditor');
		$this->load->model('capsysdre_actividades');
	}

	function index(){		
		echo "<pre>";
			echo "Selecccione Un Tipo de Actividad";
		echo "</pre>";
	}/*! index */

    function actualizaActividades_Operacion(){
		$todasActividadesActualizar  = $this->actividadesActualizar_Operacion();
		
		echo "<pre>";
		print("TimeStart: ".date('Y-m-d H:i:s'));
			echo "<br />Actualizando Actividades de Operacion<br />";
			echo count($todasActividadesActualizar)."<br />";
			//print_r($todasActividadesActualizar);
			if($todasActividadesActualizar != false){
				$contLine = 0;

				foreach($todasActividadesActualizar as $actividadActualizar){
					$idInterno = $actividadActualizar->idInterno;
					echo "<pre>";
						echo "<b>".$contLine."</b><br />";
						print_r($actividadActualizar);
					echo "</pre>";
	
					//***
					//* Switch Tipo de Actividad Sicas
					//***
					switch($actividadActualizar->tipoActividadSicas){
						case "ot":
							$infoDocumento	= $this->capsysdre_actividades->DetalleDocumento($actividadActualizar->idSicas);
							if($infoDocumento != ""){
								$FechaEntrega	= $infoDocumento[0]->FEntrega;
								$Status			= $infoDocumento[0]->StatusUser;
								$idSicas 		= $infoDocumento[0]->IDDocto;
								$NumSolicitud	= $infoDocumento[0]->NumSolicitud;
								$Documento		= $infoDocumento[0]->Documento;
							} else {
								$FechaEntrega	= "";
								$Status			= "";
								$idSicas 		= "";
								$NumSolicitud	= "";
								$Documento		= "";
							}
						break;
						
						case "tarea":
							$infoDocumento	= $this->capsysdre_actividades->DetalleDocumentoTarea($actividadActualizar->idSicas);
							if($infoDocumento != ""){
								$FechaEntrega	= $infoDocumento[0]->FPromesa;
								$Status			= $infoDocumento[0]->Status;
								$idSicas 		= $infoDocumento[0]->IDTarea;
								$NumSolicitud	= "";
								$Documento		= "";
							} else {
								$FechaEntrega	= "";
								$Status			= "";
								$idSicas 		= "";
								$NumSolicitud	= "";
								$Documento		= "";
							}
						break;
					}//*! Fin de Switch Tipo de Actividad Sicas
					echo "<pre>";
						print_r($infoDocumento);
					echo "</pre>";
					
					//***
					//* Formateo de Fecha Promesa
					//***
					if($FechaEntrega != ""){
						$fechaPromesa = date_format(date_create($FechaEntrega), 'Y-m-d H:i:s');
						$SetFechaPromesa =	"`fechaPromesa`	= '".$fechaPromesa."',";
					} else {
						$fechaPromesa = NULL;
						$SetFechaPromesa =	"";
					}//*! fin If Formateo Fecha Promesa
					
					if($NumSolicitud != ""){
						$SetNumSolicitud =	"`NumSolicitud`	= '".$NumSolicitud."',";
					} else {
						$SetNumSolicitud =	"";
					}
					
					if($Documento != ""){
						$SetDocumento =	"`Documento`	= '".$Documento."',";
					} else {
						$SetDocumento =	"";
					}

					//-->echo "<pre>";
						//-->print("->FechaPromesa:".$fechaPromesa."<br />");
					//-->echo "</pre>";

					//***
					//* Update Actividad Capsys
					//***
					if($idSicas != ""){
						$sql_UpdateActividad = "
							Update
								`actividades`
							Set
								`Status` 		= '".$Status."',
								".$SetFechaPromesa."
								".$SetNumSolicitud."
								".$SetDocumento."
								`fechaSyncro`	= '".date('Y-m-d H:i:s')."'
							Where
								-- `idSicas`		= '".$idSicas."';
								`idInterno`		= '".$idInterno."'
											   ";
						$this->db->query($sql_UpdateActividad);
					} else {
						$sql_UpdateActividad_SicasDelete = "
							Update
								`actividades`
							Set
								`sicasDelete`	= '0',
								`fechaSyncro`	= '".date('Y-m-d H:i:s')."'
							Where
								`idInterno`		= '".$idInterno."'
														   ";
						$this->db->query($sql_UpdateActividad_SicasDelete);
					}
					//*! Fin Update Actividad Capsys
				/*
				*/				
				$contLine++;	
				}//*! fin del foreach $todasActividadesActualizar
		
			} else {
				echo "No Existen Elemento a Actualizar";
			} /*! fin del if si existen elementos en el arreglo $todasActividadesActualizar */
		print("TimeEnd: ".date('Y-m-d H:i:s'));
		echo "<pre>";
	}/*! actualizaActividades_Operacion */
	
    function actualizaActividades_Todas(){
		$todasActividadesActualizar  = $this->actividadesActualizar_Todas();
		
		echo "<pre>";
		print("TimeStart: ".date('Y-m-d H:i:s'));
			echo "<br />Actualizando Actividades de Todas<br />";
			echo count($todasActividadesActualizar)."<br />";
			//print_r($todasActividadesActualizar);
			if($todasActividadesActualizar != false){
				$contLine = 0;
				$idSicas		= "";
				$FechaEntrega	= "";
				$NumSolicitud	= "";
				$Documento		= "";

				foreach($todasActividadesActualizar as $actividadActualizar){
					$idInterno = $actividadActualizar->idInterno;
					echo "<pre>";
						echo "<b>".$contLine."</b><br />";
						print_r($actividadActualizar);
					echo "</pre>";
	
					//***
					//* Switch Tipo de Actividad Sicas
					//***

					switch($actividadActualizar->tipoActividadSicas){
						case "ot":
							$infoDocumento	= $this->capsysdre_actividades->DetalleDocumento($actividadActualizar->idSicas);
							if($infoDocumento != ""){
								$FechaEntrega	= $infoDocumento[0]->FEntrega;
								$Status			= $infoDocumento[0]->StatusUser;
								$idSicas 		= $infoDocumento[0]->IDDocto;
								$NumSolicitud	= $infoDocumento[0]->NumSolicitud;
								$Documento		= $infoDocumento[0]->Documento;
							} else {
								$FechaEntrega	= "";
								$Status			= "";
								$idSicas 		= "";
								$NumSolicitud	= "";
								$Documento		= "";
							}
						break;
						
						case "tarea":
							$infoDocumento	= $this->capsysdre_actividades->DetalleDocumentoTarea($actividadActualizar->idSicas);
							if($infoDocumento != ""){
								$FechaEntrega	= $infoDocumento[0]->FPromesa;
								$Status			= $infoDocumento[0]->Status;
								$idSicas 		= $infoDocumento[0]->IDTarea;
								$NumSolicitud	= "";
								$Documento		= "";
							} else {
								$FechaEntrega	= "";
								$Status			= "";
								$idSicas 		= "";
								$NumSolicitud	= "";
								$Documento		= "";
							}
						break;
					}//*! Fin de Switch Tipo de Actividad Sicas
					sleep(1);
/*
					if($actividadActualizar->tipoActividadSicas == "ot"){
						$infoDocumento	= $this->capsysdre_actividades->DetalleDocumento($actividadActualizar->idSicas);
							if($infoDocumento != ""){
								$FechaEntrega	= $infoDocumento[0]->FEntrega;
								$Status			= $infoDocumento[0]->StatusUser;
								$idSicas 		= $infoDocumento[0]->IDDocto;
								$NumSolicitud	= $infoDocumento[0]->NumSolicitud;
								$Documento		= $infoDocumento[0]->Documento;
							} else {
								$FechaEntrega	= "";
								$Status			= "";
								$idSicas 		= "";
								$NumSolicitud	= "";
								$Documento		= "";
							}
							sleep(1);
					}
*/
				//	echo "<pre>";
					//	print_r($infoDocumento);
				//	echo "</pre>";
					
					//***
					//* Formateo de Fecha Promesa
					//***
					if($FechaEntrega != ""){
						$fechaPromesa = date_format(date_create($FechaEntrega), 'Y-m-d H:i:s');
						$SetFechaPromesa =	"`fechaPromesa`	= '".$fechaPromesa."',";
					} else {
						$fechaPromesa = NULL;
						$SetFechaPromesa =	"";
					}//*! fin If Formateo Fecha Promesa
					
					if($NumSolicitud != ""){
						$SetNumSolicitud =	"`NumSolicitud`	= '".$NumSolicitud."',";
					} else {
						$SetNumSolicitud =	"";
					}
					
					if($Documento != ""){
						$SetDocumento =	"`Documento`	= '".$Documento."',";
					} else {
						$SetDocumento =	"";
					}

					//***
					//* Update Actividad Capsys
					//***
					if($idSicas != ""){
						$sql_UpdateActividad = "
							Update
								`actividades`
							Set
								`Status` 		= '".$Status."',
								".$SetFechaPromesa."
								".$SetNumSolicitud."
								".$SetDocumento."
								`fechaSyncro`	= '".date('Y-m-d H:i:s')."'
							Where
								`idInterno`		= '".$idInterno."'
											   ";
						##$this->db->query($sql_UpdateActividad);
					} else {
						$sql_UpdateActividad = "
							Update
								`actividades`
							Set
								`sicasDelete`	= '0',
								`fechaSyncro`	= '".date('Y-m-d H:i:s')."'
							Where
								`idInterno`		= '".$idInterno."'
											   ";
						##$this->db->query($sql_UpdateActividad_SicasDelete);
					}
					$this->db->query($sql_UpdateActividad);
					//*! Fin Update Actividad Capsys
					echo "<pre>";
						print($sql_UpdateActividad);
					echo "</pre>";
				/*
				*/				
				$contLine++;	
				}//*! fin del foreach $todasActividadesActualizar
		
			} else {
				echo "No Existen Elemento a Actualizar";
			} /*! fin del if si existen elementos en el arreglo $todasActividadesActualizar */
		print("TimeEnd: ".date('Y-m-d H:i:s'));
		echo "<pre>";
	}/*! actualizaActividades_Todas */
	
    function actualizaActividades_UserVend(){
		$sql_ActividadesSinVendedor = "
			Select
				`idInterno`,
				`folioActividad`,
				`idSicas`,
				`NumSolicitud`,
				`Documento`,
				`ClaveBit`,
				`IDBit`,
				`Status`,
				`tipoActividadSicas`,
				`inicio`,
				`fin`,
				`idCliente`,
				`idContacto`,
				`tipoActividad`,
				`usuarioVendedor`
			From
				`actividades`
			Where
				`usuarioVendedor` = ''
				-- Or
				-- `usuarioVendedor` Is Null
									  ";
		$query_ActividadesSinVendedor = $this->db->query($sql_ActividadesSinVendedor);

		if($query_ActividadesSinVendedor->num_rows() > 0){
			$todasActividadesActualizarVendedor = $query_ActividadesSinVendedor->result();
		} else {
			$todasActividadesActualizarVendedor = false;
		}
				
		echo "<pre>";
		print("TimeStart: ".date('Y-m-d H:i:s'));
			echo "<br />Actualizando Actividades de Todas<br />";
			echo count($todasActividadesActualizarVendedor)."<br />";
			//print_r($todasActividadesActualizar);
			if($todasActividadesActualizarVendedor != false){
				$contLine = 0;
				$usuarioVendedor = "";
				foreach($todasActividadesActualizarVendedor as $actividadActualizar){
					$idInterno		= $actividadActualizar->idInterno;
					$idCliente		= $actividadActualizar->idCliente;
					$idContacto		= $actividadActualizar->idContacto;
					$ClienteSicas	= $idCliente."-".$idContacto;
					
					echo "<pre>";
						echo "<b>".$contLine."</b><br />";
						print_r($actividadActualizar);
					echo "</pre>";
					
					if(($idCliente != "" || $idCliente != NULL ) && ($idContacto != "" || $idContacto != NULL )){
						$detalleCliente = $this->capsysdre_actividades->DetalleCliente($ClienteSicas);
						$IDVend = $detalleCliente[0]->URL;
						
						$sql_DetalleVendedor = "
							Select * From
								`catalog_vendedores`
							Where
								`IDVend` = '".$IDVend."'
											   ";
						$this->db->query($sql_DetalleVendedor);
						$query_DetalleVendedor = $this->db->query($sql_DetalleVendedor);
						if($query_DetalleVendedor->num_rows() > 0){
							$detalleVendedor	= $query_DetalleVendedor->result();
							$usuarioVendedor	= strtoupper(rtrim(ltrim($detalleVendedor[0]->EMail1)));
						} else {
							$detalleVendedor	= false;
							$usuarioVendedor	= "";
						}
					}

					//***
					//* Update Actividad Capsys
					//***
					if($usuarioVendedor != ""){
						$sql_UpdateActividad = "
							Update
								`actividades`
							Set
								`usuarioVendedor`	= '".$usuarioVendedor."'
							Where
								`idInterno`		= '".$idInterno."'
											   ";
					} else {
						$sql_UpdateActividad = "
							Update
								`actividades`
							Set
								`usuarioVendedor`	= 'SinIdentificar',
							Where
								`idInterno`		= '".$idInterno."'
											   ";
					}
//**-->					$this->db->query($sql_UpdateActividad);
					//*! Fin Update Actividad Capsys
					echo "<pre>";
						print($sql_UpdateActividad);
					echo "</pre>";
				/*
				*/				
				$contLine++;	
				}//*! fin del foreach $todasActividadesActualizar
		
			} else {
				echo "No Existen Elemento a Actualizar";
			} /*! fin del if si existen elementos en el arreglo $todasActividadesActualizarVend */
		print("TimeEnd: ".date('Y-m-d H:i:s'));
		echo "</pre>";
	}/*! actualizaActividades_UserVend */
	
    function actualizaActividades_RankingVend(){
		$sql_ActividadesSinRankingVendedor = "
			Select
				`idInterno`,
				`folioActividad`,
				`idSicas`,
				`NumSolicitud`,
				`Documento`,
				`ClaveBit`,
				`IDBit`,
				`Status`,
				`tipoActividadSicas`,
				`inicio`,
				`fin`,
				`idCliente`,
				`idContacto`,
				`nombreCliente`,
				`tipoActividad`,
				`usuarioCreacion`,
				`usuarioVendedor`,
				`nombreUsuarioVendedor`,
				`rankingVendedor`
			From
				`actividades`
			Where
				(
					`usuarioVendedor` != ''
					Or
					`usuarioVendedor` Is Not Null
				)
				And
				(
					`rankingVendedor` Is Null
				)
									  ";
		$query_ActividadesSinRankingVendedor = $this->db->query($sql_ActividadesSinRankingVendedor);

		if($query_ActividadesSinRankingVendedor->num_rows() > 0){
			$todasActividadesSinRankingVendedor = $query_ActividadesSinRankingVendedor->result();
		} else {
			$todasActividadesSinRankingVendedor = false;
		}
				
		echo "<pre>";
		print("TimeStart: ".date('Y-m-d H:i:s'));
			echo "<br />Actualizando Actividades de Todas<br />";
			echo count($todasActividadesSinRankingVendedor)."<br />";
			//print_r($todasActividadesActualizar);
			if($todasActividadesSinRankingVendedor != false){
				$contLine = 0;
				$usuarioVendedor = "";
				foreach($todasActividadesSinRankingVendedor as $actividadActualizar){
					$idInterno			= $actividadActualizar->idInterno;
					$usuarioVendedor	= $actividadActualizar->usuarioVendedor;
					
					echo "<pre>";
						echo "<b>".$contLine."</b><br />";
						print_r($actividadActualizar);
					echo "</pre>";
					
					if($usuarioVendedor != "" || $usuarioVendedor != NULL){

						$sql_DetalleRankingVendedor = "
							Select
								`emailUser`,
								`IDVend`,
								`IDVendNs`,
								`IDCont`,
								`consultor`,
								Concat(`nombre`,' ',`apellidop`,' ',`apellidom`) As `nombreUsuarioVendedor`,
								`Ranking`
							From
								`user_miInfo`
							Where
								`emailUser` = '".$usuarioVendedor."'
											   ";
						$this->db->query($sql_DetalleRankingVendedor);
						$query_DetalleRankingVendedor = $this->db->query($sql_DetalleRankingVendedor);
						if($query_DetalleRankingVendedor->num_rows() > 0){
							$detalleRankingVendedor	= $query_DetalleRankingVendedor->result();
							$rankingVendedor		= strtoupper(rtrim(ltrim($detalleRankingVendedor[0]->Ranking)));
							$nombreUsuarioVendedor	= strtoupper(rtrim(ltrim($detalleRankingVendedor[0]->nombreUsuarioVendedor)));

						} else {
							$detalleRankingVendedor	= false;
							$rankingVendedor	= "";
						}
							/*						
							echo "<pre>";
								echo "[X]";
								echo $sql_DetalleRankingVendedor;
								print_r($detalleRankingVendedor);
							echo "</pre>";
							*/
					}

					//***
					//* Update Actividad Capsys
					//***
					if($rankingVendedor != ""){
						$sql_UpdateActividad = "
							Update
								`actividades`
							Set
								`rankingVendedor`	= '".$rankingVendedor."',
								`nombreUsuarioVendedor` = '".$nombreUsuarioVendedor."'
							Where
								`idInterno`		= '".$idInterno."'
											   ";
					} else {
						$sql_UpdateActividad = "
							Update
								`actividades`
							Set
								`rankingVendedor`	= 'SinIdentificar',
								`nombreUsuarioVendedor` = 'SinIdentificar'
							Where
								`idInterno`		= '".$idInterno."'
											   ";
					}
					$this->db->query($sql_UpdateActividad);
					//*! Fin Update Actividad Capsys
					echo "<pre>";
						print($sql_UpdateActividad);
					echo "</pre>";
				/*
				*/				
				$contLine++;	
				}//*! fin del foreach $todasActividadesActualizar

			} else {
				echo "No Existen Elemento a Actualizar";
			} /*! fin del if si existen elementos en el arreglo $todasActividadesActualizarVend */
		print("TimeEnd: ".date('Y-m-d H:i:s'));
		echo "</pre>";
	}/*! actualizaActividades_RankingVend */
	
	function actualizaActividades_RankingVendEmision(){
		$sql_ActividadesConRankingVendedor = "
			Select
				`idInterno`,
				`folioActividad`,
				`idSicas`,
				`NumSolicitud`,
				`Documento`,
				`ClaveBit`,
				`IDBit`,
				`Status`,
				`tipoActividadSicas`,
				`inicio`,
				`fin`,
				`idCliente`,
				`idContacto`,
				`nombreCliente`,
				`tipoActividad`,
				`usuarioCreacion`,
				`IDVend`,
				`usuarioVendedor`,
				`nombreUsuarioVendedor`,
				`rankingVendedor`
			From
				`actividades`
			Where
				(
					`usuarioVendedor` != ''
					Or
					`usuarioVendedor` Is Not Null
				)
				And
				(
					`rankingVendedor` Is Not Null
				)
									  		 ";
		$query_ActividadesConRankingVendedor = $this->db->query($sql_ActividadesConRankingVendedor);

		if($query_ActividadesConRankingVendedor->num_rows() > 0){
			$todasActividadesConRankingVendedor = $query_ActividadesConRankingVendedor->result();
		} else {
			$todasActividadesConRankingVendedor = false;
		}
				
		echo "<pre>";
		print("TimeStart: ".date('Y-m-d H:i:s'));
			echo "<br />Actualizando Actividades Emision de Todas<br />";
			echo count($todasActividadesConRankingVendedor)."<br />";
			//print_r($todasActividadesActualizar);
			if($todasActividadesConRankingVendedor != false){
				$contLine = 0;
				$usuarioVendedor = "";
				foreach($todasActividadesConRankingVendedor as $actividadActualizar){
					//$idInterno			= $actividadActualizar->idInterno;
					$folioActividad			= $actividadActualizar->folioActividad;
					$IDVend					= $actividadActualizar->IDVend;
					$usuarioVendedor		= $actividadActualizar->usuarioVendedor;
					$nombreUsuarioVendedor	= $actividadActualizar->nombreUsuarioVendedor;
					$rankingVendedor		= $actividadActualizar->rankingVendedor;

					echo "<pre>";
						echo "<b>".$contLine."</b><br />";
						print_r($actividadActualizar);
					echo "</pre>";

					//***
					//* Update Actividad Capsys
					//***
					if($rankingVendedor != ""){
						$sql_UpdateActividad = "
							Update
								`actividades`
							Set
								`IDVend`				= '".$IDVend."',
								`usuarioVendedor`		= '".$usuarioVendedor."',
								`nombreUsuarioVendedor`	= '".$nombreUsuarioVendedor."',
								`rankingVendedor`		= '".$rankingVendedor."'
							Where
								`folioActividad`				= '".$folioActividad."'
								And
								`IDVend`				= ''
											   ";
					}
					$this->db->query($sql_UpdateActividad);
					//*! Fin Update Actividad Capsys
					echo "<pre>";
						print($sql_UpdateActividad);
					echo "</pre>";
				/*
				*/				
				$contLine++;	
				}//*! fin del foreach $todasActividadesActualizar

			} else {
				echo "No Existen Elemento a Actualizar";
			} /*! fin del if si existen elementos en el arreglo $todasActividadesActualizarVend */
		print("TimeEnd: ".date('Y-m-d H:i:s'));
		echo "</pre>";
	}/*! actualizaActividades_RankingVendEmision */
	
	function calculaSemaforoActividades(){
		$actividadesCalculaSemaforo = $this->actividadesCalculaSemaforo();
		if($actividadesCalculaSemaforo != false){
			echo "<strong>Total de Actividades Actualizar:</strong> ".$actividadesCalculaSemaforo->num_rows();
			foreach($actividadesCalculaSemaforo->result() as $actividadCalculaSemaforo){
				$fechaCreacion	= strtotime($actividadCalculaSemaforo->fechaCreacion);
				$fechaActual	= strtotime($actividadCalculaSemaforo->fechaActual);
				$fechaRespuesta	= strtotime($actividadCalculaSemaforo->fechaRespuesta);
				
				if($actividadCalculaSemaforo->semaforo == ""){
					if($actividadCalculaSemaforo->fechaPromesa == ""){
						$colorSemaforo = "";
						if($actividadCalculaSemaforo->fechaRespuesta == ""){
							$difSegundos_ActualCreacion	= $fechaActual - $fechaCreacion;
							$difMinutos_ActualCreacion	= intval($difSegundos_ActualCreacion/60);
							
							switch($actividadCalculaSemaforo->tipoActividad){
							case "Cotizacion":					## 1
							case "Emision":						## 2
							case "Diligencias":					## 3
							case "CambiodeConducto":			## 4
							case "Endoso":						## 5
							case "Cancelacion":					## 6
							//case "Siniestros":				## 7
							case "OtrasActividades":			## 8
							case "AclaraciondeComisiones":		## 9
							case "SolicituddetarjetasClubCap":	## 10
							case "PagoCobranza":				## 11
							case "CapturaEmision":				## 12
							case "CapturaRenovacion":			## 13
								if($difMinutos_ActualCreacion == 0 || $difMinutos_ActualCreacion < 60){
									$colorSemaforo = "verde";
								} else if($difMinutos_ActualCreacion > 61 && $difMinutos_ActualCreacion < 90){
									$colorSemaforo = "amarillo";
								} else if($difMinutos_ActualCreacion > 91){
									$colorSemaforo = "rojo";
								}
							}
							
								$semaforoTocoRojoNew = $actividadCalculaSemaforo->semaforoTocoRojo + 1;
								$sqlUpdateSemaforo = "
									Update
										`actividades`
									Set
										`semaforo` = '".$colorSemaforo."',
										`semaforoTocoRojo` = '".$semaforoTocoRojoNew."'
									Where
										`idInterno` = '".$actividadCalculaSemaforo->idInterno."' 
													 ";
								$this->db->query($sqlUpdateSemaforo);
							
						} else {
							$difSegundos_ActualRespuesta	= $fechaActual - $fechaRespuesta;
							$difMinutos_ActualRespuesta	= intval($difSegundos_ActualRespuesta/60);
							
							switch($actividadCalculaSemaforo->tipoActividad){
							case "Cotizacion":					## 1
							case "Emision":						## 2
							case "Diligencias":					## 3
							case "CambiodeConducto":			## 4
							case "Endoso":						## 5
							case "Cancelacion":					## 6
							//case "Siniestros":				## 7
							case "OtrasActividades":			## 8
							case "AclaraciondeComisiones":		## 9
							case "SolicituddetarjetasClubCap":	## 10
							case "PagoCobranza":				## 11
							case "CapturaEmision":				## 12
							case "CapturaRenovacion":			## 13
								if($difMinutos_ActualRespuesta == 0 || $difMinutos_ActualRespuesta < 60){
									$colorSemaforo = "verde";
								} else if($difMinutos_ActualRespuesta > 61 && $difMinutos_ActualRespuesta < 90){
									$colorSemaforo = "amarillo";
								} else if($difMinutos_ActualRespuesta > 91){
									$colorSemaforo = "rojo";
								}
							}
								
								$semaforoTocoRojoNew = $actividadCalculaSemaforo->semaforoTocoRojo + 1;
								$sqlUpdateSemaforo = "
									Update
										`actividades`
									Set
										`semaforo` = '".$colorSemaforo."',
										`semaforoTocoRojo` = '".$semaforoTocoRojoNew."'
									Where
										`idInterno` = '".$actividadCalculaSemaforo->idInterno."' 
													 ";
								$this->db->query($sqlUpdateSemaforo);
									
						} /*! Fin If FechaRespuesta */
					}
				}
			}
		}
	}
	
	private function actividadesActualizar_Operacion(){
		$sqlActividadesActualizar = "
			Select
				`idInterno`,
				`folioActividad`,
				`idSicas`,
				`NumSolicitud`,
				`Documento`,
				`ClaveBit`,
				`IDBit`,
				`Status`,
				`tipoActividadSicas`,
				`inicio`,
				`fin`,
				`idCliente`,
				`idContacto`,
				`tipoActividad`
			From
				`actividades`
			Where
				(
					inicio = '0'
					And
					fin != '1'
				)
				And
				(
					Status != '1' ## Agente Gap
					And
					Status != '6' ## Finalizada
					And
					Status != '7' ## Pospuesta
				)
				And
				(
					`idSicas` != ''
					And
					`idSicas` Is Not Null
					And
					`sicasDelete` =0
				)
			Order By
				`fechaSyncro`, `idInterno` Asc
--			Limit 
--				0,100
									";
		$query = $this->db->query($sqlActividadesActualizar);

		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return false;
		}
	}/* actividadesActualizar_Operacion */
	
	private function actividadesActualizar_Vendedores(){
		$sqlActividadesActualizar = "
			Select
				`idInterno`,
				`folioActividad`,
				`idSicas`,
				`NumSolicitud`,
				`Documento`,
				`ClaveBit`,
				`IDBit`,
				`Status`,
				`tipoActividadSicas`,
				`inicio`,
				`fin`,
				`idCliente`,
				`idContacto`,
				`tipoActividad`
			From
				`actividades`
			Where
				(
					inicio = '0'
					And
					fin != '1'
				)
				And
				(
					Status != '2' ## ASEGURADORA
					And
					Status != '3' ## NUBE
					And
					Status != '4' ## EJECUTIVO
					And
					Status != '5' ## EN CURSO
				)
				And
				(
					`idSicas` != ''
					And
					`idSicas` Is Not Null
					And
					`sicasDelete` =0
				)
			Order By
				`fechaSyncro`, `idInterno` Asc
--			Limit 
--				0,100
									";
		$query = $this->db->query($sqlActividadesActualizar);

		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return false;
		}
	}/* actividadesActualizar_Vendedores */
	
	private function actividadesActualizar_Todas(){
		$sqlActividadesActualizar = "
			Select
				`idInterno`,
				`folioActividad`,
				`idSicas`,
				`NumSolicitud`,
				`Documento`,
				`ClaveBit`,
				`IDBit`,
				`Status`,
				`tipoActividadSicas`,
				`inicio`,
				`fin`,
				`idCliente`,
				`idContacto`,
				`tipoActividad`
			From
				`actividades`
			Where
				(
					inicio = '0'
					And
					fin != '1'
				)
				And
				(
					Status != '6' ## Finalizada
				)
				And
				(
					`idSicas` != ''
					And
					`idSicas` Is Not Null
					And
					`sicasDelete` =0
				)
			Order By
--				`fechaSyncro`, `idInterno` Asc
				`Status` Desc
--			Limit 
--				0,100
									";
		$query = $this->db->query($sqlActividadesActualizar);

		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return false;
		}
	}/* actividadesActualizar_Todas */
	
	private function actividadesCalculaSemaforo(){
		
		$sqlActividadesCalculaSemaforo = "
			Select
				`idInterno`,
				`tipoActividad`,
				`semaforo`,
				`fechaCreacion`,
				`fechaPromesa`,
				`fechaRespuesta`,
				`folioActividad`,
				`semaforoTocoRojo`,
				Concat(Curdate(), ' ', Curtime()) As `fechaActual`
			From
				`actividades`

			Where
				(
					`idSicas` Is Not Null
					And
					`Status` != '6'
				)
			Order By
				`idInterno` Desc;
									";
		$query = $this->db->query($sqlActividadesCalculaSemaforo);

		if($query->num_rows() > 0){
			return $query;
		} else {
			return false;
		}
	
	} /*! actividadesCalculaSemaforo */

	
    /* ======================MI CODIGO  LOCM====================================*/


	function actualizaactividadesporvendedor()
	{

				$todasActividadesActualizar =$this->actividadesActualizarPorVendedor();
			/*	echo "<pre>";
		print("TimeStart: ".date('Y-m-d H:i:s'));
			echo "<br />Actualizando Actividades de Todas<br />";
			echo count($todasActividadesActualizar)."<br />";*/
			//print_r($todasActividadesActualizar);
			if($todasActividadesActualizar != false){
				$contLine = 0;
				$idSicas		= "";
				$FechaEntrega	= "";
				$NumSolicitud	= "";
				$Documento		= "";

				foreach($todasActividadesActualizar as $actividadActualizar){
					$idInterno = $actividadActualizar->idInterno;
					echo "<pre>";
						echo "<b>".$contLine."</b><br />";
						print_r($actividadActualizar);
					echo "</pre>";
	
					//***
					//* Switch Tipo de Actividad Sicas
					//***

					switch($actividadActualizar->tipoActividadSicas){
						case "ot":
							$infoDocumento	= $this->capsysdre_actividades->DetalleDocumento($actividadActualizar->idSicas);
							if($infoDocumento != ""){
								$FechaEntrega	= $infoDocumento[0]->FEntrega;
								$Status			= $infoDocumento[0]->StatusUser;
								$idSicas 		= $infoDocumento[0]->IDDocto;
								$NumSolicitud	= $infoDocumento[0]->NumSolicitud;
								$Documento		= $infoDocumento[0]->Documento;
							} else {
								$FechaEntrega	= "";
								$Status			= "";
								$idSicas 		= "";
								$NumSolicitud	= "";
								$Documento		= "";
							}
						break;
						
						case "tarea":
							$infoDocumento	= $this->capsysdre_actividades->DetalleDocumentoTarea($actividadActualizar->idSicas);
							if($infoDocumento != ""){
								$FechaEntrega	= $infoDocumento[0]->FPromesa;
								$Status			= $infoDocumento[0]->Status;
								$idSicas 		= $infoDocumento[0]->IDTarea;
								$NumSolicitud	= "";
								$Documento		= "";
							} else {
								$FechaEntrega	= "";
								$Status			= "";
								$idSicas 		= "";
								$NumSolicitud	= "";
								$Documento		= "";
							}
						break;
					}//*! Fin de Switch Tipo de Actividad Sicas
					sleep(1);

					//* Formateo de Fecha Promesa
					//***
					if($FechaEntrega != ""){
						$fechaPromesa = date_format(date_create($FechaEntrega), 'Y-m-d H:i:s');
						$SetFechaPromesa =	"`fechaPromesa`	= '".$fechaPromesa."',";
					} else {
						$fechaPromesa = NULL;
						$SetFechaPromesa =	"";
					}//*! fin If Formateo Fecha Promesa
					
					if($NumSolicitud != ""){
						$SetNumSolicitud =	"`NumSolicitud`	= '".$NumSolicitud."',";
					} else {
						$SetNumSolicitud =	"";
					}
					
					if($Documento != ""){
						$SetDocumento =	"`Documento`	= '".$Documento."',";
					} else {
						$SetDocumento =	"";
					}

					//***
					//* Update Actividad Capsys
					//***
					if($idSicas != ""){
						$sql_UpdateActividad = "
							Update
								`actividades`
							Set
								`Status` 		= '".$Status."',
								".$SetFechaPromesa."
								".$SetNumSolicitud."
								".$SetDocumento."
								`fechaSyncro`	= '".date('Y-m-d H:i:s')."'
							Where
								`idInterno`		= '".$idInterno."'
											   ";
						##$this->db->query($sql_UpdateActividad);
					} else {
						$sql_UpdateActividad = "
							Update
								`actividades`
							Set
								`sicasDelete`	= '0',
								`fechaSyncro`	= '".date('Y-m-d H:i:s')."'
							Where
								`idInterno`		= '".$idInterno."'
											   ";
						##$this->db->query($sql_UpdateActividad_SicasDelete);
					}
					$this->db->query($sql_UpdateActividad);
					//*! Fin Update Actividad Capsys
					echo "<pre>";
						print($sql_UpdateActividad);
					echo "</pre>";
				/*
				*/				
				$contLine++;	
				}//*! fin del foreach $todasActividadesActualizar
		
			} else {
					redirect('/actividades/');
				//echo "No Existen Elemento a Actualizar";
			} /*! fin del if si existen elementos en el arreglo $todasActividadesActualizar */
//		print("TimeEnd: ".date('Y-m-d H:i:s'));
		//echo "<pre>";


		redirect('/actividades/');
		
	}

	private function actividadesActualizarPorVendedor()
	{
		$sqlActividadesActualizar = "
			Select
				`idInterno`,
				`folioActividad`,
				`idSicas`,
				`NumSolicitud`,
				`Documento`,
				`ClaveBit`,
				`IDBit`,
				`Status`,
				`tipoActividadSicas`,
				`inicio`,
				`fin`,
				`idCliente`,
				`idContacto`,
				`tipoActividad`
			From
				`actividades`
			Where
				(
					inicio = '0'
					And
					fin != '1'
				)
				And
				(
					Status != '6' ## Finalizada
				)
				And
				(
					`idSicas` != ''
					And
					`idSicas` Is Not Null
					And
					`sicasDelete` =0
				)"."				and 
				(
				 	`usuarioCreacion`= 
				".'"'.$this->tank_auth->get_usermail().'"'.
				")
			Order By
				`Status` Desc

									";
		//echo ($sqlActividadesActualizar);
		$query = $this->db->query($sqlActividadesActualizar);

		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return false;
		}

	}
    /*LOCM*/
    /*====================================================================*/


}

/* End of file actualizaActividades.php */


/* Location: ./application/controllers/actualizaActividades.php */

/* ======================MI CODIGO LOCM====================================*/


