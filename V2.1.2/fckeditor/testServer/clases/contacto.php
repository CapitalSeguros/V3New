<?php
 class contacto extends basedatos {
	var $id;
	var $para;
	var $cc;
	var $cco;	
	var $comentario;
	var $area;

	function contacto(){
		$this->basedatos();
	}
	/************************** Datos en Variables ****************************/
	function DatosEnvariables(){
		$this->id   = $this->Datos[$this->Posicion]["id"];
		$this->para = $this->Datos[$this->Posicion]["para"];
		$this->cc   = $this->Datos[$this->Posicion]["cc"];
		$this->cco  = $this->Datos[$this->Posicion]["cco"];
		$this->comentario = $this->Datos[$this->Posicion]["comentario"];
		$this->area       = $this->Datos[$this->Posicion]["area"];		
	}
	function Nuevo($Datos) {
		$Campos = array_keys($Datos);
		$CadenaSQL = " INSERT INTO contactos (";
		$CadenaVal = " VALUES( ";
		for($i=0; $i<count($Campos); $i++){
				$Campos[$i] = str_replace($order, $replace, $Campos[$i]);				
				$CadenaSQL.= $Campos[$i].",";
			$CadenaVal.= "'".trim($Datos[$Campos[$i]])."',";
		}
		$CadenaSQL = substr($CadenaSQL,0,strlen($CadenaSQL)-1).") ".substr($CadenaVal,0,strlen($CadenaVal)-1).")";
		if($this->EjecutarInstruccion($CadenaSQL.";"))
			echo '<p class="estilo_transac">Datos registrados exitosamente</p>';
		echo $CadenaSQL;
		return true;
	}
	function Cambio($Id,$Datos){
		$Campos = array_keys($Datos);
		$CadenaSQL = " UPDATE contactos SET ";	
		for($i=0; $i<count($Campos); $i++){		
			$CadenaSQL.= $Campos[$i]."='".trim($Datos[$Campos[$i]])."',";
		}
		$CadenaSQL = substr($CadenaSQL,0,strlen($CadenaSQL)-1)." ";	
		$CadenaSQL.= " WHERE id=".$Id;	
		if($this->EjecutarInstruccion($CadenaSQL.";"))
			echo '<p class="estilo_transac">Datos modificados exitosamente</p>';
		return true;
	}
	function CambioComentario($Datos){
		$Campos = array_keys($Datos);
		$CadenaSQL = " UPDATE contactos SET ";	
		for($i=0; $i<count($Campos); $i++){		
			$CadenaSQL.= $Campos[$i]."='".trim($Datos[$Campos[$i]])."',";
		}
		$CadenaSQL = substr($CadenaSQL,0,strlen($CadenaSQL)-1)." ";	
		if($this->EjecutarInstruccion($CadenaSQL.";"))
			echo '<p class="estilo_transac">Datos modificados exitosamente</p>';
		return true;
	}

	function Baja($Idcontacto){
		$this->Catalogo($Idcontacto);
		$CadenaSQL = " DELETE FROM contactos WHERE id=".$Idcontacto;
		$this->EjecutarInstruccion($CadenaSQL.";");
		return true;
	}	
	function Catalogo(){	
		$CadenaSQL = " SELECT * FROM contactos";
		$this->EjecutarConsulta($CadenaSQL.";");
		$this->TotalResultados = $this->NumeroRegistros;
		return true;
	}
	function BuscaxArea($Area){	
		$CadenaSQL = " SELECT * FROM contactos where area='".$Area."'";
		$this->EjecutarConsulta($CadenaSQL.";");
		$this->TotalResultados = $this->NumeroRegistros;
		return true;
	}
}
?>