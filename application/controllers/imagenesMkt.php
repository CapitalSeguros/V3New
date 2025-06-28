<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class imagenesMkt extends CI_Controller{

	function __construct(){
		parent::__construct();   
			$this->load->model('capsysdre_imagenes'); 

	}

	function index(){		
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['ListaCategoriasImagenes']	= $this->capsysdre_imagenes->ListaCategoriasImagenes();
			$data['configModulos']			= $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail());

				$this->load->view('imagenesMkt/principal', $data);
		}
	}/*! index */

	function categoriasAgregar(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
				$data['configModulos']	= $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail());
				
					$this->load->view('imagenesMkt/categoriasAgregar', $data);
		}
		
	}/*! categoriasAgregar */
function AgregarCategoria(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$nombre			= urlencode($this->input->post("nombre",TRUE));
			$posicion		= $this->input->post("posicion",TRUE);

			$sqlEdicionCategoria = "
				Insert Into
					`imagenesMkt_categorias`
				(
					`nombre`,
					`posicion`,
					`img_link`
				)
				Values
				(
					'".$nombre."',
					'".$posicion."',
					'noPhoto.png'
				)
								   ";
			$this->db->query($sqlEdicionCategoria);
			$idCategoria = $this->db->insert_id();

			if ($_FILES['imgCategoria']["error"] == 0){
				$nameImgCategoria = "CategoriaImg_";
				$nameImgCategoria.= $idCategoria;
				$nameImgCategoria.= ".".strrev(strstr(strrev($_FILES['imgCategoria']['name']), '.', true));
				$destination	= RUTA_ASSETS.'img/imagenesMkt/categorias//'.$nameImgCategoria;
				//$destination	= 'C:\wamp64\www\Capsys\www\V3\assets\img\imagenesMkt\categorias\\'.$nameImgCategoria;
				
				
				if(file_exists($destination)){ unlink($destination); }
				

/*========================================================================*/

$nombre_img = $_FILES['imgCategoria']['name'];
$tipo = $_FILES['imgCategoria']['type'];
$tamano = $_FILES['imgCategoria']['size'];
		
 
//Si existe imagen y tiene un tamaño correcto
if (($nombre_img == !NULL) && ($_FILES['imgCategoria']['size'] <= 20000000)) 
{
   //indicamos los formatos que permitimos subir a nuestro servidor
   if (($_FILES["imgCategoria"]["type"] == "image/gif")
   || ($_FILES["imgCategoria"]["type"] == "image/jpeg")
   || ($_FILES["imgCategoria"]["type"] == "image/jpg")
   || ($_FILES["imgCategoria"]["type"] == "image/png"))
   {
      // Ruta donde se guardarán las imágenes que subamos
      // Muevo la imagen desde el directorio temporal a nuestra ruta indicada anteriormente
                   
      move_uploaded_file($_FILES['imgCategoria']['tmp_name'],$destination);
	  
    } 
    else 
    {
       //si no cumple con el formato
       echo "No se puede subir una imagen con ese formato ";
    }
} 
else 
{
   //si existe la variable pero se pasa del tamaño permitido
   if($nombre_img == !NULL) echo "La imagen es demasiado grande "; 
}



/*======================================================================*/
				
				$sqlEdicionCategoria_img = "
					Update
						`imagenesMkt_categorias`
					Set
						`img_link` = '".$nameImgCategoria."'
					Where
						`idCategoria` = '".$idCategoria."'
									   ";
				$this->db->query($sqlEdicionCategoria_img);
			}

			redirect('/imagenesMkt/categoriasModificar/');
		}
	}/*! AgregarCategoria */
	
		function categoriasModificar(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['ListaCategoriasImagenes']	= $this->capsysdre_imagenes->ListaCategoriasImagenes();
			$data['configModulos']			= $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail());
			
				$this->load->view('imagenesMkt/categoriasModificar', $data);
		}
	}/*! categoriasModificar */
	function categoriasEditar(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$idCategoria = $this->input->get("idCategoria",TRUE);
			$data['ListaCategoriasImagenes']	= $ListaCategoriasImagenes = $this->capsysdre_imagenes->EditarCategoriaImagenes($idCategoria);
			
			if($idCategoria == "" || $ListaCategoriasImagenes == false ){
				redirect('/imagenesMkt/categoriasModificar');
			} else {
				
				$data['configModulos']	= $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail());

					$this->load->view('imagenesMkt/categoriasEditar', $data);
			}
		}
	}/*! categoriasEditar */
	
	function EdicionCategoria(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {			
			$idCategoria	= $this->input->post("idCategoria",TRUE);
			$nombre			= urlencode($this->input->post("nombre",TRUE));
			$posicion		= $this->input->post("posicion",TRUE);

			if ($_FILES['imgCategoria']["error"] == 0){
				$nameImgCategoria = "CategoriaImg_";
				$nameImgCategoria.= $idCategoria;
				$nameImgCategoria.= ".".strrev(strstr(strrev($_FILES['imgCategoria']['name']), '.', true));
				$destination	= RUTA_ASSETS.'img/imagenesMkt/categorias//'.$nameImgCategoria;
				//$destination	= 'C:\wamp64\www\Capsys\www\V3\assets\img\imagenesMkt\categorias\\'.$nameImgCategoria;
				
				if(file_exists($destination)){ unlink($destination); }

	
/*========================================================================*/

$nombre_img = $_FILES['imgCategoria']['name'];
$tipo = $_FILES['imgCategoria']['type'];
$tamano = $_FILES['imgCategoria']['size'];
		
 
//Si existe imagen y tiene un tamaño correcto
if (($nombre_img == !NULL) && ($_FILES['imgCategoria']['size'] <= 20000000)) 
{
   //indicamos los formatos que permitimos subir a nuestro servidor
   if (($_FILES["imgCategoria"]["type"] == "image/gif")
   || ($_FILES["imgCategoria"]["type"] == "image/jpeg")
   || ($_FILES["imgCategoria"]["type"] == "image/jpg")
   || ($_FILES["imgCategoria"]["type"] == "image/png"))
   {
      // Ruta donde se guardarán las imágenes que subamos
      // Muevo la imagen desde el directorio temporal a nuestra ruta indicada anteriormente
                   
      move_uploaded_file($_FILES['imgCategoria']['tmp_name'],$destination);
	  
    } 
    else 
    {
       //si no cumple con el formato
       echo "No se puede subir una imagen con ese formato ";
    }
} 
else 
{
   //si existe la variable pero se pasa del tamaño permitido
   if($nombre_img == !NULL) echo "La imagen es demasiado grande "; 
}



/*======================================================================*/			
				$sqlEdicionCategoria_img = "
					Update
						`imagenesMkt_categorias`
					Set
						`img_link` = '".$nameImgCategoria."'
					Where
						`idCategoria` = '".$idCategoria."'
									   ";
				$this->db->query($sqlEdicionCategoria_img);
			}
			
			$sqlEdicionCategoria = "
				Update
					`imagenesMkt_categorias`
				Set
					`nombre` = '".$nombre."',
					`posicion` = '".$posicion."'
				Where
					`idCategoria` = '".$idCategoria."'
								   ";
			$this->db->query($sqlEdicionCategoria);
			
			redirect('/imagenesMkt/categoriasModificar/');
		}
	}/*! EdicionCategoria */

	function BorrarCategoria(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$idCategoria	= $this->input->get("idCategoria",TRUE);
			$data['EditarCategoriaImagenes']	= $EditarCategoriaImagenes = $this->capsysdre_imagenes->EditarCategoriaImagenes($idCategoria);
			
			if($idCategoria == "" || $EditarCategoriaImagenes == false ){
				redirect('/imagenesMkt/categoriasModificar');
			} else {
				$destination	= RUTA_ASSETS.'img/imagenesMkt/categorias//'.$EditarCategoriaImagenes[0]->img_link;
				//$destination	= 'C:\wamp64\www\Capsys\www\V3\assets\img\imagenesMkt\categorias\\'.$EditarCategoriaImagenes[0]->img_link;
				
				if(file_exists($destination)){ unlink($destination); }
				
				$sqlDelete = "
					Delete From
						`imagenesMkt_categorias`
					Where
						`idCategoria` = '".$idCategoria."'
							 ";
				$this->db->query($sqlDelete);
				redirect('/imagenesMkt/categoriasModificar');	
			}
		}
	}/*! BorrarCategoria */


	function imagenesAgregar(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
				$data['configModulos']	= $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail());
				
					$this->load->view('imagenesMkt/imagenesAgregar', $data);
		}
		
	}/*! categoriasAgregar */

		function AgregarImagenes(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {

			$ddd=base_url();

			$idCategoria	= $this->input->post("idCategoria",TRUE);
			$idArea	= $this->input->post("idArea",TRUE);
			$idSubcategoria	= $this->input->post("idSubcategoria",TRUE);
			$nombre			= urlencode($this->input->post("nombre",TRUE));
			$logo 		= $this->input->post("logo",TRUE);
			$logoside 		= $this->input->post("logoside",TRUE);
			//$imagen= $this->input->post("imgArticulo",TRUE);
			//$_FILES['imagen']=$this->input->post("imgArticulo",TRUE);
			$imagen = base64_encode(file_get_contents($_FILES['imagenMkt']['tmp_name']));

			$sqlInsertImagenes = "
				Insert Into
					`imagenesMkt_imagenes`
				(
					`idCategoria`,
					`idArea`,
					`idSubcategoria`,
					`nombre`,
					`img_link`,
					`logo`,
					`logoside`
				)
				Values
				(
					'".$idCategoria."',
					'".$idArea."',
					'".$idSubcategoria."',
					'".$nombre."',
					'noPhoto.png',
					'".$logo."',
					'".$logoside."'
				)


								   ";

					/*$fp = fopen('resultadoJason.txt', 'w');
                  fwrite($fp, print_r($sqlInsertArticulo, TRUE));
                   fclose($fp);*/

			$this->db->query($sqlInsertImagenes);
			$idImagen = $this->db->insert_id();

			if ($_FILES['imagenMkt']["error"] == 0){
				$nameImagenMkt = "ImagenMkt_";
				$nameImagenMkt.= $idImagen;
				$nameImagenMkt.= ".".strrev(strstr(strrev($_FILES['imagenMkt']['name']), '.', true));

				$destination	= RUTA_ASSETS.'img/imagenesMkt/imagenes//'.$nameImagenMkt;
				//$destination	= 'C:\wamp64\www\Capsys\www\V3\assets\img\imagenesMkt\imagenes\\'.$nameImagenMkt;
				

/*===================PARA GUARDARLO LOCALMENTE===============================================*/
      //$destination = $_SERVER['DOCUMENT_ROOT'].'/Capsys/www/V3/assets/img/tienda/articulos/'.$nameImagenMkt;

            

				//--> $destination	= 'C:\wamp\www\web_capsys\www\V3\assets\img\tienda\articulos\\'.$nameImagenMkt;
				
				if(file_exists($destination)){ unlink($destination); }

				
				 // $ruta='C:/locm/imagenes/'.$Iname;
				//move_uploaded_file($_FILES['imgArticulo']['tmp_name'], $destination);
				 

/*========================================================================*/

$nombre_img = $_FILES['imagenMkt']['name'];
$tipo = $_FILES['imagenMkt']['type'];
$tamano = $_FILES['imagenMkt']['size'];
		
 
//Si existe imagen y tiene un tamaño correcto
if (($nombre_img == !NULL) && ($_FILES['imagenMkt']['size'] <= 20000000)) 
{
   //indicamos los formatos que permitimos subir a nuestro servidor
   if (($_FILES["imagenMkt"]["type"] == "image/gif")
   || ($_FILES["imagenMkt"]["type"] == "image/jpeg")
   || ($_FILES["imagenMkt"]["type"] == "image/jpg")
   || ($_FILES["imagenMkt"]["type"] == "image/png"))
   {
      // Ruta donde se guardarán las imágenes que subamos
      // Muevo la imagen desde el directorio temporal a nuestra ruta indicada anteriormente
                   
      move_uploaded_file($_FILES['imagenMkt']['tmp_name'],$destination);
	  
    } 
    else 
    {
       //si no cumple con el formato
       echo "No se puede subir una imagen con ese formato ";
    }
} 
else 
{
   //si existe la variable pero se pasa del tamaño permitido
   if($nombre_img == !NULL) echo "La imagen es demasiado grande "; 
}



/*======================================================================*/

				
				$sqlEdicionImagenes = "
					Update
						`imagenesMkt_imagenes`
					Set
						`img_link` = '".$nameImagenMkt."'
					Where
						`idImagen` = '".$idImagen."'
									   ";
				$this->db->query($sqlEdicionImagenes);
			}

			redirect('/imagenesMkt/imagenesModificar/');
		}
	}/*! AgregarImagenes */

	function imagenesModificar(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['ListaCategoriasImagenes']	= $this->capsysdre_imagenes->ListaCategoriasImagenes();
			$data['configModulos']			= $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail());
			
				$this->load->view('imagenesMkt/imagenesModificar', $data);
		}
	}/*! imagenesModificar */


		function imagenesEditar(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$idImagen = $this->input->get("idImagen",TRUE);
			$data['EditarImagenesMkt']	= $EditarImagenesMkt = $this->capsysdre_imagenes->EditarImagenesMkt($idImagen);
			
			if($idImagen == "" || $EditarImagenesMkt == false ){
				redirect('/imagenesMkt/imagenesModificar');
			} else {

				$data['configModulos']	= $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail());

                  

              // $datos = $data['EditarArticulosTienda']->fetch(PDO::FETCH_ASSOC)["imagen"]; 
			

             

					$this->load->view('imagenesMkt/imagenesEditar', $data);
			}
		}
	}/*! ImagenesEditar */

		function EdicionImagen(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {			
			$idImagen		= $this->input->post("idImagen",TRUE);
			$idCategoria	= $this->input->post("idCategoria",TRUE);
			$idArea	= $this->input->post("idArea",TRUE);
			$idSubcategoria	= $this->input->post("idSubcategoria",TRUE);
			$nombre			= urlencode($this->input->post("nombre",TRUE));
			$logo 		= $this->input->post("logo",TRUE);
			$logoside 		= $this->input->post("logoside",TRUE);
			

			
			if ($_FILES['imagenMkt']["error"] == 0){
				$nameImagen = "ImagenMkt_";
				$nameImagen.= $idImagen;
				$nameImagen.= ".".strrev(strstr(strrev($_FILES['imagenMkt']['name']), '.', true));
				$destination	= RUTA_ASSETS.'img/imagenesMkt/imagenes//'.$nameImagen;
				//$destination	= 'C:\wamp64\www\Capsys\www\V3\assets\img\imagenesMkt\imagenes\\'.$nameImagen;

				if(file_exists($destination)){ unlink($destination); }
				
/*========================================================================*/

$nombre_img = $_FILES['imagenMkt']['name'];
$tipo = $_FILES['imagenMkt']['type'];
$tamano = $_FILES['imagenMkt']['size'];
		
 
//Si existe imagen y tiene un tamaño correcto
if (($nombre_img == !NULL) && ($_FILES['imagenMkt']['size'] <= 20000000)) 
{
   //indicamos los formatos que permitimos subir a nuestro servidor
   if (($_FILES["imagenMkt"]["type"] == "image/gif")
   || ($_FILES["imagenMkt"]["type"] == "image/jpeg")
   || ($_FILES["imagenMkt"]["type"] == "image/jpg")
   || ($_FILES["imagenMkt"]["type"] == "image/png"))
   {
      // Ruta donde se guardarán las imágenes que subamos
      // Muevo la imagen desde el directorio temporal a nuestra ruta indicada anteriormente
                   
      move_uploaded_file($_FILES['imagenMkt']['tmp_name'],$destination);
	  
    } 
    else 
    {
       //si no cumple con el formato
       echo "No se puede subir una imagen con ese formato ";
    }
} 
else 
{
   //si existe la variable pero se pasa del tamaño permitido
   if($nombre_img == !NULL) echo "La imagen es demasiado grande "; 
}



/*======================================================================*/



				$sqlEdicionCategoria_img = "
					Update
						`imagenesMkt_imagenes`
					Set
						`img_link` = '".$nameImagen."'
					Where
						`idImagen` = '".$idImagen."'
									   ";
				$this->db->query($sqlEdicionCategoria_img);
			}
			
			$sqlEdicionImagen = "
				Update
					`imagenesMkt_imagenes`
				Set
					`idCategoria`	= '".$idCategoria."',
					`idArea`	= '".$idArea."',
					`idSubcategoria`	= '".$idSubcategoria."',
					`nombre`		= '".$nombre."',
					`logo`		= '".$logo."',
					`logoside`		= '".$logoside."'
				Where
					`idImagen` = '".$idImagen."'
								   ";
			$this->db->query($sqlEdicionImagen);
			
			redirect('/imagenesMkt/imagenesModificar/');
		}
	}/*! EdicionImagen */

		function BorrarImagen(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$idImagen = $this->input->get("idImagen",TRUE);
			$data['EditarImagenesMkt']	= $EditarImagenesMkt = $this->capsysdre_imagenes->EditarImagenesMkt($idImagen);
			
			if($idImagen == "" || $EditarImagenesMkt == false ){
				redirect('/imagenesMkt/imagenesModificar');
			} else {
				$destination	= RUTA_ASSETS.'img/imagenesMkt/imagenes//'.$EditarImagenesMkt[0]->img_link;
				//$destination	= 'C:\wamp64\www\Capsys\www\V3\assets\img\imagenesMkt\imagenes\\'.$EditarImagenesMkt[0]->img_link;
				
				if(file_exists($destination)){ unlink($destination); }
				
				$sqlDelete = "
					Delete From
						`imagenesMkt_imagenes`
					Where
						`idImagen` = '".$idImagen."'
							 ";
				$this->db->query($sqlDelete);
				redirect('/imagenesMkt/imagenesModificar');	
			}
		}
	}/*! BorrarImagen */

	function categoria(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$idPersona=$this->tank_auth->get_idPersona();
			$data['ListaImagenesCategoria']	= $this->capsysdre_imagenes->ListaImagenesCategoria($this->input->get('idCategoria', TRUE),$this->input->get('idArea', TRUE),$this->input->get('idSubcategoria', TRUE));
			$data['categoria']	= $this->capsysdre_imagenes->EditarCategoriaImagenes($this->input->get('idCategoria', TRUE));
			$data['Area']	= $this->capsysdre_imagenes->EditarAreaImagenes($this->input->get('idArea', TRUE));
			$data['nombrePersona'] = $this->capsysdre_imagenes->nombreCompleto($idPersona);
			$data['emailPersona'] = $this->capsysdre_imagenes->emailCelular($idPersona);
			$data['idCategoria']	= $this->input->get('idCategoria', TRUE);
			$data['idArea']	= $this->input->get('idArea', TRUE);
				$this->load->view('/imagenesMkt/categoria', $data);
			}
		
	}/*! categoria */

		function areas(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {

			$data['ListaAreasImagenes']	= $this->capsysdre_imagenes->ListaAreasImagenes();
			$data['idCategoria']	= $this->input->get('idCategoria', TRUE);
			
				$this->load->view('/imagenesMkt/areas', $data);
		}
	}/*! areas */

	function areasAgregar(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
				$data['configModulos']	= $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail());
				
					$this->load->view('imagenesMkt/areasAgregar', $data);
		}
		
	}/*! areasAgregar */

