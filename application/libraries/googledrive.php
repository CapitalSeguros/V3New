<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require __DIR__ . '/drive/vendor/autoload.php';
/*
Recuperar carpetas y archivos
Buscar por extencion o por nombre
 
 Debe retornar el id,nombre,mime type, tipo de dato, fecha creacion, fecha de modificacion
*/
if (!defined('CREDENTIALS_PATH'))
	define('CREDENTIALS_PATH', __DIR__ . '/drive/config/credenciales.json');

if (!defined('CREDENTIALS_PATH_USER'))
	define('CREDENTIALS_PATH_USER', __DIR__ . '/drive/config/user.json');

class googledrive
{

	const TOKEN_KEY = "shdwbx.gdrive.access_token";


	const SYSDIR = 'shdwbx.drive';
	public $client;
	private $service;
	private $redirect_uri;
	var $OAuth2Service;
	var $Tokens;
	var $Ready = FALSE;


	public function __construct()
	{
		$this->CI = &get_instance();
		$this->CI->load->library('session');
		$this->CI->load->helper('url');

		$this->client = new Google_Client();
		$this->client->setAuthConfig(CREDENTIALS_PATH);
		$this->client->setAccessType("offline");
		$this->client->setApprovalPrompt('force');
		//$this->client->setRedirectUri($this->redirect_uri);
		$this->client->addScope(
			Google_Service_Drive::DRIVE,
			Google_Service_Drive::DRIVE_FILE,
			Google_Service_Drive::DRIVE_APPDATA,
			Google_Service_Drive::DRIVE_METADATA,
			Google_Service_Drive::DRIVE_SCRIPTS
		);

		$this->service = new Google_Service_Drive($this->client);

		$this->redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . "/V3/welcome";

		$this->client->setRedirectUri($this->redirect_uri);
		$this->client->setAccessType('offline');
		$this->client->setApprovalPrompt('force');

		$accessToken = array();
		if (file_exists(CREDENTIALS_PATH_USER)) {
			$accessToken = json_decode(file_get_contents(CREDENTIALS_PATH_USER), true);
			$this->client->setAccessToken($accessToken);
		}
		// If there is no previous token or it's expired.
		if ($this->client->isAccessTokenExpired()) {
			// Refresh the token if possible, else fetch a new one.
			if ($this->client->getRefreshToken()) {
				$this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
			} else {
				$authUrl = $this->client->createAuthUrl();
				printf("Open the following link in your browser:\n%s\n", $authUrl);
				print 'Enter verification code: ';
				if ($code = $this->CI->input->get('code', TRUE)) {
					$this->client->authenticate($code);
				} else {
					if (!empty($this->redirect_uri)) {
						redirect($this->client->createAuthUrl());
					}
				}
			}
			if (!file_exists(dirname(CREDENTIALS_PATH_USER))) {
				mkdir(dirname(CREDENTIALS_PATH_USER), 0700, true);
			}
			$accessToken = array_merge($accessToken, $this->client->getAccessToken());
			file_put_contents(CREDENTIALS_PATH_USER, json_encode($accessToken));
		}
	}

	/*
	Paginacion
	Listar archivos y carpetas
	*/
	public function getAllFiles($opcion)
	{
	}

	public function get($id)
	{
		$optParams = array(
			'fields' => 'id,name,mimeType,description,thumbnailLink,fileExtension,size,exportLinks,webContentLink,webViewLink,createdTime,modifiedTime,version,parents,iconLink',
			'supportsAllDrives' => true
		);
		$results = $this->service->files->get($id, $optParams);
		return  $results;
	}

	//En lista todos los archivos del google drive
	public function getAllFolder($opcion = null)
	{
		$q = "";
		foreach ($opcion as $key => $value) {
			switch ($key) {
				case 'parents':
					$q = "'$value' in parents AND ";
					break;
				default:
					# code...
					break;
			}
		}
		$q = substr($q, 0, -4);
		$optParams = array(
			'pageSize' => 100,
			'fields' => 'nextPageToken, files(id,name,mimeType,description,thumbnailLink,fileExtension,size,exportLinks,webContentLink,webViewLink,createdTime,modifiedTime,version,parents,iconLink)',
			'q' => $q,
			'supportsAllDrives' => true
		);

		$results = $this->service->files->listFiles($optParams);

		$response = array(
			"files" => $results->getFiles(),
			"nextToken" => $results->getnextPageToken()
		);
		return  $response;
	}

