<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$mensajeGeneral="";

class callcenter extends CI_Controller{
	
	var $operPersona;
	var $emailUser;
	var $idPersona;

	function __construct(){

		parent::__construct();
	
		$params['id_sicas']		= $this->tank_auth->get_IDUserSICAS(); "get_IDUserSICAS";
		$params['user_sicas'] 	= $this->tank_auth->get_UserSICAS(); "get_UserSICAS";
		$params['pass_sicas'] 	= $this->tank_auth->get_PassSICAS(); "get_PassSICAS";
		$this->load->library('Ws_sicasdre',$params);
		$this->load->library('webservice_sicas_soap');
		$this->load->library('localfileuploader');
		$this->load->library("libreriav3");
		$this->load->helper('ckeditor');
		$this->load->model('capsysdre_actividades');
		$this->load->model('fullcalendar_model');
		$this->load->model('personamodelo');
		$this->load->model('PersonaModelo');
		
		$this->operPersona	= new $this->PersonaModelo;
		
		$this->emailUser	= $this->tank_auth->get_usermail();
		$this->idPersona	= $this->tank_auth->get_idPersona();

	}

	function index(){
		
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			
			//** $this->conexionCS();
			
			/*$correoProcedente		= $this->tank_auth->get_usermail();
			$data_search['id']		= $this->capsysdre->IDxEmail($correoProcedente);
			$data_search['role']	= "OPERATIVO";  //pasamos este dato para qeu la consulta traiga los del vendedor*/

			/*BUSCAMOS CLIENTE SIKAS  
			$data_result = $this->webservice_sicas_soap->GetClientp100($data_search);	
			$data['data_result']=$data_result;*/

			/*$nombrep			= $this->input->post('nomsik');
			$busquedaUsuario	= $this->input->get('busquedaUsuario', TRUE);
			
		    if($nombrep!=""){
				$data_result			= $this->capsysdre_actividades->ListaClienteProspecto($nombrep);	
				$data['data_result']	= $data_result;
            }*/ 

			/////////////////////////////////////////////////////////////////////////////////////////////PARA DIMENSIONADOS

			 /*$sqlConsultaDimension = "
				Select
					*
				From
					`clientes_actualiza`
				Where
					`Usuario`='".$correoProcedente."'
					And
					`EstadoActual` = 'DIMENSION'
					And
					`callcenter` = '1'
				Order By
					 `ApellidoP` Asc
									 ";
			$queryConsultaDimension	= $this->db->query($sqlConsultaDimension);*/

			/////////////////////////////////////////////////////////////////////////////////////////PARA PERFILADOS

			/*$sqlConsultaperfilados = "
				Select
					*
				From
					`clientes_actualiza`
				Where
					`Usuario`='".$correoProcedente."'
					And
					`EstadoActual` = 'PERFILADO'
					And
					`callcenter` = '1'
				Order By
					 `ApellidoP` Asc
									 ";
			$queryConsultaperfilados	= $this->db->query($sqlConsultaperfilados);*/

			///////////////////////////////////////////////////////////////////////////////////// PARA CONTACTADOS

			/*$sqlConsultacontactados = "
				Select
					*
				From
					`clientes_actualiza`
				Where
					`Usuario`='".$correoProcedente."'
					And
					`EstadoActual` = 'CONTACTADO'
					And
					`callcenter` = '1'
				Order By
					 `ApellidoP` Asc
									 ";
			$queryConsultacontactados	= $this->db->query($sqlConsultacontactados);*/

			///////////////////////////////////////////////////////////////////////////////////// PARA REGISTRADAS CITAS

			/*$sqlConsultaRegistrados = "
				Select
					*
				From
					`clientes_actualiza`
				Where
					`Usuario`='".$correoProcedente."'
					And
					`EstadoActual` = 'REGISTRADO'
					And
					`callcenter` = '1'
				Order By
					 `ApellidoP` Asc
									 ";
			$queryConsultaRegistrados	= $this->db->query($sqlConsultaRegistrados);*/

			
			///////////////////////////////////////////////////////////////////////////////////// COTIZADOS 

			/*$sqlConsultaCotizados = "
				Select 
					cat.IDCli,cat.ApellidoP,cat.ApellidoM,cat.Nombre,cat.Telefono1,cat.EMail1,cat.EstadoActual,pj.FolioActividad,pj.idSicas
				From
					clientes_actualiza cat Inner Join puntaje pj 
					on 
					cat.IDCli = pj.IDCliente
				Where
					`cat`.`Usuario`='".$correoProcedente."'
					And
					(
						`cat`.`EstadoActual` = 'COTIZADO' 
						And
						`callcenter` = '1'
					)
					And
					(
						`pj`.`EdoActual`='COTIZADO' 
						And 
						`pj`.`PuntosGenerados`>0 
						And
						`callcenter` = '1'
					)
				Order By
					`ApellidoP` Asc
									";// en la consulta los puntos mayores de cero es para elimnar la de vehiculos porque vehiculos no genera puntos
									
			$queryConsultaCotizados	= $this->db->query($sqlConsultaCotizados);*/

			///////////////////////////////////////////////////////////////////////////////////// PAGADOS 

			/*$sqlConsultaPagados = "
			Select cat.IDCli,cat.ApellidoP,cat.ApellidoM,cat.Nombre,cat.Telefono1,cat.EMail1,cat.EstadoActual,pj.FolioActividad,pj.idSicas
From
clientes_actualiza cat
inner join
puntaje pj on cat.IDCli=pj.IDCliente
Where
`cat`.`Usuario`='".$correoProcedente."'
And
(`cat`.`EstadoActual` = 'PAGADO' And
					`callcenter` = '1')
And
(`pj`.`EdoActual`='COTIZADO' And
					`callcenter` = '1') 
Order By
`ApellidoP` Asc
									 "; 
			$queryConsultaPagados	= $this->db->query($sqlConsultaPagados);*/

			///////////////////////////////////////////////////////////////////////////////////// 

			/*$data['queryConsultaDimension']		= $queryConsultaDimension;
			$data['queryConsultacontactados']	= $queryConsultacontactados;
			$data['queryConsultaRegistrados']	= $queryConsultaRegistrados;
			$data['queryConsultaCotizados']		= $queryConsultaCotizados; 
			$data['queryConsultaPagados']		= $queryConsultaPagados; 
			$data['queryConsultaperfilados']	= $queryConsultaperfilados;

			$data['agentesTemporales']			= array_values(array_filter($this->operPersona->obtenerPersonas("SISTEMAS@ASESORESCAPITAL.COM",1), function($arr){ return $arr->colaboradorArea == "Comercial"; })); //$this->emailUser
			$data['personas']					= $this->libreriav3->agrupaPersonasParaSelect($data['agentesTemporales']);
			$data['historialClientes']			= $this->historialesClientes();
			$data['mailings']					= $this->mailings();*/
//			$data['idMailing']					= "0";
	
			/*if(

				$correoProcedente != "MARKETING@AGENTECAPITAL.COM" 
				|| 
				$correoProcedente != "TELEMARKETING@AGENTECAPITAL.COM" 
				|| 
				$correoProcedente != "AUXILIARMKT@AGENTECAPITAL.COM" 
				|| 
				$correoProcedente != "DIRECTORGENERAL@AGENTECAPITAL.COM" 
			  ){
				  
				$usuario	= "MARKETING@AGENTECAPITAL.COM";*/
				//** $correoProcedente != "TELEMARKETING@AGENTECAPITAL.COM" || || $correoProcedente != "DIRECTORGENERAL@AGENTECAPITAL.COM"
				//$data['ListaClientes']				= $this->capsysdre->ListaCLientescallcenter($busquedaUsuario,$correoProcedente);
				
				/*$sqlBusquedaUsuario = "
					Select * From
						`clientes_actualiza`
					Where
						(
							`Nombre` Like '%".$busquedaUsuario."%'
							or
							`ApellidoP` Like '%".$busquedaUsuario."%'
							or
							`ApellidoM` Like '%".$busquedaUsuario."%'
                    		or
							`RazonSocial` Like '%".$busquedaUsuario."%'
						)
						And
			   				`EstadoActual` <>'ELIMINADO'	
						And
			   			-- `callcenter` = '1'   
			   			--	`leads` Is Not NULL
			   				(
								`leads` = 'Cliengo'
								Or
								`leads` = 'http://www.fianzascapital.com.mx'
								Or
								`leads` = 'http://www.capitalsegurosgmm.com'
								Or
								`leads` = 'http://capsys.com.mx/client'
							)
						Order By
							`fechaActualizacion` Desc
							  ";
				$query = $this->db->query($sqlBusquedaUsuario);
				$data['ListaClientes']				= $query;
				
			} else {

				$sqlBusquedaUsuario = "
					Select * From
						`clientes_actualiza`
					Where
							`usuario` = '".$usuario."'
						And 
						(
							`Nombre` Like '%".$busquedaUsuario."%'
							or
							`ApellidoP` Like '%".$busquedaUsuario."%'
							or
							`ApellidoM` Like '%".$busquedaUsuario."%'
                    		or
							`RazonSocial` Like '%".$busquedaUsuario."%'
						)
						And
			   				`EstadoActual` <>'ELIMINADO'
						And
						--	`leads` Is Not NULL
			   				(
								`leads` = 'Cliengo'
								Or
								`leads` = 'http://www.fianzascapital.com.mx'
								Or
								`leads` = 'http://www.capitalsegurosgmm.com'
								Or
								`leads` = 'http://capsys.com.mx/client'
							)
					Order By
						`fechaActualizacion` Desc
							  ";
				$query = $this->db->query($sqlBusquedaUsuario);
				$data['ListaClientes']				= $query;
			}

			 global $mensajeGeneral;
			 
			 if($mensajeGeneral!=""){
				 $data['mensaje']=$mensajeGeneral;			 	
			 }*/
			$data['citas']	= $this->fullcalendar_model->devuelveCitasActivasPorUsuarios();
			$option1 = "";
			$option2 = "";
			$count = date('Y') - 2021;
			$yearI = date('Y');
			$months = $this->libreriav3->devolverMeses();
			foreach ($months as $key => $val) {
				$selected = "";
				if ($key == date('m')) { $selected = "selected"; }			
				$option1 .= '<option value="'.$key.'" '.$selected.'>'.$val.'</option>';
			}
			for ($i=0;$i<=$count;$i++) {
				$selected = "";
				if ($yearI == date('Y')) { $selected = "selected"; }
				$option2 .= '<option value="'.$yearI.'" '.$selected.'>'.$yearI.'</option>';
				$yearI--;
			}
			$data['option1'] = $option1;
			$data['option2'] = $option2;
			$this->load->view('callcenter/principal',$data);
			
		}
	}

	function Estadistica(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {

	        $data['ListaVendedores']= $this->capsysdre->ListaVendedoresP100();

	        $fechaini=$this->input->post('fechaini');
	        $fechafin=$this->input->post('fechafin');
	        $data['fechaini']=$fechaini;
            $data['fechafin']=$fechafin;

            $this->load->view('callcenter/Estadistica',$data);

		}
	} /*! Estadistica */

	function editPros(){

		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			if($this->input->get('IDCLente',TRUE)){
				
				$idInterno	= $this->input->get('IDCLente',TRUE);
				$data['detalleUsuario']		= $this->capsysdre->detalleProspecto($idInterno);
				$data['ListaComentarios']	= $this->capsysdre->ListaComentarios($idInterno);
			
				$this->load->view('callcenter/editProspecto', $data);
			}
		}
	} /*! editPros */

	function consultaxfechas(){
		if (!$this->tank_auth->is_logged_in()){
			redirect('/auth/login/');
		} else {

			$fechaini=$this->input->post('fechaini');
			$fechafin=$this->input->post('fechafin');

			$data['ListaVendedores']= $this->capsysdre->ListaVendedoresP100();
			$data['fechaini']=$fechaini;
			$data['fechafin']=$fechafin;

			$this->load->view('callcenter/Estadistica',$data);

         } 
    } /*! consultaxfechas */

	function actualizaProspecto(){

		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {  

			strtoupper ($this->input->post('cliselecsikas'));

				$IDpros			= $this->input->post('IDCl');

				$ApellidoP			= strtoupper ($this->input->post('ApellidoP'));
	 			$ApellidoM			= strtoupper ($this->input->post('ApellidoM'));
	 			$Nombre				= strtoupper ($this->input->post('Nombre'));
	 			$RazonSocial		= strtoupper ($this->input->post('RazonSocial'));
	 			$RFC				= strtoupper ($this->input->post('RFC'));
	 			$email				= strtoupper ($this->input->post('EMail1'));
				$cel				= $this->input->post('Telefono1');


				$CP				= strtoupper ($this->input->post('CP'));
	 			$edad		= strtoupper ($this->input->post('edad'));
	 			$presupuesto				= strtoupper ($this->input->post('presupuesto'));
	 			$suma				= strtoupper ($this->input->post('suma'));
				$comentarios				= $this->input->post('comentarios');




				$sqlUpdateUser = "
				Update
					`clientes_actualiza`
				Set
				`ApellidoP` = '".$ApellidoP."',
				`ApellidoM` = '".$ApellidoM."',
				`Nombre` = '".$Nombre."',
				`RazonSocial`='".$RazonSocial."',
	            `RFC` = '".$RFC."',
	            `EMail1` = '".$email."',
	            `Telefono1` = '".$cel."',
	            `CP` = '".$CP."',
				`edad`='".$edad."',
	            `presupuesto` = '".$presupuesto."',
	            `suma` = '".$suma."',
	            `comentarios` = '".$comentarios."'



				Where
				`IDCli` = '".$IDpros."'
						 ";

				$this->db->query($sqlUpdateUser);
  

				$data['detalleUsuario'] = $this->capsysdre->detalleProspecto($IDpros);
				$data['alert']		= "success";
				redirect('callcenter/Reportes', $data);

		}
	} /*! actualizaProspecto */

	function Eliminar(){

		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {

           	$IDCli2=$this->input->get('IDCL', TRUE);
           	$fecharegistro=(string)date('Y-m-d H:i:s');
			$correoProcedente=$this->tank_auth->get_usermail();
			$EdoAnt=$this->input->get('EDOANT', TRUE);


          	$sqlInsert_Referencia = "
						Update
							`clientes_actualiza` set
										`EstadoActual` = 'ELIMINADO'
										
									where
									    `IDCli`='".$IDCli2."'
											";

                         
						$this->db->query($sqlInsert_Referencia);
						$referencia = $this->db->insert_id();

			$sqlInsert_grabapuntos = "
						Insert Ignore Into
							`puntaje` 
									(
                                      
										`Usuario`, 
										`IDCliente`,
										`FechaRegistro`,
										`EdoAnterior`,
										`EdoActual`,
										`PuntosGenerados`
									) 
									Values
									(
									    
									    '".$correoProcedente."',
									    '".$IDCli2."',
										'".$fecharegistro."', 
										'".$EdoAnt."',
										'ELIMINADO',
										'0'
									);
											";

											
                         
					$this->db->query($sqlInsert_grabapuntos);
					$referencia = $this->db->insert_id();



             	redirect('callcenter/Reportes');
       	}
    }

    function Reportes(){

		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
            //DETERMINAMOS CORREO PROSCEDENTE
            $correoForm = $this->input->get('vendedorp', TRUE);
            $correoForm="TELEMARKETING@AGENTECAPITAL.COM";
            
            if ($correoForm != "")
            {
               $this->CalculaInfo($correoForm);
            }
            else
            {	
		 		$correoProcedente=$this->tank_auth->get_usermail();
		 		$this->CalculaInfo($correoProcedente);
		    }
       	}//fin del Else basico de la funcion
    }

	function CalculaInfo($EmailUserp100){

		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {

			$correoProcedente=$EmailUserp100;


			$data['ListaClientes']		= $this->capsysdre->ListaCLientescallcenter($this->input->get('busquedaUsuario', TRUE),$correoProcedente);


            $correoPermisoLista=$this->tank_auth->get_usermail();
       	 	$profileuser=$this->capsysdre->ProfilexEmail($correoPermisoLista);
		 	//$correoescogido=$this->input->get('vendedorp', TRUE);


			if($profileuser=='4' || $profileuser=='3')  //SOLO ES master
        	{
        		$data['ListaVendedores']= $this->capsysdre->ListaVendedoresCall();
        		$arreglo=[7];
        		$data['vendedoresAsignar']= $this->personamodelo->obtenerVendedoresPorTipoAgente($arreglo);
        		$data['correoUsuario']="TELEMARKETING@AGENTECAPITAL.COM";//$this->input->get('vendedorp', TRUE);
        	
      		}
      		else
      		{	

               $data['ListaVendedores']=$this->capsysdre->ObtieneUsuarioxEmail($correoProcedente);
               
        	} //fin del else de master


           $this->load->view('callcenter/ReporteClientes',$data);

        }
    }   

	function asignaAgente(){
		
		$data['vendedoresAsignar']	= $this->personamodelo->obtenerVendedoresPorTipoAgente($arreglo);
		$data['correoUsuario']		= $_POST['correoAgente'];
		$arreglo	= [7];
		$email		= $_POST['emailAgenteAsignar'];
        		
        //
		if(ctype_digit($_POST['emailAgenteAsignar'])){
			
			$data['mensajeAlerta']='alert("El agente esta en proceso de Alta")';

		} else {
			if($this->personamodelo->verificaExistenciaCorreos($_POST['emailAgenteAsignar'])){
				$this->capsysdre->reasignaClienteVendedor($_POST['idClie'],$_POST['emailAgenteAsignar']);
			}

		}
        
		$data['ListaClientes']			= $this->capsysdre->ListaCLientescallcenter($this->input->get('busquedaUsuario', TRUE),"TELEMARKETING@AGENTECAPITAL.COM");
        $data['ListaVendedores']		= $this->capsysdre->ListaVendedoresCall();
        $data['emailUsuarioAsignar']	= $_POST['emailAgenteAsignar'];	

		$this->load->view('callcenter/ReporteClientes',$data);
		
	}/*! asignaAgente */
	
	function asignaMailing(){// Modificado [2024-01-29]
		
		$IDCli			= $this->input->get_post('IDCli', TRUE);
		$campaignEmail	= $this->input->get_post('campaignEmail', TRUE);
		
		$sqlInfoMailing	= "
			Select * From
				`mailing`
			Where
				`idMailing` = '".$campaignEmail."'
			;
						  ";
		$mailingInfo	= $this->db->query($sqlInfoMailing)->row();
		
		if(isset($mailingInfo->tipo_prospecto)){
			$tipoProspecto = $mailingInfo->tipo_prospecto;
		} else {
			$tipoProspecto = 3;
		}
		
		$sqlUpdate = "
			Update
				`clientes_actualiza`
			Set
				`idMailing`			= '".$campaignEmail."',
				`tipo_prospecto`	= '".$tipoProspecto."'
			Where
				`IDCli` = '".$IDCli."'
					 ";
		$this->db->query($sqlUpdate);
		
		## clientes_actualiza_historial
		$sqlInsertHistorial = "
			Insert Into
				`clientes_actualiza_historial`
				(
					`IDCli`,
					`informacion`
				
				)
			Values
				(
					'".$IDCli."',
					'Mailing Asignado: ".$mailingInfo->nombre."'
				)
							  ";
		$this->db->query($sqlInsertHistorial);

		//redirect('/callcenter/');
		$data['IDCli'] = $IDCli;
		$data['mail'] = $campaignEmail;
		echo json_encode($data);
		
	}/*! asignaMailing */
	
	function asignaStatus(){// Modificado [2024-01-29]

		
		$IDCli			= $this->input->get_post('IDCli', TRUE);
		$statusCliente	= $this->input->get_post('statusCliente', TRUE);
				
		$sqlUpdate = "
			Update
				`clientes_actualiza`
			Set
				`EstadoActual`	= '".$statusCliente."'
			Where
				`IDCli` = '".$IDCli."'
					 ";
		$this->db->query($sqlUpdate);
		
		## clientes_actualiza_historial
		$sqlInsertHistorial = "
			Insert Into
				`clientes_actualiza_historial`
				(
					`IDCli`,
					`informacion`
				
				)
			Values
				(
					'".$IDCli."',
					'Cambio de Estado: ".$statusCliente."'
				)
							  ";
		$this->db->query($sqlInsertHistorial);

		//redirect('/callcenter/');
		$data['IDCli'] = $IDCli;
		$data['status'] = $statusCliente;
		echo json_encode($data);
	}
	
	function eliminaCliente(){// Modificado [2024-01-30]

		$IDCli			= $this->input->get_post('IDCli', TRUE);
				
		$sqlUpdate = "
			Update
				`clientes_actualiza`
			Set
				`EstadoActual`	= 'ELIMINADO'
			Where
				`IDCli` = '".$IDCli."'
					 ";
		$this->db->query($sqlUpdate);
		
		## clientes_actualiza_historial
		$sqlInsertHistorial = "
			Insert Into
				`clientes_actualiza_historial`
				(
					`IDCli`,
					`informacion`
				
				)
			Values
				(
					'".$IDCli."',
					'Cliente Eliminado'
				)
							  ";
		$this->db->query($sqlInsertHistorial);

		//redirect('/callcenter/');
		$data['IDCli'] = $IDCli;
		$data['query1'] = $sqlUpdate;
		$data['query2'] = $sqlInsertHistorial;
		echo json_encode($data);
	
	}
	
	function asignaUsuario(){// Modificado [2024-01-29]
		
		$IDCli		= $this->input->get_post('IDCli', TRUE);
		$usuarioNew	= $this->input->get_post('emailUsuario', TRUE);
        
	//Modificacion Miguel Jaime 07-05-2021
		$sqlUpdate = "
			Update
				`clientes_actualiza`
			Set
				`Usuario` = '".$usuarioNew."',
                `tipo_prospecto` = '0'
			Where
				`IDCli` = '".$IDCli."'
					 ";
    //fin modificacion
		$this->db->query($sqlUpdate);
		
		## clientes_actualiza_historial
		$sqlInsertHistorial = "
			Insert Into
				`clientes_actualiza_historial`
				(
					`IDCli`,
					`informacion`
				
				)
			Values
				(
					'".$IDCli."',
					'Cliente Asignado: ".$usuarioNew."'
				)
							  ";
		$this->db->query($sqlInsertHistorial);
		
		//redirect('/callcenter/');
		$data['IDCli'] = $IDCli;
		$data['user'] = $usuarioNew;
		echo json_encode($data);
	}
	


	function AgregaComentario(){
		
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {

			$correoProcedente=$this->tank_auth->get_usermail();
			$idCliente=$this->input->post('IDCl2', TRUE);
			$fecharegistro=(string)date('Y-m-d H:i:s');
			$comentario=$this->input->post('comentarios', TRUE);

			$sqlInsert_grabapuntos = "
						Insert Ignore Into
							`comentarioscall` 
									(
                                      
										`IDCliente`, 
										`fechaCaptura`,
										`Usuario`,
										`comentario`
										
									) 
									Values
									(
									    
									    '".$idCliente."',
									    '".$fecharegistro."',
										'".$correoProcedente."', 
										'".$comentario."'
									
									);
											";

											
                         
					$this->db->query($sqlInsert_grabapuntos);
					$referencia = $this->db->insert_id();

           
			$data['detalleUsuario']	= $this->capsysdre->detalleProspecto($idCliente);

			$data['ListaClientes']		= $this->capsysdre->ListaCLientescallcenter($this->input->get('busquedaUsuario', TRUE),$correoProcedente);
            $data['ListaComentarios']	= $this->capsysdre->ListaComentarios($idCliente);
           

           $this->load->view('callcenter/editProspecto',$data);

        }
    }    
 
	function LlamaCotizacion(){
		
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			
			   $Cliente=$this->input->get('IDCL', TRUE);


				 if($Cliente>0)
                 {
                

			   		$sqlConsultaDatos = "
							Select
							*
							From
							`clientes_actualiza`
								Where
								`IDCli`='".$Cliente."'
									 ";

			   		$queryConsultaDatos	= $this->db->query($sqlConsultaDatos); 

			   		 	if(!empty($queryConsultaDatos))
                        { 
                             foreach ($queryConsultaDatos->result() as $Registro) { 

                              $apaterno= str_replace(" ", "", $Registro->ApellidoP);
                              $amaterno=str_replace(" ", "", $Registro->ApellidoM);
                              $nombres=str_replace(" ", "_", $Registro->Nombre);
                              $Telefono1=str_replace(" ", "", $Registro->Telefono1);
                              $email=str_replace(" ", "", $Registro->EMail1);

                              $RazonSocial=str_replace(" ", "", $Registro->RazonSocial);

                              $IDCliSikasn=$Registro->IDCliSikas;
                              $IDContacton=$Registro->IDContacto;

                            }
                             $resultado1 = str_replace("@", "-", $email);


						}

                 }

                
                if( $nombres!='' && $apaterno!='' && $amaterno!='' && $Telefono1!='' && $email!='' )
                {

                 	if($IDCliSikasn>0)//es cliente sikas por la tanto llamo nuevo
                 	{
                        $cadenafina="/actividades/agregar/Cotizacion/VEHICULOS/17/Existente?idCliente=".$IDCliSikasn."-".$IDContacton."&clientep=".$Cliente."";
                 	} 
                 	else
                	{   
                	     if($RazonSocial!="")
                     	 {	

                      		 $cadenafina="/actividades/agregar/Cotizacion/VEHICULOS/17/Nuevo/Moral/".$Cliente."/SAP/SAM/SN/".$Telefono1."/".$resultado1."/".$RazonSocial."/";
                     	 } 
                      	 else
                      	 { 

                         	$cadenafina="/actividades/agregar/Cotizacion/VEHICULOS/17/Nuevo/Fisica/".$Cliente."/".$apaterno."/".$amaterno."/".$nombres."/".$Telefono1."/".$resultado1."/SR/";
                      	 }	  
                 	}	

					redirect($cadenafina);
				}
				else
				{
                  
                    $this->load->view('callcenter/mensajero');
  
                } 	


		}
	}

	function Emision(){
		
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			
			   $Cliente=$this->input->post('cliselecEmi', TRUE);


				 if($Cliente>0)
                 {
                    
			   		$sqlConsultaDatos = "
							Select
							*
							From
							`clientes_actualiza`
								Where
								`IDCli`='".$Cliente."'
									 ";

			   		$queryConsultaDatos	= $this->db->query($sqlConsultaDatos); 

			   		 	if(!empty($queryConsultaDatos))
                        { 
                             foreach ($queryConsultaDatos->result() as $Registro) { 

                              $apaterno= str_replace(" ", "", $Registro->ApellidoP);
                              $amaterno=str_replace(" ", "", $Registro->ApellidoM);
                              $nombres=str_replace(" ", "_", $Registro->Nombre);
                              $Telefono1=str_replace(" ", "", $Registro->Telefono1);
                              $email=str_replace(" ", "", $Registro->EMail1);

                              $RazonSocial=str_replace(" ", "", $Registro->RazonSocial);

                              $IDCliSikasn=$Registro->IDCliSikas;
                              $IDContacton=$Registro->IDContacto;

                            }
                             $resultado1 = str_replace("@", "-", $email);


						}

                 }

           

                 if($IDCliSikasn>0)//es cliente sikas por la tanto llamo nuevo
                 {
                        $cadenafina="/actividades/agregar/Emision/VEHICULOS/17/Existente?idCliente=".$IDCliSikasn."-".$IDContacton."&clientep=".$Cliente."";
                 } 
                 else
                 {   
                      if($RazonSocial!="")
                      {	

                      	 $cadenafina="/actividades/agregar/Emision/VEHICULOS/17/Nuevo/Moral/".$Cliente."/SAP/SAM/SN/".$Telefono1."/".$resultado1."/".$RazonSocial."/";
                      } 
                      else
                      { 

                         $cadenafina="/actividades/agregar/Emision/VEHICULOS/17/Nuevo/Fisica/".$Cliente."/".$apaterno."/".$amaterno."/".$nombres."/".$Telefono1."/".$resultado1."/SR/";
                      }	  
                 }	

			redirect($cadenafina);


		}
	}
	
	function LlamaCapturaEmision(){
		
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			
			   $Cliente=$this->input->post('cliselecCotiEmi', TRUE);


				 if($Cliente>0)
                 {
                    
			   		$sqlConsultaDatos = "
							Select
							*
							From
							`clientes_actualiza`
								Where
								`IDCli`='".$Cliente."'
									 ";

			   		$queryConsultaDatos	= $this->db->query($sqlConsultaDatos); 

			   		 	if(!empty($queryConsultaDatos))
                        { 
                             foreach ($queryConsultaDatos->result() as $Registro) { 

                              $apaterno= str_replace(" ", "", $Registro->ApellidoP);
                              $amaterno=str_replace(" ", "", $Registro->ApellidoM);
                              $nombres=str_replace(" ", "_", $Registro->Nombre);
                              $Telefono1=str_replace(" ", "", $Registro->Telefono1);
                              $email=str_replace(" ", "", $Registro->EMail1);

                              $RazonSocial=str_replace(" ", "", $Registro->RazonSocial);

                              $IDCliSikasn=$Registro->IDCliSikas;
                              $IDContacton=$Registro->IDContacto;

                            }
                             $resultado1 = str_replace("@", "-", $email);


						}

                 }

           

                 if($IDCliSikasn>0)//es cliente sikas por la tanto llamo nuevo
                 {
                        $cadenafina="/actividades/agregar/CapturaEmision/VEHICULOS/17/Existente?idCliente=".$IDCliSikasn."-".$IDContacton."&clientep=".$Cliente."";
                 } 
                 else
                 {   
                      if($RazonSocial!="")
                      {	

                      	 $cadenafina="/actividades/agregar/CapturaEmision/VEHICULOS/17/Nuevo/Moral/".$Cliente."/SAP/SAM/SN/".$Telefono1."/".$resultado1."/".$RazonSocial."/";
                      } 
                      else
                      { 

                         $cadenafina="/actividades/agregar/CapturaEmision/VEHICULOS/17/Nuevo/Fisica/".$Cliente."/".$apaterno."/".$amaterno."/".$nombres."/".$Telefono1."/".$resultado1."/SR/";
                      }	  
                 }	

			redirect($cadenafina);


		}
	}

	function Limpia($cadena){

       $lista= str_replace("Ñ", "N", $cadena);
       $lista1= str_replace("ñ", "n", $lista);
       $lista2= str_replace("á", "a", $lista1);
       $lista3= str_replace("é", "e", $lista2);
       $lista4= str_replace("í", "i", $lista3);
       $lista5= str_replace("ó", "o", $lista4);
       $lista6= str_replace("ú", "u", $lista5);
       $lista7= str_replace("Á", "A", $lista6);
       $lista8= str_replace("É", "E", $lista7);
       $lista9= str_replace("Í", "I", $lista8);
       $lista0= str_replace("Ó", "O", $lista9);
       $listafin= str_replace("Ú", "U", $lista0);
       $listafin2= strtoupper($listafin);

       return $listafin2;
	} /*! */

	function InsertaDimensiondeSikas(){
		
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			
			$fecharegistro=(string)date('Y-m-d H:i:s');
			$correoProcedente=$this->tank_auth->get_usermail();

             //traigo los valores de sikas  

			//$idclienteSikas=strtoupper ($this->input->post('cliselecsikas'));

			//$DatosCli=$this->webservice_sicas_soap->GetClient_forID($idclienteSikas); 



			foreach ($DatosCli['cliente'] as $key) {
				 $ApellidoP = $key->ApellidoP;
                 $ApellidoM = $key->ApellidoM;
                 $Nombre = $key->Nombre;
                 $IdContacto = $key->IDCont;
			}



           // $ApellidoP = strtoupper ($this->input->post('apellidop'));
           // $ApellidoM = strtoupper ($this->input->post('apellidom'));
           // $Nombre = strtoupper ($this->input->post('nombre'));

             $FuenteProspecto = $this->input->post('fuente');
             $IngresoMensual =  $this->input->post('IngMen');
             $RangodeEdad =  $this->input->post('RangoEdad');
             $Ocupacion =  $this->input->post('ocupacion');
             $EdoCivil =  $this->input->post('estadocivil');
             $TiempodeConocerProspec =  $this->input->post('tiempoconocer');
             $FrecuenciaVio =  $this->input->post('frecuenciavio');
             $PosibiAcercamiento =  $this->input->post('posacercamiento');
             $HabilidadRef =  $this->input->post('habilidadref');


            

				/*$sqlInsert_Referencia = "
						Insert Ignore Into
							`clientes_actualiza` 
									(
                                        `actualiza`, 
										`IDCont`, 
										`TipoEnt`,
										`ApellidoP`,
										`ApellidoM`,
										`Nombre`,
										`RazonSocial`,
										`RFC`,
										`EMail1`,
										`fechaActualizacion`,
										`Usuario`,
										`EstadoActual`,

										`FuenteProspecto`,
										`IngresoMensual`,
										`RangodeEdad`,
										`Ocupacion`,
										`EdoCivil`,
										`TiempodeConocerProspec`,
										`FrecuenciaVio`,
										`PosibiAcercamiento`,
										`HabilidadRef`,
										`IDCliSikas`,
										`IDContacto`,
										`callcenter`
									) 
									Values
									(
									    'clienteSikas',
									    '0',
									    '0',
										'".$ApellidoP."', 
										'".$ApellidoM."',
										'".$Nombre."',
										'',
										'',
										'',
                                        '".$fecharegistro."',
										'".$correoProcedente."',
										'DIMENSION',

										'".$FuenteProspecto."',
										'".$IngresoMensual."',
										'".$RangodeEdad."',
										'".$Ocupacion."',
										'".$EdoCivil."',
										'".$TiempodeConocerProspec."',
										'".$FrecuenciaVio."',
										'".$PosibiAcercamiento."',
										'".$HabilidadRef."',
										'".$idclienteSikas."',
										'".$IdContacto."',
										'1'

									);
											";*/

											
                         
				// $this->db->query($sqlInsert_Referencia);
				// $referencia = $this->db->insert_id();

			
				redirect('/callcenter');
		}
	}
	
	function InsertaDimension(){// Modificado [2024-01-23]
		
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			
			$fecharegistro=(string)date('Y-m-d H:i:s');
			$correoProcedente=$this->tank_auth->get_usermail();

			$ApellidoP = $this->Limpia($this->input->post('apellidop'));
            $ApellidoM = $this->Limpia ($this->input->post('apellidom'));
            $Nombre = $this->Limpia ($this->input->post('nombre'));

            $Razon = $this->Limpia ($this->input->post('razon'));
            $rfc = strtoupper ($this->input->post('rfc'));

            $email = strtoupper ($this->input->post('email'));
            $telefono = strtoupper ($this->input->post('celular'));
            $FuenteProspecto = $this->input->post('fuente');
            $entidad = $this->input->post('entidad');
            $ramo = $this->input->post('ramo');
            $mensaje = $this->input->post('mensaje');

				$sqlInsert_Referencia = "
						Insert Ignore Into
							`clientes_actualiza` 
									(
                                        `actualiza`, 
										`IDCont`, 
										`TipoEnt`,
										`ApellidoP`,
										`ApellidoM`,
										`Nombre`,
										`RazonSocial`,
										`RFC`,
										`EMail1`,
										`Telefono1`,
										`fechaActualizacion`,
										`Usuario`,
										`EstadoActual`,

										`FuenteProspecto`,
										`callcenter`,
										`tipoEntidad`,
										`observacion`,
										`leads`
									) 
									Values
									(
									    'clienteWeb',
									    '0',
									    '0',
										'".$ApellidoP."', 
										'".$ApellidoM."',
										'".$Nombre."',
										'".$Razon."',
										'".$rfc."',
										'".$email."',
										'".$telefono."',
                                        '".$fecharegistro."',
										'".$correoProcedente."',
										'DIMENSION',

										'".$FuenteProspecto."',
										'1',
										'".$entidad."',
										'".$mensaje."',
										'".$ramo."'
									);
											";

											
                         
				$this->db->query($sqlInsert_Referencia);
				$data['referencia'] = $this->db->insert_id();
				$data['query'] = $sqlInsert_Referencia;

			
				//redirect('/callcenter');
				echo json_encode($data);
		}
	}

	function InsertaContactado(){

		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {

			$mensaje="";
			
			$fecharegistro=(string)date('Y-m-d H:i:s');
			$correoProcedente=$this->tank_auth->get_usermail();

           $IDCli2 = $this->input->get('IDCL', TRUE);

         /*   $CP = $this->input->post('cp');
            $edad = $this->input->post('edad');
            $presupuesto = $this->input->post('presupuestod');
            $suma = $this->input->post('sumaseg');
            $fechacontacto = $this->input->post('fechaStart');
             $texto = $this->input->post('Text');*/


            if($IDCli2>0)
            {	

            	try{

					$sqlInsert_Referencia = "
						Update
							`clientes_actualiza` set
									
										`EstadoActual` = 'CONTACTADO'
									where
									    `IDCli`='".$IDCli2."'
											";

                         
					$this->db->query($sqlInsert_Referencia);
					$referencia = $this->db->insert_id();

					$sqlInsert_grabapuntos = "
						Insert Ignore Into
							`puntaje` 
									(
                                      
										`Usuario`, 
										`IDCliente`,
										`FechaRegistro`,
										`EdoAnterior`,
										`EdoActual`,
										`PuntosGenerados`,
										`FechaContacto`

									) 
									Values
									(
									    
									    '".$correoProcedente."',
									    '".$IDCli2."',
										'".$fecharegistro."', 
										'DIMENSION',
										'CONTACTADO',
										'0',
										'".$fechacontacto."'
									);
											";

											
                         
					$this->db->query($sqlInsert_grabapuntos);
					$referencia = $this->db->insert_id();
				 }
                 catch (Exception $e){    
             	         echo $e->getMessage();
             	         redirect('/callcenter');
        	     }	
            
				redirect('/callcenter');

			}

		}
	}

	function devuelveFecha($fecha){
		$fec= explode("/",$fecha);
		list($anio,$mes,$dia)=$fec;     
		$fechaCon1=$anio."-".$mes."-".$dia;
		$fechaNac= date("y-m-d", strtotime($fechaCon1));

		return($fechaNac);
	}

	function VerificarPago(){
		
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {

			$IdSikas = $this->input->get('IDSIK', TRUE);
			$IDCli3 = $this->input->get('IDCL', TRUE);
			$fecharegistro=(string)date('Y-m-d H:i:s');
			$correoProcedente=$this->tank_auth->get_usermail();

			$D_Cred=new stdClass();
        	$datoCredenciales['username']="nombre";
         	$datoCredenciales['Password']="passwor";
         	$datoCredenciales['CodeAuth']="codigo";
          
      
            $datos['TipoEntidad']='0';
       		$datos['TypeDestinoCDigital']='CONTACT';
        	$datos['IDValuePK']='0';
        	$datos['ActionCDigital']='GETFiles';
        	$datos['TypeFormat']='XML';
        	$datos['TProct']='Read_Data';
        	$datos['KeyProcess']='REPORT';
        	$datos['KeyCode']='H03430_003';
        	$datos['Page']='1';
        	$datos['ItemForPage']='10';
        	$datos['InfoSort']='VDatDocumentos.IDDocto';
        	$datos['IDRelation']='0';
        	$datos['ConditionsAdd']='IDDocto;0;0;'.$IdSikas.';'.$IdSikas.';DatDocumentos.IDDocto';


             $xml=$this->webservice_sicas_soap->datos($datos); 


             $tapoliza="";
             foreach($xml->TableInfo as $table)
             {
                  $tapoliza=$table->Status_TXT;
             }


             if($tapoliza=='Liquidado'){

             	//genera los puntos y cmabia el status

             	$sqlInsert_Referencia = "
						Update
							`clientes_actualiza` set
										`EstadoActual` = 'PAGADO'
									where
									    `IDCli`='".$IDCli3."'
											";

                         
			$this->db->query($sqlInsert_Referencia);
			$referencia = $this->db->insert_id();

			$sqlInsert_grabapuntos = "
						Insert Ignore Into
							`puntaje` 
									(
                                      
										`Usuario`, 
										`IDCliente`,
										`FechaRegistro`,
										`EdoAnterior`,
										`EdoActual`,
										`PuntosGenerados`
										
									) 
									Values
									(
									    
									    '".$correoProcedente."',
									    '".$IDCli3."',
										'".$fecharegistro."', 
										'COTIZADO',
										'PAGADO',
										'5'
										
									);
											";

											
                         
								$this->db->query($sqlInsert_grabapuntos);
								$referencia = $this->db->insert_id();


			
               
             }
             

            redirect('/callcenter/');

		}
	}

	function ExportaClientes(){

	//$mysqli = new mysqli('localhost','root','','capsysv3');

	$mysqli = new mysqli('www.capsys.com.mx','root','viki52','capsysV3');
    $correoProcedente=$this->tank_auth->get_usermail();
	$fecha = date("d-m-Y");

   	$consulta= "select * from clientes_actualiza ca where usuario='".$correoProcedente."' And
					`callcenter` = '1' order by ca.ApellidoP

   	";

   	$resultado= $mysqli->query($consulta);

  

	//Inicio de la instancia para la exportación en Excel
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename=Listado_$fecha.xls");
	header("Pragma: no-cache");
	header("Expires: 0");

	echo "<table border=1> ";
	echo "<tr> ";
	echo    "<th>Id_Cliente</th> ";
	echo 	"<th>TipoCliente</th> ";
	echo    "<th>ApellidoP</th> ";
	echo    "<th>ApellidoM</th> ";
	echo 	"<th>Nombres</th> ";
	echo 	"<th>Razon_Social</th> ";
	echo 	"<th>RFC</th> ";
	echo 	"<th>Email</th> ";
	echo 	"<th>Telefono</th> ";
	echo 	"<th>EstadoActual</th> ";

	echo 	"<th>FuenteProspecto</th> ";
	echo 	"<th>CP</th> ";
	echo 	"<th>edad</th> ";
	echo 	"<th>presupuesto</th> ";
	echo 	"<th>suma</th> ";
	echo 	"<th>comentarios</th> ";


	echo "</tr> ";

	while($row = mysqli_fetch_array($resultado)){	

	$IDCli = $row['IDCli'];
	$actualiza = $row['actualiza'];
	$ApellidoP = $row['ApellidoP'];
	$ApellidoM = $row['ApellidoM'];
	$Nombre = $row['Nombre'];
	$RazonSocial = $row['RazonSocial'];
    $RFC = $row['RFC'];
	$EMail1 = $row['EMail1'];
	$Telefono1 = $row['Telefono1'];
	$EstadoActual = $row['EstadoActual'];

    $FuenteProspecto = $row['FuenteProspecto'];
	$CP = $row['CP'];
	$edad = $row['edad'];
    $presupuesto = $row['presupuesto'];
	$suma = $row['suma'];
	$comentarios = $row['comentarios'];



	echo    "<tr> ";
	echo 	"<td HEIGHT=20>".$IDCli."</td> "; 
	echo 	"<td HEIGHT=20>".$actualiza."</td> ";
	echo 	"<td HEIGHT=20>".$ApellidoP."</td> "; 
	echo 	"<td HEIGHT=20>".$ApellidoM."</td> "; 
	echo 	"<td HEIGHT=20>".$Nombre."</td> "; 
	echo 	"<td HEIGHT=20>".$RazonSocial."</td> "; 
	echo 	"<td HEIGHT=20>".$RFC."</td> "; 
	echo 	"<td HEIGHT=20>".$EMail1."</td> "; 
	echo 	"<td HEIGHT=20>".$Telefono1."</td> "; 
	echo 	"<td HEIGHT=20>".$EstadoActual."</td> "; 

	echo 	"<td HEIGHT=20>".$FuenteProspecto."</td> "; 
	echo 	"<td HEIGHT=20>".$CP."</td> "; 
	echo 	"<td HEIGHT=20>".$edad."</td> "; 
	echo 	"<td HEIGHT=20>".$presupuesto."</td> "; 
	echo 	"<td HEIGHT=20>".$suma."</td> "; 
	echo 	"<td HEIGHT=20>".$comentarios."</td> "; 

	

	echo    "</tr> ";

	}
	echo "</table> ";

 	}

	function mailings(){
		$sqlMailing	= "
				Select
					*
				From	
					`mailing`
				Where
					`padre` Is Null
				;	
						  ";
		$queryMailing	= $this->db->query($sqlMailing);
	
		return
			$queryMailing->result();
	}
	
	function historialesClientes(){// Modificado [2024-02-01]
		$sqlHistorial	= "
				Select
					`IDCli`, `fecha`, `informacion`
				From	
					`clientes_actualiza_historial` Order By `fecha` Desc
				;	
						  ";
		$queryHistorial	= $this->db->query($sqlHistorial);
	
		return
			$queryHistorial->result();
	}
	
	function viewCalendar(){
	}

