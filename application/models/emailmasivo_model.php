<?php
class emailmasivo_model extends CI_Model{
	var $lsActividades = array();
	var $Actividad;
	var $Invitados;
	var $InvitadosAndPromotor = array();
	var $Promotores = array();
	var $Useralias = array();
	var $VendedorPromotor = array();
	var $data = array();
	var $data_id;
	var $forIDVendNS = array();
	
	public function __Construct(){
		parent::__Construct();
	}
	public function Insert_envio_correos($data){
		
		$insert_value = false;
		
		try{
			
			$this->db->trans_begin();
			
			
			$hoy = new DateTime('now');
			$date = $hoy->format("Y-m-d H:i:s");
			
			$old = new DateTime('1900-01-01 00:00:00');
			$datesend = $old->format("Y-m-d H:i:s");

			$sMensaje = $data["mensaje"];

			$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($sMensaje, TRUE));fclose($fp);	
			// $sMensaje = str_replace("files/", base_url()."files/", $sMensaje);
			$sMensaje = str_replace( array(
											'"http://files/',
											'"files/'
									), 
									array(
										   '"'.base_url().'files/',
										   '"'.base_url().'files/'
								    ), 
									$sMensaje);
		
			$data_table = array(
					'fechacreacion' => $date,
					// 'desde' => 'CAPSYS Web <do-not-reply@capsys.com.mx>',
					'desde' => $data["desde"], 
					'para' => $data["para"],
					'copia' => $data["cc"],
					'copiaOculta' => $data["bcc"],
					'asunto' => htmlentities($data["asunto"]),
					'mensaje' => $sMensaje,
					'fileAdjunto' => $data["archivoAdjunto"],
					'nameAdjunto' => $data["nameArchivo"],
					'status' => '0',
					'fechaEnvio' => $datesend
			);
			
			$this->db->insert('envio_correos', $data_table);
			
			if ($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
			}
			else
			{
				$this->db->trans_commit();
				$insert_value = true;
			}

		}catch(Exception $e){
			
		}
		
