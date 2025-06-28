<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class fechadepago extends CI_Model {
	var $funcionLlamar;
	var $datos;
//-----------------------------------------------------------------
	function __construct(){
		parent::__construct();     

	}

 public function DevueveFacturasinfechapago()
 {
      $consulta="select * from facturas f where f.fecha_pago is null";
    	
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
 public function DevulvePasivos($valor)
 {
    
    $consulta="select * 
                         from calificaencuesta where  activa =1
                        and   calificacion >=  70 and calificacion <  90 and idencuesta = '".$valor."'";
    
    $datos=$this->db->query($consulta)->result();
    return $datos;
 }
 public function DevulvePromotores($valor)
 {
    
    $consulta="select * 
                         from calificaencuesta where  activa =1
                        and   calificacion >=  90 and  idencuesta = '".$valor."'";
    
    $datos=$this->db->query($consulta)->result();
    return $datos;
 }

}	
?>