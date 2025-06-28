<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Siniestros extends TIC_Controller
{
    function __construct()
    {
        parent::__construct();
        //$this->load->helper('url');
        $this->load->model('siniestros_model', 'siniestros');
        $this->load->library('graficos');
        $this->load->library('phpmailer_lib');
        $this->load->model('evaluacion_periodos_model', 'periodo');
        $this->load->model('evaluaciones_model', 'evaluaciones');
        $this->load->model("personamodelo", "persona");

        $this->load->model('notificacionmodel', 'notificacion_model');

        $this->load->library('webservice');
        $this->load->model('servicios_model', 'servicios');
        $this->load->model('personamodelo', 'persona');
        $this->config->load('global', TRUE);
        $this->lang->load('tank_auth');

        $this->load->library('googledrive');
        $this->load->model("documentsmodel", "documento");
        $this->load->library('libreriav3'); //Dennis Castillo [2022-01-07]
        $this->load->model("graficas_model", "kpi"); //Dennis Castillo [2022-01-17]

        ///test
        $this->load->model('seguimiento_model', 'seguimiento');
    }

    function index()
    {
        if (!isset($_POST['isRequest'])) {
            $head = array('title' => 'Capsys - Siniestros');
            $data = array();
            //$lol=$this->session->flashdata('id');
            $notificacion = $this->session->flashdata('id');
            $notificacion_log = $this->session->flashdata('id_log_siniestro');
            if ($notificacion_log != false) {
                $row = $this->siniestros->getLogIdsiniestros($notificacion_log);
                $data['idNotificacion'] = $row[0]["json_data"];
            } else {
                $data['idNotificacion'] = "";
            }
            $footer = array();
            //$estados = array(array("id" => 6, "nombre" => "EN TRAMITE", "valores"=>0), array("id" => 7, "nombre" => "AVISADO", "valores"=>0), array("id" => 8, "nombre" => "CONDICIONADO", "valores"=>0), array("id" => 9, "nombre" => "LIQUIDADO", "valores"=>1), array("id" => 10, "nombre" => "SIN ESTATUS", "valores"=>0));
            $estados = $this->siniestros->getAllestatusT();
            //$estados=$this->siniestros->getAllestatus();
            $tipoS = $this->siniestros->tiposiniestro();
            $causaS = $this->siniestros->causasiniestro();
            $autoridad = $this->siniestros->autoridadPresente();
            $segun = $this->siniestros->segunAjyAs();
            $aseguradoras = $this->siniestros->getAseguradoras();
            $clientes = $this->siniestros->getClientes();
            $clientestabla = $this->servicios->getClientesEjecutivo($this->tank_auth->get_idPersona());
            $estados_e = $this->siniestros->getEstados();
            $municipios = array(array("id" => 0, "nombre" => "N/A", "id_padre" => 0));
            $fechaFin = true;

            //nuevos tramites
            $tram_autos = $this->siniestros->getTramitesAutos();
            $estatusReparacion = $this->siniestros->getLlenadoSelect('ERR');
            $data["tramites"] = $tram_autos;
            //docuemtnos de los tramites de los autos individuales
            $documentos = $this->siniestros->getDocuments();

            //Requisitos para las notas del siniestros //Dennis Castillo [2022-01-18]
            $data["notes"]["agentsToAssing"] = $this->libreriav3->agrupaPersonasParaSelect($this->persona->obtenerPersonas("SISTEMAS@ASESORESCAPITAL.COM", 3)); //array();//$tram_autos;

            $data['controlador'] = $this->router->routes;
            //var_dump($parse->PaquetePoliza->Descripcion);
            //opcion para mostar el menu lateral
            $data["tipo"] = "Siniestros";
            $actualyears = $this->siniestros->getYearsDocs();

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
                    'path' => 'gap/js/sweetalert.min.js'
                ),
                array(
                    'type' => 'JS',
                    'path' => 'js/fileupload/public/bundle-siniestros.js'
                ),
                array(
                    'type' => 'JS',
                    'path' => 'js/fileupload/public/bundle-modal-seguimiento.js'
                ),
                /* array(
                    'type' => 'JS',
                    'path' => 'js/fileupload/public/bundle-selectm.js'
                ), */
                array(
                    'type' => 'JSHTML',
                    'data' => "const _estatus = " . json_encode($estados) . "; const _siniestroT= " . json_encode($tipoS) . ";  const _causaS= " . json_encode($causaS) . "; const _autoridadS= " . json_encode($autoridad) . "; const _segunS= " . json_encode($segun) . ";"
                        . " const _Aseg= " . json_encode($aseguradoras) . ";" . "const _Cli= " . json_encode($clientes) . ";" . " const _estados=" . json_encode($estados_e) . ";" . "const _mun=" . json_encode($municipios) . ";" . "const _clienteT=" . json_encode($clientestabla) . ";" .
                        "const _FechaFin = " . json_encode($fechaFin) . ";" . "const _Documents = " . json_encode($documentos) . ";" . "const _TramAutos = " . json_encode($tram_autos) . ";" . "const _Estatus_Reparacion = " . json_encode($estatusReparacion) . ";" . "const _years = " . json_encode($actualyears) . ";"
                )

            ));
            //$this->render('siniestros/index', $head, $data, $footer);
            $this->render('siniestros/index_2', $head, $data, $footer);
            
        } else {
            $this->_postupload();
        }
    }

    function rango_dias()
    {
        $head = array('title' => 'Capsys - Siniestros');
        $data = array();
        //opcion para mostar el menu lateral
        $data["tipo"] = "Siniestros";
        $footer = array();

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
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/rangosSiniestros.js'
            )

        ));
        $this->render('siniestros/rangos', $head, $data, $footer);
    }

    public function getDataRangos($id)
    {
        $idpost = $this->input->post('Rango', true);
        $mensaje = "";
        $codigo = "";
        $data = array();
        switch ($id) {
            case 1:
                $data = $this->siniestros->get_rango();
                $mensaje = "Éxito";
                $codigo = "200";
                break;
            case 2:
                $compare = $this->siniestros->rango_getLastRow(0);
                if (intval($idpost) > intval($compare["rango"])) {
                    $data = $this->siniestros->get_rango();
                    $dataS = array("rango" => $idpost, "aseguradora_id" => 0);
                    $this->siniestros->rango_add($dataS);
                    $mensaje = "Éxito";
                    $codigo = "200";
                } else {
                    $data = [];
                    $mensaje = "Eror, el numero debe ser mayor al último ingresado en la tabla";
                    $codigo = "400";
                }
                break;
            case 3:
                $idD = $this->input->post('id', true);
                $result = $this->siniestros->rango_delete($idD);
                $data = $idD;
                $mensaje = "Éxito";
                $codigo = "200";
                break;
            default:
                # code...
                break;
        }
        $this->responseJSON($codigo, $mensaje, $data);
    }

    function Tablero()
    {
        $clientes = $this->servicios->getClientesEjecutivo($this->tank_auth->get_idPersona());
        $clientesDB = $this->map_clientes($clientes);
        $clientes_array = $this->getArrayClientes($clientes);
        $filtro = array(
            "fecha" => date('Y-m-d'),
            "periodo" => 0,
            "puesto" => 0,
            "empresa" => 0,
            "colaborador" => 0,
            "periodos" => 0,
            "fechaInicio" => date('Y-m-d'),
            "fechaFin" => date('Y-m-d'),
            "clientes" => $clientesDB
        );

        $head = array('title' => 'Capsys - Siniestros Reportes');
        $data = array();
        $footer = array();
        $hearders = $this->get_head_rango();
        $hearders1 = $this->get_head_range_generic("tabla1");
        $hearders3 = $this->get_head_range_generic("tabla3");

        $data["grafico1"] = $this->graficos->render("TEST", $filtro);
        $data["grafico2"] = $this->graficos->render("SINIESTROS_TODOS_LOS_MESES", $filtro);
        $data["grafico3"] = $this->graficos->render("SINIESTROS_COMPARACION_MESES", $filtro);
        $data["grafico4"] = $this->graficos->render("SINIESTROS_TOP_ESTADOS", $filtro);
        $data["grafico5"] = $this->graficos->render("CORTE_SINIESTROS", $filtro);
        $data["DataSiniestros"] = $this->siniestros->allsiniestros($clientesDB);
        $data["lastupdate"] = $this->siniestros->getlastUpdate($clientesDB);
        $data["clientes"] = $clientes;

        //opcion para mostar el menu lateral
        $data["tipo"] = "Siniestros";


        $this->breadcrumbs->push('', '');
        $this->breadcrumbs->unshift('Registro de siniestros', '/Siniestros/registros');
        $this->breadcrumbs->unshift('Tablero', '/Siniestros');
        $this->breadcrumbs->unshift('Inicio', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();

        //las nuevas graficas
        $data["tablaAutosmes"] = $this->siniestros->getReporteTableAutosC($clientes_array, date('Y'), date('m'));
        $data["tablaAutos"] = $this->siniestros->getReporteTableAutosC($clientes_array, date('Y'));


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
                'data' => "const _headers1 = " . json_encode($hearders1) . ";" . "const _headers = " . json_encode($hearders) . ";" . "const _headers3 = " . json_encode($hearders3) . ";"
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
                'path' => 'gap/js/reporteSiniestros.js'
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
                'data' => $data["grafico1"]["JS"]
            ),
            array(
                'type' => 'JSHTML',
                'data' => $data["grafico2"]["JS"]
            ),
            array(
                'type' => 'JSHTML',
                'data' => $data["grafico3"]["JS"]
            ),
            array(
                'type' => 'JSHTML',
                'data' => $data["grafico4"]["JS"]
            ),
            array(
                'type' => 'JSHTML',
                'data' => $data["grafico5"]["JS"]
            ),
        ));
        $this->render('siniestros/dashboard', $head, $data, $footer);
        /* if(!empty($this->servicios->getClientesEjecutivo($this->tank_auth->get_idPersona()))){
            $this->render('siniestros/dashboard', $head, $data, $footer);
        }else{
            redirect('/', 'refresh');
        } */
        //$this->render('siniestros/dashboard', $head, $data, $footer);
    }

    function getTable()
    {
        header('Content-Type: application/json');
        $tabla = array();
        $clientesDB = $this->servicios->getClientesEjecutivo($this->tank_auth->get_idPersona());
        $clientes = $this->map_clientes($clientesDB);
        $tabla["data"] = $this->siniestros->tablaSiniestros($clientes);
        $tabla["lastUpdt"] = $this->siniestros->getlastUpdate($clientes);
        //$tabla["clientes"]=$clientes;
        echo json_encode($this->response("200", "Exíto", $tabla));
        die;
    }

    function filterdates()
    {
        //header('Content-Type: application/json');
        date_default_timezone_set('America/Mexico_City');
        $today = date("Y-m-d H:i");
        $aseguradora = $this->input->post('aseguradora_id');
        $cliente = $this->input->post('cliente_id');
        $fechaI = $this->input->post('FechaI');
        $fechaF = $this->input->post('FechaF');
        $array_fechas = array(
            "FechaInicio" => $fechaI,
            "FechaFin" => $fechaF
        );
        $validate = $this->siniestros->validateServicio($aseguradora, $cliente, "RANGO", "SERVICIO");
        $validateUP = $this->siniestros->validateServicio($aseguradora, $cliente, "INDIVIDUAL", "SERVICIO");
        //var_dump($validate);
        //$datos2 = $this->datos_WS($validateUP);
        $datos2 = $this->webservice->datos_WS($validateUP, "INDIVIDUAL");
        if (!empty($validate)) {
            $datos = $this->webservice->datos_WS($validate, "RANGO", $array_fechas);
            /* $datos['conexion']->FechaInicio = $fechaI;
            $datos['conexion']->FechaFin = $fechaF; */
            $data = $this->webservice->consumoWS($datos, $aseguradora);
            //var_dump($data);
            $actualizados = 0;
            $Agregados = 0;
            if ($data['codigo'] != 400) {
                //actualizacion de los siniestros
                /* $siniestros_update = $this->siniestros->getAll_siniestros_Update();
                foreach ($siniestros_update as $registro) {
                    $datos2['conexion']->solicitud = $registro["cabina_id"];
                    $urlSingle='http://enterpriseservices.implementation.hdi.com.mx/B2B/Partners/REST/SiniestrosCabinaSrv/json/reply/ObtieneReporteRequest';
                    $datosUpd=array('Headers'=>array('username'=>'0684900001','password'=>'Pa55word'),'solicitud'=>$registro["cabina_id"],'Agente'=>'068490','Supervisor'=>'false','Oficina'=>'00497');
                    $responseUdp = $this->webservice->consumoWS($datos2["conexion"], $datos2["url"]);
                    $value = $this->validate_update($registro, $responseUdp["Data"][0]);
                    $actualizados = $actualizados + $value;
                } */
                //Agrega los nuevos siniestros en la fecha correspondiente seleccionada
                //array id_logs
                $array_log = [];
                foreach ($data["Data"] as $value) {
                    if (is_array($value)) {
                        $today = date("Y-m-d H:i");
                        if ($this->siniestros->find_id_siniestro($value["cabina_id"]) != TRUE) {
                            $array_log[] = $value["cabina_id"];
                            //$value+=['aseguradora_id'=>$aseguradora,'cliente_id'=>$cliente];
                            $value["aseguradora_id"] = $aseguradora;
                            $value["cliente_id"] = $cliente;
                            $value["agregado_por"] = $this->tank_auth->get_idPersona();
                            $value["agregado"] = $today;
                            $this->siniestros->insertSiniestro($value);
                            $Agregados++;
                        }
                    }
                }
            }
            if ($actualizados != 0 || $Agregados != 0) {
                $usuarios = $this->servicios->getUsersCliente($cliente);
                $format = array();
                //$jsondata=implode('|',$array_log);
                foreach ($usuarios as $key => $value) {
                    $this->sendNotificacionManual("SINIESTROS", array("idSeguimiento" => "15", "id_persona" => $value['id'], "Agregados" => $Agregados, "Actualizados" => $actualizados, "fecha" => $today, "referencia" => "15"));
                    $idnoty = $this->siniestros->returnLastidNoty();
                    $this->siniestros->insertLogNotificacion(array("id_notificacion" => $idnoty, "json_data" => implode('|', $array_log)));
                }
                $array_update = array("aseguradora_id" => $cliente, "fecha" => $today);
                $this->siniestros->insertUpdate($array_update);
            }
            //$result = array("actualizados" => $actualizados, "Agregados" => $Agregados);
            $this->responseJSON($data["codigo"], $data["codigo"] != 200 ? "Servicio no disponible" : "Exíto", $data["Data"]);
        } else {
            $this->responseJSON("400", "No se cuentan con los permisos", []);
        }
    }

    function postData()
    {
        //header('Content-Type: application/json');
        $Accion = $this->input->post('Accion');
        date_default_timezone_set('America/Mexico_City');
        $today = date("Y-m-d H:i");
        $data = json_decode($this->input->post('Data'), true);
        $dataU = array(
            'cabina_id' => $Accion == "Editar" ? $data["cabina_id"] : $this->siniestros->getidManual(),
            'ajustador_id' => $data["ajustador_id"],
            'ajustador_nombre' => $data["ajustador_nombre"],
            //''=>intval($data["estatusSiniesto"]),
            'siniestro_id' => $data["siniestro_id"],
            'poliza' => $data["poliza"],
            'certificado' => $data["certificado"],
            'asegurado_nombre' => $data["asegurado_nombre"],
            'estado_id' => intval($data["estado_id"]),
            'municipio_id' => intval($data["municipio_id"]),
            'declara_conductor' => $data["declara_conductor"],
            'evento' => $data["evento"],
            'sub_evento' => $data["sub_evento"],
            'atencion_lugar' => $data["atencion_lugar"],
            'autoridad_id' => intval($data["autoridad_id"]),
            'tipo_siniestro_id' => intval($data["tipo_siniestro_id"]),
            'causa_siniestro_id' => intval($data["causa_siniestro_id"]),
            'responsable_autoridad' => intval($data["responsable_autoridad"]),
            'responsable_ajustador' => intval($data["responsable_ajustador"]),
            'fecha_repote' => date("Y-m-d H:i", strtotime($data["fecha_repote"])),
            'fecha_ocurrencia' => date("Y-m-d H:i", strtotime($data["fecha_ocurrencia"])),
            'cita' => date("Y-m-d H:i", strtotime($data["cita"])),
            'inicio_ajuste' => date("Y-m-d H:i", strtotime($data["inicio_ajuste"])),
            'fin_ajuste' => date("Y-m-d H:i", strtotime($data["fin_ajuste"])),
            'paquete_descripcion' => $data["paquete_descripcion"],
            'paquete_poliza_id' => intval($data["paquete_poliza_id"]),
            'aseguradora_id' => $data["aseguradora_id"],
            'cliente_id' => $data["cliente_id"],
            'tipo_actualizacion' => 'MANUAL',
            'complemento_json' => json_encode(array(
                "Siniestro" => array(
                    "EstatusSiniestro" => $data["status_id"]
                )
            ))
        );
        if ($Accion == "Editar") {
            $dataU["modificado"] = intval($this->tank_auth->get_idPersona());
            $dataU["modificado_por"] = $today;
            $response_db = $this->return_array_db($data["cabina_id"]);
            $dataBit = array(
                'siniestro_id' => $data["cabina_id"],
                'informacion' => json_encode(array($response_db)),
                'modificado' => $today,
                'modificado_por' => $this->tank_auth->get_idPersona()
            );
            $this->siniestros->insert_siniestro_bitacora($dataBit);
            $result = $this->siniestros->updateSiniestro($data["id"], $dataU);
        } else {
            //'agregado_por'=>$data["agregado_por"],
            //'agregado'=>$data["agregado"],
            $dataU["agregado_por"] = intval($this->tank_auth->get_idPersona());
            $dataU["agregado"] = $today;
            $result = $this->siniestros->insertSiniestro($dataU);
        }
        $this->responseJSON("200", "Exíto", $result);
        //echo json_encode($this->response("200", "Exíto", $result));
        //die;
    }

    function update_SiniestroWS()
    {
        //header('Content-Type: application/json');
        $id = $this->input->post('id');
        $aseguradora = $this->input->post('aseguradora_id');
        $cliente = $this->input->post('cliente_id');
        $validacion = $this->siniestros->validateServicio($aseguradora, $cliente, "INDIVIDUAL", "SERVICIO");
        if (!empty($validacion)) {
            $datos = $this->datos_WS($validacion);
            $datos['conexion']->solicitud = $id;
            //$datos=array('Headers'=>array('username'=>'0684900001','password'=>'Pa55word'),'solicitud'=>$id,'Agente'=>'068490','Supervisor'=>'false','Oficina'=>'00497');
            //$url='http://enterpriseservices.implementation.hdi.com.mx/B2B/Partners/REST/SiniestrosCabinaSrv/json/reply/ObtieneReporteRequest';
            //$response=$this->consultaWS($datos,2);
            $response = $this->webservice->consumoWS($datos['conexion'], $datos['url']);
            //var_dump($response);
            $data = $this->siniestros->get_single_siniestro_all($id);
            $this->validate_update($data[0], $response["Data"][0]);
            $data = $this->siniestros->get_single_siniestro_all($id);
            $this->responseJSON($response['codigo'], "Exíto", $data);
            /* echo json_encode($this->response($response['codigo'], "Exíto", $data));
            die; */
        } else {
            $this->responseJSON("400", "No se cuentan con los permisos", []);
            /* echo json_encode($this->response("400", "No se cuentan con los permisos", []));
            die; */
        }
    }

    function get_bitacora()
    {
        //header('Content-Type: application/json');
        $id = $this->input->post('id');
        $data = $this->siniestros->get_siniestros_bitacora($id);
        $this->responseJSON("200", "Exíto", $data);
        /* echo json_encode($this->response("200", "Exíto", $data));
        die; */
    }

    function validate_update($registro, $response)
    {
        $diff = [];
        foreach ($response as $key => $value) {
            if (strval($registro[$key]) != strval($value)) {
                $diff[$key] = $value;
            }
        }
        date_default_timezone_set('America/Mexico_City');
        $today = date("Y-m-d H:i:s");
        if (!empty($diff)) {
            $siniestroAllData = $this->siniestros->get_single_siniestro_all($registro["cabina_id"]);
            $data = array(
                'siniestro_id' => $registro["cabina_id"],
                'informacion' => json_encode($siniestroAllData),
                'modificado' => $today,
                'modificado_por' => $this->tank_auth->get_idPersona(),
                'aseguradora_id' => 0
            );
            $diff["modificado_por"] = 0;
            $diff["modificado"] = $today;
            $this->siniestros->insert_siniestro_bitacora($data);
            $this->siniestros->updateSiniestroWS($registro["cabina_id"], $diff);
            return 1;
        } else {
            return 0;
        }
    }

    function return_array_db($id)
    {
        $result = $this->siniestros->getSingleSiniestro($id);
        $dataR = $result[0];
        unset($dataR['id'], $dataR['agregado'], $dataR['agregado_por'], $dataR['modificado'], $dataR['modificado_por']);
        return $dataR;
    }

    function resultado_lineas_siniestros($nombre)
    {
        $array_data1 = array();
        $array_data2 = array();
        $data = $this->siniestros->get_siniestros_per_Year();
        for ($i = 1; $i <= 12; $i++) {
            $array_data1[$i] = 0;
        }
        foreach ($data as $key => $data) {
            $array_data2[(int)$data["mes"]] = (int)$data["total"];
        }
        $result_array = array_replace_recursive($array_data1, $array_data2);
        return array("name" => $nombre, "type" => "line", "data" => array_values($result_array));
    }

    ///post tablas dashboard siniestros
    function tabla1_dasboard()
    {
        $clientes = $this->servicios->getClientesEjecutivo($this->tank_auth->get_idPersona());
        $clientesDB = $this->map_clientes($clientes);
        $today = date("Y");
        $tabla = array();
        $tabla["data"] = $this->siniestros->get_all_count_estatus($today, $clientesDB);
        $this->responseJSON("200", "Exíto", $tabla);
    }

    function tabla2_dasboard()
    {
        $clientes = $this->servicios->getClientesEjecutivo($this->tank_auth->get_idPersona());
        $clientesDB = $this->map_clientes($clientes);
        $tabla = array();
        $today = date("Y");
        $tabla["data"] = $this->siniestros->get_rango_table($today, $clientesDB);
        $this->responseJSON("200", "Exíto", $tabla);
    }
    function tabla3_dasboard()
    {
        $clientes = $this->servicios->getClientesEjecutivo($this->tank_auth->get_idPersona());
        $clientesDB = $this->map_clientes($clientes);
        $today = date("Y");
        $tabla = array();
        $tabla["data"] = $this->siniestros->table_estatus_meses($today, $clientesDB);
        $this->responseJSON("200", "Exíto", $tabla);
    }

    function get_head_rango()
    {
        $arrayRango = $this->siniestros->get_rango();
        $lastkey = end($arrayRango);
        $arrayreturn = array();
        $count = 0;
        foreach ($arrayRango as $key => $value) {
            if ($key == 0) {
                $count == 0 ? array_push($arrayreturn, array("title" => "DÍAS RESPUESTA", "data" => NULL, "defaultContent" => "TOTALES")) : array_push($arrayreturn, array("title" => "DÍAS RESPUESTA", "data" => NULL, "defaultContent" => "DIAS RESPUESTA"));
                array_push($arrayreturn, array("title" => "0-" . $value["rango"], "data" => "0-" . $value["rango"], "sClass" => "control text-center", "defaultContent" => "Sin contenido"));
            } elseif ($lastkey["id"] == $value["id"]) {
                array_push($arrayreturn, array("title" => ($arrayRango[$key - 1]["rango"] + 1) . "-" . $value["rango"], "data" => ($arrayRango[$key - 1]["rango"] + 1) . "-" . $value["rango"], "sClass" => "control text-center", "defaultContent" => "Sin contenido"));
                array_push($arrayreturn, array("title" => "Mas de " . $value["rango"], "data" => "Mas de " . $value["rango"], "sClass" => "control text-center", "defaultContent" => "Sin contenido"));
                array_push($arrayreturn, array("title" => "Total", "data" => "Total", "sClass" => "control text-center", "defaultContent" => "Sin contenido"));
            } else {
                array_push($arrayreturn, array("title" => ($arrayRango[$key - 1]["rango"] + 1) . "-" . $value["rango"], "data" => ($arrayRango[$key - 1]["rango"] + 1) . "-" . $value["rango"], "sClass" => "control text-center", "defaultContent" => "Sin contenido"));
            }
            $count++;
        }
        return $arrayreturn;
    }

    function get_head_range_generic($tipo)
    {
        $clientes = $this->servicios->getClientesEjecutivo($this->tank_auth->get_idPersona());
        $clientesDB = $this->map_clientes($clientes);
        $today = date("Y");
        $arrayR = array();
        switch ($tipo) {
            case 'SinData':
                array_push($arrayR, array("title" => "Sin información disponible", "data" => NULL, "defaultContent" => "Sin información disponible"));
                break;
            case 'tabla1':
                $data = $this->siniestros->get_all_count_estatus($today, $clientesDB);
                break;
            case 'tabla3':
                $data = $this->siniestros->table_estatus_meses($today, $clientesDB);
                break;
        }
        if (!empty($data)) {
            foreach ($data[0] as $key => $value) {
                if ($key == "CAUSA" || $key == "Estatus") {
                    array_push($arrayR, array("title" => $key, "data" => $key, "sClass" => "control", "defaultContent" => "Sin contenido"));
                } else {
                    array_push($arrayR, array("title" => $key, "data" => $key, "sClass" => "control text-center", "defaultContent" => "Sin contenido"));
                }
            }
        } else {
            $arrayR[] = array("title" => "Sin información disponible", "data" => NULL, "defaultContent" => "Sin información disponible");
        }
        return $arrayR;
    }

    function _postupload()
    {
        $configArray = $this->global["array_Excel"];
        header('Content-Type: application/json');
        date_default_timezone_set('UTC');
        $aseguradora = $this->input->post('aseguradora_id');
        $cliente = $this->input->post('cliente_id');

        if (!empty($this->siniestros->validateServicio($aseguradora, $cliente, "", "EXCEL"))) {
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
                echo json_encode($this->response("400", "El tipo de documento no es el correcto", null));
                die;
            }

            try {
                $objPHPExcel = PHPExcel_IOFactory::load($archivo);
            } catch (Exception $e) {
            }

            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();


            //$data = array();
            $rowConfig = array();
            $rowDataV = $sheet->rangeToArray(
                'A' . 5 . ':' . $highestColumn . 5
            );
            //echo count($rowDataV[0]);
            if (count($rowDataV[0]) <= 55 || count($rowDataV[0]) > 57) {
                echo json_encode($this->response("400", "El documento no tiene el numero de columnas necesarias", count($rowDataV[0])));
                die;
            }

            $test = array();

            for ($row = 2; $row <= $highestRow; $row++) {
                $rowData = $sheet->rangeToArray(
                    'A' . $row . ':' . $highestColumn . $row
                );
                foreach ($configArray as $key => $value) {
                    foreach ($value as $key2 => $value2) {
                        if ($key == "Siniestro" && $key2 == "EstatusSiniestro") {
                            if ($rowData[0][55] == "FINALIZADO" || $rowData[0][55] == "LIQUIDADO") {
                                $rowConfig[$key][$key2] = "LIQUIDADO";
                            } else {
                                $rowConfig[$key][$key2] = $rowData[0][$value2];
                            }
                        } else {
                            $rowConfig[$key][$key2] = $rowData[0][$value2];
                        }
                    }
                }
                $datadb = array("complemento_json" => json_encode($rowConfig), "siniestro_estatus" => $rowData[0][55], "fecha_fin" => null); //nuevo
                if ($rowData[0][55] == "FINALIZADO" || $rowData[0][55] == "LIQUIDADO") {
                    $datadb["fecha_fin"] = date('Y-m-d', strtotime($rowData[0][56]));
                    //$rowConfig["Siniestro"]["EstatusSiniestro"]="LIQUIDADO";
                }
                if (empty($this->siniestros->estatusValidacion($rowData[0][0]))) {
                    $this->siniestros->updateSiniestro_complement($rowData[0][0], $datadb);
                }

                //array_push($data,$rowConfig);
            }

            //alertas de los siniestros en caso de que esten escalados
            $usuarios = $this->servicios->getUsersCliente($cliente);
            foreach ($usuarios as $key => $value) {
                ///siniestros que son escalados
                $es_0 = $this->servicios->escalamiento($cliente, 'esc_0', $value['id']); ///escala 0
                $es_1 = $this->servicios->escalamiento($cliente, 'esc_1', $value['id']); ///escala 1
                $es_2 = $this->servicios->escalamiento($cliente, 'esc_2', $value['id']); ///escala 2
                $tabla = $this->tablacorreoE(array_merge($es_0, $es_1, $es_2));
                //$this->sendNotificacionManual("ALERTA", array("tabla" => $tabla, "usuario" => $value['id'], "referencia" => "20", "Tipo" => 1), array('web', 'email'));
            }
            $update = array(
                "aseguradora_id" => $cliente,
                "fecha" => date('Y-m-d H:i:s')
            );
            $this->siniestros->insertUpdate($update);

            echo json_encode($this->response("200", "Se cargo la información", $highestColumn));
            die;
        } else {
            echo json_encode($this->response("400", "No se tienen los permisos", []));
            die;
        }
    }

    function Seguimiento($tipo)
    {
        switch ($tipo) {
            case 1:
                $id = $this->input->post('id');
                $comentario = $this->input->post('comentario');
                $today = date("Y-m-d H:i:s");
                //$datosR = json_decode($this->input->post('Data'), true);
                $data = array(
                    "referencia" => "SINIESTRO",
                    "referencia_id" => $id,
                    "fecha" => $today,
                    "usuario_id" => $this->tank_auth->get_idPersona(),
                    "comentario" => $comentario
                );
                $this->siniestros->insertSeguimiento($data);
                $codigo = 200;
                $mensaje = "Éxito";
                $data = [];
                break;
            case 2:
                $id = $this->input->post('id');
                //$id=4937;
                $tramites = $this->siniestros->getTramites($id);
                $dataTram = [];
                foreach ($tramites as $key => $value) {
                    $dta = array(
                        "info" => $value,
                        "documentos" => $this->siniestros->getAllDocumentTramites($value['id'])
                    );
                    $dataTram[] = $dta;
                }
                $data = array(
                    "comentarios" => $this->siniestros->getSeguimiento($id),
                    "Tramites" => $dataTram
                    //"Tramites"=>$this->siniestros->getTramites($id)
                );
                $codigo = 200;
                $mensaje = "Éxito";
                $data = $data;
                break;

            default:
                break;
        }
        $this->responseJSON($codigo, $mensaje, $data);
    }

    function testarrays()
    {
        var_dump($this->siniestros->opcionCerrarSiniestro('2'));
        /* $fechaI = $this->input->post('FechaI');
        $fechaF = $this->input->post('FechaF');
        $aseguradora=1;$cliente=4;
        $validate = $this->siniestros->validateServicio($aseguradora, $cliente, "RANGO", "SERVICIO");
        $validateUP = $this->siniestros->validateServicio($aseguradora, $cliente, "INDIVIDUAL", "SERVICIO");
        $datos = $this->datos_WS($validate);
        $datos['conexion']->FechaInicio = "2021-01-02";
        $datos['conexion']->FechaFin = "2021-01-03";
        $data = $this->webservice->consumoWS($datos['conexion'], $datos['url']);
        var_dump($data); */
        //echo 'lol';
    }
    function imprimirPuestosHomonimos($datos)
    {
        $opciones = "";
        foreach ($datos as $key => $value) {
            $opciones .= '<optgroup label="' . $key . '">';
            foreach ($value as  $valuePP) {

                $opciones .= '<option value="' . $valuePP->idPuesto . '">' . $valuePP->personaPuesto . '</option>';
            }
            $opciones .= '</optgroup>';
        }
        return $opciones;
    }

    function algo($start = 0, $array)
    {
        $instancia = $array;
        if (count($instancia) >= 2) {
            if (intval($instancia[2]) > 0) {
                echo 'lol';
                return join('/', array_slice($instancia, $start, 1));
            } else {
                echo 'lol2';
                return join('/', array_slice($instancia, $start, 2));
            }
        } else {
            echo 'lol3';
            return join('/', array_slice($instancia, $start));
        }
    }

    function tablacorreoE($array)
    {
        $table = "";
        $tipo = "";
        foreach ($array as $key => $value) {
            if ($tipo != $value["tipo"]) {
                $tipo = $value["tipo"];
                $table = $table . "<tr style='background-color:#ffffff;color: #472380;'><th colspan='3'>$tipo</th></tr><tr style='background-color: #ccc;color: #472380;'><th>SINIESTRO</th><th>PARAMETRO</th><th>DÍAS TRANSCURRIDOS</th></tr>";
            }
            $table = $table . "<tr style='background-color: #f7f5fa;color: #472380;'><th>" . $value["cabina_id"] . "</th><th>" . $value["dias"] . "</th><th>" . $value["transcurrido"] . "</th></tr>";
        }
        $table = $table . " <tr style='background-color:#ffffff;color: #ffffff;'><th style='height: 10px;' colspan='3'></th></tr>";
        return $table;
    }

    function datos_WS($data)
    {
        $datosSQL = json_decode($data[0]["datos"]);
        return array("url" => $datosSQL->url, "conexion" => $datosSQL->objetojson);
    }

    function map_clientes($array)
    {
        $clientes = "(";
        $num = count($array);
        foreach ($array as $key => $value) {
            if ($num - 1 == $key) {
                $clientes = $clientes . $value["id"];
            } else {
                $clientes = $clientes . $value["id"] . ",";
            }
        }
        $clientes = $clientes . ")";
        return empty($array) ? "(0)" : $clientes;
    }

    function changeClient()
    {
        $data = array();
        $clint = $this->input->post('cliente');
        if ($clint == 0) {
            $clientesDB = $this->servicios->getClientesEjecutivo($this->tank_auth->get_idPersona());
            $clientes = $this->map_clientes($clientesDB);
        } else {
            $clientes = "(" . $clint . ")";
        }
        $filtros = array(
            "fecha" => date('Y-m-d'),
            "periodo" => 0,
            "puesto" => 0,
            "empresa" => 0,
            "colaborador" => 0,
            "periodos" => 0,
            "fechaInicio" => date('Y-m-d'),
            "fechaFin" => date('Y-m-d'),
            "clientes" => $clientes
        );
        $today = date("Y");
        $data["DataSiniestros"] = $this->siniestros->allsiniestros($clientes);
        $data["TEST"] = $this->graficos->getDatos($filtros, "SINIESTROS");
        $data["MESES"] = $this->graficos->get_data_siniestros($filtros, "", "SINIESTROS");
        $data["COMPARACION"] = $this->graficos->get_data_siniestros_comparacion($filtros, "", "SINIESTROS_MESES");
        $data["CORTE"] = $this->graficos->getDatosTop($filtros, "SINIESTROS_RANGO");
        $data["ESTADOS"] = $this->graficos->getDatosTop($filtros, "SINIESTROS_TOP");
        $data["Tabla1"] = $this->siniestros->get_all_count_estatus($today, $filtros["clientes"]);
        $data["Tabla2"] = $this->siniestros->get_rango_table($today, $filtros["clientes"]);
        $data["Tabla3"] = $this->siniestros->table_estatus_meses($today, $filtros["clientes"]);

        ///$data["lastupdate"]=$this->siniestros->getlastUpdate("0");

        $this->responseJSON("200", "Exíto", $data);
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

    function postExcel()
    {
        if (isset($_POST["filtro"])) {
            $this->session->set_flashdata('filtros', $this->input->post('filtro'));
            $this->responseJSON(200, "Exito", array("res" => $this->input->post('filtro')));
        }
    }

    function getExcel()
    {
        $dataIDS = $this->session->flashdata('filtros');
        if ($dataIDS != '') {
            date_default_timezone_set('America/Merida');
            $clientesDB = $this->servicios->getClientesEjecutivo($this->tank_auth->get_idPersona());
            $clientes = $this->map_clientes($clientesDB);
            $tabla = $this->siniestros->getExcel($clientes, $dataIDS);

            $contador = 2;
            $this->load->library('excel');
            $this->excel->setActiveSheetIndex(0);
            $this->excel->getActiveSheet()->setTitle('Siniestros');
            $this->excel->getActiveSheet()->setCellValue('A1', 'Registro de siniestros ' . date('Y-m-d H:s'));
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20)->setBold(true);
            $this->excel->getActiveSheet()->getDefaultColumnDimension()->setWidth(15);


            ///Headers de la tabla
            $headers = $tabla[0];
            $HC = 0;
            foreach ($headers as $key => $H) {
                if ($key == "complemento_json") {
                    $dta = json_decode($H, true);
                    foreach ($dta["general"] as $key2 => $value) {
                        $this->excel->getActiveSheet()->setCellValueByColumnAndRow($HC, $contador, $key2);
                        $column = PHPExcel_Cell::stringFromColumnIndex($HC);
                        $celda = $column . $contador;
                        $this->excel->getActiveSheet()->getStyle($celda)->getFont()->setSize(10)->setBold(true);
                        $this->excel->getActiveSheet()->getStyle($celda)->applyFromArray(
                            array(
                                'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => 'C8ACE8')
                                )
                            )
                        );
                        //$this->excle->getActiveSheet()->
                        $HC++;
                    }
                } else {
                    $this->excel->getActiveSheet()->setCellValueByColumnAndRow($HC, $contador, $key);
                    $column = PHPExcel_Cell::stringFromColumnIndex($HC);
                    $celda = $column . $contador;
                    $this->excel->getActiveSheet()->getStyle($celda)->getFont()->setSize(10)->setBold(true);
                    $this->excel->getActiveSheet()->getStyle($celda)->applyFromArray(
                        array(
                            'fill' => array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('rgb' => 'C8ACE8')
                            )
                        )
                    );
                    //$this->excle->getActiveSheet()->
                    $HC++;
                }
            }
            $HC = 0;
            $contador = 3;
            foreach ($tabla as $key => $ls) {
                $keysH = array_keys($ls);
                foreach ($keysH as $keys => $value) {
                    if ($value == "complemento_json") {
                        $dta = json_decode($ls[$value], true);
                        foreach ($dta["general"] as $key => $valuedta) {
                            $column = PHPExcel_Cell::stringFromColumnIndex($HC);
                            $celda = $column . $contador;
                            $this->excel->getActiveSheet()->setCellValueByColumnAndRow($HC, $contador, $valuedta == '' ? 'NA' : $valuedta);
                            $this->excel->getActiveSheet()->getStyle($celda)->applyFromArray(
                                array(
                                    'fill' => array(
                                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                        'color' => array('rgb' => 'EDE6F5')
                                    )
                                )
                            );
                            $HC++;
                        }
                    } elseif ($value == "json_tram") {
                        $dtatram = json_decode($ls[$value], true);
                        foreach ($dtatram as $key => $valuedta) {
                            $column = PHPExcel_Cell::stringFromColumnIndex($HC);
                            $celda = $column . $contador;
                            $this->excel->getActiveSheet()->setCellValueByColumnAndRow($HC, $contador, $valuedta == '' ? 'NA' : $valuedta);
                            $this->excel->getActiveSheet()->getStyle($celda)->applyFromArray(
                                array(
                                    'fill' => array(
                                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                        'color' => array('rgb' => 'EDE6F5')
                                    )
                                )
                            );
                            $HC++;
                        }
                    } else {
                        $column = PHPExcel_Cell::stringFromColumnIndex($HC);
                        $celda = $column . $contador;
                        $this->excel->getActiveSheet()->setCellValueByColumnAndRow($HC, $contador, $ls[$value] == '' ? 'NA' : $ls[$value]);
                        $this->excel->getActiveSheet()->getStyle($celda)->applyFromArray(
                            array(
                                'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => 'EDE6F5')
                                )
                            )
                        );
                        $HC++;
                    }
                }
                $HC = 0;
                $contador++;
            }
            //$this->excel->getActiveSheet()->mergeCells('A1:D1');           
            $filename = 'Siniestro_Registros' . date('Y-m-d') . '.xls';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0'); //no cache 
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');

            // Forzamos a la descarga         
            $objWriter->save('php://output');
            //echo 'phpExcel/nombredelfichero.xls';
        } else {
            $this->responseJSON(400, "No hay información de los siniestros", []);
        }
    }

    //nuevos metodos para la parte de la actualizacion del módulo
    function RegistroAutosC($id = null)
    {
        $head = array('title' => 'Capsys - AutosC');
        $data = array();
        $footer = array();
        $this->breadcrumbs->push('Siniestros Autos Coporativo', 'Bonos');
        $this->breadcrumbs->unshift('Autos corporativo', 'Siniestros/registros');
        $this->breadcrumbs->unshift('Inicio', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['titulo'] = $id == NULL ? 'Nuevo' : 'Editar';
        ///$data['registro']=$this->danos->getResgistroDanos($id);
        //$data['registro']=$this->autos->getSiniestroPoliza($id==null?0:$id);
        $data['registro'] = $this->siniestros->getSiniestro($id == null ? 0 : $id);
        $data['estados'] = $this->siniestros->getAllEstados();
        //Nueva parte
        $manual = 1;
        $causa_s = array();
        if ($manual) {
            $causa_s = $this->siniestros->getAllData('siniestro_causa');
            $data['estados'] = $this->siniestros->getEstadosN();
            $data['usuario'] = $this->tank_auth->get_usernamecomplete();
            $data['tipo_s'] = $this->siniestros->getAllData('siniestro_tipo');
            $data['ajustador'] = $this->siniestros->getAllDataWith(1, 'siniestro_segun_ajustador');
            $data['ajustador_tipo'] = $this->siniestros->getAllData('siniestro_segun_autoridad');
            $data['autoridad_t'] = $this->siniestros->getAllData('siniestro_tipoautoridad');
            //$data['cliente_siniestro']=$this->siniestros->getClientes();
            $data['cliente_siniestro'] = $this->siniestros->getClienteManual();
        }

        $data["Manual"] = $manual;

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ), array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            )
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _Causa = " . json_encode($causa_s) . ";"
            ),
        ));
        $this->render('siniestros/formulario_autos_c', $head, $data, $footer);
    }
    function ChangeEstatus()
    {
        $id = $this->input->post('id_siniestro');
        $id_estatus = $this->input->post('estatus');
        $fecha = $this->input->post('fecha_fin');
        //$tramite=$this->input->post('tramite');
        $obj = $this->siniestros->findStatus($id);
        $sNombre = $this->siniestros->findStatusNombre($id_estatus);
        //$objdes=json_decode($obj,true);
        //$objdes["Siniestro"]["EstatusSiniestro"]=$sNombre;
        $data = array(
            "siniestro_estatus" => $sNombre,
            //"complemento_json"=>json_encode($objdes),
            "status_id" => $id_estatus
        );
        $dataSegumiento = array(
            "referencia" => "AUTOS_C",
            "referencia_id" => $this->input->post('id_siniestro'),
            "fecha" => date("Y-m-d"),
            "usuario_id" => $this->tank_auth->get_idPersona(),
            "fecha_alta" => date("Y-m-d H:i:s"),
            "comentario" => $this->input->post('comentario'),
            "estatus_id" => $id_estatus,
            "causa_id" => 0
            //"tramite_id"=>$id
        );
        if ($this->siniestros->opcionCerrarSiniestro($id_estatus)) {
            $data['fecha_fin'] = $fecha != '' ? $fecha : date("Y-m-d");
        }
        $this->siniestros->updateAutos($id, $data);
        $this->siniestros->addSeguimiento($dataSegumiento);
        $this->responseJSON("200", "Se guardo con Éxito", $fecha);
    }

    function NuevoComentario()
    {
        $id_siniestro = $this->input->post('id_siniestro_c_t');
        $id_estatus = $this->input->post('id_esttram_c_t');
        $idtramite = $this->input->post('id_tramite_c_t');
        $tipo_tram = $this->input->post('id_tipotram_c_t');
        $dataSegumiento = array(
            "referencia" => "AUTOS_C",
            "referencia_id" => $id_siniestro,
            "fecha" => date("Y-m-d H:i:s"),
            "usuario_id" => $this->tank_auth->get_idPersona(),
            "fecha_alta" => date("Y-m-d H:i:s"),
            "comentario" => $this->input->post('comentario_s_t'),
            "estatus_id" => $id_estatus ? $id_estatus : null,
            "tramite_id" => $idtramite ? $idtramite : null,
            "causa_id" => $tipo_tram ? $tipo_tram : null
        );
        $this->siniestros->addSeguimiento($dataSegumiento);
        $data = array();
        $this->responseJSON("200", "Se guardo con Éxito", $data);
    }

    function getArrayClientes($array)
    {
        $rReturn = [];
        foreach ($array as $key => $value) {
            $rReturn[] = $value["id"];
        }
        return $rReturn;
    }

    ///nuevas funciones de los siniestros
    function GetpartialTramite()
    {
        $tipotramite = $this->input->post('tipotramite');
        $idtramite = $this->input->post('id_tramite');
        $id = $this->input->post('id_siniestro');
        ///LLENADO DE LOS SELECT
        $data = [];
        $data["Afectados"] = $this->siniestros->getLlenadoSelect('A');
        $data["Deducible"] = $this->siniestros->getLlenadoSelect('D');
        $data["Recuperacion"] = $this->siniestros->getLlenadoSelect('R');
        $data["EstatusPT"] = $this->siniestros->getLlenadoSelect('EP');
        $data["ResultadoEvaluacion"] = $this->siniestros->getLlenadoSelect('RE');
        $data["EstatusFinal"] = $this->siniestros->getLlenadoSelect('EFR');
        $data["EstatusReparacion"] = $this->siniestros->getLlenadoSelect('ERR');
        $data['data'] = $this->siniestros->getTramite($idtramite, $id);
        switch ($tipotramite) {
            case '1':
                $this->load->view('autos/tramite_detenidos_partial', $data);
                break;
            case '2':
                $this->load->view('autos/tramite_reparacion_partial', $data);
                break;
            case '3':
                $this->load->view('autos/tramite_pt_partial', $data);
                break;
        }
    }

    function postTramite()
    {
        $inserted_id = 0;
        $tipo_tramite = $this->input->post("tipo_tramite_select");
        $id_siniestro = $this->input->post("id_siniestro");
        $id_tramite = $this->input->post("id_tramite");
        $data = $this->input->post();
        $fecha_inicio = $this->input->post('fecha_inicio');
        unset($data["tipo_tramite_select"]);
        unset($data["id_siniestro"]);
        unset($data["id_tramite"]);
        unset($data["fecha_inicio"]);
        $comentario = $this->input->post('comentario');
        unset($data["comentario"]);
        $datadb = array(
            "id_siniestro" => $id_siniestro,
            "estatus" => 1,
            "tipo_tramite" => $tipo_tramite,
            "valores" => json_encode($data),
            "fecha_inicio" => $fecha_inicio,
            "subido_por" => $this->tank_auth->get_idPersona()
        );
       

        if ($id_tramite == 0) {
            //obtenemos el id del registro insertado
            $inserted_id = $this->siniestros->insertTramite($datadb);
            //actualizo el siniestro a activo
            $sNombre = $this->siniestros->findStatusNombre(1);
            //$objdes=[];
            //$objdes["Siniestro"]["EstatusSiniestro"]=$sNombre;
            $datareporte = array(
                "siniestro_estatus" => $sNombre,
                //"complemento_json"=>json_encode($objdes),
                "status_id" => 1,
                "ultimo_tramite"=>$inserted_id
            );
            $this->siniestros->updateAutos($id_siniestro, $datareporte);

            $this->NuevoComenatarioHandler($comentario, $id_siniestro, null, $inserted_id, $tipo_tramite);
        } else {
            $inserted_id = $id_tramite;
            $dataup = array(
                "fecha_inicio" => $fecha_inicio,
                "valores" => json_encode($data),
            );
            $this->siniestros->updateTramite($id_tramite, $dataup);
            $tipo_tramite = $this->siniestros->getTipoTramite($id_tramite);
            $this->NuevoComenatarioHandler($comentario, $id_siniestro, null, $id_tramite, $tipo_tramite["tipo_tramite"]);
        }

        $result = new \stdClass;
        $result->ok = true;
        //guardado de los documentos de los tramites
        if (!empty($_FILES)) {
            $keys = array_keys($_FILES);
            $finalRef = $this->createReferenciaFolder('AUTOSC_', '');
            $padre = $finalRef->getId();
            //$inset_id=12;
            $folder = $this->googledrive->createFolder('AUTOSC_' . $inserted_id, $padre);
            $count = 0;
            foreach ($_FILES as $file) {
                $uploadFile = $this->googledrive->createFiles($file, $keys[$count], 'documentación del registro', $folder->data->getId());
                $this->saveDoc($uploadFile->data, '', 'AUTOSC_', $inserted_id, []);
                $count++;
            }
            $result->ok = true;
        } //fin upload
        if ($result->ok === false) {
            $this->responseJSON("400", "Ocurrio un error al guardar la información", []);
        } else {
            $this->responseJSON("200", "Se guardo con Éxito", $data);
        }


        //$this->responseJSON("200", "Se guardo con Éxito", $data);
    }

    function ChangeEstatusTramite()
    {
        $id = $this->input->post('id_siniestro');
        $id_estatus = $this->input->post('estatus');
        $fecha = $this->input->post('fecha_fin');
        $idtramite = $this->input->post('id_tramite');
        $tipo_tram = $this->input->post('tipo_tram');
        //$tramite=$this->input->post('tramite');
        /*  $obj=$this->siniestros->findStatus($id);
        $sNombre=$this->siniestros->findStatusNombre($id_estatus);
        $objdes=json_decode($obj,true);
        $objdes["Siniestro"]["EstatusSiniestro"]=$sNombre; */
        $dataup = array(
            "estatus" => $id_estatus
        );

        $dataSegumiento = array(
            "referencia" => "AUTOS_C",
            "referencia_id" => $id,
            "fecha" => date("Y-m-d"),
            "usuario_id" => $this->tank_auth->get_idPersona(),
            "fecha_alta" => date("Y-m-d H:i:s"),
            "comentario" => $this->input->post('comentario'),
            "estatus_id" => $id_estatus,
            "tramite_id" => $idtramite,
            "causa_id" => $tipo_tram
            //"tramite_id"=>$id
        );
        if ($this->siniestros->opcionCerrarSiniestro($id_estatus)) {
            $dataup['fecha_fin'] = $fecha != '' ? $fecha : date("Y-m-d");
        }
        if ($id_estatus == 6) {
            $datalog = array(
                "fecha_inicio" => date("Y-m-d"),
                "estatus" => 6,
                "id_registro" => $idtramite,
                "id_siniestro" => $id
            );
            $this->siniestros->insertLogDormido($datalog);
        }
        if ($id_estatus != 6) {
            $datauplog = array(
                "fecha_fin" => date("Y-m-d")
            );
            $this->siniestros->updateTramitelog($idtramite, $datauplog);
        }
        //$this->siniestros->updateAutos($id,$data);
        $this->siniestros->updateTramite($idtramite, $dataup);
        $this->siniestros->addSeguimiento($dataSegumiento);
        $this->responseJSON("200", "Se guardo con Éxito", $fecha);
    }

    function Reingreso()
    {
        $tipo_tramite = $this->input->post("tipo_tramite_select");
        $id_siniestro = $this->input->post("id_siniestro");
        $id_tramite = $this->input->post("id_tramite");
        $data = $this->input->post();
        $fecha_inicio = $this->input->post('fecha_inicio');
        $comentario_bitacora = $this->input->post('comentario');
        unset($data["tipo_tramite_select"]);
        unset($data["id_siniestro"]);
        unset($data["id_tramite"]);
        unset($data["fecha_inicio"]);
        unset($data["comentario"]);
        $datadb = array(
            "id_siniestro" => $id_siniestro,
            "estatus" => 1,
            "tipo_tramite" => $tipo_tramite,
            "valores" => json_encode($data),
            "fecha_inicio" => $fecha_inicio,
            "subido_por" => $this->tank_auth->get_idPersona(),
            "reingreso" => 1,
            "fecha_agregado" => date("Y-m-d H:i:s"),
        );
        $id = "";
        if ($id_tramite == 0) {
            $id = $this->siniestros->insertTramite($datadb);
            $sNombre = $this->siniestros->findStatusNombre(1);
            //$objdes=[];
            $objdes["Siniestro"]["EstatusSiniestro"] = $sNombre;
            $datareporte = array(
                "siniestro_estatus" => $sNombre,
                //"complemento_json"=>json_encode($objdes),
                "status_id" => 1,
                "reingreso" => 'SI',
                "fecha_fin" => NULL
            );
            $this->siniestros->updateAutos($id_siniestro, $datareporte);
            //añadimos un log de reingreso ==estatus ->0 
            $datalog = array(
                "fecha_inicio" => date("Y-m-d"),
                "estatus" => 0,
                "id_registro" => $id,
                "id_siniestro" => $id_siniestro
            );
            $this->siniestros->insertLogDormido($datalog);
        } else {
            $dataup = array(
                "valores" => json_encode($data),
            );
            $this->siniestros->updateTramite($id_tramite, $dataup);
        }

        //guardamos la bitacora
        $dataSegumiento = array(
            "referencia" => "AUTOS_C",
            "referencia_id" => $id_siniestro,
            "fecha" => date("Y-m-d H:i:s"),
            "usuario_id" => $this->tank_auth->get_idPersona(),
            "fecha_alta" => date("Y-m-d H:i:s"),
            "comentario" => $comentario_bitacora,
            "estatus_id" => 1,
            "tramite_id" => $id,
            "causa_id" => $tipo_tramite
        );
        $this->siniestros->addSeguimiento($dataSegumiento);


        $this->responseJSON("200", "Se guardo con Éxito", $data);
    }

   function AccionesAutos()
    {
        $id = $this->input->post('id');
        $id_sin = $this->input->post('numero_siniestro');
        //$nombre=$this->input->post('nombre_a')." ".$this->input->post('apellido_p')." ".$this->input->post('apellido_m');
        $validateM = intval($this->input->post('validate'));
        $dataS = array(
            'complemento_json' => json_encode(
                array(
                    "cordinador" => array(
                        'nombre_coordinador' => $this->input->post('nombre_coordinador'),
                        'telefono_coordinador' => $this->input->post('telefono_coordinador'),
                        'correo_coordinador' => $this->input->post('correo_coordinador'),
                    ),
                    "general" => array(
                        'vehiculo' => $this->input->post('vehiculo'),
                        'serie' => $this->input->post('serie'),
                        'lugar' => $this->input->post('lugar'),
                        'afectado' => $this->input->post('afectado'),
                        'economico' => $this->input->post('economico'),
                        'modelo' => $this->input->post('modelo'),
                        'valor_unidad' => $this->input->post('valor_unidad'),
                        'deducible' => $this->input->post('deducible'),
                        'estatus_deducible' => $this->input->post('estatus_deducible'),
                        'tipo_recuperacion' => $this->input->post('tipo_recuperacion'),
                        'importe_reserva' => $this->input->post('importe_reserva'),
                        'inciso' => $this->input->post('inciso_p'),
                        'marca' => $this->input->post('marca'),
                        'ano' => $this->input->post('ano'),
                        'nuestro_asegurado' => $this->input->post('nuestro_asegurado')
                    )
                )
            )
        );

        //Nuevo metodo que permite agregar el siniestro
        if ($validateM) {
            $clintAse = $this->siniestros->getClienteAseguradoraC($this->input->post('cliente_siniestro'));
            $dataS['cabina_id'] = $this->input->post('num_cabina');
            //$dataS['ajustador_nombre']=$this->input->post('');
            $dataS['siniestro_id'] = $this->input->post('numero_siniestro');
            $dataS['poliza'] = $this->input->post('numero_poliza');
            $dataS['certificado'] = $this->input->post('Certificado');
            $dataS['paquete_descripcion'] = $this->input->post('Paquete');
            $dataS['asegurado_nombre'] = $this->input->post('nombres');
            $dataS['estado_id'] = $this->input->post('estado');
            $dataS['status_id'] = 1;
            $dataS['tipo_r'] = "S";
            $dataS['agregado_por'] = $this->tank_auth->get_idPersona();
            $dataS['siniestro_estatus'] = "ACTIVO";
            $dataS['causa_siniestro_id'] = $this->input->post('causa');
            $dataS['tipo_siniestro_id'] = $this->input->post('tipo_siniestro');
            //$dataS['declara_conductor']=$this->input->post('declaracion');
            $dataS['responsable_autoridad'] = $this->input->post('autoridad_presente');
            $dataS['responsable_ajustador'] = $this->input->post('tipo_ajustador');
            $dataS['autoridad_id'] = $this->input->post('tipo_autoridad');
            //$dataS['cliente_id']=$this->input->post('cliente_siniestro');
            //$dataS['aseguradora_id']=1;
            $dataS['inicio_ajuste'] = date("Y-m-d H:i", strtotime($this->input->post('fecha_aviso')));
            $dataS['fecha_repote'] = date("Y-m-d H:i", strtotime($this->input->post('fecha_aviso')));
            $dataS['fecha_ocurrencia'] = date("Y-m-d H:i", strtotime($this->input->post('fecha_ocurrencia')));
            $dataS['cita'] = date("Y-m-d H:i", strtotime($this->input->post('fecha_aviso')));
            $dataS['fin_ajuste'] = date("Y-m-d H:i", strtotime($this->input->post('fecha_aviso')));
            $dataS['manual'] = 1;
            $dataS['cliente_id'] = $clintAse[0]["cliente_id"];
            $dataS['aseguradora_id'] = $clintAse[0]["aseguradora_id"];
            $evento = $this->siniestros->getNameTipoCausaSiniestro($this->input->post('tipo_siniestro'), "siniestro_tipo");
            $causa = $this->siniestros->getNameTipoCausaSiniestro($this->input->post('causa'), "siniestro_causa");
            /* $dataS['evento']=$evento['nombre'];
            $dataS['sub_evento']=$causa['nombre']; */
            $dataS['evento'] = $causa['nombre'];
            $dataS['sub_evento'] = $evento['nombre'];

            //Nuevos cambios
            $dataS['id_sicas_cliente'] = $this->input->post('idsicascliente');
            $dataS['id_sicas_vendedor'] = $this->input->post('idsicasvendedor');

            $poliza = array(
                "poliza" => $this->input->post('numero_poliza'),
                "data_poliza" => $this->input->post('json_poliza')
            );
        }

        if ($id == 0) {
            if ($this->siniestros->find_id_siniestro($dataS["cabina_id"]) != TRUE) {
                $this->siniestros->insertSiniestro($dataS);
                if (!$this->siniestros->existPoliza($this->input->post('numero_poliza'))) {
                    $this->siniestros->insert_poliza($poliza);
                }
                $this->responseJSON('200', "Exito ", []);
            } else {
                $this->responseJSON('400', "ya existe un registro con el número de Cabina ", []);
            }
        } else {
            $this->siniestros->updateSiniestroN($id, $dataS);
            $this->responseJSON('200', "Exito", []);
        }
    }

    ///Subir los archivos al drive
    private function createReferenciaFolder($referencia, $referencia_id)
    {
        $finalReference = null;
        $folReferencia = null;
        $folReferenciaId = null;
        $exist_ref = $this->googledrive->searchfile(array("name" => $referencia));

        if (count($exist_ref->data) == 0) {
            $folReferencia = $this->googledrive->createFolder($referencia);

            if ($folReferencia->exito) {
                //$this->saveDoc($folReferencia->data, false, $referencia);
                $folReferencia = $folReferencia->data;
            } else {
                $this->responseJSON("400", $folReferencia->mensaje, null);
                die;
            }
        } else {
            $folReferencia = $exist_ref->data[0];
        }

        if (!empty($referencia_id)) {
            $exist_ref_id = $this->googledrive->searchfile(array("name" => $referencia_id, "parents" => $folReferencia->getId()));
            if (count($exist_ref_id->data) == 0) {
                $folReferenciaId = $this->googledrive->createFolder($referencia_id, $folReferencia->getId());
                if ($folReferenciaId->exito) {
                    //$this->saveDoc($folReferenciaId->data, false, $referencia, $referencia_id);
                    $folReferenciaId = $folReferenciaId->data;
                }
            } else {
                $folReferenciaId = $exist_ref_id->data[0];
            }
        }

        if ($folReferenciaId != null) {
            $finalReference = $folReferenciaId;
        } else {
            $finalReference = $folReferencia;
        }

        return $finalReference;
    }

    //Funcion para añadir los archvios a la DB
    private function saveDoc($file, $privado, $referencia, $referencia_id = 0, $puestos = [])
    {
        $data = array(
            'nombre' => basename($file->getName()), //
            'descripcion' => $file->getDescription(), //
            'ruta' => $file->getWebViewLink(), //
            'ruta_completa' => $file->getWebContentLink(), //
            'tipo' => $file->getMimeType(), //
            'nombre_completo' => $file->getName(), //
            'revision' => '0', //
            'referencia' => $referencia, //
            'referencia_id' => $referencia_id, //
            'usuario_alta_id' => $this->tank_auth->get_idPersona(), //
            'parent_id' => count($file->getParents()) > 0 ? $file->getParents()[0] : "",

            'file_id' => $file->getId(), //
            'tamanio' => $file->getSize(),
            'url_icono' => $file->getIconLink(),
            'url_descargar' => $file->getWebContentLink(),
            'thumbnail_link' => $file->getThumbnailLink(),
            'fecha_alta' => date("Y-m-d H:i:s"), //
            //'privado' => $privado == "true" ? 1 : 0,
            'estado' => 'ACTIVO' //
        );
        $result =  $this->documento->saveDocument($data);
    }


    function updateDocumentos()
    {
        $inset_id = $this->input->post('id');
        $result = new \stdClass;
        $result->ok = false;

        if (!empty($_FILES)) {
            $keys = array_keys($_FILES);
            $finalRef = $this->createReferenciaFolder('AUTOSI_', '');
            $padre = $finalRef->getId();
            //$inset_id=12;
            $folder = $this->googledrive->createFolder('AUTOSI_' . $inset_id, $padre);
            $count = 0;
            foreach ($_FILES as $file) {
                $uploadFile = $this->googledrive->createFiles($file, $keys[$count], 'documentación del registro', $folder->data->getId());
                $this->saveDoc($uploadFile->data, '', 'AUTOSI_', $inset_id, []);
                $count++;
            }
            $result->ok = true;
        } //fin upload
        if ($result->ok === false) {
            $this->responseJSON("400", "Ocurrio un error al guardar la información", []);
        } else {
            $this->responseJSON("200", "Se guardo con Éxito", []);
        }
    }

    function delete_documento()
    {
        $id_doc = $this->input->post('id_doc');
        $response = $this->googledrive->deleteFile($id_doc);
        $this->siniestros->delete_doc_drive($id_doc);
        $this->responseJSON("200", "Se realizó con Éxito", []);
    }

    //--------------------- //Dennis Castillo [2022-01-18]
    function manageNote()
    {

        $idNote = $_POST["id-note"];
        $response = array();

        if ($idNote > 0) {

            $response = $this->updateNote($_POST);
        } else {
            $response = $this->insertNote($_POST);
        }

        echo json_encode($response);
    }
    //-------------------- //Dennis Castillo [2022-01-18]
    function updateNote($data)
    {

        $batchArray = array();
        $updateNote = $this->siniestros->updateRecordSafely(
            "sininisterNotes", //Table
            array("id" => $data["id-note"]),  //Condition
            array( //Data
                "note" => $data["coment"],
                "dateUpdate" => date("Y-m-d H:i:s"),
            )
        );
        if ($updateNote["bool"]) {
            $deleteAssigneds = $this->siniestros->deleteNoteSafely("sinisterNotesAssigned", array("idNote" => $data["id-note"])); //First delete persons

            if ($deleteAssigneds) {

                if (!empty($data["person-selected"])) {

                    foreach ($data["person-selected"] as $dp) {
                        $batchArray[] = array("idPersona" => $dp, "idNote" => $data["id-note"]);
                    }

                    $insertBatch = $this->siniestros->insertMultipleRecordSafely("sinisterNotesAssigned", $batchArray); //Second re-insert persons

                    if ($insertBatch["bool"]) {
                        $this->sendNotification($batchArray, "ACTUALIZACION_NOTA_SINIESTRO");
                    }
                }
            }
        }

        return $updateNote;
    }
    //-------------------- //Dennis Castillo [2022-01-18]
    function insertNote($data)
    {

        $batchArray = array();
        $insertNote = $this->siniestros->insertRecordSafely(
            "sininisterNotes",
            array(
                "note" => $data["coment"],
                "dateCreate" => date("Y-m-d H:i:s"),
                "idSinister" => $data["id-row"],
                "creator" => $this->tank_auth->get_usermail(),
            )
        );

        if (!empty($data["person-selected"])) {

            foreach ($data["person-selected"] as $dp) {
                $batchArray[] = array("idPersona" => $dp, "idNote" => $insertNote["lastId"]);
            }

            $insertBatch = $this->siniestros->insertMultipleRecordSafely("sinisterNotesAssigned", $batchArray);

            if ($insertBatch["bool"]) {
                $this->sendNotification($batchArray, "NUEVA_NOTA_SINIESTRO");
            }
        }


        return $insertNote;
        //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($batchArray, TRUE));fclose($fp);
        //echo json_encode($insertNote);

    }
    //-------------------- //Dennis Castillo [2022-01-18]
    function getNotes()
    {

        $id = $_GET["id"];
        $getNotes = $this->siniestros->getNotes($id);
        $allDataNotes = $this->siniestros->getAllDataNote($id);
        $response = array();

        foreach ($allDataNotes as $dn) {

            $response[$dn->id]["note"] = $dn->note;
            $response[$dn->id]["sinister"] = $dn->idSinister;
            $response[$dn->id]["policy"] = $dn->poliza;
            $response[$dn->id]["numberSinister"] = $dn->siniestro_id;
            $response[$dn->id]["sinister"] = $dn->idSinister;
            $response[$dn->id]["typesinister"] = $dn->tipo_r;
            $response[$dn->id]["insure"] = $dn->asegurado_nombre;
            $response[$dn->id]["creator"] = $dn->creator;
            $response[$dn->id]["dateCreate"] = $dn->dateCreate;
            $response[$dn->id]["persons"][] = array(
                "idPerson" => $dn->idPersona,
                "name" => $dn->nombres . " " . $dn->apellidoPaterno . " " . $dn->apellidoMaterno,
                "email" => $dn->email,
            );
        }

        //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($response, TRUE));fclose($fp);
        echo json_encode($response);
    }
    //-------------------- //Dennis Castillo [2022-01-18]
    function deleteNote()
    {

        $id = $_POST["id"];
        $response["bool"] = false;
        $response["message"] = "Hubo un detalle con la eliminación. Favor de contactar al departamento de sistemas.";

        $deleteNote = $this->siniestros->deleteNoteSafely("sininisterNotes", array("id" => $id));

        if ($deleteNote) {
            $deleteAssigneds = $this->siniestros->deleteNoteSafely("sinisterNotesAssigned", array("idNote" => $id));
            $response["bool"] = true;
            $response["message"] = "Registro eliminado con éxito";
        }

        echo json_encode($response);
    }
    //--------------------- //Dennis Castillo [2022-01-18]
    function getNote()
    {

        $id = $_GET["id"];
        $getNote = $this->siniestros->getNote($id);

        echo json_encode($getNote);
    }
    //--------------------- //Dennis Castillo [2022-01-18]
    function sendNotification($array, $label)
    {

        $forwhoisthismessage = array();

        if (!empty($array)) {
            foreach ($array as $da) {

                $getEmail = $this->persona->obtenerEmail($da["idPersona"]);

                $object = new stdClass();
                $object->idPersona = $da["idPersona"];
                $object->email = $getEmail->email;
                array_push($forwhoisthismessage, $object);
            }
        }
        //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($forwhoisthismessage, TRUE));fclose($fp);
        $this->notificacion->add($forwhoisthismessage, "email", "ENVIADO", $label, "NOTA_SINIESTRO", array("evaluacion_id" => $array[0]["idNote"]));
    }
    //------------------------- //Dennis Castillo [2022-01-18]
    function getMyNotes()
    {

        //$notesForType = $this->getNotesForType($_GET["tipo"]);
        $head = array();
        $footer = array();
        $notesForType = $this->getNotesFiltered($_GET["tipo"]);
        $myNotes = array();

        if (!empty($notesForType)) {

            foreach ($notesForType as $dn) {
                $myNotes[date("d-m-Y", strtotime($dn->dateCreate))][] = $dn;
            }
        }

        $data["tipo"] = "Siniestros"; //$this->returntipo($_GET["tipo"]);
        $data["notes"] = $myNotes;
        //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($data, TRUE));fclose($fp);
        $this->render('siniestros/claimsnotescorporate', $head, $data, $footer);
        //$this->load->view("siniestros/claimsnotes", $data);
    }
    //------------------------- //Dennis Castillo [2022-01-18]
    function getNotesFiltered($type_r)
    {

        $response = $this->siniestros->getAllDataNote(null); ///$this->getNotesForType($type_r);
        $perId = $this->tank_auth->get_idPersona();
        $filter = array_filter($response, function ($arr) use ($type_r, $perId) {

            return $arr->tipo_r == $type_r && $arr->idPersona == $perId;
        });

        return array_values($filter);
    }
    //------------------------- //Dennis Castillo [2022-01-18]
    function editNoteOfSinister($controller, $idNote)
    {

        $head = array();
        $footer = array();
        $notes = array();
        $getNotes = $this->siniestros->getAllDataNote(null); //$this->getNotesForType($controller);
        $dataFiltered =  array_filter($getNotes, function ($arr) use ($controller, $idNote) {

            return $arr->tipo_r == $controller && $arr->id == $idNote;
        });

        foreach ($dataFiltered as $dn) {

            $notes["sinister"] = $dn->idSinister;
            $notes["id"] = $dn->id;
            $notes["coment"] = $dn->note;
            $notes["clientPolicy"] = $dn->asegurado_nombre;
            $notes["numberpolicy"] = $dn->siniestro_id;
            $notes["sinisterTypeChild"] = $dn->tipo_siniestro_nombre;
            $notes["numberSinister"] = $dn->poliza;
            $notes["assigned"][] = $dn->idPersona;
        }

        $data["tipo"] = $controller;
        $data["info"] = $notes;
        $data["notes"]["agentsToAssing"] = $this->libreriav3->agrupaPersonasParaSelect($this->persona->obtenerPersonas("SISTEMAS@ASESORESCAPITAL.COM", 3)); //array();//$tram_autos;
        //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($data, TRUE));fclose($fp);
        $this->render('siniestros/editNoteOfSinister', $head, $data, $footer);
    }
    //------------------------- //Dennis Castillo [2022-01-18]
    function getKpi()
    {

        $year = $_GET["year"];
        $getKPI = $this->kpi->getKPI_Siniestros("AUTOSC", null, $year, $this->tank_auth->get_idPersona());

        echo json_encode($getKPI);
    }

    //---------------------///Miguel Avila Actualizacion [2022-05-18]
    function NuevoComenatarioHandler($comentario, $id_siniestro, $id_estatus, $idtramite, $tipo_tram)
    {
        if ($comentario != null && $comentario != '') {
            //$id_siniestro = $this->input->post('id_siniestro_c_t');
            $dataSegumiento = array(
                "referencia" => "AUTOS_C",
                "referencia_id" => $id_siniestro,
                "fecha" => date("Y-m-d H:i:s"),
                "usuario_id" => $this->tank_auth->get_idPersona(),
                "fecha_alta" => date("Y-m-d H:i:s"),
                "comentario" => $comentario,
                "estatus_id" => $id_estatus ? $id_estatus : null,
                "tramite_id" => $idtramite ? $idtramite : null,
                "causa_id" => $tipo_tram ? $tipo_tram : null
            );
            $this->siniestros->addSeguimiento($dataSegumiento);
        }
    }
    //---------------------
    function checkid()
    {
        $tipo = $this->input->post('tipo');
        $id = $this->input->post('id');
        $result = $this->siniestros->validateid($tipo, $id);
        $this->responseJSON('200', "Exito", ["result" => empty($result) ? true : false]);
    }
    //---------------------///Miguel Avila Actualizacion [2022-06-26]
    public function updateCampoTramite(){
       /*  $clientes = $this->servicios->getClientesEjecutivo($this->tank_auth->get_idPersona());
        $clientesDB = $this->map_clientes($clientes);
        //var_dump($$clientesDB);
        $tbl=$this->siniestros->tablaSiniestros($clientesDB);
        foreach ($tbl as $key => $value) {
           $tramite=$this->siniestros->getTramiteNuevo($value["id"]);
           $this->siniestros->updateNewCampo($value["id"],array("ultimo_tramite"=>$tramite["tramite"]));
           echo "El tramite es ".$tramite["tramite"]. ' <br/>';
        } */
        //$this->responseJSON("200", "Exíto", $tbl);
    }

    public function getTablaDT()
    {
        $dataGet= $this->input->get();
        $data=$this->siniestros->getDatatable($dataGet);
        echo json_encode($data);
        //$this->responseJSON("200", "Exíto", $data);
    }

    public function testDatafull()
    {
        $dataGet= $this->input->get();
        $clientes = $this->servicios->getClientesEjecutivo($this->tank_auth->get_idPersona());
        $clientesNewarray=$this->mapClientesNew($clientes);
        $data=$this->siniestros->getTablaSiniestrosNew($dataGet,$clientesNewarray);
        //$data=$this->siniestros->getTablaSiniestrosNew2($dataGet);
        echo json_encode($data);
        //$this->responseJSON("200", "Exíto", $data);
    }

    
    function mapClientesNew($clientes)
    {
        $array=[];
        $array[]=0;
        foreach ($clientes as $key => $value) {
            $array[]=$value["id"];
        }
        return $array;
    }


}
