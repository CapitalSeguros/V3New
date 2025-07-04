<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Capsysdre_actividades extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('libreriaV3');
		$this->load->model('PersonaModelo');
		$this->load->model('ticc_folios_model');
		$this->load->library('Kpi_automaticos');
	}/*! */

	public function CalculaNewFolioActividad()
	{

		/*PROBLEMAS CON EL DBDRIVER MYSQL TIENE QUE SER DBDRIVER MYSQLI*/
		//$base2 = $this->load->database('db2', true);
		//$consulta = 'CALL devuelveIdFolio();';
		//$row = $base2->query($consulta);
		//  $row=$this->db->GET('db.devuelveIdFolio()');

		//$folioActividad = "SW";
		//$folioActividad .= $row->result()[0]->valor;
		//$folioActividad .= $row->valor; //+1;
		//return
		//$folioActividad;

		$Nom = "SW";
		$Year = date('Y');
		$folioFinal = "";

		//** 1. Verifica si existe el folioActividad en la tabla ticc_folios
		$folioActividad = $this->ticc_folios_model->getFolioByNumYear($Nom, $Year);
		if (count($folioActividad) > 0) {
			//** 2. Si existe, incrementa el folio
			$folioActividad = $folioActividad[0]['folio'] + 1;
			//** 3. Actualiza el folio en la tabla ticc_folios
			$this->ticc_folios_model->updateFolioByNumYear($Nom, $Year, $folioActividad);

			$folioFinal = $Nom . "-" . substr($Year, 2) . str_pad($folioActividad, 7, '0', STR_PAD_LEFT);
		}

		//$folioActividad = "SW";
		//$folioActividad .= date('ymdsm');

		return
			$folioFinal;
	}/*! CalculaNewFolioActividad */



	public function ActualizaNewFolioActividad($valor)
	{
		$CleanValor = (int)substr($valor, 2, 11);
		$data = array(
			'valor' => $CleanValor + 1
		);
		$this->db->where('configdre.parametro', 'folioActividad');
		$this->db->update('configdre', $data);
	}/*! ActualizaNewFolioActividad */

	function UsuarioSicasCapsysWeb($IDUser)
	{
		$this->db->from("users");
		$this->db->where("IDUser", $IDUser);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->row()->name_complete;
		} else {
			return false;
		}
	}/*! UsuarioSicasCapsysWeb */

	function titleDatosExpres($textoExpress)
	{
		$quitar = array("<p>", "</p>", "<br />");
		$poner = array("", "\n", "\n");

		$textoLimpio = str_replace($quitar, $poner, $textoExpress);

		return
			$textoLimpio;
	}/*! titleDatosExpres */

	function fechaHoraEspActividades($fechaHoraMysql, $tipoImpresion)
	{
		switch ($tipoImpresion) {
			case "title":
				$saltoLine = "\n";
				break;

			case "lineal":
				$saltoLine = "&nbsp;";
				break;

			default:
				$saltoLine = "<br />";
				break;
		}
		$mesEsp['01'] = 'Ene';
		$mesEsp['02'] = 'Feb';
		$mesEsp['03'] = 'Mar';
		$mesEsp['04'] = 'Abr';
		$mesEsp['05'] = 'May';
		$mesEsp['06'] = 'Jun';
		$mesEsp['07'] = 'Jul';
		$mesEsp['08'] = 'Ago';
		$mesEsp['09'] = 'Sep';
		$mesEsp['10'] = 'Oct';
		$mesEsp['11'] = 'Nov';
		$mesEsp['12'] = 'Dic';

		$fechaFormateada = date_format(date_create($fechaHoraMysql), 'H:i:s a');
		$fechaFormateada .= $saltoLine;
		$fechaFormateada .= date_format(date_create($fechaHoraMysql), 'd-');
		$fechaFormateada .= $mesEsp[(string)date_format(date_create($fechaHoraMysql), 'm')];
		$fechaFormateada .= date_format(date_create($fechaHoraMysql), '-Y');
		return
			$fechaFormateada;
	}/*! fechaHoraEspActividades */

	function Status($IdStatus)
	{
		$this->db->from("catalog_actividades-status");
		$this->db->where("IdStatus", $IdStatus);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->row()->Nombre;
		} else {
			return false;
		}
	}/*! Status */

	function SubRamoActivicad($IDSRamo)
	{
		$this->db->from("catalog_subRamos");
		$this->db->where("IDSRamo", $IDSRamo);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->row()->Nombre;
		} else {
			return false;
		}
	}/*! SubRamoActivicad */

	function semaforoActividad($semaforo)
	{
		switch ($semaforo) {
				/*
				-- Green
				-- Purple
				-- Red
				-- Orange
				-- Blue
			*/
			case "Red": // rojo
				$styloSemaforo = "
									background-color:#FF0000;
									color:#FFFFFF;
									/* border-radius:30px; */
									border:#D43F3A solid 2px;
									font-weight:bold;
								 ";
				break;

			case "Orange": // amarillo
				$styloSemaforo = "
									background-color:#FFA500; 
									color:#FFFFFF; 
									/* border-radius:30px; */
									border:#EEA236 solid 2px;
									font-weight:bold;
								 ";
				break;

			case "Green": // verde
				$styloSemaforo = "
									background-color:#008000;
									color:#FFFFFF;
									/* border-radius:30px; */
									border:#063 solid 2px;
									font-weight:bold;
								 ";
				break;

			case "Purple": // Morado
				$styloSemaforo = "
									background-color:#800080; 
									color:#FFFFFF; 
									/* border-radius:30px; */
									border:#909 solid 2px;
									font-weight:bold;
								 ";
				break;

			case "Blue": // Azul
				$styloSemaforo = "
									background-color:#FFFFFF;
									color:#000000;
									/* border-radius:30px; */
									border:#CCCCCC solid 2px;
									font-weight:bold;
								 ";
				break;

			default:
				$styloSemaforo = "
									background-color:#FFFFFF; 
									color:#000000; 
									/* border-radius:30px; */
									border:#CCCCCC solid 2px;
									font-weight:bold;
								 ";
				break;
		}

		return
			$styloSemaforo;
	}/*! semaforoActividad */

	function ActividadesUsuario($usuarioResponsable)
	{
		//$this->db->select("idInterno, folioActividad, fin, fechaActualizacion");
		$this->db->from("actividades");
		$this->db->where("(fin != '1' And inicio = '0' And Status != '6' And Status != '7')"); //And (tipoActividadSicas = 'ot')
		//$this->db->where("usuarioCreacion", $usuarioResponsable);
		$this->db->where("(usuarioCreacion = '" . $usuarioResponsable . "' Or usuarioResponsable = '" . $usuarioResponsable . "' Or usuarioBolita = '" . $usuarioResponsable . "')");
		$this->db->order_by("actividades.fechaActualizacion", "desc");

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			//$return = $query;
			return $query;
		} else {
			//$return = "";
			return false;
		}
	}/*! ActividadesUsuario */


	function ActividadesPendientes($usuarioResponsable)
	{
		//$this->db->select("idInterno, folioActividad, fin, fechaActualizacion");

		$consulta = 'select users.ActCreadaPorOtro from users where users.email="' . $usuarioResponsable . '"';
		$datos = $this->db->query($consulta);
		$ActCreadaPorOtro = $datos->result()[0]->ActCreadaPorOtro;
		//$datos[0]['ActCreadaPorOtro'];

		$this->db->from("actividades");
		$this->db->where("(actividades.fin != '1' And actividades.inicio = '0')");
		switch ($this->tank_auth->get_userprofile()) {

			case 1:
			case 2:
			case 3:
			case 4:
				/*	$this->db->where("(usuarioCreacion = '".$usuarioResponsable."')"); 
			//**  And usuarioBolita = '".$usuarioResponsable."'
			$this->db->where("(Status = '1')");*/
				if ($ActCreadaPorOtro == "SI") {
					//**  And usuarioBolita = '".$usuarioResponsable."'
					$this->db->where("(usuarioCreacion = '" . $usuarioResponsable . "' or usuarioVendedor='" . $usuarioResponsable . "' )");
					$this->db->where("(Status = '1')");
				} else {
					//**  And usuarioBolita = '".$usuarioResponsable."'
					$this->db->where("(usuarioCreacion = '" . $usuarioResponsable . "')");
					$this->db->where("(Status = '1')");
				}
				break;

			case 5:

				$this->db->where("(usuarioCreacion = '" . $usuarioResponsable . "' And Status = '1' )
								Or
								(usuarioBloqueo = '" . $usuarioResponsable . "' And Status = '3')");
				break;
		}
		$this->db->order_by("actividades.idSicas", "desc");
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query;
		} else {
			return false;
		}
	}/*! ActividadesPendientes */

	function ActividadesTrabajandose($usuarioCreacion)
	{

		/* $consulta='select users.ActCreadaPorOtro from users where users.email="'.$usuarioCreacion.'"';
         $datos=$this->db->query($consulta);


		$this->db->from("actividades");
		$this->db->where("(actividades.fin != '1' And actividades.inicio = '0')");
				  if($datos->result()[0]->ActCreadaPorOtro=="NO"){
		$this->db->where("(usuarioCreacion = '".$usuarioCreacion."')");} //**  And usuarioBolita != '".$usuarioCreacion."'
		else{
	$this->db->where("(usuarioCreacion = '".$usuarioCreacion."' or usuarioVendedor='".$usuarioCreacion."' )");}
		$this->db->where("(Status = '2' Or Status = '3' Or Status = '4' Or Status = '5')"); //** Or Status = '7'
		//$this->db->group_by("idSicas");
		$this->db->order_by("actividades.idSicas", "desc");

		$query = $this->db->get();

		if($query->num_rows() > 0){
  			return $query;
		} else {
			return false;
		}*/ //++


		$consulta = 'select users.ActCreadaPorOtro from users where users.email="' . $usuarioCreacion . '"';
		$datos = $this->db->query($consulta);

		$consulta = "select * from actividades where (actividades.fin != '1' And actividades.inicio = '0')";
		if ($datos->result()[0]->ActCreadaPorOtro == "NO") {
			$consulta = $consulta . " and (usuarioCreacion = '" . $usuarioCreacion . "') and";
		} else {
			$consulta = $consulta . " and (usuarioCreacion = '" . $usuarioCreacion . "' or usuarioVendedor='" . $usuarioCreacion . "' ) and ";
		}

		$consulta = $consulta . "(Status = '2' Or Status = '3' Or Status = '4' Or Status = '5')";



		$query = $this->db->query($consulta);
		if ($query->num_rows() > 0) {
			return $query;
		} else {
			return false;
		}
	}/*! ActividadesTrabajandose */
	//---------------------------------------------------------------------
	function ActividadesPospuestas($usuarioResponsable)
	{


		//**  And usuarioBolita = '".$usuarioResponsable."'
		//$this->db->select("idInterno, folioActividad, fin, fechaActualizacion");


		$consulta = 'select users.ActCreadaPorOtro from users where users.email="' . $usuarioResponsable . '"';
		$datos = $this->db->query($consulta);

		$this->db->from("actividades");
		$this->db->where("(actividades.fin != '1' And actividades.inicio = '0')");


		if ($datos->result()[0]->ActCreadaPorOtro == "SI") {
			$this->db->where("(usuarioCreacion = '" . $usuarioResponsable . "' or usuarioVendedor='" . $usuarioResponsable . "' )");
		} else {
			$this->db->where("(usuarioCreacion = '" . $usuarioResponsable . "')");
		} //**  And usuarioBolita = '".$usuarioResponsable."'
		$this->db->where("(Status = '7')");
		$this->db->order_by("actividades.idSicas", "desc");

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			//$return = $query;
			return $query;
		} else {
			//$return = "";
			return false;
		}
	}/*! ActividadesPospuestas */

	function ActividadesNubeAutos()
	{
		//$this->db->select("idInterno, folioActividad, fin, fechaActualizacion");
		$this->db->from("actividades");
		$this->db->where("(actividades.fin != '1' And actividades.inicio = '0' And (actividades.Status = '5' /*Or actividades.Status = '3'*/))");
		$this->db->where("(actividades.tipoActividadSicas = 'ot')");
		$this->db->where("(actividades.ramoActividad = 'VEHICULOS')");
		$this->db->where("(actividades.tipoActividad = 'Cotizacion' And actividades.fechaEmite Is NULL)");
		$this->db->order_by("actividades.fechaActualizacion", "desc");
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			//$return = $query;
			return $query;
		} else {
			//$return = "";
			return false;
		}
	}/*! ActividadesNubeAutos */

	function ActividadesNubeDanos()
	{
		//$this->db->select("idInterno, folioActividad, fin, fechaActualizacion");
		$this->db->from("actividades");
		$this->db->where("(actividades.fin != '1' And actividades.inicio = '0' And (actividades.Status = '5' /*Or actividades.Status = '3'*/))");
		$this->db->where("(actividades.tipoActividadSicas = 'ot')");
		$this->db->where("(actividades.ramoActividad = 'DANOS')");
		$this->db->where("(actividades.tipoActividad = 'Cotizacion' And actividades.fechaEmite Is NULL)");
		$this->db->order_by("actividades.fechaActualizacion", "desc");
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			//$return = $query;
			return $query;
		} else {
			//$return = "";
			return false;
		}
	}/*! ActividadesNubeDanos */

	function ActividadesNubeLineasPersonales()
	{
		//$this->db->select("idInterno, folioActividad, fin, fechaActualizacion");
		$this->db->from("actividades");
		$this->db->where("(actividades.fin != '1' And actividades.inicio = '0' And (actividades.Status = '5' /*Or actividades.Status = '3'*/))");
		$this->db->where("(actividades.tipoActividadSicas = 'ot')");
		$this->db->where("(actividades.ramoActividad = 'ACCIDENTES_Y_ENFERMEDADES' Or actividades.ramoActividad = 'VIDA')");
		$this->db->where("(actividades.tipoActividad = 'Cotizacion' And actividades.fechaEmite Is NULL)");
		$this->db->order_by("actividades.fechaActualizacion", "desc");
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			//$return = $query;
			return $query;
		} else {
			//$return = "";
			return false;
		}
	}/*! ActividadesNubeLineasPersonales */


	function BuscadorActividades($folioBuscado, $usuarioCreacion, $userProfile)
	{
		switch ($userProfile) {
			case "1":
				$this->db->from("actividades");
				$this->db->where(
					"NumSolicitud Like '%" . $folioBuscado . "%' Or folioActividad Like '%" . $folioBuscado . "%' Or nombreCliente Like '%" . $folioBuscado . "%' Or folioActividadSiniestros Like '%" . $folioBuscado . "%'"
				);
				break;

			case "2":
				$this->db->from("actividades");
				$this->db->where(
					"NumSolicitud Like '%" . $folioBuscado . "%' Or folioActividad Like '%" . $folioBuscado . "%' Or nombreCliente Like '%" . $folioBuscado . "%' Or folioActividadSiniestros Like '%" . $folioBuscado . "%'"
				);
				break;

			case "3": // Operativo
			case "4": // Master
			case "5": // Nube
			case "6": // Cliente
				$this->db->from("actividades");
				$this->db->where(
					"NumSolicitud Like '%" . $folioBuscado . "%' Or folioActividad Like '%" . $folioBuscado . "%' Or nombreCliente Like '%" . $folioBuscado . "%' Or folioActividadSiniestros Like '%" . $folioBuscado . "%'"
				);
				break;
		}
		$this->db->order_by("actividades.fechaCreacion", "Desc");
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	function consultarActSiniestros($poliza, $folioSiniestros)
	{
		$this->db->from("actividades");
		$this->db->where("poliza ='" . $poliza . "' && folioActividadSiniestros ='" . $folioSiniestros . "'");
		//$this->db->where("actividades.poliza",$poliza);
		//$this->db->where("actividades.folioActividadSiniestros",$folioSiniestros);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	function validacionFolioActividad($folioActividad)
	{
		$this->db->from("actividades");
		$this->db->where("actividades.folioActividad", $folioActividad);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}/*! validacionFolioActividad */

	function infoFolioActividad($folioActividad)
	{
		$this->db->from("actividades");
		$this->db->where("actividades.folioActividad", $folioActividad);
		$this->db->where("actividades.inicio", "0");
		//$this->db->order_by("actividades.fechaCreacion","Desc");
		$query = $this->db->get();

		if ($query->num_rows() > 0) {

			$row = $query->row();
			$row->pagoFormas = "";
			$row->pagoConducto = "";
			if ($row->idPagoFormas != '' && $row->idPagoFormas != 0) {
				$consulta = "select * from pagoformas where idPagoFormas=" . $row->idPagoFormas;
				$pagoFormas = $this->db->query($consulta)->result();
				$row->pagoFormas = $pagoFormas[0]->pagoFormas;
			}
			if ($row->idPagoConducto != '' && $row->idPagoConducto != 0) {
				$consulta = "select * from pagoconducto where idPagoConducto=" . $row->idPagoConducto;
				$pagoConducto = $this->db->query($consulta)->result();
				$row->pagoConducto = $pagoConducto[0]->pagoConducto;
			}
		} else {
			$row = "";
		}

		return
			$row;
	} /*! infoFolioActividad */

	function infoFolioActividadEmi($folioActividad)
	{
		$this->db->from("actividades");
		$this->db->where("actividades.folioActividad", $folioActividad);
		$this->db->where("actividades.inicio", "1");
		//$this->db->order_by("actividades.fechaCreacion","Desc");
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$row = $query->row();
		} else {
			$row = "";
		}

		return
			$row;
	} /*! infoFolioActividadEmi */


	/*--*/
	function SelectActividad($arrayPermisos, $user = '')
	{ // $arrayPermisos
?>
		<script>
			function selectTipoActividad(tipo) {
				window.open('<?= base_url() ?>actividades/agregar/' + tipo, '_self');
			}
		</script>
		<?php
		$this->db->from("catalog_actividades");
		$this->db->where("activo", "0");

		$this->db->where("`permiso` Is Null");
		if (count($arrayPermisos) > 0) {
			foreach ($arrayPermisos as $permiso) {
				$permisoTexto = $permiso['modulo'] . "-";
				$permisoTexto .= $permiso['subModulo'] . "-";
				$permisoTexto .= $permiso['accion'] . "-";
				$permisoTexto .= $permiso['permiso'];
				$this->db->or_where("`permiso` = '" . $permisoTexto . "'");
			}
		}

		$this->db->order_by("orden", "asc");
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$return = '<select
						name = "tipoActividad"
						id = "tipoActividad"
						onchange = "selectTipoActividad(this.value)"
						class="form-control input-sm"
					   >';
			$return .= '<option value="">-- Seleccione --</option>';
			foreach ($query->result() as $row) {
				if ($row->alias != "Pago con Tarjeta/Domiciliar") {
					if (!($user == "")) {
						if ($user == "CLIENTECORPORATIVO") {
							if ($row->idActividad != 4 && $row->idActividad != 9 && $row->idActividad != 12 && $row->idActividad != 15 && $row->idActividad != 16) {
								$return .= '<option value="' . $row->nombre . '">' . $row->alias . '</option>';
							}
						}
					} else {
						$return .= '<option value="' . $row->nombre . '">' . $row->alias . '</option>';
					}
				}
			}
			$return .= '</select>';

			return
				$return;
			//$arrayPermisos;
		}
	} /*! SelectActividad */

	function SelectTipoEndoso($actividad)
	{
		if ($actividad == "Endoso") {
			$sql_CatalogEndosos = "
				Select * From 
					`catalog_endosos`
				Order By
					`tipo` Asc
								";
		}

		$query = $this->db->query($sql_CatalogEndosos);
		if ($query->num_rows() > 0) {

			$return = '<select
						name = "tipoEndoso"
						id = "tipoEndoso"
						class="form-control input-sm"
						onchange="selecTipoEndoso(this.value);"
						required
					   >';
			$return .= '<option value="">-- Seleccione --</option>';
			foreach ($query->result() as $row) {

				//if($this->uri->segment(4) == $row->Abreviacion){ $selected = 'selected="selected"'; } else { $selected = '';}

				$return .= '<option value="' . $row->tipo . '">' . $row->descripcion . '</option>';
			}
			$return .= '</select>';

			return
				$return;
		}
	}

	function SelectRamo($tipoActividad, $arrayPermisos, $user = '')
	{
		?>
		<script>
			function selectTipoRamo(tipoActividad, tipoRamo) {
				window.open('<?= base_url() ?>actividades/agregar/' + tipoActividad + '/' + tipoRamo, '_self');
			}
		</script>
		<?php

		if ($tipoActividad != "Cotizacion" && $tipoActividad != "Sustitucion" && $tipoActividad != "Fianzas") {
			$sql_CatalogRamos = "
				Select * From 
					`catalog_ramos`
				Order By
					`orden` Asc
								";
		} else if ($tipoActividad == "Cotizacion") {

			if (count($arrayPermisos) > 0) {
				$where = "";
				$whereArray = array();
				if (in_array("VEHICULOS", $arrayPermisos)) {
					$where .= "`Abreviacion` = 'VEHICULOS'";
					$whereArray[] .= "`Abreviacion` = 'VEHICULOS'";
				}
				if (in_array("ACCIDENTES_Y_ENFERMEDADES", $arrayPermisos)) {
					$where .= "`Abreviacion` = 'ACCIDENTES_Y_ENFERMEDADES'";
					$whereArray[] .= "`Abreviacion` = 'ACCIDENTES_Y_ENFERMEDADES'";
				}
				if (in_array("DANOS", $arrayPermisos)) {
					$where .= "`Abreviacion` = 'DANOS'";
					$whereArray[] .= "`Abreviacion` = 'DANOS'";
				}
				if (in_array("VIDA", $arrayPermisos)) {
					$where .= "`Abreviacion` = 'VIDA'";
					$whereArray[] .= "`Abreviacion` = 'VIDA'";
				}
				if (in_array("FIANZAS", $arrayPermisos)) {
					$where .= "`Abreviacion` = 'FIANZAS'";
					$whereArray[] .= "`Abreviacion` = 'FIANZAS'";
				}
				if (count($whereArray) == 1) {
					$where;
				} else if (count($whereArray) > 0) {
					$where = implode(" Or ", $whereArray);
				} else {
					$where = "`Abreviacion` = '0'";
				}
			} else {
				$where = "1";
			}

			$sql_CatalogRamos = "
				Select * From 
					`catalog_ramos`
				Where
					" . $where . " and activo=0
				Order By
					`orden` Asc
								";
		} else if ($tipoActividad == "Sustitucion") {

			$sql_CatalogRamos = "
				Select * From 
					`catalog_ramos`

				Order By
					`orden` Asc
								";
		} else if ($tipoActividad == "Fianzas") {

			$sql_CatalogRamos = "
				Select * From 
					`catalog_ramos`
				Where
					`descripcion` = 'RamoFianzas'
				Order By
					`orden` Asc
								";
		}

		$query = $this->db->query($sql_CatalogRamos);
		if ($query->num_rows() > 0) {
			$return = '<select
						name = "tipoRamo"
						id = "tipoRamo"
						onchange = "selectTipoRamo(\'' . $tipoActividad . '\', this.value)"
						class="form-control input-sm"
					   >';
			$return .= '<option value="">-- Seleccione --</option>';
			foreach ($query->result() as $row) {
				if ($this->uri->segment(4) == $row->Abreviacion) {
					$selected = 'selected="selected"';
				} else {
					$selected = '';
				}
				if ($user != '') {
					if ($user == "CLIENTECORPORATIVO") {
						if ($row->IDRamo == 1 || $row->IDRamo == 2 || $row->IDRamo == 3) {
							$return .= '<option value="' . $row->Abreviacion . '" ' . $selected . '>' . $row->Nombre . '</option>';
						}
					}
				} else {
					$return .= '<option value="' . $row->Abreviacion . '" ' . $selected . '>' . $row->Nombre . '</option>';
				}
			}
			$return .= '</select>';

			return
				$return;
		}
	} /*! SelectRamo */
	function subRamos($tipoActividad, $tipoRamo)
	{
		//$this->db->select("IDRamo,Nombre");	
		$this->db->from("catalog_ramos");
		$this->db->join("catalog_subRamos", "catalog_ramos.IDRamo = catalog_subRamos.IDRamo", "inner");
		$this->db->where("catalog_ramos.Abreviacion", $tipoRamo);
		$this->db->where("catalog_subRamos.activo", "0");
		$this->db->order_by("catalog_subRamos.orden", "asc");
		$query = $this->db->get();
		return $query;
	}
	function SelectSubRamo($tipoActividad, $tipoRamo)
	{
		?>
		<script>
			function selectTipoSubRamo(tipoActividad, tipoRamo, tipoSubRamo) {
				window.open('<?= base_url() ?>actividades/agregar/' + tipoActividad + '/' + tipoRamo + '/' + tipoSubRamo, '_self');
			}
		</script>
		<?php

		$this->db->from("catalog_ramos");
		$this->db->join("catalog_subRamos", "catalog_ramos.IDRamo = catalog_subRamos.IDRamo", "inner");
		$this->db->where("catalog_ramos.Abreviacion", $tipoRamo);
		$this->db->where("catalog_subRamos.activo", "0");

		$this->db->order_by("catalog_subRamos.orden", "asc");
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$return = '<select
						name = "tipoRamo"
						id = "tipoRamo1"
						onchange = "selectTipoSubRamo(\'' . $tipoActividad . '\',\'' . $tipoRamo . '\', this.value)"
						class="form-control input-sm"
					   >';

			$return .= '<option value="">-- Seleccione --</option>';
			foreach ($query->result() as $row) {
				if (urldecode($this->uri->segment(5)) == $row->IDSRamo) {
					$selected = 'selected="selected"';
				} else {
					$selected = '';
				}
				$return .= '<option value="' . $row->IDSRamo . '" ' . $selected . '>' . $row->Nombre . '</option>';
			}
			$return .= '</select>';


			return
				$return;
		}
	} /*! SelectSubRamo */

	function SelectCliente($tipoActividad, $tipoRamo, $tipoSubRamo)
	{
		?>
		<script>
			function selectTipoCliente(tipoActividad, tipoRamo, tipoSubRamo, tipoCliente) {
				window.open('<?= base_url() ?>actividades/agregar/' + tipoActividad + '/' + tipoRamo + '/' + tipoSubRamo + '/' + tipoCliente, '_self');
			}
		</script>
		<?php
		switch ($this->uri->segment(6)) {
			case "Nuevo":
				$selectedNuevo		= 'selected="selected"';
				$selectedExistente	= '';
				break;

			case "Existente":
				$selectedNuevo		= '';
				$selectedExistente	= 'selected="selected"';
				break;

			default:
				$selectedNuevo		= '';
				$selectedExistente	= '';
				break;
		}

		$return = '<select
						name = "tipoCliente"
						id = "tipoCliente"
						onchange = "selectTipoCliente(\'' . $tipoActividad . '\',\'' . $tipoRamo . '\',\'' . $tipoSubRamo . '\', this.value)"
						class="form-control input-sm"
					   >';

		$return .= '<option value="">-- Seleccione --</option>';

		if ($this->uri->segment(3) == 'Cotizacion' || $this->uri->segment(3) == 'Emision' || $this->uri->segment(3) == 'CapturaEmision' || $this->uri->segment(3) == 'CambiodeConducto') {
			//$return.= '<option value="Nuevo" '.$selectedNuevo.'>Nuevo</option>';
		}

		$return .= '<option value="Existente" ' . $selectedExistente . '>Existente</option>';

		$return .= '</select>';

		return
			$return;
	} /*! SelectCliente */

	function SelectEntidad($tipoActividad, $tipoRamo, $tipoSubRamo, $tipoCliente)
	{
		?>
		<script>
			function selectTipoEntidad(tipoActividad, tipoRamo, tipoSubRamo, tipoCliente, tipoEntidad) {
				window.open('<?= base_url() ?>actividades/agregar/' + tipoActividad + '/' + tipoRamo + '/' + tipoSubRamo + '/' + tipoCliente + '/' + tipoEntidad, '_self');
			}
		</script>
<?php
		switch ($this->uri->segment(7)) {
			case "Moral":
				$selectedFisica	= '';
				$selectedMoral 	= 'selected="selected"';
				break;

			case "Fisica":
				$selectedFisica	= 'selected="selected"';
				$selectedMoral 	= '';
				break;

			default:
				$selectedFisica	= '';
				$selectedMoral 	= '';
				break;
		}

		$return = '<select
						name = "tipoEntidad"
						id = "tipoEntidad"
						onchange = "selectTipoEntidad(\'' . $tipoActividad . '\',\'' . $tipoRamo . '\',\'' . $tipoSubRamo . '\',\'' . $tipoCliente . '\', this.value)"
						class="form-control input-sm"						
					   >';

		$return .= '<option value="">-- Seleccione --</option>';
		$return .= '<option value="Fisica" ' . $selectedFisica . '>Fisica</option>';
		$return .= '<option value="Moral" ' . $selectedMoral . '>Moral</option>';

		$return .= '</select>';

		return
			$return;
	} /*! SelectEntidad */
	//-------------------------------------------	
	function SelectVendedor($idVendedor, $superior, $tipoProfile)
	{

		if ($idVendedor == 0) {
			$idVendedor = "";
		}

		switch ($tipoProfile) {
			case "1": // Vendedor
				$this->db->from("catalog_vendedores");
				$this->db->where("catalog_vendedores.Status", "0");
				$this->db->where("catalog_vendedores.IDVend", $idVendedor);
				$consulta = 'select trim(c.NombreCompleto) as nombreSinCaracteres,c.* from catalog_vendedores c where c.`Status`=0 and c.NombreCompleto!="" and c.IDVend=' . $idVendedor;
				break;

			case "2": // Promotor
				$this->db->from("catalog_vendedores");
				$this->db->where("catalog_vendedores.Status", "0");
				$this->db->where("catalog_vendedores.IDVendNS = " . $superior . " Or catalog_vendedores.IDVend = " . $idVendedor);
				$consulta = 'select trim(c.NombreCompleto) as nombreSinCaracteres,c.* from catalog_vendedores c where c.`Status`=0 and c.NombreCompleto!="" and c.IDVend=' . $idVendedor . ' and c.IDVendNS=' . $superior;
				break;

			case "3":
				$this->db->from("catalog_vendedores");
				$this->db->where('catalog_vendedores.Status', '0');
				$consulta = 'select trim(c.NombreCompleto) as nombreSinCaracteres,c.* from catalog_vendedores c where c.`Status`=0 and c.NombreCompleto!=""';
				break; // Operativo
			case "4":
				$this->db->from("catalog_vendedores");
				$this->db->where('catalog_vendedores.Status', '0');
				$consulta = 'select trim(c.NombreCompleto) as nombreSinCaracteres,c.* from catalog_vendedores c where c.`Status`=0 and c.NombreCompleto!=""';
				break; // Master
			case "5": // Nube
				$this->db->from("catalog_vendedores");
				$this->db->where('catalog_vendedores.Status', '0');
				$consulta = 'select trim(c.NombreCompleto) as nombreSinCaracteres,c.* from catalog_vendedores c where c.`Status`=0 and c.NombreCompleto!=""';
				break;
			default:
				$this->db->from("catalog_vendedores");
				$this->db->where('catalog_vendedores.Status', '0');
				$consulta = 'select trim(c.NombreCompleto) as nombreSinCaracteres,c.* from catalog_vendedores c where c.`Status`=0 and c.NombreCompleto!=""';

				break;
		}

		$this->db->order_by("catalog_vendedores.NombreCompleto", "asc");
		//$query = $this->db->get();
		$query = $this->db->query($consulta . ' order by nombreSinCaracteres');
		//
		$return = '';
		//$return='<input type="text" class="form-control input-sm" placeholder="FILTRO DE AGENTES" onchange="filtrarSelectVendedor(this.value)" onfocus="desplegarVendedor()" onblur="comprimirVendedor()"  onkeydown="filtrarSelectVendedor(this.value)">';
		$return .= '<div class="row"><div class="col-md-2 col-sm-2 col-xs-2"><input type="text" class="form-control input-sm" placeholder="FILTRO DE AGENTES" onchange="filtrarSelectVendedor(this.value)"  onkeydown="filtrarSelectVendedor(this.value)" id="filtroIDVend"></div>';
		//$return.='<datalist id="listamascotas" class="form-control input-sm"><label for="IDVend">O eligela de la siguiente lista:</label>';
		//$return.='<input type="text" class="form-control input-sm" placeholder="FILTRO DE AGENTES" list="datalistVendedor"><datalist id="datalistVendedor"';
		if ($query->num_rows() > 0) {
			$return .= '<div class="col-md-10 col-sm-10 col-xs-10"><select name = "IDVend" id = "IDVend" class="form-control input-sm" required="required" onchange="cambiaVen(this)" >';
			$return .= '<option value="" >-- Seleccione --</option>';
			foreach ($query->result() as $row) {
				if ($row->idPersona != "") {
					$ranking = "";
					$urgentes = "";
					$canal = "";
					$datosAdicionales = $this->db->query("select p.idpersonarankingagente,u.NumUrgentes,cc.nombreTitulo,pta.personaTipoAgente from persona p left join catalog_canales cc on cc.IdCanal=p.id_catalog_canales left join users u on u.idPersona=p.idPersona left join personatipoagente pta on pta.idPersonaTipoAgente=p.personaTipoAgente where p.idPersona=" . $row->idPersona)->result();

					$ranking = $datosAdicionales[0]->idpersonarankingagente;
					$urgentes = $datosAdicionales[0]->NumUrgentes;
					$canal = $datosAdicionales[0]->nombreTitulo;
					$tipoAgente = $datosAdicionales[0]->personaTipoAgente;
				}
				if ($row->EMail1 != "") {
					$title = "";
				} else {
					$title = "";
				}
				$selected = ($row->IDVend == $idVendedor) ? 'selected="selected"' : '';
				$return .= '<option value="' . $row->IDVend . '" ' . $selected . 'title="' . $title . '" data-ranking="' . $ranking . '" data-urgentes="' . $urgentes . '" data-canal="' . $canal . '" data-tipoAgente="' . $tipoAgente . '" >' . $row->NombreCompleto . '</option>';
			}
			$return .= '</select></div></div>';

			return $return;
		}
	} /*! SelectVendedor */
	//-----------------------------------------------
	function ArrayVendedor()
	{
		$this->db->select('`IDVend`, `NombreCompleto`');
		$this->db->from("catalog_vendedores");
		$this->db->where('catalog_vendedores.Status', '0');
		$this->db->order_by("catalog_vendedores.NombreCompleto", "asc");
		$query = $this->db->get();

		if ($query->num_rows() > 0) {

			$return = array('0' => '--Seleccione--',);
			foreach ($query->result() as $row) {
				$return[$row->IDVend] = $row->NombreCompleto;
			}
		}
		return
			$return;
	} /*! ArrayVendedor */

	function ArraySubGrupos()
	{
		$this->db->select('`IDSGrupo`, `SubGrupo`');
		$this->db->from("catalog_subGrupos");
		$this->db->where('catalog_subGrupos.activo', '0');
		$this->db->order_by("catalog_subGrupos.orden", "asc");
		$query = $this->db->get();

		if ($query->num_rows() > 0) {

			$return = array('0' => '--Seleccione--',);
			foreach ($query->result() as $row) {
				$return[$row->IDSGrupo] = $row->SubGrupo;
			}
		}
		return
			$return;
	} /*! ArrayVendedor */

	function ArrayGrupos()
	{
		$this->db->select('`IDGrupo`, `Grupo`');
		$this->db->from("catalog_grupos");
		$this->db->where('catalog_grupos.activo', '0');
		$this->db->order_by("catalog_grupos.orden", "asc");
		$query = $this->db->get();

		if ($query->num_rows() > 0) {

			$return = array('0' => '--Seleccione--',);
			foreach ($query->result() as $row) {
				$return[$row->IDGrupo] = $row->Grupo;
			}
		}
		return
			$return;
	} /*! ArrayGrupos */

	function validacionIdClienteActividad($idCliente) {}/*! validacionIdClienteActividad */

	/*	Ver Lista de Cliente Prospectos SICAS
	*	@Param 
	*	@Return Array
	*/
	function ListaClienteProspecto($busquedaClienteProspecto)
	{
		$wsKeycode = "HDS00002";
		$wsBody['Page'] = "1";
		$wsBody['ItemForPage'] = "150";
		$wsBody['InfoSort'] = "CatClientes.IDCli";
		$wsConditionsAdd =
			"Nombre Completo;0;0;*" . $busquedaClienteProspecto . "*;" . $busquedaClienteProspecto . ";CatClientes.NombreCompleto";
		$wsNodoExtrae = "TableInfo";

		if (isset($busquedaClienteProspecto) && $busquedaClienteProspecto != "") {
			return
				$this->ws_sicasdre->wsreport($wsKeycode, $wsBody, $wsConditionsAdd, $wsNodoExtrae);
		} else {
			return
				false;
		}
	}/*! ListaClienteProspecto */

	/* Ver Detalle Ordenes de Trabajo y Polizas SICAS
	*	@Param
	*	@Return Array
	*/
	function DetalleDocumento($IDDocto)
	{

		$resultado = array(); //NUEVO

		$wsKeycode = "HWS_DOCTOS";
		$wsTipo = "Read_Data";
		$wsTextoPlano = "<InfoData>
							<DatDocumentos>
								<IDDocto>" . $IDDocto . "</IDDocto>
							</DatDocumentos>
						</InfoData>";
		$wsNodoExtrae = "VDatDocumentos";
		$datos = $this->ws_sicasdre->wsdata($wsKeycode, $wsTipo, $wsTextoPlano, $wsNodoExtrae);

		if (isset($datos)) {
			$resultado = $datos;
		}

		return $resultado; //NUEVO  //$datos;
		//htmlspecialchars ($wsTextoPlano);

	}/*! DetalleDocumento */

	/* Ver Detalle Polizas
	*	@Param
	*	@Return Array
	*/
	function DetallePoliza($Documento)
	{

		$wsKeycode = "HWS_DOCTOS";
		$wsBody['Page'] = "1";
		$wsBody['ItemForPage'] = "25";
		$wsBody['InfoSort'] = "DatDocumentos.FHasta Desc";
		$wsConditionsAdd =
			"Documento;0;0;" . $Documento . ";Documento;DatDocumentos.Documento";
		$wsNodoExtrae = "TableInfo";

		return
			//htmlspecialchars ($wsTextoPlano);
			$this->ws_sicasdre->wsreport($wsKeycode, $wsBody, $wsConditionsAdd, $wsNodoExtrae);
	}/*! DetallePoliza */

	/* Ver Detalle Tarea SICAS
	*	@Param
	*	@Return Array
	*/
	function DetalleDocumentoTarea($IDDocto)
	{
		$wsKeycode = "H04245";
		$wsTipo = "Read_Data";
		$wsTextoPlano = "<InfoData>
							<DatTareas>
								<IDTarea>" . $IDDocto . "</IDTarea>
							</DatTareas>
						</InfoData>";
		$wsNodoExtrae = "DatTareas";

		return
			//htmlspecialchars ($wsTextoPlano);
			$this->ws_sicasdre->wsdata($wsKeycode, $wsTipo, $wsTextoPlano, $wsNodoExtrae);
	}/*! DetalleDocumento */

	/* Ver Detalle Cliente SICAS
	*	@Param
	*	@Return Array
	*/
	function DetalleCliente($idCliente)
	{
		$IDCli	= strstr($idCliente, '-', true);
		$IDCont	= substr(strstr($idCliente, "-"), 1);
		$wsKeycode = "H02000";
		$wsTipo = "Read_Data";
		$wsTextoPlano = "
						<InfoData>
							<CatClientes>
								<IDCli>" . $IDCli . "</IDCli>
								<IDCont>" . $IDCont . "</IDCont>
							</CatClientes>
						</InfoData>";
		$wsNodoExtrae = "CatClientes";

		return
			$this->ws_sicasdre->wsdata($wsKeycode, $wsTipo, $wsTextoPlano, $wsNodoExtrae);
		//htmlspecialchars($wsTextoPlano);
	}/*! DetalleCliente */

	function TextoExpresAsteriscos($tipoActividad, $tipoRamo, $tipoSubRamo)
	{
		$this->db->from("catalog_textosExpres");
		$this->db->where("catalog_textosExpres.tipoActividad", $tipoActividad);
		$this->db->where("catalog_textosExpres.tipoRamo", $tipoRamo);
		$this->db->where("catalog_textosExpres.tipoSubRamo", $tipoSubRamo);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			//$row = $query->row();
			return $query;
		} else {
			//$row = "";
			return false;
		}
	} /*! TextoExpresAsteriscos */

	function TextoExpresFormulario($tipoActividad, $tipoRamo, $tipoSubRamo)
	{
		$this->db->from("catalog_textosExpres");
		$this->db->where("catalog_textosExpres.tipoActividad", $tipoActividad);
		$this->db->where("catalog_textosExpres.tipoRamo", $tipoRamo);
		$this->db->where("catalog_textosExpres.tipoSubRamo", $tipoSubRamo);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query;
		} else {
			return false;
		}
	} /*! TextoExpresFormulario */

	function SelectTipoImg($campoImg)
	{
		$this->db->from("catalog_tipoImg");
		$this->db->where('catalog_tipoImg.activo', '0');
		$this->db->order_by("catalog_tipoImg.orden", "asc");
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$return = '<select
						name = "tipoImg_' . $campoImg . '"
						id = "tipoImg_' . $campoImg . '"
						class="form-control input-sm"
					   >';
			$return .= '<option value="">-- Seleccione --</option>';
			foreach ($query->result() as $row) {
				$return .= '<option value="' . $row->nombre . '" >' . $row->nombre . '</option>';
			}
			$return .= '</select>';

			return
				$return;
		}
	} /*! SelectTipoImg */

	/* */

	/*	Crear Cliente Contacto SICAS
	*	
	*/
	function CrearClienteContacto($TipoEnt)
	{
		//$FechaNac = date_format(date_create($this->input->post('fecha_nacimiento', TRUE)), 'd/m/Y');
		//$FechaConst = date_format(date_create($this->input->post('fecha_constitucion', TRUE)), 'd/m/Y');
		$FechaNac = date_format(date_create($this->input->post('fecha_nacimiento', TRUE)), 'Y-m-d');
		$FechaConst = date_format(date_create($this->input->post('fecha_constitucion', TRUE)), 'Y-m-d');

		//si hay espacIOS EN BLANCO DE ULITMO
		$ApellidoP = trim($this->input->post('ApellidoP', TRUE));
		$ApellidoM = trim($this->input->post('ApellidoM', TRUE));
		$Nombres = trim($this->input->post('Nombre', TRUE));


		$wsKeycode = "H02000";
		$wsTipo = "Save_Data";
		if ($TipoEnt == 0) {//<Sexo>" . $this->input->post('Sexo', TRUE) . "</Sexo>
			$wsTextoPlano = "<InfoData>
								<CatContactos>
									<IDCont>-1</IDCont>
									<TipoEnt>0</TipoEnt>
									<TipoEnt_TXT>Fisica</TipoEnt_TXT>
									<ApellidoP>" . $ApellidoP . "</ApellidoP>
									<ApellidoM>" . $ApellidoM . "</ApellidoM>
									<Nombre>" . $Nombres . "</Nombre>
									<FechaNac>" . $FechaNac . "</FechaNac>
									<Sexo_TXT>" . ($this->input->post('Sexo', TRUE) == 0 ? "Masculino" : "Femenino") . "</Sexo_TXT>
									<EMail1>" . $this->input->post('EMail1', TRUE) . "</EMail1>
									<RFC>" . $this->input->post('RFC', TRUE) . "</RFC>
									<Telefono1>Celular|" . $this->input->post('Telefono1', TRUE) . "</Telefono1>
								</CatContactos>
								<CatClientes>
									<IDCli>-1</IDCli>
									<IDCont>-1</IDCont>
									<IDGrupo>1</IDGrupo>
									<IDEjecut>" . $this->input->post('IDEjecut', TRUE) . "</IDEjecut>
									<Calidad>PROSPECTO</Calidad>
									<FieldInt1>" . $this->input->post('IDVend', TRUE) . "</FieldInt1>
									<FieldInt2>1</FieldInt2>
								</CatClientes>
							</InfoData>";
		} else if ($TipoEnt == 1) {
			$wsTextoPlano = "<InfoData>
								<CatContactos>
									<IDCont>-1</IDCont>
									<TipoEnt>1</TipoEnt>
									<TipoEnt_TXT>Moral</TipoEnt_TXT>
									<RFC>" . $this->input->post('RFC', TRUE) . "</RFC>
									<RazonSocial>" . $this->input->post('Nombre', TRUE) . "</RazonSocial>
									<FechaConst>" . $FechaConst . "</FechaConst>
									<EMail1>" . $this->input->post('EMail1', TRUE) . "</EMail1>
									<Telefono1>Celular|" . $this->input->post('Telefono1', TRUE) . "</Telefono1>
								</CatContactos>
								<CatClientes>
									<IDCli>-1</IDCli>
									<IDCont>-1</IDCont>
									<IDGrupo>1</IDGrupo>
									<IDEjecut>" . $this->input->post('IDEjecut', TRUE) . "</IDEjecut>
									<Calidad>PROSPECTO</Calidad>
									<FieldInt1>" . $this->input->post('IDVend', TRUE) . "</FieldInt1>
									<FieldInt2>1</FieldInt2>
								</CatClientes>
							</InfoData>";
		}
		$wsNodoExtrae = "DATAINFO";

		return
			//htmlspecialchars($wsTextoPlano);
			$this->ws_sicasdre->wsdata($wsKeycode, $wsTipo, $wsTextoPlano, $wsNodoExtrae);
	}/*! CrearClienteContacto */

	/*	Crear Orden de Trabajo SICAS
	*	
	*/
	function CrearOt($folioActividad, $idCliente)
	{

		$type = $this->input->post('tipoActividad', TRUE);
		$intIsV3 = strtoupper($type) == "EMISION" ? 0 : 1;
		$fechaEmision = strtoupper($type) == "EMISION" ? "<FEmision>" . date('d/m/Y') . "</FEmision>" : "";

		switch ($this->input->post('tipoActividad', TRUE)) {

			case "CapturaEmision":
				$Concepto	= "CAPTURA EMISION => Capsys Web " . $folioActividad . "//CAPTURA";
				$Documento	= ""; //"<Documento>".$this->input->post('polizaNew',TRUE)."</Documento>";
				$DAnterior	= "";
				break;

			case "CapturaRenovacion":
				$Concepto = "CAPTURA RENOVACION => Capsys Web " . $folioActividad;
				$Documento	= ""; //"<Documento>".$this->input->post('polizaNew',TRUE)."</Documento>";
				$DAnterior	= ""; //"<DAnterior>".$this->input->post('polizaAnt',TRUE)."</DAnterior>";
				break;

			default:
				$Concepto = $this->input->post('tipoActividad', TRUE) . " Capsys Web " . $folioActividad;
				$Documento	= "";
				$DAnterior	= "";
				break;
		}
		//AGREGAMOS QUE CAMBIE EL ID DEL EJECUTIVO  SI ES PARA PORYECTO 100 MOISES ESCAMILLA 24-08-2017
		//EL ID DEL EJECUTIVO DESIGNA  A QUIEN LE CAE EN EL SICAS  se mueve a este nivel porque no lo toma del URI
		if ($this->input->post('IDPcien') > 0) {

			if ($this->input->post('tipoRamo', TRUE) == "ACCIDENTES_Y_ENFERMEDADES" || $this->input->post('tipoRamo', TRUE) == "VIDA") {
				$IDEjecutin	= "3"; // SE VA MONICA PERSONALES
			}
			if ($this->input->post('tipoRamo', TRUE) == "DANOS") {
				$IDEjecutin	= "1"; // SE VA SERGIO DAÑOS Y BIENES
			}
			if ($this->input->post('tipoRamo', TRUE) == "VEHICULOS") {
				$IDEjecutin	= "2"; // SE VA EDUARDO AUTOS
			}
			if ($this->input->post('tipoRamo', TRUE) == "FIANZAS") {
				$IDEjecutin	= "6"; // SE VA ANA FIANZAS
			}
		} else {
			$IDEjecutin = $this->input->post('IDEjecut', TRUE);
		}



		$wsKeycode = "HWCAPTURE";
		$wsTipo = "Save_Data";
		$wsTextoPlano = "<InfoData>
							<DatDocumentos>
								<IDDocto>-1</IDDocto>
								<TipoDocto>" . $this->input->post('TipoDocto', TRUE) . "</TipoDocto>
								" . $Documento . "
								" . $DAnterior . "
								" . $fechaEmision . "
								<IsV3>" . $intIsV3 . "</IsV3>
								<Referencia1>" . $folioActividad . "</Referencia1>
								<IDCli>" . $idCliente . "</IDCli>
								<IDDir>" . $this->input->post('IDDir', TRUE) . "</IDDir>
								<IDGrupo>" . $this->input->post('IDGrupo', TRUE) . "</IDGrupo>
								<IDAgente>" . $this->input->post('IDAgente', TRUE) . "</IDAgente>
								<IDFPago>1</IDFPago>
								<IDMon>1</IDMon>
								<IDSRamo>" . $this->input->post('IDSRamo', TRUE) . "</IDSRamo>
								<IDEjecut>" . $IDEjecutin . "</IDEjecut>
								<IDVend>" . $this->input->post('IDVend', TRUE) . "</IDVend>
								<FDesde>" . date('d/m/Y') . "</FDesde>
								<FHasta>" . date('d/m/Y', strtotime('+1 year', strtotime(date('Y-m-j')))) . "</FHasta>
								<Status>0</Status>
								<Referencia3>" . $this->input->post('tarjetaVerde', TRUE) . "</Referencia3>
								<Referencia4>" . "{$this->input->post('tipoActividad', TRUE)}-{$this->input->post('tipoSubRamo', TRUE)}" . "</Referencia4>
								<StatusUser>5</StatusUser>
								<PrimaNeta>0</PrimaNeta>
								<STotal>0</STotal>
								<PrimaTotal>0</PrimaTotal>
								<Concepto>" . $Concepto . "</Concepto>
								<APDP>0</APDP>
								<CCP>0</CCP>
								<CCE>0</CCE>
							</DatDocumentos>
							<DatDoctoDetail>
								<IDInc>-1</IDInc>
							</DatDoctoDetail>
						</InfoData>";
		$wsNodoExtrae = "DATAINFO";

		//

		return $this->ws_sicasdre->wsdataPruebas($wsKeycode, $wsTipo, $wsTextoPlano, $wsNodoExtrae);
		//** htmlspecialchars($wsTextoPlano);
	}/*! CrearOt */

	/*	Crear Tarea SICAS
	*	
	*/
	function CrearTarea($FolioNo, $IDCont, $Titulo, $Descripcion, $IDUserR, $IDTTarea, $Poliza = null)
	{
		$quitar	= array(
			'<p>',
			'</p>',
			'<br />',
			'<br>',
			'&nbsp;',
			'&Ntilde;',
			'&ntilde;',
			'&iquest;',
			'&iexcl;',
			'&aacute;',
			'&eacute;',
			'&iacute;',
			'&oacute;',
			'&uacute;',
			'&Aacute;',
			'&Eacute;',
			'&Iacute;',
			'&Oacute;',
			'&Uacute;',
			'&agrave;',
			'&egrave;',
			'&igrave;',
			'&ograve;',
			'&ugrave;',
			'&Agrave;',
			'&Egrave;',
			'&Igrave;',
			'&Ograve;',
			'&Ugrave;',
		);
		$poner	= array(
			'',
			'',
			'\r\n',
			'\r\n',
			'',
			'Ñ',
			'ñ',
			'¿',
			'¡',
			'á',
			'é',
			'í',
			'ó',
			'ú',
			'Á',
			'É',
			'Í',
			'Ó',
			'Ú',
			'à',
			'è',
			'ì',
			'ò',
			'ù',
			'À',
			'È',
			'Ì',
			'Ò',
			'Ù',
		);
		$wsKeycode = "H04245";
		$wsTipo = "Save_Data";
		$wsTextoPlano = "<InfoData>
							<DatTareas>
								<IDTarea>-1</IDTarea>
								<FolioNo>" . $FolioNo . "</FolioNo>
								<IDCont>" . $IDCont . "</IDCont>
    							<IDContacto>0</IDContacto>
			    				<IDDir>0</IDDir>
								<Titulo>" . $Titulo . "</Titulo>
								<FInicio>" . date('d/m/Y') . "</FInicio>
								<FPromesa>" . date('d/m/Y') . "</FPromesa>
								<Descripcion>" . str_replace($quitar, $poner, $Descripcion) . "</Descripcion>
								<IDCategoria>1</IDCategoria>
						    	<IDPrioridad>1</IDPrioridad>
								<Status>5</Status>
								<IDUserR>" . $IDUserR . "</IDUserR>
								<IDTTarea>" . $IDTTarea . "</IDTTarea>
								<Poliza>" . $Poliza . "</Poliza>
							</DatTareas>					
						</InfoData>";
		$wsNodoExtrae = "DATAINFO";
		//$datos=;

		return $this->ws_sicasdre->wsdataPruebas($wsKeycode, $wsTipo, $wsTextoPlano, $wsNodoExtrae);
		//htmlspecialchars($wsTextoPlano);

	}/*! CrearTarea */

	function CambiaStatusUser($IDDocto, $StatusUser)
	{
		$wsKeycode = "HWCAPTURE";
		$wsTipo = "Save_Data";
		$wsTextoPlano = "<InfoData>
							<DatDocumentos>
								<IDDocto>" . $IDDocto . "</IDDocto>
								<StatusUser>" . $StatusUser . "</StatusUser>
							</DatDocumentos>
						</InfoData>";
		$wsNodoExtrae = "DATAINFO";

		return
			$this->ws_sicasdre->wsdata($wsKeycode, $wsTipo, $wsTextoPlano, $wsNodoExtrae);
	}/*! CambiaStatusUser */

	function CambiaStatusUserTarea($IDTarea, $Status)
	{
		$wsKeycode = "H04245";
		$wsTipo = "Save_Data";
		$wsTextoPlano = "<InfoData>
							<DatTareas>
								<IDTarea>" . $IDTarea . "</IDTarea>
								<Status>" . $Status . "</Status>
							</DatTareas>
						</InfoData>";
		$wsNodoExtrae = "DATAINFO";

		return
			$this->ws_sicasdre->wsdata($wsKeycode, $wsTipo, $wsTextoPlano, $wsNodoExtrae);
		//htmlspecialchars($wsTextoPlano);
	}/*! CambiaStatusUserTarea */

	function CambiaStatusEmision($IDDocto, $StatusUser, $Concepto)
	{
		$wsKeycode = "HWCAPTURE";
		$wsTipo = "Save_Data";
		$wsTextoPlano = "<InfoData>
							<DatDocumentos>
								<IDDocto>" . $IDDocto . "</IDDocto>
								<StatusUser>" . $StatusUser . "</StatusUser>
								<Concepto>" . $Concepto . "</Concepto>
								<TipoDocto>1</TipoDocto>
							</DatDocumentos>
						</InfoData>";
		$wsNodoExtrae = "DATAINFO";

		return
			$this->ws_sicasdre->wsdata($wsKeycode, $wsTipo, $wsTextoPlano, $wsNodoExtrae);
	}/*! CambiaStatusEmision */

	function UpdateDocumento($IDDocto, $nodosUpdate)
	{

		$wsKeycode = "HWCAPTURE";
		$wsTipo = "Save_Data";
		$wsTextoPlano = "<InfoData>
							<DatDocumentos>
								<IDDocto>" . $IDDocto . "</IDDocto>";
		foreach ($nodosUpdate as $nodo) {
			$wsTextoPlano .= $nodo;
		}
		$wsTextoPlano .= "</DatDocumentos>
						</InfoData>";
		$wsNodoExtrae = "DATAINFO";

		return
			//**htmlspecialchars($wsTextoPlano);
			$this->ws_sicasdre->wsdata($wsKeycode, $wsTipo, $wsTextoPlano, $wsNodoExtrae);
	}/*! UpdateDocumento */


	/*
	*	Crear Bitacoras SICAS
	*	@Param
	*	@Param
	*	@Param
	*	@return
	*/
	function CrearBitacora($ClaveBit, $Procedencia, $Comentario, $IDDocto = 0)
	{
		$quitar	= array(
			'<p>',
			'</p>',
			'<br />',
			'<br>',
			'&nbsp;',
			'&acute;',
			'&quot;',
			'&uml;',
			'&Ntilde;',
			'&ntilde;',
			'&iquest;',
			'&iexcl;',
			'&uuml;',
			'&Uuml;',
			'&aacute;',
			'&eacute;',
			'&iacute;',
			'&oacute;',
			'&uacute;',
			'&Aacute;',
			'&Eacute;',
			'&Iacute;',
			'&Oacute;',
			'&Uacute;',
			'&agrave;',
			'&egrave;',
			'&igrave;',
			'&ograve;',
			'&ugrave;',
			'&Agrave;',
			'&Egrave;',
			'&Igrave;',
			'&Ograve;',
			'&Ugrave;',
			'&lt;',
			'&gt;',
		);
		$poner	= array(
			'',
			'',
			'\r\n',
			'\r\n',
			'',
			'',
			'',
			'',
			'Ñ',
			'ñ',
			'¿',
			'¡',
			'u',
			'U',
			'á',
			'é',
			'í',
			'ó',
			'ú',
			'Á',
			'É',
			'Í',
			'Ó',
			'Ú',
			'à',
			'è',
			'ì',
			'ò',
			'ù',
			'À',
			'È',
			'Ì',
			'Ò',
			'Ù',
			'<',
			'>',
		);

		$wsKeycode = "H04270";
		$wsTipo = "Save_Data";
		$wsTextoPlano = "<InfoData>
							<DatBitacora>
								<IDBit>-1</IDBit>
								<ClaveBit>" . $ClaveBit . "</ClaveBit>
								<Prioridad>1</Prioridad>
								<Procedencia>" . $Procedencia . "</Procedencia>
								<Comentario>" . str_replace($quitar, $poner, $Comentario) . "</Comentario>
								<IDDocto>" . $IDDocto . "</IDDocto>
							</DatBitacora>
						</InfoData>";
		$wsNodoExtrae = "DATAINFO";

		return
			$this->ws_sicasdre->wsdata($wsKeycode, $wsTipo, $wsTextoPlano, $wsNodoExtrae);
		//htmlspecialchars($wsTextoPlano);
	}/*! CrearBitacora */

	function CargarDocumento($TypeDestinoCDigital, $IDValuePK, $ListFilesURL, $FolderDestino, $Cliente=null)
	{
		$wsBody['TypeDestinoCDigital']	= $TypeDestinoCDigital;
		$wsBody['IDValuePK']			= $IDValuePK;
		$wsBody['ListFilesURL']			= $ListFilesURL;
		$wsBody['FolderDestino']		= $FolderDestino;
		if($Cliente!=null){$wsBody['IDCli']		= $Cliente;}
		$wsAction = "PUTFiles";
		$wsNodoExtrae = "Datos";
		return $this->ws_sicasdre->wscdigital($wsBody, $wsAction, $wsNodoExtrae);
		//$this->ws_sicasdre->wscdigital($wsBody, $wsAction);	
	}/*! CargarDocumento */

	function actividades_agregarCliente($data) {} /*! actividades_agregarCliente */

	function actividades_agregarGuardar($data)
	{


		if ($data['tipoActividad'] == 'Emision') {
			$consulta = "select AES_ENCRYPT('" . $data['tarjetaNumero'] . "','" . $data['folioActividad'] . "AC') as tarjeta, AES_ENCRYPT('" . $data['tarjetaCcv'] . "','" . $data['folioActividad'] . "AC') as codigo";
			$datos = $this->db->query($consulta)->result();
			$data['tarjetaNumero'] = "";
			$data['tarjetaCcv'] = "";
			$data['tarjetaNumeroEncriptado'] = $datos[0]->tarjeta;
			$data['tarjetaCodigoSeguridad'] = $datos[0]->codigo;
		}

		$this->db->insert('actividades', $data);
		$this->kpi_automaticos->kpiAutomatico($data, 'actividades');
	} /*! actividades_agregarGuardar */

	/* */
	/*	Ver Lista de Cliente Prospectos SICAS
	*	@Param 
	*	@Return Array
	*/
	function InfoBitacoras($claveBit)
	{
		$wsKeycode = "HWS_BITACORA";
		$wsBody['Page'] = "1";
		$wsBody['ItemForPage'] = "100";
		$wsBody['InfoSort'] = "DatBitacora.FechaHora Desc"; //"DatBitacora.IDBit Desc";
		$wsConditionsAdd =
			"Bitacora;0;0;" . $claveBit . ";Tarea;DatBitacora.ClaveBit";
		$wsNodoExtrae = "TableInfo";

		return
			$this->ws_sicasdre->wsreport($wsKeycode, $wsBody, $wsConditionsAdd, $wsNodoExtrae);
	}/*! InfoBitacoras */

	function InfoDocumento($TypeDestinoCDigital, $IDValuePK)
	{
		$wsBody['TypeDestinoCDigital']	= $TypeDestinoCDigital;
		$wsBody['IDValuePK']			= $IDValuePK;
		$wsBody['ListFilesURL']			= "";
		$wsBody['FolderDestino']		= "";
		$wsAction = "GETFiles";
		$wsNodoExtrae = "Datos";
		return
			$this->ws_sicasdre->wscdigital($wsBody, $wsAction, $wsNodoExtrae);
	}/*! InfoDocumento */

	function GuardarSatisfaccion($folioActividad, $satisfaccion, $tipoActividad)
	{

		if ($tipoActividad != "Emision") {
			$data['satisfaccion'] = $satisfaccion;
			/*================================LOCM 21/06/2018===================================*/
			if ($satisfaccion == "malo") {
				/*$insertCorreo="insert into envio_correos(fechacreacion,desde,para,copia,copiaoculta,asunto,mensaje,status,fechaenvio)";
			$insertCorreo=$insertCorreo.'values(now(), "Buzon de quejas<avisosgap@aserorescpital.com>","directorgeneral@agentecapital.com" ,0,0,"Actividad calificada mala",CONCAT("la actividad ['.$folioActividad.'] fue calificada de mala"),0,now());';
			  $this->db->query($insertCorreo);

			  		$insertCorreo="insert into envio_correos(fechacreacion,desde,para,copia,copiaoculta,asunto,mensaje,status,fechaenvio)";
			$insertCorreo=$insertCorreo.'values(now(), "Buzon de quejas<avisosgap@aserorescpital.com>","auditorinterno@agentecapital.com" ,0,0,"Actividad calificada mala",CONCAT("la actividad ['.$folioActividad.'] fue calificada de mala"),0,now());';
			  $this->db->query($insertCorreo);*/
				$correos = $this->db->query('select u.email from personapermisorelacion ppr left join users u on u.idPersona=ppr.idPersona where ppr.idPersonaPermiso=6')->result();
				$insertCorreoBase = "insert into envio_correos(fechacreacion,desde,para,copia,copiaoculta,asunto,mensaje,status,fechaenvio,identificaModulo)";

				foreach ($correos as $value) {

					$insertCorreo = $insertCorreoBase . 'values(now(), "Buzon de quejas<avisosgap@aserorescpital.com>","' . $value->email . '",0,0,"Actividad calificada mala",CONCAT("la actividad [' . $folioActividad . '] fue calificada de mala por:","' . $_GET['comentario'] . '"),0,now(),"Actividad Calificada Mala");';
					$this->db->query($insertCorreo);
				}
				/*Modificación Edwin 24/05/2024*/
				//BUSCAR CORREOS DEL RESPONSABLE Y JEFE DIRECTO Y CONCATENARLOS EN EL ARRAY 
				$correoResponsable = $this->db->query("select `usuarioResponsable` as email FROM `actividades` WHERE `folioActividad`='" . $folioActividad . "';")->result();
				$puestoPadre = $this->db->query("select `padrePuesto` FROM `personapuesto` WHERE `email`='" . $correoResponsable[0]->email . "';")->result();
				$correoJefeDirecto = $this->db->query("select `email` FROM `personapuesto` WHERE `idPuesto`=" . $puestoPadre[0]->padrePuesto . ";")->result();


				$insertCorreoResponsable = $insertCorreoBase . 'values(now(), "Buzon de quejas<avisosgap@aserorescpital.com>","' . $correoResponsable[0]->email . '",0,0,"Actividad calificada mala",CONCAT("la actividad [' . $folioActividad . '] fue calificada de mala por:","' . $_GET['comentario'] . '"),0,now(),"Actividad Calificada Mala");';
				$this->db->query($insertCorreoResponsable);

				$correoJefe = $insertCorreoBase . 'values(now(), "Buzon de quejas<avisosgap@aserorescpital.com>","' . $correoJefeDirecto[0]->email . '",0,0,"Actividad calificada mala",CONCAT("la actividad [' . $folioActividad . '] fue calificada de mala por:","' . $_GET['comentario'] . '"),0,now(),"Actividad Calificada Mala");';
				$this->db->query($correoJefe);
				/*================================LOCM 21/06/2018===================================*/
			}
		} else {
			$data['satisfaccionEmision'] = $satisfaccion;
		}
		if ($satisfaccion == "malo") {
			$data['comentarioActividad'] = $_GET['comentario'];
		}
		$this->db->where('actividades.folioActividad', $folioActividad);
		$this->db->update('actividades', $data);
	}/*! GuardarSatisfaccion */
	//------------------------------------------------------------------------------------------	
	function calculaSemaforoActividad($usermail)
	{

		$this->db->from("actividades");
		$this->db->where("(fin != '1' And inicio = '0' And Status != '6' And Status != '7')");
		$this->db->where("usuarioCreacion = '" . $usermail . "'");
		$this->db->where("usuarioCreacion", $usermail);
		$this->db->order_by("actividades.fechaActualizacion", "desc");

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}/*! calculaSemaforoActividad */

	/*
	*	Crear Detalle Cliente SICAS
	*	@Param
	*	@Param
	*	@Param
	*	@return
	*/
	function DetalleCliente_($IDCli)
	{
		$wsKeycode = "H02000";
		$wsTipo = "Read_Data";
		$wsTextoPlano = "<InfoData>
							<CatClientes>
								<IDCli>12194</IDCli>
							</CatClientes>
						</InfoData>";
		$wsNodoExtrae = "CatClientes";

		return
			$this->ws_sicasdre->wsdata($wsKeycode, $wsTipo, $wsTextoPlano, $wsNodoExtrae);
		//htmlspecialchars($wsTextoPlano);
	}/*! DetalleCliente */

	function permiteEmision($param)
	{
		$this->db->from("permiteEmision");
		$this->db->where("DireccionContacto", $param);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	//------------------------------------------------------------------------------------------------------
	function devuelveActCerrar($usermail)
	{

		$consulta = 'update actividades set status=6, notasDre="finalizada automaticamente" ';
		$consulta = $consulta . ' where actividades.fechaCreacion<
(date_add(NOW(), INTERVAL -60 DAY)) and actividades.`Status`=1
and actividades.usuarioCreacion="';
		$consulta = $consulta . $usermail . '"';
		$consulta = 'select (count(actividades.idInterno)) as cont from actividades where actividades.fechaCreacion<
(date_add(NOW(), INTERVAL -55 DAY)) and actividades.`Status`=1
and actividades.usuarioCreacion="';
		$consulta = $consulta . $usermail . '"';
		$datos = $this->db->query($consulta);
		return  $datos->result()[0]->cont;
	}
	//------------------------------------------------------------------------------------------------------
	function buscaComentarios()
	{

		$dato = "";
		$ventana = "";
		$dato = '<button class="btn btn-primary btn-xs contact-item" onclick="document.head.removeChild(document.getElementById(\'divVentanaComentariosEstilo\'));document.body.removeChild(document.getElementById(\'divVentanaComentarios\'))">cerrar</button><br><h1>Comentarios</h1>';
		$dato = $dato . '<input id="textNuevoComentario" type="text"><button class="btn btn-primary" onclick="document.head.removeChild(document.getElementById(\'divVentanaComentariosEstilo\'));direccionAJAX(\'' . $_GET['idProspecto'] . '\',\'nuevoComentario\')">Agregar Comentario</button><br><br><hr>';

		$consulta = "select * from comentarioscitacontacto where statusCCC='1' and tipoCCC=0 and IDCli_CA=" . $_GET['idProspecto'];

		$consulta = $this->db->query($consulta)->result();
		$dato = $dato . '<table border="2"><tr><td>fecha</td><td>Comentario</td><td>Modificar</td><td>Borrar</td></tr>';


		foreach ($consulta as $value) {
			$dato = $dato . '<tr>';
			$dato = $dato . '<td>' . $value->fechaCCC . '</td>';
			$dato = $dato . '<td><textarea id="comentario' . $_GET['idProspecto'] . '-' . $value->idCCC . '">' . $value->comentarioCCC . '</textarea></td>';
			$dato = $dato . '<td><button onclick="document.head.removeChild(document.getElementById(\'divVentanaComentariosEstilo\'));direccionAJAX(\'' . $_GET['idProspecto'] . '-' . $value->idCCC . '\',\'modificaComentario\')" class="btn btn-primary" >M</button></td>';
			$dato = $dato . '<td><button onclick="document.head.removeChild(document.getElementById(\'divVentanaComentariosEstilo\'));direccionAJAX(\'' . $_GET['idProspecto'] . '-' . $value->idCCC . '\',\'eliminaComentario\')" class="btn btn-primary">X</button></td>';
			$dato = $dato . '</tr>';
		}

		$dato = $dato . '</table>';
		$dato = $dato . '<br><br>';
		$ventana['estilo'] = $this->estiloVentana();
		$ventana['datos'] = $dato;

		return $ventana;
	}
	//------------------------------------------------------------------------------------------------------
	function insertaComentario()
	{
		$insertar['IDCli_CA'] = $_GET['idProspecto'];
		$insertar['comentarioCCC'] = $_GET['nuevoComentario'];
		$insertar['tipoCCC'] = 0;
		$this->db->insert('comentarioscitacontacto', $insertar);
	}
	//------------------------------------------------------------------------------------------------------
	function modificaComentario()
	{
		//$this->db->imprimir($_GET,'w');
		$update['comentarioCCC'] = $_GET['modificaComentario'];
		$this->db->where('idCCC', $_GET['idComentario']);
		$this->db->update('comentarioscitacontacto', $update);
		$this->db->where('tabla', 'comentarioscitaconta');
		$this->db->where('idTabla', $_GET['idComentario']);
		$actualiza['titulo'] = $_GET['modificaComentario'];
		$this->db->update('citascalendar', $actualiza);
	}
	//------------------------------------------------------------------------------------------------------
	function eliminaComentario()
	{
		$update['statusCCC'] = 0;
		$this->db->where('idCCC', $_GET['idComentario']);
		$this->db->update('comentarioscitacontacto', $update);
	}
	//------------------------------------------------------------------------------------------------------
	function devuelveVentana()
	{
		$dato = "";
		$dato = '<button class="btn btn-primary btn-xs contact-item" onclick="document.head.removeChild(document.getElementById(\'divVentanaComentariosEstilo\'));document.body.removeChild(document.getElementById(\'divVentanaComentarios\'))">cerrar</button><br><br><h1>Contacto y cita</h1>';
		$dato = $dato . '<label>Fecha:</label><input type="text" id="dpCitaContacto"><br>';
		$dato = $dato . '<label>De:</label><select id="selectFechaDeCC">';
		$deHora = "";
		$inicio = 8;
		for ($i = 0; $i < 12; $i++) {
			$deHora .= '<option>' . $inicio . ':00</option>';
			$deHora .= '<option>' . $inicio . ':30</option>';
			$inicio++;
		}
		$dato .= $deHora . '</select>';
		$dato = $dato . '<label>A:</label><select id="selectFechaACC">';
		$deHora = "";
		$inicio = 8;
		for ($i = 0; $i < 12; $i++) {
			$deHora .= '<option>' . $inicio . ':00</option>';
			$deHora .= '<option>' . $inicio . ':30</option>';
			$inicio++;
		}
		$dato .= $deHora . '</select><br>';

		$dato = $dato . '<label>Tipo:</label><select id="tipoCCC"><option value="1">Primera Cita</option><option value="2">Segunda Cita</option></select><br>';
		$dato = $dato . '<button class="btn btn-primary"  onclick="document.head.removeChild(document.getElementById(\'divVentanaComentariosEstilo\'));direccionAJAX(\'' . $_GET['idProspecto'] . '\',\'guardarCCC\')">Guardar</button>';
		$dato = $dato . '<table border="2"><tr><td>fecha</td><td>Contacto/Cita</td><td>Comentario</td><td>Modificar</td></tr>';
		$consulta = $this->db->query("select *,cast(fechaContactoCitaCCC as date) as fecha from comentarioscitacontacto where (tipoCCC=1 or tipoCCC=2) and idCli_CA=" . $_GET['idProspecto'])->result();
		foreach ($consulta as $value) {
			$dato = $dato . '<tr>';
			$dato = $dato . '<td>' . $value->fecha . '</td>';
			if ($value->tipoCCC == 1) {
				$contactoCita = "Primera Cita";
			} else {
				$contactoCita = "Segunda Cita";
			}
			$dato = $dato . '<td>' . $contactoCita . '</td>';
			$dato = $dato . '<td><textarea id="comentario' . $_GET['idProspecto'] . '-' . $value->idCCC . '">' . $value->comentarioCCC . '</textarea></td>';
			$dato = $dato . '<td><button onclick="document.head.removeChild(document.getElementById(\'divVentanaComentariosEstilo\'));direccionAJAX(\'' . $_GET['idProspecto'] . '-' . $value->idCCC . '\',\'modificaCCC\')" class="btn btn-primary" >M</button></td>';
			$dato = $dato . '</tr>';
		}
		$dato = $dato . '</table><br><br><br>';
		$ventana['estilo'] = $this->estiloVentana();
		$ventana['datos'] = $dato;
		return $ventana;
	}
	//--------------------------------------------------------------------------------------------------------
	function guardarContactoCita()
	{
		$insert['idCli_CA'] = $_GET['idProspecto'];
		$insert['fechaContactoCitaCCC'] = $this->libreriav3->convierteFecha($_GET['citaContacto']);
		$insert['tipoCCC'] = $_GET['tipoCCC'];
		$this->db->insert('comentarioscitacontacto', $insert);
		$last = $this->db->insert_id();

		if ($_GET['tipoCCC'] == "1") { // JJ //		
			//Cambios Edwin Marin
			$puntos = $this->obtenerPuntosProspeccionIndividual("CONTACTO");

			$fecharegistro = (string)date('Y-m-d H:i:s');
			$correoProcedente = $this->tank_auth->get_usermail();
			$FechaContacto = $_GET['citaContacto'];
			$IDCli2 = $_GET['idProspecto'];
			$sqlInsert_Referencia = "Update `clientes_actualiza` set `EstadoActual` = 'CONTACTADO' where `IDCli`='" . $IDCli2 . "'";

			$this->db->query($sqlInsert_Referencia);
			$referencia = $this->db->insert_id();

			$sqlInsert_grabapuntos = "Insert Ignore Into `puntaje` (`Usuario`, `IDCliente`,`FechaRegistro`,`EdoAnterior`,`EdoActual`,`PuntosGenerados`,`FechaContacto` ) Values('" . $correoProcedente . "','" . $IDCli2 . "','" . $fecharegistro . "', 'PERFILADO','CONTACTADO','" . $puntos . "','" . $FechaContacto . "');";
			$this->db->query($sqlInsert_grabapuntos);
			$referencia = $this->db->insert_id();
		}
		if ($_GET['tipoCCC'] == "2") {
			//Cambios Edwin Marin
			$puntos = $this->obtenerPuntosProspeccionIndividual("REGISTRAR");
			$fecharegistro = (string)date('Y-m-d H:i:s');
			$correoProcedente = $this->tank_auth->get_usermail();
			$FechaCita = $_GET['citaContacto'];
			$IDCli3 = $_GET['idProspecto'];
			$sqlInsert_Referencia = "Update `clientes_actualiza` set `EstadoActual` = 'REGISTRADO' where `IDCli`='" . $IDCli3 . "'";
			$this->db->query($sqlInsert_Referencia);
			$referencia = $this->db->insert_id();
			$sqlInsert_grabapuntos = "Insert Ignore Into `puntaje` (`Usuario`, `IDCliente`,`FechaRegistro`,`EdoAnterior`,`EdoActual`,`PuntosGenerados`,`FechaCita`) Values('" . $correoProcedente . "','" . $IDCli3 . "','" . $fecharegistro . "', 'CONTACTADO','REGISTRADO','" . $puntos . "','" . $FechaCita . "');";
			$this->db->query($sqlInsert_grabapuntos);
			$referencia = $this->db->insert_id();
			$this->idCliente = $IDCli3;
			$this->citaRegistrada = 1;
		}
		return $last;
	}

	//------------------------------------------------------------------------------------------------------
	////-----------------------------------------------------------------
	//Cambios Edwin Marin
	public function obtenerPuntosProspeccionIndividual($prospeccion)
	{
		/*persona,permisosOperativos*/
		$consulta = 'select puntosOtorgados from  puntosprospeccion where prospeccion="' . $prospeccion . '"';
		$datos = $this->db->query($consulta);
		$puntos = $datos->result()[0]->puntosOtorgados;
		return $puntos;
	}
	function modificaComentarioCita()
	{
		$update['comentarioCCC'] = $_GET['comentarioCCC'];
		$this->db->where('$idCCC', $_GET['idCCC']);
		$this->db->update('comentariocitacontacto', $update);
	}
	//------------------------------------------------------------------------------------------------------
	function estiloVentana()
	{
		$estilo = '.estilo {border: 4px solid #472380; background-color: white;color:black;position:fixed;top:20%;left:30%;font-size:20px;z-index:100;overflow:scroll;height:50%;width:30%};.linkDocumento{color:black}';
		return $estilo;
	}
	//------------------------------------------------------------------------------------------------------
	function ActividadesImportantes($usermail)
	{
		$consulta	= 'select users.ActCreadaPorOtro from users where users.email="' . $usermail . '"';
		$datos		= $this->db->query($consulta);

		$this->db->from("actividades");
		$this->db->where("(actividades.fin != '1' And actividades.inicio = '0')");
		$this->db->where("(actividadImportante = '1')");
		$this->db->where("(Status != '6')");

		switch ($this->tank_auth->get_userprofile()) {

			case 1:
			case 2:
			case 3:
			case 4:
				$sqlCorreosImportante = "Select `correo`  From  `catalog_correosImportantes` Where 1";
				$queryCorreosImportante = $this->db->query($sqlCorreosImportante);
				foreach ($queryCorreosImportante->result() as $rowCorreo) {
					$correosPermImpor[]	= strtoupper($rowCorreo->correo);
				}
				if (in_array($usermail, $correosPermImpor)) {
					// $this->db->where("(usuarioCreacion = '".$usermail."')");
				} else {

					if ($datos->result()[0]->ActCreadaPorOtro == "SI") {
						$this->db->where("(usuarioCreacion = '" . $usermail . "' or usuarioVendedor='" . $usermail . "' )");
					} else if ($datos->result()[0]->ActCreadaPorOtro == "NO") {
						$this->db->where("(usuarioCreacion = '" . $usermail . "')");
					} else {
						$this->db->where("(usuarioCreacion = '" . $usermail . "')");
					}
				}
				break;
			case 5:
				$this->db->where("(usuarioCreacion = '" . $usermail . "' And actividadImportante = '1' )
								Or
								(usuarioBloqueo = '" . $usermail . "' And actividadImportante = '1')");
				break;
		}

		$this->db->order_by("actividades.idSicas", "desc");
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query;
		} else {
			return false;
		}
	}
	//------------------------------------------------------------------------------------------------------	
	function SemaforoActividadesJjHe($folioActividad)
	{

		$sqlTipoActividad = "
Select 
	(if(TIMESTAMPDIFF(minute,`act`.`fechaCreacion`,`fechaGrabado`)>=120,'Purple','Green')) As `color`,
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
	`act`.`Status_Txt`,
	`acp`.`status`,
	Min(acp.fechaGrabado) As `fechaGrabado`
From
	`actividades` `act` Left Join `actividadespartidas` `acp` 
	On  
	`act`.`folioActividad` = `acp`.`folioActividad`
Where
	(`act`.`Status_Txt` = 'AGENTE GAP')
	And 
	(`act`.ramoActividad = 'VEHICULOS' OR `act`.ramoActividad='DANOS' OR `act`.ramoActividad='DAÑOS')
	And 
	(`act`.subRamoActividad<>'FLOTILLA DE VEHICULOS')
	And
	(
		`act`.`folioActividad` = '" . $folioActividad . "'
	)
Group By 1,2,3,4,5,6,7,8,9,10,11,12

UNION 

### 2 ###
Select
	(
		if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=120,'Red',
		if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=30,'Orange','Blue'))
	) As `color`,
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
	`act`.`Status_Txt`,
	'5' As `status`,
	now() As `fechaGRabado`
