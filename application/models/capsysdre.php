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
//---------------------------------------------------
function AperturaContable()
    {
     $idapertura =1;  
     $this->db->select('idAperturaContable');
	 $this->db->from("aperturacontable");
	 $this->db->where("statusAbiertoAC",$idapertura); 	 
	 $query = $this->db->get();
	   
	 if ($query->num_rows() > 0){
	   return $query->row()->idAperturaContable;
	
	  }
	 return "0"; 
    }

//----------------------------------------------------

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
                (banned='0')
                And
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

//---------------------------------------------------------------------------
	function ListaClientesBant($option, $bant, $usuario){
		if($option=="AUTH"){
			$sql = "SELECT * From clientes_actualiza WHERE usuario='$usuario' AND bant_aut = '$bant' ORDER BY fechaCreacionCA DESC";
		}

		if($option=="NEED"){
			$sql = "SELECT * From clientes_actualiza WHERE usuario='$usuario' AND bant_need = '$bant' ORDER BY  fechaCreacionCA DESC";
		}

		if($option=="TIMING"){
			$sql = "SELECT * From clientes_actualiza WHERE usuario='$usuario' AND bant_timing = '$bant' ORDER BY  fechaCreacionCA DESC";
		}


		$query = $this->db->query($sql);
		return $query;
	} 
//---------------------------------------------------------------------------

//---------------------------------------------------------------------------
	function ListaClientes($busquedaUsuario,$usuario){
		$busquedaUsuario = strtoupper($busquedaUsuario);
		
		$sqlBusquedaUsuario = "Select * From `clientes_actualiza` Where usuario='".$usuario."'and 
				(`Nombre` Like '%".$busquedaUsuario."%' or `ApellidoP` Like '%".$busquedaUsuario."%' or `ApellidoM` Like '%".$busquedaUsuario."%' or `RazonSocial` Like '%".$busquedaUsuario."%')
			and `EstadoActual` <>'ELIMINADO' and `EstadoActual` <>'PAUSA' Order By
								folioActividad ASC,`fechaCreacionCA` desc
							  ";
				  
		$query = $this->db->query($sqlBusquedaUsuario);
		
		return
			$query;
	} /*! ListaCLientesp100 */
//---------------------------------------------------------------------------
	function ListaReasignados($busquedaUsuario,$usuario){
		$busquedaUsuario = strtoupper($busquedaUsuario);
		
		$sqlBusquedaUsuario = "Select * From `clientes_actualiza` Where usuarioAnterior='".$usuario."'and 
				(`Nombre` Like '%".$busquedaUsuario."%' or `ApellidoP` Like '%".$busquedaUsuario."%' or `ApellidoM` Like '%".$busquedaUsuario."%' or `RazonSocial` Like '%".$busquedaUsuario."%')
			and `EstadoActual` <>'ELIMINADO' and `callcenter` IS NULL	Order By
				`fechaCreacionCA` Desc
							  ";
								  
		$query = $this->db->query($sqlBusquedaUsuario);
		
		return
			$query;
	} /*! ListaCLientesp100 */

function envioSMS($numero,$mensaje){
  $filename = getcwd()."/../xml/config.xml";
      $response = "";
      $params = array("apikey" => "0bf959dfc9127cef8131396dd312548c6f93354c");
      curl_setopt_array($ch = curl_init(), array(
        CURLOPT_URL => "https://api.smsmasivos.com.mx/auth",
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_POST => 1,
        CURLOPT_POSTFIELDS => http_build_query($params),
        CURLOPT_RETURNTRANSFER => 1
      ));
      $response = curl_exec($ch);
      curl_close($ch);
      $response_obj = json_decode($response, true);
      $text =$mensaje;
      $number = $numero; 
      $country = "052";
      $name = "CAPITAL SEGUROS Y FIANZAS";
      $sandbox = "0";

      if($name == ""){$name = "Escribe un nombre para tu campaña ".date("Y-m-d H:i:s");}
      $params = array("message" => $text,"numbers" => $number,"country_code" => $country,"name" => $name,"sandbox" => $sandbox);
     $headers = array("token: ".$response_obj['token']);

      curl_setopt_array($ch = curl_init(), array(
        CURLOPT_URL => "https://api.smsmasivos.com.mx/sms/send",
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_HEADER => 0,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_POST => 1,
        CURLOPT_POSTFIELDS => http_build_query($params),
        CURLOPT_RETURNTRANSFER => 1
      ));
      $response = curl_exec($ch);
      curl_close($ch);
}


