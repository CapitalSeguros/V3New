<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class tabbonos_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function getTable()
    {
        $obj = $this->db
            ->select("ts.*,pp.personaPuesto")
            ->where("ts.estado <>", "CERRADO")
            ->join("personapuesto pp", "pp.idPuesto=ts.puesto_id", "inner")
            ->get('tabulador_sueldos ts');
        return $obj->result_array();
    }

    function addNew($data)
    {
        $this->db->insert('tabulador_sueldos', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function editElment($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('project_implementation_plan', $data);
    }

    function delete()
    {
    }

    function getSeguimiento($id)
    {
        $obj = $this->db
            ->select("tsh.*,u.name_complete")
            ->where("tsh.tabulador_sueldo_id", $id)
            ->join("users u", "u.idPersona=tsh.modificado_por", "inner")
            ->order_by("tsh.fecha", "DESC")
            ->get('tabulador_sueldos_historico tsh');

        return $obj->result();
    }

    function postSeguimiento($data)
    {
        $this->db->insert('tabulador_sueldos_historico', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function getRegistro($id)
    {
        $obj = $this->db
            ->select("ts.*,pp.personaPuesto, (select u.name_complete from users u where u.idPersona=ts.creado_por) as creado")
            ->where("ts.id", $id)
            ->join("personapuesto pp", "pp.idPuesto=ts.puesto_id", "inner")
            ->get('tabulador_sueldos ts');
        return $obj->result();
    }

    function postRespuesta($data)
    {
        $this->db->insert('tabulador_sueldos_historico', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function updateEstatuspeticion($data, $id)
    {
        $this->db->where('id', $id);
        return $this->db->update('tabulador_sueldos', $data);
    }

    function insertSeguimiento($data)
    {
        $this->db->insert('tabulador_sueldos_historico', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function deleteRegistro($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('tabulador_sueldos', $data);
    }

    function checkRegistro($calificacion, $puesto)
    {
        $obj = $this->db
            ->select("t.*")
            ->where(array("t.calificacion" => $calificacion, "t.puesto_id" => $puesto))
            ->get("tabulador_sueldos t");
        return $obj->result();
    }
}
