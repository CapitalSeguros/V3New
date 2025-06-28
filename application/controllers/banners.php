<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class banners extends CI_Controller{

	function __construct(){
		parent::__construct();     
	}

	function index(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['configModulos']	= $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail());
				
			$this->load->view('banners/inicio', $data);
		}
	}/*! index */

	function inicio(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['configModulos']	= $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail());
				
			$this->load->view('banners/inicio', $data);
		}
	}

	function fijos(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['configModulos']	= $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail());
				
			$this->load->view('banners/fijos', $data);
		}
	}

	function slideInicio(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['configModulos']	= $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail());
				
			$this->load->view('banners/slideInicio', $data);
		}
	}
	
	function EdicionBanner(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			//echo "<pre>";
				//print_r($_REQUEST);
			//echo "</pre>";

			$id				= $this->input->post("id", TRUE);
			$img			= explode(".",$this->input->post("img", TRUE));
			$directorio		= $this->input->post("directorio", TRUE);
			$linkRedirect	= $this->input->post("linkRedirect", TRUE);
			
			if ($_FILES['imgBanner']["error"] == 0){
				$imgName 		= $img[0].".".$img[1];
				$imgNameNew		= "nuestrosagentes_".date('is').".".$img[1];
				$destination	= RUTA_ASSETS."".$directorio."/".$imgName;
				$destinationNew	= RUTA_ASSETS."".$directorio."/".$imgNameNew;
				if(file_exists($destination)){ unlink($destination); }
				move_uploaded_file($_FILES['imgBanner']['tmp_name'], $destinationNew);
				
				$sqlUpdate = "
					Update
						`banners`
					Set
						`img` = '".$imgNameNew."'
					Where
						`id` = '".$id."' 
							 ";
				$this->db->query($sqlUpdate);
				
			}

			redirect('/banners/'.$linkRedirect.'/');

		}
	}/*! EdicionBanner */
	
	function editarSlide(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$banner_id = $this->uri->segment(3, 0);
			
			if ($this->uri->segment(3) === FALSE){
				//$banner_id = 0;
				redirect('/banners/slideInicio/');
			} else {
				$data['banner_id'] = $banner_id = $this->uri->segment(3);
				$sqlBanner = "
					Select * From 
						`slide_inicio`
					Where
						`id` = ".$banner_id."
							 ";
				$queryBanner = $this->db->query($sqlBanner);
				$data['banner_info'] = $queryBanner->result();
				
				$this->load->view('banners/editarSlide', $data);
			}
		}
	}/*! Editar */

	
	function GuardarBannerSlide(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$idBanner		= $this->input->post('idBanner', TRUE);
			$nombreBanner	= $this->input->post('nombreBanner', TRUE);
			
			if(!isset($idBanner)){
				redirect('/banners/slideInicio/');
			} else {
				
				if ($_FILES['imgBanner']["error"] == 0){
					$imgName = $idBanner."_".date('is').".png";
					$destination	= RUTA_ASSETS.'assets/img/inicio/slideShow/'.$imgName;
				
					if(file_exists($destination)){ unlink($destination); }
					move_uploaded_file($_FILES['imgBanner']['tmp_name'], $destination);
					
					$sqlUpdate = "
						Update
							`slide_inicio`
						Set
							`nombre` = '".$nombreBanner."',
							`img`	 = '".$imgName."'
						Where
							`id` = ".$idBanner."
								 ";
					$this->db->query($sqlUpdate);
				} else {
					$sqlUpdate = "
						Update
							`slide_inicio`
						Set
							`nombre` = '".$nombreBanner."'
						Where
							`id` = ".$idBanner."
								 ";
					$this->db->query($sqlUpdate);
				}
				redirect('/banners/slideInicio/');
			}
		}
	}/*! GuardarBannerSlide */

	function NewBannerSlide(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$sqlNewBanner = "
				Insert Into
					`slide_inicio`
					(`nombre`)
					Values
					('Banner_".date('Y-m-d_H:i:s')."');
							";
			$this->db->query($sqlNewBanner);
			$idBanner = $this->db->insert_id();
			
			redirect('/banners/editarSlide/'.$idBanner);

		}
	}/*! NewBannerSlide */

	
	function eliminarSlide(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$banner_id = $this->uri->segment(3, 0);
			
			if ($this->uri->segment(3) === FALSE){
				//$banner_id = 0;
				redirect('/banners/slideInicio/');
			} else {
				$sqlBanner = "
					Select * From 
						`slide_inicio`
					Where
						`id` = ".$banner_id."
							 ";
				$queryBanner	= $this->db->query($sqlBanner);
				$banner			= $queryBanner->result();
				$imgName		= $banner[0]->img;
				$destination	= RUTA_ASSETS.'assets/img/inicio/slideShow/'.$imgName;
				
				if($imgName != "NoImage.png"){
					if(file_exists($destination)){ unlink($destination); }
				}
				
				$sqlDeleteBanner = "
					Delete From 
						`slide_inicio`
					Where
						`id` = '".$banner_id."'
								   ";
				$this->db->query($sqlDeleteBanner);
				redirect('/banners/slideInicio/');
			}
		}
	}/*! eliminarSlide */
	
	
	function microSitios(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['configModulos']	= $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail());
				
			$this->load->view('banners/microSitios', $data);
		}
	}/*! microSitios */
	
	function NewBannerMicrositio(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$sqlNewBanner = "
				Insert Into
					`banners_micrositios`
					(`nombre`)
					Values
					('Banner_".date('Y-m-d_H:i:s')."');
							";
			$this->db->query($sqlNewBanner);
			$idBanner = $this->db->insert_id();
			
			redirect('/banners/editarMicrositios/'.$idBanner);

		}
	}/*! NewBannerMicrositio */

	function editarMicrositios(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$banner_id = $this->uri->segment(3, 0);
			
			if ($this->uri->segment(3) === FALSE){
				//$banner_id = 0;
				redirect('/banners/microSitios/');
			} else {
				$data['banner_id'] = $banner_id = $this->uri->segment(3);
				$sqlBanner = "
					Select * From 
						`banners_micrositios`
					Where
						`id` = ".$banner_id."
							 ";
				$queryBanner = $this->db->query($sqlBanner);
				$data['banner_info'] = $queryBanner->result();
				
				$this->load->view('banners/editarMicrositios', $data);
			}
		}
	}/*! editarMicrositios */
	
	function GuardarBannerMicrositios(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$idBanner		= $this->input->post('idBanner', TRUE);
			$nombreBanner	= $this->input->post('nombreBanner', TRUE);
			$ramoBanner	= $this->input->post('ramoBanner', TRUE);
			
			if(!isset($idBanner)){
				redirect('/banners/microSitios/');
			} else {
				
				if ($_FILES['imgBanner']["error"] == 0){
					$imgName = $idBanner."_".date('is').".png";
					$destination	= RUTA_ASSETS.'assets/img/banners/micrositios/'.$imgName;
				
					if(file_exists($destination)){ unlink($destination); }
					move_uploaded_file($_FILES['imgBanner']['tmp_name'], $destination);
					
					$sqlUpdate = "
						Update
							`banners_micrositios`
						Set
							`nombre` = '".$nombreBanner."',
							`ramo` = '".$ramoBanner."',
							`img`	 = '".$imgName."'
						Where
							`id` = ".$idBanner."
								 ";
					$this->db->query($sqlUpdate);
				} else {
					$sqlUpdate = "
						Update
							`banners_micrositios`
						Set
							`nombre` = '".$nombreBanner."',
							`ramo` = '".$ramoBanner."'
						Where
							`id` = ".$idBanner."
								 ";
					$this->db->query($sqlUpdate);
				}
				redirect('/banners/microSitios/');
			}
		}
	}/*! GuardarBannerMicrositios */
	
	function eliminarMicrositios(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$banner_id = $this->uri->segment(3, 0);
			
			if ($this->uri->segment(3) === FALSE){
				//$banner_id = 0;
				redirect('/banners/micrositios/');
			} else {
				$sqlBanner = "
					Select * From 
						`banners_micrositios`
					Where
						`id` = ".$banner_id."
							 ";
				$queryBanner	= $this->db->query($sqlBanner);
				$banner			= $queryBanner->result();
				$imgName		= $banner[0]->img;
				$destination	= RUTA_ASSETS.'assets/img/banners/micrositios/'.$imgName;
				
				if($imgName != "NoImage.png"){
					if(file_exists($destination)){ unlink($destination); }
				}
				
				$sqlDeleteBanner = "
					Delete From 
						`banners_micrositios`
					Where
						`id` = '".$banner_id."'
								   ";
				$this->db->query($sqlDeleteBanner);
				redirect('/banners/micrositios/');
			}
		}
	}/*! eliminarMicrositios */

}

/* End of file inicio.php */
/* Location: ./application/controllers/inicio.php */