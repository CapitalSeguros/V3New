<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//require_once __DIR__.'dompdf/autoload.inc.php';
//use Dompdf\Dompdf;
//require_once(dirname(__FILE__) . '\dompdf\autoload.inc');

class pruebas extends CI_Controller{
	var $mensaje	= "";


public function __Construct(){
	parent::__Construct();
   $this->load->library('ws_sicas');
}
//------------------------------------------


function documentoPorNombre()
 {
 	/*
       POR QUE NO DEVUELVE EL DOCUMENTO
        *FALTA DE RECIBOS
        *ACTUALIZACION DE MONTOS
 	*/
   $documento=$this->ws_sicas->buscaDocumento('0880347157');
   $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($documento,false));fclose($fp);
}
//------------------------------------------

function reciboPorId()
{
	$recibo=$this->ws_sicas->buscarReciboPorID(343847);
	$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($recibo,TRUE));fclose($fp);
}
//-----------------------------------------------------------
function traerBorrados()
{
  $consulta='select * from papelera where year(fechaEliminacion)=2024 and tabla="facturas" and email="CONTABILIDAD@AGENTECAPITAL.COM"';

  $datos=$this->db->query($consulta)->result();
  foreach ($datos as  $value) 
  {
   //var_dump();  
    $datosDecode=json_decode($value->datos);
    $nombreProveedor=$this->db->query('select NombreProveedor from proveedores p where p.id='.$datosDecode->idProveedor)->result()[0]->NombreProveedor;
    $datosDecode->nombreProveedor=$nombreProveedor;
   $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($datosDecode,TRUE));fclose($fp);
  }
  
}
//-----------------------------------------------------------
function crearDirectorio()
{
  $this->load->model('manejodocumento_modelo');
  $repository = $this->manejodocumento_modelo->obtenerDirectorio("U");  
  $link = $repository.'archivosSiniestros'; //'/var/www/html/V3/archivosSiniestros/'
  if (!file_exists($link)) {mkdir($link, 0777, true);}
  $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($link,false));fclose($fp);
}
//-----------------------------------------------------------
function ssh()
{
  if (!function_exists('ssh2_connect')) { die('No existe la funcion ssh2_connect.');}
}
//-----------------------------------------------------------
}