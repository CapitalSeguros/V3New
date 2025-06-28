<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Graficos
{
    protected $reporte;

    function __construct($global)
    {
        $this->CI = &get_instance();
        $this->config($global);
        $this->CI->config->load('global', TRUE);
        $this->CI->global = $this->CI->config->item('global');
        $this->CI->load->model('graficas_model', 'graficas');
        $this->CI->load->model('autos_model', 'autos');
        $this->CI->load->library('common');
    }

    protected function config($global, $new_options = [])
    {
        $options = $global;
        $options = array_merge($options, $new_options);

        $this->reporte = $options['reporte'];
    }


    public function getGrafico($nombre_reporte)
    {
        $grafico = array_filter($this->reporte, function ($item) use ($nombre_reporte) {
            return $item["id"] == $nombre_reporte;
        });

        $grafico = $grafico[key($grafico)];

        return $grafico;
    }

    public function render($nombre_reporte = null, $filtros = null,$tipo=null,$date=false)
    {
        $grafico = $this->getGrafico($nombre_reporte);
        $_filtros = array();
        $this->procesarFiltro($filtros, $grafico);

        switch ($nombre_reporte) {
            case 'INCIDENCIAS_MENSUALES':
                $_filtros = $this->getDatos($filtros,"INCIDENCIAS");
                break;
            case 'INCIDENCIAS_TRIMESTRAL':
                $_filtros = $this->getDatos($filtros,"INCIDENCIAS");
                break;
            case 'COMPARATIVO_COLABORADORES':
                $_filtros = $this->getDatosLine($filtros, $grafico);
                break;
            case 'ROTACION_PERSONAL':
                $_filtros = $this->getRotacion($filtros, $grafico);
                break;
            case 'CRECIMIENTO_PERIODO':
                $_filtros = $this->getCrecimiento($filtros, $grafico);
                break;
            case 'EVALUACIONES_COMPETENCIAS':
                $_filtros = $this->getEvalByCompetencia($filtros, $grafico);
                break;
            case 'EVALUACIONES_DESEMPENIO':
                $_filtros = $this->getEvaluacionDesempenio($filtros, $grafico);
                break;
            //AUTOS WEB SERVICE
            case 'TEST':
                $_filtros = $this->getDatos($filtros,"SINIESTROS");
                break;
            case 'SINIESTROS_TODOS_LOS_MESES':
                $_filtros = $this->get_data_siniestros($filtros, $grafico,"SINIESTROS");
                break;
            case 'SINIESTROS_COMPARACION_MESES':
                $_filtros = $this->get_data_siniestros_comparacion($filtros, $grafico,"SINIESTROS_MESES");
                break;
            case 'SINIESTROS_TOP_ESTADOS':
                $_filtros = $this->getDatosTop($filtros,"SINIESTROS_TOP");
                 break;
            case 'CORTE_SINIESTROS':
                $_filtros = $this->getDatosTop($filtros,"SINIESTROS_RANGO");
                break;
            //DAÑOS Y AUTOS INDIVUDIAL 
            case 'SINIESTROS_AUTOS_TOTAL':
                $_filtros = $this->getstatusAutosSiniestros($filtros,$tipo);
                break;   
            case 'SINIESTROS_AUTOS_ANO_ACTUAL':
                $_filtros = $this->getSiniestrosAutosAnos($filtros,$tipo);
                break;
            case 'SINIESTROS_AUTOS_COMPARACION':
                    $_filtros = $this->get_data_siniestros_comparacion_2($filtros,$tipo);
                    break;
            case 'SINIESTROS_TOP_ESTADOS_AUTOS':
                $_filtros = $this->getDatosTop_2($filtros,$tipo);
                break;
            case 'SINIESTROS_RANGO_AUTOS':
                $_filtros = $this->getDatosRango($filtros,$tipo);
                break;
            //daños  
            case 'SINIESTROS_DANOS_TOTAL':
                //$_filtros = $this->getDatosRango($filtros,$tipo); //getstatusAutosSiniestros
                $_filtros = $this->getstatusAutosSiniestros($filtros,$tipo);
            break;
            case 'SINIESTROS_DANOS_ANO_ACTUAL':
                $_filtros = $this->getSiniestrosAutosAnos($filtros,$tipo);
            break;
            case 'SINIESTROS_DANOS_COMPARACION':
                $_filtros = $this->get_data_siniestros_comparacion_2($filtros,$tipo);
                break;
            case 'SINIESTROS_TOP_ESTADOS_DANOS':
                $_filtros = $this->getDatosTop_2($filtros,$tipo);
                break;
            case 'SINIESTROS_RANGO_DANOS':
                $_filtros = $this->getDatosRango($filtros,$tipo);
                break;
            //Siniestros GMM
            case 'SINIESTROS_GMM':
                $_filtros = $this->getstatusGMM($filtros,$tipo);//getSiniestrosGMMAnos
                break;
            case 'SINIESTROS_GMM_ANO_ACTUAL':
                $_filtros = $this->getSiniestrosGMMAnos($filtros,$tipo);//get_data_siniestros_comparacion_GMM
                break;
            case 'SINIESTROS_GMM_COMPARACION':
                $_filtros = $this->get_data_siniestros_comparacion_GMM($filtros,$tipo);//getDatosTop_GMM
                break;
            case 'SINIESTROS_TOP_ESTADOS_GMM':
                $_filtros = $this->getDatosTop_GMM($filtros,$tipo);//getDatosRangoGMM
                break;
            case 'SINIESTROS_RANGO_GMM':
                $_filtros = $this->getDatosRangoGMM($filtros,$tipo);//getDatosRangoGMM
                break;
            default:
                break;
        }

        $chart =  array(
            "chart" => array(
                "id" => $nombre_reporte,
                "type" => ""
            ),
            "title" => array(
                "text" => $this->titulo($grafico["title"], $grafico["type"]),
                "align" => ""
            ),
            "tooltip" => array(
                "enabled" => true
            )
        );

        $data = array();
        switch ($grafico["type"]) {
            case 'bar':
                $chart["chart"]["type"] = "bar";
                $chart["series"] = $_filtros["series"];
                // $chart["title"]["text"] = $this->titulo($titulo, $grafico["type"]);
                $chart["xaxis"]["categories"] = $_filtros["options"]["xaxis"]["categories"];
                $contador = count($chart["xaxis"]["categories"]);
                if ($contador > 1) {
                    if ($grafico["id"] == "CRECIMIENTO_PERIODO" || $grafico["id"] == "EVALUACIONES_COMPETENCIAS" || $grafico["id"] == "EVALUACIONES_DESEMPENIO") {
                        $chart["plotOptions"] = array(
                            "bar" => array(
                                "horizontal" => true,
                                "columnWidth" => "8%"
                            )
                        );
                        $chart["xaxis"]["type"] = "category";
                        $chart["yaxis"]["labels"] = array(
                            "style" => array(
                                "fontSize" => '8px',
                                "cssClass" => 'apexcharts-xaxis-label'
                            )
                        );
                    } else {
                        $chart["plotOptions"] = array(
                            "bar" => array(
                                "horizontal" => false,
                                "columnWidth" => "8%"
                            )
                        );
                    }
                }
                break;
            case 'line':
                $chart["chart"]["type"] = "line";
                $chart["series"] = $_filtros["series"];
                // $chart["title"]["text"] = $this->titulo($titulo, $grafico["type"]);
                $chart["markers"]["size"] = 3; //necesario para poder ejecutar el dataponitselection
                // $chart["tooltip"]["shared"] = false; //para mostrar el modal porque no funciona el evento
                // $chart["tooltip"]["intersect"] = true; //click
                $chart["tooltip"] = array(
                    "x" => array(
                        "show" => true
                    )
                );
                $chart["xaxis"]["categories"] = $_filtros["options"]["xaxis"]["categories"];
                $contador = $chart["xaxis"]["categories"];
                if ($contador > 1) {
                    $chart["plotOptions"] = array(
                        "bar" => array(
                            "horizontal" => false,
                            "columnWidth" => "8%"
                        )
                    );
                }
                $chart["stroke"] = array(
                    "curve" => "smooth",
                    "width" => [2, 1]
                );
                break;
            case 'pie':
                $chart["chart"]["type"] = "pie";
                $chart["series"] = $_filtros["series"];
                // $chart["title"]["text"] = $this->titulo($titulo, $grafico["type"]); 
                $chart["labels"] = $_filtros["labels"];

                break;
            default:
                break;
        }

        $chart["title"]["align"] = "left";
        $chart["title"]["style"] = array(
            "fontSize" => "12px",
            "fontWeight" => "bold",
            "fontFamily" => "Open Sans, sans-serif"
        );

        $chart["xaxis"]["tickPlacement"] = "on";
        $chart["colors"]=array('#149EF7', '#E74C3C','#138D75','#2ECC71','#AB47BC','#F4D03F','#5D6D7E','#FFA301','#0570A6','#CC14BA','#DB2364','#53149C','#87D11F');
        $chart["chart"]["height"] = 300;
        $chart["chart"]["width"] = 480;
       /*  $chart["chart"]["height"] = 400;
        $chart["chart"]["width"] = 480; */
        $chart["chart"]["id"] = $nombre_reporte;
        $data["chart"] = $chart;
        $data["name"] = $nombre_reporte;
        $data["title"] = $grafico["title"];
        $data["año"]=isset($grafico["año"])?1:0;
        $data["mes"]=isset($grafico["mes"])?1:0;

        $data["filter"] = $grafico["filter"];
        $data["multiple"] = @$grafico["multiple"];
        $data["filter_default"] =  $grafico["filter_default"];

        if ($grafico["type"] == "pie" || $grafico["type"] == "bar") {
            if ($grafico["type"] == "pie") {
                $data["function"] = array(
                    "click" => "window.click" . $grafico["id"] . ", beforeMount: function (chartContext, config) {
                      }"
                );
            }
            if ($grafico["type"] == "bar") {
                $data["function"] = array(
                    "click" => "window.click" . $grafico["id"] . ", beforeMount: function (chartContext, config) {
                        // console.log(chartContext);
                        // console.log(config);
                    }"
                );
                $data["formatter"] = array(
                    "formatter" => "window.formatter"
                );
            }
        } else {
            $data["function"] = array(
                "dataPointSelection" => "window.dataPointSelection" . $grafico["id"] . " "
            );
        }
        return array(
            "JS" => $this->printJS($data),
            "HTML" => $this->parsePlantilla($grafico["template"], $data, $this->printACCION($data))
        );
    }

    function printACCION($data)
    {
        $multiple = "";
        if (isset($data["multiple"])) {
            $multiple = "data-chart-multiple";
        }
        return "<a id='btnfilter-" . $data["name"] . "' class='bn-open-filter pull-right' $multiple style='color:white;margin-top: -6px;' data-chart-title='" . $data["title"] . "' data-chart-name='" . $data["name"] . "' data-date='".date('Y-m-d')."' data-filter='" . implode(",", $data["filter"]) . "'  data-filter-default='" . implode(",", $data["filter_default"]) . "' data-uri-filter='" . base_url() . "tableros_siniestros/updateChart' data-setmonth='".$data["mes"]."'  data-setyear='".$data["año"]."'>
        <i class='fa fa-cog fa-2x' aria-hidden='true'></i></a>";
    }

    //javascript para ejecutar el apexchart y generar la gráfica
    function printJS($data)
    {
        $sfun = "";
        if (isset($data["function"])) {
            $sfun = "options.chart.events ={
                " . key($data["function"]) . " : " . $data["function"][key($data["function"])] . "
            }";
        }

        $forfun = "";
        if (isset($data["formatter"])) {
            $forfun = "options.dataLabels ={
                " . key($data["formatter"]) . ":" . $data["formatter"][key($data["formatter"])] . "
            }";
        }

        return " var options = " . json_encode($data["chart"], JSON_NUMERIC_CHECK) . ";
            $sfun
            $forfun
            let chart_" . $data["name"] . " = new ApexCharts(document.querySelector('#graficos_" . $data["name"] . "'), options);
            chart_" . $data["name"] . ".render();";
    }

    //devolver html de la grafica
    public function parsePlantilla($pathString, $data,  $action)
    {
        if (!empty($pathString) && !empty($data)) {
            $view = $this->CI->parser->parse($pathString, array(
                "name" => $data["name"],
                "title" => $data["title"],
                "año"=>$data["año"],
                "mes"=>$data["mes"],
                "action" => $action,
            ), TRUE);
            return $view;
        }
    }

    //retorna el titulo del la gráfica
    public function titulo($titulo = null, $type)
    {
        if (empty($titulo)) {
            if ($type == "line") {
                $type = "lineas";
            }
            if ($type == "pie") {
                $type = "circular";
            }
            if ($type == "bar") {
                $type = "barras";
            }
            $texto = "Gráfica de tipo $type";
        } else {
            $texto = $titulo;
        }
        return $texto;
    }

    function procesarFiltro(&$filtro, $grafico)
    {
        if ($grafico != null) {
            $filter_default = $grafico["filter_default"];

            foreach ($filter_default as $fk => $fv) {
                $_fil = explode(":", $fv);
                if (count($_fil) > 1)
                    $filtro[$_fil[0]] = $_fil[1];
            }
        }
    }

    function getDatos($filtro,$tipo= null)
    {
        $fecha_inicio = $this->CI->common->first_date($filtro["fecha"]);
        $fecha_fin = $this->CI->common->last_date($filtro["fecha"], $filtro["periodo"]);

        $datos = array();
        if($tipo=="INCIDENCIAS"){
            $range = $this->CI->graficas->tipoincidenciaByFecha($fecha_inicio, $fecha_fin, $filtro);
            $evIncidencias = $this->CI->global["evaluacion_incidencias"];
        }else{
            $año=date("Y",strtotime($filtro["fecha"]));
            $mes= date('m', strtotime($filtro["fecha"]));
            $range=$this->CI->graficas->grafica_siniestro_estatus($filtro["clientes"],$mes,$año);
            //$evIncidencias = $this->CI->global["evaluacion_siniestros"];
            $evIncidencias=$this->CI->graficas->getConfigGrafica();
        }
        /* $range = $this->CI->graficas->tipoincidenciaByFecha($fecha_inicio, $fecha_fin, $filtro);
        $evIncidencias = $this->CI->global["evaluacion_incidencias"]; */
        $labels = array_map(function ($it) use ($range, &$datos) {
            $exist_incidencia = array_filter($range, function ($item) use ($it) {
                return in_array($item["tipo_incidencias_id"], $it["valor"]);
            });
            if (count($exist_incidencia) > 0) {
                $tt = array_sum(array_map(function ($i) {
                    return $i["total"];
                }, $exist_incidencia));
                    array_push($datos, $tt);
                } else {
                    array_push($datos, 0);
                }
                return $it["titulo"];
            }, $evIncidencias);
    
            $labels = array_values($labels);
        //$lol=array("series" => $datos, "labels" => $labels);
        //var_dump($lol);
        return array("series" => $datos, "labels" => $labels);
    }

    function getDatosC($filtro){

    }

    function getDatosTop($filtro,$tipo= null){
        $labels=array();
        $datos=array();
        $all=[];
        $año=date("Y",strtotime($filtro["fecha"]));
        $mes= date('m', strtotime($filtro["fecha"]));
        if($tipo=="SINIESTROS_TOP"){
            $consulta=$this->CI->graficas->grafica_siniestro_estados($mes,$año,$filtro["clientes"]);
            /* $labels=array("Quintana Roo","Jalisco","México","Nuevo León","Distrito Federal");
            $datos=array(4,6,8,78,45); */
            foreach ($consulta as $key => $value) {
                //$all[$value["nombre"]]=$value["total"];
                array_push($labels,$value["nombre"]);
                array_push($datos,$value["total"]);
            }
            
            //$labels=array("Quintana Roo","Jalisco","M\u00e9xico","Nuevo Le\u00f3n","Distrito Federal");
            //$labels=array_keys($all);
        }else{
            $today=date("Y");
            $consulta=$this->CI->graficas->get_rango_table($today,$filtro["clientes"]);
            unset($consulta[0]["Total"]);
            $datos=array_values($consulta[0]);
            $labels=array_keys($consulta[0]);
        }
        /* $lol=array("series" => $datos, "labels" => $labels);
        var_dump($lol); */
        return array("series" => $datos, "labels" => $labels);
        //return array("series" => $series, "options" => array("xaxis" => array("categories" => array_values($labels))));
    }

    function getDatosLine($filtro, $grafico = null)
    {
        $meses = array(1 => "Ene", 2 => "Feb", 3 => "Mar", 4 => "Abr", 5 => "May", 6 => "Jun", 7 => "Jul", 8 => "Agt", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dic");
        $fecha_inicio_anual = "";
        $fecha_fin_anual = "";
        $colaboradores = array();
        $idPersona = $this->CI->tank_auth->get_idPersona();

        if ($filtro != null) {
            $fecha = $filtro["fecha"];
            $mes_actual = date('m', strtotime($fecha));
        } else {
            $fecha_actual = date('Y-m-d');
            $mes_actual = date('m', strtotime($fecha_actual));
        }

        if ($grafico != null) {
            $filter_default = $grafico["filter_default"];
            if (!empty($filter_default)) {
                foreach ($filter_default as $fk => $fv) {
                    $_fil = explode(":", $fv);
                    if (count($_fil) > 0)
                        $filtro[$_fil[0]] = $_fil[1];
                }
            }
        }

        if (empty($filtro["colaborador"])) {
            $filtro["colaborador"] = $idPersona;
        } else {
            foreach ($filtro["colaborador"] as $key => $value) {
                if (!empty($value)) {
                    array_push($colaboradores, $value);
                } else {
                    array_push($colaboradores, $value["value"]);
                    $filtro["colaborador"] = $colaboradores;
                }
            }
        }

        $dato_mes_2 = array();
        $dato_anual_2 = array();
        $nombres = array();

        $fecha_anual = $this->CI->common->getfechaanual($filtro["fecha"]);
        $fecha_inicio_anual = $fecha_anual["fecha_inicio_anual"];
        $fecha_fin_anual = $fecha_anual["fecha_fin_anual"];

        $range_anual = $this->CI->graficas->tipoincidenciaByFechaColaborador($fecha_inicio_anual, $fecha_fin_anual, $filtro);

        $array_parametros = json_decode(json_encode($range_anual), True);
        $group_anual = $this->CI->graficas->group_by("empleado", $array_parametros); //agrupado por empleado para poder graficar linea por cada empleado

        // print_r($group_anual);
        $categoria_meses = array_values($meses);
        // if (is_array($range_anual)) {

        foreach ($group_anual as $it) {

            $dato_anual = array();
            $dato_mes = array();
            foreach ($meses as $key => $value) {
                $fecha = array_filter($it, function ($item) use ($key) {
                    return $item["fecha"] == $key;
                });

                $fecha = array_values($fecha);
                if (count($fecha) > 0) {
                    $tt = array_map(function ($i) {
                        return $i["total"];
                    }, $fecha);
                    array_push($dato_anual, $tt[0]);
                } else {
                    array_push($dato_anual, 0);
                }

                if ($key == $mes_actual) {
                    $tt = array_map(function ($i) {
                        return $i["total"];
                    }, $fecha);
                    if ($tt > 0 && $tt != null) {
                        array_push($dato_mes, $tt[0]);
                    } else {
                        array_push($dato_mes, 0);
                    }
                } else {
                    array_push($dato_mes, 0);
                }
            }
            array_push($dato_anual_2, $dato_anual);
            array_push($dato_mes_2, $dato_mes);
        }

        $_dato1 = array();
        foreach ($dato_anual_2 as $value) {
            $dato1 = array("name" => "Anual ", "type" => "line", "data" => $value); //COVID-19
            array_push($_dato1, $dato1);
        }

        $_dato2 = array();
        foreach ($dato_mes_2 as $value) {
            $dato2 = array("name" => "Mensual", "type" => "line", "data" => $value);
            array_push($_dato2, $dato2);
        }
        $datosanuales_mensuales = array_merge($_dato1, $_dato2);

        return array("series" => $datosanuales_mensuales, "options" => array("xaxis" => array("categories" => array_values($meses))));

        // }else{
        //     return array("series" => array(array("name" => "Anual", "type" => "line", "data" => array(0,0,0,0,0,0,0,0,0,0,0,0)),array("name" => "Mensual", "type" => "line", "data" => array(0,0,0,0,0,0,0,0,0,0,0,0))), "options" => array("xaxis" => array("categories" => array_values($meses))));
        // }


        // }
    }

    function getRotacion($filtro, $grafico = null)
    {
        $title = "";
        $array_anios = array();
        $array_bajas = array();
        $fecha_inicio_anual = "";
        $fecha_fin_anual = "";
        $rotacion = array();

        if ($grafico != null) {
            $title = $grafico["title"];
        }
        if ($filtro["fechaInicio"] == $filtro["fechaFin"]) {
            $fecha = date('Y-m-d');
            $nuevafecha = strtotime('-3 year', strtotime($fecha));
            $nuevafecha = date('Y-m-d', $nuevafecha);

            $fecha_fin = $fecha;
            $fecha_inicio = $nuevafecha;

            $fechaini_anual = $this->CI->common->getfechaanual($fecha_inicio);
            $fechafin_anual = $this->CI->common->getfechaanual($fecha_fin);
        } else {

            $fecha_inicio = $filtro["fechaInicio"];
            $fecha_fin = $filtro["fechaFin"];


            $fechaini_anual["fecha_inicio_anual"] = $this->CI->common->first_date($fecha_inicio);
            $fechafin_anual["fecha_fin_anual"] = $this->CI->common->last_date($fecha_fin);
            // //$fecha_actual = date('Y-m-d', strtotime($fecha_inicio));
            // $fecha_inicio = "2014-05-23";
            // $fecha_fin = "2025-03-12";
            // $fechaini_anual = $this->CI->common->getfechaanual($fecha_inicio);
            // $fechafin_anual = $this->CI->common->getfechaanual($fecha_fin);           
        }

        $fecha_inicio_anual = $fechaini_anual["fecha_inicio_anual"];
        $fecha_fin_anual = $fechafin_anual["fecha_fin_anual"];

        $anio = date("Y", strtotime($fecha_inicio));
        $baja_personal = $this->CI->graficas->count_bajapersonal($fecha_inicio_anual, $fecha_fin_anual, $filtro);

        foreach ($baja_personal as $value) {
            $total_empleados = $value["total"];
            $sum_baja = ($value["baja"] > 0) ? $value["baja"] : 0;
            $rotacion = ($sum_baja / $total_empleados) * 100;
            $decimals = round($rotacion, 2);
            array_push($array_anios, $value["anio"]);
            array_push($array_bajas, $decimals);
        }

        $series = array(
            array(
                "name" => "ROTACIÓN DE PERSONAL",
                "data" => $array_bajas
            )
        );

        $options  = array(
            "xaxis" => array("categories" => $array_anios)
        );

        return array("series" => $series, "options" => $options);
    }


    function getCrecimiento($filtros, $grafico = null)
    {
        $title = "";
        $nombre = array();
        $calificacion = array();
        $periodo = "";

        $evaluacion_periodo = $this->CI->graficas->activo();

        if ($filtros["periodos"] > 0) {
            $periodo = $filtros["periodos"]["value"];
        } else {
            $periodo = @$evaluacion_periodo->id;
        }
        $crecimiento = $this->CI->graficas->getgraficaEvaluacion($periodo);

        foreach ($crecimiento as $value) {
            // print_r($value->nombre);
            $calif = round($value->calificacion, 2);
            array_push($nombre, $value->nombre);
            array_push($calificacion, $calif);
        }

        if (count($calificacion) > 0) {
            $calificacion = $calificacion;
        } else {
            $calificacion = array(0);
        }
        if (count($nombre) > 0) {
            $nombre = $nombre;
        } else {
            $nombre = array(0);
        }

        $series = array(
            array(
                "data" => $calificacion
            )
        );

        $options  = array(
            "xaxis" => array("categories" => $nombre, "tickPlacement" => "on"),
            "yaxis" => array(
                "labels" => array(
                    "style" => array(
                        "fontSize" => '8px',
                        "cssClass" => 'apexcharts-xaxis-label',

                    )
                )
            ),


            "plotOptions" => array(
                "bar" => array(
                    "horizontal" => true
                )
            )

        );


        return array("series" => $series, "options" => $options);
    }

    function getEvalByCompetencia($filtros, $grafico = null)
    {
        $titulos = array();
        $calificacion = array();

        $eval_compete = $this->CI->graficas->getEvaluacionByCompetencia($filtros);
        foreach ($eval_compete as $value) {
            $calif = round($value->porcentaje, 2);
            array_push($titulos, $value->titulo);
            array_push($calificacion, $calif);
        }
        if (count($calificacion) > 0) {
            $calificacion = $calificacion;
        } else {
            $calificacion = array(0);
        }
        if (count($titulos) > 0) {
            $titulos = $titulos;
        } else {
            $titulos = array(0);
        }

        $datos = $this->graficahorizontal($calificacion, $titulos);

        return $datos;
    }

    function getEvaluacionDesempenio($filtros, $grafico = null)
    {
        $periodo = "";
        $array_data = array();
        $array_categories = array();
        $evaluacion_periodo = $this->CI->graficas->activo();

        if ($filtros["periodos"] > 0) {
            $periodo = $filtros["periodos"]["value"];
        } else {
            $periodo = @$evaluacion_periodo->id;
        }

        $eval_desempeño = $this->CI->graficas->getEvaluacionDesempenio($periodo);

        foreach ($eval_desempeño as $value) {
            array_push($array_data, $value->mayores);
            array_push($array_data, $value->iguales);
            array_push($array_data, $value->menores);
        }

        if (count($array_data) > 0) {
            $array_data = $array_data;
        } else {
            $array_data = array(0, 0, 0);
        }

        $array_categories = array("Mayores de 85", "Iguales a 85", "Menores a 85");

        $datos = $this->graficahorizontal($array_data, $array_categories);

        return $datos;
    }


    function graficahorizontal($data, $categories)
    {
        $series = array(
            array(
                "data" => $data
            )
        );

        $options  = array(
            "xaxis" => array(
                "categories" => $categories
            ),
            "plotOptions" => array(
                "bar" => array(
                    "horizontal" => true
                )
            )
        );

        return array("series" => $series, "options" => $options);
    }

    function get_data_siniestros($filtro, $grafico = null,$tipo){
        $Año=date("Y",strtotime($filtro["fecha"]));
        $meses = array(1 => "Ene", 2 => "Feb", 3 => "Mar", 4 => "Abr", 5 => "May", 6 => "Jun", 7 => "Jul", 8 => "Agt", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dic");
        $result_array=array();
        $result_array[]=$this->resultado_lineas_siniestros("Siniestro total por mes","1",$Año,$filtro["clientes"]);
        $result_array[]=$this->resultado_lineas_siniestros("Siniestro liquidados por mes","2",$Año,$filtro["clientes"]);
        //$lol=array("series" => $result_array, "options" => array("xaxis" => array("categories" => array_values($meses))));
        //var_dump($lol);
        return array("series" => $result_array, "options" => array("xaxis" => array("categories" => array_values($meses))));
    }

    function get_data_siniestros_comparacion($filtro, $grafico = null,$tipo){
        setlocale(LC_TIME, 'es_ES');
        $result_array=array();
        $today=date("d-m-Y",strtotime($filtro["fecha"]));
        $mesactual=date("n",strtotime($today));
        $meses = array(1 => "Ene", 2 => "Feb", 3 => "Mar", 4 => "Abr", 5 => "May", 6 => "Jun", 7 => "Jul", 8 => "Agt", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dic");
        $result_array[]=$this->resultado_lineas_siniestros_mes(date("d-m-Y",strtotime($today."-1 year")),$filtro["clientes"]);
        $result_array[]=$this->resultado_lineas_siniestros_mes($today,$filtro["clientes"]);
        return array("series" => $result_array, "options" => array("xaxis" => array("categories" => array($meses[(int)$mesactual]))));
    }


    function resultado_lineas_siniestros($nombre,$tipo,$año,$clientes){
        $array_data1=array();
        $array_data2=array();
        $data=$tipo=="1"?$this->CI->graficas->get_siniestros_per_Year($año,$clientes):$this->CI->graficas->get_siniestros_Liquidados($año,$clientes);
        for($i = 1; $i <= 12; $i++){
            $array_data1[$i]=0;
        }
        foreach($data as $key=>$data) {
            $array_data2[(int)$data["mes"]]=(int)$data["total"];
        }
        $result_array=array_replace_recursive($array_data1,$array_data2);
        return array("name" => $nombre, "data" => array_values($result_array));
    }

    function resultado_lineas_siniestros_mes($date,$clientes){
        $meses = array(1 => "Ene", 2 => "Feb", 3 => "Mar", 4 => "Abr", 5 => "May", 6 => "Jun", 7 => "Jul", 8 => "Agt", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dic");
        setlocale(LC_TIME, 'es_ES');
        $yearActual=date("Y",strtotime($date));
        $mesactual=date("n",strtotime($date));
        $dataActual=$this->CI->graficas->get_siniestros_per_MontAndYear($yearActual,$mesactual,$clientes);
        return array("name" =>$meses[(int)$mesactual]." ".$yearActual, "data" => array($dataActual!=[]?(int)$dataActual[0]["total"]:0));
    }

    //Funciones para las graficas de Daños y autos Individual
    public function getstatusAutosSiniestros($filtros = null,$tipo){
        $Año=isset($filtros["fecha"])?date("Y",strtotime($filtros["fecha"])):date("Y");
        $mes=isset($filtros["fecha"])?date("m",strtotime($filtros["fecha"])):date("m");
        $range=$this->CI->graficas->getAllestatusAutos($Año,$mes,$tipo);
        $evIncidencias = $this->CI->graficas->getConfigGrafica();
        $datos=array();

        $labels = array_map(function ($it) use ($range, &$datos) {
            $exist_incidencia = array_filter($range, function ($item) use ($it) {
                return in_array($item["tipo_incidencias_id"], $it["valor"]);
            });
            if (count($exist_incidencia) > 0) {
                    $tt = array_sum(array_map(function ($i) {
                        return $i["total"];
                    }, $exist_incidencia));
                    //var_dump($datos);
                    array_push($datos, $tt);
                } else {
                    array_push($datos, 0);
                }
                return $it["titulo"];
            }, $evIncidencias);
    
        $labels = array_values($labels);
        $data_render =array("series" => $datos, "labels" => $labels);
        return $data_render;
        //return $this->CI->graficos_estrutura->render($nombre_reporte,$filtros,$data_render);
    }

    public function getSiniestrosAutosAnos($filtros,$tipo){
        $Año=isset($filtros["fecha"])?date("Y",strtotime($filtros["fecha"])):date("Y");
        $meses = array(1 => "Ene", 2 => "Feb", 3 => "Mar", 4 => "Abr", 5 => "May", 6 => "Jun", 7 => "Jul", 8 => "Agt", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dic");
        $result_array=array();
        $result_array[]=$this->resultado_lineas_siniestros_2("Siniestro total por mes",$tipo,$Año);
        $result_array[]=$this->resultado_lineas_siniestros_2("Siniestro liquidados por mes",$tipo,$Año,'SI');
        //return array("series" => $result_array, "options" => array("xaxis" => array("categories" => array_values($meses))));
        return $data_render=array("series" => $result_array, "options" => array("xaxis" => array("categories" => array_values($meses))));
    }
    function resultado_lineas_siniestros_2($nombre,$tipo,$año,$liquidado=null){
        $array_data1=array();
        $array_data2=array();
        $data=$liquidado==null?$this->CI->graficas->get_siniestros_per_Year_2($año,$tipo):$this->CI->graficas->get_siniestros_per_Year_2($año,$tipo,"SI");
        for($i = 1; $i <= 12; $i++){
            $array_data1[$i]=0;
        }
        foreach($data as $key=>$data) {
            $array_data2[(int)$data["mes"]]=(int)$data["total"];
        }
        $result_array=array_replace_recursive($array_data1,$array_data2);
        return array("name" => $nombre, "data" => array_values($result_array));
    }

    function get_data_siniestros_comparacion_2($filtros,$tipo){
        setlocale(LC_TIME, 'es_ES');
        $result_array=array();
        $today=isset($filtros["fecha"])?date("d-m-Y",strtotime($filtros["fecha"])):date('d-m-Y');
        $mesactual=date("n",strtotime($today));
        $meses = array(1 => "Ene", 2 => "Feb", 3 => "Mar", 4 => "Abr", 5 => "May", 6 => "Jun", 7 => "Jul", 8 => "Agt", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dic");
        $result_array[]=$this->resultado_lineas_siniestros_mes_2(date("d-m-Y",strtotime($today."-1 year")),$tipo);
        $result_array[]=$this->resultado_lineas_siniestros_mes_2($today,$tipo);
        return $data_render=array("series" => $result_array, "options" => array("xaxis" => array("categories" => array($meses[(int)$mesactual]))));
        //return $this->CI->graficos_estrutura->render($nombre_reporte,$filtros,$data_render);
    }

    function resultado_lineas_siniestros_mes_2($date,$tipo){
        $meses = array(1 => "Ene", 2 => "Feb", 3 => "Mar", 4 => "Abr", 5 => "May", 6 => "Jun", 7 => "Jul", 8 => "Agt", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dic");
        setlocale(LC_TIME, 'es_ES');
        $yearActual=date("Y",strtotime($date));
        $mesactual=date("n",strtotime($date));
        $dataActual=$this->CI->graficas->get_siniestros_per_MontAndYear_2($yearActual,$mesactual,$tipo);
        return array("name" =>$meses[(int)$mesactual]." ".$yearActual, "data" => array($dataActual!=[]?(int)$dataActual[0]["total"]:0));
        //var_dump(array("name" =>$meses[(int)$mesactual]." ".$yearActual, "data" => array($dataActual!=[]?(int)$dataActual[0]["total"]:0)));
    }

    function getDatosTop_2($filtro,$tipo){
        $labels=array();
        $datos=array();
        $all=[];
        $año=date("Y",strtotime($filtro["fecha"]));
        $mes= date('m', strtotime($filtro["fecha"]));
        $consulta=$this->CI->graficas->grafica_siniestro_estados_2($mes,$año,$tipo);
        foreach ($consulta as $key => $value) {
            array_push($labels,$value["nombre"]);
            array_push($datos,$value["total"]);
        }
        
        /* $lol=array("series" => $datos, "labels" => $labels);
        var_dump($lol); */
        return $data_render=array("series" => $datos, "labels" => $labels);
        //return $this->CI->graficos_estrutura->render($nombre_reporte,$filtro,$data_render);
        //return array("series" => $series, "options" => array("xaxis" => array("categories" => array_values($labels))));
    }

    function getDatosRango($filtro,$tipo){
        $today=isset($filtro["fecha"])?date("Y",strtotime($filtro["fecha"])):date("Y");
        $consulta=$this->CI->graficas->get_rango_table_2($today,$tipo);
        unset($consulta[0]["Total"]);
        $datos=array_values($consulta[0]);
        $labels=array_keys($consulta[0]);
        return $data_render=array("series" => $datos, "labels" => $labels);
        //return $this->CI->graficos_estrutura->render($nombre_reporte,$filtro,$data_render);
    }

    //metodos para GMM
    function getstatusGMM($filtro,$tipo){
        $Año=isset($filtro["fecha"])?date("Y",strtotime($filtro["fecha"])):date("Y");
        $mes=isset($filtro["fecha"])?date("m",strtotime($filtro["fecha"])):date("m");
        $range=$this->CI->graficas->getAllStatusGMM($Año,$mes,$tipo);
        $evIncidencias = $this->CI->graficas->getConfigGrafica();
        $datos=array();

        $labels = array_map(function ($it) use ($range, &$datos) {
            $exist_incidencia = array_filter($range, function ($item) use ($it) {
                return in_array($item["tipo_incidencias_id"], $it["valor"]);
            });
            if (count($exist_incidencia) > 0) {
                    $tt = array_sum(array_map(function ($i) {
                        return $i["total"];
                    }, $exist_incidencia));
                    //var_dump($datos);
                    array_push($datos, $tt);
                } else {
                    array_push($datos, 0);
                }
                return $it["titulo"];
            }, $evIncidencias);
    
        $labels = array_values($labels);
        $data_render =array("series" => $datos, "labels" => $labels);
        return $data_render;
    }

    public function getSiniestrosGMMAnos($filtros,$tipo){
        $Año=isset($filtros["fecha"])?date("Y",strtotime($filtros["fecha"])):date("Y");
        $meses = array(1 => "Ene", 2 => "Feb", 3 => "Mar", 4 => "Abr", 5 => "May", 6 => "Jun", 7 => "Jul", 8 => "Agt", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dic");
        $result_array=array();
        $result_array[]=$this->resultado_lineas_siniestros_GMM("Total trámites por mes",$tipo,$Año);
        $result_array[]=$this->resultado_lineas_siniestros_GMM("Total trámites liquidados por mes",$tipo,$Año,'SI');
        //return array("series" => $result_array, "options" => array("xaxis" => array("categories" => array_values($meses))));
        return $data_render=array("series" => $result_array, "options" => array("xaxis" => array("categories" => array_values($meses))));
    }

    function resultado_lineas_siniestros_GMM($nombre,$tipo,$año,$liquidado=null){
        $array_data1=array();
        $array_data2=array();
        $data=$liquidado==null?$this->CI->graficas->get_siniestros_per_Year_GMM($año,$tipo):$this->CI->graficas->get_siniestros_per_Year_GMM($año,$tipo,"SI");
        for($i = 1; $i <= 12; $i++){
            $array_data1[$i]=0;
        }
        foreach($data as $key=>$data) {
            $array_data2[(int)$data["mes"]]=(int)$data["total"];
        }
        $result_array=array_replace_recursive($array_data1,$array_data2);
        return array("name" => $nombre, "data" => array_values($result_array));
    }

    function get_data_siniestros_comparacion_GMM($filtros,$tipo){
        setlocale(LC_TIME, 'es_ES');
        $result_array=array();
        $today=isset($filtros["fecha"])?date("d-m-Y",strtotime($filtros["fecha"])):date('d-m-Y');
        $mesactual=date("n",strtotime($today));
        $meses = array(1 => "Ene", 2 => "Feb", 3 => "Mar", 4 => "Abr", 5 => "May", 6 => "Jun", 7 => "Jul", 8 => "Agt", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dic");
        $result_array[]=$this->resultado_lineas_siniestros_mes_GMM(date("d-m-Y",strtotime($today."-1 year")),$tipo);
        $result_array[]=$this->resultado_lineas_siniestros_mes_GMM($today,$tipo);
        return $data_render=array("series" => $result_array, "options" => array("xaxis" => array("categories" => array($meses[(int)$mesactual]))));
        //return $this->CI->graficos_estrutura->render($nombre_reporte,$filtros,$data_render);
    }

    function resultado_lineas_siniestros_mes_GMM($date,$tipo){
        $meses = array(1 => "Ene", 2 => "Feb", 3 => "Mar", 4 => "Abr", 5 => "May", 6 => "Jun", 7 => "Jul", 8 => "Agt", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dic");
        setlocale(LC_TIME, 'es_ES');
        $yearActual=date("Y",strtotime($date));
        $mesactual=date("n",strtotime($date));
        $dataActual=$this->CI->graficas->get_siniestros_per_MontAndYear_Gmm($yearActual,$mesactual,$tipo);
        return array("name" =>$meses[(int)$mesactual]." ".$yearActual, "data" => array($dataActual!=[]?(int)$dataActual[0]["total"]:0));
        //var_dump(array("name" =>$meses[(int)$mesactual]." ".$yearActual, "data" => array($dataActual!=[]?(int)$dataActual[0]["total"]:0)));
    }

    function getDatosTop_GMM($filtro,$tipo){
        $labels=array();
        $datos=array();
        $all=[];
        $año=date("Y",strtotime($filtro["fecha"]));
        $mes= date('m', strtotime($filtro["fecha"]));
        $consulta=$this->CI->graficas->grafica_siniestro_estados_2($mes,$año,$tipo);
        foreach ($consulta as $key => $value) {
            array_push($labels,$value["nombre"]);
            array_push($datos,$value["total"]);
        }
        return $data_render=array("series" => $datos, "labels" => $labels);
    }

    function getDatosRangoGMM($filtro,$tipo){
        $today=isset($filtro["fecha"])?date("Y",strtotime($filtro["fecha"])):date("Y");
        $consulta=$this->CI->graficas->get_rango_table_GMM($today,$tipo);
        unset($consulta[0]["Total"]);
        $datos=array_values($consulta[0]);
        $labels=array_keys($consulta[0]);
        return $data_render=array("series" => $datos, "labels" => $labels);
        //return $this->CI->graficos_estrutura->render($nombre_reporte,$filtro,$data_render);
    }

}