	public function createFolder($folderName, $parentId = null)
	{
		try {
			$results = new stdClass();
			$results->exito = false;
			$results->mensaje = "";
			$results->data = null;

			if (!empty($folderName)) {
				$fileMetadata = new \Google_Service_Drive_DriveFile(
					array(
						'name' 	=> $folderName,
						'parents' 	=> array($parentId),
						'mimeType' 	=> 'application/vnd.google-apps.folder',
					)
				);

				$file = $this->service->files->create($fileMetadata, array('fields' => 'id,name,mimeType,description,thumbnailLink,fileExtension,size,exportLinks,webContentLink,createdTime,modifiedTime,version,iconLink,parents,originalFilename'));
				$results->exito = true;
				$results->data = $file;
				$permissionService = new Google_Service_Drive_Permission();
				$permissionService->role = "reader";
				$permissionService->type = "anyone"; // anyone with the link can view the file
				$this->service->permissions->create($file->getId(), $permissionService);
			} else {
				$results->mensaje = "El nombre de la carpeta a crear no puede ser vacío";
			}
		} catch (Exception $e) {
			$results->mensaje = $e->getMessage();
		}

		return $results;
	}

	public function GetAllTrashed()
	{
		$q = "trashed = true";


		$optParams = array(
			'pageSize' => 100,
			'fields' => 'nextPageToken, files(id,name,mimeType,description,thumbnailLink,fileExtension,size,exportLinks,webContentLink,webViewLink,createdTime,modifiedTime,version,parents,iconLink,trashed)',
			'q' => $q,
			'supportsAllDrives' => true
		);

		$results = $this->service->files->listFiles($optParams);

		$response = array(
			"files" => $results->getFiles(),
			"nextToken" => $results->getnextPageToken()
		);
		return  $response;
	}

	public function createFiles($file, $title, $description,  $parentid = null)
	{
		try {

			$results = new stdClass();
			$results->exito = false;
			$results->mensaje = "";
			$results->data = null;
			$fechaActual = date('d-m-Y H:i:s');

			$fileMetadata = new Google_Service_Drive_DriveFile(array(
				'name' => $title,
				'description' => $description,
				'parents' 	=> array(@$parentid)
			));

			$content = file_get_contents($file["tmp_name"]);
			$mimeType = $file["type"];

			$file = $this->service->files->create($fileMetadata, array(
				'data' => $content,
				'mimeType' => $mimeType,
				'uploadType' => 'multipart',
				'fields' => 'id'
			));

			$results->data = $this->get($file->getId());
			$results->mensaje = "El archivo subio con exíto";
			$results->exito = true;
			//añadir permisos
			$permissionService = new Google_Service_Drive_Permission();
			$permissionService->role = "reader";
			$permissionService->type = "anyone"; // anyone with the link can view the file
			$this->service->permissions->create($file->getId(), $permissionService);
		} catch (Exception $e) {
			$mensaje = $e->getMessage();
			$json = json_decode($mensaje, true);
			$reason = $json["error"]["errors"][0]["reason"];
			$message = $json["error"]["errors"][0]["message"];
			$code = $json["error"]["code"];

			$results->mensaje = array(
				"code" => $code,
				"reason" => $reason,
				"message" => $message
			);
		}
		return $results;
	}

	public function deleteFile($fileId)
	{
		try {
			$results = new stdClass();
			$results->exito = false;
			$results->mensaje = "";
			$results->data = null;

			$delete = $this->service->files->delete($fileId);

			$results->mensaje = "Se elimino el archivo $fileId";
			$results->exito = true;
		} catch (Exception $e) {
			$mensaje = $e->getMessage();
			$json = json_decode($mensaje, true);
			$reason = $json["error"]["errors"][0]["reason"];
			$message = $json["error"]["errors"][0]["message"];
			$code = $json["error"]["code"];

			$results->mensaje = array(
				"code" => $code,
				"reason" => $reason,
				"message" => $message
			);
		}
		return $results;
	}

	public function trashFile($fileId)
	{
		try {
			$results = new stdClass();
			$results->exito = false;
			$results->mensaje = "";
			$results->data = null;

			$fileMetadata = new Google_Service_Drive_DriveFile();
			$fileMetadata->setTrashed(true);

			$file = $this->service->files->update($fileId, $fileMetadata, array(
				// 'modifiedTime' => $fechaActual,
				'uploadType' => 'multipart',
				'fields' => 'id,name,mimeType,description,thumbnailLink,fileExtension,size,exportLinks,webContentLink,createdTime,modifiedTime,version,iconLink,parents,originalFilename'
			));

			$results->data = $file;
			$results->mensaje = "Se actualizó el archivo corectamente";
			$results->exito = true;
		} catch (Exception $e) {
			$mensaje = $e->getMessage();
			$json = json_decode($mensaje, true);
			$reason = $json["error"]["errors"][0]["reason"];
			$message = $json["error"]["errors"][0]["message"];
			$code = $json["error"]["code"];

			$results->mensaje = array(
				"code" => $code,
				"reason" => $reason,
				"message" => $message
			);
		}
		return $results;
	}

