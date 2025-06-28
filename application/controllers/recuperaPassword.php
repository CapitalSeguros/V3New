<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class recuperaPassword extends CI_Controller
{
 private $quitarSicas = array('<p>', '</p>', '<br />', ',');
 private $ponerSicas = array('', '', '\n\r', '');	
 function __construct()
  {
	parent::__construct();		
	$params['id_sicas'] = $this->tank_auth->get_IDUserSICAS(); "get_IDUserSICAS";
	$params['user_sicas'] = $this->tank_auth->get_UserSICAS(); "get_UserSICAS";
	$params['pass_sicas'] = $this->tank_auth->get_PassSICAS(); "get_PassSICAS";
	$this->load->library('Ws_sicasdre',$params);

	$this->load->helper('ckeditor');
	$this->load->model('capsysdre_actividades');
	$this->load->library(array("webservice_sicas_soap","role"));	
 
  }
    function index()
   {	
   	$this->load->view('configuraciones/recuperaPassword');	
   }
   function guardaCorreoParaEnviar(){

   	$var=$this->input->post('direccionCorreo');

   	//llamar a un modelo
   	$this->load->model('insertaCorreos');
//llamar a  un modelo dentro de un subdirectorio  $this->load->model('carpeta_del_modelo/Nombre_model');
//CARGAR VARIOS MODELO DE UNA SOLA VEZ $this->load->model(array('Cliente_model','Factura_model'));
   	$datos;
   	$resultado=$this->insertaCorreos->insertaCorreos(strtoupper($var));
    if($resultado==-1){
    	$datos['datos']="EL CORREO NO SE ENCUENTRA REGISTRADO";

    	 $this->load->view('configuraciones/recuperaPassword',$datos);
      
    }
    else{
    	$datos['datos']="SU PASSWORD SE A ENVIADO AL CORREO PROPORCIONADO EN BREVE SEGUNDOS SE REEDIRIGIRA A LA PAGINA PRINCIPAL";
    	$datos['reedirigir']=1;
    	 $this->load->view('configuraciones/recuperaPassword',$datos);

    }
    
   	

   }


}