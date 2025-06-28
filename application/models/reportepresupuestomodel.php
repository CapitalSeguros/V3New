<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ReportePresupuestoModel extends CI_Model {
	var $funcionLlamar;
	var $datos;
//-----------------------------------------------------------------
	function __construct(){
		parent::__construct();     

	}

public function DevuelveGasto($valor,$iden)
 {
   $valor2 = $valor -1;
   if($iden==1)
   { 
   $eneroi = $valor."-01-01";
   $enerof = $valor."-01-31";
   }
   if($iden==2)
   { 
   $eneroi = $valor."-02-01";
   $enerof = $valor."-02-29";
   }
   if($iden==3)
   { 
   $eneroi = $valor."-03-01";
   $enerof = $valor."-03-31";
   }
   if($iden==4)
   { 
   $eneroi = $valor."-04-01";
   $enerof = $valor."-04-30";
   }
   if($iden==5)
   { 
   $eneroi = $valor."-05-01";
   $enerof = $valor."-05-31";
   }
   if($iden==6)
   { 
   $eneroi = $valor."-06-01";
   $enerof = $valor."-06-30";
   }
   if($iden==7)
   { 
   $eneroi = $valor."-07-01";
   $enerof = $valor."-07-31";
   }
   if($iden==8)
   { 
   $eneroi = $valor."-08-01";
   $enerof = $valor."-08-31";
   }
   if($iden==9)
   { 
   $eneroi = $valor."-09-01";
   $enerof = $valor."-09-30";
   }
   if($iden==10)
   { 
   $eneroi = $valor."-10-01";
   $enerof = $valor."-10-31";
   }
   if($iden==11)
   { 
   $eneroi = $valor."-11-01";
   $enerof = $valor."-11-30";
   }
   if($iden==12)
   { 
   $eneroi = $valor."-12-01";
   $enerof = $valor."-12-31";
   } 
      $consulta="select sum(fac.totalfactura) as gasto from facturas fac
where fac.fecha_pago between ".$eneroi."' and '".$enerof."'
";
      
    $datos=$this->db->query($consulta)->result();
    return $datos;
 }


 public function DevuelveDeposito($valor)
 {
   $eneroi = $valor."-01-01";
   $enerof = $valor."-01-31";
   $febreroi = $valor."-02-01";
   $febrerof = $valor."-02-29";
   $marzoi = $valor."-03-01";
   $marzof = $valor."-03-31";
   $abrili = $valor."-04-01";
   $abrilf = $valor."-04-30";
   $mayoi = $valor."-05-01";
   $mayof = $valor."-05-31";
   $junioi = $valor."-06-01";
   $juniof = $valor."-06-30";
   $julioi = $valor."-07-01";
   $juliof = $valor."-07-31";
   $agostoi = $valor."-08-01";
   $agostof = $valor."-08-31";
   $septiembrei = $valor."-09-01";
   $septiembref = $valor."-09-30";
   $octubrei = $valor."-10-01";
   $octubref = $valor."-10-31";
   $noviembrei = $valor."-11-01";
   $noviembref = $valor."-11-30";
   $diciembrei = $valor."-12-01";
   $diciembref = $valor."-12-31";
    
      $consulta="select 'Enero' as mes,format(sum(fac.totalfactura),2) as gasto,
      format(coalesce((select sum(ch.total)  from cheques ch where ch.tipo ='DEPOSITO' and ch.concepto not like '%inversion%' and ch.FECHA between '".$eneroi."' and '".$enerof."'),0.00),2) as deposito
from facturas fac
where fac.fecha_pago between '".$eneroi."' and '".$enerof."'
union
select 'Febrero' as mes,format(sum(fac.totalfactura),2) as gasto,
format(coalesce((select sum(ch.total)  from cheques ch where ch.tipo ='DEPOSITO' and ch.concepto not like '%inversion%' and 
ch.FECHA between '".$febreroi."' and '".$febrerof."'),0.00),2) as deposito
from facturas fac
where fac.fecha_pago between '".$febreroi."' and '".$febrerof."'
union
select 'Marzo' as mes,format(sum(fac.totalfactura),2) as gasto,
format(coalesce((select sum(ch.total)  from cheques ch where ch.tipo ='DEPOSITO' and ch.concepto not like '%inversion%' and ch.FECHA between '".$marzoi."' and '".$marzof."'),0.00),2) as deposito
from facturas fac
where fac.fecha_pago between '".$marzoi."' and '".$marzof."'
union
select 'Abril' as mes,format(sum(fac.totalfactura),2) as gasto,
format(coalesce((select sum(ch.total)  from cheques ch where ch.tipo ='DEPOSITO' and ch.concepto not like '%inversion%' and ch.FECHA between '".$abrili."' and '".$abrilf."'),0.00),2) as deposito
from facturas fac
where fac.fecha_pago between '".$abrili."' and '".$abrilf."'
union
select 'Mayo' as mes,format(sum(fac.totalfactura),2) as gasto,
format(coalesce((select sum(ch.total)  from cheques ch where ch.tipo ='DEPOSITO' and ch.concepto not like '%inversion%' and ch.FECHA between '".$mayoi."' and '".$mayof."'),0.00),2) as deposito
from facturas fac
where fac.fecha_pago between '".$mayoi."' and '".$mayof."'
union
select 'Junio' as mes,format(sum(fac.totalfactura),2) as gasto,
format(coalesce((select sum(ch.total)  from cheques ch where ch.tipo ='DEPOSITO' and ch.concepto not like '%inversion%' and ch.FECHA between '".$junioi."' and '".$juniof."'),0.00),2) as deposito
from facturas fac
where fac.fecha_pago between '".$junioi."' and '".$juniof."'
union
select 'Julio' as mes,format(sum(fac.totalfactura),2) as gasto,
format(coalesce((select sum(ch.total)  from cheques ch where ch.tipo ='DEPOSITO' and ch.concepto not like '%inversion%' and ch.FECHA between '".$julioi."' and '".$juliof."'),0.00),2) as deposito
from facturas fac
where fac.fecha_pago between '".$julioi."' and '".$juliof."'
union
select 'Agosto' as mes,format(sum(fac.totalfactura),2) as gasto,
format(coalesce((select sum(ch.total)  from cheques ch where ch.tipo ='DEPOSITO' and ch.concepto not like '%inversion%' and ch.FECHA between '".$agostoi."' and '".$agostof."'),0.00),2) as deposito
from facturas fac
where fac.fecha_pago between '".$agostoi."' and '".$agostof."'
union
select 'Septiembre' as mes,format(sum(fac.totalfactura),2) as gasto,
format(coalesce((select sum(ch.total)  from cheques ch where ch.tipo ='DEPOSITO' and ch.concepto not like '%inversion%' and ch.FECHA between '".$septiembrei."' and '".$septiembref."'),0.00),2) as deposito
from facturas fac
where fac.fecha_pago between '".$septiembrei."' and '".$septiembref."'
union
select 'Octubre' as mes,format(sum(fac.totalfactura),2) as gasto,
format(coalesce((select sum(ch.total)  from cheques ch where ch.tipo ='DEPOSITO' and ch.concepto not like '%inversion%' and ch.FECHA between '".$octubrei."' and '".$octubref."'),0.00),2) as deposito
from facturas fac
where fac.fecha_pago between '".$octubrei."' and '".$octubref."'
union
select 'Noviembre' as mes,format(sum(fac.totalfactura),2) as gasto,
format(coalesce((select sum(ch.total)  from cheques ch where ch.tipo ='DEPOSITO' and ch.concepto not like '%inversion%' and ch.FECHA between '".$noviembrei."' and '".$noviembref."'),0.00),2) as deposito
from facturas fac
where fac.fecha_pago between '".$noviembrei."' and '".$noviembref."'
union
select 'Diciembre' as mes,format(sum(fac.totalfactura),2) as gasto,format(
coalesce((select sum(ch.total)  from cheques ch where ch.tipo ='DEPOSITO' and ch.concepto not like '%inversion%' and ch.FECHA between '".$diciembrei."' and '".$diciembref."'),0.00),2) as deposito
from facturas fac
where fac.fecha_pago between '".$diciembrei."' and '".$diciembref."'";
//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($consulta, TRUE));fclose($fp); 
 $datos=$this->db->query($consulta)->result();
    return $datos;
 }
 public function DevuelveGstosLineal($valor)
 {
   $eneroi = $valor."-01-01";
   $enerof = $valor."-12-31";
   
    $consulta="select '1' as ano,coalesce(sum(fac.totalfactura),0.0) as total  from facturas fac
 where fac.fecha_pago is not null and year(fac.fecha_pago)= '".$valor."' and month(fac.fecha_pago)= 1
 union
 select '2' as ano,coalesce(sum(fac.totalfactura),0.0) as total  from facturas fac
 where fac.fecha_pago is not null and year(fac.fecha_pago)= '".$valor."' and month(fac.fecha_pago)= 2
 union
 select '3' as ano,coalesce(sum(fac.totalfactura),0.0) as total  from facturas fac
 where fac.fecha_pago is not null and year(fac.fecha_pago)= '".$valor."' and month(fac.fecha_pago)= 3
 union
 select '4' as ano,coalesce(sum(fac.totalfactura),0.0) as total  from facturas fac
 where fac.fecha_pago is not null and year(fac.fecha_pago)= '".$valor."' and month(fac.fecha_pago)= 4
 union
 select '5' as ano,coalesce(sum(fac.totalfactura),0.0) as total  from facturas fac
 where fac.fecha_pago is not null and year(fac.fecha_pago)= '".$valor."' and month(fac.fecha_pago)= 5
 union
 select '6' as ano,coalesce(sum(fac.totalfactura),0.0) as total  from facturas fac
 where fac.fecha_pago is not null and year(fac.fecha_pago)= '".$valor."' and month(fac.fecha_pago)= 6
 union
 select '7' as ano,coalesce(sum(fac.totalfactura),0.0) as total  from facturas fac
 where fac.fecha_pago is not null and year(fac.fecha_pago)= '".$valor."' and month(fac.fecha_pago)= 7
 union
 select '8' as ano,coalesce(sum(fac.totalfactura),0.0) as total  from facturas fac
 where fac.fecha_pago is not null and year(fac.fecha_pago)= '".$valor."' and month(fac.fecha_pago)= 8
 union
 select '9' as ano,coalesce(sum(fac.totalfactura),0.0) as total  from facturas fac
 where fac.fecha_pago is not null and year(fac.fecha_pago)= '".$valor."' and month(fac.fecha_pago)= 9
 union
 select '10' as ano,coalesce(sum(fac.totalfactura),0.0) as total  from facturas fac
 where fac.fecha_pago is not null and year(fac.fecha_pago)= '".$valor."' and month(fac.fecha_pago)= 10
 union
 select '11' as ano,coalesce(sum(fac.totalfactura),0.0) as total  from facturas fac
 where fac.fecha_pago is not null and year(fac.fecha_pago)= '".$valor."' and month(fac.fecha_pago)= 11
 union
 select '12' as ano,coalesce(sum(fac.totalfactura),0.0) as total  from facturas fac
 where fac.fecha_pago is not null and year(fac.fecha_pago)= '".$valor."' and month(fac.fecha_pago)= 12";
      
//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($consulta, TRUE));fclose($fp); 
 $datos=$this->db->query($consulta)->result();
    return $datos;
 }
 public function DevuelveDepoLineal($valor)
 {
   $eneroi = $valor."-01-01";
   $enerof = $valor."-12-31";
   
    $consulta="select '1' as ano,coalesce(sum(ch.total),0.0) as total  from cheques ch
      where ch.FECHA  is not null and year(ch.FECHA)= '".$valor."' and month(ch.fecha)= 1
 union
 select '2' as ano,coalesce(sum(ch.total),0.0) as total  from cheques ch
      where ch.FECHA  is not null and year(ch.FECHA)= '".$valor."' and month(ch.fecha)= 2
 union
 select '3' as ano,coalesce(sum(ch.total),0.0) as total  from cheques ch
      where ch.FECHA  is not null and year(ch.FECHA)= '".$valor."' and month(ch.fecha)= 3
 union
select '4' as ano,coalesce(sum(ch.total),0.0) as total  from cheques ch
      where ch.FECHA  is not null and year(ch.FECHA)= '".$valor."' and month(ch.fecha)= 4
 union
 select '5' as ano,coalesce(sum(ch.total),0.0) as total  from cheques ch
      where ch.FECHA  is not null and year(ch.FECHA)= '".$valor."' and month(ch.fecha)= 5
 union
 select '6' as ano,coalesce(sum(ch.total),0.0) as total  from cheques ch
      where ch.FECHA  is not null and year(ch.FECHA)= '".$valor."' and month(ch.fecha)= 6
 union
 select '7' as ano,coalesce(sum(ch.total),0.0) as total  from cheques ch
      where ch.FECHA  is not null and year(ch.FECHA)= '".$valor."' and month(ch.fecha)= 7
 union
 select '8' as ano,coalesce(sum(ch.total),0.0) as total  from cheques ch
      where ch.FECHA  is not null and year(ch.FECHA)= '".$valor."' and month(ch.fecha)= 8
 union
 select '9' as ano,coalesce(sum(ch.total),0.0) as total  from cheques ch
      where ch.FECHA  is not null and year(ch.FECHA)= '".$valor."' and month(ch.fecha)= 9
 union
 select '10' as ano,coalesce(sum(ch.total),0.0) as total  from cheques ch
      where ch.FECHA  is not null and year(ch.FECHA)= '".$valor."' and month(ch.fecha)= 10
 union
 select '11' as ano,coalesce(sum(ch.total),0.0) as total  from cheques ch
      where ch.FECHA  is not null and year(ch.FECHA)= '".$valor."' and month(ch.fecha)= 11
 union
 select '12' as ano,coalesce(sum(ch.total),0.0) as total  from cheques ch
      where ch.FECHA  is not null and year(ch.FECHA)= '".$valor."' and month(ch.fecha)= 12";
      
//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($consulta, TRUE));fclose($fp); 
 $datos=$this->db->query($consulta)->result();
    return $datos;
 }
public function DevuelveCanales($valor)
 {
   $eneroi = $valor."-01-01";
   $enerof = $valor."-12-31";
   
    
      $consulta="select sum(montofianzas) as Fianzas,sum(montoinstitucional) as Institucional,sum(corporativo) as Coorporativo from facturas fac
where fac.fecha_pago between '".$eneroi."' and '".$enerof."'";
//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($consulta, TRUE));fclose($fp); 
 $datos=$this->db->query($consulta)->result();
    return $datos;
 }
 /************************************* */
public function DevuelveRepDepositos($valor)
 {
   $eneroi = $valor."-01-01";
   $enerof = $valor."-12-31";
   
    
      $consulta="select REPLACE(promotoria,',', '') as promo,replace(format(sum(total),2),',','') as total from cheques ch where 
ch.FECHA  between '".$eneroi."' and '".$enerof."' group by promotoria";
//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($consulta, TRUE));fclose($fp); 
 $datos=$this->db->query($consulta)->result();
    return $datos;
 }
 /********************************************** */
 public function DevuelveRepDepositosxmes($valor,$mes,$tipo)
 {
   //$eneroi = $valor."-01-01";
   $eneroi = $valor."-".$mes."-01";
   //$enerof = $valor."-12-31";
   $enerof = $valor."-".$mes."-31";
    $tip = $tipo; 
      $consulta="select REPLACE(promotoria,',', '') as promo,replace(format(sum(total),2),',','') as total from cheques ch where 
ch.FECHA  between '".$eneroi."' and '".$enerof."' and ch.seguro = '".$tip."' group by promotoria";
//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($consulta, TRUE));fclose($fp); 
 $datos=$this->db->query($consulta)->result();
    return $datos;
 }
 /************************************* */
 public function DevuelveAsesores()
 {
      $consulta="select * from facturas f where f.fecha_pago is null order by id";
    	
	  $datos=$this->db->query($consulta)->result();
    return $datos;
 }
 public function DevuelveFactura($valor)
 {
      $consulta="select * from facturas f where id = '".$valor."'";
        
      $datos=$this->db->query($consulta)->result();
    return $datos;
 }
public function DevulveDtractores($valor)
 {
    
    $consulta="select * 
                         from calificaencuesta where  activa =1
                        and   calificacion <  70 and  idencuesta = '".$valor."'";
    
    $datos=$this->db->query($consulta)->result();
    return $datos;
 }
 //--------------------------------------------------
 public function DevulvePasivos($valor)
 {
    
    $consulta="select * 
                         from calificaencuesta where  activa =1
                        and   calificacion >=  70 and calificacion <  90 and idencuesta = '".$valor."'";
    
    $datos=$this->db->query($consulta)->result();
    return $datos;
 }
 //---------------------------------------------------
 public function DevulvePromotores($valor)
 {
    
    $consulta="select * from calificaencuesta where  activa =1 and   calificacion >=  90 and  idencuesta = '".$valor."'";    
    $datos=$this->db->query($consulta)->result();
    return $datos;
 }
 //----------------------------------------------------
 public function DevulvePresupuesto($valor,$iden)
 {
   $valor2 = $valor -1;
   if($iden==1)
   { 
   $eneroi = $valor."-01-01";
   $enerof = $valor."-01-31";
   }
   if($iden==2)
   { 
   $eneroi = $valor."-02-01";
   $enerof = $valor."-02-29";
   }
   if($iden==3)
   { 
   $eneroi = $valor."-03-01";
   $enerof = $valor."-03-31";
   }
   if($iden==4)
   { 
   $eneroi = $valor."-04-01";
   $enerof = $valor."-04-30";
   }
   if($iden==5)
   { 
   $eneroi = $valor."-05-01";
   $enerof = $valor."-05-31";
   }
   if($iden==6)
   { 
   $eneroi = $valor."-06-01";
   $enerof = $valor."-06-30";
   }
   if($iden==7)
   { 
   $eneroi = $valor."-07-01";
   $enerof = $valor."-07-31";
   }
   if($iden==8)
   { 
   $eneroi = $valor."-08-01";
   $enerof = $valor."-08-31";
   }
   if($iden==9)
   { 
   $eneroi = $valor."-09-01";
   $enerof = $valor."-09-30";
   }
   if($iden==10)
   { 
   $eneroi = $valor."-10-01";
   $enerof = $valor."-10-31";
   }
   if($iden==11)
   { 
   $eneroi = $valor."-11-01";
   $enerof = $valor."-11-30";
   }
   if($iden==12)
   { 
   $eneroi = $valor."-12-01";
   $enerof = $valor."-12-31";
   }
   $consulta="select 'AsesoresMerida' as Sucursal,sum((ef.Comision0+ef.Comision1+ef.Comision2+ef.Comision3+ef.Comision4+ef.Comision5+ef.Comision7+ef.Comision8+ef.Comision9)*ef.TCPago) as comision from estadofinanciero ef where FechaDocto between '".$eneroi."' and '".$enerof."' and ef.ramosnombre NOT LIKE '%Fianzas%' AND ef.GerenciaNombre not like '%institucional%' and 
      DespNombre like '%MERIDA%' union 
      select 'AsesoresCancun' as Sucursal,sum((ef.Comision0+ef.Comision1+ef.Comision2+ef.Comision3+ef.Comision4+ef.Comision5+ef.Comision7+ef.Comision8+ef.Comision9)*ef.TCPago)  as comision from estadofinanciero ef where FechaDocto between '".$eneroi."' and '".$enerof."' and ef.ramosnombre NOT LIKE '%Fianzas%' AND ef.GerenciaNombre not like '%insti%' and 
     DespNombre like '%Cancun%'
     union
     select 'Institucional MID' as Sucursal,sum((ef.Comision0+ef.Comision1+ef.Comision2+ef.Comision3+ef.Comision4+ef.Comision5+ef.Comision7+ef.Comision8+ef.Comision9)*ef.TCPago) from estadofinanciero ef where FechaDocto between '".$eneroi."' and '".$enerof."' and ef.ramosnombre NOT LIKE '%Fianzas%' AND ef.GerenciaNombre   like '%insti%' and 
 ef.Grupo like'%Pro%' and DespNombre like '%Merida%'  and SubGrupo not like '%huer%' and SubGrupo not like '%loria%'
     union
     select 'Institucional CAN' as Sucursal,sum((ef.Comision0+ef.Comision1+ef.Comision2+ef.Comision3+ef.Comision4+ef.Comision5+ef.Comision7+ef.Comision8+ef.Comision9)*ef.TCPago) from estadofinanciero ef where FechaDocto between '".$eneroi."' and '".$enerof."' and ef.ramosnombre NOT LIKE '%Fianzas%' AND ef.GerenciaNombre  like '%insti%' and 
     ef.Grupo like'%Pro%' and DespNombre like '%can%' and SubGrupo not like '%huerfana%'  and SubGrupo not like '%loria%'
         
     ";
//$fp=fopen('resultadoJason.txt','a');fwrite($fp,print_r($consulta.'=============',true));fclose($fp);
        
   $datos=$this->db->query($consulta)->result();
    return $datos;
 }
 //------------------------------------------------------------
  public function DevuelveBonoSeguros($valor,$iden)
 {
   //$valor2 = $valor -1;
   $consulta="
      select concat(tipo,' ".$valor."') as sucursal ,cantidad as total from promobono  where   canal  like  '%insti%' and tipo like '%bono%' and anio = '".$valor."' and mes = '".$iden."'";
     
   $datos=$this->db->query($consulta)->result();
   return $datos;
  } 
  //------------------------------------------------------------
    public function DevuelvePromoSeguros($valor,$iden)
 {
   $valor2 = $valor -1;
   $consulta="
      select tipo as sucursal ,cantidad as total from promobono  where   canal  like  '%inst%' and tipo like '%prom%' and anio = '".$valor."' and mes = '".$iden."'";
   $datos=$this->db->query($consulta)->result();
   return $datos;
  }
   public function DevuelveBonoFianzas($valor,$iden)
 {
   //$valor2 = $valor -1;
   $consulta="
      select concat(tipo,' ".$valor."') as sucursal ,cantidad as total from promobono  where   canal  like  '%fianza%' and tipo like '%bono%' and anio = '".$valor."' and mes = '".$iden."'
     ";
   $datos=$this->db->query($consulta)->result();
   return $datos;
  } 
  
    public function DevuelvePromoFianzas($valor,$iden)
 {
   $valor2 = $valor -1;
   $consulta="
      select tipo as sucursal ,cantidad as total from promobono  where   canal  like  '%fianz%' and tipo like '%prom%' and anio = '".$valor."' and mes = '".$iden."'
     ";
   $datos=$this->db->query($consulta)->result();
   return $datos;
  } 
public function DevulveBono($valor)
 {
   $valor2 = $valor -1;
   $eneroi = $valor."-01-01";
   $enerof = $valor."-01-31";
   $consulta="
     select tipo as sucursal ,cantidad as total from promobono  where   canal  like  '%segu%' and tipo like '%cost%' and anio = '".$valor."' and mes = 1
     ";
   $datos=$this->db->query($consulta)->result();
    return $datos;
 } 
public function DevulveCostoVenta($valor,$iden)
 {
   if($iden==1)
   { 
   $eneroi = $valor."-01-01";
   $enerof = $valor."-01-31";
   }
   if($iden==2)
   { 
   $eneroi = $valor."-02-01";
   $enerof = $valor."-02-29";
   }
   if($iden==3)
   { 
   $eneroi = $valor."-03-01";
   $enerof = $valor."-03-31";
   }
   if($iden==4)
   { 
   $eneroi = $valor."-04-01";
   $enerof = $valor."-04-30";
   }
   if($iden==5)
   { 
   $eneroi = $valor."-05-01";
   $enerof = $valor."-05-31";
   }
   if($iden==6)
   { 
   $eneroi = $valor."-06-01";
   $enerof = $valor."-06-30";
   }
   if($iden==7)
   { 
   $eneroi = $valor."-07-01";
   $enerof = $valor."-07-31";
   }
   if($iden==8)
   { 
   $eneroi = $valor."-08-01";
   $enerof = $valor."-08-31";
   }
   if($iden==9)
   { 
   $eneroi = $valor."-09-01";
   $enerof = $valor."-09-30";
   }
   if($iden==10)
   { 
   $eneroi = $valor."-10-01";
   $enerof = $valor."-10-31";
   }
   if($iden==11)
   { 
   $eneroi = $valor."-11-01";
   $enerof = $valor."-11-30";
   }
   if($iden==12)
   { 
   $eneroi = $valor."-12-01";
   $enerof = $valor."-12-31";
   }
   $consulta="select 'COSTO' as sucursal ,sum(h.ImporteP ) as total from honorarios h where h.Ramo not like '%fian%' and
                 h.FPago between '".$eneroi."' and '".$enerof."' and h.VendNombre not like'%G.A.P%'";
   

/*   $consulta="select 'COSTO' as sucursal ,sum(h.ImporteP ) as total from honorarios h where h.Ramo not like '%fian%' and
  h.FPago between '".$eneroi."' and '".$enerof."'";
  */   
   $datos=$this->db->query($consulta)->result();
    return $datos;
 }
 public function DevulveGasto($valor,$iden)
 {
   //$valor2 = $valor -1;
   //$eneroi = $valor."-01-01";
   //$enerof = $valor."-01-31";
   if($iden==1)
   { 
   $eneroi = $valor."-01-01";
   $enerof = $valor."-01-31";
   }
   if($iden==2)
   { 
   $eneroi = $valor."-02-01";
   $enerof = $valor."-02-29";
   }
   if($iden==3)
   { 
   $eneroi = $valor."-03-01";
   $enerof = $valor."-03-31";
   }
   if($iden==4)
   { 
   $eneroi = $valor."-04-01";
   $enerof = $valor."-04-30";
   }
   if($iden==5)
   { 
   $eneroi = $valor."-05-01";
   $enerof = $valor."-05-31";
   }
   if($iden==6)
   { 
   $eneroi = $valor."-06-01";
   $enerof = $valor."-06-30";
   }
   if($iden==7)
   { 
   $eneroi = $valor."-07-01";
   $enerof = $valor."-07-31";
   }
   if($iden==8)
   { 
   $eneroi = $valor."-08-01";
   $enerof = $valor."-08-31";
   }
   if($iden==9)
   { 
   $eneroi = $valor."-09-01";
   $enerof = $valor."-09-30";
   }
   if($iden==10)
   { 
   $eneroi = $valor."-10-01";
   $enerof = $valor."-10-31";
   }
   if($iden==11)
   { 
   $eneroi = $valor."-11-01";
   $enerof = $valor."-11-30";
   }
   if($iden==12)
   { 
   $eneroi = $valor."-12-01";
   $enerof = $valor."-12-31";
   }
   $consulta="
     select 'Gasto de Operacion' as sucursal,sum(fac.montoinstitucional ) as total from facturas fac where tipoGasto <> 2 and  fac.fecha_pago between  '".$eneroi."' and '".$enerof."'
     ";
   $datos=$this->db->query($consulta)->result();
    return $datos;
 }
  public function DevulveNomina($valor,$iden)
 {
  if($iden==1)
   { 
   $eneroi = $valor."-01-01";
   $enerof = $valor."-01-31";
   }
   if($iden==2)
   { 
   $eneroi = $valor."-02-01";
   $enerof = $valor."-02-29";
   }
   if($iden==3)
   { 
   $eneroi = $valor."-03-01";
   $enerof = $valor."-03-31";
   }
   if($iden==4)
   { 
   $eneroi = $valor."-04-01";
   $enerof = $valor."-04-30";
   }
   if($iden==5)
   { 
   $eneroi = $valor."-05-01";
   $enerof = $valor."-05-31";
   }
   if($iden==6)
   { 
   $eneroi = $valor."-06-01";
   $enerof = $valor."-06-30";
   }
   if($iden==7)
   { 
   $eneroi = $valor."-07-01";
   $enerof = $valor."-07-31";
   }
   if($iden==8)
   { 
   $eneroi = $valor."-08-01";
   $enerof = $valor."-08-31";
   }
   if($iden==9)
   { 
   $eneroi = $valor."-09-01";
   $enerof = $valor."-09-30";
   }
   if($iden==10)
   { 
   $eneroi = $valor."-10-01";
   $enerof = $valor."-10-31";
   }
   if($iden==11)
   { 
   $eneroi = $valor."-11-01";
   $enerof = $valor."-11-30";
   }
   if($iden==12)
   { 
   $eneroi = $valor."-12-01";
   $enerof = $valor."-12-31";
   }
   $consulta="
     select 'Nomina' as sucursal,sum(fac.montoinstitucional ) as total from facturas fac where tipoGasto = 2 and fac.fecha_pago between  '".$eneroi."' and '".$enerof."'
     ";
     
   $datos=$this->db->query($consulta)->result();
    return $datos;
 }
 public function DevuelveFianzas($valor,$iden)
 {
   $valor2 = $valor -1;
   //$eneroi = $valor."-01-01";
   //$enerof = $valor."-01-31";
   if($iden==1)
   { 
   $eneroi = $valor."-01-01";
   $enerof = $valor."-01-31";
   }
   if($iden==2)
   { 
   $eneroi = $valor."-02-01";
   $enerof = $valor."-02-29";
   }
   if($iden==3)
   { 
   $eneroi = $valor."-03-01";
   $enerof = $valor."-03-31";
   }
   if($iden==4)
   { 
   $eneroi = $valor."-04-01";
   $enerof = $valor."-04-30";
   }
   if($iden==5)
   { 
   $eneroi = $valor."-05-01";
   $enerof = $valor."-05-31";
   }
   if($iden==6)
   { 
   $eneroi = $valor."-06-01";
   $enerof = $valor."-06-30";
   }
   if($iden==7)
   { 
   $eneroi = $valor."-07-01";
   $enerof = $valor."-07-31";
   }
   if($iden==8)
   { 
   $eneroi = $valor."-08-01";
   $enerof = $valor."-08-31";
   }
   if($iden==9)
   { 
   $eneroi = $valor."-09-01";
   $enerof = $valor."-09-30";
   }
   if($iden==10)
   { 
   $eneroi = $valor."-10-01";
   $enerof = $valor."-10-31";
   }
   if($iden==11)
   { 
   $eneroi = $valor."-11-01";
   $enerof = $valor."-11-30";
   }
   if($iden==12)
   { 
   $eneroi = $valor."-12-01";
   $enerof = $valor."-12-31";
   }
   $consulta="select 'Institucional',sum((ef.Comision0+ef.Comision1+ef.Comision2+ef.Comision3+ef.Comision4+ef.Comision5+ef.Comision7+ef.Comision8+ef.Comision9)*ef.TCPago)  as Fianzas from estadofinanciero ef where FechaDocto between '".$eneroi."' and '".$enerof."'  and ramosnombre='Fianzas'
     and  ef.vendNombre like('%G.A.P%') AND ef.Grupo like'%PRO%'
    union
    select 'Coporativa',sum((ef.Comision0+ef.Comision1+ef.Comision2+ef.Comision3+ef.Comision4+ef.Comision5+ef.Comision7+ef.Comision8+ef.Comision9)*ef.TCPago)  as Fianzas from estadofinanciero ef where FechaDocto between '".$eneroi."' and '".$enerof."'   and ramosnombre='Fianzas'
    and  ef.vendNombre like('%G.A.P%') AND ef.Grupo like'%Cer%'
    union
     select 'Asesores',sum((ef.Comision0+ef.Comision1+ef.Comision2+ef.Comision3+ef.Comision4+ef.Comision5+ef.Comision7+ef.Comision8+ef.Comision9)*ef.TCPago)  as Fianzas from estadofinanciero ef where ef.FechaDocto between '".$eneroi."' and '".$enerof."'   and ramosnombre='Fianzas'
       and  ef.vendNombre not like('%G.A.P%') 
            ";

   $datos=$this->db->query($consulta)->result();
    return $datos;
 }
public function DevulveCostoFianza($valor,$iden)
 {
   $valor2 = $valor -1;
   if($iden==1)
   { 
   $eneroi = $valor."-01-01";
   $enerof = $valor."-01-31";
   }
   if($iden==2)
   { 
   $eneroi = $valor."-02-01";
   $enerof = $valor."-02-29";
   }
   if($iden==3)
   { 
   $eneroi = $valor."-03-01";
   $enerof = $valor."-03-31";
   }
   if($iden==4)
   { 
   $eneroi = $valor."-04-01";
   $enerof = $valor."-04-30";
   }
   if($iden==5)
   { 
   $eneroi = $valor."-05-01";
   $enerof = $valor."-05-31";
   }
   if($iden==6)
   { 
   $eneroi = $valor."-06-01";
   $enerof = $valor."-06-30";
   }
   if($iden==7)
   { 
   $eneroi = $valor."-07-01";
   $enerof = $valor."-07-31";
   }
   if($iden==8)
   { 
   $eneroi = $valor."-08-01";
   $enerof = $valor."-08-31";
   }
   if($iden==9)
   { 
   $eneroi = $valor."-09-01";
   $enerof = $valor."-09-30";
   }
   if($iden==10)
   { 
   $eneroi = $valor."-10-01";
   $enerof = $valor."-10-31";
   }
   if($iden==11)
   { 
   $eneroi = $valor."-11-01";
   $enerof = $valor."-11-30";
   }
   if($iden==12)
   { 
   $eneroi = $valor."-12-01";
   $enerof = $valor."-12-31";
   }
   $consulta="
     select 'COSTO' as sucursal ,sum(h.ImporteP ) as total from honorarios h where h.Ramo  like '%fian%' and
                 h.FPago between '".$eneroi."' and '".$enerof."' 
     ";
   $datos=$this->db->query($consulta)->result();
    return $datos;
 }
 public function DevulveGastoFianza($valor,$iden)
 {
   $valor2 = $valor -1;
   //$eneroi = $valor."-01-01";
   //$enerof = $valor."-01-31";
   if($iden==1)
   { 
   $eneroi = $valor."-01-01";
   $enerof = $valor."-01-31";
   }
   if($iden==2)
   { 
   $eneroi = $valor."-02-01";
   $enerof = $valor."-02-29";
   }
   if($iden==3)
   { 
   $eneroi = $valor."-03-01";
   $enerof = $valor."-03-31";
   }
   if($iden==4)
   { 
   $eneroi = $valor."-04-01";
   $enerof = $valor."-04-30";
   }
   if($iden==5)
   { 
   $eneroi = $valor."-05-01";
   $enerof = $valor."-05-31";
   }
   if($iden==6)
   { 
   $eneroi = $valor."-06-01";
   $enerof = $valor."-06-30";
   }
   if($iden==7)
   { 
   $eneroi = $valor."-07-01";
   $enerof = $valor."-07-31";
   }
   if($iden==8)
   { 
   $eneroi = $valor."-08-01";
   $enerof = $valor."-08-31";
   }
   if($iden==9)
   { 
   $eneroi = $valor."-09-01";
   $enerof = $valor."-09-30";
   }
   if($iden==10)
   { 
   $eneroi = $valor."-10-01";
   $enerof = $valor."-10-31";
   }
   if($iden==11)
   { 
   $eneroi = $valor."-11-01";
   $enerof = $valor."-11-30";
   }
   if($iden==12)
   { 
   $eneroi = $valor."-12-01";
   $enerof = $valor."-12-31";
   }
   $consulta="
     select 'Gasto' as sucursal,sum(fac.montofianzas ) as total from facturas fac where tipoGasto in(0,1)  and fac.fecha_pago between  '".$eneroi."' and '".$enerof."'
     ";
   $datos=$this->db->query($consulta)->result();
    return $datos;
 }
 //------------------------------------------------------
public function DevulveNominaFianza($valor,$iden)
 {
   $valor2 = $valor -1;
   if($iden==1)
   { 
   $eneroi = $valor."-01-01";
   $enerof = $valor."-01-31";
   }
   if($iden==2)
   { 
   $eneroi = $valor."-02-01";
   $enerof = $valor."-02-29";
   }
   if($iden==3)
   { 
   $eneroi = $valor."-03-01";
   $enerof = $valor."-03-31";
   }
   if($iden==4)
   { 
   $eneroi = $valor."-04-01";
   $enerof = $valor."-04-30";
   }
   if($iden==5)
   { 
   $eneroi = $valor."-05-01";
   $enerof = $valor."-05-31";
   }
   if($iden==6)
   { 
   $eneroi = $valor."-06-01";
   $enerof = $valor."-06-30";
   }
   if($iden==7)
   { 
   $eneroi = $valor."-07-01";
   $enerof = $valor."-07-31";
   }
   if($iden==8)
   { 
   $eneroi = $valor."-08-01";
   $enerof = $valor."-08-31";
   }
   if($iden==9)
   { 
   $eneroi = $valor."-09-01";
   $enerof = $valor."-09-30";
   }
   if($iden==10)
   { 
   $eneroi = $valor."-10-01";
   $enerof = $valor."-10-31";
   }
   if($iden==11)
   { 
   $eneroi = $valor."-11-01";
   $enerof = $valor."-11-30";
   }
   if($iden==12)
   { 
   $eneroi = $valor."-12-01";
   $enerof = $valor."-12-31";
   }
   $consulta="
     select 'Nomina' as sucursal,sum(fac.montofianzas ) as total from facturas fac where tipoGasto in(2)  and fac.fecha_pago between  '".$eneroi."' and '".$enerof."'
     ";
     
   $datos=$this->db->query($consulta)->result();
    return $datos;
 }
//------------------------------------------------------------------------
 public function DevulveComisionCoorpo($valor,$iden)
 {
   $valor2 = $valor -1;
    if($iden==1)
   { 
   $eneroi = $valor."-01-01";
   $enerof = $valor."-01-31";
   }
   if($iden==2)
   { 
   $eneroi = $valor."-02-01";
   $enerof = $valor."-02-29";
   }
   if($iden==3)
   { 
   $eneroi = $valor."-03-01";
   $enerof = $valor."-03-31";
   }
   if($iden==4)
   { 
   $eneroi = $valor."-04-01";
   $enerof = $valor."-04-30";
   }
   if($iden==5)
   { 
   $eneroi = $valor."-05-01";
   $enerof = $valor."-05-31";
   }
   if($iden==6)
   { 
   $eneroi = $valor."-06-01";
   $enerof = $valor."-06-30";
   }
   if($iden==7)
   { 
   $eneroi = $valor."-07-01";
   $enerof = $valor."-07-31";
   }
   if($iden==8)
   { 
   $eneroi = $valor."-08-01";
   $enerof = $valor."-08-31";
   }
   if($iden==9)
   { 
   $eneroi = $valor."-09-01";
   $enerof = $valor."-09-30";
   }
   if($iden==10)
   { 
   $eneroi = $valor."-10-01";
   $enerof = $valor."-10-31";
   }
   if($iden==11)
   { 
   $eneroi = $valor."-11-01";
   $enerof = $valor."-11-30";
   }
   if($iden==12)
   { 
   $eneroi = $valor."-12-01";
   $enerof = $valor."-12-31";
   }
   $consulta="
      select tipo as sucursal ,cantidad as total from promobono  where   canal  like  '%Coorp%' and tipo like '%comi%' and anio = '".$valor."' and mes = '".$iden."
     '";
   $datos=$this->db->query($consulta)->result();
    return $datos;
 }
  public function DevulveBonoCoorpo($valor,$iden)
 {
   $valor2 = $valor -1;
   if($iden==1)
   { 
   $eneroi = $valor."-01-01";
   $enerof = $valor."-01-31";
   }
   if($iden==2)
   { 
   $eneroi = $valor."-02-01";
   $enerof = $valor."-02-29";
   }
   if($iden==3)
   { 
   $eneroi = $valor."-03-01";
   $enerof = $valor."-03-31";
   }
   if($iden==4)
   { 
   $eneroi = $valor."-04-01";
   $enerof = $valor."-04-30";
   }
   if($iden==5)
   { 
   $eneroi = $valor."-05-01";
   $enerof = $valor."-05-31";
   }
   if($iden==6)
   { 
   $eneroi = $valor."-06-01";
   $enerof = $valor."-06-30";
   }
   if($iden==7)
   { 
   $eneroi = $valor."-07-01";
   $enerof = $valor."-07-31";
   }
   if($iden==8)
   { 
   $eneroi = $valor."-08-01";
   $enerof = $valor."-08-31";
   }
   if($iden==9)
   { 
   $eneroi = $valor."-09-01";
   $enerof = $valor."-09-30";
   }
   if($iden==10)
   { 
   $eneroi = $valor."-10-01";
   $enerof = $valor."-10-31";
   }
   if($iden==11)
   { 
   $eneroi = $valor."-11-01";
   $enerof = $valor."-11-30";
   }
   if($iden==12)
   { 
   $eneroi = $valor."-12-01";
   $enerof = $valor."-12-31";
   }
   $consulta="
      select tipo as sucursal ,cantidad as total from promobono  where   canal  like  '%Coorp%' and tipo like '%Bono%' and anio = '".$valor."' and mes ='".$iden."'";
    // $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($consulta,TRUE));fclose($fp);
   $datos=$this->db->query($consulta)->result();
    return $datos;
 }
   public function DevulveCostoCoorpo($valor,$iden)
 {
   $valor2 = $valor -1;
  if($iden==1)
   { 
   $eneroi = $valor."-01-01";
   $enerof = $valor."-01-31";
   }
   if($iden==2)
   { 
   $eneroi = $valor."-02-01";
   $enerof = $valor."-02-29";
   }
   if($iden==3)
   { 
   $eneroi = $valor."-03-01";
   $enerof = $valor."-03-31";
   }
   if($iden==4)
   { 
   $eneroi = $valor."-04-01";
   $enerof = $valor."-04-30";
   }
   if($iden==5)
   { 
   $eneroi = $valor."-05-01";
   $enerof = $valor."-05-31";
   }
   if($iden==6)
   { 
   $eneroi = $valor."-06-01";
   $enerof = $valor."-06-30";
   }
   if($iden==7)
   { 
   $eneroi = $valor."-07-01";
   $enerof = $valor."-07-31";
   }
   if($iden==8)
   { 
   $eneroi = $valor."-08-01";
   $enerof = $valor."-08-31";
   }
   if($iden==9)
   { 
   $eneroi = $valor."-09-01";
   $enerof = $valor."-09-30";
   }
   if($iden==10)
   { 
   $eneroi = $valor."-10-01";
   $enerof = $valor."-10-31";
   }
   if($iden==11)
   { 
   $eneroi = $valor."-11-01";
   $enerof = $valor."-11-30";
   }
   if($iden==12)
   { 
   $eneroi = $valor."-12-01";
   $enerof = $valor."-12-31";
   }
   $consulta="
      select tipo as sucursal ,cantidad as total from promobono  where   canal  like  '%Coorp%' and tipo like '%CCO%' and anio = '".$valor."' and mes = '".$iden."'";
   $datos=$this->db->query($consulta)->result();
    return $datos;
 }
  public function DevulveGastoCoorpo($valor,$iden)
 {
   $valor2 = $valor -1;
   if($iden==1)
   { 
   $eneroi = $valor."-01-01";
   $enerof = $valor."-01-31";
   }
   if($iden==2)
   { 
   $eneroi = $valor."-02-01";
   $enerof = $valor."-02-29";
   }
   if($iden==3)
   { 
   $eneroi = $valor."-03-01";
   $enerof = $valor."-03-31";
   }
   if($iden==4)
   { 
   $eneroi = $valor."-04-01";
   $enerof = $valor."-04-30";
   }
   if($iden==5)
   { 
   $eneroi = $valor."-05-01";
   $enerof = $valor."-05-31";
   }
   if($iden==6)
   { 
   $eneroi = $valor."-06-01";
   $enerof = $valor."-06-30";
   }
   if($iden==7)
   { 
   $eneroi = $valor."-07-01";
   $enerof = $valor."-07-31";
   }
   if($iden==8)
   { 
   $eneroi = $valor."-08-01";
   $enerof = $valor."-08-31";
   }
   if($iden==9)
   { 
   $eneroi = $valor."-09-01";
   $enerof = $valor."-09-30";
   }
   if($iden==10)
   { 
   $eneroi = $valor."-10-01";
   $enerof = $valor."-10-31";
   }
   if($iden==11)
   { 
   $eneroi = $valor."-11-01";
   $enerof = $valor."-11-30";
   }
   if($iden==12)
   { 
   $eneroi = $valor."-12-01";
   $enerof = $valor."-12-31";
   }
   $consulta="
     select 'Gasto' as sucursal,sum(fac.corporativo) as total from facturas fac where tipoGasto in(0,1)  and fac.fecha_pago between  '".$eneroi."' and '".$enerof."'
     ";
   $datos=$this->db->query($consulta)->result();
    return $datos;
 }
 public function DevulveNominaCorpo($valor,$iden)
 {
   $valor2 = $valor -1;
   if($iden==1)
   { 
   $eneroi = $valor."-01-01";
   $enerof = $valor."-01-31";
   }
   if($iden==2)
   { 
   $eneroi = $valor."-02-01";
   $enerof = $valor."-02-29";
   }
   if($iden==3)
   { 
   $eneroi = $valor."-03-01";
   $enerof = $valor."-03-31";
   }
   if($iden==4)
   { 
   $eneroi = $valor."-04-01";
   $enerof = $valor."-04-30";
   }
   if($iden==5)
   { 
   $eneroi = $valor."-05-01";
   $enerof = $valor."-05-31";
   }
   if($iden==6)
   { 
   $eneroi = $valor."-06-01";
   $enerof = $valor."-06-30";
   }
   if($iden==7)
   { 
   $eneroi = $valor."-07-01";
   $enerof = $valor."-07-31";
   }
   if($iden==8)
   { 
   $eneroi = $valor."-08-01";
   $enerof = $valor."-08-31";
   }
   if($iden==9)
   { 
   $eneroi = $valor."-09-01";
   $enerof = $valor."-09-30";
   }
   if($iden==10)
   { 
   $eneroi = $valor."-10-01";
   $enerof = $valor."-10-31";
   }
   if($iden==11)
   { 
   $eneroi = $valor."-11-01";
   $enerof = $valor."-11-30";
   }
   if($iden==12)
   { 
   $eneroi = $valor."-12-01";
   $enerof = $valor."-12-31";
   }
   $consulta="
     select 'Nomina' as sucursal,sum(fac.corporativo ) as total from facturas fac where tipoGasto in(2)  and fac.fecha_pago between  '".$eneroi."' and '".$enerof."'
     ";
   $datos=$this->db->query($consulta)->result();
    return $datos;
 }
/********************************** */
function DevulvegastosEspeciales($fecha1,$fecha2)
{
  $consulta = "select f.fecha_pago,f.concepto,f.totalfactura 
  ,f.ccc,f.cco,f.inversion,f.gestion
  from facturas f where f.fecha_pago between '".$fecha1."' and '".$fecha2."' 
  and f.gestion >0";
  $datos=$this->db->query($consulta)->result();
    return $datos;
}
/********************************** */
}	
?>