From
	`actividades` `act`
Where
	(`act`.`Status_Txt`='EN CURSO')
	And 
	(`act`.ramoActividad='VEHICULOS' OR `act`.ramoActividad='DANOS' OR `act`.ramoActividad='DAÑOS')
	And 
	(`act`.subRamoActividad<>'FLOTILLA DE VEHICULOS')
	And
	(
		`act`.`folioActividad` = '" . $folioActividad . "'
	)

UNION 

### 3 ###
Select 
	(if(TIMESTAMPDIFF(minute,`act`.`fechaCreacion`,`fechaGrabado`)>=7200,'Purple','Green')) As `color`,
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
	`act`.`Status_Txt`,
	`acp`.`status`,
	Min(`acp`.fechaGrabado) As `fechaGrabado`
From
	`actividades` `act`Left Join `actividadespartidas` `acp` 
	On  
	`act`.`folioActividad` = `acp`.`folioActividad`
Where
	(`act`.`Status_Txt`='AGENTE GAP')
	And 
	(`act`.ramoActividad='VEHICULOS')
	And 
	(`act`.subRamoActividad='FLOTILLA DE VEHICULOS')
	And 
	(`act`.tipoActividad='Cotizacion' or `act`.tipoActividad='Emision')
	And
	(
		`act`.`folioActividad` = '" . $folioActividad . "'
	)