function reasignaClienteVendedor($idCliente,$emailAgente){
 $update['Usuario']=$emailAgente;
 $update['callcenter']=null;
 $this->db->where('IDCli',$idCliente);
 $this->db->update('clientes_actualiza',$update);

 $sql="SELECT persona.celOficina,persona.celPersonal from users,persona where users.email='$emailAgente' AND persona.idPersona=users.idPersona";
 $query = $this->db->query($sql)->result();
 foreach ($query as $row) {
 	 $celOficina=$row->celOficina;
 	 $celPersonal=$row->celPersonal;
 }
$telefono="";
$telefono1="";
$telefono2="";
if($celOficina!=''){
	$telefono1=$celOficina;
}
if($celPersonal!=''){
	$telefono2=$celPersonal;
}
if($telefono2!=''){
	$telefono=$telefono2;
}
if($telefono1!=''){
	$telefono=$telefono1;
}

	if($telefono!=''){
		$mensaje="Capital Seguros y Fianzas - Notificación: Marketing te acaba de asignar un nuevo prospecto";
		//$this->envioSMS($telefono,$mensaje);
            	  $this->envioSMS('+529996439995',$mensaje);
	} 
}




	Function ListaCLientescallcenter($busquedaUsuario,$usuario){
		$busquedaUsuario = strtoupper($busquedaUsuario);
		
		$sqlBusquedaUsuario = "
			Select * From
				`clientes_actualiza`
			Where
			   usuario='".$usuario."'
            and 
				(
					`Nombre` Like '%".$busquedaUsuario."%'
					or
					`ApellidoP` Like '%".$busquedaUsuario."%'
					or
					`ApellidoM` Like '%".$busquedaUsuario."%'
                    or
					`RazonSocial` Like '%".$busquedaUsuario."%'
				)
			and
			   `EstadoActual` <>'ELIMINADO'	
			and
			   `callcenter` = '1'   
			Order By
				`ApellidoP` Asc
							  ";
						  
		$query = $this->db->query($sqlBusquedaUsuario);
		;
		return
			$query;
	} /*! ListaCLientespCALLCENTER */

	
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
//---------------------------------------------------------------------------
function fechaProximoBaneo($email){
 $consulta="select persona.personaTipoAgente,persona.idpersonarankingagente,
TIMESTAMPDIFF(day,curdate(),DATE_ADD(cast(concat(YEAR(NOW()),'-',MONTH (NOW()),'-','01') as date),INTERVAL 1 MONTH) ) as diasBaneo 
from users
left join persona on persona.idPersona=users.idPersona
where users.email='".$email."'";
 return $this->db->query($consulta)->result();
}
//---------------------------------------------------------------------------
function obtenerGananciaMensual($email){

	$consulta='select eab.* from users u
left join envioagentesbitacora eab on eab.IDVendEAB=u.IDVend
where eab.anioEAB=YEAR(NOW()) and u.email="'.$email.'"';
  
	return $this->db->query($consulta)->result();
}

//---------------------------------------------------------------------------
	function miInfo_GuardarUsuario($emailUser, $data){
		$this->db->where('user_miInfo.emailUser', $emailUser);
		$this->db->update('user_miInfo', $data); 
	} /*! miInfo_GuardarUsuario */
//---------------------------------------------------------------------------	
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
//---------------------------------------------------------------------------
       function TipoUsuarioID($IDVend){		
		$this->db->from("users");
		$this->db->where("users.IDVend", $IDVend);
		$query = $this->db->get();

		if($query->num_rows() > 0){
			return $query->row()->idTipoUser_txt;
		} else {
			return false;
		}
	}/*! NombreVendedor*/
//---------------------------------------------------------------------------
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
//---------------------------------------------------------------------------
	function ProfilexEmail($EmailUser){		
		$this->db->from("users");
		$this->db->where("users.email", $EmailUser);
		$query = $this->db->get();

		if($query->num_rows() > 0){
			return $query->row()->profile;
		} else {
			return false;
		}
	}/*! Profile del usuario */
