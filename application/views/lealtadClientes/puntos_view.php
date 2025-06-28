<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
<title>PUNTOS DE CLIENTES</title>	
</head>
<body>
<h2>Puntos Para Clientes</h2>
<table border = 1>
 <tr>
 <form action="<?=base_url("puntos_controller/add");?>" method = "post">
<td></td> 	
<td> <input  type="text" name = "tipo" /> </td>
<td> <input  type="text" name = "punto" /> </td>
<td> <input  type="submit" name = "submit" value="Agregar"  </td>	
</tr>
 <tr>
 <td>ID </td>	
    	  <td>NOMBRE </td>
    	   <td>CANTIDAD</td>	
    	</tr>
 <?php
 foreach($ver as $fila){
 ?>     	 
    <tr>
     <td><?=$fila->IDPUNTO; ?> </td>
   	 <td><?=$fila->TIPO; ?> </td>
  	 <td><?=$fila->PUNTO;?> </td>
  	 <td>  	
  	 <a href="<?=base_url('puntos_controller/mod/'.$fila->IDPUNTO);?>">Modificar</a>
  	 <a href="<?=base_url('puntos_controller/eliminar/'.$fila->IDPUNTO);?>"> &nbsp; &nbsp;Eliminar</a>
  	  </td> 
   </tr>
<?php
 }  
?>
</table>
</body>
</html>