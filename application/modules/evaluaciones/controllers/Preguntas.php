<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Preguntas extends TIC_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library(array('form_validation', 'JbUpload'));
        $this->load->model('preguntasmodel', 'preguntas');
        $this->load->helper('cookie');
    }
    public function index()
    {
        //$this->comprobarpermiso($_SERVER['REQUEST_URI'],$this->tank_auth->get_idPersona());
        $head = array('title' => 'Capsys - Preguntas');
        $data = array();
        $footer = array();

        $this->breadcrumbs->push('Preguntas', 'preguntas');
        $this->breadcrumbs->unshift('Inicio', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['tabla'] = $this->preguntas->selectPregunta();
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
                'path' => 'gap/js/survey.jquery.min.js'
            ), array(
                'type' => 'JS',
                'path' => 'gap/js/datatables.min.js'
            ), array(
                'type' => 'JS',
                'path' => 'js/fileupload/public/bundle-preguntas.js'
            ), array(
                'type' => 'JS',
                'path' => 'gap/js/preguntas.table.js'
            )
        ));
        $this->render('Preguntas/pregunta', $head, $data, $footer);
    }

    public function getTipoPregunta()
    {
        $data = $this->preguntas->getTipoPregunta();
        $this->responseJSON("200", "Exíto", $data);
    }

    function addPregunta()
    {
        header('Content-Type: application/json');
        $accion = $this->input->post('Accion');
        if ($accion === "Editar") {
            $id = $this->input->post('id');
            $data = array(
                'titulo' => $this->input->post('Pregunta'),
                'descripcion' => $this->input->post('slug'),
                //'tipo_pregunta_id' => $this->preguntas->getIdTipopregunta($this->input->post('tipoPregunta')),
                'respuesta'=>$this->input->post('correcta'),
                'tipo_pregunta_id' => $this->input->post('tipoPregunta'),
                'tipo_dato' => '',
                'json_content' => $this->input->post('Template', true)
            );
            $value = $this->preguntas->updatePregunta($id, $data);
        } else {
            $data = array(
                'id' => $this->preguntas->getLastIndexTable('preguntas'),
                'titulo' => $this->input->post('Pregunta'),
                'descripcion' => $this->input->post('slug'),
                //'tipo_pregunta_id' => $this->preguntas->getIdTipopregunta($this->input->post('tipoPregunta')),
                'tipo_pregunta_id' => $this->input->post('tipoPregunta'),
                'tipo_dato' => '',
                'respuesta'=>$this->input->post('correcta'),
                'json_content' => $this->input->post('Template', true)
            );
            //var_dump($this->input->post('correcta'));
            $value = $this->preguntas->insertPregunta($data);
        }
        echo json_encode($this->response("200", "Exíto", $value));
    }

    function getPreguntasTable()
    {
        header('Content-Type: application/json');
        $tabla = $this->preguntas->selectPregunta();
        echo json_encode($this->response("200", "Exíto", $tabla));
    }

    function getPregunta()
    {
        header('Content-Type: application/json');
        $id = $this->input->post('id');
        $data = $this->preguntas->getPregunta($id);
        //echo json_encode($data);
        echo json_encode($this->response("200", "Exíto", $data));
    }

    function deletePregunta()
    {
        header('Content-Type: application/json');
        $id = $this->input->post('id');
        $data = $this->preguntas->DeletePregunta($id);
        //echo json_decode($data);
        echo json_encode($this->response("200", "Exíto", $data));
    }

    function editPregunta()
    {
        if (isset($_GET['ref'])) {
            $id = $_GET['ref'];
            $data = $this->preguntas->getPregunta($id);
            echo json_encode($data);
        }
    }
}