//---------------------------------------------------------------------------
	function IDxEmail($EmailUser){		
		$this->db->from("users");
		$this->db->where("users.email", $EmailUser);
		$query = $this->db->get();

		if($query->num_rows() > 0){
			return $query->row()->IDVend;
		} else {
			return false;
		}
	}/*! regresa el Idvendedor*/

	function GetCarcapitalxEmail($EmailUser){		
		$this->db->from("users");
		$this->db->where("users.email", $EmailUser);
		$query = $this->db->get();

		if($query->num_rows() > 0){
			return $query->row()->UsuarioCarCapital;
		} else {
			return false;
		}
	}/*! regresa el Idvendedor*/


	function GiroID($IDVend){		
		$this->db->from("user_miInfo");
		$this->db->where("user_miInfo.IDVend", $IDVend);
		$query = $this->db->get();

		if($query->num_rows() > 0){
			return $query->row()->Giro;
		} else {
			return false;
		}
	}/*! GiroVendedor*/

	function GetSucursal($Idsucursal){		
		$this->db->from("catalog_sucursales");
		$this->db->where("catalog_sucursales.IdSucursal", $Idsucursal);
		$query = $this->db->get();

		if($query->num_rows() > 0){
			return $query->row()->NombreSucursal;
		} else {
			return false;
		}
	}/*! devuelve cuscurslr*/

	function GetCanal($IDCanal){		
		$this->db->from("catalog_canales");
		$this->db->where("catalog_canales.IdCanal", $IDCanal);
		$query = $this->db->get();

		if($query->num_rows() > 0){
			return $query->row()->nombre;
		} else {
			return false;
		}
	}/*! devuelve canal*/


	function RankingID($IDVend){		
		$this->db->from("user_miInfo");
		$this->db->where("user_miInfo.IDVend", $IDVend);
		$query = $this->db->get();

		if($query->num_rows() > 0){
			return $query->row()->Ranking;
		} else {
			return false;
		}
	}/*! RankingVendedor users*/
	
	function RankingUsuarioEmail($EmailVendedor){
		$this->db->from("catalog_vendedores");
		$this->db->where("catalog_vendedores.EMail1", $EmailVendedor);
		$query = $this->db->get();

		if($query->num_rows() > 0){
			return "(".$query->row()->Clasifica_TXT.")";
		} else {
			return false;
		}
	} /*! RankingUsuarioEmail de catalog vendedroes */

	function RankingUsuarioEmaildeMiinfo($EmailVendedor){
		$this->db->from("user_miInfo");
		$this->db->where("user_miInfo.emailUser", $EmailVendedor);
		$query = $this->db->get();

		if($query->num_rows() > 0){
			return "(".$query->row()->Ranking.")";
		} else {
			return false;
		}
	} /*! RankingUsuarioEmail de Miinfo se agrego para qeu al principio traiga el ranking de la tabla miinfo*/
	
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
				`banned`,
				`CelularSMS`,
				`FechaIngresoAgente`,
				 `passwordVisible`,
                                `ActCreadaPorOtro`
	
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


	function detalleProspecto($idUser = '0'){
		$sqlDetalleUsuario = "
			Select
				*
			From
				`clientes_actualiza`
			Where
				`IDCli` = '".$idUser."';
							 ";
		

		$query = $this->db->query($sqlDetalleUsuario);

		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return false;
		}
	}

	function ListaSucursales(){
		
		$sqlBusquedaVendedor = "
			Select * From
				`catalog_sucursales`
			Order By
				`IdSucursal` Asc
							   ";
		$query = $this->db->query($sqlBusquedaVendedor);
	
		return $query;
	} /*!Devuelve sucursales*/

	function ListaCanales(){
		
		$sqlBusquedaVendedor = "
			Select * From
				`catalog_canales`
			Order By
				`IdCanal` Asc
							   ";
		$query = $this->db->query($sqlBusquedaVendedor);
	
		return $query;
	} /*!Devuelve canales*/

	function ListaVendedores($busquedaUsuario){
		$busquedaUsuario = strtoupper($busquedaUsuario);

        $userEmail=$this->tank_auth->get_usermail();
        $IdSucursal=$this->ObtieneSucursal($userEmail);
        $IdSucursal2=$this->ObtieneSucursal2($userEmail);
        $IdCanal=$this->ObtieneCanal($userEmail);

        if($IdCanal=='9') 
        {                               //No aplico filtro  x suc y canal         
           $sqlBusquedaVendedor = "
			Select * From
				`users`
			Where
                (idTipoUser=15 || idTipoUser=17 || idTipoUser=18)
                And
                (banned='0')
                And
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

        }
        else  //si aplico filtro para gerentes DE CANAL
        {

        	$sqlBusquedaVendedor = "
			Select * From
				`users`
			Where
                (idTipoUser=15 || idTipoUser=17 || idTipoUser=18)
                And
                (banned='0')
                And
				(
					(`Idsucursal` = '".$IdSucursal."' or `Idsucursal2` = '".$IdSucursal2."') and (`IdCanal` = '".$IdCanal."')
				)
				And
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
        
        }	

		$query = $this->db->query($sqlBusquedaVendedor);
		return
			$query;
	} /*! ListaVendedores */

	function ListaVendedoresSinFiltro($busquedaUsuario){

		$busquedaUsuario = strtoupper($busquedaUsuario);
        $sqlBusquedaVendedor = "
			Select * From
				`users`
			Where
                (idTipoUser=15 || idTipoUser=17 || idTipoUser=18)
                And
                (banned='0')
                And
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
		return
			$query;
	} /*! ListaVendedores */


	function ObtieneUsuarioxEmail($Email){
		$usuarito = strtoupper($Email);
        $sqlBusquedaVendedor = "
			Select * From
				`users`
			Where
					`email`= '".$usuarito."' 

							   ";
		$query = $this->db->query($sqlBusquedaVendedor);
		return
			$query;
	} /*! ObtieneUsuarioxEmail */


	function ListaVendedoresCall(){
		
        $sqlBusquedaVendedor = "
			select distinct(ca.Usuario) as email,us.name_complete from clientes_actualiza ca 
			left join users us on us.email=ca.Usuario
			where ca.usuario is not null
			and ca.callcenter='1' and ca.Usuario='TELEMARKETING@AGENTECAPITAL.COM'
			group by 2

							   ";
		$query = $this->db->query($sqlBusquedaVendedor);
		return
			$query;
	} /*! ListaVendedoresP100 */


	function ListaVendedoresP100(){
		
        $sqlBusquedaVendedor = "
			select distinct(ca.Usuario) as email,us.name_complete from clientes_actualiza ca 
			left join users us on us.email=ca.Usuario
			where ca.usuario is not null
			group by 2

							   ";
		$query = $this->db->query($sqlBusquedaVendedor);
		return
			$query;
	} /*! ListaVendedoresP100 */


	function ListaVendedoresP100xFecha($fechaini,$fechafin,$coordinadorVendedor,$mes_anio=''){
				/*
        $sqlBusquedaVendedor = "
			select distinct(ca.Usuario) as email,us.name_complete from clientes_actualiza ca
 			left join users us on us.email=ca.Usuario
 			left join puntaje p on p.IDCliente=ca.IDCli
			where ca.callcenter is null
 			and 
			cast(p.FechaRegistro as date)>='".$fechaini."' and cast(p.FechaRegistro as date)<='".$fechafin."'
			group by 2
							   ";
		*/
	$bandExistaMA=false;
	$where='';
	$filtroVendedor='';
	if($this->tank_auth->get_IDVend()>0){$filtroVendedor=' and users.idPersona='.$this->tank_auth->get_idPersona();}
	if(is_array($mes_anio))
	{
      if(isset($mes_anio['mes']) and isset($mes_anio['anio']))
      {
      	$where=" and year(puntaje.FechaRegistro )=".$mes_anio['anio']." and month(puntaje.FechaRegistro)=".$mes_anio['mes'].$filtroVendedor;
        $bandExistaMA=true;
      }
      else
      {
      	if(isset($mes_anio['anio']))
      	{
      		$where=" and year(puntaje.FechaRegistro )=".$mes_anio['anio'].$filtroVendedor;
           $bandExistaMA=true;
      	} 
      }
    }
    if(!$bandExistaMA)
    {
       $where=" and cast(puntaje.FechaRegistro as date)>='".$fechaini."' and cast(puntaje.FechaRegistro as date)<='".$fechafin."' ".$filtroVendedor;
    }

		$sqlBusquedaVendedor = "select Distinct(users.email),users.name_complete,persona.userEmailCreacion FROM users 
	INNER JOIN persona On users.idPersona = persona.idPersona
	 INNER JOIN puntaje On puntaje.usuario = users.email
     WHERE
	persona.userEmailCreacion Like '%".$coordinadorVendedor."%'".$where." Group By 2";

		
			  
		$query = $this->db->query($sqlBusquedaVendedor);
		return
			$query;
	} /*! ListaVendedoresP100unicamente los que hayan generado puntos en un rango de fecha */
	function TipoMovimiento(){
		
        $sqlBusquedaVendedor = "
			select * from tipomovimiento
							   ";
		$query = $this->db->query($sqlBusquedaVendedor);
		return
			$query;
	}
	function ListaBancos(){
		
        $sqlBusquedaVendedor = "
			select * from bancos
							   ";
		$query = $this->db->query($sqlBusquedaVendedor);
		return
			$query;
	}
	function ListaConceptos(){
		
        $sqlBusquedaVendedor = "
			select * from concepto
							   ";
		$query = $this->db->query($sqlBusquedaVendedor);
		return
			$query;
	}

	function ListaCheques()
	{
		
        $sqlBusquedaVendedor = "
			select * from cheques order by  idcheque desc
							   ";
		$query = $this->db->query($sqlBusquedaVendedor);
		return
			$query;
	}

    function ListaProveedores(){		
        $sqlBusquedaVendedor = "select * from proveedores p order by p.NombreProveedor";
		$query = $this->db->query($sqlBusquedaVendedor);
		return $query;
	} 
	 function EnviaCheque($idche){
		
        $sqlBusquedapro = "
			select * from cheques f 
			where f.IDCHEQUE='".$idche."'
							   ";
		$query = $this->db->query($sqlBusquedapro);
		return
			$query;
	} 

	function buscaProveedores($valor){

        $sqlBusquedaVendedor = 'select * from proveedores  where NombreProveedor like "%'.$valor;
        $sqlBusquedaVendedor=$sqlBusquedaVendedor.'%"';
        $sqlBusquedaVendedor.=' || Nombre_contacto like "%'.$valor.'%"';
        $sqlBusquedaVendedor.=' || telefono1 like "%'.$valor.'%"';
        $sqlBusquedaVendedor.=' || telefono_movil like "%'.$valor.'%"';
        $sqlBusquedaVendedor.=' || email like "%'.$valor.'%"';
        $sqlBusquedaVendedor.=' || direccion like "%'.$valor.'%"';
        $sqlBusquedaVendedor.=' || banco like "%'.$valor.'%"';
        $sqlBusquedaVendedor.=' || cuenta like "%'.$valor.'%"';
        $sqlBusquedaVendedor.=' || clabe like "%'.$valor.'%"';
        $sqlBusquedaVendedor.=' || extension like "%'.$valor.'%"';
        $sqlBusquedaVendedor.=' || banco 	 like "%'.$valor.'%"';
        $sqlBusquedaVendedor.=' || giroProveedor 	 like "%'.$valor.'%"';

							   ;
		$query = $this->db->query($sqlBusquedaVendedor);
		return
			$query;
	}


	 function ListaComentarios( $cliente){
		
        $sqlBusquedacomentarios = "
			select * from comentarioscall c where  c.IDCliente='".$cliente."'
							   ";
		$query = $this->db->query($sqlBusquedacomentarios);
		return
			$query;
	} 

	 function GetProveedor($idproveedor){
		
        $sqlBusquedapro = "
			select * from proveedores p 
			where p.id='".$idproveedor."'
							   ";
		$query = $this->db->query($sqlBusquedapro);
		return
			$query;
	} 

	 function GetFact($idfact){
		
        $sqlBusquedapro = "
			select * from facturas f 
			where f.id='".$idfact."'
							   ";
		$query = $this->db->query($sqlBusquedapro);
		return
			$query;
	} 


	 function GetAcumuladoMes($Usuario,$mes,$ano){
$query="";
$sqlBusquedapro="";


	 	if($mes=="01")
	 	{
	 		$sqlBusquedapro = "
			select sum(totalfactura) as acumuladomes from facturas f
			where f.usuario='".$Usuario."'
			and f.autorizadireccion='1'
			and f.fecha_factura>='".$ano."-01-01' and f.fecha_factura<='".$ano."-01-31'
							   ";
		    $query = $this->db->query($sqlBusquedapro);


        } 
        if($mes=="02")
	 	{
	 		$sqlBusquedapro = "
			select sum(totalfactura) as acumuladomes from facturas f
			where f.usuario='".$Usuario."'
			and f.autorizadireccion='1'
			and f.fecha_factura>='".$ano."-02-01' and f.fecha_factura<='".$ano."-02-31'
							   ";
		    $query = $this->db->query($sqlBusquedapro);
        } 
        if($mes=="03")
	 	{
	 		$sqlBusquedapro = "
			select sum(totalfactura) as acumuladomes from facturas f
			where f.usuario='".$Usuario."'
			and f.autorizadireccion='1'
			and f.fecha_factura>='".$ano."-03-01' and f.fecha_factura<='".$ano."-03-31'
							   ";
		    $query = $this->db->query($sqlBusquedapro);
        } 
        if($mes=="04")
	 	{
	 		$sqlBusquedapro = "
			select sum(totalfactura) as acumuladomes from facturas f
			where f.usuario='".$Usuario."'
			and f.autorizadireccion='1'
			and f.fecha_factura>='".$ano."-04-01' and f.fecha_factura<='".$ano."-04-31'
							   ";
		    $query = $this->db->query($sqlBusquedapro);
        } 
        if($mes=="05")
	 	{
	 		$sqlBusquedapro = "
			select sum(totalfactura) as acumuladomes from facturas f
			where f.usuario='".$Usuario."'
			and f.autorizadireccion='1'
			and f.fecha_factura>='".$ano."-05-01' and f.fecha_factura<='".$ano."-05-31'
							   ";
		    $query = $this->db->query($sqlBusquedapro);
        } 
        if($mes=="06")
	 	{
	 		$sqlBusquedapro = "
			select sum(totalfactura) as acumuladomes from facturas f
			where f.usuario='".$Usuario."'
			and f.autorizadireccion='1'
			and f.fecha_factura>='".$ano."-06-01' and f.fecha_factura<='".$ano."-06-31'
							   ";
		    $query = $this->db->query($sqlBusquedapro);
        } 
        if($mes=="07")
	 	{
	 		$sqlBusquedapro = "
			select sum(totalfactura) as acumuladomes from facturas f
			where f.usuario='".$Usuario."'
			and f.autorizadireccion='1'
			and f.fecha_factura>='".$ano."-07-01' and f.fecha_factura<='".$ano."-07-31'
							   ";
		    $query = $this->db->query($sqlBusquedapro);
        } 
        if($mes=="08")
	 	{
	 		$sqlBusquedapro = "
			select sum(totalfactura) as acumuladomes from facturas f
			where f.usuario='".$Usuario."'
			and f.autorizadireccion='1'
			and f.fecha_factura>='".$ano."-08-01' and f.fecha_factura<='".$ano."-08-31'
							   ";
		    $query = $this->db->query($sqlBusquedapro);
        } 
        if($mes=="09")
	 	{
	 		$sqlBusquedapro = "
			select sum(totalfactura) as acumuladomes from facturas f
			where f.usuario='".$Usuario."'
			and f.autorizadireccion='1'
			and f.fecha_factura>='".$ano."-09-01' and f.fecha_factura<='".$ano."-09-31'
							   ";
		    $query = $this->db->query($sqlBusquedapro);
        } 
        if($mes=="10")
	 	{
	 		$sqlBusquedapro = "
			select sum(totalfactura) as acumuladomes from facturas f
			where f.usuario='".$Usuario."'
			and f.autorizadireccion='1'
			and f.fecha_factura>='".$ano."-10-01' and f.fecha_factura<='".$ano."-10-31'
							   ";
							    $query = $this->db->query($sqlBusquedapro);

		       

        } 
        if($mes=="11")
	 	{
	 		$sqlBusquedapro = "
			select sum(totalfactura) as acumuladomes from facturas f
			where f.usuario='".$Usuario."'
			and f.autorizadireccion='1'
			and f.fecha_factura>='".$ano."-11-01' and f.fecha_factura<='".$ano."-11-31'
							   ";
		    $query = $this->db->query($sqlBusquedapro);
		
        } 
        if($mes=="12")
	 	{
	 		$sqlBusquedapro = "
			select sum(totalfactura) as acumuladomes from facturas f
			where f.usuario='".$Usuario."'
			and f.autorizadireccion='1'
			and f.fecha_factura>='".$ano."-12-01' and f.fecha_factura<='".$ano."-12-31'
							   ";
		    $query = $this->db->query($sqlBusquedapro);
        } 
       
		return $query->row()->acumuladomes;
	} 


	 function GetAcumuladoAno($Usuario,$ano){

	
	 		$sqlBusquedapro = "
			select sum(totalfactura) as acumuladoano from facturas f
			where f.usuario='".$Usuario."'
			and f.autorizadireccion='1'
			and f.fecha_factura>='".$ano."-01-01' and f.fecha_factura<='".$ano."-12-31'
							   ";
		    $query = $this->db->query($sqlBusquedapro);


       

		return $query->row()->acumuladoano;
	} 



	 function GetLimiteMes($Usuario,$mes){

	 	if($mes=="01")
	 	{
	 		$sqlBusquedapro = "select enero as limite from usuariospresupuesto up where up.usuario='".$Usuario."'";
		    $query = $this->db->query($sqlBusquedapro);
        } 
        if($mes=="02")
	 	{
	 		$sqlBusquedapro = "select febrero as limite from usuariospresupuesto up where up.usuario='".$Usuario."'";
		    $query = $this->db->query($sqlBusquedapro);
        } 
        if($mes=="03")
	 	{
	 		$sqlBusquedapro = "select marzo as limite from usuariospresupuesto up where up.usuario='".$Usuario."'";
		    $query = $this->db->query($sqlBusquedapro);
        } 
        if($mes=="04")
	 	{
	 		$sqlBusquedapro = "
			select abril as limite from usuariospresupuesto up 
			where up.usuario='".$Usuario."'
							   ";
		    $query = $this->db->query($sqlBusquedapro);
        } 
        if($mes=="05")
	 	{
	 		$sqlBusquedapro = "
			select mayo as limite from usuariospresupuesto up 
			where up.usuario='".$Usuario."'
							   ";
		    $query = $this->db->query($sqlBusquedapro);
        } 
        if($mes=="06")
	 	{
	 		$sqlBusquedapro = "
			select junio as limite from usuariospresupuesto up 
			where up.usuario='".$Usuario."'
							   ";
		    $query = $this->db->query($sqlBusquedapro);
        } 
        if($mes=="07")
	 	{
	 		$sqlBusquedapro = "
			select julio as limite from usuariospresupuesto up 
			where up.usuario='".$Usuario."'
							   ";
		    $query = $this->db->query($sqlBusquedapro);
        } 
        if($mes=="08")
	 	{
	 		$sqlBusquedapro = "
			select agosto as limite from usuariospresupuesto up 
			where up.usuario='".$Usuario."'
							   ";
		    $query = $this->db->query($sqlBusquedapro);
        } 
        if($mes=="09")
	 	{
	 		$sqlBusquedapro = "
			select septiembre as limite from usuariospresupuesto up 
			where up.usuario='".$Usuario."'
							   ";
		    $query = $this->db->query($sqlBusquedapro);
        } 
        if($mes=="10")
	 	{
	 		$sqlBusquedapro = "
			select octubre as limite from usuariospresupuesto up 
			where up.usuario='".$Usuario."'
							   ";
		    $query = $this->db->query($sqlBusquedapro);
        } 
        if($mes=="11")
	 	{
	 		$sqlBusquedapro = "
			select noviembre as limite from usuariospresupuesto up 
			where up.usuario='".$Usuario."'
							   ";
		    $query = $this->db->query($sqlBusquedapro);
        } 
        if($mes=="12")
	 	{
	 		$sqlBusquedapro = "
			select diciembre as limite from usuariospresupuesto up 
			where up.usuario='".$Usuario."'
							   ";
		    $query = $this->db->query($sqlBusquedapro);
        } 

		return $query->row()->limite;
	} 


	 function GetLimiteAno($Usuario){
	
	 		$sqlBusquedapro = "
			select enero+febrero+marzo+abril+mayo+junio+julio+agosto+septiembre+octubre+noviembre+diciembre as limite from usuariospresupuesto up 
			where up.usuario='".$Usuario."'
							   ";
		    $query = $this->db->query($sqlBusquedapro);

		return $query->row()->limite;
	} 



	function GetNombreProveedor($idproveedor){		
        $sqlBusquedapro = "select NombreProveedor from proveedores p where p.id='".$idproveedor."'";
		$query = $this->db->query($sqlBusquedapro);
		return $query->row()->NombreProveedor;
	}

	function GetTarjetas($idTarjetas){		
        $sql = "select numeroTarjeta from tarjetas p where p.idTarjetas='".$idTarjetas."'";
		$query = $this->db->query($sql);
		return $query->row()->numeroTarjeta;
	}

	function GetCuentaContable($idCuentaContable){		
        $sql = "select cuentaContable from relcuentacontabledepartamento p where p.idCuentaContable='".$idCuentaContable."'";
		$query = $this->db->query($sql);
		return $query->row()->cuentaContable;
	}

	function ListaPagos() {
        $sqlBusquedaVendedor = "
			select 
				f.id,
				f.fecha_captura,
				f.fecha_factura,
				f.folio_factura,
				f.concepto,
				f.montofianzas,
				f.montoinstitucional,
				f.gestion,
				f.promomid,
				f.promocun,
				f.corporativo,
				f.otromonto1,
				f.otromonto2,
				f.totalfactura,
				f.autorizadireccion,
				f.pagado,
				f.fecha_pago,
				f.Usuario,
				f.idProveedor,
				f.iva,
				f.totalconiva,
				f.posteriorapago,
				f.archivoNombreXML,
				f.archivoNombrePDF,
				f.archivoDescripcionXML,
				f.archivoDescripcionPDF,
				f.sucursal,
				f.validada,
				f.idCuentaContable,
				f.idAperturaContable,
				f.Comprobante_pago,
				'' as idPersonaDepartamento
			from facturas f 
			where f.autorizadireccion = '1' 
			and f.pagado = '0' 
			and f.posteriorapago in (0,1,3,4,5,9)

 union

			select 
				'' as id,
				'' as fecha_captura,
				'' as fecha_factura,
				'' as folio_factura,
				'SUMA DE GASTOS DE CAJA CHICA MERIDA' as concepto,
				'0' as montofianzas,
				'0' as montoinstitucional,
				'0' as gestion,
				'0' as promomid,
				'0' as promocun,
				'0' as corporativo,
				'0' as otromonto1,
				'0' as otromonto2,
				sum(f.totalfactura) as totalfactura,
				'1' as autorizadireccion,
				'0' as pagado,
				'' as fecha_pago,
				f.Usuario,
				'20' as idProveedor,
				'' as iva,
				sum(f.totalconiva) as totalconiva,
				'6' as posteriorapago,
				'' as archivoNombreXML,
				'' as archivoNombrePDF,
				'' as archivoDescripcionXML,
				'' as archivoDescripcionPDF,
				'' as Comprobante_pago,
				f.sucursal,
				f.validada,
				f.idCuentaContable,
				f.idAperturaContable,
				f.idPersonaDepartamento
			from facturas f 
			where f.autorizadireccion = '1' 
			and f.pagado = '0' 
			and f.posteriorapago = '2' 
			and f.sucursal = 'MERIDA'

 union

			select 
				'' as id,
				'' as fecha_captura,
				'' as fecha_factura,
				'' as folio_factura,
				'SUMA DE GASTOS DE CAJA CHICA NORTE' as concepto,
				'0' as montofianzas,
				'0' as montoinstitucional,
				'0' as gestion,
				'0' as promomid,
				'0' as promocun,
				'0' as corporativo,
				'0' as otromonto1,
				'0' as otromonto2,
				sum(f.totalfactura) as totalfactura,
				'1' as autorizadireccion,
				'0' as pagado,
				'' as fecha_pago,
				f.Usuario,
				'20' as idProveedor,
				'' as iva,
				sum(f.totalconiva) as totalconiva,
				'6' as posteriorapago,
				'' as archivoNombreXML,
				'' as archivoNombrePDF,
				'' as archivoDescripcionXML,
				'' as archivoDescripcionPDF,
				'' as Comprobante_pago,
				f.sucursal,
				f.validada,
				f.idCuentaContable,
				f.idAperturaContable,
				f.idPersonaDepartamento
			from facturas f 
			where f.autorizadireccion = '1' 
			and f.pagado = '0' 
			and f.posteriorapago = '2' 
			and f.sucursal = 'NORTE'

			union

			select 
				'' as id,
				'' as fecha_captura,
				'' as fecha_factura,
				'' as folio_factura,
				'SUMA DE GASTOS DE CAJA CHICA CANCUN' as concepto,
				'0' as montofianzas,
				'0' as montoinstitucional,
				'0' as gestion,
				'0' as promomid,
				'0' as promocun,
				'0' as corporativo,
				'0' as otromonto1,
				'0' as otromonto2,
				sum(f.totalfactura) as totalfactura,
				'1' as autorizadireccion,
				'0' as pagado,
				'' as fecha_pago,
				f.Usuario,
				'20' as idProveedor,
				'' as iva,
				sum(f.totalconiva) as totalconiva,
				'6' as posteriorapago,
				'' as archivoNombreXML,
				'' as archivoNombrePDF,
				'' as archivoDescripcionXML,
				'' as archivoDescripcionPDF,
				'' as Comprobante_pago,
				f.sucursal,
				f.validada,
				f.idCuentaContable,
				f.idAperturaContable,
				f.idPersonaDepartamento
			from facturas f 
			where f.autorizadireccion = '1' 
			and f.pagado = '0' 
			and f.posteriorapago = '2' 
			and f.sucursal = 'CANCUN' 
 group by f.Usuario
							   ";


		$query = $this->db->query($sqlBusquedaVendedor);
		return $query;
	}