Group BY 
	1,2,3,4,5,6,7,8,9,10,11,12

UNION 
### 4 ###

Select 
	(
		if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=7200,'Red',
		if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=1440,'Orange','Blue'))
	) As `color`,
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
	`act`.`Status_Txt`,
	'5' As `status`,
	now() As `fechaGRabado`
From
	`actividades` `act`
Where
	(`act`.`Status_Txt`='EN CURSO')
	And
	(`act`.ramoActividad='VEHICULOS')
	And 
	(`act`.subRamoActividad='FLOTILLA DE VEHICULOS')
	And 
	(`act`.tipoActividad='Cotizacion' or `act`.tipoActividad='Emision')
	And
	(
		`act`.`folioActividad` = '" . $folioActividad . "'
	)

UNION ### 5 ###

Select 
	(If(TIMESTAMPDIFF(minute,`act`.`fechaCreacion`,`fechaGrabado`)>=4320,'Purple','Green')) As `color`,
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
	`act`.`Status_Txt`,
	`acp`.`status`,
	Min(`acp`.fechaGrabado) As `fechaGrabado`
From
	`actividades` `act` Left Join `actividadespartidas` `acp`
	On  
	`act`.`folioActividad` = `acp`.`folioActividad`
Where
	(`act`.`Status_Txt`='AGENTE GAP')
	And 
	(`act`.ramoActividad='VEHICULOS')
	And 
	(`act`.subRamoActividad='FLOTILLA DE VEHICULOS')
	And 
	(`act`.tipoActividad='Endoso' or `act`.tipoActividad='Cancelacion')
	And
	(
		`act`.`folioActividad` = '" . $folioActividad . "'
	)
