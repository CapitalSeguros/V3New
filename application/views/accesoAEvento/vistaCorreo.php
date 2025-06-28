<DOCTYPE html>
    <html>
        <head></head>
        <style>
            body {
                font-family:arial;
                font-size: 12px;
            }
            .titulos{
                color: #616A6B;
            }
            td {
                padding: 5px;
                text-align: left;
                width: 30%;
            }
            table {
                border-width: 1px;
                padding: 5%; border-color: #b2b2b2;
                border-radius: 10px;
                border-style:solid;
                background-color: #fff;
            }
            a{
                text-decoration: none;
                padding: 15px 15px 15px 15px;
                color: white;
                background-color: #21618C;
                border-radius: 2px;
            }
        </style>
        <body>
            <?php ?>
         <table width="75%" align="center">
             <tr>
                 <td colspan="2" class="titulos"><img src="https://www.capsys.com.mx/V3/assets/img/logo/logocapital.png" width="30%" style="margin-top: -8%;"></td>
            </tr>
             <tr>
                 <td colspan="2" class="titulos"><b>Saludos Cordiales</b><br><p><?=$subTitulo?></p></td></tr>
             <tr>
                 <td colspan="2">&nbsp;</td>
            </tr>
             <tr>
                <td class="titulos"><b>Titulo:</b></td><td><?=$titulo?></td>
            </tr>
            <tr>
                <td class="titulos"><b>Fecha/Hora Inicio:</b></td>
                <td><?=$fHInicio?></td>
            </tr>
            <tr>
                <td class="titulos"><b>Fecha/Hora Final:</b></td>
                <td><?=$fHFinal?></td>
            </tr>
            <tr>
                <td class="titulos"><b>Clasificacion:</b></td>
                <td><?=$clasificacion?></td>
            </tr> 
            <tr>
                <td class="titulos"><b>Sub Categoria Capacitación:</b></td>
                <td><?=$capacitacion?></td>
            </tr>
            <tr>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan="2" style="border-top: 1px black solid"></td>
            </tr>
            <?php if($estadoEvento == "nuevo"){?>
                <tr>
                    <td class="titulos"><b>Para más información favor de ingresar a la siguiente liga.</b></td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center;">
                        <a href="<?=base_url()."accesoAEvento/evento/".$evento."/".$invitado."/".$tipo.""?>">Acceso al evento</a>
                    </td>
                </tr>
            <?php } elseif($estadoEvento == "cancelado"){?>
                <tr>
					<td class="titulos" colspan="2"><h4 style="color: red"><b>El evento ha sido cancelado por el organizador del evento</b></h4></td>
				</tr>
            <?php } elseif($estadoEvento == "rechazado"){?>
                <tr>
				    <td class="titulos"><b>Respuesta del organizador</b></td>
			    </tr>
                <tr>
                    <td colspan="2"></td>
                </tr>
			    <tr>
				    <td colspan="2" style="text-align: center;">    
                        <p>
                            Cap Capital agradece su espera para esta respuesta. Por desgracia, el organizador del evento decidió declinar su solicitud de acceso a la reunión.<br>
                            Si requiere más información al respecto comuniquesé al siguiente teléfono 99-92-60-81-92
                        </p>
				    </td>
			    </tr>    
            <?php }?>
         </table>
        </body>
    </html>