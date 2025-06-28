<?php
$sqlInvitados = "
	Select * From 
		`cliramos` Inner Join `empresas` 
		On 
		`cliramos`.`CLAVE_CLIENTE` = `empresas`.`CLAVE` 
	Group By 
		`SUBRAMO`
				";
		
		
$sqlInvitadosVendedores = "
	Select * From 
		`cliramos` Inner Join `empresas` 
		On 
		`cliramos`.`CLAVE_CLIENTE` = `empresas`.`CLAVE` Inner Join `contactos`
		On
		`empresas`.`CLAVE` = `contactos`.`CLAVE`
	Where
		`empresas`.`VENDEDOR` = '$Usuario'
		And
		`contactos`.`EMAIL` != ''
	Group BY
		`empresas`.`CLAVE`,`cliramos`.`SUBRAMO`
	Order By 
		`SUBRAMO`, `RAZON_SOCIAL` Asc
						  ";
echo "<pre>";
	echo "&bull;<br>";
	echo $sqlInvitados;
	echo "<br>&bull;<br>";
	echo $sqlInvitadosVendedores;
echo "</pre>";
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
                        Agregar Clientes
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
<?php
	if($Nivel != 2){
?>
            <!-- 1 Inicio -->
            	<a href="#InvitadosTodos" onclick="mostrarOcultarDiv('InvitadosTodos')" class="linkDiv" style="text-decoration:none;" title="Click para ver detalle...">
                <font style="color:#273B71; text-decoration:none; font-weight:bold;">
                	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&bull; Clientes - Sub Ramo 
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
							<input type="checkbox" name="paCorreo[]"  id="paCorreo[]" value="<? echo $rowInvitados['SUBRAMO']; ?>"/>
						</td>
                    	<td align="justify">
                        	<? echo $rowInvitados['SUBRAMO']; ?>
                        </td>
					</tr>
<?php
	}
?>
            	</table>
                </div>
            <!-- 1 Fin -->
<?php
	} else {
?>
            <!-- 2 Inicio -->
            	<a href="#InvitadosTodos" onclick="mostrarOcultarDiv('InvitadosTodos')" class="linkDiv" style="text-decoration:none;" title="Click para ver detalle...">
                <font style="color:#273B71; text-decoration:none; font-weight:bold;">
                	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&bull; Clientes
				</font>
				</a>
            	<div id="InvitadosTodos" <? echo ($muestra2 == "InvitadosTodos")? 'style="display:block;"':'style="display:none;"'; ?>>
<!-- style="display:none;" -->
<?php
	// ?para=clientes&SubRamoRequest=GASTOS%20MEDICOS&muestra=Invitados&muestra2=InvitadosTodos#InvitadosTodos;
	$urlSubRamo = $_SERVER['PHP_SELF']."?para=clientes&SubRamoRequest=GASTOS%20MEDICOS&muestra=Invitados&muestra2=InvitadosTodos#InvitadosTodos";
?>
				<input type="checkbox" name="" id="" onChange="JavaScript: window.open('<? echo $urlSubRamo; ?>', '_self')" />
                <a id="InvitadosTodos" name="InvitadosTodos"></a>
            	<table width="900" cellpadding="1" cellspacing="1" border="0" align="center" style="font-size:12px;">
                	<tr style="background-image:url(img/fondoTablaDegradadoGris.png); color:#273B71; font-weight:bold;">
                    	<td width="10">&nbsp;</td>
                        <td width="450"><strong>SubRamo</strong></td>
                        <td width="450"><strong>Nombre</strong></td>
                        
					</tr>
<?php
	$contIntLi=0;
	$resInvitados = DreQueryDB($sqlInvitadosVendedores);
	
	while($rowInvitados = mysql_fetch_assoc($resInvitados)){
		$contIntLi++;
?>
					<tr bgcolor="<? echo($contIntLi%2==0)?"#B6C6D7":"#DFDFDF"; ?>">
                    	<td align="justify">
							<input type="checkbox" name="paCorreo[]"  id="paCorreo[]" value="<? echo $rowInvitados['RAZON_SOCIAL']; ?>" <? echo ($rowInvitados['SUBRAMO'] == $SubRamoRequest )? "checked":""; ?> />
						</td>
                    	<td align="justify">
                        	<? echo $rowInvitados['SUBRAMO']; ?>
                        </td>
                    	<td align="justify">
                        	<? echo $rowInvitados['RAZON_SOCIAL']; ?>
                        </td>
					</tr>
<?php
	}
?>
            	</table>
                </div>
            <!-- 1 Fin -->
<?php
	}
?>
            <br><br>
</div>
		</td>
	</tr>
</table>