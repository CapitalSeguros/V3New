<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Serviciosws extends TIC_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('servicios_model', 'servicios');
        $this->load->model("personamodelo", "persona");
        $this->load->model('siniestros_model', 'siniestros');
    }

    function servicioAseguradoras(){
        $head = array('title' => 'Capsys - Siniestros');
        $data = array();
        //opcion para mostar el menu lateral
        $data["tipo"]="Siniestros";
        $footer = array();
        $aseguradoras=$this->servicios->getAseguradoras();
        $clientes=$this->servicios->getClientesExplicit();

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
                'path' => 'js/fileupload/public/bundle-aseguradoraws.js'
            ),
            array(
                'type' => 'JSHTML',
                'data' => "const _aseguradoras = " . json_encode($aseguradoras) . ";". "const _cliente = " . json_encode($clientes) . ";"
            )
            
        ));
        $this->render('servicios/aseguradoras', $head, $data, $footer);
    }
    function servicioClientes(){
        $head = array('title' => 'Capsys - Siniestros');
        $data = array();
        //opcion para mostar el menu lateral
        $data["tipo"]="Siniestros";
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
        ));
        $this->render('servicios/clientes', $head, $data, $footer);
    }

    //vista de ejecutivo-cliente
    function ejecutivo_cliente(){
        $head = array('title' => 'Capsys - Cliente-Ejecutivo');
        $data = array();
        //opcion para mostar el menu lateral
        $data["tipo"]="Siniestros";
        $footer = array();
        $clientes=$this->servicios->getClientesExplicit();
        $empleados = $this->servicios->getEmpleados();
        $_puestos=$this->getPuestos();
        $tiposCLiente=$this->servicios->getTiposCLientes();

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
                'path' => 'js/fileupload/public/bundle-cliente-ejecutivo.js'
            ),
            array(
                'type' => 'JSHTML',
                'data' => "const _puestos = " . json_encode($_puestos) . ";"."const _cliente = " . json_encode($clientes) . ";". "const _usuarios = " . json_encode($empleados) . ";"."const _Tipos = " . json_encode($tiposCLiente) . ";"
            )
            
        ));
        $this->render('servicios/ejecutivo_cliente', $head, $data, $footer);
    }

    function Notificacionespodias(){
        $head = array('title' => 'Capsys - Alertas');
        $data = array();
        //opcion para mostar el menu lateral
        //$data["tipo"]="Siniestros";
        $tipo=$this->input->get('tipo');
        $data["tipo"] = $this->returntipo($tipo);
        $footer = array();
        $clientes=$this->servicios->getClientesExplicit();
        $empleados = $this->servicios->getEmpleadosExplicit();
        $empleadosA = $this->servicios->getEmpleados();
        $tiposCausa=$this->servicios->getIndcadoresSubtipo();
        $tipos=$this->servicios->getTIpos();
        $subtipos=$this->servicios->getSubtipos();
        $gmm=$this->servicios->getTableNombre('siniestro_tramite_gmm');
        $danos=$this->servicios->getTableNombre('siniestro_tramite_danos');
        $_puestos=$this->getPuestos();


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
                'path' => 'js/fileupload/public/bundle-cliente-ejecutivo.js'
            ),
            array(
                'type' => 'JSHTML',
                'data' => "const _cliente = " . json_encode($clientes) . ";". "const _usuarios = " . json_encode($empleados) . ";". "const _Causa = " . json_encode($tiposCausa) . ";"
                . "const _SubtIpos = " . json_encode($subtipos) . ";". "const _Tipos = " . json_encode($tipos) . ";". "const _GMM = " . json_encode($gmm) . ";"
                . "const _Danos = " . json_encode($danos) . ";"."const _puestos = " . json_encode($_puestos) . ";"."const _Empleados = " . json_encode($empleadosA) . ";"
            )
            
        ));
        $this->render('servicios/notificaciones', $head, $data, $footer);
    }

    function Indicadores(){
        $head = array('title' => 'Capsys - Indicadores');
        $data = array();
        //opcion para mostar el menu lateral
        //$data["tipo"]="Siniestros";
        $tipo=$this->input->get('tipo');
        $data["tipo"] = $this->returntipo($tipo);
        $footer = array();
        $clientes=$this->servicios->getClientesExplicit();
        $tiposCausa=$this->siniestros->tiposiniestro();

        $tipos=$this->servicios->getTIpos();
        $subtipos=$this->servicios->getSubtipos();
        $gmm=$this->servicios->getTableNombre('siniestro_tramite_gmm');
        //$danos=$this->servicios->getTableNombre('siniestro_tramite_danos');
        $danos=$this->servicios->getTiposDanos();

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
                'path' => 'js/fileupload/public/bundle-cliente-ejecutivo.js'
            ),
            array(
                'type' => 'JSHTML',
                'data' => "const _cliente = " . json_encode($clientes) . ";". "const _causas = " . json_encode($tiposCausa) . ";"
                . "const _SubtIpos = " . json_encode($subtipos) . ";". "const _Tipos = " . json_encode($tipos) . ";". "const _GMM = " . json_encode($gmm) . ";"
                . "const _Danos = " . json_encode($danos) . ";"
            )
            
        ));
        $this->render('servicios/indicadores', $head, $data, $footer);
    }

    function getTable($tipo){
        switch ($tipo) {
            case 1:
                $data=$this->servicios->getTable();
                break;
            case 2:
                $data=$this->servicios->getClientes();
            break;
            case 3:
                $data=$this->servicios->table_cliente_ejectivo();
            break;
            case 4:
                $data=$this->servicios->table_alertas();
            break;
            case 5:
                $data=$this->servicios->table_Indicadores();
            break;
            default:
                # code...
                break;
        }
        $this->responseJSON("200", "Èxito", $data);
    }


    function servicio_post($tipo){
        $mensaje="";
        $codigo="";
        switch ($tipo) {
            case 1:
                $djason = json_decode(file_get_contents("php://input"), true);
                if($this->servicios->validateAdd($djason["data"]["Aseguradora"],$djason["data"]["Accionws"],$djason["data"]["cliente"],$djason["data"]["AccionS"])){
                    $mensaje="Ya existe un registro de la aseguradora con el mismo metodo";
                    $codigo="400";
                    $data=[];
                }else{
                    $db=$this->dataAdd($djason);
                    $mensaje="Éxito";
                    $codigo="200";
                    $data=$djason;
                    $inserted=$this->servicios->insertServicio($db);
                }
                break;
            case 2:
                $djason = json_decode(file_get_contents("php://input"), true);
                $db=$this->dataAdd($djason);
                $accion=$this->servicios->actualizarAseguradora($djason["data"]["id"],$db);
                $mensaje="Éxito";
                $codigo="200";
                $data=[];
                break;
            case 3:
                $Accion = $this->input->post('id');
                $this->servicios->deleteServicio($Accion);
                $data=$Accion;
                $codigo=200;$mensaje="Éxito";
                break;
            default:
                # code...
                break;
        }
        $this->responseJSON($codigo, $mensaje, $data);
    }
    function servicio_postC($tipo){
        $datos=array(
            "nombre"=>$this->input->post('nombre', true),
            "descripcion"=>$this->input->post('descripcion', true)
        );
        $id=$this->input->post('id', true);
        $mensaje="";
        $codigo="";
        switch ($tipo) {
            case 1:
                if($id==0){
                    if(empty($this->servicios->validacion($datos["nombre"]))){
                        $datos["creado_por"]=$this->tank_auth->get_idPersona();
                        $datos["creado"]=date('Y-m-d H:i:s');
                        $data=$this->servicios->insertCliente($datos);
                        $mensaje="Éxito";
                        $codigo="200";
                    }else{
                        $mensaje="Ya existe un cliente con el mismo nombre";
                        $codigo="400";
                        $data=[];
                    }
                   
                }else{
                    $datos["modificado_por"]=$this->tank_auth->get_idPersona();
                    $datos["modificado"]=date('Y-m-d H:i:s');
                    $data=$this->servicios->actualizarCliente($id,$datos);
                    $mensaje="Éxito";
                    $codigo="200";
                }
                break;
            case 2:
                if(empty($this->servicios->validateDeleteC($id))){
                    $this->servicios->deleteCliente($id);
                    $mensaje="Éxito";
                    $codigo="200";
                    $data=[];
                }else{
                    $mensaje="El cliente esta vinculado a una aseguradora";
                    $codigo="400";
                    $data=[];
                }
                
                break;
            case 3:
                break;
            default:
                # code...s
                break;
        }
        $this->responseJSON($codigo, $mensaje, $data);
    }
    
    function dataAdd($djason){
        $datos=array(
            "objetocampo"=>$djason["data"]["objeto"],
            "objetojson"=>$djason["data"]["conexiontext"],
            "url"=>$djason["data"]["url"],
            "json_dinamico"=>$djason["data"]["json"]
        );
        $db=array(
            "aseguradora_id"=>$djason["data"]["Aseguradora"],
            "tipo_actualizacion"=>$djason["data"]["AccionS"],
            "cliente_id"=>$djason["data"]["cliente"],
            "tipo_metodo"=>$djason["data"]["Accionws"],
            "datos"=>json_encode($datos)
        );
        return $db;
    }

    function servicio_postE($tipo){
        $mensaje="";
        $codigo="";
        switch ($tipo) {
            case 1:
                $usuario = $this->input->post('usuario');
                $cliente=$this->input->post('cliente');
                $tipo=$this->input->post('tipo');
                if(empty($this->servicios->validacionE($cliente,$usuario))){
                    $datos=array("cliente_id"=>$cliente,"ejecutivo_id"=>$usuario,"tipo"=>$tipo);
                    $data=$this->servicios->insertEjectuivo($datos);
                    $mensaje="Éxito";
                    $codigo="200";
                }else{
                    $mensaje="Ya existe un registro.";
                    $codigo="400";
                    $data=[];
                }
                break;
            case 2:
                $usuario = $this->input->post('usuario');
                $cliente=$this->input->post('cliente');
                $id=$this->input->post('id');
                $tipo=$this->input->post('tipo');
                $datos=array("tipo"=>$tipo);
                $this->servicios->actualizarE($id,$datos);
                $mensaje="Éxito";
                $codigo="200";
                $data=$datos;
                break;
            case 3:
                $Accion = $this->input->post('id');
                $this->servicios->deleteServicioE($Accion);
                $data=$Accion;
                $codigo=200;$mensaje="Éxito";
                break;
            default:
                # code...
                break;
        }
        $this->responseJSON($codigo, $mensaje, $data);
    }


    function servicio_postA($tipo){
        $mensaje="";
        $codigo="";
        switch ($tipo) {
            case 1:
                $datosR = json_decode($this->input->post('Data'), true);
                if(empty($this->servicios->validacionA($datosR["cliente_id"],$datosR["causa_id"]))){
                    $data=array(
                        "cliente_id"=>$datosR["cliente_id"]==''?0:$datosR["cliente_id"],
                        "indicador_id"=>$datosR["causa_id"],
                        "dias"=>$datosR["dias"],
                        "esc1_dias"=>$datosR["dias_posteriores_1"],
                        "esc2_dias"=>$datosR["dias_posteriores_2"],
                        "escalamiento_1"=>json_encode(array(
                            "usuarios"=>$datosR["escalamiento_1"],
                            "dias"=>$datosR["dias_posteriores_1"]
                        )),
                        "escalamiento_2"=>json_encode(array(
                            "usuarios"=>$datosR["escalamiento_2"],
                            "dias"=>$datosR["dias_posteriores_2"]
                        )),
                        "tipo_notificacion"=>json_encode($datosR["notificacion"])
                    );
                    $this->servicios->insertAlerta($data);
                    $mensaje="EXITO";
                    $codigo="200";
                    $data=$datosR;
                }else{
                    $mensaje="Ya existe un registro.";
                    $codigo="400";
                    $data=[];
                }
                break;
            case 2:
                $datosR = json_decode($this->input->post('Data'), true);
                    $datos=array(
                        "esc1_dias"=>$datosR["dias_posteriores_1"],
                        "esc2_dias"=>$datosR["dias_posteriores_2"],
                        "dias"=>$datosR["dias"],
                        "escalamiento_1"=>json_encode(array(
                            "usuarios"=>$datosR["escalamiento_1"],
                            "dias"=>$datosR["dias_posteriores_1"]
                        )),
                        "escalamiento_2"=>json_encode(array(
                            "usuarios"=>$datosR["escalamiento_2"],
                            "dias"=>$datosR["dias_posteriores_2"]
                        )),
                        "tipo_notificacion"=>json_encode($datosR["notificacion"]),
                    );
                    $this->servicios->actualizarA($datosR["id"],$datos);
                    $mensaje="Éxito";
                    $codigo="200";
                    $data=$datos;
                break;
            case 3:
                $Accion = $this->input->post('id');
                $this->servicios->deleteServicioA($Accion);
                $data=$Accion;
                $codigo=200;$mensaje="Éxito";
                break;
            default:
                break;
        }
        $this->responseJSON($codigo, $mensaje, $data);
    }

    function servicio_postI($tipo){
        $mensaje="";
        $codigo="";
        switch ($tipo) {
            case 1:
                $datosR = json_decode($this->input->post('Data'), true);
                if(empty($this->servicios->validacionI($datosR["cliente_id"],$datosR["tipo_id"],$datosR["sub_tipo_id"],$datosR["causa_id"]))){
                    $this->servicios->insertIndicador($datosR);
                    $mensaje="EXITO";
                    $codigo="200";
                    $data=$datosR;
                }else{
                    $mensaje="Ya existe un registro.";
                    $codigo="400";
                    $data=[];
                }
                break;
            case 2:
                $datosR = json_decode($this->input->post('Data'), true);
                    $datos=array(
                        "dias"=>$datosR["dias"],
                    );
                    $this->servicios->actualizarI($datosR["id"],$datos);
                    $mensaje="Éxito";
                    $codigo="200";
                    $data=$datos;
                break;
            case 3:
                $Accion = $this->input->post('id');
                $this->servicios->deleteServicioI($Accion);
                $data=$Accion;
                $codigo=200;$mensaje="Éxito";
                break;
            default:
                break;
        }
        $this->responseJSON($codigo, $mensaje, $data);
    }

    function returntipo($tipo){
        $return="";
        switch ($tipo) {
            case 'G':
                $return="C_GMM";
                break;
            case 'A':
                $return="C_AUTOS";
                # code...
                break;
            case 'D':
                $return="C_DANOS";
                # code...
            break;
            default:
            $return="Siniestros";
                # code...
                break;
        }
        return $return;
    }

    
}
