<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Autos extends TIC_Controller{

    function __construct()
    {
        parent::__construct();
        //$this->load->library(array('session'));
        //$this->load->helper('url');
        $this->load->model('danos_model', 'danos');//modelo de gmm
        $this->load->library(array('form_validation', 'JbUpload'));
        $this->load->library('googledrive');
        $this->load->model("documentsmodel", "documento");
        $this->load->model('autos_model','autos');
        $this->load->library('ws_sicas');
        $this->load->model('personamodelo','persona'); //Dennis Castillo [2022-01-07]}
        $this->load->model("graficas_model", "kpi"); //Dennis Castillo [2022-01-17]
        $this->load->model('notificacionmodel','notificacion'); //Dennis Castillo [2022-01-17]
        $this->load->library('libreriav3'); //Dennis Castillo [2022-01-07]
    }

    //pagina de inicio de GMMM
    function index(){
        $head = array('title' => 'Capsys - Daños');
        $data = array();
        $footer = array();
        $this->breadcrumbs->push('Registros Autos', 'Bonos');
        $this->breadcrumbs->unshift('Inicio', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $documentos=$this->autos->getDocuments();
        $tipos_tramites=$this->autos->getTramitesDanos();
        $estatus=$this->autos->getStatus();
        $actualyears=$this->autos->getYearsDocs();
        $fechaFin=true;
        $tipoS = $this->autos->tiposiniestro();

        //$tipo_s=$this->autos->getAllData('siniestro_tipo');
        //$causa_s=$this->autos->getAllData('siniestro_causa');
        //$ajustador=$this->autos->getAllData('siniestro_segun_ajustador');
        $data['tipo_s'] = $this->autos->getAllData('siniestro_tipo');
        $data['ajustador'] = $this->autos->getAllData('siniestro_segun_ajustador');
        $data["tipo"] = "C_AUTOS";
        $data["idNotificacion"]=$this->input->get('registro');
        //nuevos tramites
        $tram_autos=$this->autos->getTramitesAutos();
        $estatusReparacion=$this->autos->getLlenadoSelect('ERR');
        $data["tramites"]=$tram_autos;
        //aseguradoras
        $aseguradoras=$this->autos->getAseguradoras('A');

        //Requisitos para las notas del siniestros //Dennis Castillo [2022-01-17]
        $data["notes"]["agentsToAssing"] = $this->libreriav3->agrupaPersonasParaSelect($this->persona->obtenerPersonas("SISTEMAS@ASESORESCAPITAL.COM",3));

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
                'data' => "const _estatus = " . json_encode($estatus) . ";"."const _Documents = " . json_encode($documentos) . ";"."const _Tram = " . json_encode($tipos_tramites) . ";"."const _years = " . json_encode($actualyears) . ";"
                ."const _FechaFin = " . json_encode($fechaFin) . ";" ."const _siniestroT= " . json_encode($tipoS) . ";"."const _Aseguradoras = " . json_encode($aseguradoras) . ";"."const _TramAutos = " . json_encode($tram_autos) . ";"
                ."const _Estatus_Reparacion = " . json_encode($estatusReparacion) . ";"
            ),
        ));
        $this->render('autos/autos', $head, $data, $footer);
    }

    //funcion pára obtener los registros de GMM
    function getAutos(){
        $id=null;
        $year='0';
        if($this->input->post()){
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
        //$data=$this->autos->getAllAutos($id, $year);
        $data=$this->autos->getAllAutos($id, $year,null,$this->tank_auth->get_IDVend());
        
        $this->responseJSON($code, $message, $data);
        //echo 'id-> '.$id;
    }

    //Acciones para los registros de GMM
    function AccionesAutos(){
        $id=$this->input->post('id');
        $id_sin=$this->input->post('numero_siniestro');
        $Npoliza=$this->input->post('numero_poliza');
        //$nombre=$this->input->post('nombre_a')." ".$this->input->post('apellido_p')." ".$this->input->post('apellido_m');
        $dataS = array(
            'cabina_id' => '',
            'ajustador_nombre' => $this->input->post('nombre_coordinador'),
            'siniestro_id' => $this->input->post('numero_siniestro'),
            'poliza' => $this->input->post('numero_poliza'),
            'certificado' => $this->input->post('certificado'),
            'asegurado_nombre' => $this->input->post('nombres'),
            'estado_id' => $this->input->post('estado'),
            'inicio_ajuste' => date("Y-m-d H:i", strtotime($this->input->post('fecha_aviso'))),
            'status_id'=>1,
            //'tipo_r'=>'A',
            'agregado_por'=>$this->tank_auth->get_idPersona(),
            'siniestro_estatus'=>"ACTIVO",
            'tipo_r'=>'A',
            'declara_conductor'=>$this->input->post('declaracion'),
            'causa_siniestro_id'=>$this->input->post('causa'),
            'tipo_siniestro_id'=>$this->input->post('tipo_siniestro'),
            'responsable_autoridad'=>$this->input->post('autoridad_presente'),
            'responsable_ajustador'=>$this->input->post('tipo_ajustador'),
            'autoridad_id'=>$this->input->post('tipo_autoridad'),
            'atencion_lugar'=>$this->input->post('atencion'),
            'id_sicas_cliente'=>$this->input->post('idsicascliente'),
            'id_sicas_vendedor'=>$this->input->post('idsicasvendedor'),
            'aseguradora_id'=>$this->input->post('aseguradora_id'),
            'complemento_json'=>json_encode(
                array(
                    "cordinador"=>array(
                        'nombre_coordinador' => $this->input->post('nombre_coordinador'),
                        'telefono_coordinador' => $this->input->post('telefono_coordinador'),
                        'correo_coordinador' =>$this->input->post('correo_coordinador'), 
                    ),
                    "general"=>array(
                        'vehiculo'=>$this->input->post('vehiculo'),
                        'serie'=>$this->input->post('serie'),
                        'lugar'=>$this->input->post('lugar'),
                        'afectado'=>$this->input->post('afectado'),
                        'valor_unidad'=>$this->input->post('valor_unidad'),
                        'deducible'=>$this->input->post('deducible'),
                    )
                )
            )
        );
        $poliza=array(
            "poliza"=>$this->input->post('numero_poliza'),
            "data_poliza"=>$this->input->post('json_poliza')
        );

        if($id==0){
            if($this->autos->ExistSiniestro($id_sin,$Npoliza)){
                 $id_inserted=$this->autos->insertSiniestro($dataS);
                if(!$this->autos->existPoliza($this->input->post('numero_poliza'))){
                    $this->autos->insert_poliza($poliza);
                }
                $this->responseJSON('200', "Exito ",$this->autos->ExistSiniestro2($id_sin,$Npoliza));
            }else{
               
                $this->responseJSON('400', "Ya existe un registro con el número de siniestro", []);
            }
            
        }else{
            $this->autos->updateSiniestro($id,$dataS);
            $this->responseJSON('200', "Exitoiohjij", []);
        }
        
    }

    //formulario para agregar GMMM
    function RegistroAutos($id=null){
        $head = array('title' => 'Capsys - GMM');
        $data = array();
        $footer = array();
        $this->breadcrumbs->push('Siniestros Autos', 'Bonos');
        $this->breadcrumbs->unshift('Autos', 'Autos');
        $this->breadcrumbs->unshift('Inicio', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['titulo']=$id==NULL?'Nuevo':'Editar';
        ///$data['registro']=$this->danos->getResgistroDanos($id);
        $data['registro']=$this->autos->getSiniestroPoliza($id==null?0:$id);
        $causa_s=$this->autos->getAllData('siniestro_causa');
        //$data['coberturas']=$this->danos->getCoberturasDanos();
        $data['estados']=$this->autos->getEstados();
        $data['usuario']=$this->tank_auth->get_usernamecomplete();
        $data['tipo_s'] = $this->autos->getAllData('siniestro_tipo');
        $data['ajustador'] = $this->autos->getAllDataWith(1,'siniestro_segun_ajustador');
        $data['ajustador_tipo'] = $this->autos->getAllData('siniestro_segun_autoridad');
        $data['autoridad_t']=$this->autos->getAllData('siniestro_tipoautoridad');

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
                'data' => "const _Causa = " . json_encode($causa_s) . ";"
            ),
        ));
        $this->render('autos/formulario_autos', $head, $data, $footer);
    }

    //consulta de las polizas del asegurado
    function getPolizas(){
        $this->load->library('ws_sicas');
        $code=200;
        $message="Exito";
        $res=$this->ws_sicas->PruebaPolizas($this->input->post());
        if(isset($res->TableInfo)){
            $data=$res;
        }else{
            $object = new stdClass();
            $object->TableInfo=[];
            $data=$object;
        }
        $this->responseJSON($code, $message, $data);
    }

    function ChangeEstatus(){
        $id=$this->input->post('id_siniestro');
        $id_estatus=$this->input->post('estatus');
        $fecha=$this->input->post('fecha_fin');
        //$tramite=$this->input->post('tramite');
        $data=array(
            "siniestro_estatus"=>$this->autos->findStatus($id_estatus),
            "status_id"=>$id_estatus
        );
        $dataSegumiento=array(
            "referencia"=>"AUTOS",
            "referencia_id"=>$this->input->post('id_siniestro'),
            "fecha"=>date("Y-m-d"),
            "usuario_id"=>$this->tank_auth->get_idPersona(),
            "fecha_alta"=>date("Y-m-d"),
            "comentario"=>$this->input->post('comentario'),
            "estatus_id"=>$id_estatus,
            //"tramite_id"=>$id
        );

        /* if($id_estatus==3){
            $data['fecha_fin']=$fecha!=''?$fecha:date("Y-m-d");
        } */
        $closedEstatus=array("3","4","5");
        if(in_array($id_estatus,$closedEstatus)){//$id_estatus==3
            $data['fecha_fin']=$fecha!=''?$fecha:date("Y-m-d");
        }
        $this->autos->updateAutos($id,$data);
        $this->autos->addSeguimiento($dataSegumiento);
        $this->responseJSON("200", "Se guardo con Éxito", $fecha);
        //echo $this->input->post('id');
    }

    function getAllTramites(){
        $id=$this->input->post('id');
        //$data=$this->danos->getTramites($id);
        $data["siniestro"]=$this->autos->getSiniestroPoliza($id);
        $data["seguimiento"]=$this->autos->getSeguimiento($id);

        //obtner los documentos
        $tramites=$this->autos->getTramites($id);
        $dataTram=[];
        foreach ($tramites as $key => $value) {
            $dta=array(
                "info"=>$value,
                "documentos"=>$this->autos->getAllDocumentTramites($value['id'])
            );
            $dataTram[]=$dta;
        }
        $data["tramites"]=$dataTram;
        //$data["tramites"]=$this->autos->getTramites($id);
        //$data["tramites"]=$this->danos->getTramites($id);
        $this->responseJSON("200", "Se guardo con Éxito",$data);
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
            "referencia"=>"AUTOS",
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
        $this->responseJSON("200", "Se guardo con Éxito", $data);

    }


    ///Nuevos metodos
    function GetpartialTramite(){
        $tipotramite=$this->input->post('tipotramite');
        $idtramite=$this->input->post('id_tramite');
        $id=$this->input->post('id_siniestro');
        ///LLENADO DE LOS SELECT
        $data=[];
        $data["Afectados"]=$this->autos->getLlenadoSelect('A');
        $data["Deducible"]=$this->autos->getLlenadoSelect('D');
        $data["Recuperacion"]=$this->autos->getLlenadoSelect('R');
        $data["EstatusPT"]=$this->autos->getLlenadoSelect('EP');
        $data["ResultadoEvaluacion"]=$this->autos->getLlenadoSelect('RE');
        $data["EstatusFinal"]=$this->autos->getLlenadoSelect('EFR');
        $data["EstatusReparacion"]=$this->autos->getLlenadoSelect('ERR');
        $data['data']=$this->autos->getTramite($idtramite,$id);
        switch ($tipotramite) {
            case '1':
                 $this->load->view('autos/tramite_detenidos_partial',$data);
                break;
            case '2':
                $this->load->view('autos/tramite_reparacion_partial',$data);
            break;
            case '3':
                 $this->load->view('autos/tramite_pt_partial',$data);
             break;
            
        }
    }

    //se obtine la vista parcial
    function postTramite(){
        $tipo_tramite=$this->input->post("tipo_tramite_select");
        $id_siniestro=$this->input->post("id_siniestro");
        $id_tramite=$this->input->post("id_tramite");
        $data=$this->input->post();
        $fecha_inicio=$this->input->post('fecha_inicio');
        unset($data["tipo_tramite_select"]);
        unset($data["id_siniestro"]);
        unset($data["id_tramite"]);
        unset($data["fecha_inicio"]);
        $comentario = $this->input->post('comentario');
        unset($data["comentario"]);
        $datadb=array(
            "id_siniestro"=>$id_siniestro,
            "estatus"=>1,
            "tipo_tramite"=>$tipo_tramite,
            "valores"=>json_encode($data),
            "fecha_inicio"=>$fecha_inicio,
            "subido_por"=>$this->tank_auth->get_idPersona()
        );
        if($id_tramite==0){
            $inserted_id=$this->autos->insertTramite($datadb);
            //$this->siniestros->updateAutos($id_siniestro,$datareporte);
        }else{
            $inserted_id=$id_tramite;
            $dataup=array(
                "valores"=>json_encode($data),
            );
            $this->autos->updateTramite($id_tramite,$dataup);
        }

        $result = new \stdClass;
        $result->ok = true;
        //guardado de los documentos de los tramites
        if (!empty($_FILES)) {
            $keys=array_keys($_FILES);
            $finalRef = $this->createReferenciaFolder('AUTOSI_', '');
            $padre = $finalRef->getId();
            //$inset_id=12;
            $folder = $this->googledrive->createFolder('AUTOSI_'.$inserted_id, $padre);
            $count=0;
            foreach ($_FILES as $file) {
                $uploadFile = $this->googledrive->createFiles($file, $keys[$count], 'documentación del registro', $folder->data->getId());
                $this->saveDoc($uploadFile->data, '', 'AUTOSI_', $inserted_id, []);
                $count++;
            }
            $result->ok = true;
        }//fin upload
        if ($result->ok === false) {
            $this->responseJSON("400", "Ocurrio un error al guardar la información", []);
        } else {
            $this->responseJSON("200", "Se guardo con Éxito", $data);
        }
        
     
        $this->responseJSON("200", "Se guardo con Éxito", $data);
    }

    
    function ChangeEstatusTramite(){
        $id=$this->input->post('id_siniestro');
        $id_estatus=$this->input->post('estatus');
        $fecha=$this->input->post('fecha_fin');
        $idtramite=$this->input->post('id_tramite');
        $tipo_tram=$this->input->post('tipo_tram');
        $dataup=array(
            "estatus"=>$id_estatus
        );
        
        $dataSegumiento=array(
            //"referencia"=>"AUTOS_C",
            "referencia"=>"AUTOS",
            "referencia_id"=>$id,
            "fecha"=>date("Y-m-d"),
            "usuario_id"=>$this->tank_auth->get_idPersona(),
            "fecha_alta"=>date("Y-m-d H:i:s"),
            "comentario"=>$this->input->post('comentario'),
            "estatus_id"=>$id_estatus,
            "tramite_id"=>$idtramite,
            "causa_id"=>$tipo_tram
            //"tramite_id"=>$id
        );
        if($this->autos->opcionCerrarSiniestro($id_estatus)){
            $dataup['fecha_fin']=$fecha!=''?$fecha:date("Y-m-d");
        }
        if($id_estatus==6){
            $datalog=array(
                "fecha_inicio"=>date("Y-m-d"),
                "estatus"=>6,
                "id_registro"=>$idtramite,
                "id_siniestro"=>$id
            );
            $this->autos->insertLogDormido($datalog);
        }
        if($id_estatus!=6){
            $datauplog=array(
                "fecha_fin"=>date("Y-m-d")
            );
            $this->autos->updateTramitelog($idtramite,$datauplog);
        }
        //$this->autos->updateAutos($id,$data);
        $this->autos->updateTramite($idtramite,$dataup);
        $this->autos->addSeguimiento($dataSegumiento);
        $this->responseJSON("200", "Se guardo con Éxito", $fecha);
    }

    function Reingreso(){
        $tipo_tramite=$this->input->post("tipo_tramite_select");
        $id_siniestro=$this->input->post("id_siniestro");
        $id_tramite=$this->input->post("id_tramite");
        $data=$this->input->post();
        $fecha_inicio=$this->input->post('fecha_inicio');
        unset($data["tipo_tramite_select"]);
        unset($data["id_siniestro"]);
        unset($data["id_tramite"]);
        unset($data["fecha_inicio"]);
        $datadb=array(
            "id_siniestro"=>$id_siniestro,
            "estatus"=>1,
            "tipo_tramite"=>$tipo_tramite,
            "valores"=>json_encode($data),
            "fecha_inicio"=>$fecha_inicio,
            "subido_por"=>$this->tank_auth->get_idPersona(),
            "reingreso"=>1,
            "fecha_agregado"=>date("Y-m-d H:i:s"),
        );

        if($id_tramite==0){
            $id=$this->autos->insertTramite($datadb);
            $datareporte=array(
                "status_id"=>1,
                "reingreso"=>'SI',
                "fecha_fin"=>NULL
            );
            $this->autos->updateAutos($id_siniestro,$datareporte);
            //añadimos un log de reingreso ==estatus ->0 
            $datalog=array(
                "fecha_inicio"=>date("Y-m-d"),
                "estatus"=>0,
                "id_registro"=>$id,
                "id_siniestro"=>$id_siniestro
            );
            $this->autos->insertLogDormido($datalog);

        }else{
            $dataup=array(
                "valores"=>json_encode($data),
            );
            $this->autos->updateTramite($id_tramite,$dataup);
        }
        
     
        $this->responseJSON("200", "Se guardo con Éxito", $data);
    }

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

    ///funciones para administar los documentos
    function updateDocumentos(){
        $inset_id=$this->input->post('id');
        $result = new \stdClass;
        $result->ok = true;

        if (!empty($_FILES)) {
            $keys=array_keys($_FILES);
            $finalRef = $this->createReferenciaFolder('AUTOSI_', '');
            $padre = $finalRef->getId();
            //$inset_id=12;
            $folder = $this->googledrive->createFolder('AUTOSI_'.$inset_id, $padre);
            $count=0;
            foreach ($_FILES as $file) {
                $uploadFile = $this->googledrive->createFiles($file, $keys[$count], 'documentación del registro', $folder->data->getId());
                $this->saveDoc($uploadFile->data, '', 'AUTOSI_', $inset_id, []);
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
        $this->autos->delete_doc_drive($id_doc);
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
        $updateNote = $this->autos->updateRecordSafely(
            "sininisterNotes", //Table
            array("id" => $data["id-note"]),  //Condition
            array( //Data
                "note" => $data["coment"], 
                "dateUpdate" => date("Y-m-d H:i:s"),
            )
        );
        if($updateNote["bool"]){
            $deleteAssigneds = $this->autos->deleteNoteSafely("sinisterNotesAssigned", array("idNote" => $data["id-note"])); //First delete persons

            if($deleteAssigneds){

                if(!empty($data["person-selected"])){

                    foreach($data["person-selected"] as $dp){
                        $batchArray[] = array("idPersona" => $dp, "idNote" => $data["id-note"]);
                    }
        
                    $insertBatch = $this->autos->insertMultipleRecordSafely("sinisterNotesAssigned", $batchArray); //Second re-insert persons
        
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
        $insertNote = $this->autos->insertRecordSafely(
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

            $insertBatch = $this->autos->insertMultipleRecordSafely("sinisterNotesAssigned", $batchArray);

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
        $getNotes = $this->autos->getNotes($id);
        $allDataNotes = $this->autos->getAllDataNote($id);
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

        $deleteNote = $this->autos->deleteNoteSafely("sininisterNotes", array("id" => $id));

        if($deleteNote){
            $deleteAssigneds = $this->autos->deleteNoteSafely("sinisterNotesAssigned", array("idNote" => $id));
            $response["bool"] = true;
            $response["message"] = "Registro eliminado con éxito";
        }

        echo json_encode($response);
    }
    //--------------------- //Dennis Castillo [2022-01-18]
    function getNote(){

        $id = $_GET["id"];
        $getNote = $this->autos->getNote($id);

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
        $getKPI = $this->kpi->getKPI_Siniestros("AUTOSI", null, $year, $this->tank_auth->get_idPersona());

        echo json_encode($getKPI);
    }
    //---------------------
    

}