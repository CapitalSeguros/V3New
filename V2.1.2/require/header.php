<table width="980" cellpadding="0" cellspacing="0" border="0" align="center">
	<tr>
    	<td class="systemTex" style="font-size:10px;" align="left">
        	<strong>Usuario: </strong><? echo $_SESSION['WebDreTacticaWeb2']['Usuario']; ?>
            <strong>-</strong><? echo $_SESSION['WebDreTacticaWeb2']['Nombre']; ?>
            [<? echo DreNombreTipoPerfil($_SESSION['WebDreTacticaWeb2']['Tipo']); ?>]
            <? if($_SESSION['WebDreTacticaWeb2']['Ranking'] != ""){?>
            <br>
            <strong>Ranking: </strong><? echo $_SESSION['WebDreTacticaWeb2']['Ranking']; ?>
            <? } ?>
        </td>
        <td>&nbsp;</td>
        <td class="systemTex" style="font-size:12px;" align="right">
        	<a href="includes/logout.php" class="systemTex" title="Salir">
            	<strong>Cerrar Sesi&oacute;n</strong>
                <img src="img/transparente.fw.png" class="system logout" alt="logout" border="0"/>
        	</a>
        </td>
    </tr>
    <tr>
    	<td colspan="3"><br><br></td>
    </tr>
</table>