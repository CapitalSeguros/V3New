<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class evaluacion_tipo_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function select()
    {
        $obj = $this->db->get('evaluacion_tipo');
        return $obj->result_array();
    }

    function selectById($id)
    {
        $obj = $this->db
            ->where("id", $id)
            ->get('evaluacion_tipo');
        return $obj->row();
    }

    function add($data)
    {
        $this->db->insert('evaluacion_tipo', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('evaluacion_tipo', $data);
    }

    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete("evaluacion_tipo");
    }
}
