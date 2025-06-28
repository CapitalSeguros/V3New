<?php defined('BASEPATH') OR exit('No direct script access allowed');
class test_model extends CI_Model
{

    function getAllSiniestros(){
        $this->db->where('sr.tipo_r <>','S');
        $obj=$this->db->get('siniestro_reportes sr');
        return $obj->result_array();
    }

    function getPoliza($poliza){
        $this->db->where('p.poliza',$poliza);
        $obj=$this->db->get('siniestro_poliza p');
        return $obj->result_array();
    }

    function updateSiniestro($id,$data){
        $this->db->set($data);
		$this->db->where('id', $id);
        return $this->db->update('siniestro_reportes');
    }

    function getAseguradoras($tipo){
        $this->db->select('cat.Promotoria');
        $this->db->where('sr.tipo_r',$tipo);
        $this->db->join('siniestro_reportes sr','cat.idPromotoria=sr.aseguradora_id','left')
        ->group_by('cat.idPromotoria')->order_by('cat.Promotoria','ASC');
        $obj=$this->db->get('catalog_promotorias cat');
        return $obj->result_array();
       
    }

    function validateServicio($Aseguradora,$cliente,$metodo,$tipo_actualizacion){
        if($metodo!=null && $tipo_actualizacion!=null){
            $SQL ="select * from siniestro_servicio_aseguradoras sa where sa.tipo_actualizacion='".$tipo_actualizacion."' and sa.tipo_metodo='".$metodo."' and sa.aseguradora_id=".$Aseguradora." and sa.cliente_id=".$cliente.";";
        }else{
            $SQL ="select * from siniestro_servicio_aseguradoras sa where sa.cliente_id='".$cliente."' and sa.aseguradora_id=".$Aseguradora." and sa.tipo_actualizacion='".$tipo_actualizacion."'";
        }
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        return $row;
    }

    function getSiniestrosmal(){
        $this->db->where("siniestro_id","2020-11-30");
        $obj=$this->db->get('siniestro_reportes');
        return $obj->result_array();
    }

}