function AgregarArea(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$nombre			= urlencode($this->input->post("nombre",TRUE));
			$posicion		= $this->input->post("posicion",TRUE);

			$sqlEdicionArea = "
				Insert Into
					`imagenesMkt_area`
				(
					`nombre`,
					`posicion`,
					`img_link_portada`,
					`img_link_color`,
					`img_link_blanco`
				)
				Values
				(
					'".$nombre."',
					'".$posicion."',
					'noPhoto.png',
					'noPhoto.png',
					'noPhoto.png'
				)
								   ";
			$this->db->query($sqlEdicionArea);
			$idArea = $this->db->insert_id();

			if ($_FILES['imgAreaPortada']["error"] == 0){
				$nameImgAreaPortada = "imgAreaPortada";
				$nameImgAreaPortada.= $idArea;
				$nameImgAreaPortada.= ".".strrev(strstr(strrev($_FILES['imgAreaPortada']['name']), '.', true));
				$destination	= '/var/www/html/V3/assets/img/imagenesMkt/areas/'.$nameImgAreaPortada;
				//$destination	= 'C:\wamp64\www\Capsys\www\V3\assets\img\imagenesMkt\areas\\'.$nameImgAreaPortada;
				
				
				if(file_exists($destination)){ unlink($destination); }
				move_uploaded_file($_FILES['imgAreaPortada']['tmp_name'], $destination);
				
				$sqlEdicionArea_img_portada = "
					Update
						`imagenesMkt_area`
					Set
						`img_link_portada` = '".$nameImgAreaPortada."'
					Where
						`idArea` = '".$idArea."'
									   ";
				$this->db->query($sqlEdicionArea_img_portada);
			}

			if ($_FILES['imgAreaColor']["error"] == 0){
				$nameImgAreaColor = "imgAreaColor";
				$nameImgAreaColor.= $idArea;
				$nameImgAreaColor.= ".".strrev(strstr(strrev($_FILES['imgAreaColor']['name']), '.', true));
				$destination	= RUTA_ASSETS.'img/imagenesMkt/areas//'.$nameImgAreaColor;
				//$destination	= 'C:\wamp64\www\Capsys\www\V3\assets\img\imagenesMkt\areas\\'.$nameImgAreaColor;
				
				
				if(file_exists($destination)){ unlink($destination); }
				move_uploaded_file($_FILES['imgAreaColor']['tmp_name'], $destination);
				
				$sqlEdicionArea_img_color = "
					Update
						`imagenesMkt_area`
					Set
						`img_link_color` = '".$nameImgAreaColor."'
					Where
						`idArea` = '".$idArea."'
									   ";
				$this->db->query($sqlEdicionArea_img_color);
			}
			if ($_FILES['imgAreablanco']["error"] == 0){
				$nameImgAreablanco = "imgAreablanco";
				$nameImgAreablanco.= $idArea;
				$nameImgAreablanco.= ".".strrev(strstr(strrev($_FILES['imgAreablanco']['name']), '.', true));
				$destination	= RUTA_ASSETS.'img/imagenesMkt/areas//'.$nameImgAreablanco;
				//$destination	= 'C:\wamp64\www\Capsys\www\V3\assets\img\imagenesMkt\areas\\'.$nameImgAreablanco;
				
				
				if(file_exists($destination)){ unlink($destination); }
				move_uploaded_file($_FILES['imgAreablanco']['tmp_name'], $destination);
				
				$sqlEdicionArea_img_blanco = "
					Update
						`imagenesMkt_area`
					Set
						`img_link_blanco` = '".$nameImgAreablanco."'
					Where
						`idArea` = '".$idArea."'
									   ";
				$this->db->query($sqlEdicionArea_img_blanco);
			}

			redirect('/imagenesMkt/areasModificar/');
		}
	}/*! AgregarAreas */
