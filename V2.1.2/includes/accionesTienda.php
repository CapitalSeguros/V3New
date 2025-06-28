<?php
session_start();
extract($_REQUEST);
if(	$seccion != "index"){
	if(!isset($_SESSION['WebDreTacticaWeb2'])){ header("Location: index.php"); }
	if(!isset($_SESSION['WebDreTacticaWeb2']['Usuario'])){ header("Location: index.php"); }
}
include('../config/funcionesDre.php');
	$conexion = DreConectarDB();
		
// action categorias_Agregar
if($_REQUEST['action'] == "categorias_Agregar"){
	$sqlInsertCategorias = "
		Insert Into 
			`tienda_categorias`
		(
			`nombre`
			,`img_link`
			,`posicion`
		)
		Values
		(
			'".urlencode($nombre)."'
			,'no_imagen.png'
			,'$posicion'
		)
				       ";
	DreQueryDB($sqlInsertCategorias);
	$idCategoria = mysql_insert_id();
	$return = "../".$seccion."Editar.php?idCategoria=".$idCategoria;
	
	header("Location: $return");
}

// action categorias_Editar
if($_REQUEST['action'] == "categorias_Editar"){
	$sqlUpdateCategorias = "
		Update
			`tienda_categorias`
		Set
			`nombre` = '".urlencode($nombre)."'
			,`posicion` = '$posicion'
		Where 
			`idCategoria` = '$idCategoria'
						   ";
	DreQueryDB($sqlUpdateCategorias);
	$return = "../".$seccion."Modificar.php";
	
	header("Location: $return");	
}

// action categorias_Borrar
if($_REQUEST['action'] == "categorias_Borrar"){
	// Accion a efectuar en esta opcion		
		$sqlBorrar = "Delete From `tienda_categorias` Where `idCategoria` = '$idCategoria'";
		DreQueryDB($sqlBorrar);

	// pagina que cargamos cuando termina la acccion
		$return = "../".$seccion."Modificar.php";
	header("Location: $return");		
}

// action categorias_ImgPortada
if($_REQUEST['action'] == "categorias_ImgPortada"){
	if ($_FILES['fileImg']['error'] == UPLOAD_ERR_NO_FILE) { //validamos si hay un archivo seleccionado o no.
		echo "No Selecciono la Imagen a Guardar<br />Seleccione Una e Intente de Nuevo";
		echo "<FORM>";
		echo	"<INPUT TYPE='button' VALUE='Regresar'";
		echo	"onClick='history.go(-1)'>";
		echo "</FORM>";
	} else {
	//accion a efectuar en esta opcion
	$imagen = "../img/tienda_categorias/".$source;
	if (file_exists($imagen)) { unlink($imagen); } // Borramos el archivo si existe
	if(copy($_FILES['fileImg']['tmp_name'], $imagen)) {
		// Actualizamos
		$sqlImg = "
			Update
				`tienda_categorias`
			Set
				`img_link` = '$source'
			Where 
				`idCategoria` = '$idCategoria'
				  ";
		DreQueryDB($sqlImg);		
		
		// definimos la ruta de retorno
		$return = "../".$seccion."Modificar.php";
		
		header("Location: $return");
		
	} else {
		echo "Error al cargar el archivo<br />";
		echo "<FORM>";
		echo	"<INPUT TYPE='button' VALUE='Regresar'";
		echo	"onClick='history.go(-1)'>";
		echo "</FORM>";		
	} // fin del if copy file
	} // fin del if NO Existe el archivo	
}


// action articulos_Agregar
if($_REQUEST['action'] == "articulos_Agregar"){
	$sqlInsertArticulos = "
		Insert Into 
			`tienda_articulos`
		(
			`nombre`
			,`img_link`
			,`precio`
			,`controlaTallas`
			,`idCategoria`
			
		)
		Values
		(
			'".urlencode($nombre)."'
			,'no_imagen.png'
			,'$precio'
			,'$controlaTallas'
			,'$idCategoria'
		)
				       ";
	DreQueryDB($sqlInsertArticulos);
	$idArticulo = mysql_insert_id();
	$return = "../".$seccion."Editar.php?idArticulo=".$idArticulo;
	
	header("Location: $return");
}

// action articulos_Editar
if($_REQUEST['action'] == "articulos_Editar"){
	$sqlUpdateArticulos = "
		Update
			`tienda_articulos`
		Set
			`nombre` = '".urlencode($nombre)."'
			,`idCategoria` = '$idCategoria'
			,`precio` = '$precio'
			,`controlaTallas` = '$controlaTallas'
		Where 
			`idArticulo` = '$idArticulo'
						   ";
	DreQueryDB($sqlUpdateArticulos);
	$return = "../".$seccion."Modificar.php";
	
	header("Location: $return");	
}

// action articulos_Borrar
if($_REQUEST['action'] == "articulos_Borrar"){
	// Accion a efectuar en esta opcion		
		$sqlBorrar = "Delete From `tienda_articulos` Where `idArticulo` = '$idArticulo'";
		DreQueryDB($sqlBorrar);

	// pagina que cargamos cuando termina la acccion
		$return = "../".$seccion."Modificar.php";
	header("Location: $return");		
}


// action articulos_ImgPortada
if($_REQUEST['action'] == "articulos_ImgPortada"){
	if ($_FILES['fileImg']['error'] == UPLOAD_ERR_NO_FILE) { //validamos si hay un archivo seleccionado o no.
		echo "No Selecciono la Imagen a Guardar<br />Seleccione Una e Intente de Nuevo";
		echo "<FORM>";
		echo	"<INPUT TYPE='button' VALUE='Regresar'";
		echo	"onClick='history.go(-1)'>";
		echo "</FORM>";
	} else {
	//accion a efectuar en esta opcion
	$imagen = "../img/tienda_articulos/".$source;
	if (file_exists($imagen)) { unlink($imagen); } // Borramos el archivo si existe
	if(copy($_FILES['fileImg']['tmp_name'], $imagen)) {
		// Actualizamos
		$sqlImg = "
			Update
				`tienda_articulos`
			Set
				`img_link` = '$source'
			Where 
				`idArticulo` = '$idArticulo'
				  ";
		DreQueryDB($sqlImg);		
		
		// definimos la ruta de retorno
		$return = "../".$seccion."Modificar.php";
		
		header("Location: $return");
		
	} else {
		echo "Error al cargar el archivo<br />";
		echo "<FORM>";
		echo	"<INPUT TYPE='button' VALUE='Regresar'";
		echo	"onClick='history.go(-1)'>";
		echo "</FORM>";		
	} // fin del if copy file
	} // fin del if NO Existe el archivo	
}

// action articulos_Borrar
if($_REQUEST['action'] == "pedido_Borrar"){
	// Accion a efectuar en esta opcion		
		$sqlBorrar = "Delete From `tienda_pedidos` Where `idPedido` = '$idPedido'";
		DreQueryDB($sqlBorrar);

	// pagina que cargamos cuando termina la acccion
		$return = "../tiendaMisPedidos.php";
	//header("Location: $return");
	?>
    <script>
		alert('Pedido Cancelado !!!');
		window.open('<? echo $return; ?>', '_self');
	</script>
    <?
}

DreDesconectarDB($conexion);
?>