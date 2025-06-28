<link rel="stylesheet" type="text/css" href="../webcam/css/estilos.css" />

<script type="text/javascript" src="../webcam/js/webcam.js"></script>
<script type="text/javascript" src="../webcam/js/funciones.js"></script>
    <script language="JavaScript">
		webcam.set_api_url( '../webcam/test.php' );//PHP adonde va a recibir la imagen y la va a guardar en el servidor
		webcam.set_quality( 90 ); // calidad de la imagen
		webcam.set_shutter_sound( true ); // Sonido de flash
		webcam.set_hook( 'onComplete', 'my_completion_handler' );
	</script>

<div align="left" id="cuadro_camara">    
<table width="100%" height="144"><tr><td width="100" valign=top>
		<form>
		<input type=button value="Configurar" onClick="webcam.configure()" class="botones_cam">
		&nbsp;&nbsp;
		<input type=button value="Tomar foto" onClick="webcam.freeze();mostrarboton();" class="botones_cam">
		&nbsp;&nbsp;
		<input type=button value="subir" onClick="do_upload();ocultarboton();" class="botones_cam" id="btnsubir" style="display:none;">
		&nbsp;&nbsp;
		<input type=button value="Reset" onClick="webcam.reset();ocultarboton();" class="botones_cam">
	</form>
	</td>
    <td width="263" valign=top>
	<script language="JavaScript">
	document.write( webcam.get_html(320, 240) );//dimensiones de la camara
	</script>
    </td>
    <td width="411">
	    <div id="upload_results" class="formulario" > </div>
  </td></tr></table>
</div>

    <div id="gallery">
    <ul>
  <?php  
  //Visto en : www.entrecodigos.net
  include("conexion.php");
  //Hacemos una consulta para mostrar las imagenes
  $consulta="select * from fotos order by id_foto desc";
  $busca_fotos=mysql_query($consulta,$conectar);
  while($row=mysql_fetch_array($busca_fotos)){
   $url=$row['id_foto'];  
   $nombre=$row['nombre']; 
   $des=$row['des'];
   //mostramos las imagenes
   echo "<li>
            <a href=\"fotos/".$url.".jpg\" title=\"$nombre - $des\" target=\"_blank\">
                <img src=\"fotos/".$url.".jpg\" width=\"150\" height=\"120\" alt=\"\" />
            </a>
        </li>";
  }
?>    
    </ul>