function areasModificar(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['ListaAreasImagenes']	= $this->capsysdre_imagenes->ListaAreasImagenes();
			$data['configModulos']			= $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail());
			
				$this->load->view('imagenesMkt/areasModificar', $data);
		}
	}/*! AreasModificar */

	function areaEditar(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$idArea = $this->input->get("idArea",TRUE);
			$data['ListaAreasImagenes']	= $ListaAreasImagenes = $this->capsysdre_imagenes->EditarAreaImagenes($idArea);
			
			if($idArea == "" || $ListaAreasImagenes == false ){
				redirect('/imagenesMkt/areasModificar');
			} else {
				
				$data['configModulos']	= $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail());

					$this->load->view('imagenesMkt/areasEditar', $data);
			}
		}
	}/*! areasEditar */

	function EdicionArea(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {			
			$idArea	= $this->input->post("idArea",TRUE);
			$nombre			= urlencode($this->input->post("nombre",TRUE));
			$posicion		= $this->input->post("posicion",TRUE);
			
			if ($_FILES['imgAreaPortada']["error"] == 0){
				$nameImgAreaPortada = "imgAreaPortada";
				$nameImgAreaPortada.= $idArea;
				$nameImgAreaPortada.= ".".strrev(strstr(strrev($_FILES['imgAreaPortada']['name']), '.', true));
				$destination	= '/var/www/html/V3/assets/img/imagenesMkt/areas/'.$nameImgAreaPortada;
				//$destination	= 'C:\wamp64\www\Capsys\www\V3\assets\img\imagenesMkt\areas\\'.$nameImgAreaPortada;
				
				if(file_exists($destination)){ unlink($destination); }
				move_uploaded_file($_FILES['imgAreaPortada']['tmp_name'], $destination);
				
				$sqlEdicionArea_img_portada = "
					Update
						`imagenesMkt_area`
					Set
						`img_link_portada` = '".$nameImgAreaPortada."'
					Where
						`idArea` = '".$idArea."'
									   ";
				$this->db->query($sqlEdicionArea_img_portada);
			}

			if ($_FILES['imgAreaColor']["error"] == 0){
				$nameImgAreaColor = "imgAreaColor";
				$nameImgAreaColor.= $idArea;
				$nameImgAreaColor.= ".".strrev(strstr(strrev($_FILES['imgAreaColor']['name']), '.', true));
				$destination	= RUTA_ASSETS.'img/imagenesMkt/areas/'.$nameImgAreaColor;
				//$destination	= 'C:\wamp64\www\Capsys\www\V3\assets\img\imagenesMkt\areas\\'.$nameImgAreaColor;
				
				if(file_exists($destination)){ unlink($destination); }
				move_uploaded_file($_FILES['imgAreaColor']['tmp_name'], $destination);
				
				$sqlEdicionArea_img_color = "
					Update
						`imagenesMkt_area`
					Set
						`img_link_color` = '".$nameImgAreaColor."'
					Where
						`idArea` = '".$idArea."'
									   ";
				$this->db->query($sqlEdicionArea_img_color);
			}

			if ($_FILES['imgAreablanco']["error"] == 0){
				$nameImgAreablanco = "imgAreablanco";
				$nameImgAreablanco.= $idArea;
				$nameImgAreablanco.= ".".strrev(strstr(strrev($_FILES['imgAreablanco']['name']), '.', true));
				$destination	= RUTA_ASSETS.'img/imagenesMkt/areas//'.$nameImgAreablanco;
				//$destination	= 'C:\wamp64\www\Capsys\www\V3\assets\img\imagenesMkt\areas\\'.$nameImgAreablanco;
				
				if(file_exists($destination)){ unlink($destination); }
				move_uploaded_file($_FILES['imgAreablanco']['tmp_name'], $destination);
				
				$sqlEdicionArea_img_blanco = "
					Update
						`imagenesMkt_area`
					Set
						`img_link_blanco` = '".$nameImgAreablanco."'
					Where
						`idArea` = '".$idArea."'
									   ";
				$this->db->query($sqlEdicionArea_img_blanco);
			}
			
			$sqlEdicionArea = "
				Update
					`imagenesMkt_area`
				Set
					`nombre` = '".$nombre."',
					`posicion` = '".$posicion."'
				Where
					`idArea` = '".$idArea."'
								   ";
			$this->db->query($sqlEdicionArea);
			
			redirect('/imagenesMkt/areasModificar/');
		}
	}/*! EdicionArea */

		function BorrarArea(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$idArea	= $this->input->get("idArea",TRUE);
			$data['ListaAreasImagenes']	= $ListaAreasImagenes = $this->capsysdre_imagenes->EditarAreaImagenes($idArea);
			
			if($idArea == "" || $ListaAreasImagenes == false ){
				redirect('/imagenesMkt/areasModificar');
			} else {
				$destination	= RUTA_ASSETS.'img/imagenesMkt/areas//'.$ListaAreasImagenes[0]->img_link;
				//$destination	= 'C:\wamp64\www\Capsys\www\V3\assets\img\imagenesMkt\categorias\\'.$ListaAreasImagenes[0]->img_link_color;
				
				if(file_exists($destination)){ unlink($destination); }

				$destination2	= RUTA_ASSETS.'img/imagenesMkt/areas//'.$ListaAreasImagenes[0]->img_link;
				//$destination2	= 'C:\wamp64\www\Capsys\www\V3\assets\img\imagenesMkt\categorias\\'.$ListaAreasImagenes[0]->img_link_blanco;
				
				if(file_exists($destination2)){ unlink($destination2); }
				
				$sqlDelete = "
					Delete From
						`imagenesMkt_area`
					Where
						`idArea` = '".$idArea."'
							 ";
				$this->db->query($sqlDelete);
				redirect('/imagenesMkt/areasModificar');	
			}
		}
	}/*! BorrarArea */
		function subcategoriasAgregar(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
				$data['configModulos']	= $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail());
				
					$this->load->view('imagenesMkt/subcategoriasAgregar', $data);
		}
		
	}/*! subcategoriaAgregar */

	function AgregarSubcategoria(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$nombre			= urlencode($this->input->post("nombre",TRUE));
			$posicion		= $this->input->post("posicion",TRUE);
			$idCategoria		= $this->input->post("idCategoria",TRUE);
			

			$sqlEdicionArea = "
				Insert Into
					`imagenesMkt_subcategorias`
				(
					`idCategoria`,
					`nombre`,
					`posicion`,
					`img_link`
				)
				Values
				(
					'".$idCategoria."',
					'".$nombre."',
					'".$posicion."',
					'noPhoto.png'
				)
								   ";
			$this->db->query($sqlEdicionArea);
			$idSubcategoria = $this->db->insert_id();

			if ($_FILES['imgSubcategoria']["error"] == 0){
				$nameImgSubcategoria = "imgSubcategoria";
				$nameImgSubcategoria.= $idSubcategoria;
				$nameImgSubcategoria.= ".".strrev(strstr(strrev($_FILES['imgSubcategoria']['name']), '.', true));
				$destination	= RUTA_ASSETS.'img/imagenesMkt/subcategorias//'.$nameImgSubcategoria;
				//$destination	= 'C:\wamp64\www\Capsys\www\V3\assets\img\imagenesMkt\subcategorias\\'.$nameImgSubcategoria;
				
				
				if(file_exists($destination)){ unlink($destination); }



/*========================================================================*/

$nombre_img = $_FILES['imgSubcategoria']['name'];
$tipo = $_FILES['imgSubcategoria']['type'];
$tamano = $_FILES['imgSubcategoria']['size'];
		
 
//Si existe imagen y tiene un tamaño correcto
if (($nombre_img == !NULL) && ($_FILES['imgSubcategoria']['size'] <= 20000000)) 
{
   //indicamos los formatos que permitimos subir a nuestro servidor
   if (($_FILES["imgSubcategoria"]["type"] == "image/gif")
   || ($_FILES["imgSubcategoria"]["type"] == "image/jpeg")
   || ($_FILES["imgSubcategoria"]["type"] == "image/jpg")
   || ($_FILES["imgSubcategoria"]["type"] == "image/png"))
   {
      // Ruta donde se guardarán las imágenes que subamos
      // Muevo la imagen desde el directorio temporal a nuestra ruta indicada anteriormente
                   
      move_uploaded_file($_FILES['imgSubcategoria']['tmp_name'],$destination);
	  
    } 
    else 
    {
       //si no cumple con el formato
       echo "No se puede subir una imagen con ese formato ";
    }
} 
else 
{
   //si existe la variable pero se pasa del tamaño permitido
   if($nombre_img == !NULL) echo "La imagen es demasiado grande "; 
}



/*======================================================================*/

				
				$sqlEdicionSubcategoria_img = "
					Update
						`imagenesMkt_subcategorias`
					Set
						`img_link` = '".$nameImgSubcategoria."'
					Where
						`idSubcategoria` = '".$idSubcategoria."'
									   ";
				$this->db->query($sqlEdicionSubcategoria_img);
			}

			redirect('/imagenesMkt/subcategoriasModificar/');
		}
	}/*! AgregarSubcategorias */

	function subcategoriasModificar(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['ListaSubcategoriasImagenes']	= $this->capsysdre_imagenes->ListaSubcategoriasImagenes();
			$data['configModulos']			= $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail());
			
				$this->load->view('imagenesMkt/subcategoriasModificar', $data);
		}
	}/*! subcategoriasModificar */

	function subcategoriasEditar(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$idSubcategoria = $this->input->get("idSubcategoria",TRUE);
			$data['ListaSubcategoriasImagenes']	= $ListaSubcategoriasImagenes = $this->capsysdre_imagenes->EditarSubcategoriaImagenes($idSubcategoria);
			
			if($idSubcategoria == "" || $ListaSubcategoriasImagenes == false ){
				redirect('/imagenesMkt/subcategoriasModificar');
			} else {
				
				$data['configModulos']	= $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail());

					$this->load->view('imagenesMkt/subcategoriasEditar', $data);
			}
		}
	}/*! subcategoriasEditar */
	
	function EdicionSubcategoria(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {			
			$idSubcategoria	= $this->input->post("idSubcategoria",TRUE);
			$idCategoria		= $this->input->post("idCategoria",TRUE);
			$nombre			= urlencode($this->input->post("nombre",TRUE));
			$posicion		= $this->input->post("posicion",TRUE);

			if ($_FILES['imgSubcategoria']["error"] == 0){
				$nameImgSubcategoria = "imgSubcategoria";
				$nameImgSubcategoria.= $idSubcategoria;
				$nameImgSubcategoria.= ".".strrev(strstr(strrev($_FILES['imgSubcategoria']['name']), '.', true));
				$destination	= RUTA_ASSETS.'img/imagenesMkt/subcategorias//'.$nameImgSubcategoria;
				//$destination	= 'C:\wamp64\www\Capsys\www\V3\assets\img\imagenesMkt\subcategorias\\'.$nameImgSubcategoria;
				
				if(file_exists($destination)){ unlink($destination); }


/*========================================================================*/

$nombre_img = $_FILES['imgSubcategoria']['name'];
$tipo = $_FILES['imgSubcategoria']['type'];
$tamano = $_FILES['imgSubcategoria']['size'];
		
 
//Si existe imagen y tiene un tamaño correcto
if (($nombre_img == !NULL) && ($_FILES['imgSubcategoria']['size'] <= 20000000)) 
{
   //indicamos los formatos que permitimos subir a nuestro servidor
   if (($_FILES["imgSubcategoria"]["type"] == "image/gif")
   || ($_FILES["imgSubcategoria"]["type"] == "image/jpeg")
   || ($_FILES["imgSubcategoria"]["type"] == "image/jpg")
   || ($_FILES["imgSubcategoria"]["type"] == "image/png"))
   {
      // Ruta donde se guardarán las imágenes que subamos
      // Muevo la imagen desde el directorio temporal a nuestra ruta indicada anteriormente
                   
      move_uploaded_file($_FILES['imgSubcategoria']['tmp_name'],$destination);
	  
    } 
    else 
    {
       //si no cumple con el formato
       echo "No se puede subir una imagen con ese formato ";
    }
} 
else 
{
   //si existe la variable pero se pasa del tamaño permitido
   if($nombre_img == !NULL) echo "La imagen es demasiado grande "; 
}



/*======================================================================*/
				
				$sqlEdicionSubcategoria_img = "
					Update
						`imagenesMkt_subcategorias`
					Set
						`img_link` = '".$nameImgSubcategoria."'
					Where
						`idSubcategoria` = '".$idSubcategoria."'
									   ";
				$this->db->query($sqlEdicionSubcategoria_img);
			}
			
			$sqlEdicionSubcategoria = "
				Update
					`imagenesMkt_subcategorias`
				Set
					`idCategoria` = '".$idCategoria."',
					`nombre` = '".$nombre."',
					`posicion` = '".$posicion."'
				Where
					`idSubcategoria` = '".$idSubcategoria."'
								   ";
			$this->db->query($sqlEdicionSubcategoria);
			
			redirect('/imagenesMkt/subcategoriasModificar/');
		}
	}/*! EdicionSubcategoria */

			function subcategoria(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {

			$data['ListaSubcategoriasImagenes']	= $this->capsysdre_imagenes->ListaSubcategoriasCategoriasImagenes($this->input->get('idCategoria', TRUE));
			$data['idCategoria']	= $this->input->get('idCategoria', TRUE);
			$data['idArea']	= $this->input->get('idArea', TRUE);
			
				$this->load->view('/imagenesMkt/subcategorias', $data);
		}
	}/*! subcategoria */

		function subcategoriaFirmas(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {

			$data['ListaSubcategoriasImagenes']	= $this->capsysdre_imagenes->ListaSubcategoriasCategoriasImagenes($this->input->get('idCategoria', TRUE));
			$data['idCategoria']	= $this->input->get('idCategoria', TRUE);
			
			
				$this->load->view('/imagenesMkt/subcategoriasFirmas', $data);
		}
	}/*! subcategoria */

	function firmas(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$idPersona=$this->tank_auth->get_idPersona();
			$data['ListaImagenesFirma']	= $this->capsysdre_imagenes->ListaImagenesFirma($this->input->get('idCategoria', TRUE),$this->input->get('idSubcategoria', TRUE));
			$data['categoria']	= $this->capsysdre_imagenes->EditarCategoriaImagenes($this->input->get('idCategoria', TRUE));
			$data['infoPersona'] = $infoPersona = $this->capsysdre_imagenes->nombreCompleto($idPersona);
			$data['personaPuesto']= $this->capsysdre_imagenes->personaPuesto($infoPersona[0]->idPersonaPuesto);
			if($infoPersona[0]->celOficina==""){
				$data['celOficina']="";
			}else{
				$data['celOficina']='Cel: '.$infoPersona[0]->celOficina.' <i style="color: green !important;" class="fa fa-whatsapp" aria-hidden="true"></i><br>';
			}
			$data['idValida'] =$idValida = $this->capsysdre_imagenes->obtenerUserMiInfo($idPersona);
			$data['linkQR'] = $this->capsysdre_imagenes->generarQR($idValida[0]->IDValida);
			$data['idCategoria']	= $this->input->get('idCategoria', TRUE);
				$this->load->view('/imagenesMkt/firmas', $data);
			}
		
	}/*! firma */

		function general(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$idPersona=$this->tank_auth->get_idPersona();
			$data['ListaImagenesGeneral']	= $this->capsysdre_imagenes->ListaImagenesGeneral($this->input->get('idCategoria', TRUE));
			$data['categoria']	= $this->capsysdre_imagenes->EditarCategoriaImagenes($this->input->get('idCategoria', TRUE));
				$this->load->view('/imagenesMkt/general', $data);
			}
		
	}/*! categoria */

}

/* End of file inicio.php */
/* Location: ./application/controllers/inicio.php */