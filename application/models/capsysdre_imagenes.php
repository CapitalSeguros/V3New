<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class capsysdre_imagenes extends CI_Model {
		 
	function __construct(){
		parent::__construct();
	}
	
	function ListaCategoriasImagenes(){		
		$this->db->from("imagenesMkt_categorias");
		$this->db->order_by("imagenesMkt_categorias.posicion", "asc");
		$query = $this->db->get();

		if($query->num_rows() > 0){
  			$return = $query;
		} else {
			$return = "";
		}
		
		return
			$return;
	} /*! ListaCategoriasImagenes */

	 	function EditarCategoriaImagenes($idCategoria){
		$sql = "
			Select * From
				`imagenesMkt_categorias`
			Where
				`idCategoria` = '".$idCategoria."'
			   ";
		$query = $this->db->query($sql);

		if($query->num_rows() > 0){
  			$return = $query->result();
		} else {
			$return = false;
		}

		return
			$return;
	} /*! EditarCategoriaImagenes */   

		function ListaImagenesMkt($idCategoria){		
		$this->db->from("imagenesMkt_imagenes");
		$this->db->where("imagenesMkt_imagenes.idCategoria", $idCategoria);
		$this->db->order_by("imagenesMkt_imagenes.nombre", "asc");
		$query = $this->db->get();

		if($query->num_rows() > 0){
  			$return = $query;
		} else {
			$return = "";
		}
		
		return
			$return;
	} /*! ListaImagenes */

		function EditarImagenesMkt($idImagen){
		$sql = "
			Select * From 
				`imagenesMkt_imagenes`
			Where
				 `idImagen` = '".$idImagen."'
			   ";
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0){
  			$return = $query->result();
		} else {
			$return = false;
		}

		return
			$return;
	} /*! EditarImagenes */

		function ListaImagenesCategoria($idCategoria,$idArea,$idSubcategoria){	
		$sql = "select * FROM `imagenesMkt_imagenes` WHERE `idCategoria`= ".$idCategoria." and (`idArea`=".$idArea." or `idArea`=0) and `idSubcategoria`=".$idSubcategoria;	
		$query = $this->db->query($sql);

		if($query->num_rows() > 0){
  			$return = $query;
		} else {
			$return = "";
		}
		
		return
			$return;
	} /*! ListaImagenesCategoria */

		function ListaAreasImagenes(){		
		$this->db->from("imagenesMkt_area");
		$this->db->order_by("imagenesMkt_area.posicion", "asc");
		$query = $this->db->get();

		if($query->num_rows() > 0){
  			$return = $query;
		} else {
			$return = "";
		}
		
		return
			$return;
	} /*! ListaAreasImagenes */


	 	function EditarAreaImagenes($idArea){
		$sql = "
			Select * From
				`imagenesMkt_area`
			Where
				`idArea` = '".$idArea."'
			   ";
		$query = $this->db->query($sql);

		if($query->num_rows() > 0){
  			$return = $query->result();
		} else {
			$return = false;
		}

		return
			$return;
	} /*! EditarAreaImagenes */


	 	function ListaSubcategoriasImagenes(){		
		$this->db->from("imagenesMkt_subcategorias");
		$this->db->order_by("imagenesMkt_subcategorias.posicion", "asc");
		$query = $this->db->get();

		if($query->num_rows() > 0){
  			$return = $query;
		} else {
			$return = "";
		}
		
		return
			$return;
	} /*! ListaSubcategoriasImagenes */ 

		function ListaSubcategoriasCategoriasImagenes($idCategoria){		
		$this->db->from("imagenesMkt_subcategorias");
		$this->db->where("imagenesMkt_subcategorias.idCategoria", $idCategoria);
		$this->db->order_by("imagenesMkt_subcategorias.posicion", "asc");
		$query = $this->db->get();

		if($query->num_rows() > 0){
  			$return = $query;
		} else {
			$return = "";
		}
		
		return
			$return;
	} /*! ListaSubcategoriasCategoriasImagenes */  

		function EditarSubcategoriaImagenes($idSubcategoria){
		$sql = "
			Select * From
				`imagenesMkt_subcategorias`
			Where
				`idSubcategoria` = '".$idSubcategoria."'
			   ";
		$query = $this->db->query($sql);

		if($query->num_rows() > 0){
  			$return = $query->result();
		} else {
			$return = false;
		}

		return
			$return;
	} /*! EditarSubcategoriaImagenes */   

	function nombreCompleto($idPersona){
		$this->db->from("persona");
		$this->db->where("persona.idPersona", $idPersona);
		$query = $this->db->get();
		
		if($query->num_rows() >= 0){
  			$return = $query->result();
		} else {
			$return = false;
		}
		return
			$return;
	}

	function emailCelular($idPersona){
		$sql = "
			Select * From
				`users`
			Where
				`idPersona` = ".$idPersona."
			   ";
		$query = $this->db->query($sql);

		if($query->num_rows() > 0){
  			$return = $query->result();
		} else {
			$return = false;
		}
		return
			$return;
	}

	
	function ListaImagenesFirma($idCategoria, $idSubcategoria){	
		$sql = "select * FROM `imagenesMkt_imagenes` WHERE `idCategoria`= ".$idCategoria." and `idSubcategoria`=".$idSubcategoria;	
		$query = $this->db->query($sql);

		if($query->num_rows() > 0){
  			$return = $query;
		} else {
			$return = "";
		}
		
		return
			$return;
	} /*! ListaImagenesFirma */
	
	function obtenerUserMiInfo($idPersona){
		$sql = "
			Select * From
				`user_miInfo`
			Where
				`idPersona` = ".$idPersona."
			   ";
		$query = $this->db->query($sql);

		if($query->num_rows() > 0){
  			$return = $query->result();
		} else {
			$return = false;
		}
		return
			$return;
	}

	function personaPuesto($idPersonaPuesto){
		$sql = "
			Select * From
				`personapuesto`
			Where
				`idPuesto` = ".$idPersonaPuesto."
			   ";
		$query = $this->db->query($sql);

		if($query->num_rows() > 0){
  			$return = $query->result();
		} else {
			$return = false;
		}
		return
			$return;
	}

	function generarQR($IDValida){
  $qr="https://www.asesoresonline.mx/tarjeta/index.php?id=".$IDValida;
  $PNG_TEMP_DIR = "assets/temp/";
  $PNG_WEB_DIR = "../assets/temp/";
  include "assets/phpcode/qrlib.php";
  if (!file_exists($PNG_TEMP_DIR))
      mkdir($PNG_TEMP_DIR);
  $filename = $PNG_TEMP_DIR.'test.png';
  $matrixPointSize = 7;
  $errorCorrectionLevel = 'L';
  $filename = $PNG_TEMP_DIR.'test'.md5($qr.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
  QRcode::png($qr, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
  return $PNG_WEB_DIR.basename($filename);
}
//Fin
//****************************************

function ListaImagenesGeneral($idCategoria){	
		$sql = "select * FROM `imagenesMkt_imagenes` WHERE `idCategoria`= ".$idCategoria;	
		$query = $this->db->query($sql);

		if($query->num_rows() > 0){
  			$return = $query;
		} else {
			$return = "";
		}
		
		return
			$return;
	} /*! ListaImagenesGeneral */



}