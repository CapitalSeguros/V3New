<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class bonos_model extends CI_Model
{
    function getMe($id)
    {
        $obj = $this->db
            ->select("ss.*, u.name_complete")
            ->join("users u", "ss.empleado_id=u.idPersona", "inner")
            ->where("empleado_id", $id)
            ->get('solicitud_sueldo ss');

        return $obj->result();
    }

    function getTable()
    {
        $obj = $this->db
            ->select("ss.*, u.name_complete")
            ->join("users u", "ss.empleado_id=u.idPersona", "inner")
            ->get('solicitud_sueldo ss');
        return $obj->result();
    }

    function AddSolicitud($data)
    {
        $ok = $this->db->insert('solicitud_sueldo', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function getPuesto($id)
    {
        $obj = $this->db
            ->where("idPersona", $id)
            ->get('persona');
        return $obj->row();
    }

    function getSubordinados($id)
    {
        $obj = $this->db->select("u.name_complete,p.idPersona as id")
            ->where("pp.padrePuesto", $id)
            ->join("users u", "u.idPersona=p.idPersona", "inner")
            ->join("personapuesto pp", "p.idPersonaPuesto=pp.idPuesto", "inner")
            ->get('persona p');
        return $obj->result();
    }

    function getDataPeticion($id)
    {
        $obj = $this->db
            ->select("ss.*, u.name_complete, (select u.name_complete from users u where u.idPersona=ss.creado_por) as Creador, p.idPersonaPuesto puesto")
            ->where('ss.id', $id)
            ->join("users u", "ss.empleado_id=u.idPersona", "inner")
            ->join("persona p", "ss.empleado_id=p.idPersona", "inner")
            ->get('solicitud_sueldo ss');
        return $obj->result();
    }

    function insertSeguimiento($data)
    {
        $this->db->insert('solicitud_sueldo_seguimiento', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function updateEstatuspeticion($data, $id)
    {
        $this->db->where('id', $id);
        return $this->db->update('solicitud_sueldo', $data);
    }

    function getAllSeguimiento($id)
    {
        $obj = $this->db
            ->select("ss.*,u.name_complete")
            ->where('s.id', $id)
            ->join("solicitud_sueldo_seguimiento ss", "s.id=ss.solicitud_sueldo_id", "inner")
            ->join("users u", "u.idPersona=ss.empleado_id", "inner")
            ->order_by('ss.id', 'DESC')
            ->get('solicitud_sueldo s');
        return $obj->result();
    }

    function getbonosreporte($idPeriodo)
    {
        if ($idPeriodo == null)
            $idPeriodo = 0;
        $SQL = "SELECT 
                    tmp.name_complete AS nombre,
                    tmp.calificacion,
                    IFNULL(bonos_empleado(tmp.idPersonaPuesto,tmp.calificacion),0) AS bono
                FROM (
                SELECT epe.empleado_id AS empleado,
                    AVG(eprs.porcentaje) calificacion,p.idPersonaPuesto,u.name_complete
                FROM evaluacion_periodo_respuestas eprs
                    INNER JOIN evaluacion_periodo_empleado epe ON eprs.evaluacion_p_e_id = epe.id
                    INNER JOIN evaluaciones e ON e.id = epe.evaluacion_id 
                    INNER JOIN evaluacion_tipo et ON et.id = e.tipo_evaluacion_id
                    INNER JOIN persona p ON(p.idpersona =  epe.empleado_id) 
                    INNER JOIN users u ON(p.idpersona = u.idpersona)
                WHERE eprs.evaluacion_periodo_id = $idPeriodo
                GROUP BY epe.empleado_id
                ) tmp;";
        $query = $this->db->query($SQL);

        return $query->result();
    }
}
