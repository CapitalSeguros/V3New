<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Siniestro_catalogos extends TIC_Controller{
    
    function __construct()
    {
        parent::__construct();
        //$this->load->library(array('session'));
        //$this->load->helper('url');
        $this->load->model('siniestro_catalogo_model', 'scm');//modelo de gmm
        $this->load->model('danos_model', 'danos');
        $this->lang->load('tank_auth');
        $this->load->model('autos_model', 'autos'); //Dennis Castillo [2022-01-18]
        $this->load->model('gmm_model', 'gmm'); //Dennis Castillo [2022-01-18]
        $this->load->model('personamodelo','persona'); //Dennis Castillo [2022-01-18]
        $this->load->library('libreriav3'); //Dennis Castillo [2022-01-18]
        //$this->load->library('ws_sicas');
    }


    function Tipo_documento(){
        $head = array('title' => 'Capsys - GMM');
        $data = array();
        $footer = array();
        $this->breadcrumbs->unshift('Catalogos', 'Siniestro_catalogos');
        $this->breadcrumbs->unshift('Inicio', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $tipo=$this->input->get('tipo');
        $data["tipo"] = $this->returntipo($tipo);
        //$data["tipo"] = "C_siniestros";
        
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
          /*   array(
                'type' => 'JSHTML',
                'data' => "const _empleados = " . json_encode($empleados) . "; const _puestos = " . json_encode($_puestos) . ";"
            ), */
        ));
        $this->render('siniestro_catalogo/tipo_documento', $head, $data, $footer);
    }

    function getAllTiposDocumentos(){
        $code=200;
        $message="Exito";
        $data=$this->scm->getAllData('siniestro_tipo_documento');
        $this->responseJSON($code, $message, $data);
    }

    function AccionesTipoDocumento(){
        $code=200;
        $message="Exito";
        $id=$this->input->post('id');
        $data=array(
            'nombre'=>$this->input->post('Nombre'),
            'descripcion'=>$this->input->post('Descripcion')
        );
        if($id==0){
            if($this->scm->ExistName($data['nombre'],'siniestro_tipo_documento')){
                $this->scm->insertData($data,'siniestro_tipo_documento');
            }else{
                $code=400;
                $message="Ya existe un registro con el mismo nombre.";
            }
           
        }else{
            if($this->scm->ExistName($data['nombre'],'siniestro_tipo_documento')){
                $this->scm->updateData($id,$data,'siniestro_tipo_documento');
            }else{
                $code=400;
                $message="Ya existe un registro con el mismo nombre.";
            }
           
        }
        $this->responseJSON($code, $message, []);
    }

    function deleteTipoDoucumento(){
        $id = $this->input->post('id');
        $res=$this->scm->deleteData($id,'siniestro_tramite_documento');
        $this->responseJSON("200", "Éxito", $res);
    }

    function TramitesDocumentos($tipo=null){
        $head = array('title' => 'Capsys - GMM');
        $data = array();
        $footer = array();
        $this->breadcrumbs->unshift('Catalogos', 'Siniestro_catalogos');
        $this->breadcrumbs->unshift('Inicio', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $danos=$this->scm->getAllData('siniestro_tramite_danos');
        $gmm=$this->scm->getAllData('siniestro_tramite_gmm');
        $autos=$this->scm->getAllData('siniestro_tramite_autos');
        $documentos=$this->scm->getAllData('siniestro_tipo_documento');
        //$data["tipo"] = "C_siniestros";
        $data["tipo"] = $this->returntipo($tipo);
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
                'data' => "const _Danos = " . json_encode($danos) . "; const _GMM = " . json_encode($gmm) . ";"."const _Documentos = " . json_encode($documentos) . ";"
                ."const _Autos = " . json_encode($autos) . ";"
            ),
        ));
        $this->render('siniestro_catalogo/tramite_documento', $head, $data, $footer);
    }
    
    function getTableData($id){
        $code=200;
        $message="Exito";
        switch ($id) {
            case '1':
            break;
            case '2':
                $data=$this->scm->getAllDoucumentosTramites();
            break;
            case '3':
                //$data=$this->scm->getAllData('siniestro_tramite_danos');
                $data=$this->scm->getalltramitesD();
            break;
            case '4':
                $data=$this->scm->getAllData('siniestro_tramite_gmm');
            break;
            case '5':
                $data=$this->scm->getAllData('sininestro_causa_cerrar');
            break;
            case '6':
                $data=$this->scm->getCoberturasDanos();
            break;
            case '7':
                $data=$this->scm->getAllData('siniestro_tipo');
            break;
            case '8':
                $data=$this->scm->getcausasAutos();//getcausasAutos
            break;
            case '9':
                $data=$this->scm->getAllCoberturaGMM();
            break;
            default:
                $data=[];
            break;
        }
        $this->responseJSON($code, $message, $data);
    }

    function AccionesTramiteDocumento(){
        $code=200;
        $message="Exito";
        $id=$this->input->post('id');
        $data=array(
            "modulo"=>$this->input->post('modulo'),
            "id_tipo_documento"=>$this->input->post('documento'),
            "tramite"=>$this->input->post('tramite')
        );
        if($id==0){
            if($this->scm->ExistNameDocTramite($data['id_tipo_documento'],$data['tramite'],$data['modulo'])){
                $this->scm->insertData($data,'siniestro_tramite_documento');
            }else{
                $code=400;
                $message="Ya existe un registro con el mismo nombre.";
            }
            
        }else{
            if($this->scm->ExistNameDocTramite($data['id_tipo_documento'],$data['tramite'],$data['modulo'])){
                $this->scm->updateData($id,$data,'siniestro_tramite_documento');
            }else{
                $code=400;
                $message="Ya existe un registro con el mismo nombre.";
            }
            
        }
        $this->responseJSON($code, $message, $data);
    }


    function TiposTramitesDanos($tipo=null){
        $head = array('title' => 'Capsys - GMM');
        $data = array();
        $footer = array();
        $this->breadcrumbs->unshift('Catalogos', 'Siniestro_catalogos');
        $this->breadcrumbs->unshift('Inicio', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data["tipo"] = $this->returntipo($tipo);
        $tipos_tramites=$this->scm->getAllData('siniestro_tramite_danos');
        //$data["tipo"] = "C_siniestros";
        
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
                'data' => "let _Tram = " . json_encode($tipos_tramites) . ";"
            ),
        ));
        $this->render('siniestro_catalogo/tramites_danos', $head, $data, $footer);
    }

    function AccionesTramiteDanos(){
        $code=200;
        $message="Exito";
        $id=$this->input->post('id');
        $data=array(
            "nombre"=>$this->input->post('nombre'),
            "url"=>$this->input->post('icono'),
        );
        if($id==0){
            if($this->scm->ExistName($data['nombre'],'siniestro_tramite_danos')){
                $data["order"]=$this->danos->getmax()+1;
                $this->scm->insertData($data,'siniestro_tramite_danos');
            }else{
                $code=400;
                $message="Ya existe un registro con el mismo nombre.";
            }
           
        }else{
            //orignal del orcer a cambiar
            $original=$this->scm->getAfterchange($this->input->post('order'));
            //registro que se esta modificando 
            $new=$this->scm->getAfterchangeNombre($id);

            $data["order"]=$this->input->post('order');
            //actualizo el nuevo
            $this->scm->updateData($id,$data,'siniestro_tramite_danos');

            $original[0]["order"]=$new[0]["order"];
           $this->scm->updateData($original[0]["id"],$original[0],'siniestro_tramite_danos');
            
            /* if($this->scm->ExistName($data['nombre'],'siniestro_tramite_danos')){
                $original=$this->scm->getAfterchange($this->input->('order'));
                $this->scm->updateData($id,$data,'siniestro_tramite_danos');
            }else{
                $code=400;
                $message="Ya existe un registro con el mismo nombre.";
            } */
        }
        $resp=[];
        $resp["tramites"]=$this->scm->getAllData('siniestro_tramite_danos');
        $this->responseJSON($code, $message, $resp);
    }

    function deleteTramiteDanos(){
        $id = $this->input->post('id');
        $dataAfterD=$this->scm->getAfterchangeNombre($id);
        $orderDelete=$dataAfterD[0]["order"];
        $datachange=$this->scm->getAllDeletetipos($dataAfterD[0]["order"]);

        foreach ($datachange as $key => $value) {
            $value["order"]=$orderDelete;
            $this->scm->updateData($value["id"],$value,'siniestro_tramite_danos');
            $orderDelete++;
        }
        $res=$this->scm->deleteDataTramites($id,array("delete"=>1));
        //$res=$this->scm->deleteData($id,'siniestro_tramite_danos');
        $this->responseJSON("200", "Éxito", $datachange);
    }

    function TiposTramitesGmm($tipo=null){
        $head = array('title' => 'Capsys - GMM');
        $data = array();
        $footer = array();
        $this->breadcrumbs->unshift('Catalogos', 'Siniestro_catalogos');
        $this->breadcrumbs->unshift('Inicio', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data["tipo"] = $this->returntipo($tipo);
        //$data["tipo"] = "C_siniestros";
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
            
        ));
        $this->render('siniestro_catalogo/tramites_gmm', $head, $data, $footer);
    }

    function AccionesTramiteGmm(){
        $code=200;
        $message="Exito";
        $id=$this->input->post('id');
        $data=array(
            "nombre"=>$this->input->post('nombre'),
            //"url"=>$this->input->post('icono'),
        );
        if($id==0){
            if($this->scm->ExistName($data['nombre'],'siniestro_tramite_gmm')){
                $this->scm->insertData($data,'siniestro_tramite_gmm');
            }else{
                $code=400;
                $message="Ya existe un registro con el mismo nombre.";
            }
           
        }else{
            $this->scm->updateData($id,$data,'siniestro_tramite_gmm');
        }
        $this->responseJSON($code, $message, $data);
    }

    function deleteTramiteGmm(){
        $id = $this->input->post('id');
        $res=$this->scm->deleteData($id,'siniestro_tramite_gmm');
        $this->responseJSON("200", "Éxito", $res);
    }

    function Siniestro_causa_cierre($tipo=null){
        $head = array('title' => 'Capsys - GMM');
        $data = array();
        $footer = array();
        $this->breadcrumbs->unshift('Catalogos', 'Siniestro_catalogos');
        $this->breadcrumbs->unshift('Inicio', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data["tipo"] = $this->returntipo($tipo);
        //$data["tipo"] = "C_siniestros";
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
            
        ));
        $this->render('siniestro_catalogo/siniestro_cierre', $head, $data, $footer);
    }

    function AccionesSiniestroCausa(){
        $code=200;
        $message="Exito";
        $id=$this->input->post('id');
        $data=array(
            'nombre'=>$this->input->post('Nombre'),
            'descripcion'=>$this->input->post('Descripcion')
        );
        if($id==0){
            if($this->scm->ExistName($data['nombre'],'sininestro_causa_cerrar')){
                $this->scm->insertData($data,'sininestro_causa_cerrar');
            }else{
                $code=400;
                $message="Ya existe un registro con el mismo nombre.";
            }
            
        }else{
            if($this->scm->ExistName($data['nombre'],'sininestro_causa_cerrar')){
                $this->scm->updateData($id,$data,'sininestro_causa_cerrar');
            }else{
                $code=400;
                $message="Ya existe un registro con el mismo nombre.";
            }
           
        }
        $this->responseJSON($code, $message, []);
    }

    
    function deleteSiniestroCausa(){
        $id = $this->input->post('id');
        $res=$this->scm->deleteData($id,'sininestro_causa_cerrar');
        $this->responseJSON("200", "Éxito", $res);
    }

    function TipoCoberturaDanos($tipo=null){
        $head = array('title' => 'Capsys - GMM');
        $data = array();
        $footer = array();
        $this->breadcrumbs->unshift('Catalogos', 'Siniestro_catalogos');
        $this->breadcrumbs->unshift('Inicio', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data["tipo"] = $this->returntipo($tipo);
        //$data["tipo"] = "C_siniestros";
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
            
        ));
        $this->render('siniestro_catalogo/coberturadanos', $head, $data, $footer);
    }

    function AccionesTramiteCDanos(){
        $code=200;
        $message="Exito";
        $id=$this->input->post('id');
        $data = array(
            "nombre" => $this->input->post('Nombre'),
            "descripcion" => $this->input->post('Descripcion'),
            "Tipo"=>"DAÑOS",
            "tipo_c"=>$this->input->post('tipo')
        );
        if($id==0){
            if($this->scm->ExistNameAndTipo($data['nombre'],$data['tipo_c'],'tipo_coberturas_gmm')){
                $this->scm->insertData($data,'tipo_coberturas_gmm');
            }else{
                $code=400;
                $message="Ya existe un registro con el mismo nombre y tipo.";
            }
           
        }else{
            if($this->scm->ExistNameAndTipo($data['nombre'],$data['tipo_c'],'tipo_coberturas_gmm')){
                $this->scm->updateData($id,$data,'tipo_coberturas_gmm');
            }else{
                $code=400;
                $message="Ya existe un registro con el mismo nombre y tipo.";
            }
           
        }
        $this->responseJSON($code, $message, $data);
    }

    function SiniestroTipoAutos($tipo=null){
        $head = array('title' => 'Capsys - Catálogos');
        $data = array();
        $footer = array();
        $this->breadcrumbs->unshift('Catálogos', 'Siniestro_catalogos');
        $this->breadcrumbs->unshift('Inicio', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        //$data["tipo"] = "C_siniestros";
        $data["tipo"] = $this->returntipo($tipo);
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
            
        ));
        $this->render('siniestro_catalogo/autos_tipos', $head, $data, $footer);
    }

    function AccionesTipoAutos(){
        $code=200;
        $message="Exito";
        $id=$this->input->post('id');
        $data=array(
            'nombre'=>$this->input->post('Nombre'),
            'id'=>$this->scm->getLastidTipo()+1
        );
        if($id==0){
            if($this->scm->ExistName($data['nombre'],'siniestro_tipo')){
                $this->scm->insertData($data,'siniestro_tipo');
            }else{
                $code=400;
                $message="Ya existe un registro con el mismo nombre.";
            }
            
        }else{
            if($this->scm->ExistName($data['nombre'],'siniestro_tipo')){
                $this->scm->updateData($id,$data,'siniestro_tipo');
            }else{
                $code=400;
                $message="Ya existe un registro con el mismo nombre.";
            }
           
        }
        $this->responseJSON($code, $message, []);
    }


    function deleteTiposAutos(){
        $id = $this->input->post('id');
        $res=$this->scm->deleteData($id,'siniestro_tipo');
        $this->responseJSON("200", "Éxito", $res);
    }

    
    function SiniestroCausaAutos($tipo=null){
        $head = array('title' => 'Capsys - Catálogos');
        $data = array();
        $footer = array();
        $this->breadcrumbs->unshift('Catálogos', 'Siniestro_catalogos');
        $this->breadcrumbs->unshift('Inicio', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        //$data["tipo"] = "C_siniestros";
        $data["tipo"] = $this->returntipo($tipo);
        $data['TiposA']=$this->scm->getAllData('siniestro_tipo');
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
            
        ));
        $this->render('siniestro_catalogo/autos_causas', $head, $data, $footer);
    }

    function AccionesCausasAutos(){
        $code=200;
        $message="Exito";
        $id=$this->input->post('id');
        $data = array(
            "nombre" => $this->input->post('Nombre'),
            "id"=>$this->scm->getLastidCausa()+1,
            "tipo_siniestro_id"=> $this->input->post('Tipo')
        );
        if($id==0){
            if($this->scm->ExistCausa($data['tipo_siniestro_id'],$data['nombre'])){
                $this->scm->insertData($data,'siniestro_causa');
            }else{
                $code=400;
                $message="Ya existe un registro con el mismo nombre y tipo.";
            }
           
        }else{
            if($this->scm->ExistCausa($data['tipo_siniestro_id'],$data['nombre'])){
                $this->scm->updateData($id,$data,'siniestro_causa');
            }else{
                $code=400;
                $message="Ya existe un registro con el mismo nombre y tipo.";
            }
           
        }
        $this->responseJSON($code, $message, $data);
    }

    function deleteCausaAutos(){
        $id = $this->input->post('id');
        $res=$this->scm->deleteData($id,'siniestro_causa');
        $this->responseJSON("200", "Éxito", $res);
    }

    function Coberturas_GMM($tipo=null){
        $head = array('title' => 'Capsys - Coberturas GMM');
        $data = array();
        $footer = array();
        $this->breadcrumbs->unshift('Catálogos', 'Siniestro_catalogos');
        $this->breadcrumbs->unshift('Inicio', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data["tipo"] = $this->returntipo($tipo);
        //$data["tipo"] = "C_siniestros";
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
            
        ));
        $this->render('siniestro_catalogo/cobertura_gmm', $head, $data, $footer);
    }

    function AccionesTramiteCGMM(){
        $code=200;
        $message="Exito";
        $id=$this->input->post('id');
        $data = array(
            "nombre" => $this->input->post('Nombre'),
            //"id"=>$this->scm->getLastidCausa()+1,
            //"tipo_siniestro_id"=> $this->input->post('Tipo')
        );
        if($id==0){
            if($this->scm->ExistName($data['nombre'],'siniestro_gmm_cobertura')){
                $this->scm->insertData($data,'siniestro_gmm_cobertura');
            }else{
                $code=400;
                $message="Ya existe un registro con el mismo nombre.";
            }
            
        }else{
            if($this->scm->ExistName($data['nombre'],'siniestro_gmm_cobertura')){
                $this->scm->updateData($id,$data,'siniestro_gmm_cobertura');
            }else{
                $code=400;
                $message="Ya existe un registro con el mismo nombre.";
            }
           
        }
        $this->responseJSON($code, $message, $data);
    }

    function deleteTipoCoberturaGMM(){
        $id = $this->input->post('id');
        $res=$this->scm->deleteData($id,'siniestro_gmm_cobertura');
        $this->responseJSON("200", "Éxito", $res);
    }

    function siniestro_estatus(){
        $head = array('title' => 'Capsys - GMM');
        $data = array();
        $footer = array();
        $this->breadcrumbs->push('Estatus de siniestros', 'Bonos');
        $this->breadcrumbs->unshift('Inicio', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $tipo=$this->input->get('tipo');
        $data["tipo"] = $this->returntipo($tipo);


        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            )
            
        ));
        $this->footerScripts(array(
        ));
        $this->render('GMM/estatus', $head, $data, $footer);

    }

    function Padecimientos($tipo=null){
        $head = array('title' => 'Capsys - Bonos');
        $data = array();
        $footer = array();
        $this->breadcrumbs->push('Tipos de cobertura', 'Bonos');
        $this->breadcrumbs->unshift('Inicio', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data["tipo"] = $this->returntipo($tipo);
        //$data["tipo"] = "C_siniestros";
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
        ));
        $this->render('GMM/TiposGMM', $head, $data, $footer);
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
            $return="C_siniestros";
                # code...
                break;
        }
        return $return;
    }

    //------------------------- //Dennis Castillo [2022-01-18]
    function getMyNotes(){

        //$notesForType = $this->getNotesForType($_GET["tipo"]);
        $notesForType = $this->getNotesFiltered($_GET["tipo"]);
        $myNotes = array();
        
        if(!empty($notesForType)){

            foreach($notesForType as $dn){
                $myNotes[date("d-m-Y", strtotime($dn->dateCreate))][] = $dn;
            }
        }

        $data["tipo"] = $this->returntipo($_GET["tipo"]);
        $data["notes"] = $myNotes;
        //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($data, TRUE));fclose($fp);
        $this->load->view("siniestros/claimsnotes", $data);
    }
    //------------------------- //Dennis Castillo [2022-01-18]
    function getNotesFiltered($type_r){

        $response = $this->getNotesForType($type_r);
        $perId = $this->tank_auth->get_idPersona();
        $filter = array_filter($response, function($arr) use($type_r, $perId){

            return $arr->tipo_r == $type_r && $arr->idPersona == $perId;
        });

        return array_values($filter);
    }
    //------------------------- //Dennis Castillo [2022-01-18]
    function getNotesForType($type_r){

        $response = array();
        switch($type_r){
            case "A": $response = $this->autos->getAllDataNote(null);
            break;
            case "D": $response = $this->danos->getAllDataNote(null);
            break;
            case "G": $response = $this->gmm->getAllDataNote(null);
            break;
            //case "S": $response = $this->gmm->getAllDataNote(null);
            //break;
        }

        return $response;
    }
    //------------------------- //Dennis Castillo [2022-01-18]
    function editNoteOfSinister($controller, $idNote){

        $head = array();
        $footer = array();
        $notes = array();
        $getNotes = $this->getNotesForType($controller);
        $dataFiltered =  array_filter($getNotes, function($arr) use($controller, $idNote){

            return $arr->tipo_r == $controller && $arr->id == $idNote;
        });

        foreach($dataFiltered as $dn){

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
        $data["notes"]["agentsToAssing"] = $this->libreriav3->agrupaPersonasParaSelect($this->persona->obtenerPersonas("SISTEMAS@ASESORESCAPITAL.COM",3)); //array();//$tram_autos;
        //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($data, TRUE));fclose($fp);
        $this->render('siniestros/editNoteOfSinister', $head, $data, $footer);
    }
    //-------------------------



}