Group By 1,2,3,4,5,6,7,8,9,10,11,12

UNION

Select 
	(
		if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=4320,'Red',
		if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=1440,'Orange','Blue'))
	) As `color`,
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
	`act`.`Status_Txt`,
	'5' As `status`,
	now() As `fechaGRabado`
From 
	`actividades` `act`
Where
	(`act`.`Status_Txt`='EN CURSO')
	And 
	(`act`.ramoActividad='VEHICULOS')
	And 
	(`act`.subRamoActividad='FLOTILLA DE VEHICULOS')
	And 
	(`act`.tipoActividad='Endoso' or `act`.tipoActividad='Cancelacion')
	And
	(
		`act`.`folioActividad` = '" . $folioActividad . "'
	)
	
UNION

Select 
	(If(TIMESTAMPDIFF(minute,`act`.`fechaCreacion`,`fechaGrabado`)>=7200,'Purple','Green')) As `color`,
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
	`act`.`Status_Txt`,
	`acp`.`status`,
	Min(acp.fechaGrabado) as fechaGrabado
From
	`actividades` `act` Left Join `actividadespartidas` `acp` 
	On 
	`act`.`folioActividad`=`acp`.`folioActividad`
Where
	(`act`.`Status_Txt`='ASEGURADORA')
	and 
	(`act`.ramoActividad='DANOS' OR `act`.ramoActividad='DAÑOS')
	and 
	(`act`.tipoActividad='Cotizacion' or `act`.tipoActividad='Emision')
	And
	(
		`act`.`folioActividad` = '" . $folioActividad . "'
	)
