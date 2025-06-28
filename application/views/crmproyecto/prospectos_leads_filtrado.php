<?php
 $user=$this->tank_auth->get_usermail();
if(!isset($leads)){
    $this->load->model('crmproyecto_model');
    $leads=$this->crmproyecto_model->prospectos_leads();
}?>
<div class="panel panel-default">
    <div class="panel-body">
    <div style="height: 270px;overflow: scroll;">
       <table class="table table-hover" id='table_id' border="1">
                <thead>
                    <tr>
                        <th><i class="fa fa-cogs"></i></th>
                        <th>Prospecto</th>
                        <th>Fuente</th>
                        <th>Asignado</th>
                        <th>Status</th>
                        <th>Correo</th>
                        <th>Telefono</th>
                        <th>Fecha Creacion</th>
                        <th>Comentarios</th>
                        <!--
                        <th style="text-align: center;" colspan="2"><i class="fa fa-cogs"></i>
                        -->
                    </tr>
                </thead>
                <tbody>
                <?php $c=0;
                foreach($leads as $lead){?>
                <tr style="height: 10px;">
                    <!--
                    <td><input type="checkbox" name="check" onclick="seleccionar_agentes(<?php echo trim($lead->IDCli);?>)"></td>
                    -->
                    <td style="text-align:center;"><?php echo $c++;?></td>
                    <td><?php echo $lead->Nombre.' '.$lead->ApellidoP;?></td>
                    <td><?php echo $lead->FuenteProspecto;?></td>
                    <td><?php echo $lead->Usuario;?></td>
                    <td>
                    <?php if(!empty($lead->EstadoActual)){?>
                        <div class="badge badge-primary" style="width: 100px;font-size:10px;font-weight: normal;"> <?php echo $lead->EstadoActual;?></div>
                    <?php }?>
                    </td>
                    <td><?php echo $lead->EMail1;?></td>
                    <td><?php echo $lead->Telefono1;?></td>
                    <td><?php echo date('d-m-Y',strtotime($lead->fechaCreacionCA));?></td>
                    <td><?php echo $lead->comentarios;?></td>
                    <!--
                    <td><a href="#" data-toggle="modal" data-target="#editar_comentarios" onclick="editar_prospecto('<?php echo $lead->IDCli?>','<?php echo $lead->comentarios?>','<?php echo $lead->Nombre.' '.$lead->ApellidoP;?>')"><i class="fa fa-edit fa-2x" style="color: green"></i></a></td>
                    <td>
                    <?php if(($user=="MARKETING@AGENTECAPITAL.COM")||($user=="DIRECTORGENERAL@AGENTECAPITAL.COM")){?>
                        <a href="#" onclick="eliminar_prospecto('<?php echo $lead->IDCli?>')"><i class="fa fa-times-circle fa-2x" style="color: red"></i></a>
                    <?php }?>
                    </td>
                    -->
                </tr>
                <?php }?>
                </tbody>
            </table>
</div>
    </div>
</div>
