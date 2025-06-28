<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Personas extends TIC_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('tipo_baja_model', 'tipoBaja');
        $this->load->model('incidenciasmodel', 'incidencia');
        $this->load->model('evaluaciones_model', 'evaluacion');
        $this->load->model('evaluacion_periodos_model', 'periodo');
        $this->load->model('bonos_model', 'bono');
        $this->load->model('pipmodel', 'pip');
        $this->load->model("personamodelo", "persona");
        $this->load->library('common');
    }


    public function perfil($id = null)
    {
        $obPeriodo = null;
        if (isset($_GET["periodo"])) {
            $periodoId = intval($_GET["periodo"]);
            $obPeriodo = $this->periodo->selectById($periodoId);
        } else {
            $obPeriodo = $this->periodo->activo();
        }

        if ($id == null)
            $id =  $this->tank_auth->get_idPersona();

        $bonos = $this->bono->getMe($id);

        $data = array(
            "evaluaciones_pendientes" => array(),
            "mis_evaluaciones" => array(),
            "bonos" => $bonos
        );

        $empleados = $this->persona->getEmpleados();
        $_puestos = $this->persona->getPuestos();

        $data["id"] = $id;
        $data["periodos"] = $this->periodo->selectCerrados();

        $data["periodoId"] = @$obPeriodo->id;
        $data["periodoName"] = @$obPeriodo->titulo;
        $obPersona = $this->persona->obtener($id);
        $data["name_complete"] = $obPersona->name_complete;

        $startD = $this->common->first_date(date("Y-m-d"));
        $endD = $this->common->last_date(date("Y-m-d"));
        $data["minDayVacation"] = $this->global["minDayVacation"];
        $data["startBlock"] = $this->global["startBlock"];
        $data["daysBlock"] = $this->global["daysBlock"];

        $obPuesto = $this->persona->obtenerPuestoBy($obPersona->idPersonaPuesto);
        $data["dias_vacaciones"] = $this->persona->getVacaciones($id);
        $data["solicitud_vacaciones"] = $this->incidencia->getVacacionesByfechas($id);
        $data["mis_incidencias"] = $this->incidencia->getIncidenciasByfechas($startD, $endD, $id);
        $data["pips"] = $this->pip->getSeguimientoByEmpleado(@$obPeriodo->id,$id);
    

        if ($obPeriodo != null) {
            $data["evaluaciones_pendientes"] = $this->periodo->selectEvaluacionesByEmpelado($obPeriodo->id, $id);
            $data["mis_evaluaciones"] = $this->periodo->selectEvaluacionByEmpleado($obPeriodo->id, $id);
        }
        $data["puedo_solicitar"] =  $this->tank_auth->get_idPersona() == $id ?  true : $obPuesto->padrePuesto == $this->tank_auth->get_idPersonaPuesto() ? true : false;

        $head = array("title" => "Capsys - Perfil");
 
        $footer = array();
        $this->breadcrumbs->push('Perfil', 'personas/perfil');
        $this->breadcrumbs->unshift('Persona', 'personas');
        $this->breadcrumbs->unshift('Inicio', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        //opcion para mostar el menu lateral
        $data["tipo"]="CapitalHumano";

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
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
                'path' => 'js/fileupload/public/bundle-incidencias.js'
            ),
            array(
                'type' => 'JS',
                'path' => 'js/fileupload/public/bundle-bonos.js'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/personas.profile.js'
            )
        ));
        $this->render('personas/perfil', $head, $data, $footer);
    }

    public function baja()
    {
        //$this->comprobarpermiso($_SERVER['REQUEST_URI'],$this->tank_auth->get_idPersona());
        $head = array('title' => 'Capsys - Catalogo Bajas');
        $data = array();
        $footer = array();

        $this->breadcrumbs->push('Tipo de baja', 'personas/baja');
        $this->breadcrumbs->unshift('Catalogos', 'personas/baja');
        $this->breadcrumbs->unshift('Inicio', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        //opcion para mostar el menu lateral
        $data["tipo"]="CapitalHumano";

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
            ), array(
                'type' => 'JS',
                'path' => 'gap/js/persona_baja.table.js'
            ),
        ));
        $this->render('personas/baja', $head, $data, $footer);
    }
  

    public function getBaja()
    {
        $data = $this->tipoBaja->select();
        $this->responseJSON("200", "Éxito", $data);
    }

    public function baja_save()
    {
        $data = array(
            "nombre" => $this->input->post('nombre', true),
            "created" => date('Y-m-d H:i:s'),
            "modified" => date('Y-m-d H:i:s'),
            "creado_por" => $this->tank_auth->get_idPersona(),
            "modificado_por" => $this->tank_auth->get_idPersona(),
        );
        $ok = false;
        $id = $this->input->post('id', true);
        $id = intval($id);
        if ($id == 0) {
            $id = $this->tipoBaja->add($data);
            $ok = $id > 0;
        } else {
            $ok = $this->tipoBaja->update($id, array(
                "nombre" => $data["nombre"],
                "modified" => $data["modified"],
                "modificado_por" => $data["modificado_por"],
            ));
        }
        if ($ok)
            $this->responseJSON("200", "Se guardo con éxito.", $data);
        else
            $this->responseJSON("400", "Ocurrio un error al guardar.", null);
    }

    public function deleteBaja()
    {
        $id = $this->input->post('id', true);
        $id = intval($id);
        $data = $this->tipoBaja->delete($id);
        $this->responseJSON("200", "Éxito", $data);
    }

    public function baja_persona()
    {
        $djason = json_decode(file_get_contents("php://input"));
        $id = $djason->empleadoId;
        $id = intval($id);
        $motivo = $djason->motivoId;
        $this->load->model('PersonaModelo', 'persona');
        $ok = $this->persona->baja_persona($id, $motivo);
        if ($ok) {
            $this->responseJSON("200", "Se proceso con éxito.", null);
        } else {
            $this->responseJSON("400", "Ocurrio un error al dar de baja", null);
        }
    }
}
