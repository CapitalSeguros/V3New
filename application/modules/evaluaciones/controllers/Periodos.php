<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Periodos extends TIC_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library(array('common'));
        $this->load->model('pipmodel', 'pip');
        $this->load->model('evaluacion_periodos_model', 'evaluacionPeriodo');
        $this->load->model('incidenciasmodel', 'incidencia');
        // include APPPATH . 'third_party/TC/Chart.php';
    }

    public function index()
    {
        ///$this->comprobarpermiso($_SERVER['REQUEST_URI'],$this->tank_auth->get_idPersona());
        $head = array('title' => 'Capsys - Periodo');
        $data = array();
        $footer = array();

        $this->breadcrumbs->push('Periodos de evaluación', 'periodos');
        $this->breadcrumbs->unshift('Inicio', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $_puestos = $this->getPuestos();
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
                'type' => 'JSHTML',
                'data' => "const _puestos = " . json_encode($_puestos)
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/datatables.min.js'
            ), array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ), array(
                'type' => 'JS',
                'path' => 'gap/js/periodo.table.js'
            ), array(
                'type' => 'JS',
                'path' => 'js/fileupload/public/bundle-modalperiodo.js'
            )
        ));
        $this->render('periodo/index', $head, $data, $footer);
    }

    public function add()
    {
        $head = array('title' => 'Capsys - Periodo');
        $data = array();
        $footer = array();

        $this->breadcrumbs->push('Nuevo', 'periodo/add');
        $this->breadcrumbs->unshift('Periodos de evaluación', 'periodos');
        $this->breadcrumbs->unshift('Inicio', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        //opcion para mostar el menu lateral
        $data["tipo"] = "CapitalHumano";

        $this->headerScripts(array());
        $this->footerScripts(array(
            array(
                'type' => 'JS',
                'path' => 'js/fileupload/public/bundle-evaluacion-periodo.js'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/evaluacion.periodo.js'
            )
        ));
        $this->render('periodo/add', $head, $data, $footer);
    }

    public function edit($id)
    {
        $head = array('title' => 'Capsys - Periodo');
        $data = array();
        $footer = array();
        //opcion para mostar el menu lateral
        $data["tipo"] = "CapitalHumano";

        $this->breadcrumbs->push('Nuevo', 'periodo/add');
        $this->breadcrumbs->unshift('Periodos de evaluación', 'periodo');
        $this->breadcrumbs->unshift('Inicio', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data["id"] = $id;
        $this->headerScripts(array());
        $this->footerScripts(array(
            array(
                'type' => 'JS',
                'path' => 'js/fileupload/public/bundle-evaluacion-periodo.js'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/evaluacion.periodo.js'
            )
        ));
        $this->render('periodo/add', $head, $data, $footer);
    }

    public function liberar($id)
    {
        $empleados = [];
        $evaluados = [];
        $evaluador = [];
        $empleados_incidencia = [];
        $allrows = [];
        $full = "";
        $result = $this->evaluacionPeriodo->selectById($id, $full);

        $valid_tipo_evaluacion = array(
            $this->global["evaluacion_tipo"]["Competencias"],
            $this->global["evaluacion_tipo"]["Funciones"],
            $this->global["evaluacion_tipo"]["360"],
            $this->global["evaluacion_tipo"]["Otra"]
        );

        $tipo_evaluacion_incidencia = $this->global["evaluacion_tipo"]["Incidencias"];

        //Nuevos puestos de rank 
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

        foreach ($result->evaluacion_puesto as $ky => $ve) {
            if ($ve->tipo == "EVALUADO" && in_array($ve->tipo_evaluacion_id, $valid_tipo_evaluacion)) {
                if (in_array($ve->puesto_id, $puestosRanking)) {
                    //Si hay ranks seleccionados 
                    $personas_ranks = $this->evaluacionPeriodo->getPersonasRank($puestosRankingNombres[$ve->puesto_id]);
                    foreach ($personas_ranks as $key => $value) {
                        $empl = array(
                            "periodo_id" => $id,
                            "evaluacion_id" => $ve->evaluacion_id,
                            "empleado_id" => $value["id"],
                            "aplica_id" => '',
                            "fecha_registro" => date("Y-m-d"),
                            "tipo" => $ve->tipo_evaluacion_id,
                            "puesto_id" => $ve->puesto_id,
                            "padre_id"=>null
                        );
                        array_push($evaluados, $empl);
                    }
                } else {
                    //Evaluaciones del normales del sistema (Competencias,Funciones,360,Otra)
                    $empleados =  $this->evaluacionPeriodo->get_EmpleadoByPuesto($ve->puesto_id);
                    foreach ($empleados as $k => $v) {
                        $empl = array(
                            "periodo_id" => $id,
                            "evaluacion_id" => $ve->evaluacion_id,
                            "empleado_id" => $v["id"],
                            "aplica_id" => '',
                            "fecha_registro" => date("Y-m-d"),
                            "tipo" => $ve->tipo_evaluacion_id,
                            "puesto_id" => $ve->puesto_id,
                            "padre_id"=>null
                        );
                        array_push($evaluados, $empl);
                    }
                }
            } else if ($ve->tipo == "EVALUADO" && $ve->tipo_evaluacion_id == $tipo_evaluacion_incidencia) { //Esta son de incidencias
                $empleados =  $this->evaluacionPeriodo->get_EmpleadoByPuesto($ve->puesto_id);

                foreach ($empleados as $k => $v) {
                    $empl = array(
                        "periodo_id" => $id,
                        "evaluacion_id" => $ve->evaluacion_id,
                        "empleado_id" => $v["id"],
                        "aplica_id" => '',
                        "fecha_registro" => date("Y-m-d"),
                        "puesto_id" => $ve->puesto_id,
                        "padre_id"=>null
                    );
                    array_push($empleados_incidencia, $empl);
                }
            } else {
                //Añadimos los evaluadores 
                array_push($evaluador, $ve);
            }
        }

        $arrayEval = array();
        $delArrayFull=array();
        //$prueba=$evaluados;
        //Envio de notificaciones a la persona evaluada
        /* foreach ($evaluados as $key => $item) {
            
            $dataUser=$this->evaluacionPeriodo->getPersona($item["empleado_id"]);
            $not=array(
                "fecha_alta"=>date("Y-m-d"),
                "persona_id"=>$item["empleado_id"],
                "tipo"=>'PERIODO_LIBERADO',
                "tipo_id"=>'email',
                "email"=>$dataUser->email,
                "comment"=>'ENVIADA',
                "referencia"=>'PERIODOS',
                "referencia_id"=>'0',
                "check"=>0,
                "comentarioAdicional"=>$this->aditionalmessage($result->tiempo_periodo,$result->fecha_inicio,$result->titulo)
            );
            $this->evaluacionPeriodo->insertNnormal($not);
            array_push($delArrayFull,$item["empleado_id"]);
        } */

        //foreach para vincular los evaluados con los evaluadores
        foreach ($evaluados as $key => $item) {
            if ($item["tipo"] != "5") {

                //Si hay tipos ranks
                if (in_array($item["puesto_id"], $puestosRanking)) {
                    $personaR = $this->evaluacionPeriodo->getPersonaRank($item["empleado_id"]); //Busqueda de la persona del rank
                    if ($personaR->idPersonaPuesto != 0) { //Si la persona del rank tiene puesto
                        $parentPuesto = $this->evaluacionPeriodo->getIdParentPuesto($item["empleado_id"]); //id del puesto padre
                        $personasParentPuesto = $this->evaluacionPeriodo->getParentPersonas($parentPuesto->padrePuesto); //Busqueda de las personas con el puesto padre
                        foreach ($personasParentPuesto as $itm) {
                            $item['aplica_id'] = $itm->idPersona;
                            if ($item["tipo"] != "4") {
                                unset($item["tipo"]);
                                //unset($item->tipo);
                            }
                            array_push($allrows, $item);
                        }
                    } else {
                        //Si no tiene puesto
                        $creador = $this->evaluacionPeriodo->findSuperiorRank($personaR->userEmailCreacion);
                        $item['aplica_id'] = $creador->idPersona;
                        if ($item["tipo"] != "4") {
                            unset($item["tipo"]);
                        }
                        array_push($allrows, $item);
                    }
                } else {
                    //Si no hay de tipo rank 
                    //Para las evaluaciones que sean diferentes de OTRA y de la 360 
                    $parentPuesto = $this->evaluacionPeriodo->getIdParentPuesto($item["empleado_id"]); //id del puesto padre
                    $personasParentPuesto = $this->evaluacionPeriodo->getParentPersonas($parentPuesto->padrePuesto); //Busqueda de las personas con el puesto padre
                    foreach ($personasParentPuesto as $itm) {
                        $item['aplica_id'] = $itm->idPersona;
                        if ($item["tipo"] != "4") {
                            unset($item->tipo);
                        }
                        array_push($allrows, $item);
                    }
                    if ($item["tipo"] == "4") {

                        //Solo aplica para la 360, que es la busqueda de los subordinados 
                        $puestoSubordiandos = $this->evaluacionPeriodo->getPuestoSubordinados($parentPuesto->idPuesto);
                        foreach ($puestoSubordiandos as $key => $vps) {
                            $perpuesto = $this->evaluacionPeriodo->getParentPersonas($vps->idPuesto);
                            foreach ($perpuesto as $key => $ppp) {
                                $item['aplica_id'] = $ppp->idPersona;
                                $test = $item;
                                unset($test->tipo);
                                array_push($allrows, $test);
                            }
                        }
                        //print_r($puestoSubordiandos);
                    }
                }
            } else {
                //Esta son evaluaciones de tipo OTRA
                $item['aplica_id'] = $item['empleado_id'];
                $parentPuesto = $this->evaluacionPeriodo->getIdParentPuesto($item["empleado_id"]);
                $personasParentPuesto = $this->evaluacionPeriodo->getParentPersonas(isset($parentPuesto->padrePuesto)?$parentPuesto->padrePuesto:0);
                if(!empty($personasParentPuesto)){
                    $item['padre_id'] = $personasParentPuesto[0]->idPersona;
                }
                unset($item->tipo);
                array_push($allrows, $item);
            }
        }

        $test = $allrows;

        //foreach para los evaluadores
        foreach ($evaluador as $item) {
            foreach ($evaluados as $itm) {
                if (in_array($item->puesto_id, $puestosRanking)) {
                    //Si hay ranks seleccionados 
                    $personas_ranks = $this->evaluacionPeriodo->getPersonasRank($puestosRankingNombres[$item->puesto_id]);
                    foreach ($personas_ranks as $key => $value) {
                        $itm['aplica_id'] = $value["id"];
                        array_push($allrows, $itm);
                        array_push($arrayEval, $itm);
                    }
                } else {
                    //Evaluadores que no son ranks
                    if ($item->evaluacion_id == $itm['evaluacion_id']) {
                        $allevaluadores = $this->evaluacionPeriodo->getPersonasEvaluador($item->puesto_id);
                        foreach ($allevaluadores as $evl) {
                            $itm['aplica_id'] = $evl->idPersona;
                            //unset($itm->tipo);
                            array_push($allrows, $itm);
                            array_push($arrayEval, $itm);
                        }
                    }
                }
            }
        }

        $allrows_ = array();
        foreach ($allrows as $key => $value) {
            unset($value["tipo"]);
            array_push($allrows_, $value);
        }

        //var_dump($allrows_);


        $duplicados = $this->evaluacionPeriodo->getEvaluadores360($id);
        if (!empty($duplicados)) {
            $diff = array_diff(array_map('json_encode', $allrows_), array_map('json_encode', $duplicados));
            // Json decode the result
            $allrows_ = array_map(array($this, "convert_array"), $diff);
        }
        /* echo 'allrows <br>';
        var_dump($allrows_); */

        $this->evaluacionPeriodo->addEvaluacionEmpleadosBatch($allrows_);
        $this->evaluacionPeriodo->update($id, array('estatus' => 'LIBERADO'));

        //Eliminamos los repetidos
       /*  foreach ($allrows as $key => $value) {
            if(in_array($value["persona_id"],$delArrayFull)){
                unset($allrows[$key]);
            }
        } */
        ///cuando se libera un periodo
        $this->sendNotificacionManual("PERIODO_LIBERADO", array("Opcion"=>2,"Allrows"=>$allrows,"referencia"=>$id,"Tipo"=>"LIBERADO"));
        $evIncidencias = $this->global["evaluacion_incidencias"];
        $years = array(
            date('Y', strtotime($result->fecha_inicio)),
            date('Y', strtotime($result->fecha_final))
        );
        $years = array_unique($years);
        $dias_festivos = $this->common->getDateHoliday($years);
        $dias_laborales = $this->common->getDiasHabiles($result->fecha_inicio, $result->fecha_final, $dias_festivos);
        $periodo = $this->global["tiempo"][$result->tiempo_periodo];
        $nDias = count($dias_laborales);

        foreach ($empleados_incidencia as $key => $value) {
            $lsIncidencias = $this->incidencia->getIncidenciasByfechas($result->fecha_inicio, $result->fecha_final, $value["empleado_id"]);
            $eval_incidencias = array();
            $ttotal = 0;
            foreach ($evIncidencias as $k => $v) {
                $noInci = array_filter($lsIncidencias, function ($it) use ($v) {
                    return in_array($it->tipo_incidencias_id, $v["valor"]);
                });
                $tt = (((count($noInci) / $nDias) - 1) * -1);
                $ttotal += $tt;
                array_push($eval_incidencias, array(
                    "titulo" => $v["titulo"],
                    "subtitulo" => $v["subtitulo"],
                    "dias" => count($noInci),
                    "subtitulo_1" => "Total de dias en el $periodo",
                    "dias_laborados" => $nDias,
                    "total" => $tt
                ));
            }
            $value["calificacion"] = (($ttotal / $nDias * 100) / count($evIncidencias));
            //$value["calificacion"] = (($ttotal / count($nDias) * 100) / count($evIncidencias));
            $this->evaluacionPeriodo->addEvaluacionEmpleadosBatch(array($value));
        }

        $this->responseJSON("200", "Éxito", null);
    }

    function convert_array($el)
    {
        return json_decode($el, true);
    }

    function beforeLiberar($id)
    {
        header('Content-Type: application/json');
        $data = new  \stdClass();
        $eval360 = [];
        $data360 = [];
        $info = $this->evaluacionPeriodo->allTypePuestoCompetencia($id);
        foreach ($info as $item) {

            if ($item['tipo_evaluacion'] == 4 && $item['tipo'] === 'EVALUADO') {

                $infoEval = $this->evaluacionPeriodo->getdataEvaluacion($item['evaluacion_id'], $item['puesto_id']);
                $empl360 = $this->evaluacionPeriodo->getPersonas($item['puesto_id']);
                foreach ($empl360 as $itm360) {

                    $itemdata = array(
                        'Emp' => $itm360,
                        "aplicados" => $this->evaluacionPeriodo->getEvalaudores360($itm360['idPersona'], $item['evaluacion_id'], $item['evaluacion_periodo_id'])
                    );
                    array_push($data360, $itemdata);
                }
                $eval = array(
                    "Nombre" => $item['titulo'],
                    "Perido" => $item['evaluacion_periodo_id'],
                    "id_evaluacion" => $item['evaluacion_id'],
                    "Puesto" => $this->evaluacionPeriodo->getPuesto($item['puesto_id']),
                    "empleados" => $data360,
                );
                array_push($eval360, $eval);
                $data360 = [];
            }
        }
        $data->infoPeriodo = $this->evaluacionPeriodo->getInfoPerido($id);
        $data->evaluaciones = $info;
        $data->eval360 = $eval360;
        $data->empleados = $this->pip->getUsers();
        echo json_encode($this->response("200", "Exï¿½to", $data));
    }

    function addEval360()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $djason = json_decode(file_get_contents("php://input"));
            $this->evaluacionPeriodo->insertEval360($djason);
        }
    }

    function deleteEval360()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $djason = json_decode(file_get_contents("php://input"));
            $this->evaluacionPeriodo->deleteEval360($djason->id);
        }
    }

    function getEvaluadores360()
    {
        header('Content-Type: application/json');
        $idp = $this->input->get('idPersona');
        $eva = $this->input->get('idEvaluacion');
        $per = $this->input->get('idPeriodo');
        $result = new  \stdClass();
        $result = $this->evaluacionPeriodo->getEvalaudores360($idp, $eva, $per);
        $this->responseJSON("200", "Éxito", $result);
    }

    public function getAll()
    {
        $result = new  \stdClass();

        $result = $this->evaluacionPeriodo->select();

        $this->responseJSON("200", "Èxito", $result);
    }

    public function get()
    {
        $id = $this->input->get('id', true);
        $full = $this->input->get('full');

        $result = new  \stdClass();
        if ($id != null) {
            $result = $this->evaluacionPeriodo->selectById($id, $full);
        }
        $this->responseJSON("200", "Èxito aa", $result);
    }

    public function close($id)
    {
        $result = $this->evaluacionPeriodo->close($id);
        if ($result->ok) {
            $this->responseJSON("200", $result->message, true);
        } else {
            $this->responseJSON("400", $result->message, null);
        }
    }

    public function delete($id)
    {
        $result = $this->evaluacionPeriodo->delete($id);
        if ($result->ok) {
            $this->responseJSON("200", $result->message, true);
        } else {
            $this->responseJSON("400", $result->message, null);
        }
    }

    public function clonarPeriodo($id)
    {
        $id = intval($id);

        if ($id > 0) {
            $data = array(
                "periodo" => array(),
                "puestos" => array(),
                "competencias" => array(),
                "empleados" => array()
            );
            $obPeriodo =  $this->evaluacionPeriodo->selectById($id, "");
            if ($obPeriodo != null) {
                $dFi = date('Y-m-d', strtotime($obPeriodo->fecha_final . " + $obPeriodo->tiempo_periodo month"));
                $dFi = date('Y-m-d', strtotime($dFi . "-1 day"));
                $result = new \stdClass;
                $result->ok = true;

                $titulo = "$obPeriodo->titulo GENERADO AUTOMATICO";

                if ($this->evaluacionPeriodo->existBytitulo($titulo)) {
                    $result->ok = false;
                    $erro_message = "Ocurrio un error, no puedes guardar un período con el mismo título.";
                    goto end;
                }

                $data["periodo"] = array(
                    "titulo" => $titulo,
                    "fecha_inicio" => date('Y-m-d', strtotime($obPeriodo->fecha_final . " +1 day")),
                    "fecha_final" =>  $dFi,
                    "tiempo_periodo" => $obPeriodo->tiempo_periodo,
                    "tiempo_evaluacion" => date('Y-m-d', strtotime($obPeriodo->fecha_final)),
                    "tipo_periodo" => $obPeriodo->tipo_periodo,
                    "comentario" => $obPeriodo->comentario,
                    "dias_previos" => $obPeriodo->dias_previos,
                    "fecha_registro" => date("Y-m-d"),
                    "creado_por" => $this->tank_auth->get_idPersona(),
                    "modificado_por" => $this->tank_auth->get_idPersona(),
                    "created" => date("Y-m-d"),
                    "modified" => date("Y-m-d"),
                    "estatus" => "BORRADOR"
                );
                $this->evaluacionPeriodo->db->trans_begin();
                $insert_id  =  $this->evaluacionPeriodo->add($data["periodo"]);

                foreach ($obPeriodo->evaluacion_competencias as $key => $value) {
                    $competencia = array(
                        "evaluacion_periodo_id" => $insert_id,
                        "evaluacion_id" => $value->evaluacion_id,
                        "puesto_id" => $value->puesto_id,
                        "competencias_id" => $value->competencias_id,
                        "grado" => $value->grado
                    );
                    array_push($data["competencias"], $competencia);
                }

                foreach ($obPeriodo->evaluacion_puesto as $key => $value) {
                    $puesto = array(
                        "evaluacion_periodo_id" => $insert_id,
                        "puesto_id" => $value->puesto_id,
                        "evaluacion_id" => $value->evaluacion_id,
                        "tipo" => $value->tipo,
                        "valor" => $value->valor
                    );
                    array_push($data["puestos"], $puesto);
                }
                $this->evaluacionPeriodo->addEvaluacionCompetenciasBatch($data["competencias"]);
                // $this->evaluacionPeriodo->addEvaluacionEmpleadosBatch($data["empleados"]);
                $this->evaluacionPeriodo->addEvaluacionPuestosBatch($data["puestos"]);

                end:
                if ($this->evaluacionPeriodo->db->trans_status() === FALSE || $result->ok === false) {
                    $this->evaluacionPeriodo->db->trans_rollback();
                    if (empty($erro_message))
                        $erro_message = "Ocurrio un error al guardar la información";
                    $this->responseJSON("400", $erro_message, null);
                } else {
                    $this->evaluacionPeriodo->db->trans_commit();
                    $this->responseJSON("200", "Se guardo con éxito", null);
                }
            }

            return;
        }
        $this->responseJSON("400", "El periodo indicando no existe", null);
    }


    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $obj = json_decode(file_get_contents("php://input"));

            $dFi = date('Y-m-d', strtotime($obj->fecha_inicio . " + $obj->tiempo_periodo month"));
            $dFi = date('Y-m-d', strtotime($dFi . "-1 day"));

            $data = array(
                "periodo" => array(
                    "titulo" => $obj->titulo,
                    "fecha_inicio" => date('Y-m-d', strtotime($obj->fecha_inicio)),
                    "fecha_final" =>  $dFi,
                    "tiempo_periodo" => $obj->tiempo_periodo,
                    "tiempo_evaluacion" => date('Y-m-d', strtotime($obj->tiempo_evaluacion)),
                    "tipo_periodo" => $obj->tipo_periodo,
                    "comentario" => $obj->comentario,
                    "dias_previos" => $obj->dias_previos,
                    "fecha_registro" => date("Y-m-d"),
                    "creado_por" => $this->tank_auth->get_idPersona(),
                    "modificado_por" => $this->tank_auth->get_idPersona(),
                    "created" => date("Y-m-d"),
                    "modified" => date("Y-m-d"),
                    "estatus" => "BORRADOR"
                ),
                "puestos" => array(),
                "competencias" => array(),
                "empleados" => array()
            );

            //Puestos especiales de rankings
            $ranks = array(
                "BRONCE",
                "ORO",
                "PLATINO VIP"
            );

            $result = new \stdClass;
            $result->ok = true;
            $erro_message = "";
            $insert_id = intval(@$obj->id);
            $this->evaluacionPeriodo->db->trans_begin();

            if ($insert_id == 0) {
                if ($this->evaluacionPeriodo->existBytitulo($data["periodo"]["titulo"])) {
                    $result->ok = false;
                    $erro_message = "Ocurrio un error, no puedes guardar un período con el mismo título.";
                    goto end;
                }
                $insert_id  =  $this->evaluacionPeriodo->add($data["periodo"]);
            } else {
                $this->evaluacionPeriodo->update($insert_id, array(
                    "titulo" => $data["periodo"]["titulo"],
                    "fecha_inicio" => $data["periodo"]["fecha_inicio"],
                    "fecha_final" => $data["periodo"]["fecha_final"],
                    "tiempo_periodo" => $data["periodo"]["tiempo_periodo"],
                    "tipo_periodo" => $data["periodo"]["tipo_periodo"],
                    "comentario" => $data["periodo"]["comentario"],
                    "dias_previos" => $data["periodo"]["dias_previos"],
                ));

                $this->evaluacionPeriodo->deleteEvaluacionCompetenciasBatch($insert_id);
                $this->evaluacionPeriodo->deleteEvaluacionEmpleadosBatch($insert_id);
                $this->evaluacionPeriodo->deleteEvaluacionPuestosBatch($insert_id);
            }

            foreach ($obj->evaluacion_competencias as $key => $value) {
                $competencia = array(
                    "evaluacion_periodo_id" => $insert_id,
                    "evaluacion_id" => $value->evaluacion_id,
                    "puesto_id" => $value->puesto_id,
                    "competencias_id" => $value->competencias_id,
                    "grado" => $value->grado
                );
                array_push($data["competencias"], $competencia);
            }

            foreach ($obj->evaluacion_periodos_puesto as $key => $value) {
                // if ($value->tipo == "EVALUADO") {

                //     $empleados =  $this->evaluacionPeriodo->get_EmpleadoByPuesto($value->puesto_id);

                //     foreach ($empleados as $k => $v) {
                //         $empl = array(
                //             "periodo_id" => $insert_id,
                //             "evaluacion_id" => $value->evaluacion_id,
                //             "empleado_id" => $v["id"],
                //             "fecha_registro" => date("Y-m-d")
                //         );
                //         array_push($data["empleados"], $empl);
                //     }
                // }
                /*  $puesto = array(
                    "evaluacion_periodo_id" => $insert_id,
                    "puesto_id" => $value->puesto_id,
                    "evaluacion_id" => $value->evaluacion_id,
                    "tipo" => $value->tipo,
                    "valor" => $value->valor,
                ); */

                $puesto = array(
                    "evaluacion_periodo_id" => $insert_id,
                    "puesto_id" => in_array($value->puesto_id, $ranks) ? 0 : $value->puesto_id,
                    "evaluacion_id" => $value->evaluacion_id,
                    "tipo" => $value->tipo,
                    "valor" => $value->valor,
                    "ranking" => in_array($value->puesto_id, $ranks) ? $value->puesto_id : null
                );
                array_push($data["puestos"], $puesto);
            }

            $this->evaluacionPeriodo->addEvaluacionCompetenciasBatch($data["competencias"]);
            // $this->evaluacionPeriodo->addEvaluacionEmpleadosBatch($data["empleados"]);
            $this->evaluacionPeriodo->addEvaluacionPuestosBatch($data["puestos"]);

            //var_dump($data["puestos"]);
            end:
            if ($this->evaluacionPeriodo->db->trans_status() === FALSE || $result->ok === false) {
                $this->evaluacionPeriodo->db->trans_rollback();
                if (empty($erro_message))
                    $erro_message = "Ocurrio un error al guardar la información";
                $this->responseJSON("400", $erro_message, null);
            } else {
                $this->evaluacionPeriodo->db->trans_commit();
                $this->responseJSON("200", "Se guardo con éxito", null);
            }

            // if($id == 0){

            // }else{
            //     $this->evaluacionPeriodo->edit($id,array(

            //     ));
            // }
        }
    }

    public function checkPreviewDays()
    {
        $empleados = [];
        $evaluados = [];
        $evaluador = [];
        $empleados_incidencia = [];
        $allrows = [];
        $full = "";
        date_default_timezone_set('America/Mexico_City');
        $Periodos = $this->evaluacionPeriodo->getPeriodosLiberados();
        foreach ($Periodos as $key => $value) {

            $result = $this->evaluacionPeriodo->selectById($value->id, $full);
            $valid_tipo_evaluacion = array(
                $this->global["evaluacion_tipo"]["Competencias"],
                $this->global["evaluacion_tipo"]["Funciones"]
            );

            $tipo_evaluacion_incidencia = $this->global["evaluacion_tipo"]["Incidencias"];

            foreach ($result->evaluacion_puesto as $ky => $ve) { //inicio de forech de evaluaciones liberadas 

                if ($ve->tipo == "EVALUADO" && in_array($ve->tipo_evaluacion_id, $valid_tipo_evaluacion)) {
                    $empleados =  $this->evaluacionPeriodo->get_EmpleadoByPuesto($ve->puesto_id);
                    foreach ($empleados as $k => $v) {
                        $empl = array(
                            "periodo_id" => $value->id,
                            "evaluacion_id" => $ve->evaluacion_id,
                            "empleado_id" => $v["id"],
                            "aplica_id" => '',
                            "fecha_registro" => date("Y-m-d")
                        );
                        array_push($evaluados, $empl);
                    }
                } else if ($ve->tipo == "EVALUADO" && $ve->tipo_evaluacion_id == $tipo_evaluacion_incidencia) {
                    $empleados =  $this->evaluacionPeriodo->get_EmpleadoByPuesto($ve->puesto_id);
                    foreach ($empleados as $k => $v) {
                        $empl = array(
                            "periodo_id" => $value->id,
                            "evaluacion_id" => $ve->evaluacion_id,
                            "empleado_id" => $v["id"],
                            "aplica_id" => '',
                            "fecha_registro" => date("Y-m-d")
                        );
                        array_push($empleados_incidencia, $empl);
                    }
                } else {
                    array_push($evaluador, $ve);
                }
            }
            //foreach para los evaluados
            foreach ($evaluados as $item) {
                $parentPuesto = $this->evaluacionPeriodo->getIdParentPuesto($item["empleado_id"]);
                $personasParentPuesto = $this->evaluacionPeriodo->getParentPersonas($parentPuesto->padrePuesto);
                foreach ($personasParentPuesto as $itm) {
                    $item['aplica_id'] = $itm->idPersona;
                    array_push($allrows, $item);
                }
            }
            //foreach para los evaluadores
            foreach ($evaluador as $item) {
                foreach ($evaluados as $itm) {
                    if ($item->evaluacion_id == $itm['evaluacion_id']) {
                        $allevaluadores = $this->evaluacionPeriodo->getPersonasEvaluador($item->puesto_id);
                        foreach ($allevaluadores as $evl) {
                            $itm['aplica_id'] = $evl->idPersona;
                            array_push($allrows, $itm);
                        }
                    }
                }
            }
            //Notificaciones antes del periodo 
            $dateInicio = new DateTime($value->fecha_inicio);
            $dateFin = new DateTime($value->fecha_final);
            $TodayDate = new DateTime('now');
            //$TodayDate = new DateTime('2019-12-31');
            //echo $date2->diff($dateInicio)->days;

            if ($TodayDate < $dateInicio) {
                if ($TodayDate->diff($dateInicio)->days <= $value->dias_previos) {
                    //metodo que avisa antes de iniciar la evaluacion
                    //echo 'Dias antes de iniciar '.$TodayDate->diff($dateInicio)->days;
                    //$this->sendNotificacionManual("PERIODO_POR_EMPEZAR", array("Allrows"=>$allrows,"referencia"=>$value->id,"Dias"=>$TodayDate->diff($dateInicio)->days));
                    //$this->sendNotificacionManual("PERIODO_POR_EMPEZAR", array("Opcion" => 1, "Allrows" => $allrows, "referencia" => $value->id, "Tipo" => "ESPERA", "Dias" => $TodayDate->diff($dateInicio)->days));
                }
            } elseif ($TodayDate < $dateFin && $TodayDate->diff($dateFin)->days <= $value->dias_previos) {
                //echo 'Dias antes de Terminar '.$TodayDate->diff($dateFin)->days;
                //$this->sendNotificacionManual("PERIODO_POR_TERMINAR", array("Allrows"=>$allrows,"referencia"=>$value->id,"Dias"=>$TodayDate->diff($dateFin)->days));
                // $this->sendNotificacionManual("PERIODO_POR_TERMINAR", array("Opcion" => 1, "Allrows" => $allrows, "referencia" => $value->id, "Tipo" => "TERMINO", "Dias" => $TodayDate->diff($dateFin)->days));
            }
        } //end foreach de periodos liberados 
    }

    function TestpuestoEmpleado()
    {
        echo 'esta es una opcion de prueba';
        $returnD = $this->evaluacionPeriodo->getnullEmpleado();
        //var_dump($this->evaluacionPeriodo->getnullEmpleado());

        foreach ($returnD as $key => $value) {
            $returnD[$key]['puesto_id'] = $this->evaluacionPeriodo->getPuestoPrueba($value['empleado_id']);
        }
        var_dump($returnD);
        $this->evaluacionPeriodo->batchEvalPrueba($returnD);
    }

    //Funcion del trimestre
    public function trimestre($datetime)
    {
        $mes = date("m",strtotime($datetime));
        $mes = is_null($mes) ? date('m') : $mes;
        $trim=floor(($mes-1) / 3)+1;
        return $trim;
    }

    public function bimestre($mes)
    {
        $bimestre="";
        switch ($mes) {
            case '1':
            case '2':
                $bimestre=1;
                break;
            case '3':
            case '4':
                $bimestre=2;
                 break;
            case '5':
            case '6':
                $bimestre=3;
                break;
            case '7':
            case '8':
                $bimestre=4;
                break;
            case '9':
            case '10':
                $bimestre=5;
                break;
            case '11':
            case '12':
                $bimestre=6;
                break;                     
        }
        return $bimestre;
    }

    public function aditionalmessage($perido,$fecha,$nombre){
        $msg='';
        switch ($perido) {
            case '1':
                $mes=date("m",strtotime($fecha));
                $msg="con el nombre $nombre del $mes mes con fecha de inicio $fecha";
                break;
            case '2':
                $mes=date("m",strtotime($fecha));
                $bimestre=$this->bimestre($mes);
                $msg="con el nombre $nombre del $bimestre bimestre con fecha de inicio $fecha";
                break;
            case '3':
                $timestre=$this->trimestre($fecha);
                $msg="con el nombre $nombre del $timestre trimestre con fecha de inicio $fecha";
                break;
            case '6':
                $mes=date("m",strtotime($fecha));
                $semetres=$mes<=6?1:2;
                $msg="con el nombre $nombre del $semetres semestre con fecha de inicio $fecha";
                break;
            case '12':
                $msg="con el nombre $nombre de tipo anual con fecha de inicio $fecha";
                break;
        }
        return $msg;
    }
}
