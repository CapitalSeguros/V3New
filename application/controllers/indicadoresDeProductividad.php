<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//require_once __DIR__.'dompdf/autoload.inc.php';
//use Dompdf\Dompdf;
//require_once(dirname(__FILE__) . '\dompdf\autoload.inc');

class indicadoresDeProductividad extends CI_Controller{
	  function __construct(){
    parent::__construct();

    $this->load->library("libreriav3");
    $this->load->model('kpi');
   
  }
  function index()
  {
  	 if (!$this->tank_auth->is_logged_in()){redirect('/auth/login/');}
     $datos['imprimirMenu']=true;
  	  $this->load->view('persona/indicadoresDeProductividad',$datos);
  }
  //-----------------------------------------------------------
  function devolverPuestos()
  {
  	$this->load->model('capitalhumano_model');
  	$datos['puestos'] = $this->capitalhumano_model->devolverPuestos(1);
  	echo json_encode($datos);
  }
  //-----------------------------------------------------------
  function manejoKPI()
  {
    $respuesta['success']=true;
    $respuesta['mensaje']='GUARDADO CON EXITO';
    if(isset($_POST['idKPI']))
    {
     $kpi=$this->kpi->kpi_indicadoproductividad($_POST);
     //$respuesta['kpi']=$this->kpi->kpi_indicadoproductividad()['kpi'];
      if(!$kpi['success'])
      {
        $respuesta['success']=false;
        $respuesta['mensaje']=$kpi['mensaje'];     
      }
    }
    else
    {
     //$respuesta['kpi']=$this->kpi->kpi_indicadoproductividad()['kpi'];
    }
    $respuesta['kpi']=$this->kpi->kpi_indicadoproductividad()['kpi'];
   
    echo json_encode($respuesta);
  }
  //-----------------------------------------------------------
  function guardarActualizacionKPI()
  {
    $respuesta['success']=1;
    $kpi=json_decode($_POST['kpi']);   
    foreach ($kpi as $value) 
    {
      $update['kpi']=$value->kpi;
      $update['variable1']=$value->variable1;
      $update['variable2']=$value->variable2;
      $update['comentarioKPI']=$value->comentarioKPI;
      $update['idKPI']=$value->idKPI;
      $update['referenciaKPI']=$value->referenciaKPI;
      $update['update']=1;
      $this->kpi->kpi_indicadoproductividad($update);
    }
    $respuesta['kpi']=$this->kpi->kpi_indicadoproductividad()['kpi'];
    echo json_encode($respuesta);
  }
//-----------------------------------------------------------
function eliminarKPI()
{
  $respuesta['success']=true;
  $respuesta['mensaje']='ELIMINACION CORRECTA';
  $array['idKPI']=$_POST['idKPI'];
  $kpi=$this->kpi->kpi_puesto($array);

   if(count($kpi['kpiPuesto'])==0)
   {

     $borrar['estaBorrado']=1;
     $borrar['idKPI']=$_POST['idKPI'];
     $borrar['update']='';
     $this->kpi->kpi_indicadoproductividad($borrar);
    
   }
   else
   {
    $respuesta['success']=false;
    $respuesta['mensaje']='NO SE LLEVO A CABO LA YA QUE UNO O VARIOS PUESTOS ESTAN RELACIONADOS CON ES KPI';
 
   }
  echo json_encode($respuesta);
}
//-----------------------------------------------------------
function unirPuestoKPI()
{
  $respuesta['success']=true;
  $respuesta['mensaje']='';
  
  $insert['idPuesto']=$_POST['idPuesto'];
  $insert['idKPI']=$_POST['idKPI'];
  $peticion=$this->kpi->kpi_puesto($insert);
 
  $anio=date('Y');
  $mes=date('m');

   for($i=$mes;$i<=12;$i++)
   {

   $insert['idKPI']=$_POST['idKPI'];
   $insert['idPuesto']=$_POST['idPuesto'];
   $insert['anio']=$anio;
   $insert['mes']=$i;
   $insert['variable1']=$_POST['variable1'];
   $insert['variable2']=$_POST['variable2'];
   $insert['insert']=1;

  $this->kpi->kpi_puesto_mesanio($insert);
   }



  $respuesta['success']=$peticion['success'];
  $respuesta['mensaje']=$peticion['mensaje'];  
  echo json_encode($respuesta);
}
//----------------------------------------------------------
function borrarPuestoParaKPI()
{
  $respuesta['success']=true;
  $respuesta['mensaje']='';  
  $delete['idPuesto']=$_POST['idPuesto'];
  $delete['idKPI']=$_POST['idKPI'];
  $delete['eliminar']=1;
  $peticion=$this->kpi->kpi_puesto($delete);
  $respuesta['success']=$peticion['success'];
  $respuesta['mensaje']=$peticion['mensaje'];  
  $_POST['function']=1;

  $datos=$this->kpiUnionPuesto();
  $respuesta['kpiPuesto']=$datos['kpiPuesto'];
  $respuesta['mes']=$datos['mes'];
  $respuesta['anio']=$datos['anio'];
  //$respuesta['tieneOtrosPuestos']=$datos['tieneOtrosPuestos'];

  echo json_encode($respuesta);
}
//----------------------------------------------------------
function kpiUnionPuesto()
{
  $respuesta['success']=1;
  $kpiPuesto=$this->kpi->kpiUnionPuesto();
  $respuesta['kpiPuesto']=$kpiPuesto['kpiPuesto'];
  $respuesta['tieneOtrosPuestos']=$kpiPuesto['tieneOtrosPuestos'];  
if(isset($_POST['mesAnio']))
{
  $mesAnio=explode('-', $_POST['mesAnio']);
  $respuesta['mes']=$mesAnio[1];
  $respuesta['anio']=$mesAnio[0];

}
else
{
  $respuesta['mes']=date("m");
  $respuesta['anio']=date("Y");
}
$respuesta['botonesModificacion']='';
  if($kpiPuesto['tieneOtrosPuestos'])
  {
    $respuesta['botonesModificacion']='<div style="margin-right: 13px"><button class="btn btn-warning" onclick="editarKPIPuestoMesAnio()" title="EDITAR">&#9997</button></div>
                <div style="margin-right: 13px"><button class="btn btn-warning" onclick="editarKPIPuestoMesAnio(1)" title="CANCELAR EDICION"><span>&#10060</span></button></div>
                <div style="margin-right: 13px"><button class="btn btn-success" onclick="guardarKPIPuestoMesAnio()" title="GUARDAR CAMBIOS">&#128190</button></div> 
                <div style="margin-right: 13px"><button class="btn btn-danger" onclick="borrarPuestoParaKPI()" title="ELIMINAR KPI DEL PUESTO">&#9940</button></div>
                ';
  }
  if(isset($_POST['function'])){return $respuesta;}
  else{echo json_encode($respuesta);}
}
//---------------------------------------------------------
function devolverKPIPuestoAnioMes()
{
  
   $respuesta['success']=1;
   if(isset($_POST['mesAnio']))
   {
    $mesAnio=explode('-', $_POST['mesAnio']);
    $array['anio']=$mesAnio[0];
    $array['mes']=$mesAnio[1];
    $respuesta['kpiPuestosMesAnio']=$this->kpi->kpi_puesto_mesanio($array)['kpiPuestosMesAnio'];
   }
   else
   {
    if(isset($_POST['anio']))
    {
          $array['idKPI']=$_POST['kpi'];
          $array['anio']=2024;//$_POST['anio'];
          $array['idPuesto']=$_POST['idPuesto'];
       $respuesta['kpiPuestosMesAnio']=$this->kpi->kpi_puesto_mesanio($array)['kpiPuestosMesAnio'];
       $kpi['idKPI']=$_POST['kpi'];
       $respuesta['variable2']=$this->kpi->kpi_indicadoproductividad($kpi)['kpi'][0]->variable2;
       $respuesta['meses']=$this->libreriav3->devolverMeses();   
    }
   }



   echo json_encode($respuesta);
}
//---------------------------------------------------------
function guardarKPIPuestoMesAnio()
{
  $respuesta['success']=1;
  $kpiPuestoMesAnio=json_decode($_POST['kpiPuestoMesAnio']);

  $mesAnio=explode('-', $_POST['mesAnio']);
  foreach ($kpiPuestoMesAnio as $value) 
  {
   $insert['idKPI']=$value->idKPI;
   $insert['idPuesto']=$value->idPuesto;
   $insert['anio']=$mesAnio[0];
   $insert['mes']=$mesAnio[1];
   $insert['variable1']=$value->variable1;
   $insert['variable2']=$value->variable2;
   $insert['insert']=1;
  $this->kpi->kpi_puesto_mesanio($insert);
     
  }
  $respuesta['anio']=$mesAnio[0];
  $respuesta['mes']=$mesAnio[1];
  echo json_encode($respuesta);
}

//---------------------------------------------------------
//---------------------------------------------------------  
function guardarCadaKpiPuestoPorMesAnio()
{

  $respuesta['success']=1;
    $mesAnio=explode('-', $_POST['mesAnio']);
  $kpiPuestoMes=json_decode($_POST['kpiPuestoMes']);
  $array['anio']=$mesAnio[0];
  $array['idPuesto']=$_POST['idPuesto'];
  $array['idKPI']=$_POST['idKPI'];
  $kpiAnio=$this->kpi->kpi_puesto_mesanio($array)['kpiPuestosMesAnio'];

  foreach ($kpiPuestoMes as $key => $value) 
  {

    $variable1=0;
    foreach ($kpiAnio as $valKpiAnio) 
    {
      if($valKpiAnio->mes==$value->mes)
      {
        $variable1=$valKpiAnio->variable1;
      }
    }
   $insert['idKPI']=$_POST['idKPI'];
   $insert['idPuesto']=$_POST['idPuesto'];
   $insert['anio']=$mesAnio[0];
   $insert['mes']=$value->mes;
   $insert['variable1']=$variable1;
   $insert['variable2']=$value->valor;
   $insert['insert']=1;
  $this->kpi->kpi_puesto_mesanio($insert);
  }
  echo json_encode($respuesta);
}
 
}
