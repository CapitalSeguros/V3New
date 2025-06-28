<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//require_once __DIR__.'dompdf/autoload.inc.php';
//use Dompdf\Dompdf;
//require_once(dirname(__FILE__) . '\dompdf\autoload.inc');

class contabilidad extends CI_Controller{
//------------------------------------------------------------------------------------------------------------------------------------------
var $datos	= array(); //"";
		function __construct(){
		parent::__construct();     
		$this->CI =& get_instance();
		$this->load->model('contabilidadmodelo');
		$this->load->model('catalogos_model');
      $this->load->model('personamodelo');
    $this->load->library('libreriav3');
    $this->load->library('ws_sicas');
$this->load->model('ReportePresupuestoModel');
		  if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');}

	}
//-----------------------------------------------------------------------------------
function index(){
	$this->datos['aperturaCierre']=$this->contabilidadmodelo->aperturaContable(null);
  $this->datos['tarjetasFormaDePago']=$this->contabilidadmodelo->devolverTarjetas(null);
	$this->datos['departamentos']=$this->catalogos_model->obtenerCatAbtDpto(null);
  $this->datos['empleados2']=$this->personamodelo->devolverColaboradoresActivos();
  $array['grupos']=1;
  $this->datos['empleados']=$this->personamodelo->devolverColaboradoresActivos($array);
  
  /*foreach ($this->datos['empleados'] as $key => $value) 
  {
    foreach ($value['Data'] as  $key1 => $valueData) 
    {
         $select['idPersona']=$valueData['idPersona'];

          //$value['Data'][$valueData['permisosCuentaContable']]=  $this->contabilidadmodelo->relcuentacontabledepartamentopersona($select);
           //$value['permisosCC']=array();
        //$value[$key][$key1]['permisosCC']=$this->contabilidadmodelo->relcuentacontabledepartamentopersona($select); 
        //$this->datos['empleados']['Data'][$key1]['permisosCC']=array();
        $this->datos['empleados'][$key][$key1]['permisosCC']=$this->contabilidadmodelo->relcuentacontabledepartamentopersona($select);
    }
  }*/
 $totalEmpleados=count($this->datos['empleados']);
 for($i=0;$i<$totalEmpleados;$i++)
 {
 
  $totalData=count($this->datos['empleados'][$i]['Data']);
   for($j=0;$j<$totalData;$j++)
   {
    $select['idPersona']=$this->datos['empleados'][$i]['Data'][$j]['idPersona'];
           $permiso=$this->contabilidadmodelo->relcuentacontabledepartamentopersona($select);           
          $this->datos['empleados'][$i]['Data'][$j]['permisosCC']=$permiso;
   }
   
  
 }

  $this->datos['tarjetas']=$this->contabilidadmodelo->tarjetas(null);
	$cuentasContable=$this->contabilidadmodelo->relCuentaContableDepartamento(null);
	$cuentasPorDepartamento=array();$cont=0;
	foreach ($cuentasContable as $value) {$cuentasPorDepartamento[$value->personaDepartamento][$cont]=$value;$cont++;}
	$this->datos['cuentasPorDepartamento']=$cuentasPorDepartamento;
  $this->datos['meses']=$this->libreriav3->devolverMeses();
  $this->datos['anios']=$this->libreriav3->devolverAnios();
  $this->datos['usuarioEmail']=$this->tank_auth->get_usermail();
  $this->datos['catalogoFormaPago']=$this->contabilidadmodelo->catalogFormaPago();
 $this->datos['anioActual']=date('Y');
  $this->datos['mesActual']=(int)date('m');
  //$this->datos['aperturaMeses']


	$this->load->view('contabilidad/contabilidad',$this->datos);
      
}
//-----------------------------------------------------------------------------------
function eliminarCuentaContable(){

$update['statusCC']=0;
$update['idCuentaContable']=$_POST['idCuentaContable'];	
$update['update']=1;
$this->contabilidadmodelo->relCuentaContableDepartamento($update);
$this->index();
}
//-----------------------------------------------------------------------------------
function crearCuentaContable(){

$insert['cuentaContable']=$_POST['cuentaContable'];
$insert['idPersonaDepartamento']=$_POST['idPersonaDepartamento'];
$insert['idCuentaContable']=-1;
$this->datos['pestania']='cuentasContables';
$this->contabilidadmodelo->relCuentaContableDepartamento($insert);
$this->index();
}
//-----------------------------------------------------------------------------------
function guardarMontoMesesDepartamento()
{
  $array['idAperturaContable']=$_GET['idAperturaContable'];
$respuesta=$this->contabilidadmodelo->aperturaContable($array);
$consulta['idPersonaDepartamento']=$_GET['idPersonaDepartamento'];
$consulta['idAperturaContable']=$_GET['idAperturaContable'];
$montoApertura=$this->contabilidadmodelo->relDepartamentoApertura($consulta);
$datos['mensaje']="";
if($respuesta->statusAbiertoAC==1){

$personaDepartamento=explode(';',$_GET['valores']);

$bandActivos=0;
$suma=0;
foreach ($personaDepartamento as  $value) {
  if($value!=''){
    $monto=explode('-',$value);
    $suma=$suma+$monto[1]; 
  }
}
if((int)$suma==(int)$montoApertura[0]->montoDAC )
{ 
  foreach ($personaDepartamento as  $value) {
  if($value!=''){
     $monto=explode('-',$value);
    $update['idAperturaContableMontoMes']=$monto[0];
    $update['montoMes']=$monto[1];
    $update['update']="";
    $this->contabilidadmodelo->aperturacontablemontomes($update);
  }
}
  $datos['mensaje']='La actualizacion fue correcta' ;   
}
else{$datos['mensaje']="La suma montos totales por departamento no son iguales al monto total" ;}
}
else{$datos['mensaje']='No se puede procesar la solicitud';}

echo json_encode($datos);


}
 //-----------------------------------------------------------------------------------
 function devolverMontoMeses(){
  $consulta['idPersonaDepartamento']=$_GET['idPersonaDepartamento'];
  $consulta['idAperturaContable']=$_GET['idAperturaContable'];
  $datos['mesesApertura']=$this->contabilidadmodelo->devolverMesesApertura($consulta);
  $datos['meses']= $this->datos['meses']=$this->libreriav3->devolverMeses();

  $datos['montoDepartamento']=$this->contabilidadmodelo->relDepartamentoApertura($consulta);
 
  echo json_encode($datos);

 }
 //-----------------------------------------------------------------------------------
function aperturaContable()
  {

 $respuesta=$this->contabilidadmodelo->verificaAperturaContable();
      if($respuesta[0]->total>0){
      	$anioSiguiente=(int)$respuesta[0]->anioAC+1;
      	$this->datos['aperturaContable']['anioAc']=$respuesta[0]->anioAC;
      	$this->datos['aperturaContable']['anioSiguiente']=$anioSiguiente;
      	//$this->datos['mensaje']='Desea cerrar la cuenta contable '.$respuesta[0]->anioAC.' y abrir '.$anioSiguiente;
      	$this->datos['pestania']='cierreContable';

      }
      $this->index();
  //$this->load->view('contabilidad/contabilidad',$this->datos);
  }
 //-----------------------------------------------------------------------------------
 function abrirCerrarCC(){
 	$idPersona=$this->tank_auth->get_idPersona();
 	 $respuesta=$this->contabilidadmodelo->verificaAperturaContable();
 	 $montoCierre=$this->contabilidadmodelo->calcularTotalFacturasAnio($respuesta[0]->anioAC);	  
 	if($montoCierre[0]->total==""){$montoCierre[0]->total=0;}
  $cuentasContablesAntiguas=$this->contabilidadmodelo->relCuentaContableDepartamento(null);
 	 $update['totalCierreAC']=$montoCierre[0]->total;
 	 $update['idAperturaContable']=$respuesta[0]->idAperturaContable;
 	 $update['update']=0;
 	 $update['statusAbiertoAC']=0;
     $update['idPersona']=$idPersona;
     $update['fechaCierreAC']=date("Y/m/d");
 	 $this->contabilidadmodelo->aperturaContable($update);   
 	 $anioSiguiente=(int)$respuesta[0]->anioAC+1;
 	 $insert['idAperturaContable']=-1;
 	 $insert['inicialAC']=$montoCierre[0]->total;
     $insert['anioAC']=$anioSiguiente;
     $insert['idPersona']=$idPersona;
     $idAperturaContable=$this->contabilidadmodelo->aperturaContable($insert);
     $departamentos=$this->catalogos_model->obtenerCatAbtDpto(null);
     foreach ($departamentos as  $value) 
     {
     	$insertar['idPersonaDepartamento']=$value->idPersonaDepartamento;
     	$insertar['idAperturaContable']=$idAperturaContable;
     	$insertar['idRelDepartamentoApertura']=-1;
     	$this->contabilidadmodelo->relDepartamentoApertura($insertar);
     $insertMeses['idAperturaContable']=$idAperturaContable;
     $insertMeses['idPersonaDepartamento']=$value->idPersonaDepartamento;
     $this->contabilidadmodelo->crearMesesApertura($insertMeses);
     }
     foreach ($cuentasContablesAntiguas as $value) 
     {
       $insert="";
       $insert['cuentaContable']=$value->cuentaContable;
       $insert['idPersonaDepartamento']=$value->idPersonaDepartamento;
       $insert['statusCC']=$value->statusCC;
       $insert['idAperturaContable']=$idAperturaContable;
       $insert['idCuentaContable']=-1;
       $insert['idCuentaContableInicial']=$value->idCuentaContableInicial;
       $insert['fianzasPorcentaje']=$value->fianzasPorcentaje;
       $insert['institucionalPorcentaje']=$value->institucionalPorcentaje;
       $insert['coorporativoPorcentaje']=$value->coorporativoPorcentaje;
       $insert['asesoresPorcentaje']=$value->asesoresPorcentaje;
       $insert['gestionPorcentaje']=$value->gestionPorcentaje;
       $insert['idCuentaContableAnterior']=$value->idCuentaContable;
       //$insert['personaDepartamento']=$value->personaDepartamento;
       //$insert['sumPorcentaje']=$value->sumPorcentaje;
         //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($insert, TRUE));fclose($fp);
       $idNuevaCC=$this->contabilidadmodelo->relCuentaContableDepartamento($insert);
       $idPersonasCCAntiguas=$this->db->query('select idPersona from relcuentacontabledepartamentopersona where idCuentaContable='.$value->idCuentaContable)->result();
       
        foreach ($idPersonasCCAntiguas as $dat) 
        {
          $insertRCCD['idPersona']=$dat->idPersona;
          $insertRCCD['idCuentaContable']=$idNuevaCC;
          $insertRCCD['idAperturaContable']=$idAperturaContable;
          
       
          $insertRCCD['idCuentaContableAnterior']=$value->idCuentaContable;
          $insertRCCD['idCuentaContableInicial']=$value->idCuentaContableInicial;
          $this->db->insert('relcuentacontabledepartamentopersona',$insertRCCD);
        }
     }

 	  //$this->load->view('contabilidad/contabilidad',$this->datos);
 	  $this->datos['pestania']='aperturaContable';
 	  $this->index();
 }
//------------------------------------------------------------------------------------------------------------
function guardarPorcentaje()
{
 $datos['mensaje']='Guardar con Exito';
  $idCuentaContable=explode(',', $_POST['cuentas']);
  
  foreach ($idCuentaContable as  $value) {
    if($idCuentaContable!=''){
    $update['fianzasPorcentaje']=$_POST['fianzasPorcentaje'];
    $update['institucionalPorcentaje']=$_POST['institucionalPorcentaje'];
    $update['coorporativoPorcentaje']=$_POST['coorporativoPorcentaje'];
    $update['gestionPorcentaje']=$_POST['gestionPorcentaje'];
    $update['asesoresPorcentaje']=$_POST['asesoresPorcentaje'];
    $update['idCuentaContable']=$value;
    $update['update']='';
    $this->contabilidadmodelo->relCuentaContableDepartamento($update);
    
    }
  }
  $this->index();
  //echo json_encode($datos);
}

//------------------------------------------------------------------------------------------------------------
function guardarPromoBono()
{
  $informacion['mensaje']='El guardado se realizo con exito';
  $informacion['seGuardo']=1;
  $insert['anio']=$_GET['anio'];
  $insert['mes']=$_GET['mes'];
  $insert['tipo']=$_GET['tipo'];
  $insert['canal']=$_GET['canal'];
  $insert['cantidad']=$_GET['cantidad'];
  $insert['idPromoBono']=-1;
  $insert['email']=$this->tank_auth->get_usermail();
  //$seInserta=$this->contabilidadmodelo->buscarPromoBonoAnioAndMes($insert);
  $this->contabilidadmodelo->promobono($insert);  
  /*if((count($seInserta))==0){$this->contabilidadmodelo->promobono($insert);}
  else
  {
    $informacion['mensaje']='El guardado no se realizo ya existe uno capturado';
    $informacion['seGuardo']=0;
  }*/
  echo json_encode($informacion);
}
//---------------------------------------------------------------------------------------
function buscarPromoBono()
{
  $respuesta=array();
  
  $respuesta['informacion']=$this->contabilidadmodelo->buscarPromoBonoPorAnio($_GET['anio'],$_GET['tipoCaptura'],$this->tank_auth->get_usermail());    
  echo json_encode($respuesta);
}
//-------------------------------------------
function eliminarPromoBono()
 {
  $respuesta['mensaje']="Eliminacion correcta";
  $respuesta['status']=1;
  $update['idPromoBono']=$_GET['idPromoBono'];
  $update['activo']=0;
  $update['delete']="";

  $this->contabilidadmodelo->promobono($update);
  
  echo json_encode($respuesta);
 }
//--------------------------------------------
function buscarCobranzaEfectuada()
{ 
  $respuesta['respuesta']=array();
  $respuesa['cabecera']='';
  $consulta['mes']=$_GET['mes'];
  $consulta['anio']=$_GET['anio'];
  $respuesta['respuesta']=$this->contabilidadmodelo->estadoFinancieroMesAnio($consulta);
  $respuesta['cabecera']=$this->db->query('show columns from estadofinanciero')->result();
  echo json_encode($respuesta);
}
//-------------------------------------------
//-------------------------------------------------------------------
function sincronizarCobranzaEfectuada()
{
      /*$mes=(date('m'));$mes=$mes-1;$anio=date('Y');
     if($mes==0){$mes=12;$anio=$anio-1;}
    $fechaInicial='01/'.$mes.'/'.$anio;
    $fechaFinal=$this->devuelveUltimoDiaMes().'/'.$mes.'/'.$anio;
  $ultimoDiaMes=$this->libreriav3->devolverUltimoDiaDeMes('/','03','2019');*/
  $respuesta="";
  $primerDiaMes='01'.'/'.$_GET['mes'].'/'.$_GET['anio'];//'01/04/2020';
  $buscar['anio']=$_GET['anio'];
  $buscar['mes']=$_GET['mes'];
  $ultimoDia=$this->libreriav3->diaDeMesFinal($buscar);
  $ultimoDiaMes=$ultimoDia['dia'].'/'.$_GET['mes'].'/'.$_GET['anio'];

  $recibos=$this->ws_sicas->obtenerRecibosPorFecha($primerDiaMes,$ultimoDiaMes,null);
  
  $borrar['anio']=$_GET['anio'];
  $borrar['mes']=$_GET['mes'];
  $this->contabilidadmodelo->borrarEstadoFinanciero($borrar);
  foreach ($recibos as  $value)
  {
   $insert=null; 
   $insert['mes']=$_GET['mes'];
   $insert['anio']=$_GET['anio'];
   $insert['IDRecibo']=$value->IDRecibo;
   $insert['FechaPago']=Strstr($value->FechaPago,"T",true);
   $insert['TipoDocto']=(string)$value->TipoDocto;
   $insert['FechaDocto']=Strstr($value->FechaDocto,"T",true);
   $insert['FLiquidacion']=(isset($value->FLiquidacion))? Strstr($value->FLiquidacion,"T",true) : null;
   $insert['TCPago']=$value->TCPago;
   $insert['MonedaPago']=(string)$value->MonedaPago;
   $insert['Moneda']=(string)$value->Moneda;
   $insert['Documento']=(string)$value->Documento;
   $insert['Endoso']=(isset($value->Endoso))? (string)$value->Endoso : '';
   $insert['Letra']=(isset($value->Letra))? (string)$value->Letra : '';
   $insert['Periodo']=$value->Periodo;
   $insert['Serie']=(string)$value->Serie;
   $insert['FDesde']=Strstr($value->FDesde,"T",true);
   $insert['FHasta']=Strstr($value->FHasta,"T",true);
   $insert['FLimPago']=Strstr($value->FLimPago,"T",true);
$insert['FStatus']=(isset($value->FStatus))? Strstr($value->FStatus,"T",true) : null;

   //$insert['FStatus']=Strstr($value->FStatus,"T",true);   
   $insert['Status']=$value->Status;
   $insert['Status_TXT']=(string)$value->Status_TXT;
   $insert['PrimaNeta']=$value->PrimaNeta;
   $insert['Descuento']=$value->Descuento;
   $insert['Recargos']=$value->Recargos;
   $insert['Derechos']=$value->Derechos;
   $insert['GastosAdm']=$value->GastosAdm;
   $insert['Impuesto1']=$value->Impuesto1;
   $insert['Impuesto2']=$value->Impuesto2;
   $insert['FondoInv']=$value->FondoInv;
   $insert['PrimaTotal']=$value->PrimaTotal;
   $insert['Comision0']=$value->Comision0;
   $insert['Comision1']=$value->Comision1;
   $insert['Comision2']=$value->Comision2;
   $insert['Comision3']=$value->Comision3;
   $insert['Comision4']=$value->Comision4;
   $insert['Comision5']=$value->Comision5;
   $insert['Comision6']=$value->Comision6;
   $insert['Comision7']=$value->Comision7;
   $insert['Comision8']=$value->Comision8;
   $insert['Comision9']=$value->Comision9;
   $insert['Grupo']=(string)$value->Grupo;
   $insert['SubGrupo']=(string)$value->SubGrupo;
   $insert['NombreCompleto']=(string)$value->NombreCompleto;
   $insert['CAgente']=(string)$value->CAgente;
   $insert['AgenteNombre']=(string)$value->AgenteNombre;
   $insert['VendNombre']=(string)$value->VendNombre;
   $insert['OfnaNombre']=(string)$value->OfnaNombre;
   $insert['FPago']=(string)$value->FPago;
   $insert['RamosNombre']=(string)$value->RamosNombre;
   $insert['SRamoNombre']=(string)$value->SRamoNombre;
   $insert['CCobro_TXT']=(string)$value->CCobro_TXT;
   $insert['IDDocto']=$value->IDDocto;
   $insert['DespNombre']=(string)$value->DespNombre;
   $insert['ImportePago']=$value->ImportePago;
   $insert['ImporteReal']=$value->ImporteReal;
   $insert['ImportePagoTC']=$value->ImportePagoTC;
   $insert['Renovacion']=$value->Renovacion;
   $insert['ClasCia_TXT']=(string)$value->ClasCia_TXT;
   $insert['GerenciaNombre']=(string)$value->GerenciaNombre;
   $insert['RenovacionDocto']=$value->RenovacionDocto;
   $insert['VendAbreviacion']=(string)$value->VendAbreviacion;
   $insert['EjecutNombre']=(string)$value->EjecutNombre;   
   //(isset($value->FEmisionDocto))? $insert['FEmisionDocto']=Strstr($value->FEmisionDocto,"T",true);
    $this->db->insert('estadofinanciero',$insert);   
  }
  $respuesta['status']=1;
  echo json_encode($respuesta);

}
//------------------------------------------------------------------
function subirArchivoPromoBono()
{
  /*DIRECCION PARA HACER CUANDO SE EJECUTE LOCALMENTE*/
$directorio=$_SERVER["DOCUMENT_ROOT"]."/Capsys/www/V3/ArchivosPromoBono/".$_POST['idPromoBono']."";//base_url().'ArchivosPresupuesto/'.$_POST['id']."/"; 
///*DIRECTORIO CUANDO SE SUBE AL SERVIDOR  */
//$directorio=$_SERVER["DOCUMENT_ROOT"]."/V3/ArchivosPromoBono/".$_POST['idPromoBono']."";
  
if(!file_exists($directorio))
{@mkdir($directorio, 0700);}
     $extension=explode(".",$_FILES['Archivo']['name'] );
     $largo=count($extension);
if($extension[$largo-1]=='pdf' || $extension[$largo-1]=='PDF' || $extension[$largo-1]=='xml' || $extension[$largo-1]=='XML')
 {
      // $nuevoNombre=$_POST['anio']."-".$_POST['mes'];
        $mi_archivo = 'Archivo';
        $config['upload_path'] = $directorio;
        $config['file_name'] =$_POST['idPromoBono'].".".$extension[$largo-1];
        $config['allowed_types'] = "*";
        $config['max_size'] = "50000";
        $config['max_width'] = "2000";
        $config['overwrite'] = "TRUE";
        $config['max_height'] = "2000";  
        $this->load->library('upload', $config);        
        if ($this->upload->do_upload($mi_archivo)) 
        {

         $this->db->query($updateFactura);
         $cadena['ruta']=base_url()."ArchivosPromoBono/".$_POST['id']."/".$_POST['idPromoBono'].".".$extension[$largo-1];
         $cadena['archivo']=$_POST['id'].".".$extension[$largo-1];
         $cadena['status']="0";
               $archivoRespuesta="ARCHIVO GUARDADO";  
        }
        else{
          $cadena= $_SERVER["DOCUMENT_ROOT"];
         $archivoRespuesta="PROBLEMAS AL PROCESAR EL ARCHIVO";  
        }

}
else{$archivoRespuesta="FORMATO NO VALIDO"; }


 

}
//------------------------------------------------------------------
function guardarTarjeta()
{$respuesta['mensaje']='Tarjeta Guardada';

  if($_GET['numeroTarjeta']!='')
 {
   $insert['numeroTarjeta']=$_GET['numeroTarjeta'];
   $insert['idFormaPago']=$_GET['idFormaPago'];
   $insert['idTarjetas']=-1;
   $this->contabilidadmodelo->tarjetas($insert);
 }
 else{$respuesta['mensaje']='Es necesario agregar numero a la tarjeta';}
 $respuesta['tarjetas']=$this->contabilidadmodelo->tarjetas(null);
 echo json_encode($respuesta);

}
//------------------------------------------------------------------
function asignarTarjeta()
{
  
  $respuesta['mensaje']='La tarjeta se asigno correctamente';
  if($_GET['idPersona']==0){$respuesta['mensaje']='La tarjeta se le ha retirado al empleado';}
  $update['idTarjetas']=$_GET['idTarjetas'];
  $update['idPersona']=(int)$_GET['idPersona'];
  $this->contabilidadmodelo->tarjetas($update);
  $respuesta['tarjetas']=$this->contabilidadmodelo->tarjetas(null);
  
 echo json_encode($respuesta);

}
//------------------------------------------------------------------
function traerFormasPagos()
{
  $resultado['tarjetas']=$this->contabilidadmodelo->devolverTarjetasPersonales();
  $select['idPersona']=$this->tank_auth->get_idPersona();
  $resultado['notas']=$this->contabilidadmodelo->notasparacompras($select);
  
  echo json_encode($resultado);

}
//--------------------------------------------------------------------
function guardarNota()
{
  $insert['idNotasCompra']=-1;
  $insert['descripcionCompras']=$_POST['notasDescripcion'];
  $insert['cargoFianzas']=$_POST['notasCargoFianzas'];
  $insert['cargoEspecial']=$_POST['notasCargoEspeciales'];
  $insert['cargoSeguros']=$_POST['notasCargoSeguros'];
  $insert['montoCompra']=$_POST['notasTotal'];
  $insert['cargoCoorporativo']=$_POST['notasCargoCoorporativos'];
  $insert['cargoEspecial']=$_POST['notasCargoEspeciales']; 
  $insert['idTarjetas']=$_POST['idFormaPago']; 
  $insert['fechaCompra']=$this->libreriav3->convierteFecha($_POST['fechaNota']);
  $this->contabilidadmodelo->notasparacompras($insert);
  $select['idPersona']=$this->tank_auth->get_idPersona();
  $respuesta['notas']=$this->contabilidadmodelo->notasparacompras($select);
  $respuesta['mensaje']='La nota se guardo correctamente';
  echo json_encode($respuesta);

}

//------------------------------------------------------------------
function borrarNotas()
{
  $delete['idNotasCompra']=$_POST['idNotasCompra'];
  $delete['delete']=1;
  $this->contabilidadmodelo->notasparacompras($delete);
  $select['idPersona']=$this->tank_auth->get_idPersona();
  $respuesta['notas']=$this->contabilidadmodelo->notasparacompras($select);
  $respuesta['mensaje']='Se elimino correctamente la nota';
  echo json_encode($respuesta);
}
//-----------------------------------------------------------------
function buscarPersonasConNotas()
{
  $respuesta['personasConNotas']=$this->contabilidadmodelo->buscarPersonasConNotas(null);
  echo json_encode($respuesta);
}
//-------------------------------------------------------------
function traerNotasDePersonas()
{
  $consulta['idPersona']=$_POST['idPersona'];
  $respuesta['notas']=$this->contabilidadmodelo->notasparacompras($consulta);
  
  echo json_encode($respuesta);
}
//-------------------------------------------------------------
function guardarAsignacionCC()
{
  $datos=array();
  $_GET['cuentas']=trim($_GET['cuentas'],',');
  $datos['mensaje']='Datos guardados';
  $insert['idPersona']=$_GET['persona'];
  $insert['idCuentaContable']=$_GET['cuentas'];
  $insert['insert']='';
  
  $this->contabilidadmodelo->relcuentacontabledepartamentopersona($insert);  
  $datos['cuentas']=$_GET['cuentas'];
  $datos['idPersona']=$_GET['persona'];
  echo json_encode($datos);
}
//--------------------------------------------


function asignarCuenteContable()
{
  $cc3=$this->db->query('select rp.*,r.idCuentaContable,r.cuentaContable from relcuentacontabledepartamentopersona rp
left join relcuentacontabledepartamento r on r.idCuentaContable=rp.idCuentaContable')->result();
  $cc4=$this->db->query('select r.idCuentaContable,r.cuentaContable from relcuentacontabledepartamento r where r.idAperturaContable=4')->result();

foreach ($cc4 as  $value) 
{
 foreach ($cc3 as  $value2) 
 {
   if($value->cuentaContable==$value2->cuentaContable) 
   {
    $insert=array();
    $insert['idPersona']=$value2->idPersona;
    $insert['idCuentaContable']=$value->idCuentaContable;
    $insert['idCuentaContableAnterior']=$value2->idCuentaContable;
    $insert['idAperturaContable']=4;
    //$this->db->insert('relcuentacontabledepartamentopersona',$insert);

   }   
 }
}

  
}
//----------------------------------------
function asignarPorcentajePorCuentaContable()
{
  $cc3=$this->db->query('select * from relcuentacontabledepartamento where idAperturaContable=3')->result();
  $cc4=$this->db->query('select * from relcuentacontabledepartamento where idAperturaContable=4')->result();
  foreach ($cc4 as $value) 
  {
    foreach ($cc3 as $valueC) 
    {
     if($value->cuentaContable==$valueC->cuentaContable)
     {
      $update=array();
      $update['fianzasPorcentaje']=$valueC->fianzasPorcentaje;
      $update['institucionalPorcentaje']=$valueC->institucionalPorcentaje;
      $update['coorporativoPorcentaje']=$valueC->coorporativoPorcentaje;
      $update['gestionPorcentaje']=$valueC->gestionPorcentaje;
      $this->db->where('idCuentaContable',$value->idCuentaContable);
      //$this->db->update('relcuentacontabledepartamento',$update);     
     }
    }
  }
}
//-------------------------------------------------------------------------
function devuelveEstadoEr()
{
 //echo  json_encode($_POST); 

//var_dump($_SESSION);

 $ano = $_POST['ano'];
 $mes = $_POST['mes'];
 
 $suma =0;
 $costo =0;
 $gasto =0;
 $nomina =0;
 $i=1;
 while($i <= $mes)
 {
  $respuesta=$this->ReportePresupuestoModel->DevulvePresupuesto($ano,$i);
  foreach($respuesta as $row)
   {
     $suma =$suma+ $row->comision; 
   }   
   $respuestabonoanterior=$this->ReportePresupuestoModel->DevuelveBonoSeguros($ano-1,$i);
   foreach($respuestabonoanterior as $row)
   {
    $suma =$suma+ $row->total; 
   }
   $respuestabono=$this->ReportePresupuestoModel->DevuelveBonoSeguros($ano,$i);
   foreach($respuestabono as $row)
   {
    $suma =$suma+ $row->total; 
   }
   $respuestapromo=$this->ReportePresupuestoModel->DevuelvePromoSeguros($ano,$i);
   foreach($respuestapromo as $row)
   {
    $suma =$suma+ $row->total; 
   }
   $costoventa = $this->ReportePresupuestoModel->DevulveCostoVenta($ano,$i);
   foreach($costoventa as $row)
   {
    $costo =$costo+ $row->total; 
   }
   $gastoopreacion =$this->ReportePresupuestoModel->DevulveGasto($ano,$i);
   foreach($gastoopreacion as $row)
   {
    $gasto =$gasto+ $row->total; 
   }
   $nominaoperacion =$this->ReportePresupuestoModel->DevulveNomina($ano,$i);
   foreach($nominaoperacion as $row)
   {
    $nomina =$nomina+ $row->total; 
   }
  $i = $i +1;
 }
 $envio['total'] = $suma;
 $envio['costo'] = $costo;
 $envio['gasto'] = $gasto;
 $envio['nomina'] = $nomina;
 //fianzas
 $i=1;
 $costof =0;
 $suma2=0;
 $gasto=0;
 $nomina=0;
 while($i <= $mes)
 {
   $respuestafianza=$this->ReportePresupuestoModel->DevuelveFianzas($ano,$i);
   foreach($respuestafianza as $row)
   {
     $suma2 =$suma2+ $row->Fianzas; 
   }   
   $respuestfianzabonoanterior=$this->ReportePresupuestoModel->DevuelveBonoFianzas($ano-1,$i);
   foreach($respuestfianzabonoanterior as $row)
   {
    $suma2 =$suma2+ $row->total; 
   }
   $respuestafianzabono=$this->ReportePresupuestoModel->DevuelveBonoFianzas($ano,$i);
   foreach($respuestafianzabono as $row)
   {
    $suma2 =$suma2+ $row->total; 
   }
   $respuestafianzapromo=$this->ReportePresupuestoModel->DevuelvePromoFianzas($ano,$i);
   foreach($respuestafianzapromo as $row)
   {
    $suma2 =$suma2+ $row->total; 
   }
   $costofianzas = $this->ReportePresupuestoModel->DevulveCostoFianza($ano,1);
   foreach($costofianzas as $row)
   {
    $costof =$costof+ $row->total; 
   }
   $gastoopreacion =$this->ReportePresupuestoModel->DevulveGastoFianza($ano,$i);
   foreach($gastoopreacion as $row)
   {
    $gasto =$gasto+ $row->total; 
   }
   $nominaoperacion =$this->ReportePresupuestoModel->DevulveNominaFianza($ano,$i);
   foreach($nominaoperacion as $row)
   {
    $nomina =$nomina+ $row->total; 
   }
  $i = $i +1;
 } 
 //costo tienes 
 $envio['totalfianza'] = $suma2;
 $envio['costofianza'] = $costof;
 $envio['gastofianza'] = $gasto;
 $envio['nominafianza'] = $nomina;
 $i=1;
 $costoC =0;
 $suma2=0;
 $gasto=0;
 $nomina=0;
 while($i <= $mes)
 {
   $respuestaCorporativa=$this->ReportePresupuestoModel->DevulveComisionCoorpo($ano,$i);
   foreach($respuestaCorporativa as $row)
   {
     $suma2 =$suma2+ $row->total; 
   }   
   $respuestCorporativabonoanterior=$this->ReportePresupuestoModel->DevulveBonoCoorpo($ano-1,$i);
   foreach($respuestCorporativabonoanterior as $row)
   {
    $suma2 =$suma2+ $row->total; 
   }
   $respuestaCorporativabono=$this->ReportePresupuestoModel->DevulveBonoCoorpo($ano,$i);
   foreach($respuestaCorporativabono as $row)
   {
    $suma2 =$suma2+ $row->total; 
   }
    $costoCorporativo = $this->ReportePresupuestoModel->DevulveCostoCoorpo($ano,1);
   foreach($costoCorporativo as $row)
   {
    $costoC =$costoC+ $row->total; 
   }
   $gastoopreacion =$this->ReportePresupuestoModel->DevulveGastoCoorpo($ano,$i);
   foreach($gastoopreacion as $row)
   {
    $gasto =$gasto+ $row->total; 
   }
   $nominaoperacion =$this->ReportePresupuestoModel->DevulveNominaCorpo($ano,$i);
   foreach($nominaoperacion as $row)
   {
    $nomina =$nomina+ $row->total; 
   }
  $i = $i +1;
 }
 //$usuario =  $this->tank_auth->get_idPersona();
 $envio['totalCor'] = $suma2;
 $envio['costoCor'] = $costoC;
 $envio['gastoCor'] = $gasto;
 $envio['nominaCor'] = $nomina;
 $usuario  =  $this->tank_auth->get_idPersona();
   $consulta="select ppg.idPersonaPuestoGrupo  from persona p,personapuesto pp, personapuestogrupo ppg
    where p.idPersona=pp.idPersona and pp.idPersonaPuestoGrupo = ppg.idPersonaPuestoGrupo
    and p.idpersona =".$usuario;
 $envio['usuario'] = $this->db->query($consulta)->result()[0]->idPersonaPuestoGrupo;
 //$envio['usuario'] = $consulta;
 echo  json_encode($envio); 
 }
//-------------------------------------------------------------
function guardarFormaPago()
{
  $respuesta=array();
   
   $this->db->query('delete from relformapagousers where email="'.$_GET['email'].'"');
   $idFormaPago=explode(';', $_GET['idFormaPago']);
   foreach ($idFormaPago as $value) 
   {
     if($value!='')
     {
      $insert['idPersona']=$_GET['idPersona'];
      $insert['email']=$_GET['email'];
      $insert['idFormaPago']=$value;
      $this->db->insert('relformapagousers',$insert);
     }
   }
   $respuesta['success']=true;
  echo json_encode($respuesta);
}
//-------------------------------------------------------------
function permisosFormaPago()
{$respuesta=array();
  //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp,print_r($_GET,TRUE));fclose($fp); 
  $respuesta['idFormaPago']=$this->db->query('select * from relformapagousers where email="'.$_GET['email'].'"')->result();
  $respuesta['success']=true;
  echo json_encode($respuesta);
}
//------------------------------------------------------------
function datosConfiguracionreportes()
{
  $datos=array();
  $grupos=$this->devolverCuentaContableGrupos();
    $datos['gastosOperacion']=$grupos['gastosOperacion'];
    $datos['gastosVariables']=$grupos['gastosVariables'];
    $datos['gastosFinancieros']=$grupos['gastosFinancieros'];
    $datos['gastosImpuestos']=$grupos['gastosImpuestos'];     
       $datos['gastosActivos']=$grupos['gastosActivos'];  
    $datos['mes']=$grupos['mes'];     
    $datos['anio']=$grupos['anio'];  
   echo json_encode($datos);
}
//-------------------------------------------------------
function guardaGrupoCuentaContable()
{
  $insert['tipoGrupo']=$_GET['tipo'];
  $insert['cuentaContableGrupos']=$_GET['grupoCuentaContable'];
  if(isset($_GET['idCuentaContable'])){$insert['idCuentaContable']=$_GET['idCuentaContable'];}
  
  
  $this->db->insert('cuentacontablegrupos',$insert);
  $grupos=$this->devolverCuentaContableGrupos();
    $datos['gastosOperacion']=$grupos['gastosOperacion'];
    $datos['gastosVariables']=$grupos['gastosVariables'];
    $datos['gastosFinancieros']=$grupos['gastosFinancieros'];  
    $datos['gastosImpuestos']=$grupos['gastosImpuestos'];  
    $datos['gastosActivos']=$grupos['gastosActivos'];  
        $datos['mes']=$grupos['mes'];     
    $datos['anio']=$grupos['anio']; 

    echo json_encode($datos);  

  
}
//-------------------------------------------------------
function devolverCuentaContableGrupos()
{
  $datos=array();
  $mes=date('m');
  $year=date('Y');
      $datos['gastosOperacion']=$this->db->query('select * from cuentacontablegrupos where tipoGrupo="gastosOperacion"')->result();
    $datos['gastosVariables']=$this->db->query('select * from cuentacontablegrupos where tipoGrupo="gastosVariables"')->result();
    $datos['gastosFinancieros']=$this->db->query('select * from cuentacontablegrupos where tipoGrupo="gastosFinancieros"')->result();
    $datos['gastosImpuestos']=$this->db->query('select * from cuentacontablegrupos where tipoGrupo="gastosImpuestos"')->result();
    $datos['gastosActivos']=$this->db->query('select * from cuentacontablegrupos where tipoGrupo="gastosActivos"')->result();
    $datos['mes']=$mes;
    $datos['anio']=$year;
    foreach ($datos['gastosOperacion'] as $key => $value) 
    {
     $consulta='select c.idCuentaContable,rc.cuentaContable from cuentascontablesgruporelacion c left join relcuentacontabledepartamento rc on rc.idCuentaContable=c.idCuentaContable where c.idCuentaContableGrupo='.$value->idCuentaContableGrupos;
     $value->hijos=$this->db->query($consulta)->result(); 

     $consulta='select * from cuentacontablegrupospresupuesto c where  c.anio='.$year.' and c.idCuentaContableGrupos='.$value->idCuentaContableGrupos.' order by c.mes';
     //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp,print_r($consulta,TRUE));fclose($fp);
     $value->monto=$this->db->query($consulta)->result();
    }
        foreach ($datos['gastosVariables'] as $key => $value) 
    {
     $consulta='select c.idCuentaContable,rc.cuentaContable from cuentascontablesgruporelacion c left join relcuentacontabledepartamento rc on rc.idCuentaContable=c.idCuentaContable where c.idCuentaContableGrupo='.$value->idCuentaContableGrupos;
     $value->hijos=$this->db->query($consulta)->result();
     $consulta='select * from cuentacontablegrupospresupuesto c where  c.anio='.$year.' and c.idCuentaContableGrupos='.$value->idCuentaContableGrupos.' order by c.mes';
     $value->monto=$this->db->query($consulta)->result();
 
    }
        foreach ($datos['gastosFinancieros'] as $key => $value) 
    {
     $consulta='select c.idCuentaContable,rc.cuentaContable from cuentascontablesgruporelacion c left join relcuentacontabledepartamento rc on rc.idCuentaContable=c.idCuentaContable where c.idCuentaContableGrupo='.$value->idCuentaContableGrupos;
     $value->hijos=$this->db->query($consulta)->result(); 
     $consulta='select * from cuentacontablegrupospresupuesto c where  c.anio='.$year.' and c.idCuentaContableGrupos='.$value->idCuentaContableGrupos.' order by c.mes';
     $value->monto=$this->db->query($consulta)->result();

    }

  foreach ($datos['gastosImpuestos'] as $key => $value) 
    {
     $consulta='select c.idCuentaContable,rc.cuentaContable from cuentascontablesgruporelacion c left join relcuentacontabledepartamento rc on rc.idCuentaContable=c.idCuentaContable where c.idCuentaContableGrupo='.$value->idCuentaContableGrupos;
     $value->hijos=$this->db->query($consulta)->result(); 
     $consulta='select * from cuentacontablegrupospresupuesto c where  c.anio='.$year.' and c.idCuentaContableGrupos='.$value->idCuentaContableGrupos.' order by c.mes';
      $value->monto=$this->db->query($consulta)->result();
    }
   

foreach ($datos['gastosActivos'] as $key => $value) 
    {
      $consulta='select c.idCuentaContable,rc.cuentaContable from cuentascontablesgruporelacion c left join relcuentacontabledepartamento rc on rc.idCuentaContable=c.idCuentaContable where c.idCuentaContableGrupo='.$value->idCuentaContableGrupos;
      $value->hijos=$this->db->query($consulta)->result(); 
     $consulta='select * from cuentacontablegrupospresupuesto c where  c.anio='.$year.' and c.idCuentaContableGrupos='.$value->idCuentaContableGrupos.' order by c.mes';
      $value->monto=$this->db->query($consulta)->result();
    }
   
    return $datos;
}
//-------------------------------------------------------
function guardaCuentasContablesGrupoRelacion()
{
  $idCuentaContable=explode(',', $_GET['idCuentaContable']);
  if(isset($_GET['idCuentaContableGrupo']))
  {
     $datos=array();
     $delete='delete from cuentascontablesgruporelacion where idCuentaContableGrupo='.$_GET['idCuentaContableGrupo'];
     $this->db->query($delete);        
     foreach ($idCuentaContable as $key => $value) 
     {
       if($value!='')
       {
         $delete='delete from cuentascontablesgruporelacion where idCuentaContable='.$value;
         $this->db->query($delete);
         $insert['idCuentaContable']=$value;
         $insert['idCuentaContableGrupo']=$_GET['idCuentaContableGrupo'];
         $this->db->insert('cuentascontablesgruporelacion',$insert);
       }
      }
  }
  else
  {

         foreach ($idCuentaContable as $key => $value) 
     {
       if($value!='')
       {
         $delete='delete from cuentascontablesgruporelacion where idCuentaContable='.$value;
         $this->db->query($delete);

         $delete='delete from cuentacontablegrupos where idCuentaContable='.$value;
         //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($delete, TRUE));fclose($fp);
         $this->db->query($delete);

         $insert['idCuentaContable']=$value;
         $insert['tipoGrupo']=$_GET['tipoGrupo'];
         $this->db->insert('cuentacontablegrupos',$insert);
       }
      }
  }
  $grupos=$this->devolverCuentaContableGrupos();
    $datos['gastosOperacion']=$grupos['gastosOperacion'];
    $datos['gastosVariables']=$grupos['gastosVariables'];
    $datos['gastosFinancieros']=$grupos['gastosFinancieros'];
    $datos['gastosImpuestos']=$grupos['gastosImpuestos'];
    $datos['mes']=$grupos['mes'];
    $datos['anio']=$grupos['anio'];
   echo json_encode($datos);
}
//------------------------------------------------------
function eliminarCCReporte()
{
  $datos=array();
//  $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($_GET, TRUE));fclose($fp);

    if($_GET['idCuentaContableGrupo']>0)
    {
      $this->db->where('idCuentaContableGrupos',$_GET['idCuentaContableGrupo']);
      $this->db->delete('cuentacontablegrupos');
      $this->db->where('idCuentaContableGrupo',$_GET['idCuentaContableGrupo']);
      $this->db->delete('cuentascontablesgruporelacion');
    }
    else
    {
      if($_GET['idCuentaContable']>0)
      {
      $this->db->where('idCuentaContable',$_GET['idCuentaContable']);
      $this->db->delete('cuentacontablegrupos');
      $this->db->where('idCuentaContable',$_GET['idCuentaContable']);
      $this->db->delete('cuentascontablesgruporelacion');
      }
    }
    $grupos=$this->devolverCuentaContableGrupos();
    $datos['gastosOperacion']=$grupos['gastosOperacion'];
    $datos['gastosVariables']=$grupos['gastosVariables'];
    $datos['gastosFinancieros']=$grupos['gastosFinancieros']; 
    $datos['gastosImpuestos']=$grupos['gastosImpuestos'];    
        $datos['mes']=$grupos['mes'];     
    $datos['anio']=$grupos['anio'];  
   echo json_encode($datos);

}
//--------------------------------
function guardarPresupuestoGrupos()
{
  //
  $delete='delete from cuentacontablegrupospresupuesto where idCuentaContableGrupos='.$_GET['idCuentaContableGrupo'].' and anio='.$_GET['anio'];
  $respuesta['mensaje']='LOS DATOS SE GUARDARON CORRECTAMENTE';
  $this->db->query($delete);
  $val=explode(';', $_GET['val']);
  $insert['idCuentaContableGrupos']=$_GET['idCuentaContableGrupo'];
  $montoCad='';
  $monto=0;
  $insert['anio']=$_GET['anio'];
  $i=1;
  foreach ($val as $value) 
  {
    if($value!='')
    {
    $insert['mes']=$i;
    $insert['monto']=$value;
     //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($insert,TRUE));fclose($fp);   
    $this->db->insert('cuentacontablegrupospresupuesto',$insert);
    $i++;
     }
     $montoCad.=$value.',';
     $monto=$monto+(double)$value;
  }
  $respuesta['montoCad']=$montoCad;
  $respuesta['monto']=$monto;
  $respuesta['idCuentaContableGrupos']=$_GET['idCuentaContableGrupo'];
  echo json_encode($respuesta);
}
//--------------------------------



//-----------------------------------------------------------------------------------

function asignarPresupuestoContable()
{
$array['idAperturaContable']=$_POST['idAperturaContable'];
$respuesta=$this->contabilidadmodelo->aperturaContable($array);
if($respuesta->statusAbiertoAC==1)
{
 $departamento=$this->contabilidadmodelo->devolverDepartamentosPorApertura($_POST['idAperturaContable']);
 $cantDepartamentos=count($departamento);
 $_POST['montoContable']=str_replace('$','',$_POST['montoContable']);  
 $_POST['montoContable']=str_replace(',','',$_POST['montoContable']);  
 $monto=$_POST['montoContable']/$cantDepartamentos;
 $update['montoDAC']=$monto;
 $update['idAperturaContable']=$_POST['idAperturaContable'];
 $this->contabilidadmodelo->actualizarMontoPorDepartamento($update);
 $updateAC['idAperturaContable']=$_POST['idAperturaContable'];
 $updateAC['update']=1;
 $updateAC['inicialAC']=$_POST['montoContable'];
 $this->datos['pestania']='aperturaContable';
 $this->contabilidadmodelo->aperturaContable($updateAC);
 $updateIACMM['idAperturaContable']=$_POST['idAperturaContable'];
 $this->contabilidadmodelo->inicializarAperturaContableMontoMes($updateIACMM);
}

$this->index();
}
//----------------------------------------------------------------------------------

function asignarPresupuestoDepartamento()
{
$array['idAperturaContable']=$_POST['idAperturaContable'];
$respuesta=$this->contabilidadmodelo->aperturaContable($array);
if($respuesta->statusAbiertoAC==1)
{

$personaDepartamento=explode(',',$_POST['personaDepartamento']);
$departamentosActivos=$this->catalogos_model->obtenerCatAbtDpto(null);
$totalDA=count($departamentosActivos);
$bandActivos=0;
$suma=0;
/*foreach ($personaDepartamento as  $value) 
{
  if($value!='')
  {
    $monto=explode('-',$value);
    $suma=$suma+(int)$monto[1]; 
     foreach ($departamentosActivos as  $value) 
     {
       if($monto[0]==$value->idPersonaDepartamento){$bandActivos++;}
     }
  }
}*/

  foreach ($personaDepartamento as  $value) 
 {
   if($value!='')
   {
    $monto=explode('-',$value);
    //$suma=$suma+(int)$monto[1]; 
    $updateRDA['idPersonaDepartamento']=$monto[0];
    $updateRDA['idAperturaContable']=$_POST['idAperturaContable'];
    $updateRDA['montoDAC']=$monto[1];

    $this->contabilidadmodelo->actualizarRelDepartamentoApertura($updateRDA);
    $suma=(float)$suma+(float)$monto[1];
  }
}

   $updateAC['idAperturaContable']=$_POST['idAperturaContable'];
 $updateAC['update']=1;
 $updateAC['inicialAC']=$suma;
 $updateAC['update']=1 ;
 $this->contabilidadmodelo->aperturaContable($updateAC);


  $this->datos['mensaje']='La actualizacion fue correcta' ; 

/*if((int)$suma==(int)$respuesta->inicialAC && $bandActivos==$totalDA)
{
  foreach ($personaDepartamento as  $value) 
 {
   if($value!=''){
    $monto=explode('-',$value);
    $suma=$suma+(int)$monto[1]; 
    $updateRDA['idPersonaDepartamento']=$monto[0];
    $updateRDA['idAperturaContable']=$_POST['idAperturaContable'];
    $updateRDA['montoDAC']=$monto[1];
    $this->contabilidadmodelo->actualizarRelDepartamentoApertura($updateRDA);
  }
}
  $this->datos['mensaje']='La actualizacion fue correcta' ;   
}
else{$this->datos['mensaje']="La suma montos totales por departamento no son iguales al monto total" ;}*/
}
$this->datos['pestania']='aperturaContable';
$this->index();
}





}