//--------------------------------------------------------

	 function Listafacturas(){
		
        $sqlBusquedaVendedor = "
			select * from facturas f order by f.fecha_factura desc
							   ";
		$query = $this->db->query($sqlBusquedaVendedor);
		return
			$query;
	} 
//--------------------------------------------------------
	 function ListafacturasParaAutorizar(){
		
        $sqlBusquedaVendedor = "select * from facturas f where f.autorizadireccion='0' and f.pagado='0' and f.validada='1' order by f.Usuario,f.fecha_factura desc
							   ";
		$query = $this->db->query($sqlBusquedaVendedor);
		return
			$query;
	} 
//--------------------------------------------------------
	function Listafacturasxuser($user){		
        $sqlBusquedaVendedor = "select * from facturas f where f.pagado=0 and f.Usuario='".$user."' order by f.id desc";
		$query = $this->db->query($sqlBusquedaVendedor);
		return
			$query;
	} 
//-----------------------------------------------------------------------------
	function ListafacturasxuserTodas($user){		
	if(isset($user['Usuario']))
        {
        $sqlBusquedaVendedor = "select *,(cast(fecha_captura as date)) as fecFactura from facturas f where (f.fecha_captura BETWEEN '".$user['fechaInicial']."' and '".$user['fechaFinal']."') ";
        if($user['Usuario']!=''){$sqlBusquedaVendedor.=" and f.Usuario='".$user['Usuario']."'";}
        $sqlBusquedaVendedor.=' order by cast(f.fecha_captura as date) desc';
		$query = $this->db->query($sqlBusquedaVendedor);
	}
	else
	{
        $sqlBusquedaVendedor = "select * from facturas f where  f.Usuario='".$user."' order by f.id desc";
		$query = $this->db->query($sqlBusquedaVendedor);
	}


		return $query;
	} 
