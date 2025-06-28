<?php
class fullcalendar_model extends CI_Model{

	
	public function __Construct(){
		parent::__Construct();
	}

//------------------------------------------------------------------------
function devuelveCitasActivasPorUsuarios(){
$citas= $this->db->query('select (titulo) as title,(fechaInicial) as start,(fechaFinal) as end,id from  citascalendar where emailEstado="A" and emailUsuario="'.$this->tank_auth->get_usermail().'"');
 return($citas->result());
}
//------------------------------------------------------------------------

function eliminaCita($id){
	$delete='update citascalendar set emailEstado="C" where id='.$id;
$resp=$this->db->query($delete);
return $resp;
}
//------------------------------------------------------------------------

function actualizaCita($id,$fi,$ff){
		$update='update citascalendar set fechaInicial="'.$fi.'",fechaFinal="'.$ff.'" where id='.$id;
		$resp=$this->db->query($update);

		return $resp;
}
//------------------------------------------------------------------------
function guardaCitaModulo($array){
	
 /*$insert="insert into citascalendar(emailUsuario,titulo,fechaInicial,fechaFinal,tabla,idTabla) values";	
 $insert=$insert.'("'.$this->tank_auth->get_usermail().'","'.$titulo.'","'.$fechaFormato.' '.$fi.':00","'.$fechaFormato.' '.$ff.':00","clientes_actualiza",'.$idTabla.')';*/
//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($array, TRUE));fclose($fp);
 $array['emailUsuario']=$this->tank_auth->get_usermail();

 $this->db->insert('citascalendar',$array);
 //$this->db->query($insert);
}

//------------------------------------------------------------------------
function guardaCitaModulo2($titulo,$fechaFormato,$fi,$ff,$tabla,$idTabla){

 $insert="insert into citascalendar(emailUsuario,titulo,fechaInicial,fechaFinal,tabla,idTabla) values";	
 $insert=$insert.'("'.$this->tank_auth->get_usermail().'","'.$titulo.'","'.$fechaFormato.' '.$fi.':00","'.$fechaFormato.' '.$ff.':00","clientes_actualiza",'.$idTabla.')';
 $this->db->query($insert);
}
//------------------------------------------------------------------------
//------------------------------------------------------------------------

}