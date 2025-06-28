<?php
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

if(
	$_SESSION['WebDreTacticaWeb2']['Tipo'] == "310"
	||
	$_SESSION['WebDreTacticaWeb2']['Tipo'] == "410"
	||
	$_SESSION['WebDreTacticaWeb2']['Tipo'] == "210"
	||
	$_SESSION['WebDreTacticaWeb2']['Tipo'] == "220"
	||
	$_SESSION['WebDreTacticaWeb2']['Tipo'] == "100"
  ){
$sqlAdicionalFiltradoTipo = "";
  } else {

$sqlAdicionalFiltradoTipo = "		
		And
		(
			`usuarios`.`VALOR` Like '%$Usuario%'
		)
		";
  }
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
		$sqlAdicionalFiltradoTipo
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
                        Agregar Usuarios
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
if(
	$_SESSION['WebDreTacticaWeb2']['Tipo'] == "310"
	||
	$_SESSION['WebDreTacticaWeb2']['Tipo'] == "410"
	||
	$_SESSION['WebDreTacticaWeb2']['Tipo'] == "210"
	||
	$_SESSION['WebDreTacticaWeb2']['Tipo'] == "220"
	||
	$_SESSION['WebDreTacticaWeb2']['Tipo'] == "100"
  ){ //Fin de Validacion Tipos de Usuario
?>

            	<table width="900" cellpadding="1" cellspacing="1" border="0" align="center" style="font-size:12px;">
                	<tr>
                    	<td>
                        	Todos los Usuarios del Sistema:
                        	<input type="checkbox" name="paCorreo[]"  id="paCorreo[]" value="todos"/>
                        </td>
					</tr>
				</table>
            <br>
            <!-- 1 Inicio -->
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
            	<tr>
                	<td>
            	<a href="#InvitadosTodos" onclick="mostrarOcultarDiv('InvitadosTodos')" class="linkDiv" style="text-decoration:none;" title="Click para ver detalle...">
                <font style="color:#273B71; text-decoration:none; font-weight:bold;">
                	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&bull;Usuarios 
				</font>
				</a>
                    </td>
                	<td align="right">
                        	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        	Todos Usuarios :
                        	<input type="checkbox" name="paCorreo[]"  id="paCorreo[]" value="todosUsuarios"/>
                    </td>
				</tr>
			</table>
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
?>
					<tr bgcolor="<? echo($contIntLi%2==0)?"#B6C6D7":"#DFDFDF"; ?>">
                    	<td align="justify">
							<input type="checkbox" name="paCorreo[]"  id="paCorreo[]" value="<? echo $rowInvitados['VALOR']; ?>"/>
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
            <br>
            <!-- 2 Inicio -->
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
            	<tr>
                	<td>
            	<a href="#InvitadosGerentes" onclick="mostrarOcultarDiv('InvitadosGerentes')" class="linkDiv" style="text-decoration:none;" title="Click para ver detalle...">
                <font style="color:#273B71; text-decoration:none; font-weight:bold;">
                	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&bull;Usuarios Gerentes
				</font>
				</a>
                    </td>
                	<td align="right">
                        	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        	Todos Gerentes :
                        	<input type="checkbox" name="paCorreo[]"  id="paCorreo[]" value="todosGerentes"/>
                    </td>
                </tr>
            </table>
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
?>
					<tr bgcolor="<? echo($contIntLi%2==0)?"#B6C6D7":"#DFDFDF"; ?>">
                    	<td align="justify">
							<input type="checkbox" name="paCorreo[]"  id="paCorreo[]" value="<? echo $rowInvitadosGerentes['VALOR']; ?>"/>
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
            	</table>
                </div>
            <!-- 2 Fin -->
            <br>
            <!-- 3 Inicio -->
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
            	<tr>
                	<td>
            	<a href="#InvitadosEjecutivos" onclick="mostrarOcultarDiv('InvitadosEjecutivos')" class="linkDiv" style="text-decoration:none;" title="Click para ver detalle...">
                <font style="color:#273B71; text-decoration:none; font-weight:bold;">
                	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&bull;Usuarios Ejecutivos
				</font>
				</a>
                    </td>
                	<td align="right">
                        	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        	Todos Ejecutivos :
                        	<input type="checkbox" name="paCorreo[]"  id="paCorreo[]" value="todosEjecutivos"/>
                    </td>
				</tr>
			</table>
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
?>
					<tr bgcolor="<? echo($contIntLi%2==0)?"#B6C6D7":"#DFDFDF"; ?>">
                    	<td align="justify">
							<input type="checkbox" name="paCorreo[]"  id="paCorreo[]" value="<? echo $rowInvitadosEjecutivos['VALOR']; ?>"/>
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
            	</table>
                </div>
            <!-- 3 Fin -->
            <br>
            <!-- 4 Inicio -->
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
            	<tr>
                	<td>
            	<a href="#InvitadosPromotores" onclick="mostrarOcultarDiv('InvitadosPromotores')" class="linkDiv" style="text-decoration:none;" title="Click para ver detalle...">
                <font style="color:#273B71; text-decoration:none; font-weight:bold;">
                	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&bull;Usuarios Promotores
				</font>
				</a>
                    </td>
                    <td  align="right">
            				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        	Todos Promotores :
                        	<input type="checkbox" name="paCorreo[]"  id="paCorreo[]" value="todosPromotores"/>
                    </td>
				</tr>
			</table>
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
?>
					<tr bgcolor="<? echo($contIntLi%2==0)?"#B6C6D7":"#DFDFDF"; ?>">
                    	<td align="justify">
							<input type="checkbox" name="paCorreo[]"  id="paCorreo[]" value="<? echo $rowInvitadosPromotores['VALOR']; ?>"/>
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
            	</table>
                </div>
            <!-- 4 Fin -->
            <br>
            <!-- 5 Inicio -->
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
            	<tr>
                	<td>
            	<a href="#InvitadosVendedoresSinPromotor" onclick="mostrarOcultarDiv('InvitadosVendedoresSinPromotor')" class="linkDiv" style="text-decoration:none;" title="Click para ver detalle...">
                <font style="color:#273B71; text-decoration:none; font-weight:bold;">
                	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&bull;Usuarios Vendedores Libres
				</font>
				</a>
                    </td>
                	<td align="right">
            				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        	Todos Vendedores Libres :
                        	<input type="checkbox" name="paCorreo[]"  id="paCorreo[]" value="todosVendedoresLibres"/>
                    </td>
				</tr>
			</table>
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
?>
					<tr bgcolor="<? echo($contIntLi%2==0)?"#B6C6D7":"#DFDFDF"; ?>">
                    	<td align="justify">
							<input type="checkbox" name="paCorreo[]"  id="paCorreo[]" value="<? echo $rowInvitadosVendedoresSinPromotor['VALOR']; ?>"/>
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
<?php
} //Fin de Validacion Tipos de Usuario
?>
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
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
            	<tr>
                	<td>
            	<a href="<? echo "#sqlInvitadosVendedoresPorPromotor".$rowPromotores['VALOR']; ?>" onclick="mostrarOcultarDiv('<? echo "#sqlInvitadosVendedoresPorPromotor".$rowPromotores['VALOR']; ?>')" class="linkDiv" style="text-decoration:none;" title="Click para ver detalle...">
                <font style="color:#273B71; text-decoration:none; font-weight:bold;">
                	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&bull;Usuarios Vendedores del Promotor:
				</font>
                <font style="color:#273B71; text-decoration:none; font-weight:bold; font-size:12px">
                     <? echo $rowPromotores['nombreCorto'];?>
				</font>
				</a>
                    </td>
                	<td align="right">
            				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        	Todos V. <font style="font-size:12px;"><? echo $rowPromotores['nombreCorto']; ?> :</font>
                        	<input type="checkbox" name="paCorreo[]"  id="paCorreo[]" value="<? echo "todosVendedoresPro-".$rowPromotores['VALOR']; ?>"/>
                    </td>
				</tr>
			</table>
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
?>
					<tr bgcolor="<? echo($contIntLi%2==0)?"#B6C6D7":"#DFDFDF"; ?>">
                    	<td align="justify">
							<input type="checkbox" name="paCorreo[]"  id="paCorreo[]" value="<? echo $rowInvitadosVendedoresPorPromotor['VALOR']; ?>"/>
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

<?php
}
?>
            </div>
		</td>
	</tr>
</table>