<?php defined('BASEPATH') OR exit('No direct script access allowed');
class ticc_folios_model extends CI_Model
{

    function getFolioByNumYear($Num, $Year){
        $this->db->where('a.nom =', $Num);
        $this->db->where('a.anio =', $Year);
        $obj = $this->db->get('folios_sistema a');

        if ($obj->num_rows() == 0) {
            $data = array(
                'nom' => $Num,
                'anio' => $Year,
                'folio' => 0
            );
            $this->db->insert('folios_sistema', $data);
            $obj = $this->db->get('folios_sistema a');
        }

        return $obj->result_array();
    }

    function updateFolioByNumYear($Num, $Year, $Folio) {
        $this->db->set('folio', $Folio);
        $this->db->where('nom', $Num);
        $this->db->where('anio', $Year);
        
        $result = $this->db->update('folios_sistema');
        
        if (!$result) {
            //log_message('error', 'Error al actualizar folio: ' . $this->db->error()['message']);
            return false;
        }
        return true;
    }

}