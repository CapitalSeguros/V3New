<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tablero extends TIC_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('cookie');
        $this->load->model('reportesmodel', 'reportes_model');
        $this->load->model("personamodelo", "persona");
        $this->load->model('evaluacion_periodos_model', 'periodo');
        $this->load->model('incidenciasmodel', 'incidencia');
        $this->load->library('graficos');
    }

    public function index()
    {
        $head = array("title" => "Capsys - Tablero");
        $data = array();
        $footer = array();


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

        $empleados = $this->persona->getEmpleados();
        $_puestos = $this->persona->getPuestos();
        $_puestos2 = $this->getPuestos();
        $periodos = $this->periodo->select_listado_Cerrados();

        $data["incidencia_mensual"] = $this->graficos->render("INCIDENCIAS_MENSUALES", $filtro);
        $data["incidencia_trimestral"] = $this->graficos->render("INCIDENCIAS_TRIMESTRAL", $filtro);
        $data["comparativo_col"] = $this->graficos->render("COMPARATIVO_COLABORADORES", $filtro);

        $data["rotacion_personal"] = $this->graficos->render("ROTACION_PERSONAL", $filtro);
        $data["crecimiento_periodo"] = $this->graficos->render("CRECIMIENTO_PERIODO", $filtro);
        $data["evaluacion_competencia"] = $this->graficos->render("EVALUACIONES_COMPETENCIAS", $filtro);
        $data["evaluacion_desempenio"] = $this->graficos->render("EVALUACIONES_DESEMPENIO", $filtro);
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
                'data' => "const _empleados = " . json_encode($empleados) . "; const _puestos = " . json_encode($_puestos) . "; const _puestos2 = " .json_encode($_puestos2). "; const _periodos = " . json_encode($periodos) . ";"
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
                'data' => $data["incidencia_mensual"]["JS"] . $data["incidencia_trimestral"]["JS"] . $data["comparativo_col"]["JS"] . $data["rotacion_personal"]["JS"] . $data["crecimiento_periodo"]["JS"] . $data["evaluacion_competencia"]["JS"] . $data["evaluacion_desempenio"]["JS"]
            ),
            // array(
            //     'type' => 'JSHTML',
            //     'data' => $data["grafico4"]["JS"]
            // ),
            // array(
            //     'type' => 'JSHTML',
            //     'data' => $data["grafico5"]["JS"]
            // ),
            // array(
            //     'type' => 'JSHTML',
            //     'data' => $data["grafico6"]["JS"]
            // ),
            // array(
            //     'type' => 'JSHTML',
            //     'data' => $data["grafico7"]["JS"]
            // )

        ));

        $this->breadcrumbs->push('tablero', 'tablero/');
        $this->breadcrumbs->unshift('Inicio', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();

        $this->render('tableros/reporte', $head, $data, $footer);
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

            if (strtolower($key) == strtolower($seriename)) {
                $incidencia[] = $value;
                break;
            }
        }

        $range = $this->incidencia->detalle_incidencias_mensuales($fecha_inicio, $fecha_fin, $incidencia, $filtro);

        if (count($range) == 0) {
            array_push($datos, 0);
            $range = $datos;
        }

        $this->responseJSON("200", "Éxito", $range);
    }

    public function getreporteevaluacion()
    {
        header('Content-Type: application/json');
        $data = $this->reportes_model->getreporteevaluacion();
        echo json_encode($this->response("200", "Éxito", $data));
    }


    public function getreporteprueba()
    {
        $data = $this->reportes_model->getreporteincidencia();
        //$data = $this->reportes_model->getreporteevaluacion();

        //if (count($data) > 0) {
        print_r($this->graficos->render("INCIDENCIAS_FALTAS", $data));
        // $this->graficos->render("INCIDENCIAS_FALTAS2", $data);
        // $this->graficos->render("INCIDENCIAS_FALTAS3", $data);
        //}
    }
}