Group By 1,2,3,4,5,6,7,8,9,10,11,12

UNION

Select 
	(
		if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=7200,'Red',
		if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=1440,'Orange','Blue'))
	) As `color`,
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
	`act`.`Status_Txt`,
	'5' As `status`,
	Now() As `fechaGRabado`
From
	`actividades` `act`
Where
		(`act`.`Status_Txt`='ASEGURADORA')
	And 
		(`act`.ramoActividad='DANOS' OR `act`.ramoActividad='DAÑOS')
	and 
		(`act`.tipoActividad='Cotizacion' or `act`.tipoActividad='Emision')
	AND  
	(
		`act`.`folioActividad` = '" . $folioActividad . "'
	)

UNION

Select 
	(If(TIMESTAMPDIFF(minute,`act`.`fechaCreacion`,`fechaGrabado`)>=4320,'Purple','Green')) As `color`,
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
	`act`.`Status_Txt`,
	`acp`.`status`,
	Min(acp.fechaGrabado) As `fechaGrabado`
From
	`actividades` `act` Left Join `actividadespartidas` `acp` 
	On  
	`act`.`folioActividad` = `acp`.`folioActividad`
Where
	(`act`.`Status_Txt`='ASEGURADORA')
	And
	(`act`.ramoActividad='DANOS' OR `act`.ramoActividad='DAÑOS')
	And
	(`act`.tipoActividad='Endoso' or `act`.tipoActividad='Cancelacion')
	And
	(
		`act`.`folioActividad` = '" . $folioActividad . "'
	)
