<?php
/*
* plugin calendar de google
* Desarrollador: Henry oy
* Correo: henry.oy@ticc.com.mx
* Nombre: Library for drive
* version: 1.0.0
* Fecha: 18/02/2016 
*/


// if(!@include( __DIR__  . '/google/vendor/autoload.php'))
	// include( __DIR__  . '/google/vendor/autoload.php');
// if(!@include( __DIR__  . '/class/autoload.cenis.php'))
	// include( __DIR__  . '/class/autoload.cenis.php');
if(!defined('CREDENTIALS_PATH')) 
	define('CREDENTIALS_PATH', __DIR__ . '/configure/credentials/calendar-php.json');
if(!defined('PATH_CONFIGURE')) 
	define("PATH_CONFIGURE" , __DIR__  . "/configure/client_secret_341662279938-2r7nb3v39sv4boa3daf5ifa8jvohtgo9.apps.googleusercontent.com.json");

class DriveCenis{
	var $client;
	var $service;
	var $calendarId;
	var $email;
	var $displayName;
	var $AuthConfigFile;
	var $file;
	
	public function __construct(){
		
		$this->client = new Google_Client();
		$this->AuthConfigFile = PATH_CONFIGURE;
		$CI =& get_instance();
		$CI->load->library('session');
		
		if (strlen($this->AuthConfigFile) == 0){
				throw new Exception('La ruta del archivo no puede ser null o vacio.');
		}
		
		$this->client->setAuthConfigFile($this->AuthConfigFile);
		
		//$this->client->addScope("https://www.googleapis.com/auth/drive");
		$this->client->addScope(Google_Service_Drive::DRIVE);
		$this->client->addScope(Google_Service_Drive::DRIVE_FILE);
		$this->client->addScope(Google_Service_Drive::DRIVE_APPDATA);
		$this->client->addScope(Google_Service_Drive::DRIVE_APPS_READONLY);
		
		$this->client->addScope(Google_Service_Drive::DRIVE_METADATA);
		$this->client->addScope(Google_Service_Drive::DRIVE_METADATA_READONLY);
		$this->client->addScope(Google_Service_Drive::DRIVE_PHOTOS_READONLY);
		$this->client->addScope(Google_Service_Drive::DRIVE_READONLY);
		$this->client->addScope(Google_Service_Drive::DRIVE_SCRIPTS);

		$credentialsPath = $this->expandHomeDirectory(CREDENTIALS_PATH);
	  	if (file_exists($credentialsPath)) {
    		$accessToken = file_get_contents($credentialsPath);
	  	} else {
		    // Request authorization from the user.
	    	$authUrl = $this->client->createAuthUrl();
		    printf("Open the following link in your browser:\n%s\n", $authUrl);
		    print 'Enter verification code: ';
		    $authCode = trim(fgets(STDIN));

		    // Exchange authorization code for an access token.
		    $accessToken = $this->client->authenticate($authCode);

		    // Store the credentials to disk.
		    if(!file_exists(dirname($credentialsPath))) {
		      mkdir(dirname($credentialsPath), 0700, true);
		    }
		    file_put_contents($credentialsPath, $accessToken);
		    printf("Credentials saved to %s\n", $credentialsPath);
	  	}
	  	$this->client->setAccessToken($accessToken);

		  // Refresh the token if it's expired.
	  	if ($this->client->isAccessTokenExpired()) {
		    $this->client->refreshToken($this->client->getRefreshToken());
		    file_put_contents($credentialsPath, $this->client->getAccessToken());
	  	}
	
	    
		$this->service = new Google_Service_Drive($this->client);

		
	}

	function expandHomeDirectory($path) {
	  $homeDirectory = getenv('HOME');
	  if (empty($homeDirectory)) {
	    $homeDirectory = getenv("HOMEDRIVE") . getenv("HOMEPATH");
	  }
	  return str_replace('~', realpath($homeDirectory), $path);
	}
	public function UploadFile($data){
		
		//$result = array("name" => "tetst");
		$chunkSizeBytes = 1 * 1024 * 1024;
		
		try{			
			
			//if ($this->client->getAccessToken()) {
				
				if(is_array($data)){
					
					$file_local 	= $data['pathfile'];
					$mimeType_local = $data['mimeType'];
					$title_local	= $data['title'];
					
					if(isset($data['uploadType']))
						$uploadType_local = $data['uploadType'];
					else
						$uploadType_local = 'media';
					
					$this->file = new Google_Service_Drive_DriveFile();
				    $this->file->setTitle($title_local);
					$this->file->setDescription($title_local);
					$this->file->setMimeType($mimeType_local);
					//$this->client->setDefer(true);
					$data_file = file_get_contents($file_local);
					$result = $this->service->files->insert(
						  $this->file,
						  array(
							'data' => file_get_contents($file_local),
							'mimeType' => $mimeType_local,
							'uploadType' => $uploadType_local,
							//'visibility' => 'DEFAULT'
						  )
					);
					
					// $media = new Google_Http_MediaFileUpload(
					  // $this->client,
					  // $result,
					  // $mimeType_local,
					  // null,
					  // true,
					  // $chunkSizeBytes
					// );
					
					// $media->setFileSize(filesize($file_local));
					
					// Upload the various chunks. $status will be false until the process is
					// complete.
					// $status = false;
					// $handle = fopen($file_local, "rb");
					// while (!$status && !feof($handle)) {
					  // $chunk = fread($handle, $chunkSizeBytes);
					  // $status = $media->nextChunk($chunk);
					 // }

					// The final value of $status will be the data from the API for the object
					// that has been uploaded.
					// $result_exito = false;
					// if($status != false) {
					  // $result_exito = $status;
					// }

					// fclose($handle);
					// Reset to the client to execute requests immediately in the future.
					// $this->client->setDefer(false);
					
					//$this->insertPermission($result->id);
				}
			//}
			
		}catch(Exception $e){
			echo "Ocurrio un error: " . $e->getMessage();
		}
		
		return $result;
	}
	
