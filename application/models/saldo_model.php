<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class saldo_model extends CI_Model {
	
	public function __Construct(){
		parent::__Construct();
	}
	
	function saldo($idUser){
		$saldo = '9.0000';
		
		$sql  = "
			Select 
				`saldo` 
			From
				`envio_saldo`
			Where
				`idUser` = '".$idUser."'
				";
		if(isset($this->db->query($sql)->row()->saldo)){
			$saldo = $this->db->query($sql)->row()->saldo;
		}
		
		return
			$saldo;
	}
	
	function cargarSaldo($idUser, $saldo)
	{
		$saldoFormat = number_format($saldo, 4);
		$sqlConsulta = "
			Select Count(*) As `Existe` From
				`envio_saldo`
			Where
				`idUser` = '".$idUser."'
					   ";
		//var_dump();			

		if($this->db->query($sqlConsulta)->row()->Existe == "1"){
			$sql = "
				Update
					`envio_saldo`
				Set
					`saldo` = `saldo`+'".$saldoFormat."'
				Where
					`idUser` = '".$idUser."'
				;
				   ";
		} else {
			$sql = "
				Insert Into
					`envio_saldo`
				(`idUser`,`saldo`)
				Values
					('".$idUser."','".$saldoFormat."');
				   ";
		}
		
		$this->db->query($sql);
		
	}
}