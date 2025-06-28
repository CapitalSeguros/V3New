<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class PIP extends TIC_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('pipmodel', 'pip');
    }

    function index($id=0)
    {
        $head = array('title' => 'Capsys - PIP');
        $data = array();
        $footer = array();
        $data['idperiodo'] = $id;
        
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
                'type' => 'JS',
                'path' => 'gap/js/datatables.min.js'
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ), array(
                'type' => 'JS',
                'path' => 'js/fileupload/public/bundle-monitoreoPIP.js'
            )
        ));
        $this->render('pip/tablaPIP', $head, $data, $footer);
    }


    public function generar()
    {
        $id=$this->input->get('id');
        $empleados =  $this->pip->getEmpleadosEvaluados($id);
        $_emp = $this->pip->getEmpleadosProject($id); 
        foreach ($empleados as $key => $value) {

            $exst = array_filter($_emp, function ($it) use ($value) {
                return $it["empleado_id"] == $value["idPersona"];
            });

            if (count($exst) == 0) {
                $data = array(
                    "evaluacion_periodo_id" => $id,
                    "empleado_id" => $value["idPersona"],
                    "creado_por" => $this->tank_auth->get_IdPersona(),
                    "created" => date("Y-m-d H:i:s"),
                    "modificado_por" => $this->tank_auth->get_idPersona(),
                    "modified" => date("Y-m-d H:i:s"),
                    "estatus" => "BORRADOR"
                );
                $insertedID = $this->pip->AddPIP($data);
            }
        }
        $this->responseJSON("200", "Éxito", $id);
    }

    

    function AgregarPIP()
    {
        $head = array('title' => 'Capsys - PIP');
        $data = array();
        $footer = array();

        $this->breadcrumbs->push('Performance Improvement Plan', '/');
        $this->breadcrumbs->unshift('Periodos de evaluación', '/periodo');
        $this->breadcrumbs->unshift('Inicio', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        //opcion para mostar el menu lateral
        //$_puestos=$this->getPuestos();
        $_puestos=$this->getPuestosNuevo($this->tank_auth->get_idPersonaPuesto());
        $_usuarios=$this->pip->getEmpleados();
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
                'data' => "const _puestos = " . json_encode($_puestos)."; const _empleados = " . json_encode($_usuarios).";"
            ),
            array(
                'type' => 'JS',
                'path' => 'gap/js/datatables.min.js'
            ), array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'JS',
                'path' => 'js/fileupload/public/bundle-pip.js'
            )
        ));
        $this->render('pip/pip', $head, $data, $footer);
    }

    function MonitoreoPIP()
    {
        $head = array('title' => 'Capsys - Monitoreo PIP');
        $data = array();
        $footer = array();
        $data["id"]=$this->input->get('id');
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
                'type' => 'JS',
                'path' => 'gap/js/datatables.min.js'
            ), array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ),
            array(
                'type' => 'JS',
                'path' => 'js/fileupload/public/bundle-monitoreoPIP.js'
            )
        ));
        $this->render('pip/monitoreo', $head, $data, $footer);
    }

    function PostPip()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $djason = json_decode(file_get_contents("php://input"));
            $inicioData = array(
                'empleado_id' => $djason->Empleadoset->value,
                'comentario' => $djason->Comentario,
                'empleado_seguimiento_id' => 0,
                'creado_por' => $this->tank_auth->get_IdPersona(),
                'estatus' => $djason->estatus->label,
                'evaluacion_periodo_id' => $djason->Perido,
                'created'=>date("Y-m-d")
            );
            
            //var_dump($lineManager);
            $insertedID = $this->pip->AddPIP($inicioData);
            $lineManager=array();
            $lineManager[]=array("id_manager"=>$this->tank_auth->get_idPersonaPuesto(),"id_PIP"=>$insertedID);
            //array_push($lineManager,$this->tank_auth->get_idPersonaPuesto());
            foreach ($djason->Linemanager as $key => $value) {
                $lineManager[]=array("id_manager"=>$value->value,"id_PIP"=>$insertedID);
                
                if($djason->estatus->label=="ACTIVO"){
                    $contacto=$this->pip->getusrPuesto($value->value);
                    //var_dump($contacto);
                    foreach ($contacto as $key => $val) {
                        //$this->sendNotificacionManual("PIP", array("referencia"=>$insertedID,"id_persona"=>$val["idPersona"]));
                    }
                    //La relacion del jefe
                    $this->pip->insertManagers(array("id_manager"=>$this->tank_auth->get_idPersonaPuesto(),"id_PIP"=>$insertedID));
                }
            }
            
            if(!empty($lineManager)){
                $this->pip->insertManagers($lineManager);
            }

            foreach ($djason->Items as $valor) {
                if ($valor->FechaComp != '') {
                    $fechap = date("Y-m-d", strtotime($valor->FechaComp));
                } else {
                    $fechap = null;
                }
                $parent = array(
                    'id' => $this->pip->getLastIndexTable('project_implementation_plan_task'),
                    'project_imp_plan_id' => $insertedID,
                    'parent' => 0,
                    'empleado_id' => $djason->Empleadoset->value,
                    'titulo' => $valor->Elemento,
                    'observacion' => $valor->Evidencia,
                    'resultado_esperado' => $valor->MejoraEsparada,
                    'fecha' => $fechap
                );
                //var_dump($parent);
                $this->pip->AddParent($parent);
                $id_parent = $this->pip->getLastIndexTable('project_implementation_plan_task') - 1;
                foreach ($valor->AccionesACabo as $value) {
                    $parent = array(
                        'id' => $this->pip->getLastIndexTable('project_implementation_plan_task'),
                        'project_imp_plan_id' => $insertedID,
                        'parent' => $id_parent,
                        'empleado_id' => $djason->Empleadoset->value,
                        'titulo' => $value->titulo,
                        'observacion' => '',
                        'resultado_esperado' => '',
                        'fecha' => $fechap
                    );
                    $this->pip->AddParent($parent);
                }
            }
        }
    }

    function PostEditPIP()
    {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $djason = json_decode(file_get_contents("php://input"));
            if(isset($djason->Linemanager)){
                if (is_object($djason->Linemanager)) {
                    $LineManager = 0;
                }
                if (is_array($djason->Linemanager)) {
                    $LineManager = 0;
                }
            }else{
                $LineManager=0;
            }
            //var_dump($LineManager);
            $inicioData = array(
                'empleado_id' => $djason->Empleadoset->value,
                'comentario' => $djason->Comentario,
                'empleado_seguimiento_id' => $LineManager,
                'modificado_por' => $this->tank_auth->get_idPersona(),
                //'evaluacion_periodo_id'=>$djason->Perido,
                'estatus' => $djason->estatus->label
            );
            $idTaks = $djason->idTask;
            //var_dump($idTaks);
            $this->pip->deleteAllTask($idTaks); //procesos para eliminar la preguntas
            $this->pip->deleteAllmanagers($djason->idTask);///elemina todos los linemanager
            $lineManager=array();
            $lineManager[]=array("id_manager"=>$this->tank_auth->get_idPersonaPuesto(),"id_PIP"=>$idTaks);
            foreach ($djason->Linemanager as $key => $value) {
                $lineManager[]=array("id_manager"=>$value->value,"id_PIP"=>$idTaks);
                if($djason->estatus->label=="ACTIVO"){
                    $contacto=$this->pip->getusrPuesto($value->value);
                    //var_dump($contacto);
                    foreach ($contacto as $key => $val) {
                        //$this->sendNotificacionManual("PIP", array("referencia"=>$idTaks,"id_persona"=>$val["idPersona"]));
                    }

                     //La relacion del jefe
                     $this->pip->insertManagers(array("id_manager"=>$this->tank_auth->get_idPersonaPuesto(),"id_PIP"=>$idTaks));
                }
            }

            if(!empty($lineManager)){
                $this->pip->insertManagers($lineManager);
            }

            //$this->pip->insertManagers($lineManager);

            $insertedID = $this->pip->UpdatePlan($djason->idTask, $inicioData); //update
            foreach ($djason->Items as $valor) {
                if ($valor->FechaComp != '') {
                    $fechap = date("Y-m-d", strtotime($valor->FechaComp));
                } else {
                    $fechap = null;
                }
                $parent = array(
                    'id' => $this->pip->getLastIndexTable('project_implementation_plan_task'),
                    'project_imp_plan_id' => $idTaks,
                    'parent' => 0,
                    'empleado_id' => $djason->Empleadoset->value,
                    'titulo' => $valor->Elemento,
                    'observacion' => $valor->Evidencia,
                    'resultado_esperado' => $valor->MejoraEsparada,
                    'fecha' => $fechap
                );
                $this->pip->AddParent($parent);
                $id_parent = $this->pip->getLastIndexTable('project_implementation_plan_task') - 1;
                foreach ($valor->AccionesACabo as $value) {
                    $parent = array(
                        'id' => $this->pip->getLastIndexTable('project_implementation_plan_task'),
                        'project_imp_plan_id' => $idTaks,
                        'parent' => $id_parent,
                        'empleado_id' => $djason->Empleadoset->value,
                        'titulo' => $value->titulo,
                        'observacion' => '',
                        'resultado_esperado' => '',
                        'fecha' => $fechap
                    );
                    $this->pip->AddParent($parent);
                }
            }
        }
        echo json_encode($this->response("200", "Éxito", []));
    }

    function editPIP()
    {
        header('Content-Type: application/json');
        $idPerido = $this->input->get('idPerido');
        $idUsuario = $this->input->get('idUsuario');
        //var_dump($idUsuario);
        $result = new \stdClass;
        $result->Info = $this->pip->getDataPIP($idUsuario, $idPerido);
        $result->Taks = $this->pip->getTaks($idUsuario, $idPerido);

        echo json_encode($this->response("200", "Éxito",$result));
    }

    function getData()
    {
        header('Content-Type: application/json');
        $id = $this->input->get('id');
        $result = new \stdClass;
        $result->Info = $this->pip->getEmpleadosEvaluados($id);
        $result->Puestos = $this->pip->getUsers();
        echo json_encode($this->response("200", "Éxito", $result));
    }

    function getdataPIPElement()
    {
        header('Content-Type: application/json');
        $id = $this->input->get('id');
        $idPlan = $this->input->get('idPeriodo');
        $result = new \stdClass;
        $result->Info = $this->pip->getEmpleadoEvaluado($id);
        $result->Puestos = $this->pip->getUsers();
        $result->Seguimiento = $this->pip->getEmpleadoSeguimiento($idPlan);
        $result->getLinemanagers=$this->pip->getLinemanagers($idPlan);

        echo json_encode($this->response("200", "Éxito", $result));
    }

    //metodos del modulo de Monitoreo de PIP
    function MonitoreoGet()
    {
        header('Content-Type: application/json');
        $id = $this->input->get('id');
        $result = new \stdClass;
        $result->Evaluado = '';
        $result->Items = $this->pip->getItemsMonitoreo($id);
        echo json_encode($this->response("200", "Éxito", $result));
    }

    function getTableMonitoreo()
    {
        header('Content-Type: application/json');
        $idPerido = $this->input->get('id');
        $result = $this->pip->getAllInfoMonitoreoTable($idPerido,$this->tank_auth->get_idPersona());
        echo json_encode($this->response("200", "Éxito", $result));
    }

    function getDataMonitoreo()
    {
        header('Content-Type: application/json');
        $result = new \stdClass;
        $idPI = $this->input->get('idPI');
        $result->Info = $this->pip->getAllInfoMonitoreo($idPI);
        $result->Taks = $this->pip->getTasksMonitoreo($idPI);
        echo json_encode($this->response("200", "Éxito", $result));
    }

    function getComentarios()
    {
        header('Content-Type: application/json');
        $result = new \stdClass;
        $idPI = $this->input->get('idPI');
        $result->Comentarios = $this->pip->getComentarios($idPI);
        echo json_encode($this->response("200", "Éxito", $result));
    }

    function AddComentarios()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $djason = json_decode(file_get_contents("php://input"));
            $data = array(
                'project_imp_task_id' => $djason->Itemseleccionado->id,
                'project_imp_plan_id' => $djason->IdPIP,
                'comentario' => $djason->AddComent,
                'creado_por' => $this->tank_auth->get_idPersona(),
            );
            //var_dump($data);
            $this->pip->AddComentario($data);
        }
    }

    function Cerrar(){
        header('Content-Type: application/json');
        $result =$this->input->post('id');
        $data=array(
            "estatus"=>"CERRADO"
        );
        $this->pip->updatePlanInfo($result,$data);
        echo json_encode($this->response("200", "Éxito", []));
    }

    function DeletePIP(){
        header('Content-Type: application/json');
        $result =$this->input->post('id');
        $this->pip->deleteAllPIP($result);
        echo json_encode($this->response("200", "Éxito", []));
    }
}
