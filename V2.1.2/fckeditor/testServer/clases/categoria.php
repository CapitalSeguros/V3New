<?php
 class categoria extends basedatos {
	var $id;
 	var $categoria;
 	var $orden;
	var $imagen;

	function categoria(){
		$this->basedatos();
	}
	function DatosEnvariables(){
		$this->id  			= $this->Datos[$this->Posicion]["id"];
		$this->categoria	= $this->Datos[$this->Posicion]["categoria"];
		$this->orden    	= $this->Datos[$this->Posicion]["orden"];
		$this->imagen   	= $this->Datos[$this->Posicion]["imagen"];
	}
	function Nuevo($Datos) {
		$Campos = array_keys($Datos);
		$CadenaSQL = " INSERT INTO categorias (";
		$CadenaVal = " VALUES( ";
		for($i=0; $i<count($Campos); $i++){
			$CadenaSQL.= $Campos[$i].",";
			if(strcmp(trim($Campos[$i]),"orden")==0)
				$CadenaVal.= "".trim($Datos[$Campos[$i]]).",";
			else
				$CadenaVal.= "'".trim($Datos[$Campos[$i]])."',";
		}
		$CadenaSQL = substr($CadenaSQL,0,strlen($CadenaSQL)-1).") ".substr($CadenaVal,0,strlen($CadenaVal)-1).")";
		if($this->EjecutarInstruccion($CadenaSQL.";"))
			echo '<p class="estilo_transac">Datos registrados exitosamente</p>';
		return true;
	}
	function Baja($Idcategoria){
		$this->Catalogo($Idcategoria);
		unlink("../imgprod/".trim($this->imagen));	
		$CadenaSQL = " DELETE FROM categorias WHERE id=".$Idcategoria;
		$this->EjecutarInstruccion($CadenaSQL.";");
		return true;
	}
	function Cambio($Id,$Datos){
		$Campos = array_keys($Datos);
		$CadenaSQL = " UPDATE categorias SET ";	
		for($i=0; $i<count($Campos); $i++){
			if(strcmp(trim($Campos[$i]),"orden")==0)
				$CadenaSQL.= $Campos[$i]."=".$Datos[$Campos[$i]].",";
			else
				$CadenaSQL.= $Campos[$i]."='".$Datos[$Campos[$i]]."',";
		}
		$CadenaSQL = substr($CadenaSQL,0,strlen($CadenaSQL)-1)." ";		
		$CadenaSQL.= " WHERE id=".$Id;		
		if($this->EjecutarInstruccion($CadenaSQL.";"))
			echo '<p class="estilo_transac">Datos modificados exitosamente</p>';
		return true;
	}
	function Catalogo($Idcategoria=NULL){	
		$CadenaSQL = " SELECT * FROM categorias";
		if(isset($Idcategoria)){
			$CadenaSQL.= " WHERE id=".$Idcategoria;
		}
		$CadenaSQL.= " ORDER BY orden";
		$this->EjecutarConsulta($CadenaSQL.";");
		$this->TotalResultados = $this->NumeroRegistros;
		return true;
	}
	function CatalogoProd(){	
		//$CadenaSQL = " SELECT * FROM categorias where permiso=-1 ";
		$CadenaSQL = " SELECT categorias.* FROM categorias,productos WHERE categorias.id=productos.idcategoria GROUP BY idcategoria";
		$CadenaSQL.= " ORDER BY categorias.orden ";
		$this->EjecutarConsulta($CadenaSQL.";");
		$this->TotalResultados = $this->NumeroRegistros;
		return true;
	}	
	function CatalogoPag($Idcategoria=NULL,$ParOffset=0, $ParTamanioPagina=100){	
		//$CadenaSQL = " SELECT * FROM categorias where permiso=-1 ";
		$CadenaSQL = " SELECT * FROM categorias";
		if(isset($Idcategoria)){
			$CadenaSQL.= " WHERE id=".$Idcategoria;
		}
		$CadenaSQL.= " ORDER BY orden LIMIT ".$ParOffset.",".$ParTamanioPagina;
		$this->EjecutarConsulta($CadenaSQL.";");
		
		$this->TotalResultados = $this->NumeroRegistros;
		return true;
	}
 	/**************************Actualizar ****************************/
	function SubeArchivoImagen($Id,$Archivo,$Anchura,$Hmax){	
		$error = false;
		$userfile = $Archivo['tmp_name'];
		$userfile_name = $Archivo['name']; 
		$userfile_type = $Archivo['type'];
		$userfile_size = $Archivo['size']; 
		$userfile_error = $Archivo['error'];
		$ext = explode(".",$userfile_name);
		if ($userfile_error > 0){
			$error = true;
			switch ($userfile_error){
				case 1: echo "<script language=\"javascript\"> alert(\"El archivo excedió el tamaño máximo de carga\")</script>"; break;
				case 2: echo "<script language=\"javascript\"> alert(\"El archivo excedió el tamaño máximo del archivo\")</script>"; break;
				case 3: echo "<script language=\"javascript\"> alert(\"El archivo solo se cargó parcialmente\")</script>"; break;
				case 4: echo "<script language=\"javascript\"> alert(\"No se cargó el archivo:"+$userfile_name+" \")</script>"; break;
			}
		}		
		//$ruta = substr(getcwd(),0,strlen(getcwd())-9)."\\logos\\";
		$ruta = "../imgprod/";
		if(!$error){
			$code     = getdate();
			$doc_name = "imagen".$code["year"].$code["mon"].$code["mday"].$code["hours"].$code["minutes"].$code["seconds"].".".$ext[1];
			$upfile   = $ruta.$doc_name;
			//echo $upfile;
			if(is_uploaded_file($userfile)){
				if(!move_uploaded_file($userfile,$upfile)){
					echo "<script language=\"javascript\"> alert(\"Problema: No se pudo mover el archivo al directorio destino $userfile $upfile \")</script>"; 
					$error = true;
				} else {
					//Redimenciona la imagen
					/*$nombre=basename($upfile);
					$datos = getimagesize($upfile);
					if($datos[2]==1){$img = imagecreatefromgif($upfile);} 
					if($datos[2]==2){$img = imagecreatefromjpeg($upfile);} 
					if($datos[2]==3){$img = imagecreatefrompng($upfile);} 
					$ratio = ($datos[0] / $Anchura); 
					$altura = ($datos[1] / $ratio); 
					if($altura>$Hmax){$anchura2=$Hmax*$Anchura/$altura;$altura=$Hmax;$Anchura=$anchura2;}
					$thumb = imagecreatetruecolor($Anchura,$altura); 
					imagecopyresampled($thumb, $img, 0, 0, 0, 0, $Anchura, $altura, $datos[0], $datos[1]); 
					if($datos[2]==1){imagegif($thumb,$upfile);}
					if($datos[2]==2){imagejpeg($thumb, $upfile, 75);}
					if($datos[2]==3){imagepng($thumb, $upfile); }
					imagedestroy($thumb);
					*/
					/*----Redimenciona la imagen-----*/
				}
			}
			else{
				echo "<script language=\"javascript\"> alert(\"Problema: Posible agresión al archivo. Nombre del archivo ".$userfile_name."\")</script>"; 
				$error = true;
			}
			$tamanio = filesize($upfile);
		}
		$CadenaSQL = "update categorias set imagen='".$doc_name."' where id=".$Id;
		$this->EjecutarInstruccion($CadenaSQL.";");
		return array($tamanio,$doc_name, $error);
	}	
	function IndicePaginas($ParTotalResultados, $ParOffset=0, $ParTamanioPagina=25, $Parametros=""){
		$NumeroPaginas = ceil($ParTotalResultados/$ParTamanioPagina);
		echo '<table  width="150" height="22" border="0" cellpadding="0" cellspacing="0">';
		echo '<tr>';

		echo '<td width="29">';
		if($ParOffset>0)
			echo '<a href="#" onclick="javascript:setOffset('.($ParOffset-$ParTamanioPagina).')"><img src="images/flecha_izq.jpg" width="9" height="22" border="0" /></a>';
		//else 
			//echo '<img src="images/flecha_izq.jpg" width="9" height="22" border="0" /></a>';
		echo "</td>";
			
		echo '<td width="103" bgcolor="#6C6C6C">&nbsp;';
		for($i=0; $i < $NumeroPaginas; $i++){
			if($i*$ParTamanioPagina == $ParOffset)
				echo("<strong><span class=\"EstiloPaginaM\"> ".($i+1)."</span>&nbsp;");
			else
				echo("<span class=\"EstiloPagina\"><a href=\"#\" onclick=\"javascript:setOffset(". $i*$ParTamanioPagina.$Parametros.")\"><strong><span > " . ($i+1) . "</span></strong></a>&nbsp;");
		}
		echo '</td>';
		echo '<td width="25" align="right">';
		//if(($NumeroPaginas+1)*$ParTamanioPagina>$ParOffset)
		if ($ParTotalResultados>($ParOffset+$ParTamanioPagina))
			echo '<a href="#" onclick="javascript:setOffset('.($ParOffset+$ParTamanioPagina).')"><img src="images/flecha_der.jpg" width="9" height="22" border="0" /></a>';
		//else
			//echo '<img src="images/flecha_der.jpg" width="9" height="22" border="0" />';
		echo "</td>";
					
		echo '</tr>';
		echo '</table>';
	}
}
?>