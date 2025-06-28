<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class TabuladorBonos extends TIC_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('tabBonos_model', 'tabulador');
        $this->load->model("personamodelo", "persona");
        // include APPPATH . 'third_party/TC/Chart.php';
    }

    public function index()
    {
        //$this->comprobarpermiso($_SERVER['REQUEST_URI'],$this->tank_auth->get_idPersona());
        $empleados = $this->persona->getEmpleados();
        $_puestos = $this->persona->getPuestos();
        $_puestos2 = $this->getPuestos();
        $head = array('title' => 'Capsys - Configuración de bonos');
        $data = array();
        $footer = array();
        //opcion para mostar el menu lateral
        $data["tipo"]="CapitalHumano";
        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            ),
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _empleados = " . json_encode($empleados) . "; const _puestos = " . json_encode($_puestos) . ";". "; const _puestos2 = " . json_encode($_puestos2) . ";"
            ),
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
                'path' => 'js/fileupload/public/bundle-modal-seguimiento.js'
            ),
            array(
                'type' => 'JS',
                'path' => 'js/fileupload/public/bundle-modal-autorizacion.js'
            ),
            array(
                'type' => 'JS',
                'path' => 'js/fileupload/public/bundle-tabuladorbono.js'
            )
        ));
        $this->render('TabuladorBonos/TabuladorBonos', $head, $data, $footer);
    }

    public function getTableTabuladorBonos()
    {
        $data = $this->tabulador->getTable();
        $this->responseJSON("200", "Éxito", $data);
    }

    public function getSeguimiento($id)
    {
        //echo $id
        $data = $this->tabulador->getSeguimiento($id);
        $this->responseJSON("200", "Éxito", $data);
    }

    public function getRegistro($id)
    {
        $data = $this->tabulador->getRegistro($id);
        $this->responseJSON("200", "Éxito", $data);
    }

    public function postData()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $djason = json_decode(file_get_contents("php://input"));
            $today = date("Y-m-d H:i:s");
            $data = array(
                "puesto_id" => $djason->Puesto->value,
                "calificacion" => $djason->Puntos,
                "sueldo" => $djason->importe,
                "creado_por" => $this->tank_auth->get_idPersona(),
                "fecha" => $today,
                "estado" => 'PENDIENTE',
            );

            $check = $this->tabulador->checkRegistro($djason->Puntos, $djason->Puesto->value);
            if ($check) {
                $this->responseJSON("400", "No se puede agregar puestos con el mismo puntaje", null);
            } else {
                $addTabBono = $this->tabulador->addNew($data);
                $data = $this->tabulador->getRegistro($addTabBono);
                $seguimiento = array(
                    "tabulador_sueldo_id" => $addTabBono,
                    "calificacion" => $data[0]->calificacion,
                    "motivo" => "Creación de registro",
                    "creado_por" => $this->tank_auth->get_idPersona(),
                    "modificado_por" => $this->tank_auth->get_idPersona(),
                    "fecha" => $today,
                    "sueldo" => $data[0]->sueldo,
                    "estatus" => "PENDIENTE"
                );
                if ($addTabBono > 0) {
                    $seguim = $this->tabulador->insertSeguimiento($seguimiento);
                    $this->responseJSON("200", "Éxito", null);
                } else {
                    $this->responseJSON("400", "Ocurrio un error al generar el registro.", null);
                }
            }
        }
    }

    public function insertSeguimiento()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            header('Content-Type: application/json');
            $djason = json_decode(file_get_contents("php://input"));
            //echo $djason->estado->value;
            //print_r($djason);
            $today = date("Y-m-d H:i:s");
            $opcion = 1;
            if ($djason->estado->value == "APROBADO") {
                $opcion = 2;
                $updatepeticion = array(
                    "calificacion" => $djason->Puntos,
                    "sueldo" => $djason->importe,
                    "estado" => $djason->estado->value,
                );
            } else {
                $opcion = 3;
                $updatepeticion = array(
                    "calificacion" => $djason->Puntos,
                    "sueldo" => $djason->importe,
                    "estado" => $djason->estado->value,
                    // "importe" => $djason->form->importe,
                    // "fecha" => date("Y-m-d", strtotime($djason->form->fecha)),
                    //"motificado_por" => $this->tank_auth->get_idPersona(),
                    //"autorizado_por" => $djason->data->idPersona,
                    //"modified" => $today,
                    "estado" => $djason->estado->value
                );
            }
            //print_r($updatepeticion);

            $ok = $this->tabulador->updateEstatuspeticion($updatepeticion, $djason->idSeguimiento);

            $seguimiento = array(
                "tabulador_sueldo_id" => $djason->idSeguimiento,
                "calificacion" => $djason->Puntos,
                "motivo" => $djason->motivo,
                "creado_por" => $this->tank_auth->get_idPersona(),
                "modificado_por" => $this->tank_auth->get_idPersona(),
                "fecha" => $today,
                "sueldo" => $djason->importe,
                "estatus" => $djason->estado->value
            );
            if ($ok) {
                $ok = $this->tabulador->insertSeguimiento($seguimiento);
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

    public function editRegistro()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            header('Content-Type: application/json');
            $djason = json_decode(file_get_contents("php://input"));
            //echo $djason->estado->value;
            //print_r($djason);
            $today = date("Y-m-d H:i:s");
            $opcion = 1;
            $updatepeticion = array(
                "calificacion" => $djason->Puntos,
                "sueldo" => $djason->importe,
                "estado" => "PENDIENTE",
            );
            //print_r($updatepeticion);

            $ok = $this->tabulador->updateEstatuspeticion($updatepeticion, $djason->edit);

            $seguimiento = array(
                "tabulador_sueldo_id" => $djason->edit,
                "calificacion" => $djason->Puntos,
                "motivo" => "Edición del registro",
                "creado_por" => $this->tank_auth->get_idPersona(),
                "modificado_por" => $this->tank_auth->get_idPersona(),
                "fecha" => $today,
                "sueldo" => $djason->importe,
                "estatus" => "PENDIENTE"
            );
            if ($ok) {
                $ok = $this->tabulador->insertSeguimiento($seguimiento);
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

    public function deleteRegistro($id)
    {
        $updatepeticion = array(
            "estado" => "CERRADO",
        );
        $data = $this->tabulador->getRegistro($id);
        //print_r($data);
        $ok = $this->tabulador->updateEstatuspeticion($updatepeticion, $id);
        $today = date("Y-m-d H:i:s");
        $seguimiento = array(
            "tabulador_sueldo_id" => $id,
            "calificacion" => $data[0]->calificacion,
            "motivo" => "Eliminar registro",
            "creado_por" => $this->tank_auth->get_idPersona(),
            "modificado_por" => $this->tank_auth->get_idPersona(),
            "fecha" => $today,
            "sueldo" => $data[0]->sueldo,
            "estatus" => "CERRADO"
        );
        if ($ok) {
            $ok = $this->tabulador->insertSeguimiento($seguimiento);
            if ($ok) {
                $this->responseJSON("200", "Éxito", null);
            } else {
                $this->responseJSON("400", "Ocurrio un error al procesar el registro", null);
            }
        } else {
            $this->responseJSON("400", "Ocurrio un error al procesar el registro", null);
        }
    }
}
