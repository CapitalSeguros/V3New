<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class administrador extends CI_Controller
{
  var $idUsuario='';
  function __construct()
  {
		parent::__construct();
    $this->CI =& get_instance();
       $this->load->library('Libreriav3');
       $this->load->library('Phpmailer_lib');
       $this->load->library('tank_auth');
       //$this->lang->load('tank_auth');
      //  $this->load->model("Musuario");
       //session_start();
       //$this->idUsuario=$_SESSION['idusuario'];
  }
 
  //--
  function guardarDocumento()
{

   $info = new SplFileInfo($_FILES['escogerArchivosAD']['name']);

  //session_start();
  //$idUsuario=$_SESSION['idusuario'];
  $idUsuario =  $this->tank_auth->get_idPersona();
  $respuesta['mensaje']='ARCHIVO AGREGADO CON EXITO';
  $tipoArchivo=$this->db->query('select catalogoTipoDocumento from catalogotipodocumento where idCTD='.$_POST['tipoDocumentoSelectADoc'])->result()[0]->catalogoTipoDocumento;
  //$directorio='C:\wamp64\www\sloanseguimiento\assets\documentos\\'. $idUsuario.'\\';
  $directorio='assets\documentos\\'. $idUsuario.'\\';
  if(!file_exists($directorio)){mkdir($directorio, 0777,true);}
  $directorio .= $tipoArchivo.'.'.$info->getExtension();

  move_uploaded_file($_FILES['escogerArchivosAD']['tmp_name'], $directorio);
  echo json_encode($respuesta);
  
}
//-----------------------------------------
public function devolverArchivos($directorio='')
{
  //$comprueba='./'.$directorio;
  //session_start();
  //console.log($_SESSION);
  //$idUsuario=$_SESSION['idusuario'];
  //$comprobar='C:\wamp64\www\sloanseguimiento\assets\documentos\\'. $idUsuario.'\\';
   $idusuario =  $this->tank_auth->get_idPersona();
  //  $directorio='assets\documentos\\';
  $directorio="assets\documentos\\". $idusuario."\\";
 //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($directorio, TRUE));fclose($fp);
  $dato=array();
  if(file_exists($directorio))
  {
   $ficheros  = scandir($directorio);
    $cantArchivos=count($ficheros);

    for($i=2;$i<$cantArchivos;$i++)

    {
      $extension=explode(".",$ficheros[$i] );
      $largo=count($extension);
      if($largo>1){
       $archivo['url']='<a  href="'.base_url().$directorio.$ficheros[$i].'" target="_blank">'.$ficheros[$i].'</a>';
       $archivo['nombreArchivo']=$ficheros[$i];
      $archivo['PathWWW']=base_url().$directorio.$ficheros[$i];
      $archivo['nombreArchivo']=$ficheros[$i];
      array_push($dato, $archivo);

      }

    }
    }
  //  $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($dato, TRUE));fclose($fp);
    echo json_encode($dato);

   //echo json_encode($directorio);

  }

}