<?php
$sqlInvitados = "
	Select * From 
		`correos_email`
	Group By 
		`tipoCorreo`
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
                        Agregar Grupo Masivo
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
            	<a href="#InvitadosTodos" onclick="mostrarOcultarDiv('InvitadosTodos')" class="linkDiv" style="text-decoration:none;" title="Click para ver detalle...">
                <font style="color:#273B71; text-decoration:none; font-weight:bold;">
                	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&bull; Masivo - Grupo 
				</font>
				</a>
            	<div id="InvitadosTodos" style="display:none;">
                <a id="InvitadosTodos" name="InvitadosTodos"></a>
            	<table width="900" cellpadding="1" cellspacing="1" border="0" align="center" style="font-size:12px;">
                	<tr style="background-image:url(img/fondoTablaDegradadoGris.png); color:#273B71; font-weight:bold;">
                    	<td width="10">&nbsp;</td>
                        <td width="900"><strong>SubRamo</strong></td>
					</tr>
<?php
	$contIntLi=0;
	$resInvitados = DreQueryDB($sqlInvitados);
	
	while($rowInvitados = mysql_fetch_assoc($resInvitados)){
		$contIntLi++;
?>
					<tr bgcolor="<? echo($contIntLi%2==0)?"#B6C6D7":"#DFDFDF"; ?>">
                    	<td align="justify">
							<input type="checkbox" name="paCorreo[]"  id="paCorreo[]" value="<? echo $rowInvitados['tipoCorreo']; ?>"/>
						</td>
                    	<td align="justify">
                        	<? echo $rowInvitados['tipoCorreo']; ?>
                        </td>
					</tr>
<?php
	}
?>
            	</table>
                </div>
            <!-- 1 Fin -->
            <br><br>
</div>
		</td>
	</tr>
</table>