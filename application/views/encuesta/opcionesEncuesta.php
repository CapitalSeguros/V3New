<div class="panel_botones" id="BtnMenuEncuesta">
    <table class="tablaMenu table" id="PanelBotonesEncuesta" style="position: sticky;top:0;">
        <tbody>
            <tr>
                <td style="border-top: none;">
                    <div class="boton lbboton" onclick="verContenidoEncuesta('divReportes','Reporte de Encuestas')">
                        <img src="<?php echo(base_url().'assets\images\agrega_agentes\encuesta.png')?>" style="width:65%;padding: 3px;">
                        <span>Reporte De Encuestas</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="border-top: none;">
                    <div class="boton lbboton" onclick="verContenidoEncuesta('divAltas','Alta de Encuestas')">
                        <img src="<?php echo(base_url().'assets\images\agrega_agentes\votacion.png')?>" style="width:65%;padding: 3px;">
                        <span>Altas De Encuestas</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="border-top: none;">
                    <div class="boton lbboton" onclick="verContenidoEncuesta('divAsignar','Asignar a Empleado')">
                        <img src="<?php echo(base_url().'assets\images\agrega_agentes\examen.png')?>" style="width:65%;padding: 3px;">
                        <span>Asignar</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="border-top: none;">
                    <div class="boton lbboton" onclick="verContenidoEncuesta('divSinContestar','Encuestas Faltantes')">
                        <img src="<?php echo(base_url().'assets\images\agrega_agentes\encuesta.png')?>" style="width:65%;padding: 3px;">
                        <span>Encuestas Sin Contestar</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="border-top: none;">
                    <div class="boton lbboton" onclick="verContenidoEncuesta('divPorTelefono','Encuestas Por Teléfono')">
                        <img src="<?php echo(base_url().'assets\images\agrega_agentes\encuesta.png')?>" style="width:65%;padding: 3px;">
                        <span>Encuesta Por Teléfono</span>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
