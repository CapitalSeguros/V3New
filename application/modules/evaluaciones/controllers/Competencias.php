<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Competencias extends TIC_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library(array('form_validation', 'JbUpload'));
        $this->load->model('preguntasmodel', 'preguntas');
        $this->load->model('competenciasmodel', 'competencias');
        $this->load->helper('cookie');
    }

    function index()
    {
        //$this->comprobarpermiso($_SERVER['REQUEST_URI'],$this->tank_auth->get_idPersona());
        $head = array('title' => 'Capsys - Competencias');
        $data = array();
        $footer = array();
        $this->breadcrumbs->push('Competencias', 'Competencias');
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
                'path' => 'js/fileupload/public/bundle-competencias.js'
            ), array(
                'type' => 'JS',
                'path' => 'gap/js/survey.jquery.min.js'
            ), array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            )
        ));
        $this->render('competencias/tablaCompetencias', $head, $data, $footer);
    }

    function AgregarCompetencia()
    {
        $head = array('title' => 'Capsys - Agregar Competencia');
        $data = array();
        $footer = array();
        
        $this->breadcrumbs->push('Nuevo', '/Competencias/AgregarCompetencia');
        $this->breadcrumbs->unshift('Competencias', '/Competencias');
        $this->breadcrumbs->unshift('Inicio', '/');

        $data['breadcrumbs'] = $this->breadcrumbs->show();
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
                'path' => 'js/fileupload/public/bundle-competencias.js'
            )
        ));
        $this->render('competencias/competencias', $head, $data, $footer);
    }

    function getDataUpdate()
    {
        header('Content-Type: application/json');
        $id = $this->input->get('id');
        $result = new \stdClass;
        $result->Informacion = $this->competencias->getCompetencia($id);
        $result->Puesto = $this->competencias->getPuesto($id);
        $allquestion = $this->competencias->getCompletePreguntas();
        $selectedQuestions = $this->competencias->getSelectedPreguntas($id);
        $result->listPregunta = $allquestion;/* array_diff($allquestion, $selectedQuestions); */
        $result->listQuestion = $selectedQuestions;
        /* $result->puestos = $this->competencias->getPuestos(); */
        $result->puestos = $this->getPuestos();
        $result->TipoPreguntas = $this->competencias->getTipodePregunta();
        echo json_encode($this->response("200", "Ex�to", $result));
    }

    function getDataPreguntas()
    {
        header('Content-Type: application/json');
        $result = new \stdClass;
        $result->preguntas = $this->preguntas->selectPregunta();
        /* $result->puestos = $this->competencias->getPuestos(); */
        $result->puestos =$this->getPuestos();
        $result->TipoPreguntas = $this->competencias->getTipodePregunta();
        echo json_encode($this->response("200", "Ex�to", $result));
    }
    //metodo de la tabla
    function getTablaCompetencias()
    {
        header('Content-Type: application/json');
        $result = $this->competencias->getCompetencias();
        echo json_encode($this->response("200", "Ex�to", $result));
    }
    function deleteCompetencia()
    {
        $id = $this->input->post('id');
        header('Content-Type: application/json');
        $Comprobacion = $this->competencias->Comprobacion($id);
        if ($Comprobacion !== 0) {
            $result = 1;
        } else {
            $this->competencias->EliminarCompetencia($id);
            $this->competencias->DeletePreguntasCompetencias($id);
            $this->competencias->DeletePuestosCompetencias($id);
            $result = 0;
        }
        echo json_encode($this->response("200", "Ex�to", $result));
    }

    function Comprobacion()
    {
        $id = $this->input->post('id');
        header('Content-Type: application/json');
        $Comprobacion = $this->competencias->Comprobacion($id);
        if ($Comprobacion !== 0) {
            $result = 1;
        } else {
            $result = 0;
        }
        echo json_encode($this->response("200", "Exíto", $result));
    }

    function postDatapreguntas()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $djason = json_decode(file_get_contents("php://input"));
   
            if ($djason->Accion === "Editar") {
                $data = array(
                    'titulo' => $djason->titulo,
                    'descripcion' => $djason->descripcion
                );
                $this->competencias->updateInfoCompetencia($djason->id, $data);
                $array = json_decode(json_encode($djason->Puesto), true);
                if (count($array) > 0) {
                    if (is_object($djason->Puesto)) {
                        $valor = $djason->Puesto->value;
                    }
                    if (is_array($djason->Puesto)) {
                        $valor = $djason->Puesto[0]->value;
                    }
                    if ($djason->ultimoPuesto != $valor) {
                        $ids = array('competencias_id' => $djason->id, 'puestos_id' => $valor);
                        $this->competencias->updatePuestoCompetencia($djason->id, $ids);
                    }
                    if ($djason->ultimoPuesto == null && $array['value'] != '') {
                        echo 'add';
                        $data2 = array('competencias_id' => $djason->id, 'puestos_id' => $array['value']);
                        $this->competencias->addCompetenciaPuesto($data2);
                    }
                }
                $this->competencias->eliminarPreguntasCompetencia($djason->id);
                $order = 0;
                foreach ($djason->Competencias as $valor) {
                    $dataPreguntas = array("competencias_id" => $djason->id, "pregunta_id" => $valor->Idp, "orden" => $order);
                    $this->competencias->addPreguntasCompetencias($dataPreguntas);
                    $order++;
                }
            } else {
                $data = array(
                    'id' => $id = $this->competencias->getLastIndexTable('competencias'),
                    'titulo' => $djason->titulo,
                    'descripcion' => $djason->descripcion
                );
                $idinsert = $this->competencias->addCompetencia($data);
                $array = json_decode(json_encode($djason->Puesto), true);
                if (count($array) > 0) {
                    $data2 = array('competencias_id' => $idinsert, 'puestos_id' => $array['value']);
                    $this->competencias->addCompetenciaPuesto($data2);
                }
                $order = 0;
                foreach ($djason->Competencias as $valor) {
                    $dataPreguntas = array("competencias_id" => $idinsert, "pregunta_id" => $valor->Idp, "orden" => $order);
                    $this->competencias->addPreguntasCompetencias($dataPreguntas);
                    $order++;
                }
            }
        }
    }
    function getCompetencias()
    {
        $data = $this->competencias->getCompetencias();
        return $this->responseJSON("200", "�xito", $data);
    }
}
