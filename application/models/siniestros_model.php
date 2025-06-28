<?php
class siniestros_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function Siniestro_Add($datos)
    {
        $this->db->trans_begin();

        $siniestro_general = array(
            "num_reporte" => $datos["num_reporte"],
            "num_sininestro" => $datos["num_sininestro"],
            "estado" => $datos["estado"],
            "ciudad" => $datos["ciudad"],
            "estatus_t" => $datos["estatus_t"],
            "serie" => $datos["serie"],
            "uso" => $datos["uso"],
            "tipo_siniestro_id" => $datos["tipo_siniestro_id"],
            "causa_sininestro_id" => $datos["causa_sininestro_id"],
            "responsabilidad" => $datos["responsabilidad"],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],

        );

        $siniestro_deducible = array(
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
        );

        $siniestro_valores_reserva = array(
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
        );

        $siniestro_tramite = array(
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],
            "" => $datos[""],

        );

        $this->db->insert('siniestros', $datos);
        $insert_id = $this->db->insert_id();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
        return $insert_id;
    }

    function getAllData($tabla)
    {
        $tipos = $this->db->get($tabla);
        return $tipos->result_array();
    }

    function getAllTipoSiniestros()
    {
        $this->db->where('active', 1);
        $tipos = $this->db->get('siniestro_tipo');
        return $tipos->result_array();
    }

    function getTipoTramiteByTipoCausa($tipo, $causa)
    {
        $this->db->where('sc.tipo_siniestro_id', $tipo);
        $this->db->where('sc.id', $causa);
        $obj = $this->db->get('siniestro_causa sc');
        return $obj->row();
        //return $obj->result_array();
    }

    function getEstados()
    {
        $tipos = $this->db->get('catalog_estados');
        return $tipos->result_array();
    }

    function SaveOrUpdate_2024($data)
    {
        $response = "";
        $this->db->trans_begin(); //Inicio de la trassaccion

        $id = isset($data['siniestro_form']['id']) ? $data['siniestro_form']['id'] : 0;
        if ($id == 0 || $id == '') { //se guarda el siniestro

            //Inser poliza
            if (!$data["siniestro_poliza"]["id"]) {
                $this->db->insert('siniestro_poliza_n', $data["siniestro_poliza"]);
                $insert_id_poliza = $this->db->insert_id();
            } else {
                $insert_id_poliza = $data["siniestro_poliza"]["id"];
            }



            //Insert siniestro
            $data["siniestro_form"]["siniestro_poliza_id"] = $insert_id_poliza;
            $data["siniestro_form"]["modulo"] = "AC";
            $this->db->insert('siniestro', $data["siniestro_form"]);
            $insert_id_siniestro = $this->db->insert_id();
            $response = $insert_id_siniestro;

            //Insert siniestro_deducible
            $data["siniestro_deducible"]["siniestro_id"] = $insert_id_siniestro;
            $this->db->insert('siniestro_deducible', $data["siniestro_deducible"]);

            //Insert sininestro_valores_reserva
            $data["siniestro_reserva"]["siniestro_id"] = $insert_id_siniestro;
            $this->db->insert('siniestro_valores_reserva', $data["siniestro_reserva"]);

            //Insert siniestro_tramite_n
            $data["siniestro_tramite"]["siniestro_id"] = $insert_id_siniestro;
            $this->db->insert('siniestro_tramite_autos_n', $data["siniestro_tramite"]);
        } else { //Actualizar los registros

            $response = $id;
            //Se actualiza la poliza
            $id_poliza = isset($data['siniestro_form']['siniestro_poliza_id']) ? $data['siniestro_form']['siniestro_poliza_id'] : 0;
            $this->db->where('id', $id_poliza);
            $this->db->update('siniestro_poliza_n', $data["siniestro_poliza"]);

            //se actuliza el siniestro
            $data["siniestro_form"]["estatus_t"] = (int)$data["siniestro_form"]["estatus_t"];
            $this->db->where('id', $id);
            $this->db->update('siniestro', $data["siniestro_form"]);

            //Se actualiza deducible siniestro_id
            $this->db->where('siniestro_id', $id);
            $this->db->update('siniestro_deducible', $data["siniestro_deducible"]);

            //Se actualiza sininestro_valores_reserva
            $this->db->where('siniestro_id', $id);
            $this->db->update('siniestro_valores_reserva', $data["siniestro_reserva"]);

            //se actualiza siniestro_tramite_n
            $this->db->where('siniestro_id', $id);
            $this->db->update('siniestro_tramite_autos_n', $data["siniestro_tramite"]);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            //$response = true;
            $this->db->trans_commit();
        }

        return $response; //id del siniestro
    }

    function SaveOrUpdate($data)
    {
        $response = "";
        $this->db->trans_begin(); //Inicio de la trassaccion

        $id = isset($data['siniestro_form']['id']) ? $data['siniestro_form']['id'] : 0;
        if ($id == 0 || $id == '') { //se guarda el siniestro

            //Inser poliza
            if (!$data["siniestro_poliza"]["Id"]) {
                $this->db->insert('siniestro_corporativo_polizas', $data["siniestro_poliza"]);
                $insert_id_poliza = $this->db->insert_id();
            } else {
                $insert_id_poliza = $data["siniestro_poliza"]["Id"];
            }



            //Insert siniestro
            $data["siniestro_form"]["siniestro_poliza_id"] = $insert_id_poliza;
            $data["siniestro_form"]["modulo"] = "AC";
            $this->db->insert('siniestro', $data["siniestro_form"]);
            $insert_id_siniestro = $this->db->insert_id();
            $response = $insert_id_siniestro;

            //Insert siniestro_deducible
            $data["siniestro_deducible"]["siniestro_id"] = $insert_id_siniestro;
            $this->db->insert('siniestro_deducible', $data["siniestro_deducible"]);

            //Insert sininestro_valores_reserva
            $data["siniestro_reserva"]["siniestro_id"] = $insert_id_siniestro;
            $this->db->insert('siniestro_valores_reserva', $data["siniestro_reserva"]);

            //Insert siniestro_tramite_n
            $data["siniestro_tramite"]["siniestro_id"] = $insert_id_siniestro;
            $this->db->insert('siniestro_tramite_autos_n', $data["siniestro_tramite"]);
        } else { //Actualizar los registros

            $response = $id;
            //Se actualiza la poliza
            $id_poliza = isset($data['siniestro_form']['siniestro_poliza_id']) ? $data['siniestro_form']['siniestro_poliza_id'] : 0;
            $this->db->where('Id', $id_poliza);
            $this->db->update('siniestro_corporativo_polizas', $data["siniestro_poliza"]);

            //se actuliza el siniestro
            $data["siniestro_form"]["estatus_t"] = (int)$data["siniestro_form"]["estatus_t"];
            $this->db->where('id', $id);
            $this->db->update('siniestro', $data["siniestro_form"]);

            //Se actualiza deducible siniestro_id
            $this->db->where('siniestro_id', $id);
            $this->db->update('siniestro_deducible', $data["siniestro_deducible"]);

            //Se actualiza sininestro_valores_reserva
            $this->db->where('siniestro_id', $id);
            $this->db->update('siniestro_valores_reserva', $data["siniestro_reserva"]);

            //se actualiza siniestro_tramite_n
            $this->db->where('siniestro_id', $id);
            $this->db->update('siniestro_tramite_autos_n', $data["siniestro_tramite"]);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            //$response = true;
            $this->db->trans_commit();
        }

        return $response; //id del siniestro
    }

    function getSiniestro($id)
    {
        $data = [];
        $data["siniestro_form"] = (array)$this->db->where('id', $id)->get('siniestro')->row();
        $data["siniestro_poliza"] = (array)$this->db->where('Id', $data["siniestro_form"]["siniestro_poliza_id"])->get('siniestro_corporativo_polizas')->row();
        //$data["siniestro_poliza"] = (array)$this->db->where('id', $data["siniestro_form"]["siniestro_poliza_id"])->get('siniestro_poliza_n')->row();
        $data["siniestro_deducible"] = (array)$this->db->where('siniestro_id', $data["siniestro_form"]["id"])->get('siniestro_deducible')->row();
        $data["siniestro_reserva"] = (array)$this->db->where('siniestro_id', $data["siniestro_form"]["id"])->get('siniestro_valores_reserva')->row();
        $data["siniestro_tramite"] = (array)$this->db->where('siniestro_id', $data["siniestro_form"]["id"])->get('siniestro_tramite_autos_n')->row();
        //get Template
        $tm = (array)$this->db->where('id', $data["siniestro_form"]["causa_siniestro_id"])->get('siniestro_causa')->row();
        $data["template"] = $tm["tipo_template"];
        return $data;
    }

    function getTablaSiniestrosNew($Filtros, $clientes)
    {

        $sql = "SELECT count(id) total FROM siniestro sr; ";
        $data = $this->db->query($sql);
        $total = $data->row_array();
        $isfiltered = false;

        $this->db->select("sr.*,i.dias parametro,TIMESTAMPDIFF(DAY, sr.fecha_reporte, CURDATE()) progreso,st.nombre TipoNombre, sc.nombre TipoCausa,seg.opcion SeguimientoOpc,
        (select nt.color from siniestro_estatus_tramites nt where sr.siniestro_estatus=nt.nombre) siniestro_color,sp.Poliza as poliza,sett.nombre etapa,se.nombre estatusSeguimiento ", false);
        $this->db->join("siniestro_corporativo_polizas sp", "sr.siniestro_poliza_id=sp.id", "left");
        $this->db->join("siniestro_tipo st", "sr.tipo_siniestro_id=st.id", "left");
        $this->db->join("siniestro_estatus_seguimiento seg", "sr.seguimiento_id=seg.id", "left");
        $this->db->join("siniestro_causa sc", "sr.causa_siniestro_id=sc.id", "left");
        $this->db->join("(select * from indicadores i where cliente_id=0) as i", "sr.tipo_siniestro_id=i.causa_id", "left");
        $this->db->join("siniestro_etapa sett", "sr.etapa_id=sett.id", "left");
        $this->db->join("siniestro_estatus se", "sr.estatus_s_id=se.id", "left");

        //Filtros de la vista
        if ($Filtros["search"] != '') {
            $this->db->like("sc.nombre", $Filtros["search"])
                ->or_like("sp.Poliza", $Filtros["search"])
                ->or_like("st.nombre", $Filtros["search"])
                ->or_like("sr.num_reporte", $Filtros["search"])
                //->or_like("seg.opcion", $Filtros["seguimiento"])
                ->or_like("sr.num_siniestro", $Filtros["search"]);
            $isfiltered = true;
        }
        if ($Filtros["seguimiento"] != '') {
            $this->db->like->or_like("seg.opcion", $Filtros["seguimiento"]);
        }
        if ($Filtros["finicio"] != '') {
            $this->db->where('sr.fecha_siniestro >=', $Filtros["finicio"]);
            $isfiltered = true;
        }
        if ($Filtros["ffin"] != '') {
            $this->db->where('sr.fecha_terminacion <=', $Filtros["ffin"]);
            $isfiltered = true;
        }
        if (isset($Filtros["evento"])) {
            $this->db->where_in('sr.tipo_siniestro_id', $Filtros["evento"]);
            $isfiltered = true;
        }
        if ($Filtros["estatus_siniestro"] != '') {
            $this->db->where('sr.siniestro_estatus', $Filtros["estatus_siniestro"]);
            $isfiltered = true;
        }
        if ($Filtros["seguimiento"] != '') {
            if ($Filtros["seguimiento"] != "N/A") {
                $this->db->where('seg.id', $Filtros["seguimiento"]);
            } else {
                $this->db->where('seg.opcion is null');
            }
            $isfiltered = true;
        }
        if ($Filtros["etapa"] != '') {
            $this->db->where('sett.id', $Filtros["etapa"]);
            $isfiltered = true;
        }
        if ($Filtros["Eseguimiento"] != '') {
            $this->db->where('se.id', $Filtros["Eseguimiento"]);
            $isfiltered = true;
        }

        //$this->db->where_in("sr.cliente_id",$clientes);
        //$this->db->where('YEAR(sr.fecha_ocurrencia)','2022');
        $this->db->group_by("sr.id");
        $this->db->order_by('sr.fecha_siniestro', 'DESC');
        $tipo = $this->db->get("siniestro sr");

        $offset = $Filtros["start"];
        //$offset=0;
        $dta = $tipo->result_array();


        $test = $this->db->last_query();
        //var_dump($test);
        //log_message('error', $test);

        $dataQ = $this->db->query($test . " LIMIT {$offset}, 10");
        $Rq = $dataQ->result_array();

        $result = array(
            "draw"            => $Filtros["draw"],
            "recordsTotal"    => $total["total"],
            "recordsFiltered" => $isfiltered ? count($dta) : $total["total"],
            "data"            => $Rq,
            "prueba" => $test
        );

        return $result;
    }

    function getAllestatusT()
    {
        $this->db->where('activo', '1');
        $tipos = $this->db->get('siniestro_estatus_tramites');
        return $tipos->result_array();
    }

    function tiposiniestro()
    {
        //$tipos = $this->db->get('siniestro_tipo');
        $this->db->select('st.nombre,st.id');
        //$this->db->where('sr.modulo', 'AC');
        $this->db->join("siniestro_tipo st", "sr.tipo_siniestro_id=st.id", "inner");
        $this->db->group_by("st.id")->order_by('st.nombre', 'ASC');
        $tipos = $this->db->get('siniestro sr');
        return $tipos->result_array();
    }

    function getDocumentsSiniestros($id_siniestro, $tramite)
    {
        $this->db->select('id,nombre,ruta,file_id,url_icono,url_descargar,ruta,referencia,fecha_alta');
        $this->db->where('referencia_id', $id_siniestro);
        $this->db->where('referencia', $tramite);
        $tipos = $this->db->get('documentos');
        return $tipos->result_array();
    }

    function addSeguimiento($data)
    {
        $this->db->insert('seguimiento', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function getSeguimientoAC($id, $tramite)
    {
        $sql = "select s.comentario,s.fecha_alta fecha_add,u.name_complete usuario
        from seguimiento s
        left join users u on s.usuario_id=u.idPersona
        where s.referencia_id=" . $id . " and s.referencia='AUTOS_C' and s.nombre_tramite='" . $tramite . "' order by s.id DESC;";
        $data = $this->db->query($sql);
        return $data->result_array();
    }

    function saveRefaccion($data)
    {
        $this->db->insert('siniestro_refacciones', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function getRefacciones($id_siniestro)
    {
        $this->db->where('siniestro_id', $id_siniestro);
        $data = $this->db->get('siniestro_refacciones');
        return $data->result_array();
    }

    function getStatusTramites()
    {
        $this->db->where('modulo IS NOT NULL', null, false);
        $data = $this->db->get('siniestro_estatus');
        return $data->result_array();
    }

    function getStatusTramitesByEtapa()
    {
        $this->db->where('id_etapa IS NOT NULL', null, false);
        $data = $this->db->get('siniestro_estatus');
        return $data->result_array();
    }

    function delete_doc_drive($id)
    {
        $this->db->where('file_id', $id);
        $this->db->delete('documentos');
    }

    function getDtaFiltrosTablero($dta)
    {
        switch ($dta["tipo_r"]) {
            case 'DEDUCIBLES':
                $this->db->select("sp.poliza,
                IFNULL(NULL,DATE_FORMAT(s.fecha_reporte, '%d/%m/%Y')) fecha_siniestro,
                s.num_reporte,
                s.economico,
                s.modelo,
                s.ano año,
                st.nombre tipo_siniestro,
                'DEDUCIBLE' Concepto,
                CONCAT('$', FORMAT(sd.demerito, 2, 'es_MX')) demerito, 
                CONCAT('$', FORMAT(svr.deducible, 2, 'es_MX')) deducible,
                IFNULL(NULL,DATE_FORMAT(sd.fecha_solicitud, '%d/%m/%Y')) fecha_solicitud,
                IFNULL(NULL,DATE_FORMAT(sd.fecha_pago_deducible, '%d/%m/%Y')) fecha_pago", false);
                if ($dta['estatus_d'] != "") {
                    $this->db->where("sd.estatus_deducible REGEXP ", '\'' . $dta['estatus_d'] . '\'', false);
                }
                break;
            case 'PERDIDA_TOTAL':
                $this->db->select("
                IFNULL(NULL,DATE_FORMAT(s.fecha_reporte, '%d/%m/%Y')) fecha_siniestro,
                s.num_reporte,
                s.economico,
                s.modelo,
                s.ano año,
                st.nombre tipo_siniestro,
                IFNULL(NULL,DATE_FORMAT(sta.fecha_notificacion, '%d/%m/%Y')) fecha_notif,
                IFNULL(NULL,DATE_FORMAT(sta.fecha_documentacion, '%d/%m/%Y')) fecha_docum,
                IFNULL(NULL,DATE_FORMAT(sta.fecha_pago, '%d/%m/%Y')) fecha_pago,
                CONCAT('$', FORMAT(svr.suma_asegurada, 2, 'es_MX')) suma_asegurada, 
                CONCAT('$', FORMAT(svr.pagado, 2, 'es_MX')) pagado,
                ", false);
                $this->db->where("sta.estatus_pt IS NOT NULL");
                break;
            case 'PENALIZACION':
                $this->db->select("
                IFNULL(NULL,DATE_FORMAT(s.fecha_reporte, '%d/%m/%Y')) fecha_siniestro,
                s.num_reporte,
                s.economico,
                s.modelo,
                s.ano año,
                st.nombre tipo_siniestro,
                IFNULL(NULL,DATE_FORMAT(sta.fecha_pago, '%d/%m/%Y')) fecha_pago,
                sta.dias_penalizacion,
                CONCAT('$', FORMAT((sta.dias_penalizacion * sta.monto_dia), 2, 'es_MX')) total_penalizacion,
                IFNULL(NULL,DATE_FORMAT(sta.fecha_pago_penalizacion, '%d/%m/%Y')) fecha_pago, 
                ", false);
                $this->db->where("sta.estatus_pt IS NOT NULL");
                break;
            case 'ROBOS':
                $this->db->select("
                IFNULL(NULL,DATE_FORMAT(s.fecha_reporte, '%d/%m/%Y')) fecha_siniestro,
                s.num_reporte,
                s.economico,
                s.modelo,
                s.ano año,
                st.nombre tipo_siniestro,
                sc.nombre causa_siiestro,
                IFNULL(NULL,DATE_FORMAT(sta.fecha_localizacion, '%d/%m/%Y')) fecha_localizacion,
                IFNULL(NULL,DATE_FORMAT(sta.fecha_recuperacion, '%d/%m/%Y')) fecha_recuperacion,
                IFNULL(NULL,DATE_FORMAT(sta.fecha_liberacion, '%d/%m/%Y')) fecha_liberacion, 
                ", false);
                $this->db->where("st.id", 3363);
                break;
            case 'DETENIDOS':
                $this->db->select("
                IFNULL(NULL,DATE_FORMAT(s.fecha_reporte, '%d/%m/%Y')) fecha_siniestro,
                s.num_reporte,
                s.economico,
                s.modelo,
                s.ano año,
                st.nombre tipo_siniestro,
                sc.nombre causa_siiestro,
                IFNULL(NULL,DATE_FORMAT(sta.fecha_acreditacion, '%d/%m/%Y')) fecha_acreditacion,
                IFNULL(NULL,DATE_FORMAT(sta.fecha_dictamen, '%d/%m/%Y')) fecha_dictamen,
                IFNULL(NULL,DATE_FORMAT(sta.fecha_liberacion, '%d/%m/%Y')) fecha_liberacion, 
                ", false);
                $this->db->where_not_in('st.id', array(3147, 27609));
                break;
            case 'VIAL':
                $this->db->select("
                IFNULL(NULL,DATE_FORMAT(s.fecha_reporte, '%d/%m/%Y')) fecha_siniestro,
                s.num_reporte,
                s.economico,
                s.modelo,
                s.ano año,
                st.nombre tipo_siniestro,
                sc.nombre causa_siiestro,
                CONCAT('$', FORMAT(costo_total, 2, 'es_MX')) costo_total,
                CONCAT('$', FORMAT(costo_carga_cia, 2, 'es_MX')) costo_cargo_cia,
                CONCAT('$', FORMAT(costo_carga_na, 2, 'es_MX')) costo_carga_na,
                IFNULL(NULL,DATE_FORMAT(sta.fecha_pago, '%d/%m/%Y')) fecha_pago
                ", false);
                $this->db->where("st.id", 27609);
                break;
            case 'CRISTALES':
                $this->db->select("
                IF(s.estatus_t=1,'SI','NO') t_de_hertz,
                IFNULL(NULL,DATE_FORMAT(s.fecha_reporte, '%d/%m/%Y')) fecha_siniestro,
                s.num_reporte,
                s.num_siniestro,
                s.economico,
                s.modelo,
                s.ano año,
                st.nombre tipo_siniestro,
                sc.nombre causa_siiestro,
                ce.estado,
                s.ciudad,
                sta.fecha_surtido,
                sta.fecha_surtido_bo,
                sta.fecha_cita,
                sta.fecha_instalacion,
                sta.fecha_entrega,
                sta.estatus_reparacion,
                IF(sta.exitencia_check=1,'SI','NO')existencia
                ", false);
                //$this->db->where("sta.estatus_t", 1);
                $this->db->where_in('s.tipo_siniestro_id', array(3147));
                break;
            case 'REPARACION':
                $this->db->select("
                IF(s.estatus_t=1,'SI','NO') t_de_hertz,
                IFNULL(NULL,DATE_FORMAT(s.fecha_reporte, '%d/%m/%Y')) fecha_siniestro,
                s.num_reporte,
                s.num_siniestro,
                s.economico,
                s.modelo,
                s.ano año,
                ce.estado,
                s.ciudad,
                st.nombre tipo_siniestro,
                sc.nombre causa_siiestro,
                s.responsabilidad,
                sta.nombre_taller,
                sta.ciudad_reparacion,
                svr.suma_asegurada,
                IFNULL(NULL,DATE_FORMAT(sta.fecha_ingreso, '%d/%m/%Y')) fecha_ingreso,
                IFNULL(NULL,DATE_FORMAT(sta.fecha_termino_reparacion, '%d/%m/%Y')) fecha_termino_reparacion,
                IFNULL(NULL,DATE_FORMAT(sta.fecha_entrega_unidad, '%d/%m/%Y')) fecha_entrega_unidad,
                sta.estatus_reparacion,
                ", false);
                $this->db->where_not_in('s.tipo_siniestro_id', array(3147, 27609));
                //$this->db->where("sta.estatus_t", 1);
                break;
            default:
                $this->db->select('*');
                break;
        }

        //Fechas
        if ($dta["f_inicio"] != "") {
            $this->db->where('s.fecha_reporte >=', $dta["f_inicio"]);
        }
        if ($dta["f_fin"] != "") {
            $this->db->where('s.fecha_terminacion <=', $dta["f_fin"]);
        }

        //cliente
        if (isset($dta["cliente"])) {
            if (count($dta["cliente"]) > 0) {
                $c_filter = array_filter($dta["cliente"]);
                if (count($c_filter) > 0) {
                    $this->db->where("sp.cliente REGEXP ", '\'' . join("|", $c_filter) . '\'', false);
                }
            }
        }

        //compania
        if (isset($dta["compania"])) {
            if (count($dta["compania"]) > 0) {
                $c_filter = array_filter($dta["compania"]);
                if (count($c_filter) > 0) {
                    $this->db->where("sp.compania REGEXP ", '\'' . join("|", $c_filter) . '\'', false);
                }
            }
        }

        //compania
        if (isset($dta["poliza"])) {
            if (count($dta["poliza"]) > 0) {
                $c_filter = array_filter($dta["poliza"]);
                if (count($c_filter) > 0) {
                    $this->db->where("sp.poliza REGEXP ", '\'' . join("|", $c_filter) . '\'', false);
                }
            }
        }

        $this->db->join("catalog_estados ce", "s.estado=ce.clave", "left");
        $this->db->join("siniestro_tramite_autos_n sta", "s.id=sta.siniestro_id", "left");
        $this->db->join("siniestro_poliza_n sp", "s.siniestro_poliza_id=sp.id", "inner");
        $this->db->join("siniestro_tipo st", "s.tipo_siniestro_id=st.id", "inner");
        $this->db->join("siniestro_causa sc", "s.causa_siniestro_id=sc.id", "inner");
        $this->db->join("siniestro_deducible sd", "s.id=sd.siniestro_id", "inner");
        $this->db->join("siniestro_valores_reserva svr", "s.id=svr.siniestro_id", "inner");
        $this->db->order_by('s.fecha_reporte', 'ASC');
        $data = $this->db->get('siniestro s');
        $sql = $this->db->last_query();

        return $data->result_array();
    }

    //metodo para los reportes de estatus t y reparaciones
    function getReporteAcumulado($tipo, $valor)
    {
        $this->db->select('count(*) busqueda');
        if ($tipo == 1) {
            $this->db->where("sta.estatus_t", 1);
        }
        $this->db->where("s.siniestro_estatus", "ACTIVO");
        $this->db->where("sta.estatus_reparacion REGEXP ", $valor, false);
        $this->db->join("siniestro_tramite_autos_n sta", "s.id=sta.siniestro_id", "left");
        $data = $this->db->get('siniestro s');
        $sql = $this->db->last_query();
        return $data->result_array();
    }

    function getValuesallReporte($flota)
    {
        $sql = "select 
        " . $flota . " TotalFlota,
        (select count(*) from siniestro where year(fecha_siniestro)=2023 and modulo='AC' and tipo_siniestro_id not in (27609)) TotalS,
        (select count(*) from siniestro where year(fecha_siniestro)=2023 and modulo='AC' and tipo_siniestro_id=3147) TotalC,
        (select count(*) from siniestro where year(fecha_siniestro)=2023 and modulo='AC' and tipo_siniestro_id not in (3147,27609)) TotalRE,
        (select count(*) from siniestro where year(fecha_siniestro)=2023 and modulo='AC' and tipo_siniestro_id=3147 and estatus_t=1) TotalCRT,
        (select count(*) from siniestro where year(fecha_siniestro)=2023 and modulo='AC' and tipo_siniestro_id not in (3147,27609) and estatus_t=1) TotalRET,
        (select count(*) from siniestro s inner join siniestro_tramite_autos_n sta on s.id=sta.siniestro_id where year(s.fecha_siniestro)=2023 and s.modulo='AC' and s.tipo_siniestro_id not in (3147,27609) and sta.estatus_reparacion REGEXP 'SURTIDO DE REFACCION EN BO CON FECHA|SURTIDO DE REFACCIONES CON FECHA') SurtidoRefConFechaRE,
        (select count(*) from siniestro s inner join siniestro_tramite_autos_n sta on s.id=sta.siniestro_id where year(s.fecha_siniestro)=2023 and s.modulo='AC' and s.tipo_siniestro_id not in (3147,27609) and sta.estatus_reparacion REGEXP 'SURTIDO DE REFACCIONES SIN FECHA|SURTIDO DE REFACCION EN BO SIN FECHA') SurtidoRefSinFechaRE,
        (select count(*) from siniestro s inner join siniestro_tramite_autos_n sta on s.id=sta.siniestro_id where year(s.fecha_siniestro)=2023 and s.modulo='AC' and s.tipo_siniestro_id not in (3147,27609) and sta.estatus_reparacion REGEXP 'PIEZAS COMPLETAS CON FECHA DE ENTREGA|SOLO MANO DE OBRA CON FECHA') PiezasCompletasConFechaRE,
        (select count(*) from siniestro s inner join siniestro_tramite_autos_n sta on s.id=sta.siniestro_id where year(s.fecha_siniestro)=2023 and s.modulo='AC' and s.tipo_siniestro_id not in (3147,27609) and sta.estatus_reparacion REGEXP 'PIEZAS COMPLETAS SIN FECHA DE ENTREGA|SOLO MANO DE OBRA SIN FECHA') PiezasCompletasSinFechaRE,
        (select count(*) from siniestro s inner join siniestro_tramite_autos_n sta on s.id=sta.siniestro_id where year(s.fecha_siniestro)=2023 and s.modulo='AC' and s.tipo_siniestro_id not in (3147,27609) and sta.estatus_reparacion REGEXP 'ELABORACION DE PRESUPUESTO|ESPERA DE VALUACION') ProcesoValuacionRE,
        (select count(*) from siniestro s inner join siniestro_tramite_autos_n sta on s.id=sta.siniestro_id where year(s.fecha_siniestro)=2023 and s.modulo='AC' and s.tipo_siniestro_id not in (3147,27609) and sta.estatus_reparacion REGEXP 'PENDIENTE DE INGRESAR') PendienteIngresoRE,
        (select count(*) from siniestro s inner join siniestro_tramite_autos_n sta on s.id=sta.siniestro_id where year(s.fecha_siniestro)=2023 and s.modulo='AC' and s.tipo_siniestro_id=3147 and sta.estatus_reparacion REGEXP 'SURTIDO DE CRISTAL CON FECHA|SURTIDO DE CRISTAL EN BO CON FECHA') SurtidoRefConFechaCR,
        (select count(*) from siniestro s inner join siniestro_tramite_autos_n sta on s.id=sta.siniestro_id where year(s.fecha_siniestro)=2023 and s.modulo='AC' and s.tipo_siniestro_id=3147 and sta.estatus_reparacion REGEXP 'SURTIDO DE CRISTAL EN BO SIN FECHA|SURTIDO DE CRISTAL EN BO SIN FECHA') SurtidoRefSinFechaCR,
        (select count(*) from siniestro s inner join siniestro_tramite_autos_n sta on s.id=sta.siniestro_id where year(s.fecha_siniestro)=2023 and s.modulo='AC' and s.tipo_siniestro_id=3147 and sta.estatus_reparacion REGEXP 'CON CITA PROGRAMADA') PiezasCompletasConFechaCR,
        (select count(*) from siniestro s inner join siniestro_tramite_autos_n sta on s.id=sta.siniestro_id where year(s.fecha_siniestro)=2023 and s.modulo='AC' and s.tipo_siniestro_id=3147 and sta.estatus_reparacion REGEXP 'SIN CITA PROGRAMADA') PiezasCompletasSinFechaCR,
        (select count(*) from siniestro s inner join siniestro_tramite_autos_n sta on s.id=sta.siniestro_id where year(s.fecha_siniestro)=2023 and s.modulo='AC' and s.tipo_siniestro_id=3147 and sta.estatus_reparacion REGEXP 'NA') ProcesoValuacionCR,
        (select count(*) from siniestro s inner join siniestro_tramite_autos_n sta on s.id=sta.siniestro_id where year(s.fecha_siniestro)=2023 and s.modulo='AC' and s.tipo_siniestro_id=3147 and sta.estatus_reparacion REGEXP 'SIN REPORTE') PendienteIngresoCR;";
        $data = $this->db->query($sql);
        return $data->result_array()[0];
    }

    //metodos para el modal de polizas
    public function getTablePolizas_old($Filtros)
    {

        $sql = "SELECT count(id) total from siniestro_poliza_n; ";
        $data = $this->db->query($sql);
        $total = $data->row_array();
        $isfiltered = false;

        $this->db->select("*", false);

        if ($Filtros["search"] != '') {
            $this->db->like("s.cliente", $Filtros["search"])
                ->or_like("s.vendedor", $Filtros["search"])
                ->or_like("s.inciso", $Filtros["search"])
                ->or_like("s.compania", $Filtros["search"])
                ->or_like("s.poliza", $Filtros["search"]);
            $isfiltered = true;
        }
        if ($Filtros["finicio"] != '') {
            $this->db->where('s.f_inicio >=', $Filtros["finicio"]);
            $isfiltered = true;
        }
        if ($Filtros["ffin"] != '') {
            $this->db->where('s.f_fin <=', $Filtros["ffin"]);
            $isfiltered = true;
        }

        $this->db->group_by("s.id");
        $this->db->order_by('s.f_inicio', 'DESC');
        $tipo = $this->db->get("siniestro_poliza_n s");

        $offset = $Filtros["start"];

        $dta = $tipo->result_array();
        $test = $this->db->last_query();
        $dataQ = $this->db->query($test . " LIMIT {$offset}, 10");
        $Rq = $dataQ->result_array();

        if ($Filtros["search"] == "" && $Filtros["tipo"] == 2) {
            $result = array(
                "draw"            => $Filtros["draw"],
                "recordsTotal"    => 0,
                "recordsFiltered" => 0,
                "data"            => [],
                "prueba" => $test
            );
        } else {
            $result = array(
                "draw"            => $Filtros["draw"],
                "recordsTotal"    => $total["total"],
                "recordsFiltered" => $isfiltered ? count($dta) : $total["total"],
                "data"            => $Rq,
                "prueba" => $test
            );
        }


        return $result;
    }

    public function getTablePolizas($Filtros)
    {

        $sql = "SELECT count(id) total from siniestro_corporativo_polizas;";
        $data = $this->db->query($sql);
        $total = $data->row_array();
        $isfiltered = false;

        $this->db->select("*", false);

        if ($Filtros["search"] != '') {
            $this->db->like("s.Poliza", $Filtros["search"])
                ->or_like("s.Descripcion", $Filtros["search"])
                ->or_like("s.Modelo", $Filtros["search"])
                ->or_like("s.Serie", $Filtros["search"])
                ->or_like("s.Endoso", $Filtros["search"])
                ->or_like("s.Economico", $Filtros["search"]);
            $isfiltered = true;
        }
        if ($Filtros["finicio"] != '') {
            $this->db->where('s.FDesde >=', $Filtros["finicio"]);
            $isfiltered = true;
        }
        if ($Filtros["ffin"] != '') {
            $this->db->where('s.FDesde <=', $Filtros["ffin"]);
            $isfiltered = true;
        }

        $this->db->group_by("s.Id");
        $this->db->order_by('s.FDesde', 'DESC');
        $tipo = $this->db->get("siniestro_corporativo_polizas s");

        $offset = $Filtros["start"];

        $dta = $tipo->result_array();
        $test = $this->db->last_query();
        $dataQ = $this->db->query($test . " LIMIT {$offset}, 10");
        $Rq = $dataQ->result_array();

        if ($Filtros["search"] == "" && $Filtros["tipo"] == 2) {
            $result = array(
                "draw"            => $Filtros["draw"],
                "recordsTotal"    => 0,
                "recordsFiltered" => 0,
                "data"            => [],
                "prueba" => $test
            );
        } else {
            $result = array(
                "draw"            => $Filtros["draw"],
                "recordsTotal"    => $total["total"],
                "recordsFiltered" => $isfiltered ? count($dta) : $total["total"],
                "data"            => $Rq,
                "prueba" => $test
            );
        }


        return $result;
    }

    //validacion de siniestro
    function ExistSiniestro($num_reporte, $num_siniestro)
    {
        $tipos = $this->db->where('num_reporte', $num_reporte)->or_where('num_siniestro', $num_siniestro)->where('modulo', 'AC')->get('siniestro');
        return empty($tipos->result_array()) ? true : false;
    }

    function ExistPoliza($poliza)
    {
        //$tipos = $this->db->where('poliza', $poliza)->get('siniestro_poliza_n');
        $tipos = $this->db->where('Poliza', $poliza)->get('siniestro_corporativo_polizas');
        return empty($tipos->result_array()) ? true : false;
    }

    function getAllSiniestroByPoliza($poliza)
    {
        $tipos = $this->db->where('siniestro_poliza_id', $poliza)->get('siniestro');
        $var = $tipos->result_array();
        return empty($tipos->result_array()) ? true : false;
    }

    function deletePoliza($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('siniestro_poliza_n');
    }

    function udpateOrSavePoliza($data)
    {
        unset($data['accion']);
        if ($data["Id"] == 0) {
            //$this->db->insert('siniestro_poliza_n', $data);
            //$insert_id_poliza = $this->db->insert_id();
            $this->db->insert('siniestro_corporativo_polizas', $data);
            $insert_id_poliza = $this->db->insert_id();
        } else {
            //$this->db->where('id', $data['id']);
            //$this->db->update('siniestro_poliza_n', $data);
            $this->db->where('Id', $data['Id']);
            $this->db->update('siniestro_corporativo_polizas', $data);
        }
    }

    function GetExistPoliza($poliza)
    {
        //$tipos = $this->db->where('id', $poliza)->get('siniestro_poliza_n');
        $tipos = $this->db->where('Id', $poliza)->get('siniestro_corporativo_polizas');
        return $tipos->row_array();
    }
}