		return $insert_value;
	}
	
	public function get_CabInvitados($data){ //[Dennis: checar]
		try{			
			
			$data = array(
								"id" => '4',
								"role" => "PROMOTOR");
												
			$this->db->select("b.id,a.idTipoUser,a.alias,a.nombre,b.username,b.IDVendNS,b.email");								
			$this->db->from("catalog_tipouser a");
			$this->db->join("users b", "a.idTipoUser = b.idTipoUser", "inner");

			if(is_array($data)){
				
				$this->data = $data;			
				
				switch($this->data["role"]){
					case "MASTER":
					//ninguna restriccion
					//busca toda la relacion de ususarios
					//Agrupacion
					
					//->todos gerentes 
					//->todos ejecutivos
					//->todos promotores
					//->todos vendedores
					//->todos los vendedores de los promotoes
					//->-->todos los vendedores del promotor x
					//->-->todos los vendedores del promotor y
					//->-->--> todos los clientes de tal vendedor
					
					break;
					case "GERENTE" :
					//Gerente
					//ve a sus ejeecutivos
					//ve los promotores de sus ejecutivoa
					//ve los vendedores de sus ejecutivos
					//ve los vendedores del promotos de ese ejecutivo
					
					break;
					case "EJECUTIVO":
					//ve los promotores de sus ejecutivoa
					//ve los vendedores de sus ejecutivos
					//ve los vendedores del promotos de ese ejecutivo
					$this->db->where("b.id", $data['id']);
					$this->db->group_by ("a.idTipoUser");
					$this->Invitados = $this->db->get();										
					
					if ($this->Invitados->num_rows() > 0){
			
						foreach ($this->Invitados->result_array() as $invitado => $value) {
							
							$array_data = array(
								"id" => $value["id"],
								"IDVendNS" => $value["id"],
								"alias" => $value["alias"]
							);															
							
							$ArrayInvitado = $this->get_forIDVendNS($array_data);
							
							$Promotor = array(
									"alias" => $value["alias"],
									"email" => $value["email"],
									"id" => $value["id"],
									"IDVendNS" => $value["IDVendNS"],
									"idTipoUser" => $value["idTipoUser"],
									"nombre" => $value["nombre"],
									"username" => $value["username"],
									"Vendedores" => (array)$ArrayInvitado[0]
									);
									
																	
							array_push($this->Promotores,$Promotor);
														
						}

						$this->InvitadosAndPromotor = $this->Promotores;
					}			
					
					break;
					case "PROMOTOR":
					//ve los promotores de sus ejecutivoa
					//ve los vendedores de sus ejecutivos
					//ve los vendedores del promotos de ese ejecutivo
						$this->db->where("b.id", $data['id']);
						$this->db->group_by ("a.idTipoUser");
						$this->Invitados = $this->db->get();
											
						
						if ($this->Invitados->num_rows() > 0){							
							$this->InvitadosAndPromotor = $this->get_promotor($this->Invitados);
						}						
					
					break;
					case "VENDEDOR":
					//ve los promotores de sus ejecutivoa
					//ve los vendedores de sus ejecutivos
					//ve los vendedores del promotos de ese ejecutivo
						$this->db->where("b.id", $data['id']);
						$this->db->group_by ("a.idTipoUser");
						$this->Invitados = $this->db->get();
											
						
						if ($this->Invitados->num_rows() > 0){
				
							foreach ($this->Invitados->result_array() as $invitado => $value) {
								
								$array_data = array(
									"id" => $value["id"],
									"IDVendNS" => $value["IDVendNS"],
									"alias" => $value["alias"]
								);															
								
								$ArrayInvitado = $this->get_forIDVendNS($array_data);
								
								$arrayPromotor = array($value["alias"] => $ArrayInvitado);					
								array_push($this->InvitadosAndPromotor,$arrayPromotor);			
							}			
						}
					
					break;
					
					default:
					break;
				}
				
			}	
			
				
			//var_dump($this->InvitadosAndPromotor);		
			
			// if ($this->Invitados->num_rows() > 0){
				
				// foreach ($this->Invitados->result_array() as $invitado => $value) {
										
					// $ArrayInvitado = $this->get_UserForAlias($value["alias"]);
					
					// $arrayPromotor = array($value["alias"] => $ArrayInvitado);					
					// array_push($this->InvitadosAndPromotor,$arrayPromotor);			
				// }			
			// }
						
		}catch(Exception $e){
			echo 'Excepci&oacute;n capturada: ',  $e->getMessage(), "\n";
		}	
		
		return json_encode($this->InvitadosAndPromotor);
	}
	
	public function get_forIDVendNS($data){
		
		try{			
			
			$this->db->select("b.id,a.idTipoUser,a.alias,a.nombre,b.username,b.IDVendNS,b.email");
			$this->db->join("users b", "a.idTipoUser = b.idTipoUser", "inner");
			//$this->db->where("a.alias",$alias);
			$this->db->where("b.IDVendNS",$data["id"]);
			
			$this->Invitados = $this->db->get("catalog_tipouser a");
			
			if ($this->Invitados->num_rows() > 0){

				$this->VendedorPromotor = $this->Invitados->result_array();
			}else{
				$result = array();
			}
									
		}catch(Exception $e){
			echo 'Excepci&oacute;n capturada: ',  $e->getMessage(), "\n";
		}
		
		return array($this->VendedorPromotor);
	}
	
	public function get_foridUser($data){
		
		try{	
			
			$this->db->select("b.id,a.idTipoUser,a.alias,a.nombre,b.username,b.IDVendNS,b.email");
			$this->db->join("users b", "a.idTipoUser = b.idTipoUser", "inner");
			//$this->db->where("a.alias",$data["alias"]);
			$this->db->where("b.id",$data["id"]);
			
			$this->Invitados = $this->db->get("catalog_tipouser a");
			
			if ($this->Invitados->num_rows() > 0){
				$this->VendedorPromotor = $this->Invitados->result_array();
			}else{
				$this->VendedorPromotor = array();
			}
			
						
		}catch(Exception $e){
			echo 'Excepci&oacute;n capturada: ',  $e->getMessage(), "\n";
		}
		
		return array($this->VendedorPromotor);
	}
	
	public function get_promotor($data){
		try{
			
			foreach ($data->result_array() as $invitado => $value) {
								
				$array_data = array(
					"id" => $value["id"],
					"IDVendNS" => $value["id"],
					"alias" => $value["alias"]
				);															
				
				$ArrayInvitado = $this->get_forIDVendNS($array_data);
				
				$Promotor = array(
						"alias" => $value["alias"],
						"email" => $value["email"],
						"id" => $value["id"],
						"IDVendNS" => $value["IDVendNS"],
						"idTipoUser" => $value["idTipoUser"],
						"nombre" => $value["nombre"],
						"username" => $value["username"],
						"Vendedores" => (array)$ArrayInvitado[0]
						);
						
														
				array_push($this->Promotores,$Promotor);
											
			}
			
		}catch(Exception $e){
			
		}
		return $this->Promotores;
	}
	
	public function get_dataEmail($data){ //band0
		
		$table = array();
		$data_temp = array();
		
		//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($data,TRUE));fclose($fp);	

		if(is_array($data))
		{	
			//var_dump($data);
			$idTipoUser = $data["IdTipoUser"];
			$Profile 	= $data["Profile"];
			$nProfile 	= $this->catalogos_model->get_Profile($Profile);


			if($this->role->Is_Mater($data) || $this->role->Is_Operativo($data))
			{
			
				//if(Is_Master($data)){
					// var_dump($this->role->getID());
					// var_dump($this->role->getIDNS());
				$_role_id_user 			= $this->role->getID();	
				$_role_id_user_super 	= $this->role->getIDNS();


				if($_role_id_user == 0 && $_role_id_user_super  == 0)
				{
					$this->db->select();
					$this->db->where("activo","0");
					$this->db->order_by('orden','ASC');
					$tipo = $this->db->get("catalog_tipouser");

                    $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($tipo->result(),TRUE));fclose($fp);		
   
					if ($tipo->num_rows() > 0)  //TRAE LOS CATALOG_TIPO UACTIVOS
					{
						foreach ($tipo->result_array() as $invitado => $value) {
							//var_dump($value);
							$table["Name"] = $value["nombre"];						
							$table["IdUser"] = $value["idTipoUser"];	
							$table["Data"] = $this->getUserForIdSuperior($value["idTipoUser"],$_role_id_user_super,$nProfile);

							//	$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($table["Data"],TRUE));fclose($fp);

							array_push($data_temp, $table);
									
						}

					}
					/*   $table["Name"]="Prueba";
						$table["IdUser"]=1000;
						$table["Data"]="Prueba";
                       array_push($data_temp, $table);*/
				}	

			}
			else if($this->role->Is_Promotor($data))
			{
				$_role_id_user 			= $this->role->getID();	
				$_role_id_user_super 	= $this->role->getIDNS();

				if($_role_id_user == $_role_id_user_super && $_role_id_user_super > 0 )
				{
					$this->db->select();
					$this->db->where('idTipoUser',$this->tank_auth->get_idTipoUser() );
					$tipo = $this->db->get("catalog_tipouser");
					
					// var_dump($tipo->result_array());
					
					if ($tipo->num_rows() > 0){
						foreach ($tipo->result_array() as $invitado => $value) 
						{ 
							$table["Name"] = $value["nombre"];						
							$table["IdUser"] = $value["idTipoUser"];						
							$table["Data"] = $this->getUserForIdSuperior($value["idTipoUser"],$_role_id_user_super,$nProfile);								
															
							array_push($data_temp, $table);
									
						}
					}
				}
			}
			else if($this->role->Is_Vendedor($data))
			{	
				$_role_id_user 			= $this->role->getID();	
				$_role_id_user_super 	= $this->role->getIDNS();	
				
				if($_role_id_user != $_role_id_user_super && $_role_id_user_super  > 0 && $_role_id_user > 0)
				{		
					$this->db->select();
					$this->db->where('idTipoUser',$this->tank_auth->get_idTipoUser() );
					$tipo = $this->db->get("catalog_tipouser");
					
					if ($tipo->num_rows() > 0){
						foreach ($tipo->result_array() as $invitado => $value) { 
							$table["Name"] = $value["nombre"];						
							$table["IdUser"] = $value["idTipoUser"];						
							$table["Data"] = $this->getUserForIdSuperior($value["idTipoUser"],$_role_id_user,$nProfile);																							
							array_push($data_temp, $table);
									
						}
					}
				}

			}			
		}
	
		return $data_temp;
		
	}/*! get_dataEmail */
	
	private function getUserForIdSuperior($idSuperior,$ID,$rol){
		try
		{
		 	//var_dump("Superrior: ".$idSuperior." ID: ".$ID." ROL: ".$rol);
			//$this->db->select();
	
			$this->db->where("banned","0");
			$this->db->where("activated","1");
			
			$this->db->where("idTipoUserSMSmail",$idSuperior); 
			
			if ($rol == "PROMOTOR") 
			{
				$this->db->where("IDVendNS",$ID);
			}
			else if ($rol == "VENDEDOR"){
				$this->db->where("IDVend",$ID);
			}
			$this->db->order_by("name_complete","Asc");
			$tipo = $this->db->get("users");


			//[Dennis 2020-08-07]: comentado por requerimiento de direccion, no se debe reflejar Marketing Proyecto 100
          /*if($idSuperior==21){
          	$consulta='select (IDCli) as  IDVend,(IDCli) as  id,(concat(Nombre," ",ApellidoP," ",ApellidoM )) as name_complete, (EMail1) as email,(Telefono1) as CelularSMS, 0 as banned, 9 as IdCanal, 4 as idTipoUserSMSmail
from clientes_actualiza where EstadoActual="ELIMINADO" and basuraSMSEmail=0';

            $tipo=$this->db->query($consulta);
          //  
          } */

		  //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($tipo->result_array(),TRUE));fclose($fp);
			$temp = array();
			
			if ($tipo->num_rows() > 0){
				foreach ($tipo->result_array() as $invitado => $value) 
				{ 	#GetClient

					$table["IDVend"]   = $value["IDVend"];
					$table["id"]         = $value["id"];
					$table["idPersonaA"]= $value["idPersona"]; //[Dennis 2020-08-07]
					$table["username"] = $value["name_complete"];
					$table["idTipoUser"] =  $idSuperior;
					$table["email"]    = $value["email"];
					$table["CelularSMS"]    = $value["CelularSMS"];
					$table["banned"]	= $value["banned"];
					$table["Canal"]   = $this->get_canal($value["IdCanal"]);
					$table["idTipoUserSMSmail"]	= $value["idTipoUserSMSmail"];
				 	if($idSuperior == '6' ){
                        $table["vendedores"] = ($rol != "VENDEDOR" && $value["IDVend"] == $value["IDVendNS"]) ? $this->getUserByIdSuperior($value["IDVend"]) : null;    
                    }
					#$table["Clientes"] = $this->webservice_sicas_soap->GetClient_forIdVend(array( "IdVend" => $value["IDVend"]));

					array_push($temp, $table);		
				} 
				
				return $temp;
			}
			
		}catch(Exception $e){
			
		}
	}	
	
	public function get_VendedoresPromotor($IdPromotor){
		try{	
			$this->db->select("b.id,a.idTipoUser,a.alias,a.nombre,b.username,b.IDVendNS,b.email");
			$this->db->join("users b", "a.idTipoUser = b.idTipoUser", "inner");
			$this->db->where("b.IDVendNS",$IdPromotor);
			$this->Invitados = $this->db->get("catalog_tipouser a");
			
			if ($this->Invitados->num_rows() > 0){
				$this->VendedorPromotor = $this->Invitados->result_array();
			}else{
				$this->VendedorPromotor = array();
			}
						
		}catch(Exception $e){
			echo 'Excepci&oacute;n capturada: ',  $e->getMessage(), "\n";
		}
		
		return array($this->VendedorPromotor);
	}
	
	public function get_vendedor($data){
		
		try{
			
			foreach ($data->result_array() as $invitado => $value) {
								
				$array_data = array(
					"id" => $value["id"],
					"IDVendNS" => $value["id"],
					"alias" => $value["alias"]
				);															
				
				$ArrayInvitado = $this->get_forIDVendNS($array_data);
				
				$Promotor = array(
						"alias" => $value["alias"],
						"email" => $value["email"],
						"id" => $value["id"],
						"IDVendNS" => $value["IDVendNS"],
						"idTipoUser" => $value["idTipoUser"],
						"nombre" => $value["nombre"],
						"username" => $value["username"],
						"Vendedores" => $ArrayInvitado
						);
						
														
				array_push($this->Promotores,$Promotor);
											
			}
			
		}catch(Exception $e){
			
		}
		return $this->Promotores;
	}

	public function get_gerente($data){
		try{
			
			$this->db->select("b.id,a.idTipoUser,a.alias,a.nombre,b.username,b.IDVendNS,b.email");
			$this->db->join("users b", "a.idTipoUser = b.idTipoUser", "inner");
			$this->db->where("a.alias","gerente");
			//$this->db->where("b.id",$data["id"]);
			$this->Invitados = $this->db->get("catalog_tipouser a");
			
			if ($this->Invitados->num_rows() > 0){
				$result = $this->Invitados->result_array();
			}else{
				$result = array();
			}
			
		}catch(Exception $e){
			
		}
		
		return $result;
	}
	
	public function get_ejecutivo($data){
		try{
			
		}catch(Exception $e){
			
		}
	}
	
	public function get_alias($data){
		$result = array();
		
		try{
			if(is_array($data)){
				$this->db->select("b.id,a.idTipoUser,a.alias,a.nombre,b.username,b.IDVendNS,b.email");
				$this->db->join("users b", "a.idTipoUser = b.idTipoUser", "inner");
				$this->db->where("a.alias",$data["alias"]);				
				$this->Invitados = $this->db->get("catalog_tipouser a");
			
				if ($this->Invitados->num_rows() > 0){
					$result = $this->Invitados->result_array();
				}
				
				// var_dump($result);
			}	
			
		}catch(Exception $e){
			
		}
		
		return $result;
	}
	
	public function get_Promotor_get_Vendedores($data){
				
		if(is_array($data)){
			
			foreach($data as $item){
				
				$vendedoresPromotor = $this->get_forIDVendNS($item);
				
				$Promotor = array(
											"alias" => $item["alias"],
											"email" => $item["email"],
											"id" => $item["id"],
											"IDVendNS" => $item["IDVendNS"],
											"idTipoUser" => $item["idTipoUser"],
											"nombre" => $item["nombre"],
											"username" => $item["username"],
											"Vendedores" => $vendedoresPromotor
											);
				array_push($this->Promotores,$Promotor);
							
				//array_push($this->Useralias,$this->Promotores);
			}
			
		}

		return $this->Promotores;
		
	}
	
	public function get_UserForAlias($data){
		try{	
		
			if(is_array($data)){
				
				$this->db->select("b.id,a.idTipoUser,a.alias,a.nombre,b.username,b.IDVendNS,b.email");
				$this->db->join("users b", "a.idTipoUser = b.idTipoUser", "inner");
				$this->db->where("a.alias",$data["alias"]);
				$this->db->where("b.id",$data["id"]);
				
				$this->Invitados = $this->db->get("catalog_tipouser a");
				
				if ($this->Invitados->num_rows() > 0){
									
					foreach ($this->Invitados->result_array() as $invitado => $value) { 
						
						if(strtoupper($value["alias"]) == "PROMOTOR"){
							$vendedoresPromotor = $this->get_VendedoresPromotor($value["id"]);						 
							
							$Promotor = array(
											"alias" => $value["alias"],
											"email" => $value["email"],
											"id" => $value["id"],
											"IDVendNS" => $value["IDVendNS"],
											"idTipoUser" => $value["idTipoUser"],
											"nombre" => $value["nombre"],
											"username" => $value["username"],
											"Vendedores" => (array)$vendedoresPromotor[0]
											);
																			
							array_push($this->Promotores,$Promotor);
							
							array_push($this->Useralias,$this->Promotores);
							
							
						}										
					}
				}	
			}			
						
		}catch(Exception $e){
			echo 'Excepci&oacute;n capturada: ',  $e->getMessage(), "\n";
		}
		
		return $this->Useralias;
	}
		
	private function getUserByIdSuperior($idSuperior){
		try{
			
			$this->db->select();
			$this->db->where("IDVendNS",$idSuperior);
			$this->db->where("banned","0");
			$this->db->order_by("name_complete","Asc");
			$tipo = $this->db->get("users");
			
			if ($tipo->num_rows() > 0)
			{				
				return $tipo->result_array();
			}
			
		}catch(Exception $e){
			
		}
	}

	private function get_canal($idCanal){
		try{
			
			$this->db->select("nombreTitulo");
			$this->db->where("IdCanal",$idCanal);
			$tipo = $this->db->get("catalog_canales");
			
			if ($tipo->num_rows() > 0)
			{			
			    $result = $tipo->result_array();	

			    foreach ($result as $value) {
				 $canalito=$value["nombreTitulo"];
				 }
				return $canalito;
			}
			
		}catch(Exception $e){
			
		}
	}
		
	public function getReporte($email){
		$query = $this->db->query("SELECT * FROM envio_correos ec WHERE ec.desde LIKE '%".$email."%' GROUP BY ec.asunto ORDER BY ec.fechaCreacion DESC;");
		$result = array();
		if($query->num_rows() > 0){
			$rss = $query->result_array();


			foreach ($rss as $key => $value) {
				$itrs = array(
					'desde' => $value['desde'],
					'asunto'=>$value['asunto'],
					'fechaCreacion'=>$value['fechaCreacion'],);

				array_push($result, $itrs);
			}
		}
		return $result;
	}

	public function getReporteDetalle($asunto,$desde){ //Modificado [Suemy][2024-08-16]
		$query = $this->db->query("SELECT ec.* FROM envio_correos ec WHERE ec.asunto ='".$asunto."' AND ec.desde = '".$desde."'");
		$result = array();
		if($query->num_rows() > 0){
			$result = $query->result_array();
		}
		return $result;
	}

	//---------------------------------------------------------------------------------------------------------------------------
	//[Dennis 2020-06-21] band1
	function obtenerEmailAgentesXCoor($data){

		$matrizResultado=array();

		if($this->role->Is_Mater($data) || $this->role->Is_Operativo($data)){

			//consulta que devuelve tipo de usuario de la tabla catalog_tipouser.
			//consulta tomado del metodo: get_dataEmail();
			$this->db->where("activo","0");
			$this->db->order_by('orden','ASC');
			$tipoUsuario = $this->db->get("catalog_tipouser")->result();

			//Replica del manejo de array del metodo: get_dataEmail();
			foreach($tipoUsuario as $valor){
				$resultado["Name"]=$valor->nombre;
				$resultado["IdUser"]=$valor->idTipoUser;
				$resultado["Data"]=$this->devuelveAgentesActivos($valor->idTipoUser,$data["usuario"]);

				array_push($matrizResultado,$resultado);
			}
			return $matrizResultado;
		}
	}
	//---------------------------------------------------------------------------------------------------------
	//[Dennis 2020-06-21]
	function devuelveAgentesActivos($tipoUser, $coor){

		$agente=array();
		//Consulta que devuelve a los agentes activos del coordinador.
		//$this->db->select("name_complete,email,alias");
		$this->db->from("persona");
		$this->db->join("users","users.idPersona=persona.idPersona","inner");
		$this->db->join("catalog_tipouser","catalog_tipouser.idTipoUser=users.idTipoUser","inner");
		$this->db->where("bajaPersona",0);
		$this->db->where("banned",0);
		$this->db->where("activated",1);

		if($coor != "SISTEMAS@ASESORESCAPITAL.COM" && $coor != "DIRECTORGENERAL@AGENTECAPITAL.COM" &&
			$coor != "AUDITORINTERNO@AGENTECAPITAL.COM" && $coor!="SUBGERENTE@CAPCAPITAL.COM.MX" && $coor!="GERENTE@CAPCAPITAL.COM.MX" &&
			$coor!="MARKETING@AGENTECAPITAL.COM" && $coor!="GERENTEOPERATIVO@AGENTECAPITAL.COM" && $coor!="GERENTE@FIANZASCAPITAL.COM"){
			$this->db->where("userEmailCreacion",$coor);
			$this->db->where("tipoPersona",3);
		}
		
		$this->db->where("users.idTipoUser",$tipoUser);
		$this->db->order_by("name_complete","ASC");
		$query=$this->db->get();

		//Replica del manejo de array del metodo: getUserForIdSuperior();
		if($query->num_rows()>0){
			foreach($query->result() as $valor){
				$agentesActivos["idPersonaA"]=$valor->idPersona;
				$agentesActivos["IDVend"]=$valor->IDVend;
				$agentesActivos["id"]=$valor->id;
				$agentesActivos["username"]=$valor->name_complete;
				$agentesActivos["idTipoUser"]=$tipoUser;
				$agentesActivos["email"]=$valor->email;

				array_push($agente, $agentesActivos);
			}
			return $agente;
		}
	}
	//---------------------------------------------------------------------------------------------------------------------------
	//[Dennis 2020-07-01]
	function inserta_correos_externos($correos){
		
		if(isset($correos)){
			foreach($correos as $valor){
				$this->db->insert("catalog_correos_externos",$valor);

				if($this->db->trans_status()===FALSE){
					$this->db->trans_rollback();
				} else{
					$this->db->trans_commit();
				}

			}
		}
	}
	//---------------------------------------------------------------------------------------------------------------------------
	function obtenerCorreosExternosActivos($evento){
		
		$resultado=array();

		$this->db->where("id_evento", $evento);
		$this->db->where("activo",1);
		$query=$this->db->get("catalog_correos_externos");

		if($query->num_rows()>0){
			$resultado=$query->result();
		}

		return $resultado;

	}

	//---------------------------------------------------------------------------------------------------------------------------
	function devuelve_correoExt_unitario($emailE, $evento){

		$resultado=false;

		$this->db->where("correo_externo", $emailE);
		$this->db->where("id_evento",$evento);
		$this->db->where("activo",1);
		$query=$this->db->get("catalog_correos_externos");

		if($query->num_rows()>0){
			$resultado=true;
		}

		return $resultado;

	}
	
	//---------------------------------------------------------------------------------------------------------------------------
}
?>