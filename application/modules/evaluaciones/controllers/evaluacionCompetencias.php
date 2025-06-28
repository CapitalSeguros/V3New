<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class evaluacionCompetencias extends TIC_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library(array('form_validation', 'JbUpload'));
        $this->load->model('preguntasmodel', 'preguntas');
        $this->load->model('competenciasmodel', 'competencias');
        $this->load->model('personamodelo', 'personamodelo');
        $this->load->model('evaluacion_competencias_model', 'evaluacioncompetencias');
        $this->load->helper('cookie');
    }

    function index()
    {
        //$this->comprobarpermiso($_SERVER['REQUEST_URI'],$this->tank_auth->get_idPersona());
        $head = array('title' => 'Capsys - Evaluacion por competencias');
        $data = array();
        $footer = array();
        $this->breadcrumbs->push('Evaluacion por competencias', 'Evaluacion por competencias');
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
        $this->render('competencias/evaluacionCompetencias', $head, $data, $footer);
    }

    function getInfoCompetencia(){
        $valor=$this->input->post('competencia');
        $datos['puestos'] = $this->personamodelo->getColaboradoresEvaluacion(null);
        $datos['personas'] = $this->personamodelo->getNombresColaboradores(null);
        $datos['idPersona'] = $this->tank_auth->get_idPersona();
        $datos['preguntas'] = $this->evaluacioncompetencias->getPreguntas($valor);
        $respuesta=$this->evaluacioncompetencias->getRespuestasxCompetecia($valor,$this->tank_auth->get_idPersona());
        $datos['respuestas']="";
        if (!empty($respuesta)) {
            $datos['respuestas']="Guardadas";
        }else{
            $datos['respuestas']="No guardadas";
        }
        echo json_encode($datos);
    }

    function getInfoResultados(){
        $personas = $this->personamodelo->getNombresColaboradores(null);
        $respuestasProcesadas = [];
        foreach ($personas as $persona) {
            if($persona->id!=$this->tank_auth->get_idPersona()){
            $respuesta=$this->evaluacioncompetencias->getRespuestas($persona->id);
            $cont1=0;
            $cont2=0;
            $cont3=0;
            $cont4=0;
            $cont5=0;
            $cont6=0;
            if (!empty($respuesta)) {
            foreach ($respuesta as $r) {
                if($r['idCompetencia']==1){
                    $cont1 += (int) $r['respuesta'];
                }
                if($r['idCompetencia']==2){
                    $cont2 += (int) $r['respuesta'];
                }
                if($r['idCompetencia']==3){
                    $cont3 += (int) $r['respuesta'];
                }
                if($r['idCompetencia']==4){
                    $cont4 += (int) $r['respuesta'];
                } 
                if($r['idCompetencia']==5){
                    $cont5 += (int) $r['respuesta'];
                }               
                if($r['idCompetencia']==6){
                    $cont6 += (int) $r['respuesta'];
                }
                }
            }
                            $porcen1 = round(($cont1 / 25) * 100, 2);
                $porcen2 = round(($cont2 / 25) * 100, 2);
                $porcen3 = round(($cont3 / 25) * 100, 2);
                $porcen4 = round(($cont4 / 25) * 100, 2);
                $porcen5 = round(($cont5 / 25) * 100, 2);
                $porcen6 = round(($cont6 / 25) * 100, 2);
                $total = round((($cont1+$cont2+$cont3+$cont4+$cont5+$cont6) / 150) * 100, 2);
            $respuestasProcesadas[] = [
                    'idPersona' => $persona->id,
                    'nombre' => $persona->nombre,
                    'puesto' => $persona->personaPuesto,
                    'departamento' => $persona->colaboradorArea,
                    'competencia1'  => $porcen1,
                    'competencia2'  => $porcen2,
                    'competencia3'  => $porcen3,
                    'competencia4'  => $porcen4,
                    'competencia5'  => $porcen5,
                    'competencia6'  => $porcen6,
                    'total'  => $total
                ];    
        }
    }
        $datos['respuestas']=$respuestasProcesadas;
        echo json_encode($datos);
    }

    function guardarRespuestas(){
        $contenidoJSON = file_get_contents("php://input");
    
    // Decodifica
    $data = json_decode($contenidoJSON, true);

    if ($data) {
        // Accede a los datos del formulario
        $valor = isset($data['idCompetencia']) ? $data['idCompetencia'] : null;
        $preguntas = $this->evaluacioncompetencias->getPreguntas($valor);
        $personas =  $this->personamodelo->getColaboradoresEvaluacion(null);
        $respuestas = [];
            // Recorre personas
        foreach ($personas as $persona) {
             foreach ($preguntas as $pregunta) {
                if($persona->id!=$this->tank_auth->get_idPersona()){
                $idPersona=$persona->id;
                $idPregunta=$pregunta['idPregunta'];
                $id=$idPregunta."-".$idPersona;
                $respuesta = isset($data[$id]) ? $data[$id] : null;
                        // Guarda cada fila como un array asociativo
                $respuestas[] = [
                    'idPersona' => $idPersona,
                    'idPregunta' => $idPregunta,
                    'respuesta' => $respuesta,
                    'valor' => $valor
                ];
                $this->evaluacioncompetencias->insertRespuestas($idPersona, $idPregunta, $respuesta, $valor, $this->tank_auth->get_idPersona());
                }
            }
        }

        echo json_encode($respuestas);
    }else{
        echo json_encode(['mensaje' => 'No entro']);
    }
    }

}