Group By 1,2,3,4,5,6,7,8,9,10,11,12

UNION

Select 
	(
		if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=4320,'Red',
		if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=1440,'Orange','Blue'))
	) As `color`,
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
	`act`.`Status_Txt`,
	'5' As `status`,
	Now() As `fechaGRabado`
From
	`actividades` `act`
Where
	(`act`.`Status_Txt`='ASEGURADORA')
	And 
	(`act`.ramoActividad='DANOS' OR `act`.ramoActividad='DAÑOS')
	And 
	(`act`.tipoActividad='Endoso' or `act`.tipoActividad='Cancelacion')
	And
	(
		`act`.`folioActividad` = '" . $folioActividad . "'
	)
	
UNION

Select 
	(If(TIMESTAMPDIFF(minute,`act`.`fechaCreacion`,`fechaGrabado`)>=7200,'Purple','Green')) As `color`,
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
	`act`.`Status_Txt`,
	`acp`.`status`,
	Min(acp.fechaGrabado) As `fechaGrabado`
From
	`actividades` `act` Left Join `actividadespartidas` `acp` 
	On
	`act`.`folioActividad`=`acp`.`folioActividad`
Where
	(`act`.`Status_Txt`='AGENTE GAP')
	And 
	(`act`.ramoActividad!='VIDA')
	And 
	(`act`.tipoActividad='Emision' or `act`.tipoActividad='Endoso')
	And
	(
		`act`.`folioActividad` = '" . $folioActividad . "'
	)
Group By 1,2,3,4,5,6,7,8,9,10,11,12

UNION

Select
	(
		if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=7200,'Red',
		if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=1440,'Orange','Blue'))
	) As `color`,
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
	`act`.`Status_Txt`,
	'5' As `status`,
	now() As `fechaGRabado`
From
	`actividades` `act`
Where
	(`act`.`Status_Txt`='EN CURSO')
	And 
	(`act`.ramoActividad!='VIDA')
	And 
	(`act`.tipoActividad='Emision' or `act`.tipoActividad='Endoso')
	And
	(
		`act`.`folioActividad` = '" . $folioActividad . "'
	)
				
UNION

Select 
	(If(TIMESTAMPDIFF(minute,`act`.`fechaCreacion`,`fechaGrabado`)>=10080,'Purple','Green')) As `color`,
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
	`act`.`Status_Txt`,
	`acp`.`status`,
	Min(acp.fechaGrabado) As `fechaGrabado`
From
	`actividades` `act` Left Join `actividadespartidas` `acp` 
	On  
	`act`.`folioActividad` = `acp`.`folioActividad`
Where
	(`act`.`Status_Txt`='AGENTE GAP')
	and 
	(`act`.ramoActividad!='VIDA')
	and 
	(`act`.tipoActividad='Cotizacion')
	And  
	(
		`act`.`folioActividad` = '" . $folioActividad . "'
	)
Group By 1,2,3,4,5,6,7,8,9,10,11,12

UNION

Select
	(
	if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=10080,'Red',
	if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=1440,'Orange','Blue'))
	) As `color`,
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
	`act`.`Status_Txt`,
	'5' As `status`,
	now() As `fechaGRabado`
From
	`actividades` `act`
WHERE 
	(`act`.`Status_Txt`='EN CURSO')
	And
	(`act`.ramoActividad!='VIDA')
	And 
	(`act`.tipoActividad='Cotizacion')
	And
	(
		`act`.`folioActividad` = '" . $folioActividad . "'
	)


UNION

Select 
	(if(TIMESTAMPDIFF(minute,`act`.`fechaCreacion`,`fechaGrabado`)>=7200,'Purple','Green')) As `color`,
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
	`act`.`Status_Txt`,
	`acp`.`status`,
	Min(acp.fechaGrabado) As `fechaGrabado`
From
	`actividades` `act` Left join `actividadespartidas` `acp` 
	On  
	`act`.`folioActividad` = `acp`.`folioActividad`
Where
	(`act`.`Status_Txt`='AGENTE GAP')
 	and 
	(`act`.ramoActividad!='ACCIDENTES_Y_ENFERMEDADES')
	and 
	(`act`.tipoActividad='Emision' or `act`.tipoActividad='Endoso')
	And
	(
		`act`.`folioActividad` = '" . $folioActividad . "'
	)
Group By 1,2,3,4,5,6,7,8,9,10,11,12

UNION

Select 
	(
		if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=7200,'Red',
		if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=1440,'Orange','Blue'))
	) AS `color`,
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
	`act`.`Status_Txt`,
	'5' As `status`,
	now() As `fechaGRabado`
From
	`actividades` act
Where
	(`act`.`Status_Txt`='EN CURSO')
	And 
	(`act`.ramoActividad!='ACCIDENTES_Y_ENFERMEDADES')
	And 
	(`act`.tipoActividad='Emision' or `act`.tipoActividad='Endoso')
	And
	(
		`act`.`folioActividad` = '" . $folioActividad . "'
	)

UNION 

Select 
	(if(TIMESTAMPDIFF(minute,`act`.`fechaCreacion`,`fechaGrabado`)>=180,'Purple','Green')) As `color`,
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
	`act`.`Status_Txt`,
	`acp`.`status`,
	Min(acp.fechaGrabado) As `fechaGrabado`
FROM 
	`actividades` `act` Left Join `actividadespartidas` `acp` 
	on  
	`act`.`folioActividad`=`acp`.`folioActividad`
WHERE 
	(`act`.`Status_Txt`='AGENTE GAP')
	And 
	(`act`.ramoActividad!='ACCIDENTES_Y_ENFERMEDADES')
	And 
	(`act`.tipoActividad='Cotizacion')
	And
	(
		`act`.`folioActividad` = '" . $folioActividad . "'
	)
Group By 1,2,3,4,5,6,7,8,9,10,11,12

UNION 

Select 
	(
		if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=180,'Red',
		if(TIMESTAMPDIFF(minute , `act`.`fechaCreacion`, now( ))>=30,'Orange','Blue'))
	) As `color`,
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
	`act`.`Status_Txt`,
	'5' As `status`,
	now() As `fechaGRabado`
From
	`actividades` `act`
