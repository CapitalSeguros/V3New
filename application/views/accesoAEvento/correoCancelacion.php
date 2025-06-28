<DOCTYPE html>
	<html>
	<head>
		<title></title>
		<style>
			.titulos,h3{
				font-family:Helvetica;
			}
			.titulos{
				font-size: 15px;
				align-content: center;
			}
			#pregunta{
				text-align:center;
			}
			.titulosA{
				font-family:helvetica;
				text-align:center;
			}
			a{
				text-decoration: none;
    			padding: 10;
    			font-weight: 300;
				font-size: 15px;
				color: black;
    			border-radius: 6px;
    			border: 1px solid #B9E2FB;
			}
		</style>
	</head>
	<body style='background-color: #F6FBFE'>
	<table width='75%' align='center'>
		<tr>
			<td align='center' colspan='2'>
				<img src='https://www.capitalseguros.com.mx/assets/img/logocapitalseguros.png' width='200' height='100'><br>
			</td>
		</tr>
		    <tr align='center'><td colspan='2'><h3>Cancelación de evento.</h3><br></td></tr>
            <tr align='center'><td colspan='2'><p style="font-family: helvetica">Estimado(a) <?=$datos["nombre"]?></p></td></tr>
            <tr align='center'><td colspan='2'><p style="font-family: helvetica">se le informa que el organizador del evento ha cancelado la reunion siguente:</p><hr></td></tr>
		<tr>
            <td class='titulos'><b>Tema:</b></td>
			<td class='titulos'><?=$datos["titulo"]?></td>
		</tr>
		<tr>
        <td class='titulos'><b>Descripcion:</b></td>
			<td class='titulos'><?=$datos["descripcion"]?></td>
		</tr>
		<tr>
            <td class='titulos'><b>Fecha:</b></td>
			<td class='titulos'><?=$datos["fecha_inicio"]?> Hrs a <?=$datos["fecha_final"]?>Hrs</td>
		</tr>
		<tr>
            <td class='titulos'><b>Lugar:</b></td>
			<td class='titulos'><?=$datos["lugar"]?></td>
			</tr>
	</table>
	<hr width='75%'>
	</body>
</html>