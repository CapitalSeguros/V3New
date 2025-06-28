<table width="950" cellpadding="0" cellspacing="0" border="0" align="center">
	<tr>
    	<td colspan="2">&nbsp;</td>
    </tr>
    <form name="formMailMasivo" id="formMailMasivo" method="post" action="includes/enviarCorreo.php?tipoEnvio=correoMasivo">
	<? 
		//if($Usuario == "0000028964" || $Usuario == "0000522578" ){
		if(DrePermisoUsuario('mailMasivo-desdeSelect-verDesdeSelect-si', $nodosPermisos)){
	?>
	<tr>
		<td>
        	Desde:
        </td>
        <td>
			<select name="desdeSelect" id="desdeSelect">
            	<option value="">--Seleccione--</option>
            	<option value="CAPACITA <confirmaciones@capacitasegurosyfianzas.com.mx>" <? echo ($desdeSelect == "CAPACITA <confirmaciones@capacitasegurosyfianzas.com.mx>")? "selected":"";?>>CAPACITA</option>
            	<option value="CAPSYS Web <soporte@capsys.com.mx>" <? echo ($desdeSelect == "CAPSYS Web <soporte@capsys.com.mx>")? "selected":"";?>>CAPSYS</option>
            </select>
        </td>
    </tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<?
		}
	?>
	<tr>
    	<td>
			Para:
		</td>
		<td>
        <?
			if(!isset($para)){
				switch($Nivel){
					case "2":
					?>
                    	<!--
						<input 
                        	type="button" value="Usuarios" class="buttonGeneral"
                            onclick="java:window.open('mailMasivo.php?para=usuarios','_self');"
                        />
                        -->
						<input 
                        	type="button" value="Clientes" class="buttonGeneral"
                            onclick="java:window.open('mailMasivo.php?para=clientes','_self');"
                        />
                        <?
							if(DrePermisoUsuario('mailMasivo-paraMasivo-masivo-si', $nodosPermisos)){
							?>
								<input 
                                	type="button" value="Masivos" class="buttonGeneral" 
									onclick="java:window.open('<? echo "mailMasivo.php?para=masivos&desdeSelect=".$desdeSelect; ?>','_self');" 
                                />
                            <?
							}
						?>
                    <?
					break;
					
					default:
					?>
						<input 
                        	type="button" value="Clientes" class="buttonGeneral"
                            onclick="java:window.open('mailMasivo.php?para=clientes','_self');"
                        />
                    <?
					break;
				}
			} else {
				?>
                <font class="TextoTitulosSecciondivClic">
					<? echo $para; ?>
                </font>
                <?
			}
		?>
		</td>
	</tr>
    <tr valign="top">
    	<td colspan="2">
			<?php 
				switch($para){
					case "usuarios":
						include('mailMasivoInvitados_usuarios.php'); 
					break;
					
					case "clientes":
						include('mailMasivoInvitados_clientes.php'); 
					break;
					
					case "masivos":
						include('mailMasivoInvitados_masivos.php'); 
					break;
				}
			?>
        </td>
    </tr>
	<tr>
		<td colspan="2">&nbsp;
			
		</td>
	</tr>
	<tr>
    	<td width="110">
        	Asunto:
		</td>
		<td width="840" align="left">
			<input type="text" name="asunto" id="asunto" style="width:100%" />
		</td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;
			
		</td>
	</tr>
    <tr>
    	<td colspan="2">
        Mensaje:
        </td>
	</tr>
	<tr>
		<td colspan="2">
        <?php
			$tipo_toolbar = "Default";
			$oFCKeditor = new FCKeditor('mensajeEmail') ;
			$oFCKeditor->BasePath = 'fckeditor/' ;
			$oFCKeditor->ToolbarSet = preg_replace("/[^a-z]/i", "", $tipo_toolbar);
			$oFCKeditor->Value = "";
			$oFCKeditor->Create();              
		?>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="right" valign="top">
			<input type="hidden" name="para" id="para" value="<? echo $para; ?>" />
			<input type="submit" value="Enviar Correos" title="Clic" />
		</td>
	</tr>
</form>
</table>