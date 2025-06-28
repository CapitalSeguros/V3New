<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class capsysdre extends CI_Model {
		 
	function __construct(){
		parent::__construct();
		
		function _encriptaSICAS($key,$ivPass,$TextPlain){
			if(strlen($key)!=24){
				echo "La longitud de la key ha de ser de 24 dígitos.<br>"; return -1; 
			} if((strlen($ivPass) % 8 )!=0){ 
				echo "La longitud del vector iv Passsword ha de ser múltiple de 8 dígitos.<br>"; return -2; 
			}
		return 
			@base64_encode(mcrypt_encrypt(MCRYPT_3DES, $key, $TextPlain, MCRYPT_MODE_CBC, $ivPass));
		}/*! _encriptaSICAS */

		function _consumoWsSICAS($XMLData){
			$headers = array(
    	    				"POST /SOnlineWSQua/WS_SICASOnline.asmx HTTPS/1.1",
        	                "Content-Type: text/xml; charset=utf-8",
            	            "Accept: text/xml",                        
                	        "Host: www.sicasonline.info",
                    	    "Pragma: no-cache",
                        	"SOAPAction: http://tempuri.org/ProcesarWS", 
	                        "Content-length: ".strlen($XMLData),
    	                );
        	// PHP cURL  for https connection with auth
            $urlProceso = "https://www.sicasonline.info:448/SOnlineWS/WS_SICASOnline.asmx?WSDL";

	        $ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $urlProceso);
        	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	        //curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc
    	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);            
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    	    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        	curl_setopt($ch, CURLOPT_POST, true);
	        curl_setopt($ch, CURLOPT_POSTFIELDS, $XMLData); // the SOAP request

    	    // converting
	        $response = curl_exec($ch); 
    	    curl_close($ch);        

        	// converting
	        $response1 = str_replace("<soap:Body>","",$response);            
    	    $response1 = str_replace("</soap:Body>","",$response1);
			
        	return  
				(string)$response1;
		}/*! _consumoWsSICAS */

	}
	
	function ConfiguracionUsuarios($emailUser){
		$this->db->from("user_config");
		$this->db->where("user_config.emailUser", $emailUser);
		$query = $this->db->get();

		if($query->num_rows() > 0){
			foreach ($query->result() as $row){
				$returns[]	=	array(
					'modulo'		=>	$row->modulo
					,'subModulo'	=>	$row->subModulo
					,'accion'		=>	$row->accion
					,'permiso'		=>	$row->permiso
				);
			}
		} else {
				$returns[]	=	array(
					'modulo'		=>	''
					,'subModulo'	=>	''
					,'accion'		=>	''
					,'permiso'		=>	''
				);
		}
		
	return
		$returns;
	} /*! ConfiguracionUsuarios */

	function ArrayVendedor(){
		$this->db->select('`IDVend`, `NombreCompleto`');
		$this->db->from("catalog_vendedores");
		$this->db->where('catalog_vendedores.Status', '0');
		$this->db->order_by("catalog_vendedores.NombreCompleto", "asc");
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			
			$return = array('0'=>'--Seleccione--',);
			foreach($query->result() as $row){
				$return[$row->IDVend] = $row->NombreCompleto;
			}
		}
		return
			$return;
	} /*! ArrayVendedor */
	
	/*
	function ArraySubGrupos(){
		$this->db->select('`IDSGrupo`, `SubGrupo`');
		$this->db->from("catalog_subGrupos");
		//$this->db->where('catalog_subGrupos.activo', '0');
		//$this->db->order_by("catalog_subGrupos.orden", "asc");
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			
			$return = array('0'=>'--Seleccione--',);
			foreach($query->result() as $row){
				$return[$row->IDSGrupo] = $row->SubGrupo;
			}
		}
		return
			$return;
	} /*! ArraySubGrupos */
	
	function ArrayGrupos(){
		$this->db->select('`IDGrupo`, `Grupo`');
		$this->db->from("catalog_grupos");
		//$this->db->where('catalog_grupos.activo', '0');
		//$this->db->order_by("catalog_grupos.orden", "asc");
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			
			$return = array('0'=>'--Seleccione--',);
			foreach($query->result() as $row){
				$return[$row->IDGrupo] = $row->Grupo;
			}
		}
		return
			$return;
	} /*! ArrayGrupos */

	function ListaUsuarios($busquedaUsuario){
		$busquedaUsuario = strtoupper($busquedaUsuario);
		$sqlBusquedaUsuario = "
			Select * From
				`users`
			Where
				(
					`profile` != '1' And `profile` != '2'
				)
				And
				(
					`email` Like '%".$busquedaUsuario."%'
					or
					`name_complete` Like '%".$busquedaUsuario."%'
				)
			Order By
				`name_complete` Asc
							  ";
		$query = $this->db->query($sqlBusquedaUsuario);
		/*
		$this->db->from("users");
		$this->db->like('email', $busquedaUsuario);
		$this->db->or_like('name_complete', $busquedaUsuario);
		$this->db->order_by("users.profile, users.name_complete", "asc");
		$query = $this->db->get();

		if($query->num_rows() > 0){
  			$return = $query;
		} else {
			$return = $query;
		}
		*/		
		return
			/* $return; */
			$query;
	} /*! ListaUsuarios */
