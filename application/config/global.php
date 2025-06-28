<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
defined('DIR_APP')       or define('DIR_APP',  '/V3/');
$config["incidencia"] = array(
    "FALTAS INJUSTIFICADAS" => 5,
    "ENDRADA/SALIDA" => 6,
    "RETARDOS" =>  4
);

$config["minDayVacation"] = 1; //Meses
$config["startBlock"] = "12-01"; //MM-DD
$config["daysBlock"] = 40;

$config["tiempo"] = array(
    "1" => "Mensual",
    "2" => "Bimestral",
    "3" => "Trimestral",
    "6" => "Semestral",
    "12" => "Anual"
);

$config["contacts"] = array(
    "default" => array(
        "to" => array(),
        "from" => "",
        "subject" => "",
        "cc" => array()
    ),
    "ANTES_VACACIONES" => array(
        "to" => array(),
        "from" => "",
        "subject" => "",
        "cc" => array(),
        "bcc" => array()
    )
);

$config["notificationes"] = array(
    array(
        "clave" => "ANTES_VACACIONES",
        "titulo" => "Antes de vacaciones",
        "tipo" => array("web", "email"),
        "categoria" => "INCIDENCIAS",
        "plantilla" => "_templates/vacaciones",
        "function" => "before_vacaciones",
        "dias_previos"  => 7
    ),
    array(
        "clave" => "DISPONIBLE_EVALUACION",
        "titulo" => "Evaluación disponible",
        "tipo" => array("web", "email"),
        "categoria" => "EVALUACION",
        "plantilla" => "_templates/evaluaciones",
        "function" => "disponibilidad_evaluacion"
    ),
    array(
        "clave" => "ANTES_EVALUACION",
        "titulo" => "Antes de aplciar evaluación",
        "tipo" => array("web", "email"),
        "categoria" => "EVALUACION",
        "plantilla" => "_templates/antes_evaluaciones",
        "function" => "antes_evaluacion"
    ),
    array(
        "clave" => "ANTES_EVALUACION_CIERRE",
        "titulo" => "Antes de cerrar evaluación",
        "tipo" => array("web", "email"),
        "categoria" => "EVALUACION",
        "plantilla" => "_templates/antes_evaluaciones_cierre",
        "function" => "antes_evaluacion_cierre"
    ),
    array(
        "clave" => "INCIDENCIA",
        "titulo" => "Incidencias en general",
        "tipo" => array("web", "email"),
        "categoria" => "INCIDENCIAS",
        "plantilla" => "_templates/incidencias",
        "function" => "incidencia"
    ),
    array(
        "clave" => "INCIDENCIA_ACTIVA",
        "titulo" => "Se ha subido una nueva incidencia",
        "tipo" => array("web", "email"),
        "categoria" => "INCIDENCIAS",
        "plantilla" => "_templates/incidencias",
        "function" => "incidencia2"
    ),
    array(
        "clave" => "INCIDENCIA_APROBADA",
        "titulo" => "La incidencia ha sido aceptada",
        "tipo" => array("web", "email"),
        "categoria" => "INCIDENCIAS",
        "plantilla" => "_templates/incidencias",
        "function" => "incidencia2"
    ),
    array(
        "clave" => "INCIDENCIA_RECHAZADA",
        "titulo" => "La incidencia ha sido rechazada",
        "tipo" => array("web", "email"),
        "categoria" => "INCIDENCIAS",
        "plantilla" => "_templates/incidencias",
        "function" => "incidencia2"
    ), array(
        "clave" => "BONO_PENDIENTE",
        "titulo" => "Bono subido para revición",
        "tipo" => array("web", "email"),
        "categoria" => "BONOS",
        "plantilla" => "_templates/bonos_pendiente",
        "function" => "bonos"
    ), array(
        "clave" => "BONO_AUTORIZADO",
        "titulo" => "Bono autorizado",
        "tipo" => array("web", "email"),
        "categoria" => "BONOS",
        "plantilla" => "_templates/bonos_pendiente",
        "function" => "bonos"
    ), array(
        "clave" => "BONO_RECHAZADO",
        "titulo" => "Bono rechazado",
        "tipo" => array("web", "email"),
        "categoria" => "BONOS",
        "plantilla" => "_templates/bonos_pendiente",
        "function" => "bonos"
    ), array(
        "clave" => "BONO_REPLICA",
        "titulo" => "Bono replicado",
        "tipo" => array("web", "email"),
        "categoria" => "BONOS",
        "plantilla" => "_templates/bonos_pendiente",
        "function" => "bonos"
    ), array(
        "clave" => "PERIODO_LIBERADO",
        "titulo" => "Periodo liberado de evaluaciones",
        "tipo" => array("web", "email"),
        "categoria" => "PERIODOS",
        "plantilla" => "_templates/Liberar_Periodo",
        "function" => "Periodos_liberar"
    ), array(
        "clave" => "PERIODO_POR_EMPEZAR",
        "titulo" => "Días para empezar el período de evaluaciones",
        "tipo" => array("web", "email"),
        "categoria" => "PERIODOS",
        "plantilla" => "_templates/bonos_pendiente",
        "function" => "Periodos_liberar"
    ), array(
        "clave" => "PERIODO_POR_TERMINAR",
        "titulo" => "Dias para concluir el período de evaluaciones",
        "tipo" => array("web", "email"),
        "categoria" => "PERIODOS",
        "plantilla" => "_templates/bonos_pendiente",
        "function" => "Periodos_liberar"
    ),array(
        "clave" => "SINIESTROS",
        "titulo" => "Actualización del módulo de siniestros",
        "tipo" => array("web", "email"),
        "categoria" => "SINIESTROS",
        "plantilla" => "_templates/siniestros",
        "function" => "siniestros"
    ),
    array(
        "clave" => "ALERTA",
        "titulo" => "Alerta de los siniestros que pasan los dias estandarizados",
        "tipo" => array(),
        "categoria" => "ALERTA",
        "plantilla" => "_templates/alerta",
        "function" => "alerta"
    ),
    array(
        "clave" => "EVALUACION",
        "titulo" => "Alerta de las evaluaciones pendientes",
        "tipo" => array("web","email"),
        "categoria" => "EVALUACION",
        "plantilla" => "_templates/evaluaciones",
        "function" => "alerta_evaluacion"
    ),
    array(
        "clave" => "COMPARTIR",
        "titulo" => "Compartir documento",
        "tipo" => array("web","email"),
        "categoria" => "ARCHIVO",
        "plantilla" => "_templates/compartir",
        "function" => "alerta_compartir"
    ),
    array(
        "clave" => "PIP",
        "titulo" => "PIP ACTIVO",
        "tipo" => array("web","email"),
        "categoria" => "PIP",
        "plantilla" => "_templates/pip",
        "function" => "alerta_pip"
    )


);

