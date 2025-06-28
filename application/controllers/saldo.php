<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Saldo extends CI_Controller{
		
	function __construct(){
		parent::__construct();
	}

	function index(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
		}
	}/*! index */

	function cargar($idPedido, $idProducto, $redirec){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			
			$sqlPedido = "
				Select * From
					`tienda_pedidos`
				Where
					`idPedido` = '".$idPedido."'
						 ";
			$idUser = $this->db->query($sqlPedido)->row()->idUsuario;

			$sqlSaldo = "
				Select
					(`cantidad` * `precio`) As `saldo`
				From
					`tienda_pedidos_productos`
				Where
					`idPedido` = '".$idPedido."'
					And
					`idProducto` = '".$idProducto."'
						";
			$saldo = $this->db->query($sqlSaldo)->row()->saldo;			
			
			$this->saldo_model->cargarSaldo($idUser, $saldo);
			
			$sqlUpdateCargado = "
							Update
								`tienda_pedidos_productos`
							Set
								`cargado` = 'Si'
							Where
								`idPedido` = '".$idPedido."'
								And
								`idProducto` = '".$idProducto."'
								";
			$this->db->query($sqlUpdateCargado);
			
			switch($redirec){
				case "tienda":
					$return = "tienda/pedidodetalle/".$idPedido;
				break;
			}
			
			redirect($return);
		}
	}/*! index */

}
/* End of file saldo.php */
/* Location: ./application/controllers/saldo.php */