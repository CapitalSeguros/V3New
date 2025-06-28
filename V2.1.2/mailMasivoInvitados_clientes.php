<?php
## 0000040610
Function DreReclasificaCliRamosEmpresas($vendedor){
	$sqlConsultaEmpresasVendedor = "
		Select * From 
			`empresas`
		Where
			`VENDEDOR` = '$vendedor'
			And
			`cliramos_subRamo` = ''
								   ";
	$resConsultaEmpresasVendedor = DreQueryDB($sqlConsultaEmpresasVendedor);
	//$count = 0;
	while($rowConsultaEmpresasVendedor = mysql_fetch_assoc($resConsultaEmpresasVendedor)){
		$sqlConsultaPolizasEmpresa = "
			Select * From
				`cliramos`
			Where
				`CLAVE_CLIENTE` = '".$rowConsultaEmpresasVendedor['CLAVE']."'
			Group By
				`SUBRAMO`
									 ";
		$resConsultaPolizasEmpresa = DreQueryDB($sqlConsultaPolizasEmpresa);
		while($rowConsultaPolizasEmpresa = mysql_fetch_assoc($resConsultaPolizasEmpresa)){
			$updateCliramosSubRAmo = "
				Update
					`empresas`
				Set
					`cliramos_subRamo` = '".$rowConsultaPolizasEmpresa['SUBRAMO']."'
									 ";
			$return[] = $updateCliramosSubRAmo."-".$rowConsultaPolizasEmpresa['SUBRAMO']."|".$rowConsultaPolizasEmpresa['CLAVE_CLIENTE'];
		}
		$return[] = "&bull;";
			
		//$count++;
	}
	
	return
		//print($sqlConsultaEmpresasVendedor);
		//print($count);
		print_r($return);
		
}
		
echo "<pre>";
	DreReclasificaCliRamosEmpresas($Usuario);
/*
	echo "&bull;<br>";
	echo $sqlInvitados;
	echo "<br>&bull;<br>";
	echo $sqlInvitadosVendedores;
*/
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
		</td>
	</tr>
</table>