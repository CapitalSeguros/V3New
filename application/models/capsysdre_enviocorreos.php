<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class capsysdre_enviocorreos extends CI_Model {
		 
	function __construct(){
		parent::__construct();
	}

	function correosPendientesEnviar(){
		$query = $this->db->query("
			Select * From
				`envio_correos`
			Where
				`Status` = '0'
			Limit
				0,10
								  ");
		if($query->num_rows()>0){
			return
				$query->result_array();
		} else {
			return 
				false;
		}
	}
	
	function correoEnviadoUpdate($idCorreo){
		$data['status']		= "1";
		$data['fechaEnvio']	= date('Y-m-d H:i:s'); 
		$this->db->where('envio_correos.idCorreo', $idCorreo);
		$this->db->update('envio_correos', $data);
	}
	
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
}