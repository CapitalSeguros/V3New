<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Bonos extends TIC_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library(array('session'));
        $this->load->helper('url');
        $this->load->model('bonos_model', 'bonos');
        $this->load->model('pipmodel', 'pip');
        $this->load->model("personamodelo", "persona");
        $this->load->model('evaluacion_periodos_model', 'periodo');
        $this->lang->load('tank_auth');
    }

    public function index()
    {
        //$this->comprobarpermiso($_SERVER['REQUEST_URI'],$this->tank_auth->get_idPersona());
        $head = array('title' => 'Capsys - Bonos');
        $data = array();
        $footer = array();
        $empleados = $this->persona->getEmpleados();
        //$_puestos = $this->persona->getPuestos();
        $_puestos = $this->getPuestos();
        $this->breadcrumbs->push('Solicitudes', 'Bonos');
        $this->breadcrumbs->unshift('Inicio', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data["id"] = $this->tank_auth->get_idPersona();
        $data['idNotificacion'] = $this->session->flashdata('id');
        //opcion para mostar el menu lateral
        $data["tipo"]="CapitalHumano";

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
                'data' => "const _empleados = " . json_encode($empleados) . "; const _puestos = " . json_encode($_puestos) . ";"
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/datatables.min.js'
            ),
            array(
                'type' => 'JS',
                'path' => 'js/fileupload/public/bundle-modal-seguimiento.js'
            ),
            array(
                'type' => 'JS',
                'path' => 'js/fileupload/public/bundle-modal-autorizacion.js'
            ),
            array(
                'type' => 'JS',
                'path' => 'js/fileupload/public/bundle-bonos.js'
            )
        ));
        $this->render('Bonos/tablaBonos', $head, $data, $footer);
    }

    function getTableBonos()
    {
        header('Content-Type: application/json');
        $result = $this->bonos->getTable();
        echo json_encode($this->response("200", "Éxito", $result));
    }

    function getUsers()
    {
        header('Content-Type: application/json');
        $idPuesto = $this->bonos->getPuesto($this->tank_auth->get_idPersona());
        //print_r($idPuesto->idPersonaPuesto);
        $subordinados = $this->bonos->getSubordinados($idPuesto->idPersonaPuesto);
        $result = new \stdClass;
        $result->idUsuario = $this->tank_auth->get_idPersona();
        $result->Users = $this->pip->getUsers();
        $result->subordinados = $subordinados;
        echo json_encode($this->response("200", "Éxito", $result));
    }

    function postData()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $djason = json_decode(file_get_contents("php://input"));

            $data = array(
                "empleado_id" => $djason->empleado->value,
                "importe" => $djason->importe,
                "fecha" => date("Y-m-d", strtotime($djason->fecha)),
                "creado_por" => $this->tank_auth->get_idPersona(),
                "motivo" => $djason->motivo,
                "estatus" => 'PENDIENTE',
            );
            $addBono = $this->bonos->AddSolicitud($data);

            if ($addBono > 0) {
                $this->sendNotificacionManual("BONO_PENDIENTE", array("idSeguimiento" => $addBono, "id_persona" => $this->tank_auth->get_idPersona(), "TipoBono" => 1, "referencia" => $addBono));
                $this->responseJSON("200", "Éxito", null);
            } else {
                $this->responseJSON("400", "Ocurrio un error al generar el registro.", null);
            }
        }
    }

    function getDataPeticion($id)
    {
        header('Content-Type: application/json');
        $result = $this->bonos->getDataPeticion($id);
        $result[]["test"]="test";
        echo json_encode($this->response("200", "Éxito", $result));
    }

    function ValidacionLogeo()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $djason = json_decode(file_get_contents("php://input"));
            $data['login_by_username'] = ($this->config->item('login_by_username', 'tank_auth') and
                $this->config->item('use_username', 'tank_auth'));
            $data['login_by_email'] = $this->config->item('login_by_email', 'tank_auth');
            $data = $this->tank_auth->ValidacionLogeo($djason->Usuario, $djason->Contrasena, $data['login_by_username'], $data['login_by_email']);

            if (!empty($data->data)) {
                $this->responseJSON("200", "Éxito",  $data->data);
            } else {
                $this->responseJSON("400", $data->error, $data->data);
            }
        }
    }

    function insertSeguimiento()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            header('Content-Type: application/json');
            $djason = json_decode(file_get_contents("php://input"));
            $today = date("Y-m-d H:i:s");
            $opcion = 1;
            if ($djason->estado->value == "AUTORIZADO") {
                $opcion = 2;
                $updatepeticion = array(
                    "importe_final" => $djason->importe,
                    "fecha_aplicacion" => date("Y-m-d", strtotime($djason->fecha)),
                    "motificado_por" => $this->tank_auth->get_idPersona(),
                    "autorizado_por" => $djason->data->idPersona,
                    "modified" => $today,
                    "estatus" => $djason->estado->value
                );
            } else {
                $opcion = 3;
                $updatepeticion = array(
                    // "importe" => $djason->form->importe,
                    // "fecha" => date("Y-m-d", strtotime($djason->form->fecha)),
                    "motificado_por" => $this->tank_auth->get_idPersona(),
                    "autorizado_por" => $djason->data->idPersona,
                    "modified" => $today,
                    "estatus" => $djason->estado->value
                );
            }

            $ok = $this->bonos->updateEstatuspeticion($updatepeticion, $djason->idSeguimiento);
            $seguimiento = array(
                "solicitud_sueldo_id" => $djason->idSeguimiento,
                "motivo" => $djason->motivo,
                "empleado_id" => $this->tank_auth->get_idPersona(),
                "fecha" => $today,
                "estatus" => $djason->estado->value
            );
            if ($ok) {
                $ok = $this->bonos->insertSeguimiento($seguimiento);
                if ($ok) {
                    if ($opcion == 2) {
                        // $this->sendNotificacionManual("BONO_AUTORIZADO", array("idSeguimiento" => $djason->idSeguimiento, "id_persona" => $this->tank_auth->get_idPersona(), "TipoBono" => $opcion, "referencia" => $djason->idSeguimiento));
                    } else {
                        // $this->sendNotificacionManual("BONO_RECHAZADO", array("idSeguimiento" => $djason->idSeguimiento, "id_persona" => $this->tank_auth->get_idPersona(), "TipoBono" => $opcion, "referencia" => $djason->idSeguimiento));
                    }
                    $this->responseJSON("200", "Éxito", null);
                } else {
                    $this->responseJSON("400", "Ocurrio un error al procesar el registro", null);
                }
            } else {
                $this->responseJSON("400", "Ocurrio un error al procesar el registro", null);
            }
        }
    }

    function getSeguimiento($id)
    {
        header('Content-Type: application/json');
        $result = $this->bonos->getAllSeguimiento($id);
        echo json_encode($this->response("200", "Éxito", $result));
    }

    function ReplicaBono()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            header('Content-Type: application/json');
            $djason = json_decode(file_get_contents("php://input"));
            $today = date("Y-m-d H:i:s");

            $updatepeticion = array(
                "importe" => $djason->importe,
                "fecha" => date("Y-m-d", strtotime($djason->fecha)),
                "motificado_por" => $this->tank_auth->get_idPersona(),
                "modified" => $today,
                "estatus" => "PENDIENTE"
            );
            $ok = $this->bonos->updateEstatuspeticion($updatepeticion, $djason->idPeticion);
            $seguimiento = array(
                "solicitud_sueldo_id" => $djason->idPeticion,
                "motivo" => $djason->motivo,
                "empleado_id" => $this->tank_auth->get_idPersona(),
                "fecha" => $today,
                "estatus" => "PENDIENTE"
            );

            if ($ok) {
                $ok  = $this->bonos->insertSeguimiento($seguimiento);
                if ($ok) {
                    $this->responseJSON("200", "Éxito", null);
                    $this->sendNotificacionManual("BONO_REPLICA", array("idSeguimiento" => $djason->idPeticion, "id_persona" => $this->tank_auth->get_idPersona(), "TipoBono" => 1, "referencia" => $djason->idSeguimiento));
                } else {
                    $this->responseJSON("400", "Ocurrio un error al procesar el registro", null);
                }
            } else {
                $this->responseJSON("400", "Ocurrio un error al procesar el registro", null);
            }
        }
    }

    function bonosreporte()
    {
        $id = $this->input->get("id");
        $id = intval($id);
        if ($id == 0) {
            $obPeriodo = $this->periodo->activo();
            $id = @$obPeriodo->id;
        }

        $data = $this->bonos->getbonosreporte($id);
        $this->responseJSON("200", "Éxito", $data);
    }
}
