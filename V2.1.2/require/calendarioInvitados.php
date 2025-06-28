<?php
	$paInvitadoAgregado = explode('*',$paInvitado);

$sqlInvitados = "
	Select 
		*
		, `usuarios`.`NOMBRE` As `nombreCorto`
		, `catalogo_perfiles`.`NOMBRE` As `nombreTipo`
		, `usuarios`.`EMAIL` As `correoInvitado`
	From 
		`usuarios` Inner Join `catalogo_perfiles`
		On 
		`usuarios`.`TIPO` = `catalogo_perfiles`.`TIPO` 
	Where
		(
			`usuarios`.`EMAIL` != ''
		)
		And
		(
			`catalogo_perfiles`.`TIPO` Not Like '2%'
			And
			`catalogo_perfiles`.`TIPO` Not Like '30%'
			And
			`catalogo_perfiles`.`TIPO` Not Like '31%'
			And
			`catalogo_perfiles`.`TIPO` Not Like '32%'
			And
			`catalogo_perfiles`.`TIPO` Not Like '33%'
			And
			`catalogo_perfiles`.`TIPO` Not Like '40%'
		)
	Order By
		`usuarios`.`NOMBRE` Asc
				";

$sqlInvitadosGerentes = "
	Select 
		*
		, `usuarios`.`NOMBRE` As `nombreCorto`
		, `catalogo_perfiles`.`NOMBRE` As `nombreTipo`
		, `usuarios`.`EMAIL` As `correoInvitado`
	From 
		`usuarios` Inner Join `catalogo_perfiles`
		On 
		`usuarios`.`TIPO` = `catalogo_perfiles`.`TIPO` 
	Where
		(
			`usuarios`.`EMAIL` != ''
		)
		And
		(
			`catalogo_perfiles`.`TIPO` Like '2%'
		)			    
	Order By
		`usuarios`.`NOMBRE` Asc
						";

$sqlInvitadosEjecutivos = "
	Select 
		*
		, `usuarios`.`NOMBRE` As `nombreCorto`
		, `catalogo_perfiles`.`NOMBRE` As `nombreTipo`
		, `usuarios`.`EMAIL` As `correoInvitado`
	From 
		`usuarios` Inner Join `catalogo_perfiles`
		On 
		`usuarios`.`TIPO` = `catalogo_perfiles`.`TIPO` 
	Where
		(
			`usuarios`.`EMAIL` != ''
		)
		And
		(
			`catalogo_perfiles`.`TIPO` Like '31%'
			Or
			`catalogo_perfiles`.`TIPO` Like '32%'
			Or
			`catalogo_perfiles`.`TIPO` Like '33%'
		)
	Order By
		`usuarios`.`NOMBRE` Asc
					      ";

$sqlInvitadosPromotores = "
	Select 
		*
		, `usuarios`.`NOMBRE` As `nombreCorto`
		, `catalogo_perfiles`.`NOMBRE` As `nombreTipo`
		, `usuarios`.`EMAIL` As `correoInvitado`
	From 
		`usuarios` Inner Join `catalogo_perfiles`
		On 
		`usuarios`.`TIPO` = `catalogo_perfiles`.`TIPO` 
	Where
		(
			`usuarios`.`EMAIL` != ''
		)
		And
		(
			`catalogo_perfiles`.`TIPO` Like '30%'
		)
	Order By
		`usuarios`.`NOMBRE` Asc
					    ";
						
