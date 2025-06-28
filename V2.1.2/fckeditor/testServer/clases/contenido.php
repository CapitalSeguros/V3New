<?php
 class contenido extends basedatos {
	var $nosotros;

	function contenido(){
		$this->basedatos();
	}
	/************************** Datos en Variables ****************************/
	function DatosEnvariables(){
		$this->nosotros = $this->Datos[$this->Posicion]["nosotros"];
	}
	function Borrar(){
		$Campos = array_keys($Datos);
		$CadenaSQL = " UPDATE contenido SET nosotros='' ";	
		if($this->EjecutarInstruccion($CadenaSQL.";"))
			echo '<p class="estilo_transac">Datos modificados exitosamente</p>';
		return true;
	}	
	function Nuevo($Datos) {
		$order = array("\r\n", "\n", "\r");
		$replace = ' ';	
		$Campos = array_keys($Datos);
		$CadenaSQL = " INSERT INTO contenido (";
		$CadenaVal = " VALUES( ";
		for($i=0; $i<count($Campos); $i++){
			//if (strcmp($Campos[$i],"nosotros")==0){				
				$Campos[$i] = str_replace($order, $replace, $Campos[$i]);				
			//}
				$CadenaSQL.= $Campos[$i].",";
			$CadenaVal.= "'".trim($Datos[$Campos[$i]])."',";
		}
		$CadenaSQL = substr($CadenaSQL,0,strlen($CadenaSQL)-1).") ".substr($CadenaVal,0,strlen($CadenaVal)-1).")";
		echo "CadenaSQL: ".$CadenaSQL;
		if($this->EjecutarInstruccion($CadenaSQL.";"))
			echo '<p class="estilo_transac">Datos registrados exitosamente</p>';
		return true;
	}
	function Cambio($Datos){
		$Campos = array_keys($Datos);
		$CadenaSQL = " UPDATE contenido SET ";	
		for($i=0; $i<count($Campos); $i++){		
				$CadenaSQL.= $Campos[$i]."='".trim($Datos[$Campos[$i]])."',";
		}
		$CadenaSQL = substr($CadenaSQL,0,strlen($CadenaSQL)-1)." ";		
		if($this->EjecutarInstruccion($CadenaSQL.";"))
			echo '<p class="estilo_transac">Datos modificados exitosamente</p>';
		return true;
	}
	function Catalogo(){	
		$CadenaSQL = " SELECT nosotros FROM contenido";
		$this->EjecutarConsulta($CadenaSQL.";");
		$this->TotalResultados = $this->NumeroRegistros;
		return true;
	}
}
?>