//-----------------------------------------------------------------------------
	function Listafacturasparavalidar(){
		
        $sqlBusquedaVendedor = "select r.cuentaContable,p.personaDepartamento,f.* from facturas f left join relcuentacontabledepartamento r on r.idCuentaContable=f.idCuentaContable
left join personadepartamento p on p.idPersonaDepartamento=r.idPersonaDepartamento where f.validada='0' order by f.fecha_factura desc";	
		$query = $this->db->query($sqlBusquedaVendedor);
		return
			$query;
	} 

//-----------------------------------------------------------------------------
	function SumaPresupuestos()
	{		
        $sqlBusquedaVendedor = "select sum(f.totalfactura) as simota from facturas f where f.autorizadireccion='0' and f.validada='1'";
		$query = $this->db->query($sqlBusquedaVendedor);
		return $query->row()->simota;
	} 

	
	function ClasificacionVendedor($EmailVendedor){
		$sqlClasificacionVendedor = "Select * From `user_miInfo` Where `emailUser` = '".$EmailVendedor."'";
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

	function NombreCompletoVendedor($IDVend){	
		$this->db->from("catalog_vendedores");
		$this->db->where("catalog_vendedores.IDVend", $IDVend);
		$query = $this->db->get();

		if($query->num_rows() > 0){
			return strtoupper($query->row()->NombreCompleto);
		} else {
			return false;
		}
	}/*! Nombre Completo de Vendedor */

	function NombreCompletoUsuarioCreacion($email){	
		$this->db->from("users");
		$this->db->where("users.Email", $email);
		$query = $this->db->get();

		if($query->num_rows() > 0){
			return strtoupper($query->row()->name_complete);
		} else {
			return false;
		}
	}/*! Nombre Completo Usuario Creacion */

	function NombreCompletoUsuarioResponsable($email){	
		$this->db->from("users");
		$this->db->where("users.Email", $email);
		$query = $this->db->get();

		if($query->num_rows() > 0){
			return strtoupper($query->row()->name_complete);
		} else {
			return false;
		}
	}/*! Nombre Completo Usuario Responsable */

	function ObtieneSucursal($email){	
		$this->db->from("users");
		$this->db->where("users.Email", $email);
		$query = $this->db->get();

		if($query->num_rows() > 0){
			return strtoupper($query->row()->IdSucursal);
		} else {
			return false;
		}
	}/*! Obtiene sucursal */

	function ObtieneSucursal2($email){	
		$this->db->from("users");
		$this->db->where("users.Email", $email);
		$query = $this->db->get();

		if($query->num_rows() > 0){
			return strtoupper($query->row()->IdSucursal2);
		} else {
			return false;
		}
	}/*! Obtiene csucursal2 */

	function ObtieneCanal($email){	
		$this->db->from("users");
		$this->db->where("users.Email", $email);
		$query = $this->db->get();

		if($query->num_rows() > 0){
			return strtoupper($query->row()->IdCanal);
		} else {
			return false;
		}
	}/*! Obtiene canal */
//------------------------------------------------------------------------------------------
	function usuariosDePresupuestos()
{$sqlBusquedaVendedor = "select usuario from usuariospresupuesto where activo=1";
 $query = $this->db->query($sqlBusquedaVendedor);
 return $query;
}
//------------------------------------------------------------------------------------------
function devuelveFacturas($usuario){
	/*"SISTEMAS@ASESORESCAPITAL.COM"
GROUP by MONTH(fecha_factura) */
$sqlBusquedaVendedor = 'Select (MONTH(fecha_factura)) as mes,(sum(facturas.totalfactura)) as suma FROM facturas 
WHERE (MONTH(fecha_factura) BETWEEN 1 and 12) AND YEAR(fecha_factura) = 2018';
if($usuario!="TODOS"){$sqlBusquedaVendedor=$sqlBusquedaVendedor.' and usuario="'.$usuario.'" GROUP by MONTH(fecha_factura)';}
else{$sqlBusquedaVendedor=$sqlBusquedaVendedor.' GROUP by MONTH(fecha_factura)';}
 $query = $this->db->query($sqlBusquedaVendedor);
	

 return $query->result();
  }

 //------------------------------------------------------------------------------------------
function devuelvePresupuesto($usuario){
if($usuario!="TODOS"){
$sqlBusquedaVendedor = 'select (enero) as "T1", 
(febrero) as "T2",(marzo) as "T3",(abril) as "T4",(mayo) as "T5",(junio) as "T6",
(julio) as "T7",(agosto) as "T8",(septiembre) as "T9",(octubre) as "T10",(noviembre) as "T11",(diciembre) as "T12" from usuariospresupuesto ';
	$sqlBusquedaVendedor=$sqlBusquedaVendedor.'where usuario="'.$usuario.'"';
}
else{
	$sqlBusquedaVendedor ='select (sum(enero)) as "T1", 
(sum(febrero)) as "T2",(sum(marzo)) as "T3",(sum(abril)) as "T4",(sum(mayo)) as "T5",(sum(junio)) as "T6",
(sum(julio)) as "T7",(sum(agosto)) as "T8",(sum(septiembre)) as "T9",(sum(octubre)) as "T10",(sum(noviembre)) as "T11",(sum(diciembre)) as "T12"
 from usuariospresupuesto ';
}


 $query = $this->db->query($sqlBusquedaVendedor);

 return $query->result();

 }
//------------------------------------------------------------------------------------------
 function devuelvePresupuestoAutorizado($usuario){
$sqlBusquedaVendedor = 'Select (MONTH(fecha_factura)) as mes,(sum(facturas.totalfactura)) as suma FROM facturas WHERE (MONTH(fecha_factura) BETWEEN 1 and 12) AND YEAR(fecha_factura) = 2018 ';
if($usuario!="TODOS"){$sqlBusquedaVendedor=$sqlBusquedaVendedor.'and usuario="'.$usuario.'" and autorizadireccion=1 GROUP by MONTH(fecha_factura)';}
else{$sqlBusquedaVendedor=$sqlBusquedaVendedor.' and autorizadireccion=1 GROUP by MONTH(fecha_factura)';}
 $query = $this->db->query($sqlBusquedaVendedor);
 return $query->result();

 }
 //------------------------------------------------------------------------------------------
 function devolverPresupuestoAutorizado($array){
 	
 	if(isset($array['mes']))
 	{
 	$consulta='Select (sum(f.totalfactura)) as suma FROM facturas f WHERE (MONTH(f.fecha_factura) BETWEEN 1 and 12) and f.idPersonaDepartamento='.$array['idPersonaDepartamento'].'  and f.autorizadireccion=1 and f.idAperturaContable='.$array['idAperturaContable'].' and MONTH(f.fecha_factura)='.$array['mes'];
    }
    else
    {
 	$consulta='Select (sum(f.totalfactura)) as suma FROM facturas f WHERE (MONTH(f.fecha_factura) BETWEEN 1 and 12) and f.idPersonaDepartamento='.$array['idPersonaDepartamento'].'  and f.autorizadireccion=1 and f.idAperturaContable='.$array['idAperturaContable'];

    }
 	 
 	 $datos=$this->db->query($consulta)->result()[0]->suma;
 	
 	 if($datos!=''){return $datos;}
 	 else{return 0;}

 }

 //------------------------------------------------------------------------------------------
 function devolverPresupuestoPagado($array){
 	$consulta='Select (sum(f.totalfactura)) as suma FROM facturas f WHERE (MONTH(f.fecha_factura) BETWEEN 1 and 12) and f.idPersonaDepartamento='.$array['idPersonaDepartamento'].'  and f.pagado=1 and f.idAperturaContable='.$array['idAperturaContable'].' and MONTH(f.fecha_factura)='.$array['mes'];
 	 $datos=$this->db->query($consulta)->result()[0]->suma;
 	 
 	 if($datos!=''){return $datos;}
 	 else{return 0;}

 }
 //------------------------------------------------------------------------------------------ 
function devuelvePresupuestoPagado($usuario){
$sqlBusquedaVendedor = 'Select (MONTH(fecha_factura)) as mes,(sum(facturas.totalfactura)) as suma FROM facturas 
WHERE (MONTH(fecha_factura) BETWEEN 1 and 12) AND YEAR(fecha_factura) = 2018 ';
if($usuario!="TODOS"){$sqlBusquedaVendedor=$sqlBusquedaVendedor.'and usuario="'.$usuario.'" and pagado=1 GROUP by MONTH(fecha_factura)';}
else{$sqlBusquedaVendedor=$sqlBusquedaVendedor.' and pagado=1 GROUP by MONTH(fecha_factura)';}
 $query = $this->db->query($sqlBusquedaVendedor);
  
 return $query->result();

 }
 //------------------------------------------------------------------------------------------
 	function devolverDatosActividades($emailVendedor){
    $consulta='select im.Giro,p.idpersonarankingagente,pta.personaTipoAgente
from user_miInfo im
left join persona p on p.idPersona=im.idPersona
left join personatipoagente pta on pta.idPersonaTipoAgente=p.personaTipoAgente
where im.emailUser="'.$emailVendedor.'"';
return $this->db->query($consulta)->result();

	}

}
