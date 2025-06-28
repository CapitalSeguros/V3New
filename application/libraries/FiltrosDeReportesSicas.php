<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
class FiltrosDeReportesSicas {

    function __construct(){
        //parent::__construct();
    }

    //---------------------------------------
    function obtenerFiltro($reporte = "", $recibos_por, $estatus){

        //Institucional.
        $filtro["institucional"] = array(
            "filtroDespacho" => array(3), 
            "excepcionDespacho" => 1,
            "filtroRamo" =>  array(5,6), 
            "excepcionRamos" => 1,
            "filtroGrupo" => array(12),
            "excepcionGrupo" => 1,
            "filtroGerencia" => array(9), 
            "excepcionCanales" => 0,
            "filtroVendedor" => array(),
            "excepcionVendedor" => 0
        );
        $filtro["merida"]=array(
            "filtroDespacho" => array(3), 
            "excepcionDespacho" => 1,
            "filtroRamo" =>  array(5,6), 
            "excepcionRamos" => 1,
            "filtroGrupo" => array(),
            "excepcionGrupo" => 0,
            "filtroGerencia" => array(9), 
            "excepcionCanales" => 1,
            "filtroVendedor" => array(7),
            "excepcionVendedor" => 1
        );

        $filtro["cancun"]=array(
            "filtroDespacho" => array(3), 
            "excepcionDespacho" => 0,
            "filtroRamo" =>  array(5,6), 
            "excepcionRamos" => 1,
            "filtroGrupo" => array(),
            "excepcionGrupo" => 0,
            "filtroGerencia" => array(9), 
            "excepcionCanales" => 1,
            "filtroVendedor" => array(7),
            "excepcionVendedor" => 1
        );

        $filtro["fianzas"]=array(
            "filtroDespacho" => array(), 
            "excepcionDespacho" => 0,
            "filtroRamo" =>  array(5), 
            "excepcionRamos" => 0,
            "filtroGrupo" => array(12),
            "excepcionGrupo" => 1,
            "filtroGerencia" => array(), 
            "excepcionCanales" => 0,
            "filtroVendedor" => array(),
            "excepcionVendedor" => 0
        );

        $rr = $recibos_por == 1 ? "FechaDocumento" : "FechaLimite";

        $tipo_reporte = $this->devuelveReporte($rr, $estatus);

        $filtro_completo = array_merge($filtro[$reporte], $tipo_reporte);

        return $filtro_completo; //$filtro[$reporte];
    }
    //---------------------------------------------------
    function devuelveReporte($r, $t_r){

        $tt = array();

        switch($t_r){
            case 0: array_push($tt,0);
            break;
            case 3: array_push($tt,3,4);
            break;
        }

        $reporte["FechaDocumento"] = array("filtroStatus" => $tt, "tipoFecha" => "FDocto");
        $reporte["FechaLimite"] = array("filtroStatus" => $tt, "tipoFecha" => "FLimPago");

        return $reporte[$r];
    }

//-------------Fin de la clase-------------------
}
?>