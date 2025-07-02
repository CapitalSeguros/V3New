<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class filemanager extends TIC_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('googledrive');
        $this->load->model("documentsmodel", "documento");
        $this->load->model("personamodelo", "persona");
    }

    function index()
    {
        //$_puestos = $this->persona->getPuestos();
        $_puestos = $this->getPuestos();
        $this->responseJSON("200", "Exìto", $_puestos);
    }

    function getTrashed()
    {
        $files = $this->googledrive->GetAllTrashed();
        $filesN = array();
        //var_dump($files["files"]);
        foreach ($files["files"] as $key => $value) {
            $value->permisos = array();
            //var_dump($value);
            //echo '<br>';
            //$value["permisos"]=[];
            array_push($filesN, $value);
        }
        //var_dump($filesN);
        $this->responseJSON("200", "Èxito", array("files" => $filesN));
    }

    public function restoreFile()
    {
        $file_id = $this->input->post('file_id');
        $response = $this->googledrive->restoreFile($file_id);
        $this->documento->restaurar($file_id);

        if ($response->exito) {
            $this->responseJSON("200", "Éxito", $file_id);
        } else {
            $this->responseJSON("400", "Ocurrio un error al procesar la baja", $file_id);
        }
    }

    function delete()
    {

        $file_id = $this->input->post('file_id');
        $this->documento->eliminar($file_id);

        $response =  $this->googledrive->deleteFile($file_id);
        if ($response->exito) {
            $this->responseJSON("200", "Éxito", null);
        } else {
            $this->responseJSON("400", "Ocurrio un error al procesar la baja", null);
        }
    }

    function trashed()
    {
        $file_id = $this->input->post('file_id');

        $this->googledrive->trashFile($file_id);
        if ($this->documento->baja($file_id)) {
            $this->responseJSON("200", "Éxito", null);
        } else {
            $this->responseJSON("400", "Ocurrio un error al procesar la baja", null);
        }
    }


    function get()
    {
        $referencia = $this->input->get("referencia");
        $referencia_id = $this->input->get("referencia_id");
        $puesto_id = $this->tank_auth->get_idPersonaPuesto();
        $persona_id = $this->tank_auth->get_idPersona();


        $document = $this->documento->getDocument($referencia, $referencia_id);
        if ($document != null) {

            $arr = $this->documento->getFileByPuesto($puesto_id, array("tipo" => "application/vnd.google-apps.folder", "usuario" => $persona_id), $referencia, $referencia_id, null);
            $carr = array();
            foreach ($arr as $key => $value) {
                array_push($carr, array(
                    "label" => $value->nombre,
                    "value" => $value->file_id,
                    "showCheckbox" => false,
                    "employee" => $value->empleado,
                    "id" => $value->file_id,
                    "canDelete" => $value->usuario_alta_id == $persona_id ? true : false,
                    "name" => $value->nombre,
                    "description" => $value->descripcion,
                    "iconLink" => $value->url_icono,
                    "thumbnailLink" => $value->thumbnail_link,
                    "mimeType" => $value->tipo,
                    "size" => $value->tamanio,
                    "parent_id" => $value->parent_id,
                    "children" => array(),
                    "permisos" => $this->documento->getPuestosDocument($value->id),
                    "employee_id" => $value->usuario_alta_id,
                ));
            }
            $new = array();
            foreach ($carr as $a) {
                $new[$a['parent_id']][] = $a;
            }

            $tree = $this->createTree($new, array($carr[0]));
            $files = $this->documento->getFileByPuesto($puesto_id, array("usuario" => $persona_id), $referencia, $referencia_id, $document->file_id);
            $childs = array();
            foreach ($files as $key => $value) {
                array_push($childs, array(
                    "id" => $value->file_id,
                    "name" => $value->nombre,
                    "description" => $value->descripcion,
                    "employee" => $value->empleado,
                    "canDelete" => $value->usuario_alta_id == $persona_id ? true : false,
                    "iconLink" => $value->url_icono,
                    "thumbnailLink" => $value->thumbnail_link,
                    "mimeType" => $value->tipo,
                    "size" => $value->tamanio,
                    "parent_id" => $value->parent_id,
                    "permisos" => $this->documento->getPuestosDocument($value->id),
                    "employee_id" => $value->usuario_alta_id,
                ));
            }

            $this->responseJSON("200", "Éxito", array(
                "parent" => array(
                    "id" => $document->file_id,
                    "name" => $document->nombre,
                    "mimeType" => "application/vnd.google-apps.folder"
                ),
                "child" => $childs,
                "tree" => $tree
            ));
        }
        $this->responseJSON("400", "Éxito", array(
            "parent" => array(
                "id" => "",
                "name" => $referencia,
                "mimeType" => "application/vnd.google-apps.folder"
            )
        ));
    }

    function getV2()
    {
        $referencia = $this->input->get("referencia");
        $referencia_id = $this->input->get("referencia_id");
        $usuario_id = 0;
        $puesto_id = $this->tank_auth->get_idPersonaPuesto();
        $persona_id = $this->tank_auth->get_idPersona();
        if ($referencia == "Polizas" || $referencia == "Fianzas") {
            $referencia = "Documento";
        }
        //$document = $this->documento->getDocument($referencia, $referencia_id);
        $document = $this->documento->getDocumentV2($referencia, $referencia_id);
        if ($document != null) {
            $usuario_id = $document->IDCli;
            $arr = $this->documento->getFileByPuesto($puesto_id, array("tipo" => "application/vnd.google-apps.folder", "usuario" => $persona_id), $referencia, $referencia_id, null);
            $carr = array();
            foreach ($arr as $key => $value) {
                array_push($carr, array(
                    "label" => $value->nombre_completo,
                    "name_complete" => $value->nombre_completo,
                    "value" => $value->file_id,
                    "showCheckbox" => false,
                    "employee" => $value->empleado,
                    "id" => $value->file_id,
                    "canDelete" => $value->usuario_alta_id == $persona_id ? true : false,
                    "name" => $value->nombre_completo,
                    "description" => $value->descripcion,
                    "iconLink" => $value->url_icono,
                    "thumbnailLink" => $value->thumbnail_link,
                    "mimeType" => $value->tipo,
                    "size" => $value->tamanio,
                    "parent_id" => $value->parent_id,
                    "children" => array(),
                    "permisos" => $this->documento->getPuestosDocument($value->id),
                    "employee_id" => $value->usuario_alta_id,
                    "ruta_completa" => $value->ruta_completa
                ));
            }
            $new = array();
            foreach ($carr as $a) {
                $new[$a['parent_id']][] = $a;
            }
            $ADocument = $document;
            $ArrayElement = array(
                "label" => $ADocument->nombre_completo,
                "name_complete" => $ADocument->nombre_completo,
                "value" => $ADocument->file_id,
                "showCheckbox" => false,
                "employee" => "",
                "id" => $ADocument->file_id,
                "canDelete" => false,
                "name" => $ADocument->nombre_completo,
                "description" => $ADocument->descripcion,
                "iconLink" => $ADocument->url_icono,
                "thumbnailLink" => $ADocument->thumbnail_link,
                "mimeType" => $ADocument->tipo,
                "size" => $ADocument->tamanio,
                "parent_id" => $ADocument->parent_id,
                "children" => array(),
                "permisos" => [],
                "employee_id" => $ADocument->usuario_alta_id,
                "ruta_completa" => $value->ruta_completa
            );
            $tree = $this->createTree($new, array($ArrayElement));
            //$tree = $this->createTree($new, array((array)$document));
            $files = $this->documento->getFileByPuesto($puesto_id, array("usuario" => $persona_id), $referencia, $referencia_id, $document->file_id);
            $childs = array();
            $childsId = array();
            $exist = array();
            foreach ($files as $key => $value) {
                if ($value->file_id == null) {
                    $value->file_id = $value->id;
                }
                if (!in_array($value->file_id, $exist)) {
                    array_push($exist, $value->file_id . $value->id);
                    if (!in_array($value->file_id, $childsId)) {
                        $childsId[] = $value->file_id;
                        array_push($childs, array(
                            "id" => $value->file_id,
                            "name" => $value->nombre,
                            "name_complete" => $value->nombre_completo,
                            "description" => $value->descripcion,
                            "employee" => $value->empleado,
                            "canDelete" => $value->usuario_alta_id == $persona_id ? true : false,
                            "iconLink" => $value->url_icono,
                            "thumbnailLink" => $value->thumbnail_link,
                            "mimeType" => $value->tipo,
                            "size" => $value->tamanio,
                            "parent_id" => $value->parent_id,
                            "permisos" => $this->documento->getPuestosDocument($value->id),
                            "employee_id" => $value->usuario_alta_id,
                            "ruta_completa" => $value->ruta_completa
                        ));
                    }
                }
            }

            $filesUser = $this->documento->getFilesUserByUsuario($usuario_id);
            $documentsChilds = array();

            foreach ($filesUser as $value) {
                $isFolder = ($value->tipo === 'application/vnd.google-apps.folder') 
                            || ($value->nombre_completo == 15);
                
                $documentData = array(
                    "id" => $value->file_id,
                    "name" => $value->nombre,
                    "name_complete" => $value->nombre_completo,
                    "description" => $value->descripcion,
                    "employee" => $value->empleado,
                    "canDelete" => $value->usuario_alta_id == $persona_id ? true : false,
                    "iconLink" => $value->url_icono,
                    "thumbnailLink" => $value->thumbnail_link,
                    "mimeType" => $value->tipo,
                    "size" => $value->tamanio,
                    "parent_id" => $value->parent_id,
                    "permisos" => [],
                    "employee_id" => $value->usuario_alta_id,
                    "ruta_completa" => $value->ruta_completa,
                    "children" => array() // Array para almacenar hijos si es una carpeta
                );
                
                if ($isFolder) {
                    $documentsParent = $value;
                    $documentsTree[] = array(
                        "label"=> "CLIENTE: " . $value->nombre_completo,
                        "name_complete"=> "CLIENTE: " . $value->nombre_completo,
                        "value"=> $value->file_id,
                        "showCheckbox"=> false,
                        "employee"=> "",
                        "id"=> $value->file_id,
                        "canDelete"=> false,
                        "name"=> "CLIENTE: " . $value->nombre_completo,
                        "description"=> null,
                        "iconLink"=> null,
                        "thumbnailLink"=> null,
                        "mimeType"=> $value->tipo,
                        "size"=> null,
                        "parent_id"=> $value->parent_id,
                        "children"=> [],
                        "permisos"=> [],
                        "employee_id"=> null,
                        "ruta_completa"=> null,
                    );
                    // Es una carpeta, la añadimos al array principal
                    //$documents[$value->file_id] = $documentData;
                } else {
                    // Es un documento, lo añadimos como hijo de su carpeta padre
                    if ($value->parent_id && isset($documentsChilds[$value->parent_id])) {
                        $documentsChilds[$value->parent_id]['children'][] = $documentData;
                    } else {
                        // Documento sin padre conocido, lo añadimos al nivel principal
                        $documentsChilds[] = $documentData;
                    }
                }
            }

            // Convertir el array asociativo en indexado si es necesario
            $documentsChilds = array_values($documentsChilds);


            $this->responseJSON("200", "Éxito", array(
                "parent" => array(
                    "id" => $document->file_id,
                    "name" => $document->nombre,
                    "mimeType" => "application/vnd.google-apps.folder"
                ),
                "child" => $childs,
                "tree" => $tree,
                "documentsparent" => array(
                    "id" => $documentsParent->file_id,
                    "name" => "CLIENTE: " . $documentsParent->nombre_completo,
                    "mimeType" => "application/vnd.google-apps.folder"
                ),
                "documentstree" => $documentsTree,
                "documentschild" => $documentsChilds
            ));
        } else {
            $RefeFoldID = $this->createReferenciaFolderV2($referencia, $referencia_id);
            //Se actualiza todo los documentos que no tengan id del padre
            $this->documento->updateAllParent($RefeFoldID->id, $referencia, $referencia_id);
            $document = $this->documento->getDocument($referencia, $referencia_id);
            $arr = $this->documento->getFileByPuesto($puesto_id, array("tipo" => "application/vnd.google-apps.folder", "usuario" => $persona_id), $referencia, $referencia_id, null);
            $carr = array();
            foreach ($arr as $key => $value) {
                array_push($carr, array(
                    "label" => $value->nombre_completo,
                    "name_complete" => $value->nombre_completo,
                    "value" => $value->file_id,
                    "showCheckbox" => false,
                    "employee" => $value->empleado,
                    "id" => $value->file_id,
                    "canDelete" => $value->usuario_alta_id == $persona_id ? true : false,
                    "name" => $value->nombre,
                    "description" => $value->descripcion,
                    "iconLink" => $value->url_icono,
                    "thumbnailLink" => $value->thumbnail_link,
                    "mimeType" => $value->tipo,
                    "size" => $value->tamanio,
                    "parent_id" => $value->parent_id,
                    "children" => array(),
                    "permisos" => $this->documento->getPuestosDocument($value->id),
                    "employee_id" => $value->usuario_alta_id,
                    "ruta_completa" => $value->ruta_completa
                ));
            }
            $new = array();
            foreach ($carr as $a) {
                $new[$a['parent_id']][] = $a;
            }

            $tree = $this->createTree($new, array($carr[0]));
            $files = $this->documento->getFileByPuesto($puesto_id, array("usuario" => $persona_id), $referencia, $referencia_id, $document->file_id);
            $childs = array();
            $exist = array();
            foreach ($files as $key => $value) {
                if (!in_array($value->file_id, $exist)) {
                    array_push($exist, $value->file_id . $value->id);
                    array_push($childs, array(
                        "id" => $value->file_id,
                        "name" => $value->nombre,
                        "name_complete" => $value->nombre_completo,
                        "description" => $value->descripcion,
                        "employee" => $value->empleado,
                        "canDelete" => $value->usuario_alta_id == $persona_id ? true : false,
                        "iconLink" => $value->url_icono,
                        "thumbnailLink" => $value->thumbnail_link,
                        "mimeType" => $value->tipo,
                        "size" => $value->tamanio,
                        "parent_id" => $value->parent_id,
                        //"permisos" => $this->documento->getPuestosDocument($value->id),
                        "permisos" => [],
                        "employee_id" => $value->usuario_alta_id,
                        "ruta_completa" => $value->ruta_completa
                    ));
                }
            }

            $this->responseJSON("200", "Éxito", array(
                "parent" => array(
                    "id" => $document->file_id,
                    "name" => $document->nombre,
                    "mimeType" => "application/vnd.google-apps.folder"
                ),
                "child" => $childs,
                "tree" => $tree
            ));
        }
        /*  $this->responseJSON("400", "Éxito", array(
            "parent" => array(
                "id" => "",
                "name" => $referencia,
                "mimeType" => "application/vnd.google-apps.folder"
            )
        )); */
    }

    public function getBy($id)
    {
        $documento = $this->documento->getFileId($id);
        $documento->puestos = $this->documento->getPuestosFile($id);

        $this->responseJSON("200", "Éxito", $documento);
    }

    private function saveDoc($file, $privado, $referencia, $referencia_id = 0, $puestos = [], $revision = 0, $IDCli = null)
    {
        $Parent = strval(count($file->getParents()) > 0 ? $file->getParents()[0] : "");
        $TypeDoc = "DOCUMENT";
        $GetParent = $this->documento->getById($Parent);
        if ($GetParent != null) {
            if (strpos('Recibo', $GetParent[0]['nombre_completo']) !== false) {
                $TypeDoc = "RECEIPT";
            }
        }
        $data = array(
            'nombre' => basename($file->getName()), //
            'descripcion' => $file->getDescription(), //
            'ruta' => $file->getWebViewLink(), //
            'ruta_completa' => $file->getWebContentLink(), //
            'tipo' => $file->getMimeType(), //
            'nombre_completo' => $file->getName(), //
            'revision' => $revision, //
            'referencia' => $referencia, //
            'referencia_id' => $referencia_id, //
            'usuario_alta_id' => $this->tank_auth->get_idPersona(), //
            'parent_id' => count($file->getParents()) > 0 ? $file->getParents()[0] : "",
            'file_id' => $file->getId(), //
            'tamanio' => $file->getSize(),
            'url_icono' => $file->getIconLink(),
            'url_descargar' => $file->getWebContentLink(),
            'thumbnail_link' => $file->getThumbnailLink(),
            'fecha_alta' => date("Y-m-d"), //
            'privado' => $privado == "true" ? 1 : 0,
            'estado' => 'ACTIVO', //
            'TypeDoc' => $TypeDoc,
            'IDCli' => $IDCli
        );
        $result =  $this->documento->saveDocument($data);

        if ($privado == "true") {
            $this->documento->saveDocumentoPuesto($result->id, $puestos);
        }
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
                $this->saveDoc($folReferencia->data, false, $referencia);
                $folReferencia = $folReferencia->data;
            } else {
                $this->responseJSON("400", $folReferencia->mensaje, null);
                die;
            }
        } else {
            $docFind = $this->documento->getFileByID($exist_ref->data[0]->id);
            if ($docFind == null) {
                $this->saveDoc($exist_ref->data[0], false, $referencia, $referencia_id);
            }
            $folReferencia = $exist_ref->data[0];
        }

        if (!empty($referencia_id)) {
            $exist_ref_id = $this->googledrive->searchfile(array("name" => $referencia_id, "parents" => $folReferencia->getId()));
            if (count($exist_ref_id->data) == 0) {
                $folReferenciaId = $this->googledrive->createFolder($referencia_id, $folReferencia->getId());
                if ($folReferenciaId->exito) {
                    $this->saveDoc($folReferenciaId->data, false, $referencia, $referencia_id);
                    $folReferenciaId = $folReferenciaId->data;
                }
            } else {
                $check = $this->documento->getFileByID($exist_ref_id->data[0]->id);
                if ($check == null) {
                    $this->saveDoc($exist_ref_id->data[0], false, "DOCUMENT", $referencia_id);
                }
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

    private function createReferenciaFolderV2($referencia, $referencia_id)
    {
        $finalReference = null;
        $folReferencia = null;
        $folReferenciaId = null;
        //Se crea la referencia del padre
        $exist_ref = $this->googledrive->searchfile(array("name" => $referencia));
        if (count($exist_ref->data) == 0) {
            $folReferencia = $this->googledrive->createFolder($referencia);
            if ($folReferencia->exito) {
                $this->saveDoc($folReferencia->data, false, $referencia);
                $folReferencia = $folReferencia->data;
            } else {
                $this->responseJSON("400", $folReferencia->mensaje, null);
                die;
            }
        } else {
            $docFind = $this->documento->getFileByID($exist_ref->data[0]->id);
            if ($docFind == null) {
                $this->saveDoc($exist_ref->data[0], false, $referencia, '');
            }
            $folReferencia = $exist_ref->data[0];
        }
        //Creamos la carpeta del hijo
        if (!empty($referencia_id)) {
            $exist_ref_id = $this->googledrive->searchfile(array("name" => $referencia_id, "parents" => $folReferencia->getId()));
            if (count($exist_ref_id->data) == 0) {
                $folReferenciaId = $this->googledrive->createFolder($referencia_id, $folReferencia->getId());
                if ($folReferenciaId->exito) {
                    $this->saveDoc($folReferenciaId->data, false, $referencia, $referencia_id);
                    $folReferenciaId = $folReferenciaId->data;
                }
            } else {
                $Find = $this->documento->getFileByID($exist_ref_id->data[0]->id);
                if ($Find == null) {
                    $this->saveDoc($exist_ref_id->data[0], false, $referencia, $referencia_id);
                }
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

    function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $id = $this->input->post("id");
            $puestos = $this->input->post("puestos");
            if ($id != "") {
                $this->documento->clearDocumentoPuesto($id);
                $this->documento->saveDocumentoPuesto($id, $puestos);
                $this->responseJSON("200", "Se cargo con exito el documento", array());
                die;
            }

            $isFolder = $this->input->post("isFolder");
            $referencia = $this->input->post("referencia");
            $referencia_id = $this->input->post("referencia_id");
            $puestos = $this->input->post("puestos");
            $nombre = $this->input->post("nombre");
            $padre = $this->input->post("padre");
            $privado = $this->input->post("privado");
            $IDCli = $this->input->post("IDCli");

            if ($referencia == "Polizas" || $referencia == "Fianzas") {
                $referencia = "Documento";
            }

            if ($isFolder == "false") {

                if ($padre == "") {
                    $finalRef = $this->createReferenciaFolder($referencia, $referencia_id);
                    $padre = $finalRef->getId();
                }

                $folder = $this->googledrive->createFolder($nombre, $padre);
                if ($folder->exito) {
                    $this->saveDoc($folder->data, $privado, $referencia, $referencia_id, $puestos, null, $IDCli);
                    $this->responseJSON("200", "Se cargo con exito el documento", array());
                } else {
                    $this->responseJSON("400", $folder->mensaje, null);
                    die;
                }
            } else {
                if (empty($_FILES)) {
                    $this->responseJSON("400", "El archivo es requerido", null);
                    die;
                }
                if ($_FILES[0]["error"] != 0) {
                    switch ($_FILES["error"]) {
                        case '1':
                            $this->responseJSON("400", "El documento excede el tamaño permitido", null);
                            die;
                            break;
                        default:
                            $this->responseJSON("400", "La referencia es requerida", null);
                            die;
                            break;
                    }
                }
                //$descripcion = $this->input->post("descripcion");

                if (empty($referencia)) {
                    $this->responseJSON("400", "La referencia es requerida", null);
                    die;
                }
                if ($padre == "") {
                    $finalRef = $this->createReferenciaFolder($referencia, $referencia_id);
                    $padre = $finalRef->getId();
                }

                $count = -1;
                $CountF = 0;
                $keys = array_keys($_FILES);
                foreach ($_FILES as $file) {
                    $test = $file["name"];
                    $uploadFile = $this->googledrive->createFiles($file, $file["name"], '', $padre);
                    $this->saveDoc($uploadFile->data, $privado, $referencia, $referencia_id, $puestos, $IDCli);
                    $count++;
                    $CountF++;
                }

                //$uploadFile = $this->googledrive->createFiles($_FILES[0], $nombre, $descripcion, $padre);
                //if ($uploadFile->exito) {
                if ($count > -1) {
                    $this->saveDoc($uploadFile->data, $privado, $referencia, $referencia_id, $puestos, $IDCli);
                    return $this->responseJSON("200", "Se cargo con exito el documento", array());
                }
                return $this->responseJSON("400", "Ocurrio un problema al cargar el documento", array());
            }
        }
    }

    function createV2()
    {
        return $this->responseJSON("200", "Se cargo con exito el documento", array());
    }

    function getByParent()
    {
        $type = $this->input->get("type");
        $parent = $this->input->get("parent");
        $referencia = $this->input->get("referencia");
        $referencia_id = $this->input->get("referencia_id");
        $puesto_id = $this->tank_auth->get_idPersonaPuesto();
        $persona_id = $this->tank_auth->get_idPersona();
        $childs = array();
        $exist = array();

        if ($type == "DOCUMENT") {
            $files = $this->documento->getFileByPuesto($puesto_id, array("usuario" => $persona_id), $referencia, $referencia_id, $parent);
            foreach ($files as $key => $value) {
                if ($value->file_id == null) {
                    $value->file_id = $value->id;
                }
                if (!in_array($value->file_id, $exist)) {
                    array_push($exist, $value->file_id);
                    array_push($childs, array(
                        "id" => $value->file_id,
                        "name" => $value->nombre_completo,
                        "name_complete" => $value->nombre_completo,
                        "employee" => $value->empleado,
                        "description" => $value->descripcion,
                        "canDelete" => $value->usuario_alta_id == $persona_id ? true : false,
                        "iconLink" => $value->url_icono,
                        "thumbnailLink" => $value->thumbnail_link,
                        "mimeType" => $value->tipo,
                        "size" => $value->tamanio,
                        "parent_id" => $value->parent_id,
                        "permisos" => $this->documento->getPuestosDocument($value->id),
                        "employee_id" => $value->usuario_alta_id,
                        "ruta_completa" => $value->ruta_completa,
                    ));
                }
            }
        } else {
            $filesDocuments = $this->documento->getFilesDocumentsByParent($parent);
            foreach ($filesDocuments as $key => $value) {
                if ($value->file_id == null) {
                    $value->file_id = $value->id;
                }
                if (!in_array($value->file_id, $exist)) {
                    array_push($exist, $value->file_id);
                    array_push($childs, array(
                        "id" => $value->file_id,
                        "name" => $value->nombre_completo,
                        "name_complete" => $value->nombre_completo,
                        "employee" => $value->empleado,
                        "description" => $value->descripcion,
                        "canDelete" => $value->usuario_alta_id == $persona_id ? true : false,
                        "iconLink" => $value->url_icono,
                        "thumbnailLink" => $value->thumbnail_link,
                        "mimeType" => $value->tipo,
                        "size" => $value->tamanio,
                        "parent_id" => $value->parent_id,
                        "permisos" => $this->documento->getPuestosDocument($value->id),
                        "employee_id" => $value->usuario_alta_id,
                        "ruta_completa" => $value->ruta_completa,
                    ));
                }
            }
        }

        $arr = $this->documento->getFileByPuesto($puesto_id, array("tipo" => "application/vnd.google-apps.folder", "usuario" => $persona_id), $referencia, $referencia_id, null);
        $carr = array();
        foreach ($arr as $key => $value) {
            array_push($carr, array(
                "label" => $value->nombre_completo,
                "value" => $value->file_id,
                "showCheckbox" => false,
                "employee" => $value->empleado,
                "id" => $value->file_id,
                "canDelete" => $value->usuario_alta_id == $persona_id ? true : false,
                "name" => $value->nombre_completo,
                "description" => $value->descripcion,
                "iconLink" => $value->url_icono,
                "thumbnailLink" => $value->thumbnail_link,
                "mimeType" => $value->tipo,
                "size" => $value->tamanio,
                "parent_id" => $value->parent_id,
                "children" => array(),
                "permisos" => $this->documento->getPuestosDocument($value->id),
                "ruta_completa" => $value->ruta_completa,
                "employee_id" => $value->usuario_alta_id,
            ));
        }
        $new = array();
        foreach ($carr as $a) {
            $new[$a['parent_id']][] = $a;
        }
        $parent = isset($carr[0]) ? array($carr[0]) : array(null);

        //$tree = $this->createTree($new, array($carr[0]));
        $tree = $this->createTree($new, $parent);

        // $files = $this->googledrive->getAllFolder(array("parents" => $parent));
        $this->responseJSON("200", "Éxito", array(
            "childs" => $childs,
            "tree" => $tree
        ));
    }


    function createTree(&$list, $parent)
    {
        $tree = array();
        foreach ($parent as $k => $l) {
            if (isset($list[$l['id']])) {
                $l['children'] = $this->createTree($list, $list[$l['id']]);
            }
            $tree[] = $l;
        }
        return $tree;
    }

    function ShareFile()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $puestos = $this->input->post("puestos");
            $mensaje = $this->input->post("descripcion");
            $id = $this->input->post("id");
            $file = json_decode($this->input->post("file"), true);
            //var_dump(json_decode($file,true));
            $this->sendNotificacionManual("COMPARTIR", array("File" => $file, "Mensaje" => $mensaje, "Puestos" => $puestos, "referencia" => "0"));
        }
    }

    function move()
    {
        $IdDoc = $this->input->post("IdDoc");
        $ref = $this->input->post("ref");
        $refId = $this->input->post("refId");
        $padreDoc = $this->input->post("IdPadre");

        try {
            //se realiza los metodos de google
            $GoogleData = $this->googledrive->moveFile($IdDoc, $padreDoc);
            //Actualizamos la parte de la base de datos
            $dta = array(
                "parent_id" => $padreDoc
            );
            $UpdateF = $this->documento->UpdateFileDB($IdDoc, $dta);
            return $this->responseJSON("200", "Se cargo movio con exito el documento.", array());
        } catch (\Throwable $th) {
            return $this->responseJSON("400", $th, array());
        }
    }

    function copy()
    {
        $IdDoc = $this->input->post("IdDoc");
        $ref = $this->input->post("ref");
        $refId = $this->input->post("refId");
        $padreDoc = $this->input->post("IdPadre");

        try {
            //se realiza los metodos de google
            $GoogleData = $this->googledrive->copyFile($IdDoc, "Copia", $padreDoc);
            //Actualizamos la parte de la base de datos
            $this->saveDoc($GoogleData->data, null, $ref, $padreDoc);
            $FindCopy = $this->documento->getById($IdDoc);
            $FindPadre = $this->documento->getById($padreDoc);
            $IdDocCopy = $GoogleData->data->getId();
            $this->documento->UpdateDocument($IdDocCopy, array(
                "nombre_completo" => "Copia_" . $FindCopy[0]['nombre'],
                "nombre" => "Copia" . $FindCopy[0]['nombre'],
                "referencia_id" => $FindPadre[0]['referencia_id'],
                "url_icono" => $FindCopy[0]['url_icono'],
                "parent_id" => $padreDoc
            ));
            //$FindDoc=$this->documento->getById($IdDocCopy);
            return $this->responseJSON("200", "Se cargo movio con exito el documento.", array());
        } catch (\Throwable $th) {
            return $this->responseJSON("400", $th, []);
        }
    }

    function refDocumentos()
    {
        $ref = $this->input->post("ref");
        $refId = $this->input->post("refId");
        $Documentos = $this->input->post("Carpetas");

        if ($Documentos != "") {
            $Elementos = explode(",", $Documentos);
            //$document = $this->documento->getDocument($ref, $refId);
            $document = $this->documento->getDocumentParentLoad($ref, $refId);
            $Find = [];
            if ($document == null) {
                $FindRef = $this->createReferenciaFolder($ref, $refId);
                //$ref="DOCUMENT";
                $document = $this->documento->getDocument($ref, $refId);
                if ($document == null) {
                    $Find["file_id"] = $FindRef->file_id;
                } else {
                    $Find["file_id"] = $document->file_id;
                }
            } else {
                $Find["file_id"] = $document->file_id;
            }
            //$AllFind = $this->documento->getDocumentsByParent($document->file_id);
            foreach ($Elementos as $key => $value) {
                $FindByname = $this->documento->FindByName($value, $refId);
                if ($FindByname == null) {
                    //$folder = $this->googledrive->createFolder($value, $Find->file_id);
                    $folder = $this->googledrive->createFolder($value,  $Find["file_id"]);
                    if ($folder->exito) {
                        $this->saveDoc($folder->data, 0, "DOCUMENT", $refId, [], 1);
                    } else {
                        return $this->responseJSON("400", "error.", $folder);
                    }
                }
            }
            return $this->responseJSON("200", "Exito.", array());
        } else {
            return $this->responseJSON("400", "No existe referencias.", []);
        }

        /* $response =  $this->googledrive->deleteFile($file_id);
        if ($response->exito) {
            $this->responseJSON("200", "Éxito", null);
        } */
    }

    function downloadFileFromUrl($url)
    {
        // Validar URL
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return ['error' => 'URL no válida'];
        }

        // Obtener información del encabezado
        $headers = get_headers($url, 1);
        if (strpos($headers[0], '200') === false) {
            return ['error' => 'Archivo no encontrado en la URL'];
        }

        // Crear archivo temporal
        $tempName = tempnam(sys_get_temp_dir(), 'url_download_');

        // Usar cURL para mejor control de la descarga
        $ch = curl_init($url);
        $fp = fopen($tempName, 'wb');

        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        if (!curl_exec($ch)) {
            fclose($fp);
            unlink($tempName);
            return ['error' => 'Error al descargar: ' . curl_error($ch)];
        }

        curl_close($ch);
        fclose($fp);

        // Determinar tipo MIME (mejor que mime_content_type)
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $tempName);
        finfo_close($finfo);

        // Obtener nombre del archivo
        $fileName = basename(parse_url($url, PHP_URL_PATH));
        if (empty($fileName)) {
            $fileName = 'downloaded_file_' . time();
        }

        return [
            'name' => $fileName,
            'type' => $mimeType,
            'tmp_name' => $tempName,
            'error' => 0,
            'size' => filesize($tempName)
        ];
    }

    //uso
    /* $file = downloadFileFromUrl('https://www.example.com/images/sample.jpg');

    if (!isset($file['error'])) {
        $targetPath = 'uploads/' . uniqid() . '_' . $file['name'];
        
        // Mover el archivo (usamos rename porque no es un upload real)
        if (rename($file['tmp_name'], $targetPath)) {
            echo "Archivo guardado en: $targetPath";
        } else {
            echo "Error al mover el archivo";
            unlink($file['tmp_name']); // Limpiar
        }
    } else {
        echo "Error: " . $file['error'];
    } */
}
