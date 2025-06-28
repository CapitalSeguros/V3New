<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clientelealtadmodelo extends CI_Model {
	var $funcionLlamar;
	var $datos;
//-----------------------------------------------------------------
	function __construct(){
		parent::__construct();
     

	}

  public function borrarPromocionAgente($idPunto){
 
    $this->db->where('idPunto',1);
    $this->db->delete('clientelealtad');
  }

 //--------------------------------------------
 
public function guardarPromocionAgente($datos){
 $this->db->insert('clientelealtad',$datos);
}
//----------------------------------------------
public function buscaPromocionAgente($idPunto){
	//$consulta="select * from clientelealtad where idPunto=".$idPunto;
	$consulta="select persona.nombres,persona.apellidoPaterno,persona.apellidoMaterno,clientelealtad.idPersonaP
from clientelealtad
left join persona on persona.idPersona=clientelealtad.idPersonaP";
  $datos=$this->db->query($consulta)->result();
  return $datos;
}

public function antiguedadclientes($num){
   if($num == '1')
   {
    $consulta='select clb.IDCli ,min(clb.FechaDocto )as fecha,clp.nombreCliente as nombre from clientelealtadbitacora clb
     ,clientelealtadpuntos clp where clp.IDCli =clb.IDCli and clb.FechaDocto > DATE_ADD(curdate(),INTERVAL -3 YEAR)
      group by clb.IDCli';
   } 
  if($num == '2')
   {
    $consulta='select clb.IDCli ,min(clb.FechaDocto )as fecha,clp.nombreCliente as nombre from clientelealtadbitacora clb
         ,clientelealtadpuntos clp   where clp.IDCli =clb.IDCli and clb.FechaDocto < DATE_ADD(curdate(),INTERVAL -3 YEAR) AND 
             clb.FechaDocto > DATE_ADD(curdate(),INTERVAL -5 YEAR)
        group by clb.IDCli ';
   } 
   if($num == '3')
   {
    $consulta='select clb.IDCli ,min(clb.FechaDocto )as fecha,clp.nombreCliente as nombre from clientelealtadbitacora clb
        ,clientelealtadpuntos clp       where clp.IDCli =clb.IDCli and clb.FechaDocto < DATE_ADD(curdate(),INTERVAL -5 YEAR) AND 
              clb.FechaDocto > DATE_ADD(curdate(),INTERVAL -10 YEAR)
               group by clb.IDCli ';
   }
   if($num =='4')
   {
    $consulta='select clb.IDCli ,min(clb.FechaDocto )as fecha,clp.nombreCliente as nombre from clientelealtadbitacora clb
         ,clientelealtadpuntos clp      where clp.IDCli =clb.IDCli and clb.FechaDocto < DATE_ADD(curdate(),INTERVAL -10 YEAR) AND 
              clb.FechaDocto > DATE_ADD(curdate(),INTERVAL -15 YEAR)
               group by clb.IDCli';
   }
   if($num =='5')
   {
    $consulta='select clb.IDCli ,min(clb.FechaDocto )as fecha,clp.nombreCliente as nombre from clientelealtadbitacora clb
          ,clientelealtadpuntos clp     where clp.IDCli =clb.IDCli and clb.FechaDocto < DATE_ADD(curdate(),INTERVAL -15 YEAR)
               group by clb.IDCli';
   }
  
    $datos =$this->db->query($consulta);
    return $datos->result();

}

}