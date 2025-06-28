<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class seguimiento_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function select()
    {
        $tipos = $this->db->get('seguimiento');
        return $tipos->result_array();
    }

    function selectByParams($referencia, $id)
    {
        $this->db
            ->where("referencia", $referencia)
            ->where("referencia_id", $id);

        switch ($referencia) {
            case 'INCIDENCIA':
                $this->db->join("incidencias i", "s.referencia_id = i.idincidencias AND s.referencia = 'INCIDENCIA'", 'inner');
                $this->db->select("i.estatus");
                break;
        }
        $this->db->join("users u", "u.idPersona = s.usuario_id");

        $this->db->select("s.id, s.referencia_id, s.fecha_alta fecha, s.comentario motivo ,u.name_complete");
        $query = $this->db->get('seguimiento s');

        return $query->result();
    }


    function add($data)
    {
        $this->db->insert('seguimiento', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('seguimiento', $data);
    }

}
