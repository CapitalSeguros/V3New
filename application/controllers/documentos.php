<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class documentos extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('documentos_model', 'docs');
        $this->load->model('gmm_model', 'gmm');
        $this->load->library('session');
        $this->load->library('googledrive');
        $this->load->helper('url');
        
    }

    //pagina de inicio de GMMM
    function index()
    {
        $this->load->library('docgeneral');
        if ($this->tank_auth->is_logged_in()) {
            redirect('/', 'refresh');
        }
        $this->load->view('documentos/login.php', []);
    }

    function Login()
    {
        $data = array(
            "usuario" => $this->input->post('user'),
            "pass" => $this->input->post('pass')
        );
        $response = $this->docs->ValidateUser($data);
        if ($response != null) {
            $res = base64_encode(json_encode(array("id" => $response[0]["id_siniestro"], "estatus" => $response[0]["estatus_doc_cliente"])));
            $this->responseJSON(200, "Exito", ["data" => $res]);
        } else {
            $this->responseJSON(400, "Error", ["data" => "Credenciales no validas"]);
        }
    }

    function up($access = null)
    {
        if ($this->tank_auth->is_logged_in()) {
            redirect('/documentos', 'refresh');
        }
        if ($access == "" || $access == null) {
            redirect('/documentos', 'refresh');
        }
        try {
            $accesFull = base64_decode($access);
            $validateAccess = json_decode($accesFull);

            $data = [];
            $data["documentos"] = "const _Documents = " . json_encode($this->gmm->getDocuments()) . ";";
            $data["siniestro"] = $this->docs->getSiniestroTramite($validateAccess->id); //"12288"
            $data["documentos_carga"] = $this->docs->getDocuments($data["siniestro"][0]["tipo_tramite"]);
            $tramite_id = $data["siniestro"][0]["id_tramite"];
            $data["up_documents"] = $this->docs->getUpDocuments($data["siniestro"][0]["id_tramite"]); //id_tramite
            $data["access"] = $access;

            $this->load->view('documentos/index.php', $data);
        } catch (\Throwable $th) {
            echo "error " . $th;
        }
    }

    function SaveDocumentos()
    {
        $id_siniestro = $this->input->post('id_siniestro');
        $inset_id = $this->input->post('id_tram');
        $tipo_Accion = $this->input->post('tipo');
        $access = $this->input->post('acess');

        $accesFull = base64_decode($access);
        $validateAccess = json_decode($accesFull);


        $dataFind = $this->docs->getSiniestroTramite($validateAccess->id);
        if ($dataFind == null) {
            $this->responseJSON(400, "Error", ["data" => "Credenciales no validas"]);
        }
        if ($dataFind[0]["id"] != $id_siniestro) {
            $this->responseJSON(400, "Error", ["data" => "Credenciales no validas"]);
        }

        $estatus = "";
        switch ($tipo_Accion) {
            case '1':
                $estatus = "PENDIENTE";
                break;
            case '2':
                $estatus = "REVISION";

                break;
            default:
                $estatus = "PENDIENTE";
                break;
        }

        $result = new \stdClass;
        $result->ok = true;

        //subo documentos al drive
        if (!empty($_FILES)) {
            $pruebaid = $inset_id;
            $keys = array_keys($_FILES);
            $finalRef = $this->createReferenciaFolder('GMM', '');
            $padre = $finalRef->getId();
            $folder = $this->googledrive->createFolder('GMM_' . $inset_id, $padre);
            $count = 0;
            foreach ($_FILES as $file) {
                $FormatSplit = explode('_', strval($keys[$count]));
                $CantidadSplit = count($FormatSplit);
                $tipo_campo = $FormatSplit[$CantidadSplit - 2];
                $tipo_tramite = $FormatSplit[$CantidadSplit - 1];
                $uploadFile = $this->googledrive->createFiles($file, $keys[$count], 'documentación del registro', $folder->data->getId());
                //$arrayFiles[]=$uploadFile;
                $this->saveDoc($uploadFile->data, '', 'GMM', $inset_id, [], $tipo_campo, $estatus);
                $count++;
            }
            $result->ok = true;
        } //fin subir documentos

        //Agregamos en la db
        if ($tipo_Accion == 2) {
            $this->docs->UpdateAllDocs($dataFind[0]["id_tramite"]);
            $this->docs->UpdateTramiteEstatus($dataFind[0]["id_tramite"], $estatus);
        }

        //Enviamos el correo
        if ($estatus == "REVISION")
            $this->SendCorreoFull(1, $id_siniestro, null);

        if ($result->ok === false) {
            $this->responseJSON("400", "Ocurrio un error al guardar la información", []);
        } else {
            $this->responseJSON("200", "Se guardo con Éxito", []);
        }
    }

    function SaveEstatus()
    {
        $result = new \stdClass;
        $result->ok = true;

        $id_siniestro = $this->input->post('id_siniestro');
        $inset_id = $this->input->post('id_tram');
        $tipo_Accion = $this->input->post('tipo');
        $access = $this->input->post('acess');
        $comentario = $this->input->post('comentario');

        $EstatusDocs = $this->input->post('validaciones');

        $allEstatus = array();
        foreach ($EstatusDocs as $key => $value) {
            $explodeValue = explode("_", $value);
            $this->docs->AgentValidateDoc($explodeValue[0], $explodeValue[1], $inset_id);
            $allEstatus[] = $explodeValue[1];
            $result->ok = true;
        }

        $estatusActualizar = "";
        if (in_array("INCORRECTO", $allEstatus)) {
            $estatusActualizar = "INCORRECTO";
        } else {
            $estatusActualizar = "ACTIVO";
        }
        $result->ok = true;
        $this->SendCorreoFull(2, $id_siniestro, null);

        $this->docs->UpdateTramiteEstatus($inset_id, $estatusActualizar);
        $this->docs->UpdateTramiteComentario($inset_id, trim($comentario));

        if ($result->ok === false) {
            $this->responseJSON("400", "Ocurrio un error al guardar la información", []);
        } else {
            $this->responseJSON("200", "Se guardo con Éxito", []);
        }
    }

    function check($access = null)
    {
        if (!$this->tank_auth->is_logged_in()) {
            redirect('/documentos', 'refresh');
        }
        if ($access == "" || $access == null) {
            redirect('/documentos', 'refresh');
        }

        $accesFull = base64_decode($access);
        $validateAccess = json_decode($accesFull);

        $data = [];
        $data["documentos"] = "const _Documents = " . json_encode($this->gmm->getDocuments()) . ";";
        $data["siniestro"] = $this->docs->getSiniestroTramite($validateAccess->id); //"12288"
        $data["documentos_carga"] = $this->docs->getDocuments($data["siniestro"][0]["tipo_tramite"]);
        $tramite_id = $data["siniestro"][0]["id_tramite"];
        $data["up_documents"] = $this->docs->getUpDocuments($data["siniestro"][0]["id_tramite"]); //id_tramite
        $data["access"] = $access;


        $this->load->view('documentos/check.php', $data);
    }

    function deleteDoc()
    {
        $id = $this->input->post('id');
        //elminamos de google
        $this->googledrive->deleteFile($id);
        //eliminamos de la db
        $this->docs->deleteDocDB($id);

        $this->responseJSON("200", "Se realizó con Éxito", []);
    }

    public function parseTemplate($template, $variables)
    {
        foreach ($variables as $key => $value) {
            $template = str_replace('{{ ' . $key . ' }}', $value, $template);
        }
        return $template;
    }

    /* public function test()
    {
        $Send=$this->SendCorreoFull(2,12288);
        $test2 = "";
    } */

    //Metodos para guadar en Google Drive
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

    private function saveDoc($file, $privado, $referencia, $referencia_id = 0, $puestos = [], $tipoTram, $estatus)
    {
        $data = array(
            'nombre' => basename($file->getName()), //
            'descripcion' => $file->getDescription(), //
            'ruta' => $file->getWebViewLink(), //
            'ruta_completa' => $file->getWebContentLink(), //
            'tipo' => $file->getMimeType(), //
            'nombre_completo' => $file->getName(), //
            'revision' => $tipoTram, //
            'referencia' => $referencia, //
            'referencia_id' => $referencia_id, //
            //'usuario_alta_id' => $this->tank_auth->get_idPersona(),//
            'parent_id' => count($file->getParents()) > 0 ? $file->getParents()[0] : "",
            'file_id' => $file->getId(), //
            'tamanio' => $file->getSize(),
            'url_icono' => $file->getIconLink(),
            'url_descargar' => $file->getWebContentLink(),
            'thumbnail_link' => $file->getThumbnailLink(),
            'fecha_alta' => date("Y-m-d H:i:s"), //
            'estado' => "PENDIENTE"
        );
        $result =  $this->docs->saveDocument($data);
    }

    public function responseJSON($code, $message, $data)
    {
        header('Content-Type: application/json');
        echo json_encode(array('code' => $code, 'message' => $message, 'data' => $data), JSON_NUMERIC_CHECK);
        die;
    }

    //metodo para enviar el correo completo
    private function SendCorreoFull($tipo, $idSiniestro, $data = null)
    {
        $para = "";
        $html = "";
        $siniestro = $this->docs->getSiniestroTramite($idSiniestro);
        $complemento = json_decode($siniestro[0]["complemento_json"], true);
        $data = array(
            "folio_cia" => $siniestro[0]["folio_cia"],
            "tipo_tramite" => $siniestro[0]["nombre_tramite"],
            "tramite_descripcion" => $siniestro[0]["tram_des"],
            "afectado" => $complemento["general"]['afectado'],
            "mensaje" => "",
            "estatus_docs" => $siniestro[0]["estatus_doc_revision"],
            "usuario" => $siniestro[0]["user_doc"],
            "constrasena" => $siniestro[0]["pass_doc"],
            "url" => base_url() . "documentos/"
        );
        switch ($tipo) {
            case '1':
                $agente = $this->docs->getAgenteByid($siniestro[0]["agregado_por"]);
                $para = $agente[0]["correo"];
                $html = $this->load->view('documentos/templateCorreo/correo.php', [], true);
                $data["mensaje"] = "El usuario ha cargado documentos para su validacion, verificar el V3.";
                break;
            case '2':
                $html = $this->load->view('documentos/templateCorreo/correo2.php', [], true);
                $datosP = $this->docs->getSiniestroPoliza($siniestro[0]["poliza"]);
                $convertP = json_decode($datosP[0]["data_poliza"], true);
                //var_dump($siniestro[0]);
                //$para = $convertP["EMail1"];
                $para=$siniestro[0]["correo_asegurado_notificacion"];
                $data["mensaje"] = "El agente ha validado los documentos, verificar el sistema.";
                break;
            case '2':
                $html = $this->load->view('documentos/templateCorreo/correo2.php', [], true);
                $datosP = $this->docs->getSiniestroPoliza($siniestro[0]["poliza"]);
                $convertP = json_decode($datosP[0]["data_poliza"], true);
                $para=$siniestro[0]["correo_asegurado_notificacion"];
                $data["mensaje"] = "El agente ha validado los documentos, verificar el sistema.";
                break;
        }

        //Cargamos la data del correo
        $parsedHtml = $this->parseTemplate($html, $data);
        $dataC = array();
        $dataC['para'] = $para;
        $dataC['asunto'] = "Notificacion";
        $dataC['mensaje'] = $parsedHtml;

        //var_dump($dataC);

        //Se envia el correo
        $this->docs->enviarCorreo($dataC);
    }


}
