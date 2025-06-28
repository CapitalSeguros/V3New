<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class servicioArchivos extends CI_Controller
{
    public $global;
    public $config;
    public $load;
    function __construct()
    {
        parent::__construct();
        $this->config->load('global', TRUE);
        $this->global = $this->config->item('global');
        $this->load->library('googledrive');
        $this->load->model("documentsmodel", "documento");
        $this->load->model("personamodelo", "persona");
    }

    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $json = file_get_contents('php://input');
            $post_data = json_decode($json, true);
            $referencia = $post_data["referencia"];
            $referencia_id =  $post_data["referencia_id"];
            $puestos = [];
            //$puestos = $this->input->post("puestos");
            //$padre = $this->input->post("padre");
            $padre = "";
            //$privado = $this->input->post("privado");
            $privado = "false";
            $IDCli = $post_data["IDCli"];
            $ListaDocs = $post_data["ListaDocs"];

            if ($referencia == "Polizas" || $referencia == "Fianzas") {
                $referencia = "Documento";
            }

            if (empty($ListaDocs)) {
                $this->responseJSON("400", "El archivo es requerido", null);
                die;
            }

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
            //$keys = array_keys($_FILES);
            foreach ($ListaDocs as $fileURL) {
                $URLFILE = base64_decode($fileURL);
                //return  $URLFILE;
                $file = $this->downloadFileFromUrl($URLFILE);
                //var_dump($file);
                if ($file['error'] != 0) {
                    return $this->responseJSON("400", "Ocurrio un problema al cargar el documento", $file);
                }
                $uploadFile = $this->googledrive->createFiles($file, $file["name"], '', $padre);
                $this->saveDoc($uploadFile->data, $privado, $referencia, $referencia_id, $puestos,0, $IDCli);
                $count++;
                $CountF++;
            }

            //$uploadFile = $this->googledrive->createFiles($_FILES[0], $nombre, $descripcion, $padre);
            //if ($uploadFile->exito) {
            if ($count > -1) {
                //$this->saveDoc($uploadFile->data, $privado, $referencia, $referencia_id, $puestos, $IDCli);
                return $this->responseJSON("200", "Se cargo con exito el documento", array());
            }
            return $this->responseJSON("400", "Ocurrio un problema al cargar el documento", array());
        } else {
            echo 'AAA';
        }
    }

    public function upload()
    {
        return $this->responseJSON("200", "Se cargo con exito el documento", array());
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
            //'usuario_alta_id' => $this->tank_auth->get_idPersona(), //
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
        if ($data["nombre"] != "Untitled") {
            $result =  $this->documento->saveDocument($data);
        }

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

    function downloadFileFromUrl($url)
    {
        // Validar URL
        //$encodedUrl = str_replace(' ', '%20', $url);
        //$encodedUrl = rawurlencode($url);
        $encodedUrl = $this->FormatURL($url);
        if (!filter_var($encodedUrl, FILTER_VALIDATE_URL)) {
            return ['error' => 'URL no válida'];
        }

        // Obtener información del encabezado
        $headers = get_headers($encodedUrl, 1);
        if (strpos($headers[0], '200') === false) {
            return ['error' => 'Archivo no encontrado en la URL'];
        }

        // Crear archivo temporal
        $tempName = tempnam(sys_get_temp_dir(), 'url_download_');

        // Usar cURL para mejor control de la descarga
        $ch = curl_init($encodedUrl);
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

    public function responseJSON($code, $message, $data)
    {
        header('Content-Type: application/json');
        echo json_encode(array('code' => $code, 'message' => $message, 'data' => $data), JSON_NUMERIC_CHECK);
        die;
    }

    public function FormatURL($url)
    {
        // Primero parsear la URL para codificar cada componente por separado
        $partes = parse_url($url);

        // Codificar cada parte necesaria
        $partes['path'] = implode('/', array_map('rawurlencode', explode('/', $partes['path'])));

        if (isset($partes['query'])) {
            parse_str($partes['query'], $query);
            $partes['query'] = http_build_query($query);
        }

        // Reconstruir la URL
        $url_valida = $partes['scheme'] .  "://" . $partes['host'] . (isset($partes['port']) ? ":{$partes['port']}" : '') . $partes['path'];
        if (isset($partes['query'])) {
            $url_valida .= '?' . $partes['query'];
        }

        return $url_valida;
    }
}
