<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class GMM extends TIC_Controller{

    function __construct()
    {
        parent::__construct();
        //$this->load->library(array('session'));
        //$this->load->helper('url');
        $this->load->model('gmm_model', 'gmm');//modelo de gmm
        $this->load->model('documentsmodel');
        $this->load->library(array('form_validation', 'JbUpload'));
        $this->lang->load('tank_auth');
        $this->load->library('googledrive');
        $this->load->model("documentsmodel", "documento");
        $this->load->library('ws_sicas');
        $this->load->model("graficas_model", "kpi"); //Dennis Castillo [2022-01-17]
        $this->load->model('personamodelo','persona'); //Dennis Castillo [2022-01-14]
        $this->load->library('libreriav3'); //Dennis Castillo [2022-01-14]
        //$this->load->library('ws_sicas');
    }

    //pagina de inicio de GMMM
    function index(){
        $head = array('title' => 'Capsys - GMM');
        $data = array();
        $footer = array();
        $this->breadcrumbs->push('Registros GMM', 'Bonos');
        $this->breadcrumbs->unshift('Inicio', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['padecimientos']=$this->gmm->getCoberturasGMM();
        $data['reclamo']=$this->gmm->getTipostramites();
        $actualyears=$this->gmm->getYearsDocs();
        $cierre=$this->gmm->getCausaCierre();
        $FechaFin=true;
        //$data['estatus']=$this->gmm->getStatus();
        $coberturas=$this->gmm->getCoberurasGmm();
        $data["coberturas"]=$coberturas;
        $documentos=$this->gmm->getDocuments();
        $estatus=$this->gmm->getStatus();
        $data["tipo"] = "C_GMM";
        $data["idNotificacion"]=$this->input->get('registro');

         //aseguradoras
         $aseguradoras=$this->gmm->getAseguradoras('G');

        //Requisitos para las notas del siniestros //Dennis Castillo [2022-01-18]
        $data["notes"]["agentsToAssing"] = $this->libreriav3->agrupaPersonasParaSelect($this->persona->obtenerPersonas("SISTEMAS@ASESORESCAPITAL.COM",3)); //array();//$tram_autos;

        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            )/* , array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ) */
        ));
        $this->footerScripts(array(
            array(
                'type' => 'JSHTML',
                'data' => "const _estatus = " . json_encode($estatus) . ";"."const _Documents = " . json_encode($documentos) . ";"."const _Causa = " . json_encode($cierre) . ";"
                ."const _years = " . json_encode($actualyears) . ";"."const _FechaFin = " . json_encode($FechaFin) . ";"."const _cobertura = " . json_encode($coberturas) . ";"
                ."const _Aseguradoras = " . json_encode($aseguradoras) . ";"
            ), 
            /* array(
                'type' => 'JS',
                'path' => 'js/fileupload/public/bundle-preview.js'
            ) */
        ));
        $this->render('GMM/gmm', $head, $data, $footer);
    }

    //funcion pára obtener los registros de GMM
    function getGMM(){
        /* $code=200;
        $message="Exito";
        $data=$this->gmm->getAllGMM(); */
        $id=null;
        $year=null;
        if($this->input->post('id')){
            $id=$this->input->post('id');
            $year=$this->input->post('year');
            if($id=='TODOS'){
                $id='0';
            }
        }else{
            $year='0';
            $id='0';
        }
        $code=200;
        $message="Exito". "id->".$id. " Año->".$year;
        //$data=$this->gmm->getAllGMM($id,$year);
        $data=$this->gmm->getAllGMM($id,$year,$this->tank_auth->get_IDVend());
        $this->responseJSON($code, $message, $data);
    }

    //Acciones para los registros de GMM
    function AccionesGMM(){
        //  var_dump($this->input->post());
        $id=$this->input->post('id');
        $id_sin=$this->input->post('numero_siniestro');
        $Npoliza=$this->input->post('numero_poliza');
        /* if($id==0){
            if($this->gmm->ExistSiniestro($id_sin,$poliza)){
                $this->responseJSON('400', "Ya existe un siniestro con el mismo número", []);
                die;
            }
        } */
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
            'tipo_r'=>'G',
            'agregado_por'=>$this->tank_auth->get_idPersona(),
            'id_sicas_cliente'=>$this->input->post('idsicascliente'),
            'id_sicas_vendedor'=>$this->input->post('idsicasvendedor'),
            'aseguradora_id'=>$this->input->post('aseguradora_id'),
            'correo_asegurado_notificacion'=>$this->input->post('correo_asegurado_notificacion'),
            'complemento_json'=>json_encode(
                array(
                    "general"=>array(
                        'siniestro_id' => $this->input->post('numero_siniestro'),
                        //'folio_cia' => $this->input->post('folio_cia'),
                        'usuario_responsable' => $this->tank_auth->get_usernamecomplete(),
                        'titular' => $this->input->post('titular'),
                        'afectado' => $this->input->post('afectado'),
                        'inciso' => $this->input->post('inciso_u'),
                        'parentesco' => $this->input->post('parentesco'),
                        'certificado' => $this->input->post('certificado'),
                        'responsable'=>$this->tank_auth->get_usernamecomplete(),
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
            if($this->gmm->ExistSiniestro($id_sin,$Npoliza)){
                 $id_inserted=$this->gmm->insertSiniestro($dataS);
                if(!$this->gmm->existPoliza($this->input->post('numero_poliza'))){
                    $this->gmm->insert_poliza($poliza);
                }
                $this->responseJSON('200', "Exito", []);
            }else{
               
                $this->responseJSON('400', "Ya existe un registro con el número de siniestro", []);
            }
            
        }else{
            $this->gmm->updateSiniestro($id,$dataS);
            $this->responseJSON('200', "Exito", []);
        }
    }

    //formulario para agregar GMMM
    function RegistroGMM($id=null){
        $head = array('title' => 'Capsys - GMM');
        $data = array();
        $footer = array();
        $this->breadcrumbs->push('Siniestros GMM', 'Bonos');
        $this->breadcrumbs->unshift('GMM', 'GMM');
        $this->breadcrumbs->unshift('Inicio', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['titulo']=$id==NULL?'Nuevo':'Editar';
        /* $data['registro']=$this->gmm->getResgistroGMM($id); */
        $data['registro']=$this->gmm->getSiniestroPoliza($id==null?0:$id);
        $data['coberturas']=$this->gmm->getCoberturasGMM();
        $data['reclamo']=$this->gmm->getTipostramites();
        $data['estados']=$this->gmm->getEstados();
        $data['usuario']=$this->tank_auth->get_usernamecomplete();
        $data['parentescos']=$this->gmm->getParentescos();

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
          /*   array(
                'type' => 'JSHTML',
                'data' => "const _empleados = " . json_encode($empleados) . "; const _puestos = " . json_encode($_puestos) . ";"
            ), */
        ));
        $this->render('GMM/formulario_gmm', $head, $data, $footer);
    }

    //pagina de iniciio de tipos de Caberturas 
    function TiposCobertura(){
        $head = array('title' => 'Capsys - Bonos');
        $data = array();
        $footer = array();
        $this->breadcrumbs->push('Tipos de cobertura', 'Bonos');
        $this->breadcrumbs->unshift('Inicio', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data["tipo"] = "C_siniestros";
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
        $this->render('GMM/TiposGMM', $head, $data, $footer);
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


    //retorna todos los registros de Tipos de cabertura
    function getTiposGMM(){
        $code=200;
        $message="Exito";
        $data=$this->gmm->getAllCoberturas();
        $this->responseJSON($code, $message, $data);
    }

    //retorna todos los registros de Tipos de cabertura
    function test(){
        $code=200;
        $message="Exito";
        //$data=$this->gmm->ExistSiniestro('252525','880284589');
        if($this->gmm->ExistSiniestro('2525255','880284589')){
            $this->responseJSON('200', "Exito", array('id'=>$id_sin,'npoli'=>$Npoliza));
            
        }else{
            $this->responseJSON('400', "Ya existe un registro con el número de siniestro", []);
        }
        //$this->responseJSON($code, $message, $data);
       
    }

    ///acciones para agregar ek nuevos tipos de cobertura
    function AccionesTiposCobertura(){
        $code=200;
        $message="Exito";
        $nombre = $this->input->post('Nombre');
        $descripcion = $this->input->post('Descripcion');
        $tipo = $this->input->post('tipo');
        $id = $this->input->post('id');
        $data = array(
            "nombre" => $nombre,
            "descripcion" => $descripcion,
            "Tipo"=>$tipo
        );
        if ($id == 0) {
            if($this->gmm->ExisCobertura($data['nombre'],$data["Tipo"],'tipo_coberturas_gmm')){
                $data = $this->gmm->insertCobertura($data);
            }else{
                $code=400;
                $message="Ya existe un registro con el mismo nombre.";
            }
           
        } else {
            if($this->gmm->ExisCobertura($data['nombre'],$data["Tipo"],'tipo_coberturas_gmm')){
                $data = $this->gmm->updateCobertura($id, $data);
            }else{
                $code=400;
                $message="Ya existe un registro con el mismo nombre.";
            }
           
        }
        $this->responseJSON($code, $message, $id);
    }
    //sirve para eliminar el tipo de cobertura
    function deleteTipoCobertura(){
        $id = $this->input->post('id');
        $res=$this->gmm->deleteCobertura($id);
        $this->responseJSON("200", "Éxito", $res);
    }

    //sirve para agregar un nuevo tipo de tramite
    function nuevoTramite(){
        $test=$this->input->post();
        $arrayFiles=[];
        $idtram=$this->input->post('id_tram');
        $data=array(
            "id_siniestro"=>$this->input->post('id_siniestro'),
            "fecha_inicio"=>date('Y-m-d', strtotime($this->input->post('inicio_tramite'))),
            "descripcion"=>$this->input->post('descripcion'),
            "tipo_tramite"=>$this->input->post('tipo_tramite'),
            "cobertura_afectada"=>$this->input->post('riesgo_id'),
            "cobertura_id"=>$this->input->post('cobertura_id'),
            "subido_por"=>$this->tank_auth->get_idPersona(),
            "estatus"=>"1",
            "folio_cia"=>$this->input->post('folio_cia'),
            "fecha_agregado"=>date('Y-m-d H:i:s'),
            "valores"=>json_encode(array(
                "reclamado"=>$this->input->post('reclamado'),
                "deducible"=>$this->input->post('deducible'),
                "coaseguro"=>$this->input->post('coaseguro'),
                "no_cubierto"=>$this->input->post('no_cubierto'),
                "convenio"=>$this->input->post('convenio'),
                "retencion"=>$this->input->post('retencion'),
                "pagado"=>$this->input->post('pagado'),
                "p_coaseguro"=>$this->input->post('p_coaseguro')
            )),
            //Nuevos campos
            "estatus_doc_cliente"=>null,
            "user_doc"=>"usuario_".substr(str_shuffle(MD5(microtime())), 0, 5),
            "pass_doc"=>substr(str_shuffle(MD5(microtime())), 0, 8)
        );
        if($idtram==0){
            $inset_id=$this->gmm->insertTramite($data);
        }else{
            $update=$this->gmm->updateTramite($idtram,$data);
            $inset_id=$idtram;
        }
        
        $result = new \stdClass;
        $result->ok = true;
    
        //subo documentos al drive
        if (!empty($_FILES)) {
            $pruebaid=$inset_id;
            $keys=array_keys($_FILES);
            $finalRef = $this->createReferenciaFolder('GMM', '');
            $padre = $finalRef->getId();
            //$inset_id=12;
            $folder = $this->googledrive->createFolder('GMM_'.$inset_id, $padre);
            $count=0;
            foreach ($_FILES as $file) {
                $uploadFile = $this->googledrive->createFiles($file, $keys[$count], 'documentación del registro', $folder->data->getId());
                $arrayFiles[]=$uploadFile;
                $this->saveDoc($uploadFile->data, '', 'GMM', $inset_id, []);
                $count++;
            }
            $result->ok = true;
            //file_put_contents(APPPATH.'files_uploads/'.$data["folio_cia"].".txt", json_encode($arrayFiles));
        }//fin subir documentos
        //mandar correo 
        $this->SendCorreoFull('3',$this->input->post('id_siniestro'),null);

        if ($result->ok === false) {
            $this->responseJSON("400", "Ocurrio un error al guardar la informaciÉn", []);
        } else {
            $this->responseJSON("200", "Se guardo con Éxito", []);
        }


        /* if (!empty($_FILES)) {
            print_r(array_keys($_FILES));
            foreach ($_FILES as $file) {
                var_dump($file);
            }
        } */

    }

    function getAllTramites(){
        $id=$this->input->post('id');
        //$id=14;
        $data["siniestro"]=$this->gmm->getSiniestroPoliza($id);
        $tram=$this->gmm->getTramites($id);
        $dataTram=[];
        foreach ($tram as $key => $value) {
            $dta=array(
                "info"=>$value,
                "documentos"=>$this->gmm->getAllDocumentTramites($value['id'])
            );
            $dataTram[]=$dta;
        }
        $data["tramites"]=$dataTram;
        $data["SeguimientoGeneral"]=$this->gmm->getSeguimientogeneral($id);
        //$data["tramites"]=$this->gmm->getTramites($id);
        $this->responseJSON("200", "Se guardo con Éxito",$data);
    }

    function siniestro_estatus(){
        $head = array('title' => 'Capsys - GMM');
        $data = array();
        $footer = array();
        $this->breadcrumbs->push('Estatus de siniestros', 'Bonos');
        $this->breadcrumbs->unshift('Inicio', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data["tipo"] = "C_siniestros";
        $this->headerScripts(array(
            array(
                'type' => 'CSS',
                'path' => 'gap/css/datatables.min.css'
            )/* , array(
                'type' => 'JS',
                'path' => 'gap/js/sweetalert.min.js'
            ), */
            
        ));
        $this->footerScripts(array(
          /*   array(
                'type' => 'JSHTML',
                'data' => "const _empleados = " . json_encode($empleados) . "; const _puestos = " . json_encode($_puestos) . ";"
            ), */
        ));
        $this->render('GMM/estatus', $head, $data, $footer);

    }

    function get_estatus(){
        $res=$this->gmm->getStatus();
        $this->responseJSON("200", "Éxito", $res);
    }

    function AccionesEstatus(){
        $code=200;
        $message="Exito";
        $id=$this->input->post('id');
        $orden=$this->input->post('orden');
        $data=array();
        
        if($id==0){
            $data=array(
                "nombre"=>$this->input->post('Nombre'),
                "depende"=>$this->input->post('depende'),
                "orden"=>$this->gmm->getlastorden()
            );
            if($this->gmm->ExistName($data['nombre'],'siniestro_estatus_tramites')){
                $this->gmm->saveEstatus($data);
            }else{
                $code=400;
                $message="Ya existe un registro con el mismo nombre.";
            }
            
           
        }else{
           $pos=$this->gmm->getResgistroOrden($orden);
           if($id==$pos[0]["id"]&&$orden==$pos[0]["orden"]){
               $data=array(
                   "nombre"=>$this->input->post('Nombre'),
                   "depende"=>$this->input->post('depende'),
                   "color"=>$this->input->post('color')
               );
           }else{
                $data=array(
                    "nombre"=>$this->input->post('Nombre'),
                    "depende"=>$this->input->post('depende'),
                    "orden"=>$this->input->post('orden'),
                    "color"=>$this->input->post('color')
                );
           }
           $this->gmm->updateStatus($data,$id);
        }
        $this->responseJSON($code, $message, []);
    }

    function deleteStatus(){
        $id=$this->input->post('id');
        $orden=$this->input->post('orden');
        $dta=$this->gmm->getAllorderDelete($orden);
        $this->gmm->deleteEstatus($id);
        foreach ($dta as $key => $value) {
            $data=array("orden"=>$value["orden"]-1);
            $this->gmm->updateStatus($data,$value['id']);
        }

       $this->responseJSON("200", "Éxito", []);
    }


    function ChangeEstatus(){
        $id=$this->input->post('id');
        $id_estatus=$this->input->post('estatus');
        $fecha=$this->input->post('fecha_fin');
        $data=array(
            "estatus"=>$id_estatus,
        );

        $dataSegumiento=array(
            "referencia"=>"GMM_T",
            "referencia_id"=>$this->input->post('id'),
            "fecha"=>date("Y-m-d"),
            "usuario_id"=>$this->tank_auth->get_idPersona(),
            "fecha_alta"=>date("Y-m-d H:i:s"),
            "comentario"=>$this->input->post('comentario'),
            "estatus_id"=>$id_estatus,
            "tramite_id"=>$id
        );
        if($id_estatus==3||$id_estatus==4){
            //$data['fecha_fin']=date("Y-m-d");
            $data['fecha_fin']=$fecha!=''?$fecha:date("Y-m-d");
            $data['valores']=json_encode($this->input->post('valores'));
        }

        if($id_estatus==6){
            $datalog=array(
                "fecha_inicio"=>date("Y-m-d"),
                "estatus"=>6,
                "id_registro"=>$idtramite,
                "id_siniestro"=>$id
            );
            $this->gmm->insertLogDormido($datalog);
        }
        if($id_estatus!=6){
            $datauplog=array(
                "fecha_fin"=>date("Y-m-d")
            );
            //$this->gmm->updateTramitelog($idtramite,$datauplog);
        }

        $this->gmm->updateTramite($id,$data);
        $this->gmm->addSeguimiento($dataSegumiento);
        $this->responseJSON("200", "Se guardo con Éxito", []);
        //var_dump($this->input->post());
        //echo $this->input->post('id');
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
        $data=$this->gmm->getSeguimiento($id);
        $this->responseJSON("200", "Se guardo con Éxito", $data);
    }
    function getSeguimientoT(){
        $id=$this->input->post('id');
        $data=$this->gmm->getSeguimientoT($id);
        $this->responseJSON("200", "Se guardo con Éxito", $data);
    }

    function CerrarSiniestro(){
        $id=$this->input->post('id_siniestro');
        $data=array(
            "siniestro_estatus"=>'FINIQUITADO',
            "fecha_fin"=>date("Y-m-d"),
            "costo"=>$this->input->post('costo'),
            //"causa_siniestro_id"=>$this->input->post('id_causa'),
        );
        $dataSeguimento=array(
            "referencia"=>"GMM",
            "referencia_id"=>$this->input->post('id_siniestro'),
            "fecha"=>date("Y-m-d"),
            "usuario_id"=>$this->tank_auth->get_idPersona(),
            "fecha_alta"=>date("Y-m-d H:i:s"),
            "comentario"=>"<strong>Siniestro cerrado</strong><br>".$this->input->post('comentario'),
            //"estatus_id"=>0,
            "causa_id"=>$this->input->post('id_causa')
            //"tramite_id"=>$this->input->post('id_causa'),

        );
        //$this->gmm->addSeguimiento($dataSeguimento);
        $this->gmm->updateSiniestro($id,$data);
        $this->responseJSON("200", "Se guardo con Éxito", []);

    }

    function NuevoComentario(){
        $dataSegumiento=array(
            "referencia"=>"GMM",
            "referencia_id"=>$this->input->post('id_siniestro_c'),
            "fecha"=>date("Y-m-d"),
            "usuario_id"=>$this->tank_auth->get_idPersona(),
            "fecha_alta"=>date("Y-m-d H:i:s"),
            "comentario"=>$this->input->post('comentario_s'),
        );
        $this->gmm->addSeguimiento($dataSegumiento);
        $this->responseJSON("200", "Se guardo con Éxito", []);

    }

    function NuevoComentarioT(){
        $dataSegumiento=array(
            "referencia"=>"GMM_T",
            "referencia_id"=>$this->input->post('id_siniestro_c_t'),
            "fecha"=>date("Y-m-d"),
            "usuario_id"=>$this->tank_auth->get_idPersona(),
            "fecha_alta"=>date("Y-m-d H:i:s"),
            "comentario"=>$this->input->post('comentario_s_t'),
        );
        $idtram=$this->input->post('id_siniestro_c_t');
        $this->gmm->addSeguimiento($dataSegumiento);
        $idSiniestro=$this->gmm->getidSiniestroTramite($idtram);
        $data=array();
        $data=$this->gmm->getSeguimientogeneral($idSiniestro);
        $this->responseJSON("200", "Se guardo con Éxito", $data);

    }

    function delete_documento(){
        $id_doc=$this->input->post('id_doc');
        $response=$this->googledrive->deleteFile($id_doc);
        $this->gmm->delete_doc_drive($id_doc);
        $this->responseJSON("200", "Se realizó con Éxito", []);
    }
    function testdelete(){
        $id_documento="1AoU0gdoW4b0ce0CHpTXb60Fqgv34aRfy";
        $response=$this->googledrive->deleteFile($id_documento);
        var_dump($response);
    }


    //funciones para administar los documentos
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
        $updateNote = $this->gmm->updateRecordSafely(
            "sininisterNotes", //Table
            array("id" => $data["id-note"]),  //Condition
            array( //Data
                "note" => $data["coment"], 
                "dateUpdate" => date("Y-m-d H:i:s"),
            )
        );
        if($updateNote["bool"]){
            $deleteAssigneds = $this->gmm->deleteNoteSafely("sinisterNotesAssigned", array("idNote" => $data["id-note"])); //First delete persons

            if($deleteAssigneds){

                if(!empty($data["person-selected"])){

                    foreach($data["person-selected"] as $dp){
                        $batchArray[] = array("idPersona" => $dp, "idNote" => $data["id-note"]);
                    }
        
                    $insertBatch = $this->gmm->insertMultipleRecordSafely("sinisterNotesAssigned", $batchArray); //Second re-insert persons
        
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
        $insertNote = $this->gmm->insertRecordSafely(
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

            $insertBatch = $this->gmm->insertMultipleRecordSafely("sinisterNotesAssigned", $batchArray);

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
        $getNotes = $this->gmm->getNotes($id);
        $allDataNotes = $this->gmm->getAllDataNote($id);
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

        $deleteNote = $this->gmm->deleteNoteSafely("sininisterNotes", array("id" => $id));

        if($deleteNote){
            $deleteAssigneds = $this->gmm->deleteNoteSafely("sinisterNotesAssigned", array("idNote" => $id));
            $response["bool"] = true;
            $response["message"] = "Registro eliminado con éxito";
        }

        echo json_encode($response);
    }
    //--------------------- //Dennis Castillo [2022-01-18]
    function getNote(){

        $id = $_GET["id"];
        $getNote = $this->gmm->getNote($id);

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
        $getKPI = $this->kpi->getKPI_Siniestros("GMM", null, $year, $this->tank_auth->get_idPersona());

        echo json_encode($getKPI);
    }
    //---------------------

    //metodo para enviar el correo completo
    private function SendCorreoFull($tipo, $idSiniestro, $data = null)
    {
        $this->load->model('documentos_model', 'docs');
        $para="";
        $html="";
        $siniestro = $this->docs->getSiniestroTramite($idSiniestro);
        $complemento = json_decode($siniestro[0]["complemento_json"], true);
        $data=array(
            "folio_cia"=>$siniestro[0]["folio_cia"],
            "tipo_tramite"=>$siniestro[0]["nombre_tramite"],
            "tramite_descripcion"=>$siniestro[0]["tram_des"],
            "afectado"=>$complemento["general"]['afectado'],
            "mensaje"=>"",
            "estatus_docs"=>$siniestro[0]["estatus_doc_revision"],
            "usuario"=>$siniestro[0]["user_doc"],
            "contrasena"=>$siniestro[0]["pass_doc"],
            "url"=>base_url()."documentos"

        );
        $para=$siniestro[0]["correo_asegurado_notificacion"];
        switch ($tipo) {
            case '3':
                $html = $this->load->view('documentos/templateCorreo/correo1.php', [], true);
                $datosP=$this->docs->getSiniestroPoliza($siniestro[0]["poliza"]);
                $convertP=json_decode($datosP[0]["data_poliza"],true);
                //$para=$convertP["EMail1"];
                $para=$siniestro[0]["correo_asegurado_notificacion"];
                $data["mensaje"]="En necesario cargar los documentos, con el usuario y contraseña anexados";
                break;
        }

        //Cargamos la data del correo
        $parsedHtml = $this->parseTemplateG($html, $data);
        $dataC=array();
        $dataC['para'] = $para;
        $dataC['asunto'] = "Notificacion";
        $dataC['mensaje'] = $parsedHtml;
        
        //Se envia el correo
        $this->docs->enviarCorreo($dataC);
    }

    public function parseTemplateG($template, $variables)
    {
        foreach ($variables as $key => $value) {
            $template = str_replace('{{ ' . $key . ' }}', $value, $template);
        }
        return $template;
    }


    function testNewNot(){
        $this->load->model('servicios_model','test');
        //$value=$this->test->SendAllNewCorreos();
        $value=$this->test->SendAdminCorreo();
    }
}