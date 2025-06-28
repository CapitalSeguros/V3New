<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
class servicios_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function getEmpleados()
    {
        $this->db->where("activated", 1);
        $this->db->where("banned", 0);
        $this->db->select("u.idPersona as value,u.name_complete as label, p.idPersonaPuesto puesto ");
        $this->db->join("persona p", "p.idPersona = u.idPersona");
        $this->db->order_by('u.name_complete', 'ASC');
        $tipos = $this->db->get('users u');
        return $tipos->result_array();
    }

    function getEmpleadosExplicit()
    {
        $this->db->select("sc.ejecutivo_id as value, u.name_complete as label, sc.cliente_id as cliente");
        $this->db->join("users u", "sc.ejecutivo_id=u.idPersona");
        $tipos = $this->db->get('siniestro_cliente_ejecutivo sc');
        return $tipos->result_array();
    }

    function getClientesEjecutivo($id)
    {
        /* $this->db->where("se.ejecutivo_id", $id);
        $this->db->select("distinct sc.id,sc.nombre,sa.aseguradora_id aseguradora");
        $this->db->join("siniestro_clientes sc","se.cliente_id=sc.id");
        $this->db->join("siniestro_servicio_aseguradoras sa","se.cliente_id=sa.cliente_id");
        $tipos = $this->db->get('siniestro_cliente_ejecutivo se');
        return $tipos->result_array(); */
        $SQL = "SELECT distinct sc.id,sc.nombre,sa.aseguradora_id aseguradora
        from siniestro_cliente_ejecutivo se
        inner join siniestro_clientes sc on se.cliente_id=sc.id
        inner join siniestro_servicio_aseguradoras sa on se.cliente_id=sa.cliente_id
        where se.ejecutivo_id=" . $id;
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        return $row;
    }

    function getAseguradoras()
    {
        $obj = $this->db
            ->select("cp.idPromotoria id, cp.Promotoria")
            ->get('catalog_promotorias cp');
        return $obj->result();
    }

    function insertServicio($data)
    {
        $this->db->insert('siniestro_servicio_aseguradoras', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function getTable()
    {
        $SQL = "SELECT cp.Promotoria,sa.*,sc.nombre cliente
        from siniestro_servicio_aseguradoras sa
        left join catalog_promotorias cp on sa.aseguradora_id=cp.idPromotoria
        left join siniestro_clientes sc on sa.cliente_id=sc.id";
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        return $row;
    }

    function getClientesExplicit()
    {
        $SQL = "SELECT sc.id id, sc.nombre nombre from siniestro_clientes sc;";
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        return $row;
    }

    function getClientes()
    {
        $SQL = "SELECT * from siniestro_clientes";
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        return $row;
    }
    function insertCliente($data)
    {
        $this->db->insert('siniestro_clientes', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    function deleteCliente($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('siniestro_clientes');
    }
    function actualizarCliente($id, $data)
    {
        $this->db->where('id', $id);
        $res = $this->db->update('siniestro_clientes', $data);
        return $res;
    }

    function getTiposCLientes()
    {
        $tipos = $this->db->get('siniestro_clientes_tipo');
        return $tipos->result_array();
    }

    function validacion($cliente)
    {
        $obj = $this->db->where('nombre', $cliente)
            ->get('siniestro_clientes');
        return $obj->result_array();
    }

    function deleteServicio($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('siniestro_servicio_aseguradoras');
    }

    function validateAdd($id, $metodo, $cliente, $actualizacion)
    {
        if ($metodo != null && $actualizacion != null) {
            $SQL = "select * from siniestro_servicio_aseguradoras sa where sa.tipo_actualizacion='" . $actualizacion . "' and sa.tipo_metodo='" . $metodo . "' and sa.aseguradora_id=" . $id . " and sa.cliente_id=" . $cliente . ";";
        } else {
            $SQL = "select * from siniestro_servicio_aseguradoras sa where sa.cliente_id='" . $cliente . "' and sa.aseguradora_id=" . $id . " and sa.tipo_actualizacion='" . $actualizacion . "'";
        }
        $query = $this->db->query($SQL);
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function validateDeleteC($cliente)
    {
        $obj = $this->db->where('cliente_id', $cliente)
            ->get('siniestro_servicio_aseguradoras');
        return $obj->result_array();
    }

    function actualizarAseguradora($id, $data)
    {
        $this->db->where('id', $id);
        $res = $this->db->update('siniestro_servicio_aseguradoras', $data);
        return $res;
    }
    //cliente- ejecutivo
    function table_cliente_ejectivo()
    {
        $SQL = "SELECT sce.*,sc.nombre nombreC,u.name_complete nombreE,ct.nombre tipoN FROM siniestro_cliente_ejecutivo sce
        left join siniestro_clientes sc on sce.cliente_id=sc.id
        left join siniestro_clientes_tipo ct on sce.tipo=ct.id
        left join users u on sce.ejecutivo_id=u.idPersona;";
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        return $row;
    }
    function insertEjectuivo($data)
    {
        $this->db->insert('siniestro_cliente_ejecutivo', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    function validacionE($cliente, $usuario)
    {
        $SQL = "select * from siniestro_cliente_ejecutivo ce where ce.cliente_id=" . $cliente . " and ce.ejecutivo_id=" . $usuario;
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        return $row;
    }
    function deleteServicioE($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('siniestro_cliente_ejecutivo');
    }
    function actualizarE($id, $data)
    {
        $this->db->where('id', $id);
        $res = $this->db->update('siniestro_cliente_ejecutivo', $data);
        return $res;
    }

    //alertas
    function insertAlerta($data)
    {
        $this->db->insert('siniestro_alerta', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    function table_alertas()
    {
        /* $SQL ="SELECT sa.id,sa.dias,sa.indicador_id causa_id,i.sub_tipo_id,i.tipo_id,st.nombre causa,it.nombre tipo,
        ist.nombre sub_tipo,sc.nombre cliente, sa.escalamiento_1,sa.escalamiento_2,sa.indicador_id,sa.tipo_notificacion,i.cliente_id
        FROM siniestro_alerta sa
        left join siniestro_clientes sc on sa.cliente_id=sc.id
        left join indicadores i on sa.indicador_id=i.id
        left join siniestro_tipo st on i.causa_id=st.id
        left join indicador_tipo it on i.tipo_id=it.id
        left join indicador_sub_tipo ist on i.sub_tipo_id=ist.id"; */
        $SQL = "SELECT sa.id,sa.dias,sa.indicador_id causa_id,i.sub_tipo_id,i.tipo_id,
        case 
            when i.sub_tipo_id=2 then (select st.nombre from siniestro_tipo st where i.causa_id=st.id)
            when i.sub_tipo_id=1 then (select CONCAT(st.nombre,'-',st.tipo_c) from tipo_coberturas_gmm st where i.causa_id=st.id)
            when i.sub_tipo_id=3 then (select st.nombre from siniestro_tramite_gmm st where i.causa_id=st.id)
        end causa
        ,it.nombre tipo,
        ist.nombre sub_tipo,sc.nombre cliente, sa.escalamiento_1,sa.escalamiento_2,sa.indicador_id,sa.tipo_notificacion,i.cliente_id
        FROM siniestro_alerta sa
        left join siniestro_clientes sc on sa.cliente_id=sc.id
        left join indicadores i on sa.indicador_id=i.id
        left join indicador_tipo it on i.tipo_id=it.id
        left join indicador_sub_tipo ist on i.sub_tipo_id=ist.id";;
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        return $row;
    }

    function validacionA($cliente, $tipo)
    {
        $clientes = $cliente == '' || $cliente == null ? "sa.cliente_id=0" : " sa.cliente_id='" . $cliente . "'";
        $SQL = "select * from siniestro_alerta sa where " . $clientes . " and sa.indicador_id='" . $tipo . "'";
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        return $row;
    }
    function actualizarA($id, $data)
    {
        $this->db->where('id', $id);
        $res = $this->db->update('siniestro_alerta', $data);
        return $res;
    }
    function deleteServicioA($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('siniestro_alerta');
    }

    function getAlertas($cliente)
    {
        $SQL = "select  sa.*,st.nombre from siniestro_alerta sa left join siniestro_tipo st on sa.causa=st.id where sa.cliente_id=" . $cliente;
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        return $row;
    }
    function siniestrosAlertas($cliente, $today, $dias, $tipo)
    {
        $SQL = "select sr.siniestro_id id, timestampdiff(DAY,sr.fecha_ocurrencia,'" . $today . "') dias from siniestro_reportes sr 
        where timestampdiff(DAY,sr.fecha_ocurrencia,'" . $today . "')>" . $dias . " and sr.tipo_siniestro_id=" . $tipo . "
         and sr.cliente_id=" . $cliente . " and sr.complemento_json  REGEXP 'AVISADO|CONDICIONADO|EN TRAMITE' order by sr.fecha_ocurrencia ASC limit 10;";
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        return $row;
    }

    ///indicadores 
    function table_Indicadores()
    {
        //indicadores del tipo de Autos
        /* $SQL ="SELECT i.*,sc.nombre cliente,it.nombre tipo,ist.nombre sub_tipo,st.nombre causa from indicadores i
        left join siniestro_clientes sc on i.cliente_id=sc.id
        left join indicador_tipo it on i.tipo_id=it.id
        left join indicador_sub_tipo ist on i.sub_tipo_id=ist.id
        left join siniestro_tipo st on i.causa_id=st.id where sub_tipo_id=2"; */
        /* $SQL ="SELECT i.*,sc.nombre cliente,it.nombre tipo,ist.nombre sub_tipo,
        case 
            when i.sub_tipo_id=2 then (select st.nombre from siniestro_tipo st where i.causa_id=st.id)
            when i.sub_tipo_id=1 then (select CONCAT(st.nombre, '-', st.tipo_c) from siniestro_tramite_danos st where i.causa_id=st.id)
            when i.sub_tipo_id=3 then (select st.nombre from siniestro_tramite_gmm st where i.causa_id=st.id)
        end causa from indicadores i
        left join siniestro_clientes sc on i.cliente_id=sc.id
        left join indicador_tipo it on i.tipo_id=it.id
        left join indicador_sub_tipo ist on i.sub_tipo_id=ist.id"; */
        $SQL = "SELECT i.*,sc.nombre cliente,it.nombre tipo,ist.nombre sub_tipo,
        case 
            when i.sub_tipo_id=2 then (select st.nombre from siniestro_tipo st where i.causa_id=st.id)
            when i.sub_tipo_id=1 then (select CONCAT(st.nombre,'-',st.tipo_c) from tipo_coberturas_gmm st where i.causa_id=st.id)
            when i.sub_tipo_id=3 then (select st.nombre from siniestro_tramite_gmm st where i.causa_id=st.id)
        end causa from indicadores i
        left join siniestro_clientes sc on i.cliente_id=sc.id
        left join indicador_tipo it on i.tipo_id=it.id
        left join indicador_sub_tipo ist on i.sub_tipo_id=ist.id";
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        return $row;
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        return $row;
    }
    function insertIndicador($data)
    {
        $this->db->insert('indicadores', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    function deleteServicioI($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('indicadores');
    }
    function actualizarI($id, $data)
    {
        $this->db->where('id', $id);
        $res = $this->db->update('indicadores', $data);
        return $res;
    }
    function validacionI($cliente, $tipo, $subtipo, $causa)
    {
        $clientes = $cliente == '' || $cliente == null ? "sa.cliente_id=0" : " sa.cliente_id='" . $cliente . "'";
        $SQL = "select * from indicadores sa where " . $clientes . " and sa.tipo_id=" . $tipo . " and sa.sub_tipo_id=" . $subtipo . " and sa.causa_id=" . $causa;
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        return $row;
    }

    function getIndcadoresSubtipo()
    {
        /* $SQL ="SELECT i.id,ifnull(i.cliente_id,'') cliente_id,i.tipo_id,i.sub_tipo_id, st.nombre, i.dias from indicadores i
        left join siniestro_tipo st on i.causa_id=st.id"; */ //select t.id,CONCAT(t.nombre, '-', tipo_c) nombre from tipo_coberturas_gmm t where t.Tipo='DAÑOS'
        /*   $SQL="select i.id,ifnull(i.cliente_id,'') cliente_id,i.tipo_id,i.sub_tipo_id,
        case 
            when i.sub_tipo_id=2 then (select st.nombre from siniestro_tipo st where i.causa_id=st.id)
            when i.sub_tipo_id=1 then (select st.nombre from siniestro_tramite_danos st where i.causa_id=st.id)
            when i.sub_tipo_id=3 then (select st.nombre from siniestro_tramite_gmm st where i.causa_id=st.id)
        end nombre
        , i.dias from indicadores i;"; */
        $SQL = "select i.id,ifnull(i.cliente_id,'') cliente_id,i.tipo_id,i.sub_tipo_id,
        case 
            when i.sub_tipo_id=2 then (select st.nombre from siniestro_tipo st where i.causa_id=st.id)
            when i.sub_tipo_id=1 then (select CONCAT(st.nombre,'-',st.tipo_c) from tipo_coberturas_gmm st where i.causa_id=st.id)
            when i.sub_tipo_id=3 then (select st.nombre from siniestro_tramite_gmm st where i.causa_id=st.id)
        end nombre
        , i.dias from indicadores i;";
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        return $row;
    }

    function getTIpos()
    {
        $tipos = $this->db->get('indicador_tipo');
        return $tipos->result_array();
    }
    function getSubtipos()
    {
        $tipos = $this->db->get('indicador_sub_tipo');
        return $tipos->result_array();
    }

    //notificaciones de alertas

    function escalamiento($cliente, $tipo, $usuario)
    {
        $SQL = "";
        switch ($tipo) {
            case 'esc_0':
                $SQL = "select sr.siniestro_id,st.nombre,i.dias, sa.dias antes,TIMESTAMPDIFF(DAY,sr.fecha_repote,CURDATE()+1) transcurrido,('POR ESCALAR') tipo,('Autos Corporativo') modulo,sr.inicio_ajuste ocurrencia
                from siniestro_reportes sr
                inner join 	siniestro_tipo st on sr.tipo_siniestro_id=st.id
                inner join indicadores i on st.id=i.causa_id
                inner join siniestro_alerta sa on i.id=sa.indicador_id where 
                TIMESTAMPDIFF(DAY,sr.fecha_repote,CURDATE()+1)>(i.dias-sa.dias)
                and  TIMESTAMPDIFF(DAY,sr.fecha_repote,CURDATE()+1)<=(i.dias)
                and  (sr.complemento_json REGEXP '\"EstatusSiniestro\":\"EN TRAMITE\"|\"EstatusSiniestro\":\"AVISADO\"|\"EstatusSiniestro\":\"CONDICIONADO\"|\"EstatusSiniestro\":\"PENDIENTE\"'
                OR sr.siniestro_estatus IN ('ACTIVO') OR sr.siniestro_estatus IS null)
                and sr.tipo_r='S' and year(sr.fecha_repote)>='2021'
                and sr.cliente_id=" . $cliente . " order by TIMESTAMPDIFF(DAY,sr.fecha_repote,CURDATE()+1) DESC;";
                break;
            case 'esc_1':
                $SQL = "select sr.siniestro_id,st.nombre,i.dias, sa.dias antes,TIMESTAMPDIFF(DAY,sr.fecha_repote,CURDATE()+1) transcurrido, ('PRIMERA ESCALA') tipo, ('Autos Corporativo') modulo,sr.inicio_ajuste ocurrencia
                from siniestro_reportes sr
                inner join 	siniestro_tipo st on sr.tipo_siniestro_id=st.id
                inner join indicadores i on st.id=i.causa_id
                inner join siniestro_alerta sa on i.id=sa.indicador_id where 
                TIMESTAMPDIFF(DAY,sr.fecha_repote,CURDATE()+1)>(i.dias+sa.esc1_dias)
                and  TIMESTAMPDIFF(DAY,sr.fecha_repote,CURDATE()+1)<=(i.dias+sa.esc1_dias+sa.esc2_dias)
                and  (sr.complemento_json REGEXP '\"EstatusSiniestro\":\"EN TRAMITE\"|\"EstatusSiniestro\":\"AVISADO\"|\"EstatusSiniestro\":\"CONDICIONADO\"|\"EstatusSiniestro\":\"PENDIENTE\"'
                OR sr.siniestro_estatus IN ('ACTIVO') OR sr.siniestro_estatus IS null)
                and sr.tipo_r='S' and year(sr.fecha_repote)>='2021'
                and sr.cliente_id=" . $cliente . " and sa.escalamiento_1 regexp '\"value\":\"" . $usuario . "\"' order by TIMESTAMPDIFF(DAY,sr.fecha_repote,CURDATE()+1) DESC;";
                break;
            case 'esc_2':
                $SQL = "select sr.siniestro_id,st.nombre,i.dias, sa.dias antes,TIMESTAMPDIFF(DAY,sr.fecha_repote,CURDATE()+1) transcurrido,('SEGUNDA ESCALA') tipo,('Autos Corporativo') modulo,sr.inicio_ajuste ocurrencia
                from siniestro_reportes sr
                inner join 	siniestro_tipo st on sr.tipo_siniestro_id=st.id
                inner join indicadores i on st.id=i.causa_id
                inner join siniestro_alerta sa on i.id=sa.indicador_id where 
                TIMESTAMPDIFF(DAY,sr.fecha_repote,CURDATE()+1)>(i.dias+sa.esc1_dias+sa.esc2_dias)
                and  (sr.complemento_json REGEXP '\"EstatusSiniestro\":\"EN TRAMITE\"|\"EstatusSiniestro\":\"AVISADO\"|\"EstatusSiniestro\":\"CONDICIONADO\"|\"EstatusSiniestro\":\"PENDIENTE\"'
                OR sr.siniestro_estatus IN ('ACTIVO') OR sr.siniestro_estatus IS null)
                and sr.tipo_r='S' and year(sr.fecha_repote)>='2021'
                and sr.cliente_id=" . $cliente . " and sa.escalamiento_2 regexp '\"value\":\"" . $usuario . "\"' order by TIMESTAMPDIFF(DAY,sr.fecha_repote,CURDATE()+1) DESC;";
                break;
        }
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        return $row;
    }



    function getUsersCliente($cliente)
    {
        $SQL = "SELECT u.idPersona id from siniestro_cliente_ejecutivo ce 
        left join users u on ce.ejecutivo_id=u.idPersona where ce.notify is null and ce.cliente_id=" . $cliente;
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        return $row;
    }

    function getSiniestrosAlertasEjecutivo($cliente)
    {
        $SQL = "SELECT distinct sr.id,sr.siniestro_id, TIMESTAMPDIFF(DAY, sr.fecha_ocurrencia, CURDATE()+1) diasD,i.dias parametro,st.nombre
        from siniestro_reportes sr
        left join siniestro_tipo st on sr.tipo_siniestro_id=st.id
        left join indicadores i on sr.tipo_siniestro_id=i.causa_id
        left join siniestro_alerta sa on sa.cliente_id=sr.cliente_id
        where i.cliente_id=" . $cliente . " and sr.complemento_json not REGEXP 'LIQUIDADO'
        and (TIMESTAMPDIFF(DAY, sr.fecha_ocurrencia, CURDATE()+1)>(i.dias-sa.dias)) order by sr.fecha_ocurrencia;";
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        return $row;
    }

    function getSiniestrosAlertasEspecial($cliente, $diasE)
    {
        $SQL = "SELECT  distinct sr.id,sr.*, TIMESTAMPDIFF(DAY, sr.fecha_ocurrencia, CURDATE()+1) diasP ,i.dias parametro
        from siniestro_reportes sr
        left join indicadores i on sr.tipo_siniestro_id=i.causa_id
        left join siniestro_alerta sa on sa.cliente_id=sr.cliente_id
        where i.cliente_id=" . $cliente . " and sr.complemento_json not REGEXP 'LIQUIDADO'
        and (TIMESTAMPDIFF(DAY, sr.fecha_ocurrencia, CURDATE()+1)>(i.dias+" . $diasE . ")) order by sr.fecha_ocurrencia ;";
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        return $row;
    }

    function getSiniestrosEscala($cliente, $dias1, $dias2, $tipo)
    {
        $SQL = "SELECT distinct sr.id, sr.*,i.*,(TIMESTAMPDIFF(DAY, sr.fecha_ocurrencia, CURDATE()+1)) trans, st.nombre tipoN,i.dias diasI,
        if((TIMESTAMPDIFF(DAY, sr.fecha_ocurrencia, CURDATE()+1))>(i.dias+sa.dias+" . $dias1 . ") && (TIMESTAMPDIFF(DAY, sr.fecha_ocurrencia, CURDATE()+1))<(i.dias+sa.dias+" . $dias1 . "+" . $dias2 . ") ,'esc_1','esc_2') tipo from siniestro_reportes sr
        left join indicadores i on sr.tipo_siniestro_id=i.causa_id
        left join siniestro_alerta sa on i.id=sa.indicador_id
        left join siniestro_tipo st on sr.tipo_siniestro_id=st.id 
        where i.cliente_id=" . $cliente . " and sr.tipo_siniestro_id=" . $tipo . " and sr.complemento_json not REGEXP 'LIQUIDADO';";
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        return $row;
    }

    function getAllAPI()
    {
        $SQL = "SELECT ssa.cliente_id,ssa.aseguradora_id from siniestro_servicio_aseguradoras ssa
        where ssa.tipo_actualizacion='SERVICIO' group by ssa.cliente_id;";
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        return $row;
    }
    /// funciones del módulo de permisos
    function getAllUrls()
    {
        $SQL = "select id value, nombre label from modulo_url";
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        return $row;
    }
    function insertpermiso($data)
    {
        $this->db->insert('modulo_permisos', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    function getTablePermisos()
    {
        /* $SQL ="select mp.id,mu.url,pp.personaPuesto from modulo_permisos mp
        inner join personapuesto pp on mp.id_puestoPersona=pp.idPuesto
        inner join modulo_url mu on mp.id_url=mu.id"; */
        $SQL = "select mp.id, (select mu.url from modulo_url mu where mp.id_url=mu.id) url,
        (select mu.nombre from modulo_url mu where mp.id_url=mu.id) nombre,
        (select pp.personaPuesto from personapuesto pp where mp.id_puestoPersona=pp.idPuesto) personaPuesto,
        (select pp.idPuesto from personapuesto pp where mp.id_puestoPersona=pp.idPuesto) id_puesto,
        (select mu.id from modulo_url mu where mp.id_url=mu.id) id_url,
        mp.acciones
        from modulo_permisos mp order by personaPuesto";
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        return $row;
    }
    function verify($url, $puesto)
    {
        $SQL = "Select * from modulo_permisos where id_url=" . $url . " and id_puestoPersona=" . $puesto . ";";
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        return $row;
    }
    function deletePermiso($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('modulo_permisos');
    }

    function permiso($idP, $url)
    {
        $SQL = "select * from modulo_permisos mp
        inner join modulo_url mu on mp.id_url=mu.id
        where mu.url='" . $url . "' and mp.id_puestoPersona=" . $idP;
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        return $row;
    }

    function getTableNombre($tabla)
    {
        $tipos = $this->db->get($tabla);
        return $tipos->result_array();
    }

    function getTiposDanos()
    {
        $SQL = "select t.id,CONCAT(t.nombre, '-', tipo_c) nombre from tipo_coberturas_gmm t where t.Tipo='DAÑOS';";
        $query = $this->db->query($SQL);
        return $query->result_array();
    }


    function actualizarPermisos($id, $data)
    {
        $this->db->where('id', $id);
        $res = $this->db->update('modulo_permisos', $data);
        return $res;
    }

    function getPermisosPuesto($puesto, $url)
    {
        $SQL = "select mp.acciones permisos, mp.id id_permiso from modulo_permisos mp
        left join modulo_url mu on mp.id_url=mu.id
        where mp.id_puestoPersona=" . $puesto . " and mu.url='" . $url . "'";
        $query = $this->db->query($SQL);
        return $query->result_array();
    }

    function getTreedb()
    {
        $tipos = $this->db->get("modulo_grupo");
        $allt = $tipos->result_array();
        $tree = [];
        foreach ($allt as $key => $value) {
            $tree[] = array(
                "nombre" => $value["nombre"],
                "items" => $this->getItemsGroups($value["id"])
            );
        }
        return $tree;
    }

    function getItemsGroups($id)
    {
        $this->db->select('mu.nombre ,mu.url,mg.nombre modulo, mu.id')
            ->join("modulo_url mu", "mgr.id_url=mu.id", "left")
            ->join("modulo_grupo mg", "mgr.id_grupo=mg.id", "left")
            ->where("mgr.id_grupo", $id)
            ->order_by('mu.id', 'ASC');
        $obj = $this->db->get('modulo_grupo_relacion mgr');
        return $obj->result_array();
    }


    function getModulosPermisos($id_usuario)
    {
        $this->db->select('mg.nombre modulo, mu.nombre url')
            ->join("modulo_grupo_relacion mgr", "mp.id_url=mgr.id_url", "left")
            ->join("modulo_grupo mg", "mgr.id_grupo=mg.id", "left")
            ->join("modulo_url mu", "mp.id_url=mu.id", "left")
            ->where('mp.id_puestoPersona', $id_usuario);
        $obj = $this->db->get("modulo_permisos mp");
        return $obj->result_array();
    }

    function getpermisostabla($id)
    {
        $this->db->where('id_puestoPersona', $id);
        $obj = $this->db->get('modulo_permisos');
        return $obj->result_array();
    }

    function CopyPermiso($data)
    {
        $this->db->insert_batch('modulo_permisos', $data);
    }


    ///Escalamientos de los nuevos módulos de siniestros
    function escalamientoAutosI($tipo, $usuario)
    {
        $SQL = "";
        switch ($tipo) {
            case 'esc_0':
                $SQL = "select sr.siniestro_id,st.nombre,i.dias, sa.dias antes,TIMESTAMPDIFF(DAY,sr.inicio_ajuste,CURDATE()) transcurrido,('POR ESCALAR') tipo,('AUTOS INDIVIDUAL') modulo,sr.inicio_ajuste ocurrencia
                from siniestro_reportes sr
                left join siniestro_tipo st on sr.tipo_siniestro_id=st.id
                left join (select * from indicadores i where cliente_id IN (0,4)) as i on sr.tipo_siniestro_id=i.causa_id
                inner join siniestro_alerta sa on i.id=sa.indicador_id 
                where sr.tipo_r='A' and sr.status_id in (1,2,6) and sr.cliente_id is null
                and TIMESTAMPDIFF(DAY,sr.inicio_ajuste,CURDATE())>(i.dias-sa.dias)
                and  TIMESTAMPDIFF(DAY,sr.inicio_ajuste,CURDATE())<=(i.dias) 
                and sa.escalamiento_1 regexp '\"value\":\"" . $usuario . "\"'
                order by TIMESTAMPDIFF(DAY,sr.inicio_ajuste,CURDATE()) DESC;";
                break;
            case 'esc_1':
                $SQL = "select sr.siniestro_id,st.nombre,i.dias, sa.dias antes,TIMESTAMPDIFF(DAY,sr.inicio_ajuste,CURDATE()) transcurrido,('PRIMERA ESCALA') tipo,('AUTOS INDIVIDUAL') modulo,sr.inicio_ajuste ocurrencia
                from siniestro_reportes sr
                left join siniestro_tipo st on sr.tipo_siniestro_id=st.id
                left join (select * from indicadores i where cliente_id IN (0,4)) as i on sr.tipo_siniestro_id=i.causa_id
                inner join siniestro_alerta sa on i.id=sa.indicador_id 
                where sr.tipo_r='A' and TIMESTAMPDIFF(DAY,sr.inicio_ajuste,CURDATE())>(i.dias+sa.esc1_dias)
                and  TIMESTAMPDIFF(DAY,sr.inicio_ajuste,CURDATE())<=(i.dias+sa.esc1_dias+sa.esc2_dias)
                and sr.status_id in (1,2,6) and sr.cliente_id is null
                and sa.escalamiento_1 regexp '\"value\":\"" . $usuario . "\"' order by TIMESTAMPDIFF(DAY,sr.inicio_ajuste,CURDATE()) DESC;";
                break;
            case 'esc_2':
                $SQL = "select sr.siniestro_id,st.nombre,i.dias, sa.dias antes,TIMESTAMPDIFF(DAY,sr.inicio_ajuste,CURDATE()) transcurrido,('SEGUNDA ESCALA') tipo,('AUTOS INDIVIDUAL') modulo,sr.inicio_ajuste ocurrencia
                from siniestro_reportes sr
                left join siniestro_tipo st on sr.tipo_siniestro_id=st.id
                left join (select * from indicadores i where cliente_id IN (0,4)) as i on sr.tipo_siniestro_id=i.causa_id
                inner join siniestro_alerta sa on i.id=sa.indicador_id 
                where sr.tipo_r='A' and TIMESTAMPDIFF(DAY,sr.inicio_ajuste,CURDATE())>(i.dias+sa.esc1_dias+sa.esc2_dias)
                and sr.status_id in (1,2,6) and sr.cliente_id is null
                and sa.escalamiento_2 regexp '\"value\":\"" . $usuario . "\"' order by TIMESTAMPDIFF(DAY,sr.inicio_ajuste,CURDATE()) DESC;";
                break;
        }
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        return $row;
    }

    function escalamientoDanos($tipo, $usuario)
    {
        $SQL = "";
        switch ($tipo) {
            case 'esc_0':
                $SQL = "select sr.siniestro_id,(concat(tcg.nombre,'-',tcg.tipo_c)) nombre,i.dias, sa.dias antes,TIMESTAMPDIFF(DAY,sr.inicio_ajuste,CURDATE()+1) transcurrido,('POR ESCALAR') tipo,('DAÑOS') modulo,sr.inicio_ajuste ocurrencia
                from siniestro_reportes sr 
                left join tipo_coberturas_gmm tcg on sr.id_tipo_d=tcg.id
                left join (select * from indicadores i where cliente_id=0) as i on tcg.id=i.causa_id
                inner join siniestro_alerta sa on i.id=sa.indicador_id 
                where sr.tipo_r='D'
                and sr.status_id in (1,2,6) and sr.cliente_id is null
                and TIMESTAMPDIFF(DAY,sr.inicio_ajuste,CURDATE()+1)>(i.dias-sa.dias)
                and  TIMESTAMPDIFF(DAY,sr.inicio_ajuste,CURDATE()+1)<=(i.dias)
                and sa.escalamiento_1 regexp '\"value\":\"" . $usuario . "\"'
                order by TIMESTAMPDIFF(DAY,sr.inicio_ajuste,CURDATE()+1) DESC;";
                break;
            case 'esc_1':
                $SQL = "select sr.siniestro_id,(concat(tcg.nombre,'-',tcg.tipo_c)) nombre,i.dias, sa.dias antes,TIMESTAMPDIFF(DAY,sr.inicio_ajuste,CURDATE()+1) transcurrido,('PRIMERA ESCALA') tipo,('DAÑOS') modulo,sr.inicio_ajuste ocurrencia
                from siniestro_reportes sr 
                left join tipo_coberturas_gmm tcg on sr.id_tipo_d=tcg.id
                left join (select * from indicadores i where cliente_id=0) as i on tcg.id=i.causa_id
                inner join siniestro_alerta sa on i.id=sa.indicador_id 
                where sr.tipo_r='D' and TIMESTAMPDIFF(DAY,sr.inicio_ajuste,CURDATE())>(i.dias+sa.esc1_dias)
                and  TIMESTAMPDIFF(DAY,sr.inicio_ajuste,CURDATE())<=(i.dias+sa.esc1_dias+sa.esc2_dias)
                and sr.status_id in (1,2,6) and sr.cliente_id is null
                and sa.escalamiento_1 regexp '\"value\":\"" . $usuario . "\"' order by TIMESTAMPDIFF(DAY,sr.inicio_ajuste,CURDATE()+1) DESC;";
                break;
            case 'esc_2':
                $SQL = "select sr.siniestro_id,(concat(tcg.nombre,'-',tcg.tipo_c)) nombre,i.dias, sa.dias antes,TIMESTAMPDIFF(DAY,sr.inicio_ajuste,CURDATE()+1) transcurrido,('SEGUNDA ESCALA') tipo,('DAÑOS') modulo,sr.inicio_ajuste ocurrencia
                from siniestro_reportes sr 
                left join tipo_coberturas_gmm tcg on sr.id_tipo_d=tcg.id
                left join (select * from indicadores i where cliente_id=0) as i on tcg.id=i.causa_id
                inner join siniestro_alerta sa on i.id=sa.indicador_id 
                where sr.tipo_r='D' and TIMESTAMPDIFF(DAY,sr.inicio_ajuste,CURDATE())>(i.dias+sa.esc1_dias+sa.esc2_dias)
                and sr.status_id in (1,2,6) and sr.cliente_id is null
                and sa.escalamiento_2 regexp '\"value\":\"" . $usuario . "\"' order by TIMESTAMPDIFF(DAY,sr.inicio_ajuste,CURDATE()) DESC;";
                break;
        }
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        return $row;
    }


    function escalamientoGMM($tipo, $usuario)
    {
        $SQL = "";
        switch ($tipo) {
            case 'esc_0':
                $SQL = "select sr.siniestro_id,stg.nombre nombre,i.dias, sa.dias antes,TIMESTAMPDIFF(DAY,st.fecha_inicio,CURDATE()) transcurrido,('POR ESCALAR') tipo,('GMM') modulo, st.fecha_inicio ocurrencia
                from siniestro_tramite st 
                left join siniestro_reportes sr on st.id_siniestro=sr.id
                left join siniestro_tramite_gmm stg on st.tipo_tramite=stg.id
                left join (select * from indicadores i where cliente_id=0 and i.sub_tipo_id=3) as i on st.tipo_tramite=i.causa_id
                inner join siniestro_alerta sa on i.id=sa.indicador_id 
                where sr.tipo_r='G'
                and st.estatus in (1,2,6) and sr.cliente_id is null
                and TIMESTAMPDIFF(DAY,st.fecha_inicio,CURDATE())>(i.dias-sa.dias)
                and  TIMESTAMPDIFF(DAY,st.fecha_inicio,CURDATE())<=(i.dias) 
                and sa.escalamiento_1 regexp '\"value\":\"" . $usuario . "\"'
                order by TIMESTAMPDIFF(DAY,st.fecha_inicio,CURDATE()) DESC;";
                break;
            case 'esc_1':
                $SQL = "select sr.siniestro_id,stg.nombre nombre,i.dias, sa.dias antes,TIMESTAMPDIFF(DAY,st.fecha_inicio,CURDATE()) transcurrido,('PRIMERA ESCALA') tipo,('GMM') modulo,st.fecha_inicio ocurrencia
                from siniestro_tramite st 
                left join siniestro_reportes sr on st.id_siniestro=sr.id
                left join siniestro_tramite_gmm stg on st.tipo_tramite=stg.id
                left join (select * from indicadores i where cliente_id=0 and i.sub_tipo_id=3) as i on st.tipo_tramite=i.causa_id
                inner join siniestro_alerta sa on i.id=sa.indicador_id 
                where sr.tipo_r='G'
                and TIMESTAMPDIFF(DAY,st.fecha_inicio,CURDATE())>(i.dias+sa.esc1_dias)
                and  TIMESTAMPDIFF(DAY,st.fecha_inicio,CURDATE())<=(i.dias+sa.esc1_dias+sa.esc2_dias)
                and sr.status_id in (1,2,6) and sr.cliente_id is null
                and sa.escalamiento_1 regexp '\"value\":\"" . $usuario . "\"' order by TIMESTAMPDIFF(DAY,st.fecha_inicio,CURDATE()) DESC;";
                break;
            case 'esc_2':
                $SQL = "select sr.siniestro_id,stg.nombre nombre,i.dias, sa.dias antes,TIMESTAMPDIFF(DAY,st.fecha_inicio,CURDATE()) transcurrido,('SEGUNDA ESCALA') tipo,('GMM') modulo,st.fecha_inicio ocurrencia
                from siniestro_tramite st 
                left join siniestro_reportes sr on st.id_siniestro=sr.id
                left join siniestro_tramite_gmm stg on st.tipo_tramite=stg.id
                left join (select * from indicadores i where cliente_id=0 and i.sub_tipo_id=3) as i on st.tipo_tramite=i.causa_id
                inner join siniestro_alerta sa on i.id=sa.indicador_id 
                where sr.tipo_r='G'
                and TIMESTAMPDIFF(DAY,st.fecha_inicio,CURDATE())>(i.dias+sa.esc1_dias+sa.esc2_dias)
                and st.estatus in (1,2,6) and sr.cliente_id is null
                and sa.escalamiento_2 regexp '\"value\":\"" . $usuario . "\"' order by TIMESTAMPDIFF(DAY,st.fecha_inicio,CURDATE()) DESC;";
                break;
        }
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        return $row;
    }

    function getAllnotifiacaciones()
    {
        $obj = [];
        //$this->db->where("sa.cliente_id",0);
        $this->db->where_in("sa.cliente_id", array(0, 4));
        $obj = $this->db->get('siniestro_alerta sa');
        return $obj->result_array();
    }

    function getAllusersNoty()
    {
        $all = [];
        $idusr = [];
        $all = $this->getAllnotifiacaciones();
        foreach ($all as $key => $value) {
            $dtaEsc1 = json_decode($value["escalamiento_1"], true);
            foreach ($dtaEsc1["usuarios"] as $key => $usr1) {
                $idusr[] = $usr1["value"];
            }
            $dtaEsc2 = json_decode($value["escalamiento_2"], true);
            foreach ($dtaEsc2["usuarios"] as $key => $usr2) {
                $idusr[] = $usr2["value"];
            }
        }

        return array_unique($idusr);
    }

    function getTablaNewNotificaciones()
    {
        $SQL = "SELECT a.id,u.name_complete usuario, a.usuario id_usuario,p.idPersonaPuesto puesto,
        CASE
            WHEN a.modulo ='A' THEN 'AUTOS INDIVIDUAL'
            WHEN a.modulo ='C' THEN 'AUTOS CORPORATIVO'
            WHEN a.modulo ='G' THEN 'GASTOS MEDICOS'
            ELSE 'DAÑOS'
        END as modulo,
        CASE
            WHEN a.tipo ='V' THEN 'VERDE'
            WHEN a.tipo ='A' THEN 'AMBAR'
            ELSE 'ROJO'
        END as tipo,
        a.tipo as tipoT,
        a.modulo as moduloT
        from notificacion_siniestros_alertas a
        INNER JOIN users u on a.usuario=u.id
        INNER JOIN persona p where u.idPersona=p.idPersona";
        $query = $this->db->query($SQL);
        return $query->result_array();
    }

    function getPuestos()
    {
        $sql = "SELECT idPuesto,personaPuesto FROM personapuesto WHERE statusPuesto=1 ORDER BY PersonaPuesto";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function validacionN($modulo, $tipo, $usuario)
    {
        $SQL = "select * from notificacion_siniestros_alertas sa where sa.modulo='" . $modulo . "' and sa.tipo='" . $tipo . "' and sa.usuario=" . $usuario;
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        return $row;
    }

    function insertNuevaN($data)
    {
        unset($data["id"]);
        $this->db->insert('notificacion_siniestros_alertas', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function actualizarNuevaN($id, $data)
    {
        unset($data["id"]);
        $this->db->where('id', $id);
        $res = $this->db->update('notificacion_siniestros_alertas', $data);
        return $res;
    }

    function deleteNuevaN($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('notificacion_siniestros_alertas');
    }



    //Nuevas notificaciones
    function NewNotificaiconesAutosI()
    {
        $SQL = "SELECT sr.asegurado_nombre,
        p.Promotoria compania, sr.inicio_ajuste fecha, sr.siniestro_estatus Estado, TIMESTAMPDIFF(DAY,sr.inicio_ajuste, CURDATE()) tiempo, st.nombre tipo
        ,sr.tipo_r modulo,(TIMESTAMPDIFF(DAY,sr.inicio_ajuste, CURDATE())/indicador.dias) as porcentaje,
        CASE
            WHEN (TIMESTAMPDIFF(DAY,sr.inicio_ajuste, CURDATE())/indicador.dias) <=0.8 THEN 'V'
            WHEN (TIMESTAMPDIFF(DAY,sr.inicio_ajuste, CURDATE())/indicador.dias) >0.8 AND (TIMESTAMPDIFF(DAY,sr.inicio_ajuste, CURDATE())/indicador.dias) <=1 THEN 'A'
            WHEN (TIMESTAMPDIFF(DAY,sr.inicio_ajuste, CURDATE())/indicador.dias) >1 THEN 'R'
        END as tipo_i
        from siniestro_reportes sr
        left join (select * from indicadores i where cliente_id=0) indicador on sr.tipo_siniestro_id=indicador.causa_id
        left join siniestro_estatus_tramites setr on sr.status_id=setr.id
        left join catalog_promotorias p on sr.aseguradora_id=p.idPromotoria
        left join siniestro_tipo st on sr.tipo_siniestro_id=st.id
        where sr.tipo_r='A' and indicador.id is not null
        and siniestro_estatus IN ('ACTIVO')
        and YEAR(sr.inicio_ajuste)='2023' 
        and sr.fecha_fin is NULL;";
        $query = $this->db->query($SQL);
        return $query->result_array();
    }

    function NewNotificaiconesDanos()
    {
        $SQL = "SELECT sr.asegurado_nombre,
        p.Promotoria compania, sr.inicio_ajuste fecha, sr.siniestro_estatus Estado, TIMESTAMPDIFF(DAY,sr.inicio_ajuste, CURDATE()) tiempo, stg.nombre tipo,
        sr.tipo_r modulo,(TIMESTAMPDIFF(DAY,sr.inicio_ajuste, CURDATE())/indicador.dias) as porcentaje,
        CASE
            WHEN (TIMESTAMPDIFF(DAY,sr.inicio_ajuste, CURDATE())/indicador.dias) <=0.8 THEN 'V'
            WHEN (TIMESTAMPDIFF(DAY,sr.inicio_ajuste, CURDATE())/indicador.dias) >0.8 AND (TIMESTAMPDIFF(DAY,sr.inicio_ajuste, CURDATE())/indicador.dias) <=1 THEN 'A'
            WHEN (TIMESTAMPDIFF(DAY,sr.inicio_ajuste, CURDATE())/indicador.dias) >1 THEN 'R'
        END as tipo_i
        from siniestro_reportes sr
        left join siniestro_tramite tramite on sr.id=tramite.id_siniestro and tramite.id=(select max(tre.id) from siniestro_tramite tre where tre.id_siniestro=sr.id)
        left join tipo_coberturas_gmm tcg on tramite.cobertura_id=tcg.id
        left join siniestro_tramite_danos stg on tramite.tipo_tramite=stg.id
        left join (select * from indicadores i where cliente_id=0 and sub_tipo_id=1) indicador on sr.id_tipo_d=indicador.causa_id
        left join siniestro_estatus_tramites setr on sr.status_id=setr.id
        left join catalog_promotorias p on sr.aseguradora_id=p.idPromotoria
        where sr.tipo_r='D'
        AND indicador.id is not null
        and siniestro_estatus IN ('ACTIVO')
        and sr.fecha_fin is NULL;";
        $query = $this->db->query($SQL);
        return $query->result_array();
    }

    function NewNotificaiconesGMM()
    {
        $SQL = "SELECT sr.asegurado_nombre,
        p.Promotoria compania, st.fecha_inicio fecha, sr.siniestro_estatus Estado, TIMESTAMPDIFF(DAY,st.fecha_inicio, CURDATE()) tiempo, stg.nombre tipo,
        sr.tipo_r modulo,(TIMESTAMPDIFF(DAY,sr.inicio_ajuste, CURDATE())/indicador.dias) as porcentaje,
        CASE
            WHEN (TIMESTAMPDIFF(DAY,sr.inicio_ajuste, CURDATE())/indicador.dias) <=0.8 THEN 'V'
            WHEN (TIMESTAMPDIFF(DAY,sr.inicio_ajuste, CURDATE())/indicador.dias) >0.8 AND (TIMESTAMPDIFF(DAY,sr.inicio_ajuste, CURDATE())/indicador.dias) <=1 THEN 'A'
            WHEN (TIMESTAMPDIFF(DAY,sr.inicio_ajuste, CURDATE())/indicador.dias) >1 THEN 'R'
        END as tipo_i
        from siniestro_tramite st
        left join tipo_coberturas_gmm tcg on st.cobertura_id=tcg.id
        left join siniestro_tramite_gmm stg on st.tipo_tramite=stg.id
        left join (select * from indicadores i where cliente_id=0 AND i.sub_tipo_id='3') as indicador on st.tipo_tramite=indicador.causa_id
        left join siniestro_estatus_tramites setr on st.estatus=setr.id
        left join siniestro_reportes sr on st.id_siniestro=sr.id 
        left join catalog_promotorias p on sr.aseguradora_id=p.idPromotoria
        where sr.tipo_r='G'
        AND indicador.id is not null
        and sr.siniestro_estatus IN ('ACTIVO')
        and sr.fecha_fin is NULL;";
        $query = $this->db->query($SQL);
        return $query->result_array();
    }

    function NewNotificaiconesAC()
    {
        $SQL = "SELECT sp.compania , s.fecha_siniestro fecha,st.nombre tipo, s.siniestro_estatus estado, TIMESTAMPDIFF(DAY,s.fecha_siniestro, CURDATE()) tiempo, sp.cliente as asegurado_nombre
        ,'C' modulo,(TIMESTAMPDIFF(DAY,s.fecha_siniestro, CURDATE())/indicador.dias) as porcentaje,
        CASE
            WHEN (TIMESTAMPDIFF(DAY,s.fecha_siniestro, CURDATE())/indicador.dias) <=0.8 THEN 'V'
            WHEN (TIMESTAMPDIFF(DAY,s.fecha_siniestro, CURDATE())/indicador.dias) >0.8 AND (TIMESTAMPDIFF(DAY,s.fecha_siniestro, CURDATE())/indicador.dias) <=1 THEN 'A'
            WHEN (TIMESTAMPDIFF(DAY,s.fecha_siniestro, CURDATE())/indicador.dias) >1 THEN 'R'
        END as tipo_i
        from siniestro s
        inner join siniestro_poliza_n sp on s.siniestro_poliza_id=sp.id
        left join siniestro_tipo st on s.tipo_siniestro_id=st.id
        left join (select * from indicadores i where cliente_id=0) indicador on s.tipo_siniestro_id=indicador.causa_id";
        $query = $this->db->query($SQL);
        return $query->result_array();
    }

    function getAllUserNotificaciones()
    {
        $SQL = "SELECT * FROM notificacion_siniestros_alertas a";
        $query = $this->db->query($SQL);
        return $query->result_array();
    }

    function getUserByPersona($id)
    {
        $SQL = "SELECT u.email correo from persona p
        inner join users u on p.idPersona=u.idPersona
        where p.idPersona='" . $id . "';";
        $query = $this->db->query($SQL);
        return $query->result_array();
    }

    function getTotalMes($tipo, $mes, $year)
    {
        $SQL = '';
        switch ($tipo) {
            case 'A':
                $SQL = "SELECT 
                count(id) total
                from siniestro_reportes s
                WHERE YEAR(s.inicio_ajuste)='" . $year . "' and month(s.inicio_ajuste)='" . $mes . "'
                AND s.tipo_r='A' 
                and s.fecha_fin is NULL;";
                break;
            case 'G':
                $SQL = "SELECT 
                count(id) total
                from siniestro_reportes s
                WHERE YEAR(s.inicio_ajuste)='" . $year . "' and month(s.inicio_ajuste)='" . $mes . "'
                and s.tipo_r='G' 
                and s.fecha_fin is NULL;";
                break;
            case 'D':
                $SQL = "SELECT 
                count(id) total
                from siniestro_reportes s
                WHERE YEAR(s.inicio_ajuste)='" . $year . "' and month(s.inicio_ajuste)='" . $mes . "'
                and s.tipo_r='D' 
                and s.fecha_fin is NULL;";
                break;
            case 'C':
                $SQL = "SELECT count(id) total
                from siniestro s
                WHERE YEAR(s.fecha_siniestro)='" . $year . "' and month(s.fecha_siniestro)='" . $mes . "'";
                break;
        }

        $query = $this->db->query($SQL);
        return $query->result_array();
    }

    function getTotaProm($tipo, $year)
    {
        $SQL = '';
        switch ($tipo) {
            case 'A':
                $SQL = "SELECT 
                ROUND(sum(TIMESTAMPDIFF(DAY,s.inicio_ajuste, CURDATE()))/count(id)) prom 
                from siniestro_reportes s
                WHERE YEAR(s.inicio_ajuste)='" . $year . "' 
                AND s.tipo_r='A';";
                break;
            case 'G':
                $SQL = "SELECT 
                ROUND(sum(TIMESTAMPDIFF(DAY,s.inicio_ajuste, CURDATE()))/count(id)) prom 
                from siniestro_reportes s
                WHERE YEAR(s.inicio_ajuste)='" . $year . "' 
                and s.tipo_r='G';";
                break;
            case 'D':
                $SQL = "SELECT 
                ROUND(sum(TIMESTAMPDIFF(DAY,s.inicio_ajuste, CURDATE()))/count(id)) prom 
                from siniestro_reportes s
                WHERE YEAR(s.inicio_ajuste)='" . $year . "' 
                and s.tipo_r='D';";
                break;
            case 'C':
                $SQL = "SELECT ROUND(sum(TIMESTAMPDIFF(DAY,s.fecha_siniestro, CURDATE()))/count(id)) prom 
                from siniestro s
                WHERE YEAR(s.fecha_siniestro)='" . $year . "';";
                break;
        }

        $query = $this->db->query($SQL);
        return $query->result_array();
    }

    function SendAllNewCorreos()
    {
        date_default_timezone_set("America/Guatemala");
        //Optenemos todos los sininestros
        $S_AI = $this->NewNotificaiconesAutosI();
        $S_D = $this->NewNotificaiconesDanos();
        $S_G = $this->NewNotificaiconesGMM();
        $S_AC = $this->NewNotificaiconesAC();

        //Union de todos los siniestros
        $fullRegistros = array_merge($S_AI, $S_D, $S_G, $S_AC);

        //Usuarios configurados
        $getAllUser = $this->getAllUserNotificaciones();

        $newArray = array();
        //Se agrega un solo array con todos los tipos
        foreach ($getAllUser as $key => $value) {
            $newArray[$value["usuario"]]["tipo"][] = $value["tipo"] . "_" . $value["modulo"];
            //$newArray[$value["usuario"]]["modulo"][] = $value["tipo"];
        }

        //Se hace el el total
        $tabla = array();
        $tablaString = "";
        foreach ($newArray as $key1 => $val) {
            $tabla = array();
            foreach ($fullRegistros as $key2 => $item) {
                if (in_array($item["tipo_i"] . "_" . $item["modulo"], $val["tipo"])) {
                    $tabla[] = $item;
                    $tablaString = $tablaString . "<tr style='text-align: center; font-size: 14px;'><td>{$item["asegurado_nombre"]}</td><td>{$item["fecha"]}</td><td>{$item["tipo"]}</td><td>{$item["modulo"]}</td><td>{$item["Estado"]}</td><td>{$item["tiempo"]}</td><td>{$item["compania"]}</td></tr>";
                }
            }
            $data = array();
            $data["tabla"] = $tablaString;
            $html = $this->load->view('documentos/templateCorreo/notificaciones1.php', [], true);
            $parsedHtml = $this->parseTemplate($html, $data);

            //Id persona
            $idPersona = $key1;
            $user = $this->getUserByPersona($idPersona);
            $dataC = array();
            $dataC['para'] = $user[0]["correo"];
            $dataC['asunto'] = "Notificacion";
            $dataC['mensaje'] = $parsedHtml;
            $ActualDay = date("N");
            if (count($tabla) > 0 && ($ActualDay != "6" && $ActualDay != "7")) {
                $this->enviarCorreo($dataC);
            }
        }
    }

    function SendAdminCorreo()
    {
        $this->load->model('graficas_model', 'graficas');
        $year = date('Y');
        $AI = $this->graficas->getKPI_Siniestros("AUTOSI", null, $year, 6);
        $AC = $this->graficas->getKPI_Siniestros("AUTOSC", null, $year, 6);
        $D = $this->graficas->getKPI_Siniestros("DANOS", null, $year, 6);
        $G = $this->graficas->getKPI_Siniestros("GMM", null, $year, 6);

        $dataParse = array();
        $dataParse["i_nuevos_mes"] = $this->getTotalMes('A', date('m'), date('Y'))[0]["total"];
        $dataParse["i_total"] = $AI["Totales"]["Total"];
        $dataParse["i_en_tiempo"] = $AI["Totales"]["Total_verde"] + $AI["Totales"]["Total_ambar"];
        $dataParse["i_fuera_tiempo"] = $AI["No_Finalizado"]["rojo"];
        $dataParse["i_tiempo_promedio"] = round($this->getTotaProm('A', date('Y'))[0]["prom"],2);

        $dataParse["c_nuevos_mes"] = $this->getTotalMes('C', date('m'), date('Y'))[0]["total"];
        $dataParse["c_total"] = $AC["Totales"]["Total"];
        $dataParse["c_en_tiempo"] = $AC["Totales"]["Total_verde"] + $AC["Totales"]["Total_ambar"];
        $dataParse["c_fuera_tiempo"] = $AC["No_Finalizado"]["rojo"];
        $dataParse["c_tiempo_promedio"] = round($this->getTotaProm('C', date('Y'))[0]["prom"],2);

        $dataParse["g_nuevos_mes"] = $this->getTotalMes('G', date('m'), date('Y'))[0]["total"];
        $dataParse["g_total"] = $G["Totales"]["Total"];
        $dataParse["g_en_tiempo"] = $G["Totales"]["Total_verde"] + $G["Totales"]["Total_ambar"];
        $dataParse["g_fuera_tiempo"] = $G["No_Finalizado"]["rojo"];
        $dataParse["g_tiempo_promedio"] = round($this->getTotaProm('G', date('Y'))[0]["prom"],2);

        $dataParse["d_nuevos_mes"] = $this->getTotalMes('D', date('m'), date('Y'))[0]["total"];
        $dataParse["d_total"] = $D["Totales"]["Total"];
        $dataParse["d_en_tiempo"] = $D["Totales"]["Total_verde"] + $D["Totales"]["Total_ambar"];
        $dataParse["d_fuera_tiempo"] = $D["No_Finalizado"]["rojo"];
        $dataParse["d_tiempo_promedio"] = round($this->getTotaProm('D', date('Y'))[0]["prom"]);

        $dataParse["Total1"] = $dataParse["i_nuevos_mes"]+ $dataParse["c_nuevos_mes"]+ $dataParse["g_nuevos_mes"]+  $dataParse["d_nuevos_mes"];
        $dataParse["Total2"] = $dataParse["i_total"]+$dataParse["c_total"]+$dataParse["d_total"]+$dataParse["d_total"];
        $dataParse["Total3"] = $dataParse["i_en_tiempo"] + $dataParse["c_en_tiempo"]+$dataParse["g_en_tiempo"]+$dataParse["d_en_tiempo"];
        $dataParse["Total4"] = $dataParse["i_fuera_tiempo"]+$dataParse["c_fuera_tiempo"]+$dataParse["g_fuera_tiempo"]+$dataParse["d_fuera_tiempo"];
        $dataParse["Total5"] = $dataParse["i_tiempo_promedio"]+$dataParse["c_tiempo_promedio"]+$dataParse["g_tiempo_promedio"]+$dataParse["d_tiempo_promedio"];

        $html = $this->load->view('documentos/templateCorreo/admin.php', [], true);
        $parsedHtml = $this->parseTemplate($html, $dataParse);

        //Id persona
        $user = $this->getUserByPersona("6");
        $dataC = array();
        $dataC['para'] = $user[0]["correo"];
        $dataC['asunto'] = "Notificacion";
        $dataC['mensaje'] = $parsedHtml;
        $ActualDay = date("N");
        //$this->enviarCorreo($dataC);
        if ($ActualDay != "6" && $ActualDay != "7") {
            $this->enviarCorreo($dataC);
        }
    }


    function enviarCorreo($array)
    {
        $guardaMensaje['desde'] = "Avisos de GAP<avisosgap@aserorescpital.com>";
        $guardaMensaje['para'] = $array['para'];
        $guardaMensaje['asunto'] = $array['asunto'];
        $guardaMensaje['mensaje'] = $array['mensaje'];
        //$guardaMensaje['identificaModulo'] = $array['identificaModulo'];
        $guardaMensaje['status'] = 0;

        $guardaMensaje['fechaEnvio'] = date("Y-m-d H:i");
        $this->db->insert('envio_correos', $guardaMensaje);
    }

    public function parseTemplate($template, $variables)
    {
        foreach ($variables as $key => $value) {
            $template = str_replace('{{ ' . $key . ' }}', $value, $template);
        }
        return $template;
    }
}
