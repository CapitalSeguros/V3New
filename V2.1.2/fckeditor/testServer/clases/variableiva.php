<?php
 class variableiva extends base {
	var $id;
 	var $iva;
	function variableiva($par=""){
		$this->basedatos($par);
	}
	/************************** Datos en Variables ****************************/
	function DatosEnvariables(){
		$this->id  			= $this->Datos[$this->Posicion]["id"];
		$this->iva  		= $this->Datos[$this->Posicion]["iva"];
	}
	function Cambio($CadenaSQL){
		$this->EjecutarInstruccion($CadenaSQL.";");
		$this->TotalResultados = $this->NumeroRegistros;
		return true;
	}		
	function Catalogo(){
		$CadenaSQL = " SELECT * FROM iva ";
		$CadenaSQL.= " ORDER BY iva DESC";
		$this->EjecutarConsulta($CadenaSQL.";");
		$this->TotalResultados = $this->NumeroRegistros;
		return true;
	}
}
?>