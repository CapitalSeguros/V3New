<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Evaluaciones extends TIC_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library(array('form_validation', 'common'));
        $this->load->model('evaluaciones_model', 'evaluacion');
        $this->load->model('evaluacion_periodos_model', 'periodo');
        $this->load->model("personamodelo", "persona");
        $this->load->model('incidenciasmodel', 'incidencia');
        $this->load->model('notificacionmodel', 'notificacion');
    }

    function index()
    {
        //$this->comprobarpermiso($_SERVER['REQUEST_URI'],$this->tank_auth->get_idPersona());
        $head = array("title" => "Capsys - Evaluaciones");
        $data = array();
        $footer = array();
        $this->breadcrumbs->push('Evaluaciones', 'evaluaciones');
        $this->breadcrumbs->unshift('Inicio', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['controlador'] = $_SERVER['REQUEST_URI'];
        //opcion para mostar el menu lateral
        $data["tipo"] = "CapitalHumano";
        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            )
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JS',
                'path' => 'gap/js/datatables.min.js'
            ), array(
                'type' => 'JS',
                'path' => 'gap/js/evaluacion.table.js'
            )
        ));
        $this->render('evaluacion/index', $head, $data, $footer);
    }

    public function getData()
    {
        $data = $this->evaluacion->get_evaluaciones();
        $this->responseJSON("200", "Éxito", $data);
    }

    function nuevo()
    {
        $head = array("title" => "Capsys - Nueva evaluación");
        $data = array();
        $footer = array();
        $this->breadcrumbs->push('Nuevo', 'nuevo');
        $this->breadcrumbs->unshift('Evaluaciones', '/evaluaciones');
        $this->breadcrumbs->unshift('Inicio', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data["tipo"] = "CapitalHumano";

        $this->footerScripts(array(
            array(
                'type' => 'JS',
                'path' => 'js/fileupload/public/bundle-evaluaciones.js'
            ), array(
                'type' => 'JS',
                'path' => 'gap/js/evaluacion.nuevo.js'
            )
        ));
        $this->render('evaluacion/nuevo', $head, $data, $footer);
    }


    public function editar($id)
    {
        $head = array("title" => "Capsys - Editar evaluación");
        $data = array();
        $footer = array();
        $this->breadcrumbs->push('Editar', 'editar');
        $this->breadcrumbs->unshift('Evaluaciones', '/evaluaciones');
        $this->breadcrumbs->unshift('Inicio', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data["id"] = $id;
        $data["tipo"] = "CapitalHumano";
        // $this->headerScripts(array(
        //     array(
        //         'type' => 'CSS',
        //         'path' => 'gap/css/datatables.min.css'
        //     )
        // ));

        $this->footerScripts(array(
            array(
                'type' => 'JS',
                'path' => 'js/fileupload/public/bundle-evaluaciones.js'
            ), array(
                'type' => 'JS',
                'path' => 'gap/js/evaluacion.nuevo.js'
            )
        ));
        $this->render('evaluacion/nuevo', $head, $data, $footer);
    }

    public function aplicar($id)
    {
        $head = array('title' => 'Capsys - Aplicar evaluacion');
        $data = array();
        $footer = array();
        $emp =   $this->periodo->selectEvaluacionEmpleadoById($id);
        if ($emp == null) {
            $_i_p = $this->tank_auth->get_idPersona();
            redirect("/miInfo");
            return;
        }

        $data['evaluacion'] = $emp;
        $data['id'] = $id;
        $data['tipo_pregunta'] = $this->evaluacion->getTipoPregunta();
        $this->breadcrumbs->push('Aplicar', '/');
        //$this->breadcrumbs->unshift('Evaluaciones', '/evaluaciones');
        $this->breadcrumbs->unshift('Inicio', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            )
        ));

        $this->footerScripts(array(
            array(
                'type' => 'JS',
                'path' => 'gap/js/survey.jquery.min.js'
            ), array(
                'type' => 'JS',
                'path' => 'gap/js/datatables.min.js'
            ), array(
                'type' => 'JS',
                'path' => 'gap/js/speakingurl.min.js'
            ), array(
                'type' => 'JS',
                'path' => 'gap/js/evaluacion.util.js'
            ), array(
                'type' => 'JS',
                'path' => 'gap/js/evaluacion.aplicar.js'
            )
        ));
        $this->render('evaluacion/aplicar', $head, $data, $footer);
    }

    public function visor()
    {
        //$this->comprobarpermiso($_SERVER['REQUEST_URI'],$this->tank_auth->get_idPersona());
        $head = array("title" => "Capsys - Evaluaciones");
        $data = array();
        $footer = array();
        $this->breadcrumbs->push('Evaluaciones', 'evaluaciones');
        $this->breadcrumbs->unshift('Inicio', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data["puestoUsuario"] = $this->tank_auth->get_idPersonaPuesto();
        $data["IdUsuario"] = $this->tank_auth->get_idPersona();
        //opcion para mostar el menu lateral
        $data["tipo"] = "CapitalHumano";
        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            )
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JS',
                'path' => 'gap/js/datatables.min.js'
            ), array(
                'type' => 'JS',
                'path' => 'js/filemanager/public/bundle.js'
            )
        ));
        $this->render('evaluacion/prueba', $head, $data, $footer);
    }

    public function getBy()
    {
        $id = $this->input->get("id", true);
        $evaluacion = $this->evaluacion->getEvaluacionId($id);

        $this->responseJSON("200", "Exíto", $evaluacion->data);
    }

    public function updateChart()
    {
        $djason = json_decode(file_get_contents("php://input"));
        $this->responseJSON("200", "Exíto", $djason);
    }

    public function perfil()
    {
        $_ip = $this->tank_auth->get_idPersona();
        $empleados = $this->persona->getEmpleados();
        $_puestos = $this->persona->getPuestos();
        $obPeriodo = $this->periodo->activo();
        $lsIncidencias = $this->incidencia->getIncidenciasByfechas($obPeriodo->fecha_inicio, $obPeriodo->fecha_final, $_ip);
        $evIncidencias = $this->global["evaluacion_incidencias"];

        $years = array(
            date('Y', strtotime($obPeriodo->fecha_inicio)),
            date('Y', strtotime($obPeriodo->fecha_final))
        );

        $years = array_unique($years);

        $dias_festivos = $this->common->getDateHoliday($years);
        $dias_laborales = $this->common->getDiasHabiles($obPeriodo->fecha_inicio, $obPeriodo->fecha_final, $dias_festivos);
        $periodo = $this->global["tiempo"][$obPeriodo->tiempo_periodo];
        $nDias = count($dias_laborales);
        $eval_incidencias = array();
        foreach ($evIncidencias as $k => $v) {
            $noInci = array_filter($lsIncidencias, function ($it) use ($v) {
                return in_array($it->tipo_incidencias_id, $v["valor"]);
            });

            array_push($eval_incidencias, array(
                "titulo" => $v["titulo"],
                "subtitulo" => $v["subtitulo"],
                "dias" => count($noInci),
                "subtitulo_1" => "Total de dias en el $periodo",
                "dias_laborados" => $nDias,
                "total" => (((count($noInci) / $nDias) - 1) * -1)
            ));
        }

        $data = array(
            "nDias" => $nDias,
            "evaluacion_incidencias" => $eval_incidencias
        );

        $this->breadcrumbs->push('Perfil', 'persona/perfil');
        $this->breadcrumbs->unshift('Inicio', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        //opcion para mostar el menu lateral
        $data["tipo"] = "CapitalHumano";

        $head = array("title" => "Capsys - Evaluaciones");
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _empleados = " . json_encode($empleados) . "; const _puestos = " . json_encode($_puestos) . ";"
            ),
            array(
                'type' => 'JS',
                'path' => 'js/fileupload/public/bundle-modal-filtro.js'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/reporte.js'
            )
        ));
        $footer = array();
        $this->render('evaluacion/resultado', $head, $data, $footer);
        // $this->render('evaluacion/evaluacion_incidencia', $head, $data, $footer);
    }

    public function pendientes()
    {
        $data = array();
        $_ip = $this->tank_auth->get_idPersona();

        $data["pendientes"] = array();

        $obPersona = $this->persona->obtener($_ip);
        if (!empty($obPersona)) {
            $obPuesto = $this->persona->obtenerPuestoBy($obPersona->idPersonaPuesto);
            if (!empty($obPuesto)) {
                $idp = 12;
                $evEmpleados = $this->periodo->selectEvaluacionesByEmpelado($idp, $_ip);
                $data["pendientes"] = $evEmpleados;
            }
        }

        $head = array("title" => "Capsys - Evaluaciones");

        $footer = array();
        $this->breadcrumbs->push('Evaluaciones', 'evaluaciones');
        $this->breadcrumbs->unshift('Inicio', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        //opcion para mostar el menu lateral
        $data["tipo"] = "CapitalHumano";
        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            )
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JS',
                'path' => 'gap/js/datatables.min.js'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/evaluacion.table.js'
            )
        ));
        $this->render('evaluacion/pendientes', $head, $data, $footer);
    }

    public function get()
    {
        $this->load->model('competenciasmodel', 'competencia');
        $this->load->model('evaluacion_tipo_model', 'evaluacion_tipo');
        $tipo = $this->input->get("tipo", true);
        $competencias = array();
        $puestos = array();
        $puestos2 = array();
        $tipos = array();
        $evaluaciones = array();

        if ($tipo == "periodo") {
            $evaluaciones = $data = $this->evaluacion->get_evaluaciones(true);
            $puestos = $this->persona->get_Puestos();
            $puestos2 = $this->getPuestos();
        }
        $competencias = $this->competencia->getCompetencias();
        $tipos = $this->evaluacion_tipo->select();

        //Se añaden los tres puestos
        $ranks = $this->periodo->getRankActivo();
        $id = 0;
        foreach ($ranks as $key => $value) {
            $id = $id + 1000;
            $puestos[] = array(
                "id" => $id,
                "name" => $value["rank"],
                "parent" => 0,
                "idPersonaPuestoGrupo" => 0
            );
        }

        $this->responseJSON("200", "Exíto", array(
            "competencia" => $competencias,
            "puesto" => $puestos,
            "puestos2" => $puestos2,
            "tipos" => $tipos,
            "evaluaciones" => $evaluaciones,
            "minDate" => $this->config->item('min_date')
        ));
    }

    public function post()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $djason = json_decode(file_get_contents("php://input"));

            $data = array(
                "evaluacion" => array(
                    "titulo" => $djason->titulo,
                    "tipo_periodo" => $djason->tiempo_evaluacion,
                    "descripcion" => $djason->descripcion,
                    "fecha_registro" => date("Y-m-d"),
                    "creado_por" => $this->tank_auth->get_idPersona(),
                    "estatus" => "ACTIVO",
                    "tipo_evaluacion_id" => $djason->tipos_evaluaciones,
                ),
                // "evaluados" => array(),
                // "evaluadores" => array(),
                "competencias" => array()
            );
            $insert_id = intval($djason->id);

            $result = new \stdClass;
            $result->ok = true;

            $this->evaluacion->db->trans_begin();
            if ($insert_id == 0) {
                $insert_id  =  $this->evaluacion->inserteEvaluaciones($data["evaluacion"]);
            } else {
                $this->evaluacion->updateEvaluaciones($insert_id, array(
                    "titulo" => $data["evaluacion"]["titulo"],
                    "tipo_periodo" => $data["evaluacion"]["tipo_periodo"],
                    "descripcion" => $data["evaluacion"]["descripcion"],
                    "fecha_registro" => $data["evaluacion"]["fecha_registro"],
                    "modificado_por" => $this->tank_auth->get_idPersona(),
                    "tipo_evaluacion_id" => $data["evaluacion"]["tipo_evaluacion_id"],
                ));
                $this->evaluacion->delCompetenciaBy($insert_id);
            }

            foreach ($djason->competencias as $key => $value) {
                array_push($data["competencias"], array(
                    "evaluacion_id" => $insert_id,
                    "competencias_id" => $value->id,
                    "grado" => $value->grado
                ));
            }
            // foreach ($djason->evaluados as $key => $value) {
            //     $insert_id  =  $this->evaluacion->inserteEvaluaciones($data["evaluacion"]);

            //     $data["evaluacion"]["empleado_id"] = $value->id;

            //     // foreach ($djason->evaluadores as $key => $value) {
            //     //     array_push($data["evaluadores"], array(
            //     //         "evaluaciones_id" => $insert_id,
            //     //         "relacion_id" => $value->id,
            //     //         "relacion" => "empleado"
            //     //     ));
            //     // }
            //     foreach ($djason->competencias as $key => $value) {
            //         array_push($data["competencias"], array(
            //             "evaluaciones_id" => $insert_id,
            //             "competencias_id" => $value->id,
            //             "grado" => $value->grado
            //         ));
            //     }
            //     // array_push($data["evaluados"], array(
            //     //     "evaluacion_id" => $insert_id,
            //     //     "empleado_id" => $value->id
            //     // ));
            // }

            // $this->evaluacion->insertEvaluacion_evaluados_batch($data["evaluados"]);
            // $this->evaluacion->insertEvaluacion_relacion_batch($data["evaluadores"]);
            $this->evaluacion->insertEvaluacion_competencia_batch($data["competencias"]);


            if ($this->evaluacion->db->trans_status() === FALSE && $result->ok === false) {
                $this->evaluacion->db->trans_rollback();
                $this->responseJSON("400", "Ocurrio un error al guardar la información", null);
            } else {
                $this->evaluacion->db->trans_commit();
                $this->responseJSON("200", "Se guardo con éxito", null);
            }
        }
    }

    public function delete()
    {
        $id = $this->input->post("id", true);
        $id = intval($id);
        if ($this->evaluacion->updateDelete($id, $this->tank_auth->get_idPersona())) {
            $this->responseJSON("200", "Èxito", null);
        } else {
            $this->responseJSON("400", "Ocurrio un error al dar de baja la evaluación", null);
        }
    }

    public function getEmpleadoByPuesto()
    {
        $id = $this->input->get("id", true);
        $ids = explode(",", $id);
        $data = $this->evaluacion->get_EmpleadoByPuesto($ids);
        $this->responseJSON("200", "Exíto", $data);
    }

    public function eve_competencia($id)
    {
        $respuestas = $this->periodo->getRespuestasEmpleadoByid($id);
        $gRespuestas = $this->group_by("competencia", $respuestas);
        $data = array(
            "respuestas" => $gRespuestas,
            "persona" => $this->periodo->getPersonaResultado($id)
        );
        $template = $this->load->view('evaluacion/evaluacion_competencia_resultado', $data, true);

        $this->responseJSON("200", "Èxito", $template);
    }


    public function listado($periodoId)
    {

        $obPeriodo = $this->periodo->selectById($periodoId);
        $evs = $this->periodo->get_evaluacionesEmpleadoByPeriodo($periodoId); ///trae las evaluaciones
        $allempleados = $this->periodo->getusuariosEvaluados($periodoId); //empleados evaluados

        $data = array();
        $data["usuarios"] = array();
        $data["totales"] = $this->periodo->getTotalesEvaluacion($periodoId);
        $data["periodo"] = $obPeriodo;
        $data["Calificaciones"] = $this->periodo->CailiFEval($periodoId);
        foreach ($allempleados as $key => $value) {
            array_push($data["usuarios"], array(
                "id" => $value->empleado_id,
                "Puesto" => $value->personaPuesto,
                "puestoid" => $value->idPuesto,
                "nombre" => $value->nombres,
                "Promedio" => $value->promedio,
                "bono" => 0,
                //"bono" => $this->periodo->getBono(round(intval($value->promedio), 2), $value->idPuesto),
                "PEvaluaciones" => $this->periodo->getPromedioEvaluaciones($periodoId, $value->empleado_id),
                "tipo" => $value->puesto_id
            ));
            //array_push();
        }
        $data["ranks"] = array(
            1000,
            2000,
            3000,
        );

        $data["ranksRel"] = array(
            1000 => "BRONCE",
            2000 => "ORO",
            3000 => "PLATINO VIP"
        );

        $this->breadcrumbs->push('Perfil', 'persona/perfil');
        $this->breadcrumbs->unshift('Inicio', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        //opcion para mostar el menu lateral
        $data["tipo"] = "CapitalHumano";

        ///es para indicar los bonos en caso de que haya
        $data["bonos"] = "bonos";

        $head = array("title" => "Capsys - Evaluaciones");
        $this->footerScripts(array(
            array(
                'type' => 'JS',
                'path' => 'gap/js/modal.preview.js'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/evaluaciones.resultado.js'
            ),
        ));
        $footer = array();
        $test = $data;
        $this->render('evaluacion/tablero', $head, $data, $footer);
    }

    public function listado2($periodoId)
    {
        $obPeriodo = $this->periodo->selectById($periodoId);
        $evs = $this->periodo->get_evaluacionesEmpleadoByPeriodo($periodoId); ///trae las evaluaciones
        // $resultado = $this->periodo->getResultadoByEmpleado($periodoId, $id);
        // print_r($evs);
        $data = array();
        $data["evals"] = array();
        $data["periodo"] = $obPeriodo;

        foreach ($evs as $key => $value) {
            $empls = $this->periodo->selectEvaluacionEmpleadoEstado($periodoId, $value->id);
            $incomplete = $this->periodo->getCompleteTest($periodoId, $value->id);

            array_push($data["evals"], array(
                "id" => $value->id,
                "evaluacion" => $value->titulo,
                "empleados" => $empls,
                "result" => $incomplete
            ));
        }

        $data["ranks"] = array(
            1000,
            2000,
            3000,
        );

        $data["ranksRel"] = array(
            1000 => "BRONCE",
            2000 => "ORO",
            3000 => "PLATINO VIP"
        );

        $this->breadcrumbs->push('Periodos', 'evaluaciones/tablero/' . $periodoId);
        $this->breadcrumbs->unshift('Inicio', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        //opcion para mostar el menu lateral
        $data["tipo"] = "CapitalHumano";
        $data["InfoPeriodo"] = $this->periodo->getInfoPeriodo($periodoId);
        $head = array("title" => "Capsys - Evaluaciones");
        $this->footerScripts(array(
            array(
                'type' => 'JS',
                'path' => 'gap/js/modal.preview.js'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/evaluaciones.resultado.js'
            ),
        ));
        $footer = array();
        $this->render('evaluacion/tablero2', $head, $data, $footer);
    }


    public function resultado_completo($periodoId, $id)
    {
        $obPeriodo = $this->periodo->selectById($periodoId);
        // $resultado = $this->periodo->getResultadoByEmpleado($periodoId, $id);
        $evs = $this->periodo->get_evaluacionesByEmpleado($periodoId, $id);
        $data = array(
            "evaluaciones" => $evs
        );
        $order = array();
        foreach ($evs as $key => $value) {
            $source = $this->periodo->selectEvaluacionAllByEmpleado($periodoId, $id, $value->tipo_evaluacion_id);
            if (!empty($source)) {
                if ($value->nombre == "360") {
                    $data["c360"] = $source;
                    array_push($order, 'c360');
                } else {
                    $data[strtolower($value->nombre)] = $source;
                    array_push($order, strtolower($value->nombre));
                }
            }
        }
        /* array_push($order,'c360');
        array_push($order,'incidencias'); */

        $lsIncidencias = $this->incidencia->getIncidenciasByfechas($obPeriodo->fecha_inicio, $obPeriodo->fecha_final, $id);
        $evIncidencias = $this->global["evaluacion_incidencias"];

        $years = array(
            date('Y', strtotime($obPeriodo->fecha_inicio)),
            date('Y', strtotime($obPeriodo->fecha_final))
        );

        $years = array_unique($years);

        $dias_festivos = $this->common->getDateHoliday($years);
        $dias_laborales = $this->common->getDiasHabiles($obPeriodo->fecha_inicio, $obPeriodo->fecha_final, $dias_festivos);
        $periodo = $this->global["tiempo"][$obPeriodo->tiempo_periodo];
        $nDias = count($dias_laborales);
        $eval_incidencias = array();
        foreach ($evIncidencias as $k => $v) {
            $noInci = array_filter($lsIncidencias, function ($it) use ($v) {
                return in_array($it->tipo_incidencias_id, $v["valor"]);
            });

            array_push($eval_incidencias, array(
                "titulo" => $v["titulo"],
                "subtitulo" => $v["subtitulo"],
                "dias" => count($noInci),
                "subtitulo_1" => "Total de dias en el $periodo",
                "dias_laborados" => $nDias,
                "total" => (((count($noInci) / $nDias) - 1) * -1)
            ));
        }

        $data["nDias"] = $nDias;
        $data["evaluacion_incidencias"] = $eval_incidencias;

        $this->breadcrumbs->push('Perfil', 'persona/perfil');
        $this->breadcrumbs->unshift('Inicio', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();

        $head = array("title" => "Capsys - Evaluaciones");
        //opcion para mostar el menu lateral
        $data["tipo"] = "CapitalHumano";
        rsort($order);
        $data["order"] = $order;
        //var_dump($data);
        $this->footerScripts(array(
            array(
                'type' => 'JS',
                'path' => 'gap/js/modal.preview.js'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/evaluaciones.resultado.js'
            ),
        ));
        $footer = array();
        $this->render('evaluacion/resultado', $head, $data, $footer);
    }

    public function resultado($periodoId, $id)
    {
        $obPeriodo = $this->periodo->selectById($periodoId);

        $resultado = $this->periodo->getResultadoByEmpleado($periodoId, $id);
        $obPersona = $this->persona->obtener($id, "");
        $obJefe = $this->persona->obtenerJefe($id);

        $data = array();
        $data["persona"] = $obPersona;
        $data["jefe"] = $obJefe;
        $data["periodo"] = $obPeriodo;
        $data["resultado"] = $resultado;
        // echo '<pre>';
        // print_r($obPersona);
        // die;
        $this->breadcrumbs->push('Perfil', 'persona/perfil');
        $this->breadcrumbs->unshift('Inicio', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();

        $head = array("title" => "Capsys - Evaluaciones");
        //opcion para mostar el menu lateral
        $data["tipo"] = "CapitalHumano";
        $this->footerScripts(array(
            array(
                'type' => 'JS',
                'path' => 'js/fileupload/public/bundle-modal-filtro.js'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/reporte.js'
            )
        ));
        $footer = array();
        $this->render('evaluacion/resultado_evaluacion', $head, $data, $footer);
    }

    /*     public function postRespuesta()
    {
        $start = $this->input->post("start", true);
        $complete = $this->input->post("complete", true);
        $id = $this->input->post('id', true);
        $data = array(
            'evaluacion_p_e_id' => $id,
            'evaluacion_periodo_id' => $this->input->post('ev_p_id', true),
            'empleado_id' => $this->tank_auth->get_idPersona(),
            "porcentaje" => 0,
            'respuesta' => $this->input->post('respuesta')
        );
        $result = new \stdClass();
        $result->ok = true;
        $this->evaluacion->db->trans_begin();
        if ($start == "true") {
            $result->ok = $this->periodo->updateEvaluacionEmpleado($id, array(
                "fecha_aplicacion" => date("Y-m-d H:i:s")
            ));
        }

        if ($result->ok && $complete == "true") {
            $grade = array(
                "A" => [100, 75, 50, 25],
                "B" => [100, 100, 75, 50],
                "C" => [100, 100, 100, 75],
                "D" => [100, 100, 100, 100]
            );
            $alphabet = ["A", "B", "C", "D"];
            $questions = $this->input->post("questions");
            $respuesta = json_decode($data["respuesta"]);
            $final_respuesta = array();
            $sumCalificacion = 0;
            $texto=0;
            //var_dump($respuesta);
            foreach ($respuesta as $key => $value) {
                //obtengo el tipo de pregunta
                $resultT = $this->evaluacion->getTipoCompetencia($key);
                $totalparcial=0;
                if (!empty($resultT)) {
                    switch ($resultT[0]['tipo']) {
                        case '1':
                        case '2':
                            //$texto++;
                            $porcentaje=100;
                            $sumCalificacion += 100;
                            break;
                        case '3':
                        case '4':
                        case '8':
                            $validar=$this->evaluacion->validateRespuesta($value,$resultT[0]["pregunta"]);
                            //var_dump(!empty($validar));
                            !empty($validar)?$sumCalificacion += 100:$sumCalificacion += 0;
                            $porcentaje=!empty($validar)?100: 0;
                            break;
                        case '6':
                            foreach ($value as $key2 => $value2) {
                                $totalparcial+=$value2;
                            }
                            $porcentaje=$totalparcial;
                            $sumCalificacion+=$totalparcial;
                            break;
                    }
                    array_push($final_respuesta, array(
                        'evaluacion_p_e_id' => $id,
                        'evaluacion_periodo_id' => $this->input->post('ev_p_id', true),
                        'empleado_id' => $this->tank_auth->get_idPersona(),
                        "competencia_id" => $resultT[0]["competencia"],
                        "pregunta_id" => $resultT[0]["pregunta"],
                        "porcentaje" => $porcentaje,
                        "respuesta" => $resultT[0]['tipo']=='6'?$totalparcial:$value
                    ));
                } else {
                    $_grado = "";
                    $_cid = 0;
                    $fques = array_filter($questions, function ($it) use ($key, &$_grado, &$_cid) {
                        if ($key == $this->slugify($it["titulo_competencia"])) {
                            $_grado = $it["grado"];
                            $_cid = $it["competencias_id"];
                            return true;
                        }
                        return false;
                    });
                    if (count($fques) == 0)
                        continue;
                    //aqui iria la validacion de esa wea
                    $_grade = $grade[$_grado];

                    foreach ($value as $ky => $vl) {
                        //aqui es donde se obtinen el porcentaje de cada pregunta
                        $_idP = str_replace("preg-", "", $ky);
                        $aIndx =  array_search($vl, $alphabet);
                        $value = $_grade[$aIndx];
                        $sumCalificacion =$sumCalificacion+$value;
                        array_push($final_respuesta, array(
                            'evaluacion_p_e_id' => $id,
                            'evaluacion_periodo_id' => $this->input->post('ev_p_id', true),
                            'empleado_id' => $this->tank_auth->get_idPersona(),
                            "competencia_id" => $_cid,
                            "pregunta_id" => $_idP,
                            "porcentaje" => $value,
                            "respuesta" => $vl
                        ));
                    }
                }
            }
            $data["porcentaje"] = $sumCalificacion / (count($final_respuesta))?:1;
            //var_dump($data["porcentaje"]);
            $result->ok = $this->periodo->updateEvaluacionEmpleado($id, array(
                "fecha_finalizacion" => date("Y-m-d H:i:s"),
                "calificacion" => $data["porcentaje"]
            ));

            if ($result->ok)
                $result = $this->evaluacion->insertEvaluacionRespuestas($final_respuesta); 
        }
         if ($result->ok)
            $result = $this->evaluacion->insertEvaluacionRespuesta($data);

        if ($this->evaluacion->db->trans_status() === FALSE && $result->ok === false) {
            $this->evaluacion->db->trans_rollback();
            $this->responseJSON("400", "Ocurrio un error al guardar la información", null);
        } else {
            $this->evaluacion->db->trans_commit();
            $this->responseJSON("200", "Se guardo con éxito", null);
        }
    } */

    public function postRespuesta()
    {
        $start = $this->input->post("start", true);
        $complete = $this->input->post("complete", true);
        $id = $this->input->post('id', true);
        $data = array(
            'evaluacion_p_e_id' => $id,
            'evaluacion_periodo_id' => $this->input->post('ev_p_id', true),
            'empleado_id' => $this->tank_auth->get_idPersona(),
            "porcentaje" => 0,
            'respuesta' => $this->input->post('respuesta')
        );
        $result = new \stdClass();
        $result->ok = true;
        $this->evaluacion->db->trans_begin();
        if ($start == "true") {
            $result->ok = $this->periodo->updateEvaluacionEmpleado($id, array(
                "fecha_aplicacion" => date("Y-m-d H:i:s")
            ));
        }

        if ($result->ok && $complete == "true") {
            $grade = array(
                "A" => [100, 75, 50, 25],
                "B" => [100, 100, 75, 50],
                "C" => [100, 100, 100, 75],
                "D" => [100, 100, 100, 100]
            );
            $alphabet = ["A", "B", "C", "D"];
            $questions = $this->input->post("questions");
            $respuesta = json_decode($data["respuesta"]);
            $final_respuesta = array();
            $sumCalificacion = 0;
            $texto = 0;
            //var_dump($respuesta);
            foreach ($respuesta as $key => $value) {
                //obtengo el tipo de pregunta
                $resultT = $this->evaluacion->getTipoCompetencia($key);
                $totalparcial = 0;
                if (!empty($resultT)) {
                    switch ($resultT[0]['tipo']) {
                        case '1':
                        case '2':
                            //$texto++;
                            $porcentaje = 100;
                            $sumCalificacion += 100;
                            break;
                        case '3':
                        case '4':
                        case '8':
                            $validar = $this->evaluacion->validateRespuesta($value, $resultT[0]["pregunta"]);
                            //var_dump(!empty($validar));
                            !empty($validar) ? $sumCalificacion += 100 : $sumCalificacion += 0;
                            $porcentaje = !empty($validar) ? 100 : 0;
                            /* $sumCalificacion += $value;
                            $porcentaje=100; */
                            break;
                        case '6':
                            foreach ($value as $key2 => $value2) {
                                $totalparcial += $value2;
                            }
                            /* var_dump($totalparcial);
                            echo '<br>'; */
                            $porcentaje = $totalparcial;
                            $sumCalificacion += $totalparcial;
                            break;
                    }
                    array_push($final_respuesta, array(
                        'evaluacion_p_e_id' => $id,
                        'evaluacion_periodo_id' => $this->input->post('ev_p_id', true),
                        'empleado_id' => $this->tank_auth->get_idPersona(),
                        "competencia_id" => $resultT[0]["competencia"],
                        "pregunta_id" => $resultT[0]["pregunta"],
                        "porcentaje" => $porcentaje,
                        "respuesta" => $resultT[0]['tipo'] == '6' ? $totalparcial : $value
                    ));
                } else {
                    /* echo 'Matrix';
                    echo '<br>'; */
                    $_grado = "";
                    $_cid = 0;
                    $fques = array_filter($questions, function ($it) use ($key, &$_grado, &$_cid) {
                        if ($key == $this->slugify2($it["titulo_competencia"])) {
                            $_grado = $it["grado"];
                            $_cid = $it["competencias_id"];
                            return true;
                        }
                        return false;
                    });
                    if (count($fques) == 0)
                        continue;
                    //aqui iria la validacion de esa wea
                    $_grade = $grade[$_grado];

                    foreach ($value as $ky => $vl) {
                        //aqui es donde se obtinen el porcentaje de cada pregunta
                        $_idP = str_replace("preg-", "", $ky);
                        $aIndx =  array_search($vl, $alphabet);
                        $percent = $_grade[$aIndx];
                        $sumCalificacion = $sumCalificacion + $percent;
                        array_push($final_respuesta, array(
                            'evaluacion_p_e_id' => $id,
                            'evaluacion_periodo_id' => $this->input->post('ev_p_id', true),
                            'empleado_id' => $this->tank_auth->get_idPersona(),
                            "competencia_id" => $_cid,
                            "pregunta_id" => $_idP,
                            "porcentaje" => $percent,
                            "respuesta" => $vl
                        ));
                    }
                }
            }
            $data["porcentaje"] = $sumCalificacion / (count($final_respuesta)) ?: 1;
            $result->ok = $this->periodo->updateEvaluacionEmpleado($id, array(
                "fecha_finalizacion" => date("Y-m-d H:i:s"),
                "calificacion" => $data["porcentaje"]==1?0:$data["porcentaje"]
                //"calificacion" => $data["porcentaje"]
            ));

            if ($result->ok)
                $result = $this->evaluacion->insertEvaluacionRespuestas($final_respuesta);
                $this->sendNotificaciones($id,$this->input->post('ev_p_id', true)); //La notificacion al terminar la evaluacion
        }
        if ($result->ok)
            $result = $this->evaluacion->insertEvaluacionRespuesta($data);

        if ($this->evaluacion->db->trans_status() === FALSE && $result->ok === false) {
            $this->evaluacion->db->trans_rollback();
            $this->responseJSON("400", "Ocurrio un error al guardar la información", null);
        } else {
            $this->evaluacion->db->trans_commit();
            $this->responseJSON("200", "Se guardo con éxito", null);
        }
    }

    public static function slugify2($text)
    {

        $replace = [
            '&lt;' => '', '&gt;' => '', '&#039;' => '', '&amp;' => '',
            '&quot;' => '', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'Ae',
            '&Auml;' => 'A', 'Å' => 'A', 'Ā' => 'A', 'Ą' => 'A', 'Ă' => 'A', 'Æ' => 'Ae',
            'Ç' => 'C', 'Ć' => 'C', 'Č' => 'C', 'Ĉ' => 'C', 'Ċ' => 'C', 'Ď' => 'D', 'Đ' => 'D',
            'Ð' => 'D', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ē' => 'E',
            'Ę' => 'E', 'Ě' => 'E', 'Ĕ' => 'E', 'Ė' => 'E', 'Ĝ' => 'G', 'Ğ' => 'G',
            'Ġ' => 'G', 'Ģ' => 'G', 'Ĥ' => 'H', 'Ħ' => 'H', 'Ì' => 'I', 'Í' => 'I',
            'Î' => 'I', 'Ï' => 'I', 'Ī' => 'I', 'Ĩ' => 'I', 'Ĭ' => 'I', 'Į' => 'I',
            'İ' => 'I', 'Ĳ' => 'IJ', 'Ĵ' => 'J', 'Ķ' => 'K', 'Ł' => 'K', 'Ľ' => 'K',
            'Ĺ' => 'K', 'Ļ' => 'K', 'Ŀ' => 'K', 'Ñ' => 'N', 'Ń' => 'N', 'Ň' => 'N',
            'Ņ' => 'N', 'Ŋ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O',
            'Ö' => 'Oe', '&Ouml;' => 'Oe', 'Ø' => 'O', 'Ō' => 'O', 'Ő' => 'O', 'Ŏ' => 'O',
            'Œ' => 'OE', 'Ŕ' => 'R', 'Ř' => 'R', 'Ŗ' => 'R', 'Ś' => 'S', 'Š' => 'S',
            'Ş' => 'S', 'Ŝ' => 'S', 'Ș' => 'S', 'Ť' => 'T', 'Ţ' => 'T', 'Ŧ' => 'T',
            'Ț' => 'T', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'Ue', 'Ū' => 'U',
            '&Uuml;' => 'Ue', 'Ů' => 'U', 'Ű' => 'U', 'Ŭ' => 'U', 'Ũ' => 'U', 'Ų' => 'U',
            'Ŵ' => 'W', 'Ý' => 'Y', 'Ŷ' => 'Y', 'Ÿ' => 'Y', 'Ź' => 'Z', 'Ž' => 'Z',
            'Ż' => 'Z', 'Þ' => 'T', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a',
            'ä' => 'ae', '&auml;' => 'ae', 'å' => 'a', 'ā' => 'a', 'ą' => 'a', 'ă' => 'a',
            'æ' => 'ae', 'ç' => 'c', 'ć' => 'c', 'č' => 'c', 'ĉ' => 'c', 'ċ' => 'c',
            'ď' => 'd', 'đ' => 'd', 'ð' => 'd', 'è' => 'e', 'é' => 'e', 'ê' => 'e',
            'ë' => 'e', 'ē' => 'e', 'ę' => 'e', 'ě' => 'e', 'ĕ' => 'e', 'ė' => 'e',
            'ƒ' => 'f', 'ĝ' => 'g', 'ğ' => 'g', 'ġ' => 'g', 'ģ' => 'g', 'ĥ' => 'h',
            'ħ' => 'h', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ī' => 'i',
            'ĩ' => 'i', 'ĭ' => 'i', 'į' => 'i', 'ı' => 'i', 'ĳ' => 'ij', 'ĵ' => 'j',
            'ķ' => 'k', 'ĸ' => 'k', 'ł' => 'l', 'ľ' => 'l', 'ĺ' => 'l', 'ļ' => 'l',
            'ŀ' => 'l', 'ñ' => 'n', 'ń' => 'n', 'ň' => 'n', 'ņ' => 'n', 'ŉ' => 'n',
            'ŋ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'oe',
            '&ouml;' => 'oe', 'ø' => 'o', 'ō' => 'o', 'ő' => 'o', 'ŏ' => 'o', 'œ' => 'oe',
            'ŕ' => 'r', 'ř' => 'r', 'ŗ' => 'r', 'š' => 's', 'ù' => 'u', 'ú' => 'u',
            'û' => 'u', 'ü' => 'ue', 'ū' => 'u', '&uuml;' => 'ue', 'ů' => 'u', 'ű' => 'u',
            'ŭ' => 'u', 'ũ' => 'u', 'ų' => 'u', 'ŵ' => 'w', 'ý' => 'y', 'ÿ' => 'y',
            'ŷ' => 'y', 'ž' => 'z', 'ż' => 'z', 'ź' => 'z', 'þ' => 't', 'ß' => 'ss',
            'ſ' => 'ss', 'ый' => 'iy', 'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G',
            'Д' => 'D', 'Е' => 'E', 'Ё' => 'YO', 'Ж' => 'ZH', 'З' => 'Z', 'И' => 'I',
            'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
            'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F',
            'Х' => 'H', 'Ц' => 'C', 'Ч' => 'CH', 'Ш' => 'SH', 'Щ' => 'SCH', 'Ъ' => '',
            'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'YU', 'Я' => 'YA', 'а' => 'a',
            'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo',
            'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l',
            'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's',
            'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch',
            'ш' => 'sh', 'щ' => 'sch', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e',
            'ю' => 'yu', 'я' => 'ya'
        ];

        // make a human readable string
        $text = strtr($text, $replace);

        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d.]+~u', '-', $text);

        // trim
        $text = trim($text, '-');

        // remove unwanted characters
        $text = preg_replace('~[^-\w.]+~', '', $text);

        $text = strtolower($text);

        return $text;
    }

    public static function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    public  function createSlug($string)
    {

        $table = array(
            'Š' => 'S', 'š' => 's', 'Đ' => 'Dj', 'đ' => 'dj', 'Ž' => 'Z', 'ž' => 'z', 'Č' => 'C', 'č' => 'c', 'Ć' => 'C', 'ć' => 'c',
            'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
            'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O',
            'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss',
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e',
            'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o',
            'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'ý' => 'y', 'þ' => 'b',
            'ÿ' => 'y', 'Ŕ' => 'R', 'ŕ' => 'r', '/' => '-', ' ' => '-'
        );

        // -- Remove duplicated spaces
        $stripped = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $string);

        // -- Returns the slug
        return strtolower(strtr($string, $table));
    }

    public function getPreguntas($id, $ide, $idpe, $idp)
    {
        $template = $this->load->view("_templates/evaluacion_introduccion", null, true);
        $data = $this->evaluacion->get_evaluacion_periodo_empleado($id);
        $preguntas = $this->evaluacion->get_preguntas_evaluacion($ide, $idpe, $idp);
        $aplica_id = isset($data->aplica_id) ? $data->aplica_id : 0;
        $padre_id = isset($data->padre_id) ? $data->padre_id : 0;
        $currentUser = $this->tank_auth->get_idPersona();
        $personaEvaluacion = 0;
        if ($aplica_id == $currentUser || $padre_id == $currentUser) {
            $personaEvaluacion = $aplica_id;
        }
        $respuestas = $this->evaluacion->get_respuesta_evaluacion($id, $idpe, $personaEvaluacion);
        $this->responseJSON("200", "Èxito", array(
            'pregunta' => $preguntas->data,
            'respuesta' => $respuestas->data,
            "template" => $template
        ));
    }

    public function pregunta()
    {
        $this->load->View('evaluaciones/pregunta');
    }

    private function _addCompetenciaPregunta()
    {
        $data = array(
            'id' => $this->input->post('id', true),
            'pregunta_id' => $this->input->post('pregunta_id', true)
        );
        return $this->evaluacion->insertCompetencias_preguntas($data);
    }
    private function _addCompetencia()
    {

        $data = array(
            'titulo' => $this->input->post('titulo', true),
            'descripcion' => $this->input->post('descripcion', true)
        );

        return $this->evaluacion->insertCompetencias($data);
    }

    function getTipo()
    {
        $this->load->model('evaluacion_tipo_model', 'evaluacion_tipo');
        $result = $this->evaluacion_tipo->select();
        $this->responseJSON("200", "Èxito", $result);
    }

    function addPregunta()
    {
        $data = array(
            'titulo' => $this->input->post('titulo', true),
            'descripcion' => $this->input->post('descripcion', true),
            'tipo_pregunta_id' => $this->input->post('tipo_pregunta', true),
            'tipo_dato' => '',
            'json_content' => $this->input->post('json', true)
        );
        return $this->evaluacion->insertPregunta($data);
    }

    public function getReporteEvaluaciones()
    {
        $filtros = $this->input->get("puesto");
        $id = $this->input->get("id");
        print_r($filtros);
        $id = intval($id);
        if ($id == 0) {
            $obPeriodo = $this->periodo->activo();
            $id = @$obPeriodo->id;
        }

        $data = $this->evaluacion->getReporteEvaluaciones($id);
        $this->responseJSON("200", "Éxito", $data);
    }

    ////metoddos de pruebas
    function getResgitrorespuesta()
    {
        $grade = array(
            "A" => [100, 75, 50, 25],
            "B" => [100, 100, 75, 50],
            "C" => [100, 100, 100, 75],
            "D" => [100, 100, 100, 100]
        );
        $alphabet = ["A", "B", "C", "D"];
        $final_respuesta = array();
        $sum = 0;
        $count = 0;
        $tabla = $this->evaluacion->getRespuestasJson();
        foreach ($tabla as $key => $fila) {
            if ($fila["fecha_finalizacion"] != '') {
                $jsonPreguntas = json_decode($fila['respuesta'], true);
                //var_dump($jsonPreguntas);echo 'FIN <br>';
                foreach ($jsonPreguntas as $ks => $pregunta) {
                    if (is_array($pregunta)) {
                        //var_dump(str_replace('-',' ',$ks));echo 'FIN <br>';
                        $titulo = str_replace('-', ' ', $ks);
                        $getCompertencia = $this->evaluacion->getCompetenciasGrado($fila['evaluacion_periodo_id'], $fila['evaluacion_id'], $fila['puesto_id'], $titulo);
                        if (!empty($getCompertencia)) {
                            //var_dump($pregunta);echo 'FIN <br>';
                            foreach ($pregunta as $kk => $res) {

                                //echo $kk. ' -sin slug =>'.str_replace('preg-','',$kk).'<br>';
                                //ar_dump($res);echo 'FIN <br>';
                                $grado = $getCompertencia[0]['grado'];
                                //var_dump($grado);
                                $indexP = array_search($res, $alphabet);
                                $valorP = $grade[$grado][$indexP];
                                $sum += $valorP;
                                $count++;
                                echo 'grado=>' . $grado . ' index=>' . $indexP . ' valor=>' . $valorP . ' respuesta=>' . $res . 'id p_e=>' . $fila['evaluacion_p_e_id'];
                                echo ' FIN <br>';
                                if (is_int(intval(str_replace('preg-', '', $kk)))) {
                                    $final_respuesta[] = array(
                                        'evaluacion_p_e_id' => intval($fila['evaluacion_p_e_id']),
                                        'evaluacion_periodo_id' => intval($fila['evaluacion_periodo_id']),
                                        'empleado_id' => intval($fila['empleado_id']),
                                        "competencia_id" => intval($getCompertencia[0]['competencias_id']),
                                        "pregunta_id" => intval(str_replace('preg-', '', $kk)),
                                        "porcentaje" => $valorP,
                                        "respuesta" => $res
                                    );
                                }
                            }
                            echo 'FIN pregubnta <br>';
                        }
                    }
                }
            }
            //echo 'Total='. $sum/$count .' Tabla id='.$fila['evaluacion_p_e_id'].' FIN <br>';
            /* $this->periodo->updateEvaluacionEmpleado($fila['evaluacion_p_e_id'], array(
                "porcentaje" => ''
            ));
            $count=0;
            $sum=0; */
        }
        //var_dump($final_respuesta);
    }
    ////metoddos de pruebas
    function getResgitrorespuesta2()
    {
        $grade = array(
            "A" => [100, 75, 50, 25],
            "B" => [100, 100, 75, 50],
            "C" => [100, 100, 100, 75],
            "D" => [100, 100, 100, 100]
        );
        $alphabet = ["A", "B", "C", "D"];
        $final_respuesta = array();
        $sum = 0;
        $count = 0;
        $tabla = $this->evaluacion->getRespuestasJson();
        foreach ($tabla as $key => $fila) {
            if ($fila["fecha_finalizacion"] != '') {
                $jsonPreguntas = json_decode($fila['respuesta'], true);
                //var_dump($jsonPreguntas);echo 'FIN <br>';
                foreach ($jsonPreguntas as $ks => $pregunta) {
                    if (is_array($pregunta)) {
                        //var_dump(str_replace('-',' ',$ks));echo 'FIN <br>';
                        $titulo = str_replace('-', ' ', $ks);
                        $getCompertencia = $this->evaluacion->getCompetenciasGrado($fila['evaluacion_periodo_id'], $fila['evaluacion_id'], $fila['puesto_id'], $titulo);
                        if (!empty($getCompertencia)) {
                            //var_dump($pregunta);echo 'FIN <br>';
                            foreach ($pregunta as $kk => $res) {

                                //echo $kk. ' -sin slug =>'.str_replace('preg-','',$kk).'<br>';
                                //ar_dump($res);echo 'FIN <br>';
                                $grado = $getCompertencia[0]['grado'];
                                //var_dump($grado);


                                if (is_int(intval(str_replace('preg-', '', $kk)))) {

                                    $indexP = array_search($res, $alphabet);
                                    $valorP = $grade[$grado][$indexP];
                                    $sum += $valorP;
                                    $count++;
                                    echo 'grado=>' . $grado . ' index=>' . $indexP . ' valor=>' . $valorP . ' respuesta=>' . $res . ' id p_e=>' . $fila['evaluacion_p_e_id'];
                                    echo ' FIN <br>';
                                    $final_respuesta[] = array(
                                        'evaluacion_p_e_id' => intval($fila['evaluacion_p_e_id']),
                                        'evaluacion_periodo_id' => intval($fila['evaluacion_periodo_id']),
                                        'empleado_id' => intval($fila['empleado_id']),
                                        "competencia_id" => intval($getCompertencia[0]['competencias_id']),
                                        "pregunta_id" => intval(str_replace('preg-', '', $kk)),
                                        "porcentaje" => $valorP,
                                        "respuesta" => $res
                                    );
                                }
                            }
                            //echo 'FIN pregubnta <br>';
                        }
                    }
                }
            }

            if ($count != 0) {
                echo 'Total=' . $sum / $count . ' Tabla id=' . $fila['evaluacion_p_e_id'] . ' FIN <br>';
                $this->periodo->updateEvaluacionEmpleado($fila['evaluacion_p_e_id'], array(
                    "calificacion" => $sum / $count
                ));
                $sum = 0;
                $count = 0;
            } else {
                $sum = 0;
                $count = 0;
            }
        }
        //var_dump(count($final_respuesta));

    }

    function sendNotificaciones($id, $idPerido)
    {
        $puestosRanking = array(
            1000,
            2000,
            3000
        );

        $puestosRankingNombres = array(
            1000 => "BRONCE",
            2000 => "ORO",
            3000 => "PLATINO VIP"
        );
        //se busca la info con referencia
        $info = $this->periodo->dataNotificacion($id, $idPerido);
        $para = '';
        $iduserPadre='';

        if ($info->info->tipo_evaluacion_id == 5) { //Tipo evaluacion  otra
            //Es un ranking
            if (in_array($info->info->puesto_id, $puestosRanking)) {
                if ($info->usuario->puesto == 0 || $info->usuario->puesto!=null) { //Es agente
                    if ($info->usuario->creador != "CAPITALHUMANO@AGENTECAPITAL.COM") {
                        $para=$info->usuario->creador;
                        $padre=$this->periodo->selectPadreEmail($para);
                        $iduserPadre=$padre->idPersona;
                    }else{
                        $para="COORDINADOR@CAPCAPITAL.COM.MX";
                        $padre=$this->periodo->selectPadreEmail($para);
                        $iduserPadre=$padre->idPersona;
                    }
                } else { //Es usuario
                    $padre=$this->periodo->selectPadre($info->usuario->padrePuesto);
                    $para=$padre->email;
                    $iduserPadre=$padre->idPersona;
                }
            }
        }else{
            $padre=$this->periodo->selectPadre($info->usuario->padrePuesto);
            $para=$padre->email;
            $iduserPadre=$padre->idPersona;
        }


        $data = array(
            "desde" => "Avisos de GAP<avisosgap@aserorescapital.com>",
            "asunto" => "Evaluación Contestada",
            "mensaje" => '<p><span style="color:#0000CD"><span style="font-size:18px">Estimado Usuario:</span></span></p>
            <p><span style="color:#0000CD"><span style="font-size:18px">Se le informa que se ha constestado una evaluación del periodo '.$info->info->titulo.' del usuario '.$info->usuario->name_complete .'</span></span></p>
            <p><span style="color:#0000CD"><span style="font-size:18px">SALUDOS CORDIALES</span></span></p>',
            "para" => $para,
            "status" => 0,
            "fechaEnvio" => date("Y-m-d H:i:s")
        );

        $this->notificacion->insertCorreo($data); //Por correo
        /* $data2 = array(
            "tipo" => "ALERTA",
            "tipo_id" => "email",
            "persona_id" => $iduserPadre,
            "fecha_alta" => date('Y-m-d H:i:s'),
            "email" => $para,
            "comment" => "ENVIADA",
            "referencia" => "ALERTA",
            "referencia_id" => 0
        );
        $this->notificacion->insertNnormal($data2); //por web */
    }
}