/*	
	function TotalListaUsuarios($busquedaUsuario){		
		$this->db->from("users");
		$this->db->like('email', $busquedaUsuario);
		$this->db->or_like('username', $busquedaUsuario);
		$this->db->order_by("users.email", "asc");
		$query = $this->db->get();
		
		return
			$query->num_rows(); 
	}
*/
	
	function miInfo_DatosUsuario($emailUser){
		$this->db->from("user_miInfo");
		$this->db->where("user_miInfo.emailUser", $emailUser);
		$query = $this->db->get();

		if($query->num_rows() > 0){
			$row = $query->row();
		} else {
			$row = "";
		}
		
	return
		$row;
	} /*! miInfo_DatosUsuario */

	function miInfo_GuardarUsuario($emailUser, $data){
		$this->db->where('user_miInfo.emailUser', $emailUser);
		$this->db->update('user_miInfo', $data); 
	} /*! miInfo_GuardarUsuario */
	
	function NombreUsuario($IDUser){		
		$this->db->from("users");
		$this->db->where("users.IDUser", $IDUser);
		$query = $this->db->get();

		if($query->num_rows() > 0){
			return $query->row()->name_complete;
		} else {
			return false;
		}
	}/*! NombreVendedor*/

	function NombreUsuarioEmail($EmailUser){		
		$this->db->from("users");
		$this->db->where("users.email", $EmailUser);
		$query = $this->db->get();

		if($query->num_rows() > 0){
			return $query->row()->name_complete;
		} else {
			return false;
		}
	}/*! NombreVendedor*/
	
	function RankingUsuarioEmail($EmailVendedor){
		$this->db->from("catalog_vendedores");
		$this->db->where("catalog_vendedores.EMail1", $EmailVendedor);
		$query = $this->db->get();

		if($query->num_rows() > 0){
			return "(".$query->row()->Clasifica_TXT.")";
		} else {
			return false;
		}
	} /*! RankingUsuarioEmail */
	
	function NombrePerfilUsuario($idProfile){		
		$this->db->from("catalog_profiles");
		$this->db->where("catalog_profiles.idProfile", $idProfile);
		$query = $this->db->get();

		if($query->num_rows() > 0){
			return $query->row()->Nombre;
		} else {
			return false;
		}
	}/*! NombrePerfilUsuario */
	
	function NombreVendedor($IDVend){	
		$this->db->from("catalog_vendedores");
		$this->db->where("catalog_vendedores.IDVend", $IDVend);
		$query = $this->db->get();

		if($query->num_rows() > 0){
			return $query->row()->NombreCompleto;
		} else {
			return false;
		}
	}/*! NombrePerfilUsuario */
	
	function detalleUsuario($idUser = '0'){
		$sqlDetalleUsuario = "
			Select
				`id`,
				`idTipoUser`,
				`IDUser`,
				`IDVendNs`,
				`IDSGrupo`,
				`profile`,
				`username`,
				`email`,
				`name_complete`,
				`banned`
				
			From
				`users`
			Where
				`id` = '".$idUser."';
							 ";
		//	SELECT us.id ,us.name_complete AS 'nombre', us.email AS 'correo' FROM users us WHERE us.id = '".$idUser."';
		//** $SQL = "SELECT us.id ,us.name_complete AS 'nombre', us.email AS 'correo', IF (us.IDVendNS = 0,' ', (SELECT us2.name_complete FROM users us2 WHERE us2.IDVend = us.IDVendNS)) AS 'consultor' FROM users us WHERE us.id = '".$idUser."';";

		$query = $this->db->query($sqlDetalleUsuario);

		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return false;
		}
	}

	function ListaVendedores($busquedaUsuario){
		$busquedaUsuario = strtoupper($busquedaUsuario);
		$sqlBusquedaVendedor = "
			Select * From
				`users`
			Where
				(
					`profile` = '1' Or `profile` = '2'
				)
				And
				(
					`email` Like '%".$busquedaUsuario."%'
					or
					`name_complete` Like '%".$busquedaUsuario."%'
				)
			Order By
				`name_complete` Asc
							   ";
		$query = $this->db->query($sqlBusquedaVendedor);
		/*
		$this->db->from("users");
		$this->db->like('email', $busquedaUsuario);
		$this->db->or_like('name_complete', $busquedaUsuario);
		$this->db->order_by("users.profile, users.name_complete", "asc");
		$query = $this->db->get();

		if($query->num_rows() > 0){
  			$return = $query;
		} else {
			$return = "";
		}
		*/		
		return
			/* $return; */
			$query;
	} /*! ListaVendedores */
	
	function ClasificacionVendedor($EmailVendedor){
		$sqlClasificacionVendedor = "
			Select * From
				`user_miInfo`
			Where
				`emailUser` = '".$EmailVendedor."'
									";
		$query = $this->db->query($sqlClasificacionVendedor);

		if($query->num_rows() > 0){
			if($query->row()->Giro != ""){
				return 
					"&lt;".$query->row()->Giro."&gt;";
			} else {
				return 
					false;
			}
		} else {
			return false;
		}
	} /*! ClasificacionVendedor */

	function CertificacionesVendedor($EmailVendedor){
		$sqlClasificacionVendedor = "
			Select * From
				`user_miInfo`
			Where
				`emailUser` = '".$EmailVendedor."'
									";
		$query = $this->db->query($sqlClasificacionVendedor);

		if($query->num_rows() > 0){
			$result = $query->result();
			$certificaciones = "";
			
			if($result[0]->Giro == "AGENTE" || $result[0]->Giro == "AGENTE INTEGRAL"){
				$certificaciones.=" <u>|Autos|</u> ";
				$certificaciones.=" <u>|Gmm|</u> ";
				$certificaciones.=" <u>|Vida|</u> ";
				$certificaciones.=" <u>|Danos|</u> ";
				$certificaciones.=" <u>|Fianzas|</u> ";
			} else {
				if($result[0]->certificacionAutos == "SI"){
					$certificaciones.=" <u>|Autos|</u> ";
				}
				if($result[0]->certificacionGmm == "SI"){
					$certificaciones.=" <u>|Gmm|</u> ";
				}
				if($result[0]->certificacionVida == "SI"){
					$certificaciones.=" <u>|Vida|</u> ";
				}
				if($result[0]->certificacionDanos == "SI"){
					$certificaciones.=" <u>|Danos|</u> ";
				}
				if($result[0]->certificacionFianzas == "SI"){
					$certificaciones.=" <u>|Fianzas|</u> ";
				}
			}
			return
				$certificaciones;
		} else {
			return false;
		}
	} /*! CertificacionesVendedor */
	
	function cotizacionPermisos($emailUser,$profileUser){
		if($profileUser != 1){
			$permisos = array("VEHICULOS", "ACCIDENTES_Y_ENFERMEDADES", "DANOS", "VIDA", "FIANZAS");
		} else if($profileUser == 1){
			$Sql_PermisosVendedores = "
				Select * From 
					`vend_permisos`
				Where
					`emailUser` = '".$emailUser."'
									  ";
			$query = $this->db->query($Sql_PermisosVendedores);
			if($query->num_rows() > 0){
				foreach($query->result() as $permiso){
					if($permiso->tipo == "Cotizacion"){
						if($permiso->permiso == "SI"){
							$permisos[] = $permiso->ramo;
						} else {
							$permisos[] = "";
						}
					}
				}
			} else {
				$permisos[] = "";
			}
		}
	return
		$permisos;
	} /*! cotizacionPermisos */
	
	function EmailVendedor($IDVend){	
		$this->db->from("catalog_vendedores");
		$this->db->where("catalog_vendedores.IDVend", $IDVend);
		$query = $this->db->get();

		if($query->num_rows() > 0){
			return strtoupper($query->row()->EMail1);
		} else {
			return false;
		}
	}/*! EmailVendedor */
}