<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class incidencias extends TIC_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library(array('form_validation', 'JbUpload'));
        $this->load->library('email');
        $this->load->library('graficos');
        $this->load->model('incidenciasmodel', 'incidencia');
        $this->load->model('seguimiento_model', 'seguimiento');
        $this->load->model('documentsmodel');
        $this->load->model('evaluacion_periodos_model', 'periodo');
        $this->load->model('evaluaciones_model', 'evaluaciones');
        $this->load->model("personamodelo", "persona");
        $this->load->model('notificacionmodel', 'notificacion_model');
        $this->load->model('reportesmodel', 'reportes_model');
        $this->load->model('bonos_model', 'bonos');
        $this->load->helper(array('form_incidencias', 'form_tipoincidencia'));
        $this->load->model('servicios_model', 'servicios');
        $this->load->helper('cookie');
    }

    function index()
    {
        //$this->comprobarpermiso($_SERVER['REQUEST_URI'],$this->tank_auth->get_idPersona());

        $head = array('title' => 'Capsys - Incidencias');
        $data = array();
        $footer = array();
        $data["minDayVacation"] = $this->global["minDayVacation"];
        $data["startBlock"] = $this->global["startBlock"];
        $data["daysBlock"] = $this->global["daysBlock"];

        $this->breadcrumbs->push('Incidencias', 'incidencias');
        $this->breadcrumbs->unshift('Inicio', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['idNotificacion'] = $this->session->flashdata('id');
        $data['TipoUser'] = $this->tank_auth->get_userprofile();

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            )
        ));
        $empleados = $this->persona->getEmpleados();
        $tipoIncidencias=$this->incidencia->getTipoIncidencias();
        //$_puestos = $this->persona->getPuestos();
        $_puestos = $this->getPuestos();
        //opcion para mostar el menu lateral
        $data["tipo"]="CapitalHumano";
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _empleados = " . json_encode($empleados) . "; const _puestos = " . json_encode($_puestos) . ";". "; const _TipoI = " . json_encode($tipoIncidencias) . ";"
            ), array(
                'type' => 'JS',
                'path' => 'gap/js/datatables.min.js'
            ), array(
                'type' => 'JS',
                'path' => 'js/fileupload/public/bundle-modal-seguimiento.js' //Modal seguimiento
            ), array(
                'type' => 'JS',
                'path' => 'js/fileupload/public/bundle-incidencias.js' //Modal para el registro
            ), /*array( //Desactivado [Suemy][2024-05-31] - Solo se visualiza archivos PDF
                'type' => 'JS',
                'path' => 'js/fileupload/public/bundle-preview.js' //Visor PDF
            ),*/ array(
                'type' => 'JS',
                'path' => 'gap/js/incidencias.table.js' //Tabla de los registros
            )
        ));
        $this->render('incidencias/tablaIncidencias', $head, $data, $footer);
    }

    function getIncidencias()
    {
        header('Content-Type: application/json');
        $tabla = $this->incidencia->getIncidenciasTable();
        echo json_encode($this->response("200", "Exíto", $tabla));
        die;
    }

    function getTipoIncidencias()
    {
        header('Content-Type: application/json');
        $tipos = $this->incidencia->getTipoIncidencias();
        $this->responseJSON("200", "Èxito", $tipos);
    }

    function getTipoIncidencia()
    {
        header('Content-Type: application/json');
        $tipos = $this->incidencia->getTipoIncidencias();
        $this->responseJSON("200", "Èxito", array('types' => $tipos));
    }

    public function updateChart()
    {
        $filtros = array();
        $djason = json_decode(file_get_contents("php://input"), true);
        if($djason["clientes"]=="0"||$djason["clientes"]==""){
            $clientesDB=$this->servicios->getClientesEjecutivo($this->tank_auth->get_idPersona());
            $clientes=$this->map_clientes($clientesDB);
        }else{
            $clientes="(".$djason["clientes"].")";
        }
        //echo $clientes;
        $djason["clientes"]=$clientes;
        //var_dump($djason);
        switch ($djason["charName"]) {
            case 'INCIDENCIAS_MENSUALES':
                $filtros = $this->graficos->getDatos($djason);
                break;
            case 'INCIDENCIAS_TRIMESTRAL':
                $filtros = $this->graficos->getDatos($djason);
                break;
            case 'COMPARATIVO_COLABORADORES':
                $filtros = $this->graficos->getDatosLine($djason);
                break;
            case 'ROTACION_PERSONAL':
                $filtros = $this->graficos->getRotacion($djason);
                break;
            case 'CRECIMIENTO_PERIODO':
                $filtros = $this->graficos->getCrecimiento($djason);
                break;
            case 'EVALUACIONES_COMPETENCIAS':
                $filtros = $this->graficos->getEvalByCompetencia($djason);
                break;
            case "EVALUACIONES_DESEMPENIO":
                $filtros = $this->graficos->getEvaluacionDesempenio($djason);
                break;
            case "REPORTE_BONO":
                $filtros = $this->bonos->getbonosreporte($djason["periodos"]["value"]);
                break;
            case "REPORTE_EVALUACIONES":
                $filtros = $this->evaluaciones->getReporteEvaluaciones($djason["periodos"]["value"], $djason);
                break;
            case "SINIESTROS_TODOS_LOS_MESES":
                $filtros = $this->graficos->get_data_siniestros($djason,"","");
                break;
            case "SINIESTROS_COMPARACION_MESES":
                $filtros = $this->graficos->get_data_siniestros_comparacion($djason,"","SINIESTROS_MESES");
                break;
            case "SINIESTROS_TOP_ESTADOS":
                $filtros = $this->graficos->getDatosTop($djason,"SINIESTROS_TOP");
                break;
        }

        $this->responseJSON("200", "Exíto", $filtros);
    }

    function grafica()
    {
        $filtro = array(
            "fecha" => date('Y-m-d'),
            "periodo" => 0,
            "puesto" => 0,
            "empresa" => 0,
            "colaborador" => 0,
            "periodos" => 0,
            "fechaInicio" => date('Y-m-d'),
            "fechaFin" => date('Y-m-d')
        );

        $head = array('title' => 'Capsys - Reportes');
        $data = array();
        $footer = array();

        $empleados = $this->persona->getEmpleados();
        $_puestos = $this->persona->getPuestos();
        $periodos = $this->periodo->select_listado_Cerrados();
        $data["grafico3"] = $this->graficos->render("INCIDENCIAS_MENSUALES", $filtro);
        $data["grafico2"] = $this->graficos->render("INCIDENCIAS_TRIMESTRAL", $filtro);
        $data["grafico1"] = $this->graficos->render("COMPARATIVO_COLABORADORES", $filtro);
        $data["grafico4"] = $this->graficos->render("ROTACION_PERSONAL", $filtro);
        $data["grafico5"] = $this->graficos->render("CRECIMIENTO_PERIODO", $filtro);
        $data["grafico6"] = $this->graficos->render("EVALUACIONES_COMPETENCIAS", $filtro);
        $data["grafico7"] = $this->graficos->render("EVALUACIONES_DESEMPENIO", $filtro);

        //opcion para mostar el menu lateral
        $data["tipo"]="CapitalHumano";

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'css/apexcharts.css'
            ),
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
                'path' => 'js/plugins/apexcharts/apexcharts.js'
            ),
            array(
                'type' => 'JSHTML',
                'data' => "const _empleados = " . json_encode($empleados) . "; const _puestos = " . json_encode($_puestos) . "; const _periodos = " . json_encode($periodos) . ";"
            ),
            array(
                'type' => 'JS',
                'path' => 'js/fileupload/public/bundle-modal-filtro.js'
            ),
            array(
                'type' => 'JS',
                'path' => 'js/fileupload/public/bundle-modal-detalle.js'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/reporte.js'
            ),
            array(
                'type' => 'JSON',
                'path' => 'Apex.chart = {
                        locales: 
                            [
                                {
                                    "name": "es",
                                    "options": {
                                        "months": 
                                        [
                                            "Enero",
                                            "Febrero",
                                            "Marzo",
                                            "Abril",
                                            "Mayo",
                                            "Junio",
                                            "Julio",
                                            "Agosto",
                                            "Septiembre",
                                            "Octubre",
                                            "Noviembre",
                                            "Diciembre"
                                        ],
                                        "shortMonths": [
                                            "Ene",
                                            "Feb",
                                            "Mar",
                                            "Abr",
                                            "May",
                                            "Jun",
                                            "Jul",
                                            "Ago",
                                            "Sep",
                                            "Oct",
                                            "Nov",
                                            "Dic"
                                        ],
                                        "days": [
                                            "Domingo",
                                            "Lunes",
                                            "Martes",
                                            "Miércoles",
                                            "Jueves",
                                            "Viernes",
                                            "Sábado"
                                        ],
                                        "shortDays": ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
                                        "toolbar": {
                                            "exportToSVG": "Descargar SVG",
                                            "exportToPNG": "Descargar PNG",
                                            "exportToCSV": "Descargar CSV",
                                            "menu": "Menu",
                                            "selection": "Seleccionar",
                                            "selectionZoom": "Seleccionar Zoom",
                                            "zoomIn": "Aumentar",
                                            "zoomOut": "Disminuir",
                                            "pan": "Navegación",
                                            "reset": "Reiniciar Zoom"
                                        }
                                    }
                                }
                            ],
                            defaultLocale: "es"
                    };
                  '
            ),
            array(
                'type' => 'JSHTML',
                'data' => $data["grafico3"]["JS"]
            ),
            array(
                'type' => 'JSHTML',
                'data' => $data["grafico2"]["JS"]
            ),
            array(
                'type' => 'JSHTML',
                'data' => $data["grafico1"]["JS"]
            ),
            array(
                'type' => 'JSHTML',
                'data' => $data["grafico4"]["JS"]
            ),
            array(
                'type' => 'JSHTML',
                'data' => $data["grafico5"]["JS"]
            ),
            array(
                'type' => 'JSHTML',
                'data' => $data["grafico6"]["JS"]
            ),
            array(
                'type' => 'JSHTML',
                'data' => $data["grafico7"]["JS"]
            )

        ));
        $this->render('incidencias/dashboard', $head, $data, $footer);
    }

    function detallereporte()
    {
        $seriename = ($_POST['seriename'] != null) ? $_POST['seriename'] : "";
        $filtro = (json_decode($_POST['filtro']) != null) ? json_decode($_POST['filtro']) : "";

        if ($filtro == "") {
            $fecha = date("Y-m-d");
            $fecha_inicio = $this->common->first_date($fecha);
            $fecha_fin = $this->common->last_date($fecha, null);
        } else {
            $fecha_inicio = $this->common->first_date($filtro->fecha);
            $fecha_fin = $this->common->last_date($filtro->fecha, $filtro->periodo);
        }

        $evIncidencias = $this->global["evaluacion_incidencias"];

        $datos = array();
        $incidencia = array();
        foreach ($evIncidencias as $key => $value) {
            if ($key == $seriename) {
                $incidencia[] = $value;
                break;
            }
        }
        print_r($incidencia);

        $range = $this->incidencia->detalle_incidencias_mensuales($fecha_inicio, $fecha_fin, $incidencia, $filtro);

        if (count($range) == 0) {
            array_push($datos, 0);
            $range = $datos;
        }

        $this->responseJSON("200", "Éxito", $range);
    }

    //COMPARATIVO DE COLABORADORES
    function detallereportepoint()
    {        //     $seriename = ($_POST['seriename'] != null) ? $_POST['seriename'] : "";
        $filtro = (json_decode($_POST['filtro']) != null) ? json_decode($_POST['filtro']) : "";
        $punto = (($_POST['puntos']) != null) ? ($_POST['puntos']) : "";
        if (is_array($punto)) {
            $punto = $punto[0];
        }
        $date = date('Y-m-d');
        $fecha_inicio = "";
        $fecha_fin = "";
        if ($filtro == "") {
            $fecha_inicio = $this->common->first_date($date);
            $fecha_fin = $this->common->last_date($date);
        } else {
            if ($filtro != null) {
                $fecha_inicio = $this->common->first_date($filtro->fecha);
                $fecha_fin = $this->common->last_date($filtro->fecha);
            }
        }
        //$filtro["colaborador"] = $idPersona;
        $range = $this->incidencia->detalle_anual_mensual($fecha_inicio, $fecha_fin, $punto, $filtro);


        $this->responseJSON("200", "Éxito", $range);
    }

    //ROTACION DE PERSONAL
    function detallerotacion()
    {
        $fecha = "";
        $filtro = (json_decode($_POST['filtro']) != null) ? json_decode($_POST['filtro']) : "";
        $anio = (($_POST['anio']) != null) ? ($_POST['anio']) : "";

        $date = date("$anio-01-01");
        $fecha_anual = $this->common->getfechaanual($date);

        $rotacion_personal = $this->incidencia->detalle_rotacion_anual($fecha_anual, $filtro);
        $this->responseJSON("200", "Éxito", $rotacion_personal);
    }

    //DETALLE DE EVALUACION DE DESEMPEÑO
    function detalledesempenio()
    {
        $periodo = 0;
        $seriename = ($_POST['seriename'] != null) ? $_POST['seriename'] : "";
        $filtro = (json_decode($_POST['filtro']) != null) ? json_decode($_POST['filtro']) : "";
        $labels = ($_POST['labels'] != null) ? $_POST['labels'] : "";

        if ($filtro != null) {
            $periodo = $filtro->periodos->value;
        }
        // if($filtro->periodos->value > 0){
        //     $periodo = $filtro->periodos->value;    
        // }else{
        //     print_r($filtro);
        // }
        // }   
        // print_r($periodo);
        $rotacion_personal = $this->evaluaciones->detalleDesempenio($periodo, $labels);
        $this->responseJSON("200", "Éxito", $rotacion_personal);
    }

    function pruebaReporte()
    {
        $this->load->library('graficos');
        $head = array('title' => 'Capsys - Reportes');
        $this->breadcrumbs->push('Incidencias', 'incidencias/dashboard');
        $this->breadcrumbs->unshift('Inicio', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data = array();
        $footer = array();

        $datos = $this->reportes_model->getreporteincidencia();

        $data["grafico"] = $this->graficos->render("INCIDENCIAS_FALTAS", null);
        $data["grafico2"] = $this->graficos->render("INCIDENCIAS_FALTAS2", $datos);
        $data["grafico3"] = $this->graficos->render("INCIDENCIAS_FALTAS3", null);
        //opcion para mostar el menu lateral
        $data["tipo"]="CapitalHumano";
        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'css/apexcharts.css'
            )
        ));

        $this->footerScripts(array(
            array(
                'type' => 'JS',
                'path' => 'js/plugins/apexcharts/apexcharts.js'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/reporte.js'
            ),
            array(
                'type' => 'JSHTML',
                'data' => $data["grafico"]["JS"]
            ),
            array(
                'type' => 'JSHTML',
                'data' => $data["grafico2"]["JS"]
            ),
            array(
                'type' => 'JSHTML',
                'data' => $data["grafico3"]["JS"]
            )
        ));
        $this->render('incidencias/dashboard', $head, $data, $footer);
    }
    /*PARAMETROS ESTATICOS*/
    function prueba()
    {
        $parameter["tipo"] = 'incidencias';
        $parameter["id_persona"] = '70';
        $parameter["empleado_nombre"] = 'JIMMY';
        $parameter["incidencia_id"] = '1';
        $parameter["incidencia"] = 'Faltas';
        $parameter["data"] = array(
            'empleado_nombre'   => 'JIMMY',
            'incidencia' => 'Faltas',

        );

        $this->sendNotificacionManual("INCIDENCIA", $parameter);
    }

    /*incidencias con estatus liberado */
    function pruebaglobal()
    {
        $search_incidencias = $this->notificacion_model->search_incidencias();
        foreach ($search_incidencias as $key => $value) {
            $this->sendNotificacionManual($value->notificacion, array("id_persona" => $value->empleado_id, "data" => $value));
        }
    }
    /*Evaluacion y evaluacion cierre */

    function pruebaevaluacion()
    {
        $search_evaluacion = $this->notificacion_model->search_evaluaciones();
        // foreach($search_evaluacion as $key => $value){
        $this->sendNotificacionManual("ANTES_EVALUACION_CIERRE", array("data" => $search_evaluacion));
        // }
    }

    function postAgregarIncidencia() //Modificado [Suemy][2024-05-31]
    {
        header('Content-Type: application/json');
        $this->load->model('seguimiento_model', 'seguimiento');

        $reference = $this->input->post('reference', true);
        $idWeb = $this->input->post('id', true);
        $data = array(
            "tipo_incidencias_id" => $this->input->post('type'),
            "estatus" => "ACTIVO",
            "fecha_inicio" => date('Y-m-d', strtotime($this->input->post('start'))),
            "dias" => $this->input->post('type')=="1"?$this->input->post('days'):$this->input->post('days2'),
            "comentario" => $this->input->post('comment'),
            "fecha_alta" => date("Y-m-d"),
            "fecha_ultima_modificacion" => date("Y-m-d"),
            "estado" => "MANUAL",
            "justificado" => false,
            "empleado_id" =>  $this->input->post('employee')
        );
        if (empty($this->input->post('type')) || $this->input->post('type') == "undefined") {
            echo json_encode($this->response("400", "El tipo de incidencia es requerido.", $data));
            die;
        }
        if (empty($this->input->post('start')) || $this->input->post('start') == "undefined") {
            echo json_encode($this->response("400", "La fecha es requerida.", $data));
            die;
        }
        if ($this->input->post('days2') == 0 || $this->input->post('days2') == "undefined") {
            echo json_encode($this->response("400", "Desdes establecer los días.", $data));
            die;
        }
        if (empty($data["empleado_id"]) || $data["empleado_id"] == "undefined") {
            echo json_encode($this->response("400", "El empleado es requerido.", $data));
            die;
        }
        if (empty($this->input->post('comment'))) {
            echo json_encode($this->response("400", "Es necesario el comentario.", $data));
            die;
        }
        if (empty($_FILES)) {
            echo json_encode($this->response("400", "Es obligatorio anexar un documento.", $data));
            die;
        }
        $obTipoInc = $this->incidencia->getTipoIncidencia($data["tipo_incidencias_id"]);
        if ($obTipoInc->id == 1) {
            $dias = $this->persona->getVacaciones($data["empleado_id"]);
            if ($data["dias"] > $dias) {
                echo json_encode($this->response("400", "La cantidad solicitada excede los días($dias) restantes del empleado.", $data));
                die;
            }
        }
        if (empty($data["fecha_inicio"]) || $data["fecha_inicio"] == "1970-01-01") {
            echo json_encode($this->response("400", "La fecha de la incidencia es requerida.", $data));
            die;
        }

        if($obTipoInc->id == 9){ //Dennis [2021-07-27]
            if (empty($_FILES)) {
                if ($obTipoInc->documento) {
                    echo json_encode($this->response("400", "El archivo es requerido.", $data));
                    die;
                }
            }
        }

        $this->incidencia->db->trans_begin();
        $result = new \stdClass;
        $result->ok = true;

        if ($idWeb > 0) {
            $inset_id = $idWeb;

            $this->incidencia->editIncidencia($inset_id, array(
                "comentario" => $data["comentario"],
                "justificado" => true,
            ));
        } else {
            $coincidencias=$this->incidencia->coincidenciaIncidencias($data);
            if($coincidencias==true){
            echo json_encode($this->response("400", "Ya existe un registro con los mismos datos.", null));
            die;
            }else{
            $inset_id = $this->incidencia->insertIncidencias($data);
            $this->sendNotificacionManual("INCIDENCIA_ACTIVA", array("id_persona" => $data['empleado_id'], "id_incidencia" => $inset_id, "Tipoinc" => 1, "referencia" => $inset_id, "Opcion" => 'ACTIVA', "Asunto" => "Incidencia Activa"));
        }
           
        }

        $this->seguimiento->add(array(
            "referencia" => "INCIDENCIA",
            "referencia_id" => $inset_id,
            "fecha" => date("Y-m-d"),
            "fecha_alta" => date("Y-m-d"),
            "usuario_id" => $this->tank_auth->get_idPersona(),
            "comentario" => $data["comentario"]
        ));

        if (!empty($_FILES)) {
            $uploaddir = '/uploads/';
            $proye = 'REF_' . $inset_id;
            $uploaddir_ref_id =  $this->jbupload->createDirectory($reference, $proye);
            foreach ($_FILES as $file) {
                $fullname = $file["name"];
                if ($this->jbupload->moveFile($file, $uploaddir_ref_id, basename($fullname))) {
                    $files[] = $uploaddir . $file['name'];
                    $data = array(
                        'nombre' => basename($fullname),
                        'descripcion' => $fullname,
                        'ruta' => $uploaddir_ref_id,
                        'ruta_completa' => $uploaddir_ref_id . basename($fullname),
                        'tipo' => $file['type'],
                        'nombre_completo' => $fullname,
                        'revision' => '0',
                        'referencia' => $reference,
                        'referencia_id' => $inset_id,
                        'usuario_alta_id' => $this->tank_auth->get_idPersona(),
                        'fecha_alta' => date("Y-m-d")
                    );
                    $res = $this->documentsmodel->saveDocument($data);

                    if ($res->status) {
                        $result->ok = true;
                    } else {
                        $result->ok = false;
                    }
                } else {
                    $result->ok = false;
                    $result->message = 'Ocurrio un error al subir el archivo';
                }
            }
        }
        if ($this->incidencia->db->trans_status() === FALSE && $result->ok === false) {
            $this->incidencia->db->trans_rollback();
            echo json_encode($this->response("400", "Ocurrio un error al guardar la informaciÉn", null));
        } else {
            $this->incidencia->db->trans_commit();
            echo json_encode($this->response("200", "Se guardo con Éxito", null));
        }
        die;
    }

    function getDias($dateInicio, $dateFin)
    {
        //America/Mexico_City
        date_default_timezone_set('America/Mexico_City');
        $date1 = new DateTime($dateFin);
        $date2 = new DateTime($dateInicio);
        $diff = $date1->diff($date2);
        return $diff->days;
    }

    ///metodos para agregar el nuevos tipos de incidencias
    function tipoIncidencia()
    {
        //$this->comprobarpermiso($_SERVER['REQUEST_URI'],$this->tank_auth->get_idPersona());
        $incidencias_tipos = $this->global["notificationes"];

        $head = array('title' => "Capsys - Cargar incidencias masivo.");
        $data = array();
        $footer = array();
        $this->breadcrumbs->push('Tipo Incidencias', 'tipoIncidencia');
        $this->breadcrumbs->unshift('Incidencias', '/incidencias');
        $this->breadcrumbs->unshift('Inicio', '/');
        //opcion para mostar el menu lateral
        $data["tipo"]="CapitalHumano";
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
                'path' => 'gap/js/datatables.min.js'
            ), array(
                'type' => 'JS',
                'path' => 'gap/js/incidencias_tipo.table.js'
            )
        ));

        $data["notificacion"] = array_filter($incidencias_tipos, function ($it) {
            return $it["categoria"] == "INCIDENCIAS";
        });
        $data['TipoUser'] = $this->tank_auth->get_userprofile();
        $data['tabla'] = $this->incidencia->getTipoIncidencias();
        $this->render("incidencias/tipo_incidencia", $head, $data, $footer);
    }

    function re_procesar()
    {
        $incidencias =  $this->incidencia->getIncidenciasSinJustificar();
        foreach ($incidencias as $key => $value) {
            $id_in = $this->incidencia->getIncidenciasJustifiado($value->empleado_id, $value->fecha_inicio, 1, $value->tipo_incidencias_id);
            if ($id_in != null) {

                $this->incidencia->editIncidencia($id_in->idincidencias, array(
                    "justificado" => 1
                ));
                $this->incidencia->editIncidencia($value->idincidencias, array(
                    "justificado" => 1,
                    "id_justificado" => $id_in->idincidencias
                ));
            }
        }
    }

    function addTipoIncidencia()
    {
        $nombre = $this->input->post('nombre');
        $descripcion = $this->input->post('smsText');

        $datos = array(
            'nombre' => $nombre,
            'descripcion' => $descripcion,
        );
        $rules = getFormRulesTipo();
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run()) {
            if (!$this->incidencia->inserTipoIncidencia($datos)) {
                $data['mensaje'] = 'Error al agregar la incidencia';
            } else {
                $data['mensaje'] = 'Se agrego correctamente';
                return redirect('incidencias/tipoIncidencia', 'refresh');
            }
        } else {
            $this->tipoIncidencia();
        }
    }

    function deleteTipoIncidencia()
    {
        $id = $this->input->post('id');
        //var_dump($id);
        if (!$this->incidencia->EliminarTipoInicidencia($id)) {
            $data['mensaje'] = 'Error al agregar la incidencia';
        } else {
            $data['mensaje'] = 'Se agrego correctamente';
            return redirect('incidencias/tipoIncidencia', 'refresh');
        }
    }

    function buscarTipoIncidencia()
    {
        $id = $this->input->post('id');
        $data = $this->incidencia->getTipoIncidencia($id);
        $this->responseJSON("200", "Éxito", $data);
    }

    function editarTipoIncidencia()
    {
        $nombre = $this->input->post('nombre');
        $descripcion = $this->input->post('descripcion');
        $notificacion = $this->input->post('notificacion');
        $id = $this->input->post('id2');
        $data = array(
            "nombre" => $nombre,
            "descripcion" => $descripcion,
            "notificacion" => $notificacion,
            "documento" => 0
        );
        if ($id == 0) {
            $data = $this->incidencia->inserTipoIncidencia($data);
        } else {
            $data = $this->incidencia->editTipoincidencia($id, $data);
        }
        //var_dump($this->input->post('id2'));
        $this->responseJSON("200", "Éxito", $id);
    }

    //metodos de la vista
    function datosInicidencia()
    {
        header('Content-Type: application/json');
        $id = $this->input->get('id');
        $data = array(
            "incidencia" => $this->incidencia->getDataIncidencia($id),
            "documento" => $this->incidencia->getDocumentosIncidencia($id)
        );
        echo json_encode($this->response("200", "Éxito", $data));
    }

    function gestionIncidencia() //Modificado [Suemy][2024-05-31]
    {
        $id = $this->input->post('id');
        $accion = $this->input->post('accion');
        $comentario = $this->input->post('comentario');
        $FechaSubida = getdate();
        $usr_autorizacion = $this->tank_auth->get_idPersona();
        if ($accion === '2') {
            $estatus = 'RECHAZADO';
            $EstaN = 'INCIDENCIA_RECHAZADA';
            $status_i = "Incidencia Rechazada";
        }
        if ($accion === '1') {
            $estatus = 'AUTORIZADO';
            $EstaN = 'INCIDENCIA_APROBADA';
            $status_i = "Incidencia Aprobada";
            //$comentario="";
        }

        $this->seguimiento->add(array(
            "referencia" => "INCIDENCIA",
            "referencia_id" => $id,
            "fecha" => date("Y-m-d"),
            "fecha_alta" => date("Y-m-d H:i:s"),
            "usuario_id" => $this->tank_auth->get_idPersona(),
            "comentario" => $comentario
        ));

        $data = array(
            'fecha_autorizacion' => $FechaSubida['year'] . '-' . $FechaSubida['mon'] . '-' . $FechaSubida['mday'],
            'usuario_autorizacion' => $usr_autorizacion,
            'comentario_rechazo' => $comentario,
            'estatus' => $estatus,
        );
        $res = $this->incidencia->updateEstadoIncidencia($data, $id);
        if ($res == 1) {
            echo json_encode(array("mensaje" => "Se realizo correctamente la operacion"));
        } else {
            echo json_encode(array("mensaje" => "Hubo un error, realizelo depues"));
        }
        $idusr = $this->incidencia->getDataIncidencia($id);
        $this->sendNotificacionManual($EstaN, array("id_persona" => $idusr->empleado_id, "id_incidencia" => $id, "Tipoinc" => 2, "referencia" => $id, "Opcion" => $EstaN, "Asunto" => $status_i));
        //$result=$this->incidencia->updateEstadoIncidencia();
    }

    private function stringContains($string, $owned_urls)
    {
        $result = array();
        foreach ($owned_urls as $url) {
            if (strstr($string, $url)) { // mine version
                // if (strpos($string, $url) !== FALSE) { // Yoshi version
                array_push($result, $url);
            }
        }
        return count($result) > 0;
    }

    public function postUploadOneMinute()
    {
        if (!isset($_POST['isRequest'])) {
            $head = array('title' => "Capsys - Cargar incidencias masivo.");
            $data = array();
            $footer = array();

            $this->breadcrumbs->push('Cargar incidencias masivo', 'incidencias/cargar_documento');
            $this->breadcrumbs->unshift('Incidencias', '/incidencias');
            $this->breadcrumbs->unshift('Inicio', '/');
            $data['breadcrumbs'] = $this->breadcrumbs->show();
            //opcion para mostar el menu lateral
            $data["tipo"]="CapitalHumano";
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
                    'path' => 'js/fileupload/public/bundle-incidencias.js'
                ), array(
                    'type' => 'JS',
                    'path' => 'js/fileupload/public/bundle-preview.js'
                ), array(
                    'type' => 'JS',
                    'path' => 'gap/js/incidencias.js'
                )
            ));
            $this->render('incidencias/cargar_documento', $head, $data, $footer);
        } else {
            $this->_postUpload();
        }
    }

    private function _postUpload()
    {

        $incidencias_tipos = $this->global["incidencia"];

        header('Content-Type: application/json');
        date_default_timezone_set('UTC');
        $this->load->library('PHPExcel-1.8/Classes/PHPExcel');
        $formatos = array(
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/octet-stream'
        );

        $archivo = $_FILES['document']['tmp_name'];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $archivo);
        finfo_close($finfo);

        if (!in_array($mime, $formatos)) {
            echo json_encode($this->response("400", "El tipo de documento no es el correcot", null));
            die;
        }

        try {
            $objPHPExcel = PHPExcel_IOFactory::load($archivo);
        } catch (Exception $e) {
        }

        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        $id_empleado = -1;
        $name_empleado = "";
        $oEmp = new \stdClass();
        $data = array();

        for ($row = 1; $row <= $highestRow; $row++) {
            $rowData = $sheet->rangeToArray(
                'A' . $row . ':' . $highestColumn . $row
            );
            $tmp_id = $rowData[0][1];
            if ($id_empleado == -1) {
                if (empty($tmp_id) && $id_empleado == -1)
                    continue;

                if (!is_numeric($tmp_id) && $id_empleado == -1)
                    continue;

                $id_empleado = $tmp_id;
                $name_empleado = $rowData[0][2];
                $oEmp = $this->incidencia->getEmpleadoOnTheMinute($id_empleado);
            } else {
                if (is_numeric($tmp_id)) {
                    $id_empleado = $tmp_id;
                    $name_empleado = $rowData[0][2];
                    $oEmp = $this->incidencia->getEmpleadoOnTheMinute($id_empleado);
                    continue;
                } else {

                    if ($oEmp == null)
                        continue;

                    $incidencia = $rowData[0][13];
                    if (!$this->stringContains($rowData[0][4], array("AM", "PM")))
                        $starFecha = null;
                    else
                        $starFecha = date('Y-m-d', strtotime($rowData[0][3])) . " " . $rowData[0][4];

                    if (!$this->stringContains($rowData[0][7], array("AM", "PM")))
                        $endFecha = null;
                    else
                        $endFecha = date('Y-m-d', strtotime($rowData[0][3])) . " " . $rowData[0][7];

                    if ($starFecha == null && $endFecha == null)
                        continue;

                    $sthour = $starFecha = date('Y-m-d', strtotime($rowData[0][3])) . " " . $rowData[0][5];

                    $dStarFecha = new DateTime($starFecha);
                    $dEndFecha = new DateTime($endFecha);

                    $tipo_incidencia_id = null;
                    if (empty($incidencia)) {
                        if ($endFecha == null) {
                            $tipo_incidencia_id = $incidencias_tipos["ENDRADA/SALIDA"];
                        }
                    } else {
                        $tipo_incidencia_id = $incidencias_tipos[$incidencia];
                    }

                    $id_incidencia = $this->incidencia->validarIncidencia($oEmp->idPersona, $dStarFecha->format('Y-m-d'), 1, $tipo_incidencia_id);
                    array_push($data, array(
                        'fecha' => $dStarFecha->format('Y-m-d'),
                        'empleado' => $name_empleado,
                        'empleado_id' => $oEmp->idPersona,
                        'incidencia_id' => $id_incidencia,
                        'tipo_incidencia_id' => $tipo_incidencia_id,
                        'entrada' => ($starFecha == null) ? null : $dStarFecha->format('Y-m-d H:i:s'),
                        'salida' => ($endFecha == null) ? null : $dEndFecha->format('Y-m-d H:i:s'),
                        'incidencia' => $incidencia
                    ));
                }
            }
        }

        $result = $this->incidencia->postOnMinute($data);
        if ($result->ok) {
            echo json_encode($this->response("200", "Se cargo la información", $result->data));
        } else {
            $message = "Ocurrio un error al procesar la información";
            $code = "400";
            if (empty($result->data)) {
                $message = "No se encontro nueva información para procesar.";
                $code = "200";
            }
            echo json_encode($this->response($code, $message, null));
        }
        die;
    }

    function map_clientes($array){
        $clientes="(";
        $num=count($array);
        foreach ($array as $key => $value) {
            if($num-1==$key){
                $clientes=$clientes.$value["id"];
            }else{
                $clientes=$clientes.$value["id"].",";
            }
        }
        $clientes=$clientes.")";
        return empty($array)?"(0)":$clientes;
    }
}
