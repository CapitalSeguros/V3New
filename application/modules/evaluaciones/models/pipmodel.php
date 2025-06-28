<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class pipmodel extends CI_Model
{
    function getUsers()
    {
        $tipos = $this->db->query('select u.idPersona as id, u.name_complete, p.idPersonaPuesto puesto from users u
        inner join persona p on u.idPersona=p.idPersona
        where u.activated=1 and u.banned=0 and u.name_complete <>"SNOMBRE"');
        return $tipos->result_array();
    }
    function getEmpleados()
	{
		$this->db->where("activated", 1);
		$this->db->where("banned", 0);
		$this->db->select("u.idPersona as value,u.name_complete as label, p.idPersonaPuesto puesto ");
		$this->db->join("persona p","p.idPersona = u.idPersona");
		$tipos = $this->db->get('users u');
		return $tipos->result_array();
    }

    function getDataPIP($idU, $idPerido)
    {
        $tipos = $this->db->query('select * from project_implementation_plan pp  where id="' . $idPerido . '" and empleado_id="' . $idU . '"');
        return $tipos->result_array();
    }
    function getTaks($idU, $idPerido)
    {
        $tipos = $this->db->query('select pt.titulo,pt.fecha,pt.observacion,pt.resultado_esperado,pp.comentario,pp.evaluacion_periodo_id,pp.empleado_seguimiento_id,pp.estatus,pt.parent,pt.id
        from project_implementation_plan_task pt, project_implementation_plan pp
        where pt.project_imp_plan_id=pp.id and pt.empleado_id=pp.empleado_id and
        pp.id="' . $idPerido . '" and pp.empleado_id="' . $idU . '"');
        return $tipos->result_array();
    }

    function deleteAllTask($id)
    {
        $this->db->where('project_imp_plan_id', $id);
        $this->db->delete('project_implementation_plan_task');
    }
    function UpdatePlan($id, $data)
    {
        $this->db->where('id', $id);
        $res = $this->db->update('project_implementation_plan', $data);
        return $res;
    }

    function userData($id)
    {
        $tipos = $this->db->query('select id,idTipoUser,idTipoUser_txt, name_complete from capsysV3.users where id="' . $id . '"');
        return $tipos->result_array();
    }

    function AddPIP($data)
    {
        $this->db->insert('project_implementation_plan', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function AddPIPTaks($data)
    {
        $this->db->insert('project_implementation_plan_task', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function AddParent($data)
    {
        $this->db->insert('project_implementation_plan_task', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function updatePlanInfo($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('project_implementation_plan', $data);
    }

    function updatePlanTaks($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('project_implementation_plan_task', $data);
    }

    function getLastIndexTable($nameTable)
    {
        $res = $this->db->query("select id from " . $nameTable . " ORDER BY `id` DESC LIMIT 1");
        foreach ($res->result_array() as $row) {
            $value = $row['id'];
        }
        return $value + 1;
    }

    /* modelos de Seguimiento de PIP */

    function getItemsMonitoreo($id)
    {
        $tipos = $this->db->query('select * from project_implementation_plan_task where project_imp_plan_id="' . $id . '"');
        return $tipos->result_array();
    }

    function getEmpleadosEvaluados($id)
    {
        $SQL = "SELECT 
                    u.name_complete, pp.personaPuesto, pp.idPuesto, p.idPersona, epe.periodo_id
                FROM evaluacion_periodo_empleado epe
                INNER JOIN users u ON u.idPersona = epe.empleado_id
                INNER JOIN persona p ON p.idPersona = epe.empleado_id
                LEFT JOIN personapuesto pp ON pp.idPuesto = p.idPersonaPuesto
                WHERE epe.periodo_id = $id
                GROUP BY epe.empleado_id";
        $res = $this->db->query($SQL);
        return $res->result_array();
    }

    function getEmpleadosProject($id)
    {
        $query = $this->db->where("evaluacion_periodo_id", $id)
            ->get("project_implementation_plan");

        return $query->result_array();
    }

    function getEmpleadoSeguimiento($id)
    {
        $res = $this->db->query('select * from project_implementation_plan pp where pp.id="' . $id . '"');
        return $res->result_array();
    }

    function getSeguimientoByEmpleado($id, $empleado)
    {
        $query = $this->db
            ->where("pip.evaluacion_periodo_id", $id)
            ->where("pip.empleado_id", $empleado)
            ->where("pipt.parent >", 0)
            ->join("project_implementation_plan pip", "pip.id = pipt.project_imp_plan_id", "inner")
            ->get("project_implementation_plan_task pipt");

        return $query->result();
    }


    function getEmpleadoEvaluado($id)
    {
        $res = $this->db->query('
        select u.name_complete, pp.personaPuesto, pp.idPuesto,p.idPersona,pl.evaluacion_periodo_id
        from users u, persona p, personapuesto pp, project_implementation_plan pl
        where p.idPersona=u.idPersona and p.idPersonaPuesto=pp.idPuesto and pl.empleado_id=p.idPersona and p.idPersona="' . $id . '"');
        return $res->result_array();
    }

    function getAllInfoMonitoreo($id)
    {
        $tipos = $this->db->query('select u.name_complete,pp.personaPuesto,pi.comentario,pi.id,pi.estatus
        from users u, persona p, project_implementation_plan pi,personapuesto pp
        where p.idPersona=u.idPersona and p.idPersonaPuesto=pp.idPuesto and p.idPersona=pi.empleado_id 
        and pi.id="' . $id . '"');
        return $tipos->result_array();
    }

    function getAllInfoMonitoreoTable($id,$idUser)
    {
        if($id!=0){
            $tipos = $this->db->query('select u.name_complete,pp.personaPuesto,pi.comentario,pi.id,pi.estatus,p.idPersona,pi.evaluacion_periodo_id, ep.titulo as Periodo
        from users u, persona p, project_implementation_plan pi,personapuesto pp, evaluacion_periodos ep
        where ep.id=pi.evaluacion_periodo_id and p.idPersona=u.idPersona and p.idPersonaPuesto=pp.idPuesto and p.idPersona=pi.empleado_id and  evaluacion_periodo_id='.$id);
        }else{
            $tipos = $this->db->query('select u.name_complete,pp.personaPuesto,pi.comentario,pi.id,pi.estatus,p.idPersona,pi.evaluacion_periodo_id, ep.titulo as Periodo
            from project_implementation_plan pi
            inner join users u on pi.empleado_id=u.idPersona
            inner join persona p on pi.empleado_id=p.idPersona
            inner join personapuesto pp on p.idPersonaPuesto=pp.idPuesto
            left join  evaluacion_periodos ep on pi.evaluacion_periodo_id=ep.id
            where pi.creado_por='.$idUser);
        }
        return $tipos->result_array();
    }

    function getTasksMonitoreo($id)
    {
        $tipos = $this->db->query('select pt.*
        from project_implementation_plan pi,project_implementation_plan_task pt
        where pi.id= pt.project_imp_plan_id and pi.id="' . $id . '"');
        return $tipos->result_array();
    }

    function getComentarios($id)
    {
        $tipos = $this->db->query('select pc.comentario,u.name_complete,pc.created
        from project_implementation_plan_comment pc, users u
        where u.idPersona=pc.creado_por and pc.project_imp_task_id="' . $id . '" order by pc.created DESC');
        return $tipos->result_array();
    }
    function AddComentario($data)
    {
        $this->db->insert('project_implementation_plan_comment', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function insertManagers($data){
        $this->db->insert_batch('project_implementation_plan_manager', $data);
    }

    function getLinemanagers($idPIP){
        $tipos = $this->db->query('select pp.personaPuesto label, pp.idPuesto value from project_implementation_plan_manager pipm
        inner join personapuesto pp on pipm.id_manager=pp.idPuesto
        where pipm.id_PIP='.$idPIP);
        return $tipos->result_array();
    }

    function deleteAllmanagers($idPIP){
        $this->db->delete('project_implementation_plan_manager', array('id_PIP' => $idPIP));
    }

    function getusrPuesto($id)
    {
        $obj=$this->db->query("select p.idPersona,u.email from persona p 
        inner join users u on p.idPersona=u.idPersona
        where p.idPersonaPuesto=".$id);
        return $obj->result_array();
    }

    function deleteAllPIP($id){
        //Eliminamos el PIP
        $this->db->where('id', $id);
        $this->db->delete('project_implementation_plan');

        //Eliminamor las manager
        $this->db->where('id_PIP', $id);
        $this->db->delete('project_implementation_plan_manager');

        //eliminaos las task
        $this->db->where('project_imp_plan_id', $id);
        $this->db->delete('project_implementation_plan_task');

        //eliminaos las cometarios
        $this->db->where('project_imp_plan_id', $id);
        $this->db->delete('project_implementation_plan_comment');
    }

    /* function insertRelacionPadre($data){
        $this->db->insert('project_implementation_plan_manager', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    } */
}