$sqlInvitadosVendedoresSinPromotor = "
	Select 
		*
		, `usuarios`.`NOMBRE` As `nombreCorto`
		, `catalogo_perfiles`.`NOMBRE` As `nombreTipo`
		, `usuarios`.`EMAIL` As `correoInvitado`
	From 
		`usuarios` Inner Join `catalogo_perfiles`
		On 
		`usuarios`.`TIPO` = `catalogo_perfiles`.`TIPO` 
	Where
		(
			`usuarios`.`EMAIL` != ''
		)
		And
		(
			`catalogo_perfiles`.`TIPO` Like '40%'
			And
			(
			`usuarios`.`PROMOTOR` = '0000000000' Or `usuarios`.`PROMOTOR` = '0000007851'
			)
		)
	Order By
		`usuarios`.`NOMBRE` Asc
									 ";
 
	if(isset($addInvitados)){
?>
<table width="950" cellpadding="0" cellspacing="0" border="0">
<!--
	<tr class="TextoTitulosSecciondivClic" align="left" style="font-size:15px;">
		<td>
        	<div class="divClic">
			<table width="950" cellpadding="0" cellspacing="0" border="0">
            	<tr>
                	<td width="300" align="left">
            			&nbsp;&nbsp;&nbsp;
						<a href="#Invitados" onclick="mostrarOcultarDiv('Invitados')" class="TextoTitulosSecciondivClic" title="Click para ver detalle...">
                        Agregar Invitados
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
-->
    <tr>
    	<td>
        	<div id="Invitados" <? echo (true)? 'style="display:block;"':'style="display:none;"'; //$muestra == "Invitados"; ?>>
            	<a name="Invitados" id="Invitados"></a>
            <br>
            	<table width="900" cellpadding="1" cellspacing="1" border="0" align="center" style="font-size:12px;">
                	<tr>
                    	<td>
                        	Todos los Usuarios del Sistema:
                        	<input type="checkbox" name="paInvitado[]"  id="paInvitado[]" value="todos" />
                        </td>
					</tr>
				</table>
            <br>
            <!-- 1 Inicio -->
            	<a href="#InvitadosTodos" onclick="mostrarOcultarDiv('InvitadosTodos')" class="linkDiv" style="text-decoration:none;" title="Click para ver detalle...">
                <font style="color:#273B71; text-decoration:none; font-weight:bold;">
                	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&bull;Invitados 
				</font>
				</a>
            	<div id="InvitadosTodos" style="display:none;">
                <a id="InvitadosTodos" name="InvitadosTodos"></a>
            	<table width="900" cellpadding="1" cellspacing="1" border="0" align="center" style="font-size:12px;">
                	<tr style="background-image:url(img/fondoTablaDegradadoGris.png); color:#273B71; font-weight:bold;">
                    	<td width="10">&nbsp;</td>
                        <td width="450"><strong>Usuario</strong></td>
                        <td width="440"><strong>Correo</strong></td>
					</tr>
<?php
	$contIntLi=0;
	$resInvitados = DreQueryDB($sqlInvitados);
	
	while($rowInvitados = mysql_fetch_assoc($resInvitados)){
		$contIntLi++;
		$fechaStartArray = explode('-', $fechaStart);
		$fechaStartRequest = $fechaStartArray[2]."-".$fechaStartArray[1]."-".$fechaStartArray[0]." ".$horaStart.":00";
		$fechaEndArray = explode('-', $fechaEnd);
		$fechaEndRequest = $fechaEndArray[2]."-".$fechaEndArray[1]."-".$fechaEndArray[0]." ".$horaEnd.":00";

		$sqlDisponibilidad = "
			Select * from 
				`agenda_invitados` Inner Join `agenda` 
				On 
				`agenda_invitados`.`idAgenda` = `agenda`.`idAgenda` 
			Where
				`agenda_invitados`.`confirmado` = '1'
				And
				(
					`agenda_invitados`.`usuario` = '$rowInvitados[VALOR]' 
					And 
					(
						(`fechaStart` >= '$fechaStartRequest' And `fechaStart` <= '$fechaStartRequest')
						Or
						(`fechaEnd` >= '$fechaEndRequest' And `fechaEnd` <= '$fechaEndRequest')
					)
				);
							 ";
		$resDisponibilidad = DreQueryDB($sqlDisponibilidad);
		$rowDisponibilidad = mysql_num_rows($resDisponibilidad);
//-->		
		if($rowDisponibilidad > 0){
			$disponibilidad = "disabled='disabled' title='Invitado Ocupado'";
		} else {
			$disponibilidad = "";
		}
		if(in_array($rowInvitados['VALOR'], $paInvitadoAgregado)){
			$invitadoAgregado = "checked";
		} else {
			$invitadoAgregado = "";
		}
		
		
?>
					<tr bgcolor="<? echo($contIntLi%2==0)?"#B6C6D7":"#DFDFDF"; ?>">
                    	<td align="justify">
                        	<?php if($disponibilidad != ""){ ?>
                            <div style="background-color:#FF0004;">
                            <?php } ?>
							<input type="checkbox" name="paInvitado[]"  id="paInvitado[]"
                            	value="<? echo $rowInvitados['VALOR']; ?>" 
								<? echo $disponibilidad; ?>
                                <? echo $invitadoAgregado; ?>
								
                            />
                        	<?php if($disponibilidad != ""){ ?>
                            </div>
                            <?php } ?>
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
?>
            	</table>
                </div>
            <!-- 1 Fin -->
            <br><br>
            <!-- 2 Inicio -->
            	<a href="#InvitadosGerentes" onclick="mostrarOcultarDiv('InvitadosGerentes')" class="linkDiv" style="text-decoration:none;" title="Click para ver detalle...">
                <font style="color:#273B71; text-decoration:none; font-weight:bold;">
                	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&bull;Invitados Gerentes
				</font>
				</a>
            	<div id="InvitadosGerentes" style="display:none;">
                <a id="InvitadosGerentes" name="InvitadosGerentes"></a>
            	<table width="900" cellpadding="1" cellspacing="1" border="0" align="center" style="font-size:12px;">
                	<tr style="background-image:url(img/fondoTablaDegradadoGris.png); color:#273B71; font-weight:bold;">
                    	<td width="10">&nbsp;</td>
                        <td width="450"><strong>Usuario</strong></td>
                        <td width="440"><strong>Correo</strong></td>
					</tr>
<?php
	$contIntLi=0;
	$resInvitadosGerentes = DreQueryDB($sqlInvitadosGerentes);
	
	while($rowInvitadosGerentes = mysql_fetch_assoc($resInvitadosGerentes)){
		$contIntLi++;
		$fechaStartArray = explode('-', $fechaStart);
		$sqlDisponibilidad = "
			Select * from 
				`agenda_invitados` Inner Join `agenda` 
				On 
				`agenda_invitados`.`idAgenda` = `agenda`.`idAgenda` 
			Where
				`agenda_invitados`.`usuario` = '$rowInvitadosGerentes[VALOR]' 
				And 
				(`fechaStart` = '".$fechaStartArray[2]."-".$fechaStartArray[1]."-".$fechaStartArray[0]." ".$horaStart.":00' )
							 ";
		$resDisponibilidad = DreQueryDB($sqlDisponibilidad);
		$rowDisponibilidad = mysql_num_rows($resDisponibilidad);
		
		if($rowDisponibilidad > 0){
			$disponibilidad = "disabled='disabled' title='Invitado Ocupado'";
		} else {
			$disponibilidad = "";
		}
?>
					<tr bgcolor="<? echo($contIntLi%2==0)?"#B6C6D7":"#DFDFDF"; ?>">
                    	<td align="justify">
                        	<?php if($disponibilidad != ""){ ?>
                            <div style="background-color:#FF0004;">
                            <?php } ?>
							<input type="checkbox" name="paInvitado[]"  id="paInvitado[]" value="<? echo $rowInvitadosGerentes['VALOR']; ?>" <? echo $disponibilidad; ?>/>
                        	<?php if($disponibilidad != ""){ ?>
                            </div>
                            <?php } ?>
						</td>
                    	<td align="justify">
                        	<? echo $rowInvitadosGerentes['nombreCorto']; ?>
                        </td>
                    	<td align="justify">
                        	<? echo $rowInvitadosGerentes['correoInvitado']; ?>
                        </td>
					</tr>
<?php
	}
?>
                	<tr>
                    	<td></td>
                    	<td colspan="2">
                        	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        	Todos Gerentes :
                        	<input type="checkbox" name="paInvitado[]"  id="paInvitado[]" value="todosGerentes"/>
                        </td>
                    </tr>
            	</table>
                </div>
            <!-- 2 Fin -->
            <br><br>
            <!-- 3 Inicio -->
            	<a href="#InvitadosEjecutivos" onclick="mostrarOcultarDiv('InvitadosEjecutivos')" class="linkDiv" style="text-decoration:none;" title="Click para ver detalle...">
                <font style="color:#273B71; text-decoration:none; font-weight:bold;">
                	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&bull;Invitados Ejecutivos
				</font>
				</a>
            	<div id="InvitadosEjecutivos" style="display:none;">
                <a id="InvitadosEjecutivos" name="InvitadosEjecutivos"></a>
            	<table width="900" cellpadding="1" cellspacing="1" border="0" align="center" style="font-size:12px;">
                	<tr style="background-image:url(img/fondoTablaDegradadoGris.png); color:#273B71; font-weight:bold;">
                    	<td width="10">&nbsp;</td>
                        <td width="450"><strong>Usuario</strong></td>
                        <td width="440"><strong>Correo</strong></td>
					</tr>
<?php
	$contIntLi=0;
	$resInvitadosEjecutivos = DreQueryDB($sqlInvitadosEjecutivos);
	
	while($rowInvitadosEjecutivos = mysql_fetch_assoc($resInvitadosEjecutivos)){
		$contIntLi++;
		$fechaStartArray = explode('-', $fechaStart);
		$sqlDisponibilidad = "
			Select * from 
				`agenda_invitados` Inner Join `agenda` 
				On 
				`agenda_invitados`.`idAgenda` = `agenda`.`idAgenda` 
			Where
				`agenda_invitados`.`usuario` = '$rowInvitadosEjecutivos[VALOR]' 
				And 
				(`fechaStart` = '".$fechaStartArray[2]."-".$fechaStartArray[1]."-".$fechaStartArray[0]." ".$horaStart.":00' )
							 ";
		$resDisponibilidad = DreQueryDB($sqlDisponibilidad);
		$rowDisponibilidad = mysql_num_rows($resDisponibilidad);
		
		if($rowDisponibilidad > 0){
			$disponibilidad = "disabled='disabled' title='Invitado Ocupado'";
		} else {
			$disponibilidad = "";
		}
?>
					<tr bgcolor="<? echo($contIntLi%2==0)?"#B6C6D7":"#DFDFDF"; ?>">
                    	<td align="justify">
                        	<?php if($disponibilidad != ""){ ?>
                            <div style="background-color:#FF0004;">
                            <?php } ?>
							<input type="checkbox" name="paInvitado[]"  id="paInvitado[]" value="<? echo $rowInvitadosEjecutivos['VALOR']; ?>" <? echo $disponibilidad; ?>/>
                        	<?php if($disponibilidad != ""){ ?>
                            </div>
                            <?php } ?>
						</td>
                    	<td align="justify">
                        	<? echo $rowInvitadosEjecutivos['nombreCorto']; ?>
                        </td>
                    	<td align="justify">
                        	<? echo $rowInvitadosEjecutivos['correoInvitado']; ?>
                        </td>
					</tr>
<?php
	}
?>
                	<tr>
                    	<td></td>
                    	<td colspan="2">
                        	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        	Todos Ejecutivos :
                        	<input type="checkbox" name="paInvitado[]"  id="paInvitado[]" value="todosEjecutivos"/>
                        </td>
                    </tr>
            	</table>
                </div>
            <!-- 3 Fin -->
            <br><br>
            <!-- 4 Inicio -->
            	<a href="#InvitadosPromotores" onclick="mostrarOcultarDiv('InvitadosPromotores')" class="linkDiv" style="text-decoration:none;" title="Click para ver detalle...">
                <font style="color:#273B71; text-decoration:none; font-weight:bold;">
                	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&bull;Invitados Promotores
				</font>
				</a>
            	<div id="InvitadosPromotores" style="display:none;">
                <a id="InvitadosPromotores" name="InvitadosPromotores"></a>
            	<table width="900" cellpadding="1" cellspacing="1" border="0" align="center" style="font-size:12px;">
                	<tr style="background-image:url(img/fondoTablaDegradadoGris.png); color:#273B71; font-weight:bold;">
                    	<td width="10">&nbsp;</td>
                        <td width="450"><strong>Usuario</strong></td>
                        <td width="440"><strong>Correo</strong></td>
					</tr>
<?php
	$contIntLi=0;
	$resInvitadosPromotores = DreQueryDB($sqlInvitadosPromotores);
	
	while($rowInvitadosPromotores = mysql_fetch_assoc($resInvitadosPromotores)){
		$contIntLi++;
		$fechaStartArray = explode('-', $fechaStart);
		$sqlDisponibilidad = "
			Select * from 
				`agenda_invitados` Inner Join `agenda` 
				On 
				`agenda_invitados`.`idAgenda` = `agenda`.`idAgenda` 
			Where
				`agenda_invitados`.`usuario` = '$rowInvitadosPromotores[VALOR]' 
				And 
				(`fechaStart` = '".$fechaStartArray[2]."-".$fechaStartArray[1]."-".$fechaStartArray[0]." ".$horaStart.":00' )
							 ";
		$resDisponibilidad = DreQueryDB($sqlDisponibilidad);
		$rowDisponibilidad = mysql_num_rows($resDisponibilidad);

		if($rowDisponibilidad > 0){
			$disponibilidad = "disabled='disabled' title='Invitado Ocupado'";
		} else {
			$disponibilidad = "";
		}
?>
					<tr bgcolor="<? echo($contIntLi%2==0)?"#B6C6D7":"#DFDFDF"; ?>">
                    	<td align="justify">
                        	<?php if($disponibilidad != ""){ ?>
                            <div style="background-color:#FF0004;">
                            <?php } ?>
							<input type="checkbox" name="paInvitado[]"  id="paInvitado[]" value="<? echo $rowInvitadosPromotores['VALOR']; ?>" <? echo $disponibilidad; ?>/>
                        	<?php if($disponibilidad != ""){ ?>
                            </div>
                            <?php } ?>
						</td>
                    	<td align="justify">
                        	<? echo $rowInvitadosPromotores['nombreCorto']; ?>
                        </td>
                    	<td align="justify">
                        	<? echo $rowInvitadosPromotores['correoInvitado']; ?>
                        </td>
					</tr>
<?php
	}
?>
                	<tr>
                    	<td></td>
                    	<td colspan="2">
                        	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        	Todos Promotores :
                        	<input type="checkbox" name="paInvitado[]"  id="paInvitado[]" value="todosPromotores"/>
                        </td>
                    </tr>
            	</table>
                </div>
            <!-- 4 Fin -->
            <br><br>
            <!-- 5 Inicio -->
            	<a href="#InvitadosVendedoresSinPromotor" onclick="mostrarOcultarDiv('InvitadosVendedoresSinPromotor')" class="linkDiv" style="text-decoration:none;" title="Click para ver detalle...">
                <font style="color:#273B71; text-decoration:none; font-weight:bold;">
                	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&bull;Invitados Vendedores Libres
				</font>
				</a>
            	<div id="InvitadosVendedoresSinPromotor" style="display:none;">
                <a id="InvitadosVendedoresSinPromotor" name="InvitadosVendedoresSinPromotor"></a>
            	<table width="900" cellpadding="1" cellspacing="1" border="0" align="center" style="font-size:12px;">
                	<tr style="background-image:url(img/fondoTablaDegradadoGris.png); color:#273B71; font-weight:bold;">
                    	<td width="10">&nbsp;</td>
                        <td width="450"><strong>Usuario</strong></td>
                        <td width="440"><strong>Correo</strong></td>
					</tr>
<?php
	$contIntLi=0;
	$resInvitadosVendedoresSinPromotor = DreQueryDB($sqlInvitadosVendedoresSinPromotor);
	
	while($rowInvitadosVendedoresSinPromotor = mysql_fetch_assoc($resInvitadosVendedoresSinPromotor)){
		$contIntLi++;
		$fechaStartArray = explode('-', $fechaStart);
		$sqlDisponibilidad = "
			Select * from 
				`agenda_invitados` Inner Join `agenda` 
				On 
				`agenda_invitados`.`idAgenda` = `agenda`.`idAgenda` 
			Where
				`agenda_invitados`.`usuario` = '$rowInvitadosVendedoresSinPromotor[VALOR]' 
				And 
				(`fechaStart` = '".$fechaStartArray[2]."-".$fechaStartArray[1]."-".$fechaStartArray[0]." ".$horaStart.":00' )
							 ";
		$resDisponibilidad = DreQueryDB($sqlDisponibilidad);
		$rowDisponibilidad = mysql_num_rows($resDisponibilidad);
			
		if($rowDisponibilidad > 0){
			$disponibilidad = "disabled='disabled' title='Invitado Ocupado'";
		} else {
			$disponibilidad = "";
		}

?>
					<tr bgcolor="<? echo($contIntLi%2==0)?"#B6C6D7":"#DFDFDF"; ?>">
                    	<td align="justify">
                        	<?php if($disponibilidad != ""){ ?>
                            <div style="background-color:#FF0004;">
                            <?php } ?>
							<input type="checkbox" name="paInvitado[]"  id="paInvitado[]" value="<? echo $rowInvitadosVendedoresSinPromotor['VALOR']; ?>" <? echo $disponibilidad; ?>/>
                        	<?php if($disponibilidad != ""){ ?>
                            </div>
                            <?php } ?>
						</td>
                    	<td align="justify">
                        	<? echo $rowInvitadosVendedoresSinPromotor['nombreCorto']; ?>
                        </td>
                    	<td align="justify">
                        	<? echo $rowInvitadosVendedoresSinPromotor['correoInvitado']; ?>
                        </td>
					</tr>
<?php
	}
?>
            	</table>
                </div>
            <!-- 5 Fin -->
            <br>
<?php
$resPromotores = DreQueryDB($sqlInvitadosPromotores);
while($rowPromotores = mysql_fetch_assoc($resPromotores)){

$sqlInvitadosVendedoresPorPromotor = "
	Select 
		*
		, `usuarios`.`NOMBRE` As `nombreCorto`
		, `catalogo_perfiles`.`NOMBRE` As `nombreTipo`
		, `usuarios`.`EMAIL` As `correoInvitado`
	From 
		`usuarios` Inner Join `catalogo_perfiles`
		On 
		`usuarios`.`TIPO` = `catalogo_perfiles`.`TIPO` 
	Where
		(
			`usuarios`.`EMAIL` != ''
		)
		And
		(
			`catalogo_perfiles`.`TIPO` Like '40%'
			And
			`usuarios`.`PROMOTOR` = '$rowPromotores[VALOR]'
		)
	Order By
		`usuarios`.`NOMBRE` Asc
									 ";
?>
			<br>
            <!-- 5 Inicio -->
            	<a href="<? echo "#sqlInvitadosVendedoresPorPromotor".$rowPromotores['VALOR']; ?>" onclick="mostrarOcultarDiv('<? echo "#sqlInvitadosVendedoresPorPromotor".$rowPromotores['VALOR']; ?>')" class="linkDiv" style="text-decoration:none;" title="Click para ver detalle...">
                <font style="color:#273B71; text-decoration:none; font-weight:bold;">
                	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&bull;Invitados Vendedores del Promotor: <? echo $rowPromotores['nombreCorto'];?>
				</font>
				</a>
            	<div id="<? echo "#sqlInvitadosVendedoresPorPromotor".$rowPromotores['VALOR']; ?>" style="display:none;">
                <a id="<? echo "#sqlInvitadosVendedoresPorPromotor".$rowPromotores['VALOR']; ?>" name="<? echo "#sqlInvitadosVendedoresPorPromotor".$rowPromotores['VALOR']; ?>"></a>
            	<table width="900" cellpadding="1" cellspacing="1" border="0" align="center" style="font-size:12px;">
                	<tr style="background-image:url(img/fondoTablaDegradadoGris.png); color:#273B71; font-weight:bold;">
                    	<td width="10">&nbsp;</td>
                        <td width="450"><strong>Usuario</strong></td>
                        <td width="440"><strong>Correo</strong></td>
					</tr>
<?php
	$contIntLi=0;
	$resInvitadosVendedoresPorPromotor = DreQueryDB($sqlInvitadosVendedoresPorPromotor);
	
	while($rowInvitadosVendedoresPorPromotor = mysql_fetch_assoc($resInvitadosVendedoresPorPromotor)){
		$contIntLi++;
		$fechaStartArray = explode('-', $fechaStart);
		$sqlDisponibilidad = "
			Select * from 
				`agenda_invitados` Inner Join `agenda` 
				On 
				`agenda_invitados`.`idAgenda` = `agenda`.`idAgenda` 
			Where
				`agenda_invitados`.`usuario` = '$rowInvitadosVendedoresPorPromotor[VALOR]' 
				And 
				(`fechaStart` = '".$fechaStartArray[2]."-".$fechaStartArray[1]."-".$fechaStartArray[0]." ".$horaStart.":00' )
							 ";
		$resDisponibilidad = DreQueryDB($sqlDisponibilidad);
		$rowDisponibilidad = mysql_num_rows($resDisponibilidad);
	
		
		if($rowDisponibilidad > 0){
			$disponibilidad = "disabled='disabled' title='Invitado Ocupado'";
		} else {
			$disponibilidad = "";
		}
?>
					<tr bgcolor="<? echo($contIntLi%2==0)?"#B6C6D7":"#DFDFDF"; ?>">
                    	<td align="justify">
                        	<?php if($disponibilidad != ""){ ?>
                            <div style="background-color:#FF0004;">
                            <?php } ?>
							<input type="checkbox" name="paInvitado[]"  id="paInvitado[]" value="<? echo $rowInvitadosVendedoresPorPromotor['VALOR']; ?>" <? echo $disponibilidad; ?>/>
                        	<?php if($disponibilidad != ""){ ?>
                            </div>
                            <?php } ?>
						</td>
                    	<td align="justify">
                        	<? echo $rowInvitadosVendedoresPorPromotor['nombreCorto']; ?>
                        </td>
                    	<td align="justify">
                        	<? echo $rowInvitadosVendedoresPorPromotor['correoInvitado']; ?>
                        </td>
					</tr>
<?php
	}
?>
            	</table>
                </div>
            <!-- 5 Fin -->
            <br>
            
<?php
}

?>
            	<br>
					<font style="color:#000; text-decoration:none; font-weight:bold;">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&bull;Invitados Libres
					</font>
				<br>
                <table width="900" cellpadding="1" cellspacing="1" border="0" align="center" style="font-size:12px;">
                	<!--
                	<tr style="background-image:url(img/fondoTablaDegradadoGris.png); color:#273B71; font-weight:bold;">
                    	<td width="10">&nbsp;</td>
                        <td width="450"><strong>Usuario</strong></td>
                        <td width="440"><strong>Correo</strong></td>
					</tr>
                    -->
                    <tr>
                    	<td>
                        	<input 
                            	type="text" name="invitadosLibres" id="invitadosLibres" style="width:95%"
                                value="<? echo $invitadosLibres; ?>"
                            />
                        </td>
                    </tr>
            	</table>
            </div>
		</td>
	</tr>
    <tr>
    	<td>&nbsp;
        	
        </td>
    </tr>
</table>
<?php
	}
?>