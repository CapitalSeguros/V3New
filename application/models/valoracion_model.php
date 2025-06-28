<?php
class valoracion_model  extends CI_Model  {

	public function __Construct(){
		parent::__Construct();
		
    }
//-----------------------------------------------------------
	function getTotalEstrellas($id){
		$sql="SELECT COUNT(e.id_punto) as total,p.descripcion as nombre FROM estrellas_calificacion_new as e, puntos_evaluacion as p WHERE e.id_user='$id' AND e.id_punto=p.id GROUP BY e.id_punto";
		return $this->db->query($sql)->result();
	}
//-----------------------------------------------------------	
	function getComentarios($id){
		$sql="SELECT * FROM comentarios WHERE id_user='$id' ORDER BY id DESC";
		return $this->db->query($sql)->result();
	}
//-----------------------------------------------------------
	function getPuntos(){

			$sql="SELECT * FROM puntos_evaluacion where id>0 ORDER BY id DESC ";
			return $this->db->query($sql)->result();
	}
//-----------------------------------------------------------
	function savePuntoValoracion($punto){
		$this->data=[
			"descripcion"=>$punto
		];
		$this->db->insert("puntos_evaluacion",$this->data);
		return $this->getPuntos();
	}
//-----------------------------------------------------------
	function delPuntoValoracion($id){
		$sql="DELETE FROM puntos_evaluacion WHERE id='$id'";
		$this->db->query($sql);
		return $this->getPuntos();
	}

	function total_estrellas($id_punto,$id_user){
		$total=0;
		$sql="SELECT count(id_punto) as total FROM estrellas_calificacion_new WHERE id_punto='$id_punto' AND id_user='$id_user'";
	    $result=$this->db->query($sql)->result();
	   
	    if ($result) {$total=$result[0]->total;}
	    return $total;
	}
//-----------------------------------------------------------
	function getCuantos($idPersona){
		 $query="SELECT total FROM estrellas_calificacion_voto WHERE id_user='$idPersona'";
		 $result=$this->db->query($query);
		 $row=$result->result();
		 $cuantos=0;
		 if($row){
		 	$cuantos=$row[0]->total;
		 }
		 return $cuantos;
	}
//-----------------------------------------------------------
	function getIniciales($nombre){
        if($nombre!=''){
            $P=explode(" ",$nombre);
            if(isset($P[1])){
                $n=$P[0];
                $a=$P[1];
                $n=substr($n,0,1);
                $a=substr($a,0,1);
                $nombre=$n.$a;
            }else{
                $nombre=substr($nombre,0,1);
            }
            return strtoupper($nombre);
        }else{
            return 'A';
        }
   }
//-----------------------------------------------------------

}?>