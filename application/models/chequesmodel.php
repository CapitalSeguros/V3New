<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class chequesModel extends CI_Model {
	var $funcionLlamar;
	var $datos;
//-----------------------------------------------------------------
	function __construct(){
		parent::__construct();
     

	}
//----------------------------------------------------
	public function TMovimiento(){
    $consulta='select * from tipomovimiento';
	$datos=$this->db->query($consulta)->result();
    return $datos;
 }

public function ConsulCheque($fecha){	
//$mes = date("m",$fecha);
//$ano = date("Y",$fecha)	;
//$newDate = date("d-m-Y", strtotime($fecha));	
//$consulta="select * from `cheques` where month(`FECHA`)=".$mes. " AND YEAR(`FECHA`)= ".$ano."
//order by `IDCHEQUE` desc";
//$consulta="select * from cheques where DATE(FECHA)= '".$fecha."'"; 
$dat = explode("-", $fecha);  
// echo $dat[1];
$fec=  $dat[0]."-".$dat[1]."-01";
$fec2 =  (int)$dat[0]-1;
$fec2 = (string)$fec2;
$fec2=  $fec2."-01-01";
$fec3=  $fec2."-12-31";
//echo $fec2;
$consulta="select B.descripcionbancos,ch.FECHA,ch.movimiento ,ch.concepto,ch.total
,COALESCE((SELECT SUM(ch1.total ) FROM cheques ch1 where 
(ch1.FECHA >= '".$fec."' AND ch1.FECHA < '".$fecha."') AND ch1.tipo ='DEPOSITO' AND ch1.bancos = B.descripcionbancos
 ),0.0) as ACUMES,
round(COALESCE((SELECT SUM(ch1.total ) FROM cheques ch1 where 
(ch1.FECHA >= '".$fec2."' AND ch1.FECHA < '2019/01/01') AND  ch1.bancos = B.descripcionbancos
 ),0.0),2) as ACUMANOPASADO,ch.tipo
 FROM bancos B 
left join cheques ch on ch.bancos = B.descripcionbancos and ch.FECHA ='".$fecha."'
AND ch.tipo ='DEPOSITO'";


$datos=$this->db->query($consulta);
// echo $this->db->last_query();exit();
         return $datos;
	}
//----------------------------------------------------
public function ConsulChequeEx($fecha){	
$dat = explode("-", $fecha);  
$fec=  $dat[0]."-".$dat[1]."-01";
$fec2 =  (int)$dat[0]-1;
$fec2 = (string)$fec2;
$fec2=  $fec2."-01-01";
$fec3=  $fec2."-12-31";
//echo $fec2;
$consulta="select ch.fecha  from bancos b
left join cheques ch on ch.bancos = b.descripcionbancos 
and ch.tipo ='DEPOSITO'";


$datos=$this->db->query($consulta);
 //echo $this->db->last_query();exit();
         return $datos;
	}
//----------------------------------------------------
public function ConsulPromotoria($idpro){	
$dat = $idpro; 
//echo $fec2;
$consulta="select Promotoria from catalog_promotorias where idPromotoria ='".$dat."'";
$datos=$this->db->query($consulta);
//foreach($datos as $variable){echo $variable->Promotoria;}
 //echo $this->db->last_query();exit();
         return $datos->Promotoria;
	}
//----------------------------------------------------
function cheques($array){

  	$salida=0;$seguridad=0;$datos="";
  	do{
    if(isset($array['IDCHEQUE']) )
    {
     if($array['IDCHEQUE']==-1)
     {
     	unset($array['IDCHEQUE']);
     	unset($array['update']);
     	$this->db->insert('cheques',$array);
     	$array['IDCHEQUE']=$this->db->insert_id();
     } 
     else
     {
     	if(isset($array['update']))
     	{
     	  unset($array['update']);
     	  if($array['IDCHEQUE']!=''){

          $this->db->where('IDCHEQUE',$array['IDCHEQUE']);
         $this->db->update('cheques',$array);
      
           }else{$salida=1;}
           	
     	}
     	else
     	{
          $this->db->where('IDCHEQUE',$array['IDCHEQUE']);
          $datos=$this->db->get('cheques')->result();
          $salida=1;
     	}
     }
    }
    else
    { 
    	//$where->db->where('Usuario',$this->tank_auth->get_usermail());
         $datos=$this->db->get('cheques')->result();        
         $salida=1;
    }
    $seguridad++;
    if($seguridad>4){$salida=1;}

  }while($salida==0);
  return $datos;

}

}