$config["evaluacion_tipo"] = array(
    "Funciones" => 1,
    "Incidencias" => 2,
    "Competencias" => 3,
    "360" => 4,
    "Otra"=>5
);

$menu = array(
    "dashboard" => array(
        "title" => "Tablero",
        "href" => DIR_APP . "incidencias/grafica",
        "icon" => "fa-eval"
    ),
    "periodos" => array(
        "title" => "Periodos",
        "href" => DIR_APP . "periodo",
        "icon" => "fa-eval"
    ),

    "incidencias" => array(
        "title" => "Incidencias",
        "href" => DIR_APP . "incidencias",
        "icon" => "fa-eval"
    ),
    "baja_catalogo" => array(
        "title" => "Catalogos",
        "child" => array(
            array(
                "title" => "Tipo de baja",
                "href" => DIR_APP . "personas/baja"
            ),
            array(
                "title" => "Tipo de incidencias",
                "href" => DIR_APP . "incidencias/tipoIncidencia"
            ),
            array(
                "title" => "Preguntas",
                "href" => DIR_APP . "Preguntas"
            ),
            array(
                "title" => "Competencias",
                "href" => DIR_APP . "Competencias"
            ),
            array(
                "title" => "Evaluaciones",
                "href" => DIR_APP . "evaluaciones/"
            ),
            array(
                "title" => "Tabulador de bonos",
                "href" => DIR_APP . "TabuladorBonos"
            ),
            array(
                "title" => "Bonos",
                "href" => DIR_APP . "Bonos"
            ),
            
        ),
        "href" => DIR_APP . "#",
        "icon" => "fa-eval"
    ),
);


