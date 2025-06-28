
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class buscaXfolio extends CI_Controller
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
  $this->load->library('Ws_sicas');
 
  }


    function index()
   {	
    	if (!$this->tank_auth->is_logged_in()) 
    	{
		    redirect('/auth/login/');
     	} 
	   else 
   	{


$vendedor=$this->tank_auth->get_IDVend();
if($vendedor>0){
  $idPersona=$this->tank_auth->get_idPersona()*1000;
  if($vendedor==$idPersona){$vendedor=0;}
}
//SERIE=2T1BU42E49C086672
//PLACA=YZX262A
if($this->input->post('opcionBusqueda')!='DOCUMENTO')
{
 if($this->input->post('opcionBusqueda')=='SERIE') 
 {
   $poliza=$this->ws_sicas->buscarDocumentoDetalle('','',$this->input->post('TbuscarXfolio'));
   if(isset($poliza->TableInfo)){$_POST['TbuscarXfolio']=(string)$poliza->TableInfo[0]->Documento;}
   else{$_POST['TbuscarXfolio']='-z0';}
 }
 else
 {
  if($this->input->post('opcionBusqueda')=='PLACA')
  {
    $poliza=$this->ws_sicas->buscarDocumentoDetalle('',$this->input->post('TbuscarXfolio'),'');

       if(isset($poliza->TableInfo)){$_POST['TbuscarXfolio']=(string)$poliza->TableInfo[0]->Documento;}
   else{$_POST['TbuscarXfolio']='-z0';}
  }
 }
}

$xml=$this->ws_sicas->obtenerCobranzaEfectuadaPorFolio($this->input->post('TbuscarXfolio'),$vendedor);
    
                  $bandera="";
                 foreach($xml->TableInfo as $table)
                 {
                  $bandera=$table->Status_TXT;
                 }
                 $contador=0;
                 $contador=$xml->TableControl->MaxRecords;
                 if($contador>1){                             
                        $this->load->view('reportes/produccion',$xml);                 
                 }
                 else
                 { 
                     $x['TableInfo']= $xml->TableInfo; 
                   $x['TableControl'] =$xml->TableControl;
                   $this->load->view('reportes/produccion',$x);
                 }  	
   }
   

  }
}