	public function UploadFiless($data){
		
		//$result = array("name" => "tetst");
		
		try{			
			
			// if ($this->client->getAccessToken()) {
				
				if(is_array($data)){
					
					$file_local 	= $data['pathfile'];
					$mimeType_local = $data['mimeType'];
					$title_local	= $data['title'];
					
					if(isset($data['uploadType']))
						$uploadType_local = $data['uploadType'];
					else
						$uploadType_local = 'media';
					
					$this->file = new Google_Service_Drive_DriveFile();
				    $this->file->setTitle($title_local);
					
					$result = $this->service->files->insert(
						  $this->file,
						  array(
							'data' => @file_get_contents($file_local),
							'mimeType' => $mimeType_local,
							'uploadType' => $uploadType_local
						  )
					);
					
					$this->insertPermission($result->id);
				}
			// }
			
		}catch(Exception $e){
			echo "Ocurrio un error: " . $e->getMessage();
		}
		
		return $result;
	}
	public function DeleteFile($fileId){
		
		try{			
			$infoDelete = $this->service->files->delete($fileId);			
		}catch(Exception $e){
			echo "Ocurrio un error: " . $e->getMessage();
		}
		
		return $infoDelete;
	}
	/**
	 * Insert a new permission.
	 *
	 * @param Google_Service_Drive $service Drive API service instance.
	 * @param String $fileId ID of the file to insert permission for.
	 * @param String $value User or group e-mail address, domain name or NULL for
						   "default" type.
	 * @param String $type The value "user", "group", "domain" or "default".
	 * @param String $role The value "owner", "writer" or "reader".
	 * @return Google_Servie_Drive_Permission The inserted permission. NULL is
	 *     returned if an API error occurred.
	 */
	public function insertPermission($fileId) {
	  
	  $newPermission = new Google_Service_Drive_Permission();
	  
	  //$newPermission->setValue($value);
	  $newPermission->setType("anyone");
	  $newPermission->setRole("reader");
	  
	  try {
		return $this->service->permissions->insert($fileId, $newPermission);
		
	  } catch (Exception $e) {
		  
		print "An error occurred: " . $e->getMessage();
		
	  }
	  
	  return NULL;
	}
	
	public function insertPermissionEmail($fileId,$email) {
	  
	  $newPermission = new Google_Service_Drive_Permission();
	  
	  $newPermission->setValue($email);
	  $newPermission->setType("anyone");
	  $newPermission->setRole("reader");
	  
	  try {
		return $this->service->permissions->insert($fileId, $newPermission);
		
	  } catch (Exception $e) {
		  
		print "An error occurred: " . $e->getMessage();
		
	  }
	  
	  return NULL;
	}
	public function updateUploadFile($fileId,$data){
		try{
			
			if(is_array($data)){

				$file_local 		= $data['pathfile'];
				$mimeType_local 	= $data['mimeType'];
				$title_local		= $data['title'];
				$descripcion_local	= $data['description'];
				$newRevision		= $data['newRevision'];
				
				//$service, 
				//$fileId, 
				//$newTitle, 
				//$newDescription, 
				//$newMimeType, 
				//$newFileName, 
				//$newRevision	
				
				$file = $this->service->files->get($fileId);
	
				$file->setTitle($title_local);
				$file->setDescription($descripcion_local);
				$file->setMimeType($mimeType_local);
				//$file->setModifiedDate()
				$data = file_get_contents($file_local);

				$additionalParams = array(
					'newRevision' => $newRevision,
					'data' => $data,
					'mimeType' => $mimeType_local
				);

				$updatedFile = $this->service->files->update($fileId, $file, $additionalParams);				
			}

		}catch(Exception $e){
			echo "Ocurrio un error: " . $e->getMessage();
		}
		
		return $updatedFile;
	}
}
?>