<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class configuraciones extends CI_Controller{

	function __construct(){
		parent::__construct();		
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('security');
		$this->load->library('tank_auth');
		$this->lang->load('tank_auth');
	}

	function ExportaAgentes(){	

	$mysqli = new mysqli('localhost','root','','capsysv3');

	//$mysqli = new mysqli('www.capsys.com.mx','root','viki52','capsysV3');

	$fecha = date("d-m-Y");

   	$consulta= "select `cs`.`NombreSucursal`,`cc`.`nombre`,`us`.`name_complete`,`ui`.`Giro`,`ui`.`Ranking`,`us`.`CelularSMS`,`us`.`email` From users us
	left join user_miInfo ui on `us`.`email`=`ui`.`emailUser`
	left join catalog_sucursales `cs` on `us`.`IdSucursal`=`cs`.`IdSucursal`
	left join catalog_canales `cc` on `us`.`IdCanal`=`cc`.`IdCanal`
	Where (idTipoUser=6)
	And
	(banned='0')
	And
	(
   	 `profile` = '1' Or `profile` = '2'
	)
	Order By  `name_complete` Asc

   	";

   	$resultado= $mysqli->query($consulta);

  

	//Inicio de la instancia para la exportación en Excel
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename=Listado_$fecha.xls");
	header("Pragma: no-cache");
	header("Expires: 0");

	echo "<table border=1> ";
	echo "<tr> ";
	echo    "<th>Nombre Sucursal</th> ";
	echo 	"<th>Canal</th> ";
	echo 	"<th>Nombre</th> ";
	echo 	"<th>Clasificacion</th> ";
	echo 	"<th>Ranking</th> ";
	echo 	"<th>Celular</th> ";
	echo 	"<th>Email</th> ";


	echo "</tr> ";

	while($row = mysqli_fetch_array($resultado)){	

	$NombreSucursal = $row['NombreSucursal'];
	$nombre = $row['nombre'];
	$name_complete = $row['name_complete'];
	$Giro = $row['Giro'];
	$Ranking = $row['Ranking'];
    $CelularSMS = $row['CelularSMS'];
	$email = $row['email'];
	

	echo    "<tr> ";
	echo 	"<td HEIGHT=20>".$NombreSucursal."</td> "; 
	echo 	"<td HEIGHT=20>".$nombre."</td> "; 
	echo 	"<td HEIGHT=20>".$name_complete."</td> "; 
	echo 	"<td HEIGHT=20>".$Giro."</td> "; 
	echo 	"<td HEIGHT=20>".$Ranking."</td> "; 
	echo 	"<td HEIGHT=20>".$CelularSMS."</td> "; 
	echo 	"<td HEIGHT=20>".$email."</td> "; 

	echo    "</tr> ";

	}
	echo "</table> ";

 	}

	function index(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data["configModulos"] = $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail());
				$this->load->view('configuraciones/principal',$data);
		}
	} /*! index */

	function editUser(){		
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			if($this->input->get('idInterno',TRUE)){
				$idInterno = $this->input->get('idInterno',TRUE);
				$data['detalleUsuario'] = $this->capsysdre->detalleUsuario($idInterno);
				$data['alert']			= "";
				$this->load->view('configuraciones/editUser', $data);
			} else {
				$idInterno = '0';
				redirect('configuraciones/listUser');
			}
		}
	} /*! editUser */
	
	function listUser(){		
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['ListaUsuarios']		= $this->capsysdre->ListaUsuarios($this->input->get('busquedaUsuario', TRUE));
			$this->load->view('configuraciones/listUser', $data);
		}
	} /*! listUser */

	function editVend(){		
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			if($this->input->get('idInterno',TRUE)){
				$idInterno = $this->input->get('idInterno',TRUE);
				$data['detalleUsuario']	= $this->capsysdre->detalleUsuario($idInterno);
				$data['alert']			= "";
				$this->load->view('configuraciones/editVend', $data);
			} else {
				$idInterno = '0';
				redirect('configuraciones/listVend');
			}
		}
	} /*! editVend */
	
	function listVend(){		
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['ListaVendedores']		= $this->capsysdre->ListaVendedores($this->input->get('busquedaUsuario', TRUE));
			$this->load->view('configuraciones/listVend', $data);
		}
	} /*! listVENDEDORES CON PERMISO DE EDICION */

	function listVend2(){		
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['ListaVendedores']		= $this->capsysdre->ListaVendedoresSinFiltro($this->input->get('busquedaUsuario', TRUE));
			$this->load->view('configuraciones/listVend2', $data);
		}
	} /*! listVENDEDORES NADA MAS*/
	
	function addUser(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$use_username = $this->config->item('use_username', 'tank_auth');
			if ($use_username) {
				$this->form_validation->set_rules('username','Nombre de usuario','trim|required|xss_clean|min_length['.$this->config->item('username_min_length','tank_auth').']|max_length['.$this->config->item('username_max_length','tank_auth').']|alpha_dash');
			}
			$this->form_validation->set_rules('email', 'Correo electr&oacute;nico', 'trim|required|xss_clean|valid_email');
			//$this->form_validation->set_rules('idVendedor', 'IdVendedor', 'trim|required|xss_clean|alpha_dash');
			//$this->form_validation->set_rules('IDGrupo', 'IDGrupo', 'trim|required|xss_clean|alpha_dash');
			//$this->form_validation->set_rules('IDSGrupo', 'IDSGrupo', 'trim|required|xss_clean|alpha_dash');
			$this->form_validation->set_rules('profile', 'Perfil', 'trim|required|xss_clean|alpha_dash');
			
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']|alpha_dash');
			$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|xss_clean|matches[password]');

			$data['errors'] = array();

			$email_activation = $this->config->item('email_activation', 'tank_auth');

			if($this->input->post('tipoUser')=='1')
			{
                    $tipoUsertxt='Gestion';
            }


			
			if ($this->form_validation->run()) {								// validation ok
				if (!is_null($data = $this->tank_auth->create_user(
						$use_username ? $this->form_validation->set_value('username') : '',
						$this->form_validation->set_value('email'),
						$this->form_validation->set_value('password'),
						$email_activation,
						$this->input->post('tipoUser'),
						$tipoUsertxt,
						$this->form_validation->set_value('idVendedor'),
						$this->form_validation->set_value('IDGrupo'),
						$this->form_validation->set_value('profile'),
					
						$this->input->post('sucursal'),
						$this->input->post('canal')
						))) {									// success



					$data['site_name'] = $this->config->item('website_name', 'tank_auth');

					if ($email_activation) {												// send "activate" email
						$data['activation_period'] = $this->config->item('email_activation_expire', 'tank_auth') / 3600;
						$this->_send_email('activate', $data['email'], $data);
						unset($data['password']); // Clear password (just for any case)
						$this->_show_message($this->lang->line('auth_message_registration_completed_1'));

					} else {
						
						if ($this->config->item('email_account_details', 'tank_auth')) {	// send "welcome" email
							$this->_send_email('welcome', $data['email'], $data);
						}
						unset($data['password']); // Clear password (just for any case)
						$this->_show_message($this->lang->line('auth_message_registration_completed_2').' '.anchor('/auth/login/', 'Login'));
					}
				} else {
					$errors = $this->tank_auth->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				}
			}
			
			$data['use_username'] = $use_username;		
			$data['alert']		= "success";	
			$this->load->view('configuraciones/addUser', $data);
		}
	}

	function actualizarcontrasenia(){
		$idUser			= $this->input->post('idUser');
	 	$contrasenia	= $this->input->post('contrasenia');
	 	$name_complete	= $this->input->post('name_complete');
	 	$email			= $this->input->post('email');
	 	$profile		= $this->input->post('profile');
	 	$idTipoUser		= $this->input->post('idTipoUser');
		$banned			= $this->input->post('banned');
		$CelularSMS		= $this->input->post('CelularSMS');
		$Sucursal		= $this->input->post('Sucursal');
		$Canal		    = $this->input->post('Canal');
/* */
		$Giro					= $this->input->post('Giro');
		$Ranking				= $this->input->post('Ranking');
		$certificacionAutos		= $this->input->post('certificacionAutos');
		$certificacionGmm		= $this->input->post('certificacionGmm');
		$certificacionVida		= $this->input->post('certificacionVida');
		$certificacionDanos		= $this->input->post('certificacionDanos');
		$certificacionFianzas	= $this->input->post('certificacionFianzas');
		$emailUser				= $this->input->post('emailUser');
		$permisosVerRamosCotiza	= $this->input->post('actividades_agregar_Cotizacion_VER');
		
		if($this->input->post('tipoEdicion',TRUE) == "User"){
			$view		= "configuraciones/editUser";
			$redirect	= "configuraciones/listUser";
		} else {
			$view		= "configuraciones/editVend";
			$redirect	= "configuraciones/listVend";
		}

		$sqlUpdateUser = "
			Update
				`users`
			Set
				`name_complete` = '".$name_complete."',
				
				`idTipoUser` = '".$idTipoUser."',
				`banned` = '".$banned."',
				`passwordVisible`='".$contrasenia."',
	            `CelularSMS` = '".$CelularSMS."',


	            `IdSucursal` = '".$Sucursal."',
	            `IdCanal` = '".$Canal."'


			Where
				`id` = '".$idUser."'
						 ";
		$this->db->query($sqlUpdateUser);


		if($contrasenia != ""){
			$this->tank_auth->change_password_user($idUser,$contrasenia);
		}

		if($this->input->post('tipoEdicion',TRUE) == "Vend"){
			$sqlUpdateMiInfo = "
				Update
					`user_miInfo`
				Set
					`Giro` 					= '".$Giro."',
					`Ranking`				= '".$Ranking."'

					

				Where
					`emailUser` = '".$emailUser."'
							   ";
			$this->db->query($sqlUpdateMiInfo);

			if(count($permisosVerRamosCotiza) > 0 && isset($permisosVerRamosCotiza)){
				$sql_UpdatePermisosVerRamosCotizacion_Reset = "
					Update
						`vend_permisos`
					Set
						`permiso`	= 'NO'
					Where
						`tipo`		= 'Cotizacion'
						And
						`accion`	= 'VER'
						And
						`emailUser`	= '".$emailUser."'
															  ";
				$this->db->query($sql_UpdatePermisosVerRamosCotizacion_Reset);
			if($permisosVerRamosCotiza){				
			foreach($permisosVerRamosCotiza as $verRamoCotizacion){
				$sql_UpdatePermisosVerRamosCotizacion = "
					Update
						`vend_permisos`
					Set
						`permiso`	= 'SI'
					Where
						`tipo`		= 'Cotizacion'
						And
						`accion`	= 'VER'
						And
						`ramo`		= '".$verRamoCotizacion."'
						And
						`emailUser`	= '".$emailUser."'
														";
				$this->db->query($sql_UpdatePermisosVerRamosCotizacion);
			}
			}
			}
		}
			$data['detalleUsuario'] = $this->capsysdre->detalleUsuario($idUser);
			$data['alert']		= "success";
			$this->load->view($view, $data);
		}

	/**
	 * Show info message
	 *
	 * @param	string
	 * @return	void
	 */
	function _show_message($message)
	{
		$this->session->set_flashdata('message', $message);
		redirect('configuraciones/addUser'); 
	}
	
	/**
	 * Send email message of given type (activate, forgot_password, etc.)
	 *
	 * @param	string
	 * @param	string
	 * @param	array
	 * @return	void
	 */
	function _send_email($type, $email, &$data){
		$this->load->library('email');
		$this->email->from($this->config->item('webmaster_email', 'tank_auth'), $this->config->item('website_name', 'tank_auth'));
		$this->email->reply_to($this->config->item('webmaster_email', 'tank_auth'), $this->config->item('website_name', 'tank_auth'));
		$this->email->to($email);
		$this->email->subject(sprintf($this->lang->line('auth_subject_'.$type), $this->config->item('website_name', 'tank_auth')));
		$this->email->message($this->load->view('email/'.$type.'-html', $data, TRUE));
		$this->email->set_alt_message($this->load->view('email/'.$type.'-txt', $data, TRUE));
		$this->email->send();
	}

}
/* End of file configuracones.php */
/* Location: ./application/controllers/configuraciones.php */