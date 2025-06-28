<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class tipo_baja_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function select()
    {
        $tipos = $this->db->get('tipos_bajas');
        return $tipos->result_array();
    }

    function selectById($id)
    {
        $tipos = $this->db
            ->where("id", $id)
            ->get('tipos_bajas');
        return $tipos->row();
    }

    function add($data)
    {
        $this->db->insert('tipos_bajas', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('tipos_bajas', $data);
    }

    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete("tipos_bajas");
    }
}