	public function restoreFile($fileId)
	{
		try {
			$results = new stdClass();
			$results->exito = false;
			$results->mensaje = "";
			$results->data = null;

			$fileMetadata = new Google_Service_Drive_DriveFile();
			$fileMetadata->setTrashed(false);

			$file = $this->service->files->update($fileId, $fileMetadata, array(
				// 'modifiedTime' => $fechaActual,
				'uploadType' => 'multipart',
				'fields' => 'id,name,mimeType,description,thumbnailLink,fileExtension,size,exportLinks,webContentLink,createdTime,modifiedTime,version,iconLink,parents,originalFilename'
			));

			$results->data = $file;
			$results->mensaje = "Se actualizó el archivo corectamente";
			$results->exito = true;
		} catch (Exception $e) {
			$mensaje = $e->getMessage();
			$json = json_decode($mensaje, true);
			$reason = $json["error"]["errors"][0]["reason"];
			$message = $json["error"]["errors"][0]["message"];
			$code = $json["error"]["code"];

			$results->mensaje = array(
				"code" => $code,
				"reason" => $reason,
				"message" => $message
			);
		}
		return $results;
	}
	public function updateFiles($fileId, $file, $newname = null, $newdescripcion = null)
	{
		try {
			$fileId = $fileId;
			$additionalParams = array();
			$results = new stdClass();
			$results->exito = false;
			$results->mensaje = "";
			$results->data = null;
			$fechaActual = date('d-m-Y H:i:s');

			$file_tmp_name 	= $file["file"]["tmp_name"];
			$mimeType 		= $file["file"]["type"];
			$title 			= $file["file"]["name"];
			$error    		= $file["file"]["error"];
			$size     		= $file["file"]["size"];
			$ext      = strtolower(pathinfo($title, PATHINFO_EXTENSION));

			$files = $this->service->files->get($fileId);

			if (empty($title) & !empty($newname) & empty($mimeType)) {
				$fileId = $files->getId();
				$mimeType = $files->getMimeType();
			}
			if (!empty($newname)) {
				$title = $newname;
			}

			if (!empty($file_tmp_name) & !empty($mimeType) & !empty($title)) {
				$additionalParams = array(
					'data' => @file_get_contents($file_tmp_name),
					'mimeType' => $mimeType,
					'uploadType' => 'multipart'
				);
			}

			$fileMetadata = new Google_Service_Drive_DriveFile();
			$fileMetadata->setName($title);
			$fileMetadata->setMimeType($mimeType);

			if (!empty($newdescripcion)) {
				$fileMetadata->setDescription($newdescripcion);
			}

			$file = $this->service->files->update($fileId, $fileMetadata, array(
				'data' => @file_get_contents($file_tmp_name),
				'mimeType' => $mimeType,
				// 'modifiedTime' => $fechaActual,
				'uploadType' => 'multipart',
				'fields' => 'id,name,mimeType,description,thumbnailLink,fileExtension,size,exportLinks,webContentLink,createdTime,modifiedTime,version,iconLink,parents,originalFilename'

			));

			$results->data = $file;
			$results->mensaje = "Se actualizó el archivo corectamente";
			$results->exito = true;
		} catch (Exception $e) {
			$mensaje = $e->getMessage();
			$json = json_decode($mensaje, true);
			$reason = $json["error"]["errors"][0]["reason"];
			$message = $json["error"]["errors"][0]["message"];
			$code = $json["error"]["code"];

			$results->mensaje = array(
				"code" => $code,
				"reason" => $reason,
				"message" => $message
			);
		}
		return $results;
	}

	public function searchfile($params)
	{
		try {
			$results = new stdClass();
			$results->exito = false;
			$results->mensaje = "";
			$results->data = null;

			$name = @$params["name"];
			$mimeType = @$params["mimeType"];
			$fechaInicio = @$params["fechainicio"];
			$fechaFin = @$params["fechafin"];
			$parents = @$params["parents"];

			$search = "trashed = false AND ";

			if (!empty($name)) {
				$search .= " name ='$name' and ";
			}
			if (!empty($parents)) {
				$search .= " '$parents' in parents AND ";
			}
			if (!empty($mimeType)) {
				$search .= " mimeType = '$mimeType' and ";
			}

			if (!empty($fechaInicio)) {
				$search .= " modifiedTime >= '$fechaInicio' and ";
			}

			if (!empty($fechaFin)) {
				$search .= " modifiedTime =< '$fechaFin' and ";
			}

			$search = substr($search, 0, -4);

			$optParams = array(
				'fields' => 'nextPageToken, files(id, name, trashed, webViewLink, mimeType, ownedByMe, parents, fileExtension, webContentLink,thumbnailLink)',
				"q" => $search
			);

			$file = $this->service->files->listFiles($optParams);
			$results->data = $file->getFiles();
			$results->mensaje = "Se encontro el archivo";
			$results->exito = true;
		} catch (Exception $e) {
			$mensaje = $e->getMessage();
			$json = json_decode($mensaje, true);
			$reason = $json["error"]["errors"][0]["reason"];
			$message = $json["error"]["errors"][0]["message"];
			$code = $json["error"]["code"];

			$results->mensaje = array(
				"code" => $code,
				"reason" => $reason,
				"message" => $message
			);
		}
		return $results;
	}


