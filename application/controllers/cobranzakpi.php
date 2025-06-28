<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class cobranzakpi extends CI_Controller{
   function __construct(){
      parent::__construct();
      $this->load->library('Ws_sicas');
      error_reporting(0);
         
   }


//Modificacion 29-09-2021
 function index(){

   if( (!empty($_REQUEST['fdesde'])) && (!empty($_REQUEST['fhasta'])) ) {
      $fdesde=date('d-m-Y',strtotime($_REQUEST['fdesde']));
      $fhasta=date('d-m-Y',strtotime($_REQUEST['fhasta']));
   }else{
      date_default_timezone_set('America/Mexico_City');
      $fdesde=date("d-m-Y", mktime(0,0,0,date("m"),01,date("Y")));
      $fhasta= date("d-m-Y", mktime(0,0,0,date("m") + 1,0, date("Y")));
   }
$this->datos['error']=$this->CobranzaPendiente($fdesde,$fhasta);


//********Desgloces
 
$this->datos['todaCobranza']=$this->getTodaCobranza();//TABLA cobranza_toda 
$this->datos['totalTodaPendiente']=$this->getTodaCobranzaEstado('Pendiente');//TABLA cobranza_toda 
$this->datos['totalTodaCancelado']=$this->getTodaCobranzaEstado('Cancelado');//TABLA cobranza_toda 
$this->datos['totalTodaPagado']=$this->getTodaCobranzaEstado('Pagado');//TABLA cobranza_toda 
$this->datos['totalTodaLiquidado']=$this->getTodaCobranzaEstado('Liquidado');//TABLA cobranza_toda 
$this->datos['todaCobranzaF']=$this->getTodaCobranzaF(); //TABLA cobranza_toda 
$this->datos['totalTodaPendienteF']=$this->getTodaCobranzaEstadoF('Pendiente');//TABLA cobranza_toda 
$this->datos['totalTodaCanceladoF']=$this->getTodaCobranzaEstadoF('Cancelado');//TABLA cobranza_toda 
$this->datos['totalTodaPagadoF']=$this->getTodaCobranzaEstadoF('Pagado');//TABLA cobranza_toda 
$this->datos['totalTodaLiquidadoF']=$this->getTodaCobranzaEstadoF('Liquidado');//TABLA cobranza_toda 
$this->datos['efectuadaCobranza']=$this->getEfectuadaCobranza(); //TABLA cobranza_toda 
$this->datos['totalEfectuadaPagado']=$this->geTotalEfectuada();//TABLA cobranza_toda 
$this->datos['efectuadaCobranzaF']=$this->getEfectuadaCobranzaF(); //TABLA cobranza_toda 
$this->datos['totalEfectuadaPagadoF']=$this->geTotalEfectuadaF();//TABLA cobranza_toda 

//*********

$this->datos['totalSemaforo']=$this->getSemaforo();//TABLA cobranza_toda 
$this->datos['ctVencidasAgente']=$this->getTiempo(1);//TABLA cobranza_toda 
$this->datos['ctVencidasInstitucional']=$this->getTiempo(0);//TABLA cobranza_toda 
$this->datos['ctEntiempoAgente']=$this->getTiempo(1);//TABLA cobranza_toda 
$this->datos['ctEntiempoInstitucional']=$this->getTiempo(0);//TABLA cobranza_toda 
$this->datos['ctAgentesCAT']=$this->getCobranzaCAT(0);//TABLA cobranza_toda 
$this->datos['ctInstitucionalCAT']=$this->getCobranzaCAT(1);//TABLA cobranza_toda 
$this->datos['ctFianzasAgentes']=$this->getPendientesCountRecibosAgentes(1);//TABLA cobranza_toda 
$this->datos['ctSegurosAgentes']=$this->getPendientesCountRecibosAgentes(0);//TABLA cobranza_toda 
$this->datos['ctFianzasInstitucional']=$this->getPendientesCountRecibosInstitucional(1);//TABLA cobranza_toda 
$this->datos['ctSegurosInstitucional']=$this->getPendientesCountRecibosInstitucional(0);//TABLA cobranza_toda 
$this->datos['ctEfectuadaAtrasadaFianzas']=$this->getEfectuadaAtrasadaCountRecibos(1);//TABLA cobranza_toda 
$this->datos['ctEfectuadaAtrasadaSeguros']=$this->getEfectuadaAtrasadaCountRecibos(0);//TABLA cobranza_toda 
$this->datos['primaNetaEfectuadaAtrasadaFianzas']=$this->getEfectuadaAtrasadaPrimaNeta(1);//TABLA cobranza_toda 
$this->datos['primaNetaEfectuadaAtrasadaSeguros']=$this->getEfectuadaAtrasadaPrimaNeta(0);//TABLA cobranza_toda 
$this->datos['comisionEfectuadaAtrasadaFianzas']=$this->getEfectuadaAtrasadaComision(1);//TABLA cobranza_toda 
$this->datos['comisionEfectuadaAtrasadaSeguros']=$this->getEfectuadaAtrasadaComision(0);//TABLA cobranza_toda 
$this->datos['ctEfectuadaFianzas']=$this->getEfectuadaCountRecibos(1);//TABLA cobranza_toda
$this->datos['ctEfectuadaSeguros']=$this->getEfectuadaCountRecibos(0);//TABLA cobranza_toda
$this->datos['primaNetaEfectuadaFianzas']=$this->getEfectuadaPrimaNeta(1);//TABLA cobranza_toda
$this->datos['primaNetaEfectuadaSeguros']=$this->getEfectuadaPrimaNeta(0);//TABLA cobranza_toda
$this->datos['comisionEfectuadaFianzas']=$this->getEfectuadaComision(1);//TABLA cobranza_toda
$this->datos['comisionEfectuadaSeguros']=$this->getEfectuadaComision(0);//TABLA cobranza_toda
$this->datos['ctCanceladaFianzas']=$this->getCanceladaCobranzaCountRecibos(1);//TABLA cobranza_toda
$this->datos['ctCanceladaSeguros']=$this->getCanceladaCobranzaCountRecibos(0);
$this->datos['primaNetaCanceladaFianzas']=$this->getCanceladaCobranzaPrimaNeta(1);//TABLA cobranza_toda
$this->datos['primaNetaCanceladaSeguros']=$this->getCanceladaCobranzaPrimaNeta(0,'cobranza_toda');//TABLA cobranza_toda
$this->datos['comisionCanceladaFianzas']=$this->getCanceladaCobranzaComision(1);//TABLA cobranza_toda
$this->datos['comisionCanceladaSeguros']=$this->getCanceladaCobranzaComision(0);//TABLA cobranza_toda
$this->datos['ctEfectuadaAnticipadaFianzas']=$this->getEfectuadaAnticipadaCobranzaCountRecibos(1);//TABLA cobranza_toda
$this->datos['ctEfectuadaAnticipadaSeguros']=$this->getEfectuadaAnticipadaCobranzaCountRecibos(0);//TABLA cobranza_toda
$this->datos['primaNetaEfectuadaAnticipadaFianzas']=$this->getEfectuadaAnticipadaCobranzaPrimaNeta(1);//TABLA cobranza_toda
$this->datos['primaNetaEfectuadaAnticipadaSeguros']=$this->getEfectuadaAnticipadaCobranzaPrimaNeta(0);//TABLA cobranza_toda
$this->datos['comisionEfectuadaAnticipadaFianzas']=$this->getEfectuadaAnticipadaCobranzaComision(1);//TABLA cobranza_toda
$this->datos['comisionEfectuadaAnticipadaSeguros']=$this->getEfectuadaAnticipadaCobranzaComision(0);//TABLA cobranza_toda
$this->datos['ctTodaFianzas']=$this->getTodaCobranzaCountRecibos(1);//TABLA cobranza_toda
$this->datos['ctTodaSeguros']=$this->getTodaCobranzaCountRecibos(0);//TABLA cobranza_toda
$this->datos['primaNetaFianzas']=$this->getTodaCobranzaPrimaNeta(1);//TABLA cobranza_toda
$this->datos['primaNetaSeguros']=$this->getTodaCobranzaPrimaNeta(0);//TABLA cobranza_toda
$this->datos['comisionFianzas']=$this->getCobranzaComision(1);//TABLA cobranza_toda
$this->datos['comisionSeguros']=$this->getCobranzaComision(0);//TABLA del_cobranza_toda
$this->datos['fdesde']=$fdesde;
$this->datos['fhasta']=$fhasta;

$this->load->view('reportes/cobranzakpi',$this->datos);
 }    


//Cuadro Secundario

function getPendientesCountRecibosInstitucional($fianzas){
   if($fianzas==1){
   $sql="SELECT COUNT(*) AS total FROM cobranza_toda WHERE RamosNombre='Fianzas' AND GerenciaNombre='INSTITUCIONAL' AND Status_TXT='Pendiente'";
   }else{
   $sql="SELECT COUNT(*) as total FROM cobranza_toda WHERE RamosNombre!='Fianzas'AND GerenciaNombre='INSTITUCIONAL' AND Status_TXT='Pendiente'";
   }
   $rs=$this->db->query($sql)->result();
   return $rs[0]->total;
}

function getPendientesCountRecibosAgentes($fianzas){
   if($fianzas==1){
   $sql="SELECT COUNT(*) AS total FROM cobranza_toda WHERE RamosNombre='Fianzas' AND GerenciaNombre!='INSTITUCIONAL' AND Status_TXT='Pendiente'";
   }else{
   $sql="SELECT COUNT(*) as total FROM cobranza_toda WHERE RamosNombre!='Fianzas' AND GerenciaNombre!='INSTITUCIONAL' AND Status_TXT='Pendiente'";
   }
   $rs=$this->db->query($sql)->result();
   return $rs[0]->total;
}



//**Cuadro Principal
function getEfectuadaAtrasadaCountRecibos($tipo){
  $mes=date('m');
  if($tipo==1){
    //$sql="SELECT COUNT(*) AS total FROM cobranza_toda WHERE Status_TXT='Pagado' AND RamosNombre='Fianzas' AND MONTH(FDoctoPago)!='$mes' OR Status_TXT='Liquidado' AND RamosNombre='Fianzas' AND MONTH(FDoctoPago)!='$mes'";
    $sql="SELECT COUNT(*) AS total FROM cobranza_efectuada WHERE RamosNombre='Fianzas' AND MONTH(FDoctoPago)!=MONTH(FechaDocto)  AND YEAR(FDoctoPago)=YEAR(FechaDocto)";
  }else{
     //$sql="SELECT COUNT(*) AS total FROM cobranza_toda WHERE Status_TXT='Pagado' AND RamosNombre!='Fianzas' AND MONTH(FDoctoPago)!='$mes' OR Status_TXT='Liquidado' AND RamosNombre!='Fianzas' AND MONTH(FDoctoPago)!='$mes'";
       $sql="SELECT COUNT(*) AS total FROM cobranza_efectuada WHERE  RamosNombre!='Fianzas' AND MONTH(FDoctoPago)!=MONTH(FechaDocto)  AND YEAR(FDoctoPago)=YEAR(FechaDocto)";
  }
  $rs=$this->db->query($sql)->result();
  return $rs[0]->total;
}

function getEfectuadaAtrasadaPrimaNeta($tipo){
  $total=0;
  $mes=date('m');
  if($tipo==1){
    //$sql="SELECT SUM(PrimaNeta) AS total FROM cobranza_toda WHERE Status_TXT='Pagado' AND RamosNombre='Fianzas' AND MONTH(FDoctoPago)!='$mes' OR Status_TXT='Liquidado' AND RamosNombre='Fianzas' AND MONTH(FDoctoPago)!='$mes'";
        $sql="SELECT SUM(PrimaNeta) AS total FROM cobranza_efectuada WHERE  RamosNombre='Fianzas' AND MONTH(FDoctoPago)!=MONTH(FechaDocto)  AND YEAR(FDoctoPago)=YEAR(FechaDocto)";
    $rs=$this->db->query($sql)->result();
    $total=$rs[0]->total;
  }else{
     //$sql="SELECT SUM(PrimaNeta) AS total FROM cobranza_toda WHERE Status_TXT='Pagado' AND RamosNombre!='Fianzas' AND MONTH(FDoctoPago)!='$mes' OR Status_TXT='Liquidado' AND RamosNombre!='Fianzas' AND MONTH(FDoctoPago)!='$mes'";
         $sql="SELECT SUM(PrimaNeta) AS total FROM cobranza_efectuada WHERE RamosNombre!='Fianzas' AND MONTH(FDoctoPago)!=MONTH(FechaDocto)  AND YEAR(FDoctoPago)=YEAR(FechaDocto)";
     $rs=$this->db->query($sql)->result();
     $total=$rs[0]->total;
  }
  return $total;
}

function getEfectuadaAtrasadaComision($tipo){
   $total=0;
   $mes=date('m');
  if($tipo==1){
     //$sqlY="SELECT * FROM cobranza_toda WHERE Status_TXT='Pagado' AND RamosNombre='Fianzas' AND MONTH(FDoctoPago)!='$mes' OR Status_TXT='Liquidado' AND RamosNombre='Fianzas' AND MONTH(FDoctoPago)!='$mes'";
         $sqlY="SELECT * FROM cobranza_efectuada WHERE  RamosNombre='Fianzas' AND MONTH(FDoctoPago)!=MONTH(FechaDocto)  AND YEAR(FDoctoPago)=YEAR(FechaDocto)";
     $rsY=$this->db->query($sqlY)->result();
     foreach($rsY as $rowY){
        $total+=(($rowY->Comision0)+($rowY->Comision1)+($rowY->Comision2)+($rowY->Comision3)+($rowY->Comision4)+($rowY->Comision5)+($rowY->Comision6)+($rowY->Comision7)+($rowY->Comision8)+($rowY->Comision9))*$rowY->TCPago;
     }
  }else{
    //$sqlY="SELECT * FROM cobranza_toda WHERE Status_TXT='Pagado' AND RamosNombre!='Fianzas' AND MONTH(FDoctoPago)!='$mes' OR Status_TXT='Liquidado' AND RamosNombre!='Fianzas' AND MONTH(FDoctoPago)!='$mes'";
        $sqlY="SELECT * FROM cobranza_efectuada WHERE   RamosNombre!='Fianzas' AND MONTH(FDoctoPago)!=MONTH(FechaDocto)  AND YEAR(FDoctoPago)=YEAR(FechaDocto)";
     $rsY=$this->db->query($sqlY)->result();
     foreach($rsY as $rowY){
        $total+=(($rowY->Comision0)+($rowY->Comision1)+($rowY->Comision2)+($rowY->Comision3)+($rowY->Comision4)+($rowY->Comision5)+($rowY->Comision6)+($rowY->Comision7)+($rowY->Comision8)+($rowY->Comision9))*$rowY->TCPago;
     }
  }
  return $total;
}

//*******************************
function getEfectuadaCountRecibos($tipo){
  $mes=date('m');
  if($tipo==1){
    //$sql="SELECT COUNT(*) AS total FROM cobranza_toda WHERE RamosNombre='Fianzas' AND Status_TXT='Pagado' AND MONTH(FDoctoPago)='$mes' OR RamosNombre='Fianzas' AND Status_TXT='Liquidado' AND MONTH(FDoctoPago)='$mes'";
    $sql="SELECT COUNT(*) AS total 
FROM cobranza_efectuada WHERE RamosNombre='Fianzas' 
AND MONTH(FDoctoPago)=MONTH(FechaDocto)  AND YEAR(FDoctoPago)=YEAR(FechaDocto)";
  }else{
    // $sql="SELECT COUNT(*) AS total FROM cobranza_toda WHERE RamosNombre!='Fianzas' AND Status_TXT='Pagado' AND MONTH(FDoctoPago)='$mes' OR RamosNombre!='Fianzas' AND Status_TXT='Liquidado' AND MONTH(FDoctoPago)='$mes'";
        $sql="SELECT COUNT(*) AS total 
FROM cobranza_efectuada WHERE RamosNombre!='Fianzas' 
AND MONTH(FDoctoPago)=MONTH(FechaDocto)  AND YEAR(FDoctoPago)=YEAR(FechaDocto)";
  }
  $rs=$this->db->query($sql)->result();
  return $rs[0]->total;
}

function getEfectuadaPrimaNeta($tipo){
  $total=0;
  $mes=date('m');
  if($tipo==1){
    //$sql="SELECT SUM(PrimaNeta) AS total FROM cobranza_toda WHERE RamosNombre='Fianzas' AND Status_TXT='Pagado' AND MONTH(FDoctoPago)='$mes' OR RamosNombre='Fianzas' AND Status_TXT='Liquidado' AND MONTH(FDoctoPago)='$mes'";
    $sql="SELECT SUM(PrimaNeta) AS total FROM cobranza_efectuada WHERE RamosNombre='Fianzas' AND MONTH(FDoctoPago)=MONTH(FechaDocto)  AND YEAR(FDoctoPago)=YEAR(FechaDocto)";
    $rs=$this->db->query($sql)->result();
    $total=$rs[0]->total;
  }else{
     //$sql="SELECT SUM(PrimaNeta) AS total FROM cobranza_toda WHERE RamosNombre!='Fianzas' AND Status_TXT='Pagado' AND MONTH(FDoctoPago)='$mes' OR RamosNombre!='Fianzas' AND Status_TXT='Liquidado' AND MONTH(FDoctoPago)='$mes'";
    $sql="SELECT SUM(PrimaNeta) AS total FROM cobranza_efectuada WHERE RamosNombre!='Fianzas' AND MONTH(FDoctoPago)=MONTH(FechaDocto)  AND YEAR(FDoctoPago)=YEAR(FechaDocto)";
     $rs=$this->db->query($sql)->result();
     $total=$rs[0]->total;
  }
  return $total;
}

function getEfectuadaComision($tipo){
   $total=0;
   $mes=date('m');
  if($tipo==1){
     $sqlY="SELECT * FROM cobranza_efectuada c WHERE RamosNombre='Fianzas' AND MONTH(FDoctoPago)=MONTH(FechaDocto)  AND YEAR(FDoctoPago)=YEAR(FechaDocto)";
     $rsY=$this->db->query($sqlY)->result();
     foreach($rsY as $rowY){
        $total+=(($rowY->Comision0)+($rowY->Comision1)+($rowY->Comision2)+($rowY->Comision3)+($rowY->Comision4)+($rowY->Comision5)+($rowY->Comision6)+($rowY->Comision7)+($rowY->Comision8)+($rowY->Comision9))*$rowY->TCPago;
     }
  }else{
    $sqlY="SELECT * FROM cobranza_efectuada WHERE RamosNombre!='Fianzas' AND MONTH(FDoctoPago)=MONTH(FechaDocto)  AND YEAR(FDoctoPago)=YEAR(FechaDocto)";
     $rsY=$this->db->query($sqlY)->result();
     foreach($rsY as $rowY){
        $total+=(($rowY->Comision0)+($rowY->Comision1)+($rowY->Comision2)+($rowY->Comision3)+($rowY->Comision4)+($rowY->Comision5)+($rowY->Comision6)+($rowY->Comision7)+($rowY->Comision8)+($rowY->Comision9))*$rowY->TCPago;
     }
  }
  return $total;
}


//************
function getCanceladaCobranzaCountRecibos($tipo){
  if($tipo==1){
    $sql="SELECT COUNT(*) AS total FROM cobranza_toda WHERE RamosNombre='Fianzas' AND Status_TXT='Cancelado'";
  }else{
     $sql="SELECT COUNT(*) AS total FROM cobranza_toda WHERE RamosNombre!='Fianzas' AND Status_TXT='Cancelado'";
  }
  $rs=$this->db->query($sql)->result();
  return $rs[0]->total;
}

function getCanceladaCobranzaPrimaNeta($tipo){
  $total=0;
  if($tipo==1){
    $sql="SELECT SUM(PrimaNeta) AS total FROM cobranza_toda WHERE RamosNombre='Fianzas' AND Status_TXT='Cancelado'";
    $rs=$this->db->query($sql)->result();
    $total=$rs[0]->total;
  }else{
     $sql="SELECT SUM(PrimaNeta) AS total FROM cobranza_toda WHERE RamosNombre!='Fianzas' AND Status_TXT='Cancelado'";
     $rs=$this->db->query($sql)->result();
     $total=$rs[0]->total;
  }
  return $total;
}

function getCanceladaCobranzaComision($tipo){
   $total=0;
  if($tipo==1){
     $sqlY="SELECT * FROM cobranza_toda WHERE RamosNombre='Fianzas' AND Status_TXT='Cancelado'";
     $rsY=$this->db->query($sqlY)->result();
     foreach($rsY as $rowY){
        $total+=(($rowY->Comision0)+($rowY->Comision1)+($rowY->Comision2)+($rowY->Comision3)+($rowY->Comision4)+($rowY->Comision5)+($rowY->Comision6)+($rowY->Comision7)+($rowY->Comision8)+($rowY->Comision9))*$rowY->TCDay;
     }
  }else{
    $sqlY="SELECT * FROM cobranza_toda WHERE RamosNombre!='Fianzas' AND Status_TXT='Cancelado'";
     $rsY=$this->db->query($sqlY)->result();
     foreach($rsY as $rowY){
        $total+=(($rowY->Comision0)+($rowY->Comision1)+($rowY->Comision2)+($rowY->Comision3)+($rowY->Comision4)+($rowY->Comision5)+($rowY->Comision6)+($rowY->Comision7)+($rowY->Comision8)+($rowY->Comision9))*$rowY->TCDay;
     }
  }
  return $total;
}

//***************
function getEfectuadaAnticipadaCobranzaCountRecibos($tipo){
  $mes=date('m');
  if($tipo==1){
    //$sql="SELECT COUNT(*) AS total FROM cobranza_toda WHERE RamosNombre='Fianzas' AND MONTH(FDoctoPago)!='$mes' AND Status_TXT='Pagado' AND Status_TXT='Liquidado'";
    $sql="SELECT COUNT(*) AS total FROM cobranza_efectuada
WHERE RamosNombre='Fianzas' AND MONTH(FechaDocto)=MONTH(FDoctoPago) AND YEAR(FechaDocto)=YEAR(FDoctoPago) ";
  }else{
     //$sql="SELECT COUNT(*) AS total FROM cobranza_toda WHERE RamosNombre!='Fianzas' AND MONTH(FDoctoPago)!='$mes' AND Status_TXT='Pagado' AND Status_TXT='Liquidado'";
        $sql="SELECT COUNT(*) AS total FROM cobranza_efectuada
WHERE RamosNombre!='Fianzas' AND MONTH(FechaDocto)=MONTH(FDoctoPago) AND YEAR(FechaDocto)=YEAR(FDoctoPago) ";
  }
  $rs=$this->db->query($sql)->result();
  return $rs[0]->total;
}

function getEfectuadaAnticipadaCobranzaPrimaNeta($tipo){
  $mes=date('m');
  $total=0;
  if($tipo==1){
    $sql="SELECT SUM(PrimaNeta) AS total FROM cobranza_efectuada WHERE RamosNombre='Fianzas' AND MONTH(FechaDocto)=MONTH(FDoctoPago) AND YEAR(FechaDocto)=YEAR(FDoctoPago)";
    $rs=$this->db->query($sql)->result();
    $total=$rs[0]->total;
  }else{
     $sql="SELECT SUM(PrimaNeta) AS total FROM cobranza_efectuada WHERE RamosNombre!='Fianzas' AND MONTH(FechaDocto)=MONTH(FDoctoPago) AND YEAR(FechaDocto)=YEAR(FDoctoPago)";
     $rs=$this->db->query($sql)->result();
     $total=$rs[0]->total;
  }
  return $total;
}

function getEfectuadaAnticipadaCobranzaComision($tipo){
   $total=0;
   $mes=date('m');
  if($tipo==1){
     $sqlY="SELECT c.*,(c.TCPago) as TCDay FROM cobranza_efectuada c WHERE RamosNombre='Fianzas' AND MONTH(FechaDocto)=MONTH(FDoctoPago) AND YEAR(FechaDocto)=YEAR(FDoctoPago)";
     $rsY=$this->db->query($sqlY)->result();
     foreach($rsY as $rowY){
        $total+=(($rowY->Comision0)+($rowY->Comision1)+($rowY->Comision2)+($rowY->Comision3)+($rowY->Comision4)+($rowY->Comision5)+($rowY->Comision6)+($rowY->Comision7)+($rowY->Comision8)+($rowY->Comision9))*$rowY->TCDay;
     }
  }else{
    $sqlY="SELECT c.*,(c.TCPago) as TCDay FROM cobranza_efectuada c WHERE RamosNombre!='Fianzas'AND MONTH(FechaDocto)=MONTH(FDoctoPago) AND YEAR(FechaDocto)=YEAR(FDoctoPago)";
     $rsY=$this->db->query($sqlY)->result();
     foreach($rsY as $rowY){
        $total+=(($rowY->Comision0)+($rowY->Comision1)+($rowY->Comision2)+($rowY->Comision3)+($rowY->Comision4)+($rowY->Comision5)+($rowY->Comision6)+($rowY->Comision7)+($rowY->Comision8)+($rowY->Comision9))*$rowY->TCDay;
     }
  }
  return $total;
}


//******************

function getTodaCobranzaCountRecibos($tipo){
  if($tipo==1){
    //$sql="SELECT COUNT(*) AS total FROM cobranza_toda WHERE RamosNombre='Fianzas'";
    $sql="SELECT (COUNT(*)+ (SELECT COUNT(*) FROM cobranza_efectuada WHERE RamosNombre='Fianzas' )) AS total FROM cobranza_toda WHERE RamosNombre='Fianzas' AND Status_TXT NOT IN   ('Liquidado','Pagado')";
  }else{
     //$sql="SELECT COUNT(*) AS total FROM cobranza_toda WHERE RamosNombre!='Fianzas'";
    $sql="SELECT (COUNT(*)+ (SELECT COUNT(*) FROM cobranza_efectuada WHERE RamosNombre!='Fianzas' )) AS total FROM cobranza_toda WHERE RamosNombre!='Fianzas' AND Status_TXT NOT IN   ('Liquidado','Pagado')";
  }
  $rs=$this->db->query($sql)->result();
  return $rs[0]->total;
}

function getTodaCobranzaPrimaNeta($tipo){
  if($tipo==1){
    //$sql="SELECT SUM(PrimaNeta) AS total FROM cobranza_toda WHERE RamosNombre='Fianzas'";
      $sql="SELECT (SUM(PrimaNeta)+ (SELECT if(SUM(PrimaNeta) is null,0,SUM(PrimaNeta)) FROM cobranza_efectuada WHERE RamosNombre='Fianzas' )) AS total FROM cobranza_toda WHERE RamosNombre='Fianzas' AND Status_TXT NOT IN   ('Liquidado','Pagado')";
  }else{
     //$sql="SELECT SUM(PrimaNeta) AS total FROM cobranza_toda WHERE RamosNombre!='Fianzas'";
        $sql="SELECT (SUM(PrimaNeta)+ (SELECT if(SUM(PrimaNeta) is null,0,SUM(PrimaNeta)) FROM cobranza_efectuada WHERE RamosNombre!='Fianzas' )) AS total FROM cobranza_toda WHERE RamosNombre!='Fianzas' AND Status_TXT NOT IN   ('Liquidado','Pagado')";

  }
  $rs=$this->db->query($sql)->result();
  return $rs[0]->total;
}

function getCobranzaComision($tipo){
  $total=0;
  if($tipo==1){
     //$sqlY="SELECT * FROM cobranza_toda WHERE RamosNombre='Fianzas'";
    $sqlY="SELECT Comision0,Comision1,Comision2,Comision3,Comision4,Comision5,Comision6,Comision7,Comision8,Comision9,TCDay 
FROM cobranza_toda 
WHERE RamosNombre='Fianzas' 
UNION 
SELECT Comision0,Comision1,Comision2,Comision3,Comision4,Comision5,Comision6,Comision7,Comision8,Comision9,(TCPago) AS TCDay 
FROM cobranza_efectuada WHERE RamosNombre='Fianzas'";
     $rsY=$this->db->query($sqlY)->result();
     foreach($rsY as $rowY){
        $total+=(($rowY->Comision0)+($rowY->Comision1)+($rowY->Comision2)+($rowY->Comision3)+($rowY->Comision4)+($rowY->Comision5)+($rowY->Comision6)+($rowY->Comision7)+($rowY->Comision8)+($rowY->Comision9))*$rowY->TCDay;
     }
  }else{
    //$sqlY="SELECT * FROM cobranza_toda WHERE RamosNombre!='Fianzas'";
        $sqlY="SELECT Comision0,Comision1,Comision2,Comision3,Comision4,Comision5,Comision6,Comision7,Comision8,Comision9,TCDay 
FROM cobranza_toda 
WHERE RamosNombre!='Fianzas' 
UNION 
SELECT Comision0,Comision1,Comision2,Comision3,Comision4,Comision5,Comision6,Comision7,Comision8,Comision9,(TCPago) AS TCDay 
FROM cobranza_efectuada WHERE RamosNombre!='Fianzas'";
     $rsY=$this->db->query($sqlY)->result();
     foreach($rsY as $rowY){
        $total+=(($rowY->Comision0)+($rowY->Comision1)+($rowY->Comision2)+($rowY->Comision3)+($rowY->Comision4)+($rowY->Comision5)+($rowY->Comision6)+($rowY->Comision7)+($rowY->Comision8)+($rowY->Comision9))*$rowY->TCDay;
     }
  }
  return $total;
}

//Desgloces*************

function getTodaCobranza(){
 
  $sql="SELECT IDRecibo,Documento,Periodo,Serie,renovacion,FDesde ,FHasta,FLimPago,Status_TXT,PrimaNeta,Grupo,SubGrupo,VendNombre,
Nombre_Companía,RamosNombre,SRamoNombre
FROM cobranza_toda WHERE RamosNombre!='Fianzas' AND Status_TXT NOT IN ('Liquidado','Pagado')
  UNION 
SELECT IDRecibo,Documento,Periodo,Serie,renovacion,FDesde ,FHasta,FLimPago,Status_TXT,PrimaNeta,Grupo,SubGrupo,VendNombre,
Nombre_Companía,RamosNombre,SRamoNombre
FROM cobranza_efectuada WHERE RamosNombre!='Fianzas'";
// $sql="SELECT * FROM cobranza_toda WHERE RamosNombre!='Fianzas'";

$datos=$this->db->query($sql)->result();
//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($datos, TRUE));fclose($fp);
  return $datos;
}
function getTodaCobranzaEstado($estado){
   //$sql="SELECT COUNT(*) as total FROM cobranza_toda WHERE RamosNombre!='Fianzas' and Status_TXT='$estado'";
  if($estado=='Pagado' || $estado=="Liquidado")
  {
   $sql="SELECT COUNT(*) as total FROM cobranza_efectuada WHERE RamosNombre!='Fianzas' and Status_TXT='$estado'";
  }
  else
  {
   $sql="SELECT COUNT(*) as total FROM cobranza_toda WHERE RamosNombre!='Fianzas' and Status_TXT='$estado'"; 
  }
   $rs=$this->db->query($sql)->result();
   return $rs[0]->total;
}
function getTodaCobranzaF(){
 
    $sql="SELECT IDRecibo,Documento,Periodo,Serie,renovacion,FDesde ,FHasta,FLimPago,Status_TXT,PrimaNeta,Grupo,SubGrupo,VendNombre,
Nombre_Companía,RamosNombre,SRamoNombre,FDoctoPago
FROM cobranza_toda WHERE RamosNombre='Fianzas' AND Status_TXT NOT IN ('Liquidado','Pagado')
  UNION 
SELECT IDRecibo,Documento,Periodo,Serie,renovacion,FDesde ,FHasta,FLimPago,Status_TXT,PrimaNeta,Grupo,SubGrupo,VendNombre,
Nombre_Companía,RamosNombre,SRamoNombre,FDoctoPago
FROM cobranza_efectuada WHERE RamosNombre='Fianzas'";
 //$sql="SELECT * FROM cobranza_toda WHERE RamosNombre='Fianzas'";

   $rs=$this->db->query($sql)->result();
  return $this->db->query($sql)->result();
}

function getTodaCobranzaEstadoF($estado){
   $sql="SELECT COUNT(*) as total FROM cobranza_toda WHERE RamosNombre='Fianzas' and Status_TXT='$estado'";

  if($estado=='Pagado' || $estado=="Liquidado")
  {
   $sql="SELECT COUNT(*) as total FROM cobranza_efectuada WHERE RamosNombre='Fianzas' and Status_TXT='$estado'";
  }
  else
  {
  $sql="SELECT COUNT(*) as total FROM cobranza_toda WHERE RamosNombre='Fianzas' and Status_TXT='$estado'";
  }

   $rs=$this->db->query($sql)->result();
   return $rs[0]->total;
}



function getEfectuadaCobranza(){
   //$sql="SELECT * FROM cobranza_toda WHERE RamosNombre!='Fianzas' AND Status_TXT='Pagado' OR  RamosNombre!='Fianzas' AND Status_TXT='Liquidado'";
  $sql="SELECT * FROM cobranza_efectuada WHERE RamosNombre!='Fianzas' ";
    return $this->db->query($sql)->result();
}

function geTotalEfectuada(){
    //$sql="SELECT COUNT(*) as total FROM cobranza_toda WHERE RamosNombre!='Fianzas' AND Status_TXT='Pagado' OR RamosNombre!='Fianzas' AND Status_TXT='Liquidado' ";
  $sql="SELECT COUNT(*) as total FROM cobranza_efectuada WHERE RamosNombre!='Fianzas'";
   $rs=$this->db->query($sql)->result();
   return $rs[0]->total;
}

function getEfectuadaCobranzaF(){
   //$sql="SELECT * FROM cobranza_toda WHERE RamosNombre='Fianzas' AND Status_TXT='Pagado' OR RamosNombre='Fianzas' AND Status_TXT='Liquidado'";
    $sql="SELECT * FROM cobranza_efectuada WHERE RamosNombre='Fianzas' ";
    return $this->db->query($sql)->result();
}
function geTotalEfectuadaF(){
    //$sql="SELECT COUNT(*) as total FROM cobranza_toda WHERE RamosNombre='Fianzas' AND Status_TXT='Pagado' OR  RamosNombre='Fianzas' AND Status_TXT='Liquidado'" ;
   $sql="SELECT COUNT(*) as total FROM cobranza_efectuada WHERE RamosNombre='Fianzas'";
   $rs=$this->db->query($sql)->result();
   return $rs[0]->total;
}

//Cargo a Tarjeta
function getCobranzaCAT($institucional){
   if($institucional==1){
    $sql="SELECT COUNT(*) AS total FROM cobranza_toda WHERE GerenciaNombre='INSTITUCIONAL' AND Status_TXT='Pendiente' AND CCobro_TXT='Tarjeta de Credito'";
   }else{
      $sql="SELECT COUNT(*) AS total FROM cobranza_toda WHERE GerenciaNombre!='INSTITUCIONAL' AND Status_TXT='Pendiente' AND CCobro_TXT='Tarjeta de Credito'";
   }
   $rs=$this->db->query($sql)->result();
   return $rs[0]->total;
}


//Recibos en Tiempo
function getTiempo($tipo){
   $contador_atrasadas=0;
   $contador_pendientes=0;
   $contador_por_vencer=0;
   //Agente
if($tipo==1){
   $sql="SELECT * FROM cobranza_toda WHERE GerenciaNombre!='INSTITUCIONAL' AND Status_TXT='Pendiente'";
   $rsAgente=$this->db->query($sql)->result();
   foreach($rsAgente as $rowAgente){
      $aa=date("d-m-Y", strtotime((String)$rowAgente->FLimPago));
      $bb=date("d-m-Y");
      $cc=(int)$aa-(int)$bb;
      if($cc <= -10){  
          $contador_atrasadas++;
      }
      elseif($cc >-10 && $cc<=6){
          $contador_pendientes++;
      }
      elseif($cc > 6){
          $contador_por_vencer++;
      }
   }
   //Institucional
}else{
   $sql="SELECT * FROM cobranza_toda WHERE GerenciaNombre='INSTITUCIONAL' AND Status_TXT='Pendiente'";
   $rsIntitucional=$this->db->query($sql)->result();
   foreach($rsIntitucional as $rowInstitucional){
      $aa=date("d-m-Y", strtotime((String)$rowInstitucional->FLimPago));
      $bb=date("d-m-Y");
      $cc=(int)$aa-(int)$bb;
      if($cc <= -10){  
          $contador_atrasadas++;
      }
      elseif($cc >-10 && $cc<=6){
          $contador_pendientes++;
      }
      elseif($cc > 6){
          $contador_por_vencer++;
      }
   }
}
   $this->data['pendientes']=$contador_pendientes;
   $this->data['vencidas']=$contador_atrasadas;
   return $this->data;
}

//Total Semaforo
function getSemaforo(){
   $contador_atrasadas=0;
   $contador_pendientes=0;
   $contador_por_vencer=0;
   $sql="SELECT * FROM cobranza_toda WHERE  Status_TXT='Pendiente'";
   $rs=$this->db->query($sql)->result();
   foreach($rs as $row){
      $aa=date("d-m-Y", strtotime((String)$row->FLimPago));
      $bb=date("d-m-Y");
      $cc=(int)$aa-(int)$bb;
      if($cc <= -10){  $contador_atrasadas++;}
      elseif($cc >-10 && $cc<=6){$contador_pendientes++;}
      elseif($cc > 6){$contador_por_vencer++;}
   }
   $this->data['vencidas']=$contador_atrasadas;
   $this->data['pendientes']=$contador_pendientes;
   $this->data['entiempo']=$contador_por_vencer;
   return $this->data;
}


//Actualizar datos kpi

function CobranzaPendiente($fdesde,$hasta){
  
//limpiar tablas



set_time_limit(0);
$array['fechaInicial']=$fdesde;
$array['fechaFinal']=$hasta;
$array['tipoReporte']='todos';
//$array['filtroStatus']=[0,1,2,5];
$array['tipoFecha']='FLimPago';//(FDesde,FHasta,FLimPago,FGeneracion,FStatus)/
//$array['filtroStatus']=[-1];
$array['filtroStatus']=[0,1];
  
//[1,2,3,4,5];/0(COBRANZA PENDIENTE),1(COBRANZA CANCELADA),3(COBRANZA EFECTUADA/PAGADO),4(LIQUIDADO),-1(TODOS)/
//Toda la Cobranza (Pendiente,Cancelado,Liquidado)
$result=0;
//$respuesta='';
$respuesta=$this->ws_sicas->recibosClientes($array); 
//Toda la Cobranza (PENDIENTE, CANCELADO, LIQUIDADO, PAGADO)
//$respuesta['error']=0;
if(array_key_exists("TableInfo", $respuesta))
{
  $del_cobranza_toda="DELETE FROM cobranza_toda";
$this->db->query($del_cobranza_toda); 
  foreach($respuesta->TableInfo as $datosSicas){
    if((String)$datosSicas->Grupo != "GRUPO CER"){
        //echo json_encode($datosSicas);
        $IDRecibo=$datosSicas->IDRecibo; 
        $Documento=$datosSicas->Documento; 
        $Periodo=$datosSicas->Periodo; 
        $Serie=$datosSicas->Serie; 
        $Renovacion=$datosSicas->Renovacion; 
        $FDesde=$datosSicas->FDesde; 
        $FHasta=$datosSicas->FHasta; 
        $FLimPago=$datosSicas->FLimPago; 
        $Status_TXT=$datosSicas->Status_TXT; 
        $PrimaNeta=$datosSicas->PrimaNeta; 
        $Comision0=$datosSicas->Comision0; 
        $Comision1=$datosSicas->Comision1; 
        $Comision2=$datosSicas->Comision2; 
        $Comision3=$datosSicas->Comision3; 
        $Comision4=$datosSicas->Comision4; 
        $Comision5=$datosSicas->Comision5;
        $Comision6=$datosSicas->Comision6;
        $Comision7=$datosSicas->Comision7;
        $Comision8=$datosSicas->Comision8;
        $Comision9=$datosSicas->Comision9;
        $Grupo=$datosSicas->Grupo; 
        $SubGrupo=$datosSicas->SubGrupo; 
        $VendNombre=$datosSicas->VendNombre; 
        $Nombre_Companía=$datosSicas->CiaNombre; 
        $Moneda=$datosSicas->Moneda; 
        $RamosNombre=$datosSicas->RamosNombre; 
        $SRamoNombre=$datosSicas->SRamoNombre; 
        $FCapturaDocto=$datosSicas->FCapturaDocto; 
        $TCDay=$datosSicas->TCDay;
        $GerenciaNombre=$datosSicas->GerneciaNombre;
        $CCobro_TXT=$datosSicas->CCobro_TXT;
        $FDoctoPago=$datosSicas->FDoctoPago;
                  $sql_toda="INSERT INTO cobranza_toda(IDRecibo, Documento, Periodo, Serie, Renovacion, FDesde, FHasta, FLimPago, Status_TXT, PrimaNeta, Comision0, Comision1, Comision2, Comision3, Comision4, Comision5, Comision6, Comision7, Comision8, Comision9, Grupo, SubGrupo, VendNombre, Nombre_Companía, Moneda, RamosNombre, SRamoNombre, FCapturaDocto,TCDay,GerenciaNombre,CCobro_TXT,FDoctoPago)VALUES('$IDRecibo', '$Documento', '$Periodo', '$Serie', '$Renovacion', '$FDesde', '$FHasta', '$FLimPago', '$Status_TXT', '$PrimaNeta', '$Comision0', '$Comision1', '$Comision2', '$Comision3','$Comision4', '$Comision5', '$Comision6', '$Comision7', '$Comision8', '$Comision9', '$Grupo', '$SubGrupo', '$VendNombre', '$Nombre_Companía', '$Moneda', '$RamosNombre', '$SRamoNombre', '$FCapturaDocto','$TCDay','$GerenciaNombre','$CCobro_TXT','$FDoctoPago')";
        $this->db->query($sql_toda);

      }
    }
  }
  else{$result=1;}

  //Efectuada
$array['filtroStatus']=[3,4];
  //$array['filtroStatus']=['A'];
$array['tipoFecha']='FDocto';
//$array['fechaFinal']='12-01-2023';
$array['fechaFinal']=$hasta;
$respuesta=$this->ws_sicas->recibosClientes($array); 
                 
if(array_key_exists("TableInfo", $respuesta))
{ 
  $del_cobranza_efectuada="DELETE FROM cobranza_efectuada";
  $this->db->query($del_cobranza_efectuada);  
  foreach($respuesta->TableInfo as $datosSicas){
    if((String)$datosSicas->Grupo != "GRUPO CER"){
        //echo json_encode($datosSicas);
        $IDRecibo=$datosSicas->IDRecibo; 
        $Documento=$datosSicas->Documento; 
        $Periodo=$datosSicas->Periodo; 
        $Serie=$datosSicas->Serie; 
        $Renovacion=$datosSicas->Renovacion; 
        $FDesde=$datosSicas->FDesde; 
        $FHasta=$datosSicas->FHasta; 
        $FLimPago=$datosSicas->FLimPago; 
        $Status_TXT=$datosSicas->Status_TXT; 
        $PrimaNeta=$datosSicas->PrimaNeta; 
        $Comision0=$datosSicas->Comision0; 
        $Comision1=$datosSicas->Comision1; 
        $Comision2=$datosSicas->Comision2; 
        $Comision3=$datosSicas->Comision3; 
        $Comision4=$datosSicas->Comision4; 
        $Comision5=$datosSicas->Comision5;
        $Comision6=$datosSicas->Comision6;
        $Comision7=$datosSicas->Comision7;
        $Comision8=$datosSicas->Comision8;
        $Comision9=$datosSicas->Comision9;
        $Grupo=$datosSicas->Grupo; 
        $SubGrupo=$datosSicas->SubGrupo; 
        $VendNombre=$datosSicas->VendNombre; 
        $Nombre_Companía=$datosSicas->CiaNombre; 
        $Moneda=$datosSicas->Moneda; 
        $RamosNombre=$datosSicas->RamosNombre; 
        $SRamoNombre=$datosSicas->SRamoNombre; 
        $FCapturaDocto=$datosSicas->FCapturaDocto; 
        $TCPago=$datosSicas->TCDay;
        $GerenciaNombre=$datosSicas->GerneciaNombre;
        $CCobro_TXT=$datosSicas->CCobro_TXT;
        $FechaDocto=$datosSicas->FechaDocto;
        $FDoctoPago=$datosSicas->FechaPago;
                  $sql_toda="INSERT INTO cobranza_efectuada(IDRecibo, Documento, Periodo, Serie, Renovacion, FDesde, FHasta, FLimPago, Status_TXT, PrimaNeta, Comision0, Comision1, Comision2, Comision3, Comision4, Comision5, Comision6, Comision7, Comision8, Comision9, Grupo, SubGrupo, VendNombre, Nombre_Companía, Moneda, RamosNombre, SRamoNombre, FCapturaDocto,TCPago,GerenciaNombre,CCobro_TXT,FechaDocto,FDoctoPago)VALUES('$IDRecibo', '$Documento', '$Periodo', '$Serie', '$Renovacion', '$FDesde', '$FHasta', '$FLimPago', '$Status_TXT', '$PrimaNeta', '$Comision0', '$Comision1', '$Comision2', '$Comision3','$Comision4', '$Comision5', '$Comision6', '$Comision7', '$Comision8', '$Comision9', '$Grupo', '$SubGrupo', '$VendNombre', '$Nombre_Companía', '$Moneda', '$RamosNombre', '$SRamoNombre', '$FCapturaDocto','$TCPago','$GerenciaNombre','$CCobro_TXT','$FechaDocto','$FDoctoPago')";
 
        $this->db->query($sql_toda);
      }
    }
  }
  else{$result=2;}
  return $result;

}

//FIN DE LA CLASE
}