<?php
include('../config/funcionesDre.php');
$conexion = DreConectarDB();
extract($_REQUEST);

// Carga de Disponibilidad CSV
//-->if(@$_GET['action']=='disponibilidadCsv'){


	//-->$return = "../disponibilidad_csv.php";
	//-->$fileCsv = "../../filesCsv/disponibilidad/".date('d-m-Y_h-i').$extension;
	$nameFile = "catRsa.csv";
	$fileCsv = "../../syncronizacion/".$nameFile;
	$arrayStrinQuitar = array( 	
								"\'"
								,"\n"
								,"\r"
								,"\n\r"
								,"\r\n"
								,chr(10)
								,chr(11)
								,chr(12)
								,chr(13)
								,chr(10).chr(13)
								,chr(13).chr(10)
								,"/"
								,"\""
							  );
	$arrayStrinPoner = array(
								"'"
								,""
								,""
								,""
								,""
								,""
								,""
								,""
								,""
								,""
								,""
								,"-"
								,""
							  );

//-->	if (file_exists($fileCsv)) { unlink($fileCsv); } // Borramos el archivo si existe
//-->	if(copy($_FILES['filecsv']['tmp_name'], $fileCsv)) {
		// abrimos el archivoy guardamos en la tabla
			if(file_exists($fileCsv) && filesize($fileCsv)!=0){//If Validacion Existe Archivo  y Tiene Informacion
				//-->echo "si Existe el Archivo";

				$filas = file($fileCsv); 
				$i = 0; // contador de filas en el archivo
				$totalFilas = count($filas);  // Total de filas de registros en el archivo				
				while($i < $totalFilas){	// Siclo While Insert Into Tabla
					$newFila = explode(',',str_replace($arrayStrinQuitar, $arrayStrinPoner,$filas[$i++]));

					$sql =	"
						Insert Into
							`ws_catalogo_amis_rsa` 
								(
									`SA`
									,`CLAVE`
									,`MARCA`
									,`TIPO`
									,`DESCRIPCION`
									,`MODELO`
									,`BUCKET`
									,`LO_JACK`
									,`ZONA_LO_JACK`
								) 
							Values
							";
					$sql .=	"('".$newFila[0]."'";
					$sql .=	",'".$newFila[1]."'";
					$sql .=	",'".$newFila[2]."'";
					$sql .=	",'".$newFila[3]."'";
					$sql .=	",'".$newFila[4]."'";
					$sql .=	",'".$newFila[5]."'";
					$sql .=	",'".$newFila[6]."'";
					$sql .=	",'".$newFila[7]."'";
					$sql .=	",'".$newFila[8]."')";

	echo "<pre>";
		echo $i;
		echo "-";
		echo $sql;
	echo "</pre>";
					
					DreQueryDB($sql); // Ejecutamos el Query

				} // fin del While
			} // fin del If Existe archivo y pesa mas que cero
		?>
        <script>
			//-->alert('Carga de Archivo Exitosa !!!');
			//-->window.open('<?php //echo $return; ?>','_self');
		</script>
        <?php
//-->	} else {
		?>
        <script>
			//-->alert('Error al Cargar el Archivo !!!');
			//-->window.open('<?php //echo $return; ?>','_self');
		</script>
        <?php
//-->	} // fin del if copy file
//*->}

?>