<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class archivos extends CI_Controller
{
   function __construct()
  {
     parent::__construct();	
  	$this->load->library('Ws_sicas');
  }
  //-----------------------------------------------------------
   function index()
 { 
 }
 //-----------------------------------------------------------
 //-----------------------------------------------------------
function peticionArchivoSicas()
{
      
  switch ($_POST['tipoBusqueda']) {
    case 'recibo':
           $idDocto = $_POST['idRecibo']; 
           $data = array("IDDocto" => $idDocto,"ReadRecursive"=>0,'RECEIPT'=>0);
           $data_result = $this->ws_sicas->GetCDDigital($data);      break;
        case 'documento':
                   $idDocto = $_POST['idDocumento']; 
           $data = array("IDDocto" => $idDocto,"ReadRecursive"=>0);
           $data_result = $this->ws_sicas->GetCDDigital($data);
      # code...
      break;
              case 'cliente':
                $data['IDValuePK']=$_POST['idCliente'];
 // $data['IDDocto']=6936;
  $data['RECEIPT']=1;
    $info=array();
$data_result =$this->ws_sicas->GetCDDigitalCliente($data,1);
     
      break;
              case 'todo':
      # code...
      break;
   
  }
  
   echo json_encode($data_result);
}
//-----------------------------------------------------------

}