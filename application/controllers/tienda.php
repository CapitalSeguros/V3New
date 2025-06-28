<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class tienda extends CI_Controller{

	function __construct(){
		parent::__construct();   
					$this->load->model('clientelealtadmodelo'); 
			$this->load->model('personamodelo');  
			$this->load->library('Ws_sicas'); 
	}

	function index(){		
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['ListaCategoriasTienda']	= $this->capsysdre_tienda->ListaCategoriasTienda();
			$data['tiendaestatus'] 			= array(
                                        		'pedidos'=>$this->capsysdre_tienda->tengoPedidos($this->tank_auth->get_user_id()),
                                        		'carrito'=>$this->session->userdata('carrito')
											  );
			$data['configModulos']			= $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail());

				$this->load->view('tienda/principal', $data);
		}
	}/*! index */
	
	function categoria(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {

            $data['tiendaestatus'] = array(
                                        'pedidos'=>$this->capsysdre_tienda->tengoPedidos($this->tank_auth->get_user_id()),
                                        'carrito'=>$this->session->userdata('carrito'));
			$data['ListaArticulosTienda']	= $this->capsysdre_tienda->ListaArticulosTienda($this->input->get('idCategoria', TRUE));
			
				$this->load->view('tienda/categoria', $data);
		}
	}/*! categoria */
    
    function pedidodetalle($idPedido = 0){
        if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
            
            
            $data['tiendaestatus'] = array(
                                        'pedidos'=>$this->capsysdre_tienda->tengoPedidos($this->tank_auth->get_user_id()),
                                        'carrito'=>$this->session->userdata('carrito'));
			
            $data['misPedidos'] = $this->capsysdre_tienda->misPedidosDetalle($idPedido);
            $this->load->view('tienda/mispedidosdetalle', $data);
		}
    }
	
	function misPedidos(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
            
            
            $data['tiendaestatus'] = array(
                                        'pedidos'=>$this->capsysdre_tienda->tengoPedidos($this->tank_auth->get_user_id()),
                                        'carrito'=>$this->session->userdata('carrito'));
                                        
            $data['misPedidos'] = $this->capsysdre_tienda->misPedidos($this->tank_auth->get_user_id());
            $this->load->view('tienda/misPedidos', $data);
		}
	}/*! misPedidos */
    
    function cancelarpedido($idPedido){
        $this->capsysdre_tienda->borrarPedido($idPedido);
        
        redirect('/tienda/mispedidos');
    }
    
    function cancelarproducto($idArticulo){
        if($this->session->userdata('carrito') != null){
            $tiendaCapsys = $this->session->userdata('carrito');
            unset($tiendaCapsys[md5($idArticulo)]);
            $this->session->set_userdata('carrito',$tiendaCapsys);   
        }
        redirect('/tienda/misproductos');
    }
    
    function crearpedido(){
        if($this->session->userdata('carrito') == true){    
            $idPedido = $this->capsysdre_tienda->crearpedido($this->tank_auth->get_user_id());
            $this->enviarPedido($idPedido);
            $this->session->unset_userdata('carrito');
            echo 'true';
        }else{
            echo 'false';
        }
    }
	
	function agregarCarrito($idArticulo,$cantidad,$precio,$idCategoria,$talla = '',$puntos){
        if($this->session->userdata('carrito') != null){
            $tiendaCapsys = $this->session->userdata('carrito');    
        }
        $tiendaCapsys[md5($idArticulo)] = array(
            'idArticulo'=>$idArticulo,
            'talla'=>$talla,
            'cantidad'=>$cantidad,
            'precio'=>$precio,
            'puntos'=>$puntos,
        );    
		
        $this->session->set_userdata('carrito',$tiendaCapsys);
        
	    echo 'true';
	}