Where
	(`act`.`Status_Txt`='EN CURSO')
	And 
	(`act`.ramoActividad!='ACCIDENTES_Y_ENFERMEDADES')
	And 
	(`act`.tipoActividad='Cotizacion')
	And
	(
		`act`.`folioActividad` = '" . $folioActividad . "'
	)
							";
		$query = $this->db->query($sqlTipoActividad);

		$return = "";
		if (count($query->result()) > 0) {
			foreach ($query->result() as $row) {
				$return = $row->color;
			}
			//$return = $query->result()[0]->color;
		} else {
			$return = "";
		}

		return
			//$query->result()[0]->color;
			$return;
	}
	//------------------------------------------------------------------------------------------------------
	public function obtenerCompaniasSubRamo($idSubRamo)
	{
		$consulta = 'select cp.idPromotoria,cp.Promotoria from relacionramopromotoria rrp left join catalog_promotorias cp on cp.idPromotoria=rrp.idPromotoria where rrp.idSubRamo=' . $idSubRamo;
		return $this->db->query($consulta)->result();
	}
	//------------------------------------------------------------------------------
	public function pagoFormas()
	{
		$consulta = "select * from pagoformas where visiblePF=1";
		return $this->db->query($consulta)->result();
	}
	//------------------------------------------------------------------------------
	public function pagoConducto()
	{
		$consulta = "select * from pagoconducto where visiblePC=1";
		return $this->db->query($consulta)->result();
	}
	//------------------------------------------------------------------------------
	public function pagoFactura()
	{
		$consulta = "select * from pagofactura where visiblePF=1";
		return $this->db->query($consulta)->result();
	}
	//------------------------------------------------------------------------------
	public function statusActividades()
	{
		$consulta = "select * from actividadesStatus where activar=1";
		return $this->db->query($consulta)->result();
	}
	//------------------------------------------------------------------------------

	function ActividadesPendientesOperativo($usuarioResponsable)
	{
		$consulta = 'select users.ActCreadaPorOtro from users where users.email="' . $usuarioResponsable . '"';
		$datos = $this->db->query($consulta);
		$ActCreadaPorOtro = $datos->result()[0]->ActCreadaPorOtro;
		//$datos[0]['ActCreadaPorOtro'];

		$this->db->from("actividades");
		$this->db->where("(actividades.fin != '1' And actividades.inicio = '0')");
		switch ($this->tank_auth->get_userprofile()) {

			case 1:
			case 2:
			case 3:
			case 4:
				/*	$this->db->where("(usuarioCreacion = '".$usuarioResponsable."')"); 
			//**  And usuarioBolita = '".$usuarioResponsable."'
			$this->db->where("(Status = '1')");*/
				if ($ActCreadaPorOtro == "SI") {
					//**  And usuarioBolita = '".$usuarioResponsable."'
					$this->db->where("(usuarioCreacion = '" . $usuarioResponsable . "' or usuarioVendedor='" . $usuarioResponsable . "' )");
					$this->db->where("(Status = '1')");
				} else {
					//**  And usuarioBolita = '".$usuarioResponsable."'
					$this->db->where("(usuarioCreacion = '" . $usuarioResponsable . "')");
					$this->db->where("(Status = '1')");
				}
				break;

			case 5:

				$this->db->where("(usuarioCreacion = '" . $usuarioResponsable . "' And Status = '1' )
								Or
								(usuarioBloqueo = '" . $usuarioResponsable . "' And Status = '3')");
				break;
		}
		$this->db->order_by("actividades.idSicas", "desc");
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query;
		} else {
			return false;
		}
		$consulta = "select * from actividades a where a.Status = '1' and a.usuarioResponsable='" . $usuarioResponsable . "'";
		$datos = $this->db->query($consulta);

		if ($datos->num_rows() > 0) {
			return $datos;
		} else {
			return false;
		}
	}/*! ActividadesPendientes */



	//------------------------------------------------------------------------------------
	function actividadesNoTrabajandose($usuarioCreacion)
	{
		$responsable =	' a.usuarioCreacion="' . $this->tank_auth->get_usermail() . '"';
		$consulta = "select ca.orden,csr.IDRamo,csr.RamosNombre,cr.Abreviacion,((TIMESTAMPDIFF(minute,a.fechaActualizacionStatus,NOW()))/60) as tiempoSemaforo,a.* from actividades a left join catalog_subRamos csr on csr.IDSRamo=a.IDSRamo left join catalog_ramos cr on cr.IDRamo=csr.IDRamo left join catalog_actividades ca on ca.nombre=a.tipoActividad where a.Status = '1' and " . $responsable . " and a.tipoActividad='Cotizacion' order by ca.orden";
		$query = $this->db->query($consulta)->result();

		foreach ($query as $key => $value) {
			$band = 1;
			if ($value->tipoActividad == 'Cotizacion' && $value->inicio == 0) {
				$band = 1;
				$cotizacionEmision = $this->db->query('select a.idInterno from actividades a where a.inicio=1 and a.folioActividad="' . $value->folioActividad . '"')->result();
				if (count($cotizacionEmision) > 0) {
					unset($query[$key]);
					$band = 0;
				}
			}
		}

		$respuesta['cotizaciones'] = $query;
		$consulta = "select ca.orden,csr.IDRamo,csr.RamosNombre,cr.Abreviacion,((TIMESTAMPDIFF(minute,a.fechaActualizacionStatus,NOW()))/60) as tiempoSemaforo,a.* from actividades a left join catalog_subRamos csr on csr.IDSRamo=a.IDSRamo left join catalog_ramos cr on cr.IDRamo=csr.IDRamo left join catalog_actividades ca on ca.nombre=a.tipoActividad where a.Status = '1' and " . $responsable . " and a.tipoActividad!='Cotizacion' order by ca.orden";
		$query = $this->db->query($consulta)->result();

		foreach ($query as $key => $value) {
			$band = 1;
			if ($value->tipoActividad == 'Cotizacion' && $value->inicio == 0) {
				$band = 1;
				$cotizacionEmision = $this->db->query('select a.idInterno from actividades a where a.inicio=1 and a.folioActividad="' . $value->folioActividad . '"')->result();
				if (count($cotizacionEmision) > 0) {
					unset($query[$key]);
					$band = 0;
				}
			}
		}
		$respuesta['otrasActividades'] = $query;


		return $respuesta;
	}
	//------------------------------------------------------------------------------------
	function ActividadesTrabajandoseOperativos($usuarioResponsable)
	{

		//     $consulta='select users.ActCreadaPorOtro from users where users.email="'.$usuarioResponsable.'"';
		//     $datos=$this->db->query($consulta);
		// $agentesCoordinador="select * from "
		$consultaRamos = "select * from catalog_ramos where activo=0";
		$datosRamos = $this->db->query($consultaRamos)->result();
		$anexo = "";

		foreach ($datosRamos as  $value) {
			$actividades[$value->Abreviacion] = new stdClass();
		}
		/*SI SE AÑADE UN PERMISO ADICIONAL PARA ALGUIEN IGUAL EN LA FUNCION actividadesenrojo*/
		$usuario = $this->tank_auth->get_usermail();
		switch ($usuario) {
			case 'AUTOS@ASESORESCAPITAL.COM':
				$responsable =	"((a.usuarioResponsable='AUTOS@ASESORESCAPITAL.COM') or (a.usuarioResponsable='INTERNO@AGENTECAPITAL.COM') or (a.usuarioResponsable='EJECUTIVOCOTIZACIONES@AGENTECAPITAL.COM'))";
				$anexo = ", fechaActualizacion desc";
				break;
			case 'BIENES@ASESORESCAPITAL.COM':
				$responsable =	"((a.usuarioResponsable='BIENES@ASESORESCAPITAL.COM') or (a.usuarioResponsable='BIENES@AGENTECAPITAL.COM') or ( a.usuarioResponsable='AUTOSNUEVOS@AGENTECAPITAL.COM') )";
				break;
			case 'COORDINADOROPERATIVO@ASESORESCAPITAL.COM':
				$responsable =	"((a.usuarioResponsable='EJECUTIVOCOTIZACIONES@AGENTECAPITAL.COM') or (a.usuarioResponsable='BIENES@ASESORESCAPITAL.COM') or (a.usuarioResponsable='BIENES@AGENTECAPITAL.COM') or ( a.usuarioResponsable='AUTOSNUEVOS@AGENTECAPITAL.COM')  or ( a.usuarioResponsable='LINEASPERSONALES@ASESORESCAPITAL.COM') or ( a.usuarioResponsable='SINIESTROS@ASESORESCAPITAL.COM') or (a.usuarioResponsable='AUTOS@ASESORESCAPITAL.COM') or (a.usuarioResponsable='AUTOSRENOVACIONES@ASESORESCAPITAL.COM') or (a.usuarioResponsable='COBRANZA@ASESORESCAPITAL.COM')) ";
				break;
			case 'GERENTECOMERCIAL@AGENTECAPITAL.COM':
				$responsable = "((a.usuarioResponsable='BIENES@ASESORESCAPITAL.COM') or (a.usuarioResponsable='BIENES@AGENTECAPITAL.COM') or ( a.usuarioResponsable='AUTOSNUEVOS@AGENTECAPITAL.COM')  or ( a.usuarioResponsable='LINEASPERSONALES@ASESORESCAPITAL.COM') or ( a.usuarioResponsable='SINIESTROS@ASESORESCAPITAL.COM') or (a.usuarioResponsable='AUTOS@ASESORESCAPITAL.COM') or (a.usuarioResponsable='AUTOSRENOVACIONES@ASESORESCAPITAL.COM') or (a.usuarioResponsable='COBRANZA@ASESORESCAPITAL.COM') or (a.usuarioResponsable='LINEASPERSONALESCOMERCIAL@ASESORESCAPITAL.COM') or (a.usuarioResponsable='GERENTECOMERCIAL@AGENTECAPITAL.COM'))";
				break;
			case 'SISTEMAS@ASESORESCAPITAL.COM':
				$responsable = "((a.usuarioResponsable='BIENES@ASESORESCAPITAL.COM') or (a.usuarioResponsable='BIENES@AGENTECAPITAL.COM') or ( a.usuarioResponsable='AUTOSNUEVOS@AGENTECAPITAL.COM') or ( a.usuarioResponsable='EJECUTIVOCOTIZACIONES@AGENTECAPITAL.COM') or ( a.usuarioResponsable='LINEASPERSONALES@ASESORESCAPITAL.COM') or ( a.usuarioResponsable='SINIESTROS@ASESORESCAPITAL.COM') or (a.usuarioResponsable='AUTOS@ASESORESCAPITAL.COM') or (a.usuarioResponsable='AUDITORINTERNO@AGENTECAPITAL.COM') or (a.usuarioResponsable='AUTOSRENOVACIONES@ASESORESCAPITAL.COM') or (a.usuarioResponsable='COBRANZA@ASESORESCAPITAL.COM') or (a.usuarioResponsable='AUTOSRENOVACIONES@ASESORESCAPITAL.COM') or (a.usuarioResponsable='FIANZAS@FIANZASCAPITAL.COM'))";
				break;
			case 'AUDITORINTERNO@AGENTECAPITAL.COM':
				$responsable = "((a.usuarioResponsable='BIENES@ASESORESCAPITAL.COM') or (a.usuarioResponsable='BIENES@AGENTECAPITAL.COM') or ( a.usuarioResponsable='AUTOSNUEVOS@AGENTECAPITAL.COM') or ( a.usuarioResponsable='EJECUTIVOCOTIZACIONES@AGENTECAPITAL.COM') or ( a.usuarioResponsable='LINEASPERSONALES@ASESORESCAPITAL.COM') or ( a.usuarioResponsable='SINIESTROS@ASESORESCAPITAL.COM') or (a.usuarioResponsable='AUTOS@ASESORESCAPITAL.COM') or (a.usuarioResponsable='AUTOSRENOVACIONES@ASESORESCAPITAL.COM') or (a.usuarioResponsable='COBRANZA@ASESORESCAPITAL.COM'))";
				break;
			case 'DIRECTORGENERAL@AGENTECAPITAL.COM':
				$responsable = "((a.usuarioResponsable='BIENES@ASESORESCAPITAL.COM') or (a.usuarioResponsable='BIENES@AGENTECAPITAL.COM') or ( a.usuarioResponsable='AUTOSNUEVOS@AGENTECAPITAL.COM') or ( a.usuarioResponsable='EJECUTIVOCOTIZACIONES@AGENTECAPITAL.COM') or ( a.usuarioResponsable='LINEASPERSONALES@ASESORESCAPITAL.COM') or ( a.usuarioResponsable='SINIESTROS@ASESORESCAPITAL.COM') or (a.usuarioResponsable='AUTOS@ASESORESCAPITAL.COM') or (a.usuarioResponsable='AUTOSRENOVACIONES@ASESORESCAPITAL.COM') or (a.usuarioResponsable='COBRANZA@ASESORESCAPITAL.COM'))";
				break;
			case 'GERENTEOPERATIVO@AGENTECAPITAL.COM':
				$responsable = "((a.usuarioResponsable='BIENES@ASESORESCAPITAL.COM') or (a.usuarioResponsable='BIENES@AGENTECAPITAL.COM') or ( a.usuarioResponsable='AUTOSNUEVOS@AGENTECAPITAL.COM') or ( a.usuarioResponsable='EJECUTIVOCOTIZACIONES@AGENTECAPITAL.COM') or ( a.usuarioResponsable='LINEASPERSONALES@ASESORESCAPITAL.COM') or ( a.usuarioResponsable='SINIESTROS@ASESORESCAPITAL.COM') or (a.usuarioResponsable='AUTOS@ASESORESCAPITAL.COM') or (a.usuarioResponsable='AUTOSRENOVACIONES@ASESORESCAPITAL.COM') or (a.usuarioResponsable='COBRANZA@ASESORESCAPITAL.COM'))";
				break;
			case 'COORDINADORCORPORATIVO@AGENTECAPITAL.COM':
				$responsable = "(a.usuarioResponsable='EJECUTIVOCORPORATIVO@AGENTECAPITAL.COM')";
				break;
			case 'ARNULFO.MANCERA@HOTMAIL.COM':
				$responsable = "((a.usuarioResponsable='BIENES@ASESORESCAPITAL.COM') or (a.usuarioResponsable='BIENES@AGENTECAPITAL.COM') or ( a.usuarioResponsable='AUTOSNUEVOS@AGENTECAPITAL.COM') or ( a.usuarioResponsable='EJECUTIVOCOTIZACIONES@AGENTECAPITAL.COM') or ( a.usuarioResponsable='LINEASPERSONALES@ASESORESCAPITAL.COM') or ( a.usuarioResponsable='SINIESTROS@ASESORESCAPITAL.COM') or (a.usuarioResponsable='AUTOS@ASESORESCAPITAL.COM') or (a.usuarioResponsable='AUTOSRENOVACIONES@ASESORESCAPITAL.COM') or (a.usuarioResponsable='COBRANZA@ASESORESCAPITAL.COM'))";
				break;
			case 'FIANZAS@FIANZASCAPITAL.COM':
				$responsable =	"((a.usuarioResponsable='FIANZAS@FIANZASCAPITAL.COM'))";
				break;
			default:
				$responsable = '((a.usuarioResponsable="' . $usuarioResponsable . '" || a.usuarioCreacion="' . $usuarioResponsable . '")';
				$agentesDelCoordinadorConsulta = 'select p.emailUsers,u.email from persona p left join users u on u.idPersona=p.idPersona where p.userEmailCreacion="' . $usuario . '"';
				$agentesDelCoordinador = $this->db->query($agentesDelCoordinadorConsulta)->result();

				foreach ($agentesDelCoordinador as $value) {
					if ($value->email != '') {
						$responsable .= ' or (a.usuarioResponsable="' . $value->email . '" || a.usuarioCreacion="' . $value->email . '")';
					}
				}
				$responsable .= ')';

				break;
		}


		$consulta = "select csr.IDRamo,csr.RamosNombre,cr.Abreviacion,((TIMESTAMPDIFF(minute,a.fechaActualizacionStatus,NOW()))/60) as tiempoSemaforo,(((TIME_TO_SEC(a.semaforoIncremento))/60)/60) as nuevoSemaforo,a.* from actividades a left join catalog_subRamos csr on csr.IDSRamo=a.IDSRamo left join catalog_ramos cr on cr.IDRamo=csr.IDRamo where (a.Status = '2' Or a.Status = '3' Or a.Status = '4' Or a
     .Status = '5') and " . $responsable . " order by a.actividadUrgente desc" . $anexo;




		$query = $this->db->query($consulta)->result();

		foreach ($query as $key => $value) {
			$band = 1;
			if ($value->tipoActividad == 'Cotizacion' && $value->inicio == 0) {
				$cotizacionEmision = $this->db->query('select a.idInterno from actividades a where a.inicio=1 and a.folioActividad="' . $value->folioActividad . '"')->result();
				if (count($cotizacionEmision) > 0) {
					unset($query[$key]);
					$band = 0;
				}
			}
			if ($band == 1) {
				$value->horasOficinaCP = 0;
				$value->horasPortalCP = 0;
				$consulta = 'select rap.*,rrp.*,cp.Promotoria from relactividadpromotoria rap left join relacionramopromotoria rrp on rrp.idPromotoria=rap.idPromotoria and rrp.idSubRamo=rap.idSubRamo left join catalog_promotorias cp on cp.idPromotoria=rap.idPromotoria where  rap.folioActividad="' . $value->folioActividad . '" and rap.tipoActividad="' . $value->tipoActividad . '"';
				$promotoria = $this->db->query($consulta)->result();

				if ((count($promotoria)) == 0 and $value->IDSRamo != "") {
					$consulta = 'select rp.* from relacionramopromotoria rp left join catalog_promotorias cp on cp.idPromotoria=rp.idPromotoria where idSubRamo=' . $value->IDSRamo;
					$promotoria = $this->db->query($consulta)->result();
				}

				if ((count($promotoria)) > 0) {
					/*======SI EXISTE UNA RELACION ENTRA PROMOTORIA Y ACTIVIDAD======*/
					switch ($value->tipoActividad) {
						case 'Cotizacion':
							$value->horasOficinaCP = $promotoria[0]->horasOficinaCotizacion;
							$value->horasPortalCP = $promotoria[0]->horasPortalCotizacion;
							break;
						case 'Emision':
							$value->horasOficinaCP = $promotoria[0]->horasOficinaEmision;
							$value->horasPortalCP = $promotoria[0]->horasPortalEmision;
							break;
						case 'Endoso':
							$value->horasOficinaCP = $promotoria[0]->horasOficinaEndosos;
							$value->horasPortalCP = 0;
							break;
						case 'CapturaEmision':
							$value->horasOficinaCP = 0;
							$value->horasPortalCP = $promotoria[0]->horasPortalCaptura;
							break;
						default:
							$value->horasOficinaCP = 0;
							$value->horasPortalCP = 0;
							break;
					}
				} else {
					/*========SI NO EXITE RELACION ENTRE PROMOTORIA Y ACTIVIDAD(CON EL TIEMPO SE PUEDE QUITAR)=========*/
					$value->horasOficinaCP = 0;
					$value->horasPortalCP = 0;
				}
				$nombrePromotorias = "";
				$filtroPromotorias = "";

				foreach ($promotoria as $valPromotoria) {/*PONGO POR DEFAULT LA PROMOTORIA QUE TIENE MENOS TIEMPO*/

					$valPromotoria->horasOficina = -1;
					$horasOficina;
					$horasPortal;
					switch ($value->tipoActividad) {
						case 'Cotizacion':
							$horasOficina = $valPromotoria->horasOficinaCotizacion;
							$horasPortal = $valPromotoria->horasPortalCotizacion;
							break;
						case 'Emision':
							$horasOficina = $valPromotoria->horasOficinaEmision;
							$horasPortal = $valPromotoria->horasPortalEmision;
							break;
						case 'Endoso':
							$horasOficina = $valPromotoria->horasOficinaEndosos;
							$horasPortal = 0;
							break;
						case 'CapturaEmision':
							$horasOficina = 0;
							$horasPortal = $valPromotoria->horasPortalCaptura;
							break;
						default:
							$horasOficina = 0;
							$horasPortal = 0;
							break;
					}
					if (isset($valPromotoria->Promotoria)) {
						$nombrePromotorias = $nombrePromotorias . '*' . $valPromotoria->Promotoria . '(Portal ' . $horasPortal . 'hrs,Aseguradora ' . $horasOficina . ' hrs)<br>';
						$filtroPromotorias = $filtroPromotorias . $valPromotoria->Promotoria . '|';
					}

					if ($value->horasOficinaCP > $horasOficina) {
						$value->horasOficinaCP = $horasOficina;
					}
					if ($value->horasPortalCP > $horasPortal) {
						$value->horasPortalCP = $horasPortal;
					}
				}
				$value->promotorias = $nombrePromotorias;
				$value->filtroPromotorias = $filtroPromotorias;
				foreach ($actividades as $key1 => $valor) {
					if ($value->Abreviacion == $key1) {
						$actividades[$key1]->$key = $value;
					}
				}
			}
		}
		$respuesta['actividades'] = $actividades;
		$respuesta['ramos'] = $datosRamos;
		$respuesta['totalesPorRamo'] = new stdClass;
		$respuesta['personaTrabajaActividad'] = new stdClass;
		$agregar = "";
		if (!is_object($agregar)) {
			$agregar = new stdClass;
		}

		foreach ($respuesta['actividades'] as $key => $value) {
			$total = 0;
			foreach ($respuesta['actividades'][$key] as $key2 => $value2) {
				$total++;
				if ($value2->idPersonaTrabaja > 0) {
					$consulta = "select email from users where idPersona=" . $value2->idPersonaTrabaja;
					$emailPersona = $this->db->query($consulta)->result()[0];
					$usuarioTrabaja['usuarioTrabaja'] = $emailPersona->email;
					$usuarioTrabaja['usuarioResponsable'] = $value2->usuarioResponsable;
					$usuarioTrabaja['idInterno'] = $value2->idInterno;
					//$agregar->folioActividad=$value2->folioActividad;
					$folio = $value2->folioActividad;

					$respuesta['personaTrabajaActividad']->$folio = $usuarioTrabaja;

					//array_push($respuesta['personaTrabajaActividad'],'f','f');
				}
			}

			$respuesta['totalesPorRamo']->$key = $total;
		}

		return $respuesta;
	}

	//-------------------------------------------------------------------------------------
	function actualizarActividad($folioActividad, $array)
	{
		$this->db->where('folioActividad', $folioActividad);
		$this->db->update('actividades', $array);
	}
	//------------------------------------------------------------
	function obtenerCalificaciones()
	{
		$consulta = "select * from calificacionagente where statusCalificacionAgente=1";
		return $this->db->query($consulta)->result();
	}
	//------------------------------------------------------------
	function obtenerActividadCalificada($folioActividad, $tipoActividad)
	{
		$consulta = 'select (count(folioActividad)) as total from calificacionactividad ca where ca.folioActividad="' . $folioActividad . '" and ca.tipoActividad="' . $tipoActividad . '"';
		return $this->db->query($consulta)->result();
	}
	//------------------------------------------------------------
	function descriptaDatosActividad($folioActividad)
	{
		//select (AES_DECRYPT(tarjetaNumeroEncriptado,'SW16196AC')) as numero,(AES_DECRYPT(tarjetaCodigoSeguridad,'SW16196AC')) as codigo from actividades a where a.folioActividad="SW16196";
		$consulta = 'select (AES_DECRYPT(tarjetaNumeroEncriptado,"' . $folioActividad . 'AC")) as numero,(AES_DECRYPT(tarjetaCodigoSeguridad,"' . $folioActividad . 'AC"))  as codigo from actividades a where a.folioActividad="' . $folioActividad . '"';

		return $this->db->query($consulta)->result();
	}
	//-------------------------------------------------------------
	function obtenerPromotoriaPorActividad($folioActividad, $tipoActividad)
	{

		if ($tipoActividad != null) {
			$consulta = 'select rap.*,rrp.*,cp.Promotoria from relactividadpromotoria rap left join relacionramopromotoria rrp on rrp.idPromotoria=rap.idPromotoria and rrp.idSubRamo=rap.idSubRamo left join catalog_promotorias cp on cp.idPromotoria=rap.idPromotoria where rap.folioActividad="' . $folioActividad . '" && rap.tipoActividad="' . $tipoActividad . '"';

			return $this->db->query($consulta)->result();
		}
	}
	//-------------------------------------------------------------
	function comprobarExistenciaActividad($folioActividad)
	{
		$consulta = 'select * from actividades where folioActividad="' . $folioActividad . '"';
		$respuestas = false;
		$datos = $this->db->query($consulta);
		if ($datos->num_rows > 0) {
			$respuesta = true;
		}
		return $respuesta;
	}
	//-------------------------------------------------------------
	function comprobarExistenciaRAP($folioActividad, $idPromotoria)
	{
		$consulta = 'select * from relactividadpromotoria where folioActividad="' . $folioActividad . '" and idPromotoria=' . $idPromotoria;
		$respuesta = false;
		$datos = $this->db->query($consulta);
		if ($datos->num_rows > 0) {
			$respuesta = true;
		}
		return $respuesta;
	}
	//-------------------------------------------------------------
	function buscarActividadPorFolio($folioActividad)
	{
		$consulta = 'select * from actividades where folioActividad="' . $folioActividad . '"';
		$datos = $this->db->query($consulta)->result();
		return $datos;
	}
	//-------------------------------------------------------------
	function relactividadpromotoria($array)
	{
		if (isset($array['idRelActividadPromotoria'])) {
			if ($array['idRelActividadPromotoria'] == -1) {
			} else {
				if (isset($array['update'])) {
					unset($array['update']);
					$this->db->where('idRelActividadPromotoria', $array['idRelActividadPromotoria']);
					$this->db->update('relactividadpromotoria', $array);
				}
			}
		}
	}
	//-------------------------------------------------------------
	function actividades($array)
	{

		$salida = 0;
		$seguridad = 0;
		$datos = "";
		do {
			if (isset($array['idInterno'])) {
				if ($array['idInterno'] == -1) {
					unset($array['idInterno']);
					unset($array['update']);
					$this->db->insert('actividades', $array);
					$array['ID'] = $this->db->insert_id();
				} else {
					if (isset($array['update'])) {
						unset($array['update']);
						if ($array['idInterno'] != '') {

							$this->db->where('idInterno', $array['idInterno']);
							$this->db->update('actividades', $array);
						} else {
							$salida = 1;
						}
					} else {
						$this->db->where('idInterno', $array['idInterno']);
						$datos = $this->db->get('actividades')->result()[0];
						$salida = 1;
					}
				}
			} else {
				//$where->db->where('Usuario',$this->tank_auth->get_usermail());

				//$datos=$this->db->get('actividades')->result();    

				$salida = 1;
			}
			$seguridad++;
			if ($seguridad > 4) {
				$salida = 1;
			}
		} while ($salida == 0);

		return $datos;
	}
	//-------------------------------------------------------------
	function actividadespartidas($array)
	{

		$salida = 0;
		$seguridad = 0;
		$datos = "";
		do {
			if (isset($array['idPartida'])) {
				if ($array['idPartida'] == -1) {
					unset($array['idPartida']);
					unset($array['update']);

					$this->db->insert('actividadespartidas', $array);
					$array['idPartida'] = $this->db->insert_id();
				} else {
					if (isset($array['update'])) {
						unset($array['update']);
						if ($array['idPartida'] != '') {

							$this->db->where('idPartida', $array['idPartida']);
							$this->db->update('actividadespartidas', $array);
						} else {
							$salida = 1;
						}
					} else {
						$this->db->where('idPartida', $array['idPartida']);
						$datos = $this->db->get('actividadespartidas')->result();
						$salida = 1;
					}
				}
			} else {
				//$where->db->where('Usuario',$this->tank_auth->get_usermail());

				//$datos=$this->db->get('actividades')->result();    

				$salida = 1;
			}
			$seguridad++;
			if ($seguridad > 4) {
				$salida = 1;
			}
		} while ($salida == 0);

		return $datos;
	}
	//-------------------------------------------------------------
	function cantidadActividadesTrabajandose($idPersona)
	{
		$consulta = "select (count(idPersonaTrabaja)) as cantidad,idInterno from actividades where idPersonaTrabaja=" . $idPersona;
		return $this->db->query($consulta)->result();
	}

	//------------------------------------------------------------
	function devolverActividades($array)
	{
		$respueta = array();
		if (isset($array['idInterno'])) {
			$consulta = "select a.idInterno,a.folioActividad,a.tipoActividad,a.Status_Txt,a.nombreCliente,a.ramoActividad,a.subRamoActividad,a.usuarioCreacion,a.usuarioVendedor,a.usuarioResponsable,a.fechaCreacion,a.ClaveBit,a.motivoCambio from actividades a where a.idInterno=" . $array['idInterno'];
		} else {
			if (isset($arra['IDVend'])) {
				$consulta = "select a.idInterno,a.folioActividad,a.tipoActividad,a.Status_Txt,a.nombreCliente,a.ramoActividad,a.subRamoActividad,a.usuarioCreacion,a.usuarioVendedor,a.usuarioResponsable,a.fechaCreacion,a.ClaveBit,a.motivoCambio from actividades a where a.Status!=6 and a.IDVend=" . $array['IDVend'];
			} else {
				if (isset($array['where'])) {
					$consulta = "select a.idInterno,a.folioActividad,a.tipoActividad,a.Status_Txt,a.nombreCliente,a.ramoActividad,a.subRamoActividad,a.usuarioCreacion,a.usuarioVendedor,a.usuarioResponsable,a.fechaCreacion,a.ClaveBit,a.IDVend,'' as idPersona,'' as nombreVendedor,a.motivoCambio from actividades a where a.Status!=6 " . $array['where'];
				} else {
					$consulta = "select a.idInterno,a.folioActividad,a.tipoActividad,a.Status_Txt,a.nombreCliente,a.ramoActividad,a.subRamoActividad,a.usuarioCreacion,a.usuarioVendedor,a.usuarioResponsable,a.fechaCreacion,a.ClaveBit,a.motivoCambio from actividades a where a.Status!=6";
				}
			}
		}

		$respuesta = $this->db->query($consulta)->result();
		return $respuesta;
	}
	//---------------------------------------------------------
	function devolverPartidasActividades($array)
	{
		$respuesta = array();
		$consulta = 'select p.fechaGrabado,p.comentarioAP,p.motivoCambio,s.Nombre ,c.motivoCambio from actividadespartidas p left join `catalog_actividades-status` s on s.IdStatus=p.status left join catalog_motivocambioactividades c on c.idMotivaCambio=p.motivoCambio where p.idInterno=' . $array['idInterno'] . ' order by p.fechaGrabado ';

		$respuesta = $this->db->query($consulta)->result();
		return $respuesta;
	}
	//---------------------------------------------------------
	function devolverPromotoriActividad($folioActividad)
	{
		$consulta = 'select * from relactividadpromotoria r where r.folioActividad="' . $folioActividad . '"';
		$respuesta = $this->db->query($consulta)->result();
		return $respuesta;
	}
	//------------------------------------------------------
	function actividadesPartidasPorFecha($fInicial, $fFinal)
	{
		//error_reporting(E_ERROR | E_PARSE);

		$consulta = 'select idInterno,tipoActividad,subRamoActividad,usuarioResponsable,folioActividad,Status_Txt,satisfaccion,satisfaccionEmision,ramoActividad,subRamoActividad,usuarioCreacion,usuarioVendedor,fechaCreacion,motivoCambio,status,nombreUsuarioVendedor from actividades a where cast(a.fechaCreacion as date)>="' . $fInicial . '" and cast(a.fechaCreacion as date)<="' . $fFinal . '"';

		$datos = array();
		$datos['actividad'] = $this->db->query($consulta)->result();
		$datos['tipoActividad'] = array();
		$datos['subRamoActividad'] = array();
		$datos['usuarioResponsable'] = array();
		$datos['motivoCambio'] = array();
		$datos['statusTXT'] = array();
		$datos['satisfaccion'] = array();
		$datos['satisfaccionEmision'] = array();
		$datos['nombreUsuarioVendedor'] = array();
		$in = '';
		foreach ($datos['actividad'] as  $value) {
			(string)$tipoActividad = '';
			$tipoActividad = $value->tipoActividad;
			if ($tipoActividad == '') {
				$tipoActividad = 'SIN_INFORMACION';
			}
			$subRamoActividad = $value->subRamoActividad;
			if ($subRamoActividad == '') {
				$subRamoActividad = 'SIN_INFORMACION';
			}
			$usuarioResponsable = $value->usuarioResponsable;
			if ($usuarioResponsable == '') {
				$usuarioResponsable = 'SIN_INFORMACION';
			}
			$statusTXT = $value->Status_Txt;
			if ($statusTXT == '') {
				$statusTXT = 'SIN_INFORMACION';
			}
			$satisfaccion = $value->satisfaccion;
			if ($satisfaccion == '') {
				$satisfaccion = 'SIN CALIFICAR';
			}
			$satisfaccionEmision = $value->satisfaccionEmision;
			if ($satisfaccionEmision == '') {
				$satisfaccionEmision = 'SIN_CALIFICAR';
			}
			$nombreUsuarioVendedor = $value->nombreUsuarioVendedor;
			if ($nombreUsuarioVendedor == '') {
				$nombreUsuarioVendedor = 'SIN INFORMACION';
			} //Campos nulos

			if (isset($datos['tipoActividad'][$tipoActividad])) {
				$datos['tipoActividad'][$tipoActividad]++;
			} else {
				$datos['tipoActividad'][$tipoActividad] = 1;
			}
			if (isset($datos['subRamoActividad'][$subRamoActividad])) {
				$datos['subRamoActividad'][$subRamoActividad]++;
			} else {
				$datos['subRamoActividad'][$subRamoActividad] = 1;
			}
			if (isset($datos['usuarioResponsable'][$usuarioResponsable])) {
				$datos['usuarioResponsable'][$usuarioResponsable]++;
			} else {
				$datos['usuarioResponsable'][$usuarioResponsable] = 1;
			}
			if (isset($datos['statusTXT'][$statusTXT])) {
				$datos['statusTXT'][$statusTXT]++;
			} else {
				$datos['statusTXT'][$statusTXT] = 1;
			}
			if (isset($datos['satisfaccion'][$satisfaccion])) {
				$datos['satisfaccion'][$satisfaccion]++;
			} else {
				$datos['satisfaccion'][$satisfaccion] = 1;
			}
			if (isset($datos['satisfaccionEmision'][$satisfaccionEmision])) {
				$datos['satisfaccionEmision'][$satisfaccionEmision]++;
			} else {
				$datos['satisfaccionEmision'][$satisfaccionEmision] = 1;
			}

			if (isset($datos['nombreUsuarioVendedor'][$nombreUsuarioVendedor])) {
				$datos['nombreUsuarioVendedor'][$nombreUsuarioVendedor]++;
			} else {
				$datos['nombreUsuarioVendedor'][$nombreUsuarioVendedor] = 1;
			}
			$value->partidas = array();
			$in .= $value->idInterno . ',';
			/* $consulta='select ap.*,m.motivoCambio from actividadespartidas ap left join catalog_motivocambioactividades m on m.idMotivaCambio=ap.motivoCambio where ap.status!=5 and ap.idInterno='.$value->idInterno;
        
            
		  $partidas=$this->db->query($consulta)->result();	
		  $value->partidas=$partidas;

		
		  foreach ($partidas as  $valuePart) 
		  {
		  	            $motivoCambio=$valuePart->motivoCambio;
            if($motivoCambio==''){$motivoCambio='SIN_INFORMACION';}
		   	if(isset($datos['motivoCambio'][$motivoCambio])){$datos['motivoCambio'][$motivoCambio]++;}
		   	else{$datos['motivoCambio'][$motivoCambio]=1;}

		  }	*/
		}
		$datos['motivosDeCambio'] = $this->db->query('select * from catalog_motivocambioactividades where estaActivo=1')->result();
		if ($in != '') {
			$in = substr($in, 0, -1);
			$datos['partidasTodas'] = $this->db->query('select ap.*,m.motivoCambio,m.idMotivaCambio from actividadespartidas ap left join catalog_motivocambioactividades m on m.idMotivaCambio=ap.motivoCambio 
where ap.status!=5 and ap.idInterno in (' . $in . ')')->result();
			$datos['semaforosIdInterno'] = $this->db->query('select distinct(a.idInterno) from actividadesenrojo a where idInterno in (' . $in . ') and a.statusActividad="ROJO" ')->result();
		} else {

			$datos['partidasTodas'] = array();
			$datos['partidasSemaforos'] = array();
		}


		return $datos;
	}

	//-----------------------------------------------------
	function actividadesenrojo($array = array())
	{
		$usuario = $this->tank_auth->get_usermail();
		switch ($usuario) {
			case 'AUTOS@ASESORESCAPITAL.COM':
				$responsable =	"((a.usuarioResponsable='AUTOS@ASESORESCAPITAL.COM') or (a.usuarioResponsable='EJECUTIVOCOTIZACIONES@AGENTECAPITAL.COM'))";
				break;
			case 'BIENES@ASESORESCAPITAL.COM':
				$responsable =	"((a.usuarioResponsable='BIENES@ASESORESCAPITAL.COM') or (a.usuarioResponsable='BIENES@AGENTECAPITAL.COM') or ( a.usuarioResponsable='AUTOSNUEVOS@AGENTECAPITAL.COM') )";
				break;
			case 'COORDINADOROPERATIVO@ASESORESCAPITAL.COM':
				$responsable =	"((a.usuarioResponsable='EJECUTIVOCOTIZACIONES@AGENTECAPITAL.COM') or (a.usuarioResponsable='BIENES@ASESORESCAPITAL.COM') or (a.usuarioResponsable='BIENES@AGENTECAPITAL.COM') or ( a.usuarioResponsable='AUTOSNUEVOS@AGENTECAPITAL.COM')  or ( a.usuarioResponsable='LINEASPERSONALES@ASESORESCAPITAL.COM') or ( a.usuarioResponsable='SINIESTROS@ASESORESCAPITAL.COM') or (a.usuarioResponsable='AUTOS@ASESORESCAPITAL.COM') or (a.usuarioResponsable='AUTOSRENOVACIONES@ASESORESCAPITAL.COM') or (a.usuarioResponsable='COBRANZA@ASESORESCAPITAL.COM')) ";
				break;
			case 'GERENTECOMERCIAL@AGENTECAPITAL.COM':
				$responsable = "((a.usuarioResponsable='BIENES@ASESORESCAPITAL.COM') or (a.usuarioResponsable='BIENES@AGENTECAPITAL.COM') or ( a.usuarioResponsable='AUTOSNUEVOS@AGENTECAPITAL.COM')  or ( a.usuarioResponsable='LINEASPERSONALES@ASESORESCAPITAL.COM') or ( a.usuarioResponsable='SINIESTROS@ASESORESCAPITAL.COM') or (a.usuarioResponsable='AUTOS@ASESORESCAPITAL.COM') or (a.usuarioResponsable='AUTOSRENOVACIONES@ASESORESCAPITAL.COM') or (a.usuarioResponsable='COBRANZA@ASESORESCAPITAL.COM') or ( a.usuarioResponsable='LINEASPERSONALESCOMERCIAL@ASESORESCAPITAL.COM') or (a.usuarioResponsable='GERENTECOMERCIAL@AGENTECAPITAL.COM'))";
				break;
			case 'SISTEMAS@ASESORESCAPITAL.COM':
				$responsable = "((a.usuarioResponsable='BIENES@ASESORESCAPITAL.COM') or (a.usuarioResponsable='BIENES@AGENTECAPITAL.COM') or ( a.usuarioResponsable='AUTOSNUEVOS@AGENTECAPITAL.COM') or ( a.usuarioResponsable='EJECUTIVOCOTIZACIONES@AGENTECAPITAL.COM') or ( a.usuarioResponsable='LINEASPERSONALES@ASESORESCAPITAL.COM') or ( a.usuarioResponsable='SINIESTROS@ASESORESCAPITAL.COM') or (a.usuarioResponsable='AUTOS@ASESORESCAPITAL.COM') or (a.usuarioResponsable='AUDITORINTERNO@AGENTECAPITAL.COM') or (a.usuarioResponsable='AUTOSRENOVACIONES@ASESORESCAPITAL.COM') or (a.usuarioResponsable='COBRANZA@ASESORESCAPITAL.COM') or (a.usuarioResponsable='FIANZAS@FIANZASCAPITAL.COM'))";
				break;
			case 'AUDITORINTERNO@AGENTECAPITAL.COM':
				$responsable = "((a.usuarioResponsable='BIENES@ASESORESCAPITAL.COM') or (a.usuarioResponsable='BIENES@AGENTECAPITAL.COM') or ( a.usuarioResponsable='AUTOSNUEVOS@AGENTECAPITAL.COM') or ( a.usuarioResponsable='EJECUTIVOCOTIZACIONES@AGENTECAPITAL.COM') or ( a.usuarioResponsable='LINEASPERSONALES@ASESORESCAPITAL.COM') or ( a.usuarioResponsable='SINIESTROS@ASESORESCAPITAL.COM') or (a.usuarioResponsable='AUTOS@ASESORESCAPITAL.COM') or (a.usuarioResponsable='AUTOSRENOVACIONES@ASESORESCAPITAL.COM') or (a.usuarioResponsable='COBRANZA@ASESORESCAPITAL.COM'))";
				break;
			case 'DIRECTORGENERAL@AGENTECAPITAL.COM':
				$responsable = "((a.usuarioResponsable='BIENES@ASESORESCAPITAL.COM') or (a.usuarioResponsable='BIENES@AGENTECAPITAL.COM') or ( a.usuarioResponsable='AUTOSNUEVOS@AGENTECAPITAL.COM') or ( a.usuarioResponsable='EJECUTIVOCOTIZACIONES@AGENTECAPITAL.COM') or ( a.usuarioResponsable='LINEASPERSONALES@ASESORESCAPITAL.COM') or ( a.usuarioResponsable='SINIESTROS@ASESORESCAPITAL.COM') or (a.usuarioResponsable='AUTOS@ASESORESCAPITAL.COM') or (a.usuarioResponsable='AUTOSRENOVACIONES@ASESORESCAPITAL.COM') or (a.usuarioResponsable='COBRANZA@ASESORESCAPITAL.COM'))";
				break;
			case 'GERENTEOPERATIVO@AGENTECAPITAL.COM':
				$responsable = "((a.usuarioResponsable='BIENES@ASESORESCAPITAL.COM') or (a.usuarioResponsable='BIENES@AGENTECAPITAL.COM') or ( a.usuarioResponsable='AUTOSNUEVOS@AGENTECAPITAL.COM') or ( a.usuarioResponsable='EJECUTIVOCOTIZACIONES@AGENTECAPITAL.COM') or ( a.usuarioResponsable='LINEASPERSONALES@ASESORESCAPITAL.COM') or ( a.usuarioResponsable='SINIESTROS@ASESORESCAPITAL.COM') or (a.usuarioResponsable='AUTOS@ASESORESCAPITAL.COM') or (a.usuarioResponsable='AUTOSRENOVACIONES@ASESORESCAPITAL.COM') or (a.usuarioResponsable='COBRANZA@ASESORESCAPITAL.COM'))";
				break;
			case 'ARNULFO.MANCERA@HOTMAIL.COM':
				$responsable = "((a.usuarioResponsable='BIENES@ASESORESCAPITAL.COM') or (a.usuarioResponsable='BIENES@AGENTECAPITAL.COM') or ( a.usuarioResponsable='AUTOSNUEVOS@AGENTECAPITAL.COM') or ( a.usuarioResponsable='EJECUTIVOCOTIZACIONES@AGENTECAPITAL.COM') or ( a.usuarioResponsable='LINEASPERSONALES@ASESORESCAPITAL.COM') or ( a.usuarioResponsable='SINIESTROS@ASESORESCAPITAL.COM') or (a.usuarioResponsable='AUTOS@ASESORESCAPITAL.COM') or (a.usuarioResponsable='AUTOSRENOVACIONES@ASESORESCAPITAL.COM') or (a.usuarioResponsable='COBRANZA@ASESORESCAPITAL.COM'))";
				break;
			case 'FIANZAS@FIANZASCAPITAL.COM':
				$responsable =	"((a.usuarioResponsable='FIANZAS@FIANZASCAPITAL.COM'))";
				break;
			default:
				$responsable = '((a.usuarioResponsable="' . $usuarioResponsable . '" || a.usuarioCreacion="' . $usuarioResponsable . '")';
				break;
		}

		$consulta = "select ar.*,a.usuarioResponsable from actividadesenrojo ar left join actividades a on a.idInterno=ar.idInterno   where (a.Status = '2' Or a.Status = '3' Or a.Status = '4' Or a
     .Status = '5') and " . $responsable . "  and ar.estaCerrado=0 and ar.statusActividad='ROJO' order by ar.fechaInsercion";
		return $this->db->query($consulta)->result();
	}

	//----------------------------------------------------
	function getEvents($idProspecto)
	{
		return $this->db->query("select *,cast(fechaContactoCitaCCC as date) as fecha from comentarioscitacontacto where (tipoCCC=1 or tipoCCC=2) and idCli_CA=" . $idProspecto)->result_array();
	}
	//----------------------------------------------------
}
