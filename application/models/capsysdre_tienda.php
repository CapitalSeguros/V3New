<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class capsysdre_tienda extends CI_Model {
		 
	function __construct(){
		parent::__construct();
	}
	
	function ListaCategoriasTienda(){		
		$this->db->from("tienda_categorias");
		$this->db->order_by("tienda_categorias.posicion", "asc");
		$query = $this->db->get();

		if($query->num_rows() > 0){
  			$return = $query;
		} else {
			$return = "";
		}
		
		return
			$return;
	} /*! ListaCategoriasTienda */
	
	function tengoPedidos($idUsuario){		
		$this->db->from("tienda_pedidos");
		$this->db->where("tienda_pedidos.idUsuario", $idUsuario);
		$this->db->order_by("tienda_pedidos.fecha", "asc");
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
  			$return = true;
		} else {
			$return = false;
		}
		
		return
			$return;
	} /*! TotalListaUsuarios */
    
    function misPedidos($idUsuario){	        	
		$query = $this->db->query("SELECT idPedido, fecha, idUsuario, totalPedido, pagado, (SELECT COUNT(*) FROM tienda_pedidos_surtido WHERE tienda_pedidos_surtido.idPedido = tienda_pedidos.idPedido) AS surtido FROM tienda_pedidos WHERE tienda_pedidos.idUsuario = ".$idUsuario." ;");
		
		// $query = $this->db->get();
		
		if($query->num_rows() > 0){
  			$return = $query->result_array();
		} else {
			$return = array();
		}
		return $return;
	}
    
    function misProductos(){
        $result = array();
        $carrito = $this->session->userdata('carrito');
        if($carrito == null)
            return $result;
        
        foreach ($carrito as $value) {
            $this->db->where('idArticulo', $value['idArticulo']);
            $this->db->from('tienda_articulos');
            $query = $this->db->get();
            if($query->num_rows() > 0){
               array_push($result,array('data'=>$query->result(),'cantidad' => $value['cantidad'], 'talla'=> $value['talla']));
            }
        }	        	
		
		
		return $result;
	}
    
    function borrarPedido($idPedido){
        $this->db->where('idPedido', $idPedido);
        $query = $this->db->delete('tienda_pedidos');
        var_dump($query);
        
    }
    
    function getSurtido($idPedido){
        $this->db->from("tienda_pedidos_surtido");
		$this->db->where("tienda_pedidos_surtido.idPedido", $idPedido);
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
  			$return = true;
		} else {
			$return = false;
		}
		return $return;
    }
	
	function ListaArticulosTienda($idCategoria){		
		$this->db->from("tienda_articulos");
		$this->db->where("tienda_articulos.idCategoria", $idCategoria);
		$this->db->order_by("tienda_articulos.nombre", "asc");
		$query = $this->db->get();

		if($query->num_rows() > 0){
  			$return = $query;
		} else {
			$return = "";
		}
		
		return
			$return;
	} /*! ListaCategoriasTienda */

	function misPedidosDetalle($idPedido){
        
        $query = $this->db->query("SELECT * FROM `tienda_pedidos_productos` INNER JOIN `tienda_articulos` ON `tienda_pedidos_productos`.`idProducto` = `tienda_articulos`.`idArticulo` WHERE tienda_pedidos_productos.idPedido ='".$idPedido."';");
		
		// $query = $this->db->get();
		
		if($query->num_rows() > 0){
  			$return = $query->result_array();
		} else {
			$return = array();
		}
		return $return;
	}
    
    function crearpedido($idUser){
        
        $data = $this->session->userdata('carrito');
        $total = 0;
        foreach ($data as $value) {
            $total = $total + ($value['precio'] * $value['cantidad']);
        }
        
        $tiendapedido = array(
            'idUsuario' => $idUser,
            'totalPedido' => $total,
        );
        $this->db->insert('tienda_pedidos',$tiendapedido);
        $idPedido = $this->db->insert_id();
        $data_pedido = array();
        foreach ($data as $value) {
            $tmp = array(
                    'idPedido' => $idPedido, 
                    'idProducto' => $value['idArticulo'],
                    'cantidad' => $value['cantidad'],
                    'precio' => $value['precio']);   
            array_push($data_pedido,$tmp);
        }
        $this->db->insert_batch('tienda_pedidos_productos',$data_pedido);

        return $idPedido;
    } 
    function pedidosSurtir(){
		$sql =	"
					Select 
						*
						,`users`.`id`
					From
						`tienda_pedidos` Inner Join `users`
						On
						`tienda_pedidos`.`idUsuario` = `users`.`id`
					Order By
						`idPedido` Desc
				";  	
		$query = $this->db->query($sql);
				
		if($query->num_rows() > 0){
			return
				$query->result_array();
		} else {
			return
				false;
		}
	}
 
    function DreCalculaPedidoPendiente($idPedido){
			$sql =	"
				Select * From 
					`tienda_pedidos_productos` 
				Where
					`idPedido` = '".$idPedido."'
					";

		$query = $this->db->query($sql);
		if($query->num_rows() > 0){
				foreach($query->result() as $registro){
					if($registro->cantidad == $registro->surtidos){
						$estatusPartida[] = "Surtida";
					} else if($registro->cantidad != $registro->surtidos){
						$estatusPartida[] = "Pendiente";
					}
				}
				if(in_array("Pendiente", $estatusPartida)){
					$estatusPartidaFinal = "Si";
				} else {
					$estatusPartidaFinal = "No";
				}
				return
					$estatusPartidaFinal;
		} else {
			return
				false;
		}
    }
    
 	function EditarCategoriaTienda($idCategoria){
		$sql = "
			Select * From
				`tienda_categorias`
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
	} /*! EditarCategoriaTienda */   
	
	function EditarArticulosTienda($idArticulo){
		$sql = "
			Select * From 
				`tienda_articulos`
			Where
				 `idArticulo` = '".$idArticulo."'
			   ";
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0){
  			$return = $query->result();
		} else {
			$return = false;
		}

		return
			$return;
	} /*! EditarArticulosTienda */
}