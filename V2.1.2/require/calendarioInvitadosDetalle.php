<?php
$sqlInvitados = "
		Select 
			*
--			,concat(SUBSTRING(`usuarios`.`NOMBRE`,1,Locate(' ', `usuarios`.`NOMBRE`)+1),'.') As `nombreCorto`
			,`usuarios`.`NOMBRE` As `nombreCorto`
			, `usuarios`.`EMAIL` As `correoInvitado`
			, `catalogo_perfiles`.`NOMBRE` As `nombreTipo`
		From 
			`catalogo_perfiles` Inner Join `usuarios` 
			On 
			`catalogo_perfiles`.`TIPO` = `usuarios`.`TIPO` Inner Join `agenda_invitados`
			On 
			`usuarios`.`VALOR` = `agenda_invitados`.`usuario`
		Where 
			`usuarios`.`VALOR` != '".$Usuario."'
			And
			`agenda_invitados`.`idAgenda` = '".$rowInfoCita['idAgenda']."'

				";									 
$sqlInvitadosLibres = "
		Select 
			*
		From 
			`agenda_invitados`
		Where 
			`agenda_invitados`.`idAgenda` = '".$rowInfoCita['idAgenda']."'
			And
			`usuario` Like '%@%'
				";									 

?>

<table width="950" cellpadding="0" cellspacing="0" border="0">
	<tr class="TextoTitulosSecciondivClic" align="left" style="font-size:15px;">
		<td>
        	<div class="divClic">
			<table width="950" cellpadding="0" cellspacing="0" border="0">
            	<tr>
                	<td width="300" align="left">
            			&nbsp;&nbsp;&nbsp;
						<a href="#Invitados" onclick="mostrarOcultarDiv('Invitados')" class="TextoTitulosSecciondivClic" title="Click para ver detalle...">
                        Ver Invitados
                        </a>
                    </td>
                	<td width="650" align="left">
						<a href="#Invitados" onclick="mostrarOcultarDiv('Invitados')" class="LinkSecciondivClic" title="Click para ver detalle...">
                        	&nbsp;&nbsp;&nbsp;
							Click para ver detalle...
                        </a>
                    </td>
                </tr>
			</table>
            </div>
        </td>
    </tr>
    <tr>
    	<td>
        	<div id="Invitados" <? echo ($muestra == "Invitados")? 'style="display:block;"':'style="display:none;"'; ?>>
            	<a name="Invitados" id="Invitados"></a>
            <br>
            <!-- 1 Inicio -->
            	<table width="900" cellpadding="1" cellspacing="1" border="0" align="center" style="font-size:12px;">
                	<tr>
                    	<td colspan="3" style="background-image:url(img/fondoTablaDegradadoGris.png); color:#273B71; font-weight:bold;">
                        <font style="text-decoration:underline;">
                        Usuarios del Sistema
                        </font>
                        </td>
                    </tr>
                	<tr style="background-image:url(img/fondoTablaDegradadoGris.png); color:#273B71; font-weight:bold;">
                    	<td width="80">Confirmado</td>
                        <td width="410"><strong>Usuario</strong></td>
                        <td width="410"><strong>Correo</strong></td>
					</tr>
<?php
	$contIntLi=0;
	$resInvitados = DreQueryDB($sqlInvitados);
	
	while($rowInvitados = mysql_fetch_assoc($resInvitados)){
		$contIntLi++;
?>
					<tr bgcolor="<? echo($contIntLi%2==0)?"#B6C6D7":"#DFDFDF"; ?>">
                    	<td align="center">
							<?php if($rowInvitados['confirmado'] == 1){ echo "Si"; } else { echo "No"; }?>	
						</td>
                    	<td align="justify">
                        	<? echo $rowInvitados['nombreCorto']; //." (".$rowInvitados['nombreTipo'].")"; ?>
                        </td>
                    	<td align="justify">
                        	<? echo $rowInvitados['correoInvitado']; ?>
                        </td>
					</tr>
<?php
	}

	if(mysql_num_rows(DreQueryDB($sqlInvitadosLibres)) > 0){
?>
                	<tr>
                    	<td colspan="3" style="background-image:url(img/fondoTablaDegradadoGris.png); color:#273B71; font-weight:bold;">
                        <font style="text-decoration:underline;">
                        Invitados Libres
                        </font>
                        </td>
                    </tr>
                	<tr style="background-image:url(img/fondoTablaDegradadoGris.png); color:#273B71; font-weight:bold;">
                    	<td width="80">Confirmado</td>
                        <td width="410"><strong>Usuario</strong></td>
                        <td width="410"><strong>Correo</strong></td>
					</tr>
<?php
	$contIntLi=0;
	$resInvitadosLibres = DreQueryDB($sqlInvitadosLibres);
	
	while($rowInvitadosLibres = mysql_fetch_assoc($resInvitadosLibres)){
		$contIntLi++;
?>
					<tr bgcolor="<? echo($contIntLi%2==0)?"#B6C6D7":"#DFDFDF"; ?>">
                    	<td align="center">
							<?php if($rowInvitadosLibres['confirmado'] == 1){ echo "Si"; } else { echo "No"; }?>	
						</td>
                    	<td align="justify">
                        	<? echo $rowInvitadosLibres['usuario']; //." (".$rowInvitados['nombreTipo'].")"; ?>
                        </td>
                    	<td align="justify">
                        	<? echo $rowInvitadosLibres['usuario']; ?>
                        </td>
					</tr>
<?php
	}
	}
?>
            	</table>
            <!-- 1 Fin -->
            <br><br>
            </div>
		</td>
	</tr>
</table>