function cambiarProductosPorPuntos(){
	
	$mensaje="";
	if($_GET['idPersona']>0){
	if($_GET['IDClie']>0){
	$data =$this->session->userdata('carrito');
	            //$data['misProductos'] = $this->capsysdre_tienda->misProductos(); 
	//  $data['misPedidos'] = $this->capsysdre_tienda->misPedidosDetalle($idPedido);
	//array('pedidos'=>$this->capsysdre_tienda->tengoPedidos($this->tank_auth->get_user_id()),'carrito'=>$this->session->userdata('carrito'));
    $this->load->model('puntos_model');
    $puntos=0;
	$puntos=$this->puntos_model->obtenerPuntosCliente($_GET['IDClie']);
    $sumPuntos=0;//(double)$puntos[0]->PUNTOS+1;
    
    foreach ($data as  $value) {
     $sumPuntos=(double)$sumPuntos+(double)((double)$value['cantidad']*(double)$value['puntos']);
    }

    if((double)$puntos[0]->PUNTOS>=$sumPuntos){
    	$folio=$this->puntos_model->devuelveFolio();
    	    
       
      foreach ($data as  $value) {
      $puntos=(double)$value['puntos']*(double)$value['cantidad'];
     $sumPuntos=(double)$sumPuntos+(double)((double)$value['cantidad']*(double)$value['puntos']);
     $insert['IDCli']=$_GET['IDClie'];
     $insert['PUNTOS']=$puntos;
     $insert['idArticulo']=$value['idArticulo'];
     $insert['cantPuntos']=$value['puntos'];
     $insert['cantArticulos']=$value['cantidad'];
     $insert['idPersona']=$_GET['idPersona'];
     $insert['operacion']=-1;
     $insert['folioTicket']=$folio[0]->valor;
     $this->puntos_model->guardarEnBitacora($insert);
      $this->puntos_model->sumaPuntos($_GET['IDClie'],-$puntos,$_GET['idPersona']);
    }

     $mensaje="Cambio satisfactorio";
     $this->session->unset_userdata('carrito');
    }else
    {$mensaje="No hay puntos suficientes";}                  
    
	  //$this->session->unset_userdata('carrito');//BORRA ARTICULOS DE CARRO
    }
    else{$mensaje="Escoger Cliente";}
    }
    else{
    	$mensaje="Escoger Agente";
    }
	echo json_encode($mensaje);
}
	function misProductos(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		}else{
            $data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
            $data['tiendaestatus'] = array(
                                        'pedidos'=>$this->capsysdre_tienda->tengoPedidos($this->tank_auth->get_user_id()),
                                        'carrito'=>$this->session->userdata('carrito'));
                                        
            $data['misProductos'] = $this->capsysdre_tienda->misProductos();
                   $data['agentesPromocion']=$this->buscaAgentePromocion();
            $this->load->view('tienda/misproductos', $data);
		}
	}

    function pedidodemo(){
        $data['misPedidos'] = $this->capsysdre_tienda->misPedidosDetalle('11');
        
    }

    function enviarPedido($idPedido){

        $data['misPedidos'] = $this->capsysdre_tienda->misPedidosDetalle($idPedido);

        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
        
        $this->load->library('email',$config);
        $this->load->library('sendemail');
        $this->sendemail->enviarSolicitudTienda($this->load->view('tienda/pedidosdetalle', $data,TRUE));
    }
	
	function pedidosSurtir(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {            
            $data['pedidosSurtir'] = $this->capsysdre_tienda->pedidosSurtir();
            $this->load->view('tienda/pedidosSurtir', $data);
		}
	}/*! pedidosSurtir */
	
	/* -Administracion Tienda - */
	
	function categoriasModificar(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['ListaCategoriasTienda']	= $this->capsysdre_tienda->ListaCategoriasTienda();
			$data['tiendaestatus'] 			= array(
                                        		'pedidos'=>$this->capsysdre_tienda->tengoPedidos($this->tank_auth->get_user_id()),
                                        		'carrito'=>$this->session->userdata('carrito')
											  );
			$data['configModulos']			= $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail());
			
				$this->load->view('tienda/categoriasModificar', $data);
		}
	}/*! categoriasModificar */
	
	function categoriasEditar(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$idCategoria = $this->input->get("idCategoria",TRUE);
			$data['EditarCategoriaTienda']	= $EditarCategoriaTienda = $this->capsysdre_tienda->EditarCategoriaTienda($idCategoria);
			
			if($idCategoria == "" || $EditarCategoriaTienda == false ){
				redirect('/tienda/categoriasModificar');
			} else {
				$data['tiendaestatus']	= array(
												'pedidos'=>$this->capsysdre_tienda->tengoPedidos($this->tank_auth->get_user_id()),
												'carrito'=>$this->session->userdata('carrito')
										  );
				$data['configModulos']	= $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail());

					$this->load->view('tienda/categoriasEditar', $data);
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
				$nameImgCategoria = "Categoria_";
				$nameImgCategoria.= $idCategoria;
				$nameImgCategoria.= ".".strrev(strstr(strrev($_FILES['imgCategoria']['name']), '.', true));
				$destination	= RUTA_ASSETS.'assets/img/tienda/categorias/'.$nameImgCategoria;
				//--> $destination	= 'C:\wamp\www\web_capsys\www\V3\assets\img\tienda\categorias\\'.$nameImgCategoria;
				
				if(file_exists($destination)){ unlink($destination); }
				move_uploaded_file($_FILES['imgCategoria']['tmp_name'], $destination);
				
				$sqlEdicionCategoria_img = "
					Update
						`tienda_categorias`
					Set
						`img_link` = '".$nameImgCategoria."'
					Where
						`idCategoria` = '".$idCategoria."'
									   ";
				$this->db->query($sqlEdicionCategoria_img);
			}
			
			$sqlEdicionCategoria = "
				Update
					`tienda_categorias`
				Set
					`nombre` = '".$nombre."',
					`posicion` = '".$posicion."'
				Where
					`idCategoria` = '".$idCategoria."'
								   ";
			$this->db->query($sqlEdicionCategoria);
			
			redirect('/tienda/categoriasModificar/');
		}
	}/*! EdicionCategoria */
	
	function categoriasAgregar(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
				$data['tiendaestatus']	= array(
												'pedidos'=>$this->capsysdre_tienda->tengoPedidos($this->tank_auth->get_user_id()),
												'carrito'=>$this->session->userdata('carrito')
										  );
				$data['configModulos']	= $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail());
				
					$this->load->view('tienda/categoriasAgregar', $data);
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
					`tienda_categorias`
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
				$nameImgCategoria = "Categoria_";
				$nameImgCategoria.= $idCategoria;
				$nameImgCategoria.= ".".strrev(strstr(strrev($_FILES['imgCategoria']['name']), '.', true));
				$destination	= RUTA_ASSETS.'assets/img/tienda/categorias/'.$nameImgCategoria;
				//--> $destination	= 'C:\wamp\www\web_capsys\www\V3\assets\img\tienda\categorias\\'.$nameImgCategoria;
				
				if(file_exists($destination)){ unlink($destination); }
				move_uploaded_file($_FILES['imgCategoria']['tmp_name'], $destination);
				
				$sqlEdicionCategoria_img = "
					Update
						`tienda_categorias`
					Set
						`img_link` = '".$nameImgCategoria."'
					Where
						`idCategoria` = '".$idCategoria."'
									   ";
				$this->db->query($sqlEdicionCategoria_img);
			}

			redirect('/tienda/categoriasModificar/');
		}
	}/*! AgregarCategoria */
	
	function BorrarCategoria(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$idCategoria	= $this->input->get("idCategoria",TRUE);
			$data['EditarCategoriaTienda']	= $EditarCategoriaTienda = $this->capsysdre_tienda->EditarCategoriaTienda($idCategoria);
			
			if($idCategoria == "" || $EditarCategoriaTienda == false ){
				redirect('/tienda/categoriasModificar');
			} else {
				$destination	= RUTA_ASSETS.'assets/img/tienda/categorias/'.$EditarCategoriaTienda[0]->img_link;
				//--> $destination	= 'C:\wamp\www\web_capsys\www\V3\assets\img\tienda\categorias\\'.$EditarCategoriaTienda[0]->img_link;
				if(file_exists($destination)){ unlink($destination); }
				
				$sqlDelete = "
					Delete From
						`tienda_categorias`
					Where
						`idCategoria` = '".$idCategoria."'
							 ";
				$this->db->query($sqlDelete);
				redirect('/tienda/categoriasModificar');	
			}
		}
	}/*! BorrarCategoria */
	
	
	
	function articulosModificar(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['ListaCategoriasTienda']	= $this->capsysdre_tienda->ListaCategoriasTienda();
			$data['tiendaestatus'] 			= array(
                                        		'pedidos'=>$this->capsysdre_tienda->tengoPedidos($this->tank_auth->get_user_id()),
                                        		'carrito'=>$this->session->userdata('carrito')
											  );
			$data['configModulos']			= $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail());
			
				$this->load->view('tienda/articulosModificar', $data);
		}
	}/*! articulosModificar */
	
	function articulosEditar(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$idArticulo = $this->input->get("idArticulo",TRUE);
			$data['EditarArticulosTienda']	= $EditarArticulosTienda = $this->capsysdre_tienda->EditarArticulosTienda($idArticulo);
			
			if($idArticulo == "" || $EditarArticulosTienda == false ){
				redirect('/tienda/articulosModificar');
			} else {
				$data['tiendaestatus']	= array(
												'pedidos'=>$this->capsysdre_tienda->tengoPedidos($this->tank_auth->get_user_id()),
												'carrito'=>$this->session->userdata('carrito')
										  );
				$data['configModulos']	= $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail());

                  

              // $datos = $data['EditarArticulosTienda']->fetch(PDO::FETCH_ASSOC)["imagen"]; 
			

             

					$this->load->view('tienda/articulosEditar', $data);
			}
		}
	}/*! articulosEditar */
	
	function EdicionArticulo(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {			
			$idArticulo		= $this->input->post("idArticulo",TRUE);
			$idCategoria	= $this->input->post("idCategoria",TRUE);
			$nombre			= urlencode($this->input->post("nombre",TRUE));
			$precio			= $this->input->post("precio",TRUE);
			$controlaTallas	= $this->input->post("controlaTallas",TRUE);
			$puntos         = $this->input->post("puntos",TRUE);
			if($controlaTallas == ""){
				$controlaTallas = 0;
			} else {
				$controlaTallas = $this->input->post("controlaTallas",TRUE);
			}
			
			if ($_FILES['imgArticulo']["error"] == 0){
				$nameImgArticulo = "Articulo_";
				$nameImgArticulo.= $idArticulo;
				$nameImgArticulo.= ".".strrev(strstr(strrev($_FILES['imgArticulo']['name']), '.', true));
				$destination	= RUTA_ASSETS.'assets/img/tienda/articulos/'.$nameImgArticulo;
				//--> $destination	= 'C:\wamp\www\web_capsys\www\V3\assets\img\tienda\articulos\\'.$nameImgArticulo;
				
				if(file_exists($destination)){ unlink($destination); }
				move_uploaded_file($_FILES['imgArticulo']['tmp_name'], $destination);
				
				$sqlEdicionCategoria_img = "
					Update
						`tienda_articulos`
					Set
						`img_link` = '".$nameImgArticulo."'
					Where
						`idArticulo` = '".$idArticulo."'
									   ";
				$this->db->query($sqlEdicionCategoria_img);
			}
			
			$sqlEdicionArticulo = "
				Update
					`tienda_articulos`
				Set
					`idCategoria`	= '".$idCategoria."',
					`nombre`		= '".$nombre."',
					`precio`		= '".$precio."',
					`puntos`		= '".$puntos."',
					`controlaTallas`	= '".$controlaTallas."'
				Where
					`idArticulo` = '".$idArticulo."'
								   ";
			$this->db->query($sqlEdicionArticulo);
			
			redirect('/tienda/articulosModificar/');
		}
	}/*! EdicionArticulo */
	
	function articulosAgregar(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
				$data['tiendaestatus']	= array(
												'pedidos'=>$this->capsysdre_tienda->tengoPedidos($this->tank_auth->get_user_id()),
												'carrito'=>$this->session->userdata('carrito')
										  );
				$data['configModulos']	= $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail());
				
					$this->load->view('tienda/articulosAgregar', $data);
		}
		
	}/*! categoriasAgregar */
	
	function AgregarArticulo(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {

			$ddd=base_url();

			$idCategoria	= $this->input->post("idCategoria",TRUE);
			$nombre			= urlencode($this->input->post("nombre",TRUE));
			$precio			= $this->input->post("precio",TRUE);
			$controlaTallas	= $this->input->post("controlaTallas",TRUE);
			$puntos = $this->input->post("punto",TRUE);
			//$imagen= $this->input->post("imgArticulo",TRUE);
			//$_FILES['imagen']=$this->input->post("imgArticulo",TRUE);
			$imagen = base64_encode(file_get_contents($_FILES['imgArticulo']['tmp_name']));

			if($controlaTallas == ""){
				$controlaTallas = 0;
			} else {
				$controlaTallas = $this->input->post("controlaTallas",TRUE);
			}

			$sqlInsertArticulo = "
				Insert Into
					`tienda_articulos`
				(
					`idCategoria`,
					`nombre`,
					`precio`,
					`controlaTallas`,
					`img_link`,
				     `puntos`
				)
				Values
				(
					'".$idCategoria."',
					'".$nombre."',
					'".$precio."',
					'".$controlaTallas."',
					'noPhoto.png',
					'".$puntos."'
				)


								   ";

					/*$fp = fopen('resultadoJason.txt', 'w');
                  fwrite($fp, print_r($sqlInsertArticulo, TRUE));
                   fclose($fp);*/

			$this->db->query($sqlInsertArticulo);
			$idArticulo = $this->db->insert_id();

			if ($_FILES['imgArticulo']["error"] == 0){
				$nameImgArticulo = "Articulo_";
				$nameImgArticulo.= $idArticulo;
				$nameImgArticulo.= ".".strrev(strstr(strrev($_FILES['imgArticulo']['name']), '.', true));
				/*LO COMENTE ES LA DIRECCION ANTERIOR*/
				$destination	= RUTA_ASSETS.'assets/img/tienda/articulos/'.$nameImgArticulo;

/*===================PARA GUARDARLO LOCALMENTE===============================================*/
      //$destination = $_SERVER['DOCUMENT_ROOT'].'/Capsys/www/V3/assets/img/tienda/articulos/'.$nameImgArticulo;

            

				//--> $destination	= 'C:\wamp\www\web_capsys\www\V3\assets\img\tienda\articulos\\'.$nameImgArticulo;
				
				if(file_exists($destination)){ unlink($destination); }

				
				 // $ruta='C:/locm/imagenes/'.$Iname;
				//move_uploaded_file($_FILES['imgArticulo']['tmp_name'], $destination);
				 

/*========================================================================*/

$nombre_img = $_FILES['imgArticulo']['name'];
$tipo = $_FILES['imgArticulo']['type'];
$tamano = $_FILES['imgArticulo']['size'];
		
 
//Si existe imagen y tiene un tamaño correcto
if (($nombre_img == !NULL) && ($_FILES['imgArticulo']['size'] <= 200000)) 
{
   //indicamos los formatos que permitimos subir a nuestro servidor
   if (($_FILES["imgArticulo"]["type"] == "image/gif")
   || ($_FILES["imgArticulo"]["type"] == "image/jpeg")
   || ($_FILES["imgArticulo"]["type"] == "image/jpg")
   || ($_FILES["imgArticulo"]["type"] == "image/png"))
   {
      // Ruta donde se guardarán las imágenes que subamos
      // Muevo la imagen desde el directorio temporal a nuestra ruta indicada anteriormente
                   
      move_uploaded_file($_FILES['imgArticulo']['tmp_name'],$destination);
	  
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

				
				$sqlEdicionArticulo_img = "
					Update
						`tienda_articulos`
					Set
						`img_link` = '".$nameImgArticulo."'
					Where
						`idArticulo` = '".$idArticulo."'
									   ";
				$this->db->query($sqlEdicionArticulo_img);
			}

			redirect('/tienda/articulosModificar/');
		}
	}/*! AgregarArticulo */
	
	function BorrarArticulo(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$idArticulo	= $this->input->get("idArticulo",TRUE);
			$data['EditarArticulosTienda']	= $EditarArticulosTienda = $this->capsysdre_tienda->EditarArticulosTienda($idArticulo);
			
			if($idArticulo == "" || $EditarArticulosTienda == false ){
				redirect('/tienda/articulosModificar');
			} else {
				$destination	= RUTA_ASSETS.'assets/img/tienda/articulos/'.$EditarCategoriaTienda[0]->img_link;
				//--> $destination	= 'C:\wamp\www\web_capsys\www\V3\assets\img\tienda\articulos\\'.$EditarArticulosTienda[0]->img_link;
				if(file_exists($destination)){ unlink($destination); }
				
				$sqlDelete = "
					Delete From
						`tienda_articulos`
					Where
						`idArticulo` = '".$idArticulo."'
							 ";
				$this->db->query($sqlDelete);
				redirect('/tienda/articulosModificar');	
			}
		}
	}/*! BorrarArticulo */

function obtenerClientesDeSicas(){

$idVen=$this->personamodelo->obtenerIdVendedor($_GET['idPersona']);
	$respuesta=$this->ws_sicas->obtenerClientesPorVendedor($idVen[0]->IDVend,$_GET['nombreCliente']);
   $clientesPorAgente="";
  // $fp=fopen('resultadoJason.txt','a');fwrite($fp,print_r($respuesta,true));fclose($fp);
  // $respuesta=$this->ws_sicas->obtenerClientePorID(20810);
    
   $i=0;
  if(isset($respuesta->TableInfo)){
   foreach ($respuesta->TableInfo as $key => $value) {
    $clientesPorAgente[$i]['IDCli']=(string)$value->IDCli[0];
    $clientesPorAgente[$i]['nombreCompleto']=(string)$value->NombreCompleto[0];
    $i++;
   }
      $this->datos['clientesPorAgente']=$clientesPorAgente;
      $this->datos['cant']=count($clientesPorAgente);

  }
   else
   {
   	$this->datos['mensaje']="No se encontraron coincidencias";
   }
  //$this->datos['idPersona']=$_POST['selectAgentesClub'];
  //$this->datos['pestania']="divAsignarPuntos";
    	echo json_encode($this->datos);
}

//--------------------------------------------------------
function obtenerPuntosCliente(){
		$this->load->model('puntos_model');
$puntos="";
 $puntos=$this->puntos_model->obtenerPuntosCliente($_GET['IDVend']);
 if(count($puntos)>0){$puntos=$puntos[0]->PUNTOS;}
 else{$puntos=0;}
   
  echo json_encode($puntos);	
}
//--------------------------------------------------------
function buscaAgentePromocion(){   	
      $datos=$this->clientelealtadmodelo->buscaPromocionAgente(null);
       return $datos;
}
//-----------------------------------------------------------------------------
 function buscarPuntosPorAgente()
 {
 	 
 	  $this->load->model('puntos_model');
 	if($_GET['idPersona']>0){
         $puntos=$this->puntos_model->obtenerPuntosDeLosClientes($_GET['idPersona']);          
 	}
 	else{
 		$puntos[0]['IDCli']=0;
 		$puntos[0]['PUNTOS']=0;
 		$puntos[0]['nombreCliente']="0 Resultados";
 	}

   echo json_encode($puntos);		
  
 }
//-----------------------------------------------------------------------------


}

/* End of file inicio.php */
/* Location: ./application/controllers/inicio.php */