<table width="950" cellpadding="0" cellspacing="0" border="0">
	<tr>
    	<td colspan="2">&nbsp;</td>
    </tr>			
<form name="formMailMasivo" id="formMailMasivo" method="post" action="includes/enviarCorreo.php?tipoEnvio=correoMasivo">
	<tr>
    	<td>
        	Desde:
        </td>
        <td>
        	<select name="desdeSelect" id="desdeSelect">
            	<option value="">--Seleccione--</option>
            	<option value="CAPACITA <confirmaciones@capacitasegurosyfianzas.com.mx>">CAPACITA</option>
            	<option value="CAPSYS Web <soporte@capsys.com.mx>">CAPSYS</option>
            </select>
        </td>
    </tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
    	<td>
			Para:
		</td>
		<td>
			<?php
				if(	$Nivel != 2 && !isset($para)){	
			?>
        	<input type="button" value="Usuarios" class="buttonGeneral" onclick="java:window.open('mailMasivo.php?para=usuarios','_self');" />
        	<input type="button" value="Clientes" class="buttonGeneral" onclick="java:window.open('mailMasivo.php?para=clientes','_self');" />
         	<? if($Usuario == "0000028964" || $Usuarios == "0000522578" ){ ?>
            <input type="button" value="Masivos" class="buttonGeneral" onclick="java:window.open('mailMasivo.php?para=masivos','_self');" />
            <? } ?>
			<?php
				} else if( !isset($para)) {
			?>
        	<input type="button" value="Clientes" class="buttonGeneral" onclick="java:window.open('mailMasivo.php?para=clientes','_self');" />
            <?php
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