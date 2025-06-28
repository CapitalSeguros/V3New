<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Permisos extends TIC_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library(array('session'));
        $this->lang->load('tank_auth');
        $this->load->model("personamodelo", "persona");
        $this->load->model("servicios_model", "servicio");
        //$this->checkPermisos();
    }

    public function index()
    {
        $head = array('title' => 'Capsys - Permisos');
        $data = array();
        $footer = array();
        //opcion para mostar el menu lateral
        $tipo=$this->input->get('tipo');
        $data["tipo"]=$this->returntipo($tipo);;
        //$data["tipo"]="Siniestros";
        //$_puestos = $this->persona->getPuestos();
        $_puestos = $this->getPuestos();
        //$data["modulos"]=$this->servicio->getTableNombre('modulo_url');
        $data["modulos"]=$this->servicio->getTreedb();
        $data["puestos"]=$_puestos;
        //array_push($_puestos,array("value"=>"0","label"=>"SIN PUESTO"));
        $acciones=$this->servicio->getTableNombre('modulo_acciones');
        $data["acciones"]=$acciones;
        $_urls=$this->servicio->getAllUrls();
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
                'path' => 'js/fileupload/public/bundle-permisos.js'
            ),
            array(
                'type' => 'JSHTML',
                'data' => "const _puestos = " . json_encode($_puestos) . ";"."const _url = " . json_encode($_urls) . ";"."_puesto=".json_encode([]).";"
                ."_Acciones=".json_encode($acciones).";"
            ),
            
        ));
        $this->render('validation/permisostree', $head, $data, $footer);
    }

    public function Acciones($tipo){
        $data=array();
        $code="";
        $message="";
        switch ($tipo) {
            case 1:
                $datosR = json_decode($this->input->post('Data'), true);
                $result=array(
                    "id_url"=>$datosR["url"],
                    "id_puestoPersona"=>$datosR["puesto"],
                    "acciones"=>$datosR["permisos"]
                );
                if(empty($this->servicio->verify($datosR["url"],$datosR["puesto"]))){
                    $data=$this->servicio->insertpermiso($result);
                    $code="200";
                    $message="Se guardo con éxito.";
                }else{
                    $code="400";
                    $message="Ya existe un registro";
                }
                break;
            case 2:
                $datosR = $this->input->post('id');
                $this->servicio->deletePermiso($datosR); 
                $code="200";
                $message="Se guardo con éxito.";
                break;
            case 3:
                $data=$this->servicio->getTablePermisos();
                $code="200";
                $message="Se guardo con éxito.";
                break;
            case 4:
                $datosR = json_decode($this->input->post('Data'), true);
                $result=array(
                    "id_url"=>$datosR["url"],
                    "id_puestoPersona"=>$datosR["puesto"],
                    "acciones"=>$datosR["permisos"]
                );
                $data=$this->servicio->actualizarPermisos($datosR["id"],$result);
                $code="200";
                $message="Se guardo con éxito.";
                break;
            
        }
        $this->responseJSON($code, $message, $data);
    }

    function partial_uri($start = 0) {
        return join('/',array_slice(get_instance()->uri->segment_array(), $start));
    }

    function Accionespermisos(){
        $id=$this->input->post('id_permiso');
        $data=array(
            "id_url"=>$this->input->post('id_url'),
            "id_puestoPersona"=>$this->input->post('id_persona'),
            "acciones"=>$this->input->post('acciones'),
        );
        if($id==0){
            if($data["acciones"]!=''){
                $this->servicio->insertpermiso($data);
            }
        }else{
            if($data["acciones"]!=''){
                $this->servicio->actualizarPermisos($id,$data);
            }else{
                $this->servicio->deletePermiso($id); 
            }
        }
        $this->responseJSON('200', "Exito", $data);
    }

    function getPermisos(){
       $url=$this->input->post('url');
       $puesto=$this->tank_auth->get_idPersona();
       $data=$this->servicio->getPermisosPuesto($puesto,$url);
       $code="200";$message="Exito";
       $this->responseJSON($code, $message, $data);
       //var_dump($url);
    }

    function getPermisosForm(){
        $url=$this->input->post('url');
        $puesto=$this->input->post('id_usuario');
        $data=$this->servicio->getPermisosPuesto($puesto,$url);
        $code="200";$message="Exito";
        $this->responseJSON($code, $message, $data);
        //var_dump($url);
     }
 

    function getUsers(){
        $id_puesto=$this->input->post('id_puesto');
        $filter=[];
        $datadb=$this->servicio->getEmpleados();
        foreach ($datadb as $key => $value) {
            if($value["puesto"]==$id_puesto){
                $filter[]=$value;
            }
        }
        //$data=$this->servicio->getPermisosPuesto($puesto,$url);
        $data=$filter;
        $code="200";$message="Exito";
        $this->responseJSON($code, $message, $data);
    }

    function getModulos(){
        $id_usuario=$this->input->post('id_usuario');
        $data=$this->servicio->getModulosPermisos($id_usuario);
        $code="200";$message="Exito";
        $this->responseJSON($code, $message, $data);
    }

    function CopyPermisos(){
        $id_usuario=$this->input->post('id_usuario');
        $id_usuario_copia=$this->input->post('id_usuario_copia');
        $dataper=$this->servicio->getpermisostabla($id_usuario);
        $Copy=[];
        foreach ($dataper as $key => $value) {
            $Copy[]=array(
                "id_url"=>$value["id_url"],
                "id_puestoPersona"=>$id_usuario_copia,
                "acciones"=>$value["acciones"]
            );
        }
        $this->servicio->CopyPermiso($Copy);
        $code="200";$message="Exito";
        $this->responseJSON($code, $message, []);

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
