<DOCTYPE html>
<html>
    <head>
        <title></title>
        <style>
            .titulos,h3{
                font-family:Helvetica;
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
            .barra{
                width: 100%;
                height: 15px;
                //border: 1px blue solid;
                background-color:#0464A0;
            }
        </style>
    </head>
    <body style='background-color: #F6FBFE'>
        <div class='barra'></div>
        <table width='75%' align='center'>
            <tr>
              <td align='center' colspan='2'>
                <img src='https://www.capitalseguros.com.mx/assets/img/logocapitalseguros.png' width='200' height='100'><br>
              </td>
            </tr>
            <tr align='center'><td colspan='2'><h3>Estimado <?=$datos["nombreC"]?> la solicitud al evento: <?=$datos["nombreEvento"]?> ha sido:</h3></td></tr>
            <tr align='center'><td colspan='2'><h3><?=$datos["estado"]?></h3></td></tr>
        </table>
        <?php 
            if($datos["estado"]=="ACEPTADO"){ ?>
            <hr style="width: 75%">
            <table width='75%' align='center'>
			<tr>
				<td id='pregunta' colspan='2'>
					<h3>Para generar el evento por favor haga clic al enlace de abajo.</h3>
				</td>
			</tr>
			<tr>
				<td class='titulosA'><a href='<?=base_url()."accesoAEvento/habilitaEvento?q=".$datos["idEvento"]."&r=".$datos["idInvitado"]?>'>IR AL EVENTO</a></td>
			</tr>
		</table>
        <?php } else{ ?>
            <hr style="width: 75%">
            <br>
            <h3 style="text-align: center; color: black">Lo sentimos. El organizador ha negado su permiso al evento solicitado.</h3>
            <br>
        <?php }       
        ?>
    </body>
    </html>