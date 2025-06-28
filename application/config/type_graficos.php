<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

$config['tipo_grafica'] = array(
    
    "bar" => array(
        "chart" => array(
            "type" => "bar",
        ),
        "title" => array(
            "text" => "Prueba de bajas del año 2019 en forma de barras",
            "align" => "center",
            "style" => array(
                "color" => "#007bff"
            )
        ),
        "tooltip" => array (
            "enabled" => true,
            "offsetY" => -35,            
        ),
        "colors" => array(
            "blue","red","purple"
        )
    )
    ,

    "line" => array(
        "chart" => array(
            "type" => "line",
        ),
        "stroke" => array(
            "curve" => "straight"
        ),
        "title" => array(
            "text" => "Prueba de bajas del año 2019 en forma de lineas",
            "align" => "left",
            "style" => array(
                "color" => "#007bff"
            )          
        ),
        "colors" => "green",
        "tooltip" => array(
            "enabled" => true
        )
    )
    ,

    "pie" => array(
        "chart" => array(
            "type" => "pie"
        ),
        "colors" => array("red","blue","orange"), //dependiendo de la serie        
        "title" => array(
            "text" => "prueba de bajas del año 2019 en forma circular",
            "align" => "center"
        ),
        "tooltip" => array(
            "enabled" => true
        )
    )
)
?>
