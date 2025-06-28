<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Danos extends TIC_Controller{

    function __construct()
    {
        parent::__construct();
        //$this->load->library(array('session'));
        //$this->load->helper('url');
        $this->load->model('danos_model', 'danos');//modelo de gmm
        $this->load->library(array('form_validation', 'JbUpload'));
        $this->load->library('googledrive');
        $this->load->model("documentsmodel", "documento");
        $this->load->library('ws_sicas');
        $this->load->model("graficas_model", "kpi"); //Dennis Castillo [2022-01-17]
        $this->load->model('personamodelo','persona'); //Dennis Castillo [2022-01-14]
        $this->load->library('libreriav3'); //Dennis Castillo [2022-01-14]
    }

    //pagina de inicio de GMMM
    function index(){
        $head = array('title' => 'Capsys - Daños');
        $data = array();
        $footer = array();
        $this->breadcrumbs->push('Registros Daños', 'Bonos');
        $this->breadcrumbs->unshift('Inicio', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $documentos=$this->danos->getDocuments();
        $tipos_tramites=$this->danos->getTramitesDanos();
        $estatus=$this->danos->getStatus();
        $actualyears=$this->danos->getYearsDocs();
        $FechaFin=true;
        $data['FechaFin']=true;
        $data["tipo"] = "C_DANOS";
        $data["idNotificacion"]=$this->input->get('registro');
        //listado de las aseguradoras
        $aseguradoras=$this->danos->getAseguradoras('D');

        //Requisitos para las notas del siniestros //Dennis Castillo [2022-01-18]
        $data["notes"]["agentsToAssing"] = $this->libreriav3->agrupaPersonasParaSelect($this->persona->obtenerPersonas("SISTEMAS@ASESORESCAPITAL.COM",3)); //array();//$tram_autos;

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
                'data' => "const _estatus = " . json_encode($estatus) . ";"."const _Documents = " . json_encode($documentos) . ";"."const _Tram = " . json_encode($tipos_tramites) . ";"
                ."const _years = " . json_encode($actualyears) . ";"."const _FechaFin = " . json_encode($FechaFin) . ";"."const _Aseguradoras = " . json_encode($aseguradoras) . ";"
            ),
        ));
        $this->render('Daños/danos', $head, $data, $footer);
    }

    //funcion pára obtener los registros de GMM
    function getDanos(){
        /* $code=200;
        $message="Exito";
        $data=$this->danos->getAllDanos(); */
        $id=null;
        $year='0';
        if($this->input->post('id')){
            $id=$this->input->post('id');
            //$year=$this->input->post('year');
            if($id=='TODOS'){
                $id='0';
            }
        }else{
            //$year=date('Y');
            $id='0';
        }
        $code=200;
        $message="Exito". "id->".$id. " Año->".$year;
        $data=$this->danos->getAllDanos($id,$year,null,$this->tank_auth->get_IDVend());
        //$data=$this->danos->getAllDanos($id,$year);
        $this->responseJSON($code, $message, $data);
    }

    //Acciones para los registros de GMM
    function AccionesDanos(){
        $id=$this->input->post('id');
        $id_sin=$this->input->post('numero_siniestro');
        $Npoliza=$this->input->post('numero_poliza');
        //$nombre=$this->input->post('nombre_a')." ".$this->input->post('apellido_p')." ".$this->input->post('apellido_m');
        $dataS = array(
            'cabina_id' => '',
            'ajustador_nombre' => $this->input->post('nombre_coordinador'),
            'siniestro_id' => $this->input->post('numero_siniestro'),
            'poliza' => $this->input->post('numero_poliza'),
            'certificado' => $this->input->post('inciso_p'),
            'asegurado_nombre' => $this->input->post('nombres'),
            'estado_id' => $this->input->post('estado'),
            'inicio_ajuste' => date("Y-m-d H:i", strtotime($this->input->post('fecha_aviso'))),
            'siniestro_estatus'=>"ACTIVO",
            'fecha_ocurrencia'=>$this->input->post('fecha_ocurrencia'),
            //'tipo_r'=>'G',
            'agregado_por'=>$this->tank_auth->get_idPersona(),
            'siniestro_estatus'=>"ACTIVO",
            'tipo_r'=>'D',
            'id_tipo_d'=>$this->input->post('cobertura_id'),
            'status_id'=>1,
            'id_sicas_cliente'=>$this->input->post('idsicascliente'),
            'id_sicas_vendedor'=>$this->input->post('idsicasvendedor'),
            'aseguradora_id'=>$this->input->post('aseguradora_id'),
            'complemento_json'=>json_encode(
                array(
                    "general"=>array(
                        'siniestro_id' => $this->input->post('numero_siniestro'),
                        'num_reporte' => $this->input->post('numero_reporte'),
                        'responsable' => $this->input->post('responsable'),
                        'persona_reporta' => $this->input->post('persona_reporta'),
                        'numero_reporta' => $this->input->post('numero_reporta'),
                        'direccion'=>$this->input->post('direccion'),
                        'descripcion_afectado' => $this->input->post('descripcion_afectado'),
                        'inciso' => $this->input->post('inciso_a'),
                        'riesgo_id' => $this->input->post('cobertura_id'),
                        'riesgo_nombre' => "",
                        'tipo_p'=>$this->input->post('tipo_poliza'),
                        'concepto'=> $this->input->post('concepto')
                    ),
                    "cordinador"=>array(
                        'nombre_coordinador' => $this->input->post('nombre_coordinador'),
                        'telefono_coordinador' => $this->input->post('telefono_coordinador'),
                        'correo_coordinador' =>$this->input->post('correo_coordinador'), 
                    ),
                )
            )
        );
        $poliza=array(
            "poliza"=>$this->input->post('numero_poliza'),
            "data_poliza"=>$this->input->post('json_poliza')
        );
        if($id==0){
            if($this->danos->ExistSiniestro($id_sin,$Npoliza)){
                 $id_inserted=$this->danos->insertSiniestro($dataS);
                if(!$this->danos->existPoliza($this->input->post('numero_poliza'))){
                    $this->danos->insert_poliza($poliza);
                }
                $this->responseJSON('200', "Exito", []);
            }else{
               
                $this->responseJSON('400', "Ya existe un registro con el número de siniestro", []);
            }
            
        }else{
            $this->danos->updateSiniestro($id,$dataS);
            $this->responseJSON('200', "Exito", []);
        }
        /* if($id==0){
            $id_inserted=$this->danos->insertSiniestro($dataS);
            if(!$this->danos->existPoliza($this->input->post('numero_poliza'))){
                $this->danos->insert_poliza($poliza);
            }

        }else{
            $this->danos->updateSiniestro($id,$dataS);
            $this->responseJSON(200, "Exito", $id);
        } */
    }

    //formulario para agregar GMMM
    function RegistroDanos($id=null){
        $head = array('title' => 'Capsys - Daños');
        $data = array();
        $footer = array();
        $this->breadcrumbs->push('Siniestros Daños', 'Bonos');
        $this->breadcrumbs->unshift('Daños', 'Danos');
        $this->breadcrumbs->unshift('Inicio', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['titulo']=$id==NULL?'Nuevo':'Editar';
        ///$data['registro']=$this->danos->getResgistroDanos($id);
        $data['registro']=$this->danos->getSiniestroPoliza($id==null?0:$id);
        //$data['coberturas']=$this->danos->getCoberturasDanos();
        $coberturas=$this->danos->getCoberturasDanos();
        $data['estados']=$this->danos->getEstados();
        $data['usuario']=$this->tank_auth->get_usernamecomplete();

        //Carga de los datos del directorio
        $documento=$this->input->get('documento');
        if($documento){
            $resultado=[];
            $res=$this->ws_sicas->Polizas_Documento($documento);
            if(isset($res->TableInfo)){
                $resultado=$res;
            }else{
                $object = new stdClass();
                $object->TableInfo=[];
                $resultado=$object;
            }
            $data['Poliza_Carga']=$resultado;
        }

        ///fin de la craga del directorio

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
                'data' => "const _Coberturas = " . json_encode($coberturas) 
            ),
        ));
        $this->render('Daños/formulario_danos', $head, $data, $footer);
    }



    //sirve para agregar un nuevo tipo de tramite
    function nuevoTramite(){
        $id_siniestro=$this->input->post('id_siniestro');
        $id_tramite=$this->input->post('id_tramite');
        $fecha_inicio=$this->input->post('inicio_tramite');
        
        //añadir seguimiento fin
        $dataSegumiento=array(
            "referencia"=>"DANOS",
            "referencia_id"=>$id_siniestro,
            "fecha"=>date("Y-m-d"),
            "usuario_id"=>$this->tank_auth->get_idPersona(),
            "fecha_alta"=>date("Y-m-d H:i:s"),
            "comentario"=>'SE CERRO EL TRÁMITE',
            "tramite_id"=>$this->input->post('id_tramite'),
            "estatus_id"=>3,
        );
       
        if($id_tramite!=0){
            $this->danos->addSeguimiento($dataSegumiento);
        }
        /* $data=array(
            "id_siniestro"=>$this->input->post('id_siniestro'),
            "fecha_inicio"=>date('Y-m-d', strtotime($this->input->post('inicio_tramite'))),
            "descripcion"=>$this->input->post('descripcion'),
            "tipo_tramite"=>$this->input->post('tipo_tramite'),
            "estatus"=>"1",
        ); */
        $orderTipo=$this->input->post('tipo_tramite');
        $tipo=$this->input->post('opcion');
        $data=array(
            "id_siniestro"=>$this->input->post('id_siniestro'),
            "fecha_inicio"=>$fecha_inicio,
            "descripcion"=>$this->input->post('descripcion'),
            //"tipo_tramite"=>$this->input->post('tipo_tramite'),
            "tipo_tramite"=>$this->danos->getIdTipotramite($orderTipo),
            "estatus"=>"1",
        );
        
        /* if($data['tipo_tramite']<=10){
            $inset_id=$this->danos->insertTramite($data);
            $dataSegumiento['referencia_id']=$id_siniestro;
            $dataSegumiento['comentario']=$this->input->post('descripcion');
            $dataSegumiento['estatus_id']=1;
            $dataSegumiento['tramite_id']=$inset_id;
            $this->danos->addSeguimiento($dataSegumiento);
            //$inset_id=$this->danos->insertTramite($data);
        } */
        
        $maxval=$this->danos->getmax();
        if($orderTipo<=$maxval){
            $inset_id=$this->danos->insertTramite($data);
            $dataSegumiento['referencia_id']=$id_siniestro;
            $dataSegumiento['comentario']=$this->input->post('descripcion');
            $dataSegumiento['estatus_id']=1;
            $dataSegumiento['tramite_id']=$inset_id;
            $this->danos->addSeguimiento($dataSegumiento);
            $data["test"]=array(
                "tipo_t"=>$orderTipo,
                "maxvalue"=>$maxval
            );
            //$inset_id=$this->danos->insertTramite($data);
        }
        $dataS=array("fecha_fin"=>$fecha_inicio,"estatus"=>3);
        $this->danos->updateTramite($id_tramite,$dataS);
        if($orderTipo>$maxval){
            $data["test"]=array(
                "tipo_t"=>$orderTipo,
                "maxvalue"=>$maxval
            );
            //$this->danos->updateSiniestro($data['id_siniestro'],array('siniestro_estatus'=>"FINIQUITADO",'status_id'=>3,'fecha_fin'=>date('Y-m-d')));
        }
        //$this->incidencia->db->trans_begin();
        $result = new \stdClass;
        $result->ok = true;
    
        if (!empty($_FILES)) {
            $keys=array_keys($_FILES);
            $finalRef = $this->createReferenciaFolder('DANOS_', '');
            $padre = $finalRef->getId();
            //$inset_id=12;
            $folder = $this->googledrive->createFolder('DANOS_'.$inset_id, $padre);
            $count=0;
            foreach ($_FILES as $file) {
                $uploadFile = $this->googledrive->createFiles($file, $keys[$count], 'documentación del registro', $folder->data->getId());
                $this->saveDoc($uploadFile->data, '', 'DANOS_', $inset_id, []);
                $count++;
            }
            $result->ok = true;
        }//fin upload
        if ($result->ok === false) {
            $this->responseJSON("400", "Ocurrio un error al guardar la información", []);
        } else {
            $this->responseJSON("200", "Se guardo con Éxito", $data);
        }
        
    }

    function nuevoTramite2(){
        $id_siniestro=$this->input->post('id_siniestro');
        $id_tramite=$this->input->post('id_tramite');
        //añadir seguimiento fin
        $dataSegumiento=array(
            "referencia"=>"DANOS",
            "referencia_id"=>$id_siniestro,
            "fecha"=>date("Y-m-d"),
            "usuario_id"=>$this->tank_auth->get_idPersona(),
            "fecha_alta"=>date("Y-m-d H:i:s"),
            "comentario"=>'SE CERRO EL TRÁMITE',
            "tramite_id"=>$this->input->post('id_tramite'),
            "estatus_id"=>3,
        );
       
        if($id_tramite!=0){
            $this->danos->addSeguimiento($dataSegumiento);
        }
        $orderTipo=$this->input->post('tipo_tramite');
        $tipo=$this->input->post('opcion');
        $data=array(
            "id_siniestro"=>$this->input->post('id_siniestro'),
            "fecha_inicio"=>date('Y-m-d'),
            "descripcion"=>$this->input->post('descripcion'),
            //"tipo_tramite"=>$this->input->post('tipo_tramite'),
            "tipo_tramite"=>$this->danos->getIdTipotramite($orderTipo),
            "estatus"=>"1",
        );
        $maxval=$this->danos->getmax();
        if($orderTipo<=$maxval){
            $inset_id=$this->danos->insertTramite($data);
            $dataSegumiento['referencia_id']=$id_siniestro;
            $dataSegumiento['comentario']=$this->input->post('descripcion');
            $dataSegumiento['estatus_id']=1;
            $dataSegumiento['tramite_id']=$inset_id;
            $this->danos->addSeguimiento($dataSegumiento);
            //$inset_id=$this->danos->insertTramite($data);
        }
        $dataS=array("fecha_fin"=>date('Y-m-d'),"estatus"=>3);
        $this->danos->updateTramite($id_tramite,$dataS);
        if($orderTipo>$maxval){
            $this->danos->updateSiniestro($data['id_siniestro'],array('siniestro_estatus'=>"FINIQUITADO",'status_id'=>3,'fecha_fin'=>date('Y-m-d')));
        }
        //$this->incidencia->db->trans_begin();
        $result = new \stdClass;
        $result->ok = true;
    
        if (!empty($_FILES)) {
            $keys=array_keys($_FILES);
            $finalRef = $this->createReferenciaFolder('DANOS_', '');
            $padre = $finalRef->getId();
            //$inset_id=12;
            $folder = $this->googledrive->createFolder('DANOS_'.$inset_id, $padre);
            $count=0;
            foreach ($_FILES as $file) {
                $uploadFile = $this->googledrive->createFiles($file, $keys[$count], 'documentación del registro', $folder->data->getId());
                $this->saveDoc($uploadFile->data, '', 'DANOS_', $inset_id, []);
                $count++;
            }
            $result->ok = true;
        }//fin upload
        if ($result->ok === false) {
            $this->responseJSON("400", "Ocurrio un error al guardar la informaciÉn", []);
        } else {
            $this->responseJSON("200", "Se guardo con Éxito", $data);
        }
        
    }

    function ChangeEstatus(){
        $id=$this->input->post('id');
        $id_estatus=$this->input->post('estatus');
        $numEvento=$this->input->post('numEvento');
        $fecha=$this->input->post('fecha_fin');
        $id_siniestro=$this->input->post('id_siniestro');
        //$tramite=$this->input->post('tramite');
        $data=array(
            "estatus"=>$id_estatus,
        );
        $dataSegumiento=array(
            "referencia"=>"DANOS",
            "referencia_id"=>$this->input->post('id_siniestro'),
            "fecha"=>date("Y-m-d"),
            "usuario_id"=>$this->tank_auth->get_idPersona(),
            "fecha_alta"=>date("Y-m-d H:i:s"),
            "comentario"=>$this->input->post('comentario'),
            "estatus_id"=>$id_estatus,
            "tramite_id"=>$id
        );
        
        $closedEstatus=array("3","4","5");
        if(in_array($id_estatus,$closedEstatus)){//$id_estatus==3
            $data['fecha_fin']=$fecha!=''?$fecha:date("Y-m-d");
        }
        /* if($id_estatus==3){
            //$data['fecha_fin']=date("Y-m-d");
            $data['fecha_fin']=$fecha!=''?$fecha:date("Y-m-d");
        } */
        if($id_estatus==6){
            $datalog=array(
                "fecha_inicio"=>date("Y-m-d"),
                "estatus"=>6,
                "id_registro"=>$id,
                "id_siniestro"=>$id_siniestro
            );
            $this->danos->insertLogDormido($datalog);
        }
        if($id_estatus!=6){
            $datauplog=array(
                "fecha_fin"=>date("Y-m-d")
            );
            $this->danos->updateTramitelog($id,$datauplog);
        }

        $this->danos->updateTramite($id,$data);
        $maxval=$this->danos->getmax();
        if($numEvento==$maxval){
            $this->danos->updateSiniestro($this->input->post('id_siniestro'),array('siniestro_estatus'=>"FINIQUITADO",'status_id'=>3,'fecha_fin'=>$data['fecha_fin']));
        }
        //$this->danos->addSeguimiento($dataSegumiento);
        $this->responseJSON("200", "Se guardo con Éxito", []);
        //echo $this->input->post('id');
    }

    function getAllTramites(){
        $id=$this->input->post('id');
        //$data=$this->danos->getTramites($id);
        $data["siniestro"]=$this->danos->getSiniestroPoliza($id);
        //$data["tramites"]=$this->danos->getTramites($id);
        $tram=$this->danos->getTramites($id);
        $dataTram=[];
        foreach ($tram as $key => $value) {
            $dta=array(
                "info"=>$value,
                "documentos"=>$this->danos->getAllDocumentTramites($value['id'])
            );
            $dataTram[]=$dta;
        }
        $data["tramites"]=$dataTram;
        $data["SeguimientoGeneral"]=$this->danos->getSeguimientogeneral($id);
        $this->responseJSON("200", "Se guardo con Éxito",$data);
    }


        ///Subir los archivos al drive
        private function createReferenciaFolder($referencia, $referencia_id)
        {
            $finalReference = null;
            $folReferencia = null;
            $folReferenciaId = null;
            $exist_ref = $this->googledrive->searchfile(array("name" => $referencia));
    
            if (count($exist_ref->data) == 0) {
                $folReferencia = $this->googledrive->createFolder($referencia);
    
                if ($folReferencia->exito) {
                    //$this->saveDoc($folReferencia->data, false, $referencia);
                    $folReferencia = $folReferencia->data;
                } else {
                    $this->responseJSON("400", $folReferencia->mensaje, null);
                    die;
                }
            } else {
                $folReferencia = $exist_ref->data[0];
            }
    
            if (!empty($referencia_id)) {
                $exist_ref_id = $this->googledrive->searchfile(array("name" => $referencia_id, "parents" => $folReferencia->getId()));
                if (count($exist_ref_id->data) == 0) {
                    $folReferenciaId = $this->googledrive->createFolder($referencia_id, $folReferencia->getId());
                    if ($folReferenciaId->exito) {
                        //$this->saveDoc($folReferenciaId->data, false, $referencia, $referencia_id);
                        $folReferenciaId = $folReferenciaId->data;
                    }
                } else {
                    $folReferenciaId = $exist_ref_id->data[0];
                }
            }
    
            if ($folReferenciaId != null) {
                $finalReference = $folReferenciaId;
            } else {
                $finalReference = $folReferencia;
            }
    
            return $finalReference;
        }
        
        //Funcion para añadir los archvios a la DB
        private function saveDoc($file, $privado, $referencia, $referencia_id = 0, $puestos = [])
        {
            $data = array(
                'nombre' => basename($file->getName()),//
                'descripcion' => $file->getDescription(),//
                'ruta' => $file->getWebViewLink(),//
                'ruta_completa' => $file->getWebContentLink(),//
                'tipo' => $file->getMimeType(),//
                'nombre_completo' => $file->getName(),//
                'revision' => '0',//
                'referencia' => $referencia,//
                'referencia_id' => $referencia_id,//
                'usuario_alta_id' => $this->tank_auth->get_idPersona(),//
                'parent_id' => count($file->getParents()) > 0 ? $file->getParents()[0] : "",
    
                'file_id' => $file->getId(),//
                'tamanio' => $file->getSize(),
                'url_icono' => $file->getIconLink(),
                'url_descargar' => $file->getWebContentLink(),
                'thumbnail_link' => $file->getThumbnailLink(),
                'fecha_alta' => date("Y-m-d H:i:s"),//
                //'privado' => $privado == "true" ? 1 : 0,
                'estado' => 'ACTIVO'//
            );
            $result =  $this->documento->saveDocument($data);
        }

        function getSeguimiento(){
            $id=$this->input->post('id');
            $data=$this->danos->getSeguimiento($id);
            $this->responseJSON("200", "Se guardo con Éxito", $data);
        }


        function NuevoComentario(){
            $id_siniestro=$this->input->post('id_siniestro_c_t');
            $id_estatus=$this->input->post('id_esttram_c_t');
            $idtramite=$this->input->post('id_tramite_c_t');
            $tipo_tram=$this->input->post('id_tipotram_c_t');
            $dataSegumiento=array(
                "referencia"=>"DANOS",
                "referencia_id"=>$id_siniestro,
                "fecha"=>date("Y-m-d H:i:s"),
                "usuario_id"=>$this->tank_auth->get_idPersona(),
                "fecha_alta"=>date("Y-m-d H:i:s"),
                "comentario"=>$this->input->post('comentario_s_t'),
                "estatus_id"=>$id_estatus?$id_estatus:null,
                "tramite_id"=>$idtramite?$idtramite:null,
                "causa_id"=>$tipo_tram?$tipo_tram:null
            );
            $this->danos->addSeguimiento($dataSegumiento);
            $data=array();
            $data['SeguimientoGeneral']=$this->danos->getSeguimientogeneral($id_siniestro);
            $this->responseJSON("200", "Se guardo con Éxito", $data);

        }

        
        function testD (){
           $algo=$this->danos->getmax();
           var_dump($algo);
        }

        function idtestSicas(){
            //var_dump($this->danos->testpruebaids());
            $datatest=$this->danos->testpruebaids();
            foreach ($datatest as $key => $value) {
                $dtap=json_decode($value["data_poliza"],true);
                $id=$value["id"];
                echo "id-user=> ".$dtap["IDCli"].", id_verndedor=> ".$dtap["IDVend"];
                echo "<br>";
                $dataup=array(
                    "id_sicas_cliente"=>$dtap["IDCli"],
                    "id_sicas_vendedor"=>$dtap["IDVend"]
                );

                $this->danos->updateSiniestro($id,$dataup);
            }
        }

        function updateDocumentos(){
            $inset_id=$this->input->post('id');
            $result = new \stdClass;
            $result->ok = true;
    
            if (!empty($_FILES)) {
                $keys=array_keys($_FILES);
                $finalRef = $this->createReferenciaFolder('DANOS_', '');
                $padre = $finalRef->getId();
                //$inset_id=12;
                $folder = $this->googledrive->createFolder('DANOS_'.$inset_id, $padre);
                $count=0;
                foreach ($_FILES as $file) {
                    $uploadFile = $this->googledrive->createFiles($file, $keys[$count], 'documentación del registro', $folder->data->getId());
                    $this->saveDoc($uploadFile->data, '', 'DANOS_', $inset_id, []);
                    $count++;
                }
                $result->ok = true;
            }//fin upload
            if ($result->ok === false) {
                $this->responseJSON("400", "Ocurrio un error al guardar la información", []);
            } else {
                $this->responseJSON("200", "Se guardo con Éxito", []);
            }
        }

        function delete_documento(){
            $id_doc=$this->input->post('id_doc');
            $response=$this->googledrive->deleteFile($id_doc);
            $this->danos->delete_doc_drive($id_doc);
            $this->responseJSON("200", "Se realizó con Éxito", []);
        }
        //--------------------- //Dennis Castillo [2022-01-18]
        function manageNote(){

            $idNote = $_POST["id-note"];
            $response = array();

            if($idNote > 0){

                $response = $this->updateNote($_POST);
            } else{
                $response = $this->insertNote($_POST);
            }

            echo json_encode($response);
        }
        //-------------------- //Dennis Castillo [2022-01-18]
        function updateNote($data){

            $batchArray = array();
            $updateNote = $this->danos->updateRecordSafely(
                "sininisterNotes", //Table
                array("id" => $data["id-note"]),  //Condition
                array( //Data
                    "note" => $data["coment"], 
                    "dateUpdate" => date("Y-m-d H:i:s"),
                )
            );
            if($updateNote["bool"]){
                $deleteAssigneds = $this->danos->deleteNoteSafely("sinisterNotesAssigned", array("idNote" => $data["id-note"])); //First delete persons

                if($deleteAssigneds){

                    if(!empty($data["person-selected"])){

                        foreach($data["person-selected"] as $dp){
                            $batchArray[] = array("idPersona" => $dp, "idNote" => $data["id-note"]);
                        }
            
                        $insertBatch = $this->danos->insertMultipleRecordSafely("sinisterNotesAssigned", $batchArray); //Second re-insert persons
            
                        if($insertBatch["bool"]){
                            $this->sendNotification($batchArray, "ACTUALIZACION_NOTA_SINIESTRO");
                        }
                    }
                }
            }

            return $updateNote;
        }
        //-------------------- //Dennis Castillo [2022-01-18]
        function insertNote($data){

            $batchArray = array();
            $insertNote = $this->danos->insertRecordSafely(
                "sininisterNotes", 
                array(
                    "note" => $data["coment"], 
                    "dateCreate" => date("Y-m-d H:i:s"), 
                    "idSinister" => $data["id-row"],
                    "creator" => $this->tank_auth->get_usermail(),
                )
            );

            if(!empty($data["person-selected"])){

                foreach($data["person-selected"] as $dp){
                    $batchArray[] = array("idPersona" => $dp, "idNote" => $insertNote["lastId"]);
                }

                $insertBatch = $this->danos->insertMultipleRecordSafely("sinisterNotesAssigned", $batchArray);

                if($insertBatch["bool"]){
                    $this->sendNotification($batchArray, "NUEVA_NOTA_SINIESTRO");
                }
            }


            return $insertNote;
            //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($batchArray, TRUE));fclose($fp);
            //echo json_encode($insertNote);

        }
        //-------------------- //Dennis Castillo [2022-01-18]
        function getNotes(){

            $id = $_GET["id"];
            $getNotes = $this->danos->getNotes($id);
            $allDataNotes = $this->danos->getAllDataNote($id);
            $response = array();

            foreach($allDataNotes as $dn){
                
                $response[$dn->id]["note"] = $dn->note;
                $response[$dn->id]["sinister"] = $dn->idSinister;
                $response[$dn->id]["policy"] = $dn->poliza;
                $response[$dn->id]["numberSinister"] = $dn->siniestro_id;
                $response[$dn->id]["sinister"] = $dn->idSinister;
                $response[$dn->id]["typesinister"] = $dn->tipo_r;
                $response[$dn->id]["insure"] = $dn->asegurado_nombre;
                $response[$dn->id]["creator"] = $dn->creator;
                $response[$dn->id]["dateCreate"] = $dn->dateCreate;
                $response[$dn->id]["persons"][] = array(
                    "idPerson" => $dn->idPersona, 
                    "name" => $dn->nombres." ".$dn->apellidoPaterno." ".$dn->apellidoMaterno,
                    "email" => $dn->email,
                );
            }

            //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($response, TRUE));fclose($fp);
            echo json_encode($response);
        }
        //-------------------- //Dennis Castillo [2022-01-18]
        function deleteNote(){

            $id = $_POST["id"];
            $response["bool"] = false;
            $response["message"] = "Hubo un detalle con la eliminación. Favor de contactar al departamento de sistemas.";

            $deleteNote = $this->danos->deleteNoteSafely("sininisterNotes", array("id" => $id));

            if($deleteNote){
                $deleteAssigneds = $this->danos->deleteNoteSafely("sinisterNotesAssigned", array("idNote" => $id));
                $response["bool"] = true;
                $response["message"] = "Registro eliminado con éxito";
            }

            echo json_encode($response);
        }
        //--------------------- //Dennis Castillo [2022-01-18]
        function getNote(){

            $id = $_GET["id"];
            $getNote = $this->danos->getNote($id);

            echo json_encode($getNote);
        }
        //--------------------- //Dennis Castillo [2022-01-18]
        function sendNotification($array, $label){

            $forwhoisthismessage = array();

            if(!empty($array)){
                foreach($array as $da){

                    $getEmail = $this->persona->obtenerEmail($da["idPersona"]);

                    $object = new stdClass();
                    $object->idPersona = $da["idPersona"];
                    $object->email = $getEmail->email;
                    array_push($forwhoisthismessage, $object);
                }
            }

            //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($forwhoisthismessage, TRUE));fclose($fp);
            $this->notificacion->add($forwhoisthismessage, "email", "ENVIADO", $label, "NOTA_SINIESTRO", array("evaluacion_id" => $array[0]["idNote"]));
        }
        //--------------------- //Dennis Castillo [2022-01-18]
        function getKpi(){

            $year = $_GET["year"];
            $getKPI = $this->kpi->getKPI_Siniestros("DANOS", null, $year, $this->tank_auth->get_idPersona());

            echo json_encode($getKPI);
        }
        //---------------------
}