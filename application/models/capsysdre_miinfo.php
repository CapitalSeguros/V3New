<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Capsysdre_miinfo extends CI_Model {
	
	function __construct(){
		parent::__construct();
	}/*! */
		
	/* Ver Detalle Contacto SICAS
	*	@Param
	*	@Return Array
	*/
	function DetalleContacto($IDCont){
		$wsKeycode = "HDATACONTACT";
		$wsTipo = "Read_Data";
		$wsTextoPlano = "
						<InfoData>
							<CatContactos>
								<IDCont>".$IDCont."</IDCont>
							</CatContactos>
						</InfoData>";
		$wsNodoExtrae = "CatContactos";
		
		return
			$this->ws_sicasdre->wsdata($wsKeycode, $wsTipo, $wsTextoPlano, $wsNodoExtrae);
	}/*! DetalleContacto */
	

	function ActualizarContacto($datos){

		if(is_array($datos)){
			$data = array(
	            'datos'=> $datos,
	            'KeyCode' => 'HDATACONTACT',
	            'TipoEntidad' => '0',
	            'IDRelation' => '0');

	    	$res = $this->webservice_sicas_soap->UpdateContacto($data);	
		}
	}
}