/*-----------------------------------TRANSFIERE DEL SURVEYSLAM A CAPSYS PARA PROYECTO 100 DE TELEMARKETING-------------------------------------------------------------------*/
	function  conexionCS(){
		$idMaxSVS	= $this->db->query("select (max(id_SVS)) as maximo from clientes_actualiza where id_bd_referencia=0");
	//**	print($idMaxSVS->row()->maximo);
	//**	$bdCapital	= $this->load->database('capita13_wp1', true);//INSTACEAMOS BD /*capitalSeguros*/
//		$bdCapital	= $this->load->database('zapier', true);//INSTACEAMOS BD /*capitalSeguros*/
  		
		//$fp = fopen('resultadoJason.txt', 'a+');fwrite($fp, print_r($idMaxSVS->result(),TRUE));fclose($fp);

		//**if($idMaxSVS->result()[0]->maximo	== ''){

		if($idMaxSVS->row()->maximo	== ''){
			$row	= $this->db->query('select id,name,email, details from wp_svs_submits where id>0 and email!=""');
		} else {
			$row	= $this->db->query("select id,name,email, details from wp_svs_submits where id>".$idMaxSVS->row()->maximo.' and email!=""');
		}

		
		foreach($row->result() as  $value){
			$bandInsertar	= 0;
			$arreglo	= explode("Q: ",$value->details);
			for($i=0;$i<count($arreglo);$i++){
				if(strstr($arreglo[$i],'"Nombre, Email y Teléfono"',false)){
					$pl		= $arreglo[$i];
					$cadena	= str_replace('"Nombre, Email y Teléfono"','',$pl);
					$tel	= strstr($cadena,"*",true);
					$nombre	= $value->name;
					$id		= $value->id;
            		$email	= $value->email;

					$insert	= '
								Insert Into
									`clientes_actualiza`  
										(
											`actualiza`, 
											`tipo_prospecto` ,
											`IDCont`, 
											`TipoEnt`, 
											`Nombre`, 
											`ApellidoM`, 
											`ApellidoP`,
											`EMail1`,
											`Telefono1`,
											`Usuario`,
											`RazonSocial`,
											`RFC`,
											`callcenter`,
											`EstadoActual`,
											`id_SVS`,
											`tipoSeguroSVS`,
											`id_bd_referencia`
										)
							  ';
					$insert	= $insert.'
									Values
										(
											"clienteWEB",
											"3",
											0, 
											0,
											"",
											"",
											"'.$nombre.'",
									  ';
					$insert	= $insert.'
											"'.$email.'",
									  ';
					$insert	= $insert.'
											"'.$tel.'",
											"TELEMARKETING@AGENTECAPITAL.COM",
											"",
											"",
											1,
											"DIMENSION",
									  '.$id;
										
					$bandInsertar	= $bandInsertar+3;
					$i	= count($arreglo);

					//$this->db->query($insert);

				} else {
					if($bandInsertar==0){
						if(strstr($arreglo[$i],'"Seguro"',false)){
							$seguro	= $arreglo[$i];
							$tipoSeguro	= str_replace('"Seguro"','',$seguro);
							$tipoSeguroElimnado	= str_replace("*","",$tipoSeguro);
							$bandInsertar++;
						}
					}
				}
			}
			if($bandInsertar>3){
				$insert=$insert.',"'.trim($tipoSeguroElimnado).'",0)';
				$this->db->query($insert);
			} else {
				if($bandInsertar==3){
					$insert=$insert.',"",0)';
					$this->db->query($insert);
				}
			}
			
//**			echo "<pre>";
//**			print_r($insert);
		}

	}

/*------------------------------------------------------------------------------------------------------*/

/*-----------------------------------------GUARDA ARCHIVO QUE SU SUBE-----------------------------------------*/

	function guardarArchivo(){
		//$nameArchivo=;
	

$nombreKey=key($_FILES);
$id=str_replace("Archivo","",$nombreKey);
/*DIRECCION PARA HACER CUANDO SE EJECUTE LOCALMENTE*/
//$directorio=$_SERVER["DOCUMENT_ROOT"]."/Capsys/www/V3/ArchivosCallCenter/".$id."";//

$directorio=$_SERVER["DOCUMENT_ROOT"]."/V3/ArchivosCallCenter/".$id."";

//base_url().'ArchivosPresupuesto/'.$_POST['id']."/"; 
/*DIRECTORIO CUANDO SE SUBE AL SERVIDOR  */
//$directorio=$_SERVER["DOCUMENT_ROOT"]."/V3/ArchivosCallCenter/".$id."";
if(!file_exists($directorio))
{@mkdir($directorio, 0700);}

     $extension=explode(".",$_FILES[$nombreKey]['name'] );
     $largo=count($extension);
if($extension[$largo-1]=='pdf' || $extension[$largo-1]=='PDF' || $extension[$largo-1]=='xml' || $extension[$largo-1]=='XML' || $extension[$largo-1]=='jpg'  || $extension[$largo-1]=='JPG|' || $extension[$largo-1]=='bmp' || $extension[$largo-1]=='BMP' || $extension[$largo-1]=='JPEG' || $extension[$largo-1]=='jpeg' || $extension[$largo-1]=='png' || $extension[$largo-1]=='PNG'){
        $mi_archivo = $nombreKey;
        $config['upload_path'] = $directorio;
        $config['file_name'] =$this->eliminaCaracteres($_FILES[$nombreKey]['name']);
        $config['allowed_types'] = "*";
        $config['max_size'] = "5000";
        $config['max_width'] = "2000";
        $config['overwrite'] = "TRUE";
        $config['max_height'] = "2000";  
        $this->load->library('upload', $config);        
        if($this->upload->do_upload($mi_archivo))
        	{$mensaje="El archivo se guardo correctamente";}
else{
$mensaje=$this->upload->display_errors();
	}
}
else{
	$mensaje="El formato no es valido";
}
global $mensajeGeneral;
$mensajeGeneral=$mensaje;
$this->index();

	}

/*------------------------------------------------------------------------------------------------------*/

	function devuelveDocumentos(){
$idProspecto=$_GET['idProspecto'];
$directorio = './ArchivosCallCenter/'.$idProspecto;
if(file_exists($directorio))
{
 $ficheros  = scandir($directorio);
  $cantArchivos=count($ficheros);
  $dato="";
  for($i=2;$i<$cantArchivos;$i++)
  {
	$dato=$dato.'<a href="'.base_url().'ArchivosCallCenter/'.$idProspecto.'/'.$ficheros[$i].'" style="font-size:18px;color:green;margin:50px;">*'.$ficheros[$i].'</a><br>';
  }

}
else
{$dato='<p style="color:red">No existe archivos para este prospecto</p>';}
echo json_encode($dato);
	}

/*------------------------------------------------------------------------------------------------------*/
	function eliminaCaracteres($s){
		
		//$s = str_replace(" ","",$s);
		$s = str_replace("á","a",$s);
		$s = str_replace("é","e",$s);
		$s = str_replace("í","i",$s);
		$s = str_replace("ó","o",$s);
		$s = str_replace("ú","u",$s);
		$s = str_replace("Á","A",$s);
		$s = str_replace("É","E",$s);
		$s = str_replace("Í","I",$s);
		$s = str_replace("Ó","O",$s);
		$s = str_replace("Ú","U",$s);
		$s = str_replace("ñ","n",$s);
		$s = str_replace("Ñ","N",$s);
		//$s = str_replace("","",$s);
		return $s;
		
	}

/*------------------------------------------------------------------------------------------------------*/

	function guardaCita(){ // Modificado [2024-01-29]
		$_POST['idClienteCita']	= 1;
		
		$insert['titulo']		= $_POST['tituloCita'];
		$insert['fechaInicial']	= date('Y-m-d H:i:s', strtotime($_POST['fecCita'].' '.$_POST['fecIniCita'].':00'));
		$insert['fechaFinal']	= date('Y-m-d H:i:s', strtotime($_POST['fecCita'].' '.$_POST['fecFinCita'].':00'));
		$insert['tabla']		= 'clientes_actualiza';
		$insert['idTabla']		= null;
		
		$this->fullcalendar_model->guardaCitaModulo($insert);

		//$this->fullcalendar_model->guardaCitaModulo($_POST['tituloCita'],$fechaFormato,$_POST['fecIniCita'],$_POST['fecFinCita'],"clientes_actualiza",$_POST['idClienteCita']);
		//$this->citaRegistrada=1;
		//$this->index();
		$data['fecha'] = $_POST['fecCita'];
		$data['horaI'] = $_POST['fecIniCita'];
		$data['horaF'] = $_POST['fecFinCita'];
		$data['insert'] = $insert;
		echo json_encode($data);
	}
	
/*------------------------------------------------------------------------------------------------------*/
	function getInfoClient() { //Modificado [Suemy][2024-04-03]
		$month = $this->input->get('mn');
		$year = $this->input->get('yr');
		$date = $this->input->get('dt');
		$channel = $this->input->get('ch');
		if (!empty($month) && !empty($year)) {
			$sql = "And Month(fechaActualizacion) = '".$month."' And Year(fechaActualizacion) = '".$year."'";
			$query = "where Month(fecha) = '".$month."' and Year(fecha) = '".$year."'";
		}
		else {
			if (!empty($month)) {
				$sql = "And Month(fechaActualizacion) = '".$month."'";
				$query = "where Month(fecha) = '".$month."'";
			}
			if (!empty($year)) {
				$sql = "And Year(fechaActualizacion) = '".$year."'";
				$query = "where Year(fecha) = '".$year."'";
			}
		}
		if (!empty($date)) {
			$format = date('Y-m-d', strtotime($date));
        	$sql = "And Date(fechaActualizacion) = '".$format."'"; //fechaCreacionCA
        	$query = "where Date(fecha) = '".$format."'";
		}
		if (!empty($channel)) {
			$sql .= " And leads = '".$channel."'";
		}
        else {
        	$sql .= " And 
			-- `callcenter` = '1' 
			-- `leads` Is Not NULL 
			(`leads` = 'Cliengo' Or `leads` = 'http://www.fianzascapital.com.mx' Or `leads` = 'http://www.capitalsegurosgmm.com' Or `leads` = 'http://capsys.com.mx/client' Or `leads` = 'https://flotillascapital.com')";
        }
        // And Month(fechaCreacionCA) = '".$mes."' And Year(fechaCreacionCA) = '".$anio."'
		$correo	= $this->tank_auth->get_usermail();
		$data_search['id']		= $this->capsysdre->IDxEmail($correo);
		$data_search['role']	= "OPERATIVO";

		/*BUSCAMOS CLIENTE SICAS  
		$data_result = $this->webservice_sicas_soap->GetClientp100($data_search);	
		$data['data_result']=$data_result;*/
		//$nombrep			= $this->input->post('nomsik');
		//$busquedaUsuario	= $this->input->get('busquedaUsuario', TRUE);
		/*if($nombrep!=""){
			$data_result			= $this->capsysdre_actividades->ListaClienteProspecto($nombrep);	
			$data['data_result']	= $data_result;
        } */

        /////////////////////////////////////////////////////////////////////////////////////

		//PARA DIMENSIONADOS
		/*$sqlConsultaDimension = "Select * From `clientes_actualiza` Where `Usuario`='".$correo."' And `EstadoActual` = 'DIMENSION' And `callcenter` = '1' Order By `ApellidoP` Asc";
		$data['queryConsultaDimension']	= $this->db->query($sqlConsultaDimension)->result();

		//PARA PERFILADOS
		$sqlConsultaperfilados = "Select * From `clientes_actualiza` Where `Usuario`='".$correo."' And `EstadoActual` = 'PERFILADO' And `callcenter` = '1' Order By `ApellidoP` Asc";
		$data['queryConsultaperfilados']	= $this->db->query($sqlConsultaperfilados)->result();

		//PARA CONTACTADOS
		$sqlConsultacontactados = "Select * From `clientes_actualiza` Where `Usuario`='".$correo."' And `EstadoActual` = 'CONTACTADO' And `callcenter` = '1' Order By `ApellidoP` Asc";
		$data['queryConsultacontactados']	= $this->db->query($sqlConsultacontactados)->result();

		//PARA REGISTRADAS CITAS
		$sqlConsultaRegistrados = "Select * From `clientes_actualiza` Where `Usuario`='".$correo."' And `EstadoActual` = 'REGISTRADO' And `callcenter` = '1' Order By `ApellidoP` Asc";
		$data['queryConsultaRegistrados']	= $this->db->query($sqlConsultaRegistrados)->result();

		//COTIZADOS 
		//En la consulta los puntos mayores de cero es para elimnar la de vehiculos porque vehiculos no genera puntos
		$sqlConsultaCotizados = "Select cat.IDCli,cat.ApellidoP,cat.ApellidoM,cat.Nombre,cat.Telefono1,cat.EMail1,cat.EstadoActual,pj.FolioActividad,pj.idSicas From clientes_actualiza cat Inner Join puntaje pj on cat.IDCli = pj.IDCliente Where `cat`.`Usuario`='".$correo."' And (`cat`.`EstadoActual` = 'COTIZADO' And `callcenter` = '1') And (`pj`.`EdoActual`='COTIZADO' And `pj`.`PuntosGenerados`>0 And `callcenter` = '1') Order By `ApellidoP` Asc";
		$data['queryConsultaCotizados']	= $this->db->query($sqlConsultaCotizados)->result();

		//PAGADOS 
		$sqlConsultaPagados = "Select cat.IDCli,cat.ApellidoP,cat.ApellidoM,cat.Nombre,cat.Telefono1,cat.EMail1,cat.EstadoActual,pj.FolioActividad,pj.idSicas From clientes_actualiza cat Inner Join puntaje pj on cat.IDCli=pj.IDCliente Where `cat`.`Usuario`='".$correo."' And (`cat`.`EstadoActual` = 'PAGADO' And `callcenter` = '1') And (`pj`.`EdoActual`='COTIZADO' And `callcenter` = '1') Order By `ApellidoP` Asc"; 
		$data['queryConsultaPagados']	= $this->db->query($sqlConsultaPagados)->result();*/

		///////////////////////////////////////////////////////////////////////////////////////
		//Agentes
		$agentesTemporales = array_values(array_filter(
			$this->operPersona->obtenerPersonas("SISTEMAS@ASESORESCAPITAL.COM",1), 
			function($arr){ return $arr->colaboradorArea == "Comercial"; }
		));
		//Asignacion
		$data['personas'] = array();
		$personas = $this->libreriav3->agrupaPersonasParaSelect($agentesTemporales);
		foreach ($personas['Comercial'] as $value) {
			array_push($data['personas'], $value);
		}
		//Historial (busca todos)
		$data['historialClientes'] = $this->historialesClientes();
		//Mailing (busca todos)
		$data['mailings'] = $this->mailings();
		//Búsqueda de clientes
		if($correo != "MARKETING@AGENTECAPITAL.COM" || $correo != "TELEMARKETING@AGENTECAPITAL.COM" || $correo != "AUXILIARMKT@AGENTECAPITAL.COM" || $correo != "DIRECTORGENERAL@AGENTECAPITAL.COM"){
			$usuario = "MARKETING@AGENTECAPITAL.COM";	
			$sqlBusquedaUsuario = "Select * From `clientes_actualiza` Where `EstadoActual` <> 'ELIMINADO' ".$sql." Order By`fechaCreacionCA` Desc";
		} else {
			$sqlBusquedaUsuario = "Select * From `clientes_actualiza` Where `usuario` = '".$usuario."' And `EstadoActual` <>'ELIMINADO' ".$sql." Order By `fechaCreacionCA` Desc";
		}
		$query = $this->db->query($sqlBusquedaUsuario)->result();
		$data['ListaClientes'] = $query;
		$data['query'] = $sqlBusquedaUsuario;
		$data['puntaje'] = array();
		//Puntaje
		foreach ($query as $val) {
			$con = $this->db->query('select count(IDCliente) as numero from puntaje pj where pj.EdoActual = "CONTACTADO" and pj.IDCliente = '.$val->IDCli)->row()->numero;
			$cot = $this->db->query('select count(IDCliente) as numero from puntaje pj where pj.EdoActual = "COTIZADO" and pj.IDCliente = '.$val->IDCli)->row()->numero;
			$pag = $this->db->query('select count(IDCliente) as numero from puntaje pj where pj.EdoActual = "PAGADO" and pj.IDCliente = '.$val->IDCli)->row()->numero;
			$add['IDCli'] = $val->IDCli;
			$add['contactado'] = $con;
			$add['cotizado'] = $cot;
			$add['pagado'] = $pag;
			array_push($data['puntaje'], $add);
		}
		echo json_encode($data);
	}

	function saveNote() {
		$data['data'] = array(
			"IDCli" => $this->input->post('id'),
			"informacion" => $this->input->post('tx')
		);
		$data['result'] = $this->db->insert('clientes_actualiza_historial',$data['data']);
		echo json_encode($data);
	}

	function getHistoryClient() {
		$IDCli = $this->input->get('id');
		$query = $this->db->query("select * from clientes_actualiza_historial where IDCli = ".$IDCli." order by fecha desc")->result();
		echo json_encode($query);
	}
}
