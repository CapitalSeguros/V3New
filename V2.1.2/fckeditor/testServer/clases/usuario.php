<?php
 class usuario extends basedatos {
	var $id;
 	var $nombre;
	var $user;
	var $pw;

	function usuario(){
		$this->basedatos();
	}
	/************************** Datos en Variables ****************************/
	function DatosEnvariables(){
		$this->id  			= $this->Datos[$this->Posicion]["id"];
		$this->nombre		= $this->Datos[$this->Posicion]["nombre"];
		$this->user 		= $this->Datos[$this->Posicion]["user"];		
		$this->pw     	 	= $this->Datos[$this->Posicion]["pw"];
	}
	function Acceso($Usuario, $Clave){
			$CadenaSQL = "SELECT * FROM usuarios";
			$this->EjecutarConsulta($CadenaSQL.";");
			$this->TotalResultados = $this->NumeroRegistros;			
			for($i=0; $i<$this->NumeroRegistros; $i++) {
				if (strcmp(trim($this->user),trim($Usuario))==0 && strcmp(trim($this->pw),trim($Clave))==0) {
					return true;
				}
				$this->Siguiente();
			}					
			return FALSE;
	}
	function Nuevo($Nombre,$ApePat,$ApeMat,$Direccion,$Tel,$Empresa,$User,$Pw,$Vehiculos,$Maquinaria,$Computo,$Motos){
		$CadenaSQL = " INSERT INTO usuarios (nombre,apepat,apemat,direccion,telefono,empresa,user,pw,vehiculos,maquinaria,computo,motos,permiso)";
		$CadenaSQL.= " VALUES('".trim($Nombre)."','".trim($ApePat)."','".trim($ApeMat)."','".trim($Direccion)."','".trim($Tel)."','".trim($Empresa)."','".trim($User)."','".trim($Pw)."',".$Vehiculos.",".$Maquinaria.",".$Computo.",".$Motos.",-1)";
		$this->EjecutarInstruccion($CadenaSQL.";");
		return true;
	}
	function Baja($IdUsuario){
		$CadenaSQL = " DELETE FROM usuarios WHERE id=".$IdUsuario;
		$this->EjecutarInstruccion($CadenaSQL.";");
		return true;
	}
	function Cambio($CadenaSQL){
		$this->EjecutarInstruccion($CadenaSQL.";");
		$this->TotalResultados = $this->NumeroRegistros;
		return true;
	}		
	function Catalogo($IdUsuario=NULL){	
		//$CadenaSQL = " SELECT * FROM usuarios where permiso=-1 ";
		$CadenaSQL = " SELECT * FROM usuarios";
		if(isset($IdUsuario)){
			$CadenaSQL.= " WHERE id=".$IdUsuario;
		}
		$CadenaSQL.= " ORDER BY nombre ";
		$this->EjecutarConsulta($CadenaSQL.";");
		$this->TotalResultados = $this->NumeroRegistros;
		return true;
	}
}
?>