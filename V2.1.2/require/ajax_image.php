<?php
include('../config/funcionesDre.php');
$conex = DreConectarDB();
$t_width = 100;	// Maximum thumbnail width
$t_height = 100;	// Maximum thumbnail height
$path = "../img/usuarios/";

if(isset($_GET['t']) and $_GET['t'] == "ajax")
	{
		extract($_GET);
		$ratio = ($t_width/$w); 
		$nw = ceil($w * $ratio);
		$nh = ceil($h * $ratio);
		$nimg = imagecreatetruecolor($nw,$nh);
		$im_src = imagecreatefromjpeg($path.$img);
		imagecopyresampled($nimg,$im_src,0,0,$x1,$y1,$nw,$nh,$w,$h);
		imagejpeg($nimg,$path."small_".$Usuario.".jpg",100);
		// Reemplazamos Foto
			$sqlConsultaImagen  = "
				Select `IMAGEN` From 
					`info_usuarios_vendedores` 
				Where  
					`VALOR` = '".$Usuario."'
								  ";
			$resConsultaImagen = DreQueryDB($sqlConsultaImagen);
			$rowConsultaImagen = mysql_fetch_assoc($resConsultaImagen);
			
			
			$imagen = "../img/usuarios/".$rowConsultaImagen['IMAGEN'];
			
			//--> if(file_exists($imagen)) { unlink($imagen); } // Borramos el archivo si existe
				//--> $imagenNew = $path."small_".$Usuario.".jpg";
				
			if(file_exists("../img/usuarios/"."small_".$Usuario.".jpg")){
				// Actualizamos
					$sqlImg = "
						Update
							`info_usuarios_vendedores`
						Set
							`IMAGEN` = '"."small_".$Usuario.".jpg"."'
						Where 
							`VALOR` = '".$Usuario."'
							  ";
					DreQueryDB($sqlImg);
			}

//		echo "small_".$Usuario.".png"."?".time();
		DreDesconectarDB($conex);
		exit;
	}
?>
	