	public function searchfiles($params)
	{
		try {
			$results = new stdClass();
			$results->exito = false;
			$results->mensaje = "";
			$results->data = null;

			$name = @$params["name"];
			$name = @$params["name"];
			$mimeType = @$params["mimeType"];
			$fechaInicio = @$params["fechainicio"];
			$fechaFin = @$params["fechafin"];

			$search = "";
			if (!empty($name)) {
				$search .= " name contains '$name' and ";
			}

			if (!empty($mimeType)) {
				$search .= " mimeType = '$mimeType' and ";
			}

			if (!empty($fechaInicio)) {
				$search .= " modifiedTime >= '$fechaInicio' and ";
			}

			if (!empty($fechaFin)) {
				$search .= " modifiedTime =< '$fechaFin' and ";
			}

			$search = substr($search, 0, -4);

			$optParams = array(
				'fields' => 'nextPageToken, files(id, name, trashed, webViewLink, mimeType, ownedByMe, parents, fileExtension, webContentLink)',
				"q" => $search
			);

			$file = $this->service->files->listFiles($optParams);
			$file = $file->getFiles();

			$results->data = $file;
			$results->mensaje = "Se encontro el archivo";
			$results->exito = true;
		} catch (Exception $e) {
			$mensaje = $e->getMessage();
			$json = json_decode($mensaje, true);
			$reason = $json["error"]["errors"][0]["reason"];
			$message = $json["error"]["errors"][0]["message"];
			$code = $json["error"]["code"];

			$results->mensaje = array(
				"code" => $code,
				"reason" => $reason,
				"message" => $message
			);
		}
		return $results;
	}

	public function copyFile($originFileId, $copyTitle, $newParentId = null)
	{
		$copiedFile = new Google_Service_Drive_DriveFile();
		$copiedFile->setName($copyTitle);
		try {
			$results = new stdClass();
			$results->exito = false;
			$results->mensaje = "";
			$results->data = null;
			$optParams = array();

			if ($newParentId != null) {
				$copiedFile->setParents(array($newParentId));
			} else {
				$copiedFile->setParents(array("root"));
			}

			$response = $this->service->files->copy($originFileId, $copiedFile);

			$results->data = $response;
			$results->mensaje = "Se copio el archivo";
			$results->exito = true;
		} catch (Exception $e) {
			$mensaje = $e->getMessage();
			$json = json_decode($mensaje, true);
			$reason = $json["error"]["errors"][0]["reason"];
			$message = $json["error"]["errors"][0]["message"];
			$code = $json["error"]["code"];

			$results->mensaje = array(
				"code" => $code,
				"reason" => $reason,
				"message" => $message
			);
		}
		return $results;
	}

	public function moveFile($fileId, $newParentId)
	{
		try {

			$results = new stdClass();
			$results->exito = 0;
			$results->mensaje = "";
			$results->data = null;

			if (empty($fileId)) {
				return $results->mensaje = "No se ha seleccionado un archivo para mover";
			} else {
				if (empty($newParentId)) {
					return $results->mensaje = "No se ha seleccionado el folder para mover el arvhivo";
				}
			}
			$emptyFileMetadata = new Google_Service_Drive_DriveFile();

			$file = $this->service->files->get($fileId, array('fields' => 'parents'));
			$previousParents = join(',', $file->parents);

			$file = $this->service->files->update($fileId, $emptyFileMetadata, array(
				'addParents' => $newParentId,
				'removeParents' => $previousParents,
				'fields' => 'id, parents'
			));

			$results->data = $file;
			$results->mensaje = "Se movio el archivo $fileId correctamente a $newParentId";
			$results->exito = 1;
		} catch (Exception $e) {
			$mensaje = $e->getMessage();
			$json = json_decode($mensaje, true);
			$reason = $json["error"]["errors"][0]["reason"];
			$message = $json["error"]["errors"][0]["message"];
			$code = $json["error"]["code"];

			$results->mensaje = array(
				"code" => $code,
				"reason" => $reason,
				"message" => $message
			);
		}

		return $results;
	}
	public function emptyTrash()
	{
		try {
			return $this->service->files->emptyTrash();
		} catch (Exception $e) {
			print "An error occurred: " . $e->getMessage();
		}
		return NULL;
	}
}
