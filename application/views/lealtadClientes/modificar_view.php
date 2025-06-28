<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
<title>MODIFICAR PUNTOS</title>	
<body>
<h2>MODIFICA PUNTOS </h2>
 <form action="<?php echo(base_url()) ?>" method="POST">	
 	<?php foreach ($mod as $fila){ ?>
<input type="text" name="tipo" value="<?=$fila->TIPO?>"/>
<input type="text" name="punto" value="<?=$fila->PUNTO?>"/>
<input type="submit" name="submit" value="Modificar"/>
<?php } ?>
 </form>
</body>
</head>