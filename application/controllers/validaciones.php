<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class validaciones extends CI_Controller
{

	function __construct(){
		parent::__construct();
	
			$params['id_sicas'] = $this->tank_auth->get_IDUserSICAS(); "get_IDUserSICAS";
			$params['user_sicas'] = $this->tank_auth->get_UserSICAS(); "get_UserSICAS";
			$params['pass_sicas'] = $this->tank_auth->get_PassSICAS(); "get_PassSICAS";
			$this->load->library('Ws_sicasdre',$params);
			$this->load->library('webservice_sicas_soap');
			$this->load->library('localfileuploader');

			$this->load->helper('ckeditor');
			$this->load->model('capsysdre_miinfo');
			//$this->load->model('catalogos_model');
	}

	function saveImage(){
		if (isset($_FILES['upload'])) {
			// $_FILES['upload']['extension'] = 'jpg';
			$email = $this->input->post('vendedor');
			$fileUploader = new localfileuploader();
    		$url = $fileUploader->moveFileB($_FILES['upload'],$email);

    		//var_dump($email);

    		if(!empty($url)){

    			$data = array('fotoUser'=>$email.'.jpg');

    			$data = array('fotoconcurso1'=>$email.'.jpg');
    			$data = array('fotoconcurso2'=>$email.'.jpg');
    			$data = array('fotoconcurso3'=>$email.'.jpg');
    			$data = array('fotoconcurso4'=>$email.'.jpg');
    			$data = array('fotoconcurso5'=>$email.'.jpg');
    			$data = array('fotoconcurso6'=>$email.'.jpg');



    			$this->capsysdre->miInfo_GuardarUsuario($email,$data);

    			echo 'true';
    		}else
    		{
    			echo 'false';
    		}    		
    		return;
		}

	 	echo 'false';
	}

	function obtieneInfo()
	{
           
			 // variables
			$msg = "";
			$configModulos = array();
			$path_foto = "./assets/img/miInfo/userPhotos/";

			$path_fotoc1 = "./assets/img/miInfo/userPhotosconcurso1/";
			$path_fotoc2 = "./assets/img/miInfo/userPhotosconcurso2/";
			$path_fotoc3 = "./assets/img/miInfo/userPhotosconcurso3/";
			$path_fotoc4 = "./assets/img/miInfo/userPhotosconcurso4/";
			$path_fotoc5 = "./assets/img/miInfo/userPhotosconcurso5/";
			$path_fotoc6 = "./assets/img/miInfo/userPhotosconcurso6/";


			$micorreo=$this->input->post('vendedor');
			if($micorreo!='')
 	        {

					$miInfo_Datos = $this->capsysdre->miInfo_DatosUsuario($micorreo);


					if(empty($miInfo_Datos)){
							$msg = "No se pudieron cargar los datos del usuario, el correo es vacio";
							$miInfo_Datos = array();
					}else{
				
						$IDCont			= $miInfo_Datos->IDCont;
			
						if( ((int)$IDCont) > 0 ){
					
								$infoContacto	= $this->capsysdre_miinfo->DetalleContacto($IDCont);
							
								if(!empty($infoContacto)){
						
									$emailUser								= strtoupper($infoContacto[0]->EMail1);
									//$emailUser								= 1;
									$dataMiInfo['nombre'] 					= "".$infoContacto[0]->Nombre."";
									$dataMiInfo['apellidop'] 				= "".$infoContacto[0]->ApellidoP."";
									$dataMiInfo['apellidom'] 				= "".$infoContacto[0]->ApellidoM."";
									$dataMiInfo['rfc'] 						= "".$infoContacto[0]->RFC;
									$dataMiInfo['telefono_celular'] 		= "".$infoContacto[0]->Telefono1."";
									$dataMiInfo['telefono_casa'] 			= "".$infoContacto[0]->Telefono2."";
									$dataMiInfo['telefono_trabajo'] 		= "".$infoContacto[0]->Telefono3."";
									$dataMiInfo['estado_civil'] 			= "".$infoContacto[0]->EdoCivil."";
									$dataMiInfo['fecha_nacimiento'] 		= "".$infoContacto[0]->FechaNac."";
									$dataMiInfo['imss'] 					= "".$infoContacto[0]->NSS."";
									$dataMiInfo['cuanto_te_gustaria_ganar'] = "".$infoContacto[0]->Percepcion."";
									$dataMiInfo['licencia_conducir'] 		= "".$infoContacto[0]->LicenciaNum."";
									$dataMiInfo['pasaporte'] 				= "".$infoContacto[0]->NumPasaporte."";
									$dataMiInfo['Expediente'] 				= "".$infoContacto[0]->Expediente."";
									//$dataMiInfo['Giro'] 					= "".$infoContacto[0]->Giro."";
									$dataMiInfo['Actividad'] 				= "".$infoContacto[0]->Actividad."";
									$dataMiInfo['Clasifica'] 				= "".$infoContacto[0]->Clasifica."";


			
						
									if(empty($emailUser)){
											$msg = "El email esta vacio, no se actualizaron los campos.";
									}else{
										$this->db->trans_begin();
										$this->db->where('user_miInfo.emailUser', $emailUser);
										$this->db->update('user_miInfo', $dataMiInfo);
							
										if ($this->db->trans_status() === FALSE)
										{
											$msg = "Ocurrio un error en la transaccion.";
											$this->db->trans_rollback();
										}
										else
										{
											$msg = "Sus registros fueron actualizados correctamente";
											$this->db->trans_commit();
										}
									}
								}else{
										$msg = "El detalle del contacto del ws sicas esta vacio, por lo tanto no se realiza ninguna actualizacion local.";
								}	
					
						}

						//$miInfo_Datos = $this->capsysdre->miInfo_DatosUsuario($micorreo);
						if(file_exists( $path_foto . $micorreo.".jpg")){			
					
						$miInfo_Datos->fotoUser = $path_foto . $micorreo.".jpg";
						} else {
							$miInfo_Datos->fotoUser = $path_foto . "noPhoto.png";
						}

						if(file_exists( $path_fotoc1 . $this->tank_auth->get_usermail().".jpg")){			
					
							$miInfo_Datos->fotoconcurso1 = $path_fotoc1 . $this->tank_auth->get_usermail().".jpg";
						} else {
							$miInfo_Datos->fotoconcurso1 = $path_fotoc1 . "noPhoto.png";
						}

						if(file_exists( $path_fotoc2 . $this->tank_auth->get_usermail().".jpg")){			
					
							$miInfo_Datos->fotoconcurso2 = $path_fotoc2 . $this->tank_auth->get_usermail().".jpg";
						} else {
							$miInfo_Datos->fotoconcurso2 = $path_fotoc2 . "noPhoto.png";
						}

						if(file_exists( $path_fotoc3 . $this->tank_auth->get_usermail().".jpg")){			
					
							$miInfo_Datos->fotoconcurso3 = $path_fotoc3 . $this->tank_auth->get_usermail().".jpg";
						} else {
							$miInfo_Datos->fotoconcurso3 = $path_fotoc3 . "noPhoto.png";
						}

						if(file_exists( $path_fotoc4 . $this->tank_auth->get_usermail().".jpg")){			
					
							$miInfo_Datos->fotoconcurso4 = $path_fotoc4 . $this->tank_auth->get_usermail().".jpg";
						} else {
							$miInfo_Datos->fotoconcurso4 = $path_fotoc4 . "noPhoto.png";
						}

						if(file_exists( $path_fotoc5 . $this->tank_auth->get_usermail().".jpg")){			
					
							$miInfo_Datos->fotoconcurso5 = $path_fotoc5 . $this->tank_auth->get_usermail().".jpg";
						} else {
							$miInfo_Datos->fotoconcurso5 = $path_fotoc5 . "noPhoto.png";
						}

						if(file_exists( $path_fotoc6 . $this->tank_auth->get_usermail().".jpg")){			
					
							$miInfo_Datos->fotoconcurso6 = $path_fotoc6 . $this->tank_auth->get_usermail().".jpg";
						} else {
							$miInfo_Datos->fotoconcurso6 = $path_fotoc6 . "noPhoto.png";
						}

						$configModulos = $this->capsysdre->ConfiguracionUsuarios($micorreo);	
					}
			


					$data['configModulos'] = $configModulos;	
					$data['miInfo_Datos'] = $miInfo_Datos;
					$data['msg'] = $msg;
					$data['ListaVendedores']		= $this->capsysdre->ListaVendedores($this->input->get('busquedaUsuario', TRUE));
             
            		
					$this->load->view('validaciones/editar', $data);
			}
    }


 function index(){
		
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			
			// variables
			$msg = "";
			$configModulos = array();
			$path_foto = "./assets/img/miInfo/userPhotos/";

			$path_fotoc1 = "./assets/img/miInfo/userPhotosconcurso1/";
			$path_fotoc2 = "./assets/img/miInfo/userPhotosconcurso2/";
			$path_fotoc3 = "./assets/img/miInfo/userPhotosconcurso3/";
			$path_fotoc4 = "./assets/img/miInfo/userPhotosconcurso4/";
			$path_fotoc5 = "./assets/img/miInfo/userPhotosconcurso5/";
			$path_fotoc6 = "./assets/img/miInfo/userPhotosconcurso6/";


			
			$miInfo_Datos = $this->capsysdre->miInfo_DatosUsuario($this->tank_auth->get_usermail());

			//var_dump($miInfo_Datos);
						
			if(empty($miInfo_Datos)){
				$msg = "No se pudieron cargar los datos del usuario, el correo es vacio";
				$miInfo_Datos = array();
			}else{
				
				$IDCont			= $miInfo_Datos->IDCont;
			
				if( ((int)$IDCont) > 0 ){
					
					$infoContacto	= $this->capsysdre_miinfo->DetalleContacto($IDCont);
							
					if(!empty($infoContacto)){
						
						$emailUser								= strtoupper($infoContacto[0]->EMail1);
						//$emailUser								= 1;
						$dataMiInfo['nombre'] 					= "".$infoContacto[0]->Nombre."";
						$dataMiInfo['apellidop'] 				= "".$infoContacto[0]->ApellidoP."";
						$dataMiInfo['apellidom'] 				= "".$infoContacto[0]->ApellidoM."";
						$dataMiInfo['rfc'] 						= "".$infoContacto[0]->RFC;
						$dataMiInfo['telefono_celular'] 		= "".$infoContacto[0]->Telefono1."";
						$dataMiInfo['telefono_casa'] 			= "".$infoContacto[0]->Telefono2."";
						$dataMiInfo['telefono_trabajo'] 		= "".$infoContacto[0]->Telefono3."";
						$dataMiInfo['estado_civil'] 			= "".$infoContacto[0]->EdoCivil."";
						$dataMiInfo['fecha_nacimiento'] 		= "".$infoContacto[0]->FechaNac."";
						$dataMiInfo['imss'] 					= "".$infoContacto[0]->NSS."";
						$dataMiInfo['cuanto_te_gustaria_ganar'] = "".$infoContacto[0]->Percepcion."";
						$dataMiInfo['licencia_conducir'] 		= "".$infoContacto[0]->LicenciaNum."";
						$dataMiInfo['pasaporte'] 				= "".$infoContacto[0]->NumPasaporte."";
						$dataMiInfo['Expediente'] 				= "".$infoContacto[0]->Expediente."";
						$dataMiInfo['Giro'] 					= "".$infoContacto[0]->Giro."";
						$dataMiInfo['Actividad'] 				= "".$infoContacto[0]->Actividad."";
						$dataMiInfo['Clasifica'] 				= "".$infoContacto[0]->Clasifica."";


						/*$dataMiInfo['cedula_cnsf'] 				= "".$infoContacto[0]->FechaNac."";
						$dataMiInfo['vigencia_cnsf'] 			= "".$infoContacto[0]->NSS."";
						$dataMiInfo['IDValida'] 				= "".$infoContacto[0]->Percepcion."";
						$dataMiInfo['certificacion'] 			= "".$infoContacto[0]->LicenciaNum."";
						$dataMiInfo['certificacionAutos'] 		= "".$infoContacto[0]->NumPasaporte."";
						$dataMiInfo['certificacionGmm'] 		= "".$infoContacto[0]->Expediente."";
						$dataMiInfo['certificacionVida'] 		= "".$infoContacto[0]->Giro."";
						$dataMiInfo['certificacionDanos'] 		= "".$infoContacto[0]->Actividad."";
						$dataMiInfo['certificacionFianzas'] 	= "".$infoContacto[0]->Clasifica."";*/
						
						if(empty($emailUser)){
							$msg = "El email esta vacio, no se actualizaron los campos.";
						}else{
							$this->db->trans_begin();
							$this->db->where('user_miInfo.emailUser', $emailUser);
							$this->db->update('user_miInfo', $dataMiInfo);
							
							if ($this->db->trans_status() === FALSE)
							{
								$msg = "Ocurrio un error en la transaccion.";
								$this->db->trans_rollback();
							}
							else
							{
								$msg = "Sus registros fueron actualizados correctamente";
								$this->db->trans_commit();
							}
						}
					}else{
						$msg = "El detalle del contacto del ws sicas esta vacio, por lo tanto no se realiza ninguna actualizacion local.";
					}	
					
				}
				//$miInfo_Datos = $this->capsysdre->miInfo_DatosUsuario($this->tank_auth->get_usermail());

				//var_dump($miInfo_Datos);

				if(file_exists( $path_foto . $this->tank_auth->get_usermail().".jpg")){			
					
					$miInfo_Datos->fotoUser = $path_foto . $this->tank_auth->get_usermail().".jpg";
					//echo "si hay photo usuario";
				} else {
					$miInfo_Datos->fotoUser = $path_foto . "noPhoto.png";
					
				}


				if(file_exists( $path_fotoc1 . $this->tank_auth->get_usermail().".jpg")){			
					
					$miInfo_Datos->fotoconcurso1 = $path_fotoc1 . $this->tank_auth->get_usermail().".jpg";
					echo "si hay photo usuario consurso1";
				} else {
					$miInfo_Datos->fotoconcurso1 = $path_fotoc1 . "noPhoto.png";
					
				}

				if(file_exists( $path_fotoc2 . $this->tank_auth->get_usermail().".jpg")){			
					
					$miInfo_Datos->fotoconcurso2 = $path_fotoc2 . $this->tank_auth->get_usermail().".jpg";
				} else {
					$miInfo_Datos->fotoconcurso2 = $path_fotoc2 . "noPhoto.png";
				}

				if(file_exists( $path_fotoc3 . $this->tank_auth->get_usermail().".jpg")){			
					
					$miInfo_Datos->fotoconcurso3 = $path_fotoc3 . $this->tank_auth->get_usermail().".jpg";
				} else {
					$miInfo_Datos->fotoconcurso3 = $path_fotoc3 . "noPhoto.png";
				}

				if(file_exists( $path_fotoc4 . $this->tank_auth->get_usermail().".jpg")){			
					
					$miInfo_Datos->fotoconcurso4 = $path_fotoc4 . $this->tank_auth->get_usermail().".jpg";
				} else {
					$miInfo_Datos->fotoconcurso4 = $path_fotoc4 . "noPhoto.png";
				}

				if(file_exists( $path_fotoc5 . $this->tank_auth->get_usermail().".jpg")){			
					
					$miInfo_Datos->fotoconcurso5 = $path_fotoc5 . $this->tank_auth->get_usermail().".jpg";
				} else {
					$miInfo_Datos->fotoconcurso5 = $path_fotoc5 . "noPhoto.png";
				}

				if(file_exists( $path_fotoc6 . $this->tank_auth->get_usermail().".jpg")){			
					
					$miInfo_Datos->fotoconcurso6 = $path_fotoc6 . $this->tank_auth->get_usermail().".jpg";
				} else {
					$miInfo_Datos->fotoconcurso6 = $path_fotoc6 . "noPhoto.png";
				}

				$configModulos = $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail());	
			}
			


			$data['configModulos'] = $configModulos;	
			$data['miInfo_Datos'] = $miInfo_Datos;
			$data['msg'] = $msg;
			$data['ListaVendedores']		= $this->capsysdre->ListaVendedores($this->input->get('busquedaUsuario', TRUE));

			//var_dump($miInfo_Datos);
			
  
			$this->load->view('validaciones/editar', $data);
		}
	}
	/*
	* @$url_tumb_resize = Url de la imagen previamente reducida a recortar,
	* @$x_axis = valor x donde se leera la imagen a recortar,
	* @$y_axis = valor y donde se leera la imagen a recortar
	* Retorna la ruta completa donde se encuentra el archivo recortado
	*/
	function Crop($url_tumb_resize,$x_axis,$y_axis){
		
			$config['image_library'] = 'gd2';
			$config['source_image']	= $url_tumb_resize;
			$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = false;
			$config['width']	= '100';
			$config['height']	= '120';
			$config['x_axis'] = $x_axis;
			$config['y_axis'] = $y_axis;

			$this->load->library('image_lib');
			$this->image_lib->clear();		
			$this->image_lib->initialize($config);			
			$properti_image = $this->image_lib;

			$xp	= $this->image_lib->explode_name($properti_image->dest_image);

				
			$filename = $xp['name'];
			$file_ext = $xp['ext'];
		
			$this->image_lib->crop();
			
			$fotoUser = "assets/img/miInfo/userPhotos/". $filename. $properti_image->thumb_marker. $file_ext;
			
			return $fotoUser;
	}
	/*
	* @$miInfo_Datos = Url de la imagen previamente reducida a recortar,
	* @$width = ancho de imagen a reducir,
	* @$height = alto de imagen a reducir
	* Retorna la ruta completa donde se encuentra el archivo reducido
	*/
	function Resize($miInfo_Datos,$width,$height){
		
		
			$config['image_library'] 	= 'gd2';
			$config['source_image']		= "assets/img/miInfo/userPhotos/". $miInfo_Datos->fotoUser;
			$config['create_thumb'] 	= TRUE;
			$config['maintain_ratio'] 	= true;
			$config['width']			= $width;
			$config['height']			= $height;

			$this->load->library('image_lib');
			$this->image_lib->clear();		
			$this->image_lib->initialize($config);			
			$properti_image = $this->image_lib;

			$xp	= $this->image_lib->explode_name($properti_image->dest_image);

				
			$filename = $xp['name'];
			$file_ext = $xp['ext'];
		
			$this->image_lib->resize();
			
			$fotoUser = "assets/img/miInfo/userPhotos/". $filename. $properti_image->thumb_marker. $file_ext;
			
			return $fotoUser;			
	}

	function editar(){		
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {

			$miinfo = $this->capsysdre->miInfo_DatosUsuario($this->tank_auth->get_usermail());
			if(file_exists("assets/img/miInfo/userPhotos/". $miinfo->fotoUser)){
				$miinfo->fotoUser = base_url()."assets/img/miInfo/userPhotos/".$miinfo->fotoUser;
			} else {
				$miinfo->fotoUser = base_url()."assets/images/default-lgAvatar.jpg";
			}


			$data = array(
				'configModulos'	=> $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail())
				,'miInfo_Datos' => $miinfo
			);

			//$data['ListaVendedores']		= $this->capsysdre->ListaVendedores($this->input->get('busquedaUsuario', TRUE));

			$this->load->view('validaciones/editar', $data);
		}
	}

