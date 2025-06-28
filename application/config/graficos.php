<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['reporte'] = array(
    array(
        "template" => "tableros/reporte_bar",
        "filter" => array("fecha", "puesto", "colaborador"),
        "action" => "",
        "filter_default" => array("periodo:1"),
        "function" => "INCIDENCIAS_MENSUALES",
        "type"  => "pie",
        "title" => "INCIDENCIAS MENSUALES",
        "id" => "INCIDENCIAS_MENSUALES"
    ),
    array(
        "template" => "tableros/reporte_bar",
        "filter" => array("fecha", "puesto", "colaborador"),
        "action" => "",
        "filter_default" => array("periodo:3"),
        "function" => "INCIDENCIAS_TRIMESTRAL",
        "type"  => "pie",
        "title" => "INCIDENCIAS TRIMESTRAL",
        "id" => "INCIDENCIAS_TRIMESTRAL"
    ),
    array(
        "template" => "tableros/reporte_bar",
        "filter" => array("fecha", "puesto","colaborador"),
        "action" => "",
        "filter_default" => array("colaborador:"),
        "multiple" => true,
        "function" => "COMPARATIVO_COLABORADORES",
        "type"  => "line",
        "title" => "COMPARATIVO DE COLABORADORES",
        "id" => "COMPARATIVO_COLABORADORES"
    ),
    array(
        "template" => "tableros/reporte_bar",
        "filter" => array("rango", "puesto"),
        "action" => "",
        "filter_default" => array("colaborador:"),
        "function" => "ROTACION_PERSONAL",
        "type"  => "bar",
        "title" => "ROTACION DE PERSONAL",
        "id" => "ROTACION_PERSONAL"
    ),
    array(
        "template" => "tableros/reporte_bar",
        "filter" => array("empresa", "periodos"),
        "action" => "",
        "filter_default" => array("periodos"),
        "function" => "CRECIMIENTO_PERIODO",
        "type"  => "bar",
        "title" => "CRECIMIENTO PERIODO",
        "id" => "CRECIMIENTO_PERIODO"
    ),
    array(
        "template" => "tableros/reporte_bar",
        "filter" => array("empresa", "puesto", "colaborador"),
        "action" => "",
        "filter_default" => array("periodos"),
        "function" => "EVALUACIONES_COMPETENCIAS",
        "type"  => "bar",
        "title" => "EVALUACIONES COMPETENCIAS",
        "id" => "EVALUACIONES_COMPETENCIAS"
    ),
    array(
        "template" => "tableros/reporte_bar",
        "filter" => array("empresa","periodos"),
        "action" =>"",
        "filter_default" => array("periodos"),
        "function" => "EVALUACIONES_DESEMPENIO",
        "type"  => "bar",
        "title" => "EVALUACIONES DE DESEMPEÑO",
        "id" => "EVALUACIONES_DESEMPENIO"
    ),
    array(
        "template" => "tableros/reporte_bar",
        "filter" => array("empresa"),
        "action" => "",
        "filter_default" => array("periodo:1"),
        "function" => "INCIDENCIAS_MENSUALES",
        "type"  => "pie",
        "title" => "ESTATUS DE TODOS LOS SINIESTROS",
        "id" => "TEST"
    ),
    array(
        "template" => "tableros/reporte_bar",
        "filter" => array("empresa,fecha"),
        "action" => "",
        "filter_default" => array("periodo:1"),
        "function" => "INCIDENCIAS_MENSUALES",
        "type"  => "line",
        "title" => "SINIESTROS POR CADA MES DEL AÑO ACTUAL",
        "id" => "SINIESTROS_TODOS_LOS_MESES"
    ),
    array(
        "template" => "tableros/reporte_bar",
        "filter" => array("empresa,fecha"),
        "action" => "",
        "filter_default" => array("periodo:1"),
        "function" => "INCIDENCIAS_MENSUALES",
        "type"  => "bar",
        "title" => "COMPARACIÓN ENTRE MESES IGUALES",
        "id" => "SINIESTROS_COMPARACION_MESES"
    ),
    array(
        "template" => "tableros/reporte_bar",
        "filter" => array("empresa,fecha"),
        "action" => "",
        "filter_default" => array("periodo:1"),
        "function" => "",
        "type"  => "pie",
        "title" => "TOP 5 DE ESTADOS CON MAS SINIESTROS",
        "id" => "SINIESTROS_TOP_ESTADOS"
    ),
    array(
        "template" => "tableros/reporte_bar2.php",
        "filter" => array("empresa"),
        "action" => "",
        "filter_default" => array("periodo:1"),
        "function" => "",
        "type"  => "pie",
        "title" => "RANGO DE DIAS DE RESPUESTA",
        "id" => "CORTE_SINIESTROS"
    ),
    array(
        "template" => "tableros/reporte_bar.php",
        "filter" => array("fecha"),
        "action" => "",
        "filter_default" => array(),
        "function" => "SINIESTROS_AUTOS_TOTAL",
        "type"  => "pie",
        "año"=>true,
        "mes"=>true,
        "title" => "SINIESTRO AUTOS INDIVIDUAL",
        "id" => "SINIESTROS_AUTOS_TOTAL"
    ),
    array(
        "template" => "tableros/reporte_bar.php",
        "filter" => array("fecha"),
        "action" => "",
        "filter_default" => array(),
        "function" => "",
        "type"  => "line",
        "año"=>true,
        "title" => "SINIESTRO AUTOS INDIVIDUAL AÑO",
        "id" => "SINIESTROS_AUTOS_ANO_ACTUAL"
    ),
    array(
        "template" => "tableros/reporte_bar.php",
        "filter" => array("fecha"),
        "action" => "",
        "filter_default" => array(),
        "function" => "",
        "type"  => "bar",
        "title" => "SINIESTROS AUTOS INDIVIDUAL-COMPARACIÓN",
        "id" => "SINIESTROS_AUTOS_COMPARACION"
    ),
    array(
        "template" => "tableros/reporte_bar.php",
        "filter" => array("fecha"),
        "action" => "",
        "filter_default" => array(),
        "function" => "",
        "type"  => "pie",
        "mes"=>true,
        "año"=>true,
        "title" => "TOP 5 ESTADOS SINIESTROS AUTOS INDIVIDUAL",
        "id" => "SINIESTROS_TOP_ESTADOS_AUTOS"
    ),
    array(
        "template" => "tableros/reporte_bar2.php",
        "filter" => array(),
        "action" => "SINIESTROS_RANGO_AUTOS",
        "filter_default" => array(),
        "function" => "",
        "type"  => "pie",
        "title" => "SINIESTRO AUTOS-RANGOS DIAS",
        "id" => "SINIESTROS_RANGO_AUTOS"
    ),
    //DAÑOS
    array(
        "template" => "tableros/reporte_bar.php",
        "filter" => array("fecha"),
        "action" => "SINIESTROS_DANOS_TOTAL",
        "filter_default" => array(""),
        "function" => "",
        "type"  => "pie",
        "año"=>true,
        "mes"=>true,
        "title" => "SINIESTRO DAÑOS",
        "id" => "SINIESTROS_DANOS_TOTAL"
    ),
    array(
        "template" => "tableros/reporte_bar.php",
        "filter" => array("fecha"),
        "action" => "",
        "filter_default" => array(),
        "function" => "",
        "type"  => "line",
        "año"=>true,
        "title" => "SINIESTRO DAÑOS AÑO",
        "id" => "SINIESTROS_DANOS_ANO_ACTUAL"
    ),
    array(
        "template" => "tableros/reporte_bar.php",
        "filter" => array("fecha"),
        "action" => "",
        "filter_default" => array(),
        "function" => "",
        "type"  => "bar",
        "title" => "SINIESTROS DAÑOS-COMPARACIÓN MESES",
        "id" => "SINIESTROS_DANOS_COMPARACION"
    ),
    array(
        "template" => "tableros/reporte_bar.php",
        "filter" => array("fecha"),
        "action" => "",
        "filter_default" => array(),
        "function" => "",
        "type"  => "pie",
        "mes"=>true,
        "año"=>true,
        "title" => "TOP 5 ESTADOS SINIESTROS-DAÑOS",
        "id" => "SINIESTROS_TOP_ESTADOS_DANOS"
    ),
    array(
        "template" => "tableros/reporte_bar2.php",
        "filter" => array(),
        "action" => "SINIESTROS_RANGO_DANOS",
        "filter_default" => array(),
        "function" => "",
        "type"  => "pie",
        "title" => "SINIESTRO DAÑOS-RANGOS DIAS",
        "id" => "SINIESTROS_RANGO_DANOS"
    ),
    ///SINiestrso de tipo GMM
    array(
        "template" => "tableros/reporte_bar.php",
        "filter" => array("fecha"),
        "action" => "SINIESTROS_GMM",
        "filter_default" => array(),
        "function" => "",
        "type"  => "pie",
        "año"=>true,
        "mes"=>true,
        "title" => "TRAMITES GMM",
        "id" => "SINIESTROS_GMM"
    ),
    array(
        "template" => "tableros/reporte_bar.php",
        "filter" => array("fecha"),
        "action" => "",
        "filter_default" => array(),
        "function" => "",
        "type"  => "line",
        "año"=>true,
        "title" => "TRÁMITES GMM DEL AÑO",
        "id" => "SINIESTROS_GMM_ANO_ACTUAL"
    ),
    array(
        "template" => "tableros/reporte_bar.php",
        "filter" => array("fecha"),
        "action" => "",
        "filter_default" => array(),
        "function" => "",
        "type"  => "bar",
        "title" => "SINIESTROS GMM-COMPARACIÓN MESES",
        "id" => "SINIESTROS_GMM_COMPARACION"
    ),
    array(
        "template" => "tableros/reporte_bar.php",
        "filter" => array("fecha"),
        "action" => "",
        "filter_default" => array(),
        "function" => "",
        "type"  => "pie",
        "mes"=>true,
        "año"=>true,
        "title" => "TOP 5 DE ESTADOS SINIESTROS-GMM",
        "id" => "SINIESTROS_TOP_ESTADOS_GMM"
    ),
    array(
        "template" => "tableros/reporte_bar2.php",
        "filter" => array(),
        "action" => "SINIESTROS_RANGO_GMM",
        "filter_default" => array(),
        "function" => "",
        "type"  => "pie",
        "title" => "TRÀMITES GMM-RANGOS DIAS",
        "id" => "SINIESTROS_RANGO_GMM"
    )
);