$config["evaluacion_incidencias"] = array(
    "puntualidad" => array(
        "titulo" => "Puntualidad",
        "subtitulo" => "Días checados fuera de horario",
        "valor" => array(4),
        "clave" => "puntualidad"
    ),
    "asistencia" => array(
        "titulo" => "Asistencia",
        "subtitulo" => "Faltas justificadas e injustificadas",
        "valor" => array(5),
        "clave" => "asistencia"
    ),
    "incapacidad" => array(
        "titulo" => "Incapacidades",
        "subtitulo" => "Incapacidades presentadas",
        "valor" => array(8),
        "clave" => "incapacidades"
    ),
    "permisos" => array(
        "titulo" => "Permisos",
        "subtitulo" => "Total de permisos solicitados",
        "valor" => array(2, 3),
        "clave" => "permisos"
    ),
    "no_entrada_salida" => array(
        "titulo" => "No checo entrada y/o salida",
        "subtitulo" => "Días no checados",
        "valor" => array(6),
        "clave" => "no checo entrada y salida"
    )

);
/* 
$config["evaluacion_siniestros"] = array(
    "Abierto" => array(
        "titulo" => "ABIERTO",
        "subtitulo" => "Siniestros abiertos",
        "valor" => array(1),
        "clave" => "ABIERTO"
    ),
    "EdicionAjustador" => array(
        "titulo" => "EDICIÓN POR AJUSTADOR",
        "subtitulo" => "Edicion por ajustador",
        "valor" => array(2),
        "clave" => "EdicionAjustador"
    ),
    "cerradoAjustador" => array(
        "titulo" => "CERRADO POR AJUSTADOR",
        "subtitulo" => "Siniestros cerrados por ajustador",
        "valor" => array(3),
        "clave" => "cerradoajustador"
    ),
    "cerradoCabina" => array(
        "titulo" => "CERRADO POR CABINA",
        "subtitulo" => "Siniestros cerrados por cabina",
        "valor" => array(4),
        "clave" => "cerradocabina"
    ),
    "cancelado" => array(
        "titulo" => "CANCELADO",
        "subtitulo" => "Siniestros cancelados",
        "valor" => array(5),
        "clave" => "cancelado"
    ),
); */
$config["evaluacion_siniestros"] = array(
    "EN TRÁMITE" => array(
        "titulo" => "En trámite",
        "subtitulo" => "En trámite",
        "valor" => array(1),
        "clave" => "En trámite"
    ),
    "AVISADO" => array(
        "titulo" => "Avisado",
        "subtitulo" => "Avisado",
        "valor" => array(2),
        "clave" => "Avisado"
    ),
    "CONDICIONADO" => array(
        "titulo" => "Condicionado",
        "subtitulo" => "Condicionado",
        "valor" => array(3,6),
        "clave" => "cerradoajustador"
    ),
    "LIQUIDADO" => array(
        "titulo" => "Liquidado",
        "subtitulo" => "Liquidado",
        "valor" => array(4,7),
        "clave" => "Liquidado"
    ),
    "SIN ESTATUS" => array(
        "titulo" => "Sin estatus",
        "subtitulo" => "Sin estatus",
        "valor" => array(5),
        "clave" => "Sin estatus"
    ),
);

$config["array_Excel"]=array(
    "Siniestro"=>array(
        "EstatusSiniestro"=>3,
        "FechaTermino"=>22,
        "FechaPromesa"=>21,
        "FechaEntrega"=>23,
    ),
    "Vehiculo"=>array(
        "Marca"=>8,
        "Version"=>9,
        "Año"=>10,
        "Color"=>26,
        "Placas"=>27,
        "Motor"=>28,
        "#serie"=>29,
    ),
    "Reserva"=>array(
        "ReservaRT"=>32,
        "ReservaGM"=>34,
        "ReservaRT"=>33,
        "EstimacionInicial"=>35,
        "Pagos"=>36,
        "Gastos"=>37,
        "AplicaDedicible"=>38,
        "Dedicible"=>39,
        "Salvamento"=>40,
        "ReservaPendiente"=>52
    ),
    "Expediente"=>array(
        "Investigacion"=>41,
        "ProcesoLegal"=>42,
        "SIPAC"=>43,
        "NoExpediente"=>54
    ),
    "Valuacion"=>array(
        "Taller"=>45,
        "DireccionTaller"=>46,
        "TelTaller"=>47,
        "TipoValuacion"=>48,
        "FechaValuacion"=>49,
        "MontoRefaccion"=>51
    )
);


$config["puestos_360"] = array(
    8
);
$config['notification_table']               = "notificacion";
$config['notification_read_tracking_table'] = "persona_notificacion";
