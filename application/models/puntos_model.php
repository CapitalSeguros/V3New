<?php
class Puntos_model extends CI_Model {
//llamamos al constructor de la clase padre
	public function __construct() {
     parent::__construct();
   $this->load->database();
 }
 public function ver(){
 	$consulta= $this->db->query("SELECT * FROM punto where statusPunto=1");
 	return $consulta->result();
 }
//---------------------------------------------------
 public function add($dato1,$dato2){
 	$consulta = $this->db->query("SELECT tipo FROM punto WHERE tipo LIKE '$dato1'");
 	if($consulta->num_rows() == 0)
 	{
 	 $insert['tipo']= $dato1;
 	 $insert['punto']= $dato2;
 	 $consulta = $this->db->insert('punto',$insert);
 	}

 	if($consulta == true){ return true;}
 }
//------------------------------------------------------
 public function mod($idpunto,$dato1="NULL",$dato2="NULL",$modificar="NULL")
  {
   
   if($modificar == "NULL")
   {
    $consulta = $this->db->query("SELECT * FROM punto WHERE idpunto = $idpunto");
    return $consulta->result();
   }
   else{$consulta = $this->db->query("UPDATE punto SET tipo='$dato1', punto='$dato2' WHERE idpunto=$idpunto;");  }
  }  
//--------------------------------------------------------
  public function eliminar($idpunto)
  {
    $consulta = $this->db->query("update  punto set statusPunto=0 where idpunto=$idpunto;");
    if($consulta == true){	return true;}
    else{return false;}

  }
//--------------------------------------------------------
function verificaExistenciaClientPunto($IDCli){
 $consulta="select IDCli from clientelealtadpuntos where IDCli=".$IDCli;
 $datos=$this->db->query($consulta)->result();
 
  if(count($datos)>0){return 1;}else{return 0;}
}
//--------------------------------------------------------
function insertaClienteEnPunto($IDCli,$PUNTOS,$idPersona){
 $insert['IDCli']=$IDCli;
 $insert['PUNTOS']=$PUNTOS;
 $insert['idPersonaAgente']=$idPersona;
 $this->db->insert('clientelealtadpuntos',$insert);
}
//--------------------------------------------------------
function sumaPuntos($IDCli,$PUNTOS,$idPersona){
  if($PUNTOS<0){$update="update clientelealtadpuntos set PUNTOS=PUNTOS".$PUNTOS.",idPersonaAgente=".$idPersona." where IDCli=".$IDCli;}
  else{$update="update clientelealtadpuntos set PUNTOS=PUNTOS+".$PUNTOS.",idPersonaAgente=".$idPersona." where IDCli=".$IDCli;}
  
  $this->db->query($update);
}   
//--------------------------------------------------------
function actualizarNombreCliente($IDCli,$nombreCliente){
  $update='update clientelealtadpuntos set nombreCliente="'.$nombreCliente.'" where IDCli='.$IDCli;
   $this->db->query($update);
}
//--------------------------------------------------------
function obtenerPuntosDeLosClientes($idPersona){
  $datos=array();
  if($idPersona==null){$consulta="select (if(clp.NombreCompleto is null,nombreCliente,NombreCompleto)) as nombre,(if(clp.PUNTOS is null,0,clp.PUNTOS)) as puntosObtenidos,clp.*,cr.clienteRanking from clientelealtadpuntos clp left join clienteranking cr on cr.idClienteRanking=clp.idClienteRanking order by nombre";}
  else{$consulta="select (if(clp.NombreCompleto is null,nombreCliente,NombreCompleto)) as nombre,(if(clp.PUNTOS is null,0,clp.PUNTOS)) as puntosObtenidos,clp.*,cr.clienteRanking from clientelealtadpuntos clp left join clienteranking cr on cr.idClienteRanking=clp.idClienteRanking where idPersonaAgente=".$idPersona.' order by nombre'; 
 $datos=$this->db->query($consulta)->result();
}

  return $datos;
}
//--------------------------------------------------------
function guardarEnBitacora($datos)
{ $this->db->insert('clientelealtadbitacora',$datos);  }
//--------------------------------------------------------
function obtenerPuntosCanjeados($idCliente)
{
  $consulta="select ta.nombre,clb.cantPuntos,clb.cantArticulos,clb.PUNTOS,clb.folioTicket,cast(clb.fecha as date) as fecha from clientelealtadbitacora clb
left join tienda_articulos ta on ta.idArticulo=clb.idArticulo
where operacion=-1 and IDCli=".$idCliente;
  $consulta=$consulta.' order by fecha';
  return $this->db->query($consulta)->result();
}
//--------------------------------------------------------
public function obtenerCanjePorTicket($IDTicket){
  $consulta="select ta.nombre,clb.* from clientelealtadbitacora clb
left join tienda_articulos ta on ta.idArticulo=clb.idArticulo
where clb.folioTicket=".$IDTicket;
return $this->db->query($consulta)->result();
}
//--------------------------------------------------------
public function exportarBitacora(){
  set_time_limit(0);
  $consulta="select p.TIPO,clp.nombreCliente,ta.nombre,clb.* from clientelealtadbitacora clb left join tienda_articulos ta on ta.idArticulo=clb.idArticulo left join clientelealtadpuntos clp on clp.IDCli=clb.IDCli left join punto p on p.IDPUNTO=clb.idPromocionPunto";
  return $this->db->query($consulta)->result();
}
//--------------------------------------------------------

public function obtenerPuntosOtorgados($idCliente){
  $consulta='select p.TIPO, clb.cantPuntos,clb.cantArticulos,clb.PUNTOS,clb.folioTicket,cast(clb.fecha as date) as fecha,clb.FechaDocto,clb.FLimPago,clb.PrimaNeta,clb.Renovacion from clientelealtadbitacora clb
left join punto p on p.IDPUNTO=clb.idPromocionPunto
where operacion=1 and IDCli='.$idCliente;
  $consulta=$consulta.' order by fecha';
  return $this->db->query($consulta)->result();
}
//--------------------------------------------------------
function obtenerPuntosHistorial($idCliente){
  $consulta='select ta.nombre,p.TIPO,clb.* from clientelealtadbitacora clb
left join punto p  on p.IDPUNTO=clb.idPromocionPunto
left join tienda_articulos ta on ta.idArticulo=clb.idArticulo where clb.IDCli='.$idCliente.' order by clb.fecha';
  return $this->db->query($consulta)->result();


}
//--------------------------------------------------------
public function nombreCliente($IDCli){
  $consulta="select * from clientelealtadpuntos where IDCli=".$IDCli;
  return $this->db->query($consulta)->result();
}

//---------------------------------------------------------
function obtenerPuntosCliente($IDCli){
 
  $consulta="select PUNTOS from clientelealtadpuntos where IDCli=".$IDCli;
            $datos=$this->db->query($consulta)->result();
  return $datos;
 }
//--------------------------------------------------------
public function devuelveFolio(){
    $base2 = $this->load->database('db2', true);
         $consulta='CALL devuelvefolioticketlc();';
         $row=$base2->query($consulta)->result();
         return $row;
}
public function devolverPuntosAutomaticos(){
  $consulta='select * from punto where IDPUNTO<7 and statusPunto=1';
  return $this->db->query($consulta)->result();
}

//--------------------------------------------------------
public function productos(){
  $consulta="select * from tienda_articulos where puntos>0";
 return $this->db->query($consulta)->result(); 
  }
//--------------------------------------------------------
public function agregarRanking($array)
{
  $this->db->insert('clienteranking',$array);
} 
//--------------------------------------------------------
public function obtenerListaRanking(){
  $consulta="select * from clienteranking order by rango1";
   
 return  $this->db->query($consulta)->result();
}
//--------------------------------------------------------
public function modificarRanking($idClienteRanking,$array){
  $this->db->where('idClienteRanking',$idClienteRanking);
  $this->db->update('clienteranking',$array);
}
//--------------------------------------------------------
public function eliminarRanking($idClienteRanking){
  $this->db->where('idClienteRanking',$idClienteRanking);
  $this->db->delete('clienteranking');
}
//-------------------------------------------------------
public function traeBitacoraPuntos(){
  return $this->db->query("select (sum(PUNTOS)) as sumaPuntos,IDCli from clientelealtadbitacora
group by IDCli")->result();
}
//-------------------------------------------------------
public function actualizarClientes($IDCli,$array){
  $this->db->where('IDCli',$IDCli);
  $this->db->update('clientelealtadpuntos',$array);
}
//-------------------------------------------------------
public function asignaRankingFaltante($idClienteRanking){
  $consulta='update clientelealtadpuntos set idClienteRanking='.$idClienteRanking.' where idClienteRanking is null';
  $this->db->query($consulta);
}
//-------------------------------------------------------
public function inicializaRanking(){
    $consulta='update clientelealtadpuntos set idClienteRanking=null';
     $this->db->query($consulta); 
}
//-------------------------------------------------------

//-------------------------------------------------------
}

//--------------------------------------------------------
?>