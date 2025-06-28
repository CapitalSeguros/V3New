<?php
class Clientemodelo extends CI_Model {
	public function __construct() {
     parent::__construct();
   $this->load->database();
 }
 public function verificaExistenciaCliente($IDCli){ $consulta="select IDCli from clientelealtadpuntos where IDCli=".$IDCli;
 $datos=$this->db->query($consulta)->result();
  if(count($datos)>0){return 1;}else{return 0;}
 }
 //-------------------------------------------------------------------
 public function obtenerCliente($IDCli){
 	$consulta="select idContacto from clientelealtadpuntos where IDCli=".$IDCli;
 	return $this->db->query($consulta)->result();
 }
 //-------------------------------------------------------------------
public function actualizarCliente($IDCli,$array){
	$this->db->where('IDCli',$IDCli);
	$this->db->update('clientelealtadpuntos',$array);

}
//--------------------------------------------------------------------
public function insertarCliente($array)
{

	if(isset($array['IDCli']))
    {
      if(isset($array['IDVend']))
      {
        if(isset($array['EMail1']))
        {
          if($array['EMail1']!=''){
         if($array['IDVend']>0 && $array['IDVend']<10000)
        {
         $consultIdvalida=$this->db->query('select IDValida from user_miInfo u where u.IDVend='.$array['IDVend'])->result();
         if(count($consultIdvalida)==1)
         {
           $texto='<p>Tenemos un compromiso contigo y nuestros accionistas de brindar un servicio y un nivel de asesoría de excelencia, motivo por el cual agradecemos nos apoyes haciendo una valoración al asesor que te atendió, muchas gracias</p>';
           $texto.='<a href="'.base_url().'validarinformacion/calificaElCliente?dato='.$consultIdvalida[0]->IDValida.'">IR A CALIFICAR</a>';
           $guardaMensaje['desde']="Avisos de GAP<avisosgap@aserorescpital.com>";
           $guardaMensaje['para']=$array['EMail1'];
           $guardaMensaje['asunto']="Califica a nuestros agentes";
           $guardaMensaje['mensaje']=$texto;
           $guardaMensaje['status']=0;
           $guardaMensaje['identificaModulo']='clientelealtadpuntos-'.$array['IDCli'];
           
          $this->db->insert('envio_correos',$guardaMensaje);
         }
        } 
        } 
       }       
      }
      $this->db->insert('clientelealtadpuntos',$array);
    }
}
//--------------------------------------------------------------------
public function guardarClienteVerifica($array){
	$this->db->insert('clienteverificar',$array);
}

//--------------------------------------------------------------------
public function obtenerClientesActualizar()
{
	/*SE OBTIENEN LOS CLIENTES QUE SE LE HAN MODIFICADO SUS DATOS PARA VARIFICAR LOS DATOS */
	return $this->db->query('select cv.*,clp.Nombre,clp.ApellidoP,clp.ApellidoM,clp.EMail1,clp.Telefono1,clp.NombreCompleto from clienteverificar cv 
left join clientelealtadpuntos clp on clp.IDCli=cv.IDCli
where statusComprobacion=0')->result();
}
//-----------------------------------------------
//--------------------------------------------------------------------
public function obtenerClienteDeActualizar($idClienteVerificar)
{
	/*SE OBTIENEN LOS CLIENTES QUE SE LE HAN MODIFICADO SUS DATOS PARA VARIFICAR LOS DATOS */
	return $this->db->query('select * from clienteverificar cv 
where idClienteVerificar='.$idClienteVerificar)->result();
}
//-----------------------------------------------
public function cancelarActualizacion($idClienteVerificar,$array){
  $this->db->where('idClienteVerificar',$idClienteVerificar);
  $this->db->update('clienteverificar',$array);
}
//-----------------------------------------------
public function obtenerDatosCliente($IDCli){
	$consulta="select * from clientelealtadpuntos where IDCli=".$IDCli;
	return $this->db->query($consulta)->result();

}
//---------------------------------------------
public function clientes_actualiza($array){
	$datos="";$bandera=0;

	do
	{
	 if(isset($array['IDCli']))
	 {
      if($array['IDCli']==-1)
      {
      	unset($array['IDCli']);
      	unset($array['update']);
      	if(!isset($array['Usuario'])){$array['Usuario']=$this->tank_auth->get_usermail();}
      	$this->db->insert('clientes_actualiza',$array);
      	$array['IDCli']=$this->db->insert_id();
      }
      else
      {
        if(isset($array['update']))
        {
        	unset($array['update']);
        	$this->db->where('IDCli',$array['IDCli']);
        	$this->db->update('clientes_actualiza',$array);        
        }
        else
        {	
          $consulta='select * from clientes_actualiza where IDCli='.$array['IDCli'];           
          $datos=$this->db->query($consulta)->result();
          $bandera=1;
        }
      }
	}
	else
	{
     $consulta='select * from clientes_actualiza where Usuario="'.$this->tank_auth->get_usermail().'"';
     $datos=$this->db->query($consulta)->result();
     $bandera=1;
	}
  }while($bandera==0);

	return $datos;
}
//---------------------------------------------

function clientesConDetalle(){
	$consulta="select (if(clp.EMail1 is null || clp.EMail1='','classEmailVacio',if(locate('@',clp.EMail1)=0 ,'classEmailSF','classEmailDeAgente'))) as detalle,clp.* from clientelealtadpuntos clp  
	    left join users u on u.email=clp.EMail1
where (clp.EMail1 is null or clp.EMail1='' or locate('@',clp.EMail1)=0 or u.email is not null) and clp.idPersonaAgente=254
order by detalle";
return $this->db->query($consulta)->result();
}
//----------------------------------------------
function eliminarClienteNuevo($array){

	$this->db->where("IDCli", $array["IDCli"]);
	$this->db->where("canal", $array["canal"]);
	$this->db->where("mes", $array["mes"]);
	$query = $this->db->delete("clientes_nuevos");

	return $query;
}
//----------------------------------------------
function insertarClienteNuevo($array){

	$this->db->insert("clientes_nuevos", $array);
}
//----------------------------------------------
function devuelveClientesNuevos($condition){

	if(!empty($condition)){
		$this->db->where($condition);
	}

	$query = $this->db->get("catalog_clientes_nuevos a");

	return $query->num_rows() > 0 ? $query->result() : array();
}
//----------------------------------------------
//Dennis Castillo [2021-12-28]
function getClients($name){

	$query = $this->db->like("NombreCompleto", strtoupper($name))
			->get("clientelealtadpuntos");

	return $query->num_rows() > 0 ? $query->result() : array();
}
//----------------------------------------------
//Dennis Castillo [2021-12-28]
function insertRecordSafely($array, $table){

	$response = array(
		"status" => false,
		"lastId" => 0
	);

	$this->db->trans_begin();
	$this->db->insert($table, $array);
	$response["lastId"] = $this->db->insert_id();

	if($this->db->trans_status() === FALSE){
		$this->db->trans_rollback();
	} else{
		$this->db->trans_commit();
		$response["status"] = true;
	}

	return $response;
}
//----------------------------------------------
//Dennis Castillo [2021-12-28]
function insertMultipleRecordSafely($arrayBatch, $table){

	$response = array(
		"status" => false,
		//"lastId" => 0
	);

	$this->db->trans_begin();
	$this->db->insert_batch($table, $arrayBatch);
	//$response["lastId"] = $this->db->insert_id();

	if($this->db->trans_status() === FALSE){
		$this->db->trans_rollback();
	} else{
		$this->db->trans_commit();
		$response["status"] = true;
	}

	return $response;
}
//----------------------------------------------
//Dennis Castillo [2021-12-28]
function getUnifications(){

	$query = $this->db->select("*")
			->from("client_unification_block a")
			->join("client_unifications b", "a.id = b.blockNum", "left")
			//->join("client_ramification c", "a.id = c.blockNum", "left")
			->join("(SELECT IDCli, NombreCompleto FROM clientelealtadpuntos) d", "b.clientID = d.IDCli", "left")
			->get();

	return $query->num_rows() > 0 ? $query->result() : array();
}
//----------------------------------------------
//Dennis Castillo [2021-12-28]
function getRamifications($id){

	$query = $this->db->where("blockNum", $id)
			->get("client_ramification");
	
	return $query->num_rows() > 0 ? $query->result() : array();
}
//----------------------------------------------
//Dennis Castillo [2021-12-28]
function deleteBlockSafely($id){

	$response = false;

	$this->db->trans_begin();
	$this->db->delete('client_unification_block', array('id' => $id));
	$this->db->delete(array("client_unifications", "client_ramification"), array('blockNum' => $id));

	if($this->db->trans_status() === FALSE){
		$this->db->trans_rollback();
	} else{
		$this->db->trans_commit();
		$response = true;
	}

	return $response;
}
//---------------------------------------------
//Dennis Castillo [2021-12-28]
function getAssociatedClients($client){

	$query = $this->db->select('DISTINCT(a.clientID), b.NombreCompleto', false)
					->join("clientelealtadpuntos b", "a.clientID = b.IDCli", "inner")
					->where('blockNum IN (SELECT blockNum FROM client_unifications WHERE clientID = '.$client.')')
					->get("client_unifications a");

	return $query->num_rows() > 0 ? $query->result() : array();
}
//---------------------------------------------
function bitacoraclientesactualizacionInsertar($IDCli,$IDCont,$newValue,$oldValue)
{
   $insert['IDCli']=$IDCli;
   $insert['IDCont']=$IDCont;
   $insert['emailUser']=$this->tank_auth->get_usermail();
   $insert['oldValue']=json_encode($oldValue);
   $insert['newValue']=json_encode($newValue);
   $this->db->insert('bitacoraclientesactualizacion',$insert);
 
}
//---------------------------------------------
}