/*=======================LOCM=============================================*/
	  function devuelveFecha($fecha){
       	 $fec= explode("/",$fecha);
         list($anio,$mes,$dia)=$fec;     
         $fechaCon1=$anio."-".$mes."-".$dia;
	     $fechaNac= date("y-m-d", strtotime($fechaCon1));

     return($fechaNac);
   }
 /*======================================================================*/
	
	function guardar(){		
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
		
		  $micorreo=$this->input->post('idCont');
 	     
          		$fechaNac=$this->devuelveFecha($this->input->post('fecha_nacimiento'));
          		$fechaVigLicencia=$this->devuelveFecha($this->input->post('vigencia_licencia'));
          		$fechaVigPasaporte=$this->devuelveFecha($this->input->post('vigencia_pasaporte'));
      
				$data = array(
				'rfc'		=>	$this->input->post('rfc',TRUE),
				'nombre'	=>	$this->input->post('nombre',TRUE),
				'apellidop'	=>	$this->input->post('apellidop', TRUE),
				'apellidom'	=>	$this->input->post('apellidom', TRUE),
				'calle'		=>	$this->input->post('calle', TRUE),
				'no_ext'	=>	$this->input->post('no_ext', TRUE),
				'cruzamiento'	=>	$this->input->post('cruzamiento', TRUE),
				'cp'		=>	$this->input->post('cp', TRUE),
				'colonia'	=>	$this->input->post('colonia', TRUE),
				'ciudad'	=>	$this->input->post('ciudad', TRUE),
				'telefono_casa'	=>	$this->input->post('telefono_casa', TRUE),
				'telefono_trabajo'	=>	$this->input->post('telefono_trabajo', TRUE),
				'telefono_celular'	=>	$this->input->post('telefono_celular', TRUE),
				'cia_celular'	=>	$this->input->post('cia_celular', TRUE),
				'estado_civil'	=>	$this->input->post('estado_civil', TRUE),
				'escolaridad'	=>	$this->input->post('escolaridad', TRUE),
				'lugar_nacimiento'	=>	$this->input->post('lugar_nacimiento', TRUE),
				//'fecha_nacimiento'	=>	date("Y-m-d",strtotime($this->input->post('fecha_nacimiento', TRUE))),
				'vehiculo_propio'	=>	$this->input->post('vehiculo_propio', TRUE),
				'modelo_vehiculo'	=>	$this->input->post('modelo_vehiculo', TRUE),
				'banco'	=>	$this->input->post('banco', TRUE),
				'cuenta_bancaria'	=>	$this->input->post('cuenta_bancaria', TRUE),
				'clabe'	=>	$this->input->post('clabe', TRUE),
				'tipo_cuenta'	=>	$this->input->post('tipo_cuenta', TRUE),
				'accidente_avisar'	=>	$this->input->post('accidente_avisar', TRUE),
				'accidente_telefono'	=>	$this->input->post('accidente_telefono', TRUE),
				'recomendado_por'	=>	$this->input->post('recomendado_por', TRUE),
				'referencias'	=>	$this->input->post('referencias', TRUE),
				'imss'	=>	$this->input->post('imss', TRUE),
				'tiene_hijos'	=>	$this->input->post('tiene_hijos', TRUE),
				'gasto_promedio_mensual'	=>	$this->input->post('gasto_promedio_mensual', TRUE),
				'cuanto_te_gustaria_ganar'	=>	$this->input->post('cuanto_te_gustaria_ganar', TRUE),
				'comida_favorita'	=>	$this->input->post('comida_favorita', TRUE),
				'color_favorito'	=>	$this->input->post('color_favorito', TRUE),
				'pasatiempo'	=>	$this->input->post('pasatiempo', TRUE),
				'club_social'	=>	$this->input->post('club_social', TRUE),
				//'cedula_cnsf'	=>	$this->input->post('cedula_cnsf', TRUE),
				//'vigencia_cnsf'	=>	date("Y-m-d",strtotime($this->input->post('vigencia_cnsf', TRUE))),
				'licencia_conducir'	=>	$this->input->post('licencia_conducir', TRUE),
				'vigencia_licencia'	=>	$fechaVigLicencia,
				'pasaporte'	=>	$this->input->post('pasaporte', TRUE),
                'fecha_nacimiento'	=>$fechaNac,
				'cedula_cnsf'	=>	$this->input->post('cedula_cnsf', TRUE),
				'vigencia_cnsf'	=>	$this->devuelveFecha($this->input->post('vigencia_cnsf')),

				'IDValida'	=>	$this->input->post('IDValida', TRUE),
				'certificacion'	=>	$this->input->post('certificacion', TRUE),
				'certificacionAutos'		=>	$this->input->post('certificacionAutos', TRUE),
				'certificacionGmm'	=>	$this->input->post('certificacionGmm', TRUE),
				'certificacionVida'	=>	$this->input->post('certificacionVida', TRUE),
				'certificacionDanos'		=>	$this->input->post('certificacionDanos', TRUE),
				'certificacionFianzas'	=>	$this->input->post('certificacionFianzas', TRUE),

				'polrescivil'	=>	$this->input->post('polrescivil', TRUE),
				'sumaaseg'		=>	$this->input->post('sumaaseg', TRUE),
				'vigenciapolrescivil'	=>	$this->devuelveFecha($this->input->post('vigenciapolrescivil')),

				'vigencia_pasaporte'	=>	$fechaVigPasaporte,
				'porcentajesa'	=>	$this->input->post('porcentajesa', TRUE),
				
				);

		

				$IDCont =   $this->input->post('idCont', TRUE);

				$Tel1 = explode('|', $this->input->post('telefono_celular', TRUE));
				$Tel2 = explode('|', $this->input->post('telefono_casa', TRUE));
				$Tel3 = explode('|', $this->input->post('telefono_trabajo', TRUE));

			//$oDate = new DateTime($this->input->post('fecha_nacimiento', TRUE));
   


				$datos = array(
                    "CatContactos" => array(
                                 "IDCont"       => $IDCont,
                                 "Nombre"       => $this->input->post('nombre',TRUE),
                                 "ApellidoP"    => $this->input->post('apellidop',TRUE),
                                 "ApellidoM"    => $this->input->post('apellidom',TRUE),
                                    // "Abreviacion"  => $Alias,
                                 "FechaNac"     => $fechaNac,
                                    // "FechaNac"     => $oDate->format('d/m/Y'),
                                 "NumID"       => $this->input->post('cedula_cnsf', TRUE),
                                 "Telefono1"    => count($Tel1) > 1? 'Celular|'.$Tel1[1]:'Celular|'.$Tel1[0],
                                 'Telefono2'	=>	count($Tel2) > 1? 'Casa|'.$Tel2[1]:'Casa|'.$Tel2[0],
								 'Telefono3'	=>	count($Tel3) > 1? 'Trabajo|'.$Tel3[1]:'Trabajo|'.$Tel3[0],
                                  "EdoCivil"=> $this->input->post('estado_civil', TRUE),
                                  "RFC"=> $this->input->post('rfc',TRUE),
                                    // "LugarNac" => $LugarNac,
                                  "LicenciaNum"=>$this->input->post('licencia_conducir', TRUE),
                                  "NSS"=> $this->input->post('imss', TRUE),
                                  "Profesion"=> $this->input->post('escolaridad', TRUE),
                                  "Percepcion"=> $this->input->post('cuanto_te_gustaria_ganar', TRUE),
                                    )
                );
			

				// var_dump($micorreo);

				//$this->capsysdre_miinfo->ActualizarContacto($datos);
                

				$this->capsysdre->miInfo_GuardarUsuario($micorreo,$data);
		    	redirect('validaciones');
		
		}
	}

}

/* End of file miInfo.php */
/* Location: ./application/controllers/miInfo.php */