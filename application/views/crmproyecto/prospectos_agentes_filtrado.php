<?php
 $user=$this->tank_auth->get_usermail();
if(!isset($agentes)){
    $this->load->model('crmproyecto_model');
    $agentes=$this->crmproyecto_model->prospectos_agentes();
}?>
<div class="panel panel-default">
    <div class="panel-body">
    <div style="height: 270px;overflow: scroll;">
       <table class="table table-hover" id='table_id' border="1">
                <thead>
                    <tr style="background-color: #E6E6E6;">
                    <td colspan="3"></td>
                    <td>
                        <select name="status" id="status" onchange="filtroProspectoAgente(this,'status')">
                            <option value="NINGUNO">NINGUNO</option>
                            <option value="NO CONTACTADO">NO CONTACTADO</option>
                            <option value="EN PROCESO">EN PROCESO</option>
                            <option value="CONTACTADO">CONTACTADO</option>
                            <option value="RECLUTADO">RECLUTADO</option>
                            <option value="DESCARTADO">DESCARTADO</option>
                        </select>
                    </td>
                    <td colspan="6"></td>
                    <td>
                        <select name="coordinacion" id="coordinacion" onchange="filtroProspectoAgente(this,'coordinacion')">
                            <option value="NINGUNO">NINGUNO</option>
                            <option value="CBE">CBE</option>
                            <option value="MID">MID</option>
                        </select>
                    </td>
                    <td>
                        <select name="asignado" id="asignado" onchange="filtroProspectoAgente(this,'asignado')" style="width: 150px;">
                            <option value="NINGUNO">NINGUNO</option>
                            <option value="COORDINADOR@CAPCAPITAL.COM.MX">COORDINADOR@CAPCAPITAL.COM.MX</option>
                            <option value="COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX">COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX</option>
                             <option value="EJECUTIVOCOMERCIAL@ASESORESCAPITAL.COM">EJECUTIVOCOMERCIAL@ASESORESCAPITAL.COM</option>
                             <option value="AUXILIARCOMERCIAL@CAPCAPITAL.COM.MX">AUXILIARCOMERCIAL@CAPCAPITAL.COM.MX</option>
                        </select>
                    </td>
                    <td></td>
                    <td colspan="2"></td>
                </tr>
                    <tr>
                        <th><i class="fa fa-cogs"></i></th>
                        <th>Prospecto</th>
                        <th>Medio</th>
                        <th>Status</th>
                        <th>CedulaS/N</th>
                        <th>Correo</th>
                        <th>Telefono</th>
                        <th>Ubicación</th>
                        <th>Dia</th>
                        <th>Mes/Año</th>
                        <th>Coordinación</th>
                        <th>Asignado</th>
                        <th>Comentarios</th>
                        <th style="text-align: center;" colspan="2"><i class="fa fa-cogs"></i>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($agentes as $agente){?>
                <tr style="height: 10px;">
                    <td><input type="checkbox" name="check" onclick="seleccionar_agentes(<?php echo trim($agente->id);?>)"></td>
                    <td><?php echo $agente->prospecto;?></td>
                    <td><?php echo $agente->medio;?></td>
                    <td>
                    <?php if(!empty($agente->status)){?>
                        <div class="badge badge-primary" style="width: 100px;font-size:10px;font-weight: normal;"> <?php echo $agente->status;?></div>
                    <?php }?>
                    </td>
                    <td><?php echo $agente->tiene_cedula;?></td>
                    <td><?php echo $agente->correo;?></td>
                    <td><?php echo $agente->numero_telefono;?></td>
                    <td><?php echo $agente->ubicacion;?></td>
                    <td><?php echo $agente->dia;?></td>
                    <td><?php echo $agente->mes.'/'.$agente->anio;?></td>
                    <td><?php echo $agente->coordinacion;?></td>
                    <td><?php echo $agente->asignado;?></td>
                    <td><?php echo $agente->comentarios;?></td>
                    <td><a href="#" data-toggle="modal" data-target="#editar_comentarios" onclick="editar_prospecto_agente('<?php echo $agente->id?>','<?php echo $agente->comentarios?>','<?php echo $agente->prospecto;?>')"><i class="fa fa-edit fa-2x" style="color: green"></i></a></td>
                    <td>
                    <?php if(($user=="MARKETING@AGENTECAPITAL.COM")||($user=="DIRECTORGENERAL@AGENTECAPITAL.COM")){?>
                        <a href="#" onclick="eliminar_prospecto_agente('<?php echo $agente->id?>')"><i class="fa fa-times-circle fa-2x" style="color: red"></i></a>
                    <?php }?>
                    </td>
                </tr>
                <?php }?>
                </tbody>
            </table>
</div>
        </div>
    </div>
