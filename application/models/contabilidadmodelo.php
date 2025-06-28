<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ContabilidadModelo extends CI_Model {
	var $funcionLlamar;
	var $datos;
//-----------------------------------------------------------------
	function __construct(){
		parent::__construct();
     

	}
//-------------------------------------------------------
function verificaAperturaContable(){
	$consulta='select (count(idAperturaContable)) as total,anioAC,idAperturaContable from aperturacontable where statusAbiertoAC=1';
	return $this->db->query($consulta)->result();
}
//-------------------------------------------------------

function aperturaContable($array){

	if(isset($array['idAperturaContable'])){
     if($array['idAperturaContable']==-1){
     
      unset($array['idAperturaContable']);
      $this->db->insert('aperturacontable',$array);
      $last=$this->db->insert_id();
      return  $last;
     }
     else{
       if(isset($array['update'])){
         unset($array['update']);
         $this->db->where('idAperturaContable',$array['idAperturaContable']);
         $this->db->update('aperturacontable',$array);
       }
       else{
  
             /*DEVOLVER DE APERTURA CONTABLE CORRESPONDIENTE*/
             $consulta="select * from aperturacontable where idAperturaContable=".$array['idAperturaContable'];            
             $aperturaContable=$this->db->query($consulta)->result()[0];
              return $aperturaContable;
       }
     }
}
	else{
        /*DEVOLVER TODO DE APERTURA CONTABLE*/
        $consulta="select * from aperturacontable  order by idAperturaContable desc";
        $aperturaContable=$this->db->query($consulta)->result();

        foreach($aperturaContable as $key=>$value){
         $consulta='select * from reldepartamentoapertura rda left join personadepartamento pd on pd.idPersonaDepartamento=rda.idPersonaDepartamento where rda.idAperturaContable='.$value->idAperturaContable;
            $aperturaContable[$key]->departamentos=$this->db->query($consulta)->result();
            //$consulta="select * from aperturacontablemontomes where idAperturaContable=".$value->idAperturaContable;
            //$aperturaContable[$key]->aperturaMeses=$this->db->query($consulta)->result();
      }
      foreach ($aperturaContable as $value) {
        foreach ($value->departamentos as $key => $valueDepartamentos) {
          $consulta="select * from relcuentacontabledepartamento where idPersonaDepartamento=".$valueDepartamentos->idPersonaDepartamento.' and statusCC=1 and idAperturaContable='.$valueDepartamentos->idAperturaContable;

          $valueDepartamentos->cuentaContable=$this->db->query($consulta)->result();
        }
      }
     
        return $aperturaContable;
	}

}
//-------------------------------------------------------
function calcularTotalFacturasAnio($stringAnio){
	$consulta='select (sum(totalconiva)) as total from facturas where YEAR(fecha_factura)="'.$stringAnio.'"';
	return $this->db->query($consulta)->result();

}

//-------------------------------------------------------
function devolverDepartamentosPorApertura($idAperturaContable){
  $consulta='select * from reldepartamentoapertura where idAperturaContable='.$idAperturaContable;
  return $this->db->query($consulta)->result();
}
//-------------------------------------------------------

function actualizarMontoPorDepartamento($array){
  $this->db->where('idAperturaContable',$array['idAperturaContable']);
  $this->db->update('reldepartamentoapertura',$array);
}
//-------------------------------------------------------
function relDepartamentoApertura($array){

	if(isset($array['idRelDepartamentoApertura'])){
		if($array['idRelDepartamentoApertura']==-1){
	      unset($array['idRelDepartamentoApertura']);
	      $this->db->insert('reldepartamentoapertura',$array);

		}
	}
  else{
    if(isset($array['idPersonaDepartamento']) && isset($array['idAperturaContable'])){
      $consulta="select * from reldepartamentoapertura where idPersonaDepartamento=".$array['idPersonaDepartamento'].' and idAperturaContable='.$array['idAperturaContable'];
          
      $datos=$this->db->query($consulta)->result();

      return $datos;
    }
  }
}

//-------------------------------------------------------
function actualizarRelDepartamentoApertura($array){
 $this->db->where('idPersonaDepartamento',$array['idPersonaDepartamento']);
 $this->db->where('idAperturaContable',$array['idAperturaContable']);
 $this->db->update('reldepartamentoapertura',$array);
}
//-------------------------------------------------------
function relCuentaContableDepartamento($array){
  if(isset($array['idCuentaContable'])){
    if($array['idCuentaContable']==-1)
    {
       unset($array['idCuentaContable']);
       $array['idAperturaContable']=$this->verificaAperturaContable()[0]->idAperturaContable;
       $array['cuentaContable']=strtoupper($array['cuentaContable']);
       $this->db->insert('relcuentacontabledepartamento',$array);
       $last=$this->db->insert_id();
       if(!isset($array['idCuentaContableInicial']))
       {
       $updateCC='update relcuentacontabledepartamento set idCuentaContableInicial='.$last.' where idCuentaContable='.$last;
       $this->db->query($updateCC);
        }
       return  $last;
    }
    else{
     if(isset($array['update'])){
      unset($array['update']);
      
      $this->db->where('idCuentaContable',$array['idCuentaContable']);
      $this->db->update('relcuentacontabledepartamento',$array);
     }  
    }
  }
  else
  {
    $idAperturaContable=$this->verificaAperturaContable()[0]->idAperturaContable;
    
    $consulta="select rcc.*,pd.personaDepartamento,((rcc.fianzasPorcentaje+rcc.institucionalPorcentaje+rcc.coorporativoPorcentaje+rcc.gestionPorcentaje)) as sumPorcentaje from relcuentacontabledepartamento rcc left join personadepartamento pd on pd.idPersonaDepartamento=rcc.idPersonaDepartamento where rcc.statusCC=1 and pd.aperturaContableStatus=1 and rcc.idAperturaContable=".$idAperturaContable;
    return $this->db->query($consulta)->result();
  }
}
//-------------------------------------------------------
function relCuentaContableDepartamentoPermiso($array){
     $idPersona=$this->tank_auth->get_idPersona();
     $consulta='select * from persona where idPersona='.$idPersona;
     $datos=$this->db->query($consulta)->result()[0];
    
    $idAperturaContable=$this->verificaAperturaContable()[0]->idAperturaContable;
    /*$consulta='select rcc.*,pd.personaDepartamento from relcuentacontabledepartamento rcc left join personadepartamento pd on pd.idPersonaDepartamento=rcc.idPersonaDepartamento left join reldepartamentopersonacc rdpcc on rdpcc.idDepartamentoPersona=pd.idPersonaDepartamento where rcc.statusCC=1 and pd.aperturaContableStatus=1 and rcc.idAperturaContable='.$idAperturaContable.' and rdpcc.idPersona='.$idPersona;*/
$consulta='select rcc.*,pd.personaDepartamento from relcuentacontabledepartamentopersona rccdp
left join relcuentacontabledepartamento rcc on rcc.idCuentaContable=rccdp.idCuentaContable
left join personadepartamento pd on pd.idPersonaDepartamento=rcc.idPersonaDepartamento
where rcc.idAperturaContable='.$idAperturaContable.' and rccdp.idPersona='.$idPersona;
         

    $cuentasContables=$this->db->query($consulta)->result();
    foreach ($cuentasContables as $value) 
    {

        $consul='select montoMes from aperturacontablemontomes where idMes=MONTH(NOW()) and idAperturaContable='.$value->idAperturaContable.' and idPersonaDepartamento='.$value->idPersonaDepartamento;
            $montoMes['idAperturaContable']=$value->idAperturaContable;
      $montoMes['idPersonaDepartamento']=$value->idPersonaDepartamento;
      $montoMes['mes']=date('m');       
        //$presu=$this->devolverPresupuestoAutorizado($montoMes);
          $presu=$this->facturasQueAfectanPresupuesto($montoMes);
         
        $value->montoMes=$this->db->query($consul)->result_array()[0]['montoMes'];
        $value->autorizadoMes=$presu;
        
    }
  

    return $cuentasContables;
  
}
//-------------------------------------------------------
function crearMesesApertura($array){
  for($i=1;$i<13;$i++){
    // $insert['idAperturaContable']=$array['idAperturaContable'];
     $array['idMes']=$i;
     $array['montoMes']=0;
     $this->db->insert('aperturacontablemontomes',$array);

  }

}
//-------------------------------------------------------
function devolverMesesApertura($array){
  $this->db->where('idPersonaDepartamento',$array['idPersonaDepartamento']);
  $this->db->where('idAperturaContable',$array['idAperturaContable']);
  $this->db->order_by('idMes', 'ASC');

  $datos=$this->db->get('aperturacontablemontomes')->result();

  return $datos;
}
//-------------------------------------------------------
function aperturacontablemontomes($array){

      $salida=0;$seguridad=0;$datos="";
    do{
    if(isset($array['idAperturaContableMontoMes']) )
    {
     if($array['idAperturaContableMontoMes']==-1)
     {
      unset($array['idAperturaContableMontoMes']);
      unset($array['update']);
      $this->db->insert('aperturacontablemontomes',$array);
      $array['idAperturaContableMontoMes']=$this->db->insert_id();
     } 
     else
     {
      if(isset($array['update']))
      {
        unset($array['update']);
        if($array['idAperturaContableMontoMes']!=''){

          $this->db->where('idAperturaContableMontoMes',$array['idAperturaContableMontoMes']);
         $this->db->update('aperturacontablemontomes',$array);
      
           }else{$salida=1;}
            
      }
      else
      {
          $this->db->where('idAperturaContableMontoMes',$array['idAperturaContableMontoMes']);
          $datos=$this->db->get('aperturacontablemontomes')->result();
          $salida=1;
      }
     }
    }
    else
    { 
      //$where->db->where('Usuario',$this->tank_auth->get_usermail());
         $datos=$this->db->get('aperturacontablemontomes')->result();        
         $salida=1;
    }
    $seguridad++;
    if($seguridad>4){$salida=1;}

  }while($salida==0);
  return $datos;

}
//-------------------------------------------------------
function inicializarAperturaContableMontoMes($array){
  if(isset($array['idAperturaContable'])){
    $array['montoMes']=0;
    $this->db->where('idAperturaContable',$array['idAperturaContable']);
    $this->db->update('aperturacontablemontomes',$array);
  }
}
//-----------------------------------------------

function promobono($array)
{
  if($array['idPromoBono']==-1)
  {
    unset($array['idPromoBono']);
    $this->db->insert('promobono',$array);
  }
  else
  {
   if(isset($array['update']))
   {
    unset($array['update']);
    $this->db->where('idPromoBono',$array['idPromoBono']);
    $this->db->update('promobono',$array);
   } 
   else
   {
    if(isset($array['delete']))
    {
      $this->db->where('idPromoBono',$array['idPromoBono']);
      $this->db->delete('promobono');
    }
    else{$consulta='select * from promobono where idPromoBono='.$array['idPromoBono'];}
   }
  }
}
//--------------------------------------------------
function buscarPromoBonoPorAnio($anio,$tipoCaptura="",$usuario="")
{
  $respuesta="";
  $filtroTipoCaptura="";
  $filtroUsuario="";
  if($tipoCaptura!="")
  {
   if($tipoCaptura=='CCO'){$filtroTipoCaptura=" and tipo='CCO'";}
    else{$filtroTipoCaptura=" and tipo!='CCO' ";}
  }
  if($usuario!='')
  {
    if($usuario!='SISTEMAS@ASESORESCAPITAL.COM' and $usuario!='CONTABILIDAD@AGENTECAPITAL.COM' and $usuario!='DIRECeTORGENERAL@AGENTECAPITAL.COM' and $usuario!='GERENTEOPERATIVO@AGENTECAPITAL.COM')
    {
     $filtroUsuario=" and email='".$this->tank_auth->get_usermail()."' ";
    }

  }
  $consulta="select pb.*,m.mesMX from promobono pb left join meses m on m.idMes=pb.mes where anio='".$anio."' and activo=1 ".$filtroTipoCaptura.$filtroUsuario;
  
  $respuesta=$this->db->query($consulta)->result();  
  return $respuesta;
}
//-----------------------------------------------
function buscarPromoBonoAnioAndMes($array)
{ 
  $respuesta=array();
  $respuesta="";
  $consulta="select * from promobono  where anio='".$array['anio']."' and activo=1 and mes='".$array['mes']."' and tipo='".$array['tipo']."' and canal='".$array['canal']."'";
  $respuesta=$this->db->query($consulta)->result(); 
  return $respuesta;
}
//-----------------------------------------------
function estadoFinancieroMesAnio($array)
{
  $consulta="select * from estadofinanciero where mes=".$array['mes'].' and anio='.$array['anio'];
  return $this->db->query($consulta)->result();
}
//--------------------------------------------------
function borrarEstadoFinanciero($array)
{
  $consulta="delete from estadofinanciero where anio=".$array['anio']." and mes=".$array['mes'];
  $this->db->query($consulta);
}
//-------------------------------------------
function devolverTarjetas($array)
{
  $consulta='select * from formapago where esTarjeta=1';
  return $this->db->query($consulta)->result();
}
//-------------------------------------------
function tarjetas($array)
{ $respuesta=array();

  if(isset($array['idTarjetas']))
  {
    if($array['idTarjetas']==-1)
    {
      unset($array['idTarjetas']);
      $this->db->insert('tarjetas',$array);
    }
    else
    {
      $this->db->where('idTarjetas',$array['idTarjetas']);
      $this->db->update('tarjetas',$array);
    }
  }
  else
  {
    $consulta='select t.*,p.nombres,p.apellidoPaterno,p.apellidoMaterno,fp.formaPago from tarjetas t left join persona p on p.idPersona=t.idPersona left join formapago fp on fp.idFormaPago=t.idFormaPago where t.estaDeBaja=0 and t.esTarjetaEspecial=0';
    $respuesta=$this->db->query($consulta)->result();
  }
  return $respuesta;
}
//------------------------------------------------
function devolverTarjetasPersonales()
{
  $consulta='select t.*,p.nombres,p.apellidoPaterno,p.apellidoMaterno,fp.formaPago from tarjetas t left join persona p on p.idPersona=t.idPersona  left join formapago fp on fp.idFormaPago=t.idFormaPago  where t.estaDeBaja=0 and t.idPersona='.$this->tank_auth->get_idPersona();
  return $this->db->query($consulta)->result();
}
//---------------------------------------------
function notasparacompras($array)
{
  if(isset($array['idNotasCompra']))
  {
    if($array['idNotasCompra']==-1)
    {
      unset($array['idNotasCompra']);
      $array['idPersona']=$this->tank_auth->get_idPersona();
      $this->db->insert('notasparacompras',$array);
    }
    else
    {
      if(isset($array['delete']))
      {
        if($array['delete']==1)
        {
          $delete='delete from notasparacompras where idNotasCompra='.$array['idNotasCompra'];
          $this->db->query($delete);
        }
      }
      else
      {
        $this->db->where('idNotasCompra',$array['idNotasCompra']);
        $this->db->update('notasparacompras',$array);
      }
    }
  }
  else
  {
    if(isset($array['idPersona']))
    {
      $consulta='select f.formaPago,t.numeroTarjeta,n.*,(DATE_FORMAT(n.fechaCompra, "%d/%m/%Y")) as soloFecha  from notasparacompras n left join tarjetas t on t.idTarjetas=n.idTarjetas left join formapago f on f.idFormaPago=t.idFormaPago where n.estaFacturado=0 and n.idPersona='.$array['idPersona'].' order by soloFecha desc';
      return $this->db->query($consulta)->result();
    }
  }
}
//----------------------------------------------
function buscarPersonasConNotas($array)
{
   $permiso='select (count(idPersona)) as cantidad from notasparacompraspermiso where idPersona='.$this->tank_auth->get_idPersona();
   $respuesta=$this->db->query($permiso)->result()[0]->cantidad;
 
   if($respuesta==0){ $consulta='select DISTINCT(n.idPersona),p.apellidoPaterno,p.apellidoMaterno,p.nombres,p.idPersona from notasparacompras n left join persona p on p.idPersona=n.idPersona where n.estaFacturado=0 and n.idPersona='.$this->tank_auth->get_idPersona();}
   else{
  $consulta='select DISTINCT(n.idPersona),p.apellidoPaterno,p.apellidoMaterno,p.nombres,p.idPersona from notasparacompras n left join persona p on p.idPersona=n.idPersona where n.estaFacturado=0';}
  return $this->db->query($consulta)->result();
}
//-----------------------------------------------
function relcuentacontabledepartamentopersona($array)
{
  if(isset($array['insert']))
  {
    $this->db->where('idPersona',$array['idPersona']);
    $this->db->delete('relcuentacontabledepartamentopersona');
    $cuentas=explode(',', $array['idCuentaContable']);
    foreach ($cuentas as $value) 
    { 
     if($value!='')
     {
      $insert['idPersona']=$array['idPersona'];
      $insert['idCuentaContable']=$value;
      $this->db->insert('relcuentacontabledepartamentopersona',$insert);
     }
  }

 }
 else{
  if(isset($array['idPersona'])){
    $this->db->where('idPersona',$array['idPersona']);
    return $this->db->get('relcuentacontabledepartamentopersona')->result_array();
  }
 }
 }
//-----------------------------------------
function devolverAperturaContableMontoMes($array)
{
  $respuesta=array();
  if(isset($array['idMes']))
  {
  $consulta='select * from aperturacontablemontomes where idAperturaContable='.$array['idAperturaContable'].' and idPersonaDepartamento='.$array['idPersonaDepartamento'].' and idMes='.$array['idMes'];
  
  }
  else
  {
$consulta='select (sum(montoMes)) as montoMes from aperturacontablemontomes where idAperturaContable='.$array['idAperturaContable'].' and idPersonaDepartamento='.$array['idPersonaDepartamento'];
  
  }

  $respuesta=$this->db->query($consulta)->result_array();
  
  return $respuesta;
}
//-----------------------------------------
 function devolverPresupuestoAutorizado($array){
  /*
      AL APLICAR ALGUN TIPO DE FILTRO TAMBIEN SE DEBEN CONTEMPLAR LAS FUNCIONES 
     
     -----devolverPresupuestoAutorizadoPorCuenta($array)

   */
  $filtro='';
  $filtro=$this->cuentasContablesQueAfectanElPresupuesto();
  if(isset($array['mes']))
  {
  $consulta='Select (if(sum(f.totalfactura)  is null,0,sum(f.totalfactura)))as suma FROM facturas f WHERE (MONTH(f.fecha_factura) BETWEEN 1 and 12) and f.posteriorapago!=5 and((f.ccc is null and f.cco is null and f.inversion is null) or (f.ccc =0 and f.cco =0 and f.inversion =0)) and f.idPersonaDepartamento='.$array['idPersonaDepartamento'].'  and f.autorizadireccion=1 and f.idAperturaContable='.$array['idAperturaContable'].' and MONTH(f.fecha_factura)='.$array['mes'].' and f.idCuentaContableInicial in ('.$filtro.')';
    }
    else
    {
  $consulta='Select (sum(f.totalfactura)) as suma FROM facturas f WHERE (MONTH(f.fecha_factura) BETWEEN 1 and 12) and and f.posteriorapago!=5 and((f.ccc is null and f.cco is null and f.inversion is null) or (f.ccc =0 and f.cco =0 and f.inversion =0)) and  f.idPersonaDepartamento='.$array['idPersonaDepartamento'].'  and f.autorizadireccion=1 and f.idAperturaContable='.$array['idAperturaContable'].' and f.idCuentaContableInicial in ('.$filtro.')';

    }
    
   $datos=$this->db->query($consulta)->result()[0]->suma;
  
   if($datos!=''){return $datos;}
   else{return 0;}

 }

//-----------------------------------------
 function devolverPresupuestoPagado($array){
  /*
      AL APLICAR ALGUN TIPO DE FILTRO TAMBIEN SE DEBEN CONTEMPLAR LAS FUNCIONES 
     
     -----devolverPresupuestoPagadoPorCuenta($array)
     
   */
  if(isset($array['mes']))
  {
  $consulta='Select (if(sum(f.totalfactura)  is null,0,sum(f.totalfactura)))as suma FROM facturas f WHERE (MONTH(f.fecha_factura) BETWEEN 1 and 12) and f.posteriorapago!=5 and((f.ccc is null and f.cco is null and f.inversion is null) or (f.ccc =0 and f.cco =0 and f.inversion =0)) and f.idPersonaDepartamento='.$array['idPersonaDepartamento'].'  and f.pagado=1 and f.idAperturaContable='.$array['idAperturaContable'].' and MONTH(f.fecha_factura)='.$array['mes'];
  }
    else
    {
  $consulta='Select (sum(f.totalfactura)) as suma FROM facturas f WHERE (MONTH(f.fecha_factura) BETWEEN 1 and 12) and and f.posteriorapago!=5 and((f.ccc is null and f.cco is null and f.inversion is null) or (f.ccc =0 and f.cco =0 and f.inversion =0)) and  f.idPersonaDepartamento='.$array['idPersonaDepartamento'].'  and f.pagado=1 and f.idAperturaContable='.$array['idAperturaContable'];

    }
    
   $datos=$this->db->query($consulta)->result()[0]->suma;
  
   if($datos!=''){return $datos;}
   else{return 0;}

 }

//-----------------------------------------
 function devolverGastosEspecialesPagados($array)
 {
  /*
    HAY TRES GASTOS ESPECIALES LOS cco,ccc E inversion(ESTA CORRESPONDE A GASTOS INSTITUCIONALES)
    DEBE RECIBOR UNA EL ARRAY

   */
  if(isset($array['mes']))
  {
  $consulta='Select (if(sum(f.totalfactura)  is null,0,sum(f.totalfactura)))as suma FROM facturas f WHERE (MONTH(f.fecha_factura) BETWEEN 1 and 12) and f.posteriorapago!=5 and(f.'.$array['tipoGastoEspecial'].' is not null and f.'.$array['tipoGastoEspecial'].'!=0)  and f.idPersonaDepartamento='.$array['idPersonaDepartamento'].'  and f.pagado=1 and f.idAperturaContable='.$array['idAperturaContable'].' and MONTH(f.fecha_factura)='.$array['mes'];
  }
    else
    {
  $consulta='Select (sum(f.totalfactura)) as suma FROM facturas f WHERE (MONTH(f.fecha_factura) BETWEEN 1 and 12) and and f.posteriorapago!=5 and (f.'.$array['tipoGastoEspecial'].' is not null and f.'.$array['tipoGastoEspecial'].'!=0)
   and  f.idPersonaDepartamento='.$array['idPersonaDepartamento'].'  and f.pagado=1 and f.idAperturaContable='.$array['idAperturaContable'];

    }
   
   $datos=$this->db->query($consulta)->result()[0]->suma;
  
   if($datos!=''){return $datos;}
   else{return 0;}

 }

//-----------------------------------------
function facturasQueAfectanPresupuesto($montoMes)
{

   
   $filtro='';
   $filtro=$this->cuentasContablesQueAfectanElPresupuesto();
  $consulta='Select (if(sum(f.totalfactura)  is null,0,sum(f.totalfactura)))as suma FROM facturas f WHERE (MONTH(f.fecha_factura) BETWEEN 1 and 12) and f.posteriorapago!=5 and((f.ccc is null and f.cco is null and f.inversion is null) or (f.ccc =0 and f.cco =0 and f.inversion =0 and f.estrategia=0)) and f.idPersonaDepartamento='.$montoMes['idPersonaDepartamento'].'  and f.autorizadireccion=1 and f.idAperturaContable='.$montoMes['idAperturaContable'].' and MONTH(f.fecha_factura)='.$montoMes['mes'].' and f.idCuentaContableInicial in ('.$filtro.')';
//$fp = fopen('resultadoJason.txt','a');fwrite($fp,print_r($filtro,TRUE));fclose($fp);
        $datos=$this->db->query($consulta)->result()[0]->suma;
        return $datos;
}

//-----------------------------------------
function catalogFormaPago($array='')
{
  $consulta="select * from catalog_formapago";
  return $this->db->query($consulta)->result();
}
//-----------------------------------------
 function devolverPresupuestoPagadoPorCuenta($array){
  if(isset($array['mes']))
  {
   $filtro='';
    $filtro=$this->cuentasContablesQueAfectanElPresupuesto();
  $consulta='Select 
  (if(sum(f.montofianzas)  is null,0,sum(f.montofianzas)))as sumaFianzas,
(if(sum(f.montoinstitucional)  is null,0,sum(f.montoinstitucional)))as sumaInstitucional,
(if(sum(f.corporativo)  is null,0,sum(f.corporativo)))as sumaCorporativo
 FROM facturas f WHERE (MONTH(f.fecha_factura) BETWEEN 1 and 12) and f.posteriorapago!=5 and((f.ccc is null and f.cco is null and f.inversion is null) or (f.ccc =0 and f.cco =0 and f.inversion =0)) and f.idPersonaDepartamento in(1,2,4,5)  and f.pagado=1 and f.idAperturaContable='.$array['idAperturaContable'].' and MONTH(f.fecha_factura)='.$array['mes'].' and f.idCuentaContableInicial in ('.$filtro.')';;
  }
    else
    {
  //$consulta='Select (sum(f.totalfactura)) as suma FROM facturas f WHERE (MONTH(f.fecha_factura) BETWEEN 1 and 12) and and f.posteriorapago!=5 and((f.ccc is null and f.cco is null and f.inversion is null) or (f.ccc =0 and f.cco =0 and f.inversion =0)) and  f.idPersonaDepartamento='.$array['idPersonaDepartamento'].'  and f.pagado=1 and f.idAperturaContable='.$array['idAperturaContable'];

    }
    
   $datos=$this->db->query($consulta)->result()[0];
  
   if($datos!=''){return $datos;}
   else{return 0;}

 }

//-----------------------------------------
function devolverPresupuestoAutorizadoPorCuenta($array){
  if(isset($array['mes']))
  {
$consulta='Select 
  (if(sum(f.montofianzas)  is null,0,sum(f.montofianzas)))as sumaFianzas,
(if(sum(f.montoinstitucional)  is null,0,sum(f.montoinstitucional)))as sumaInstitucional,
(if(sum(f.corporativo)  is null,0,sum(f.corporativo)))as sumaCorporativo
 FROM facturas f WHERE (MONTH(f.fecha_factura) BETWEEN 1 and 12) and f.posteriorapago!=5 and((f.ccc is null and f.cco is null and f.inversion is null) or (f.ccc =0 and f.cco =0 and f.inversion =0)) and f.idPersonaDepartamento in(1,2,4,5)  and f.autorizadireccion=1 and f.idAperturaContable='.$array['idAperturaContable'].' and MONTH(f.fecha_factura)='.$array['mes'];
  }
    else
    {
  //$consulta='Select (sum(f.totalfactura)) as suma FROM facturas f WHERE (MONTH(f.fecha_factura) BETWEEN 1 and 12) and and f.posteriorapago!=5 and((f.ccc is null and f.cco is null and f.inversion is null) or (f.ccc =0 and f.cco =0 and f.inversion =0)) and  f.idPersonaDepartamento='.$array['idPersonaDepartamento'].'  and f.autorizadireccion=1 and f.idAperturaContable='.$array['idAperturaContable'];

    }
    
   $datos=$this->db->query($consulta)->result()[0];
  
   if($datos!=''){return $datos;}
   else{return 0;}

 }

//-----------------------------------------
function inversionBajaAlta($array)
{

  /*
    DEVUELVE LA SUMA DE BAJA Y LATA DE INVERSION DEPENDIENDO DEL ID Y DE LA FECHA QUE SE RECIBE   
   -2 ES BAJA DE INVERSION(DE ANTES SE MANEJABA EL 52)
   -1 ES BAJA DE INVERSION(DE ANTES SE MANEJABA EL 51)
   */
  $sum=0;
  if(isset($array['idPromotoria']))
  {

      if(isset($array['anio']) && isset($array['mes']) && isset($array['dia']))
      {
             $sum=$this->db->query('select (if(sum(total) is null,0,sum(total))) as sum  from cheques where idPromotoria='.$array['idPromotoria'].' and month(FECHA)="'.$array['mes'].'" and year(FECHA)='.$array['anio'].' and day(FECHA)<='.$array['dia'])->result()[0]->sum;
      }
      else
      {
             if(isset($array['fecha']) && isset($array['anio']))
            {
              $sum=$this->db->query('select (if(sum(total) is null,0,sum(total))) as sum  from cheques where idPromotoria='.$array['idPromotoria'].' and FECHA<="'.$array['fecha'].'" and year(FECHA)='.$array['anio'])->result()[0]->sum;
              
            }
            else
            {
              if(isset($array['anio']) and isset($array['mes']))
              {

                   $sum=$this->db->query('select (if(sum(total) is null,0,sum(total))) as sum  from cheques where idPromotoria='.$array['idPromotoria'].' and month(FECHA)="'.$array['mes'].'" and year(FECHA)='.$array['anio'])->result()[0]->sum;;
              }
              else
              {
               if(isset($array['fecha']))
               {
                 $sum=$this->db->query('select (if(sum(total) is null,0,sum(total))) as sum  from cheques where idPromotoria='.$array['idPromotoria'].' and FECHA="'.$array['fecha'].'"')->result()[0]->sum;
               }
               else
               {
                if(isset($array['anio']))
                {
                  $sum=$this->db->query('select (if(sum(total) is null,0,sum(total))) as sum  from cheques where idPromotoria='.$array['idPromotoria'].' and year(FECHA)="'.$array['anio'].'"')->result()[0]->sum;
                }
               }
              }
            }
      }
  }
  return $sum;
}
//-----------------------------------------
function gastosTipoNomina($array='')
{
  $mes=date("m");
  $anio=date("Y");
  $suma='*';
  $datos=array();
  if(isset($array['mes'])){$mes=$array['mes'];}
  if(isset($array['anio'])){$anio=$array['anio'];}
  if(isset($array['suma'])){$suma='(if(sum(f.totalfactura) is null,0,sum(f.totalfactura))) as totalconiva';}
  $select='select '.$suma.' from facturas f where f.idCuentaContableInicial in (1086) and year(f.fecha_pago)='.$anio.' and month(f.fecha_pago)='.$mes;
  $datos=$this->db->query($select)->result();  
  return $datos;
}
//-----------------------------------------
function gastosTipoNominaPorCanal($array='')
{
     $mes=date("m");
  $anio=date("Y");
  $suma='*';
  $datos=array();
  if(isset($array['mes'])){$mes=$array['mes'];}
  if(isset($array['anio'])){$anio=$array['anio'];}
  $select='select (if(sum(montoFianzas) is null,0,sum(montoFianzas))) as montoFianzas from facturas f where f.idCuentaContableInicial in (1086) and year(f.fecha_pago)='.$anio.' and month(f.fecha_pago)='.$mes;
  $datos['montoFianzas']=$this->db->query($select)->result()[0]->montoFianzas;  
  $select='select (if(sum(montoinstitucional) is null,0,sum(montoinstitucional))) as montoinstitucional from facturas f where f.idCuentaContableInicial in (1086) and year(f.fecha_pago)='.$anio.' and month(f.fecha_pago)='.$mes;
  $datos['montoInstitucional']=$this->db->query($select)->result()[0]->montoinstitucional;  
    $select='select (if(sum(corporativo) is null,0,sum(corporativo))) as corporativo from facturas f where f.idCuentaContableInicial in (1086) and year(f.fecha_pago)='.$anio.' and month(f.fecha_pago)='.$mes;
  $datos['montoCorporativo']=$this->db->query($select)->result()[0]->corporativo;  


  return $datos;

}
//----------------------------------------
function cuentasContablesQueAfectanElPresupuesto()
{
  $cc=$this->db->query('select * from cuentascontablesafectapresupuesto')->result();
   $filtro='';
   foreach ($cc as $key => $value) {$filtro.=$value->idCuentaContableInicial.',';}
   $filtro = substr($filtro, 0, -1);
   return $filtro;
}
//----------------------------------------
} 


